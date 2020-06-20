<div class="off-elg" style="margin-bottom:320px;">
	<h2 class="title-tool-bar">Edit Cwt Graph</h2>
    <div class="col-md-12" > 
        <div class="col-md-6">
           <br/><!-- Just so that JSFiddle's Result label doesn't overlap the Chart -->
           <div id="google.charts" style="height: 360px; width: 100%;">
        
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
     google.charts.load("current", {packages:["corechart"]});
     google.charts.setOnLoadCallback(drawChart);
     function drawChart() {
       var data = google.visualization.arrayToDataTable([
         ['Age', 'Weight'],
         [ 8,      12],
         [ 4,      5.5],
         [ 11,     14],
         [ 4,      5],
         [ 3,      3.5],
         [ 6.5,    7]
       ]);

       var options = {
         title: 'Age vs. Weight comparison',
         legend: 'none',
         crosshair: { trigger: 'both', orientation: 'both' },
         trendlines: {
           0: {
             type: 'polynomial',
             degree: 3,
			 visibleInLegend: true,
           }
         }
       };

       var chart = new google.visualization.ScatterChart(document.getElementById('polynomial2_div'));
       chart.draw(data, options);
     }
   </script>
 <body>
  <div id='polynomial2_div' style='width: 900px; height: 500px;'></div>
 </body>
 </div>
</div>       
    </div>
</div>