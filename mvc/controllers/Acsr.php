<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acsr extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("airports_m");
		$this->load->model('marketzone_m');
		$this->load->model('acsr_m');
		$this->load->model('season_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('acsr', $language);	
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'orig_market_id',
				'label' => $this->lang->line("orig_market"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
			),
   		    array(
                		'field' => 'dest_market_id',
                		'label' => $this->lang->line("dest_market"),
                		'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                       ),
			array(
                 		'field' => 'flight_nbr_start',
                 		'label' => $this->lang->line("flight_nbr_start"),
                 		'rules' => 'trim|required|integer|max_length[200]|xss_clean'
            		),
			array(
          		       'field' => 'flight_nbr_end',
                 		'label' => $this->lang->line("flight_nbr_end"),
                 		'rules' => 'trim|required|integer|max_length[200]|xss_clean'
            		),
			array(
                 		'field' => 'frequency[]',
                 		'label' => $this->lang->line("frequency"),
                 		'rules' => 'trim|required|max_length[200]|xss_clean'
            		),


			array(
                		 'field' => 'flight_dep_date_start',
                		 'label' => $this->lang->line("flight_dep_date_start"),
                 		'rules' => 'trim|required|max_length[200]|xss_clean'
            		),
			array(
               			  'field' => 'flight_dep_date_end',
                 		'label' => $this->lang->line("flight_dep_date_end"),
                 		'rules' => 'trim|required|max_length[200]|xss_clean'
            		),
			array(
                                 'field' => 'flight_dep_start_hrs',
                                 'label' => $this->lang->line("flight_dep_time_start"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),

			array(
                                 'field' => 'flight_dep_start_mins',
                                 'label' => $this->lang->line("flight_dep_time_start"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),

                        array(
                                  'field' => 'flight_dep_end_hrs',
                                'label' => $this->lang->line("flight_dep_time_end"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),
                        array(
                                  'field' => 'flight_dep_end_mins',
                                'label' => $this->lang->line("flight_dep_time_end"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),


			 array(
                                'field' => 'upgrade_from_cabin_type',
                                'label' => $this->lang->line("upgrade_from"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),
                       array(
                                'field' => 'upgrade_to_cabin_type',
                                'label' => $this->lang->line("upgrade_to"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                       ),

			 array(
                                  'field' => 'future_use',
                                'label' => $this->lang->line("future_use"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),


			   array(
                                'field' => 'memp',
                                'label' => $this->lang->line("memp"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),
                       array(
                                'field' => 'min_bid_price',
                                'label' => $this->lang->line("min_bid_price"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                       ),

                         array(
                                  'field' => 'action_type',
                                'label' => $this->lang->line("action_type"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),

			array(
                                  'field' => 'season',
                                'label' => $this->lang->line("season"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),


		);
		return $rules;
	}
	
	function valMarket($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valMarket", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valOrigLevelValue($post_array){		
	  if(count($post_array) < 1){
		 $this->form_validation->set_message("valOrigLevelValue", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valDestLevel($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valDestLevel", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valDestLevelValue($post_array){        	
	  if(count($post_array) < 1){
		 $this->form_validation->set_message("valDestLevelValue", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	public function index() {

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


		if(!empty($this->input->post('orig_market_id'))){
		          $this->data['origmarketID'] = $this->input->post('orig_market_id');
        	} else {
          		$this->data['origmarketID'] = 0;
       		}
	        if(!empty($this->input->post('dest_market_id'))){
        		  $this->data['destmarketID'] = $this->input->post('dest_market_id');
        	} else {
         		 $this->data['destmarketID'] = 0;
        	}
		

		 if(!empty($this->input->post('from_cabin'))){
                          $this->data['fromcabin'] = $this->input->post('from_cabin');
                } else {
                         $this->data['fromcabin'] = 0;
                }

                 if(!empty($this->input->post('to_cabin'))){
                          $this->data['tocabin'] = $this->input->post('to_cabin');
                } else {
                         $this->data['tocabin'] = 0;
                }


                if(!empty($this->input->post('future_use'))){
                          $this->data['future_use'] = $this->input->post('future_use');
                } else {
                         $this->data['future_use'] = 1;
                }


		if(!empty($this->input->post('flight_nbr_start'))){
                          $this->data['nbr_start'] = $this->input->post('flight_nbr_start');
                }


		if(!empty($this->input->post('flight_dep_date_start'))){
                          $this->data['dep_date_start'] = date('d-m-Y',$this->input->post('flight_dep_date_start'));
                }

	
		if(!empty($this->input->post('flight_dep_date_end'))){
                          $this->data['dep_date_end'] = date('d-m-Y',$this->input->post('flight_dep_date_end'));
                }

		if(!empty($this->input->post('flight_nbr_end'))){
                          $this->data['nbr_end'] = $this->input->post('flight_nbr_end');
                }


		if(!empty($this->input->post('day'))){
                          $this->data['day'] = $this->input->post('day');
                } else {
                         $this->data['day'] = 0;
                }


		if(!empty($this->input->post('active'))){
                	$this->data['active'] = $this->input->post('active');
                } else {
                    	$this->data['active'] = '1';
                }


		 $this->data['marketzones'] = $this->marketzone_m->getMarketzones();
           	$this->data['cabin_type'] = $this->airports_m->getDefns('13'); // airline class types
           	$this->data['days_of_week'] = $this->airports_m->getDefns('14'); // days of week
           	$this->data['hrs'] = $this->acsr_m->time_dropdown('24');
           	$this->data['mins'] = $this->acsr_m->time_dropdown('60');
                $this->data['seasons'] = $this->season_m->getSeasonsList();
        	$this->data['action_types'] = $this->airports_m->getDefns('19');

		$this->data["subview"] = "acsr/index";
		$this->load->view('_layout_main', $this->data);		
	}

	public function add() {
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
	
	   $this->data['marketzones'] = $this->marketzone_m->getMarketzones();
	   $this->data['cabin_type'] = $this->airports_m->getDefns('13'); // airline class types
	   $this->data['days_of_week'] = $this->airports_m->getDefns('14'); // days of week
	   $this->data['hrs'] = $this->acsr_m->time_dropdown('24');
	   $this->data['mins'] = $this->acsr_m->time_dropdown('60');
		$this->data['seasons'] = $this->season_m->getSeasonsList();
	$this->data['action_types'] = $this->airports_m->getDefns('19');
	 
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "acsr/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array["orig_market_id"] = $this->input->post("orig_market_id");
				$array["dest_market_id"] = $this->input->post("dest_market_id");
				$array["flight_nbr_start"] = $this->input->post("flight_nbr_start");
				 $array["flight_nbr_end"] = $this->input->post("flight_nbr_end");
				$array["flight_dep_date_start"] = strtotime($this->input->post("flight_dep_date_start"));
				$array["flight_dep_date_end"] = strtotime($this->input->post("flight_dep_date_end"));
				$array['flight_dep_time_start'] = $this->input->post("flight_dep_start_hrs").':'.$this->input->post("flight_dep_start_mins");
				  $array['flight_dep_time_end'] = $this->input->post("flight_dep_end_hrs").':'.$this->input->post("flight_dep_end_mins");
				$array['frequency'] = implode(',',$this->input->post("frequency"));
				$array['season_id'] = $this->input->post("season");
				$array['upgrade_from_cabin_type'] = $this->input->post("upgrade_from_cabin_type");
				$array['upgrade_to_cabin_type'] = $this->input->post("upgrade_to_cabin_type");
				$array["future_use"] = $this->input->post("future_use");

				$array['action_type'] = $this->input->post("action_type");
                                $array['memp'] = $this->input->post("memp");
                                $array["min_bid_price"] = $this->input->post("min_bid_price");

				$array["create_date"] = time();
				$array["modify_date"] = time();
				$array["create_userID"] = $this->session->userdata('loginuserID');
			       $array["modify_userID"] = $this->session->userdata('loginuserID');
				$this->acsr_m->insert_acsr($array);
				
				
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("acsr/index"));
			}
		} else {
			$this->data["subview"] = "acsr/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit() {
      $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css',
                        'assets/datepicker/datepicker.css'						
                ),
                'js' => array(
                        'assets/select2/select2.js',
                        'assets/datepicker/datepicker.css'
                )
        );		


		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['rule'] = $this->acsr_m->get_single_acsr(array('acsr_id'=>$id));
			if($this->data['rule']) {

			 $this->data['marketzones'] = $this->marketzone_m->getMarketzones();
		           $this->data['cabin_type'] = $this->airports_m->getDefns('13'); // airline class types
		           $this->data['days_of_week'] = $this->airports_m->getDefns('14'); // days of week
           		   $this->data['hrs'] = $this->acsr_m->time_dropdown('24');
           		   $this->data['mins'] = $this->acsr_m->time_dropdown('60');
                	   $this->data['seasons'] = $this->season_m->getSeasonsList();
                           $this->data['action_types'] = $this->airports_m->getDefns('19');

				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) { 
						$this->data["subview"] = "acsr/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {
						

					$array["orig_market_id"] = $this->input->post("orig_market_id");
                                $array["dest_market_id"] = $this->input->post("dest_market_id");
                                $array["flight_nbr_start"] = $this->input->post("flight_nbr_start");
                                 $array["flight_nbr_end"] = $this->input->post("flight_nbr_end");
                                $array["flight_dep_date_start"] = strtotime($this->input->post("flight_dep_date_start"));
                                $array["flight_dep_date_end"] = strtotime($this->input->post("flight_dep_date_end"));
                                $array['flight_dep_time_start'] = $this->input->post("flight_dep_start_hrs").':'.$this->input->post("flight_dep_start_mins");
                                  $array['flight_dep_time_end'] = $this->input->post("flight_dep_end_hrs").':'.$this->input->post("flight_dep_end_mins");
                                $array['frequency'] = implode(',',$this->input->post("frequency"));
                                $array['season_id'] = $this->input->post("season");
                                $array['upgrade_from_cabin_type'] = $this->input->post("upgrade_from_cabin_type");
                                $array['upgrade_to_cabin_type'] = $this->input->post("upgrade_to_cabin_type");
                                $array["future_use"] = $this->input->post("future_use");

                                $array['action_type'] = $this->input->post("action_type");
                                $array['memp'] = $this->input->post("memp");
                                $array["min_bid_price"] = $this->input->post("min_bid_price");

                                $array["create_date"] = time();
                                $array["modify_date"] = time();
                                $array["create_userID"] = $this->session->userdata('loginuserID');
                               $array["modify_userID"] = $this->session->userdata('loginuserID');

                                $this->acsr_m->update_acsr($array, $id);


						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("acsr/index"));
					}
				} else {
					$this->data["subview"] = "acsr/edit";
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
			$this->data['rule'] = $this->acsr_m->get_single_acsr(array('acsr_id'=>$id));
			if($this->data['rule']) {
				$this->acsr_m->delete_acsr($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("acsr/index"));
			} else {
				redirect(base_url("acsr/index"));
			}
		} else {
			redirect(base_url("acsr/index"));
		}
	}
	
  
   function active() {
		if(permissionChecker('acsr_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				if((int)$id) {
					$data['modify_userID'] = $this->session->userdata('loginuserID');
					$data['modify_date'] = time();
					if($status == 'chacked') {
						$data['active'] = 1 ;
						$this->acsr_m->update_acsr($data, $id);
						echo 'Success';
					} elseif($status == 'unchacked') {
						$data['active'] = 0 ;
						$this->acsr_m->update_acsr($data, $id);
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
		} else {
			echo "Error";
		}
	}
	

function time_dropdown($val) {
		for($i=0;$i<$val;$i++){
			if($i<10 && strlen($i)<2)
    			{
        			$num = '0'.$i;
    			}
			$hrs[$num] = $num;
		}
	return $hrs;
}


	function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  
				
	    $aColumns = array('MainSet.acsr_id' ,'MainSet.orig_mkt_name', 'MainSet.dest_mkt_name', 
        'MainSet.flight_dep_date_start', 'MainSet.flight_dep_date_end', 'MainSet.flight_dep_time_start', 'MainSet.flight_dep_time_end', 
        'MainSet.flight_nbr', 'MainSet.from_cabin', 'MainSet.to_cabin', 'Subset.frequency', 'MainSet.future_use', 'MainSet.active',
        'MainSet.orig_market_id', 'MainSet.dest_market_id','MainSet.upgrade_from_cabin_type', 'MainSet.upgrade_to_cabin_type',
	'MainSet.flight_nbr_start','MainSet.flight_nbr_end');
	
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

                        if(!empty($this->input->get('origID'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.orig_market_id = '.$this->input->get('origID');
                        }
                        if(!empty($this->input->get('destID'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.dest_market_id = '.$this->input->get('destID');
                        }


                        if(!empty($this->input->get('active')) && $this->input->get('active') != '-1'){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.active = '.$this->input->get('active');
                        }else if ($this->input->get('active') == '0') {
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.active = '.$this->input->get('active');
                        }

			
			if(!empty($this->input->get('fromCabin'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.upgrade_from_cabin_type = '.$this->input->get('fromCabin');
                        }
                        if(!empty($this->input->get('toCabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.upgrade_to_cabin_type = '.$this->input->get('toCabin');
                        }

			if(!empty($this->input->get('futureuse'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.future_use = '.$this->input->get('futureuse');
                        }


		        if(!empty($this->input->get('nbrStart'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_nbr_start = '.$this->input->get('nbrStart');
                        }


			if(!empty($this->input->get('nbrEnd'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_nbr_end = '.$this->input->get('nbrEnd');
                        }


                       if(!empty($this->input->get('depDateStart'))){
                               $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_dep_date_start = '.strtotime($this->input->get('depDateStart'));
                        }


                        if(!empty($this->input->get('depDateEnd'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_dep_date_end = '.strtotime($this->input->get('depDateEnd'));
                        }



			if(!empty($this->input->get('startHrs')) && !empty($this->input->get('startMins')) 
					&& $this->input->get('startHrs') != '-1' && $this->input->get('startMins') != '-1'){
                               $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_dep_time_start = "'.$this->input->get('startHrs').':'.$this->input->get('startMins').'"';
                        }


			 if(!empty($this->input->get('endHrs')) && !empty($this->input->get('endMins'))
				&& $this->input->get('endHrs') != '-1' && $this->input->get('endMins') != '-1'){
                               $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_dep_time_end = "'.$this->input->get('endHrs').':'.$this->input->get('endMins').'"';
                        }



			if(!empty($this->input->get('day') )){
				$days = explode(',',$this->input->get('day'));
				foreach($days as $day){
					$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
					$sWhere .= 'FIND_IN_SET("'.$day.'",Subset.dayslist)';
				}
				
			}


		$sQuery = "

SELECT  SQL_CALC_FOUND_ROWS MainSet.acsr_id,MainSet.orig_mkt_name, MainSet.dest_mkt_name, 
        MainSet.flight_dep_date_start, MainSet.flight_dep_date_end, MainSet.flight_dep_time_start, MainSet.flight_dep_time_end, 
        MainSet.flight_nbr, MainSet.from_cabin, MainSet.to_cabin, Subset.frequency, MainSet.future_use, MainSet.active,
        MainSet.orig_market_id, MainSet.dest_market_id , Subset.dayslist , MainSet.upgrade_from_cabin_type, MainSet.upgrade_to_cabin_type,
        MainSet.flight_nbr_start, MainSet.flight_nbr_end ,  MainSet.action_type, MainSet.action_typ, MainSet.season_name,MainSet.min_bid_price,

	MainSet.memp

FROM (     

              select acsr_id, ex.orig_market_id , ex.dest_market_id ,oz.market_name as orig_mkt_name, dz.market_name as dest_mkt_name, 
              flight_dep_date_start, flight_dep_date_end, flight_dep_time_start, flight_dep_time_end, CONCAT(flight_nbr_start,'-',flight_nbr_end) 
              as flight_nbr,fc.aln_data_value as from_cabin , tc.aln_data_value as to_cabin, future_use, ex.active , 
              ex.upgrade_from_cabin_type, ex.upgrade_to_cabin_type  ,ex.flight_nbr_start, ex.flight_nbr_end,
	      ex.action_type, at.aln_data_value as action_typ,ex.memp, ex.season_id, ss.season_name, ex.min_bid_price
              from VX_aln_auto_confirm_setup_rules ex 

              LEFT JOIN VX_aln_market_zone oz on (oz.market_id = ex.orig_market_id) 
              LEFT JOIN VX_aln_market_zone dz on (dz.market_id = ex.dest_market_id)  
	      LEFT JOIN  vx_aln_data_defns at on (at.vx_aln_data_defnsID = ex.action_type ) 
	      LEFT JOIN  VX_aln_season ss on (ss.VX_aln_seasonID = ex.season_id ) 
              LEFT JOIN  vx_aln_data_defns fc on (fc.vx_aln_data_defnsID = ex.upgrade_from_cabin_type ) 
              LEFT JOIN vx_aln_data_defns tc on (tc.vx_aln_data_defnsID  = ex.upgrade_to_cabin_type)) as MainSet 
		
LEFT JOIN (
              select
                        FirstSet.frequency,FirstSet.acsr_id, FirstSet.dayslist
                from 
                        (         
                              select mf.acsr_id ,group_concat(c.aln_data_value) as frequency  , mf.frequency as dayslist

                             from  VX_aln_auto_confirm_setup_rules mf 
                             LEFT join vx_aln_data_defns c on find_in_set(c.vx_aln_data_defnsID, mf.frequency) group by mf.acsr_id 
                        ) as FirstSet  
) as Subset on (MainSet.acsr_id = Subset.acsr_id) 


		$sWhere			
		$sOrder
		$sLimit	"; 

//	print_r($sQuery); exit;
	$rResult = $this->install_m->run_query($sQuery);
	$sQuery = "SELECT FOUND_ROWS() as total";
	$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
			
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $rResultFilterTotal,
		"iTotalDisplayRecords" => $rResultFilterTotal,
		"aaData" => array()
	  );
	  foreach($rResult as $rule){	
		$rule->flight_dep_date_start = date('d-m-Y',$rule->flight_dep_date_start);
               $rule->flight_dep_date_end = date('d-m-Y',$rule->flight_dep_date_end);
		  
		  $rule->future_use = ($rule->future_use)?"yes":"no";
		  
		  if(permissionChecker('acsr_edit')){ 			
			$rule->action = btn_edit('acsr/edit/'.$rule->acsr_id, $this->lang->line('edit'));
		  }
		  if(permissionChecker('acsr_delete')){
		   $rule->action .= btn_delete('acsr/delete/'.$rule->acsr_id, $this->lang->line('delete'));			 
		  }
			$status = $rule->active;
			$rule->active = "<div class='onoffswitch-small' id='".$rule->acsr_id."'>";
            $rule->active .= "<input type='checkbox' id='myonoffswitch".$rule->acsr_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $rule->active .= " checked >";
			} else {
			   $rule->active .= ">";
			}	
			
			$rule->active .= "<label for='myonoffswitch".$rule->acsr_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
			
			
			$output['aaData'][] = $rule;				
		}
		echo json_encode( $output );
	}


}
