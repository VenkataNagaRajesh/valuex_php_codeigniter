
<?php $colors = array('#E7823A','#546BC1','#6dad92','#e65b82','#65d8d8','#babd0b'); ?>
<div class="row">
	<div class="col-md-2" style="margin-top:20px">
	<?php $i = 1;foreach($upgrade_cabins as $cab){
	  $cabs = explode('-',$cab['name']);
	  $cab_name = strtolower($cabs[0].$cabs[1]); 
	  if(!empty($$cab_name['report']) && !empty($$cab_name['accept_revenue'])){ ?>
	  <div>
	  	<h4 style="background:#ff6633;color:#ddd;"><?=$$cab_name['title']?></h4>
		<span>Revenue : <?=round($$cab_name['accept_revenue'])?></span><br>
		<span>Passengers : <?=$$cab_name['passengers']?></span><br>
		<span>AVG Bid : <?=round($$cab_name['avg_bid'])?></span><br>
		<span>Rejected Revenue : <?=$$cab_name['reject_revenue']?></span><br>
		<span>LDF where Bid Rejected : 80%</span><br>
      </div>
	  <?php  } $i++; } ?>
	</div>
	<div class="col-md-6">
		<div id="revenuechart" style="height: 250px; width: 100%;margin-top:20px"></div>
		<div id="revenuemonthlychart" style="height: 250px; width: 100%;margin-top:20px"></div>
	</div>
	<div class="col-md-4">
	<?php foreach($upgrade_cabins as $cab){
	  $cabs = explode('-',$cab['name']);
	  $cab_name = strtolower($cabs[0].$cabs[1]);	 
         if(!empty($$cab_name['report']) && !empty($$cab_name['accept_revenue'])){ ?>
		<div id="progress-<?=$cab_name?>"  class="pie-title-center" data-percent="<?=round(($$cab_name['accept_revenue']/$total_accept_revenue)*100)?>" style="height: 250px; width: 100%;margin-top:20px">
			<span class="pie-value"></span>
			<p><?=$$cab_name['title']?></p>
		</div>	
		 <?php } } ?>	
	</div>
</div>
<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->
<script src="<?=base_url('assets/chartjs/canvasjs.min.js')?>"></script>
<script src="<?=base_url('assets/chartjs/pie-chart.js')?>"></script>
<script>
window.onload = function () {

/*----------------------------Revenue Chart By Cabin Combinations ------------------------*/
var totalRevenue = <?=$total_accept_revenue?>;

 var points =[];
  <?php $i = 1;foreach($upgrade_cabins as $cab){
	  $cabs = explode('-',$cab['name']);
	  $cab_name = strtolower($cabs[0].$cabs[1]);	 
         if(!empty($$cab_name['report']) && !empty($$cab_name['accept_revenue'])){ ?>
		obj = {x: <?=$i*10?>, y: <?=$$cab_name['accept_revenue']?>, name: "<?=$$cab_name['title']?>", color: "<?=$colors[$i-1]?>"};			
		points.push(obj);  			
	<?php	}
	$i++; } ?>
 
var revenueData = {
	"revenue_cabins": [{
		click: visitorsChartDrilldownHandler,
		cursor: "pointer",
		explodeOnClick: false,
		innerRadius: "75%",
		legendMarkerType: "square",
		name: "New vs Returning Visitors",
		radius: "100%",
		showInLegend: true,
		startAngle: 90,
		type: "doughnut",
		indexLabelFontSize: 12,
		
		indexLabel: "{name} - #percent%",
		/*dataPoints: [
			{ x: 10, y: 23, name: "First", color: "#E7823A" },
			{ x: 20, y: 18, name: "Second", color: "#546BC1" },
			{ x: 30, y: 17, name: "Third", color: "#6dad92" },
			{ x: 40, y: 41, name: "Fourth", color: "#e65b82" }
		]*/
		dataPoints:points
	}]	
};

var revenueChartOptions = {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "Revenue chart"
	},
	/*subtitles: [{
		text: "Click on Any Segment to Drilldown",
		backgroundColor: "#2eacd1",
		fontSize: 16,
		fontColor: "white",
		padding: 5
	}], 
	legend: {
		fontFamily: "calibri",
		fontSize: 14,
		itemTextFormatter: function (e) {
			return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalRevenue * 100) + "%";  
		}
	}, */
	data: []
	
};


function visitorsChartDrilldownHandler(e) {
	console.log(e);
	//alert("sss");
//	window.location.href= "<?=base_url('airline')?>";	
}


var revenuechart = new CanvasJS.Chart("revenuechart", revenueChartOptions);
revenuechart.options.data = revenueData["revenue_cabins"];
revenuechart.render();


/*---------------------------- Monthly Revenue Chart ------------------------*/
var d = new Date(2020,1).toLocaleString('default', { month: 'long' });
//var month = d.getMonth();
console.log(d);
var revenueMonthlyChartOptions = {
	animationEnabled: true,
		title:{
			text: "Monthly Revenue Chart",
			fontFamily: "arial black",
			fontColor: "#695A42"
		},
		axisX: {
			interval: 1,
			intervalType: "month"
		},
		axisY:{
			valueFormatString:"$#0",
			//interval: 5,
			gridColor: "#B6B1A8",
			tickColor: "#B6B1A8"
		},
		toolTip: {
			shared: true,
			content: toolTipContent
		},
		data: [{
		type: "stackedColumn",
		showInLegend: true,
		color: "#696661",
		name: "Current Year", //new Date(2020,4).toLocaleString('default', { month: 'long' })
		dataPoints: [
			{ y: 6.75, label: new Date(2020,0).toLocaleString("default", { month: "long" }) },
			{ y: 6.75, label: new Date(2020,1).toLocaleString("default", { month: "long" }) },
			{ y: 8.57, label: new Date(2020,2).toLocaleString("default", { month: "long" }) },
			{ y: 10.64, label: new Date(2020,3).toLocaleString("default", { month: "long" }) },
			{ y: 13.97, label: new Date(2020,4).toLocaleString("default", { month: "long" }) },
			{ y: 15.42, label: new Date(2020,5).toLocaleString("default", { month: "long" }) },
			{ y: 17.26, label: new Date(2020,6).toLocaleString("default", { month: "long" }) },
			{ y: 20.26, label: new Date(2020,7).toLocaleString("default", { month: "long" }) },
			{ y: 10.64, label: new Date(2020,8).toLocaleString("default", { month: "long" }) },
			{ y: 13.97, label: new Date(2020,9).toLocaleString("default", { month: "long" }) },
			{ y: 15.42, label: new Date(2020,10).toLocaleString("default", { month: "long" }) },
			{ y: 17.26, label: new Date(2020,11).toLocaleString("default", { month: "long" }) }
		]
		},
		{        
			type: "stackedColumn",
			showInLegend: true,
			name: "Previous Year",
			color: "#EDCA93",
			dataPoints: [
				{ y: 6.82, label: new Date(2020,0).toLocaleString("default", { month: "long" }) },
				{ y: 6.82, label: new Date(2020,1).toLocaleString("default", { month: "long" }) },
				{ y: 9.02, label: new Date(2020,2).toLocaleString("default", { month: "long" }) },
				{ y: 11.80, label: new Date(2020,3).toLocaleString("default", { month: "long" }) },
				{ y: 14.11, label: new Date(2020,4).toLocaleString("default", { month: "long" }) },
				{ y: 15.96, label: new Date(2020,5).toLocaleString("default", { month: "long" }) },
				{ y: 17.73, label: new Date(2020,6).toLocaleString("default", { month: "long" }) },
				{ y: 21.5, label: new Date(2020,7).toLocaleString("default", { month: "long" }) },
				{ y: 11.80, label: new Date(2020,8).toLocaleString("default", { month: "long" }) },
				{ y: 14.11, label: new Date(2020,9).toLocaleString("default", { month: "long" }) },
				{ y: 15.96, label: new Date(2020,10).toLocaleString("default", { month: "long" }) },
				{ y: 17.73, label: new Date(2020,11).toLocaleString("default", { month: "long" }) }			]
		}]
   };

var visitorsDrilldownedChartOptions = {
	animationEnabled: true,
	theme: "light2",
	axisX: {
		labelFontColor: "#717171",
		lineColor: "#a2a2a2",
		tickColor: "#a2a2a2"
	},
	axisY: {
		gridThickness: 0,
		includeZero: false,
		labelFontColor: "#717171",
		lineColor: "#a2a2a2",
		tickColor: "#a2a2a2",
		lineThickness: 1
	},
	data: []
};


var revenuemonthlychart = new CanvasJS.Chart("revenuemonthlychart", revenueMonthlyChartOptions);
//revenuemonthlychart.options.data = revenueMonthlyData["revenue_monthly_data"];
revenuemonthlychart.render();


function toolTipContent(e) {
	//console.log(e);
	var str = "";
	var total = 0;
	var str2, str3;
	for (var i = 0; i < e.entries.length; i++){
		var  str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + "\"> "+e.entries[i].dataSeries.name+"</span>: $<strong>"+e.entries[i].dataPoint.y+"</strong><br/>";
		total = e.entries[i].dataPoint.y + total;
		str = str.concat(str1);
	}
	str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.x)+"</strong></span><br/>";
	total = Math.round(total * 100) / 100;
	str3 = "<span style = \"color:Tomato\">Total:</span><strong> $"+total+"</strong><br/>";
	str3 = ""; 
	return (str2.concat(str)).concat(str3);
}
}

/* --------------Progress Chart ------------------------*/

<?php $i = 1;foreach($upgrade_cabins as $cab){
	  $cabs = explode('-',$cab['name']);
	  $cab_name = strtolower($cabs[0].$cabs[1]);	 
        if(!empty($$cab_name['report']) && !empty($$cab_name['accept_revenue'])){ ?>
			$('#progress-<?=$cab_name?>').pieChart({
                barColor: '<?=$colors[$i-1]?>',
                trackColor: '#eee',
                lineCap: 'round',
				lineWidth: 8,
				size: 80,
				rotate: 0,
				animate: { 
				   duration: 1000,
				   enabled:true
				},				
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});
		<?php  } $i++; } ?>

</script>


