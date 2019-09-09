<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eligibility_exclusion_m extends MY_Model {

	protected $_table_name = 'VX_aln_eligibility_excl_rules';
	protected $_primary_key = 'eexcl_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "eexcl_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_eligibility_exlusion_rules($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	

	function get_single_eligibility_exclrule($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_eligibility_rule($array) {
		$error = parent::insert($array);
		return TRUE;
	}


	function get_max_grp(){
		$this->db->select('max(excl_grp) as cnt')->from('VX_aln_eligibility_excl_rules');
		$query = $this->db->get();
                $r = $query->row();

                return $r->cnt;


	}
	function time_dropdown($val, $incre = 1) {
                for($i=0;$i<$val;$i=$i+$incre){
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

/*
	function apply_exclusion_rules($array) {

		$date_format =  date('d-m', $array['dep_date']);
                $current_year =  date("Y");
                $prv_year = $current_year - 1;
                 $current_yr_date = strtotime($date_format.'-'.$current_year);
                 $old_yr_date = strtotime($date_format.'-'.$prv_year);
		$result = array();
		if ( !empty($array['from_city']) && !empty($array['to_city']) ) {
		$query = "select distinct eexcl_id, ex.*, dair.airport_id as dest_point, sair.airport_id as src_point  
				 from VX_aln_eligibility_excl_rules ex  
				LEFT JOIN VX_market_airport_map dair on (dair.market_id = dest_market_id)   
				LEFT JOIN VX_market_airport_map sair on  (sair.market_id = orig_market_id) 
				where ex.active = 1 AND sair.airport_id =".$array['from_city']. "  AND dair.airport_id =". $array['to_city'] . 
				" AND carrier = ".$array['carrier'] .
				" and flight_nbr_start <= ". $array['flight_number'] . " and flight_nbr_end >= " . $array['flight_number'] . 
			//	" and  flight_dep_start <= ".$array['dep_time']." and flight_dep_end >= ".$array['dep_time'] .
				" AND ((flight_efec_date <= ".$current_yr_date." AND flight_disc_date >= " . $current_yr_date . ") OR (flight_efec_date <= ".$old_yr_date." AND flight_disc_date >= "  . $old_yr_date."))";


//				"  and 	flight_efec_date <= ".$array['dep_date']." and flight_disc_date >= ".$array['dep_date'] .
//				"  and  flight_dep_start <= ".$array['dep_time']." and flight_dep_end >= ".$array['dep_time'];

		//var_dump($query);exit;
		$result = $this->install_m->run_query($query);
		}
		return $result;
	}
*/


	function apply_exclusion_rules($param = 0) {
/*
	$date_format =  date('d-m', $array['dep_date']);
                $current_year =  date("Y");
                $prv_year = $current_year - 1;
                 $current_yr_date = strtotime($date_format.'-'.$current_year);
                 $old_yr_date = strtotime($date_format.'-'.$prv_year);
*/


		if ( $param == 0 ) {
		
		$query = "select eexcl_id,excl_grp, orig_level, dest_level,frequency, flight_efec_date, flight_disc_date, carrier, flight_dep_start, flight_dep_end , flight_nbr_start, flight_nbr_end, upgrade_from_cabin_type, upgrade_to_cabin_type, active ";
		} else {

			$query =  "select eexcl_id, excl_grp " ;

		}

		$query .= "  from (SELECT        ex.*, IFNULL(group_concat(distinct cc.airportID) , group_concat(distinct mapo.airport_id))  as orig_level, IFNULL(group_concat(distinct c.airportID) ,group_concat(distinct map.airport_id)) as dest_level FROM VX_aln_eligibility_excl_rules ex LEFT OUTER JOIN  vx_aln_master_data c ON (
(find_in_set(c.countryID, ex.dest_level_value) AND ex.dest_level_id  = 2) OR
(find_in_set(c.cityID, ex.dest_level_value) AND ex.dest_level_id  = 3) OR
(find_in_set(c.airportID, ex.dest_level_value) AND ex.dest_level_id  = 1) OR
(find_in_set(c.regionID, ex.dest_level_value) AND ex.dest_level_id  = 4) OR
(find_in_set(c.areaID, ex.dest_level_value) AND ex.dest_level_id  = 5) 
  ) LEFT OUTER JOIN VX_market_airport_map map on (find_in_set(map.market_id, ex.dest_level_value) AND ex.dest_level_id  = 17) LEFT OUTER JOIN  vx_aln_master_data cc ON ((find_in_set(cc.countryID, ex.orig_level_value) AND ex.orig_level_id  = 2) OR
(find_in_set(cc.cityID, ex.orig_level_value) AND ex.orig_level_id  = 3) OR
(find_in_set(cc.airportID, ex.orig_level_value) AND ex.orig_level_id  = 1) OR
(find_in_set(cc.regionID, ex.orig_level_value) AND ex.orig_level_id  = 4) OR
(find_in_set(cc.areaID, ex.orig_level_value) AND ex.orig_level_id  = 5) )
LEFT OUTER JOIN VX_market_airport_map mapo on (find_in_set(mapo.market_id, ex.orig_level_value) AND ex.orig_level_id  = 17) group by ex.eexcl_id) as SubSet  WHERE active = 1  ";

/*

"  AND   find_in_set(".$array['from_city'].", orig_level) OR  find_in_set(".$array['to_city'].", dest_level) OR (flight_nbr_start <= ". $array['flight_number'] . " and flight_nbr_end >= " . $array['flight_number']. ") OR ((flight_efec_date <= ".$current_yr_date." AND flight_disc_date >= " . $current_yr_date . ") OR (flight_efec_date <= ".$old_yr_date." AND flight_disc_date >= "  . $old_yr_date.")) OR carrier = ".$array['carrier']." OR find_in_set(".$array['frequency'].", frequency) AND (upgrade_from_cabin_type = ".$array['from_cabin']." AND upgrade_to_cabin_type = ".$array['to_cabin'].") OR  (flight_dep_start <= ".$array['dep_time']." and flight_dep_end >= ".$array['dep_time'].")"; */
		//var_dump($query);exit;
		if($param == 0 ) {
			 $result = $this->install_m->run_query($query);
		 	return $result;
		} else{
			return $query;	
		}
	}

	function getDataForEditRule($grp_id) {

	 $sql = "select  excl_grp, group_concat(fdef.cabin ,'-', tdef.cabin  ) as cabins ,
		excl_reason_desc, orig_level_id, dest_level_id, orig_level_value, 
		dest_level_value ,flight_efec_date, flight_disc_date, flight_dep_start, 
		flight_dep_end, flight_nbr_start, flight_nbr_end, ex.carrier, frequency 
		  from VX_aln_eligibility_excl_rules ex 
		INNER JOIN VX_aln_airline_cabin_def fdef on (fdef.carrier = ex.carrier)
		INNER JOIN  vx_aln_data_defns df on (df.alias = fdef.level and df.aln_data_typeID = 13 AND df.vx_aln_data_defnsID = ex.upgrade_from_cabin_type )  
		INNER JOIN VX_aln_airline_cabin_def tdef on (tdef.carrier = ex.carrier)
		INNER JOIN  vx_aln_data_defns dt on (dt.alias = tdef.level and dt.aln_data_typeID = 13 AND dt.vx_aln_data_defnsID = ex.upgrade_to_cabin_type ) 
		where excl_grp = " . $grp_id. "  group by excl_reason_desc, 
		 orig_level_id, dest_level_id, orig_level_value, dest_level_value ,flight_efec_date, flight_disc_date, flight_dep_start, 
		flight_dep_end, flight_nbr_start, flight_nbr_end, carrier, frequency";
		$result = $this->install_m->run_query($sql);
		return $result[0];

	}



	public function apply_excl_rules_before_acsr($arr){

	  $rules = $this->apply_exclusion_rules();
		$matched = 0;
               if(count($rules) > 0 ) {
			foreach ( $rules  as $rule ) {
                                                $query = $this->apply_exclusion_rules(1);
                                                $query .= ' AND eexcl_id = ' .$rule->eexcl_id;

                                                if ($rule->orig_level != NULL) {
                                                        $query .= ' AND  (FIND_IN_SET('.$arr["from_city"].', orig_level))';
                                                }
                                                if ($rule->dest_level != NULL) {
                                                        $query .= ' AND  (FIND_IN_SET('.$arr["to_city"].',dest_level))';

                                                }

                                                if($rule->frequency != '0' ) {

                                                        $query .= ' AND (FIND_IN_SET('.$arr["frequency"].',frequency))';

                                                }

						if($rule->flight_efec_date != 0 AND $rule->flight_disc_date != 0 ){

                                                        $date_format =  date('d-m', $arr["dep_date"]);
                                                        $current_year =  date("Y");
                                                        $prv_year = $current_year - 1;
                                                        $current_yr_date = strtotime($date_format.'-'.$current_year);
                                                        $old_yr_date = strtotime($date_format.'-'.$prv_year);

                                                        $query .= " AND ((flight_efec_date <= ".$current_yr_date." AND flight_disc_date >= " . $current_yr_date . ") OR (flight_efec_date <= ".$old_yr_date." AND flight_disc_date >= "  . $old_yr_date.")) ";

                                                }

                                                if($rule->carrier != 0 ) {
                                                        $query .= " AND  (carrier = ".$arr['carrier_code']. ")";

                                                }



						 if($rule->flight_nbr_start != '0' AND $rule->flight_nbr_end != 0 ) {
                                                        $query .= " AND  (flight_nbr_start <= ". $arr['flight_number']. " and flight_nbr_end >= " . $arr['flight_number']. ")";

                                                }

                                                if($rule->upgrade_from_cabin_type != 0  AND $rule->upgrade_to_cabin_type != 0 ) {
                                                        $query .= " AND ( upgrade_from_cabin_type = " .$arr['from_cabin']. "  AND upgrade_to_cabin_type = " .$arr['to_cabin']. " ) ";
                                                }


						/*

						 if($rule->flight_dep_start != -1 AND $rule->flight_dep_end != -1 ) {

                                                        $query .= " AND (flight_dep_start <= ".$arr['dept_time']." and flight_dep_end >= ".$arr['dept_time'].")";
                                                }*/

                                                        $result = $this->install_m->run_query($query);
                                                        if(count($result) > 0 ) {
                                                                $matched = $result[0]->excl_grp;
                                                                break;
                                                          }
                                        }
					

	} 

		return $matched;

	}


	function getexclIdForGrpANDCabins($grp,$fc,$tc) {

		$this->db->select('eexcl_id')->from('VX_aln_eligibility_excl_rules');
		$this->db->where('excl_grp',$grp);
		$this->db->where('upgrade_from_cabin_type',$fc);
		$this->db->where('upgrade_to_cabin_type',$tc);
		$this->db->limit(1);
		$query = $this->db->get();
                $r = $query->row();

		return $r->eexcl_id;
	}
	function update_eligibility_rule($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	function delete_data_bygrp($grp_id){
		$this->db->where('excl_grp',$grp_id);
                $this->db->delete('VX_aln_eligibility_excl_rules');
                return;
	}

	public function delete_eligibility_rule($id){
		parent::delete($id);
	}
	
	function EErulesTotalCount(){
		$this->db->select('count(*) count')->from('VX_aln_eligibility_excl_rules');		
		$query = $this->db->get();		
		return $query->row('count');
	}
}

