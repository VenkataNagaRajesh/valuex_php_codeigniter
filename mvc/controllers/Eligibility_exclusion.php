<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eligibility_exclusion extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("airports_m");
		$this->load->model('marketzone_m');
		$this->load->model('eligibility_exclusion_m');
		$this->load->model('airline_cabin_def_m');
		$this->load->model('airline_m');
		$this->load->model('user_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('eligibility_exclusion', $language);	
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'desc',
				'label' => $this->lang->line("desc"),
				'rules' => 'trim|required|xss_clean|max_length[200]'
			),
			array(
				'field' => 'orig_level_id',
				'label' => $this->lang->line("orig_level_id"),
				'rules' => 'trim|max_length[200]|xss_clean'
			),
   		    array(
                		'field' => 'orig_level_value',
                		'label' => $this->lang->line("orig_level_value"),
                		'rules' => 'trim|max_length[200]|xss_clean'
                       ),

			  array(
                                'field' => 'dest_level_id',
                                'label' => $this->lang->line("dest_level_id"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),
                    array(
                                'field' => 'dest_level_value',
                                'label' => $this->lang->line("dest_level_value"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                       ),



			 array(
                                'field' => 'carrier',
                                'label' => $this->lang->line("carrier"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valDestLevel'
                       ),


			array(
                 		'field' => 'flight_nbr_start',
                 		'label' => $this->lang->line("flight_nbr_start"),
                 		'rules' => 'trim|integer|max_length[4]|xss_clean|callback_FlightNbrStartCheck'
            		),
			array(
          		       'field' => 'flight_nbr_end',
                 		'label' => $this->lang->line("flight_nbr_end"),
                 		'rules' => 'trim|integer|max_length[4]|xss_clean|callback_FlightNbrEndCheck'
            		),
			array(
                 		'field' => 'frequency',
                 		'label' => $this->lang->line("frequency"),
                 		'rules' => 'trim|max_length[7]|xss_clean|callback_valFrequency'
            		),
			array(
                		 'field' => 'flight_efec_date',
                		 'label' => $this->lang->line("flight_efec_date"),
                 		'rules' => 'trim|max_length[200]|xss_clean|callback_validateEfecDate'
            		),
			array(
               			  'field' => 'flight_disc_date',
                 		'label' => $this->lang->line("flight_disc_date"),
                 		'rules' => 'trim|max_length[200]|xss_clean|callback_validateDiscDate'
            		),
			array(
                                 'field' => 'flight_dep_start_hrs',
                                 'label' => $this->lang->line("flight_dep_start"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),

			array(
                                 'field' => 'flight_dep_start_mins',
                                 'label' => $this->lang->line("flight_dep_start"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),

                        array(
                                  'field' => 'flight_dep_end_hrs',
                                'label' => $this->lang->line("flight_dep_end"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),
                        array(
                                  'field' => 'flight_dep_end_mins',
                                'label' => $this->lang->line("flight_dep_end"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),


                       array(
                                'field' => 'cabin_list[]',
                                'label' => 'Cabin Exclusion',
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valOrigLevelValue'
                       ),

		);
		return $rules;
	}


	

function validateEfecDate(){
 $efec = strtotime($this->input->post("flight_efec_date"));
$disc = strtotime($this->input->post("flight_disc_date"));

if( $efec == '' AND $disc != '' ) {
	$this->form_validation->set_message("validateEfecDate", "Flight Effective date should be selected");
        return false;
}else{
	return true;
}


}


function validateDiscDate(){
 $efec = strtotime($this->input->post("flight_efec_date"));
$disc = strtotime($this->input->post("flight_disc_date"));

if( $efec != '' AND $disc == '' ) {
        $this->form_validation->set_message("validateDiscDate", "Flight Discontinue date should be selected");
        return false;
}

if($disc < $efec ) {
  $this->form_validation->set_message("validateDiscDate", "Flight discontinue date should be ahead of effective date ");
        return false;
} else {
        return true;
}


}


function FlightNbrStartCheck(){
$start = $this->input->post("flight_nbr_start");
$end = $this->input->post("flight_nbr_end");

if( $start == '' AND $end != '' ) {
        $this->form_validation->set_message("FlightNbrStartCheck", "Flight Nbr start required");
        return false;
}else{
	return true;

}

}


function FlightNbrEndCheck(){
$start = $this->input->post("flight_nbr_start");
$end = $this->input->post("flight_nbr_end");

if( $start != '' AND $end == '' ) {
        $this->form_validation->set_message("FlightNbrEndCheck", "Flight nbr end required");
        return false;
}

if($end < $start ) {
  $this->form_validation->set_message("FlightNbrEndCheck", "Flight end number should be more than start ");
        return false;
} else {
        return true;
}

}


function valFrequency($num)
{

	if($num == '*') {
		return true;

	} else {
		if ( $num != '' ){
			$arr = str_split($num);
			$freq = range(1,7);
			foreach($arr as $a ) {
				if( !in_array($a, $freq) ) {
					$this->form_validation->set_message("valFrequency", "%s must be in 1-7");
					return false;
				}

			}

    			if (count($arr) > 7 )
    			{
				$this->form_validation->set_message("valFrequency", "%s must be 7 digits");
         			return false;
    			}else if (count($arr) != count(array_unique($arr))){
				$this->form_validation->set_message("valFrequency", "%s contains duplicate values");
				return false;
			}
    			else
    				{
				return true;
    			}

		} else {
			return true;
		}

	}
}
	function valMarket($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valMarket", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valOrigLevelValue($post_array){		
	  if(count($post_array) < 1){
		 $this->form_validation->set_message("valOrigLevelValue", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valDestLevel($post_string){		
	  if($post_string == '0'){
		 $this->form_validation->set_message("valDestLevel", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	function valDestLevelValue($post_array){        	
	  if(count($post_array) < 1){
		 $this->form_validation->set_message("valDestLevelValue", "%s is required");
		  return FALSE;
	   }else{
		  return TRUE;
	   }
	}
	
	public function index() {

	$excl_id = htmlentities(escapeString($this->uri->segment(3)));
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


		if($excl_id > 0 ) {

			$this->data['sexcl_id'] = $excl_id;
		}


		if(!empty($this->input->post('sorig_market_id'))){
		          $this->data['origmarketID'] = $this->input->post('sorig_market_id');
        	} else {
          		$this->data['origmarketID'] = 0;
       		}
	        if(!empty($this->input->post('sdest_market_id'))){
        		  $this->data['destmarketID'] = $this->input->post('sdest_market_id');
        	} else {
         		 $this->data['destmarketID'] = 0;
        	}
		

		 if(!empty($this->input->post('sfrom_class'))){
                          $this->data['fromclass'] = $this->input->post('sfrom_class');
                } else {
                         $this->data['fromclass'] = 0;
                }

                 if(!empty($this->input->post('sto_class'))){
                          $this->data['toclass'] = $this->input->post('sto_class');
                } else {
                         $this->data['toclass'] = 0;
                }



		if(!empty($this->input->post('sflight_nbr_start'))){
                          $this->data['nbr_start'] = $this->input->post('sflight_nbr_start');
                }


		if(!empty($this->input->post('sflight_efec_date'))){
                          $this->data['efec_date'] =  date('d-m-Y',$this->input->post('sflight_efec_date'));
                }

	
		if(!empty($this->input->post('sflight_disc_date'))){
                          $this->data['disc_date'] = date('d-m-Y',$this->input->post('sflight_disc_date'));
                }

		if(!empty($this->input->post('sflight_nbr_end'))){
                          $this->data['nbr_end'] = $this->input->post('sflight_nbr_end');
                }


		if(!empty($this->input->post('sday'))){
                          $this->data['day'] = $this->input->post('sday');
                } else {
                         $this->data['day'] = 0;
                }


		if(!empty($this->input->post('active'))){
                	$this->data['active'] = $this->input->post('active');
                } else {
                    	$this->data['active'] = '-1';
                }

		//$this->data['carriers'] = $this->airports_m->getDefnsListByType('12');

		 $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                        $this->data['carriers'] = $this->airline_m->getClientAirline($userID);
                           }  else if($userTypeID != 1){
						 $this->data['carriers'] = $this->user_m->getUserAirlines($userID);	   
						   }else {
                   $this->data['carriers'] = $this->airline_m->getAirlinesData();
                }

		$this->data['marketzones'] = $this->marketzone_m->getMarketzones();
		 $this->data['days_of_week'] = $this->airports_m->getDefnsCodesListByType('14');
		$this->data['class_type'] = $this->airports_m->getDefns('13');
		  $this->data['hrs'] = $this->eligibility_exclusion_m->time_dropdown('24',1);
           $this->data['mins'] = $this->eligibility_exclusion_m->time_dropdown('60',5);
		$types = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
                  foreach($types as $type){
                        $this->data['aln_datatypes'][$type->vx_aln_data_typeID] = $type->alias;
                  }
         if($this->input->post('scarrier')){
		   $this->data['scarrier'] = $this->input->post('scarrier');
	     } else {
		   if($userTypeID == 2){
             $this->data['scarrier'] = $this->session->userdata('default_airline');
		   } else {
			 $this->data['scarrier'] = 0;
		   }
         }
		 
		$this->data["subview"] = "eligibility_exclusion/index";
		$this->load->view('_layout_main', $this->data);		
	}

	public function add() {
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
	
	   $this->data['marketzones'] = $this->marketzone_m->getMarketzones();
	   $this->data['class_type'] = $this->airports_m->getDefns('13'); // airline class types
	   $this->data['carriers'] = $this->airports_m->getDefnsListByType('12');
	   $this->data['days_of_week'] = $this->airports_m->getDefnsCodesListByType('14'); // days of week
	   $this->data['hrs'] = $this->eligibility_exclusion_m->time_dropdown('24',1);
	   $this->data['mins'] = $this->eligibility_exclusion_m->time_dropdown('60',5);
	   
	 
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$this->data["subview"] = "eligibility_exclusion/add";
				$this->load->view('_layout_main', $this->data);			
			} else {
				$array["excl_reason_desc"] = $this->input->post("desc");
				$array["orig_market_id"] = $this->input->post("orig_market_id");
				$array["dest_market_id"] = $this->input->post("dest_market_id");
				$array["flight_nbr_start"] = $this->input->post("flight_nbr_start");
				 $array["flight_nbr_end"] = $this->input->post("flight_nbr_end");
				$array["flight_efec_date"] = strtotime($this->input->post("flight_efec_date"));
				$array["flight_disc_date"] = strtotime($this->input->post("flight_disc_date"));
				$array['flight_dep_start'] = (3600 * $this->input->post("flight_dep_start_hrs")) + (60 * $this->input->post("flight_dep_start_mins"));
				  $array['flight_dep_end'] = (3600 * $this->input->post("flight_dep_end_hrs"))  + ( 60 * $this->input->post("flight_dep_end_mins"));
				$array['frequency'] = implode(',',$this->input->post("frequency"));
				$array['upgrade_from_cabin_type'] = $this->input->post("upgrade_from_cabin_type");
				$array['upgrade_to_cabin_type'] = $this->input->post("upgrade_to_cabin_type");
				$array["carrier"] = $this->input->post("carrier");
				$array["create_date"] = time();
				$array["modify_date"] = time();
				$array["create_userID"] = $this->session->userdata('loginuserID');
			       $array["modify_userID"] = $this->session->userdata('loginuserID');
				$this->eligibility_exclusion_m->insert_eligibility_rule($array);
				
				
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("eligibility_exclusion/index"));
			}
		} else {
			$this->data["subview"] = "eligibility_exclusion/add";
			$this->load->view('_layout_main', $this->data);
		}
	}



        public function getRuleData() {
                $id = $this->input->post('excl_grp_id');
                if((int)$id) {
                        $rule = $this->eligibility_exclusion_m->getDataForEditRule($id);
			$rule->flight_efec_date = $rule->flight_efec_date ? date('d-m-Y',$rule->flight_efec_date) : '';
                  	$rule->flight_disc_date = $rule->flight_disc_date ? date('d-m-Y',$rule->flight_disc_date) : '';
			 if($rule->flight_dep_start != '-1' ) {
					$st_arr = explode(':',gmdate('H:i', $rule->flight_dep_start));
					$rule->flight_dep_start_hrs = $st_arr[0];
					$rule->flight_dep_start_mins  = $st_arr[1];
			}else {
					$rule->flight_dep_start_hrs = '-1';
					$rule->flight_dep_start_mins = '-1';
			}

			if($rule->flight_dep_end != '-1' ) {
			$st_arr = explode(':',gmdate('H:i', $rule->flight_dep_end));
                        $rule->flight_dep_end_hrs = $st_arr[0];
                        $rule->flight_dep_end_mins  = $st_arr[1];
			}else{
				$rule->flight_dep_end_hrs = '-1';
				 $rule->flight_dep_end_mins = '-1';
			}
			$rule->orig_level_value = $rule->orig_level_value ? $rule->orig_level_value : '';
			$rule->dest_level_value = $rule->dest_level_value ? $rule->dest_level_value : '';

			$freq = $this->airports_m->getDefnsCodesListByType('14');
			if($rule->frequency != 0 ) {
			 $arr = explode(',',$rule->frequency);
		  	    $rule->frequency = implode('',array_map(function($x) use ($freq) { return $freq[$x]; }, $arr));
			    
			
			}
			

                }
		

                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode($rule));


        }

public function save() {
	if($_POST) {

                        $excl_grp_id = $this->input->post("excl_id");
                        $rules = $this->rules();
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                                $json['status'] = validation_errors();
	
				$json['errors'] = array(
		
		'desc' => form_error('desc'),
                'orig_level_id' => form_error('orig_level_id'),
                'dest_level_id' => form_error('dest_level_id'),
		'orig_level_value' => form_error('orig_level_value'),
                'dest_level_value' => form_error('dest_level_value'),
                'carrier' => form_error('carrier'),
                'flight_efec_date' => form_error('flight_efec_date'),
                                'flight_disc_date' => form_error('flight_disc_date'),
                                'flight_dep_start_hrs' => form_error('flight_dep_start_hrs'),
                                'flight_dep_start_mins' => form_error('flight_dep_start_mins'),
                                'flight_dep_end_hrs' => form_error('flight_dep_end_hrs'),
                                'flight_dep_end_mins' => form_error('flight_dep_end_mins'),
                                'flight_nbr_start' => form_error('flight_nbr_start'),
                                'flight_nbr_end' => form_error('flight_nbr_end'),
				'frequency' => form_error('frequency'),
				'cabin_list' => form_error('cabin_list'),
                );

                        } else {
				  $cabins = $this->input->post("cabin_list");
				 $array["excl_reason_desc"] = $this->input->post("desc");
                                $array["orig_level_id"] = $this->input->post("orig_level_id") ? $this->input->post("orig_level_id") : 0;
                                $array["dest_level_id"] = $this->input->post("dest_level_id") ? $this->input->post("dest_level_id") : 0;
				$orig_level_value = $this->input->post("orig_level_value") ? $this->input->post("orig_level_value") : 0;					$dest_level_value = $this->input->post("dest_level_value") ? $this->input->post("dest_level_value") : 0;
				 $array["orig_level_value"] = implode(',',$orig_level_value) ;
                                $array["dest_level_value"] = implode(',',$dest_level_value);

                                $array["flight_nbr_start"] = $this->input->post("flight_nbr_start") ? $this->input->post("flight_nbr_start") : 0;
                                 $array["flight_nbr_end"] = $this->input->post("flight_nbr_end") ? $this->input->post("flight_nbr_end") : 0;
                                $array["flight_efec_date"] = strtotime($this->input->post("flight_efec_date"));
                                $array["flight_disc_date"] = strtotime($this->input->post("flight_disc_date"));
//                                $array['flight_dep_start'] = (3600 * $this->input->post("flight_dep_start_hrs")) + (60 * $this->input->post("flight_dep_start_mins"));
  //                                $array['flight_dep_end'] = (3600 * $this->input->post("flight_dep_end_hrs"))  + ( 60 * $this->input->post("flight_dep_end_mins"));

					$start_hrs = $this->input->post("flight_dep_start_hrs");
                                $start_mins = $this->input->post("flight_dep_start_mins");
                                if ( $start_hrs != '-1' && $start_mins != '-1' ) {
                                        $array['flight_dep_start'] = (3600 * $start_hrs) + (60 * $start_mins);
                                } else  if ( $start_hrs != '-1' && $start_mins == '-1' ) {

                                        $array['flight_dep_start'] = (3600 * $start_hrs) ;
                                } else if ($start_hrs == '-1' && $start_mins != '-1') {
                                        $array['flight_dep_start'] = (60 * $start_mins) ;

                                }else{
                                         $array['flight_dep_start'] = '-1';
                                }



                                $end_hrs = $this->input->post("flight_dep_end_hrs");
                                $end_mins = $this->input->post("flight_dep_end_mins");
                                if ( $end_hrs != '-1' && $end_mins != '-1' ) {
                                        $array['flight_dep_end'] = (3600 * $end_hrs) + (60 * $end_mins);
                                } else  if ( $end_hrs != '-1' && $end_mins == '-1' ) {

                                        $array['flight_dep_end'] = (3600 * $end_hrs) ;
                                } else if ($end_hrs == '-1' && $end_mins != '-1') {
                                        $array['flight_dep_end'] = (60 * $end_mins) ;

                                }else{
                                         $array['flight_dep_end'] = '-1';
                                }




					$freq = $this->airports_m->getDefnsCodesListByType('14');
					$frstr = $this->input->post("frequency") ? $this->input->post("frequency") : 0; 
					if($frstr == '*'){
						$frstr = '1234567';
					}
					if ( $frstr != '0') {
						$arr = str_split($frstr);
						$array["frequency"]  = implode(',',array_map(function($x) use ($freq) { return array_search($x, $freq); }, $arr));				
					}
                                $array["carrier"] = $this->input->post("carrier");

                                 if( $excl_grp_id) {
					$array['excl_grp'] = $excl_grp_id;	
					$array["create_date"] = time();
					$array["create_userID"] = $this->session->userdata('loginuserID');
                                        $array["modify_date"] = time();
                                        $array["modify_userID"] = $this->session->userdata('loginuserID');
					$this->eligibility_exclusion_m->delete_data_bygrp($excl_grp_id);
					foreach($cabins as $c ){
                                                $spl = explode('-',$c);
                                                $array['upgrade_from_cabin_type'] = $this->airline_cabin_def_m->getCabinIDForCarrierANDCabin($array["carrier"],$spl[0]);

                                                $array['upgrade_to_cabin_type'] = $this->airline_cabin_def_m->getCabinIDForCarrierANDCabin($array["carrier"],$spl[1]);
                                                $this->eligibility_exclusion_m->insert_eligibility_rule($array);
                                        }

					//$this->eligibility_exclusion_m->update_eligibility_rule($array, $excl_grp_id);
                                        $json['action'] = 'edit';
			
 				  } else {
                                        $array["create_date"] = time();
                                        $array["modify_date"] = time();
                                        $array["create_userID"] = $this->session->userdata('loginuserID');
                                        $array["modify_userID"] = $this->session->userdata('loginuserID');
					$max_cnt = $this->eligibility_exclusion_m->get_max_grp();
                                        $array['excl_grp'] = $max_cnt + 1;
					foreach($cabins as $c ){
						$spl = explode('-',$c);
						$array['upgrade_from_cabin_type']  = $this->airline_cabin_def_m->getCabinIDForCarrierANDCabin($array["carrier"],$spl[0]);
						$array['upgrade_to_cabin_type'] =  $this->airline_cabin_def_m->getCabinIDForCarrierANDCabin($array["carrier"],$spl[1]);
						$this->eligibility_exclusion_m->insert_eligibility_rule($array);
					}
                                        $json['action'] = 'add';
                                 }

                                $json['status'] = "success";



  		}


                }else {

                        $json['status'] = "no data";
                }

                 $this->output->set_content_type('application/json');
                 $this->output->set_output(json_encode($json));



}
	public function edit() {
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
		if((int)$id) {
			$this->data['e_rule'] = $this->eligibility_exclusion_m->get_single_eligibility_exclrule(array('eexcl_id'=>$id));
			if($this->data['e_rule']) {

			       $this->data['marketzones'] = $this->marketzone_m->getMarketzones();
			       $this->data['class_type'] = $this->airports_m->getDefns('13'); // airline class types
           			$this->data['days_of_week'] = $this->airports_m->getDefnsCodesListByType('14'); // days of week
           			$this->data['hrs'] = $this->eligibility_exclusion_m->time_dropdown('24',1);
           			$this->data['mins'] = $this->eligibility_exclusion_m->time_dropdown('60',5);
				$this->data['carriers'] = $this->airports_m->getDefnsListByType('12');


				if($_POST) {
					$rules = $this->rules();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) { 
						$this->data["subview"] = "eligibility_exclusion/edit";
						$this->load->view('_layout_main', $this->data);			
					} else {
						

                                $array["excl_reason_desc"] = $this->input->post("desc");
                                $array["orig_market_id"] = $this->input->post("orig_market_id");
                                $array["dest_market_id"] = $this->input->post("dest_market_id");
                                $array["flight_nbr_start"] = $this->input->post("flight_nbr_start");
                                 $array["flight_nbr_end"] = $this->input->post("flight_nbr_end");
                                $array["flight_efec_date"] = strtotime($this->input->post("flight_efec_date"));
                                $array["flight_disc_date"] = strtotime($this->input->post("flight_disc_date"));
                                $array['flight_dep_start'] = (3600 * $this->input->post("flight_dep_start_hrs")) + (60 * $this->input->post("flight_dep_start_mins"));
                                  $array['flight_dep_end'] = (3600 * $this->input->post("flight_dep_end_hrs")) + (60 * $this->input->post("flight_dep_end_mins"));
                                $array['frequency'] = implode(',',$this->input->post("frequency"));
                                $array['upgrade_from_cabin_type'] = $this->input->post("upgrade_from_cabin_type");
                                $array['upgrade_to_cabin_type'] = $this->input->post("upgrade_to_cabin_type");
				$array["carrier"] = $this->input->post("carrier");
                                $array["modify_date"] = time();
                               $array["modify_userID"] = $this->session->userdata('loginuserID');

                                $this->eligibility_exclusion_m->update_eligibility_rule($array, $id);


						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("eligibility_exclusion/index"));
					}
				} else {
					$this->data["subview"] = "eligibility_exclusion/edit";
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
			$this->data['rule'] = $this->eligibility_exclusion_m->get_single_eligibility_exclrule(array('eexcl_id'=>$id));
			if($this->data['rule']) {
				$this->eligibility_exclusion_m->delete_eligibility_rule($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("eligibility_exclusion/index"));
			} else {
				redirect(base_url("eligibility_exclusion/index"));
			}
		} else {
			redirect(base_url("eligibility_exclusion/index"));
		}
	}
	
	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int)$id) {
			$this->data['rule'] = $this->eligibility_exclusion_m->get_single_eligibility_exclrule(array('eexcl_id'=>$id));
			if($this->data["rule"]) {
				$this->data["subview"] = "eligibility_exclusion/view";
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
  
   function active() {
		if(permissionChecker('eligibility_exclusion_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if($id != '' && $status != '') {
				if((int)$id) {
					$data['modify_userID'] = $this->session->userdata('loginuserID');
					$data['modify_date'] = time();
					if($status == 'chacked') {
						$data['active'] = 1 ;
						$this->eligibility_exclusion_m->update_eligibility_rule($data, $id);
						echo 'Success';
					} elseif($status == 'unchacked') {
						$data['active'] = 0 ;
						$this->eligibility_exclusion_m->update_eligibility_rule($data, $id);
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
	

function time_dropdown($val) {
		for($i=0;$i<$val;$i++){
			if($i<10 && strlen($i)<2)
    			{
        			$num = '0'.$i;
    			}
			$hrs[$num] = $num;
		}
	return $hrs;
}


	function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  


	$aColumns = array('MainSet.eexcl_id','MainSet.excl_grp','MainSet.excl_reason_desc','MainSet.orig_level', 'SubSet.orig_level_value','MainSet.dest_level', 'SubSet.dest_level_value' ,'MainSet.carrier_code','MainSet.flight_efec_date', 'MainSet.flight_disc_date','MainSet.flight_dep_start', 'MainSet.flight_dep_end','MainSet.flight_nbr','MainSet.from_class','MainSet.to_class','SubSet.frequency','SubSet.orig_full_name', 'SubSet.dest_full_name', 'MainSet.active');
				
	
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

                        if(!empty($this->input->get('scarrier'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.carrier = '.$this->input->get('scarrier');
                        }


                        if(!empty($this->input->get('active')) && $this->input->get('active') != '-1'){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.active = '.$this->input->get('active');
                        }else if ($this->input->get('active') == '0') {
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.active = '.$this->input->get('active');
                        }

			
			if(!empty($this->input->get('fromClass'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.upgrade_from_cabin_type = '.$this->input->get('fromClass');
                        }
                        if(!empty($this->input->get('toClass'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.upgrade_to_cabin_type = '.$this->input->get('toClass');
                        }


			 if(!empty($this->input->get('excl_id'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.eexcl_id = '.$this->input->get('excl_id');
                        }



		        if(!empty($this->input->get('nbrStart'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_nbr_start <= '.$this->input->get('nbrStart');
                        }


			if(!empty($this->input->get('nbrEnd'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_nbr_end >= '.$this->input->get('nbrEnd');
                        }


                       if(!empty($this->input->get('efecDate'))){
                               $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_efec_date <= '.strtotime($this->input->get('efecDate'));
                        }


                        if(!empty($this->input->get('discDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_disc_date >= '.strtotime($this->input->get('discDate'));
                        }



			if(!empty($this->input->get('startHrs')) && !empty($this->input->get('startMins')) 
					&& $this->input->get('startHrs') != '-1' && $this->input->get('startMins') != '-1'){

				$stime = (3600 * $this->input->get('startHrs')) + (60 * $this->input->get('startMins') );
                               $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_dep_start <= ' . $stime;
                        }



			 if(!empty($this->input->get('endHrs')) && !empty($this->input->get('endMins'))
				&& $this->input->get('endHrs') != '-1' && $this->input->get('endMins') != '-1'){
				$stime = (3600 * $this->input->get('endHrs')) + (60 * $this->input->get('endMins') );
                               $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_dep_end >= ' . $stime;
                        }



			



		 if(!empty($this->input->get('sfrequency'))){
                               $frstr = $this->input->get('sfrequency');
                                $freq = $this->airports_m->getDefnsCodesListByType('14');
				if($frstr == '*'){
					$frstr = '1234567';
				}
                                 if ( $frstr != '0') {
                                        $arr = str_split($frstr);
                                        $freq_str = array_map(function($x) use ($freq) { return array_search($x, $freq); }, $arr);                                       
					foreach($freq_str as $day){
						$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
						$sWhere .= 'FIND_IN_SET("'.$day.'",SubSet.dayslist)';
					}
                                  }

                        }

                  $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'MainSet.carrier IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';
                }


		$sQuery = "

SELECT SQL_CALC_FOUND_ROWS MainSet.eexcl_id,MainSet.excl_reason_desc , 
        MainSet.flight_efec_date, MainSet.flight_disc_date, MainSet.flight_dep_start, MainSet.flight_dep_end, 
        MainSet.flight_nbr, MainSet.from_class, MainSet.to_class, SubSet.frequency, MainSet.active,
        MainSet.orig_level, MainSet.dest_level, SubSet.orig_level_value, SubSet.dest_level_value , SubSet.dayslist , MainSet.upgrade_from_cabin_type, MainSet.upgrade_to_cabin_type,MainSet.carrier,
        MainSet.flight_nbr_start, MainSet.flight_nbr_end , MainSet.carrier_code, MainSet.excl_grp,
	SubSet.orig_full_name, SubSet.dest_full_name, MainSet.active

FROM
(
           select eexcl_id,excl_reason_desc, orig.alias as orig_level,dest.alias as dest_level,
              flight_efec_date, flight_disc_date, flight_dep_start, flight_dep_end, CONCAT(flight_nbr_start,'-',flight_nbr_end) 
              as flight_nbr,fdef.cabin as from_class , tdef.cabin as to_class,  ex.active , 
              ex.upgrade_from_cabin_type, ex.upgrade_to_cabin_type  ,ex.flight_nbr_start,
	      ex.flight_nbr_end, car.code as carrier_code, ex.excl_grp,ex.carrier
              from VX_aln_eligibility_excl_rules ex 
	       LEFT JOIN vx_aln_data_types orig on (orig.vx_aln_data_typeID = ex.orig_level_id) 
              LEFT JOIN vx_aln_data_types dest on (dest.vx_aln_data_typeID = ex.dest_level_id) 
	      INNER JOIN VX_aln_airline_cabin_def fdef on (fdef.carrier = ex.carrier)
	      INNER JOIN vx_aln_data_defns fc on (fc.alias = fdef.level and fc.vx_aln_data_defnsID = ex.upgrade_from_cabin_type AND fc.aln_data_typeID = 13) 
	      INNER JOIN VX_aln_airline_cabin_def tdef on (tdef.carrier = ex.carrier)
	      INNER JOIN vx_aln_data_defns tc on (tc.alias = tdef.level and tc.vx_aln_data_defnsID = ex.upgrade_to_cabin_type AND tc.aln_data_typeID = 13)
		
              LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID  = ex.carrier AND car.aln_data_typeID = 12)

) as MainSet

LEFT JOIN (
                select FirstSet.eexcl_id, FirstSet.orig_level as orig_level_value,  SecondSet.dest_level as dest_level_value,ThirdSet.frequency, ThirdSet.dayslist , FirstSet.orig_full_name, SecondSet.dest_full_name
                from 
                        (         
						SELECT       ex.eexcl_id as eexcl_id  , 
                                                COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(mm.market_name) )  AS orig_level, group_concat(c.aln_data_value) as orig_full_name
                                                FROM VX_aln_eligibility_excl_rules ex 
                                                LEFT OUTER JOIN  vx_aln_data_defns c ON 
                                                (find_in_set(c.vx_aln_data_defnsID, ex.orig_level_value) AND ex.orig_level_id in (1,2,3,4,5)) 
                                                LEFT OUTER JOIN  VX_aln_market_zone mm  
                                                ON (find_in_set(mm.market_id, ex.orig_level_value) AND ex.orig_level_id = 17) group by 							ex.eexcl_id
                        ) as FirstSet  
                LEFT join 

                        (       
						SELECT       ex.eexcl_id as eexcl_id  , 
                                                COALESCE(group_concat(c.code), group_concat(c.aln_data_value), group_concat(mm.market_name) )  AS dest_level ,  group_concat(c.aln_data_value) as dest_full_name
                                                FROM VX_aln_eligibility_excl_rules ex 
                                                LEFT OUTER JOIN  vx_aln_data_defns c ON 
                                                (find_in_set(c.vx_aln_data_defnsID, ex.dest_level_value) AND ex.dest_level_id in (1,2,3,4,5)) 
                                                LEFT OUTER JOIN  VX_aln_market_zone mm  
                                                ON (find_in_set(mm.market_id, ex.dest_level_value) AND ex.dest_level_id = 17) group by 							ex.eexcl_id
                        ) as SecondSet


                        on FirstSet.eexcl_id = SecondSet.eexcl_id


			 LEFT JOIN 
                        (
 					select mf.eexcl_id ,group_concat(c.code) as frequency  , mf.frequency as dayslist
	            		        from  VX_aln_eligibility_excl_rules mf 
                                         LEFT join vx_aln_data_defns c on find_in_set(c.vx_aln_data_defnsID, mf.frequency) group by mf.eexcl_id   
                        ) as ThirdSet

                        on ThirdSet.eexcl_id = FirstSet.eexcl_id


		) as SubSet on (MainSet.eexcl_id = SubSet.eexcl_id)

		$sWhere			
		$sOrder
		$sLimit	"; 

//	print_r($sQuery); exit;
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

	  foreach($rResult as $rule){	
		 $rule->chkbox = "<input type='checkbox'  class='deleteRow' value='".$rule->eexcl_id."'  /> ".$rownum ;
                                $rownum++;

		$rule->ruleno = $rule->excl_grp;
		$rule->flight_efec_date = $rule->flight_efec_date ? date('d-m-Y',$rule->flight_efec_date) : 'NA';
               $rule->flight_disc_date = $rule->flight_disc_date ? date('d-m-Y',$rule->flight_disc_date) : 'NA';
		if ( $rule->flight_dep_start != '-1'){
			$rule->flight_dep_start = gmdate('H:i', $rule->flight_dep_start);
		}else {
			$rule->flight_dep_start = 'NA';
		}


		 if ( $rule->flight_dep_end != '-1'){
                        $rule->flight_dep_end = gmdate('H:i', $rule->flight_dep_end);
                }else {
                        $rule->flight_dep_end = 'NA';
                }



		$rule->orig_level = $rule->orig_level ? $rule->orig_level : 'NA';
		$rule->dest_level = $rule->dest_level ? $rule->dest_level : 'NA';
		$rule->orig_level_value = $rule->orig_level_value ? $rule->orig_level_value : 'NA';
                $rule->dest_level_value = $rule->dest_level_value ? $rule->dest_level_value : 'NA';
		$rule->carrier_code = $rule->carrier_code ? $rule->carrier_code : 'NA';

		if($rule->flight_nbr == '0-0') {
			$rule->flight_nbr = 'NA';
		}
		

		if ( $rule->frequency != '' ) {
			$freq = explode(',',$rule->frequency);
			ksort($freq);
			$arr = array('1','2','3','4','5','6','7');
			$rule->frequency = implode('',array_map(function($x) use ($freq) { if(in_array($x,$freq)) return $x; else return '.'; }, $arr));
				
		} else {
			$rule->frequency = 'NA';
		}
		
		  
		  
		  if(permissionChecker('eligibility_exclusion_edit')){ 			
 $rule->action .=  '<a href="#" class="btn btn-warning btn-xs mrg" id="edit_rule"  data-placement="top" onclick="editrule('.$rule->excl_grp.')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>';

		  }
		  if(permissionChecker('eligibility_exclusion_delete')){
		   $rule->action .= btn_delete('eligibility_exclusion/delete/'.$rule->eexcl_id, $this->lang->line('delete'));			 
		  }
			$status = $rule->active;
			$rule->active = "<div class='onoffswitch-small' id='".$rule->eexcl_id."'>";
            $rule->active .= "<input type='checkbox' id='myonoffswitch".$rule->eexcl_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $rule->active .= " checked >";
			} else {
			   $rule->active .= ">";
			}	
			
			$rule->active .= "<label for='myonoffswitch".$rule->eexcl_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
			
			
			$output['aaData'][] = $rule;				
		}
		if(isset($_REQUEST['export'])){
		  $columns = array('#','Rule#','Reason Description','Origin Level','Orig Level Value','Dest Level','Dest Level Value','Carrier','Flight Effective Date','Flight Discontinue Date','Departure Start Time','Departure End Time','Flight Number Range','Upgrade From Cabin','Upgrade To Cabin','Frequency');
		  $rows = array("eexcl_id","ruleno","excl_reason_desc","orig_level","orig_level_value","dest_level","dest_level_value","carrier_code" ,"flight_efec_date","flight_disc_date","flight_dep_start","flight_dep_end","flight_nbr","from_class","to_class","frequency");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
	}



public function delete_excl_bulk_records(){
$data_ids = $_REQUEST['data_ids'];
$data_id_array = explode(",", $data_ids);
if(!empty($data_id_array)) {
    foreach($data_id_array as $id) {
		 $this->data['rule'] = $this->eligibility_exclusion_m->get_single_eligibility_exclrule(array('eexcl_id'=>$id));
                        if($this->data['rule']) {
                                $this->eligibility_exclusion_m->delete_eligibility_rule($id);

                        }
    }
}
}

}
