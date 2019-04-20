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
				'label' => $this->lang->line("amz_level_type"),
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
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),


			array(
                                'field' => 'amz_incl_value[]',
                                'label' => $this->lang->line("amz_incl_value"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),

			array(
                                'field' => 'amz_excl_id',
                                'label' => $this->lang->line("amz_excl_type"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),
			array(
                                'field' => 'amz_excl_value[]',
                                'label' => $this->lang->line("amz_excl_value"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
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
				$tarray['is_run'] = '0';	
			
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
                                $tarray['is_run'] = '0';

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

}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
