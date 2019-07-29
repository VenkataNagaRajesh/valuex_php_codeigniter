<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketzone extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("marketzone_m");
		$this->load->model("trigger_m");
		$this->load->model('airports_m');
		$this->load->model('install_m');
		$this->load->model('client_m');
		$this->load->model('airline_m');
		$this->load->model('user_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('marketzone', $language);
		
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'market_name',
				'label' => $this->lang->line("market_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_marketzonename'
			),

			array(
                                'field' => 'desc',
                                'label' => $this->lang->line("desc"),
                                'rules' => 'trim|xss_clean|max_length[200]'
                        ),

			array(
				'field' => 'amz_level_id',
				'label' => $this->lang->line("level_type"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_valLevelType'
			),

			array(
                                'field' => 'airline_id',
                                'label' => $this->lang->line("airline_id"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valLevelType'
                        ),



   		       array(
                                'field' => 'amz_level_value[]',
                                'label' => $this->lang->line("amz_level_value"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valLevelValue'
                        ),

	                array(
                               'field' => 'amz_incl_id',
                                'label' => $this->lang->line("amz_incl_type"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),


			array(
                                'field' => 'amz_incl_value[]',
                                'label' => $this->lang->line("amz_incl_value"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),

			array(
                                'field' => 'amz_excl_id',
                                'label' => $this->lang->line("amz_excl_type"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),
			array(
                                'field' => 'amz_excl_value[]',
                                'label' => $this->lang->line("amz_excl_value"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        )
		);
		return $rules;
	}

  public function unique_marketzonename() {
	$id = $this->input->post("market_id");
	$airline_id = $this->input->post("airline_id");
                if((int)$id) {
                        $marketzone = $this->marketzone_m->get_order_by_marketzone(array("market_name" => $this->input->post("market_name"),"airline_id" => $airline_id, "market_id !=" => $id));
                        if(count($marketzone)) {
                                $this->form_validation->set_message("unique_marketzonename", "%s already exists");
                                return FALSE;
                        }
                        return TRUE;
                } else {
                        $marketzone = $this->marketzone_m->get_order_by_marketzone(array("market_name" => $this->input->post("market_name"),"airline_id" => $airline_id));

                        if(count($marketzone)) {
                                $this->form_validation->set_message("unique_marketzonename", "%s already exists");
                                return FALSE;
                        }
                        return TRUE;
                }
        }





   function valLevelType($post_string){
          if($post_string == '0'){
                 $this->form_validation->set_message("valLevelType", "%s is required");
                  return FALSE;
           }else{
                  return TRUE;
           }
        }

        function valLevelValue($post_array){
          if(count($post_array) < 1){
                 $this->form_validation->set_message("valLevelValue", "%s is required");
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
				'assets/dist/themes/default/style.min.css',
                        ),
                        'js' => array(
				'assets/treeview/simpleTree.js',
                                'assets/select2/select2.js',
				'assets/dist/jstree.min.js'
                        )
                );


	        if(!empty($this->input->post('market_id'))){
                  $this->data['marketID'] = $this->input->post('market_id');
                } else {
                  $this->data['marketID'] = 0;
                }
                if(!empty($this->input->post('amz_level_id'))){
                $this->data['levelID'] = $this->input->post('amz_level_id');
                } else {
                  $this->data['levelID'] = 0;
                }
                if(!empty($this->input->post('amz_incl_id'))){
                   $this->data['inclID'] = $this->input->post('amz_incl_id');
                } else {
                  $this->data['inclID'] = 0;
                }
                if(!empty($this->input->post('amz_excl_id'))){
                $this->data['exclID'] = $this->input->post('amz_excl_id');
                } else {
                    $this->data['exclID'] = 0;
                }

		if(!empty($this->input->post('active'))){
                $this->data['active'] = $this->input->post('active');
                } else {
                    $this->data['active'] = '1';
                }


		$userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
		if($userTypeID == 2){
                        $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
                           } else {
                   $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }
        if($this->session->userdata('usertypeID') == 2){ 
		  $this->data['marketzones'] = $this->marketzone_m->get_marketzones(null,$this->session->userdata('login_user_airlineID'));
		} else {
		  $this->data['marketzones'] = $this->marketzone_m->get_marketzones();
		}
		//$this->data['aln_datatypes'] = $this->marketzone_m->getAlnDataTYpes();
		$types = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
		  foreach($types as $type){
			$this->data['aln_datatypes'][$type->vx_aln_data_typeID] = $type->alias;
		  }

		if($userTypeID == 2){
		$this->data['treedata'] = $this->marketzone_m->getAirportsMarketData($this->session->userdata('login_user_airlineID'));
		} else {

			 $this->data['treedata'] = $this->marketzone_m->getAirportsMarketData();
		}
		$this->data["subview"] = "marketzone/index";
		$this->data['reconfigure'] =  $this->trigger_m->get_trigger_time('VX_aln_market_zone');
		$this->load->view('_layout_main', $this->data);

	}

	public function save() {

		if($_POST) {

			$market_id = $this->input->post("market_id");
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$json['status'] = validation_errors();
			} else {
				$date_now = time(); 
				$array["market_name"] = $this->input->post("market_name");
				$array['description'] = $this->input->post("desc");
				$array["amz_level_id"] = $this->input->post("amz_level_id");
				$array["amz_level_name"] = implode(',',$this->input->post("amz_level_value"));
				$array["amz_incl_id"] = $this->input->post("amz_incl_id");
				$array["amz_incl_name"] = implode(',',$this->input->post("amz_incl_value"));
				$array["amz_excl_id"] = $this->input->post("amz_excl_id");
				$array["amz_excl_name"] = implode(',',$this->input->post("amz_excl_value"));
				$array['airline_id'] = $this->input->post("airline_id");
				 if( $market_id) {
					$array["modify_date"] = $date_now;
					$array["modify_userID"] = $this->session->userdata('loginuserID');
					$editid = $this->marketzone_m->update_marketzone($array, $market_id);
					$json['action'] = 'edit';
			 	  } else {	
					$array["create_date"] = $date_now;
					$array["modify_date"] = $date_now;
					$array["create_userID"] = $this->session->userdata('loginuserID');
			        	$array["modify_userID"] = $this->session->userdata('loginuserID');
					$newid = $this->marketzone_m->insert_marketzone($array);
					$json['action'] = 'add';
				 }
				
			      // insert entry in trigger table for mapping table generation
	
				$tarray['table_name'] = 'VX_aln_market_zone';
				$tarray['create_date'] = $date_now;
				$tarray['modify_date'] = $date_now;
				$tarray['create_userID'] = $this->session->userdata('loginuserID');
				$tarray['modify_userID'] = $this->session->userdata('loginuserID');
				$tarray['isReconfigured'] = '1';
			
			        $this->trigger_m->insert_trigger($tarray);

				$json['reconfigure'] =  $this->trigger_m->get_trigger_time('VX_aln_market_zone');
				$json['has_reconf_perm'] = permissionChecker('marketzone_reconfigure');
				$json['status'] = "success";
			  }


                }else {

			$json['status'] = "no data";
		}

		 $this->output->set_content_type('application/json');
                 $this->output->set_output(json_encode($json));
	}




	public function getMarketZoneData() {
		$id = $this->input->post('market_id');
		if((int)$id) {
           		$mktzone = $this->marketzone_m->get_single_marketzone(array('market_id' => $id));

		}
		 		
			$this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode($mktzone));
		

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


		$userTypeID = $this->session->userdata('usertypeID');
        $userID = $this->session->userdata('loginuserID');

		//$this->data['aln_datatypes'] = $this->marketzone_m->getAlnDataTYpes();
		$types = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
		  foreach($types as $type){
			$this->data['aln_datatypes'][$type->vx_aln_data_typeID] = $type->alias;
		  }
          if($userTypeID == 2){
             $this->data['airlines'] = $this->airline_m->getClientAirline($userID);
          } else {
             $this->data['airlines'] = $this->airline_m->getAirlinesData();
          }

		 $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $this->data['marketzone'] = $this->marketzone_m->get_single_marketzone(array('market_id' => $id));
            if($this->data['marketzone']) {
                if($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "/marketzone/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else { 
			   $date_now = time();	
			    $array["market_name"] = $this->input->post("market_name");
			    $array['description'] = $this->input->post("desc");
                            $array["amz_level_id"] = $this->input->post("amz_level_id");
			    $array["amz_level_name"] =  implode(',',$this->input->post("amz_level_value"));
                            $array["amz_incl_id"] = $this->input->post("amz_incl_id");
			    $array["amz_incl_name"] = implode(',',$this->input->post("amz_incl_value"));
                            $array["amz_excl_id"] = $this->input->post("amz_excl_id");
			    $array["amz_excl_name"] =  implode(',',$this->input->post("amz_excl_value"));
				$array['airline_id'] =  $this->input->post("airline_id");

                            $array["modify_date"] = $date_now;
			    $array["modify_userID"] = $this->session->userdata('loginuserID');

                            $this->marketzone_m->update_marketzone($array, $id);


			        $tarray['table_name'] = 'VX_aln_market_zone';
                                $tarray['create_date'] = $date_now;
				$tarray['modify_date'] = $date_now;
                                $tarray['create_userID'] = $this->session->userdata('loginuserID');
                                $tarray['isReconfigured'] = '1';
				$tarray['modify_userID'] = $this->session->userdata('loginuserID');

                                $this->trigger_m->insert_trigger($tarray);



                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                            redirect(base_url("marketzone/index"));
                    }

                } else {
                    $this->data["subview"] = "/marketzone/edit";
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
			$this->data['marketzone'] = $this->marketzone_m->get_marketzonename($id);
			if($this->data['marketzone']) {
				$this->marketzone_m->delete_marketzone($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("marketzone/index"));
			} else {
				redirect(base_url("marketzone/index"));
			}
		} else {
			redirect(base_url("marketzone/index"));
		}
	}




   public function getSubdataTypes(){
	
	$id = $this->input->post('id');
	$market_id = $this->input->post('market_id');
	$airline_id = $this->input->post('airline_id');
	if($this->input->post('sub_id')){
              $sub_id = $this->input->post('sub_id');
         }else{
             $sub_id = null;
        }
	if ( isset($id)){
		if($id == 17){
			$result = $this->marketzone_m->get_marketzones(null,$airline_id,array($market_id));
			
		   foreach ($result as $market) {                               
               echo "<option value=\"$market->market_id\">",$market->market_name,"</option>";
            }
		} else {
		  $result = $this->marketzone_m->getSubDataDefns($id);
	      $list = explode(',',$sub_id);
          // echo "<option value='0'>", SELECT,"</option>";
            foreach ($result as $defns) {                               
		if ( $id == 4 || $id == 5 ) {
			echo "<option value=\"$defns->vx_aln_data_defnsID\">",$defns->aln_data_value,"</option>";
		}else {
               		echo "<option value=\"$defns->vx_aln_data_defnsID\">",$defns->code,"</option>";

		}
            }
	    }
     }
   }

function getSubListForExcl() {

$id = $this->input->post('id');
	$market_id = $this->input->post('market_id');
        $airline_id = $this->input->post('airline_id');
	$level_id = $this->input->post('level_id');
	$level_value = $this->input->post('level_value');

        if($this->input->post('sub_id')){
              $sub_id = $this->input->post('sub_id');
         }else{
             $sub_id = null;
        }

		$result = array();
        if ( isset($id)){
                if($id == 17){
                        $result = $this->marketzone_m->get_marketzones(null,$airline_id);

                   foreach ($result as $market) {
               echo "<option value=\"$market->market_id\">",$market->market_name,"</option>";
            }
                } else {
			
                  foreach ($level_value as $level){
			$tenp = array();
			$temp = $this->marketzone_m->getChildsList($level,$id);
			$result = array_merge($result,$temp);	
		  }
              $list = explode(',',$sub_id);
          // echo "<option value='0'>", SELECT,"</option>";
            foreach ($result as $defns) {
                if ( $id == 4 || $id == 5 ) {
                        echo "<option value=\"$defns->vx_aln_data_defnsID\">",$defns->aln_data_value,"</option>";
                }else {
                        echo "<option value=\"$defns->vx_aln_data_defnsID\">",$defns->code,"</option>";

                }
            }
            }
     }

}
	 function active() {
                if(permissionChecker('marketzone_edit')) {
                        $id = $this->input->post('id');
                        $status = $this->input->post('status');
                        if($id != '' && $status != '') {
                                if((int)$id) {
                                        if($status == 'chacked') {
                                                $this->marketzone_m->update_marketzone(array('active' => 1), $id);
                                                echo 'Success';
                                        } elseif($status == 'unchacked') {
                                                $this->marketzone_m->update_marketzone(array('active' => 0), $id);
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



	public function view() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
                if ((int)$id) {
			$this->data['marketzone'] = $this->marketzone_m->getMarketZoneById($id);
                        //$this->data["marketzone"] = $this->marketzone_m->get_marketzonename($id);
                        if($this->data["marketzone"]) {
                                $this->data["subview"] = "marketzone/view";
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


	function deleteAlnDataDefVal(){
		 $type_id = htmlentities(escapeString($this->uri->segment(5)));
                $market_id = htmlentities(escapeString($this->uri->segment(4)));
		$aln_type_val = htmlentities(escapeString($this->uri->segment(3)));
	//	 $type_id = 1;$market_id = 1; $aln_type_val = 5;
		$result = $this->marketzone_m->get_marketzonename($market_id);
		if ($type_id == 1){
		   	$cur_level_value = explode(',',$result->amz_level_name);
			$field = "amz_level_name";
		} else if ($type_id == 2 ) {
			$cur_level_value = explode(',',$result->amz_incl_name);
			$field = "amz_incl_name";
		} else if ($type_id == 3 ) {
			$cur_level_value = explode(',',$result->amz_excl_name);
			$field = "amz_excl_name";
		}
	
		if (in_array($aln_type_val,$cur_level_value)) {
			  unset($cur_level_value[array_search($aln_type_val,$cur_level_value)]);
		}
		
		
		$array =  array($field => implode(',',$cur_level_value));
		
		$this->marketzone_m->update_marketzone(array($field => implode(',',$cur_level_value)), $market_id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));

                redirect(base_url("marketzone/edit/".$market_id));

	}

  function server_processing(){


$aColumns =  array('MainSet.market_id','MainSet.market_name','MainSet.airline_name','MainSet.lname', 'SubSet.levelname', 'MainSet.iname', 'SubSet.inclname','MainSet.ename', 'SubSet.exclname', 'MainSet.airlineID','SubSet.level_d_name', 'SubSet.incl_d_name' , 'SubSet.excl_d_name','MainSet.airline_full_name');

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
                                                  //      $sOrder .= " (s.order_no*-1) DESC ,";
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

                        if(!empty($this->input->get('marketID'))){
                     		 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'MainSet.market_id = '.$this->input->get('marketID');
                	}
                        if(!empty($this->input->get('levelID'))){
                      		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'MainSet.level_id = '.$this->input->get('levelID');
                	}

                        if(!empty($this->input->get('inclID'))){
	                      $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
        		      $sWhere .= 'MainSet.incl_id = '.$this->input->get('inclID');
               		 }
                        if(!empty($this->input->get('exclID'))){
                      		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'MainSet.excl_id = '.$this->input->get('exclID');
                	}

			if(!empty($this->input->get('active')) && $this->input->get('active') != '-1'){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.active = '.$this->input->get('active');
                        }else if ($this->input->get('active') == '0') {
				$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.active = '.$this->input->get('active');
			}

		 	if(!empty($this->input->get('airlineID'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.airlineID = '.$this->input->get('airlineID');
                        }

                $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
		if($userTypeID == 2){
			 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
			$sWhere .= 'MainSet.airlineID IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';			
                } 

$sQuery = "
SELECT SQL_CALC_FOUND_ROWS MainSet.market_id,MainSet.market_name,MainSet.lname, MainSet.iname, MainSet.ename , SubSet.inclname, SubSet.exclname, SubSet.levelname, MainSet.active ,MainSet.level_id, MainSet.incl_id, MainSet.excl_id,MainSet.airline_name, MainSet.airlineID,
SubSet.level_d_name, SubSet.incl_d_name , SubSet.excl_d_name, MainSet.airline_full_name

FROM
(
              select  mz.market_id, mz.market_name ,dtl.alias as lname,dti.alias as iname, dte.alias as ename , mz.active as active, 
			mz.amz_level_id as level_id, mz.amz_incl_id as incl_id, mz.amz_excl_id as excl_id , dd.code as airline_name, 
			dd.aln_data_value as airline_full_name,mz.airline_id as airlineID
	      from VX_aln_market_zone mz 
	      LEFT JOIN vx_aln_data_types dtl on (dtl.vx_aln_data_typeID = mz.amz_level_id) 
	      LEFT JOIN vx_aln_data_types dti on (dti.vx_aln_data_typeID = mz.amz_incl_id)  
              LEFT JOIN vx_aln_data_types dte on (dte.vx_aln_data_typeID = mz.amz_excl_id)
	      LEFT JOIN vx_aln_data_defns dd ON dd.vx_aln_data_defnsID = mz.airline_id
) as MainSet

LEFT JOIN (
		select
    			FirstSet.market_id, FirstSet.level as levelname, ThirdSet.excl as exclname, SecondSet.incl as inclname, FirstSet.level_d_name, SecondSet.incl_d_name , ThirdSet.excl_d_name
		from 
			(         

				 SELECT        m.market_id  as market_id  , 
						COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(mm.market_name) )  AS level , COALESCE(group_concat(c.aln_data_value),group_concat(mm.market_name) ) as level_d_name
						FROM VX_aln_market_zone m 
						LEFT OUTER JOIN  vx_aln_data_defns c ON 
						(find_in_set(c.vx_aln_data_defnsID, m.amz_level_name) AND m.amz_level_id in (1,2,3,4,5)) 
						LEFT OUTER JOIN  VX_aln_market_zone mm  
						ON (find_in_set(mm.market_id, m.amz_level_name) AND m.amz_level_id = 17) group by m.market_id
 	   
			) as FirstSet  
		LEFT join 

			(          
				 SELECT        m.market_id  as market_id  , 
                                                COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(mm.market_name) )  AS incl, COALESCE(group_concat(c.aln_data_value),group_concat(mm.market_name) ) as incl_d_name
                                                FROM VX_aln_market_zone m 
                                                LEFT OUTER JOIN  vx_aln_data_defns c ON 
                                                (find_in_set(c.vx_aln_data_defnsID, m.amz_incl_name) AND m.amz_incl_id in (1,2,3,4,5)) 
                                                LEFT OUTER JOIN  VX_aln_market_zone mm  
                                                ON (find_in_set(mm.market_id, m.amz_incl_name) AND m.amz_incl_id = 17) group by m.market_id

			) as SecondSet
			on FirstSet.market_id = SecondSet.market_id
		LEFT JOIN 
			(

				  SELECT        m.market_id  as market_id  , 
                                                COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(mm.market_name) )  AS excl , COALESCE(group_concat(c.aln_data_value),group_concat(mm.market_name)) as excl_d_name 
                                                FROM VX_aln_market_zone m 
                                                LEFT OUTER JOIN  vx_aln_data_defns c ON 
                                                (find_in_set(c.vx_aln_data_defnsID, m.amz_excl_name) AND m.amz_excl_id in (1,2,3,4,5)) 
                                                LEFT OUTER JOIN  VX_aln_market_zone mm  
                                                ON (find_in_set(mm.market_id, m.amz_excl_name) AND m.amz_excl_id = 17) group by m.market_id


			) as ThirdSet

			on ThirdSet.market_id = FirstSet.market_id

) as SubSet
on MainSet.market_id = SubSet.market_id
 $sWhere $sOrder $sLimit";

//print_r($sQuery);exit;
                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                $marketzonescount = $this->marketzone_m->get_marketzones_count();

                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $rResultFilterTotal,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );

	$rownum = 1 + $_GET['iDisplayStart'];

                foreach($rResult as $marketzone){
			    $marketzone->cbox = "<input type='checkbox'  class='deleteRow' value='".$marketzone->market_id."'  /> #".$rownum ;
				$rownum++;
                        if(permissionChecker('marketzone_edit') ) {
				//$marketzone->action .= btn_edit('marketzone/edit/'.$marketzone->market_id, $this->lang->line('edit'));
				$marketzone->action .=  '<a href="#" class="btn btn-warning btn-xs mrg" id="edit_market"  data-placement="top" onclick="editzone('.$marketzone->market_id.')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
			}
			
			if (permissionChecker('marketzone_view') ) {
			       $marketzone->action .= btn_view('marketzone/view/'.$marketzone->market_id, $this->lang->line('view'));	
			}

			if (permissionChecker('marketzone_delete') ) {                                        				
			 $marketzone->action .= btn_delete('marketzone/delete/'.$marketzone->market_id, $this->lang->line('delete'));
			}
			$lstr = explode(',',$marketzone->levelname);
				
			$i = 1;
			$marketzone->levelname  = '';
			foreach($lstr as $label) {
   				$marketzone->levelname .= $label;

   				if($i < count($lstr)) {
      				$marketzone->levelname .= ", ";
  				 }

   				if($i%4==0) {
       				//$marketzone->levelname .= "<br>"; // or echo "\n";
   				}    
   				$i++;
			}

			$i = 1;
			$istr = explode(',',$marketzone->inclname);
                        $marketzone->inclname  = '';
                        foreach($istr as $label) {
                                $marketzone->inclname .= $label;
                        
                                if($i < count($istr)) {
                                $marketzone->inclname .= ", ";
                                 }
                        
                                if($i%4==0) {
                               // $marketzone->inclname .= "<br>"; // or echo "\n";
                                }    
                                $i++;
                        }


			$estr = explode(',',$marketzone->exclname);
			$i = 1;
                        $marketzone->exclname  = '';
                        foreach($estr as $label) {
                                $marketzone->exclname .= $label;
                        
                                if($i < count($estr)) {
                                $marketzone->exclname .= ", ";
                                 }
                        
                                if($i%4==0) {
                                //$marketzone->exclname .= "<br>"; // or echo "\n";
                                }    
                                $i++;
                        }



			$status = $marketzone->active;
			
                        $marketzone->active = "<div class='onoffswitch-small' id='".$marketzone->market_id."'>";
            $marketzone->active .= "<input type='checkbox' id='myonoffswitch".$marketzone->market_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
                        if($status){
                           $marketzone->active .= "checked='checked' >";
                        } else {
                           $marketzone->active .= ">";
                        }
                        $marketzone->active .= "<label for='myonoffswitch".$marketzone->market_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";

                        $output['aaData'][] = $marketzone;

                }
               if(isset($_REQUEST['export'])){
				  $columns = array('#','Marketzone Name','Airline','Level Type','Level Value','Inclusion Type','Inclusion Value','Exclusion Type','Exclusion Value');
				  $rows = array('market_id','market_name','airline_name','lname','levelname','iname','inclname','ename','exclname');
				  $this->exportall($output['aaData'],$columns,$rows);		
			  } else {	
				  echo json_encode( $output );
			  }
        }


	
public function delete_mz_bulk_records(){
$data_ids = $_REQUEST['data_ids'];
$data_id_array = explode(",", $data_ids); 
if(!empty($data_id_array)) {
    foreach($data_id_array as $id) {

		 $this->data['marketzone'] = $this->marketzone_m->get_marketzonename($id);
                        if($this->data['marketzone']) {
                                $this->marketzone_m->delete_marketzone($id);
			}
    }
}
}


}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
