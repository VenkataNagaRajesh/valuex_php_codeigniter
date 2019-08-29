<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airports_master extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("airports_m");		
		$this->load->model("marketzone_m");
		$this->load->model("market_airport_map_m");
		$this->load->model("season_m");
		$this->load->model("season_airport_map_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('airports', $language);
        $this->data['icon'] = $this->menu_m->getMenu(array("link"=>"airports_master"))->icon;       	
    }	
	
	protected function rules() {
		$rules = array(
		   array(
				'field' => 'cityID', 
				'label' => $this->lang->line("master_state"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_city'
			),
			array(
				'field' => 'regionID', 
				'label' => $this->lang->line("master_region"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_region'
			),
			array(
				'field' => 'countryID', 
				'label' => $this->lang->line("master_country"), 
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_country'
			),
			/* array(
				'field' => 'latitude', 
				'label' => $this->lang->line("master_latitude"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'longitude', 
				'label' => $this->lang->line("master_longitude"), 
				'rules' => 'trim|required|xss_clean|max_length[60]'
			) */
			
		);
		return $rules;
	}
	
	function city($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("city", "%s is required");
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
	
	function country($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("country", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
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
		$this->data['areaslist'] = $this->airports_m->getDefns(5);
		if(!empty($this->input->post('countryID'))){
		  $this->data['countryID'] = $this->input->post('countryID');
		} else {
		  $this->data['countryID'] = 0;
		}
	   if(!empty($this->input->post('cityID'))){		
        	$this->data['cityID'] = $this->input->post('cityID');
		} else {
		  $this->data['cityID'] = 0;
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
		
		$this->data["subview"] = "airports_master/index";
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
			$this->data['airport'] = $this->airports_m->getAirportData($id);
			$this->data['areaslist'] = $this->airports_m->getDefns(5);
			//print_r($this->input->post('airport')); exit;
			if($this->data['airport']) {
				if($_POST) {	
                   $rules = $this->rules();
				   $this->form_validation->set_rules($rules);
				   if ($this->form_validation->run() == FALSE) { 
				   	$this->data["subview"] = "airports_master/edit";
				   	$this->load->view('_layout_main', $this->data);			
				   } else {				
						$data['countryID'] = $this->input->post('countryID');
						$data['cityID'] = $this->input->post('cityID');
						$data['regionID'] = $this->input->post('regionID');
						$data['areaID'] = $this->input->post('areaID');
						//$data['lat'] = $this->input->post('latitude');
                       // $data['lng'] = $this->input->post('longitude');
                        $data['active'] = $this->input->post('active');						
						$data['modify_date'] = time();					
						$data['modify_userID'] = $this->session->userdata('loginuserID'); 
						$this->airports_m->update_master_data($data,$id); 						
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("airports_master/index"));	
                   }						
				} else {
					$this->data["subview"] = "airports_master/edit";
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
			$this->data['airport'] = $this->airports_m->get_airportmaster($id);
			if($this->data['airport']) {
				$data['active'] = 0 ;
				$this->airports_m->update_master_data($data, $id);
				//$this->airports_m->delete_airport($id,$this->data['airport']->airportID);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("airports_master/index"));
			} else {
				redirect(base_url("airports_master/index"));
			}
		} else {
			redirect(base_url("airports_master/index"));
		}
	}
	
	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
			$this->data["airport"] = $this->airports_m->getAirportData($id);
			if($this->data["airport"]) {
				$this->data["subview"] = "airports_master/view";
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
			$this->data["subview"] = "airports_master/upload";
			$this->load->view('_layout_main', $this->data);
		 } else {
			require(APPPATH.'libraries/spreadsheet/php-excel-reader/Spreadsheet_Excel_Reader.php'); 
			require(APPPATH.'libraries/spreadsheet/SpreadsheetReader.php');	
          	
		try {	
		   $file = $_FILES['file']['tmp_name'];          
			   if(move_uploaded_file($file, APPPATH."/uploads/".$_FILES['file']['name'])){		
				$file =  APPPATH."/uploads/".$_FILES['file']['name']; 			   
				$Reader = new SpreadsheetReader($file); 
				$header = array_map('strtolower',array('S.No','Airport Name','Airport Code','City Name','City Code','Country Code','Country','Region','Area'));
				 $header = array_map('strtolower', $header);
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
                       $Row = array_map('trim', $Row);					  
                     $import_header = array_map('strtolower', $Row);
                    if(count(array_diff($header,$import_header)) == 0){
						 $flag = 1;
					 }				  
					} else {
					   if($flag == 1){  //exit; 						   						
					   		 $airport_key = array_search ('airport name', $import_header);	
                          	 $airportcode_key = array_search ('airport code', $import_header);
                             $city_key = array_search ('city name', $import_header);
                             $citycode_key = array_search ('city code', $import_header);
                             $countrycode_key = array_search ('country code', $import_header);
							 $country_key = array_search('country',$import_header);
							 $region_key = array_search ('region', $import_header);
							 $area_key = array_search('area',$import_header);				 						
							  $Row = array_map('trim', $Row);	
							 $airport = $Row[$airport_key];							
							 $country = $Row[$country_key];
							 $region = $Row[$region_key];	                              					 
							 $area = $Row[$area_key];
							 $city = $Row[$city_key];
							unset($validate);
							 $validate = array('airport'=> $airport,'airportcode' => $Row[$airportcode_key],'citycode' => $Row[$citycode_key],'countrycode' => $Row[$countrycode_key],'area' => $area,'region' => $region);					        								 
							  $res = $this->airports_m->checkAirport($airport);							 
						 if($res){
                            $val_status = $this->validateAirport($validate);                            
						  if($val_status){								
							  $countryID = 0;							
							  $regionID = 0;
							  $areaID = 0;
							  $cityID = 0;
							   foreach($defnData as $aln_data){ //Total Execution Time: 0.45060066779455 Mins
								 if($aln_data->aln_data_typeID == 2 && $aln_data->aln_data_value == $country){
								 	$countryID = $aln_data->vx_aln_data_defnsID;
								 }
								 if($aln_data->aln_data_typeID == 3 && $aln_data->aln_data_value == $city){
								 	$cityID = $aln_data->vx_aln_data_defnsID;
								 }
								 if($aln_data->aln_data_typeID == 4 && $aln_data->aln_data_value == $region){
								 	$regionID = $aln_data->vx_aln_data_defnsID;
								 }
								 if($aln_data->aln_data_typeID == 5 && $aln_data->aln_data_value == $area){	
								 	$areaID = $aln_data->vx_aln_data_defnsID;
								 }
							  } 
							  
							    if(!empty($areaID)){
							  	$data['areaID'] = $areaID;								
							  } else {
							  	$data['areaID'] =  $this->airports_m->checkData($area,5,null);
                                $aobj->vx_aln_data_defnsID = $data['areaID'];
                                $aobj->aln_data_typeID = 5;
                                $aobj->aln_data_value = $area;	
                                $defnData[] = $aobj;
								unset($aobj);
							  } 
            
			                   if(!empty($regionID)){
							  	$data['regionID'] = $regionID;
							  } else {
							  	$data['regionID'] =  $this->airports_m->checkData($region,4,$data['areaID']);
                                $robj->vx_aln_data_defnsID = $data['regionID'];
                                $robj->aln_data_typeID = 4;
                                $robj->aln_data_value = $region;	
                                 $defnData[] = $robj;	
                                 unset($robj);								 
							  }							  
							                           							  
							  if(!empty($countryID)){
							  	$data['countryID'] = $countryID;
							  } else {								 
							  	$data['countryID'] =  $this->airports_m->checkData($country,2,$data['regionID'] ,$Row[$countrycode_key]);
                                $cobj->vx_aln_data_defnsID = $data['countryID'];
                                $cobj->aln_data_typeID = 2;
                                $cobj->aln_data_value = $country;
                                $defnData[] = $cobj;
								unset($cobj);
							  }							  
							 

                              if(!empty($cityID)){
							  	$data['cityID'] = $cityID;
							  } else {
							  	$data['cityID'] =  $this->airports_m->checkData($city,3,$data['countryID'],$Row[$citycode_key]);
                                $ctobj->vx_aln_data_defnsID = $data['cityID'];
                                $ctobj->aln_data_typeID = 3;
                                $ctobj->aln_data_value = $city;	
                                $defnData[] = $ctobj;	
                                unset($ctobj);								
							  }	 							  
							 
						     $data['airportID'] = $this->airports_m->addAirport($airport, $data['cityID'],$Row[$airportcode_key]);
                             
							if ($data['airportID']) {
							    $parentSet  = $this->marketzone_m->getParentsofAirport($data['airportID']);
							    $marketzones = $this->marketzone_m->get_marketzones();
								foreach($marketzones as $marketzone) {

								    if(!is_null($marketzone->amz_level_name)) {
				                                        $levellist = explode(',',$marketzone->amz_level_name);
                                				    }else {
                                        					$levellist = [];
                                				    }
								  
                                                                    if(!is_null($marketzone->amz_incl_name)) {
                                                                        $incllist = explode(',',$marketzone->amz_incl_name);
                                                                    }else {
                                                                                $incllist = [];
                                                                    }

																										   if(!is_null($marketzone->amz_excl_name)) {
                                                                        $excllist = explode(',',$marketzone->amz_excl_name);
                                                                    }else {
                                                                                $excllist = [];
                                                                    }
		


								if ( !empty($levellist) || !empty($incllist)){ 

									if(!empty(array_intersect($parentSet,$levellist)) || 
										!empty(array_intersect($parentSet,$incllist))) {
										 $newentry['airport_id'] = $data['airportID'];
                                                                               $newentry['market_id'] = $marketzone->market_id;
                                                                            $this->market_airport_map_m->insert_marketairport_mapid($newentry);


								}
									}
								}
								
								//Updating seasons maping data
							    $seasons = $this->season_m->get_seasons();
								foreach($seasons as $season){
								   $origlist = explode(',',$season->ams_orig_level_value);
								   $distlist = explode(',',$season->ams_dest_level_value);
								   if(!empty($origlist)){
								     if(!empty(array_intersect($parentSet,$origlist))){
									   $oarray["seasonID"] = $season->VX_aln_seasonID;
									   $oarray["orig_airportID"] = $data['airportID']; 
									   $this->season_airport_map_m->insert_origseason_airport_mapid($oarray); 
								     }
								   }
								   
								   if(!empty($distlist)){
								     if(!empty(array_intersect($parentSet,$distlist))){
									    $darray["seasonID"] = $season->VX_aln_seasonID;
                                        $darray["dest_airportID"] = $data['airportID'];
                                        $this->season_airport_map_m->insert_destseason_airport_mapid($darray); 
								     }
								   }
								   
								}
								
							 }
								

                              $data['lat'] = $latitude;
                              $data['lng'] = $longitude;							  
							  $data['create_date'] = time();
							  $data['modify_date'] = time();
							  $data['create_userID'] = $this->session->userdata('loginuserID');
							  $data['modify_userID'] = $this->session->userdata('loginuserID'); 			
                              $this->airports_m->addMasterData($data);	
                       //Updating seasons maping data
					     
							 }				  
							} else {
								$this->mydebug->airports_log("Airport :".$airport." already  existed");		 
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
		     redirect(base_url("airports_master/index")); 	
		 }	
	 } else {
			$this->data["subview"] = "airports_master/upload";
			$this->load->view('_layout_main', $this->data); 
      }
    }

    function validateAirport($validate){
        $validateAirportCode = $this->airports_m->checkAirportCode($validate['airportcode']);		
		if(strlen($validate['airportcode']) != 3 || ctype_alpha($validate['airportcode']) != 1){
			$this->mydebug->airports_log("Airport Code must be alphabets and length 3 ".$validate['airport'].'-'.$validate['airportcode']);
			return FALSE;
		} else if($validateAirportCode != 0){
			$this->mydebug->airports_log("Airport Code must be UNIQUE ".$validate['airport'].'-'.$validate['airportcode']);
			return FALSE;
		} else if(strlen($validate['citycode']) != 3 || ctype_alpha($validate['citycode']) != 1){
			$this->mydebug->airports_log("City Code must be alphabets and length 3 ".$validate['airport'].'-'.$validate['citycode']);
			return FALSE;
		} else if(strlen($validate['countrycode']) != 2 || ctype_alpha($validate['countrycode']) != 1){
			$this->mydebug->airports_log("Countrycode Code must be alphabets and length 2 ".$validate['airport'].'-'.$validate['countrycode']);
			return FALSE;
		} else if(strlen($validate['area']) != 1 || !is_numeric($validate['area'])){
			$this->mydebug->airports_log("Area must be numeric and length 1 ".$validate['airport'].'-'.$validate['area']);
			return FALSE;
		} else if(strlen($validate['region']) > 99 || !ctype_alpha($validate['region'])){
			$this->mydebug->airports_log("region must be alphabets and length <= 99 ".$validate['airport'].'-'.$validate['region']);			
			return FALSE;
		} else {			
			return TRUE;
		} 
		
	}	

    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  
		
	    $aColumns = array('m.vx_amdID','ma.aln_data_value','mct.aln_data_value','mc.aln_data_value','mr.aln_data_value','mar.aln_data_value','ma.code','ma.active');
	
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
			if($this->input->get('areaID') > 0 ){
		      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'm.areaID = '.$this->input->get('areaID');		 
	        }
			if($this->input->get('regionID') > 0){
		      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'm.regionID = '.$this->input->get('regionID');		 
	        }
			if($this->input->get('countryID') > 0){
		      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'm.countryID = '.$this->input->get('countryID');		 
	        }
            if(isset($_GET['active']) && $this->input->get('active') != 2){ 
		      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'm.active = '.$this->input->get('active');		 
	        }			
			/* if($this->input->get('stateID') > 0){
		      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'm.stateID = '.$this->input->get('stateID');		 
	        } */			
			
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS m.vx_amdID,ma.aln_data_value airport,ma.code airportcode,mct.aln_data_value city,mct.code citycode,mc.aln_data_value country,mc.code countrycode,mr.aln_data_value region,mar.aln_data_value area,ma.code,m.active from vx_aln_master_data m left join vx_aln_data_defns ma ON ma.vx_aln_data_defnsID = m.airportID left join vx_aln_data_defns mct ON mct.vx_aln_data_defnsID = m.cityID left join vx_aln_data_defns mc ON mc.vx_aln_data_defnsID = m.countryID left join vx_aln_data_defns mr ON mr.vx_aln_data_defnsID = m.regionID left join vx_aln_data_defns mar ON mar.vx_aln_data_defnsID = m.areaID	
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
	  $i=1;

	$rownum = 1 + $_GET['iDisplayStart'];

	  foreach($rResult as $airport){		 	

		 $airport->chkbox = "<input type='checkbox'  class='deleteRow' value='".$airport->vx_amdID."'  /> ".$rownum ;
                                $rownum++;

		  if(permissionChecker('airports_master_edit')){ 			
			$airport->action = btn_edit('airports_master/edit/'.$airport->vx_amdID, $this->lang->line('edit'));
		  }
		  if(permissionChecker('airports_master_delete')){
		   $airport->action .= btn_delete('airports_master/delete/'.$airport->vx_amdID, $this->lang->line('delete'));			 
		  }
		  if(permissionChecker('airports_master_view') ) {
		    $airport->action .= btn_view('airports_master/view/'.$airport->vx_amdID, $this->lang->line('view'));
		  }
			$status = $airport->active;
			$airport->active = "<div class='onoffswitch-small' id='".$airport->vx_amdID."'>";
            $airport->active .= "<input type='checkbox' id='myonoffswitch".$airport->vx_amdID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $airport->active .= " checked >";
			} else {
			   $airport->active .= ">";
			}	
			
			$airport->active .= "<label for='myonoffswitch".$airport->vx_amdID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";         
            $airport->temp_id = $i;
			$output['aaData'][] = $airport;
            $i++;			
		}
		if(isset($_REQUEST['export'])){
		  $columns = array('#','Name','Code','City','City Code','Country','Country Code','Region','Area');
		  $rows = array("temp_id","airport","code","city","citycode","country","countrycode","region","area");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
	
    function active() {
		if(permissionChecker('airports_master_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['modify_date'] = time();
				if($status == 'chacked') {
					$data['active'] = 1 ;
					$this->airports_m->update_master_data($data, $id);
					echo 'Success';
				} elseif($status == 'unchacked') {
					$data['active'] = 0 ;
					$this->airports_m->update_master_data($data, $id);
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
	
	function downloadFormat(){
		$this->load->helper('download');
        $filename = APPPATH.'downloads/airport_master.xlsx'; 
		force_download($filename, null);		
	}

/*function testadd(){
$data['airportID']='499';

                                                           $parentSet  = $this->marketzone_m->getParentsofAirport($data['airportID']);

                                                            $marketzones = $this->marketzone_m->get_marketzones();
                                                                foreach($marketzones as $marketzone) {
								
                                                                    if(!is_null($marketzone->amz_level_name)) {
                                                                        $levellist = explode(',',$marketzone->amz_level_name);
                                                                    }else {
                                                                                $levellist = [];
                                                                    }

                                                                    if(!is_null($marketzone->amz_incl_name)) {
                                                                        $incllist = explode(',',$marketzone->amz_incl_name);
                                                                    }else {
                                                                                $incllist = [];
                                                                    }


                                                                    if(!is_null($marketzone->amz_excl_name)) {
                                                                        $excllist = explode(',',$marketzone->amz_excl_name);
                                                                    }else {
                                                                                $excllist = [];
                                                                    }

                                                                  if ( !empty($levellist) && !empty($incllist)){
                                                                  if(!empty(array_intersect($parentSet,$levellist))) {
                                                                        if(!empty(array_intersect($parentSet,$incllist))){
                                                                                if(empty(array_intersect($parentSet,$excllist))){
                                                                                          $newentry['airport_id'] = $data['airportID'];
                                                                                $newentry['market_id'] = $marketzone->market_id;
                                                                                $this->market_airport_map_m->insert_marketairport_mapid($newentry);
                                                                                }
                                                                        } else {
                                                                                if(empty(array_intersect($parentSet,$excllist))){
                                                                                    $newentry['airport_id'] = $data['airportID'];
                                                                                $newentry['market_id'] = $marketzone->market_id;
                                                                                $this->market_airport_map_m->insert_marketairport_mapid($newentry);

                                                                                }
                                                                        }
                                                                  }
                                                                 } else if (empty($incllist) && !empty($levellist) ) {
                                                                        if(!empty(array_intersect($parentSet,$levellist))){
                                                                                if(empty(array_intersect($parentSet,$excllist))){
                                                                                        $newentry['airport_id'] = $data['airportID'];
                                                                                $newentry['market_id'] = $marketzone->market_id;
                                                                                $this->market_airport_map_m->insert_marketairport_mapid($newentry);
                                                                                 }
                                                                         }
                                                                }
                                                                }



}*/
	
	

public function delete_master_bulk_records(){
$data_ids = $_REQUEST['data_ids'];
$data_id_array = explode(",", $data_ids);
if(!empty($data_id_array)) {
    foreach($data_id_array as $id) {
	 $this->data['airport'] = $this->airports_m->get_airportmaster($id);
                        if($this->data['airport']) {
                                $data['active'] = 0 ;
                                $this->airports_m->update_master_data($data, $id);
                        }
    }
}
}

   
}

