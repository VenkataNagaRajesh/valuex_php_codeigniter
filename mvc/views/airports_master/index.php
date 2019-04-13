
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_airports_master')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
                    <h5 class="page-header">
                        <a href="<?php echo base_url('usertype/add') ?>" >
                            <i class="fa fa-plus"></i> 
                            <?=$this->lang->line('add_title')?>
                        </a> 
						<?php if(permissionChecker('airports_master_upload')) { ?>
                        <a href="<?php echo base_url('airports_master/upload') ?>">
                            <i class="fa fa-upload"></i>
                            <?=$this->lang->line('upload_airports')?>
                        </a>
					 <?php } ?>
                    </h5>
            <div id="hide-table">
                    <table id="master" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-2"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-8"><?=$this->lang->line('master_airport')?></th>
								<th class="col-lg-8"><?=$this->lang->line('master_country')?></th>
								<th class="col-lg-8"><?=$this->lang->line('master_state')?></th>
								<th class="col-lg-8"><?=$this->lang->line('master_region')?></th>
								<th class="col-lg-8"><?=$this->lang->line('master_area')?></th>
                                <?php if(permissionChecker('airports_master_edit') || permissionChecker('airports_master_delete')) { ?>
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
    $('#master').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('airports_master/server_processing'); ?>",
	  /* "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
              aoData.push({"name": "usertypeID","value": $("#usertypeID").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); }, */
      "columns": [{"data": "vx_amdID" },
                  {"data": "airport" },
				  {"data": "country" },
				  {"data": "state" },
				  {"data": "region" },
                  {"data": "area"},				 
                  {"data": "active"},
                  {"data": "action"}
				  ],			   
	  //"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
  });
  
  
  
   $('#master tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#master tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('user/active')?>",
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
