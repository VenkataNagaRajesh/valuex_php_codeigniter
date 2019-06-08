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
				where sair.airport_id  IN (" . implode(',',$array['from_city']) . " ) AND dair.airport_id IN (". implode(',',$array['to_city']) . 
				" ) and flight_nbr_start <= ". $array['flight_number'] . " and flight_nbr_end >= " . $array['flight_number'] . 
			//	" and  flight_dep_start <= ".$array['dep_time']." and flight_dep_end >= ".$array['dep_time'] .
				" AND ((flight_efec_date <= ".$current_yr_date." AND flight_disc_date >= " . $current_yr_date . ") OR (flight_efec_date <= ".$old_yr_date." AND flight_disc_date >= "  . $old_yr_date."))";


//				"  and 	flight_efec_date <= ".$array['dep_date']." and flight_disc_date >= ".$array['dep_date'] .
//				"  and  flight_dep_start <= ".$array['dep_time']." and flight_dep_end >= ".$array['dep_time'];

		//var_dump($query);exit;
		$result = $this->install_m->run_query($query);
		}
		return $result;
	}

	function update_eligibility_rule($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_eligibility_rule($id){
		parent::delete($id);
	}
}

