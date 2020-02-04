<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_product_m extends MY_Model {

	protected $_table_name = 'VX_airline_product';
	protected $_primary_key = 'airline_productID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "airline_productID desc";

	function __construct() {
		parent::__construct();
	}

	function get_airline_products($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);		
		return $query;   
	}
	
	function get_airline_product($id){
		$this->db->select('*')->from('VX_airline_product');
		$this->db->where('airline_productID',$id);
		$query = $this->db->get();
		return $query->row();
	}

	function insert_airline_product($array) {
		//print_r($array); exit;
		$error = parent::insert($array);
		return TRUE;
	}

	function update_airline_product($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_airline_product($id){
		parent::delete($id);
	}

	public function getAirlineByWhere($where){
		$query=$this->db->get_where('VX_airline_product',$where);
		return $query->result();
	}

	public function getAirlineProducts($airlineID){
		$this->db->select('p.*,ap.*')->from('VX_airline_product ap');
		$this->db->join('VX_products p','p.productID=ap.productID','LEFT');
		$query = $this->db->get();
		return $query->result();
	}
}

