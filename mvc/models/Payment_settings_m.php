<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_settings_m extends MY_Model {

	function update_key($array) {
		$this->db->update_batch('VX_ini_config', $array, 'config_key'); 
	}

	function get_order_by_config() {
		$query = $this->db->get_where('VX_ini_config');
		return $query->result();
	}
}