<div class="off-elg">
	<h2 class="title-tool-bar">Upgrade Report</h2>
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
		    <div class="col-md-2">
			<?php $ylist = array("0" => "Select Year"); 
			    $current_year = date('Y');              
               for($i=0;$i<10;$i++){
				 $ylist[$current_year-$i] = $current_year-$i;	
			   }				
			   echo form_dropdown("filter_year", $ylist,set_value("filter_year",$year), "id='filter_year' class='form-control hide-dropdown-icon select2'"); ?>	 
			</div>
			<div class="col-md-2">
				<select name="filter_from_month" id="filter_from_month" class="form-control hide-dropdown-icon select2">				
				</select>
			</div>
			<div class="col-md-2">
				<select name="filter_to_month" id="filter_to_month" class="form-control hide-dropdown-icon select2" >  				
				</select>
			</div>
			<div class="col-md-2">
			<?php $types = array("1" => "Departure Report","2" =>"Sales Report"); 			   				
			   echo form_dropdown("filter_type", $types,set_value("filter_type",$type), "id='filter_type' class='form-control hide-dropdown-icon select2'"); ?>	 
			</div>	
			<div class="col-md-2">
				<button type="submit" class="form-control btn btn-danger">Report</button>				
			</div>
		  </div>
	   </form>
	</div>
<div class="col-md-12 report-box">
	<?php if(count($current_report) > 0 || count($report) > 0){ ?><div style="color:#f26522"><h3><strong><bold>Upgrade Report &nbsp;<?php echo $this->data['from_date']; ?>&nbsp; to &nbsp;<?php echo $this->data['to_date']; ?></bold></strong></h3></div>
	<?php } ?>
	 <div class="row">		
		<div class="col-md-3">
		  <h3><b>Upgrades</b></h3>
		</div>
		<div class="col-md-4" style="padding:0;">
		  <h3><b>Revenue</b></h3>
		</div>
		<div class="col-md-5">
		  <h3><b>Acceptance Rate</b></h3>
		</div>
	  </div>
	 <div class="row">
	<?php if(count($current_report) > 0 || count($report) > 0){
		 $colors = array('#E7823A','#546BC1','#6dad92','#e65b82','#65d8d8','#babd0b'); ?>		
		<div class="col-md-3" style="border-right:solid 1px #ddd;">
			<!--<h4> Total Revenue : $<?=$total_accept_revenue?></h4> -->				
			<?php $i = 1;foreach($upgrade_cabins as $cab){
			$cabs = explode('-',$cab['name']);
			$cab_name = strtolower($cabs[0].$cabs[1]); 
			if(!empty($$cab_name['report']) && !empty($$cab_name['accept_revenue'])){
				if(round($$cab_name['accept_revenue']) >= round($$cab_name['pre_accept_revenue'])){
					$icon = 'up'; $color = "#0c9e0c";
				} else {
				$icon = 'down'; $color = "#ea2708"; } ?>
			<div class="report-data">
				<h4 class="report-cabin-header"><?=$$cab_name['title']?></h4>
				<p><span>Revenue :</span><b onclick="progressReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)"><?="$".round($$cab_name['accept_revenue'])?></b><i class="fa fa-caret-<?=$icon?> pull-right" onclick="progressReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)" style="color:<?=$color?>;" aria-hidden="true"></i></p>
				<p><span>Passengers : </span> <b onclick="progressReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)" ><?=$$cab_name['passengers']?></b><i class="fa fa-caret-<?=$icon?> pull-right"  onclick="progressReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)" style="color:<?=$color?>;" aria-hidden="true"></i></p>
				<p><span>AVG Bid : </span><b onclick="progressReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)" ><?="$".round($$cab_name['avg_bid'])?></b><i class="fa fa-caret-<?=$icon?> pull-right" onclick="progressReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)" style="color:<?=$color?>;" aria-hidden="true"></i></p>
				<p><span>Rejected Revenue :</span> <b onclick="rejectReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)"><?="$".$$cab_name['reject_revenue']?></b><i class="fa fa-caret-<?=$icon?> pull-right" onclick="rejectReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)" style="color:<?=$color?>;" aria-hidden="true"></i></p>
				<p><span>LDF where Bid Rejected :</span><b> <?=$$cab_name['ldf']?>%</b></p>
			</div><?php  } $i++; } ?>
		</div>
		<div class="col-md-4">
		    <div class="revenue-box">
				<div class="upgrade-revenue-price-box">$<?=$total_accept_revenue?> </div>
				<div class="upgrade-revenue-box">Upgrade Revenue</div>
			</div>
			<div id="revenuechart" style="height: 250px; width: 100%;margin-top: 9px" ></div>					
			<div id="revenuemonthlychart" style="height: 250px; width: 100%;margin-top: 9px"></div>
			<div id="report" style="margin: 10px;">
				<button class="btn btn-danger" onclick="yearlyReport(1)" >Current year</button>
				<button class="btn btn-danger" style="float: right;" onclick="yearlyReport(2)">Previous Year</button>
			</div>
		</div>
		<div class="col-md-5" style="border-left:solid 1px #ddd;text-align:center;">			
			<div>
			<?php $i = 1; foreach($upgrade_cabins as $cab){
			$cabs = explode('-',$cab['name']);
			$cab_name = strtolower($cabs[0].$cabs[1]);
			if(!empty($$cab_name['report']) && !empty($$cab_name['accept_revenue'])){ ?>		 
				<div class="col-md-6">
					<div id="progress-<?=$cab_name?>"  class="pie-title-center" data-percent="<?=round(($$cab_name['accept_revenue']/$total_accept_revenue)*100)?>" style="height: 180px; width: 100%;">
						<a onclick="progressReport(<?=$$cab_name['from_cabin_id']?>,<?=$$cab_name['to_cabin_id']?>)">
							<span style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="<?=number_format($$cab_name['accept_revenue'])?>" class="pie-value"></span>
						</a>
						<p><?=$$cab_name['title']?></p>
					</div>	
				</div>       			
			<?php $i++; } } ?>
			</div>
						
		</div>
		</div>
	  <?php } else { ?>
		  <div style="height:500px;" class="col-md-12"> <h3 style="text-align: center;">No Report Data</h3></div>
	 <?php } ?>	
	 </div>
	<form id="reportform" action="<?=base_url('offer_table')?>" style="display:none;" method="post" target='_blank'>
		<input type="hidden" name="from_date" id="from_date" value="">
		<input type="hidden" name="to_date" id="to_date" value="">
		<input type="hidden" name="from_cabin" id="from_cabin" value="">
		<input type="hidden" name="to_cabin" id="to_cabin" value="">
		<input type="hidden" name="carrier" id="carrier" value="">
		<input type="hidden" name="type" id="type" value="">
		<input type="hidden" name="offer_status" id="offer_status" value="">
		<input type="hidden" name="month" id="month" value="">
		<input type="hidden" name="year" id="year" value="">
		<input type="submit" value="Submit">
	</form>	
</div>
<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->
<script src="<?=base_url('assets/chartjs/canvasjs.min.js')?>"></script>
<script src="<?=base_url('assets/chartjs/pie-chart.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/inilabs/jquery.redirect.js'); ?>"></script>
<script>
$(document).ready(function(){
	$('#filter_year').val(<?=$year?>).trigger('change');	
	$('#filter_from_month').val(<?=$from_month?>).trigger('change');	
	$('#filter_to_month').val(<?=$to_month?>).trigger('change');	
	$('#filter_type').val(<?=$type?>).trigger('change');	
});

function yearlyReport(type){	
	  if(type == 1){
		 var from_date = "<?=$from_date?>";
		 var to_date = "<?=$to_date?>";
	  } else {
		var from_date = "<?=date('Y-m-d', strtotime('-1 year', strtotime($from_date)))?>";
		var to_date = "<?=date('Y-m-d', strtotime('-1 year', strtotime($to_date)))?>";
	  }
	 
	   $('#carrier').val(<?=$airlineID?>);
	   $('#month').val();
	   $('#year').val();
	   $('#type').val('<?=$type?>');
	   $('#offer_status').val(<?=$bid_accepted?>);
	   $('#from_cabin').val('');
	   $('#to_cabin').val('');
	   $('#from_date').val(from_date);
	   $('#to_date').val(to_date);
	   $('#reportform').submit();
}

function progressReport(from_cabin,to_cabin) {	
		$('#carrier').val('<?=$airlineID?>');
		$('#from_cabin').val(from_cabin);
		$('#to_cabin').val(to_cabin);
		$('#from_date').val('<?=$from_date?>');
		$('#to_date').val('<?=$to_date?>');
		$('#type').val( '<?=$type?>');
		$('#offer_status').val(<?=$bid_accepted?>);
		$('#month').val('');
		$('#year').val('');
	 $("#reportform").submit();	
}

function rejectReport(from_cabin,to_cabin) {	
		$('#carrier').val('<?=$airlineID?>');
		$('#from_cabin').val(from_cabin);
		$('#to_cabin').val(to_cabin);
		$('#from_date').val('<?=$from_date?>');
		$('#to_date').val('<?=$to_date?>');
		$('#type').val( '<?=$type?>');
		$('#offer_status').val(<?=$bid_rejected?>);
		$('#month').val('');
		$('#year').val('');
	 $("#reportform").submit();	
}

$('.select2').select2();

$('#filter_year').change(function(){
	var year = <?=date('Y')?>;
	if(year == $(this).val()){		
		end_month = new Date().getMonth();
	} else {
    	end_month = 11;
	}
	end_month = 11;
	var html = '',value=0;
	var from_selected = '';
	var to_selected = '';
	var from_html = "<option value='0'>From Month</option>";
	var to_html = "<option value='0'>To Month</option>";
	for(var i=0;i<=end_month;i++){
		value = i+1;
		from_selected = (<?=$from_month?>==value)?'selected':'';
		to_selected = (<?=$to_month?>==value)?'selected':'';		
		from_html += '<option value="'+value+'" '+from_selected+' >'+new Date($(this).val(),i).toLocaleString("default", { month: "long" })+'</option>';
		to_html += '<option value="'+value+'" '+to_selected+'>'+new Date($(this).val(),i).toLocaleString("default", { month: "long" })+'</option>';
	}	
	
	
	$('#filter_from_month').html(from_html);
	$('#filter_to_month').html(to_html);	
});

window.onload = function () {

/*----------------------------Revenue Chart By Cabin Combinations ------------------------*/
var totalRevenue = <?=$total_accept_revenue?>;

 var points =[];
  <?php $i = 1;foreach($upgrade_cabins as $cab){
	  $cabs = explode('-',$cab['name']);
	  $cab_name = strtolower($cabs[0].$cabs[1]);	 
         if(!empty($$cab_name['report']) && !empty($$cab_name['accept_revenue'])){ ?>
		obj = {x: <?=$i*10?>, y: <?=$$cab_name['accept_revenue']?>, name: "<?=$$cab_name['title']?>",from_cabin:"<?=$$cab_name['from_cabin_id']?>",to_cabin:"<?=$$cab_name['to_cabin_id']?>", color: "<?=$colors[$i-1]?>"};			
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
		name: "Revenue",
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
		text: ""
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
		$('#carrier').val('<?=$airlineID?>');
		$('#from_cabin').val(e.dataPoint.from_cabin);
		$('#to_cabin').val(e.dataPoint.to_cabin);
		$('#from_date').val('<?=$from_date?>');
		$('#to_date').val('<?=$to_date?>');
		$('#type').val( '<?=$type?>');
		$('#offer_status').val(<?=$bid_accepted?>);
		$('#month').val('');
		$('#year').val('');
	 $("#reportform").submit();
	//getReport(e.dataPoint.from_cabin,e.dataPoint.to_cabin,<?=$bid_accepted?>);
}

function getReport(from_cabin,to_cabin,status){
	$.redirect('<?=base_url('offer_table')?>', {
		'carrier':'<?=$airlineID?>',
		'from_cabin': from_cabin,
		'to_cabin': to_cabin,
		'from_date':'<?=$from_date?>',
		'to_date':'<?=$to_date?>',
		'type': '<?=$type?>',
		'offer_status':status
	});
}

var revenuechart = new CanvasJS.Chart("revenuechart", revenueChartOptions);
revenuechart.options.data = revenueData["revenue_cabins"];
revenuechart.render();


/*---------------------------- Monthly Revenue Chart ------------------------*/
var d = new Date(2020,1).toLocaleString('default', { month: 'long' });
//var month = d.getMonth();
console.log(d);

var currentdata = [];
	<?php  foreach($current as $key => $value){ ?>
		  cobj = {y: <?=$value?>, label:"<?=$key?>"};
		  currentdata.push(cobj);
	<?php  } ?>

	var previousdata = [];
	<?php  foreach($previous as $key => $value){ ?>
		  pobj = {y: <?=$value?>, label:"<?=$key?>"};
		  console.log(<?=$value?>);
		  previousdata.push(pobj);
	<?php  } ?>
	
  //console.log(previousdata);

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
		click: monthlyReport,
		showInLegend: true,
		color: "#71c58f",
		name: "Current Year", //new Date(2020,4).toLocaleString('default', { month: 'long' })
		/*dataPoints: [
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
		]*/
		dataPoints : currentdata	
		},
		{        
			type: "stackedColumn",
			click: monthlyReport,
			showInLegend: true,
			name: "Previous Year",
			color: "#e2a22d",			
			dataPoints:previousdata
			/*dataPoints: [
				{ y: 6.82, label: new Date(2020,0).toLocaleString("default", { month: "long" }) },
				{ y: 6.82, label: new Date(2020,1).toLocaleString("default", { month: "long" }) },
				{ y: 9.02, label: new Date(2020,2).toLocaleString("default", { month: "long" }) },
				{ y: 11.80, label: new Date(2020,3).toLocaleString("default", { month: "long" }) },
				{ y: 10, label: new Date(2020,4).toLocaleString("default", { month: "long" }) },
				{ y: 15.96, label: new Date(2020,5).toLocaleString("default", { month: "long" }) },
				{ y: 17.73, label: new Date(2020,6).toLocaleString("default", { month: "long" }) },
				{ y: 21.5, label: new Date(2020,7).toLocaleString("default", { month: "long" }) },
				{ y: 11.80, label: new Date(2020,8).toLocaleString("default", { month: "long" }) },
				{ y: 14.11, label: new Date(2020,9).toLocaleString("default", { month: "long" }) },
				{ y: 15.96, label: new Date(2020,10).toLocaleString("default", { month: "long" }) },
				{ y: 17.73, label: new Date(2020,11).toLocaleString("default", { month: "long" }) }			
			   ] */
		}
	  ]
   };

   function monthlyReport(e){
	   $('#carrier').val(<?=$airlineID?>);
	   $('#month').val(e.dataPoint.label);
	   $('#year').val($("#filter_year").val());
	   $('#type').val( '<?=$type?>');
	   $('#offer_status').val(<?=$bid_accepted?>);
	   $('#from_cabin').val('');
	   $('#to_cabin').val('');
	   $('#from_date').val('');
	   $('#to_date').val('');
	   $('#reportform').submit();
	  /* $.redirect('<?=base_url('offer_table')?>', {
		'carrier':'<?=$airlineID?>',		
		'month':e.dataPoint.label,
		'year':$("#year").val(),
		'type': '<?=$type?>',
		'offer_status':<?=$bid_accepted?>
		});*/
   }

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
		var  str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + "\"> "+e.entries[i].dataSeries.name+"</span>: $<strong>"+numformat(e.entries[i].dataPoint.y)+"</strong><br/>";
		total = e.entries[i].dataPoint.y + total;
		str = str.concat(str1);
	}
	str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.x)+"</strong></span><br/>";
	total = Math.round(total * 100) / 100;
	str3 = "<span style = \"color:Tomato\">Total:</span><strong> $"+total+"</strong><br/>";
	str3 = ""; 
	return (str2.concat(str)).concat(str3);
}

function numformat(n){
	return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
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


