<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>

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
                  <a href="<?php echo base_url('paxfeed/upload') ?>" class="btn btn-danger">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_paxfeed')?>
                  </a>

		    &nbsp;&nbsp;
                                  <a href="<?php echo base_url('paxfeed/downloadFormat') ?>" class="btn btn-danger">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('download_paxfeed_format')?>
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
                        $airports['0'] = ' Board Point';
                        ksort($airports);

                                   echo form_dropdown("from_city", $airports,set_value("from_city",$from_city), "id='from_city' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


    <div class="col-sm-2">
               <?php
                        $airports['0'] = ' Off Point';
                        ksort($airports);

                                   echo form_dropdown("to_city", $airports,set_value("to_city",$to_city), "id='to_city' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


<div class="col-sm-2">
               <?php
                        $airlines['0'] = ' Carrier';
                        ksort($airlines);

                                   echo form_dropdown("carrier_code", $airlines,set_value("carrier_code",$carrier_code), "id='carrier_code' class='form-control hide-dropdown-icon select2'");    ?>


                </div>

 <div class="col-sm-2">
 <input type="text" class="form-control" placeholder='frequency' id="frequency" name="frequency" value="<?=set_value('frequency')?>" >

                </div>

<div class="col-sm-2">
 <input type="text" class="form-control" placeholder='Flight range' id="flight_range" name="flight_range" value="<?=set_value('flight_range')?>" >

                </div>



 <div class="col-sm-2">
               <?php
                        $pax_type['0'] = ' Pax Type';
                        ksort($pax_type);

                                   echo form_dropdown("pax_type", $pax_type,set_value("pax_type"), "id='pax_type' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

<div class="col-sm-2">
 <input type="text" class="form-control" placeholder='Pax ID' id="pf_id" name="pf_id" value="<?=set_value('pf_id',$pf_id)?>" >

                </div>



    <div class="col-sm-2">
               <?php

			$tier_arr = array('1' => '1', '2' =>'2', '3' => '3');
                        $tier_arr['0'] = ' Tier';
                        ksort($tier_arr);

                                   echo form_dropdown("tier", $tier_arr,set_value("tier"), "id='tier' class='form-control hide-dropdown-icon select2'");    ?>

                </div>



<div class="col-sm-2">
                 <input type="text" class="form-control" placeholder='Dep Start Date' id="start_date" name="start_date" value="<?=set_value('start_date')?>" >


                </div>


                <div class="col-sm-2">
                 <input type="text" class="form-control" placeholder='Dep End Date' id="end_date" name="end_date" value="<?=set_value('end_date')?>" >


                </div>





                <div class="col-md-2 col-sm-6">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter">Filter</button>
				   <button type="button" class="btn btn-danger" onclick="downloadPAXFeed()">Download</button>
                </div>	             				
			  </div>
			 </form>			

<div class="col-md-12">
                <div class="col-md-12">
                        <div class="tab-content table-responsive" id="hide-table">
               <table id="paxfeedtable" class="table table-bordered dataTable no-footer">
                 <thead>
                    <tr>
			 <th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
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
                        <th class="col-lg-1">Board Point</th>
                        <th class="col-lg-1">Off Point</th>
			<th class="col-lg-1">Tier</th>
			<th class="col-lg-1">Frequency</th>
                         <th class="col-lg-1"><?=$this->lang->line('pax_contact_email')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('phone')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('booking_country')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('booking_city')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('office_id')?></th>
                         <th class="col-lg-1"><?=$this->lang->line('channel')?></th>
			
			
		 <th class="col-lg-1 noExport"><?=$this->lang->line('active')?></th>

	<?php if(permissionChecker('paxfeed_delete')){?>
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
   </div>
</div>
<script>
 $(document).ready(function() {	 
	
    $('#paxfeedtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('paxfeed/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "bookingCountry","value": $("#booking_country").val()},
                   {"name": "bookingCity","value": $("#booking_city").val()},
                   {"name": "fromCity","value": $("#from_city").val()},
                   {"name": "toCity","value": $("#to_city").val()},
				   {"name": "pax_type","value": $("#pax_type").val()},
				   {"name": "tier","value": $("#tier").val()},
				   {"name": "flight_range","value": $("#flight_range").val()},
				   {"name": "start_date","value": $("#start_date").val()},
				   {"name": "end_date","value": $("#end_date").val()},
				   {"name": "frequency","value": $("#frequency").val()},
				   {"name": "pf_id","value": $("#pf_id").val()},
                   {"name": "carrierCode","value": $("#carrier_code").val()},
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 
      "columns": [{"data": "chkbox" },
                  {"data": "airline_code" },
				  {"data": "pnr_ref" },
				  {"data": "pax_nbr"},
                                  {"data": "first_name" },
				{"data": "last_name"},
                                  {"data": "ptc_code" },
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
				 {"data": "tier" },
				{"data": "frequency" },
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
    // buttons: [ 'copy', 'csv', 'excel','pdf' ]
        buttons: [
		         { text: 'Delete', exportOptions: { columns: ':visible' },
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
							url: "<?php echo base_url('paxfeed/delete_pax_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#paxfeedtable').DataTable().ajax.reload();
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
                                url: "<?php echo base_url('paxfeed/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"bookingCountry":$("#booking_country").val(),"bookingCity":$("#booking_city").val(),"fromCity":$("#from_city").val(),"toCity":$("#to_city").val(),"pax_type":$("#pax_type").val(),"tier":$("#tier").val(),"flight_range":$("#flight_range").val(),"start_date":$("#start_date").val(),"end_date":$("#end_date").val(),"frequency":$("#frequency").val(),"pf_id": $("#pf_id").val(),"carrierCode":$("#carrier_code").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","paxfeed.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ],        
            

	"columnDefs": [ {"targets": 0,"width": "50px" }]

    });
	
	
  });
 
  function downloadPAXFeed(){
	  $.ajax({
        url: "<?php echo base_url('paxfeed/server_processing'); ?>?page=all&&export=1",
        type: 'get',
        data: {"bookingCountry":$("#booking_country").val(),"bookingCity":$("#booking_city").val(),"fromCity":$("#from_city").val(),"toCity":$("#to_city").val(),"pax_type":$("#pax_type").val(),"tier":$("#tier").val(),"flight_range":$("#flight_range").val(),"start_date":$("#start_date").val(),"end_date":$("#end_date").val(),"frequency":$("#frequency").val(),"pf_id": $("#pf_id").val(),"carrierCode":$("#carrier_code").val()},
        dataType: 'json'
        }).done(function(data){
		var $a = $("<a>");
		$a.attr("href",data.file);
		$("body").append($a);
		$a.attr("download","paxfeed.xls");
		$a[0].click();
		$a.remove();
	   });
  }
  
   $('#paxfeedtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#paxfeedtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
$('#start_date').datepicker();
$('#end_date').datepicker();



$("#start_date").datepicker({
    }).on('changeDate', function (ev) {
        $('#end_date').val("").datepicker("update");
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#end_date').datepicker('setStartDate', minDate);
         $("#end_date").datepicker("setDate" , $(this).val());
    });

    $("#end_date").datepicker()
        .on('changeDate', function (selected) {

                var dates = $(this).val();
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#start_date').datepicker('setEndDate', maxDate);
        });

$(document).ready(function() { 

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
                url: "<?php echo base_url('paxfeed/delete_pax_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#paxfeedtable').DataTable().ajax.reload();
		  $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 


$('#paxfeedtable').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });


});
 </script>
