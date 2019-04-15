<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airports_m extends MY_Model {

  public function checkData($data,$type,$parent = null){
	$this->db->select('*')->from('vx_aln_data_defns');
	  $this->db->where(array('aln_data_value'=>$data,'aln_data_typeID'=> $type));
	  $query = $this->db->get();	
	  if (count($query->result()) > 0) {
       return $query->row('vx_aln_data_defnsID');
      } else {
		$array = array(
		'aln_data_value' => $data,
		'aln_data_typeID' => $type,
		'create_date' => time(),
		'modify_date' => time(),
		'create_userID' => $this->session->userdata('loginuserID'),
		'modify_userID' => $this->session->userdata('loginuserID'),
		'parentID' => $parent
		);
      $this->db->insert('vx_aln_data_defns',$array);
	  if ($this->db->affected_rows() > 0){
	     return $this->db->insert_id();
	  } else {
	     return FALSE; 
	  }
    }
  }
  
  public function checkAirport($data){ 
	  $this->db->select('count(*)')->from('vx_aln_data_defns');
	  $this->db->where(array('aln_data_value'=>$data,'aln_data_typeID'=> 1));
	  $query = $this->db->get();	
	  if ($query->row('count(*)') > 0) { 
       return 0;
      } else { 
       return 1;
      }	   
  }
  
  public function addAirport($airport,$parent){ 
	 $array = array(
		'aln_data_value' => $airport,
		'aln_data_typeID' => 1,
		'create_date' => time(),
		'modify_date' => time(),
		'create_userID' => $this->session->userdata('loginuserID'),
		'modify_userID' => $this->session->userdata('loginuserID'),
		'parentID' => $parent
		);
		
      $this->db->insert('vx_aln_data_defns',$array);
	  if ($this->db->affected_rows() > 0){
	     return $this->db->insert_id();
	  } else {
	     return FALSE; 
	  }
  }
  
  public function addMasterData($data){	 
	  $this->db->insert('vx_aln_master_data',$data);	 
	  if ($this->db->affected_rows() > 0){
	     return $this->db->insert_id();
	  } else {
	     return FALSE; 
	  }
  }
  
  public function getDefns(){
	  $this->db->select('vx_aln_data_defnsID,aln_data_typeID,aln_data_value')->from('vx_aln_data_defns'); 
	  $this->db->where('aln_data_typeID !=',1);
	  $query = $this->db->get();
	  return $query->result();
  }
	
}

