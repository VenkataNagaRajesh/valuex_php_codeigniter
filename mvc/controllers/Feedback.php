<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends Admin_Controller {

	function __construct() {
		parent::__construct();	
        $this->load->model('bid_m');		
		$language = $this->session->userdata('lang');
		$this->lang->load('feedback', $language);	
	}

	public function index() {
		$this->data['avg_rating'] = $this->bid_m->avgFeedback();
		$this->data["subview"] = "feedback/index";
		$this->load->view('_layout_main', $this->data);
		
	}

	function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  
				
	    $aColumns = array('feedbackID','overall_experience','time_response','our_support','overall_satisfaction','customer_service','message');
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
			$sHaving = "";
			if ( $_GET['sSearch'] != "" )
			{
				$sWhere = "WHERE (";
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
				$sHaving = " HAVING airline_name LIKE '%".$_GET['sSearch']."%'";
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
		   
		   $sQuery = "SELECT SQL_CALC_FOUND_ROWS * from UP_feedback
			#sWhere		
			$sOrder
			$sLimit	"; 
		//print_r($sQuery); exit;
		$rResult = $this->install_m->run_query($sQuery);
		$sQuery = "SELECT FOUND_ROWS() as total";
		$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
				
			$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $rResultFilterTotal,
			"iTotalDisplayRecords" => $rResultFilterTotal,
			"aaData" => array()
		  );
	  foreach($rResult as $feedback){	
          
           	$output['aaData'][] = $feedback;				
		}			
	   echo json_encode( $output );
		
	}

}
