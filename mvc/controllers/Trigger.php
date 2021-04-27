<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trigger extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("marketzone_m");
		$this->load->model("trigger_m");
		$this->load->model("market_airport_map_m");
		$this->load->model('role_m');
		$this->load->model('install_m');
		$this->load->model('season_m');
		$this->load->model("season_airport_map_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('marketzone', $language);
	}


        public function marketzone_trigger() {
	

		$timestamp = $this->trigger_m->get_trigger_time('VX_market_zone');
                if (isset($timestamp)) {
			//get list of markets that are modified
			$list = $this->marketzone_m->getMarketzones_for_triggerrun($timestamp);
			if (count($list) > 0){
				$mzdata = $this->marketzone_m->getAirportsDataForMktZones($list);
				$this->process_marketzones($mzdata);
				// now check for the case above marketzones are part of any other zones
				$sublist = $this->marketzone_m->getSubmarketsForList($list);	
				if(count($sublist) > 0 ){
					$subdata = $this->marketzone_m->getAirportsDataForMktZones($sublist);
					$this->process_marketzones($subdata);
				}
				
		    }
			//update market type seasons
                        $this->update_market_seasons();
                        //update trigger table 
                        $tarray['modify_date'] = time();
                        $tarray['isReconfigured'] = '0';
                        $tarray['modify_userID'] = $this->session->userdata('loginuserID');
                        $this->trigger_m->update_trigger($tarray,'VX_market_zone');

		}

		redirect(base_url("marketzone/index"));
	}


	public function process_marketzones($mzdata){

		 foreach($mzdata as $marketzone){
                                // now we have level, incl, excl list for each zone
                                // check and insert in map table

                                $level_list = array_filter(explode(',',$marketzone->level_value));
                                $incl_list = array_filter(explode(',',$marketzone->incl_value));
                                $excl_list = array_filter(explode(',',$marketzone->excl_value));
                                $remlist =  array_diff(array_unique(array_merge($level_list,$incl_list)),$excl_list);
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

				if(count($finallist) > 0  && !empty($finallist)) { 
                                //insert entries to mapping table
                                foreach($finallist as $airportid) {
					if($airportid != ''){
                                      		 $array["market_id"] = $marketzone->market_id;;
                                       		$array["airport_id"] = $airportid;
                                       		$this->market_airport_map_m->insert_marketairport_mapid($array);
					}
                                }
				}

                          }

	}

	public function index() {
	/*	$timestamp = $this->trigger_m->get_trigger_time('VX_aln_market_zone');
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
					 if ($marketzone->amz_level_id == 17 ) {
							$level_list =	$this->market_airport_map_m->getAirportsByMarketzones($level_arr);

					   } else {
							foreach ( $level_arr as $level_id ) {
					    		if (!empty($level_id)) {	
			     	       				$llist = $this->marketzone_m->getAirportsList($level_id);
								$level_list = array_merge($level_list,$llist);
					    		}
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
					 if ($marketzone->amz_incl_id == 17 ) {
                                                        $incl_list =   $this->market_airport_map_m->getAirportsByMarketzones($incl_arr);

                                           } else {
					foreach($incl_arr as $incl_id) {
					     if(!empty($incl_id)) {
						$ilist = $this->marketzone_m->getAirportsList($incl_id);
						$incl_list = array_merge($incl_list,$ilist);
					      }
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
					 if ($marketzone->amz_excl_id == 17 ) {
                                                        $excl_list =   $this->market_airport_map_m->getAirportsByMarketzones($excl_arr);

                                           } else {

	                                foreach($excl_arr as $excl_id) {
					   if(!empty($excl_id)){
        	                                $elist = $this->marketzone_m->getAirportsList($excl_id);
                	                        $excl_list = array_merge($excl_list,$elist);
					   }
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
            //update market type seasons
			$this->update_market_seasons();
			//update trigger table 
			$tarray['modify_date'] = time();
			$tarray['isReconfigured'] = '0';
			$tarray['modify_userID'] = $this->session->userdata('loginuserID');
			$this->trigger_m->update_trigger($tarray,'VX_aln_market_zone');

		}

        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
	*/
		redirect(base_url("marketzone/index"));
	}

    public function season_trigger(){
		$timestamp = $this->trigger_m->get_trigger_time('VX_season');

	if ($timestamp) { 

		//echo $timestamp;
	
		      $data = $this->season_m->getSeasons_for_triggerrun($timestamp);
			foreach($data as $season){ 	
			  
			    if(!is_null($season->ams_orig_level_value)) {
					$orig_arr = explode(',',$season->ams_orig_level_value);
				}else {
					$orig_arr = [];
				} 
				if(!is_null($season->ams_dest_level_value)) {
					$dest_arr = explode(',',$season->ams_dest_level_value);
				}else {
					$dest_arr = [];
				}
				
				$orig_list = []; $dest_list = [];
				if ( $season->ams_orig_levelID != -1 && count($orig_arr)>0){ 
					if ($season->ams_orig_levelID == 1 ) {
						$orig_list = $orig_arr; 
					} else if ($season->ams_orig_levelID == 17){
						//$this->mydebug->debug("market type orig");
						$olist = $this->market_airport_map_m->getAirportsByMarketzones($orig_arr); 
						$this->mydebug->debug($olist);
					    $orig_list = array_merge($orig_list,$olist);
					} else { 
						foreach ( $orig_arr as $level_id ) {
							if (!empty($level_id)) {	
							  $olist = $this->marketzone_m->getAirportsList($level_id); 
							  $orig_list = array_merge($orig_list,$olist);
							}
					   }
					}
			    }
				
				if ( $season->ams_dest_levelID != -1 && count($dest_arr)>0){ 
					if ($season->ams_dest_levelID == 1 ) {
						$dest_list = $dest_arr;
					} else if ($season->ams_dest_levelID == 17){
						//$this->mydebug->debug("market type dest");
						$dlist = $this->market_airport_map_m->getAirportsByMarketzones($dest_arr); 
						$this->mydebug->debug($dlist);
					    $dest_list = array_merge($dest_list,$dlist);
					} else {
						foreach ( $dest_arr as $level_id ) {
							if (!empty($level_id)) {	
							  $dlist = $this->marketzone_m->getAirportsList($level_id);
							  $dest_list = array_merge($dest_list,$dlist);
							}
					   }
					}
			    }
				
				$isNewOrigEntry = $this->season_airport_map_m->checkOrigMappingdata($season->VX_aln_seasonID);
				$isNewDestEntry = $this->season_airport_map_m->checkDestMappingdata($season->VX_aln_seasonID);
				
				if (!$isNewOrigEntry) {
					/* $OrigOldlist = $this->season_airport_map_m->get_orig_season_airport_mapdata($marketzone->market_id);
					$Origremovelist = array_diff($OrigOldlist,$orig_list);
					if(!empty($Origremovelist)) {
						$this->season_airport_map_m->remove_old_orig_entriesbyid($season->VX_aln_seasonID,$Origremovelist); 
					}
					$origfinallist = array_diff($orig_list,$OrigOldlist); */
					$this->season_airport_map_m->delete_old_orig_entries($season->VX_aln_seasonID);
				} 
					$origfinallist = $orig_list;
				//print_r($isNewOrigEntry);
				//print_r($origfinallist); exit;
				if (!$isNewDestEntry) {
					/* $DestOldlist = $this->season_airport_map_m->get_dest_season_airport_mapdata($season->VX_aln_seasonID);
					$Destremovelist = array_diff($DestOldlist,$dest_list); 
					if(!empty($Destremovelist)) {
						$this->season_airport_map_m->remove_old_dest_entriesbyid($season->VX_aln_seasonID,$Destremovelist);
					}
					$destfinallist = array_diff($dest_list,$DestOldlist); */
					$this->season_airport_map_m->delete_old_dest_entries($season->VX_aln_seasonID);
				} 
					$destfinallist = $dest_list;
				
				
				foreach($origfinallist as $orig_airport) {
			   	   $oarray["seasonID"] = $season->VX_aln_seasonID;
                   $oarray["orig_airportID"] = $orig_airport; 
                   $this->season_airport_map_m->insert_origseason_airport_mapid($oarray); 
				}
				
				foreach($destfinallist as $dest_airport) {
			   	   $darray["seasonID"] = $season->VX_aln_seasonID;
                   $darray["dest_airportID"] = $dest_airport;
                   $this->season_airport_map_m->insert_destseason_airport_mapid($darray);
				}
			}
			$this->mydebug->debug("market type dest");
			$tarray['modify_date'] = time();
			$tarray['isReconfigured'] = '1';
			$this->trigger_m->update_trigger($tarray,'VX_season');
			
			
			
			echo "i am here";
			exit();
		} 
		$this->session->set_flashdata('success', $this->lang->line('menu_success'));
		redirect(base_url("season/index"));
	}
	
	public function update_market_seasons(){
		$timestamp = $this->trigger_m->get_trigger_time('VX_market_zone');
		if (isset($timestamp)) {
		   $marketzones = $this->marketzone_m->getMarkets_for_triggerrun($timestamp);
		   //print_r($marketzones);
		   $marketseasons = $this->season_m->getMarketSeasons_for_triggerrun();
		   foreach($marketseasons as $season){
			   $orig_list = []; $dest_list = [];
			 if($season->ams_orig_levelID == 17){
			   $orig_arr = explode(',',$season->ams_orig_level_value);
			   $final_orig = array_intersect($orig_arr,$marketzones);
			   if(!empty($final_orig)){
			    $olist = $this->market_airport_map_m->getAirportsByMarketzones($orig_arr); 			
			    $orig_list = array_merge($orig_list,$olist);
				$this->season_airport_map_m->delete_old_orig_entries($season->VX_aln_seasonID);
			   }
			    foreach($orig_list as $orig_airport) {
			   	   $oarray["seasonID"] = $season->VX_aln_seasonID;
                   $oarray["orig_airportID"] = $orig_airport; 
                   $this->season_airport_map_m->insert_origseason_airport_mapid($oarray); 
				}
			  //
			 // print_r($orig_list);
			 }			 
			 if($season->ams_dest_levelID == 17){
			   $dest_arr = explode(',',$season->ams_dest_level_value);
			   $final_dest = array_intersect($dest_arr,$marketzones);
			   if(!empty($final_orig)){
			     $dlist = $this->market_airport_map_m->getAirportsByMarketzones($dest_arr); 			
			     $dest_list = array_merge($dest_list,$dlist);
				 $this->season_airport_map_m->delete_old_dest_entries($season->VX_aln_seasonID);
			   }
			   foreach($dest_list as $dest_airport) {
			   	   $darray["seasonID"] = $season->VX_aln_seasonID;
                   $darray["dest_airportID"] = $dest_airport;
                   $this->season_airport_map_m->insert_destseason_airport_mapid($darray);
				}
			   // print_r($dest_list);
			 }			
		   }
		}
	}
}

