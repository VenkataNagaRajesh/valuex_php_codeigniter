<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_m extends MY_Model {
  
  function pnr_code_validate($pnr,$code){	//7k7BXu
	$this->db->select('count(*) count')->from('VX_aln_offer_ref');	 
	 $this->db->where('pnr_ref',$pnr);
	 $this->db->where('coupon_code',$code);
	 $result = $this->db->get();	 
	 return $result->row('count');
  }
  
  function cabins(){
	  $this->db->select("*")->from('vx_aln_data_defns');
	  $this->db->where('aln_data_typeID','13');
  }
  
   function getPassengers(){
	 $this->db->select("tpf.cabin,tpf.pnr_ref,group_concat(distinct fclr.fclr_id) fclr,group_concat(distinct fclr.to_cabin,'-',fclr.fclr_id) to_cabins,group_concat( distinct round(fclr.min)) min,group_concat( distinct round(fclr.max)) max,group_concat( distinct round(fclr.average)) avg,tpf.flight_number,tpf.dep_date, tpf.arrival_date,tpf.dept_time,tpf.arrival_time,car.code carrier_code,c1.aln_data_value from_city,c2.aln_data_value to_city,booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(distinct pax_contact_email) as email_list, group_concat(distinct first_name,' ', last_name SEPARATOR ' ,') as pax_names,oref.miles,oref.offer_id")->from(' VX_aln_dtpf_ext pfe');	

//$this->db->select("tpf.cabin,tpf.pnr_ref,group_concat(distinct fclr.to_cabin) to_cabins,group_concat( distinct fclr.min) min,group_concat( distinct fclr.max) max,fclr.average avg,tpf.flight_number,tpf.dep_date,booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(pax_contact_email) as email_list, group_concat(distinct first_name,' ', last_name SEPARATOR ' ,') as pax_names")->from(' VX_aln_dtpf_ext pfe');		 
	  $this->db->join('vx_aln_data_defns dd','(dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20)','LEFT');
	  $this->db->join('VX_aln_daily_tkt_pax_feed tpf','(tpf.dtpf_id = pfe.dtpf_id )','LEFT');
	  $this->db->join('VX_aln_fare_control_range fclr','(fclr.fclr_id = pfe.fclr_id AND fclr.from_cabin=tpf.cabin)','LEFT');	  
		
	  $this->db->join('vx_aln_data_defns fci','(fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns  tci','(tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns  cab','(cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13)','LEFT');
	  $this->db->join('VX_aln_offer_ref oref','oref.pnr_ref = tpf.pnr_ref','LEFT');
	 // $this->db->join('vx_aln_data_defns fl','(fl.vx_aln_data_defnsID = tpf.flight_number AND fl.aln_data_typeID = 16)','LEFT');
	  $this->db->join('vx_aln_data_defns c1','(c1.vx_aln_data_defnsID = tpf.from_city AND c1.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns c2','(c2.vx_aln_data_defnsID = tpf.to_city AND c2.aln_data_typeID = 1)','LEFT');
	  $this->db->join('vx_aln_data_defns car','(car.vx_aln_data_defnsID = tpf.carrier_code AND car.aln_data_typeID = 12)','LEFT'); 
	 // $this->db->join('','','LEFT');
	  $this->db->where('dd.alias','sent_offer_mail');
	  $this->db->where("tpf.pnr_ref","WQ1234");
	 // $this->db->where("oref.coupon_code",$this->hash('7k7BXu'));
	  $query = $this->db->get();
	  //print_r($this->db->last_query()); exit;
	  return $query->row();
  } 
  
    
	
}

