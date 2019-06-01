<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_reference_m extends MY_Model {

	protected $_table_name = 'VX_aln_offer_ref';
	protected $_primary_key = 'offer_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "offer_id desc";

        function __construct() {
                parent::__construct();
        }

        function get_offer_ref($array=NULL, $signal=FALSE) {
                $query = parent::get($array, $signal);
                return $query;
        }


        function get_single_offer_ref($array=NULL) {
                $query = parent::get_single($array);
                return $query;
        }

        function insert_offer_ref($array) {
		$error = parent::insert($array);
                return TRUE;

        }

	  function update_offer_ref($data, $id = NULL) {
                parent::update($data, $id);
                return $id;
        }



        public function delete_offer_ref($id){
                parent::delete($id);
        }

	public function getEncoded($str) {
		return $this->hash($str);
        }

	
}

