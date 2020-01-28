<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class smssettings_m extends MY_Model {

	function get_order_by_clickatell() {
		$query = $this->db->get_where('VX_smssettings', array('types' => 'clickatell'));
		return $query->result();
	}

	function update_clickatell($array) {
		$this->db->update_batch('VX_smssettings', $array, 'field_names'); 
	}

	function get_order_by_twilio() {
		$query = $this->db->get_where('VX_smssettings', array('types' => 'twilio'));
		return $query->result();
	}

	function update_twilio($array) {
		$this->db->update_batch('VX_smssettings', $array, 'field_names'); 
	}

	function get_order_by_bulk() {
		$query = $this->db->get_where('VX_smssettings', array('types' => 'bulk'));
		return $query->result();
	}

	function update_bulk($array) {
		$this->db->update_batch('VX_smssettings', $array, 'field_names'); 
	}

    function get_order_by_msg91() {
        $query = $this->db->get_where('VX_smssettings', array('types' => 'msg91'));
        return $query->result();
    }

    function update_msg91($array) {
		$this->db->update_batch('VX_smssettings', $array, 'field_names');
	}


}