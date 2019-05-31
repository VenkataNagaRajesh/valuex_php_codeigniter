<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_m extends MY_Model {
  
  function pnr_code_validate($pnr,$code){
     $this->db->select('count(*) count')->from('VX_aln_dtpf_ext ext');
	 $this->db->join('VX_aln_daily_tkt_pax_feed dtpf','dtpf.dtpf_id = ext.dtpf_id','LEFT'); 
	 $this->db->where('dtpf.pnr_ref',$pnr);
	 $this->db->where('ext.coupon_code',$code);
	 $result = $this->db->get();	 
	 return $result->row('count');
  }
	
}

