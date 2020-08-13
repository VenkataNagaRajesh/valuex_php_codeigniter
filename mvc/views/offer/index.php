<div class="off-elg">
	<h2 class="title-tool-bar">Offer Details</h2>
	<div class="col-md-12 off-elg-filter-box">
		<div class="auto-gen">
			<a href="<?php echo base_url('offer_issue/run_offer_issue') ?>">
				 <i class="fa fa-upload"></i>
				 <?=$this->lang->line('offer_issue')?>
			</a>
			<a href="<?php echo base_url('offer_issue/auto_acsr') ?>">
				 <i class="fa fa-upload"></i>
				 <?php echo "AUTO ACSR"?>
			</a>
		</div><br>
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">	
			<div class="form-group">
				<div class="col-md-3 select-form">
					<div class="col-sm-12">
						<?php
							$airports['0'] = 'Boarding Point';
							ksort($airports);
							echo form_dropdown("boarding_point", $airports,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");   ?>
					</div>
					 <div class="col-sm-12">
						<?php
							$airports['0'] = 'Off Point';
							ksort($airports);
							echo form_dropdown("off_point", $airports,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");     ?>
					</div>
				</div>
				<div class="col-md-3 select-form">
					<div class="col-sm-12">
	<input type="text" class="form-control" placeholder="Pnr ref" id="pnr_ref" name="pnr_ref" value="<?=set_value('pnr_ref')?>" >

					</div>
					<div class="col-sm-12">
						<?php

				 foreach($carriers as $airline){
                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
         }

                 $airlinelist[0]= 'Carrier';
                  ksort($airlinelist);

							echo form_dropdown("carrier", $airlinelist,set_value("carrier",$car), "id='carrier' class='form-control hide-dropdown-icon select2'");     ?>
					</div>
				</div>
				<div class="col-md-3 select-form">
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="Start range" id="flight_number" name="flight_number" value="<?=set_value('flight_number',$flight_number)?>" >
					</div>
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="End range" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
					</div>
				</div>
				<div class="col-md-3">
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Enter Dep From date" id="dep_from_date" name="dep_from_date" value="<?=set_value('dep_from_date',$dep_from_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Enter Dep To date" id="dep_to_date" name="dep_to_date" value="<?=set_value('dep_to_date',$dep_to_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<button type="submit" class="btn btn-danger pull-right" name="filter" id="filter" data-title="Filter" data-toggle="tooltip"><i class="fa fa-filter"></i></button>
					<button type="button" class="btn btn-danger pull-right" onclick="downloadOfferData()" data-title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 off-elg-table">
		<div class="col-md-12">
			<div id="hide-table">
				<table id="offertable" class="table table-bordered">
					 <thead>
						<tr>
							<th class="col-lg-1">#</th>
							<th class="col-lg-1"><?=$this->lang->line('offer_id')?></th>
							<th class="col-lg-1"><?=$this->lang->line('passenger_list')?></th>
							<th class="col-lg-1"><?=$this->lang->line('pnr_ref')?></th>
							<th class="col-lg-1"><?=$this->lang->line('origin')?></th>
							<th class="col-lg-1"><?=$this->lang->line('destination')?></th>
							<th class="col-lg-1"><?=$this->lang->line('departure_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
							<th class="col-lg-1 noExport">Offer Status</th>
							<th class="col-lg-1 noExport">Bid Info</th>
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



    $('#offertable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
	"stateSave": true,
      "sAjaxSource": "<?php echo base_url('offer_issue/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#flight_number").val()},
		  {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#off_point").val()},
		    {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
		    {"name": "pnr_ref","value": $("#pnr_ref").val()},
		   {"name": "carrier","value": $("#carrier").val()},
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

	"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("biddatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("biddatatable"));
                //if (data) data.start = 0;
                return data;
            },

      "columns": [ {"data": "sno" },{"data": "offer_id" },
				   {"data": "passenger_list" },
				   {"data": "pnr_ref"},
				   {"data": "source_point" },
                   {"data": "dest_point" },
                   {"data": "departure_date" },
                   {"data": "carrier" },
                   {"data": "flight_number" },
                   {"data": "booking_status" },
		           {"data": "bid_info" }

				  ],			     
     dom: 'B<"clear">lfrtip',
    // buttons: [ 'copy', 'csv', 'excel','pdf' ]
      buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('offer_issue/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"flightNbr":$("#flight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#off_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"pnr_ref":$("#pnr_ref").val(),"carrier":$("#carrier").val(),"fromCabin": $("#from_cabin").val(),"toCabin":$("#to_cabin").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","offer_issue.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ] ,
     "autoWidth": false,
     "columnDefs": [ { "width": "20px", "targets": 0 } ]	
    });
	
	
  });
 
  function downloadOfferData(){
	  $.ajax({
           url: "<?php echo base_url('offer_issue/server_processing'); ?>?page=all&&export=1",
           type: 'get',
           data: {"flightNbr":$("#flight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#off_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"pnr_ref":$("#pnr_ref").val(),"carrier":$("#carrier").val(),"fromCabin": $("#from_cabin").val(),"toCabin":$("#to_cabin").val()},
           dataType: 'json'
       }).done(function(data){
		var $a = $("<a>");
		$a.attr("href",data.file);
		$("body").append($a);
		$a.attr("download","offer_issue.xls");
		$a[0].click();
		$a.remove();
	   });
  }
  
   $('#offertable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#offertable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
