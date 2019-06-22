<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailandsmstemplate extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('usertype_m');
		$this->load->model("mailandsmstemplate_m");
		$this->load->model("mailandsmstemplatetag_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('mailandsmstemplate', $language);
	}

	public function index() {
		$this->data['mailandsmstemplates'] = $this->mailandsmstemplate_m->get_order_by_mailandsmstemplate_with_usertypeID();
		$this->data["subview"] = "mailandsmstemplate/index";
		$this->load->view('_layout_main', $this->data);
	}

	protected function rules_email() {
		$rules = array(
				array(
					'field' => 'type',
					'label' => '',
					'rules' => 'trim|required|xss_clean|max_length[10]'
				),
				array(
					'field' => 'email_name',
					'label' => $this->lang->line("mailandsmstemplate_name"),
					'rules' => 'trim|required|xss_clean|max_length[128]'
				),
				array(
					'field' => 'email_user',
					'label' => $this->lang->line("mailandsmstemplate_user"),
					'rules' => 'trim|required|xss_clean|max_length[15]|callback_email_user_check'
				),
				array(
					'field' => 'email_template',
					'label' => $this->lang->line("mailandsmstemplate_template"),
					'rules' => 'trim|required|xss_clean|max_length[20000]'
				)
			);
		return $rules;
	}

	protected function rules_sms() {
		$rules = array(
				array(
					'field' => 'type',
					'label' => '',
					'rules' => 'trim|required|xss_clean|max_length[10]'
				),
				array(
					'field' => 'sms_name',
					'label' => $this->lang->line("mailandsmstemplate_name"),
					'rules' => 'trim|required|xss_clean|max_length[128]'
				),
				array(
					'field' => 'sms_user',
					'label' => $this->lang->line("mailandsmstemplate_user"),
					'rules' => 'trim|required|xss_clean|max_length[15]|callback_sms_user_check'
				),
				array(
					'field' => 'sms_template',
					'label' => $this->lang->line("mailandsmstemplate_template"),
					'rules' => 'trim|required|xss_clean|max_length[1500]'
				)
			);
		return $rules;
	}

	public function add() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/editor/jquery-te-1.4.0.css'
			),
			'js' => array(
				'assets/editor/jquery-te-1.4.0.min.js'
			)
		);
		$usertypes = $this->usertype_m->get_usertype();
		$this->data['categories'] = $this->mailandsmstemplate_m->get_categories();
		$this->data['usertypes'] = $usertypes;
		if($_POST) { 
			$type = $this->input->post('type');
			if($type == 'email') {
				$this->data["email"] = 1;
				$this->data["sms"] = 0;
				$this->data["email_user"] = $this->input->post('email_user');
				$this->data["sms_user"] = 'select';
				$rules = $this->rules_email();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data['form_validation'] = validation_errors();
					$this->data["subview"] = "mailandsmstemplate/add";
					$this->load->view('_layout_main', $this->data);
				} else {
					$array = array(
						'name' => $this->input->post('email_name'),
						'usertypeID' => $this->input->post('email_user'),
						'type' => $this->input->post('type'),
						'catID' => $this->input->post('category'),
						'template' => $this->input->post('email_template'),
					);
					$id = $this->mailandsmstemplate_m->insert_mailandsmstemplate($array);
					if($id && $this->input->post('default')){
						$this->mailandsmstemplate_m->setDefault($this->input->post('category'),$id);
					}
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url('mailandsmstemplate/index'));
				}
			} elseif($type == "sms") {
				$this->data["email"] = 0;
				$this->data["sms"] = 1;
				$this->data["email_user"] = 'select';
				$this->data["sms_user"] = $this->input->post('sms_user');
				$rules = $this->rules_sms();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data['form_validation'] = validation_errors();
					$this->data["subview"] = "mailandsmstemplate/add";
					$this->load->view('_layout_main', $this->data);
				} else {
					$array = array(
						'name' => $this->input->post('sms_name'),
						'usertypeID' => $this->input->post('sms_user'),
						'type' => $this->input->post('type'),
						'template' => $this->input->post('sms_template'),
					);

					$this->mailandsmstemplate_m->insert_mailandsmstemplate($array);
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url('mailandsmstemplate/index'));
				}
			}
		} else {
			$this->data["email"] = 1;
			$this->data["sms"] = 0;
			$this->data["email_user"] = 'select';
			$this->data["sms_user"] = 'select';
				$this->data["subview"] = "mailandsmstemplate/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	function email_user_check() {
		if($this->input->post('email_user') == 'select') {
			$this->form_validation->set_message("email_user_check", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	function sms_user_check() {
		if($this->input->post('sms_user') == 'select') {
			$this->form_validation->set_message("sms_user_check", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function edit() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/editor/jquery-te-1.4.0.css'
			),
			'js' => array(
				'assets/editor/jquery-te-1.4.0.min.js'
			)
		);

		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['mailandsmstemplate'] = $this->mailandsmstemplate_m->get_mailandsmstemplate($id);
			if($this->data['mailandsmstemplate']) {
				$usertypes = $this->usertype_m->get_usertype();
				$this->data['usertypes'] = $usertypes;
				$this->data['categories'] = $this->mailandsmstemplate_m->get_categories();
				if($_POST) {
					if($this->data['mailandsmstemplate']->type == 'email') {
						/* For Email */
						$this->data['email'] = 1;
						$this->data['sms'] = 0;
						$this->data["email_user"] = $this->data['mailandsmstemplate']->usertypeID;
						$this->data["sms_user"] = $this->data['mailandsmstemplate']->usertypeID;
						$rules = $this->rules_email();
						unset($rules[0]);
						$this->form_validation->set_rules($rules);
						if ($this->form_validation->run() == FALSE) {
							$this->data["subview"] = "mailandsmstemplate/edit";
							$this->load->view('_layout_main', $this->data);
						} else {
							$array = array(
								'name' => $this->input->post('email_name'),
								'usertypeID' => $this->input->post('email_user'),
								'template' => $this->input->post('email_template'),
								'catID' => $this->input->post('category')
							);
                            if($this->input->post('default')){
						     $this->mailandsmstemplate_m->setDefault($this->input->post('category'),$id);
					        }
							$this->mailandsmstemplate_m->update_mailandsmstemplate($array, $id);
							$this->session->set_flashdata('success', $this->lang->line('menu_success'));
							redirect(base_url('mailandsmstemplate/index'));
						}
					} elseif($this->data['mailandsmstemplate']->type == 'sms') {
						/* For SMS */
						$this->data['email'] = 0;
						$this->data['sms'] = 1;
						$this->data["email_user"] = $this->data['mailandsmstemplate']->usertypeID;
						$this->data["sms_user"] = $this->data['mailandsmstemplate']->usertypeID;
						$rules = $this->rules_sms();
						unset($rules[0]);
						$this->form_validation->set_rules($rules);
						if ($this->form_validation->run() == FALSE) {
							$this->data["subview"] = "mailandsmstemplate/edit";
							$this->load->view('_layout_main', $this->data);
						} else {
							$array = array(
								'name' => $this->input->post('sms_name'),
								'usertypeID' => $this->input->post('sms_user'),
								'template' => $this->input->post('sms_template'),
							);

							$this->mailandsmstemplate_m->update_mailandsmstemplate($array, $id);
							$this->session->set_flashdata('success', $this->lang->line('menu_success'));
							redirect(base_url('mailandsmstemplate/index'));
						}
					}
				} else {
					if($this->data['mailandsmstemplate']->type == 'email') {
						$this->data['email'] = 1;
						$this->data['sms'] = 0;
					} elseif($this->data['mailandsmstemplate']->type == 'sms') {
						$this->data['email'] = 0;
						$this->data['sms'] = 1;
					}
					$this->data["email_user"] = $this->data['mailandsmstemplate']->usertypeID;
					$this->data["sms_user"] = $this->data['mailandsmstemplate']->usertypeID;
					$this->data["subview"] = "mailandsmstemplate/edit";
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

	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['mailandsmstemplate'] = $this->mailandsmstemplate_m->get_mailandsmstemplate($id);
			if($this->data['mailandsmstemplate']) {
				$this->data["subview"] = "mailandsmstemplate/view";
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

	public function delete() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['mailandsmstemplate'] = $this->mailandsmstemplate_m->get_mailandsmstemplate($id);
			if($this->data['mailandsmstemplate']) {
				$this->mailandsmstemplate_m->delete_mailandsmstemplate($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("mailandsmstemplate/index"));
			} else {
				redirect(base_url("mailandsmstemplate/index"));
			}
		} else {
			redirect(base_url("mailandsmstemplate/index"));
		}
	}
	
	public function makedefault(){
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
	      $mailandsmstemplate = $this->mailandsmstemplate_m->get_mailandsmstemplate($id);
          $this->mailandsmstemplate_m->setDefault($mailandsmstemplate->catID,$id);
          redirect(base_url("mailandsmstemplate/index"));	
		}
	}

}

