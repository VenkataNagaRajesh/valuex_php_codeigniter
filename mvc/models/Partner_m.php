<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner_m extends MY_Model {
  
	protected $_table_name = 'VX_partner';
	protected $_primary_key = 'partnerID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "priority desc";

	function __construct() {
		parent::__construct();
	}

    function get_single_partner($array) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_partner($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_partner($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_partner($id){
		parent::delete($id);
	}
}