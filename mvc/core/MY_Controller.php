<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property document_m $document_m
 * @property email_m $email_m
 * @property error_m $error_m
 */
class MY_Controller extends CI_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/
	public $data = array();

	public function __construct() {
		parent::__construct();
		$this->load->config('iniconfig');
		$this->data['errors'] = array();

        if(!$this->config->config_install()) {
            redirect(site_url('install'));
        }
		$this->load->model('rafeed_m');
		$this->load->model('preference_m');
		$this->load->model('mailandsmstemplate_m');
		$this->load->model('bid_m');
		$this->load->model('airline_m');
		$this->load->library('parser');
		 $this->load->library('email');
		 $this->load->library('session');
		 $this->load->model('reset_m');		
		 if($this->session->userdata('roleID') == 5 && $this->session->userdata('show_performance_detail') == 1){
			$this->output->enable_profiler(TRUE);
		 }
	}
	
	public function allowValidation($pnr_ref){	
return;
		$status = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
		//$bid_confirmation = $this->preference_m->get_preference(array("pref_code" => 'BID_CONFIRMATION'))->pref_value;
		//$bid_expire = $this->preference_m->get_preference(array("pref_code" => 'BID_EXPIRE'))->pref_value;
					
		$offer_data = $this->offer_reference_m->getOfferDataByRef($pnr_ref);
		
		 $bid_confirmation = $this->preference_m->get_preference_value_bycode('BID_CONFIRMATION','24',$offer_data->carrier_code);	
         $bid_expire = $this->preference_m->get_preference_value_bycode('BID_EXPIRE','24',$offer_data->carrier_code);		
		
		if(empty($offer_data->offer_status)){
			return "Invalid PNR Reference";
		} else {
			if($status == $offer_data->offer_status){
				$added_timestamp = strtotime('+'.$bid_expire+$bid_confirmation.' day', time());
				if($added_timestamp > $offer_data->dep_date){
					$error ="Offer Expired";
				} else {
					$error = '';
				}  
			} else {
				$error = "This Offer Status Not matched";
			}
			//$error = '';
			return $error;
	    }
	}
	
	public function sendMail($data){
		 $this->mydebug->debug($data);
		 $template = 'bid_cancel';
		 
		  $this->load->model('airline_m');
		 $template_images = $this->airline_m->getImagesByType($data['carrier']);
		   foreach($template_images as $img){
			   $data[$img->type] = base_url('uploads/images/'.$img->image);
		   }
		   $airline_info = $this->bid_m->getAirlineLogoByPNR($data['pnr_ref']);
		   $data['logo'] = $airline_info->logo;
		   if(!empty($data['logo'])){
			 $data['logo'] = base_url('uploads/images/'.$data['logo']);  
		   }else{
			 $data['logo'] = base_url('assets/home/images/emir.png');  
		   }

          $data['mail_header_color'] = $airline_info->mail_header_color;
		   if(empty($data['mail_header_color'])){
			 $data['mail_header_color'] = '#333';  
		   }
		   
	   $tpl = $this->mailandsmstemplate_m->getDefaultMailTemplateByCat($data['template'],$data['carrier'])->template;
	   $message = $this->parser->parse_string($tpl, $data,TRUE);
#echo $message;exit;
	   // $this->mydebug->debug($message);
	  $message =html_entity_decode($message);
	  $siteinfos = $this->reset_m->get_site();  	     
		 $config['protocol']='smtp';
		 $config['smtp_host']='mail.sweken.com';
		 $config['smtp_port']='26';
		 $config['smtp_timeout']='30';
		 $config['smtp_user']='info@sweken.com';
		 $config['smtp_pass']='Infoinfo-1!';
		 $config['charset']='utf-8';
		 $config['newline']="\r\n";
		 $config['wordwrap'] = TRUE;
		 $config['mailtype'] = 'html';
		 $this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->from($siteinfos->email,$siteinfos->sname);
		$this->email->to($data['tomail']);
		$this->email->subject($data['subject']);
		$this->email->message($message);
	   $status =  $this->email->send();
       return $status;
   }

}

