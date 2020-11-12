<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paxfeed extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("paxfeed_m");
		$this->load->model('paxfeedraw_m');
		$this->load->model('rafeed_m');
		$this->load->model('airports_m');
		$this->load->model('airline_m');
		$this->load->model("airline_cabin_m");
		$this->load->model('airline_cabin_class_m');
        $this->load->model('user_m');
        $this->load->model('preference_m');
		$this->load->model('season_m');
		$this->load->model('fclr_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('paxfeed', $language);
        $this->data['icon'] = $this->menu_m->getMenu(array("link"=>"airline_cabin"))->icon;		
	}	
	
	
	public function index() {



		$this->paxfeed_m->process_tiermarkup(array("US0401"));
		$pf_id = htmlentities(escapeString($this->uri->segment(3)));
		 $this->data['headerassets'] = array(
                        'css' => array(
                                'assets/select2/css/select2.css',
                                'assets/select2/css/select2-bootstrap.css',
				'assets/datepicker/datepicker.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js',
				'assets/datepicker/datepicker.js'
                        )
                );


		 if($pf_id > 0){
                  $this->data['pf_id'] = $pf_id;
                }
	
		  if(!empty($this->input->post('booking_country'))){
                  $this->data['booking_country'] = $this->input->post('booking_country');
                } else {
                  $this->data['booking_country'] = 0;
                }
                if(!empty($this->input->post('booking_city'))){
                $this->data['booking_city'] = $this->input->post('booking_city');
                } else {
                  $this->data['booking_city'] = 0;
                }
                if(!empty($this->input->post('from_city'))){
                   $this->data['from_city'] = $this->input->post('from_city');
                } else {
                  $this->data['from_city'] = 0;
                }
                if(!empty($this->input->post('to_city'))){
                $this->data['to_city'] = $this->input->post('to_city');
                } else {
                    $this->data['to_city'] = 0;
                }


		if(!empty($this->input->post('carrier_code'))){
                $this->data['carrier_code'] = $this->input->post('carrier_code');
                } else {
                    if($this->session->userdata('roleID') != 1){
					 $this->data['carrier_code'] = $this->session->userdata('default_airline');
				   } else {					
                     $this->data['carrier_code'] = 0;
				   }
                }


		$userID = $this->session->userdata('loginuserID');
                $roleID = $this->session->userdata('roleID');
                if($roleID != 1){
						 $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
						   }  else {
                   $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }

                $this->data['city'] = $this->airports_m->getDefnsCodesListByType('3');
                //$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
		$this->data['country'] = $this->airports_m->getDefnsCodesListByType('2');
		$this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1');
                $this->data['cabins'] =  $this->airports_m->getDefnsCodesListByType('13');
		$this->data['pax_type'] =  $this->airports_m->getDefnsCodesListByType('18');

		$this->data["subview"] = "paxfeed/index";
		$this->load->view('_layout_main', $this->data);
	}
	

        public function delete() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
                if((int)$id) {
                        $this->data['paxfeed'] = $this->paxfeed_m->get_single_paxfeed(array('dtpf_id'=>$id));
                        if($this->data['paxfeed']) {
                                $this->paxfeed_m->delete_paxfeed($id);
				$this->paxfeedraw_m->delete_paxfeedraw($this->data['paxfeed']->dtpfraw_id);
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("paxfeed/index"));
                        } else {
                                redirect(base_url("paxfeed/index"));
                        }
                } else {
                        redirect(base_url("paxfeed/index"));
                }
        }	

	public function upload(){
	
	$pax_insert_list = array();
	 if($_FILES){
		 if (empty($_FILES['file']['name'])) {
            $this->session->set_flashdata('error',"Please select File");			
			$this->data["subview"] = "paxfeed/upload";
			$this->load->view('_layout_main', $this->data);
		 } else {
			require(APPPATH.'libraries/spreadsheet/php-excel-reader/Spreadsheet_Excel_Reader.php'); 
			require(APPPATH.'libraries/spreadsheet/SpreadsheetReader.php');	
          	
		try {	
		   $file = $_FILES['file']['tmp_name'];          
			   if(move_uploaded_file($file, APPPATH."/uploads/".$_FILES['file']['name'])){		

				$file =  APPPATH."/uploads/".$_FILES['file']['name']; 			   
				$Reader = new SpreadsheetReader($file); 



	$header = array_map("strtolower", array("Airline Code","PNR ref","Pax nbr","first name","last name","ptc","FQTV","seg nbr","carrier code","flight nbr","dept date","arrival date","dept time", "arrival time","class","board point","off point","PAX contact email","Phone","Booking country","booking city","office-id","channel","tier markup","Operating Carrier","Marketing Carrier"));	
		$header = array_map('strtolower', $header);
		

				$Sheets = $Reader -> Sheets();
                        //      print_r(count($header)); exit;
								$Sheets = $Reader -> Sheets();
								
                        //      $defnData = $this->airports_m->getDefns();

		$this->mydebug->paxfeed_log("Processing the excel file " . $_FILES['file']['name'] , 0);
          foreach ($Sheets as $Index => $Name){
			  $Reader -> ChangeSheet($Index);
              $i = 0;
               //$time_start = microtime(true);
		$column = 0;                   
             foreach ($Reader as $Row){
		 	
			$column++;
		$Row = array_map('trim', $Row);
                 if($i == 0){ // header checking                                         

                  	$flag = 0 ;
		       // $Row = array_map('trim', $Row);
					$import_header = array_map('strtolower', $Row);
					

                        if(count(array_diff($header,$import_header)) == 0){
                             $flag = 1;
				$this->mydebug->paxfeed_log("Header Matched for file  " . $_FILES['file']['name'] , 0);
					
                         } else {
				$this->mydebug->paxfeed_log("Header mismatch" , 1);
				 $this->session->set_flashdata('error', "Header mismatch, upload failed");
				 redirect(base_url("paxfeed/index")); 	
					break;
			 }
                        } else {
							 if($flag == 1){                                                                                      
					if(count($Row) == 26){ //print_r($Row); exit;	
											
				    $this->mydebug->paxfeed_log("Columns count Matched for row " . $column , 0);
					$paxfeedraw = array();
					
						 $paxfeedraw['airline_code'] =  $Row[array_search('airline code',$import_header)];
						
					if (!is_numeric($paxfeedraw['airline_code']) || strlen($paxfeedraw['airline_code']) != '3' ) {
						$this->mydebug->paxfeed_log("Airline code should be 3 digits in row " . $column , 1);
						continue;
					}

					 $paxfeedraw['pnr_ref'] = $Row[array_search('pnr ref',$import_header)];
					 if ( strlen($paxfeedraw['pnr_ref']) != '6' ) {
                                                $this->mydebug->paxfeed_log("PNR ref should be of length 6 in row " . $column , 1);
                                                continue;
										}
										

									  $paxfeedraw['pax_nbr'] = $Row[array_search('pax nbr',$import_header)];
									  

					if ( strlen($paxfeedraw['pax_nbr']) >= 3 || !is_numeric($paxfeedraw['pax_nbr'])) {
                                                $this->mydebug->paxfeed_log("Pax nbr should be of length 2 in row " . $column , 1);
                                                continue;
										}
				
										

                                      $paxfeedraw['first_name'] = trim($Row[array_search('first name',$import_header)]);

                                       if ( strlen($paxfeedraw['first_name']) >= 99 )  {
                                              $this->mydebug->paxfeed_log("First name should be of length 99 characters in row " . $column , 1);
                                                continue;
                                        }

                                      $paxfeedraw['last_name'] = trim($Row[array_search('last name',$import_header)]);

					if ( strlen($paxfeedraw['last_name']) >= 99  ) {
                                              $this->mydebug->paxfeed_log("Last name should be of length 99 characters in row " . $column , 1);
                                                continue;
                                        }
										
					$paxfeedraw['operating_carrier'] = trim($Row[array_search('operating carrier',$import_header)]);
					
					if ( strlen($paxfeedraw['operating_carrier']) != 2){
						
						
						$this->mydebug->paxfeed_log("Operating Carrier Code should be 2 alphabets in row " . $column , 1);
						continue;
						  
				  }
				  		
				  

					$paxfeedraw['marketing_carrier'] = trim($Row[array_search('marketing carrier',$import_header)]);
					if ( strlen($paxfeedraw['marketing_carrier']) != 2){
						
						
						$this->mydebug->paxfeed_log("Marketing Carrier Code should be 2 alphabets in row " . $column , 1);
						continue;  
				  }

				 


                    $paxfeedraw['ptc'] = $Row[array_search('ptc',$import_header)];

					 if ( strlen($paxfeedraw['ptc']) >= 4 || !ctype_alpha($paxfeedraw['ptc'])) {
                                              $this->mydebug->paxfeed_log("PTC should be 3 characters in row " . $column , 1);
                                                continue;
                                        }

                                     $paxfeedraw['fqtv'] = $Row[array_search('fqtv',$import_header)];
					if ( strlen($paxfeedraw['fqtv']) >= 13 || !is_numeric($paxfeedraw['fqtv'])) {
                                              $this->mydebug->paxfeed_log("FQTV should be  less than".$paxfeedraw['fqtv']. "  12 digits in row " . $column , 1);
                                                continue;
                                        }

					
                                      $paxfeedraw['seg_nbr'] =  $Row[array_search('seg nbr',$import_header)];

					if ( strlen($paxfeedraw['seg_nbr']) >= 3 || !is_numeric($paxfeedraw['seg_nbr'])) {
						
											  $this->mydebug->paxfeed_log("SEG nbr should be lessthan or equal 2 digits in row " . $column , 1);
											 
											  continue;	
												
										}
					
										

                                      $paxfeedraw['carrier_code'] =  $Row[array_search('carrier code',$import_header)];

					if ( strlen($paxfeedraw['carrier_code']) != 2){
                                              $this->mydebug->paxfeed_log("Carrier code should be 2 alphabets in row " . $column , 1);
                                                continue;
                                        }

                                      $paxfeedraw['flight_number'] = $Row[array_search('flight nbr',$import_header)];
	
					 if ( strlen($paxfeedraw['flight_number']) != 6 ) {
                                              $this->mydebug->paxfeed_log("Flight number should be  6 alplanumeric " . $column , 1);
                                                continue;
                                        }

                                      $paxfeedraw['dep_date'] = $Row[array_search('dept date',$import_header)];
					$paxfeedraw['arrival_date'] = $Row[array_search('arrival date',$import_header)];
				      $paxfeedraw['dept_time'] = $Row[array_search('dept time',$import_header)];
				      $paxfeedraw['arrival_time'] = $Row[array_search('arrival time',$import_header)];
			
					$class_arr = range('A','Z');
                                      $paxfeedraw['class'] = $Row[array_search('class',$import_header)];

					if( strlen($paxfeedraw['class']) != 1 || !in_array($paxfeedraw['class'],$class_arr)){
						$this->mydebug->paxfeed_log("Class should be in A-Z in row " . $column , 1);
                                                continue;

					}


					 $cabin_new_entry = $this->airline_cabin_class_m->validateCabinMapData($paxfeedraw['carrier_code'],$paxfeedraw['class']);

					if(count($cabin_new_entry) != 1) {
						$this->mydebug->paxfeed_log("Cabin - class mapping data not proper in row " . $column , 1);
                                                continue;
					}
                                      $paxfeedraw['from_city'] = $Row[array_search('board point',$import_header)];
					if( strlen($paxfeedraw['from_city']) != 3 || !ctype_alpha($paxfeedraw['from_city'])){
                                                $this->mydebug->paxfeed_log("Board Point should be 3 letter code in row " . $column , 1);
                                                continue;

                                        }

                                      $paxfeedraw['to_city'] = $Row[array_search('off point',$import_header)];

					 if( strlen($paxfeedraw['to_city']) != 3 || !ctype_alpha($paxfeedraw['to_city'])){
                                                $this->mydebug->paxfeed_log("Off Point should be 3 letter code in row " . $column , 1);
                                                continue;

                                        }
                                      $paxfeedraw['phone'] = $Row[array_search('phone',$import_header)];
                                      if( strlen($paxfeedraw['phone']) >= 13 || !is_numeric($paxfeedraw['phone'])){
                                                $this->mydebug->paxfeed_log("Phone num should not be more than 12 digits in row " . $column , 1);
                                                continue;

                                        }

                                      $paxfeedraw['pax_contact_email'] = $Row[array_search('pax contact email',$import_header)];
                                      $paxfeedraw['booking_country'] =  $Row[array_search('booking country',$import_header)];

					if( strlen($paxfeedraw['booking_country']) != 2 || !ctype_alpha($paxfeedraw['booking_country'])){
                                                $this->mydebug->paxfeed_log("Booking country shoud be 2 Alpha code in row " . $column , 1);
                                                continue;

                                        }

                                      $paxfeedraw['booking_city'] = $Row[array_search('booking city',$import_header)];


					if( strlen($paxfeedraw['booking_city']) != 3 || !ctype_alpha($paxfeedraw['booking_city'])){
                                                $this->mydebug->paxfeed_log("Booking city shoud be 3 Alpha code in row " . $column , 1);
                                                continue;

                                        }


                                      $paxfeedraw['office_id'] = $Row[array_search('office-id',$import_header)];
					if( strlen($paxfeedraw['office_id']) >= 9 ){
                                                $this->mydebug->paxfeed_log("Office ID should not be more than 9   " . $column , 1);
                                                continue;

                                        }

					
                                      $paxfeedraw['channel'] = $Row[array_search('channel',$import_header)];

					 if( strlen($paxfeedraw['channel']) > 99 || !ctype_alpha($paxfeedraw['channel'])){
                                                $this->mydebug->paxfeed_log("Channel should not be more than 99 characters in row " . $column , 1);
                                                continue;

                                        }

					
					$paxfeedraw['tier_markup'] = $Row[array_search('tier markup',$import_header)];

					if( !is_numeric($paxfeedraw['tier_markup']) || $paxfeedraw['tier_markup'] >= 5){
                                                $this->mydebug->paxfeed_log("Tier markup should be 1-4 in row " . $column , 1);
                                                continue;

										}
					

					$exist_pax_raw = $this->paxfeedraw_m->checkPaxFeedRaw($paxfeedraw);
				      if(!$exist_pax_raw) {

		                       $pnr_exist = $this->paxfeedraw_m->get_single_paxfeedraw(array('pnr_ref' => $paxfeedraw['pnr_ref'],'flight_number'=>$paxfeedraw['flight_number']));
                                        if(count($pnr_exist) > 0){
                                        $cabin_new_entry = $this->airline_cabin_class_m->validateCabinMapData($paxfeedraw['carrier_code'],$paxfeedraw['class']);
					$cabin_old_entry = $this->airline_cabin_class_m->validateCabinMapData($pnr_exist->carrier_code,$pnr_exist->class);
					$is_uniq_pnr_carrier_flight_psgr_num = $this->paxfeedraw_m->get_single_paxfeedraw(array('pnr_ref' => $paxfeedraw['pnr_ref'],'flight_number'=>$paxfeedraw['flight_number'],'carrier_code' => $paxfeedraw['carrier_code'],'pax_nbr' => $paxfeedraw['pax_nbr']));
					if(count($is_uniq_pnr_carrier_flight_psgr_num) > 0 ){
						$this->mydebug->paxfeed_log("Multi Pax entry, entry should be unique per pnr,carrier, flight_number, passenger number for row  " . $column , 1);
                                                continue;

					}
					
                                          if($paxfeedraw['from_city'] != $pnr_exist->from_city){
						$this->mydebug->paxfeed_log("Multi Pax entry,  invalid board point for row " . $column , 1);
						continue;
					}

					if($paxfeedraw['to_city'] != $pnr_exist->to_city) {

					 $this->mydebug->paxfeed_log("Multi Pax entry,  invalid off point for row " . $column , 1);
                                                continue;
					}

					if($paxfeedraw['dep_date'] != $pnr_exist->dep_date) {

					 $this->mydebug->paxfeed_log("Multi Pax entry,  invalid departure date for row " . $column , 1);
                                                continue;

					}
				
					if( $paxfeedraw['arrival_date'] != $pnr_exist->arrival_date ){
					$this->mydebug->paxfeed_log("Multi Pax entry,  invalid arrival date for row " . $column , 1);
                                                continue;
					}

	
					if($paxfeedraw['arrival_time'] != $pnr_exist->arrival_time) {
						 $this->mydebug->paxfeed_log("Multi Pax entry,  invalid arrival time for row " . $column , 1);
                                                continue;
					}


					if($paxfeedraw['dept_time'] != $pnr_exist->dept_time) {
						$this->mydebug->paxfeed_log("Multi Pax entry,  invalid departure time for row " . $column , 1);
                                                continue;
	
					}	

					if( $paxfeedraw['carrier_code'] != $pnr_exist->carrier_code) {

						$this->mydebug->paxfeed_log("Multi Pax entry,  invalid carrier code for row " . $column , 1);
                                                continue;
					}

					if( $paxfeedraw['operating_carrier'] != $pnr_exist->operating_carrier) {

						$this->mydebug->paxfeed_log("Multi Pax entry,  invalid carrier code for row " . $column , 1);
                                                continue;
					}

					if( $paxfeedraw['marketing_carrier'] != $pnr_exist->marketing_carrier) {

						$this->mydebug->paxfeed_log("Multi Pax entry,  invalid carrier code for row " . $column , 1);
                                                continue;
					}

					if($cabin_new_entry->cabin_id !=  $cabin_old_entry->cabin_id){
                                                $this->mydebug->paxfeed_log("Multi Pax entry,  Invalid cabin for row " . $column , 1);
                                                continue;
                                        }

					
                                        if( $paxfeedraw['class'] != $pnr_exist->class) {

                                                $this->mydebug->paxfeed_log("Multi Pax entry,  invalid class for row " . $column , 1);
                                                continue;
                                        }

                                        }

					
                                          $paxfeedraw['create_date'] = time();
                                          $paxfeedraw['modify_date'] = time();
                                          $paxfeedraw['create_userID'] = $this->session->userdata('loginuserID');
                                          $paxfeedraw['modify_userID'] = $this->session->userdata('loginuserID');
                                          $raw_pax_id = $this->paxfeedraw_m->insert_paxfeedraw($paxfeedraw);
						if($raw_pax_id){
							$this->mydebug->paxfeed_log("Raw feed id is inserted for row " . $column , 0);
						}
					} else {

						// check pax raw in pf table
							 $this->mydebug->paxfeed_log("Raw fields already exist for row " . $column , 0);

						$exist_data = $this->paxfeed_m->get_single_paxfeed(array('dtpfraw_id' => $exist_pax_raw));
						if (count($exist_data) >= 1) {
							$this->mydebug->paxfeed_log("Pax feed entry already exist for row " . $column , 0);
							continue;
						} else {
							$raw_pax_id = $exist_pax_raw;
						}
					}
						
			             if ( $raw_pax_id ) {
	
					$paxfeed = array();
	 				$paxfeed['airline_code'] = $paxfeedraw['airline_code'];
                                        $paxfeed['pnr_ref'] = $paxfeedraw['pnr_ref'];
                                        $paxfeed['pax_nbr'] = $paxfeedraw['pax_nbr'];
										$paxfeed['first_name'] = $paxfeedraw['first_name'];
										$paxfeed['operating_carrier'] = $paxfeedraw['operating_carrier'];
										$paxfeed['marketing_carrier'] = $paxfeedraw['marketing_carrier'];
					$paxfeed['last_name'] = $paxfeedraw['last_name'];
                                        $paxfeed['ptc'] = $this->airports_m->getDefIdByTypeAndCode($paxfeedraw['ptc'],'18');;
                                        $paxfeed['fqtv'] = $paxfeedraw['fqtv'];
                                        $paxfeed['seg_nbr'] = $paxfeedraw['seg_nbr'];
				        $paxfeed['carrier_code'] =  $this->airports_m->getDefIdByTypeAndCode($paxfeedraw['carrier_code'],'12');
                                        $paxfeed['flight_number'] =  substr($paxfeedraw['flight_number'], 2);
                                        $paxfeed['dep_date'] = strtotime(str_replace('-','/',$paxfeedraw['dep_date']));
					$day_of_week = date('w', $paxfeed['dep_date']);
                                        $day = ($day_of_week)?$day_of_week:7;
					$paxfeed['frequency']  = $this->airports_m->getDefIdByTypeAndCode($day,'14');

					 $paxfeed['arrival_date'] = strtotime(str_replace('-','/',$paxfeedraw['arrival_date']));
					$paxfeed['dept_time'] = $this->convertTimeToSeconds($paxfeedraw['dept_time']);
					 $paxfeed['arrival_time'] = $this->convertTimeToSeconds($paxfeedraw['arrival_time']);
                                        $paxfeed['class'] = $paxfeedraw['class'];
		  		         $cabin = $this->airline_cabin_class_m->getCabinFromClassForCarrier($paxfeed['carrier_code'],$paxfeed['class']);
					 $paxfeed['cabin'] = $cabin->cabin_id;
                                         $paxfeed['from_city'] = $this->airports_m->getDefIdByTypeAndCode($paxfeedraw['from_city'],'1');
                                         $paxfeed['to_city'] = $this->airports_m->getDefIdByTypeAndCode($paxfeedraw['to_city'],'1');
					 $paxfeed['phone'] = $paxfeedraw['phone'];
                                         $paxfeed['pax_contact_email'] = $paxfeedraw['pax_contact_email'];
                                         $paxfeed['booking_country'] =  $this->airports_m->getDefIdByTypeAndCode($paxfeedraw['booking_country'],'2');
					 $paxfeed['booking_city'] = $this->airports_m->getDefIdByTypeAndCode($paxfeedraw['booking_city'],'3');
                                         $paxfeed['office_id'] = $paxfeedraw['office_id'];
                                         $paxfeed['channel'] = $paxfeedraw['channel'];
				if ( $paxfeedraw["tier_markup"] ) {
				$paxfeed['tier_markup'] = $this->preference_m->get_preference_value_bycode('T'.$paxfeedraw["tier_markup"].'_MARKUP','24',$paxfeed['carrier_code'] );
				} else {
					$paxfeed['tier_markup'] = 0;
				}

				$paxfeed['tier'] = $paxfeedraw["tier_markup"];

				if($cabin->rbd_markup) {
				  $paxfeed['rbd_markup'] = $cabin->rbd_markup;
				} else {
					$paxfeed['rbd_markup']  = 0;
				}
				$is_null_flag = 0;

				foreach ($paxfeed as $k=>$v) {
                                       if($k != 'day_of_week' && $k != 'season_id' && $k != 'rbd_markup') {
                                            if($v == '' ){
                                                 $this->mydebug->paxfeed_log("There is null value column ".$k. " in row " . $column, 1);
                                                 $this->paxfeedraw_m->delete_paxfeedraw($raw_pax_id);
                                                  $is_null_flag = 1;
                                             }
                                       }
                               }

				if($is_null_flag == 1){
					$this->mydebug->paxfeed_log("Improper data for row ". $column. " skipping ..", 1);
					continue;

				}



			
					 if($this->paxfeed_m->checkPaxFeed($paxfeed)) {
					
							     $paxfeed['dtpfraw_id' ] = $raw_pax_id;
                                                             $paxfeed['create_date'] = time();
                                                             $paxfeed['modify_date'] = time();
                                                             $paxfeed['create_userID'] = $this->session->userdata('loginuserID');
															 $paxfeed['modify_userID'] = $this->session->userdata('loginuserID');
								
						//	print_r($rafeed);exit;
                                                              $insert_id = $this->paxfeed_m->insert_paxfeed($paxfeed);
								if ( $insert_id ) {
								array_push($pax_insert_list,$paxfeed['pnr_ref']);
							    $this->mydebug->paxfeed_log("Inserted pax record for row " . $column, 0);
								} else{
									$this->mydebug->paxfeed_log("Not inserted pax record for row " . $column .' not a valid data ', 1);
								}
					}else {

						$this->mydebug->paxfeed_log("Duplicate record for row ". $column, 0);
					}
			}
		}

					   } else {
						   print_r("mismatch");
						$this->mydebug->paxfeed_log("Columns count didn't match for row ". $column . " skipping ..", 1);
					   }

					}

				   $i++;					   
				  }
				} 
				
			  } 				 
			} catch (Exception $E)	{
				echo $E -> getMessage();
			}
		    if(file_exists($file)) {
		    	unlink($file);					
		    }			

			 $this->paxfeed_m->process_tiermarkup(array_unique($pax_insert_list));
			 $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		     	 redirect(base_url("paxfeed/index")); 	
		 }	
	 } else {
			$this->data["subview"] = "paxfeed/upload";
			$this->load->view('_layout_main', $this->data); 
      }
    }   

    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');	  


		
$aColumns = array('dtpf_id', 'airline_code' ,'pnr_ref','operating_carrier','marketing_carrier','pax_nbr','first_name' ,'last_name','ptc.code','fqtv','dca.code','seg_nbr',
		   'flight_number','dep_date','dept_time','arrival_date','arrival_time','class', 'cdef.cabin','df.code','dt.code',
			'tier','dfre.code','pax_contact_email','phone','cou.code','cit.code','office_id','channel','is_fclr_processed','fclr_data','pax.active',
			'ptc.aln_data_value','dca.aln_data_value','cdef.desc','df.aln_data_value','dt.aln_data_value',
			'dfre.aln_data_value','cou.aln_data_value','cit.aln_data_value');
	
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
						 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
							".$_GET['sSortDir_'.$i] .", ";
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


		 if(!empty($this->input->get('bookingCountry'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.booking_country = '.$this->input->get('bookingCountry');
                        }
                        if(!empty($this->input->get('bookingCity'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.booking_city = '.$this->input->get('bookingCity');
                        }

			if(!empty($this->input->get('carrierCode'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.carrier_code = '.$this->input->get('carrierCode');
                        }
                        if(!empty($this->input->get('fromCity'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.from_city = '.$this->input->get('fromCity');

                        }

			 if(!empty($this->input->get('pf_id'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.dtpf_id = '.$this->input->get('pf_id');

                        }



			if(!empty($this->input->get('toCity'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.to_city = '.$this->input->get('toCity');

                        }

			 if(!empty($this->input->get('tier'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.tier = '.$this->input->get('tier');

                        }



                        if(!empty($this->input->get('pax_type'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.ptc = '.$this->input->get('pax_type');


						}
						
						if(!empty($this->input->get('operating_carrier'))){
							$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
							$sWhere .= 'operating_carrier = '.$this->input->get('operating_carrier');


					}


					if(!empty($this->input->get('marketing_carrier'))){
						$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
						$sWhere .= 'marketing_carrier = '.$this->input->get('marketing_carrier');


				}


			if(!empty($this->input->get('start_date'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.dep_date >= '. strtotime($this->input->get('start_date'));
                        }
                        if(!empty($this->input->get('end_date'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.dep_date <= '.  strtotime($this->input->get('end_date'));
                        }


			 if(!empty($this->input->get('flight_range'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $num_arr = explode('-',$this->input->get('flight_range'));

                                if ( $num_arr[0] > 0 AND $num_arr[1] > 0 AND $num_arr[1] > $num_arr[0]) {
                                        $sWhere .= 'pax.flight_number >= '.$num_arr[0]. ' AND pax.flight_number <= ' . $num_arr[1];
                                } else if($num_arr[0] > 0 ) {
                                        $sWhere .= 'pax.flight_number ='. $num_arr[0];

                                }

                        }


			


		         if(!empty($this->input->get('frequency'))){
                                $frstr = $this->input->get('frequency');
				if($frstr === '*'){
                                        $frstr = '1234567';
                                }

                                $freq = $this->airports_m->getDefnsCodesListByType('14');
                                 if ( $frstr != '0') {
                                        $arr = str_split($frstr);
                                        $freq_str = implode(',',array_map(function($x) use ($freq) { return array_search($x, $freq); }, $arr));
                                        $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                        $sWhere .= 'pax.frequency IN ('.$freq_str.') ';
                                  }

                        }



    $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID == 2){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'pax.carrier_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';              
                }


			
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS 

			dtpf_id,first_name, last_name, pnr_ref,operating_carrier,marketing_carrier, pax_nbr,flight_number, pax.ptc ,ptc.code as ptc_code, fqtv, seg_nbr, dep_date, class ,dt.code as to_city, is_fclr_processed, fclr_data,
			df.code as from_city, pax_contact_email, phone, cou.code as booking_country, cit.code as booking_city, office_id, 
			pax.airline_code , channel, dca.code as carrier_code, cdef.cabin as cabin, pax.arrival_time,
			pax.dept_time, pax.arrival_date,pax.frequency,pax.tier,dfre.code as frequency,cdef.desc,
			pax.active  FROM VX_daily_tkt_pax_feed pax 
			LEFT JOIN VX_data_defns df on (df.vx_aln_data_defnsID = pax.from_city) 
			LEFT JOIN VX_data_defns dt on  (dt.vx_aln_data_defnsID = pax.to_city) 
		        LEFT JOIN VX_data_defns dfre on  (dfre.vx_aln_data_defnsID = pax.frequency)
			LEFT JOIN VX_data_defns cou  on (cou.vx_aln_data_defnsID = pax.booking_country) 
                        LEFT JOIN VX_data_defns cit on  (cit.vx_aln_data_defnsID = pax.booking_city) 
			LEFT JOIN  VX_data_defns dca on (dca.vx_aln_data_defnsID = pax.carrier_code)	
			INNER JOIN VX_airline_cabin_def cdef on (cdef.carrier = pax.carrier_code)
			INNER JOIN  VX_data_defns dcab on (dcab.vx_aln_data_defnsID = pax.cabin and dcab.aln_data_typeID = 13 and dcab.alias = cdef.level)
			LEFT JOIN  VX_data_defns ptc on (ptc.vx_aln_data_defnsID = pax.ptc)
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

	  $i = 1;
	 $rownum = 1 + $_GET['iDisplayStart'];
	  foreach($rResult as $feed){	
		 $feed->chkbox = "<input type='checkbox'  class='deleteRow' value='".$feed->dtpf_id."'  /> ".$rownum ;
                                $rownum++;

		$feed->dep_date = date('d/m/Y',$feed->dep_date);
		$feed->arrival_date = date('d/m/Y',$feed->arrival_date);
		$feed->dept_time = gmdate("H:i:s", $feed->dept_time);
		$feed->arrival_time = gmdate("H:i:s", $feed->arrival_time);
		$feed->is_fclr_processed = $feed->is_fclr_processed ? 'Yes': 'No';
		if ($feed->is_fclr_processed)  {
			$feed->fclr_data = $feed->fclr_data ? 'Matched' : 'No Data';
		} else {
			$feed->fclr_data = 'NA';
		}

		  if(permissionChecker('paxfeed_delete')){
		   $feed->action .= btn_delete('paxfeed/delete/'.$feed->dtpf_id, $this->lang->line('delete'));			 
		  }
			$status = $feed->active;
			$feed->active = "<div class='onoffswitch-small' id='".$feed->dtpf_id."'>";
            $feed->active .= "<input type='checkbox' id='myonoffswitch".$feed->dtpf_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $feed->active .= " checked >";
			} else {
			   $feed->active .= ">";
			}	
			
			$feed->active .= "<label for='myonoffswitch".$feed->dtpf_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";         
             $feed->id = $i; $i++;
			$output['aaData'][] = $feed;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array("#","Airline Code","PNR Reference","PAX Number","First Name","Last Name","PTC","FQTV","Carrier Code","Seg Number","Flight Number","Departure Date","Departure Time","Arrival Date","Arrival Time","Class","Cabin","Board Point","Off Point","Tier","Frequency","Pax Contact Email","Phone","Booking Country","Booking City","Office","Channel",'FCLR Report','FCLR Data','Operating Carrier','Marketing Carrier');
		  $rows = array("id","airline_code","pnr_ref","pax_nbr","first_name","last_name","ptc_code","fqtv","carrier_code","seg_nbr","flight_number","dep_date","dept_time","arrival_date","arrival_time","class","cabin","from_city","to_city","tier","frequency","pax_contact_email","phone","booking_country","booking_city","office_id","channel",'is_fclr_processed','fclr_data','operating_carrier','marketing_carrier');
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
	
 function convertTimeToSeconds($time_str) {
	$str = explode(':',$time_str);
	$time_in_seconds = (3600 * $str[0] ) + ( 60 * $str[1]) + (1 * $str[2]);
	return $time_in_seconds; 

 }



    function active() {

			if(permissionChecker('paxfeed_edit')){
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['modify_date'] = time();
				if($status == 'chacked') {
					$data['active'] = 1 ;
					$this->paxfeed_m->update_paxfeed($data, $id);
					echo 'Success';
				} elseif($status == 'unchacked') {
					$data['active'] = 0 ;
					$this->paxfeed_m->update_paxfeed($data, $id);
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
        $filename = APPPATH.'downloads/paxfeed.xlsx';
                force_download($filename, null);
      }


public function delete_pax_bulk_records(){
$data_ids = $_REQUEST['data_ids'];
$data_id_array = explode(",", $data_ids);
if(!empty($data_id_array)) {
    foreach($data_id_array as $id) {
	$this->data['paxfeed'] = $this->paxfeed_m->get_single_paxfeed(array('dtpf_id'=>$id));
                        if($this->data['paxfeed']) {
                                $this->paxfeed_m->delete_paxfeed($id);
				$this->paxfeedraw_m->delete_paxfeedraw($this->data['paxfeed']->dtpfraw_id);

                        }
    }
}
}

public function process_fclr_matching_report() {

				$sQuery = " SELECT * FROM VX_daily_tkt_pax_feed pf where fclr_data = 0 order by dtpf_id";
				
                $rResult = $this->install_m->run_query($sQuery);

		foreach ($rResult as $feed ) {
			 $this->paxfeed_m->update_paxfeed(array('is_fclr_processed' => '1'), $feed->dtpf_id);
			$upgrade = array();
                        $upgrade['boarding_point'] = $feed->from_city;
                        $upgrade['off_point'] = $feed->to_city;
                        $upgrade['flight_number'] = $feed->flight_number;
                        $upgrade['carrier_code'] = $feed->carrier_code;

                        $day_of_week = date('w', $feed->dep_date);
                        $day = ($day_of_week)?$day_of_week:7;

                        $p_freq =  $this->rafeed_m->getDefIdByTypeAndCode($day,'14'); //507;
                        $upgrade['season_id'] =  $this->season_m->getSeasonForDateANDAirlineID($feed->dep_date,$feed->carrier_code,$feed->from_city,$feed->to_city); //0;


                         $upgrade['from_cabin'] = $feed->cabin;
                        $data = array();
                        if($upgrade['season_id'] > 0) {
                                $data = $this->fclr_m->getUpgradeCabinsData($upgrade);
                        }
			
			 if((count($data) == 0 && $upgrade['season_id'] > 0) || $upgrade['season_id'] == 0) {
                                $upgrade['season_id'] = 0;
                                 $upgrade['frequency'] = $p_freq;
                                $data = $this->fclr_m->getUpgradeCabinsData($upgrade);

                          }

			if(count($data) > 0 ) {
				$fclr_data = implode(',',array_column($data,'fclr_id'));
				$this->paxfeed_m->update_paxfeed(array('fclr_data' => $fclr_data), $feed->dtpf_id);
			}


		}

	#redirect(base_url("paxfeed/index"));	
}

}

