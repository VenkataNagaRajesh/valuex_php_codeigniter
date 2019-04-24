<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season_airport_map_m extends MY_Model {

	function checkOrigMappingdata($id){
	  $this->db->select('count(*)')->from('VX_season_airport_origin_map');
      $this->db->where('seasonID',$id);
       $query = $this->db->get();
       if ($query->row('count(*)') > 0) {
        return 0;
       } else {
       	return 1;
       }
	}

    function checkDestMappingdata($id){
	  $this->db->select('count(*)')->from('VX_season_airport_dest_map');
      $this->db->where('seasonID',$id);
       $query = $this->db->get();
       if ($query->row('count(*)') > 0) {
        return 0;
       } else {
       	return 1;
       }
	}

    /* function remove_old_dest_entriesbyid($seasonID,$list){
		$query = "DELETE FROM VX_season_airport_dest_map WHERE seasonID = ".$seasonID." AND dest_airportID IN (".implode(',',$list).")";
		$this->db->query($query);
        return true;
	}

    function remove_old_orig_entriesbyid($seasonID,$list){
		$query = "DELETE FROM VX_season_airport_origin_map WHERE seasonID = ".$seasonID." AND orig_airportID IN (".implode(',',$list).")";
		$this->mydebug->debug($query);
		$this->db->query($query); 
        return true;
	} */

    function delete_old_orig_entries($seasonID){
		$this->db->where('seasonID',$seasonID);
		$this->db->delete('VX_season_airport_origin_map');
		return;
	}

    function delete_old_dest_entries($seasonID){
		$this->db->where('seasonID',$seasonID);
		$this->db->delete('VX_season_airport_dest_map');
		return;
	}	
	
	function get_orig_season_airport_mapdata($seasonID) {
		$this->db->select('orig_airportID')->from('VX_season_airport_origin_map');
		$this->db->where('seasonID',$seasonID);
		$query = $this->db->get();
		$result = $query->result();
		return array_column($result,'orig_airportID');		
	}
	
	function get_dest_season_airport_mapdata($seasonID) {
		$this->db->select('dest_airportID')->from('VX_season_airport_dest_map');
		$this->db->where('seasonID',$seasonID);
		$query = $this->db->get();
		$result = $query->result();
		return array_column($result,'dest_airportID');		
	}
	
	function insert_origseason_airport_mapid($array) {
		$this->db->insert('VX_season_airport_origin_map',$array);
		return TRUE;
	}
	
	function insert_destseason_airport_mapid($array) {
		$this->db->insert('VX_season_airport_dest_map',$array);
		return TRUE;
	}
}