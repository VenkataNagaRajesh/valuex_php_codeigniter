<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends Admin_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/
	function __construct() {
		parent::__construct();
		$this->load->model("role_m");
		$this->load->model("usertype_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('role', $language);	
	}

	public function index() {
		$usertype = $this->session->userdata("usertype");
		$this->data['usertypes'] = $this->usertype_m->get_usertype();
		$usertypeID = null;
		if($this->session->userdata('usertypeID') != 1){
			$usertypeID = $this->session->userdata('usertypeID');
		}
		$this->data['roles'] = $this->role_m->get_roleinfo($usertypeID);		
		$this->data["subview"] = "role/index";
		$this->load->view('_layout_main', $this->data);		
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'usertypeID', 
				'label' => $this->lang->line("role_usertype"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_usertype'
			),
			array(
				'field' => 'role', 
				'label' => $this->lang->line("role_role"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_role'
			)
		);
		return $rules;
	}

	function unique_usertype(){
		if(empty($this->input->post('usertypeID'))){
			$this->form_validation->set_message("unique_usertype", "%s id required");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function add() {
		$usertype = $this->session->userdata("usertype");
		$this->data['usertypes'] = $this->usertype_m->get_usertype();
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "role/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array = array(
					"role" => $this->input->post("role"),
					"usertypeID" => $this->input->post("usertypeID"),
					"create_date" => date("Y-m-d h:i:s"),
					"modify_date" => date("Y-m-d h:i:s"),
					"create_userID" => $this->session->userdata('loginuserID'),
					//"create_username" => $this->session->userdata('username'),
					//"create_usertype" => $this->session->userdata('usertype')
				);
				$this->role_m->insert_role($array);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("role/index"));
			}
		} else {
			$this->data["subview"] = "role/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit() {
		$this->data['usertypes'] = $this->usertype_m->get_usertype();
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['role'] = $this->role_m->get_role($id);
			if($this->data['role']) {
				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) {
						$this->data["subview"] = "role/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {
						$array = array(
							"role" => $this->input->post("role"),
							"usertypeID" => $this->input->post("usertypeID"),
							"modify_date" => date("Y-m-d h:i:s")
						);
						$this->role_m->update_role($array, $id);
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("role/index"));
					}
				} else {
					$this->data["subview"] = "role/edit";
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
		$usertype = $this->session->userdata("usertype");
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['role'] = $this->role_m->get_role($id);
			if($this->data['role']) {
				$reletionarray = array(1,2,3,4,5,6,7);
				if(!in_array($this->data['role']->roleID, $reletionarray)) {
					$this->role_m->delete_role($id);
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("role/index"));
				} else {
					redirect(base_url("role/index"));
				}
			} else {
				redirect(base_url("role/index"));
			}
		} else {
			redirect(base_url("role/index"));
		}	

	}

	public function unique_role() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$role = $this->role_m->get_order_by_role(array("role" => $this->input->post("role"), "roleID !=" => $id,"usertypeID ="=>$this->input->post('usertypeID')));
			if(count($role)) {
				$this->form_validation->set_message("unique_role", "%s already exists");
				return FALSE;
			}
			return TRUE;
		} else {
			$role = $this->role_m->get_order_by_role(array("role" => $this->input->post("role"),"usertypeID ="=>$this->input->post('usertypeID')));
			if(count($role)) {
				$this->form_validation->set_message("unique_role", "%s already exists");
				return FALSE;
			}
			return TRUE;
		}	
	}


}

