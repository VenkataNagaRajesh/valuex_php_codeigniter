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
							<p>Passenger(s):<span><?php echo ucfirst($results[0]->pax_names); ?></span>
							<span class="pull-right" style="color:#333;">Booking Ref No: <?=$results[0]->pnr_ref?></span></p>
							<div class="col-md-5">
								<h2>Flight Information</h2>
								<?php foreach($results as $result){ ?>
								<div class="bid-info <?=($result->fclr == null)?"bid-visible":""?>">
									<div class="col-md-6">
										<p><?php echo $result->from_city; ?></p>
										<ul>
											<li><?php echo date('d M Y',$result->dep_date); ?></li>
											<li>Flight <?php echo $result->carrier_code.$result->flight_number; ?></li>
											<li><?=$result->time_diff?></li>
											<li><?=date('H:i a',$result->dep_date+$result->dept_time)?></li>
										</ul>
									</div>
									<p><i class="fa fa-fighter-jet"></i></p>
									<div class="col-md-6">
										<p><?php echo $result->to_city; ?></p>
										<ul>
											<li><?php echo date('d M Y',$result->arrival_date); ?></li>
											<li>Flight <?php echo $result->carrier_code.$result->flight_number; ?></li>
											<li><?=$result->time_diff?></li>
											<li><?=date('H:i a',$result->arrival_date+$result->arrival_time)?></li>
										</ul>
									</div>
								</div>
								<?php } ?>
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
								<?php foreach($results as $result){ ?>
									<div class="bid-radio">
									   <?php $i=0; //$offer_cabins = explode(',',$result->to_cabins);
									   foreach($result->to_cabins as $key => $value) { if($result->fclr != null){ ?>								      
										<label class="radio-inline">
											<input type="radio" name="bid_cabin_<?=$result->flight_number?>" value="<?php echo $value.'|'.$key; ?>" <?php echo ($i==0)?"checked":''; ?> ><?php echo $cabins[$value]; ?>
										</label><br>
									   <?php $i++; } } ?>									
									</div>
								<?php } ?>
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
								<?php foreach($results as $result){  if($result->fclr != null){ ?>
								<div class="price-range">									
                                    	<i class="fa fa-dollar"></i><b id="bid_min_<?=$result->flight_number?>"></b>
       										<input id="bid_slider_<?=$result->flight_number?>" data-slider-id='bid_slider_<?=$result->flight_number?>Slider' type="text" data-slider-min="<?php echo explode(',',$result->min)[0]; ?>" data-slider-max="<?php echo explode(',',$result->max)[0]; ?>" data-slider-step="1" data-slider-value="<?php echo explode(',',$result->avg)[0]; ?>" data-slider-handle="square"min-slider-handle="200"/>
										<i class="fa fa-dollar"></i><b id="bid_max_<?=$result->flight_number?>"></b>
								</div>
								<?php } } ?>
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
								<p class="pull-right">Total Bid Amount  <b style="margin-left:12px;"><i class="fa fa-dollar" id="tot"></i> </b></p>
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
							<h2 class="pull-right">Booking Ref No: <?php echo $results[0]->pnr_ref; ?></h2>
						</div>
						<div class="col-md-12">
							<p class="pull-right">Total Bid Amount  <b style="margin-left:12px;"><i class="fa fa-dollar" id="bidtot"></i> </b></p>
						</div>
						<div class="col-md-8 col-md-offset-2">
							<div class="price-range">
								<b id="mile-min"> </b>
       										<input id="miles" data-slider-id='milesSlider' type="text" data-slider-min="0" data-slider-max="<?=$results[0]->miles?>" data-slider-step="5" data-slider-value="<?=$results[0]->miles/2?>" data-slider-handle="square"min-slider-handle="200"/>
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
												<input type="tel" class="form-control" name="card_number" id="card_number"
													placeholder="Enter Card Number" min="16" max="16"
												/>
												<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
											</div>
										</div>
									</div>                            
									<div class="form-group card-exp">
										<div class="col-md-6">
											<label for="cardExpiry">Expiry Date</label>
											<input type="tel" class="form-control" name="month_expiry" id="month_expiry" placeholder="MM"/>
											/ <input type="tel" class="form-control" name="year_expiry" id="year_expiry" placeholder="YY"/>
										</div>
										<div class="col-md-6">
											<label for="cardCVC" style="position: relative;margin-left: auto;margin-right: 2em;">CVV</label>
											<input type="tel" class="form-control pull-right" name="cvv" id="cvv" />
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
									<p>Total Cash to be Paid <b><i class="fa fa-dollar" id="paid_cash"></i></b></p>
									<p>Total Miles to be Paid : <b id="paid_miles"></b></p>
									<a href="#" type="button" class="btn btn-danger" onclick="saveBid(<?=$result->offer_id?>)">Pay Now</a>
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
var mile_value = <?=$mile_value?>;
var mile_proportion = <?=$mile_proportion?>;

$(document).ready(function () {
   $('#milesSlider .slider-selection').css({"background":"#0feded"});
	   $('#milesSlider .slider-handle').css({"background":"#0feded"});	
   tot_avg = 0;
  <?php foreach($results as $result){  if($result->fclr != null){  ?>
    var tot_avg = tot_avg + <?=explode(',',$result->avg)[0]?>;
    $('#bid_min_<?=$result->flight_number?>').text(<?php echo explode(',',$result->min)[0]; ?>);
    $('#bid_max_<?=$result->flight_number?>').text(<?php echo explode(',',$result->max)[0]; ?>);
    changeColors(<?=$result->flight_number?>);
  <?php } } ?>  
  $("#tot").text(tot_avg);
  $("#bidtot").text(tot_avg);  
  mileSliderUpdate();
 
});
<?php foreach($results as $result){  if($result->fclr != null){ ?> 
$('#bid_slider_<?=$result->flight_number?>').slider({
	tooltip: 'always',
	formatter: function(value) {
		return '$'+value + ' per Passenger';
	}
});
<?php } } ?>

$('#miles').slider({
	tooltip: 'always',
	formatter: function(value) {			
		var dollar = value * mile_value;
		//var bid_amount = $("#ex1").slider('getValue');
		var bid_amount = getTotal();
		var pay_cash = bid_amount - Math.round(dollar);
		$("#paid_cash").text(pay_cash);
        $("#paid_miles").text(value + ' Miles'+'($'+Math.round(dollar)+')'); 		
		return '$'+pay_cash+' + '+value + ' Miles'+'($'+Math.round(dollar)+')';
		//return value;
		
	}
});

<?php foreach($results as $result){   if($result->fclr != null){?> 	
$("#bid_slider_<?=$result->flight_number?>").on("slide", function(slideEvt) {
	var tot_avg = getTotal();
	$("#tot").text(tot_avg);
	$("#bidtot").text(tot_avg);	 
    mileSliderUpdate();	
    changeColors(<?=$result->flight_number?>);	 
});
<?php } } ?>

<?php foreach($results as $result){  if($result->fclr != null){ ?>
$('input[type=radio][name=bid_cabin_<?=$result->flight_number?>]').change(function(){
	var bid_cabin = $(this).val();
	var result = $(this).val().split('|');
       $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('homes/bidding/getFclrValues')?>",          
		  data: {"fclr_id" :result[1]},
          dataType: "html",			
          success: function(data) {
            var info = jQuery.parseJSON(data);              		
            $("#bid_slider_<?=$result->flight_number?>").slider('setAttribute', 'max', Math.round(info['max']));
		    $("#bid_slider_<?=$result->flight_number?>").slider('setAttribute', 'min', Math.round(info['min']));
		    $("#bid_slider_<?=$result->flight_number?>").slider('setValue', Math.round(info['average']));
			$("#bid_min_<?=$result->flight_number?>").text(Math.round(info['max']));
			$("#bid_min_<?=$result->flight_number?>").text(Math.round(info['min']));
			var tot_avg = getTotal();
			 $("#tot").text(tot_avg);
			 $("#bidtot").text(tot_avg);			
			mileSliderUpdate();
            changeColors(<?=$result->flight_number?>);			
          }
     });
});
<?php } } ?>

 function getTotal(){
		var tot_avg = 0;
		<?php foreach($results as $result){  if($result->fclr != null){ ?>
		  tot_avg = tot_avg+$("#bid_slider_<?=$result->flight_number?>").slider('getValue');;
		<?php } } ?>	
		return tot_avg; 
	}

 function changeColors(id){
	 var value = $("#bid_slider_"+id).slider('getValue');	
	 var diff = $("#bid_slider_"+id).slider('getAttribute', 'max') - $("#bid_slider_"+id).slider('getAttribute', 'min');
	 var min = $("#bid_slider_"+id).slider('getAttribute', 'min');
	 var one = min + Math.round((diff)*(25/100));
	 var two = min + Math.round((diff)*(50/100));
	 var three = min+ Math.round((diff)*(75/100));
	 	 
	  if(value <= one ){
	   $('#bid_slider_'+id+'Slider .slider-selection').css({"background":"red"});
	   $('#bid_slider_'+id+'Slider .slider-handle').css({"background":"red"});
     } else if(value <= two){ 
	   $('#bid_slider_'+id+'Slider .slider-selection').css({"background":"orange"}); 
	   $('#bid_slider_'+id+'Slider .slider-handle').css({"background":"orange"});
     } else if(value <= three ){
	   $('#bid_slider_'+id+'Slider .slider-selection').css({"background":"#00ff00"}); 
	   $('#bid_slider_'+id+'Slider .slider-handle').css({"background":"#00ff00"});
     } else {
	    $('#bid_slider_'+id+'Slider .slider-selection').css({"background":"#009900"}); 
		$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"#009900"});
     }
 }
 
 function mileSliderUpdate(){	  
	 var value = getTotal();	  
     var miles = value/mile_value;
	  $("#mile-min").text(0+' Miles');  
	 // $("#mile-max").text(Math.round(miles)+' Miles');
	 // $("#mile1").slider('setAttribute', 'max', Math.round(miles));
	 //$("#mile1").slider('setValue', Math.round(miles)* mile_proportion);
	  $("#mile-max").text( Math.round(Math.round(miles)* mile_proportion)+' Miles');
	  $("#miles").slider('setAttribute', 'max', Math.round(Math.round(miles)* mile_proportion));	  
	  $("#miles").slider('setValue',0);  
	  $("#miles").slider('setAttribute', 'step', Math.round(1/mile_value)); 
	  
 }
 
 function saveBid(offer_id){  			
    $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('homes/bidding/saveCardData')?>",          
		  data: {"card_number" :$('#card_number').val(),"month_expiry":$('#month_expiry').val(),"year_expiry":$('#year_expiry').val(),"cvv":$('#cvv').val(),"offer_id":offer_id},
          dataType: "html",			
          success: function(data) {
            var cardinfo = jQuery.parseJSON(data);              		
            if(cardinfo['status'] == "success"){
		      <?php foreach($results as $result){  if($result->fclr != null){ ?>
				var bid_value = $("#bid_slider_<?=$result->flight_number?>").slider('getValue');  
				var miles = $("#miles").slider('getValue');	
				var pay_cash = bid_value - Math.round(miles * mile_value);
				var flight_number = <?=$result->flight_number?>;
				
				var upgrade = $('input[type=radio][name=bid_cabin_<?=$result->flight_number?>]:checked').val().split('|');
				var upgrade_type = upgrade[0];	
				var fclr_id = upgrade[1];
				$.ajax({
				  async: false,
				  type: 'POST',
				  url: "<?=base_url('homes/bidding/saveBidData')?>",          
				  data: {"offer_id" :offer_id,"bid_value":bid_value,"miles":miles,"cash":pay_cash,"flight_number":flight_number,"upgrade_type":upgrade_type,"fclr_id":fclr_id},
				  dataType: "html",			
				  success: function(data) {
					var info = jQuery.parseJSON(data);              		
					if(info['status'] == "success"){
						window.location = "<?=base_url('home/paysuccess')?>/"+offer_id;
					} else {
						alert(info['status']);
					}			
				  }
			   });
			  <?php } } ?>
			} else {
				var status = cardinfo['status'];
				alert($(status).text());
			}			
          } 
     }); 
 } 
 
</script>


