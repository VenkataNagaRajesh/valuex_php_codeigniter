<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rafeed_m extends MY_Model {

	protected $_table_name = 'VX_aln_ra_feed';
	protected $_primary_key = 'rafeed_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "rafeed_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_rafeed($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function get_single_rafeed($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function checkRaFeed($array){
		$this->db->select('rafeed_id');
		$this->db->from('VX_aln_ra_feed');
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();	
		if($check->rafeed_id) {
		    return false ;
		} else {
		  return true;
		}
			

	}

        function getDefIdByTypeAndCode($code,$type) {

                $this->db->select('vx_aln_data_defnsID');
                $this->db->from('vx_aln_data_defns');
                $this->db->where('aln_data_typeID',$type);
                $this->db->where('code',$code);
                $this->db->limit(1);
                $query = $this->db->get();
                $name = $query->row();
                return $name->vx_aln_data_defnsID;
        }


	function getCodesByType($type) {
		$this->db->select('vx_aln_data_defnsID, code');
                $this->db->from('vx_aln_data_defns');
                $this->db->where('aln_data_typeID',$type);
		$this->db->where('code !=',NULL);
		$query = $this->db->get();
		$result = $query->result();
		foreach ($result as $k) {
			$arr[$k->vx_aln_data_defnsID] = $k->code;
		}
		
		return $arr;
	}

	function insert_rafeed($array) {// echo "check"; exit;
		$error = parent::insert($array);
//		print_r($this->db->last_query); exit;
		return TRUE;
	}

	function update_rafeed($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_rafeed($id){
		parent::delete($id);
	}
	
}

