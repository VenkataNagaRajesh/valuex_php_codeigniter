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
		$this->load->model('usertype_m');
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


	    $this->data['aln_datatypes'] = $this->getAlnDataTYpes();

		$this->data['usertypes'] = $this->usertype_m->get_usertype();
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "marketzone/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				$array["market_name"] = $this->input->post("market_name");
				$array["amz_level_id"] = $this->input->post("amz_level_id");
				$array["amz_level_name"] = implode(',',$this->input->post("amz_level_value"));
				$array["amz_incl_id"] = $this->input->post("amz_incl_id");
				$array["amz_incl_name"] = implode(',',$this->input->post("amz_incl_value"));
				$array["amz_excl_id"] = $this->input->post("amz_excl_id");
				$array["amz_excl_name"] = implode(',',$this->input->post("amz_excl_value"));
				$array["create_date"] = date("Y-m-d h:i:s");
				$array["modify_date"] = date("Y-m-d h:i:s");
				$array["create_userID"] = $this->session->userdata('loginuserID');
			        $array["modify_userID"] = $this->session->userdata('loginuserID');
				$array["active"] = 1;
				$this->marketzone_m->insert_marketzone($array);
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
                                'assets/select2/css/select2-bootstrap.css',
				'assets/fselect/fSelect.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js',
				'assets/fselect/fSelect.js',
                        )
                );
		$this->data['aln_datatypes'] = $this->getAlnDataTYpes();
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

			    $array["market_name"] = $this->input->post("market_name");
                            $array["amz_level_id"] = $this->input->post("amz_level_id");
                            //$array["amz_level_name"] = $this->data['marketzone']->amz_level_name . ',' .  implode(',',$this->input->post("amz_level_value"));
			    $array["amz_level_name"] =  implode(',',$this->input->post("amz_level_value"));
                            $array["amz_incl_id"] = $this->input->post("amz_incl_id");
                            //$array["amz_incl_name"] = $this->data['marketzone']->amz_incl_name . ',' . implode(',',$this->input->post("amz_incl_value"));
			     $array["amz_incl_name"] = implode(',',$this->input->post("amz_incl_value"));
                            $array["amz_excl_id"] = $this->input->post("amz_excl_id");
                            //$array["amz_excl_name"] = $this->data['marketzone']->amz_excl_name . ',' . implode(',',$this->input->post("amz_excl_value"));
			   $array["amz_excl_name"] =  implode(',',$this->input->post("amz_excl_value"));
                            $array["modify_date"] = date("Y-m-d h:i:s");
			   $array["modify_userID"] = $this->session->userdata('loginuserID');

                            $this->marketzone_m->update_marketzone($array, $id);
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
			$this->data['marketzone'] = $this->marketzone_m->get_marketzonename_row('VX_aln_market_zone',array('market_id'=> $id));
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


   public function getAlnDataTYpes(){
	$query = "SELECT vx_aln_data_typeID, name FROM  vx_aln_data_types ";
	$result = $this->install_m->run_query($query);
		foreach($result as $type) {
			$datatypes[$type->vx_aln_data_typeID]  = $type->name;
	        }
	return $datatypes;
   }


   public function getSubdataTypes(){
	
	$id = $this->input->post('id');
	
	if($this->input->post('sub_id')){
              $sub_id = $this->input->post('sub_id');
         }else{
             $sub_id = null;
        }
	//$sub_id = "5,6";
	//$id = 2;
	if ( isset($id)){
	 $this->db->select('vx_aln_data_defnsID, aln_data_value')->from('vx_aln_data_defns');
         $this->db->where('aln_data_typeID',$id);
	  /*if ( $sub_id != null ) {
		$qq = ' data_defns_id NOT IN (' . $sub_id . ')';
		$this->db->where($qq); 
	}*/
         $query = $this->db->get();
         $result =  $query->result();
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

	function deleteAlnDataDefVal(){
		 $type_id = htmlentities(escapeString($this->uri->segment(5)));
                $market_id = htmlentities(escapeString($this->uri->segment(4)));
		$aln_type_val = htmlentities(escapeString($this->uri->segment(3)));
	//	 $type_id = 1;$market_id = 1; $aln_type_val = 5;
		$result = $this->marketzone_m->get_marketzonename_row('VX_aln_market_zone',array('market_id'=> $market_id));
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
