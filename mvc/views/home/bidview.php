<div class="container top-bar">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-2">
				<img class="img-responsive" src="<?php echo base_url('assets/home/images/emir.png'); ?>" alt="logo">
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="bid-tab">
			<ul class="nav nav-tabs">
				<li class="col-md-6"><a href="#offer"><span class="badge badge-secondary">1</span> Make Us an Offer</a></li>
				<li class="col-md-6"><a href="#payment"><span class="badge badge-secondary">2</span> Review & Payment</a></li>
			</ul>
            <div class="tab-content">
                <div id="offer" class="">
					<div class="col-md-12">
						<h3>your chance for a Emirates business upgrade</h3>
						<p>Treat yourself to the amenities and comfort of business upgrade to business class by submitting your bid here is how to proceed</p>
						<ol>
							<li>Submit your bid per flight leg and click on next</li>
							<li>Indicate your method of payment you will be charged only if your upgrade bid has been approved</li>
							<li>Check and confirm your data</li>
						</ol>
						<p>The submission of your bid will be confirmed in a sepate email. you will receive a message from us between 120 and 48 hours before departure informing you whether or not you bid has been accepted, Bids are per flight segment and donot including the original ticket price</p>
					</div>
					<div class="col-md-10">
						<div class="pass-info">
							<p>Passenger(s):<span><?php echo ucfirst($result->pax_names); ?></span>
							<span class="pull-right" style="color:#333;">Booking Ref No: 12346789</span></p>
							<div class="col-md-5">
								<h2>Flight Information</h2>
								<div class="bid-info">
									<div class="col-md-6">
										<p><?php echo $result->from_city; ?></p>
										<ul>
											<li><?php echo date('d M Y',$result->dep_date); ?></li>
											<li>Flight <?php echo $result->carrier_code.$result->flight_number; ?></li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
									<p><i class="fa fa-fighter-jet"></i></p>
									<div class="col-md-6">
										<p><?php echo $result->to_city; ?></p>
										<ul>
											<li><?php echo date('d M Y',$result->dep_date); ?></li>
											<li>Flight <?php echo $result->carrier_code.$result->flight_number; ?></li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
								</div>
						<!--	<div class="bid-info bid-visible">
									<div class="col-md-6">
										<p>Los Angeles</p>
										<ul>
											<li>02 Jan 2016</li>
											<li>Flight LX 41</li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
									<p><i class="fa fa-fighter-jet"></i></p>
									<div class="col-md-6">
										<p>Zurich (ZRH)</p>
										<ul>
											<li>02 Jan 2016</li>
											<li>Flight LX 41</li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
								</div>
								<div class="bid-info">
									<div class="col-md-6">
										<p>Los Angeles</p>
										<ul>
											<li>02 Jan 2016</li>
											<li>Flight LX 41</li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
									<p><i class="fa fa-fighter-jet"></i></p>
									<div class="col-md-6">
										<p>Zurich (ZRH)</p>
										<ul>
											<li>02 Jan 2016</li>
											<li>Flight LX 41</li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
								</div>
								<div class="bid-info">
									<div class="col-md-6">
										<p>Los Angeles</p>
										<ul>
											<li>02 Jan 2016</li>
											<li>Flight LX 41</li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
									<p><i class="fa fa-fighter-jet"></i></p>
									<div class="col-md-6">
										<p>Zurich (ZRH)</p>
										<ul>
											<li>02 Jan 2016</li>
											<li>Flight LX 41</li>
											<li>11 hours 15 mins</li>
											<li>02.30am-15.25pm</li>
										</ul>
									</div>
								</div>-->
							</div>
							<div class="col-md-3">
								<h2>Upgrade Type</h2>
								<div class="bid-radio">
								   <?php $i=0; //$offer_cabins = explode(',',$result->to_cabins);
								   foreach($result->to_cabins as $key => $value) {?>								      
									<label class="radio-inline">
										<input type="radio" name="bid_cabin" value="<?php echo $value.'|'.$key; ?>" <?php echo ($i==0)?"checked":''; ?> ><?php echo $cabins[$value]; ?>
									</label><br>
								   <?php $i++; } ?>
									<!--<label class="radio-inline">
										<input type="radio" name="optradio">Business
									</label><br>
									<label class="radio-inline">
										<input type="radio" name="optradio">No Bid
									</label>-->
								</div>
								<!--<div class="bid-radio bid-visible">
									<label class="radio-inline">
										<input type="radio" name="optradio">Premium
									</label><br>
									<label class="radio-inline">
										<input type="radio" name="optradio">Business
									</label><br>
									<label class="radio-inline">
										<input type="radio" name="optradio">No Bid
									</label>
								</div>
								<div class="bid-radio">
									<label class="radio-inline">
										<input type="radio" name="optradio">Premium
									</label><br>
									<label class="radio-inline">
										<input type="radio" name="optradio">Business
									</label><br>
									<label class="radio-inline">
										<input type="radio" name="optradio">No Bid
									</label>
								</div>
								<div class="bid-radio">
									<label class="radio-inline">
										<input type="radio" name="optradio">Premium
									</label><br>
									<label class="radio-inline">
										<input type="radio" name="optradio">Business
									</label><br>
									<label class="radio-inline">
										<input type="radio" name="optradio">No Bid
									</label>
								</div>-->
							</div>
							<div class="col-md-4">
								<h2>Bid (s)</h2>
								<div class="price-range">
									<!--<div role="main" class="ui-content">
										<div class="jquery-script-ads"></div>
										<label for="slider"></label>
										<?php// echo round(explode(',',$result->min)[0]); ?>
										<input type="range" name="sliders" id="slider0"  value="<?php echo round($result->avg); ?>" min="<?php echo round(explode(',',$result->min)[0]); ?>" max="<?php echo round(explode(',',$result->max)[0]); ?>" data-highlight="true" step="1">
										<?php// echo round(explode(',',$result->max)[0]); ?>
									</div>-->
                                    	<b>$<?php echo explode(',',$result->min)[0]; ?> </b>
       										<input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="<?php echo explode(',',$result->min)[0]; ?>" data-slider-max="<?php echo explode(',',$result->max)[0]; ?>" data-slider-step="1" data-slider-value="<?php echo explode(',',$result->avg)[0]; ?>" data-slider-handle="square"/>
										<b> $<?php echo explode(',',$result->max)[0]; ?></b>								
								</div>
								<!--<div class="price-range bid-visible">
									<p>Price Range</p>
								</div>
								<div class="price-range">
									<div role="main" class="ui-content">
										<div class="jquery-script-ads"></div>
										<label for="slider"></label>
										<input type="range" name="sliders" id="slider1"  value="93" min="0" max="100" data-highlight="true">
									</div>
								</div>
								<div class="price-range">
									<p>Price Range</p>
								</div>-->
							</div>
							<div class="col-md-12" style="padding-right:0;">
								<p class="pull-right">Total Bid Amount <i class="fa fa-dollar" id="tot"> </i></p>
							</div>
							<a data-toggle="tab" href="#offer" class="btn btn-danger  pull-right btn btn-secondary sw-btn-next" type="button">Continue</a>
						</div>
					</div>
					<div class="col-md-2">
						<div class="side-image">
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
						</div>
					</div>
				</div>
                <div id="payment" class="">
					<div class="col-md-9">
						<div class="col-md-2 back-btn">
							<a type="button" class="btn btn-danger btn btn-secondary sw-btn-prev"><i class="fa fa-arrow-left"></i> Back</a>
						</div>
						<div class="col-md-10 booking-ref">
							<h2 class="pull-right">Booking Ref No: 12346789</h2>
						</div>
						<div class="col-md-12">
							<p class="pull-right">Total Bid Amount  <b style="margin-left:12px;"><i class="fa fa-dollar"></i> 2100.00</b></p>
						</div>
						<div class="col-md-8 col-md-offset-2">
							<div class="price-range">
								<p>Price Range</p>
							</div>
						</div>
						<div class="col-md-12 payment-box">
							<form role="form" id="payment-form" method="POST" action="#">
								<div class="col-md-8">
									<div class="form-group">
										<div class="col-md-12">
											<label for="cardNumber">Card number</label>
											<div class="input-group">
												<input type="tel" class="form-control" name="cardNumber"
													placeholder="Enter Card Number"
												/>
												<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
											</div>
										</div>
									</div>                            
									<div class="form-group card-exp">
										<div class="col-md-6">
											<label for="cardExpiry">Expiry Date</label>
											<input type="tel" class="form-control" name="cardExpiry" placeholder="MM"/>
											/ <input type="tel" class="form-control" name="cardExpiry" placeholder="YY"/>
										</div>
										<div class="col-md-6">
											<label for="cardCVC" style="position: relative;margin-left: auto;margin-right: 2em;">CVV</label>
											<input type="tel" class="form-control pull-right" name="cardCVC" />
										</div>
									</div>
									<div class="col-md-12">
										<div class="pay-info">
											<p>Your card will save for future usage upon BID Confirmation</p>
											<p>Bid Participation Charges  <b>(1$ Non Refundable)</b></p>
										</div>
									</div>
								</div>
								<div class="col-md-4 actual-cash">
									<p>Total Cash to be Paid <b><i class="fa fa-dollar"></i>1200.00</b></p>
									<a href="#" type="button" class="btn btn-danger">Pay Now</a>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-3">
						<div class="side-video">
							<iframe src="https://www.youtube.com/embed/_O2_nTt1N6w" width="100%" height="180"></iframe>
						</div>
						<div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('assets/home/images/multi-bid/mb2.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('assets/home/images/multi-bid/mb3.jpg'); ?>" alt="img1">
						</div>
					</div>
				</div>
            </div>
        </div>
	</div>
</div>

<script>
$('input[type=radio][name=bid_cabin]').change(function(){
	var bid_cabin = $(this).val();
	console.log(bid_cabin);
	var result = $(this).val().split('|');
   console.log( result[1] );
}); 
$(document).ready(function () {
  $("#tot").text(<?php echo explode(',',$result->avg)[0]; ?>); 
});

  $('#ex1').slider({
	tooltip: 'always',
	formatter: function(value) {
		return value + ' Per Passenger(1)';
	}//,
	//rangeHighlights: [{ "start": 150, "end": 250, "class": "category1" },
                 //     { "start": 250, "end": 300, "class": "category2" }] 
});

$("#ex1").on("slide", function(slideEvt) {
	$("#tot").text(slideEvt.value);
   if(slideEvt.value < 250){
	   $(' #ex1Slider .slider-selection').css({"background":"#f2126f"});
   } else if(slideEvt.value < 300 && slideEvt.value > 250){
	   $(' #ex1Slider .slider-selection').css({"background":"green"}); 
   } else if(slideEvt.value > 300 ){
	   $(' #ex1Slider .slider-selection').css({"background":"yellow"}); 
   }
});

</script>


