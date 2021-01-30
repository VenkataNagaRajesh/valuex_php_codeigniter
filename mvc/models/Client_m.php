<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class client_m extends MY_Model {	
	
    function getClientData($id=null,$userID = null){
		$this->db->select('c.*,group_concat(d.aln_data_value) airlines,group_concat(ca.airlineID) airlineIDs')->from('VX_aln_client c');
		$this->db->join('VX_client_airline ca','ca.clientID=c.VX_aln_clientID','LEFT');
		$this->db->join('VX_data_defns d','d.vx_aln_data_defnsID = ca.airlineID','LEFT');
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
		$this->db->select('count(*) count')->from('VX_user u');
		$this->db->join('VX_user_airline ua','ua.userID = u.userID','LEFT');
		$this->db->where('u.usertypeID',2);
		if($this->session->userdata('roleID') != 1){
			$this->db->where_in('ua.airlineID',$this->session->userdata('login_user_airlineID'));
		}
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

	public function add_client_product($data){
		$this->db->insert('VX_client_product',$data);
		return ($this->db->affected_rows() == 1) ? true : false;
	}

	public function get_client_products($clientID){
		$this->db->select('up.*,p.name product_name')->from('VX_user_product up');		
		$this->db->join('VX_products p','p.productID = up.productID','LEFT');
		$this->db->where('up.userID',$clientID);
		$query = $this->db->get();		
		return $query->result();
	}

	public function delete_client_product($id){
		$this->db->select('clientID')->from('VX_client_product')->where('client_productID',$id);
		$query = $this->db->get();
		$clientID = $query->row('clientID');
		$this->db->where('client_productID',$id);
		$this->db->delete('VX_client_product');
		return $clientID;
	}

   function isClientAdminUserExists($carrierId){
		$this->db->select('u.userID')->from('VX_user u');
		$this->db->join('VX_user_airline ua','ua.userID = u.userID','INNER');
		$this->db->where('u.roleID',6);
		$this->db->where('u.active',1);
		$this->db->where('ua.airlineID',$carrierId);
		$query = $this->db->get();
           // print_r($this->db->last_query()); exit;
		$result =  $query->row();
		return $result->userID;
	}

	function getAirlineAdminByCarriercode($carrier_code){
		$this->db->select('u.email')->from('VX_user u');
		$this->db->join('VX_user_airline ua','ua.userID = u.userID','INNER');
		$this->db->join('VX_data_defns dd','dd.vx_aln_data_defnsID = ua.airlineID','LEFT');
		$this->db->where('u.roleID',6);
		$this->db->where('u.active',1);
        $this->db->where('dd.aln_data_typeID',12);
		$this->db->where('dd.code',$carrier_code);
		$query = $this->db->get();
		return $query->row_array();
	}
}
