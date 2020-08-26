<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bclr_m extends MY_Model {

	protected $_table_name = 'BG_baggage_control_rule';
	protected $_primary_key = 'bclr_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "bclr_id desc";

        function __construct() {
                parent::__construct();
        }

        function get_bclr($array=NULL, $signal=FALSE) {
                $query = parent::get($array, $signal);
             //print_r($this->db->last_query());
                return $query;
        }


        function get_single_bclr($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }

        function get_single_bg_cwt_bclr_id($array=NULL) {
            $this->db->select('cwt_bclr_id');
            $this->db->from('BG_cwt_bclr_new');
            $this->db->where($array);
            $query = $this->db->get();
            $check = $query->row();
            if($check->cwt_bclr_id) {
                return $check->cwt_bclr_id;
            } else {
              return false;
            }
        }

        function get_cwt_bclr_data($bclr_id)
        {
            $query = $this->db->get_where('BG_cwt_bclr_new',array("active" => 1,"bclr_id" => $bclr_id));
            return $query->result();
        }

        function insert_bclr($array) {
                $error = parent::insert($array);
                return TRUE;
        }

	  function update_bclr($data, $id = NULL) {
                parent::update($data, $id);
            //print_r($this->db->last_query());
                return $id;
        }

	function checkBCLREntry($array){
                $this->db->select('bclr_id,version_id');
                $this->db->from('BG_baggage_control_rule');
                $this->db->where($array);
                $this->db->limit(1);
                $query = $this->db->get();
            //print_r($this->db->last_query());
                $check = $query->row();
                $get_bclr_entry = array();
                if($check->bclr_id) {
                    $get_bclr_entry = [$check->bclr_id,$check->version_id];
                }
                return $get_bclr_entry;
        }


	function checkANDInsertBCLR($data,$array1) {
	   $bclr_id = $this->checkBCLREntry($data);
		$array = array_merge($data,$array1);
           if($bclr_id){ 
                  $array["modify_date"] = time();
                  $array["modify_userID"] = $this->session->userdata('loginuserID');
                  $this->bclr_m->update_bclr($array,$bclr_id);

           } else {
                  $array["create_date"] = time();
                  $array["modify_date"] = time();
                  $array["create_userID"] = $this->session->userdata('loginuserID');
                  $array["modify_userID"] = $this->session->userdata('loginuserID');
                 $this->bclr_m->insert_bclr($array);
            }
        }
        
        // public function delete_bclr($id){
        //         parent::delete($id);
        // }  
        
    public function delete_bclr($id){
        $this->db->where(['bclr_id' => $id]);
        $this->db->update('BG_baggage_control_rule', ['active' => 0]);
        return true;
    }

	public function insert_cwt($data){
            $this->db->insert('BG_cwt',$data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function update_cwt($data,$where){
            $this->db->where($where);
            $this->db->update('BG_cwt',$data);
            // print_r($this->db->last_query());
        }

        public function insert_cwt_bclr($data){
            $this->db->insert('BG_cwt_bclr_new', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function update_cwt_bclr($data, $where){
            $this->db->where($where);
            $this->db->update('BG_cwt_bclr_new', $data);
            // print_r($this->db->last_query());die();
            return TRUE;
        }

        public function disable_cwt($bclr_id){
            $this->db->where('bclr_id',$bclr_id);
            $this->db->update('BG_cwt',array('active'=>0));
            return TRUE;
        }

        public function getActiveCWT($bclr_id){
            $this->db->select('cum_wt, price_per_kg');
            $this->db->from('BG_cwt');
            $this->db->where(array("active" => 1,"bclr_id" => $bclr_id));
	    $query = $this->db->get();
            return $query->result_array();
        }

        public function insert_update_cwt($data){
           $where = array("bclr_id"=> $data['bclr_id'],"cum_wt"=>$data['cum_wt'],"active"=>1);
           $result = $this->db->get_where('BG_cwt',$where)->row();
           if($result){
               $this->db->where('cwt_id',$result->cwt_id);
               $this->db->update('BG_cwt',array('price_per_kg' => $data['price_per_kg']));
           }  else {
               $this->db->insert('BG_cwt',$data);
           }  
        }

        public function checkGraphName($bclr_id,$name){
            $query = $this->db->get_where('BG_cwt',array('bclr_id'=>$bclr_id,"name"=>$name));
            $result = $query->row();
            if($result){
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public function getVersionID($bclr_id)
        {
            $this->db->select('version_id');
            $this->db->from('BG_baggage_control_rule');
            $this->db->where(['bclr_id' => $bclr_id]);
            $query = $this->db->get();
            $check = $query->row();
            return $check->version_id;
        }

        public function delete_cwt($where)
        {
            $this -> db -> where($where);
            $this -> db -> delete('BG_cwt');
            return TRUE;
        }

        function get_bclr_by_carrier_id($carrier_id)
        {
            $query = $this->db->get_where('BG_baggage_control_rule',array("active" => 1,"carrierID" => $carrier_id));
            return $query->result();
        }

        function get_bclr_by_all_carriers($carriers= Array())
        {
		$query = " SELECT * FROM BG_baggage_control_rule  WHERE carrierID IN (" . implode(",", $carriers) . " )ORDER BY carrierID ";
		$result = $this->install_m->run_query($query);
		$bcresult = Array();
		foreach($result as $bclr){
			$bcresult[$bclr->carrierID][]  = $bclr;
		}
		return  $bcresult;

        }

}

