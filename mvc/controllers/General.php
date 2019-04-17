<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends Admin_Controller {

    function __construct() {
		parent::__construct();
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('usertype', $language);	
	}
	
	public function getAirportStates(){
		$countryID = $this->input->post('countryID');
		$stateID = $this->input->post('stateID');	
	    if($countryID){
		   $states = $this->airports_m->getDefns(3,$countryID);		
			echo '<option value="0">Select State</option>';
			foreach ($states as $state) {
				if($state->vx_aln_data_defnsID == $stateID){
					echo '<option value="'.$state->vx_aln_data_defnsID.'" selected>'.$state->aln_data_value.'</option>';
				}else{
				   echo '<option value="'.$state->vx_aln_data_defnsID.'" selected>'.$state->aln_data_value.'</option>';
				}
			}
		}
		/* $this->output->set_content_type('application/json');		
		$this->output->set_output(json_encode($json)); */
	}
	
	public function getAirportRegions(){
		$regionID = $this->input->post('regionID');
		$stateID = $this->input->post('stateID');	
	    if($stateID){
		   $regions = $this->airports_m->getDefns(4,$stateID);		
			echo '<option value=\"0\">Select Region</option>';
			foreach ($regions as $region) {
				if($region->vx_aln_data_defnsID == $regionID){
					echo '<option value="'.$region->vx_aln_data_defnsID.'" selected>'.$region->aln_data_value.'</option>';
				}else{
				    echo '<option value="'.$region->vx_aln_data_defnsID.'">'.$region->aln_data_value.'</option>';
				}
			}
		}
		/* $this->output->set_content_type('application/json');		
		$this->output->set_output(json_encode($json)); */
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
		/* $this->output->set_content_type('application/json');		
		$this->output->set_output(json_encode($json)); */
	}

}