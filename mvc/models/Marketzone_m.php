<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketzone_m extends MY_Model {

	protected $_table_name = 'VX_aln_market_zone';
	protected $_primary_key = 'market_id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "market_id";

	function __construct() {
		parent::__construct();
	}


	function get_marketzonename($id) {
		$query = $this->db->get_where('VX_aln_market_zone',array('market_id'=>$id));
		return $query->row();
	}



	function getMarketZoneById($id) {
	$query = "SELECT MainSet.market_id,MainSet.market_name,MainSet.lname, MainSet.iname, MainSet.ename , SubSet.inclname, SubSet.exclname, SubSet.levelname, MainSet.active ,MainSet.level_id, MainSet.incl_id, MainSet.excl_id,MainSet.airline_name, MainSet.airlineID, MainSet.create_date, MainSet.modify_date, MainSet.create_userID, MainSet.modify_userID
FROM
(
              select  mz.market_id, mz.market_name ,dtl.alias as lname,dti.alias as iname, dte.alias as ename , mz.active as active, 
                        mz.amz_level_id as level_id, mz.amz_incl_id as incl_id, mz.amz_excl_id as excl_id , dd.aln_data_value as airline_name,
                        mz.airline_id as airlineID, mz.create_date, mz.modify_date, mz.create_userID, mz.modify_userID 
              from VX_aln_market_zone mz 
              LEFT JOIN vx_aln_data_types dtl on (dtl.vx_aln_data_typeID = mz.amz_level_id) 
              LEFT JOIN vx_aln_data_types dti on (dti.vx_aln_data_typeID = mz.amz_incl_id)  
              LEFT JOIN vx_aln_data_types dte on (dte.vx_aln_data_typeID = mz.amz_excl_id)
              LEFT JOIN vx_aln_data_defns dd ON dd.vx_aln_data_defnsID = mz.airline_id
) as MainSet

LEFT JOIN (


                select
                        FirstSet.market_id, FirstSet.level as levelname, SecondSet.excl as exclname, ThirdSet.incl as inclname
                from 
                        (          SELECT
                                        m.market_id as market_id,
                                        group_concat(c.aln_data_value) as level
                                   from
                                        VX_aln_market_zone m
                                        join vx_aln_data_defns c on find_in_set(c.vx_aln_data_defnsID, m.amz_level_name)
                                        group by
                                        m.market_id     
           
                        ) as FirstSet  
                LEFT join 

                        (          SELECT
                                   m.market_id as market_id,
                                   group_concat(c.aln_data_value) as excl
                                   from
                                        VX_aln_market_zone m
                                        join vx_aln_data_defns c on find_in_set(c.vx_aln_data_defnsID, m.amz_excl_name)
                                        group by
                                         m.market_id
                        ) as SecondSet
                        on FirstSet.market_id = SecondSet.market_id
                LEFT JOIN 
                        (
                                SELECT
                                        m.market_id as market_id,
                                        group_concat(c.aln_data_value) as incl
                                from
                                        VX_aln_market_zone m 
                                JOIN vx_aln_data_defns c ON find_in_set(c.vx_aln_data_defnsID, m.amz_incl_name)
                                group by
                                        m.market_id
                        ) as ThirdSet

                        on ThirdSet.market_id = FirstSet.market_id

) as SubSet
on MainSet.market_id = SubSet.market_id WHERE MainSet.market_id =".$id;

          $marketzones = $this->install_m->run_query($query);
                return $marketzones;




	}

	function get_single_marketzone($array) {
	        $query = parent::get_single($array);
        	return $query;
    	}

	function get_order_by_marketzone($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}
	
        function get_marketzones_count() {
		$this->db->select('count(*) as cnt')->from('VX_aln_market_zone');
                $query = $this->db->get();
                return $query->row('cnt');

	}
	 function get_marketzones($wherein = null) {
                $this->db->select('*');
                $this->db->from('VX_aln_market_zone');
				if(!empty($wherein)){
					$this->db->where_in('market_id',$wherein);
				}
                        $query = $this->db->get();
                        return $query->result();
        }

	function insert_marketzone($array) {
		$id = parent::insert($array);
		return TRUE;
	}

	function getAlndataType($type){
		$this->db->select('name');
		$this->db->from('vx_aln_data_types');
		$this->db->where(array('vx_aln_data_typeID' => $type));
		$query = $this->db->get();
		$type = $query->row();
		return $type->name;
		
	}

	function getMarketzones() {
		$this->db->select('market_id,market_name');
		$this->db->from('VX_aln_market_zone');
		$this->db->where('active','1');
		$query = $this->db->get();
		 $result = $query->result();

                foreach($result  as $zone) {
                        $marketzones[$zone->market_id]  = $zone->market_name;
                }
                return $marketzones;
        }
		
		
	function getAlnDataTYpes(){
	        $this->db->select('vx_aln_data_typeID,name');
                $this->db->from('vx_aln_data_types');
		$query = $this->db->get();
		$result = $query->result();
                foreach($result  as $type) {
                        $datatypes[$type->vx_aln_data_typeID]  = $type->name;
                }
        	return $datatypes;
	}




	function getMarketzones_for_triggerrun($timestamp) {
		$sql = "SELECT * FROM VX_aln_market_zone
                              WHERE modify_date >= ".$timestamp." AND active = 1 ";
		$marketzones = $this->install_m->run_query($sql);
                return $marketzones;
	}



	function getALndataTypeValues($list){
		$query = "SELECT aln_data_value FROM  vx_aln_data_defns WHERE vx_aln_data_defnsID in (". $list . ")";
                $result = $this->install_m->run_query($query);
		$str = '';
		return implode('<br>+',array_column($result, 'aln_data_value'));
	}
	
	function getSubDataDefns($id){
		  
		 $this->db->select('vx_aln_data_defnsID, aln_data_value')->from('vx_aln_data_defns');
         	 $this->db->where('aln_data_typeID',$id);
         	$query = $this->db->get();
         	$result =  $query->result();
		return $result;
	}


	function getAirportsList($parentID){
		 $query = "select vx_aln_data_defnsID FROM 
					( SELECT * from 
					( SELECT * from vx_aln_data_defns  order by parentID, vx_aln_data_defnsID) 
					  vx_aln_data_defns, (select @pv := ".$parentID.") 
                                          initialisation where find_in_set(parentID, @pv) > 0 and 
					  @pv := concat(@pv, ',', vx_aln_data_defnsID ) ) as subresult where aln_data_typeID = 1";
		$result = $this->install_m->run_query($query);
		return array_column($result,'vx_aln_data_defnsID');
	}

	function getParentsofAirport($airportID) {
		$query = "SELECT T2.vx_aln_data_defnsID 
		          FROM (
    				SELECT
        				@r AS _id,
        				(SELECT @r := parentID FROM vx_aln_data_defns WHERE vx_aln_data_defnsID = _id) AS parentID,
        				@l := @l + 1 AS lvl
    				FROM
        				(SELECT @r := ".$airportID.", @l := 0) vars,
        			    	vx_aln_data_defns m
    					WHERE @r <> 0) T1
				JOIN vx_aln_data_defns T2
					ON T1._id = T2.vx_aln_data_defnsID
				ORDER BY T1.lvl DESC";

		$result = $this->install_m->run_query($query);
		return array_column($result,'vx_aln_data_defnsID');

	}

	function update_marketzone($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	function delete_marketzone($id){
		parent::delete($id);
	}

	function hash($string) {
		return parent::hash($string);
	}	
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
