<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("user_m");
		$this->load->model('role_m');
		$this->load->model('airline_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('user', $language);
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'name',
				'label' => $this->lang->line("user_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'dob',
				'label' => $this->lang->line("user_dob"),
				'rules' => 'trim|required|max_length[10]|callback_date_valid|xss_clean'
			),
			array(
				'field' => 'sex',
				'label' => $this->lang->line("user_sex"),
				'rules' => 'trim|max_length[10]|xss_clean'
			),
			array(
				'field' => 'religion',
				'label' => $this->lang->line("user_religion"),
				'rules' => 'trim|max_length[25]|xss_clean'
			),
			array(
				'field' => 'email',
				'label' => $this->lang->line("user_email"),
				'rules' => 'trim|required|max_length[40]|valid_email|xss_clean|callback_unique_email'
			),
			array(
				'field' => 'phone',
				'label' => $this->lang->line("user_phone"),
				'rules' => 'trim|min_length[5]|max_length[25]|xss_clean'
			),
			array(
				'field' => 'address',
				'label' => $this->lang->line("user_address"),
				'rules' => 'trim|max_length[200]|xss_clean'
			),
			array(
				'field' => 'jod',
				'label' => $this->lang->line("user_jod"),
				'rules' => 'trim|required|max_length[10]|callback_date_valid|xss_clean'
			),			
			array(
				'field' => 'roleID',
				'label' => $this->lang->line("user_usertype"),
				'rules' => 'trim|required|max_length[11]|xss_clean|numeric|callback_unique_roleID'
			),		
			array(
				'field' => 'photo',
				'label' => $this->lang->line("user_photo"),
				'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
			),
			array(
				'field' => 'username',
				'label' => $this->lang->line("user_username"),
				'rules' => 'trim|required|min_length[4]|max_length[40]|xss_clean|callback_lol_username'
			),
			array(
				'field' => 'password',
				'label' => $this->lang->line("user_password"),
				'rules' => 'trim|required|min_length[4]|max_length[40]|xss_clean|callback_valid_password'
			),
			array(
				'field' => 'airlineID',
				'label' => $this->lang->line("user_airline"),
				'rules' => 'trim|max_length[10]|xss_clean|callback_valAirlines'
			)
		);
		return $rules;
	}

	public function valid_password($password = '')
    {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
        if (empty($password))
        {
            $this->form_validation->set_message('valid_password', 'The {field} field is required.');
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1 || preg_match_all($regex_uppercase, $password) < 1 ||  preg_match_all($regex_number, $password) < 1 ||preg_match_all($regex_special, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have  uppercase & lowercase letter & numeric & special character.');
            return FALSE;
        }        
        if (strlen($password) < 5)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least 5 characters in length.');
            return FALSE;
        }
        if (strlen($password) > 32)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');
            return FALSE;
        }
        return TRUE;
    }
	
	public function valAirlines(){
		if(count($this->input->post('airlineID')) > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message("valAirlines", "%s Required");
			return FALSE;
		}
	}

	public function photoupload() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$user = array();
		if((int)$id) {
			$user = $this->user_m->get_user($id);
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
			if(count($user)) {
				$this->upload_data['file'] = array('file_name' => $user->photo);
				return TRUE;
			} else {
				$this->upload_data['file'] = array('file_name' => $new_file);
			return TRUE;
			}
		}
	}

	public function index() {
		/* if($this->session->userdata('roleID') == 2){
		 $this->data['users'] = $this->user_m->get_user_by_usertype(null,array("u.roleID" => 5,"u.create_userID"=>$this->session->userdata('loginuserID')));
		} else {
		$this->data['users'] = $this->user_m->getUsers();	
		} */
		$this->data['users'] = array();
		if($this->session->userdata('roleID') == 1){
		 $this->data['users'] = $this->user_m->getUsers();	
		}
		foreach($this->data['users'] as $user){
			if($user->roleID == 1){
		       $user->airlinelist = Array();
			} else {
			    $airlinelist = $this->user_m->getUserAirlines($user->userID);	
			}
			foreach($airlinelist as $car){
				$user->airlinelist[] = $car->code;
			}
		}
		//print_r($this->data['users']); exit;
		$this->data["subview"] = "user/index";
		$this->load->view('_layout_main', $this->data);
	}

	public function add() {
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
		
		$usertype = 1;        
		$this->data['roles'] = $this->role_m->get_roleinfo($usertype);	
		if($this->session->userdata('usertypeID') == 1 && $this->session->userdata('roleID') == 1){
		   $this->data['airlinelist'] = $this->airline_m->getAirlinesData();
		} else {
		   $this->data['airlinelist'] = $this->user_m->getUserAirlines($userID);	
		}		
		
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "user/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				$array["name"] = $this->input->post("name");
				$array["dob"] = date("Y-m-d", strtotime($this->input->post("dob")));
				$array["sex"] = $this->input->post("sex");
				$array["religion"] = $this->input->post("religion");
				$array["email"] = $this->input->post("email");
				$array["phone"] = $this->input->post("phone");
				$array["address"] = $this->input->post("address");
				$array["jod"] = date("Y-m-d", strtotime($this->input->post("jod")));
				$array["username"] = $this->input->post("username");
				$array["password"] = $this->user_m->hash($this->input->post("password"));				
				$array["create_date"] = date("Y-m-d h:i:s");
				$array["modify_date"] = date("Y-m-d h:i:s");
				$array["create_userID"] = $this->session->userdata('loginuserID');
				$array["create_username"] = $this->session->userdata('username');
				$array["create_usertype"] = $this->session->userdata('usertype');
				$array["active"] = 1;
				$array['photo'] = $this->upload_data['file']['file_name'];
				$array["roleID"] = $this->input->post("roleID");
				$array["usertypeID"] = 1;
				// For Email
				$this->usercreatemail($this->input->post('email'), $this->input->post('username'), $this->input->post('password'));

				$this->user_m->insert_user($array);
				$userID = $this->db->insert_id();
				 $link['userID'] = $userID;
				 $link["create_date"] = time();
				 $link["modify_date"] = time();
				 $link["create_userID"] = $this->session->userdata('loginuserID');
				 $link["modify_userID"] = $this->session->userdata('loginuserID');
				 foreach($this->input->post('airlineID') as $airlineID){
				  $link['airlineID'] = $airlineID;
				  $this->user_m->insert_user_airline($link);
				 }
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("user/index"));
			}
		} else {
			$this->data["subview"] = "user/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	function unique_roleID() {
		if($this->input->post('roleID') == 0) {
			$this->form_validation->set_message("unique_roleID", "The %s field is required ");
			return FALSE;
		} else {
			/* $blockuser = array(1, 2, 3, 4);
			if(in_array($this->input->post('roleID'), $blockuser)) {
				$this->form_validation->set_message("unique_roleID", "The %s field is required.");
				return FALSE;
			} */
			return TRUE;
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
		$usertype = 1;        
		$this->data['roles'] = $this->role_m->get_roleinfo($usertype);
		$userID = $this->session->userdata('loginuserID');
		if($this->session->userdata('usertypeID') == 1 && $this->session->userdata('roleID') == 1){
		   $this->data['airlinelist'] = $this->airline_m->getAirlinesData();
		} else {
		   $this->data['airlinelist'] = $this->user_m->getUserAirlines($userID);	
		}
		if((int)$id) {
			$this->data['user'] = $this->user_m->get_user($id);
			//print_r($this->data['user']); exit;
			if($this->data['user']) {
				$rules = $this->rules();				
				unset($rules[11]);								
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data["subview"] = "user/edit";
					$this->load->view('_layout_main', $this->data);
				} else {
					$array["name"] = $this->input->post("name");
					$array["dob"] = date("Y-m-d", strtotime($this->input->post("dob")));
					$array["sex"] = $this->input->post("sex");
					$array["religion"] = $this->input->post("religion");
					$array["email"] = $this->input->post("email");
					$array["phone"] = $this->input->post("phone");
					$array["address"] = $this->input->post("address");
					$array["jod"] = date("Y-m-d", strtotime($this->input->post("jod")));					
					$array["modify_date"] = date("Y-m-d h:i:s");
					$array["username"] = $this->input->post('username');
					$array['photo'] = $this->upload_data['file']['file_name'];					
					$array["roleID"] = $this->input->post("roleID");
					$this->user_m->update_user($array, $id);
					
					 $airlines = array();
					 if(!empty($this->data['user']->airlineIDs)){
					 $airlines = explode(',',$this->data['user']->airlineIDs);
					 }
					 $delete_list = array_diff($airlines,$this->input->post('airlineID'));
					 if(!empty($delete_list)){
					 $this->user_m->delete_user_airline($id,$delete_list);
					 }
					 $insert_list = array_diff($this->input->post('airlineID'),$airlines);
					// print_r( $insert_list); exit;
					  if(!empty($insert_list)){
					  $link['userID'] = $id;					
					  $link["modify_date"] = time();
                      $link["create_date"] = time();
                      $link["create_userID"] = $this->session->userdata('loginuserID');					  
					  $link["modify_userID"] = $this->session->userdata('loginuserID');
					  foreach($insert_list as $airlineID){
					   $link['airlineID'] = $airlineID;
					   $this->user_m->insert_user_airline($link);
					  }
					 }

					
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("user/index"));
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
			$this->data['user'] = $this->user_m->get_user($id);
			if($this->data['user']) {
				if(config_item('demo') == FALSE) {
					if($this->data['user']->photo != 'defualt.png') {
						if(file_exists(FCPATH.'uploads/images/'.$this->data['user']->photo)) {
							unlink(FCPATH.'uploads/images/'.$this->data['user']->photo);
						}
					}
				}
				$this->user_m->delete_user($id);
				$this->user_m->delete_user_airline($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("user/index"));
			} else {
				redirect(base_url("user/index"));
			}
		} else {
			redirect(base_url("user/index"));
		}
	}

	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
			$this->data["user"] = $this->user_m->get_user($id);
			if($this->data["user"]) {
				$this->data["subview"] = "user/view";
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

	public function print_preview() {
		if(permissionChecker('user_view')) {
			$id = htmlentities(escapeString($this->uri->segment(3)));
			if((int)$id) {
				$this->data['user'] = $this->user_m->get_user_by_usertype($id);
				if($this->data['user']) {
					$this->data['panel_title'] = $this->lang->line('panel_title');
					$this->printview($this->data, 'user/print_preview');
				} else {
					$this->data["subview"] = "error";
					$this->load->view('_layout_main', $this->data);
				}
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "errorpermission";
			$this->load->view('_layout_main', $this->data);
		}
	}
	
	public function send_mail() {
		$id = $this->input->post('id');
		if ((int)$id) {
			$this->data['user'] = $this->user_m->get_user_by_usertype($id);
			if($this->data["user"]) {

				$email = $this->input->post('to');
				$subject = $this->input->post('subject');
				$message = $this->input->post('message');

				$this->viewsendtomail($this->data, 'user/print_preview', $email, $subject, $message);

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
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$user_info = $this->user_m->get_single_user(array('userID' => $id));
			$tables = array('VX_user');
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
			$tables = array('VX_user');
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

	public function date_valid($date) {
		if(strlen($date) <10) {
			$this->form_validation->set_message("date_valid", "%s is not valid dd-mm-yyyy");
	     	return FALSE;
		} else {
	   		$arr = explode("-", $date);
	        $dd = $arr[0];
	        $mm = $arr[1];
	        $yyyy = $arr[2];
	      	if(checkdate($mm, $dd, $yyyy)) {
	      		return TRUE;
	      	} else {
	      		$this->form_validation->set_message("date_valid", "%s is not valid dd-mm-yyyy");
	     		return FALSE;
	      	}
	    }
	}

	public function unique_email() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$user_info = $this->user_m->get_single_user(array('userID' => $id));
			$tables = array('VX_user');
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
			$tables = array('VX_user');
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
		if(permissionChecker('user_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				if((int)$id) {
					if($status == 'chacked') {
						$this->user_m->update_user(array('active' => 1), $id);
						echo 'Success';
					} elseif($status == 'unchacked') {
						$this->user_m->update_user(array('active' => 0), $id);
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
}


