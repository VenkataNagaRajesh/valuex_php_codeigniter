<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class role_m extends MY_Model {

	protected $_table_name = 'VX_role';
	protected $_primary_key = 'roleID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "roleID desc";

	function __construct() {
		parent::__construct();
	}

	function get_role($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;   
	}

	function get_order_by_role($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	function get_single_role($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_role($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_role($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_role($id){
		parent::delete($id);
	}
}

