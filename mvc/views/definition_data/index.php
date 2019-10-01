
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
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
	<div class="box-body">
      <div class="row">
         <div class="col-sm-12"> 
     <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>
                <div class="col-sm-2 col-xs-6">			   
                 <?php $typelist = array("0" => " Type");               
                  		foreach($types as $type){
						  $typelist[$type->vx_aln_data_typeID] = $type->alias;	
						}				
				   echo form_dropdown("aln_data_typeID", $typelist,set_value("aln_data_typeID",$aln_data_typeID), "id='aln_data_typeID' class='form-control hide-dropdown-icon select2'");    ?>
                </div>	
				<div class="col-sm-2 col-xs-6">
                  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
                </div>
				<div class="col-sm-2">
                  <button type="button" class="form-control btn btn-danger" name="download" onclick="downloadData()"  id="download">Download</button>
                </div>
            </div>				
	 </form>
    <!-- form start -->
    
            <div class="col-sm-12">              		 				
            <div id="hide-table">
               <table id="defdata" class="table table-bordered dataTable no-footer">
                 <thead>
                    <tr>
			 <th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
                        <th class="col-lg-1"><?=$this->lang->line('defdata_type')?></th>
						<th class="col-lg-2"><?=$this->lang->line('defdata_value')?></th>
						<th class="col-lg-1"><?=$this->lang->line('defdata_parent')?></th>
						<th class="col-lg-1"><?=$this->lang->line('defdata_code')?></th>				
						<th class="col-lg-1 noExport"><?=$this->lang->line('defdata_active')?></th>
                        <?php if(permissionChecker('definition_data_edit') || permissionChecker('definition_data_delete')) { ?>
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
</div>
<script>
 $(document).ready(function() {	
 
  /* jQuery.fn.DataTable.Api.register( 'buttons.exportData()', function ( options ) {   alert(buttons[0]); 
            if ( this.context.length ) {
                var jsonResult = $.ajax({
                    url: "<?php echo base_url('definition_data/server_processing'); ?>?page=all",
                    data: {sSearch: $("#search").val()},
                    success: function (result) {
                        //Do nothing
                    },
                    async: false
                });

                return {body: jsonResult.responseJSON.data, header: $("#defdata thead tr th").map(function() { return this.innerHTML; }).get()};
            }
        } ); */ 

    $('#defdata').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
	 // "lengthMenu": [[10,20, 100, -1], [10,20,100, "All"]],
     // "pageLength": 10,
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
      "columns": [{"data": "chkbox" },
                  {"data": "datatype" },
				  {"data": "aln_data_value" },
				  {"data": "parent" },
				  {"data": "code" },                 			  
                  {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     //buttons: [ 'copy', 'csv', 'excel','pdf' ]
    buttons: [  { text: 'Delete',
	               action: function(e, dt, node, config) {
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
							url: "<?php echo base_url('definition_data/delete_def_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#defdata').DataTable().ajax.reload();
							   $('#bulkDelete').prop("checked",false);
							},
							async:false
						});
					} 
				   }
	            },
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } ,modifier: {search: 'applied',
                    order: 'applied',page : 'all'}
          		},
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('definition_data/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"aln_data_typeID": $("#aln_data_typeID").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","definition_data.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }					              
              ],
	 "autoWidth": false,
	"columnDefs": [ {"targets": 0,"width": "1%"}] 
    });
	
	//$(".dt-buttons").append('<a href="<?=base_url("definition_data/exportall")?>" class="dt-button" tabindex="0" aria-controls="defdata"><span>ExportAll</span></a>');
	
	//$(".dt-buttons").append('<a href="<?=base_url("definition_data/server_processing")?>?page=all&&export=1" class="dt-button" tabindex="0" aria-controls="defdata"><span>ExportA</span></a>');
    });

  function downloadData(){
	  $.ajax({
        url: "<?php echo base_url('definition_data/server_processing'); ?>?page=all&&export=1",
        type: 'get',
        data: {"aln_data_typeID": $("#aln_data_typeID").val()},
        dataType: 'json'
        }).done(function(data){
		var $a = $("<a>");
		$a.attr("href",data.file);
		$("body").append($a);
		$a.attr("download","definition_data.xls");
		$a[0].click();
		$a.remove();
	   }); 
   }  
    
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

$(document).ready(function() {
$("#bulkDelete").on('click',function() { // bulk checked
        var status = this.checked;
        $(".deleteRow").each( function() {
          if(status == 1 && $(this).prop('checked')) {
                
          } else {
                if (status == false && $(this).prop('checked') == false) {

                } else {
                         $(this).prop("checked",status);
                        $(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
                }
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
                url: "<?php echo base_url('definition_data/delete_def_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#defdata').DataTable().ajax.reload();
                   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 


$('#defdata').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });





});
</script>
