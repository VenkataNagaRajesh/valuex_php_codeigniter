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
	}
	
	public function allowValidation($pnr_ref){
		$status = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
		//$bid_confirmation = $this->preference_m->get_preference(array("pref_code" => 'BID_CONFIRMATION'))->pref_value;
		//$bid_expire = $this->preference_m->get_preference(array("pref_code" => 'BID_EXPIRE'))->pref_value;
					
		$offer_data = $this->offer_reference_m->getOfferDataByRef($pnr_ref);
		
		 $bid_confirmation = $this->preference_m->get_preference_value_bycode('BID_CONFIRMATION','24',$offer_data->carrier_code);	
         $bid_expire = $this->preference_m->get_preference_value_bycode('BID_EXPIRE','24',$offer_data->carrier_code);
		
		//print_r($offer_data); exit;
		//$this->mydebug->debug($status);
		//$this->mydebug->debug($offer_data->offer_status);
		//$offer_data->dep_date = 1561805915;
		if(empty($offer_data->offer_status)){
			return "Invalid PNR Reference";
		} else {
			if($status == $offer_data->offer_status){
				$added_timestamp = strtotime('+'.$bid_expire+$bid_confirmation.' day', time());
				//$this->mydebug->debug("cal date : ".date('d.m.Y', $added_timestamp));
				//$this->mydebug->debug("dep date : ".date('d.m.Y', $offer_data->dep_date));
				//echo $result;
				 if($added_timestamp > $offer_data->dep_date){
					$error ="Offer Expired";
				} else {
					$error = '';
				} 
			} else {
				$error = "This Offer Status Not matched";
			}
			return $error;
	    }
	}

}

