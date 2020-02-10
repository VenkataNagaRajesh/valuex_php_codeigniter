
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_airline_client')?></li>
        </ol>
    </div><!-- /.box-header -->
	 <?php if(permissionChecker('client_add')) {   ?>
         <h5 class="page-header">
             <a href="<?php echo base_url('client/adds') ?>" data-toggle="tooltip" data-title="Add Airline Client" data-placement="left" class="btn btn-danger">
                 <i class="fa fa-plus"></i> 
             </a>
         </h5>
     <?php } ?>
     
	 <form class="form-horizontal col-md-12" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>
			    <div class="col-sm-4 col-md-3">			   
                 <?php $status = array("InActive","Active","Status");               
                  						
				   echo form_dropdown("active", $status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                <div class="col-sm-4 col-md-3">			   
                 <?php $list = array("0" => "Select Carrier");               
                  		foreach($airlines as $airline){
						  $list[$airline->vx_aln_data_defnsID] = $airline->code;	
						}				
				   echo form_dropdown("airlineID", $list,set_value("airlineID",$airlineID), "id='airlineID' class='form-control hide-dropdown-icon select2'");    ?>
                </div>	
				<div class="col-sm-4 col-md-3">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter">Filter</button>
				  <button type="button" class="btn btn-danger" name="download" onclick="downloadClients()" >Download</button>
                </div>
				
            </div>				
	 </form>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
			<div id="hide-table">			
                    <table id="clienttable" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1 noExport"><?=$this->lang->line('client_photo')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('client_name')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('client_email')?></th>
								<th class="col-lg-1"><?=$this->lang->line('client_phone')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('client_airline')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('client_role')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('client_usertype')?></th>
                                <?php if(permissionChecker('client_edit')) { ?>
                                <th class="col-lg-1 noExport"><?=$this->lang->line('client_status')?></th>
                                <?php } ?>
                                <?php if(permissionChecker('client_edit') || permissionChecker('client_delete') || permissionChecker('client_view')) { ?>
                                <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>                            
                        </tbody>
                    </table>
                </div>
            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

<script>
  $(document).ready(function() {	 
    $('#clienttable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('client/server_processing'); ?>",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "airlineID","value": $("#airlineID").val()},
                   {"name": "active","value": $("#active").val()} ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); },	  
	  "columns": [{"data": "userID" },
                  {"data": "image" },
				  {"data": "name" },
				  {"data": "email" },
				  {"data": "phone" }, 
                  {"data": "airline_code"},
                  {"data" : "role"},
                  {"data" : "usertype"},
				  {"data": "active"},
                  {"data": "action"}
				  ],			     
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
                                url: "<?php echo base_url('client/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"airlineID": $("#airlineID").val(),"active":$('#active').val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","airline_clients.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }	                
            ] ,
    });
  }); 
  
  function downloadClients(){
	$.ajax({
        url: "<?php echo base_url('client/server_processing'); ?>?page=all&&export=1",
        type: 'get',
        data: {"airlineID": $("#airlineID").val(),"active":$('#active').val()},
        dataType: 'json'
    }).done(function(data){
	var $a = $("<a>");
	$a.attr("href",data.file);
	$("body").append($a);
	$a.attr("download","airline_clients.xls");
	$a[0].click();
	$a.remove();
	 });  
  }
  
   $('#clienttable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#clienttable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('client/active')?>",
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
</script>
