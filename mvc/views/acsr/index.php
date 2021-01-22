<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_acsr')?></li>
        </ol>
    </div><!-- /.box-header -->
	<h5 class="page-header">
		<?php  if(permissionChecker('acsr_add')) {  ?>
        <a href="<?php echo base_url('acsr/add') ?>" data-toggle="tooltip" data-title="Add Rule" data-placement="left" class="btn btn-danger">
            <i class="fa fa-plus"></i> 
        </a>
		<?php } ?>						 
	</h5>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
		<div class="nav-tabs-custom" style="display:flex;margin-bottom:0;">
       <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
		<div class="col-md-12">
		 <div class="col-sm-2">

        <?php

                                         foreach($carriers as $airline){
                                     $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                                                         }

                        $airlinelist['0'] = ' Carrier';
                        ksort($airlinelist);



                                                        echo form_dropdown("carrier", $airlinelist,set_value("carrier",$carrier), "id='carrier' class='form-control hide-dropdown-icon select2'");?>
		</div>
		<div class="col-sm-2">
               <?php $marketzones['0'] = ' Destination Market';
			ksort($marketzones);
                                   echo form_dropdown("dest_market_id", $marketzones,set_value("dest_market_id",$destmarketID), "id='dest_market_id' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

		                <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_nbr_start" name="flight_nbr_start"  placeholder=' flight nbr start' value="<?=set_value('flight_nbr_start',$nbr_start)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_nbr_end" name="flight_nbr_end"  placeholder=' flight nbr end' value="<?=set_value('flight_nbr_end',$nbr_end)?>" >
                </div>


                           <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_dep_date_start" name="flight_dep_date_start"  placeholder=' flight Dep Date Start' value="<?=set_value('flight_dep_date_start',$dep_date_start)?>" >
                </div>



                <div class="col-sm-2">
                        <input type="text" class="form-control" id="flight_dep_date_end" name="flight_dep_date_end"  placeholder=' flight Dep Date End' value="<?=set_value('flight_dep_date_end',$dep_date_end)?>" >
                </div>
</div></div>
<div class='form-group'>
<div class='col-md-12'>
  <div class="col-sm-2">
                           <?php
				$hrs['-1'] = ' Departure Start Hrs';
				ksort($hrs);

                                    echo form_dropdown("flight_dep_start_hrs", $hrs,set_value("flight_dep_start_hrs"), "id='flight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php
				$mins['-1'] = ' Departure start Mins';
				ksort($mins);
                                                    echo form_dropdown("flight_dep_start_mins", $mins,set_value("flight_dep_start_mins"), "id='flight_dep_start_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>
  <div class="col-sm-2">
                           <?php
		 $hrs['-1'] = ' Departure End Hrs';
                                ksort($hrs);

                                    echo form_dropdown("flight_dep_end_hrs", $hrs,set_value("flight_dep_end_hrs"), "id='flight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
                                </div>
                                <div class="col-sm-2">
                <?php

			 $mins['-1'] = ' Departure End Mins';
                                ksort($mins);
                                                    echo form_dropdown("flight_dep_end_mins", $mins,set_value("flight_dep_end_mins"), "id='flight_dep_end_mins' class='form-control hide-dropdown-icon select2'");

                ?>
                                </div>


	   <div class="col-sm-2">

		 <select  name="from_cabin"  id='from_cabin' class="form-control select2">
                                <option value=0>From Cabin</option>
                                                        </select>

               <?php

		/*
                        $cabin_list['0'] = ' From Cabin';
                        foreach ($cabin_type as $cabin) {
                                $cabin_list[$cabin->vx_aln_data_defnsID] = $cabin->aln_data_value;
                        }

			ksort($cabin_list);

                                   echo form_dropdown("from_cabin", $cabin_list,set_value("from_cabin",$fromcabin), "id='from_cabin' class='form-control hide-dropdown-icon select2'");  */  ?>

                </div>


	     <div class="col-sm-2">

		 <select  name="to_cabin"  id='to_cabin' class="form-control select2">
                                <option value=0>To Cabin</option>
                                                        </select>
               <?php/*
                        $cabin_list['0'] = ' To Cabin';
			ksort($cabin_list);

                                   echo form_dropdown("to_cabin", $cabin_list,set_value("to_cabin",$tocabin), "id='to_cabin' class='form-control hide-dropdown-icon select2'");   */ ?>

                </div>
</div></div>

<div class='form-group'>
<div class="col-md-12">

		 <div class="col-sm-2">
  <input type="text" class="form-control" placeholder="Frequency" id="day" name="day" value="<?=set_value('day')?>" >

                 </div>
				                            <div class="col-sm-2">
               <?php 
			$marketzones['0'] = ' Origin Market';
			ksort($marketzones);

                                   echo form_dropdown("orig_market_id", $marketzones,set_value("orig_market_id",$origmarketID), "id='orig_market_id' class='form-control hide-dropdown-icon select2'");    ?>

                </div>

          <div class="col-sm-2">

                        <?php
                        $status['-1'] = ' Status';
                        $status['1'] = 'Active';
                        $status['0'] = 'In Active';
                        echo form_dropdown("active", $status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

		 <!--<div class="col-sm-2">
                            <?php

						$toggle['-1'] = ' future use';
                                                          $toggle[1] = "Yes";
                                                          $toggle[0] = "No";
                                                          echo form_dropdown("future_use", $toggle,set_value("future_use",$future_use), "id='future_use' class='form-control hide-dropdown-icon select2'");
                                                        ?>
                        </div>-->
                                  
                <div class="col-md-6 text-right col-sm-4">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter" data-title="Filter" data-toggle="tooltip"><i class="fa fa-filter"></i></button>
				  <button type="button" class="btn btn-danger" onclick="downloadACSR()" data-title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></button>
                </div>

</div>
                          </div>


                         </form>
						 </div>

				<div class="col-md-12">
					<div id="hide-table">
                    <table id="ruleslist" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
								 <th class="col-lg-1"><?=$this->lang->line('carrier_code')?></th>
				<th class="col-lg-1"><?=$this->lang->line('orig_level_id')?></th>
				<th class="col-lg-4"><?=$this->lang->line('orig_level_value')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('dest_level_id')?></th>
				<th class="col-lg-4" ><?=$this->lang->line('dest_level_value')?></th>			
			       <th class="col-lg-1"><?=$this->lang->line('flight_dep_date_start')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('flight_dep_date_end')?></th>
			      <th class="col-lg-1"><?=$this->lang->line('flight_dep_time_start')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('flight_dep_time_end')?></th>
				<th class="col-lg-1"><?=$this->lang->line('flight_nbr_range')?></th>
			        <th class="col-lg-1"><?=$this->lang->line('upgrade_from')?></th>
				<th class="col-lg-1"><?=$this->lang->line('upgrade_to')?></th>
				<th class="col-lg-1"><?=$this->lang->line('memp')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('min_bid_price')?></th>
				 <th class="col-lg-1"><?=$this->lang->line('frequency')?></th>
				<th class="col-lg-1"><?=$this->lang->line('action_type')?></th>
				 <th class="col-lg-1 noExport"><?=$this->lang->line('rule_status')?></th> 
                                <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
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

$('#carrier').change(function(event) {    
  var carrier = $('#carrier').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#from_cabin').html(data);
                                $("#from_cabin option").html(function(i,str){
                                        return str.replace(/From Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "From Cabin")?"Cabin":"From Cabin";
                                 });
});
                                $('#to_cabin').html(data);

                                $("#to_cabin option").html(function(i,str){
                                        return str.replace(/To Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "To Cabin")?"Cabin":"To Cabin";
                                 });
                                });

                                
                                }        
      });       
});

$('#carrier').trigger('change');
$('#from_cabin').trigger('change');
$('#to_cabin').trigger('change');
$('#from_cabin').val('<?=$fromcabin?>').trigger('change');
$('#to_cabin').val('<?=$tocabin?>').trigger('change');


  $('#ruleslist').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
	"stateSave": true,
	"initComplete": function (settings, json) {  
		$("#ruleslist").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	  },
      "sAjaxSource": "<?php echo base_url('acsr/server_processing'); ?>",   
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "carrier","value": $("#carrier").val()},
                   {"name": "origID","value": $("#orig_market_id").val()},
                   {"name": "destID","value": $("#dest_market_id").val()},
				   {"name": "day","value": $("#day").val()},
				   {"name": "fromCabin","value": $("#from_cabin").val()},
				   {"name": "toCabin","value": $("#to_cabin").val()},
		           {"name": "nbrStart","value": $("#flight_nbr_start").val()},
                   {"name": "nbrEnd","value": $("#flight_nbr_end").val()},
		           {"name": "depDateStart","value": $("#flight_dep_date_start").val()},
                   {"name": "depDateEnd","value": $("#flight_dep_date_end").val()},
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

	"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("acsrdatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("acsrdatatable"));
                //if (data) data.start = 0;
                return data;
            },

      "columns": [{"data": "id" },
				   {"data": "carrier" },	
                  {"data": "orig_level" },
                  {"data": "orig_level_value" },
				  {"data": "dest_level" },
                  {"data": "dest_level_value" },			 
                  {"data": "flight_dep_date_start" }, 
                  {"data": "flight_dep_date_end"},
                  {"data": "flight_dep_time_start" },
                  {"data": "flight_dep_time_end" },
                  {"data": "flight_nbr" },
                  {"data": "from_cabin"},
                  {"data": "to_cabin" },
				  {"data": "memp" },
                  {"data": "min_bid_price"},
                  {"data": "frequency"},
				  {"data": "action_typ" },
				  {"data": "active"},
                  {"data": "action"}

                                  ],                       
        //"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']  
        dom: 'B<"clear">lfrtip',
  //  buttons: [ 'copy', 'csv', 'excel','pdf' ]
   buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL',exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'Export All', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('acsr/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"origID":$("#orig_market_id").val(),"destID":$("#dest_market_id").val(),"day":$("#day").val(),"fromCabin":$("#from_cabin").val(),"toCabin":$("#to_cabin").val(),"nbrStart":$("#flight_nbr_start").val(),"nbrEnd":$("#flight_nbr_end").val(),"depDateStart":$("#flight_dep_date_start").val(),"depDateEnd":$("#flight_dep_date_end").val(),"startHrs":$("#flight_dep_start_hrs").val(),"startMins":$("#flight_dep_start_mins").val(),"endHrs":$("#flight_dep_end_hrs").val(),"endMins": $("#flight_dep_end_mins").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","acsr.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ] 
    });
  });
  
  function downloadACSR(){
	   $.ajax({
         url: "<?php echo base_url('acsr/server_processing'); ?>?page=all&&export=1",
         type: 'get',
         data: {"origID":$("#orig_market_id").val(),"destID":$("#dest_market_id").val(),"day":$("#day").val(),"fromCabin":$("#from_cabin").val(),"toCabin":$("#to_cabin").val(),"nbrStart":$("#flight_nbr_start").val(),"nbrEnd":$("#flight_nbr_end").val(),"depDateStart":$("#flight_dep_date_start").val(),"depDateEnd":$("#flight_dep_date_end").val(),"startHrs":$("#flight_dep_start_hrs").val(),"startMins":$("#flight_dep_start_mins").val(),"endHrs":$("#flight_dep_end_hrs").val(),"endMins": $("#flight_dep_end_mins").val()},
         dataType: 'json'
         }).done(function(data){
			var $a = $("<a>");
			$a.attr("href",data.file);
			$("body").append($a);
			$a.attr("download","acsr.xls");
			$a[0].click();
			$a.remove();
		  });
  }
  
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
              url: "<?=base_url('acsr/active')?>",
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
                         placeholder: "Frequency"});

$("#flight_dep_date_start").datepicker();
$("#flight_dep_date_end").datepicker();

$("#flight_dep_date_start").datepicker({
    }).on('changeDate', function (ev) {
        $('#flight_dep_date_end').val("").datepicker("update");
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#flight_dep_date_end').datepicker('setStartDate', minDate);
         $("#flight_dep_date_end").datepicker("setDate" , $(this).val());
    });

    $("#flight_dep_date_end").datepicker()
        .on('changeDate', function (selected) {

                var dates = $(this).val();
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#flight_dep_date_start').datepicker('setEndDate', maxDate);
        });


</script>
