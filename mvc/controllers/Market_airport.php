<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market_airport extends Admin_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/
	function __construct() {
		parent::__construct();
		$this->load->model("marketzone_m");
		$this->load->model("market_airport_map_m");
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('market_airport', $language);
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
                $this->data['airportID'] = $this->input->post('airort_id');
                } else {
                  $this->data['airportID'] = 0;
                }

		$this->data['marketzones'] = $this->marketzone_m->get_marketzones();
		$this->data['airports_list'] = $this->airports_m->getDefns('1');
		$this->data["subview"] = "market_airport/index";
		$this->load->view('_layout_main', $this->data);


	}





  function server_processing(){

	    $aColumns =  array('mz.market_name,airport,country,state,region,area');
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

                        if(!empty($this->input->get('marketID'))){
                     		 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'mz.market_id = '.$this->input->get('marketID');
                	}
                        if(!empty($this->input->get('airportID'))){
                      		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'mam.airport_id = '.$this->input->get('airportID');
                	}



$sQuery = " SELECT mz.market_id,mz.market_name,ma.aln_data_value airport,mc.aln_data_value country,ms.aln_data_value state,
            mr.aln_data_value region,mar.aln_data_value area,ma.code,m.active FROM VX_aln_market_zone mz 
            JOIN VX_market_airport_map mam on (mam.market_id = mz.market_id) 
            LEFT JOIN vx_aln_master_data m on (m.airportID = mam.airport_id ) 
            left join vx_aln_data_defns ma ON (ma.vx_aln_data_defnsID = m.airportID) 
            left join vx_aln_data_defns ms ON (ms.vx_aln_data_defnsID = m.stateID) 
            left join vx_aln_data_defns mc ON (mc.vx_aln_data_defnsID = m.countryID) 
            left join vx_aln_data_defns mr ON (mr.vx_aln_data_defnsID = m.regionID) 
            left join vx_aln_data_defns mar ON (mar.vx_aln_data_defnsID = m.areaID)
 $sWhere $sOrder $sLimit";
                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                $mapcount = $this->market_airport_map_m->get_market_airport_mapid_count();

                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $mapcount,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );

                foreach($rResult as $list){

                        $output['aaData'][] = $list;

                }
                echo json_encode( $output );
        }
	


}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
