<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validation extends MY_Controller {

     public function validate(){
	   $json = array();
	   $json['code'] = 'abcd';
	   if (isset($_SERVER)) {		
		    header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			header('Access-Control-Max-Age: 1000');
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json)); 
   }

}