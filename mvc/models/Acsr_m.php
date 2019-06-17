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


   function apply_acsr_rules($array) {

                $date_format =  date('d-m', $array['dep_date']);
                $current_year =  date("Y");
                $prv_year = $current_year - 1;
                 $current_yr_date = strtotime($date_format.'-'.$current_year);
                 $old_yr_date = strtotime($date_format.'-'.$prv_year);
                $result = array();
                if ( !empty($array['from_city']) && !empty($array['to_city']) ) {
                $query = "select distinct acsr_id, acsr.*, dair.airport_id as dest_point, sair.airport_id as src_point,
				dd.alias as status
                                 from VX_aln_auto_confirm_setup_rules acsr  
                                LEFT JOIN VX_market_airport_map dair on (dair.market_id = dest_market_id)   
                                LEFT JOIN VX_market_airport_map sair on  (sair.market_id = orig_market_id) 
				LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = acsr.action_type and dd.aln_data_typeID = 19)
                                where sair.airport_id =".$array['from_city']. "  AND dair.airport_id =". $array['to_city'] .
                                " and flight_nbr_start <= ". $array['flight_number'] . " and flight_nbr_end >= " .$array['flight_number'] .
				" AND upgrade_from_cabin_type = " . $array['from_cabin'] . " AND upgrade_to_cabin_type = ".$array['to_cabin'];
			if($array['season_id'] != 0 ) {
		
				$query .= " AND season_id = " . $array['season_id'] ;
			}else {

				$query .= " AND frequency = " .$array['frequency'] ;
			}
                         $query .= " AND ((flight_dep_date_start <= ".$current_yr_date." AND flight_dep_date_end >= " . $current_yr_date . ") OR ( flight_dep_date_start <= ".$old_yr_date." AND flight_dep_date_end >= "  . $old_yr_date."))";



                //var_dump($query);exit;
                $result = $this->install_m->run_query($query);
                }
                return $result[0];
        }



	function update_acsr($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_acsr($id){
		parent::delete($id);
	}
}

