<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adreport extends Admin_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('report_m');
		$this->load->model('reportdata_m');
		$this->load->model('user_m');
		$this->load->model('product_m');
		$this->load->model('airline_m');
		$this->load->model('invfeed_m');
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
		}
		if($this->input->post('filter_to_month')){
			$this->data['to_month'] = $this->input->post('filter_to_month');
		}
		if($this->input->post('product_id')){
			$this->data['product_id'] = $this->input->post('product_id');
		}

		if ( $this->data['to_year'] && $this->data['to_month'] ) {
			//Last day of current month.
			$dateString = $this->data['to_year']. '-' . $this->data['to_month'] . '-01';
			$lastDateOfMonth = date("t", strtotime($dateString));
			#$this->data['to_date'] = date("t-m-Y", strtotime($this->data['to_year'].'-'.$this->data['to_month'].'-01'));		 
			$this->data['to_date'] = mktime(23,59,59,$this->data['to_month'],$lastDateOfMonth,$this->data['to_year']);
		}
		
		  if($roleID != 1){
			$this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		  } else {
			  $this->data['airlines'] = $this->airline_m->getAirlinesData();
		  }
		
		$bid_accepted_status =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
		$bid_rejected_status =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');

		$this->data['products'] = $this->product_m->productName();
        
        
		//Accepted Builds
		$sQuery = "SELECT count(*) as total_bids, sum(bid.bid_value) as total_revenue from UP_bid bid INNER JOIN VX_offer_info oi ON ( oi.dtpfext_id = bid.dtpfext_id) ";
		$sQuery .= " INNER JOIN VX_daily_tkt_pax_feed  pf ON ( pf.dtpf_id = oi.dtpf_id) ";
		$sQuery .= " WHERE bid.bid_id is NOT NULL ";
		if ( $this->data['product_id'] ) {
			$sQuery .= " AND bid.productID =  ". $this->data['product_id']; 
		}
		$sQuery .= " AND  oi.booking_status = $bid_accepted_status "; 
		if ( $this->data['to_date'] ) {
			$sQuery .= " AND  pf.dep_date > " . time() .  " AND pf.dep_date <= " . $this->data['to_date'] ; 
		} else {
			$sQuery .= " AND  pf.dep_date > " . time(); 
		}
		if ( $this->data['airlineID'] ) {
			$sQuery .= " AND  pf.carrier_code = " .  $this->data['airlineID'];
		}
             	$rResult = $this->install_m->run_query($sQuery);
		$bid_accepted = $rResult[0]->total_bids;
		$bid_revenue = $rResult[0]->total_revenue;
		$from_date = time();
	

		//Received/Total Builds
		$sQuery = "SELECT count(*) as cnt from UP_bid bid INNER JOIN VX_offer_info oi ON ( oi.dtpfext_id = bid.dtpfext_id) ";
		$sQuery .= " INNER JOIN VX_daily_tkt_pax_feed  pf ON ( pf.dtpf_id = oi.dtpf_id) ";
		$sQuery .= " WHERE bid.bid_id is NOT NULL ";
		if ( $this->data['product_id'] ) {
			$sQuery .= " AND bid.productID =  ". $this->data['product_id']; 
		}
		#$sQuery .= " AND  oi.booking_status = $bid_accepted_status "; 
		if ( $this->data['to_date'] ) {
			$sQuery .= " AND  pf.dep_date > " . $from_date .  " AND pf.dep_date <= " . $this->data['to_date'] ; 
		} else {
			$sQuery .= " AND  pf.dep_date > " .  $from_date; 
		}
		if ( $this->data['airlineID'] ) {
			$sQuery .= " AND  pf.carrier_code = " .  $this->data['airlineID'];
		}
             	$rResult = $this->install_m->run_query($sQuery);
		$bid_received = $rResult[0]->cnt;

		$bid_average = $bid_received ? ($bid_accepted*100)/$bid_received : 0;

		//Bid Volume
		$sQuery = "SELECT count(*) as y, DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%M-%Y') AS label from UP_bid bid INNER JOIN VX_offer_info oi ON ( oi.dtpfext_id = bid.dtpfext_id) ";
		$sQuery .= " INNER JOIN VX_daily_tkt_pax_feed  pf ON ( pf.dtpf_id = oi.dtpf_id) ";
		$sQuery .= " WHERE bid.bid_id is NOT NULL ";
		if ( $this->data['product_id'] ) {
			$sQuery .= " AND bid.productID =  ". $this->data['product_id']; 
		}
		if ( $this->data['to_date'] ) {
			$sQuery .= " AND  pf.dep_date > " . $from_date .  " AND pf.dep_date <= " . $this->data['to_date'] ; 
		} else {
			$sQuery .= " AND  pf.dep_date > " . $from_date; 
		}
		if ( $this->data['airlineID'] ) {
			$sQuery .= " AND  pf.carrier_code = " .  $this->data['airlineID'];
		}
		$sQuery .= " GROUP BY DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%M-%Y')";
             	$rResult = $this->install_m->run_query($sQuery);
		$bid_volume_data = json_decode(json_encode($rResult), true);
		
		//Bid Revenue per month
		$sQuery = "SELECT SUM(bid.bid_value) as y, DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%M-%Y') AS label from UP_bid bid INNER JOIN VX_offer_info oi ON ( oi.dtpfext_id = bid.dtpfext_id) ";
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
		$sQuery .= " GROUP BY DATE_FORMAT(FROM_UNIXTIME(pf.dep_date),'%M-%Y')";
             	$rResult = $this->install_m->run_query($sQuery);
		$bid_revenue_data = json_decode(json_encode($rResult), true);
	
		$this->data['bid_details'] = $bid_details;
		$this->data['bid_accepted_status'] = $bid_accepted_status;
		$this->data['bid_accepted'] = $bid_accepted;
		$this->data['from_date'] = $from_date;
		$this->data['bid_received'] = $bid_received; 
		$this->data['bid_average'] = $bid_average;     
		$this->data['bid_revenue'] = $bid_revenue;     
		$this->data['bid_volume_data'] = $bid_volume_data;     
		$this->data['bid_revenue_data'] = $bid_revenue_data;     
        	$this->data["subview"] = "adreport/index";
		$this->load->view('_layout_main', $this->data); 
	}
}
