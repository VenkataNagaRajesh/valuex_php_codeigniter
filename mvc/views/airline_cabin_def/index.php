
<div class="box ar-cab-def">
    <div class="box-header">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_airline_cabin')?></li>           
        </ol>
    </div><!-- /.box-header -->
	<h5 class="page-header">
			<?php
                    if(permissionChecker('airline_cabin_def_add')) {
                ?>
                        <a href="<?php echo base_url('airline_cabin_def/add') ?>" data-toggle="tooltip" data-title="Add Airline Cabin" data-placement="left" class="btn btn-danger">
                            <i class="fa fa-plus"></i>
                        </a>
			<?php } ?>
	</h5>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">			
			  <div class="nav-tabs-custom" style="display:flex;margin-bottom:0;">
               <!--<ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?=$this->lang->line("panel_title")?></a></li>       
               </ul>-->                
	<div class="col-md-12">
       <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" style="padding:0 15px;">
                      <div class='form-group' style="display:flex;align-items:center;">
                           <div class="col-sm-2">
               <?php 

                         foreach($airlinesdata as $airline){
                                $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
				}

                                                        $airlinelist[0]= 'Carrier';
                                                        ksort($airlinelist);



                                   echo form_dropdown("carrier", $airlinelist,set_value("carrier",$airlineID), "id='carrier' class='form-control hide-dropdown-icon select2'");    ?>
                </div>

		 <div class="col-sm-2">

                        <?php
                        $map_status['-1'] = ' Status';
                        $map_status['1'] = 'Active';
                        $map_status['0'] = 'In Active';
                        echo form_dropdown("active", $map_status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>


                <div class="col-sm-8 text-right">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter" data-title="Filter" data-toggle="tooltip"><i class="fa fa-filter"></i></button>
				  <button type="button" class="btn btn-danger" name="filter" onclick="downloadCabins()" data-title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></button>			   
                </div>
				
                          </div>
                         </form>

		</div>
 </div>
                <div class="col-md-12">
                        <div class="tab-content table-responsive" id="hide-table">
                                <table id="cabindeftable" class="table table-bordered dataTable no-footer">
                                  <thead>
                                           <tr>
		
				 <th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
                                <th class="col-lg-1">Carrier</th>
                                <th class="col-lg-1">Cabin</th>
				<th class="col-lg-1">Level</th>
                                                <th class="col-lg-1">Description</th>
                                <?php if(permissionChecker('airline_cabin_edit')) { ?>
                                  <th class="col-lg-1 noExport">Active</th>
                                <?php } ?>

                                 <?php if(permissionChecker('airline_cabin_edit') ||  permissionChecker('airline_cabin_delete')) { ?>
                                <th class="col-lg-1 noExport"><?=$this->lang->line('action')?></th>
                                <?php } ?>


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


<script type="text/javascript">
  $(document).ready(function() {

  
  $( ".select2" ).select2();

    $('#cabindeftable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "stateSave": true,
      "sAjaxSource": "<?php echo base_url('airline_cabin_def/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "carrier","value": $("#carrier").val()},
			{"name": "active","value": $("#active").val()})
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
		"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("aircabindatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("aircabindatatable"));
                if (data) data.start = 0;
                return data;
            },

      "columns": [{"data": "chkbox" },
		   {"data": "carrier_name"},
		  {"data": "cabin"},
		  {"data": "level"},
		  {"data": "desc"},
		  {"data": "active"},
                  {"data": "action"}

				  ],			   
	//"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']	
	dom: 'B<"clear">lfrtip',
   // buttons: [ 'copy', 'csv', 'excel','pdf' ]
     buttons: [ {text: 'Delete',
				  action: function ( e, dt, node, config ) {
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
							url: "<?php echo base_url('airline_cabin/delete_airline_cabins_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#cabindeftable').DataTable().ajax.reload();
					   $('#bulkDelete').prop("checked",false);
							},
							async:false
						});
					}  
				  }
	            },
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export'} },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },{ text: 'Export All', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('airline_cabin_def/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"airlineID": $("#carrier").val(),"active": $("#active").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","airline_cabin.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }	                
            ] ,
	 "autoWidth": false,
     "columnDefs":  [ {"targets":5,
	                 render: function ( data, type, row, meta ) {
                       console.log(type);						 
						if(type == 'export'){
                          return $(data).attr("href");
						} else {
						  return data;	
						}                      
                   }},{"targets": 0,"width": "1%"}]
	 
    });
  });
  
  function downloadCabins(){
	  $.ajax({
           url: "<?php echo base_url('airline_cabin_def/server_processing'); ?>?page=all&&export=1",
           type: 'get',
           data: {"airlineID": $("#carrier").val(),"cabinID": $("#airline_cabin").val(),"active": $("#active").val()},
           dataType: 'json'
       }).done(function(data){
		  var $a = $("<a>");
		  $a.attr("href",data.file);
		  $("body").append($a);
		  $a.attr("download","airline_cabin.xls");
		  $a[0].click();
		  $a.remove();
		 });
  }
  
   $('#cabindeftable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });

 var status = '';
  var id = 0;
 $('#cabindeftable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('airline_cabin_def/active')?>",
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
                url: "<?php echo base_url('marketzone/delete_mz_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#cabindeftable').DataTable().ajax.reload();
		   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 


$('#cabindeftable').on('click', '.deleteRow', function() {
	$(this).not("#bulkDelete").closest('tr').toggleClass('rowselected', this.checked);
});


});
</script>
