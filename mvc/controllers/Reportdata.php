<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Reportdata extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->model('report_m');
        $this->load->model('reportdata_m');
		$this->load->model('user_m');
		$this->load->model('airline_m');  
        $this->load->model('rafeed_m');        
    }

    public function index() {
        $carriers = $this->report_m->getPaxCarriers();       
       foreach($carriers as $car){
          $reportdata = $this->reportdata_m->getReportdata(array("carrier"=>$car->vx_aln_data_defnsID));
          if($reportdata){

          } else {
              $date = date("Y-n-j", strtotime("last day of previous month"));                          
              $dep_report = $this->reportdata_m->get_report($car->vx_aln_data_defnsID,$date,1);
              $sale_report = $this->reportdata_m->get_report($car->vx_aln_data_defnsID,$date,2);

              // Inserting Departure Report data 
              if(count($dep_report) > 0){
                foreach($dep_report as $report){
                    $key = date('Y-M',$report->flight_date);
                    $report->p_count = count(explode('<br>',$report->p_list));
                    $report->dep_date = date('Y-m-d',$report->flight_date);
                    $dep_lists[$key][] = $report;
                }                 
                $this->addReport($car->vx_aln_data_defnsID,$dep_lists,1); 
              }

              // Inserting Sales Report data 
              if(count($sale_report) > 0){
                foreach($sale_report as $report){
                    $key = date('Y-M',$report->flight_date);
                    $report->p_count = count(explode('<br>',$report->p_list));
                    $report->dep_date = date('Y-m-d',$report->flight_date);
                    $sale_lists[$key][] = $report;
                }             
               // $this->addReport($car->vx_aln_data_defnsID,$sale_lists,2); 
              }        
             
          }

          exit;
       }       
    }

    function addReport($carrier,$lists,$type){
        $bid_accepted =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
		$bid_rejected =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20'); 
        //to get month and year wise report
        foreach($lists as $key => $list){                  
            $data['month'] = explode('-',$key)[1];
            $data['year'] = explode('-',$key)[0];
            $data['carrier'] = $carrier;
            $data['report_type'] = $type;

            // To get cabin wise report from month&year report
             foreach($list as $li){                       
                 $cabins[$li->from_cabin_id."-".$li->to_cabin_id][]=$li;
             }
             foreach($cabins as $cabkey => $cablist){
                 $data['from_cabin'] = explode('-',$cabkey)[0];
                 $data['to_cabin'] = explode('-',$cabkey)[1];
              $accepted_list = array_filter($cablist,function ($item) use ($bid_accepted) {
                  if ($item->booking_status == $bid_accepted) {
                      return true;
                  }
                  return false;
              });
              $rejected_list = array_filter($cablist,function ($item) use ($bid_rejected) {
                  if ($item->booking_status == $bid_rejected) {
                      return true;
                  }
                  return false;
              });
                 $data['accept_revenue'] = array_sum(array_column($accepted_list,'bid_value'));
                 $data['reject_revenue'] = array_sum(array_column($rejected_list,'bid_value'));
                 $data['passenger_count'] = array_sum(array_column($cablist,'p_count'));
                 $data['create_date'] = time();
                 $data['modify_date'] = time();
                 $this->reportdata_m->add_reportdata($data);
             }                 
        }
    }
}