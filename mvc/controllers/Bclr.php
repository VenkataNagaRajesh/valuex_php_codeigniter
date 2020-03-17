<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bclr extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model('airline_cabin_def_m');
		$this->load->model("fclr_m");
		$this->load->model("season_m");
		$this->load->model('airports_m');
		$this->load->model('airline_m');
		$this->load->model("marketzone_m");
		$this->load->model('eligibility_exclusion_m');
		$this->load->model('user_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('bclr', $language);	
	}	
	
	protected function rules() {
		$rules = array(
                        array(
                                'field' => 'carrierID',
                                'label' => $this->lang->line("carrier"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                        ),
                        array(
                                'field' => 'from_cabin',
                                'label' => $this->lang->line("from_cabin"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                        ),
                        array(
                                'field' => 'partner_carrierID',
                                'label' => $this->lang->line("partner_carrier"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                        ),
                        array(
                                'field' => 'allow',
                                'label' => $this->lang->line("allowance"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),
                        array(
                                'field' => 'aircraft_type',
                                'label' => $this->lang->line("aircraft_type"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                        ),
                        array(
                                'field' => 'flight_num_range',
                                'label' => $this->lang->line("flight_number_range"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valFlightrange'
                        ),			
			array(
				'field' => 'origin_level',
				'label' => $this->lang->line("origin_level"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                         ),
                        array(
                                'field' => 'origin_content[]',
                                'label' => $this->lang->line("origin_content"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateContent'
                        ),
                        array(
				'field' => 'dest_level',
				'label' => $this->lang->line("dest_level"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                         ),
                        array(
                                'field' => 'dest_content[]',
                                'label' => $this->lang->line("dest_content"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateContent'
                        ),
                        array(
                                'field' => 'effective_date',
                                'label' => $this->lang->line("effective_date"),
                                'rules' => 'trim|required|xss_clean|max_length[60]'  
                        ),
                        array(
                                'field' => 'discontinue_date',
                                'label' => $this->lang->line("discontinue_date"),
                                'rules' => 'trim|required|xss_clean|max_length[60]'  
                        ),
                        array(
                               'field' => 'frequency',
                               'label' => $this->lang->line("frequency"),
                               'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                        ),
                        array(
                                'field' => 'rule_auth_carrier',
                                'label' => $this->lang->line("rule_auth"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                        ),
                        array(
                               'field' => 'dep_time_start',
                               'label' => $this->lang->line("dep_time_start"),
                               'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),
                        array(
                                'field' => 'dep_time_end',
                                'label' => $this->lang->line("dep_time_end"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                         ), 
                         array(
                                'field' => 'min_unit',
                                'label' => $this->lang->line("min_unit"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                         ),
                         array(
                                'field' => 'max_capacity',
                                'label' => $this->lang->line("max_capacity"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                         ),    
                         array(
                                'field' => 'min_price',
                                'label' => $this->lang->line("min_price"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                         ),
                         array(
                                'field' => 'max_price',
                                'label' => $this->lang->line("max_price"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                         )       

		);
	        return $rules;
        }

        function validateLevel($post_string){
              if($post_string == '0'){
                    $this->form_validation->set_message("validateLevel", "%s is required");
                     return FALSE;
              }else{
                     return TRUE;
              }
        }
        
        function validateContent($post_array){
            if(count($post_array) < 1){
                   $this->form_validation->set_message("validateContent", "%s is required");
                    return FALSE;
             }else{
                    return TRUE;
             }
        }

        function valFlightrange($post_string){
           if(empty($post_string)){
                $this->form_validation->set_message("valFlightrange", "%s is required");
                return FALSE;
           } else if(preg_match('/(\d+)-(\d+)/', $post_string, $matches)){
                return TRUE;
           }  else {
             $this->form_validation->set_message("valFlightrange", "%s format like 1011-1050");
             return FALSE;
           }
        }

 
        public function getFCLRData() {
           $id = $this->input->post('fclr_id');
           if((int)$id) {
              $fclr = $this->fclr_m->get_single_fclr(array('fclr_id' => $id));   
           }
           $this->output->set_content_type('application/json');
           $this->output->set_output(json_encode($fclr));
        }

        public function getAircrafts(){
           $carrierID = $this->input->post('carrierID');
           $aircrafts = $this->airline_m->getAirCraftTypesList($carrierID);
           //echo "<option value='0'> Select Aircraft </option>";
           foreach($aircrafts as $aircraft){
              echo "<option value='".$aircraft->aircraftID."'>".$aircraft->aln_data_value."</option>";
           }
        }

        public function getCabinsCarrier(){
           $carrierID = $this->input->post('carrierID');
           $cabins = $this->airline_cabin_def_m->getCabinsDataForCarrier($carrierID,1);
           echo "<option value='0'> From Cabin </option>";
           foreach($cabins as $cabin){
              echo "<option value='".$cabin->vx_aln_data_defnsID."'>".$cabin->cabin."</option>";
           }
           if(count($cabins) > 0){
             echo "<option value='*'> All (*) </option>";
           }
        }

        public function save() {
          if($_POST) {
            $bclr_id = $this->input->post("bclr_id");
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
              $json['status'] = validation_errors();
                $json['errors'] = array(
                'carrierID' => form_error('carrierID'),
                'from_cabin' => form_error('from_cabin'),
                'partner_carrierID' => form_error('partner_carrierID'),
                'allow' => form_error('allow'),
                'aircraft_type' => form_error('aircraft_type'),
                'flight_num_range' => form_error('flight_num_range'),
                'origin_level' => form_error('origin_level'),
                'origin_content' => form_error('origin_content[]'),
                'dest_level' => form_error('dest_level'),
                'dest_content' => form_error('dest_content[]'),
                'effective_date' => form_error('effective_date'),
                'discontinue_date' => form_error('discontinue_date'),
                'frequency' => form_error('frequency'),
		'bag_type' => form_error('bag_type'),
                'rule_auth_carrier' => form_error('rule_auth_carrier'),
                'dep_time_start'=>form_error('dep_time_start'),
                'dep_time_end'=>form_error('dep_time_end'),
                'min_unit'=>form_error('min_unit'),
                'max_capacity'=>form_error('max_capacity'),
                'min_price'=>form_error('min_price'),
                'max_price'=>form_error('max_price')
                );
            } else {
                $array['carrierID'] = $this->input->post('carrierID');
                $array['from_cabin'] = $this->input->post('from_cabin');
                $array['partner_carrierID'] = $this->input->post('partner_carrierID');
                $array['allow'] = $this->input->post('allow');
                $array['aircraft_type'] = $this->input->post('aircraft_type');
                $array['flight_num_range'] = $this->input->post('flight_num_range');
                $array['origin_level'] = $this->input->post('origin_level');
                $array['origin_content'] =  implode(',',$this->input->post('origin_content'));
                $array['dest_level'] = $this->input->post('dest_level');
                $array['dest_content'] =  implode(',',$this->input->post('dest_content'));
                $array['effective_date'] = $this->input->post('effective_date');
                $array['discontinue_date'] = $this->input->post('discontinue_date');
                $array['frequency'] = $this->input->post('frequency');
		$array['bag_type'] = $this->input->post('bag_type');
                $array['rule_auth_carrier'] = $this->input->post('rule_auth_carrier');
                $array['dep_time_start'] = $this->input->post('dep_time_start');
                $array['dep_time_end'] = $this->input->post('dep_time_end');
                $array['min_unit'] = $this->input->post('min_unit');
                $array['max_capacity'] = $this->input->post('max_capacity');
                $array['min_price'] = $this->input->post('min_price');
                $array['max_price'] = $this->input->post('max_price');
                $exist_id = $this->bclr_m->checkBCLREntry($array);
		        if($bclr_id) {
		                if ( $exist_id && $exist_id != $bclr_id )  {
		        		$json['status'] = 'duplicate';	
		        	} else {
		        		$array["modify_date"] = time();
                                       	$array["modify_userID"] = $this->session->userdata('loginuserID');
                                       	$this->bclr_m->update_bclr($array,$bclr_id);
                                       	$json['status'] = 'success';
		        	}
                         }  else {
		        	if ( $exist_id ) {
		        		$json['status'] = 'duplicate';
		        	} else {
		        		$array["create_date"] = time();
                                       	$array["modify_date"] = time();
                                       	$array["create_userID"] = $this->session->userdata('loginuserID');
                                       	$array["modify_userID"] = $this->session->userdata('loginuserID');
                                       	$this->bclr_m->insert_bclr($array);
                                       	$json['status'] = 'success';
		        	}
		        }
                }
          } else {
            $json['status'] = "no data";
          }

           $this->output->set_content_type('application/json');
           $this->output->set_output(json_encode($json));
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
                                'assets/datepicker/datepicker.css',
                                'assets/timepicker/timepicker.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js',
                                'assets/datepicker/datepicker.js',
                                'assets/timepicker/timepicker.js'
                        )
                );

                $userID = $this->session->userdata('loginuserID');
                $roleID = $this->session->userdata('roleID');
                
                if($this->input->post('carrierID')){
                  $this->data['carrierID'] = $this->input->post('carrierID');
                } elseif($roleID != 1){
                  $this->data['carrierID'] = $this->session->userdata('default_airline'); 
                } else {
                  $this->data['carrierID'] = 0;
                }
                
                if($this->input->post('partner_carrierID')){
                    $this->data['partner_carrierID'] = $this->input->post('partner_carrierID');
                } else {
                    $this->data['partner_carrierID'] = 0;
                }
        
                if($this->input->post('start_date')){
                    $this->data['start_date'] = $this->input->post('start_date');
                } else {
                    $this->data['start_date'] = '';
                }
        
                if($this->input->post('end_date')){
                    $this->data['end_date'] = $this->input->post('end_date');
                } else {
                    $this->data['end_date'] = '';
                }
        
                if($this->input->post('origin_content')){
                    $this->data['origin_content'] = $this->input->post('origin_content');
                } else {
                    $this->data['origin_content'] = 0;
                }
        
                if($this->input->post('origin_level')){
                    $this->data['origin_level'] = $this->input->post('origin_level');
                } else {
                    $this->data['origin_level'] = 0;
                }
        
                if($this->input->post('origin_content')){
                    $this->data['origin_content'] = $this->input->post('origin_content');
                } else {
                    $this->data['origin_content'] = 0;
                }
        
                if($this->input->post('dest_level')){
                    $this->data['dest_level'] = $this->input->post('dest_level');
                } else {
                    $this->data['dest_level'] = 0;
                }
        
                if($this->input->post('dest_content')){
                    $this->data['dest_content'] = $this->input->post('dest_content');
                } else {
                    $this->data['dest_content'] = 0;
                }        
                
                $this->data['airlines'] = $this->airline_m->getAirlinesData();
                $this->data['types'] = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
               
                if($roleID != 1){
                    $this->data['myairlines'] = $this->user_m->getUserAirlines($userID);	   
                } else {
                    $this->data['myairlines'] = $this->airline_m->getAirlinesData();
                }
		
                $this->data['days_of_week'] = $this->airports_m->getDefnsCodesListByType('14');  
                $this->data['seasons'] = $this->season_m->getSeasonsList();	
		$this->data["subview"] = "bclr/index";
		$this->load->view('_layout_main', $this->data);
	}
	




    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');	  


	 $aColumns = array('fclr_id','dbp.code','dop.code','dai.code','flight_number','season_name','sea.ams_season_start_date', 'sea.ams_season_end_date','dfre.code','fdef.cabin','tdef.cabin','average','min','max','slider_start','fc.active','dop.code','dbp.code','dai.code','dfre.aln_data_value', 'dop.aln_data_value', 'dbp.aln_data_value', 'dai.aln_data_value', 'fdef.desc', 'tdef.desc');
		
	
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
                                $sWhere .= 'flight_number >= '.$this->input->get('flightNbr');
                        }

		
			if(!empty($this->input->get('flightNbrEnd'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'flight_number <= '.$this->input->get('flightNbrEnd');
                        }


			if(!empty($this->input->get('sfclr_id'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'fclr_id = '.$this->input->get('sfclr_id');
                        }

			/*
			if(!empty($this->input->get('depStartDate'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'departure_date >= '. strtotime($this->input->get('depStartDate'));
                        }
                        if(!empty($this->input->get('depEndDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'departure_date <= '.  strtotime($this->input->get('depEndDate'));
                        }*/

			


			if(!empty($this->input->get('smarket'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'smap.market_id = '. $this->input->get('smarket');
                        }
                        if(!empty($this->input->get('dmarket'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'dmap.market_id = '.  $this->input->get('dmarket');
                        }



			 if(!empty($this->input->get('sfrom_cabin'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'fc.from_cabin = '. $this->input->get('sfrom_cabin');
                        }
                        if(!empty($this->input->get('sto_cabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'fc.to_cabin = '.  $this->input->get('sto_cabin');
                        }


		       if(!empty($this->input->get('sseason_id'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'fc.season_id = '. $this->input->get('sseason_id');
                        }
                        if(!empty($this->input->get('scarrier'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'fc.carrier_code = '.  $this->input->get('scarrier');
                        }


                       if(!empty($this->input->get('frequency'))){
                               $frstr = $this->input->get('frequency');
                                $freq = $this->airports_m->getDefnsCodesListByType('14');
				if($frstr === '*'){
					$frstr = '1234567';
				}
                                 if ( $frstr != '0') {
                                        $arr = str_split($frstr);
                                        $freq_str = implode(',',array_map(function($x) use ($freq) { return array_search($x, $freq); }, $arr));
                                        $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                        $sWhere .= 'fc.frequency IN ('.$freq_str.') ';
                                  }

                        }

                  $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID != 1){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'fc.carrier_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';
                }


			


$sQuery = " SELECT SQL_CALC_FOUND_ROWS distinct fclr_id,boarding_point, dai.code as carrier_code , off_point, 
		season_id,flight_number, fdef.cabin as fcabin, sea.season_name,
            	tdef.cabin as tcabin,  dfre.code as day_of_week , fc.active, sea.ams_season_start_date as start_date, sea.ams_season_end_date as end_date,
            	min,max,average,slider_start,from_cabin, to_cabin,
		dbp.code as source_point , dop.code as dest_point,
		dfre.aln_data_value, dop.aln_data_value, dbp.aln_data_value, dai.aln_data_value, fdef.desc,tdef.desc 
		
                    FROM UP_fare_control_range  fc
                     LEFT JOIN  VX_data_defns dbp on (dbp.vx_aln_data_defnsID = fc.boarding_point) 
		     LEFT JOIN VX_data_defns dop on (dop.vx_aln_data_defnsID = fc.off_point)    
		     LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = fc.carrier_code)
		     LEFT JOIN VX_data_defns dfre on (dfre.vx_aln_data_defnsID = fc.frequency)
		     INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = fc.carrier_code)

		     INNER JOIN VX_data_defns fca on (fca.alias = fdef.level and fca.aln_data_typeID = 13 AND fca.vx_aln_data_defnsID = fc.from_cabin)
		     
		     INNER JOIN VX_airline_cabin_def tdef on (tdef.carrier = fc.carrier_code)
                     INNER JOIN VX_data_defns tca on (tca.alias = tdef.level and tca.aln_data_typeID = 13 AND tca.vx_aln_data_defnsID = fc.to_cabin)
		     LEFT JOIN VX_season sea on (sea.VX_aln_seasonID = fc.season_id )
		     LEFT JOIN VX_market_airport_map smap on (smap.airport_id = fc.boarding_point ) 
		     LEFT JOIN VX_market_airport_map dmap on (dmap.airport_id = fc.off_point)

$sWhere $sOrder $sLimit";


	$rResult = $this->install_m->run_query($sQuery);
	$sQuery = "SELECT FOUND_ROWS() as total";
	$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $rResultFilterTotal,
		"iTotalDisplayRecords" => $rResultFilterTotal,
		"aaData" => array()
	  );

	    $i = 1;
		$rownum = 1 + $_GET['iDisplayStart'];
		foreach ($rResult as $feed ) {

			 $feed->chkbox = "<input type='checkbox'  class='deleteRow' value='".$feed->fclr_id."'  /> ".$rownum ;
                                $rownum++;

			$boarding_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->boarding_point));
			$feed->day_of_week = ($feed->day_of_week)? ($feed->day_of_week):"NA";
			$feed->source = $feed->source_point;
			$feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip"  data-original-title="'.$boarding_markets.'">'.$feed->source_point.'</a>';
			 $dest_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->off_point));
			  $feed->dest = $feed->dest_point ;
               $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip"  data-original-title="'.$dest_markets.'">'.$feed->dest_point.'</a>';

			
			/*if ( $feed->season_id > 0 ) {
				$season = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$feed->season_id));
				$feed->season_id =  $season->season_name ;
				$feed->start_date = date('d-m-Y',$season->ams_season_start_date);
				$feed->end_date  = date('d-m-Y',$season->ams_season_end_date);
			} else {
				 $feed->season_id = 'default season';
				$feed->start_date = 'NA';
				$feed->end_date = 'NA';
			}*/


			$feed->season_id = ($feed->season_name) ? ($feed->season_name) : 'default';
			$feed->start_date = ($feed->start_date) ? date('d-m-Y',$feed->start_date) : 'NA';
			$feed->end_date = $feed->end_date ? date('d-m-Y',$feed->end_date) : 'NA';
            $feed->action = '';
                  if(permissionChecker('fclr_edit')){

			 $feed->action .=  '<a href="#" class="btn btn-warning btn-xs mrg" id="edit_fclr"  data-placement="top" onclick="editfclr('.$feed->fclr_id.')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
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
           $feed->id = $i; $i++;
		$output['aaData'][] = $feed;

		}

						 
        if(isset($_REQUEST['export'])){
		  $columns = array('#','Board Point','Off Point','Carrier','Flight Number','Season','From date','To date','Frequency','From Cabin','To Cabin','Average','Minimum','Maximum','Slider Position');
		  $rows = array("id","source","dest","carrier_code","flight_number","season_id","start_date","end_date","day_of_week","fcabin","tcabin","average","min","max","slider_start");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
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
   

  public function delete_fclr_bulk_records(){
        $data_ids = $_REQUEST['data_ids'];
        $data_id_array = explode(",", $data_ids);
        if(!empty($data_id_array)) {
                foreach($data_id_array as $id) {
                $this->data['rule'] = $this->bclr_m->get_single_bclr(array('bclr_id'=>$id));
                if($this->data['rule']) {
                $this->bclr_m->delete_bclr($id);
                }           
                }
        }
}

}


