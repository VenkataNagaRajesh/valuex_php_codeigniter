<script>
window.onload = function () {

var totalVisitors = 883000;
var visitorsData = {
	"New vs Returning Visitors": [{
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
		indexLabelFontSize: 17,
		
		indexLabel: "{name} - #percent%",
		dataPoints: [
			{ x: 10, y: 71, name: "First", color: "#E7823A" },
			{ x: 20, y: 55, name: "Second", color: "#546BC1" },
			{ x: 30, y: 50, name: "Third", color: "#6dad92" },
			{ x: 40, y: 125, name: "Fourth", color: "#e65b82" }
		]
	}]	
};

var newVSReturningVisitorsOptions = {
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
			return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalVisitors * 100) + "%";  
		}
	},*/
	data: []
	
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

var chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
chart.options.data = visitorsData["New vs Returning Visitors"];
chart.render();

function visitorsChartDrilldownHandler(e) {
	console.log(e);
	//alert("sss");
	window.location.href= "<?=base_url('airline')?>";	
}
}
</script>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
