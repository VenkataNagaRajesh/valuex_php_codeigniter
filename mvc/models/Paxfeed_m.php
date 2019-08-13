<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paxfeed_m extends MY_Model {

	protected $_table_name = 'VX_aln_daily_tkt_pax_feed';
	protected $_primary_key = 'dtpf_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "dtpf_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_paxfeed($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	
	function get_single_paxfeed($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}



	function checkPaxFeed($array){
		$this->db->select('dtpf_id');
		$this->db->from('VX_aln_daily_tkt_pax_feed');
		$this->db->where($array);
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();	
		if($check->dtpf_id) {
		    return false ;
		} else {
		  return true;
		}
			

	}


	function insert_paxfeed($array) {// echo "check"; exit;

		$this->db->insert('VX_aln_daily_tkt_pax_feed',$array);
                if ($this->db->affected_rows() > 0){
                             return $this->db->insert_id();
                } else {
                        return FALSE;
                }
	}



	function process_tiermarkup($pnr_list){
		foreach($pnr_list as $pnr){
			$this->db->select('tier_markup,rbd_markup')->from('VX_aln_daily_tkt_pax_feed');
			$this->db->where('pnr_ref',$pnr);
			$this->db->order_by('tier','desc');
			$this->db->order_by('rbd_markup','desc');
			$query = $this->db->get();
	                $data = $query->result();
			if(count($data) >= 2) {
				$arr = array();
				$arr['rbd_markup'] = $data[0]->rbd_markup;
				$arr['tier_markup'] = $data[0]->tier_markup;
				$this->db->where('pnr_ref',$pnr);
				$this->db->update('VX_aln_daily_tkt_pax_feed',$arr);
			}
		}


	}

	function update_paxfeed($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_paxfeed($id){
		parent::delete($id);
	}
	
}

