
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("acsr/index")?>"></i> <?=$this->lang->line('menu_acsr')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_acsr')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

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
                          echo form_dropdown("orig_market_id", $marketzones,set_value("orig_market_id"), "id='orig_market_id' class='form-control hide-dropdown-icon select2'");
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
			  echo form_dropdown("dest_market_id", $marketzones,set_value("dest_market_id"), "id='dest_market_id' class='form-control hide-dropdown-icon select2'");  
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('dest_market_id'); ?>
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
                        <label for="flight_nbr_end" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_nbr_end');?>
                        </label>
                        <div class="col-sm-6">
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
                        <label for="flight_dep_date_start" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_dep_date_start')?>
                        </label>
                        <div class="col-sm-6">
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
                        <label for="flight_dep_date_end" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_dep_date_end')?>
                        </label>
                        <div class="col-sm-6">
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
                        <label for="flight_dep_time_start" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_dep_time_start');?>
                        </label>
                        <div class="col-sm-6">
				<div class="col-sm-3">
				Hrs:
                           <?php

                                    echo form_dropdown("flight_dep_start_hrs", $hrs,set_value("flight_dep_start_hrs"), "id='flight_dep_start_hrs' class='form-control hide-dropdown-icon select2'");
                                 ?>
				</div>
				<div class="col-sm-3">
					Mins:
		<?php
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
                        <label for="flight_dep_time_end" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_dep_time_end')?>
                        </label>
                        <div class="col-sm-6">
				<div class="col-sm-3">
				Hrs:
                           <?php
                                     echo form_dropdown("flight_dep_end_hrs", $hrs,set_value("flight_dep_end_hrs"), "id='flight_dep_end_hrs' class='form-control hide-dropdown-icon select2'");
                                                   ?>
				</div>

				  <div class="col-sm-3">
				Mins:
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
                        if(form_error('season'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="season" class="col-sm-2 control-label">
                            <?=$this->lang->line('season');?>
                        </label>
                        <div class="col-sm-6">
<?php
			$seasons['0'] = 'Select Season';
			ksort($seasons);
                 echo form_dropdown("season", $seasons, set_value("season"), "id='season' class='form-control select2'");

     ?>                   </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('season'); ?>
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
			$cabin_list['0'] = 'Select From Cabin';
			ksort($cabin_list);
			foreach ($cabin_type as $cabin) {
				$cabin_list[$cabin->vx_aln_data_defnsID] = $cabin->aln_data_value;
			}
                         echo form_dropdown("upgrade_from_cabin_type", $cabin_list,set_value("upgrade_from_cabin_type"), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'");

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
			$cabin_list['0'] = 'Select To Cabin';
			ksort($cabin_list);
                         echo form_dropdown("upgrade_to_cabin_type", $cabin_list,set_value("upgrade_to_cabin_type"), "id='upgrade_to_cabin_type' class='form-control hide-dropdown-icon select2'");

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
                        <label for="memp" class="col-sm-2 control-label">
                            <?=$this->lang->line('memp');?>
                        </label>
                        <div class="col-sm-6">

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
                        <label for="min_bid_price" class="col-sm-2 control-label">
                            <?=$this->lang->line('min_bid_price');?>
                        </label>
                        <div class="col-sm-6">

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
                        <label for="action_type" class="col-sm-2 control-label">
                            <?=$this->lang->line('action_type');?>
                        </label>
                        <div class="col-sm-6">
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
							  echo form_dropdown("future_use", $toggle,set_value("future_use",1), "id='future_use' class='form-control hide-dropdown-icon'");
							?>
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('future_use'); ?>
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
		         placeholder: "Select Frequency"});
				
$("#flight_dep_date_start").datepicker();
$("#flight_dep_date_end").datepicker();


</script>
