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
				$arr['product_id'] = $array['product_id'];
				$arr['active'] = 1;
				$id = $this->checkOfferRefEntry($arr);
				if (!$id){
					 $id = parent::insert($array);
				}
						return $id;
		}


       function checkOfferRefEntry($array){
                $this->db->select('offer_id');
                $this->db->from('VX_offer');
                $this->db->where($array);
                $this->db->limit(1);
                $query = $this->db->get();
                $check = $query->row();
                if($check->offer_id) {
                    return $check->offer_id ;
                } else {
                  return 0;
                }
        }

	    function update_offer_ref($data, $id = NULL) {
                parent::update($data, $id);
			//echo $this->db->last_query();
                return $id;
        }



        public function delete_offer_ref($id){
                parent::delete($id);
        }

	public function getEncoded($str) {
		return $this->hash($str);
        }
		
	public function getOfferDataByRef($pnr_ref) {
		$this->db->select('ref.product_id, p.name as product_name, ref.offer_status,tpf.dep_date,tpf.carrier_code')->from('VX_daily_tkt_pax_feed tpf');
		$this->db->join('VX_offer ref','ref.pnr_ref = tpf.pnr_ref','LEFT');
		$this->db->join('VX_products p','p.productID = ref.product_id','LEFT');
		$this->db->join('VX_offer_info o','ref.product_id = o.product_id AND tpf.dtpf_id = o.dtpf_id AND o.rule_id > 0 AND (CAST(ond AS UNSIGNED) > 0 OR ond is NULL )','INNER');
        $this->db->where('ref.pnr_ref',$pnr_ref);
        $this->db->where('o.active',1);
        $this->db->where('ref.active',1);
            //$this->db->group_by('tpf.flight_number');			
				//$this->mydebug->debug($this->db->last_query());

        $query = $this->db->get();
		//		echo $this->db->last_query(); exit;
       //     return 	$query->row();		
		return $query->result();
	}
		
	function offersTotalCount(){
		$this->db->select('count(*) count')->from('VX_offer');		
		$query = $this->db->get();		
		return $query->row('count');
	}

	
}
