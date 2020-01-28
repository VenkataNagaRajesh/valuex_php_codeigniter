<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rafeed_m extends MY_Model {

	protected $_table_name = 'UP_ra_feed';
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
		$this->db->from('UP_ra_feed');
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
                $this->db->from('VX_data_defns');
                $this->db->where('aln_data_typeID',$type);
                $this->db->where('code',$code);
                $this->db->limit(1);
                $query = $this->db->get();
                $name = $query->row();
                return $name->vx_aln_data_defnsID;
        }


	function getDefIdByTypeAndAlias($alias,$type) {

                $this->db->select('vx_aln_data_defnsID');
                $this->db->from('VX_data_defns');
                $this->db->where('aln_data_typeID',$type);
                $this->db->where('alias',$alias);
                $this->db->limit(1);
                $query = $this->db->get();
                $name = $query->row();
                return $name->vx_aln_data_defnsID;
        }


	function getDefIdByTypeAndName($name ,$type) {

		$this->db->select('vx_aln_data_defnsID');
                $this->db->from('VX_data_defns');
                $this->db->where('aln_data_typeID',$type);
                $this->db->where('aln_data_value',$name);
                $this->db->limit(1);
                $query = $this->db->get();
                $name = $query->row();

                return $name->vx_aln_data_defnsID;

	}
	function getCodesByType($type) {
		$this->db->select('vx_aln_data_defnsID, code');
                $this->db->from('VX_data_defns');
                $this->db->where('aln_data_typeID',$type);
		$this->db->where('code !=',NULL);
		$query = $this->db->get();
		$result = $query->result();
		foreach ($result as $k) {
			$arr[$k->vx_aln_data_defnsID] = $k->code;
		}
		
		return $arr;
	}


	function getNamesByType($type) {
                $this->db->select('vx_aln_data_defnsID, aln_data_value');
                $this->db->from('VX_data_defns');
                $this->db->where('aln_data_typeID',$type);
                $this->db->where('aln_data_value !=',NULL);
                $query = $this->db->get();
                $result = $query->result();
                foreach ($result as $k) {
                        $arr[$k->vx_aln_data_defnsID] = $k->aln_data_value;
                }

                return $arr;
        }


	function insert_rafeed($array) {// echo "check"; exit;

		  $this->db->insert('UP_ra_feed',$array);
                if ($this->db->affected_rows() > 0){
                             return $this->db->insert_id();
                } else {
                        return FALSE;
                }


	}

	function update_rafeed($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_rafeed($id){
		parent::delete($id);
		$this->db->where('sub_season_record',$id);
                $this->db->delete('UP_ra_feed');
              return TRUE;
	
	}
	
}

