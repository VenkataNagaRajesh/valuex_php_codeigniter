<div class="seasons">
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:96%;">Seasons</h2>
	<p class="card-header" data-toggle="collapse" data-target="#seasonAdd"><button type="button" id = 'add_season_button' class="btn btn-danger pull-right" style="margin:1px 0;" data-placement="left" title="Add Season" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
	<div class="col-md-12 season-add-box collapse" id="seasonAdd">
		<form class="form-horizontal" action="#">
			<div class="form-group">
				<div class="row">
					<div class="col-md-3 select-form">
						<div class="col-md-12">
							<input type="text" class="form-control"  placeholder="Enter Name" id="season_name" name="season_name" value="<?=set_value('season_name')?>">
						</div>
						<div class="col-md-12">
							<?php
								$airlinelist[0]=$this->lang->line("season_select_airline");
								 foreach($airlines as $airline){
									$airlinelist[$airline->vx_aln_data_defnsID] = $airline->airline_name;
								  }							
								echo form_dropdown("airlineID", $airlinelist,set_value("airlineID"), "id='airlineID' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
					</div>
					<div class="col-md-3 select-form">
						<div class="col-md-12">
							<?php
								 $orglevels[0]=$this->lang->line("season_orig_level_select");
								 foreach($types as $level){
									 $orglevels[$level->vx_aln_data_typeID] = $level->alias;
								 }							
								echo form_dropdown("ams_orig_levelID", $orglevels,set_value("ams_orig_levelID"), "id='ams_orig_levelID' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
						<div class="col-md-12">
							<div class="col-md-10" style="padding:0;">
								<select name="ams_orig_level_value[]" id="ams_orig_level_value" class="form-control select2" multiple="multiple">
								</select>
							</div>
							<div class="col-md-2">
								<input type="checkbox" id="orig_all" title="Select All" data-toggle="tooltip" data-placement="top">
							</div>
						</div>
					</div>
					<div class="col-md-3 select-form">
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
							<div class="col-md-10" style="padding:0;">
								<select name="ams_dest_level_value[]" id="ams_dest_level_value" class="form-control select2 col-md-10" multiple="multiple">
							</select>	
							</div>
							<div class="col-md-2">
								<input type="checkbox" id="dest_all" title="Select All" data-toggle="tooltip" data-placement="top">
							</div>	
						</div>
					</div>
					<div class="col-md-3">
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
				</div>
				<div class="row">
					<div class="col-md-3">
						<label class="control-label col-md-3">Color</label>
						<div class="col-md-9">
							<input type="color" class="form-control" id="season_color" name="season_color" value="<?=set_value('season_color')?>" >
						</div>
					</div>
					<div class="col-md-4">
						<label class="control-label col-md-5">Return Inclusive</label>
						<div class="col-md-7">
							<label class="radio-inline">
								<input type="radio" name="is_return_inclusive" value="1" <?=set_value('is_return_inclusive')?> >Yes
							</label>
							<label class="radio-inline" style="margin-left: 0px;">
								<input type="radio" name="is_return_inclusive" value="0"  <?=set_value('is_return_inclusive')?> >No
							</label>
							<input type="hidden" class="form-control" id="season_id" name="season_id"   value="" >	
						</div>
					</div>
					<div class="col-md-5">
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
		<p>
	      <?php if( isset ($reconfigure) && permissionChecker('season_reconfigure')) {?>
                   <a href="<?php echo base_url('trigger/season_trigger') ?>" class="btn btn-danger">
                       <i class="fa fa-plus"></i>
                       <?=$this->lang->line('generate_map_table')?>
                   </a>
           <?php } ?>
		</p>
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="season-form">		   
			<div class='form-group'>			 
				<div class="col-sm-2">			   
				<?php $slist = array("0" => " Season");               
				   foreach($seasonslist as $season){
					  $slist[$season->VX_aln_seasonID] = $season->season_name;
					}							
				   echo form_dropdown("seasonID", $slist,set_value("seasonID",$seasonID), "id='seasonID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-sm-2">			   
				  <input type="text" name="airlinecode" id="airlinecode" placeholder="Carrier code_name" class="form-control" value="<?=set_value('airlinecode',$airlinecode)?>"/>
				</div>
				<div class="col-sm-2">			   
				  <?php $olist = array("0" => " Origin Level");               
				  foreach($types as $type){
					  $olist[$type->vx_aln_data_typeID] = $type->alias;
					}							
				  echo form_dropdown("origID", $olist,set_value("origID",$origID), "id='origID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>                				
				<div class="col-sm-2">
					<?php $dlist = array("0" => " Destination");               
				   foreach($types as $type){
					  $dlist[$type->vx_aln_data_typeID] = $type->alias;
					}							
				  echo form_dropdown("destID", $dlist,set_value("destID",$destID), "id='destID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-sm-2">
					<?php $activestatus[1]="Active";	$activestatus[0]="In Active";				
				  echo form_dropdown("active", $activestatus,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-sm-2">
				  <button type="submit" class="btn btn-danger" name="filter" id="filter">Search</button> <button data-toggle="collapse" data-target="#seasonList" type="button" class="btn btn-danger"><i class="fa fa-table"></i> View</button>
				</div>			
			</div>
		</form>
		<div id="seasonList"  class="collapse">
			<div id="hide-table">
				<table id="seasonslist" class="table table-striped table-bordered table-hover dataTable no-footer" style="width:100%;">
					<thead>
						<tr>
							<th class="col-lg-1" colspan="3"><?=$this->lang->line('slno')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_name')?></th>
							<!--<th class="col-lg-1"><?=$this->lang->line('season_airline')?></th>-->
							<th class="col-lg-1"><?=$this->lang->line('season_airline_code')?></th>
							<th class="col-lg-1"><?=$this->lang->line('orig_level')?></th>
							<th class="col-lg-1"><?=$this->lang->line('orig_level_value')?></th>
							<th class="col-lg-1"><?=$this->lang->line('dest_level')?></th>
							<th class="col-lg-1"><?=$this->lang->line('dest_level_value')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_start_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_end_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('is_return_inclusive')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_color')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season_active')?></th>
							<?php if(permissionChecker('season_edit') || permissionChecker('season_delete')) { ?>
							<th class="col-lg-2"><?=$this->lang->line('action')?></th>
							   <?php } ?>
						  </tr>
					   </thead>
					   <tbody>                            
					   </tbody>
				   </table>
			  </div>
		  </div>
	</div>
	<div class="col-md-12 cal-table">
		<div class="col-md-8" style="padding:0;">
			<div id="calendar1" class="cal-box"></div>
		</div>
		<div class="col-md-4">
			<div class="season-highlight">
				<p><select style="width:85%;" name="color_season" id="color_airline_season" class="form-control">
				 <option value="0">Airlines</option>
				 <?php foreach($airlines as $airline){
                  echo '<option value="'.$airline->vx_aln_data_defnsID.'">'.$airline->airline_name.'</option>';  
				 } ?>
				</select></p>
				<p>
					<span>Season</span><span>Highlights</span><br>
					<!--<span class="default">Default</span><span class="default-high">&nbsp;</span><br>
					<span class="default">Summer Peak</span><span class="summer-high">&nbsp;</span><br>
					<span class="default">Christmas Peak</span><span class="christ-high">&nbsp;</span>-->
					<?php foreach($seasonslist as $season) { ?>
					<span class="default"><?=$season->season_name?></span><span style="background: <?=$season->season_color?>;">&nbsp;</span>
					<?php } ?>
				</p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {	
	seasoncalender('<?php echo json_encode($seasonslist)?>');
	//alert('<?php echo json_encode($seasonslist)?>');
	

});

function seasoncalender (seasonlist = '[]') {
	var season_data = jQuery.parseJSON(seasonlist);

        // An array of dates
     var eventDates = {}; var season = {}; var name = {};


	
	 //$_POST['color_season']=10; 
             for(var i=0; i<season_data.length; i++){
		for ( var k=0 ; k<season_data[i]['dates'].length; k++){	
	       eventDates[ new Date( season_data[i]['dates'][k] )] = new Date( season_data[i]['dates'][k] ).toString();
		    season[ new Date( season_data[i]['dates'][k] )] = season_data[i]['VX_aln_seasonID'];
			name[ new Date( season_data[i]['dates'][k] )] = season_data[i]['season_name'] ;
			 
	   } 
	    $("<style> .season"+season_data[i]['VX_aln_seasonID'] + " { color:#fffff !important;  background:"+season_data[i]['season_color'] + " !important;} </style>").appendTo("head");
     }   
    //console.log(event);
       
        jQuery('#calendar1').datepicker({		    
           // changeMonth: true,
           // changeYear: true,
            numberOfMonths: [3,4],            			
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
	

$('#color_airline_season').change(function(event) {    
	//alert('here');
	var airline_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('season/getSeasonsForAirline')?>",            
             data: "id=" + airline_id,            
             dataType: "html",                                  
             success: function(data) {               
		$("#calendar1").datepicker("destroy");
		seasoncalender(data);
              }        
      });       
});
 



  
</script>
<script>
$(document).ready(function() {	 
    $('#seasonslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('season/server_processing'); ?>", 
	  "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) { 
      aoData.push(
	  {"name": "seasonID","value": $("#seasonID").val()},
	  {"name": "origID","value": $("#origID").val()},
      {"name": "active","value": $("#active").val()},	  
	  {"name": "destID","value": $("#destID").val()},
	  {"name": "airlinecode","value": $("#airlinecode").val()}),     
	  //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); },	  
      "columns": [{"data": "VX_aln_seasonID" },
                  {"data": "season_name" },
				 // {"data": "airline_name" },
				  {"data": "airline_code" },
				  {"data": "orig_level" },
				  {"data": "orig_level_values" },
				  {"data": "dest_level" }, 
                  {"data": "dest_level_values"},
				  {"data": "ams_season_start_date" },
				  {"data": "ams_season_end_date" },
				  {"data": "is_return_inclusive" },
				  {"data": "season_color"},
                  {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
  }); 
  
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
  
  $("#airlinecode").autocomplete({
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
	
   });
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
$("#ams_season_start_date").datepicker();
$("#ams_season_end_date").datepicker();

$('#season_color').colorpicker({});

$( ".select2" ).select2({closeOnSelect:false,
		         placeholder: " value"});
				 
$(document).ready(function(){
	$('#ams_orig_levelID').trigger('change');
    $('#ams_dest_levelID').trigger('change');	
	var orig_level = [<?php echo implode(',',$this->input->post("ams_orig_level_value")); ?>];
	$('#ams_orig_level_value').val(orig_level).trigger('change');
	var dest_level = [<?php echo implode(',',$this->input->post("ams_dest_level_value")); ?>];
	$('#ams_dest_level_value').val(dest_level).trigger('change');  
	//$("input[name=is_return_inclusive][value=1]").attr('checked', 'checked');
});

$('#ams_orig_levelID').change(function(e){
	$(this).parent().removeClass('has-error');
	$('#ams_orig_level_value').val(null).trigger('change')
     var level_id = $(this).val();                 
    $.ajax({ 
             async: false,            
	         type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
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
    $.ajax({ 
             async: false,            
	         type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
               $('#ams_dest_level_value').html(data);
			 }        
      }); 
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

  function form_reset(){    
	  var $inputs = $('#season_form :input'); 
	  $inputs.each(function (index)
       {
          $(this).val("");  
       });
	   $("#airlineID").removeAttr("selected");
	   $('#airlineID').trigger('change');
	   $("#orig_all").removeAttr("checked");
	   $("#dest_all").removeAttr("checked");
       $("#ams_orig_levelID").removeAttr("selected");
	   $('#ams_orig_levelID').trigger('change');	   
	   $("#ams_dest_levelID").removeAttr("selected");
	   $('#ams_dest_levelID').trigger('change');	   
  }

    function saveseason() {
      $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('season/save')?>",          
          data: {"airlineID" :$('#airlineID').val(),
			    "season_name":$('#season_name').val(),
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
				alert(status);
				form_reset();
				$("#seasonslist").dataTable().fnDestroy();
				loaddatatable();
				$("#calendar1").datepicker("destroy");
				seasoncalender(JSON.stringify(seasoninfo['season_list']));

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
				$('#btn_txt').text('Edit Season');				
				$('#airlineID').val(seasoninfo['airlineID']);
				$('#airlineID').trigger('change');
				$('#season_name').val(seasoninfo['season_name']);
				$('#season_color').val(seasoninfo['season_color']);
				$('#ams_orig_levelID').val(seasoninfo['ams_orig_levelID']);
				$('#ams_orig_levelID').trigger('change');
				var orig_level = seasoninfo['ams_orig_level_value'].split(',');
					$('#ams_orig_level_value').val(orig_level).trigger('change');
				$('#ams_dest_levelID').val(seasoninfo['ams_dest_levelID']);
				$('#ams_dest_levelID').trigger('change');
			    var dest_level = seasoninfo['ams_dest_level_value'].split(',');
				$('#ams_dest_level_value').val(dest_level).trigger('change'); 
				$('#ams_season_start_date').val(seasoninfo['ams_season_start_date']);
				$('#ams_season_end_date').val(seasoninfo['ams_season_end_date']);
							
				$("input[name=is_return_inclusive][value=" + seasoninfo['is_return_inclusive'] + "]").attr('checked', 'checked');				
				
				$('#season_id').val(seasoninfo['VX_aln_seasonID']);
         }
	 });
}
   
   function loaddatatable(){
	   $('#seasonslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('season/server_processing'); ?>", 
	  "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) { 
      aoData.push(
	  {"name": "seasonID","value": $("#seasonID").val()},
	  {"name": "origID","value": $("#origID").val()},
      {"name": "active","value": $("#active").val()},	  
	  {"name": "destID","value": $("#destID").val()},
	  {"name": "airlinecode","value": $("#airlinecode").val()}),     
	  //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); },	  
      "columns": [{"data": "VX_aln_seasonID" },
                  {"data": "season_name" },
				 // {"data": "airline_name" },
				  {"data": "airline_code" },
				  {"data": "orig_level" },
				  {"data": "orig_level_values" },
				  {"data": "dest_level" }, 
                  {"data": "dest_level_values"},
				  {"data": "ams_season_start_date" },
				  {"data": "ams_season_end_date" },
				  {"data": "is_return_inclusive" },
				  {"data": "season_color"},
                  {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    }); 
   }
</script>
