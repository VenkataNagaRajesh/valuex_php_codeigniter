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
		$this->load->model("bid_m");
		$this->load->model("season_m");
		$this->load->model("partner_m");
		$this->load->model('paxfeed_m');
		$this->load->model("marketzone_m");
		$this->load->model("bclr_m");
		$this->load->model("fclr_m");
		$this->load->model("season_m");
		$this->load->model("airports_m");
		$this->load->model("product_m");
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
	
		if(!empty($this->input->post('name'))){	
			$this->data['name'] = $this->input->post('name');
		} else {
		    $this->data['name'] = 0;
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
		$this->data['product_name'] = $this->product_m->productName();
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


		
	    $aColumns = array('dtpfext_id', 'pf.carrier_code','pext.rule_id', 'pext.dtpf_id', 'pext.product_id', 'sea.season_name','dbp.code','dop.code','pf.pnr_ref','pf.dep_date','dai.code','pf.flight_number',
			 'fca.aln_data_value','tca.aln_data_value','dfre.code','fc.average','fc.min','fc.max','fc.slider_start',
			 'bs.aln_data_value','dbp.aln_data_value','dop.aln_data_value','dai.aln_data_value','fdef.desc',
			 'tdef.desc','dfre.aln_data_value','pf.pnr_ref', 'pext.ond', 'of.offer_id');
	
		$sLimit = "";
		
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{		
			  $sLimit = "LIMIT ".$_GET['iDisplayStart'].",".$_GET['iDisplayLength'];
			}
			$sOrder = "ORDER BY  ";
			if ( isset( $_GET['iSortCol_0']) &&  $_GET['iSortCol_0'] != 0   )
			{
				for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
				{
					if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
					{
						 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
							".$_GET['sSortDir_'.$i] .", ";
					}
				}				
				  $sOrder = substr_replace( $sOrder, "", -2 );
				
				if ( $sOrder == "ORDER BY  " )
				{
					$sOrder .= " dtpf_id ";

				}
			} else {
				$sOrder .= "  of.offer_id DESC, pf.pnr_ref ASC, pext.product_id ASC, pext.ond ASC ";
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
						// var_dump($this->input->get('name'));
						// die();
						if(!empty($this->input->get('name'))){
							$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
							$sWhere .= 'productID = '.$this->input->get('name');
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


			if(!empty($this->input->get('offer_status'))){
				$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= ' of.offer_status = '.  $this->input->get('offer_status');
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
                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                $sWhere .= " pext.active = 1 ";
	


$sQuery = " SELECT SQL_CALC_FOUND_ROWS pext.rule_id, of.offer_id, vp.name as product_offer_type, pext.product_id, pext.ond, pext.dtpf_id , pext.dtpfext_id ,
		 boarding_point, dai.code as carrier_code , off_point, fc.season_id,pf.flight_number, fdef.cabin as fcabin, 
            	tdef.cabin as tcabin, dfre.code as day_of_week , sea.season_name,
            	pf.dep_date as departure_date, min,max,average,slider_start,fdef.cabin as from_cabin, tdef.cabin as to_cabin,
		dbp.code as source_point , dop.code as dest_point, bs.aln_data_value as booking_status, pext.exclusion_id, 
		pf.pnr_ref , bc.min_unit, bc.max_capacity, bc.min_price, bc.max_price,  os.aln_data_value as offer_status
		     from VX_offer_info pext 
		     LEFT JOIN VX_daily_tkt_pax_feed pf  on  (pf.dtpf_id = pext.dtpf_id)
		     LEFT JOIN UP_fare_control_range fc on  (pext.rule_id = fc.fclr_id AND fc.carrier_code = pf.carrier_code AND pext.product_id = 1)
		     LEFT JOIN BG_baggage_control_rule bc on  (pext.rule_id = bc.bclr_id AND bc.carrierID = pf.carrier_code AND pext.product_id = 2)
		     LEFT JOIN VX_season sea on (sea.VX_aln_seasonID = fc.season_id )
		     LEFT JOIN VX_offer of on (of.pnr_ref = pf.pnr_ref AND pext.product_id = of.product_id )
		     LEFT JOIN VX_products vp on (vp.productID = pext.product_id )
             LEFT JOIN VX_data_defns dbp on (dbp.vx_aln_data_defnsID = pf.from_city AND dbp.aln_data_typeID = 1)  
		     LEFT JOIN VX_data_defns dop on (dop.vx_aln_data_defnsID = pf.to_city AND dop.aln_data_typeID = 1)    
		     LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = pf.carrier_code AND dai.aln_data_typeID = 12)
		     LEFT JOIN VX_data_defns dfre on (dfre.vx_aln_data_defnsID = pf.frequency AND dfre.aln_data_typeID = 14)
		     LEFT JOIN VX_data_defns fca on (fca.vx_aln_data_defnsID = pf.cabin AND fca.aln_data_typeID = 13 )
		     LEFT JOIN VX_airline_cabin_def fdef on (fdef.carrier = pf.carrier_code  AND fca.alias = fdef.level)
             LEFT JOIN VX_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin AND tca.aln_data_typeID = 13 )
		     LEFT JOIN VX_airline_cabin_def tdef on (tdef.carrier = pf.carrier_code AND tca.alias = tdef.level)
		     LEFT JOIN VX_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20)
		     LEFT JOIN VX_data_defns os on (os.vx_aln_data_defnsID = of.offer_status AND bs.aln_data_typeID = 20)

$sWhere $sOrder $sLimit";
//print_r($sQuery) ;exit;

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
                   	$feed->action .=  '<a target="_blank" href="' . base_url('offer_eligibility/processOfferPerPnr/' . $feed->dtpf_id) . '" class="btn btn-primary btn-xs mrg"  data-placement="top" data-toggle="tooltip" data-original-title="MANUAL OFFER PROCESS PER PNR"><i class="fa fa-check"></i></a>';
			$boarding_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->boarding_point));
			$feed->spoint = $feed->source_point;
		        $feed->dpoint = $feed->dest_point;		
			$feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$boarding_markets.'">'.$feed->source_point.'</a>';
			$dest_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->off_point));
                        $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$dest_markets.'">'.$feed->dest_point.'</a>';
               		$feed->bstatus = $feed->offer_status;			  
			if($feed->booking_status == 'Excluded') {
				$excl_id = $this->eligibility_exclusion_m->getexclIdForGrpANDCabins($feed->exclusion_id,$feed->from_cabin,$feed->to_cabin);
				$feed->offer_status = '<a href="'.base_url('eligibility_exclusion/index/'.$excl_id).'" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="Rule#'.$feed->exclusion_id.'">'.$feed->booking_status.'</a>';

			}
            $feed->fclrID = $feed->rule_id;
			$feed->dtpfID = $feed->dtpf_id ;
			if ($feed->product_id == 1) {
				$prod_c = 'fclr';
				$rule_title = 'FCLR ID ' . $feed->rule_id . ': MIN - ' . $feed->min . ', MAX - ' . $feed->max . ', AVG - ' . $feed->average . ', SLIDER START POISTION - ' . $feed->slider_start;
			} elseif ($feed->product_id == 2) {
				$prod_c = 'bclr';
				$rule_title = 'BCLR ID: ' . $feed->rule_id . ': MIN UNIT - ' . $feed->min_unit . ', MAX CAPACITY - ' . $feed->max_capacity . ', MIN. PRICE - ' . $feed->min_price . ', MAX PRICE - ' . $feed->max_price;
			}
			if ( $feed->rule_id ) {
				$feed->rule_id = '<div><a target="_new" data-toggle="tooltip" data-container="body" title="'. $rule_title. '"  style="color:blue;" href="'.base_url($prod_c . '/index/'.$feed->rule_id).'"  >'.$feed->rule_id.'</a></div>';
			} else {
				$feed->rule_id = '&nbsp;';
			}
			$feed->offer_id = '<a target="_new" style="color:blue;" href="'.base_url('offer_issue/view/'.$feed->pnr_ref).'"  >'.$feed->offer_id.'</a>';
			$feed->dtpf_id = '<a target="_new" style="color:blue;" href="'.base_url('paxfeed/index/'.$feed->dtpf_id).'"  >'.$feed->dtpf_id.'</a>';

			$feed->season_id = ($feed->season_id) ? $this->season_m->getSeasonNameByID($feed->season_id) : (($feed->product_id == 1) ? "default" : "");
			$feed->departure_date = date('d-m-Y',$feed->departure_date);
                                $output['aaData'][] = $feed;

		}

		
		if(isset($_REQUEST['export'])){
		  $columns = array("#","PAX Feed ID","RULE_ID", "OFFER_ID", "OFFER TYPE", "OND",  "Season","Board Point","Off Point","PNR Reference","Departure Date","Carrier","Flight Number" ,"From Cabin","To Cabin","Frequency","Average","Min","Max","Slider Position","Booking Status");
		  $rows = array("id","dtpfID","rule_id","product_offer_type", "OND", "offer_id", "season_id","spoint","dpoint","pnr_ref","departure_date","carrier_code","flight_number" ,"fcabin","tcabin","day_of_week","average","min","max","slider_start","bstatus");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
	
	function calculateOND($pax_list, $bg_ond_partners) {
		$twentyfourhours =  24*60*60;
		$twelevehours =  12*60*60;
		$eighthours =  8*60*60;
		#$current_carrier_code =  'XX';

		foreach (array_keys($pax_list) as $pnr ) {
		$ond = Array();
		$i = 1;
			print "PNR=$pnr----------------------------------------------------------------------------------------------------<br>\n";
			foreach($pax_list[$pnr] as $ckey => $crow) {
				$paxId = $crow['dtpf_id']; 
		echo "<br>\n<br>\nROW=".($ckey+1) . " - SEG=" . $paxId;

				if ($ckey == 0 ) {
					echo "<br><br>\nFIRST ROW CREATE NEW OND   ======";
					$current_carrier_code = $crow['carrier_code'];
					$domesticCountryCode = $crow['get_origin_country_code'];
					$originAiport = $crow['from_city'];
					$originDistance = $crow['distance'];
					$ond = $this->createOND($ond,$i, $paxId);
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

				if ( $this->isDomestic($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  $this->isDomestic($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code'])) {
					$checkHours = $eighthours;
					$checkHoursDp = 8;;

				} elseif (($this->isDomestic($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  $this->isInternational($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code'])) || ($this->isInternational($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  $this->isDomestic($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code']))) {

					$checkHours = $twelevehours;
					$checkHoursDp = 12;;
				} elseif ( $this->isInternational($crow['get_origin_country_code'], $crow['get_dest_country_code']) &&  $this->isInternational($pfrow['get_origin_country_code'], $pfrow['get_dest_country_code'])) {
					$checkHours = $twentyfourhours;
					$checkHoursDp = 24;
				}


				if ( ! $this->isPartner($crow['carrier_code'], $current_carrier_code, $bg_ond_partners)) {
					echo "<br>\n<br>CURRENT CARRIER " . $crow['carrier_code'] . " NOT A PARTNER WITH " . $current_carrier_code  . "  ======";
					$i++;
					echo "<br>\n<br>CURRENT CARRIER NOT A PARTNER - NEW OND CREATAED $i  - NO SILDER ======";
					$ond = $this->createOND($ond,"NP", $paxId); //NOT A PARTNER
				
					continue;

				} else {
					echo "<br>\n<br>CURRENT FLIGT CARRIER " . $crow['carrier_code'] . " IS PARTNER WITH " . $current_carrier_code  . "  ======";
				}




				if ( $this->isDomestic($crow['get_origin_country_code'], $crow['get_dest_country_code'])) {
					echo "<br>\nCURRENT IS DOMESTIC  ======";
					if( $pfkey >= 0) { //Prev row exits $pfrow =  $pax_list[$pnr][$pfkey];
						if ( $crow['from_city'] == $pfrow['to_city']) {
							echo "<br>\nCURRENT IS DOMESTIC - CUR CITY " . $crow['from_city'] . " MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							if ((($crow['total_dep_date']) - ( $pfrow['total_arrival_date'])) < $checkHours) {
								echo "<br>\nCURRENT IS DOMESTIC - WITHIN $checkHoursDp Hrs, DEP=" . ($crow['total_dep_date']) . ",ARR=" .  ( $pfrow['total_arrival_date']). "  ======";
								if ( $crow['to_city'] == $pfrow['from_city'] && $pfrow['from_city'] == $originAiport) {
									echo "<br>\nCURRENT IS DOMESTIC - CUR TO CITY " . $crow['to_city'] . " MATCHED WITH PREV FROM CITY " . $pfrow['from_city']  . "  ======";
									$i++;
									echo "<br>\nCURRENT IS DOMESTIC - NEW OND CREATAED $i ======";
									$ond = $this->createOND($ond,$i, $paxId);
									continue;
									
								} else {
									echo "<br>\nCURRENT IS DOMESTIC - CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH PREV FROM CITY  " . $pfrow['from_city'] . " START CHECK FARTHER END MATCHES WITH ORIGIN AIPRORT $originAiport !";
									if ( !$nfrow && ($crow['to_city'] == $originAiport && $crow['distance'] == $originDistance)) {
										$i++;
										echo "<br>\nCURRENT IS DOMESTIC - CUR TO CITY ". $crow['to_city']  . "  MATCHED WITH ORIGIN CITY OR  NEXT FLIGHT " . $pfrow['to_city'] . " MATCHED WITH ORIGIN - FARTHER POINT ADDING TO NEW OND $i ======";
										$ond = $this->createOND($ond,$i, $paxId);
										continue;
									} else {
										echo "<br>\nCURRENT IS DOMESTIC - DISTANCE CASE ";
										if ( ($crow['to_city'] != $originAiport) && ($crow['distance'] && $pfrow['distance'] && ($crow['distance'] <= $pfrow['distance']))) { 
											$i++;
											echo "<br>\nCURRENT IS DOMESTIC - DISTANCE CASE : CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH ORIGIN AND DISTANCE IS LESS THAN PREVOUS  CREATING NEW OND $i ======";
											$ond = $this->createOND($ond,$i, $paxId);
											continue;
										} elseif ( ($crow['from_city'] == $originAiport) ) { 
											$i++;
											echo "<br>\nCURRENT IS DOMESTIC - DISTANCE CASE : CUR FROM CITY ". $crow['to_city']  . "  MATCHED WITH ORIGIN  CITY  " . $originAiport . "  ADDING TO PREV OND $i ======";
											$ond = $this->createOND($ond,$i, $paxId);
											continue;
										} else {
											echo "<br>\nCURRENT IS DOMESTIC - DISTANCE CASE : DEFAULT CASE   ADDING TO PREV OND $i ======";
											$ond = $this->createOND($ond,$i, $paxId);
											continue;
										}

									}
								}
								
							} else {
								echo "<br>\nCURRENT IS DOMESTIC -BUT MORE THAN $checkHoursDp Hrs  ======";
								$i++;
								echo "<br>\nCURRENT IS DOMESTIC - NEW OND CREATAED $i ======";
								$ond = $this->createOND($ond,$i, $paxId);
								continue;
							}
					
						} else {
							echo "<br>\nCURRENT IS DOMESTIC - CUR CITY " . $crow['from_city'] . "  NOT MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							$i++;
							echo "<br>\nCURRENT IS DOMESTIC - NEW OND CREATAED $i ======";
							$ond = $this->createOND($ond,$i, $paxId);
							continue;
						}
					}
						
				} else {
					echo "<br>\nCURRENT IS INTERNATIONAL  ======";
					if( $pfkey >= 0) { //Prev row exits $pfrow =  $pax_list[$pnr][$pfkey];
						if ( $crow['from_city'] == $pfrow['to_city']) {
							echo "<br>\nCURRENT IS INTERNATIONAL - CUR CITY " . $crow['from_city'] . " MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							if ((($crow['total_dep_date']) -( $pfrow['total_arrival_date'])) < $checkHours) {
								echo "<br>\nCURRENT IS INTERNATIONAL - WITHIN $checkHoursDp Hrs  ======";
								if ( $crow['to_city'] == $pfrow['from_city'] && $pfrow['from_city'] == $originAiport) {
									echo "<br>\nCURRENT IS INTERNATIONAL - CUR TO CITY " . $crow['to_city'] . " MATCHED WITH PREV FROM CITY " . $pfrow['from_city']  . "  ======";
									$i++;
									echo "<br>\nCURRENT IS INTERNATIONAL - NEW OND CREATAED $i ======";
									$ond = $this->createOND($ond,$i, $paxId);
									continue;
									
								} else {
									echo "<br>\nCURRENT IS INTERNATIONAL - CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH PREV FROM CITY  " . $pfrow['from_city'] . " START CHECK FARTHER END MATCHES WITH ORIGIN AIPRORT $originAiport !";
									if ( $nfrow && ($crow['to_city'] == $originAiport ||  $nfrow['to_city'] == $originAiport)) {
										if ( $pfrow &&  $pax_list[$pnr][$pfkey-1] )  {
										$i++;
										}
										echo "<br>\nCURRENT IS INTERNATIONAL - CUR TO CITY ". $crow['to_city']  . "  MATCHED WITH ORIGIN CITY OR  NEXT FLIGHT " . $pfrow['to_city'] . " MATCHED WITH ORIGIN - FARTHER POINT ADDING TO NEW OND $i ======";
										$ond = $this->createOND($ond,$i, $paxId);
										if ( $pfrow &&  !$pax_list[$pnr][$pfkey-1] ){ 
											$i++;
											echo "<br>\nCURRENT IS INTERNATIONAL - FARTHER POINT - JUST 3 ROWS CASE - CREATE OND FOR NEXT ROW $i ======";
										}
										continue;
									} else {
										echo "<br>\nCURRENT IS INTERNATIONAL - DISTANCE CASE ";
										if ( ($crow['to_city'] != $originAiport) && ($crow['distance'] && $pfrow['distance'] && ($crow['distance'] <= $pfrow['distance']))) { 
											$i++;
											echo "<br>\nCURRENT IS INTERNATIONAL - DISTANCE CASE : CUR TO CITY ". $crow['to_city']  . " NOT MATCHED WITH ORIGIN AND DISTANCE IS LESS THAN PREVOUS  CREATING NEW OND $i ======";
											$ond = $this->createOND($ond,$i, $paxId);
											continue;
										} elseif ( ($crow['from_city'] == $originAiport) ) { 
											$i++;
											echo "<br>\nCURRENT IS INTERNATIONAL - DISTANCE CASE : CUR FROM CITY ". $crow['to_city']  . "  MATCHED WITH ORIGIN  CITY  " . $originAiport . "  ADDING TO PREV OND $i ======";
											$ond = $this->createOND($ond,$i, $paxId);
											continue;
										} else {
											echo "<br>\nCURRENT IS INTERNATIONAL - DISTANCE CASE : DEFAULT CASE   ADDING TO PREV OND $i ======";
											$ond = $this->createOND($ond,$i, $paxId);
											continue;
										}
									}
						

								}
								
							} else {
								echo "<br>\nCURRENT IS INTERNATIONAL -BUT MORE THAN $checkHoursDp Hrs  ======";
								$i++;
								echo "<br>\nCURRENT IS INTERNATIONAL - NEW OND CREATAED $i ======";
								$ond = $this->createOND($ond,$i, $paxId);
								continue;
							}
					
						} else {
							echo "<br>\nCURRENT IS INTERNATIONAL - CUR CITY " . $crow['from_city'] . "  NOT MATCHED WITH PREV ARRIVAL " . $pfrow['to_city'] . " ======";
							$i++;
							echo "<br>\nCURRENT IS INTERNATIONAL - NEW OND CREATAED $i ======";
							$ond = $this->createOND($ond,$i, $paxId);
							continue;
						}
					}
				}

			}
			print "PNR $pnr  END=====================================================================================<br>\n";
		}
		return $ond;
	}

	function createOND($ond, $i, $seg) {
		$ond[$i][] = $seg;
		return $ond;
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

	$carrier_id = htmlentities(escapeString($this->uri->segment(3)));

	ob_start();
	# Get Contracts to decide what carrier and what products offers to be generated
	$contracts = $this->contract_m->getActiveContracts();
	#echo "<pre>CONTRACTS=" . print_r($contracts,1). "</pre>";
   	#$this->processGenBaggageOffers(5500);
#exit;

	foreach($contracts as $contract) {
		$this->mydebug->debug(print_r($contract,1));
		$product = $contract->productID;
		if ($carrier_id) {
			if ( $carrier_id  == $contract->airlineID) {
				$carrierId = $contract->airlineID;
			} else {
				continue;
			}
		} else {
			$carrierId = $contract->airlineID;
		}

		switch ($product) {
			case 1:
				 $this->mydebug->debug("OFFER GEN: PRODUCT UPGRADE : CARRIER ID: " . $carrierId);
   			     $this->processGenUpgradeOffers($carrierId);
				 break;
			case 2:
				$carriers[] = $carrierId;
				$this->mydebug->debug("OFFER GEN: PRODUCT BAGGAGE : CARRIER ID: " . $carrierId);
				break;
		}
			
	}

	//Process BAGGAGE OFFERS
 	$this->processGenBaggageOffers($carriers);
	$debug = ob_get_contents();
	$this->mydebug->offer_eligibility_log($debug, 0);
	ob_end_clean();
//echo $debug;
	$this->session->set_flashdata('success', $this->lang->line('menu_success'));
	redirect(base_url("offer_eligibility/index"));

   }

   function processOfferPerPnr() {

	$pax_id = htmlentities(escapeString($this->uri->segment(3)));
	if ( ! $pax_id ) {
		echo "<br>PAX ID parameter missing ! ";
		return;
	}
	$contracts = $this->contract_m->getActiveContracts();
	echo "<pre>CONTRACTS=" . print_r($contracts,1). "</pre>";
   	#$this->processGenBaggageOffers(5500);
#exit;

	$carriers = Array();
	foreach($contracts as $contract) {
		$carriers[] = $contract->airlineID;
	}

	$parray = Array('dtpf_id' => $pax_id);
	$pax = $this->paxfeed_m->get_single_paxfeed($parray);
	if ($pax->pnr_ref){
		//Reset processing parameters
		$this->resetOffers($pax->pnr_ref);
		echo "<br>======================== START PROCESSING UPGRADE OFFER ! ======================================";
   		$this->processGenUpgradeOffers($pax->carrier_code, $pax->pnr_ref);
		echo "<br>======================== END PROCESSING UPGRADE OFFER ! ======================================";
		echo "<br><br><br>======================== START PROCESSING BAGGAGE OFFER ! ======================================";
   		$this->processGenBaggageOffers($carriers, $pax->pnr_ref);
		echo "<br>======================== END PROCESSING BAGGAGE OFFER ! ======================================";
	} else {
		echo "<br>PNR NOT FOUND ! for pax ID : $pax_id, not able to process baggage offer";
	}
   }

   function resetOffers($pnr_arg = 0) {
		if ($pnr_arg) {
			$pnr = $pnr_arg;
		} else {
			$pnr = htmlentities(escapeString($this->uri->segment(3)));
		}
		if ( $pnr ) {
			$q = "UPDATE VX_daily_tkt_pax_feed set is_up_offer_processed=0, is_bg_offer_processed=0, is_fclr_processed=0,fclr_data=0 ";
			if ( strtolower($pnr) == 'all') {
				echo "Resetting all Offers!";
			} else {
				echo "Resetting PNR $pnr!";
				$flg = 1;
				$q .= " WHERE  pnr_ref = '$pnr'";
			}
			$this->db->query($q);
			echo "Offers Reset complete!";
		}  else {
			echo "PNR Parameter mssing !";
		}
   }

   function processGenBaggageOffers($carriers, $pnr = 0) {
	
		$bclr_rules = $this->bclr_m->get_bclr_by_all_carriers($carriers);
		echo "<br>OND BCLR ALLCARR=<pre>" . print_r($bclr_rules,1) . "</pre>";
		#$bclr_rules = $this->bclr_m->get_bclr_by_carrier_id($carrierId);
		if ( !count($bclr_rules) ) {
			echo ("<br>OFFER GEN: PROCESS BAGGAGE : NO BCLR RULES FOUND FOR CARRIER IDS: " . implode(',', $carriers));
			return;
		}

		echo ("<br>OFFER GEN: START PROCESS BAGGAGE :");


		$days = $this->preference_m->get_application_preference_value('OFFER_ISSUE_WINDOW','7');
                $current_time = time();
                $tstamp = $current_time + ($days * 86400);
		
		//$id = $this->airline_cabin_class_m->checkCarrierDataByID($id);
		# GET  PAXA FEED OF PTC TYPE ADT  ADULT , exclude UNN and NON-REV of speicific Class
		# FILTER 
		$bg_pax_data = $this->offer_eligibility_m->getBaggagePaxDataForAllCarriers($carriers, $tstamp, $pnr);
		$bg_partners = $this->partner_m->getAllPartnerCarriers($carriers);
			echo "<br>PARTNERS=<pre>" . print_r($bg_partners,1) . "</pre>";
		foreach($bg_partners as $partner) {
			$bg_ond_partners[$partner->carrierID][]= $partner->partner_carrierID;
		}
			echo "<br>OND PARTNERS=<pre>" . print_r($bg_ond_partners,1) . "</pre>";
		
		$air_distances = Array();
		$air_distances = $this->airports_m->getAirDistances();

		if ( count($bg_pax_data) ) {
			echo "<br> PAXDATA FOUND=<pre>" . print_r($bg_pax_data,1) . "</pre>";
		} else {
			echo "<br>  MATCHING PAXDATA NOT FOUND!";
			if ($pnr) {
				echo " FOR PNR $pnr";
			}
		}

		$alines = $this->airline_m->getAirlinesData();
		$airline_code_to_carrierId_map = Array();
		foreach($alines as $aline){
			$airline_code_to_carrierId_map[$aline->code]= $aline->vx_aln_data_defnsID;
		}

		#Find Operating carrier for this PNR 

		$pax_ond = Array();
		foreach ($bg_pax_data as $pax_pnr_single ) {
			//echo "<br>SINGLEPNR=<pre>" . print_r($pax_pnr_single,1) . "</pre>";
			$single_adult_full_pax = $this->offer_eligibility_m->getBaggageSingleAdultPax($pax_pnr_single);
			echo "<br>FULLPAX=<pre>" . print_r($single_adult_full_pax,1) . "</pre>";
			$pax_cnt = 0;
			foreach ($single_adult_full_pax as $s_pax ) {
			    $pnr = $s_pax->pnr_ref;
				$range= $s_pax->from_city . "-" . $s_pax->to_city;
				if  (!isset($air_distances[$range])) {
					$air_distances[$range] = $this->distCalc($s_pax->from_city, $s_pax->to_city);
				}
			    $pax_list[$pnr][$pax_cnt]['distance'] =  $air_distances[$range];
			    $pax_list[$pnr][$pax_cnt]['from_city'] =  $s_pax->from_city;
			    $pax_list[$pnr][$pax_cnt]['to_city'] =  $s_pax->to_city;
			    $pax_list[$pnr][$pax_cnt]['total_dep_date'] =  $s_pax->dep_date + $s_pax->dept_time;
			    $pax_list[$pnr][$pax_cnt]['total_arrival_date'] =  $s_pax->arrival_date + $s_pax->arrival_time;
			    $pax_list[$pnr][$pax_cnt]['carrier_code'] =  $s_pax->carrier_code;
			    $pax_list[$pnr][$pax_cnt]['pax_nbr'] =  $s_pax->carrier_code;
			    $pax_list[$pnr][$pax_cnt]['seg_nbr'] =  $s_pax->seg_nbr;
			    $pax_list[$pnr][$pax_cnt]['get_origin_country_code'] =  $s_pax->from_country;
			    $pax_list[$pnr][$pax_cnt]['get_dest_country_code'] =  $s_pax->to_country;
			    $pax_list[$pnr][$pax_cnt]['get_origin_city_ocde'] =  $s_pax->from_city;
			    $pax_list[$pnr][$pax_cnt]['get_dest_city_ocde'] =  $s_pax->to_city;
			    $pax_list[$pnr][$pax_cnt]['flight_number'] =  $s_pax->flight_number;
			    $pax_list[$pnr][$pax_cnt]['dtpf_id'] =  $s_pax->dtpf_id;
			    $pax_list[$pnr][$pax_cnt]['carrier_code'] =  $s_pax->carrier_code;
			    $pax_cnt++;
			}
			echo "<br><pre>ALL PAX  = " . print_r($pax_list,1). "</pre>";

			$tmp_ond = $this->calculateOND($pax_list, $bg_ond_partners);
			if (count($tmp_ond)) {
				$pax_ond[$pax_pnr_single->pnr_ref] = $tmp_ond;
			}
		}
		echo "<br>+++++++++++++++++++++++++++++++++++++++++++++";
		echo "<pre>All PAX OND = " . print_r($pax_ond,1). "</pre>";
		echo "<br>+++++++++++++++++++++++++++++++++++++++++++++";
		if ( !count($pax_ond)) {
			echo "<br> ERROR: NO OND's FOUND , NOTHING TO PROCESS BAGGAGE OFFER, QUITING!";
		}

		#Determine matching BCLR for all OND  
		foreach($pax_ond as $pnr => $ond) {
			foreach($ond as $ond_grp => $pax_arr) {
				echo ("<br>ONGRP GEN: $ond_grp ". print_r($pax_arr,1));
				foreach($pax_arr as $dtpfId) {
					echo ("<br>ONGRP : $ond_grp  DTPF=".$dtpfId);
					$bclrIds = Array();
					$ext = array();
					$blrId = 0;
					if ( $ond_grp != 'NP') {
						$pax = $this->paxfeed_m->get_single_paxfeed(Array("dtpf_id" => $dtpfId));
						$op_carrier = $airline_code_to_carrierId_map[$pax->operating_carrier];
						$mk_carrier = $airline_code_to_carrierId_map[$pax->marketing_carrier];
						if ( !$op_carrier) {
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : OPERATING CARRIER  MISING  FOR PAX ID :  $dtpfId" );
						}
						if ( !$mk_carrier) {
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : MARKETING CARRIER  MISING  FOR PAX ID :  $dtpfId" );
						}
						$pax->op_carrier = $op_carrier;
						$pax->mk_carrier = $mk_carrier;
						//First give precedence for partner based BCLR rules defined by current carrier 
						foreach($bclr_rules[$op_carrier] as $bclr_rule) {
							if ( $bclr_rule->partner_carrierID ) {
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : CHECK PARTNER DEFINED RULES FOR PAX ID $dtpfId FOR  PARTNER CARRIER ID: " . $bclr_rule->partner_carrierID);
								$blrId = $this->getMatchedBclrForPax($pax, $bclr_rule,1);//Check Partner Matched BCLR rules
							}
							if ( $blrId ) {
								$bclrIds[] = $blrId;
							}
						}

						if ( count($bclrIds)) {
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : CHECK PARTNER DEFINED BCLR RULES FOR PAX ID $dtpfId FOR  PARTNER CARRIER ID: " . $bclr_rule->partner_carrierID . ", BCRL RULE = " . print_r($bclrIds,1));
							//Rules might be matched but check block or white listed !
							if ( count($bclrIds) > 1) {
								$bclrId = $this->findBestMatchBclrRule($bclrIds, $bclr_rules);
							} else {
								$bclrId = $bclrIds[0];
							}
						foreach($bclr_rules[$op_carrier] as $bclr_rule) {
							if ( $bclr_rule->partner_carrierID && $bclr_rule->bclr_id == $bclrId && $bclr_rule->allowance == 1) {
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : CHECK PARTNER DEFINED BCLR RULES FOR PAX ID $dtpfId FOR  PARTNER CARRIER ID: " . $bclr_rule->partner_carrierID . ", BCRL RULE WHITELISTED= "  . $bclrId);
								$ext['ond'] = $ond_grp;
								break; 
							} elseif ( $bclr_rule->partner_carrierID && $bclr_rule->bclr_id == $bclrId && $bclr_rule->allowance == 0) {
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : CHECK PARTNER DEFINED BCLR RULES FOR PAX ID $dtpfId FOR  PARTNER CARRIER ID: " . $bclr_rule->partner_carrierID . ", BCRL RULE BLOCKED= "  . $bclrId);
								$ext['ond'] = 'BL'; //PARTNER  BLOCK LIST
								break; 
							}
						}
						} else {
							//If no partner specific  rules  matched , consider current carrier rules 
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : CHECK PARTNER RULES NOT MATCHED, CHECKEING DEFAULT  BCLR RULES FOR PAX ID $dtpfId FOR  CARRIER ID: " . $carrierID);
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : OPERATING CARRIER :". $op_carrier);
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : MARKETING CARRIER :". $mk_carrier);
							echo ("<br>OFFER GEN: PROCESS BAGGAGE : FOR OPERTING CARRIER  BCRL RULES COUNT:". count($bclr_rules[$op_carrier]));
							if ( !count($bclr_rules[$op_carrier])) {
								echo ("<br>OFFER GEN: PROCESS BAGGAGE :NO BCLR RULES FOR  OPERATING CARRIER!" );
							}
				
							foreach($bclr_rules[$op_carrier] as $bclr_rule) {
								if ( !$bclr_rule->partner_carrierID ) {
									$blrId = $this->getMatchedBclrForPax($pax, $bclr_rule,0);//Check SELF BCLR rules
								}
								if ( $blrId ) {
									$bclrIds[] = $blrId;
								}
							}

							if ( count($bclrIds) > 1 ) {
								echo ("<br>OFFER GEN: PROCESS BAGGAGE : MATCHED MORE THAN ONE BCLRID ".  print_r($bclrIds,1) . " FOUND FOR PAX ID $dtpfId FOR  CARRIER ID: " . $carrierId);
								$bclrId = $this->findBestMatchBclrRule($bclrIds, $bclr_rules);
							} else {
								$bclrId = $bclrIds[0];
							}
							if ( $bclrId) {

								echo ("<br>OFFER GEN: PROCESS BAGGAGE : BEST MATCHED BCLR ID $bclrId FOUND FOR PAX ID $dtpfId FOR  CARRIER ID: " . $carrierId);
								$this->mydebug->debug("OFFER GEN: PROCESS BAGGAGE : MATCHED BCLR ID $bclrId FOUND FOR PAX ID $dtpfId FOR  CARRIER ID: " . $carrierId);
								$ext['ond'] = $ond_grp;
							} else {
								$bclrId = 0;
								$ext['ond'] = 'NBCLR'; //NO BC LR MATCHED
								$this->mydebug->debug("OFFER GEN: PROCESS BAGGAGE :  NO BCLR MATCHED  FOR PAX ID $dtpfId FOR  CARRIER ID: " . $carrierId);
								echo ("<br>OFFER GEN: PROCESS BAGGAGE : NO BCLR ID $bclrId MATCHED FOR PAX ID $dtpfId FOR  CARRIER ID: " . $carrierId);
							}
						}
					} else {
						$bclrId = 0;
						$ext['ond'] = $ond_grp;
						echo ("<br>OFFER GEN: PROCESS BAGGAGE : NOT A PARTNER AND NO SLIDER FOR  PAX ID $dtpfId FOR  CARRIER ID: " . $carrierId);
						$this->mydebug->debug("OFFER GEN: PROCESS BAGGAGE : NOT A PARTNER AND NO SLIDER FOR  PAX ID $dtpfId FOR  CARRIER ID: " . $carrierId);
					}
					#Deactive old records of any
					$q = "UPDATE VX_offer_info SET active = 0 WHERE dtpf_id = $dtpfId and product_id = 2 ";	
					$this->db->query($q);
					$ext['dtpf_id'] = $dtpfId;
					$ext['rule_id'] =  $bclrId;
					$ext['product_id'] = 2;//BAGGAGE PRODUCT
					$ext["create_date"] = time();
					$ext["modify_date"] = time();
					$ext["create_userID"] = $this->session->userdata('loginuserID');
					$ext["modify_userID"] = $this->session->userdata('loginuserID');
					$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
					echo ("<br>OFFER GEN: PROCESS BAGGAGE : INSERT MATCHED " . print_r($ext,1) );
					$this->offer_eligibility_m->insert_dtpfext_bclr($ext);
					if (is_int($ext['ond'])) {
						$this->paxfeed_m->update_paxfeed(array('is_bg_offer_processed' => '1'), $dtpfId);
					}
					
				}
			}
		}
		echo ("<br>OFFER GEN: PROCESS BAGGAGE : COMPLETED!");
	}

	function findBestMatchBclrRule($bclrIds, $bclr_rules) {
		$i = 0;
		foreach($bclrIds as $bclrId ) {  // Get least of origin and destimation seperately 
			if ($i == 0 ) {
				$obest = $bclrId;
				$dbest = $bclrId;
				continue;
			}
			if ( $bclr_rules[$bclrId]['origin_level'] <  $bclr_rules[$obest]['origin_level']) {
				$obest = $bclrId;
			}
			if ( $bclr_rules[$bclrId]['destination_level'] <  $bclr_rules[$dbest]['destination_level']) {
				$dbest = $bclrId;
			}
			$i++;
		}
		if ( $dbest == $obest) {  // if they two match same BCLR ID , best match
			$thebest = $dbest;
		} else {  //Find best of Two
			if ( $bclr_rules[$obest]['origin_level'] <  $bclr_rules[$dbest]['origin_level']) {
				$thebest = $obest;
				$check = $dbest;
			} else {
				$thebest = $dbest;
				$check = $obest;
			}
			if ( $bclr_rules[$thebest]['destination_level'] >  $bclr_rules[$check]['origin_level']) {
				$thebest = $check;
			}
		}
		return $thebest;
	}

	function getMatchedBclrForPax($pax, $bclr, $checkPartner = 0) {
        	#$bclr = $this->bclr_m->get_single_bclr(array('bclr_id' => $bclrId));
		$bclrId = $bclr->bclr_id;
		$carrierId = $bclr->carrierID;
		$min_price = $bclr->min_price;
		$max_price = $bclr->max_price;
		$max_capacity = $bclr->max_capacity;
		$cabin = $bclr->from_cabin;
		$frequency = $bclr->frequency;
		$dept_time_start = $bclr->dept_time_start;
		$dept_time_end = $bclr->dept_time_end;
		$flight_number = $bclr->flight_num_range;
		$flight_num_range = explode("-", $flight_number);
		$start_flight_range = $flight_num_range[0];
		$end_flight_range = $flight_num_range[1];
		$origin_list_p = $this->marketzone_m->getAirportsByLevelAndLevelID($bclr->origin_content, $bclr->origin_level);
		$dest_list_p = $this->marketzone_m->getAirportsByLevelAndLevelID($bclr->dest_content, $bclr->dest_level);
		
		$checkCarrierId = $pax->op_carrier; //3958
		if ( $checkPartner ) {
			if ( $bclr->partner_carrierID ) { //5000
				$checkCarrierId = $bclr->partner_carrierID; //5000
			} else {
				return 0;
			}
		}
		//echo "<br>start_date=" . $start_date;
		#print_r($pax);
		
		# Validate, carrier, origin, destination, date , flight, frequency, partner, cabin, class 
		echo "<br><br>MATCHSTART ==========================================================================================";
		echo "<pre>SINGLE PAX  = " . print_r($pax,1). "</pre>";
		echo "<pre>SINGLE BCLR  = " . print_r($bclr,1). "</pre>";
		echo "<br>PAX=" .  $pax->dep_date . " + " . $pax->dept_time;
		echo "<br>PAXT=" .  $pax->dep_date + $pax->dept_time;
		echo "<br>BCLR=" . $bclr->effective_date . " + " . $bclr->dept_time_start;
		echo "<br>BCLRT=" . $bclr->effective_date  +  $bclr->dept_time_start;
	echo "<br>DEPART MATCH=" . date("d M Y H:i:s", $pax->dep_date + $pax->dept_time) . " >= " . date("d M Y H:i:s",($bclr->effective_date + $bclr->dept_time_start)) ."  , " . date("d M Y H:i:s",$pax->dep_date+$pax->dept_time). " <=" ,  date("d M Y H:i:s",$bclr->discontinue_date + $bclr->dept_time_end);
	echo "<br>DEPART MATCH=" .  ($pax->dep_date + $pax->dept_time). " >= " . ($bclr->effective_date + $bclr->dept_time_start) ."  , " . ($pax->dep_date+$pax->dept_time). " <=" .  ($bclr->discontinue_date + $bclr->dept_time_end);
	echo "<br>ARRIVA MATCH=" . date("d M Y H:i:s", $pax->arrival_date+$pax->arrival_time) . " >= " . date("d M Y H:i:s",($bclr->effective_date + $bclr->dept_time_start)) ."  , " . date("d M Y H:i:s",$pax->arrival_date+$pax->arrival_time). " <=" ,  date("d M Y H:i:s",$bclr->discontinue_date + $bclr->dept_time_end);
		echo "<br>ORGIN LIST=" .implode(',',$origin_list_p);
		echo "<br>DEST LIST=" .implode(',',$dest_list_p);
		echo "<br>MATCHEND +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
		
		$matched = 0;
		echo ('<br>  Check Carrier with '.$pax->carrier_code.' == '.$checkCarrierId);
		if ($pax->carrier_code == $checkCarrierId ) {  // 3958 == 5000
			echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED CARRIER CODE - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			$matched++ ;
		} else {
			echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED CARRIER CODE - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
		}


		if( $bclr->frequency) {
			if (  in_array($pax->frequency, explode(',',$bclr->frequency))) {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED FREQUECY  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED FREQUECY  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED FREQUECY MATCH ALL  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++ ;
		}
			
		if( $start_flight_range ) {
			if ( $pax->flight_number >= $start_flight_range ) {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED FLIGHT START RANGE  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED FLIGHT START RANGE   - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED FLIGHT START RANGE MATHC ALL - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++;
		}

		if( $end_flight_range ) {
			if ( $pax->flight_number <= $end_flight_range ) {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED FLIGHT END RANGE  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED FLIGHT END RANGE  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED FLIGHT END RANGE MATHC ALL - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++;
		}
		
		if( $bclr->effective_date + $bclr->dept_time_start > 0 ) {
			if ( $pax->dep_date + $pax->dept_time >= ($bclr->effective_date + $bclr->dept_time_start)   && ($pax->dep_date + $pax->dept_time) <= ($bclr->discontinue_date + $bclr->dept_time_end))  {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED DEPARTURE DATE RANGE  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED DEPARTURE DATE RANGE  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED DEPARTURE DATE  MATCH  ALL - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++;
		}
		
		if( $bclr->effective_date + $bclr->dept_time_start > 0 ) {
			if ( $pax->arrival_date + $pax->arrival_time >= ($bclr->effective_date + $bclr->dept_time_start)   && ($pax->arrival_date + $pax->arrival_time) <= ($bclr->discontinue_date + $bclr->dept_time_end)) {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED ARRIVAL DATE RANGE  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED ARRIVAL DATE RANGE  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED ARRIVAL DATE  MATCH  ALL - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++;
		}
		
		if( $bclr->from_cabin) {
			if ( in_array($pax->cabin, explode(',',$bclr->from_cabin))) {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED CABIN  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED CABIN  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED CABIN MATCH ALL  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++ ;
		}
			
		if( count($origin_list_p)) {
			if  ( in_array($pax->from_city, $origin_list_p))  {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED ORIGIN CITY  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED ORIGIN CITY  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED ORIGIN CITY MATCH ALL  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++ ;
		}
			
		if( count($dest_list_p)) {
			if ( in_array($pax->to_city, $dest_list_p)) {
				$matched++ ;
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED DESTINATION CITY  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED DESTINATION CITY  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			}
		} else {
				echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MATCHED DESTINVATION CITY MATCH ALL  - BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
				$matched++ ;
		}
			
		if ( $matched == 9 ) { //All Matched
			echo ("<br>OFFER GEN: PRODUCT BAGGAGE : MMATCHED BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			$this->mydebug->debug("OFFER GEN: PRODUCT BAGGAGE : MATCHED BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
			return $bclrId;
		} else {
			echo ("<br>OFFER GEN: PRODUCT BAGGAGE : NOT MATCHED BCLR ID $bclrId FOR PAX " . $pax->dtpf_id . "  CARRIER ID: " . $carrierId);
		}
		return 0;
	}
 	

   function processGenUpgradeOffers($carrierId, $pnr = 0) {

		echo ("<br>OFFER GEN: PRODUCT UPGRADE :  CARRIER ID: " . $carrierId);
		$days = $this->preference_m->get_application_preference_value('OFFER_ISSUE_WINDOW','7');

                $current_time = time();
                $tstamp = $current_time + ($days * 86400);


		$sQuery = " SELECT * FROM VX_daily_tkt_pax_feed  WHERE is_up_offer_processed = 0  AND dep_date >= ".$tstamp." AND carrier_code = $carrierId ";
		if ($pnr) {
			$sQuery .= " AND pnr_ref = '$pnr' ";
		}
		$sQuery .= " ORDER by dtpf_id";
		echo ("<br>OFFER GEN: PRODUCT UPGRADE :  QUERY PAX DATA FOR CARRIER ID: " . $sQuery);
		$rResult = $this->install_m->run_query($sQuery);

	if ( $rResult ) {
		echo ("<br>OFFER GEN: PRODUCT UPGRADE :  PAX DATA FOUND FOR CARRIER ID: " . print_r($rResult,1));
		$rules = $this->eligibility_exclusion_m->apply_exclusion_rules(0,$carrierId);
		if ($rules) {
			echo ("<br>OFFER GEN: PRODUCT UPGRADE :  FOUND SOME EXCLUSION RULES FOR CARRIER ID: " . print_r($rules,1));
		}
	} else {
		echo ("<br>OFFER GEN: PRODUCT UPGRADE :  PAX DATA NOT FOUND FOUND  FOR CARRIER ID: " . print_r($carrierId,1));
	}

	foreach ($rResult as $feed ) {

		echo ("<br>OFFER GEN: PRODUCT UPGRADE :  INSIDE FOR LOOP FOR PAX ID: " . print_r($feed->dtpf_id,1));
		//update record it is processed

		$this->paxfeed_m->update_paxfeed(array('is_up_offer_processed' => '1'), $feed->dtpf_id);
		$cabin = $this->airline_cabin_class_m->getCabinFromClassForCarrier($feed->carrier_code,$feed->class);
		
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
                    $data = $this->fclr_m->getUpgradeCabinsData($upgrade, $feed->dep_date);
		}

		 if((count($data) == 0 && $upgrade['season_id'] > 0) || $upgrade['season_id'] == 0) {
				$upgrade['season_id'] = 0;
				 $upgrade['frequency'] = $p_freq;
                 $data = $this->fclr_m->getUpgradeCabinsData($upgrade, $feed->dep_date);
		  }

		if ($data) {
			echo ("<br>OFFER GEN: PRODUCT UPGRADE :  FOUND UPGRADE CABINS  DATA FOR CARRIER ID: " . print_r($data,1));
		} else {
			echo ("<br>OFFER GEN: PRODUCT UPGRADE :   UPGRADE CABINS  DATA NOT FOUND FOR PAX ID: " . $feed->dtpf_id);
		}
		 //$data = $this->fclr_m->getUpgradeCabinsData($upgrade);
		foreach($data as $f) {
		 #Deactive old records of any
				 $q = "UPDATE VX_offer_info SET active = 0 WHERE dtpf_id = ".$feed->dtpf_id." and product_id = 1 ";	
				 $this->db->query($q);
				 $ext = array();
				$ext['dtpf_id'] = $feed->dtpf_id;
				$ext['rule_id'] = $f->fclr_id;
				$ext['product_id'] = 1;//UPGRADE PRODUCT
				$ext["create_date"] = time();
				$ext["modify_date"] = time();
				$ext["create_userID"] = $this->session->userdata('loginuserID');
				$ext["modify_userID"] = $this->session->userdata('loginuserID');
				$matched = 0;
				if(count($rules) > 0 ) {
					foreach ( $rules  as $rule ) {
					echo ("<br>OFFER GEN: PRODUCT UPGRADE :  APPLYING EXCLUSING RULE  ID: " . print_r($rule->eexcl_id,1));
						$query = $this->eligibility_exclusion_m->apply_exclusion_rules(1, $carrierId);
						$query .= ' AND eexcl_id = ' .$rule->eexcl_id;
	
						if ($rule->orig_level != NULL) {
							$query .= " AND  ('".$feed->from_city."' IN (orig_level))";
						}
						if ($rule->dest_level != NULL) {
							$query .= " AND  ('".$feed->to_city."' IN (dest_level))";

						}

						if($rule->frequency != '0' ) {

							$query .= " AND ('".$p_freq."' IN (frequency))";

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

								echo "<br>OFFER GEN: EXCLUSION MATCH QUERY :  FOR RULE GRP ID: " . $query ;
							$result = $this->install_m->run_query($query);
							if(count($result) > 0 ) {	
								echo ("<br>OFFER GEN: PRODUCT UPGRADE :   EXCLUSION RULE MATCHED  FOR RULE GRP ID: " . $result[0]->excl_grp);
								$matched = $result[0]->excl_grp;
								break;
							  }
					}

					if($matched > 0 ) {
						echo ("<br>OFFER GEN: PRODUCT UPGRADE :   ADDING OFFER ELIGIBLITY WITH EXCLUTION FOR CARRIER ID: " .$feed->dtpf_id);
						$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
                        $ext['exclusion_id'] = $matched;
                        $this->offer_eligibility_m->insert_dtpfext_fclr($ext);

					} else {
						echo ("<br>OFFER GEN: PRODUCT UPGRADE :   ADDING OFFER ELIGIBLITY FOR CARRIER ID: " . $feed->dtpf_id);
							$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
                            $this->offer_eligibility_m->insert_dtpfext_fclr($ext);
					}

				}else {
						echo ("<br>OFFER GEN: PRODUCT UPGRADE :   ADDING OFFER ELIGIBLITY DUE TO RULES FOR PAX ID: " . $feed->dtpf_id);
			        	$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');
						$this->offer_eligibility_m->insert_dtpfext_fclr($ext);
				}
			 }
		}

	}

	public function offdtlpage() {		
		$this->data["subview"] = "offer_eligibility/offdtlpage";
		$this->load->view('_layout_main', $this->data);
	}

	function distCalc($fromAirport, $toAirport) {
		//$from = "EGLL";
		//$to = "KJFK";
		$fromAirportCode = $this->airports_m->getAirportICAOCode($fromAirport);
		$toAirportCode = $this->airports_m->getAirportICAOCode($toAirport);
		$distance = $this->getAirportsDistance($fromAirportCode,$toAirportCode);
		$this->airports_m->insertAirDistance($fromAirport,$toAirport,$distance);
		echo "DISTANCE BETWEEN $fromAirportCode - $toAirportCode in KM  = " . $distance;
		return $distance;
	}

	public function getAirportsDistance($from = '', $to = '') {
		$ditance = 0;
		if ( $from && $to ) {
			$url = "https://www.greatcirclemapper.net/en/great-circle-mapper.html?route=$from-$to&aircraft=&speed=";
			$data = file_get_contents($url);
			if ( preg_match("/<td>(.*) nm, (.*) km<\/td>/", $data, $matches) ){
				$distance = $matches[2];
			}
		}
		return $distance;
	}
}
