<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends Admin_Controller {

    function __construct() {
		parent::__construct();
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('usertype', $language);	
	}
	
	public function getAirportCountries(){
		$countryID = $this->input->post('countryID');		
		$regionID = $this->input->post('regionID');	
		if ( empty($countryID) ) {
			$countryID = 0;
		}
        echo '<option value="0" ' . ((!$countryID) ? 'selected': '') . ' >Country</option>';		
		   $countries = $this->airports_m->getDefnsByMasterData(2,$regionID);					
			foreach ($countries as $country) {
				if($country->vx_aln_data_defnsID == $countryID){
					echo '<option value="'.$country->vx_aln_data_defnsID.'" selected>'.$country->code.'</option>';
				}else{
				   echo '<option value="'.$country->vx_aln_data_defnsID.'" >'.$country->code.'</option>';
				}
			}
	}

	public function getAirports(){
		$airportID = $this->input->post('airportID');		
		$cityID = $this->input->post('cityID');	
        echo '<option value="0">Airport</option>';		
		   $airports = $this->airports_m->getDefnsByMasterData(1,$cityID);					
			foreach ($airports as $airport) {
				if($airport->vx_aln_data_defnsID == $airportID){
					echo '<option value="'.$airport->vx_aln_data_defnsID.'" selected>'.$airport->code.'</option>';
				}else{
				   echo '<option value="'.$airport->vx_aln_data_defnsID.'" >'.$airport->code.'</option>';
				}
			}
	}
	
	public function getAirportsByName(){

		$search = $this->input->post('search');
		$season=$this->input->post('season');

		if(empty($season)){
			
			$airports = $this->airports_m->getAirportsByName($search,1);
		} 
		else if($season>0)
		{
			//alert($season);
				$airports=$this->airports_m->getAirportsByNameBasedOnSeason($search,$season);
		}
		
		else {
		$airports = array();
		}
		if ( empty($airports) ) {
			$airports[0]['airportID'] = 0;
			$airports[0]['airport_name'] = 'No Matching Airports';;
		}
		$this->output->set_content_type('application/json');
	        $this->output->set_output(json_encode($airports));
	}



	public function getCitiesByName(){
		$search = $this->input->post('search');
		if($search){
			$cities = $this->airports_m->getCitiesByName($search,1);
		} else {
		$cities = array();
		}
		$this->output->set_content_type('application/json');
	        $this->output->set_output(json_encode($cities));
	}
	public function getCountriesByName(){
		$search = $this->input->post('search');
		if($search){
			$countries = $this->airports_m->getCountriesByName($search,1);
		} else {
		$countries = array();
		}
		$this->output->set_content_type('application/json');
	        $this->output->set_output(json_encode($countries));
	}

	public function getAirportCities(){
		$countryID = $this->input->post('countryID');		
		$cityID = $this->input->post('cityID');	
        echo '<option value="0">City</option>';		
		   $cities = $this->airports_m->getDefnsByMasterData(3,$countryID);		
			
			foreach ($cities as $city) {
				if($city->vx_aln_data_defnsID == $cityID){
					echo '<option value="'.$city->vx_aln_data_defnsID.'" selected>'.$city->code.'</option>';
				}else{
				   echo '<option value="'.$city->vx_aln_data_defnsID.'" >'.$city->code.'</option>';
				}
			}
	}
	
	public function getAirportRegions(){
		$regionID = $this->input->post('regionID');
		$areaID = $this->input->post('areaID');	
			echo '<option value="0">Region</option>';
		   $regions = $this->airports_m->getDefnsByMasterData(4,$areaID);		
		
			foreach ($regions as $region) {
				if($region->vx_aln_data_defnsID == $regionID){
					echo '<option value="'.$region->vx_aln_data_defnsID.'" selected>'.$region->aln_data_value.'</option>';
				}else{
				    echo '<option value="'.$region->vx_aln_data_defnsID.'">'.$region->aln_data_value.'</option>';
				}
			}
	}
	
	public function getAirportAreas(){
		$regionID = $this->input->post('regionID');
		$areaID = $this->input->post('areaID');
		echo '<option value="0">Area</option>';		
		   $areas = $this->airports_m->getDefnsByMasterData(5,$regionID);
           		   
			foreach ($areas as $area) {
				if($area->vx_aln_data_defnsID == $areaID){
					echo '<option value="'.$area->vx_aln_data_defnsID.'" selected>'.$area->aln_data_value.'</option>';
				}else{
				   echo '<option value="'.$area->vx_aln_data_defnsID.'">'.$area->aln_data_value.'</option>';
				}
		}		 
	}
	
	public function getParentlist(){
		$type = $this->input->post('type');	
		 echo '<option value="0">Parent</option>';			
	    if($type ){
		  
		   if($type != 1 && $type != 2){
		   $parentlist = $this->airports_m->getDefns($type-1);          	   
			foreach ($parentlist as $parent) {
				 echo '<option value="'.$parent->vx_aln_data_defnsID.'">'.$parent->aln_data_value.'</option>';
			 }
		   }
		}		 
	}
	
	public function defaultAirline(){
		$this->session->set_userdata('default_airline',$this->input->post('airline'));
		$json='default airline changed';
       if (isset($_SERVER)) {		
		    header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			header('Access-Control-Max-Age: 1000');
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));		
	}
	
      public function submitFeedback(){
		 $data = $_POST;	
          if(empty($data['customer_service'])){
			  $data['customer_service'] = 0;
		  }
         	 
		 $this->load->model('bid_m');
         $this->bid_m->addFeedBack($data);	 
		 $json['status'] = 'Success'; 
	     if (isset($_SERVER)) {		
		    header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			header('Access-Control-Max-Age: 1000');
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));	 
      }
	
	
}
