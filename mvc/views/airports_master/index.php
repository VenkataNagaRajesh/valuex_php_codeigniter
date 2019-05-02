
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_airports_master')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
              <h5 class="page-header">                        
					<?php if(permissionChecker('airports_master_upload')) { ?>
                  <a href="<?php echo base_url('airports_master/upload') ?>">
                      <i class="fa fa-upload"></i>
                      <?=$this->lang->line('upload_airports')?>
                  </a>
				 <?php } ?>
              </h5>
			  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 
			   <div class="col-sm-2">			   
               <?php $clist = array("0" => "Select Country");               
                   foreach($countrylist as $country){
								 $clist[$country->vx_aln_data_defnsID] = $country->aln_data_value;
							 }							
				   echo form_dropdown("countryID", $clist,set_value("countryID",$countryID), "id='countryID' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                 <div class="col-sm-2">			   
                   <select name="stateID" id="stateID" class="form-control" placeholder="State">
				   
				   </select>
                 </div>                				
			     <div class="col-sm-2">
                    <select name="regionID" id="regionID" class="form-control" placeholder="Region">
				   
				    </select>
                 </div>
                 <div class="col-sm-2">
                 	<select name="areaID" id="areaID" class="form-control" placeholder="Area">
				   
				    </select>	
                 </div>
                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>				
            <div id="hide-table">
               <table id="master" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
                        <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                        <th class="col-lg-2"><?=$this->lang->line('master_airport')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_country')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_state')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_region')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_area')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_code')?></th>
						<th class="col-lg-1"><?=$this->lang->line('master_active')?></th>
                        <?php if(permissionChecker('airports_master_edit') || permissionChecker('airports_master_delete')) { ?>
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
<script>
 $(document).ready(function() {	 
	 var countryID = <?=$countryID?>;
	 var stateID = <?=$stateID?>;
	 var regionID =<?=$regionID?>;
	 var areaID = <?=$areaID?>;
	
    if(countryID == null) {
        $('#stateID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportStates')?>",          
		   data: {"countryID" :countryID , "stateID": stateID},
            dataType: "html",			
            success: function(data) {
               $('#stateID').html(data);
            }
        }); 		
	}
	
	if(stateID === null) { 
        $('#regionID').val(0);
    } else { 
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportRegions')?>",          
		   data: {"regionID" :regionID , "stateID": stateID},
            dataType: "html",			
            success: function(data) {
               $('#regionID').html(data);
            }
        }); 		
	}
	
	if(regionID === null) {
        $('#areaID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportAreas')?>",          
		   data: {"regionID" :regionID , "areaID": areaID},
            dataType: "html",			
            success: function(data) {
               $('#areaID').html(data);
            }
        }); 		
	}
	 
    $('#master').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('airports_master/server_processing'); ?>",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "countryID","value": $("#countryID").val()},{"name": "stateID","value": $("#stateID").val()},{"name": "regionID","value": $("#regionID").val()},{"name": "areaID","value": $("#areaID").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); },	  
      "columns": [{"data": "vx_amdID" },
                  {"data": "airport" },
				  {"data": "country" },
				  {"data": "state" },
				  {"data": "region" },
                  {"data": "area"},
                  {"data": "code"},				  
                  {"data": "active"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',	
    // buttons: [ 'copy', 'csv', 'excel','pdf' ]	
      buttons: [{
		  extend: 'collection',
		  className: 'exportButton',
		  text: 'Data Export',
		  buttons: ['copy','excel','csv','pdf'],
		  modifier : {
                        // DataTables core
                        order : 'current',  // 'current', 'applied', 'index',  'original'
                        page : 'all',      // 'all',     'current'
                        search : 'applied'     // 'none',    'applied', 'removed'
                    }
		}]
		
    }); 	
  });
 
  
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
  
  $('#countryID').on('change',function(event) {
   var countryID = $(this).val();
 if(countryID == null) {
        $('#stateID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportStates')?>",          
		   data: {"countryID" :countryID},
            dataType: "html",			
            success: function(data) {
               $('#stateID').html(data);
            }
        }); 		
	}
});	

$('#stateID').on('change',function(e) {
	e.preventDefault();
   var stateID = $(this).val();   
	if(stateID === null) {
        $('#regionID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportRegions')?>",          
		   data: {"stateID": stateID},
            dataType: "html",			
            success: function(data) {
               $('#regionID').html(data);
            }
        }); 		
	}
});

$('#regionID').on('change', function(event) {
   var regionID = $(this).val();
	if(regionID === null) {
        $('#areaID').val(0);
    } else {  
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportAreas')?>",          
		   data: {"regionID" :regionID},
            dataType: "html",			
            success: function(data) {
               $('#areaID').html(data);			   
            }
        }); 		
	}
});

</script>
