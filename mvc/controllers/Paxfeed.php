<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paxfeed extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("paxfeed_m");
		$this->load->model('paxfeedraw_m');
		$this->load->model('rafeed_m');
		$this->load->model('airports_m');
		$this->load->model("airline_cabin_m");
		$this->load->model('airline_cabin_class_m');
        	$this->load->model('preference_m');

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


                $this->data['city'] = $this->airports_m->getDefnsCodesListByType('3');
                $this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
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



	$header = array_map("strtolower", array("Airline Code","PNR ref","Pax nbr","first name","last name","ptc","FQTV","seg nbr","carrier code","flight nbr","dept date","arrival date","dept time", "arrival time","class","board point","off point","PAX contact email","Phone","Booking country","booking city","office-id","channel","tier markup"));	
		$header = array_map('strtolower', $header);


				$Sheets = $Reader -> Sheets();
                        //      print_r(count($header)); exit;
                                $Sheets = $Reader -> Sheets();
                        //      $defnData = $this->airports_m->getDefns();

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
			   	 if(count($Row) == 24){ //print_r($Row); exit;						
					$paxfeedraw = array();
			   	      $paxfeedraw['airline_code'] =  $Row[array_search('airline code',$import_header)];
                                      $paxfeedraw['pnr_ref'] = $Row[array_search('pnr ref',$import_header)];
                                      $paxfeedraw['pax_nbr'] = $Row[array_search('pax nbr',$import_header)];
                                      $paxfeedraw['first_name'] = $Row[array_search('first name',$import_header)];
                                      $paxfeedraw['last_name'] = $Row[array_search('last name',$import_header)];
                                      $paxfeedraw['ptc'] = $Row[array_search('ptc',$import_header)];
                                     $paxfeedraw['fqtv'] = $Row[array_search('fqtv',$import_header)];
                                      $paxfeedraw['seg_nbr'] =  $Row[array_search('seg nbr',$import_header)];
                                      $paxfeedraw['carrier_code'] =  $Row[array_search('carrier code',$import_header)];
                                      $paxfeedraw['flight_number'] = $Row[array_search('flight nbr',$import_header)];
                                      $paxfeedraw['dep_date'] = $Row[array_search('dept date',$import_header)];
					$paxfeedraw['arrival_date'] = $Row[array_search('arrival date',$import_header)];
				      $paxfeedraw['dept_time'] = $Row[array_search('dept time',$import_header)];
				      $paxfeedraw['arrival_time'] = $Row[array_search('arrival time',$import_header)];
                                      $paxfeedraw['class'] = $Row[array_search('class',$import_header)];
                                      $paxfeedraw['from_city'] = $Row[array_search('board point',$import_header)];
                                      $paxfeedraw['to_city'] = $Row[array_search('off point',$import_header)];
                                      $paxfeedraw['phone'] = $Row[array_search('phone',$import_header)];
                                      $paxfeedraw['pax_contact_email'] = $Row[array_search('pax contact email',$import_header)];
                                      $paxfeedraw['booking_country'] =  $Row[array_search('booking country',$import_header)];
                                      $paxfeedraw['booking_city'] = $Row[array_search('booking city',$import_header)];
                                      $paxfeedraw['office_id'] = $Row[array_search('office-id',$import_header)];
                                      $paxfeedraw['channel'] = $Row[array_search('channel',$import_header)];
					
					$paxfeedraw['tier_markup'] = $Row[array_search('tier markup',$import_header)];

				      if($this->paxfeedraw_m->checkPaxFeedRaw($paxfeedraw)) {

                                          $paxfeedraw['create_date'] = time();
                                          $paxfeedraw['modify_date'] = time();
                                          $paxfeedraw['create_userID'] = $this->session->userdata('loginuserID');
                                          $paxfeedraw['modify_userID'] = $this->session->userdata('loginuserID');
                                          $raw_pax_id = $this->paxfeedraw_m->insert_paxfeedraw($paxfeedraw);

			             if ( $raw_pax_id ) {
					$paxfeed = array();
	 				$paxfeed['airline_code'] = $paxfeedraw['airline_code'];
                                        $paxfeed['pnr_ref'] = $paxfeedraw['pnr_ref'];
                                        $paxfeed['pax_nbr'] = $paxfeedraw['pax_nbr'];
                                        $paxfeed['first_name'] = $paxfeedraw['first_name'];
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
				/*
					 if ($paxfeedraw['tier_markup'] == 1 ){
						$paxfeed['tier_markup'] = $this->preference_m->get_preference_value_bycode('T1_MARKUP','7');
					 } else if($paxfeedraw['tier_markup'] == 2){

						$paxfeed['tier_markup'] = $this->preference_m->get_preference_value_bycode('T2_MARKUP','7');
					 } else if ($paxfeedraw['tier_markup'] == 3){
						$paxfeed['tier_markup'] = $this->preference_m->get_preference_value_bycode('T3_MARKUP','7');
					 } else if ($paxfeedraw['tier_markup'] == 4){
						$paxfeed['tier_markup'] = $this->preference_m->get_preference_value_bycode('T4_MARKUP','7');
					 }else {
						$paxfeed['tier_markup'] = 0;
					  }*/
				if ( $paxfeedraw["tier_markup"] ) {
				$paxfeed['tier_markup'] = $this->preference_m->get_preference_value_bycode('T'.$paxfeedraw["tier_markup"].'_MARKUP','7');
				} else {
					$paxfeed['tier_markup'] = 0;
				}

				$paxfeed['tier'] = $paxfeedraw["tier_markup"];

				if ( $cabin->cabin_code != '') {
				$paxfeed['rbd_markup'] = $this->preference_m->get_preference_value_bycode('RBD_'.$cabin->cabin_code,'7');
				} else {
					$paxfeed['rbd_markup'] = 0;
				}
					 if($this->paxfeed_m->checkPaxFeed($paxfeed)) {
							     $paxfeed['dtpfraw_id' ] = $raw_pax_id;
                                                             $paxfeed['create_date'] = time();
                                                             $paxfeed['modify_date'] = time();
                                                             $paxfeed['create_userID'] = $this->session->userdata('loginuserID');
                                                             $paxfeed['modify_userID'] = $this->session->userdata('loginuserID');
						//	print_r($rafeed);exit;
                                                              $this->paxfeed_m->insert_paxfeed($paxfeed);
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


		
$aColumns = array('dtpf_id', 'airline_code' ,'pnr_ref','pax_nbr','first_name' ,'last_name','ptc.code','fqtv','dca.code','seg_nbr',
		   'flight_number','dep_date','dept_time','arrival_date','arrival_time','class', 'dcab.code','df.code','dt.code',
			'tier','dfre.code','pax_contact_email','phone','cou.code','cit.code','office_id','channel','pax.active',
			'ptc.aln_data_value','dca.aln_data_value','dcab.aln_data_value','df.aln_data_value','dt.aln_data_value',
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
                                $freq = $this->airports_m->getDefnsCodesListByType('14');
                                 if ( $frstr != '0') {
                                        $arr = str_split($frstr);
                                        $freq_str = implode(',',array_map(function($x) use ($freq) { return array_search($x, $freq); }, $arr));
                                        $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                        $sWhere .= 'pax.frequency IN ('.$freq_str.') ';
                                  }

                        }




			
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS 

			dtpf_id,first_name, last_name, pnr_ref, pax_nbr,flight_number, pax.ptc ,ptc.code as ptc_code, fqtv, seg_nbr, dep_date, class ,dt.code as to_city,
			df.code as from_city, pax_contact_email, phone, cou.code as booking_country, cit.code as booking_city, office_id, 
			pax.airline_code , channel, dca.code as carrier_code, dcab.code as cabin, pax.arrival_time,
			pax.dept_time, pax.arrival_date,pax.frequency,pax.tier,dfre.code as frequency,
			pax.active  FROM VX_aln_daily_tkt_pax_feed pax 
			LEFT JOIN vx_aln_data_defns df on (df.vx_aln_data_defnsID = pax.from_city) 
			LEFT JOIN vx_aln_data_defns dt on  (dt.vx_aln_data_defnsID = pax.to_city) 
		        LEFT JOIN vx_aln_data_defns dfre on  (dfre.vx_aln_data_defnsID = pax.frequency)
			LEFT JOIN vx_aln_data_defns cou  on (cou.vx_aln_data_defnsID = pax.booking_country) 
                        LEFT JOIN vx_aln_data_defns cit on  (cit.vx_aln_data_defnsID = pax.booking_city) 
			LEFT JOIN  vx_aln_data_defns dca on (dca.vx_aln_data_defnsID = pax.carrier_code)	
			LEFT JOIN  vx_aln_data_defns dcab on (dcab.vx_aln_data_defnsID = pax.cabin)
			LEFT JOIN  vx_aln_data_defns ptc on (ptc.vx_aln_data_defnsID = pax.ptc)
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
		$feed->arrival_date = date('d/m/Y',$feed->arrival_date);
		$feed->dept_time = gmdate("H:i:s", $feed->dept_time);
		$feed->arrival_time = gmdate("H:i:s", $feed->arrival_time);

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


}

