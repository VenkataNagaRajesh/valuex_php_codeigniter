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
}

