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

	public function upgradeOfferMail($maildata){
		
		if($maildata['offer_id'])
		{
			$offerdt = $this->offer_issue_m->getOfferDetailsByOfferId($maildata['offer_id']);
			
			$maildata['pnr_ref']=$offerdt[0]->pnr_ref;
		}
			$pnr_ref=$maildata['pnr_ref'];
			$offer = $this->bid_m->getPassengers($maildata['pnr_ref']);
			
			if (!$offer[0]->carrier_code) {
				echo "<br>missing passenger deails for  $pnr_ref";
				return;
			}
			
			$prodlist = explode(',',$offer[0]->products);
			$email_list = explode(',',$offer[0]->email_list);

			$baggage_offer = 0;
			$upgrade_offer = 0;
			$exclude = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
		$cabins  = $this->airline_cabin_m->getAirlineCabins();
		foreach ($prodlist as $prodId) {
			switch ($prodId) {
			case 1:
				$upgrade_offer = 1;
				$results = $this->bid_m->getUpgradeOffers($pnr_ref);
				if(count($results)>0){
					foreach($results as $result){
					  $result->to_cabins = explode(',',$result->to_cabins);
					  $cdata = array();
						  foreach($result->to_cabins as $value){
								$cdata = explode('-',$value);              		
								if($cdata[2] != $exclude){
									$tocabins[$cdata[3]] = $cabins[$cdata[0]];
									//$result->tocabins[] = array('cabin_name' => $cabins[$cdata[0]]); 
								}              
							}
							ksort($tocabins);
							foreach($tocabins as $c){
								$result->tocabins[] = array('cabin_name' => $c);
							}
							if($result->fclr != null && !empty($result->tocabins)){			
						  $dept = date('d-m-Y H:i:s',$result->dep_date+$result->dept_time);
						  $arrival =  date('d-m-Y H:i:s',$result->arrival_date+$result->arrival_time);
						  $dteStart = new DateTime($dept); 
						  $dteEnd   = new DateTime($arrival); 
						  $dteDiff  = $dteStart->diff($dteEnd);
						  $result->time_diff = $dteDiff->format('%H hrs %i Min');
								$paxdata['dep_date'] = date('D d M Y',$result->dep_date);
								$paxdata['dep_time'] = date('H:i',$result->dept_time);
								$paxdata['arrival_date'] = date('D d M Y',$result->arrival_date);
								$paxdata['arrival_time'] = date('H:i',$result->arrival_time);
								$paxdata['carrier_code'] = $result->carrier_code;
								$paxdata['carrier_name'] = $result->carrier_name;
								$paxdata['flight_number'] = $result->flight_number;
								$paxdata['from_city_code'] = $result->from_city_code;
								$paxdata['from_city'] = $result->from_city;
								$paxdata['to_city_code'] = $result->to_city_code;
								$paxdata['to_city'] = $result->to_city;
								$paxdata['seat_no'] = $result->seat_no;
								$paxdata['current_cabin'] = $result->current_cabin;
								$paxdata['cabins'] = $result->tocabins;
								$paxdata['time_diff'] = $dteDiff->format('%H hrs %i Min');
								$offerdata[] = $paxdata;
							}
								$maildata['carrier_name'] = $result->carrier_name;
								break;
							}
					  		$maildata['highest_upgrade_class'] = $result->tocabins[0]['cabin_name'];
						}

						//print_r($results); exit();
					break;
					case 2:
						
						$baggage_offer = 1;
						if ( $upgrade_offer) {
							break;//HACK
						}
						$results = $this->offer_issue_m->getBaggageOffer($pnr_ref);
						if(count($results)>0){
						foreach($results as $result){
						  $dept = date('d-m-Y H:i:s',$result->dep_date+$result->dept_time);
						  $arrival =  date('d-m-Y H:i:s',$result->arrival_date+$result->arrival_time);
						  $dteStart = new DateTime($dept); 
						  $dteEnd   = new DateTime($arrival); 
						  $dteDiff  = $dteStart->diff($dteEnd);
						  $result->time_diff = $dteDiff->format('%H hrs %i Min');
						  $cdata = array();
							$paxdata['dep_date'] = date('D d M Y',$result->dep_date);
							$paxdata['dep_time'] = date('H:i',$result->dept_time);
							$paxdata['arrival_date'] = date('D d M Y',$result->arrival_date);
							$paxdata['arrival_time'] = date('H:i',$result->darrival_time);
							$paxdata['carrier_code'] = $result->carrier_code;
							$paxdata['carrier_name'] = $result->carrier_name;
							$paxdata['flight_number'] = $result->flight_number;
							$paxdata['from_city_code'] = $result->from_city_code;
							$paxdata['from_city'] = $result->from_city;
							$paxdata['to_city_code'] = $result->to_city_code;
							$paxdata['to_city'] = $result->to_city;
							$paxdata['seat_no'] = $result->seat_no;
							$paxdata['current_cabin'] = $result->current_cabin;
							$paxdata['cabins'] = $result->tocabins;
							$paxdata['time_diff'] = $dteDiff->format('%H hrs %i Min');
							$offerdata[] = $paxdata;
							$maildata['carrier_name'] = $result->carrier_name;
							break;
						}
						}
					//print_r($results); exit();
				break;

				default:
			break;
		}
	}
	if($maildata['template'])
	{
		$template=$maildata['template'];
		
	}
	else{
	if ( $baggage_offer && $upgrade_offer ) {
			#echo "<br>UPGRADE & BAGGAGE COMBO OFFER";
			$template = "upgrade_baggage_offer";    
			$maildata['mail_subject'] .= " Upgrade & Baggage offer";    
		} elseif( $upgrade_offer) {
			#echo "<br>UPGRADE OFFER";
			$template = "upgrade_offer";    
			$maildata['mail_subject'] .= " Upgrade offer";    
		} elseif( $baggage_offer) {
			#echo "<br>BAGGAGE OFFER";
			$template = "baggage_offer";    
			$maildata['mail_subject'] .= " Baggage offer";    
		}
	}
		$pax_names = $this->bid_m->getPaxNames($pnr_ref);
	
				$maildata['first_name']=$offer[0]->pax_names;
				$maildata['pnr_ref'] =  $pnr_ref;
                $maildata['offer_data'] = $offerdata;
                $maildata['airlineID'] = $offer[0]->carrier_code;
              //  $maildata['first_name'] = $offer[0]->pax_names;
                $maildata['tomail'] = $email_list[0];
                $primary_client = $this->user_m->getClientByAirline($maildata['airlineID'],6)[0];	   
		$dir = "assets/mail-temps";
		$tpl = $this->mailandsmstemplate_m->getDefaultMailTemplateByCat($template,$maildata['airlineID']);
                //$maildata = array_merge($maildata, $paxdata);
                $maildata['airlineID'] = $offer[0]->carrier_code;
		$tpl_file = $tpl->template_path;
    	 	$maildata['mail_subject'] = (!empty($tpl->mail_subject)) ? $tpl->mail_subject  : "Congratulations! Update about your offer..!";
		$maildata['mail_subject'] .= " for PNR#" . strtoupper($pnr_ref);
		$t = explode('.',$tpl_file);
		$tpl_path = $t[0]. '-imgs';
		if ( $upgrade_offer) {
                 $maildata['up_tpl_bnr'] = base_url("$dir/$tpl_path/banner.jpg");
                 $maildata['up_tpl_bnrtop'] = base_url("$dir/$tpl_path/bannerTop.png");	
                 $maildata['up_tpl_bnrbottom'] = base_url("$dir/$tpl_path/bannerBottom.png");
                 #$maildata['up_tpl_bnrbottom'] = base_url("assets/mail-temps/bg_temp1_images/bannerBottom.png");	
                 #$maildata['up_tpl_contact_img'] = base_url("assets/mail-temps/bg_temp2_images/contactUs.png");	
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
		$this->sendMailTemplateParser($template,$maildata);	
		}

	 public function sendMailTemplateParser($template,$data){
           	   $this->load->library('parser');
		   $this->load->library('email');
			//Check any customized tpl for this carrier saved in database 
		   $tpl = $this->mailandsmstemplate_m->getDefaultMailTemplateByCat($template,$data['airlineID'])->template;
		   if ( empty($tpl) ) {
			//Check any customized tpl file for this carrier 
		   	$tpl_file = $this->mailandsmstemplate_m->getDefaultMailTemplateByCat($template,$data['airlineID'])->template_path;
			$dir = "mvc/views/mail-templates";
			#$dir = "mvc/views/offer-email-temps";
			$tpl_path = "$dir/$tpl_file";
		        if (is_file($tpl_path)){
				$tpl = file_get_contents($tpl_path);
			} else {
				$this->mydebug->debug("Template file  - $tpl_path - missing!");
			}

		   }

		   if  (empty($tpl)) {
			$this->mydebug->debug("Mail Template is empty, can't send offer email!");
			return;
		   }

		   #$tpl = str_replace(array('<!--{','}-->'),array('{','}'),$tpl);		   
		   $message = $this->parser->parse_string($tpl, $data,true);
		  //$this->mydebug->debug($tpl); exit;
		  // $template="home/temp-2";		
		   //$message = $this->parser->parse($template, $data);
		  $message =html_entity_decode($message);
		  $siteinfos = $this->reset_m->get_site();
		  $this->mydebug->debug($data['tomail'].'----'.$template);		  
#$data['tomail'] ='vamsi63@gmail.com';
		  if($data['tomail']) {                      
			$subject = $data['mail_subject'];
			$email = $data['tomail'];
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
			$this->email->from($siteinfos->email,$siteinfos->sname);
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($message);

			/* if($this->email->send()) {
			$this->mydebug->debug("mail sent successfully");
			} else {
			$this->mydebug->debug($this->lang->line('mail_error'));
			} */

			if($this->email->send()){
			  $this->mydebug->debug("email_sent Congragulation Email Send Successfully.");
			} else {
			   $this->mydebug->debug("email_sent You have encountered an error ......".$this->email->print_debugger()) ;	  
			}
		}
	}	

}

