<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends Admin_Controller {

	function __construct() {
		parent::__construct();	
        $this->load->model('partner_m');
        $this->load->model('airline_m');
        $this->load->model('airports_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('partner', $language);			
    }
    
    protected function rules() {
		$rules = array(
            array(
                'field' => 'partner_carrierID',
                'label' => $this->lang->line("partner_carrier"),
                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
                ),			
			array(
				'field' => 'origin_level',
				'label' => $this->lang->line("partner_origin_level"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
            ),
            array(
                'field' => 'origin_content[]',
                'label' => $this->lang->line("partner_origin_content"),
                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateContent'
            ),
            array(
				'field' => 'dest_level',
				'label' => $this->lang->line("partner_destination_level"),
				'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateLevel'
            ),
            array(
                'field' => 'dest_content[]',
                'label' => $this->lang->line("partner_destination_content"),
                'rules' => 'trim|required|max_length[200]|xss_clean|callback_validateContent'
            ),
            array(
                'field' => 'start_date',
                'label' => $this->lang->line("partner_start_date"),
                'rules' => 'trim|required|xss_clean|max_length[60]'  
            ),
            array(
                'field' => 'end_date',
                'label' => $this->lang->line("partner_end_date"),
                'rules' => 'trim|required|xss_clean|max_length[60]'  
            ),          

		);
		return $rules;
    }
    
    function validateLevel($post_string){
        if($post_string == '0'){
               $this->form_validation->set_message("validateLevel", "%s is required");
                return FALSE;
         }else{
                return TRUE;
         }
      }

    function validateContent($post_array){
        if(count($post_array) < 1){
               $this->form_validation->set_message("validateContent", "%s is required");
                return FALSE;
         }else{
                return TRUE;
         }
    }         

	public function index() {        
        $userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');
	
        $this->data['airlines'] = $this->airline_m->getAirlinesData();
        $this->data["subview"] = "partner/index";
		$this->load->view('_layout_main', $this->data);
    }

    public function add(){
        $this->data['headerassets'] = array(
            'css' => array(
                    'assets/select2/css/select2.css',
                    'assets/select2/css/select2-bootstrap.css',
                    'assets/dist/themes/default/style.min.css',
                    'assets/datepicker/datepicker.css',
            ),
            'js' => array(
                    'assets/treeview/simpleTree.js',
                    'assets/select2/select2.js',
                    'assets/dist/jstree.min.js',
                    'assets/datepicker/datepicker.js',
            )
        );
        $userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');	
        $this->data['airlines'] = $this->airline_m->getAirlinesData();
        $types = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
        foreach($types as $type){
          $this->data['aln_datatypes'][$type->vx_aln_data_typeID] = $type->alias;
        }
        if($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "partner/add";
                $this->load->view('_layout_main', $this->data);
            } else { 
                $array['carrierID'] = $this->session->userdata('login_user_airlineID')[0];               
                $array["partner_carrierID"] = $this->input->post("partner_carrierID");
                $array["origin_level"] = $this->input->post("origin_level");
			    $array["origin_content"] =  implode(',',$this->input->post("origin_content"));
                $array["dest_level"] = $this->input->post("dest_level");
			    $array["dest_content"] = implode(',',$this->input->post("dest_content"));
                $array["start_date"] = strtotime($this->input->post("start_date"));
			    $array["end_date"] =  strtotime($this->input->post("end_date"));
                $array["create_date"] = time();
                $array["modify_date"] = time();
			    $array["create_userID"] = $this->session->userdata('loginuserID');
			    $array["modify_userID"] = $this->session->userdata('loginuserID');
                $this->partner_m->insert_partner($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("partner/index"));
            }
        } else {
            $this->data["subview"] = "partner/add";
            $this->load->view('_layout_main', $this->data);
        }        
    }

    public function edit(){
        $this->data['headerassets'] = array(
            'css' => array(
                    'assets/select2/css/select2.css',
                    'assets/select2/css/select2-bootstrap.css',
                    'assets/dist/themes/default/style.min.css',
                    'assets/datepicker/datepicker.css',
            ),
            'js' => array(
                    'assets/treeview/simpleTree.js',
                    'assets/select2/select2.js',
                    'assets/dist/jstree.min.js',
                    'assets/datepicker/datepicker.js',
            )
        );
        $userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');	
        $this->data['airlines'] = $this->airline_m->getAirlinesData();
        $types = $this->airports_m->getDefdataTypes(null,array(1,2,3,4,5,17));
        foreach($types as $type){
          $this->data['aln_datatypes'][$type->vx_aln_data_typeID] = $type->alias;
        }
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $this->data['partner'] = $this->partner_m->get_single_partner(array('partnerID' => $id));
            if($this->data['partner']) {
                if($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "partner/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else {                       
                        $data["partner_carrierID"] = $this->input->post("partner_carrierID");
                        $data["origin_level"] = $this->input->post("origin_level");
                        $data["origin_content"] =  implode(',',$this->input->post("origin_content"));
                        $data["dest_level"] = $this->input->post("dest_level");
                        $data["dest_content"] = implode(',',$this->input->post("dest_content"));
                        $data["start_date"] = strtotime($this->input->post("start_date"));
                        $data["end_date"] =  strtotime($this->input->post("end_date"));
                        $data["modify_date"] = time();
                        $data["modify_userID"] = $this->session->userdata('loginuserID');
                        $this->partner_m->update_partner($data,$id);
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("partner/index"));
                    }
                } else {
                    $this->data["subview"] = "partner/edit";
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

    function server_processing(){		
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');
	   
	    $aColumns = array('MainSet.partnerID','MainSet.carrier_code','MainSet.partner_carrier_code','MainSet.origin_level_value','SubSet.origin_content_data','MainSet.dest_level_value','SubSet.dest_content_data','MainSet.start_date','MainSet.end_date');
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
						
						 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
							".$_GET['sSortDir_'.$i] .", ";
						
					}
				}				
				  $sOrder = substr_replace( $sOrder, "", -2 );
				
				if ( $sOrder == "ORDER BY" )
				{
					$sOrder = "";
				}
			}
			$sWhere = "";
			
			if ( $_GET['sSearch'] != "" )	{
				
						$sWhere .= " AND (";
				
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

          /* if($this->input->get('airlineID')){  
              $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
			  $sWhere .= 'c.airlineID = '.$this->input->get('airlineID');		
            } */		   
		  
		 // $sGroup = " GROUP BY d.vx_aln_data_defnsID ";  
         $sQuery = "SELECT SQL_CALC_FOUND_ROWS MainSet.partnerID,MainSet.carrier_code,MainSet.partner_carrier_code,MainSet.start_date,MainSet.end_date,
                    MainSet.origin_level_value,MainSet.dest_level_value,SubSet.origin_content_data,SubSet.dest_content_data
                    FROM
                    (
                        SELECT p.partnerID,p.start_date,p.end_date,ddc.code as carrier_code,ddpc.code as partner_carrier_code,dto.alias as origin_level_value,dtd.alias as dest_level_value   
                        from VX_partner p 
                        LEFT JOIN VX_data_types dto on (dto.vx_aln_data_typeID = p.origin_level) 
                        LEFT JOIN VX_data_types dtd on (dtd.vx_aln_data_typeID = p.dest_level)         
                        LEFT JOIN VX_data_defns ddc ON ddc.vx_aln_data_defnsID = p.carrierID
                        LEFT JOIN VX_data_defns ddpc ON ddpc.vx_aln_data_defnsID = p.partner_carrierID
                    ) as MainSet
                    LEFT JOIN (
                        SELECT 	origin_set.partnerID,origin_set.origin_content_data,dest_set.dest_content_data 
                        FROM (  
                        SELECT p.partnerID,COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(m.market_name) ) AS origin_content_data FROM VX_partner p 
                        LEFT OUTER JOIN  VX_data_defns c ON 
                        (find_in_set(c.vx_aln_data_defnsID, p.origin_content) AND p.origin_level in (1,2,3,4,5)) 
                        LEFT OUTER JOIN  VX_market_zone m  
                        ON (find_in_set(m.market_id, p.origin_content) AND p.origin_level = 17)
                        ) as origin_set
                    
                        LEFT JOIN (
                            SELECT p.partnerID,COALESCE(group_concat(c.code),group_concat(c.aln_data_value),group_concat(m.market_name)) AS dest_content_data FROM VX_partner p 
                            LEFT OUTER JOIN  VX_data_defns c ON 
                            (find_in_set(c.vx_aln_data_defnsID, p.dest_content) AND p.dest_level in (1,2,3,4,5)) 
                            LEFT OUTER JOIN  VX_market_zone m  
                            ON (find_in_set(m.market_id, p.dest_content) AND p.dest_level = 17)
                        ) as dest_set
                        ON origin_set.partnerID = dest_set.partnerID    
                    ) as SubSet
                    on MainSet.partnerID = SubSet.partnerID
		           $sWhere				  
				   $sOrder		
				   $sLimit";					
		
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
	  $i=1;
	  foreach($rResult as $partner){		 	
		  if(permissionChecker('partner_edit')){ 			
			$partner->action = btn_edit('partner/edit/'.$partner->partnerID, $this->lang->line('edit'));				
		  }
		  if(permissionChecker('partner_delete')){
		   $partner->action .= btn_delete('partner/delete/'.$partner->partnerID, $this->lang->line('delete'));			 
		  }
		  $partner->sno = $i;	   
			$partner->start_date = date('d-m-Y',$partner->start_date);
			$partner->end_date = date('d-m-Y',$partner->end_date);
            $output['aaData'][] = $partner;	
            $i++;			
		}
		if(isset($_REQUEST['export'])){
		  $columns = array('#','Carrier','Product','Start Date','End Date');
		  $rows = array('contractID','code','name','start_date','end_date');
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}
    }
    
    public function delete() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$this->partner_m->delete_partner($id);
			$this->session->set_flashdata('success', $this->lang->line('menu_success'));
			redirect(base_url("partner/index"));
		} else {
			redirect(base_url("partner/index"));
		}
	}

}