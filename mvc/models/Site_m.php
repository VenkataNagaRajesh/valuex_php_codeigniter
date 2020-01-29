<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_m extends MY_Model {

	protected $_table_name = 'VX_setting';
	protected $_primary_key = 'option';
	protected $_primary_filter = 'intval';
	protected $_order_by = "option asc";

	function __construct() {
		parent::__construct();
	}

	function get_site($id) {
		$compress = array();
		$query = $this->db->get('VX_setting');
		foreach ($query->result() as $row) {
		    $compress[$row->fieldoption] = $row->value;
		}
		return (object) $compress;
	}
}
