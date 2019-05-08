<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rafeed extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("season_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('rafeed', $language);	
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
		

		//print_r( $this->data['stateID']); exit;
		$this->data['country'] = $this->rafeed_m->getCodesByType('2');
		$this->data['city'] = $this->rafeed_m->getCodesByType('5');
		$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
		$this->data['airport'] = $this->rafeed_m->getCodesByType('1');
		$this->data['cabin'] = $this->rafeed_m->getCodesByType('13');

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
				$Reader = new SpreadsheetReader($file); 
				
				//$header = array('ticket_number','coupon_number'	, 'booking_city', 'booking_country','issuance_city','issuance_country','board_point','off_point','cabin','class','booking_date','departure_date','days_to_departure','prorated_price','marketing_airline_code','operating_airline_code');


		//		$header = array('ticket_number','airline_code','cpn_number','cpn_value','carrier','flight_number','boarding_point','off_point','class','cabin','flight_date','fare_basis','booking_country','booking_city','office_id','channel','pax_type');
			$header  = array("ticket_number","coupon_number","booking_city","booking_country","issuance_city","issuance_country",
				"board_point","off_point","cabin","class","booking_date","departure_date","prorated_price","marketing_airline_code","operating_airline_code","flight_number","channel","pax_type","office_id");	


			//	print_r(count($header)); exit;
				$Sheets = $Reader -> Sheets();
			//	$defnData = $this->airports_m->getDefns();
					
			    foreach ($Sheets as $Index => $Name){                 					
				   $Reader -> ChangeSheet($Index);
				   $i = 0;
                 //$time_start = microtime(true); 					   
				  foreach ($Reader as $Row){
				//	print_r($Row);exit;
					if($i == 0){ // header checking						
					
					  $flag = 0 ;						 
					 if($Row == $header ){
						 $flag = 1;
					 }				  
					} else {
					   if($flag == 1){ 						   										
					   	 if(count($Row) == 19){ //print_r($Row); exit;
	 						$rafeed['ticket_number'] = $Row[0]; 
							$rafeed['coupon_number'] = $Row[1];
							$rafeed['booking_city'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[2],'5');
							$rafeed['booking_country'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[3],'2');
							$rafeed['issuance_city'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[4],'5');
							$rafeed['issuance_country'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[5],'2');
							$rafeed['boarding_point'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[6],'1');
                                                        $rafeed['off_point'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[7],'1');
							$rafeed['cabin'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[8],'13');
							 $rafeed['class'] = $Row[9];
							$rafeed['booking_date'] = strtotime(str_replace('-','/',$Row[10]));
							$rafeed['departure_date'] = strtotime(str_replace('-','/',$Row[11]));
							$rafeed['day_of_week'] = date('w', $rafeed['departure_date']);
							$rafeed['days_to_departure'] =  floor(($rafeed['departure_date'] - $rafeed['booking_date']) / (60*60*24) );

							$rafeed['marketing_airline_code'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[13],'12');
                                                         $rafeed['operating_airline_code']= $this->rafeed_m->getDefIdByTypeAndCode($Row[14],'12');

								$season_id = $this->season_m->getSeasonForDateANDAirlineID($rafeed['departure_date'],$rafeed['operating_airline_code']);
							if(is_null($season_id)) {
								$season_id = 0;
							} 
							$rafeed['season_id'] = $season_id; 
                                                         $rafeed['prorated_price'] = $Row[12];
							 $rafeed['flight_number'] = $Row[15];
                                                         $rafeed['office_id'] = $Row[18];
							$rafeed['channel']= $Row[16];
                                                         $rafeed['pax_type'] =  $this->rafeed_m->getDefIdByTypeAndCode($Row[17],'18');
						if($this->rafeed_m->checkRaFeed($rafeed)) {
								
                                                           $rafeed['create_date'] = time();
                                                          $rafeed['modify_date'] = time();
                                                          $rafeed['create_userID'] = $this->session->userdata('loginuserID');
                                                          $rafeed['modify_userID'] = $this->session->userdata('loginuserID');
						//	print_r($rafeed);exit;
                                                        $this->rafeed_m->insert_rafeed($rafeed);
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


		
	    $aColumns = array('rafeed_id','ticket_number', 'coupon_number', 'booking_country', 'booking_city', 'issuance_country', 'issuance_city','boarding_point', 'off_point', 'cabin', 'class', 'booking_date','departure_date', 'prorated_price', 'operating_airline_code', 'marketing_airline_code', 'active');
	
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
                                $sWhere .= 'rf.operating_airline_code = '.$this->input->get('airLine');
                        }
                        if(!empty($this->input->get('Class'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'rf.cabin = '.$this->input->get('Class');
                        }



			
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS rafeed_id,ticket_number, coupon_number, dc.code as booking_country , 
				day_of_week, days_to_departure, 
			   dci.code as  booking_city, dico.code as issuance_country, dici.code as issuance_city,
			    dai.code as operating_airline_code, dam.code as marketing_airline_code, flight_number, dbp.code as boarding_point, 
                           dop.code as off_point,  dcla.code as cabin , booking_date, departure_date, prorated_price, class,
                           office_id, channel, pax_type ,rf.active  
                           FROM VX_aln_ra_feed rf  
                          LEFT JOIN vx_aln_data_defns dc on (dc.vx_aln_data_defnsID = rf.booking_country) 
                          LEFT JOIN vx_aln_data_defns dci on  (dci.vx_aln_data_defnsID = rf.booking_city) 
			  LEFT JOIN vx_aln_data_defns dico on (dico.vx_aln_data_defnsID = rf.issuance_country) 
                          LEFT JOIN vx_aln_data_defns dici on  (dici.vx_aln_data_defnsID = rf.issuance_city)
                          LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  
			  LEFT JOIN vx_aln_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code)
                          LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point)  
                          LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) 
                           LEFT JOIN vx_aln_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) 
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
	  foreach($rResult as $feed){		 	
		$feed->booking_date = date('d/m/Y',$feed->booking_date);
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
           
			$output['aaData'][] = $feed;				
		}
		echo json_encode( $output );
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

}

