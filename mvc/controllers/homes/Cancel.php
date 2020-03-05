<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cancel extends MY_Controller {
	
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
		 $this->load->model('mailandsmstemplate_m');
		 $this->load->model('install_m');
		 $this->load->model('airline_m');
		 $this->load->model("reset_m");
		 $this->load->library('session');
         $this->load->helper('form');
         $this->load->library('form_validation');
         $this->load->library('email');		 
	     $language = $this->session->userdata('lang');	  
		 $this->lang->load('bidding', $language);
         $this->load->library('parser'); 
	 }

     function index(){ 
        if(empty($this->input->get('pnr_ref'))){
			redirect(base_url('home/index'));
		}		 
		$this->load->library('user_agent');
		if ($this->agent->is_mobile()){
           $this->data['mobile_view'] ="mb_";
        } else {
		   $this->data['mobile_view'] = "";
		}
        $this->data['bid_received'] =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
		$this->data['excluded_status'] =  $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
		$this->session->set_userdata('ref',$this->input->get('pnr_ref'));		
        $status = $this->bid_m->getOfferStatus($this->input->get('pnr_ref'));
		if(empty($status)){
			redirect(base_url('home/index'));
		}
        if($status->status_no != $this->data['bid_received']){
			$this->data['message'] = $status->status;
			$this->data['pnr_ref'] = $this->input->get('pnr_ref');
			$this->data["subview"] = "home/not-resubmit";
		    $this->load->view('_layout_home', $this->data);
		} else {		
		 $this->data['results'] = $this->bid_m->getPassengers($this->input->get('pnr_ref'),'bid_received');    

        foreach($this->data['results'] as $result ){			
			$result->pax_names = $this->bid_m->getPaxNames($this->input->get('pnr_ref'));
			$tocabins = array();
			$tocabins1 = array();
			$result->to_cabins = explode(',',$result->to_cabins);
			   foreach($result->to_cabins as $value){
                $data = explode('-',$value);
                 $tocabins1[$data[3]][$data[1].'-'.$data[2]] = $data[0];
               }			  
			     // asort($tocabins1);
				  ksort($tocabins1);
				  foreach($tocabins1 as $cabins){
					  foreach($cabins as $key => $value){
					    $tocabins[$key] = $value;
					  }					  
				  } 
              $result->to_cabins = $tocabins;
			   
			$dept = date('d-m-Y H:i:s',$result->dep_date+$result->dept_time);
			$arrival =  date('d-m-Y H:i:s',$result->arrival_date+$result->arrival_time);
			$dteStart = new DateTime($dept); 
			$dteEnd   = new DateTime($arrival); 
			$dteDiff  = $dteStart->diff($dteEnd);
			$result->time_diff = $dteDiff->format('%d days %H hours %i min');
            $this->data['passengers_count'] = count(explode(',',$result->pax_names));
            $result->sliderval = $result->bid_value/$this->data['passengers_count'];
            $this->data['bid_miles'] = $this->data['bid_miles'] + $result->bid_miles; 			
     	}
        $bid_data = $this->bid_m->getBidData($this->data['results'][0]->offer_id);
		$this->data['card_data'] = $this->bid_m->getCardData($this->data['results'][0]->offer_id);
		$this->session->set_userdata('cancel_offer',$this->data['results'][0]->offer_id);
        //print_r($this->data['card_data']); exit;
        $this->data['cabins']  = $this->bid_m->get_cabins($this->data['results'][0]->carrier);
		
        // $this->data['mile_value'] = $this->preference_m->get_preference(array("pref_code" => 'MILES_DOLLAR'))->pref_value;
        // $this->data['mile_proportion'] = $this->preference_m->get_preference(array("pref_code" => 'MIN_CASH_PROPORTION'))->pref_value;
		
          $this->data['mile_value'] = $this->preference_m->get_preference_value_bycode('MILES_DOLLAR','24',$this->data['results'][0]->carrier);	
         $this->data['mile_proportion'] = $this->preference_m->get_preference_value_bycode('MIN_CASH_PROPORTION','24',$this->data['results'][0]->carrier);	
		
		if(!empty($this->input->get('pnr_ref'))){
		  $airline = $this->bid_m->getAirlineLogoByPNR($this->input->get('pnr_ref'));
		  if(!empty($airline->logo)){
		    $this->data['airline_logo'] = base_url('uploads/images/'.$airline->logo);
		  } else {
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');
		  }
          $this->data['mail_header_color'] = $airline->mail_header_color;
		   if(empty($this->data['mail_header_color'])){
			 $this->data['mail_header_color'] = '#333';  
		   }
		   
         $this->data['images'] = $this->airline_m->getImagesByType($airline->airlineID,'gallery');
         $this->data['airline_video_link'] = str_replace('watch?v=','embed/',$airline->video_links);		 
		} else {
			$this->data['mail_header_color'] = '#333'; 
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');			
		}
		
		$this->data["subview"] = "home/resubmit";
		$this->load->view('_layout_home', $this->data);	
	  }		
	}

    
    function page(){
		if(empty($this->session->userdata('ref')) || empty($this->session->userdata('cancel_offer'))){
			redirect(base_url('home/index'));
		}
		$bid_cancel = $this->rafeed_m->getDefIdByTypeAndAlias('bid_cancel','20');
		$bid_received = $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
		$bid_unselect_cabin = $this->rafeed_m->getDefIdByTypeAndAlias('bid_unselect_cabin','20');
		
		$ref['offer_status'] = $bid_cancel;
		$ref["modify_date"] = time();
		$this->offer_reference_m->update_offer_ref($ref,$this->session->userdata('cancel_offer'));
		 $extention_data1 = $this->offer_issue_m->getPassengerDataByStatus($this->session->userdata('cancel_offer'),null,'bid_received');
         $extention_data2 = $this->offer_issue_m->getPassengerDataByStatus($this->session->userdata('cancel_offer'),null,'bid_unselect_cabin');
         $extention_data->p_list = $extention_data1->p_list.','.$extention_data2->p_list;            
		 $p_list = explode(',',$extention_data->p_list);		   
         $this->offer_eligibility_m->update_dtpfext(array("booking_status" => $bid_cancel,"modify_date"=>time()),$p_list);
		 
		 //tracking
		 $tracker = array();				 
		 $tracker['comment'] = 'Bid Cancelled By Customer';
		 $tracker["create_date"] = time();
         $tracker["modify_date"] = time(); 				  
         $p_list1 = explode(',',$extention_data1->p_list); 			  
		 if(!empty($extention_data1->p_list)){				                                         
              foreach($p_list1 as $id) {
                  $tracker['booking_status_from'] = $bid_received;
		          $tracker['booking_status_to'] = $bid_cancel;
			      $tracker['dtpfext_id'] = $id;
                  $this->offer_issue_m->insert_dtpf_tracker($tracker);
		      }
		  }
          $p_list2 = explode(',',$extention_data2->p_list);                 
		  if(!empty($extention_data2->p_list)){
             foreach($p_list2 as $id) {
               $tracker['booking_status_from'] = $bid_unselect_cabin;
		       $tracker['booking_status_to'] = $bid_cancel;
			   $tracker['dtpfext_id'] = $id;
               $this->offer_issue_m->insert_dtpf_tracker($tracker);
			 }
		  }
		  
		   //send bid cancel mail
			   $offer_data = $this->bid_m->get_offer_data($this->session->userdata('cancel_offer'));
			   $maildata = (array)$offer_data;
			   $maildata['dep_date'] = date('d/m/Y',$maildata['dep_date']);
			   $maildata['dep_time'] = gmdate('H:i A',$maildata['dept_time']);			  
			   $maildata['base_url'] = base_url();			    		
			   $maildata['tomail'] = explode(',',$maildata['email_list'])[0]; 
               $maildata['first_name'] = explode(',',$maildata['pax_names'])[0];
               //$maildata['tomail'] = 'swekenit@gmail.com';
			   $maildata['template'] = 'bid_cancel';
			   $maildata['subject'] = 'Your bid has been Successfully Cancelled';
				$this->sendMail($maildata);
				
		  $airline = $this->bid_m->getAirlineLogoByPNR($this->session->userdata('ref'));
		  if(!empty($airline->logo)){
		    $this->data['airline_logo'] = base_url('uploads/images/'.$airline->logo);
		  } else {
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');
		  }
		  
		  $this->data['mail_header_color'] = $airline->mail_header_color;
		   if(empty($this->data['mail_header_color'])){
			 $this->data['mail_header_color'] = '#333';  
		   }
      		
		$this->data['pnr_ref'] = $this->session->userdata('ref');
		$this->data['subview'] = 'home/cancel-page';
		$this->load->view('_layout_home', $this->data);	
	}
	
	
}