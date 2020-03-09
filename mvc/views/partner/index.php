
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_partner')?></li>
        </ol>
    </div><!-- /.box-header -->
	<?php 
         $usertype = $this->session->userdata("usertype");
         if(permissionChecker('partner_add')) {?>
         <h5 class="page-header">
             <a href="<?php echo base_url('partner/add') ?>" data-toggle="tooltip" data-title="Add Role" data-placement="left" class="btn btn-danger">
                 <i class="fa fa-plus"></i> 
             </a>
         </h5>
     <?php } ?>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div id="hide-table">
                     <table id="partnertable" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1 noExport"><?=$this->lang->line('carrier')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_carrier')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_origin_level')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('partner_origin_content')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('partner_destination_level')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('partner_destination_content')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_start_date')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_start_date')?></th>                                
                                <?php if(permissionChecker('partner_edit') || permissionChecker('partner_delete') || permissionChecker('partner_view')) { ?>
                                <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
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
    $('#partnertable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('partner/server_processing'); ?>",                 
       "columns": [{"data": "sno" },
                  {"data": "carrierID" },
				  {"data": "partner_carrierID" },
				  {"data": "origin_level" },
				  {"data": "origin_content" },
				  {"data": "dest_level" },
				  {"data": "dest_content" },
                  {"data": "start_date"},
                  {"data" : "end_date"},
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
                                url: "<?php echo base_url('partner/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","partners.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }	                
            ] ,
    });
  }); 

</script>
