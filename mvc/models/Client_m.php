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

		
}