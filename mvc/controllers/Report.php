<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends Admin_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('report_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('report', $language);			


	}

	public function index() {		
		$cabins = $this->report_m->getAirlineCabins();	
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

		$start    = (new DateTime('2019-10-01'))->modify('first day of this month');
		$end      = (new DateTime('2019-12-30'))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		foreach ($period as $dt) {
		  $this->data['current'][]=$dt->format("M");
		}
		$this->data['current'] = array_fill_keys($this->data['current'],0);
		 

		$this->data['report'] = $this->report_m->get_report();
		$bid_accepted =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
		$bid_rejected =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');

		foreach($this->data['report'] as $feed){
			$feed->p_count = count(explode('<br>',$feed->p_list));
			$feed->dep_date = date('Y-m-d',$feed->flight_date);
			if ($feed->booking_status == $bid_accepted) {
			 $this->data['current'][date('M',$feed->flight_date)] +=  $feed->bid_value;
			} 
		}		
		 //print_r($this->data['current']); exit;
		//bid_value,
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