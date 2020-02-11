
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_contract')?></li>
        </ol>
    </div><!-- /.box-header -->
	 <?php if(permissionChecker('contract_add')) {   ?>
         <h5 class="page-header">
             <a href="<?php echo base_url('contract/add') ?>" data-toggle="tooltip" data-title="Add Contract" data-placement="left" class="btn btn-danger">
                 <i class="fa fa-plus"></i> 
             </a>
         </h5>
     <?php } ?>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
			<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			 <div class='form-group'>			 
			   <div class="col-sm-2">			   
                 <?php $airlinelist = array("0" => "Select Carrier");               
                   foreach($airlines as $airline){
								 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
							 }							
				   echo form_dropdown("airlineID", $airlinelist,set_value("airlineID",$airlineID), "id='airlineID' class='form-control hide-dropdown-icon select2'");    ?>
                </div>                 	    
                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>			
            <div id="hide-table">
               <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('contract_name')?></th>                       
						<th class="col-lg-1"><?=$this->lang->line('airline_code')?></th>
						<th class="col-lg-1"><?=$this->lang->line('product_name')?></th>
						<th class="col-lg-1"><?=$this->lang->line('start_date')?></th>
						<th class="col-lg-1"><?=$this->lang->line('end_date')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('no_users')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('contract_active')?></th>
                        <?php if(permissionChecker('contract_edit') || permissionChecker('contract_delete')) { ?>
                         <th class="col-lg-1 noExport"><?=$this->lang->line('action')?></th>
                        <?php } ?>
                    </tr>
                 </thead>
                 <tbody> 
                     <?php $i = 1; foreach($contracts as $contract){ 
                         $j=1; foreach($contract->products as $product){ 
                         if($j == 1){ ?>
                    <tr>
                        <th rowspan="2"><?=$i?></th>
                        <th rowspan="2"><?=$contract->name?></th>
                        <th rowspan="2"><?=$contract->carrier_code?></th>                        
                        <td><?=$product->product_name?></td>
                        <td><?=date_format(date_create($product->start_date),'d-m-Y')?></td>
                        <td><?=date_format(date_create($product->end_date),'d-m-Y')?></td>
                        <td><?=$product->no_users?></td>
                        <td data-title="<?=$this->lang->line('contract_active')?>" rowspan="2">
                            <div class="onoffswitch-small" id="<?=$contract->contractID?>">
                                  <input type="checkbox" id="myonoffswitch<?=$contract->contractID?>" class="onoffswitch-small-checkbox" name="paypal_demo" <?php if($contract->active === '1') echo "checked='checked'"; ?>>
                                  <label for="myonoffswitch<?=$contract->contractID?>" class="onoffswitch-small-label">
                                      <span class="onoffswitch-small-inner"></span>
                                      <span class="onoffswitch-small-switch"></span>
                                  </label>
                            </div>           
                        </td>                      
                        <?php if(permissionChecker('contract_edit') || permissionChecker('contract_delete')) { ?>
                        <td data-title="<?=$this->lang->line('action')?>" rowspan="2">
                            <?php
                               echo btn_edit('contract/edit/'.$contract->contractID, $this->lang->line('edit'));
                               echo btn_delete('contract/delete/'.$contract->contractID, $this->lang->line('delete'));
                            ?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <td><?=$product->product_name?></td>
                        <td><?=date_format(date_create($product->start_date),'d-m-Y')?></td>
                        <td><?=date_format(date_create($product->end_date),'d-m-Y')?></td>
                        <td><?=$product->no_users?></td>
                    </tr>
                    <?php } ?>
                     <?php $j++; } //products end
                      $i++; } //contract end ?>                                      
                 </tbody>
              </table>
            </div>
          </div>
       </div>
   </div>
</div>
<script>
  var status = '';
  var id = 0;
  $('.onoffswitch-small-checkbox').click(function() {
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
              url: "<?=base_url('contract/active')?>",
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

<script>
 $('#airlineID').select2();
 $(document).ready(function() {	
    $('#contracttable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('contract/server_processing'); ?>",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "airlineID","value": $("#airlineID").val()})
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); 
        },      
		"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("contractdatatable", JSON.stringify(data));
           },
        "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("contractdatatable"));
                if (data) data.start = 0;
                return data;
            },
       "columns": [{"data": "contractID" },
                  {"data": "name" },
                  {"data": "code" },
				  {"data": "products" },
				  {"data": "start_date"},
				  {"data":"end_date"},				 
				  {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
    // buttons: [ 'copy', 'csv', 'excel','pdf' ],
	 buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('contract/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"airlineID": $("#airlineID").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","contracts.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ],
	"autoWidth": false,
	//"columnDefs": [ {"targets": 0,"width": "1%"},{"targets": 1,"width": "1%"},{"targets": 2,"width": "1%"},{"targets": 3,"width": "1%"},{"targets": 4,"width": "1%"}]
    });
	
	
  });
 
  
   $('#contracttable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#contracttable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('contract/active')?>",
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
