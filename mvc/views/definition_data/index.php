
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-template"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_defdata')?></li>
        </ol>
    </div><!-- /.box-header -->
	<h5 class="page-header">                        
		<?php if(permissionChecker('definition_data_add')) { ?>
         <a href="<?php echo base_url('definition_data/add') ?>" data-toggle="tooltip" data-title="Add Data" data-placement="left" class="btn btn-danger">
             <i class="fa fa-plus" ></i>
             <!--<?=$this->lang->line('add_defdata')?>-->
         </a>
		<?php } ?>
    </h5>	
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              		 				
            <div id="hide-table">
               <table id="defdata" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('defdata_type')?></th>
						<th class="col-lg-2"><?=$this->lang->line('defdata_value')?></th>
						<th class="col-lg-1"><?=$this->lang->line('defdata_parent')?></th>
						<th class="col-lg-1"><?=$this->lang->line('defdata_code')?></th>				
						<th class="col-lg-1"><?=$this->lang->line('defdata_active')?></th>
                        <?php if(permissionChecker('definition_data_edit') || permissionChecker('definition_data_delete')) { ?>
                        <th class="col-lg-1"><?=$this->lang->line('action')?></th>
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
    $('#defdata').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('definition_data/server_processing'); ?>",      	  
      "columns": [{"data": "vx_aln_data_defnsID" },
                  {"data": "datatype" },
				  {"data": "aln_data_value" },
				  {"data": "parent" },
				  {"data": "code" },                 			  
                  {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
  }); 
  
   $('#defdata tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#defdata tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('definition_data/active')?>",
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
