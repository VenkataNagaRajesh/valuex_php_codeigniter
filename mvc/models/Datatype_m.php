<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatype_m extends MY_Model {

	protected $_table_name = 'vx_aln_data_types';
	protected $_primary_key = 'vx_aln_data_typeID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "vx_aln_data_typeID ASC";

	function __construct() {
		parent::__construct();
	}

	function get_datatypes($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

	function get_datatype($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_datatype($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_datatype($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_datatype($id){
		parent::delete($id);
	}
}

