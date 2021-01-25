<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_m extends MY_Model {

	protected $_table_name = 'VX_user';
	protected $_primary_key = 'userID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "roleID";

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
		$this->db->from('VX_user');
		$this->db->where(array('userID' => $id));
		$query = $this->db->get();
		$result = $query->row();
		return $result->name;
	}
	
	function get_user_by_role($userID = null,$where = array()) {
		$this->db->select('*');
		$this->db->from('VX_user u');
		$this->db->join('VX_role ur', 'ur.roleID = u.roleID', 'LEFT');
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
		$this->db->select('u.*,ur.role,ut.usertype');
		$this->db->from('VX_user u');
		$this->db->join('VX_role ur', 'ur.roleID = u.roleID', 'LEFT');
		$this->db->join('VX_usertype ut','ut.usertypeID = u.usertypeID ','LEFT');
		$this->db->where('u.usertypeID !=',2);		
		$query = $this->db->get();
		return $query->result();		
	}

	function get_user($userID) {
		/* $query = parent::get($array, $signal);
		return $query; */
		$this->db->select('u.*,group_concat(ua.user_airlineID) user_airline,group_concat(ua.airlineID) airlineIDs,group_concat(dd.code) airlines')->from('VX_user u');
		$this->db->join('VX_user_airline ua','ua.userID=u.userID','LEFT');
        $this->db->join('VX_data_defns dd','dd.vx_aln_data_defnsID = ua.airlineID','LEFT');		
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
		$data['active'] = 0;
		parent::update($data, $id);
	}

	function hash($string) {
		return parent::hash($string);
	}

    function userTotalCount(){
		$this->db->select('count(*) count')->from('VX_user');
		$this->db->where('usertypeID !=',2);
		$query = $this->db->get();		
		return $query->row('count');
	}

    function getUserAirlines($userID){
		$this->db->select('dd.*')->from('VX_user_airline ua');
		$this->db->join('VX_data_defns dd','dd.vx_aln_data_defnsID = ua.airlineID','LEFT');
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
	function getProductsByUser($userID){
		$this->db->select('group_concat(productID) products')->from('VX_user_product');
		$this->db->where('userID',$userID);
		$query = $this->db->get();
		return $query->row('products');
	}
	function getProductsInfoByUser($userID){
		$this->db->select('group_concat(p.name) product_name,group_concat(up.productID) products')->from('VX_user_product up');
		$this->db->join('VX_products p','p.productID = up.productID','LEFT');
		$this->db->where('up.userID',$userID);
		$query = $this->db->get();
		return $query->row();
	}

    function insert_user_airline($data){
		$this->db->insert('VX_user_airline',$data);
		return $this->db->insert_id();
	}

	function update_user_airline($id,$data){
		$this->db->where('user_airlineID',$id);
		$this->db->update('VX_user_airline',$data);		
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

	 function getClientByAirline($airlineID,$role=null){
		 $this->db->select('u.*')->from('VX_user u');
		 $this->db->join('VX_user_airline ua','ua.userID = u.userID','INNER');
		 $this->db->where('ua.airlineID',$airlineID);
		 $this->db->where('u.usertypeID',2);
		 if($role){
			$this->db->where('u.roleID',$role);
		 }
		 $query = $this->db->get();
		 return $query->result();
	 }

	 function insert_user_product($data){
		 $this->db->insert("VX_user_product",$data);
		 return TRUE;
	 }

	 function delete_user_product($userID,$products =array()){
		if(!empty($products)){
		  $this->db->where_in('productID',$products);
		}
		$this->db->where('userID',$userID);
		$this->db->delete('VX_user_product');		
		return TRUE;
	 }

	 function getUserActiveProducts($airlineID){		 
		 $this->db->select('p.*,cp.*')->from('VX_contract c');		 
		 $this->db->join('VX_contract_products cp','cp.contractID = c.contractID','LEFT');
		 $this->db->join('VX_products p','p.productID = cp.productID','LEFT');
		 $this->db->where('c.airlineID',$airlineID);
		 $this->db->where('c.active',1);
		 $this->db->where('cp.start_date <=',date('Y-m-d'));
		 $this->db->where('cp.end_date >=',date('Y-m-d'));
		 $query = $this->db->get();
		 //print_r($this->db->last_query());
		 return $query->result();
	 }

	 function getUsersCountByAirline($airlineID,$usertypeID,$productID,$userID = null){
		 $this->db->select("count(*) count")->from('VX_user_airline ua');
		 $this->db->join("VX_user u","u.userID = ua.userID","LEFT");
		 $this->db->join('VX_user_product up','up.userID = u.userID','LEFT');
		 $this->db->where('u.usertypeID',$usertypeID);
		 $this->db->where('ua.airlineID',$airlineID);
		 $this->db->where('up.productID',$productID);
		 if($userID){
			 $this->db->where('u.userID !=',$userID);
		 }
		 $query = $this->db->get();		
		 return $query->row('count');
	 }

	 function loginUserProducts(){
		 $this->db->select('cp.*,p.name product_name,c.name contract_name')->from('VX_contract_products cp');
		 $this->db->join('VX_user_product up','up.productID = cp.productID',"LEFT");
		 $this->db->join('VX_contract c','c.contractID = cp.contractID','INNER');
		 $this->db->join('VX_products p','p.productID = cp.productID','INNER');		 
		 $this->db->where('up.userID',$this->session->userdata('loginuserID'));
		 $this->db->where('cp.end_date >=',date('Y-m-d'));
		 $this->db->where('c.active',1);
		 $this->db->where('cp.status',1);
		 $query = $this->db->get();
		 return $query->result();
	 }
}

