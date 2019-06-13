<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_paxfeed')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
              <h5 class="page-header">                        
		<?php if(permissionChecker('paxfeed_upload')) { ?>
                  <a href="<?php echo base_url('paxfeed/upload') ?>">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_paxfeed')?>
                  </a>

		    &nbsp;&nbsp;
                                  <a href="<?php echo base_url('paxfeed/downloadFormat') ?>">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('download_paxfeed_format')?>
                  </a>
                                 <?php } ?>

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
                        $city['0'] = 'Select From City';
                        ksort($city);

                                   echo form_dropdown("from_city", $city,set_value("from_city",$from_city), "id='from_city' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $city['0'] = 'Select To City';
                        ksort($city);

                                   echo form_dropdown("to_city", $city,set_value("to_city",$to_city), "id='to_city' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


<div class="col-sm-2">
               <?php
                        $airlines['0'] = 'Select Carrier';
                        ksort($airlines);

                                   echo form_dropdown("carrier_code", $airlines,set_value("carrer_code",$airline_code), "id='carrer_code' class='form-control hide-dropdown-icon select2'");    ?>

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
                        <th class="col-lg-2"><?=$this->lang->line('airline_code')?></th>
			<th class="col-lg-1"><?=$this->lang->line('pnr_ref')?></th>
			<th class="col-lg-1"><?=$this->lang->line('pax_nbr')?></th>
			<th class="col-lg-1"><?=$this->lang->line('first_name')?></th>
			<th class="col-lg-1"><?=$this->lang->line('last_name')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('ptc')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('fqtv')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('carrier_code')?></th>
			<th class="col-lg-1"><?=$this->lang->line('seg_nbr')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
			<th class="col-lg-1"><?=$this->lang->line('dep_date')?></th>
			<th class="col-lg-1"><?=$this->lang->line('dep_time')?></th>
			<th class="col-lg-1"><?=$this->lang->line('arrival_date')?></th>
			<th class="col-lg-1"><?=$this->lang->line('arrival_time')?></th>
			<th class="col-lg-1"><?=$this->lang->line('class')?></th>
			<th class="col-lg-1"><?=$this->lang->line('cabin')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('from_city')?></th>

                        <th class="col-lg-1"><?=$this->lang->line('to_city')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('pax_contact_email')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('phone')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('booking_country')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('booking_city')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('office_id')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('channel')?></th>
			
			
		 <th class="col-lg-1"><?=$this->lang->line('active')?></th>

	<?php if(permissionChecker('paxfeed_delete')){?>
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
      "sAjaxSource": "<?php echo base_url('paxfeed/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "bookingCountry","value": $("#booking_country").val()},
                   {"name": "bookingCity","value": $("#booking_city").val()},
                   {"name": "fromCity","value": $("#from_city").val()},
                   {"name": "toCity","value": $("#to_city").val()},
                    {"name": "carrierCode","value": $("#carrier_code").val()},
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [{"data": "dtpf_id" },
                  {"data": "airline_code" },
				  {"data": "pnr_ref" },
				  {"data": "pax_nbr"},
                                  {"data": "first_name" },
				{"data": "last_name"},
                                  {"data": "ptc" },
                                {"data": "fqtv"},
                                 {"data": "carrier_code" },
				{"data": "seg_nbr" },
				{"data": "flight_number" },
                                {"data": "dep_date" },
				{"data": "dept_time" },
				{"data": "arrival_date" },
				{"data": "arrival_time" },
				 {"data": "class" },
				 {"data": "cabin" },
				{"data": "from_city" },
				
                                  {"data": "to_city" },
                                  {"data": "pax_contact_email"},

                                  {"data": "phone"},
				 {"data": "booking_country" },
				 {"data": "booking_city" },
                                  {"data": "office_id"},
				    {"data": "channel" },
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
              url: "<?=base_url('paxfeed/active')?>",
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
