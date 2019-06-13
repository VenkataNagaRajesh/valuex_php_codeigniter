<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paxfeedraw_m extends MY_Model {

	protected $_table_name = 'VX_aln_daily_tkt_pax_feed_raw';
	protected $_primary_key = 'dtpfraw_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "dtpfraw_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_paxfeedraw($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function get_single_paxfeedraw($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function checkPaxFeedRaw($array){
		$this->db->select('dtpfraw_id');
		$this->db->from('VX_aln_daily_tkt_pax_feed_raw');
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();	
		if($check->dtpfraw_id) {
		    return false ;
		} else {
		  return true;
		}
			

	}


	function insert_paxfeedraw($array) {// echo "check"; exit;

		$this->db->insert('VX_aln_daily_tkt_pax_feed_raw',$array);
          if ($this->db->affected_rows() > 0){
             return $this->db->insert_id();
          } else {
             return FALSE;
          }

	}

	function update_paxfeedraw($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_paxfeedraw($id){
		parent::delete($id);
	}
	
}

