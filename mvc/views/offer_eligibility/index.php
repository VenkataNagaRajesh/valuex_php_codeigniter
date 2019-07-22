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
					<h4>Board/Off Point</h4>
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
					<h4>Cabins</h4>
					<div class="col-sm-12">
					<?php
                        $cabin['0'] = 'From Cabin';
                        ksort($cabin);
						echo form_dropdown("from_cabin", $cabin,set_value("from_cabin",$from_cabin), "id='from_cabin' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
					<div class="col-sm-12">
						<?php
							$cabin['0'] = 'To Cabin';
							ksort($cabin);
							echo form_dropdown("to_cabin", $cabin,set_value("to_cabin",$to_cabin), "id='to_cabin' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
				</div>


		 <div class="col-md-2 select-form">
                                        <h4>Season & Frequency</h4>
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
                                        <h4>Carrier & Status</h4>
                                        <div class="col-sm-12">
                                        <?php
                        $carriers['0'] = 'Carrier';
                        ksort($carriers);
                                                echo form_dropdown("carrier", $carriers,set_value("carrier"), "id='carrier' class='form-control hide-dropdown-icon select2'");    ?>
                                        </div>
                                        <div class="col-sm-12">
                                                <?php
                                                        $status['0'] = 'Booking Status';
                                                        ksort($status);
                                                        echo form_dropdown("booking_status", $status,set_value("booking_status"), "id='booking_status' class='form-control hide-dropdown-icon select2'");    ?>
                                        </div>
                                </div>


				<div class="col-md-2 select-form">
					<h4>Flight Nbr Range</h4>
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="Start range" id="flight_number" name="flight_number" value="<?=set_value('flight_number',$flight_number)?>" >
					</div>
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="End range" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
					</div>
				</div>
				<div class="col-md-2">
					<h4>Dep Date Range</h4>
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
				<div class="col-sm-2 pull-right">
                  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
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

      "columns": [ {"data": "dtpfext_id" },
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
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
	
	
  });
 
  
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
