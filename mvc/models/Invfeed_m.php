<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invfeed_m extends MY_Model {

	protected $_table_name = 'VX_aln_daily_inv_feed';
	protected $_primary_key = 'invfeed_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "invfeed_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_invfeed($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function get_single_invfeed($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function checkInvFeed($array){
		$this->db->select('invfeed_id');
		$this->db->from('VX_aln_daily_inv_feed');
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();	
		if($check->invfeed_id) {
		    return false ;
		} else {
		  return true;
		}
			

	}


	 function getCabinSeatData($array){
                $this->db->select('cabin,empty_seats');
                $this->db->from('VX_aln_daily_inv_feed');
                $this->db->where($array);
                $query = $this->db->get();
                $result = $query->result();
		$arr = array();
		foreach($result as $feed) {
			$arr[$feed->cabin] = $feed->empty_seats;
		}
                return $arr;
        }



	function insert_invfeed($array) {// echo "check"; exit;
		$error = parent::insert($array);
//		print_r($this->db->last_query); exit;
		return TRUE;
	}

	function update_invfeed($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_invfeed($id){
		parent::delete($id);
	}
	
}

