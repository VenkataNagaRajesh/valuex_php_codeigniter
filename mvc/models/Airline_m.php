<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_m extends MY_Model {

	protected $_table_name = 'vx_aln_data_defns';
	protected $_primary_key = 'vx_aln_data_defnsID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "vx_aln_data_defnsID desc";

	function __construct() {
		parent::__construct();
	}

	function get_airlines($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function get_single_airline($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_airline($array) {
		$error = parent::insert($array);
		if ($this->db->affected_rows() > 0){
	     return $this->db->insert_id();
	  } else {
	     return FALSE; 
	  }
	}

	function update_airline($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_airline($id){
		parent::delete($id);
	}
	
	public function getAirlineData($id){
		$this->db->select('dd.*,dd.aln_data_value airline_name,dd.code,u.name modify_by,GROUP_CONCAT(d.aln_data_value SEPARATOR ", ") flights')->from('vx_aln_data_defns dd');	
        $this->db->join('vx_aln_data_defns d','d.parentID = dd.vx_aln_data_defnsID','LEFT');			
		$this->db->join('user u','u.userID = dd.modify_userID','LEFT');	
        $this->db->where('dd.aln_data_typeID',12);
		$this->db->where('dd.vx_aln_data_defnsID',$id);		
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getAirlinesData(){
		$this->db->select('dd.*,dd.aln_data_value airline_name,dd.code,u.name modify_by')->from('vx_aln_data_defns dd');		
		$this->db->join('user u','u.userID = dd.modify_userID','LEFT');	
        $this->db->where('dd.aln_data_typeID',12);		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getClientAirline($userID, $getrow=NULL){
		$this->db->select('dd.*,dd.aln_data_value airline_name,c.airlineID')->from('VX_aln_client c');
		//$this->db->join('VX_aln_airline a','a.VX_aln_airlineID = c.airlineID','LEFT');
		$this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = c.airlineID','LEFT');
		$this->db->where('c.userID',$userID);
		$query = $this->db->get();

		if ($getrow == 1) {
                	return $query->row();
		} else {
			return $query->result();
		}
	}




	public function getClientAirlineArr($userID){
                $this->db->select('dd.*,dd.aln_data_value airline_name')->from('VX_aln_client c');
                //$this->db->join('VX_aln_airline a','a.VX_aln_airlineID = c.airlineID','LEFT');
                $this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = c.airlineID','LEFT');
                $this->db->where('c.userID',$userID);
                $query = $this->db->get();

		$result = $query->result();
		foreach($result as $v) {
			$arr[$v->vx_aln_data_defnsID] = $v->airline_name;
		}

		return $arr;
        }



	
	public function checkAirline($airline){
		$check = $this->db->get_where('vx_aln_data_defns',array('aln_data_typeID' => 12,'aln_data_value' => $airline['name']))->row();
		if(!empty($check)){
			$data->existed = 1;
			$data->id = $check->vx_aln_data_defnsID;
			return $data;
		}else{
			$array = array(
			'aln_data_value' => $airline['name'],
			'aln_data_typeID' => 12,
			'create_date' => time(),
			'modify_date' => time(),
			'create_userID' => $this->session->userdata('loginuserID'),
			'modify_userID' => $this->session->userdata('loginuserID'),
			'code' => $airline['code']
			);
		  $this->db->insert('vx_aln_data_defns',$array);
			if ($this->db->affected_rows() > 0){
				$data->existed = 0;
				$data->id = $this->db->insert_id();
				 return $data;
			} else {
				 return FALSE; 
			}
		}
	}
	
	public function add_airline($airline){
		$array = array(
			'aln_data_value' => $airline['name'],
			'aln_data_typeID' => 12,
			'create_date' => time(),
			'modify_date' => time(),
			'create_userID' => $this->session->userdata('loginuserID'),
			'modify_userID' => $this->session->userdata('loginuserID'),
			'code' => $airline['code'],
			'parentID' => $airline['aircraftID']
			);
		  $this->db->insert('vx_aln_data_defns',$array);
			if ($this->db->affected_rows() > 0){
				$data->existed = 0;
				$data->id = $this->db->insert_id();
				 return $data;
			} else {
				 return FALSE; 
			}
	}	
	
}

