<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_eligibility_exclusion')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-2">               
                    <h5 class="page-header">
					    <?php  if(permissionChecker('eligibility_exclusion_add')) {  ?>
                        <a href="<?php echo base_url('eligibility_exclusion/add') ?>">
                            <i class="fa fa-plus"></i> 
                            <?=$this->lang->line('add_title')?>
                        </a>
						 <?php } ?>
						 
                    </h5>

	  </div>
	<div class="col-sm-12">
       <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
		<div class="col-sm-12">
                           <div class="col-sm-2">
               <?php 
			$marketzones['0'] = 'Select Origin Market';
			ksort($marketzones);

                                   echo form_dropdown("orig_market_id", $marketzones,set_value("orig_market_id",$origmarketID), "id='orig_market_id' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

<div class="col-sm-2">
               <?php $marketzones['0'] = 'Select Destination Market';
			ksort($marketzones);
                                   echo form_dropdown("dest_market_id", $marketzones,set_value("dest_market_id",$destmarketID), "id='dest_market_id' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

		                <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_nbr_start" name="flight_nbr_start"  placeholder='Select flight nbr start' value="<?=set_value('flight_nbr_start',$nbr_start)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_nbr_end" name="flight_nbr_end"  placeholder='Select flight nbr end' value="<?=set_value('flight_nbr_end',$nbr_end)?>" >
                </div>


                           <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_efec_date" name="flight_efec_date"  placeholder='Select flight Effective Date' value="<?=set_value('flight_efec_date',$efec_date)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_disc_date" name="flight_disc_date"  placeholder='Select flight discontinue Date' value="<?=set_value('flight_disc_date',$disc_date)?>" >
                </div>
</div></div>
<br> 
<div class='form-group'>
<div class='col-sm-12'>
  <div class="col-sm-2">
                           <?php
				$hrs['-1'] = 'Select Departure Start Hrs';
				ksort($hrs);

                                    echo form_dropdown("flight_dep_start_hrs", $hrs,set_value("flight_dep_start_hrs"), "id='flight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php
				$mins['-1'] = 'Select Departure start Mins';
				ksort($mins);
                                                    echo form_dropdown("flight_dep_start_mins", $mins,set_value("flight_dep_start_mins"), "id='flight_dep_start_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>
  <div class="col-sm-2">
                           <?php
		 $hrs['-1'] = 'Select Departure End Hrs';
                                ksort($hrs);

                                    echo form_dropdown("flight_dep_end_hrs", $hrs,set_value("flight_dep_end_hrs"), "id='flight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php

			 $mins['-1'] = 'Select Departure End Mins';
                                ksort($mins);
                                                    echo form_dropdown("flight_dep_end_mins", $mins,set_value("flight_dep_end_mins"), "id='flight_dep_end_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>


	   <div class="col-sm-2">
               <?php
                        $class_list['0'] = 'Select From Class';
                        foreach ($class_type as $class) {
                                $class_list[$class->vx_aln_data_defnsID] = $class->aln_data_value;
                        }

			ksort($class_type);

                                   echo form_dropdown("from_class", $class_list,set_value("from_class",$fromclass), "id='from_class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>


	     <div class="col-sm-2">
               <?php
                        $class_list['0'] = 'Select To Class';
			ksort($class_list);

                                   echo form_dropdown("to_class", $class_list,set_value("to_class",$toclass), "id='to_class' class='form-control hide-dropdown-icon select2'");    ?>

                </div>
</div></div>
<br>
<div class='form-group'>
<div class="col-sm-12">

		 <div class="col-sm-2">

                        <?php
                 foreach($days_of_week as $day ) {
                                $days[$day->vx_aln_data_defnsID] = $day->aln_data_value;
                        }
                 echo form_multiselect("day[]", $days, set_value("day"), "id='day' class='form-control select2'");

                        ?>

                 </div>



          <div class="col-sm-2">

                        <?php
                        $status['-1'] = 'Select Status';
                        $status['1'] = 'Active';
                        $status['0'] = 'In Active';
                        echo form_dropdown("active", $status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

		 <div class="col-sm-2">
                            <?php

						$toggle['-1'] = 'Select future use';
                                                          $toggle[1] = "Yes";
                                                          $toggle[0] = "No";
                                                          echo form_dropdown("future_use", $toggle,set_value("future_use",$future_use), "id='future_use' class='form-control hide-dropdown-icon select2'");
                                                        ?>
                        </div>
                                  

                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>

</div>
                          </div>


                         </form>

</div>
<br> <br>

                <div id="hide-table">
                    <table id="ruleslist" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('desc')?></th>
				<th class="col-lg-1"><?=$this->lang->line('orig_market')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('dest_market')?></th>
			       <th class="col-lg-1"><?=$this->lang->line('flight_efec_date')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('flight_disc_date')?></th>
			      <th class="col-lg-1"><?=$this->lang->line('flight_dep_start')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('flight_dep_end')?></th>
				<th class="col-lg-1"><?=$this->lang->line('flight_nbr_range')?></th>
			        <th class="col-lg-1"><?=$this->lang->line('upgrade_from')?></th>
				<th class="col-lg-1"><?=$this->lang->line('upgrade_to')?></th>
				<th class="col-lg-1"><?=$this->lang->line('frequency')?></th>
				<th class="col-lg-1"><?=$this->lang->line('future_use')?></th>
				 <th class="col-lg-1"><?=$this->lang->line('rule_status')?></th> 
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

  $('#ruleslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('eligibility_exclusion/server_processing'); ?>",   
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "origID","value": $("#orig_market_id").val()},
                   {"name": "destID","value": $("#dest_market_id").val()},
		   {"name": "day","value": $("#day").val()},
		   {"name": "fromClass","value": $("#from_class").val()},
		   {"name": "toClass","value": $("#to_class").val()},
		    {"name": "nbrStart","value": $("#flight_nbr_start").val()},
                   {"name": "nbrEnd","value": $("#flight_nbr_end").val()},
		   {"name": "efecDate","value": $("#flight_efec_date").val()},
                   {"name": "discDate","value": $("#flight_disc_date").val()},
		   {"name": "futureuse","value": $("#future_use").val()},

		   {"name": "startHrs","value": $("#flight_dep_start_hrs").val()},
                   {"name": "startMins","value": $("#flight_dep_start_mins").val()},
		 {"name": "endHrs","value": $("#flight_dep_end_hrs").val()},
                   {"name": "endMins","value": $("#flight_dep_end_mins").val()},
                   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 
      "columns": [{"data": "eexcl_id" },
                  {"data": "excl_reason_desc" },
                                  {"data": "orig_mkt_name" },
                                  {"data": "dest_mkt_name" },
                                  {"data": "flight_efec_date" }, 
                  {"data": "flight_disc_date"},
                                  {"data": "flight_dep_start" },
                                  {"data": "flight_dep_end" },
                                  {"data": "flight_nbr" },
                                  {"data": "from_class"},
                                         {"data": "to_class" },
                                  {"data": "frequency"},
                                  {"data": "future_use"},
				  {"data": "active"},
                  {"data": "action"}

                                  ],                       
        //"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']  
        dom: 'B<"clear">lfrtip',
    buttons: [ 'copy', 'csv', 'excel','pdf' ]
    });
  });
  
   $('#ruleslist tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });

  
  var status = '';
  var id = 0;
 $('#ruleslist tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('eligibility_exclusion/active')?>",
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
$( ".select2" ).select2({closeOnSelect:false,
                         placeholder: "Select Frequency"});

$("#flight_efec_date").datepicker();
$("#flight_disc_date").datepicker();

</script>
