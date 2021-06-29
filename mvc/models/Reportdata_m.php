<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportdata_m extends MY_Model {

    function __construct() {
      parent::__construct();
      $this->load->model('rafeed_m');
    }
    
    function getReportdata($where){
       $this->db->select("*")->from('VX_reportdata');
       $this->db->where($where);
       $query = $this->db->get();       
       return $query->result();
    }

    public function get_report($airlineID,$from_date=null,$to_date,$type = 1, $product_id = 0 ){ 
      $bid_accepted =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
      $bid_rejected =  $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');       
      if($type == 2){
        $swhere = " WHERE bid.bid_submit_date <= ".strtotime($to_date);
        if($from_date){
          $swhere .= " AND bid.bid_submit_date >= ".strtotime($from_date);
        }
        $order = " ORDER BY MainSet.bid_submit_date ASC";         
      } else {
        $dwhere = " AND pf1.dep_date <= ".strtotime($to_date);
        if($from_date){
          $dwhere .= " AND pf1.dep_date >= ".strtotime($from_date);
        }
        $order = " ORDER BY SubSet.flight_date ASC"; 
      }     

	if ( $swhere ) {
		$swhere .= " AND pe.product_id = bid.productID "; 
	} else {
		$swhere .= " WHERE pe.product_id = bid.productID "; 
	}

	if ($product_id ) {
		$swhere .= "  AND pe.product_id = $product_id  ";
	}
         $swhere .= " AND pf.carrier_code = ".$airlineID;
         $dwhere .= " AND pf1.carrier_code = ".$airlineID;
        
    $query = "  select  SQL_CALC_FOUND_ROWS  
                      MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , MainSet.flight_number , 
                      SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin,
                      MainSet.to_cabin,MainSet.to_cabin_id, MainSet.bid_value  , SubSet.fqtv, MainSet.cash, MainSet.miles, MainSet.offer_status,
    SubSet.from_cabin_id, MainSet.upgrade_type, SubSet.boarding_point, SubSet.off_point, MainSet.bid_submit_date, MainSet.booking_status, SubSet.from_city_code, SubSet.to_city_code, SubSet.from_city_name, SubSet.to_city_name,MainSet.bid_avg, MainSet.rank, MainSet.bid_markup_val,SubSet.carrier_code

              FROM ( 
                              select distinct bid.bid_id, pe.dtpfext_id, pe.dtpf_id,oref.offer_id, oref.create_date as offer_date ,bid_value, bid_avg,bid_markup_val,
                              tdef.cabin as to_cabin, tcab.vx_aln_data_defnsID as to_cabin_id, oref.pnr_ref, bid.flight_number,bid.cash, bid.miles  , bid.upgrade_type,bs.aln_data_value as offer_status, bid_submit_date, pe.booking_status, rank, fcab.code as from_cabin
                              from  
                                      VX_offer oref 
                                      INNER JOIN UP_bid bid on (bid.offer_id = oref.offer_id) 
                                      INNER JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref ";
		switch ($product_id) {
			case 1;
			$query .= " and pf.flight_number = bid.flight_number ";
			break;
			case 2;
			$query .= " ";
			break;
			default:
			$query .= " ";
		}

		$query .= " ) INNER JOIN VX_airline_cabin_def tdef on (tdef.carrier = pf.carrier_code) 
                             INNER JOIN VX_offer_info pe on ( pe.dtpf_id = pf.dtpf_id  and bid.dtpfext_id = pe.dtpfext_id ) ";
       		$query .= " INNER JOIN VX_data_defns fcab on (fcab.vx_aln_data_defnsID = pf.cabin AND fcab.aln_data_typeID = 13)";
		switch ($product_id) {
			case 1:
                               $query .=  "  LEFT JOIN UP_fare_control_range fclr on (pe.rule_id = fclr.fclr_id AND fclr.to_cabin = bid.upgrade_type AND pe.product_id = 1) ";
        			$query .= " INNER JOIN VX_data_defns tcab on (tcab.vx_aln_data_defnsID = upgrade_type AND tcab.aln_data_typeID = 13 and tcab.alias = tdef.level)";
			break;
			case 2:
                               $query .= " LEFT JOIN BG_baggage_control_rule bclr on (pe.rule_id = bclr.bclr_id AND pe.product_id = 2)";
        			$query .= " INNER JOIN VX_data_defns tcab on (tcab.vx_aln_data_defnsID = pf.cabin AND tcab.aln_data_typeID = 13 and tcab.alias = tdef.level)";
			break;
		}
                          $query .= " INNER JOIN VX_data_defns bs on (bs.vx_aln_data_defnsID = pe.booking_status AND bs.aln_data_typeID = 20)
                                        ".$swhere."                                      
                                       ) as MainSet"; 
                     
                      $query .= " INNER  JOIN (
                                      select  pf1.dtpf_id, flight_number,group_concat(distinct first_name, ' ' , last_name , ' fqtv: ' , fqtv SEPARATOR '<br>'  ) as p_list ,group_concat(distinct fqtv) as fqtv,
                                              group_concat(distinct dep_date) as flight_date  ,
                                              pnr_ref,pf1.from_city as from_city_code,pf1.to_city as to_city_code,  
                                              cab.code as from_cabin  , fc.code as from_city, 
          tc.code as to_city, from_city as boarding_point , to_city as off_point, 
          fc.aln_data_value as from_city_name, tc.aln_data_value as to_city_name,
           group_concat(distinct pf1.cabin) as from_cabin_id, 
                                               car.code as carrier, pf1.carrier_code
                                      
                                      from VX_daily_tkt_pax_feed pf1 
                                      INNER JOIN VX_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                      INNER JOIN VX_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
        INNER JOIN VX_airline_cabin_def fdef on (fdef.carrier = pf1.carrier_code)
                                      INNER JOIN VX_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13 and cab.alias = fdef.level)
                                      INNER JOIN VX_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12)
                                      where ";
		switch ($product_id) {
			case 1:
		    		$query .= " pf1.is_up_offer_processed = 1 ";
			break;
			case 2:
		    		$query .= " pf1.is_bg_offer_processed = 1 ";
			break;
			default:
		    		$query .= " ( pf1.is_up_offer_processed = 1 && pf1.is_bg_offer_processed = 1 )";
		}
		  $query .= $dwhere." group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code
                 		) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref  ";
		switch ($product_id) {
			case 1:
		    		$query .= "  AND MainSet.flight_number = SubSet.flight_number ";
			break;
			case 2:
		    		$query .= "  ";
			break;
			default:
		    		$query .= " ";
		}
                 $query .= " ) WHERE SubSet.carrier_code = ".$airlineID;
                 $query .= " AND SubSet.dtpf_id = MainSet.dtpf_id AND  (MainSet.offer_status =".$bid_accepted." OR MainSet.offer_status =".$bid_rejected.")".$order;
                
         //print_r($query); echo "<br>"; echo "<br>"; exit;
          $result =   $this->db->query($query);
          return $result->result();
  }

  function checkdata($data){
     $query = $this->db->get_where('VX_reportdata',$data);
     return $query->row('dataID');
  }

  function add_reportdata($data){
      $this->db->insert('VX_reportdata',$data);
      return ($this->db->affected_rows() != 1) ? false : true;
  }

  function update_reportdata($dataID,$data){
     $this->db->where('dataID',$dataID);
     $this->db->update('VX_reportdata',$data);
     return ($this->db->affected_rows() != 1) ? false : true;
  }

}
