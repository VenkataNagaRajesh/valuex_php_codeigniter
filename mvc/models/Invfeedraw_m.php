<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invfeedraw_m extends MY_Model {

	protected $_table_name = 'VX_daily_inv_feed_raw';
	protected $_primary_key = 'invfeedraw_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "invfeedraw_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_invfeedraw($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function get_single_invfeedraw($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function checkInvFeedRaw($array){
		$this->db->select('invfeedraw_id');
		$this->db->from('VX_daily_inv_feed_raw');
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();	
		if($check->invfeedraw_id) {
		    return false ;
		} else {
		  return true;
		}
			

	}


	function insert_invfeedraw($array) {// echo "check"; exit;
                $this->db->insert('VX_daily_inv_feed_raw',$array);
	        if ($this->db->affected_rows() > 0){
        		     return $this->db->insert_id();
          	} else {
             		return FALSE;
          	}

	}

	function update_invfeedraw($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_invfeedraw($id){
		parent::delete($id);
	}
	
}

