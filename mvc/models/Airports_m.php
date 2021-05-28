<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Airports_m extends MY_Model
{

	public function checkData($data, $type, $parent = null, $code = null)
	{
		$this->db->select('*')->from('VX_data_defns');
		if (!empty($code)) {
			$this->db->where(array('code' => $code, 'aln_data_typeID' => $type));
		} else {
			$this->db->where(array('aln_data_value' => $data, 'aln_data_typeID' => $type));
		}

		if ($parent != null) {
			$this->db->where('parentID', $parent);
		}
		$query = $this->db->get();
		$this->mydebug->debug($this->db->last_query());
		if (count($query->result()) > 0) {
			return $query->row('vx_aln_data_defnsID');
		} else {
			$array = array(
				'aln_data_value' => $data,
				'aln_data_typeID' => $type,
				'code' => $code,
				'create_date' => time(),
				'modify_date' => time(),
				'create_userID' => $this->session->userdata('loginuserID'),
				'modify_userID' => $this->session->userdata('loginuserID'),
				'parentID' => $parent
			);
			$this->db->insert('VX_data_defns', $array);
			// $this->mydebug->debug($data);
			$this->mydebug->debug($this->db->last_query());
			if ($this->db->affected_rows() > 0) {
				return $this->db->insert_id();
			} else {
				return FALSE;
			}
		}
	}

	public function checkAirport($data)
	{
		$this->db->select('*')->from('VX_data_defns');
		$this->db->where(array('aln_data_value' => $data, 'aln_data_typeID' => 1));
		$query = $this->db->get();
		// print_r($this->db->last_query()); exit;  	  
		return $query->row();
	}

	public function checkAirportCode($code)
	{
		$this->db->select('count(*) count')->from('VX_data_defns');
		$this->db->where(array('code' => $code, 'aln_data_typeID' => 1));
		$query = $this->db->get();
		return $query->row('count');
	}

	public function addAirport($airport, $parent, $code, $alias = '')
	{
		$array = array(
			'aln_data_value' => $airport,
			'code' => $code,
			'alias' => $alias,
			'aln_data_typeID' => 1,
			'create_date' => time(),
			'modify_date' => time(),
			'create_userID' => $this->session->userdata('loginuserID'),
			'modify_userID' => $this->session->userdata('loginuserID'),
			'parentID' => $parent
		);

		$this->db->insert('VX_data_defns', $array);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function addMasterData($data)
	{
		$this->db->insert('VX_master_data', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	 public function getDefns($type = null, $parent = null)
        {
                $this->db->select('vx_aln_data_defnsID,aln_data_typeID,aln_data_value,code, alias')->from('VX_data_defns');
                if ($type != null) {
                        $this->db->where('aln_data_typeID', $type);
                } else {
                        $this->db->where('aln_data_typeID !=', 1);
                }
                if ($parent != null) {
                        $this->db->where('parentID', $parent);
                }
                $query = $this->db->get();
                //$this->mydebug->debug($this->db->last_query());
                return $query->result();
        }
	public function getCountriesByName($search,$countryVal=0){
                $this->db->select('CONCAT_WS("-",d.code,d.aln_data_value) as country_name,d.vx_aln_data_defnsID as  countryID')->from('VX_data_defns d');
                $this->db->group_start();
                $this->db->like('d.aln_data_value',$search);
                $this->db->or_like('d.code',$search);
                $this->db->group_end();
                if($countryVal){
                   $this->db->where('d.vx_aln_data_defnsID !=',0);
                } else {
                   $this->db->where('d.vx_aln_data_defnsID',0);
                }
                   $this->db->where('d.active',1);
                   $this->db->where('d.aln_data_typeID',2);
                #$this->db->limit(5);
                $query = $this->db->get();
	//	echo $this->db->last_query();	 exit;
                return $query->result();
        }

	public function getCitiesByName($search,$cityVal=0){
                $this->db->select('CONCAT_WS("-",d.code,d.aln_data_value) as city_name,d.vx_aln_data_defnsID as cityID')->from('VX_data_defns d');
                $this->db->group_start();
                $this->db->like('d.aln_data_value',$search);
                $this->db->or_like('d.code',$search);
                $this->db->group_end();
                if($cityVal){
                   $this->db->where('d.vx_aln_data_defnsID !=',0);
                } else {
                   $this->db->where('d.vx_aln_data_defnsID',0);
                }
                   $this->db->where('d.active',1);
                   $this->db->where('d.aln_data_typeID',3);
                #$this->db->limit(5);
                $query = $this->db->get();
	//	echo $this->db->last_query();	 exit;
                return $query->result();
        }

	public function getAirportsByName($search,$airportVal=0){

                $this->db->select('CONCAT_WS("-",d.code,d.aln_data_value) as airport_name,d.vx_aln_data_defnsID as airportID')->from('VX_data_defns d');
                $this->db->group_start();
                $this->db->like('d.aln_data_value',$search);
                $this->db->or_like('d.code',$search);
                $this->db->group_end();
                if($airportVal){
                   $this->db->where('d.vx_aln_data_defnsID !=',0);
                } else {
                   $this->db->where('d.vx_aln_data_defnsID',0);
                }
                   $this->db->where('d.active',1);
                   $this->db->where('d.aln_data_typeID',1);
                #$this->db->limit(5);
                $query = $this->db->get();
                return $query->result();
        }

		public function getAirportsByNameBasedOnSeason($search,$season)
		{
			
			$this->db->select('CONCAT_WS("-",d.code,d.aln_data_value) as airport_name,d.vx_aln_data_defnsID as airportID');
			$this->db->group_start();
			$this->db->from('VX_data_defns d');
        	$this->db->like('d.code',$search);
			$this->db->like('d.aln_data_value',$search);
			$this->db->group_end();
			$this->db->join('VX_season_airport_origin_map','VX_season_airport_origin_map.orig_airportID=d.vx_aln_data_defnsID','inner');	
			$this->db->where('VX_aln_seasonID',$season)->from('VX_season');
			$this->db->order_by('d.aln_data_value');
			
			
		
			#$this->db->limit(5);
			$query = $this->db->get();
//		echo $this->db->last_query();	 exit;
			return $query->result();

		}



	public function getDefnsByMasterData($type = null, $parent = null)
	{
		switch($type) {
			case 5: 
				$column = 'areaID';
				$col = 'areaID';
			break;
			case 4: 
				$column = 'areaID';
				$col = 'regionID';
			break;
			case 2: 
				$column = 'regionID';
				$col = 'countryID';
			break;
			case 3: 
				$column = 'countryID';
				$col = 'cityID';
			break;
			case 1: 
				$column = 'cityID';
				$col = 'airportID';
			break;
		}
		$this->db->distinct();
		$this->db->select('vx_aln_data_defnsID,aln_data_typeID,aln_data_value,code, alias')->from('VX_master_data m');
		$this->db->join('VX_data_defns ma', 'ma.vx_aln_data_defnsID = m.' . $col, 'LEFT');
		if ( $parent ) {
			$this->db->where($column, $parent);
		} else  {
			$this->db->where('aln_data_typeID', $type);
		}
		$query = $this->db->get();
		//$this->mydebug->debug($this->db->last_query());	  
		//echo $this->db->last_query();	 
		return $query->result();
	}

	public function getDefnsListByType($type)
	{

		$this->db->select('vx_aln_data_defnsID,aln_data_value')->from('VX_data_defns');
		$this->db->where('aln_data_typeID', $type);
		$query = $this->db->get();
		$result = $query->result();
		$arr = array();
		foreach ($result as $def) {
			$arr[$def->vx_aln_data_defnsID] = $def->aln_data_value;
		}


		return $arr;
	}


	public function getDefnsCodesListByType($type)
	{

		$this->db->select('vx_aln_data_defnsID,code')->from('VX_data_defns');
		$this->db->where('aln_data_typeID', $type);
		$query = $this->db->get();
		$result = $query->result();
		$arr = array();
		foreach ($result as $def) {
			$arr[$def->vx_aln_data_defnsID] = $def->code;
		}

        
		return $arr;
	}



	public function getDefinitionList($wherein)
	{
		$this->db->select('aln_data_value,code,vx_aln_data_defnsID')->from('VX_data_defns');
		$this->db->where_in('vx_aln_data_defnsID', $wherein);
		$query = $this->db->get();
		return $query->result();
	}


	public function get_airportmaster($id)
	{
		$query = $this->db->get_where('VX_master_data', array('vx_amdID' => $id))->row();
		return $query;
	}

	public function delete_airport($vx_amdID, $airportID)
	{
		$this->db->where('vx_amdID', $vx_amdID);
		$this->db->delete('VX_master_data');

		$this->db->where('vx_aln_data_defnsID', $airportID);
		$this->db->delete('VX_data_defns');

		return TRUE;
	}

	public function getAirportData($id)
	{
		$this->db->select('m.*,ma.aln_data_value airport,mc.aln_data_value country,mr.aln_data_value region,mar.aln_data_value area,ma.code,u.name modify_by,m.modify_date')->from('VX_master_data m');
		$this->db->join('VX_data_defns ma', 'ma.vx_aln_data_defnsID = m.airportID', 'LEFT');
		$this->db->join('VX_data_defns ms', 'ms.vx_aln_data_defnsID = m.cityID ', 'LEFT');
		$this->db->join('VX_data_defns mc', 'mc.vx_aln_data_defnsID = m.countryID', 'LEFT');
		$this->db->join('VX_data_defns mr', 'mr.vx_aln_data_defnsID = m.regionID', 'LEFT');
		$this->db->join('VX_data_defns mar', 'mar.vx_aln_data_defnsID = m.areaID', 'LEFT');
		$this->db->join('VX_user u', 'u.userID = m.modify_userID', 'LEFT');
		$this->db->where('m.vx_amdID', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getAirportMasterDataByAiportId($id)
	{
		$this->db->select('m.*,ma.aln_data_value airport,ma.vx_aln_data_defnsID as airport_id,mc.vx_aln_data_defnsID as country_id,  mc.aln_data_value country, mr.vx_aln_data_defnsID as regin_id, ms.vx_aln_data_defnsID as city_id, mar.vx_aln_data_defnsID as area_id,mr.aln_data_value region,mar.aln_data_value area,ma.code,u.name modify_by,m.modify_date')->from('VX_master_data m');
		$this->db->join('VX_data_defns ma', 'ma.vx_aln_data_defnsID = m.airportID', 'LEFT');
		$this->db->join('VX_data_defns ms', 'ms.vx_aln_data_defnsID = m.cityID ', 'LEFT');
		$this->db->join('VX_data_defns mc', 'mc.vx_aln_data_defnsID = m.countryID', 'LEFT');
		$this->db->join('VX_data_defns mr', 'mr.vx_aln_data_defnsID = m.regionID', 'LEFT');
		$this->db->join('VX_data_defns mar', 'mar.vx_aln_data_defnsID = m.areaID', 'LEFT');
		$this->db->join('VX_user u', 'u.userID = m.modify_userID', 'LEFT');
		$this->db->where('m.airportID', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function TotalAirports()
	{
		$this->db->select('count(*) count')->from('VX_master_data');
		$query = $this->db->get();
		return $query->row('count');
	}

	public function update_master_data($data, $id)
	{
		$this->db->where('vx_amdID', $id);
		$this->db->update('VX_master_data', $data);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function add_definition_data($data)
	{
		$this->db->insert('VX_data_defns', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function get_definition_data($id)
	{
		$this->db->select('dd.*,dd1.aln_data_value parent,u.name modify_by,t.name type,t.alias type_alias')->from('VX_data_defns dd');
		$this->db->join('VX_data_defns dd1', 'dd1.vx_aln_data_defnsID = dd.parentID', 'LEFT');
		$this->db->join('VX_data_types t', 't.vx_aln_data_typeID = dd.aln_data_typeID', 'LEFT');
		$this->db->join('VX_user u', 'u.userID = dd.modify_userID', 'LEFT');
		$this->db->where('dd.vx_aln_data_defnsID', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_definition_data($data, $id)
	{
		$this->db->where('vx_aln_data_defnsID', $id);
		$this->db->update('VX_data_defns', $data);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function validateDefdata($where)
	{
		$this->db->select('count(*)')->from('VX_data_defns');
		$this->db->where($where);
		$query = $this->db->get();
		// $this->mydebug->debug($this->db->last_query());
		return $query->row('count(*)');
	}

	public function delete_definition_data($id)
	{
		$this->db->where('vx_aln_data_defnsID', $id);
		$this->db->delete('VX_data_defns');
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function getDefdataTypes($excludetype = array(), $includetype = array())
	{
		$this->db->select('*')->from('VX_data_types');
		if (!empty($excludetype)) {
			$this->db->where_not_in('vx_aln_data_typeID', $excludetype);
		}
		if (!empty($includetype)) {
			$this->db->where_in('vx_aln_data_typeID', $includetype);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function getDefIdByTypeAndValue($value, $type)
	{

		$this->db->select('VX_data_defnsID');
		$this->db->from('VX_data_defns');
		$this->db->where('aln_data_typeID', $type);
		$this->db->where('aln_data_value', $value);
		$this->db->limit(1);
		$query = $this->db->get();
		$name = $query->row();
		return $name->vx_aln_data_defnsID;
	}



	function getDefIdByTypeAndCode($code, $type)
	{

		$this->db->select('vx_aln_data_defnsID');
		$this->db->from('VX_data_defns');
		$this->db->where('aln_data_typeID', $type);
		$this->db->where('code', $code);
		$this->db->limit(1);
		$query = $this->db->get();
		$name = $query->row();
		return $name->vx_aln_data_defnsID;
	}



	function getDefDataCodeByIDANDType($defId, $type)
	{

		$this->db->select('code');
		$this->db->from('VX_data_defns');
		$this->db->where('aln_data_typeID', $type);
		$this->db->where('vx_aln_data_defnsID', $defId);
		$this->db->limit(1);
		$query = $this->db->get();
		$name = $query->row();
		return $name->code;
	}

	function getDefDataForAirlineCabin($defId, $type, $carrier)
	{

		$this->db->select('cdef.level,cdef.cabin');
		$this->db->from('VX_airline_cabin_def cdef');
		$this->db->join('VX_data_defns aca', 'aca.VX_aln_data_defnsID = ' . $defId . ' and aca.alias = cdef.level and aca.aln_data_typeID = ' . $type, 'INNER');
		$this->db->where('cdef.carrier', $carrier);
		$this->db->limit(1);
		$query = $this->db->get();
		$name = $query->row();
		return $name;
	}

	function getAirportICAOCode($defId)
	{

		$this->db->select('alias');
		$this->db->from('VX_data_defns');
		$this->db->where('vx_aln_data_defnsID', $defId);
		$this->db->limit(1);
		$query = $this->db->get();
		$name = $query->row();
		return $name->alias;
	}

	function insertAirDistance($fromAirport,$toAirport,$distance)
	{
		$array = array(
			'from_airport' => $fromAirport,
			'to_airport' => $toAirport,
			'distance' => $distance
		);
		$this->db->insert('VX_airport_distance', $array);
		// $this->mydebug->debug($data);
		$this->mydebug->debug($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	function getAirDistances($from_city = 0, $to_city = 0) {
		$sQuery = "SELECT CONCAT_WS('-', from_airport, to_airport) as airports, distance" ;
		$sQuery .= " FROM `VX_airport_distance` ";
		if ($from_city ) {
			$sQuery .= " AND `from_airport` = $from_city";
		}
		if ($to_city ) {
			$sQuery .= " AND `to_airport` = $to_city";
		}
		//$result = $this->install_m->run_query($sQuery);
		$result = $this->db->query($sQuery);
		//print_r($this->db->last_query());
                return  array_column($result->result_array(), 'distance', 'airports');
	}

	public function getAirportDataDefData($id)
	{
		$this->db->select('ma.aln_data_value airport,ma.vx_aln_data_defnsID as airportID, ms.vx_aln_data_defnsID as cityID, mc.vx_aln_data_defnsID as countryID, mr.vx_aln_data_defnsID as regionID, mar.vx_aln_data_defnsID as areaID,  mc.aln_data_value country,mr.aln_data_value region,mar.aln_data_value area,ma.code')->from('VX_data_defns ma');
		$this->db->join('VX_data_defns ms', 'ms.vx_aln_data_defnsID = ma.parentID ', 'LEFT');
		$this->db->join('VX_data_defns mc', 'mc.vx_aln_data_defnsID = ms.parentID', 'LEFT');
		$this->db->join('VX_data_defns mr', 'mr.vx_aln_data_defnsID = mc.parentID', 'LEFT');
		$this->db->join('VX_data_defns mar', 'mar.vx_aln_data_defnsID = mr.parentID', 'LEFT');
		$this->db->where('ma.vx_aln_data_defnsID', $id);
		$query = $this->db->get();
	//	echo $this->db->last_query();
		return $query->row();
	}

}
