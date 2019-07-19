<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_rafeed')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body rafeed">
        <div class="row">
            <div class="col-sm-12">              

              <h5 class="page-header">                        
		<?php if(permissionChecker('rafeed_upload')) { ?>
                  <a href="<?php echo base_url('rafeed/upload') ?>" class="btn btn-danger">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_rafeed')?>
                  </a>
		
		   &nbsp;&nbsp;
                                  <a href="<?php echo base_url('rafeed/downloadFormat') ?>" class="btn btn-danger">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('download_rafeed_format')?>
                  </a>
                                 <?php } ?>


              </h5>
			 <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 

			 <div class="col-sm-2">
               <?php
                        $country['0'] = ' Booking Country';
                        ksort($country);

                                   echo form_dropdown("booking_country", $country,set_value("booking_country",$booking_country), "id='booking_country' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


	    <div class="col-sm-2">
               <?php
                        $city['0'] = ' Booking City';
                        ksort($city);

                                   echo form_dropdown("booking_city", $city,set_value("booking_city",$booking_city), "id='booking_city' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $airport['0'] = ' Boarding Point';
                        ksort($airport);

                                   echo form_dropdown("boarding_point", $airport,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $airport['0'] = ' Off Point';
                        ksort($airport);

                                   echo form_dropdown("off_point", $airport,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


<div class="col-sm-2">
               <?php

                                                     
			foreach($airlines as $airline){
                                     $airlinelist[$airline->vx_aln_data_defnsID] = $airline->aln_data_value.'('.$airline->code.')';
                                                         }

                        $airlinelist['0'] = ' Carrier';
                        ksort($airlinelist);

                                   echo form_dropdown("airline_code", $airlinelist,set_value("airline_code",$airline_code), "id='airline_code' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $cabin['0'] = ' Cabin';
                        ksort($cabin);

                                   echo form_dropdown("class", $cabin,set_value("class",$cla), "id='class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

<div class="col-sm-2">
		 <input type="text" class="form-control" placeholder='flight range' id="flight_range" name="flight_range" value="<?=set_value('flight_range')?>" >


                </div>


<div class="col-sm-2">
                 <input type="text" class="form-control" placeholder='Start Date' id="start_date" name="start_date" value="<?=set_value('start_date')?>" >


                </div>


                <div class="col-sm-2">
                 <input type="text" class="form-control" placeholder='End Date' id="end_date" name="end_date" value="<?=set_value('end_date')?>" >


                </div>

		<div class="col-sm-2">
 <input type="text" class="form-control" placeholder='frequency' id="frequency" name="frequency" value="<?=set_value('frequency')?>" >

                </div>







                <div class="col-sm-2 pull-right">
                  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>			
            <div id="hide-table">
               <table id="rafeedtable" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
			 <th class="col-lg-2"><?=$this->lang->line('airline_code')?></th>
                        <th class="col-lg-2"><?=$this->lang->line('ticket_number')?></th>
			<th class="col-lg-1"><?=$this->lang->line('coupon_number')?></th>
			<th class="col-lg-1"><?=$this->lang->line('booking_country')?></th>
			<th class="col-lg-1"><?=$this->lang->line('booking_city')?></th>
			<th class="col-lg-1"><?=$this->lang->line('issuance_country')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('issuance_city')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
			<th class="col-lg-1"><?=$this->lang->line('prorated_price')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('cabin')?></th>
			<th class="col-lg-1"><?=$this->lang->line('class')?></th>
			<th class="col-lg-1"><?=$this->lang->line('fare_basis')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('departure_date')?></th>

                        <th class="col-lg-1"><?=$this->lang->line('day_of_week')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('operating_airline_code')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('marketing_airline_code')?></th>
			<th class="col-lg-1"><?php echo "Carrier Code";?></th>
                        <th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('office_id')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('channel')?></th>
			<th class="col-lg-1"><?=$this->lang->line('pax_type')?></th>
			
			
		 <th class="col-lg-1"><?=$this->lang->line('active')?></th>

	<?php if(permissionChecker('rafeed_delete') || permissionChecker('rafeed_view')){?>
                                <th class="col-lg-1"><?=$this->lang->line('action')?></th>
						<?php }?>
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
	
    $('#rafeedtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('rafeed/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "bookingCountry","value": $("#booking_country").val()},
                   {"name": "bookingCity","value": $("#booking_city").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#offPoint").val()},
                   {"name": "Class","value": $("#class").val()},
			{"name": "frequency","value": $("#frequency").val()},
                    {"name": "airLine","value": $("#airline_code").val()},
		   {"name": "flight_range","value": $("#flight_range").val()},
		  {"name": "start_date","value": $("#start_date").val()},
		  {"name": "end_date","value": $("#end_date").val()},

                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [{"data": "rafeed_id" },
		  {"data": "airline_code" },
                  {"data": "ticket_number" },
				  {"data": "coupon_number" },
				  {"data": "booking_country"},
                                  {"data": "booking_city" },
				{"data": "issuance_country"},
                                  {"data": "issuance_city" },
                                {"data": "boarding_point"},
                                 {"data": "off_point" },
				{"data": "prorated_price" },
				{"data": "cabin" },
                                {"data": "class" },
				{"data": "fare_basis" },
				{"data": "departure_date" },
                                  {"data": "day_of_week" },

                                  {"data": "operating_airline_code"},
				 {"data": "marketing_airline_code" },
				 {"data": "carrier_code" },
				 {"data": "flight_number" },
                                  {"data": "office_id"},
				    {"data": "channel" },
                                  {"data": "pax_type"},
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
              url: "<?=base_url('rafeed/active')?>",
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

$("#start_date").datepicker();
$("#end_date").datepicker();

 </script>
