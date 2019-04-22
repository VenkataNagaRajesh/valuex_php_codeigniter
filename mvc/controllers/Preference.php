<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preference extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("preference_m");
		$this->load->model("airports_m");		
		$language = $this->session->userdata('lang');
		$this->lang->load('preference', $language);	
	}

	public function index() {		
		$this->data["subview"] = "preference/index";
		$this->load->view('_layout_main', $this->data);		
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'categoryID', 
				'label' => $this->lang->line("preference_category"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_category'
			),
			array(
				'field' => 'pref_type', 
				'label' => $this->lang->line("preference_type"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valPreftype'
			),
			array(
				'field' => 'pref_code', 
				'label' => $this->lang->line("preference_code"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_uniquecode'
			),
			array(
				'field' => 'pref_display_name', 
				'label' => $this->lang->line("preference_display_name"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'pref_value', 
				'label' => $this->lang->line("preference_value"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'pref_get_value_type', 
				'label' => $this->lang->line("preference_get_value_type"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valPrefGetValueType'
			),
			array(
				'field' => 'pref_get_value', 
				'label' => $this->lang->line("preference_get_value"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valPrefGetValue'
			),
			array(
				'field' => 'active', 
				'label' => $this->lang->line("preference_active"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valactive'
			)
		);
		return $rules;
	}
	
	function category($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("category", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valPreftype($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valPreftype", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valPrefGetValueType($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valPrefGetValueType", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valPrefGetValue($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valPrefGetValue", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valactive($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("active", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	public function uniquecode($post_string) {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
		
			return TRUE;
		} else {
			$preference = $this->preference_m->get_preference(array('pref_code'=>$post_string));
			if(count($preference)) {
				$this->form_validation->set_message("uniquecode", "%s already exists");
				return FALSE;
			}
			return TRUE;
		}	
	}

	public function add() {	
	  $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css',
                        'assets/fselect/fSelect.css'
                ),
                'js' => array(
                        'assets/select2/select2.js',
                        'assets/fselect/fSelect.js',
                )
        );
      $this->data['catlist'] = $this->airports_m->getDefns(6);
      $this->data['pref_types'] = $this->airports_m->getDefns(7);
      $this->data['valuetypes'] = $this->airports_m->getDefdataTypes(null,array('8','9','10'));	 
     //  print_r( $this->data['valuetypes']); exit;	  
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "preference/add";
				$this->load->view('_layout_main', $this->data);			
			} else {				
				$array = array(
				    "categoryID" => $this->input->post('categoryID'),
					"pref_type" => $this->input->post('pref_type'),
					"pref_code" => $this->input->post('pref_code'),
					"pref_display_name" => $this->input->post('pref_display_name'),
					"pref_get_value_type" => $this->input->post('pref_get_value_type'),
					"pref_get_value" => $this->input->post('pref_get_value'),
					"pref_value" => $this->input->post('pref_value'),
					"create_date" => time(),
					"modify_date" => time(),
					"create_userID" => $this->session->userdata('loginuserID'),
                    "modify_userID" => $this->session->userdata('loginuserID'),					
				);
				$this->preference_m->insert_preference($array);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("preference/index"));
			}
		} else {
			$this->data["subview"] = "preference/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit() {
        $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css',
                        'assets/fselect/fSelect.css'
                ),
                'js' => array(
                        'assets/select2/select2.js',
                        'assets/fselect/fSelect.js',
                )
        );		
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['preference'] = $this->preference_m->get_preference(array('VX_aln_preferenceID'=>$id));
			 if($this->data['preference']) {
			  $this->data['catlist'] = $this->airports_m->getDefns(6);
			  $this->data['pref_types'] = $this->airports_m->getDefns(7);
			  $this->data['valuetypes'] = $this->airports_m->getDefdataTypes(null,array('8','9','10'));	 	  
				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) { 
						$this->data["subview"] = "preference/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {				
						$array = array(
							"categoryID" => $this->input->post('categoryID'),
							"pref_type" => $this->input->post('pref_type'),
							"pref_code" => $this->input->post('pref_code'),
							"pref_display_name" => $this->input->post('pref_display_name'),
							"pref_get_value_type" => $this->input->post('pref_get_value_type'),
							"pref_get_value" => $this->input->post('pref_get_value'),
							"pref_value" => $this->input->post('pref_value'),							
							"modify_date" => time(),							
							"modify_userID" => $this->session->userdata('loginuserID'),					
						);
						$this->preference_m->update_preference($array,$id);
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("preference/index"));
					}
				} else {
					$this->data["subview"] = "preference/edit";
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
			$this->data['preference'] = $this->preference_m->get_preference(array('VX_aln_preferenceID'=>$id));
			if($this->data['preference']) {			
					$this->preference_m->delete_preference($id);
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("preference/index"));			
			} else {
				redirect(base_url("preference/index"));
			}
		} else {
			redirect(base_url("preference/index"));
		}	

	}
	
	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
		  $this->data["preference"] = $this->preference_m->get_preference_data($id);
			if($this->data["preference"]) {
				$this->data["subview"] = "preference/view";
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
		if(permissionChecker('preference_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['modify_date'] = time();
				if($status == 'chacked') {
					$data['active'] = 1 ;
					$this->preference_m->update_preference($data, $id);
					echo 'Success';
				} elseif($status == 'unchacked') {
					$data['active'] = 0 ;
					$this->preference_m->update_preference($data, $id);
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
	}
	
	function server_processing(){		
		$aColumns = array('p.VX_aln_preferenceID','dd.aln_data_value','dd1.aln_data_value','p.pref_code','pref_display_name','preference_value','dt1.name','dt2.name','p.active');
	
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
			
			
		$sQuery = "SELECT p.*,dd.aln_data_value category,dd1.aln_data_value type,dt1.name valuetype,dt2.name value FROM VX_aln_preference p LEFT JOIN vx_aln_data_defns dd ON dd.vx_aln_data_defnsID = p.categoryID LEFT JOIN vx_aln_data_defns dd1 ON dd1.vx_aln_data_defnsID = p.pref_type LEFT JOIN vx_aln_data_types dt1 ON dt1.vx_aln_data_typeID = p.pref_get_value_type LEFT JOIN vx_aln_data_types dt2 ON dt2.vx_aln_data_typeID = p.pref_get_value
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
	  foreach($rResult as $preference){		 	
		  if(permissionChecker('preference_edit')){ 			
			$preference->action = btn_edit('preference/edit/'.$preference->VX_aln_preferenceID, $this->lang->line('edit'));
		  }
		  if(permissionChecker('preference_delete')){
		   $preference->action .= btn_delete('preference/delete/'.$preference->VX_aln_preferenceID, $this->lang->line('delete'));			 
		  }
		  if(permissionChecker('preference_view')) {
		    $preference->action .= btn_view('preference/view/'.$preference->VX_aln_preferenceID, $this->lang->line('view'));
		  }
			$status = $preference->active;
			$preference->active = "<div class='onoffswitch-small' id='".$preference->VX_aln_preferenceID."'>";
            $preference->active .= "<input type='checkbox' id='myonoffswitch".$preference->VX_aln_preferenceID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $preference->active .= " checked >";
			} else {
			   $preference->active .= ">";
			}	
			
			$preference->active .= "<label for='myonoffswitch".$preference->VX_aln_preferenceID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";         
           
			$output['aaData'][] = $preference;				
		}
		echo json_encode( $output );
	}

	public function pref_get_value(){
		$type = $this->input->post('type');
		$get_value = $this->input->post('get_value');
		if($type){
		  if($type == 10){
			$list = $this->airports_m->getDefdataTypes(null,array('1','2','3','4','5'));		
		  } else {
			$list = $this->airports_m->getDefdataTypes(null,array($type));	
		  }
			echo '<option value="0">Select Value</option>';
			foreach ($list as $li) {
				 if($li->vx_aln_data_typeID == $get_value){
					echo '<option value="'.$li->vx_aln_data_typeID.'" selected>'.$li->name.'</option>';
				}else{ 
				    echo '<option value="'.$li->vx_aln_data_typeID.'">'.$li->name.'</option>';
				}
			}
		} else {
		   echo "Select Value Type";
		}
	}

}