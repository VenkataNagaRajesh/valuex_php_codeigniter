<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_airline_cabin_class')?></li>           
        </ol>
    </div><!-- /.box-header -->
	 <h5 class="page-header">

                <?php
                    if(permissionChecker('airline_cabin_class_add')) {
                ?>
                        <a href="<?php echo base_url('airline_cabin_class/add') ?>" data-toggle="tooltip" data-title="Add Carrier Cabin Class Mapping" data-placement="left" class="btn btn-danger">
                            <i class="fa fa-plus"></i>
                        </a>
		<?php } ?>

	</h5>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">			
			  <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?=$this->lang->line("panel_title")?></a></li>       
               </ul>

	<br/> <br/>                
       <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
                           <div class="col-sm-2">
               <?php $airlinesdata['0'] = " Airlines";
			ksort($airlinesdata);
                                   echo form_dropdown("carrier", $airlinesdata,set_value("carrier",$carrer), "id='carrier' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                 <div class="col-sm-2">

			<?php
			
                        $airlinecabins['0'] = " Cabin";
			ksort($airlinecabins);
                        echo form_dropdown("airline_cabin", $airlinecabins,set_value("airline_cabin",$cabinID), "id='airline_cabin' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

		 <div class="col-sm-2">

                        <?php
                        $map_status['-1'] = ' Status';
                        $map_status['1'] = 'Active';
                        $map_status['0'] = 'In Active';
                        echo form_dropdown("active", $map_status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>


                <div class="col-sm-2">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter">Filter</button>
				  <button type="button" class="btn btn-danger" name="filter" onclick="downloadCabinmap()">Download</button>
                </div>
                          </div>
                         </form>

		
		
	       <div class="tab-content">
                <div id="all" class="tab-pane active">
                  <div id="hide-table">
                    <table id="carriermaptable" class="table table-bordered dataTable no-footer">
                       <thead>
                            <tr>
				<th><input type="checkbox" id="bulkDelete"/> <button id="deleteTriger">Delete All</button></th>
				<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('airline_cabin')?></th>
				<th class="col-lg-1"><?=$this->lang->line('airline_class')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('is_revenue')?></th>
				<th class="col-lg-1"><?=$this->lang->line('order')?></th>
                                <?php if(permissionChecker('airline_cabin_class_edit')) { ?>
                                        <th class="col-lg-1 noExport"><?=$this->lang->line('airline_cabin_status')?></th>
                                <?php } ?>

                                 <?php if(permissionChecker('airline_cabin_class_edit') || permissionChecker('airline_cabin_class_view') ||  permissionChecker('airline_cabin_class_delete')) { ?>
                                <th class="col-lg-1 noExport"><?=$this->lang->line('action')?></th>
                                <?php } ?>

	
                            </tr>
                        </thead>
						<tbody>                           
                        </tbody>
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
</div>


<script type="text/javascript">
  $(document).ready(function() {

  $( ".select2" ).select2();

    $('#carriermaptable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('airline_cabin_class/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "carrier","value": $("#carrier").val()},
		   {"name": "cabinID","value": $("#airline_cabin").val()},
			{"name": "active","value": $("#active").val()})
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
      "columns": [{"data": "chkbox" },
		  {"data": "carrier_name"},
		   {"data": "airline_cabin"},
                  {"data": "airline_class" },
		  {"data": "is_revenue" },
		  {"data": "order" },
		  {"data": "active"},
                  {"data": "action"}

				  ],			   
	//"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']	
	dom: 'B<"clear">lfrtip',
    //buttons: [ 'copy', 'csv', 'excel','pdf' ]
	 buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('airline_cabin_class/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"carrier": $("#carrier").val(),"cabinID":$("#airline_cabin").val(),"active": $("#active").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","airline_cabin_class.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }	                
            ] ,
	 "autoWidth": false,
     "columnDefs": [ {"targets": 0,"orderable": false,"searchable": false,"width": "5px" },{ "width": "30px", "targets": 5 } ]
    });
  });
  
  function downloadCabinmap(){
	 $.ajax({
          url: "<?php echo base_url('airline_cabin_class/server_processing'); ?>?page=all&&export=1",
          type: 'get',
          data: {"carrier": $("#carrier").val(),"cabinID":$("#airline_cabin").val(),"active": $("#active").val()},
          dataType: 'json'
      }).done(function(data){
		var $a = $("<a>");
		$a.attr("href",data.file);
		$("body").append($a);
		$a.attr("download","airline_cabin_class.xls");
		$a[0].click();
		$a.remove();
		}); 
  }
  
   $('#carriermaptable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });

 var status = '';
  var id = 0;
 $('#carriermaptable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('airline_cabin_class/active')?>",
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

 $(document).ready(function () {

	$("#bulkDelete").on('click',function() { // bulk checked
        var status = this.checked;
        $(".deleteRow").each( function() {
          if(status == 1 && $(this).prop('checked')) {
                
          } else {
            $(this).prop("checked",status);
            $(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
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
                url: "<?php echo base_url('airline_cabin_class/delete_carrier_map_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#carriermaptable').DataTable().ajax.reload();
		   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 



   $('#carriermaptable').on('click', 'input[type="checkbox"]', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });


 });
  
</script>
