<style>
    /*09-02-2021 style sheet*/

.subs-hdng{ width:100%; margin:0; padding:0; background:#f4f4f4; font-size:18px; font-weight:500; color:#000;}
.top-tbl-bar{ width:100%; margin:20px 0; padding:0; background:<?=$mail_header_color?>; float:left; border:0px;}
.top-tbl-bar h2{ width:100%; margin:0; padding: 10px 0; font-size:20px; font-weight:500; color: #fff;}

.sub-tbl-bar{ width:100%; margin:0px 0; padding:0; display:block; border:0px;}
.sub-tbl-bar h2{ width: 100%;
    margin: 0 0 20px 0;
    padding: 10px;
    font-size: 20px;
    font-weight: 500;
    color: #000;
    background: #efefef;}



.lft-gap{padding-left:0px !important;}
.accordion {
    float: left;
    width: 100%;
}
.accordion-inner h2{width:100%; margin:0; padding:30px 0 10px 0;  font-size:20px; font-weight:500; color:#000; border-bottom:1px solid #ccc;}
.accordion-heading h2 {
    font-size: 18px;
    margin: 0;
    padding: 10px 0;
}
.lst-box{width:100%; margin:0px; padding:0px;}
.lst-box ul{width:100%; margin:0px; padding:0px; list-type:none;}
.lst-box li{width:100%; margin:10px; padding:0px;}
.bid-tab .tab-content .tab-pane p{margin-top:0px;}
#offer .price-range{padding:10px 15px ;}
.badge{width:20px; height:20px;padding:0px; border-radius:50%; line-height:17px !important; text-align:center;}
.payment-box .actual-cash{margin-top: 20px;}
.payment-box .card-exp input{width:85px;}


@media screen and (max-width: 767px) {

	#offer .pull-right, #payment .pull-right{
		display: table;
		float: right !important;
		margin-left: 0;
	}

}




@media (min-width: 480px) and (max-width: 680px) {
    
  .lst-box li{width:32%; margin:0px !important; }
  .bid-tab li{padding:0px;}
#offer .price-range{padding:20px 15px 0px 15px ;}
  .payment-box .card-exp input{width:60px;}

}
@media (min-width: 320px) and (max-width: 479px) {
    
  .lst-box li{width:45%; margin:0px !important; }
  .bid-tab li{padding:0px;}
  .payment-box .card-exp input{width:55px;}

}


</style>
<?php 
		if ( $error) {
?>
				<br>
				<br>
				<div class="container" style="background-color:red">
					<div class="row">
						<div class="col-md-12" style="text-align:center;color:white">
								<b><big><?=$error?></big></b>
						</div>
					</div>
				</div>
<?php
		exit;
		}
	$any_product = 0;
	if ($upgrade_offer || $baggage_offer) {// 2 - BAGGAGE PRODUCT
		$any_product = 1;
	}
if ($any_product ) {
?>
<script>
	function numformat(n){
		return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	}
</script>

<div class="container" style="background:<?=$mail_header_color?>">
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
				<li class="col-xs-6 col-md-6 col-sm-6 col-lg-6"><a href="#offer"><span class="badge badge-secondary" style="color:<?=$mail_header_color?>">1</span> Make Us an Offer</a></li>
				<li class="col-xs-6 col-md-6 col-sm-6 col-lg-6"><a href="#payment"><span class="badge badge-secondary" style="color:<?=$mail_header_color?>">2</span> Review & Payment</a></li>
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
					<div class="col-md-12 col-sm-12">
						<div class="pass-info">
							<p>Passenger(s):<span style="color:<?=$mail_header_color?>"><?php echo ucfirst($pax_names); ?></span>
							<span class="pull-right" style="color:#333;">Booking Ref No: <?=$pnr_ref?></span>
							<br><span class="pull-right" style="color:#333;">No Of Passengers: <?=$passengers_count?></span>
<?php
		if ( isset($resubmit) && isset($last_bid_total_value)) {
			
?>
							<br><span class="pull-right" style="color:#333;align:right">Status: Re-bidding:  Last Bid Total: $ <i><?=$last_bid_total_value?></i></span>
<?php
		} else {
?>
			<br><span class="pull-right" style="color:#333;align:right">Status: Fresh Bidding</i></span>
<?php
		}
?>
							</p>
<?php
	} else {
?>
				<br>
				<br>
				<div class="container" style="background-color:red">
					<div class="row">
						<div class="col-md-12" style="text-align:center;color:white">
								<b><big>No Active Offers found for this PNR </big></b>
						</div>
					</div>
				</div>
<?php
	}
?>
<?php   
	if ($upgrade_offer) {// 1 - UPGRADE PRODUCT
?>
					<div class="col-sm-12 top-tbl-bar" >
    					   <div class="col-xs-7 col-sm-5 col-lg-6"><h2>Flight Information</h2></div>
    					   <div class="col-xs-5 col-sm-6 col-lg-6" ><h2>Bid Amount</h2></div>
					</div>
 <div class="col-sm-12 sub-tbl-bar"><h2 style='float:left'>Upgrade Offer</h2></div>	           
   <div class="container">
	 <div class="accordion" id="upgrade-refine">
                <?php $n=1; foreach($upgrade as $upg){?>

    <div class="hidden-phone hidden-xs">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#upgrade-refine" href="#upgrade-search<?=$n?>">
              <legend><h2><?=$n?> . <?php echo $upg->from_city; ?> To <?php echo $upg->to_city; ?></h2></legend>
            </a>
        </div>
    </div>

    <div class="visible-phone visible-xs">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#upgrade-refine" href="#upgrade-search<?=$n?>">
              <legend><h2><?=$n?> . <?php echo $upg->from_city; ?> To <?php echo $upg->to_city; ?></h2></legend>
            </a>
        </div>
    </div>
    <div id="upgrade-search<?=$n?>" class="accordion-body collapse in">
        <div class="accordion-inner">
                <div class="row">
                    
                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4 lft-gap">
                        <div class="col-xs-6 col-sm-6">                        
                                <p style="color:<?=$mail_header_color?>"><?php echo $upg->from_city; ?> <span class="time-bid"><?=date('H:i A',$upg->dep_date+$upg->dept_time);?></span></p>
        						<ul>
        							<li><?php echo date('d M Y',$upg->dep_date); ?></li>
        							<li style="color:<?=$mail_header_color?>"><?php echo $upg->carrier_code.$upg->flight_number; ?></li>
        							<!--<li><?=$upg->time_diff?></li>-->
        						</ul>
        						<small><?php echo substr($upg->from_airport,0,25) . ".."; ?></small>                        
                    	</div>

                        <div class="col-xs-6 col-sm-6">

                                <p style="color:<?=$mail_header_color?>"><?php echo $upg->to_city; ?> <span class="time-bid"><?=date('H:i A',$upg->arrival_date+$upg->arrival_time);?></span></p>
                                <ul>
                                	<li><?php echo date('d M Y',$upg->arrival_date); ?></li>
                                	<li style="color:<?=$mail_header_color?>"><?php echo $upg->carrier_code.$upg->flight_number; ?></li>
                                	<!--<li><?=$upg->time_diff?></li>-->
                                </ul>
                                <small><?php echo substr($upg->to_airport,0,25) . ".."; ?></small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2 lft-gap">
                        <div class="col-xs-12 col-sm-12"><b style="color:#000; float:left">upgrade To</b></div>
                        <div class="col-xs-12 col-sm-12">
    						<div class="col-xs-12 col-sm-12">
    						    <div class="lst-box">

							   <ul>
							   <?php $i=0; //$offer_cabins = explode(',',$upg->to_cabins);
							   foreach($upg->to_cabins as $key => $value) { if($upg->fclr != null){  $split = explode('-',$key); $key = $split[0]; $status = $split[1]; ?>			
			<?php $last_bid_name = 'last_bid_' . $upg->product_id . '_' . $upg->flight_number;?>
								<li class="cabins-<?=$upg->flight_number?> radio-inline <?=($status == $excluded_status)?"bid-visible":""?>" >
									<input type="radio" name="bid_cabin_<?=$upg->flight_number?>" value="<?php echo $value.'|'.$key; ?>" ><?php echo $cabins[$value]; ?>
								</li>
							   <?php if($status == $excluded_status) { $i++; } } } ?>
								<li class="radio-inline" >
									<input type="radio" name="bid_cabin_<?=$upg->flight_number?>" value="" >No Bid
								</li>
								<?php if (isset($last_bid[$last_bid_name])) {?>
                           		<li class="checkbox-inline<?=($upg->fclr == null)?"bid-visible":""?>">
									<input type="checkbox" name="bid_action_<?=$upg->flight_number?>" value="1" /> Cancel Bid 
								</li>	
							   <?php } ?>
								 </ul>
								 </div>
                           </div>
                        
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 lft-gap">
                            
                            <?php if($upg->fclr != null){													 
								 foreach($upg->to_cabins as $key => $value) {		 
								  $split = explode('-',$key); $key = $split[0]; $status = $split[1];
								   if($status == $sent_mail_status){
									 break;  
								   }
								 }
								 $i = array_search($key, explode(',',$upg->fclr)); 	?>       
							
								<div class="price-range col-md-12">		
								<span style="float:left;width:60px !important;"><b>Min: $</b> <i class="fa fa-dollar"></i> <b id="bid_min_<?=$upg->flight_number?>"></b></span>
									<input id="bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>" data-slider-id='bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>Slider' type="text" data-slider-min="<?php echo explode(',',$upg->min)[$i]; ?>" data-slider-max="<?php echo explode(',',$upg->max)[$i]; ?>" data-slider-step="1" data-slider-value="<?php echo explode(',',$upg->slider_position)[$i]; ?>" data-slider-handle="round"min-slider-handle="200"/>
								<span style="float:right"><b>Max: $</b> <i class="fa fa-dollar"></i> <b id="bid_max_<?=$upg->flight_number?>"></b></span>
<?php
			if (isset($last_bid[$last_bid_name])) {
					$last_bid_value = $last_bid[$last_bid_name];
?>
								<br><span style="float:left;"><b>Last Bid Value: $</b> <i class="fa fa-dollar"><?=$last_bid_value?></i></span>
<?php
			}
?>
								</div>
							<?php }  ?>
                        </div>
                    <div  id="side-image-<?=$upg->flight_number?>" class="col-xs-12 col-sm-3 col-md-2 col-lg-2 side-image" style="margin:10px 0;">
                    </div>
                </div>
            </div> 
            
	    </div>

 <script>
	$(window).bind('resize load', function() {
    if ($(this).width() <= 767) {
        $('#upgrade-search<?=$n?>').removeClass('in');
    } else {
        $('#upgrade-search<?=$n?>').addClass('in');
    }
});
function updateCabinMedia(flight_number){
	var upgrade = $('input[type=radio][name=<?=$mobile_view?>bid_cabin_'+flight_number+']:checked').val().split('|');
	var upgrade_type = upgrade[0];	
	$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('homes/bidding/getCabinImages')?>",          
		  data: {"cabin" :upgrade_type,"carrierID":<?=$upgrade[0]->carrier?>},
          dataType: "html",			
          success: function(data) {
			   //$('.side-image').html('');
               $('.side-video').html('');				   
            var cabin_media = jQuery.parseJSON(data); 
			var imghtml = ''; var videohtml = '';
			
			//dynamic Cabin images
			for (i = 0; i < cabin_media['cabin_images'].length; i++) {			 
			 imghtml += '<img class="img-responsive" src="<?=base_url("uploads/images/")?>'+cabin_media['cabin_images'][i]['image']+'" alt="img1">';
			}
             $('#side-image-' + flight_number).html(imghtml);
			 
			//Dynamic Cabin Videos
            for (i = 0; i < cabin_media['cabin_videos'].length; i++) {			 
			 videohtml += '<iframe src="'+cabin_media['cabin_videos'][i]+'" width="100%" height="180"></iframe>';
			}
            $('.side-video').html(videohtml);	 	
          }
     });
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
	     } else if(value <= two){ 
		 $('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":"orange"});   
		 $('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 100%,#cf0404 100%,#e2d704 100%)"},{"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 100%,#cf0404 100%,#e2d704 100%)"}); 
	     } else if(value <= three ){
		   $('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 35%,#e2d704 41%,#e2d704 59%,#04ea04 100%,#cf0404 100%,#04ea04 100%)"},{"background":" -webkit-linear-gradient(left,  #ff3019 0%,#e2d704 35%,#e2d704 41%,#e2d704 59%,#04ea04 100%,#cf0404 100%,#04ea04 100%)"}); 
	     } else {
		$('#<?=$mobile_view?>bid_slider_'+id+'Slider .slider-selection').css({"background":" -webkit-linear-gradient(left, #f94231 1%,#d6b822 37%,#d6b822 37%,#d6b822 40%,#39ed25 67%,#146d28 99%,#146d28 99%,#7db9e8 100%)"},{"background":" -webkit-linear-gradient(left, #f94231 1%,#d6b822 37%,#d6b822 37%,#d6b822 40%,#39ed25 67%,#146d28 99%,#146d28 99%,#7db9e8 100%)"}); 
	     }  
	 
	}
</script>               
    			   
	    
<?php $n++;}  ?>	    
</div>	    
</div>	    

<?php } ?>
</div>					   

<?php  
	if ($baggage_offer) {// 2 - BAGGAGE PRODUCT
?>
<div class="clear"></div>


<div class="col-sm-12 top-tbl-bar" >
   <div class="col-xs-7 col-sm-5 col-lg-6"><h2>Flight Information</h2></div>
   <div class="col-xs-5 col-sm-6 col-lg-6" ><h2>Bid Amount</h2></div>
</div>
<div class="col-sm-12 sub-tbl-bar"><h2 style='float:left '>Baggage offer</h2></div>
   <div class="container">
	 <div class="accordion" id="baggage-refine">
<?php $n=1;foreach($baggage as $bg => $row){ ?>
		<?php $bslider = $row['pax']; 
?>
    <div class="hidden-phone hidden-xs">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#baggage-refine" href="#baggage-search<?=$n?>">
              <legend><h2><?=$n ?> . <?php echo $bslider['from_city_name']; ?> To <?php echo $bslider['to_city_name']; ?></h2></legend>
            </a>
        </div>
    </div>

    <div class="visible-phone visible-xs">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#baggage-refine" href="#baggage-search<?=$n?>">
              <legend><h2><?=$n ?> . <?php echo $bslider['from_city_name']; ?> To <?php echo $bslider['to_city_name']; ?></h2></legend>
            </a>
        </div>
    </div>
    <div id="baggage-search<?=$n?>" class="accordion-body collapse in">
        <div class="accordion-inner">
                <div class="row">
                    
                    <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4 lft-gap">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">                        
                                <p style="color:<?=$mail_header_color?>"><?php echo $bslider['from_city_name']; ?> <span class="time-bid"><?=date('H:i A',$bslider['dep_date']+$bslider['dept_time']);?></span></p>
								<ul>
									<li><?php echo date('d M Y',$bslider['dep_date']); ?></li>
									<li style="color:<?=$mail_header_color?>"><?php echo $bslider['flight_number'];?></li>
								</ul>
								<small><?php echo substr($bslider['from_airport'],0,25) . ".."; ?></small>                       
                            </div>

                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <p style="color:<?=$mail_header_color?>"><?php echo $bslider['to_city_name']; ?> <span class="time-bid"><?=date('H:i A',$bslider['arrival_date']+$bslider['arrival_time']);?></span></p>
								<ul>
									<li><?php echo date('d M Y',$bslider['arrival_date']); ?></li>
									<li style="color:<?=$mail_header_color?>"><?php echo $bslider['flight_number'];?></li>
								</ul>
								<small><?php echo substr($bslider['to_airport'],0,25) . ".."; ?></small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2 lft-gap">
                        <div class="col-sm-12">
    						<label class="checkbox-inline">
								<input type="checkbox" name="bid_bag_<?=$bslider['flight_number']?>" id="bid_bag_<?=$bslider['flight_number']?>" value="" >Check this box if not Interested
							</label>
                        
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 lft-gap">
                       
						<?php if($bclr[$bslider['ond']]->bag_type=='PC'){ 
							$item_title = 'Piece';
							$item_unit = $bslider['piece'];
						} else {
							$item_title = 'KG';
							$item_unit = $bslider['per_max'];
						}
						?>	
							<div id="slider">
								<div class="price-range col-md-12">	
									<b> Min&nbsp;&nbsp;<?=$bslider['per_min']?>  <?=$bclr[$bslider['ond']]->bag_type?>&nbsp;&nbsp;</b>
									<input id="bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>"
									 
									data-slider-id='bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>Slider' 
									 
									 type="text" data-slider-min="<?=$bslider['per_min']?>" data-slider-max="<?=$item_unit?>" 
									 
									 data-slider-step="1" data-slider-value="<?=$bslider['min_price'];?>" data-slider-handle="round" 
									 
									 min-slider-handle="50"/>

									 
									<b> Max&nbsp;&nbsp;<?=$item_unit?> <?=$item_title?> </b>
								</div>
							</div>
							
						</div>
					<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="margin:10px 0;">

						<img src="<?=base_url('assets/home/images/baggage.jpg')?>" alt="Los Angeles" style="width:100%;">
        			</div>
                </div>
           </div>
      </div>

 <script>
	$(window).bind('resize load', function() {
    if ($(this).width() <= 767) {
        $('#baggage-search<?=$n?>').removeClass('in');
    } else {
        $('#baggage-search<?=$n?>').addClass('in');
    }
});
<?php
if ( $baggage_offer ) { 
foreach($cwtdata as $ond => $cwtpoints){ ?>
var cwtpoints<?=$ond?> = [];
<?php foreach($cwtpoints as $cwt){ ?>
	
	cwtpoints<?=$ond?>[<?=$cwt['cum_wt']?>] = <?=$cwt['price_per_kg']?>;
<?php } ?>
<?php } ?>
<?php } ?>
</script>               
    			   
	    
<?php $n++;}  ?>	    
            </div>  
	    </div>
<?php } ?>
</div>	    



<?php
	if ( $any_product ) { //ANY PRODUCTS EXISTS
?>
	  
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10" >
		<p class="pull-right">Total Bid Amount  <strong style="margin-left:12px;"> <i class="fa fa-dollar"></i> <b id="tot"></b></strong> </p>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
		<a data-toggle="tab" href="#offer" class="btn btn-danger  pull-right btn btn-secondary sw-btn-next" type="button" style="background:<?=$mail_header_color?>">Continue</a>
	</div>
</div>
                <div id="payment" class="">
					<div class="col-sm-12 col-md-9 ">
						<div class="col-md-2 back-btn">
							<a type="button" class="btn btn-danger btn btn-secondary sw-btn-prev" style="background:<?=$mail_header_color?>"><i class="fa fa-arrow-left" ></i> Back</a>
						</div>
						<div class="col-md-10 ">
						    <div class="col-md-12">
						        <h2 class="pull-right" style="margin:5px 0px;"><b>Booking Ref No: <?php echo $pnr_ref; ?></b></h2>
<?php
		if ( isset($resubmit) && isset($last_bid_total_value)) {
			
?>
						        
						    </div>
						    <div class="col-md-12">
						        <h2 class="pull-right" ><span style="color:#333;align:right">Status: Re-bidding:  Last Bid Total: $ <i><?=$last_bid_total_value?></i></span></h2>
<?php
		} else {
?>
						        
						    </div>
						    <div class="col-md-12">
							
							
							<h2 class="pull-right"><span style="color:#333;align:right">Status: Fresh Bidding</i></span></h2>
<?php
		}
?>                      </div>
	                    <div class="col-md-12">
							<p class="pull-right">Total Bid Amount  <strong style="margin-left:12px;"> <i class="fa fa-dollar"></i> <b id="bidtot"></b></strong></p>
						</div>
						</div>
					
						<div class="col-md-12 ">
							<div class="price-range">
								<b id="mile-min"> </b>
									<input id="miles" data-slider-id='milesSlider' type="text" data-slider-min="0" data-slider-max="<?=$upgrade[0]->miles?>" data-slider-step="5" data-slider-value="<?= $upgrade[0]->miles/2 ?>" data-slider-handle="round" min-slider-handle="200"/>
								<b id="mile-max"></b> 
							</div>
						</div>
						<div class="col-sm-12 col-md-12 payment-box">
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
									<div class="form-group card-exp col-xs-12 col-sm-12 col-lg-12">
										<div class="col-xs-6 col-sm-8 col-lg-6">
											<label for="cardExpiry">Expiry Date</label>
											<input type="number" class="form-control" name="month_expiry" id="month_expiry" placeholder="MM" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"/>
											/ <input type="number" class="form-control" name="year_expiry" id="year_expiry" placeholder="YY" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"/>
										</div>
										<div class="col-xs-6 col-sm-4 col-lg-6">
											<label for="cardCVC" >CVV</label>
											<input type="number" class="form-control " name="cvv" id="cvv" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" />
										</div>
									</div>
								
								</div>
								<div class="col-md-4 actual-cash">
								<?php if($upgrade_offer){ ?>
									<p>Upgrade Total: <strong><i class="fa fa-dollar"></i><b id="up_paid_cash"></b></strong></p>
									<!--<p>Upgrade Total Miles: <b id="up_paid_miles"></b> </p>-->
								<?php }?>
								<?php if($baggage_offer){ ?>
									<p>Baggage Total: <strong><i class="fa fa-dollar"></i> <b id="bg_paid_cash"></b></strong></p>
									<!--<p>Baggage Total Miles: <b id="bg_paid_miles"></b> </p>-->
								<?php }?>
								</div>
								<div class="col-md-4 actual-cash">
									<p>Total Cash: <strong><i class="fa fa-dollar"></i> <b id="paid_cash"></b></strong></p>
									<p>Total Miles: <b id="paid_miles"></b> </p>
									<a href="#" type="button" class="btn btn-danger" onclick="saveBid('<?=$pnr_ref?>')" style="background:<?=$mail_header_color?>">Pay Now</a>	
								</div>
								<div class="col-md-12">
									<div class="pay-info">
										<p style="color:<?=$mail_header_color?>">Your card will be saved for future usage upon BID Confirmation</p>
										<p style="color:<?=$mail_header_color?>">Bid Participation Charges  <b>(1$ Non Refundable)</b></p>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-12 col-md-3 ">
						<div class="side-video">
							<iframe src="https://www.youtube.com/embed/_O2_nTt1N6w" width="100%" height="180"></iframe>
							
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
<?php } ?>
	    <br>
	    <br>

<script>
<?php if ($upgrade_offer) {?>
<?php foreach($upgrade as $upg){  if($upg->fclr != null){ ?> 
$('#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>').slider({
	tooltip: 'always',
	formatter: function(value) {
		return '$'+numformat(value) + ' Per Person';
	}
});
<?php } } }?>

<?php if ($baggage_offer) {?>
<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?> 
	$('#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>').slider({
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
<?php } ?>
<?php } ?>

<?php
if ( $any_product ) { //ANY PRODUCTS EXISTS
?>
	function getTotal() {
		var tot_avg = 0;
		<?php foreach($upgrade as $upg){  if($upg->fclr != null){ ?>//$(this). prop("checked") == true
		
		   tot_avg = tot_avg+$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('getValue')*<?=$passengers_count?>;
		<?php } } ?>
		<?php foreach($baggage as $pax => $paxval){ $bslider = $baggage[$pax]['pax']; ?> 
			var bg_val = 0;

			if($('input[type=checkbox][name=<?=$mobile_view?>bid_bag_<?=$bslider['flight_number']?>]').prop("checked") == false){
				bg_val = $("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>").slider('getValue');
			}
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

		<?php }?>
	      return tot_avg.toFixed(2);
	}

	function mileSliderUpdate(){	  
		var value = getTotal();	  
		var miles = Math.round(value/mile_value);
		$("#mile-min").text(0+' Miles');  
		$("#mile-max").text( numformat(Math.round(Math.round(miles)* mile_proportion))+' Miles');
		$("#miles").slider('setAttribute', 'max', Math.round(Math.round(miles)* mile_proportion));	  
		$("#miles").slider('setValue',0);  
		$("#miles").slider('setAttribute', 'step', Math.round(1/mile_value)); 
	}

	$('#miles').slider({
		tooltip: 'always',
		formatter: function(value) {			
			var dollar = value * mile_value;
			var bid_amount = getTotal();
			var pay_cash = bid_amount - Math.round(dollar);
			var bg_val = 0;
			<?php if($baggage_offer) { ?>
			  <?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?>
			  var bg_val = bg_val + cwtpoints<?=$bslider['ond']?>[$("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>").slider('getValue')];
			  <?php } ?>
			   //var bg_pay_cash = (bg_val) - Math.round(dollar);;
			   var bg_pay_cash = bg_val;
			   $("#bg_paid_cash").text('$ ' + numformat(bg_pay_cash));
			   //$("#bg_paid_miles").text(numformat(value) + ' ($ '+numformat(Math.round(dollar))+')'); 		
			  <?php } ?>
			<?php if($upgrade_offer) { ?>
			   	//var up_pay_cash = (bid_amount - bg_val) - Math.round(dollar);;
			   	var up_pay_cash = bid_amount - bg_val;
				$("#up_paid_cash").text('$ ' + numformat(up_pay_cash));
				//$("#up_paid_miles").text(numformat(value) + ' ($ '+numformat(Math.round(dollar))+')'); 		
			  <?php } ?>
			$("#paid_cash").text('$ ' + numformat(pay_cash));
			$("#paid_miles").text(numformat(value) + ' ($ '+numformat(Math.round(dollar))+')'); 		
			return '$ '+numformat(pay_cash)+' + '+numformat(value) + '($ '+numformat(Math.round(dollar))+')';
		}
	});
		$('#milesSlider .slider-selection').css({"background":"#0feded"});
		$('#milesSlider .slider-handle').css({"background":"#0feded"});	
	var mile_value = <?=$mile_value?>;
	var mile_proportion = <?=$mile_proportion?>;

$(document).ready(function () {	
		tot_avg = 0;
		var total = getTotal();
		$("#tot").text('$ ' + numformat(total));
		$("#bidtot").text('$ ' + numformat(total));

	$(".bid-visible").click(function () {   
		 event.preventDefault();
	});
   		mileSliderUpdate(); 


	});




	function saveBid(pnr_ref) {	 
		var miles = $("#miles").slider('getValue');
		var tot_bid = getTotal();
		var pay_cash = tot_bid - Math.round(miles * mile_value);	
		var paysuccess = 0;
				$.ajax({
				  async: false,
				  type: 'POST',
				  url: "<?=base_url('homes/bidding/saveCardData')?>",          
					  data: {"card_number" :$('#card_number').val(),"month_expiry":$('#month_expiry').val(),"year_expiry":$('#year_expiry').val(),"cvv":$('#cvv').val(),"pnr_ref":pnr_ref,"cash":pay_cash,"miles":miles,"tot_bid":tot_bid},
				  dataType: "html",	         		  
				  success: function(data) {
					var cardinfo = jQuery.parseJSON(data);
					var orderID = cardinfo['orderID'];
					if(cardinfo['status'] == "success"){
						<?php if($baggage_offer) { ?>
							var bg_tot_value = 0;
						<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?>
							bg_tot_value_obj = $("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>");
							if ( bg_tot_value_obj ) {
								bg_tot_value = bg_tot_value + cwtpoints<?=$bslider['ond']?>[bg_tot_value_obj.slider('getValue')];
							}
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
				      <?php foreach($upgrade as $upg){  if($upg->fclr != null) { ?>
						var bid_value = $("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('getValue')*<?=$passengers_count?>;			
						var up_pay_cash = bid_value - Math.round(miles * mile_value);				
						var up_miles = miles;
						var up_tot_bid = tot_bid;
						//var up_pay_cash = pay_cash;
						var flight_number = <?=$upg->flight_number?>;				
						var upgrade = $('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$upg->flight_number?>]:checked').val().split('|');
						var upgrade_type = upgrade[0];	
						var fclr_id = upgrade[1];
						var dtpfext_id=<?=$upg->dtpfext_id?>;
						var product_id=<?=$upg->product_id?>;
						var offer_id=<?=$upg->offer_id?>;
						//var bid_action = $('input[type=radio][name=bid_action_<?=$upg->flight_number?>]:checked').val();
						if($('input[type=checkbox][name=<?=$mobile_view?>bid_action_<?=$upg->flight_number?>]').prop("checked") == false){
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
								window.location = "<?=base_url('home/paysuccess')?>/"+pnr_ref;
								paysuccess = 1;
							} else {
								//alert(info['status']);
								paysuccess = 0;
								status = status + "<p>"+info['status']+"</p>";
							}			
						  }
					   }); 
					  <?php } } ?>
					  <?php if($baggage_offer){ ?>
					       if(status != ''){
							<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?>
								var bg_weight_obj = $("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>");
								var bg_weight = 0;
								if ( bg_weight_obj ) {
									 bg_weight = bg_weight_obj.slider('getValue');
								}
								var flight_number = <?=$bslider['flight_number']?>;				
								var bg_value = cwtpoints<?=$bslider['ond']?>[bg_weight];
								var dtpfext_id=<?=$bslider['dtpfext_id']?>;
								var product_id=<?=$bslider['product_id']?>;
								var offer_id=<?=$bslider['offer_id']?>;
								$.ajax({
								async: false,
								type: 'POST',
								url: "<?=base_url('homes/bidding/saveBidData')?>",       
								data: {"ond":<?=$bslider['ond']?>,"flight_number":flight_number,"orderID":orderID,"dtpfext_id":dtpfext_id,"offer_id" :offer_id,"weight":bg_weight,"baggage_value":bg_value,"tot_cash":bg_pay_cash,"product_id":product_id,"tot_miles":bg_miles,"tot_bid":bg_tot_bid},
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
							   window.location = "<?=base_url('home/paysuccess')?>/"+pnr_ref;
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

<script>
<?php
if ( $upgrade_offer ) { 
?>
$(document).ready(function () {
<?php foreach($upgrade as $upg){  if($upg->fclr != null){    
	$flag =0;
	foreach($upg->to_cabins as $key => $value) {		 
		$split = explode('-',$key); $key = $split[0]; $status = $split[1];
		if($status == $sent_mail_status){
		$flag = 1;
		break;  
		}
	}
	$flag =1;
	$i = array_search($key, explode(',',$upg->fclr)); 
	if($flag == 1 && explode(',',$upg->min)[$i]){  ?>  
		$('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$upg->flight_number?>]').filter('[value="<?=$value.'|'.$key?>"]').attr('checked', true);
		$('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$upg->flight_number?>]:checked').trigger('change'); 
		$('#<?=$mobile_view?>bid_min_<?=$upg->flight_number?>').text(numformat(<?php echo explode(',',$upg->min)[$i]; ?>));
		$('#<?=$mobile_view?>bid_max_<?=$upg->flight_number?>').text(numformat(<?php echo explode(',',$upg->max)[$i]; ?>));

	//var tot_avg = tot_avg + <?=explode(',',$upg->avg)[$i]?>;
	updateCabinMedia(<?=$upg->flight_number?>);
	<?php } } } ?>    



<?php foreach($upgrade as $upg){  if($upg->fclr != null){ ?>
$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").on("slide", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	//console.log(tot_avg);
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
	changeColors('<?=$upg->product_id . '_' . $upg->flight_number?>');
    	mileSliderUpdate();	
});
$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").on("click", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	//console.log(tot_avg);
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
	changeColors('<?=$upg->product_id . '_' . $upg->flight_number?>');
    	mileSliderUpdate();	
});
	$('input[type=radio][name=<?=$mobile_view?>bid_cabin_<?=$upg->flight_number?>]').change(function(){
		$(this).checked = true;
		var bid_cabin = $(this).val();
		var upg = $(this).val().split('|');

		if  (upg != '') {
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('enable');
		updateCabinMedia(<?=$upg->flight_number?>);
	        $.ajax({
		  async: false,
		  type: 'POST',
		  url: "<?=base_url('homes/bidding/getFclrValues')?>",          
			  data: {"fclr_id" :upg[1]},
		  dataType: "html",			
		  success: function(data) {
			var info = jQuery.parseJSON(data);              		
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('setAttribute', 'max', Math.round(info['max']));
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('setAttribute', 'min', Math.round(info['min']));
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('setValue', Math.round(info['slider_start']));
			$("#<?=$mobile_view?>bid_max_<?=$upg->flight_number?>").text(numformat(Math.round(info['max'])));
			$("#<?=$mobile_view?>bid_min_<?=$upg->flight_number?>").text(numformat(Math.round(info['min'])));
			var tot_avg = getTotal();
			$("#tot").text(numformat(tot_avg));
			$("#bidtot").text(numformat(tot_avg));			
			mileSliderUpdate();
			changeColors('<?=$upg->product_id . '_' . $upg->flight_number?>');
  		}
		});
		} else {
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('setAttribute', 'min',0);
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('setValue',0);
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('disable');
			var tot_avg = getTotal();
			$("#tot").text(numformat(tot_avg));
			$("#bidtot").text(numformat(tot_avg));			
			mileSliderUpdate();
		}
 
	});
<?php } } ?>
	changeColors('<?=$upg->product_id . '_' . $upg->flight_number?>');
	});

<?php } ?>
</script>

<script>
<?php
if ( $baggage_offer ) { 

?>
//baggage slider jquery
	$(document).ready(function () {
<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; ?> 

		$('#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>Slider .slider-selection').css({"background":"<?=$mail_header_color?>"});
    		$('#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>Slider .slider-handle').css({"background":"<?=$mail_header_color?>"});
		$('input[type=checkbox][name=<?=$mobile_view?>bid_bag_<?=$bslider['flight_number']?>]').change(function(){
			var total = getTotal();
			$("#tot").text(numformat(total));
			$("#bidtot").text(numformat(total));
		});
		$('input[type=checkbox][name=<?=$mobile_view?>bid_bag_<?=$bslider['flight_number']?>]:checked').trigger('change'); 


$("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>").on("slide", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
   	 mileSliderUpdate();	
});

$("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>").on("click", function(slideEvt) { 
	//var tot_avg = getTotal();
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	$("#tot").text(numformat(tot_avg));
	$("#bidtot").text(numformat(tot_avg));	 
    	mileSliderUpdate();	
});
<?php } ?>

	//action click
	$('input[type=checkbox][name=<?=$mobile_view?>baggage_action_<?=$bslider['flight_number']?>]').click(function(){	
		 if($(this). prop("checked") == true){
		   $('.cabins-'+<?=$bslider['flight_number']?>).addClass('bid-visible');
		  
		   $("#<?=$mobile_view?>bid_slider_<?=$bslider['product_id']?>_<?=$bslider['flight_number']?>").slider('disable'); 
		 } else {
		    $('.cabins-'+<?=$bslider['flight_number']?>).removeClass('bid-visible');
		   $("#<?=$mobile_view?>bid_slider_<?=$bslider['flight_number']?>").slider('enable');  
		 }
		var tot_avg = getTotal();
		$("#tot").text(numformat(tot_avg));
		$("#bidtot").text(numformat(tot_avg));
		mileSliderUpdate();
	});

	});
<?php }} ?>
</script>
