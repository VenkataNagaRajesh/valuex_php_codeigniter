<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pref_setting extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("preference_m");
		$this->load->model("airports_m");		
                $this->load->model("airline_m");
                $this->load->model("user_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('preference', $language);
        $this->data['icon'] = $this->menu_m->getMenu(array("link"=>"pref_setting"))->icon;		
	}
	
	function vallist($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("vallist", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}

	public function app_settings() {	
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
        $this->data['preferences'] = $this->preference_m->get_preferenceslist(array('pref_type' => '7'));
		if($_POST){
           foreach($_POST as $key => $value){			
		     $info = explode('-',$key);
             $array['pref_value'] = $value;
			 $array['modify_userID'] = $this->session->userdata('loginuserID');
			 $array['modify_date'] = time();
			 $this->preference_m->update_preference($array,$info[1]);
		   }
		  $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		  redirect(base_url("pref_setting"));			
		} else {			
		  $this->data["subview"] = "preference/setting";
		  $this->load->view('_layout_main', $this->data);		
		}
	}


	public function airline_settings() {
	
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




	                $userID = $this->session->userdata('loginuserID');
                $roleID = $this->session->userdata('roleID');
             if($roleID != 1){
                                                 $this->data['airlines'] = $this->user_m->getUserAirlines($userID);
                                                   } else {
                   $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }

       // $this->data['preferences'] = $this->preference_m->get_preferenceslist(array('pref_type' => '7'));
                //print_r( $this->data['preferences']); exit;
                if($_POST){
			  if(!empty($this->input->post('airline_id'))){
	        	          $this->data['airlineID'] = $this->input->post('airline_id');
        	        }

			//$is_default_values =  $this->input->post('pref_default_values');
			$airline_id = $this->input->post('airline_id');
           foreach($_POST as $key => $value){
			if (preg_match("/prefvalue-/", $key))  {
	                     $info = explode('-',$key);
             		 $array['pref_value'] = $value;
                         $array['modify_userID'] = $this->session->userdata('loginuserID');
                         $array['modify_date'] = time();
			$is_default_value = $this->input->post('pref_default-'.$info[1]);
			 if($is_default_value == 0) {
				
			 $pref = $this->preference_m->get_preference(array('VX_aln_preferenceID'=>$info[1]));
				$insert = array(
                                    "categoryID" => $pref->categoryID,
                                        "pref_type" => $pref->pref_type,
					"pref_type_value" => $airline_id,
                                        "pref_code" => $pref->pref_code,
                                        "pref_display_name" => $pref->pref_display_name,
                                        "pref_get_value_type" => $pref->pref_get_value_type,
                                        "pref_get_value" => $pref->pref_get_value,
                                        "pref_value" => $value,
                                        "create_date" => time(),
                                        "modify_date" => time(),
                                        "create_userID" => $this->session->userdata('loginuserID'),
                    			"modify_userID" => $this->session->userdata('loginuserID'),
                                );

                         	$this->preference_m->insert_preference($insert);
			} else {	
			$this->preference_m->update_preference($array,$info[1]);
			}

			}
                   }
                  $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		$this->data["subview"] = "preference/airline_settings";
                  $this->load->view('_layout_main', $this->data);
                  //redirect(base_url("pref_setting/airline_settings"));
                } else {
                  $this->data["subview"] = "preference/airline_settings";
                  $this->load->view('_layout_main', $this->data);
                }



	}




	public function user_preferences() {


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


                        $userID = $this->session->userdata('loginuserID');
                $roleID = $this->session->userdata('roleID');
                if($roleID != 1){
                                                 $this->data['airlines'] = $this->user_m->getUserAirlines($userID);
                                                   } else {
                   $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }

       // $this->data['preferences'] = $this->preference_m->get_preferenceslist(array('pref_type' => '7'));
                //print_r( $this->data['preferences']); exit;
                if($_POST){
                        //$is_default_values =  $this->input->post('pref_default_values');
                        $airline_id = $this->input->post('airline_id');
           foreach($_POST as $key => $value){
                        if (preg_match("/prefvalue-/", $key))  {
                             $info = explode('-',$key);
                         $array['pref_value'] = $value;
                         $array['modify_userID'] = $this->session->userdata('loginuserID');
                         $array['modify_date'] = time();
                        $is_default_value = $this->input->post('pref_default-'.$info[1]);
                         if($is_default_value == 0) {

                         $pref = $this->preference_m->get_preference(array('VX_aln_preferenceID'=>$info[1]));
                                $insert = array(
                                    "categoryID" => $pref->categoryID,
					"pref_type" => $pref->pref_type,
                                       "pref_type_value" => $this->session->userdata('loginuserID'),
                                        "pref_code" => $pref->pref_code,
                                        "pref_display_name" => $pref->pref_display_name,
                                        "pref_get_value_type" => $pref->pref_get_value_type,
                                        "pref_get_value" => $pref->pref_get_value,
                                        "pref_value" => $value,
                                        "create_date" => time(),
                                        "modify_date" => time(),
                                        "create_userID" => $this->session->userdata('loginuserID'),
                                        "modify_userID" => $this->session->userdata('loginuserID'),
                                );

                                $this->preference_m->insert_preference($insert);
                        } else {
                        $this->preference_m->update_preference($array,$info[1]);
                        }

                        }
                   }
			
                  $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		$this->data["subview"] = "preference/user_preferences";
                  $this->load->view('_layout_main', $this->data);

                  //redirect(base_url("pref_setting/user_preferences"));
                } else {
                  $this->data["subview"] = "preference/user_preferences";
                  $this->load->view('_layout_main', $this->data);
                }



        }







	public function getPreferencesbyType(){
		 if($this->input->post('pref_type_id')){
			$id = $this->input->post('id');
			$pref_type_id = $this->input->post('pref_type_id');

			// get airline specific preferences any exist
                        $preferences1 = $this->preference_m->get_preferenceslist(array('pref_type' => $pref_type_id, 'pref_type_value' => $id));

			if(count($preferences1) > 0){
				// check and get default ones other than airline specific;
				$list = array_column($preferences1,'pref_code');
				$preference2  = $this->preference_m->get_preferenceslist_not_in('pref_code',$list, array('pref_type' => $pref_type_id, 'pref_type_value' => '0'));
				$preferences = array_merge($preferences1,$preference2);
				
			} else {
				$preferences = $this->preference_m->get_preferenceslist(array('pref_type' => $pref_type_id, 'pref_type_value' => '0'));
			}


			/*
			if(count($preferences1) == 0) {
			 	$preferences2 = $this->preference_m->get_preferenceslist(array('pref_type' => $this->input->post('pref_type_id'), 'pref_type_value' => '0'));			
				echo "<input type='hidden' id='pref_default_values' name='pref_default_values' value='1'>";
				
			}*/

			if($pref_type_id == '24' ){
				$airline_name = $this->airports_m->getDefDataCodeByIDANDType($id,'12');
				echo "<h4 style='color:orange'> Preferences list for Carrier <b> " .$airline_name ."</b></h4>";
			}

			if(count($preferences) > 0 ) {
			 foreach($preferences as $pref) { if($pref->active == 1) { 
                        if(form_error('prefvalue-'.$pref->VX_aln_preferenceID))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";

				
			  $label = 'prefvalue-'.$pref->VX_aln_preferenceID;

			echo "<label for=\"$label\" class='col-sm-2 control-label'>";
			echo $pref->pref_display_name;
                        echo "</label>";
			echo "<input type='hidden' id='pref_default-$pref->VX_aln_preferenceID' name='pref_default-$pref->VX_aln_preferenceID' value=$pref->pref_type_value>";
                        echo "<div class='col-sm-6'>";
                                                  
			 if($pref->pref_get_value_type == 10 ) {

                         echo  "<input type='text' class='form-control' id=\"$label\" name=\"$label\" value=".set_value($label, $pref->pref_value)." >";
                          } else if($pref->pref_get_value_type == 9) {
				$r_value1 = ($pref->pref_value == 1) ? 'checked' : '';
				$r_value2 = ($pref->pref_value == 0)?'checked':'';
				echo " <input type='radio' id=\"$label\" name=\"$label\" value='1' $r_value1 > TRUE";
                                echo " <input type='radio' id=\"$label\" name=\"$label\" value='0' $r_value2> FALSE";
                                                  
			  } else {
                                                     
				

                               if($pref->pref_code=='TYPE_OF_BAG'){
                                       $typelist[0] = "Select Value";
                                       $typelist[1] = "KG";
                                       $typelist[2] = "PC";

                                        echo form_dropdown($label, $typelist,set_value($label,$pref->pref_value), "id=$label class='form-control hide-dropdown-icon select2'");
                               }else{
                                       $list =$this->airports_m->getDefns($pref->pref_get_value);
                                        $typelist[0] = "Select Value";
                                        foreach($list as $defn){
                                                $typelist[$defn->vx_aln_data_defnsID] = $defn->aln_data_value;
                                        }
                                        echo form_dropdown($label, $typelist,set_value($label,$pref->pref_value), "id=$label class='form-control hide-dropdown-icon select2'");
                                }
                                                   
			} 
                           echo "</div>";
                        echo "<span class='col-sm-4 control-label'>";
                       echo form_error('pref_value-'.$pref->VX_aln_preferenceID);
                       echo " </span>";
                    	echo "</div>";
                                    } } 
			} else {
				echo "No Preferences Set";
			}

                } 


        }

}
