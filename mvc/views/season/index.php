<div class="seasons">
	<p class="card-header" data-toggle="collapse" data-target="#seasonAdd"><button type="button" class="btn btn-danger pull-right" data-placement="left" title="Add Season" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
	<div class="table-responsive col-md-12 collapse" id="seasonAdd">
		<form class="form-horizontal" action="#">
			<div class="col-md-8 col-md-offset-2">
				<label class="control-label col-md-3">Season Name</label>
				<div class="col-md-9">
					<input type="text" class="form-control" id="season-name">
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-bordered">
					<thead>
						<th>Origin Market</th>
						<th>Destination Market</th>
						<th>Date Range</th>
						<th>Return Inclusive</th>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="col-md-6">
									<p>
										<span>Content</span>
										<select class="form-control" id="inc-level">
											<option>level</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</p>
								</div>
								<div class="col-md-6">
									<p>
										<span>Level</span>
										<select class="form-control" id="inc-level">
											<option>level</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</p>
								</div>
							</td>
							<td>
								<div class="col-md-6">
									<p>
										<span>Content</span>
										<select class="form-control" id="inc-level">
											<option>level</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</p>
								</div>
								<div class="col-md-6">
									<p>
										<span>Level</span>
										<select class="form-control" id="inc-level">
											<option>level</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</p>
								</div>
							</td>
							<td>
								<div class="col-md-6">
									<p>
										<span>Effective</span>
										<select class="form-control" id="inc-level">
											<option>level</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</p>
								</div>
								<div class="col-md-6">
									<p>
										<span>Discontinue</span>
										<select class="form-control" id="inc-level">
											<option>level</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</p>
								</div>
							</td>
							<td>
								<label class="radio-inline">
									<input type="radio" name="optradio">Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="optradio">No
								</label>
							</td>	
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
					<a href="#" type="button" class="btn btn-danger">Save</a>
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