<?php 
?> 
<style>
.off-elg .ui-datepicker-calendar thead{
	background: #333366;
    color: #fff;
    font-family: calibri;
    font-weight: bold;
    font-size: 14px;
    line-height: 8px;
}
.off-elg .ui-datepicker-header{
	background:none;
	border: solid 1px #ddd;
    border-bottom: none;
    border-radius: 0;
}
.off-elg .ui-datepicker-title{
	text-align:left;
	margin:0 12px;
}
.off-elg .ui-datepicker tr td a {
	border:none;
}
.off-elg .ui-datepicker tr td{
	border:solid 1px #ddd;
}
.off-elg #calendar1 .ui-datepicker-month{
	font-weight: bold;
    font-size: 22px;
    color: #336699;
    font-family: calibri;
}
.off-elg #calendar1 .ui-datepicker-year{
	font-weight: normal;
    font-size: 22px;
    color: #336699;
    font-family: calibri;
}
.off-elg #calendar2 .ui-datepicker-month ,.off-elg #calendar3 .ui-datepicker-month{
	font-weight: bold;
    font-size: 14px;
    font-family: calibri;
}
.off-elg #calendar2 .ui-datepicker-year ,.off-elg #calendar3 .ui-datepicker-year{
	font-weight: bold;
    font-size:14px;
    font-family: calibri;
}
.bidnormal p{
	background: #008000 !important;
	margin-top:-39px;
    position: relative;
    line-height: 16px;
    font-size: 12px;
    font-weight: bold;
    padding: 3px 0;
    margin-bottom: 0;
    text-align: center;
    font-family: calibri;
}
.bidnormal a {
	color: white !important;
}
.bidwarning p{
	margin-top:-39px;
	background: #FFFF00 !important;
    position: relative;
    line-height: 16px;
    font-size: 12px;
    font-weight: bold;
    padding: 3px 0;
    margin-bottom: 0;
    text-align: center;
    font-family: calibri;
}
.bidwarning a {
	color: black !important;
}
.bidalert {
	background: #FF0000;
}
.bidnormal a {
	color: black !important;
}
#calendar1 .ui-datepicker {
    width: auto;
	padding: 0;
	border:none;
}
#calendar1 .ui-datepicker tr td{
    border: solid 1px #ddd;
}
#calendar1 .ui-datepicker tr td a {
    font-size: 16px;
	width: 75px;
    height: 75px;
    border: none;
    font-weight: bold;
    text-align: left;
    font-family: calibri;
	color:#000;
}
#calendar1 .ui-datepicker tr td a p {
    background: yellow;
    margin-top: 16px;
    font-size: 12px;
    text-align: center;
    padding: 4px 0;
}
#calendar2 .ui-datepicker ,#calendar3 .ui-datepicker{
	width: auto;
	margin-bottom:16px;
	padding: 0;
    border: none;
}
#calendar2 tbody , #calendar3 tbody{
	line-height:23px;
}
</style>

<div class="off-elg">
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:100%;"><i class="fa fa-calendar"></i> Bid Calendar Report
		<ol class="breadcrumb pull-right">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active">Bid Calendar Report</li>
        </ol>
	</h2>
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
			<div class="col-md-4">
				<fieldset>
					<legend>To Date</legend>
					<div class="col-md-6">
			<?php $ylist = array("0" => "Select To Year"); 
			    $current_year = date('Y');              
               		    for($i=0;$i<10;$i++){
				 $ylist[$current_year+$i] = $current_year+$i;	
			   }				
			   echo form_dropdown("filter_year_to", $ylist,set_value("filter_year_to",$year), "id='filter_year_to' class='form-control hide-dropdown-icon select2'"); ?>	 
			</div>
			<div class="col-md-6">
				<select name="filter_to_month" id="filter_to_month" class="form-control hide-dropdown-icon select2" >  				
				</select>
					</div>
				</fieldset>
			</div>
                    <div class="col-sm-2">
			<?php
			$products['0'] = 'Product Type';
                            ksort($products);
			echo form_dropdown("product_id", $products,set_value("product_id",$product_id), "id='product_id' class='form-control hide-dropdown-icon select2'");    ?>
			</div>
			<div class="col-md-2 pull-right">
				<button type="submit" class="form-control btn btn-danger">Report</button>				
			</div>
		  </div>
	   </form>
	</div>
<div class="col-md-12 report-box">
	 <div class="row">		
		<div class="col-md-7 col-md-offset-1">
		  <h3><strong><b>Bid Calendar <?=$products[$product_id]?> Report for <?= $airlineID ? $list[$airlineID] : " all Carriers" ;?> <?=$this->data['to_date'] ?  " &nbsp;" . date('M - Y', $this->data['to_date']) : "" ; ?></b></strong></h3>
		</div>
		<div class="col-md-3">
		  <h3><b>Future Months</b></h3>
		</div>
	  </div>
	 <div class="row">
		<div class="col-md-7 col-md-offset-1">
			<div id="calendar1" class="cal-box"></div>
		</div> 
		<div class="col-md-3">
			<div id="calendar2" class="cal-box"></div>
			<div id="calendar3" class="cal-box"></div>
		</div>  
	</div>
 </div>
	<form id="reportform" action="<?=base_url('offer_table')?>" style="display:none;" method="post" target='_blank'>
		<input type="hidden" name="flight_from_dep_date" id="flight_from_dep_date" value="">
		<input type="hidden" name="flight_to_dep_date" id="flight_to_dep_date" value="">
		<input type="hidden" name="carrier" id="carrier" value="">
		<input type="hidden" name="offer_status" id="offer_status" value="">
		<input type="hidden" name="product_id" id="product_id" value="">
		<input type="submit" value="Submit">
	</form>	
</div>

<script src="<?=base_url('assets/chartjs/canvasjs.min.js')?>"></script>
<script src="<?=base_url('assets/chartjs/pie-chart.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/inilabs/jquery.redirect.js'); ?>"></script>
<script>

			$('#progress-<?=$bid_accepted?>').pieChart({
                barColor: '#5499C7',
                trackColor: '#eee',
                lineCap: 'round',
				lineWidth: 15,
				size: 120,
				rotate: 0,
				animate: { 
				   duration: 1000,
				   enabled:true
				},				
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


</script>
<script>
jQuery(document).ready(function() {	
	bidcalender1('<?php echo json_encode($bids_current_month_list)?>', '<?=$bids_current_month_average?>','<?=$bids_avg_revenue_alert_percentage?>');
	bidcalender2('<?php echo json_encode($bids_month1_list)?>', '<?=$bids_month1_average?>','<?=$bids_avg_revenue_alert_percentage?>');
	bidcalender3('<?php echo json_encode($bids_month2_list)?>', '<?=$bids_month2_average?>','<?=$bids_avg_revenue_alert_percentage?>');
});

$(document).ready(function(){
	$('#filter_year_to').val(<?=$to_year?>).trigger('change');	
	$('#filter_to_month').val(<?=$to_month?>).trigger('change');	
});

$('#filter_year_to').change(function(){
	var year = <?=date('Y')?>;
	var month = <?=date('m')?>;
	if(year == $(this).val()){		
		start_month = month-1; 
	} else {
		start_month = 0;
	}
   	end_month = 11;
	var html = '',value=0;
	var from_selected = '';
	var to_selected = '';
	var to_html = "<option value='0'>To Month</option>";
	for(var i=start_month;i<=end_month;i++){
		value = i+1;
		to_selected = ('<?=$to_month?>'==value)?'selected':'';		
		to_html += '<option value="'+value+'" '+to_selected+'>'+new Date($(this).val(),i).toLocaleString("default", { month: "long" })+'</option>';
	}	
	
	
	$('#filter_to_month').html(to_html);	
});

function progressReport(from_date, to_date) {	
		$('#carrier').val('<?=$airlineID?>');
		$('#flight_from_dep_date').val(from_date);
		$('#flight_to_dep_date').val(to_date);
		$('#offer_status').val(1988);//Accpeted builds
		$('#product_id').val('<?=$product_id?>');
	 	$("#reportform").submit();	
}

function bidcalender1 (bidlist = '[]', bid_average, bid_avg_rev_percent = 10) 
{
	var bid_data = jQuery.parseJSON(bidlist);
        // An array of bid_date
     var eventDates = {}; var bidcolor = {}; var name = {};
	 //var datecal = new Date().getFullYear();
	 var datecal = '<?=$from_date?>';
	 //$_POST['color_bid']=10; 
	     //  var html = '';
	dtpoints = [];
    for(var i=0; i<bid_data.length; i++) {
	       	eventDates[ new Date( bid_data[i]['bid_date'] )] = new Date( bid_data[i]['bid_date'] ).toString();
		    	bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidnormal'; 
			if (bid_data[i]['bid_count'] > 0) {
				avghighmark = bid_average + bid_average*(bid_avg_rev_percent)/100;
				avglowmark = bid_average - bid_average*(bid_avg_rev_percent)/100;
				cdate_avg_value = bid_data[i]['bid_revenue']/bid_data[i]['bid_count'];
				d =  new Date( bid_data[i]['bid_date']);
				bidclass = 'bidday' + d.getDay();
				if ( cdate_avg_value > avghighmark ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidalert' + ' ' + bidclass; 
				} else if ( cdate_avg_value < avghighmark ||  cdate_avg_value > avglowmark  ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidwarning' + ' ' + bidclass; 
				} else if ( cdate_avg_value < avglowmark  ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidnormal' + ' ' + bidclass; 
				}
			}
		    name[ new Date( bid_data[i]['bid_date'] )] = bid_data[i]['bid_date'] +  '\n' + 'Bid Count: '+bid_data[i]['bid_count'] +  '\n' + 'Bid Current Date Average Revenue: '+ Math.round(cdate_avg_value) + '(' + Math.round(100-cdate_avg_value*100/bid_average) + '%)' +  '\n' + 'Bid Current Month Average Revenue: '+ Math.round(bid_average); 
		    dtpoints[bidclass] =  bid_data[i]['bid_count'] +  '<br>' + '$' + Math.round(cdate_avg_value)
                 			
	    //$("<style> .bid"+bid_data[i]['bid_date'] + " { color:#ffffff !important;  background-color:"+bid_data[i]['bid_color'] + " !important;} </style>").appendTo("head");			
	    //bidstyle = "<style> .bid"+bid_data[i]['bid_date'] + " { color:#ffffff !important;  background:"+bid_data[i]['bid_color'] + " !important;} </style>";			
	//	$('head').append(bidstyle);
    }   

	jQuery('#calendar1').datepicker({		    
		format:'unixtime',
		height: '550px',
		//numberOfMonths: [3,4],  
		stepMonths: 0,
		defaultDate: new Date(datecal, 0, 1),			
		onSelect: function (date) {

			var d = new Date(date);
			//var d = date;
			 var year = d.getUTCFullYear();
			 var month = d.getUTCMonth();
			 var day = d.getUTCDate();

			 var startHour =Date.UTC(year,month,day+1,0,0,0,0);
			 var endHour = startHour + 86400000-1;
		    //defined your own method here
			//progressReport('<?=$from_date?>','<?=$to_date?>');
			progressReport(startHour/1000, endHour/1000);
		},
		beforeShowDay: function( date ) {					
			var highlight = eventDates[date];
			var bid_color = bidcolor[highlight];
			var bid_name = name[highlight];					
				if( highlight ) {                   
				//return [true,"bid"+bidid,bid_name];								
				return [true,bid_color,bid_name];								
			} else {
				return [true, '', ''];
			}  
		}
	}); 
	$(".ui-datepicker-prev, .ui-datepicker-next").remove();
	for (var dayclass in dtpoints) { 
		$('#calendar1 .' + dayclass).append('<p>' + dtpoints[dayclass] + '</p>');
	}
	//$("#calendar1 .ui-datepicker").css('font-size', '20px');
	//$("#calendar1 .ui-datepicker").css('height', '450px');
//	$("#calendar1 .ui-datepicker").css('width', '722px');
//	$("#calendar1 .ui-datepicker").css('font-size', '60px');
//	$("#calendar1 .ui-datepicker").css('text-align', '60px');
//	//$("#calendar1 .ui-datepicker  tr > td:a ").css('width', '130px');
//	$("#calendar1 .ui-datepicker tr td a").css('width', '100px');
//	$("#calendar1 .ui-datepicker tr td a").css('height', '86px');
}

function bidcalender2 (bidlist = '[]', bid_average, bid_avg_rev_percent = 10) 
{
	var bid_data = jQuery.parseJSON(bidlist);
        // An array of bid_date
     var eventDates = {}; var bidcolor = {}; var name = {};
	 //var datecal = new Date().getFullYear();
	 var datecal = new Date(<?=$month1_from_date*1000?>);

    for(var i=0; i<bid_data.length; i++) {
	       	eventDates[ new Date( bid_data[i]['bid_date'] )] = new Date( bid_data[i]['bid_date'] ).toString();
		    	bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidnormal'; 
			if (bid_data[i]['bid_count'] > 0) {
				avghighmark = bid_average + bid_average*(bid_avg_rev_percent)/100;
				avglowmark = bid_average - bid_average*(bid_avg_rev_percent)/100;
				cdate_avg_value = bid_data[i]['bid_revenue']/bid_data[i]['bid_count'];
				if ( cdate_avg_value > avghighmark ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidalert'; 
				} else if ( cdate_avg_value < avghighmark ||  cdate_avg_value > avglowmark  ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidwarning'; 
				} else if ( cdate_avg_value < avglowmark  ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidnormal'; 
				}
			}
		    name[ new Date( bid_data[i]['bid_date'] )] = bid_data[i]['bid_date'] +  '\n' + 'Bid Count: '+bid_data[i]['bid_count'] +  '\n' + 'Bid Current Date Average Revenue: '+ Math.round(cdate_avg_value) + '(' + Math.round(100-cdate_avg_value*100/bid_average) + '%)' +  '\n' + 'Bid Current Month Average Revenue: '+ Math.round(bid_average); 
    }   

	jQuery('#calendar2').datepicker({		    
		//format:'unixtime',
		format: "MM yyyy",
		//numberOfMonths: [3,4],  
		stepMonths: 0,
		defaultDate: new Date(datecal.getFullYear(), datecal.getMonth(), 1),			
		onSelect: function (date) {
		    //defined your own method here
			progressReport('<?=$month1_from_date?>','<?=$month1_to_date?>');
		},
		beforeShowDay: function( date ) {					
			var highlight = eventDates[date];
			var bid_color = bidcolor[highlight];
			var bid_name = name[highlight];					
				if( highlight ) {                   
				//return [true,"bid"+bidid,bid_name];								
				return [true,bid_color,bid_name];								
			} else {
				return [true, '', ''];
			}  
		}
	}); 
	$(".ui-datepicker-prev, .ui-datepicker-next").remove();
}

function bidcalender3 (bidlist = '[]', bid_average, bid_avg_rev_percent = 10) 
{
	var bid_data = jQuery.parseJSON(bidlist);
        // An array of bid_date
     var eventDates = {}; var bidcolor = {}; var name = {};
	 //var datecal = new Date().getFullYear();
	 var datecal = new Date(<?=$month2_from_date*1000?>);

    for(var i=0; i<bid_data.length; i++) {
	       	eventDates[ new Date( bid_data[i]['bid_date'] )] = new Date( bid_data[i]['bid_date'] ).toString();
		    	bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidnormal'; 
			if (bid_data[i]['bid_count'] > 0) {
				avghighmark = bid_average + bid_average*(bid_avg_rev_percent)/100;
				avglowmark = bid_average - bid_average*(bid_avg_rev_percent)/100;
				cdate_avg_value = bid_data[i]['bid_revenue']/bid_data[i]['bid_count'];
				if ( cdate_avg_value > avghighmark ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidalert'; 
				} else if ( cdate_avg_value < avghighmark ||  cdate_avg_value > avglowmark  ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidwarning'; 
				} else if ( cdate_avg_value < avglowmark  ) {
		    			bidcolor[ new Date( bid_data[i]['bid_date'] )] = 'bidnormal'; 
				}
			}
		    name[ new Date( bid_data[i]['bid_date'] )] = bid_data[i]['bid_date'] +  '\n' + 'Bid Count: '+bid_data[i]['bid_count'] +  '\n' + 'Bid Current Date Average Revenue: '+ Math.round(cdate_avg_value) + '(' + Math.round(100-cdate_avg_value*100/bid_average) + '%)' +  '\n' + 'Bid Current Month Average Revenue: '+ Math.round(bid_average); 
    }   

	jQuery('#calendar3').datepicker({		    
		//format:'unixtime',
		format: "MM yyyy",
		//numberOfMonths: [3,4],  
		stepMonths: 0,
		defaultDate: new Date(datecal.getFullYear(), datecal.getMonth(), 1),			
		onSelect: function (date) {
		    //defined your own method here
			progressReport('<?=$month2_from_date?>','<?=$month2_to_date?>');
		},
		beforeShowDay: function( date ) {					
			var highlight = eventDates[date];
			var bid_color = bidcolor[highlight];
			var bid_name = name[highlight];					
				if( highlight ) {                   
				//return [true,"bid"+bidid,bid_name];								
				return [true,bid_color,bid_name];								
			} else {
				return [true, '', ''];
			}  
		}
	}); 
	$(".ui-datepicker-prev, .ui-datepicker-next").remove();
}

</script>

