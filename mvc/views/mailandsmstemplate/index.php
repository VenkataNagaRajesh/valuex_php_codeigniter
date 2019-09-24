
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-template"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_mailandsmstemplate')?></li>
        </ol>
    </div><!-- /.box-header -->
	 <?php 
         if(permissionChecker('mailandsmstemplate_add')) {?>
           <h5 class="page-header">
               <a href="<?php echo base_url('mailandsmstemplate/add') ?>" data-toggle="tooltip" data-title="Add a template" data-placement="left" class="btn btn-danger">
                   <i class="fa fa-plus"></i> 
               </a>
           </h5>
    <?php } ?>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
			<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 
			   <div class="col-sm-2">			   
               <?php $list = array("0" => "Select Carrier");               
                   foreach($airlines as $airline){
								 $list[$airline->vx_aln_data_defnsID] = $airline->code;
							 }							
				   echo form_dropdown("filter_airline", $list,set_value("filter_airline",$filter_airline), "id='filter_airline' class='form-control select2'");    ?>
                </div>                 	    
                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-danger" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>
				<div id="hide-table">
                    <table id="mailtemplate" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-2"><?=$this->lang->line('slno')?></th>
                                <th class="col-sm-2"><?=$this->lang->line('mailandsmstemplate_name')?></th>
								<th class="col-sm-2"><?=$this->lang->line('mailandsmstemplate_airline')?></th>
                                <th class="col-sm-2"><?=$this->lang->line('mailandsmstemplate_category')?></th>
								<th class="col-sm-2"><?=$this->lang->line('mailandsmstemplate_default')?></th>
								<!--<th class="col-sm-2"><?=$this->lang->line('mailandsmstemplate_template')?></th>-->
                                <?php if(permissionChecker('mailandsmstemplate_edit') || permissionChecker('mailandsmstemplate_delete') || permissionChecker('mailandsmstemplate_view')) {
                                ?>
                                <th class="col-sm-2"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                       <!-- <tbody>
                            <?php if(count($mailandsmstemplates)) {$i = 1; foreach($mailandsmstemplates as $mailandsmstemplate) { ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('mailandsmstemplate_name')?>">
                                        <?php 
                                            if(strlen($mailandsmstemplate->name) > 25)
                                                echo substr($mailandsmstemplate->name, 0, 25)."...";
                                            else 
                                                echo substr($mailandsmstemplate->name, 0, 25);
                                        ?>
                                    </td>
									 <td data-title="<?=$this->lang->line('mailandsmstemplate_catgeory')?>">
                                        <?php
                                            echo ucfirst($mailandsmstemplate->airline_code);
                                        ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('mailandsmstemplate_catgeory')?>">
                                        <?php
                                            echo ucfirst($mailandsmstemplate->category);
                                        ?>
                                    </td>
									<td data-title="<?=$this->lang->line('mailandsmstemplate_default')?>">
                                        <?php
                                            echo ucfirst($mailandsmstemplate->default);
                                        ?>
                                    </td>
                                   <!-- <td data-title="<?=$this->lang->line('mailandsmstemplate_template')?>">
                                        <?php 
                                            if(strlen($mailandsmstemplate->template) > 25)
                                                echo substr($mailandsmstemplate->template, 0, 25)."...";
                                            else 
                                                echo substr($mailandsmstemplate->template, 0, 25);
                                        ?>
                                    </td>
									
                                    <?php if(permissionChecker('mailandsmstemplate_edit') || permissionChecker('mailandsmstemplate_delete') || permissionChecker('mailandsmstemplate_view')) {
                                    ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
                                        <?php //echo btn_view('mailandsmstemplate/view/'.$mailandsmstemplate->mailandsmstemplateID, $this->lang->line('view')) ?>
                                        <?php echo btn_edit('mailandsmstemplate/edit/'.$mailandsmstemplate->mailandsmstemplateID, $this->lang->line('edit')) ?>
                                        <?php echo btn_delete('mailandsmstemplate/delete/'.$mailandsmstemplate->mailandsmstemplateID, $this->lang->line('delete')) ?>
										<a href="<?=base_url('mailandsmstemplate/makedefault/'.$mailandsmstemplate->mailandsmstemplateID)?>" class="btn btn-success btn-xs mrg">Make Default</a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php $i++; }} ?>
                        </tbody>-->
                    </table>
                </div>
                

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {	 
	
    $('#mailtemplate').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('mailandsmstemplate/server_processing'); ?>",
	  "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "filter_airline","value": $("#filter_airline").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },
      "columns": [{"data": "mailandsmstemplateID" },
                  {"data": "name" },
				  {"data": "airline_code" },
				  {"data": "category"},				
				  {"data": "default"},
                  {"data": "action"}
				  ],			     
     dom: 'B<"clear">lfrtip',
    // buttons: [ 'copy', 'csv', 'excel','pdf' ],
	 buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },                       
            ],
	"autoWidth": false,
	"columnDefs": [ {"targets": 0,"width": "30px"}]
    });
	
	
  });
</script>