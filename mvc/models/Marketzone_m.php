<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketzone_m extends MY_Model {

	protected $_table_name = 'VX_aln_market_zone';
	protected $_primary_key = 'market_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "market_id";

	function __construct() {
		parent::__construct();
	}


	function get_marketzonename($id) {
		$query = $this->db->get_where('VX_aln_market_zone',array('market_id'=>$id));
		return $query->row();
	}


	function get_single_marketzone($array) {
	        $query = parent::get_single($array);
        	return $query;
    	}

	function get_order_by_marketzone($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	 function get_marketzones() {
                $this->db->select('*');
                $this->db->from('VX_aln_market_zone');
                        $query = $this->db->get();
                        return $query->result();
        }

	function insert_marketzone($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function getAlndataType($type){
		$this->db->select('name');
		$this->db->from('vx_aln_data_types');
		$this->db->where(array('vx_aln_data_typeID' => $type));
		$query = $this->db->get();
		$type = $query->row();
		return $type->name;
		
	}

	function getAlnDataTYpes(){
	        $this->db->select('vx_aln_data_typeID,name');
                $this->db->from('vx_aln_data_types');
		$query = $this->db->get();
		$result = $query->result();
                foreach($result  as $type) {
                        $datatypes[$type->vx_aln_data_typeID]  = $type->name;
                }
        	return $datatypes;
	}




	function getMarketzones_for_triggerrun($timestamp) {
		$sql = "SELECT * FROM VX_aln_market_zone
                              WHERE modify_date >= ".$timestamp;
		$marketzones = $this->install_m->run_query($sql);
                return $marketzones;
	}



	function getALndataTypeValues($list){
		$query = "SELECT aln_data_value FROM  vx_aln_data_defns WHERE vx_aln_data_defnsID in (". $list . ")";
                $result = $this->install_m->run_query($query);
		$str = '';
		return implode('<br>+',array_column($result, 'aln_data_value'));
	}
	
	function getSubDataDefns($id){
		  
		 $this->db->select('vx_aln_data_defnsID, aln_data_value')->from('vx_aln_data_defns');
         	 $this->db->where('aln_data_typeID',$id);
         	$query = $this->db->get();
         	$result =  $query->result();
		return $result;
	}


	function getAirportsList($parentID){
		 $query = "select vx_aln_data_defnsID FROM 
					( SELECT * from 
					( SELECT * from vx_aln_data_defns  order by parentID, vx_aln_data_defnsID) 
					  vx_aln_data_defns, (select @pv := ".$parentID.") 
                                          initialisation where find_in_set(parentID, @pv) > 0 and 
					  @pv := concat(@pv, ',', vx_aln_data_defnsID ) ) as subresult where aln_data_typeID = 1";
		$result = $this->install_m->run_query($query);
		return array_column($result,'vx_aln_data_defnsID');
	}

	function update_marketzone($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	function delete_marketzone($id){
		parent::delete($id);
	}

	function hash($string) {
		return parent::hash($string);
	}	
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
