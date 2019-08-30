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
                        FirstSet.market_id, FirstSet.level as levelname, ThirdSet.excl as exclname, SecondSet.incl as inclname
                from 
                        (         

                                 SELECT        m.market_id  as market_id  , 
                                                COALESCE(group_concat(c.aln_data_value),group_concat(mm.market_name) )  AS level 
                                                FROM VX_aln_market_zone m 
                                                LEFT OUTER JOIN  vx_aln_data_defns c ON 
                                                (find_in_set(c.vx_aln_data_defnsID, m.amz_level_name) AND m.amz_level_id in (1,2,3,4,5)) 
                                                LEFT OUTER JOIN  VX_aln_market_zone mm  
                                                ON (find_in_set(mm.market_id, m.amz_level_name) AND m.amz_level_id = 17) group by m.market_id
           
                        ) as FirstSet  
                LEFT join 

                        (          
                                 SELECT        m.market_id  as market_id  , 
                                                COALESCE(group_concat(c.aln_data_value),group_concat(mm.market_name) )  AS incl
                                                FROM VX_aln_market_zone m 
                                                LEFT OUTER JOIN  vx_aln_data_defns c ON 
                                                (find_in_set(c.vx_aln_data_defnsID, m.amz_incl_name) AND m.amz_incl_id in (1,2,3,4,5)) 
                                                LEFT OUTER JOIN  VX_aln_market_zone mm  
                                                ON (find_in_set(mm.market_id, m.amz_incl_name) AND m.amz_incl_id = 17) group by m.market_id

                        ) as SecondSet
                        on FirstSet.market_id = SecondSet.market_id
                LEFT JOIN 
                        (

                                  SELECT        m.market_id  as market_id  , 
                                                COALESCE(group_concat(c.aln_data_value),group_concat(mm.market_name) )  AS excl 
                                                FROM VX_aln_market_zone m 
                                                LEFT OUTER JOIN  vx_aln_data_defns c ON 
                                                (find_in_set(c.vx_aln_data_defnsID, m.amz_excl_name) AND m.amz_excl_id in (1,2,3,4,5)) 
                                                LEFT OUTER JOIN  VX_aln_market_zone mm  
                                                ON (find_in_set(mm.market_id, m.amz_excl_name) AND m.amz_excl_id = 17) group by m.market_id


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
	 function get_marketzones($wherein = null,$airline_in=null,$where_not_in = null) {
                $this->db->select('*');
                $this->db->from('VX_aln_market_zone');
				if(!empty($wherein)){
					$this->db->where_in('market_id',$wherein);
				}
				if(!empty($airline_in)){
					$this->db->where_in('airline_id',$airline_in);
				}

				if(!empty($where_not_in)){
					$this->db->where_not_in('market_id',$where_not_in);
				}
                        $query = $this->db->get();
                        return $query->result();
        }


	function insert_marketzone($array) {
		 $this->db->insert("VX_aln_market_zone",$array);
          	return $this->db->insert_id();

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
		if($this->session->userdata('usertypeID') != 1){
			$this->db->where_in('airline_id',$this->session->userdata('login_user_airlineID'));
		}
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
		$sql = "SELECT market_id FROM VX_aln_market_zone
                              WHERE modify_date >= ".$timestamp." AND active = 1 ";
		$marketzones = $this->install_m->run_query($sql);
			  
		$list = array_column($marketzones,'market_id');

		return $list;

	}



	function getAirportsDataForMktZones($list){

	 $this->db->query('SET SQL_BIG_SELECTS=1');

	 $sQuery =  "SELECT        mz.market_id, COALESCE(group_concat(distinct c.airportID) ,group_concat(distinct mapl.airport_id)) as level_value , COALESCE(group_concat(distinct cc.airportID) , group_concat(distinct mapi.airport_id))  as incl_value, COALESCE(group_concat(distinct ce.airportID) , group_concat(distinct mape.airport_id))  as excl_value FROM VX_aln_market_zone mz LEFT OUTER JOIN  vx_aln_master_data c ON (
(find_in_set(c.countryID, mz.amz_level_name) AND mz.amz_level_id  = 2) OR
(find_in_set(c.cityID, mz.amz_level_name) AND mz.amz_level_id  = 3) OR
(find_in_set(c.airportID, mz.amz_level_name) AND mz.amz_level_id  = 1) OR
(find_in_set(c.regionID, mz.amz_level_name) AND mz.amz_level_id  = 4) OR
(find_in_set(c.areaID, mz.amz_level_name) AND mz.amz_level_id  = 5) 
  ) LEFT OUTER JOIN VX_market_airport_map mapl on (find_in_set(mapl.market_id, mz.amz_level_name) AND mz.amz_level_id  = 17) LEFT OUTER JOIN  vx_aln_master_data cc ON ((find_in_set(cc.countryID, mz.amz_incl_name) AND mz.amz_incl_id  = 2) OR
(find_in_set(cc.cityID, mz.amz_incl_name) AND mz.amz_incl_id  = 3) OR
(find_in_set(cc.airportID, mz.amz_incl_name) AND mz.amz_incl_id  = 1) OR
(find_in_set(cc.regionID, mz.amz_incl_name) AND mz.amz_incl_id  = 4) OR
(find_in_set(cc.areaID, mz.amz_incl_name) AND mz.amz_incl_id  = 5) )
LEFT OUTER JOIN VX_market_airport_map mapi on (find_in_set(mapi.market_id, mz.amz_incl_name) AND mz.amz_incl_id  = 17) 
LEFT OUTER JOIN  vx_aln_master_data ce ON ((find_in_set(ce.countryID, mz.amz_excl_name) AND mz.amz_excl_id  = 2) OR
(find_in_set(ce.cityID, mz.amz_excl_name) AND mz.amz_excl_id  = 3) OR
(find_in_set(ce.airportID, mz.amz_excl_name) AND mz.amz_excl_id  = 1) OR
(find_in_set(ce.regionID, mz.amz_excl_name) AND mz.amz_excl_id  = 4) OR
(find_in_set(ce.areaID, mz.amz_excl_name) AND mz.amz_excl_id  = 5) )
LEFT OUTER JOIN VX_market_airport_map mape on (find_in_set(mape.market_id, mz.amz_excl_name) AND mz.amz_excl_id  = 17)

 WHERE mz.active = 1 AND mz.market_id IN (" .implode(',',$list) . " )
group by mz.market_id";   
	
	$result = $this->install_m->run_query($sQuery);
	return $result;
	}


	function getSubmarketsForList($list){
		$matchset = array();
		
		foreach ($list as $id ) {

                        $sql = "SELECT market_id FROM VX_aln_market_zone WHERE active = 1 AND
                                amz_level_id = 17 AND FIND_IN_SET(".$id.",amz_level_name) OR
                                amz_incl_id  = 17 AND FIND_IN_SET(".$id.",amz_incl_name) OR
                                amz_excl_id  = 17 AND FIND_IN_SET(".$id.",amz_excl_name)";
                        $newlist = $this->install_m->run_query($sql);

                        $matchset = array_merge($matchset,array_column($newlist,'market_id'));
                }
		
		return $matchset;
	}
	
	function getMarkets_for_triggerrun($timestamp) {
		$sql = "SELECT market_id FROM VX_aln_market_zone WHERE modify_date >= ".$timestamp." AND active = 1 ";
		$marketzones = $this->install_m->run_query($sql);
        return array_column($marketzones,'market_id');
	}



	function getALndataTypeValues($list){
		$query = "SELECT aln_data_value FROM  vx_aln_data_defns WHERE vx_aln_data_defnsID in (". $list . ")";
                $result = $this->install_m->run_query($query);
		$str = '';
		return implode('<br>+',array_column($result, 'aln_data_value'));
	}
	
	function getSubDataDefns($id){
		  
		 $this->db->select('vx_aln_data_defnsID, aln_data_value,code')->from('vx_aln_data_defns');
         	 $this->db->where('aln_data_typeID',$id);
		 $this->db->where('active','1');
		$this->db->order_by('aln_data_value');
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


	function getChildsList($parentID,$type){
                 $query = "select vx_aln_data_defnsID, aln_data_value,code FROM 
                                        ( SELECT * from 
                                        ( SELECT * from vx_aln_data_defns  order by parentID, vx_aln_data_defnsID) 
                                          vx_aln_data_defns, (select @pv := ".$parentID.") 
                                          initialisation where find_in_set(parentID, @pv) > 0 and 
                                          @pv := concat(@pv, ',', vx_aln_data_defnsID ) ) as subresult where aln_data_typeID = ".$type.
					  " AND active = 1 ";
                $result = $this->install_m->run_query($query);
                return $result;
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


	function getMarketsForAirportID($airport_id) {

		$this->db->select('market_name')->from('VX_aln_market_zone m');
          $this->db->join('VX_market_airport_map ma','ma.market_id = m.market_id','LEFT');
          $this->db->where('ma.airport_id',$airport_id);
		$query = $this->db->get();
                $result =  $query->result();
		return array_column($result,'market_name');
	}


	function getAirportsForMarketID($market_id) {
                $this->db->select('airport_id')->from('VX_market_airport_map');
                $this->db->where('market_id',$market_id);
                $query = $this->db->get();
                $result =  $query->result();
                return array_column($result,'airport_id');
        }


	function getAirportsMarketData($airline_in = array()) { 
	
	  $sql  =  "select  mz.market_name, group_concat(dd.code)   as airports
		    from VX_market_airport_map map 
			INNER JOIN VX_aln_market_zone mz on (mz.market_id = map.market_id)  
			INNER JOIN  vx_aln_data_defns dd on (dd.vx_aln_data_defnsID =  map.airport_id ) " ;
		if(!empty($airline_in)){
			$sql .= "  WHERE airline_id IN ( " . implode(',',$airline_in) . ")" ;
                }

	   $sql .= " group by mz.market_id";

		$rResult = $this->install_m->run_query($sql);
		return $rResult;

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

    function marketzoneTotalCount(){
		$this->db->select('count(*) count')->from('VX_aln_market_zone');
		if($this->session->userdata('usertypeID') != 1){		
			//$this->db->where('create_userID',$this->session->userdata('loginuserID'));
			$this->db->where_in('airline_id',$this->session->userdata('login_user_airlineID'));
		}
		if(!empty($this->session->userdata('default_airline'))){
			$this->db->where('airline_id',$this->session->userdata('default_airline'));
		}
		$query = $this->db->get();
		return $query->row('count');
	}	
}

/* End of file user_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/user_m.php */
