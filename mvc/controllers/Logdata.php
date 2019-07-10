<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logdata extends Admin_Controller {

	private $logViewer;

	public function __construct() {
		parent::__construct(); 
		$this->logViewer = new \CILogViewer\CILogViewer();
		//...
	}

	public function index() {
		echo $this->logViewer->showLogs();
		return;
		//$this->data = $this->logViewer->showLogs();
		
		$this->data["subview"] = "cilogviewer/logs"; //print_r($this->data); exit;
		$this->load->view('_layout_main', $this->data);
	}
}