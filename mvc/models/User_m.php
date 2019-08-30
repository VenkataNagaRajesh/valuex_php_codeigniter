<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_m extends MY_Model {

	protected $_table_name = 'user';
	protected $_primary_key = 'userID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "usertypeID";

	function __construct() {
		parent::__construct();
	}

	function get_username($table, $data=NULL) {
		$query = $this->db->get_where($table, $data);
		return $query->result();
	}

	function get_username_row($table, $data=NULL) {
		$query = $this->db->get_where($table, $data);
		return $query->row();
	}

	function get_username_byid($id){
		$this->db->select('name');
		$this->db->from('user');
		$this->db->where(array('userID' => $id));
		$query = $this->db->get();
		$result = $query->row();
		return $result->name;
	}
	
	function get_user_by_usertype($userID = null,$where = array()) {
		$this->db->select('*');
		$this->db->from('user u');
		$this->db->join('usertype ut', 'ut.usertypeID = u.usertypeID', 'LEFT');
		if(!empty($where)){
		    $this->db->where($where);
		}
		if($userID) {
			$this->db->where(array('userID' => $userID));
			$query = $this->db->get();
			return $query->row();
		} else {
			$query = $this->db->get();
			return $query->result();
		}
	}
	
	function getUsers(){
		$this->db->select('*');
		$this->db->from('user u');
		$this->db->join('usertype ut', 'ut.usertypeID = u.usertypeID', 'LEFT');
		$this->db->where('u.usertypeID !=',2);
		$query = $this->db->get();
		return $query->result();		
	}

	function get_user($userID) {
		/* $query = parent::get($array, $signal);
		return $query; */
		$this->db->select('u.*,group_concat(ua.airlineID) airlineIDs,group_concat(dd.code) airlines')->from('user u');
		$this->db->join('VX_user_airline ua','ua.userID=u.userID','LEFT');
        $this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = ua.airlineID','LEFT');		
		$this->db->where('u.userID',$userID);	
		$query = $this->db->get();
		//print_r($this->db->last_query()); exit;
		return $query->row();
	}

	function get_order_by_user($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	function get_single_user($array) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_user($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_user($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	function delete_user($id){
		parent::delete($id);
	}

	function hash($string) {
		return parent::hash($string);
	}

    function userTotalCount(){
		$this->db->select('count(*) count')->from('user');
		$this->db->where('usertypeID !=',2);
		$query = $this->db->get();		
		return $query->row('count');
	}

    function getUserAirlines($userID){
		$this->db->select('dd.*')->from('VX_user_airline ua');
		$this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = ua.airlineID','LEFT');
		$this->db->where('ua.userID',$userID);
		$query = $this->db->get();		
		return $query->result();		
	}
	function getAirlinesByUser($userID){
		$this->db->select('airlineID')->from('VX_user_airline');
		$this->db->where('userID',$userID);
		$query = $this->db->get();
		return $query->result();
	}

    function insert_user_airline($data){
		$this->db->insert('VX_user_airline',$data);
		return $this->db->insert_id();
	}

    function delete_user_airline($userID,$airlineIDs =array()){
		if(!empty($airlineIDs)){
		  $this->db->where_in('airlineID',$airlineIDs);
		}
		$this->db->where('userID',$userID);
		$this->db->delete('VX_user_airline');		
		return TRUE;
	 }
}

