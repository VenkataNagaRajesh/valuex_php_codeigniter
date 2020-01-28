<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class client_m extends MY_Model {

	protected $_table_name = 'VX_aln_client';
	protected $_primary_key = 'VX_aln_clientID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "VX_aln_clientID";

	function __construct() {
		parent::__construct();
	}
	function get_client($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);		
		return $query;
	}

	function get_single_client($array) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_client($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_client($data, $id = NULL) {
		parent::update($data, $id);
		
		return $id;
	}

	function delete_client($id){
		parent::delete($id);
	}
	
    function getClientData($id=null,$userID = null){
		$this->db->select('c.*,group_concat(d.aln_data_value) airlines,group_concat(ca.airlineID) airlineIDs')->from('VX_aln_client c');
		$this->db->join('VX_client_airline ca','ca.clientID=c.VX_aln_clientID','LEFT');
		$this->db->join('vx_aln_data_defns d','d.vx_aln_data_defnsID = ca.airlineID','LEFT');
		if($id != null){
		  $this->db->where('c.VX_aln_clientID',$id);
		}
		if($userID != null){
		  $this->db->where('c.userID',$userID);	
		}
		
			
		$this->db->group_by('c.VX_aln_clientID');
		$query = $this->db->get();
		return $query->row();
	}
	
	function clientTotalCount(){
		$this->db->select('count(*) count')->from('VX_user')->where('usertypeID',2);
		$query = $this->db->get();		
		return $query->row('count');
	}
	
	function insert_client_airline($data){
		$this->db->insert('VX_client_airline',$data);
	}
	
	function delete_client_airline($clientID,$airlineIDs =array()){
		if(!empty($airlineIDs)){
		  $this->db->where_in('airlineID',$airlineIDs);
		}
		$this->db->where('clientID',$clientID);
		$this->db->delete('VX_client_airline');		
		return TRUE;
	}
		
}
