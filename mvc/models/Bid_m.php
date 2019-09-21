<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bid_m extends MY_Model {
  
  function pnr_code_validate($pnr,$code){	//7k7BXu
	$this->db->select('count(*) count')->from('VX_aln_offer_ref');	 
	 $this->db->where('pnr_ref',$pnr);
	 $this->db->where('coupon_code',$code);
	 //$this->db->where('offer_status',$status);
	 $result = $this->db->get();	 
	 return $result->row('count');
  }
  
  function cabins(){
	  $this->db->select("*")->from('vx_aln_data_defns');
	  $this->db->where('aln_data_typeID','13');
  }
  

 /*  function getPassengers($pnr_ref,$bidstatus = NULL){
	  $this->db->select("tpf.cabin,tpf.pnr_ref,tpf.seat_no,cab.aln_data_value current_cabin,group_concat(distinct fclr.fclr_id) fclr,group_concat(distinct fclr.to_cabin,'-',fclr.fclr_id,'-',pfe.booking_status) to_cabins,group_concat( distinct round(fclr.min)) min,group_concat( distinct round(fclr.max)) max,group_concat( distinct round(fclr.average)) avg,group_concat( distinct round(fclr.slider_start)) slider_position,tpf.flight_number,tpf.dep_date, tpf.arrival_date,tpf.dept_time,tpf.arrival_time,car.code carrier_code,c1.aln_data_value from_city,c1.code from_city_code,c2.aln_data_value to_city,c2.code to_city_code,booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat( pax_contact_email) as email_list, group_concat(first_name,' ', last_name SEPARATOR ' ,') as pax_names,oref.miles,oref.offer_id,air_city1.aln_data_value air_from_city,air_city2.aln_data_value air_to_city,bid.bid_value,bid.miles bid_miles,bid.upgrade_type bid_upgrade")->from('VX_aln_daily_tkt_pax_feed tpf');	
      $this->db->join('VX_aln_dtpf_ext pfe','(tpf.dtpf_id = pfe.dtpf_id )','LEFT');		 
	  $this->db->join('VX_aln_fare_control_range fclr','(fclr.fclr_id = pfe.fclr_id AND fclr.from_cabin=tpf.cabin)','LEFT');	
	  $this->db->join('vx_aln_data_defns  tci','(tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns  cab','(cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13)','LEFT');
	  $this->db->join('VX_aln_offer_ref oref','oref.pnr_ref = tpf.pnr_ref','LEFT');
	  $this->db->join('vx_aln_data_defns dd','(dd.vx_aln_data_defnsID = oref.offer_status AND dd.aln_data_typeID = 20)','LEFT');	 
	  $this->db->join('vx_aln_data_defns c1','(c1.vx_aln_data_defnsID = tpf.from_city AND c1.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns c2','(c2.vx_aln_data_defnsID = tpf.to_city AND c2.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns car','(car.vx_aln_data_defnsID = tpf.carrier_code AND car.aln_data_typeID = 12)','LEFT'); 
	  $this->db->join('vx_aln_master_data m1','m1.airportID = c1.vx_aln_data_defnsID','LEFT');
	  $this->db->join('vx_aln_master_data m2','m2.airportID = c2.vx_aln_data_defnsID','LEFT');
	  $this->db->join('vx_aln_data_defns air_city1','(air_city1.vx_aln_data_defnsID = m1.cityID AND air_city1.aln_data_typeID = 3)','LEFT');
	  $this->db->join('vx_aln_data_defns air_city2','(air_city2.vx_aln_data_defnsID = m2.cityID AND air_city2.aln_data_typeID = 3)','LEFT');
	 $this->db->join('VX_aln_bid bid','(bid.offer_id = oref.offer_id AND tpf.flight_number = bid.flight_number)','LEFT');
      if(!empty($bidstatus)){
        $this->db->where('dd.alias',$bidstatus);
      } else {
	    $this->db->where('dd.alias','sent_offer_mail');
      }
	   $this->db->where("tpf.pnr_ref",$pnr_ref);	 
	    $this->db->group_by('tpf.flight_number');
	    $query = $this->db->get();  
	  return $query->result();
  } 
   */
  
   function getPassengers($pnr_ref,$bidstatus = NULL){
	  $this->db->select("tpf.carrier_code carrier,tpf.cabin,tpf.pnr_ref,tpf.seat_no,def.desc current_cabin,group_concat(distinct fclr.fclr_id) fclr,group_concat(distinct fclr.to_cabin,'-',fclr.fclr_id,'-',pfe.booking_status) to_cabins,group_concat( distinct round(fclr.min)) min,group_concat( distinct round(fclr.max)) max,group_concat( distinct round(fclr.average)) avg,group_concat( distinct round(fclr.slider_start)) slider_position,tpf.flight_number,tpf.dep_date, tpf.arrival_date,tpf.dept_time,tpf.arrival_time,car.code carrier_code,c1.aln_data_value from_city,c1.code from_city_code,c2.aln_data_value to_city,c2.code to_city_code,booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat( pax_contact_email) as email_list, group_concat(first_name,' ', last_name SEPARATOR ' ,') as pax_names,oref.miles,oref.offer_id,air_city1.aln_data_value air_from_city,air_city2.aln_data_value air_to_city,bid.bid_value,bid.miles bid_miles,bid.upgrade_type bid_upgrade")->from('VX_aln_daily_tkt_pax_feed tpf');	
      $this->db->join('VX_aln_dtpf_ext pfe','(tpf.dtpf_id = pfe.dtpf_id )','LEFT');		 
	  $this->db->join('VX_aln_fare_control_range fclr','(fclr.fclr_id = pfe.fclr_id AND fclr.from_cabin=tpf.cabin)','LEFT');	
	  $this->db->join('vx_aln_data_defns  tci','(tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)','LEFT');
	 // $this->db->join('vx_aln_data_defns  cab','(cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13)','LEFT');
	  $this->db->join('vx_aln_data_defns dcla','(dcla.aln_data_typeID = 13 and tpf.cabin = dcla.vx_aln_data_defnsID)','INNER');
	  $this->db->join('VX_aln_airline_cabin_def def','(def.carrier = tpf.carrier_code) AND (dcla.alias = def.level)','INNER');
	  $this->db->join('VX_aln_offer_ref oref','oref.pnr_ref = tpf.pnr_ref','LEFT');
	  $this->db->join('vx_aln_data_defns dd','(dd.vx_aln_data_defnsID = oref.offer_status AND dd.aln_data_typeID = 20)','LEFT');	 
	  $this->db->join('vx_aln_data_defns c1','(c1.vx_aln_data_defnsID = tpf.from_city AND c1.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns c2','(c2.vx_aln_data_defnsID = tpf.to_city AND c2.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns car','(car.vx_aln_data_defnsID = tpf.carrier_code AND car.aln_data_typeID = 12)','LEFT'); 
	  $this->db->join('vx_aln_master_data m1','m1.airportID = c1.vx_aln_data_defnsID','LEFT');
	  $this->db->join('vx_aln_master_data m2','m2.airportID = c2.vx_aln_data_defnsID','LEFT');
	  $this->db->join('vx_aln_data_defns air_city1','(air_city1.vx_aln_data_defnsID = m1.cityID AND air_city1.aln_data_typeID = 3)','LEFT');
	  $this->db->join('vx_aln_data_defns air_city2','(air_city2.vx_aln_data_defnsID = m2.cityID AND air_city2.aln_data_typeID = 3)','LEFT');
	  $this->db->join('VX_aln_bid bid','(bid.offer_id = oref.offer_id AND tpf.flight_number = bid.flight_number)','LEFT');
      if(!empty($bidstatus)){
        $this->db->where('dd.alias',$bidstatus);
      } else {
	    $this->db->where('dd.alias','sent_offer_mail');
      }
	   $this->db->where("tpf.pnr_ref",$pnr_ref);	 
	    $this->db->group_by('tpf.flight_number');
	    $query = $this->db->get();  
		//print_r($this->db->last_query()); exit;
	  return $query->result();
  }
  
  public function getPaxNames($pnr_ref){
	  $this->db->select("group_concat(first_name,' ', last_name SEPARATOR ' ,') as pax_names")->from('VX_aln_daily_tkt_pax_feed');
	  $this->db->where('pnr_ref',$pnr_ref);
	  $this->db->group_by('flight_number');
	  $query = $this->db->get();
	  return $query->row('pax_names');
  }
  
   public function get_offer_data($offer_id){
	   $this->db->select("def.desc cabin,udef.desc upgrade_type,tpf.seat_no,tpf.pnr_ref,tpf.carrier_code  carrier,tpf.dep_date,tpf.arrival_date,tpf.dept_time,tpf.arrival_time,car.code carrier_code,tpf.flight_number,c1.aln_data_value from_city,c1.code from_city_code,c2.aln_data_value to_city,c2.code to_city_code,booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(distinct pax_contact_email) as email_list, group_concat(distinct first_name,' ', last_name SEPARATOR ' ,') as pax_names,oref.cash,oref.miles")->from(' VX_aln_dtpf_ext pfe');	
	  $this->db->join('vx_aln_data_defns dd','(dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20)','LEFT');
	  $this->db->join('VX_aln_daily_tkt_pax_feed tpf','(tpf.dtpf_id = pfe.dtpf_id )','LEFT');
	  $this->db->join('VX_aln_fare_control_range fclr','(fclr.fclr_id = pfe.fclr_id AND fclr.from_cabin=tpf.cabin)','LEFT');	
	  $this->db->join('VX_aln_offer_ref oref','oref.pnr_ref = tpf.pnr_ref','LEFT');
	  $this->db->join('VX_aln_bid bid','bid.offer_id = oref.offer_id','LEFT');
	  //$this->db->join('vx_aln_data_defns upcab','upcab.vx_aln_data_defnsID = bid.upgrade_type','LEFT');
	  //$this->db->join('vx_aln_data_defns  cab','(cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13)','LEFT');
	  $this->db->join('vx_aln_data_defns dcla','(dcla.aln_data_typeID = 13 and tpf.cabin = dcla.vx_aln_data_defnsID)','INNER');
	  $this->db->join('VX_aln_airline_cabin_def def','(def.carrier = tpf.carrier_code) AND (dcla.alias = def.level)','INNER');	  
	  $this->db->join('vx_aln_data_defns udcla','(udcla.aln_data_typeID = 13 and bid.upgrade_type = udcla.vx_aln_data_defnsID)','INNER');
	  $this->db->join('VX_aln_airline_cabin_def udef','(udef.carrier = tpf.carrier_code) AND (udcla.alias = udef.level)','INNER');	  
	  $this->db->join('vx_aln_data_defns c1','(c1.vx_aln_data_defnsID = tpf.from_city AND c1.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns c2','(c2.vx_aln_data_defnsID = tpf.to_city AND c2.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns car','(car.vx_aln_data_defnsID = tpf.carrier_code AND car.aln_data_typeID = 12)','LEFT');
      $this->db->where('oref.offer_id',$offer_id);	  
	 // $this->db->where('dd.alias','sent_offer_mail');
	  $query = $this->db->get();
       $this->mydebug->debug($this->db->last_query());	  
	  return $query->row(); 
   } 
  
  public function save_bid_data($data){
	  $this->db->select('*')->from('VX_aln_bid');
	  $this->db->where('offer_id',$data['offer_id']);
	  $this->db->where('flight_number',$data['flight_number']);
	  $query = $this->db->get();
	  $bid_data = $query->row();
	  if(empty($bid_data)){
	   $this->db->insert("VX_aln_bid",$data);
	   $id = $this->db->insert_id();
	  } else {
		$this->db->where('bid_id',$bid_data->bid_id);
		$this->db->update('VX_aln_bid',$data);
        $id = $bid_data->bid_id;		
	  }
	  return $id;
  } 
  
  public function save_card_data($data){	  
	  $this->db->select('*')->from('VX_aln_card_data');
	  $this->db->where('offer_id',$data['offer_id']);	 
	  $query = $this->db->get();
	  $card_data = $query->row();
	  if(empty($card_data)){
	   $this->db->insert("VX_aln_card_data",$data);
	   $id = $this->db->insert_id();
	  } else {
		$this->db->where('card_id',$card_data->card_id);
		$this->db->update('VX_aln_card_data',$data);
        $id = $card_data->card_id;		
	  }
	  return $id;
  }


	public function getBidByOfferID($offer_id){
		$this->db->select('count(*) as count')->from('VX_aln_bid');
		$this->db->where('offer_id',$offer_id);
		$query = $this->db->get();
                return $query->row('count');

	
	}
  public function getCardData($offer_id){
	  $this->db->select("*")->from("VX_aln_card_data");
	  $this->db->where('offer_id',$offer_id);
	  $query = $this->db->get();
	  return $query->row();
  } 
  
  function bidsTotalCount(){
		$this->db->select('count(*) count')->from('VX_aln_bid');		
		$query = $this->db->get();		
		return $query->row('count');
	}
	
	function getAirlineLogoByPNR($pnr_ref){
		$this->db->select("a.*,d.aln_data_value")->from('VX_aln_airline a');
		$this->db->join('vx_aln_data_defns d','d.vx_aln_data_defnsID = a.airlineID','LEFT');
		$this->db->join('VX_aln_daily_tkt_pax_feed p','p.carrier_code = d.vx_aln_data_defnsID','LEFT');
		$this->db->where('p.pnr_ref',$pnr_ref);
		$query = $this->db->get();
		return $query->row();
	}
	
	function addFeedBack($data){
		$data['date'] = time();
		$this->db->insert('VX_aln_feedback',$data);
		return $this->db->insert_id();
	}
	
	function avgFeedback(){
		$this->db->select('sum(customer_service)/count(*) avg')->from('VX_aln_feedback');
		$query = $this->db->get();
		return $query->row('avg');
	}

    function getBidData($offer_id){
       $this->db->select('*')->from('VX_aln_bid');
       $this->db->where('offer_id',$offer_id);
       $query = $this->db->get();
       return $query->result(); 
    }

    function addBidHistory($data){
       $this->db->insert('VX_aln_bid_history',$data);
       return true;
    }
	
	function getOfferStatus($pnr_ref){
		$this->db->select('ref.offer_status status_no,d.aln_data_value status')->from('VX_aln_offer_ref ref');
		$this->db->join('vx_aln_data_defns d','(d.vx_aln_data_defnsID = ref.offer_status AND d.aln_data_typeID = 20)','LEFT');
		$this->db->where('ref.pnr_ref',$pnr_ref);
		$query = $this->db->get();
		return $query->row();
	}
	
	function get_cabins($carrier){
		$this->db->select('acd.*,def.vx_aln_data_defnsID')->from('VX_aln_airline_cabin_def acd');
		$this->db->join('VX_aln_data_defns def','(def.alias = acd.level) and aln_data_typeID = 13','INNER');
		$this->db->where('acd.carrier',$carrier);
		$query = $this->db->get();
		 $result = $query->result();
         foreach($result as $k) {
           $arr[$k->vx_aln_data_defnsID] = $k->desc;
         }
         return $arr;
	}

    public function getCarrierCabinImages($airlineID,$cabin){
		$this->db->select('i.image')->from('VX_aln_airline_cabin_map m');
		$this->db->join('VX_aln_airline_cabin_images i','i.airline_cabin_map_id = m.cabin_map_id','LEFT');
		$this->db->where('m.airline_code',$airlineID);
		$this->db->where('m.airline_cabin',$cabin);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getCarrierCabinVideos($airlineID,$cabin){
		$this->db->select('video_links')->from('VX_aln_airline_cabin_map');
		$this->db->where('airline_code',$airlineID); //2250 |           966
		$this->db->where('airline_cabin',$cabin);
		$query = $this->db->get();
		//$this->mydebug->debug($this->db->last_query());
		return $query->result();
	}
	
}

