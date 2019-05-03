<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invfeed extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("invfeed_m");
		$this->load->model('rafeed_m');
		$this->load->model("airline_cabin_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('invfeed', $language);	
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
                  $this->data['airline_code'] = 0;
                }
                if(!empty($this->input->post('cabin'))){
                $this->data['cabin'] = $this->input->post('cabin');
                } else {
                    $this->data['cabin'] = 0;
                }
		

		//print_r( $this->data['stateID']); exit;
		$this->data['airports'] = $this->rafeed_m->getCodesByType('1');
		$this->data['airlines'] = $this->airline_cabin_m->getAirlines();;
		$this->data['cabins'] = $this->airline_cabin_m->getAirlineCabins();

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
				
				$header = array('airline_code','flight_nbr','departure_date','origin_airport','dest_airport','cabin','empty_seats','sold_seats');

				$Sheets = $Reader -> Sheets();
					

	
                        //      print_r(count($header)); exit;
                                $Sheets = $Reader -> Sheets();
                        //      $defnData = $this->airports_m->getDefns();

                            foreach ($Sheets as $Index => $Name){
                                   $Reader -> ChangeSheet($Index);
                                   $i = 0;
                 //$time_start = microtime(true);                                          
                                  foreach ($Reader as $Row){
                                //      print_r($Row);exit;
                                        if($i == 0){ // header checking                                         

                                          $flag = 0 ;
                                         if($Row == $header ){
                                                 $flag = 1;
                                         }
                                        } else {
                                           if($flag == 1){                                                                                      
					   	 if(count($Row) == 8){ //print_r($Row); exit;						
	 						$invfeed['airline_id'] =  $this->rafeed_m->getDefIdByTypeAndCode($Row[0],'12'); 
                                                         $invfeed['flight_nbr'] = $Row[1];
                                                         $invfeed['departure_date'] = strtotime(str_replace('-','/',$Row[2]));
                                                         $invfeed['origin_airport'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[3],'1');
							 $invfeed['dest_airport'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[4],'1');
                                                         $invfeed['cabin'] = $this->airline_cabin_m->getAirlineClassByName($Row[5]);
                                                         $invfeed['empty_seats'] = $Row[6];
                                                         $invfeed['sold_seats'] =  $Row[7];
		
						if($this->invfeed_m->checkInvFeed($invfeed)) {
							
                                                           $invfeed['create_date'] = time();
                                                          $invfeed['modify_date'] = time();
                                                          $invfeed['create_userID'] = $this->session->userdata('loginuserID');
                                                          $invfeed['modify_userID'] = $this->session->userdata('loginuserID');
						//	print_r($rafeed);exit;
                                                        $this->invfeed_m->insert_invfeed($invfeed);
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


		
$aColumns = array('invfeed_id', 'flight_nbr', 'departure_date', 'origin_airport', 'sold_seats', 'empty_seats',
                        'dest_airport', 'cabin', 'airline_code', 'inv.active');
	
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


			
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS 

			invfeed_id, flight_nbr, departure_date, concat(do.aln_data_value,'(',do.code,')') as origin_airport, 
		        departure_date, sold_seats, empty_seats,
			concat(ds.aln_data_value,'(',ds.code,')') as dest_airport, dc.aln_data_value as cabin, 
			concat(da.aln_data_value,'(',da.code,')')  as airline_code ,
			inv.active  FROM VX_aln_daily_inv_feed inv  
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
	  foreach($rResult as $feed){		 	
		$feed->departure_date = date('d/m/Y',$feed->departure_date);

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
           
			$output['aaData'][] = $feed;				
		}
		echo json_encode( $output );
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

}

