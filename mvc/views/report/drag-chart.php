<div class="off-elg" style="margin-bottom:320px;">
	<h2 class="title-tool-bar">Upgrade Report</h2>
    <div class="col-md-12" > 
        <div class="col-md-6">
           <br/><!-- Just so that JSFiddle's Result label doesn't overlap the Chart -->
           <div id="interactive-chart" style="height: 360px; width: 100%;"></div>
        </div>       
    </div>
</div>
<script src="<?=base_url('assets/chartjs/canvasjs.min.js')?>"></script>  
<script>
		var interactiveChart = new CanvasJS.Chart("interactive-chart", {
			animationEnabled: true,
			theme: "light2",
			title: {
				text: "Try dragging Data Points to reposition them"
			},
			subtitles: [{
				text: "Click anywhere on plotarea to add new Data Points"
			}],
			axisX: {
				minimum: 0,
				maximum: 120
			},
            axisY: {
		        title: "Closing Price (in USD)"
            },
			data: [
			{
				//markerSize: 12,
				type: "area", //spline,line,area
				cursor: "move",
                color: "#55cea7",
               // xValueFormatString: "DD MMM",
		       // yValueFormatString: "$##0.00",
                //lineDashType: "dash",
                showInLegend: true,
                name: "Unique Visit",
                markerType: "circle", //square
				dataPoints: [
				{ x: 10, y: 71 },
				{ x: 20, y: 55 },
				{ x: 30, y: 50 },
				{ x: 40, y: 65 },
				{ x: 50, y: 95 },
				{ x: 60, y: 68 },
				{ x: 70, y: 28 },
				{ x: 80, y: 34 },
				{ x: 90, y: 14 }                
				]
			}					
			]
		});
    
    interactiveChart.render();
    		var record = false;
			var snapDistance = 5;
			var xValue, yValue, parentOffset, relX, relY;
			var selected;
			var newData = false;
			var timerId = null;
			
			$("#interactive-chart .canvasjs-chart-canvas").last().on({
				mousedown: function(e) {
					parentOffset = jQuery(this).parent().offset();
					relX = e.pageX - parentOffset.left;
					relY = e.pageY - parentOffset.top;
					xValue = Math.round(interactiveChart.axisX[0].convertPixelToValue(relX));
					yValue = Math.round(interactiveChart.axisY[0].convertPixelToValue(relY));
					var dps = interactiveChart.data[0].dataPoints;
					for(var i = 0; i < dps.length; i++ ) {
						if((xValue >= dps[i].x - snapDistance && xValue <= dps[i].x + snapDistance) && 
							(yValue >= dps[i].y - snapDistance && yValue <= dps[i].y + snapDistance) ) {
							record = true;
						selected = i;
						break;
					} else {
						selected = null;
					}
				}
				newData = (selected === null) ? true : false;
				if(newData) {
					interactiveChart.data[0].addTo("dataPoints", {x: xValue, y: yValue});
					interactiveChart.axisX[0].set("maximum", Math.max(interactiveChart.axisX[0].maximum, xValue + 30));
						//interactiveChart.render();
					}
				},

				mousemove: function(e) {
					if(record && !newData) {
						parentOffset = jQuery(this).parent().offset();
						relX = e.pageX - parentOffset.left;
						relY = e.pageY - parentOffset.top;
						xValue = Math.round(interactiveChart.axisX[0].convertPixelToValue(relX));
						yValue = Math.round(interactiveChart.axisY[0].convertPixelToValue(relY));
						clearTimeout(timerId);
						timerId = setTimeout(function(){
							if(selected !== null) {
								interactiveChart.data[0].dataPoints[selected].x = xValue;
								interactiveChart.data[0].dataPoints[selected].y = yValue;
								interactiveChart.render();
							}	
						}, 0);
					}
				},
				mouseup: function(e) {
					if(selected !== null) {
						interactiveChart.data[0].dataPoints[selected].x = xValue;
						interactiveChart.data[0].dataPoints[selected].y = yValue;
						interactiveChart.render();
						record = false;
					}
				}
			});
</script>
		