<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_reference_m extends MY_Model {

	protected $_table_name = 'VX_offer';
	protected $_primary_key = 'offer_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "offer_id desc";

        function __construct() {
                parent::__construct();
        }

        function get_offer_ref($array=NULL, $signal=FALSE) {
                $query = parent::get($array, $signal);
                return $query;
        }


        function get_single_offer_ref($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }



        function insert_offer_ref($array) {
		$arr['pnr_ref'] = $array['pnr_ref'];
		if ($this->checkOfferRefEntry($arr)){
                  $error = parent::insert($array);
                        return TRUE;
                }

        }


       function checkOfferRefEntry($array){
                $this->db->select('offer_id');
                $this->db->from('VX_offer');
                $this->db->where($array);
                $this->db->limit(1);
                $query = $this->db->get();
                $check = $query->row();
                if($check->offer_id) {
                    return false ;
                } else {
                  return true;
                }
        }

	    function update_offer_ref($data, $id = NULL) {
                parent::update($data, $id);
			//	$this->mydebug->debug($this->db->last_query());
                return $id;
        }



        public function delete_offer_ref($id){
                parent::delete($id);
        }

	public function getEncoded($str) {
		return $this->hash($str);
        }
		
	public function getOfferDataByRef($pnr_ref) {
		$this->db->select('ref.offer_status,MIN(tpf.dep_date) dep_date,tpf.carrier_code')->from('VX_daily_tkt_pax_feed tpf');
		$this->db->join('VX_offer ref','ref.pnr_ref = tpf.pnr_ref','LEFT');
            	$this->db->where('ref.pnr_ref',$pnr_ref);
            //$this->db->group_by('tpf.flight_number');			
				//$this->mydebug->debug($this->db->last_query());

            $query = $this->db->get();
            return 	$query->row();		
	}
		
	function offersTotalCount(){
		$this->db->select('count(*) count')->from('VX_offer');		
		$query = $this->db->get();		
		return $query->row('count');
	}

	
}
