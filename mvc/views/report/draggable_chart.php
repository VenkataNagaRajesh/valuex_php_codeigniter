<div class="off-elg">
	<h2 class="title-tool-bar">Report</h2>
    <div class="col-md-12" >   
        <canvas id="cvs" width="600" height="250">[No canvas support]</canvas>
        <button onclick="line.set('outofboundsClip', !line.get('outofboundsClip')); RGraph.redraw()">Toggle the outofboundsClip option</button>
    </div>
</div>
   
<script src="<?=base_url('assets/chartjs/RGraph.common.core.js')?>"></script>
<script src="<?=base_url('assets/chartjs/RGraph.line.js')?>"></script>
<script src="<?=base_url('assets/chartjs/RGraph.common.dynamic.js')?>"></script>
    <script>
        line = new RGraph.Line({
            id: 'cvs',
            data: [
                //[4,5,8,7,6,4,3,5],
                [7,1,6,9,4,6,5,2]
            ],
            options: {
                xaxisLabels: ['Kev','Matt','Rich','Dave','Iggy','Polly','Fiona','Fred','Pete','Lou','Fred','Bob'],
                marginBottom: 35,
                linewidth: 2,
                marginInner: 10,
                shadow: true,
                adjustable: true,
                title: 'An adjustable line chart',
                titleVpos: 0.4,
                spline: true,
                tickmarksStyle: 'circle',
                tickmarksSize: 5
            }
        }).draw().on('click', function (e, shape)        {
            
            var obj   = e.target.__object__
            var shape = obj.getShape(e);
            
            if (shape) {

                var index   = shape.index,
                    dataset = shape.dataset,
                    value   = obj.original_data[dataset][index];

                alert('Value is: ' + value);
            }
        }).on('mousemove', function ()
        {
            return true;
        });
    document.getElementById("cvs").onclick = function (e, shape)   {
        var canvas = e.target;      
        var bar = canvas.__object__;
        console.log(bar.original_data);               
    }
    </script>
