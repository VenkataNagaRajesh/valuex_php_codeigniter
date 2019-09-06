<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_cabin_def_m extends MY_Model {

	protected $_table_name = 'VX_aln_airline_cabin_def';
	protected $_primary_key = 'map_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "map_id";

	function __construct() {
		parent::__construct();
	}


	function get_airline_cabin_defbyid($id) {
                $query = $this->db->get_where('VX_aln_airline_cabin_def',array('map_id'=>$id));
                return $query->row();
        }



	 function get_mapped_airlines() {

		$this->db->distinct();
		$this->db->select('carrier')->from('VX_aln_airline_cabin_def');
		$query = $this->db->get();
                $result = $query->result();

                return array_column($result,'carrier');
        }

	function checkCarrierDataByID($id){
		$this->db->select('*');
		$this->db->from('VX_aln_airline_cabin_def');
		$this->db->where('carrier',$id);
	        $query = $this->db->get();
		$result = $query->result();
		$arr = array();
		foreach ($result as $v ) {
			$arr['carrier'] = $v->carrier;
			$arr[$v->level]['map_id'] = $v->map_id;
			$arr[$v->level]['cabin'] = $v->cabin; 
			$arr[$v->level]['desc'] = $v->desc;
			
		}
		return $arr;
	}


	function checkClassDataForCarrierID($id){

		$this->db->select('count(*) as cnt');
                $this->db->from('VX_aln_airline_cabin_def');
		$this->db->where('map_id',$id);
                $query = $this->db->get();
                return $query->row('cnt');

	}


	function insert_airline_cabin_def($array) {
		$id = parent::insert($array);
		return TRUE;
	}


	function update_airline_cabin_def($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}


	function getListOfMappedCarriers(){
		$this->db->distinct();
		$this->db->select('carrier')->from('VX_aln_airline_cabin_def');
		$query = $this->db->get();
		$result = $query->result();
		return array_column($result,'carrier');
	}

  public function getAirlineCabinsByName(){
                $this->db->select('cabin_map_id, name')->from('VX_aln_airline_cabin_map');
                $query = $this->db->get();
		$result = $query->result();
		$list = array();
		foreach ($result as $k) {
			$list[$k->cabin_map_id] = $k->name;
		}

                return $list;
        }

function getAirlinesToMap($array) {
                $this->db->select('vx_aln_data_defnsID, aln_data_value');
                $this->db->from('vx_aln_data_defns');
                $this->db->where('aln_data_typeID','12');
		if(count($array) > 0) {
		$this->db->where_not_in('vx_aln_data_defnsID',$array);
		}
                $query = $this->db->get();
                 $result = $query->result();
                        foreach($result as $k) {
                                $arr[$k->vx_aln_data_defnsID] = $k->aln_data_value;
                        }
                return $arr;


}
	function delete_airline_cabin_def($array){
		 $this->db->where($array);
          	$this->db->delete('VX_aln_airline_cabin_def');
              return TRUE;

	}

	function hash($string) {
		return parent::hash($string);
	}	


	function getCabinFromClassForCarrier($carrier_id , $class ) {
		$this->db->select('airline_cabin as cabin_id , acc.rbd_markup,  aca.code as cabin_code, aca.aln_data_value as cabin_name')->from('VX_aln_airline_cabin_def acc');	
		$this->db->join('vx_aln_data_defns aca', 'aca.vx_aln_data_defnsID = acc.airline_cabin','LEFT');
		$this->db->where('carrier', $carrier_id);
		$this->db->where('airline_class',$class);
		 $this->db->limit(1);
		$query = $this->db->get();
		$result = $query->row();
                return $result; 

	}


	function validateCabinMapData($carrier_code,$class) {
		$this->db->select('airline_cabin as cabin_id , acc.rbd_markup,  aca.code as cabin_code, aca.aln_data_value as cabin_name')->from('VX_aln_airline_cabin_def acc');
                $this->db->join('vx_aln_data_defns aca', 'aca.vx_aln_data_defnsID = acc.airline_cabin and aca.aln_data_typeID = 13','LEFT');
		$this->db->join('vx_aln_data_defns car', 'car.vx_aln_data_defnsID = acc.carrier and car.aln_data_typeID = 12','LEFT');
                $this->db->where('car.code', $carrier_code);
                $this->db->where('airline_class',$class);
                 $this->db->limit(1);
                $query = $this->db->get();
                $result = $query->row();
                return $result;


	}
		
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
