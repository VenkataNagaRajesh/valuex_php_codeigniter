<div class="seasons">
	<p class="card-header" data-toggle="collapse" data-target="#seasonAdd"><button type="button" class="btn btn-danger pull-right" data-placement="left" title="Add Season" data-toggle="tooltip"  id='add_season_button'><i class="fa fa-plus"></i></button></p>
	<div class="table-responsive col-md-12 collapse" id="seasonAdd">
		<form class="form-horizontal" action="#">
			<div class="col-md-8 col-md-offset-2">
				<label class="control-label col-md-3">Season Name</label>
				<div class="col-md-9">
					<input type="text" class="form-control"  id="season_name" name="season_name" value="<?=set_value('season_name')?>">
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-bordered">
					<thead>
					    <th>Carrier</th>
						<th>Origin Market</th>
						<th>Destination Market</th>
					</thead>
					<tbody>
						<tr>
						    <td>
							  <div class="col-md-12">
								 <p>
								   <span>Carrier</span>
									 <?php
							            $airlinelist[0]=$this->lang->line("season_select_airline");
						                 foreach($airlines as $airline){
							              $airlinelist[$airline->vx_aln_data_defnsID] = $airline->airline_name;
						             	 }							
						                 echo form_dropdown("airlineID", $airlinelist,set_value("airlineID"), "id='airlineID' class='form-control hide-dropdown-icon select2'"); 
									 ?>
								  </p>
								</div>
							</td>
							<td>
								<div class="col-md-6">
									<p>
										<span>Level</span>
										<?php
											 $orglevels[0]=$this->lang->line("season_orig_level_select");
											 foreach($types as $level){
												 $orglevels[$level->vx_aln_data_typeID] = $level->alias;
											 }							
										   echo form_dropdown("ams_orig_levelID", $orglevels,set_value("ams_orig_levelID"), "id='ams_orig_levelID' class='form-control hide-dropdown-icon select2'"); 
										?>
									</p>
								</div>
								<div class="col-md-6">
									<p>
										<span>Content</span>
										<select name="ams_orig_level_value[]" id="ams_orig_level_value" class="form-control select2" multiple="multiple">
						                </select>
										<span>
											<input type="checkbox" id="orig_all" >Select All
										</span>
									</p>
								</div>
							</td>
							<td>
								<div class="col-md-6">
									<p>
										<span>Level</span>
										 <?php
											 $destlevels[0]=$this->lang->line("season_dest_level_select");
											 foreach($types as $level){
												 $destlevels[$level->vx_aln_data_typeID] = $level->alias;
											 }							
										   echo form_dropdown("ams_dest_levelID", $destlevels,set_value("ams_dest_levelID"), "id='ams_dest_levelID' class='form-control hide-dropdown-icon select2'"); 
										?>
									</p>
								</div>
								<div class="col-md-6">
									<p>
										<span>Content</span>
										<select name="ams_dest_level_value[]" id="ams_dest_level_value" class="form-control select2" multiple="multiple">
						                </select>
										<span>
											<input type="checkbox" id="dest_all" >Select All
										</span>
									</p>
								</div>
							</td>							
						</tr>
					</tbody>
					<thead>					    
						<th>Date Range</th>
						<th>Color</th>
						<th>Return Inclusive</th>
					</thead>
					<tbody>
						<tr>						   
							<td>
								<div class="col-md-6">
									<p>
										<span>Start Date</span>
										<input type="text" class="form-control" id="ams_season_start_date" name="ams_season_start_date" value="<?=set_value('ams_season_start_date')?>" >
									</p>
								</div>
								<div class="col-md-6">
									<p>
										<span>End Date</span>
										<input type="text" class="form-control" id="ams_season_end_date" name="ams_season_end_date" value="<?=set_value('ams_season_end_date')?>" >
									</p>
								</div>
							</td>
							<td>
							  <div class="col-md-12">
								<p>
								   <span>Color</span>
								   <input type="color" class="form-control" id="season_color" name="season_color" value="<?=set_value('season_color')?>" >
								</p> 
							</td>
							<td>
								<label class="radio-inline">
									<input type="radio" name="is_return_inclusive" value="1" <?=set_value('is_return_inclusive')?> >Yes
								</label>
								<label class="radio-inline" style="margin-left: 0px;">
									<input type="radio" name="is_return_inclusive" value="0"  <?=set_value('is_return_inclusive')?> >No
								</label>
							</td>
                            <input type="hidden" class="form-control" id="season_id" name="season_id"   value="" >							
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-8">
				<div class="calendar-box">
					<div id="calendar1" class="col-md-5 cal-box"></div>
					<div id="calendar2" class="col-md-5 cal-box"></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="season-highlight">
					<p>
						<span>Season</span><span>Highlights</span><br>
						<span class="default">Default</span><span class="default-high">&nbsp;</span><br>
						<span class="default">Summer Peak</span><span class="summer-high">&nbsp;</span><br>
						<span class="default">Christmas Peak</span><span class="christ-high">&nbsp;</span>
					</p>
				</div>
			</div>
			<div class="col-md-12">
				<p class="pull-right">
					<a href="#" type="button" class="btn btn-danger" id='btn_txt' onclick="saveseason()">Save</a>
					<a href="#" type="button" class="btn btn-danger">Cancel</a>
				</p>
			</div>
		</form>
	</div>
	<div class="col-md-12 season-table">
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 
				<div class="col-sm-2">			   
				<?php $slist = array("0" => "Select Season");               
				   foreach($seasonslist as $season){
					  $slist[] = $season;
					}							
				   echo form_dropdown("seasonID", $slist,set_value("seasonID",$seasonID), "id='seasonID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>
				<div class="col-sm-2">			   
				  <input type="text" name="airlinecode" id="airlinecode" placeholder="Carrier code_name" class="form-control" value="<?=set_value('airlinecode',$airlinecode)?>"/>
				</div>
				<div class="col-sm-2">			   
				  <?php $olist = array("0" => "Select Origin Level");               
				  foreach($types as $type){
					  $olist[$type->vx_aln_data_typeID] = $type->alias;
					}							
				  echo form_dropdown("origID", $olist,set_value("origID",$origID), "id='origID' class='form-control hide-dropdown-icon select2'");    ?>
				</div>                				
				<div class="col-sm-2">
					<?php $dlist = array("0" => "Select Destination");               
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
				  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Search</button>
				</div>	             				
			</div>
		</form>
        <div id="hide-table">
            <table id="seasonslist" class="table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
					<tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('season_name')?></th>
						<th class="col-lg-1"><?=$this->lang->line('season_airline')?></th>
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
<script type="text/javascript">
    jQuery(document).ready(function() {
        
        // An array of dates
        var eventDates = {};
        eventDates[ new Date( '12/04/2014' )] = new Date( '12/04/2014' );
        eventDates[ new Date( '12/06/2014' )] = new Date( '12/06/2014' );
        eventDates[ new Date( '12/20/2014' )] = new Date( '12/20/2014' );
        eventDates[ new Date( '12/25/2014' )] = new Date( '12/25/2014' );
        
        // datepicker
        jQuery('#calendar1').datepicker({
            beforeShowDay: function( date ) {
                var highlight = eventDates[date];
                if( highlight ) {
                     return [true, "event", highlight];
                } else {
                     return [true, '', ''];
                }
             }
        });
		jQuery('#calendar2').datepicker({
            beforeShowDay: function( date ) {
                var highlight = eventDates[date];
                if( highlight ) {
                     return [true, "event", highlight];
                } else {
                     return [true, '', ''];
                }
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
				  {"data": "airline_name" },
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
		         placeholder: "Select a value"});
				 
$(document).ready(function(){
	$('#ams_orig_levelID').trigger('change');
    $('#ams_dest_levelID').trigger('change');	
	var orig_level = [<?php echo implode(',',$this->input->post("ams_orig_level_value")); ?>];
	$('#ams_orig_level_value').val(orig_level).trigger('change');
	var dest_level = [<?php echo implode(',',$this->input->post("ams_dest_level_value")); ?>];
	$('#ams_dest_level_value').val(dest_level).trigger('change');  
});

$('#ams_orig_levelID').change(function(e){
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
				"is_return_inclusive":$('input[type=radio][name=is_return_inclusive]').val(),
			    "desc":$('#desc').val(),				
			    "season_id":$('#season_id').val()},
         dataType: "html",                     
         success: function(data) {
			var seasoninfo = jQuery.parseJSON(data);
			var status = seasoninfo['status'];			
			if (status == 'success' ) {
				alert(status);
				$("#seasonslist").dataTable().fnDestroy();
				loaddatatable();
			} else {
				alert($(status).text());
			
			}
	     }
     });
   }
   
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
				  {"data": "airline_name" },
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