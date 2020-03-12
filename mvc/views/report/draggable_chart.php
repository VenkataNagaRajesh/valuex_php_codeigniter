<div class="off-elg" style="margin-bottom:320px;">
	<h2 class="title-tool-bar">Report</h2>
    <div class="col-md-12" > 
        <div class="col-md-6">
            <canvas id="cvs" width="600" height="250">[No canvas support]</canvas>
        </div>
        <div class="col-md-6">
            <span style="font-size: 10pt">New label: </span><input id="label" style="font-size: 10pt; padding: 3px" />
            <button class="btn btn-danger" id="png_link"  onclick="RGraph.showPNG(document.getElementById('cvs'), event)">Get PNG</button>  
            <!--   <button onclick="line.set('outofboundsClip', !line.get('outofboundsClip')); RGraph.redraw()">Toggle the outofboundsClip option</button> -->
        </div>
    </div>
</div>
   
<script src="<?=base_url('assets/chartjs/RGraph.common.core.js')?>"></script>
<script src="<?=base_url('assets/chartjs/RGraph.line.js')?>"></script>
<script src="<?=base_url('assets/chartjs/RGraph.common.dynamic.js')?>"></script>
<script src="<?=base_url('assets/chartjs/RGraph.common.tooltips.js')?>"></script>
<script src="<?=base_url('assets/chartjs/RGraph.common.context.js')?>"></script>
    <script>
        line = new RGraph.Line({
            id: 'cvs',
            data: [
                [4,5,8,7,6,4,3,5],
                [7,1,6,9,4,6,5,2]
            ],
            labels:['red','green'],
            options: {
                xaxisLabels: ['A','B','C','D','E','F','G','H','I','J','K','L'],               
                marginBottom: 35,
                linewidth: 2,
                marginInner: 10,
                shadow: true,
                adjustable: true,
                title: 'An adjustable line chart',
                titleVpos: 0.4,
                //spline: true, //curve type
                tickmarksStyle: 'circle',
                tickmarksSize: 5,
                tooltips: '<strong>Value %{value}</strong>',
                contextmenu: [ ['Get PNG', RGraph.showPNG], null, ['Cancel', function () {}] ]
            }
        }).draw().on('click', function (e, shape) {            
            var obj   = e.target.__object__
            var shape = obj.getShape(e);            
            if (shape) {
                var index   = shape.index,
                    dataset = shape.dataset,
                    value   = obj.original_data[dataset][index];
                alert('Value is: ' + value);
            }
        }).on('mousemove', function (){
            return true;
        }).trace({frames: 60}, function (obj){
        obj.animate({
            'tickmarksSize': 7
        });
    });

    line.canvas.addEventListener('click', function (e)
    {
        // Get:
        //  o The mouse coordinates
        //  o The value at the point where the chart has been clicked
        //  o The value that has been entered in the text input
        var xy     = RGraph.getMouseXY(e),
            value  = line.getValue(e),
            label  = document.getElementById('label').value,
            canvas = line.canvas;
        

        // The chart was clicked in the right margin so add the new point at the
        // end of the line (RHS)
        if (xy[0] > (canvas.width - line.get('marginRight')) ) {
            line.original_data[0].push(value);

            line.get('xaxisLabels').push(label);

        // The chart was clicked in the left margin so add the new point at the
        // beginning of the line (LHS)
        } else if (xy[0] < line.get('marginLeft')) {
            line.original_data[0].unshift(value );
            line.get('xaxisLabels').unshift(label);
        }
        
        // Set the number of X tickmarks to one less than the number of points on
        // the chart
        line.set('tickmarksCount', line.original_data[0].length - 1);
        
        // Redraw the chart
        RGraph.redraw();
        
        // Clear the text input using standard DOM code
        document.getElementById('label').value = '';
    }, false);


    document.getElementById("cvs").onclick = function (e, shape)   {
        var canvas = e.target;      
        var bar = canvas.__object__;
        console.log("Red Line");
        console.log(bar.original_data[0]); 
        console.log("Green Line");
        console.log(bar.original_data[1]);               
    }
    
    </script>
