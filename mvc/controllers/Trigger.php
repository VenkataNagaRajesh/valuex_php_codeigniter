<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trigger extends Admin_Controller {
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
		$this->load->model("market_airport_map_m");
		$this->load->model('usertype_m');
		$this->load->model('install_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('marketzone', $language);
	}

	public function index() {
		$timestamp = $this->trigger_m->get_trigger_time('VX_aln_market_zone');
		if (isset($timestamp)) {
		      $data = $this->marketzone_m->getMarketzones_for_triggerrun($timestamp);
			foreach($data as $marketzone){
				
				if(!is_null($marketzone->amz_level_name)) {
					$level_arr = explode(',',$marketzone->amz_level_name);
				}else {
					$level_arr = [];
				}

				$level_list = [];$incl_list = []; $excl_list = [];
			   if ( $marketzone->amz_level_id != -1 && count($level_arr)>0){ 
				if ($marketzone->amz_level_id == 1 ) {
					$level_list = $level_arr;
				} else {
					foreach ( $level_arr as $level_id ) {
					    if (!empty($level_id)) {	
			     	       		$llist = $this->marketzone_m->getAirportsList($level_id);
						$level_list = array_merge($level_list,$llist);
					    }
				        }

				}
			    }	

			  if(!is_null($marketzone->amz_incl_name)) {
				$incl_arr = explode(',',$marketzone->amz_incl_name);
			   } else {
				$incl_arr = [];
			   }

			  if($marketzone->amz_incl_id != -1 && count($incl_arr)>0){
				if($marketzone->amz_incl_id == 1) {
					$incl_list = $incl_arr;
				} else {
					foreach($incl_arr as $incl_id) {
					     if(!empty($incl_id)) {
						$ilist = $this->marketzone_m->getAirportsList($incl_id);
						$incl_list = array_merge($incl_list,$ilist);
					      }
				         }
				}
                            }


			      if(!is_null($marketzone->amz_excl_name)){
				$excl_arr = explode(',',$marketzone->amz_excl_name);
			      } else {
				$excl_arr = [];
			      }


			   if ( $marketzone->amz_excl_id != -1 && count($excl_arr)>0){
				if ( $marketzone->amz_excl_id == 1){
					$excl_list = $excl_arr;
				} else {

	                                foreach($excl_arr as $excl_id) {
					   if(!empty($excl_id)){
        	                                $elist = $this->marketzone_m->getAirportsList($excl_id);
                	                        $excl_list = array_merge($excl_list,$elist);
					   }
                        	        }       
				}
			    }
				
				$commonlist = [];

				if(!empty($incl_list) && !empty($level_list)){
					$commonlist = array_intersect($level_list,$incl_list);
				} else if (!empty($incl_list) && empty($level_list)) {
					$commonlist = $incl_list;
				} else if (empty($incl_list) && !empty($level_list)){
					$commonlist = $level_list;
				}
				

				if(!empty($excl_list)){
					$remlist = array_diff($commonlist,$excl_list);
				} else {

					$remlist = $commonlist;
				}

				//before inserting check if any entried present in maptablle for that id
				// this might be the case for edit
				// check and delete

				$isNewentry = $this->market_airport_map_m->check_mappingdata($marketzone->market_id);
				if (!$isNewentry) {
					$oldlist = $this->market_airport_map_m->get_market_airport_mapdata($marketzone->market_id);
					$removelist = array_diff($oldlist,$remlist);
					if(!empty($removelist)) {
						$this->market_airport_map_m->remove_old_entriesbyid($marketzone->market_id,$removelist);
					}
					$finallist = array_diff($remlist,$oldlist);

				} else {
					$finallist = $remlist;
				}

				//insert entries to mapping table
				foreach($finallist as $airportid) {
			   	       $array["market_id"] = $marketzone->market_id;;
                                       $array["airport_id"] = $airportid;
                                       $this->market_airport_map_m->insert_marketairport_mapid($array);
				}


		        }


			//update trigger table 


			$tarray['trigger_last_run_time'] = time();
			$tarray['isReconfigured'] = '0';
			$this->trigger_m->update_trigger($tarray);

		}

		redirect(base_url("marketzone/index"));
	}


}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
