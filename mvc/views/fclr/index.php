<div class="fclr-bar">
	<!--<p class="card-header" data-toggle="collapse" data-target="#fclrAdd"><button type="button" class="btn btn-danger pull-right" data-placement="left" title="Add FCLR" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
	<div class="col-md-12 fclr-table-add collapse" id="fclrAdd">
		<form class="form-horizontal" action="#">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<th>Board Point</th>
						<th>Off Point</th>
						<th>Season</th>
						<th>Carrier</th>
						<th>Flight Number</th>
						<th>Frequency</th>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php
									$airports['0'] = 'Select Board Point';
									ksort($airports);
									echo form_dropdown("board_point", $airports,set_value("board_point"), "id='board_point' class='form-control hide-dropdown-icon select2'");
                                ?>
							</td>
							<td>
								 <?php
									$airports['0'] = 'Select Off Point';
									ksort($airports);
									echo form_dropdown("off_point", $airports,set_value("off_point"), "id='off_point' class='form-control hide-dropdown-icon select2'");
                                 ?>
							</td>
							<td>
								<?php 
									$seasons[0] = 'Select Seasons';
									ksort($seasons);
									echo form_dropdown("season_id", $seasons,set_value("season_id"), "id='season_id' class='form-control hide-dropdown-icon select2'");  
                                 ?>
							</td>
							<td>
								 <?php
									$carrier[0] = 'Select Carrier';
									ksort($carrier);
									echo form_dropdown("carrier_code", $carrier,set_value("carrier_code"), "id='carrier_code' class='form-control hide-dropdown-icon select2'");
                                  ?>
							</td>
							<td>
								<input type="text" class="form-control" id="flight_number" name="flight_number" value="<?=set_value('flight_number')?>" >
							</td>
							<td>
								<?php
									$days[0] = 'Select Frequency';
									ksort($days);
									echo form_dropdown("frequency", $days, set_value("frequency"), "id='frequency' class='form-control hide-dropdown-icon select2'");

								?>  
							</td>
						</tr>
					</tbody>
					<thead>
						<th>From Cabin</th>
						<th>To Cabin</th>
						<th>Minimum </th>
						<th>Maximum</th>
						<th>Average</th>
						<th>Slider Position</th>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php
									$cabins['0'] = 'Select From Cabin';
									ksort($cabins);
									echo form_dropdown("upgrade_from_cabin_type", $cabins,set_value("upgrade_from_cabin_type"), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'");

								?>     
							</td>
							<td>
								 <?php
									$cabins['0'] = 'Select To Cabin';
									ksort($cabins);
									echo form_dropdown("upgrade_to_cabin_type", $cabins,set_value("upgrade_to_cabin_type"), "id='upgrade_to_cabin_type' class='form-control hide-dropdown-icon select2'");

								?> 
							</td>
							<td>
								<input type="text" class="form-control" id="min" name="min" value="<?=set_value('min')?>" >
							</td>
							<td>
								 <input type="text" class="form-control" id="max" name="max" value="<?=set_value('max')?>" >
							</td>
							<td>
								<input type="text" class="form-control" id="avg" name="avg" value="<?=set_value('avg')?>" >
							</td>
							<td>
								<input type="text" class="form-control" id="slider_start" name="slider_start" value="<?=set_value('slider_start')?>" >
							</td>
						</tr>
					</tbody>
				</table>
				<div class="col-md-2 pull-right">
					<span><button type="submit" class="btn btn-danger" name="add" id="add">Add</button></span>
					<span><button type="submit" class="btn btn-danger" name="add" id="add">Save</button></span>
				</div>
			</div>
		</form>
	</div>-->
	<div class="col-md-12 table-responsive">
		<form class="form-horizontal" action="#">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<th>Flight No Range</th>
						<th>Departure Date</th>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="col-md-6">
									<?php $airport['0'] = 'Select Boarding Point';
										ksort($airport);
										echo form_dropdown("boarding_point", $airport,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>

								</div>
								<div class="col-md-6">
									<?php $airport['0'] = 'Select Off Point';
										ksort($airport);
										echo form_dropdown("off_point", $airport,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>
								</div>
							</td>
							<td>
								<div class="col-md-6">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Enter Dep From date" id="dep_from_date" name="dep_from_date" value="<?=set_value('dep_from_date',$dep_from_date)?>" >
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									 </div>
								</div>
								<div class="col-md-6">
									 <div class="input-group">
										<input type="text" class="form-control" placeholder="Enter Dep To date" id="dep_to_date" name="dep_to_date" value="<?=set_value('dep_to_date',$dep_to_date)?>" >
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									 </div>
								</div>
							</td>	
						</tr>
					</tbody>
				</table>
				<table class="table">
					<thead>
						<th>City</th>
						<th>Market</th>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="col-md-6">
									<select class="form-control" id="inc-level">
										<option>Origin</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
									</select>
								</div>
								<div class="col-md-6">
									<select class="form-control" id="inc-level">
										<option>Dest</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
									</select>
								</div>
							</td>
							<td>
								<div class="col-md-6">
									<select class="form-control" id="inc-level">
										<option>Origin</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
									</select>
								</div>
								<div class="col-md-6">
									<select class="form-control" id="inc-level">
										<option>Dest</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
									</select>
								</div>
							</td>	
						</tr>
					</tbody>
				</table>
				<table class="table">
					<thead>
						<th>Frequency</th>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="col-md-6">
									<input type="text" class="form-control" id="frequency" placeholder="Enter Frequency">
								</div>
								<div class="col-sm-2">
									<button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
								</div>
							</td>							
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>
	<div class="col-md-12 fclr-table">
		<div id="hide-table" class="fclr-table-data">
             <table id="rafeedtable" class="table table-striped table-bordered dataTable no-footer">
                 <thead>
					<tr>
						<th class="col-lg-1"><?=$this->lang->line('slno')?></th>
						<th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
						<th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
						<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
						<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
						<th class="col-lg-1"><?=$this->lang->line('season')?></th>
						<th class="col-lg-1"><?=$this->lang->line('start_date')?></th>
						<th class="col-lg-1"><?=$this->lang->line('end_date')?></th>
						<th class="col-lg-1"><?=$this->lang->line('day_of_week')?></th>
						<th class="col-lg-1"><?=$this->lang->line('from_cabin')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('to_cabin')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('avg')?></th>
						<th class="col-lg-1"><?=$this->lang->line('min')?></th>
						<th class="col-lg-1"><?=$this->lang->line('max')?></th>
						<th class="col-lg-1"><?=$this->lang->line('slider_start')?></th>
						<th class="col-lg-1"><?=$this->lang->line('fclr_status')?></th>
                        <th class="col-lg-2"><?=$this->lang->line('action')?></th>
                    </tr>
                 </thead>
                 <tbody>                          
                 </tbody>
              </table>
         </div>
	</div>
</div>
<script>
 $(document).ready(function() {	 
	
$("#dep_from_date").datepicker();
$("#dep_to_date").datepicker();

    $('#rafeedtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('fclr/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#flight_number").val()},
		  {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#off_point").val()},
		    {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
		  {"name": "fromCabin","value": $("#from_cabin").val()},
                   {"name": "toCabin","value": $("#to_cabin").val()},
                  
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [ {"data": "fclr_id" },
		   {"data": "source_point" },
	           {"data": "dest_point" },
		   {"data": "carrier_code" },
		   {"data": "flight_number" },
		   {"data": "season_id" },
		   {"data": "start_date" },
		   {"data": "end_date" },
		   {"data": "day_of_week" },
		   {"data": "fcabin" },
		   {"data": "tcabin" },
		   {"data": "average" },
                   {"data": "min" },
		  {"data": "max" },
		 {"data": "slider_start" },
		 {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
	
	
  });
 
  
   $('#rafeedtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#rafeedtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('fclr/active')?>",
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
$( ".select2" ).select2();
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