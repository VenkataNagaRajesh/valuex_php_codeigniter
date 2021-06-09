<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?= $icon ?>"></i> <?= $this->lang->line('panel_title_baggage') ?></h3>
        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $this->lang->line('menu_rafeed') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body rafeed">
        <div class="row">
            <div class="col-md-12">
                <h5 class="page-header">
                    <?php if (permissionChecker('rafeed_upload')) { ?>
                        <a href="<?php echo base_url('rafeed/upload') ?>" class="btn btn-danger">
                            <i class="fa fa-upload"></i>
                            <?= $this->lang->line('upload_rafeed') ?>
                        </a>

                        &nbsp;&nbsp;
                        <a href="<?php echo base_url('rafeed/downloadFormat/rafeed-baggage') ?>" class="btn btn-danger">
                            <!--<i class="fa fa-upload"></i>-->
                            <?= $this->lang->line('download_rafeed_format') ?>
                        </a>
                    <?php } ?>

                </h5><br>
				<div class="nav-tabs-custom" style="display:flex;margin-bottom:0;">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    <div class='form-group'>
						
                        <div class="col-sm-2">
                            <?php


                            foreach ($airlines as $airline) {
                                $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                            }

                            $airlinelist['0'] = ' Carrier';
                            ksort($airlinelist);

                            echo form_dropdown("airline_code", $airlinelist, set_value("airline_code", $airline_code), "id='airline_code' class='form-control hide-dropdown-icon select2'");    ?>

                        </div>
                        <div class="col-sm-2">
                            <?php
                            $airport['0'] = ' Boarding Point';
                            ksort($airport);

                            echo form_dropdown("boarding_point", $airport, set_value("boarding_point", $boarding_point), "id='boarding_point' class='form-control hide-dropdown-icon select2'");    ?>

                        </div>


                        <div class="col-sm-2">
                            <?php
                            $airport['0'] = ' Off Point';
                            ksort($airport);

                            echo form_dropdown("off_point", $airport, set_value("off_point", $off_point), "id='off_point' class='form-control hide-dropdown-icon select2'");    ?>

                        </div>
                        <div class="col-sm-2">

                            <select name="class" id='class' class="form-control select2">
                                <option value=0>Cabin</option>
                            </select>

                            <?php
                            /*$cabin['0'] = ' Cabin';
                        ksort($cabin);

                                   echo form_dropdown("class", $cabin,set_value("class",$cla), "id='class' class='form-control hide-dropdown-icon select2'");   */ ?>

                        </div>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='flight range' id="flight_range" name="flight_range" value="<?= set_value('flight_range') ?>">
                        </div>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='weight' id="weight" name="weight" value="<?= set_value('weight') ?>">
                        </div>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='ssr code' id="ssr_code" name="ssr_code" value="<?= set_value('ssr_code') ?>">
                        </div>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='RFIC' id="rfic" name="rfic" value="<?= set_value('rfic') ?>">
                        </div>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='RFISC' id="rfic" name="rfisc" value="<?= set_value('rfisc') ?>">
                        </div>


                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='Start Date' id="start_date" name="start_date" value="<?= set_value('start_date') ?>">


                        </div>


                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='End Date' id="end_date" name="end_date" value="<?= set_value('end_date') ?>">


                        </div>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder='frequency' id="frequency" name="frequency" value="<?= set_value('frequency') ?>">

                        </div>
                        <div class="col-md-2">
                                    <select class="form-control select2"  name="bg_status" id="bg_status">
                                        <option value="1">Active</option>
                                        <option value="0">In active</option>
                                    </select>
                            </div>
                            		
                 
                        <div class="col-sm-12" style="text-align:right;">
                            <button type="submit" class="btn btn-danger" name="filter" id="filter" data-toggle="tooltip" data-title="Filter"><i class="fa fa-filter"></i></button>
                            <button type="button" data-toggle="tooltip" data-title="Download" class="btn btn-danger" onclick="downloadRAFeed()"><i class="fa fa-download"></i></button>
                        </div>
                    </div>
                </form>
				</div>
                <div class="col-md-12" style="padding:0;">
                    <div class="tab-content table-responsive" id="hide-table">
                    
                        <table id="rafeedtable" class="table table-bordered dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="col-lg-1"><input class="filter" title="Select All" type="checkbox" id="bulkDelete" />#</th>
									<th class="col-lg-1"><?php echo "Carrier Code"; ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('airline_code') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('coupon_number') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('weight') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('rfic') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('rfisc') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('ssr_code') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('board_point') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('off_point') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('prorated_price') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('cabin') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('class') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('fare_basis') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('departure_date') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('day_of_week') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('operating_airline_code') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('marketing_airline_code') ?></th> 
									<th class="col-lg-1"><?= $this->lang->line('flight_number') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('office_id') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('channel') ?></th>
                                    <th class="col-lg-1"><?= $this->lang->line('pax_type') ?></th>
                                    <th class="col-lg-1 noExport"><?= $this->lang->line('active') ?></th>
                                    <?php if (permissionChecker('rafeed_delete') || permissionChecker('rafeed_view')) { ?>
                                        <th class="col-lg-1 noExport" style="display:none;"><?= $this->lang->line('action') ?></th>
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
</div>
<script>
    $(document).ready(function() {
                    loaddatatable();

    $("#filter").click(function(e){
          e.preventDefault();
             $('#rafeedtable').dataTable().fnDestroy();
             loaddatatable(); 
    });
            
        $('#airline_code').change(function(event) {
            var carrier = $('#airline_code').val();
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?= base_url('airline_cabin_class/getCabinDataFromCarrier') ?>",
                data: {
                    "carrier": carrier,
                },
                dataType: "html",
                success: function(data) {
                    $('#class').html(data);
                }
            });
        });
    

        $('#airline_code').trigger('change');

        $('#class').val('<?= $cla ?>').trigger('change');
    });

function loaddatatable()
{

        $('#rafeedtable').DataTable({
            "bProcessing": true,
            "bServerSide": true,
			"initComplete": function (settings, json) {  
				$("#rafeedtable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
			},
            "sAjaxSource": "<?php echo base_url('rafeed/server_processing_baggage'); ?>",
            "fnServerData": function(sSource, aoData, fnCallback, oSettings) {
                aoData.push({
                        "name": "weight",
                        "value": $("#weight").val()
                    }, {
                        "name": "ssr_code",
                        "value": $("#ssr_code").val()
                    }, {
                        "name": "rfisc",
                        "value": $("#rfisc").val()
                    }, {
                        "name": "rfic",
                        "value": $("#rfic").val()
                    }, {
                        "name": "boardPoint",
                        "value": $("#boarding_point").val()
                    }, {
                        "name": "offPoint",
                        "value": $("#off_point").val()
                    }, {
                        "name": "Class",
                        "value": $("#class").val()
                    }, {
                        "name": "frequency",
                        "value": $("#frequency").val()
                    }, {
                        "name": "airLine",
                        "value": $("#airline_code").val()
                    }, {
                        "name": "flight_range",
                        "value": $("#flight_range").val()
                    }, {
                        "name": "start_date",
                        "value": $("#start_date").val()
                    }, {
                        "name": "end_date",
                        "value": $("#end_date").val()
                    },
                    {
                        "name":"bg_status",
                        "value":$("#bg_status").val()
                    }

                ) //pushing custom parameters
                oSettings.jqXHR = $.ajax({
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            "columns": [{
                    "data": "cbox"
                },
				{
                    "data": "carrier_code"
                },
                {
                    "data": "airline_code"
                },
                {
                    "data": "coupon_number"
                },
                {
                    "data": "weight"
                },
                {
                    "data": "rfic"
                },
                {
                    "data": "rfisc"
                },
                {
                    "data": "ssr_code"
                },
                {
                    "data": "boarding_point"
                },
                {
                    "data": "off_point"
                },
                {
                    "data": "prorated_price"
                },
                {
                    "data": "cabin"
                },
                {
                    "data": "class"
                },
                {
                    "data": "fare_basis"
                },
                {
                    "data": "departure_date"
                },
                {
                    "data": "day_of_week"
                },
                {
                    "data": "operating_airline_code"
                },
                {
                    "data": "marketing_airline_code"
                },
                {
                    "data": "flight_number"
                },
                {
                    "data": "office_id"
                },
                {
                    "data": "channel"
                },
                {
                    "data": "pax_type"
                },
                {
                    "data": "active"
                },
                /*{
                    "data": "action"
                }*/
            ],
            dom: 'B<"clear">lfrtip',
            // buttons: [ 'copy', 'csv', 'excel','pdf' ]	
            buttons: [
                {
                    text: 'Delete',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function(e, dt, node, config) {
                        if ($('.deleteRow:checked').length > 0) { // at-least one checkbox checked
                            var ids = [];
                            $('.deleteRow').each(function() {
                                if ($(this).is(':checked')) {
                                    ids.push($(this).val());
                                }
                            });
                            var ids_string = ids.toString(); // array to string conversion 
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url('rafeed/delete_rafeed_bulk_records'); ?>",
                                data: {
                                    data_ids: ids_string,
                                    table_name:'BG_ra_feed'
                                },
                                success: function(result) {
                                    $('#rafeedtable').DataTable().ajax.reload();
                                    $('#bulkDelete').prop("checked", false);
                                },
                                async: false
                            });
                        }
                    }
                },
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 7;
                        doc.styles.tableHeader.fontSize = 7;
                    },
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    text: 'Export All',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function(e, dt, node, config) {
                        $.ajax({
                            url: "<?php echo base_url('rafeed/server_processing_baggage'); ?>?page=all&&export=1",
                            type: 'get',
                            data: {
                                sSearch: $("input[type=search]").val(),
                                "bookingCountry": $("#booking_country").val(),
                                "bookingCity": $("#booking_city").val(),
                                "boardPoint": $("#boarding_point").val(),
                                "offPoint": $("#offPoint").val(),
                                "Class": $("#class").val(),
                                "frequency": $("#frequency").val(),
                                "airLine": $("#airline_code").val(),
                                "flight_range": $("#flight_range").val(),
                                "start_date": $("#start_date").val(),
                                "end_date": $("#end_date").val()
                            },
                            dataType: 'json'
                        }).done(function(data) {
                            var $a = $("<a>");
                            $a.attr("href", data.file);
                            $("body").append($a);
                            $a.attr("download", "rafeed.xls");
                            $a[0].click();
                            $a.remove();
                        });
                    }
                }
            ],

            "columnDefs": [{
                "targets": 0,
                "width": "30px"
            }]

        });


    }

    function downloadRAFeed() {
        $.ajax({
            url: "<?php echo base_url('rafeed/server_processing'); ?>?page=all&&export=1",
            type: 'get',
            data: {
                "bookingCountry": $("#booking_country").val(),
                "bookingCity": $("#booking_city").val(),
                "boardPoint": $("#boarding_point").val(),
                "offPoint": $("#offPoint").val(),
                "Class": $("#class").val(),
                "frequency": $("#frequency").val(),
                "airLine": $("#airline_code").val(),
                "flight_range": $("#flight_range").val(),
                "start_date": $("#start_date").val(),
                "end_date": $("#end_date").val()
            },
            dataType: 'json'
        }).done(function(data) {
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "rafeed.xls");
            $a[0].click();
            $a.remove();
        });
    }


    $('#rafeedtable tbody').on('mouseover', 'tr', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover',
            html: true
        });
    });

    var status = '';
    var id = 0;
    $('#rafeedtable tbody').on('click', 'tr .onoffswitch-small-checkbox', function() {
        if ($(this).prop('checked')) {
            status = 'chacked';
            id = $(this).parent().attr("id");
          //  alert(status);
        } else {
            status = 'unchacked';
            id = $(this).parent().attr("id");
          //  alert(status);
        }

        if ((status != '' || status != null) && (id != '')) {
            
            var tname="BG_ra_feed";
            //alert(status+"   "+tname);
            $.ajax({
                type: 'POST',
                url: "<?=base_url().'rafeed/active' ?>",
                data: "id=" + id + "&status=" + status + "&table=" + tname,
                dataType: "html",
                success: function(data) {

                    if (data == 'Success') {
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

    $(".select2").select2();

    $("#start_date").datepicker();
    $("#end_date").datepicker();


    $("#start_date").datepicker({}).on('changeDate', function(ev) {
        $('#end_date').val("").datepicker("update");
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1] + "/" + dates1[0] + "/" + dates1[2];
        var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#end_date').datepicker('setStartDate', minDate);
        $("#end_date").datepicker("setDate", $(this).val());
    });

    $("#end_date").datepicker()
        .on('changeDate', function(selected) {

            var dates = $(this).val();
            var dates = $(this).val();
            var dates1 = dates.split("-");
            var newDate = dates1[1] + "/" + dates1[0] + "/" + dates1[2];
            var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#start_date').datepicker('setEndDate', maxDate);
        });



    $(document).ready(function() {


        $("#bulkDelete").on('click', function() { // bulk checked
            var status = this.checked;
            $(".deleteRow").each(function() {
                if (status == 1 && $(this).prop('checked')) {

                } else {
                    if (status == false && $(this).prop('checked') == false) {

                    } else {
                        $(this).prop("checked", status);
                        $(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
                    }
                }
            });
        });


        $('#deleteTriger').on("click", function(event) { // triggering delete one by one
            if ($('.deleteRow:checked').length > 0) { // at-least one checkbox checked
                var ids = [];
                $('.deleteRow').each(function() {
                    if ($(this).is(':checked')) {
                        ids.push($(this).val());
                    }
                });
                var ids_string = ids.toString(); // array to string conversion 
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('rafeed/delete_rafeed_bulk_records'); ?>",
                    data: {
                        data_ids: ids_string
                    },
                    success: function(result) {
                        $('#rafeedtable').DataTable().ajax.reload();
                        $('#bulkDelete').prop("checked", false);
                    },
                    async: false
                });
            }
        });

        $('#rafeedtable').on('click', '.deleteRow', function() {
            $(this).not("#bulkDelete").closest('tr').toggleClass('rowselected');
        });

    });
</script>
