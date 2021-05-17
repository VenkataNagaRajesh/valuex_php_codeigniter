<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fclr extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model("rafeed_m");
                $this->load->model("airline_cabin_m");
                $this->load->model('airline_cabin_def_m');
                $this->load->model("fclr_m");
                $this->load->model("contract_m");
                $this->load->model("season_m");
                $this->load->model('airports_m');
                $this->load->model('airline_m');
                $this->load->model("marketzone_m");
                $this->load->model('eligibility_exclusion_m');
                $this->load->model('user_m');
                $language = $this->session->userdata('lang');
                $this->lang->load('fclr', $language);
        }



        protected function rules()
        {
                $rules = array(
                        array(
                                'field' => 'board_point',
                                'label' => $this->lang->line("board_point"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),
                        array(
                                'field' => 'off_point',
                                'label' => $this->lang->line("off_point"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),

                        array(
                                'field' => 'carrier_code',
                                'label' => $this->lang->line("carrier"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),


                        array(
                                'field' => 'flight_number',
                                'label' => $this->lang->line("flight_number"),
                                'rules' => 'trim|required|integer|max_length[200]|xss_clean'
                        ),
                        array(
                                'field' => 'season_id',
                                'label' => $this->lang->line("season"),
                                'rules' => 'trim|integer|max_length[200]|xss_clean|callback_validateSeasonOrFreq'
                        ),
                        array(
                                'field' => 'frequency',
                                'label' => $this->lang->line("frequency"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),
                        array(
                                'field' => 'upgrade_from_cabin_type',
                                'label' => $this->lang->line("from_cabin"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),

                        array(
                                'field' => 'upgrade_to_cabin_type',
                                'label' => $this->lang->line("to_cabin"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valMarket'
                        ),

                        array(
                                'field' => 'min',
                                'label' => $this->lang->line("min"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),

                        array(
                                'field' => 'max',
                                'label' => $this->lang->line("max"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),


                        array(
                                'field' => 'avg',
                                'label' => $this->lang->line("avg"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),
                        array(
                                'field' => 'slider_start',
                                'label' => $this->lang->line("slider_start"),
                                'rules' => 'trim|required|max_length[200]|xss_clean'
                        ),




                );
                return $rules;
        }

        function valMarket($post_string)
        {
                if ($post_string == '0') {
                        $this->form_validation->set_message("valMarket", "%s is required");
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

        function valOrigLevelValue($post_array)
        {
                if (count($post_array) < 1) {
                        $this->form_validation->set_message("valOrigLevelValue", "%s is required");
                        return FALSE;
                } else {
                        return TRUE;
                }
        }


        function validateSeasonOrFreq()
        {
                $freq = $this->input->post("frequency");
                $season = $this->input->post("season_id");

                if (($freq == 0 && $season == 0) || ($freq != 0 && $season != 0)) {
                        $this->form_validation->set_message("validateSeasonOrFreq", "Either frequency or season should be selected");
                        return false;
                }

                return true;
        }





        public function getFCLRData()
        {
                $id = $this->input->post('fclr_id');
                if ((int) $id) {
                        $fclr = $this->fclr_m->get_single_fclr(array('fclr_id' => $id));
                }

                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode($fclr));
        }



        public function save()
        {
                if ($_POST) {
                        $fclr_id = $this->input->post("fclr_id");
                        $rules = $this->rules();
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                                $json['status'] = validation_errors();
                                $json['errors'] = array(
                                        'board_point' => form_error('board_point'),
                                        'off_point' => form_error('off_point'),
                                        'frequency' => form_error('frequency'),
                                        'flight_number' => form_error('flight_number'),
                                        'carrier_code' => form_error('carrier_code'),
                                        'upgrade_from_cabin_type' => form_error('upgrade_from_cabin_type'),
                                        'upgrade_to_cabin_type' => form_error('upgrade_to_cabin_type'),
                                        'min' => form_error('min'),
                                        'max' => form_error('max'),
                                        'avg' => form_error('avg'),
                                        'slider_start' => form_error('slider_start'),
                                );
                        } 
                        else {


                                $array["boarding_point"] = $this->input->post("board_point");
                                $array["off_point"] = $this->input->post("off_point");
                                $array["carrier_code"] = $this->input->post("carrier_code");
                                $array["flight_number"] = $this->input->post("flight_number");
                                $array['frequency'] = $this->input->post("frequency");
                                $array['from_cabin'] = $this->input->post("upgrade_from_cabin_type");
                                $array['to_cabin'] = $this->input->post("upgrade_to_cabin_type");
                                $array['season_id'] = $this->input->post("season_id");
                                $exist_id = $this->fclr_m->checkFCLREntry($array);

                                $array['average'] = $this->input->post("avg");
                                $array['min'] = $this->input->post("min");
                                $array['max'] = $this->input->post("max");
                                $array['slider_start'] = $this->input->post("slider_start");

                                $min=$this->preference_m->get_preference_value_bycode('fclr_min',24,4079);
                                $max=$this->preference_m->get_preference_value_bycode('fclr_max',24,4079);
                                $slider_val=$this->preference_m->get_preference_value_bycode('fclr_slider_value',24,4079);
                        
                                if($array['min']<$min || $array['max']<$max || $array['slider_start']<$slider_val)
                                {
                                        $array['active']=0;
                                }
                                else{
                                        $array['active']=1;
                                }

                                if ($fclr_id) {
                                        if ($exist_id && $exist_id != $fclr_id) {
                                                $json['status'] = 'duplicate';
                                        } else {
                                                $array["modify_date"] = time();
                                                $array["modify_userID"] = $this->session->userdata('loginuserID');
                                                $this->fclr_m->update_fclr($array, $fclr_id);
                                                $json['status'] = 'success';
                                        }
                                } else {
                                        if ($exist_id) {
                                                $json['status'] = 'duplicate';
                                        } else {
                                                $array["create_date"] = time();
                                                $array["modify_date"] = time();
                                                $array["create_userID"] = $this->session->userdata('loginuserID');
                                                $array["modify_userID"] = $this->session->userdata('loginuserID');
                                                $this->fclr_m->insert_fclr($array);
                                                $json['status'] = 'success';
                                        }
                                }
                        }
                }
                else {
                        $json['status'] = "no data";
                }

                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode($json));
        }



        public function add()
        {
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

                $this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1'); // airports
                $this->data['days'] = $this->airports_m->getDefnsListByType('14'); // days of week		
                $this->data['cabins'] = $this->airports_m->getDefnsListByType('13');
                $this->data['seasons'] = $this->season_m->getSeasonsList();
                $this->data['carrier'] = $this->airports_m->getDefnsCodesListByType('12');



                if ($_POST) {
                        $rules = $this->rules();
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                                $this->data["subview"] = "fclr/add";
                                $this->load->view('_layout_main', $this->data);
                        } else {
                                $array["boarding_point"] = $this->input->post("board_point");
                                $array["off_point"] = $this->input->post("off_point");
                                $array["carrier_code"] = $this->input->post("carrier_code");
                                $array["flight_number"] = $this->input->post("flight_number");
                                $array['frequency'] = $this->input->post("frequency");
                                $array['from_cabin'] = $this->input->post("upgrade_from_cabin_type");
                                $array['to_cabin'] = $this->input->post("upgrade_to_cabin_type");
                                $array['season_id'] = $this->input->post("season_id");

                                $fclr_id = $this->fclr_m->checkFCLREntry($array);
                                if ($fclr_id) {
                                        $this->session->set_flashdata('error', 'Duplicate Entry');
                                        redirect(base_url("fclr/index"));
                                } else {
                                        $array['average'] = $this->input->post("avg");
                                        $array['min'] = $this->input->post("min");
                                        $array['max'] = $this->input->post("max");
                                        $array['slider_start'] = $this->input->post("slider_start");
                                        $array["create_date"] = time();
                                        $array["modify_date"] = time();
                                        $array["create_userID"] = $this->session->userdata('loginuserID');
                                        $array["modify_userID"] = $this->session->userdata('loginuserID');
                                        $this->fclr_m->insert_fclr($array);
                                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                        redirect(base_url("fclr/index"));
                                }
                        }
                } else {
                        $this->data["subview"] = "fclr/add";
                        $this->load->view('_layout_main', $this->data);
                }
        }

        public function edit()
        {
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
                if ((int) $id) {
                        $this->data['fclr'] = $this->fclr_m->get_single_fclr(array('fclr_id' => $id));
                        if ($this->data['fclr']) {

                                $this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1'); // airports
                                $this->data['days'] = $this->airports_m->getDefnsListByType('14'); // days of week           
                                $this->data['cabins'] = $this->airports_m->getDefnsListByType('13');
                                $this->data['seasons'] = $this->season_m->getSeasonsList();
                                $this->data['carrier'] = $this->airports_m->getDefnsCodesListByType('12');

                                if ($_POST) {
                                        $rules = $this->rules();
                                        $this->form_validation->set_rules($rules);
                                        if ($this->form_validation->run() == FALSE) {
                                                $this->data["subview"] = "fclr/edit";
                                                $this->load->view('_layout_main', $this->data);
                                        } else {



                                                $array["boarding_point"] = $this->input->post("board_point");
                                                $array["off_point"] = $this->input->post("off_point");
                                                $array["carrier_code"] = $this->input->post("carrier_code");
                                                $array["flight_number"] = $this->input->post("flight_number");
                                                $array['frequency'] = $this->input->post("frequency");
                                                $array['from_cabin'] = $this->input->post("upgrade_from_cabin_type");
                                                $array['to_cabin'] = $this->input->post("upgrade_to_cabin_type");
                                                $array['season_id'] = $this->input->post("season_id");
                                                $fclr_id = $this->fclr_m->checkFCLREntry($array);
                                                if ($fclr_id && $fclr_id != $id) {
                                                        $this->session->set_flashdata('error', 'Duplicate Entry');
                                                        redirect(base_url("fclr/index"));
                                                } else {
                                                        $array['average'] = $this->input->post("avg");
                                                        $array['min'] = $this->input->post("min");
                                                        $array['max'] = $this->input->post("max");
                                                        $array['slider_start'] = $this->input->post("slider_start");

                                                        $array["modify_date"] = time();
                                                        $array["modify_userID"] = $this->session->userdata('loginuserID');
                                                        $this->fclr_m->update_fclr($array, $id);


                                                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                                        redirect(base_url("fclr/index"));
                                                }
                                        }
                                } else {
                                        $this->data["subview"] = "fclr/edit";
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
                        $this->data['rule'] = $this->fclr_m->get_single_fclr(array('fclr_id' => $id));
                        if ($this->data['rule']) {
                                $this->fclr_m->delete_fclr($id);
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("fclr/index"));
                        } else {
                                redirect(base_url("fclr/index"));
                        }
                } else {
                        redirect(base_url("fclr/index"));
                }
        }


        public function index()
        {

                $fclr_id = htmlentities(escapeString($this->uri->segment(3)));

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

                $this->data['check_product'] = $this->user_m->loginUserProducts(array('p.productID'=>1));

                if ($fclr_id > 0) {
                        $this->data['sfclr_id'] = $fclr_id;
                }

                if (!empty($this->input->post('boarding_point'))) {
                        $this->data['boarding_point'] = $this->input->post('boarding_point');
                } else {
                        $this->data['boarding_point'] = 0;
                }
                if (!empty($this->input->post('soff_point'))) {
                        $this->data['off_point'] = $this->input->post('soff_point');
                } else {
                        $this->data['off_point'] = 0;
                }

                if (!empty($this->input->post('sflight_number'))) {
                        $this->data['flight_number'] = $this->input->post('sflight_number');
                }

                if (!empty($this->input->post('end_flight_number'))) {
                        $this->data['end_flight_number'] = $this->input->post('end_flight_number');
                }

                if (!empty($this->input->post('dep_from_date'))) {
                        $this->data['dep_from_date'] = date('d-m-Y', $this->input->post('dep_from_date'));
                }


                if (!empty($this->input->post('dep_to_date'))) {
                        $this->data['dep_to_date'] = date('d-m-Y', $this->input->post('dep_to_date'));
                }


                if (!empty($this->input->post('smarket'))) {
                        $this->data['smarket'] = $this->input->post('smarket');
                } else {
                        $this->data['smarket'] = 0;
                }


                if (!empty($this->input->post('dmarket'))) {
                        $this->data['dmarket'] = $this->input->post('dmarket');
                } else {
                        $this->data['dmarket'] = 0;
                }


                if (!empty($this->input->post('sfrequency'))) {
                        $this->data['frequency'] = $this->input->post('sfrequency');
                } else {
                        $this->data['day'] = 0;
                }


                if (!empty($this->input->post('sfrom_cabin'))) {
                        $this->data['sfrom_cabin'] = $this->input->post('sfrom_cabin');
                } else {
                        $this->data['sfrom_cabin'] = 0;
                }



                if (!empty($this->input->post('sto_cabin'))) {
                        $this->data['sto_cabin'] = $this->input->post('sto_cabin');
                } else {
                        $this->data['sto_cabin'] = 0;
                }




                $this->data['seasons'] = $this->season_m->getSeasonsList();


                $this->data['country'] = $this->rafeed_m->getCodesByType('2');
                $this->data['city'] = $this->rafeed_m->getCodesByType('5');

                $userID = $this->session->userdata('loginuserID');
                $roleID = $this->session->userdata('roleID');
                if ($roleID != 1) {
                        $this->data['airlines'] = $this->user_m->getUserAirlines($userID);
                } else {
                        $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }

                //$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
                $this->data['airports'] = $this->rafeed_m->getCodesByType('1');
                $this->data['cabins'] = $this->rafeed_m->getCodesByType('13');
                $this->data['marketzones'] = $this->marketzone_m->getMarketzones();
                //$this->data['flights'] = $this->rafeed_m->getNamesByType('16');
                $this->data['days_of_week'] = $this->airports_m->getDefnsCodesListByType('14');

                if ($this->input->post('scarrier')) {
                        $this->data['scarrier_id'] = $this->input->post('scarrier');
                } else {
                        if ($roleID != 1) {
                                $this->data['scarrier_id'] = $this->session->userdata('default_airline');
                        } else {
                                $this->data['scarrier_id'] = 0;
                        }
                }

                $this->data["subview"] = "fclr/index";
                $this->load->view('_layout_main', $this->data);
        }


        function server_processing()
        {


                $userID = $this->session->userdata('loginuserID');
                $roleID = $this->session->userdata('roleID');


                $aColumns = array('fclr_id', 'dbp.code', 'dop.code', 'dai.code', 'flight_number', 'season_name', 'sea.ams_season_start_date', 'sea.ams_season_end_date', 'dfre.code', 'fdef.cabin', 'tdef.cabin', 'average', 'min', 'max', 'slider_start', 'fc.active', 'dop.code', 'dbp.code', 'dai.code', 'dfre.aln_data_value', 'dop.aln_data_value', 'dbp.aln_data_value', 'dai.aln_data_value', 'fdef.desc', 'tdef.desc');


                $sLimit = "";

                if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                        $sLimit = "LIMIT " . $_GET['iDisplayStart'] . "," . $_GET['iDisplayLength'];
                }
                if (isset($_GET['iSortCol_0'])) {
                        $sOrder = "ORDER BY  ";
                        for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                                        $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
							" . $_GET['sSortDir_' . $i] . ", ";
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




                if (!empty($this->input->get('boardPoint'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'boarding_point = ' . $this->input->get('boardPoint');
                }
                if (!empty($this->input->get('offPoint'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'off_point = ' . $this->input->get('offPoint');
                }


                if (!empty($this->input->get('flightNbr'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'flight_number >= ' . $this->input->get('flightNbr');
                }


                if (!empty($this->input->get('flightNbrEnd'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'flight_number <= ' . $this->input->get('flightNbrEnd');
                }


                if (!empty($this->input->get('sfclr_id'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'fclr_id = ' . $this->input->get('sfclr_id');
                }

                /*
			if(!empty($this->input->get('depStartDate'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'departure_date >= '. strtotime($this->input->get('depStartDate'));
                        }
                        if(!empty($this->input->get('depEndDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'departure_date <= '.  strtotime($this->input->get('depEndDate'));
                        }*/




                if (!empty($this->input->get('smarket'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'smap.market_id = ' . $this->input->get('smarket');
                }
                if (!empty($this->input->get('dmarket'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'dmap.market_id = ' .  $this->input->get('dmarket');
                }



                if (!empty($this->input->get('sfrom_cabin'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'fc.from_cabin = ' . $this->input->get('sfrom_cabin');
                }
                if (!empty($this->input->get('sto_cabin'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'fc.to_cabin = ' .  $this->input->get('sto_cabin');
                }


                if (!empty($this->input->get('sseason_id'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'fc.season_id = ' . $this->input->get('sseason_id');
                }
                if (!empty($this->input->get('scarrier'))) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'fc.carrier_code = ' .  $this->input->get('scarrier');
                }


                if (!empty($this->input->get('frequency'))) {
                        $frstr = $this->input->get('frequency');
                        $freq = $this->airports_m->getDefnsCodesListByType('14');
                        if ($frstr === '*') {
                                $frstr = '1234567';
                        }
                        if ($frstr != '0') {
                                $arr = str_split($frstr);
                                $freq_str = implode(',', array_map(function ($x) use ($freq) {
                                        return array_search($x, $freq);
                                }, $arr));
                                $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                                $sWhere .= 'fc.frequency IN (' . $freq_str . ') ';
                        }
                }

                $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if ($roleID != 1) {
                        $sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
                        $sWhere .= 'fc.carrier_code IN (' . implode(',', $this->session->userdata('login_user_airlineID')) . ')';
                }

               $ac=$_GET['inputVal'];
                $sQuery = " SELECT SQL_CALC_FOUND_ROWS distinct fclr_id,boarding_point, dai.code as carrier_code , off_point, 
		season_id,flight_number, fdef.cabin as fcabin, sea.season_name,
            	tdef.cabin as tcabin,  dfre.code as day_of_week , fc.active, sea.ams_season_start_date as start_date, sea.ams_season_end_date as end_date,
            	round(min) as min ,round(max) as max,floor(average) as average_value,round(slider_start)as slider_start,from_cabin, to_cabin,
		dbp.code as source_point , dop.code as dest_point,
		dfre.aln_data_value, dop.aln_data_value, dbp.aln_data_value, dai.aln_data_value, fdef.desc,tdef.desc 
		
                    FROM UP_fare_control_range  fc
                     LEFT JOIN  VX_data_defns dbp on (dbp.vx_aln_data_defnsID = fc.boarding_point) 
		     LEFT JOIN VX_data_defns dop on (dop.vx_aln_data_defnsID = fc.off_point)    
		     LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = fc.carrier_code)
		     LEFT JOIN VX_data_defns dfre on (dfre.vx_aln_data_defnsID = fc.frequency) 
		     INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = fc.carrier_code) and fc.active=$ac

		     INNER JOIN VX_data_defns fca on (fca.alias = fdef.level and fca.aln_data_typeID = 13 AND fca.vx_aln_data_defnsID = fc.from_cabin)
		     
		     INNER JOIN VX_airline_cabin_def tdef on (tdef.carrier = fc.carrier_code)
                     INNER JOIN VX_data_defns tca on (tca.alias = tdef.level and tca.aln_data_typeID = 13 AND tca.vx_aln_data_defnsID = fc.to_cabin)
		     LEFT JOIN VX_season sea on (sea.VX_aln_seasonID = fc.season_id )
		     LEFT JOIN VX_market_airport_map smap on (smap.airport_id = fc.boarding_point ) 
		     LEFT JOIN VX_market_airport_map dmap on (dmap.airport_id = fc.off_point)
                     
                     
                     $sWhere $sOrder $sLimit";


                $rResult = $this->install_m->run_query($sQuery);
                
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                $output = array(
                        "sEcho" => intval($_GET['sEcho']),
                        "iTotalRecords" => $rResultFilterTotal,
                        "iTotalDisplayRecords" => $rResultFilterTotal,
                        "aaData" => array()
              
                );

                $i = 1;
                $rownum = 1 + $_GET['iDisplayStart'];
                foreach ($rResult as $feed) {

                        $feed->chkbox = "<input type='checkbox'  class='deleteRow' value='" . $feed->fclr_id . "'  /> " . $rownum;
                        $rownum++;

                        $boarding_markets = implode(',', $this->marketzone_m->getMarketsForAirportID($feed->boarding_point));
                        $feed->day_of_week = ($feed->day_of_week) ? ($feed->day_of_week) : "NA";
                        $feed->source = $feed->source_point;
                        $feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip"  data-original-title="' . $boarding_markets . '">' . $feed->source_point . '</a>';
                        $dest_markets = implode(',', $this->marketzone_m->getMarketsForAirportID($feed->off_point));
                        $feed->dest = $feed->dest_point;
                        $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip"  data-original-title="' . $dest_markets . '">' . $feed->dest_point . '</a>';


                        /*if ( $feed->season_id > 0 ) {
				$season = $this->season_m->get_single_season(array('VX_aln_seasonID'=>$feed->season_id));
				$feed->season_id =  $season->season_name ;
				$feed->start_date = date('d-m-Y',$season->ams_season_start_date);
				$feed->end_date  = date('d-m-Y',$season->ams_season_end_date);
			} else {
				 $feed->season_id = 'default season';
				$feed->start_date = 'NA';
				$feed->end_date = 'NA';
			}*/


                        $feed->season_id = ($feed->season_name) ? ($feed->season_name) : 'default';
                        $feed->start_date = ($feed->start_date) ? date('d-m-Y', $feed->start_date) : 'NA';
                        $feed->end_date = $feed->end_date ? date('d-m-Y', $feed->end_date) : 'NA';
                        $feed->action = '';
                        if (permissionChecker('fclr_edit')) {

                                $feed->action .=  '<a href="#" class="btn btn-warning btn-xs mrg" id="edit_fclr"  data-placement="top" onclick="editfclr(' . $feed->fclr_id . ')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                        }

                        if (permissionChecker('fclr_delete')) {
                                $feed->action .= btn_delete('fclr/delete/' . $feed->fclr_id, $this->lang->line('delete'));
                        }
                        $status = $feed->active;
                        $feed->active = "<div class='onoffswitch-small' id='" . $feed->fclr_id . "'>";
                        $feed->active .= "<input type='checkbox' id='myonoffswitch" . $feed->fclr_id . "' class='onoffswitch-small-checkbox' name='paypal_demo'";
                        if ($status) {
                                $feed->active .= " checked >";
                        } else {
                                $feed->active .= ">";
                        }

                        $feed->active .= "<label for='myonoffswitch" . $feed->fclr_id . "' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
                        $feed->id = $i;
                        $i++;
                        $output['aaData'][] = $feed;
                }


                if (isset($_REQUEST['export'])) {
                        $columns = array('#', 'Board Point', 'Off Point', 'Carrier', 'Flight Number', 'Season', 'From date', 'To date', 'Frequency', 'From Cabin', 'To Cabin', 'Average', 'Minimum', 'Maximum', 'Slider Position');
                        $rows = array("id", "source", "dest", "carrier_code", "flight_number", "season_id", "start_date", "end_date", "day_of_week", "fcabin", "tcabin", "average", "min", "max", "slider_start");
                        $this->exportall($output['aaData'], $columns, $rows);
                } else {
                        echo json_encode($output);
                }
        }


        /*
	function calculate_Min_Max($fromCabin ,$toCabin ) {

		 $fromCabinAvg = array_sum($fromCabin)/count($fromCabin);
                $toCabinAvg = array_sum($toCabin)/count($toCabin);

                $fromCabinSD = $this->fclr_m->Stand_Deviation($fromCabin);
                $toCabinSD = $this->fclr_m->Stand_Deviation($toCabin);

                $bidAvg = $toCabinAvg - $fromCabinAvg;

                $bidSD =  sqrt(pow($fromCabinSD,2) + pow($toCabinSD,2));
                $max = $bidAvg + (3 * $bidSD);
                $min = $bidAvg - (3 * $bidSD);
		

                $feed->average = round($bidAvg,1);
                $feed->min = round($min,1);
                $feed->max = round($max,1);
		$feed->slider_start = round(($bidAvg - (2 * $bidSD)),1); 
		 return  $feed;

 	}

*/


        function calculate_Min_Max($fromCabinSD, $toCabinSD,  $fromCabinAvg, $toCabinAvg)
        {


                $bidAvg = $toCabinAvg - $fromCabinAvg;

                $bidSD =  sqrt(pow($fromCabinSD, 2) + pow($toCabinSD, 2));
                $max = $bidAvg + (3 * $bidSD);
                $min = $bidAvg - (3 * $bidSD);


                $feed->average = round($bidAvg, 1);
                $feed->min = round($min, 1);
                $feed->max = round($max, 1);
                $feed->slider_start = round(($bidAvg - (2 * $bidSD)), 1);
                return  $feed;
        }


        function active()
        {
                if (permissionChecker('fclr_edit')) {
                        $id = $this->input->post('id');
                        $slider=$this->input->post('slider_start');
                        $minimum_values=$this->input->post('min');
                        $status = $this->input->post('status');
                        if ($id != '' && $status != '') {
                                if ((int) $id) {
                                        $data['modify_userID'] = $this->session->userdata('loginuserID');
                                        $data['modify_date'] = time();
                                        if ($status == 'chacked' || $slider>0  || $minimum_values>0) {
                                                $data['active'] = 1;
                                                $this->fclr_m->update_fclr($data, $id);
                                                echo 'Success';
                                        } else if ($status == 'unchacked') {
                                                $data['active'] = 0;
                                                $this->fclr_m->update_fclr($data, $id);
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


        function generatedata()
        {
		$errors = 0;

			$airlines = $this->airline_m->get_airlines();
                $param = htmlentities(escapeString($this->uri->segment(3)));
                $carrier_id = $this->input->get('carrier_id');
		//$carrier_id = 5418;
                if ((int) $param) {
                        $year = $param;
                	$where_date = " year(FROM_UNIXTIME(rf.departure_date)) = " . $year;
                } else {
                        $current_year =  date("Y");
                        $year = $current_year - 1;
			$lastday = time() - 86400;
			$lastday = mktime(23, 59, 59, date("m"), date("d")-1, date("Y"));
                	$where_date = " rf.departure_date <= " . $lastday;
                }

		$carriers = Array();
		if ( $carrier_id) {
			$contracts = $this->contract_m->getActiveContracts($carrier_id);
		} else {
			$contracts = $this->contract_m->getActiveContracts();
		}
		foreach($contracts as $contract) {
			$product = $contract->productID;
			switch ($product) {
			case 1:
				$carriers[$contract->airlineID] = $contract->code;
			break;
			}
		}


		foreach($carriers as $carrier_id => $airline_code) {
               	$where = $where_date . " AND rf.carrier = " . $carrier_id;

                $list = $this->airline_cabin_def_m->getDummyCabinsList($carrier_id);
                $list1 = $list;
                $cabin_map_arr = array();
                //Y-4, W-3, C-2, F-1
                foreach ($list as $l1) {
                        foreach ($list1 as $l2) {
                                if ($l1->alias > $l2->alias) {
                                        $temp = array($l1->code, $l2->code);
                                        $cabin_map_arr[] = $temp;
                                }
                        }
                }
#echo "<br><br>CARR-$carrier_id, CABINS=<pre>" .print_r($cabin_map_arr,1) ."</pre>";

                /*
                        $cabin_map_arr = array(
			array('Y','W'),
			array('Y','C'),
			array('W','C')
		     );
                */
                //with out season calculation on day_of_week
                // for 7 days in a week each entery for multiple levels

                $rResult1 = array();
                foreach ($cabin_map_arr as $cabin_arr) {
                        $sQuery =  "SELECT SuperSet.cabin as from_cabin, SubSet1.cabin as to_cabin, SuperSet.flight_number, SuperSet.boarding_point, SuperSet.off_point, SuperSet.from_sd as from_sd, SuperSet.from_avg as from_avg,SubSet1.to_sd , SubSet1.to_avg,SuperSet.day_of_week,SuperSet.carrier , SuperSet.cabin_id as from_cabin_code, SubSet1.cabin_id as to_cabin_code from  (SELECT dcla.vx_aln_data_defnsID as cabin_id, cd.cabin, rf.carrier, day_of_week ,flight_number, boarding_point,off_point ,  avg(prorated_price) as from_avg, std(prorated_price)  as from_sd,dai.code as carrier_code   FROM UP_ra_feed rf  LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.carrier)   LEFT JOIN VX_data_defns doa on (doa.vx_aln_data_defnsID = rf.operating_airline_code)                LEFT JOIN VX_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code) LEFT JOIN VX_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) LEFT JOIN VX_airline_cabin_def cd on (dcla.alias = cd.level  AND cd.carrier  = rf.carrier)  LEFT JOIN VX_airline_cabin_class acc  on ( acc.carrier = rf.carrier AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class) LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = rf.pax_type AND ptc.aln_data_typeID = 18)   where " . $where . "  AND  rf.season_id = 0 AND acc.order > 0 AND cd.cabin = '" . $cabin_arr[0] . "' AND acc.is_revenue = 1 AND ptc.code NOT IN ('INF', 'INS', 'UNN')  group by cd.cabin , day_of_week,flight_number, boarding_point,off_point,rf.carrier  order by flight_number, day_of_week) as SuperSet
                                INNER JOIN (
                        select MainSet.code, MainSet.cabin_id,  MainSet.cabin ,MainSet.day_of_week, MainSet.to_sd, MainSet.to_avg, MainSet.boarding_point, MainSet.off_point , MainSet.flight_number ,MainSet.carrier from (SELECT acc.order as porder , dcla.vx_aln_data_defnsID as cabin_id, dcla.code ,rf.carrier, cd.cabin ,day_of_week ,flight_number, boarding_point,off_point ,  std(prorated_price)  as to_sd, avg(prorated_price) as to_avg, dai.code as carrier_code  FROM UP_ra_feed rf  LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.carrier)  LEFT JOIN VX_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) LEFT JOIN VX_airline_cabin_def cd on (dcla.alias = cd.level  AND cd.carrier  = rf.carrier)   LEFT JOIN VX_airline_cabin_class acc  on ( acc.carrier = rf.carrier AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class) LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = rf.pax_type AND ptc.aln_data_typeID = 18)   where " . $where . " AND  rf.season_id = 0 AND acc.order > 0 AND cd.cabin = '" . $cabin_arr[1] . "'  AND acc.is_revenue = 1 AND ptc.code NOT IN ('INF', 'INS', 'UNN')  group by rf.cabin , acc.order , day_of_week,flight_number, boarding_point,off_point,rf.carrier  order by acc.order desc
                        ) as MainSet
                                INNER JOIN
                                ( select max(corder) as porder, cabin ,  boarding_point,off_point,day_of_week,flight_number  , carrier from (SELECT acc.order as corder  , dcla.code ,rf.carrier,  std(prorated_price)  as to_sd, avg(prorated_price)  as to_avg, cd.cabin ,day_of_week ,flight_number, boarding_point,off_point , dai.code as carrier_code   FROM UP_ra_feed rf  LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.carrier)    LEFT JOIN VX_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin)  LEFT JOIN VX_airline_cabin_def cd on (dcla.alias = cd.level AND cd.carrier  = rf.carrier)  LEFT JOIN VX_airline_cabin_class acc  on ( acc.carrier = rf.carrier AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class) LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = rf.pax_type AND ptc.aln_data_typeID = 18)   where " . $where . "  AND  rf.season_id = 0 AND acc.order > 0 AND cd.cabin = '" . $cabin_arr[1] . "'  AND acc.is_revenue = 1 AND ptc.code NOT IN ('INF', 'INS', 'UNN')  group by cd.cabin , acc.order , day_of_week,flight_number, boarding_point,off_point,rf.carrier  order by acc.order desc) as MainSet group by  flight_number, boarding_point, off_point, carrier,day_of_week, cabin
                                ) SubSet  ON (MainSet.flight_number = SubSet.flight_number AND MainSet.boarding_point = SubSet.boarding_point AND MainSet.off_point = SubSet.off_point AND MainSet.day_of_week = SubSet.day_of_week AND MainSet.carrier = SubSet.carrier AND MainSet.porder = SubSet.porder )) as SubSet1 on (SuperSet.flight_number = SubSet1.flight_number AND SuperSet.boarding_point = SubSet1.boarding_point AND SuperSet.off_point = SubSet1.off_point AND SuperSet.day_of_week = SubSet1.day_of_week AND SuperSet.carrier = SubSet1.carrier) 
                        ";
                        $rResult = $this->install_m->run_query($sQuery);
                        $rResult1 = array_merge($rResult1, $rResult);
			if ( !$rResult) {
				$msg .= "<br>No matching records FROM RA FEED for NO SEASON carrer ID : $carrier_id,($airline_code) for CABINS ". $cabin_arr[0] . " => " . $cabin_arr[1]  ;
				$errors = 1;
			} else {
				$msg .= "<br>FOUND matching records FROM RA FEED for NO SEASON carrer ID : $carrier_id,($airline_code) for CABINS ". $cabin_arr[0] . " => " . $cabin_arr[1]  ;
			}
#echo "<br><br>$sQuery";
                }

                $rResult2 = array();
                foreach ($cabin_map_arr as $cabin_arr) {
                        $sQuery =  "SELECT SuperSet.cabin as from_cabin, SubSet1.cabin as to_cabin, SuperSet.flight_number, SuperSet.boarding_point, SuperSet.off_point, SuperSet.from_sd,  SuperSet.from_avg, SubSet1.to_avg, SubSet1.to_sd, SuperSet.season_id,SuperSet.carrier ,  SuperSet.cabin_id as from_cabin_code, SubSet1.cabin_id as to_cabin_code from  (SELECT dcla.vx_aln_data_defnsID as cabin_id, cd.cabin,dcla.code ,rf.carrier,season_id, flight_number, boarding_point,off_point ,  std(prorated_price)  as from_sd, avg(prorated_price) as from_avg, dai.code as carrier_code   FROM UP_ra_feed rf  LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.carrier)   LEFT JOIN VX_data_defns doa on (doa.vx_aln_data_defnsID = rf.operating_airline_code)                LEFT JOIN VX_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code) LEFT JOIN VX_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin)  LEFT JOIN VX_airline_cabin_def cd on (dcla.alias = cd.level AND cd.carrier  = rf.carrier)  LEFT JOIN VX_airline_cabin_class acc  on ( acc.carrier = rf.carrier AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class) LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = rf.pax_type AND ptc.aln_data_typeID = 18)   where " . $where . "  AND   rf.season_id > 0 AND acc.order > 0 AND cd.cabin = '" . $cabin_arr[0] . "'  AND acc.is_revenue = 1 AND ptc.code NOT IN ('INF', 'INS', 'UNN')  group by  cd.cabin , season_id,flight_number, boarding_point,off_point,season_id,rf.carrier  order by flight_number, season_id) as SuperSet
                        INNER JOIN (
                        select MainSet.code, MainSet.cabin ,  MainSet.cabin_id ,MainSet.season_id, MainSet.to_sd, MainSet.to_avg, MainSet.boarding_point, MainSet.off_point , MainSet.flight_number ,MainSet.carrier from (SELECT dcla.vx_aln_data_defnsID as cabin_id, acc.order as porder , dcla.code ,rf.carrier,season_id,cd.cabin ,flight_number, boarding_point,off_point ,  std(prorated_price)  as to_sd,  avg(prorated_price)  as to_avg ,dai.code as carrier_code  FROM UP_ra_feed rf  LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.carrier)  LEFT JOIN VX_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin)  LEFT JOIN VX_airline_cabin_def cd on (dcla.alias = cd.level  AND cd.carrier  = rf.carrier)   LEFT JOIN VX_airline_cabin_class acc  on ( acc.carrier = rf.carrier AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class) LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = rf.pax_type AND ptc.aln_data_typeID = 18)   where " . $where . "  AND   rf.season_id > 0 AND acc.order > 0 AND cd.cabin = '" . $cabin_arr[1] . "'  AND acc.is_revenue = 1 AND ptc.code NOT IN ('INF', 'INS', 'UNN')  group by cd.cabin , acc.order , season_id,flight_number, boarding_point,off_point,season_id,rf.carrier  order by acc.order desc
                        ) as MainSet
                                INNER JOIN
                                ( select max(corder) as porder,cabin ,  boarding_point,off_point,season_id,flight_number  , carrier from (SELECT acc.order as corder  , dcla.code ,rf.carrier, std(prorated_price)  as to_sd, avg(prorated_price) as to_avg, cd.cabin ,season_id ,flight_number, boarding_point,off_point , dai.code as carrier_code   FROM UP_ra_feed rf  LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.carrier)    LEFT JOIN VX_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin)  LEFT JOIN VX_airline_cabin_def cd on (dcla.alias = cd.level AND cd.carrier  = rf.carrier)  LEFT JOIN VX_airline_cabin_class acc  on ( acc.carrier = rf.carrier AND rf.cabin = acc.airline_cabin AND rf.class = acc.airline_class) LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = rf.pax_type AND ptc.aln_data_typeID = 18)   where " . $where . "  AND  rf.season_id > 0 AND acc.order > 0 AND cd.cabin = '" . $cabin_arr[1] . "'  AND acc.is_revenue = 1 AND ptc.code NOT IN ('INF', 'INS', 'UNN')  group by cd.cabin , acc.order , season_id,flight_number, boarding_point,off_point,season_id,rf.carrier  order by acc.order desc) as MainSet group by  flight_number, boarding_point, off_point, carrier,season_id,cabin
                                ) SubSet  ON (MainSet.flight_number = SubSet.flight_number AND MainSet.boarding_point = SubSet.boarding_point AND MainSet.off_point = SubSet.off_point AND MainSet.season_id = SubSet.season_id AND MainSet.carrier = SubSet.carrier AND MainSet.porder = SubSet.porder )) as SubSet1 on (SuperSet.flight_number = SubSet1.flight_number AND SuperSet.boarding_point = SubSet1.boarding_point AND SuperSet.off_point = SubSet1.off_point AND SuperSet.season_id = SubSet1.season_id AND SuperSet.carrier = SubSet1.carrier) 
                        ";
                        $rResult = $this->install_m->run_query($sQuery);
                        $rResult2 = array_merge($rResult, $rResult2);
			if ( !$rResult) {
				$msg .= "<br>No matching records FROM RA FEED for MATCING SEASON carrer ID : $carrier_id, ($airline_code) for CABINS ". $cabin_arr[0] . " => " . $cabin_arr[1];
				$errors = 1;
			} else {
				$msg .= "<br>Found matching records FROM RA FEED for MATCING SEASON carrer ID : $carrier_id, ($airline_code) for CABINS ". $cabin_arr[0] . " => " . $cabin_arr[1];
			}
#echo "<br><br>$sQuery";
                }

                $rResult = array_merge($rResult1, $rResult2);
		if ($rResult ) {

			foreach ($rResult as $feed) {
				if ($feed->season_id > 0) {
					$array['season_id'] = $feed->season_id;
					$array['frequency'] = 0;
				} else {

					$array['season_id'] = 0;
					$array['frequency'] = $feed->day_of_week;
				}

				$array['boarding_point'] = $feed->boarding_point;
				$array['off_point'] = $feed->off_point;
				$array['flight_number'] = $feed->flight_number;
				$array['carrier_code'] = $feed->carrier;


				//$fromCabin = explode(',',$feed->l_price);
				//$toCabin  = explode(',',$feed->u_price);

				//if(count($fromCabin) > 0  AND count($toCabin) > 0 ){
				$array['from_cabin'] = $feed->from_cabin_code;
				$array['to_cabin'] = $feed->to_cabin_code;
				$data = $this->calculate_Min_Max($feed->from_sd, $feed->to_sd, $feed->from_avg, $feed->to_avg);
				$array1['average'] = $data->average;
				$array1['min'] = $data->min;
				$array1['max'] = $data->max;
				$array1['slider_start'] = $data->slider_start;

                                if($array1['min']<$min || $array1['max']<$max || $array1['slider_start']<$slider_val)
                                {
                                        $array['active']=0;
                                }
                                else{
                                        $array['active']=1;
                                }
				$this->fclr_m->checkANDInsertFCLR($array, $array1);

				//}

			}
		} else {
			$errors = 1;
			$msg .= "<br>Sorry, Could not find matching records to generate FCLR for carrer ID : $carrier_id" .  " ($airline_code)";
		}
		}

		$this->mydebug->debug_log('fclr',$msg);
		$msg = "FCLR generated successfully!";
		if ( $errors) {
			$msg .= ", But hsa some errors. Please check FCLR log for more info. Note: FCLR will be genereated based on matched parameters like Boarding point, Off point, Depature day, across cabins for same flight number for pre defined  seasons..  ";
		}
               	$this->session->set_flashdata('success', $msg);
               redirect(base_url("fclr/index"));
        }


        public function delete_fclr_bulk_records()
        {
                $data_ids = $_REQUEST['data_ids'];
                $data_id_array = explode(",", $data_ids);
                if (!empty($data_id_array)) {
                        foreach ($data_id_array as $id) {

                                $this->data['rule'] = $this->fclr_m->get_single_fclr(array('fclr_id' => $id));
                                if ($this->data['rule']) {
                                        $this->fclr_m->delete_fclr($id);
                                }
                        }
                }
        }
}
