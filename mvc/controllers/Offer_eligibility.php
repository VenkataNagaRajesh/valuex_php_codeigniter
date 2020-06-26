<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_eligibility extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("airline_cabin_class_m");
		$this->load->model("offer_eligibility_m");
		$this->load->model("eligibility_exclusion_m");
		$this->load->model("airline_m");
		$this->load->model("bclr_m");
		$this->load->model("season_m");
		$this->load->model("partner_m");
		$this->load->model('paxfeed_m');
		$this->load->model("marketzone_m");
		$this->load->model("fclr_m");
		$this->load->model("seasobclr_m");
		$this->load->model("airports_m");
		$this->load->model("user_m");
		$this->load->model("contract_m");
		$language = $this->session->userdata('lang');
		//$this->load->library('encrypt');
		$this->lang->load('offer_eligibility', $language);	
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


		                $userID = $this->session->userdata('loginuserID');
                $roleID = $this->session->userdata('roleID');
                if($roleID != 1){
						 $this->data['carriers'] = $this->user_m->getUserAirlines($userID);	   
						   } else {
                   $this->data['carriers'] = $this->airline_m->getAirlinesData();
                }


		$this->data['country'] = $this->rafeed_m->getCodesByType('2');
		$this->data['city'] = $this->rafeed_m->getCodesByType('5');
		//$this->data['carriers'] = $this->rafeed_m->getCodesByType('12');
		$this->data['airport'] = $this->rafeed_m->getCodesByType('1');
		$this->data['cabin'] = $this->rafeed_m->getCodesByType('13');
		$this->data['flights'] = $this->rafeed_m->getNamesByType('16');
		$this->data['status'] = $this->rafeed_m->getNamesByType('20');
		

	$roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');

        if($this->session->userdata('roleID') != 1){
                    $this->data['seasonslist'] = $this->season_m->get_seasons_where(null,$this->session->userdata('login_user_airlineID'));
                }else{
                   $this->data['seasonslist'] = $this->season_m->get_seasons();
                }
        if($this->input->post('carrier')){
		   $this->data['carrier'] = $this->input->post('carrier');
	     } else {
		   if($roleID != 1){
             $this->data['carrier'] = $this->session->userdata('default_airline');
		   } else {
			 $this->data['carrier'] = 0;
		   }
         }

		$this->data["subview"] = "offer_eligibility/index";
		$this->load->view('_layout_main', $this->data);
	}
	


    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');	  


		
	    $aColumns = array('dtpfext_id','pext.dtpf_id','pext.fclr_id','sea.season_name','dbp.code','dop.code','pf.pnr_ref','pf.dep_date','dai.code','pf.flight_number',
			 'fdef.cabin','tdef.cabin','dfre.code','fc.average','fc.min','fc.max','fc.slider_start',
			 'bs.aln_data_value','dbp.aln_data_value','dop.aln_data_value','dai.aln_data_value','fdef.desc',
			 'tdef.desc','dfre.aln_data_value','pf.pnr_ref');
	
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
						 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
							".$_GET['sSortDir_'.$i] .", ";
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
                                $sWhere .= 'pf.flight_number >= '.$this->input->get('flightNbr');
                        }

		
			if(!empty($this->input->get('flightNbrEnd'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pf.flight_number <= '.$this->input->get('flightNbrEnd');
                        }


			if(!empty($this->input->get('depStartDate'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pf.dep_date >= '. strtotime($this->input->get('depStartDate'));
                        }
                        if(!empty($this->input->get('depEndDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pf.dep_date <= '.  strtotime($this->input->get('depEndDate'));
                        }
			if(!empty($this->input->get('fromCabin'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'from_cabin = '. $this->input->get('fromCabin');
                        }
                        if(!empty($this->input->get('toCabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'to_cabin = '.  $this->input->get('toCabin');
                        }


			if(!empty($this->input->get('frequency'))){
                               $frstr = $this->input->get('frequency');
				if($frstr === '*' ){
					$frstr = '1234567';
				}
                                $freq = $this->airports_m->getDefnsCodesListByType('14');
                                 if ( $frstr != '0') {
                                        $arr = str_split($frstr);
                                        $freq_str = implode(',',array_map(function($x) use ($freq) { return array_search($x, $freq); }, $arr));
					$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
					$sWhere .= ' pf.frequency IN ( '.$freq_str.' )';
                                  }

                        }


			if(!empty($this->input->get('booking_status'))){
				$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= ' pext.booking_status = '.  $this->input->get('booking_status');
                        }


			  if(!empty($this->input->get('carrier'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= ' pf.carrier_code = '.  $this->input->get('carrier');
                        }


			if(!empty($this->input->get('season'))){
                               $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= ' fc.season_id = '.  $this->input->get('season');
                        }

			




		                  $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID != 1){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'pf.carrier_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';
                }
	


$sQuery = " SELECT SQL_CALC_FOUND_ROWS pext.fclr_id, pext.dtpf_id , pext.dtpfext_id ,
		 boarding_point, dai.code as carrier_code , off_point, season_id,pf.flight_number, fdef.cabin as fcabin, 
            	tdef.cabin as tcabin, dfre.code as day_of_week , sea.season_name,
            	pf.dep_date as departure_date, min,max,average,slider_start,from_cabin, to_cabin,
		dbp.code as source_point , dop.code as dest_point, bs.aln_data_value as booking_status, pext.exclusion_id, 
		pf.pnr_ref
		     from UP_dtpf_ext pext 
		     INNER JOIN VX_daily_tkt_pax_feed pf  on  (pf.dtpf_id = pext.dtpf_id AND pf.is_processed = 1 and pf.active = 1)
		     LEFT JOIN UP_fare_control_range fc on  (pext.fclr_id = fc.fclr_id)
		     LEFT JOIN VX_season sea on (sea.VX_aln_seasonID = fc.season_id )
                     LEFT JOIN  VX_data_defns dbp on (dbp.vx_aln_data_defnsID = pf.from_city AND dbp.aln_data_typeID = 1)  
		     LEFT JOIN VX_data_defns dop on (dop.vx_aln_data_defnsID = pf.to_city AND dop.aln_data_typeID = 1)    
		     LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = pf.carrier_code AND dai.aln_data_typeID = 12)
		     LEFT JOIN VX_data_defns dfre on (dfre.vx_aln_data_defnsID = pf.frequency AND dfre.aln_data_typeID = 14)
		     INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = pf.carrier_code)
		     INNER JOIN VX_data_defns fca on (fca.vx_aln_data_defnsID = fc.from_cabin AND fca.aln_data_typeID = 13 and fca.alias = fdef.level)
		     INNER JOIN VX_airline_cabin_def tdef on (tdef.carrier = pf.carrier_code)
                     INNER JOIN VX_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin AND tca.aln_data_typeID = 13 and tca.alias = tdef.level)
		     INNER JOIN VX_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20)

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

		$rownum = 1 + $_GET['iDisplayStart'];
		foreach ($rResult as $feed ) {
			$feed->sno = $rownum;
			$rownum++;
			$boarding_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->boarding_point));
			$feed->spoint = $feed->source_point;
            $feed->dpoint = $feed->dest_point;		
			$feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$boarding_markets.'">'.$feed->source_point.'</a>';
			 $dest_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->off_point));
                        $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$dest_markets.'">'.$feed->dest_point.'</a>';
               $feed->bstatus = $feed->booking_status;			  
			if($feed->booking_status == 'Excluded') {
				$excl_id = $this->eligibility_exclusion_m->getexclIdForGrpANDCabins($feed->exclusion_id,$feed->from_cabin,$feed->to_cabin);
				$feed->booking_status = '<a href="'.base_url('eligibility_exclusion/index/'.$excl_id).'" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="Rule#'.$feed->exclusion_id.'">'.$feed->booking_status.'</a>';

			}
            $feed->fclrID = $feed->fclr_id;
			$feed->dtpfID = $feed->dtpf_id ;
			$feed->fclr_id = '<a target="_new" style="color:blue;" href="'.base_url('fclr/index/'.$feed->fclr_id).'"  >'.$feed->fclr_id.'</a>';
			$feed->dtpf_id = '<a target="_new" style="color:blue;" href="'.base_url('paxfeed/index/'.$feed->dtpf_id).'"  >'.$feed->dtpf_id.'</a>';

			$feed->season_id = ($feed->season_id) ? $this->season_m->getSeasonNameByID($feed->season_id) : "default";
			$feed->departure_date = date('d-m-Y',$feed->departure_date);
                                $output['aaData'][] = $feed;

		}

		
		if(isset($_REQUEST['export'])){
		  $columns = array("#","PAX Feed ID","FCLR ID","Season","Board Point","Off Point","PNR Reference","Departure Date","Carrier","Flight Number" ,"From Cabin","To Cabin","Frequency","Average","Min","Max","Slider Position","Booking Status");
		  $rows = array("id","dtpfID","fclrID","season_id","spoint","dpoint","pnr_ref","departure_date","carrier_code","flight_number" ,"fcabin","tcabin","day_of_week","average","min","max","slider_start","bstatus");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
	
	function calculateOND($pax_list, $bg_ond_partners) {
		$twentyfourhours =  24*60*60;
		$twelevehours =  12*60*60;
		$eighthours =  8*60*60;
		$current_carrier_code =  'XX';

		foreach (array_keys($pax_list) as $pnr ) {
		$ond = Array();
		$i = 1;
			print "PNR=$pnr----------------------------------------------------------------------------------------------------\n";
			foreach($pax_list[$pnr] as $ckey => $crow) {
				$paxId = $crow['dtpf_id']; 
		echo "\n\nROW=".($ckey+1) . " - SEG=" . $paxId;

				if ($ckey == 0 ) {
					echo "\nFIRST ROW CREATE NEW OND   ======";
					$domesticCountryCode = $crow['get_origin_country_code'];
					$originAiport = $crow['from_city'];
					createOND($i, $paxId);
					continue;
				}


				/* Case 2a check
				If current flight is Domestic & next flight is INTL, then introduce break  
				introduce break; go to next flight;
				*/
				$nfkey = $ckey + 1;	
				$pfkey = $ckey - 1;	
				$pfrow = $pax_list[$pnr][$pfkey];
				$nfrow = $pax_list[$pnr][$nfkey];

				if ( isDomestic($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  isDomestic($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code'])) {
					$checkHours = $eighthours;
					$checkHoursDp = 8;;

				} elseif ((isDomestic($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  isInternational($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code'])) || (isInternational($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  isDomestic($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code']))) {

					$checkHours = $twelevehours;
					$checkHoursDp = 12;;
				} elseif ( isInternational($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  isInternational($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code'])) {
					$checkHours = $twentyfourhours;
					$checkHoursDp = 24;
				}


				if ( ! isPartner($crow['carrier_code'], $current_carrier_code, $bg_ond_partners)) {
					echo "\nCURRENT CARRIER " . $crow['carrier_code'] . " NOT A PARTNER WITH " . $current_carrier_code  . "  ======";
					$i++;
					echo "\nCURRENT CARRIER NOT A PARTNER - NEW OND CREATAED $i  - NO SILDER ======";
					createOND("NOSLIDER", $paxId);
					continue;

				} else {
					echo "\nCURRENT FLIGT CARRIER " . $crow['carrier_code'] . " IS PARTNER WITH " . $current_carrier_code  . "  ======";
				}




				if ( isDomestic($crow['get_origin_country_code'], $crow['get_dest_country_code'])) {
					echo "\nCURRENT IS DOMESTIC  ======";
					if( $pfkey >= 0) { //Prev row exits $pfrow =  $pax_list[$pnr][$pfkey];
						if ( $crow['from_city'] == $pfrow['to_city']) {
							echo "\nCURRENT IS DOMESTIC - CUR CITY " . $crow['from_city'] . " MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							if ((strtotime($crow['total_dep_date']) - strtotime( $pfrow['total_arrival_date'])) < $checkHours) {
								echo "\nCURRENT IS DOMESTIC - WITHIN $checkHoursDp Hrs  ======";
								if ( $crow['to_city'] == $pfrow['from_city'] && $pfrow['from_city'] == $originAiport) {
									echo "\nCURRENT IS DOMESTIC - CUR TO CITY " . $crow['to_city'] . " MATCHED WITH PREV FROM CITY " . $pfrow['from_city']  . "  ======";
									$i++;
									echo "\nCURRENT IS DOMESTIC - NEW OND CREATAED $i ======";
									createOND($i, $paxId);
									continue;
									
								} else {
									echo "\nCURRENT IS DOMESTIC - CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH PREV FROM CITY  " . $pfrow['from_city'] . " START CHECK FARTHER END MATCHES WITH ORIGIN AIPRORT $originAiport !";
									if ( $nfrow && ($crow['to_city'] == $originAiport ||  $nfrow['to_city'] == $originAiport)) {
										if ( $pfrow &&  $pax_list[$pnr][$pfkey-1] )  {
										$i++;
										}
										echo "\nCURRENT IS DOMESTIC - CUR TO CITY ". $crow['to_city']  . "  MATCHED WITH ORIGIN CITY OR  NEXT FLIGHT " . $pfrow['to_city'] . " MATCHED WITH ORIGIN - FARTHER POINT ADDING TO NEW OND $i ======";
										createOND($i, $paxId);
										if ( $pfrow &&  !$pax_list[$pnr][$pfkey-1] ){ 
											#$i++;
											echo "\nCURRENT IS DOMESTIC - FARTHER POINT - JUST 3 ROWS CASE - CREATE OND FOR NEXT ROW $i ======";
										}
										continue;
									} else {
									echo "\nCURRENT IS DOMESTIC - CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH PREV FROM CITY  " . $pfrow['from_city'] . "  ADDING TO PREV OND $i ======";
									createOND($i, $paxId);
									continue;
									}

								}
								
							} else {
								echo "\nCURRENT IS DOMESTIC -BUT MORE THAN $checkHoursDp Hrs  ======";
								$i++;
								echo "\nCURRENT IS DOMESTIC - NEW OND CREATAED $i ======";
								createOND($i, $paxId);
								continue;
							}
					
						} else {
							echo "\nCURRENT IS DOMESTIC - CUR CITY " . $crow['from_city'] . "  NOT MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							$i++;
							echo "\nCURRENT IS DOMESTIC - NEW OND CREATAED $i ======";
							createOND($i, $paxId);
							continue;
						}
					}
						
				} else {
					echo "\nCURRENT IS INTERNATIONAL  ======";
					if( $pfkey >= 0) { //Prev row exits $pfrow =  $pax_list[$pnr][$pfkey];
						if ( $crow['from_city'] == $pfrow['to_city']) {
							echo "\nCURRENT IS INTERNATIONAL - CUR CITY " . $crow['from_city'] . " MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							if ((strtotime($crow['total_dep_date']) - strtotime( $pfrow['total_arrival_date'])) < $checkHours) {
								echo "\nCURRENT IS INTERNATIONAL - WITHIN $checkHoursDp Hrs  ======";
								if ( $crow['to_city'] == $pfrow['from_city'] && $pfrow['from_city'] == $originAiport) {
									echo "\nCURRENT IS INTERNATIONAL - CUR TO CITY " . $crow['to_city'] . " MATCHED WITH PREV FROM CITY " . $pfrow['from_city']  . "  ======";
									$i++;
									echo "\nCURRENT IS INTERNATIONAL - NEW OND CREATAED $i ======";
									createOND($i, $paxId);
									continue;
									
								} else {
									echo "\nCURRENT IS INTERNATIONAL - CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH PREV FROM CITY  " . $pfrow['from_city'] . " START CHECK FARTHER END MATCHES WITH ORIGIN AIPRORT $originAiport !";
									if ( $nfrow && ($crow['to_city'] == $originAiport ||  $nfrow['to_city'] == $originAiport)) {
										if ( $pfrow &&  $pax_list[$pnr][$pfkey-1] )  {
										$i++;
										}
										echo "\nCURRENT IS INTERNATIONAL - CUR TO CITY ". $crow['to_city']  . "  MATCHED WITH ORIGIN CITY OR  NEXT FLIGHT " . $pfrow['to_city'] . " MATCHED WITH ORIGIN - FARTHER POINT ADDING TO NEW OND $i ======";
										createOND($i, $paxId);
										if ( $pfrow &&  !$pax_list[$pnr][$pfkey-1] ){ 
											$i++;
											echo "\nCURRENT IS INTERNATIONAL - FARTHER POINT - JUST 3 ROWS CASE - CREATE OND FOR NEXT ROW $i ======";
										}
										continue;
									} else {
									echo "\nCURRENT IS INTERNATIONAL - CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH PREV FROM CITY  " . $pfrow['from_city'] . "  ADDING TO PREV OND $i ======";
									createOND($i, $paxId);
									continue;
									}
						

								}
								
							} else {
								echo "\nCURRENT IS INTERNATIONAL -BUT MORE THAN $checkHoursDp Hrs  ======";
								$i++;
								echo "\nCURRENT IS INTERNATIONAL - NEW OND CREATAED $i ======";
								createOND($i, $paxId);
								continue;
							}
					
						} else {
							echo "\nCURRENT IS INTERNATIONAL - CUR CITY " . $crow['from_city'] . "  NOT MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							$i++;
							echo "\nCURRENT IS INTERNATIONAL - NEW OND CREATAED $i ======";
							createOND($i, $paxId);
							continue;
						}
					}
				}

			}
			print_r($ond);
			print "PNR $pnr  END=====================================================================================\n";
		}
		return $ond;
	}

	function createOND($ondi, $seg) {
		global $ond;
		global $pax_list;
		$ond[$ondi][] = $seg;
	}


	function isPartner($carrier, $current_carrier_code, $partners) {

		if ( ($current_carrier_code == $carrier ) || in_array($carrier , $partners[$current_carrier_code])) {
			return true;
		} else {
			return false;
		}
	}

	function isDomestic($orgCountry, $destCountry) {
	if ($orgCountry == $destCountry) {
			return true;
		}
		return false;
	}

	function isInternational($orgCountry, $destCountry) {
		if ($orgCountry != $destCountry) {
			return true;
		}
		return false;
	}

	

   function generatedata() {

	# Get Contracts to decide what carrier and what products offers to be generated
	$contracts = $this->contract_m->getActiveContracts();

	foreach($contracts as $contract) {
		echo "<pre>" . print_r($contract,1). "</pre>";
		$this->mydebug->debug(print_r($contract,1));
		$product = $contract->productID;
		$carrierId = $contract->airlineID;

		switch ($product) {
			case 1:
			$this->mydebug->debug("OFFER GEN: PRODUCT UPGRADE : CARRIER ID: " . $carrierId);
   			 #$this->processGenUpgradeOffers($carrierId);
			break;
			case 2:
			$this->mydebug->debug("OFFER GEN: PRODUCT BAGGAGE : CARRIER ID: " . $carrierId);
   			 $this->processGenBaggageOffers($carrierId);
			break;
		}
			
	}

		
   }

   function processGenBaggageOffers($carrierId) {
		$carrierId = 5500;
		echo ("OFFER GEN: PROCESS BAGGAGE : CARRIER ID: " . $carrierId);

		$this->mydebug->debug("OFFER GEN: PROCESS BAGGAGE : CARRIER ID: " . $carrierId);

		$days = $this->preference_m->get_application_preference_value('OFFER_ISSUE_WINDOW','7');
                $current_time = time();
                $tstamp = $current_time + ($days * 86400);
                $tstamp = 0;//For testing
		
		//$id = $this->airline_cabin_class_m->checkCarrierDataByID($id);
		# GET  PAXA FEED OF PTC TYPE ADT  ADULT , exclude UNN and NON-REV of speicific Class
		# FILTER 
		$bg_pax_data = $this->offer_eligibility_m->getBaggagePaxData($carrierId, $tstamp);
		$bg_partners = $this->partner_m->getPartnerCarriers($carrierId);
		foreach($bg_partners as $partner) {
			$bg_ond_partners[$carrierId][]= $partner->partner_carrierID;
		}
			echo "<br>PARTNERS=<pre>" . print_r($bg_partners,1) . "</pre>";
		

		$pax_ond = Array();
		foreach ($bg_pax_data as $pax_pnr_single ) {
			echo "<br>SINGLEPNR=<pre>" . print_r($pax_pnr_single,1) . "</pre>";
			$single_adult_full_pax = $this->offer_eligibility_m->getBaggageSingleAdultPax($pax_pnr_single);
			echo "<br>FULLPAX=<pre>" . print_r($single_adult_full_pax,1) . "</pre>";
			foreach ($single_adult_full_pax as $s_pax ) {
			    $pnr = $this->pnr_ref;
			    $pax_list[$pnr]['from_city'] =  $s_pax->from_city;
			    $pax_list[$pnr]['to_city'] =  $s_pax->to_city;
			    $pax_list[$pnr]['total_dep_date'] =  $s_pax->dep_date;
			    $pax_list[$pnr]['total_arrival_date'] =  $s_pax->arrival_date;
			    $pax_list[$pnr]['carrier_code'] =  $s_pax->carrier_code;
			    $pax_list[$pnr]['pax_nbr'] =  $s_pax->carrier_code;
			    $pax_list[$pnr]['seg_nbr'] =  $s_pax->seg_nbr;
			    $pax_list[$pnr]['get_origin_country_code'] =  $s_pax->from_country;
			    $pax_list[$pnr]['get_dest_country_code'] =  $s_pax->to_country;
			    $pax_list[$pnr]['get_origin_city_ocde'] =  $s_pax->from_city;
			    $pax_list[$pnr]['get_dest_city_ocde'] =  $s_pax->to_city;
			    $pax_list[$pnr]['flight_number'] =  $s_pax->flight_number;
			    $pax_list[$pnr]['dtpf_id'] =  $s_pax->dtpf_id;
			}

			$pax_ond[] =  $this->calculateOND($pax_list, $bg_ond_partners);
		}

		#Determine matching BCLR for all OND  
		$rules = $this->bclr_m->get_bclr();
		foreach($pax_ond as $ond) {

			 $ext = array();
					$ext['dtpf_id'] = $feed->dtpf_id;
					$ext["create_date"] = time();
					$ext["modify_date"] = time();
					$ext["create_userID"] = $this->session->userdata('loginuserID');
					$ext["modify_userID"] = $this->session->userdata('loginuserID');
			$matched = 0;
			if(count($rules) > 0 ) {
				foreach ( $rules  as $rule ) {
					$query = $this->eligibility_exclusion_m->apply_exclusion_rules(1);
					$query .= ' AND eexcl_id = ' .$rule->eexcl_id;

					if ($rule->orig_level != NULL) {
						$query .= ' AND  (FIND_IN_SET('.$feed->from_city.', orig_level))';
					}
					if ($rule->dest_level != NULL) {
						$query .= ' AND  (FIND_IN_SET('.$feed->to_city.',dest_level))';

					}

					if($rule->frequency != '0' ) {

						$query .= ' AND (FIND_IN_SET('.$p_freq.',frequency))';

					}

					if($rule->flight_efec_date != 0 AND $rule->flight_disc_date != 0 ){

						$date_format =  date('d-m', $feed->dep_date);
						$current_year =  date("Y");
						$prv_year = $current_year - 1;
						$current_yr_date = strtotime($date_format.'-'.$current_year);
						$old_yr_date = strtotime($date_format.'-'.$prv_year);

						$query .= " AND ((flight_efec_date <= ".$current_yr_date." AND flight_disc_date >= " . $current_yr_date . ") OR (flight_efec_date <= ".$old_yr_date." AND flight_disc_date >= "  . $old_yr_date.")) ";

					}

					if($rule->carrier != 0 ) {
						$query .= " AND  (carrier = ".$feed->carrier_code. ")";

					}

					if($rule->flight_nbr_start != '0' AND $rule->flight_nbr_end != 0 ) {
						$query .= " AND  (flight_nbr_start <= ". $feed->flight_number. " and flight_nbr_end >= " . $feed->flight_number. ")";

					}
					
					if($rule->upgrade_from_cabin_type != 0  AND $rule->upgrade_to_cabin_type != 0 ) {
						$query .= " AND ( upgrade_from_cabin_type = " .$f->from_cabin. "  AND upgrade_to_cabin_type = " .$f->to_cabin. " ) ";
					}


					if($rule->flight_dep_start != -1 AND $rule->flight_dep_end != -1 ) {

						$query .= " AND (flight_dep_start <= ".$feed->dept_time." and flight_dep_end >= ".$feed->dept_time.")";
					}

						$result = $this->install_m->run_query($query);
						if(count($result) > 0 ) {	
							$matched = $result[0]->excl_grp;
							break;
						  }
				}

				if($matched > 0 ) {
					$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
					$ext['exclusion_id'] = $matched;
					$this->offer_eligibility_m->insert_dtpfext($ext);

				}else {
						$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
							$this->offer_eligibility_m->insert_dtpfext($ext);

				}

			}else {
				$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
				$this->offer_eligibility_m->insert_dtpfext($ext);
			}
		 }

	}
 	

   function processGenUpgradeOffers($carrierId) {


		$days = $this->preference_m->get_application_preference_value('OFFER_ISSUE_WINDOW','7');

                $current_time = time();
                $tstamp = $current_time + ($days * 86400);


		$sQuery = " SELECT * FROM VX_daily_tkt_pax_feed  WHERE is_processed = 0  AND dep_date >= ".$tstamp." AND carrier_code = $carrierId by dtpf_id";
		$rResult = $this->install_m->run_query($sQuery);

		/*$exclQuery = "SELECT * from VX_aln_eligibility_excl_rules ";
		$excl = $this->install_m->run_query($exclQuery);*/
/*
		$fclrQuery = " SELECT  boarding_point, off_point,flight_number,  group_concat(price SEPARATOR ';') as code_price           FROM (                select boarding_point, off_point , flight_number , group_concat(fca.code,' ' , tca.code ,' min ', min, ' max ' , max,' average ', average ,' slider_start ' , slider_start) as price from VX_aln_fare_control_range fc LEFT JOIN vx_aln_data_defns fca on (fca.vx_aln_data_defnsID = fc.from_cabin)  LEFT JOIN vx_aln_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin) group by boarding_point ,off_point,flight_number,from_cabin,to_cabin)  as MainSet                  group by  boarding_point, off_point, flight_number
 " ;
		$fclr = $this->install_m->run_query($fclrQuery);*/

	foreach ($rResult as $feed ) {

		//update record it is processed

		$this->paxfeed_m->update_paxfeed(array('is_processed' => '1'), $feed->dtpf_id);
		$cabin = $this->airline_cabin_class_m->getCabinFromClassForCarrier($feed->carrier_code,$feed->class);

		/*
		$array = array();
		$array['from_city'] = $feed->from_city;
		$array['to_city'] = $feed->to_city;
		$array['flight_number'] = $feed->flight_number;
		$array['dep_date'] = $feed->dep_date;
		$array['carrier'] = $feed->carrier_code;
		//$array['dep_time'] = $feed->dep_time;*/
		//$rules = $this->eligibility_exclusion_m->apply_exclusion_rules($array);
			
			$upgrade = array();
			$upgrade['boarding_point'] = $feed->from_city;
                        $upgrade['off_point'] = $feed->to_city;
                        $upgrade['flight_number'] = $feed->flight_number;
                        $upgrade['carrier_code'] = $feed->carrier_code;

			$day_of_week = date('w', $feed->dep_date); 
                        $day = ($day_of_week)?$day_of_week:7;

                        $p_freq =  $this->rafeed_m->getDefIdByTypeAndCode($day,'14'); //507;
                        $upgrade['season_id'] =  $this->season_m->getSeasonForDateANDAirlineID($feed->dep_date,$feed->carrier_code,$feed->from_city,$feed->to_city); //0;
			

			 $upgrade['from_cabin'] = $feed->cabin;
                        $data = array();
                        if($upgrade['season_id'] > 0) {
                                $data = $this->fclr_m->getUpgradeCabinsData($upgrade);
                        }

                         if((count($data) == 0 && $upgrade['season_id'] > 0) || $upgrade['season_id'] == 0) {
                                $upgrade['season_id'] = 0;
                                 $upgrade['frequency'] = $p_freq;
                                $data = $this->fclr_m->getUpgradeCabinsData($upgrade);

                          }

                         //$data = $this->fclr_m->getUpgradeCabinsData($upgrade);
			$rules = $this->eligibility_exclusion_m->apply_exclusion_rules();
			 foreach($data as $f) {

				 $ext = array();
                                                $ext['dtpf_id'] = $feed->dtpf_id;
                                                $ext['fclr_id'] = $f->fclr_id;
                                                $ext["create_date"] = time();
                                                $ext["modify_date"] = time();
                                                $ext["create_userID"] = $this->session->userdata('loginuserID');
                                                $ext["modify_userID"] = $this->session->userdata('loginuserID');
				$matched = 0;
				if(count($rules) > 0 ) {
					foreach ( $rules  as $rule ) {
						$query = $this->eligibility_exclusion_m->apply_exclusion_rules(1);
						$query .= ' AND eexcl_id = ' .$rule->eexcl_id;
	
						if ($rule->orig_level != NULL) {
							$query .= ' AND  (FIND_IN_SET('.$feed->from_city.', orig_level))';
						}
						if ($rule->dest_level != NULL) {
							$query .= ' AND  (FIND_IN_SET('.$feed->to_city.',dest_level))';

						}

						if($rule->frequency != '0' ) {

							$query .= ' AND (FIND_IN_SET('.$p_freq.',frequency))';

						}

						if($rule->flight_efec_date != 0 AND $rule->flight_disc_date != 0 ){

							$date_format =  date('d-m', $feed->dep_date);
					                $current_year =  date("Y");
                					$prv_year = $current_year - 1;
                 					$current_yr_date = strtotime($date_format.'-'.$current_year);
                 					$old_yr_date = strtotime($date_format.'-'.$prv_year);

							$query .= " AND ((flight_efec_date <= ".$current_yr_date." AND flight_disc_date >= " . $current_yr_date . ") OR (flight_efec_date <= ".$old_yr_date." AND flight_disc_date >= "  . $old_yr_date.")) ";
	
						}

						if($rule->carrier != 0 ) {
							$query .= " AND  (carrier = ".$feed->carrier_code. ")";
	
						}
	
						if($rule->flight_nbr_start != '0' AND $rule->flight_nbr_end != 0 ) {
							$query .= " AND  (flight_nbr_start <= ". $feed->flight_number. " and flight_nbr_end >= " . $feed->flight_number. ")";

						}
						
						if($rule->upgrade_from_cabin_type != 0  AND $rule->upgrade_to_cabin_type != 0 ) {
							$query .= " AND ( upgrade_from_cabin_type = " .$f->from_cabin. "  AND upgrade_to_cabin_type = " .$f->to_cabin. " ) ";
						}


						if($rule->flight_dep_start != -1 AND $rule->flight_dep_end != -1 ) {

							$query .= " AND (flight_dep_start <= ".$feed->dept_time." and flight_dep_end >= ".$feed->dept_time.")";
						}

							$result = $this->install_m->run_query($query);
							if(count($result) > 0 ) {	
								$matched = $result[0]->excl_grp;
								break;
							  }
					}

					if($matched > 0 ) {
						$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
                                                $ext['exclusion_id'] = $matched;
                                                $this->offer_eligibility_m->insert_dtpfext($ext);

					}else {
							$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
                                                                $this->offer_eligibility_m->insert_dtpfext($ext);

					}

				}else {
			        	$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
					$this->offer_eligibility_m->insert_dtpfext($ext);
				}
			 }

/*	
		if(count($rules) > 0 ) {
			// rule matches partially check for the cabins that are excluded
			foreach($rules as $rule ) {
				//var_dump($rule);
				//echo "<br> <br>";
				//var_dump($data);exit;
				foreach($data as $f) {
						$rule_freq= explode(',',$rule->frequency);
						$ext = array();
						$ext['dtpf_id'] = $feed->dtpf_id;
                                                $ext['fclr_id'] = $f->fclr_id;
						$ext["create_date"] = time();
                                                 $ext["modify_date"] = time();
                                                $ext["create_userID"] = $this->session->userdata('loginuserID');
                                                 $ext["modify_userID"] = $this->session->userdata('loginuserID');
				if($f->from_cabin == $rule->upgrade_from_cabin_type && $f->to_cabin == $rule->upgrade_to_cabin_type  &&
						($f->season_id > 0 || in_array($f->frequency,$rule_freq))) {
                                                $ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
						$ext['exclusion_id'] = $rule->eexcl_id;
                                                 $this->offer_eligibility_m->insert_dtpfext($ext);
	
						 
				} else {
                                                $ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
                                                 $this->offer_eligibility_m->insert_dtpfext($ext);

				}
			}
		    } 
		 } else {
			//insert pax not excluded
                                        foreach($data as $f) {
                                                // cabins Y, W we have to insert
                                                // y->c,  W->C, Y-> W
                                                        // insert records ext table 
						$ext = array();
						$ext['dtpf_id'] = $feed->dtpf_id;
						$ext['fclr_id'] = $f->fclr_id;
						$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
						$ext["create_date"] = time();
                		                $ext["modify_date"] = time();
		                                $ext["create_userID"] = $this->session->userdata('loginuserID');
                                                $ext["modify_userID"] = $this->session->userdata('loginuserID');
                                                $this->offer_eligibility_m->insert_dtpfext($ext);

					}	
	        }
		*/

	}

		$this->session->set_flashdata('success', $this->lang->line('menu_success'));
                           redirect(base_url("offer_eligibility/index"));


	}
	public function offdtlpage() {		
		$this->data["subview"] = "offer_eligibility/offdtlpage";
		$this->load->view('_layout_main', $this->data);
	}
}

