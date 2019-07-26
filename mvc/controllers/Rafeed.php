<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rafeed extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model('airports_m');
		$this->load->model("season_m");
		$this->load->model("airline_m");
		$language = $this->session->userdata('lang');
		
		$this->lang->load('rafeed', $language);	
		$this->data['icon'] = $this->menu_m->getMenu(array("link"=>"rafeed"))->icon;
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
		if(!empty($this->input->post('boarding_point'))){	
		   $this->data['boarding_point'] = $this->input->post('boarding_point');
		} else {
		  $this->data['boarding_point'] = 0;
		}
		if(!empty($this->input->post('off_point'))){	
	    	$this->data['off_point'] = $this->input->post('off_point');
		} else {
		    $this->data['off_point'] = 0;
		}

		if(!empty($this->input->post('airline_code'))){
                   $this->data['airline_code'] = $this->input->post('airline_code');
                } else {
                  $this->data['airline_code'] = 0;
                }
                if(!empty($this->input->post('class'))){
                $this->data['cla'] = $this->input->post('class');
                } else {
                    $this->data['cla'] = 0;
                }
		


		 if(!empty($this->input->post('flight_range'))){
                   $this->data['flight_range'] = $this->input->post('flight_range');
                } else {
                  $this->data['flight_range'] = '';
                }

                if(!empty($this->input->post('frequency'))){
                $this->data['frequency'] = $this->input->post('frequency');
                } else {
                    $this->data['frequency'] = '';
                }


		 if(!empty($this->input->post('start_date'))){
                   $this->data['start_date'] = date('d-m-Y',$this->input->post('start_date'));
                } else {
                  $this->data['start_date'] = '';
                }

                if(!empty($this->input->post('end_date'))){
                $this->data['end_date'] = date('d-m-Y',$this->input->post('end_date'));
                } else {
                    $this->data['end_date'] = 0;
                }

		//print_r( $this->data['stateID']); exit;
		$this->data['country'] = $this->rafeed_m->getCodesByType('2');
		$this->data['city'] = $this->rafeed_m->getCodesByType('3');
		//$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
		$this->data['airport'] = $this->rafeed_m->getCodesByType('1');
		$this->data['cabin'] = $this->rafeed_m->getCodesByType('13');

               $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                        $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
                           } else {
                   $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }


		$this->data["subview"] = "rafeed/index";
		$this->load->view('_layout_main', $this->data);
	}
	

        public function delete() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
                if((int)$id) {
                        $this->data['rafeed'] = $this->rafeed_m->get_single_rafeed(array('rafeed_id'=>$id));
                        if($this->data['rafeed']) {
                                $this->rafeed_m->delete_rafeed($id);
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("rafeed/index"));
                        } else {
                                redirect(base_url("rafeed/index"));
                        }
                } else {
                        redirect(base_url("rafeed/index"));
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
			$this->data["subview"] = "rafeed/upload";
			$this->load->view('_layout_main', $this->data);
		 } else {
			require(APPPATH.'libraries/spreadsheet/php-excel-reader/Spreadsheet_Excel_Reader.php'); 
			require(APPPATH.'libraries/spreadsheet/SpreadsheetReader.php');	
          	
		try {	
		   $file = $_FILES['file']['tmp_name'];          
			   if(move_uploaded_file($file, APPPATH."/uploads/".$_FILES['file']['name'])){		

				$file =  APPPATH."/uploads/".$_FILES['file']['name']; 			   
				 $this->mydebug->rafeed_log("Processing the excel file " . $_FILES['file']['name'] , 0);
				$Reader = new SpreadsheetReader($file); 
				$header = array_map('strtolower', array("Airline Code","Ticket Number", "Coupon Number", "Carrier","Flight Number","Boarding Point","Off Point","CPN Value","Class","Flight Date","Fare Basis","Cabin","Booking Country","Booking City","Issuance Country","Issuance City","Marketing Airline Code","Operating Airline Code","OfficeID","Channel","Pax Type"));
                                 $header = array_map('strtolower', $header);


				 $Sheets = $Reader -> Sheets();
					
			foreach ($Sheets as $Index => $Name){                 					
			   $Reader -> ChangeSheet($Index);
			   $i = 0;
			  $column = 0;
			   foreach ($Reader as $Row){
				$column++;
			//	print_r($Row);exit;
				if($i == 0){ // header checking						
					
				  $flag = 0 ;						 
				  $Row = array_map('trim', $Row);
				   $import_header = array_map('strtolower', $Row);
				  if(count(array_diff($header,$import_header)) == 0){
					$this->mydebug->rafeed_log("Header matched for " . $_FILES['file']['name'] , 0);
					$this->mydebug->rafeed_log("Processing records.. ", 0 );
						 $flag = 1;
				   }				  
				 } else {
				      if($flag == 1){ 						   										
				   if(count($Row) == 21){ 
					$this->mydebug->rafeed_log("coulmns count matched , uploading data for row " . $column , 0);
					$rafeed = array();
					$num =  explode('E',$Row[array_search('ticket number',$import_header)]);
					$num1 = explode('.',$num[0]);
	 			        $rafeed['ticket_number'] =  $num1[0];
					if(!ctype_digit($rafeed['ticket_number']) || strlen($rafeed['ticket_number']) != '13'){
						$this->mydebug->rafeed_log("Ticket Number should be integer and 13 digits in row " . $column, 1);
                                                continue;
					}
				      $rafeed['coupon_number'] = $Row[array_search('coupon number',$import_header)];
					if(!is_numeric($rafeed['coupon_number']) || strlen($rafeed['coupon_number']) >= '2'){
                                                $this->mydebug->rafeed_log("Coupon should be integer and single digit in row " . $column, 1);
                                                continue;
                                        }


				      $rafeed['prorated_price'] = $Row[array_search('cpn value',$import_header)];
					if(!is_numeric($rafeed['prorated_price'])){
                                                $this->mydebug->rafeed_log("PRice should be numeric in row " . $column, 1);
                                                continue;
                                        }
	
					
				      $rafeed['airline_code'] = $Row[array_search('airline code',$import_header)];
				      if(!is_numeric($rafeed['airline_code']) || strlen($rafeed['airline_code']) != 3){
						$this->mydebug->rafeed_log("Airline Code should be 3 digits  and integer in row " . $column, 1);
						continue;
					}
				      $rafeed['fare_basis'] = $Row[array_search('fare basis',$import_header)];
					$carrier = $Row[array_search('carrier',$import_header)];
   				      $rafeed['carrier'] = 
					    $this->airports_m->getDefIdByTypeAndCode($carrier,'12');

					if(strlen($carrier) >= 3 || !ctype_alpha($carrier)){
                                                $this->mydebug->rafeed_log("Carrier should  be 2 alpha code in row " . $column, 1);
                                                continue;
                                        }

					$booking_country = $Row[array_search('booking country',$import_header)];
				      $rafeed['booking_country'] = 
					    $this->airports_m->getDefIdByTypeAndCode($booking_country,'2');

					  if(strlen($booking_country) >= 3 || !ctype_alpha($booking_country)){
                                                $this->mydebug->rafeed_log("Boking country should be 2 alpha code in row " . $column, 1);
                                                continue;
                                        }

					$booking_city = $Row[array_search('booking city',$import_header)];
				      $rafeed['booking_city'] = 
					    $this->airports_m->getDefIdByTypeAndCode($booking_city,'3');
	

					if(strlen($booking_city) >= 4 || !ctype_alpha($booking_city)){
                                                $this->mydebug->rafeed_log("Boking city should be 3 alpha code in row " . $column, 1);
                                                continue;
                                        }

					$issuance_country = $Row[array_search('issuance country',$import_header)];
				      $rafeed['issuance_country'] = 
					   $this->airports_m->getDefIdByTypeAndCode($issuance_country,'2');

					 if(strlen($issuance_country) >= 3 || !ctype_alpha($issuance_country)){
                                                $this->mydebug->rafeed_log("Issueance country should be 2 alpha code in row " . $column, 1);
                                                continue;
                                        }

					$issuance_city = $Row[array_search('issuance city',$import_header)];
                                      $rafeed['issuance_city'] = 
					     $this->airports_m->getDefIdByTypeAndCode($issuance_city,'3');

					 if(strlen($issuance_city) >= 4 || !ctype_alpha($issuance_city)){
                                                $this->mydebug->rafeed_log("Issueance city should be 3 alpha code in row " . $column, 1);
                                                continue;
                                        }

					$boarding_point = $Row[array_search('boarding point',$import_header)];

				      $rafeed['boarding_point'] =
					     $this->airports_m->getDefIdByTypeAndCode($boarding_point,'1');

					if(strlen($boarding_point) >= 4 || !ctype_alpha($boarding_point)){
                                                $this->mydebug->rafeed_log(" Boarding point should be 3 alpha code in row " . $column, 1);
                                                continue;
                                        }

					$off_point = $Row[array_search('off point',$import_header)];

				      $rafeed['off_point'] =
					     $this->airports_m->getDefIdByTypeAndCode($off_point,'1');
                                       if(strlen($off_point) >= 4 || !ctype_alpha($off_point)){
                                                $this->mydebug->rafeed_log("Off point should be 3 alpha code in row " . $column, 1);
                                                continue;
                                        }
					$cabin = $Row[array_search('cabin',$import_header)];
				      $rafeed['cabin'] = 
					     $this->airports_m->getDefIdByTypeAndCode($cabin,'13');
					$cabin_arr = array('Y','W','C','F');
					if(!in_array($cabin,$cabin_arr)){
						$this->mydebug->rafeed_log("cabin should in Y,W,C,F " . $column, 1);
						continue;
					}
  				      $rafeed['class'] = $Row[array_search('class',$import_header)];
					$class_arr = range('A','Z');
					 if(!in_array($rafeed['class'],$class_arr)){
                                                $this->mydebug->rafeed_log("class should be in A-Z " . $column, 1);
                                                continue;
                                        }

					
				      $rafeed['departure_date'] =  
					     strtotime(str_replace('-','/',$Row[array_search('flight date',$import_header)]));
				      $day_of_week = date('w', $rafeed['departure_date']);
				      $day = ($day_of_week)?$day_of_week:7;
				      $rafeed['day_of_week'] = $this->airports_m->getDefIdByTypeAndCode($day,'14');

					$marketing_airline_code = $Row[array_search('marketing airline code',$import_header)];
				      $rafeed['marketing_airline_code'] = 
					    $this->airports_m->getDefIdByTypeAndCode($marketing_airline_code,'12');

				 if(strlen($marketing_airline_code) >= 3 || !ctype_alpha($marketing_airline_code)){
                                                $this->mydebug->rafeed_log("MKT airine should be 2 alpha code in row " . $column, 1);
                                                continue;
                                        }

					$operating_airline_code = $Row[array_search('operating airline code',$import_header)];
                                      $rafeed['operating_airline_code']= 
					    $this->airports_m->getDefIdByTypeAndCode($operating_airline_code,'12');


					 if(strlen($operating_airline_code) >= 3 || !ctype_alpha($operating_airline_code)){
                                                $this->mydebug->rafeed_log("Operating airline should be 2 alpha code in row " . $column, 1);
                                                continue;
                                        }
					$season_id = $this->season_m->getSeasonForDateANDAirlineID($rafeed['departure_date'],$rafeed['carrier'],$rafeed['boarding_point'],$rafeed['off_point']);
				     $rafeed['season_id'] = $season_id; 
					$rafeed['flight_number'] = substr($Row[array_search('flight number',$import_header)], 2);

					if(strlen($rafeed['flight_number']) >= 7 ){
                                                $this->mydebug->rafeed_log("Flight number should not be more than 6 AlphaNumeric code in row " . $column, 1);
                                                continue;
                                        }

                                      $rafeed['office_id'] = $Row[array_search('officeid',$import_header)];
				      $rafeed['channel']= $Row[array_search('channel',$import_header)];
					$pax_type = $Row[array_search('pax type',$import_header)];
                                      $rafeed['pax_type'] =  $this->airports_m->getDefIdByTypeAndCode($pax_type,'18');

					 if(strlen($pax_type) >= 4 || !ctype_alpha($pax_type)){
                                                $this->mydebug->rafeed_log("Pax type code should be 2 alpha code in row " . $column, 1);
                                                continue;
                                        }

					//var_dump($rafeed);exit;
						if($this->rafeed_m->checkRaFeed($rafeed)) {
								
							$insert_flag = 1;
							foreach ($rafeed as $k=>$v) {
								if($k != 'day_of_week' && $k != 'season_id') {
									if($v == '' ){
									$this->mydebug->rafeed_log("There is null value column ".$k. " in row " . $column, 1);
									$insert_flag = 0;
								}
								}
							 }

							if ( $insert_flag == '1' ) {
                                                          $rafeed['create_date'] = time();
                                                          $rafeed['modify_date'] = time();
                                                          $rafeed['create_userID'] = $this->session->userdata('loginuserID');
                                                          $rafeed['modify_userID'] = $this->session->userdata('loginuserID');
						//	print_r($rafeed);exit;
                                                       		 $insert_id = $this->rafeed_m->insert_rafeed($rafeed);
								if ( $insert_id ) {
								$this->mydebug->rafeed_log("uploaded row " . $column , 0);
								} else{

									$this->mydebug->rafeed_log("Record not inserted for row " . $column , 0);
								}
							} else {

								$this->mydebug->rafeed_log("Not proper data for  row " . $column, 1);
								continue;
							}
						}else{
							$this->mydebug->rafeed_log("Duplicate Entry", 1);
						}

					   	 } 						
						else{
							$this->mydebug->rafeed_log("coulmns count didn't match for " . $column, '1');
						}
					   } else {
						$this->mydebug->rafeed_log("Header mismatch", 1);
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
		     redirect(base_url("rafeed/index")); 	
		 }	
	 } else {
			$this->data["subview"] = "rafeed/upload";
			$this->load->view('_layout_main', $this->data); 
      }
    }   

    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  



	$aColumns = array('rafeed_id','airline_code','ticket_number','coupon_number','dc.code','dci.code','dico.code','dici.code','dbp.code','dop.code','prorated_price','dcla.code','class','fare_basis','rf.departure_date','day_of_week','dai.code', 'dam.code','dcar.code','rf.flight_number','office_id','channel','dpax.code','rf.active','dfre.aln_data_value' , 'dc.aln_data_value', 'dci.aln_data_value', 'dico.aln_data_value',
                                'dici.aln_data_value', 'dai.aln_data_value', 'dam.aln_data_value', 'dcar.aln_data_value', 'dbp.aln_data_value',
                                'dop.aln_data_value','dcla.aln_data_value');
		
	
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
						//if($_GET['iSortCol_0'] == 8){
						//	$sOrder .= " (s.order_no*-1) DESC ,";
						//} else {
						 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
							".$_GET['sSortDir_'.$i] .", ";
						//}
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
                                $sWhere .= 'rf.booking_country = '.$this->input->get('bookingCountry');
                        }
                        if(!empty($this->input->get('bookingCity'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.booking_city = '.$this->input->get('bookingCity');
                        }


			if(!empty($this->input->get('boardPoint'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.boarding_point = '.$this->input->get('boardPoint');
                        }
                        if(!empty($this->input->get('offPoint'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.off_point = '.$this->input->get('offPoint');
                        }


			if(!empty($this->input->get('airLine'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.carrier= '.$this->input->get('airLine');
                        }
                        if(!empty($this->input->get('Class'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.cabin = '.$this->input->get('Class');
                        }



			if(!empty($this->input->get('flight_range'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
				$num_arr = explode('-',$this->input->get('flight_range'));

				if ( $num_arr[0] > 0 AND $num_arr[1] > 0 AND $num_arr[1] > $num_arr[0]) {
					$sWhere .= 'rf.flight_number >= '.$num_arr[0]. ' AND rf.flight_number <= ' . $num_arr[1];
				} else if($num_arr[0] > 0 ) {
					$sWhere .= 'rf.flight_number ='. $num_arr[0];
					
				}
			
                        }


			 if(!empty($this->input->get('start_date'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.departure_date >= '. strtotime($this->input->get('start_date'));
                        }
                        if(!empty($this->input->get('end_date'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.departure_date <= '.  strtotime($this->input->get('end_date'));
                        }



			if(!empty($this->input->get('frequency'))){
				$frstr = $this->input->get('frequency');
				$freq = $this->airports_m->getDefnsCodesListByType('14');
				 if ( $frstr != '0') {
                                        $arr = str_split($frstr);
					$freq_str = implode(',',array_map(function($x) use ($freq) { return array_search($x, $freq); }, $arr));
					$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                        $sWhere .= 'rf.day_of_week IN ('.$freq_str.') ';
				  }
					
                        }

		  $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'rf.carrier IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';                
                }


			
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS rafeed_id,ticket_number, coupon_number, dc.code as booking_country , 
				dfre.code as day_of_week,  dfre.aln_data_value , dc.aln_data_value, dci.aln_data_value, dico.aln_data_value,
				dici.aln_data_value, dai.aln_data_value, dam.aln_data_value, dcar.aln_data_value, dbp.aln_data_value,
				dop.aln_data_value,dcla.aln_data_value,
			   dci.code as  booking_city, dico.code as issuance_country, dici.code as issuance_city,dcar.code as carrier_code,
			    dai.code as operating_airline_code, dam.code as marketing_airline_code, flight_number, dbp.code as boarding_point, 
                           dop.code as off_point,  dcla.code as cabin ,  departure_date, prorated_price, class,
                           office_id, channel, dpax.code as pax_type ,rf.active  ,rf.airline_code, rf.fare_basis
                           FROM VX_aln_ra_feed rf  
                          LEFT JOIN vx_aln_data_defns dc on (dc.vx_aln_data_defnsID = rf.booking_country) 
                          LEFT JOIN vx_aln_data_defns dci on  (dci.vx_aln_data_defnsID = rf.booking_city) 
			  LEFT JOIN vx_aln_data_defns dico on (dico.vx_aln_data_defnsID = rf.issuance_country) 
                          LEFT JOIN vx_aln_data_defns dici on  (dici.vx_aln_data_defnsID = rf.issuance_city)
                          LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  
			  LEFT JOIN vx_aln_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code)
			  LEFT JOIN vx_aln_data_defns dcar on (dcar.vx_aln_data_defnsID = rf.carrier)
                          LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point)  
                          LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) 
                           LEFT JOIN vx_aln_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) 
			   LEFT JOIN vx_aln_data_defns dpax on (dpax.vx_aln_data_defnsID = rf.pax_type) 
			  LEFT JOIN vx_aln_data_defns dfre on (dfre.vx_aln_data_defnsID = rf.day_of_week) 
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
	  foreach($rResult as $feed){		 	
		$feed->departure_date = date('d/m/Y',$feed->departure_date);


		
		  if(permissionChecker('rafeed_delete')){
		   $feed->action .= btn_delete('rafeed/delete/'.$feed->rafeed_id, $this->lang->line('delete'));			 
		  }
			$status = $feed->active;
			$feed->active = "<div class='onoffswitch-small' id='".$feed->rafeed_id."'>";
            $feed->active .= "<input type='checkbox' id='myonoffswitch".$feed->rafeed_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $feed->active .= " checked >";
			} else {
			   $feed->active .= ">";
			}	
			
			$feed->active .= "<label for='myonoffswitch".$feed->rafeed_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";         
            $feed->temp_id = $i; $i++;
			$output['aaData'][] = $feed;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array("#","Airline Code","Ticket Number","Coupon number","Booking Country","Booking City","Issuance Country","Issuance City","Board Point","Off Point","Prorated Price","Cabin","Class","Fare Basis","Departure Date","Day Of Week","Operating Airline","Marketing Airline","Carrier Code","Flight Number","Office","Channel","Pax Type");
		  $rows = array("temp_id","airline_code","ticket_number","coupon_number","booking_country","booking_city","issuance_country","issuance_city","boarding_point","off_point","prorated_price","cabin","class","fare_basis","departure_date","day_of_week","operating_airline_code","marketing_airline_code","carrier_code","flight_number","office_id","channel","pax_type");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
	


 function downloadFormat(){
                $this->load->helper('download');
        $filename = APPPATH.'downloads/rafeed.xlsx';
                force_download($filename, null);
      }

    function active() {

			if(permissionChecker('rafeed_edit')){
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['modify_date'] = time();
				if($status == 'chacked') {
					$data['active'] = 1 ;
					$this->rafeed_m->update_rafeed($data, $id);
					echo 'Success';
				} elseif($status == 'unchacked') {
					$data['active'] = 0 ;
					$this->rafeed_m->update_rafeed($data, $id);
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


 function convertTimeToSeconds($time_str) {
        $str = explode(':',$time_str);
        $time_in_seconds = (3600 * $str[0] ) + ( 60 * $str[1]) + (1 * $str[2]);
        return $time_in_seconds;

 }

}

