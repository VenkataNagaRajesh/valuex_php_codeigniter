<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_m extends MY_Model {

	protected $_table_name = 'VX_permissions';
	protected $_primary_key = 'permissionID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "permissionID asc";

	function __construct() {
		parent::__construct();
	}

	/*public function get_all_usertype()
	{
		$this->db->select('*')->from('VX_usertype')->order_by('roleID');
		$query = $this->db->get();
		return $query->result();	
	}*/

	function get_permission($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

	public function get_modules_with_permission($id=null) {		
		//$query = "Select p1.permissionID,p1.name,p1.description, (case when p2.roleID = $id then 'yes' else 'no' end) as active From VX_permissions p1 left join VX_permission_relationships p2 ON p1.permissionID = p2.permission_id and p2.roleID =$id";
		$query = "Select m.module_name,p1.permissionID,p1.name,p1.description, (case when p2.roleID = $id then 'yes' else 'no' end) as active From VX_permissions p1 LEFT JOIN VX_module m ON m.moduleID = p1.moduleID left join VX_permission_relationships p2 ON p1.permissionID = p2.permission_id and p2.roleID =$id";
		if($this->session->userdata('roleID') != 5){
			$query .= ' WHERE p1.name NOT IN("bulkimport","backup","update") ';
		}
		//$query .= ' ORDER BY p1.moduleID,p1.permissionID ';		
		return $this->db->query($query)->result();
	}

	function get_order_by_permission($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	function insert_permission($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_permission($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}
	public function delete_all_permission($usertypeID,$roleID)
	{
		$this->db->where(array('usertypeID' =>$usertypeID,'roleID' => $id));
	  	$this->db->delete('VX_permission_relationships'); 
	  	return true;
	}
	public function insert_relation($array)
	{
		$this->db->insert("VX_permission_relationships", $array);
		$id = $this->db->insert_id();
		return $id;
	}

	public function delete_permission($id){
		parent::delete($id);
	}


}
