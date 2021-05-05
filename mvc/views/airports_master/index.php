
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_airports_master')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">              
              <h5 class="page-header">                        
					<?php if(permissionChecker('airports_master_upload')) { ?>
                  <a href="<?php echo base_url('airports_master/upload') ?>" class="btn btn-danger">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_airports')?>
                  </a>
				  &nbsp;&nbsp;
				  <a href="<?php echo base_url('airports_master/downloadFormat') ?>" class="btn btn-danger">
                     <?=$this->lang->line('download_airport_format')?>
                  </a>&nbsp;&nbsp;
			    <?php } ?>
              </h5><br>
			  <div class="nav-tabs-custom" style="margin-bottom:0;">
			  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>
			    <div class="col-sm-2">			   
                 <?php $alist = array("0" => " Area");               
                   foreach($areaslist as $area){
					 $alist[$area->vx_aln_data_defnsID] = $area->aln_data_value;
				   }							
				   echo form_dropdown("areaID", $alist,set_value("areaID",$areaID), "id='areaID' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
				 <div class="col-sm-2">
                 <?php $alist = array("0" => " Region");               
				  echo form_dropdown("regionID", $alist,set_value("regionID",$regionID), "id='regionID' class='form-control hide-dropdown-icon select2'");    ?>
                 </div>
				<div class="col-sm-2">
                 <?php #$alist = array("0" => " Country");               
			#	  echo form_dropdown("countryID", $alist,set_value("countryID",$countryID), "id='countryID' class='form-control hide-dropdown-icon select2'");    ?>
			<input id="country" name="country" class="form-control" placeholder="type country name or code"/> <input type="hidden" id="countryID" name="countryID" class="form-control" value="<?=set_value('countryID',$countryID)?>" /> 
				   
                 </div>
                 <div class="col-sm-2">			   
                 <?php #$alist = array("0" => " City");               
		#		  echo form_dropdown("cityID", $alist,set_value("cityID",$cityID), "id='cityID' class='form-control hide-dropdown-icon select2'");    ?>
			<input id="city" name="city" class="form-control" placeholder="type city name or code"/> <input type="hidden" id="cityID" name="cityID" class="form-control" value="<?=set_value('cityID',$cityID)?>" /> 
				   
                 </div>              				
                 <div class="col-sm-2">			   
                 <?php #$alist = array("0" => " Airport");               
				  #echo form_dropdown("airportID", $alist,set_value("airportID",$airportID), "id='airportID' class='form-control hide-dropdown-icon select2'");    ?>
			<input id="airport" name="airport" class="form-control" placeholder="type airport name or code"/> <input type="hidden" id="airportID" name="airportID" class="form-control" value="<?=set_value('airportID',$airportID)?>" /> 
				   
                 </div> 
              
                <div class="col-sm-2">			   
                 <?php $status = array("1" => "Active","0" => "InActive","2" => "Status");               
                  						
				   echo form_dropdown("active", $status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>
                </div>			
	
		<br>
		<br>
                 
                <div class="col-sm-12 text-right" style="align: right">
                  <button type="submit" class="btn btn-danger" name="filter" id="filter" data-title="Filter" data-toggle="tooltip"><i class="fa fa-filter"></i></button>
				  <button type="button" class="btn btn-danger" onclick="downloadMasterData()" data-title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></button>
                </div>	             				
			  </div>
			 </form>	
			</div>

            <div id="hide-table">
               <table id="master" class="table table-bordered dataTable no-footer">
                 <thead>
                    <tr>
					<th><input class="filter" title="Select All" type="checkbox" id="bulkDelete"/>#</th>
                        <!--<th class="col-lg-2"><?=$this->lang->line('master_airport')?></th>-->
						<th class="col-lg-1"><?=$this->lang->line('master_airport')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_code')?></th>
						<!--<th class="col-lg-1"><?=$this->lang->line('master_city')?></th>-->
						<th class="col-lg-1"><?=$this->lang->line('master_citycode')?></th>
						<!--<th class="col-lg-1"><?=$this->lang->line('master_state')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_country')?></th>-->
						<th class="col-lg-1"><?=$this->lang->line('master_countrycode')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_region')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_area')?></th>					
						<th class="col-lg-1"><?=$this->lang->line('master_alias')?></th>

                            <?php if($this->session->userdata('name')=='valuex' )
                            {
                                ?>                        
						<th class="col-lg-1 noExport"><?=$this->lang->line('master_active')?></th>


                        <?php } ?>
                        <th class="col-lg-1 noExport"> <?= $this->lang->line('action') ?> </th>
                        
                      <?php if(permissionChecker('airports_master_edit') || permissionChecker('airports_master_delete')) { ?>
                        

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
$( ".select2" ).select2({closeOnSelect:false, placeholder:'Value'});



 $(document).ready(function() {	 
	 var countryID = <?=$countryID?>;	
	 var regionID =<?=$regionID?>;
	 var areaID = <?=$areaID?>; 
	 var cityID = <?=$cityID?>; 
	 var airportID = <?=$airportID?>; 

        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportRegions')?>",          
		   data: {'regionID': regionID},
            dataType: "html",			
            success: function(data) {
               $('#regionID').html(data);			   
            }
        }); 		
	$('#regionID').val(regionID).change();
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportCities')?>",          
		   data: {'cityID': cityID},
            dataType: "html",			
            success: function(data) {
               $('#cityID').html(data);			   
            }
        }); 		
	$('#cityID').val(cityID).change();

        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportCountries')?>",          
		   data: {'countryID': countryID},
            dataType: "html",			
            success: function(data) {
               $('#countryID').html(data);			   
            }
        }); 		
	$('#countryID').val(countryID).change();
	 
     
$( "#airport" ).autocomplete({
      //source: availableTags
           source : function( request, response ) {
                $.ajax({
                    url: "<?=base_url('general/getAirportsByName')?>",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        search: request.term
                    },
                    success: function (data) {
		   response( $.map( data, function( item ) {                  
				  return {                                    
					label: item['airport_name'],
				value: item['airportID']
				  }
		  }));
                    }
                });
            },
    	minLength: 3,
        'select': function(event, ui) {
        $('#airport').val(ui.item.label);
	$('#airportID').val(ui.item.value);
        return false; // Prevent the widget from inserting the value.
    },
 }).val('<?php echo $airport_name; ?>').data('autocomplete');

$( "#country" ).autocomplete({
      //source: availableTags
           source : function( request, response ) {
                $.ajax({
                    url: "<?=base_url('general/getCountriesByName')?>",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        search: request.term
                    },
                    success: function (data) {
		   response( $.map( data, function( item ) {                  
				  return {                                    
					label: item['country_name'],
				value: item['countryID']
				  }
		  }));
                    }
                });
            },
    	minLength: 2,
        'select': function(event, ui) {
        $('#country').val(ui.item.label);
	$('#countryID').val(ui.item.value);
        return false; // Prevent the widget from inserting the value.
    },
 }).val('<?php echo $country_name; ?>').data('autocomplete');

$( "#city" ).autocomplete({
      //source: availableTags
           source : function( request, response ) {
                $.ajax({
                    url: "<?=base_url('general/getCitiesByName')?>",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        search: request.term
                    },
                    success: function (data) {
		   response( $.map( data, function( item ) {                  
				  return {                                    
					label: item['city_name'],
				value: item['cityID']
				  }
		  }));
                    }
                });
            },
    	minLength: 3,
        'select': function(event, ui) {
        $('#city').val(ui.item.label);
	$('#cityID').val(ui.item.value);
        return false; // Prevent the widget from inserting the value.
    },
 }).val('<?php echo $city_name; ?>').data('autocomplete');



    $('#master').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "lengthMenu": [[10,20, 100, -1], [10, 20,100, "All"]],
      "pageLength": 10,	  
      "sAjaxSource": "<?php echo base_url('airports_master/server_processing'); ?>",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "countryID","value": $("#countryID").val()},
				   {"name": "regionID","value": $("#regionID").val()},
				   {"name": "areaID","value": $("#areaID").val()},
				   {"name": "cityID","value": $("#cityID").val()},
				   {"name": "airportID","value": $("#airportID").val()},
				   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); },	  
      "columns": [{"data": "chkbox" },                
				  {"data": "airport"},				
				  {"data": "code"},				
				  {"data": "citycode" },				
				  {"data": "countrycode" },
				  {"data": "region" },
                  {"data": "area"},                  				  
                  {"data": "alias"},  
<?php  if($this->session->userdata('name')=='valuex')
{   ?>                {"data": "active"},
<?php }?>


                  {"data": "action"}

				  ],			     
     dom: 'B<"clear">lfrtip',	
    // buttons: [ 'copy', 'csv', 'excel','pdf' ],	
     buttons: [  { text: 'Delete', exportOptions: { columns: ':visible' },
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
									url: "<?php echo base_url('airports_master/delete_master_bulk_records'); ?>",
									data: {data_ids:ids_string},
									success: function(result) {
									   $('#master').DataTable().ajax.reload();
									   $('#bulkDelete').prop("checked",false);
									},
									async:false
								});
							}
							
						}
	             },
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel',exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'Export All', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('airports_master/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"countryID":$("#countryID").val(),"regionID": $("#regionID").val(),"areaID": $("#areaID").val(),"cityID": $("#cityID").val(),"airportID": $("#airportID").val(),"active": $("#active").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","airports_master.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ] ,
     "autoWidth": false,
    "columnDefs": [ {"targets": 0,"width": "1%"},{"targets": 1,"width": "1%"},{"targets": 2,"width": "1%"},{"targets": 3,"width": "1%"},{"targets": 4,"width": "1%"},{"targets": 5,"width": "1%"},{"targets": 6,"width": "1%"},{"targets": 7,"width": "1%"},{"targets": 8,"width": "1%"}]		
    }); 
  
    
  });
  
  function downloadMasterData(){
	     $.ajax({
              url: "<?php echo base_url('airports_master/server_processing'); ?>?page=all&&export=1",
              type: 'get',
              data: {"countryID":$("#countryID").val(),"regionID": $("#regionID").val(),"areaID": $("#areaID").val(),"cityID": $("#cityID").val(),"airportID": $("#airportID").val(),"active": $("#active").val()},
              dataType: 'json'
          }).done(function(data){
		 var $a = $("<a>");
		 $a.attr("href",data.file);
		 $("body").append($a);
		 $a.attr("download","airports_master.xls");
		 $a[0].click();
		 $a.remove();
		  });
  }
 
  
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
              url: "<?=base_url('airports_master/active')?>",
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
  
$(document).ready(function () {

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
                url: "<?php echo base_url('airports_master/delete_master_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#master').DataTable().ajax.reload();
                   $('#bulkDelete').prop("checked",false);
                },
                async:false
            });
        }
    }); 

              

$('#master').on('click', '.deleteRow', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });



});
</script>
