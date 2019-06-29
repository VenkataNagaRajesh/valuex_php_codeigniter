<div class="eer">
	<h2 class="title-tool-bar" style="color:#fff;">Eligibility Exclusion Rules</h2>
	<p class="card-header" data-toggle="collapse" data-target="#eerAdd"><button type="button" id = 'rule_add_btn' class="btn btn-danger pull-right" data-placement="left" title="Add Rule" data-toggle="tooltip"><i class="fa fa-plus"></i></button></p>
	<div class="table-responsive col-md-12 collapse" id="eerAdd">
		<div class="col-md-12"><h2>Rule Criteria</h2></div>
		<form class="form-horizontal" id='add_rule_form' action="#">
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
									<td>W</td>
									<td>C</td>
									<td>F</td>
								</tr>
								<tr>
<input type="hidden" class="form-control" id="excl_id" name="excl_id"   value="" >
									<td>Y</td>
									<td class="block"></td>
									<td><input type="checkbox" class="form-control"  name='cabin_list' value='Y-W'  > 												</td>
									<td><input type="checkbox" class="form-control"  name='cabin_list' value='Y-C'  ></td>
									<td><input type="checkbox" class="form-control"  name='cabin_list' value='Y-F'  ></td>
								</tr>
								<tr>
									<td>W</td>
									<td class="block"></td>
									<td class="block"></td>
									<td><input type="checkbox" class="form-control" name='cabin_list'  value='W-C'  ></td>
									<td><input type="checkbox" class="form-control"  name='cabin_list' value='W-F'  ></td>
								</tr>
								<tr>
									<td>C</td>
									<td class="block"></td>
									<td class="block"></td>
									<td class="block"></td>
									<td><input type="checkbox" class="form-control"  name='cabin_list' value='C-F' ></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<span class="col-md-2">
					<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="saverule();">ADD Rule</a>
					<a href="#" type="button" class="btn btn-danger" onclick="form_reset()">Cancel</a>
				</span>
			</div>
		</form>
	</div>
	<div class="col-sm-12 off-table">

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
		<div class="col-sm-12">
                           <div class="col-sm-2">
               <?php 
			$marketzones['0'] = 'Select Origin Market';
			ksort($marketzones);

                                   echo form_dropdown("sorig_market_id", $marketzones,set_value("sorig_market_id",$origmarketID), "id='sorig_market_id' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

<div class="col-sm-2">
               <?php $marketzones['0'] = 'Select Destination Market';
			ksort($marketzones);
                                   echo form_dropdown("sdest_market_id", $marketzones,set_value("sdest_market_id",$destmarketID), "id='sdest_market_id' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

		                <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_nbr_start" name="sflight_nbr_start"  placeholder='Select flight nbr start' value="<?=set_value('sflight_nbr_start',$nbr_start)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_nbr_end" name="sflight_nbr_end"  placeholder='Select flight nbr end' value="<?=set_value('sflight_nbr_end',$nbr_end)?>" >
                </div>


                           <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_efec_date" name="sflight_efec_date"  placeholder='Select flight Effective Date' value="<?=set_value('sflight_efec_date',$efec_date)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="sflight_disc_date" name="sflight_disc_date"  placeholder='Select flight discontinue Date' value="<?=set_value('sflight_disc_date',$disc_date)?>" >
                </div>
</div></div>
<br> 
<div class='form-group'>
<div class='col-sm-12'>
  <div class="col-sm-2">
                           <?php
				$hrs['-1'] = 'Select Departure Start Hrs';
				ksort($hrs);

                                    echo form_dropdown("sflight_dep_start_hrs", $hrs,set_value("sflight_dep_start_hrs"), "id='sflight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php
				$mins['-1'] = 'Select Departure start Mins';
				ksort($mins);
                                                    echo form_dropdown("sflight_dep_start_mins", $mins,set_value("sflight_dep_start_mins"), "id='sflight_dep_start_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>
  <div class="col-sm-2">
                           <?php
		 $hrs['-1'] = 'Select Departure End Hrs';
                                ksort($hrs);

                                    echo form_dropdown("sflight_dep_end_hrs", $hrs,set_value("sflight_dep_end_hrs"), "id='sflight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php

			 $mins['-1'] = 'Select Departure End Mins';
                                ksort($mins);
                                                    echo form_dropdown("sflight_dep_end_mins", $mins,set_value("sflight_dep_end_mins"), "id='sflight_dep_end_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>


	   <div class="col-sm-2">
               <?php
                        $class_list['0'] = 'Select From Class';
                        foreach ($class_type as $class) {
                                $class_list[$class->vx_aln_data_defnsID] = $class->aln_data_value;
                        }

			ksort($class_type);

                                   echo form_dropdown("sfrom_class", $class_list,set_value("sfrom_class",$fromclass), "id='sfrom_class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


	     <div class="col-sm-2">
               <?php
                        $class_list['0'] = 'Select To Class';
			ksort($class_list);

                                   echo form_dropdown("sto_class", $class_list,set_value("sto_class",$toclass), "id='sto_class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>
</div></div>
<br>
<div class='form-group'>
<div class="col-sm-12">

		 <div class="col-sm-2">

                        <?php
                 echo form_multiselect("sday[]", $days_of_week, set_value("sday"), "id='sday' class='form-control select2'");

                        ?>

                 </div>



          <div class="col-sm-2">

                        <?php
                        $status['-1'] = 'Select Status';
                        $status['1'] = 'Active';
                        $status['0'] = 'In Active';
                        echo form_dropdown("active", $status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

		 <div class="col-sm-2">
                            <?php

						$toggle['-1'] = 'Select future use';
                                                          $toggle[1] = "Yes";
                                                          $toggle[0] = "No";
                                                          echo form_dropdown("sfuture_use", $toggle,set_value("sfuture_use",$future_use), "id='sfuture_use' class='form-control hide-dropdown-icon select2'");
                                                        ?>
                        </div>
                                  

                <div class="col-sm-2">
		<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="$('#ruleslist').dataTable().fnDestroy();;loaddatatable();">Filter</a>

                </div>

</div>
                          </div>


                         </form>


         </div>
		 <div id="hide-table" class="col-md-12">
              <table id="ruleslist" class="table table-striped table-bordered table-hover dataTable no-footer">
                   <thead>
                       <tr>
							<th class="col-lg-1"><?=$this->lang->line('slno')?></th>
							<th class="col-lg-1">Rule#</th>
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
loaddatatable();
});


function loaddatatable() {
  $('#ruleslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('eligibility_exclusion/server_processing'); ?>",   
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "origID","value": $("#sorig_market_id").val()},
                   {"name": "destID","value": $("#sdest_market_id").val()},
		   {"name": "day","value": $("#sday").val()},
		   {"name": "fromClass","value": $("#sfrom_class").val()},
		   {"name": "toClass","value": $("#sto_class").val()},
		    {"name": "nbrStart","value": $("#sflight_nbr_start").val()},
                   {"name": "nbrEnd","value": $("#sflight_nbr_end").val()},
		   {"name": "efecDate","value": $("#sflight_efec_date").val()},
                   {"name": "discDate","value": $("#sflight_disc_date").val()},
		   {"name": "futureuse","value": $("#sfuture_use").val()},

		   {"name": "startHrs","value": $("#sflight_dep_start_hrs").val()},
                   {"name": "startMins","value": $("#sflight_dep_start_mins").val()},
		 {"name": "endHrs","value": $("#sflight_dep_end_hrs").val()},
                   {"name": "endMins","value": $("#sflight_dep_end_mins").val()},
                   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 
      "columns": [{"data": "sno" },
		  {"data": "ruleno" },
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
                         placeholder: "Select Frequency"});

$("#flight_efec_date").datepicker();
$("#flight_disc_date").datepicker();

$("#sflight_efec_date").datepicker();
$("#sflight_disc_date").datepicker();



function saverule() {
            var favorite = [];

            $.each($('input[type=checkbox][name=cabin_list]:checked'), function(){            
                favorite.push($(this).val());

            });
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('eligibility_exclusion/save')?>",          
                  data: {"orig_market_id" :$('#orig_market_id').val(),
                         "dest_market_id":$('#dest_market_id').val(),
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
                          "future_use":$('#future_use').val(),
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
                $('#btn_txt').text('Update Rule');
		$('#desc').val(ruleinfo['excl_reason_desc']);
                $('#orig_market_id').val(ruleinfo['orig_market_id']);
                $('#orig_market_id').trigger('change');
                $('#dest_market_id').val(ruleinfo['dest_market_id']);
                $('#orig_market_id').trigger('change');
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


		$('#flight_nbr_start').val(ruleinfo['flight_nbr_start']);
		$('#flight_nbr_end').val(ruleinfo['flight_nbr_end']);

		var freq = ruleinfo['frequency'].split(',');
                $('#frequency').val(freq).trigger('change');


		$('#future_use').val(ruleinfo['future_use']);
                $('#future_use').trigger('change');

		var cab = ruleinfo['cabins'].split(',');

		$.each(cab, function (index, value) {
  			$('input[name="cabin_list"][value="' + value.toString() + '"]').prop("checked", true);
		});	

		

                var excl_id  = ruleinfo['excl_grp'];
                $('#excl_id').val(excl_id);




        //      var info = JSON.stringify(zoneinfo);

          }
          });
}


function form_reset(){    
          var $inputs = $('#add_rule_form :input'); 
          $inputs.each(function (index)
       {
          $(this).val("");  
       });

           $("#carrier").val(0).trigger('change');
	   $("#orig_market_id").val(0).trigger('change');
	   $("#dest_market_id").val(0).trigger('change');
           $("#frequency").val(0).trigger('change');
	   $("#future_use").val(0).trigger('change');
	   $("#flight_dep_start_hrs").val('00').trigger('change');
	   $("#flight_dep_start_mins").val('00').trigger('change');
	   $("#flight_dep_end_hrs").val('00').trigger('change');
           $("#flight_dep_end_mins").val('00').trigger('change');
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
</script>
