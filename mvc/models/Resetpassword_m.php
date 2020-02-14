<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resetpassword_m extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}

	function get_username($table, $data=NULL) {
		$query = $this->db->get_where($table, $data);		
		return $query->result();
	}

	function hash($string) {
		return parent::hash($string);
	}	

	function update_resetpassword($table, $data=NULL, $tableID, $userID ) {
		$this->db->update($table, $data, $tableID." = ". $userID);
		//print_r($this->db->last_query()); exit;
		return TRUE;
	}
}

