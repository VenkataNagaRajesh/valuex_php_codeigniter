<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("client_m");
		$this->load->model("user_m");
		$this->load->model('usertype_m');
		$this->load->model('airline_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('client', $language);
		$usertype = 2; 
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'name',
				'label' => $this->lang->line("client_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),			
			array(
				'field' => 'email',
				'label' => $this->lang->line("client_email"),
				'rules' => 'trim|required|max_length[40]|valid_email|xss_clean|callback_unique_email'
			),
			array(
				'field' => 'phone',
				'label' => $this->lang->line("client_phone"),
				'rules' => 'trim|required|min_length[5]|max_length[25]|xss_clean'
			),
			array(
				'field' => 'address',
				'label' => $this->lang->line("client_address"),
				'rules' => 'trim|max_length[200]|xss_clean'
			),
			array(
				'field' => 'airlineID',
				'label' => $this->lang->line("client_airline"),
				'rules' => 'trim|max_length[10]|xss_clean|callback_valAirlines'
			),			
			array(
				'field' => 'photo',
				'label' => $this->lang->line("client_photo"),
				'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
			),
			array(
				'field' => 'mail_logo',
				'label' => $this->lang->line("client_mail_logo"),
				'rules' => 'trim|max_length[200]|xss_clean|callback_maillogoupload'
			),
			array(
				'field' => 'username',
				'label' => $this->lang->line("client_username"),
				'rules' => 'trim|required|min_length[4]|max_length[40]|xss_clean|callback_lol_username'
			),
			array(
				'field' => 'password',
				'label' => $this->lang->line("client_password"),
				'rules' => 'trim|required|min_length[4]|max_length[40]|xss_clean'
			),
		);
		return $rules;
	}
	
	public function valAirlines(){
		if(count($this->input->post('airlineID')) > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message("valAirlines", "%s Required");
			return FALSE;
		}
	}
	
	public function validate_airline() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		 if((int)$id) {
		    $client = $this->client_m->get_single_client(array('VX_aln_clientID !=' => $id,'airlineID' => $this->input->post('airlineID')));	
			if(count($client)) {
				$this->form_validation->set_message("validate_airline", "%s already exists");
				return FALSE;
			}
			return TRUE;
		} else {
			$client = $this->client_m->get_single_client(array('airlineID' => $this->input->post('airlineID')));	
			if(count($client)) {
				$this->form_validation->set_message("validate_airline", "%s already exists");
				return FALSE;
			}
			return TRUE;
		}
	} 
	
	public function photoupload() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$client = array();
		if((int)$id) {
			$client = $this->client_m->get_client($id);
		}
		$new_file = "defualt.png";
		if($_FILES["photo"]['name'] !="") {
			$file_name = $_FILES["photo"]['name'];
			$random = rand(1, 10000000000000000);
	    	$makeRandom = hash('sha512', $random.$this->input->post('username') . config_item("encryption_key"));
			$file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
	            $new_file = $file_name_rename.'.'.end($explode);
				$config['upload_path'] = "./uploads/images";
				$config['allowed_types'] = "gif|jpg|png";
				$config['file_name'] = $new_file;
				$config['max_size'] = '1024';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload("photo")) {
					$this->form_validation->set_message("photoupload", $this->upload->display_errors());
	     			return FALSE;
				} else {
					$this->upload_data['file'] =  $this->upload->data();
					return TRUE;
				}
			} else {
				$this->form_validation->set_message("photoupload", "Invalid file");
	     		return FALSE;
			}
		} else {
			if(count($client)) {
				$this->upload_data['file'] = array('file_name' => $client->photo);
				return TRUE;
			} else {
				$this->upload_data['file'] = array('file_name' => $new_file);
			return TRUE;
			}
		}
	}
	
	public function maillogoupload() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$client = array();
		if((int)$id) {
			$client = $this->client_m->get_client($id);
		}
		$new_file = "defualt.png";
		if($_FILES["mail_logo"]['name'] !="") {
			$file_name = $_FILES["mail_logo"]['name'];
			$random = rand(1, 10000000000000000);
	    	$makeRandom = hash('sha512', $random.$this->input->post('username') . config_item("encryption_key"));
			$file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
	            $new_file = $file_name_rename.'.'.end($explode);
				$config['upload_path'] = "./uploads/images";
				$config['allowed_types'] = "gif|jpg|png";
				$config['file_name'] = $new_file;
				$config['max_size'] = '1024';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload("mail_logo")) {
					$this->form_validation->set_message("maillogoupload", $this->upload->display_errors());
	     			return FALSE;
				} else {
					$this->upload_data['mail_logo'] =  $this->upload->data();
					return TRUE;
				}
			} else {
				$this->form_validation->set_message("maillogoupload", "Invalid file");
	     		return FALSE;
			}
		} else {
			if(count($client)) {
				$this->upload_data['mail_logo'] = array('file_name' => $client->mail_logo);
				return TRUE;
			} else {
				$this->upload_data['mail_logo'] = array('file_name' => $new_file);
			return TRUE;
			}
		}
	}

	public function index() {
		$userTypeID = $this->session->userdata('usertypeID');
		$userID = $this->session->userdata('loginuserID');
		if($userTypeID == 2){
			  $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
		   } else {
			   $this->data['airlines'] = $this->airline_m->getAirlinesData();
		   }
		
		if(!empty($this->input->post('airlineID'))){	
		   $this->data['airlineID'] = $this->input->post('airlineID');
		} else {
			if($userTypeID == 2){
		      $this->data['airlineID'] = $this->session->userdata('default_airline');
			} else {
			  $this->data['airlineID'] = 0;	
			}
		}
		
		if(!empty($this->input->post('active'))){	
		   $this->data['active'] = $this->input->post('active');
		} else {
		  $this->data['active'] = 2;
		}
		$this->data["subview"] = "client/index";
		$this->load->view('_layout_main', $this->data);
	}

	public function add() {
		 $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css', 				
                ),
                'js' => array(
                        'assets/select2/select2.js',  					
                )
        );
        $usertype = 2;
        $this->data['airlinelist'] = $this->airline_m->getAirlinesData();		
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "client/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				$array["name"] = $this->input->post("name");				
				$array["email"] = $this->input->post("email");
				$array["phone"] = $this->input->post("phone");
				$array["address"] = $this->input->post("address");				
				$array["username"] = $this->input->post("username");
				$array["password"] = $this->user_m->hash($this->input->post("password"));
				$array["usertypeID"] = $usertype;
				$array["create_date"] = date("Y-m-d h:i:s");
				$array["modify_date"] = date("Y-m-d h:i:s");
				$array["create_userID"] = $this->session->userdata('loginuserID');
				$array["create_username"] = $this->session->userdata('username');
				$array["create_usertype"] = $this->session->userdata('usertype');
				$array["active"] = $this->input->post("active");	
				$array['photo'] = $this->upload_data['file']['file_name'];
				// For Email
				$this->user_m->insert_user($array);
				$userID = $this->db->insert_id();
			 if($userID){
				$client['userID'] = $userID;
				$client["name"] = $this->input->post("name");				
				$client["email"] = $this->input->post("email");
				$client["phone"] = $this->input->post("phone");
				$client["address"] = $this->input->post("address");				
				$client["username"] = $this->input->post("username");
				$client["password"] = $this->user_m->hash($this->input->post("password"));
               // $client["airlineID"] = $this->input->post("airlineID");				
				$client["create_date"] = time();
				$client["modify_date"] = time();
				$client["create_userID"] = $this->session->userdata('loginuserID');
				$client["modify_userID"] = $this->session->userdata('loginuserID');
				$client["active"] = $this->input->post("active");	
				$client['photo'] = $this->upload_data['file']['file_name'];
				$client['mail_logo'] = $this->upload_data['mail_logo']['file_name'];				
				$this->client_m->insert_client($client);				 
				 $clientID = $this->db->insert_id();
				 $link['clientID'] = $clientID;
				 $link["create_date"] = time();
				 $link["modify_date"] = time();
				 $link["create_userID"] = $this->session->userdata('loginuserID');
				 $link["modify_userID"] = $this->session->userdata('loginuserID');
				 foreach($this->input->post('airlineID') as $airlineID){
				  $link['airlineID'] = $airlineID;
				  $this->client_m->insert_client_airline($link);
				 }
			 }
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("client/index"));
			}
		} else {
			$this->data["subview"] = "client/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/datepicker/datepicker.css',
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/datepicker/datepicker.js',
				'assets/select2/select2.js'
			)
		);

		$id = htmlentities(escapeString($this->uri->segment(3))); 
		if((int)$id) {
			$this->data['client'] = $this->client_m->getClientData($id); //print_r($this->data['client'] ); exit;	
			if($this->data['client']) {
				$this->data['airlinelist'] = $this->airline_m->getAirlinesData();	
				$rules = $this->rules();
				unset($rules[8]);
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data["subview"] = "client/edit";
					$this->load->view('_layout_main', $this->data);
				} else {
					$array["name"] = $this->input->post("name");					
					$array["email"] = $this->input->post("email");
					$array["phone"] = $this->input->post("phone");
					$array["address"] = $this->input->post("address");
					$array["modify_date"] = date("Y-m-d h:i:s");
					$array["username"] = $this->input->post('username');
					$array['photo'] = $this->upload_data['file']['file_name'];
					$this->user_m->update_user($array,$this->data['client']->userID);
					
					$client["name"] = $this->input->post("name");				
					$client["email"] = $this->input->post("email");
					$client["phone"] = $this->input->post("phone");
					$client["address"] = $this->input->post("address");				
					$client["username"] = $this->input->post("username");					
					//$client["airlineID"] = $this->input->post("airlineID");					
					$client["modify_date"] = time();
					$client["create_userID"] = $this->session->userdata('loginuserID');					
					$client["active"] = $this->input->post("active");	
					$client['photo'] = $this->upload_data['file']['file_name'];
					$client['mail_logo'] = $this->upload_data['mail_logo']['file_name'];
					 $this->client_m->update_client($client,$id);
					 $airlines = array();
					 if(!empty($this->data['client']->airlineIDs)){
					 $airlines = explode(',',$this->data['client']->airlineIDs);
					 }
					 $delete_list = array_diff($airlines,$this->input->post('airlineID'));
					 if(!empty($delete_list)){
					 $this->client_m->delete_client_airline($id,$delete_list);
					 }
					 $insert_list = array_diff($this->input->post('airlineID'),$airlines);
					// print_r( $insert_list); exit;
					  if(!empty($insert_list)){
					  $link['clientID'] = $id;					
					  $link["modify_date"] = time();
                      $link["create_date"] = time();
                      $link["create_userID"] = $this->session->userdata('loginuserID');					  
					  $link["modify_userID"] = $this->session->userdata('loginuserID');
					  foreach($insert_list as $airlineID){
					   $link['airlineID'] = $airlineID;
					   $this->client_m->insert_client_airline($link);
					  }
					 }
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("client/index"));
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
		$clientid =  htmlentities(escapeString($this->uri->segment(3)));			
		$client = $this->client_m->get_single_client(array('VX_aln_clientID' => $clientid));
		$id = $client->userID;
		if((int)$clientid) {
			$this->data['user'] = $this->user_m->get_user($id);
			if($this->data['user']) {
				if(config_item('demo') == FALSE) {
					if($this->data['user']->photo != 'defualt.png') {
						if(file_exists(FCPATH.'uploads/images/'.$client->photo)) {
							unlink(FCPATH.'uploads/images/'.$client->photo);
						}
					}
				}
				$this->user_m->delete_user($id);
				$this->client_m->delete_client($id);
				$this->client_m->delete_client_airline($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("client/index"));
			} else {
				redirect(base_url("client/index"));
			}
		} else {
			redirect(base_url("client/index"));
		}
	}

	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
			$this->data["client"] = $this->client_m->getClientData($id); 
			if($this->data["client"]) {
				$this->data["subview"] = "client/view";
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

	public function lol_username() {
		$clientid = htmlentities(escapeString($this->uri->segment(3)));
		$client = $this->client_m->get_single_client(array('VX_aln_clientID' => $clientid));
		$id = $client->userID;
		if((int)$id) {
			$user_info = $this->user_m->get_single_user(array('userID' => $id));
			$tables = array('user' => 'user');
			$array = array();
			$i = 0;
			foreach ($tables as $tablekey => $table) {
				$user = $this->user_m->get_username($table, array("username" => $this->input->post('username'), "username !=" => $user_info->username));
				if(count($user)) {
					$this->form_validation->set_message("lol_username", "%s already exists");
					$array['permition'][$i] = 'no';
				} else {
					$array['permition'][$i] = 'yes';
				}
				$i++;
			}
			if(in_array('no', $array['permition'])) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			$tables = array('user' => 'user');
			$array = array();
			$i = 0;
			foreach ($tables as $table) {
				$user = $this->user_m->get_username($table, array("username" => $this->input->post('username')));
				if(count($user)) {
					$this->form_validation->set_message("lol_username", "%s already exists");
					$array['permition'][$i] = 'no';
				} else {
					$array['permition'][$i] = 'yes';
				}
				$i++;
			}

			if(in_array('no', $array['permition'])) {
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	public function unique_email() {
		$clientid = htmlentities(escapeString($this->uri->segment(3)));
		$client = $this->client_m->get_single_client(array('VX_aln_clientID' => $clientid));
		$id = $client->userID;
		if((int)$id) {
			$user_info = $this->user_m->get_single_user(array('userID' => $id));
			$tables = array('user' => 'user');
			$array = array();
			$i = 0;
			foreach ($tables as $table) {
				$user = $this->user_m->get_username($table, array("email" => $this->input->post('email'), 'username !=' => $user_info->username ));
				if(count($user)) {
					$this->form_validation->set_message("unique_email", "%s already exists");
					$array['permition'][$i] = 'no';
				} else {
					$array['permition'][$i] = 'yes';
				}
				$i++;
			}
			if(in_array('no', $array['permition'])) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			$tables = array('user' => 'user');
			$array = array();
			$i = 0;
			foreach ($tables as $table) {
				$user = $this->user_m->get_username($table, array("email" => $this->input->post('email')));
				if(count($user)) {
					$this->form_validation->set_message("unique_email", "%s already exists");
					$array['permition'][$i] = 'no';
				} else {
					$array['permition'][$i] = 'yes';
				}
				$i++;
			}

			if(in_array('no', $array['permition'])) {
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function active() {
		if(permissionChecker('client_edit')) {
			$clientid = $this->input->post('id');			
		    $client = $this->client_m->get_single_client(array('VX_aln_clientID' => $clientid));
		    $id = $client->userID;
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				if((int)$id) {
					if($status == 'chacked') {
						$this->user_m->update_user(array('active' => 1), $id);
						$this->client_m->update_client(array('active' => 1), $clientid);
						echo 'Success';
					} elseif($status == 'unchacked') {
						$this->user_m->update_user(array('active' => 0), $id);
						$this->client_m->update_client(array('active' => 0), $clientid);
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
				
	    $aColumns = array('c.VX_aln_clientID','c.photo','c.name','c.email','c.photo','c.phone','dd.code','c.active');
	
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
			$sHaving = "";
			if ( $_GET['sSearch'] != "" )
			{
				$sWhere = "WHERE (";
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
				$sHaving = " HAVING airline_name LIKE '%".$_GET['sSearch']."%'";
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
			
			if($usertypeID == 2){
				$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                $sWhere .= 'c.userID = '.$this->session->userdata('loginuserID');	
			}
			
			if($this->input->get('airlineID') > 0 ){
		      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'ca.airlineID = '.$this->input->get('airlineID');		 
	        }
			
			if($this->input->get('active') < 2 ){
		      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'c.active = '.$this->input->get('active');		 
	        }
			
		    $sGroupby = " GROUP BY c.VX_aln_clientID";
		   $sQuery = "SELECT SQL_CALC_FOUND_ROWS c.*,group_concat(dd.code) airline_code,group_concat(dd.aln_data_value) airline_name FROM VX_aln_client c LEFT JOIN VX_client_airline ca ON ca.clientID = VX_aln_clientID LEFT JOIN vx_aln_data_defns dd ON dd.vx_aln_data_defnsID = ca.airlineID
			$sWhere	
            $sGroupby
            $sHaving			
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
	  foreach($rResult as $client){	
          if(permissionChecker('client_edit')){ 			
			$client->action = btn_edit('client/edit/'.$client->VX_aln_clientID, $this->lang->line('edit'));
		  }
		  if(permissionChecker('client_delete')){
		   $client->action .= btn_delete('client/delete/'.$client->VX_aln_clientID, $this->lang->line('delete'));			 
		  }
		  if(permissionChecker('client_view') ) {
		   $client->action .= btn_view('client/view/'.$client->VX_aln_clientID, $this->lang->line('view'));
		  }
		  
		 	$status = $client->active;
			$client->active = "<div class='onoffswitch-small' id='".$client->VX_aln_clientID."'>";
            $client->active .= "<input type='checkbox' id='myonoffswitch".$client->VX_aln_clientID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $client->active .= " checked >";
			} else {
			   $client->active .= ">";
			}	
			
			$client->active .= "<label for='myonoffswitch".$client->VX_aln_clientID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
						
			 $array = array(
               "src" => base_url('uploads/images/'.$client->image),
               'width' => '35px',
               'height' => '35px',
               'class' => 'img-rounded'
              );
			 $client->image = img($array);
           	$output['aaData'][] = $client;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array('#','Name','Email','Phone','Carrier Name',"Carrier Code");
		  $rows = array("VX_aln_clientID","name","email","phone","airline_name","airline_code");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
}


