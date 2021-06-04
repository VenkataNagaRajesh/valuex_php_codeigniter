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
	
	public function allowValidation($pnr_ref) {	
	}
	
	public function sendMail($data){
		 $this->mydebug->debug($data);
		// print_r($data); exit;
		if($data['product_id']==1)
		{
			$upgrade_offer=1;
		}
		else if($data['product_id']==2){
			$baggage_offer=1;
		}
		$maildata=array();
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
		   $dir = "assets/mail-temps";
	   $tpl = $this->mailandsmstemplate_m->getDefaultMailTemplateByCat($data['template'],$data['airlineID'])->template;
		if ( empty($tpl) ) {
			//Check any customized tpl file for this carrier 
			$tpl_file = $this->mailandsmstemplate_m->getDefaultMailTemplateByCat($data['template'],$data['airlineID'])->template_path;

			$t = explode('.',$tpl_file);
		$tpl_path = $t[0]. '-imgs';
			
		if ( $upgrade_offer) {
                 $maildata['up_tpl_bnr'] = base_url("$dir/$tpl_path/banner.jpg");
                 $maildata['up_tpl_bnrtop'] = base_url("$dir/$tpl_path/bannerTop.png");	
                 $maildata['up_tpl_bnrbottom'] = base_url("$dir/$tpl_path/bannerBottom.png");
                
		}

		if( $baggage_offer) {
                 $maildata['bg_tpl_bnr'] = base_url("$dir/$tpl_path/banner.png");	
                 $maildata['bg_tpl_bnrtop'] = base_url("$dir/$tpl_path/bannerTop.png");	
                 $maildata['bg_tpl_bnrbottom'] = base_url("$dir/$tpl_path/bannerBottom.png");	
              
		}
                 $maildata['open_browser'] = base_url("$dir/$tpl_path/openBrowser.png");
                 $maildata['facebook_icon'] = base_url("$dir/$tpl_path/facebook.png");		
                 $maildata['tag_img'] = base_url("$dir/$tpl_path/tag.png");		
                 $maildata['twitter_icon'] = base_url("$dir/$tpl_path/twitter.png");	
                 $maildata['pinterest_icon'] = base_url("$dir/$tpl_path/pinterest.png");	
                 $maildata['openbrowser_img'] = base_url("$dir/openBrowser.png");
            	 $maildata['airline_logo'] = base_url('uploads/images/'.$this->airline_m->getAirlineLogo($maildata['airlineID'])->logo);            
                
                 $maildata['domain'] = $primary_client->domain;
                 $maildata['primary_phone'] = $primary_client->phone;
                 $maildata['primary_mail'] = $primary_client->email;
                 $maildata['fb_link'] = "https://facebook.com";
                 $maildata['twitter_link'] = "https://twitter.com";
                 $maildata['pinterest_link'] = "https://pinterest.com";
                 $maildata['unsubscribe_link'] = base_url('home/index');
                 $maildata['forward_friend_link'] = base_url('home/index');
                 $maildata['openbrowser_link'] = base_url('home/index');
                 $maildata['not_intrested_link'] = base_url('home/index');
                 
		   $maildata['base_url'] = base_url(); 
		   $maildata['bidnow_link'] = base_url('homes/bidding?pnr_ref='.$pnr_ref);
		   $template_images = $this->airline_m->getImagesByType($maildata['airlineID']);
		   foreach($template_images as $img){
			   $maildata[$img->type] = base_url('uploads/images/'.$img->image);
		   } 
                   $airline_info = $this->bid_m->getAirlineLogoByPNR($pnr_ref);
		   $maildata['mail_header_color'] = $airline_info->mail_header_color;
		   if(empty($maildata['mail_header_color'])){
			 $maildata['mail_header_color'] = '#333';  
		   }
		   
		   if(isset($maildata['bid_value'])){
			   $maildata['bid_value'] = number_format($maildata['bid_value']);
		   }

			$dir = "mvc/views/mail-templates";
			#$dir = "mvc/views/offer-email-temps";
			$tpl_path = "$dir/$tpl_file";
				if (is_file($tpl_path)){
				$tpl = file_get_contents($tpl_path);
			} else {
				$this->mydebug->debug("Template file  - $tpl_path - missing!");
			}
		}
		$data=array_merge($data,$maildata);
		$status=$this->sendMailTemplateParser($data['template'],$data);
       return $status;
   }

}

