<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Make_payment extends Admin_Controller {
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
        $this->load->model("make_payment_m");
        $this->load->model("manage_salary_m");
        $this->load->model("teacher_m");
        $this->load->model("user_m");
        $this->load->model("systemadmin_m");
        $this->load->model("salary_template_m");
        $this->load->model("salaryoption_m");
        $this->load->model("hourly_template_m");

        $language = $this->session->userdata('lang');
        $this->lang->load('make_payment', $language);
    }


    protected function rules($salaryType = 1) {
        $rules = array(
            array(
                'field' => 'month',
                'label' => $this->lang->line("make_payment_month"),
                'rules' => 'trim|required|xss_clean|max_length[7]|callback_month_valid'
            ),
            array(
                'field' => 'payment_amount',
                'label' => $this->lang->line("make_payment_payment_amount"),
                'rules' => 'trim|required|xss_clean|max_length[11]|numeric'
            ),
            array(
                'field' => 'payment_method',
                'label' => $this->lang->line("make_payment_payment_method"),
                'rules' => 'trim|required|numeric|xss_clean|max_length[11]|callback_unique_payment_method'
            ),
            array(
                'field' => 'comments',
                'label' => $this->lang->line("make_payment_comments"),
                'rules' => 'trim|xss_clean|max_length[128]'
            ),
        );

        if($salaryType == 2) {
            $rules[] = array(
                'field' => 'total_hours',
                'label' => $this->lang->line("make_payment_total_hours"),
                'rules' => 'trim|required|xss_clean|max_length[11]|numeric'
            );
        }

        return $rules;
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

        $this->data['roles'] = $this->role_m->get_role();
        $setrole = htmlentities(escapeString($this->uri->segment(3)));
        
        if(!isset($setrole)) {
            $setrole = 0;
            $this->data['setrole'] = $setrole;
        } else {
            $this->data['setrole'] = $setrole;
        }

        if($setrole == 1) {
            $this->data['users'] = $this->systemadmin_m->get_systemadmin();
            $this->data['managesalary'] = pluck($this->manage_salary_m->get_order_by_manage_salary(array('roleID' => 1)), 'userID');
         } elseif($setrole == 2) {
            $this->data['users'] = $this->teacher_m->get_teacher();
            $this->data['managesalary'] = pluck($this->manage_salary_m->get_order_by_manage_salary(array('roleID' => 2)), 'userID');
        } else {
            $this->data['users'] = $this->user_m->get_order_by_user(array('roleID' => $setrole));
            $this->data['managesalary'] = pluck($this->manage_salary_m->get_order_by_manage_salary(array('roleID' => $setrole)), 'userID');
        }

        $this->data["subview"] = "make_payment/index";
        $this->load->view('_layout_main', $this->data);
    }

    public function add() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/datepicker/datepicker.css',
            ),
            'js' => array(
                'assets/datepicker/datepicker.js'
            )
        );

        $error = FALSE;
        $this->data['grosssalary'] = 0;
        $this->data['totaldeduction'] = 0;
        $this->data['netsalary'] = 0;

        if(permissionChecker('make_payment')) {
            $userID = htmlentities(escapeString($this->uri->segment(3)));
            $roleID = htmlentities(escapeString($this->uri->segment(4)));

            if((int)$userID && (int) $roleID) {
                if($roleID == 1) {
                    $user = $this->systemadmin_m->get_single_systemadmin(array('roleID' => $roleID, 'systemadminID' => $userID));
                    $this->data['usertype'] = $this->role_m->get_role($user->roleID);
                } elseif($roleID == 2) {
                    $user = $this->teacher_m->get_single_teacher(array('roleID' => $roleID, 'teacherID' => $userID));
                } else {
                    $user = $this->user_m->get_single_user(array('roleID' => $roleID, 'userID' => $userID));
                }

                $this->data['make_payments'] = $this->make_payment_m->get_order_by_make_payment(array('roleID' => $roleID, 'userID' => $userID));

                if(count($user)) {
                    $this->data['usertype'] = $this->role_m->get_role($user->roleID);
                    $this->data['user'] = $user;

                    $manageSalary = $this->manage_salary_m->get_single_manage_salary(array('roleID' => $roleID, 'userID' => $userID));
                    if(count($manageSalary)) {
                        $this->data['manage_salary'] = $manageSalary;

                        if($manageSalary->salary == 1) {
                            $this->data['salary_template'] = $this->salary_template_m->get_single_salary_template(array('salary_templateID' => $manageSalary->template));
                            if($this->data['salary_template']) {

                                $this->db->order_by("salary_optionID", "asc");
                                $this->data['salaryoptions'] = $this->salaryoption_m->get_order_by_salaryoption(array('salary_templateID' => $manageSalary->template));

                                $grosssalary = 0;
                                $totaldeduction = 0;
                                $netsalary = $this->data['salary_template']->basic_salary;
                                $grosssalarylist = array();
                                $totaldeductionlist = array();

                                if(count($this->data['salaryoptions'])) {
                                    foreach ($this->data['salaryoptions'] as $salaryOptionKey => $salaryOption) {
                                        if($salaryOption->option_type == 1) {
                                            $netsalary += $salaryOption->label_amount;
                                            $grosssalary += $salaryOption->label_amount;
                                            $grosssalarylist[$salaryOption->label_name] = $salaryOption->label_amount;
                                        } elseif($salaryOption->option_type == 2) {
                                            $netsalary -= $salaryOption->label_amount;
                                            $totaldeduction += $salaryOption->label_amount;
                                            $totaldeductionlist[$salaryOption->label_name] = $salaryOption->label_amount;
                                        }
                                    }
                                }

                                $this->data['grosssalary'] = $grosssalary;
                                $this->data['totaldeduction'] = $totaldeduction;
                                $this->data['netsalary'] = $netsalary;
                            } else {
                                $error = TRUE;
                            }
                        } elseif($manageSalary->salary == 2) {
                            $this->data['hourly_salary'] = $this->hourly_template_m->get_single_hourly_template(array('hourly_templateID'=> $manageSalary->template));
                            if(count($this->data['hourly_salary'])) {
                                $this->data['grosssalary'] = 0;
                                $this->data['totaldeduction'] = 0;
                                $this->data['netsalary'] = $this->data['hourly_salary']->hourly_rate;
                            } else {
                                $error = TRUE;
                            }
                        }

                        if($error == FALSE) {
                            if($_POST) {
                                $rules = $this->rules($manageSalary->salary);
                                $this->form_validation->set_rules($rules);
                                if ($this->form_validation->run() == FALSE) {
                                    $this->data['form_validation'] = validation_errors();
                                    $this->data["subview"] = "make_payment/add";
                                    $this->load->view('_layout_main', $this->data);
                                } else {
                                    $array = array(
                                        "month" => $this->input->post("month"),
                                        "gross_salary" => $this->data['grosssalary'],
                                        "total_deduction" => $this->data['totaldeduction'],
                                        "net_salary" => $this->data['netsalary'],
                                        'payment_amount' => $this->input->post('payment_amount'),
                                        "payment_method" => $this->input->post("payment_method"),
                                        "comments" => $this->input->post("comments"),
                                        'templateID' => $manageSalary->template,
                                        'salaryID' => $manageSalary->salary,
                                        'roleID' => $roleID,
                                        'userID' => $userID,
                                        'create_date'       => date("Y-m-d h:i:s"),
                                        'modify_date'       => date("Y-m-d h:i:s"),
                                        'create_userID'     => $this->session->userdata('loginuserID'),
                                        'create_username'   => $this->session->userdata('username'),
                                        'create_usertype'   => $this->session->userdata('usertype'),
                                    );

                                    if($manageSalary->salary == 2) {
                                        $array['total_hours'] = $this->input->post('total_hours');
                                    }

                                    $this->make_payment_m->insert_make_payment($array);
                                    $lastID = $this->db->insert_id();
                                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                    redirect(base_url("make_payment/add/$userID/$roleID"));
                                }
                            } else {
                                $this->data["subview"] = "make_payment/add";
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
                } else {
                    $this->data["subview"] = "error";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            redirect(base_url('exceptionpage/index'));
        }
    }

    public function view() {
        if(permissionChecker('make_payment')) {
            $id = htmlentities(escapeString($this->uri->segment(3)));
            if((int)$id) {
                $this->data['paymentMethod'] = array(
                    '1' => $this->lang->line('make_payment_payment_cash'),
                    '2' => $this->lang->line('make_payment_payment_cheque'),
                );

                $this->data['make_payment'] = $this->make_payment_m->get_single_make_payment(array('make_paymentID' => $id));

                if($this->data['make_payment']) {
                    $userID = $this->data['make_payment']->userID;
                    $roleID = $this->data['make_payment']->roleID;

                    if((int)$userID && (int) $roleID) {
            
                        $this->data['roleID'] = $roleID;
                        $this->data['userID'] = $userID;

                        if($roleID == 1) {
                            $user = $this->systemadmin_m->get_single_systemadmin(array('roleID' => $roleID, 'systemadminID' => $userID));
                        } elseif($roleID == 2) {
                            $user = $this->teacher_m->get_single_teacher(array('roleID' => $roleID, 'teacherID' => $userID));
                        } else {
                            $user = $this->user_m->get_single_user(array('roleID' => $roleID, 'userID' => $userID));
                        }

                        if(count($user)) {
                            $this->data['usertype'] = $this->role_m->get_role($user->roleID);
                            $this->data['user'] = $user;
                            $manageSalary = $this->manage_salary_m->get_single_manage_salary(array('roleID' => $roleID, 'userID' => $userID));
                            if(count($manageSalary)) {
                                $this->data['manage_salary'] = $manageSalary;

                                if($this->data['make_payment']->salaryID == 1) {
                                    $this->data['persent_salary_template'] = $this->salary_template_m->get_single_salary_template(array('salary_templateID' => $this->data['make_payment']->templateID));
                                } elseif($this->data['make_payment']->salaryID == 2) {
                                    $this->data['persent_salary_template'] = $this->hourly_template_m->get_single_hourly_template(array('hourly_templateID'=> $this->data['make_payment']->templateID));
                                }

                                if(count($this->data['persent_salary_template'])) {
                                    if($this->data['make_payment']->salaryID == 1) {

                                        $this->data['salary_template'] = $this->salary_template_m->get_single_salary_template(array('salary_templateID' => $this->data['make_payment']->templateID));

                                        if($this->data['salary_template']) {
                                            $this->db->order_by("salary_optionID", "asc");
                                            $this->data['salaryoptions'] = $this->salaryoption_m->get_order_by_salaryoption(array('salary_templateID' => $this->data['make_payment']->templateID));

                                            $grosssalary = 0;
                                            $totaldeduction = 0;
                                            $netsalary = $this->data['salary_template']->basic_salary;
                                            $grosssalarylist = array();
                                            $totaldeductionlist = array();

                                            if(count($this->data['salaryoptions'])) {
                                                foreach ($this->data['salaryoptions'] as $salaryOptionKey => $salaryOption) {
                                                    if($salaryOption->option_type == 1) {
                                                        $netsalary += $salaryOption->label_amount;
                                                        $grosssalary += $salaryOption->label_amount;
                                                        $grosssalarylist[$salaryOption->label_name] = $salaryOption->label_amount;
                                                    } elseif($salaryOption->option_type == 2) {
                                                        $netsalary -= $salaryOption->label_amount;
                                                        $totaldeduction += $salaryOption->label_amount;
                                                        $totaldeductionlist[$salaryOption->label_name] = $salaryOption->label_amount;
                                                    }
                                                }
                                            }

                                            $this->data['grosssalary'] = $grosssalary;
                                            $this->data['totaldeduction'] = $totaldeduction;
                                            $this->data['netsalary'] = $netsalary;
                                            $this->data["subview"] = "make_payment/view";
                                            $this->load->view('_layout_main', $this->data);
                                        } else {
                                            $this->data["subview"] = "error";
                                            $this->load->view('_layout_main', $this->data);
                                        }
                                    } elseif($this->data['make_payment']->salaryID == 2) {
                                        $this->data['hourly_salary'] = $this->hourly_template_m->get_single_hourly_template(array('hourly_templateID'=> $this->data['make_payment']->templateID));
                                        if(count($this->data['hourly_salary'])) {

                                            $this->data['grosssalary'] = 0;
                                            $this->data['totaldeduction'] = 0;
                                            $this->data['netsalary'] = $this->data['hourly_salary']->hourly_rate;

                                            $this->data["subview"] = "make_payment/view";
                                            $this->load->view('_layout_main', $this->data);
                                        } else {
                                            $this->data["subview"] = "error";
                                            $this->load->view('_layout_main', $this->data);
                                        }
                                    } else {
                                        $this->data["subview"] = "error";
                                        $this->load->view('_layout_main', $this->data);
                                    }
                                } else{
                                    $this->data["subview"] = "error";
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
                    } else {
                        $this->data["subview"] = "error";
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
        } else {
            redirect(base_url('exceptionpage/index'));
        }
    }

    public function delete() {
        if(permissionChecker('make_payment')) {
            $id = htmlentities(escapeString($this->uri->segment(3)));
            if((int)$id) {
                $this->data['make_payment'] = $this->make_payment_m->get_single_make_payment(array('make_paymentID' => $id));
                if($this->data['make_payment']) {
                    $this->make_payment_m->delete_make_payment($id);
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                    redirect(base_url("make_payment/add/".$this->data['make_payment']->userID.'/'.$this->data['make_payment']->roleID));
                } else {
                    redirect(base_url("make_payment/index"));
                }
            } else {
                redirect(base_url("make_payment/index"));
            }
        } else {
            redirect(base_url('exceptionpage/index'));
        }
    }

    public function role_list() {
        $role = $this->input->post('id');
        if((int)$role) {
            $string = base_url("make_payment/index/$role");
            echo $string;
        } else {
            echo base_url("make_payment/index");
        }
    }

    public function unique_payment_method() {
        if($this->input->post('payment_method') == 0) {
            $this->form_validation->set_message('unique_payment_method', 'The %s field is required.');
            return FALSE;
        }
        return TRUE;
    }

    public function month_valid($date) {
        if($date) {
            if(strlen($date) <7) {
                $this->form_validation->set_message("month_valid", "%s is not valid mm-yyyy");
                return FALSE;
            } else {
                $arr = explode("-", $date);
                $mm = $arr[0];
                $yyyy = $arr[1];
                if(checkdate($mm, 11, $yyyy)) {
                    return TRUE;
                } else {
                    $this->form_validation->set_message("month_valid", "%s is not valid mm-yyyy");
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
}
