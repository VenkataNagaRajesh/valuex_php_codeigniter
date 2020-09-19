<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bgreport extends Admin_Controller {

	function __construct() {
		parent::__construct();	
		$this->load->model('report_m');
		$this->load->model('reportdata_m');
		$this->load->model('user_m');
		$this->load->model('airline_m');
		$this->load->model('invfeed_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('bgreport', $language);			
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
		if($this->input->post('filter_year')){
			$this->data['year'] = $this->input->post('filter_year');
		} else {
			$this->data['year'] = date('Y');
		}
		if($this->input->post('filter_from_month')){
			$this->data['from_month'] = $this->input->post('filter_from_month');
		} else {
			$this->data['from_month'] = 1;
		}
		if($this->input->post('filter_to_month')){
			$this->data['to_month'] = $this->input->post('filter_to_month');
		} else {
			$this->data['to_month'] = date('m');
		}
		if($this->input->post('filter_type')){
			$this->data['type'] = $this->input->post('filter_type');
		} else {
			$this->data['type'] = 1;
		}
		$this->data['from_date'] = '01'.'-'.$this->data['from_month']."-".$this->data['year'];
		$this->data['to_date'] = date("t-m-Y", strtotime($this->data['year'].'-'.$this->data['to_month'].'-01'));		 
		
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
				  "to_cabin" => $cabins[$j]->desc,
				  "from_cabin_id" => $cabins[$i]->vx_aln_data_defnsID,
				  "to_cabin_id" => $cabins[$j]->vx_aln_data_defnsID
				);
			}
		  $i++;			
		}

		$start    = (new DateTime($this->data['from_date']))->modify('first day of this month');
		$end      = (new DateTime($this->data['to_date']))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		foreach ($period as $dt) {
		  $this->data['current'][]=$dt->format("M");
		}
		$bid_accepted =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
		$bid_rejected =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');
		$this->data['current'] = array_fill_keys($this->data['current'],0);
		$this->data['previous'] = $this->data['current'];
		$this->data['total_accept_revenue'] = 0;
		$this->data['bid_accepted'] = $bid_accepted;
		$this->data['bid_rejected'] = $bid_rejected;
		if($this->data['type'] == 1){
			$filter_date = 'flight_date';
		} else {
			$filter_date = 'bid_submit_date';
		}
		/*  To get previous year report by monthly */
		$pre_where = array('carrier'=>$this->data['airlineID'],'type'=>$this->data['type'],'year'=>$this->data['year']-1,'month >='.$this->data['from_month'],'month <='=>$this->data['to_month']);
		$this->data['previous_report'] = $this->reportdata_m->getReportdata($pre_where);
		if(count($this->data['previous_report'])){
			foreach($this->data['previous_report'] as $feed){
				if ($rep->accept_revenue > 0) {
					$monthname = date("M", mktime(0, 0, 0, $rep->month, 01)); 
					$this->data['previous'][$monthname] +=  $rep->accept_revenue;
				}
			}
			/* Getting previous data from Report data Backup */ 
			foreach($this->data['upgrade_cabins'] as $cab){
				$cabs = explode('-',$cab['name']);
					$cab_name = strtolower($cabs[0].$cabs[1]);
					$this->data[$cab_name]['pre_report'] = array_filter($this->data['previous_report'],function ($item) use ($cab) {
						if ($item->from_cabin == $cab['from_cabin_id'] and $item->to_cabin == $cab['to_cabin_id']) {
							return true;
						}
						return false;
					});
				if(count($this->data[$cab_name]['pre_report']) > 0){				
					$this->data[$cab_name]['pre_accept_revenue'] = array_sum(array_column($this->data[$cab_name]['pre_report'],'accept_revenue'));
					$this->data[$cab_name]['pre_passengers'] = array_sum(array_column($this->data[$cab_name]['pre_report'],'passenger_count'));
					$this->data[$cab_name]['pre_avg_bid'] = $this->data[$cab_name]['accept_revenue'] / $this->data[$cab_name]['passengers'];
					$this->data[$cab_name]['pre_reject_revenue'] = array_sum(array_column($this->data[$cab_name]['pre_report'],'reject_revenue'));
					$this->data[$cab_name]['pre_title'] = $cab['from_cabin'].' To '.$cab['to_cabin'];
					$this->data[$cab_name]['pre_from_cabin_id'] = $cab['from_cabin_id'];
					$this->data[$cab_name]['pre_to_cabin_id'] = $cab['to_cabin_id'];				
				} else {
					// unset($this->data[$cab_name]);
					continue;
				}				
			}
		}

		/* To get current year Report By monthly */
		$where_filter = array('carrier'=>$this->data['airlineID'],'type'=>$this->data['type'],'year'=>$this->data['year'],'month >='.$this->data['from_month'],'month <='=>$this->data['to_month']);
		$report = $this->reportdata_m->getReportdata($where_filter);
		$this->data['current_report'] = $report;
		foreach($report as $rep){
			if ($rep->accept_revenue > 0) {
				$monthname = date("M", mktime(0, 0, 0, $rep->month, 01)); 
				$this->data['current'][$monthname] +=  $rep->accept_revenue;
			}
		}
		/* Getting data from Report data Backup */ 
		foreach($this->data['upgrade_cabins'] as $cab){
			$cabs = explode('-',$cab['name']);
				$cab_name = strtolower($cabs[0].$cabs[1]);
				$this->data[$cab_name]['report'] = array_filter($report,function ($item) use ($cab) {
					if ($item->from_cabin == $cab['from_cabin_id'] and $item->to_cabin == $cab['to_cabin_id']) {
						return true;
					}
					return false;
				});
             if(count($this->data[$cab_name]['report']) > 0){				
				$this->data[$cab_name]['accept_revenue'] = array_sum(array_column($this->data[$cab_name]['report'],'accept_revenue'));
				$this->data[$cab_name]['passengers'] = array_sum(array_column($this->data[$cab_name]['report'],'passenger_count'));
				$this->data[$cab_name]['avg_bid'] = $this->data[$cab_name]['accept_revenue'] / $this->data[$cab_name]['passengers'];
				$this->data[$cab_name]['reject_revenue'] = array_sum(array_column($this->data[$cab_name]['report'],'reject_revenue'));
				$this->data[$cab_name]['title'] = $cab['from_cabin'].' To '.$cab['to_cabin'];
				$this->data[$cab_name]['from_cabin_id'] = $cab['from_cabin_id'];
				$this->data[$cab_name]['to_cabin_id'] = $cab['to_cabin_id'];
				$this->data[$cab_name]['tot_seat_capacity'] = array_sum(array_column($this->data[$cab_name]['report'],'tot_seat_capacity'));
				$this->data[$cab_name]['tot_passengers_boarded'] = array_sum(array_column($this->data[$cab_name]['report'],'tot_passengers_boarded'));
				$this->data[$cab_name]['ldf'] = ($this->data[$cab_name]['tot_passengers_boarded']/$this->data[$cab_name]['tot_seat_capacity'])*100;
				$this->data['total_accept_revenue'] +=  $this->data[$cab_name]['accept_revenue'];
			 } else {
				 //unset($this->data[$cab_name]);
				 continue;
			 }				
		}

		/* To get Current Month Report data */
		if($this->data['to_month'] >= date('m') && $this->data['year'] == date('Y')){
			$this->data['current_from_date'] = date('Y-m-d', strtotime('first day of this month'));
			$this->data['current_to_date'] = date('Y-m-d', strtotime('last day of this month'));
			$from_query_date = '01-'.date('m').'-'.$this->data['year'];
			$to_query_date = '01-'.$this->data['to_month'].'-'.$this->data['year'];
			$this->data['current_from_date'] = date('Y-m-01', strtotime($from_query_date));			
			$this->data['current_to_date'] = date('Y-m-t', strtotime($to_query_date));	
			//print_r($this->data['current_from_date']); 		
			//print_r($this->data['current_to_date']); exit; 		
			$this->data['report'] = $this->report_m->get_report($this->data['airlineID'],$this->data['current_from_date'],$this->data['current_to_date'],$this->data['type'],$bid_accepted,$bid_rejected);					
			foreach($this->data['report'] as $feed){
					$feed->p_count = count(explode('<br>',$feed->p_list));
					$feed->dep_date = date('Y-m-d',$feed->flight_date);
					if ($feed->booking_status == $bid_accepted) {
					$this->data['current'][date('M',$feed->$filter_date)] +=  $feed->bid_value;
					}
			}		
			
			foreach($this->data['upgrade_cabins'] as $cab){			
				$cabs = explode('-',$cab['name']);
				$cab_name = strtolower($cabs[0].$cabs[1]);
				$this->data[$cab_name]['report'] = array_filter($this->data['report'],function ($item) use ($cabs) {
					if ($item->from_cabin == $cabs[0] and $item->to_cabin == $cabs[1]) {
						return true;
					}
					return false;
				});
				if(count($this->data[$cab_name]['report']) > 0){			 
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
					$tot_cap = array(); $ldf_value = 0;
					foreach($accepted_list as $accept){						
						$unique_key = $accept->flight_number.'-'.$accept->flight_date.'-'.$accept->from_city_code.'-'.$accept->to_city_code; 
						if(!isset($tot_cap[$unique_key])){
							$inv = array();
							$inv['flight_nbr'] = $accept->flight_number;
							$inv['airline_id'] = $accept->carrier_code;
							$inv['departure_date'] = $accept->flight_date;
							$inv['origin_airport'] = $accept->from_city_code;
							$inv['dest_airport'] = $accept->to_city_code;
							$inv['cabin'] = $accept->upgrade_type;
							$seats_data = $this->invfeed_m->getEmptyCabinSeats($inv);
							$tot_cap[$unique_key] = $seats_data->seat_capacity;
						}
					}
				    if(count($accepted_list) > 0){
					  $ldf_value = (array_sum(array_column($accepted_list,'p_count'))/array_sum($tot_cap))*100;
					}
					$this->data[$cab_name]['accept_revenue'] = array_sum(array_column($accepted_list,'bid_value'));
					$this->data[$cab_name]['passengers'] = array_sum(array_column($this->data[$cab_name]['report'],'p_count'));
					$this->data[$cab_name]['avg_bid'] = $this->data[$cab_name]['accept_revenue'] / $this->data[$cab_name]['passengers'];
					$this->data[$cab_name]['reject_revenue'] = array_sum(array_column($rejected_list,'bid_value'));
					$this->data[$cab_name]['title'] = $cab['from_cabin'].' To '.$cab['to_cabin'];
					$this->data[$cab_name]['from_cabin_id'] = $cab['from_cabin_id'];
					$this->data[$cab_name]['to_cabin_id'] = $cab['to_cabin_id'];
					$this->data[$cab_name]['tot_seat_capacity'] = array_sum($tot_cap);
					$this->data[$cab_name]['tot_passengers_boarded'] = array_sum(array_column($accepted_list,'p_count'));
					$this->data[$cab_name]['ldf'] = round($ldf_value);
					$this->data['total_accept_revenue'] +=  $this->data[$cab_name]['accept_revenue'];
					//echo $cab_name;
					//print_r($this->data[$cab_name]);
				} else {
					//unset($this->data[$cab_name]);
					continue;
				}
			} //exit;
	    }		
        $this->data["subview"] = "bgreport/index";
		$this->load->view('_layout_main', $this->data); 
	}
	
	public function getreport() {
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
		if($this->input->post('filter_year')){
			$this->data['year'] = $this->input->post('filter_year');
		} else {
			$this->data['year'] = date('Y');
		}
		if($this->input->post('filter_from_month')){
			$this->data['from_month'] = $this->input->post('filter_from_month');
		} else {
			$this->data['from_month'] = 1;
		}
		if($this->input->post('filter_to_month')){
			$this->data['to_month'] = $this->input->post('filter_to_month');
		} else {
			$this->data['to_month'] = date('m');
		}
		if($this->input->post('filter_type')){
			$this->data['type'] = $this->input->post('filter_type');
		} else {
			$this->data['type'] = 1;
		}
		$this->data['from_date'] = '01'.'-'.$this->data['from_month']."-".$this->data['year'];
		$this->data['to_date'] = date("t-m-Y", strtotime($this->data['year'].'-'.$this->data['to_month'].'-01'));		 
		
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
				  "to_cabin" => $cabins[$j]->desc,
				  "from_cabin_id" => $cabins[$i]->vx_aln_data_defnsID,
				  "to_cabin_id" => $cabins[$j]->vx_aln_data_defnsID
				);
			}
		  $i++;			
		}

		$start    = (new DateTime($this->data['from_date']))->modify('first day of this month');
		$end      = (new DateTime($this->data['to_date']))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		foreach ($period as $dt) {
		  $this->data['current'][]=$dt->format("M");
		}
		$this->data['current'] = array_fill_keys($this->data['current'],0);
		$this->data['previous'] = $this->data['current'];
		$bid_accepted =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
		$bid_rejected =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');

		$this->data['report'] = $this->report_m->get_report($this->data['airlineID'],$this->data['from_date'],$this->data['to_date'],$this->data['type'],$bid_accepted,$bid_rejected);
		$this->data['previous_report'] = $this->report_m->get_report($this->data['airlineID'],date('Y-m-d', strtotime('-1 year', strtotime($this->data['from_date']))),date('Y-m-d', strtotime('-1 year', strtotime($this->data['to_date']))),$this->data['type'],$bid_accepted,$bid_rejected);
		
		$this->data['bid_accepted'] = $bid_accepted;
		$this->data['bid_rejected'] = $bid_rejected;
		if($this->data['type'] == 1){
			$filter_date = 'flight_date';
		} else {
			$filter_date = 'bid_submit_date';
		}
		//print_r($this->data['report']); exit;
		foreach($this->data['report'] as $feed){
				$feed->p_count = count(explode('<br>',$feed->p_list));
				$feed->dep_date = date('Y-m-d',$feed->flight_date);
				if ($feed->booking_status == $bid_accepted) {
				 $this->data['current'][date('M',$feed->$filter_date)] +=  $feed->bid_value;
				}
		}
		foreach($this->data['previous_report'] as $feed){
				$feed->p_count = count(explode('<br>',$feed->p_list));
				$feed->dep_date = date('Y-m-d',$feed->flight_date);
				if ($feed->booking_status == $bid_accepted) {
				 $this->data['previous'][date('M',$feed->$filter_date)] +=  $feed->bid_value;
				}
		}        
		
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

			$tot_cap = array(); $ldf_value = 0;
			foreach($accepted_list as $accept){						
				$unique_key = $accept->flight_number.'-'.$accept->flight_date.'-'.$accept->from_city_code.'-'.$accept->to_city_code; 
				if(!isset($tot_cap[$unique_key])){
					$inv = array();
					$inv['flight_nbr'] = $accept->flight_number;
					$inv['airline_id'] = $accept->carrier_code;
					$inv['departure_date'] = $accept->flight_date;
					$inv['origin_airport'] = $accept->from_city_code;
					$inv['dest_airport'] = $accept->to_city_code;
					$inv['cabin'] = $accept->upgrade_type;
					$seats_data = $this->invfeed_m->getEmptyCabinSeats($inv);
					$tot_cap[$unique_key] = $seats_data->seat_capacity;
				}
			}
			if(count($accepted_list) > 0){
			  $ldf_value = (array_sum(array_column($accepted_list,'p_count'))/array_sum($tot_cap))*100;
			}
		
			$this->data[$cab_name]['accept_revenue'] = array_sum(array_column($accepted_list,'bid_value'));
			$this->data[$cab_name]['passengers'] = array_sum(array_column($this->data[$cab_name]['report'],'p_count'));
			$this->data[$cab_name]['avg_bid'] = $this->data[$cab_name]['accept_revenue'] / $this->data[$cab_name]['passengers'];
			$this->data[$cab_name]['reject_revenue'] = array_sum(array_column($rejected_list,'bid_value'));
			$this->data[$cab_name]['title'] = $cab['from_cabin'].' To '.$cab['to_cabin'];
			$this->data[$cab_name]['from_cabin_id'] = $cab['from_cabin_id'];
			$this->data[$cab_name]['to_cabin_id'] = $cab['to_cabin_id'];
			$this->data[$cab_name]['tot_seat_capacity'] = array_sum($tot_cap);
			$this->data[$cab_name]['tot_passengers_boarded'] = array_sum(array_column($accepted_list,'p_count'));
			$this->data[$cab_name]['ldf'] = round($ldf_value);
			$this->data['total_accept_revenue'] +=  $this->data[$cab_name]['accept_revenue'];
		}
		//print_r($this->data); exit;
        $this->data["subview"] = "bgreport/index";
		$this->load->view('_layout_main', $this->data); 
	}	
	
}