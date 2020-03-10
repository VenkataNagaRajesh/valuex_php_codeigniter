
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_partner')?></li>
        </ol>
    </div><!-- /.box-header -->
	<?php 
         $usertype = $this->session->userdata("usertype");
         if(permissionChecker('partner_add')) {?>
         <h5 class="page-header">
             <a href="<?php echo base_url('partner/add') ?>" data-toggle="tooltip" data-title="Add Role" data-placement="left" class="btn btn-danger">
                 <i class="fa fa-plus"></i> 
             </a>
         </h5>
     <?php } ?>
    <!-- form start -->
    <div class="box-body">
        <div class="row">        
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
                        <div class='form-group'>
                            <div class="col-sm-2 col-xs-6">			   
                            <?php $list1 = array("0" => "Carrier");               
                                    foreach($myairlines as $airline){
                                    $list1[$airline->vx_aln_data_defnsID] = $airline->code;	
                                    }				
                            echo form_dropdown("carrierID", $list1,set_value("carrierID",$carrierID), "id='carrierID' class='form-control hide-dropdown-icon select2'");    ?>
                            </div>
                            <div class="col-sm-2 col-xs-6">			   
                            <?php  $list2 = array("0" => "Partner Carrier");               
                                    foreach($airlines as $airline){
                                    $list2[$airline->vx_aln_data_defnsID] = $airline->code;	
                                    }				
                                    echo form_dropdown("partner_carrierID", $list2,set_value("partner_carrierID",$partner_carrierID), "id='partner_carrierID' class='form-control hide-dropdown-icon select2'");    ?>
                            </div>
                            <div class="col-sm-2 col-xs-6">	
                                <?php $origin_level_list[0]="Origin Level";
                                 foreach($types as $type){
                                  $origin_level_list[$type->vx_aln_data_typeID] = $type->alias;
                                 }
                                echo form_dropdown("origin_level", $origin_level_list, set_value("origin_level"), "id='origin_level' class='form-control select2'");
                                ?>
                            </div>
                            <div class="col-sm-2 col-xs-6">
				                <select  name="origin_content[]"  placeholder="Origin Content" id="origin_content" class="form-control select2" multiple="multiple">
				                </select> 
                            </div>
                            <div class="col-sm-2 col-xs-6">	
                            <?php $dest_level_list[0]="Destination Level";
                                 foreach($types as $type){
                                  $dest_level_list[$type->vx_aln_data_typeID] = $type->alias;
                                 }
                                echo form_dropdown("dest_level", $dest_level_list, set_value("dest_level"), "id='dest_level' class='form-control select2'");
                            ?>
                            </div> 
                            <div class="col-sm-2 col-xs-6">
				                <select  name="dest_content[]"  placeholder="Destination Content" id="dest_content" class="form-control select2" multiple="multiple">
				                </select> 
                            </div> 
                        </div>
                        <div class='form-group'>
                            <div class="col-sm-2 col-xs-6">
                                <div class="input-group" style="margin-bottom: 0">
                                    <input type="text" class="form-control hasDatepicker" placeholder="Start Date"  id="start_date" name="start_date" value="<?=set_value('start_date',$start_date)?>" >
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <div class="input-group" style="margin-bottom: 0">
                                    <input type="text" class="form-control hasDatepicker" placeholder="End Date" id="end_date" name="end_date" value="<?=set_value('end_date',$end_date)?>" >
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
                            </div>
                            <div class="col-sm-2">
                            <a href="#" type="button"  class="btn btn-danger" onclick="downloadPartners()" data-title="Download" data-toggle="tooltip" data-placement="top" style="padding: 6px 12px;"><i class="fa fa-download"></i></a>
                            </div>                                                     
                        </div>				
                </form>
            </div>
            <div class="col-sm-12 off-elg-table">
                <div id="hide-table">
                     <table id="partnertable" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1 noExport"><?=$this->lang->line('carrier')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_carrier')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_origin_level')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('partner_origin_content')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('partner_destination_level')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('partner_destination_content')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_start_date')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('partner_end_date')?></th>                                
                                <?php if(permissionChecker('partner_edit') || permissionChecker('partner_delete') || permissionChecker('partner_view')) { ?>
                                <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
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
$(".select2").select2();
$('#start_date').datepicker();
$('#end_date').datepicker();
$(document).ready(function(){
    $('#origin_level').val(<?=$origin_level?>).trigger('change');
    var origin_content = [<?=implode(',',$origin_content)?>];
    $('#origin_content').val(origin_content).trigger('change');
    $('#dest_level').val(<?=$dest_level?>).trigger('change');
    var dest_content = [<?=implode(',',$dest_content)?>];
    $('#dest_content').val(dest_content).trigger('change');        
});
$('#origin_level').change(function(event) {    
	$('#origin_content').val(null).trigger('change')
    var level_id = $(this).val();                   
    var airline_id = $('#partner_carrierID').val();  
	if( level_id == '17' ) {
		if($('#partner_carrierID').val() == '0') {
			alert('select Airline');
			$("#origin_level").val(0);
            $('#origin_level').trigger('change');
			return false;
		}
	}               
    $.ajax({     async: false,            
	    type: 'POST',            
        url: "<?=base_url('marketzone/getSubdataTypes')?>",            
        data: {"id":level_id,"airline_id":airline_id},           
        dataType: "html",                                  
        success: function(data) {               
        $('#origin_content').html(data); }        
    });       
});
$('#dest_level').change(function(event) {    
	$('#dest_content').val(null).trigger('change')
    var level_id = $(this).val(); 
    var airline_id = $('#partner_carrierID').val();  
	if( level_id == '17' ) {
		if($('#partner_carrierID').val() == '0') {
			alert('select Airline');
			$("#dest_level").val(0);
            $('#dest_level').trigger('change');
			return false;
		}
	}                               
    $.ajax({     async: false,            
	    type: 'POST',            
        url: "<?=base_url('marketzone/getSubdataTypes')?>",            
        data: {"id":level_id,"airline_id":airline_id},           
        dataType: "html",                                  
        success: function(data) {               
        $('#dest_content').html(data); }        
    });       
});
$('#partner_carrierID').change(function(event) {
	if ($('#origin_level').val() == 17 ) {
		$('#origin_level').trigger('change');
	}
	if ($('#dest_level').val() == 17 ) {
		$('#dest_level').trigger('change');
	}
});

$(document).ready(function() {	 
    $('#partnertable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('partner/server_processing'); ?>",  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "carrierID","value": $("#carrierID").val()},
                   {"name": "partner_carrierID","value": $("#partner_carrierID").val()},
                   {"name": "start_date","value": $("#start_date").val()},
                   {"name": "end_date","value": $("#end_date").val()},
                   {"name": "origin_level","value": $("#origin_level").val()},
                   {"name": "origin_content","value": $("#origin_content").val()},
                   {"name": "dest_level","value": $("#dest_level").val()},
                   {"name": "dest_content","value": $("#dest_content").val()},
                    ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
			 } ); },               
       "columns": [{"data": "sno" },
                  {"data": "carrier_code" },
				  {"data": "partner_carrier_code" },
				  {"data": "origin_level_value" },
				  {"data": "origin_content_data" },
				  {"data": "dest_level_value" },
				  {"data": "dest_content_data" },
                  {"data": "start_date"},
                  {"data" : "end_date"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
     //buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
	 buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                            var submitData = {sSearch: $("input[type=search]").val(),"carrierID": $("#carrierID").val(),"partner_carrierID":$("#partner_carrierID").val(),"start_date":$("#start_date").val(),"end_date":$("#end_date").val(),"origin_content":$("#origin_content").val(),"origin_level":$("#origin_level").val(),"dest_level":$("#dest_level"),"dest_content":$("#dest_content")};
                           $.ajax({
                                url: "<?php echo base_url('partner/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: JSON.stringify(submitData) ,
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","partners.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }	                
            ] ,
    });
  }); 

  function downloadPartners(){ 
      var submitData = {"carrierID": $("#carrierID").val(),"partner_carrierID":$("#partner_carrierID").val(),"start_date":$("#start_date").val(),"end_date":$("#end_date").val(),"origin_content":$("#origin_content").val(),"origin_level":$("#origin_level").val(),"dest_level":$("#dest_level"),"dest_content":$("#dest_content")};
          
	  $.ajax({
             url: "<?php echo base_url('partner/server_processing'); ?>?page=all&&export=1",
             type: 'get',
             data: JSON.stringify(submitData) ,
             dataType: 'json'
         }).done(function(data){
			var $a = $("<a>");
			$a.attr("href",data.file);
			$("body").append($a);
			$a.attr("download","partners.xls");
			$a[0].click();
			$a.remove();
		 });
  }

</script>
