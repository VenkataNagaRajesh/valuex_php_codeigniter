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

        function insert_dtpfext_fclr($array) {
		$arr['fclr_id'] = $array['fclr_id'];
		$arr['dtpf_id'] = $array['dtpf_id'];
		//$arr['booking_status'] = $array['booking_status'];		
		if ($this->checkDTPFExtEntry($arr)){
              	  $error = parent::insert($array);
                	return TRUE;
		}
        }

        function insert_dtpfext_bclr($array) {
		$arr['bclr_id'] = $array['bclr_id'];
		$arr['dtpf_id'] = $array['dtpf_id'];
		//$arr['booking_status'] = $array['booking_status'];		
		$ret = $this->checkDTPFExtEntry($arr);
		if (!$ret){
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
                    return TRUE ;
                } else {
                  return FALSE;
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

	function getBaggagePaxData($carrierId, $timestamp) {
		$sQuery = "SELECT carrier_code, pnr_ref, first_name, last_name FROM ";
		$sQuery .= " (SELECT DISTINCT dtpf.carrier_code, dtpf.pnr_ref, dtpf.first_name,dtpf.last_name FROM `VX_daily_tkt_pax_feed` `dtpf` ";
		$sQuery .= " LEFT JOIN `VX_data_defns` `dd` ON `dtpf`.`ptc` = `dd`.`vx_aln_data_defnsID` AND `aln_data_typeID` = 18 ";
		$sQuery .= " LEFT JOIN `VX_airline_cabin_class` `cc` ON `dtpf`.`carrier_code` = `cc`.`carrier` AND `dtpf`.`class` = `cc`.`airline_class` ";
		$sQuery .= " WHERE `is_bg_offer_processed` =0 AND `dd`.`code` = 'ADT' ";
		$sQuery .= " AND `dd`.`code` != 'UNN' AND `cc`.`is_revenue` = 1 ";
		$sQuery .= " AND `dtpf`.`carrier_code` = $carrierId"; 
		$sQuery .= " AND `dep_date` > $timestamp ORDER BY `pnr_ref`) t1 GROUP BY pnr_ref";
		$result = $this->install_m->run_query($sQuery);
		//print_r($this->db->last_query());
                return  $result;
	}

	function getBaggageSingleAdultPax($pax_pnr_single) {
		$sQuery = "SELECT *, ddcu.parentID as from_country, dddcu.parentID as to_country FROM  VX_daily_tkt_pax_feed dtpf ";
		$sQuery .= " LEFT JOIN `VX_data_defns` `dd` ON (`dtpf`.`ptc` = `dd`.`vx_aln_data_defnsID` AND `dd`.`aln_data_typeID` = 18) ";
		$sQuery .= " LEFT JOIN `VX_airline_cabin_class` `cc` ON (`dtpf`.`carrier_code` = `cc`.`carrier` AND `dtpf`.`class` = `cc`.`airline_class`) ";
		$sQuery .= " LEFT JOIN `VX_data_defns` `ddoc` ON (`dtpf`.`from_city` = `ddoc`.`vx_aln_data_defnsID`) ";
		$sQuery .= " LEFT JOIN `VX_data_defns` `ddcu` ON (`ddoc`.`parentID` = `ddcu`.`vx_aln_data_defnsID` ) ";
		$sQuery .= " LEFT JOIN `VX_data_defns` `dddc` ON (`dtpf`.`to_city` = `dddc`.`vx_aln_data_defnsID` ) ";
		$sQuery .= " LEFT JOIN `VX_data_defns` `dddcu` ON (`dddc`.`parentID` = `dddcu`.`vx_aln_data_defnsID`) ";
		$sQuery .= " WHERE `is_bg_offer_processed` =0 AND `dd`.`code` = 'ADT' ";
		$sQuery .= " AND `dd`.`code` != 'UNN' AND `cc`.`is_revenue` = 1 ";
		$sQuery .= " AND `dtpf`.`carrier_code` = " . $pax_pnr_single->carrier_code; 
		$sQuery .= " AND `pnr_ref` = '" .  $pax_pnr_single->pnr_ref . "'";
		$sQuery .= " AND `first_name` = '" .  $pax_pnr_single->first_name . "'";
		$sQuery .= " AND `last_name` = '" .  $pax_pnr_single->last_name . "'";
		print_r($sQuery);
		$result = $this->install_m->run_query($sQuery);
	//	print_r($this->db->last_query());
                return  $result;
	}

}

