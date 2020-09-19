<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_issue_m extends MY_Model {

	protected $_table_name = 'UP_dtpf_tracker';
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

		$this->db->select("group_concat(distinct dep_date) as dep_date,pext.booking_status,oref.pnr_ref,group_concat(distinct offer_id) as offer_id, group_concat(first_name , ' ' , last_name)  as passengers, group_concat(distinct pax_contact_email)  as emails, group_concat(distinct pext.dtpfext_id) as p_list, carrier_code, from_city, to_city, group_concat(distinct dept_time) as dept_time, car.code as carrier_c, fc.code as from_city_name, tc.code as to_city_name,car.aln_data_value carrier_name")->from('VX_daily_tkt_pax_feed pf');
		$this->db->join('VX_offer oref', 'oref.pnr_ref =  pf.pnr_ref', 'LEFT');
		$this->db->join('VX_offer_info pext', 'pext.dtpf_id =  pf.dtpf_id', 'LEFT');
		$this->db->join(' VX_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20', 'LEFT');
		$this->db->join(' VX_data_defns car', 'car.vx_aln_data_defnsID = pf.carrier_code AND car.aln_data_typeID = 12', 'LEFT');
		$this->db->join(' VX_data_defns fc', 'fc.vx_aln_data_defnsID = pf.from_city AND fc.aln_data_typeID = 1', 'LEFT');
		$this->db->join(' VX_data_defns tc', 'tc.vx_aln_data_defnsID = pf.to_city AND tc.aln_data_typeID = 1', 'LEFT');
		$this->db->where('offer_id',$offerid); 
		$this->db->where('dd.alias','bid_received');
		$this->db->where('pf.flight_number',$flight_number);
		$this->db->group_by(array('pf.pnr_ref' , 'booking_status', 'from_city','to_city','carrier_code','carrier_c', 'from_city_name','to_city_name'));
		 $this->db->limit(1);
		$query = $this->db->get();
//var_dump($this->db->last_query());exit;
                $passgr = $query->row();
		
		return $passgr;
	}
	
	function getPassengerDataByStatus($offerid,$flight_number = null,$status,$fclr_id = null,$fclr_true = 0) {
		$this->db->select("oref.pnr_ref,group_concat(distinct offer_id) as offer_id, group_concat(distinct first_name , ' ' , last_name)  as passengers, group_concat(distinct pax_contact_email)  as emails, group_concat(distinct pext.dtpfext_id) as p_list")->from('VX_daily_tkt_pax_feed pf');
		$this->db->join('VX_offer oref', 'oref.pnr_ref =  pf.pnr_ref', 'LEFT');
		$this->db->join('VX_offer_info pext', 'pext.dtpf_id =  pf.dtpf_id', 'LEFT');
		$this->db->join('VX_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20', 'LEFT');
		$this->db->where('offer_id',$offerid); 
		$this->db->where('dd.alias',$status);
		if($fclr_id != null){
			if($fclr_true){
			  $this->db->where('pext.rule_id',$fclr_id);
			}else{
			  $this->db->where('pext.rule_id !=',$fclr_id);
			}
		}
		if($flight_number != null){
		$this->db->where('pf.flight_number',$flight_number);
		}
		$this->db->group_by('pf.pnr_ref' , 'booking_status');
		$query = $this->db->get();
		//$this->mydebug->debug($this->db->last_query());
        $passgr = $query->row();		
		return $passgr;
	}
	

	function calculateBidAvg($array){
		/*
		$this->db->select('bid_value,bid_id')->from('VX_aln_bid bid');
		$this->db->join('VX_aln_offer_ref ref', 'ref.offer_id = bid.offer_id', 'INNER');
		$this->db->join('VX_aln_daily_tkt_pax_feed pf', 'pf.pnr_ref = ref.pnr_ref AND  bid.flight_number = pf.flight_number', 'INNER');
		$this->db->join('VX_aln_dtpf_ext pext', 'pext.dtpf_id = pf.dtpf_id and bid.fclr_id = pext.fclr_id', 'INNER');
		$this->db->join('vx_aln_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status and dd.aln_data_typeID = 20', 'LEFT');
		$this->db->where('pf.carrier_code',$array['carrier_code']);
		$this->db->where('bid.flight_number',$array['flight_number']);
		$this->db->where('pf.dep_date',$array['flight_date']);
		$this->db->where('bid.upgrade_type',$array['upgrade_type']);
		$this->db->where('dd.alias','bid_received');
		$this->db->order_by('bid_value','desc');
		$this->db->order_by('bid_submit_date','asc');*/
		$query = "SELECT bid_id, round(markup_bid_avg,2) as markup_bid_avg, round(markup_bid_avg/p_cnt,2) as bid_avg_per_person, p_cnt,tier_markup, rbd_markup,  bid_submit_date, cash_percentage,bid_value FROM  (SELECT BidRef.bid_id, BidRef.bid_value,  (tier_val + ((BidRef.rbd_markup * tier_val)/100)) as markup_bid_avg,Pax.p_cnt,BidRef.tier_markup, BidRef.rbd_markup,BidRef.bid_submit_date, BidRef.cash_percentage FROM (select distinct bid_id, bid_value, (bid_value + ((pf.rbd_markup * bid_value)/100)) as tier_val, pf.pnr_ref,bid.flight_number,tier_markup, rbd_markup, bid.cash_percentage , bid.bid_submit_date  from UP_bid bid INNER JOIN VX_offer ref on (ref.offer_id = bid.offer_id) INNER JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = ref.pnr_ref and bid.flight_number = pf.flight_number) INNER JOIN VX_offer_info pext on (pext.dtpf_id = pf.dtpf_id) LEFT JOIN VX_data_defns dd on (dd.vx_aln_data_defnsID = pext.booking_status and dd.aln_data_typeID = 20 ) WHERE pf.carrier_code = ".$array['carrier_code']."  AND pf.cabin = ".$array['from_cabin']." and bid.flight_number = ".$array['flight_number']." and pf.dep_date = '".$array['flight_date']."'  and bid.upgrade_type = ".$array['upgrade_type']." and dd.alias = 'bid_received') as BidRef  INNER JOIN (select count(dtpf_id) as p_cnt,flight_number,dep_date, carrier_code, pnr_ref from VX_daily_tkt_pax_feed group by pnr_ref, flight_number,carrier_code,from_city,to_city, dep_date) as Pax on (BidRef.pnr_ref = Pax.pnr_ref  and BidRef.flight_number = Pax.flight_number) ) as MainSet
 order by bid_avg_per_person desc,tier_markup desc , rbd_markup desc,cash_percentage desc,bid_submit_date asc ";
	
   		$rResult = $this->install_m->run_query($query);

		$avg_arr = array_column($rResult,'bid_value');
		$total_psg = array_column($rResult,'p_cnt');
		$avg = array_sum($avg_arr)/array_sum($total_psg);
		$i = 1;
		foreach($rResult as $b){
			$data =array();
			$data['bid_avg'] = $avg;
			$data['bid_markup_val']  = $b->markup_bid_avg;
			$data['rank'] = $i;
			 $this->db->where('bid_id',$b->bid_id);
                         $this->db->update('UP_bid',$data);
			$i++;
		}
		

	}


	function checkForUniqueCouponCode($code) {
		$this->db->select('dtpfext_id')->from('VX_offer_info');
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

public function getBidInfoFromOfferID($offer_id, $flight_number,$carrier_code) {
	$this->db->select(' bid.*, oref.*, cdef.desc as upgrade_cabin_name')->from('UP_bid bid');
	$this->db->join('VX_offer oref', 'oref.offer_id =  bid.offer_id', 'LEFT');
	$this->db->join('VX_airline_cabin_def cdef', 'cdef.carrier = '.$carrier_code, 'INNER');
	$this->db->join('VX_data_defns dd', 'dd.vx_aln_data_defnsID = bid.upgrade_type AND dd.aln_data_typeID = 13 AND cdef.level = dd.alias', 'INNER');
	$this->db->where('bid.offer_id',$offer_id);
	$this->db->where('bid.flight_number',$flight_number);
	$this->db->limit(1);
	$query = $this->db->get();
        $check = $query->row();
	return $check;
	


}
public function getOfferDetailsById($id) {

$query = " select  SQL_CALC_FOUND_ROWS  
                        MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , MainSet.flight_number , 
                        SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin, MainSet.to_cabin_code,
                        MainSet.to_cabin, MainSet.bid_value  , SubSet.fqtv, MainSet.cash, MainSet.miles, MainSet.offer_status  , SubSet.carrier_code, MainSet.min,MainSet.max , SubSet.from_city_code, SubSet.to_city_code, MainSet.cash_percentage, MainSet.rank

                FROM ( 
                               select distinct oref.offer_id, oref.create_date as offer_date ,bid_value, rank,tdef.desc as to_cabin, upgrade_type as to_cabin_code, oref.pnr_ref, bid.flight_number,oref.cash_percentage, bid.cash, bid.miles, fclr.min, fclr.max , bs.aln_data_value as offer_status from  VX_offer oref   INNER JOIN UP_bid bid on (bid.offer_id = oref.offer_id)    INNER JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref  and pf.flight_number = bid.flight_number) INNER JOIN VX_airline_cabin_def tdef on (tdef.carrier = pf.carrier_code) INNER JOIN VX_data_defns tcab on (tcab.vx_aln_data_defnsID = upgrade_type AND tcab.aln_data_typeID = 13 AND tdef.level = tcab.alias)  INNER JOIN VX_offer_info pe on ( pe.dtpf_id = pf.dtpf_id ) INNER JOIN UP_fare_control_range fclr on (pe.rule_id = fclr.fclr_id AND fclr.to_cabin = bid.upgrade_type) LEFT JOIN VX_data_defns bs on (bs.vx_aln_data_defnsID = pe.booking_status AND bs.aln_data_typeID = 20) WHERE  oref.offer_id = ".$id."
                     ) as MainSet 

                        
                        INNER JOIN (
                                        select  flight_number,group_concat(distinct fqtv) as fqtv ,
                                                group_concat(distinct dep_date) as flight_date  ,
                                                pnr_ref,group_concat(first_name, ' ' , last_name, ':', ptc.code, ':', pax_contact_email, ':' , phone , ':' , fqtv, ':', tier SEPARATOR '<br>' ) as p_list ,  from_city as from_city_code, to_city as to_city_code,
                                                group_concat(distinct fdef.desc) as from_cabin  , fc.code as from_city, tc.code as to_city, 
                                                car.code as carrier , pf1.carrier_code
                                         from VX_daily_tkt_pax_feed pf1 
					LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18)
                                        LEFT JOIN VX_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                        LEFT JOIN VX_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
					INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier  = pf1.carrier_code )
                                        INNER JOIN VX_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13 AND fdef.level = cab.alias)
				
                                        LEFT JOIN VX_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12)
                                        where pf1.is_up_offer_processed = 1  
                                       group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code
                   ) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number)";




$rResult = $this->install_m->run_query($query);

return $rResult;

}





	function get_flight_date($offer_id,$flight_number){
		$this->db->select('dep_date,carrier_code,cabin')->from('VX_daily_tkt_pax_feed pf');
		$this->db->join('VX_offer oref', 'oref.pnr_ref =  pf.pnr_ref', 'INNER');
		$this->db->where('oref.offer_id',$offer_id);
		$this->db->where('pf.flight_number',$flight_number);
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function getProductsforOffer($id) {
		$sql = " SELECT DISTINCT oi.product_id, p.name FROM VX_offer_info oi, VX_offer o, VX_daily_tkt_pax_feed dtpf, VX_products p ";
		$sql .= " WHERE dtpf.pnr_ref = o.pnr_ref AND dtpf.dtpf_id = oi.dtpf_id AND p.productID = oi.product_id";
		$sql .= " AND o.offer_id = " . $id; 
		$rResult = $this->install_m->run_query($sql);
		$products = Array();
		foreach($rResult as $row) {
			$products[$row->product_id]  = $row->name;
		}
		return $products;
	}


	function getOfferDetails($id, $product_id) {
		
		switch($product_id) {
			case 1:

			$sql = " SELECT  SQL_CALC_FOUND_ROWS MainSet.min, MainSet.max, MainSet.average, MainSet.slider_start, MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin, MainSet.to_cabin , MainSet.cash, MainSet.miles, MainSet.booking_status, SubSet.carrier_code,  SubSet.from_city_code, SubSet.to_city_code, MainSet.cash_percentage, SubSet.flight_number FROM (  select distinct oref.offer_id, tdef.desc as to_cabin , oref.create_date as offer_date ,pf.flight_number, bs.aln_data_value as booking_status, oref.pnr_ref,oref.cash_percentage, oref.cash, oref.miles, fc.min, fc.max, fc.average, fc.slider_start from  VX_offer oref ";
			$sql .= " LEFT JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref) ";
			$sql .= " INNER JOIN VX_offer_info pext on (pext.dtpf_id = pf.dtpf_id) ";
			$sql .= " LEFT JOIN UP_fare_control_range fc on (fc.fclr_id = pext.rule_id) ";
			$sql .= " INNER JOIN  VX_airline_cabin_def tdef on (pf.carrier_code = tdef.carrier ) ";
			$sql .= " LEFT  JOIN VX_data_defns tcab on (tcab.vx_aln_data_defnsID = fc.to_cabin AND tcab.aln_data_typeID = 13 AND tcab.alias = tdef.level) ";
			$sql .= " LEFT JOIN VX_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20) ";
			$sql .= " WHERE  oref.offer_id = ".$id." AND pext.product_id = " . $product_id . " ) as MainSet  ";
			$sql .= " INNER JOIN (select  flight_number,  group_concat(distinct dep_date) as flight_date  , pnr_ref,group_concat(first_name, ' ' , last_name  ) as p_list ,  from_city as from_city_code, to_city as to_city_code, group_concat(distinct fdef.desc) as from_cabin  , fc.code as from_city, tc.code as to_city, car.code as carrier , pf1.carrier_code from VX_daily_tkt_pax_feed pf1 ";
			$sql .= " LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18) ";
			$sql .= " LEFT JOIN VX_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1) ";
			$sql .= " LEFT JOIN VX_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1) ";
			$sql .= " INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = pf1.carrier_code) ";
			$sql .= " INNER JOIN VX_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13 AND cab.alias = fdef.level) ";
			$sql .= " LEFT JOIN VX_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12) ";
			$sql .= " WHERE pf1.is_up_offer_processed = 1  ";
			$sql .= " group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number )";
			break;

			case 2:

			$sql = " SELECT  SQL_CALC_FOUND_ROWS MainSet.min_unit, MainSet.max_capacity, MainSet.min_price, MainSet.max_price, MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin, MainSet.cash, MainSet.miles, MainSet.booking_status, SubSet.carrier_code,  SubSet.from_city_code, SubSet.to_city_code, MainSet.cash_percentage, SubSet.flight_number FROM (  select distinct oref.offer_id, oref.create_date as offer_date ,pf.flight_number, bs.aln_data_value as booking_status, oref.pnr_ref,oref.cash_percentage, oref.cash, oref.miles, bc.min_unit, bc.max_capacity, bc.min_price, bc.max_price from  VX_offer oref ";
			$sql .= " LEFT JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref) ";
			$sql .= " INNER JOIN VX_offer_info pext on (pext.dtpf_id = pf.dtpf_id) ";
			$sql .= " LEFT JOIN BG_baggage_control_rule bc on (bc.bclr_id = pext.rule_id) ";
			$sql .= " LEFT JOIN VX_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20) ";
			$sql .= " WHERE  oref.offer_id = ".$id." AND pext.product_id = " . $product_id . " ) as MainSet  ";
			$sql .= " INNER JOIN (select  flight_number,  group_concat(distinct dep_date) as flight_date  , pnr_ref,group_concat(first_name, ' ' , last_name  ) as p_list ,  from_city as from_city_code, to_city as to_city_code, group_concat(distinct fdef.desc) as from_cabin  , fc.code as from_city, tc.code as to_city, car.code as carrier , pf1.carrier_code from VX_daily_tkt_pax_feed pf1 ";
			$sql .= " LEFT JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18) ";
			$sql .= " LEFT JOIN VX_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1) ";
			$sql .= " LEFT JOIN VX_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1) ";
			$sql .= " INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = pf1.carrier_code) ";
			$sql .= " INNER JOIN VX_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13 AND cab.alias = fdef.level) ";
			$sql .= " LEFT JOIN VX_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12) ";
			$sql .= " WHERE pf1.is_bg_offer_processed = 1  ";
			$sql .= " group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number )";
			break;
		}

//echo "<br><br>$sql";

		$rResult = $this->install_m->run_query($sql);

		return $rResult;
	}


        public function delete_dtpf_tracker($id){
                parent::delete($id);
        }

	public function getEncoded($str) {
		return $this->hash($str);
        }

	function getBaggageOffer($pnr_ref) {

		$this->db->select("pext.ond, pext.rule_id, pf.*, fc.aln_data_value as from_airport, tc.aln_data_value as to_airport, fc.code as from_city_code, tc.code as to_city_code, car.aln_data_value carrier_name, c1.aln_data_value as from_city, c2.aln_data_value as to_city")->from('VX_daily_tkt_pax_feed pf');
		$this->db->join('VX_offer oref', 'oref.pnr_ref =  pf.pnr_ref', 'LEFT');
		$this->db->join('VX_offer_info pext', 'pext.dtpf_id =  pf.dtpf_id AND pext.rule_id > 0', 'LEFT');
		$this->db->join(' VX_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20', 'LEFT');
		$this->db->join(' VX_data_defns car', 'car.vx_aln_data_defnsID = pf.carrier_code AND car.aln_data_typeID = 12', 'LEFT');
		$this->db->join(' VX_data_defns fc', 'fc.vx_aln_data_defnsID = pf.from_city AND fc.aln_data_typeID = 1', 'LEFT');
		$this->db->join(' VX_data_defns tc', 'tc.vx_aln_data_defnsID = pf.to_city AND tc.aln_data_typeID = 1', 'LEFT');
		  $this->db->join('VX_data_defns c1','(c1.vx_aln_data_defnsID = fc.parentID AND c1.aln_data_typeID = 3)','LEFT');
		  $this->db->join('VX_data_defns c2','(c2.vx_aln_data_defnsID = tc.parentID AND c2.aln_data_typeID = 3)','LEFT');
		$this->db->where('oref.pnr_ref',$pnr_ref); 
		$this->db->where('pext.product_id',2);  //BAGGAGE
		$this->db->order_by('pext.ond ASC'); 
		#$this->db->where('dd.alias','bid_received');
		#$this->db->group_by(array('pf.pnr_ref' , 'booking_status', 'from_city','to_city','carrier_code','carrier_c', 'from_city_name','to_city_name'));
		$query = $this->db->get();
		#var_dump($this->db->last_query());exit;
                return $query->result();
	}

	
}

