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
				'field' => 'airline', 
				'label' => $this->lang->line("airline_name"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_name'
			),
			array(
				'field' => 'code', 
				'label' => $this->lang->line("airline_code"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_code'
			)	
			
		);
		return $rules;
	}
	
	public function unique_name($post_string) {
      $id = htmlentities(escapeString($this->uri->segment(3)));
      if((int)$id) {
             $airline =  $this->airline_m->get_single_airline(array('vx_aln_data_defnsID !='=>$id,'aln_data_value'=>$post_string));
              if(count($airline)) {
                      $this->form_validation->set_message("unique_name", "%s already exists");
                      return FALSE;
              }
              return TRUE;
      } else {
              $airline =  $this->airline_m->get_single_airline(array('aln_data_value'=>$post_string,'aln_data_typeID' => 12));
            
              if(count($airline)) {
                      $this->form_validation->set_message("unique_name", "%s already exists");
                      return FALSE;
              }
              return TRUE;
      }
    }
	
	public function unique_code($post_string) {
      $id = htmlentities(escapeString($this->uri->segment(3)));
      if((int)$id) {
             $airline =  $this->airline_m->get_single_airline(array('vx_aln_data_defnsID !='=>$id,'code'=>$post_string));
              if(count($airline)) {
                      $this->form_validation->set_message("unique_code", "%s already exists");
                      return FALSE;
              }
              return TRUE;
      } else {
              $airline =  $this->airline_m->get_single_airline(array('code'=>$post_string,'aln_data_typeID' => 12));            
              if(count($airline)) {
                      $this->form_validation->set_message("unique_code", "%s already exists");
                      return FALSE;
              }
              return TRUE;
      }
    }
	
	public function index() {
		
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
			if($this->data['airline']) {
				if($_POST) {	
                   $rules = $this->rules();
				   $this->form_validation->set_rules($rules);
				   if ($this->form_validation->run() == FALSE) { 
				   	$this->data["subview"] = "airline/edit";
				   	$this->load->view('_layout_main', $this->data);			
				   } else {				
						$data['aln_data_value'] = $this->input->post('airline');
						$data['code'] = $this->input->post('code');
						//$data['active'] = $this->input->post('active');						
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
			$this->data['airline'] = $this->airline_m->get_single_airline(array('vx_aln_data_defnsID' => $id));
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
			//print_r($this->data["airline"]); exit;
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
				//$header = array('SNO','code','Airline Name','flightno');
				//print_r(count($header)); exit;
				$header = array_map('strtolower',array('S.No','AIRLINE NAME','Carrier Code'));
				 $header = array_map('trim', $header);
				$Sheets = $Reader -> Sheets();
				$defnData = $this->airports_m->getDefns();
					
			    foreach ($Sheets as $Index => $Name){                 					
				   $Reader -> ChangeSheet($Index);
				   $i = 0;
                 //$time_start = microtime(true); 					   
				  foreach ($Reader as $Row){
					if($i == 0){ // header checking						
					  $flag = 0 ;	
                      $Row = array_map('trim', $Row);					  
                     $import_header = array_map('strtolower', $Row);
                     if(count(array_diff($header,$import_header)) == 0){
						 $flag = 1;
					 }			  
					} else {
					   if($flag == 1){
                           $airline_key = array_search ('airline name', $import_header);	
                           $airline_code_key = array_search ('carrier code', $import_header);						   
						  $airline['name'] = $Row[$airline_key];
						  $airline['code'] = $Row[$airline_code_key];
						 //$airline['flights'] = $Row[3];                            
                           $val_status = $this->validateAirline($airline);                            
						  if($val_status){
                            $validate_code = $this->airline_m->get_single_airline(array('code'=>$Row[$airline_code_key]));							  
						   if(count($validate_code) < 1){								 
                              $checkairline = $this->airline_m->add_airline($airline);					 
							/* if($checkairline->id){
							  $flights = explode(',',$Row[3]);
							  $airline['flights']= array();							  
							  foreach($flights as $flight){
								 $id = $this->airports_m->checkData($flight,16,$checkairline->id);	 
							  }                              				  
							} else {
								//echo "Airport :".$airport." already  existed";								 
							} */
						  }else{
							$this->mydebug->airlines_log("Airline Code must be UNIQUE ".$airline['name'].'-'.$airline['code']);
						  }
						} 						 
					   } else {
						   print_r("mismatch");
					   }
					 }
				   $i++;					   
				  } //exit;
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

    public function validateAirline($data){
	  if(!ctype_alnum($data['code']) || strlen($data['code']) != 2 ){
		  $this->mydebug->airlines_log("Airline Code should be alphanumeric and length 2 ".$data['name'].'-'.$data['code']);
		  return FALSE;
	  }else{
		  return TRUE;
	  }
	}
	
	function downloadFormat(){
		$this->load->helper('download');
        $filename = APPPATH.'downloads/airline_format.xlsx'; 
		force_download($filename, null);		
	}
	
	function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  
		
	   // $aColumns = array('d.vx_aln_data_defnsID','d.aln_data_value','d.code','GROUP_CONCAT(dd.aln_data_value SEPARATOR ", ")');
	     $aColumns = array('d.vx_aln_data_defnsID','d.aln_data_value','d.code');
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
			$sWhere = " WHERE d.aln_data_typeID = 12 ";
			
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

            $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
           $sWhere .= ' d.aln_data_typeID = 12 ';

           if($this->session->userdata('usertypeID') == 2){  
                  $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                  $sWhere .= 'd.vx_aln_data_defnsID = '.$this->session->userdata('login_user_airlineID');		
            } 		   
		  
		  $sGroup = " GROUP BY vx_aln_data_defnsID ";  
         $ss = "select d.*,GROUP_CONCAT(dd.aln_data_value SEPARATOR ', ') flights from vx_aln_data_defns d left join vx_aln_data_defns dd ON dd.parentID = d.vx_aln_data_defnsID where d.aln_data_typeID = 12 group by d.vx_aln_data_defnsID"  ;
		   
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS d.* from vx_aln_data_defns d left join vx_aln_data_defns dd ON dd.parentID = d.vx_aln_data_defnsID	
		$sWhere
        $sGroup		
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
	  foreach($rResult as $airline){		 	
		  if(permissionChecker('airline_edit')){ 			
			$airline->action = btn_edit('airline/edit/'.$airline->vx_aln_data_defnsID, $this->lang->line('edit'));
		  }
		  if(permissionChecker('airline_delete')){
		   $airline->action .= btn_delete('airline/delete/'.$airline->vx_aln_data_defnsID, $this->lang->line('delete'));			 
		  }
		  if(permissionChecker('airline_view') ) {
		    $airline->action .= btn_view('airline/view/'.$airline->vx_aln_data_defnsID, $this->lang->line('view'));
		  }
		    
			$status = $airline->active;
			$airline->active = "<div class='onoffswitch-small' id='".$airline->vx_aln_data_defnsID."'>";
            $airline->active .= "<input type='checkbox' id='myonoffswitch".$airline->vx_aln_data_defnsID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $airline->active .= " checked >";
			} else {
			   $airline->active .= ">";
			}	
			
			$airline->active .= "<label for='myonoffswitch".$airline->vx_aln_data_defnsID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";  
           
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

