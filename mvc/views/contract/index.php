
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-list"> </i> <?=$this->lang->line('panel_title')?></h3>       
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
			<div class="nav-tabs-custom" style="display:flex;margin-bottom:0;">
				<div class="col-md-12">              
					<form class="form-horizontal contr" role="form" method="post" enctype="multipart/form-data" style="padding:0 15px;">		   
					 <div class='form-group'>			 
					   <div class="col-sm-2">			   
						 <?php $airlinelist = array("0" => "All Carriers");               
						   foreach($airlines as $airline){
										 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
									 }							
						   echo form_dropdown("airlineID", $airlinelist,set_value("airlineID",$airlineID), "id='airlineID' class='form-control hide-dropdown-icon select2'");    ?>
						</div>                 	    
						<div class="col-sm-11 text-right">
						  <button data-title="Filter" data-toggle="tooltip" type="submit" class="btn btn-danger" name="filter" id="filter"><i class="fa fa-filter"></i></button>
						</div>	             				
					  </div>
					 </form>
				</div>	
			</div>
            <div id="hide-table">
               <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('contract_name')?></th>                       
						<th class="col-lg-1"><?=$this->lang->line('airline_code')?></th>
						<th class="col-lg-1"><?=$this->lang->line('create_client')?></th>
						<th class="col-lg-1"><?=$this->lang->line('product_name')?></th>
						<th class="col-lg-1"><?=$this->lang->line('start_date')?></th>
						<th class="col-lg-1"><?=$this->lang->line('end_date')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('no_users')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('expire_message')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('product_status')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('contract_active')?></th>
                        <?php if(permissionChecker('contract_edit') || permissionChecker('contract_delete')) { ?>
                         <th class="col-lg-1 noExport"><?=$this->lang->line('action')?></th>
                        <?php } ?>
                    </tr>
                 </thead>
                 <tbody> 
                     <?php $i = 1; foreach($contracts as $contract){ 
                         $j=1; foreach($contract->products as $product){                            
                            $OldDate = strtotime($product->end_date);
                            $NewDate = date('M j, Y', $OldDate);
                            $diff = date_diff(date_create($NewDate),date_create(date("M j, Y")));
                            $expireStr1 = $OldDate > time() ? "Expires in " : "Expired ";
                            $expireStr2 = $OldDate > time() ? "" : " Ago";
			    $daysdiff = $diff->format('%a');
				$expstr = '';
				if ( $diff->format('%Y') != '00') {
					$expstr .= $diff->format('%Y') == 1 ? $diff->format('%Y yr') : $diff->format('%Y yrs');
				}
				if ( $diff->format('%m') != '00') {
					$expstr .= $expstr ? " " : '';
					$expstr .= $diff->format('%m') == 1 ? $diff->format('%m mth') : $diff->format('%m mths');
				}
				if ( $diff->format('%d') != '00') {
					$expstr .= $expstr ? " " : '';
					$expstr .= $diff->format('%d') == 1 ? $diff->format('%d day') : $diff->format('%d days');
				}
                            if($daysdiff <= 15){
                                $product->color = "red";
                            } else if($daysdiff <= 30){
                                $product->color = "#e0a90c";
                            } else {
                                $product->color = "#333";
                            }
                            $product->expire = $expireStr1 . $expstr . $expireStr2;
                         if($j == 1){ ?>
                    <tr>
                        <th rowspan="<?=count($contract->products)?>"><?=$i?></th>
                        <th rowspan="<?=count($contract->products)?>"><?=$contract->name?></th>
                        <th rowspan="<?=count($contract->products)?>"><?=$contract->carrier_code?></th>                        
                        <th rowspan="<?=count($contract->products)?>"><?=$contract->client_name?></th>                        
                        <td><?=$product->product_name?></td>
                        <td><?=date_format(date_create($product->start_date),'d-m-Y')?></td>
                        <td><?=date_format(date_create($product->end_date),'d-m-Y')?></td>
                        <td><?=$product->no_users?></td>
                        <td style="text-align:left;color:<?=$product->color?>;"><?=$product->expire; ?></td>
                        <td data-title="<?=$this->lang->line('product_status')?>">
                            <div class="onoffswitch-small" id="<?=$product->contract_productID?>">
                                <input type="checkbox" id="avlonoffswitch<?=$product->contract_productID?>" class="avl_onoffswitch_small_checkbox" name="paypal_demo" <?php if($product->status === '1') echo "checked='checked'"; ?>>
                                <label for="avlonoffswitch<?=$product->contract_productID?>" class="avl_onoffswitch_small_label">
                                    <span class="avl_onoffswitch_small_inner"></span> 
                                    <span class="avl_onoffswitch_small_switch"></span> 
                                </label>
                            </div>
                        </td>   
                        <td data-title="<?=$this->lang->line('contract_active')?>" rowspan="<?=count($contract->products)?>">
                            <div class="onoffswitch-small" id="<?=$contract->contractID?>">
                                  <input type="checkbox" id="myonoffswitch<?=$contract->contractID?>" class="onoffswitch-small-checkbox" name="paypal_demo" <?php if($contract->active === '1') echo "checked='checked'"; ?>>
                                  <label for="myonoffswitch<?=$contract->contractID?>" class="onoffswitch-small-label">
                                      <span class="onoffswitch-small-inner"></span>
                                      <span class="onoffswitch-small-switch"></span>
                                  </label>
                            </div>           
                        </td>  
                        <?php if(permissionChecker('contract_edit') || permissionChecker('contract_delete')) { ?>
                        <td data-title="<?=$this->lang->line('action')?>" rowspan="<?=count($contract->products)?>">
                            <?php
                               echo btn_edit('contract/edit/'.$contract->contractID, $this->lang->line('edit'));
							  //echo btn_view('contract/view/#myModal', $this->lang->line('view'));
							  echo '<a href="#myModal" data-target="#myModal" data-toggle="modal" class="btn btn-success btn-xs mrg"><i class="fa fa-eye" data-placement="top" data-toggle="tooltip" data-original-title="View"></i></a>';
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
                        <td style="text-align:left;color:<?=$product->color?>;"><?=$product->expire;?></td>
                        <td data-title="<?=$this->lang->line('product_status')?>">
                            <div class="onoffswitch-small" id="<?=$product->contract_productID?>">
                                <input type="checkbox" id="avlonoffswitch<?=$product->contract_productID?>" class="avl_onoffswitch_small_checkbox" name="paypal_demo" <?php if($product->status === '1') echo "checked='checked'"; ?>>
                                <label for="avlonoffswitch<?=$product->contract_productID?>" class="avl_onoffswitch_small_label">
                                    <span class="avl_onoffswitch_small_inner"></span> 
                                    <span class="avl_onoffswitch_small_switch"></span> 
                                </label>
                            </div>  
                        </td>
                    </tr>
                    <?php } ?>
                     <?php $j++; } //products end
                      $i++; } //contract end ?>                                      
                 </tbody>
              </table>
            </div>
		  <div class="row">
			  <!-- The Modal -->
			  <div class="modal fade" id="myModal" role="dialog" >
				<div class="modal-dialog">
				  <div class="modal-content">			  
					<!-- Modal Header -->
					<div class="modal-header">
					  <h4 class="modal-title text-center">Airline Contract View</h4>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>				
					<!-- Modal body -->
					<div class="modal-body">
					  Airline Contract View data.....
					</div>				
					<!-- Modal footer -->
					<div class="modal-footer">
					  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>					
				  </div>
				</div>
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
  $('.avl_onoffswitch_small_checkbox').click(function() {
      if($(this).prop('checked')) {
          status = 'chacked';
          msg = 'Activate';
          id = $(this).parent().attr("id");
      } else {
          status = 'unchacked';
          msg = 'De-Activate';
          id = $(this).parent().attr("id");
      }
      var box = confirm('Are You Sure You Want to '+msg+' this Product ?');
      if(!box){
          return false;
      }
      if((status != '' || status != null) && (id !='')) {
          $.ajax({
              type: 'POST',
              url: "<?=base_url('contract/product_status')?>",
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
                { text: 'Export All', exportOptions: { columns: ':visible' },
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
