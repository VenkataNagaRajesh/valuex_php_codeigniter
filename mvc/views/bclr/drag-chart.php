<div class="off-elg" style="margin-bottom:320px;">
	<h2 class="title-tool-bar">Report</h2>
    <div class="col-md-12" > 
        <div class="col-md-6">
           <br/><!-- Just so that JSFiddle's Result label doesn't overlap the Chart -->
           <div id="interactive-chart" style="height: 360px; width: 100%;"></div>
        </div>       
    </div>
</div>
<script src="<?=base_url('assets/chartjs/canvasjs.min.js')?>"></script>  
<script>
    var pointsdata = [];
	<?php  foreach($points as $key => $value){ ?>
		  cobj = {x: <?=$key?>, y:<?=$value?>};
		  pointsdata.push(cobj);
	<?php  } ?>
	console.log(pointsdata);
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
				minimum: 1,
				maximum: <?=$max_capacity?>
			},
            axisY: {
		        title: "Closing Price (in USD)",
				minimum: 1,
				maximum: <?=end($points)+1;?>
            },
			data: [
			{
				markerSize: 4,
				type: "line", //spline,line,area
				cursor: "move",
                color: "#1bbde2",
               // xValueFormatString: "DD MMM",
		       // yValueFormatString: "$##0.00",
                //lineDashType: "dash",
                showInLegend: true,
                name: "Unique Visit",
                markerType: "circle", //square
				dataPoints: pointsdata					
			}
			/*,{
				markerSize: 4,
				type: "line", //spline,line,area
				cursor: "move",
                color: "red",
               // xValueFormatString: "DD MMM",
		       // yValueFormatString: "$##0.00",
                //lineDashType: "dash",
                showInLegend: true,
                name: "Unique Visit",
                markerType: "circle", //square				
				dataPoints: [
				{ x: 1, y: 10 },
				{ x: 2, y: 15 },
				{ x: 3, y: 20 },
				{ x: 4, y: 22 },
				{ x: 5, y: 25 },
				{ x: 6, y: 30 },
				{ x: 7, y: 34 },
				{ x: 8, y: 39 },
				{ x: 9, y: 39 },
				{ x: 10, y: 5 },
				{ x: 11, y: 10 },
				{ x: 12, y: 15 },
				{ x: 13, y: 20 },
				{ x: 14, y: 22 },
				{ x: 15, y: 25 },
				{ x: 16, y: 30 },
				{ x: 17, y: 34 },
				{ x: 18, y: 39 }			            
				]			
			}*/
								
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
		