
<div class="box">
    <div class="box-header" >
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
		<ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_airline')?></li>
        </ol>
    </div><!-- /.box-header -->
	 <?php if(permissionChecker('airline_add')) {   ?>
         <h5 class="page-header">
             <a href="<?php echo base_url('airline/add') ?>" data-toggle="tooltip" data-title="Add Airline" data-placement="left" class="btn btn-danger">
                 <i class="fa fa-plus"></i> 
             </a>
         </h5>
     <?php } ?>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
			<!--<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 
			   <div class="col-sm-2">			   
               <?php $clist = array("0" => "Select Country");               
                   foreach($countrylist as $country){
								 $clist[$country->vx_aln_data_defnsID] = $country->aln_data_value;
							 }							
				   echo form_dropdown("countryID", $clist,set_value("countryID",$countryID), "id='countryID' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                 <div class="col-sm-2">			   
                   <?php $clist = array("0" => "Select Country");               
                   foreach($aircrafts as $aircraft){
								 $clist[$country->vx_aln_data_defnsID] = $country->aln_data_value;
							 }							
				   echo form_dropdown("countryID", $clist,set_value("countryID",$countryID), "id='countryID' class='form-control hide-dropdown-icon select2'");    ?>
                 </div>		    
                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>-->			
            <div id="hide-table">
               <table id="airlinetable" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-2"><?=$this->lang->line('airline_name')?></th>
						<th class="col-lg-1"><?=$this->lang->line('airline_code')?></th>
						<th class="col-lg-1"><?=$this->lang->line('airline_aircraft')?></th>
						<th class="col-lg-1"><?=$this->lang->line('airline_seat_capacity')?></th>
						<th class="col-lg-1"><?=$this->lang->line('airline_flights_ids')?></th>
						<th class="col-lg-1 noExport"><?=$this->lang->line('airline_active')?></th>
                        <?php if(permissionChecker('airline_edit') || permissionChecker('airline_delete')) { ?>
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
<script>
 $(document).ready(function() {	 
	
    $('#airlinetable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('airline/server_processing'); ?>",
      "columns": [{"data": "id" },
                  {"data": "aln_data_value" },
				  {"data": "code" },
                  {"data": "aircraft"},
				  {"data":"seat_capacity"},
				  {"data": "flights" },
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
                                url: "<?php echo base_url('airline/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"aln_data_typeID": $("#aln_data_typeID").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","airline.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ],
	"autoWidth": false,
	"columnDefs": [ {"targets": 0,"width": "1%"},{"targets": 1,"width": "1%"},{"targets": 2,"width": "1%"},{"targets": 3,"width": "1%"},{"targets": 4,"width": "1%"}]
    });
	
	
  });
 
  
   $('#airlinetable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#airlinetable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('airline/active')?>",
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
