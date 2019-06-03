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
		$this->load->model("reset_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('offer', $language);
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



		$this->data['siteinfos'] = $this->reset_m->get_site();
	
/*		$sQuery = " select group_concat(distinct pfe.dtpfext_id) as pf_list , group_concat(first_name,' ', last_name SEPARATOR ';') as pax_names , booking_status, pnr_ref , flight_number, carrier_code, from_city,to_city,dep_date, dep_time, arrival_time, fci.aln_data_value as from_city_name , tci.aln_data_value as to_city_name, group_concat(distinct pfe.fclr_id)  as fclr_list ,group_concat(pax_contact_email) as email_list , cab.aln_data_value as cabin from VX_aln_dtpf_ext pfe LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_aln_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN vx_aln_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  cab on (cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13) where  dd.alias = 'new'  group by tpf.pnr_ref, flight_number, carrier_code, from_city, to_city ,dep_date,booking_status, from_city_name, to_city_name, dep_time, arrival_time, cabin";*/
		$sQuery = " select tpf.pnr_ref, booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(pax_contact_email) as email_list, group_concat(first_name,' ', last_name SEPARATOR ';') as pax_names from VX_aln_dtpf_ext pfe LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_aln_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN vx_aln_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  cab on (cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13) where  dd.alias = 'new'  group by tpf.pnr_ref ,  booking_status";

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


			 $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
			// $this->email->from('testsweken321@gmail.com', 'ADMIN');
			 $this->email->to($emails_list[0]);
			 $this->email->subject("Upgrade Cabin Offer");
			$this->email->message($message);
			$this->email->send();

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



            $aColumns = array('offer_id');

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





$sQuery = " SELECT SQL_CALC_FOUND_ROWS group_concat(distinct dai.code) as carrier_code, group_concat(distinct pf.to_city ) as off_point ,group_concat(distinct pf.from_city) as board_point, group_concat( distinct bs.aln_data_value) as booking_status ,group_concat(distinct dbp.code) as source_point , group_concat(distinct dep_date) as departure_date , group_concat(distinct dop.code) as dest_point ,group_concat(distinct  pf.flight_number)  as flight_number , group_concat(distinct offer_id) as offer_id  , ofr.pnr_ref  ,group_concat( distinct first_name , ' ' , last_name SEPARATOR '<br>' ) as passenger_list   from VX_aln_offer_ref ofr  LEFT JOIN  VX_aln_daily_tkt_pax_feed pf on (pf.pnr_ref = ofr.pnr_ref) LEFT JOIN VX_aln_dtpf_ext pext  on (pext.dtpf_id = pf.dtpf_id) LEFT JOIN VX_aln_fare_control_range fc on  (pext.fclr_id = fc.fclr_id)  LEFT JOIN  vx_aln_data_defns dbp on (dbp.vx_aln_data_defnsID = pf.from_city AND dbp.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns dop on (dop.vx_aln_data_defnsID = pf.to_city AND dop.aln_data_typeID = 1) LEFT JOIN vx_aln_data_defns dai on (dai.vx_aln_data_defnsID = fc.carrier_code AND dai.aln_data_typeID = 12)  LEFT JOIN vx_aln_data_defns dfre on (dfre.vx_aln_data_defnsID = fc.frequency AND dfre.aln_data_typeID = 14)  LEFT JOIN vx_aln_data_defns fca on (fca.vx_aln_data_defnsID = fc.from_cabin AND fca.aln_data_typeID = 13) LEFT JOIN vx_aln_data_defns tca on (tca.vx_aln_data_defnsID = fc.to_cabin AND tca.aln_data_typeID = 13)           LEFT JOIN vx_aln_data_defns bs on (bs.vx_aln_data_defnsID = pext.booking_status AND bs.aln_data_typeID = 20)  where bs.aln_data_value != 'Excluded'  ". $sWhere. " group by ofr.pnr_ref
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
                foreach ($rResult as $feed ) {

                        $boarding_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->boarding_point));
                        $feed->source_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$boarding_markets.'">'.$feed->source_point.'</a>';
                         $dest_markets = implode(',',$this->marketzone_m->getMarketsForAirportID($feed->off_point));
                        $feed->dest_point = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="'.$dest_markets.'">'.$feed->dest_point.'</a>';

                        if($feed->booking_status == 'Excluded') {
                                $feed->booking_status = '<a href="#" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs mrg" data-original-title="Rule#'.$feed->exclusion_id.'">'.$feed->booking_status.'</a>';

                        }
                        $feed->season_id = ($feed->season_id) ? $this->season_m->getSeasonNameByID($feed->season_id) : "default season";
                        $feed->departure_date = date('d-m-Y',$feed->departure_date);

                                $output['aaData'][] = $feed;

                }


                echo json_encode( $output );

	}


}
