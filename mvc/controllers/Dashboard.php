<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
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

	function __construct() {
		parent::__construct();
		$this->load->model('systemadmin_m');
		$this->load->model("dashboard_m");
		//$this->load->model("automation_shudulu_m");
		//$this->load->model("automation_rec_m");
		$this->load->model("setting_m");
		$this->load->model("notice_m");
		$this->load->model("user_m");
		//$this->load->model("student_m");
		//$this->load->model("classes_m");
		//$this->load->model("teacher_m");
		//$this->load->model("parents_m");
		//$this->load->model("sattendance_m");
		//$this->load->model("subjectattendance_m");
		//$this->load->model("subject_m");
		$this->load->model("feetypes_m");
		$this->load->model("invoice_m");
		$this->load->model("expense_m");
		$this->load->model("payment_m");
		//$this->load->model("lmember_m");
		//$this->load->model("book_m");
		$this->load->model("issue_m");
		//$this->load->model("student_info_m");
		//$this->load->model('hmember_m');
		//$this->load->model('tmember_m');
		//$this->load->model('event_m');
		//$this->load->model('holiday_m');
		$this->load->model('visitorinfo_m');
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

		/* $students 	= $this->student_m->get_order_by_student(array('schoolyearID' => $schoolyearID));
		$classes	= pluck($this->classes_m->get_classes(), 'obj', 'classesID');
		$teachers	= $this->teacher_m->get_teacher();
		$parents	= $this->parents_m->get_parents();
		$books		= $this->book_m->get_book(); */
		$feetypes	= $this->feetypes_m->get_feetypes();
		
		//$lmembers	= $this->lmember_m->get_lmember();
		//$events		= $this->event_m->get_event();
		//$holidays	= $this->holiday_m->get_order_by_holiday(array('schoolyearID' => $schoolyearID));
		$visitors 	= $this->visitorinfo_m->get_order_by_visitorinfo(array('schoolyearID' => $schoolyearID));
		$allmenu 	= pluck($this->menu_m->get_order_by_menu(), 'icon', 'link');
		$allmenulang = pluck($this->menu_m->get_order_by_menu(), 'menuName', 'link');

		
			$invoices	= $this->invoice_m->get_invoice();
			//$subjects	= $this->subject_m->get_subject();
			//$issues		= $this->issue_m->get_order_by_issue(array('return_date' => NULL));
		

		$deshboardTopWidgetUserTypeOrder = $this->session->userdata('master_permission_set');

		//$this->data['dashboardWidget']['students'] 	= count($students);
		//$this->data['dashboardWidget']['classes']  	= count($classes);
		//$this->data['dashboardWidget']['teachers'] 	= count($teachers);
		//$this->data['dashboardWidget']['parents'] 	= count($parents);
		//$this->data['dashboardWidget']['subjects'] 	= count($subjects);
		//$this->data['dashboardWidget']['books'] 	= count($books);
		$this->data['dashboardWidget']['feetypes'] 	= count($feetypes);
		//$this->data['dashboardWidget']['lmembers'] 	= count($lmembers);
		//$this->data['dashboardWidget']['events'] 	= count($events);
		//$this->data['dashboardWidget']['issues'] 	= count($issues);
		//$this->data['dashboardWidget']['holidays'] 	= count($holidays);
		$this->data['dashboardWidget']['invoices'] 	= count($invoices);
		$this->data['dashboardWidget']['visitors'] 	= count($visitors);
		$this->data['dashboardWidget']['allmenu'] 	= $allmenu;
		$this->data['dashboardWidget']['allmenulang'] 	= $allmenulang;
		
		//$attendanceSystem = $this->data['siteinfos']->attendance;
		//$this->data['attendanceSystem'] = $attendanceSystem;

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
		// dd(date('Y-m-d 00:00:00', strtotime('-7 days')));


		$visitors = $this->loginlog_m->get_order_by_loginlog(array('login <= ' => $currentDate, 'login >= ' => $previousSevenDate));
		$showChartVisitor = array();
		foreach ($visitors as $visitor) {
			$date = date('j M',$visitor->login);
			if(!isset($showChartVisitor[$date])) {
				$showChartVisitor[$date] = 0;
			}
			$showChartVisitor[$date]++;
		}

		$this->data['showChartVisitor'] = $showChartVisitor;
		// dd($incomeMonthAndDay);
		//
		// dd($expenseMonthTotal);


		// dd($classWiseAttendance);
		// dd($todaysAttendance);
		// dd(date('d'));

		// dd($this->session->userdata);
		// dump($students);
		// dd(count($students));


		$userTypeID = $this->session->userdata('usertypeID');
		$userName = $this->session->userdata('username');
		$this->data['usertype'] = $this->session->userdata('usertype');

		if($userTypeID == 1) {
			$this->data['user'] = $this->systemadmin_m->get_single_systemadmin(array('username'  => $userName));
		}


		$this->data['notices'] = $this->notice_m->get_order_by_notice(array('schoolyearID' => $schoolyearID));
		//$this->data['holidays'] = $this->holiday_m->get_order_by_holiday(array('schoolyearID' => $schoolyearID));
		//$this->data['events'] = $this->event_m->get_event();


		$this->data["subview"] = "dashboard/index";
		$this->load->view('_layout_main', $this->data);

	}

	public function getDayWiseAttendance()
	{
		$dayWiseAttendance = json_decode($this->input->post('dayWiseAttendance'), true);
		$type = $this->input->post('type');
		$showChartData = array();
		foreach ($dayWiseAttendance as $key => $value) {
			$showChartData[$key] = $value[$type];
		}
		echo json_encode($showChartData);
	}

	public function dayWiseExpenseOrIncome()
	{
		$type = $this->input->post('type');
		$monthID = $this->input->post('monthID');
		$days = cal_days_in_month(CAL_GREGORIAN, $monthID, date('Y'));
		$dayWiseData = json_decode($this->input->post('dayWiseData'), true);

		$showChartData = array();
		for ($i=1; $i <= $days; $i++) {
			if(!isset($dayWiseData[$i])) {
				$showChartData[$i] = 0;
			} else {
				$showChartData[$i] = $dayWiseData[$i];
			}
		}

	    echo json_encode($showChartData);
	}

	

	public function getAllRec($arrays) {
		$returnArray = array();
		if(count($arrays)) {
			foreach ($arrays as $key => $array) {
				$returnArray[$array->nofmodule][$array->studentID][$array->month][$array->year] = 'Yes';
			}
		}
		return $returnArray;
	}


}

