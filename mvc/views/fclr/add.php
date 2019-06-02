
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("fclr/index")?>"></i> <?=$this->lang->line('menu_fclr')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_fclr')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

                       <?php
                        if(form_error('board_point'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="board_point" class="col-sm-2 control-label">
                            <?=$this->lang->line('board_point')?>
                        </label>
                        <div class="col-sm-6">
                        <?php
			$airports['0'] = 'Select Board Point';
			ksort($airports);
                          echo form_dropdown("board_point", $airports,set_value("board_point"), "id='board_point' class='form-control hide-dropdown-icon select2'");
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('board_point'); ?>
                        </span>
                    </div>


			                          <?php
                        if(form_error('off_point'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="off_point" class="col-sm-2 control-label">
                            <?=$this->lang->line('off_point')?>
                        </label>
                        <div class="col-sm-6">
                        <?php

			$airports['0'] = 'Select Off Point';
                        ksort($airports);
                          echo form_dropdown("off_point", $airports,set_value("off_point"), "id='off_point' class='form-control hide-dropdown-icon select2'");
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('off_point'); ?>
                        </span>
                    </div>


					
					<?php 
                        if(form_error('season_id')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group'>";
                    ?>
                        <label for="season_id" class="col-sm-2 control-label">
                            <?=$this->lang->line('season')?>
                        </label>
                        <div class="col-sm-6">
			<?php 
			 $seasons[0] = 'Select Seasons';
			 ksort($seasons);
			  echo form_dropdown("season_id", $seasons,set_value("season_id"), "id='season_id' class='form-control hide-dropdown-icon select2'");  
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('season_id'); ?>
                        </span>
                    </div>
					

	
                                        <?php
                        if(form_error('departure_date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="departure_date" class="col-sm-2 control-label">
                            <?=$this->lang->line('departure_date')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="departure_date" name="departure_date" value="<?=set_value('departure_date')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('departure_date'); ?>
                        </span>
                    </div>

                                        <?php
                        if(form_error('carrier_code'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="carrier_code" class="col-sm-2 control-label">
                            <?=$this->lang->line('carrier')?>
                        </label>
                        <div class="col-sm-6">
                        <?php
                         $carrier[0] = 'Select Carrier';
                         ksort($carrier);
                          echo form_dropdown("carrier_code", $carrier,set_value("carrier_code"), "id='carrier_code' class='form-control hide-dropdown-icon select2'");
                                                   ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('carrier_code'); ?>
                        </span>
                    </div>




                              <?php
                        if(form_error('flight_number'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flight_number" class="col-sm-2 control-label">
                            <?=$this->lang->line('flight_number');?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="flight_number" name="flight_number" value="<?=set_value('flight_number')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flight_number'); ?>
                        </span>
                    </div>

		
                     <?php
                        if(form_error('frequency'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="frequency" class="col-sm-2 control-label">
                            <?=$this->lang->line('day_of_week');?>
                        </label>
                        <div class="col-sm-6">
<?php
			$days[0] = 'Select Frequency';
			ksort($days);
		 echo form_dropdown("frequency", $days, set_value("frequency"), "id='frequency' class='form-control hide-dropdown-icon select2'");

     ?>                   </div>
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
                        <label for="upgrade_from_cabin_type" class="col-sm-2 control-label">
                            <?=$this->lang->line('from_cabin');?>
                        </label>
                        <div class="col-sm-6">

<?php
			$cabins['0'] = 'Select From Cabin';
			ksort($cabins);
                         echo form_dropdown("upgrade_from_cabin_type", $cabins,set_value("upgrade_from_cabin_type"), "id='upgrade_from_cabin_type' class='form-control hide-dropdown-icon select2'");

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
                            <?=$this->lang->line('to_cabin');?>
                        </label>
                        <div class="col-sm-6">
<?php
			 $cabins['0'] = 'Select To Cabin';
			ksort($cabins);
                         echo form_dropdown("upgrade_to_cabin_type", $cabins,set_value("upgrade_to_cabin_type"), "id='upgrade_to_cabin_type' class='form-control hide-dropdown-icon select2'");

     ?>                   </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('upgrade_to_cabin_type'); ?>
                        </span>
                    </div>


		 <?php
                        if(form_error('min'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="desc" class="col-sm-2 control-label">
                            <?=$this->lang->line('min')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="min" name="min" value="<?=set_value('min')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('min'); ?>
                        </span>
                    </div>


 <?php
                        if(form_error('max'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="max" class="col-sm-2 control-label">
                            <?=$this->lang->line('max')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="max" name="max" value="<?=set_value('max')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('max'); ?>
                        </span>
                    </div>




 <?php
                        if(form_error('avg'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="avg" class="col-sm-2 control-label">
                            <?=$this->lang->line('avg')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="avg" name="avg" value="<?=set_value('avg')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('avg'); ?>
                        </span>
                    </div>




 <?php
                        if(form_error('slider_start'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="desc" class="col-sm-2 control-label">
                            <?=$this->lang->line('slider_start')?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="slider_start" name="slider_start" value="<?=set_value('slider_start')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('slider_start'); ?>
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
				

$( ".select2" ).select2();

$("#departure_date").datepicker();


</script>
