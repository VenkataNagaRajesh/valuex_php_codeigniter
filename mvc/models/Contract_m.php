<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_m extends MY_Model {

	protected $_table_name = 'VX_contract';
	protected $_primary_key = 'contractID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "contractID desc";

	function __construct() {
		parent::__construct();
	}

	function get_contracts($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);		
		return $query;   
	}
	
	function get_contract($id){
		$this->db->select('c.*,group_concat(cp.productID) products')->from('VX_contract c');
		$this->db->join('VX_contract_products cp','cp.contractID = c.contractID','LEFT');
		$this->db->where('c.contractID',$id);
		$query = $this->db->get();
		return $query->row();
	}

	function insert_contract($array) {		
		$error = parent::insert($array);
		return TRUE;
	}

	function update_contract($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_contract($id){
		parent::delete($id);
	}

	public function getContractsByWhere($where){
		$query=$this->db->get_where('VX_contract',$where);
		return $query->result();
	}

	public function getAirlineProducts($airlineID){
		$this->db->select('p.*,c.*')->from('VX_contract c');
		$this->db->join('VX_products p','p.productID=c.productID','LEFT');
		$this->db->where('c.airlineID',$airlineID);
		$query = $this->db->get();
		return $query->result();
	}

	public function insert_contract_product($data){
		$this->db->insert('VX_contract_products',$data);
		return ($this->db->affected_rows() == 1) ? true : false;
	}

	public function delete_contract_product($contractID,$list){
		$this->db->where_in('productID',explode($list));
		$this->db->where('contractID',$contractID);
		$this->db->delete('VX_contract_products');
	}
	public function getProductsByContract($contractID){
		$this->db->select('p.*')->from('VX_contract_products cp');
		$this->db->join('VX_products p','p.productID = cp.productID','LEFT');
		$this->db->where('cp.contractID',$contractID);
		$query = $this->db->get();
		return $query->result();
	}
}

