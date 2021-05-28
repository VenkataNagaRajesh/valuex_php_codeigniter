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
	}  else  {
		$pnr_ref = $this->input->get('pnr_ref');
		redirect(base_url('homes/bidding/?pnr_ref='. $pnr_ref));
	}
	return;
     }

    
    function page(){
		
		if(empty($this->input->get('pnr_ref'))){
			redirect(base_url('home/index'));
		}		 
		if(empty($this->input->get('offer_id'))){
			redirect(base_url('home/index'));
		}		 
		if(empty($this->input->get('type'))){
			redirect(base_url('home/index'));
		}		 

		$product_id = $this->input->get('type');
		$pnr_ref = $this->input->get('pnr_ref');
		$offer_id = $this->input->get('offer_id');

		$bid_cancel = $this->rafeed_m->getDefIdByTypeAndAlias('bid_cancel','20');
		$bid_received = $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
		$bid_unselect_cabin = $this->rafeed_m->getDefIdByTypeAndAlias('bid_unselect_cabin','20');
		
		$ref['offer_status'] = $bid_cancel;
		$ref['product_id'] = $product_id;
		$ref["modify_date"] = time();
		$this->offer_reference_m->update_offer_ref($ref,$offer_id);
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
			   $offer_data = $this->bid_m->get_offer_data($offer_id);
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
      		
		$this->data['pnr_ref'] = $pnr_ref; 
		$this->data['offer_id'] = $offer_id; 
		$this->data['subview'] = 'home/cancel-page';
		$this->load->view('_layout_home', $this->data);	
	}
	
	
}
