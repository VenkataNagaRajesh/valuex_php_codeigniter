<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_rafeed')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
              <h5 class="page-header">                        
                  <a href="<?php echo base_url('rafeed/upload') ?>">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_rafeed')?>
                  </a>
              </h5>
			 <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 

			 <div class="col-sm-2">
               <?php
                        $country['0'] = 'Select Booking Country';
                        ksort($country);

                                   echo form_dropdown("booking_country", $country,set_value("booking_country",$booking_country), "id='booking_country' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


	    <div class="col-sm-2">
               <?php
                        $city['0'] = 'Select Booking City';
                        ksort($city);

                                   echo form_dropdown("booking_city", $city,set_value("booking_city",$booking_city), "id='booking_city' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $country['0'] = 'Select Boarding Point';
                        ksort($country);

                                   echo form_dropdown("boarding_point", $country,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $country['0'] = 'Select Off Point';
                        ksort($country);

                                   echo form_dropdown("off_point", $country,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


<div class="col-sm-2">
               <?php
                        $airlines['0'] = 'Select Airlines';
                        ksort($airlines);

                                   echo form_dropdown("airline_code", $airlines,set_value("airline_code",$airline_code), "id='airline_code' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $class['0'] = 'Select Class';
                        ksort($class);

                                   echo form_dropdown("class", $class,set_value("class",$cla), "id='class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>			
            <div id="hide-table">
               <table id="rafeedtable" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-2"><?=$this->lang->line('ticket_number')?></th>
						<th class="col-lg-1"><?=$this->lang->line('coupon_number')?></th>
						<th class="col-lg-1"><?=$this->lang->line('coupon_value')?></th>
						<th class="col-lg-1"><?=$this->lang->line('booking_country')?></th>
						<th class="col-lg-1"><?=$this->lang->line('booking_city')?></th>
						<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
						 <th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
                                                <th class="col-lg-1"><?=$this->lang->line('airline_code')?></th>
                                                <th class="col-lg-1"><?=$this->lang->line('board_point')?></th>

						 <th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
                                                <th class="col-lg-1"><?=$this->lang->line('cabin')?></th>
                                                <th class="col-lg-1"><?=$this->lang->line('class')?></th>

                                                <th class="col-lg-1"><?=$this->lang->line('flight_date')?></th>

                                                 <th class="col-lg-1"><?=$this->lang->line('fare_basis')?></th>
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
                    {"name": "airLine","value": $("#airline_code").val()},
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [{"data": "rafeed_id" },
                  {"data": "ticket_number" },
				  {"data": "cpn_number" },
				  {"data": "cpn_value" },
				  {"data": "booking_country"},
                                  {"data": "booking_city" },
				 {"data": "carrier" },
                                  {"data": "flight_number" },
                                  {"data": "airline_code"},

                                  {"data": "boarding_point"},
				 {"data": "off_point" },
                                  {"data": "cabin" },
                                  {"data": "class"},
				 {"data": "flight_date" },
                                  {"data": "fare_basis" },
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

 </script>
