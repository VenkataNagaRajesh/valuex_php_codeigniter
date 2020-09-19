<div class="container top-bar" style="background:<?=$mail_header_color?>">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-2">
				<img class="img-responsive" src="<?=$airline_logo?>" alt="logo">
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="bid-tab">
			<ul class="nav nav-tabs">
				<li class="col-md-6 col-sm-6"><a href="#offer"><span class="badge badge-secondary" style="color:<?=$mail_header_color?>">1</span> Make Us an Offer</a></li>
				<li class="col-md-6 col-sm-6"><a href="#payment"><span class="badge badge-secondary" style="color:<?=$mail_header_color?>">2</span> Review & Payment</a></li>
			</ul>
            <div class="tab-content">
                <div id="offer" class="">
					<div class="col-md-12 col-sm-12">
						<h3 style="color:<?=$mail_header_color?>;">Your chance for a <?=$airline_name?> Business upgrade</h3>
						<p>Treat yourself to the amenities and comfort of business upgrade to business class by submitting your bid here is how to proceed</p>
						<ol>
							<li>Submit your bid per flight leg and click on next</li>
							<li>Indicate your method of payment you will be charged only if your upgrade bid has been approved</li>
							<li>Check and confirm your data</li>
						</ol>
						<p>The submission of your bid will be confirmed in a separate email. you will receive a message from us between 120 and 48 hours before departure informing you whether or not you bid has been accepted, Bids are per flight segment and do not including the original ticket price</p>
					</div>
					<div class="col-md-10 col-sm-10">
						<div class="pass-info">
							<p>Passenger(s):<span style="color:<?=$mail_header_color?>"><?php echo ucfirst($results[0]->pax_names); ?></span>
							<span class="pull-right" style="color:#333;">Booking Ref No: <?=$results[0]->pnr_ref?></span></p>
							<div class="table">
								<table class="table hidden-xs">
									<thead style="background:<?=$mail_header_color?>">
										<tr>
											<th>Flight Information</th>
											<th style="text-align:left;"></th>
											<th>Bid Amount</th>
											<!--<th>Action</th>-->
										</tr>
									</thead>
									<tbody>
										<tr><th><p>Upgrade Offer</p></th></tr>
										<?php $n=1; foreach($results as $result){?>
										<tr>
											<td><div class="col-md-12"><p><?=$n?> . <?php echo $result->from_city; ?> To <?php echo $result->to_city; ?> </p></div></td>
											<td><p>Upgrade To</p></td>
											<td></td>
										</tr>
										<tr>
											<td>								
												<div style="text-align:left" class="bid-info <?=($result->fclr == null)?"bid-visible":""?>">
													<div class="col-md-5">
														<p style="color:<?=$mail_header_color?>"><?php echo $result->from_city; ?> <span class="time-bid"><?=date('H:i A',$result->dep_date+$result->dept_time);?></span></p>
														<ul>
															<li><?php echo date('d M Y',$result->dep_date); ?></li>
															<li style="color:<?=$mail_header_color?>"><?php echo $result->carrier_code.$result->flight_number; ?></li>
															<!--<li><?=$result->time_diff?></li>-->
														</ul>
														<small><?php echo $result->from_airport; ?></small>
													</div>
													<div class="col-md-2"><p style="text-align:center;"><i class="fa fa-plane"></i></p></div>
													<div style="align:left" class="col-md-5">
														<p style="color:<?=$mail_header_color?>"><?php echo $result->to_city; ?> <span class="time-bid"><?=date('H:i A',$result->arrival_date+$result->arrival_time);?></span></p>
														<ul>
															<li><?php echo date('d M Y',$result->arrival_date); ?></li>
															<li style="color:<?=$mail_header_color?>"><?php echo $result->carrier_code.$result->flight_number; ?></li>
															<!--<li><?=$result->time_diff?></li>-->
														</ul>
														<small><?php echo $result->to_airport; ?></small>
													</div>
												</div>											
											</td>
											<td>		 
												<div class="bid-radio col-md-12">
												   <?php $i=0; //$offer_cabins = explode(',',$result->to_cabins);
												   foreach($result->to_cabins as $key => $value) { if($result->fclr != null){  $split = explode('-',$key); $key = $split[0]; $status = $split[1]; ?>								      
													<label class="cabins-<?=$result->flight_number?> radio-inline <?=($status == $excluded_status)?"bid-visible":""?>" >
														<input type="radio" name="bid_cabin_<?=$result->flight_number?>" value="<?php echo $value.'|'.$key; ?>" ><?php echo $cabins[$value]; ?>
													</label><br>
												   <?php if($status == $excluded_status) { $i++; } } } ?>
												   <?php if($i != 0){?>
                                               		<label class="checkbox-inline<?=($result->fclr == null)?"bid-visible":""?>">
														<input type="checkbox" name="bid_action_<?=$result->flight_number?>" value="1" /> Cancel Bid 
													</label>	
												   <?php } ?>
													<label class="radio-inline">
														<input type="radio" name="bid_cabin_<?=$result->flight_number?>" value="" >No Bid
													</label>
                                              </div>
											</td>
											<td>
												<?php if($result->fclr != null){													 
													 foreach($result->to_cabins as $key => $value) {		 
													  $split = explode('-',$key); $key = $split[0]; $status = $split[1];
													   if($status == $sent_mail_status){
														 break;  
													   }
													 }
													 $i = array_search($key, explode(',',$result->fclr)); 	?>       
												
													<div class="price-range col-md-12">		
													<b>Min</b> <i class="fa fa-dollar"></i> <b id="bid_min_<?=$result->flight_number?>"></b>
															<input id="bid_slider_<?=$result->flight_number?>" data-slider-id='bid_slider_<?=$result->flight_number?>Slider' type="text" data-slider-min="<?php echo explode(',',$result->min)[$i]; ?>" data-slider-max="<?php echo explode(',',$result->max)[$i]; ?>" data-slider-step="1" data-slider-value="<?php echo explode(',',$result->slider_position)[$i]; ?>" data-slider-handle="round"min-slider-handle="200"/>
													<b>Max</b> <i class="fa fa-dollar"></i> <b id="bid_max_<?=$result->flight_number?>"></b>
													</div>
												<?php }  ?>
											</td>
										</tr>
										<?php $n++; } ?>
										<?php $n = 1; if(count($baggage) > 0){ ?>
											<tr>
												<td colspan=3 style="color: black;"><b> Baggage offer</b> </td>
											</tr>
											<?php
										
											?>
											<?php foreach($baggage as $bg => $row){ 
													
												?>
												<?php $bslider = $row['pax'];
												// var_dump($bslider);
												// die();
												?>
												<tr>
													<td>
														<p><?=$n++ ?> . <?php echo $bslider['from_city_name']; ?> To <?php echo $bslider['to_city_name']; ?> </p>
													</td>
													<td><p>Booked Cabin</p></td>
													<td></td>
												</tr>
												<tr>
													<td style="color: black;">
														<div style="text-align:left" class="bid-info">
															<div class="col-md-5">
																<p style="color:<?=$mail_header_color?>"><?php echo $bslider['from_city_name']; ?> <span class="time-bid"><?=date('H:i A',$bslider['dep_date']+$bslider['dept_time']);?></span></p>
																<ul>
																	<li><?php echo date('d M Y',$bslider['dep_date']); ?></li>
																	<li style="color:<?=$mail_header_color?>"><?php echo $bslider['flight_number'];?></li>
																</ul>
																<small><?php echo $bslider['from_airport']; ?></small>
															</div>
															<div class="col-md-2"><p style="text-align:center;"><i class="fa fa-plane"></i></p></div>
															<div style="text-align:left" class="col-md-5">
																<p style="color:<?=$mail_header_color?>"><?php echo $bslider['to_city_name']; ?><span class="time-bid"><?=date('H:i A',$bslider['arrival_date']+$bslider['arrival_time']);?></span></p>
																<ul>
																	<li><?php echo date('d M Y',$bslider['arrival_date']); ?></li>
																	<li style="color:<?=$mail_header_color?>"><?php echo $bslider['flight_number'];?></li>
																</ul>
																<small><?php echo $bslider['to_airport']; ?></small>
															</div>
														</div>
													</td>
													<td style="color: black;"><p></p>
														<label class="checkbox-inline">
															<input type="checkbox" name="ckb" id="ckb" value="" >Not Interested
														</label>
													</td>
													<?php if($bclr[$bslider['ond']]->bag_type=='PC'){ ?>
													<td style="color: black;" >
													<div id="slider">
														<div class="price-range col-md-12">	
															<b><?=$bclr[$bslider['ond']]->bag_type . " - " . $bslider['per_min']?>&nbsp;&nbsp;&nbsp;&nbsp;</b>
															<input id="baggage_slider<?=$bslider['ond']?>" data-slider-id='baggage_slider<?=$bslider['ond']?>Slider' type="text" data-slider-min="<?=$bslider['per_min']?>" data-slider-max="<?=$bslider['piece'];?>" data-slider-step="1" data-slider-value="<?=$bslider['min_price'];?>" data-slider-handle="round" min-slider-handle="50"/>
															<b> &nbsp;&nbsp;<?=$bslider['piece']?></b>
														</div>
													</div>
													</td>
													<?php } else{ ?>
														<td style="color: black;" >
														<div id="slider">
														<div class="price-range col-md-12">	
															<b><?=$bclr[$bslider['ond']]->bag_type . " - " . $bslider['per_min']?>&nbsp;&nbsp;&nbsp;&nbsp;</b>
															<input id="baggage_slider<?=$bslider['ond']?>" data-slider-id='baggage_slider<?=$bslider['ond']?>Slider' type="text" data-slider-min="<?=$bslider['per_min']?>" data-slider-max="<?=$bslider['per_max'];?>" data-slider-step="1" data-slider-value="<?=$bslider['min_price'];?>" data-slider-handle="round" min-slider-handle="50"/>
															<b> &nbsp;&nbsp;<?=$bslider['per_max']?></b>
														</div>
														</div>
													</td>

												<?php } ?>
												</tr>
											<?php } ?>
										 <?php } ?>
									</tbody>
								</table>
								<!--========Mobile Data Bidding=======--> 
								<div class="hidden-lg hidden-md hidden-sm mob-slide">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">		
										<div class="panel panel-success">
											<div class="panel-heading" role="tab" id="headingOne">
												<h4 class="panel-title">
													<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
														<i class="short-full glyphicon glyphicon-plus"></i>
														<p><?=$n-1?> . <?php echo $result->from_city; ?> To <?php echo $result->to_city; ?> </p>
													</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
												<div class="panel-body">
													<div class="col-xs-12">
														<div class="col-xs-12">
															<div style="background:<?=$mail_header_color?>" class="col-xs-12">
																<h4>Flight Information</h4>
															</div>
															<div class="bid-info <?=($result->fclr == null)?"bid-visible":""?>">
																<div class="col-md-5">
																	<p style="color:<?=$mail_header_color?>"><?php echo $result->from_city; ?> <span class="time-bid"><?=date('H:i A',$result->dep_date+$result->dept_time)?></span></p>
																	<ul>
																		<li><?php echo date('d M Y',$result->dep_date); ?></li>
																		<li style="color:<?=$mail_header_color?>"><?php echo $result->carrier_code.$result->flight_number; ?></li>
																		<!--<li><?=$result->time_diff?></li>-->
																	</ul>
																	<small data-toggle="tooltip" data-placement="top" title="<?php echo $result->from_city; ?>" class="badge">Airport Info</small>
																</div>
																<div class="col-md-2"><p style="text-align:center;"><i class="fa fa-plane"></i></p></div>
																<div class="col-md-5">
																	<p style="color:<?=$mail_header_color?>"><?php echo $result->to_city; ?> <span class="time-bid"><?=date('H:i A',$result->arrival_date+$result->arrival_time)?></span></p>
																	<ul>
																		<li><?php echo date('d M Y',$result->arrival_date); ?></li>
																		<li style="color:<?=$mail_header_color?>"><?php echo $result->carrier_code.$result->flight_number; ?></li>
																		<!--<li><?=$result->time_diff?></li>-->
																	</ul>
																	<small data-toggle="tooltip" data-placement="top" title="<?php echo $result->to_city; ?>" class="badge">Airport Info</small>
																</div>
															</div>
														</div><br>
														<div class="col-xs-12">
															<div style="background:<?=$mail_header_color?>" class="col-xs-12">
																<h4>Upgrade To Cabin</h4>
															</div>
															<div class="radio-mob">
															   <?php $i=0; //$offer_cabins = explode(',',$result->to_cabins);
															   foreach($result->to_cabins as $key => $value) { if($result->fclr != null){  $split = explode('-',$key); $key = $split[0]; $status = $split[1]; ?>								      
																<label class="cabins-<?=$result->flight_number?> radio-inline <?=($status == $excluded_status)?"bid-visible":""?>" >
																	<input type="radio" name="mb_bid_cabin_<?=$result->flight_number?>" value="<?php echo $value.'|'.$key; ?>" ><?php echo $cabins[$value]; ?>
																</label><br>
															   <?php if($status == $excluded_status) { $i++; } } } ?>
															   <?php if($i != 0){?>
																			<label class="checkbox-inline<?=($result->fclr == null)?"bid-visible":""?>">
																	<input type="checkbox" name="mb_bid_action_<?=$result->flight_number?>" value="1" /> Cancel Bid 
																</label>	
															   <?php } ?>
															</div>
														</div><br><br>
														<div class="col-xs-12">
															<div style="background:<?=$mail_header_color?>" class="col-xs-12">
																<h4>Bid Amount</h4>
															</div>
															<div class="col-xs-12">
																<?php if($result->fclr != null){																	 
																	 foreach($result->to_cabins as $key => $value) {		 
																	  $split = explode('-',$key); $key = $split[0]; $status = $split[1];
																	   if($status == $sent_mail_status){
																		 break;  
																	   } 
																	 }
																	 $i = array_search($key, explode(',',$result->fclr)); 
																	 ?>       
																	
																	<div class="price-range col-md-12">		
																		<span><b>Min</b> <i class="fa fa-dollar"></i> <b id="mb_bid_min_<?=$result->flight_number?>"></b></span>
																			<input id="mb_bid_slider_<?=$result->flight_number?>" data-slider-id='mb_bid_slider_<?=$result->flight_number?>Slider' type="text" data-slider-min="<?php echo explode(',',$result->min)[$i]; ?>" data-slider-max="<?php echo explode(',',$result->max)[$i]; ?>" data-slider-step="1" data-slider-value="<?php echo explode(',',$result->slider_position)[$i]; ?>" data-slider-handle="round"min-slider-handle="200"/>
																		<span class="max-range"><b>Max</b> <i class="fa fa-dollar"></i> <b id="mb_bid_max_<?=$result->flight_number?>"></b></span>
																	</div>
																<?php }  ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12" style="padding-right:0;">
								<p class="pull-right">Total Bid Amount  <strong style="margin-left:12px;"> <i class="fa fa-dollar"></i> <b id="tot"></b></strong> </p>
							</div>
							<div class="col-sm-12">
								<a data-toggle="tab" href="#offer" class="btn btn-danger  pull-right btn btn-secondary sw-btn-next" type="button" style="background:<?=$mail_header_color?>">Continue</a>
							</div>
						</div>
					</div>
					<div class="col-md-2 hidden-sm">
						<!--<div class="side-image">
							<img class="img-responsive img-thumbnail" src="<?php echo base_url('assets/home/images/multi-bid/mb1.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive img-thumbnail" src="<?php echo base_url('assets/home/images/multi-bid/mb2.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive img-thumbnail" src="<?php echo base_url('assets/home/images/multi-bid/mb3.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive img-thumbnail" src="<?php echo base_url('assets/home/images/multi-bid/mb1.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive img-thumbnail" src="<?php echo base_url('assets/home/images/multi-bid/mb2.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive img-thumbnail" src="<?php echo base_url('assets/home/images/multi-bid/mb3.jpg'); ?>" alt="img1">
						</div>-->
					
						<div class="side-image"></div>
					</div>
					<div class="col-sm-12 hidden-xs hidden-md hidden-lg">
						<marquee>
						 <div class="side-image">
                         </div>
						 </marquee>
					</div>
					<div class="col-md-2">
						<h2 class="baggage-title"><span>Baggage</span></h2>
						<div class="bg-title-border"></div>
						<img src="<?php echo base_url('assets/home/images/baggage.jpg'); ?>"  class="img-responsive" />
					</div>
				</div>
                <div id="payment" class="">
					<div class="col-md-9 col-sm-9">
						<div class="col-md-2 back-btn">
							<a type="button" class="btn btn-danger btn btn-secondary sw-btn-prev" style="background:<?=$mail_header_color?>"><i class="fa fa-arrow-left" ></i> Back</a>
						</div>
						<div class="col-md-10 booking-ref">
							<h2 class="pull-right"><b>Booking Ref No: <?php echo $results[0]->pnr_ref; ?></b></h2>
						</div>
						<div class="col-md-12">
							<p class="pull-right">Total Bid Amount  <strong style="margin-left:12px;"> <i class="fa fa-dollar"></i> <b id="bidtot"></b></strong></p>
						</div>
						<div class="col-md-8 col-md-offset-2">
							<div class="price-range">
								<b id="mile-min"> </b>
       										<input id="miles" data-slider-id='milesSlider' type="text" data-slider-min="0" data-slider-max="<?=$results[0]->miles?>" data-slider-step="5" data-slider-value="<?=$results[0]->miles/2?>" data-slider-handle="round"min-slider-handle="200"/>
								<b id="mile-max"></b> 
							</div>
						</div>
						<div class="col-md-12 payment-box">
							<form role="form" id="payment-form" method="POST" action="#">
								<div class="col-md-8">
									<div class="form-group">
										<div class="col-md-12">
											<label for="cardNumber">Card number</label>
											<div class="input-group">
												<input type="number" class="form-control" name="card_number" id="card_number"
													oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Enter Card Number" maxlength="16"
												/>
												<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
											</div>
										</div>
									</div>                            
									<div class="form-group card-exp">
										<div class="col-md-6">
											<label for="cardExpiry">Expiry Date</label>
											<input type="number" class="form-control" name="month_expiry" id="month_expiry" placeholder="MM" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"/>
											/ <input type="number" class="form-control" name="year_expiry" id="year_expiry" placeholder="YY" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"/>
										</div>
										<div class="col-md-6">
											<label for="cardCVC" style="position: relative;margin-left: auto;margin-right: 2em;">CVV</label>
											<input type="number" class="form-control pull-right" name="cvv" id="cvv" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" />
										</div>
									</div>
									<div class="col-md-12">
										<div class="pay-info">
											<p style="color:<?=$mail_header_color?>">Your card will be saved for future usage upon BID Confirmation</p>
											<p style="color:<?=$mail_header_color?>">Bid Participation Charges  <b>(1$ Non Refundable)</b></p>
										</div>
									</div>
								</div>
								<?php if(in_array(2,$active_products)){ ?>
									<div class="col-md-4 actual-cash">
									<p>Upgrade Total Cash to be Paid <strong><i class="fa fa-dollar"></i> <b id="up_paid_cash"></b></strong></p>
									<p>Upgrade Total Miles to be Paid : <b id="up_paid_miles"></b> </p>
									<p>Baggage Total Cash to be Paid <strong><i class="fa fa-dollar"></i> <b id="bg_paid_cash"></b></strong></p>
									<p>Baggage Total Miles to be Paid : <b id="bg_paid_miles"></b> </p>
									<a href="#" type="button" class="btn btn-danger" onclick="saveBid(<?=$result->offer_id?>)" style="background:<?=$mail_header_color?>">Pay Now</a>	
								</div>
								<?php } else { ?>
								<div class="col-md-4 actual-cash">
									<p>Total Cash to be Paid <strong><i class="fa fa-dollar"></i> <b id="paid_cash"></b></strong></p>
									<p>Total Miles to be Paid : <b id="paid_miles"></b> </p>
									<a href="#" type="button" class="btn btn-danger" onclick="saveBid(<?=$result->offer_id?>)" style="background:<?=$mail_header_color?>">Pay Now</a>	
								</div>
								<?php } ?>
							</form>
						</div>
					</div>
					<div class="col-md-3 col-sm-3">
						<div class="side-video">
							<!--<iframe src="https://www.youtube.com/embed/_O2_nTt1N6w" width="100%" height="180"></iframe>-->
							
						</div>
						
						<!--<div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('assets/home/images/multi-bid/mb2.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('assets/home/images/multi-bid/mb3.jpg'); ?>" alt="img1">
						</div>-->
						<?php $i=1; foreach($images as $img){ if($i < 3){ ?>
						 <!-- <div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('uploads/images/'.$img->image); ?>" alt="img1">
						  </div> -->                      						  
						<?php }$i++;} ?>
						<div class="side-image">
						</div>
					</div>
					<!--<div id="loading">
					</div>-->
				</div>
            </div>
        </div>
	</div>
</div>

<script>
var mile_value = <?=$mile_value?>;
var mile_proportion = <?=$mile_proportion?>;
<?php foreach($cwtdata as $ond => $cwtpoints){ ?>
var cwtpoints<?=$ond?> = [];
<?php foreach($cwtpoints as $cwt){ ?>
	
	cwtpoints<?=$ond?>[<?=$cwt['cum_wt']?>] = <?=$cwt['price_per_kg']?>;
<?php } ?>
<?php } ?>
$(document).ready(function () {	
   $('#milesSlider .slider-selection').css({"background":"#0feded"});
   $('#milesSlider .slider-handle').css({"background":"#0feded"});	
   tot_avg = 0;
  <?php foreach($results as $result){  if($result->fclr != null){  ?>	  
	<?php $flag =0;
	 foreach($result->to_cabins as $key => $value) {		 
	  $split = explode('-',$key); $key = $split[0]; $status = $split[1];
       if($status == $sent_mail_status){
		 $flag = 1;
		 break;  
	   }
	 }
	 $i = array_search($key, explode(',',$result->fclr)); 
	 if($flag == 1 && explode(',',$result->min)[$i]){  ?>  
	$('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$result->flight_number?>]').filter('[value="<?=$value.'|'.$key?>"]').attr('checked', true);
    $('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$result->flight_number?>]:checked').trigger('change'); 
	$('#<?=$mobile_view?>bid_min_<?=$result->flight_number?>').text(numformat(<?php echo explode(',',$result->min)[$i]; ?>));
    $('#<?=$mobile_view?>bid_max_<?=$result->flight_number?>').text(numformat(<?php echo explode(',',$result->max)[$i]; ?>));

	//var tot_avg = tot_avg + <?=explode(',',$result->avg)[$i]?>;
    changeColors(<?=$result->flight_number?>);
	updateCabinMedia(<?=$result->flight_number?>);

	
  <?php } } } ?>    
 // $("#tot").text(tot_avg*<?=$passengers_count?>);
  //$("#bidtot").text(tot_avg*<?=$passengers_count?>);  
    var total = getTotal();
	$("#tot").text(numformat(total));
	$("#bidtot").text(numformat(total));
    mileSliderUpdate(); 
	<?php if(in_array(2,$active_products) && count($baggage) > 0){ foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?>
		
	$('#baggage_slider<?=$bslider['ond']?>Slider .slider-selection').css({"background":"#f952be"});
    $('#baggage_slider<?=$bslider['ond']?>Slider .slider-handle').css({"background":"#f952be"});
	<?php } } ?>
});

function updateCabinMedia(flight_number){
	var upgrade = $('input[type=radio][name=<?=$mobile_view?>bid_cabin_'+flight_number+']:checked').val().split('|');
	var upgrade_type = upgrade[0];	
	$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('homes/bidding/getCabinImages')?>",          
		  data: {"cabin" :upgrade_type,"carrierID":<?=$results[0]->carrier?>},
          dataType: "html",			
          success: function(data) {
			   $('.side-image').html('');
               $('.side-video').html('');				   
            var cabin_media = jQuery.parseJSON(data); 
			var imghtml = ''; var videohtml = '';
			
			//dynamic Cabin images
			for (i = 0; i < cabin_media['cabin_images'].length; i++) {			 
			 imghtml += '<img class="img-responsive" src="<?=base_url("uploads/images/")?>'+cabin_media['cabin_images'][i]['image']+'" alt="img1">';
			}
             $('.side-image').html(imghtml);
			 
			//Dynamic Cabin Videos
            for (i = 0; i < cabin_media['cabin_videos'].length; i++) {			 
			 videohtml += '<iframe src="'+cabin_media['cabin_videos'][i]+'" width="100%" height="180"></iframe>';
			}
            $('.side-video').html(videohtml);	 	
          }
     });
}

<?php foreach($results as $result){  if($result->fclr != null){ ?> 
$('#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>').slider({
	tooltip: 'always',
	formatter: function(value) {
		return '$'+numformat(value) + ' Per Person';
	}
});
<?php } } ?>

//baggage slider jquery
<?php if(in_array(2,$active_products) && count($baggage)>0){ foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?> 
$('#baggage_slider<?=$bslider['ond']?>').slider({
	tooltip: 'always',
	formatter: function(value) {
		var price = <?=$bslider['price'] ?>;
		var total_piece = <?=$bslider['total_piece'] ?>;
		var per_total = <?=$bslider['per_total'] ?>;
		var bag_type = '<?=$bclr[$bslider['ond']]->bag_type?>';
		var total;
		if(bag_type=='PC'){
			total=price+per_total*total_piece*value;
		}else{
			total=price+per_total*value;
		}
		return value + ' <?=$bclr[$bslider['ond']]->bag_type?>' + ' = $'+total.toFixed(2);
	}
});
$("#baggage_slider<?=$bslider['ond']?>").on("slide", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
    mileSliderUpdate();	
});
$("#baggage_slider<?=$bslider['ond']?>").on("click", function(slideEvt) { 
	var tot_avg = getTotal();
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
    mileSliderUpdate();	
});
<?php } } ?>

$(".bid-visible").click(function () {   
	 event.preventDefault();
});

$('#miles').slider({
	tooltip: 'always',
	formatter: function(value) {			
		var dollar = value * mile_value;
		//var bid_amount = $("#ex1").slider('getValue');
		var bid_amount = getTotal();
		var pay_cash = bid_amount - Math.round(dollar);
		var bg_val = 0;
		<?php if(in_array(2,$active_products) && count($baggage)>0) { ?>
		  <?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?>
		  var bg_val = bg_val + cwtpoints<?=$bslider['ond']?>[$("#baggage_slider<?=$bslider['ond']?>").slider('getValue')];
		  <?php } ?>
		   var up_pay_cash = (bid_amount - bg_val) - Math.round(dollar/2);;
		   var bg_pay_cash = (bg_val) - Math.round(dollar/2);;
			$("#up_paid_cash").text(numformat(up_pay_cash));
			$("#bg_paid_cash").text(numformat(bg_pay_cash));
			$("#up_paid_miles").text(numformat(value/2) + ' Miles'+'($'+numformat(Math.round(dollar/2))+')'); 		
			$("#bg_paid_miles").text(numformat(value/2) + ' Miles'+'($'+numformat(Math.round(dollar/2))+')'); 		
        <?php } else { ?>
			$("#paid_cash").text(numformat(pay_cash));
        	$("#paid_miles").text(numformat(value) + ' Miles'+'($'+numformat(Math.round(dollar))+')'); 		
		<?php } ?>
		return '$'+numformat(pay_cash)+' + '+numformat(value) + ' Miles'+'($'+numformat(Math.round(dollar))+')';
		//return value;
	}
});

function numformat(n){
	return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

<?php foreach($results as $result){   if($result->fclr != null){?> 	
$("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").on("slide", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	//console.log(tot_avg);
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
    mileSliderUpdate();	
    changeColors(<?=$result->flight_number?>);		 
});
$("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").on("click", function(slideEvt) { 
	var tot_avg = getTotal();
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
    mileSliderUpdate();	
    changeColors(<?=$result->flight_number?>);	 
});
//action click
$('input[type=checkbox][name=<?=$mobile_view?>bid_action_<?=$result->flight_number?>]').click(function(){	
	 if($(this). prop("checked") == true){
	   $('.cabins-'+<?=$result->flight_number?>).addClass('bid-visible');
	  
	   $("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").slider('disable'); 
	 } else {
	    $('.cabins-'+<?=$result->flight_number?>).removeClass('bid-visible');
	   $("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").slider('enable');  
	 }
	var tot_avg = getTotal();
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));
	mileSliderUpdate();
});

<?php } } ?>

<?php foreach($results as $result){  if($result->fclr != null){ ?>
$('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$result->flight_number?>]').change(function(){
	$(this).checked = true;
	var bid_cabin = $(this).val();
	var result = $(this).val().split('|');
	updateCabinMedia(<?=$result->flight_number?>);
       $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('homes/bidding/getFclrValues')?>",          
		  data: {"fclr_id" :result[1]},
          dataType: "html",			
          success: function(data) {
            var info = jQuery.parseJSON(data);              		
            $("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").slider('setAttribute', 'max', Math.round(info['max']));
		    $("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").slider('setAttribute', 'min', Math.round(info['min']));
		    $("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").slider('setValue', Math.round(info['slider_start']));
			$("#<?=$mobile_view?>bid_max_<?=$result->flight_number?>").text(numformat(Math.round(info['max'])));
			$("#<?=$mobile_view?>bid_min_<?=$result->flight_number?>").text(numformat(Math.round(info['min'])));
			var tot_avg = getTotal();
			 $("#tot").text(numformat(tot_avg));
			 $("#bidtot").text(numformat(tot_avg));			
			mileSliderUpdate();
            changeColors(<?=$result->flight_number?>);			
          }
     });
	 
});
<?php } } ?>

 function getTotal(){
		var tot_avg = 0;
		<?php foreach($results as $result){  if($result->fclr != null){ ?>//$(this). prop("checked") == true
		  // var action = $('input[type=checkbox][name=bid_action_<?=$result->flight_number?>]:checked').val();	  
		  //if(action == 1){
         //if($('input[type=checkbox][name=<?=$mobile_view?>bid_action_<?=$result->flight_number?>]').prop("checked") == false){    			  
		   tot_avg = tot_avg+$("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").slider('getValue')*<?=$passengers_count?>;
	//	  } 
		<?php } } ?>
		<?php if(in_array(2,$active_products) && count($baggage) > 0) { 
		  foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?> 
		  var bg_val = $("#baggage_slider<?=$bslider['ond']?>").slider('getValue');
		var price = <?=$bslider['price'] ?>;
		var total_piece = <?=$bslider['total_piece'] ?>;
		var per_total = <?=$bslider['per_total'] ?>;
		var bag_type = '<?=$bclr[$bslider['ond']]->bag_type?>';
		var total;
		if(bag_type=='PC'){
			total=price+per_total*total_piece*bg_val;
		}else{
			total=price+per_total*bg_val;
		}
		

		  if ( bg_val) {
		  	tot_avg = tot_avg + total
			//   console.log(tot_avg+'tot_avg');
		   }
		<?php } } ?>
      return tot_avg.toFixed(2);
 }

 function changeColors(id){
	 var value = $("#<?=$mobile_view?>bid_slider_"+id).slider('getValue');	
	 var diff = $("#<?=$mobile_view?>bid_slider_"+id).slider('getAttribute', 'max') - $("#<?=$mobile_view?>bid_slider_"+id).slider('getAttribute', 'min');
	 var min = $("#<?=$mobile_view?>bid_slider_"+id).slider('getAttribute', 'min');
	 var one = min + Math.round((diff)*(25/100));
	 var two = min + Math.round((diff)*(50/100));
	 var three = min+ Math.round((diff)*(75/100));
	 	 
	   if(value <= one ){
	   $('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":"red"});
	   //$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"red"});
     } else if(value <= two){ 
	   $('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":"orange"});   
	   //$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"orange"});	   
	   $('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 100%,#cf0404 100%,#e2d704 100%)"},{"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 100%,#cf0404 100%,#e2d704 100%)"}); 
     } else if(value <= three ){
	   //$('#bid_slider_'+id+'Slider .slider-selection').css({"background":"#00ff00"}); 
	   //$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"#00ff00"});
	    $('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 35%,#e2d704 41%,#e2d704 59%,#04ea04 100%,#cf0404 100%,#04ea04 100%)"},{"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 35%,#e2d704 41%,#e2d704 59%,#04ea04 100%,#cf0404 100%,#04ea04 100%)"}); 
     } else {
	    //$('#bid_slider_'+id+'Slider .slider-selection').css({"background":"#009900"}); 
		//$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"#009900"});
		$('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left, #f94231 1%,#d6b822 37%,#d6b822 37%,#d6b822 40%,#39ed25 67%,#146d28 99%,#146d28 99%,#7db9e8 100%)"},{"background":" -webkit-linear-gradient(left, #f94231 1%,#d6b822 37%,#d6b822 37%,#d6b822 40%,#39ed25 67%,#146d28 99%,#146d28 99%,#7db9e8 100%)"}); 
     }  
	 
 }
 
 function mileSliderUpdate(){	  
	 var value = getTotal();	  
     var miles = value/mile_value;
	  $("#mile-min").text(0+' Miles');  
	 // $("#mile-max").text(Math.round(miles)+' Miles');
	 // $("#mile1").slider('setAttribute', 'max', Math.round(miles));
	 //$("#mile1").slider('setValue', Math.round(miles)* mile_proportion);
	  $("#mile-max").text( numformat(Math.round(Math.round(miles)* mile_proportion))+' Miles');
	  $("#miles").slider('setAttribute', 'max', Math.round(Math.round(miles)* mile_proportion));	  
	  $("#miles").slider('setValue',0);  
	  $("#miles").slider('setAttribute', 'step', Math.round(1/mile_value)); 
	  
 }
 
 function saveBid(offer_id){	 
	 	/* var lhtml = '<div class="ring">Loading<span></span></div>';
		//$('.myloading').html(lhtml);
		var image = "<?php echo base_url(). 'assets/home/images/Spinner.gif'; ?>";
		$('#loading').html("<img src='"+image+"' />"); */
		var miles = $("#miles").slider('getValue');
		var tot_bid = getTotal();
		var pay_cash = tot_bid - Math.round(miles * mile_value);	
		var paysuccess = 0;
    	$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('homes/bidding/saveCardData')?>",          
		  data: {"card_number" :$('#card_number').val(),"month_expiry":$('#month_expiry').val(),"year_expiry":$('#year_expiry').val(),"cvv":$('#cvv').val(),"offer_id":offer_id,"cash":pay_cash,"miles":miles,"tot_bid":tot_bid},
          dataType: "html",	         		  
          success: function(data) {
            var cardinfo = jQuery.parseJSON(data);
			var orderID = cardinfo['orderID'];

            if(cardinfo['status'] == "success"){
				<?php if(in_array(2,$active_products) && count($baggage)>0){ ?>
					var bg_tot_value = 0;
				<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?>
					bg_tot_value = bg_tot_value + cwtpoints<?=$bslider['ond']?>[$("#baggage_slider<?=$bslider['ond']?>").slider('getValue')];
				<?php } ?>
					var up_miles = $("#miles").slider('getValue')/2;
					var up_tot_bid = tot_bid - bg_tot_value;
					var up_pay_cash = up_tot_bid - Math.round(up_miles * mile_value);
					var bg_miles = $("#miles").slider('getValue')/2;
					var bg_tot_bid = bg_tot_value;
					var bg_pay_cash = bg_tot_bid - Math.round(bg_miles * mile_value); 
				<?php } else { ?>
					var up_miles = miles;
					var up_tot_bid = tot_bid;
					var up_pay_cash = pay_cash;
                <?php } ?>
		      <?php foreach($results as $result){  if($result->fclr != null) { ?>
				var bid_value = $("#<?=$mobile_view?>bid_slider_<?=$result->flight_number?>").slider('getValue')*<?=$passengers_count?>;			
				//var pay_cash = bid_value - Math.round(miles * mile_value);				
				var flight_number = <?=$result->flight_number?>;				
				var upgrade = $('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$result->flight_number?>]:checked').val().split('|');
				var upgrade_type = upgrade[0];	
				var fclr_id = upgrade[1];
				var dtpfext_id=<?=$result->dtpfext_id?>;
				var product_id=<?=$result->product_id?>;
				//var bid_action = $('input[type=radio][name=bid_action_<?=$result->flight_number?>]:checked').val();
				if($('input[type=checkbox][name=<?=$mobile_view?>bid_action_<?=$result->flight_number?>]').prop("checked") == false){
					var bid_action = 1;
				} else {
					var bid_action = 0;
				}
				 $.ajax({
				  async: false,
				  type: 'POST',
				  url: "<?=base_url('homes/bidding/saveBidData')?>",          
				  data: {"orderID":orderID,"offer_id" :offer_id,"bid_value":bid_value,"flight_number":flight_number,"upgrade_type":upgrade_type,'bid_action':bid_action,'product_id':product_id,"tot_cash":up_pay_cash,"dtpfext_id":dtpfext_id,"tot_miles":up_miles,"tot_bid":up_tot_bid,"type":"submit"},
				  dataType: "html",			
				  success: function(data) {
					var info = jQuery.parseJSON(data);              		
					if(info['status'] == "success"){
						//window.location = "<?=base_url('home/paysuccess')?>/"+offer_id;
						paysuccess = 1;
					} else {
						//alert(info['status']);
						paysuccess = 0;
						status = status + "<p>"+info['status']+"</p>";
					}			
				  }
			   }); 
			  <?php } } ?>
			  <?php if(in_array(2,$active_products)&& count($baggage)>0){ ?>
			       if(status != ''){
					<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?>
						var bg_weight = $("#baggage_slider<?=$bslider['ond']?>").slider('getValue');
						var bg_value = cwtpoints<?=$bslider['ond']?>[bg_weight];
						var dtpfext_id=<?=$bslider['dtpfext_id']?>;
						$.ajax({
						async: false,
						type: 'POST',
						url: "<?=base_url('homes/bidding/saveBidData')?>",       
						data: {"ond":<?=$bslider['ond']?>,"orderID":orderID,"dtpfext_id":dtpfext_id,"offer_id" :offer_id,"weight":bg_weight,"baggage_value":bg_value,"tot_cash":bg_pay_cash,"product_id":product_id,"tot_miles":bg_miles,"tot_bid":bg_tot_bid},
						dataType: "html",			
						success: function(data) {
							var info = jQuery.parseJSON(data);              		
							if(info['status'] == "success"){
								paysuccess = 1;
							} else {
								//alert(info['status']);
								paysuccess = 0;
								status = status + "<p>"+info['status']+"</p>";
							}			
						}
						});				   
			   		<?php } ?>
			       }
			<?php } ?>
               if(paysuccess == 1){
				   window.location = "<?=base_url('home/paysuccess')?>/"+offer_id;
			   } else {
				   alert($(status).text());
			   }
			} else {
				var status = cardinfo['status'];
				alert($(status).text());
			}			
          }
			 		  
     }); 
 } 
 
 
 
 function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".short-full")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>
