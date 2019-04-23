<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketzone extends Admin_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/
	function __construct() {
		parent::__construct();
		$this->load->model("marketzone_m");
		$this->load->model("trigger_m");
		$this->load->model('user_m');
		$this->load->model('install_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('marketzone', $language);
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'market_name',
				'label' => $this->lang->line("market_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]'
			),
			array(
				'field' => 'amz_level_id',
				'label' => $this->lang->line("level_type"),
				'rules' => 'trim|required|max_length[200]|xss_clean'
			),
   		       array(
                                'field' => 'amz_level_value[]',
                                'label' => $this->lang->line("amz_level_value"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
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


	public function index() {

		$this->data['marketzones'] = $this->marketzone_m->get_marketzones();
		
		$this->data["subview"] = "marketzone/index";
		$this->data['reconfigure'] =  $this->trigger_m->get_trigger_time('VX_aln_market_zone');
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


	    $this->data['aln_datatypes'] = $this->marketzone_m->getAlnDataTYpes();

		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "marketzone/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				$date_now = time(); 
				$array["market_name"] = $this->input->post("market_name");
				$array["amz_level_id"] = $this->input->post("amz_level_id");
				$array["amz_level_name"] = implode(',',$this->input->post("amz_level_value"));
				$array["amz_incl_id"] = $this->input->post("amz_incl_id");
				$array["amz_incl_name"] = implode(',',$this->input->post("amz_incl_value"));
				$array["amz_excl_id"] = $this->input->post("amz_excl_id");
				$array["amz_excl_name"] = implode(',',$this->input->post("amz_excl_value"));
				$array["create_date"] = $date_now;
				$array["modify_date"] = $date_now;
				$array["create_userID"] = $this->session->userdata('loginuserID');
			        $array["modify_userID"] = $this->session->userdata('loginuserID');
				$array["active"] = 1;
				$this->marketzone_m->insert_marketzone($array);
				
			      // insert entry in trigger table for mapping table generation
		
				$tarray['table_name'] = 'VX_aln_market_zone';
				$tarray['table_last_changed'] = $date_now;
				$tarray['create_userID'] = $this->session->userdata('loginuserID');
				$tarray['isReconfigured'] = '1';
			
			        $this->trigger_m->insert_trigger($tarray);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("marketzone/index"));
			}
		} else {
			$this->data["subview"] = "marketzone/add";
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
		$this->data['aln_datatypes'] = $this->marketzone_m->getAlnDataTYpes();
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
                            $array["amz_level_id"] = $this->input->post("amz_level_id");
			    $array["amz_level_name"] =  implode(',',$this->input->post("amz_level_value"));
                            $array["amz_incl_id"] = $this->input->post("amz_incl_id");
			    $array["amz_incl_name"] = implode(',',$this->input->post("amz_incl_value"));
                            $array["amz_excl_id"] = $this->input->post("amz_excl_id");
			    $array["amz_excl_name"] =  implode(',',$this->input->post("amz_excl_value"));
                            $array["modify_date"] = $date_now;
			    $array["modify_userID"] = $this->session->userdata('loginuserID');

                            $this->marketzone_m->update_marketzone($array, $id);


			        $tarray['table_name'] = 'VX_aln_market_zone';
                                $tarray['table_last_changed'] = $date_now;
                                $tarray['create_userID'] = $this->session->userdata('loginuserID');
                                $tarray['isReconfigured'] = '1';

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
				$this->marketzone_m->update_marketzone(array('active' => 0), $id);
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
	
	if($this->input->post('sub_id')){
              $sub_id = $this->input->post('sub_id');
         }else{
             $sub_id = null;
        }
	if ( isset($id)){
		$result = $this->marketzone_m->getSubDataDefns($id);
	        $list = explode(',',$sub_id);
//	 echo "<option value='0'>", SELECT,"</option>";
                        foreach ($result as $defns) {                               
                                echo "<option value=\"$defns->vx_aln_data_defnsID\">",$defns->aln_data_value,"</option>";
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
                        $this->data["marketzone"] = $this->marketzone_m->get_marketzonename($id);
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

	    $aColumns =  array('MainSet.market_id','MainSet.market_name','MainSet.lname','MainSet.iname', 'MainSet.ename','SubSet.inclname','SubSet.exclname', 'SubSet.levelname');
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


$sQuery = "
SELECT MainSet.market_id,MainSet.market_name,MainSet.lname, MainSet.iname, MainSet.ename , SubSet.inclname, SubSet.exclname, SubSet.levelname, MainSet.active 
FROM
(
              select  mz.market_id, mz.market_name ,dtl.name as lname,dti.name as iname, dte.name as ename , mz.active as active
	      from VX_aln_market_zone mz 
	      LEFT JOIN vx_aln_data_types dtl on (dtl.vx_aln_data_typeID = mz.amz_level_id) 
	      LEFT JOIN vx_aln_data_types dti on (dti.vx_aln_data_typeID = mz.amz_incl_id)  
              LEFT JOIN vx_aln_data_types dte on (dte.vx_aln_data_typeID = mz.amz_excl_id)
) as MainSet

LEFT JOIN (


select
    FirstSet.market_id,
    FirstSet.level as levelname,
    SecondSet.excl as exclname,
    ThirdSet.incl as inclname
from 
(          SELECT
                m.market_id as market_id,
                group_concat(c.aln_data_value) as level
           from
                VX_aln_market_zone m
           join vx_aln_data_defns c on find_in_set(c.vx_aln_data_defnsID, m.amz_level_name)
           group by
           m.market_id	
 	   
) as FirstSet  
LEFT join 

(          SELECT
                m.market_id as market_id,
                group_concat(c.aln_data_value) as excl
           from
                VX_aln_market_zone m
           join vx_aln_data_defns c on find_in_set(c.vx_aln_data_defnsID, m.amz_excl_name)
           group by
           m.market_id
) as SecondSet
on FirstSet.market_id = SecondSet.market_id
LEFT JOIN 
(
	SELECT
  		m.market_id as market_id,
    		group_concat(c.aln_data_value) as incl
	   from
    		VX_aln_market_zone m 
           JOIN vx_aln_data_defns c ON find_in_set(c.vx_aln_data_defnsID, m.amz_incl_name)
           group by
           m.market_id
) as ThirdSet

on ThirdSet.market_id = FirstSet.market_id

) as SubSet
on MainSet.market_id = SubSet.market_id
 $sWhere $sOrder $sLimit";
                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                $marketzonescount = $this->marketzone_m->get_marketzones_count();

                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $customerscount,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );

                foreach($rResult as $marketzone){
                        if(permissionChecker('marketzone_edit') || permissionChecker('marketzone_view') || permissionChecker('marketzone_delete') ) {                                        				
			 $marketzone->action .= btn_edit('marketzone/edit/'.$marketzone->market_id, $this->lang->line('edit'));
                         $marketzone->action .= btn_view('marketzone/view/'.$marketzone->market_id, $this->lang->line('view'));
			 $marketzone->action .= btn_delete('marketzone/delete/'.$marketzone->market_id, $this->lang->line('delete'));
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
                echo json_encode( $output );
        }


	


}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
