
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_airline_cabin')?></li>           
        </ol>
    </div><!-- /.box-header -->
	<h5 class="page-header">
			<?php
                    if(permissionChecker('airline_cabin_add')) {
                ?>
                        <a href="<?php echo base_url('airline_cabin/add') ?>" data-toggle="tooltip" data-title="Add Airline Cabin" data-placement="left" class="btn btn-danger">
                            <i class="fa fa-plus"></i>
                        </a>
			<?php } ?>
	</h5>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">			
			  <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?=$this->lang->line("panel_title")?></a></li>       
               </ul>

	<br/> <br/>


                    

       <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" style="padding:0 10px;">
                      <div class='form-group'>
                           <div class="col-sm-2">
               <?php 

                         foreach($airlines as $airline){
                                $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
				}

                                                        $airlinelist[0]= 'Carrier';
                                                        ksort($airlinelist);



                                   echo form_dropdown("airline_code", $airlinelist,set_value("airline_code",$airlineID), "id='airline_code' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                 <div class="col-sm-2">

	<select  name="airline_cabin"  id='airline_cabin' class="form-control select2">
                                <option value=0>Cabin</option>
                                                        </select>


			<?php

		/*
			
                        $airlinecabins['0'] = " Cabin";
			ksort($airlinecabins);
                        echo form_dropdown("airline_cabin", $airlinecabins,set_value("airline_cabin",$cabinID), "id='airline_cabin' class='form-control hide-dropdown-icon select2'");   */ ?>


                 </div>

		 <div class="col-sm-2">

                        <?php
                        $map_status['-1'] = ' Status';
                        $map_status['1'] = 'Active';
                        $map_status['0'] = 'In Active';
                        echo form_dropdown("active", $map_status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>


                <div class="col-sm-4">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter">Filter</button>
				  <button type="button" class="btn btn-danger" name="filter" onclick="downloadCabins()">Download</button>			   
                </div>
				
                          </div>
                         </form>

		


 <div class="col-md-12">
                <div class="col-md-12">
                        <div class="tab-content table-responsive" id="hide-table">
                                <table id="cabintable" class="table table-bordered dataTable no-footer">
                                  <thead>
                                           <tr>
		
				 <th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
                                <th class="col-lg-1"><?=$this->lang->line('airline_name')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('airline_aircraft')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('airline_cabin')?></th>
                                                <th class="col-lg-1"><?php echo "Images Count"?></th>
                                <th class="col-lg-1"><?=$this->lang->line('airline_video')?></th>
                                <?php if(permissionChecker('airline_cabin_edit')) { ?>
                                  <th class="col-lg-1 noExport"><?=$this->lang->line('airline_cabin_status')?></th>
                                <?php } ?>

                                 <?php if(permissionChecker('airline_cabin_edit') || permissionChecker('airline_cabin_view') ||  permissionChecker('airline_cabin_delete')) { ?>
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
    </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {

  
  $( ".select2" ).select2();

$('#airline_code').change(function(event) {    
  var carrier = $('#airline_code').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#airline_cabin').html(data);
                                }        
      });       
});

$('#airline_code').trigger('change');
$('#airline_cabin').val('<?=$classID;?>').trigger('change');


    $('#cabintable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "stateSave": true,
      "sAjaxSource": "<?php echo base_url('airline_cabin/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "airlineID","value": $("#airline_code").val()},
		   {"name": "cabinID","value": $("#airline_cabin").val()},
			{"name": "active","value": $("#active").val()})
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
		"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("aircabindatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("aircabindatatable"));
                if (data) data.start = 0;
                return data;
            },

      "columns": [{"data": "chkbox" },
		   {"data": "airline_code"},
		  {"data": "aircraft_name"},
		  {"data": "airline_cabin"},
		  {"data": "img_cnt"},
		  {"data": "video_links" },
		  {"data": "active"},
                  {"data": "action"}

				  ],			   
	//"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']	
	dom: 'B<"clear">lfrtip',
   // buttons: [ 'copy', 'csv', 'excel','pdf' ]
     buttons: [ {text: 'Delete',
				  action: function ( e, dt, node, config ) {
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
							url: "<?php echo base_url('airline_cabin/delete_airline_cabins_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#cabintable').DataTable().ajax.reload();
					   $('#bulkDelete').prop("checked",false);
							},
							async:false
						});
					}  
				  }
	            },
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export'} },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },{ text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('airline_cabin/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"airlineID": $("#airline_code").val(),"cabinID": $("#airline_cabin").val(),"active": $("#active").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","airline_cabin.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }	                
            ] ,
	 "autoWidth": false,
     "columnDefs":  [ {"targets": 0,"width": "30px" },{"targets":5,
	                 render: function ( data, type, row, meta ) {
                       console.log(type);						 
						if(type == 'export'){
                          return $(data).attr("href");
						} else {
						  return data;	
						}                      
                   }} ]
	 
    });
  });
  
  function downloadCabins(){
	  $.ajax({
           url: "<?php echo base_url('airline_cabin/server_processing'); ?>?page=all&&export=1",
           type: 'get',
           data: {"airlineID": $("#airline_code").val(),"cabinID": $("#airline_cabin").val(),"active": $("#active").val()},
           dataType: 'json'
       }).done(function(data){
		  var $a = $("<a>");
		  $a.attr("href",data.file);
		  $("body").append($a);
		  $a.attr("download","airline_cabin.xls");
		  $a[0].click();
		  $a.remove();
		 });
  }
  
   $('#cabintable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });

 var status = '';
  var id = 0;
 $('#cabintable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('airline_cabin/active')?>",
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
                url: "<?php echo base_url('marketzone/delete_mz_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#cabintable').DataTable().ajax.reload();
		   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 


$('#cabintable').on('click', '.deleteRow', function() {
	$(this).not("#bulkDelete").closest('tr').toggleClass('rowselected', this.checked);
});


});
</script>
