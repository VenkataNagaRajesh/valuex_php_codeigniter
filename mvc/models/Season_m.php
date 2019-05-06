<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class season_m extends MY_Model {

	protected $_table_name = 'VX_aln_season';
	protected $_primary_key = 'VX_aln_seasonID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "VX_aln_seasonID desc";

	function __construct() {
		parent::__construct();
	}

	function get_seasons($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function getSeasons_for_triggerrun($timestamp) {
		$sql = "SELECT * FROM VX_aln_season WHERE modify_date >= ".$timestamp;
		$seasons = $this->install_m->run_query($sql);
        return $seasons;
	}
	
	function getMarketSeasons_for_triggerrun() {
		$sql = "SELECT * FROM VX_aln_season WHERE ( ams_orig_levelID = 17 OR ams_dest_levelID = 17)";
		$seasons = $this->install_m->run_query($sql);
        return $seasons;
	}

	function get_single_season($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_season($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function update_season($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_season($id){
		parent::delete($id);
	}
	
	public function searchAirlineCode($string){
		$query = "SELECT CONCAT(`code`, '_', `aln_data_value`) search from vx_aln_data_defns where aln_data_typeID = 12 AND CONCAT(`code`, '_', `aln_data_value`) like '%".$string."%' limit 5";
		/* $this->db->select("CONCAT(`aln_data_value`, '_', `code`) search")->from('vx_aln_data_defns');
		$this->db->where('aln_data_typeID',12);
		$this->db->like("CONCAT(aln_data_value, '_', code)",$string);
		$query = $this->db->get(); */
		$query = $this->db->query($query);
		//print_r($this->db->last_query()); 
		
		return $query->result();
	}
}

