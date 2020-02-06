<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("permission_m");
		$this->load->model("role_m");
		$this->load->model("usertype_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('permission', $language);	
	}

	public function index() {
		 $uid = htmlentities(escapeString($this->uri->segment(3)));
		 $rid = htmlentities(escapeString($this->uri->segment(4)));
		if((int)$uid && (int)$rid) {
			$role = $this->role_m->get_role($rid);
			$usertype = $this->usertype_m->get_usertype($uid);
				if(count($role) && count($usertype)) {
				$this->data['uset'] = $uid;
				$this->data['rset'] = $rid;
				$this->data['roles'] = $this->role_m->get_role();
				$this->data['usertypes'] = $this->usertype_m->get_usertype();
				$this->data['permissions'] = $this->permission_m->get_modules_with_permission($rid);
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
			$this->data['usertypes'] = $this->usertype_m->get_usertype();
			$this->data["subview"] = "permission/index";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function permission_list() {
		$roleID = $this->input->post('roleID');
		$usertypeID = $this->input->post('usertypeID');
		if((int)$roleID && (int)$usertypeID) {
			$string = base_url("permission/index/$usertypeID/$roleID");
			echo $string;
		} else {
			redirect(base_url("permission/index"));
		}
	}

	public function save() {
		$this->session->userdata('usertype');
		$roleID = $this->uri->segment(4);
		$usertypeID = $this->uri->segment(3);
		if ((int)$roleID && (int)$usertypeID) {
			$usertype = $this->usertype_m->get_usertype($usertypeID);
			$role = $this->role_m->get_role($roleID);
			if(count($usertype) && count($role)) {
				if ($this->permission_m->delete_all_permission($usertypeID,$roleID)) {
					$array = array();
					$array['roleID'] = $roleID;
					$array['usertypeID'] = $usertypeID;
					foreach ($_POST as $key => $value) {						
						$array['permission_id'] = $value;						
						$this->permission_m->insert_relation($array);
					}
					redirect(base_url('permission/index/'.$usertypeID.'/'.$roleID),'refresh');
				} else {
					redirect(base_url('permission/index/'.$usertypeID.'/'.$roleID),'refresh');
				}
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			redirect(base_url('permission/index/'.$usertypeID.'/'.$roleID),'refresh');
		}
	}
}
