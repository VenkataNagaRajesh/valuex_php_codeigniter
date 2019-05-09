<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fclr extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("fclr_m");
		$this->load->model("season_m");
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

                if(!empty($this->input->post('class'))){
                $this->data['cla'] = $this->input->post('class');
                } else {
                    $this->data['cla'] = 0;
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
			
			$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
			$sWhere .= " acc.order > 1 ";
$sQuery = " 
SELECT  boarding_point, off_point, season_id,flight_number, day_of_week , source_point, dest_point ,  group_concat(code,' ' , price SEPARATOR ';') as code_price  FROM (SELECT dcla.code ,season_id, day_of_week ,flight_number, dbp.code as source_point , dop.code as dest_point ,boarding_point,off_point , group_concat(prorated_price)  as price   FROM VX_aln_ra_feed rf  LEFT JOIN vx_aln_data_defns dc on (dc.vx_aln_data_defnsID = rf.booking_country)  LEFT JOIN vx_aln_data_defns dci on  (dci.vx_aln_data_defnsID = rf.booking_city) LEFT JOIN vx_aln_data_defns dico on (dico.vx_aln_data_defnsID = rf.issuance_country)  LEFT JOIN vx_aln_data_defns dici on  (dici.vx_aln_data_defnsID = rf.issuance_city) LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  LEFT JOIN vx_aln_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code) LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point) LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) LEFT JOIN vx_aln_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) LEFT JOIN VX_aln_airline_cabin_class acc  on ( acc.carrier = rf.operating_airline_code AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class)  " . $sWhere. "  group by dcla.code, day_of_week,flight_number, boarding_point,off_point,season_id  order by flight_number )  as MainSet 

 group by  boarding_point, off_point, day_of_week, season_id, flight_number
                $sOrder
                $sLimit
";
//print_r($sQuery);exit;

/*		$sQuery = " SELECT SQL_CALC_FOUND_ROWS dcla.code as cabin_code , season_id, day_of_week ,
			   flight_number,boarding_point,off_point,pax_type,
			   group_concat(prorated_price)  as prorated_price
                           FROM VX_aln_ra_feed rf  
                          LEFT JOIN vx_aln_data_defns dc on (dc.vx_aln_data_defnsID = rf.booking_country) 
                          LEFT JOIN vx_aln_data_defns dci on  (dci.vx_aln_data_defnsID = rf.booking_city) 
			  LEFT JOIN vx_aln_data_defns dico on (dico.vx_aln_data_defnsID = rf.issuance_country) 
                          LEFT JOIN vx_aln_data_defns dici on  (dici.vx_aln_data_defnsID = rf.issuance_city)
                          LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  
			  LEFT JOIN vx_aln_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code)
                          LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point)  
                          LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) 
                          LEFT JOIN vx_aln_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) 
			  LEFT JOIN VX_aln_airline_cabin_class acc  
				on ( acc.carrier = rf.operating_airline_code AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class)
 
		$sWhere GROUP BY dcla.code,day_of_week,flight_number, boarding_point,off_point,season_id
		$sOrder
		$sLimit	";  */
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
			$feed->season_id = $this->season_m->getSeasonNameByID($feed->season_id);
			$code_price = $feed->code_price;
			$arr = explode(';', $code_price) ;
			$cabins['C'] = array();
			$cabins['Y'] = array();
			foreach($arr as $f ) {
				$str = explode(' ' , $f);
				$cabins[$str[0]] = explode(',',$str[1]);
			}
			
		// from economy to business (Y->C) 
                  $fromCabin = $cabins['Y'];
                  $toCabin = $cabins['C'];

			if(count($fromCabin) > 0  AND count($toCabin) > 0 ){
				$data = $this->calculate_Min_Max($fromCabin, $toCabin );
				$feed->average = $data->average;
				$feed->min = $data->min;
				$feed->max = $data->max;
				$feed->from_cabin = 'Y';
				$feed->to_cabin = 'C';
				$output['aaData'][] = $feed;
			 }
			// from economy to pre-eco

			$fromCabin =  $cabins['Y'];
			$toCabin = $cabins['W'];

			if(count($fromCabin) > 0  AND count($toCabin) > 0 ){
                                $feed = $this->calculate_Min_Max($fromCabin, $toCabin );
				$feed->average = $data->average;
                                $feed->min = $data->min;
                                $feed->max = $data->max;
                                $feed->from_cabin = 'Y';
                                $feed->to_cabin = 'W';
                                $output['aaData'][] = $feed;
                         }



			// from economy to pre-eco

                        $fromCabin =  $cabins['W'];
                        $toCabin = $cabins['C'];

                        if(count($fromCabin) > 0  AND count($toCabin) > 0 ){
                                $feed = $this->calculate_Min_Max($fromCabin, $toCabin );

				$feed->average = $data->average;
                                $feed->min = $data->min;
                                $feed->max = $data->max;

                                $feed->from_cabin = 'W';
                                $feed->to_cabin = 'C';
                                $output['aaData'][] = $feed;
                         }



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

                $feed->average = $bidAvg;
                $feed->min = $min;
                $feed->max = $max;
		 return  $feed;

 	}
   function generatedata() {
		$fromCabin = $this->fclr_m->getFareDataForGivenID('Y');
	
		$toCabin = $this->fclr_m->getFareDataForGivenID('C');

		$fromCabinAvg = array_sum($fromCabin)/count($fromCabin);
		$toCabinAvg = array_sum($toCabin)/count($toCabin);
		$fromCabinSD = $this->fclr_m->Stand_Deviation($fromCabin);
		$toCabinSD = $this->fclr_m->Stand_Deviation($toCabin);
		$bidAvg = ($fromCabinAvg + $toCabinAvg)/2;
		$bidSD =  sqrt(pow($fromCabinSD,2) + pow($toCabinSD,2));
		$max = $bidAvg + (3 * $bidSD);
		$min = $bidAvg - (3 * $bidSD);

		echo "Upgrade From Avg " . $fromCabinAvg. " SD= " . $fromCabinSD . "<br>";
		echo "Upgrade To AVG " . $toCabinAvg . "SD= " . $toCabinSD . "<br>" ;
		echo "BID AVG " . $bidAvg . "SD=" . $bidSD . "<br>";
		echo "min= ". $min . " max= " . $max . "<br>";
   }


}

