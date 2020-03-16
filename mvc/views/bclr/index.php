<div class="fclr-bar">
<?php  if(permissionChecker('fclr_add')) {  ?>
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:96%;border-radius: 2px;
    border:solid 1px #999;padding: 6px 5px;">Baggage Control Rule</h2>
	<p class="card-header" data-toggle="collapse" data-target="#bclrAdd"><button style="margin:1px 0;" type="button" class="btn btn-danger pull-right" data-placement="left" title="Add BCLR" data-toggle="tooltip" id='bclr_add_btn' ><i class="fa fa-plus"></i></button></p>
 <?php } ?>
	<div class="col-md-12 fclr-table-add collapse" id="bclrAdd">
		<form class="form-horizontal" action="#" id='bclr_add_form'>
			<div class="col-md-12">           
            <div class="form-group">
					<div class="col-md-2 col-sm-3">
                    <?php  $clist[0] = "Carrier";
                               foreach($myairlines as $airline){
                                   $clist[$airline->vx_aln_data_defnsID] = $airline->code;
                               }
                               echo form_dropdown("carrierID", $clist,
                                        set_value("carrierID"), "id='carrierID' class='form-control hide-dropdown-icon select2'"
                           
                               );
                    ?>
					</div>
					<div class="col-md-2 col-sm-3">
                    <?php  $alist[0] = "Partner Carrier";
                               foreach($airlines as $airline){
                                   $alist[$airline->vx_aln_data_defnsID] = $airline->code;
                               }
                               echo form_dropdown("partner_carrierID", $alist,
                                        set_value("partner_carrierID"), "id='partner_carrierID' class='form-control hide-dropdown-icon select2'"
                           
                               );
                    ?>
					</div>
					<div class="col-md-2 col-sm-3">
						<?php 
                            $allowance[1] = 'Whitelist';
                            $allowance[2] = 'Blacklist';
							echo form_dropdown("allowance", $allowance,set_value("allowance"), "id='allowance' class='form-control hide-dropdown-icon select2'");?>
					</div>
                   
					<div class="col-md-2 col-sm-3">
                        <select  name="aircraft_type"  id="aircraft_type" class="form-control select2" multiple="multiple" placeholder="Aircraft Type">
				        </select>
					</div>
					<div class="col-md-2 col-sm-3">
                       <input type="text" class="form-control" name="flight_num_range" placeholder="Flight Number Range" id="flight_num_range" value="<?=set_value('flight_num_range')?>" />
					</div>
                    <div class="col-md-2 col-sm-3">
                        <input type="text" class="form-control" name="frequency" id="frequency" value="<?=set_value('frequency')?>" />                       
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-3">
                         <?php                         
                          $originlist[0] = "Origin Level";
                          foreach($types as $type){
                              $originlist[$type->vx_aln_data_typeID] = $type->alias;
                          }                       
                        echo form_dropdown("origin_level", $originlist, set_value("origin_level"), "id='origin_level' class='form-control select2'");
                        ?>
					</div>
					<div class="col-md-2 col-sm-3">
                        <select  name="origin_content[]"  id="origin_content" placeholder="Origin Content" class="form-control select2" multiple="multiple">
				        </select> 
                        <span> <input type="checkbox" id="origin_checkbox_level" >Select All</span>
					</div>
					<div class="col-md-2 col-sm-3">
                    <?php                         
                          $destlist[0] = "Destination Level";
                          foreach($types as $type){
                              $destlist[$type->vx_aln_data_typeID] = $type->alias;
                          }  
                        echo form_dropdown("dest_level", $destlist, set_value("dest_level"), "id='dest_level' class='form-control select2'");
                        ?>
                                       
					</div>
					<div class="col-md-2 col-sm-3">
                        <select  name="dest_content[]"  id="dest_content" placeholder="Destination Content" class="form-control select2" multiple="multiple">
				        </select>
                         <span> <input type="checkbox" id="dest_checkbox_level" >Select All</span>         
        			</div>				
					<div class="col-md-2 col-sm-3">
                        <div class="input-group">
							<input type="text" class="form-control" placeholder="Affective Date" id="affective_date" name="affective_date" value="<?=set_value('affective_date')?>">
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
                    </div>
					<div class="col-md-2 col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control hasDatepicker" placeholder="Discontinue Date"  id="discontinue_date" name="discontinue_date" value="<?=set_value('discontine_date')?>" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-3">
                     <?php                         
                          $seasonlist[0] = "Season";                           
                        echo form_dropdown("season", $seasonlist, set_value("season"), "id='season' class='form-control select2'");
                        ?>
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <select  name="from_cabin"  id="from_cabin" placeholder="From Cabin" class="form-control select2">
                        <option value="0">From Cabin</option>
				        </select>
                    </div> 
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="min_unit" id="min_unit" placeholder="Min Unit" value="<?=set_value('min_unit')?>" />                       
                    </div> 
                    <div class="col-md-2 col-sm-3">
                     <?php                         
                          $unittypes[1] = "KG";                           
                          $unittypes[2] = "Piece";                           
                        echo form_dropdown("bag_type", $unittypes, set_value("bag_type"), "id='bag_type' class='form-control select2'");
                        ?>
                    </div> 
                    <div class="col-md-2 col-sm-3">
                        <?php  $auth[0] = "Rule Auth";
                               foreach($airlines as $airline){
                                   $auth[$airline->vx_aln_data_defnsID] = $airline->code;
                               }
                               echo form_dropdown("rule_auth_carrier", $auth,set_value("rule_auth_carrier"), "id='rule_auth_carrier' class='form-control hide-dropdown-icon select2'");
                        ?>
					</div>  
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="max_capacity" id="max_capacity" placeholder="Max Capacity" value="<?=set_value('max_capacity')?>" />                       
                    </div>
                </div>        
                <div class="from-group">
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="min_price" id="min_price" placeholder="Min Price" value="<?=set_value('min_price')?>" />                       
                    </div> 
                    <div class="col-md-2 col-sm-3">
                        <input type="number" class="form-control" name="max_price" id="max_price" placeholder="Max Price" value="<?=set_value('max_price')?>" />                       
                    </div> 
                    <input type="hidden" class="form-control" id="fclr_id" name="fclr_id"   value="" >
					<div class="col-md-3 col-sm-4">
						<a href="#" type="button"  id='btn_txt' class="btn btn-danger" onclick="savebclr();">Add BCLR</a>
						<a href="#" type="button" class="btn btn-danger" onclick="form_reset()">Cancel</a>
					</div>                                   
                </div>				
			</div>
		</form>
	</div>
	<div class="col-md-12 table-responsive">
		<div class="auto-gen col-md-12" style="margin: 10px 0 20px;">
		<a href="<?php echo base_url('fclr/generatedata') ?>">
			<i class="fa fa-upload"></i>
			<?=$this->lang->line('generate_fclr')?>
		 </a>
		</div>
		<form class="form-horizontal" action="#">
			<div class="col-md-12">
				<div class="form-group">
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
						<th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
						<th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
						<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
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
						<th class="col-lg-1 noExport"><?=$this->lang->line('fclr_status')?></th>
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
    $("#effective_date").datepicker();
    $("#disconinue_date").datepicker();
    $('#origin_level').trigger('change');
    $('#dest_level').trigger('change');
    loaddatatable();
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
$("#origin_checkbox_level").click(function(){
    if($("#origin_checkbox_level").is(':checked') ){
        $("#origin_content > option").prop("selected","selected");
        $("#origin_content").trigger("change");
    } else {
        $("#origin_content > option").removeAttr("selected");
        $("#origin_content").trigger("change");
    }
});
$("#dest_checkbox_level").click(function(){
    if($("#dest_checkbox_level").is(':checked') ){
        $("#dest_content > option").prop("selected","selected");
        $("#dest_content").trigger("change");
    } else {
        $("#dest_content > option").removeAttr("selected");
        $("#dest_content").trigger("change");
    }
});
$('#partner_carrierID').change(function(event) {
	if ($('#origin_level').val() == 17 ) {
		$('#origin_level').trigger('change');
	}
	if ($('#dest_level').val() == 17 ) {
		$('#dest_level').trigger('change');
	}
});

function loaddatatable() {
    $('#fclrtable').DataTable( {
      "bProcessing": true,
	"stateSave": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo base_url('fclr/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#sflight_number").val()},
		           {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
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
		   {"data": "source_point" },
	           {"data": "dest_point" },
		   {"data": "carrier_code" },
		   {"data": "flight_number" },
		   {"data": "season_id" },
		   {"data": "start_date" },
		   {"data": "end_date" },
		   {"data": "day_of_week" },
		   {"data": "fcabin" },
		   {"data": "tcabin" },
		   {"data": "average" },
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
                { text: 'ExportAll', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('fclr/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"flightNbr":$("#sflight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#soff_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"frequency":$("#sfrequency").val(),"smarket":$("#smarket").val(),"dmarket":$("#dmarket").val(),"sfrom_cabin":$("#sfrom_cabin").val(),"sto_cabin":$("#sto_cabin").val(),"sseason_id":$("#sseason_id").val(),"sfclr_id":$("#sfclr_id").val(),"scarrier":$("#scarrier").val()},
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
       data: {"flightNbr":$("#sflight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint":$("#soff_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"frequency":$("#sfrequency").val(),"smarket":$("#smarket").val(),"dmarket":$("#dmarket").val(),"sfrom_cabin":$("#sfrom_cabin").val(),"sto_cabin":$("#sto_cabin").val(),"sseason_id":$("#sseason_id").val(),"sfclr_id":$("#sfclr_id").val(),"scarrier":$("#scarrier").val()},
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
$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Frequency'});
 </script>

<script>

function savebclr() {
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
				form_reset();
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
             }

          });
}


function editfclr(fclr_id) {

                var isVisible = $( "#bclrAdd" ).is( ":visible" );

                var isHidden = $( "#bclrAdd" ).is( ":hidden" );
                if( isVisible == false ) {
                        $( "#bclr_add_btn" ).trigger( "click" );
                }       
$.ajax({
          async: false,
          type: 'POST',
          url: "<?=base_url('fclr/getFCLRData')?>",          
                  data: {
                           "fclr_id":fclr_id},
          dataType: "html",                     
          success: function(data) {
                var fclrinfo = jQuery.parseJSON(data);
                $('#btn_txt').text('Update FCLR');
                $('#carrier_code').val(fclrinfo['carrier_code']);
                $('#carrier_code').trigger('change');
                $('#board_point').val(fclrinfo['boarding_point']);
		$('#board_point').trigger('change');

		 $('#off_point').val(fclrinfo['off_point']);
                $('#off_point').trigger('change');

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
          var $inputs = $('#bclr_add_form :input'); 
          $inputs.each(function (index)
       {
          $(this).val("");  
       });

           $("#carrierID").val(0).trigger('change');
           $("#partner_carrierID").val(0).trigger('change');
           $("#allow").val(0).trigger('change');
           $("#origin_level").val(0).trigger('change');
           $("#dest_level").val(0).trigger('change');
           $("#rule_auth").val(0).trigger('change');
           $("#aircraft_type").val(0).trigger('change');
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
