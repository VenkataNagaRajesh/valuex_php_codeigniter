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
				'field' => 'products[]', 
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
		if(count($this->input->post('products')) > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message("valProduct", "%s Required");
			return FALSE;
		}
    }
    
    public function valProductbkp(){
		if($this->input->post('airlineID') > 0) {
            $contract = $this->contract_m->getAirlineByWhere(array('productID'=>$this->input->post('productID')));
            if(count($contract) == 0){
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
		if($roleID != 1){
			$this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		  } else {
			  $this->data['airlines'] = $this->airline_m->getAirlinesData();
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
        
         $this->data['products'] = $this->product_m->get_products();
		 $this->data['airlineID'] = htmlentities(escapeString($this->uri->segment(3)));
		
		if($_POST) { 
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
                //echo validation_errors();
				$this->data["subview"] = "contract/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				$data['airlineID'] = $this->input->post('airlineID');
				$data['name'] = $this->input->post('name');               
                $data['start_date'] = date_format(date_create($this->input->post('start_date')),'Y-m-d');
				$data['end_date'] = date_format(date_create($this->input->post('end_date')),'Y-m-d');
				$data['active'] = $this->input->post('active');
                $data['create_date'] = time();
                $data['modify_date'] = time();
                $data['create_userID'] = $this->session->userdata('loginuserID');
                $data['modify_userID'] = $this->session->userdata('loginuserID');               
				$this->contract_m->insert_contract($data);
				$contractID = $this->db->insert_id();

				// Adding product to contract
				 $link['contractID'] = $contractID;
				 $link["create_date"] = time();				 
				 $link["create_userID"] = $this->session->userdata('loginuserID');				
				 foreach($this->input->post('products') as $productID){
				  $link['productID'] = $productID;
				  $this->contract_m->insert_contract_product($link);
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
        
         $this->data['products'] = $this->product_m->get_products();
		 $this->data['contractID'] = htmlentities(escapeString($this->uri->segment(3)));
		 $this->data['contract'] = $this->contract_m->get_contract($this->data['contractID']);	
		// print_r($this->data['contract']); exit;	 
		 if($this->data['contractID']){ 
		   if($this->data['contract']){ 
			   $this->data['contract']->start_date = date_format(date_create($this->data['contract']->start_date),'d-m-Y');
			   $this->data['contract']->end_date = date_format(date_create($this->data['contract']->end_date),'d-m-Y');
			if($_POST){  
				$rules = $this->rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					//echo validation_errors();
					$this->data["subview"] = "contract/edit";
					$this->load->view('_layout_main', $this->data);
				} else {
					$data['airlineID'] = $this->input->post('airlineID');
					$data['name'] = $this->input->post('name');					
					$data['start_date'] = date_format(date_create($this->input->post('start_date')),'Y-m-d');
					$data['end_date'] = date_format(date_create($this->input->post('end_date')),'Y-m-d');               
					$data['modify_date'] = time();
					$data['active'] = $this->input->post('active');                
					$data['modify_userID'] = $this->session->userdata('loginuserID');					             
					$this->contract_m->update_contract($data,$this->data['contractID']);

					$products = array();
					 if(!empty($this->data['contract']->products)){
					 $products = explode(',',$this->data['contract']->airlineIDs);
					 }
					 $delete_list = array_diff($products,$this->input->post('products'));
					 if(!empty($delete_list)){
					 $this->contract_m->delete_contract_product($this->data['contractID'],$delete_list);
					 }
					 $insert_list = array_diff($this->input->post('products'),$products);
					
					  if(!empty($insert_list)){
					  $link['contractID'] = $this->data['contractID'];				 
                      $link["create_date"] = time();
                      $link["create_userID"] = $this->session->userdata('loginuserID');				  
					  foreach($insert_list as $productID){
					   $link['productID'] = $productID;
					   $this->contract_m->insert_contract_product($link);
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
        $airlineID = $this->contract_m->getAirlineByWhere(array('contractID'=>$id))[0]->airlineID;
       
        $this->contract_m->delete_contract($id);
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
    
}