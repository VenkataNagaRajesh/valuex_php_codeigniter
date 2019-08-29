<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acsr_m extends MY_Model {

	protected $_table_name = 'VX_aln_auto_confirm_setup_rules';
	protected $_primary_key = 'acsr_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "acsr_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_acsr($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	

	function get_single_acsr($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_acsr($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function time_dropdown($val) {
                for($i=0;$i<$val;$i++){
                        if($i<10 && strlen($i)<2)
                        {
                                $num = '0'.$i;
                        } else {
				$num = $i;
		        }  
                        $time_arr[$num] = $num;
                }
        return $time_arr;
        }


	function apply_acsr_rules($param = 0, $array = array()){
		
			$query = " select acsr_id, min_bid_price,memp,  orig_level, dest_level,frequency, flight_dep_date_start, flight_dep_date_end, carrier_code, flight_dep_time_start, flight_dep_time_end , flight_nbr_start, flight_nbr_end, dd. alias as status, upgrade_from_cabin_type, upgrade_to_cabin_type, SubSet.active ";

		$query .= " from (SELECT        acsr.*, IFNULL(group_concat(distinct cc.airportID) , group_concat(distinct mapo.airport_id))  as orig_level, IFNULL(group_concat(distinct c.airportID) ,group_concat(distinct map.airport_id)) as dest_level FROM VX_aln_auto_confirm_setup_rules acsr LEFT OUTER JOIN  vx_aln_master_data c ON (
(find_in_set(c.countryID, acsr.dest_level_value) AND acsr.dest_level_id  = 2) OR
(find_in_set(c.cityID, acsr.dest_level_value) AND acsr.dest_level_id  = 3) OR
(find_in_set(c.airportID, acsr.dest_level_value) AND acsr.dest_level_id  = 1) OR
(find_in_set(c.regionID, acsr.dest_level_value) AND acsr.dest_level_id  = 4) OR
(find_in_set(c.areaID, acsr.dest_level_value) AND acsr.dest_level_id  = 5)
  ) LEFT OUTER JOIN VX_market_airport_map map on (find_in_set(map.market_id, acsr.dest_level_value) AND acsr.dest_level_id  = 17) LEFT OUTER JOIN  vx_aln_master_data cc ON ((find_in_set(cc.countryID, acsr.orig_level_value) AND acsr.orig_level_id  = 2) OR
(find_in_set(cc.cityID, acsr.orig_level_value) AND acsr.orig_level_id  = 3) OR
(find_in_set(cc.airportID, acsr.orig_level_value) AND acsr.orig_level_id  = 1) OR
(find_in_set(cc.regionID, acsr.orig_level_value) AND acsr.orig_level_id  = 4) OR
(find_in_set(cc.areaID, acsr.orig_level_value) AND acsr.orig_level_id  = 5) )
LEFT OUTER JOIN VX_market_airport_map mapo on (find_in_set(mapo.market_id, acsr.orig_level_value) AND acsr.orig_level_id  = 17) group by acsr.acsr_id) as SubSet  LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = SubSet.action_type and dd.aln_data_typeID = 19) WHERE SubSet.active = 1  ";

		if(count($array) > 0) {
		 $date_format =  date('d-m', $array['dep_date']);
                $current_year =  date("Y");
                $prv_year = $current_year - 1;
                 $current_yr_date = strtotime($date_format.'-'.$current_year);
                 $old_yr_date = strtotime($date_format.'-'.$prv_year);

			if(!empty($array['from_city']) && !empty($array['to_city'])) {
			     $query .= " AND   (FIND_IN_SET(".$array['from_city'].", orig_level)) AND  (FIND_IN_SET(".$array['to_city'].",dest_level)) ";
			}
			
                       if(!empty($array['from_cabin']) && !empty($array['to_cabin']) ){
				$query .= " AND upgrade_from_cabin_type = " . $array['from_cabin'] . " AND upgrade_to_cabin_type = ".$array['to_cabin'];
			}
                         
			$query .= " AND ((flight_dep_date_start <= ".$current_yr_date." AND flight_dep_date_end >= " . $current_yr_date . ") OR ( flight_dep_date_start <= ".$old_yr_date." AND flight_dep_date_end >= "  . $old_yr_date.")) ";
		

		}
		if($param == 0 ) {
			$query .= ' order by acsr_id desc';
                         $result = $this->install_m->run_query($query);
                        return $result;
                } else{
                        return $query;
                }

	}

/*
   function apply_acsr_rules($array) {
                $date_format =  date('d-m', $array['dep_date']);
                $current_year =  date("Y");
                $prv_year = $current_year - 1;
                 $current_yr_date = strtotime($date_format.'-'.$current_year);
                 $old_yr_date = strtotime($date_format.'-'.$prv_year);
                $result = array();
                if ( !empty($array['from_city']) && !empty($array['to_city']) ) {
                /*$query = "select distinct acsr_id, acsr.*, dair.airport_id as dest_point, sair.airport_id as src_point,
				dd.alias as status
                                 from VX_aln_auto_confirm_setup_rules acsr  
                                LEFT JOIN VX_market_airport_map dair on (dair.market_id = dest_market_id)   
                                LEFT JOIN VX_market_airport_map sair on  (sair.market_id = orig_market_id) 
				LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = acsr.action_type and dd.aln_data_typeID = 19)
                              where  acsr.active = 1 AND sair.airport_id =".$array['from_city']. "  AND dair.airport_id =". $array['to_city'] .*/
/*			$query = "select acsr_id, min_bid_price,memp, season_id, orig_level, dest_level,frequency, flight_dep_date_start, flight_dep_date_end, carrier_code, flight_dep_time_start, flight_dep_time_end , flight_nbr_start, flight_nbr_end, dd. alias as status, upgrade_from_cabin_type, upgrade_to_cabin_type, SubSet.active from (SELECT        acsr.*, IFNULL(group_concat(distinct cc.airportID) , group_concat(distinct mapo.airport_id))  as orig_level, IFNULL(group_concat(distinct c.airportID) ,group_concat(distinct map.airport_id)) as dest_level FROM VX_aln_auto_confirm_setup_rules acsr LEFT OUTER JOIN  vx_aln_master_data c ON (
(find_in_set(c.countryID, acsr.dest_level_value) AND acsr.dest_level_id  = 2) OR
(find_in_set(c.cityID, acsr.dest_level_value) AND acsr.dest_level_id  = 3) OR
(find_in_set(c.airportID, acsr.dest_level_value) AND acsr.dest_level_id  = 1) OR
(find_in_set(c.regionID, acsr.dest_level_value) AND acsr.dest_level_id  = 4) OR
(find_in_set(c.areaID, acsr.dest_level_value) AND acsr.dest_level_id  = 5) 
  ) LEFT OUTER JOIN VX_market_airport_map map on (find_in_set(map.market_id, acsr.dest_level_value) AND acsr.dest_level_id  = 17) LEFT OUTER JOIN  vx_aln_master_data cc ON ((find_in_set(cc.countryID, acsr.orig_level_value) AND acsr.orig_level_id  = 2) OR
(find_in_set(cc.cityID, acsr.orig_level_value) AND acsr.orig_level_id  = 3) OR
(find_in_set(cc.airportID, acsr.orig_level_value) AND acsr.orig_level_id  = 1) OR
(find_in_set(cc.regionID, acsr.orig_level_value) AND acsr.orig_level_id  = 4) OR
(find_in_set(cc.areaID, acsr.orig_level_value) AND acsr.orig_level_id  = 5) )
LEFT OUTER JOIN VX_market_airport_map mapo on (find_in_set(mapo.market_id, acsr.orig_level_value) AND acsr.orig_level_id  = 17) group by acsr.acsr_id) as SubSet  LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = SubSet.action_type and dd.aln_data_typeID = 19) WHERE SubSet.active = 1  ";


			$query .= " AND   (FIND_IN_SET(".$array['from_city'].", orig_level)) AND  (FIND_IN_SET(".$array['to_city'].",dest_level)) ";
			$query .= " AND carrier_code = ".$array['carrier_code'].
                                " and flight_nbr_start <= ". $array['flight_number'] . " and flight_nbr_end >= " .$array['flight_number'] .
				" AND upgrade_from_cabin_type = " . $array['from_cabin'] . " AND upgrade_to_cabin_type = ".$array['to_cabin'];
			if($array['season_id'] != 0 ) {
		
				$query .= " AND season_id = " . $array['season_id'] ;
			}else {

				$query .= " AND find_in_set(".$array['frequency'].",frequency)" ;
			}
                         $query .= " AND ((flight_dep_date_start <= ".$current_yr_date." AND flight_dep_date_end >= " . $current_yr_date . ") OR ( flight_dep_date_start <= ".$old_yr_date." AND flight_dep_date_end >= "  . $old_yr_date.")) limit 1";



               // var_dump($query);exit;
                $result = $this->install_m->run_query($query);
                }
                return $result[0];
        }

*/

	function update_acsr($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_acsr($id){
		parent::delete($id);
	}
	
	function acsrTotalCount(){
		$this->db->select('count(*) count')->from('VX_aln_auto_confirm_setup_rules');		
		$query = $this->db->get();		
		return $query->row('count');
	}
}

