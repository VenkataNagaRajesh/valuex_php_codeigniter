<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailandsmstemplate extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('usertype_m');
		$this->load->model("mailandsmstemplate_m");
		$this->load->model("mailandsmstemplatetag_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('mailandsmstemplate', $language);
		$this->load->helper('ckeditor_helper');
		        //Ckeditor's configuration
		   $this->data['ckeditor'] = array(
       		//Optionnal values
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"550px",	//Setting a custom width
				'height' 	=> 	'100px',	//Setting a custom height
 
			) );
			$this->load->library('CKEditor');
		    $this->load->library('CKFinder');
	 
		    //Add Ckfinder to Ckeditor
		    $this->ckfinder->SetupCKEditor($this->ckeditor,'../../assets/ckfinder/'); 
		}

	public function index() {		
		$this->data['mailandsmstemplates'] = $this->mailandsmstemplate_m->get_order_by_mailandsmstemplate_with_usertypeID();
		$this->data["subview"] = "mailandsmstemplate/index";
		$this->load->view('_layout_main', $this->data);
	}

	protected function rules() {
		$rules = array(				
				array(
					'field' => 'email_name',
					'label' => $this->lang->line("mailandsmstemplate_name"),
					'rules' => 'trim|required|xss_clean|max_length[128]'
				)		
			);
		return $rules;
	}	
	

	public function add() {		
		$usertypes = $this->usertype_m->get_usertype();
		$this->data['categories'] = $this->mailandsmstemplate_m->get_categories();
		$this->data['usertypes'] = $usertypes;
		if($_POST) { 	
				$rules = $this->rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data['form_validation'] = validation_errors();
					$this->data["subview"] = "mailandsmstemplate/add";
					$this->load->view('_layout_main', $this->data);
				} else {
					$array = array(
						'name' => $this->input->post('email_name'),						
						'catID' => $this->input->post('category'),
						'template' => $this->input->post('email_template'),
						'create_userID' => $this->session->userdata('loginuserID'),
						'create_date' => time(),
						'modify_userID' => $this->session->userdata('loginuserID'),
						'modify_date' => time()
					);
					$this->mailandsmstemplate_m->insert_mailandsmstemplate($array);
					$id =  $this->db->insert_id();
					if($id && $this->input->post('default')){
						$this->mailandsmstemplate_m->setDefault($this->input->post('category'),$id);
					}
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url('mailandsmstemplate/index'));
				}			
		} else {
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
			$this->data['mailtemplate'] = $this->mailandsmstemplate_m->get_mailandsmstemplate($id);
			if($this->data['mailtemplate']) {			
				$this->data['categories'] = $this->mailandsmstemplate_m->get_categories();
				if($_POST) {
                         					
				        
					    $rules = $this->rules();
						$this->form_validation->set_rules($rules);
						if ($this->form_validation->run() == FALSE) {
							$this->data["subview"] = "mailandsmstemplate/edit";
							$this->load->view('_layout_main', $this->data);
						} else {
							
							$array = array(
								'name' => $this->input->post('email_name'),						
								'catID' => $this->input->post('category'),
								'template' => $this->input->post('email_template',FALSE),				
								'modify_userID' => $this->session->userdata('loginuserID'),
								'modify_date' => time()
							 );							 
                            if($this->input->post('default')){
						     $this->mailandsmstemplate_m->setDefault($this->input->post('category'),$id);
					        }
							$this->mailandsmstemplate_m->update_mailandsmstemplate($array, $id);
							$this->session->set_flashdata('success', $this->lang->line('menu_success'));
							redirect(base_url('mailandsmstemplate/index'));
						}
				} else {
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

