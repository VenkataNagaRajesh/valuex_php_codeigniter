<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_issue_m extends MY_Model {

	protected $_table_name = 'VX_aln_dtpf_tracker';
	protected $_primary_key = 'dtpf_tracker_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "dtpf_tracker_id desc";

        function __construct() {
                parent::__construct();
        }

        function get_dtpf_tracker($array=NULL, $signal=FALSE) {
                $query = parent::get($array, $signal);
                return $query;
        }


        function get_single_dtpf_tracker($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }

        function insert_dtpf_tracker($array) {
		$error = parent::insert($array);
                return TRUE;

        }

	  function update_dtpf_tracker($data, $id = NULL) {
                parent::update($data, $id);
                return $id;
        }

	function getPassengerData($offerid,$flight_number) {

		$this->db->select("oref.pnr_ref,group_concat(distinct offer_id) as offer_id, group_concat(distinct first_name , ' ' , last_name)  as passengers, group_concat(distinct pax_contact_email)  as emails, group_concat(distinct pext.dtpfext_id) as p_list")->from('VX_aln_daily_tkt_pax_feed pf');
		$this->db->join('VX_aln_offer_ref oref', 'oref.pnr_ref =  pf.pnr_ref', 'LEFT');
		$this->db->join('VX_aln_dtpf_ext pext', 'pext.dtpf_id =  pf.dtpf_id', 'LEFT');
		$this->db->join(' vx_aln_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20', 'LEFT');
		$this->db->where('offer_id',$offerid); 
		$this->db->where('dd.alias','bid_complete');
		$this->db->where('pf.flight_number',$flight_number);
		$this->db->group_by('pf.pnr_ref' , 'booking_status');
		$query = $this->db->get();
                $passgr = $query->row();
		
		return $passgr;



	}
	
	function getPassengerDataByStatus($offerid,$flight_number,$status,$fclr_id,$fclr_true = 0) {
		$this->db->select("oref.pnr_ref,group_concat(distinct offer_id) as offer_id, group_concat(distinct first_name , ' ' , last_name)  as passengers, group_concat(distinct pax_contact_email)  as emails, group_concat(distinct pext.dtpfext_id) as p_list")->from('VX_aln_daily_tkt_pax_feed pf');
		$this->db->join('VX_aln_offer_ref oref', 'oref.pnr_ref =  pf.pnr_ref', 'LEFT');
		$this->db->join('VX_aln_dtpf_ext pext', 'pext.dtpf_id =  pf.dtpf_id', 'LEFT');
		$this->db->join('vx_aln_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20', 'LEFT');
		$this->db->where('offer_id',$offerid); 
		$this->db->where('dd.alias',$status);
		if($fclr_true){
		  $this->db->where('pext.fclr_id',$fclr_id);
		}else{
		  $this->db->where('pext.fclr_id !=',$fclr_id);
		}
		$this->db->where('pf.flight_number',$flight_number);
		$this->db->group_by('pf.pnr_ref' , 'booking_status');
		$query = $this->db->get();
        $passgr = $query->row();		
		return $passgr;
	}
	
	function checkForUniqueCouponCode($code) {
		$this->db->select('dtpfext_id')->from('VX_aln_dtpf_ext');
		$this->db->where('coupon_code',$code);
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();
		if($check->dtpfext_id) {
                    return false ;
                } else {
                  return true;
                }

	}


        public function delete_dtpf_tracker($id){
                parent::delete($id);
        }

	public function getEncoded($str) {
		return $this->hash($str);
        }

	
}

