
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-sitemap"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_event_status')?></li>           
        </ol>
    </div><!-- /.box-header -->
	 <h5 class="page-header">
       <?php
           if(permissionChecker('event_status_add')) { ?>
               <a href="<?php echo base_url('event_status/add') ?>" data-toggle="tooltip" data-title="Add Event Status" data-placement="left" class="btn btn-danger">
                   <i class="fa fa-plus"></i>
                   <!--<?=$this->lang->line('add_title')?>-->
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
               </ul><br>
			<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
                           <div class="col-sm-2">
               <?php $booking_status['0'] = "Event Name";
			ksort($booking_status);
                                   echo form_dropdown("event_id", $booking_status,set_value("event_id",$event_id), "id='event_id' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                 <div class="col-sm-2">

			<?php
			
	$booking_status['0'] = "Current Status";
                        ksort($booking_status);
                                   echo form_dropdown("current_status", $booking_status,set_value("current_status",$current_status), "id='current_status' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

		 <div class="col-sm-2">

                        <?php
                        $map_status['-1'] = 'Status';
                        $map_status['1'] = 'Active';
                        $map_status['0'] = 'In Active';
                        echo form_dropdown("active", $map_status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>


                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
                </div>
                          </div>
                         </form>

		
		
	       <div class="tab-content">
                <div id="all" class="tab-pane active">
                  <div id="hide-table">
                    <table id="tztable" class="table table-striped table-bordered table-hover dataTable no-footer">
                       <thead>
                            <tr>
				<th class="col-lg-1"><?=$this->lang->line('event_id')?></th>
			       <th class="col-lg-1"><?=$this->lang->line('current_status')?></th>
					<th class="col-lg-1"><?=$this->lang->line('next_status')?></th>
					<th class="col-lg-1"><?=$this->lang->line('isInternalStatus')?></th>
                                <?php if(permissionChecker('event_status_edit')) { ?>
                                        <th class="col-lg-1"><?=$this->lang->line('event_status')?></th>
                                <?php } ?>

                                 <?php if(permissionChecker('event_status_edit') || permissionChecker('event_status_delete')) { ?>
                                <th class="col-lg-1"><?=$this->lang->line('action')?></th>
                                <?php } ?>

	
                            </tr>
                        </thead>
						<tbody>                           
                        </tbody>
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

    $('#tztable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('event_status/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "eventID","value": $("#event_id").val()},
		   {"name": "currentStatus","value": $("#current_status").val()},
			{"name": "active","value": $("#active").val()})
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
      "columns": [
		  {"data": "event_name"},
		   {"data": "current_status_name"},
		  {"data": "next_status_name"},
		  {"data": "isInternalStatus"},
		  {"data": "active"},
                  {"data": "action"}

				  ],			   
	//"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']	
	dom: 'B<"clear">lfrtip',
    buttons: [ 'copy', 'csv', 'excel','pdf' ]
    });
  });
  
   $('#tztable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });

 var status = '';
  var id = 0;
 $('#tztable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
      if($(this).prop('checked')) {
          status = 'chacked';
          id = $(this).parent().attr("id");
	  var res = id.split(":");
	  var id1 = res[0];
	  var id2 = res[1];
	  
      } else {
          status = 'unchacked';
          id = $(this).parent().attr("id");
	   var res = id.split(":");
          var id1 = res[0];
          var id2 = res[1];
	alert(id2);

      }

      if((status != '' || status != null) && (id1 !='') && (id2 != '') ) {
          $.ajax({
              type: 'POST',
              url: "<?=base_url('event_status/active')?>",
              data: "&id1=" + id1 + "&id2=" + id2 + "&status=" + status,
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

  
</script>
