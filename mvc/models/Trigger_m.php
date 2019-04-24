<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trigger_m extends MY_Model {

	protected $_table_name = 'VX_trigger_table';
	//protected $_primary_key = 'market_id';
	//protected $_primary_filter = 'intval';
	//protected $_order_by = "market_id";

	function __construct() {
		parent::__construct();
	}

	function insert_trigger($array) {
		$error = parent::insert($array);
		return TRUE;
	}
 	
	function get_trigger_time($table) {

	 	$this->db->select('create_date');
                $this->db->from('VX_trigger_table');
                $this->db->where(array('isReconfigured' => 1, 'table_name' => $table));
		$this->db->order_by("create_date",'ASC');
		$this->db->limit(1);
                $query = $this->db->get();
                $type = $query->row();
                return $type->create_date;

        }

	

/*	function update_trigger($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

*/


	function update_trigger($data){
	          $this->db->where('isReconfigured','1');
		  $this->db->where('modify_date','0');
           	$this->db->update('VX_trigger_table',$data);

        	  if ($this->db->affected_rows() > 0){
             		return $this->db->insert_id();
          	  } else {
             		return FALSE;
          	  }
	}


	function hash($string) {
		return parent::hash($string);
	}	
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
