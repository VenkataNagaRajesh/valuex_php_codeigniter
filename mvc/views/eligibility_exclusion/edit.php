
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("eligibility_exclusion/index")?>"></i> <?=$this->lang->line('menu_eligibility_exclusion')?></a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_eligibility_exclusion')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                    <?php 
                        if(form_error('desc')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="desc" class="col-sm-2 control-label">
                            <?=$this->lang->line('desc')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="desc" name="desc" value="<?=set_value('desc',$e_rule->excl_reason_desc)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('desc'); ?>
                        </span>
                    </div>
					

                                        <?php
                        if(form_error('orig_market_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="orig_market_id" class="col-sm-2 control-label">
                            <?=$this->lang->line('orig_market')?>
                        </label>
                        <div class="col-sm-6">
                        <?php
			$marketzones['0'] = 'Select Market';
			ksort($marketzones);
                          echo form_dropdown("orig_market_id", $marketzones,set_value("orig_market_id",$e_rule->orig_market_id), "id='orig_market_id' class='form-control hide-dropdown-icon select2'");
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('orig_market_id'); ?>
                        </span>
                    </div>

					
					<?php 
                        if(form_error('dest_market_id')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group'>";
                    ?>
                        <label for="dest_market_id" class="col-sm-2 control-label">
                            <?=$this->lang->line('dest_market')?>
                        </label>
                        <div class="col-sm-6">
			<?php 
			  echo form_dropdown("dest_market_id", $marketzones,set_value("dest_market_id",$e_rule->dest_market_id), "id='dest_market_id' class='form-control hide-dropdown-icon select2'");  
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('dest_market_id'); ?>
                        </span>
                    </div>
					
					
                       <?php
                        if(form_error('flight_efec_date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_efec_date" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_efec_date')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="flight_efec_date" name="flight_efec_date" value="<?=set_value('flight_efec_date',date('d-m-Y',$e_rule->flight_efec_date))?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_efec_date'); ?>
                        </span>
                    </div>


					<?php 
                        if(form_error('flight_disc_date')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_disc_date" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_disc_date')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="flight_disc_date" name="flight_disc_date" value="<?=set_value('flight_disc_date',date('d-m-Y',$e_rule->flight_disc_date))?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_disc_date'); ?>
                        </span>
                    </div>
					


                              <?php
                        if(form_error('flight_nbr_start'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_nbr_start" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_nbr_start');?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="flight_nbr_start" name="flight_nbr_start" value="<?=set_value('flight_nbr_start',$e_rule->flight_nbr_start)?>" >
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
                        <label for="flight_nbr_end" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_nbr_end');?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="flight_nbr_end" name="flight_nbr_end" value="<?=set_value('flight_nbr_end',$e_rule->flight_nbr_end)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_nbr_end'); ?>
                        </span>
                    </div>


                                       <?php
                        if(form_error('flight_dep_start'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="flight_dep_start" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_dep_start');?>
                        </label>
                        <div class="col-sm-6">
				<div class="col-sm-3">
				Hrs:
                           <?php
				$st_arr = explode(':',gmdate('H:i:s', $e_rule->flight_dep_start));
                                    echo form_dropdown("flight_dep_start_hrs", $hrs,set_value("flight_dep_start_hrs",$st_arr[0]), "id='flight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
				</div>
				<div class="col-sm-3">
					Mins:
		<?php
		                                    echo form_dropdown("flight_dep_start_mins", $mins,set_value("flight_dep_start_mins",$st_arr[1]), "id='flight_dep_start_mins' class='form-control hide-dropdown-icon select2'");

		?>
				</div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_dep_start'); ?>
                        </span>
                    </div>

                                       <?php
                        if(form_error('flight_dep_end'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="flight_dep_end" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_dep_end')?>
                        </label>
                        <div class="col-sm-6">
				<div class="col-sm-3">
				Hrs:
                           <?php
			$end_arr = explode(':',gmdate('H:i:s',$e_rule->flight_dep_end));
                                     echo form_dropdown("flight_dep_end_hrs", $hrs,set_value("flight_dep_end_hrs",$end_arr[0]), "id='flight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");
                                                   ?>
				</div>

				  <div class="col-sm-3">
				Mins:
                           <?php
                                     echo form_dropdown("flight_dep_end_mins", $mins,set_value("flight_dep_end_mins",$end_arr[1]), "id='flight_dep_end_mins' class='form-control hide-dropdown-icon select2'");
                                                   ?>
                                </div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_dep_end'); ?>
                        </span>
                    </div>



		
                     <?php
                        if(form_error('frequency'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="frequency" class="col-sm-2 control-label">
                            <?=$this->lang->line('frequency');?>
                        </label>
                        <div class="col-sm-6">
<?php
			foreach($days_of_week as $day ) {
				$days[$day->vx_aln_data_defnsID] = $day->aln_data_value;
			}
		 echo form_multiselect("frequency[]", $days, set_value("frequency"), "id='frequency' class='form-control select2'");

     ?>                   </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('frequency[]'); ?>
                        </span>
                    </div>



                     <?php
                        if(form_error('upgrade_from_cabin_type'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="upgrade_from_cabin_type" class="col-sm-2 control-label">
                            <?=$this->lang->line('upgrade_from');?>
                        </label>
                        <div class="col-sm-6">

<?php
			$class_list['0'] = 'Select Class';
			foreach ($class_type as $class) {
				$class_list[$class->vx_aln_data_defnsID] = $class->aln_data_value;
			}
                         echo form_dropdown("upgrade_from_cabin_type", $class_list,set_value("upgrade_from_cabin_type",$e_rule->upgrade_from_cabin_type), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'");

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
                        <label for="upgrade_to_cabin_type" class="col-sm-2 control-label">
                            <?=$this->lang->line('upgrade_to');?>
                        </label>
                        <div class="col-sm-6">
<?php
                         echo form_dropdown("upgrade_to_cabin_type", $class_list,set_value("upgrade_to_cabin_type",$e_rule->upgrade_to_cabin_type), "id='upgrade_to_cabin_type' class='form-control hide-dropdown-icon select2'");

     ?>                   </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('upgrade_to_cabin_type'); ?>
                        </span>
                    </div>

					<?php 
                        if(form_error('future_use')) 
                            echo "<div class='form-group has-error' >";
                        else     
                           echo "<div class='form-group' >";
                    ?>
					   <label for="future_use" class="col-sm-2 control-label">
                            <?=$this->lang->line('future_use');?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php 
							  $toggle[1] = "Yes";
							  $toggle[0] = "No";
							  echo form_dropdown("future_use", $toggle,set_value("future_use",$e_rule->future_use), "id='future_use' class='form-control hide-dropdown-icon'");
							?>
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('future_use'); ?>
                        </span>
                    </div>
					

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_rule")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$( ".select2" ).select2({closeOnSelect:false,
		         placeholder: "Select Frequency"});
				
                                
$("#flight_efec_date").datepicker();
$("#flight_disc_date").datepicker();
                                

$(document).ready(function(){
 var freq = [<?php echo $e_rule->frequency;?>];
$('#frequency').val(freq).trigger('change');
});
</script>
