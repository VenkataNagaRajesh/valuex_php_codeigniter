<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketzone_m extends MY_Model {

	protected $_table_name = 'VX_aln_market_zone';
	protected $_primary_key = 'market_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "market_id";

	function __construct() {
		parent::__construct();
	}

	function get_marketzonename($table, $data=NULL) {
		$query = $this->db->get_where($table, $data);
		return $query->result();
	}

	function get_marketzonename_row($table, $data=NULL) {
		$query = $this->db->get_where($table, $data);
		return $query->row();
	}


	function get_single_marketzone($array) {
	        $query = parent::get_single($array);
        	return $query;
    	}

	function get_order_by_marketzone($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	 function get_marketzones() {
                $this->db->select('*');
                $this->db->from('VX_aln_market_zone');
                        $query = $this->db->get();
                        return $query->result();
        }

	function insert_marketzone($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function getAlndataType($type){
		$this->db->select('name');
		$this->db->from('vx_aln_data_types');
		$this->db->where(array('vx_aln_data_typeID' => $type));
		$query = $this->db->get();
		$type = $query->row();
		return $type->name;
		
	}

	function getALndataTypeValues($list){
		$query = "SELECT aln_data_value FROM  vx_aln_data_defns WHERE vx_aln_data_defnsID in (". $list . ")";
                $result = $this->install_m->run_query($query);
		$str = '';
		return implode('<br>+',array_column($result, 'aln_data_value'));
	}
	

	function update_marketzone($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	function delete_marketzone($id){
		parent::delete($id);
	}

	function hash($string) {
		return parent::hash($string);
	}	
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
