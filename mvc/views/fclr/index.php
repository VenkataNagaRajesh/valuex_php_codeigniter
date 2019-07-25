<div class="fclr-bar">
<?php  if(permissionChecker('fclr_add')) {  ?>
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:96%;">Fare Control Range</h2>
	<p class="card-header" data-toggle="collapse" data-target="#fclrAdd"><button style="margin:1px 0;" type="button" class="btn btn-danger pull-right" data-placement="left" title="Add FCLR" data-toggle="tooltip" id='fclr_add_btn' ><i class="fa fa-plus"></i></button></p>
 <?php } ?>
	<div class="col-md-12 fclr-table-add collapse" id="fclrAdd">
		<form class="form-horizontal" action="#" id='fclr_add_form'>
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-2">
						<h4>Board Point</h4>
						<?php
							$airports['0'] = 'Board Point';
							ksort($airports);
							echo form_dropdown("board_point", $airports,set_value("board_point"), "id='board_point' class='form-control hide-dropdown-icon select2'"); ?>
					</div>
					<div class="col-md-2">
						<h4>Off Point</h4>
						<?php
							$airports['0'] = 'Off Point';
							ksort($airports);
							echo form_dropdown("off_point", $airports,set_value("off_point"), "id='off_point' class='form-control hide-dropdown-icon select2'");?>
					</div>
					<div class="col-md-2">
						<h4>Season</h4>
						<?php 
							$seasons[0] = 'Seasons';
							ksort($seasons);
							echo form_dropdown("season_id", $seasons,set_value("season_id"), "id='season_id' class='form-control hide-dropdown-icon select2'");?>
					</div>
					<div class="col-md-2">
						<h4>Carrier</h4>
						<?php
							$airlines[0] = 'Carrier';
							ksort($airlines);
							echo form_dropdown("carrier_code", $airlines,set_value("carrier_code"), "id='carrier_code' class='form-control hide-dropdown-icon select2'"); ?>
					</div>
					<div class="col-md-2">
						<h4>Flight Number</h4>
						<input type="text" class="form-control" id="flight_number" name="flight_number" value="<?=set_value('flight_number')?>" >
					</div>
					<div class="col-md-2">
						<h4>Frequency</h4>
						<?php
							$days_of_week[0] = 'Frequency';
							ksort($days_of_week);
							echo form_dropdown("frequency", $days_of_week, set_value("frequency"), "id='frequency' class='form-control hide-dropdown-icon select2'");?>  
					</div>
					<div class="col-md-2">
						<h4>From Cabin</h4>
						<?php
							$cabins['0'] = 'From Cabin';
							ksort($cabins);
							echo form_dropdown("upgrade_from_cabin_type", $cabins,set_value("upgrade_from_cabin_type"), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'"); ?>   
					</div>
					<div class="col-md-2">
						<h4>To Cabin</h4>
						<?php
							$cabins['0'] = 'To Cabin';
							ksort($cabins);
							echo form_dropdown("upgrade_to_cabin_type", $cabins,set_value("upgrade_to_cabin_type"), "id='upgrade_to_cabin_type' class='form-control hide-dropdown-icon select2'");?> 
					</div>
					<div class="col-md-2">
						<h4>Minimum</h4>
						<input type="text" class="form-control" id="min" name="min" value="<?=set_value('min')?>" >
					</div>
					<div class="col-md-2">
						<h4>Maximum</h4>
						<input type="text" class="form-control" id="max" name="max" value="<?=set_value('max')?>" >
					</div>
					<div class="col-md-2">
						<h4>Average</h4>
						<input type="text" class="form-control" id="avg" name="avg" value="<?=set_value('avg')?>" >
					</div>
					<div class="col-md-2">
						<h4>Slider Position</h4>
						<input type="text" class="form-control" id="slider_start" name="slider_start" value="<?=set_value('slider_start')?>" >
					</div>
					<input type="hidden" class="form-control" id="fclr_id" name="fclr_id"   value="" >
				</div>
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
				<div class="form-group">
					<div class="col-md-2 select-form">
						<h4>Flight No Range</h4>
						<div class="col-md-12">
							<input type="text" class="form-control" placeholder="Start range" id="sflight_number" name="sflight_number" value="<?=set_value('sflight_number',$flight_number)?>" >
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" placeholder="End range" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
						</div>
					</div>
					<div class="col-md-2 select-form">
						<h4>Season and Carrier</h4>
						<div class="col-md-12">
		 <?php
                                                        $seasons['0'] = 'Season';
                                                        ksort($seasons);
                                                        echo form_dropdown("sseason_id", $seasons,set_value("sseason_id",$sseason_id), "id='sseason_id' class='form-control hide-dropdown-icon select2'"); ?>

						</div>
						<div class="col-md-12">

		 <?php
                                                        $airlines['0'] = 'Carrier';
                                                        ksort($airlines);
                                                        echo form_dropdown("scarrier", $airlines,set_value("scarrier",$scarrier_id), "id='scarrier' class='form-control hide-dropdown-icon select2'"); ?>

						</div>
					</div>

					  <div class="col-md-2 select-form">
                                                <h4>Cabins</h4>
                                                <div class="col-md-12">
				 <?php
                                                        $cabins['0'] = 'From Cabin';
                                                        ksort($cabins);
                                                        echo form_dropdown("sfrom_cabin", $cabins,set_value("sfrom_cabin",$sfrom_cabin), "id='sfrom_cabin' class='form-control hide-dropdown-icon select2'"); ?>

                                                </div>
                                                <div class="col-md-12">

				   <?php
                                                        $cabins['0'] = 'To Cabin';
                                                        ksort($cabins);
                                                        echo form_dropdown("sto_cabin", $cabins,set_value("sto_cabin",$sto_cabin), "id='sto_cabin' class='form-control hide-dropdown-icon select2'"); ?>

                                                </div>
                                        </div>

					<div class="col-md-2 select-form">
						<h4>Board/Off Point</h4>
						<div class="col-md-12">
							 <?php
								$airports['0'] = ' Boarding Point';
								ksort($airports); 
                                echo form_dropdown("boarding_point", $airports,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
						<div class="col-md-12">
							<?php
								$airports['0'] = ' Off Point';
								ksort($airports);
                                echo form_dropdown("soff_point", $airports,set_value("soff_point",$off_point), "id='soff_point' class='form-control hide-dropdown-icon select2'");    ?>
						</div>
					</div>
					<div class="col-md-2 select-form">
						<h4>Market</h4>
						<div class="col-md-12">
							<?php
								$marketzones['0'] = 'Origin Market';
								ksort($marketzones);
                                echo form_dropdown("smarket", $marketzones,set_value("smarket",$smarket), "id='smarket' class='form-control hide-dropdown-icon select2'");    ?>
						</div>
						<div class="col-md-12">
							  <?php
								$marketzones['0'] = 'Dest Market';
								ksort($marketzones);
                                echo form_dropdown("dmarket", $marketzones,set_value("dmarket",$dmarket), "id='dmarket' class='form-control hide-dropdown-icon select2'");    ?>
						</div>
					</div>
					<div class="col-md-2 select-form">
						<h4>Frequency & FCLR ID</h4>
						<div class="col-md-12">
	
		<input type="text" class="form-control" placeholder='frequency' id="sfrequency" name="sfrequency" value="<?=set_value('sfrequency')?>" >
						</div>

			  <div class="col-md-12">

                <input type="text" class="form-control" placeholder='FCLR ID' id="sfclr_id" name="sfclr_id" value="<?=set_value('sfclr_id',$sfclr_id)?>" >
                                                </div>
						<div class="col-md-12">
							<a href="#" type="button"  id='btn_txt' class="btn btn-danger form-control" onclick="$('#fclrtable').dataTable().fnDestroy();;loaddatatable();">Filter</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 fclr-table">
		<div id="hide-table" class="fclr-table-data">
             <table id="fclrtable" class="table table-bordered dataTable no-footer">
                 <thead>
					<tr>

					  <th><input type="checkbox" id="bulkDelete"/> <button id="deleteTriger">Delete All</button></th>
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
						<th class="col-lg-1 noExport"><?=$this->lang->line('fclr_status')?></th>
                        <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
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
		  {"name": "sfrom_cabin","value": $("#sfrom_cabin").val()},
                   {"name": "sto_cabin","value": $("#sto_cabin").val()},
			 {"name": "sseason_id","value": $("#sseason_id").val()},
			{"name": "sfclr_id","value": $("#sfclr_id").val()},
                   {"name": "scarrier","value": $("#scarrier").val()},

                  
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [ {"data": "chkbox" },
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
    // buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
	 buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } }                
            ],

	"columnDefs": [ {"targets": 0,"orderable": false,"searchable": false}]
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

$(document).ready(function(){
$("#bulkDelete").on('click',function() { // bulk checked
        var status = this.checked;
        $(".deleteRow").each( function() {
          if(status == 1 && $(this).prop('checked')) {
                
          } else {
            $(this).prop("checked",status);
            $(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
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
                url: "<?php echo base_url('fclr/delete_fclr_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#fclrtable').DataTable().ajax.reload();
                   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 




$('#fclrtable').on('click', 'input[type="checkbox"]', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });




});
</script>
