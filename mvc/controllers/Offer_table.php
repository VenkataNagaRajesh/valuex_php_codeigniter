<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_table extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("airline_cabin_class_m");
		$this->load->model("offer_issue_m");
	        $this->load->model("offer_eligibility_m");
		$this->load->model('offer_reference_m');
		$this->load->model("eligibility_exclusion_m");
		$this->load->model("season_m");
		$this->load->model("marketzone_m");
		$this->load->model("fclr_m");
		$this->load->library('email');
		$this->load->model('invfeed_m');
		$this->load->model("reset_m");
		$this->load->model('acsr_m');
		$this->load->model("airports_m");
		$language = $this->session->userdata('lang');		
		 $this->lang->load('offer_table', $language);
		
	}	
	

        public function view() {
                $id = htmlentities(escapeString($this->uri->segment(3)));

                if ((int)$id) {
                        $this->data["ofr"] = $this->offer_issue_m->getOfferDetailsById($id);

                        if($this->data["ofr"]) {
                                $this->data["subview"] = "offer_table/view";
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

	
	public function index() {
        $this->data['headerassets'] = array(
                'css' => array(
                        'assets/select2/css/select2.css',
                        'assets/select2/css/select2-bootstrap.css',
                                                'assets/datepicker/datepicker.css'
                ),
                'js' => array(
                        'assets/select2/select2.js',
                                                'assets/datepicker/datepicker.js'
                )
        );

		$this->data["subview"] = "offer_table/index";
		$this->load->view('_layout_main', $this->data);
	}


	
 function server_processing(){
                $userID = $this->session->userdata('loginuserID');
                $usertypeID = $this->session->userdata('usertypeID');



            $aColumns = array('MainSet.offer_id');

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




                        if(!empty($this->input->get('boardPoint'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'boarding_point = '.$this->input->get('boardPoint');
                        }
                        if(!empty($this->input->get('offPoint'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'off_point = '.$this->input->get('offPoint');
                        }

			if(!empty($this->input->get('flightNbr'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pf.flight_number >= '.$this->input->get('flightNbr');
                        }


                        if(!empty($this->input->get('flightNbrEnd'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pf.flight_number <= '.$this->input->get('flightNbrEnd');
                        }


                        if(!empty($this->input->get('depStartDate'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pf.dep_date >= '. strtotime($this->input->get('depStartDate'));
                        }
                        if(!empty($this->input->get('depEndDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'pf.dep_date <= '.  strtotime($this->input->get('depEndDate'));
                        }
                        if(!empty($this->input->get('fromCabin'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'from_cabin = '. $this->input->get('fromCabin');
                        }
                        if(!empty($this->input->get('toCabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'to_cabin = '.  $this->input->get('toCabin');
                        }





 
$sQuery = "select  SQL_CALC_FOUND_ROWS  
			MainSet.offer_id, MainSet.offer_date, SubSet.flight_date ,MainSet.flight_number , 
			SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin,
			MainSet.to_cabin, MainSet.bid_value  , SubSet.fqtv, MainSet.cash, MainSet.miles, SubSet.offer_status  

		FROM ( 
				select distinct oref.offer_id, oref.create_date as offer_date ,bid_value, 
				tcab.aln_data_value as to_cabin, oref.pnr_ref, bid.flight_number,bid.cash, bid.miles  
				from  
					VX_aln_offer_ref oref 
					INNER JOIN VX_aln_bid bid on (bid.offer_id = oref.offer_id) 
					LEFT JOIN vx_aln_data_defns tcab on (tcab.vx_aln_data_defnsID = upgrade_type AND tcab.aln_data_typeID = 13)
					INNER JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref 
							and pf.flight_number = bid.flight_number) 
		     ) as MainSet 

			
			INNER JOIN (
					select  flight_number,group_concat(distinct fqtv) as fqtv ,
						group_concat(distinct dep_date) as flight_date  ,
						pnr_ref,group_concat(first_name, ' ' , last_name) as p_list , 
						group_concat(distinct cab.aln_data_value) as from_cabin  , fc.code as from_city, tc.code as to_city, 
						group_concat(distinct bs.aln_data_value) as offer_status  
					from VX_aln_daily_tkt_pax_feed pf1 
					LEFT JOIN VX_aln_dtpf_ext pext1 on (pext1.dtpf_id = pf1.dtpf_id )  
					LEFT JOIN vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pext1.booking_status AND bs.aln_data_typeID = 20) 
					LEFT JOIN vx_aln_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
					LEFT JOIN vx_aln_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
					LEFT JOIN vx_aln_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13)
					where pf1.is_processed = 1 AND  bs.alias != 'excl'  ". $sWhere. " 
					group by pnr_ref, from_city, to_city,flight_number
		   ) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number) 
		$sOrder $sLimit";


/*$sQuery = "   select ofr.pnr_ref,group_concat(distinct offer_id) as offer_id, group_concat(distinct first_name , ' ' , last_name SEPARATOR '<br>')  as list from VX_aln_offer_ref ofr  LEFT JOIN  VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = ofr.pnr_ref)  group by ofr.pnr_ref";
*/
//print_r($sQuery);exit;

        $rResult = $this->install_m->run_query($sQuery);
        $sQuery = "SELECT FOUND_ROWS() as total";
        $rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;
                $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $rResultFilterTotal,
                "iTotalDisplayRecords" => $rResultFilterTotal,
                "aaData" => array()
          );
		$i = 0;
                foreach ($rResult as $feed ) {
			$feed->cnt = ++$i;
			$feed->avg_fare = $feed->bid_value;;
                        $feed->flight_date = date('d-m-Y',$feed->flight_date);
			$feed->offer_date = date('d-m-Y',$feed->offer_date);
			$feed->p_count = count(explode(',',$feed->p_list));
			$feed->action = btn_view('offer_table/view/'.$feed->offer_id, $this->lang->line('view'));
                                $output['aaData'][] = $feed;

                }


                echo json_encode( $output );

	}


}
