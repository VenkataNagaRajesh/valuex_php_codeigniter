<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidding extends MY_Controller {
	
	function __construct () {
		parent::__construct();						
	     $this->load->model("login_m");
		 $this->load->model("airline_cabin_m");
		 $this->load->model("fclr_m");
		 $this->load->model("preference_m");
		 $this->load->library('session');				 
	     $language = $this->session->userdata('lang');	  
		$this->lang->load('home', $language);
	}
  
    public function index() {
        $this->data['result'] = $this->login_m->getPassengers();
		$this->data['result']->to_cabins = explode(',',$this->data['result']->to_cabins);
		foreach($this->data['result']->to_cabins as $key => $value){
		  $data = explode('-',$value);
		  $this->data['result']->to_cabins[$data[1]] = $data[0];
		  unset($this->data['result']->to_cabins[$key]);
		}
        
		$dept = date('d-m-Y H:i:s',$this->data['result']->dep_date+$this->data['result']->dept_time);
		$arrival =  date('d-m-Y H:i:s',$this->data['result']->arrival_date+$this->data['result']->arrival_time);
		$dteStart = new DateTime($dept); 
		$dteEnd   = new DateTime($arrival); 
		$dteDiff  = $dteStart->diff($dteEnd);
		$this->data['result']->time_diff = $dteDiff->format('%d days %H hours %i min');          		 
       // echo $interval->format('%Y years %m months %d days %H hours %i minutes %s seconds');	 exit; 
        $this->data['cabins']  = $this->airline_cabin_m->getAirlineCabins();
        $this->data['mile_value'] = $this->preference_m->get_preference(array("pref_code" => 'MILES_DOLLAR'))->pref_value;
         $this->data['mile_proportion'] = $this->preference_m->get_preference(array("pref_code" => 'MIN_CASH_PROPORTION'))->pref_value;		
		
        // print_r($this->data['result']); exit;	
	   
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

}