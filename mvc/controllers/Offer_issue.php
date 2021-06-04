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
                $this->load->model("product_m");
		$this->load->model("airports_m");
		$this->load->model("bid_m");
		$this->load->model('preference_m');
		$this->load->model("user_m");
		$language = $this->session->userdata('lang');		
		$this->lang->load('offer', $language);  
   
	}	
	
	function testmail(){
                $pnr_ref = htmlentities(escapeString($this->uri->segment(3)));
                $email = htmlentities(escapeString($this->uri->segment(4)));
                //lakshmi.amujuru@sweken.com,sirisha.majji@sweken.com,swekenit@gmail.com,anitha.jeereddi@sweken.com	    
                $data = array(
                'tomail' => $email . "@gmail.com",
                'pnr_ref' => "$pnr_ref",
                'coupon_code' => '34535',
                );			       
               // $this->sendMailTemplateParser('bid_accepted',$data);
                //        exit;
                //  $this->sendMailTemplateParser('home/bidsuccess-temp',$data);
                $this->upgradeOfferMail($data);		 
	}


	function sendoffer(){
                $pnr_ref = htmlentities(escapeString($this->uri->segment(3)));
                $email = htmlentities(escapeString($this->uri->segment(4)));
                $mailto =  $email . "@gmail.com";
                $data = array(
						'tomail' => $mailto,
						'pnr_ref' => "$pnr_ref",
						'coupon_code' => '34535',
                );			       
                $this->upgradeOfferMail($data);		 
	}

	function resendoffer(){
		
		$pnr_ref = htmlentities(escapeString($this->uri->segment(3)));
		$email = htmlentities(escapeString($this->uri->segment(4)));
		$mailto =  $email . "@gmail.com";
        $data = array(
			'pnr_ref' => "$pnr_ref",
			'coupon_code' => '34535',
        );			       
		if ($mailto) {
			$data['tomail'] =  $mailto;
		}	
		$this->send_offer_mail($pnr_ref);
        $this->upgradeOfferMail($data);		 
		$this->session->set_flashdata('success', 'Offer Mail sent to PAX successfully');
		//redirect(base_url("offer_issue/index"));		
	}
	//newly added fumction for test mail
	function sendOfferConfirmation()
	{
		$offer_id=escapeString($this->uri->segment(3));
		$email = htmlentities(escapeString($this->uri->segment(4)));
		$mailto =  $email . "@gmail.com";
        $maildata = array(
			'pnr_ref' => "$pnr_ref",
			'coupon_code' => '34535',
        );			       
		if ($mailto) {
			$maildata['tomail'] =  $mailto;
		}		

		$maildata['template'] = 'baggage_confirmed';
		$maildata['offer_id']=$offer_id;
		$this->upgradeOfferMail($maildata);
		//redirect(base_url("offer_issue/index"));
	}

/* test mail function ended */ 

        public function tplviewnew() {
		$dir = "mvc/views/mail-templates/";
                $tpl = htmlentities(escapeString($this->uri->segment(3)));
		if ( $tpl) {
			$content = file_get_contents("$dir/$tpl");
			echo $content;
		} else {

			// Sort in ascending order - this is default
			$a = scandir($dir);
			foreach ($a as $file) {
				echo "<br>";
				echo "<a href='tplviewnew/$file'>$file</a>";
			}
		}
	}
        public function tplview() {
		$dir = "mvc/views/offer-email-temps/";
                $tpl = htmlentities(escapeString($this->uri->segment(3)));
		if ( $tpl) {
			$content = file_get_contents("$dir/$tpl");
			echo $content;
		} else {

			// Sort in ascending order - this is default
			$a = scandir($dir);
			foreach ($a as $file) {
				echo "<br>";
				echo "<a href='tplview/$file'>$file</a>";
			}
		}
	}
	

        public function view() {
                $id = htmlentities(escapeString($this->uri->segment(3)));

                if ($id) {
                        $this->data['products'] = $this->offer_issue_m->getProductsforOffer($id);
			foreach($this->data["products"] as $pdId => $value ) {
                        	$this->data["offers"][$pdId] = $this->offer_issue_m->getOfferDetails($id, $pdId);
			}

                        if($this->data["offers"]) {
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
                $roleID = $this->session->userdata('roleID');
                if($roleID != 1){
		 	$this->data['carriers'] = $this->user_m->getUserAirlines($userID);	   
	   	} else {
                   	$this->data['carriers'] = $this->airline_m->getAirlinesData();
                }

                if(!empty($this->input->post('name'))){	
			$this->data['name'] = $this->input->post('name');
		} else {
		    $this->data['name'] = 0;
		}

		$this->data['airports'] = $this->airports_m->getDefnsCodesListByType('1');
                $this->data['cabins'] =  $this->airports_m->getDefnsCodesListByType('13');
                $this->data['product_name'] = $this->product_m->productName();
//		 $this->data['carrier'] =  $this->airports_m->getDefnsCodesListByType('12');

		  if($this->input->post('carrier')){
			   $this->data['car'] = $this->input->post('carrier');
		     } else {
			   if($roleID != 1){
		     $this->data['car'] = $this->session->userdata('default_airline');
			   } else {
				 $this->data['car'] = 0;
			   }
		 }
			 
		$this->data["subview"] = "offer/index";
                $this->load->view('_layout_main', $this->data);
	}

	public function run_offer_issue($pnr = '') {
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
	
		$sQuery = " select pfe.product_id, tpf.pnr_ref,tpf.carrier_code, booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(distinct pax_contact_email) as email_list, group_concat( distinct first_name,' ', last_name SEPARATOR ';') as pax_names from VX_offer_info pfe LEFT JOIN VX_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN VX_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN VX_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  where   tpf.dep_date >= ".$tstamp."  AND (tpf.is_up_offer_processed = 1 OR tpf.is_bg_offer_processed = 1) AND tpf.active = 1 AND pfe.active = 1 AND pfe.rule_id > 0 AND tpf.active = 1  ";
		if ($pnr) {
			$sQuery .= " AND tpf.pnr_ref = '$pnr' ";
		}
		$sQuery .= " group by tpf.pnr_ref ,  booking_status,tpf.carrier_code, pfe.product_id ";

		$rResult = $this->install_m->run_query($sQuery);
		$offer_status = $this->rafeed_m->getDefIdByTypeAndAlias('new','20');

	 	foreach($rResult as $offer) {

			$p_list = explode(',',$offer->pf_list);
			$namelist = explode(';',$offer->pax_names);
			$emails_list = explode(',', $offer->email_list);
			$coupon_code = $this->generateRandomString(6);

				$ref['pnr_ref'] = $offer->pnr_ref;
				$ref['coupon_code'] = $this->offer_eligibility_m->hash($coupon_code);
				$ref['offer_status'] = $offer_status; 
				$ref['product_id'] =  $offer->product_id;
				$ref["create_date"] = time();
				$ref["modify_date"] = time();
				$ref["create_userID"] = $this->session->userdata('loginuserID');
				$ref["modify_userID"] = $this->session->userdata('loginuserID');

				$this->offer_reference_m->insert_offer_ref($ref);//offer update ref table

		}
		$this->session->set_flashdata('success', 'Generated Offers all New PAX successfully');
		redirect(base_url("offer_issue/index"));
	}

	public function send_offer_mail($pnr = '') {
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
	
		$sQuery = " select o.offer_status, o.offer_id, pfe.product_id, tpf.pnr_ref,tpf.carrier_code, booking_status,group_concat(distinct pfe.dtpfext_id) as pf_list,group_concat(distinct pax_contact_email) as email_list, group_concat(distinct first_name,' ', last_name SEPARATOR ';') as pax_names from VX_offer_info pfe  LEFT JOIN VX_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id ) LEFT JOIN VX_offer o on (o.pnr_ref = tpf.pnr_ref AND pfe.product_id = o.product_id AND o.active = 1)  LEFT JOIN VX_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN VX_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  where   tpf.dep_date >= ".$tstamp."  AND (tpf.is_up_offer_processed = 1 OR tpf.is_bg_offer_processed = 1) and tpf.active = 1 AND pfe.active = 1 AND o.active = 1  ";
		if ($pnr) {
			$sQuery .= " AND tpf.pnr_ref = '$pnr' ";
		} else {
			$sQuery .= " AND (dd.alias = 'new' OR o.offer_status = 1970)";
		}
		$sQuery .= " group by tpf.pnr_ref ,  booking_status,tpf.carrier_code, pfe.product_id";

		$rResult = $this->install_m->run_query($sQuery);
		$offer_status = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');

	 	foreach($rResult as $offer) {

			$emails_list = explode(',', $offer->email_list);
			$coupon_code = $this->generateRandomString(6);

			$array = array();
			$array['booking_status'] = $offer_status;
			$array["modify_date"] = time();
			$array["modify_userID"] = $this->session->userdata('loginuserID');

			// update extension table with new status
			$this->offer_eligibility_m->update_dtpfext($array,$p_list);

			$array = array();
			$array['offer_status'] = $offer_status;
			$array['product_id'] = $offer->product_id;
			$array["modify_date"] = time();
			$array["modify_userID"] = $this->session->userdata('loginuserID');
			$this->offer_reference_m->update_offer_ref($array,$offer->offer_id);

				// update tracker about change in status
				$tracker = array();
				$tracker['booking_status_from'] = $offer->offer_status;
				$tracker['booking_status_to'] = $array['offer_status'];
				$tracker['comment'] = 'Sent Offer Email';
				$tracker["create_date"] = time();
				$tracker["modify_date"] = time();
				$tracker["create_userID"] = $this->session->userdata('loginuserID');
				$tracker["modify_userID"] = $this->session->userdata('loginuserID');

				foreach($p_list as $id) {
					$tracker['dtpfext_id'] = $id;
					$this->offer_issue_m->insert_dtpf_tracker($tracker);
				}
		
				$data = array(
					'pnr_ref' => $offer->pnr_ref,
					'coupon_code' => $coupon_code,
					'tomail' => $emails_list[0]
				);			       
				if ( ! empty($data['pnr_ref']) ){

					$msg .= $this->upgradeOfferMail($data);		 
				}

			}
		$fmsg  = 'Offer Mail sent to New PAX successfully';
		if ($msg ) {
			$fmsg .= "<br>But have some errors.. " . $msg;
		}
		$this->session->set_flashdata('success', $fmsg);
		if(!($pnr)){
		redirect(base_url("offer_issue/index"));
		}
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
                $roleID = $this->session->userdata('roleID');



            $aColumns = array('MainSet.offer_id','SubSet.name','SubSet.passenger_list','MainSet.pnr_ref','SubSet.from_city', 'SubSet.to_city','SubSet.flight_date','SubSet.carrier', 'SubSet.flight_number','SubSet.from_city_name', 'SubSet.to_city_name');

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
                         // var_dump($this->input->get('name'));
						// die();
						if(!empty($this->input->get('name'))){
							$sWhere .= ($sWhere == '')?' WHERE ':' AND ';
							$sWhere .= 'product_id = '.$this->input->get('name');
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



		$roleID = $this->session->userdata('roleID');
                $userID = $this->session->userdata('loginuserID');
                if($roleID != 1){
                         $sWhere .= ($sWhere == '')?' WHERE ':' AND ';
                        $sWhere .= 'SubSet.carrier_code IN ('.implode(',',$this->session->userdata('login_user_airlineID')) . ')';              
                }





$sQuery = " 
 select  SQL_CALC_FOUND_ROWS  
                        MainSet.offer_id, MainSet.offer_date, SubSet.flight_date , SubSet.carrier , 
                        SubSet.from_city, SubSet.to_city, MainSet.pnr_ref, SubSet.passenger_list,SubSet.product_id, SubSet.from_cabin,
                          MainSet.cash, MainSet.miles,  SubSet.carrier_code,  SubSet.from_city_code, SubSet.to_city_code, MainSet.cash_percentage, SubSet.flight_number, SubSet.from_city_name, SubSet.to_city_name, SubSet.name, SubSet.offer_status

                FROM (  select distinct oref.offer_id, oref.create_date as offer_date , oref.pnr_ref,oref.cash_percentage, oref.cash, oref.miles from  VX_offer oref  
                     ) as MainSet 
                        INNER JOIN (
                                        select  pext.offer_id,flight_number,  os.aln_data_value as offer_status,
                                                group_concat(distinct dep_date) as flight_date  ,
                                                pext.pnr_ref,group_concat(distinct first_name, ' ' , last_name SEPARATOR '<br>' ) as passenger_list ,  from_city as from_city_code, to_city as to_city_code, 
                                                group_concat(distinct cdef.desc) as from_cabin  , fc.aln_data_value as from_city_name, fc.code as from_city, tc.code as to_city, tc.aln_data_value as to_city_name,
                                                car.code as carrier , pf1.carrier_code,prq.product_id as product_id,prd.name as name
                                         from VX_daily_tkt_pax_feed pf1 
                                         INNER JOIN VX_offer pext on (pext.pnr_ref = pf1.pnr_ref )
					 INNER JOIN VX_offer_info prq on (pf1.dtpf_id = prq.dtpf_id AND prq.product_id = pext.product_id) 
                                         INNER JOIN VX_products prd on (prq.product_id = prd.productID)
                                        INNER JOIN VX_data_defns ptc on (ptc.vx_aln_data_defnsID = pf1.ptc AND ptc.aln_data_typeID = 18)
                                        INNER JOIN VX_data_defns fc on (fc.vx_aln_data_defnsID = pf1.from_city AND fc.aln_data_typeID = 1)
                                        INNER JOIN VX_data_defns tc on (tc.vx_aln_data_defnsID = pf1.to_city AND tc.aln_data_typeID = 1)
					INNER JOIN VX_airline_cabin_def cdef on (cdef.carrier = pf1.carrier_code)
                                        INNER JOIN VX_data_defns cab on (cab.vx_aln_data_defnsID = pf1.cabin AND cab.aln_data_typeID = 13 and cab.alias = cdef.level)
                                        INNER JOIN VX_data_defns car on (car.vx_aln_data_defnsID = pf1.carrier_code AND car.aln_data_typeID = 12)
		     			INNER JOIN VX_data_defns os on (os.vx_aln_data_defnsID = pext.offer_status AND os.aln_data_typeID = 20)
                                        where (pf1.is_up_offer_processed = 1  || pf1.is_bg_offer_processed = 1) AND pf1.active = 1 AND pext.active = 1 AND prq.active = 1 
                                       group by pnr_ref, pf1.from_city, pf1.to_city,flight_number,carrier_code,prq.product_id
                   ) as SubSet on (SubSet.pnr_ref = MainSet.pnr_ref AND SubSet.offer_id = MainSet.offer_id ) 
$sWhere $sOrder $sLimit";


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
			
			#$feed->action = btn_view('offer_issue/view/'.$feed->pnr_ref, $this->lang->line('view'));
			if ( $feed->offer_status  == 'New' || $feed->offer_status  == 'Sent Offer Mail') {
                   		$feed->action =  '<a target="_blank" href="' . base_url('offer_issue/resendoffer/' . $feed->pnr_ref) . '" class="btn btn-primary btn-xs mrg"  data-placement="top" data-toggle="tooltip" data-original-title="SEND OFFER MAIL TO PAX"><i class="fa fa-check"></i></a>';
			} else {
                   		$feed->action = '';
			}
                   	$feed->offer_status =  '<a target="_blank" href="' . base_url('offer_issue/view/' . $feed->pnr_ref) . '"  data-placement="top" data-toggle="tooltip" data-original-title="VIEW MORE OFFER DETAILS">'. $feed->offer_status. '</a>';
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
				  $columns = array('#','Passenger List','Product Type','PNR Reference','Board Point','Off Point','Departure Date','Carrier','Flight Number');
				  $rows = array("offer_id","passenger_list","name","pnr_ref","source","dest","departure_date","carrier","flight_number");
				  $this->exportall($output['aaData'],$columns,$rows);		
				} else {	
				  echo json_encode( $output );
				}

	}

	function auto_acsr() {

		$this->load->model('preference_m');

		$days = $this->preference_m->get_application_preference_value('CONFIRM_WINDOW','7');
		$ignore_exclusion_rules = $this->preference_m->get_application_preference_value('IGNORE_EXCLUSION_RULES','7');

		$current_time = time();
		$tstamp = $current_time + ($days * 86400);

		// update is required if offer status is updated in VX_aln_offer_ref
					// for now considering offer status is updated in  PF records
			//
		$sQuery = "select oref.offer_status, pf.dep_date , pf.flight_number , pf.carrier_code , group_concat(distinct offer_id) as offer_list  
		from VX_offer oref 
		INNER JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref and (pf.is_up_offer_processed = 1 OR pf.is_bg_offer_processed = 1) and pf.active = 1)
		INNER JOIN VX_offer_info pext on (pext.dtpf_id = pf.dtpf_id AND oref.product_id = pext.product_id)
		INNER JOIN VX_data_defns dd on (dd.vx_aln_data_defnsID = oref.offer_status AND dd.aln_data_typeID = 20)
		WHERE pf.dep_date >= ".$current_time. " AND pf.dep_date <= " . $tstamp  .
		" AND dd.alias != 'excl' AND pext.exclusion_id = 0 AND 
		dd.alias = 'bid_received'  group by pf.flight_number, pf.carrier_code, pf.dep_date  order by pf.flight_number"; 

		///var_dump($sQuery);
		$rResult = $this->install_m->run_query($sQuery);
		  

		$full_offerlist = array();
		$partial_offerlist = array();	
		foreach($rResult as $data ) {
			$q = "  SELECT distinct oref.product_id, bid.orderID,bid_id, bid.rank, bid_value as bid_val,pf.dep_date,pf.dept_time,pf.arrival_time,bid.upgrade_type,pf.flight_number,
			 pf.rbd_markup, pf.tier_markup ,bid.offer_id,bid.cash cash,bid.miles miles, bid.cash_percentage as cash_per,bid_submit_date , pf.from_city, pf.to_city, pf.carrier_code, pf.cabin, df.code as src_point, dt.code as dest_point, df.aln_data_value src_point_name,dt.aln_data_value dest_poin_name, car.code as carrier_name,car.aln_data_value as car_name ,cdef.desc as upgrade_cabin
			 from UP_bid bid
			 LEFT JOIN VX_offer oref on (oref.offer_id = bid.offer_id AND bid.productID = oref.product_id )
			 LEFT JOIN VX_daily_tkt_pax_feed pf on (pf.pnr_ref = oref.pnr_ref  AND pf.flight_number = bid.flight_number AND  (pf.is_up_offer_processed = 1 OR pf.is_bg_offer_processed = 1) and pf.active = 1 )
			 LEFT JOIN VX_data_defns df on (df.vx_aln_data_defnsID = pf.from_city and df.aln_data_typeID = 1)
			 LEFT JOIN VX_data_defns dt on (dt.vx_aln_data_defnsID = pf.to_city and dt.aln_data_typeID = 1)
			 LEFT JOIN VX_data_defns car on (car.vx_aln_data_defnsID = pf.carrier_code and car.aln_data_typeID = 12)
		 	INNER JOIN VX_airline_cabin_def cdef on (cdef.carrier = pf.carrier_code)
			 INNER JOIN VX_data_defns dcabin on (dcabin.vx_aln_data_defnsID = bid.upgrade_type and dcabin.aln_data_typeID = 13 and cdef.level = dcabin.alias)
			 WHERE bid.offer_id IN (".$data->offer_list .") AND bid.flight_number = " .$data->flight_number .
		  " order by bid.rank asc"; 
			$offers =  $this->install_m->run_query($q);
//var_dump($q);echo "<br><br>";exit;
			foreach ($offers as $feed ) {
				$passenger_data = $this->offer_issue_m->getPassengerData($feed->offer_id,$feed->flight_number);	
				//var_dump($passenger_data);
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
				if ( $ignore_exclusion_rules ) {
					$excl_id = 0;
				} else {
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
				}

				if ( $excl_id == 0) {

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
					}
				if(($acsr_data->status == 'reject' || ($feed->bid_val/$passenger_cnt) < $acsr_data->min_bid_price) ) {			
					$acsr_status = 'reject';
				}
			
				if ( $acsr_status == 'reject' ) {

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
								$offer_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_reject','20');
								$array['booking_status'] = $offer_status;
								$array["modify_date"] = time();
								$array["modify_userID"] = $this->session->userdata('loginuserID');
					$p_list = explode(',',$passenger_data->p_list);

								// update extension table with new status

								$this->offer_eligibility_m->update_dtpfext($array,$p_list);

								$array = array();
								$array['offer_status'] = $offer_status;
								$array['product_id'] = $feed->product_id;
								$array["modify_date"] = time();
								$array["modify_userID"] = $this->session->userdata('loginuserID');
								$this->offer_reference_m->update_offer_ref($array,$feed->offer_id);



					// update tracker about change in status
								$tracker = array();
										$tracker['booking_status_from'] = $passenger_data->offer_status;
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




				} else { //Accept
					  if (($cabin_seats - $passenger_cnt) < $acsr_data->memp) {

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
						$offer_status = $this->rafeed_m->getDefIdByTypeAndAlias('no_seats','20');
						$array['booking_status'] = $offer_status;
						$array["modify_date"] = time();
						$array["modify_userID"] = $this->session->userdata('loginuserID');
						$p_list = explode(',',$passenger_data->p_list);


						// update extension table with new status

						$this->offer_eligibility_m->update_dtpfext($array,$p_list);

						$array = array();
						$array['offer_status'] = $offer_status;
						$array['product_id'] = $feed->product_id;
						$array["modify_date"] = time();
						$array["modify_userID"] = $this->session->userdata('loginuserID');
						$this->offer_reference_m->update_offer_ref($array,$feed->offer_id);

						// update tracker about change in status
						$tracker = array();
						$tracker['booking_status_from'] = $passenger_data->offer_status;
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

				 $card_data = $this->bid_m->getCardData($feed->orderID);
				 $card_number = substr(trim($card_data->card_number), -4);
				 $e_data = array(
					'first_name'   => $namelist[0],
					'last_name' => '',
					'tomail' => $emails_list[0],
					'pnr_ref' => $passenger_data->pnr_ref,						
					'mail_subject' => "Bid is accepted From " .$feed->src_point." To " . $feed->dest_point,
					'card_number' => $card_number,
					'cash_paid' => number_format($feed->cash),
					'miles_used' => number_format($feed->miles),
					'flight_no' => $feed->carrier_name.$feed->flight_number,
					'dep_date' => date('d-m-Y',$feed->dep_date),
					'dep_time' => gmdate('H:i A',$passenger_data->dept_time),
					'origin' => $feed->src_point,
					'destination' => $feed->dest_point, 
					'upgrade_to' => $feed->upgrade_cabin,
					'airlineID' => $feed->carrier_code,
					'carrier_name' => $feed->car_name,
					'bid_value' => $feed->bid_val,
					'feedback_link' => base_url('home/feedback?pnr_ref='.$passenger_data->pnr_ref) 							
				 ); 			 
			  //$this->sendMailTemplateParser('home/upgradeoffertmp',$e_data);
			  	$this->sendMailTemplateParser('bid_accepted',$e_data);					  
	 			$array = array();
				$offer_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
				$array['booking_status'] = $offer_status;
				$array["modify_date"] = time();
				$array["modify_userID"] = $this->session->userdata('loginuserID');
				

				// update extension table with new status
				$p_list = explode(',',$passenger_data->p_list);
				$this->offer_eligibility_m->update_dtpfext($array,$p_list);

				$array = array();
				$array['offer_status'] = $offer_status;
				$array['product_id'] = $feed->product_id;
				$array["modify_date"] = time();
				$array["modify_userID"] = $this->session->userdata('loginuserID');
				$this->offer_reference_m->update_offer_ref($array,$feed->offer_id);


	 // update tracker about change in status
				$tracker = array();
				$tracker['booking_status_from'] = $passenger_data->offer_status;
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
								$offer_status = $this->rafeed_m->getDefIdByTypeAndAlias('offer_expire','20');
								$array['booking_status'] = $offer_status;
								$array["modify_date"] = time();
								$array["modify_userID"] = $this->session->userdata('loginuserID');


								// update extension table with new status
								$p_list = explode(',',$passenger_data->p_list);
								$this->offer_eligibility_m->update_dtpfext($array,$p_list);

								$array = array();
								$array['offer_status'] = $offer_status;
								$array['product_id'] = $feed->product_id;
								$array["modify_date"] = time();
								$array["modify_userID"] = $this->session->userdata('loginuserID');
								$this->offer_reference_m->update_offer_ref($array,$feed->offer_id);

								// update tracker about change in status
								$tracker = array();
								$tracker['booking_status_from'] = $passenger_data->offer_status;
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

				} // have partial acsr rules 
			} else {
				//exclude
				$array = array();
				$offer_status = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
				$array['booking_status'] = $offer_status;
				$array["modify_date"] = time();
				$array["modify_userID"] = $this->session->userdata('loginuserID');
				// update extension table with new status
				$p_list = explode(',',$passenger_data->p_list);
				$this->offer_eligibility_m->update_dtpfext($array,$p_list);

				$array = array();
				$array['offer_status'] = $offer_status;
				$array['product_id'] = $feed->product_id;
				$array["modify_date"] = time();
				$array["modify_userID"] = $this->session->userdata('loginuserID');
				$this->offer_reference_m->update_offer_ref($array,$feed->offer_id);

				// update tracker about change in status
				$tracker = array();
				$tracker['booking_status_from'] = $passenger_data->offer_status;
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
		
		if($maildata['offer_id'])
		{
			

			$offerdt = $this->offer_issue_m->getOfferDetailsByOfferId($maildata['offer_id']);
			
			$maildata['pnr_ref']=$offerdt[0]->pnr_ref;
		}
			$pnr_ref=$maildata['pnr_ref'];
			$offer = $this->bid_m->getPassengers($maildata['pnr_ref']);
			
			if (!$offer[0]->carrier_code) {
				echo "<br>missing passenger deails for  $pnr_ref";
				return;
			}
			
			$prodlist = explode(',',$offer[0]->products);
			$email_list = explode(',',$offer[0]->email_list);

			$baggage_offer = 0;
			$upgrade_offer = 0;
			$exclude = $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
		$cabins  = $this->airline_cabin_m->getAirlineCabins();
		foreach ($prodlist as $prodId) {
			switch ($prodId) {
			case 1:
				$upgrade_offer = 1;
				$results = $this->bid_m->getUpgradeOffers($pnr_ref);
				if(count($results)>0){
					foreach($results as $result){
					  $result->to_cabins = explode(',',$result->to_cabins);
					  $dept = date('d-m-Y H:i:s',$result->dep_date+$result->dept_time);
					  $arrival =  date('d-m-Y H:i:s',$result->arrival_date+$result->arrival_time);
					  $dteStart = new DateTime($dept); 
					  $dteEnd   = new DateTime($arrival); 
					  $dteDiff  = $dteStart->diff($dteEnd);
					  $result->time_diff = $dteDiff->format('%H hrs %i Min');
					  $cdata = array();
						  foreach($result->to_cabins as $value){
								$cdata = explode('-',$value);              		
								if($cdata[2] != $exclude){
									$tocabins[$cdata[3]] = $cabins[$cdata[0]];
									//$result->tocabins[] = array('cabin_name' => $cabins[$cdata[0]]); 
								}              
							}
							ksort($tocabins);
							foreach($tocabins as $c){
								$result->tocabins[] = array('cabin_name' => $c);
							}
							if($result->fclr != null && !empty($result->tocabins)){			
								$paxdata['dep_date'] = date('D d M Y',$result->dep_date);
								$paxdata['dep_time'] = date('H:i',$result->dept_time);
								$paxdata['arrival_date'] = date('D d M Y',$result->arrival_date);
								$paxdata['arrival_time'] = date('H:i',$result->darrival_time);
								$paxdata['carrier_code'] = $result->carrier_code;
								$paxdata['carrier_name'] = $result->carrier_name;
								$paxdata['flight_number'] = $result->flight_number;
								$paxdata['from_city_code'] = $result->from_city_code;
								$paxdata['from_city'] = $result->from_city;
								$paxdata['to_city_code'] = $result->to_city_code;
								$paxdata['to_city'] = $result->to_city;
								$paxdata['seat_no'] = $result->seat_no;
								$paxdata['current_cabin'] = $result->current_cabin;
								$paxdata['cabins'] = $result->tocabins;
								$paxdata['time_diff'] = $result->time_diff;
								$offerdata[] = $paxdata;
							}
								$maildata['carrier_name'] = $result->carrier_name;
								break;
							}
					  		$maildata['highest_upgrade_class'] = $result->tocabins[0]['cabin_name'];
						}

						//print_r($results); exit();
					break;
					case 2:
						
						$baggage_offer = 1;
						if ( $upgrade_offer) {
							break;//HACK
						}
						$results = $this->offer_issue_m->getBaggageOffer($pnr_ref);
						if(count($results)>0){
						foreach($results as $result){
						  $dept = date('d-m-Y H:i:s',$result->dep_date+$result->dept_time);
						  $arrival =  date('d-m-Y H:i:s',$result->arrival_date+$result->arrival_time);
						  $dteStart = new DateTime($dept); 
						  $dteEnd   = new DateTime($arrival); 
						  $dteDiff  = $dteStart->diff($dteEnd);
						  $result->time_diff = $dteDiff->format('%H hrs %i Min');
						  $cdata = array();
							$paxdata['dep_date'] = date('D d M Y',$result->dep_date);
							$paxdata['dep_time'] = date('H:i',$result->dept_time);
							$paxdata['arrival_date'] = date('D d M Y',$result->arrival_date);
							$paxdata['arrival_time'] = date('H:i',$result->darrival_time);
							$paxdata['carrier_code'] = $result->carrier_code;
							$paxdata['carrier_name'] = $result->carrier_name;
							$paxdata['flight_number'] = $result->flight_number;
							$paxdata['from_city_code'] = $result->from_city_code;
							$paxdata['from_city'] = $result->from_city;
							$paxdata['to_city_code'] = $result->to_city_code;
							$paxdata['to_city'] = $result->to_city;
							$paxdata['seat_no'] = $result->seat_no;
							$paxdata['current_cabin'] = $result->current_cabin;
							$paxdata['cabins'] = $result->tocabins;
							$paxdata['time_diff'] = $result->time_diff;
							$offerdata[] = $paxdata;
							$maildata['carrier_name'] = $result->carrier_name;
							break;
						}
						}
					//print_r($results); exit();
				break;

				default:
			break;
		}
	}
	if($maildata['template'])
	{
		$template=$maildata['template'];
		
	}
	else{
	if ( $baggage_offer && $upgrade_offer ) {
			#echo "<br>UPGRADE & BAGGAGE COMBO OFFER";
			$template = "upgrade_baggage_offer";    
			$maildata['mail_subject'] .= " Upgrade & Baggage offer";    
		} elseif( $upgrade_offer) {
			#echo "<br>UPGRADE OFFER";
			$template = "upgrade_offer";    
			$maildata['mail_subject'] .= " Upgrade offer";    
		} elseif( $baggage_offer) {
			#echo "<br>BAGGAGE OFFER";
			$template = "baggage_offer";    
			$maildata['mail_subject'] .= " Baggage offer";    
		}
	}
		$pax_names = $this->bid_m->getPaxNames($pnr_ref);
	
				$maildata['first_name']=$offer[0]->pax_names;
				$maildata['pnr_ref'] =  $pnr_ref;
                $maildata['offer_data'] = $offerdata;
                $maildata['airlineID'] = $offer[0]->carrier_code;
              //  $maildata['first_name'] = $offer[0]->pax_names;
                $maildata['tomail'] = $email_list[0];
                $primary_client = $this->user_m->getClientByAirline($maildata['airlineID'],6)[0];	   
                $maildata = array_merge($maildata, $paxdata);
		$dir = "assets/mail-temps";
		$tpl = $this->mailandsmstemplate_m->getDefaultMailTemplateByCat($template,$maildata['airlineID']);
		$tpl_file = $tpl->template_path;
    	 $maildata['mail_subject'] = (!empty($tpl->mail_subject)) ? $tpl->mail_subject : "Congratulations! You got great deal ! Grab it..";
		$t = explode('.',$tpl_file);
		$tpl_path = $t[0]. '-imgs';
		if ( $upgrade_offer) {
                 $maildata['up_tpl_bnr'] = base_url("$dir/$tpl_path/banner.jpg");
                 $maildata['up_tpl_bnrtop'] = base_url("$dir/$tpl_path/bannerTop.png");	
                 $maildata['up_tpl_bnrbottom'] = base_url("$dir/$tpl_path/bannerBottom.png");
                 #$maildata['up_tpl_bnrbottom'] = base_url("assets/mail-temps/bg_temp1_images/bannerBottom.png");	
                 #$maildata['up_tpl_contact_img'] = base_url("assets/mail-temps/bg_temp2_images/contactUs.png");	
		}

		if( $baggage_offer) {
                 $maildata['bg_tpl_bnr'] = base_url("$dir/$tpl_path/banner.png");	
                 $maildata['bg_tpl_bnrtop'] = base_url("$dir/$tpl_path/bannerTop.png");	
                 $maildata['bg_tpl_bnrbottom'] = base_url("$dir/$tpl_path/bannerBottom.png");	
                
		}
                 $maildata['open_browser'] = base_url("$dir/$tpl_path/openBrowser.png");
                 $maildata['facebook_icon'] = base_url("$dir/$tpl_path/facebook.png");		
                 $maildata['tag_img'] = base_url("$dir/$tpl_path/tag.png");		
                 $maildata['twitter_icon'] = base_url("$dir/$tpl_path/twitter.png");	
                 $maildata['pinterest_icon'] = base_url("$dir/$tpl_path/pinterest.png");	
                 $maildata['openbrowser_img'] = base_url("$dir/openBrowser.png");
            	 $maildata['airline_logo'] = base_url('uploads/images/'.$this->airline_m->getAirlineLogo($maildata['airlineID'])->logo);            
                 
                 $maildata['domain'] = $primary_client->domain;
                 $maildata['primary_phone'] = $primary_client->phone;
                 $maildata['primary_mail'] = $primary_client->email;
                 $maildata['fb_link'] = "https://facebook.com";
                 $maildata['twitter_link'] = "https://twitter.com";
                 $maildata['pinterest_link'] = "https://pinterest.com";
                 $maildata['unsubscribe_link'] = base_url('home/index');
                 $maildata['forward_friend_link'] = base_url('home/index');
                 $maildata['openbrowser_link'] = base_url('home/index');
                 $maildata['not_intrested_link'] = base_url('home/index');
                 
		   $maildata['base_url'] = base_url(); 
		   $maildata['bidnow_link'] = base_url('homes/bidding?pnr_ref='.$pnr_ref);
		   $template_images = $this->airline_m->getImagesByType($maildata['airlineID']);
		   foreach($template_images as $img){
			   $maildata[$img->type] = base_url('uploads/images/'.$img->image);
		   } 
                 $airline_info = $this->bid_m->getAirlineLogoByPNR($pnr_ref);
		   $maildata['mail_header_color'] = $airline_info->mail_header_color;
		   if(empty($maildata['mail_header_color'])){
			 $maildata['mail_header_color'] = '#333';  
		   }
		   
		   if(isset($maildata['bid_value'])){
			   $maildata['bid_value'] = number_format($maildata['bid_value']);
		   }
		$this->sendMailTemplateParser($template,$maildata);	
		}
}
