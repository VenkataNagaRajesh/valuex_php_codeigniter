
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-sitemap"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_marketzone')?></li>           
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

                    <h5 class="page-header">

		<?php
                    if(permissionChecker('marketzone_add')) {
                ?>
                        <a href="<?php echo base_url('marketzone/add') ?>">
                            <i class="fa fa-plus"></i>
                            <?=$this->lang->line('add_title')?>
                        </a>
	
		<?php } ?>

                        &nbsp;&nbsp;
                         <?php if(permissionChecker('marketzone_reconfigure')) {
					 if( isset ($reconfigure)) {?>
                                <a href="<?php echo base_url('trigger') ?>">
                                    <i class="fa fa-plus"></i>
                                    <?=$this->lang->line('generate_map_table')?>
                                </a>
                        <?php } }?>

                    </h5>

       <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                      <div class='form-group'>
                           <div class="col-sm-2">
               <?php $marketlist = array("0" => "Select Marketzone");
                   foreach($marketzones as $marketzone){
                                                                 $marketlist[$marketzone->market_id] = $marketzone->market_name;
                                                         }
                                   echo form_dropdown("market_id", $marketlist,set_value("market_id",$marketID), "id='market_id' class='form-control hide-dropdown-icon select2'");    ?>
                </div>
                 <div class="col-sm-2">
		<?php 
			$aln_datatypes['0'] = "Select Level Type";
                        ksort($aln_datatypes);
			echo form_dropdown("amz_level_id", $aln_datatypes,set_value("amz_level_id",$levelID), "id='amz_level_id' class='form-control hide-dropdown-icon select2'");    ?>

                 </div>
                             <div class="col-sm-2">

			  <?php
                        $aln_datatypes['0'] = "Select Inclusion Type ";
                        ksort($aln_datatypes);
                        echo form_dropdown("amz_incl_id", $aln_datatypes,set_value("amz_incl_id",$inclID), "id='amz_incl_id' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>
                 <div class="col-sm-2">

			<?php
                        $aln_datatypes['0'] = "Select Exclusion Type ";
                        ksort($aln_datatypes);
                        echo form_dropdown("amz_excl_id", $aln_datatypes,set_value("amz_excl_id",$exclID), "id='amz_excl_id' class='form-control hide-dropdown-icon select2'");    ?>


                 </div>

		  <div class="col-sm-2">
                           <?php
                        $airlinelist[0]= 'Select Airline For marketzone';
                        foreach($airlines as $airline){
                                $airlinelist[$airline->vx_aln_data_defnsID] = $airline->airline_name;
                        }
			
                        echo form_dropdown("airline_id", $airlinelist,set_value("airline_id"), "id='airline_id' class='form-control hide-dropdown-icon select2'");?>
                                                   
                        </div>


		<div class="col-sm-2">

                        <?php
			$mkt_status['-1'] = 'Select Status';
			$mkt_status['1'] = 'Active';
			$mkt_status['0'] = 'In Active';
                        echo form_dropdown("active", $mkt_status,set_value("active",$active), "id='active' class='form-control hide-dropdown-icon select2'");    ?>


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
								<th class="col-lg-1"><?=$this->lang->line('market_name')?></th>
								<th class="col-lg-1"><?=$this->lang->line('airline_code')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('level_type')?></th>
								<th class="col-lg-1"><?=$this->lang->line('amz_level_value')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('amz_incl_type')?></th>
								<th class="col-lg-1"><?=$this->lang->line('amz_incl_value')?></th>
								<th class="col-lg-1"><?=$this->lang->line('amz_excl_type')?></th>
								<th class="col-lg-1"><?=$this->lang->line('amz_excl_value')?></th>
								 <?php if(permissionChecker('marketzone_edit')) { ?>
                        				        <th class="col-lg-1"><?=$this->lang->line('marketzone_status')?></th>
                                <?php } ?>
                             
                                 <?php if(permissionChecker('marketzone_edit') || permissionChecker('marketzone_view') ||  permissionChecker('marketzone_detete')) { ?>
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
      "sAjaxSource": "<?php echo base_url('marketzone/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "marketID","value": $("#market_id").val()},
		   {"name": "levelID","value": $("#amz_level_id").val()},
		   {"name": "inclID","value": $("#amz_incl_id").val()},
		   {"name": "exclID","value": $("#amz_excl_id").val()},
		   {"name": "airlineID","value": $("#airline_id").val()},
		   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
      "columns": [{"data": "market_id" },
		  {"data": "market_name"},
		  {"data": "airline_name"},
                  {"data": "lname" },
				  {"data": "levelname" },
				  {"data": "iname" },
				  {"data": "inclname" },
                  {"data": "ename"},
				  {"data": "exclname"},
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
              url: "<?=base_url('marketzone/active')?>",
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
