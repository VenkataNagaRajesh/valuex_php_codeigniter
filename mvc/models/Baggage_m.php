<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Baggage_m extends MY_Model {

	protected $_table_name = 'BG_baggage';
	protected $_primary_key = 'baggageID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "baggageID desc";

        function __construct() {
                parent::__construct();
        }

        function get_baggage($array=NULL, $signal=FALSE) {
                $query = parent::get($array, $signal);
                return $query;
        }

        function get_single_baggage($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }

        function insert_baggage($array) {
                $error = parent::insert($array);
                return TRUE;
        }

	function update_baggage($data, $id = NULL) {
                parent::update($data, $id);
                return $id;
        }

        function insert_baggage_history($data){
            $this->db->insert('BG_baggage_history',$data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function delete_baggage($id){
            parent::delete($id);
        }

        public function save_baggage_data($data){
                $this->db->select('*')->from('BG_baggage');
                $this->db->where('offer_id',$data['offer_id']);
                $this->db->where('bclr_id',$data['bclr_id']);
                $query = $this->db->get();
                $baggage_data = $query->row();
                if(empty($baggage_data)){
                 $this->db->insert("BG_baggage",$data);
                 $id = $this->db->insert_id();
                } else {
                      $this->db->where('baggageID',$baggage_data->baggageID);
                      $this->db->update('BG_baggage',$data);
              $id = $bid_data->bid_id;		
                }
                return $id;
        } 
    }    