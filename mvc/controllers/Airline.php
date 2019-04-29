<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("airports_m");		
		$this->load->model("marketzone_m");
		$this->load->model("market_airport_map_m");
		$this->load->model("airline_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('airline', $language);	
	}	
	
	protected function rules() {
		$rules = array(
		   array(
				'field' => 'stateID', 
				'label' => $this->lang->line("master_state"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_state'
			),
			array(
				'field' => 'regionID', 
				'label' => $this->lang->line("master_region"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_region'
			),
			array(
				'field' => 'areaID', 
				'label' => $this->lang->line("master_area"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_area'
			),
			array(
				'field' => 'latitude', 
				'label' => $this->lang->line("master_latitude"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'longitude', 
				'label' => $this->lang->line("master_longitude"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			)
			
		);
		return $rules;
	}
	
	function state($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("state", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function region($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("region", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function area($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("area", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}

	public function index() {
		$this->data['countrylist'] = $this->airports_m->getDefns(2);
		
		if(!empty($this->input->post('countryID'))){
		  $this->data['countryID'] = $this->input->post('countryID');
		} else {
		  $this->data['countryID'] = 0;
		}
		if(!empty($this->input->post('stateID'))){		
        	$this->data['stateID'] = $this->input->post('stateID');
		} else {
		  $this->data['stateID'] = 0;
		}
		if(!empty($this->input->post('regionID'))){	
		   $this->data['regionID'] = $this->input->post('regionID');
		} else {
		  $this->data['regionID'] = 0;
		}
		if(!empty($this->input->post('areaID'))){	
	    	$this->data['areaID'] = $this->input->post('areaID');
		} else {
		    $this->data['areaID'] = 0;
		}
		
		//print_r( $this->data['stateID']); exit;
		$this->data["subview"] = "airline/index";
		$this->load->view('_layout_main', $this->data);
	}
	
	public function edit() {
        $this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/select2/select2.js'
			)
		);		
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['airline'] = $this->airline_m->getAirlineData($id);
			$this->data['countrylist'] = $this->airports_m->getDefns(2);
			//print_r($this->input->post('airport')); exit;
			if($this->data['airport']) {
				if($_POST) {	
                   $rules = $this->rules();
				   $this->form_validation->set_rules($rules);
				   if ($this->form_validation->run() == FALSE) { 
				   	$this->data["subview"] = "airline/edit";
				   	$this->load->view('_layout_main', $this->data);			
				   } else {				
						$data['countryID'] = $this->input->post('countryID');
						$data['stateID'] = $this->input->post('stateID');
						$data['regionID'] = $this->input->post('regionID');
						$data['areaID'] = $this->input->post('areaID');
						$data['lat'] = $this->input->post('latitude');
                        $data['lng'] = $this->input->post('longitude');
                        $data['active'] = $this->input->post('active');						
						$data['modify_date'] = time();					
						$data['modify_userID'] = $this->session->userdata('loginuserID'); 
						$this->airline_m->update_airline($data,$id); 						
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("airline/index"));	
                   }						
				} else {
					$this->data["subview"] = "airline/edit";
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
			$this->data['airline'] = $this->airline_m->get_single_airline(array('VX_aln_airlineID' => $id));
			if($this->data['airline']) {
				$this->airline_m->delete_airline($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("airline/index"));
			} else {
				redirect(base_url("airline/index"));
			}
		} else {
			redirect(base_url("airline/index"));
		}
	}
	
	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
			$this->data["airline"] = $this->airline_m->getAirlineData($id); 
			if($this->data["airline"]) {
				$this->data["subview"] = "airline/view";
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

	public function upload(){
	 if($_FILES){
		 if (empty($_FILES['file']['name'])) {
            $this->session->set_flashdata('error',"Please select File");			
			$this->data["subview"] = "airline/upload";
			$this->load->view('_layout_main', $this->data);
		 } else {
			require(APPPATH.'libraries/spreadsheet/php-excel-reader/Spreadsheet_Excel_Reader.php'); 
			require(APPPATH.'libraries/spreadsheet/SpreadsheetReader.php');	
          	
		try {	
		   $file = $_FILES['file']['tmp_name'];          
			   if(move_uploaded_file($file, APPPATH."/uploads/".$_FILES['file']['name'])){		
				$file =  APPPATH."/uploads/".$_FILES['file']['name']; 			   
				$Reader = new SpreadsheetReader($file); 
				$header = array('SNO','code','Airline Name','flightno');
				//print_r(count($header)); exit;
				$Sheets = $Reader -> Sheets();
				$defnData = $this->airports_m->getDefns();
					
			    foreach ($Sheets as $Index => $Name){                 					
				   $Reader -> ChangeSheet($Index);
				   $i = 0;
                 //$time_start = microtime(true); 					   
				  foreach ($Reader as $Row){
					if($i == 0){ // header checking						
					  $flag = 0 ;						 
					 if($Row == $header){
						 $flag = 1;
					 }				  
					} else {
					   if($flag == 1){ 						   						
					   	 if(count($Row) == 4){ //print_r($Row); exit;							
							 $airline['name'] = $Row[2];
							 $airline['code'] = $Row[1];
							 $airline['flights'] = $Row[3];							
                             $checkairline = $this->airline_m->checkAirline($airline);			 
							if($checkairline->id && $checkairline->existed == 0){
                              $data['airlineID'] = $checkairline->id;	
                              $data['flights'] = $airline['flights'];							  
							  $data['create_date'] = time();
							  $data['modify_date'] = time();
							  $data['create_userID'] = $this->session->userdata('loginuserID');
							  $data['modify_userID'] = $this->session->userdata('loginuserID'); 			
                              $this->airline_m->insert_airline($data);								   
							} else {
								//echo "Airport :".$airport." already  existed";								 
							}
					   	 } 						
					   } else {
						   print_r("mismatch");
					   }
					 }
				   $i++;					   
				  }
                  /* $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                
                   echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';
				  
                      exit;	 */			   
				} 
				
			  } 				 
			} catch (Exception $E)	{
				echo $E -> getMessage();
			}
		    if(file_exists($file)) {
		    	unlink($file);					
		    }			
			 $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		     redirect(base_url("airline/index")); 	
		 }	
	 } else {
			$this->data["subview"] = "airline/upload";
			$this->load->view('_layout_main', $this->data); 
      }
    }   

    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  
		
	    $aColumns = array('a.VX_aln_airlineID','dd.aln_data_value','dd.code','a.flights');
	
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
			if ( $_GET['sSearch'] != "" )
			{
				$sWhere = "WHERE (";
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
			
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS a.*,dd.aln_data_value name,dd.code from VX_aln_airline a LEFT JOIN vx_aln_data_defns dd ON dd.vx_aln_data_defnsID = a.airlineID	
		$sWhere			
		$sOrder
		$sLimit	"; 
	
	$rResult = $this->install_m->run_query($sQuery);
	$sQuery = "SELECT FOUND_ROWS() as total";
	$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
			
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $rResultFilterTotal,
		"iTotalDisplayRecords" => $rResultFilterTotal,
		"aaData" => array()
	  );
	  foreach($rResult as $airline){		 	
		  if(permissionChecker('airline_edit')){ 			
			$airline->action = btn_edit('airline/edit/'.$airline->VX_aln_airlineID, $this->lang->line('edit'));
		  }
		  if(permissionChecker('airline_delete')){
		   $airline->action .= btn_delete('airline/delete/'.$airline->VX_aln_airlineID, $this->lang->line('delete'));			 
		  }
		  if(permissionChecker('airline_view') ) {
		    $airline->action .= btn_view('airline/view/'.$airline->VX_aln_airlineID, $this->lang->line('view'));
		  }
			$status = $airline->active;
			$airline->active = "<div class='onoffswitch-small' id='".$airline->VX_aln_airlineID."'>";
            $airline->active .= "<input type='checkbox' id='myonoffswitch".$airline->VX_aln_airlineID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $airline->active .= " checked >";
			} else {
			   $airline->active .= ">";
			}	
			
			$airline->active .= "<label for='myonoffswitch".$airline->VX_aln_airlineID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";         
           
			$output['aaData'][] = $airline;				
		}
		echo json_encode( $output );
	}
	
    function active() {
		if(permissionChecker('airline_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['modify_date'] = time();
				if($status == 'chacked') {
					$data['active'] = 1 ;
					$this->airline_m->update_airline($data, $id);
					echo 'Success';
				} elseif($status == 'unchacked') {
					$data['active'] = 0 ;
					$this->airline_m->update_airline($data, $id);
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
	}

}

