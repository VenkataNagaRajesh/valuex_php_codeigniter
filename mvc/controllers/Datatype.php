<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatype extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("datatype_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('datatype', $language);	
		$this->data['icon'] = $this->menu_m->getMenu(array("link"=>"datatype"))->icon;
	}

	public function index() {
		$usertype = $this->session->userdata("usertype");
		$this->data['datatypes'] = $this->datatype_m->get_datatypes();
		$this->data["subview"] = "datatype/index";
		$this->load->view('_layout_main', $this->data);		
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'name', 
				'label' => $this->lang->line("datatype_name"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_datatype'
			),
			array(
				'field' => 'alias', 
				'label' => $this->lang->line("datatype_alias"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			)
		);
		return $rules;
	}

	public function add() {
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "datatype/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array = array(
					"name" => $this->input->post("name"),
					"alias" => $this->input->post("alias"),
					"active" => 1,
					"create_date" => time(),
					"modify_date" => time(),
					"create_userID" => $this->session->userdata('loginuserID'),
					"modify_userID" => $this->session->userdata('loginuserID')					
				);
				$this->datatype_m->insert_datatype($array);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("datatype/index"));
			}
		} else {
			$this->data["subview"] = "datatype/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit() {		
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['datatype'] = $this->datatype_m->get_datatype(array('vx_aln_data_typeID' => $id));
			if($this->data['datatype']) {
				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) {
						$this->data["subview"] = "datatype/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {
						$array = array(
							"name" => $this->input->post("name"),
							"alias" => $this->input->post("alias"),
							"modify_date" => time(),
							"modify_userID" => $this->session->userdata('loginuserID')
						);

						$this->datatype_m->update_datatype($array, $id);
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("datatype/index"));
					}
				} else {
					$this->data["subview"] = "datatype/edit";
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
			$this->data['datatype'] = $this->datatype_m->get_datatype(array('vx_aln_data_typeID' => $id));
			if($this->data['datatype']) {				
				$this->datatype_m->delete_datatype($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("datatype/index"));				
			} else {
				redirect(base_url("datatype/index"));
			}
		} else {
			redirect(base_url("datatype/index"));
		}	

	}

	public function unique_datatype() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$datatype = $this->datatype_m->get_datatype(array("name" => $this->input->post("name"), "vx_aln_data_typeID !=" => $id));
			if(count($datatype)) {
				$this->form_validation->set_message("unique_datatype", "%s already exists");
				return FALSE;
			}
			return TRUE;
		} else {
			$datatype = $this->datatype_m->get_datatype(array("name" => $this->input->post("name")));

			if(count($datatype)) {
				$this->form_validation->set_message("unique_datatype", "%s already exists");
				return FALSE;
			}
			return TRUE;
		}	
	}

}
