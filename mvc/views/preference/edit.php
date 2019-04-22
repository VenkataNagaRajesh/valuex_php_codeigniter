
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("preference/index")?>"></i> <?=$this->lang->line('menu_preference')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_preference')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

                    <?php 
                        if(form_error('categoryID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="categoryID" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_category")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <?php
							 $clist[0]=$this->lang->line("preference_select_category");
						     foreach($catlist as $cat){
								 $clist[$cat->vx_aln_data_defnsID] = $cat->aln_data_value;
							 }							
						   echo form_dropdown("categoryID", $clist,set_value("categoryID",$preference->categoryID), "id='categoryID' class='form-control hide-dropdown-icon select2'"); 
						   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('categoryID'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('pref_type')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pref_type" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_type")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <?php
							 $typelist[0]=$this->lang->line("preference_select_type");
						     foreach($pref_types as $type){
								 $typelist[$type->vx_aln_data_defnsID] = $type->aln_data_value;
							 }							
						   echo form_dropdown("pref_type", $typelist,set_value("pref_type",$preference->pref_type), "id='pref_type' class='form-control hide-dropdown-icon select2'"); 
						   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('pref_type'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('pref_code')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pref_code" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_code")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="pref_code" name="pref_code" value="<?=set_value('pref_code',$preference->pref_code)?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('pref_code'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('pref_display_name')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pref_display_name" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_display_name")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="pref_display_name" name="pref_display_name" value="<?=set_value('pref_display_name',$preference->pref_display_name)?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('pref_display_name'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('pref_value')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pref_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_value")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                           <input type="text" class="form-control" id="pref_value" name="pref_value" value="<?=set_value('pref_value',$preference->pref_value)?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('pref_value'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('pref_get_value_type')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pref_get_value_type" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_get_value_type")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <?php
							 $valuetypelist[0]=$this->lang->line("preference_select_value_type");
						     foreach($valuetypes as $vtype){
								 $valuetypelist[$vtype->vx_aln_data_typeID] = $vtype->name;
							 }							
						   echo form_dropdown("pref_get_value_type", $valuetypelist,set_value("pref_get_value_type",$preference->pref_get_value_type), "id='pref_get_value_type' class='form-control hide-dropdown-icon select2'"); 
						   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('pref_get_value_type'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('pref_get_value')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pref_get_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_get_value")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <select name="pref_get_value" id="pref_get_value" class="form-control">
							   
							</select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('pref_get_value'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('active')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
					   <label for="district" class="col-sm-2 control-label">
                            <?=$this->lang->line("preference_active")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php 
							  $status = array('Disable','Enable');
							  echo form_dropdown("active", $status,set_value("active",$preference->active), "id='active' class='form-control hide-dropdown-icon'");
							?>
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('active'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                           <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_preference")?>" >
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
				 
$(document).ready(function (){
	var get_val_type = $('#pref_get_value_type').val();
	var get_val = <?=$preference->pref_get_value?>;
	
	  $.ajax({
        async: false,
        type: 'POST',
        url: "<?=base_url('preference/pref_get_value')?>",          
		data: {"type" :get_val_type,"get_value":get_val},
        dataType: "html",			
        success: function(data) {
           $('#pref_get_value').html(data);
        }  
     });   
});

$('#pref_get_value_type').change( function(e){
	var type = $(this).val();
	if(type == 0){
	  $('#pref_get_value').val(0);
	} else {
	  $.ajax({
        async: false,
        type: 'POST',
        url: "<?=base_url('preference/pref_get_value')?>",          
		data: {"type" :type},
        dataType: "html",			
        success: function(data) {
           $('#pref_get_value').html(data);
        }  
     });
   }
});

</script>