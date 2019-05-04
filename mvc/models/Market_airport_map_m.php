<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market_airport_map_m extends MY_Model {

	protected $_table_name = 'VX_market_airport_map';
	protected $_primary_key = 'ma_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "ma_id";

	function __construct() {
		parent::__construct();
	}
	
	function check_mappingdata($id){
		   $this->db->select('count(*)')->from('VX_market_airport_map');
          	   $this->db->where(array('market_id'=>$id));
          	   $query = $this->db->get();
          	   if ($query->row('count(*)') > 0) {
       			return 0;
      		    } else {
       			return 1;
      		    }
	}

	function insert_marketairport_mapid($array) {
		$id = parent::insert($array);
		return TRUE;
	}

	function get_market_airport_mapid_count(){
		 $this->db->select('count(*) as cnt')->from('VX_market_airport_map');
                $query = $this->db->get();
                return $query->row('cnt');

	}
	function get_mapidlist() {
		$this->db->select('*')->from('VX_market_airport_map');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function remove_old_mappingentries($id) {
		$this->db->where(array('market_id' => $id));
                $this->db->delete('VX_market_airport_map');
                return true;
	}

	function remove_old_entriesbyid($market_id,$list){
		$query = "DELETE FROM VX_market_airport_map WHERE market_id = ".$market_id." AND airport_id IN (".implode(',',$list).")";
		$this->db->query($query);
                return true;
	}

	function get_market_airport_mapdata($id) {
		$this->db->select('airport_id')->from('VX_market_airport_map');
		$this->db->where(array('market_id'=>$id));
		$query = $this->db->get();
		$result = $query->result();
		return array_column($result,'airport_id');
		
	}

	function delete_marketairport_mapid($id){
		parent::delete($id);
	}

	function hash($string) {
		return parent::hash($string);
	}

    function getAirportsByMarketzones($wherein){
		$this->db->select('airport_id')->from('VX_market_airport_map');
		$this->db->where_in('market_id',$wherein);
		$query = $this->db->get();
		$result = $query->result();
		return array_column($result,'airport_id');
	}	
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
