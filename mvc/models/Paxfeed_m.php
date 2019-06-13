<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paxfeed_m extends MY_Model {

	protected $_table_name = 'VX_aln_daily_tkt_pax_feed';
	protected $_primary_key = 'dtpf_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "dtpf_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_paxfeed($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function get_single_paxfeed($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function checkPaxFeed($array){
		$this->db->select('dtpf_id');
		$this->db->from('VX_aln_daily_tkt_pax_feed');
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();	
		if($check->dtpf_id) {
		    return false ;
		} else {
		  return true;
		}
			

	}


	function insert_paxfeed($array) {// echo "check"; exit;
		$error = parent::insert($array);
		//print_r($this->db->last_query()); exit;
		return TRUE;
	}

	function update_paxfeed($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_paxfeed($id){
		parent::delete($id);
	}
	
}

