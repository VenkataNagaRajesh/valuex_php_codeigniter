<?php 
$a = array( 
	array("label"=>"Bid Received", "y"=>$bidsrecevied),
	array("label"=>"Bid Accepted", "y"=>$bidsaccept)
);


$dataPoints = array(
	array("y" => 25, "label" => "Sunday"),
	array("y" => 15, "label" => "Monday"),
	array("y" => 25, "label" => "Tuesday"),
	array("y" => 5, "label" => "Wednesday"),
	array("y" => 10, "label" => "Thursday"),
	array("y" => 0, "label" => "Friday"),
	array("y" => 20, "label" => "Saturday")
);

?> 
<div class="off-elg">
	<h2 class="title-tool-bar">Advanced Bids Report</h2>
<div class="col-md-12 report-box">
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
				<div style="margin-bottom: 4em;" id="progress-<?=$bidsaccept?>"  class="pie-title-center" data-percent="<?=round(($bidsaccept/$bidsrecevied)*100)?>" style="height: 180px; width: 100%;">
						<b><a onclick="progressReport(<?=$bidsaccept?>?>,<?=$bidsrecevied?>)">
							<span style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="<?=number_format($bidsaccept)?>" class="pie-value"></span>
						</a>
						<p>Accepted Bids</p>
						</b>
					</div>

				</div> 

				<div class="col-md-7">
				<div id="chartContainer" style="height: 370px; width: 100%;"></div>


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
				
				<?php $total_bids = $bidsaccept+$bidsrecevied; ?>
				
				<div class="upgrade-revenue-price-box"><?=number_format($total_bids)?> </div>
				
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

			$('#progress-<?=$bidsaccept?>').pieChart({
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
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Bid Volume"
	},
	axisY: {
		title: "Bid Volume"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

