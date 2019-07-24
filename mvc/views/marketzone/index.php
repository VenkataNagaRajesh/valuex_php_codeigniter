<div class="mzones">
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:84%;margin-right:16px;">Market Zones</h2>
	<span data-toggle="collapse" data-target="#treeview"><button type="button" class="btn btn-danger pull-right" style="margin:1px 9px;"><i class="fa fa-tree"></i> Tree View</button></span>
	<div class="col-md-12 collapse" id="treeview">
		<div class="col-md-8 col-md-offset-2 tree-box">
			<div class="srch-buttons">
				<div class="col-md-4">
					<a href="#" type="button" class="btn btn-default">Market Zone</a>
				</div>
				<div class="col-md-8">
				  <div class="input-group">
					 <input type="text" class="form-control" id="example" placeholder="Search">

					<div class="input-group-btn">
					  <button class="btn btn-danger" id='mysearch' type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				  </div>
				 </div>
			</div>
			<div class="col-md-12">
				<div id="mytree" class="market-info-tree"></div>
			</div>
		</div>
	</div>
	<span class="card-header" data-toggle="collapse" data-target="#mzonesAdd"><button type="button" id = 'add_zone_button' class="btn btn-danger" style="margin:1px 0;" data-placement="left" title="Add Market Zone" data-toggle="tooltip"><i class="fa fa-plus"></i></button></span>
	<div class="col-md-12 collapse" id="mzonesAdd">
		<div class="col-md-12">
		<form class="form-horizontal" role="form" method="post" id='add_zone' enctype="multipart/form-data">
			<div class="mzone-config col-md-12">
				<div class="col-md-12 zone-info1">
					<h2>Market Zone Configuration</h2>
					<div class="col-md-2">
						<!--<p>Airline Code</p>-->

					<?php
                                                         $airlinelist[0]= 'Airline';
                                                     foreach($airlines as $airline){
                                                                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->aln_data_value.'('.$airline->code.')';
                                                         }
							ksort($airlinelist);
                                                   echo form_dropdown("airline_id", $airlinelist,set_value("airline_id"), "id='airline_id' class='form-control hide-dropdown-icon select2'");
                                                   ?>
					</div>
					<div class="col-md-2">
						<!--<p>Market Name</p>-->

						<input type="text" class="form-control" placeholder='market name' id="market_name" name="market_name" value="<?=set_value('market_name')?>" >
					</div>
					<div class="col-md-2">
						<!--<p>Market Level</p>-->
					<?php $aln_datatypes['0'] = "Level ";
  			                      ksort($aln_datatypes);

			echo form_dropdown("amz_level_id", $aln_datatypes, set_value("amz_level_id"), "id='amz_level_id' class='form-control select2'");
					?>
					</div>
					<div class="col-md-6">
						<!--<p class="col-md-10">Value</p>-->
						<div class="col-md-11" style="padding:0;">
							<select  name="amz_level_value[]"  id="amz_level_value" class="form-control select2" multiple="multiple">
							</select>
						</div>
						<div class="col-md-1">
							<span title="Select All" data-toggle="tooltip" data-placement="top"><input type="checkbox" id="checkbox_level"></span>
						</div>						
					</div>
				</div>
				<div class="col-md-12 zone-info2">
					<div class="col-md-6">
						<?php
					 $aln_datatypes['0'] = "Inclusion Level";
                                              ksort($aln_datatypes);
                        echo form_dropdown("amz_incl_id", $aln_datatypes, set_value("amz_incl_id"), "id='amz_incl_id' class='form-control select2'");
                        ?>
				<br>
				<div class="col-md-11" style="padding:0;">
				<select  name="amz_incl_value[]"  id="amz_incl_value" class="form-control select2" multiple="multiple"></select>
				</div>
				<div class="col-md-1">
					<span title="Select All" data-toggle="tooltip" data-placement="top"> <input type="checkbox" id="checkbox_incl" ></span>
				</div>


					</div>
					<div class="col-md-6">
				                    <?php
						 $aln_datatypes['0'] = "Exclusion Level";
                                              ksort($aln_datatypes);
 echo form_dropdown("amz_excl_id", $aln_datatypes, set_value("amz_excl_id"), "id='amz_excl_id' class='form-control select2'");
                        ?>
					<br>
					<div class="col-md-11" style="padding:0;">
						<select  name="amz_excl_value[]"  id="amz_excl_value" class="form-control select2" multiple="multiple">
                     </select>
					</div>
					<div class="col-md-1">
						<span title="Select All" data-toggle="tooltip" data-placement="top"> <input type="checkbox" id="checkbox_excl" ></span>
					</div>
					</div>
					<div class="col-md-12">
					<input type="hidden" class="form-control" id="market_id" name="market_id"   value="" >
					</div>
					<div class="col-md-12">
					<br>
					<input type="text" class="form-control" id="desc" name="desc" placeholder='description'  value="<?=set_value('market_name')?>" >
						<span class="pull-right">
					   <a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="savezone()">Save</a>
					  <a href="#" type="button" class="btn btn-danger" onclick="form_reset()">Cancel</a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</form>
	</div>
	<div class="col-md-12">
		<div class="mzones-list-bar">

		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" style="margin-bottom:-1em;">
				<div class="title-bar">
					<div class="col-md-2" id='reconfigure'>

					 <?php if(permissionChecker('marketzone_reconfigure')) {
					 if( isset ($reconfigure)) {?>
                               			 <h2><a href="<?php echo base_url('trigger/marketzone_trigger') ?>" class="btn btn-danger">
                                    			<i class="fa fa-plus"></i>
                                    			<?=$this->lang->line('generate_map_table')?>
                                			</a>
						  </h2> <span class="pull-right"></span>
                        <?php } }?>

                                        </div>
				</div>
				<div class="col-md-12">
					<div class="table-reponsive col-md-12">
						<div class="col-md-11">
							<table class="table table-bordered table-striped table-highlight">
								<!--<thead>
									<th>Airline Code</th>
									<th>Select Marketzone</th>
									<th>Select Level Type</th>
									<th>Select Level Value</th>  
									<th>Select Inclusion Type</th>
							        	<th>Select Inclusion Value</th> 
									<th>Select Exclusion Type</th>
									<th>Select Exclusion Value</th> 
								</thead>-->
								<tbody>
									<tr>
										<td>
											     <?php                         

				 echo form_dropdown("sairline_id", $airlinelist,set_value("sairline_id"), "id='sairline_id' class='form-control hide-dropdown-icon select2'");?>                                                
										</td>
										<td>
								
               <?php $marketlist = array("0" => "Marketzone");
                   foreach($marketzones as $marketzone){
                                                                 
				$marketlist[$marketzone->market_id] = $marketzone->market_name;
                                                         }
                  echo form_dropdown("smarket_id", $marketlist,set_value("smarket_id",$marketID), "id='smarket_id' class='form-control hide-dropdown-icon select2'");    ?>
                
										</td>
										<td>
							<?php 			$aln_datatypes['0'] = "Level Type";                         ksort($aln_datatypes); 			echo form_dropdown("samz_level_id", $aln_datatypes,set_value("samz_level_id",$levelID), "id='samz_level_id' class='form-control hide-dropdown-icon select2'");    ?>
										</td>
									<!--	<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>	-->
										<td>

								  <?php                         $aln_datatypes['0'] = "Inclusion Type ";                         ksort($aln_datatypes);                         echo form_dropdown("samz_incl_id", $aln_datatypes,set_value("samz_incl_id",$inclID), "id='samz_incl_id' class='form-control hide-dropdown-icon select2'");    ?> 
										</td>
									<!--	<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>-->
										<td>

		 			<?php                         $aln_datatypes['0'] = "Exclusion Type ";                         ksort($aln_datatypes);                         echo form_dropdown("samz_excl_id", $aln_datatypes,set_value("samz_excl_id",$exclID), "id='samz_excl_id' class='form-control hide-dropdown-icon select2'");    ?> 
										</td>
									<!--	<td>
											<select class="form-control" id="inc-level">
												<option>level</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
											</select>
										</td>	-->
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-1">
				 <a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="$('#tztable').dataTable().fnDestroy();;loaddatatable();">Filter</a>
				 <a href="#" type="button"  class="btn btn-danger" onclick="downloadZone()">Download</a>
						</div>
						
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-12">
		<div class="col-md-12">
			<div class="tab-content table-responsive" id="hide-table">
				<table id="tztable" class="table table-bordered dataTable no-footer">
				  <thead>
					   <tr>
						      
							<th><input type="checkbox" id="bulkDelete"/> <button id="deleteTriger">Delete All</button></th>
							<th><?=$this->lang->line('market_name')?></th>
							<th><?php echo "Airline";?></th>
							<th><?=$this->lang->line('level_type')?></th>
							<th><?=$this->lang->line('amz_level_value')?></th>
							<th><?=$this->lang->line('amz_incl_type')?></th>
							<th><?=$this->lang->line('amz_incl_value')?></th>
							<th><?=$this->lang->line('amz_excl_type')?></th>
							<th><?=$this->lang->line('amz_excl_value')?></th>
							 <?php if(permissionChecker('marketzone_edit')) { ?>
								 <th class="noExport"><?=$this->lang->line('marketzone_status')?></th>
							<?php } ?>                       
							<?php if(permissionChecker('marketzone_edit') || permissionChecker('marketzone_view') ||  permissionChecker('marketzone_detete')) { ?>
						   <th class="noExport"><?=$this->lang->line('action')?></th>
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
<script>
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

//$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

//$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});
</script>



<script type="text/javascript">
  $(document).ready(function() {

$( ".select2" ).select2({closeOnSelect:false, placeholder:'Value'});
	
	loadjstree();

	loaddatatable();

 });



function loaddatatable() {
    $('#tztable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('marketzone/server_processing'); ?>",	  
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "marketID","value": $("#smarket_id").val()},
		   {"name": "levelID","value": $("#samz_level_id").val()},
		   {"name": "inclID","value": $("#samz_incl_id").val()},
		   {"name": "exclID","value": $("#samz_excl_id").val()},
		   {"name": "airlineID","value": $("#sairline_id").val()},
		   {"name": "active","value": $("#active").val()}) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); },      
      "columns": [{"data": "cbox" },
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
   // buttons: [ 'copy', 'csv', 'excel','pdf' ],
    buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)" } },
				{ extend: 'pdf', exportOptions: { columns: "thead th:not(.noExport)" } },
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('marketzone/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"marketID": $("#smarket_id").val(),"levelID":$("#samz_level_id").val(),"inclID":$("#samz_incl_id").val(),"exclID":$("#samz_excl_id").val(),"airlineID":$("#sairline_id").val(),"active":$("#active").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","marketzone.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 },  

			 {
                text: 'Bulk Delete',
                action: function ( e, dt, node, config ) {

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
                url: "<?php echo base_url('marketzone/delete_mz_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
                   $('#tztable').DataTable().ajax.reload();
                },
                async:false
            });
        }

                }

            }

            ] ,
	"autoWidth": false,
     "columnDefs": [ {"targets": 0,"orderable": false,"searchable": false,"width": "130px" },
                     { "width": "130px", "targets": 1 },
                     { "width": "50px", "targets": 2 },
					 { "width": "60px", "targets": 9 }					 
				 ]
    });
}  
   $('#tztable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  function downloadZone(){
	   $.ajax({
             url: "<?php echo base_url('marketzone/server_processing'); ?>?page=all&&export=1",
             type: 'get',
             data: {"marketID": $("#smarket_id").val(),"levelID":$("#samz_level_id").val(),"inclID":$("#samz_incl_id").val(),"exclID":$("#samz_excl_id").val(),"airlineID":$("#sairline_id").val(),"active":$("#active").val()},
             dataType: 'json'
         }).done(function(data){
			var $a = $("<a>");
			$a.attr("href",data.file);
			$("body").append($a);
			$a.attr("download","marketzone.xls");
			$a[0].click();
			$a.remove();
		   });
  }
  
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
<script>
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

</script>
<script>
$(document).ready(function(){
$('#amz_incl_id').trigger('change');
$('#amz_excl_id').trigger('change');
$('#amz_level_id').trigger('change');
        var level = [<?php echo implode(',',$this->input->post("amz_level_value")); ?>];
        $('#amz_level_value').val(level).trigger('change');

        var incl = [<?php echo implode(',',$this->input->post("amz_incl_value")); ?>];
        $('#amz_incl_value').val(incl).trigger('change');

        var excl = [<?php echo implode(',',$this->input->post("amz_excl_value")); ?>];
        $('#amz_excl_value').val(excl).trigger('change');

});


$('#airline_id').change(function(event) {
	$('#amz_level_id').trigger('change');
	$('#amz_excl_id').trigger('change');
	$('#amz_incl_id').trigger('change');

});

$('#amz_level_id').change(function(event) {    
        $('#amz_level_value').val(null).trigger('change');
  var level_id = $(this).val();                 
  var airline_id = $('#airline_id').val();
	if( level_id == '17' ) {
		if($('#airline_id').val() == '0') {
			alert('select Airline');
			$("#amz_level_id").val(0);
                           $('#amz_level_id').trigger('change');

			return false;
		}
	}
	
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            

	     data: {
                           "id":level_id,
			   "airline_id":airline_id
				},
             dataType: "html",                                  
             success: function(data) {               
             $('#amz_level_value').html(data); }        
      });       
});

$('#amz_incl_id').change(function(event) {    
        $('#amz_incl_value').val(null).trigger('change');
  var incl_id = $(this).val();                 
   var airline_id = $('#airline_id').val();
	 if( incl_id == '17' ) {
                if($('#airline_id').val() == '0') {
                        alert('select Airline');
			$('#amz_incl_id').val('0').trigger('change');
                        return false;
                }
        }

$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
	      data: {
                           "id":incl_id,
                           "airline_id":airline_id
                                },

             dataType: "html",                                  
             success: function(data) {               
             $('#amz_incl_value').html(data); }        
      });       
});



$('#amz_excl_id').change(function(event) {    
        $('#amz_excl_value').val(null).trigger('change');
  var excl_id = $(this).val();                 
   var airline_id = $('#airline_id').val();
	 if( excl_id == '17' ) {
                if($('#airline_id').val() == '0') {
                        alert('select Airline');
			 $('#amz_excl_id').val('0').trigger('change');
                        return false;
                }
        }

$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
	 data: {
                           "id":excl_id,
                           "airline_id":airline_id
                                },

             dataType: "html",                                  
             success: function(data) {               
             $('#amz_excl_value').html(data); }        
      });       
});
 
function savezone() {
  $.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('marketzone/save')?>",          
                  data: {"airline_id" :$('#airline_id').val(),
			 "market_name":$('#market_name').val(),
			 "amz_level_id":$('#amz_level_id').val(),
			 "amz_level_value":$('#amz_level_value').val(),
		         "amz_incl_id":$('#amz_incl_id').val(),
			  "amz_incl_value":$('#amz_incl_value').val(),
			  "amz_excl_id":$('#amz_excl_id').val(),
                          "amz_excl_value":$('#amz_excl_value').val(),
			  "desc":$('#desc').val(),
				
			   "market_id":$('#market_id').val()},
          dataType: "html",                     

	 beforeSend: function() {

			if($('#airline_id').val() == '0' ) {
				$('#airline_id').addClass('has-error');
				var error = 1;
				//alert('Airline Code is required');
			}

			if($('#market_name').val() == '' ) {
				var error = 1;
				$('#market_name').parent().addClass("has-error");
				//alert('Market Name is required');
			}
			if($('#amz_level_id').val() == '0'  ) {
				var error = 1;
				 $('#amz_level_id').addClass('has-error');
				//alert('Market Level field is required');
                        }

			if($('#amz_level_value').val() == null ) {
				var error = 1;
                                $('#amz_level_value').addClass('has-error');
				//alert('Market Level Value fields is required');
                        }


			if (error == 1 ) {
				alert('Please select required fields');
				return false;
		
			}

    			},



         success: function(data) {
                var zoneinfo = jQuery.parseJSON(data);
                var status = zoneinfo['status'];
                newstatus = status.replace(/<p>(.*)<\/p>/g, "$1");
                if (status == 'success' ) {
                        if ( zoneinfo['action'] == 'add' ) {
                                alert('Marketzone added successfully');
                        } else if (zoneinfo['action'] == 'edit') {
                                alert('Marketzone updated successfully');
                        }
			form_reset();
                        $("#tztable").dataTable().fnDestroy();
                        loaddatatable();
                        if (zoneinfo['has_reconf_perm'] && zoneinfo['reconfigure']) {
                                <?php
                                        $link = '<h2><a href="'.base_url('trigger/marketzone_trigger').'" class="btn btn-danger"> <i class="fa fa-plus"></i> '.$this->lang->line('generate_map_table').' </a></h2>';

                                  ?>

                                $('#reconfigure').html('<?php echo $link?>');
                        }

                } else {
                        alert(newstatus);

                }

          }

          });
}
function form_reset(){    
          var $inputs = $('#add_zone :input'); 
          $inputs.each(function (index)
       {
          $(this).val("");  
       });

           $("#airline_id").val(0);
           $('#airline_id').trigger('change');
	   $("#amz_level_id").val(0);
           $('#amz_level_id').trigger('change');

	    $("#amz_incl_id").val(0);
           $('#amz_incl_id').trigger('change');
	
	  $("#amz_excl_id").val(0);
           $('#amz_excl_id').trigger('change');
  }



function editzone(market_id) {

                var isVisible = $( "#mzonesAdd" ).is( ":visible" );

		var isHidden = $( "#mzonesAdd" ).is( ":hidden" );
		if( isVisible == false ) {
			$( "#add_zone_button" ).trigger( "click" );
		}       
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('marketzone/getMarketZoneData')?>",          
                  data: {
                           "market_id":market_id},
          dataType: "html",                     
          success: function(data) {
                var zoneinfo = jQuery.parseJSON(data);
		$('#desc').val(zoneinfo['description']);
		$('#airline_id').val(zoneinfo['airline_id']);
		$('#airline_id').trigger('change');
		$('#market_name').val(zoneinfo['market_name']);

		$('#amz_level_id').val(zoneinfo['amz_level_id']);
		$('#amz_level_id').trigger('change');
		var level = zoneinfo['amz_level_name'].split(',');
        	$('#amz_level_value').val(level).trigger('change');
	
		if(zoneinfo['amz_incl_id'] != 0 ){	
			$('#amz_incl_id').val(zoneinfo['amz_incl_id']);
			$('#amz_incl_id').trigger('change');
		}
		if( zoneinfo['amz_incl_name'] != null ) {
			var incl = zoneinfo['amz_incl_name'].split(',');
                	$('#amz_incl_value').val(incl).trigger('change');
		}
 
		if (zoneinfo['amz_excl_id'] != 0 ){  
			$('#amz_excl_id').val(zoneinfo['amz_excl_id']);
                	$('#amz_excl_id').trigger('change');
		}

		if( zoneinfo['amz_excl_name'] != null ) {
		var excl = zoneinfo['amz_excl_name'].split(',');
                $('#amz_excl_value').val(zoneinfo['amz_excl_name']).trigger('change');
		}
		
		var mktid  = zoneinfo['market_id'];
		$('#market_id').val(mktid);




	//	var info = JSON.stringify(zoneinfo);

          }
          });
}

$("#checkbox_level").click(function(){
    if($("#checkbox_level").is(':checked') ){
        $("#amz_level_value > option").prop("selected","selected");
        $("#amz_level_value").trigger("change");
    }else{
        $("#amz_level_value > option").removeAttr("selected");
         $("#amz_level_value").trigger("change");
     }
});
$("#checkbox_incl").click(function(){
    if($("#checkbox_incl").is(':checked') ){
        $("#amz_incl_value > option").prop("selected","selected");
        $("#amz_incl_value").trigger("change");
    }else{
        $("#amz_incl_value > option").removeAttr("selected");
         $("#amz_incl_value").trigger("change");
     }
});
$("#checkbox_excl").click(function(){
    if($("#checkbox_excl").is(':checked') ){
        $("#amz_excl_value > option").prop("selected","selected");
        $("#amz_excl_value").trigger("change");
    }else{
        $("#amz_excl_value > option").removeAttr("selected");
         $("#amz_excl_value").trigger("change");
     }
});
</script>

<style>
    .alert {
        border: 1px solid red !important;
	
    }
</style>
<script type="text/javascript">
function loadjstree() {

var treeinfo = [
		<?php foreach ($treedata as $data) {?>
			{'text' : '<?php echo $data->market_name?>',  
			  'state' : {
           			//	'opened' : true,
           			//	'selected' : true
         			    },
			  'children' : [
					<?php $airids = explode(',',$data->airports);
					foreach($airids as $airid) {?>
						{ 'text' : '<?php echo $airid?>', 'icon' : 'glyphicon glyphicon-pushpin' },				
					<?php }?>

					]
			},
			<?php }?>
               ];

$('#mytree').jstree({
                "core": {                    
                    'data': treeinfo
                },
                "plugins": ["search"],
                "search": {
                    "case_sensitive": false,
		    "show_only_matches": true
                }
            });


}

 $(document).ready(function () {
            $("#example").keyup(function () {
                var searchString = $(this).val();
                $('#mytree').jstree('search', searchString);
            });



$("#bulkDelete").on('click',function() { // bulk checked
        var status = this.checked;
        $(".deleteRow").each( function() {
            $(this).prop("checked",status);
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
                url: "<?php echo base_url('marketzone/delete_mz_bulk_records'); ?>",
                data: {data_ids:ids_string},
                success: function(result) {
		   $('#tztable').DataTable().ajax.reload();
                },
                async:false
            });
        }
    }); 


$('#tztable').on('click', 'input[type="checkbox"]', function() {
        $(this).not("#bulkDelete").parents("tr").toggleClass('rowselected');
    });


        });


    </script>

       
