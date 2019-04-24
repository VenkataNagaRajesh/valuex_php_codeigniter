
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("season/index")?>"></i> <?=$this->lang->line('menu_season')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_season')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                    <?php 
                        if(form_error('season_name')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="season_name" class="col-sm-2 control-label">
                            <?=$this->lang->line("season_name")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="season_name" name="season_name" value="<?=set_value('season_name')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('season_name'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('ams_orig_levelID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group'>";
                    ?>
                        <label for="ams_orig_levelID" class="col-sm-2 control-label">
                            <?=$this->lang->line("orig_level")?>
                        </label>
                        <div class="col-sm-6">
                           <?php
							 $orglevels[0]=$this->lang->line("season_orig_level_select");
						     foreach($types as $level){
								 $orglevels[$level->vx_aln_data_typeID] = $level->name;
							 }							
						   echo form_dropdown("ams_orig_levelID", $orglevels,set_value("ams_orig_levelID"), "id='ams_orig_levelID' class='form-control hide-dropdown-icon select2'"); 
						   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('ams_orig_levelID'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('ams_orig_level_value')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group'>";
                    ?>
                        <label for="ams_orig_level_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("orig_level_value")?>
                        </label>
                        <div class="col-sm-6">
                          <select name="ams_orig_level_value[]" id="ams_orig_level_value" class="form-control select2" multiple="multiple">
						  </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('ams_orig_level_value'); ?>
                        </span>
						<span>
     						<input type="checkbox" id="orig_all" >Select All
						</span>
                    </div>
					
					<?php 
                        if(form_error('ams_dest_levelID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group'>";
                    ?>
                        <label for="ams_dest_levelID" class="col-sm-2 control-label">
                            <?=$this->lang->line("dest_level")?>
                        </label>
                        <div class="col-sm-6">
                           <?php
							 $destlevels[0]=$this->lang->line("season_dest_level_select");
						     foreach($types as $level){
								 $destlevels[$level->vx_aln_data_typeID] = $level->name;
							 }							
						   echo form_dropdown("ams_dest_levelID", $destlevels,set_value("ams_dest_levelID"), "id='ams_dest_levelID' class='form-control hide-dropdown-icon select2'"); 
						   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('ams_dest_levelID'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('ams_dest_level_value')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group'>";
                    ?>
                        <label for="ams_dest_level_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("dest_level_value")?>
                        </label>
                        <div class="col-sm-6">
                          <select name="ams_dest_level_value[]" id="ams_dest_level_value" class="form-control select2" multiple="multiple">
						  </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('ams_dest_level_value'); ?>
                        </span>
						<span>
     						<input type="checkbox" id="dest_all" >Select All
						</span>
                    </div>
					
					<?php 
                        if(form_error('ams_season_start_date')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="ams_season_start_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("season_start_date")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="ams_season_start_date" name="ams_season_start_date" value="<?=set_value('ams_season_start_date')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('ams_season_start_date'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('ams_season_end_date')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="ams_season_end_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("season_end_date")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="ams_season_end_date" name="ams_season_end_date" value="<?=set_value('ams_season_end_date')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('ams_season_end_date'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('is_return_inclusive')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
					   <label for="is_return_inclusive" class="col-sm-2 control-label">
                            <?=$this->lang->line("is_return_inclusive")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php 
							  $toggle[1] = "Yes";
							  $toggle[0] = "No";
							  echo form_dropdown("is_return_inclusive", $toggle,set_value("is_return_inclusive",1), "id='is_return_inclusive' class='form-control hide-dropdown-icon'");
							?>
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('is_return_inclusive'); ?>
                        </span>
                    </div>
					
					 <?php 
                        if(form_error('season_color')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="season_color" class="col-sm-2 control-label">
                            <?=$this->lang->line("season_color")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="season_color" name="season_color" value="<?=set_value('season_color')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('season_color'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('active')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
					   <label for="active" class="col-sm-2 control-label">
                            <?=$this->lang->line("season_active")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php 
							  $status = array('Disable','Enable');
							  echo form_dropdown("active", $status,set_value("active",1), "id='active' class='form-control hide-dropdown-icon'");
							?>
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('active'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_season")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$( ".select2" ).select2({closeOnSelect:false,
		         placeholder: "Select a value"});
				
$("#ams_season_start_date").datepicker();
$("#ams_season_end_date").datepicker();

$('#ams_orig_levelID').change(function(e){
	$('#ams_orig_level_value').val(null).trigger('change')
     var level_id = $(this).val();                 
    $.ajax({ 
             async: false,            
	         type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
                $('#ams_orig_level_value').html(data); 
			 }        
      }); 
});	
			
$('#ams_dest_levelID').change(function(e){
	$('#ams_dest_level_value').val(null).trigger('change')
     var level_id = $(this).val();                 
    $.ajax({ 
             async: false,            
	         type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
               $('#ams_dest_level_value').html(data);
			 }        
      }); 
});	

$("#orig_all").click(function(){
    if($("#orig_all").is(':checked') ){
        $("#ams_orig_level_value > option").prop("selected","selected");
        $("#ams_orig_level_value").trigger("change");
    }else{
        $("#ams_orig_level_value > option").removeAttr("selected");
         $("#ams_orig_level_value").trigger("change");
     }
});


$("#dest_all").click(function(){
    if($("#dest_all").is(':checked') ){
        $("#ams_dest_level_value > option").prop("selected","selected");
        $("#ams_dest_level_value").trigger("change");
    }else{
        $("#ams_dest_level_value > option").removeAttr("selected");
         $("#ams_dest_level_value").trigger("change");
     }
});

</script>