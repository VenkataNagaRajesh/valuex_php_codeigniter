<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myhome extends MY_Controller {

   function __construct () { 
     parent::__construct();
   }
   
    public function recaptcha()
    {
        // load from spark tool
       // $this->load->spark('recaptcha-library/1.0.1');
        // load from CI library
         $this->load->library('recaptcha');

        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) and $response['success'] === true) {
                echo "You got it!";
            }
        }

        $data = array(
            'widget' => $this->recaptcha->getWidget(),
            'script' => $this->recaptcha->getScriptTag(),
        );
        $this->load->view('recaptcha', $data);
    }

}