<?php 
?> 
<div class="off-elg">
	<h2 class="title-tool-bar">Advanced Bids Report</h2>
	<div class="col-md-12 off-elg-filter-box">
	   <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
	     <div class="form-group"><br>	   		
			<div class="col-md-2">			
			<?php $list = array("0" => "Select Carrier");               
               foreach($airlines as $airline){
				 $list[$airline->vx_aln_data_defnsID] = $airline->code;	
			   }				
			   echo form_dropdown("filter_airlineID", $list,set_value("filter_airlineID",$airlineID), "id='filter_airlineID' class='form-control hide-dropdown-icon select2'"); ?>	
			</div>
			<div class="col-md-4">
				<fieldset>
					<legend>To Date</legend>
					<div class="col-md-6">
			<?php $ylist = array("0" => "Select To Year"); 
			    $current_year = date('Y');              
               		    for($i=0;$i<10;$i++){
				 $ylist[$current_year+$i] = $current_year+$i;	
			   }				
			   echo form_dropdown("filter_year_to", $ylist,set_value("filter_year_to",$year), "id='filter_year_to' class='form-control hide-dropdown-icon select2'"); ?>	 
			</div>
			<div class="col-md-6">
				<select name="filter_to_month" id="filter_to_month" class="form-control hide-dropdown-icon select2" >  				
				</select>
					</div>
				</fieldset>
			</div>
                    <div class="col-sm-2">
			<?php
			$products['0'] = 'Product Type';
                            ksort($products);
			echo form_dropdown("product_id", $products,set_value("product_id",$product_id), "id='product_id' class='form-control hide-dropdown-icon select2'");    ?>
			</div>
			<div class="col-md-2 pull-right">
				<button type="submit" class="form-control btn btn-danger">Report</button>				
			</div>
		  </div>
	   </form>
	</div>
<div class="col-md-12 report-box">
	<div style="color:#f26522"><h3><strong><bold>Advanced Bid <?=$products[$product_id]?> Report for <?= $airlineID ? $list[$airlineID] : " all Carriers" ;?> <?=$this->data['to_date'] ?  "upto &nbsp;" . date('m-d-Y', $this->data['to_date']) : "" ; ?></bold></strong></h3></div>
	 <div class="row">		
		<div class="col-md-3">
		  <h3><b>Accepted Bids</b></h3>
		</div>
		<div class="col-md-7" style="padding:0;">
		  <h3><b>Bid Volume</b></h3>
		</div>
		<div class="col-md-2">
		  <h3><b>Confirmed Revenue</b></h3>
		</div>
	  </div>
	 <div class="row">
	 <div class="col-md-12" style="border-left:solid 1px #ddd;text-align:center;">			
			<div>
				<div class="col-md-3">
				<div style="margin-bottom: 4em;" id="progress-<?=$bid_accepted?>"  class="pie-title-center" data-percent="<?=number_format(round($bid_average))?>" style="height: 180px; width: 100%;">
					<b><a onclick="progressReport(<?=$bid_accepted?>?>,<?=$bid_received?>)">
					<span style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="<?=number_format($bid_accepted)?>" class="pie-value"></span>
					</a>
					<p>Accepted Bids</p>
					</b>
					</div>
				</div> 

				<div class="col-md-7">
				<div id="bid-volume-chart" style="height: 370px; width: 100%;"></div>
				</div>  

				<div class="col-md-2">
				<div class="upgrade-revenue-price-box">$<?=number_format($bid_revenue)?> </div>


				</div>  
			</div>
		</div>
		</div>
		<div class="row">		
		<div class="col-md-3">
		  <h3><b>Total Bids</b></h3>
		</div>
		<div class="col-md-7" style="padding:0;">
		  <h3><b>Bid Revenue</b></h3>
		</div>
		<div class="col-md-2">
		  <h3><b>Confirmed Bids</b></h3>
		</div>
	  </div>
		<div class="row">
	 <div class="col-md-12" style="border-left:solid 1px #ddd;text-align:center;">			
			<div>
				<div class="col-md-3">
				
				<?php $total_bids = $bid_received; $icon = 'up'; $color = "#0c9e0c";?>
				
				<div class="upgrade-revenue-price-box" ><?=number_format($total_bids)?> </div>
				
				</div>    
			</div>
			<div>
				<div class="col-md-7">
				<div id="bid-revenue-chart" style="height: 370px; width: 100%;"></div>
				</div>  
			</div>    
			<div>
				<div class="col-md-2">
				<?php 
				$total = $bid_accepted;
				?>
				<div class="upgrade-revenue-price-box"><?=number_format($total)?> </div>
				</div>  
			</div>
		</div>
		</div>
	 </div>
</div>

<script src="<?=base_url('assets/chartjs/canvasjs.min.js')?>"></script>
<script src="<?=base_url('assets/chartjs/pie-chart.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/inilabs/jquery.redirect.js'); ?>"></script>
<script>

			$('#progress-<?=$bid_accepted?>').pieChart({
                barColor: '#5499C7',
                trackColor: '#eee',
                lineCap: 'round',
				lineWidth: 15,
				size: 120,
				rotate: 0,
				animate: { 
				   duration: 1000,
				   enabled:true
				},				
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


</script>
<script>
window.onload = function () {
 
var bvchart = new CanvasJS.Chart("bid-volume-chart", {
	title: {
		text: "Bid Volume"
	},
	axisY: {
		title: "Bid Volume"
	},
	data: [{
		dataPoints: <?php echo json_encode($bid_volume_data, JSON_NUMERIC_CHECK); ?>
	}]
});
bvchart.render();
 
var brchart = new CanvasJS.Chart("bid-revenue-chart", {
	title: {
		text: "Bid Revenue"
	},
	axisY: {
		title: "Bid Revenue"
	},
	data: [{
		dataPoints: <?php echo json_encode($bid_revenue_data, JSON_NUMERIC_CHECK); ?>
	}]
});
brchart.render();
}
$(document).ready(function(){
	$('#filter_year_to').val(<?=$to_year?>).trigger('change');	
	$('#filter_to_month').val(<?=$to_month?>).trigger('change');	
});

$('#filter_year_to').change(function(){
	var year = <?=date('Y')?>;
	var month = <?=date('m')?>;
	if(year == $(this).val()){		
		start_month = month-1; 
	} else {
		start_month = 0;
	}
   	end_month = 11;
	var html = '',value=0;
	var from_selected = '';
	var to_selected = '';
	var to_html = "<option value='0'>To Month</option>";
	for(var i=start_month;i<=end_month;i++){
		value = i+1;
		to_selected = ('<?=$to_month?>'==value)?'selected':'';		
		to_html += '<option value="'+value+'" '+to_selected+'>'+new Date($(this).val(),i).toLocaleString("default", { month: "long" })+'</option>';
	}	
	
	
	$('#filter_to_month').html(to_html);	
});
</script>

