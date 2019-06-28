<div class="eer">
	<h2 class="title-tool-bar" style="color:#fff;">Eligibility Exclusion Rules</h2>
	<p class="card-header" data-toggle="collapse" data-target="#eerAdd"><button type="button" class="btn btn-danger pull-right" data-placement="left" title="Add Rule" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
	<div class="table-responsive col-md-12 collapse" id="eerAdd">
		<div class="col-md-12"><h2>Rule Criteria</h2></div>
		<form class="form-horizontal" action="#">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label">Exclusion Reason Name</label>
						<input type="text" placeholder="Enter Name" class="form-control" id="desc" name="desc" value="<?=set_value('desc')?>" >
					</div>
					<div class="col-md-3">
						<label class="control-label">Origin & Destination</label>
						<div class="col-md-6">
							<?php
								$marketzones['0'] = 'Select Origin';
								ksort($marketzones);
								echo form_dropdown("orig_market_id", $marketzones,set_value("orig_market_id"), "id='orig_market_id' class='form-control hide-dropdown-icon select2'");?>
						</div>
						<div class="col-md-6">
							 <?php
								$marketzones['0'] = 'Select Dest';
								echo form_dropdown("dest_market_id", $marketzones,set_value("dest_market_id"), "id='dest_market_id' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
					</div>
					<div class="col-md-3">
						<label class="control-label">Carrier</label>
						<?php
							$carriers[0] = 'Select Carrier';
							ksort($carriers);
							  echo form_dropdown("carrier", $carriers,set_value("carrier"), "id='carrier' class='form-control hide-dropdown-icon select2'");?>

					</div>
					<div class="col-md-3">
						<label class="control-label">Flight Effective & Discontinue Date</label>
						<div class="col-md-6">
							<input type="text" placeholder="Effect Date" class="form-control" id="flight_efec_date" name="flight_efec_date" value="<?=set_value('flight_efec_date')?>" >
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="Disc Date" id="flight_disc_date" name="flight_disc_date" value="<?=set_value('flight_disc_date')?>" >
						</diV>
					</div>
					<div class="col-md-3">
						<label class="control-label">Departure Start Time: HRS & Mins</label>
						<div class="col-md-6">
							<?php
								echo form_dropdown("flight_dep_start_hrs", $hrs,set_value("flight_dep_start_hrs"), "id='flight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");?>
						</div>
						<div class="col-md-6">
							 <?php
							 echo form_dropdown("flight_dep_start_mins", $mins,set_value("flight_dep_start_mins"), "id='flight_dep_start_mins' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
					</div>
					<div class="col-md-3">
						<label class="control-label">Departure End Time: HRS & Mins</label>
						<div class="col-md-6">
							<?php
								echo form_dropdown("flight_dep_end_hrs", $hrs,set_value("flight_dep_end_hrs"), "id='flight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");?>
						</div>
						<div class="col-md-6">
							 <?php
								echo form_dropdown("flight_dep_end_mins", $mins,set_value("flight_dep_end_mins"), "id='flight_dep_end_mins' class='form-control hide-dropdown-icon select2'");?>
						</div>
					</div>
					<div class="col-md-3">
						<label class="control-label">Flight Number Start & End</label>
						<div class="col-md-6">
							 <input type="text" class="form-control" placeholder="Start" id="flight_nbr_start" name="flight_nbr_start" value="<?=set_value('flight_nbr_start')?>" >
						</div>
						<div class="col-md-6">
							 <input type="text" class="form-control" placeholder="End" id="flight_nbr_end" name="flight_nbr_end" value="<?=set_value('flight_nbr_end')?>" >
						</div>
					</div>
					<div class="col-md-2">
						<label class="control-label">Frequency</label>
						<?php
							echo form_multiselect("frequency[]", $days_of_week, set_value("frequency"), "id='frequency' class='form-control select2'");  ?>  
					</div>
					<div class="col-md-1">	
						<label class="control-label" style="font-size:10px;padding:5px 3px;">Future Use</label>
						 <?php
							 $toggle[1] = "Yes";
							  $toggle[0] = "No";
							  echo form_dropdown("future_use", $toggle,set_value("future_use",1), "id='future_use' class='form-control hide-dropdown-icon'");?>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="rule-box">
					<div class="col-md-9">
						<ul>
							<!--<li>Rule Action<br>Flights to be considered upgrade offer</li> -->
							<li style="margin-bottom:10em;">Cabin Exclusion</li>
							<!--<li>Cutoff time for offer acceptance</li>-->
						</ul>
					</div>
					<div class="col-md-3">
						<!--<p class="onoffswitch-small" id="1"><input id="myonoffswitch1" class="onoffswitch-small-checkbox" name="paypal_demo" checked="" type="checkbox"><label for="myonoffswitch1" class="onoffswitch-small-label"><span class="onoffswitch-small-inner"></span> <span class="onoffswitch-small-switch"></span> </label></p> --> 
						<div class="cabins">
							<table class="table">
								<tr>
									<td></td>
									<td>Y</td>
									<td>P</td>
									<td>C</td>
									<td>F</td>
								</tr>
								<tr>
									<td>Y</td>
									<td class="block"></td>
									<td><i class="fa fa-check"></i></td>
									<td><i class="fa fa-check"></i></td>
									<td><i class="fa fa-check"></i></td>
								</tr>
								<tr>
									<td>P</td>
									<td class="block"></td>
									<td class="block"></td>
									<td><i class="fa fa-check"></i></td>
									<td><i class="fa fa-check"></i></td>
								</tr>
								<tr>
									<td>C</td>
									<td class="block"></td>
									<td class="block"></td>
									<td class="block"></td>
									<td><i class="fa fa-check"></i></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<span class="col-md-2">
					<a href="#" type="button"  id='btn_txt' class="btn btn-danger">Save</a>
					<a href="#" type="button"  id='btn_txt' class="btn btn-danger">Cancel</a>
				</span>
			</div>
		</form>
	</div>
	<div class="col-sm-12 off-table">
		<div class="col-sm-2">
			<?php
                 foreach($days_of_week as $day ) {
					$days[$day->vx_aln_data_defnsID] = $day->aln_data_value;
                 }
                 echo form_multiselect("day[]", $days, set_value("day"), "id='day' class='form-control select2'"); ?>
		</div>
		<div class="col-sm-2">
			<?php
               $status['-1'] = 'Select Status';
               $status['1'] = 'Active';
               $status['0'] = 'In Active';
               echo form_dropdown("active", $status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");   ?>
		</div>
		<div class="col-sm-2">
             <?php
				$toggle['-1'] = 'Select future use';
                $toggle[1] = "Yes";
                $toggle[0] = "No";
                echo form_dropdown("future_use", $toggle,set_value("future_use",$future_use), "id='future_use' class='form-control hide-dropdown-icon select2'"); ?>
         </div>
         <div class="col-sm-2 filter">
              <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
         </div>
		 <div id="hide-table" class="col-md-12">
              <table id="ruleslist" class="table table-striped table-bordered table-hover dataTable no-footer">
                   <thead>
                       <tr>
							<th class="col-lg-1"><?=$this->lang->line('slno')?></th>
							<th class="col-lg-1"><?=$this->lang->line('desc')?></th>
							<th class="col-lg-1"><?=$this->lang->line('orig_market')?></th>
                            <th class="col-lg-1"><?=$this->lang->line('dest_market')?></th>
							<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_efec_date')?></th>
                            <th class="col-lg-1"><?=$this->lang->line('flight_disc_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_dep_start')?></th>
                            <th class="col-lg-1"><?=$this->lang->line('flight_dep_end')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_nbr_range')?></th>
							<th class="col-lg-1"><?=$this->lang->line('upgrade_from')?></th>
							<th class="col-lg-1"><?=$this->lang->line('upgrade_to')?></th>
							<th class="col-lg-1"><?=$this->lang->line('frequency')?></th>
							<th class="col-lg-1"><?=$this->lang->line('future_use')?></th>
							<th class="col-lg-1"><?=$this->lang->line('rule_status')?></th> 
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

  $('#ruleslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('eligibility_exclusion/server_processing'); ?>",   
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "origID","value": $("#orig_market_id").val()},
                   {"name": "destID","value": $("#dest_market_id").val()},
		   {"name": "day","value": $("#day").val()},
		   {"name": "fromClass","value": $("#from_class").val()},
		   {"name": "toClass","value": $("#to_class").val()},
		    {"name": "nbrStart","value": $("#flight_nbr_start").val()},
                   {"name": "nbrEnd","value": $("#flight_nbr_end").val()},
		   {"name": "efecDate","value": $("#flight_efec_date").val()},
                   {"name": "discDate","value": $("#flight_disc_date").val()},
		   {"name": "futureuse","value": $("#future_use").val()},

		   {"name": "startHrs","value": $("#flight_dep_start_hrs").val()},
                   {"name": "startMins","value": $("#flight_dep_start_mins").val()},
		 {"name": "endHrs","value": $("#flight_dep_end_hrs").val()},
                   {"name": "endMins","value": $("#flight_dep_end_mins").val()},
                   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 
      "columns": [{"data": "eexcl_id" },
                  {"data": "excl_reason_desc" },
                                  {"data": "orig_mkt_name" },
                                  {"data": "dest_mkt_name" },
				  {"data": "carrier_code" },
                                  {"data": "flight_efec_date" }, 
                  {"data": "flight_disc_date"},
                                  {"data": "flight_dep_start" },
                                  {"data": "flight_dep_end" },
                                  {"data": "flight_nbr" },
                                  {"data": "from_class"},
                                         {"data": "to_class" },
                                  {"data": "frequency"},
                                  {"data": "future_use"},
				  {"data": "active"},
                  {"data": "action"}

                                  ],                       
        //"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']  
        dom: 'B<"clear">lfrtip',
    buttons: [ 'copy', 'csv', 'excel','pdf' ]
    });
  });
  
   $('#ruleslist tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });

  
  var status = '';
  var id = 0;
 $('#ruleslist tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('eligibility_exclusion/active')?>",
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
$( ".select2" ).select2({closeOnSelect:false,
                         placeholder: "Select Frequency"});

$("#flight_efec_date").datepicker();
$("#flight_disc_date").datepicker();

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
