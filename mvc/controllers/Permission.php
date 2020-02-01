<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends Admin_Controller {
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
		$this->load->model("permission_m");
		$this->load->model("role_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('permission', $language);	
	}

	public function index() {
 		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$usertype = $this->role_m->get_role($id);
				if(count($usertype)) {

				$this->data['set'] = $id;
				$this->data['roles'] = $this->role_m->get_role();
				$this->data['permissions'] = $this->permission_m->get_modules_with_permission($id);
				if(empty($this->data['permissions'])) {
					$this->data['permissions'] = NULL;
				}
				$this->data["subview"] = "permission/index";
				$this->load->view('_layout_main', $this->data);
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data['roles'] = $this->role_m->get_role();
			$this->data["subview"] = "permission/index";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function permission_list() {
		$roleID = $this->input->post('roleID');
		if((int)$roleID) {
			$string = base_url("permission/index/$roleID");
			echo $string;
		} else {
			redirect(base_url("permission/index"));
		}
	}

	public function save() {
		$this->session->userdata('usertype');
		$roleID = $this->uri->segment(3);
		if ((int)$roleID) {
			$usertype = $this->role_m->get_role($roleID);
			if(count($usertype)) {
				if ($this->permission_m->delete_all_permission($roleID)) {
					foreach ($_POST as $key => $value) {
						$array = array();
						$array['permission_id'] = $value;
						$array['roleID'] = $roleID;
						$this->permission_m->insert_relation($array);
					}
					redirect(base_url('permission/index/'.$roleID),'refresh');
				} else {
					redirect(base_url('permission/index/'.$roleID),'refresh');
				}
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			redirect(base_url('permission/index/'.$roleID),'refresh');
		}
	}
}
