<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pref_setting extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("preference_m");
		$this->load->model("airports_m");		
		$language = $this->session->userdata('lang');
		$this->lang->load('preference', $language);	
	}
	
	function vallist($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("vallist", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}

	public function index() {	
	    $this->data['headerassets'] = array(
           'css' => array(
                   'assets/select2/css/select2.css',
                   'assets/select2/css/select2-bootstrap.css',
                   'assets/fselect/fSelect.css'
           ),
           'js' => array(
                   'assets/select2/select2.js',
                   'assets/fselect/fSelect.js',
           )
        );
        $this->data['preferences'] = $this->preference_m->get_preference();	
		//print_r( $this->data['preferences']); exit;
		if($_POST){
           foreach($_POST as $key => $value){			
		     $info = explode('-',$key);
             $array['pref_value'] = $value;
			 $array['modify_userID'] = $this->session->userdata('loginuserID');
			 $array['modify_date'] = time();
			 $this->preference_m->update_preference($array,$info[1]);
		   }
		  $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		  redirect(base_url("pref_setting"));			
		} else {			
		  $this->data["subview"] = "preference/setting";
		  $this->load->view('_layout_main', $this->data);		
		}
	}
}