<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_eligibility_m extends MY_Model {

	protected $_table_name = 'UP_dtpf_ext';
	protected $_primary_key = 'dtpfext_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "dtpfext_id desc";

        function __construct() {
                parent::__construct();
        }

        function get_dtpfext($array=NULL, $signal=FALSE) {
                $query = parent::get($array, $signal);
                return $query;
        }


        function get_single_dtpfext($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }

        function insert_dtpfext($array) {
		$arr['fclr_id'] = $array['fclr_id'];
		$arr['dtpf_id'] = $array['dtpf_id'];
		//$arr['booking_status'] = $array['booking_status'];		
		if ($this->checkDTPFExtEntry($arr)){
              	  $error = parent::insert($array);
                	return TRUE;
		}
        }

	function update_dtpfext($data, $list1) {
		$this->db->where_in('dtpfext_id', $list1);
                $this->db->update('UP_dtpf_ext', $data);
        $this->mydebug->debug($this->db->last_query());
        }

	function checkDTPFExtEntry($array){
                $this->db->select('dtpfext_id');
                $this->db->from('UP_dtpf_ext');
                $this->db->where($array);
                $this->db->limit(1);
                $query = $this->db->get();
                $check = $query->row();
                if($check->dtpfext_id) {
                    return false ;
                } else {
                  return true;
                }


        }



	function checkForUniqueCouponCode($code) {
		$this->db->select('offer_id')->from('UP_offer_ref');
		$this->db->where('coupon_code',$this->hash($code));
		$this->db->limit(1);
		$query = $this->db->get();
                $check = $query->row();
		if($check->offer_id) {
                    return false ;
                } else {
                  return true;
                }

	}


        public function delete_dtpfext($id){
                parent::delete($id);
        }

	function hash($string) {
                return parent::hash($string);
        }

	
}

