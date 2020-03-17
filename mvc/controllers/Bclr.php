<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bclr extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model('airline_cabin_def_m');
		$this->load->model("fclr_m");
		$this->load->model("bclr_m");
		$this->load->model("season_m");
		$this->load->model('airports_m');
		$this->load->model('airline_m');
		$this->load->model("marketzone_m");
		$this->load->model('eligibility_exclusion_m');
                $this->load->model('user_m');
                $this->load->model('partner_m');
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
                                'field' => 'allowance',
                                'label' => $this->lang->line("allowance"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
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
           } else if(preg_match('/(\d+)-(\d+)/', trim($post_string), $matches)){
                return TRUE;
           }  else {
             $this->form_validation->set_message("valFlightrange", "%s format like 1011-1050");
             return FALSE;
           }
        }

 
        public function getBCLRData() {
           $id = $this->input->post('bclr_id');
           if((int)$id) {
              $bclr = $this->bclr_m->get_single_bclr(array('bclr_id' => $id));   
           }
           $this->output->set_content_type('application/json');
           $this->output->set_output(json_encode($bclr));
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

        public function getSeasonsCarrier(){
                $carrierID = $this->input->post('carrierID');
                $seasons = $this->season_m->get_seasons_for_airline($carrierID);
                echo "<option value='0'> Season </option>";
                foreach($seasons as $season){
                   echo "<option value='".$season->VX_aln_seasonID."'>".$season->season_name."</option>";
                }                    
        }

        public function getPartnerCarriers(){
                $carrierID = $this->input->post('carrierID');
                $partners = $this->partner_m->getPartnerCarriers($carrierID);
                echo "<option value='0'> Partner Carrier </option>";
                foreach($partners as $partner){
                   echo "<option value='".$partner->partner_carrierID."'>".$partner->code."</option>";
                }                    
        }

        function convertTimeToSeconds($time_str) {
            $time_str = date("H:i:s", strtotime($time_str));
            $str = explode(':',$time_str);
            $time_in_seconds = (3600 * $str[0] ) + ( 60 * $str[1]) + (1 * $str[2]);
            return $time_in_seconds;       
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
                $array['season_id'] = $this->input->post('season');
                $array['allowance'] = $this->input->post('allowance');
                $array['aircraft_typeID'] = $this->input->post('aircraft_type');
                $array['flight_num_range'] = trim($this->input->post('flight_num_range'));
                $array['origin_level'] = $this->input->post('origin_level');
                $array['origin_content'] =  implode(',',$this->input->post('origin_content'));
                $array['dest_level'] = $this->input->post('dest_level');
                $array['dest_content'] =  implode(',',$this->input->post('dest_content'));
                $array['effective_date'] = strtotime($this->input->post('effective_date'));
                $array['discontinue_date'] = strtotime($this->input->post('discontinue_date'));
                $array['frequency'] = $this->input->post('frequency');
		$array['bag_type'] = $this->input->post('bag_type');
                $array['rule_auth'] = $this->input->post('rule_auth_carrier');
                $array['dep_time_start'] = $this->convertTimeToSeconds($this->input->post('dep_time_start'));
                $array['dep_time_end'] = $this->convertTimeToSeconds($this->input->post('dep_time_end'));
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
                        $this->data['rule'] = $this->bclr_m->get_single_bclr(array('bclr_id'=>$id));
                        if($this->data['rule']) {
                                $this->bclr_m->delete_bclr($id);
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("bclr/index"));
                        } else {
                                redirect(base_url("bclr/index"));
                        }
                } else {
                        redirect(base_url("bclr/index"));
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


	 $aColumns = array("MainSet.bclr_id","MainSet.carrier_code","MainSet.partner_carrier_code","MainSet.allowance","MainSet.aircraft_type","MainSet.flight_num_range","MainSet.from_cabin_value","MainSet.origin_level_value","SubSet.origin_content_data","MainSet.dest_level_value","SubSet.dest_content_data","MainSet.effective_date","MainSet.discontinue_date","MainSet.season_name","MainSet.frequency_value","MainSet.bag_type","MainSet.rule_auth_carrier_code","MainSet.dep_time_start","MainSet.dep_time_end","MainSet.min_unit","MainSet.max_capacity","MainSet.min_price","MainSet.max_price","MainSet.active");
		
	
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
                        $sWhere .= 'bc.carrierID IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';
                }


			


$sQuery = " SELECT SQL_CALC_FOUND_ROWS MainSet.bclr_id,MainSet.allowance,MainSet.flight_num_range,MainSet.effective_date,MainSet.discontinue_date,MainSet.bag_type,MainSet.dep_time_start,MainSet.dep_time_end,MainSet.min_unit,MainSet.max_capacity,MainSet.min_price,MainSet.max_price,MainSet.active,
                MainSet.carrier_code,MainSet.partner_carrier_code,MainSet.aircraft_type,MainSet.frequency_value,MainSet.from_cabin_value,MainSet.season_name,MainSet.rule_auth_carrier_code,MainSet.origin_level_value,MainSet.dest_level_value,
                SubSet.origin_content,SubSet.origin_content_data,SubSet.dest_content,SubSet.dest_content_data		
                FROM
                (
                SELECT bc.bclr_id,bc.allowance,bc.flight_num_range,bc.effective_date,bc.discontinue_date,bc.bag_type,bc.dep_time_start,bc.dep_time_end,bc.min_unit,bc.max_capacity,bc.min_price,bc.max_price,bc.active,ddc.code carrier_code,ddpc.code partner_carrier_code,ddat.aln_data_value aircraft_type,dfre.aln_data_value frequency_value,tca.aln_data_value as from_cabin_value,sea.season_name,ddac.code as rule_auth_carrier_code,dto.alias as origin_level_value,dtd.alias as dest_level_value		
                FROM BG_baggage_control_rule  bc
                LEFT JOIN  VX_data_defns ddc on (ddc.vx_aln_data_defnsID = bc.carrierID AND ddc.aln_data_typeID = 12) 
                LEFT JOIN VX_data_defns ddpc on (ddpc.vx_aln_data_defnsID = bc.partner_carrierID AND ddpc.aln_data_typeID = 12)    
                LEFT JOIN VX_data_defns ddac on (ddac.vx_aln_data_defnsID = bc.rule_auth AND ddpc.aln_data_typeID = 12)
                LEFT JOIN VX_data_types dto on (dto.vx_aln_data_typeID = bc.origin_level) 
                LEFT JOIN VX_data_types dtd on (dtd.vx_aln_data_typeID = bc.dest_level)     
                LEFT JOIN VX_data_defns ddat on (ddat.vx_aln_data_defnsID = bc.aircraft_typeID AND ddat.aln_data_typeID = 21)
                LEFT JOIN VX_data_defns dfre on (dfre.vx_aln_data_defnsID = bc.frequency)
                INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = bc.carrierID)
                INNER JOIN VX_data_defns tca on (tca.alias = fdef.level and tca.aln_data_typeID = 13 AND tca.vx_aln_data_defnsID = bc.from_cabin)
                LEFT JOIN VX_season sea on (sea.VX_aln_seasonID = bc.season_id )
                ) as MainSet 
                LEFT JOIN (
                SELECT 	origin_set.bclr_id,origin_set.origin_content,origin_set.origin_content_data,dest_set.dest_content,dest_set.dest_content_data 
                FROM (  
                SELECT bc.bclr_id,bc.origin_content,COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(m.market_name) ) AS origin_content_data FROM BG_baggage_control_rule bc 
                LEFT OUTER JOIN  VX_data_defns c ON 
                (find_in_set(c.vx_aln_data_defnsID, bc.origin_content) AND bc.origin_level in (1,2,3,4,5)) 
                LEFT OUTER JOIN  VX_market_zone m  
                ON (find_in_set(m.market_id, bc.origin_content) AND bc.origin_level = 17) GROUP BY bc.bclr_id
                ) as origin_set

                LEFT JOIN (
                        SELECT bc.bclr_id,bc.dest_content,COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(m.market_name)) AS dest_content_data FROM BG_baggage_control_rule bc 
                        LEFT OUTER JOIN  VX_data_defns c ON 
                        (find_in_set(c.vx_aln_data_defnsID, bc.dest_content) AND bc.dest_level in (1,2,3,4,5)) 
                        LEFT OUTER JOIN  VX_market_zone m  
                        ON (find_in_set(m.market_id, bc.dest_content) AND bc.dest_level = 17) GROUP BY bc.bclr_id
                ) as dest_set
                ON origin_set.bclr_id = dest_set.bclr_id    
                ) as SubSet
                on MainSet.bclr_id = SubSet.bclr_id 

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
                   $feed->bag_type_value = ($feed->bag_type == 1)?"KG":"Piece";
                   $feed->allowance = ($feed->allowance == 1)?"Whitelist":"Blacklist";
                   $feed->dep_time_start = gmdate("H:i:s", $feed->dep_time_start);
                   $feed->dep_time_end = gmdate("H:i:s", $feed->dep_time_end);
         	   $feed->chkbox = "<input type='checkbox'  class='deleteRow' value='".$feed->bclr_id."'  /> ".$rownum ;
                           $rownum++;   
		   
		   $feed->effective_date = ($feed->effective_date) ? date('d-m-Y',$feed->effective_date) : 'NA';
		   $feed->discontinue_date = ($feed->discontinue_date) ? date('d-m-Y',$feed->discontinue_date) : 'NA';
                   $feed->action = '';
                   if(permissionChecker('bclr_edit')){
			$feed->action .=  '<a href="#" class="btn btn-warning btn-xs mrg" id="edit_fclr"  data-placement="top" onclick="editbclr('.$feed->bclr_id.')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                   }
		
                  if(permissionChecker('bclr_delete')){
                        $feed->action .= btn_delete('fclr/delete/'.$feed->fclr_id, $this->lang->line('delete'));                   
                  }
                  $status = $feed->active;
                  $feed->active = "<div class='onoffswitch-small' id='".$feed->bclr_id."'>";
                  $feed->active .= "<input type='checkbox' id='myonoffswitch".$feed->bclr_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
                  if($status){
                     $feed->active .= " checked >";
                  } else {
                     $feed->active .= ">";
                  }
                  $feed->active .= "<label for='myonoffswitch".$feed->bclr_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
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
                if(permissionChecker('bclr_edit')) {
                        $id = $this->input->post('id');
                        $status = $this->input->post('status');
                        if($id != '' && $status != '') {
                                if((int)$id) {
                                        $data['modify_userID'] = $this->session->userdata('loginuserID');
                                        $data['modify_date'] = time();
                                        if($status == 'chacked') {
                                                $data['active'] = 1 ;
                                                $this->bclr_m->update_bclr($data, $id);
                                                echo 'Success';
                                        } elseif($status == 'unchacked') {
                                                $data['active'] = 0 ;
                                                $this->bclr_m->update_bclr($data, $id);
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
   

  public function delete_bclr_bulk_records(){
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


