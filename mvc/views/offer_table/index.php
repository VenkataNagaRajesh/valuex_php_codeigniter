<div class="off-elg">
	<h2 class="title-tool-bar" style="color:#fff;float:left;width:100%;"><i class="fa icon-template"></i> Bid Details
		<ol class="breadcrumb pull-right">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_bid')?></li>
        </ol>
	</h2>
	<div class="col-md-12 off-elg-filter-box">
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">	
			<div class="form-group"><br>


                                   <div class="col-md-2 select-form">
                                         <div class="col-sm-12">
                                                <?php

                                 foreach($carriers as $airline){
                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
         }

                 $airlinelist[0]= 'Carrier';
                  ksort($airlinelist);

                                                        echo form_dropdown("carrier", $airlinelist,set_value("carrier",$car), "id='carrier' class='form-control hide-dropdown-icon select2'");     ?>
                                        </div>
                                        <div class="col-sm-12">
                                                <input type="text" class="form-control" placeholder="OfferID" id="offer_id" name="offer_id" value="<?=set_value('offer_id')?>" >
                                        </div>
                    <div class="col-sm-12">
						<?php
							$product_name['0'] = 'Product Type';
                            ksort($product_name);
							echo form_dropdown("name", $product_name,set_value("name",$name), "id='name' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
                                </div>


				<div class="col-md-2 select-form">
					<div class="col-sm-12">

	 <select  name="from_cabin"  id='from_cabin' class="form-control select2">
                                <option value=0>From Cabin</option>
                                                        </select>

						<?php /*
							$cabins['0'] = 'Select From Cabin';
							ksort($cabins);
							echo form_dropdown("from_cabin", $cabins,set_value("from_cabin",$from_cabin), "id='from_cabin' class='form-control hide-dropdown-icon select2'");  */  ?>
					</div>
					<div class="col-sm-12">

 <select  name="to_cabin"  id='to_cabin' class="form-control select2">
                                <option value=0>To Cabin</option>
                                                        </select>

						<?php

							/*
							$cabins['0'] = 'Select To cabin';
							ksort($cabins);
							echo form_dropdown("to_cabin", $cabins,set_value("to_cabin",$to_cabin), "id='to_cabin' class='form-control hide-dropdown-icon select2'");   */ ?>
					</div>
				</div>
				<div class="col-md-2 select-form">
					<div class="col-sm-12">
						<?php
							$airports['0'] = 'Select Boarding Point';
							ksort($airports);
							echo form_dropdown("boarding_point", $airports,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
					 <div class="col-sm-12">
						<?php
							$airports['0'] = 'Select Off Point';
							ksort($airports);
							echo form_dropdown("off_point", $airports,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>
					</div>
				</div>
				<div class="col-md-2 select-form">
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="Start range " id="flight_number" name="flight_number" value="<?=set_value('flight_number',$flight_number)?>" >
					</div>
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="End range " id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
					</div>
				</div>
				<div class="col-md-2">
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Dep Start Date" id="dep_from_date" name="dep_from_date" value="<?=set_value('dep_from_date',$dep_from_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Dep End Date" id="dep_to_date" name="dep_to_date" value="<?=set_value('dep_to_date',$dep_to_date)?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>

				<div class="col-md-2 select-form">
                                        <div class="col-sm-12">
                                                <input type="text" class="form-control" placeholder="PNR Ref" id="pnr_ref" name="pnr_ref" value="<?=set_value('pnr_ref')?>" >
                                        </div>
                                        <div class="col-sm-12">
<?php 
 $status['0'] = 'Offer Status';
                                                        ksort($status);
                                                        echo form_dropdown("offer_status", $status,set_value("offer_status"), "id='offer_status' class='form-control hide-dropdown-icon select2'");    ?>

                                        </div>
                                </div>


			
				 <div class="col-md-12" style="padding:0 15px;">
                                       <button type="submit" class="btn btn-danger pull-right" name="filter" id="filter" data-title="Filter" data-toggle="tooltip"><i class="fa fa-filter"></i></button>
                                       <button type="button" style="margin-right: 15px;" class="btn btn-danger pull-right" onclick="downloadBidData()" data-title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></button>

				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 off-elg-table">
		<div class="col-md-12">
			<div id="hide-table">
				 <table id="offertable" class="table table-bordered">
					 <thead>
						<tr>	
							<th class="col-lg-1">#</th>
							<th class="col-lg-1"><?=$this->lang->line('carrier')?></th>
							<th class="col-lg-1"><?=$this->lang->line('offer_id')?></th>
							<th class="col-lg-1"><?=$this->lang->line('offer_date')?></th>							
							<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
							<th class="col-lg-1"><?=$this->lang->line('flight_date')?></th>
							<th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
							<th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
							<th class="col-lg-1"><?=$this->lang->line('current_cabin')?></th>
							<th class="col-lg-1"><?=$this->lang->line('bid_cabin')?></th>
							<th class="col-lg-1"><?=$this->lang->line('bid_amount')?></th>
							 <th class="col-lg-1"><?php echo "Submit Date";?></th>
                             <th class="col-lg-1"><?=$this->lang->line('pax_details')?></th>
							<th class="col-lg-1"><?=$this->lang->line('pnr_ref')?></th>
							<th class="col-lg-1"><?=$this->lang->line('avg_p')?></th>
							<th class="col-lg-1"><?=$this->lang->line('rank')?></th>
							<th class="col-lg-1"><?=$this->lang->line('cash')?></th>
							<th class="col-lg-1"><?=$this->lang->line('miles')?></th>
                            <th class="col-lg-1"><?=$this->lang->line('product_type')?></th>
							<th class="col-lg-1"><?=$this->lang->line('offer_status')?></th>
							<th class="col-lg-1 noExport"><?=$this->lang->line('details')?></th>
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
 $(document).ready(function() {	 
	
$("#dep_from_date").datepicker();
$("#dep_to_date").datepicker();

$("#dep_from_date").datepicker();
$("#dep_to_date").datepicker();


$('#carrier').change(function(event) {    
  var carrier = $('#carrier').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#from_cabin').html(data);
                                $("#from_cabin option").html(function(i,str){
                                        return str.replace(/From Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "From Cabin")?"Cabin":"From Cabin";
                                 });
});
                                $('#to_cabin').html(data);

                                $("#to_cabin option").html(function(i,str){
                                        return str.replace(/To Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "To Cabin")?"Cabin":"To Cabin";
                                 });
                                });

                                
                                }        
      });       
});

$('#carrier').trigger('change');
$('#from_cabin').trigger('change');
$('#to_cabin').trigger('change');


$('#from_cabin').val('<?=$from_cabin?>').trigger('change');
$('#to_cabin').val('<?=$to_cabin?>').trigger('change');



$("#dep_from_date").datepicker({
    }).on('changeDate', function (ev) {
        $('#dep_to_date').val("").datepicker("update");
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#dep_to_date').datepicker('setStartDate', minDate);
         $("#dep_to_date").datepicker("setDate" , $(this).val());
    });

    $("#dep_to_date").datepicker()
        .on('changeDate', function (selected) {

                var dates = $(this).val();
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#dep_from_date').datepicker('setEndDate', maxDate);
        });



    $('#offertable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
	 "stateSave": true,
	 "initComplete": function (settings, json) {  
		$("#offertable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	  },
      "sAjaxSource": "<?php echo base_url('offer_table/server_processing'); ?>",
       "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {               
       aoData.push({"name": "flightNbr","value": $("#flight_number").val()},
		   {"name": "flightNbrEnd","value": $("#end_flight_number").val()},
                   {"name": "boardPoint","value": $("#boarding_point").val()},
                   {"name": "offPoint","value": $("#off_point").val()},
		   {"name": "depStartDate","value": $("#dep_from_date").val()},
                   {"name": "depEndDate","value": $("#dep_to_date").val()},
		   {"name": "fromCabin","value": $("#from_cabin").val()},
                   {"name": "toCabin","value": $("#to_cabin").val()},
		   {"name": "offer_id","value": $("#offer_id").val()},
                   {"name": "name","value": $("#name").val()},
		   {"name": "pnr_ref","value": $("#pnr_ref").val()},
		   {"name": "product_id","value": "<?=$product_id?>"},
		   {"name": "carrier","value": $("#carrier").val()},
		   {"name": "offer_status","value": $("#offer_status").val()},
                   {"name":"bid_from_date","value":"<?=$bid_from_date?>"},
                   {"name":"bid_to_date","value":"<?=$bid_to_date?>"},
                   {"name":"flight_from_dep_date","value":"<?=$flight_from_dep_date?>"},
                   {"name":"flight_to_dep_date","value":"<?=$flight_to_dep_date?>"},
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 


	"stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("offerdatatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("offerdatatable"));
                //if (data) data.start = 0;
                return data;
            },


      "columns": [   {"data": "sno" },
	   {"data": "carrier" },
		   {"data": "offer_id" },
		   {"data": "offer_date" },		  
		   {"data": "flight_number" },
		   {"data": "flight_date"},
		   {"data": "from_city" },
                   {"data": "to_city" },
                   {"data": "from_cabin" },
                   {"data": "to_cabin" },
                   {"data": "bid_value" },
		     {"data": "bid_submit_date" },
		   {"data": "p_list" },
                   {"data": "pnr_ref" },
		 {"data": "bid_avg" },
		{"data": "rank" },
                {"data": "cash" },
        {"data": "miles" },
        {"data": "name" },
		{"data": "offer_status" },
		{"data": "action" }

				  ],			     
	"order": [[ 1, "asc" ], [ 5, "asc" ]],
     dom: 'B<"clear">lfrtip',
     //buttons: [ 'copy', 'csv', 'excel','pdf' ]
      buttons: [
	            { extend: 'copy', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },
				{ extend: 'csv', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },
				{ extend: 'excel', exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } },
				{ extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL',exportOptions: { columns: "thead th:not(.noExport)",orthogonal: 'export' } } ,
                { text: 'Export All', exportOptions: { columns: ':visible' },
                        action: function(e, dt, node, config) {
                           $.ajax({
                                url: "<?php echo base_url('offer_table/server_processing'); ?>?page=all&&export=1",
                                type: 'get',
                                data: {sSearch: $("input[type=search]").val(),"flightNbr":$("#flight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint": $("#off_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"fromCabin": $("#from_cabin").val(),"toCabin": $("#to_cabin").val(),"offer_id": $("#offer_id").val(),"pnr_ref": $("#pnr_ref").val(),"name": $("#name").val(),"offer_status":$("#offer_status").val()},
                                dataType: 'json'
                            }).done(function(data){
							var $a = $("<a>");
							$a.attr("href",data.file);
							$("body").append($a);
							$a.attr("download","bid_data.xls");
							$a[0].click();
							$a.remove();
						  });
                        }
                 }				
            ],

 "columnDefs":  [ {"targets":12,
                         render: function ( data, type, row, meta ) {
					var str = $(data).attr("data-original-title");
					var str = str.replace(/<br>/g, ",");
                                                if(type == 'export'){
						console.log($(data).attr("data-original-title"));
                          			return $(data).text() + '(' +  str + ' ) ';
                                                } else {
                                                  return data;  
                                                }                      
                   }} ]

    });
	
	
  });
  
  function downloadBidData(){
	   $.ajax({
             url: "<?php echo base_url('offer_table/server_processing'); ?>?page=all&&export=1",
             type: 'get',
             data: {"flightNbr":$("#flight_number").val(),"flightNbrEnd":$("#end_flight_number").val(),"boardPoint":$("#boarding_point").val(),"offPoint": $("#off_point").val(),"depStartDate":$("#dep_from_date").val(),"depEndDate":$("#dep_to_date").val(),"fromCabin": $("#from_cabin").val(),"toCabin": $("#to_cabin").val(),"offer_id": $("#offer_id").val(),"pnr_ref": $("#pnr_ref").val(),"name": $("#name").val(),"offer_status":$("#offer_status").val()},
             dataType: 'json'
         }).done(function(data){
			var $a = $("<a>");
			$a.attr("href",data.file);
			$("body").append($a);
			$a.attr("download","bid_data.xls");
			$a[0].click();
			$a.remove();
			 });
  }
 
  
   $('#offertable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#offertable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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
              url: "<?=base_url('offer_eligibility/active')?>",
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

$( "select2" ).select2();

 </script>
