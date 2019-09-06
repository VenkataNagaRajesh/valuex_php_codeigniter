<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailandsmstemplate extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('usertype_m');
		$this->load->model('airline_m');
		$this->load->model('user_m');
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
         $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css'                      
						//'assets/datepicker/datepicker.css'
                ),
                'js' => array(
                        'assets/select2/select2.js'                       
						//'assets/datepicker/datepicker.js'
                )
        );
		
		//$this->data['mailandsmstemplates'] = $this->mailandsmstemplate_m->get_order_by_mailandsmstemplate_with_usertypeID();
		$userID = $this->session->userdata('loginuserID');
		$userTypeID = $this->session->userdata('usertypeID');
		if($userTypeID == 2){
          $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
        } else if($userTypeID != 1){
		   $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		} else {
          $this->data['airlines'] = $this->airline_m->getAirlinesData();
        }

        if(!empty($this->input->post('filter_airline'))){
          $this->data['filter_airline'] = $this->input->post('filter_airline');
        } else {
		  if($this->session->userdata('default_airline')){
		     $this->data['filter_airline'] = $this->session->userdata('default_airline'); 
		  } else {
             $this->data['filter_airline'] = 0;
		  }
        } 

		//print_r($this->data['airlines']); exit;
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
		$userID = $this->session->userdata('loginuserID');
		$userTypeID = $this->session->userdata('usertypeID');
		if($userTypeID == 2){
          $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
        } else if($userTypeID != 1){
		   $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		} else {
          $this->data['airlines'] = $this->airline_m->getAirlinesData();
        }
	//	print_r($this->data['airlines']); exit;
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
						'airlineID' => $this->input->post('airlineID'),
						'template' => $this->input->post('email_template',FALSE),
						'create_userID' => $this->session->userdata('loginuserID'),
						'create_date' => time(),
						'modify_userID' => $this->session->userdata('loginuserID'),
						'modify_date' => time()
					);
					$this->mailandsmstemplate_m->insert_mailandsmstemplate($array);
					$id =  $this->db->insert_id();
					if($id && $this->input->post('default')){
						$this->mailandsmstemplate_m->setDefault($this->input->post('category'),$id,$this->input->post('airlineID'));
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
		$userID = $this->session->userdata('loginuserID');
		$userTypeID = $this->session->userdata('usertypeID');
		if($userTypeID == 2){
          $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
        } else if($userTypeID != 1){
		   $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
		} else {
          $this->data['airlines'] = $this->airline_m->getAirlinesData();
        }
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
								'airlineID' => $this->input->post('airlineID'),
								'template' => $this->input->post('email_template',FALSE),				
								'modify_userID' => $this->session->userdata('loginuserID'),
								'modify_date' => time()
							 );							 
                            
							$this->mailandsmstemplate_m->update_mailandsmstemplate($array, $id);
							if($this->input->post('default')){
						     $this->mailandsmstemplate_m->setDefault($this->input->post('category'),$id, $this->input->post('airlineID'));
					        }
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
          $this->mailandsmstemplate_m->setDefault($mailandsmstemplate->catID,$id,$mailandsmstemplate->airlineID);
          redirect(base_url("mailandsmstemplate/index"));	
		}
	}
	
	function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');  
		
	  
	     $aColumns = array('m.mailandsmstemplateID','m.name','a.code','cat.name','m.default');
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
			
			$sWhere = '';
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

         

           if($this->session->userdata('usertypeID') != 1){  
              $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
			  $sWhere .= 'a.vx_aln_data_defnsID IN ('.implode(',',$this->session->userdata('login_user_airlineID')).')';		
            }
            if(!empty($this->input->get('filter_airline'))){  
              $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
			  $sWhere .= 'm.airlineID = '.$this->input->get('filter_airline');		
            }		

		   
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS m.*,cat.name category,a.aln_data_value airline_name,a.code airline_code FROM mailandsmstemplate m LEFT JOIN mailandsmscategory cat ON cat.catID = m.catID LEFT JOIN vx_aln_data_defns a ON a.vx_aln_data_defnsID = m.airlineID
		$sWhere       	
		$sOrder		
		$sLimit	"; 
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
	  foreach($rResult as $template){		 	
		  if(permissionChecker('mailandsmstemplate_edit')){ 			
			$template->action .= btn_edit('mailandsmstemplate/edit/'.$template->mailandsmstemplateID, $this->lang->line('edit'));
			
		  }
		  if(permissionChecker('mailandsmstemplate_delete')){
		   $template->action .= btn_delete('mailandsmstemplate/delete/'.$template->mailandsmstemplateID, $this->lang->line('delete'));	
$template->action .= '<a href="base_url("mailandsmstemplate/makedefault/'.$template->mailandsmstemplateID.')" class="btn btn-success btn-xs mrg">Make Default</a>';			   
		  }
		  $output['aaData'][] = $template;				
		}					
		  echo json_encode( $output );		
	}

}

