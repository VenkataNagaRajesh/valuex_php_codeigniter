<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_cabin extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('airline_cabin_m');
		$this->load->model('airports_m');
		$this->load->model('user_m');
		$this->load->model('airline_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('airline_cabin', $language);
		$this->data['icon'] = $this->menu_m->getMenu(array("link"=>"airline_cabin"))->icon;
	}

	protected function rules() {
		$rules = array(
	
			array(
				'field' => 'airline_code',
				'label' => $this->lang->line("airline_name"),
				'rules' => 'trim|required|xss_clean|max_length[60]|callback_valLevelType'
			),
		
			 array(
                                'field' => 'airline_aircraft',
                                'label' => $this->lang->line("airline_aircraft"),
                                'rules' => 'trim|required|xss_clean|max_length[60]|callback_valLevelType'
                        ),


   		       array(
                                'field' => 'airline_cabin',
                                'label' => $this->lang->line("airline_cabin"),
                                'rules' => 'trim|required|max_length[200]|xss_clean|callback_valLevelType'
                        ),

			array(
                                'field' => 'video',
                                'label' => $this->lang->line("airline_video"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),
			array(
                                'field' => 'images[]',
                                'label' => $this->lang->line("images"),
                                'rules' => 'trim|max_length[200]|xss_clean'
                        ),

		);
		return $rules;
	}


   function valLevelType($post_string){
          if($post_string == '0'){
                 $this->form_validation->set_message("valLevelType", "%s is required");
                  return FALSE;
           }else{
                  return TRUE;
           }
        }

        function valLevelValue($post_array){
          if(count($post_array) < 1){
                 $this->form_validation->set_message("valLevelValue", "%s is required");
                  return FALSE;
           }else{
                  return TRUE;
           }
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


	        if(!empty($this->input->post('airline_code'))){
                  $this->data['airlineID'] = $this->input->post('airline_code');
                } else {
                  $this->data['airlineID'] = 0;
                }


		if(!empty($this->input->post('airline_aircraft'))){
                  $this->data['aircraftID'] = $this->input->post('airline_aircraft');
                } else {
                  $this->data['aircraftID'] = 0;
                }

                if(!empty($this->input->post('airline_class'))){
                $this->data['classID'] = $this->input->post('airline_class');
                } else {
                  $this->data['classID'] = 0;
                }

		if(!empty($this->input->post('active'))){
                $this->data['active'] = $this->input->post('active');
                } else {
                    $this->data['active'] = '1';
                }


		
                $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');


            $this->data['airlinecabins'] = $this->airline_cabin_m->getAirlineCabins();

                 if($userTypeID == 2){
                        $this->data['airlinesdata'] = $this->airline_m->getClientAirlineArr($userID);

                           } else {
                        $this->data['airlinesdata'] = $this->airline_cabin_m->getAirlines();

                }



		$this->data["subview"] = "airline_cabin/index";
		$this->load->view('_layout_main', $this->data);

	}

	public function add() {

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


		
                $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');


            	$this->data['airlinecabins'] = $this->airline_cabin_m->getAirlineCabins();

                 if($userTypeID == 2){
                        $this->data['airlinesdata'] = $this->airline_m->getClientAirlineArr($userID);

                           } else {
                        $this->data['airlinesdata'] = $this->airline_cabin_m->getAirlines();

                }

		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "airline_cabin/add";
				$this->load->view('_layout_main', $this->data);
			} else {

				$array["airline_code"] = $this->input->post("airline_code");
				$array['aircraft_id'] = $this->input->post("airline_aircraft");
				$array["airline_cabin"] = $this->input->post("airline_cabin");

				$exist_id = $this->airline_cabin_m->checkAirlineCabin($array);
				if ( $exist_id > 0 ) {
					 $this->session->set_flashdata('error', 'Duplicate Entry');
                                        redirect(base_url("airline_cabin/index"));
				} else {
				$array["create_date"] = time();
				$array["modify_date"] = time();
				$array["create_userID"] = $this->session->userdata('loginuserID');
			        $array["modify_userID"] = $this->session->userdata('loginuserID');
				$array["active"] = 1;
				$array['video_links'] = implode(',',$this->input->post("video"));
				$map_id = $this->airline_cabin_m->insert_airline_cabin($array);

				if($map_id > 0 ) {
					$msg = $this->airlinesgallery($map_id);
					if($msg == 'success') {
						$this->session->set_flashdata('success', $msg);
                                		redirect(base_url("airline_cabin/index"));
					} else {
						$this->session->set_flashdata('error', $msg);
                                                redirect(base_url("airline_cabin/add"));

				       }

				} else {
					
					  $this->data["subview"] = "error";
			                $this->load->view('_layout_main', $this->data);

				}
				}
			}
		} else {
			$this->data["subview"] = "airline_cabin/add";
			$this->load->view('_layout_main', $this->data);
		}
	}


	public function edit() {
		 $this->data['headerassets'] = array(
                        'css' => array(
                                'assets/select2/css/select2.css',
                                'assets/select2/css/select2-bootstrap.css'
                        ),
                        'js' => array(
                                'assets/select2/select2.js'
                        )
                );
		
		
                $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');


            $this->data['airlinecabins'] = $this->airline_cabin_m->getAirlineCabins();

                 if($userTypeID == 2){
                        $this->data['airlinesdata'] = $this->airline_m->getClientAirlineArr($userID);

                           } else {
                        $this->data['airlinesdata'] = $this->airline_cabin_m->getAirlines();

                }


		 $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $this->data['airline'] = $this->airline_cabin_m->get_single_airline_cabin(array('cabin_map_id' => $id));
	 $this->data['airline_cabin']->gallery = $this->airline_cabin_m->getAirlineCabinImages($id);
            if($this->data['airline']) {
                if($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "/airline_cabin/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else { 

			    $array["airline_code"] = $this->input->post("airline_code");
			     $array['aircraft_id'] = $this->input->post("airline_aircraft");
			    $array["airline_cabin"] =  $this->input->post("airline_cabin");
				$exist_id = $this->airline_cabin_m->checkAirlineCabin($array);
				if ( $exist_id == $id || !$exist_id ) {
                            		$array["modify_date"] = time();
			    		$array["modify_userID"] = $this->session->userdata('loginuserID');
			    		$array["video_links"] = implode(',',$this->input->post("video"));
                            		$this->airline_cabin_m->update_airline_cabin($array, $id);
					$msg = $this->airlinesgallery($id);
					if ( $msg == 'success' ) {
                            			$this->session->set_flashdata('success', $msg);
                            			redirect(base_url("airline_cabin/index"));
					 } else {
						$this->session->set_flashdata('error', $msg);
						$this->data["subview"] = "/airline_cabin/edit";
                    				$this->load->view('_layout_main', $this->data);
					
					}
			   } else {

				$this->session->set_flashdata('error', 'Duplicate Entry');
                            redirect(base_url("airline_cabin/index"));

			}
                    }

                } else {
                    $this->data["subview"] = "/airline_cabin/edit";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }    

     }

	public function delete() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->data['airline_cabin'] = $this->airline_cabin_m->get_airline_cabin_map_by_id($id);
			if($this->data['airline_cabin']) {
				$this->airline_cabin_m->delete_airline_cabin($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("airline_cabin/index"));
			} else {
				redirect(base_url("airline_cabin/index"));
			}
		} else {
			redirect(base_url("airline_cabin/index"));
		}
	}




	 function active() {
                if(permissionChecker('airline_cabin_edit')) {
                        $id = $this->input->post('id');
                        $status = $this->input->post('status');
                        if($id != '' && $status != '') {
                                if((int)$id) {
                                        if($status == 'chacked') {
                                                $this->airline_cabin_m->update_airline_cabin(array('active' => 1), $id);
                                                echo 'Success';
                                        } elseif($status == 'unchacked') {
                                                $this->airline_cabin_m->update_airline_cabin(array('active' => 0), $id);
                                                echo 'Success';
                                        } else {
                                                echo "Error";
                                        }
                                } else {
                                        echo "Error";
                                }
                        } else {
                                echo "Error";
                        }
                } else {
                        echo "Error";
                }
        }



    public function airlinesgallery($map_id){
        $airline_cabinID = $map_id;
        if($this->input->post()){
		$airline_cabin = $this->airline_cabin_m->getAirlineCabin($airline_cabinID);
            $filesCount = count($_FILES['images']['name']);
		 $imgcount = $this->airline_cabin_m->getImagesCount($airline_cabinID);
	     if( $imgcount + $filesCount > 5){
                                $msg = "Image Count Exceeded 5"; 
				return $msg;
              }
            for($i = 0; $i < $filesCount; $i++){ 
			//var_dump($airline_cabin);exit;
				$airline_cabin->cabin_map_id = $airine_cabin->cabin_map_id . $_FILES["images"]['name'][$i];
                	        $file_name = $_FILES["images"]['name'][$i];
                        	$random = rand(1, 10000000000000000);
                		$makeRandom = hash('sha512', $random.$airline_cabin->cabin_map_id . config_item("encryption_key"));
                        	$file_name_rename = $makeRandom;
            			$explode = explode('.', $file_name);
            		if(count($explode) >= 2) {
				$new_file = $file_name_rename.'.'.end($explode);
					$_FILES['image']['name'] = $_FILES['images']['name'][$i];
			 		$_FILES['image']['type'] = $_FILES['images']['type'][$i]; 
					$_FILES['image']['tmp_name'] = $_FILES['images']['tmp_name'][$i]; 
					$_FILES['image']['error'] = $_FILES['images']['error'][$i]; 
					$_FILES['image']['size'] = $_FILES['images']['size'][$i]; 

					$config['upload_path'] = "./uploads/images";
					$config['allowed_types'] = 'gif|jpg|png'; 
			 		$config['file_name'] = $new_file;
                                	$config['max_size'] = '1024';
                                	$config['max_width'] = '3000';
                                	$config['max_height'] = '3000';
                                	$this->load->library('upload', $config);
			
                			$this->upload->initialize($config);
                			if($this->upload->do_upload('image')){
                    				$fileData = $this->upload->data();

					   $gallery= array(
                                          'airline_cabin_map_id' => $map_id,
                                          'name' => $this->input->post('name'.$i),
                                          'image' => $fileData['file_name'],
					  'status' => 1,
                                          'create_date' => time(),
                                          'modify_date' => time(),
                                          'create_userID' => $this->session->userdata('loginuserID'),
                                          'modify_userID' => $this->session->userdata('loginuserID')
                                        );
					 $airline_cabin_galleryID = $this->airline_cabin_m->add_airline_cabin_gallery($gallery);
					$msg = 'success';

                		} else {
					$msg .= $this->upload->display_errors();

				}
            		}            
	     }
           }

		return $msg;
        }

        public function deleteAirlineCabinimage(){
                $cabin_imagesID = htmlentities(escapeString($this->uri->segment(3)));
                $airline_cabin_image = $this->airline_cabin_m->getAirlineCabinImage($cabin_imagesID);
                $this->mydebug->debug($airline_cabin_image);
                if($airline_cabin_image->image != 'defualt.png') {
                        if(file_exists(FCPATH.'uploads/images/'.$airline_cabin_image->image)) {
                                unlink(FCPATH.'uploads/images/'.$airline_cabin_image->image);
                        }
                }
                 $this->airline_cabin_m->deleteAirlineCabinImage($cabin_imagesID);
                 $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                 redirect(base_url('airline_cabin/edit/'.$airline_cabin_image->airline_cabin_map_id));
        }
                           




	public function view() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
		
                if ((int)$id) {
                        $this->data["airline_cabin"] = $this->airline_cabin_m->getAirLineCabinDataByID($id);
			$this->data['airline_cabin']->gallery = $this->airline_cabin_m->getAirlineCabinImages($id);

                        if($this->data["airline_cabin"]) {
                                $this->data["subview"] = "airline_cabin/view";
                                $this->load->view('_layout_main', $this->data);
                        } else {
                                $this->data["subview"] = "error";
                                $this->load->view('_layout_main', $this->data);
                        }
                } else {
                        $this->data["subview"] = "error";
                        $this->load->view('_layout_main', $this->data);
                }
        }



  function server_processing(){

	    $aColumns =  array('ac.aln_data_value','airline_cabin','video_links','cr.aln_data_value','ac.code','acl.aln_data_value');
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

                        if(!empty($this->input->get('airlineID'))){
                     		 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'airline_code = '.$this->input->get('airlineID');
                	}
                        if(!empty($this->input->get('cabinID'))){
                      		$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
              			$sWhere .= 'airline_cabin = '.$this->input->get('cabinID');
                	}

                       if(!empty($this->input->get('active')) && $this->input->get('active') != '-1'){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'cm.active = '.$this->input->get('active');
                        }else if ($this->input->get('active') == '0') {
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'cm.active = '.$this->input->get('active');
                        }


                $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID == 2){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'cm.airline_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';                        
                }



$sQuery = " SELECT SQL_CALC_FOUND_ROWS cabin_map_id,  ac.code as airline_code , ac.aln_data_value as a_code, 
        acl.aln_data_value as airline_cabin, video_links, cm.active , cr.aln_data_value as aircraft_name
        from VX_aln_airline_cabin_map cm 
        LEFT JOIN vx_aln_data_defns ac on (ac.vx_aln_data_defnsID = cm.airline_code) 
        LEFT JOIN  vx_aln_data_defns acl on (acl.vx_aln_data_defnsID = cm.airline_cabin)
        LEFT JOIN  vx_aln_data_defns cr on (cr.vx_aln_data_defnsID = cm.aircraft_id)
 $sWhere $sOrder $sLimit";
                $rResult = $this->install_m->run_query($sQuery);
                $sQuery = "SELECT FOUND_ROWS() as total";
                $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                $airlinecabinsmapcnt = $this->airline_cabin_m->get_airline_cabin_map_count();

                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $airlinecabinsmapcnt,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
            );

		

                foreach($rResult as $list){
			$list->img_cnt = $this->airline_cabin_m->getImagesCount($list->cabin_map_id);
                        if(permissionChecker('airline_cabin_edit') ) {
				$list->action = btn_edit('airline_cabin/edit/'.$list->cabin_map_id, $this->lang->line('edit'));
			}
			
			if (permissionChecker('airline_cabin_view') ) {
			       $list->action .= btn_view('airline_cabin/view/'.$list->cabin_map_id, $this->lang->line('view'));	
			}

			if (permissionChecker('airline_cabin_delete') ) {                                        				
			 $list->action .= btn_delete('airline_cabin/delete/'.$list->cabin_map_id, $this->lang->line('delete'));

			}

			$status = $list->active;
			
                        $list->active = "<div class='onoffswitch-small' id='".$list->cabin_map_id."'>";
            $list->active .= "<input type='checkbox' id='myonoffswitch".$list->cabin_map_id."' class='onoffswitch-small-checkbox' name='paypal_demo'";
                        if($status){
                           $list->active .= "checked='checked' >";
                        } else {
                           $list->active .= ">";
                        }
                        $list->active .= "<label for='myonoffswitch".$list->cabin_map_id."' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";

		if ( !empty($list->video_links) ){
			$list->videos = $list->video_links;
		  $links = explode(',', $list->video_links );
			$list->video_links = '';
			foreach ($links as $k=>$link) {
				$num = $k + 1;
				$list->video_links .= '<a target="_new" href="'.$link.'" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs">Link'.$num.'</a> &nbsp;';
			}
		}
                        $output['aaData'][] = $list;

                }
               if(isset($_REQUEST['export'])){
				  $columns = array('#','Airline Name','Aircraft','Cabin','Image Count','Video Links');
				  $rows = array("cabin_map_id","airline_code","aircraft_name","airline_cabin","img_cnt","videos");
				  $this->exportall($output['aaData'],$columns,$rows);		
				} else {	
				  echo json_encode( $output );
				}
        }

 public function getAirlineCabinByName(){
                $search = $this->input->post('search');
                if($search){
                $cabins = $this->airline_cabin_m->getAirlineCabinsByName($search);
                } else {
                $cabins = array();
                }
                $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($cabins));
        }


public function getAircraftTypes(){
        $id = $this->input->post('id');
        if ( isset($id)){
                $result = $this->airline_m->getAirCraftTypesList($id);
                        foreach ($result as $defns) {
                                echo "<option value=\"$defns->aircraftID\">",$defns->aln_data_value,"</option>";
                        }
        }
   }

	
   public function getAircrafts(){
        $id = $this->input->post('id');
        if ( isset($id)){
                $result = $this->airports_m->getDefns('16',$id);
                        foreach ($result as $defns) {
                                echo "<option value=\"$defns->vx_aln_data_defnsID\">",$defns->aln_data_value,"</option>";
                        }
        }
   }



}

/* End of file user.php */
/* Location: .//D/xampp/htdocs/school/mvc/controllers/user.php */
