<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("season_m");
		$this->load->model("airports_m");
		$this->load->model("airline_m");
		$this->load->model("trigger_m");
		$this->load->model("marketzone_m");
		$this->load->model("user_m");
		$this->load->model("season_airport_map_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('season', $language);	
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'season_name',
				'label' => $this->lang->line("season_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_name'
			),
			array(
				'field' => 'ams_orig_levelID',
				'label' => $this->lang->line("orig_level"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_valOrigLevel'
			),
			array(
				'field' => 'global_seasonID',
				'label' => $this->lang->line("season_seasonID"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_valGlobalSeasonID'
			),
			array(
				'field' => 'airlineID',
				'label' => $this->lang->line("season_airline"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_valAirline'
			),
   		    array(
                'field' => 'ams_orig_level_value[]',
                'label' => $this->lang->line("orig_level_value"),
                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valOrigLevelValue'
            ),
	        array(
                'field' => 'ams_dest_levelID',
                'label' => $this->lang->line('dest_level'),
                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valDestLevel'
            ),
			array(
                 'field' => 'ams_dest_level_value[]',
                 'label' => $this->lang->line("dest_level_value"),
                 'rules' => 'trim|required|max_length[200]|xss_clean|callback_valDestLevelValue'
             ),
			array(
                 'field' => 'ams_season_start_date',
                 'label' => $this->lang->line("season_start_date"),
                 'rules' => 'trim|required|max_length[200]|xss_clean'
            ),
			array(
                 'field' => 'ams_season_end_date',
                 'label' => $this->lang->line("season_end_date"),
                 'rules' => 'trim|required|max_length[200]|xss_clean'
            ),
			array(
                 'field' => 'is_return_inclusive',
                 'label' => $this->lang->line("is_return_inclusive"),
                 'rules' => 'trim|required|max_length[200]|xss_clean'
            ),
			array(
                 'field' => 'season_color',
                 'label' => $this->lang->line("season_color"),
                 'rules' => 'trim|required|max_length[200]|xss_clean'
            )
			/* array(
                 'field' => 'active',
                 'label' => $this->lang->line("active"),
                 'rules' => 'trim|required|max_length[200]|xss_clean'
            ) */
		);
		return $rules;
	}
	
	public function unique_name($post_string) {
      $id = $this->input->post("season_id");
      if((int)$id) {
             $season =  $this->season_m->get_single_season(array('VX_aln_seasonID !='=>$id,'season_name'=>$post_string));
              if(count($season)) {
                      $this->form_validation->set_message("unique_name", "%s already exists");
                      return FALSE;
              }
              return TRUE;
      } else {
              $season =  $this->season_m->get_single_season(array('season_name'=>$post_string));
            
              if(count($season)) {
                      $this->form_validation->set_message("unique_name", "%s already exists");
                      return FALSE;
              }
              return TRUE;
      }
    }
	
	function valAirline($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valAirline", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valGlobalSeasonID($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("global_seasonID", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	function valOrigLevel($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valOrigLevel", "%s is required");
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
	
	function valDestLevel($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valDestLevel", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valDestLevelValue($post_array){        
	  if(count($post_array) < 1){
		 $this->form_validation->set_message("valDestLevelValue", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	public function index() {
		  $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css',                   
						//'assets/datepicker/datepicker.css'
                ),
                'js' => array(
                        'assets/select2/select2.js',                       
						//'assets/datepicker/datepicker.js'
                )
        );	 
		if(!empty($this->input->post('seasonID'))){
          $this->data['seasonID'] = $this->input->post('seasonID');
        } else {
          $this->data['seasonID'] = 0;
        }
        if(!empty($this->input->post('origID'))){
          $this->data['origID'] = $this->input->post('origID');
        } else {
          $this->data['origID'] = 0;
        }
        if(!empty($this->input->post('destID'))){
          $this->data['destID'] = $this->input->post('destID');
        } else {
          $this->data['destID'] = 0;
        }
		if(!empty($this->input->post('origValues'))){
          $this->data['origValues'] = $this->input->post('origValues');
        } else {
          $this->data['origValues'] = 0;
        }
        if(!empty($this->input->post('destValues'))){
          $this->data['destValues'] = $this->input->post('destValues');
        } else {
          $this->data['destValues'] = 0;
        }
        if(!empty($this->input->post('active'))){
          $this->data['active'] = $this->input->post('active');
        } else {
            $this->data['active'] = 1;
        }
		/* if(!empty($this->input->post('airlinecode'))){
          $this->data['airlinecode'] = $this->input->post('airlinecode');
        } else {
          $this->data['airlinecode'] = "";
        } */
	if(!empty($this->input->post('filter_airline'))){
          $this->data['filter_airline'] = $this->input->post('filter_airline');
        } else {
		  if($this->session->userdata('default_airline')){
		     $this->data['filter_airline'] = $this->session->userdata('default_airline'); 
		  } else {
			  if($this->session->userdata('login_user_airlineID')){
				$this->data['filter_airline'] = $this->session->userdata('login_user_airlineID');
			  } else {
				$this->data['filter_airline'] = 0;
			  }
		  }
        } 
        $this->data['reconfigure'] =  $this->trigger_m->get_trigger_time('VX_season');
		
                $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');

        if($this->session->userdata('roleID') != 1){			
		   $this->data['seasonslist'] = $this->season_m->get_seasons_where(null,$this->session->userdata('login_user_airlineID'));
		}else{
		   $this->data['seasonslist'] = $this->season_m->get_seasons_where(); 
		}  
		   $this->data['seasons'] = $this->season_m->get_global_seasons(); 
		   foreach($this->data['seasonslist'] as $season){
			  $season->origin_values = $this->season_m->getSeasonValues($season->ams_orig_levelID,explode(',',$season->ams_orig_level_value));
			 $season->dest_values = $this->season_m->getSeasonValues($season->ams_dest_levelID,explode(',',$season->ams_dest_level_value));
             $season->ams_season_start_date = date('m/d/Y',$season->ams_season_start_date);
		     $season->ams_season_end_date = date('m/d/Y',$season->ams_season_end_date);
            $season->dates = $this->createDateRange($season->ams_season_start_date,$season->ams_season_end_date);		
           }			
      // print_r($this->data['seasonslist']); exit;
		$this->data['types'] = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
			if($roleID != 1){
			 $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		   } else {
			   $this->data['airlines'] = $this->airline_m->getAirlinesData();
		   }
		  // print_r($this->data['airlines']); exit;
		$this->data["subview"] = "season/index";
		$this->load->view('_layout_main', $this->data);		
	}


	function getSeasonsForAirline(){
		$airlineid = $this->input->post('id');
		$seasonslist = $this->season_m->get_seasons_for_airline($airlineid);

		foreach($seasonslist as $season){
			 $season->origin_values = $this->season_m->getSeasonValues($season->ams_orig_levelID,explode(',',$season->ams_orig_level_value));
			 $season->dest_values = $this->season_m->getSeasonValues($season->ams_dest_levelID,explode(',',$season->ams_dest_level_value));
             	    $season->ams_season_start_date = date('m/d/Y',$season->ams_season_start_date);
                    $season->ams_season_end_date = date('m/d/Y',$season->ams_season_end_date);
            	    $season->dates = $this->createDateRange($season->ams_season_start_date,$season->ams_season_end_date);
                }


		 $this->output->set_content_type('application/json');
	         $this->output->set_output(json_encode($seasonslist));

	}
	
	function createDateRange($startDate, $endDate, $format = "m/d/Y"){
		$begin = new DateTime($startDate);
		$end = new DateTime($endDate);
         $end->modify('+1 day');
		$interval = new DateInterval('P1D'); // 1 Day
		$dateRange = new DatePeriod($begin, $interval, $end);

		$range = [];
		foreach ($dateRange as $date) {
			$range[] = $date->format($format);
		}

		return $range;
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
	
	    $roleID = $this->session->userdata('roleID');
		$userID = $this->session->userdata('loginuserID');
	   $this->data['types'] = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
	    if($roleID != 1){
		  $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
	   } else {
		   $this->data['airlines'] = $this->airline_m->getAirlinesData();
	   }
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "season/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array["season_name"] = $this->input->post("season_name");
				$array["airlineID"] = $this->input->post("airlineID");
				$array["ams_orig_levelID"] = $this->input->post("ams_orig_levelID");
				$array["ams_orig_level_value"] = implode(',',$this->input->post("ams_orig_level_value"));
				$array["ams_dest_levelID"] = $this->input->post("ams_dest_levelID");
				$array["ams_dest_level_value"] = implode(',',$this->input->post("ams_dest_level_value"));
				$array["ams_season_start_date"] = strtotime($this->input->post("ams_season_start_date"));
				$array["ams_season_end_date"] = strtotime($this->input->post("ams_season_end_date"));
				$array['is_return_inclusive'] = $this->input->post("is_return_inclusive");
				$array['season_color'] = $this->input->post("season_color");
				$array["active"] = $this->input->post("active");
				$array["create_date"] = time();
				$array["modify_date"] = time();
				$array["create_userID"] = $this->session->userdata('loginuserID');
			    $array["modify_userID"] = $this->session->userdata('loginuserID');
				
				$this->season_m->insert_season($array);
				
			      // insert entry in trigger table for mapping table generation
		
				$tarray['table_name'] = 'VX_season';
				$tarray['create_date'] = time();
				$tarray['modify_date'] = time();
				$tarray['create_userID'] = $this->session->userdata('loginuserID');
				$tarray['modify_userID'] = $this->session->userdata('loginuserID');
				$tarray['isReconfigured'] = '1';
			
			    $this->trigger_m->insert_trigger($tarray);		
				
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("season/index"));
			}
		} else {
			$this->data["subview"] = "season/add";
			$this->load->view('_layout_main', $this->data);
		}
	}
	
	public function save() {     
		if($_POST) {
			$season_id = $this->input->post("season_id");			
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$json['status'] = validation_errors();	
                $json['errors'] = array(
                'season_name' => form_error('season_name'),
                'airlineID' => form_error('airlineID'),
                'ams_orig_levelID' => form_error('ams_orig_levelID'),
                'ams_orig_level_value' => form_error('ams_orig_level_value[]'),
                'ams_dest_levelID' => form_error('ams_dest_levelID'),
				'ams_dest_level_value' => form_error('ams_dest_level_value[]'),
				'ams_season_start_date' => form_error('ams_season_start_date'),
				'ams_season_end_date' => form_error('ams_season_end_date'),
				'global_seasonID' => form_error('global_seasonID'),
				'season_color' => form_error('season_color'),
				'is_return_inclusive' => form_error('is_return_inclusive')
                );				
			} else {				
				$array["season_name"] = $this->input->post("season_name");
				$array["airlineID"] = $this->input->post("airlineID");
				$array["global_seasonID"] = $this->input->post("global_seasonID");
				$array["ams_orig_levelID"] = $this->input->post("ams_orig_levelID");
				$array["ams_orig_level_value"] = implode(',',$this->input->post("ams_orig_level_value"));
				$array["ams_dest_levelID"] = $this->input->post("ams_dest_levelID");
				$array["ams_dest_level_value"] = implode(',',$this->input->post("ams_dest_level_value"));
				$array["ams_season_start_date"] = strtotime($this->input->post("ams_season_start_date"));
				$array["ams_season_end_date"] = strtotime($this->input->post("ams_season_end_date"));
				$array['is_return_inclusive'] = $this->input->post("is_return_inclusive");
				$array['season_color'] = $this->input->post("season_color");
				
				if( $season_id) {
					$array["modify_date"] = time();
					$array["modify_userID"] = $this->session->userdata('loginuserID');
					$this->season_m->update_season($array,$season_id);
			 	  } else {	
					$array["active"] = 1;
					$array["create_date"] = time();
					$array["modify_date"] = time();
					$array["create_userID"] = $this->session->userdata('loginuserID');
					$array["modify_userID"] = $this->session->userdata('loginuserID');					
					$this->season_m->insert_season($array);
				 }			
				

				 if($this->session->userdata('roleID') != 1){
			                   $seasonslist = $this->season_m->get_seasons_where(null,$this->session->userdata('login_user_airlineID'));
                		}else{
                   				$seasonslist = $this->season_m->get_seasons_where();
                		}
                  			 foreach($seasonslist as $season){
								 $season->origin_values = $this->season_m->getSeasonValues($season->ams_orig_levelID,explode(',',$season->ams_orig_level_value));
								 $season->dest_values = $this->season_m->getSeasonValues($season->ams_dest_levelID,explode(',',$season->ams_dest_level_value));
				             $season->ams_season_start_date = date('m/d/Y',$season->ams_season_start_date);
			                    $season->ams_season_end_date = date('m/d/Y',$season->ams_season_end_date);
				            $season->dates = $this->createDateRange($season->ams_season_start_date,$season->ams_season_end_date);
				           }

					$json['season_list'] = $seasonslist;
			      // insert entry in trigger table for mapping table generation
		         
				$tarray['table_name'] = 'VX_season';
				$tarray['create_date'] = time();
				$tarray['modify_date'] = time();
				$tarray['create_userID'] = $this->session->userdata('loginuserID');
				$tarray['modify_userID'] = $this->session->userdata('loginuserID');
				$tarray['isReconfigured'] = '1';
			
			    $this->trigger_m->insert_trigger($tarray);				
				$json['status'] = "success";
				$json['has_reconf_perm'] = permissionChecker('season_reconfigure');
			}
		} else {
			$json['status'] = "no data";
		}

		 $this->output->set_content_type('application/json');
         $this->output->set_output(json_encode($json));
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
        $roleID = $this->session->userdata('roleID');
		$userID = $this->session->userdata('loginuserID');		
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['season'] = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$id));
			if($this->data['season']) {
			   if($roleID != 1){
				 $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
			   } else {
				   $this->data['airlines'] = $this->airline_m->getAirlinesData();
			   }
			 $this->data['types'] = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) { 
					    //echo validation_errors();
						$this->data["subview"] = "season/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {
						$array["season_name"] = $this->input->post("season_name");
						$array["airlineID"] = $this->input->post("airlineID");
						$array["global_seasonID"] = $this->input->post("global_seasonID");
						$array["ams_orig_levelID"] = $this->input->post("ams_orig_levelID");
						$array["ams_orig_level_value"] = implode(',',$this->input->post("ams_orig_level_value"));
						$array["ams_dest_levelID"] = $this->input->post("ams_dest_levelID");
						$array["ams_dest_level_value"] = implode(',',$this->input->post("ams_dest_level_value"));
						$array["ams_season_start_date"] = strtotime($this->input->post("ams_season_start_date"));
						$array["ams_season_end_date"] = strtotime($this->input->post("ams_season_end_date"));
						$array['is_return_inclusive'] = $this->input->post("is_return_inclusive");
						$array['season_color'] = $this->input->post("season_color");
						$array["active"] = $this->input->post("active");						
						$array["modify_date"] = time();						
						$array["modify_userID"] = $this->session->userdata('loginuserID');
						
						$this->season_m->update_season($array,$id);
						
						  // insert entry in trigger table for mapping table generation
				
						$tarray['table_name'] = 'VX_season';
						$tarray['create_date'] = time();
						$tarray['modify_date'] = time();
						$tarray['create_userID'] = $this->session->userdata('loginuserID');
						$tarray['modify_userID'] = $this->session->userdata('loginuserID');
						$tarray['isReconfigured'] = '1';
					
					    $this->trigger_m->insert_trigger($tarray);	 	
						
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("season/index"));
					}
				} else {
					$this->data["subview"] = "season/edit";
					$this->load->view('_layout_main', $this->data);
				}
			} else { echo "dddd";
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
			$this->data['season'] = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$id));
			if($this->data['season']) {
				$this->season_m->delete_season($id);
				$this->season_airport_map_m->delete_old_orig_entries($id);
				$this->season_airport_map_m->delete_old_dest_entries($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("season/index"));
			} else {
				redirect(base_url("season/index"));
			}
		} else {
			redirect(base_url("season/index"));
		}
	}
	
	public function view() {
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
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
			$season = $this->season_m->get_seasons_where(array('VX_aln_seasonID'=>$id))[0];
			 $season->ams_season_start_date = date('d-m-Y',$season->ams_season_start_date);	  
		     $season->ams_season_end_date = date('d-m-Y',$season->ams_season_end_date);
		  
		     $season->is_return_inclusive = ($season->is_return_inclusive)?"yes":"no";
			 $orig_where = explode(',',$season->ams_orig_level_value);
			 $dest_where = explode(',',$season->ams_dest_level_value);
			 if($season->orig_type == 17){
			   $orig_values = $this->marketzone_m->get_marketzones($orig_where); 
               $orig_level_values = implode(', ',array_map(function ($object) { return $object->market_name; }, $orig_values));			   
			} else {
               $orig_values = $this->airports_m->getDefinitionList($orig_where);
			   if($season->orig_type == 4 || $season->orig_type == 5){
			   $orig_level_values = implode(', ',array_map(function ($object) { return $object->aln_data_value; }, $orig_values));
			   } else {
			    $orig_level_values = implode(', ',array_map(function ($object) { return $object->code; }, $orig_values));
			   }
			}
			if($season->dest_type == 17){
			  $dest_values = $this->marketzone_m->get_marketzones($dest_where);
			  $dest_level_values = implode(', ',array_map(function ($object) { return $object->market_name; }, $dest_values));
			} else {
              $dest_values = $this->airports_m->getDefinitionList($dest_where);
			   if($season->dest_type == 4 || $season->dest_type == 5){
              $dest_level_values = implode(', ',array_map(function ($object) { return $object->aln_data_value; }, $dest_values));
			   } else {
              $dest_level_values = implode(', ',array_map(function ($object) { return $object->code; }, $dest_values));
			   }			  
			}
			
            $season->orig_level_values = $orig_level_values;
			$season->dest_level_values = $dest_level_values;			
		   
			$this->data["season"] = $season; 
			//print_r($this->data['season'] ); exit;
			if($this->data["season"]) {
				$this->data["subview"] = "season/view";
				$this->load->view('_layout_main', $this->data);
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}
	
	public function getSeasonData() {
		$id = $this->input->post('season_id');
		if((int)$id) {
          $season = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$id));
		  $season->ams_season_start_date=date('d-m-Y',$season->ams_season_start_date);
		  $season->ams_season_end_date=date('d-m-Y',$season->ams_season_end_date);
		  $season->origin_values = $this->season_m->getSeasonValues($season->ams_orig_levelID,explode(',',$season->ams_orig_level_value));
		  $season->dest_values = $this->season_m->getSeasonValues($season->ams_dest_levelID,explode(',',$season->ams_dest_level_value));
		   $season->dates = $this->createDateRange($season->ams_season_start_date,$season->ams_season_end_date);
        }	
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($season));
	}
	
	
	
	public function getSeasonInfo() {
		$id = $this->input->post('season_id');
		if((int)$id) {
          $season = $this->season_m->get_seasons_where(array('VX_aln_seasonID'=>$id))[0];
		   $season->origin_values = $this->season_m->getSeasonValues($season->ams_orig_levelID,explode(',',$season->ams_orig_level_value));
		   $season->dest_values = $this->season_m->getSeasonValues($season->ams_dest_levelID,explode(',',$season->ams_dest_level_value));
		  $season->ams_season_start_date=date('d-m-Y',$season->ams_season_start_date);
		  $season->ams_season_end_date=date('d-m-Y',$season->ams_season_end_date);
		   $season->dates = $this->createDateRange($season->ams_season_start_date,$season->ams_season_end_date);
        }	
          $seasons[] = $season; 		
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($seasons));
	}
  
    function active() {
		if(permissionChecker('season_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				if((int)$id) {
					$data['modify_userID'] = $this->session->userdata('loginuserID');
					$data['modify_date'] = time();
					if($status == 'chacked') {
						$data['active'] = 1 ;
						$this->season_m->update_season($data, $id);
						echo 'Success';
					} elseif($status == 'unchacked') {
						$data['active'] = 0 ;
						$this->season_m->update_season($data, $id);
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
	
	function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');	  
				
	    $aColumns = array('s.VX_aln_seasonID','s.season_name','dd.aln_data_value','dd.code','dt1.name','s.ams_orig_level_value','dt2.name','s.ams_dest_level_value','s.ams_season_start_date','s.ams_season_end_date','s.is_return_inclusive','s.season_color','s.active');
	
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
			
			$roleID = $this->session->userdata('roleID');
			$userID = $this->session->userdata('loginuserID');
			if($roleID != 1){
				$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
               // $sWhere .= 'c.userID = '.$userID;	
			   $sWhere .= ' s.airlineID  IN ('.implode(',',$this->session->userdata('login_user_airlineID')).')';
			}
		
        if(!empty($this->input->get('seasonID'))){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= 's.VX_aln_seasonID = '.$this->input->get('seasonID');		 
	     }			
		if(!empty($this->input->get('origID'))){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= 's.ams_orig_levelID = '.$this->input->get('origID');		 
	     }			 
		if(!empty($this->input->get('destID'))){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= 's.ams_dest_levelID = '.$this->input->get('destID');		 
	     }		 
		if($this->input->get('active') != NULL){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= 's.active = '.$this->input->get('active');		 
	     }
        /* if($this->input->get('airlinecode') != NULL){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= 
		   " CONCAT(dd.code,'_',dd.aln_data_value) like '%".$this->input->get('airlinecode')."%'";		 
	     } */
		 if(!empty($this->input->get('filter_airline'))){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= " dd.vx_aln_data_defnsID like '%".$this->input->get('filter_airline')."%'"; 
	     }
		if(!empty($this->input->get('origValues'))){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= "s.ams_orig_level_value like '%".$this->input->get('origValues')."%'";		 
	     }         
        if(!empty($this->input->get('destValues'))){
		   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= "s.ams_dest_level_value like '%".$this->input->get('destValues')."%'";		 
	     }		 
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS s.*,ds.aln_data_value as global_season,dd.aln_data_value airline_name,dd.code airline_code,dt1.vx_aln_data_typeID orig_type,dt1.alias orig_level,dt2.vx_aln_data_typeID dest_type,dt2.alias dest_level from VX_season s LEFT JOIN VX_data_types dt1 ON dt1.vx_aln_data_typeID = s.ams_orig_levelID LEFT JOIN VX_data_types dt2 ON dt2.vx_aln_data_typeID = s.ams_dest_levelID LEFT JOIN VX_data_defns dd ON dd.vx_aln_data_defnsID = s.airlineID  LEFT JOIN VX_data_defns ds ON ds.vx_aln_data_defnsID = s.global_seasonID
		$sWhere			
		$sOrder
		$sLimit	"; 
	//print_r($sQuery); exit;
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
	  foreach($rResult as $season){	

		 $season->chkbox = "<input type='checkbox'  class='deleteRow' value='".$season->VX_aln_seasonID."'  /> ".$rownum ;
                                $rownum++;
          $season->ams_season_start_date = date('d-m-Y',$season->ams_season_start_date);	  
		  $season->ams_season_end_date = date('d-m-Y',$season->ams_season_end_date);
		  
		  $season->is_return_inclusive = ($season->is_return_inclusive)?"yes":"no";
		  
		  if(permissionChecker('season_edit')){ 			
			//$season->action = btn_edit('season/edit/'.$season->VX_aln_seasonID, $this->lang->line('edit'));
			$season->action .=  '<a href="#" class="btn btn-warning btn-xs mrg" id="edit_market"  data-placement="top" onclick="editseason('.$season->VX_aln_seasonID.')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
		  }
		  if(permissionChecker('season_delete')){
		   $season->action .= btn_delete('season/delete/'.$season->VX_aln_seasonID, $this->lang->line('delete'));			 
		  }
		  if(permissionChecker('season_view') ) {
		   $season->action .= btn_view('season/view/'.$season->VX_aln_seasonID, $this->lang->line('view'));
		  }
			$status = $season->active;
			$season->active = "<div class='onoffswitch-small' id='".$season->VX_aln_seasonID."'>";
            $season->active .= "<input type='checkbox' id='myonoffswitch".$season->VX_aln_seasonID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $season->active .= " checked >";
			} else {
			   $season->active .= ">";
			}	
			
			$season->active .= "<label for='myonoffswitch".$season->VX_aln_seasonID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
			
            $orig_where = explode(',',$season->ams_orig_level_value);
			$dest_where = explode(',',$season->ams_dest_level_value);
			if($season->orig_type == 17){
			   $orig_values = $this->marketzone_m->get_marketzones($orig_where); 
               $orig_level_values = implode(', ',array_map(function ($object) { return $object->market_name; }, $orig_values));			   
			} else {
               $orig_values = $this->airports_m->getDefinitionList($orig_where);
			   if($season->orig_type == 4 || $season->orig_type == 5){
			   $orig_level_values = implode(', ',array_map(function ($object) { return $object->aln_data_value; }, $orig_values));
			   } else {
			    $orig_level_values = implode(', ',array_map(function ($object) { return $object->code; }, $orig_values));
			   }
			}
			if($season->dest_type == 17){
			  $dest_values = $this->marketzone_m->get_marketzones($dest_where);
			  $dest_level_values = implode(', ',array_map(function ($object) { return $object->market_name; }, $dest_values));
			} else {
              $dest_values = $this->airports_m->getDefinitionList($dest_where);
			   if($season->dest_type == 4 || $season->dest_type == 5){
              $dest_level_values = implode(', ',array_map(function ($object) { return $object->aln_data_value; }, $dest_values));
			   } else {
              $dest_level_values = implode(', ',array_map(function ($object) { return $object->code; }, $dest_values));
			   }			  
			}
           
			
			
           $season->orig_level_values = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$orig_level_values.'"><i class="fa fa-list"></i></a>';
		   $season->dest_level_values = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$dest_level_values.'"><i class="fa fa-list"></i></a>';
		   
		    $season->orig_level_values = $orig_level_values;
			$season->dest_level_values = $dest_level_values;
			$season->color = $season->season_color;
		   $season->season_color = '<p class="season-list-color" style="background: '.$season->season_color.'"></p>';
			
			$output['aaData'][] = $season;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array("#","Season","Carrier","Carrier Code","Orig Level","Orig Level Values","Dest Level","Dest Level values","Start date","End Date","Return inclusive","Color");
		  $rows = array("VX_aln_seasonID","season_name","airline_name","airline_code","orig_level","orig_level_values","dest_level","dest_level_values","ams_season_start_date","ams_season_end_date","is_return_inclusive","color");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
   
    public function searchAirlineCode(){
	  if(!empty($_GET['search'])){
		
		 $search_info = $this->season_m->searchAirlineCode($_GET['search']);        			 
	
		} else {
			$search_info = array();
		}		
		echo json_encode($search_info);
    }


public function delete_season_bulk_records(){
	$data_ids = $_REQUEST['data_ids'];
	$data_id_array = explode(",", $data_ids);
	if(!empty($data_id_array)) {
		foreach($data_id_array as $id) {
		$this->data['season'] = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$id));
							if($this->data['season']) {
									$this->season_m->delete_season($id);
							}
		}
	}
     if($this->session->userdata('roleID') != 1){
		   $json['seasonslist'] = $this->season_m->get_seasons_where(null,$this->session->userdata('login_user_airlineID'));
		}else{
		   $json['seasonslist'] = $this->season_m->get_seasons_where(); 
		}  
		   foreach($json['seasonslist'] as $season){
			 $season->origin_values = $this->season_m->getSeasonValues($season->ams_orig_levelID,explode(',',$season->ams_orig_level_value));
			 $season->dest_values = $this->season_m->getSeasonValues($season->ams_dest_levelID,explode(',',$season->ams_dest_level_value));
             $season->ams_season_start_date = date('m/d/Y',$season->ams_season_start_date);
		    $season->ams_season_end_date = date('m/d/Y',$season->ams_season_end_date);
            $season->dates = $this->createDateRange($season->ams_season_start_date,$season->ams_season_end_date);		
           }
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));

   }

}
