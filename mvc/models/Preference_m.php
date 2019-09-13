<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class preference_m extends MY_Model {

	protected $_table_name = 'VX_aln_preference';
	protected $_primary_key = 'VX_aln_preferenceID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "VX_aln_preferenceID asc";

	function __construct() {
		parent::__construct();
	}	
	
	function get_preference($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_preference($array) {
		$error = parent::insert($array);
		return TRUE;
	}


	function get_preferenceslist($array){
		$this->db->select('*')->from('VX_aln_preference');
		$this->db->where($array);
		$this->db->where('active','1');
		 $query = $this->db->get();
                $result = $query->result();
		return $result;
		

	}


	 function get_preferenceslist_not_in($type ,$array,$where){
                $this->db->select('*')->from('VX_aln_preference');
                $this->db->where_not_in($type,$array);
		$this->db->where('active','1');
		$this->db->where($where);
                 $query = $this->db->get();
                $result = $query->result();
                return $result;


        }



	function update_preference($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_preference($id){
		parent::delete($id);
	}
	
	function get_preference_data($id){ 
		$this->db->select('p.*,dd.aln_data_value category,dd1.name type,dt1.name valuetype,dt2.name value,u.name user')->from('VX_aln_preference p');
		$this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = p.categoryID','LEFT');
		$this->db->join('vx_aln_data_types dd1','dd1.vx_aln_data_typeID = p.pref_type','LEFT');
		$this->db->join('vx_aln_data_types dt1','dt1.vx_aln_data_typeID = p.pref_get_value_type','LEFT');
		$this->db->join('vx_aln_data_types dt2','dt2.vx_aln_data_typeID = p.pref_get_value','LEFT');
        $this->db->join('user u','u.userID = p.create_userID','LEFT');		
		$this->db->where('VX_aln_preferenceID',$id);
		$query = $this->db->get();
		return $query->row();
	}

	// for getiing airline/user specific preferences;
	// 1. check with airline/userid
	// 2. if not avaiable for case1 then return default value

	function get_preference_value_bycode($code,$type,$id){
		$this->db->select('pref_value')->from('VX_aln_preference');
		$this->db->where('pref_code',$code);	
		$this->db->where('pref_type',$type);
		$this->db->where('pref_type_value',$id);
		$this->db->where('active',1);
		$this->db->limit(1);
		$query = $this->db->get();
		$data = $query->row();
		if(count($data) > 0 ) {
			return $data->pref_value;
		} else {
			$this->db->select('pref_value')->from('VX_aln_preference');
	                $this->db->where('pref_code',$code);
        	        $this->db->where('pref_type',$type);
                	$this->db->where('pref_type_value','0');
			$this->db->limit(1);
        	        $query = $this->db->get();
	                $data = $query->row();
			if(count($data) > 0 ) {
                        	return $data->pref_value;
                	}
			
		}

	}


	function get_application_preference_value($code,$type) {

		 $this->db->select('pref_value')->from('VX_aln_preference');
                $this->db->where('pref_code',$code);
                $this->db->where('pref_type',$type);
                $this->db->where('active',1);
                $this->db->limit(1);
                $query = $this->db->get();
                $data = $query->row();
		return $data->pref_value;	

	}
}

