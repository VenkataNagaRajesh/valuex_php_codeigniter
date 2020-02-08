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

	public function add_client_product($data){
		$this->db->insert('VX_client_product',$data);
		return ($this->db->affected_rows() == 1) ? true : false;
	}

	public function get_client_products($clientID){
		$this->db->select('cp.*,d.code carrier,c.name contract_name,p.name product_name')->from('VX_client_product cp');
		$this->db->join('VX_contract c','c.contractID = cp.contractID','LEFT');
		$this->db->join('VX_data_defns d','d.vx_aln_data_defnsID = c.airlineID','LEFT');
		$this->db->join('VX_products p','p.productID = cp.productID','LEFT');
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
		
}
