
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-sitemap"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_market_airport')?></li>           
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
			
                        $list['0'] = "Select Airport";
			foreach($airports_list as $alist ) {
				$list[$alist->vx_aln_data_defnsID] = $alist->aln_data_value;
			}
                        echo form_dropdown("airport_id", $list,set_value("airport_id",$airportID), "id='airport_id' class='form-control hide-dropdown-icon select2'");    ?>


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
                                <th class="col-lg-1"><?=$this->lang->line('airport_name')?></th>
				<th class="col-lg-1"><?=$this->lang->line('city')?></th>
				<th class="col-lg-1"><?=$this->lang->line('country')?></th>
				<th class="col-lg-1"><?=$this->lang->line('region')?></th>	
				<th class="col-lg-1"><?=$this->lang->line('area')?></th>	
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
      "sAjaxSource": "<?php echo base_url('market_airport/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "marketID","value": $("#market_id").val()},
		   {"name": "airportID","value": $("#airport_id").val()})
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
      "columns": [{"data": "market_id" },
		  {"data": "market_name"},
                  {"data": "airport" },
		  {"data": "city" },
			{"data": "country" },
		 {"data": "region" },
		{"data": "area" }
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
  
</script>
