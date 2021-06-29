<style>
    /*09-02-2021 style sheet*/
.side-video {
    width: 100%;
    float: left;
}
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
.lst-box li{width:100%; margin:0px 10px; padding:0px;}
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
    
  .lst-box li{width:auto; margin: 0px 10px 0 0 !important; padding: 0 10px !important; }
  .bid-tab li{padding:0px;}
#offer .price-range{padding:20px 15px 0px 15px ;}
  .payment-box .card-exp input{width:60px;}
  .price-range .slider-horizontal {
    width: 65% !important;
}
  .sub-tbl-bar h2{font-size:18px;line-height: 22px;}
.payment-box{margin-bottom:30px;}


}
@media (min-width: 320px) and (max-width: 479px) {
    
  .lst-box li{width:auto; margin: 0px 10px 0 0 !important; padding: 0 10px !important; }
  .bid-tab li{padding:0px;}
  .payment-box .card-exp input{width:55px;}
  .sub-tbl-bar h2{font-size:18px;line-height: 22px;}
.payment-box{margin-bottom:30px;}
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
<input type='hidden' name='total_bid_value' id='total_bid_value' value='0'>
<input type='hidden' name='paid_cash' id='paid_cash' value='0'>
<input type='hidden' name='paid_miles_cash' id='paid_miles_cash' value='0'>
<input type='hidden' name='paid_miles_miles' id='paid_miles_miles' value='0'>
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
<input type='hidden' name='total_upg_value' id='total_upg_value' value='0'>
<input type='hidden' name='upg_charges_cash' id='upg_charges_cash' value='0'>
<input type='hidden' name='upg_charges_miles' id='upg_charges_miles' value='0'>
<input type='hidden' name='upg_charges_miles_cash' id='upg_charges_miles_cash' value='0'>
					<div class="col-sm-12 top-tbl-bar" >
    					   <div class="col-xs-7 col-sm-5 col-lg-6"><h2>Flight Information</h2></div>
    					   <div class="col-xs-5 col-sm-6 col-lg-6" ><h2>Bid Amount</h2></div>
					</div>
 <div class="col-sm-12 sub-tbl-bar">
<?php
		if ( isset($bid_id_1) && $bid_id_1 > 0) {
			
?>
		<span class="col-sm-11" style='float:left'><h2>Upgrade Offer:
			&nbsp;&nbsp;Status: Re-bidding,
			&nbsp;Last Bid Total: $ <i><?=$last_bid_value_1?></i>
			</h2></span>
        		<span class="col-sm-1"  style="float:right;color:#333;align:right"><a href='#' onclick="if ( confirm('Are you sure that you like to cancel the bid ?')) window.location='<?=base_url('homes/cancel/page/?pnr_ref='. $pnr_ref. '&offer_id=' . $offer_id_1 . '&type=1')?>';" type="button" class="btn btn-danger" >Cancel Bid</a></span>
<?php
		} else {
?>
			<span class="col-xs-12  col-sm-12" style='float:left'><h2>Upgrade Offer:
			&nbsp;&nbsp;Status: Fresh Bidding
			</h2></span>
			</span>
<?php
		}
?>                   
</div>
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
                        <div class="col-xs-12 col-sm-12"><b style="color:#000; float:left">Upgrade To</b></div>
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
								<span style="float:left;width:70px !important;"><b>Min: $</b> <i class="fa fa-dollar"></i> <b id="bid_min_<?=$upg->flight_number?>"></b></span>
									<input id="bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>" data-slider-id='bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>Slider' type="text" data-slider-min="<?php echo explode(',',$upg->min)[$i]; ?>" data-slider-max="<?php echo explode(',',$upg->max)[$i]; ?>" data-slider-step="1" data-slider-value="<?php echo explode(',',$upg->slider_position)[$i]; ?>" data-slider-handle="round"min-slider-handle="200"/>
								<span style="float:right"><b>Max: $</b> <i class="fa fa-dollar"></i> <b id="bid_max_<?=$upg->flight_number?>"></b></span>
<?php
			if ( $upg->bid_id ) {
?>
				<br><span style="float:left;"><b>Last Bid Value: $</b> <i class="fa fa-dollar"><?=$upg->bid_value?></i></span>
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
	$('#total_upg_value').change(function(){
		$("#total_upg_value_view").text($('#total_upg_value').val());
	});
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
<input type='hidden' name='total_bg_value' id='total_bg_value' value='0'>
<input type='hidden' name='bg_charges_cash' id='bg_charges_cash' value='0'>
<input type='hidden' name='bg_charges_miles' id='bg_charges_miles' value='0'>
<input type='hidden' name='bg_charges_miles_cash' id='bg_charges_miles_cash' value='0'>
<div class="clear"></div>


<div class="col-sm-12 top-tbl-bar" >
   <div class="col-xs-7 col-sm-5 col-lg-6"><h2>Flight Information</h2></div>
   <div class="col-xs-5 col-sm-6 col-lg-6" ><h2>Bid Amount</h2></div>
</div>
 <div class="col-sm-12 sub-tbl-bar">
<?php
		if ( isset($bid_id_2) && $bid_id_2 > 0) {
			
?>
		<span class="col-sm-12" style='float:left'><h2>Baggage Offer: 
			&nbsp;&nbsp;Status: Re-purchasing,
			&nbsp;Last purchased extra baggage weight: <i><?=$last_weight_value_2?></i> KG
			,&nbsp;Payed Cash: $ <i><?=$last_bid_value_2?></i>
			</h2></span>
<?php
		} else {
?>
			<span class="col-xs-12  col-sm-12" style='float:left'><h2>Baggage Offer:
			</h2></span>
			</span>
<?php
		}
?>             
</div>
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
									<li style="color:<?=$mail_header_color?>"><?php echo $bslider['airline_id'].$bslider['flight_number'];?></li>
								</ul>
								<small><?php echo substr($bslider['from_airport'],0,25) . ".."; ?></small>                       
                            </div>

                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <p style="color:<?=$mail_header_color?>"><?php echo $bslider['to_city_name']; ?> <span class="time-bid"><?=date('H:i A',$bslider['arrival_date']+$bslider['arrival_time']);?></span></p>
								<ul>
									<li><?php echo date('d M Y',$bslider['arrival_date']); ?></li>
									<li style="color:<?=$mail_header_color?>"><?php echo $bslider['airline_id'].$bslider['flight_number'];?></li>
								</ul>
								<small><?php echo substr($bslider['to_airport'],0,25) . ".."; ?></small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2 lft-gap">
                        <div class="col-sm-12">
							<?php if ( !$bslider['reason'] ) {
							?>
    						<label class="checkbox-inline">
								<input type="checkbox" name="bid_bag_<?=$bslider['ond']?>" id="bid_bag_<?=$bslider['ond']?>" value="" >Check this box if not Interested
							</label>
							<?php } ?>
                        
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 lft-gap">
							<?php if ( $bslider['reason'] ) {
							?>
							<br><span style="background-color:yellow"><?=$bslider['reason']?></span>
							<?php } else {  ?>
                       
						<?php if($bclr[$bslider['ond']]->bag_type==2){ //PC 
							$item_title = 'PC';
							$item_unit = $bslider['per_max'];
						} else {
							$item_title = 'KG';
							$item_unit = $bslider['per_max'];
						}
						?>	
							<div id="slider">
								<div class="price-range col-md-12">	
									<span style="float:left;width:70px !important;"><b>Min: <?=$bslider['per_min']?>  <?=$item_title?></b></span>
									<input id="bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>"
									 
									data-slider-id='bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>Slider' 
									 
									 type="text" data-slider-min="<?=$bslider['per_min']?>" data-slider-max="<?=$item_unit?>" 
									 
									 data-slider-step="1" data-slider-value="<?=$bslider['min_price'];?>" data-slider-handle="round" 
									 
									 min-slider-handle="50"/>

									<span><nobr><b>Max: <?=$item_unit?>  <?=$item_title?></b></nobr></span>
								</div>
							</div>
							
							<?php } ?>
						</div>
					<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="margin:10px 0;">

						<img src="<?=base_url('assets/home/images/baggage.jpg')?>" alt="Los Angeles" style="width:100%;">
        			</div>
                </div>
           </div>
      </div>

 <script>
	$('#total_bg_value').change(function(){
		$("#total_bg_value_view").text($('#total_bg_value').val());
	});
	$(window).bind('resize load', function() {
    if ($(this).width() <= 767) {
        $('#baggage-search<?=$n?>').removeClass('in');
    } else {
        $('#baggage-search<?=$n?>').addClass('in');
    }
});
<?php
if ( $baggage_offer ) { 
foreach($cwtdata as $ond => $cwtpoints){  ?>
var cwtpoints<?=$ond?> = [];
<?php foreach($cwtpoints as $key => $value){ ?>

	
	cwtpoints<?=$ond?>[<?=$key?>] = <?=$value?>;
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
		<p class="pull-right">Total Bid Amount: $<strong style="margin-left:12px;"><i class="fa fa-dollar"></i><b id="total_bid_value_view1"></b></strong></p>
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
						</div>
						    <div class="col-md-12">
							<p class="pull-right">Total Bid Amount: $<strong style="margin-left:12px;"><i class="fa fa-dollar"></i><b id="total_bid_value_view2"></b></strong></p>
							</div>
<?php
		if ( isset($last_bid_total_value) && $last_bid_total_value > 0) {
?>
						    <div class="col-md-12">
							<p class="pull-right">Last Bid Total Value <strong style="margin-left:12px;"> <i class="fa fa-dollar">$ <?=$last_bid_total_value?></i></b></strong></p>
							</div>
<?
		}
?>
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
										<div class="col-xs-8 col-sm-8 col-lg-6">
											<label for="cardExpiry">Expiry Date</label>
											<input type="number" class="form-control" name="month_expiry" id="month_expiry" placeholder="MM" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"/>
											/ <input type="number" class="form-control" name="year_expiry" id="year_expiry" placeholder="YY" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"/>
										</div>
										<div class="col-xs-4 col-sm-4 col-lg-6">
											<label for="cardCVC" >CVV</label>
											<input type="number" class="form-control " name="cvv" id="cvv" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" />
										</div>
										
										
										
									</div>
									<div class="col-md-12">
									<div class="pay-info">
										<p style="color:<?=$mail_header_color?>">Your card will be saved for future usage upon BID Confirmation</p>
										<p style="color:<?=$mail_header_color?>">Bid Participation Charges  <b>(1$ Non Refundable)</b></p>
									</div>
								</div>
								</div>`
								<div class="col-md-4">
								<div class="actual-cash">
								<?php if($upgrade_offer){ ?>
									<p>Upgrade Total: <strong><i class="fa fa-dollar"></i>$ <b id="total_upg_value_view"></b></strong></p>
								<?php }?>
								<?php if($baggage_offer){ ?>
									<p>Baggage Total: <strong><i class="fa fa-dollar"></i>$ <b id="total_bg_value_view"></b></strong></p>
								<?php }?>
								</div>
								<div class="actual-cash">
								<?php if($upgrade_offer && $baggage_offer){ ?>
									<p>Upgrade Charges: <strong><i class="fa fa-dollar"></i>$ <b id="total_upg_charges_view"></b></strong></p>
									<p>Baggage Charges: <strong><i class="fa fa-dollar"></i>$ <b id="total_bg_charges_view"></b></strong></p>
								<?php }?>
								</div>
								<div class="actual-cash">
									<p>Total Cash: <strong><i class="fa fa-dollar"></i>$ <b id="paid_cash_view"></b></strong></p>
									<p>Miles Cash: <strong><i class="fa fa-dollar"></i>$ <b id="paid_miles_view"></b></strong></p>
									<a href="#" type="button" class="btn btn-danger" onclick="saveBid('<?=$pnr_ref?>')" style="background:<?=$mail_header_color?>">Pay Now</a>	
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
		$("#total_bid_value_view2").text($("#total_bid_value_view1").text());
		return '$'+numformat(value) + ' Per Person';
	}
});
<?php } } }?>

<?php if ($baggage_offer) {?>
function calcBaggageValue(slider_value_kg, soldout_kg, ond) {
		select_bg_val = 0;
			var scale = eval('cwtpoints' + ond);
			for ( i = 1; i <= slider_value_kg;i++) {
					select_bg_val = select_bg_val + scale[i];
				}
	//return select_bg_val;
	return parseFloat(select_bg_val).toFixed(2);
		//WORKI
}

<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; if ( $bslider['reason'] ) { continue;}  ?> 
	$('#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>').slider({
	tooltip: 'always',
	formatter: function(value) {
			select_bg_val = calcBaggageValue(value,<?=$bslider['per_min']?>,<?=$bslider['ond']?>);
		return value + ' <?=($bclr[$bslider['ond']]->bag_type == 2 ? 'PC' : 'KG')?>' + ' = $'+ select_bg_val;
	}
	});
<?php } ?>
<?php } ?>

<?php
if ( $any_product ) { //ANY PRODUCTS EXISTS
?>
	var mile_value = <?=$mile_value?>;
	var mile_proportion = <?=$mile_proportion?>;
	function getTotal() {
		var total_upg = 0;
		var total_value = 0;
		var tmp_upg = 0;
		var tmp_wt = 0;
		<?php foreach($upgrade as $upg){  if($upg->fclr != null){ ?>//$(this). prop("checked") == true
		
		   total_upg += parseFloat($("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('getValue')*<?=$passengers_count?>);
		<?php } } ?>
		var total_bg = 0;
		var tmp_bg = 0;
		<?php foreach($baggage as $pax => $paxval){ $bslider = $baggage[$pax]['pax']; if ( $bslider['reason'] ) { continue;} ?> 

			if($('input[type=checkbox][name=<?=$mobile_view?>bid_bag_<?=$bslider['ond']?>]').prop("checked") == false){
				bg_val = parseFloat($("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>").slider('getValue'));
				total_bg = parseFloat(total_bg) + calcBaggageValue(bg_val,<?=$bslider['per_min']?>,<?=$bslider['ond']?>);
			}
		<?php }?>
<?php if ($upgrade_offer) {?>
		tmp_upg = total_upg.toFixed(2);
		total_value += tmp_upg;
		$("#total_upg_value").val(Math.round(tmp_upg)).trigger('change');
		$("#total_bid_value").val(Math.round(total_value)).trigger('change');
<?php }?>
<?php if ($baggage_offer) {?>
		tmp_bg = total_bg;
		total_value = parseFloat(total_value) + parseFloat(tmp_bg);
		$("#total_bg_value").val(Math.round(tmp_bg)).trigger('change');
		$("#total_bid_value").val(Math.round(total_value)).trigger('change');
<?php }?>
		mileSliderUpdate();
	      return $("#total_bid_value").val();
	}

	function mileSliderUpdate(){	  
		var bidvalue = $("#total_bid_value").val();
		var cash_miles_allowed_value = bidvalue*mile_proportion; 
		var miles = Math.round(cash_miles_allowed_value/mile_value);
		$("#mile-min").text(0+' Miles');  
		$("#mile-max").text(numformat(miles)+' Miles');
		$("#miles").slider('setAttribute', 'max', miles);	  
		$("#miles").slider('setValue',0);  
		$("#miles").slider('setAttribute', 'step', 1/mile_value); 
	}

	$('#miles').slider({
		tooltip: 'always',
		formatter: function(value) {			
			var mile_cash_value = value * mile_value;
			var bidvalue = $("#total_bid_value").val();
			var pay_cash = Math.round(bidvalue - mile_cash_value);
			$("#paid_cash").val(Math.round(pay_cash));
			$("#paid_cash_view").text(numformat(Math.round(pay_cash)));
			$("#paid_miles_cash").val(Math.round(mile_cash_value));
			$("#paid_miles_miles").val(Math.round(value)); 		
			$("#paid_miles_view").text(numformat(Math.round(mile_cash_value)) + ' (' + numformat(Math.round(value)) + ' Miles)'); 		
			<?php if($upgrade_offer && $baggage_offer){ ?>
				var t_cash_miles_allowed_value = mile_cash_value;
				var t_bg_val = $("#total_bg_value").val();
				var t_upg_val = $("#total_upg_value").val();
				if ( pay_cash <= t_bg_val ) {
					t_bg_charges_cash= pay_cash;
					t_bg_charges_miles_cash= t_bg_val - t_bg_charges_cash;
				} else {
					t_bg_charges_cash=  t_bg_val;
					t_bg_charges_miles_cash= t_bg_val - t_bg_charges_cash;
				}
				t_upg_charges_miles_cash= t_cash_miles_allowed_value - t_bg_charges_miles_cash;
				t_upg_charges_cash= bidvalue - t_bg_val - t_upg_charges_miles_cash ; 


				$("#bg_charges_cash").val(Math.round(t_bg_charges_cash));
				$("#bg_charges_miles").val(Math.round(t_bg_charges_miles_cash/mile_value));
				$("#bg_charges_miles_cash").val(Math.round(t_bg_val-t_bg_charges_cash));

				$("#upg_charges_cash").val(Math.round(t_upg_charges_cash));
				$("#upg_charges_miles").val(Math.round(t_upg_charges_miles_cash/mile_value));
				$("#upg_charges_miles_cash").val(Math.round(t_upg_charges_miles_cash));

				$("#total_bg_charges_view").text('BG CASH=' + $("#bg_charges_cash").val() + ', BG MILES CASH=' + $("#bg_charges_miles_cash").val() + ' Miles=' + $("#bg_charges_miles").val());
				$("#total_upg_charges_view").text('UPG CASH=' + $("#upg_charges_cash").val() + ', UPG MILES CASH=' + $("#upg_charges_miles_cash").val() + ' Miles=' + $("#upg_charges_miles").val());
			<?php } elseif ($upgrade_offer) {
?>
				$("#upg_charges_cash").val(Math.round(pay_cash));
				$("#upg_charges_miles").val(Math.round(value));
				$("#upg_charges_miles_cash").val(Math.round(mile_cash_value));
<?php
			      } elseif ($baggage_offer) {
?>
				$("#bg_charges_cash").val(Math.round(pay_cash));
				$("#bg_charges_miles").val(Math.round(value));
				$("#bg_charges_miles_cash").val(Math.round(mile_cash_value));
<?php
			      }
			 ?>
			return 'Cash $ '+numformat(pay_cash)+ ' + Miles ' + numformat(Math.round(value)) + ' ($ '+numformat(Math.round(mile_cash_value))+')';
		}
	});
	$('#milesSlider .slider-selection').css({"background":"#0feded"});
	$('#milesSlider .slider-handle').css({"background":"#0feded"});	

$(document).ready(function () {	
	var total = getTotal();

	$(".bid-visible").click(function () {   
		 event.preventDefault();
	});
});

	var clickonce  = 0;
	function saveBid(pnr_ref) {	 
		if ( clickonce ) {
			alert("Please wait, we are processing your request!");
			return;
		}
		clickonce = 1;
		var miles = $("#paid_miles_miles").val(); 
		var cash_miles =  $("#paid_miles_cash").val();
		var pay_cash =  $("#paid_cash").val();
		var tot_bid = $("#total_bid_value").val();
		var paysuccess = 0;
		var pnr_ref='<?=$pnr_ref?>';
		$.ajax({
		  async: false,
		  type: 'POST',
		  url: "<?=base_url('homes/bidding/saveCardData')?>",          
			  data: {"card_number" :$('#card_number').val(),"month_expiry":$('#month_expiry').val(),"year_expiry":$('#year_expiry').val(),"cvv":$('#cvv').val(),"pnr_ref":pnr_ref,"cash":pay_cash,"miles":miles,"tot_bid":tot_bid,"cash_miles":cash_miles},
		  dataType: "html",	         		  
		  success: function(data) {
			var cardinfo = jQuery.parseJSON(data);
			var orderID = cardinfo['orderID'];
			if(cardinfo['status'] == "success"){
<?php   
if ($upgrade_offer) {// 1 - UPGRADE PRODUCT ?>
			var product_id = 1;
			var offer_id=<?=$offer_id_1?>;
			var pnr_ref='<?=$pnr_ref?>';
			var amount = Math.round($("#total_upg_value").val());
			var cash = $("#upg_charges_cash").val();
			var cash_miles = $("#upg_charges_miles_cash").val();
			if ( cash > 0 || cash_miles > 0) { 
			var miles = $("#upg_charges_miles").val();
			 $.ajax({
			  async: false,
			  type: 'POST',
			  url: "<?=base_url('homes/bidding/saveOfferData')?>",          
			  data: {"pnr_ref":pnr_ref,"order_id":orderID,"offer_id" :offer_id,"amount":amount,"cash":cash,"cash_miles":cash_miles,'product_id':product_id,"miles":miles},
			  dataType: "html",			
			  success: function(data) {
				var info = jQuery.parseJSON(data);              		
				if(info['status'] == "success"){
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
						var bid_id=<?=intval($upg->bid_id)?>;
						 $.ajax({
						  async: false,
						  type: 'POST',
						  url: "<?=base_url('homes/bidding/saveBidData')?>",          
						  data: {"orderID":orderID,"offer_id" :offer_id,"bid_value":bid_value,"flight_number":flight_number,"upgrade_type":upgrade_type,'product_id':product_id,"tot_cash":up_pay_cash,"dtpfext_id":dtpfext_id,"tot_miles":up_miles,"tot_bid":up_tot_bid,"bid_id":bid_id},
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
					  <?php }} ?>
					paysuccess = 1;
				} else {
					//alert(info['status']);
					paysuccess = 0;
					status = status + "<p>"+info['status']+"</p>";
				}			
			}
		});
		}
<?php } ?>
<?php if($baggage_offer){ ?>
			var product_id = 2;
			var cash = $("#bg_charges_cash").val();
			var cash_miles = $("#bg_charges_miles_cash").val();
			if ( cash > 0 || cash_miles > 0) { 
			var offer_id=<?=$offer_id_2?>;
			var pnr_ref='<?=$pnr_ref?>';
			var amount = Math.round($("#total_bg_value").val());
			var miles = $("#bg_charges_miles").val();
			 $.ajax({
			  async: false,
			  type: 'POST',
			  url: "<?=base_url('homes/bidding/saveOfferData')?>",          
			  data: {"pnr_ref":pnr_ref,"order_id":orderID,"offer_id" :offer_id,"amount":amount,"cash":cash,"cash_miles":cash_miles,'product_id':product_id,"miles":miles},
			  dataType: "html",			
			  success: function(data) {
				var info = jQuery.parseJSON(data);              		
				if(info['status'] == "success"){
					<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax']; if ( $bslider['reason'] ) { continue;}  ?>
						var bg_weight_obj = $("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>");
						var bg_weight = 0;
						if ( bg_weight_obj ) {
							 bg_weight = bg_weight_obj.slider('getValue');
						}
						var bg_value = calcBaggageValue(bg_weight,<?=$bslider['per_min']?>,<?=$bslider['ond']?>);
						var flight_number = <?=$bslider['flight_number']?>;				
						var dtpfext_id=<?=$bslider['dtpfext_id']?>;
						var product_id=<?=$bslider['product_id']?>;
						var offer_id=<?=$bslider['offer_id']?>;
						var bid_id=<?=intval($blsider['bid_id'])?>;
						$.ajax({
								async: false,
								type: 'POST',
								url: "<?=base_url('homes/bidding/saveBidData')?>",       
								data: {"ond":<?=$bslider['ond']?>,"orderID":orderID,"dtpfext_id":dtpfext_id,"offer_id" :offer_id,"weight":bg_weight,"baggage_value":bg_value,"tot_cash":cash,"product_id":product_id,"tot_miles":miles,"tot_bid":amount, "bid_id":bid_id},
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
					paysuccess = 1;
					} else {
						paysuccess = 0;
						status = status + "<p>"+info['status']+"</p>";
					}
				}
     		}); 
		}
<?php } ?>
				paysuccess = 1;
			} else {
				paysuccess = 0;
				status = "<p>"+cardinfo['status']+"</p>";
			}
			}
    		}); 

		if(paysuccess == 1){
			   window.location = "<?=base_url('home/paysuccess')?>/"+pnr_ref;
		} else {
		   alert($(status).text());
		}
 	} 
 
	 function toggleIcon(e) {
		$(e.target)
		    .prev('.panel-heading')
		    .find(".short-full")
		    .toggleClass('glyphicon-plus glyphicon-minus');
	 }
	 $('.panel-group').on('hidden.bs.collapse', toggleIcon);
	 $('.panel-group').on('shown.bs.collapse', toggleIcon);

	$('#total_bid_value').change(function(){
		$("#total_bid_value_view1").text($('#total_bid_value').val());
		$("#total_bid_value_view2").text($('#total_bid_value').val());
	});

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
$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>Slider").on("slide", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	changeColors('<?=$upg->product_id . '_' . $upg->flight_number?>');
});
$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>Slider").on("click", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	changeColors('<?=$upg->product_id . '_' . $upg->flight_number?>');
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
			changeColors('<?=$upg->product_id . '_' . $upg->flight_number?>');
  		}
		});
		} else {
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('setAttribute', 'min',0);
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('setValue',0);
			$("#<?=$mobile_view?>bid_slider_<?=$upg->product_id?>_<?=$upg->flight_number?>").slider('disable');
			var tot_avg = getTotal();
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
<?php foreach($baggage as $pax => $paxval){ $bslider =$baggage[$pax]['pax'];  if ( $bslider['reason'] ) { continue;} ?> 

		$('#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>Slider .slider-selection').css({"background":"<?=$mail_header_color?>"});
    		$('#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>Slider .slider-handle').css({"background":"<?=$mail_header_color?>"});
		$('input[type=checkbox][name=<?=$mobile_view?>bid_bag_<?=$bslider['ond']?>]').change(function(){
			var total = getTotal();
		});
		$('input[type=checkbox][name=<?=$mobile_view?>bid_bag_<?=$bslider['ond']?>]:checked').trigger('change'); 


$("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>Slider").on("slide", function(slideEvt) {
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
});

$("#bid_slider_<?=$bslider['product_id']?>_<?=$bslider['ond']?>Slider").on("click", function(slideEvt) { 
	//var tot_avg = getTotal();
	var tot_avg = getTotal().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
});

<?php } ?>
	});
<?php }} ?>
</script>
