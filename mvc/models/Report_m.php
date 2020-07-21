<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_m extends MY_Model {

    function __construct() {
           parent::__construct();               
	}

    public function get_report($airlineID,$from_date,$to_date,$type = 1,$bid_accepted,$bid_rejected){ 
       
        if($type == 2){
          $swhere = " WHERE bid.bid_submit_date >= ".strtotime($from_date)." AND bid.bid_submit_date <= ".strtotime($to_date);         
        } else {
          $dwhere = " AND pf1.dep_date >= ".strtotime($from_date)." AND pf1.dep_date <= ".strtotime($to_date);
        }
          
      $query = "  select  SQL_CALC_FOUND_ROWS  
                        MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , MainSet.flight_number , 
                        SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin,
                        MainSet.to_cabin, MainSet.bid_value  , SubSet.fqtv, MainSet.cash, MainSet.miles, MainSet.offer_status,
			SubSet.from_cabin_id, MainSet.upgrade_type, SubSet.boarding_point, SubSet.off_point, MainSet.bid_submit_date, MainSet.booking_status, SubSet.from_city_code, SubSet.to_city_code,SubSet.from_city_name, SubSet.to_city_name,MainSet.bid_avg, MainSet.rank, MainSet.bid_markup_val,SubSet.carrier_code

                FROM ( 
                                select distinct oref.offer_id, oref.create_date as offer_date ,bid_value, bid_avg,bid_markup_val,
                                tdef.cabin as to_cabin, oref.pnr_ref, bid.flight_number,bid.cash, bid.miles  , bid.upgrade_type,bs.aln_data_value as offer_status, bid_submit_date, pe.booking_status, rank
                                from  
                                        VX_offer oref 
                                        INNER JOIN UP_bid bid on (bid.offer_id = oref.offer_id) 
                                        INNER JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref 
                                                        and pf.flight_number = bid.flight_number) 

					INNER JOIN VX_airline_cabin_def tdef on (tdef.carrier = pf.carrier_code) 
					INNER JOIN VX_data_defns tcab on (tcab.vx_aln_data_defnsID = upgrade_type AND tcab.aln_data_typeID = 13 and tcab.alias = tdef.level)
                                        INNER JOIN VX_offer_info pe on ( pe.dtpf_id = pf.dtpf_id ) 
                                         INNER JOIN UP_fare_control_range fclr on (pe.rule_id = fclr.fclr_id AND fclr.to_cabin = bid.upgrade_type)
                                          LEFT JOIN VX_data_defns bs on (bs.vx_aln_data_defnsID = pe.booking_status AND bs.aln_data_typeID = 20)
                                          ".$swhere.") as MainSet"; 
                       
                        $query .= " INNER  JOIN (
                                        select  flight_number,group_concat(distinct first_name, ' ' , last_name , ' fqtv: ' , fqtv SEPARATOR '<br>'  ) as p_list ,group_concat(distinct fqtv) as fqtv,
                                                group_concat(distinct dep_date) as flight_date  ,
                                                pnr_ref,pf1.from_city as from_city_code,pf1.to_city as to_city_code, 
                                                group_concat(distinct fdef.cabin) as from_cabin  , fc.code as from_city, 
						tc.code as to_city, from_city as boarding_point , to_city as off_point, 
						fc.aln_data_value as from_city_name, tc.aln_data_value as to_city_name,
						 group_concat(distinct pf1.cabin) as from_cabin_id, 
                                                 car.code as carrier, pf1.carrier_code
                                        
                                        from VX_daily_tkt_pax_feed pf1 
                                        LEFT JOIN VX_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                        LEFT JOIN VX_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
					INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = pf1.carrier_code)
                                        INNER JOIN VX_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13 and cab.alias = fdef.level)
                                        LEFT JOIN VX_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12)
                                        where pf1.is_up_offer_processed = 1 ".$dwhere." group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code
                   ) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number ) ";
                   $query .= " WHERE SubSet.carrier_code = ".$airlineID;
                   $query .= " AND (MainSet.booking_status =".$bid_accepted." OR MainSet.booking_status =".$bid_rejected.")";
             //print_r($query)     ; exit;
            $result =   $this->db->query($query);
            return $result->result();
    }

    public function getAirlineCabins($airlineID){
        $this->db->select('cm.*,dd.vx_aln_data_defnsID')->from('VX_airline_cabin_def cm');
        $this->db->join(' VX_data_defns dd','(dd.alias = cm.level and dd.aln_data_typeID = 13)','INNER');
        $this->db->where('carrier',$airlineID);
        $this->db->order_by('cm.level','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPaxCarriers(){
        $this->db->select("car.*")->from('VX_daily_tkt_pax_feed pax');
        $this->db->join("VX_data_defns car","(car.vx_aln_data_defnsID = pax.carrier_code AND car.aln_data_typeID = 12)","INNER");
        $this->db->group_by('car.vx_aln_data_defnsID');
        $query = $this->db->get();
        return $query->result();
    }

}
