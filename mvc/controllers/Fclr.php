<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fclr extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("fclr_m");
		$this->load->model("season_m");
		$this->load->model('airports_m');
		$this->load->model("marketzone_m");
		$this->load->model('eligibility_exclusion_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('fclr', $language);	
	}	
	
	

 protected function rules() {
                $rules = array(
                        array(
                                'field' => 'board_point',
                                'label' => $this->lang->line("board_point"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),
                    array(
                                'field' => 'off_point',
                                'label' => $this->lang->line("off_point"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                       ),

			array(
                                'field' => 'carrier_code',
                                'label' => $this->lang->line("carrier"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                       ),


                        array(
                                'field' => 'flight_number',
                                'label' => $this->lang->line("flight_number"),
                                'rules' => 'trim|required|integer|max_length[200]|xss_clean'
                        ),
                        array(
                               'field' => 'season_id',
                                'label' => $this->lang->line("season"),
                                'rules' => 'trim|required|integer|max_length[200]|xss_clean'
                        ),
                        array(
                                'field' => 'frequency',
                               'label' => $this->lang->line("frequency"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),
                        array(
                                 'field' => 'departure_date',
                                 'label' => $this->lang->line("departure_date"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),
                         array(
                                'field' => 'upgrade_from_cabin_type',
                                'label' => $this->lang->line("from_cabin"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),
                                                    
 array(
                                'field' => 'upgrade_to_cabin_type',
                                'label' => $this->lang->line("to_cabin"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                       ),

                         array(
                                  'field' => 'min',
                                'label' => $this->lang->line("min"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),

			array(
                                  'field' => 'max',
                                'label' => $this->lang->line("max"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),


			array(
                                  'field' => 'avg',
                                'label' => $this->lang->line("avg"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),
			 array(
                                  'field' => 'slider_start',
                                'label' => $this->lang->line("slider_start"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),




                );
                return $rules;
        }

        function valMarket($post_string){
          if($post_string == '0'){
                 $this->form_validation->set_message("valMarket", "%s is required");
                  return FALSE;
           }else{
                  return TRUE;
           }
        }

        function valOrigLevelValue($post_array){
          if(count($post_array) < 1){
                 $this->form_validation->set_message("valOrigLevelValue", "%s is required");
                  return FALSE;
           }else{
                  return TRUE;
           }
        }


    public function add() {
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

           $this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1'); // airports
           $this->data['days'] = $this->airports_m->getDefnsListByType('14'); // days of week		
	   $this->data['cabins'] = $this->airports_m->getDefnsListByType('13');
	   $this->data['seasons'] = $this->season_m->getSeasonsList();
	   $this->data['carrier'] = $this->airports_m->getDefnsCodesListByType('12');
	   
		

                if($_POST) {
                        $rules = $this->rules();
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                                $this->data["subview"] = "fclr/add";
                                $this->load->view('_layout_main', $this->data);
                        } else {
                                $array["boarding_point"] = $this->input->post("board_point");
                                $array["off_point"] = $this->input->post("off_point");
                                $array["carrier_code"] = $this->input->post("carrier_code");
                                $array["flight_number"] = $this->input->post("flight_number");
                                $array["departure_date"] = strtotime($this->input->post("departure_date"));
                                $array['frequency'] = $this->input->post("frequency");
                                $array['from_cabin'] = $this->input->post("upgrade_from_cabin_type");
                                $array['to_cabin'] = $this->input->post("upgrade_to_cabin_type");
				$array['season_id'] = $this->input->post("season_id");
				$array['average'] = $this->input->post("avg");
                                $array['min'] = $this->input->post("min");
                                $array['max'] = $this->input->post("max");
                                $array['slider_start'] = $this->input->post("slider_start");

                                if($this->fclr_m->checkFCLREntry($array)) {
                                        $array["create_date"] = time();
                                        $array["modify_date"] = time();
                                        $array["create_userID"] = $this->session->userdata('loginuserID');
                                        $array["modify_userID"] = $this->session->userdata('loginuserID');
                                        $this->fclr_m->insert_fclr($array);
                                }


                                                                                              
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("fclr/index"));
                        }
                } else {
                        $this->data["subview"] = "fclr/add";
                        $this->load->view('_layout_main', $this->data);
                }
        }

        public function edit() {
      $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css',
                        'assets/datepicker/datepicker.css'
                ),
                'js' => array(
                        'assets/select2/select2.js',
                        'assets/datepicker/datepicker.css'
                )
        );


                $id = htmlentities(escapeString($this->uri->segment(3)));
                if((int)$id) {
                        $this->data['fclr'] = $this->fclr_m->get_single_fclr(array('fclr_id'=>$id));
                        if($this->data['fclr']) {

				 $this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1'); // airports
			         $this->data['days'] = $this->airports_m->getDefnsListByType('14'); // days of week           
          			 $this->data['cabins'] = $this->airports_m->getDefnsListByType('13');
           			$this->data['seasons'] = $this->season_m->getSeasonsList();
           			$this->data['carrier'] = $this->airports_m->getDefnsCodesListByType('12');

                                if($_POST) {
                                        $rules = $this->rules();
                                        $this->form_validation->set_rules($rules);
                                        if ($this->form_validation->run() == FALSE) {
                                                $this->data["subview"] = "fclr/edit";
                                                $this->load->view('_layout_main', $this->data);
                                        } else {



				$array["boarding_point"] = $this->input->post("board_point");
                                $array["off_point"] = $this->input->post("off_point");
                                $array["carrier_code"] = $this->input->post("carrier_code");
                                $array["flight_number"] = $this->input->post("flight_number");
                                $array["departure_date"] = strtotime($this->input->post("departure_date"));
                                $array['frequency'] = $this->input->post("frequency");
                                $array['from_cabin'] = $this->input->post("upgrade_from_cabin_type");
                                $array['to_cabin'] = $this->input->post("upgrade_to_cabin_type");
                                $array['season_id'] = $this->input->post("season_id");
                                $array['average'] = $this->input->post("avg");
                                $array['min'] = $this->input->post("min");
                                $array['max'] = $this->input->post("max");
                                $array['slider_start'] = $this->input->post("slider_start");

                                $array["modify_date"] = time();
                               $array["modify_userID"] = $this->session->userdata('loginuserID');

                                $this->fclr_m->update_fclr($array, $id);


                                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                                redirect(base_url("fclr/index"));
                                        }
                                } else {
                                        $this->data["subview"] = "fclr/edit";
                                        $this->load->view('_layout_main', $this->data);
                                }
                        } else {
                                $this->data["subview"] = "error";
                                $this->load->view('_layout_main', $this->data);
                        }
                } else {
                        $this->data["subview"] = "error";
                        $this->load->view('_layout_main', $this->data);
                }
        }

        public function delete() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
                if((int)$id) {
                        $this->data['rule'] = $this->fclr_m->get_single_fclr(array('fclr_id'=>$id));
                        if($this->data['rule']) {
                                $this->fclr_m->delete_fclr($id);
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("fclr/index"));
                        } else {
                                redirect(base_url("fclr/index"));
                        }
                } else {
                        redirect(base_url("fclr/index"));
                }
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


		
	    $aColumns = array('fclr_id','flight_number','departure_date','boarding_point','off_point');
	
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
            tca.code as tcabin, CONCAT(dfre.aln_data_value,'(',dfre.code,')') as day_of_week , fc.active,
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

                  if(permissionChecker('fclr_edit')){
                        $feed->action = btn_edit('fclr/edit/'.$feed->fclr_id, $this->lang->line('edit'));
                  }
		
                  if(permissionChecker('fclr_delete')){
                   $feed->action .= btn_delete('fclr/delete/'.$feed->fclr_id, $this->lang->line('delete'));                   
                  }
                        $status = $feed->active;
                        $feed->active = "<div class='onoffswitch-small' id='".$feed->fclr_id."'>";
            $feed->active .= "<input type='checkbox' id='myonoffswitch".$feed->fclr_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
                        if($status){
                           $feed->active .= " checked >";
                        } else {
                           $feed->active .= ">";
                        }

                        $feed->active .= "<label for='myonoffswitch".$feed->fclr_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";



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


   function active() {
                if(permissionChecker('fclr_edit')) {
                        $id = $this->input->post('id');
                        $status = $this->input->post('status');
                        if($id != '' && $status != '') {
                                if((int)$id) {
                                        $data['modify_userID'] = $this->session->userdata('loginuserID');
                                        $data['modify_date'] = time();
                                        if($status == 'chacked') {
                                                $data['active'] = 1 ;
                                                $this->fclr_m->update_fclr($data, $id);
                                                echo 'Success';
                                        } elseif($status == 'unchacked') {
                                                $data['active'] = 0 ;
                                                $this->fclr_m->update_fclr($data, $id);
                                                echo 'Success';
                                        } else {
                                                echo "Error";
                                        }
                                } else {
                                        echo "Error";
                                }
                        } else {
                                echo "Error";
                        }
                } else {
                        echo "Error";
                }
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
		LEFT JOIN vx_aln_data_defns ptc on (ptc.vx_aln_data_defnsID = rf.pax_type AND ptc.aln_data_typeID = 18)
		where acc.order > 1  AND ptc.code NOT IN ('INF', 'INS', 'UNN') 
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

