<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Reportdata extends Admin_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->model('report_m');
        $this->load->model('reportdata_m');
        $this->load->model('contract_m');
	$this->load->model('user_m');
	$this->load->model('airline_m');  
        $this->load->model('rafeed_m'); 
        $this->load->model('invfeed_m'); 
    }

    public function index() {
        $carriers = $this->report_m->getPaxCarriers();       
       foreach($carriers as $car){
	$products = $this->contract_m->getAirlineProducts($car->vx_aln_data_defnsID);
	foreach($products as $product) {
	  $product_id = $product->productID;
		
          $reportdata = $this->reportdata_m->getReportdata(array("carrier"=>$car->vx_aln_data_defnsID, $product_id));

          if($reportdata){
            $latest_dep_report = end(array_filter($reportdata,function ($item) {
                if ($item->type == 1) {
                    return true;
                }
                return false;
            }));

            $latest_sale_report = end(array_filter($reportdata,function ($item) {
                if ($item->type == 2) {
                    return true;
                }
                return false;
            }));
            $to_date = date("Y-n-j", strtotime("last day of previous month"));

             /*      Departure Report data cal    */           
            $dfrom_date = date("Y-n-j",strtotime("last day of ".$latest_dep_report->year.'-'.$latest_dep_report->month.'-'.'01'));
            $ddiff = date_diff(date_create($dfrom_date),date_create($to_date));
            if($ddiff->format("%a")){
                $dfrom_date = date('Y-m-d', strtotime('+1 day', strtotime($dfrom_date)));
                $dep_report = $this->reportdata_m->get_report($car->vx_aln_data_defnsID,$dfrom_date,$to_date,1, $product_id);              
                /* Inserting Departure Report data */ 
                if(count($dep_report) > 0){                             
                    $this->addReport($car->vx_aln_data_defnsID,$dep_report,1, $product_id); 
                }
            };
            

            /*      Sales Report data cal         */            
            $sfrom_date = date("Y-n-j",strtotime("last day of ".$latest_sale_report->year.'-'.$latest_sale_report->month.'-'.'01'));
            $sdiff = date_diff(date_create($sfrom_date),date_create($to_date));
            if($sdiff->format("%a")){
                $from_date = date('Y-m-d', strtotime('+1 day', strtotime($sfrom_date)));
                $sale_report = $this->reportdata_m->get_report($car->vx_aln_data_defnsID,$sfrom_date,$to_date,1, $product_id);              
                /* Inserting Sales Report data */ 
                if(count($sale_report) > 0){                             
                    $this->addReport($car->vx_aln_data_defnsID,$sale_report,1, $product_id); 
                }
            };            

          } else {
              $date = date("Y-n-j", strtotime("last day of previous month"));                           
              $date = date("Y-n-j");                           
              $dep_report = $this->reportdata_m->get_report($car->vx_aln_data_defnsID,null,$date,1, $product_id);
              $sale_report = $this->reportdata_m->get_report($car->vx_aln_data_defnsID,null,$date,2, $product_id);
             
              /* Inserting Departure Report data */ 
              if(count($dep_report) > 0){                             
                $this->addReport($car->vx_aln_data_defnsID,$dep_report,1, $product_id); 
              }

              /* Inserting Sales Report data  */
              if(count($sale_report) > 0){                            
                $this->addReport($car->vx_aln_data_defnsID,$sale_report,2, $product_id); 
              }        
             
          }        
       	 }       
	}
				$message = "Data report created successfully!";
				$status = 'success';
				$this->session->set_flashdata($status, $message);
				redirect(base_url("report/index"));
    }

    function addReport($carrier,$report_list,$type, $product_id){

        $bid_accepted =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
        $bid_rejected =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');
       
        /* To getting month and year wise data */
        foreach($report_list as $rep){
            if($type == 1){
                $key = date('Y-M',$rep->flight_date);
            } else {
                $key = date('Y-M',$rep->bid_submit_date);
            }
            $rep->p_count = count(explode('<br>',$rep->p_list));
            $rep->dep_date = date('Y-m-d',$rep->flight_date);
            $lists[$key][] = $rep;
        }           
   
        /*  To getting cabin wise report from monthyear data */
        foreach($lists as $lkey => $list){        
            foreach($list as $li){                       
                $cabins[$lkey."-".$li->from_cabin_id."-".$li->to_cabin_id][]=$li;
            }
        }

         /* prepare and inserting data  */
        foreach($cabins as $cabkey => $cablist){
            $data['carrier'] = $carrier;
            $data['type'] = $type;
            $data['product_id'] = $product_id;
            $data['year'] = explode('-',$cabkey)[0];
            $data['month'] = date_parse(explode('-',$cabkey)[1])['month'];
            $data['from_cabin'] = explode('-',$cabkey)[2];
            $data['to_cabin'] = explode('-',$cabkey)[3];
            $dataID = $this->reportdata_m->checkdata($data);
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
          //calculating Load Factor
          $tot_cap = array();
          $ldf_value = 0;
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
            $total_cap_sum = array_sum($tot_cap);
			if( $total_cap_sum ) {
            	$ldf_value = (array_sum(array_column($accepted_list,'p_count'))/$total_cap_sum)*100;
			}
          }
             $data['accept_revenue'] = array_sum(array_column($accepted_list,'bid_value'));
             $data['reject_revenue'] = array_sum(array_column($rejected_list,'bid_value'));
             $data['passenger_count'] = array_sum(array_column($cablist,'p_count')); 
             $data['tot_seat_capacity'] = array_sum($tot_cap);
		$data['tot_passengers_boarded'] = array_sum(array_column($accepted_list,'p_count'));
		$data['ldf'] = round($ldf_value);                
             $data['modify_date'] = time();
             $data['product_id'] = $product_id; 
            // $this->mydebug->debug("report data inserted for carrier".$carrier.", Month :".$data['month'].", Year :".$data['year']);
             if($dataID){
                $this->reportdata_m->update_reportdata($dataID,$data);
             } else {
                $data['create_date'] = time();
                $this->reportdata_m->add_reportdata($data);
             }
        }        
    }
}
