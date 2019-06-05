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
	    if($regionID){
		   $countries = $this->airports_m->getDefns(2,$regionID);		
			echo '<option value="0">Select Country</option>';
			foreach ($countries as $country) {
				if($country->vx_aln_data_defnsID == $countryID){
					echo '<option value="'.$country->vx_aln_data_defnsID.'" selected>'.$country->aln_data_value.'</option>';
				}else{
				   echo '<option value="'.$country->vx_aln_data_defnsID.'" >'.$country->aln_data_value.'</option>';
				}
			}
		}		
	}
	
	public function getAirportCities(){
		$countryID = $this->input->post('countryID');		
		$cityID = $this->input->post('cityID');		
	    if($countryID){
		   $cities = $this->airports_m->getDefns(3,$countryID);		
			echo '<option value="0">Select City</option>';
			foreach ($cities as $city) {
				if($city->vx_aln_data_defnsID == $cityID){
					echo '<option value="'.$city->vx_aln_data_defnsID.'" selected>'.$city->aln_data_value.'</option>';
				}else{
				   echo '<option value="'.$city->vx_aln_data_defnsID.'" >'.$city->aln_data_value.'</option>';
				}
			}
		}		
	}
	
	public function getAirportRegions(){
		$regionID = $this->input->post('regionID');
		$areaID = $this->input->post('areaID');	
	    if($areaID){
		   $regions = $this->airports_m->getDefns(4,$areaID);		
			echo '<option value="0">Select Region</option>';
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
	    if($regionID ){
		   $areas = $this->airports_m->getDefns(5,$regionID);
           echo '<option value="0">Select Area</option>';		   
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
	    if($type ){
		   echo '<option value="0">Select Parent</option>';	
		   if($type != 1 && $type != 2){
		   $parentlist = $this->airports_m->getDefns($type-1);          	   
			foreach ($parentlist as $parent) {
				 echo '<option value="'.$parent->vx_aln_data_defnsID.'">'.$parent->aln_data_value.'</option>';
			 }
		   }
		}		 
	}
	
}