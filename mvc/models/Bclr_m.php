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
                return $query;
        }


        function get_single_bclr($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }

        function insert_bclr($array) {
                $error = parent::insert($array);
                return TRUE;
        }

	  function update_bclr($data, $id = NULL) {
                parent::update($data, $id);
                return $id;
        }

	function checkBCLREntry($array){
                $this->db->select('bclr_id');
                $this->db->from('BG_baggage_control_rule');
                $this->db->where($array);
                $this->db->limit(1);
                $query = $this->db->get();
                $check = $query->row();
                if($check->bclr_id) {
                    return $check->bclr_id;
                } else {
                  return false;
                }
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



        public function delete_bclr($id){
                parent::delete($id);
        }    

	
}

