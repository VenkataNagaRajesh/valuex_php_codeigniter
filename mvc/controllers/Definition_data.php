<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Definition_data extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('definitiondata', $language);
		$this->data['icon'] = $this->menu_m->getMenu(array("link" => "definition_data"))->icon;
	}

	public function index()
	{
		$this->data['types'] = $this->airports_m->getDefdataTypes();
		if (!empty($this->input->post('aln_data_typeID'))) {
			$this->data['aln_data_typeID'] = $this->input->post('aln_data_typeID');
		} else {
			$this->data['aln_data_typeID'] = 0;
		}
		$this->data["subview"] = "definition_data/index";
		$this->load->view('_layout_main', $this->data);
	}

	protected function rules()
	{
		$rules = array(
			array(
				'field' => 'aln_data_value',
				'label' => $this->lang->line("defdata_value"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_name'
			)
		);
		return $rules;
	}

	protected function addrules()
	{
		$rules = array(
			array(
				'field' => 'parentID',
				'label' => $this->lang->line("defdata_parent"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_validateparent'
			),
			array(
				'field' => 'aln_data_typeID',
				'label' => $this->lang->line("defdata_type"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_type'
			),
			array(
				'field' => 'aln_data_value',
				'label' => $this->lang->line("defdata_value"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_name'
			),
			array(
				'field' => 'code',
				'label' => $this->lang->line("defdata_code"),
				'rules' => 'trim|xss_clean|max_length[60]'
			),
			array(
				'field' => 'alias',
				'label' => $this->lang->line("defdata_alias"),
				'rules' => 'trim|xss_clean|max_length[60]'
			),
			array(
				'field' => 'active',
				'label' => $this->lang->line("defdata_active"),
				'rules' => 'trim|xss_clean|max_length[60]'
			)
		);
		return $rules;
	}

	function type($post_string)
	{
		if ($post_string == '0') {
			$this->form_validation->set_message("state", "%s is required");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function validateparent($post_string)
	{
		if ($post_string == '0') {
			if ($type != 1 && $type != 2) {
				$parentlist = $this->airports_m->getDefns($type - 1);
				if (count($parentlist) > 0) {
					$this->form_validation->set_message("validateparent", "%s is required");
				} else {
					return TRUE;
				}
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return TRUE;
		}
	}

	public function unique_name($string)
	{
		if (empty($string)) {
			$this->form_validation->set_message("unique_name", "%s is required");
			return FALSE;
		} else {
			$id = htmlentities(escapeString($this->uri->segment(3)));
			if ($id) {
				$info = $this->airports_m->get_definition_data($id);
				$where = array(
					'aln_data_value' => $string,
					'aln_data_typeID' => $info->aln_data_typeID,
					'parentID' => $info->parentID,
					'vx_aln_data_defnsID !=' => $id
				);
				$validate = $this->airports_m->validateDefdata($where);
				if ($validate > 0) {
					$this->form_validation->set_message("unique_name", "%s is already existed");
					return FALSE;
				} else {
					return TRUE;
				}
			} else {
				if (!empty($this->input->post('parentID'))) {
					$parent = $this->input->post('parentID');
				} else {
					$parent = null;
				}
				if (empty($this->input->post('aln_data_typeID'))) {
					$this->form_validation->set_message("unique_name", "type required for validating");
					return FALSE;
				} else {
					$where = array(
						'aln_data_value' => $string,
						'aln_data_typeID' => $this->input->post('aln_data_typeID'),
						'parentID' => $parent
					);
					$validate = $this->airports_m->validateDefdata($where);
					if ($validate > 0) {
						$this->form_validation->set_message("unique_name", "%s is already existed");
						return FALSE;
					} else {
						return TRUE;
					}
				}
			}
		}
	}

	public function add()
	{
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
		$this->data['types'] = $this->airports_m->getDefdataTypes(null, array(1, 2, 3, 4, 5, 6, 12, 25));
		if ($_POST) {
			$rules = $this->addrules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "definition_data/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				if (!empty($this->input->post('parentID'))) {
					$parent = $this->input->post('parentID');
				} else {
					$parent = null;
				}
				$array = array(
					"aln_data_typeID" => $this->input->post('aln_data_typeID'),
					"aln_data_value" => $this->input->post("aln_data_value"),
					"parentID" => $parent,
					"code" => $this->input->post('code'),
					"create_date" => time(),
					"modify_date" => time(),
					"create_userID" => $this->session->userdata('loginuserID'),
					"modify_userID" => $this->session->userdata('loginuserID')
				);
				$id = $this->airports_m->add_definition_data($array);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("definition_data/index"));
			}
		} else {
			$this->data["subview"] = "definition_data/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit()
	{
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
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int) $id) {
			$this->data['defdata'] = $this->airports_m->get_definition_data($id);
			if ($this->data['defdata']) {
				if ($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) {
						$this->data["subview"] = "definition_data/edit";
						$this->load->view('_layout_main', $this->data);
					} else {
						$array = array(
							"aln_data_value" => $this->input->post("aln_data_value"),
							"modify_date" => time(),
							"modify_userID" => $this->session->userdata('loginuserID')
						);
						$this->airports_m->update_definition_data($array, $id);
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("definition_data/index"));
					}
				} else {
					$this->data["subview"] = "definition_data/edit";
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

	public function delete()
	{
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int) $id) {
			$this->data['defdata'] = $this->airports_m->get_definition_data($id);
			if ($this->data['defdata']) {
				$this->airports_m->delete_definition_data($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("definition_data/index"));
			} else {
				redirect(base_url("definition_data/index"));
			}
		} else {
			redirect(base_url("definition_data/index"));
		}
	}

	public function view()
	{
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int) $id) {
			$this->data["defdata"] = $this->airports_m->get_definition_data($id);
			if ($this->data["defdata"]) {
				$this->data["subview"] = "definition_data/view";
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

	function active()
	{
		if (permissionChecker('definition_data_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if ($id != '' && $status != '') {
				if ((int) $id) {
					$data['modify_userID'] = $this->session->userdata('loginuserID');
					$data['modify_date'] = time();
					if ($status == 'chacked') {
						$data['active'] = 1;
						$this->airports_m->update_definition_data($data, $id);
						echo 'Success';
					} elseif ($status == 'unchacked') {
						$data['active'] = 0;
						$this->airports_m->update_definition_data($data, $id);
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

	function server_processing()
	{
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');

		$aColumns = array('dd.vx_aln_data_defnsID', 't.name', 'dd.aln_data_value', 'dd1.aln_data_value', 'dd.code', 'dd.active');

		$sLimit = "";

		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = "LIMIT " . $_GET['iDisplayStart'] . "," . $_GET['iDisplayLength'];
		}
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					if ($_GET['iSortCol_0'] == 8) {
						$sOrder .= " (s.order_no*-1) DESC ,";
					} else {
						$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
							" . $_GET['sSortDir_' . $i] . ", ";
					}
				}
			}
			$sOrder = substr_replace($sOrder, "", -2);

			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}
		$sWhere = "";
		if ($_GET['sSearch'] != "") {
			$sWhere = "WHERE (";
			for ($i = 0; $i < count($aColumns); $i++) {
				$sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}


		/* Individual column filtering */
		for ($i = 0; $i < count($aColumns); $i++) {
			if ($_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
				if ($sWhere == "") {
					$sWhere = "WHERE ";
				} else {
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch_' . $i] . "%' ";
			}
		}
		if ($this->input->get('aln_data_typeID') > 0) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'dd.aln_data_typeID = ' . $this->input->get('aln_data_typeID');
		}

		$sQuery = "SELECT SQL_CALC_FOUND_ROWS dd.*,t.alias datatype,dd1.aln_data_value parent from VX_data_defns dd LEFT JOIN VX_data_defns dd1 ON dd1.vx_aln_data_defnsID = dd.parentID LEFT JOIN VX_data_types t ON dd.aln_data_typeID = t.vx_aln_data_typeID
		$sWhere			
		$sOrder
        $sLimit		
		";

		$rResult = $this->install_m->run_query($sQuery);
		$sQuery = "SELECT FOUND_ROWS() as total";
		$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;

		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $rResultFilterTotal,
			"iTotalDisplayRecords" => $rResultFilterTotal,
			"aaData" => array()
		);

		$rownum = 1 + $_GET['iDisplayStart'];
		foreach ($rResult as $defdata) {

			$defdata->chkbox = "<input type='checkbox'  class='deleteRow' value='" . $defdata->vx_aln_data_defnsID . "'  /> " . $rownum;
			$rownum++;
			if (permissionChecker('definition_data_edit')) {
				$defdata->action = btn_edit('definition_data/edit/' . $defdata->vx_aln_data_defnsID, $this->lang->line('edit'));
			}
			if (permissionChecker('definition_data_delete')) {
				$defdata->action .= btn_delete('definition_data/delete/' . $defdata->vx_aln_data_defnsID, $this->lang->line('delete'));
			}
			if (permissionChecker('definition_data_view')) {
				$defdata->action .= btn_view('definition_data/view/' . $defdata->vx_aln_data_defnsID, $this->lang->line('view'));
			}
			$status = $defdata->active;
			$defdata->active = "<div class='onoffswitch-small' id='" . $defdata->vx_aln_data_defnsID . "'>";
			$defdata->active .= "<input type='checkbox' id='myonoffswitch" . $defdata->vx_aln_data_defnsID . "' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if ($status) {
				$defdata->active .= " checked >";
			} else {
				$defdata->active .= ">";
			}

			$defdata->active .= "<label for='myonoffswitch" . $defdata->vx_aln_data_defnsID . "' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
			$defdata->code = ($defdata->code == 'NUL') ? '' : $defdata->code;

			$output['aaData'][] = $defdata;
		}

		if (isset($_REQUEST['export'])) {
			$columns = array('#', 'Type', 'Name', 'Parent', 'Code');
			$rows = array('vx_aln_data_defnsID', 'datatype', 'aln_data_value', 'parent', 'code');
			$this->exportall($output['aaData'], $columns, $rows);
		} else {
			echo json_encode($output);
		}
	}

	public function delete_def_bulk_records()
	{
		$data_ids = $_REQUEST['data_ids'];
		$data_id_array = explode(",", $data_ids);
		if (!empty($data_id_array)) {
			foreach ($data_id_array as $id) {

				$this->data['defdata'] = $this->airports_m->get_definition_data($id);
				if ($this->data['defdata']) {
					$this->airports_m->delete_definition_data($id);
				}
			}
		}
	}
}
