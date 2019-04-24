<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_season')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">               
                    <h5 class="page-header">
					    <?php  if(permissionChecker('season_add')) {  ?>
                        <a href="<?php echo base_url('season/add') ?>">
                            <i class="fa fa-plus"></i> 
                            <?=$this->lang->line('add_title')?>
                        </a>
						 <?php } ?>
						 
						 &nbsp;&nbsp;
                         <?php if( isset ($reconfigure) && permissionChecker('season_reconfigure')) {?>
                                <a href="<?php echo base_url('trigger/season_trigger') ?>">
                                    <i class="fa fa-plus"></i>
                                    <?=$this->lang->line('generate_map_table')?>
                                </a>
                        <?php } ?>
                    </h5>
               
                <div id="hide-table">
                    <table id="seasonslist" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('season_name')?></th>
								<th class="col-lg-1"><?=$this->lang->line('orig_level')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('orig_level_value')?></th>
								<th class="col-lg-1"><?=$this->lang->line('dest_level')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('dest_level_value')?></th>
								<th class="col-lg-1"><?=$this->lang->line('season_start_date')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('season_end_date')?></th>
								<th class="col-lg-1"><?=$this->lang->line('is_return_inclusive')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('season_color')?></th>
								<th class="col-lg-1"><?=$this->lang->line('season_active')?></th>
                                <?php if(permissionChecker('season_edit') || permissionChecker('season_delete')) { ?>
                                <th class="col-lg-2"><?=$this->lang->line('action')?></th>
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
    $('#seasonslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('season/server_processing'); ?>",      	  
      "columns": [{"data": "VX_aln_seasonID" },
                  {"data": "season_name" },
				  {"data": "orig_level" },
				  {"data": "orig_level_values" },
				  {"data": "dest_level" }, 
                  {"data": "dest_level_values"},
				  {"data": "ams_season_start_date" },
				  {"data": "ams_season_end_date" },
				  {"data": "is_return_inclusive" },
				  {"data": "season_color"},
                  {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
  }); 
  
   $('#seasonslist tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#seasonslist tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('season/active')?>",
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
