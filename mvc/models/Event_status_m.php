<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_status_m extends MY_Model {

	protected $_table_name = 'UP_event_status';
	protected $_primary_key = 'es_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "es_id";

	function __construct() {
		parent::__construct();
	}


	function get_order_by_event_status($array=NULL) {
                $query = parent::get_order_by($array);
                return $query;
        }


	function get_event_status_by_id($id){
		$this->db->select('*');
                $this->db->from('UP_event_status');
		$this->db->where('es_id', $id);	
		$query = $this->db->get();
                        return $query->result();
        }


	function checkEventStatus($array){
                $this->db->select('es_id');
                $this->db->from('UP_event_status');
                $this->db->where($array);
                $this->db->limit(1);
                $query = $this->db->get();
                $check = $query->row();
                if($check->es_id) {
                    return false ;
                } else {
                  return true;
                }


        }


         function get_single_event_status($array) {
		$this->db->select('event_id, current_status, isInternalStatus, group_concat(next_status) as next_status' );
		$this->db->from('UP_event_status');
		$this->db->where($array);
		$this->db->group_by(array("event_id", "current_status","isInternalStatus"));
		 $this->db->limit(1);
                $query = $this->db->get();
                $result = $query->row();

                return $result;
        }


	function insert_event_status($array) {
		$id = parent::insert($array);
		return TRUE;
	}


	function update_event_status($data, $event_id, $current_status) {
		$this->db->where('event_id', $event_id);
		$this->db->where('current_status', $current_status);
		$this->db->update('UP_event_status', $data);
	}

	function delete_event_status($id,$status){
		 $this->db->where('event_id', $id);
                $this->db->where('current_status', $status);
                $this->db->delete('UP_event_status');
                return;
	}

	function hash($string) {
		return parent::hash($string);
	}	
}

