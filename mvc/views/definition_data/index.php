
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_defdata')?></li>
        </ol>
    </div><!-- /.box-header -->
	<div class="box-body">
      <div class="row">
         <div class="col-sm-12"> 
	<h5 class="page-header">                        
		<?php if(permissionChecker('definition_data_add')) { ?>
         <a href="<?php echo base_url('definition_data/add') ?>" data-toggle="tooltip" data-title="Add Data" data-placement="left" class="btn btn-danger">
             <i class="fa fa-plus" ></i>
             <!--<?=$this->lang->line('add_defdata')?>-->
         </a>
		<?php } ?>
    </h5>
     <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>
                <div class="col-sm-2">			   
                 <?php $typelist = array("0" => "Select Type");               
                  		foreach($types as $type){
						  $typelist[$type->vx_aln_data_typeID] = $type->alias;	
						}				
				   echo form_dropdown("aln_data_typeID", $typelist,set_value("aln_data_typeID",$aln_data_typeID), "id='aln_data_typeID' class='form-control hide-dropdown-icon select2'");    ?>
                </div>	
				<div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
                </div>
            </div>				
	 </form>
    <!-- form start -->
    
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
</div>
<script>
 $(document).ready(function() {	 
    $('#defdata').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('definition_data/server_processing'); ?>",  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "aln_data_typeID","value": $("#aln_data_typeID").val()} ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); },	  
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
