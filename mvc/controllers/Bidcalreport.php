<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BidcalReport extends Admin_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('report_m');
		$this->load->model('reportdata_m');
		$this->load->model('user_m');
		$this->load->model('product_m');
		$this->load->model('airline_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('report', $language);			
	}

	public function index() {
		$this->data['headerassets'] = array(
			'css' => array(
					'assets/select2/css/select2.css',
					'assets/select2/css/select2-bootstrap.css'                      
					//'assets/datepicker/datepicker.css'
			),
			'js' => array(
					'assets/select2/select2.js'                       
					//'assets/datepicker/datepicker.js'
			)
		); 
		$roleID = $this->session->userdata('roleID');
		$userID = $this->session->userdata('loginuserID');
		
		if($this->input->post('filter_airlineID')){
			$this->data['airlineID'] = $this->input->post('filter_airlineID');
		} else if($roleID != 1 && $roleID != 5){
		    $this->data['airlineID'] = $this->session->userdata('default_airline');
	    	} else {
			$this->data['airlineID'] = 0;
		}
		if($this->input->post('filter_year_to')){
			$this->data['to_year'] = $this->input->post('filter_year_to');
		} else {
			$this->data['to_year'] = date("Y"); 
		}
		if($this->input->post('filter_to_month')){
			$this->data['to_month'] = $this->input->post('filter_to_month');
		} else {
			$this->data['to_month'] = date("m"); 
		}
		if($this->input->post('product_id')){
			$this->data['product_id'] = $this->input->post('product_id');
		}

		if ( $this->data['to_year'] && $this->data['to_month'] ) {
			//Last day of current month.
			$dateString = $this->data['to_year']. '-' . $this->data['to_month'] . '-01';
			$lastDateOfMonth = date("t", strtotime($dateString));
			#$this->data['to_date'] = date("t-m-Y", strtotime($this->data['to_year'].'-'.$this->data['to_month'].'-01'));		 
			$this->data['from_date'] = mktime(00,00,00,$this->data['to_month'],1,$this->data['to_year']);
			$this->data['to_date'] = mktime(23,59,59,$this->data['to_month'],$lastDateOfMonth,$this->data['to_year']);

			$month1_date = date('Y-m-d', strtotime('+1 month', strtotime($dateString)));
			list($m1_year,$m1_month,$m1_day) = explode('-',$month1_date);
			$lastDateOfMonth = date("t", $month1_date);
			$this->data['month1_from_date'] = mktime(00,00,00,$m1_month,1,$m1_year);
			$this->data['month1_to_date'] = mktime(23,59,59,$m1_month,$lastDateOfMonth,$m1_year);
			$month1_from_date = $this->data['month1_from_date'];
			$month1_to_date = $this->data['month1_to_date'];

			$month2_date = date('Y-m-d', strtotime('+2 month', strtotime($dateString)));
			list($m2_year,$m2_month,$m2_day) = explode('-',$month2_date);
			$lastDateOfMonth = date("t", $month2_date);
			$this->data['month2_from_date'] = mktime(00,00,00,$m2_month,1,$m2_year);
			$this->data['month2_to_date'] = mktime(23,59,59,$m2_month,$lastDateOfMonth,$m2_year);
			$month2_from_date = $this->data['month2_from_date'];
			$month2_to_date = $this->data['month2_to_date'];
		}
		
		  if($roleID != 1){
			$this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		  } else {
			  $this->data['airlines'] = $this->airline_m->getAirlinesData();
		  }
		
		$bid_accepted_status =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
		$bid_rejected_status =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');
		$from_date = time();

		$this->data['products'] = $this->product_m->productName();
        
		//Bid Revenue for Current month
		$sQuery = "SELECT count(*) as bid_count, SUM(bid.bid_value) as bid_revenue, DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%m/%d/%Y') AS  bid_date from UP_bid bid ";
 		$sQuery .=  "INNER JOIN VX_offer_info oi ON ( oi.dtpfext_id = bid.dtpfext_id) ";
		$sQuery .= " INNER JOIN VX_daily_tkt_pax_feed  pf ON ( pf.dtpf_id = oi.dtpf_id) ";
		$sQuery .= " WHERE bid.bid_id is NOT NULL ";
		if ( $this->data['product_id'] ) {
			$sQuery .= " AND bid.productID =  ". $this->data['product_id']; 
		}
		$sQuery .= " AND  oi.booking_status = $bid_accepted_status "; 
		if ( $this->data['to_date'] ) {
			$sQuery .= " AND  pf.dep_date > " . $from_date .  " AND pf.dep_date <= " . $this->data['to_date'] ; 
		} else {
			$sQuery .= " AND  pf.dep_date > " . $from_date; 
		}
		if ( $this->data['airlineID'] ) {
			$sQuery .= " AND  pf.carrier_code = " .  $this->data['airlineID'];
		}
		$sQuery .= " GROUP BY DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%d-%m-%Y')";
             	$rResult = $this->install_m->run_query($sQuery);
		$bids_current_month_list = $rResult;
		
		$bids_current_month_revenue =  array_sum(array_column($bids_current_month_list, 'bid_revenue'));
		$bids_current_month_total =  array_sum(array_column($bids_current_month_list, 'bid_count'));
		if ( $bids_current_month_revenue && $bids_current_month_total) {
			$bids_current_month_average =  $bids_current_month_revenue/$bids_current_month_total;
		} else {
			$bids_current_month_average =  0;
		}
		$this->data['bids_current_month_revenue'] = $bids_current_month_revenue;
		$this->data['bids_current_month_total'] = $bids_current_month_total;
		$this->data['bids_current_month_average'] = $bids_current_month_average;
		$this->data['bids_current_month_list'] = $bids_current_month_list;
		$this->data['bids_current_month_name'] = date("F-YY", $from_date); 

		//Bid Revenue for Next month
		$sQuery = "SELECT count(*) as bid_count, SUM(bid.bid_value) as bid_revenue, DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%m/%d/%Y') AS  bid_date from UP_bid bid ";
 		$sQuery .=  "INNER JOIN VX_offer_info oi ON ( oi.dtpfext_id = bid.dtpfext_id) ";
		$sQuery .= " INNER JOIN VX_daily_tkt_pax_feed  pf ON ( pf.dtpf_id = oi.dtpf_id) ";
		$sQuery .= " WHERE bid.bid_id is NOT NULL ";
		if ( $this->data['product_id'] ) {
			$sQuery .= " AND bid.productID =  ". $this->data['product_id']; 
		}
		$sQuery .= " AND  oi.booking_status = $bid_accepted_status "; 
		$sQuery .= " AND  pf.dep_date > " . $month1_from_date .  " AND pf.dep_date <= " . $month1_to_date;
		if ( $this->data['airlineID'] ) {
			$sQuery .= " AND  pf.carrier_code = " .  $this->data['airlineID'];
		}
		$sQuery .= " GROUP BY DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%d-%m-%Y')";

             	$rResult = $this->install_m->run_query($sQuery);
		$bids_month1_list = $rResult;
		
		$bids_month1_revenue =  array_sum(array_column($bids_month1_list, 'bid_revenue'));
		$bids_month1_total =  array_sum(array_column($bids_month1_list, 'bid_count'));
		if ( $bids_month1_revenue && $bids_month1_total) {
			$bids_month1_average =  $bids_month1_revenue/$bids_month1_total;
		} else {
			$bids_month1_average =  0;
		}
		$this->data['bids_month1_revenue'] = $bids_month1_revenue;
		$this->data['bids_month1_total'] = $bids_month1_total;
		$this->data['bids_month1_average'] = $bids_month1_average;
		$this->data['bids_month1_list'] = $bids_month1_list;
		$this->data['bids_month1_name'] = date("F-YY", $month1_from_date); 

		//Bid Revenue for Next month
		$sQuery = "SELECT count(*) as bid_count, SUM(bid.bid_value) as bid_revenue, DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%m/%d/%Y') AS  bid_date from UP_bid bid ";
 		$sQuery .=  "INNER JOIN VX_offer_info oi ON ( oi.dtpfext_id = bid.dtpfext_id) ";
		$sQuery .= " INNER JOIN VX_daily_tkt_pax_feed  pf ON ( pf.dtpf_id = oi.dtpf_id) ";
		$sQuery .= " WHERE bid.bid_id is NOT NULL ";
		if ( $this->data['product_id'] ) {
			$sQuery .= " AND bid.productID =  ". $this->data['product_id']; 
		}
		$sQuery .= " AND  oi.booking_status = $bid_accepted_status "; 
		$sQuery .= " AND  pf.dep_date > " . $month2_from_date .  " AND pf.dep_date <= " . $month2_to_date;
		if ( $this->data['airlineID'] ) {
			$sQuery .= " AND  pf.carrier_code = " .  $this->data['airlineID'];
		}
		$sQuery .= " GROUP BY DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%d-%m-%Y')";

             	$rResult = $this->install_m->run_query($sQuery);
		$bids_month2_list = $rResult;
		
		$bids_month2_revenue =  array_sum(array_column($bids_month2_list, 'bid_revenue'));
		$bids_month2_total =  array_sum(array_column($bids_month2_list, 'bid_count'));
		if ( $bids_month2_revenue && $bids_month2_total) {
			$bids_month2_average =  $bids_month2_revenue/$bids_month2_total;
		} else {
			$bids_month2_average =  0;
		}
		$this->data['bids_month2_revenue'] = $bids_month2_revenue;
		$this->data['bids_month2_total'] = $bids_month2_total;
		$this->data['bids_month2_average'] = $bids_month2_average;
		$this->data['bids_month2_list'] = $bids_month2_list;
		$this->data['bids_month2_name'] = date("F-YY", $month2_from_date); 

		$this->data['bids_avg_revenue_alert_percentage'] = 10;
		$this->data['bid_accepted_status'] = $bid_accepted_status;
        	$this->data["subview"] = "bidcalreport/index";
		$this->load->view('_layout_main', $this->data); 
	}
}
