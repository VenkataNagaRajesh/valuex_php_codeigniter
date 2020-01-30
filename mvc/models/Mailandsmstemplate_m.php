<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailandsmstemplate_m extends MY_Model {

	protected $_table_name = 'VX_mailandsmstemplate';
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

	function get_order_by_mailandsmstemplate_with_roleID() {
		$this->db->select('mailandsmstemplate.*,cat.name category,a.aln_data_value airline_name,a.code airline_code');
		$this->db->from('VX_mailandsmstemplate');
		//$this->db->join('usertype', 'usertype.roleID = mailandsmstemplate.roleID', 'LEFT');
		$this->db->join('VX_mailandsmscategory cat','cat.catID = VX_mailandsmstemplate.catID','LEFT');
		$this->db->join('VX_data_defns a','a.vx_aln_data_defnsID = VX_mailandsmstemplate.airlineID','LEFT');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_categories(){
		$query = $this->db->get('mailandsmscategory');
		return $query->result();
	}
	
	function setDefault($catID,$mailandsmstemplateID,$airlineID){
		$this->db->set('default', 0);
		$this->db->where('catID',$catID);
		$this->db->where('airlineID',$airlineID);
		$this->db->update('VX_mailandsmstemplate');
		
		$this->db->set('default', 1);
		$this->db->where('mailandsmstemplateID',$mailandsmstemplateID);
		$this->db->update('VX_mailandsmstemplate');		
		return true;
	}
	
	function getDefaultMailTemplateByCat($cat,$airlineID){
		$this->db->select('t.*')->from('VX_mailandsmstemplate t');
		$this->db->join('VX_mailandsmscategory c','c.catID = t.catID','LEFT');
		$this->db->where('c.alias',$cat);
		$this->db->where('airlineID',$airlineID);
		$this->db->where('t.default',1);
		$query = $this->db->get();
		$this->mydebug->debug($this->db->last_query());
		return $query->row();
	}
}
