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
		$this->load->model('airline_m');
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
		$this->load->model('preference_m');
		$this->load->model("user_m");
		$language = $this->session->userdata('lang');		
		$this->lang->load('offer', $language);  
     
	}	
	
	function testmail(){
//lakshmi.amujuru@sweken.com,sirisha.majji@sweken.com,swekenit@gmail.com,anitha.jeereddi@sweken.com	    
	  $data = array(
        'first_name'   => 'Lakshmi',
        'last_name' => 'Amujuru',
        'tomail' => 'lakshmi.amujuru@sweken.com',
        'pnr_ref' => 'BA1257',
        'coupon_code' => 'sssssssss',
        'mail_subject' => "upgrade offer template 2",
		'bidnow_link' => base_url('home/index'),
        'airlineID' => 5418		
        );			       
          //$this->sendMailTemplateParser('bid_accepted',$data);
		 // exit;
         //  $this->sendMailTemplateParser('home/bidsuccess-temp',$data);
            $this->upgradeOfferMail($data);		 
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


	     $userID = $this->session->userdata('loginuserID');
                $userTypeID = $this->session->userdata('usertypeID');
                if($userTypeID == 2){
                        $this->data['carriers'] = $this->airline_m->getClientAirline($userID);
                           }else if($userTypeID != 1){
						 $this->data['carriers'] = $this->user_m->getUserAirlines($userID);	   
						   } else {
                   $this->data['carriers'] = $this->airline_m->getAirlinesData();
                }



		$this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1');
                $this->data['cabins'] =  $this->airports_m->getDefnsCodesListByType('13');
//		 $this->data['carrier'] =  $this->airports_m->getDefnsCodesListByType('12');

          if($this->input->post('carrier')){
		   $this->data['car'] = $this->input->post('carrier');
	     } else {
		   if($userTypeID != 1){
             $this->data['car'] = $this->session->userdata('default_airline');
		   } else {
			 $this->data['car'] = 0;
		   }
         }
		 
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

	
		$days = $this->preference_m->get_application_preference_value('OFFER_ISSUE_WINDOW','7');

		 $current_time = time();
	        $tstamp = $current_time + ($days * 86400);

		$this->data['siteinfos'] = $this->reset_m->get_site();
	
/*		$sQuery = " select group_concat(distinct pfe.dtpfext_id) as pf_list , group_concat(first_name,' ', last_name SEPARATOR ';') as pax_names , booking_status, pnr_ref , flight_number, carrier_code, from_city,to_city,dep_date, dep_time, arrival_time, fci.aln_data_value as from_city_name , tci.aln_data_value as to_city_name, group_concat(distinct pfe.fclr_id)  as fclr_list ,group_concat(pax_contact_email) as email_list , cab.aln_data_value as cabin from VX_aln_dtpf_ext pfe LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_aln_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN vx_aln_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  cab on (cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13) where  dd.alias = 'new'  group by tpf.pnr_ref, flight_number, carrier_code, from_city, to_city ,dep_date,booking_status, from_city_name, to_city_name, dep_time, arrival_time, cabin";*/
		$sQuery = " select tpf.pnr_ref,tpf.carrier_code, booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(pax_contact_email) as email_list, group_concat(first_name,' ', last_name SEPARATOR ';') as pax_names from VX_aln_dtpf_ext pfe LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_aln_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN vx_aln_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  where   tpf.dep_date >= ".$tstamp."  AND tpf.is_processed = 1 and tpf.active = 1  AND dd.alias = 'new'  group by tpf.pnr_ref ,  booking_status,tpf.carrier_code";

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
		'mail_subject' => "Upgrade Cabin Offer"	,
        'airlineID' => $offer->carrier_code		
        ); 	

       
	  /* $filename1 = base_url().'assets/home/images/emir.png';
	  $filename2 = base_url()."assets/home/images/temp1-bnr.jpg";
	  $filename3 = base_url().'assets/home/images/temp1-hdr-bg.jpg';
	  
	  $this->email->attach($filename1);
      $cid1 = $this->email->attachment_cid($filename1);
	  $this->email->attach($filename2);
      $cid2 = $this->email->attachment_cid($filename2);	  
      $this->email->attach($filename3);
      $cid3 = $this->email->attachment_cid($filename3); */
	  
	    
		/* $data['logo_cid'] = $cid1;
        $data['temp_cid'] = $cid2;
        $data['bgr_file']  = $cid3; */
		
          //$this->sendMailTemplateParser('home/upgrade_offer_temp',$data);
       		
	  //$this->sendMailTemplateParser('home/testtemplate',$data);	
	    $this->upgradeOfferMail($data);

		}	
		

		redirect(base_url("offer_issue/index"));
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



            $aColumns = array('MainSet.offer_id','MainSet.offer_id','SubSet.passenger_list','MainSet.pnr_ref','SubSet.from_city', 'SubSet.to_city','SubSet.flight_date','SubSet.carrier', 'SubSet.flight_number','SubSet.from_city_name', 'SubSet.to_city_name');

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
                                                //if($_GET['iSortCol_0'] == 8){
                                                  //      $sOrder .= " (s.order_no*-1) DESC ,";
                                                //} else {
                                                 $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                                                        ".$_GET['sSortDir_'.$i] .", ";
                                                //}
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
                        if(!empty($this->input->get('carrier'))){
                                 $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'SubSet.carrier_code = '. $this->input->get('carrier');
                        }
                        if(!empty($this->input->get('pnr_ref'))){
                                $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                                $sWhere .= 'MainSet.pnr_ref = "'.  $this->input->get('pnr_ref'). '"';
                        }



		$userTypeID = $this->session->userdata('usertypeID');
                $userID = $this->session->userdata('loginuserID');
                if($userTypeID != 1){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'SubSet.carrier_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';              
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
                                                group_concat(distinct cdef.desc) as from_cabin  , fc.aln_data_value as from_city_name, fc.code as from_city, tc.code as to_city, tc.aln_data_value as to_city_name,
                                                car.code as carrier , pf1.carrier_code
                                         from VX_aln_daily_tkt_pax_feed pf1 
                                        LEFT JOIN vx_aln_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18)
                                        LEFT JOIN vx_aln_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                        LEFT JOIN vx_aln_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
					INNER JOIN VX_aln_airline_cabin_def cdef on (cdef.carrier = pf1.carrier_code)
                                        INNER JOIN vx_aln_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13 and cab.alias = cdef.level)
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

		$rownum = 1 + $_GET['iDisplayStart'];
                foreach ($rResult as $feed ) {
			$feed->sno = $rownum;
			$rownum++;
                        $boarding_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->from_city_code));
						$feed->source = $feed->from_city;
						$feed->dest = $feed->to_city;
                        $feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$boarding_markets.'">'.$feed->from_city.'</a>';
                        $dest_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->to_city_code));
                        $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-custom btn-xs mrg" data-original-title="'.$dest_markets.'">'.$feed->to_city.'</a>';
			
			$feed->booking_status = btn_view('offer_issue/view/'.$feed->offer_id, $this->lang->line('view'));
                        $feed->season_id = ($feed->season_id) ? $this->season_m->getSeasonNameByID($feed->season_id) : "default";
                        $feed->departure_date = date('d-m-Y',$feed->flight_date);
			$bid_cnt = $this->bid_m->getBidByOfferID($feed->offer_id);	
			$return_url = 'offer_issue';
			if($bid_cnt > 0 ) {
				$feed->bid_info = btn_view('offer_table/view/'.$feed->offer_id.'/return/'.$return_url, $this->lang->line('view'));
			} else{
				$feed->bid_info = 'No Bid';
			}

                                $output['aaData'][] = $feed;

                }


                if(isset($_REQUEST['export'])){
				  $columns = array('#','Passenger List','PNR Reference','Board Point','Off Point','Departure Date','Carrier','Flight Number');
				  $rows = array("offer_id","passenger_list","pnr_ref","source","dest","departure_date","carrier","flight_number");
				  $this->exportall($output['aaData'],$columns,$rows);		
				} else {	
				  echo json_encode( $output );
				}

	}

  function auto_acsr() {
	$this->load->model('preference_m');
	
	$days = $this->preference_m->get_application_preference_value('CONFIRM_WINDOW','7');

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
			dd.alias = 'bid_received'  group by pf.flight_number, pf.carrier_code, pf.dep_date  order by pf.flight_number"; 

	//var_dump($sQuery);exit;
	$rResult = $this->install_m->run_query($sQuery);
      

//	var_dump($rResult);exit;
	$full_offerlist = array();
	$partial_offerlist = array();	
	foreach($rResult as $data ) {
		$q = "  SELECT distinct bid_id, bid.rank, bid_value as bid_val,pf.dep_date,pf.dept_time,pf.arrival_time,bid.upgrade_type,pf.flight_number,
             pf.rbd_markup, pf.tier_markup ,bid.offer_id,bid.cash cash,bid.miles miles, bid.cash_percentage as cash_per,bid_submit_date , pf.from_city, pf.to_city, pf.carrier_code, pf.cabin, df.code as src_point, dt.code as dest_point, df.aln_data_value src_point_name,dt.aln_data_value dest_poin_name, car.code as carrier_name,car.aln_data_value as car_name ,cdef.desc as upgrade_cabin
             from VX_aln_bid bid
             LEFT JOIN VX_aln_offer_ref oref on (oref.offer_id = bid.offer_id )
             LEFT JOIN VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref  AND pf.flight_number = bid.flight_number AND  pf.is_processed = 1 and pf.active = 1 )
             LEFT JOIN vx_aln_data_defns df on (df.vx_aln_data_defnsID = pf.from_city and df.aln_data_typeID = 1)
             LEFT JOIN vx_aln_data_defns dt on (dt.vx_aln_data_defnsID = pf.to_city and dt.aln_data_typeID = 1)
             LEFT JOIN vx_aln_data_defns car on (car.vx_aln_data_defnsID = pf.carrier_code and car.aln_data_typeID = 12)
	     INNER JOIN VX_aln_airline_cabin_def cdef on (cdef.carrier = pf.carrier_code)
             INNER JOIN vx_aln_data_defns dcabin on (dcabin.vx_aln_data_defnsID = bid.upgrade_type and dcabin.aln_data_typeID = 13 and cdef.level = dcabin.alias)
             WHERE bid.offer_id IN (".$data->offer_list .") AND bid.flight_number = " .$data->flight_number .
          " order by bid.rank asc"; 
		$offers =  $this->install_m->run_query($q);
		//var_dump($q);echo "<br><br>";exit;
	//	var_dump($offers); echo "<br><br>";exit;
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
			
			// apply excl rules herer something might have chnaged....!!!


			$excl_arr = array();
			$excl_arr['from_city'] = $feed->from_city;
                        $excl_arr['to_city'] = $feed->to_city;
                        $excl_arr['flight_number'] = $feed->flight_number;
                        $excl_arr['dep_date'] = $feed->dep_date;
                        $excl_arr['from_cabin'] = $feed->cabin;
                        $excl_arr['to_cabin'] = $feed->upgrade_type;
                        $excl_arr['carrier_code'] = $feed->carrier_code;
                        $day_of_week = date('w', $feed->dep_date);
                        $day = ($day_of_week)?$day_of_week:7;
                        $p_freq =  $this->rafeed_m->getDefIdByTypeAndCode($day,'14'); //507;
			$excl_arr['frequency'] = $p_freq;
			$excl_arr['dept_time'] = $feed->dept_time;
			$excl_arr['arrival_time'] = $feed->arrival_time;


                        if($acsr['season_id'] == 0 ) {
                                $acsr['frequency'] = $p_freq;
                        }

			$excl_id = $this->eligibility_exclusion_m->apply_excl_rules_before_acsr($excl_arr);	

			if ($excl_id == 0 ) {

			 // get list of acsr that are partially matching 

                        $acsr = array();
                        $acsr['from_city'] = $feed->from_city;
                        $acsr['to_city'] = $feed->to_city;
                        $acsr['dep_date'] = $feed->dep_date;
                        $acsr['from_cabin'] = $feed->cabin;
                        $acsr['to_cabin'] = $feed->upgrade_type;

			$acsr_rules = $this->acsr_m->apply_acsr_rules(0,$acsr);	

			if(count($acsr_rules) > 0)  {
			foreach ($acsr_rules as $acsr_rule )  {
				$acsrquery = $this->acsr_m->apply_acsr_rules(1);
				$acsrquery .= ' AND acsr_id = ' .$acsr_rule->acsr_id;
				if($acsr_rule->frequency != '0' ) {
                                      $acsrquery .= ' AND (FIND_IN_SET('.$p_freq.',frequency))';
                                }

				if($acsr_rule->carrier != 0 ) {
                                      $acsrquery .= " AND  (carrier = ".$feed->carrier_code. ")";
                                 }
				
				 if($acsr_rule->flight_nbr_start != '0' AND $acsr_rule->flight_nbr_end != 0 ) {
                                         $acsrquery .= " AND  (flight_nbr_start <= ". $feed->flight_number. " and flight_nbr_end >= " . $feed->flight_number. ")";

                                  }

				   if($acsr_rule->flight_dep_time_start != -1 AND $acsr_rule->flight_dep_time_end != -1 ) {

                                                        $acsrquery .= " AND (flight_dep_time_start <= ".$feed->dept_time." and flight_dep_time_end >= ".$feed->dept_time.")";
                                    }
				$acsr_match_result = $this->install_m->run_query($acsrquery);
				$acsr_data = $acsr_match_result[0];
                                if(count($acsr_data) > 0 ) { // acsr rule matched for the appropriate case
                                      break;
                                }
			} // forloop for acsr rules
				
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

			if(($acsr_data->status == 'reject' && ($feed->bid_val/$passenger_cnt) < $acsr_data->min_bid_price) ) {			
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


                        /*  $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
                         //$this->email->from('testsweken321@gmail.com', 'ADMIN');
                         $this->email->to($emails_list[0]);
                         $this->email->subject("Bid is rejected From " .$feed->src_point.' To ' . $feed->dest_point);
                        $this->email->message($message);
                        $this->email->send(); */					
						
						 $rejectmail = array(
							'first_name'   => $namelist[0],
							'last_name' => '',
							'tomail' => $emails_list[0],
							'pnr_ref' => $passenger_data->pnr_ref,
                            'airlineID' => $feed->carrier_code,							
							'mail_subject' => "Bid is rejected From " .$feed->src_point.' To ' . $feed->dest_point		
							); 
                        $this->sendMailTemplateParser('bid_reject',$rejectmail);
				 $array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');
			$p_list = explode(',',$passenger_data->p_list);

                        // update extension table with new status

                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);


			// update tracker about change in status
                        $tracker = array();
                                $tracker['booking_status_from'] = $passenger_data->booking_status;
                                $tracker['booking_status_to'] = $array['booking_status'];
                                $tracker['comment'] = 'Bid Rejected by ACSR';
                                $tracker["create_date"] = time();
                                $tracker["modify_date"] = time();
                                $tracker["create_userID"] = $this->session->userdata('loginuserID');
                                $tracker["modify_userID"] = $this->session->userdata('loginuserID');
                        //      var_dump($p_list);exit;

                                foreach($p_list as $id) {
                                        $tracker['dtpfext_id'] = $id;
                                        $this->offer_issue_m->insert_dtpf_tracker($tracker);
                                }




			} else {
			/*
				echo $acsr_data->status . "<br>";
				echo $feed->bid_val . "<br>";
				echo $acsr_data->min_bid_price . "<br>";exit;*/
				if ( $acsr_data->status == 'accept' && ($feed->bid_val/$passenger_cnt) > $acsr_data->min_bid_price ) { 

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

			 // update tracker about change in status
                        $tracker = array();
                                $tracker['booking_status_from'] = $passenger_data->booking_status;
                                $tracker['booking_status_to'] = $array['booking_status'];
                                $tracker['comment'] = 'No Seats Avaiable updated by ACSR';
                                $tracker["create_date"] = time();
                                $tracker["modify_date"] = time();
                                $tracker["create_userID"] = $this->session->userdata('loginuserID');
                                $tracker["modify_userID"] = $this->session->userdata('loginuserID');
                        //      var_dump($p_list);exit;

                                foreach($p_list as $id) {
                                        $tracker['dtpfext_id'] = $id;
                                        $this->offer_issue_m->insert_dtpf_tracker($tracker);
                                }




				} else {
		//	echo "accepetd";

				// check preference before accepting for cutoff time.

			       $cabin_type = $this->airports_m->getDefDataForAirlineCabin($feed->cabin,'13',$feed->carrier_code);
			       $cutoff_time = 0;
				$cutoff_time  = $this->preference_m->get_preference_value_bycode('OFFER_ACPT_LEVEL'.$cabin_type->level,'24',$feed->carrier_code);
					
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
							'dep_time' => gmdate('H:i A',$passenger_data->dept_time),
							'origin' => $feed->src_point,
							'destination' => $feed->dest_point, 
							'upgrade_to' => $feed->upgrade_cabin,
							'airlineID' => $feed->carrier_code,
							'carrier_name' => $feed->car_name,
                            'feedback_link' => base_url('home/feedback?pnr_ref='.$passenger_data->pnr_ref) 							
						 ); 			 
					  //$this->sendMailTemplateParser('home/upgradeoffertmp',$e_data);
                      $this->sendMailTemplateParser('bid_accepted',$e_data);					  

			 $array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');


                        // update extension table with new status
			$p_list = explode(',',$passenger_data->p_list);
                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);


			 // update tracker about change in status
                        $tracker = array();
                                $tracker['booking_status_from'] = $passenger_data->booking_status;
                                $tracker['booking_status_to'] = $array['booking_status'];
                                $tracker['comment'] = 'Bid is Accepted updated by Acsr';
                                $tracker["create_date"] = time();
                                $tracker["modify_date"] = time();
                                $tracker["create_userID"] = $this->session->userdata('loginuserID');
                                $tracker["modify_userID"] = $this->session->userdata('loginuserID');
                        //      var_dump($p_list);exit;

                                foreach($p_list as $id) {
                                        $tracker['dtpfext_id'] = $id;
                                        $this->offer_issue_m->insert_dtpf_tracker($tracker);
                                }




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

			 // update tracker about change in status
                        $tracker = array();
                                $tracker['booking_status_from'] = $passenger_data->booking_status;
                                $tracker['booking_status_to'] = $array['booking_status'];
                                $tracker['comment'] = 'Offer Date expired updated by ACSR';
                                $tracker["create_date"] = time();
                                $tracker["modify_date"] = time();
                                $tracker["create_userID"] = $this->session->userdata('loginuserID');
                                $tracker["modify_userID"] = $this->session->userdata('loginuserID');
                        //      var_dump($p_list);exit;

                                foreach($p_list as $id) {
                                        $tracker['dtpfext_id'] = $id;
                                        $this->offer_issue_m->insert_dtpf_tracker($tracker);
                                }






		  }

		}

			}
				}
		} // have partial acsr rules 

		}else {

			//exclude
			$array = array();
                        $array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
                        $array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');


                        // update extension table with new status
                        $p_list = explode(',',$passenger_data->p_list);
                        $this->offer_eligibility_m->update_dtpfext($array,$p_list);

			 // update tracker about change in status
                        $tracker = array();
                                $tracker['booking_status_from'] = $passenger_data->booking_status;
                                $tracker['booking_status_to'] = $array['booking_status'];
                                $tracker['comment'] = 'Excluded updated by ACSR';
                                $tracker["create_date"] = time();
                                $tracker["modify_date"] = time();
                                $tracker["create_userID"] = $this->session->userdata('loginuserID');
                                $tracker["modify_userID"] = $this->session->userdata('loginuserID');
                        //      var_dump($p_list);exit;

                                foreach($p_list as $id) {
                                        $tracker['dtpfext_id'] = $id;
                                        $this->offer_issue_m->insert_dtpf_tracker($tracker);
                                }




				
		}



				}
		

			}
			
		redirect(base_url("offer_table/index"));


		}

    public function upgradeOfferMail($maildata){
		$pnr_ref = $maildata['pnr_ref'];
		$results = $this->bid_m->getPassengers($pnr_ref);
		$exclude = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
		$cabins  = $this->airline_cabin_m->getAirlineCabins();
		//print_r($results); exit;
		foreach($results as $result){
		  $result->to_cabins = explode(',',$result->to_cabins);
		  $cdata = array();
		   foreach($result->to_cabins as $value){
            $cdata = explode('-',$value);              		
			if($cdata[2] != $exclude){
			    $result->tocabins[] = array('cabin_name' => $cabins[$cdata[0]]); 
		    }              
           }
			if($result->fclr != null && !empty($result->tocabins)){			
				$info['dep_date'] = date('d-m-Y',$result->dep_date);
				$info['dep_time'] = date('H:i:s',$result->dept_time);
				$info['carrier_code'] = $result->carrier_code;
				$info['flight_number'] = $result->flight_number;
				$info['from_city'] = $result->from_city_code;
				$info['to_city'] = $result->to_city_code;
				$info['seat_no'] = $result->seat_no;
				$info['current_cabin'] = $result->current_cabin;
				$info['cabins'] = $result->tocabins;
				$offerdata[] = $info;
		    }
		}
		
		$pax_names = $this->bid_m->getPaxNames($pnr_ref);
		 $maildata['offer_data'] = $offerdata;		
      
//print_r($maildata); exit;		
		$this->sendMailTemplateParser('upgrade_offer',$maildata);
	}		
		

}
