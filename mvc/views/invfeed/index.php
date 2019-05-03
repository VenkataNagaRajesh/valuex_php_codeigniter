<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_invfeed')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
              <h5 class="page-header">                        
                  <a href="<?php echo base_url('invfeed/upload') ?>">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_invfeed')?>
                  </a>
              </h5>
			 <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 

			 <div class="col-sm-2">
               <?php
                        $airports['0'] = 'Select Origin Airport';
                        ksort($airports);

                                   echo form_dropdown("origin_airport", $airports,set_value("origin_airport",$origin_airport), "id='origin_airport' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


	    <div class="col-sm-2">
               <?php
                        $airports['0'] = 'Select Dest Airport';
                        ksort($airports);

                                   echo form_dropdown("dest_airport", $airports,set_value("dest_airport",$dest_airport), "id='dest_airport' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

 <div class="col-sm-2">
               <?php
                        $airlines['0'] = 'Select Airlines';
                        ksort($airlines);

                                   echo form_dropdown("airline_code", $airlines,set_value("airline_code",$airline_code), "id='airline_code' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $cabins['0'] = 'Select Cabin';
                        ksort($class);

                                   echo form_dropdown("cabin", $cabins,set_value("cabin",$cabin), "id='cabin' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>			
            <div id="hide-table">
               <table id="invfeedtable" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('airline_code')?></th>
						<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
						<th class="col-lg-1"><?=$this->lang->line('orig_airport')?></th>
						<th class="col-lg-1"><?=$this->lang->line('dest_airport')?></th>
						<th class="col-lg-1"><?=$this->lang->line('cabin')?></th>
						<th class="col-lg-1"><?=$this->lang->line('departure_date')?></th>
						 <th class="col-lg-1"><?=$this->lang->line('empty_seats')?></th>
                                                <th class="col-lg-1"><?=$this->lang->line('sold_seats')?></th>
						
						 <th class="col-lg-1"><?=$this->lang->line('active')?></th>

						<?php if(permissionChecker('invfeed_delete') || permissionChecker('invfeed_view')){?>
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
	
    $('#invfeedtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('invfeed/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "orgAirport","value": $("#origin_airport").val()},
                   {"name": "destAirport","value": $("#dest_airport").val()},
                   {"name": "Cabin","value": $("#cabin").val()},
                    {"name": "airLine","value": $("#airline_code").val()},
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },

      "columns": [{"data": "invfeed_id" },
                  {"data": "airline_code" },
				  {"data": "flight_nbr" },
				  {"data": "origin_airport" },
				  {"data": "dest_airport"},
                                  {"data": "cabin" },
				 {"data": "departure_date" },
                                  {"data": "empty_seats" },
                                  {"data": "sold_seats"},
					{"data": "active"},
				  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
	
	
  });
 
  
   $('#invfeedtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#invfeedtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('invfeed/active')?>",
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
