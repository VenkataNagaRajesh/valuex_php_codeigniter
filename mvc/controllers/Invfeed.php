<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invfeed extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("invfeed_m");
		$this->load->model('rafeed_m');
		$this->load->model("invfeedraw_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("airline_m");
		$this->load->model('airports_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('invfeed', $language);
        $this->data['icon'] = $this->menu_m->getMenu(array("link"=>"invfeed"))->icon;			
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


		
		if(!empty($this->input->post('origin_airport'))){
		  $this->data['origin_airport'] = $this->input->post('origin_airport');
		} else {
		  $this->data['origin_airport'] = 0;
		}
		if(!empty($this->input->post('dest_airport'))){		
        	$this->data['booking_city'] = $this->input->post('dest_airport');
		} else {
		  $this->data['dest_airport'] = 0;
		}

		if(!empty($this->input->post('airline_code'))){
                   $this->data['airline_code'] = $this->input->post('airline_code');
                } else {
                  if($this->session->userdata('usertypeID') == 2){
					 $this->data['airline_code'] = $this->session->userdata('default_airline');
				   } else {					
                     $this->data['airline_code'] = 0;
				   }
                }
                if(!empty($this->input->post('cabin'))){
                $this->data['cabin'] = $this->input->post('cabin');
                } else {
                    $this->data['cabin'] = 0;
                }
		

		//print_r( $this->data['stateID']); exit;
		$this->data['airports'] = $this->rafeed_m->getCodesByType('1');

		 $this->data['cabins'] = $this->rafeed_m->getCodesByType('13');

               $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                        $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
                           } else {
                   $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }


		$this->data["subview"] = "invfeed/index";
		$this->load->view('_layout_main', $this->data);
	}
	

        public function delete() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
                if((int)$id) {
                        $this->data['invfeed'] = $this->invfeed_m->get_single_invfeed(array('invfeed_id'=>$id));
                        if($this->data['invfeed']) {
                                $this->invfeed_m->delete_invfeed($id);
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("invfeed/index"));
                        } else {
                                redirect(base_url("invfeed/index"));
                        }
                } else {
                        redirect(base_url("invfeed/index"));
                }
        }	

	public function upload(){
	
	 if($_FILES){
		 if (empty($_FILES['file']['name'])) {
            $this->session->set_flashdata('error',"Please select File");			
			$this->data["subview"] = "invfeed/upload";
			$this->load->view('_layout_main', $this->data);
		 } else {
			require(APPPATH.'libraries/spreadsheet/php-excel-reader/Spreadsheet_Excel_Reader.php'); 
			require(APPPATH.'libraries/spreadsheet/SpreadsheetReader.php');	
          	
		try {	
		   $file = $_FILES['file']['tmp_name'];          
			   if(move_uploaded_file($file, APPPATH."/uploads/".$_FILES['file']['name'])){		

				$file =  APPPATH."/uploads/".$_FILES['file']['name']; 			   
				$Reader = new SpreadsheetReader($file); 
				 $header = array_map('strtolower',array("Airlline code", "Flight nbr","Dept date","Origin Airport","Destination Airport","Cabin","Empty seats"));	
				$header = array_map('strtolower', $header);
				$Sheets = $Reader -> Sheets();
					
			$this->mydebug->invfeed_log("Processing the excel file " . $_FILES['file']['name'] , 0);
	
                        //      print_r(count($header)); exit;
                                $Sheets = $Reader -> Sheets();
                        //      $defnData = $this->airports_m->getDefns();

                            foreach ($Sheets as $Index => $Name){
                                   $Reader -> ChangeSheet($Index);
                                   $i = 0;
                 //$time_start = microtime(true);                                          
				$column = 0;
                                  foreach ($Reader as $Row){
					$column++;
						$Row = array_map('trim', $Row);
                                    //  print_r($Row);exit;
                                        if($i == 0){ // header checking                                         
						
                                          $flag = 0 ;
                                         $import_header = array_map('strtolower', $Row);
                                         if(count(array_diff($header,$import_header)) == 0 ){
						$this->mydebug->invfeed_log("Header Matched for " . $_FILES['file']['name'] , 0);
                                                 $flag = 1;
                                         }
                                        } else {
                                           if($flag == 1){                                                                                      						
					   	 if(count($Row) == 7){ //print_r($Row); exit;						
							$this->mydebug->invfeed_log("coulmns count matched , uploading data for row " . $column , 0);
							$invfeedraw = array();
							$invfeedraw['airline'] = $Row[array_search('airline code',$import_header)];
							if(strlen($invfeedraw['airline']) != '2' || !ctype_alpha($invfeedraw['airline'])){
								 $this->mydebug->invfeed_log("Carrier code should be 2 charcters " . $column , 1);
								 continue;
							}
							$invfeedraw['flight_nbr'] = $Row[array_search('flight nbr',$import_header)];
							if(strlen($invfeedraw['flight_nbr']) >= '7'){

								 $this->mydebug->invfeed_log("Flight number should not be more than 6 charcters " . $column , 1);
                                                                continue;
							}
							$invfeedraw['departure_date'] = $Row[array_search('dept date',$import_header)];
							 $invfeedraw['origin_airport'] = $Row[array_search('origin airport',$import_header)];
							 if(strlen($invfeedraw['origin_airport']) != '3' || !ctype_alpha($invfeedraw['origin_airport'])){

									 $this->mydebug->invfeed_log("Origin Airport  should be 3 charcters " . $column , 1);
								continue;
							}
							$invfeedraw['dest_airport'] = $Row[array_search('destination airport',$import_header)];

							if (strlen($invfeedraw['dest_airport']) != '3' || !ctype_alpha($invfeedraw['dest_airport'])){

							 $this->mydebug->invfeed_log("Dest Airport should be 3 charcters " . $column , 1);
                                                                continue;

							}

							$cabin_arr = array('Y','W','C','F');

							$invfeedraw['cabin'] =  $Row[array_search('cabin',$import_header)];
							if(!in_array($invfeedraw['cabin'],$cabin_arr)){

								$this->mydebug->invfeed_log("Cabin should be in Y,W,C,F " . $column , 1);
                                                                continue;

							}
							$invfeedraw['empty_seats'] = $Row[array_search('empty seats',$import_header)];
							//$invfeedraw['sold_seats'] = $Row[array_search('sold seats',$import_header)];
                                                           $invfeedraw['create_date'] = time();
                                                          $invfeedraw['modify_date'] = time();
                                                          $invfeedraw['create_userID'] = $this->session->userdata('loginuserID');
                                                          $invfeedraw['modify_userID'] = $this->session->userdata('loginuserID');
								$invfeed_raw_id = $this->invfeedraw_m->insert_invfeedraw($invfeedraw);
							if($invfeed_raw_id) {
							 $this->mydebug->invfeed_log("Inserted raw field for row " . $column , 0);	
							$invfeed = array();

	 						$invfeed['airline_id'] =  $this->airports_m->getDefIdByTypeAndCode($invfeedraw['airline'],'12'); 
                                                         $invfeed['flight_nbr'] = substr($invfeedraw['flight_nbr'],2);
                                                         $invfeed['departure_date'] = strtotime(str_replace('-','/',$invfeedraw['departure_date']));
                                                         $invfeed['origin_airport'] = $this->airports_m->getDefIdByTypeAndCode($invfeedraw['origin_airport'],'1');
							 $invfeed['dest_airport'] = $this->airports_m->getDefIdByTypeAndCode($invfeedraw['dest_airport'],'1');
                                                         $invfeed['cabin'] = $this->airports_m->getDefIdByTypeAndCode($invfeedraw['cabin'],13);
                                                         $invfeed['empty_seats'] = $invfeedraw['empty_seats'] ;

                                                        $insert_flag = 1;
                                                        foreach ($invfeed as $k=>$v) {
                                                                        if($v == '' ){
                                                                        $this->mydebug->invfeed_log("There is null value column ".$k. " in row " . $column, 1);
                                                                        $insert_flag = 0;
                                                                }
                                                         }

							if ($insert_flag == 0 ) {
								$this->mydebug->invfeed_log("Improper data for row " . $column, 1);
								continue;

							} else {

                                                         //$invfeed['sold_seats'] =   $invfeedraw['sold_seats'];
							$inv_feed_id = $this->invfeed_m->checkInvFeed($invfeed);
						if($inv_feed_id) {
							// if inv feed feed exist make it inactive
							$invfeed['active'] = 1;
							$update['active'] = 0;
							$update['modify_date'] = time();
							$update['modify_userID'] = $this->session->userdata('loginuserID');
							$this->invfeed_m->update_entries($update,$invfeed);
						  }

							// insert new entry
							$invfeed['invfeedraw_id'] = $invfeed_raw_id;	
                                                           $invfeed['create_date'] = time();
                                                          $invfeed['modify_date'] = time();
                                                          $invfeed['create_userID'] = $this->session->userdata('loginuserID');
                                                          $invfeed['modify_userID'] = $this->session->userdata('loginuserID');
						//	print_r($rafeed);exit;

		                                           $insert_id = $this->invfeed_m->insert_invfeed($invfeed);
							if($insert_id) {
							 	$this->mydebug->invfeed_log("Inserted data for row " . $column, 0);
							} else{ 
								$this->mydebug->invfeed_log("Not created record, check data " . $column, 0);
							}

						}
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
		     redirect(base_url("invfeed/index")); 	
		 }	
	 } else {
			$this->data["subview"] = "invfeed/upload";
			$this->load->view('_layout_main', $this->data); 
      }
    }   

    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  


		
$aColumns = array('invfeed_id', 'da.code','flight_nbr','do.code','ds.code','dc.code', 'departure_date', 'empty_seats','sold_seats', 'inv.active','da.aln_data_value','do.aln_data_value','ds.aln_data_value','dc.aln_data_value');
	
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


		 if(!empty($this->input->get('orgAirport'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'inv.origin_airport = '.$this->input->get('orgAirport');
                        }
                        if(!empty($this->input->get('destAirport'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'inv.dest_airport = '.$this->input->get('destAirport');
                        }

			if(!empty($this->input->get('airLine'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'inv.airline_id = '.$this->input->get('airLine');
                        }
                        if(!empty($this->input->get('Cabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'inv.cabin = '.$this->input->get('Cabin');
                        }

			if(!empty($this->input->get('flight_range'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $num_arr = explode('-',$this->input->get('flight_range'));

                                if ( $num_arr[0] > 0 AND $num_arr[1] > 0 AND $num_arr[1] > $num_arr[0]) {
                                        $sWhere .= 'inv.flight_nbr >= '.$num_arr[0]. ' AND inv.flight_nbr <= ' . $num_arr[1];
                                } else if($num_arr[0] > 0 ) {
                                        $sWhere .= 'inv.flight_nbr ='. $num_arr[0];

                                }

                        }


                         if(!empty($this->input->get('start_date'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'inv.departure_date = '. strtotime($this->input->get('start_date'));
                        }




		                $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'inv.airline_id IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';                
                }

			
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS 
			invfeed_id, flight_nbr, departure_date, do.code as origin_airport, 
		        departure_date, sold_seats, empty_seats,
			ds.code as dest_airport, dc.code as cabin, 
			da.code as airline_code ,
			inv.active   FROM VX_aln_daily_inv_feed inv  
			LEFT JOIN vx_aln_data_defns do on (do.vx_aln_data_defnsID = inv.origin_airport) 
			LEFT JOIN vx_aln_data_defns ds on  (ds.vx_aln_data_defnsID = inv.dest_airport) 
			LEFT JOIN vx_aln_data_defns dc on (dc.vx_aln_data_defnsID = inv.cabin)  
			LEFT JOIN  vx_aln_data_defns da on (da.vx_aln_data_defnsID = inv.airline_id)  
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
		$feed->departure_date = date('d/m/Y',$feed->departure_date);

		 $feed->chkbox = "<input type='checkbox'  class='deleteRow' value='".$feed->invfeed_id."'  /> ".$rownum ;
                                $rownum++;


		  if(permissionChecker('invfeed_delete')){
		   $feed->action .= btn_delete('invfeed/delete/'.$feed->invfeed_id, $this->lang->line('delete'));			 
		  }
			$status = $feed->active;
			$feed->active = "<div class='onoffswitch-small' id='".$feed->invfeed_id."'>";
            $feed->active .= "<input type='checkbox' id='myonoffswitch".$feed->invfeed_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $feed->active .= " checked >";
			} else {
			   $feed->active .= ">";
			}	
			
			$feed->active .= "<label for='myonoffswitch".$feed->invfeed_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";         
            $feed->id = $i; $i++;
			$output['aaData'][] = $feed;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array('#','Carrier Code','Flight Number','origin Airport','Destination Airport','Cabin','Departure Date','Empty Seats','Sold Seats');
		  $rows = array("id","airline_code","flight_nbr","origin_airport","dest_airport","cabin","departure_date","empty_seats","sold_seats");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}
	
 function downloadFormat(){
                $this->load->helper('download');
        $filename = APPPATH.'downloads/invfeed.xlsx';
                force_download($filename, null);
      }




    function active() {

			if(permissionChecker('invfeed_edit')){
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['modify_date'] = time();
				if($status == 'chacked') {
					$data['active'] = 1 ;
					$this->invfeed_m->update_invfeed($data, $id);
					echo 'Success';
				} elseif($status == 'unchacked') {
					$data['active'] = 0 ;
					$this->invfeed_m->update_invfeed($data, $id);
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


public function delete_inv_bulk_records(){
$data_ids = $_REQUEST['data_ids'];
$data_id_array = explode(",", $data_ids);
if(!empty($data_id_array)) {
    foreach($data_id_array as $id) {
	$this->data['invfeed'] = $this->invfeed_m->get_single_invfeed(array('invfeed_id'=>$id));
          if($this->data['invfeed']) {
                  $this->invfeed_m->delete_invfeed($id);
          }
    }
  }
}


}

