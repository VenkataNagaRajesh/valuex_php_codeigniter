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
		 $this->load->model('airline_m');
		 $this->load->model("reset_m");
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
		if ($this->agent->is_mobile()){
			$this->data['mobile_view'] ="mb_";
        } else {
		   $this->data['mobile_view'] = "";
		}
      //$this->session->set_userdata('pnr_ref','AS0414');
      //$this->session->set_userdata('validation_check',1);	 
       if(!empty($this->input->get('pnr_ref'))){
		   $this->data['error'] = $this->allowValidation($this->input->get('pnr_ref'));
           if(empty($this->data['error'])){
			 $this->session->set_userdata('validation_check', 1);
			 $this->session->set_userdata('pnr_ref',$this->input->get('pnr_ref'));
		   } else {
			  // print_r($this->data['error']); exit;
			  $this->session->set_flashdata('error', $this->data['error']);
			  redirect(base_url('home/index?pnr_ref='.$this->input->get('pnr_ref'))); 
		   } 
	   }  

		if($this->session->userdata('validation_check') != 1 || empty($this->session->userdata('pnr_ref'))){
			redirect(base_url('home/index'));
			$this->session->unset_userdata('pnr_ref');
		}
		
		$this->data['results'] = $this->bid_m->getPassengers($this->session->userdata('pnr_ref'));
		#print_r($this->data['results'] ); exit;
		//$this->data['tomail'] = explode(',',$this->data['results'][0]->email_list)[0]; 
		if(empty($this->data['results'])){
			redirect(base_url('home/index'));
		}
               
			$offerId = 0;
		foreach($this->data['results'] as $result ){
			$offerId = $result->offer_id;
			//reducing duplicate names for multi cabins case
			$result->pax_names = $this->bid_m->getPaxNames($this->session->userdata('pnr_ref'));
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
            		$this->data['passengers_count'] = count(explode(',',$result->pax_names)); 			
     	}      
        //$this->data['cabins']  = $this->airline_cabin_m->getAirlineCabins();
		$this->data['cabins']  = $this->bid_m->get_cabins($this->data['results'][0]->carrier);
       // $this->data['mile_value'] = $this->preference_m->get_preference(array("pref_code" => 'MILES_DOLLAR'))->pref_value;
        // $this->data['mile_proportion'] = $this->preference_m->get_preference(array("pref_code" => 'MIN_CASH_PROPORTION'))->pref_value;
		
          $this->data['mile_value'] = $this->preference_m->get_preference_value_bycode('MILES_DOLLAR','24',$this->data['results'][0]->carrier);	
         $this->data['mile_proportion'] = $this->preference_m->get_preference_value_bycode('MIN_CASH_PROPORTION','24',$this->data['results'][0]->carrier);	
		 
		$this->data['sent_mail_status'] =  $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
		$this->data['excluded_status'] =  $this->rafeed_m->getDefIdByTypeAndAlias('excl','20');
		
		if(!empty($this->session->userdata('pnr_ref'))){
		  $airline = $this->bid_m->getAirlineLogoByPNR($this->session->userdata('pnr_ref'));
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
		} else {
			$this->data['airline_logo'] = base_url('assets/home/images/emir.png');	
            $this->data['mail_header_color'] = '#333';			
		}

		$pnr_ref = $this->session->userdata('pnr_ref');
		if ( $pnr_ref ) {
                        $this->data['active_products'] = array_keys($this->offer_issue_m->getProductsforOffer($offerId));
			$bgoffer = $this->offer_issue_m->getBaggageOffer($pnr_ref);
		#echo "<pre>" . print_r($bgoffer,1) . "</pre>"; exit;
			if ( $bgoffer) {
				$this->data['baggage_bag_type'] = $this->preference_m->get_preference_value_bycode('BAG_TYPE','24',$airline->airlineID);
				$this->data['baggage_min_val'] = $this->preference_m->get_preference_value_bycode('BAGGAGE_MIN_VAL','24',$airline->airlineID);
				$this->data['baggage_max_val'] = $this->preference_m->get_preference_value_bycode('BAGGAGE_MAX_VAL','24',$airline->airlineID);
				$this->data['piece'] = $this->preference_m->get_preference_value_bycode('PIECE','24',$airline->airlineID);
				$pnr_ref=$this->session->userdata('pnr_ref');
				// var_dump($pnr_ref);
				$test="SELECT v.dtpfext_id,v.dtpf_id,v.rule_id,v.ond,vx.pnr_ref,vx.from_city,vx.to_city,vxx.min_unit,vxx.max_capacity,vxx.min_price,vxx.max_price,vxxx.flight_number,vx.dep_date,vx.arrival_date,vx.dept_time,vx.arrival_time FROM VX_offer_info v LEFT JOIN VX_daily_tkt_pax_feed vx ON v.dtpf_id = vx.dtpf_id LEFT JOIN BG_baggage_control_rule vxx ON v.rule_id = vxx.bclr_id LEFT JOIN VX_daily_tkt_pax_feed_raw vxxx ON vx.dtpfraw_id = vxxx.dtpfraw_id WHERE v.ond>=1 AND vx.pnr_ref = '$pnr_ref'";
				$rquery = $this->install_m->run_query($test);
				// var_dump($rquery);
				$mr=[];
				$yy=[];
				foreach($rquery as $rq){
					$mr[$rq->ond][$rq->dtpf_id]['from_city']=$rq->from_city;
					$mr[$rq->ond][$rq->dtpf_id]['to_city']=$rq->to_city;
					$mr[$rq->ond][$rq->dtpf_id]['dtpf_id']=$rq->dtpf_id;
					$mr[$rq->ond][$rq->dtpf_id]['dtpfext_id']=$rq->dtpfext_id;
					$mr[$rq->ond][$rq->dtpf_id]['pnr_ref']=$rq->pnr_ref;
					$mr[$rq->ond][$rq->dtpf_id]['ond']=$rq->ond;
					$mr[$rq->ond][$rq->dtpf_id]['rule_id']=$rq->rule_id;

					$mr[$rq->ond][$rq->dtpf_id]['flight_number']=$rq->flight_number;
					$mr[$rq->ond][$rq->dtpf_id]['dep_date']=$rq->dep_date;
					$mr[$rq->ond][$rq->dtpf_id]['arrival_date']=$rq->arrival_date;
					$mr[$rq->ond][$rq->dtpf_id]['dept_time']=$rq->dept_time;
					$mr[$rq->ond][$rq->dtpf_id]['arrival_time']=$rq->arrival_time;
				}
				
				foreach($mr as $key => $value){
					$yy[$key]['first_one']=reset($value);
					$yy[$key]['last_one']=end($value);
				}

				
				
				$tr=[];
				foreach($yy as $key1 => $value1){
					// var_dump($value1,"<br>");
					$tr[$key1]['from_city']=$value1['first_one']['from_city'];
					$tr[$key1]['from_airport']=$this->getAirportName($value1['first_one']['from_city']);
					$tr[$key1]['to_airport']=$this->getAirportName($value1['last_one']['to_city']);
					$tr[$key1]['from_city_name']=$this->getCityName($value1['first_one']['from_city']);
					$tr[$key1]['to_city_name']=$this->getCityName($value1['last_one']['to_city']);
					$tr[$key1]['dtpf_id']=$value1['first_one']['dtpf_id'];
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
				$sum_query="SELECT sum(vxx.min_price) as min_price,sum(vxx.max_capacity) as max_capacity,v.ond,v.dtpfext_id FROM VX_offer_info v LEFT JOIN VX_daily_tkt_pax_feed vx ON v.dtpf_id = vx.dtpf_id LEFT JOIN BG_baggage_control_rule vxx ON v.rule_id = vxx.bclr_id WHERE v.ond>=1 AND vx.pnr_ref = '$pnr_ref' group by v.ond";
				$sum_res = $this->install_m->run_query($sum_query);
				// var_dump($sum_res);
				// die();
				foreach($sum_res as $res){
					$per_min=$this->data['baggage_min_val'];
					$per_max=$this->data['baggage_max_val'];
					$piece = $this->data['piece'];

					$price=$res->min_price;
					$total_weight=$res->max_capacity;
					$min=$per_max-$per_min;
					$per_total=$min/$total_weight;
					
					$total_piece=$per_max/$piece;
					$final = $per_min*$per_total;
					$piece_com_tot=$total_piece*$per_total;

					$tr[$res->ond]['per_min']=$per_min;
					$tr[$res->ond]['piece']=$piece;
					$tr[$res->ond]['per_max']=$per_max;
					$tr[$res->ond]['price']=$price;
					$tr[$res->ond]['total_weight']=$total_weight;
					$tr[$res->ond]['total_piece']=$total_piece;
					$tr[$res->ond]['per_total']=$per_total;
					$tr[$res->ond]['piece_com_tot']=$piece_com_tot;
					// $tr[$res->ond]['dtpfext_id']=$dtpfext_id;
				}

				// var_dump($tr);
				// die();
				foreach($tr as $bg ) {
					// var_dump(json_encode($bg,JSON_FORCE_OBJECT),"<br>");
				
					$cwtdata = $this->bclr_m->getActiveCWT($bg['rule_id']);
					$bclrdata = $this->bclr_m->get_bclr($bg['rule_id']);
					$bclrdata->bag_type = $bclrdata->bag_type == 1 ? 'KG' : 'PC';
					$this->data['baggage'][$bg['dtpf_id']]['pax'] = $bg;
					$this->data['cwtdata'][$bg['ond']] = $cwtdata;
					$this->data['bclr'][$bg['ond']] = $bclrdata;
				}
				// $this->data['baggage'][$bg->dtpf_id]['pax'] = $bg;
				// 	$this->data['cwtdata'][$bg->ond] = $cwtdata;
				// 	$this->data['bclr'][$bg->ond] = $bclrdata;

			}
		}
		#echo "<pre>" . print_r($this->data['baggage'],1) . "</pre>"; exit;
		$this->data["subview"] = "home/bidview";
		$this->load->view('_layout_home', $this->data);
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
		if($this->input->post('offer_id')){ 		
		  if($this->input->post('bid_action') == 0){
            if($this->input->post('type') == 'resubmit'){
               $this->saveBiddingHistory($this->input->post('offer_id'));
			}          
			
			
			if($this->input->post("upgrade_type") >= 1 ){
				$data['upgrade_type'] = $this->input->post("upgrade_type");
				$data['cash'] = ($this->input->post("bid_value") / $this->input->post("tot_bid"))*$this->input->post("tot_cash");
				$data['miles'] = ($this->input->post("bid_value") / $this->input->post("tot_bid"))*$this->input->post("tot_miles");
				$data["cash_percentage"] = round((($data['cash']/ $this->input->post("tot_bid"))*100),2);
				$data['offer_id'] = $this->input->post('offer_id');			
				$data['bid_value'] = $this->input->post("bid_value");	
				$data['dtpfext_id'] = $this->input->post("dtpfext_id");
				$data['flight_number'] = $this->input->post("flight_number");	
				$data['bid_submit_date'] = time();
				$data['active'] = 1;
				$data['orderID'] = $this->input->post('orderID');
				$data['productID'] = 1;
			}else{
				$data['weight'] = $this->input->post("weight");	
				$data['cash'] = ($this->input->post("baggage_value") / $this->input->post("tot_bid"))*$this->input->post("tot_cash");
				$data['bid_submit_date'] = time();
				$data['active'] = 1;
				$data['miles'] = ($this->input->post("baggage_value") / $this->input->post("tot_bid"))*$this->input->post("tot_miles");
				$data["cash_percentage"] = round((($data['cash']/ $this->input->post("tot_bid"))*100),2);
				$data['offer_id'] = $this->input->post('offer_id');			
				$data['bid_value'] = $this->input->post("baggage_value");	
				$data['dtpfext_id'] = $this->input->post("dtpfext_id");
				$data['flight_number'] = $this->input->post("flight_number");
				$data['orderID'] = $this->input->post('orderID');
				$data['productID'] = 2;
			}
            $id = $this->bid_m->save_bid_data($data);			
          if($id){
              if($this->input->post('type') == 'resubmit'){
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
			     $select_passengers_data = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'sent_offer_mail',$this->input->post("fclr_id"),1);
			     $unselect_passengers_data2 = $this->offer_issue_m->getPassengerDataByStatus($this->input->post('offer_id'),$this->input->post('flight_number'),'sent_offer_mail',$this->input->post("fclr_id"));
			  }
			  $select_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
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
              
               // updating bid status tracker
              if($this->input->post('type') == 'resubmit'){
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
               $maildata['resubmit_link'] = base_url('homes/resubmit?pnr_ref='.$maildata['pnr_ref']);
			   $maildata['cancel_link'] = base_url('homes/cancel?pnr_ref='.$maildata['pnr_ref']);
			   $maildata['bid_value'] = number_format($maildata['bid_value']);
			   if($maildata['type'] == 'resubmit'){
					$maildata['template'] = 'bid_resubmit';
					$maildata['subject'] = 'Your bid has been Successfully Re-Submitted';
				} else {
					$maildata['template'] = 'bid_success';
					$maildata['subject'] = 'Your bid has been Successfully Submitted';
				}
               			   
			  // $maildata['tomail'] = 'swekenit@gmail.com';
				$this->sendMail($maildata);
			    $json['status'] = "success";
			  
			    // calculate average and rank
                  $bid_array['flight_number'] =  $data['flight_number'];
                  $bid_array['upgrade_type'] = $data['upgrade_type'];
                  $fly_data = $this->offer_issue_m->get_flight_date($data['offer_id'],$data['flight_number']);
                  $bid_array['flight_date'] = $fly_data->dep_date;
                  $bid_array['carrier_code'] = $fly_data->carrier_code;
		  		  $bid_array['from_cabin'] = $fly_data->cabin;
                  $this->offer_issue_m->calculateBidAvg($bid_array);
								
			  $this->session->unset_userdata('validation_check');
			  $this->session->unset_userdata('pnr_ref');
    	    }	
		  } else {
             if($this->input->post('type') == 'resubmit'){
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
		  }		  
		}else{
			$json['status'] = "send offer_id";
		}
		
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json));
	}

	
	public function saveBaggageData(){
		if($this->input->post('offer_id')){
			//$this->mydebug->debug($_POST);
			if($this->input->post('type') == 'resubmit'){
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
		 if($this->input->post('offer_id')) {
			  $rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) { 
				$json['status'] = validation_errors();		
			} else {
			$orderID =  $this->bid_m->create_order();
			$data['orderID'] = $orderID;
			$data['offer_id'] = $this->input->post('offer_id');
			$data['card_number'] = $this->input->post("card_number");
			$data['month_expiry'] = $this->input->post("month_expiry");
			$data['year_expiry'] = $this->input->post("year_expiry");
			$data['cvv'] = $this->input->post("cvv");
            $data['date_added'] = time();			
            $id = $this->bid_m->save_card_data($data);
			  $select_status = $this->rafeed_m->getDefIdByTypeAndAlias('bid_received','20');
			   $ref['cash'] = $this->input->post("cash");
			   $ref['miles'] = $this->input->post("miles");
			   $tot_bid = $this->input->post("tot_bid");
			   $ref['offer_status'] = $select_status;
			   $ref["modify_date"] = time();
			   if($tot_bid != 0){
			    $ref["cash_percentage"] = round((($ref['cash']/ $tot_bid)*100),2);
			   } else {
				$ref["cash_percentage"] = 0;   
			   }
			   $this->offer_reference_m->update_offer_ref($ref,$this->input->post('offer_id'));
			if($id){
			  $json['status'] = "success";
			  $json['orderID'] = $orderID;
		    }
		  }			
		}else{
			$json['status'] = "send offer_id";
		}	 	 
		$json['status'] = success;
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

}
