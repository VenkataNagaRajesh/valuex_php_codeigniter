<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adreport extends Admin_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('report_m');
		$this->load->model('reportdata_m');
		$this->load->model('user_m');
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
		
        
        
		$sQuery = "SELECT b.alias,b.create_date FROM VX_offer_info a LEFT JOIN VX_data_defns b ON (b.vx_aln_data_defnsID = a.booking_status) LEFT JOIN UP_bid c ON(c.offer_id = a.dtpfext_id)  WHERE b.alias='bid_accepted'";
             $rResult = $this->install_m->run_query($sQuery);
             
        $bidcount = [];
        $bidcount = $rResult;
        $bidsaccept = count($bidcount);

        $ssQuery = "SELECT b.alias,b.create_date,c.cash,c.bid_value FROM VX_offer_info a LEFT JOIN VX_data_defns b ON (b.VX_aln_data_defnsID = a.booking_status) LEFT JOIN UP_bid c ON(c.offer_id = a.dtpfext_id) WHERE b.alias='bid_received'";
             $rrResult = $this->install_m->run_query($ssQuery);
             
        $bidrec = [];
        $bidrec = $rrResult;
        $bidsrecevied = count($bidrec);
		$average = $bidsaccept/$bidsrecevied*100;

		$lineResult = [];
		$line_chart = "SELECT b.alias as bid_status,b.create_date as date FROM VX_offer_info a LEFT JOIN VX_data_defns b ON (b.vx_aln_data_defnsID = a.booking_status) WHERE b.alias='bid_received'";
		$lineResult = $this->install_m->run_query($line_chart);
		
		$bid = [];
		$dates = [];
		
		foreach($lineResult as $row){
			
			$bid['bid_status'] = $row->bid_status;
			$dates['date'] = $row->date;
			
			
		}
	
		
		
		$this->data['bid_details'] = $bid_details;
		$this->data['date'] = $date;
		$this->data['bidsaccept'] = $bidsaccept;
		$this->data['bidsrecevied'] = $bidsrecevied; 
		$this->data['average'] = $average;     
        $this->data["subview"] = "adreport/index";
		$this->load->view('_layout_main', $this->data); 
	}
	
	}
