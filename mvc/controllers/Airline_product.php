<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_product extends Admin_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('airline_m');
        $this->load->model('user_m');
        $this->load->model('product_m');
        $this->load->model('airline_product_m');
        $language = $this->session->userdata('lang');
		$this->lang->load('airline_product', $language);
    }
    
    protected function rules() {
		$rules = array(
			array(
				'field' => 'airlineID', 
				'label' => $this->lang->line("airline_product"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valAirline'
			),
			array(
				'field' => 'productID', 
				'label' => $this->lang->line("product_name"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valProduct'
            ),
            array(
				'field' => 'start_date', 
				'label' => $this->lang->line("start_date"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
            ),
            array(
				'field' => 'end_date', 
				'label' => $this->lang->line("end_date"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			)
		);
		return $rules;
    }
    
    public function valAirline(){
		if($this->input->post('airlineID') > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message("valAirline", "%s Required");
			return FALSE;
		}
    }
    
    public function valProduct(){
		if($this->input->post('airlineID') > 0) {
            $airline_product = $this->airline_product_m->getAirlineByWhere(array('productID'=>$this->input->post('productID')));
            if(count($airline_product) == 0){
               return TRUE;
            } else {
               $this->form_validation->set_message("valProduct", "Already Exist this Product to this airline");
               return FALSE;
            }
		} else {
			$this->form_validation->set_message("valProduct", "%s Required");
			return FALSE;
		}
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
		
		if($this->session->userdata('usertypeID') == 1){ //echo "sss"; exit;
		   $this->data['airlinelist'] = $this->airline_m->getAirlinesData();
		} else {
		   $this->data['airlinelist'] = $this->user_m->getUserAirlines($this->session->userdata('loginuserID'));	
        }	
        
         $this->data['products'] = $this->product_m->get_products();
		 $this->data['airlineID'] = htmlentities(escapeString($this->uri->segment(3)));
		if($_POST) { 
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
				$this->data["subview"] = "airline_product/add";
				$this->load->view('_layout_main', $this->data);
			} else {
                $data['airlineID'] = $this->input->post('airlineID');
                $data['productID'] = $this->input->post('productID');
                $data['start_date'] = date_format(date_create($this->input->post('start_date')),'Y-m-d');
                $data['end_date'] = date_format(date_create($this->input->post('end_date')),'Y-m-d');
                $data['create_date'] = time();
                $data['modify_date'] = time();
                $data['create_userID'] = $this->session->userdata('loginuserID');
                $data['modify_userID'] = $this->session->userdata('loginuserID');               
                $this->airline_product_m->insert_airline_product($data);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("airline/index"));
			}
		} else {
			$this->data["subview"] = "airline_product/add";
			$this->load->view('_layout_main', $this->data);
		}
    }

    public function delete(){
        $id = htmlentities(escapeString($this->uri->segment(3))); 
        $airlineID = $this->airline_product_m->getAirlineByWhere(array('airline_productID'=>$id))[0]->airlineID;
       
        $this->airline_product_m->delete_airline_product($id);
        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		redirect(base_url('airline/view/'.$airlineID)); 
    }
    
}