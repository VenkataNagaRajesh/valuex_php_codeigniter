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

		$this->db->select("group_concat(distinct dep_date) as dep_date,oref.pnr_ref,group_concat(distinct offer_id) as offer_id, group_concat(distinct first_name , ' ' , last_name)  as passengers, group_concat(distinct pax_contact_email)  as emails, group_concat(distinct pext.dtpfext_id) as p_list, carrier_code, from_city, to_city, group_concat(distinct dept_time) as dept_time, car.code as carrier_c, fc.code as from_city_name, tc.code as to_city_name")->from('VX_aln_daily_tkt_pax_feed pf');
		$this->db->join('VX_aln_offer_ref oref', 'oref.pnr_ref =  pf.pnr_ref', 'LEFT');
		$this->db->join('VX_aln_dtpf_ext pext', 'pext.dtpf_id =  pf.dtpf_id', 'LEFT');
		$this->db->join(' vx_aln_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20', 'LEFT');
		$this->db->join(' vx_aln_data_defns car', 'car.vx_aln_data_defnsID = pf.carrier_code AND car.aln_data_typeID = 12', 'LEFT');
		$this->db->join(' vx_aln_data_defns fc', 'fc.vx_aln_data_defnsID = pf.from_city AND fc.aln_data_typeID = 1', 'LEFT');
		$this->db->join(' vx_aln_data_defns tc', 'tc.vx_aln_data_defnsID = pf.to_city AND tc.aln_data_typeID = 1', 'LEFT');
		$this->db->where('offer_id',$offerid); 
		$this->db->where('dd.alias','bid_received');
		$this->db->where('pf.flight_number',$flight_number);
		$this->db->group_by(array('pf.pnr_ref' , 'booking_status', 'from_city','to_city','carrier_code','carrier_c', 'from_city_name','to_city_name'));
		$query = $this->db->get();
//var_dump($this->db->last_query());exit;
                $passgr = $query->row();
		
		return $passgr;



	}
	
	function getPassengerDataByStatus($offerid,$flight_number,$status,$fclr_id = null,$fclr_true = 0) {
		$this->db->select("oref.pnr_ref,group_concat(distinct offer_id) as offer_id, group_concat(distinct first_name , ' ' , last_name)  as passengers, group_concat(distinct pax_contact_email)  as emails, group_concat(distinct pext.dtpfext_id) as p_list")->from('VX_aln_daily_tkt_pax_feed pf');
		$this->db->join('VX_aln_offer_ref oref', 'oref.pnr_ref =  pf.pnr_ref', 'LEFT');
		$this->db->join('VX_aln_dtpf_ext pext', 'pext.dtpf_id =  pf.dtpf_id', 'LEFT');
		$this->db->join('vx_aln_data_defns dd', 'dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20', 'LEFT');
		$this->db->where('offer_id',$offerid); 
		$this->db->where('dd.alias',$status);
		if($fclr_id != null){
			if($fclr_true){
			  $this->db->where('pext.fclr_id',$fclr_id);
			}else{
			  $this->db->where('pext.fclr_id !=',$fclr_id);
			}
		}
		$this->db->where('pf.flight_number',$flight_number);
		$this->db->group_by('pf.pnr_ref' , 'booking_status');
		$query = $this->db->get();
        $passgr = $query->row();		
		return $passgr;
	}
	

	function calculateBidAvg($array){

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
		$this->db->order_by('bid_submit_date','asc');

		$query = $this->db->get();
                 $rResult = $query->result();

		//$query = " SELECT bid_value,bid_id from VX_aln_bid bid  INNER JOIN VX_aln_offer_ref ref on (ref.offer_id = bid.offer_id) INNER JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = ref.pnr_ref AND bid.flight_number = pf.flight_number) INNER JOIN VX_aln_dtpf_ext pext on (pext.dtpf_id = pf.dtpf_id and bid.fclr_id = pext.fclr_id) LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pext.booking_status) where dd.alias = 'bid_complete' AND  pf.carrier_code = ".$array['carrier_code']." AND bid.flight_number = ".$array['flight_number']." AND pf.dep_date = ".$array['flight_date']." AND bid.upgrade_type = ".$array['upgrade_type']. "  order by bid_value desc,bid_submit_date asc";
		$avg_arr = array_column($rResult,'bid_value');
		$avg = array_sum($avg_arr)/count($avg_arr);
		$i = 1;
		foreach($rResult as $b){
			$data =array();
			$data['bid_avg'] = $avg;
			$data['rank'] = $i;
			 $this->db->where('bid_id',$b->bid_id);
                         $this->db->update('VX_aln_bid',$data);
			$i++;
		}
		

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

public function getBidInfoFromOfferID($offer_id, $flight_number) {
	$this->db->select(' bid.*, oref.*, dd.aln_data_value as upgrade_cabin_name')->from('VX_aln_bid bid');
	 $this->db->join('VX_aln_offer_ref oref', 'oref.offer_id =  bid.offer_id', 'LEFT');
	$this->db->join('vx_aln_data_defns dd', 'dd.vx_aln_data_defnsID = bid.upgrade_type AND dd.aln_data_typeID = 13', 'LEFT');
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
                               select distinct oref.offer_id, oref.create_date as offer_date ,bid_value, rank,tcab.aln_data_value as to_cabin, upgrade_type as to_cabin_code, oref.pnr_ref, bid.flight_number,oref.cash_percentage, bid.cash, bid.miles, fclr.min, fclr.max , bs.aln_data_value as offer_status from  VX_aln_offer_ref oref   INNER JOIN VX_aln_bid bid on (bid.offer_id = oref.offer_id)   LEFT JOIN vx_aln_data_defns tcab on (tcab.vx_aln_data_defnsID = upgrade_type AND tcab.aln_data_typeID = 13)  INNER JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref  and pf.flight_number = bid.flight_number) INNER JOIN VX_aln_dtpf_ext pe on ( pe.dtpf_id = pf.dtpf_id ) INNER JOIN VX_aln_fare_control_range fclr on (pe.fclr_id = fclr.fclr_id AND fclr.to_cabin = bid.upgrade_type) LEFT JOIN vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pe.booking_status AND bs.aln_data_typeID = 20) WHERE  oref.offer_id = ".$id."
                     ) as MainSet 

                        
                        INNER JOIN (
                                        select  flight_number,group_concat(distinct fqtv) as fqtv ,
                                                group_concat(distinct dep_date) as flight_date  ,
                                                pnr_ref,group_concat(first_name, ' ' , last_name, ':', ptc.code, ':', pax_contact_email, ':' , phone , ':' , fqtv, ':', tier SEPARATOR '<br>' ) as p_list ,  from_city as from_city_code, to_city as to_city_code,
                                                group_concat(distinct cab.aln_data_value) as from_cabin  , fc.code as from_city, tc.code as to_city, 
                                                car.code as carrier , pf1.carrier_code
                                         from VX_aln_daily_tkt_pax_feed pf1 
					LEFT JOIN vx_aln_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18)
                                        LEFT JOIN vx_aln_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                        LEFT JOIN vx_aln_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
                                        LEFT JOIN vx_aln_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13)
                                        LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12)
                                        where pf1.is_processed = 1  
                                       group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code
                   ) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number)";




$rResult = $this->install_m->run_query($query);

return $rResult;

}





function get_flight_date($offer_id,$flight_number){
	$this->db->select('dep_date,carrier_code')->from('VX_aln_daily_tkt_pax_feed pf');
	$this->db->join('VX_aln_offer_ref oref', 'oref.pnr_ref =  pf.pnr_ref', 'INNER');
	$this->db->where('oref.offer_id',$offer_id);
	$this->db->where('pf.flight_number',$flight_number);
	$this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();
	return $result;
}


	function getOfferDetailsForIssue($id) {
/*
$sql = "
		select car.code as carrier_code ,pf.pnr_ref, pf.dep_date as flight_date ,df.code as from_city , dt.code as to_city , oref.offer_id, flight_number,group_concat(first_name,' ' , last_name) as p_list,  bs.aln_data_value as booking_status    from VX_aln_offer_ref oref LEFT JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref) LEFT JOIN VX_aln_dtpf_ext pext on (pext.dtpf_id = pf.dtpf_id)  LEFT JOIN  vx_aln_data_defns df on(df.vx_aln_data_defnsID = pf.from_city and df.aln_data_typeID = 1 )  LEFT JOIN  vx_aln_data_defns dt on(dt.vx_aln_data_defnsID = pf.to_city and dt.aln_data_typeID = 1 )  LEFT JOIN  vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status and bs.aln_data_typeID = 20 )  LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID = pf.carrier_code  and car.aln_data_typeID = 12 ) where pf.is_processed = 1 and bs.alias != 'excl' AND oref.offer_id=".$id." group by pf.pnr_ref, pf.from_city, pf.to_city, pf.carrier_code ,pf.flight_number, pf.dep_date ,oref.offer_id, pext.booking_status" ;

*/



$sql = " select  SQL_CALC_FOUND_ROWS MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin, MainSet.to_cabin , MainSet.cash, MainSet.miles, MainSet.booking_status, SubSet.carrier_code,  SubSet.from_city_code, SubSet.to_city_code, MainSet.cash_percentage, SubSet.flight_number FROM (  select distinct oref.offer_id, tcab.aln_data_value as to_cabin , oref.create_date as offer_date ,pf.flight_number, bs.aln_data_value as booking_status, oref.pnr_ref,oref.cash_percentage, oref.cash, oref.miles from  VX_aln_offer_ref oref  LEFT JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref) INNER JOIN VX_aln_dtpf_ext pext on (pext.dtpf_id = pf.dtpf_id) LEFT JOIN VX_aln_fare_control_range fc on (fc.fclr_id = pext.fclr_id) LEFT JOIN vx_aln_data_defns tcab on (tcab.vx_aln_data_defnsID = fc.to_cabin AND tcab.aln_data_typeID = 13)  LEFT JOIN vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20)     WHERE  oref.offer_id = ".$id.") as MainSet     INNER JOIN (select  flight_number,  group_concat(distinct dep_date) as flight_date  , pnr_ref,group_concat(first_name, ' ' , last_name  ) as p_list ,  from_city as from_city_code, to_city as to_city_code, group_concat(distinct cab.aln_data_value) as from_cabin  , fc.code as from_city, tc.code as to_city, car.code as carrier , pf1.carrier_code from VX_aln_daily_tkt_pax_feed pf1  LEFT JOIN vx_aln_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18) LEFT JOIN vx_aln_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1) LEFT JOIN vx_aln_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1) LEFT JOIN vx_aln_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13) LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12) where pf1.is_processed = 1  group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number )";


	$rResult = $this->install_m->run_query($sql);

	return $rResult;


	}


        public function delete_dtpf_tracker($id){
                parent::delete($id);
        }

	public function getEncoded($str) {
		return $this->hash($str);
        }

	
}

