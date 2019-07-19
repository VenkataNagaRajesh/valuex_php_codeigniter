<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_status extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('event_status_m');
		$this->load->model('airports_m');
		$this->load->model('user_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('event_status', $language);
		$this->data['icon'] = $this->menu_m->getMenu(array("link"=>"event_status"))->icon;
	}

	protected function rules() {
		$rules = array(
	
			array(
				'field' => 'current_status',
				'label' => $this->lang->line("current_status"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valLevelType'
			),
		
			 array(
                                'field' => 'next_status[]',
                                'label' => $this->lang->line("next_status"),
                                'rules' => 'trim|required|xss_clean|max_length[60]|callback_valLevelValue'
                        ),


			array(
				'field' => 'event_id',
				'label' => $this->lang->line("event_id"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_valLevelType'
			),
			array(
                                'field' => 'isInternalStatus',
                                'label' => $this->lang->line("isInternalStatus"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valLevelType'
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
                                'assets/select2/css/select2-bootstrap.css',
                                'assets/fselect/fSelect.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js',
                                'assets/fselect/fSelect.js',
                        )
                );


	        if(!empty($this->input->post('event_id'))){
                  $this->data['event_id'] = $this->input->post('event_id');
                } else {
                  $this->data['event_id'] = 0;
                }


                if(!empty($this->input->post('current_status'))){
                $this->data['current_status'] = $this->input->post('current_status');
                } else {
                  $this->data['current_status'] = 0;
                }

		if(!empty($this->input->post('active'))){
                $this->data['active'] = $this->input->post('active');
                } else {
                    $this->data['active'] = '1';
                }


		 $this->data['booking_status'] = $this->airports_m->getDefnsListByType('20');
		$this->data["subview"] = "event_status/index";
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

		$this->data['booking_status'] = $this->airports_m->getDefnsListByType('20'); 
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "event_status/add";
				$this->load->view('_layout_main', $this->data);
			} else {


				$array['current_status'] = $this->input->post("current_status");
                                $array["event_id"] = $this->input->post("event_id");
                                $array["isInternalStatus"] =  $this->input->post("isInternalStatus");

				$next_status = $this->input->post("next_status");
				foreach ($next_status as $status ) {
					$array['next_status'] = $status;
					if ($this->event_status_m->checkEventStatus($array)){
						$array["create_date"] = time();
						$array["modify_date"] = time();
						$array["create_userID"] = $this->session->userdata('loginuserID');
			        		$array["modify_userID"] = $this->session->userdata('loginuserID');
						$this->event_status_m->insert_event_status($array);
					}
				}
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("event_status/index"));
			}
		} else {
			$this->data["subview"] = "event_status/add";
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
		

	$this->data['booking_status'] = $this->airports_m->getDefnsListByType('20');
		 $arr['event_id'] = htmlentities(escapeString($this->uri->segment(3)));
		 $arr['current_status']  = htmlentities(escapeString($this->uri->segment(4)));
		
        if((int)$arr['event_id'] && (int)$arr['current_status']) {
            $this->data['es'] = $this->event_status_m->get_single_event_status($arr);
            if($this->data['es']) {
                if($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "/event_status/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else { 
                                $array['current_status'] = $this->input->post("current_status");
                                $array["event_id"] = $this->input->post("event_id");
                                $array["isInternalStatus"] =  $this->input->post("isInternalStatus");

                                $next_status = $this->input->post("next_status");
				$this->event_status_m->delete_event_status($arr['event_id'] ,$arr['current_status']);
                                foreach ($next_status as $status ) {
                                        $array['next_status'] = $status;
					$array["create_date"] = time();
                                                $array["modify_date"] = time();
                                                $array["create_userID"] = $this->session->userdata('loginuserID');
                                                $array["modify_userID"] = $this->session->userdata('loginuserID');
                                                $this->event_status_m->insert_event_status($array);
                                }


                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                            redirect(base_url("event_status/index"));
                    }

                } else {
                    $this->data["subview"] = "/event_status/edit";
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
		   $arr['event_id'] = htmlentities(escapeString($this->uri->segment(3)));
                 $arr['current_status']  = htmlentities(escapeString($this->uri->segment(4)));

		if((int)$arr['event_id'] && (int)$arr['current_status']) {
			$this->data['es'] = $this->event_status_m->get_single_event_status($arr);
			if($this->data['es']) {
				$this->event_status_m->delete_event_status($arr['event_id'] ,$arr['current_status']);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("event_status/index"));
			} else {
				redirect(base_url("event_status/index"));
			}
		} else {
			redirect(base_url("event_status/index"));
		}
	}




	 function active() {
                if(permissionChecker('event_status_edit')) {
			$arr['event_id'] = $this->input->post('id1');
	                $arr['current_status']  =  $this->input->post('id2');
                        $status = $this->input->post('status');
                        if($arr['event_id'] != '' && $arr['current_status'] != '' && $status != '') {
                                if((int)$arr['event_id'] && (int)$arr['current_status'] ) {
                                        if($status == 'chacked') {
                                                $this->event_status_m->update_event_status(array('active' => 1), $arr['event_id'], $arr['current_status']);
                                                echo 'Success';
                                        } elseif($status == 'unchacked') {
                                                $this->event_status_m->update_event_status(array('active' => 0), $arr['event_id'], $arr['current_status']);
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




  function server_processing(){

	    $aColumns =  array('event_id', 'es.current_status', 'es.active' ,'isInternalStatus');
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

                        if(!empty($this->input->get('eventID'))){
                     		 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'event_id = '.$this->input->get('eventID');
                	}
                        if(!empty($this->input->get('currentStatus'))){
                      		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'current_status = '.$this->input->get('currentStatus');
                	}

                       if(!empty($this->input->get('active')) && $this->input->get('active') != '-1'){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'es.active = '.$this->input->get('active');
                        }else if ($this->input->get('active') == '0') {
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'es.active = '.$this->input->get('active');
                        }





$sQuery = " 
select  es.event_id , es.current_status, ev.aln_data_value as event_name, cs.aln_data_value as current_status_name, group_concat(ns.aln_data_value) as next_status_name,isInternalStatus, es.active from VX_aln_event_status es 
LEFT JOIN vx_aln_data_defns ev on (ev.vx_aln_data_defnsID = es.event_id) 
        LEFT JOIN  vx_aln_data_defns cs on (cs.vx_aln_data_defnsID = es.current_status)
        LEFT JOIN  vx_aln_data_defns ns on (ns.vx_aln_data_defnsID = es.next_status)
$sWhere  group by event_id, es.current_status, es.active , event_name, current_status_name,isInternalStatus
  $sOrder $sLimit";

//print_r($sQuery);exit;
                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;

                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $rResultFilterTotal,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );

		



                foreach($rResult as $list){

			$list->isInternalStatus = ($list->isInternalStatus)?"yes":"no";
                        if(permissionChecker('event_status_edit') ) {
				$list->action = btn_edit('event_status/edit/'.$list->event_id.'/'.$list->current_status, $this->lang->line('edit'));
			}
			
			if (permissionChecker('event_status_delete') ) {                                        				
			 $list->action .= btn_delete('event_status/delete/'.$list->event_id.'/'.$list->current_status, $this->lang->line('delete'));

			}

			$status = $list->active;
			
                        $list->active = "<div class='onoffswitch-small' id='".$list->event_id.":".$list->current_status."'>";
            $list->active .= "<input type='checkbox' id='myonoffswitch".$list->event_id.":".$list->current_status."' class='onoffswitch-small-checkbox' name='paypal_demo'";
                        if($status){
                           $list->active .= "checked='checked' >";
                        } else {
                           $list->active .= ">";
                        }
                        $list->active .= "<label for='myonoffswitch".$list->event_id.":".$list->current_status."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";

                        $output['aaData'][] = $list;

                }
                echo json_encode( $output );
        }


}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
