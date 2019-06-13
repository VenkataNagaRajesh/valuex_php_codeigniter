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
        $this->data['cabins']  = $this->airline_cabin_m->getAirlineCabins();		
		//$this->data['passengers'] = explode(';',$result->pax_names);
       //print_r($this->data['result']); exit;	
	   
		$this->data["subview"] = "home/bidview";
		$this->load->view('_layout_home', $this->data);
	}

}