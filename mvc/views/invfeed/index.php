<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>

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
		<?php if(permissionChecker('invfeed_upload')) { ?>
                  <a href="<?php echo base_url('invfeed/upload') ?>" class="btn btn-danger">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_invfeed')?>

                  </a>

		&nbsp;&nbsp;
                           <a href="<?php echo base_url('invfeed/downloadFormat') ?>" class="btn btn-danger">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('download_format')?>
                  </a>
                                 <?php } ?>


              </h5>
			 <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" style="padding:0;">		   
			<div class='form-group'>			 

			 <div class="col-sm-2">
               <?php
                        $airports['0'] = ' Origin Airport';
                        ksort($airports);

                                   echo form_dropdown("origin_airport", $airports,set_value("origin_airport",$origin_airport), "id='origin_airport' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


	    <div class="col-sm-2">
               <?php
                        $airports['0'] = ' Dest Airport';
                        ksort($airports);

                                   echo form_dropdown("dest_airport", $airports,set_value("dest_airport",$dest_airport), "id='dest_airport' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

 <div class="col-sm-2">
               <?php

	foreach($airlines as $airline){
                                     $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                                                         }

                        $airlinelist['0'] = ' Carrier';
                        ksort($airlinelist);

                                   echo form_dropdown("airline_code", $airlinelist,set_value("airline_code",$airline_code), "id='airline_code' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $cabins['0'] = ' Cabin';
                        ksort($cabins);

                                   echo form_dropdown("cabin", $cabins,set_value("cabin",$cabin), "id='cabin' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

	<div class="col-sm-2">
                 <input type="text" class="form-control" placeholder='flight range' id="flight_range" name="flight_range" value="<?=set_value('flight_range')?>" >


                </div>
<div class="col-sm-2">
                 <input type="text" class="form-control" placeholder='Departure Date' id="start_date" name="start_date" value="<?=set_value('start_date')?>" >


                </div>


                <div class="col-md-3 col-sm-6"><br>
                  <button type="submit" class="btn btn-danger" name="filter" id="filter">Filter</button>
				  <button type="button" class="btn btn-danger" onclick="downloadINVFeed()">Download</button>
                </div>	             				
			  </div>
			 </form>			
            <div id="hide-table">
               <table id="invfeedtable" class="table table-bordered dataTable no-footer">
                 <thead>
                    <tr>
			
			 <th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/># </th>
                        <th class="col-lg-1"><?=$this->lang->line('airline_code')?></th>
						<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
						<th class="col-lg-1"><?=$this->lang->line('orig_airport')?></th>
						<th class="col-lg-1"><?=$this->lang->line('dest_airport')?></th>
						<th class="col-lg-1"><?=$this->lang->line('cabin')?></th>
						<th class="col-lg-1"><?=$this->lang->line('departure_date')?></th>
						 <th class="col-lg-1"><?=$this->lang->line('empty_seats')?></th>
                                                <th class="col-lg-1"><?=$this->lang->line('sold_seats')?></th>
						
						 <th class="col-lg-1 noExport"><?=$this->lang->line('active')?></th>

						<?php if(permissionChecker('invfeed_delete') || permissionChecker('invfeed_view')){?>
                                                <th class="col-lg-1 noExport"><?=$this->lang->line('action')?></th>
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
      "stateSave": true,
      "sAjaxSource": "<?php echo base_url('invfeed/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "orgAirport","value": $("#origin_airport").val()},
                   {"name": "destAirport","value": $("#dest_airport").val()},
                   {"name": "Cabin","value": $("#cabin").val()},
                   {"name": "airLine","value": $("#airline_code").val()},
		           {"name": "flight_range","value": $("#flight_range").val()},
			       {"name": "start_date","value": $("#start_date").val()},
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },

	"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("invdatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("invdatatable"));
                if (data) data.start = 0;
                return data;
            },

      "columns": [{"data": "chkbox" },
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
    // buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
	 buttons: [ { text: 'Delete',
                  action: function(e, dt, node, config) {
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
							url: "<?php echo base_url('invfeed/delete_inv_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#invfeedtable').DataTable().ajax.reload();
					   $('#bulkDelete').prop("checked",false);
							},
							async:false
						});
					}
        		  }
	            },
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('invfeed/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"orgAirport":$("#origin_airport").val(),"destAirport":$("#dest_airport").val(),"Cabin":$("#cabin").val(),"airLine": $("#airline_code").val(),"flight_range":$("#flight_range").val(),"start_date":$("#start_date").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","invfeed.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
           		               
            ],
     "autoWidth":false,
	 "columnDefs": [ {"targets": 0,"width":"30px"}],
    });
	
	
  });
 
  function downloadINVFeed(){
	  $.ajax({
        url: "<?php echo base_url('invfeed/server_processing'); ?>?page=all&&export=1",
        type: 'get',
        data: {"orgAirport":$("#origin_airport").val(),"destAirport":$("#dest_airport").val(),"Cabin":$("#cabin").val(),"airLine": $("#airline_code").val(),"flight_range":$("#flight_range").val(),"start_date":$("#start_date").val()},
        dataType: 'json'
        }).done(function(data){
		var $a = $("<a>");
		$a.attr("href",data.file);
		$("body").append($a);
		$a.attr("download","invfeed.xls");
		$a[0].click();
		$a.remove();
	    });
  }
  
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

$(document).ready(function () {


$("#bulkDelete").on('click',function() { // bulk checked
        var status = this.checked;
        $(".deleteRow").each( function() {
          if(status == 1 && $(this).prop('checked')) {
                
          } else {
                if (status == false && $(this).prop('checked') == false) {

                } else {
                         $(this).prop("checked",status);
                        $(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
                }
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
                url: "<?php echo base_url('invfeed/delete_inv_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#invfeedtable').DataTable().ajax.reload();
		   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 


$('#invfeedtable').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });

});


$("#start_date").datepicker();


 </script>
