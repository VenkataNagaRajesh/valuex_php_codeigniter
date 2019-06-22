<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailandsms extends Admin_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('usertype_m');
		$this->load->model("smssettings_m");		
		$this->load->model('user_m');		
		$this->load->model('mailandsms_m');
		$this->load->model('mailandsmstemplate_m');
		$this->load->model('mailandsmstemplatetag_m');
		$this->load->library("email");
		$this->load->library("clickatell");
		$this->load->library("twilio");
		$this->load->library("bulk");
		$this->load->library("msg91");
		$language = $this->session->userdata('lang');
		$this->lang->load('mailandsms', $language);

	}

	protected function rules_mail() {
		$rules = array(
			array(
				'field' => 'email_usertypeID',
				'label' => $this->lang->line("mailandsms_usertype"),
				'rules' => 'trim|required|xss_clean|max_length[15]|callback_check_email_usertypeID'
			),
			array(
				'field' => 'email_schoolyear',
				'label' => $this->lang->line("mailandsms_schoolyear"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_class',
				'label' => $this->lang->line("mailandsms_class"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_users',
				'label' => $this->lang->line("mailandsms_users"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_template',
				'label' => $this->lang->line("mailandsms_template"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'email_subject',
				'label' => $this->lang->line("mailandsms_subject"),
				'rules' => 'trim|required|xss_clean|max_length[255]'
			),
			array(
				'field' => 'email_message',
				'label' => $this->lang->line("mailandsms_message"),
				'rules' => 'trim|required|xss_clean|max_length[20000]'
			),
		);
		return $rules;
	}

	protected function rules_sms() {
		$rules = array(
			array(
				'field' => 'sms_usertypeID',
				'label' => $this->lang->line("mailandsms_usertypeID"),
				'rules' => 'trim|required|xss_clean|max_length[15]|callback_check_sms_usertypeID'
			),
			array(
				'field' => 'sms_schoolyear',
				'label' => $this->lang->line("mailandsms_schoolyear"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_class',
				'label' => $this->lang->line("mailandsms_select_class"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_users',
				'label' => $this->lang->line("mailandsms_users"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_template',
				'label' => $this->lang->line("mailandsms_template"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'sms_getway',
				'label' => $this->lang->line("mailandsms_getway"),
				'rules' => 'trim|required|xss_clean|max_length[15]|callback_check_getway'
			),
			array(
				'field' => 'sms_message',
				'label' => $this->lang->line("mailandsms_message"),
				'rules' => 'trim|required|xss_clean|max_length[20000]'
			),
		);
		return $rules;
	}

	public function index() {
		$this->data['mailandsmss'] = $this->mailandsms_m->get_mailandsms_with_usertypeID();
		$this->data["subview"] = "mailandsms/index";
		$this->load->view('_layout_main', $this->data);
	}

	public function add() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css',
				'assets/editor/jquery-te-1.4.0.css'
			),
			'js' => array(
				'assets/select2/select2.js',
				'assets/editor/jquery-te-1.4.0.min.js'
			)
		);
		$this->data['usertypes'] = $this->usertype_m->get_usertype();
	    /* Start For Email */
		$email_usertypeID = $this->input->post("email_usertypeID");
		if($email_usertypeID && $email_usertypeID != 'select') {
			$this->data['email_usertypeID'] = $email_usertypeID;

		} else {
			$this->data['email_usertypeID'] = 'select';
		}
		/* End For Email */

		/* Start For SMS */
		$sms_usertypeID = $this->input->post("sms_usertypeID");
		if($sms_usertypeID && $sms_usertypeID != 'select') {
			$this->data['sms_usertypeID'] = $sms_usertypeID;
		} else {
			$this->data['sms_usertypeID'] = 'select';
		}
		/* End For SMS */

		if($_POST) {
			if($this->input->post('type') == "email") {
				$rules = $this->rules_mail();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					// echo validation_errors();
					$this->data["email"] = 1;
					$this->data["sms"] = 0;
					$this->data["subview"] = "mailandsms/add";
					$this->load->view('_layout_main', $this->data);
				} else {
					$usertypeID = $this->input->post('email_usertypeID');
                      /* FOR ALL USERS */
						$userID = $this->input->post('email_users');
						if($userID == 'select') {
							$message = $this->input->post('email_message');
							$multiusers = $this->user_m->get_order_by_user(array('usertypeID' => $usertypeID));
							if(count($multiusers)) {
								$countusers = '';
								foreach ($multiusers as $key => $multiuser) {
									$this->userConfigEmail($message, $multiuser, $usertypeID);
									$countusers .= $multiuser->name .' ,';
								}
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $countusers,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID')
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$message = $this->input->post('email_message');
							$singleuser = $this->user_m->get_user($userID);
							if(count($singleuser)) {
								$this->userConfigEmail($message, $singleuser, $usertypeID);
								$array = array(
									'usertypeID' => $usertypeID,
									'users' => $singleuser->name,
									'type' => ucfirst($this->input->post('type')),
									'message' => $this->input->post('email_message'),
									'year' => date('Y'),
									'senderusertypeID' => $this->session->userdata('usertypeID'),
									'senderID' => $this->session->userdata('loginuserID'),
									'userID' => $userID,
									'status' => 1
								);
								$this->mailandsms_m->insert_mailandsms($array);
								redirect(base_url('mailandsms/index'));
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					
				}
			} elseif($this->input->post('type') == "sms") {
				$rules = $this->rules_sms();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					echo validation_errors();
					$this->data["email"] = 0;
					$this->data["sms"] = 1;
					$this->data["subview"] = "mailandsms/add";
					$this->load->view('_layout_main', $this->data);
				} else {
					$getway = $this->input->post('sms_getway');
					$usertypeID = $this->input->post('sms_usertypeID');

					 /* FOR ALL USERS */
						$userID = $this->input->post('sms_users');
						if($userID == 'select') {
							$countusers = '';
							$retval = 1;
							$retmess = '';
							$message = $this->input->post('sms_message');
							$multiusers = $this->user_m->get_order_by_user(array('usertypeID' => $usertypeID));
							if(count($multiusers)) {
								foreach ($multiusers as $key => $multiuser) {
									$status = $this->userConfigSMS($message, $multiuser, $usertypeID, $getway);
									$countusers .= $multiuser->name .' ,';

									if($status['check'] == FALSE) {
										$retval = 0;
										$retmess = $status['message'];
										break;
									}
								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $countusers,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						} else {
							$retval = 1;
							$retmess = '';
							$message = $this->input->post('sms_message');
							$singleuser = $this->user_m->get_user($userID);
							if(count($singleuser)) {
								$status = $this->userConfigSMS($message, $singleuser, $usertypeID, $getway);
								if($status['check'] == FALSE) {
									$retval = 0;
									$retmess = $status['message'];
								}

								if($retval == 1) {
									$array = array(
										'usertypeID' => $usertypeID,
										'users' => $singleuser->name,
										'type' => ucfirst($this->input->post('type')),
										'message' => $this->input->post('sms_message'),
										'year' => date('Y'),
										'senderusertypeID' => $this->session->userdata('usertypeID'),
										'senderID' => $this->session->userdata('loginuserID')
									);
									$this->mailandsms_m->insert_mailandsms($array);
									redirect(base_url('mailandsms/index'));
								} else {
									$this->session->set_flashdata('error', $retmess);
									redirect(base_url("mailandsms/add"));
								}
							} else {
								$this->session->set_flashdata('error', $this->lang->line('mailandsms_notfound_error'));
								redirect(base_url('mailandsms/add'));
							}
						}
					
				}
			}
		} else {
			$this->data["email"] = 1;
			$this->data["sms"] = 0;
			$this->data["subview"] = "mailandsms/add";
			$this->load->view('_layout_main', $this->data);
		}
	}

	function userConfigEmail($message, $user, $usertypeID) {		
			$message = str_replace('[first_name]', 'Lakshmi', $message);
			$message = str_replace('[last_name]', 'Amujuru', $message);
			$message = str_replace('[pnr_ref]', 'WQ1235', $message);
			
			if($user->email) {
				$subject = $this->input->post('email_subject');
				$email = $user->email;
				$this->email->set_mailtype("html");
				$this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($message);

				if($this->email->send()) {
					$this->session->set_flashdata('success', $this->lang->line('mail_success'));
				} else {
					$this->session->set_flashdata('error', $this->lang->line('mail_error'));
				}
			}
	}

	function userConfigSMS($message, $user, $usertypeID, $getway) {
		if($user && $usertypeID) {
			$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => $usertypeID));

			if($usertypeID == 2) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 2));
			} elseif($usertypeID == 3) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 3));
			} elseif($usertypeID == 4) {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 4));
			} else {
				$userTags = $this->mailandsmstemplatetag_m->get_order_by_mailandsmstemplatetag(array('usertypeID' => 1));
			}

			if(count($userTags)) {
				foreach ($userTags as $key => $userTag) {
					if($userTag->tagname == '[name]') {
						if($user->name) {
							$message = str_replace('[name]', $user->name, $message);
						} else {
							$message = str_replace('[name]', ' ', $message);
						}
					} elseif($userTag->tagname == '[designation]') {
						if($user->designation) {
							$message = str_replace('[designation]', $user->designation, $message);
						} else {
							$message = str_replace('[designation]', ' ', $message);
						}
					} elseif($userTag->tagname == '[dob]') {
						if($user->dob) {
							$dob =  date("d M Y", strtotime($user->dob));
							$message = str_replace('[dob]', $dob, $message);
						} else {
							$message = str_replace('[dob]', ' ', $message);
						}
					} elseif($userTag->tagname == '[gender]') {
						if($user->sex) {
							$message = str_replace('[gender]', $user->sex, $message);
						} else {
							$message = str_replace('[gender]', ' ', $message);
						}
					} elseif($userTag->tagname == '[religion]') {
						if($user->religion) {
							$message = str_replace('[religion]', $user->religion, $message);
						} else {
							$message = str_replace('[religion]', ' ', $message);
						}
					} elseif($userTag->tagname == '[email]') {
						if($user->email) {
							$message = str_replace('[email]', $user->email, $message);
						} else {
							$message = str_replace('[email]', ' ', $message);
						}
					} elseif($userTag->tagname == '[phone]') {
						if($user->phone) {
							$message = str_replace('[phone]', $user->phone, $message);
						} else {
							$message = str_replace('[phone]', ' ', $message);
						}
					} elseif($userTag->tagname == '[address]') {
						if($user->address) {
							$message = str_replace('[address]', $user->address, $message);
						} else {
							$message = str_replace('[address]', ' ', $message);
						}
					} elseif($userTag->tagname == '[jod]') {
						if($user->jod) {
							$jod =  date("d M Y", strtotime($user->jod));
							$message = str_replace('[jod]', $jod, $message);
						} else {
							$message = str_replace('[jod]', ' ', $message);
						}
					} elseif($userTag->tagname == '[username]') {
						if($user->username) {
							$message = str_replace('[username]', $user->username, $message);
						} else {
							$message = str_replace('[username]', ' ', $message);
						}
					} elseif($userTag->tagname == "[father's_name]") {
						if($user->father_name) {
							$message = str_replace("[father's_name]", $user->father_name, $message);
						} else {
							$message = str_replace("[father's_name]", ' ', $message);
						}
					} elseif($userTag->tagname == "[mother's_name]") {
						if($user->mother_name) {
							$message = str_replace("[mother's_name]", $user->mother_name, $message);
						} else {
							$message = str_replace("[mother's_name]", ' ', $message);
						}
					} elseif($userTag->tagname == "[father's_profession]") {
						if($user->father_profession) {
							$message = str_replace("[father's_profession]", $user->father_profession, $message);
						} else {
							$message = str_replace("[father's_profession]", ' ', $message);
						}
					} elseif($userTag->tagname == "[mother's_profession]") {
						if($user->mother_profession) {
							$message = str_replace("[mother's_profession]", $user->mother_profession, $message);
						} else {
							$message = str_replace("[mother's_profession]", ' ', $message);
						}
					} elseif($userTag->tagname == '[class/department]') {
						$classes = $this->classes_m->get_classes($user->classesID);
						if(count($classes)) {
							$message = str_replace('[class/department]', $classes->classes, $message);
						} else {
							$message = str_replace('[class/department]', ' ', $message);
						}
					} elseif($userTag->tagname == '[roll]') {
						if($user->roll) {
							$message = str_replace("[roll]", $user->roll, $message);
						} else {
							$message = str_replace("[roll]", ' ', $message);
						}
					} elseif($userTag->tagname == '[country]') {
						if($user->country) {
							$message = str_replace("[country]", $this->data['allcountry'][$user->country], $message);
						} else {
							$message = str_replace("[country]", ' ', $message);
						}
					} elseif($userTag->tagname == '[state]') {
						if($user->state) {
							$message = str_replace("[state]", $user->state, $message);
						} else {
							$message = str_replace("[state]", ' ', $message);
						}
					} elseif($userTag->tagname == '[register_no]') {
						if($user->registerNO) {
							$message = str_replace("[register_no]", $user->registerNO, $message);
						} else {
							$message = str_replace("[register_no]", ' ', $message);
						}
					} elseif($userTag->tagname == '[section]') {
						if($user->sectionID) {
							$section = $this->section_m->get_section($user->sectionID);
							if(count($section)) {
								$message = str_replace('[section]', $section->section, $message);
							} else {
								$message = str_replace('[section]',' ', $message);
							}
						} else {
							$message = str_replace("[section]", ' ', $message);
						}
					}



				}
			}

			if($user->phone) {
				$send = $this->allgetway_send_message($getway, $user->phone, $message);
				return $send;
			} else {
				$send = array('check' => TRUE);
				return $send;
			}
		}
	}

	function alltemplate() {
		if($this->input->post('usertypeID') == 'select') {
			echo '<option value="select">'.$this->lang->line('mailandsms_select_template').'</option>';
		} else {
			$usertypeID = $this->input->post('usertypeID');
			$type = $this->input->post('type');

			$templates = $this->mailandsmstemplate_m->get_order_by_mailandsmstemplate(array('usertypeID' => $usertypeID, 'type' => $type));
			echo '<option value="select">'.$this->lang->line('mailandsms_select_template').'</option>';
			if(count($templates)) {
				foreach ($templates as $key => $template) {
					echo '<option value="'.$template->mailandsmstemplateID.'">'. $template->name  .'</option>';
				}
			}
		}
	}

	function allusers() {
		if($this->input->post('usertypeID') == 'select') {
			echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
		} else {
			$usertypeID = $this->input->post('usertypeID');
 			$users = $this->user_m->get_order_by_user(array('usertypeID' => $usertypeID));
				if(count($users)) {
					echo "<option value='select'>".$this->lang->line('mailandsms_select_users')."</option>";
					foreach ($users as $key => $user) {
						echo "<option value='".$user->userID."'>".$user->name.'</option>';
					}
				} else {
					echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
				}
			
		}
	}

	function allstudent() {
		$schoolyearID = $this->input->post('schoolyear');
		$classesID = $this->input->post('classes');
		if((int)$schoolyearID && (int)$classesID) {
			$students = $this->student_m->get_order_by_student(array('schoolyearID' => $schoolyearID, 'classesID' => $classesID));

			if(count($students)) {
				echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
				foreach ($students as $key => $student) {
					echo '<option value="'.$student->studentID.'">'.$student->name.'</option>';
				}
			} else {
				echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
			}
		} else {
			echo '<option value="select">'.$this->lang->line('mailandsms_select_users').'</option>';
		}
	}

	function check_email_usertypeID() {
		if($this->input->post('email_usertypeID') == 'select') {
			$this->form_validation->set_message("check_email_usertypeID", "The %s field is required");
	     	return FALSE;
		} else {
			return TRUE;
		}
	}

	function alltemplatedesign() {
		if((int)$this->input->post('templateID')) {
			$templateID = $this->input->post('templateID');
			$templates = $this->mailandsmstemplate_m->get_mailandsmstemplate($templateID);
			if(count($templates)) {
				echo $templates->template;
			}
		} else {
			echo '';
		}
	}

	function check_sms_usertypeID() {
		if($this->input->post('sms_usertypeID') == 'select') {
			$this->form_validation->set_message("check_sms_usertypeID", "The %s field is required");
	     	return FALSE;
		} else {
			return TRUE;
		}
	}

	function check_getway() {
		if($this->input->post('sms_getway') == 'select') {
			$this->form_validation->set_message("check_getway", "The %s field is required");
	     	return FALSE;
		} else {

			$getway = $this->input->post('sms_getway');
			$arrgetway = array('clickatell', 'twilio', 'bulk', 'msg91');
			if(in_array($getway, $arrgetway)) {
				if($getway == "clickatell") {
					if($this->clickatell->ping() == TRUE) {
						return TRUE;
					} else {
						$this->form_validation->set_message("check_getway", 'Setup Your clickatell Account');
	     				return FALSE;
					}
				} elseif($getway == 'twilio') {
					$get = $this->twilio->get_twilio();
					$ApiVersion = $get['version'];
					$AccountSid = $get['accountSID'];
					$check = $this->twilio->request("/$ApiVersion/Accounts/$AccountSid/Calls");

					if($check->IsError) {
						$this->form_validation->set_message("check_getway", $check->ErrorMessage);
	     				return FALSE;
					}
					return TRUE;
				} elseif($getway == 'bulk') {
					if($this->bulk->ping() == TRUE) {
						return TRUE;
					} else {
						$this->form_validation->set_message("check_getway", 'Invalid Username or Password');
	     				return FALSE;
					}
				} elseif($getway == 'msg91') {
                    return true;
//					if($this->msg91->ping() == TRUE) {
//						return TRUE;
//					} else {
//						$this->form_validation->set_message("check_getway", 'Invalid auth key');
//	     				return FALSE;
//					}
				}
			} else {
				$this->form_validation->set_message("check_getway", "The %s field is required");
	     		return FALSE;
			}


		}
	}

	private function allgetway_send_message($getway, $to, $message) {
		$result = array();
		if($getway == "clickatell") {
			if($to) {
				$this->clickatell->send_message($to, $message);
				$result['check'] = TRUE;
				return $result;
			}
		} elseif($getway == 'twilio') {
			$get = $this->twilio->get_twilio();
			$from = $get['number'];
			if($to) {
				$response = $this->twilio->sms($from, $to, $message);
				if($response->IsError) {
					$result['check'] = FALSE;
					$result['message'] = $response->ErrorMessage;
					return $result;
				} else {
					$result['check'] = TRUE;
					return $result;
				}

			}
		} elseif($getway == 'bulk') {
			if($to) {
				if($this->bulk->send($to, $message) == TRUE)  {
					$result['check'] = TRUE;
					return $result;
				} else {
					$result['check'] = FALSE;
					$result['message'] = "Check your bulk account";
					return $result;
				}
			}
		} elseif($getway == 'msg91') {
			if($to) {
				if($this->msg91->send($to, $message) == TRUE)  {
					$result['check'] = TRUE;
					return $result;
				} else {
					$result['check'] = FALSE;
					$result['message'] = "Check your msg91 account";
					return $result;
				}
			}
		}
	}

	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['mailandsms'] = $this->mailandsms_m->get_mailandsms($id);
			if($this->data['mailandsms']) {
				$this->data["subview"] = "mailandsms/view";
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

}


