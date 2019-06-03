<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airports_m extends MY_Model {

  public function checkData($data,$type,$parent = null,$code=null){
	$this->db->select('*')->from('vx_aln_data_defns');
	  $this->db->where(array('aln_data_value'=>$data,'aln_data_typeID'=> $type));
	  $query = $this->db->get();	
	  if (count($query->result()) > 0) {
       return $query->row('vx_aln_data_defnsID');
      } else {
		$array = array(
		'aln_data_value' => $data,
		'aln_data_typeID' => $type,
		'code' => $code,
		'create_date' => time(),
		'modify_date' => time(),
		'create_userID' => $this->session->userdata('loginuserID'),
		'modify_userID' => $this->session->userdata('loginuserID'),
		'parentID' => $parent
		);
      $this->db->insert('vx_aln_data_defns',$array);
	  //print_r($this->db->last_query()); exit;
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
      // print_r($this->db->last_query()); exit;  	  
	  if ($query->row('count(*)') > 0) { 
       return 0;
      } else { 
       return 1;
      }	   
  }
  
  public function addAirport($airport,$parent,$code){ 
	 $array = array(
		'aln_data_value' => $airport,
		'code' => $code,
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
  
  public function getDefns($type = null,$parent = null){
	  $this->db->select('vx_aln_data_defnsID,aln_data_typeID,aln_data_value')->from('vx_aln_data_defns'); 	 
	  if($type != null){
		$this->db->where('aln_data_typeID',$type);
	  } else {
		$this->db->where('aln_data_typeID !=',1);  
	  }
	  if($parent != null){
		$this->db->where('parentID',$parent);
	  }
	  $query = $this->db->get();
      //$this->mydebug->debug($this->db->last_query());	  
	  return $query->result();
  }

 public function getDefnsListByType($type) {

	$this->db->select('vx_aln_data_defnsID,aln_data_value')->from('vx_aln_data_defns');
	$this->db->where('aln_data_typeID',$type);
	$query = $this->db->get();
	$result = $query->result();
	$arr = array();
	foreach($result as $def ) {
		$arr[$def->vx_aln_data_defnsID] = $def->aln_data_value;
	}


		return $arr;

}


public function getDefnsCodesListByType($type) {

        $this->db->select('vx_aln_data_defnsID,code')->from('vx_aln_data_defns');
        $this->db->where('aln_data_typeID',$type);
        $query = $this->db->get();
        $result = $query->result();
        $arr = array();
        foreach($result as $def ) {
                $arr[$def->vx_aln_data_defnsID] = $def->code;
        }


                return $arr;

}


  
  public function getDefinitionList($wherein){
	  $this->db->select('aln_data_value')->from('vx_aln_data_defns');
	  $this->db->where_in('vx_aln_data_defnsID',$wherein);
	  $query = $this->db->get();
	  return $query->result();
  }
  
  
  public function get_airportmaster($id){
	  $query = $this->db->get_where('vx_aln_master_data',array('vx_amdID'=>$id))->row();
	  return $query;
  }
  
  public function delete_airport($vx_amdID,$airportID){
	  $this->db->where('vx_amdID', $vx_amdID);
      $this->db->delete('vx_aln_master_data');
	  
	  $this->db->where('vx_aln_data_defnsID', $airportID);
      $this->db->delete('vx_aln_data_defns');
	  
	  return TRUE;
  }
   
  public function getAirportData($id){
	  $this->db->select('m.*,ma.aln_data_value airport,mc.aln_data_value country,ms.aln_data_value state,mr.aln_data_value region,mar.aln_data_value area,ma.code,u.name modify_by,m.modify_date')->from('vx_aln_master_data m');
	  $this->db->join('vx_aln_data_defns ma','ma.vx_aln_data_defnsID = m.airportID','LEFT');
	  $this->db->join('vx_aln_data_defns ms','ms.vx_aln_data_defnsID = m.stateID ','LEFT');
	  $this->db->join('vx_aln_data_defns mc','mc.vx_aln_data_defnsID = m.countryID','LEFT');
	  $this->db->join('vx_aln_data_defns mr','mr.vx_aln_data_defnsID = m.regionID','LEFT');
	  $this->db->join('vx_aln_data_defns mar','mar.vx_aln_data_defnsID = m.areaID','LEFT');
	  $this->db->join('user u','u.userID = m.modify_userID','LEFT');
	  $this->db->where('m.vx_amdID',$id);
	  $query = $this->db->get();
	  return $query->row();
  }
  
  public function TotalAirports(){
	  $this->db->select('count(*) count')->from('vx_aln_master_data');
	  $query = $this->db->get();
	  return $query->row('count');
  }
  
  public function update_master_data($data,$id){
	    $this->db->where('vx_amdID',$id);
	   $this->db->update('vx_aln_master_data',$data);	       	   
	  if ($this->db->affected_rows() > 0){
	     return TRUE;
	  } else {
	     return FALSE; 
	  }
  }
  
  public function add_definition_data($data){
	  $this->db->insert('vx_aln_data_defns',$data);
	  if ($this->db->affected_rows() > 0){
	     return $this->db->insert_id();
	  } else {
	     return FALSE; 
	  }
  }
  
  public function get_definition_data($id){
	  $this->db->select('dd.*,dd1.aln_data_value parent,u.name modify_by,t.name type')->from('vx_aln_data_defns dd');
	  $this->db->join('vx_aln_data_defns dd1','dd1.vx_aln_data_defnsID = dd.parentID','LEFT');
	  $this->db->join('vx_aln_data_types t','t.vx_aln_data_typeID = dd.aln_data_typeID','LEFT');
	  $this->db->join('user u','u.userID = dd.modify_userID','LEFT');
	  $this->db->where('dd.vx_aln_data_defnsID',$id);
	  $query = $this->db->get();
	  return $query->row();
  }
  
  public function update_definition_data($data,$id){
	    $this->db->where('vx_aln_data_defnsID',$id);
	   $this->db->update('vx_aln_data_defns',$data);	       	   
	  if ($this->db->affected_rows() > 0){
	     return TRUE;
	  } else {
	     return FALSE; 
	  }
  }
  
  public function validateDefdata($where){
	  $this->db->select('count(*)')->from('vx_aln_data_defns');
	  $this->db->where($where);
	  $query = $this->db->get();
	 // $this->mydebug->debug($this->db->last_query());
	  return $query->row('count(*)');
  }
  
  public function delete_definition_data($id){
	  $this->db->where('vx_aln_data_defnsID', $id);
      $this->db->delete('vx_aln_data_defns');
	  if ($this->db->affected_rows() > 0){
	     return TRUE;
	  } else {
	     return FALSE; 
	  }
  }
  
  public function getDefdataTypes($excludetype=array(),$includetype=array()){
	 $this->db->select('*')->from('vx_aln_data_types');
	  if(!empty($excludetype)){
		  $this->db->where_not_in('vx_aln_data_typeID',$excludetype);
	  }
	  if(!empty($includetype)){
		  $this->db->where_in('vx_aln_data_typeID',$includetype);
	  } 	
	  $query = $this->db->get();	 
	  return $query->result();
  }
      
}

