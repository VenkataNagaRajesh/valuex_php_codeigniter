<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends Admin_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('report_m');
		$this->load->model('user_m');
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
		if($this->input->post('airlineID')){
			$this->data['airlineID'] = $this->input->post('airlineID');
		} else {
			$this->data['airlineID'] = 3958;
		}
		if($this->input->post('year')){
			$this->data['year'] = $this->input->post('year');
		} else {
			$this->data['year'] = date('Y');
		}
		if($this->input->post('from_month')){
			$this->data['from_month'] = $this->input->post('from_month');
		} else {
			$this->data['from_month'] = 1;
		}
		if($this->input->post('to_month')){
			$this->data['to_month'] = $this->input->post('to_month');
		} else {
			$this->data['to_month'] = date('m');
		}
		if($this->input->post('type')){
			$this->data['type'] = $this->input->post('type');
		} else {
			$this->data['type'] = 1;
		}
		$from_date = $this->data['year'].'-'.$this->data['from_month'].'-01';
		$to_date = $this->data['year'].'-'.$this->data['to_month'].'-30';


		$roleID = $this->session->userdata('loginuserID');
		  if($roleID != 1){
			$this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		  } else {
			  $this->data['airlines'] = $this->airline_m->getAirlinesData();
		  }
		
		$cabins = $this->report_m->getAirlineCabins($this->data['airlineID']);	
		$i = 0;
		foreach($cabins as $cabin){
			for($j=$i+1;$j<count($cabins);$j++){
				$this->data['upgrade_cabins'][] = array(
				  "name" => $cabins[$i]->cabin."-".$cabins[$j]->cabin, 
				  "from_cabin" => $cabins[$i]->desc,
				  "to_cabin" => $cabins[$j]->desc
				);
			}
		  $i++;			
		}

		$start    = (new DateTime($from_date))->modify('first day of this month');
		$end      = (new DateTime($to_date))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		foreach ($period as $dt) {
		  $this->data['current'][]=$dt->format("M");
		}
		$this->data['current'] = array_fill_keys($this->data['current'],0);
		$this->data['previous'] = $this->data['current'];

		$this->data['report'] = $this->report_m->get_report($this->data['airlineID'],$from_date,$to_date,$this->data['type']);
		$this->data['previous_report'] = $this->report_m->get_report($this->data['airlineID'],date('Y-m-d', strtotime('-1 year', strtotime($from_date))),date('Y-m-d', strtotime('-1 year', strtotime($to_date))),$this->data['type']);

		$bid_accepted =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
		$bid_rejected =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');
		//print_r($this->data['report']); exit;
		foreach($this->data['report'] as $feed){
			$feed->p_count = count(explode('<br>',$feed->p_list));
			$feed->dep_date = date('Y-m-d',$feed->flight_date);
			if ($feed->booking_status == $bid_accepted) {
			 $this->data['current'][date('M',$feed->flight_date)] +=  $feed->bid_value;
			} 
		}
		
		foreach($this->data['previous_report'] as $feed){
			$feed->p_count = count(explode('<br>',$feed->p_list));
			$feed->dep_date = date('Y-m-d',$feed->flight_date);
			if ($feed->booking_status == $bid_accepted) {
			 $this->data['previous'][date('M',$feed->flight_date)] +=  $feed->bid_value;
			} 
		}
		
		 //print_r($this->data['previous']); exit;
		
		$this->data['total_accept_revenue'] = 0;
		foreach($this->data['upgrade_cabins'] as $cab){			
			$cabs = explode('-',$cab['name']);
			$cab_name = strtolower($cabs[0].$cabs[1]);
			$this->data[$cab_name]['report'] = array_filter($this->data['report'],function ($item) use ($cabs) {
				if ($item->from_cabin == $cabs[0] and $item->to_cabin == $cabs[1]) {
					return true;
				}
				return false;
			});			 
			$accepted_list = array_filter($this->data[$cab_name]['report'],function ($item) use ($bid_accepted) {
				if ($item->booking_status == $bid_accepted) {
					return true;
				}
				return false;
			});
			$rejected_list = array_filter($this->data[$cab_name]['report'],function ($item) use ($bid_rejected) {
				if ($item->booking_status == $bid_rejected) {
					return true;
				}
				return false;
			});
		
			$this->data[$cab_name]['accept_revenue'] = array_sum(array_column($accepted_list,'bid_value'));
			$this->data[$cab_name]['passengers'] = array_sum(array_column($this->data[$cab_name]['report'],'p_count'));
			$this->data[$cab_name]['avg_bid'] = $this->data[$cab_name]['accept_revenue'] / $this->data[$cab_name]['passengers'];
			$this->data[$cab_name]['reject_revenue'] = array_sum(array_column($rejected_list,'bid_value'));
			$this->data[$cab_name]['title'] = $cab['from_cabin'].' To '.$cab['to_cabin'];
			$this->data['total_accept_revenue'] +=  $this->data[$cab_name]['accept_revenue'];
		}
		//print_r($this->data['yp']); exit;
        $this->data["subview"] = "report/index";
		$this->load->view('_layout_main', $this->data); 
    }
}