<div class="box">
        <div class="box-header" style="width:100%;">
                <h3 class="box-title"><i class="fa fa-users"></i>CWT graph</h3>
                <ol class="breadcrumb">
                        <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('menu_dashboard') ?></a></li>
                        <li><a href="<?= base_url("bclr/index") ?>">Back</a></li>
                        <li class="active">cwt graph-1</li>
                </ol>
        </div>
        <div class="col-md-12">
	<?php if ($no_of_passengers) { ?>
                <div class="col-md-10">
                        <br /><!-- Just so that JSFiddle's Result label doesn't overlap the Chart -->
                        <div id="interactive-chart" style="height: 360px; width: 100%;"></div>
                         <div class="chartWrapper" style="height: 380px; width: 600px;position:relative;">
                        <div class="chartAreaWrapper">
                                <div id="interactive-chart" style="height: 360px; width: 100%;"></div>
                        </div>
                        <canvas id="overlayedAxis"></canvas>
                        </div>
                </div>
                <div class="col-md-2">
                        <input type="text" name="graph_name" placeholder="Enter Unique Name" id="graph_name" value="<?= $cwt_name ?>" />
                        <button class="btn btn-danger" enabled="enabled">Edit Graph</button>
                </div>
	<?php } else {?>
		<?php echo "<h2>Data might be wrong!. Can not generate graph. Please re-check BCRL Rule</h2>"; ?>
	<?php } ?>
        </div>
</div>

		<div class='table col-md-12'>
		<h3>Graph Calculation Details chart:</h3>
			<table border='1' style="background:white;">
				<tbody>
					<tr>
						<td>No of Passengers: </td><td><?= $no_of_passengers ?></td>
					</tr>
					<tr>
						<td>Total Revenue: </td><td><?= $total_revenue ?></td>
					</tr>
					<tr>
						<td>Total Weight: </td><td><?= $total_weight ?></td>
					</tr>
					<tr>
						<td>Average Weight: </td><td><?= $average_weight ?></td>
					</tr>
					<tr>
						<td>Average Price: </td><td><?= $average_price ?></td>
					</tr>
					<tr>
						<td>Total Flight Count: </td><td><?= $total_flight_count ?></td>
					</tr>
					<tr>
						<td>Total Pax Count: </td><td><?= $total_pax_count ?></td>
					</tr>
					<tr>
						<td>Last Year Average Price Per Kg: </td><td><?= $last_year_average_price_per_kg ?></td>
					</tr>
					<tr>
						<td>No of Pax Per Flight: </td><td><?= $no_of_pax_per_flight ?></td>
					</tr>
					<tr>
						<td>Last Year  Total Weight Per Flight: </td><td><?= $last_year_total_weight_per_flight ?></td>
					</tr>
					<tr>
						<td>Last Year  Total Revenue Per Flight: </td><td><?= $last_year_revenue_per_flight ?></td>
					</tr>
					<tr>
						<td>Average Weight Per Flight Per Pax: </td><td><?= $average_weight_per_flight_per_pax ?></td>
					</tr>
					<tr>
						<td>Average Price Per Flight Per Pax: </td><td><?= $average_price_per_flight_per_pax ?></td>
					</tr>
					<tr>
						<td>Min Weight: </td><td><?= $min_weight ?></td>
					</tr>
					<tr>
						<td>Max Weight: </td><td><?= $max_weight ?></td>
					</tr>
					<tr>
						<td>Min Price: </td><td><?= $min_price ?></td>
					</tr>
					<tr>
						<td>Max Price: </td><td><?= $max_price ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/chartjs/canvasjs.min.js') ?>"></script>
<script>
	var pointsdata = [];

	<?php foreach ($points as $key => $value) { ?>
		cobj = {
			x: <?= $key ?>,
			y: <?= $value ?>
		};
		pointsdata.push(cobj);
	<?php  } ?>

	
	var interactiveChart = new CanvasJS.Chart("interactive-chart", 
	{
		animationEnabled: true,
		exportEnabled: true,
		theme: "light2",
		zoomEnabled: true,
		zoomType: "X",
		width: 1000,
		height:500,
		title:{
			text: "Baggage Unit Price Setting",
			fontSize: 20,
			padding: 5,
			backgroundColor: "#f4d5a6",
		},
		axisX:{
			title: "Weight Capacity",
			titleFontColor: "#4F81BC",
			minimum: "1",
			maximum: "<?= count($points) + 20 ?>",
		},
		axisY:[{
			title: "Price per KG",
			minimum: "<?= $min_weight?>",
			maximum: "<?= $max_weight?>",
			titleFontColor: "#4F81BC",
		},
		],
		axisY2:[{
			title: "Revenue $",
			minimum:  "1",
			maximum: "<?= $last_year_revenue_per_flight+100  ?>",
			titleFontColor: "#C0504E",
		},
		],

	data: [
		{
			type: "line",
			showInLegend: true,
			//axisYIndex: 0, //Defaults to Zero
			name: "Price per KG",
			xValueFormatString: "####",
			cursor: "move",
			color: "#1bbde2",
			markerType: "circle",
			dataPoints: pointsdata
		},
		{
			type: "line",
			showInLegend: true,
			// axisYIndex: 1, //Defaults to Zero
			name: "Last Year Average Revenue Per Flight",
			xValueFormatString: "####",
			markerType: "circle",
			cursor: "move",
			color: "#ff6633",
			axisYType: "secondary",
			// dataPoints: historic_data
			dataPoints: [
				{ x: <?= $min_weight ?>, y: <?= $last_year_revenue_per_flight ?>  },
				{ x: <?= $max_weight ?>, y: <?= $last_year_revenue_per_flight ?>  }
			]
		},
		{
			type: "line",
			showInLegend: true,                  
			axisYType: "secondary",
			cursor: "move",
			color: "#808080",
			//axisYIndex: 0, //Defaults to Zero
			name: "Projected Revenue Per Flight",
			xValueFormatString: "####",
			yValueFormatString: "$##0.00",
			markerType: "circle",
			dataPoints: [
				{ x: 5, y: 450  },
				{ x: 50, y: 450  }
			]
		},
		{
			type: "spline",
			showInLegend: true, 
			name: "Last Year Average",               	
			xValueFormatString: "####",
			cursor: "move",
			color: "red",
			dataPoints: [ 
				{ x: <?= $last_year_total_weight_per_flight ?>, y: <?= $last_year_average_price_per_kg ?>  }
			]
		}
		]
	});
	/* 
			copyAxis("interactive-chart", "overlayedAxis");

	function copyAxis(containerId, destId){
	  var chartCanvas = $("#interactive-chart .canvasjs-chart-canvas").get(0);  
	  var destCtx = $("#" + destId).get(0).getContext("2d");
	  
	  var axisWidth = 30;
	  var axisHeight = 335;
	  
	  destCtx.canvas.width = axisWidth;
	  destCtx.canvas.height = axisHeight;

	  destCtx.drawImage(chartCanvas, 0, 0, axisWidth, axisHeight, 0, 0, axisWidth, axisHeight);
	} */


	 interactiveChart.render();
	// var record = false;
	// var snapDistance = 5;
	// var xValue, yValue, parentOffset, relX, relY;
	// var selected;
	// var newData = false;
	// var timerId = null;
	// $("#interactive-chart .canvasjs-chart-canvas").last().on({
	// 	mousedown: function(e) {
	// 		parentOffset = jQuery(this).parent().offset();
	// 		relX = e.pageX - parentOffset.left;
	// 		relY = e.pageY - parentOffset.top;
	// 		xValue = Math.round(interactiveChart.axisX[0].convertPixelToValue(relX));
	// 		yValue = Math.round(interactiveChart.axisY[0].convertPixelToValue(relY));
	// 		var dps = interactiveChart.data[0].dataPoints;
	// 		for (var i = 0; i < dps.length; i++) {
	// 			if ((xValue >= dps[i].x - snapDistance && xValue <= dps[i].x + snapDistance) &&
	// 				(yValue >= dps[i].y - snapDistance && yValue <= dps[i].y + snapDistance)) {
	// 				record = true;
	// 				selected = i;
	// 				break;
	// 			} else {
	// 				selected = null;
	// 			}
	// 		}
	// 		newData = (selected === null) ? true : false;
	// 		if (newData) {
	// 			interactiveChart.data[0].addTo("dataPoints", {
	// 				x: xValue,
	// 				y: yValue
	// 			});
	// 			interactiveChart.axisX[0].set("maximum", Math.max(interactiveChart.axisX[0].maximum, xValue + 30));
	// 			//interactiveChart.render();
	// 		}
	// 	},

	// 	mousemove: function(e) {
	// 		if (record && !newData) {
	// 			parentOffset = jQuery(this).parent().offset();
	// 			relX = e.pageX - parentOffset.left;
	// 			relY = e.pageY - parentOffset.top;
	// 			xValue = Math.round(interactiveChart.axisX[0].convertPixelToValue(relX));
	// 			yValue = Math.round(interactiveChart.axisY[0].convertPixelToValue(relY));
	// 			clearTimeout(timerId);
	// 			timerId = setTimeout(function() {
	// 				if (selected !== null) {
	// 					interactiveChart.data[0].dataPoints[selected].x = xValue;
	// 					interactiveChart.data[0].dataPoints[selected].y = yValue;
	// 					interactiveChart.render();
	// 				}
	// 			}, 0);
	// 		}
	// 	},
	// 	mouseup: function(e) {
	// 		if (selected !== null) {
	// 			interactiveChart.data[0].dataPoints[selected].x = xValue;
	// 			interactiveChart.data[0].dataPoints[selected].y = yValue;
	// 			interactiveChart.render();
	// 			record = false;
	// 		}
	// 	}
	// });



	//	 function getChartValues() {
	//	var graph_name = $('#graph_name').val();
	// 	if (graph_name == '' || graph_name == null) {
	//		alert("Enter graph Name");
	// 	} else {
	// 		var data = interactiveChart.get("data");
	// 		//console.log(data[0].dataPoints);
	// 		$.ajax({
	// 			async: false,
	// 			type: 'POST',
	// 			url: "<?= base_url('bclr/updatecwtgraph') ?>",
	// 			data: {
	// 				"bclr_id": <?= $bclr_id ?>,
	// 				"graph_name": graph_name,
	// 				"points": data[0].dataPoints
	//			},
	// 			dataType: "html",
	// 			success: function(data) {
	// 				var obj = jQuery.parseJSON(data);
	// 				if (obj.status === "updated") {
	// 					window.location.reload(true);
	// 				} else {
	// 					alert(obj.status);
	// 				}
	// 			}
	// 		});
	// 	}
	// }
</script>
