<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airports_master extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('airports', $language);	
	}

	public function index() {
		$this->data["subview"] = "airports_master/index";
		$this->load->view('_layout_main', $this->data);
	}

	public function upload(){
	 if($_FILES){
		 if (empty($_FILES['file']['name'])) {
            $this->session->set_flashdata('error',"Please select File");			
			$this->data["subview"] = "airports_master/upload";
			$this->load->view('_layout_main', $this->data);
		 } else {
			require(APPPATH.'libraries/spreadsheet/php-excel-reader/Spreadsheet_Excel_Reader.php'); 
			require(APPPATH.'libraries/spreadsheet/SpreadsheetReader.php');		
		try {	
		   $file = $_FILES['file']['tmp_name'];          
			   if(move_uploaded_file($file, APPPATH."/uploads/".$_FILES['file']['name'])){		
				$file =  APPPATH."/uploads/".$_FILES['file']['name']; 			   
				$Reader = new SpreadsheetReader($file); 
				$header = array('id','ident','type','name','latitude_deg','longitude_deg','elevation_ft','continent','iso_country','iso_region','municipality','scheduled_service','gps_code','iata_code','local_code','home_link','wikipedia_link','keywords');
				//print_r(count($header)); exit;
				$Sheets = $Reader -> Sheets();
			    foreach ($Sheets as $Index => $Name){					  
				   $Reader -> ChangeSheet($Index);
				   $i = 0;										  
				  foreach ($Reader as $Row){
					if($i == 0){ // header checking						
					  $flag = 0 ;						 
					 if($Row == $header){
						 $flag = 1;
					 }				  
					} else {
					   if($flag == 1){ 						   						
					   	 if(count($Row) == 18){
							 $airport = $Row[3];
							 $country = $Row[8];
							 $region = $Row[9];
							 $state = explode('-',$Row[9])[1];	
                                					 
							 $area = $Row[10];
							 echo 'Airport :'.$airport.'<br>';
							 echo 'Country'.$country.'<br>';
							 echo 'Region'.$region.'<br>';
							 echo 'State'.$state.'<br>';
							 echo 'Area'.$area.'<br>';
echo '----------------------------------------------------------------------------------------------------<br>';
                               $res = $this->airports_m->checkAirport($airport);
							
							if($res){																	
							  $data['countryID'] = $this->airports_m->checkData($country,2);
							  $data['stateID'] = $this->airports_m->checkData($state,3,$data['countryID']);
							  $data['regionID'] = $this->airports_m->checkData($region,4,$data['stateID']);
							  $data['areaID'] = $this->airports_m->checkData($area,5,$data['regionID']);
							  $data['airportID'] = $this->airports_m->addAirport($airport, $data['areaID']);	  
							  $data['create_date'] = time();
							  $data['modify_date'] = time();
							  $data['create_userID'] = $this->session->userdata('loginuserID');
							  $data['modify_userID'] = $this->session->userdata('loginuserID'); 			
                                  $this->airports_m->addMasterData($data);	
							   
							} else {
								echo "Airport :".$airport." already  existed";
							}
					   	 } 						
					   } else {
						   print_r("mismatch");
					   }
					}
				   $i++;					   
				  }
				  
				}
				
					
				  } 
				 
			} catch (Exception $E)	{
				echo $E -> getMessage();
			}
		    if(file_exists($file)) {
		    	unlink($file);
		    }
			 $this->session->set_flashdata('success', $this->lang->line('menu_success'));
		     redirect(base_url("airports_master/index")); 	
		 }	
	 } else {
			$this->data["subview"] = "airports_master/upload";
			$this->load->view('_layout_main', $this->data); 
      }
    }
	
	
	function server_processing(){
		$userID = $this->session->userdata('loginuserID');
		$usertypeID = $this->session->userdata('usertypeID');	  
		
	    $aColumns = array('u.name','u.email','u.phone','u.username','ut.usertype','b.name');
	
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
		$sQuery = "	SELECT SQL_CALC_FOUND_ROWS u.*,ut.usertype FROM  user u LEFT JOIN usertype ut ON ut.usertypeID = u.usertypeID LEFT JOIN user_branch ub ON ub.userID = u.userID	LEFT JOIN branch b ON b.branchID = ub.branchID	
		$sWhere	
		$sGroup
		$sOrder
		$sLimit	"; 
	
	$rResult = $this->install_m->run_query($sQuery);
	$sQuery = "SELECT FOUND_ROWS() as total";
	$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;	
			
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $userscount,
		"iTotalDisplayRecords" => $rResultFilterTotal,
		"aaData" => array()
	  );
		foreach($rResult as $airport){		 	
			if(permissionChecker('airports_master_edit') || permissionChecker('airports_master_delete') || permissionChecker('airports_master_view') ) {
			 $airport->action = btn_edit('airports_master/edit/'.$airport->userID, $this->lang->line('edit'));
			 $airport->action .= btn_delete('airports_master/delete/'.$airport->userID, $this->lang->line('delete'));			 
			 $airport->action .= btn_view('airports_master/view/'.$airport->userID, $this->lang->line('view'));
			}
			$status = $airport->active;
			$airport->active = "<div class='onoffswitch-small' id='".$airport->userID."'>";
            $airport->active .= "<input type='checkbox' id='myonoffswitch".$airport->userID."' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if($status){
			   $airport->active .= " checked >";
			} else {
			   $airport->active .= ">";
			}	
			
			$airport->active .= "<label for='myonoffswitch".$airport->userID."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";            
           
			$output['aaData'][] = $airport;
				
		}
		echo json_encode( $output );
	}
	
}

