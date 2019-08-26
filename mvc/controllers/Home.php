<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	
	function __construct () {
		parent::__construct();	
		 $this->load->library('recaptcha');				
	     $this->load->model("bid_m");
		 $this->load->model("paxfeed_m");
		 $this->load->model("offer_reference_m");
         $this->load->model("reset_m");	$this->load->library('email');	 
		 $this->load->library('session');
		 $this->load->helper('form');
         $this->load->library('form_validation');	        		 
	     $language = $this->session->userdata('lang');	  
		$this->lang->load('home', $language);
		
	}
	
	protected function rules() {
		$rules = array(
			array(
				'field' => 'pnr', 
				'label' => $this->lang->line("home_pnr"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			)
			/* array(
				'field' => 'code', 
				'label' => $this->lang->line("home_code"), 
				'rules' => 'trim|required|xss_clean|max_length[50]|callback_validate_code'
			),
			array(
				'field' => 'g-recaptcha-response', 
				'label' => 'reCaptcha', 
				'rules' => 'callback_validate_recaptcha'
			) */
		);
		return $rules;
	}
	
	public function validate_recaptcha(){ 
		$recaptcha = $this->input->post('g-recaptcha-response');
		if (!empty($recaptcha)) {
			$response = $this->recaptcha->verifyResponse($recaptcha);
			if (isset($response['success']) and $response['success'] === true) {	
               return TRUE;  
			 } else {
				$this->form_validation->set_message("validate_recaptcha", $response['error-codes'][0]); 
                return FALSE;
			 } 
		} else {
            $this->form_validation->set_message("validate_recaptcha", "%s is required" );
            return FALSE;
        }

     }
	
	public function validate_code($code){ 
	   if(empty($code)){
		  $this->form_validation->set_message("validate_code", "%s is required");
		  return FALSE;
	   }else{
		  $this->load->model('offer_eligibility_m');
          $coupon_code = $this->offer_eligibility_m->hash($code);
		 // $status = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
		  $count = $this->bid_m->pnr_code_validate($this->input->post('pnr'),$coupon_code);
		  if($count > 0){
			return TRUE; 
		  } else {
			$this->form_validation->set_message("validate_code", "%s is Invalid"); 
            return FALSE;			
		  }		 
	   }
	}
	
	
	
	public function index() {
		//$_GET['pnr_ref'] = 'US0401';
        $this->data = array(
				'widget' => $this->recaptcha->getWidget(),
				'script' => $this->recaptcha->getScriptTag(),
		);
		if(!empty($_GET['pnr_ref'])){
		  $airline = $this->bid_m->getAirlineLogoByPNR($_GET['pnr_ref']);
		  if(!empty($airline->logo)){
		    $this->data['airline_logo'] = base_url('uploads/images/'.$airline->logo);
		  } else {
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');
		  }
		  if(!empty($airline->video_links)){
		    $this->data['airline_video_link'] = str_replace('watch?v=','embed/',$airline->video_links);
		  } else {
		    $this->data['airline_video_link'] = 'https://www.youtube.com/embed/_O2_nTt1N6w';
		  }		 
		} else {
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');
			$this->data['airline_video_link'] = 'https://www.youtube.com/embed/_O2_nTt1N6w';
		}
		$this->data['pnr_ref'] = $_GET['pnr_ref'];
		
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "home/index";
		        $this->load->view('_layout_home', $this->data);		
			} else {				
				$this->data['error'] = $this->allowValidation($this->input->post('pnr'));
                if(empty($this->data['error'])){
					$this->session->set_userdata('validation_check', 1);
					$this->session->set_userdata('pnr_ref',$this->input->post('pnr'));
					//$offer = $this->offer_reference_m->get_single_offer_ref(array('pnr_ref'=>$this->input->post('pnr')));
				   redirect(base_url("homes/bidding"));
				} else {
				   $this->data["subview"] = "home/index";
		           $this->load->view('_layout_home', $this->data);
				}				
			}			
		} else {			
		   $this->data["subview"] = "home/index";
		   $this->load->view('_layout_home', $this->data);
		}     		
	}
	
	public function bidsuccess() {
        $offer_id = htmlentities(escapeString($this->uri->segment(3)));	
        $this->data['offer_data'] = $this->bid_m->get_offer_data($offer_id);
		
        // print_r($this->data['offer_data']); exit;		
		$this->data["subview"] = "home/bidsuccess-temp";
		$this->load->view('_layout_home', $this->data);
	}	
	
	public function upgradeoffer() {		
		$this->data["subview"] = "home/upgradeoffertmp";
		$this->load->view('_layout_home', $this->data);
	}		
	public function paysuccess() {
        $offer_id = htmlentities(escapeString($this->uri->segment(3)));	
        $this->data['offer_data'] = $this->offer_reference_m->get_single_offer_ref(array("offer_id" => $offer_id));		
		$this->data["subview"] = "home/paysuccess";
		$this->load->view('_layout_home', $this->data);
	}
	public function temp1() {
        $dtpf_id = htmlentities(escapeString($this->uri->segment(3)));	
        $this->data['pax_data'] = $this->paxfeed_m->get_single_paxfeed(array('dtpf_id'=>$dtpf_id));		
		$this->data["subview"] = "home/temp-1";
		$this->load->view('_layout_home', $this->data);
	}
	public function temp2() {
        $dtpf_id = htmlentities(escapeString($this->uri->segment(3)));	
        $this->data['pax_data'] = $this->paxfeed_m->get_single_paxfeed(array('dtpf_id'=>$dtpf_id));		
		$this->data["subview"] = "home/temp2";
		$this->load->view('_layout_home', $this->data);
	}
	public function temp3() {
        $dtpf_id = htmlentities(escapeString($this->uri->segment(3)));	
        $this->data['pax_data'] = $this->paxfeed_m->get_single_paxfeed(array('dtpf_id'=>$dtpf_id));		
		$this->data["subview"] = "home/temp-3";
		$this->load->view('_layout_home', $this->data);
	}
	public function mailerror() {		
		$this->data["subview"] = "home/mailerror";
		$this->load->view('_layout_home', $this->data);
	}
	public function feedback() {		
		$this->data["subview"] = "home/feedback";
		$this->load->view('_layout_home', $this->data);
	}	
	
	public function sendMail(){
		$dtpf_id = 60;
		$this->data['pax_data'] = $this->paxfeed_m->get_single_paxfeed(array('dtpf_id'=>$dtpf_id));	
		$message =  $this->load->view('home/temp1',$this->data);
		$this->data['siteinfos'] = $this->reset_m->get_site();
		$this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);		
		$this->email->to('lakshmi.amujuru@sweken.com');
		$this->email->subject("Upgrade Cabin Offer");
		$this->email->message($message);
		$this->email->send();
	}
		
}
