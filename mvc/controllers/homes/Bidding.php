<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidding extends MY_Controller {
	
	function __construct () {
		parent::__construct();						
	     $this->load->model("bid_m");
		 $this->load->model("airline_cabin_m");
		 $this->load->model("fclr_m");
		 $this->load->model("preference_m");
		 $this->load->model("offer_eligibility_m");
		 $this->load->model("offer_issue_m");
		 $this->load->model("offer_reference_m");
		 $this->load->model("rafeed_m");
		 $this->load->model('mailandsmstemplate_m');
		 $this->load->model('install_m');
		 $this->load->model('invfeed_m');
		 $this->load->model('airline_m');
		 $this->load->model("reset_m");
		 $this->load->model("user_m");
		 $this->load->model("bclr_m");
		 $this->load->model("contract_m");
		 $this->load->model("baggage_m");
		 $this->load->library('session');
         $this->load->helper('form');
         $this->load->library('form_validation');
         $this->load->library('email');		 
	     $language = $this->session->userdata('lang');	  
		$this->lang->load('bidding', $language);
        $this->load->library('parser'); 

		}
  
    public function index() { 

	$this->load->library('user_agent');
       	if(!empty($this->input->post('pnr_ref'))){
		$pnr_ref = $this->input->post('pnr_ref');
	}
       	if(!empty($this->input->get('pnr_ref'))){
		$pnr_ref = $this->input->get('pnr_ref');
	}

       	if(!empty($pnr_ref)){

				$this->data['pnr_ref'] = $pnr_ref; 
				$offer_ref = $this->offer_reference_m->getOfferDataByRef($pnr_ref);
	//		echo "<pre>OFFERS=" . print_r($offer_ref,1) . "</pre>"; exit;
				if ( !count($offer_ref) ) {
					$this->data['error'] = "Sorry the offer for PNR $pnr_ref is not found! or no longer valid!"; 
				} else {
						$sent_offer_mail = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
						$bid_received = $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
						$bid_accepted = $this->rafeed_m->getDefIdByTypeAndAlias('bid_accepted','20');
						$this->data['excluded_status'] =  $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
						//$bid_confirmation = $this->preference_m->get_preference(array("pref_code" => 'BID_CONFIRMATION'))->pref_value;
						//$bid_expire = $this->preference_m->get_preference(array("pref_code" => 'BID_EXPIRE'))->pref_value;

						foreach($offer_ref as $offer_data) {
							$carrier_id = $offer_data->carrier_code;
							$bid_confirmation = $this->preference_m->get_preference_value_bycode('BID_CONFIRMATION','24',$carrier_id);
							$bid_expire = $this->preference_m->get_preference_value_bycode('BID_EXPIRE','24',$carrier_id);		

							$added_timestamp = strtotime('+'.$bid_expire+$bid_confirmation.' day', time());
							if($added_timestamp > $offer_data->dep_date){
								$this->data['error_'. $offer_data->product_id] = $offer->product_name . " Offer Expired"; 
							}  

							//echo "($sent_offer_mail == $offer_data->offer_status || $bid_received == $offer_data->offer_status)"; exit;
							if($sent_offer_mail == $offer_data->offer_status || $bid_received == $offer_data->offer_status || $bid_accepted == $offer_data->offer_status){
								switch($offer_data->product_id ) {
									case 1: 
										if ( $bid_received == $offer_data->offer_status ) {
											$this->showUpgradeOffer($pnr_ref,'bid_received');
										} else {
											$this->showUpgradeOffer($pnr_ref);
										}
										break;
									case 2: 
										$this->showBaggageOffer($pnr_ref);
									break;
								}
							}
						} 

						$offer = $this->bid_m->getPassengers($pnr_ref);
						$this->data['offer'] = $offer;
						$this->data['pax_names'] = $offer[0]->pax_names; 
						$this->data['passengers_count'] = count(explode(',',$offer[0]->pax_names)); 			
						$carrier_id = $offer[0]->carrier_id;
						
						#print_r($this->data['upgrade'] ); exit;
						//$this->data['tomail'] = explode(',',$this->data['upgrade'][0]->email_list)[0]; 

						$this->data['mile_value'] = $this->preference_m->get_preference_value_bycode('MILES_DOLLAR','24',$carrier_id);	
						$this->data['mile_proportion'] = $this->preference_m->get_preference_value_bycode('MIN_CASH_PROPORTION','24',$carrer_id);	
						$this->data['sent_mail_status'] =  $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
						
						$airline = $this->bid_m->getAirlineLogoByPNR($pnr_ref);
						if(!empty($airline->logo)){
							$this->data['airline_logo'] = base_url('uploads/images/'.$airline->logo);
						} else {
							$this->data['airline_logo'] = base_url('assets/home/images/emir.png');
						}
						$this->data['airline_name'] = $airline->aln_data_value;
						  
						$this->data['mail_header_color'] = $airline->mail_header_color;
						if(empty($this->data['mail_header_color'])){
							 $this->data['mail_header_color'] = '#333';  
						}

						$this->data['images'] = $this->airline_m->getImagesByType($airline->airlineID,'gallery');
						$this->data['airline_video_link'] = str_replace('watch?v=','embed/',$airline->video_links);		 
				}
			} else {
					$this->data['error'] = 'OOPS! PNR MISSING';
			}
			#echo "<pre>" . print_r($this->data['baggage'],1) . "</pre>"; exit;
			$this->data["subview"] = "home/bidview";
			$this->load->view('_layout_home', $this->data);
		}

		function showUpgradeOffer ($pnr_ref, $bidstatus = '') {

			if ( $pnr_ref ) {

				$upgrade = $this->bid_m->getUpgradeOffers($pnr_ref, $bidstatus);
				$this->data['upgrade'] =  $upgrade;
			//	echo "<pre>UPGRADE=" . print_r($upgrade,1) . "</pre>"; exit;
				foreach($this->data['upgrade'] as $result ){
					$this->data['offer_id_'. $result->product_id] = $result->offer_id;
					$this->data['upgrade_offer'] = 1;
					if ( $result->bid_id) {
						$this->data['bid_id_'. $result->product_id] = $result->bid_id;
						$this->data['last_bid_value_'. $result->product_id] += $result->bid_value;
						$this->data['last_bid_total_value'] += $result->bid_value;
					}
					//reducing duplicate names for multi cabins case
					$result->pax_names = $this->bid_m->getPaxNames($pnr_ref);
					$tocabins = array();
					$tocabins1 = array();
					$result->to_cabins = explode(',',$result->to_cabins);
					foreach($result->to_cabins as $value){
						$data = explode('-',$value);
						 $tocabins1[$data[3]][$data[1].'-'.$data[2]] = $data[0];
							}			  
						// asort($tocabins1);
					ksort($tocabins1);
					foreach($tocabins1 as $cabins){
						  foreach($cabins as $key => $value){
							$tocabins[$key] = $value;
						  }					  
					} 
							$result->to_cabins = $tocabins;
					   
					$dept = date('d-m-Y H:i:s',$result->dep_date+$result->dept_time);
					$arrival =  date('d-m-Y H:i:s',$result->arrival_date+$result->arrival_time);
					$dteStart = new DateTime($dept); 
					$dteEnd   = new DateTime($arrival); 
					$dteDiff  = $dteStart->diff($dteEnd);
					$result->time_diff = $dteDiff->format('%d days %H hours %i min');
				}      
		 
				//$this->data['cabins']  = $this->airline_cabin_m->getAirlineCabins();
				$this->data['cabins']  = $this->bid_m->get_cabins($this->data['upgrade'][0]->carrier);
			   // $this->data['mile_value'] = $this->preference_m->get_preference(array("pref_code" => 'MILES_DOLLAR'))->pref_value;
				// $this->data['mile_proportion'] = $this->preference_m->get_preference(array("pref_code" => 'MIN_CASH_PROPORTION'))->pref_value;
			} else {
				$this->data['error'] .= '<br>OOPS! PNR FOR OFFER MISSING';
			}
		}

		function showBaggageOffer ($pnr_ref) {
			if ( $pnr_ref ) {
					$airline = $this->bid_m->getAirlineLogoByPNR($pnr_ref);
					$this->data['active_products'] = array_keys($this->offer_issue_m->getProductsforOffer($offerId));
					$bgoffer = $this->offer_issue_m->getBaggageOffer($pnr_ref);

			//	echo "<pre>" . print_r($bgoffer,1) . "</pre>"; exit;
					if ( $bgoffer) {
						$this->data['baggage_bag_type'] = $this->preference_m->get_preference_value_bycode('BAG_TYPE','24',$airline->airlineID);
						$this->data['baggage_min_val'] = $this->preference_m->get_preference_value_bycode('BAGGAGE_MIN_VAL','24',$airline->airlineID);
						$this->data['baggage_max_val'] = $this->preference_m->get_preference_value_bycode('BAGGAGE_MAX_VAL','24',$airline->airlineID);
						$this->data['piece'] = $this->preference_m->get_preference_value_bycode('PIECE','24',$airline->airlineID);
						// var_dump($pnr_ref);
						$test="SELECT vx.carrier_code, b.bid_id, SUM(b.bid_value) as bid_value, SUM(b.weight) as weight, o.offer_id, v.product_id, v.dtpfext_id,v.dtpf_id,v.rule_id,v.ond,vx.pnr_ref,vx.from_city,vx.to_city,vxx.min_unit,vxx.max_capacity,vxx.min_price,vxx.max_price,vxxx.flight_number,vx.dep_date,vx.arrival_date,vx.dept_time,vx.arrival_time FROM VX_offer_info v LEFT JOIN VX_daily_tkt_pax_feed vx ON v.dtpf_id = vx.dtpf_id LEFT JOIN BG_baggage_control_rule vxx ON v.rule_id = vxx.bclr_id LEFT JOIN VX_daily_tkt_pax_feed vxxx ON vx.dtpfraw_id = vxxx.dtpfraw_id LEFT JOIN UP_bid b ON (b.dtpfext_id = v.dtpfext_id AND b.productID = v.product_id AND v.product_id = 2 AND b.active = 1) LEFT JOIN VX_offer o ON ( o.pnr_ref = vx.pnr_ref ) WHERE v.active =1 AND vx.active =1 AND vxxx.active = 1 AND o.active = 1  AND v.ond>=1 AND vx.pnr_ref = '$pnr_ref' GROUP BY v.dtpfext_id";
						$rquery = $this->install_m->run_query($test);
						// var_dump($rquery);
						$mr=[];
						$yy=[];
						foreach($rquery as $rq){
							$mr[$rq->ond][$rq->dtpf_id]['from_city']=$rq->from_city;
							$mr[$rq->ond][$rq->dtpf_id]['carrier_code']=$rq->carrier_code;
							$mr[$rq->ond][$rq->dtpf_id]['bid_id']=$rq->bid_id;
							$mr[$rq->ond][$rq->dtpf_id]['to_city']=$rq->to_city;
							$mr[$rq->ond][$rq->dtpf_id]['dtpf_id']=$rq->dtpf_id;
							$mr[$rq->ond][$rq->dtpf_id]['dtpfext_id']=$rq->dtpfext_id;
							$mr[$rq->ond][$rq->dtpf_id]['pnr_ref']=$rq->pnr_ref;
							$mr[$rq->ond][$rq->dtpf_id]['ond']=$rq->ond;
							$mr[$rq->ond][$rq->dtpf_id]['rule_id']=$rq->rule_id;
							$mr[$rq->ond][$rq->dtpf_id]['product_id']=$rq->product_id;
							$mr[$rq->ond][$rq->dtpf_id]['offer_id']=$rq->offer_id;
							$mr[$rq->ond][$rq->dtpf_id]['bid_value']=$rq->bid_value;
							$mr[$rq->ond][$rq->dtpf_id]['flight_number']=$rq->flight_number;
							$mr[$rq->ond][$rq->dtpf_id]['dep_date']=$rq->dep_date;
							$mr[$rq->ond][$rq->dtpf_id]['arrival_date']=$rq->arrival_date;
							$mr[$rq->ond][$rq->dtpf_id]['dept_time']=$rq->dept_time;
							$mr[$rq->ond][$rq->dtpf_id]['arrival_time']=$rq->arrival_time;
							$this->data['offer_id_'. $rq->product_id] = $rq->offer_id;
							if ( $rq->bid_id) {
								$this->data['bid_id_'. $rq->product_id] = $rq->bid_id;
								$this->data['last_bid_value_'. $rq->product_id] += $rq->bid_value;
								$this->data['last_weight_value_'. $rq->product_id] += $rq->weight;
								$this->data['last_bid_total_value'] += $rq->bid_value;
							}

					}
				
				foreach($mr as $key => $value){
					$yy[$key]['first_one']=reset($value);
					$yy[$key]['last_one']=end($value);
				}

				
				
				$tr=[];
				foreach($yy as $key1 => $value1){
					// var_dump($value1,"<br>");
					$tr[$key1]['from_city']=$value1['first_one']['from_city'];
					$tr[$key1]['carrier_code']=$value1['first_one']['carrier_code'];
					$tr[$key1]['from_airport']=$this->getAirportName($value1['first_one']['from_city']);
					$tr[$key1]['to_airport']=$this->getAirportName($value1['last_one']['to_city']);
					$tr[$key1]['from_city_name']=$this->getCityName($value1['first_one']['from_city']);
					$tr[$key1]['to_city_name']=$this->getCityName($value1['last_one']['to_city']);
					$tr[$key1]['dtpf_id']=$value1['first_one']['dtpf_id'];
					$tr[$key1]['product_id']=$value1['first_one']['product_id'];
					$tr[$key1]['offer_id']=$value1['first_one']['offer_id'];
					$tr[$key1]['dtpfext_id']=$value1['first_one']['dtpfext_id'];
					$tr[$key1]['to_city']=$value1['last_one']['to_city'];
					$tr[$key1]['ond']=$value1['last_one']['ond'];
					$tr[$key1]['pnr_ref']=$value1['last_one']['pnr_ref'];
					$tr[$key1]['rule_id']=$value1['first_one']['rule_id'];

					$tr[$key1]['flight_number']=$value1['first_one']['flight_number'];
					$tr[$key1]['dep_date']=$value1['first_one']['dep_date'];
					$tr[$key1]['arrival_date']=$value1['last_one']['arrival_date'];
					$tr[$key1]['dept_time']=$value1['first_one']['dept_time'];
					$tr[$key1]['arrival_time']=$value1['last_one']['arrival_time'];
				}
				// var_dump($tr);
				// die();
				$sum_query="SELECT b.weight,vxx.bclr_id, b.bid_id, b.bid_value, v.product_id, vxx.min_unit, vxx.max_price, vxx.min_price ,vxx.max_capacity,v.ond,v.dtpfext_id FROM VX_offer_info v LEFT JOIN VX_daily_tkt_pax_feed vx ON v.dtpf_id = vx.dtpf_id LEFT JOIN BG_baggage_control_rule vxx ON v.rule_id = vxx.bclr_id LEFT JOIN UP_bid b ON (b.dtpfext_id = v.dtpfext_id AND b.productID = v.product_id AND v.product_id = 2 AND b.active = 1 )  LEFT JOIN VX_offer o ON (v.product_id = v.product_id AND o.product_id = 2 AND vx.pnr_ref = o.pnr_ref) WHERE o.active = 1 AND v.active = 1 AND vx.active = 1 AND v.ond>=1 AND vx.pnr_ref = '$pnr_ref' ORDER BY v.ond ASC";
				$sum_res = $this->install_m->run_query($sum_query);
		//	echo $sum_query;
				// var_dump($sum_res);
				// die();
				$last_ond = 0;
				foreach($sum_res as $res){
					if ( $res->ond != $last_ond ) {
						$per_min = 0;
						$wt_purchased = 0;
						$per_max=$this->data['baggage_max_val'];//Max KG  user user can buy
					} 
					//Calculate Min Baggage purchase value
					$last_ond =  $res->ond;
					if ( $res->min_unit ) {
						if ( $per_min ) {
							$per_min = ($per_min > $res->min_unit ) ? $per_min : $res->min_unit; 
						} else {
							$per_min = $res->min_unit;
						}
					} else {
						if ( !$per_min ) {// Use Default value
							$per_min = $this->data['baggage_min_val'];
						}
					}

					//Calculate Max Baggage purchase value
					$inv = array();
					$inv['flight_nbr'] = $tr[$res->ond]['flight_number'];
					$inv['airline_id'] =  $tr[$res->ond]['carrier_code'];
					$inv['departure_date'] = $tr[$res->ond]['dep_date'];
					$inv['origin_airport'] = $tr[$res->ond]['from_city'];
					$inv['dest_airport'] = $tr[$res->ond]['to_city'];
					$inv['active'] = 1;
					$wt_sold = $this->invfeed_m->getSoldWeight($inv);

					if ( $res->max_capacity ) {
						$max_diff = $res->max_capacity - $wt_sold;
						if ( $per_max ) {
							$per_max = ($per_max < $max_diff ) ? $per_max : $max_diff; 
						} else {
							$per_max  = $max_diff;
						}
					} else {
						if (!$per_max) {
							$per_max=$this->data['baggage_max_val'];//Max KG  user user can buy
						}
					}

					$wt_purchased += $res->weight;


					if ( $per_max < $per_min ) {
						//Don't allow to buy at all
						continue;	
					}

					#$per_min = 5;
					#$per_max = 51;

					$piece = $this->data['piece'];
					$price=$res->min_price;

					$tr[$res->ond]['per_min']=$per_min;
					$tr[$res->ond]['wt_purchased']=$wt_purchased;
					$tr[$res->ond]['piece']=$piece;
					$tr[$res->ond]['per_max']=$per_max;
					$tr[$res->ond]['sold_out'][$res->bclr_id]= $wt_sold ? $wt_sold : 0;
					if ( !in_array($res->bclr_id,$tr[$res->ond]['bclrids'])) {
						$tr[$res->ond]['bclrids'][]=$res->bclr_id;
					}
					#$tr[$res->ond]['bclrids'][]=74;
				}

#print_r($tr);
				if ( count($tr) ) {
					$this->data['baggage_offer'] = 1;
				}

				foreach($tr as $bg ) {
					$bclrdata = $this->bclr_m->get_bclr($bg['rule_id']);
					$this->data['bclr'][$bg['ond']] = $bclrdata;
					if ( $tr[$bg['ond']]['wt_purchased'] ) {
						$bg['per_max'] =  $tr[$bg['ond']]['per_max'] - $tr[$bg['ond']]['wt_purchased'];//Dont allow to buy over weight
					}
					$this->data['baggage'][$bg['dtpf_id']]['pax'] = $bg;
				}

				foreach($tr as $ond => $bg ) {
					$cwtdata = Array();
					foreach($bg['bclrids'] as $bclrID ) {
						$tmp_cwtdata = $this->bclr_m->getActiveCWT($bclrID,($bg['sold_out'][$bclrID] ? $bg['sold_out'][$bclrID] : 0),($bg['per_max'] + $bg['per_min']));
						$i = 1;
						foreach($tmp_cwtdata as $key => $item ) {
								$cwtdata[$i] += $item['price_per_kg'];
								$i++;
						}
					}
					$this->data['cwtdata'][$ond] = $cwtdata;
				}
				//print_r($this->data['cwtdata']);exit;
			}
		} else {
				$this->data['error'] .= '<br>OOPS! PNR FOR UPGRADE OFFER MISSING';
		}
	}
	
	public function getFclrValues(){
		if($this->input->post('fclr_id')){
			$json = $this->fclr_m->get_single_fclr(array('fclr_id'=>$this->input->post('fclr_id')));
		} else{
			$json = "no id";
		}
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}

	public function getAirportName($id){
		$query = "SELECT aln_data_value FROM `VX_data_defns` WHERE VX_aln_data_defnsID='$id'";
		$airport = $this->install_m->run_query($query);
		$data = $airport[0]->aln_data_value;
		
		return $data;
		
	}
	
	public function getCityName($id){
		$query1 = "SELECT parentID FROM `VX_data_defns` WHERE VX_aln_data_defnsID='$id'";
		$result = $this->install_m->run_query($query1);
		
		$parent_id = $result[0]->parentID;
		// var_dump($parent_id);
		// die();
		
		$query2 = "SELECT aln_data_value FROM `VX_data_defns` WHERE VX_aln_data_defnsID='$parent_id'
		";
		$result1 = $this->install_m->run_query($query2);
		$city = $result1[0]->aln_data_value;
		return $city;
	}

	public function saveBidData(){		
				$product_id = $this->input->post("product_id");
            	$bid_id  = $this->input->post('bid_id');
            	$offer_id  = $this->input->post('offer_id');
		if($this->input->post('offer_id')){ 		
            if($bid_id && $product_id){//Bid  Resubmit case
               $this->saveBiddingHistory($this->input->post('offer_id'));
	    }          
			
		$data = Array();
		    $id = 0;
			switch($product_id) {
			case 1:		
				//Deactive old Bid records for this offer if any for same product offer
            			if($bid_id && $product_id){//Bid  Resubmit case
					$data['active'] = 0;
					$this->bid_m->update_bid($data, $product_id, $offer_id);			
					$data = Array();
				}

				$data['upgrade_type'] = $this->input->post("upgrade_type");
				$data['cash'] = ($this->input->post("bid_value") / $this->input->post("tot_bid"))*$this->input->post("tot_cash");
				$data['miles'] = ($this->input->post("bid_value") / $this->input->post("tot_bid"))*$this->input->post("tot_miles");
				$data["cash_percentage"] = round((($data['cash']/ $this->input->post("tot_bid"))*100),2);
				$data['offer_id'] = $this->input->post('offer_id');			
				$data['bid_value'] = $this->input->post("bid_value");	
				$data['dtpfext_id'] = $this->input->post("dtpfext_id");
				$data['flight_number'] = $this->input->post("flight_number");	
				$data['orderID'] = $this->input->post("orderID");
				$data['active'] = 1;
				$data['productID'] = 1;
				$id  = $this->bid_m->checkBidExists($data);
				if ( $id) {  //Just inform bid submitted nothing to do
					$json['status'] = "bid_submitted";
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode($json));
					return;
				} else {//Create New one
					$data['bid_submit_date'] = time();
					$data['orderID'] = $this->input->post('orderID');
          				$id = $this->bid_m->insert_bid_data($data);		//Always allow excess baggage till offer expired
					$bid_status = 'bid_received';
				}
				break;
			case 2:
				$data['weight'] = $this->input->post("weight");	
				$data['bid_value'] = $this->input->post("baggage_value");	
				$data['cash'] = $this->input->post("tot_cash");
				$data['active'] = 1;
				$data['miles'] = $this->input->post("tot_miles");
				$data["cash_percentage"] = round((($data['cash']/ $this->input->post("tot_bid"))*100),2);
				$data['offer_id'] = $this->input->post('offer_id');			
				$data['dtpfext_id'] = $this->input->post("dtpfext_id");
				$data['ond'] = $this->input->post("ond");
				$data['orderID'] = $this->input->post("orderID");
				$data['productID'] = 2;
				$id  = $this->bid_m->checkBidExists($data);
				if ( $id) {  //Just inform bid submitted nothing to do
					$json['status'] = "Bid submitted Succesfully";
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode($json));
					return;
				} else { //Create New one
					$data['bid_submit_date'] = time();
          				$id = $this->bid_m->insert_bid_data($data);		//Always allow excess baggage till offer expired
					$bid_status = 'bid_accepted';
				}
				break;
				default:
				break;
			}
		
          if($id){
              if($this->input->post('bid_id')){
				$select_passengers_data1 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'bid_received',$this->input->post("fclr_id"),1);
                $select_passengers_data2 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'bid_unselect_cabin',$this->input->post("fclr_id"),1);
				$select_passengers_data->p_list = $select_passengers_data1->p_list;
				$select_passengers_data->p_list .= (!empty($select_passengers_data2->p_list))?','.$select_passengers_data2->p_list:'';
                // print_r('Select Passengers Data '.$select_passengers_data2->p_list);
                 $unselect_passengers_data1 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'bid_received',$this->input->post("fclr_id"));
                 $unselect_passengers_data2 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'bid_unselect_cabin',$this->input->post("fclr_id")); 
                 $unselect_passengers_data->p_list = $unselect_passengers_data1->p_list;
				 $unselect_passengers_data->p_list .= (!empty($unselect_passengers_data2->p_list))?','.$unselect_passengers_data2->p_list:''; 
				// print_r('UNSelect Passengers Data '.$select_passengers_data->p_list); exit;
              } else {
			     $select_passengers_data = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'sent_offer_mail',$this->input->post("fclr_id"),1,$product_id);
			     $unselect_passengers_data2 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'sent_offer_mail',$this->input->post("fclr_id"),0,$product_id);
	  }
				$select_status = $this->rafeed_m->getDefIdByTypeAndAlias($bid_status,'20');
			  	$unselect_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_unselect_cabin','20');
			  	$array['booking_status'] = $select_status;
          		     $array["modify_date"] = time(); 
			  
			   $select_p_list = explode(',',$select_passengers_data->p_list);
			   $unselect_p_list = explode(',',$unselect_passengers_data->p_list);
			  /*  $this->mydebug->debug("selected and un selected list");
               $this->mydebug->debug($select_passengers_data->p_list);
			   $this->mydebug->debug($unselect_passengers_data->p_list); */
			   
             $this->offer_eligibility_m->update_dtpfext(array("booking_status" => $select_status,"modify_date"=>time()),$select_p_list);
	     $this->offer_eligibility_m->update_dtpfext(array("booking_status" => $unselect_status,"modify_date"=>time()),$unselect_p_list);

						$array = array();
						$array['offer_status'] = $select_status;
						$array['product_id'] = $product_id;
						$array["modify_date"] = time();
						$array["modify_userID"] = $this->session->userdata('loginuserID');
						$this->offer_reference_m->update_offer_ref($array,$this->input->post('offer_id'));
              
               // updating bid status tracker
              if($this->input->post('bid_id')){
                 $tracker = array();				 
				 $tracker['comment'] = 'Bid Resubmited By Customer';
			     $tracker["create_date"] = time();
                 $tracker["modify_date"] = time(); 				  
                 $p_list1 = explode(',',$select_passengers_data2->p_list); 			  
				 if(!empty($select_passengers_data2->p_list)){				                                         
              	 foreach($p_list1 as $id) {
                    $tracker['booking_status_from'] = $unselect_status;
		    $tracker['booking_status_to'] = $select_status;
		    $tracker['dtpfext_id'] = $id;
                    $this->offer_issue_m->insert_dtpf_tracker($tracker);
				 }
		}
                $p_list2 = explode(',',$unselect_passengers_data1->p_list);                 
				if(!empty($unselect_passengers_data1->p_list)){
              	 foreach($p_list2 as $id) {
                    $tracker['booking_status_from'] = $select_status;
				    $tracker['booking_status_to'] = $unselect_status;
					$tracker['dtpfext_id'] = $id;
                    $this->offer_issue_m->insert_dtpf_tracker($tracker);
				 }
				}
              }
 			  
			   //send bid success mail
			   $offer_data = $this->bid_m->get_offer_data($this->input->post("offer_id"));
			   $maildata = (array)$offer_data;
			   $maildata['dep_date'] = date('d/m/Y',$maildata['dep_date']);
			   $maildata['dep_time'] = gmdate('H:i A',$maildata['dept_time']);
			   $maildata['cash'] = number_format($this->input->post("bid_value"));
			   $maildata['base_url'] = base_url();			    		
			   $maildata['tomail'] = explode(',',$maildata['email_list'])[0]; 
			   $maildata['type'] = $this->input->post('type');
			   $maildata['resubmit_link'] = base_url('homes/bidding?pnr_ref='.$maildata['pnr_ref']);
			   $maildata['cancel_link'] = base_url('homes/bidding?pnr_ref='.$maildata['pnr_ref']);
			   $maildata['bid_value'] = number_format($maildata['cash']);

				switch ($product_id) {
					Case 1:
			    	// calculate average and rank
                 	 $bid_array['flight_number'] =  $data['flight_number'];
                 	 $bid_array['upgrade_type'] = $data['upgrade_type'];
                 	 $fly_data = $this->offer_issue_m->get_flight_date($data['offer_id'],$data['flight_number']);
                 	 $bid_array['flight_date'] = $fly_data->dep_date;
                  	 $bid_array['carrier_code'] = $fly_data->carrier_code;
		  		 	 $bid_array['from_cabin'] = $fly_data->cabin;
                  	 $this->offer_issue_m->calculateBidAvg($bid_array);

					if($bid_id) {
						$maildata['template'] = 'bid_resubmit';
					} else {
						$maildata['template'] = 'bid_received';
					}
					break;

					Case 2:
					$maildata['template'] = 'baggage_confirmed';
				    $maildata['bg_weight']= $data['weight'];
				    $maildata['bg_bid_value']= number_format($data['cash']);
					break;
					default:
					break;
				}
				$maildata['offer_id']=$offer_id;
			   // $maildata['tomail'] = 'vamsi63@gmail.com';
				$this->upgradeOfferMail($maildata);
			    $json['status'] = "success";
    	    } else {
			    $json['status'] = "Unable to save bid!";
			}	

             if($this->input->post('bid_id')){
                 $extention_data1 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'bid_received');
                 $extention_data2 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'bid_unselect_cabin');
                 $extention_data->p_list = $extention_data1->p_list.','.$extention_data->p_list;
             } else {
        		 $extention_data = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'sent_offer_mail'); 
             }
			 $no_bid_Status = $this->rafeed_m->getDefIdByTypeAndAlias('no_bid','20');
			// $this->mydebug->debug("extension list");
			  $p_list = explode(',',$extention_data->p_list);
			 // $this->mydebug->debug($extention_data->p_list);		 
              $this->offer_eligibility_m->update_dtpfext(array("booking_status" => $no_bid_Status,"modify_date"=>time()),$p_list);
			  $json['status'] = "success";
		}else{
			$json['status'] = "send offer_id";
		}
		
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}

	
	public function saveBaggageData(){
		if($this->input->post('offer_id')){
			//$this->mydebug->debug($_POST);
			if($this->input->post('bid_id')){
				$this->saveBaggageHistory($this->input->post('offer_id'));
			 }
			$data['cash'] = ($this->input->post("baggage_value") / $this->input->post("tot_bid"))*$this->input->post("tot_cash");
			$data['miles'] = ($this->input->post("baggage_value") / $this->input->post("tot_bid"))*$this->input->post("tot_miles");
			$data["cash_percentage"] = round((($data['cash']/ $this->input->post("tot_bid"))*100),2);
			$data['offer_id'] = $this->input->post('offer_id');			
			$data['weight'] = $this->input->post("weight");			
			// $data['flight_number'] = $this->input->post($bslider['flight_number']);
			$data['bid_value'] = $this->input->post("baggage_value");
			$data['bid_submit_date'] = time();
			$data['active'] = 1;
			$data['orderID'] = $this->input->post('orderID');
			$data['productID'] = 2;
            $id = $this->bid_m->save_bid_data($data);
		} else {
			$json['status'] = "Please send Offer ID";
		}
		$json['status'] = 'success';
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'card_number', 
				'label' => $this->lang->line("bid_card_number"), 
				'rules' => 'trim|required|max_length[16]|min_length[16]|numeric|xss_clean'
			),			
			array(
				'field' => 'year_expiry', 
				'label' => "Year", 
				'rules' => 'trim|required|max_length[02]|min_length[02]|numeric|xss_clean|callback_valYear'
			),
			array(
				'field' => 'month_expiry', 
				'label' => "Month",				
				'rules' => 'trim|required|max_length[02]|min_length[02]|numeric|xss_clean|callback_valMonth'
			),
			array(
				'field' => 'cvv', 
				'label' => $this->lang->line("bid_cvv"), 
				'rules' => 'trim|required|max_length[03]|min_length[02]|numeric|xss_clean'
			)
		);
		return $rules;
	}
	
	public function valMonth(){
		$cur_month = date('m');
		$cur_year = date('y');
		if(empty($this->input->post('month_expiry'))){
			$this->form_validation->set_message("valMonth", "%s is required");
			return FALSE;
		} else {
		  if($this->input->post('month_expiry') > 12){
			$this->form_validation->set_message("valMonth", "%s is invalid");
				return FALSE;  
		  } else {
			if($this->input->post('month_expiry') < $cur_month && $this->input->post('year_expiry') <= $cur_year){
				$this->form_validation->set_message("valMonth", "%s is Expired");
				return FALSE;
			} else {
				return TRUE;
			} 
          }			
		}
	}
	
	public function valYear(){
		$cur_month = date('m');
		$cur_year = date('y');
		if(empty($this->input->post('year_expiry'))){
			$this->form_validation->set_message("valYear", "%s is required");
			return FALSE;
		} else {
			if($this->input->post('year_expiry') >= $cur_year){
				return TRUE;
			}else {
				$this->form_validation->set_message("valYear", "%s is Expired");
				return FALSE;
			}
		}
	}
	
	public function saveCardData(){
		 if($this->input->post('pnr_ref')) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$json['status'] = validation_errors();		
			} else {
			$data['pnr_ref'] = $this->input->post('pnr_ref');
			$data['card_number'] = $this->input->post("card_number");
			$data['month_expiry'] = $this->input->post("month_expiry");
			$data['year_expiry'] = $this->input->post("year_expiry");
			$data['cvv'] = $this->input->post("cvv");
			$data['amount'] = $this->input->post("tot_bid");
			$data['cash'] = $this->input->post("cash");
			$data['cash_miles'] = $this->input->post("cash_miles");
			$data['miles'] = $this->input->post("miles");
			$id  = $this->bid_m->checkRecentSavedCard($data);
			if ( !$id) { // Don not create duplicate records, use recent card_id records created
				$orderID =  $this->bid_m->create_order();
				$json['orderID'] = $orderID;
				$data['orderID'] = $orderID;
				$data['date_added'] = time();			
				$id = $this->bid_m->save_card_data($data);
			}
			if($id){
			  $json['status'] = "success";
		    	} else {
				$json['status'] = "save card ERROR";
			}
		  }			
		}else{
			$json['status'] = "send PNR";
		}	 	 
		$this->output->set_content_type('application/json');
        	$this->output->set_output(json_encode($json));
	}

	public function saveOfferData(){
		 if($this->input->post('pnr_ref')) {
			$select_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
			$data['pnr_ref'] = $this->input->post('pnr_ref');
			$data['orderID'] = $this->input->post("order_id");
			$data['amount'] = $this->input->post("amount");
			$data['cash'] = $this->input->post("cash");
			$data['cash_miles'] = $this->input->post("cash_miles");
			$data['miles'] = $this->input->post("miles");
			$data['offer_status'] = $select_status;
			$data['product_id'] = $this->input->post("product_id");
			$data["modify_date"] = time();
			if($data['cash'] != 0){
			    $data["cash_percentage"] = round((($data['cash']/ $data['cash'])*100),2);
			} else {
				$data["cash_percentage"] = 0;   
			}
			$this->offer_reference_m->update_offer_ref($data,$this->input->post('offer_id'));
			$json['status'] = "success";
		}else{
			$json['status'] = "send PNR";
		}	 	 
		$this->output->set_content_type('application/json');
        	$this->output->set_output(json_encode($json));
	}
	
    public function saveBiddingHistory($offer_id){
         $bid_data = $this->bid_m->getBidData($offer_id);
         foreach($bid_data as $data){
            $data->date = time();
            $this->bid_m->addBidHistory($data);
         }
         return true;        
	}
	
	public function saveBaggageHistory($offer_id){
		$baggage_data = $this->baggage_m->get_baggage($offer_id);
		foreach($baggage_data as $data){
		   $data->date = time();
		   $this->baggage_m->insert_baggage_history($data);
		}
		return true;        
   }
	
	public function getCabinImages(){
		$json['cabin_images'] = $this->bid_m->getCarrierCabinImages($this->input->post('carrierID'),$this->input->post('cabin'));
        $cabin_videos = $this->bid_m->getCarrierCabinVideos($this->input->post('carrierID'),$this->input->post('cabin'));
		$json['cabin_videos'] = array();		
		
			foreach($cabin_videos as $link){
				$links = explode(',',$link->video_links);
				if(count($links) > 0){
					foreach($links as $lin){
					$json['cabin_videos'][]=str_replace('watch?v=','embed/',$lin);
					}
				}
		    }
		
		 if (isset($_SERVER)) {		
		    header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			header('Access-Control-Max-Age: 1000');
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));	
	}

	public function getBgSliderValue(){
		$json['status'] = "success";
		$json['value'] = rand();
		$this->output->set_content_type('application/json');
        	$this->output->set_output(json_encode($json));
	}
}
