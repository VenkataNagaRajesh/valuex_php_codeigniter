<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_fclr')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
              <h5 class="page-header">  

                                            <?php  if(permissionChecker('fclr_add')) {  ?>
                        <a href="<?php echo base_url('fclr/add') ?>">
                            <i class="fa fa-plus"></i> 
                            <?=$this->lang->line('add_fclr')?>
                        </a>
                                                 <?php } ?>

		&nbsp; &nbsp;
                      
                  <a href="<?php echo base_url('fclr/generatedata') ?>">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('generate_fclr')?>
                  </a>

		
              </h5>
			 <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 


    <div class="col-sm-2">
               <?php
                        $airport['0'] = 'Select Boarding Point';
                        ksort($airport);

                                   echo form_dropdown("boarding_point", $airport,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>

                </div>





 <div class="col-sm-2">
<?php
	$airport['0'] = 'Select Off Point';
                        ksort($airport);

                                   echo form_dropdown("off_point", $airport,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>


</div>

<div class="col-sm-2">
               <?php
                        $cabin['0'] = 'Select From Cabin';
                        ksort($cabin);

                                   echo form_dropdown("from_cabin", $cabin,set_value("from_cabin",$from_cabin), "id='from_cabin' class='form-control hide-dropdown-icon select2'");    ?>

                </div>



<div class="col-sm-2">
               <?php
                        $cabin['0'] = 'Select To cabin';
                        ksort($cabin);

                                   echo form_dropdown("to_cabin", $cabin,set_value("to_cabin",$to_cabin), "id='to_cabin' class='form-control hide-dropdown-icon select2'");    ?>

                </div>



    <div class="col-sm-2">
<input type="text" class="form-control" placeholder="Enter Start range Flight Number" id="flight_number" name="flight_number" value="<?=set_value('flight_number',$flight_number)?>" >
                </div>
<div class="col-sm-2">
<input type="text" class="form-control" placeholder="Enter End range Flight number" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
                </div>

 <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder="Enter Dep From date" id="dep_from_date" name="dep_from_date" value="<?=set_value('dep_from_date',$dep_from_date)?>" >
                        </div>

	
 <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder="Enter Dep To date" id="dep_to_date" name="dep_to_date" value="<?=set_value('dep_to_date',$dep_to_date)?>" >
                        </div>




                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>			
            <div id="hide-table">
               <table id="rafeedtable" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
			 <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
			<th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
			<th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
			<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
			<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
			<th class="col-lg-1"><?=$this->lang->line('season')?></th>
			<th class="col-lg-1"><?=$this->lang->line('start_date')?></th>
			<th class="col-lg-1"><?=$this->lang->line('end_date')?></th>
			<th class="col-lg-1"><?=$this->lang->line('day_of_week')?></th>
			<th class="col-lg-1"><?=$this->lang->line('from_cabin')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('to_cabin')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('avg')?></th>
			<th class="col-lg-1"><?=$this->lang->line('min')?></th>
			<th class="col-lg-1"><?=$this->lang->line('max')?></th>
			<th class="col-lg-1"><?=$this->lang->line('slider_start')?></th>
			 <th class="col-lg-1"><?=$this->lang->line('fclr_status')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('action')?></th>

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
	
$("#dep_from_date").datepicker();
$("#dep_to_date").datepicker();

    $('#rafeedtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('fclr/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#flight_number").val()},
		  {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#off_point").val()},
		    {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
		  {"name": "fromCabin","value": $("#from_cabin").val()},
                   {"name": "toCabin","value": $("#to_cabin").val()},
                  
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [ {"data": "fclr_id" },
		   {"data": "source_point" },
	           {"data": "dest_point" },
		   {"data": "carrier_code" },
		   {"data": "flight_number" },
		   {"data": "season_id" },
		   {"data": "start_date" },
		   {"data": "end_date" },
		   {"data": "day_of_week" },
		   {"data": "fcabin" },
		   {"data": "tcabin" },
		   {"data": "average" },
                   {"data": "min" },
		  {"data": "max" },
		 {"data": "slider_start" },
		 {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
	
	
  });
 
  
   $('#rafeedtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#rafeedtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('fclr/active')?>",
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

$( ".select2" ).select2();

 </script>
