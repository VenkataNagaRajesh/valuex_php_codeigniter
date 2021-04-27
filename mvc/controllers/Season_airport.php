<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season_airport extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("season_m");
		$this->load->model("season_airport_map_m");
		$this->load->model("airports_m");
		$this->load->model("airline_m");
		$this->load->model("user_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('season_airport', $language);
		$this->data['icon'] = $this->menu_m->getMenu(array("link"=>"season_airport"))->icon;
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
      $roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
          if(!empty($this->input->post('seasonID'))){
            $this->data['seasonID'] = $this->input->post('seasonID');
          } else {
            $this->data['seasonID'] = 0;
          }
          
          if(!empty($this->input->post('filter_airline'))){
            $this->data['filter_airline'] = $this->input->post('filter_airline');
          } else {
            $this->data['filter_airline'] = 0;
          }
          if(!empty($this->input->post('type'))){
          $this->data['type'] = $this->input->post('type');
          } else {
            $this->data['type'] = 'vx_season_airport_origin_map';
          }

		
		   $this->data['seasonslist'] = $this->season_m->getSeasonsList(); 
		 
                if($roleID != 1){
                    $this->data['airlines'] = $this->user_m->getUserAirlines($userID);	   
                } else {
                    $this->data['airlines'] = $this->airline_m->getAirlinesData();
                } 
		if (count($this->data['airlines']) == 1){
                    $this->data['filter_airline'] = $this->data['airlines'][0]->vx_aln_data_defnsID;
		}
		$this->data['airports_list'] = $this->airports_m->getDefns('1');
		$this->data["subview"] = "season_airport/index";
		$this->load->view('_layout_main', $this->data);
	}

    function server_processing(){	
	    $aColumns = array('s.season_name','ma.aln_data_value','mc.aln_data_value','mr.aln_data_value','mar.aln_data_value','ma.code','m.active');
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
                                   if($_GET['iSortCol_0'] == 8){
                                           $sOrder .= " (s.order_no*-1) DESC ,";
                                   } else { 
                                    $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                                           ".$_GET['sSortDir_'.$i] .", ";
                                   }
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
		   
		   $table = !empty($this->input->get('type'))?$this->input->get('type'):'VX_season_airport_origin_map';
		   $col = ($table == "VX_season_airport_origin_map")?'sap.orig_airportID':'sap.dest_airportID';
           $id = ($table == "VX_season_airport_origin_map")?'saoID':'sadID'; 
           if(!empty($this->input->get('seasonID'))){
           	  $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
        		$sWhere .= 'sap.seasonID = '.$this->input->get('seasonID');
        	}
           if(!empty($this->input->get('airportID'))){
           		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
        		$sWhere .= $col.' = '.$this->input->get('airportID');
                }
            if(!empty($this->input->get('carrier'))){
                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                $sWhere .= 's.airlineID = '.$this->input->get('carrier');
             }
			
	   if($this->session->userdata('roleID') != 1){  
               $seasonslist = $this->season_m->getSeasonsList($this->session->userdata('login_user_airlineID'));
               if(empty($seasonslist)){
                 $seasonslist = array('0');
               }
			 // $markets = array_column($marketzones, 'market_id'); 
			   $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              $sWhere .= 'sap.seasonID IN ('.implode(', ', array_keys($seasonslist)).')';	
			  
            }

           

            $sQuery="SELECT SQL_CALC_FOUND_ROWS s.season_name,sap.*,ma.aln_data_value airport_name,ma.code airport_code,
            
            mc.aln_data_value country_name,mc.code country_code,mr.aln_data_value region,mar.aln_data_value area,
            
            ma.code,m.active,car.code as carrier_code,concat(substring(ma.code,1,3) ,substring(mc.code,1,2)) as city_code FROM ".$table." sap 
            JOIN VX_season s on (s.VX_aln_seasonID = sap.seasonID) 
            LEFT JOIN VX_master_data m on (m.airportID = ".$col." ) 
            LEFT JOIN VX_data_defns ma ON (ma.vx_aln_data_defnsID = m.airportID and ma.aln_data_typeID=1)          
            LEFT JOIN VX_data_defns mc ON (mc.vx_aln_data_defnsID = m.countryID and mc.aln_data_typeID=2) 
            LEFT JOIN VX_data_defns mr ON (mr.vx_aln_data_defnsID = m.regionID and mr.aln_data_typeID=4) 
            LEFT JOIN VX_data_defns mar ON (mar.vx_aln_data_defnsID = m.areaID and mar.aln_data_typeID=5)
            LEFT JOIN VX_data_defns c ON (c.vx_aln_data_defnsID = m.cityID and c.aln_data_typeID=3)

            
			LEFT JOIN VX_data_defns car ON (car.vx_aln_data_defnsID = s.airlineID and car.aln_data_typeID=12)

            $sWhere $sOrder $sLimit";
		  
   //print_r($sQuery); exit;
                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
				
                //$mapcount = $this->market_airport_map_m->getcount_season_airport_orig();

                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $rResultFilterTotal,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );
			 $i++;
			 $n = 1;
            foreach($rResult as $list){
				$list->id = $list->$id;
				$list->temp_id = $n; $n++;
               $output['aaData'][] = $list;
            }
             if(isset($_REQUEST['export'])){
				  $columns = array('#','Season Name','Airport Name','City','Country','Region','Area');
				  $rows = array('temp_id','season_name','airport','city','country','region','area');
				  $this->exportall($output['aaData'],$columns,$rows);		
			 } else {	
				  echo json_encode( $output );
			 }
        }

        public function getSeasonsByCarrier(){
		$airlineID = $this->input->post('filter_airline');		
		$seasonID = $this->input->post('filter_season');		
                echo '<option value="0">Select Season</option>';		
	        if($airlineID){
		   $seasons = $this->season_m->get_seasons_for_airline($airlineID);		
			
			foreach ($seasons as $s) {
				if($s->VX_aln_seasonID == $seasonID){
					echo '<option value="'.$s->VX_aln_seasonID.'" selected>'.$s->season_name.'</option>';
				} else {
				   echo '<option value="'.$s->VX_aln_seasonID.'" >'.$s->season_name.'</option>';
				}
			}
		}		
	}
	
}

