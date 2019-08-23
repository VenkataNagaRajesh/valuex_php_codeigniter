<div class="box">
  <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
           
            <li class="active"><?=$this->lang->line('menu_season_airport')?></li>           
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
            <div class="col-sm-3 col-md-2">
             <?php $slist = array("0" => "Season");               
					   foreach($seasonslist as $key => $season){
						  $slist[$key] = $season;
						}							
				echo form_dropdown("seasonID", $slist,set_value("seasonID",$seasonID), "id='seasonID' class='form-control hide-dropdown-icon select2'");    ?>
            </div>
			
            <div class="col-sm-3 col-md-2">
			 <?php  $types['VX_season_airport_origin_map']="Origin Map";
			        $types['VX_season_airport_dest_map']="Destination Map";
				 echo form_dropdown("type", $types,set_value("type",$type), "id='type' class='form-control hide-dropdown-icon select2'");    ?>
            </div>
			
			<div class="col-sm-3 col-md-2">
			 <?php  $list['0'] = " Airport";
			     foreach($airports_list as $alist ) {
				    $list[$alist->vx_aln_data_defnsID] = $alist->aln_data_value;
			     }
				 echo form_dropdown("airportID", $list,set_value("airportID",$airportID), "id='airportID' class='form-control hide-dropdown-icon select2'");    ?>
            </div>
			
            <div class="col-sm-3 col-md-2">
              <button type="submit" class="btn btn-danger" name="filter" id="filter">Filter</button>
			  <button type="button" class="btn btn-danger" onclick="downloadSeasonAirport()">Download</button>
            </div>			
          </div>
        </form>		
	    <div class="tab-content">
          <div id="all" class="tab-pane active">
            <div id="hide-table">
             <table id="satable" class="table table-striped table-bordered table-hover dataTable no-footer">
              <thead>
               <tr>
                 <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
				 <th class="col-lg-1"><?=$this->lang->line('season_airline')?></th>
			     <th class="col-lg-1"><?=$this->lang->line('season_name')?></th>
                 <th class="col-lg-1"><?=$this->lang->line('airport_name')?></th>
				 <th class="col-lg-1"><?=$this->lang->line('country')?></th>				
				 <th class="col-lg-1"><?=$this->lang->line('region')?></th>	
				 <th class="col-lg-1"><?=$this->lang->line('area')?></th>	
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
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

  $( ".select2" ).select2();

    $('#satable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
	"stateSave": true,
      "sAjaxSource": "<?php echo base_url('season_airport/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "seasonID","value": $("#seasonID").val()},
	               {"name": "type","value": $("#type").val()},
		           {"name": "airportID","value": $("#airportID").val()})
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
	"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("smarketdatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("smarketdatatable"));
                if (data) data.start = 0;
                return data;
            },

      "columns": [{"data": "temp_id" },
		          {"data": "carrier_code"},
		          {"data": "season_name"},
                  {"data": "airport" },
		          {"data": "country" },		          
		          {"data": "region" },
		          {"data": "area" }
				 ],			   
	//"abuttons": ['copy', 'csv', 'excel', 'pdf', 'print']	
	dom: 'B<"clear">lfrtip',
   // buttons: [ 'copy', 'csv', 'excel','pdf' ]
     buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('season_airport/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"seasonID": $("#seasonID").val(),"type": $("#type").val(),"airportID": $("#airportID").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","season_airport.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }                
            ]
    });
  });
  
   function downloadSeasonAirport(){
	  $.ajax({
          url: "<?php echo base_url('season_airport/server_processing'); ?>?page=all&&export=1",
          type: 'get',
          data: {"seasonID": $("#seasonID").val(),"type": $("#type").val(),"airportID": $("#airportID").val()},
          dataType: 'json'
      }).done(function(data){
		var $a = $("<a>");
		$a.attr("href",data.file);
		$("body").append($a);
		$a.attr("download","season_airport.xls");
		$a[0].click();
		$a.remove();
		 });
   }
  
   $('#satable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
</script>
