<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("product_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('product', $language);	
	}

	public function index() {
		$dt = Array('active' => 1);
		$this->data["products"] = $this->product_m->get_products($dt, TRUE);
		//print_r($this->data["products"]); exit;		
		$this->data["subview"] = "product/index";
		$this->load->view('_layout_main', $this->data);		
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'name', 
				'label' => $this->lang->line("product_name"), 
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
				$this->data["subview"] = "product/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array = array(
					"name" => $this->input->post("name"),
					"create_date" => date("Y-m-d h:i:s"),
					"modify_date" => date("Y-m-d h:i:s"),
					"create_userID" => $this->session->userdata('loginuserID')					
				);
				if (!$this->product_m->checkProductExists($this->input->post("name"))) {
					$this->product_m->insert_product($array);
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("product/index"));
				} else {
					$this->session->set_flashdata('error', 'Product with this name already exists!');
					$this->data["subview"] = "product/add";
					$this->load->view('_layout_main', $this->data);
				}
			}
		} else {
			$this->data["subview"] = "product/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit() {		
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) { 
			$dt = Array("productID" => $id);
			$this->data['product'] = $this->product_m->get_single_product($dt);
			//print_r($this->data['product']); exit;
			if($this->data['product']) { 
				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) {
						$this->data["subview"] = "product/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {
						$array = array(
							"name" => $this->input->post("name"),
							"modify_date" => date("Y-m-d h:i:s")
						);

						if (!$this->product_m->checkProductExists($this->input->post("name"))) {
							$this->product_m->update_product($array, $id);
							$this->session->set_flashdata('success', $this->lang->line('menu_success'));
							redirect(base_url("product/index"));
						}  else {
							$this->session->set_flashdata('error', 'Product with this name already exists!');
							$this->data["subview"] = "product/edit";
							$this->load->view('_layout_main', $this->data);
						}
					}
				} else {
					$this->data["subview"] = "product/edit";
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
			$dt = Array("productID" => $id);
			$this->data['product'] = $this->product_m->get_single_product($dt);
			if($this->data['product']) {				
					$dt = Array("active" => 0);
					$this->product_m->update_product($dt,$id);
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("product/index"));				
			} else {
				redirect(base_url("product/index"));
			}
		} else {
			redirect(base_url("product/index"));
		}
	}

}
