<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("season_m");
		$this->load->model("airports_m");
		$this->load->model("trigger_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('season', $language);	
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'season_name',
				'label' => $this->lang->line("season_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'ams_orig_levelID',
				'label' => $this->lang->line("orig_level"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_valOrigLevel'
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
            ),
			array(
                 'field' => 'active',
                 'label' => $this->lang->line("active"),
                 'rules' => 'trim|required|max_length[200]|xss_clean'
            )
		);
		return $rules;
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
        $this->data['reconfigure'] =  $this->trigger_m->get_trigger_time('VX_aln_season');		
		$this->data["subview"] = "season/index";
		$this->load->view('_layout_main', $this->data);		
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
	
	   $this->data['types'] = $this->airports_m->getDefdataTypes(array('1','7','8','9','10','11','6'));
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "season/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array["season_name"] = $this->input->post("season_name");
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
		
				$tarray['table_name'] = 'VX_aln_season';
				$tarray['create_date'] = time();
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
			$this->data['season'] = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$id));
			if($this->data['season']) {
			 $this->data['types'] = $this->airports_m->getDefdataTypes(array('1','7','8','9','10','11','6'));
				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) { 
						$this->data["subview"] = "season/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {
						$array["season_name"] = $this->input->post("season_name");
						$array["ams_orig_levelID"] = $this->input->post("ams_orig_levelID");
						$array["ams_orig_level_value"] = implode(',',$this->input->post("ams_orig_level_value"));
						$array["ams_dest_levelID"] = $this->input->post("ams_dest_levelID");
						$array["ams_dest_level_value"] = implode(',',$this->input->post("ams_dest_level_value"));
						$array["ams_season_start_date"] = strtotime($this->input->post("ams_season_start_date"));
						$array["ams_season_end_date"] = strtotime($this->input->post("amz_excl_value"));
						$array['is_return_inclusive'] = $this->input->post("is_return_inclusive");
						$array['season_color'] = $this->input->post("season_color");
						$array["active"] = $this->input->post("active");						
						$array["modify_date"] = time();						
						$array["modify_userID"] = $this->session->userdata('loginuserID');
						
						$this->season_m->update_season($array,$id);
						
						  // insert entry in trigger table for mapping table generation
				
						$tarray['table_name'] = 'VX_aln_season';
						$tarray['create_date'] = time();
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
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
			$this->data['season'] = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$id));
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
		$usertypeID = $this->session->userdata('usertypeID');	  
				
	    $aColumns = array('s.VX_aln_seasonID','s.season_name','dt1.name','s.ams_orig_level_value','dt2.name','s.ams_dest_level_value','s.ams_season_start_date','s.ams_season_end_date','s.is_return_inclusive','s.season_color','s.active');
	
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
			
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS s.*,dt1.name orig_level,dt2.name dest_level from vx_aln_season s LEFT JOIN vx_aln_data_types dt1 ON dt1.vx_aln_data_typeID = s.ams_orig_levelID LEFT JOIN vx_aln_data_types dt2 ON dt2.vx_aln_data_typeID = s.ams_orig_levelID
		$sWhere			
		$sOrder
		$sLimit	"; 
	
	$rResult = $this->install_m->run_query($sQuery);
	$sQuery = "SELECT FOUND_ROWS() as total";
	$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
			
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $rResultFilterTotal,
		"iTotalDisplayRecords" => $rResultFilterTotal,
		"aaData" => array()
	  );
	  foreach($rResult as $season){	
          $season->ams_season_start_date = date('d-m-Y',$season->ams_season_start_date);	  
		  $season->ams_season_end_date = date('d-m-Y',$season->ams_season_end_date);
		  
		  $season->is_return_inclusive = ($season->is_return_inclusive)?"yes":"no";
		  
		  if(permissionChecker('season_edit')){ 			
			$season->action = btn_edit('season/edit/'.$season->VX_aln_seasonID, $this->lang->line('edit'));
		  }
		  if(permissionChecker('season_delete')){
		   $season->action .= btn_delete('season/delete/'.$season->VX_aln_seasonID, $this->lang->line('delete'));			 
		  }
		  if(permissionChecker('season_view') ) {
		   //$season->action .= btn_view('season/view/'.$season->VX_aln_seasonID, $this->lang->line('view'));
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
			
            $orig_values = $this->airports_m->getDefinitionList($orig_where);
            $dest_values = $this->airports_m->getDefinitionList($dest_where); 
			
            $orig_level_values = implode(',',array_map(function ($object) { return $object->aln_data_value; }, $orig_values));
			$dest_level_values = implode(',',array_map(function ($object) { return $object->aln_data_value; }, $dest_values));
			
           $season->orig_level_values = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$orig_level_values.'"><i class="fa fa-list"></i></a>';
		   $season->dest_level_values = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$dest_level_values.'"><i class="fa fa-list"></i></a>';
			
			$output['aaData'][] = $season;				
		}
		echo json_encode( $output );
	}


}