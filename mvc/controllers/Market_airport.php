<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market_airport extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("marketzone_m");
		$this->load->model("market_airport_map_m");
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('market_airport', $language);
		$this->data['icon'] = $this->menu_m->getMenu(array("link"=>"market_airport"))->icon;
	}


	public function index() {

		 $this->data['headerassets'] = array(
                        'css' => array(
                                'assets/select2/css/select2.css',
                                'assets/select2/css/select2-bootstrap.css',
                                'assets/fselect/fSelect.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js',
                                'assets/fselect/fSelect.js',
                        )
                );


	        if(!empty($this->input->post('market_id'))){
                  $this->data['marketID'] = $this->input->post('market_id');
                } else {
                  $this->data['marketID'] = 0;
                }
                if(!empty($this->input->post('airport_id'))){
                $this->data['airportID'] = $this->input->post('airport_id');
                } else {
                  $this->data['airportID'] = 0;
                }



		if(!empty($this->input->post('country_id'))){
                $this->data['countryID'] = $this->input->post('country_id');
                } else {
                  $this->data['countryID'] = 0;
                }


		if(!empty($this->input->post('region_id'))){
                $this->data['regionID'] = $this->input->post('region_id');
                } else {
                  $this->data['regionID'] = 0;
                }


		if(!empty($this->input->post('city_id'))){
                $this->data['cityID'] = $this->input->post('city_id');
                } else {
                  $this->data['cityID'] = 0;
                }

		if($this->session->userdata('roleID') != 1){
                  $this->data['marketzones'] = $this->marketzone_m->get_marketzones(null,$this->session->userdata('login_user_airlineID'));
                } else {
                  $this->data['marketzones'] = $this->marketzone_m->get_marketzones();
                }


		$this->data['airports_list'] = $this->airports_m->getDefnsCodesListByType('1');
		$this->data['country_list'] = $this->airports_m->getDefnsCodesListByType('2');
		$this->data['city_list'] = $this->airports_m->getDefnsCodesListByType('3');
		$this->data['region_list'] = $this->airports_m->getDefnsListByType('4');
                $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
		
                if($roleID != 1){
                    $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
                } else {
                    $this->data['airlines'] = $this->airline_m->getAirlinesData();
                }
		if (count($this->data['airlines']) == 1){
                    $this->data['filter_airline'] = $this->data['airlines'][0];
		}
		$this->data["subview"] = "market_airport/index";
		$this->load->view('_layout_main', $this->data);
	}





  function server_processing(){

	$aColumns =  array('mam.ma_id', 'mz.market_name','car.code','ma.code','mct.code','mc.code','mr.aln_data_value','mar.aln_data_value','car.aln_data_value','ma.aln_data_value','mct.aln_data_value','mc.aln_data_value');
                $sLimit = "";

                        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
                        {
                          $sLimit = "LIMIT ".$_GET['iDisplayStart'].",".$_GET['iDisplayLength'];
                        }
                        if ( isset( $_GET['iSortCol_0'] ) )
                        {
                                $sOrder = "ORDER BY  "; 
                                for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
                                {
                                        if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                                        {
                                              // // if($_GET['iSortCol_0'] == 8{
                                                //        $sOrder .= " (s.order_no*-1) DESC ,";
                                               // } else { 
                                                 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                                                        ".$_GET['sSortDir_'.$i] .", ";
                                                //}
                                        }
                                }                               
                                  $sOrder = substr_replace( $sOrder, "", -2 );

                                if ( $sOrder == "ORDER BY" )
                                {
                                        $sOrder = "";
                                }
                        }
                        $sWhere = "";
                        if ( $_GET['sSearch'] != "" )
                        {
                                $sWhere = "WHERE (";
                                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                                {
                                        $sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
                                }
                                $sWhere = substr_replace( $sWhere, "", -3 );
                                $sWhere .= ')';
                        }
                        /* Individual column filtering */
                        for ( $i=0 ; $i<count($aColumns) ; $i++ )
                        {
                                if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
                                {
                                        if ( $sWhere == "" )
                                        {
                                                $sWhere = "WHERE ";
                                        }
                                        else
                                        {
                                                $sWhere .= " AND ";
                                        }
                                        $sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
                                }
                        }

                        if(!empty($this->input->get('marketID'))){
                     		 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'mz.market_id = '.$this->input->get('marketID');
                	}
                        if(!empty($this->input->get('airportID'))){
                      		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'mam.airport_id = '.$this->input->get('airportID');
                	}


			if(!empty($this->input->get('cityID'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'm.cityID = '.$this->input->get('cityID');
                        }

			if(!empty($this->input->get('countryID'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'm.countryID = '.$this->input->get('countryID');
                        }


			if(!empty($this->input->get('regionID'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'm.regionID = '.$this->input->get('regionID');
                        }

                        if(!empty($this->input->get('carrier'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'mz.airline_id = '.$this->input->get('carrier');
                        }


                $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID != 1){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'mz.airline_id IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';                
                }


$sQuery = " SELECT SQL_CALC_FOUND_ROWS mam.ma_id,mz.market_id,mz.market_name,ma.code airport,mc.code country, 
		mct.code as city, car.code as carrier_code, car.aln_data_value,
            mr.aln_data_value region,mar.aln_data_value area,ma.code,m.active FROM VX_market_zone mz 
            JOIN VX_market_airport_map mam on (mam.market_id = mz.market_id) 
            LEFT JOIN VX_master_data m on (m.airportID = mam.airport_id ) 
	    left join VX_data_defns car ON (car.vx_aln_data_defnsID = mz.airline_id)
            left join VX_data_defns ma ON (ma.vx_aln_data_defnsID = m.airportID) 
            left join VX_data_defns mct ON (mct.vx_aln_data_defnsID = m.cityID) 
            left join VX_data_defns mc ON (mc.vx_aln_data_defnsID = m.countryID) 
            left join VX_data_defns mr ON (mr.vx_aln_data_defnsID = m.regionID) 
            left join VX_data_defns mar ON (mar.vx_aln_data_defnsID = m.areaID)

 $sWhere $sOrder $sLimit";



                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                //$mapcount = $this->market_airport_map_m->get_market_airport_mapid_count();
                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $rResultFilterTotal,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );
                $i = 1;
		$rownum = 1 + $_GET['iDisplayStart'];
                foreach($rResult as $list){
			$list->sno = $rownum;
			$rownum++;

                     $list->id = $i; $i++;
                        $output['aaData'][] = $list;
                     
                }
               if(isset($_REQUEST['export'])){
				  $columns = array('#','Marketzone Name','Airport Name','City','Country','Region','Area');
				  $rows = array('id','market_name','airport','city','country','region','area');
				  $this->exportall($output['aaData'],$columns,$rows);		
				} else {	
				  echo json_encode( $output );
				}
        }
	
        public function getMarketzoneByCarrier(){
		$airlineID = $this->input->post('filter_airline');		
		$marketzoneID = $this->input->post('filter_marketzone');		
                echo '<option value="0">Select Marketzone</option>';		
	        if($airlineID){
		   $marketzones = $this->marketzone_m->get_marketzones(null,$airlineID);		
			foreach ($marketzones as $s) {
				if($s->market_id == $marketzoneID){
					echo '<option value="'.$s->market_id.'" selected>'.$s->market_name.'</option>';
				} else {
				   echo '<option value="'.$s->market_id.'" >'.$s->market_name.'</option>';
				}
			}
		}		
	}

}

