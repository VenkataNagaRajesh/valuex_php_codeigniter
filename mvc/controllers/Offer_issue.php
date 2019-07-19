<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_issue extends Admin_Controller {

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
		$this->load->model("bid_m");
		$language = $this->session->userdata('lang');		
		$this->lang->load('offer', $language);		
	}	
	

        public function view() {
                $id = htmlentities(escapeString($this->uri->segment(3)));

                if ((int)$id) {
                        $this->data["ofr"] = $this->offer_issue_m->getOfferDetailsForIssue($id);

                        if($this->data["ofr"]) {
                                $this->data["subview"] = "offer/view";
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
		$this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1');
                $this->data['cabins'] =  $this->airports_m->getDefnsCodesListByType('13');

	$this->data["subview"] = "offer/index";
                $this->load->view('_layout_main', $this->data);


}
	public function run_offer_issue() {
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



		$this->data['siteinfos'] = $this->reset_m->get_site();
	
/*		$sQuery = " select group_concat(distinct pfe.dtpfext_id) as pf_list , group_concat(first_name,' ', last_name SEPARATOR ';') as pax_names , booking_status, pnr_ref , flight_number, carrier_code, from_city,to_city,dep_date, dep_time, arrival_time, fci.aln_data_value as from_city_name , tci.aln_data_value as to_city_name, group_concat(distinct pfe.fclr_id)  as fclr_list ,group_concat(pax_contact_email) as email_list , cab.aln_data_value as cabin from VX_aln_dtpf_ext pfe LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_aln_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN vx_aln_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  cab on (cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13) where  dd.alias = 'new'  group by tpf.pnr_ref, flight_number, carrier_code, from_city, to_city ,dep_date,booking_status, from_city_name, to_city_name, dep_time, arrival_time, cabin";*/
		$sQuery = " select tpf.pnr_ref, booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(pax_contact_email) as email_list, group_concat(first_name,' ', last_name SEPARATOR ';') as pax_names from VX_aln_dtpf_ext pfe LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_aln_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN vx_aln_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  cab on (cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13) where  tpf.is_processed = 1 and tpf.active = 1  AND dd.alias = 'new'  group by tpf.pnr_ref ,  booking_status";

		$rResult = $this->install_m->run_query($sQuery);

	 	foreach($rResult as $offer) {

			$p_list = explode(',',$offer->pf_list);
			$namelist = explode(';',$offer->pax_names);
			$emails_list = explode(',', $offer->email_list);

			$coupon_code = $this->generateRandomString(6);

			//echo $coupon_code;exit;
			$array = array();
			//$array['coupon_code'] = $this->offer_eligibility_m->hash($coupon_code);
			$array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
			$array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');

			
			// update extension table with new status

			$this->offer_eligibility_m->update_dtpfext($array,$p_list);
	
			$ref['pnr_ref'] = $offer->pnr_ref;
			$ref['coupon_code'] = $this->offer_eligibility_m->hash($coupon_code);
			$ref['offer_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
			$ref["create_date"] = time();
                        $ref["modify_date"] = time();
                        $ref["create_userID"] = $this->session->userdata('loginuserID');
                        $ref["modify_userID"] = $this->session->userdata('loginuserID');

			$this->offer_reference_m->insert_offer_ref($ref);//offer update ref table
			
			// update tracker about change in status
			$tracker = array();
				$tracker['booking_status_from'] = $offer->booking_status;
				$tracker['booking_status_to'] = $array['booking_status'];
				$tracker['comment'] = 'Sent Offer Email';
			        $tracker["create_date"] = time();
                                $tracker["modify_date"] = time();
                                $tracker["create_userID"] = $this->session->userdata('loginuserID');
                                $tracker["modify_userID"] = $this->session->userdata('loginuserID');
			//	var_dump($p_list);exit;

				foreach($p_list as $id) {
					$tracker['dtpfext_id'] = $id;
                                	$this->offer_issue_m->insert_dtpf_tracker($tracker);
				}
				

				 // send email
				 $message = '
	<html>
	<body>
	<div style="max-width: 800px; margin: 0; padding: 30px 0;">
	<table width="80%" border="0" cellpadding="0" cellspacing="0">
	<tr>
<td width="5%"></td>
	<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: orange;">Hello '.$namelist[0].'!</h2>
Thankyou for booking with us. We are pleased to inform you that you are eligible to bid for higer cabin upgrade and
experience our luxury products and services.<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b style="color: orange;">Details:</b></big><br />
<br />
PNR Reference : <b style="color: blue;">'.$offer->pnr_ref.'</b>  Coupon Code :<b style="color: blue;">'.$coupon_code.'</b><br />
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
			// $this->email->from('testsweken321@gmail.com', 'ADMIN');
			 $this->email->to($emails_list[0]);
			 $this->email->subject("Upgrade Cabin Offer");
			$this->email->message($message);
			$this->email->send(); */
			
	
       $data = array(
        'first_name'   => $namelist[0],
        'last_name' => '',
		'tomail' => $emails_list[0],
		'pnr_ref' => $offer->pnr_ref,
        'coupon_code' => $coupon_code, 		
		'mail_subject' => "Upgrade Cabin Offer"		
        ); 	   
	  $this->sendMailTemplateParser('home/testtemplate',$data);	

		}	
		
		$this->data["subview"] = "offer/index";
		$this->load->view('_layout_main', $this->data);
	}


	
 public  function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($this->offer_eligibility_m->checkForUniqueCouponCode($randomString)){
                return $randomString;  // to decode  $this->encrypt->decode($encrypt_key);
        } else {
                $this->generateRandomString(6);
        }
    }


 function server_processing(){
                $userID = $this->session->userdata('loginuserID');
                $usertypeID = $this->session->userdata('usertypeID');



            $aColumns = array('offer_id','SubSet.passenger_list','pnr_ref','SubSet.from_city', 'SubSet.to_city','SubSet.flight_date',
				'SubSet.carrier', 'SubSet.flight_number','SubSet.from_city_name', 'SubSet.to_city_name');

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
                                $sWhere .= 'SubSet.from_city_code = '.$this->input->get('boardPoint');
                        }
                        if(!empty($this->input->get('offPoint'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'SubSet.to_city_code = '.$this->input->get('offPoint');
                        }

			if(!empty($this->input->get('flightNbr'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'SubSet.flight_number >= '.$this->input->get('flightNbr');

                        }


                        if(!empty($this->input->get('flightNbrEnd'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'SubSet.flight_number <= '.$this->input->get('flightNbrEnd');
                        }


                        if(!empty($this->input->get('depStartDate'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'SubSet.flight_date >= '. strtotime($this->input->get('depStartDate'));
                        }
                        if(!empty($this->input->get('depEndDate'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'SubSet.flight_date <= '.  strtotime($this->input->get('depEndDate'));
                        }
                        if(!empty($this->input->get('fromCabin'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'from_cabin = '. $this->input->get('fromCabin');
                        }
                        if(!empty($this->input->get('toCabin'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'to_cabin = '.  $this->input->get('toCabin');
                        }





$sQuery = " 
 select  SQL_CALC_FOUND_ROWS  
                        MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , 
                        SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.passenger_list, SubSet.from_cabin,
                          MainSet.cash, MainSet.miles,  SubSet.carrier_code,  SubSet.from_city_code, SubSet.to_city_code, MainSet.cash_percentage, SubSet.flight_number, SubSet.from_city_name, SubSet.to_city_name

                FROM (  select distinct oref.offer_id, oref.create_date as offer_date , oref.pnr_ref,oref.cash_percentage, oref.cash, oref.miles from  VX_aln_offer_ref oref  
                     ) as MainSet 
                        INNER JOIN (
                                        select  flight_number,
                                                group_concat(distinct dep_date) as flight_date  ,
                                                pnr_ref,group_concat(first_name, ' ' , last_name SEPARATOR '<br>' ) as passenger_list ,  from_city as from_city_code, to_city as to_city_code, 
                                                group_concat(distinct cab.aln_data_value) as from_cabin  , fc.aln_data_value as from_city_name, fc.code as from_city, tc.code as to_city, tc.aln_data_value as to_city_name,
                                                car.code as carrier , pf1.carrier_code
                                         from VX_aln_daily_tkt_pax_feed pf1 
                                        LEFT JOIN vx_aln_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18)
                                        LEFT JOIN vx_aln_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                        LEFT JOIN vx_aln_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
                                        LEFT JOIN vx_aln_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13)
                                        LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12)
                                        where pf1.is_processed = 1  
                                       group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code
                   ) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref ) 
$sWhere $sOrder $sLimit";


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
                foreach ($rResult as $feed ) {

                        $boarding_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->from_city_code));
                        $feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$boarding_markets.'">'.$feed->from_city.'</a>';
                         $dest_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->to_city_code));
                        $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$dest_markets.'">'.$feed->to_city.'</a>';
			
			$feed->booking_status = btn_view('offer_issue/view/'.$feed->offer_id, $this->lang->line('view'));
                        $feed->season_id = ($feed->season_id) ? $this->season_m->getSeasonNameByID($feed->season_id) : "default season";
                        $feed->departure_date = date('d-m-Y',$feed->flight_date);
			$feed->bid_info = btn_view('offer_table/view/'.$feed->offer_id, $this->lang->line('view'));

                                $output['aaData'][] = $feed;

                }


                echo json_encode( $output );

	}

  function auto_acsr() {
	$this->load->model('preference_m');
	
	$days = $this->preference_m->get_preference_value_bycode('CONFIRM_WINDOW','7');
	$current_time = time();
	$tstamp = $current_time + ($days * 86400);

		// update is required if offer status is updated in VX_aln_offer_ref
		// for now considering offer status is updated in  PF records
		//
	$sQuery = "select pf.dep_date , pf.flight_number , pf.carrier_code , group_concat(distinct offer_id) as offer_list  
			from VX_aln_offer_ref oref 
			INNER JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref and pf.is_processed = 1 and pf.active = 1)
			INNER JOIN VX_aln_dtpf_ext pext on (pext.dtpf_id = pf.dtpf_id)
			INNER JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pext.booking_status AND dd.aln_data_typeID = 20)
			WHERE pf.dep_date >= ".$current_time. " AND pf.dep_date <= " . $tstamp  .
			" AND dd.alias != 'excl' AND pext.exclusion_id = 0 AND 
			dd.alias = 'bid_complete'  group by pf.flight_number, pf.carrier_code, pf.dep_date  order by pf.flight_number"; 

	//var_dump($sQuery);exit;
	$rResult = $this->install_m->run_query($sQuery);
      

//	var_dump($rResult);exit;
	$full_offerlist = array();
	$partial_offerlist = array();	
	foreach($rResult as $data ) {
		$q = "select distinct rbd_markup, flight_number, from_city, to_city,tier_markup, (val + ((rbd_markup * val)/100)) as bid_val , offer_id,bid_submit_date , dep_date, upgrade_type, carrier_code, src_point,  dest_point, cabin,src_point_name, cash,carrier_name, miles, dest_poin_name, dept_time,upgrade_cabin, cash_per FROM (
             SELECT (bid_value + ((pf.tier_markup * bid_value)/100)) as val,pf.dep_date,bid.upgrade_type,pf.flight_number,
             pf.rbd_markup, pf.tier_markup ,bid.offer_id,oref.cash cash,oref.miles miles, oref.cash_percentage as cash_per,bid_submit_date , pf.from_city, pf.to_city, pf.carrier_code, pf.cabin, df.code as src_point, dt.code as dest_point, df.aln_data_value src_point_name,dt.aln_data_value dest_poin_name, car.code as carrier_name, pf.dept_time, dcabin.aln_data_value as upgrade_cabin
             from VX_aln_bid bid
             LEFT JOIN VX_aln_offer_ref oref on (oref.offer_id = bid.offer_id )
             LEFT JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref  AND pf.flight_number = bid.flight_number AND  pf.is_processed = 1 and pf.active = 1 )
             LEFT JOIN vx_aln_data_defns df on (df.vx_aln_data_defnsID = pf.from_city and df.aln_data_typeID = 1)
             LEFT JOIN vx_aln_data_defns dt on (dt.vx_aln_data_defnsID = pf.to_city and dt.aln_data_typeID = 1)
             LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID = pf.carrier_code and car.aln_data_typeID = 12)
             LEFT JOIN vx_aln_data_defns dcabin on (dcabin.vx_aln_data_defnsID = bid.upgrade_type and dcabin.aln_data_typeID = 13)
             WHERE bid.offer_id IN (".$data->offer_list .") AND bid.flight_number = " .$data->flight_number .
          " ) as FirstSet order by bid_val desc,tier_markup desc , rbd_markup desc,cash_per desc,bid_submit_date asc"; 
		$offers =  $this->install_m->run_query($q);
		//var_dump($q);echo "<br><br>";
		//var_dump($offers); echo "<br><br>";exit;
		foreach ($offers as $feed ) {
			$passenger_data = $this->offer_issue_m->getPassengerData($feed->offer_id,$feed->flight_number);	
			//var_dump($passenger_data);exit;
			
			$inv = array();
                        $inv['flight_nbr'] = $data->flight_number;
                        $inv['airline_id'] = $data->carrier_code;
                        $inv['departure_date'] = $data->dep_date;
			$inv['cabin'] = $feed->upgrade_type;
			$inv['origin_airport'] = $feed->from_city; 
			$inv['dest_airport'] =  $feed->to_city;
			$inv['active'] = 1;
                        $seats_data = $this->invfeed_m->getEmptyCabinSeats($inv);
			$cabin_seats = $seats_data->empty_seats - $seats_data->sold_seats;
			
//echo "offerId: " . $feed->offer_id . "<br>";
//echo "seats:". $cabin_seats .  "<br> <br>";
			$namelist = explode(',',$passenger_data->passengers);
			$emails_list =  explode(',',$passenger_data->emails);

			$passenger_cnt =  count($namelist);
			
			$acsr = array();
			$acsr['from_city'] = $feed->from_city;
			$acsr['to_city'] = $feed->to_city;
			$acsr['flight_number'] = $feed->flight_number;
			$acsr['dep_date'] = $feed->dep_date;
			$acsr['from_cabin'] = $feed->cabin;
			$acsr['to_cabin'] = $feed->upgrade_type;
			$acsr['carrier_code'] = $feed->carrier_code;
                        $day_of_week = date('w', $feed->dep_date);
                      $day = ($day_of_week)?$day_of_week:7;

                        $p_freq =  $this->rafeed_m->getDefIdByTypeAndCode($day,'14'); //507;
                        $acsr['season_id'] =  $this->season_m->getSeasonForDateANDAirlineID($feed->dep_date,$feed->carrier_code,$feed->from_city,$feed->to_city); //0;

                        if($acsr['season_id'] == 0 ) {
                                $acsr['frequency'] = $p_freq;
                        }


			$acsr_data = $this->acsr_m->apply_acsr_rules($acsr);	
			$this->data['siteinfos'] = $this->reset_m->get_site();
		/*	echo "pnr ref: " . $passenger_data->pnr_ref;
			echo "<br>";
			echo "<br>status: " . $acsr_data->status ;
			echo "<br>bidval: " . $feed->bid_val;
			echo "<br>min bid price " . $acsr_data->min_bid_price;
			echo "<br> cabincnt = " .$cabin_seats;
			echo "<br>  passen cnt = " . $passenger_cnt;
			echo "<br> memp = " .  $acsr_data->memp;	
			echo "<br>";*/
			//var_dump($acsr_data);	echo "<br>";exit;
			if(($acsr_data->status == 'reject' && $feed->bid_val < $acsr_data->min_bid_price) ) {			
					// send mail min bid value not met
					// update pf entry status and VX_aln_offer_ref status as bid not accepted
		//		echo "rejected ---<br>";
					                           $message = '
        <html>
        <body>
        <div style="max-width: 800px; margin: 0; padding: 30px 0;">
        <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
<td width="5%"></td>
        <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: orange;">Hello '.$namelist[0].'!</h2>
 Your bid is rejected due to less bid price.<br />
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


                         $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
                         //$this->email->from('testsweken321@gmail.com', 'ADMIN');
                         $this->email->to($emails_list[0]);
                         $this->email->subject("Bid is rejected From " .$feed->src_point.' To ' . $feed->dest_point);
                        $this->email->message($message);
                        $this->email->send();

				 $array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('bid_cancel','20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');
			$p_list = explode(',',$passenger_data->p_list);

                        // update extension table with new status

                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);


			} else {
			/*
				echo $acsr_data->status . "<br>";
				echo $feed->bid_val . "<br>";
				echo $acsr_data->min_bid_price . "<br>";exit;*/
				if ( $acsr_data->status == 'accept' && $feed->bid_val > $acsr_data->min_bid_price ) { 

				  if (($cabin_seats -  $passenger_cnt) < $acsr_data->memp) {
					
					                                                                  $message = '
        <html>
        <body>
        <div style="max-width: 800px; margin: 0; padding: 30px 0;">
        <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
<td width="5%"></td>
        <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: orange;">Hello '.$namelist[0].'!</h2>
 Your bid is not processed due to non availability of seats.<br />
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


                         $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
                         //$this->email->from('testsweken321@gmail.com', 'ADMIN');
                         $this->email->to($emails_list[0]);
                         $this->email->subject("Bid is rejected, No seats avaiable  From " .$feed->src_point.' To ' . $feed->dest_point);
                        $this->email->message($message);
                        $this->email->send();

                                 $array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('no_seats','20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');
                        $p_list = explode(',',$passenger_data->p_list);


				   // update extension table with new status

                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);

				} else {
		//	echo "accepetd";

				// check preference before accepting for cutoff time.

			       $cabin_type = $this->airports_m->getDefDataCodeByIDANDType($feed->upgrade_type,'13');
				$cutoff_time = 0;
				if( $cabin_type == 'Y') {
					$cutoff_time  = $this->preference_m->get_preference_value_bycode('OFFER_ACPT_ECO','7');
				} else if ($cabin_type == 'W') {

					$cutoff_time  = $this->preference_m->get_preference_value_bycode('OFFER_ACPT_PEY','7');
				}

					$cutoff_time_in_secs = $cutoff_time * 3600 ;

				if( ($feed->dep_date - $current_time ) > $cutoff_time_in_secs ) {	
				//update sold seats or allocated seats in inv feed
					$update['sold_seats'] = $seats_data->sold_seats + $passenger_cnt;
					$update['modify_date'] = time();
                                        $update['modify_userID'] = $this->session->userdata('loginuserID');

					$this->invfeed_m->update_entries($update,$inv);
				
					// accept bid
					                                                         $message = '
        <html>
        <body>
        <div style="max-width: 800px; margin: 0; padding: 30px 0;">
        <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
<td width="5%"></td>
        <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: orange;">Hello '.$namelist[0].'!</h2>
 Your bid is accepted.<br />
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

/*
                          $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
                        //$this->email->from('testsweken321@gmail.com', 'ADMIN');
                         $this->email->to($emails_list[0]);
                         $this->email->subject("Bid is accepted From " .$feed->src_point.'To ' . $feed->dest_point);
                        $this->email->message($message);
                        $this->email->send(); /*
						  $cabin_name = $this->airports_m->get_definition_data($feed->upgrade_type)->aln_data_value;
                        $this->email->send(); */ 
						 
						 $card_data = $this->bid_m->getCardData($feed->offer_id);
						 $card_number = substr(trim($card_data->card_number), -4);
						 $e_data = array(
							'first_name'   => $namelist[0],
							'last_name' => '',
							'tomail' => $emails_list[0],
							'pnr_ref' => $passenger_data->pnr_ref,						
							'mail_subject' => "Bid is accepted From " .$feed->src_point." To " . $feed->dest_point,
							'card_number' => $card_number,
							'cash_paid' => $feed->cash,
							'miles_used' => $feed->miles,
							'flight_no' => $feed->carrier_name.$feed->flight_number,
							'dep_date' => date('d-m-Y',$feed->dep_date),
							'dep_time' => gmdate('H:i A',$feed->dept_time),
							'origin' => $feed->src_point_name,
							'destination' => $feed->dest_point_name, 
							'upgrade_to' => $feed->upgrade_cabin
                             							
						 ); 			 
					  $this->sendMailTemplateParser('home/upgradeoffertmp',$e_data);	

			 $array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');


                        // update extension table with new status
			$p_list = explode(',',$passenger_data->p_list);
                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);

	          } else {


                                                                                        $message = '
        <html>
        <body>
        <div style="max-width: 800px; margin: 0; padding: 30px 0;">
        <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
<td width="5%"></td>
        <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: orange;">Hello '.$namelist[0].'!</h2>
 Your bid offer is expired.<br />
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



		                         $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
                         //$this->email->from('testsweken321@gmail.com', 'ADMIN');
                         $this->email->to($emails_list[0]);
                         $this->email->subject("Bid Offer is expired  From " .$feed->src_point.'To ' . $feed->dest_point);
                        $this->email->message($message);
                        $this->email->send();

                         $array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('offer_expire','20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');


                        // update extension table with new status
                        $p_list = explode(',',$passenger_data->p_list);
                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);



		  }

		}

			}
				}



				}

			}
			
		redirect(base_url("offer_table/index"));


		}		
		

}
