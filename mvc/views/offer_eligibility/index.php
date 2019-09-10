<div class="off-elg">
	<h2 class="title-tool-bar">Offer Eligibility</h2>
	<div class="col-md-12 off-elg-filter-box">
 <a href="<?php echo base_url('offer_eligibility/generatedata') ?>" class="btn btn-danger">
                                <i class="fa fa-upload"></i>
                                <?=$this->lang->line('generate_offer_eligibility')?>
                        </a>

		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class="form-group">
				<div class="col-md-2 select-form">
					<div class="col-sm-12">
						<?php
						$airport['0'] = 'Boarding Point';
						ksort($airport);
						echo form_dropdown("boarding_point", $airport,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
					<div class="col-sm-12">
						<?php
							$airport['0'] = 'Off Point';
							ksort($airport);
							echo form_dropdown("off_point", $airport,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
				</div>



<div class="col-md-2 select-form">
                                        <h4>Carrier & Status</h4>
                                        <div class="col-sm-12">
                                        <?php
                foreach($carriers as $airline){
                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
         }
                 $airlinelist[0]= 'Carrier';
                  ksort($airlinelist);


                                                echo form_dropdown("carrier", $airlinelist,set_value("carrier",$carrier), "id='carrier' class='form-control hide-dropdown-icon select2'");    ?>
                                        </div>
                                        <div class="col-sm-12">
                                                <?php
                                                        $status['0'] = 'Offer Status';
                                                        ksort($status);
                                                        echo form_dropdown("booking_status", $status,set_value("booking_status"), "id='booking_status' class='form-control hide-dropdown-icon select2'");    ?>
                                        </div>
                                </div>



				<div class="col-md-2 select-form">
					<div class="col-sm-12">

	 <select  name="from_cabin"  id='from_cabin' class="form-control select2">
                                <option value=0>From Cabin</option>
                                                        </select>


					<?php /*
                        $cabin['0'] = 'From Cabin';
                        ksort($cabin);
						echo form_dropdown("from_cabin", $cabin,set_value("from_cabin",$from_cabin), "id='from_cabin' class='form-control hide-dropdown-icon select2'");   */ ?>
					</div>
					<div class="col-sm-12">

 <select  name="to_cabin"  id='to_cabin' class="form-control select2">
                                <option value=0>To Cabin</option>
                                                        </select>

						<?php/*
							$cabin['0'] = 'To Cabin';
							ksort($cabin);
							echo form_dropdown("to_cabin", $cabin,set_value("to_cabin",$to_cabin), "id='to_cabin' class='form-control hide-dropdown-icon select2'");  */  ?>
					</div>
				</div>


		 <div class="col-md-2 select-form">
                                        <div class="col-sm-12">
                                        <?php

				 $slist = array("0" => " Season");
                                   foreach($seasonslist as $season){
                                          $slist[$season->VX_aln_seasonID] = $season->season_name;
                                        }

                                                echo form_dropdown("season", $slist,set_value("season"), "id='season' class='form-control hide-dropdown-icon select2'");    ?>
                                        </div>
                                        <div class="col-sm-12">
		<input type="text" class="form-control" placeholder='frequency' id="frequency" name="frequency" value="<?=set_value('frequency')?>" >
                                        </div>
                                </div>


<div class="col-md-2 select-form">
                                        <div class="col-sm-12">
                                        <?php
		foreach($carriers as $airline){
                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
         }
                 $airlinelist[0]= 'Carrier';
                  ksort($airlinelist);


                                                echo form_dropdown("carrier", $airlinelist,set_value("carrier",$carrier), "id='carrier' class='form-control hide-dropdown-icon select2'");    ?>
                                        </div>
                                        <div class="col-sm-12">
                                                <?php
                                                        $status['0'] = 'Offer Status';
                                                        ksort($status);
                                                        echo form_dropdown("booking_status", $status,set_value("booking_status"), "id='booking_status' class='form-control hide-dropdown-icon select2'");    ?>
                                        </div>
                                </div>


				<div class="col-md-2 select-form">
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="Start range" id="flight_number" name="flight_number" value="<?=set_value('flight_number',$flight_number)?>" >
					</div>
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="End range" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
					</div>
				</div>
				<div class="col-md-2">
					<div class="col-sm-12">
						 <div class="input-group">
							<input type="text" class="form-control" placeholder="Dep Start" id="dep_from_date" name="dep_from_date" value="<?=set_value('dep_from_date',$dep_from_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Dep End" id="dep_to_date" name="dep_to_date" value="<?=set_value('dep_to_date',$dep_to_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter">Filter</button>
				   <button type="button" class="btn btn-danger" onclick="downloadOfferEligibility()">Download</button>
                </div>	             				
			</div>
		</form>
	</div>
	<div class="col-md-12 off-elg-table">
		<div class="col-md-12">
			<div id="hide-table">
				<table id="eligibilitytable" class="table table-bordered">
					<thead>
						<tr>
							<th class="col-lg-1"><?=$this->lang->line('slno')?></th>
							<th class="col-lg-1"><?=$this->lang->line('pax_id')?></th>
							<th class="col-lg-1"><?=$this->lang->line('fclr_id')?></th>
							<th class="col-lg-1"><?=$this->lang->line('season')?></th>
							<th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
							<th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
							<th class="col-lg-1">PNR Ref</th>
							<th class="col-lg-1"><?=$this->lang->line('departure_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
							<th class="col-lg-1"><?=$this->lang->line('from_cabin')?></th>
							<th class="col-lg-1"><?=$this->lang->line('to_cabin')?></th>
							<th class="col-lg-1"><?=$this->lang->line('day_of_week')?></th>
							<th class="col-lg-1"><?=$this->lang->line('avg')?></th>
							<th class="col-lg-1"><?=$this->lang->line('min')?></th>
							<th class="col-lg-1"><?=$this->lang->line('max')?></th>
							<th class="col-lg-1"><?=$this->lang->line('slider_start')?></th>
							<th class="col-lg-1"><?=$this->lang->line('booking_status')?></th>
						</tr>
					 </thead>
					 <tbody>                          
					 </tbody>
				  </table>
			 </div>
		</div>
	</div>
</div>
<script>
 $(document).ready(function() {	 
	

$("#dep_from_date").datepicker();
$("#dep_to_date").datepicker();


$("#dep_from_date").datepicker({
    }).on('changeDate', function (ev) {
        $('#dep_to_date').val("").datepicker("update");
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#dep_to_date').datepicker('setStartDate', minDate);
         $("#dep_to_date").datepicker("setDate" , $(this).val());
    });

    $("#dep_to_date").datepicker()
        .on('changeDate', function (selected) {

                var dates = $(this).val();
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#dep_from_date').datepicker('setEndDate', maxDate);
        });



$('#carrier').change(function(event) {    
  var carrier = $('#carrier').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#from_cabin').html(data);
                                $("#from_cabin option").html(function(i,str){
                                        return str.replace(/From Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "From Cabin")?"Cabin":"From Cabin";
                                 });
});
                                $('#to_cabin').html(data);

                                $("#to_cabin option").html(function(i,str){
                                        return str.replace(/To Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "To Cabin")?"Cabin":"To Cabin";
                                 });
                                });

                                
                                }        
      });       
});

$('#carrier').trigger('change');
$('#from_cabin').trigger('change');
$('#to_cabin').trigger('change');


$('#from_cabin').val('<?=$from_cabin?>').trigger('change');
$('#to_cabin').val('<?=$to_cabin?>').trigger('change');



    $('#eligibilitytable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('offer_eligibility/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#flight_number").val()},
		           {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#off_point").val()},
		           {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
		           {"name": "fromCabin","value": $("#from_cabin").val()},
                   {"name": "toCabin","value": $("#to_cabin").val()},
		           {"name": "frequency","value": $("#frequency").val()},
			       {"name": "booking_status","value": $("#booking_status").val()},
			       {"name": "season","value": $("#season").val()},
                   {"name": "carrier","value": $("#carrier").val()},
                  
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [ {"data": "sno" },
		   {"data": "dtpf_id" },
		   {"data": "fclr_id" },
		   {"data": "season_id" },
		   {"data": "source_point" },
	       {"data": "dest_point" },
		   {"data": "pnr_ref" },
		   {"data": "departure_date" },
		   {"data": "carrier_code" },
		   {"data": "flight_number" },
		   {"data": "fcabin" },
		   {"data": "tcabin" },
		   {"data": "day_of_week" },
		   {"data": "average" },
           {"data": "min" },
		   {"data": "max" },
		   {"data": "slider_start" },
		   {"data": "booking_status" }
				  ],			     
     dom: 'B<"clear">lfrtip',
    // buttons: [ 'copy', 'csv', 'excel','pdf' ]
     buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf',orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('offer_eligibility/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"flightNbr":$("#flight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#off_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"fromCabin": $("#from_cabin").val(),"toCabin":$("#to_cabin").val(),"frequency":$("#frequency").val(),"booking_status": $("#booking_status").val(),"season":$("#season").val(),"carrier":$("#carrier").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","offer_eligibility.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ]	
    });
	
	




  });
 
  function downloadOfferEligibility(){
	  $.ajax({
        url: "<?php echo base_url('offer_eligibility/server_processing'); ?>?page=all&&export=1",
        type: 'get',
        data: {"flightNbr":$("#flight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#off_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"fromCabin": $("#from_cabin").val(),"toCabin":$("#to_cabin").val(),"frequency":$("#frequency").val(),"booking_status": $("#booking_status").val(),"season":$("#season").val(),"carrier":$("#carrier").val()},
        dataType: 'json'
        }).done(function(data){
		   var $a = $("<a>");
		   $a.attr("href",data.file);
		   $("body").append($a);
		   $a.attr("download","offer_eligibility.xls");
		   $a[0].click();
		   $a.remove();
		  }); 
  }
  
   $('#eligibilitytable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#eligibilitytable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('offer_eligibility/active')?>",
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
