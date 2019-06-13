<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidding extends MY_Controller {
	
	function __construct () {
		parent::__construct();						
	     $this->load->model("login_m");
		 $this->load->model("airline_cabin_m");
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
        $this->data['cabins']  = $this->airline_cabin_m->getAirlineCabins();		
		//$this->data['passengers'] = explode(';',$result->pax_names);
      // print_r($this->data['result']); exit;	
	   
		$this->data["subview"] = "home/bidview";
		//$this->data["subview"] = "example";
		$this->load->view('_layout_home', $this->data);
	}

}