<div class="eer">
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:96%;">Eligibility Exclusion Rules</h2>
	<p class="card-header" data-toggle="collapse" data-target="#eerAdd"><button type="button" id = 'rule_add_btn' class="btn btn-danger pull-right" style="margin:1px 0;" data-placement="left" title="Add Rule" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
	<div class="table-responsive col-md-12 collapse" id="eerAdd">
		<div class="col-md-12"><h2>Rule Criteria</h2></div>
		<form class="form-horizontal" id='add_rule_form' action="#">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-3 col-sm-3">
						<input type="text" placeholder="Enter Name" class="form-control" id="desc" name="desc" value="<?=set_value('desc')?>" >
					</div>
					<div class="col-md-3 col-sm-3">
						<div class="col-md-6 col-sm-6">
							<?php $aln_datatypes['0'] = " Origin Level ";
                                   ksort($aln_datatypes);
									echo form_dropdown("orig_level_id", $aln_datatypes, set_value("orig_level_id"), "id='orig_level_id' class='form-control select2'");?>
						</div>
						<div class="col-md-6 col-sm-6">
							<select  name="orig_level_value[]"  id="orig_level_value" class="form-control select2" multiple="multiple"></select>
						</div>
					</div>
					<div class="col-md-3 col-sm-3">
                         <div class="col-md-6 col-sm-6">
							<?php $aln_datatypes['0'] = "Dest Level ";
                                    ksort($aln_datatypes);
									echo form_dropdown("dest_level_id", $aln_datatypes, set_value("dest_level_id"), "id='dest_level_id' class='form-control select2'");?>
                          </div>
						  <div class="col-md-6 col-sm-6">
                            <select  name="dest_level_value[]"  id="dest_level_value" class="form-control select2" multiple="multiple"></select>
                          </div>
                     </div>
					<div class="col-md-3 col-sm-3">
						<?php

					 foreach($carriers as $airline){
                                     $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                                                         }

                        $airlinelist['0'] = ' Carrier';
                        ksort($airlinelist);



							echo form_dropdown("carrier", $airlinelist,set_value("carrier"), "id='carrier' class='form-control hide-dropdown-icon select2'");?>

					</div>
				</div>
				<div class="form-group">
					<div class="col-md-3 col-sm-3">
						<label class="control-label">Flight Effective & Discontinue Date</label>
						<div class="col-md-6 col-sm-6">
							<input type="text" placeholder="Effect Date" class="form-control" id="flight_efec_date" name="flight_efec_date" value="<?=set_value('flight_efec_date')?>" >
						</div>
						<div class="col-md-6 col-sm-6">
							<input type="text" class="form-control" placeholder="Disc Date" id="flight_disc_date" name="flight_disc_date" value="<?=set_value('flight_disc_date')?>" >
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<label class="control-label">Departure Start & End Time: HRS & Mins</label>
						<div class="col-md-3 col-sm-3">
							<?php
							$hrs['-1'] = 'Start Hrs';
							ksort($hrs);
							
								echo form_dropdown("flight_dep_start_hrs", $hrs,set_value("flight_dep_start_hrs"), "id='flight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");?>
						</div>
						<div class="col-md-3 col-sm-3">
							 <?php
							 $mins['-1'] = 'Start Mins';
							 ksort($mins);
							 echo form_dropdown("flight_dep_start_mins", $mins,set_value("flight_dep_start_mins"), "id='flight_dep_start_mins' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
						<div class="col-md-3 col-sm-3">
							<?php
								$hrs['-1'] = 'End Hrs';
								echo form_dropdown("flight_dep_end_hrs", $hrs,set_value("flight_dep_end_hrs"), "id='flight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");?>
						</div>
						<div class="col-md-3 col-sm-3">
							 <?php
								 $mins['-1'] = 'End Mins';
								echo form_dropdown("flight_dep_end_mins", $mins,set_value("flight_dep_end_mins"), "id='flight_dep_end_mins' class='form-control hide-dropdown-icon select2'");?>
						</div>
					</div>
					<div class="col-md-3 col-sm-3">
						<label class="control-label">Flight Number Start & End</label>
						<div class="col-md-6 col-sm-6">
							 <input type="text" class="form-control" placeholder="Start" id="flight_nbr_start" name="flight_nbr_start" value="<?=set_value('flight_nbr_start')?>" >
						</div>
						<div class="col-md-6 col-sm-6">
							 <input type="text" class="form-control" placeholder="End" id="flight_nbr_end" name="flight_nbr_end" value="<?=set_value('flight_nbr_end')?>" >
						</div>
					</div>
					<div class="col-md-2 col-sm-2">
						<label class="control-label">Frequency</label>
						<input type="text" class="form-control" placeholder="Frequency" id="frequency" name="frequency" value="<?=set_value('frequency')?>" >
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="rule-box">
					<div class="col-md-9">
						<ul>
							<!--<li>Rule Action<br>Flights to be considered upgrade offer</li> -->
							<!--<li>Cutoff time for offer acceptance</li>-->
						</ul>
					</div>
					<div class="col-md-3">
						<!--<p class="onoffswitch-small" id="1"><input id="myonoffswitch1" class="onoffswitch-small-checkbox" name="paypal_demo" checked="" type="checkbox"><label for="myonoffswitch1" class="onoffswitch-small-label"><span class="onoffswitch-small-inner"></span> <span class="onoffswitch-small-switch"></span> </label></p> --> 

						<div class="cabins">
							<p>Cabin Exclusion</p>
							<table class="table">
								<tr>
									<td>
										<label class="btn btn-success">
											<span>&nbsp;</span>
										</label>
									</td>
									<td>	
										<label class="btn btn-success">
											<span>Y</span>
										</label>
									</td>
									<td>
										<label class="btn btn-success">
											<span>W</span>
										</label>
									</td>
									<td>
										<label class="btn btn-success">
											<span>C</span>
										</label>
									</td>
									<td>
										<label class="btn btn-success">
											<span>F</span>
										</label>
									</td>
								</tr>
								<tr>
									<input type="hidden" class="form-control" id="excl_id" name="excl_id"   value="" >
									<td>
										<label class="btn btn-success">
											<span>Y</span>
										</label>
									</td>
									<td class="block">
										<label class="btn btn-success">
											<span>&nbsp;</span>
										</label>
									</td>
									<td>	
										<div class="btn-group" data-toggle="buttons">		
											<label class="btn btn-success">
												<input type="checkbox" autocomplete="off" name='cabin_list' value='Y-W'>
												<span class="glyphicon glyphicon-ok"></span>
											</label>
										</div>			
									</td>
									<td>
										<div class="btn-group" data-toggle="buttons">		
											<label class="btn btn-success">
												<input type="checkbox" autocomplete="off" name='cabin_list' value='Y-C' >
												<span class="glyphicon glyphicon-ok"></span>
											</label>
										</div>
									</td>
									<td>
										<div class="btn-group" data-toggle="buttons">		
											<label class="btn btn-success">
												<input type="checkbox" autocomplete="off" name='cabin_list' value='Y-F'>
												<span class="glyphicon glyphicon-ok"></span>
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<label class="btn btn-success">
											<span>W</span>
										</label>
									</td>
									<td class="block">
										<label class="btn btn-success">
											<span>&nbsp;</span>
										</label>
									</td>
									<td class="block">
										<label class="btn btn-success">
											<span>&nbsp;</span>
										</label>
									</td>
									<td>
										<div class="btn-group" data-toggle="buttons">		
											<label class="btn btn-success">
												<input type="checkbox" autocomplete="off" name='cabin_list'  value='W-C'>
												<span class="glyphicon glyphicon-ok"></span>
											</label>
										</div>
									</td>
									<td>
										<div class="btn-group" data-toggle="buttons">		
											<label class="btn btn-success">
												<input type="checkbox" autocomplete="off" name='cabin_list' value='W-F'>
												<span class="glyphicon glyphicon-ok"></span>
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<label class="btn btn-success">
											<span>C</span>
										</label>
									</td>
									<td class="block">
										<label class="btn btn-success">
											<span>&nbsp;</span>
										</label>
									</td>
									<td class="block">
										<label class="btn btn-success">
											<span>&nbsp;</span>
										</label>
									</td>
									<td class="block">
										<label class="btn btn-success">
											<span>&nbsp;</span>
										</label>
									</td>
									<td>
										<div class="btn-group" data-toggle="buttons">		
											<label class="btn btn-success">
												<input type="checkbox" autocomplete="off" name='cabin_list' value='C-F'>
												<span class="glyphicon glyphicon-ok"></span>
											</label>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<span class="col-md-3">
					<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="saverule();">ADD Rule</a>
					<a href="#" type="button" class="btn btn-danger" onclick="form_reset()">Cancel</a>
				</span>
			</div>
		</form>
	</div>
	<div class="col-sm-12 off-filter-form">

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
		<div class="col-sm-12">
                           <div class="col-sm-2">
               <?php 
                        $carriers[0] = ' Carrier';
                        ksort($carriers);

                                   echo form_dropdown("scarrier", $airlinelist,set_value("scarrier",$scarrier), "id='scarrier' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

<div class="col-sm-2">
<input type="text" placeholder="Frequency" class="form-control" id="sfrequency" name="sfrequency" value="<?=set_value('sfrequency')?>" >

                </div>

		                <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_nbr_start" name="sflight_nbr_start"  placeholder=' flight nbr start' value="<?=set_value('sflight_nbr_start',$nbr_start)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_nbr_end" name="sflight_nbr_end"  placeholder=' flight nbr end' value="<?=set_value('sflight_nbr_end',$nbr_end)?>" >
                </div>


                           <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_efec_date" name="sflight_efec_date"  placeholder=' flight Effective Date' value="<?=set_value('sflight_efec_date',$efec_date)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_disc_date" name="sflight_disc_date"  placeholder=' flight discontinue Date' value="<?=set_value('sflight_disc_date',$disc_date)?>" >
                </div>
</div></div>
<div class='form-group'>
<div class='col-sm-12'>
  <div class="col-sm-2">
                           <?php
				$hrs['-1'] = ' Departure Start Hrs';
				ksort($hrs);

                                    echo form_dropdown("sflight_dep_start_hrs", $hrs,set_value("sflight_dep_start_hrs"), "id='sflight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php
				$mins['-1'] = ' Departure start Mins';
				ksort($mins);
                                                    echo form_dropdown("sflight_dep_start_mins", $mins,set_value("sflight_dep_start_mins"), "id='sflight_dep_start_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>
  <div class="col-sm-2">
                           <?php
		 $hrs['-1'] = ' Departure End Hrs';
                                ksort($hrs);

                                    echo form_dropdown("sflight_dep_end_hrs", $hrs,set_value("sflight_dep_end_hrs"), "id='sflight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php

			 $mins['-1'] = ' Departure End Mins';
                                ksort($mins);
                                                    echo form_dropdown("sflight_dep_end_mins", $mins,set_value("sflight_dep_end_mins"), "id='sflight_dep_end_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>


	   <div class="col-sm-2">
               <?php
                        $class_list['0'] = ' From Cabin';
                        foreach ($class_type as $class) {
                                $class_list[$class->vx_aln_data_defnsID] = $class->code;
                        }

			ksort($class_type);

                                   echo form_dropdown("sfrom_class", $class_list,set_value("sfrom_class",$fromclass), "id='sfrom_class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


	     <div class="col-sm-2">
               <?php
                        $class_list['0'] = ' To Cabin';
			ksort($class_list);

                                   echo form_dropdown("sto_class", $class_list,set_value("sto_class",$toclass), "id='sto_class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>
</div></div>
<div class='form-group'>
<div class="col-sm-12">


                          <div class="col-md-2">

                <input type="text" class="form-control" placeholder='Exclusion ID' id="sexcl_id" name="sexcl_id" value="<?=set_value('sexcl_id',$sexcl_id)?>" >
                                                </div>


          <div class="col-sm-2">

                        <?php
                        $status['-1'] = ' Status';
                        $status['1'] = 'Active';
                        $status['0'] = 'In Active';
                        echo form_dropdown("active", $status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

                                  

                <div class="col-md-2 col-sm-6">
		<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="$('#ruleslist').dataTable().fnDestroy();;loaddatatable();">Filter</a>
		<a type="button" class="btn btn-danger" onclick="downloadEligibilityExc()">Download</a>

                </div>

</div>
                          </div>


                         </form>


         </div>
		 <div class="col-md-12  off-table">
		 <div class="col-md-12">
			<div id="hide-table">
              <table id="ruleslist" class="table table-bordered dataTable no-footer">
                   <thead>
                       <tr>
						 
				<th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
							<th class="col-lg-1">Rule#</th>
							<th class="col-lg-1"><?=$this->lang->line('desc')?></th>
							<th class="col-lg-1"><?php echo "Origin Level";?></th>
                            				<th class="col-lg-1"><?php echo "Orig Value";?></th>
							<th class="col-lg-1"><?php echo "Dest Level";?></th>
                            				<th class="col-lg-1"><?php echo "Dest Value";?></th>
							<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_efec_date')?></th>
                            				<th class="col-lg-1"><?=$this->lang->line('flight_disc_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_dep_start')?></th>
                            				<th class="col-lg-1"><?=$this->lang->line('flight_dep_end')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_nbr_range')?></th>
							<th class="col-lg-1"><?=$this->lang->line('upgrade_from')?></th>
							<th class="col-lg-1"><?=$this->lang->line('upgrade_to')?></th>
							<th class="col-lg-1"><?=$this->lang->line('frequency')?></th>
							<th class="col-lg-1 noExport"><?=$this->lang->line('rule_status')?></th> 
                            				<th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
                       </tr>
                   </thead>
                    <tbody>                            
                    </tbody>
				</table>
			</div>
		 </div>
		 </div>
	</div>
</div>
<script>
$(document).ready(function() {	 
loaddatatable();
});


function loaddatatable() {
  $('#ruleslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "stateSave": true,
      "sAjaxSource": "<?php echo base_url('eligibility_exclusion/server_processing'); ?>",   
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "scarrier","value": $("#scarrier").val()},
		   {"name": "sfrequency","value": $("#sfrequency").val()},
		   {"name": "fromClass","value": $("#sfrom_class").val()},
		   {"name": "toClass","value": $("#sto_class").val()},
		    {"name": "nbrStart","value": $("#sflight_nbr_start").val()},
                   {"name": "nbrEnd","value": $("#sflight_nbr_end").val()},
		   {"name": "efecDate","value": $("#sflight_efec_date").val()},
                   {"name": "discDate","value": $("#sflight_disc_date").val()},

		   {"name": "startHrs","value": $("#sflight_dep_start_hrs").val()},
                   {"name": "startMins","value": $("#sflight_dep_start_mins").val()},
		 {"name": "endHrs","value": $("#sflight_dep_end_hrs").val()},
                   {"name": "endMins","value": $("#sflight_dep_end_mins").val()},
			 {"name": "excl_id","value": $("#sexcl_id").val()},
                   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 
      "columns": [{"data": "chkbox" },
		  {"data": "ruleno" },
                  {"data": "excl_reason_desc" },
                                  {"data": "orig_level" },
                                  {"data": "orig_level_value" },	
				{"data": "dest_level" },
                                  {"data": "dest_level_value" },
				  {"data": "carrier_code" },
                                  {"data": "flight_efec_date" }, 
                  {"data": "flight_disc_date"},
                                  {"data": "flight_dep_start" },
                                  {"data": "flight_dep_end" },
                                  {"data": "flight_nbr" },
                                  {"data": "from_class"},
                                         {"data": "to_class" },
                                  {"data": "frequency"},
				  {"data": "active"},
                  {"data": "action"}

                                  ],                       
        //"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']  
        dom: 'B<"clear">lfrtip',
   // buttons: [ 'copy', 'csv', 'excel','pdf' ]
    buttons: [  { text: 'Delete', exportOptions: { columns: ':visible' },
                  action: function(e, dt, node, config) {
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
							url: "<?php echo base_url('eligibility_exclusion/delete_excl_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#ruleslist').DataTable().ajax.reload();
							   $('#bulkDelete').prop("checked",false);
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
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('eligibility_exclusion/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"scarrier":$("#scarrier").val(),"sfrequency":$("#sfrequency").val(),"fromClass":$("#sfrom_class").val(),"toClass": $("#sto_class").val(),"nbrStart":$("#sflight_nbr_start").val(),"nbrEnd":$("#sflight_nbr_end").val(),"efecDate":$("#sflight_efec_date").val(),"discDate":$("#sflight_disc_date").val(),"startHrs":$("#sflight_dep_start_hrs").val(),"startMins":$("#sflight_dep_start_mins").val(),"endHrs":$("#sflight_dep_end_hrs").val(),"endMins":$("#sflight_dep_end_mins").val(),"active":$("#active").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","eligibility_exclusion.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ],


	"columnDefs": [ {"targets": 0,"width": "30px" }]

    });
  
}

function downloadEligibilityExc(){
	$.ajax({
         url: "<?php echo base_url('eligibility_exclusion/server_processing'); ?>?page=all&&export=1",
          type: 'get',
         data: {"scarrier":$("#scarrier").val(),"sfrequency":$("#sfrequency").val(),"fromClass":$("#sfrom_class").val(),"toClass": $("#sto_class").val(),"nbrStart":$("#sflight_nbr_start").val(),"nbrEnd":$("#sflight_nbr_end").val(),"efecDate":$("#sflight_efec_date").val(),"discDate":$("#sflight_disc_date").val(),"startHrs":$("#sflight_dep_start_hrs").val(),"startMins":$("#sflight_dep_start_mins").val(),"endHrs":$("#sflight_dep_end_hrs").val(),"endMins":$("#sflight_dep_end_mins").val(),"active":$("#active").val()},
         dataType: 'json'
     }).done(function(data){
		var $a = $("<a>");
		$a.attr("href",data.file);
		$("body").append($a);
		$a.attr("download","eligibility_exclusion.xls");
		$a[0].click();
		$a.remove();
		 });
}
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
                         placeholder: "Level Value"});

$("#flight_efec_date").datepicker();
$("#flight_disc_date").datepicker();

$("#flight_efec_date").datepicker({
    }).on('changeDate', function (ev) {
	$('#flight_disc_date').val("").datepicker("update");
	var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
	var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#flight_disc_date').datepicker('setStartDate', minDate);
	 $("#flight_disc_date").datepicker("setDate" , $(this).val());
    });

    $("#flight_disc_date").datepicker()
        .on('changeDate', function (selected) {

		var dates = $(this).val();
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#flight_efec_date').datepicker('setEndDate', maxDate);
        });

$("#sflight_efec_date").datepicker();
$("#sflight_disc_date").datepicker();

$("#sflight_efec_date").datepicker({
    }).on('changeDate', function (ev) {
        $('#sflight_disc_date').val("").datepicker("update");
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#sflight_disc_date').datepicker('setStartDate', minDate);
         $("#sflight_disc_date").datepicker("setDate" , $(this).val());
    });

    $("#sflight_disc_date").datepicker()
        .on('changeDate', function (selected) {

                var dates = $(this).val();
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#sflight_efec_date').datepicker('setEndDate', maxDate);
        });




function saverule() {
            var favorite = [];

            $.each($('input[type=checkbox][name=cabin_list]:checked'), function(){            
                favorite.push($(this).val());

            });
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('eligibility_exclusion/save')?>",          
                  data: {"orig_level_id" :$('#orig_level_id').val(),
                         "dest_level_id":$('#dest_level_id').val(),
			 "orig_level_value" :$('#orig_level_value').val(),
                         "dest_level_value":$('#dest_level_value').val(),
			 "desc":$('#desc').val(),
                         "carrier":$('#carrier').val(),
                         "flight_efec_date":$('#flight_efec_date').val(),
                         "flight_disc_date":$('#flight_disc_date').val(),
                         "flight_dep_start_hrs":$('#flight_dep_start_hrs').val(),
                          "flight_dep_start_mins":$('#flight_dep_start_mins').val(),
                          "flight_dep_end_hrs":$('#flight_dep_end_hrs').val(),
			 "flight_dep_end_mins":$('#flight_dep_end_mins').val(),
                          "flight_nbr_start":$('#flight_nbr_start').val(),
                          "flight_nbr_end":$('#flight_nbr_end').val(),
                          "frequency":$('#frequency').val(),
				"cabin_list":favorite,
                           "excl_id":$('#excl_id').val(),
			   },

          dataType: "html",                     


success: function(data) {

                        var ruleinfo = jQuery.parseJSON(data);
                        var status = ruleinfo['status'];
                        newstatus = status.replace(/<p>(.*)<\/p>/g, "$1");
                        if (status == 'success' ) {
                                alert(status);
				form_reset();
                                $("#ruleslist").dataTable().fnDestroy();
                                loaddatatable();
                        } else {                                
                                alert($(status).text());
                            $.each(ruleinfo['errors'], function(key, value) {
                                        if(value != ''){                                         
                                        $('#' + key).parent().addClass('has-error'); 
                                        }                                               
                });                             
                        }
             }

          });


}



function editrule(excl_grp_id) {

               var isVisible = $( "#eerAdd" ).is( ":visible" );

                var isHidden = $( "#eerAdd" ).is( ":hidden" );
                if( isVisible == false ) {
                        $( "#rule_add_btn" ).trigger( "click" );
                }       
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('eligibility_exclusion/getRuleData')?>",          
                  data: {
                           "excl_grp_id":excl_grp_id},
          dataType: "html",                     
          success: function(data) {
                var ruleinfo = jQuery.parseJSON(data);
		form_reset();
                $('#btn_txt').text('Update Rule');
		$('#desc').val(ruleinfo['excl_reason_desc']);
                $('#orig_level_id').val(ruleinfo['orig_level_id']);
                $('#orig_level_id').trigger('change');

		if( ruleinfo['orig_level_value'] != '') {
		var orig = ruleinfo['orig_level_value'].split(',');
                $('#orig_level_value').val(orig).trigger('change');
		}

                $('#dest_level_id').val(ruleinfo['dest_level_id']);
                $('#dest_level_id').trigger('change');


		if( ruleinfo['dest_level_value'] != '' ) {
		var dest = ruleinfo['dest_level_value'].split(',');
                $('#dest_level_value').val(dest).trigger('change');
		}

		$('#carrier').val(ruleinfo['carrier']);
                $('#carrier').trigger('change');

		
                $('#flight_efec_date').val(ruleinfo['flight_efec_date']);
		$('#flight_efec_date').trigger('change');

		$('#flight_disc_date').val(ruleinfo['flight_disc_date']);
		 $('#flight_disc_date').trigger('change');

		 $('#flight_dep_start_hrs').val(ruleinfo['flight_dep_start_hrs']);
		$('#flight_dep_start_hrs').trigger('change');
		$('#flight_dep_start_mins').val(ruleinfo['flight_dep_start_mins']);
                $('#flight_dep_start_mins').trigger('change');


                 $('#flight_dep_end_hrs').val(ruleinfo['flight_dep_end_hrs']);
                $('#flight_dep_end_hrs').trigger('change');
                $('#flight_dep_end_mins').val(ruleinfo['flight_dep_end_mins']);
                $('#flight_dep_end_mins').trigger('change');

		if ( ruleinfo['flight_nbr_start'] == '0' ) {	
			ruleinfo['flight_nbr_start'] = '';
		}
		$('#flight_nbr_start').val(ruleinfo['flight_nbr_start']);
		
	       if ( ruleinfo['flight_nbr_end'] == '0' ) {    
                        ruleinfo['flight_nbr_end'] = '';
                }

		$('#flight_nbr_end').val(ruleinfo['flight_nbr_end']);

		if (ruleinfo['frequency'] == '0') {
			ruleinfo['frequency'] = '';
		}

                $('#frequency').val(ruleinfo['frequency']);;

		var cab = ruleinfo['cabins'].split(',');
		$.each(cab, function (index, value) {
			$('input[type=checkbox][name="cabin_list"][value="' + value.toString() + '"]').prop("checked", true).parent().addClass("active");
		});	

		

                var excl_id  = ruleinfo['excl_grp'];
                $('#excl_id').val(excl_id);




        //      var info = JSON.stringify(zoneinfo);

          }
          });
}


function form_reset(){    
          var $inputs = $('#add_rule_form :input'); 
          $('#desc').val("");  
	  $('#flight_nbr_start').val("");
	  $('#flight_nbr_end').val("");
	  $('#flight_efec_date').val("");
          $('#flight_disc_date').val("");
	 $('#frequency').val('');
          
           $("#carrier").val(0).trigger('change');
	   $("#orig_level_id").val(0).trigger('change');
	   $("#dest_level_id").val(0).trigger('change');
           $("#orig_level_value").val(0).trigger('change');
	   $("#dest_level_value").val(0).trigger('change');
	   $("#flight_dep_start_hrs").val('-1').trigger('change');
	   $("#flight_dep_start_mins").val('-1').trigger('change');
	   $("#flight_dep_end_hrs").val('-1').trigger('change');
           $("#flight_dep_end_mins").val('-1').trigger('change');

	 $.each($('input[type=checkbox][name=cabin_list]'), function(){            
			$('input[type=checkbox][name="cabin_list"]').parent().removeClass("active");
			 $('input[type=checkbox][name="cabin_list"]').prop("checked", false);
			
            });

  }


</script>
<script>
$('#orig_level_id').change(function(event) {    
        $('#orig_level_value').val(null).trigger('change')
  var level_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#orig_level_value').html(data); }        
      });       
});

$('#dest_level_id').change(function(event) {    
        $('#dest_level_value').val(null).trigger('change')
  var level_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#dest_level_value').html(data); }        
      });       
});


function myFunction(x) {
  x.classList.toggle("fa-thumbs-up");
}
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


$(document).ready(function(){

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
                url: "<?php echo base_url('eligibility_exclusion/delete_excl_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#ruleslist').DataTable().ajax.reload();
                   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 


$('#ruleslist').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });



});

</script>



