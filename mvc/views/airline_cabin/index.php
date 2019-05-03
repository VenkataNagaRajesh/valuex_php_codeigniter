
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-sitemap"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_airline_cabin')?></li>           
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">			
			  <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?=$this->lang->line("panel_title")?></a></li>       
               </ul>

	<br/> <br/>


                    <h5 class="page-header">

                <?php
                    if(permissionChecker('airline_cabin_add')) {
                ?>
                        <a href="<?php echo base_url('airline_cabin/add') ?>">
                            <i class="fa fa-plus"></i>
                            <?=$this->lang->line('add_title')?>
                        </a>
		<?php } ?>
			&nbsp;&nbsp;
		<?php if(permissionChecker('airline_cabin_gallery')) { ?>
                                                 <a href="<?php echo base_url('airline_cabin/airlinesgallery') ?>">
                            <i class="fa fa-list-alt"></i>
                            <?="Add Gallery"?>
                        </a>
                    <?php } ?>  

		</h5>

       <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
                           <div class="col-sm-2">
               <?php $airlinesdata['0'] = "Select Airlines";
			ksort($airlinesdata);
                                   echo form_dropdown("airline_code", $airlinesdata,set_value("airline_code",$airliineID), "id='airline_code' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                 <div class="col-sm-2">

			<?php
			
                        $airlinecabins['0'] = "Select Cabin";
			ksort($airlinecabins);
                        echo form_dropdown("airline_cabin", $airlinecabins,set_value("airline_cabin",$cabinID), "id='airline_cabin' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

		 <div class="col-sm-2">

                        <?php
                        $map_status['-1'] = 'Select Status';
                        $map_status['1'] = 'Active';
                        $map_status['0'] = 'In Active';
                        echo form_dropdown("active", $map_status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>


                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>
                          </div>
                         </form>

		
		
	       <div class="tab-content">
                <div id="all" class="tab-pane active">
                  <div id="hide-table">
                    <table id="tztable" class="table table-striped table-bordered table-hover dataTable no-footer">
                       <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
				<th class="col-lg-1"><?=$this->lang->line('name')?></th>
								<th class="col-lg-1"><?=$this->lang->line('airline_name')?></th>
					<th class="col-lg-1"><?=$this->lang->line('airline_aircraft')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('airline_cabin')?></th>
				<th class="col-lg-1"><?=$this->lang->line('airline_class')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('airline_video')?></th>
                                <?php if(permissionChecker('airline_cabin_edit')) { ?>
                                        <th class="col-lg-1"><?=$this->lang->line('airline_cabin_status')?></th>
                                <?php } ?>

                                 <?php if(permissionChecker('airline_cabin_edit') || permissionChecker('airline_cabin_view') ||  permissionChecker('airline_cabin_delete')) { ?>
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
      "columns": [{"data": "cabin_map_id" },
		  {"data": "name"},
		   {"data": "airline_code"},
		  {"data": "aircraft_name"},
		  {"data": "airline_cabin"},
                  {"data": "airline_class" },
		  {"data": "video_links" },
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

  
</script>
