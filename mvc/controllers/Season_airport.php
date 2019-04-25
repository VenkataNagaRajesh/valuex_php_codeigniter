<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season_airport extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("season_m");
		$this->load->model("season_airport_map_m");
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('season_airport', $language);
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
          if(!empty($this->input->post('seasonID'))){
            $this->data['seasonID'] = $this->input->post('seasonID');
          } else {
            $this->data['seasonID'] = 0;
          }
          if(!empty($this->input->post('type'))){
          $this->data['type'] = $this->input->post('type');
          } else {
            $this->data['type'] = 'vx_season_airport_origin_map';
          }

		$this->data['seasons'] = $this->season_m->get_seasons(); 
		$this->data['airports_list'] = $this->airports_m->getDefns('1');
		$this->data["subview"] = "season_airport/index";
		$this->load->view('_layout_main', $this->data);
	}

    function server_processing(){
	   
		
	    $aColumns = array('s.season_name,ma.aln_data_value,mc.aln_data_value,ms.aln_data_value, mr.aln_data_value,mar.aln_data_value,ma.code,m.active');
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
			
		

            $sQuery="SELECT SQL_CALC_FOUND_ROWS s.season_name,sap.*,ma.aln_data_value airport,mc.aln_data_value country,ms.aln_data_value state, mr.aln_data_value region,mar.aln_data_value area,ma.code,m.active FROM ".$table." sap 
            LEFT JOIN VX_aln_season s on (s.VX_aln_seasonID = sap.seasonID) 
            LEFT JOIN vx_aln_master_data m on (m.airportID = ".$col." ) 
            LEFT JOIN vx_aln_data_defns ma ON (ma.vx_aln_data_defnsID = m.airportID) 
            LEFT JOIN vx_aln_data_defns ms ON (ms.vx_aln_data_defnsID = m.stateID) 
            LEFT JOIN vx_aln_data_defns mc ON (mc.vx_aln_data_defnsID = m.countryID) 
            LEFT JOIN vx_aln_data_defns mr ON (mr.vx_aln_data_defnsID = m.regionID) 
            LEFT JOIN vx_aln_data_defns mar ON (mar.vx_aln_data_defnsID = m.areaID)
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
            foreach($rResult as $list){
				$list->id = $list->$id;
               $output['aaData'][] = $list;
            }
                echo json_encode( $output );
        }
	


}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
