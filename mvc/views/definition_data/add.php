<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("definition_data/index")?>"></i> <?=$this->lang->line('menu_defdata')?></a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_defdata')?></li>
        </ol>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
				   <?php 
                        if(form_error('aln_data_typeID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="aln_data_typeID" class="col-sm-2 control-label">
                            <?=$this->lang->line("defdata_type")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
							   $dtype[0] = 'Select Type';
						     foreach($types as $type){
								 $dtype[$type->vx_aln_data_typeID] = $type->name;
							 }							
						   echo form_dropdown("aln_data_typeID", $dtype,set_value("aln_data_typeID"), "id='aln_data_typeID' class='form-control hide-dropdown-icon select2'"); 
						   ?>							
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('aln_data_typeID'); ?>
                        </span>
                    </div>
				   
                    <?php 
                        if(form_error('aln_data_value')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="aln_data_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("defdata_value")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="aln_data_value" name="aln_data_value" value="<?=set_value('aln_data_value')?>" >							
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('aln_data_value'); ?>
                        </span>
                    </div>
					
					 <?php 
                        if(form_error('parentID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="parentID" class="col-sm-2 control-label">
                            <?=$this->lang->line("defdata_parent")?>
                        </label>
                        <div class="col-sm-6">
                            <select name="parentID" id="parentID" class="form-control select2">
                            </select>							
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('parentID'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('code')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="code" class="col-sm-2 control-label">
                            <?=$this->lang->line("defdata_code")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="code" name="code" value="<?=set_value('code')?>" >							
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('code'); ?>
                        </span>
                    </div>
					
					<?php 
                        if(form_error('active')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="aln_data_typeID" class="col-sm-2 control-label">
                            <?=$this->lang->line("defdata_active")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
							   $active[0] = 'Disable';
							   $active[1] = 'Enable';						    						
						   echo form_dropdown("active", $active,set_value("active",1), "id='active' class='form-control hide-dropdown-icon select2'"); 
						   ?>							
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('active'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                           <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_defdata")?>" >
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
				 
$('#aln_data_typeID').change( function(e){
	var type = $(this).val();
	if(type != 0) {    
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getParentlist')?>",          
		   data: {"type": type},
            dataType: "html",			
            success: function(data) {
               $('#parentID').html(data);
            }
        }); 		
	}
});
</script>
