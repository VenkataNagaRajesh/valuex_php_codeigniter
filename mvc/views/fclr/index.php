<?php if(!empty($check_product) && $this->session->userdata('roleID') != 1) { ?>
<div id="notice-danger" class="col-md-12">
    <div class="alert alert-danger" style="margin-top:20px;">
        <i class="fa fa-check-circle"></i>
        Sorry Your Upgrade Product Expired 
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
</div>
<?php } ?>
<div class="fclr-bar">
<?php  if(permissionChecker('fclr_add')) {  ?>
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:95%;margin-right:8px;"><i class="fa fa-sun-o"></i> Fare Control Range
		<ol class="breadcrumb pull-right">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_fclr')?></li>
        </ol>
	</h2>
	<p class="card-header" data-toggle="collapse" data-target="#fclrAdd"><button style="margin:1px 0;" type="button" class="btn btn-danger pull-right" data-placement="left" title="Add FCLR" data-toggle="tooltip" id='fclr_add_btn' ><i class="fa fa-plus"></i></button></p>
 <?php } ?>
	<div class="col-md-12 fclr-table-add collapse" id="fclrAdd">
		<form class="form-horizontal" action="#" id='fclr_add_form'>
			<div class="col-md-12">
				<div class="form-group">
										<div class="col-md-2 col-sm-3">
						<?php

					foreach($airlines as $airline){
                                                                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                                                        }
                                                        $roleID = $this->session->userdata('roleID');
                                                        if($roleID == 2){
                                                                $default_airlineID =  key($airlinelist);
                                                        } else {
                                                                $default_airlineID = 0;
                                                        }




                                                        $airlinelist[0]= 'Carrier';
                                                        ksort($airlinelist);

							echo form_dropdown("carrier_code", $airlinelist,set_value("carrier_code",$default_airlineID), "id='carrier_code' class='form-control hide-dropdown-icon select2'"); ?>
					</div>
                    <div class="col-md-2 col-sm-3">
						<?php 
							$seasons[0] = 'Seasons';
							ksort($seasons);
							echo form_dropdown("season_id", $seasons,set_value("season_id"), "id='season_id' class='form-control hide-dropdown-icon select2'");?>
					</div>

                    <div class="col-md-2 col-sm-3">
                      <input id="board_point_name" name="board_point_name" class="form-control" placeholder="Type & Select Board Point"/> <input type="hidden" id="board_point" name="board_point" class="form-control" value="<?=set_value('board_point',$board_point)?>" /> 
                    </div>

                    <div class="col-md-2 col-sm-3">
                      <input id="off_point_name" name="off_point_name" class="form-control" placeholder="Type & Select Off Point"/> <input type="hidden" id="off_point" name="off_point" class="form-control" value="<?=set_value('off_point',$off_point)?>" /> 
                    </div>
					<div class="col-md-2 col-sm-3">
						<input type="text" placeholder="Flight No" class="form-control" id="flight_number" name="flight_number" value="<?=set_value('flight_number')?>" >
					</div>
					<div class="col-md-2 col-sm-3">
						<?php
							$days_of_week[0] = 'Frequency';
							ksort($days_of_week);
							echo form_dropdown("frequency", $days_of_week, set_value("frequency"), "id='frequency' class='form-control hide-dropdown-icon select2'");?>  
					</div>
					</div>
					<div class="form-group">
					<div class="col-md-2 col-sm-3">
 <select  name="upgrade_from_cabin_type"  id='upgrade_from_cabin_type' class="form-control select2">
                                <option value=0>From Cabin</option>
                                                        </select>


						<?php
						/*	$cabins['0'] = 'From Cabin';
							ksort($cabins);
							echo form_dropdown("upgrade_from_cabin_type", $cabins,set_value("upgrade_from_cabin_type"), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'"); */?>   
					</div>
					<div class="col-md-2 col-sm-3">

<select  name="upgrade_to_cabin_type"  id='upgrade_to_cabin_type' class="form-control select2">
                                <option value=0>To Cabin</option>
                                                        </select>


						<?php/*
							$cabins['0'] = 'To Cabin';
							ksort($cabins);
							echo form_dropdown("upgrade_to_cabin_type", $cabins,set_value("upgrade_to_cabin_type"), "id='upgrade_to_cabin_type' class='form-control hide-dropdown-icon select2'");*/?> 
					</div>
					<div class="col-md-2 col-sm-3">
						<input type="text" class="form-control" id="min" placeholder="min" name="min" value="<?=set_value('min')?>" >
					</div>
					<div class="col-md-2 col-sm-3">
						<input type="text" class="form-control" id="max" placeholder="max" name="max" value="<?=set_value('max')?>" >
					</div>
					<div class="col-md-2 col-sm-3">
						<input type="text" class="form-control" id="avg" placeholder="avg" name="avg" value="<?=set_value('avg')?>" >
					</div>
					<div class="col-md-2 col-sm-3">
						<input type="text" class="form-control" id="slider_start" placeholder="slider-start" name="slider_start" value="<?=set_value('slider_start')?>" >
					</div>
					<input type="hidden" class="form-control" id="fclr_id" name="fclr_id"   value="" >
				</div>
				<div class="col-md-12 col-sm-4 text-right">
						<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="savefclr();">Add FCLR</a>
						<a href="#" type="button" id='cancel' class="btn btn-danger" data-toggle="collapse" data-target="#fclrAdd" onclick="form_reset()">Cancel</a>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 table-responsive">
		<div class="auto-gen col-md-12" style="margin: 10px 0 20px;">
		<?php $gen_url = 'fclr/generatedata'; if ($carrier_id) { $gen_url .= "/?carrier_id=$carrier_id"; } ?>
		<a href="<?php echo base_url($gen_url) ?>">
			<i class="fa fa-upload"></i>
			<?=$this->lang->line('generate_fclr')?>
		 </a>
		</div>
		<form class="form-horizontal" action="#">
			<div class="col-md-12">
				<div class="form-group">
										<div class="col-md-2 col-sm-3 select-form">
						<div class="col-md-12">
                            <?php
                                echo form_dropdown("scarrier", $airlinelist,set_value("scarrier",$scarrier_id), "id='scarrier' class='form-control hide-dropdown-icon select2'"); ?>
                        </div>
						<div class="col-md-12">
		                     <?php
                                $seasons['0'] = 'Season';
                                ksort($seasons);
                                echo form_dropdown("sseason_id", $seasons,set_value("sseason_id",$sseason_id), "id='sseason_id' class='form-control hide-dropdown-icon select2'"); ?>
						</div>	

                            <div class="col-md-12">
                                    <select class="form-control select2"  name="fclr_status" id="fclr_status">
					    <option value="1" <?=(($fclr_status == 1 )? "selected":"")?>>Active</option>
					    <option value="0" <?=(($fclr_status == 0 || $fclr_status == '' )? "selected":"")?>>In active</option>
                                    </select>
                            </div>
                            			
					</div>
					<div class="col-md-2 col-sm-3 select-form">
						<div class="col-md-12">
							<input type="text" class="form-control" placeholder="Start range" id="sflight_number" name="sflight_number" value="<?=set_value('sflight_number',$flight_number)?>" >
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" placeholder="End range" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
						</div>
                        <div class="col-md-12">
                                    <select class="form-control select2"  name="fclr_edit_status" id="fclr_edit_status">
                                        <option value="">All</option>
                                        <option value="1">Manually Edited</option>
                                        <option value="2">Manual Attention needed</option>
                                        <option value="3">Manually Added</option>
                                    </select>
                            </div>
					</div>

					  <div class="col-md-2 col-sm-3 select-form">
                                                <div class="col-md-12">

 <select  name="sfrom_cabin"  id='sfrom_cabin' class="form-control select2">
                                <option value=0>From Cabin</option>
                                                        </select>

				 <?php
                                      /*                  $cabins['0'] = 'From Cabin';
                                                        ksort($cabins);
                                                        echo form_dropdown("sfrom_cabin", $cabins,set_value("sfrom_cabin",$sfrom_cabin), "id='sfrom_cabin' class='form-control hide-dropdown-icon select2'");*/ ?>

                                                </div>
                                                <div class="col-md-12">
			<select  name="sto_cabin"  id='sto_cabin' class="form-control select2">
                                <option value=0>To Cabin</option>
                                                        </select>


				   <?php/*
                                                        $cabins['0'] = 'To Cabin';
                                                        ksort($cabins);
                                                        echo form_dropdown("sto_cabin", $cabins,set_value("sto_cabin",$sto_cabin), "id='sto_cabin' class='form-control hide-dropdown-icon select2'"); */?>

                                                </div>
                                        </div>

					<div class="col-md-2 col-sm-3 select-form">
						<div class="col-md-12">
							 <?php
								$airports['0'] = ' Boarding Point';
								ksort($airports); 
                                echo form_dropdown("boarding_point", $airports,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'"); ?>
						</div>
						<div class="col-md-12">
							<?php
								$airports['0'] = ' Off Point';
								ksort($airports);
                                echo form_dropdown("soff_point", $airports,set_value("soff_point",$off_point), "id='soff_point' class='form-control hide-dropdown-icon select2'");    ?>
						</div>
					</div>
					<div class="col-md-2 col-sm-3 select-form">
						<div class="col-md-12">
							<?php
								$marketzones['0'] = 'Origin Market';
								ksort($marketzones);
                                echo form_dropdown("smarket", $marketzones,set_value("smarket",$smarket), "id='smarket' class='form-control hide-dropdown-icon select2'");    ?>
						</div>
						<div class="col-md-12">
							  <?php
								$marketzones['0'] = 'Dest Market';
								ksort($marketzones);
                                echo form_dropdown("dmarket", $marketzones,set_value("dmarket",$dmarket), "id='dmarket' class='form-control hide-dropdown-icon select2'");    ?>
						</div>
					</div>
					<div class="col-md-2 col-sm-3 select-form">
						<div class="col-md-12">
	
		<input type="text" class="form-control" placeholder='frequency' id="sfrequency" name="sfrequency" value="<?=set_value('sfrequency')?>" >
						</div>

			  <div class="col-md-12">

                <input type="text" class="form-control" placeholder='FCLR ID' id="sfclr_id" name="sfclr_id" value="<?=set_value('sfclr_id',$sfclr_id)?>" >
                </div>
                
                
					</div>
					<div class="col-md-12" style="padding-right:20px;">
                                               <div class="bttn-cl pull-right" style="margin-left: 15px;">
                                                               <a href="#" type="button"  id='btn_txt' class="btn btn-danger form-control" onclick="$('#fclrtable').dataTable().fnDestroy();;loaddatatable();" data-title="Filter" data-toggle="tooltip"><i class="fa fa-filter"></i></a>

						</div>
 						<div class="bttn-cl pull-right">
                                                               <a type="button" class="btn btn-danger form-control" onclick="downloadFCLR()" data-title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 fclr-table">
		<div id="hide-table" class="fclr-table-data">
        
             <table id="fclrtable" class="table table-bordered dataTable no-footer">
                 <thead>
					<tr>

					  <th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
					  <th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
						<th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
						<th class="col-lg-1"><?=$this->lang->line('off_point')?></th>						
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
						<th class="col-lg-1 noExport">Active</th>
                        <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>

                    </tr>
                 </thead>
                 <tbody>                          
                 </tbody>
              </table>
         </div>
	</div>
</div>
<script>
 $(document).ready(function() {	 
	
$("#dep_from_date").datepicker();
$("#dep_to_date").datepicker();


$('#carrier_code').change(function(event) {    
  var carrier = $('#carrier_code').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#upgrade_from_cabin_type').html(data);
                                $("#upgrade_from_cabin_type option").html(function(i,str){
                                        return str.replace(/From Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "From Cabin")?"Cabin":"From Cabin";
                                 });
});
                                $('#upgrade_to_cabin_type').html(data);

                                $("#upgrade_to_cabin_type option").html(function(i,str){
                                        return str.replace(/To Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "To Cabin")?"Cabin":"To Cabin";
                                 });
                                });

                                
                                }        
      });       
});

$('#upgrade_from_cabin_type').trigger('change');
$('#upgrade_to_cabin_type').trigger('change');

$("#board_point_name").blur(function() {
	var bval = $("#board_point_name").val();
	if ( bval == '') {
		$("#board_point").val(0);
	}
});
$("#off_point_name").blur(function() {
	var bval = $("#off_point_name").val();
	if ( bval == '') {
		$("#off_point").val(0);
	}
});


//auto-complete textview for boardpoint-autocomplte-textview
$( "#board_point_name" ).autocomplete({
      //source: availableTags
           source : function( request, response ) {
                $.ajax({
                    url: "<?=base_url('general/getAirportsByName')?>",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        
                        search: request.term,
                        season: $("#season_id").val(),
                    },
                    success: function (data) {
                        
                            response( $.map( data, function( item ) {                  
                                    return {                                    
                                        label: item['airport_name'],
                                    	value: item['airportID']
                                    }
                            }));
          
                    },
                    
                    
                });
            },
    	minLength: 3,
        'select': function(event, ui) {
        $('#board_point_name').val(ui.item.label);
	$('#board_point').val(ui.item.value);
        return false; // Prevent the widget from inserting the value.
    },
 }).val('<?php echo $board_point_name; ?>').data('autocomplete');


 $( "#off_point_name" ).autocomplete({
      //source: availableTags
           source : function( request, response ) {
                $.ajax({
                    url: "<?=base_url('general/getAirportsByName')?>",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        
                        search: request.term,
                        season: $("#season_id").val(),
                        
                    },
                    success: function (data) {
                        
		   response( $.map( data, function( item ) {                  
				  return {                                    
					label: item['airport_name'],
				value: item['airportID']
				  }
		  }));
          
                    },
                   
                });
            },
    	minLength: 0,
        'select': function(event, ui) {
        $('#off_point_name').val(ui.item.label);
	$('#off_point').val(ui.item.value);
        return false; // Prevent the widget from inserting the value.
    },
 }).val('<?php echo $off_point_name; ?>').data('autocomplete');




$('#scarrier').change(function(event) {    
  var carrier = $('#scarrier').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#sfrom_cabin').html(data);
				$("#sfrom_cabin option").html(function(i,str){
  					return str.replace(/From Cabin|Cabin/g,
    				 function(m,n){
         				return (m == "From Cabin")?"Cabin":"From Cabin";
     				 });
});
				$('#sto_cabin').html(data);

				$("#sto_cabin option").html(function(i,str){
                                        return str.replace(/To Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "To Cabin")?"Cabin":"To Cabin";
                                 });
				});

				
                                }        
      });       
});

$('#sfrom_cabin').trigger('change');
$('#sto_cabin').trigger('change');

$('#sfrom_cabin').val('<?=$sfrom_cabin?>').trigger('change');
$('#sto_cabin').val('<?=$sto_cabin?>').trigger('change');


loaddatatable();
});



function loaddatatable() {
    $('#fclrtable').DataTable( {
      "bProcessing": true,
      "retrieve": true,
      "paging": true,
    "searching": false,
	"stateSave": true,
      "bServerSide": true,
	  "initComplete": function (settings, json) {  
		$("#fclrtable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	  },
      "sAjaxSource": "<?php echo base_url('fclr/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#sflight_number").val()},
		           {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
		           {"name": "fclr_edit_status","value": $("#fclr_edit_status").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#soff_point").val()},
		           {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
			       {"name": "frequency","value": $("#sfrequency").val()},
		           {"name": "smarket","value": $("#smarket").val()},
                   {"name": "dmarket","value": $("#dmarket").val()},
		           {"name": "sfrom_cabin","value": $("#sfrom_cabin").val()},
                   {"name": "sto_cabin","value": $("#sto_cabin").val()},
			       {"name": "sseason_id","value": $("#sseason_id").val()},
			       {"name": "sfclr_id","value": $("#sfclr_id").val()},
                   {"name": "scarrier","value": $("#scarrier").val()},
                   {"name":"fclr_status","value":$("#fclr_status").val()}                  
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 
          "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("fclrdatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("fclrdatatable"));
                if (data) data.start = 0;
                return data;
            },


      "columns": [ {"data": "chkbox" },
	       {"data": "carrier_code" },
		   {"data": "source_point" },
	       {"data": "dest_point" },	 
		   {"data": "flight_number" },
		   {"data": "season_id" },
		   {"data": "start_date" },
		   {"data": "end_date" },
		   {"data": "day_of_week" },
		   {"data": "fcabin" },
		   {"data": "tcabin" },
		   {"data": "average_value" },
            {"data": "min" },
		  {"data": "max" },
		 {"data": "slider_start" },
		 {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',

    // buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
	 buttons: [ { text: 'Delete', exportOptions: { columns: ':visible' },
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
							url: "<?php echo base_url('fclr/delete_fclr_bulk_records'); ?>",
							data: {data_ids:ids_string},
							success: function(result) {
							   $('#fclrtable').DataTable().ajax.reload();
							   $('#bulkDelete').prop("checked",false);
							},
							async:false
						});
					}				  
				  }
				},
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },

				{ extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL',exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'Export All', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('fclr/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"flightNbr":$("#sflight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#soff_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"frequency":$("#sfrequency").val(),"smarket":$("#smarket").val(),"dmarket":$("#dmarket").val(),"sfrom_cabin":$("#sfrom_cabin").val(),"sto_cabin":$("#sto_cabin").val(),"sseason_id":$("#sseason_id").val(),"sfclr_id":$("#sfclr_id").val(),"scarrier":$("#scarrier").val(), "sfclr_edit_status":$("#sfclr_edit_status").val(),"fclr_status":$("#fclr_status").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","fclr.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ] ,
			//"autoWidth":false,
			//"columnDefs": [ {"targets": 0,"width": "30px" }]
    });	
    
  } 

function downloadFCLR(){
	$.ajax({
       url: "<?php echo base_url('fclr/server_processing'); ?>?page=all&&export=1",
       type: 'get',
       data: {"flightNbr":$("#sflight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#soff_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"frequency":$("#sfrequency").val(),"smarket":$("#smarket").val(),"dmarket":$("#dmarket").val(),"sfrom_cabin":$("#sfrom_cabin").val(),"sto_cabin":$("#sto_cabin").val(),"sseason_id":$("#sseason_id").val(),"sfclr_id":$("#sfclr_id").val(),"scarrier":$("#scarrier").val(),"fclr_status":$("#fclr_status").val()},
       dataType: 'json'
       }).done(function(data){
			var $a = $("<a>");
			$a.attr("href",data.file);
			$("body").append($a);
			$a.attr("download","fclr.xls");
			$a[0].click();
			$a.remove();
		 });
}
  
   $('#fclrtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#fclrtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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

$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Frequency'});
 </script>

<script>

function savefclr() {
    <?php if(empty($check_product) && $this->session->userdata('roleID') !=1 ) { ?>
        alert("Sorry Your Upgrade Product Expired..!");
        window.location.reload(true);
   <?php } else { ?>
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('fclr/save')?>",          
                  data: {"board_point" :$('#board_point').val(),
                         "off_point":$('#off_point').val(),
                         "season_id":$('#season_id').val(),
                         "carrier_code":$('#carrier_code').val(),
			            "flight_number":$('#flight_number').val(),
                         "frequency":$('#frequency').val(),
                          "upgrade_from_cabin_type":$('#upgrade_from_cabin_type').val(),
                          "upgrade_to_cabin_type":$('#upgrade_to_cabin_type').val(),
                          "min":$('#min').val(),
			  "max":$('#max').val(),
                          "avg":$('#avg').val(),
                          "slider_start":$('#slider_start').val(),
                           "fclr_id":$('#fclr_id').val()},
          dataType: "html",                     


success: function(data) {

                        var fclrinfo = jQuery.parseJSON(data);
                        var status = fclrinfo['status'];
			newstatus = status.replace(/<p>(.*)<\/p>/g, "$1");
                        if (status == 'success' ) {
                                alert(status);
                                location.reload();
				
                                $("#fclrtable").dataTable().fnDestroy();
                                loaddatatable();
                        } else if (status == 'duplicate'){
				alert('Duplicate Entry');
			} else {                                
                                alert($(status).text());
                            $.each(fclrinfo['errors'], function(key, value) {
                                        if(value != ''){                                         
                                        $('#' + key).parent().addClass('has-error'); 
                                        }                                               
                });                             
                        }
             },
error:function()
{
    alert("please check the data before save");
}

          });
    <?php } ?>
}


function editfclr(fclr_id) {

                var isVisible = $( "#fclrAdd" ).is( ":visible" );

                var isHidden = $( "#fclrAdd" ).is( ":hidden" );
                if( isVisible == false ) {
                        $( "#fclr_add_btn" ).trigger( "click" );
                }       
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('fclr/getFCLRData')?>",          
                  data: {
                           fclr_id:fclr_id},
          dataType: "html",                     
          success: function(data) {
            //  alert(manual_edit);
                var fclrinfo = jQuery.parseJSON(data);
                $('#btn_txt').text('Update FCLR');
                $('#carrier_code').val(fclrinfo['carrier_code']);
                $('#carrier_code').trigger('change');
                $('#board_point').val(fclrinfo['boarding_point']);
                $('#board_point_name').val(fclrinfo['boarding_point_name']);
		//$('#board_point').trigger('change');

		 $('#off_point').val(fclrinfo['off_point']);
		 $('#off_point_name').val(fclrinfo['off_point_name']);
                //$('#off_point').trigger('change');

		 $('#flight_number').val(fclrinfo['flight_number']);

		  $('#season_id').val(fclrinfo['season_id']);
                $('#season_id').trigger('change');


                $('#frequency').val(fclrinfo['frequency']);
                $('#frequency').trigger('change');

		$('#upgrade_from_cabin_type').val(fclrinfo['from_cabin']);
		$('#upgrade_from_cabin_type').trigger('change');

		$('#upgrade_to_cabin_type').val(fclrinfo['to_cabin']);
		$('#upgrade_to_cabin_type').trigger('change');


		$('#min').val(fclrinfo['min']);
		$('#max').val(fclrinfo['max']);
		$('#avg').val(fclrinfo['average']);
		$('#slider_start').val(fclrinfo['slider_start']);

                var fclrid  = fclrinfo['fclr_id'];
                $('#fclr_id').val(fclrid);




        //      var info = JSON.stringify(zoneinfo);

          }
          });
}





</script>


<script>

function form_reset(){    
          var $inputs = $('#fclr_add_form :input'); 
          $inputs.each(function (index)
       {
          $(this).val("");  
            
        });
        var isVisible = $( "#fclrAdd" ).isVisible();
             if( isVisible == true) {
                    $( "#fclr_add_btn" ).trigger( "click" );
                } 
     
  
           //$("#board_point").val(0).trigger('change');
           //$("#off_point").val(0).trigger('change');
           $("#season_id").val(0).trigger('change');
           $("#carrier_code").val(0).trigger('change');
           $("#frequency").val(0).trigger('change');
           $("#upgrade_from_cabin_type").val(0).trigger('change');
           $("#upgrade_to_cabin_type").val(0).trigger('change');

  }



    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
        });
    });

$(document).ready(function(){

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
                url: "<?php echo base_url('fclr/delete_fclr_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#fclrtable').DataTable().ajax.reload();
                   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 

$('#fclrtable').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });




});
</script>
