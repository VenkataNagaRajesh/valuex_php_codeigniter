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
        echo '<option value="0">Country</option>';		
	    if($regionID){
		   $countries = $this->airports_m->getDefns(2,$regionID);					
			foreach ($countries as $country) {
				if($country->vx_aln_data_defnsID == $countryID){
					echo '<option value="'.$country->vx_aln_data_defnsID.'" selected>'.$country->code.'</option>';
				}else{
				   echo '<option value="'.$country->vx_aln_data_defnsID.'" >'.$country->code.'</option>';
				}
			}
		}		
	}
	
	public function getAirportCities(){
		$countryID = $this->input->post('countryID');		
		$cityID = $this->input->post('cityID');	
        echo '<option value="0">City</option>';		
	    if($countryID){
		   $cities = $this->airports_m->getDefns(3,$countryID);		
			
			foreach ($cities as $city) {
				if($city->vx_aln_data_defnsID == $cityID){
					echo '<option value="'.$city->vx_aln_data_defnsID.'" selected>'.$city->code.'</option>';
				}else{
				   echo '<option value="'.$city->vx_aln_data_defnsID.'" >'.$city->code.'</option>';
				}
			}
		}		
	}
	
	public function getAirportRegions(){
		$regionID = $this->input->post('regionID');
		$areaID = $this->input->post('areaID');	
			echo '<option value="0">Region</option>';
	    if($areaID){
		   $regions = $this->airports_m->getDefns(4,$areaID);		
		
			foreach ($regions as $region) {
				if($region->vx_aln_data_defnsID == $regionID){
					echo '<option value="'.$region->vx_aln_data_defnsID.'" selected>'.$region->aln_data_value.'</option>';
				}else{
				    echo '<option value="'.$region->vx_aln_data_defnsID.'">'.$region->aln_data_value.'</option>';
				}
			}
		}		 
	}
	
	public function getAirportAreas(){
		$regionID = $this->input->post('regionID');
		$areaID = $this->input->post('areaID');
echo '<option value="0">Area</option>';		
	    if($regionID ){
		   $areas = $this->airports_m->getDefns(5,$regionID);
           		   
			foreach ($areas as $area) {
				if($area->vx_aln_data_defnsID == $areaID){
					echo '<option value="'.$area->vx_aln_data_defnsID.'" selected>'.$area->aln_data_value.'</option>';
				}else{
				   echo '<option value="'.$area->vx_aln_data_defnsID.'">'.$area->aln_data_value.'</option>';
				}
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