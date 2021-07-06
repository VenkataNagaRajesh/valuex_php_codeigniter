<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fclr_m extends MY_Model {

	protected $_table_name = 'UP_fare_control_range';
	protected $_primary_key = 'fclr_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "fclr_id desc";

        function __construct() {
                parent::__construct();
        }

        function get_fclr($array=NULL, $signal=FALSE) {
                $query = parent::get($array, $signal);
                return $query;
        }


        function get_single_fclr($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }

        function insert_fclr($array) {
                $error = parent::insert($array);
		//echo $this->db->last_query();exit;
                return TRUE;
        }

	  function update_fclr($data, $id = NULL,$isMannual_Check=0) {
                if($isMannual_Check)
                {
                        $this->db->where('manual_edit == 0 OR manual_edit == 2');
                }
                parent::update($data,$id);
	//	echo $this->db->last_query();exit;
                return $id;
        }
       
	function checkFCLREntry($array){
                $this->db->select('fclr_id');
                $this->db->from('UP_fare_control_range');
                $this->db->where($array);
                $this->db->limit(1);
                $query = $this->db->get();
                $check = $query->row();
                if($check->fclr_id) {
                    return $check->fclr_id;
                } else {
                  return false;
                }
        }
       

	function checkANDInsertFCLR($data,$array1) {
	   $fclr_id = $this->checkFCLREntry($data);
		$array = array_merge($data,$array1);
           if($fclr_id){ 
                  $array["modify_date"] = time();
                  $array["modify_userID"] = $this->session->userdata('loginuserID');
                  $this->fclr_m->update_fclr($array,$fclr_id,1);

           } else {
                  $array["create_date"] = time();
                  $array["modify_date"] = time();
                  $array["create_userID"] = $this->session->userdata('loginuserID');
                  $array["modify_userID"] = $this->session->userdata('loginuserID');
                 $this->fclr_m->insert_fclr($array);
            }
		//echo $this->db->last_query();
	//	echo "<br>";
	}



        public function delete_fclr($id){
                $data = [
                        'active' => 0,
                    ];
                    $this->db->where('fclr_id', $id);
                    $this->db->update('UP_fare_control_range', $data);
                   return true;

        }

        function getFareDataForGivenID($cabin) {
	$query = "
SELECT  prorated_price  FROM UP_ra_feed rf  LEFT JOIN VX_data_defns dc on (dc.vx_aln_data_defnsID = rf.booking_country)  LEFT JOIN VX_data_defns dci on  (dci.vx_aln_data_defnsID = rf.booking_city) LEFT JOIN VX_data_defns dico on (dico.vx_aln_data_defnsID = rf.issuance_country)  LEFT JOIN VX_data_defns dici on  (dici.vx_aln_data_defnsID = rf.issuance_city) LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  LEFT JOIN VX_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code) LEFT JOIN  VX_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point) LEFT JOIN VX_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) LEFT JOIN VX_data_defns dcla on (dcla.vx_aln_data_defnsID = rf.cabin) where dcla.code = '".$cabin."' AND flight_number = 123 AND day_of_week = 5 AND dbp.code='HKG' AND dop.code='UQE'";


	$result = $this->install_m->run_query($query);
			return array_column($result,'prorated_price');
		

	}

function Stand_Deviation($arr) 
    { 
        $num_of_elements = count($arr); 
          
        $variance = 0.0; 
          
                // calculating mean using array_sum() method 
        $average = array_sum($arr)/$num_of_elements; 
          
        foreach($arr as $i) 
        { 
            // sum of squares of differences between  
                        // all numbers and means. 
            $variance += pow(($i - $average), 2); 
        } 
          
        return (float)sqrt($variance/$num_of_elements); 
    } 


	function getUpgradeCabinsData($array){
		$this->db->select('fc.fclr_id,fc.carrier_code,fc.frequency, fc.season_id,fc.flight_number,fc.from_cabin, fc.to_cabin, fc.min, fc.max, fc.average, fc.slider_start');
                $this->db->from('UP_fare_control_range fc');
		$this->db->join('VX_data_defns fca','fca.vx_aln_data_defnsID = fc.from_cabin','LEFT');
		$this->db->join('VX_data_defns tca','tca.vx_aln_data_defnsID = fc.to_cabin','LEFT');
		$this->db->where($array);
		 $this->db->where('fc.active','1');
		
                $query = $this->db->get();
//		print_r($this->db->last_query());
                $result = $query->result();
		return $result;
	}

	
}

