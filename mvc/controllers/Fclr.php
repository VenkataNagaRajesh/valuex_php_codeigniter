<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fclr extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("fclr_m");
		$this->load->model("season_m");
		$this->load->model("marketzone_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('fclr', $language);	
	}	
	
	
	public function index() {

	$this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css',
                                                'assets/datepicker/datepicker.css'
                ),
                'js' => array(
                        'assets/select2/select2.js',
                                                'assets/datepicker/datepicker.js'
                )
        );



		
		if(!empty($this->input->post('boarding_point'))){	
		   $this->data['boarding_point'] = $this->input->post('boarding_point');
		} else {
		  $this->data['boarding_point'] = 0;
		}
		if(!empty($this->input->post('off_point'))){	
	    	$this->data['off_point'] = $this->input->post('off_point');
		} else {
		    $this->data['off_point'] = 0;
		}

               if(!empty($this->input->post('flight_number'))){       
                 $this->data['flight_number'] = $this->input->post('flight_number');
                } 

                if(!empty($this->input->post('end_flight_number'))){    
                $this->data['end_flight_number'] = $this->input->post('end_flight_number');
                }

		if(!empty($this->input->post('dep_from_date'))){
                          $this->data['dep_from_date'] = date('d-m-Y',$this->input->post('dep_from_date'));
                }


                if(!empty($this->input->post('dep_to_date'))){
                          $this->data['dep_to_date'] = date('d-m-Y',$this->input->post('dep_to_date'));
                }


		if(!empty($this->input->post('from_cabin'))){       
                   $this->data['from_cabin'] = $this->input->post('from_cabin');
                } else {
                  $this->data['from_cabin'] = 0;
                }


                if(!empty($this->input->post('to_cabin'))){    
                $this->data['to_cabin'] = $this->input->post('to_cabin');
                } else {
                    $this->data['to_cabin'] = 0;
                }


		

		$this->data['country'] = $this->rafeed_m->getCodesByType('2');
		$this->data['city'] = $this->rafeed_m->getCodesByType('5');
		$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
		$this->data['airport'] = $this->rafeed_m->getCodesByType('1');
		$this->data['cabin'] = $this->rafeed_m->getCodesByType('13');
		$this->data['flights'] = $this->rafeed_m->getNamesByType('16');
		
		$this->data["subview"] = "fclr/index";
		$this->load->view('_layout_main', $this->data);
	}
	


    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  


		
	    $aColumns = array('flight_number','departure_date','boarding_point','off_point');
	
		$sLimit = "";
		
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{		
			  $sLimit = "LIMIT ".$_GET['iDisplayStart'].",".$_GET['iDisplayLength'];
			}
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$sOrder = "ORDER BY  ";
				for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
				{
					if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
					{
						if($_GET['iSortCol_0'] == 8){
							$sOrder .= " (s.order_no*-1) DESC ,";
						} else {
						 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
							".$_GET['sSortDir_'.$i] .", ";
						}
					}
				}				
				  $sOrder = substr_replace( $sOrder, "", -2 );
				
				if ( $sOrder == "ORDER BY" )
				{
					$sOrder = "";
				}
			}
			$sWhere = "";
			if ( $_GET['sSearch'] != "" )
			{
				$sWhere = "WHERE (";
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
			}
			
			/* Individual column filtering */
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
				}
			}




			if(!empty($this->input->get('boardPoint'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'boarding_point = '.$this->input->get('boardPoint');
                        }
                        if(!empty($this->input->get('offPoint'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'off_point = '.$this->input->get('offPoint');
                        }


			if(!empty($this->input->get('flightNbr'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'flight_number >= '.$this->input->get('flightNbr');
                        }

		
			if(!empty($this->input->get('flightNbrEnd'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'flight_number <= '.$this->input->get('flightNbrEnd');
                        }


			if(!empty($this->input->get('depStartDate'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'departure_date >= '. strtotime($this->input->get('depStartDate'));
                        }
                        if(!empty($this->input->get('depEndDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'departure_date <= '.  strtotime($this->input->get('depEndDate'));
                        }
			if(!empty($this->input->get('fromCabin'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'from_cabin = '. $this->input->get('fromCabin');
                        }
                        if(!empty($this->input->get('toCabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'to_cabin = '.  $this->input->get('toCabin');
                        }


			


$sQuery = " SELECT SQL_CALC_FOUND_ROWS fclr_id,boarding_point, dai.code as carrier_code , off_point, season_id,flight_number, fca.code as fcabin, 
            tca.code as tcabin, CONCAT(dfre.aln_data_value,'(',dfre.code,')') as day_of_week ,
            departure_date, min,max,average,slider_start,from_cabin, to_cabin,
		dbp.code as source_point , dop.code as dest_point
                    FROM VX_aln_fare_control_range  fc
                     LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = fc.boarding_point) 
		     LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = fc.off_point)    
		     LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = fc.carrier_code)
		     LEFT JOIN vx_aln_data_defns dfre on (dfre.vx_aln_data_defnsID = fc.frequency)
		     LEFT JOIN vx_aln_data_defns fca on (fca.vx_aln_data_defnsID = fc.from_cabin)
                     LEFT JOIN vx_aln_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin)

$sWhere $sOrder $sLimit";

//print_r($sQuery);exit;

	$rResult = $this->install_m->run_query($sQuery);
	$sQuery = "SELECT FOUND_ROWS() as total";
	$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $rResultFilterTotal,
		"iTotalDisplayRecords" => $rResultFilterTotal,
		"aaData" => array()
	  );
		foreach ($rResult as $feed ) {
			$boarding_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->boarding_point));
			$feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$boarding_markets.'">'.$feed->source_point.'</a>';
			 $dest_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->off_point));
                        $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$dest_markets.'">'.$feed->dest_point.'</a>';

			$feed->season_id = ($feed->season_id) ? $this->season_m->getSeasonNameByID($feed->season_id) : "default season";
			$feed->departure_date = date('d-m-Y',$feed->departure_date);
                                $output['aaData'][] = $feed;

		}

		
		echo json_encode( $output );
	}
	


	function calculate_Min_Max($fromCabin ,$toCabin ) {

		 $fromCabinAvg = array_sum($fromCabin)/count($fromCabin);
                $toCabinAvg = array_sum($toCabin)/count($toCabin);
                $fromCabinSD = $this->fclr_m->Stand_Deviation($fromCabin);
                $toCabinSD = $this->fclr_m->Stand_Deviation($toCabin);
                $bidAvg = ($fromCabinAvg + $toCabinAvg)/2;
                $bidSD =  sqrt(pow($fromCabinSD,2) + pow($toCabinSD,2));
                $max = $bidAvg + (3 * $bidSD);
                $min = $bidAvg - (3 * $bidSD);

                $feed->average = round($bidAvg,2);
                $feed->min = round($min,2);
                $feed->max = round($max,2);
		$feed->slider_start = round(($min + $bidSD),2); 
		 return  $feed;

 	}


   function generatedata() {

/*	$sQuery = " 
SELECT  boarding_point, carrier_code,off_point, season_id,flight_number, day_of_week , source_point, dest_point , departure_date,  group_concat(code,' ' , price SEPARATOR ';') as code_price  FROM (SELECT dcla.code ,operating_airline_code,season_id, departure_date ,day_of_week ,flight_number, dbp.code as source_point , dop.code as dest_point ,boarding_point,off_point , group_concat(prorated_price)  as price,dai.code as carrier_code   FROM VX_aln_ra_feed rf  LEFT JOIN vx_aln_data_defns dc on (dc.vx_aln_data_defnsID = rf.booking_country)  LEFT JOIN vx_aln_data_defns dci on  (dci.vx_aln_data_defnsID = rf.booking_city) LEFT JOIN vx_aln_data_defns dico on (dico.vx_aln_data_defnsID = rf.issuance_country)  LEFT JOIN vx_aln_data_defns dici on  (dici.vx_aln_data_defnsID = rf.issuance_city) LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  LEFT JOIN vx_aln_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code) LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point) LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) LEFT JOIN vx_aln_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) LEFT JOIN VX_aln_airline_cabin_class acc  on ( acc.carrier = rf.operating_airline_code AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class)   group by dcla.code, day_of_week,flight_number, boarding_point,off_point,season_id,departure_date,operating_airline_code  order by flight_number )  as MainSet group by  boarding_point, off_point, day_of_week, season_id, flight_number, departure_date,operating_airline_code
";*/

$sQuery = " 
SELECT  boarding_point, carrier_code,operating_airline_code,off_point, season_id,flight_number, 
        day_of_week ,departure_date,  group_concat(code,' ', cabin , ' ' , price SEPARATOR ';') as code_price  
        FROM (
               SELECT dcla.code ,operating_airline_code,season_id, cabin ,departure_date ,day_of_week ,flight_number, 
                      boarding_point,off_point , 
                      group_concat(prorated_price)  as price,dai.code as carrier_code   
               FROM VX_aln_ra_feed rf  
               LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  
               LEFT JOIN vx_aln_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code) 
               LEFT JOIN vx_aln_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) 
               LEFT JOIN VX_aln_airline_cabin_class acc  on ( acc.carrier = rf.operating_airline_code 
							AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class) 
		where acc.order > 1   
		group by dcla.code, cabin , day_of_week,flight_number, boarding_point,off_point,season_id,departure_date,operating_airline_code  
		order by flight_number )  as MainSet 
		group by  boarding_point, off_point, day_of_week, season_id, flight_number, departure_date,operating_airline_code
";

        $rResult = $this->install_m->run_query($sQuery);

              foreach ($rResult as $feed ) {
                        $array['season_id'] = $feed->season_id;
			$array['boarding_point'] = $feed->boarding_point;
			$array['off_point'] = $feed->off_point;
			$array['flight_number'] = $feed->flight_number;
			$array['carrier_code'] = $feed->operating_airline_code;
			$array['departure_date'] = $feed->departure_date;
			$array['frequency'] = $feed->day_of_week;

                        $code_price = $feed->code_price;
                        $arr = explode(';', $code_price) ;
                        $cabins['C'] = array();
                        $cabins['Y'] = array();
                        foreach($arr as $f ) {
                                $str = explode(' ' , $f);
                                $cabins[$str[0]][0] = explode(',',$str[2]);
				$cabins[$str[0]][1] = $str[1];
                        }

                // from economy to business (Y->C) 
                  $fromCabin = $cabins['Y'][0]; 
                  $toCabin = $cabins['C'][0];

                        if(count($fromCabin) > 0  AND count($toCabin) > 0 ){
				$array['from_cabin'] = $cabins['Y'][1];
				$array['to_cabin'] = $cabins['C'][1];
                                $data = $this->calculate_Min_Max($fromCabin, $toCabin );
                                $array['average'] = $data->average;
                                $array['min'] = $data->min;
                                $array['max'] = $data->max;
				$array['slider_start'] = $data->slider_start;
				if($this->fclr_m->checkFCLREntry($array)) {
					$array["create_date"] = time();
		                        $array["modify_date"] = time();
                		        $array["create_userID"] = $this->session->userdata('loginuserID');
                        		$array["modify_userID"] = $this->session->userdata('loginuserID');
                                	$this->fclr_m->insert_fclr($array);
				}
				
                         }
                        // from economy to pre-eco

                        $fromCabin =  $cabins['Y'][0];
                        $toCabin = $cabins['W'][0];

                        if(count($fromCabin) > 0  AND count($toCabin) > 0 ){
				 $array['from_cabin'] = $cabins['Y'][1];
                                $array['to_cabin'] = $cabins['W'][1];
                                $feed = $this->calculate_Min_Max($fromCabin, $toCabin );
				$array['average'] = $data->average;
                                $array['min'] = $data->min;
                                $array['max'] = $data->max;
				$array['slider_start'] = $data->slider_start;

				if($this->fclr_m->checkFCLREntry($array)) {
                                        $array["create_date"] = time();
                                        $array["modify_date"] = time();
                                        $array["create_userID"] = $this->session->userdata('loginuserID');
                                        $array["modify_userID"] = $this->session->userdata('loginuserID');
                                        $this->fclr_m->insert_fclr($array);
                                }

				
                         }
                        // from economy to pre-eco

                        $fromCabin =  $cabins['W'][0];
                        $toCabin = $cabins['C'][0];

                        if(count($fromCabin) > 0  AND count($toCabin) > 0 ){
				 $array['from_cabin'] = $cabins['W'][1];
                                 $array['to_cabin'] = $cabins['C'][1];

                                $feed = $this->calculate_Min_Max($fromCabin, $toCabin );

				$array['average'] = $data->average;
                                $array['min'] = $data->min;
                                $array['max'] = $data->max;
				$array['slider_start'] = $data->slider_start;
				if($this->fclr_m->checkFCLREntry($array)) {
                                        $array["create_date"] = time();
                                        $array["modify_date"] = time();
                                        $array["create_userID"] = $this->session->userdata('loginuserID');
                                        $array["modify_userID"] = $this->session->userdata('loginuserID');
                                        $this->fclr_m->insert_fclr($array);
                                }


                         }



                }


		$this->session->set_flashdata('success', $this->lang->line('menu_success'));
                           redirect(base_url("fclr/index"));

   }


}

