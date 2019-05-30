<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	
	function __construct () {
		parent::__construct();		
		$this->lang->load('home', $language);
	}
	
	public function index() {		
		$this->data["subview"] = "home/index";
		$this->load->view('_layout_home', $this->data);
	}	
		
}
