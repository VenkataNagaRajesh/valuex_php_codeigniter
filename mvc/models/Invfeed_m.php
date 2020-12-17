<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invfeed_m extends MY_Model {

	protected $_table_name = 'VX_daily_inv_feed';
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
		$this->db->select('*');
		$this->db->from('VX_daily_inv_feed');
		$this->db->where($array);
		$this->db->where('active','1');
		$this->db->limit(1);
		$query = $this->db->get();
                return $query->row();	
	}


	 function getCabinSeatData($array){
                $this->db->select('cabin,empty_seats');
                $this->db->from('VX_daily_inv_feed');
                $this->db->where($array);
                $query = $this->db->get();
                $result = $query->result();
		$arr = array();
		foreach($result as $feed) {
			$arr[$feed->cabin] = $feed->empty_seats;
		}
                return $arr;
        }



	function getEmptyCabinSeats($array) {

		$this->db->select('empty_seats, sold_seats,seat_capacity');
		$this->db->from('VX_daily_inv_feed');
                $this->db->where($array);
		$this->db->where('active','1');
		$this->db->limit(1);
				$query = $this->db->get();
				$data = $query->row();
		return  $data;
	}


	function getSoldWeight($array) {

		$this->db->select('sold_weight');
		$this->db->from('VX_daily_inv_feed');
                $this->db->where($array);
		$this->db->where('active','1');
		$this->db->limit(1);
				$query = $this->db->get();
				$data = $query->row();
				
		return  $data;
	}
		
	function update_entries($update,$where) {
		$this->db->update('VX_daily_inv_feed', $update,$where);
//		var_dump($this->db->last_query());exit;
	}

	function insert_invfeed($array) {// echo "check"; exit;
		 $this->db->insert('VX_daily_inv_feed',$array);
                if ($this->db->affected_rows() > 0){
                             return $this->db->insert_id();
                } else {
                        return FALSE;
                }

	}

	function update_invfeed($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_invfeed($id){
		parent::delete($id);
	}
	
}

