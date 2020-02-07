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
		$language = $this->session->userdata('lang');
		$this->lang->load('role', $language);	
	}

	public function index() {
		$usertype = $this->session->userdata("usertype");
		$this->data['roles'] = $this->role_m->get_role();
		$this->data["subview"] = "role/index";
		$this->load->view('_layout_main', $this->data);		
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'role', 
				'label' => $this->lang->line("role_role"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_role'
			)
		);
		return $rules;
	}

	public function add() {
		$usertype = $this->session->userdata("usertype");
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "role/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array = array(
					"usertype" => $this->input->post("role"),
					"create_date" => date("Y-m-d h:i:s"),
					"modify_date" => date("Y-m-d h:i:s"),
					"create_userID" => $this->session->userdata('loginuserID'),
					"create_username" => $this->session->userdata('username'),
					"create_usertype" => $this->session->userdata('usertype')
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
			$role = $this->role_m->get_order_by_role(array("role" => $this->input->post("role"), "roleID !=" => $id));
			if(count($role)) {
				$this->form_validation->set_message("unique_role", "%s already exists");
				return FALSE;
			}
			return TRUE;
		} else {
			$role = $this->role_m->get_order_by_role(array("role" => $this->input->post("role")));
			if(count($role)) {
				$this->form_validation->set_message("unique_role", "%s already exists");
				return FALSE;
			}
			return TRUE;
		}	
	}


}

