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
		$this->db->select('dd.*,dd.aln_data_value airline_name,dd.code,u.name modify_by,group_concat( distinct ac.aln_data_value,"/",sc.aln_data_value) as aircraft_seat_capacity,GROUP_CONCAT(d.aln_data_value SEPARATOR ", ") flights')->from('vx_aln_data_defns dd');	
        $this->db->join('vx_aln_data_defns d','d.parentID = dd.vx_aln_data_defnsID AND d.aln_data_typeID = 16','LEFT');
		$this->db->join('VX_airline_aircraft aa','aa.airlineID = dd.vx_aln_data_defnsID','LEFT');
		$this->db->join('vx_aln_data_defns ac','ac.vx_aln_data_defnsID = aa.aircraftID AND ac.aln_data_typeID = 21','LEFT');
        $this->db->join('vx_aln_data_defns sc','sc.parentID = aa.aircraftID AND sc.aln_data_typeID = 22','LEFT');		
		$this->db->join('user u','u.userID = dd.modify_userID','LEFT');	
        $this->db->where('dd.aln_data_typeID',12);
		$this->db->where('dd.vx_aln_data_defnsID',$id);	
        $this->db->group_by('dd.vx_aln_data_defnsID');		
		$query = $this->db->get();
		//print_r($this->db->last_query()); exit;
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
		$this->db->select('dd.*,dd.aln_data_value airline_name,ca.airlineID')->from('VX_aln_client c');
		//$this->db->join('VX_aln_airline a','a.VX_aln_airlineID = c.airlineID','LEFT');
		$this->db->join('VX_client_airline ca','ca.clientID = c.VX_aln_clientID','LEFT');
		$this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = ca.airlineID','LEFT');
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
		$this->db->join('VX_client_airline ca','ca.clientID = c.VX_aln_clientID','LEFT');
                $this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = ca.airlineID','LEFT');
                $this->db->where('c.userID',$userID);
                $query = $this->db->get();

		$result = $query->result();
		foreach($result as $v) {
			$arr[$v->vx_aln_data_defnsID] = $v->airline_name;
		}

		return $arr;
        }



	
	public function checkAirline($airline){
		$check = $this->db->get_where('vx_aln_data_defns',array('aln_data_typeID' => 12,'code' => $airline['code']))->row();
		if(!empty($check)){
			//$data->existed = 1;
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
				//$data->existed = 0;
				$data->id = $this->db->insert_id();
				 return $data;
			} else {
				 return FALSE; 
			}
		}
	}
	
	public function linkAirlineAircraft($airlineID,$aircraftID){
		$this->db->select("count(*) count")->from('VX_airline_aircraft');
		$this->db->where("airlineID",$airlineID);
		$this->db->where("aircraftID",$aircraftID);
		$query = $this->db->get();
		$count = $query->row('count');
		$this->mydebug->debug($count);
		if($count == 0){
			$link['airlineID'] = $airlineID;
			$link['aircraftID'] = $aircraftID;
			$link['create_date'] = time();
			$link['modify_date'] = time();
			$link['create_userID'] = $this->session->userdata('loginuserID');
			$link['modify_userID'] = $this->session->userdata('loginuserID');
			$this->db->insert('VX_airline_aircraft',$link);
			$this->mydebug->debug($this->db->last_query());
		}
		return TRUE;
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

    public function getFlights($id){
		$this->db->select('*')->from('vx_aln_data_defns');
		$this->db->where('parentID',$id);
		$this->db->where('aln_data_typeID',16);
		$query = $this->db->get();
		return $query->result();
	}	
	public function updateSeatCapacity($seat_capacity,$seatID){
		$this->db->where('vx_aln_data_defnsID',$seatID);
		$this->db->where('aln_data_typeID',22);
		$this->db->update('vx_aln_data_defns',array('aln_data_value'=>$seat_capacity));
	}


	public function getAirCraftTypesList($airlineID){
		$this->db->select('ac.aircraftID , dd.aln_data_value')->from('VX_airline_aircraft ac');
		 $this->db->join('vx_aln_data_defns dd','dd.vx_aln_data_defnsID = ac.aircraftID','LEFT');
		$this->db->where('ac.airlineID',$airlineID);
		 $query = $this->db->get();
		$result = $query->result();
		return $result;

	}
}

