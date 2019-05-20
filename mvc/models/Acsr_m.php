<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acsr_m extends MY_Model {

	protected $_table_name = 'VX_aln_auto_confirm_setup_rules';
	protected $_primary_key = 'acsr_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "acsr_id desc";

	function __construct() {
		parent::__construct();
	}

	function get_acsr($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}	
	

	function get_single_acsr($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	function insert_acsr($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	function time_dropdown($val) {
                for($i=0;$i<$val;$i++){
                        if($i<10 && strlen($i)<2)
                        {
                                $num = '0'.$i;
                        } else {
				$num = $i;
		        }  
                        $time_arr[$num] = $num;
                }
        return $time_arr;
        }



	function update_acsr($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_acsr($id){
		parent::delete($id);
	}
}

