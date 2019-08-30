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
		$this->load->model("season_m");
		$this->load->model('paxfeed_m');
		$this->load->model("marketzone_m");
		$this->load->model("fclr_m");
		$this->load->model("season_m");
		$this->load->model("airports_m");
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
                $userTypeID = $this->session->userdata('usertypeID');
                if($userTypeID == 2){
                        $this->data['carriers'] = $this->airline_m->getClientAirline($userID);
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
		

	$userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');

        if($this->session->userdata('usertypeID') == 2){
                   $this->data['seasonslist'] = $this->season_m->get_seasons_where(array('s.create_userID' => $this->session->userdata('loginuserID')),null);
                }else{
                   $this->data['seasonslist'] = $this->season_m->get_seasons();
                }
        if($this->input->post('carrier')){
		   $this->data['carrier'] = $this->input->post('carrier');
	     } else {
		   if($userTypeID == 2){
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
		$usertypeID = $this->session->userdata('usertypeID');	  


		
	    $aColumns = array('dtpfext_id','pext.dtpf_id','pext.fclr_id','sea.season_name','dbp.code','dop.code','pf.pnr_ref','pf.dep_date','dai.code','pf.flight_number',
			 'fca.code','tca.code','dfre.code','fc.average','fc.min','fc.max','fc.slider_start',
			 'bs.aln_data_value','dbp.aln_data_value','dop.aln_data_value','dai.aln_data_value','fca.aln_data_value',
			 'tca.aln_data_value','dfre.aln_data_value','pf.pnr_ref');
	
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

			




		                  $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'pf.carrier_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';
                }
	


$sQuery = " SELECT SQL_CALC_FOUND_ROWS pext.fclr_id, pext.dtpf_id , pext.dtpfext_id ,
		 boarding_point, dai.code as carrier_code , off_point, season_id,pf.flight_number, fca.code as fcabin, 
            	tca.code as tcabin, dfre.code as day_of_week , sea.season_name,
            	pf.dep_date as departure_date, min,max,average,slider_start,from_cabin, to_cabin,
		dbp.code as source_point , dop.code as dest_point, bs.aln_data_value as booking_status, pext.exclusion_id, 
		pf.pnr_ref
		     from VX_aln_dtpf_ext pext 
		     INNER JOIN VX_aln_daily_tkt_pax_feed pf  on  (pf.dtpf_id = pext.dtpf_id AND pf.is_processed = 1 and pf.active = 1)
		     LEFT JOIN VX_aln_fare_control_range fc on  (pext.fclr_id = fc.fclr_id)
		     LEFT JOIN VX_aln_season sea on (sea.VX_aln_seasonID = fc.season_id )
                     LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = pf.from_city AND dbp.aln_data_typeID = 1)  
		     LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = pf.to_city AND dop.aln_data_typeID = 1)    
		     LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = pf.carrier_code AND dai.aln_data_typeID = 12)
		     LEFT JOIN vx_aln_data_defns dfre on (dfre.vx_aln_data_defnsID = pf.frequency AND dfre.aln_data_typeID = 14)
		     LEFT JOIN vx_aln_data_defns fca on (fca.vx_aln_data_defnsID = fc.from_cabin AND fca.aln_data_typeID = 13)
                     LEFT JOIN vx_aln_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin AND tca.aln_data_typeID = 13)
		     INNER JOIN vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20)

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
	


   function generatedata() {

		$sQuery = " SELECT * FROM VX_aln_daily_tkt_pax_feed pf LEFT JOIN vx_aln_data_defns cab on (cab.vx_aln_data_defnsID = pf.cabin and cab.aln_data_typeID = 13 ) where cab.aln_data_value != 'Business'  AND is_processed = 0 order by dtpf_id";
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
			 foreach($data as $f) {

				$rules = $this->eligibility_exclusion_m->apply_exclusion_rules();
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

