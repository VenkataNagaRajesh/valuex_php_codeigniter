<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_eligibility extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("airline_cabin_class_m");
		$this->load->model("offer_eligibility_m");
		$this->load->model("eligibility_exclusion_m");
		$this->load->model("season_m");
		$this->load->model("marketzone_m");
		$this->load->model("fclr_m");
		$language = $this->session->userdata('lang');
		$this->load->library('encrypt');
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


		

		$this->data['country'] = $this->rafeed_m->getCodesByType('2');
		$this->data['city'] = $this->rafeed_m->getCodesByType('5');
		$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
		$this->data['airport'] = $this->rafeed_m->getCodesByType('1');
		$this->data['cabin'] = $this->rafeed_m->getCodesByType('13');
		$this->data['flights'] = $this->rafeed_m->getNamesByType('16');
		
		$this->data["subview"] = "offer_eligibility/index";
		$this->load->view('_layout_main', $this->data);
	}
	


    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  


		
	    $aColumns = array('dtpfext_id','flight_number','departure_date','boarding_point','off_point');
	
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


			


$sQuery = " SELECT SQL_CALC_FOUND_ROWS pext.fclr_id, pext.dtpf_id , pext.dtpfext_id ,
		 boarding_point, dai.code as carrier_code , off_point, season_id,pf.flight_number, fca.code as fcabin, 
            	tca.code as tcabin, CONCAT(dfre.aln_data_value,'(',dfre.code,')') as day_of_week ,
            	pf.dep_date as departure_date, min,max,average,slider_start,from_cabin, to_cabin,
		dbp.code as source_point , dop.code as dest_point, bs.aln_data_value as booking_status, pext.exclusion_id
		     from VX_aln_dtpf_ext pext 
		     LEFT JOIN VX_aln_daily_tkt_pax_feed pf  on  (pf.dtpf_id = pext.dtpf_id)
		     LEFT JOIN VX_aln_fare_control_range fc on  (pext.fclr_id = fc.fclr_id)
                     LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = fc.boarding_point AND dbp.aln_data_typeID = 1)  
		     LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = fc.off_point AND dop.aln_data_typeID = 1)    
		     LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = fc.carrier_code AND dai.aln_data_typeID = 12)
		     LEFT JOIN vx_aln_data_defns dfre on (dfre.vx_aln_data_defnsID = fc.frequency AND dfre.aln_data_typeID = 14)
		     LEFT JOIN vx_aln_data_defns fca on (fca.vx_aln_data_defnsID = fc.from_cabin AND fca.aln_data_typeID = 13)
                     LEFT JOIN vx_aln_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin AND tca.aln_data_typeID = 13)
		     LEFT JOIN vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20)

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

			if($feed->booking_status == 'Excluded') {
				$feed->booking_status = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="Rule#'.$feed->exclusion_id.'">'.$feed->booking_status.'</a>';

			}
			$feed->season_id = ($feed->season_id) ? $this->season_m->getSeasonNameByID($feed->season_id) : "default season";
			$feed->departure_date = date('d-m-Y',$feed->departure_date);
                                $output['aaData'][] = $feed;

		}

		
		echo json_encode( $output );
	}
	


   function generatedata() {

		$sQuery = "SELECT * FROM VX_aln_daily_tkt_pax_feed";
		$rResult = $this->install_m->run_query($sQuery);

		$exclQuery = "SELECT * from VX_aln_eligibility_excl_rules ";
		$excl = $this->install_m->run_query($exclQuery);
/*
		$fclrQuery = " SELECT  boarding_point, off_point,flight_number,  group_concat(price SEPARATOR ';') as code_price           FROM (                select boarding_point, off_point , flight_number , group_concat(fca.code,' ' , tca.code ,' min ', min, ' max ' , max,' average ', average ,' slider_start ' , slider_start) as price from VX_aln_fare_control_range fc LEFT JOIN vx_aln_data_defns fca on (fca.vx_aln_data_defnsID = fc.from_cabin)  LEFT JOIN vx_aln_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin) group by boarding_point ,off_point,flight_number,from_cabin,to_cabin)  as MainSet                  group by  boarding_point, off_point, flight_number
 " ;
		$fclr = $this->install_m->run_query($fclrQuery);*/


	foreach ($rResult as $feed ) {
		$cabin = $this->airline_cabin_class_m->getCabinFromClassForCarrier($feed->carrier_code,$feed->class);
		$array['from_city'] = $feed->from_city;
		$array['to_city'] = $feed->to_city;
		$array['flight_number'] = $feed->flight_number;
		$array['dep_date'] = $feed->dep_date;
		
		$rules = $this->eligibility_exclusion_m->apply_exclusion_rules($array);

			$upgrade['boarding_point'] = $feed->from_city;
                        $upgrade['off_point'] = $feed->to_city;
                        $upgrade['flight_number'] = $feed->flight_number;
                        $upgrade['carrier_code'] = $feed->carrier_code;
                        $upgrade['frequency'] =  $this->rafeed_m->getDefIdByTypeAndCode(date('w',$feed->dep_date),'14'); //507;
                        $upgrade['season_id'] = $this->season_m->getSeasonForDateANDAirlineID($feed->dep_date,$feed->carrier_code); //0;
                         $data = $this->fclr_m->getUpgradeCabinsData($upgrade);
		if(count($rules) > 0 ) {
			// rule matches partially check for the cabins that are excluded
			foreach($rules as $rule ) {
				foreach($data as $f) {
					$coupon_code = $this->generateRandomString(6);
						$ext['dtpf_id'] = $feed->dtpf_id;
                                                $ext['fclr_id'] = $f->fclr_id;
					        $ext['coupon_code'] = $coupon_code;	
						$ext["create_date"] = time();
                                                 $ext["modify_date"] = time();
                                                $ext["create_userID"] = $this->session->userdata('loginuserID');
                                                 $ext["modify_userID"] = $this->session->userdata('loginuserID');
				if($f->from_cabin == $rule->upgrade_from_cabin_type && $f->to_cabin == $rule->upgrade_to_cabin_type) {
                                                $ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
						$ext['exclusion_id'] = $rule->eexcl_id ;
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
						$coupon_code = $this->generateRandomString(6);
                                                // cabins Y, W we have to insert
                                                // y->c,  W->C, Y-> W
                                                        // insert records ext table 
						$ext['dtpf_id'] = $feed->dtpf_id;
						$ext['fclr_id'] = $f->fclr_id;
						$ext['coupon_code'] = $coupon_code;
						$ext['booking_status'] = $this->rafeed_m->getDefIdByTypeAndCode('New','20');
						$ext["create_date"] = time();
                		                $ext["modify_date"] = time();
		                                $ext["create_userID"] = $this->session->userdata('loginuserID');
                                                $ext["modify_userID"] = $this->session->userdata('loginuserID');
                                                $this->offer_eligibility_m->insert_dtpfext($ext);

					}	
	        }


	}

		$this->session->set_flashdata('success', $this->lang->line('menu_success'));
                           redirect(base_url("offer_eligibility/index"));


	}


  public  function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
	if ($this->offer_eligibility_m->checkForUniqueCouponCode($randomString)){
        	return $this->encrypt->encode($randomString);  // to decode  $this->encrypt->decode($encrypt_key);
	} else {
		$this->generateRandomString(6);
	}
    }


}

