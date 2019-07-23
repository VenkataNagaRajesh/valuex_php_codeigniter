<div class="off-elg">
	<h2 class="title-tool-bar">Bid Details</h2>
	<div class="col-md-12 off-elg-filter-box">
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">	
			<div class="form-group">
				<div class="col-md-2 select-form">
					<h4>Board/Off Point</h4>
					<div class="col-sm-12">
						<?php
							$airports['0'] = 'Select Boarding Point';
							ksort($airports);
							echo form_dropdown("boarding_point", $airports,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
					 <div class="col-sm-12">
						<?php
							$airports['0'] = 'Select Off Point';
							ksort($airports);
							echo form_dropdown("off_point", $airports,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
				</div>
				<div class="col-md-2 select-form">
					<h4>Cabins</h4>
					<div class="col-sm-12">
						<?php
							$cabins['0'] = 'Select From Cabin';
							ksort($cabins);
							echo form_dropdown("from_cabin", $cabins,set_value("from_cabin",$from_cabin), "id='from_cabin' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
					<div class="col-sm-12">
						<?php
							$cabins['0'] = 'Select To cabin';
							ksort($cabins);
							echo form_dropdown("to_cabin", $cabins,set_value("to_cabin",$to_cabin), "id='to_cabin' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
				</div>
				<div class="col-md-2 select-form">
					<h4>Flight Number Range</h4>
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="Start range " id="flight_number" name="flight_number" value="<?=set_value('flight_number',$flight_number)?>" >
					</div>
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="End range " id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
					</div>
				</div>
				<div class="col-md-2">
					<h4>Departure Date Range</h4>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Dep Start Date" id="dep_from_date" name="dep_from_date" value="<?=set_value('dep_from_date',$dep_from_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Dep End Date" id="dep_to_date" name="dep_to_date" value="<?=set_value('dep_to_date',$dep_to_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>

				<div class="col-md-2 select-form">
                                        <h4>PNR ref AND Offer Status</h4>
                                        <div class="col-sm-12">
                                                <input type="text" class="form-control" placeholder="PNR Ref" id="pnr_ref" name="pnr_ref" value="<?=set_value('pnr_ref')?>" >
                                        </div>
                                        <div class="col-sm-12">
<?php 
 $status['0'] = 'Offer Status';
                                                        ksort($status);
                                                        echo form_dropdown("offer_status", $status,set_value("offer_status"), "id='offer_status' class='form-control hide-dropdown-icon select2'");    ?>

                                        </div>
                                </div>

				   <div class="col-md-2 select-form">
                                        <h4>OfferID</h4>
                                        <div class="col-sm-12">
                                                <input type="text" class="form-control" placeholder="OfferID" id="offer_id" name="offer_id" value="<?=set_value('offer_id')?>" >
                                        </div>
				</div>

			
				<div class="col-sm-2 pull-right">
					<button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 off-elg-table">
		<div class="col-md-12">
			<div id="hide-table">
				 <table id="rafeedtable" class="table table-bordered">
					 <thead>
						<tr>
							<th class="col-lg-1"><?=$this->lang->line('offer_id')?></th>
							<th class="col-lg-1"><?=$this->lang->line('offer_date')?></th>
							<th class="col-lg-1">Carrier</th>
							<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
							<th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
							<th class="col-lg-1"><?=$this->lang->line('current_cabin')?></th>
							<th class="col-lg-1"><?=$this->lang->line('bid_cabin')?></th>
							<th class="col-lg-1"><?=$this->lang->line('bid_amount')?></th>
							 <th class="col-lg-1"><?php echo "Submit Date";?></th>
							<th class="col-lg-1"><?=$this->lang->line('pax_names')?></th>
							<th class="col-lg-1"><?=$this->lang->line('fqtv')?></th>
							<th class="col-lg-1"><?=$this->lang->line('pnr_ref')?></th>
							<th class="col-lg-1"><?=$this->lang->line('number_psgr')?></th>
							<th class="col-lg-1"><?=$this->lang->line('avg_p')?></th>
							<th class="col-lg-1"><?=$this->lang->line('cash')?></th>
							<th class="col-lg-1"><?=$this->lang->line('miles')?></th>
							<th class="col-lg-1"><?=$this->lang->line('offer_status')?></th>
							<th class="col-lg-1 noExport"><?=$this->lang->line('details')?></th>
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

    $('#rafeedtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('offer_table/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#flight_number").val()},
		  {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#off_point").val()},
		    {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
		  {"name": "fromCabin","value": $("#from_cabin").val()},
                   {"name": "toCabin","value": $("#to_cabin").val()},
		  {"name": "offer_id","value": $("#offer_id").val()},
		  {"name": "pnr_ref","value": $("#pnr_ref").val()},
		  {"name": "offer_status","value": $("#offer_status").val()},
                  
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [
		   {"data": "offer_id" },
		   {"data": "offer_date" },
		   {"data": "carrier" },
		   {"data": "flight_number" },
		   {"data": "flight_date"},
		   {"data": "from_city" },
                   {"data": "to_city" },
                   {"data": "from_cabin" },
                   {"data": "to_cabin" },
                   {"data": "bid_value" },
		     {"data": "bid_submit_date" },
		   {"data": "p_list" },
		   {"data": "fqtv" },
                   {"data": "pnr_ref" },
                {"data": "p_count" },
		 {"data": "avg_fare" },
                {"data": "cash" },
		{"data": "miles" },
		{"data": "offer_status" },
		{"data": "action" }

				  ],			     
     dom: 'B<"clear">lfrtip',
     //buttons: [ 'copy', 'csv', 'excel','pdf' ]
      buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } }                
            ]	 
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
