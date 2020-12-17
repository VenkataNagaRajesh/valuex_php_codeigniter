<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_cabin_class extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('airline_cabin_class_m');
		$this->load->model('airline_cabin_def_m');
		$this->load->model('airline_cabin_m');
		$this->load->model('airports_m');
		$this->load->model('airline_m');
		$this->load->model('user_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('airline_cabin_class', $language);
		$this->data['icon'] = $this->menu_m->getMenu(array("link"=>"airline_cabin_class"))->icon;
	}

	protected function rules() {
		$rules = array(
	
                        array(
                                'field' => 'carrier',
                                'label' => $this->lang->line("carrier"),
                                'rules' => 'trim|required|xss_clean|max_length[60]|callback_valLevelType'
                        ),


		);
		return $rules;
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
                                'assets/select2/css/select2-bootstrap.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js'
                        )
                );


	        if(!empty($this->input->post('carrier'))){
                  $this->data['carrier'] = $this->input->post('carrier');
                }else if($this->session->userdata('roleID') != 1){
					$this->data['carrier'] = $this->session->userdata('default_airline');
				} else {
                  $this->data['carrier'] = 0;
                }



                if(!empty($this->input->post('airline_cabin'))){
                $this->data['cabinID'] = $this->input->post('airline_cabin');
                } else {
                  $this->data['cabinID'] = 0;
                }

		if(!empty($this->input->post('active'))){
                $this->data['active'] = $this->input->post('active');
                } else {
                    $this->data['active'] = '1';
                }



            //$this->data['airlinecabins'] = $this->airports_m->getDefnsCodesListByType('13');


		  $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
            if($roleID != 1){
						 $this->data['airlinesdata'] = $this->user_m->getUserAirlines($userID);	   
						   }else {
                   $this->data['airlinesdata'] = $this->airline_m->getAirlinesData();
                }

		$this->data["subview"] = "airline_cabin_class/index";
		$this->load->view('_layout_main', $this->data);

	}

	public function add() {

	   $this->data['headerassets'] = array(
                        'css' => array(
                                'assets/select2/css/select2.css',
                                'assets/select2/css/select2-bootstrap.css',
                                'assets/fselect/fSelect.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js',
                                'assets/fselect/fSelect.js',
                        )
                );



	    $this->data['airlinecabins'] = $this->airline_cabin_m->getAirlineCabins();
	    $this->data['deflist'] = $this->airline_cabin_class_m->getListOfMappedCarriers();


                 $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID != 1){
						 $this->data['airlinesdata'] = $this->user_m->getUserAirlines($userID);	   
						   }else {
                        $this->data['airlinesdata'] = $this->airline_m->getAirlinesData();
                }


		$this->data['mapped_airlines'] = $this->airline_cabin_class_m->get_mapped_airlines();

		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "airline_cabin_class/add";
				$this->load->view('_layout_main', $this->data);
			} else {

				foreach($this->input->post("airdata") as $k=>$v) {
					if ($v['cabin'] != 0 && $v['order'] != '' && $v['order'] != 0 ) {
						$array["carrier"] = $this->input->post("carrier");
                                		$array["airline_class"] = $k;
                                		$array["airline_cabin"] = $v['cabin'];
						$array['is_revenue'] = $v['is_revenue'];
						$array['order'] = $v['order'];
						$array['rbd_markup'] = $v['rbd_markup'] ? $v['rbd_markup'] : 0;
                                		$array["create_date"] = time();
                                		$array["modify_date"] = time();
                                		$array["create_userID"] = $this->session->userdata('loginuserID');
                                		$array["modify_userID"] = $this->session->userdata('loginuserID');
                                		$array["active"] = 1;
                                		$this->airline_cabin_class_m->insert_airline_cabin_class($array);
					}
				}
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("airline_cabin_class/index"));
			}
		} else {
			$this->data["subview"] = "airline_cabin_class/add";
			$this->load->view('_layout_main', $this->data);
		}
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
		




		 $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID != 1){
						 $this->data['airlinesdata'] = $this->user_m->getUserAirlines($userID);	   
						   }else {
                   $this->data['airlinesdata'] = $this->airline_m->getAirlinesData();
                }


		 $id = htmlentities(escapeString($this->uri->segment(3)));

		$this->data['carrier_details'] = $this->airline_m->get_single_airline(array('vx_aln_data_defnsID' => $id));


        if((int)$id) {
            $this->data['airline'] = $this->airline_cabin_class_m->checkCarrierDataByID($id);
		$this->data['airlinecabins'] = $this->airline_cabin_def_m->getCabinsDataForCarrier($id);
            if(count($this->data['airline']) > 0) {
                if($_POST) {
                    /*$rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "/airline_cabin_class/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else { */
				$this->airline_cabin_class_m->delete_airline_cabin_class(array('carrier'=>$id));
				foreach($this->input->post("airdata") as $k=>$v) {
                                       if ($v['cabin'] != 0 && $v['order'] != '' && $v['order'] != 0 ) {
                                                $array["carrier"] = $this->input->post("carrier");
                                                $array["airline_class"] = $k;
						//$exist = $this->airline_cabin_class_m->checkClassDataForCarrierID($v['map_id']);
                                                $array["airline_cabin"] = $v['cabin'];
                                                $array['is_revenue'] = $v['is_revenue'];
                                                $array['order'] = $v['order'];
						$array['rbd_markup'] = $v['rbd_markup'] ? $v['rbd_markup'] : 0;
                                                $array["create_date"] = time();
                                                $array["modify_date"] = time();
                                                $array["create_userID"] = $this->session->userdata('loginuserID');
                                                $array["modify_userID"] = $this->session->userdata('loginuserID');
                                                $array["active"] = 1;
						$this->airline_cabin_class_m->insert_airline_cabin_class($array);

							
                                        }
                                }


                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                            redirect(base_url("airline_cabin_class/index"));
                   // }

                } else {
                    $this->data["subview"] = "/airline_cabin_class/edit";
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
			$this->data['airline_cabin'] = $this->airline_cabin_class_m->checkCarrierDataByID($id);
			if($this->data['airline_cabin']) {
				$this->airline_cabin_class_m->delete_airline_cabin_class(array('carrier'=>$id));
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("airline_cabin_class/index"));
			} else {
				redirect(base_url("airline_cabin_class/index"));
			}
		} else {
			redirect(base_url("airline_cabin_class/index"));
		}
	}




	 function active() {
                if(permissionChecker('airline_cabin_class_edit')) {
                        $id = $this->input->post('id');
                        $status = $this->input->post('status');
                        if($id != '' && $status != '') {
                                if((int)$id) {
                                        if($status == 'checked') {
                                                $this->airline_cabin_class_m->update_airline_cabin_class(array('active' => 1), $id);
                                                echo 'Success';
                                        } elseif($status == 'unchecked') {
                                                $this->airline_cabin_class_m->update_airline_cabin_class(array('active' => 0), $id);
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
                        $this->data["airline_cabin"] = $this->airline_cabin_class_m->getCarrierMapDataByID($id);

                        if($this->data["airline_cabin"]) {
                                $this->data["subview"] = "airline_cabin_class/view";
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



  function server_processing(){

	    $aColumns =  array('cm.map_id','ac.code','def.cabin','airline_class','cm.is_revenue','cm.order','cm.rbd_markup','cm.active','ac.aln_data_value','def.desc');
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

                        if(!empty($this->input->get('carrier'))){
                     		 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'cm.carrier = '.$this->input->get('carrier');
                	}
                        if(!empty($this->input->get('cabinID'))){
                      		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'cm.airline_cabin = '.$this->input->get('cabinID');
                	}

                       if(!empty($this->input->get('active')) && $this->input->get('active') != '-1'){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'cm.active = '.$this->input->get('active');
                        }else if ($this->input->get('active') == '0') {
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'cm.active = '.$this->input->get('active');
                        }



               $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID != 1){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'cm.carrier IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';                  
                }



$sQuery = " SELECT SQL_CALC_FOUND_ROWS cm.map_id, airline_class,  ac.code as carrier_name, cm.carrier , 
        def.cabin as airline_cabin,  cm.active , cm.is_revenue, cm.order, cm.rbd_markup
        from VX_airline_cabin_class cm 
        LEFT JOIN VX_data_defns ac on (ac.vx_aln_data_defnsID = cm.carrier ) 
       INNER JOIN VX_airline_cabin_def def on (def.carrier = cm.carrier )  
        INNER JOIN VX_data_defns cab on (cab.alias = def.level and cab.aln_data_typeID = 13 and cm.airline_cabin = cab.vx_aln_data_defnsID)
 $sWhere $sOrder $sLimit";
                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                $airlinecabinsmapcnt = $this->airline_cabin_m->get_airline_cabin_map_count();

                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $rResultFilterTotal,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );

		
	 $rownum = 1 + $_GET['iDisplayStart'];	
                foreach($rResult as $list){
			$list->chkbox = "<input type='checkbox'  class='deleteRow' value='".$list->map_id."'  /> ".$rownum ;
                                $rownum++;
		   $list->is_revenue = ($list->is_revenue)?"yes":"no";
                        if(permissionChecker('airline_cabin_class_edit') ) {
				$list->action = btn_edit('airline_cabin_class/edit/'.$list->carrier, $this->lang->line('edit'));
			}
			
			if (permissionChecker('airline_cabin_class_view') ) {
			       $list->action .= btn_view('airline_cabin_class/view/'.$list->carrier, $this->lang->line('view'));	
			}

			if (permissionChecker('airline_cabin_class_delete') ) {                                        				
			 $list->action .= btn_delete('airline_cabin_class/delete/'.$list->carrier, $this->lang->line('delete'));

			}

			$status = $list->active;
			
                        $list->active = "<div class='onoffswitch-small' id='".$list->map_id."'>";
            		$list->active .= "<input type='checkbox' id='myonoffswitch".$list->map_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
                        if($status){
                           $list->active .= "checked='checked' >";
                        } else {
                           $list->active .= ">";
                        }
                        $list->active .= "<label for='myonoffswitch".$list->map_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";

                        $output['aaData'][] = $list;

                }
                if(isset($_REQUEST['export'])){
				  $columns = array('#','Carrier','Carrier Cabin','Carrier Class','Revenue','Order');
				  $rows = array("map_id","carrier_name","airline_cabin","airline_class","is_revenue","order");
				  $this->exportall($output['aaData'],$columns,$rows);		
				} else {	
				  echo json_encode( $output );
				}
        }



public function getCabinDataFromCarrier(){

        $carrier = $this->input->post('carrier');
	if($carrier) {
		$result = $this->airline_cabin_def_m->getCabinsDataForCarrier($carrier,1);
			echo "<option value=\"0\">",Cabin,"</option>";
			 foreach ($result as $defns) {
                        echo "<option value=\"$defns->vx_aln_data_defnsID\">",$defns->cabin,"</option>";

                	}
            } else {
		echo "<option value=\"0\">",Cabin,"</option>";

	   }

}

public function getCabinLevelDataForCarrier() {


	 $carrier = $this->input->post('carrier');
	 $result = $this->airline_cabin_def_m->getCabinsDataForCarrier($carrier,1);
	$ret = array();
	foreach($result as $res ) {
		$ret['span']['flevel'.$res->level] =  $res->cabin;
		$ret['span']['tlevel'.$res->level] =  $res->cabin;
	}

	$result1 = $result;
// Y= 4, W= 3, C = 2, F = 1
	foreach($result as $r1) {
		foreach($result1 as $r2 ) {
			if($r1->level > $r2->level) {
				$ret['level']['level'.$r1->level.'-level'.$r2->level] = $r1->cabin.'-'.$r2->cabin;
			}
		}
	}

                 $this->output->set_content_type('application/json');
                 $this->output->set_output(json_encode($ret));

}



public function delete_carrier_map_bulk_records(){
$data_ids = $_REQUEST['data_ids'];
$data_id_array = explode(",", $data_ids);
if(!empty($data_id_array)) {
    foreach($data_id_array as $id) {
		 $this->data['airline_cabin'] = $this->airline_cabin_class_m->get_airline_cabin_classbyid($id);
                        if($this->data['airline_cabin']) {
                                $this->airline_cabin_class_m->delete_airline_cabin_class(array('map_id'=>$id));
                        }
    }
}
}


}

