<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resubmit extends MY_Controller {
	
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
       
        $this->data['bid_received'] =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
		$this->data['excluded_status'] =  $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
				
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
         if(empty($this->data['results'])){ 
			redirect(base_url('home/index'));
		}
        foreach($this->data['results'] as $result ){			
			$result->pax_names = $this->bid_m->getPaxNames($this->input->get('pnr_ref'));
			$tocabins = array();
			$result->to_cabins = explode(',',$result->to_cabins);
			  foreach($result->to_cabins as $value){
                $data = explode('-',$value);
                $tocabins[$data[1].'-'.$data[2]] = $data[0];
               // unset($result->to_cabins[$key]);
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
       // print_r($this->data['results']); exit;
        $this->data['cabins']  = $this->bid_m->get_cabins($this->data['results'][0]->carrier);
        $this->data['mile_value'] = $this->preference_m->get_preference(array("pref_code" => 'MILES_DOLLAR'))->pref_value;
         $this->data['mile_proportion'] = $this->preference_m->get_preference(array("pref_code" => 'MIN_CASH_PROPORTION'))->pref_value;		
		
		if(!empty($this->input->get('pnr_ref'))){
		  $airline = $this->bid_m->getAirlineLogoByPNR($this->input->get('pnr_ref'));
		  if(!empty($airline->logo)){
		    $this->data['airline_logo'] = base_url('uploads/images/'.$airline->logo);
		  } else {
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');
		  }

         $this->data['images'] = $this->airline_m->getImagesByType($airline->airlineID,'gallery');
         $this->data['airline_video_link'] = str_replace('watch?v=','embed/',$airline->video_links);		 
		} else {
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');			
		}
		
		$this->data["subview"] = "home/resubmit";
		$this->load->view('_layout_home', $this->data);	
	  }		
	}

    
    
}