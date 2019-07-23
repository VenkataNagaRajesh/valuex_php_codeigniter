
<div class="box">
    <div class="box-header"  style="width:100%;">
        <h3 class="box-title"><i class="fa fa-plane"></i> <?=$this->lang->line('panel_title')?></h3>      
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline/index")?>"></i> <?=$this->lang->line('menu_airline')?></a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_airline')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                  <?php 
                        if(form_error('airline')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_name")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="airline" name="airline" value="<?=set_value('airline', $airline->aln_data_value)?>" >
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('airline'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('aircraft')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="aircraft" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_aircraft")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="aircraft" name="aircraft" value="<?=set_value('aircraft', $airline->aircraft)?>">
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('aircraft'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('seat_capacity')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="seat_capacity" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_seat_capacity")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="seat_capacity" name="seat_capacity" value="<?=set_value('seat_capacity', $airline->seat_capacity)?>">
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('seat_capacity'); ?>
                       </span>
                    </div>
					
					<?php 
                        if(form_error('code')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="code" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_code")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="code" name="code" value="<?=set_value('code', $airline->code)?>">
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('code'); ?>
                       </span>
                    </div>
					
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-danger" value="<?=$this->lang->line("update_airline")?>" >
                        </div>
                    </div>	
				</form>
            </div>
        </div>
    </div>
</div>


