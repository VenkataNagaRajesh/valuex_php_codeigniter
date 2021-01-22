<div class="seasons">
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:96%;"><i class="fa fa-calendar"></i> Seasons
		<ol class="breadcrumb pull-right">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_season')?></li>
        </ol>
	</h2>
	 <p class="card-header" data-toggle="collapse" data-target="#seasonAdd"><button type="button" id = 'add_season_button' class="btn btn-danger pull-right" style="margin:1px 0;" data-placement="left" title="Add Season" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
	<div class="col-md-12 season-add-box collapse" id="seasonAdd">
		<form class="form-horizontal" action="#" id="season_form" style="padding:0 15px;">
			<div class="form-group">
				<div class="row">
					<div class="col-md-3 col-sm-3 select-form">
						<div class="col-md-12">
							<?php
								 foreach($seasons as $season){
									$gseasonlist[$season->vx_aln_data_defnsID] = $season->aln_data_value;
								  }							
								$gseasonlist[0]=$this->lang->line("season_select_season");
								ksort($gseasonlist);

								echo form_dropdown("global_seasonID", $gseasonlist,set_value("global_seasonID",$global_seasonID), "id='global_seasonID' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
						<div class="col-md-12">
							<?php
								 foreach($airlines as $airline){
									$airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
								  }							


								$roleID = $this->session->userdata('roleID');
                                                        if($roleID != 1){
                                                                $default_airlineID =  key($airlinelist);
                                                        } else {
                                                                $default_airlineID = 0;
                                                        }


								$airlinelist[0]=$this->lang->line("season_select_airline");
								ksort($airlinelist);

								echo form_dropdown("airlineID", $airlinelist,set_value("airlineID",$filter_airline), "id='airlineID' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control"  placeholder="Enter Season Name" id="season_name" name="season_name" value="<?=set_value('season_name')?>">
						</div>
					</div>
					<div class="col-md-3 col-sm-3 select-form">
						<div class="col-md-12">
							<?php
								 $orglevels[0]=$this->lang->line("season_orig_level_select");
								 foreach($types as $level){
									 $orglevels[$level->vx_aln_data_typeID] = $level->alias;
								 }							
								echo form_dropdown("ams_orig_levelID", $orglevels,set_value("ams_orig_levelID"), "id='ams_orig_levelID' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
						<div class="col-md-12">
							<div class="col-md-10 col-sm-9" style="padding:0;">
								<select name="ams_orig_level_value[]" id="ams_orig_level_value" class="form-control select2" multiple="multiple">
								</select>
							</div>
							<div class="col-md-2 col-sm-2">
								<input type="checkbox" id="orig_all" title="Select All" data-toggle="tooltip" data-placement="top">
							</div>
						</div>
						<div class="col-md-12">
							<div class="input-group">
							<label class="control-label col-md-3">Color</label>
								<input type="text" class="form-control" id="season_color" name="season_color" value="<?=set_value('season_color')?>" >
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 select-form">
						<div class="col-md-12">
							 <?php
								 $destlevels[0]=$this->lang->line("season_dest_level_select");
								 foreach($types as $level){
									 $destlevels[$level->vx_aln_data_typeID] = $level->alias;
								 }							
							   echo form_dropdown("ams_dest_levelID", $destlevels,set_value("ams_dest_levelID"), "id='ams_dest_levelID' class='form-control hide-dropdown-icon select2'"); 
							?>
						</div>
						<div class="col-md-12">
							<div class="col-md-10 col-sm-9" style="padding:0;">
								<select name="ams_dest_level_value[]" id="ams_dest_level_value" class="form-control select2 col-md-10" multiple="multiple">
							</select>	
							</div>
							<div class="col-md-2 col-sm-2">
								<input type="checkbox" id="dest_all" title="Select All" data-toggle="tooltip" data-placement="top">
							</div>	
						</div>
					</div>
					<div class="col-md-3 col-sm-3">
						<div class="col-md-12">
							<div class="input-group">
								<input type="text" class="form-control" id="ams_season_start_date" name="ams_season_start_date" placeholder="Enter Dep From date" value="<?=set_value('ams_season_start_date')?>" >
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="input-group">
								<input type="text" class="form-control" id="ams_season_end_date" name="ams_season_end_date" placeholder="Enter Dep To date" value="<?=set_value('ams_season_end_date')?>" >
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<label class="control-label col-md-5 col-sm-5">Return Inclusive</label>
						<div class="col-md-7 col-sm-7">
							<label class="radio-inline">
								<input type="radio" name="is_return_inclusive" value="1" <?=set_value('is_return_inclusive')?> >Yes
							</label>
							<label class="radio-inline" style="margin-left: 0px;">
								<input type="radio" name="is_return_inclusive" value="0"  <?=set_value('is_return_inclusive')?> >No
							</label>
							<input type="hidden" class="form-control" id="season_id" name="season_id"   value="" >	
						</div>
					</div>
					<div class="col-md-5 col-sm-5">
						<div class="col-md-12">
							<p class="pull-right">
								<a href="#" type="button" class="btn btn-danger" id='btn_txt' onclick="saveseason()">Save</a>
								<a href="#" type="button" class="btn btn-danger">Cancel</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	   <div class="col-md-12 season-table">	
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="season-form" style="padding:0 15px;">		   
			<div class='form-group'>
				<div class="col-sm-3 col-md-2">			   
				 <!-- <input type="text" name="airlinecode" id="airlinecode" placeholder="Carrier code_name" class="form-control" value="<?=set_value('airlinecode',$airlinecode)?>"/>-->
				  <?php $alist = array("0" => "Carrier");               
				    foreach($airlines as $air){
					  $alist[$air->vx_aln_data_defnsID] = $air->code;
					}				
				  echo form_dropdown("filter_airline", $alist,set_value("filter_airline",$filter_airline), "id='filter_airline' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-sm-3 col-md-2">			   
				<?php $slist = array("0" => " Season Name");               
				   foreach($seasonslist as $season){
					  $slist[$season->VX_aln_seasonID] = $season->season_name;
					}							
				   echo form_dropdown("seasonID", $slist,set_value("seasonID",$seasonID), "id='seasonID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-sm-3 col-md-2">			   
				  <?php $olist = array("0" => " Origin Level");               
				  foreach($types as $type){
					  $olist[$type->vx_aln_data_typeID] = $type->alias;
					}							
				  echo form_dropdown("origID", $olist,set_value("origID",$origID), "id='origID' class='form-control hide-dropdown-icon select2'");    ?>
				</div> 
                <div class="col-sm-3 col-md-2">
				  <select name="origValues[]" id="origValues" class="form-control select2 col-md-10" multiple="multiple">
				  </select>
                </div>				
				<div class="col-sm-3 col-md-2">
					<?php $dlist = array("0" => " Destination");               
				   foreach($types as $type){
					  $dlist[$type->vx_aln_data_typeID] = $type->alias;
					}							
				  echo form_dropdown("destID", $dlist,set_value("destID",$destID), "id='destID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				 <div class="col-sm-3 col-md-2">
				  <select name="destValues[]" id="destValues" class="form-control select2 col-md-10" multiple="multiple">
				  </select>
                </div>
				<div class="col-sm-3 col-md-2">			  
				<?php 
				   echo form_dropdown("filter_global_seasonID", $gseasonlist,set_value("filter_global_seasonID",$seasonID), "id='filter_global_seasonID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-sm-3 col-md-2">
					<?php $activestatus[1]="Active";	$activestatus[0]="In Active";				
				  echo form_dropdown("active", $activestatus,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-md-8 text-right">
					<div class="bttn-cl">
										<button type="button" class=" form-control btn btn-danger" name="filter" id="filter"  onclick="$('#seasonslist').dataTable().fnDestroy();;loaddatatable();" data-title="Filter" data-toggle="tooltip"><i class="fa fa-filter"></i></button>
					 
					 <!-- <button data-toggle="collapse" data-target="#seasonList" type="button" class="form-control btn btn-danger"><i class="fa fa-table"></i> View</button>-->
					</div>
					<div class="bttn-cl">
									 <button type="button" class="form-control btn btn-danger" name="filter" onclick="downloadSeason()" data-title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></button>
					</div>
					<div class="bttn-cl">
					<?php if(permissionChecker('season_reconfigure')) {
					 if( isset ($reconfigure)) {?>
                               			<a href="<?php echo base_url('trigger/season_trigger') ?>" class="btn btn-danger">
                       <i class="fa fa-plus"></i>
                       <?=$this->lang->line('generate_map_table')?>
                   </a>
                        <?php } }?>
					</div>
               	</div>	
			</div>
		</form>
</div>
			<div id="hide-table" class="col-md-12" style="padding:0;">
				<table id="seasonslist" class="table table-bordered dataTable no-footer" style="width:100%;">
					<thead>
						<tr>

						    <th class="col-lg-1">
							  <input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#
                            </th>
                            <th class="col-lg-1"><?=$this->lang->line('season_airline_code')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_name')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_select_season')?></th>
							<th class="col-lg-1"><?=$this->lang->line('orig_level')?></th>
							<th class="col-lg-1"><?=$this->lang->line('orig_level_value')?></th>
							<th class="col-lg-1"><?=$this->lang->line('dest_level')?></th>
							<th class="col-lg-1"><?=$this->lang->line('dest_level_value')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_start_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_end_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('is_return_inclusive')?></th>
							<th class="col-lg-1 noExport"><?=$this->lang->line('season_color')?></th>
							<?php if(permissionChecker('season_edit')) {?>
							<th class="col-lg-1 noExport"><?=$this->lang->line('season_active')?></th>
							<?php }?>
							<?php if(permissionChecker('season_edit') || permissionChecker('season_delete')) { ?>
							<th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
							   <?php } ?>
						  </tr>
					   </thead>
					   <tbody>                            
					   </tbody>
				   </table>
			  </div>
	<div class="col-md-12 cal-table">
		<div class="col-md-8" style="padding:0;">
			<div id="calendar1" class="cal-box"></div>
		</div>
		<div class="col-md-4">

			<div>
			<?php
		
			 echo form_dropdown("color_airline_season", $airlinelist,set_value("color_airline_season",$filter_airline), "id='color_airline_season' class='form-control hide-dropdown-icon select2'"); ?>

			</div>
			<br>
			<div class="season-highlight">
					<!--<span>Season</span><span>Highlights</span><br>-->
					<!--<span class="default">Default</span><span class="default-high">&nbsp;</span><br>
					<span class="default">Summer Peak</span><span class="summer-high">&nbsp;</span><br>
					<span class="default">Christmas Peak</span><span class="christ-high">&nbsp;</span>-->
					
					<?php //foreach($seasonslist as $season) { ?>
					<!--<span class="default" onclick="getCalenderBySeason(<?=$season->VX_aln_seasonID?>)"><?=$season->season_name?></span><span style="background: <?=$season->season_color?>;" onclick="getCalenderBySeason(<?=$season->VX_aln_seasonID?>)">&nbsp;</span>-->
					<?php //} ?>
					
				</p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {	
	seasoncalender('<?php echo json_encode($seasonslist)?>');
	//alert('<?php echo json_encode($seasonslist)?>');
	//loadSeasonList(<?php echo json_encode($seasonslist)?>);
});

$( window ).load(function() {
	loaddatatable();
	$('#color_airline_season').val(<?=$filter_airline?>);
	$('#color_airline_season').trigger('change');
});

$("#add_season_button").on('click',function(){
	var seasonAdd_class_val = $("#seasonAdd").attr('class');
	var fa_icon = $("#plus_icon").attr('class');
	if(fa_icon == "fa fa-plus") {
		$("#plus_icon").attr('class','fa fa-minus');
	} else {
		$("#plus_icon").attr('class','fa fa-plus');
	}

	if(seasonAdd_class_val=="col-md-12 season-add-box collapse") {
		$('#color_airline_season').trigger('change');	
		$("#ams_orig_levelID").trigger('change');
		$('#ams_dest_levelID').trigger('change');
		$('#origID').trigger('change');
		$('#destID').trigger('change');	
		var orig_level = [<?php echo implode(',',$this->input->post("ams_orig_level_value")); ?>];
		$('#ams_orig_level_value').val(orig_level).trigger('change');
		var dest_level = [<?php echo implode(',',$this->input->post("ams_dest_level_value")); ?>];
		$('#ams_dest_level_value').val(dest_level).trigger('change');
		
		var origValues = [<?php echo implode(',',$this->input->post("origValues")); ?>];
		$('#origValues').val(origValues).trigger('change');
		var destValues = [<?php echo implode(',',$this->input->post("destValues")); ?>];
		$('#destValues').val(destValues).trigger('change');	
		
		$("input[name=is_return_inclusive][value=0]").attr('checked', 'checked');
	}

});

$('#color_airline_season').change(function(event) {    
	//alert('here');
	var airline_id = $(this).val();                 
    $.ajax({ async: false,            
             type: 'POST',            
             url: "<?=base_url('season/getSeasonsForAirline')?>",            
             data: "id=" + airline_id,            
             dataType: "html",                                  
             success: function(data) {               
		        $("#calendar1").datepicker("destroy");
		        seasoncalender(data);
				var seasons = jQuery.parseJSON(data);
				 $('.season-highlight').empty();
				 var html='<span>Season</span><span>Highlights</span>';
				  for(var i=0; i<seasons.length; i++){
				     html += '<span class="default" onclick="getCalenderBySeason('+seasons[i]['VX_aln_seasonID']+')">'+seasons[i]['season_name']+'</span><span style="background:'+seasons[i]['season_color']+';" onclick="getCalenderBySeason('+seasons[i]['VX_aln_seasonID']+')">&nbsp;</span>';
				 }
				 $('.season-highlight').html(html);				 
              }        
      });       
});

$("#ams_orig_levelID").change(function(){
	
	$(this).parent().removeClass('has-error');
	$('#ams_orig_level_value').val(null).trigger('change');
    var level_id = $(this).val();                 
    var airline_id = $('#airlineID').val();
		if( level_id == '17' ) {
			if($('#airlineID').val() == '0') {
				alert('select Airline');
				$("#ams_orig_levelID").val(0);
				$('#ams_orig_levelID').trigger('change');
				return false;
			}
        }

    $.ajax({ 
        async: false,            
	    type: 'POST',            
        url: "<?=base_url('marketzone/getSubdataTypes')?>",            
		data: {
			"id":level_id,
			"airline_id":airline_id,
            },
		dataType: "html",                                  
		success: function(data) {               
			$('#ams_orig_level_value').html(data); 
		}        
    }); 
});

$('#ams_dest_levelID').change(function(e){
	$(this).parent().removeClass('has-error');
	$('#ams_dest_level_value').val(null).trigger('change')
     var level_id = $(this).val();                 
	  var airline_id = $('#airlineID').val();
                 if( level_id == '17' ) {
                if($('#airlineID').val() == '0') {
                        alert('select Airline');
                        $("#ams_dest_levelID").val(0);
                           $('#ams_dest_levelID').trigger('change');

                        return false;
                }
        }

    $.ajax({ 
             async: false,            
	         type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
		 data: {
                           "id":level_id,
                           "airline_id":airline_id,
                                },

             dataType: "html",                                  
             success: function(data) {               
               $('#ams_dest_level_value').html(data);
			 }        
      }); 
});	

$('#origID').change(function(e){
	$(this).parent().removeClass('has-error');
	$('#origValues').val(null).trigger('change')
     var level_id = $(this).val();                 
    $.ajax({ 
             async: false,            
	         type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
                $('#origValues').html(data); 
			 }        
      }); 
});

$('#destID').change(function(e){
	$(this).parent().removeClass('has-error');
	$('#destValues').val(null).trigger('change')
     var level_id = $(this).val();                 
    $.ajax({ 
             async: false,            
	         type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
                $('#destValues').html(data); 
			 }        
      }); 
});

function seasoncalender (seasonlist = '[]') 
{
	var season_data = jQuery.parseJSON(seasonlist);
 	 // console.log(seasonlist);
        // An array of dates
     var eventDates = {}; var season = {}; var name = {};
	 var datecal = new Date().getFullYear();
	 //$_POST['color_season']=10; 
	     //  var html = '';
    for(var i=0; i<season_data.length; i++) {
		for ( var k=0 ; k<season_data[i]['dates'].length; k++) {	
	       eventDates[ new Date( season_data[i]['dates'][k] )] = new Date( season_data[i]['dates'][k] ).toString();
		    season[ new Date( season_data[i]['dates'][k] )] = season_data[i]['VX_aln_seasonID'];
			if(name[ new Date( season_data[i]['dates'][k] )]){
				name[ new Date( season_data[i]['dates'][k] )] = name[ new Date( season_data[i]['dates'][k] )]+' \n '+season_data[i]['season_name']+'(Airline:'+season_data[i]['airline_code']+',Origin:'+season_data[i]['origin_values']+',Destination:'+season_data[i]['dest_values']+')' ;
			} else {
			name[ new Date( season_data[i]['dates'][k] )] = season_data[i]['season_name']+'(Airline:'+season_data[i]['airline_code']+',Origin:'+season_data[i]['origin_values']+',Destination:'+season_data[i]['dest_values']+')' ;
			}
                 			
	   } 
	    $("<style> .season"+season_data[i]['VX_aln_seasonID'] + " { color:#fffff !important;  background:"+season_data[i]['season_color'] + " !important;} </style>").appendTo("head");			
    }   

	if(season_data.length == 1) {
		//datecal = new Date(season_data[0]['ams_season_start_date']).getFullYear();
		datecal = season_data[0]['ams_season_start_date'].split("-");
	}
	jQuery('#calendar1').datepicker({		    
		// changeMonth: true,
		// changeYear: true,
		//numberOfMonths: [3,4],
		numberOfMonths: [ 2, 3 ],
		//defaultDate: new Date(2020, 00, 01),
		defaultDate: new Date(datecal[2], datecal[1], datecal[0]),			
		beforeShowDay: function( date ) {					
			var highlight = eventDates[date];
			var color = "";
			var seasonid = season[highlight];
			var season_name = name[highlight];					
			if( highlight ) {                   
				return [true,"season"+seasonid,season_name];								
			} else {
				return [true, '', ''];
			}  
		}
	}); 
}

function getCalenderBySeason(season)
{
	$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('season/getSeasonInfo')?>",          
          data: {"season_id":season},
          dataType: "html",                     
          success: function(data) {
            $("#calendar1").datepicker("destroy");			  
            seasoncalender(data);			
         }
	 });
}
</script>
<script>
function downloadSeason(){
	$.ajax({
		url: "<?php echo base_url('season/server_processing'); ?>?page=all&&export=1",
		type: 'get',
		data: {"seasonID": $("#seasonID").val(),"season": $("#global_seasonID").val(),"origID": $("#origID").val(),"active": $("#active").val(),"destID": $("#destID").val(),"airlinecode": $("#airlinecode").val(),"origValues": $("#origValues").val(),"destValues": $("#destValues").val()},
		dataType: 'json'
	}).done(function(data){
	var $a = $("<a>");
	$a.attr("href",data.file);
	$("body").append($a);
	$a.attr("download","season.xls");
	$a[0].click();
	$a.remove();
	});
}
  
$('#seasonslist tbody').on('mouseover', 'tr', function () {
	$('[data-toggle="tooltip"]').tooltip({
		trigger: 'hover',
		html: true
	});
});
  
var status = '';
var id = 0;
$('#seasonslist tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
      if($(this).prop('checked')) {
          status = 'chacked';
          id = $(this).parent().attr("id");
      } else {
          status = 'unchacked';
          id = $(this).parent().attr("id");
      }

      if((status != '' || status != null) && (id !='')) {
          $.ajax({
              type: 'POST',
              url: "<?=base_url('season/active')?>",
              data: "id=" + id + "&status=" + status,
              dataType: "html",
              success: function(data) {
                  if(data == 'Success') {
                      toastr["success"]("Success")
                      toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "500",
                        "hideDuration": "500",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                  } else {
                      toastr["error"]("Error")
                      toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "500",
                        "hideDuration": "500",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                  }
              }
          });
      }
  }); 
  
  /*$("#airlinecode").autocomplete({
	   source : function( request, response ) {
                $.ajax({
                    url: "<?=base_url('season/searchAirlineCode')?>",
                    dataType: "json",
					type: 'GET',
                    data: {
                        search: request.term
                    },
                    success: function (data) {                    
					   response( $.map( data, function( item ) {						   
							  return {								
								label: item['search']  						       
							  }					  
					  })); 
                    }
                });
            },
    minLength: 0,
	'select': function(event, ui) {
       $('#airlinecode').val(ui.item.label);
        
        return false; // Prevent the widget from inserting the value.
    }
	
   });*/
</script>
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
        });
    });
</script>
<!-- form script -->
<script>
$("#ams_season_start_date").datepicker({
    onSelect: function(dateText) {
       	var dateinfo = this.value.split('/');
		console.log(dateinfo[2]+','+dateinfo[0]+','+dateinfo[1]);
		$("#ams_season_end_date").datepicker("setDate", new Date(dateinfo[2],dateinfo[0],dateinfo[1]) );
    }
});
$("#ams_season_end_date").datepicker();

$('#season_color').colorpicker({});

$( ".select2" ).select2({closeOnSelect:false,
		         placeholder: " value"});
				 
$(document).ready(function(){
    // $('#color_airline_season').trigger('change');	
	// $("#ams_orig_levelID").trigger('change');
    // $('#ams_dest_levelID').trigger('change');
    // $('#origID').trigger('change');
    // $('#destID').trigger('change');	
	// var orig_level = [<?php echo implode(',',$this->input->post("ams_orig_level_value")); ?>];
	// $('#ams_orig_level_value').val(orig_level).trigger('change');
	// var dest_level = [<?php echo implode(',',$this->input->post("ams_dest_level_value")); ?>];
	// $('#ams_dest_level_value').val(dest_level).trigger('change');
	
	// var origValues = [<?php echo implode(',',$this->input->post("origValues")); ?>];
	// $('#origValues').val(origValues).trigger('change');
	// var destValues = [<?php echo implode(',',$this->input->post("destValues")); ?>];
	// $('#destValues').val(destValues).trigger('change');	
	
	// $("input[name=is_return_inclusive][value=0]").attr('checked', 'checked');
});
			
$("#orig_all").click(function(){
    if($("#orig_all").is(':checked') ){
        $("#ams_orig_level_value > option").prop("selected","selected");
        $("#ams_orig_level_value").trigger("change");
    }else{
        $("#ams_orig_level_value > option").removeAttr("selected");
         $("#ams_orig_level_value").trigger("change");
     }
});

$("#dest_all").click(function(){
    if($("#dest_all").is(':checked') ){
        $("#ams_dest_level_value > option").prop("selected","selected");
        $("#ams_dest_level_value").trigger("change");
    }else{
        $("#ams_dest_level_value > option").removeAttr("selected");
         $("#ams_dest_level_value").trigger("change");
     }
});

//reset form
function form_reset(){    
	var $inputs = $('#season_form :input:not(:radio)'); 
	$inputs.each(function (index)
	{
		$(this).val(""); 
		$(this).parent().removeClass('has-error'); 		  
	});
	$("#airlineID").removeAttr("selected");
	$('#airlineID').trigger('change');
	$("#orig_all").removeAttr("checked");
	$("#dest_all").removeAttr("checked");
	$("#ams_orig_levelID").removeAttr("selected");
	$("#global_seasonID").removeAttr("global_seasonID");
	$('#ams_orig_levelID').trigger('change');	   
	$("#ams_dest_levelID").removeAttr("selected");
	$('#ams_dest_levelID').trigger('change');
	$("input[name=is_return_inclusive][value=0]").attr('checked', 'checked');	   
}
//save season form data
function saveseason() {
	$.ajax({
		async: false,
		type: 'POST',
		url: "<?=base_url('season/save')?>",          
		data: {"airlineID" :$('#airlineID').val(),
			"season_name":$('#season_name').val(),
			"global_seasonID":$('#global_seasonID').val(),
			"ams_orig_levelID":$('#ams_orig_levelID').val(),
			"ams_orig_level_value":$('#ams_orig_level_value').val(),
			"ams_dest_levelID":$('#ams_dest_levelID').val(),
			"ams_dest_level_value":$('#ams_dest_level_value').val(),
			"ams_season_start_date":$('#ams_season_start_date').val(),
			"ams_season_end_date":$('#ams_season_end_date').val(),
			"season_color":$('#season_color').val(),
			"is_return_inclusive":$('input[type=radio][name=is_return_inclusive]:checked').val(),
			"desc":$('#desc').val(),				
			"season_id":$('#season_id').val()},
		dataType: "html",                     
		success: function(data) {
		var seasoninfo = jQuery.parseJSON(data);
		var status = seasoninfo['status'];			
		if (status == 'success' ) {				
			alert("Successfully Saved..!");
			form_reset();
			location.reload();
			$("#seasonslist").dataTable().fnDestroy();
			loaddatatable();				
			$("#calendar1").datepicker("destroy");
			seasoncalender(JSON.stringify(seasoninfo['season_list']));
				if (seasoninfo['has_reconf_perm']) {
				<?php
				$link = '<h2><a href="'.base_url('trigger/season_trigger').'" class="btn btn-danger"> <i class="fa fa-plus"></i> '.$this->lang->line('generate_map_table').' </a></h2>';   ?>

				$('#season_reconfigure').html('<?php echo $link?>');
					}
		} else {				
			alert($(status).text());
			$.each(seasoninfo['errors'], function(key, value) {
				if(value != ''){					 
							$('#' + key).parent().addClass('has-error'); 
				}                  				
			});				
		}
		}
	});
}
   
$('#season-form').on('keyup change', function () {       
	$(this).parent().removeClass('has-error');
});
   
function editseason(season_id) {
      var isVisible = $( "#seasonAdd" ).is( ":visible" );
      var isHidden = $( "#seasonAdd" ).is( ":hidden" );
	   if( isVisible == false ) {
		  $( "#add_season_button" ).trigger( "click" );
		}       
       $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('season/getSeasonData')?>",          
          data: {"season_id":season_id},
          dataType: "html",                     
          success: function(data) {
                var seasoninfo = jQuery.parseJSON(data);
				//$('#btn_txt').text('Edit Season');				
				$('#airlineID').val(seasoninfo['airlineID']);
				$('#airlineID').trigger('change');
				$('#season_name').val(seasoninfo['season_name']);
				$('#global_seasonID').val(seasoninfo['global_seasonID']);
				$('#global_seasonID').trigger('change');
				$('#season_color').val(seasoninfo['season_color']);
				$('#ams_orig_levelID').val(seasoninfo['ams_orig_levelID']);
				$('#ams_orig_levelID').trigger('change');
				var orig_level = seasoninfo['ams_orig_level_value'].split(',');
					$('#ams_orig_level_value').val(orig_level).trigger('change');
				$('#ams_dest_levelID').val(seasoninfo['ams_dest_levelID']);
				$('#ams_dest_levelID').trigger('change');
			    var dest_level = seasoninfo['ams_dest_level_value'].split(',');
				$('#ams_dest_level_value').val(dest_level).trigger('change'); 
				//$('#ams_season_start_date').val(seasoninfo['ams_season_start_date']);
				//$('#ams_season_end_date').val(seasoninfo['ams_season_end_date']);
				sdate = seasoninfo['ams_season_start_date'].split("-");
				edate = seasoninfo['ams_season_end_date'].split("-");
				
                $("#ams_season_start_date").datepicker("setDate", new Date(sdate[1]+"-"+sdate[0]+"-"+sdate[2]));
			
				$("#ams_season_end_date").datepicker("setDate", new Date(edate[1]+"-"+edate[0]+"-"+edate[2]));
							
				$("input[name=is_return_inclusive][value=" + seasoninfo['is_return_inclusive'] + "]").attr('checked', 'checked');				
				//console.log($('input[type=radio][name=is_return_inclusive]:checked').val());
				$('#season_id').val(seasoninfo['VX_aln_seasonID']);
         }
	 });
}

//load seasons data
function loaddatatable(){
	$('#seasonslist').DataTable( {
	"bProcessing": true,
	"bServerSide": true,
	"initComplete": function (settings, json) {  
		$("#seasonslist").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	},
	"sAjaxSource": "<?php echo base_url('season/server_processing'); ?>", 
	"fnServerData": function ( sSource, aoData, fnCallback, oSettings ) { 
	aoData.push(
	{"name": "seasonID","value": $("#seasonID").val()},
	{"name": "global_seasonID","value": $("#global_seasonID").val()},
	{"name": "origID","value": $("#origID").val()},
	{"name": "active","value": $("#active").val()},	  
	{"name": "destID","value": $("#destID").val()},
	{"name": "origValues","value": $("#origValues").val()},	  
	{"name": "destValues","value": $("#destValues").val()},
	// {"name": "airlinecode","value": $("#airlinecode").val()}),
	{"name": "filter_airline","value": $("#filter_airline").val()}),	  
	//pushing custom parameters
			oSettings.jqXHR = $.ajax( {
				"dataType": 'json',
				"type": "GET",
				"url": sSource,
				"data": aoData,
				"success": fnCallback
			} ); },	  
	"columns": [{"data": "chkbox" },
				{"data": "airline_code" },
				{"data": "season_name" },
				{"data": "global_season" },
				// {"data": "airline_name" },
				{"data": "orig_level" },
				{"data": "orig_level_values" },
				{"data": "dest_level" }, 
				{"data": "dest_level_values"},
				{"data": "ams_season_start_date" },
				{"data": "ams_season_end_date" },
				{"data": "is_return_inclusive" },
				{"data": "season_color"},
			<?php if (permissionChecker('season_edit')){ ?>
				{"data": "active"},
			<?php } if(permissionChecker('season_edit') || permissionChecker('season_delete')){ ?>
				{"data": "action"}
			<?php } ?>
				],			     
	dom: 'B<"clear">lfrtip',
	//buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
	buttons: [{text: 'Delete',
				action: function ( e, dt, node, config ) {
					if( $('.deleteRow:checked').length > 0 ){  // at-least one checkbox checked
					var ids = [];
					$('.deleteRow').each(function(){
						if($(this).is(':checked')) { 
							ids.push($(this).val());
						}
					});
					var ids_string = ids.toString();  // array to string conversion 
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('season/delete_season_bulk_records'); ?>",
						data: {data_ids:ids_string},
						success: function(result) {
						//var seasoninfo = jQuery.parseJSON(result);
							$('#seasonslist').DataTable().ajax.reload();
							
							$('#bulkDelete').prop("checked",false);
							$("#calendar1").datepicker("destroy");
							seasoncalender(JSON.stringify(result['seasonslist']));
						},
						async:false
					});
				}
				}
			},
			{ extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
			{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
			{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
			{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
			{ text: 'Export All', exportOptions: { columns: ':visible' },
					action: function(e, dt, node, config) {
						$.ajax({
							url: "<?php echo base_url('season/server_processing'); ?>?page=all&&export=1",
							type: 'get',
							data: {sSearch: $("input[type=search]").val(),"seasonID": $("#seasonID").val(),"filter_global_seasonID": $("#filter_global_seasonID").val(),"origID": $("#origID").val(),"active": $("#active").val(),"destID": $("#destID").val(),"airlinecode": $("#airlinecode").val(),"origValues": $("#origValues").val(),"destValues": $("#destValues").val()},
							dataType: 'json'
						}).done(function(data){
					var $a = $("<a>");
					$a.attr("href",data.file);
					$("body").append($a);
					$a.attr("download","season.xls");
					$a[0].click();
					$a.remove();
					});
					}
				}	                
		] 
// "autoWidth": false,
//"columnDefs": [ {"targets": 0,"width": "50px"},{"targets":2,"width":"73px"},{"targets":4,"width":"100px"},{"targets":5,"width":"94px"},{"targets":6,"width":"133px"},{"targets":7,"width":"93px"}]
});
}

$(document).ready(function () {
	$("#bulkDelete").on('click',function() { // bulk checked
			var status = this.checked;
			$(".deleteRow").each( function() {
			if(status == 1 && $(this).prop('checked')) {
					
			} else {
					if (status == false && $(this).prop('checked') == false) {

					} else {
							$(this).prop("checked",status);
							$(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
					}
			}
			});
		});



	$('#deleteTriger').on("click", function(event){ // triggering delete one by one
			if( $('.deleteRow:checked').length > 0 ){  // at-least one checkbox checked
				var ids = [];
				$('.deleteRow').each(function(){
					if($(this).is(':checked')) { 
						ids.push($(this).val());
					}
				});
				var ids_string = ids.toString();  // array to string conversion 
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('season/delete_season_bulk_records'); ?>",
					data: {data_ids:ids_string},
					success: function(result) {
					$('#seasonslist').DataTable().ajax.reload();
					$('#bulkDelete').prop("checked",false);
					},
					async:false
				});
			}
		}); 



	$('#seasonslist').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });
});
</script>
