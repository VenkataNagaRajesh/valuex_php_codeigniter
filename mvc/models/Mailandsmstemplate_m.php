<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailandsmstemplate_m extends MY_Model {

	protected $_table_name = 'mailandsmstemplate';
	protected $_primary_key = 'mailandsmstemplateID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "mailandsmstemplateID asc";

	function __construct() {
		parent::__construct();
	}

	function get_mailandsmstemplate($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}
	
	function get_single_mailandsmstemplate($array = NULL){
		$query = parent::get_single($array);		
		return $query;
	}

	function get_order_by_mailandsmstemplate($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	function insert_mailandsmstemplate($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_mailandsmstemplate($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_mailandsmstemplate($id){
		parent::delete($id);
	}

	function get_order_by_mailandsmstemplate_with_usertypeID() {
		$this->db->select('mailandsmstemplate.*,cat.name category');
		$this->db->from('mailandsmstemplate');
		//$this->db->join('usertype', 'usertype.usertypeID = mailandsmstemplate.usertypeID', 'LEFT');
		$this->db->join('mailandsmscategory cat','cat.catID = mailandsmstemplate.catID','LEFT');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_categories(){
		$query = $this->db->get('mailandsmscategory');
		return $query->result();
	}
	
	function setDefault($catID,$mailandsmstemplateID){
		$this->db->set('default', 0);
		$this->db->where('catID',$catID);
		$this->db->update('mailandsmstemplate');
		
		$this->db->set('default', 1);
		$this->db->where('mailandsmstemplateID',$mailandsmstemplateID);
		$this->db->update('mailandsmstemplate');		
		return true;
	}
}
