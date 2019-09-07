<div class="container top-bar">
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
							<div class="table">
								<table class="table">
									<thead>
										<tr>
											<th>Flight Information</th>
											<th style="text-align:left;">Upgrade To Cabin</th>
											<th>Bid Amount</th>
											<!--<th>Action</th>-->
										</tr>
									</thead>
									<tbody>
										<?php $n=1; foreach($results as $result){ ?>
										<tr>
										<td><div class="col-md-12"><p><?=$n?> . <?php echo $result->air_from_city; ?> To <?php echo $result->air_to_city; ?> </p></div></td>
										</tr>
										<tr>
											<td>
												
												<div class="bid-info <?=($result->fclr == null)?"bid-visible":""?>">
													<div class="col-md-5">
														<p><?php echo $result->from_city_code; ?> <span class="time-bid"><?=date('H:i A',$result->dep_date+$result->dept_time)?></span></p>
														<small>Singapore</small>
														<ul>
															<li><?php echo date('d M',$result->dep_date); ?></li>
															<li>Flight <?php echo $result->carrier_code.$result->flight_number; ?></li>
															<!--<li><?=$result->time_diff?></li>-->
														</ul>
													</div>
													<div class="col-md-2"><p style="text-align:center;"><i class="fa fa-plane"></i></p></div>
													<div class="col-md-5">
														<p><?php echo $result->to_city_code; ?> <span class="time-bid"><?=date('H:i A',$result->arrival_date+$result->arrival_time)?></span></p>
														<small>Bengaluru</small>
														<ul>
															<li><?php echo date('d M',$result->arrival_date); ?></li>
															<li>Flight <?php echo $result->carrier_code.$result->flight_number; ?></li>
															<!--<li><?=$result->time_diff?></li>-->
														</ul>
													</div>
												</div>											
											</td>
											<td>		 
												<div class="bid-radio col-md-12">
												   <?php $i=0; //$offer_cabins = explode(',',$result->to_cabins);
												   foreach($result->to_cabins as $key => $value) { if($result->fclr != null){  $split = explode('-',$key); $key = $split[0]; $status = $split[1]; ?>								      
													<label class="cabins-<?=$result->flight_number?> radio-inline <?=($status == $excluded_status)?"bid-visible":""?>" >
														<input type="radio" name="bid_cabin_<?=$result->flight_number?>" value="<?php echo $value.'|'.$key; ?>" <?php echo ($i==0 )?"checked":''; ?> ><?php echo $cabins[$value]; ?>
													</label><br>
												   <?php if($status != $excluded_status) { $i++; } } } ?>
                                               		<label class="checkbox-inline<?=($result->fclr == null)?"bid-visible":""?>">
														<input type="checkbox" name="bid_action_<?=$result->flight_number?>" value="1" /> Cancel Bid 
													</label>									   
											  <!-- <div class="<?=($result->fclr == null)?"bid-visible":""?>">
											       <b><input type="checkbox" name="bid_action_<?=$result->flight_number?>" value="1" /> Cancel Bid <br></b>								
												</div>	-->												   
                                              </div>
                                                											
											</td>
											<td>
												<?php if($result->fclr != null){
													  $i=0;
													 foreach($result->to_cabins as $key => $value) {		 
													  $split = explode('-',$key); $key = $split[0]; $status = $split[1];
													   if($status == $sent_mail_status){
														 break;  
													   } else {
														   $i++;
													   }
													 }	?>       
												
													<div class="price-range col-md-12">		
													<b>Min</b> <i class="fa fa-dollar"></i> <b id="bid_min_<?=$result->flight_number?>"></b>
															<input id="bid_slider_<?=$result->flight_number?>" data-slider-id='bid_slider_<?=$result->flight_number?>Slider' type="text" data-slider-min="<?php echo explode(',',$result->min)[$i]; ?>" data-slider-max="<?php echo explode(',',$result->max)[$i]; ?>" data-slider-step="1" data-slider-value="<?php echo explode(',',$result->slider_position)[$i]; ?>" data-slider-handle="round"min-slider-handle="200"/>
													<b>Max</b> <i class="fa fa-dollar"></i> <b id="bid_max_<?=$result->flight_number?>"></b>
													</div>
												<?php }  ?>
											</td>
											<!--<td>
											  <div class="<?=($result->fclr == null)?"bid-visible":""?>">
											  <input type="radio" name="bid_action_<?=$result->flight_number?>" value="1" checked/> Yes <br>
											  <input type="radio" name="bid_action_<?=$result->flight_number?>" value="0"/> No
											  </div>
											</td>-->
										</tr>
										<?php $n++; } ?>
									</tbody>
								</table>
							</div>
							<div class="col-md-12" style="padding-right:0;">
								<p class="pull-right">Total Bid Amount  <strong style="margin-left:12px;"> <i class="fa fa-dollar"></i> <b id="tot"></b></strong> </p>
							</div>
							<a data-toggle="tab" href="#offer" class="btn btn-danger  pull-right btn btn-secondary sw-btn-next" type="button">Continue</a>
						</div>
					</div>
					<div class="col-md-2">
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
						<?php foreach($images as $img){ ?>
							<div class="side-image">
							<img class="img-responsive img-thumbnail" src="<?php echo base_url('uploads/images/'.$img->image); ?>" alt="img1">
						</div>
						<?php } ?>
					</div>
				</div>
                <div id="payment" class="">
					<div class="col-md-9">
						<div class="col-md-2 back-btn">
							<a type="button" class="btn btn-danger btn btn-secondary sw-btn-prev"><i class="fa fa-arrow-left"></i> Back</a>
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
											<p>Your card will save for future usage upon BID Confirmation</p>
											<p>Bid Participation Charges  <b>(1$ Non Refundable)</b></p>
										</div>
									</div>
								</div>
								<div class="col-md-4 actual-cash">
									<p>Total Cash to be Paid <strong><i class="fa fa-dollar"></i> <b id="paid_cash"></b></strong></p>
									<p>Total Miles to be Paid : <b id="paid_miles"></b> </p>
									<a href="#" type="button" class="btn btn-danger" onclick="saveBid(<?=$result->offer_id?>)">Pay Now</a>	
                                  					
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-3">
						<div class="side-video">
							<!--<iframe src="https://www.youtube.com/embed/_O2_nTt1N6w" width="100%" height="180"></iframe>-->
							<iframe src="<?=$airline_video_link?>" width="100%" height="180"></iframe>
						</div>
						
						<!--<div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('assets/home/images/multi-bid/mb2.jpg'); ?>" alt="img1">
						</div>
						<div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('assets/home/images/multi-bid/mb3.jpg'); ?>" alt="img1">
						</div>-->
						<?php $i=1; foreach($images as $img){ if($i < 3){ ?>
						  <div class="side-image">
							<img class="img-responsive" src="<?php echo base_url('uploads/images/'.$img->image); ?>" alt="img1">
						  </div> 
						<?php }$i++;} ?>
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

$(document).ready(function () {
	
   $('#milesSlider .slider-selection').css({"background":"#0feded"});
	   $('#milesSlider .slider-handle').css({"background":"#0feded"});	
   tot_avg = 0;
  <?php foreach($results as $result){  if($result->fclr != null){  ?>	  
	<?php $i=0; $flag =0;
	 foreach($result->to_cabins as $key => $value) {		 
	  $split = explode('-',$key); $key = $split[0]; $status = $split[1];
       if($status == $sent_mail_status){
		 $flag = 1;
		 break;  
	   } else {
		   $i++;
	   }
	 }	if($flag == 1 && explode(',',$result->min)[$i]){  ?>
       	
    $('#bid_min_<?=$result->flight_number?>').text(<?php echo explode(',',$result->min)[$i]; ?>);
    $('#bid_max_<?=$result->flight_number?>').text(<?php echo explode(',',$result->max)[$i]; ?>);
	//var tot_avg = tot_avg + <?=explode(',',$result->avg)[$i]?>;
    changeColors(<?=$result->flight_number?>);
  <?php } } } ?>    
 // $("#tot").text(tot_avg*<?=$passengers_count?>);
  //$("#bidtot").text(tot_avg*<?=$passengers_count?>);  
    var total = getTotal();
	$("#tot").text(total);
	$("#bidtot").text(total);
    mileSliderUpdate();
 
});
<?php foreach($results as $result){  if($result->fclr != null){ ?> 
$('#bid_slider_<?=$result->flight_number?>').slider({
	tooltip: 'always',
	formatter: function(value) {
		return '$'+value + ' Per Person';
	}
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
$("#bid_slider_<?=$result->flight_number?>").on("click", function(slideEvt) { 
	var tot_avg = getTotal();
	$("#tot").text(tot_avg);
	$("#bidtot").text(tot_avg);	 
    mileSliderUpdate();	
    changeColors(<?=$result->flight_number?>);	 
});
//action click
$('input[type=checkbox][name=bid_action_<?=$result->flight_number?>]').click(function(){	
	 if($(this). prop("checked") == true){
	   $('.cabins-'+<?=$result->flight_number?>).addClass('bid-visible');
	   $("#bid_slider_<?=$result->flight_number?>").slider('disable'); 
	 } else {
	    $('.cabins-'+<?=$result->flight_number?>).removeClass('bid-visible');
	   $("#bid_slider_<?=$result->flight_number?>").slider('enable');  
	 }
	var tot_avg = getTotal();
	$("#tot").text(tot_avg);
	$("#bidtot").text(tot_avg);
	mileSliderUpdate();
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
			$("#bid_max_<?=$result->flight_number?>").text(Math.round(info['max']));
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
		<?php foreach($results as $result){  if($result->fclr != null){ ?>//$(this). prop("checked") == true
		  // var action = $('input[type=checkbox][name=bid_action_<?=$result->flight_number?>]:checked').val();	  
		  //if(action == 1){
         if($('input[type=checkbox][name=bid_action_<?=$result->flight_number?>]').prop("checked") == false){    			  
		   tot_avg = tot_avg+$("#bid_slider_<?=$result->flight_number?>").slider('getValue')*<?=$passengers_count?>;
		  }
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
	   //$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"red"});
     } else if(value <= two){ 
	   $('#bid_slider_'+id+'Slider .slider-selection').css({"background":"orange"});   
	   //$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"orange"});	   
	   $('#bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 100%,#cf0404 100%,#e2d704 100%)"},{"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 100%,#cf0404 100%,#e2d704 100%)"}); 
     } else if(value <= three ){
	   //$('#bid_slider_'+id+'Slider .slider-selection').css({"background":"#00ff00"}); 
	   //$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"#00ff00"});
	    $('#bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 35%,#e2d704 41%,#e2d704 59%,#04ea04 100%,#cf0404 100%,#04ea04 100%)"},{"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 35%,#e2d704 41%,#e2d704 59%,#04ea04 100%,#cf0404 100%,#04ea04 100%)"}); 
     } else {
	    //$('#bid_slider_'+id+'Slider .slider-selection').css({"background":"#009900"}); 
		//$('#bid_slider_'+id+'Slider .slider-handle').css({"background":"#009900"});
		$('#bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left, #f94231 1%,#d6b822 37%,#d6b822 37%,#d6b822 40%,#39ed25 67%,#146d28 99%,#146d28 99%,#7db9e8 100%)"},{"background":" -webkit-linear-gradient(left, #f94231 1%,#d6b822 37%,#d6b822 37%,#d6b822 40%,#39ed25 67%,#146d28 99%,#146d28 99%,#7db9e8 100%)"}); 
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
	 	/* var lhtml = '<div class="ring">Loading<span></span></div>';
		//$('.myloading').html(lhtml);
		var image = "<?php echo base_url(). 'assets/home/images/Spinner.gif'; ?>";
$('#loading').html("<img src='"+image+"' />"); */
		
      var miles = $("#miles").slider('getValue');
      var tot_bid = getTotal();
	  var pay_cash = tot_bid - Math.round(miles * mile_value);		
    $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('homes/bidding/saveCardData')?>",          
		  data: {"card_number" :$('#card_number').val(),"month_expiry":$('#month_expiry').val(),"year_expiry":$('#year_expiry').val(),"cvv":$('#cvv').val(),"offer_id":offer_id,"cash":pay_cash,"miles":miles,"tot_bid":tot_bid},
          dataType: "html",	         		  
          success: function(data) {
            var cardinfo = jQuery.parseJSON(data);              		
            if(cardinfo['status'] == "success"){
		      <?php foreach($results as $result){  if($result->fclr != null){ ?>
				var bid_value = $("#bid_slider_<?=$result->flight_number?>").slider('getValue')*<?=$passengers_count?>;			
				//var pay_cash = bid_value - Math.round(miles * mile_value);				
				var flight_number = <?=$result->flight_number?>;				
				var upgrade = $('input[type=radio][name=bid_cabin_<?=$result->flight_number?>]:checked').val().split('|');
				var upgrade_type = upgrade[0];	
				var fclr_id = upgrade[1];
				//var bid_action = $('input[type=radio][name=bid_action_<?=$result->flight_number?>]:checked').val();
				if($('input[type=checkbox][name=bid_action_<?=$result->flight_number?>]').prop("checked") == false){
					var bid_action = 1;
				} else {
					var bid_action = 0;
				}
				$.ajax({
				  async: false,
				  type: 'POST',
				  url: "<?=base_url('homes/bidding/saveBidData')?>",          
				  data: {"offer_id" :offer_id,"bid_value":bid_value,"flight_number":flight_number,"upgrade_type":upgrade_type,"fclr_id":fclr_id,'bid_action':bid_action,"tot_cash":pay_cash,"tot_miles":miles,"tot_bid":tot_bid},
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



