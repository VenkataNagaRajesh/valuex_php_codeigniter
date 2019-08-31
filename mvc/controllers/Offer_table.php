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
		$this->load->model("user_m");
		$this->load->library('email');
		$this->load->model('invfeed_m');
		$this->load->model("reset_m");
		$this->load->model("airline_m");
		$this->load->model('acsr_m');
		$this->load->model("airports_m");
		$this->load->model('bid_m');
		$language = $this->session->userdata('lang');		
		$this->lang->load('offer_table', $language);
			
	}	
	

        public function view() {
                $id = htmlentities(escapeString($this->uri->segment(3)));
		$return = htmlentities(escapeString($this->uri->segment(4)));
		if($return == 'return'){
			 $return = htmlentities(escapeString($this->uri->segment(5)));
		} else {
			$return = 'offer_table';
		}

			$this->data["return"] = $return;
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


	$userID = $this->session->userdata('loginuserID');
                $userTypeID = $this->session->userdata('usertypeID');
                if($userTypeID == 2){
                        $this->data['carriers'] = $this->airline_m->getClientAirline($userID);
                           }else if($userTypeID != 1){
						 $this->data['carriers'] = $this->user_m->getUserAirlines($userID);	   
						   } else {
                   $this->data['carriers'] = $this->airline_m->getAirlinesData();
                }
				
				 if($this->input->post('carrier')){
				   $this->data['car'] = $this->input->post('carrier');
				 } else {
				   if($userTypeID != 1){
					 $this->data['car'] = $this->session->userdata('default_airline');
				   } else {
					 $this->data['car'] = 0;
				   }
                 }

                $this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1');
		$this->data['cabins'] =  $this->airports_m->getDefnsCodesListByType('13');
		$this->data['status'] =  $this->airports_m->getDefnsListByType('20');

		$this->data["subview"] = "offer_table/index";
		$this->load->view('_layout_main', $this->data);
	}


function processbid() {
$offer_id = htmlentities(escapeString($this->uri->segment(3)));
$flight_number = htmlentities(escapeString($this->uri->segment(4)));
$status = htmlentities(escapeString($this->uri->segment(5)));
 
$this->data['siteinfos'] = $this->reset_m->get_site();
  $passenger_data = $this->offer_issue_m->getPassengerData($offer_id,$flight_number);
 // get cabin from BID tablee
 $offer_data = $this->offer_issue_m->getBidInfoFromOfferID($offer_id,$flight_number);
  $upgrade_cabin =  $offer_data->upgrade_type;

$namelist = explode(',',$passenger_data->passengers);
                        $emails_list =  explode(',',$passenger_data->emails);

                        $passenger_cnt =  count($namelist);

// update inv feed data about processed seats count

	if ( $status == 'accept' ) {

        $inv = array();
        $inv['flight_nbr'] = $flight_number;
        $inv['airline_id'] = $passenger_data->carrier_code;
        $inv['departure_date'] = $passenger_data->dep_date;
        $inv['origin_airport'] = $passenger_data->from_city;
        $inv['dest_airport'] = $passenger_data->to_city;
        $inv['cabin'] = $upgrade_cabin;
        $inv['active'] = 1;
        $seats_data = $this->invfeed_m->getEmptyCabinSeats($inv);
        
        $sold_seats = $seats_data->sold_seats + $passenger_cnt;
	$upd['sold_seats'] = $sold_seats;
	 $upd["modify_userID"] = $this->session->userdata('loginuserID');
	$upd['modify_date'] = time();
        $this->invfeed_m->update_entries($upd,$inv);

//accept 
		$bid_status = 'bid_accepted';
		$msg_txt = "Bid is accepted";
		$template ="home/upgradeoffertmp";
	} else if ( $status == 'reject' ) { 
		$bid_status = 'bid_reject';	
		$msg_txt = 'Bid is rejected';
		$template ="home/bidreject-temp";	
	} else {
		$this->session->set_flashdata('error', 'No Action Status');
        	redirect(base_url("offer_table/view/".$offer_id));

	}


// $offer_data = $this->bid_m->get_offer_data($offer_id);
 $card_data = $this->bid_m->getCardData($offer_id);
   $card_number = substr(trim($card_data->card_number), -4);
   $maildata = array(
        'first_name'   => $namelist[0],
        'last_name' => '',
        'tomail' => $emails_list[0],
        'pnr_ref' => $passenger_data->pnr_ref,
        'mail_subject' => $msg_txt . " For Flight: ". $passenger_data->carrier_c . $flight_number,
        'card_number' => $card_number,
        'cash_paid' => $offer_data->cash,
        'miles_used' => $offer_data->miles,
        'flight_no' => $passenger_data->carrier_c.$passenger_data->flight_number,
        'dep_date' => date('d-m-Y',$passenger_data->dep_date),
        'dep_time' => gmdate('H:i A',$passenger_data->dept_time),
        'origin' => $passenger_data->from_city_name,
        'destination' => $passenger_data->to_city_name,
        'upgrade_to' => $offer_data->upgrade_cabin_name
   );
//var_dump($maildata);exit;
                                                                                                 $message = '
        <html>
        <body>
        <div style="max-width: 800px; margin: 0; padding: 30px 0;">
        <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
<td width="5%"></td>
        <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: orange;">Hello '.$namelist[0].'!</h2>
 ' .$msg_txt.'<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b style="color: orange;">Details:</b></big><br />
<br />
PNR Reference : <b style="color: blue;">'.$passenger_data->pnr_ref.'</b> <br />

<br />
<br />
<br />
</td>
</tr>
</table>

</div>
</body>
</html>
';

 /*  $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
//                         $this->email->from('testsweken321@gmail.com', 'ADMIN');
                         $this->email->to($emails_list[0]);
                         $this->email->subject($msg_txt . " For Flight: " . $flight_number);
                        $this->email->message($message);
                        $this->email->send(); */
				
					if($template){
					  $this->sendMailTemplateParser($template,$maildata);
					}	

                         $array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias($bid_status,'20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');

                        // update extension table with new status
                        $p_list = explode(',',$passenger_data->p_list);
                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);

		 	 $this->session->set_flashdata('success', $msg_txt);
                            redirect(base_url("offer_table/view/".$offer_id));

}
	
 function server_processing(){
                $userID = $this->session->userdata('loginuserID');
                $usertypeID = $this->session->userdata('usertypeID');



            $aColumns = array('MainSet.offer_id','MainSet.offer_id','MainSet.offer_date', 'SubSet.carrier','MainSet.flight_number', 'SubSet.flight_date' , 'SubSet.from_city', 'SubSet.to_city', 'SubSet.from_cabin','MainSet.to_cabin', 'MainSet.bid_value','MainSet.bid_submit_date','SubSet.p_list','SubSet.fqtv','MainSet.pnr_ref','1','MainSet.bid_avg','MainSet.rank','MainSet.cash', 'MainSet.miles','MainSet.offer_status','SubSet.from_city_name', 'SubSet.to_city_name');

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
                                $sWhere .= 'MainSet.flight_number >= '.$this->input->get('flightNbr');
                        }


                        if(!empty($this->input->get('flightNbrEnd'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.flight_number <= '.$this->input->get('flightNbrEnd');
                        }


                        if(!empty($this->input->get('depStartDate'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'flight_date >= '. strtotime($this->input->get('depStartDate'));
                        }
                        if(!empty($this->input->get('depEndDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'flight_date <= '.  strtotime($this->input->get('depEndDate'));
                        }
                        if(!empty($this->input->get('fromCabin'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'from_cabin_id = '. $this->input->get('fromCabin');
                        }
                        if(!empty($this->input->get('toCabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
		                $sWhere .= 'upgrade_type = '.  $this->input->get('toCabin');
                        }

			 if(!empty($this->input->get('toCabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'upgrade_type = '.  $this->input->get('toCabin');
                        }



                        if(!empty($this->input->get('offer_status'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.booking_status = '.  $this->input->get('offer_status');
                        }


		       if(!empty($this->input->get('pnr_ref'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.pnr_ref = "'.  $this->input->get('pnr_ref') . '"';
                        }


			 if(!empty($this->input->get('offer_id'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.offer_id = '.  $this->input->get('offer_id');
                        }

                         if(!empty($this->input->get('carrier'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'SubSet.carrier_code = '.  $this->input->get('carrier');
                        }

                $userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID != 1){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'SubSet.carrier_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';                
                }


		


$sQuery = " select  SQL_CALC_FOUND_ROWS  
                        MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , MainSet.flight_number , 
                        SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.p_list, SubSet.from_cabin,
                        MainSet.to_cabin, MainSet.bid_value  , SubSet.fqtv, MainSet.cash, MainSet.miles, MainSet.offer_status,
			SubSet.from_cabin_id, MainSet.upgrade_type, SubSet.boarding_point, SubSet.off_point, MainSet.bid_submit_date, MainSet.booking_status, SubSet.from_city_name, SubSet.to_city_name,MainSet.bid_avg, MainSet.rank, MainSet.bid_markup_val,SubSet.carrier_code

                FROM ( 
                                select distinct oref.offer_id, oref.create_date as offer_date ,bid_value, bid_avg,bid_markup_val,
                                tcab.code as to_cabin, oref.pnr_ref, bid.flight_number,bid.cash, bid.miles  , bid.upgrade_type,bs.aln_data_value as offer_status, bid_submit_date, pe.booking_status, rank
                                from  
                                        VX_aln_offer_ref oref 
                                        INNER JOIN VX_aln_bid bid on (bid.offer_id = oref.offer_id) 
                                        LEFT JOIN vx_aln_data_defns tcab on (tcab.vx_aln_data_defnsID = upgrade_type AND tcab.aln_data_typeID = 13)

                                        INNER JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref 
                                                        and pf.flight_number = bid.flight_number) 
                                        INNER JOIN VX_aln_dtpf_ext pe on ( pe.dtpf_id = pf.dtpf_id ) 
                                         INNER JOIN VX_aln_fare_control_range fclr on (pe.fclr_id = fclr.fclr_id AND fclr.to_cabin = bid.upgrade_type)
					  LEFT JOIN vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pe.booking_status AND bs.aln_data_typeID = 20) 
                     ) as MainSet 

                        
                       INNER  JOIN (
                                        select  flight_number,group_concat(distinct first_name, ' ' , last_name , ' fqtv: ' , fqtv SEPARATOR '<br>'  ) as p_list ,group_concat(distinct fqtv) as fqtv,
                                                group_concat(distinct dep_date) as flight_date  ,
                                                pnr_ref, 
                                                group_concat(distinct cab.code) as from_cabin  , fc.code as from_city, 
						tc.code as to_city, from_city as boarding_point , to_city as off_point, 
						fc.aln_data_value as from_city_name, tc.aln_data_value as to_city_name,
						 group_concat(distinct pf1.cabin) as from_cabin_id, 
                                                 car.code as carrier, pf1.carrier_code
                                        
                                        from VX_aln_daily_tkt_pax_feed pf1 
                                        LEFT JOIN vx_aln_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                        LEFT JOIN vx_aln_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
                                        LEFT JOIN vx_aln_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13)
                                        LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12)
					where pf1.is_processed = 1   
                                        group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code
                   ) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND MainSet.flight_number = SubSet.flight_number ) 
 $sWhere 
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
		       $i = 1;
		 $rownum = 1 + $_GET['iDisplayStart'];
                foreach ($rResult as $feed ) {
			$feed->sno = $rownum;
			$rownum++;
			$feed->miles = number_format($feed->miles);
                        $feed->flight_date = date('d-m-Y',$feed->flight_date);
			$feed->bid_submit_date =  date('d-m-Y H:i:s',$feed->bid_submit_date);
			$feed->offer_date = date('d-m-Y',$feed->offer_date);
			$feed->p_count = count(explode('<br>',$feed->p_list));
			$feed->pp_list = str_replace('<br>',',' ,$feed->p_list);
			$feed->p_list = '<a href="#" style="color:blue;"  data-placement="top" data-toggle="tooltip" data-original-title="'.$feed->p_list.'">'.$feed->p_count.'</a>';

			$feed->action = btn_view('offer_table/view/'.$feed->offer_id, $this->lang->line('view'));
                                $output['aaData'][] = $feed;
            $feed->id = $i;
			 $i++;
                }

           if(isset($_REQUEST['export'])){
		  $columns = array("id","Offer Date","Carrier","Flight Number","Flight Date","Board Point","Off Point","Current cabin","Bid Cabin","Bid Amount","Submit Date","PAX Names","PNR Reference","Number In Party","Average Fare","Markup Value","Rank","cash","miles","offer status");
		  $rows = array("id","offer_date","carrier","flight_number","flight_date","from_city","to_city","from_cabin","to_cabin","bid_value","bid_submit_date","pp_list","pnr_ref","p_count","bid_avg","bid_markup_val","rank","cash","miles","offer_status");
		  $this->exportall($output['aaData'],$columns,$rows);		
		} else {	
		  echo json_encode( $output );
		}

	}


}
