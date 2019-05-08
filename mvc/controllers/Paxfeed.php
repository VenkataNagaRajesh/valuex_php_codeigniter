<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paxfeed extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("paxfeed_m");
		$this->load->model('rafeed_m');
		$this->load->model("airline_cabin_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('paxfeed', $language);	
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
                    $this->data['carrier_code'] = 0;
                }


                $this->data['country'] = $this->rafeed_m->getCodesByType('2');
                $this->data['city'] = $this->rafeed_m->getCodesByType('5');
                $this->data['airlines'] = $this->rafeed_m->getCodesByType('12');


		$this->data["subview"] = "paxfeed/index";
		$this->load->view('_layout_main', $this->data);
	}
	

        public function delete() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
                if((int)$id) {
                        $this->data['paxfeed'] = $this->paxfeed_m->get_single_paxfeed(array('dtpf_id'=>$id));
                        if($this->data['paxfeed']) {
                                $this->paxfeed_m->delete_paxfeed($id);
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
				
		$header = array("airline_code","pnr_ref","pax_nbr","first_name","last_name","ptc","fqtv","seg_nbr",
				"carrier_code","flight_nbr","dep_date","class","from_city","to_city","pax_contact_email",
					"phone","booking_country","booking_city","office_id","channel");	

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
					   	 if(count($Row) == 20){ //print_r($Row); exit;						
	 						$paxfeed['airline_code'] =  $this->rafeed_m->getDefIdByTypeAndCode($Row[0],'12'); 
                                                         $paxfeed['pnr_ref'] = $Row[1];
                                                         $paxfeed['pax_nbr'] = $Row[2];
                                                         $paxfeed['first_name'] = $Row[3];
							 $paxfeed['last_name'] = $Row[4];
                                                         $paxfeed['ptc'] = $Row[5];
                                                         $paxfeed['fqtv'] = $Row[6];
                                                         $paxfeed['seg_nbr'] =  $Row[7];
							 $paxfeed['carrier_code'] =  $this->rafeed_m->getDefIdByTypeAndCode($Row[8],'12');
                                                         $paxfeed['flight_number'] = $Row[9];
                                                         $paxfeed['dep_date'] = strtotime(str_replace('-','/',$Row[10]));
                                                         $paxfeed['class'] = $Row[11];
                                                         $paxfeed['from_city'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[12],'5');
                                                         $paxfeed['to_city'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[13],'5');
							 $paxfeed['phone'] = $Row[14];
                                                         $paxfeed['pax_contact_email'] = $Row[15];
                                                         $paxfeed['booking_country'] =  $this->rafeed_m->getDefIdByTypeAndCode($Row[16],'2');
							 $paxfeed['booking_city'] = $this->rafeed_m->getDefIdByTypeAndCode($Row[17],'5');
                                                         $paxfeed['office_id'] = $Row[18];
                                                         $paxfeed['channel'] = $Row[19];
						if($this->paxfeed_m->checkPaxFeed($paxfeed)) {
							
                                                           $paxfeed['create_date'] = time();
                                                          $paxfeed['modify_date'] = time();
                                                          $paxfeed['create_userID'] = $this->session->userdata('loginuserID');
                                                          $paxfeed['modify_userID'] = $this->session->userdata('loginuserID');
						//	print_r($rafeed);exit;
                                                        $this->paxfeed_m->insert_paxfeed($paxfeed);
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
		     redirect(base_url("paxfeed/index")); 	
		 }	
	 } else {
			$this->data["subview"] = "paxfeed/upload";
			$this->load->view('_layout_main', $this->data); 
      }
    }   

    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  


		
$aColumns = array('dtpf_id', 'flight_nbr', 'dep_date', 'from_city', 'to_city', 'class',
                        'booking_country','booking_city', 'carrier_code', 'airline_code', 'pax.active');
	
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


			if(!empty($this->input->get('toCity'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pax.to_city = '.$this->input->get('toCity');

                        }




			
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS 

			dtpf_id,first_name, last_name, pnr_ref, pax_nbr,flight_number,ptc, fqtv, seg_nbr, dep_date, class ,dt.code as to_city,
			df.code as from_city, pax_contact_email, phone, cou.code as booking_country, cit.code as booking_city, office_id, 
			da.code as airline_code , channel, dca.code as carrier_code,
			pax.active  FROM VX_aln_daily_tkt_pax_feed pax 
			LEFT JOIN vx_aln_data_defns df on (df.vx_aln_data_defnsID = pax.from_city) 
			LEFT JOIN vx_aln_data_defns dt on  (dt.vx_aln_data_defnsID = pax.to_city) 
			LEFT JOIN vx_aln_data_defns cou  on (cou.vx_aln_data_defnsID = pax.booking_country) 
                        LEFT JOIN vx_aln_data_defns cit on  (cit.vx_aln_data_defnsID = pax.booking_city) 
			LEFT JOIN  vx_aln_data_defns da on (da.vx_aln_data_defnsID = pax.airline_code)  
			LEFT JOIN  vx_aln_data_defns dca on (dca.vx_aln_data_defnsID = pax.carrier_code)
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
		$feed->dep_date = date('d/m/Y',$feed->dep_date);

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
           
			$output['aaData'][] = $feed;				
		}
		echo json_encode( $output );
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

}

