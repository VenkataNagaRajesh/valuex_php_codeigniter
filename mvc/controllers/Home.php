<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	
	function __construct () {
		parent::__construct();	
		 $this->load->library('recaptcha');				
	     $this->load->model("login_m");
		 $this->load->library('session');
		 $this->load->helper('form');
         $this->load->library('form_validation');			 
	     $language = $this->session->userdata('lang');	  
		$this->lang->load('home', $language);
	}
	
	 protected function rules() {
		$rules = array(
			array(
				'field' => 'pnr', 
				'label' => $this->lang->line("home_pnr"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'code', 
				'label' => $this->lang->line("home_code"), 
				'rules' => 'trim|required|xss_clean|max_length[50]|callback_validate_code'
			),
			array(
				'field' => 'g-recaptcha-response', 
				'label' => 'reCaptcha', 
				'rules' => 'callback_validate_recaptcha'
			)
		);
		return $rules;
	}
	
	public function validate_recaptcha(){		
		$recaptcha = $this->input->post('g-recaptcha-response');
		if (!empty($recaptcha)) {
			$response = $this->recaptcha->verifyResponse($recaptcha);
			if (isset($response['success']) and $response['success'] === true) {	
               return TRUE;  
			 } else {
				$this->form_validation->set_message("validate_recaptcha", $response['error-codes'][0]); 
                return FALSE;
			 } 
		} else {
            $this->form_validation->set_message("validate_recaptcha", "%s is required" );
            return FALSE;
        }

     }
	
	public function validate_code($code){
	   if(empty($code)){
		  $this->form_validation->set_message("validate_code", "%s is required");
		  return FALSE;
	   }else{
		  $this->load->model('offer_eligibility_m');
          $coupon_code = $this->offer_eligibility_m->hash($code);
		  $count = $this->login_m->pnr_code_validate($this->input->post('pnr'),$coupon_code);
		  if($count > 0){
			return TRUE; 
		  } else {
			$this->form_validation->set_message("validate_code", "%s is Invalid"); 
            return FALSE;			
		  }		 
	   }
	}
	
	public function index() {
        $this->data = array(
				'widget' => $this->recaptcha->getWidget(),
				'script' => $this->recaptcha->getScriptTag(),
		);
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "home/index";
		        $this->load->view('_layout_home', $this->data);		
			} else {				
				echo "success"; exit;
				//$this->usertype_m->insert_usertype($array);
				//$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				//redirect(base_url("usertype/index"));
			}
		} else {			
		   $this->data["subview"] = "home/index";
		   $this->load->view('_layout_home', $this->data);
		}     		
	}	
	public function bidview() {		
		$this->data["subview"] = "home/bidview";
		$this->load->view('_layout_home', $this->data);
	}	
	public function paysuccess() {		
		$this->data["subview"] = "home/paysuccess";
		$this->load->view('_layout_home', $this->data);
	}
	public function temp1() {		
		$this->data["subview"] = "home/temp1";
		$this->load->view('_layout_home', $this->data);
	}
	public function temp2() {		
		$this->data["subview"] = "home/temp2";
		$this->load->view('_layout_home', $this->data);
	}
		
}
