<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract extends Admin_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('airline_m');
        $this->load->model('user_m');
        $this->load->model('product_m');
        $this->load->model('contract_m');
        $language = $this->session->userdata('lang');
		$this->lang->load('contract', $language);
		/*$url = "qbaki.com";
			if (!filter_var($url, FILTER_VALIDATE_URL)){
				echo "invalid";
			} else{ echo "valid"; }
			exit;*/
    }
    
    protected function rules() {	
		$rules = array(
			array(
				'field' => 'airlineID', 
				'label' => $this->lang->line("airline_product"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valAirline'
			),
			array(
				'field' => 'name', 
				'label' => $this->lang->line("contract_name"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'email_id', 
				'label' => $this->lang->line("email_id"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|valid_email'
			),
			array(
				'field' => 'designation', 
				'label' => $this->lang->line("designation"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'telephone', 
				'label' => $this->lang->line("telephone"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'ext_no', 
				'label' => $this->lang->line("ext_no"), 
				'rules' => 'trim|required|xss_clean|max_length[5]'
			),
			array(
				'field' => 'mobile_number', 
				'label' => $this->lang->line("mobile_number"), 
				'rules' => 'trim|required|xss_clean|max_length[10]'
			)
			);

			$i =1; 
			$products = $this->product_m->get_products(array('active'=>1));
			do{				
			 $ruleslist = array(	
				array(
					'field' => 'pmod'.$i.'-productID', 
					'label' => $this->lang->line("product_name"), 
					'rules' =>'trim|required|xss_clean|max_length[60]|callback_valProduct'
				),
				array(
					'field' => 'pmod'.$i.'-start-date', 
					'label' => $this->lang->line("start_date"), 
					'rules' => 'trim|required|xss_clean|max_length[60]|callback_valStartDate[pmod'.$i.']'
				),
				array(
					'field' => 'pmod'.$i.'-end-date', 
					'label' => $this->lang->line("end_date"), 
					'rules' => 'trim|required|xss_clean|max_length[60]|callback_valEndDate[pmod'.$i.']'
				),
				array(
					'field' => 'pmod'.$i.'-no-users', 
					'label' => $this->lang->line("no_users"), 
					'rules' => 'trim|required|xss_clean|max_length[60]'
				)
			);	
			$rules = array_merge($rules,$ruleslist);
			$i++;
		} while($i <= count($products) && !empty($this->input->post('pmod'.$i.'-productID')));
		//print_r($_POST);
		//print_r($rules); exit;
		return $rules;
	}
	
	protected function client_rules() {
		$rules = array(
			array(
				'field' => 'client_name',
				'label' => $this->lang->line("client_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'client_domain',
				'label' => $this->lang->line("client_domain"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valid_url_format'
			),			
			array(
				'field' => 'client_email',
				'label' => $this->lang->line("client_email"),
				'rules' => 'trim|required|max_length[40]|valid_email|xss_clean|callback_unique_email'
			),
			array(
				'field' => 'client_phone',
				'label' => $this->lang->line("client_phone"),
				'rules' => 'trim|required|min_length[5]|max_length[25]|xss_clean'
			),		
			array(
				'field' => 'client_username',
				'label' => $this->lang->line("client_username"),
				'rules' => 'trim|required|min_length[4]|max_length[40]|xss_clean|callback_lol_username'
			),
			array(
				'field' => 'client_password',
				'label' => $this->lang->line("client_password"),
				'rules' => 'trim|required|min_length[4]|max_length[40]|xss_clean|callback_valid_password'
			)
		);
		return $rules;
	}

	public function valid_password($password = ''){
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
        if (empty($password))
        {
            $this->form_validation->set_message('valid_password', 'The {field} field is required.');
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1 || preg_match_all($regex_uppercase, $password) < 1 ||  preg_match_all($regex_number, $password) < 1 ||preg_match_all($regex_special, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have  uppercase & lowercase letter & numeric & special character.');
            return FALSE;
        }        
        if (strlen($password) < 5)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least 5 characters in length.');
            return FALSE;
        }
        if (strlen($password) > 32)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');
            return FALSE;
        }
        return TRUE;
	}
	
    function valid_url_format($url){
		if(empty($url)){
			$this->form_validation->set_message('valid_url_format', 'Domain field is required');
            return FALSE;	
		} else {
			$pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";	
			if(substr( $url, 0, 4 ) != "http"){
                  $url = 'http://'.$url;
			}		
			if (!filter_var($url, FILTER_VALIDATE_URL)){
				$this->form_validation->set_message('valid_url_format', 'Domain you entered is not in correct format.');
				return FALSE;
			} else {
				return TRUE;
			}
		}       
    }   

	function lol_username(){
			$tables = array('VX_user');
			$array = array();
			$i = 0;
			foreach ($tables as $table) {
				$user = $this->user_m->get_username($table, array("username" => $this->input->post('username')));
				if(count($user)) {
					$this->form_validation->set_message("lol_username", "%s already exists");
					$array['permition'][$i] = 'no';
				} else {
					$array['permition'][$i] = 'yes';
				}
				$i++;
			}

			if(in_array('no', $array['permition'])) {
				return FALSE;
			} else {
				return TRUE;
			}
	}

	function unique_email(){
		    $tables = array('VX_user');
			$array = array();
			$i = 0;
			foreach ($tables as $table) {
				$user = $this->user_m->get_username($table, array("email" => $this->input->post('client_email')));
				if(count($user)) {
					$this->form_validation->set_message("unique_email", "%s already exists");
					$array['permition'][$i] = 'no';
				} else {
					$email_array = explode('@',$this->input->post('client_email'));
					$url = $this->input->post('client_domain');
					if(substr( $url, 0, 4 ) != "http"){
						$url = 'http://'.$url;
				  	}
					$pieces = parse_url($url);
					$domain = isset($pieces['host']) ? $pieces['host'] : '';
					preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs);
			
					if($regs['domain'] == $email_array[1]){
						$array['permition'][$i] = 'yes';
					} else {
						$this->form_validation->set_message("unique_email", "%s not match with domain $domain");
					    $array['permition'][$i] = 'no';	
					}					
				}
				$i++;
			}

			if(in_array('no', $array['permition'])) {
				return FALSE;
			} else {
				return TRUE;
			}
	}	
	
	public function valStartDate($date,$field){	
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if($id){
          $where['cp.contractID !='] = $id;
		}
		$where['c.airlineID'] = $this->input->post('airlineID');
		if($this->input->post($field.'-productID')){
			$where['cp.productID'] = $this->input->post($field.'-productID');
			$where ['cp.start_date <='] = date_format(date_create($this->input->post($field.'-start-date')),'Y-m-d');
			$where ['cp.end_date >='] = date_format(date_create($this->input->post($field.'-start-date')),'Y-m-d');			
			$productinfo = $this->contract_m->getProductInfo($where);
			if($productinfo){
			$this->form_validation->set_message("valStartDate", "already exist this product in this date");
			return FALSE;
			} else {
			return TRUE;
			}
	    }
	}

	public function valEndDate($date,$field){
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if($id){
          $where['cp.contractID !='] = $id;
		}
		$where['c.airlineID'] = $this->input->post('airlineID');
		if($this->input->post($field.'-productID')){
			$where['cp.productID'] = $this->input->post($field.'-productID');
			$where ['cp.start_date <='] = date_format(date_create($this->input->post($field.'-end-date')),'Y-m-d');
			$where ['cp.end_date >='] = date_format(date_create($this->input->post($field.'-end-date')),'Y-m-d');
			$productinfo = $this->contract_m->getProductInfo($where);
			if($productinfo){
			$this->form_validation->set_message("valEndDate", "already exist this product in this date");
			return FALSE;
			} else {
			return TRUE;
			}
	    }
	}

    public function valAirline(){
		if($this->input->post('airlineID') > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message("valAirline", "%s Required");
			return FALSE;
		}
	}
	
	public function valProduct($value){		
		if(!empty($value)){
			return TRUE;
		} else {
			$this->form_validation->set_message("valProduct", "%s Required");
			return FALSE;
		}
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
		$roleID = $this->session->userdata('roleID');
		$where = array();
		if(!empty($this->input->post('airlineID')) && isset($_POST['airlineID'])){
			$where['c.airlineID'] = $this->input->post('airlineID');
		}
		if($roleID != 1){
			$this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		  } else {
			  $this->data['airlines'] = $this->airline_m->getAirlinesData();
		  }
		  if($roleID == 1){
			  $this->data['contracts'] = $this->contract_m->get_contracts($where);
		  } else {
			$this->data['contracts'] = $this->contract_m->getLoginUserContracts($where);
		  }
		  foreach($this->data['contracts'] as $contract){
			  $contract->products = $this->contract_m->getProductsByContract($contract->contractID);			  
		  }				 
		$this->data["subview"] = "contract/index";
		$this->load->view('_layout_main', $this->data);
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
		
		if($this->session->userdata('usertypeID') == 1){ 
		   $this->data['airlinelist'] = $this->airline_m->getAirlinesData();
		} else {
		   $this->data['airlinelist'] = $this->user_m->getUserAirlines($this->session->userdata('loginuserID'));	
        }	
        
         $this->data['products'] = $this->product_m->get_products(array('active'=>1));
		 $this->data['airlineID'] = htmlentities(escapeString($this->uri->segment(3)));
		
		if($_POST) { 
			$rules = $this->rules();
			if($this->input->post('client-registration') == 1){
				$rules = array_merge($rules,$this->client_rules());
			}
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				//echo validation_errors(); exit;
				//echo form_error('pmod1-start-date'); exit;
				$this->data["subview"] = "contract/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				//Client Registration
				if($this->input->post('client-registration') == 1){
					$array["name"] = $this->input->post("client_name");
					$array["domain"] = $this->input->post("client_domain");				
					$array["email"] = $this->input->post("client_email");
					$array["phone"] = $this->input->post("client_phone");									
					$array["username"] = $this->input->post("client_username");
					$array["password"] = $this->user_m->hash($this->input->post("client_password"));
					$array["usertypeID"] = 2;
					$array["roleID"] = 6;
					$array["create_date"] = date("Y-m-d h:i:s");
					$array["modify_date"] = date("Y-m-d h:i:s");
					$array["create_userID"] = $this->session->userdata('loginuserID');
					$array["create_username"] = $this->session->userdata('username');
					$array["create_usertype"] = $this->session->userdata('roleID');
					$array["active"] = 1;	
					$this->user_m->insert_user($array);
					$userID = $this->db->insert_id();
					
					//adding airline to user
					$ulink['userID'] = $userID;
					$ulink["create_date"] = time();
					$ulink["modify_date"] = time();
					$ulink["create_userID"] = $this->session->userdata('loginuserID');
					$ulink["modify_userID"] = $this->session->userdata('loginuserID');
					$ulink['airlineID'] = $this->input->post('airlineID');
					$this->user_m->insert_user_airline($ulink);
				}	 else {
					$userID = $this->input->post('create_client');
				}			

				// Contract Adding
				$data['airlineID'] = $this->input->post('airlineID');
				$data['name'] = $this->input->post('name'); 
				$data['email_id'] = $this->input->post('email_id');
				$data['designation'] = $this->input->post('designation'); 
				$data['telephone'] = $this->input->post('telephone'); 
				$data['ext_no'] = $this->input->post('ext_no'); 
				$data['mobile_number'] = $this->input->post('mobile_number');              
				$data['active'] = $this->input->post('active');
				$data['create_date'] = time();
				$data['modify_date'] = time();
				$data['create_userID'] = $this->session->userdata('loginuserID');
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['create_client'] = $userID;               
				$this->contract_m->insert_contract($data);
				$contractID = $this->db->insert_id();
			  
				
				// Adding product to contract
				$i =1;
				while($i <= count($this->data['products']) && !empty($this->input->post('pmod'.$i.'-productID'))){
				 $link['contractID'] = $contractID;
				 $link["create_date"] = time();				 
				 $link["modify_date"] = time();				 
				 $link["create_userID"] = $this->session->userdata('loginuserID');			
				 $link["modify_userID"] = $this->session->userdata('loginuserID');			
				 $link['productID'] = $this->input->post('pmod'.$i.'-productID');
				 $link['start_date'] = date_format(date_create($this->input->post('pmod'.$i.'-start-date')),'Y-m-d');
				 $link['end_date'] = date_format(date_create($this->input->post('pmod'.$i.'-end-date')),'Y-m-d');
				 $link['no_users'] = $this->input->post('pmod'.$i.'-no-users');
				 //print_r($link); exit;
				  $this->contract_m->insert_contract_product($link);
				  
				  //add product to user
                 if($userID){
					$product['userID'] = $userID;
					$product["create_date"] = time();
					$product["modify_date"] = time();
					$product["create_userID"] = $this->session->userdata('loginuserID');
					$product["modify_userID"] = $this->session->userdata('loginuserID');					
					$product['productID'] = $this->input->post('pmod'.$i.'-productID');
					$this->user_m->insert_user_product($product);					
				 }

				  $i++;
			    } 
				 
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("contract/index"));
			}
		} else {
			$this->data["subview"] = "contract/add";
			$this->load->view('_layout_main', $this->data);
		}
	}
	
	public function edit() {
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
        
         $this->data['products'] = $this->product_m->get_products(array('active'=>1));
		 $this->data['contractID'] = htmlentities(escapeString($this->uri->segment(3)));
		 $this->data['contract'] = $this->contract_m->get_contract($this->data['contractID']);	
		// print_r($this->data['contract']); exit;	 
		 if($this->data['contractID']){ 
		   if($this->data['contract']){
			   $this->data['contract']->products = $this->contract_m->getProductsByContract($this->data['contract']->contractID); 
			   foreach($this->data['contract']->products as $product){
				if ( $product ) {
					$flg = 0;
					foreach($this->data['products'] as $pd) {
						if ($pd->productID == $product->productID) {
							$flg = 1;
							break;
						}
					}
					if ( !$flg){
						$this->data['products'][] =  $this->product_m->get_single_product(Array("productID" => $product->productID));
					}
				}
			       	$product->start_date = date_format(date_create($product->start_date),'d-m-Y');
				$product->end_date = date_format(date_create($product->end_date),'d-m-Y');
			   }
			   $this->data['users'] = $this->user_m->getClientByAirline($this->data['contract']->airlineID,6);					   
			if($_POST){  
				$rules = $this->rules();
				unset($rules[0]);
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					//echo validation_errors();
					$this->data["subview"] = "contract/edit";
					$this->load->view('_layout_main', $this->data);
				} else {
					//$data['airlineID'] = $this->input->post('airlineID');
					$data['name'] = $this->input->post('name');	
					$data['email_id'] = $this->input->post('email_id'); 
					$data['designation'] = $this->input->post('designation'); 
					$data['telephone'] = $this->input->post('telephone'); 
					$data['ext_no'] = $this->input->post('ext_no'); 
					$data['mobile_number'] = $this->input->post('mobile_number');				               
					$data['modify_date'] = time();
					$data['active'] = $this->input->post('active');                
					$data['modify_userID'] = $this->session->userdata('loginuserID');					             
					$this->contract_m->update_contract($data,$this->data['contractID']);

					// Update product data of contract
					$i =1;
					while($i <= count($this->data['products']) && !empty($this->input->post('pmod'.$i.'-productID'))){
					$link['contractID'] = $this->data['contractID'];
					$link["modify_date"] = time();				 
					$link["modify_userID"] = $this->session->userdata('loginuserID');			
					$link['productID'] = $this->input->post('pmod'.$i.'-productID');
					$link['start_date'] = date_format(date_create($this->input->post('pmod'.$i.'-start-date')),'Y-m-d');
					$link['end_date'] = date_format(date_create($this->input->post('pmod'.$i.'-end-date')),'Y-m-d');
					$link['no_users'] = $this->input->post('pmod'.$i.'-no-users');
									
					if($this->input->post('pmod'.$i.'-contract_productID')){
					    $this->contract_m->update_contract_product($this->input->post('pmod'.$i.'-contract_productID'),$link);
					} else {
						$link['create_date'] = time();
						$link["create_userID"] = $this->session->userdata('loginuserID');	
					    $this->contract_m->insert_contract_product($link);	
					}
					$i++;
							  //add product to user
					foreach($this->data['users'] as $user) {
					$userID = $user->userID;

		 	   		 $user_products = $this->user_m->getProductsByUser($userID);	
					$product = Array();
					 if($userID && ! in_array($this->input->post('pmod'.$i.'-productID'), explode(',',$user_products))){
						$product["userID"] = $userID;
						$product["create_date"] = time();
						$product["modify_date"] = time();
						$product["create_userID"] = $this->session->userdata('loginuserID');
						$product["modify_userID"] = $this->session->userdata('loginuserID');					
						$product['productID'] = $this->input->post('pmod'.$i.'-productID');
						$this->user_m->insert_user_product($product);					
					 }
					}
					} 
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("contract/index"));
				}
			} else { 
				$this->data["subview"] = "contract/edit";
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

    public function delete(){
        $id = htmlentities(escapeString($this->uri->segment(3))); 
        $airlineID = $this->contract_m->getContractsByWhere(array('contractID'=>$id))[0]->airlineID;       
		$this->contract_m->delete_contract($id);
		$this->contract_m->delete_contract_product($id);
        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		redirect(base_url('contract/index')); 
	}

	function active() {
		if(permissionChecker('contract_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				if((int)$id) {
					$data['modify_userID'] = $this->session->userdata('loginuserID');
					$data['modify_date'] = time();
					if($status == 'chacked') {
						$data['active'] = 1 ;
						$this->contract_m->update_contract($data, $id);
						echo 'Success';
					} elseif($status == 'unchacked') {
						$data['active'] = 0 ;
						$this->contract_m->update_contract($data, $id);
						echo 'Success';
					} else {
						echo "Error";
					}
				} else {
					echo "Error";
				}
			} else {
				echo "Error";
			}
		} else {
			echo "Error";
		}
	}
	
	function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');
	   
	    $aColumns = array('c.contractID','d.code','pname','c.start_date','c.end_date');
		$sLimit = "";
		
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{		
			  $sLimit = "LIMIT ".$_GET['iDisplayStart'].",".$_GET['iDisplayLength'];
			}
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$sOrder = "ORDER BY  ";
				for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
				{
					if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
					{
						if($_GET['iSortCol_0'] == 8){
							$sOrder .= " (s.order_no*-1) DESC ,";
						} else {
						 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
							".$_GET['sSortDir_'.$i] .", ";
						}
					}
				}				
				  $sOrder = substr_replace( $sOrder, "", -2 );
				
				if ( $sOrder == "ORDER BY" )
				{
					$sOrder = "";
				}
			}
			$sWhere = "";
			
			if ( $_GET['sSearch'] != "" )	{
				
						$sWhere .= " AND (";
				
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
			}
			
			/* Individual column filtering */
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
				}
			}           

           if($this->input->get('airlineID')){  
              $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
			  $sWhere .= 'c.airlineID = '.$this->input->get('airlineID');		
            } 		   
		  
		  $sGroup = " GROUP BY d.vx_aln_data_defnsID ";  
         $sQuery = "SELECT SQL_CALC_FOUND_ROWS group_concat(p.name SEPARATOR '+') products,c.*,d.code from VX_contract c LEFT JOIN VX_contract_products cp ON cp.contractID = c.contractID LEFT JOIN VX_products p ON p.productID = cp.productID LEFT JOIN  VX_data_defns d ON d.vx_aln_data_defnsID = c.airlineID
		           $sWhere
				   $sGroup		
				   $sOrder		
				   $sLimit";					
		
	//print_r($sQuery); exit;
	$rResult = $this->install_m->run_query($sQuery);
	$sQuery = "SELECT FOUND_ROWS() as total";
	$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
			
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $rResultFilterTotal,
		"iTotalDisplayRecords" => $rResultFilterTotal,
		"aaData" => array()
	  );
	  $i=1;
	  foreach($rResult as $contract){		 	
		  if(permissionChecker('contract_edit')){ 			
			$contract->action = btn_edit('contract/edit/'.$contract->contractID, $this->lang->line('edit'));
				
		  }
		  if(permissionChecker('contract_delete')){
		   $contract->action .= btn_delete('contract/delete/'.$contract->contractID, $this->lang->line('delete'));			 
		  }
		  	$status = $contract->active;
			$contract->active = "<div class='onoffswitch-small' id='".$contract->contractID."'>";
            $contract->active .= "<input type='checkbox' id='myonoffswitch".$contract->contractID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $contract->active .= " checked >";
			} else {
			   $contract->active .= ">";
			}				
			$contract->active .= "<label for='myonoffswitch".$contract->contractID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>"; 
			   
			$contract->start_date = date_format(date_create($contract->start_date),'d-m-Y');
			$contract->end_date = date_format(date_create($contract->end_date),'d-m-Y');
			$output['aaData'][] = $contract;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array('#','Carrier','Product','Start Date','End Date');
		  $rows = array('contractID','code','name','start_date','end_date');
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
	
	public function getContractsByAirline(){
		$airlineID = $this->input->post('airlineID');
		$contracts = $this->contract_m->getContractsByWhere(array('airlineID'=>$airlineID));
		echo '<option value="0">Select Contract</option>';
		foreach($contracts as $contract){
			echo '<option value="'.$contract->contractID.'">'.$contract->name.'</option>';
		}		
	}
	
    public function getProductsByContract(){
		$contractID = $this->input->post('contractID');
		$products = $this->contract_m->getProductsByContract($contractID);
		  echo '<option value="0">Select Product</option>';
		foreach($products as $product){
		  echo '<option value="'.$product->productID.'">'.$product->name.'</option>';
		}		
	}

	public function checkClientByAirline(){
		$airlineID = $this->input->post('airlineID');
		$users = $this->user_m->getClientByAirline($airlineID,6);
		
        if($users){
			$json['status'] = '';
			foreach($users as $user){
		   	  $json['status'] .= '<option value="'.$user->userID.'">'.$user->name.'</option>';
			}
		} else {
           $json['status'] = 0;
		}			
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}

	public function activeProductsByAirline(){
		$airlineID = $this->input->post('airlineID');
		//$products = $this->product_m->get_products();
		$products = $this->user_m->getUserActiveProducts($airlineID);
		foreach($products as $product){
			echo "<option value='".$product->productID."'>".$product->name."</option>";
		}
	}
}
