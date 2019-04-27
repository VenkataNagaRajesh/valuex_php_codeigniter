<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_cabin_m extends MY_Model {

	protected $_table_name = 'VX_aln_airline_cabin_map';
	protected $_primary_key = 'cabin_map_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "cabin_map_id";

	function __construct() {
		parent::__construct();
	}

	function getAirlines(){
		$arr = array('1' => 'singapore airlines',
			     '2' => 'Airindia Airlines',
			     '3' => 'Malyasia Airlines',
			      '4' => 'kingfisher Airlines');
		return $arr;
	}

	function getAirlineClasses(){
		$arr = array('0' => 'ECO', '1' => 'PEY', '2' => 'BIZ', '3' => 'FIRST');
		return $arr;
				

	}

        function get_airline_cabin_map_count() {
		$this->db->select('count(*) as cnt')->from('VX_aln_airline_cabin_map');
                $query = $this->db->get();
                return $query->row('cnt');

	}
	 function get_AirlineCabinsMapList() {
                $this->db->select('*');
                $this->db->from('VX_aln_airline_cabin_map');
                        $query = $this->db->get();
                        return $query->result();
        }

	function get_airline_cabin_map_by_id($id){
		$this->db->select('*');
                $this->db->from('VX_aln_airline_cabin_map');
		$this->db->where('cabin_map_id', $id);	
		$query = $this->db->get();
                        return $query->result();
        }

         function get_single_airline_cabin($array) {
                $query = parent::get_single($array);
                return $query;
        }


	function insert_airline_cabin($array) {
		$id = parent::insert($array);
		return TRUE;
	}


	function update_airline_cabin($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

function getAirlineCabin($id){
          $this->db->select('*')->from('VX_aln_airline_cabin_map');
          $this->db->where('cabin_map_id' , $id);
          $query = $this->db->get();
          return $query->row();
  }



        function add_airline_cabin_gallery($data){
          $this->db->insert('VX_aln_airline_cabin_images',$data);
          //$this->mydebug->debug($this->db->last_query());
          return TRUE;
  }



  function getAirlineCabinImages($id,$type){	
          $this->db->select('*')->from('VX_aln_airline_cabin_images');
          $this->db->where('type',$type);
          $this->db->where('airline_cabin_map_id',$id);
          $query = $this->db->get();
          return $query->result();
  }

  function getAirlineCabinImage($airline_imagesID){
          $this->db->select('*')->from('VX_aln_airline_cabin_images');
          $this->db->where('cabin_images_id',$airline_imagesID);
          $query = $this->db->get();
          return $query->row();
  }

  function deleteAirlineCabinImage($airline_imagesID){
          $this->db->where('cabin_images_id',$airline_imagesID);
          $this->db->delete('VX_aln_airline_cabin_images');
          return TRUE;
  }

  function getImagesCount($airline_cabinID,$type){
          $this->db->select('count(*) as total')->from('VX_aln_airline_cabin_images');
          $this->db->where('type',$type);
          $this->db->where('airline_cabin_map_id',$airline_cabinID);
          $query = $this->db->get();
          return $query->row('total');
  }


  public function getAirlineCabinsByName(){
                $this->db->select('cabin_map_id, name')->from('VX_aln_airline_cabin_map');
                $query = $this->db->get();
		$result = $query->result();
		$list = array();
		foreach ($result as $k) {
			$list[$k->cabin_map_id] = $k->name;
		}

                return $list;
        }

	function delete_airline_cabin($id){
		parent::delete($id);
	}

	function hash($string) {
		return parent::hash($string);
	}	
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
