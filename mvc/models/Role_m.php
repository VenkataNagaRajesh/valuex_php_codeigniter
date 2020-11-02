<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class role_m extends MY_Model {

	protected $_table_name = 'VX_role';
	protected $_primary_key = 'roleID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "roleID ASC";

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
	
	public function get_roleinfo($usertypeID =null, $showUserType = 0, $strict = 0){
		$this->db->select('r.*,ut.usertype, df.*')->from('VX_role r');
		$this->db->join('VX_usertype ut','ut.usertypeID = r.usertypeID','LEFT');
		$this->db->join('VX_data_defns df','df.vx_aln_data_defnsID = r.carrier_id','LEFT');
		$login_airline = $this->session->userdata("login_user_airlineID");
		if ( $login_airline[0] ){
			$carrier_id = $login_airline[0];
		} else {
			$carrier_id = 0;
		}
		if ( $strict ) {
			$this->db->where("(r.usertypeID = $usertypeID)");
		} else {
			if($usertypeID && !$showUserType){
				$this->db->where("((r.usertypeID = $usertypeID AND carrier_id = 0)  OR  r.carrier_id = $carrier_id)");
			} elseif ($usertypeID){
				$this->db->where("(r.usertypeID = $usertypeID)");
			}
		}
		$query = $this->db->get();
		return $query->result();
	}
}

