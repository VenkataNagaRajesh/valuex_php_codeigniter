<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends Admin_Controller {

	function __construct() {
		parent::__construct();		
		$language = $this->session->userdata('lang');
		$this->lang->load('report', $language);	
	}

	public function index() {

        $this->data["subview"] = "report/index";
		$this->load->view('_layout_main', $this->data); 
    }
}