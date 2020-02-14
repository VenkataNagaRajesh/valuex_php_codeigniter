<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resetpassword extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("resetpassword_m");
		$this->load->model('role_m');		
		$this->load->model("user_m");		
		$this->load->model("usertype_m");		
		$language = $this->session->userdata('lang');
		$this->lang->load('resetpassword', $language);	
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'usertype', 
				'label' => $this->lang->line("resetpassword_usertype"), 
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'users', 
				'label' => $this->lang->line("resetpassword_users"), 
				'rules' => 'trim|required|xss_clean|callback_unique_users'
			), 
			array(
				'field' => 'username', 
				'label' => $this->lang->line("resetpassword_username"),
				'rules' => 'trim|required|xss_clean|numeric|callback_unique_username'
			), 
			array(
				'field' => 'new_password', 
				'label' => $this->lang->line("resetpassword_new_password"),
				'rules' => 'trim|required|xss_clean|min_length[4]|max_length[40]'
			), 
			array(
				'field' => 're_password', 
				'label' => $this->lang->line("resetpassword_re_password"), 
				'rules' => 'trim|required|xss_clean|matches[new_password]|min_length[4]|max_length[40]'
			)
		);
		return $rules;
	}
	

	public function unique_users() {
		if($this->input->post('users') == 0) {
			$this->form_validation->set_message("unique_users", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function unique_username() {
		if($this->input->post('username') == 0) {
			$this->form_validation->set_message("unique_username", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function index() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/select2/select2.js'
			)
		);
		$this->data['roles'] = $this->role_m->get_role();
		$this->data['usertypes'] = $this->usertype_m->get_usertype();
		$userID = $this->input->post("users");
		$table = '';
		$tableID = '';
		if($userID != '0') {			
				$table = 'VX_user';
				$tableID = 'userID';
			$this->data['usernames'] = $this->resetpassword_m->get_username($table);
		} else {
			$this->data['usernames'] = "empty";
		}

		$this->data['username'] = 0;
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "resetpassword/index";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array = array(
					'password' => $this->resetpassword_m->hash($this->input->post("new_password"))
				);
				$userID = $this->input->post('username');
				$this->resetpassword_m->update_resetpassword($table, $array, $tableID, $userID);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("resetpassword/index"));
			}
		} else {
			$this->data["subview"] = "resetpassword/index";
			$this->load->view('_layout_main', $this->data);
		}
		
	}

	public function userscall() {
		$userID = $this->input->post('users');
		$usertypeID = $this->input->post('usertype');
		if($userID) {
			$table = 'VX_user';
			$tableID = 'userID';

			$get_users = $this->resetpassword_m->get_username($table, array('roleID' => $userID,"usertypeID" => $usertypeID));
			
			if(count($get_users)) {
				echo "<option value='0'>". $this->lang->line("resetpassword_select_username") ."</option>";
				foreach ($get_users as $key => $user) {
					if($table == 'systemadmin') {
						if($user->systemadminID != 1) {
							echo "<option value='".$user->$tableID."'>".$user->username ."</option>";
						}
					} else {
						echo "<option value='".$user->$tableID."'>".$user->username ."</option>";
					}
				}
			} else {
				echo "<option value='0'>".$this->lang->line("resetpassword_select_username")."</option>";
			}
		}
	}

}

