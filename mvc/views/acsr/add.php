
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("acsr/index")?>"></i> <?php //echo $this->lang->line('menu_acsr');?> Back</a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_acsr')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

					

			<?php
                        $aln_datatypes['0'] = "Origin Level";
                        ksort($aln_datatypes);
                      ?>
                 <?php
                        if(form_error('orig_level_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="orig_level_id" class="col-sm-3 control-label">
                            <?=$this->lang->line("orig_level_id")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-5">
                        <?php
                        echo form_dropdown("orig_level_id", $aln_datatypes, set_value("orig_level_id"), "id='orig_level_id' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('orig_level_id'); ?>
                        </span>
                    </div>


			
				 <?php
                        if(form_error('orig_level_value'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="orig_level_value" class="col-sm-3 control-label">
                            <?=$this->lang->line("orig_level_value")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-5">
                                 <select  name="orig_level_value[]"  id="orig_level_value" class="form-control select2" multiple="multiple">
                                </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('orig_level_value[]'); ?>
                        </span>
                        <span> <input type="checkbox" id="checkbox_src_level" >Select All
                        </span>
                    </div>



			                        <?php
                        $aln_datatypes['0'] = "Dest Level";
                        ksort($aln_datatypes);
                      ?>
                 <?php
                        if(form_error('dest_level_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="dest_level_id" class="col-sm-3 control-label">
                            <?=$this->lang->line("dest_level_id")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-5">
                        <?php
                        echo form_dropdown("dest_level_id", $aln_datatypes, set_value("dest_level_id"), "id='dest_level_id' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('dest_level_id'); ?>
                        </span>
                    </div>


			                                 <?php
                        if(form_error('dest_level_value'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="dest_level_value" class="col-sm-3 control-label">
                            <?=$this->lang->line("dest_level_value")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-5">
                                 <select  name="dest_level_value[]"  id="dest_level_value" class="form-control select2" multiple="multiple">
                                </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('dest_level_value[]'); ?>
                        </span>
                        <span> <input type="checkbox" id="checkbox_dest_level" >Select All
                        </span>
                    </div>



	               <?php
                        if(form_error('carrier_code'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="carrier_code" class="col-sm-3 control-label">
                            <?=$this->lang->line('carrier_code')?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-5">
                        <?php
                                         foreach($carriers as $airline){
                                     		$airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                                         }

			$userTypeID = $this->session->userdata('usertypeID');
                           if($userTypeID != 1){
                                   $default_airlineID =  $this->session->userdata('default_airline');
                            } else {
                               $default_airlineID = 0;
                            }



                        $airlinelist['0'] = ' Carrier';
                        ksort($airlinelist);

                          echo form_dropdown("carrier_code", $airlinelist,set_value("carrier_code",$default_airlineID), "id='carrier_code' class='form-control hide-dropdown-icon select2'");
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('carrier_code'); ?>
                        </span>
                    </div>




                              <?php
                        if(form_error('flight_nbr_start'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_nbr_start" class="col-sm-3 control-label">
                            <?=$this->lang->line('flight_nbr_start');?>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="flight_nbr_start" name="flight_nbr_start" value="<?=set_value('flight_nbr_start')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_nbr_start'); ?>
                        </span>
                    </div>


                              <?php
                        if(form_error('flight_nbr_end'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_nbr_end" class="col-sm-3 control-label">
                            <?=$this->lang->line('flight_nbr_end');?>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="flight_nbr_end" name="flight_nbr_end" value="<?=set_value('flight_nbr_end')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_nbr_end'); ?>
                        </span>
                    </div>




	
                                        <?php
                        if(form_error('flight_dep_date_start'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_dep_date_start" class="col-sm-3 control-label"> 
                            Flight Effective Date <span class="text-red">*</span>
                        </label> 
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="flight_dep_date_start" name="flight_dep_date_start" value="<?=set_value('flight_dep_date_start')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_dep_date_start'); ?>
                        </span>
                    </div>


					
					<?php 
                        if(form_error('flight_dep_date_end')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_dep_date_end" class="col-sm-3 control-label"> 
                            Flight Discontinue Date <span class="text-red">*</span>
                        </label> 
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="flight_dep_date_end" name="flight_dep_date_end" value="<?=set_value('flight_dep_date_end')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_dep_date_end'); ?>
                        </span>
                    </div>
					


                                       <?php
                        if(form_error('flight_dep_time_start'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="flight_dep_time_start" class="col-sm-3 control-label">
                            <?=$this->lang->line('flight_dep_time_start');?>
                        </label>
                        <div class="col-sm-5">
				<div class="col-sm-4">
			
                           <?php
				$hrs['-1'] = 'Hrs';
				ksort($hrs);

                                    echo form_dropdown("flight_dep_start_hrs", $hrs,set_value("flight_dep_start_hrs"), "id='flight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
				</div>
				<div class="col-sm-4">
		<?php

					$mins['-1'] = 'Mins';
						ksort($mins);
		                                    echo form_dropdown("flight_dep_start_mins", $mins,set_value("flight_dep_start_mins"), "id='flight_dep_start_mins' class='form-control hide-dropdown-icon select2'");

		?>
				</div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_dep_time_start'); ?>
                        </span>
                    </div>

                                       <?php
                        if(form_error('flight_dep_time_end'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="flight_dep_time_end" class="col-sm-3 control-label">
                            <?=$this->lang->line('flight_dep_time_end')?>
                        </label>
                        <div class="col-sm-5">
				<div class="col-sm-4">
                           <?php
                                     echo form_dropdown("flight_dep_end_hrs", $hrs,set_value("flight_dep_end_hrs"), "id='flight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");
                                                   ?>
				</div>

				  <div class="col-sm-4">
                           <?php
                                     echo form_dropdown("flight_dep_end_mins", $mins,set_value("flight_dep_end_mins"), "id='flight_dep_end_mins' class='form-control hide-dropdown-icon select2'");
                                                   ?>
                                </div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_dep_time_end'); ?>
                        </span>
                    </div>


		
                     <?php
                        if(form_error('frequency'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="frequency" class="col-sm-3 control-label">
                            <?=$this->lang->line('frequency');?>
                        </label>
                        <div class="col-sm-5">
			<input type="text" class="form-control" id="frequency" name="frequency" value="<?=set_value('frequency')?>" >
                       </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('frequency'); ?>
                        </span>
                    </div>



                     <?php
                        if(form_error('upgrade_from_cabin_type'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="upgrade_from_cabin_type" class="col-sm-3 control-label"> 
                            <?=$this->lang->line('upgrade_from');?> <span class="text-red">*</span>
                        </label> 
                        <div class="col-sm-5">
			 <select  name="upgrade_from_cabin_type"  id='upgrade_from_cabin_type' class="form-control select2">
                                <option value=0>From Cabin</option>
                                                        </select>


<?php /*
			$cabin_list['0'] = 'Select From Cabin';
			ksort($cabin_list);
			foreach ($cabin_type as $cabin) {
				$cabin_list[$cabin->vx_aln_data_defnsID] = $cabin->aln_data_value;
			}
                         echo form_dropdown("upgrade_from_cabin_type", $cabin_list,set_value("upgrade_from_cabin_type"), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'");*/

     ?>                   </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('upgrade_from_cabin_type'); ?>
                        </span>
                    </div>


                     <?php
                        if(form_error('upgrade_to_cabin_type'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="upgrade_to_cabin_type" class="col-sm-3 control-label">
                            <?=$this->lang->line('upgrade_to');?> <span class="text-red">*</span>
                        </label> 
                        <div class="col-sm-5">
			 <select  name="upgrade_to_cabin_type"  id='upgrade_to_cabin_type' class="form-control select2">
                                <option value=0>To Cabin</option>
                                                        </select>

<?php/*
			$cabin_list['0'] = 'Select To Cabin';
			ksort($cabin_list);
                         echo form_dropdown("upgrade_to_cabin_type", $cabin_list,set_value("upgrade_to_cabin_type"), "id='upgrade_to_cabin_type' class='form-control hide-dropdown-icon select2'");*/

     ?>                   </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('upgrade_to_cabin_type'); ?>
                        </span>
                    </div>



		     <?php
                        if(form_error('memp'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="memp" class="col-sm-3 control-label"> 
                            <?=$this->lang->line('memp');?> <span class="text-red">*</span>
                        </label> 
                        <div class="col-sm-5">

		  <input type="text" class="form-control" id="memp" name="memp" value="<?=set_value('memp')?>" >

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('memp'); ?>
                        </span>
                    </div>

                     <?php
                        if(form_error('min_bid_price'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="min_bid_price" class="col-sm-3 control-label"> 
                            <?=$this->lang->line('min_bid_price');?> <span class="text-red">*</span>
                        </label> 
                        <div class="col-sm-5">

                  <input type="text" class="form-control" id="min_bid_price" name="min_bid_price" value="<?=set_value('min_bid_price')?>" >

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('min_bid_price'); ?>
                        </span>
                    </div>



     <?php
                        if(form_error('action_type'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="action_type" class="col-sm-3 control-label">
                            <?=$this->lang->line('action_type');?> <span class="text-red">*</span>
                        </label> 
                        <div class="col-sm-5">
<?php

			$action_type_list['0'] = 'Select Action Type';
                        foreach ($action_types as $type) {
                                $action_type_list[$type->vx_aln_data_defnsID] = $type->aln_data_value;
                        }

                         echo form_dropdown("action_type", $action_type_list,set_value("action_type"), "id='action_type' class='form-control hide-dropdown-icon select2'");

     ?>                   </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('action_type'); ?>
                        </span>
                    </div>


		


					

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_rule")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$( ".select2" ).select2({closeOnSelect:false,
		         placeholder: "Select Level Value"});
				

$(document).ready(function(){

$('#carrier_code').change(function(event) {    
  var carrier = $('#carrier_code').val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('airline_cabin_class/getCabinDataFromCarrier')?>",            
              data: {
                           "carrier":carrier,
                    },
             dataType: "html",                                  
             success: function(data) {               
                                $('#upgrade_from_cabin_type').html(data);
                                $("#upgrade_from_cabin_type option").html(function(i,str){
                                        return str.replace(/From Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "From Cabin")?"Cabin":"From Cabin";
                                 });
});
                                $('#upgrade_to_cabin_type').html(data);

                                $("#upgrade_to_cabin_type option").html(function(i,str){
                                        return str.replace(/To Cabin|Cabin/g,
                                 function(m,n){
                                        return (m == "To Cabin")?"Cabin":"To Cabin";
                                 });
                                });

                                
                                }        
      });       
});

$('#upgrade_from_cabin_type').trigger('change');
$('#upgrade_to_cabin_type').trigger('change');
<?php
$from_cabin = $this->input->post("upgrade_from_cabin_type") ? $this->input->post("upgrade_from_cabin_type") : 0;
$to_cabin =  $this->input->post("upgrade_to_cabin_type") ? $this->input->post("upgrade_to_cabin_type") : 0;
?>
$('#upgrade_from_cabin_type').val('<?=$from_cabin?>').trigger('change');
$('#upgrade_to_cabin_type').val('<?=$to_cabin?>').trigger('change');


});

$("#checkbox_src_level").click(function(){
    if($("#checkbox_src_level").is(':checked') ){
        $("#orig_level_value > option").prop("selected","selected");
        $("#orig_level_value").trigger("change");
    }else{
        $("#orig_level_value > option").removeAttr("selected");
         $("#orig_level_value").trigger("change");
     }
});


$("#checkbox_dest_level").click(function(){
    if($("#checkbox_dest_level").is(':checked') ){
        $("#dest_level_value > option").prop("selected","selected");
        $("#dest_level_value").trigger("change");
    }else{
        $("#dest_level_value > option").removeAttr("selected");
         $("#dest_level_value").trigger("change");
     }
});



$('#orig_level_id').change(function(event) {    
        $('#orig_level_value').val(null).trigger('change')
  var orig_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + orig_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#orig_level_value').html(data); }        
      });       
});



$('#dest_level_id').change(function(event) {    
        $('#dest_level_value').val(null).trigger('change');
  var dest_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + dest_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#dest_level_value').html(data); }        
      });       
});


$("#flight_dep_date_start").datepicker();
$("#flight_dep_date_end").datepicker();


$("#flight_dep_date_start").datepicker({
    }).on('changeDate', function (ev) {
        $('#flight_dep_date_end').val("").datepicker("update");
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();
        var minDate = new Date(formatDate);
        $('#flight_dep_date_end').datepicker('setStartDate', minDate);
         $("#flight_dep_date_end").datepicker("setDate" , $(this).val());
    });

    $("#flight_dep_date_end").datepicker()
        .on('changeDate', function (selected) {

                var dates = $(this).val();
        var dates = $(this).val();
        var dates1 = dates.split("-");
        var newDate = dates1[1]+"/"+dates1[0]+"/"+dates1[2];
        var formatDate = new Date(newDate).getTime();

            var maxDate = new Date(formatDate);
            $('#flight_dep_date_start').datepicker('setEndDate', maxDate);
        });




$(document).ready(function(){
$('#orig_level_id').trigger('change');
$('#dest_level_id').trigger('change');

        var orig = [<?php echo implode(',',$this->input->post("orig_level_value")); ?>];
        $('#orig_level_value').val(orig).trigger('change');

        var dest = [<?php echo implode(',',$this->input->post("dest_level_value")); ?>];
        $('#dest_level_value').val(dest).trigger('change');

$('#carrier_code').trigger('change');

});


</script>
