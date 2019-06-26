<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('panel_title')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">              
			 <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		   
			<div class='form-group'>			 


    <div class="col-sm-2">
               <?php
                        $airport['0'] = 'Select Boarding Point';
                        ksort($airport);

                                   echo form_dropdown("boarding_point", $airport,set_value("boarding_point",$boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>

                </div>





 <div class="col-sm-2">
<?php
	$airport['0'] = 'Select Off Point';
                        ksort($airport);

                                   echo form_dropdown("off_point", $airport,set_value("off_point",$off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>


</div>

<div class="col-sm-2">
               <?php
                        $cabin['0'] = 'Select From Cabin';
                        ksort($cabin);

                                   echo form_dropdown("from_cabin", $cabin,set_value("from_cabin",$from_cabin), "id='from_cabin' class='form-control hide-dropdown-icon select2'");    ?>

                </div>



<div class="col-sm-2">
               <?php
                        $cabin['0'] = 'Select To cabin';
                        ksort($cabin);

                                   echo form_dropdown("to_cabin", $cabin,set_value("to_cabin",$to_cabin), "id='to_cabin' class='form-control hide-dropdown-icon select2'");    ?>

                </div>



    <div class="col-sm-2">
<input type="text" class="form-control" placeholder="Enter Start range Flight Number" id="flight_number" name="flight_number" value="<?=set_value('flight_number',$flight_number)?>" >
                </div>
<div class="col-sm-2">
<input type="text" class="form-control" placeholder="Enter End range Flight number" id="end_flight_number" name="end_flight_number" value="<?=set_value('end_flight_number',$end_flight_number)?>" >
                </div>

 <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder="Enter Dep From date" id="dep_from_date" name="dep_from_date" value="<?=set_value('dep_from_date',$dep_from_date)?>" >
                        </div>

	
 <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder="Enter Dep To date" id="dep_to_date" name="dep_to_date" value="<?=set_value('dep_to_date',$dep_to_date)?>" >
                        </div>




                <div class="col-sm-2">
                  <button type="submit" class="form-control btn btn-primary" name="filter" id="filter">Filter</button>
                </div>	             				
			  </div>
			 </form>			
            <div id="hide-table">
               <table id="rafeedtable" class="table table-striped table-bordered table-hover dataTable no-footer">
                 <thead>
                    <tr>
			 <th class="col-lg-1">#</th>
			<th class="col-lg-1"><?=$this->lang->line('offer_id')?></th>
			<th class="col-lg-1"><?=$this->lang->line('offer_date')?></th>
			<th class="col-lg-1"><?=$this->lang->line('flight_number')?></th>
			<th class="col-lg-1"><?=$this->lang->line('flight_date')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('board_point')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('off_point')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('current_cabin')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('bid_cabin')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('bid_amount')?></th>
			<th class="col-lg-1"><?=$this->lang->line('pax_names')?></th>
			<th class="col-lg-1"><?=$this->lang->line('fqtv')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('pnr_ref')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('number_psgr')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('avg_p')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('cash')?></th>
			<th class="col-lg-1"><?=$this->lang->line('miles')?></th>
                        <th class="col-lg-1"><?=$this->lang->line('offer_status')?></th>

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
	
$("#dep_from_date").datepicker();
$("#dep_to_date").datepicker();

    $('#rafeedtable').DataTable( {
      "bProcessing": true,
      "bServerSide": true,
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
                  
                   ) //pushing custom parameters
                oSettings.jqXHR = $.ajax( {
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                         } ); }, 

      "columns": [ {"data": "cnt" },
		   {"data": "offer_id" },
		   {"data": "offer_date" },
		   {"data": "flight_number" },
		   {"data": "flight_date"},
		   {"data": "from_city" },
                   {"data": "to_city" },
                   {"data": "from_cabin" },
                   {"data": "to_cabin" },
                   {"data": "bid_value" },
		   {"data": "p_list" },
		   {"data": "fqtv" },
                   {"data": "pnr_ref" },
                {"data": "p_count" },
		 {"data": "avg_fare" },
                {"data": "cash" },
		{"data": "miles" },
		{"data": "offer_status" },

				  ],			     
     dom: 'B<"clear">lfrtip',
     buttons: [ 'copy', 'csv', 'excel','pdf' ]	  
    });
	
	
  });
 
  
   $('#rafeedtable tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
  });
  
  var status = '';
  var id = 0;
 $('#rafeedtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function () {
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

$( ".select2" ).select2();

 </script>
