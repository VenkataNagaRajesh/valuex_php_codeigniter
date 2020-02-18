<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('systemadmin_m');
		$this->load->model("dashboard_m");		
		$this->load->model("setting_m");
		//$this->load->model("contract_m");
		$this->load->model("user_m");		
		$this->load->model("marketzone_m");
		$this->load->model("season_m");		
		$this->load->model("payment_m");		
		$this->load->model("airports_m");
        $this->load->model("client_m");	
        $this->load->model('acsr_m');
        $this->load->model('eligibility_exclusion_m');
        $this->load->model('offer_reference_m');	
        $this->load->model('rafeed_m');	
        $this->load->model('bid_m');		
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
		$settings = $this->setting_m->get_setting();
		
		if($this->session->userdata('usertypeID') == 2){
			$this->data['products'] = $this->user_m->loginUserProducts();
			$this->data['show_notice'] = '';
			foreach($this->data['products'] as $product){
				$OldDate = strtotime($product->end_date);
                $NewDate = date('M j, Y', $OldDate);
                $diff = date_diff(date_create($NewDate),date_create(date("M j, Y")));
				$product->expire = $diff->format('%a');				
				if($product->expire <= $settings->notice_period){
					$this->data['show_notice'] .= "<li>Your Product ".$product->product_name." is Expired in ".$product->expire."Days</li>";					
				}
			}		
		}
		
		$allmenu 	= pluck($this->menu_m->get_order_by_menu(), 'icon', 'link');
		$allmenulang = pluck($this->menu_m->get_order_by_menu(), 'menuName', 'link');		
		//$invoices	= $this->invoice_m->get_invoice();	
        $airports = $this->airports_m->TotalAirports();
		$clients = $this->client_m->clientTotalCount(); 
		$users = $this->user_m->userTotalCount();
		$acsr = $this->acsr_m->acsrTotalCount();
		$eerule = $this->eligibility_exclusion_m->EErulesTotalCount();		
		$offers = $this->offer_reference_m->offersTotalCount();
		$bid_complete = $this->bid_m->bidsTotalCount();
		
			$this->data['dashboardWidget']['sent_offer_mails']->count = $offers;
			$this->data['dashboardWidget']['sent_offer_mails']->link = "offer_issue";
			$this->data['dashboardWidget']['sent_offer_mails']->icon = "fa-list-alt";
			$this->data['dashboardWidget']['sent_offer_mails']->menu = 'Offers';
			
			$this->data['dashboardWidget']['bid_complete']->count = $bid_complete;
			$this->data['dashboardWidget']['bid_complete']->link = "offer_table";
			$this->data['dashboardWidget']['bid_complete']->icon = "fa-list-alt";
			$this->data['dashboardWidget']['bid_complete']->menu = 'Total Bids';
			
			$this->data['dashboardWidget']['feedback']->count = round($this->bid_m->avgFeedback());
			$this->data['dashboardWidget']['feedback']->link = "feedback";
			$this->data['dashboardWidget']['feedback']->icon = "fa-star";
			$this->data['dashboardWidget']['feedback']->menu = 'Average Rating';
			
			//print_r($this->data['dashboardWidget']['bid_complete_offers']); exit;
		
			$marketzones = $this->marketzone_m->marketzoneTotalCount();
			
			$seasons = $this->season_m->seasonTotalCount();
			
		$deshboardTopWidgetUserTypeOrder = $this->session->userdata('master_permission_set');
		
		//$this->data['dashboardWidget']['feetypes'] 	= count($feetypes);		
		//$this->data['dashboardWidget']['invoices'] 	= count($invoices);	
		$this->data['dashboardWidget']['airports'] 	= $airports;
        $this->data['dashboardWidget']['marketzone']= $marketzones;	
        $this->data['dashboardWidget']['season'] 	= $seasons;	
        $this->data['dashboardWidget']['clients'] 	= $clients;
        $this->data['dashboardWidget']['users']     = $users;
        $this->data['dashboardWidget']['acsr']      = $acsr;
        $this->data['dashboardWidget']['eerule']    = $eerule;		
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


		$roleID = $this->session->userdata('roleID');
		$userName = $this->session->userdata('username');
		$this->data['usertype'] = $this->session->userdata('usertype');

		if($roleID == 1) {
			$this->data['user'] = $this->user_m->get_single_user(array('username'  => $userName));
		}

		//$this->data['notices'] = $this->notice_m->get_order_by_notice(array('schoolyearID' => $schoolyearID));
		
		//print_r($this->data['loginairlines'] ); exit;
		$this->data["subview"] = "dashboard/index";
		$this->load->view('_layout_main', $this->data);
	}

}

