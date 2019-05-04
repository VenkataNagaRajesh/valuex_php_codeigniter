<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class client_m extends MY_Model {

	protected $_table_name = 'VX_aln_client';
	protected $_primary_key = 'VX_aln_clientID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "VX_aln_clientID";

	function __construct() {
		parent::__construct();
	}
	function get_client($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);		
		return $query;
	}

	function get_single_client($array) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_client($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_client($data, $id = NULL) {
		parent::update($data, $id);
		
		return $id;
	}

	function delete_client($id){
		parent::delete($id);
	}
	
    function getClientData($id){
		$this->db->select('c.*,d.aln_data_value airline')->from('VX_aln_client c');
		$this->db->join('vx_aln_data_defns d','d.vx_aln_data_defnsID = c.airlineID','LEFT');
		$this->db->where('c.VX_aln_clientID',$id);
		$query = $this->db->get();
		return $query->row();
	}
		
}