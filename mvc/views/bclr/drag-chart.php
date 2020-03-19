<div class="box">
	<div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa fa-users"></i>CWT graph</h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("bclr/index")?>">Back</a></li>
            <li class="active">cwt graph</li>
        </ol>
    </div>
    <div class="col-md-12" > 
        <div class="col-md-6">
           <br/><!-- Just so that JSFiddle's Result label doesn't overlap the Chart -->
           <div id="interactive-chart" style="height: 360px; width: 100%;"></div>
        </div> 
		<div class="col-md-6">
		  <input type="text" name="graph_name" placeholder="Enter Unique Name" id="graph_name" />
		  <button class="btn btn-danger" onclick="getChartValues()">Update</button>
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
		var interactiveChart = new CanvasJS.Chart("interactive-chart", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light2",
			//zoomEnabled: true,
      		//zoomType: "xy",
			//width: 800,
			title: {
				text: "Baggage Unit Price Setting",
				fontSize: 20,
				padding: 5,
        		backgroundColor: "#f4d5a6",	
			},
			/* subtitles: [{
				text: "Click anywhere on plotarea to add new Data Points"
			}], */
			axisX: {
				title: "Weight Capacity",
				titleFontColor: "#4F81BC",
				minimum: 1,
				maximum: <?=count($points)+10?>,
				//interval: 5,
			},
            axisY: {
		        title: "Price per KG",
				minimum: 1,
				maximum: <?=end($points)+10;?>,
				titleFontColor: "#4F81BC",
				suffix : "",
				prefix : "",
				//lineColor: "#4F81BC",
				//tickColor: "#4F81BC",

            },
			/* axisY2: {
		title: "Distance",
		titleFontColor: "#C0504E",
		suffix : " m",
		lineColor: "#C0504E",
		tickColor: "#C0504E"
	}, */
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
                name: "Price per KG",
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

			function getChartValues(){
				var graph_name = $('#graph_name').val();
				if(graph_name == '' ||graph_name == null){
                   alert("Enter graph Name"); 
				} else {
					var data = interactiveChart.get("data");
					//console.log(data[0].dataPoints);
					$.ajax({ 
						async: false,            
						type: 'POST',            
						url: "<?=base_url('bclr/updatecwtgraph')?>",            
						data: {"bclr_id":<?=$bclr_id?>,"graph_name":graph_name,"points":data[0].dataPoints},           
						dataType: "html",                                  
						success: function(data) {
							var obj = jQuery.parseJSON(data);
							if( obj.status === "updated" ){
							window.location.reload(true);
							} else {
								alert(obj.status);
							}                         
						}       
					}); 
				} 
			}
</script>
		