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
        $this->data['icon'] = $this->menu_m->getMenu(array("link"=>"airports_master"))->icon; 		
	}	
	
	protected function rules() {
		$rules = array(
		   array(
				'field' => 'airline', 
				'label' => $this->lang->line("airline_name"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_name'
			),
			array(
				'field' => 'photo',
				'label' => $this->lang->line("airline_photo"),
				'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
			)
			/* array(
				'field' => 'aircraft', 
				'label' => $this->lang->line("airline_aircraft"), 
				'rules' => 'trim|required|xss_clean|max_length[150]'
			),
			array(
				'field' => 'seat_capacity', 
				'label' => $this->lang->line("airline_seat_capacity"), 
				'rules' => 'trim|required|xss_clean|max_length[50]|callback_valSeatCapacity'
			),
			array(
				'field' => 'code', 
				'label' => $this->lang->line("airline_code"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_code'
			) */	
			
		);
		return $rules;
	}
	
	public function photoupload() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$airline = array();
		if((int)$id) {
			$airline = $this->airline_m->getAirlineLogo($id);
		}
		$new_file = "defualt.png";
		$this->mydebug->debug($_FILES);
		if($_FILES["photo"]['name'] !="") {
			$file_name = $_FILES["photo"]['name'];
			$random = rand(1, 10000000000000000);
	    	$makeRandom = hash('sha512', $random.$this->input->post('airline') . config_item("encryption_key"));
			$file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
	            $new_file = $file_name_rename.'.'.end($explode);
				$config['upload_path'] = "./uploads/images";
				$config['allowed_types'] = "gif|jpg|png";
				$config['file_name'] = $new_file;
				$config['max_size'] = '1024';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload("photo")) {
					$this->form_validation->set_message("photoupload", $this->upload->display_errors());
	     			return FALSE;
				} else {
					$this->upload_data['file'] =  $this->upload->data();
					return TRUE;
				}
			} else {
				$this->form_validation->set_message("photoupload", "Invalid file");
	     		return FALSE;
			}
		} else {
			if(count($airline)) {
				$this->upload_data['file'] = array('file_name' => $airline->logo);
				return TRUE;
			} else {
				$this->upload_data['file'] = array('file_name' => $new_file);
			return TRUE;
			}
		}
	}
	
	function valSeatCapacity($post_string){
		if(empty($post_string)){
		$this->form_validation->set_message("valSeatCapacity", "%s is Required");
		return FALSE;	
	  } else {		
			  if(preg_match('/(\d+)-(\d+)/', $post_string) || preg_match('/^(\d+)$/', $post_string)){
				  return TRUE;
			  } else {
				$this->form_validation->set_message("valSeatCapacity", "%s Format Not Matched");
				  return FALSE;  
			 }
		  }
		   return TRUE;
	}
	
	protected function flightrules() {
		$rules = array(
		   array(
				'field' => 'airlineID', 
				'label' => $this->lang->line("airline_name"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valAirline'
			),			
			array(
				'field' => 'flights', 
				'label' => $this->lang->line("airline_flights"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valFlights'
			)		
		);
		return $rules;
	}
	
	function valAirline($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valAirline", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valFlights($post_string){
	  if(empty($post_string)){
		$this->form_validation->set_message("valFlights", "%s is Required");
		return FALSE;	
	  } else {
		  $flights_array = explode(',',$post_string); 
		   foreach($flights_array as $flights_data){  
			  if(preg_match('/([a-z]+)(\d+)-[a-z]+(\d+)/i', $flights_data) || preg_match('/(\d+)-(\d+)/', $flights_data) || preg_match('/^(\d+)/', $flights_data) || preg_match('/([a-z]+)(\d+)$/i', $flights_data) || preg_match('/([a-z]+)(\d+)([a-z])/i', $flights_data)){
				  
			  } else {
				$this->form_validation->set_message("valFlights", "%s Format Not Matched");
				return FALSE;  
			 }
		  }
		   return TRUE;
	  }	   
	}
	
	public function unique_name($post_string) {
      $id = htmlentities(escapeString($this->uri->segment(3)));
      if((int)$id) {
             $airline =  $this->airline_m->get_single_airline(array('vx_aln_data_defnsID !='=>$id,'aln_data_value'=>$post_string,'aln_data_typeID' => 12));
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
            $airline = $this->airline_m->getAirlineLogo($id);	
            if(!empty($airline)){
			  $this->data['airline']->video_links = $airline->video_links;	
			} else {
			  $this->data['airline']->video_links = '';	
			}			
			if($this->data['airline']) {
				if($_POST) {	//print_r($_FILES); exit;
                   $rules = $this->rules();
				   $this->form_validation->set_rules($rules);
				   if ($this->form_validation->run() == FALSE) { //echo validation_errors();
				   	$this->data["subview"] = "airline/edit";
				   	$this->load->view('_layout_main', $this->data);			
				   } else {	
                        /* $aircraftID = $this->airports_m->checkData($this->input->post('aircraft'),21); 
						if($aircraftID == $this->data['airline']->parentID && $this->data['airline']->seatID != null ){
							$this->airline_m->updateSeatCapacity($this->input->post('seat_capacity'),$this->data['airline']->seatID);
						} else {
     						$seat_capacityID = $this->airports_m->checkData($this->input->post('seat_capacity'),22,$aircraftID);
						} */						
						$data['aln_data_value'] = $this->input->post('airline');
						//$data['code'] = $this->input->post('code');
						//$data['parentID'] = $aircraftID;
						//$data['active'] = $this->input->post('active');                     						
						$data['modify_date'] = time();					
						$data['modify_userID'] = $this->session->userdata('loginuserID'); 
						$this->airline_m->update_airline($data,$id); 
                        $array['logo'] = $this->upload_data['file']['file_name'];
						$array['video_links'] = $this->input->post('video_links');
						$array['airlineID'] = $id;
						$this->airline_m->update_airlinelogo($array);
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
	
	public function addFlights(){
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/select2/select2.js'
			)
		);
		$this->data['id'] = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['airlinelist'] = $this->airline_m->getAirlinesData();
		if($_POST) {	
            $rules = $this->flightrules();
		    $this->form_validation->set_rules($rules);
		  if ($this->form_validation->run() == FALSE) { 
		  	$this->data["subview"] = "airline/add";
		  	$this->load->view('_layout_main', $this->data);			
		  } else {				
			 $flights_array = explode(',',$this->input->post('flights')); 
			 foreach($flights_array as $flights_data){  	
				$code =null;$from=null;$to=null; $flights = array();
				   if(preg_match('/([a-z]+)(\d+)-[a-z]+(\d+)/i', $flights_data, $matches)){//AS1011-AS1020
				   $code = $matches[1];
				   $from = $matches[2];
				   $to = $matches[3];						 								
				 }elseif(preg_match('/(\d+)-(\d+)/', $flights_data, $matches)) {//1011-1020		   
				   $from = $matches[1];
				   $to = $matches[2];
				   $code=null;						 
				 }elseif(preg_match('/^(\d+)/', $flights_data, $matches)) {//1011
				   $from = $matches[0];
				   $to = $matches[0];
				   $code=null; 
				 }elseif(preg_match('/([a-z]+)(\d+)$/i', $flights_data, $matches)) {	//AS1011  
					$code = $matches[1];							   
					$from = $matches[2];
					$to = $matches[2]; 	
				 }elseif(preg_match('/([a-z]+)(\d+)([a-z])/i', $flights_data, $matches)) { //AS1011A
					 $code = $matches[1];							   
					 $from = $matches[2];
					 $to = $matches[2]; $endcode = $matches[3];
				 } else {			
					$this->mydebug->airlines_log(" format not matched "); 
				 }
			
				if(($from && $to) && $from<=$to && (strlen((string)$from) < 5) && (strlen((string)$to) < 5)){
				 for($i=$from;$i<=$to;$i++){									
					   $flights[] = $i; 									
				 }
                }                          						
			    foreach($flights as $flight){           							  
			     $id = $this->airports_m->checkData($flight,16,$this->input->post('airlineID'));	 
			    }								
			  }					
			   $this->session->set_flashdata('success', $this->lang->line('menu_success'));
			   redirect(base_url("airline/index"));	
           }						
		 } else {
			$this->data["subview"] = "airline/add";
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
				$header = array_map('strtolower',array('s.no','airline name','Carrier Code','Aircraft Type','Seat Capacity','Flight Numbers'));
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
                           $aircraft_type_key = array_search ('aircraft type', $import_header);
                           $seat_capacity_key = array_search ('seat capacity', $import_header);
                           $flightno_key = array_search ('flight numbers', $import_header);						   
						  $airline['name'] = $Row[$airline_key];
						  $airline['code'] = $Row[$airline_code_key];						  
						 
						 //$airline['flights'] = $Row[3];                            
                            $val_status = $this->validateAirline($airline);                            
						  if($val_status){
                            $validate_code = $this->airline_m->get_single_airline(array('code'=>$Row[$airline_code_key]));							  
						  //if(count($validate_code) < 1){
                              $aircraftID = $this->airports_m->checkData($Row[$aircraft_type_key],21);
							  $seat_capacity = str_replace('-',' - ',$Row[$seat_capacity_key]);
							  $seat_capacityID = $this->airports_m->checkData($seat_capacity,22,$aircraftID);	   
                              //$checkairline = $this->airline_m->add_airline($airline);
							  $checkairline = $this->airline_m->checkAirline($airline);	
                               $airline_aircraftID = $this->airline_m->linkAirlineAircraft($checkairline->id,$aircraftID);							  
							 if($checkairline->id){
                                $this->airline_m->linkAirlineAircraft($checkairline->id,$aircraftID);						 
							  $flights_array = explode(',',$Row[$flightno_key]); 
							  foreach($flights_array as $flights_data){  	
							 $code =null;$from=null;$to=null; $flights = array();
							    if(preg_match('/([a-z]+)(\d+)-[a-z]+(\d+)/i', $flights_data, $matches)){//AS1011-AS1020
								   $code = $matches[1];
								   $from = $matches[2];
								   $to = $matches[3];						 								
								 }elseif(preg_match('/(\d+)-(\d+)/', $flights_data, $matches)) {//1011-1020		   
								   $from = $matches[1];
								   $to = $matches[2];
								   $code=null;						 
								 }elseif(preg_match('/^(\d+)/', $flights_data, $matches)) {//1011
								   $from = $matches[0];
								   $to = $matches[0];
								   $code=null; 
								 }elseif(preg_match('/([a-z]+)(\d+)$/i', $flights_data, $matches)) {	//AS1011  
									$code = $matches[1];							   
									$from = $matches[2];
									$to = $matches[2]; 	
								 }elseif(preg_match('/([a-z]+)(\d+)([a-z])/i', $flights_data, $matches)) { //AS1011A
									 $code = $matches[1];							   
									 $from = $matches[2];
									 $to = $matches[2]; $endcode = $matches[3];
								 } else {			
									$this->mydebug->airlines_log("Flight number".$Row[$flightno_key]." format not matched ".$airline['name'].'-'.$airline['code'] ); 
								 }
								// $this->mydebug->debug("from : " .$from ."length : ".strlen((string)$from));
								// $this->mydebug->debug("to : " .$to."length : ".strlen((string)$to));
								if(($from && $to) && $from<=$to && (strlen((string)$from) < 5) && (strlen((string)$to) < 5)){
								 for($i=$from;$i<=$to;$i++){									
									   $flights[] = $i; 									
								 }
                                }
                                // $this->mydebug->debug($flights);								
								  foreach($flights as $flight)
								  {	
                                    							  
								    $id = $this->airports_m->checkData($flight,16,$checkairline->id);	 
							      }
								
							   }								
							                               				  
							 } else {
								$this->mydebug->airlines_log("Airline :".$airline['name']." already  existed");								 
							} 
						 /*  }else{
							$this->mydebug->airlines_log("Airline Code must be UNIQUE ".$airline['name'].' - '.$airline['code']);
						  } */
						}  						 
					   } else {
						   $this->mydebug->airlines_log("file format no matched file name : ".$_FILES['file']['name']);
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
		  $this->mydebug->airlines_log("Airline Code should be alphanumeric and length 2 ".$data['name'].' - '.$data['code']);
		  return FALSE;
	  }else{
		  return TRUE;
	  }
	}
	
	function downloadFormat(){
		$this->load->helper('download');
        $filename = APPPATH.'downloads/airlines_with_aircraft_types.xlsx'; 
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
			  $sWhere .= 'd.vx_aln_data_defnsID IN ('.implode(',',$this->session->userdata('login_user_airlineID')).')';		
            } 		   
		  
		  $sGroup = " GROUP BY d.vx_aln_data_defnsID ";  
         $ss = "select d.*,GROUP_CONCAT(dd.aln_data_value SEPARATOR ', ') flights from vx_aln_data_defns d left join vx_aln_data_defns dd ON dd.parentID = d.vx_aln_data_defnsID where d.aln_data_typeID = 12 group by d.vx_aln_data_defnsID"  ;
		   
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS d.*,group_concat( distinct ac.aln_data_value,'/',sc.aln_data_value) as aircraft_seat_capacity,GROUP_CONCAT(dd.aln_data_value SEPARATOR ', ') flights from vx_aln_data_defns d left join vx_aln_data_defns dd ON dd.parentID = d.vx_aln_data_defnsID LEFT JOIN VX_airline_aircraft aa ON aa.airlineID = d.vx_aln_data_defnsID LEFT JOIN vx_aln_data_defns ac ON (ac.vx_aln_data_defnsID = aa.aircraftID AND ac.aln_data_typeID = 21) LEFT JOIN vx_aln_data_defns sc ON (sc.parentID = aa.aircraftID AND sc.aln_data_typeID = 22) 
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
	  $i=1;
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
		  if(permissionChecker('airline_edit')){ 	
		   $airline->action .= '<a href="'.base_url('airline/addFlights/'.$airline->vx_aln_data_defnsID).'" class="btn btn-warning btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Add Flights"><i class="fa fa-plus"></i></a>';
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
            $flights = $this->airline_m->getFlights($airline->vx_aln_data_defnsID);			
            $flights_data = implode(',',array_map(function ($object) { return $object->aln_data_value; }, $flights));
			$airline->flights = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$flights_data.'"><i class="fa fa-list"></i></a>';
			// $airline->flightss = $flights;
			$aircraft_seat_capacity = explode(',',$airline->aircraft_seat_capacity);
			$aircraft =array(); $seat_capacity = array();
			foreach($aircraft_seat_capacity as $asc){				
				$info = explode('/',$asc);
				$aircraft[] = $info[0];
                $seat_capacity[] = $info[1];				
			}
			//$airline->aircraft = implode('/',$airline->aircraft_seat_capacity);
			$airline->aircraft = implode(',',$aircraft);
			$airline->seat_capacity = implode(',',$seat_capacity);
			$airline->id = $i; $i++;
			$output['aaData'][] = $airline;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array('#','Airline Name','Code','Aircraft','Seat Capacity');
		  $rows = array('id','aln_data_value','code','aircraft','seat_capacity');
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
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
	
	function getAirline(){
		if($this->input->post('airlineID')){
			$json['data'] = $this->airline_m->getAirlineData($this->input->post('airlineID'));
		} else {
			$json['data'] = "Send ID";
		}
		$aircraft =array(); $seat_capacity = array();
		$aircraft_seat_capacity = explode(',',$json['data']->aircraft_seat_capacity);
		$this->mydebug->debug($aircraft_seat_capacity);
		 foreach($aircraft_seat_capacity as $asc){
            $this->mydebug->debug($asc);			 
		    $info = explode('/',$asc);
			$aircraft[] = $info[0];
            $seat_capacity[] = $info[1]; 
         }				
		$json['data']->aircraft = implode(',',$aircraft);
		$json['data']->seat_capacity = implode(',',$seat_capacity);
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json)); 
	}

}

