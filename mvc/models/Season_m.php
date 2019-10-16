<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class season_m extends MY_Model {

	protected $_table_name = 'VX_aln_season';
	protected $_primary_key = 'VX_aln_seasonID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "VX_aln_seasonID desc";

	function __construct() {
		parent::__construct();
	}

	function get_seasons($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

     function get_seasons_where($where=null,$wherein=null){
            $this->db->select('s.*,dd.aln_data_value airline_name,dd.code airline_code,dt1.vx_aln_data_typeID orig_type,dt1.alias orig_level,dt2.vx_aln_data_typeID dest_type,dt2.alias dest_level')->from('VX_aln_season s');
			$this->db->join('vx_aln_data_types dt1','dt1.vx_aln_data_typeID = s.ams_orig_levelID','LEFT');
			$this->db->join('vx_aln_data_types dt2','dt2.vx_aln_data_typeID = s.ams_dest_levelID','LEFT');
			$this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = s.airlineID','LEFT');
			if(!empty($where)){
              $this->db->where($where);
			}
			if($wherein != null){
				$this->db->where_in('s.airlineID',$wherein);
			}
            $query = $this->db->get();
            return $query->result();
        }
	

	function get_seasons_for_airline($id){

		 $this->db->select('s.*,dd.aln_data_value airline_name,dd.code airline_code,dt1.vx_aln_data_typeID orig_type,dt1.alias orig_level,dt2.vx_aln_data_typeID dest_type,dt2.alias dest_level')->from('VX_aln_season s');
			$this->db->join('vx_aln_data_types dt1','dt1.vx_aln_data_typeID = s.ams_orig_levelID','LEFT');
			$this->db->join('vx_aln_data_types dt2','dt2.vx_aln_data_typeID = s.ams_dest_levelID','LEFT');
			$this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = s.airlineID','LEFT');
		if($id != 0){ $this->db->where('s.airlineID',$id); }
		if($this->session->userdata('usertypeID') == 2){
		   $this->db->where_in('s.airlineID',$this->session->userdata('login_user_airlineID'));
		}
		$query = $this->db->get();
            return $query->result();

	}
	
	function getSeasons_for_triggerrun($timestamp) {
		$sql = "SELECT * FROM VX_aln_season WHERE modify_date >= ".$timestamp;
		$seasons = $this->install_m->run_query($sql);
        return $seasons;
	}
	
	function getMarketSeasons_for_triggerrun() {
		$sql = "SELECT * FROM VX_aln_season WHERE ( ams_orig_levelID = 17 OR ams_dest_levelID = 17)";
		$seasons = $this->install_m->run_query($sql);
        return $seasons;
	}

	function get_single_season($array=NULL) {
		$query = parent::get_single($array); 
		return $query;
	}

	function insert_season($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function getSeasonForDateANDAirlineID($date , $carrierID,$orig_id, $dest_id ) {
		$date_format =  date('d-m', $date); 
		$current_year =  date("Y");
		$prv_year = $current_year - 1;
		 $current_yr_date = strtotime($date_format.'-'.$current_year);
		 $old_yr_date = strtotime($date_format.'-'.$prv_year);
		$this->db->select('VX_aln_seasonID')->from('VX_aln_season ss');
		$this->db->join('VX_season_airport_origin_map om','om.seasonID = ss.VX_aln_seasonID','LEFT');
		$this->db->join('VX_season_airport_dest_map dm','dm.seasonID = ss.VX_aln_seasonID','LEFT');
		$this->db->join('vx_aln_data_defns do','do.alias =  ss.ams_orig_levelID and do.aln_data_typeID = 23','LEFT');
		$this->db->join('vx_aln_data_defns dd','dd.alias =  ss.ams_dest_levelID and dd.aln_data_typeID = 23','LEFT');
		$this->db->where('airlineID' , $carrierID);
		$this->db->where('ss.active' , '1');
		
		 $this->db->where('((ams_season_start_date <= '.$current_yr_date.' AND ams_season_end_date >= ' . $current_yr_date . ') OR (ams_season_start_date <= ' .$old_yr_date .  ' AND ams_season_end_date >= '  . $old_yr_date.'))');

	// check for return inclusive as well
		$this->db->where('(( dest_airportID = '.$dest_id.' AND orig_airportID = '.$orig_id.') OR (ss.is_return_inclusive = 1 AND dest_airportID = '.$orig_id.' AND orig_airportID = '.$dest_id.'))');



		/*
		$this->db->where('airlineID' , $carrierID);
		$this->db->where('dest_airportID' , $dest_id);
		$this->db->where('orig_airportID' , $orig_id);
		$this->db->where('ss.active' , '1');*/



	//	$this->db->where('year(FROM_UNIXTIME(ams_season_start_date))' , $current_year);
        //        $this->db->where('year(FROM_UNIXTIME(ams_season_end_date)) ' , $current_year);

//	        $this->db->where('((ams_season_start_date <= '.$current_yr_date.' AND ams_season_end_date >= ' . $current_yr_date . ') OR (ams_season_start_date <= ' .$old_yr_date .  ' AND ams_season_end_date >= '  . $old_yr_date.'))');
		$this->db->order_by('do.code asc, dd.code asc,ams_season_start_date desc');
		//$this->db->order_by('VX_aln_seasonID','desc');
// select CONCAT(day(FROM_UNIXTIME(ams_season_start_date)),'-',month(FROM_UNIXTIME(ams_season_start_date)),'-',year(FROM_UNIXTIME(ams_season_start_date))) as date , FROM_UNIXTIME(ams_season_start_date) , day(FROM_UNIXTIME(ams_season_start_date)) as day ,month(FROM_UNIXTIME(ams_season_start_date)) as mon from VX_aln_season where CONCAT(day(FROM_UNIXTIME(ams_season_start_date)),'-',month(FROM_UNIXTIME(ams_season_start_date)),'-',year(FROM_UNIXTIME(ams_season_start_date))) = '1-6-2019';
		 $this->db->limit(1);
		
                $query = $this->db->get();
                $arr = $query->row();
		if( $arr->VX_aln_seasonID ) {
			return $arr->VX_aln_seasonID;
		} else {
			return 0;
		}


	}



    function getSeasonForDateANDAirlineIDForRAFeed($date , $carrierID,$orig_id, $dest_id ) {
                $date_format =  date('d-m', $date);
                $current_year =  date("Y");
                $prv_year = $current_year - 1;
                 $current_yr_date = strtotime($date_format.'-'.$current_year);
                 $old_yr_date = strtotime($date_format.'-'.$prv_year);
                $this->db->select('VX_aln_seasonID')->from('VX_aln_season ss');
                $this->db->join('VX_season_airport_origin_map om','om.seasonID = ss.VX_aln_seasonID','LEFT');
                $this->db->join('VX_season_airport_dest_map dm','dm.seasonID = ss.VX_aln_seasonID','LEFT');
                $this->db->join('vx_aln_data_defns do','do.alias =  ss.ams_orig_levelID and do.aln_data_typeID = 23','LEFT');
                 $this->db->join('vx_aln_data_defns dd','dd.alias =  ss.ams_dest_levelID and dd.aln_data_typeID = 23','LEFT');
                $this->db->where('airlineID' , $carrierID);
                //$this->db->where('dest_airportID' , $dest_id);
                //$this->db->where('orig_airportID' , $orig_id);
                $this->db->where('ss.active' , '1');
        //      $this->db->where('year(FROM_UNIXTIME(ams_season_start_date))' , $current_year);
        //        $this->db->where('year(FROM_UNIXTIME(ams_season_end_date)) ' , $current_year);

                $this->db->where('((ams_season_start_date <= '.$current_yr_date.' AND ams_season_end_date >= ' . $current_yr_date . ') OR (ams_season_start_date <= ' .$old_yr_date .  ' AND ams_season_end_date >= '  . $old_yr_date.'))');


		$this->db->where('(( dest_airportID = '.$dest_id.' AND orig_airportID = '.$orig_id.') OR (ss.is_return_inclusive = 1 AND dest_airportID = '.$orig_id.' AND orig_airportID = '.$dest_id.'))');

                $this->db->order_by('do.code asc, dd.code asc');
                //$this->db->order_by('VX_aln_seasonID','desc');
// select CONCAT(day(FROM_UNIXTIME(ams_season_start_date)),'-',month(FROM_UNIXTIME(ams_season_start_date)),'-',year(FROM_UNIXTIME(ams_season_start_date))) as date , FROM_UNIXTIME(ams_season_start_date) , day(FROM_UNIXTIME(ams_season_start_date)) as day ,month(FROM_UNIXTIME(ams_season_start_date)) as mon from VX_aln_season where CONCAT(day(FROM_UNIXTIME(ams_season_start_date)),'-',month(FROM_UNIXTIME(ams_season_start_date)),'-',year(FROM_UNIXTIME(ams_season_start_date))) = '1-6-2019';
                $query = $this->db->get();
		$result = $query->result();
		if (count($result) > 0 ) {

			return array_column($result,VX_aln_seasonID);
		} else {
			return array();
		}

        }


	function getSeasonsList($airlineID = array()){
                $this->db->select('VX_aln_seasonID,season_name');
                $this->db->from('VX_aln_season');
                $this->db->where('active','1');
				if($this->session->userdata('usertypeID') != 1){
					$this->db->where_in('airlineID',$this->session->userdata('login_user_airlineID'));
				}
                $query = $this->db->get();
			    $result = $query->result();

                foreach($result  as $season) {
                        $seasons[$season->VX_aln_seasonID]  = $season->season_name;
                }
                return $seasons;

	}

	function getSeasonNameByID($id) {

		$this->db->select('season_name')->from('VX_aln_season');
		$this->db->where('VX_aln_seasonID',$id);
		$query = $this->db->get();
		$arr = $query->row();
                return $arr->season_name;
	}

	function update_season($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_season($id){
		parent::delete($id);
	}
	
	public function searchAirlineCode($string){
		$query = "SELECT CONCAT(`code`, '_', `aln_data_value`) search from vx_aln_data_defns WHERE ";
		/* $this->db->select("CONCAT(`aln_data_value`, '_', `code`) search")->from('vx_aln_data_defns');
		$this->db->where('aln_data_typeID',12);
		$this->db->like("CONCAT(aln_data_value, '_', code)",$string);
		$query = $this->db->get(); */
		if($this->session->userdata('usertypeID') == 2){
			$airlineIDs = implode(',',$this->session->userdata('login_user_airlineID'));
			$query .= "vx_aln_data_defnsID IN (".$airlineIDs.") AND ";
		}
         $query .= " aln_data_typeID = 12 AND CONCAT(`code`, '_', `aln_data_value`) like '%".$string."%' limit 5";		
		$query = $this->db->query($query);
		//print_r($this->db->last_query()); 
		
		return $query->result();
	}
	
	public function seasonTotalCount(){
		$this->db->select('count(*) count')->from('VX_aln_season');
		if($this->session->userdata('usertypeID') != 1 ){		
			//$this->db->where('create_userID',$this->session->userdata('loginuserID'));
			$this->db->where_in('airlineID',$this->session->userdata('login_user_airlineID'));
		}
		if(!empty($this->session->userdata('default_airline'))){
			$this->db->where('airlineID',$this->session->userdata('default_airline'));
		}
		$query = $this->db->get();
		return $query->row('count');
	}
	
	public function getSeasonValues($type,$wherein){
		if($type == 4 || $type == 5){
		  $this->db->select('group_concat(aln_data_value)');
		} else {
		  $this->db->select('group_concat(code)');
		}
		$this->db->from('vx_aln_data_defns');
		$this->db->where('aln_data_typeID',$type);
		$this->db->where_in('vx_aln_data_defnsID',$wherein);
		$query = $this->db->get();
		
        if($type == 4 || $type == 5){
		  return $query->row('group_concat(aln_data_value)');
		} else {
		  return $query->row('group_concat(code)');
		}		
	}
}

