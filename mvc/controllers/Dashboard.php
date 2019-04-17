<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('systemadmin_m');
		$this->load->model("dashboard_m");		
		$this->load->model("setting_m");
		$this->load->model("notice_m");
		$this->load->model("user_m");		
		$this->load->model("feetypes_m");
		$this->load->model("invoice_m");		
		$this->load->model("payment_m");		
		$this->load->model("airports_m");	
		$language = $this->session->userdata('lang');
		$this->lang->load('dashboard', $language);
	}

	public function index() {
		$this->data['headerassets'] = array(
			'js' => array(
				'assets/highcharts/highcharts.js',
				'assets/highcharts/highcharts-more.js',
				'assets/highcharts/data.js',
				'assets/highcharts/drilldown.js',
				'assets/highcharts/exporting.js'
			)
		);


		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		
		$feetypes	= $this->feetypes_m->get_feetypes();	
		
		$allmenu 	= pluck($this->menu_m->get_order_by_menu(), 'icon', 'link');
		$allmenulang = pluck($this->menu_m->get_order_by_menu(), 'menuName', 'link');		
		$invoices	= $this->invoice_m->get_invoice();	
        $airports = $this->airports_m->TotalAirports();
		$deshboardTopWidgetUserTypeOrder = $this->session->userdata('master_permission_set');
		
		$this->data['dashboardWidget']['feetypes'] 	= count($feetypes);		
		$this->data['dashboardWidget']['invoices'] 	= count($invoices);	
		$this->data['dashboardWidget']['airports'] 	= $airports;	        		
		$this->data['dashboardWidget']['allmenu'] 	= $allmenu;
		$this->data['dashboardWidget']['allmenulang'] 	= $allmenulang;
		$months = array(
		    1 => 'January',
		    'February',
		    'March',
		    'April',
		    'May',
		    'June',
		    'July ',
		    'August',
		    'September',
		    'October',
		    'November',
		    'December',
		);

	
		$currentDate = strtotime(date('Y-m-d H:i:s'));
		$previousSevenDate = strtotime(date('Y-m-d 00:00:00', strtotime('-7 days')));	


		$userTypeID = $this->session->userdata('usertypeID');
		$userName = $this->session->userdata('username');
		$this->data['usertype'] = $this->session->userdata('usertype');

		if($userTypeID == 1) {
			$this->data['user'] = $this->systemadmin_m->get_single_systemadmin(array('username'  => $userName));
		}

		$this->data['notices'] = $this->notice_m->get_order_by_notice(array('schoolyearID' => $schoolyearID));
		
		$this->data["subview"] = "dashboard/index";
		$this->load->view('_layout_main', $this->data);
	}

}

