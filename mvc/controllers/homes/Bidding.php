<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidding extends MY_Controller {
	
	function __construct () {
		parent::__construct();						
	     $this->load->model("bid_m");
		 $this->load->model("airline_cabin_m");
		 $this->load->model("fclr_m");
		 $this->load->model("preference_m");
		 $this->load->model("offer_eligibility_m");
		 $this->load->model("offer_issue_m");
		 $this->load->model("offer_reference_m");
		 $this->load->model("rafeed_m");
		 $this->load->model("reset_m");
		 $this->load->library('session');
         $this->load->helper('form');
         $this->load->library('form_validation');
         $this->load->library('email');		 
	     $language = $this->session->userdata('lang');	  
		$this->lang->load('bidding', $language);	
                      /*   $offer_data = $this->bid_m->get_offer_data(11);
                           $data = (array)$offer_data;
                           print_r( explode(',',$data['email_list'])[0]); exit;
                      /*     $data['dep_date'] = date('d/m/Y',$data['dep_date']);
                           $data['dep_time'] = gmdate('H:i A',$data['dept_time']);
                           $data['cash'] = "lakshmi.amujuru@sweken.com";
                            $this->load->library('parser');
                          $message = $this->parser->parse("home/bidsuccess-temp", $data);
                          $message =html_entity_decode($message);
                          $siteinfos = $this->reset_m->get_site();
                          // $tomail = explode(',',$data[0]['email_list'])[0];
                                $subject = "Your bid has been Successfully Submitted";
                                $this->email->set_mailtype("html");
                                $this->email->from($siteinfos->email,$siteinfos->sname);
                                $this->email->to("lakshmi.amujuru@sweken.com");
                                $this->email->subject("bid Submitted");
                                $this->email->message($message);
                            $this->email->send();  
                  exit; */
	}
  
    public function index() {  
      // $this->session->set_userdata('pnr_ref','F90414');
     //  $this->session->set_userdata('validation_check',1);	   
		if($this->session->userdata('validation_check') != 1 || empty($this->session->userdata('pnr_ref'))){
			redirect(base_url('home/index'));
			$this->session->unset_userdata('pnr_ref');
		}
		
		$this->data['results'] = $this->bid_m->getPassengers($this->session->userdata('pnr_ref'));
		//$this->data['tomail'] = explode(',',$this->data['results'][0]->email_list)[0]; 
		if(empty($this->data['results'])){
			redirect(base_url('home/index'));
		}
                
		foreach($this->data['results'] as $result ){
			$result->to_cabins = explode(',',$result->to_cabins);
			foreach($result->to_cabins as $key => $value){
			  $data = explode('-',$value);
			  $result->to_cabins[$data[1]] = $data[0];
			  unset($result->to_cabins[$key]);
			}
			
			$dept = date('d-m-Y H:i:s',$result->dep_date+$result->dept_time);
			$arrival =  date('d-m-Y H:i:s',$result->arrival_date+$result->arrival_time);
			$dteStart = new DateTime($dept); 
			$dteEnd   = new DateTime($arrival); 
			$dteDiff  = $dteStart->diff($dteEnd);
			$result->time_diff = $dteDiff->format('%d days %H hours %i min'); 
     	}	
       // echo $interval->format('%Y years %m months %d days %H hours %i minutes %s seconds');	 exit; 
        $this->data['cabins']  = $this->airline_cabin_m->getAirlineCabins();
        $this->data['mile_value'] = $this->preference_m->get_preference(array("pref_code" => 'MILES_DOLLAR'))->pref_value;
         $this->data['mile_proportion'] = $this->preference_m->get_preference(array("pref_code" => 'MIN_CASH_PROPORTION'))->pref_value;		
		
       // print_r($this->data['results']); exit;	
	   
		$this->data["subview"] = "home/bidview";
		$this->load->view('_layout_home', $this->data);
	}
	
	public function getFclrValues(){
		if($this->input->post('fclr_id')){
			$json = $this->fclr_m->get_single_fclr(array('fclr_id'=>$this->input->post('fclr_id')));
		} else{
			$json = "no id";
		}
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}
	
	public function saveBidData(){
		if($this->input->post('offer_id')){ 
			$data['offer_id'] = $this->input->post('offer_id');
			$data['cash'] = $this->input->post("cash");
			$data['bid_value'] = $this->input->post("bid_value");
			$data['miles'] = $this->input->post("miles");
			$data['fclr_id'] = $this->input->post("fclr_id");
			$data['upgrade_type'] = $this->input->post("upgrade_type");
			$data['flight_number'] = $this->input->post("flight_number");	
			$data['bid_submit_date'] = time();
			$data['active'] = 1;
            $id = $this->bid_m->save_bid_data($data);			
          if($id){
			  $select_passengers_data = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'sent_offer_mail',$this->input->post("fclr_id"),1);
			  $unselect_passengers_data = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'sent_offer_mail',$this->input->post("fclr_id"));
			  
			  $select_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_complete','20');
			  $unselect_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_unselect_cabin','20');
			   $array['booking_status'] = $select_status;
               $array["modify_date"] = time(); 
			   
			   $select_p_list = explode(',',$select_passengers_data->p_list);
               $unselect_p_list = explode(',',$unselect_passengers_data->p_list);
			   
  $this->mydebug->debug($select_passengers_data->p_list);
			   $this->mydebug->debug($unselect_passengers_data->p_list);
			   
             $this->offer_eligibility_m->update_dtpfext(array("booking_status" => $select_status,"modify_date"=>time()),$select_p_list);
		    $this->offer_eligibility_m->update_dtpfext(array("booking_status" => $unselect_status,"modify_date"=>time()),$unselect_p_list);
			   
			   $ref['offer_status'] = $select_status;
			   $ref["modify_date"] = time();
			   $this->offer_reference_m->update_offer_ref($ref,$this->input->post('offer_id'));
			   //send bid success mail
			   $offer_data = $this->bid_m->get_offer_data($this->input->post("offer_id"));
			   $maildata = (array)$offer_data;
			   $maildata['dep_date'] = date('d/m/Y',$maildata['dep_date']);
			   $maildata['dep_time'] = gmdate('H:i A',$maildata['dept_time']);
			   $maildata['cash'] = $this->input->post("cash");
			    $this->load->library('parser');        
			  $message = $this->parser->parse("home/bidsuccess-temp", $maildata);
			  $message =html_entity_decode($message);
			  $siteinfos = $this->reset_m->get_site();
			   $tomail = explode(',',$maildata['email_list'])[0];
                            $this->mydebug->debug($maildata);
                            $this->mydebug->debug("Bid Submition ToMails ID : ".$tomail);
				$subject = "Your bid has been Successfully Submitted";				
                                     //  $tomail = 'lakshmi.amujuru@sweken.com';
				$this->email->set_mailtype("html");
				$this->email->from($siteinfos->email,$siteinfos->sname);
				$this->email->to($tomail);
				$this->email->subject($subject);
				$this->email->message($message);
			   $status =  $this->email->send();
                         $this->mydebug->debug("mailstatus : ".$status);
				
			  $json['status'] = "success";
			  $this->session->unset_userdata('validation_check');
			  $this->session->unset_userdata('pnr_ref');
    	  }			
		}else{
			$json['status'] = "send offer_id";
		}
		
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}
	
	protected function rules() {
		$rules = array(
			array(
				'field' => 'card_number', 
				'label' => $this->lang->line("bid_card_number"), 
				'rules' => 'trim|required|max_length[16]|min_length[16]|numeric|xss_clean'
			),			
			array(
				'field' => 'year_expiry', 
				'label' => "Year", 
				'rules' => 'trim|required|max_length[02]|min_length[02]|numeric|xss_clean|callback_valYear'
			),
			array(
				'field' => 'month_expiry', 
				'label' => "Month",				
				'rules' => 'trim|required|max_length[02]|min_length[02]|numeric|xss_clean|callback_valMonth'
			),
			array(
				'field' => 'cvv', 
				'label' => $this->lang->line("bid_cvv"), 
				'rules' => 'trim|required|max_length[03]|min_length[02]|numeric|xss_clean'
			)
		);
		return $rules;
	}
	
	public function valMonth(){
		$cur_month = date('m');
		$cur_year = date('y');
		if(empty($this->input->post('month_expiry'))){
			$this->form_validation->set_message("valMonth", "%s is required");
			return FALSE;
		} else {
			if($this->input->post('month_expiry') < $cur_month && $this->input->post('year_expiry') <= $cur_year){
				$this->form_validation->set_message("valMonth", "%s is Expired");
				return FALSE;
			} else {
				return TRUE;
			} 		
		}
	}
	
	public function valYear(){
		$cur_month = date('m');
		$cur_year = date('y');
		if(empty($this->input->post('year_expiry'))){
			$this->form_validation->set_message("valYear", "%s is required");
			return FALSE;
		} else {
			if($this->input->post('year_expiry') >= $cur_year){
				return TRUE;
			}else {
				$this->form_validation->set_message("valYear", "%s is Expired");
				return FALSE;
			}
		}
	}
	
	public function saveCardData(){
		if($this->input->post('offer_id')){
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$json['status'] = validation_errors();		
			} else {
			$data['offer_id'] = $this->input->post('offer_id');
			$data['card_number'] = $this->input->post("card_number");
			$data['month_expiry'] = $this->input->post("month_expiry");
			$data['year_expiry'] = $this->input->post("year_expiry");
			$data['cvv'] = $this->input->post("cvv");
            $data['date_added'] = time();			
            $id = $this->bid_m->save_card_data($data);
			if($id){
			  $json['status'] = "success";
		    }
		  }			
		}else{
			$json['status'] = "send offer_id";
		}		
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}
	
	

}
