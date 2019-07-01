<div class="fclr-bar">
<?php  if(permissionChecker('fclr_add')) {  ?>
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:95%;">Fare Control Range</h2>
	<p class="card-header" data-toggle="collapse" data-target="#fclrAdd"><button style="margin:8px 0;" type="button" class="btn btn-danger pull-right" data-placement="left" title="Add FCLR" data-toggle="tooltip" id='fclr_add_btn' ><i class="fa fa-plus"></i></button></p>
 <?php } ?>
	<div class="col-md-12 fclr-table-add collapse" id="fclrAdd">
		<form class="form-horizontal" action="#" id='fclr_add_form'>
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
									$airports['0'] = 'Board Point';
									ksort($airports);
									echo form_dropdown("board_point", $airports,set_value("board_point"), "id='board_point' class='form-control hide-dropdown-icon select2'");
                                ?>
							</td>
							<td>
								 <?php
									$airports['0'] = 'Off Point';
									ksort($airports);
									echo form_dropdown("off_point", $airports,set_value("off_point"), "id='off_point' class='form-control hide-dropdown-icon select2'");
                                 ?>
							</td>
							<td>
								<?php 
									$seasons[0] = 'Seasons';
									ksort($seasons);
									echo form_dropdown("season_id", $seasons,set_value("season_id"), "id='season_id' class='form-control hide-dropdown-icon select2'");  
                                 ?>
							</td>
							<td>
								 <?php
									$airlines[0] = 'Carrier';
									ksort($airlines);
									echo form_dropdown("carrier_code", $airlines,set_value("carrier_code"), "id='carrier_code' class='form-control hide-dropdown-icon select2'");
                                  ?>
							</td>
							<td>
								<input type="text" class="form-control" id="flight_number" name="flight_number" value="<?=set_value('flight_number')?>" >
							</td>
							<td>
								<?php
									$days_of_week[0] = 'Frequency';
									ksort($days_of_week);
									echo form_dropdown("frequency", $days_of_week, set_value("frequency"), "id='frequency' class='form-control hide-dropdown-icon select2'");

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
									$cabins['0'] = 'From Cabin';
									ksort($cabins);
									echo form_dropdown("upgrade_from_cabin_type", $cabins,set_value("upgrade_from_cabin_type"), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'");

								?>     
							</td>
							<td>
								 <?php
									$cabins['0'] = 'To Cabin';
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
                                        <input type="hidden" class="form-control" id="fclr_id" name="fclr_id"   value="" >
						</tr>
					</tbody>
				</table>
				<div class="col-md-3 pull-right">
					<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="savefclr();">ADD FCLR</a>
					<a href="#" type="button" class="btn btn-danger" onclick="form_reset()">Cancel</a>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 table-responsive">
		<div class="auto-gen col-md-12" style="margin: 10px 0 20px;">
		<a href="<?php echo base_url('fclr/generatedata') ?>">
			<i class="fa fa-upload"></i>
			<?=$this->lang->line('generate_fclr')?>
		 </a>
		</div>
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
<input type="text" class="form-control" placeholder="Enter Start range Flight Number" id="sflight_number" name="sflight_number" value="<?=set_value('sflight_number',$flight_number)?>" >

								</div>
								<div class="col-md-6">
<input type="text" class="form-control" placeholder="Enter End range Flight number" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
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
						<th>Board/Off Point</th>
						<th>Market</th>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="col-md-6">
 <?php
                        $airports['0'] = 'Select Boarding Point';
                        ksort($airports);

                                   echo form_dropdown("boarding_point", $airports,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>

								</div>
								<div class="col-md-6">
<?php
        $airports['0'] = 'Select Off Point';
                        ksort($airports);

                                   echo form_dropdown("soff_point", $airports,set_value("soff_point",$off_point), "id='soff_point' class='form-control hide-dropdown-icon select2'");    ?>

								</div>
							</td>
							<td>
								<div class="col-md-6">

				<?php
        $marketzones['0'] = 'Origin Market';
                        ksort($marketzones);

                                   echo form_dropdown("smarket", $marketzones,set_value("smarket",$smarket), "id='smarket' class='form-control hide-dropdown-icon select2'");    ?>

								</div>
								<div class="col-md-6">
  <?php
        $marketzones['0'] = 'Dest Market';
                        ksort($marketzones);

                                   echo form_dropdown("dmarket", $marketzones,set_value("dmarket",$dmarket), "id='dmarket' class='form-control hide-dropdown-icon select2'");    ?>

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
<?php
 echo form_dropdown("sfrequency", $days_of_week, set_value("sfrequency",$frequency), "id='sfrequency' class='form-control select2'");
     ?>   
								</div>
								<div class="col-sm-2">
   <a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="$('#fclrtable').dataTable().fnDestroy();;loaddatatable();">Filter</a>

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
             <table id="fclrtable" class="table table-striped table-bordered table-hover dataTable no-footer">
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
loaddatatable();
});


function loaddatatable() {
    $('#fclrtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('fclr/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#sflight_number").val()},
		  {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#soff_point").val()},
		    {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
			{"name": "frequency","value": $("#sfrequency").val()},
		  {"name": "smarket","value": $("#smarket").val()},
                   {"name": "dmarket","value": $("#dmarket").val()},
                  
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
	
	
} 
  
   $('#fclrtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#fclrtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Frequency'});
 </script>

<script>

function savefclr() {
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('fclr/save')?>",          
                  data: {"board_point" :$('#board_point').val(),
                         "off_point":$('#off_point').val(),
                         "season_id":$('#season_id').val(),
                         "carrier_code":$('#carrier_code').val(),
			 "flight_number":$('#flight_number').val(),
                         "frequency":$('#frequency').val(),
                          "upgrade_from_cabin_type":$('#upgrade_from_cabin_type').val(),
                          "upgrade_to_cabin_type":$('#upgrade_to_cabin_type').val(),
                          "min":$('#min').val(),
			  "max":$('#max').val(),
                          "avg":$('#avg').val(),
                          "slider_start":$('#slider_start').val(),
                           "fclr_id":$('#fclr_id').val()},
          dataType: "html",                     


success: function(data) {

                        var fclrinfo = jQuery.parseJSON(data);
                        var status = fclrinfo['status'];
			newstatus = status.replace(/<p>(.*)<\/p>/g, "$1");
                        if (status == 'success' ) {
                                alert(status);
				form_reset();
                                $("#fclrtable").dataTable().fnDestroy();
                                loaddatatable();
                        } else if (status == 'duplicate'){
				alert('Duplicate Entry');
			} else {                                
                                alert($(status).text());
                            $.each(fclrinfo['errors'], function(key, value) {
                                        if(value != ''){                                         
                                        $('#' + key).parent().addClass('has-error'); 
                                        }                                               
                });                             
                        }
             }

          });
}


function editfclr(fclr_id) {

                var isVisible = $( "#fclrAdd" ).is( ":visible" );

                var isHidden = $( "#fclrAdd" ).is( ":hidden" );
                if( isVisible == false ) {
                        $( "#fclr_add_btn" ).trigger( "click" );
                }       
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('fclr/getFCLRData')?>",          
                  data: {
                           "fclr_id":fclr_id},
          dataType: "html",                     
          success: function(data) {
                var fclrinfo = jQuery.parseJSON(data);
                $('#btn_txt').text('Update FCLR');
                $('#carrier_code').val(fclrinfo['carrier_code']);
                $('#carrier_code').trigger('change');
                $('#board_point').val(fclrinfo['boarding_point']);
		$('#board_point').trigger('change');

		 $('#off_point').val(fclrinfo['off_point']);
                $('#off_point').trigger('change');

		 $('#flight_number').val(fclrinfo['flight_number']);

		  $('#season_id').val(fclrinfo['season_id']);
                $('#season_id').trigger('change');


                $('#frequency').val(fclrinfo['frequency']);
                $('#frequency').trigger('change');

		$('#upgrade_from_cabin_type').val(fclrinfo['from_cabin']);
		$('#upgrade_from_cabin_type').trigger('change');

		$('#upgrade_to_cabin_type').val(fclrinfo['to_cabin']);
		$('#upgrade_to_cabin_type').trigger('change');


		$('#min').val(fclrinfo['min']);
		$('#max').val(fclrinfo['max']);
		$('#avg').val(fclrinfo['average']);
		$('#slider_start').val(fclrinfo['slider_start']);

                var fclrid  = fclrinfo['fclr_id'];
                $('#fclr_id').val(fclrid);




        //      var info = JSON.stringify(zoneinfo);

          }
          });
}





</script>


<script>

function form_reset(){    
          var $inputs = $('#fclr_add_form :input'); 
          $inputs.each(function (index)
       {
          $(this).val("");  
       });

           $("#board_point").val(0).trigger('change');
           $("#off_point").val(0).trigger('change');
           $("#season_id").val(0).trigger('change');
           $("#carrier_code").val(0).trigger('change');
           $("#frequency").val(0).trigger('change');
           $("#upgrade_from_cabin_type").val(0).trigger('change');
           $("#upgrade_to_cabin_type").val(0).trigger('change');
  }

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
