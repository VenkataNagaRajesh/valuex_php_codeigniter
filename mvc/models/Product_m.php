<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product_m extends MY_Model {

	protected $_table_name = 'VX_products';
	protected $_primary_key = 'productID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "productID ASC";

	function __construct() {
		parent::__construct();
	}

	function get_products($array=NULL, $signal=FALSE) {
            	$query = $this->db->get_where('VX_products',$array);
		return $query->result();   
	}

	function get_single_product($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_product($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function checkProductExists($product_name) {
		$array = Array("name" => $produt_name);
            	$query = $this->db->get_where('VX_products',array("name"=>$product_name));
            	$result = $query->row();
		if ($result) {
			return $result->productID;
		} else {
			return FALSE;
		}
	}

	function update_product($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_product($id){
		parent::delete($id);
	}

	function productName()
	{
		$this->db->select('productID,name');
		$this->db->from('VX_products');
		// $this->db->where('aln_data_typeID', $type);
		// $this->db->where('code !=', NULL);
		$query = $this->db->get();
		$result = $query->result();
		foreach ($result as $k) {
			$arr[$k->productID] = $k->name;
		}
		return $arr;
	}
}

