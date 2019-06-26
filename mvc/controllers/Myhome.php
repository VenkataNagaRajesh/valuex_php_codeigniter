<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myhome extends MY_Controller {

   function __construct () { 
     parent::__construct();
	  $this->load->library('recaptcha');
	  $this->load->model("login_m");
	  $language = $this->session->userdata('lang');
	  $this->lang->load('login', $language);
   }
   
   protected function rules() {
		$rules = array(
			array(
				'field' => 'pnr', 
				'label' => $this->lang->line("login_pnr"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'code', 
				'label' => $this->lang->line("login_code"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			)
		);
		return $rules;
	}
   
   public function recaptcha() { 
        if($this->request->post){
			//$recaptcha = $this->input->post('g-recaptcha-response');
			if (!empty($recaptcha)) {
				//$response = $this->recaptcha->verifyResponse($recaptcha);
				//if (isset($response['success']) and $response['success'] === true) {	
                    $code = $this->request->post('code');
                    $pnr = $this->request->post('pnr');					
					echo "You got it!";
					echo "Code : ".$code." PNR : ".$pnr;
				/* } else {
					echo "reCaptcha invalid";
				} */
			}
        } else {
			$data = array(
				'widget' => $this->recaptcha->getWidget(),
				'script' => $this->recaptcha->getScriptTag(),
			);
		}
        $this->load->view('recaptcha', $data);
    }

}