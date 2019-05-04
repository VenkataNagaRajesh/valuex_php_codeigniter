<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("marketzone/index")?>"><?=$this->lang->line('menu_marketzone')?></a></li>
            <li class="active"><?=$this->lang->line('add_marketzone')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">

                    <?php
                        if(form_error('market_name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="market_name" class="col-sm-2 control-label">
                            <?=$this->lang->line("market_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="market_name" name="market_name" value="<?=set_value('market_name')?>" >
                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('market_name'); ?>
                        </span>
                    </div>

			<?php
                        if(form_error('desc'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="desc" class="col-sm-2 control-label">
                            <?=$this->lang->line("desc")?> 
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="desc" name="desc" value="<?=set_value('market_name')?>" >
                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('desc'); ?>
                        </span>
                    </div>



	                 <?php
                        if(form_error('airline_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="airline_id" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_code")?>
                        </label>
                        <div class="col-sm-6">
                           <?php
                                                         $airlinelist[0]= 'Select Airline For marketzone';
                                                     foreach($airlines as $airline){
                                                                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->airline_name;
                                                         }
                                                   echo form_dropdown("airline_id", $airlinelist,set_value("airline_id"), "id='airline_id' class='form-control hide-dropdown-icon select2'");
                                                   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airlineID'); ?>
                        </span>
                    </div>



		
                     <?php 
			$aln_datatypes['0'] = "SELECT TYPE";
                        ksort($aln_datatypes);
                      ?>
		 <?php
                        if(form_error('amz_level_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="amz_level_id" class="col-sm-2 control-label">
                            <?=$this->lang->line("level_type")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                        <?php
                        echo form_dropdown("amz_level_id", $aln_datatypes, set_value("amz_level_id"), "id='amz_level_id' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('amz_level_id'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('amz_level_value'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="amz_level_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("amz_level_value")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
				 <select  name="amz_level_value[]"  id="amz_level_value" class="form-control select2" multiple="multiple">
				</select> 
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('amz_level_value[]'); ?>
                        </span>
			<span> <input type="checkbox" id="checkbox_level" >Select All
			</span>
                    </div>

                    <?php
                        if(form_error('amz_incl_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="amz_incl_id" class="col-sm-2 control-label">
                            <?=$this->lang->line("amz_incl_type")?> 
                        </label>
                        <div class="col-sm-6">
			<?php
			echo form_dropdown("amz_incl_id", $aln_datatypes, set_value("amz_incl_id"), "id='amz_incl_id' class='form-control select2'");
			?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('amz_incl_id'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('amz_incl_value'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="amz_incl_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("amz_incl_value");?> 
                        </label>
                        <div class="col-sm-6">
			  <select  name="amz_incl_value[]"  id="amz_incl_value" class="form-control select2" multiple="multiple">
                                </select>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('amz_incl_value[]'); ?>
                        </span>
			<span> <input type="checkbox" id="checkbox_incl" >Select All</span>
                    </div>

                    <?php
                        if(form_error('amz_excl_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="amz_excl_id" class="col-sm-2 control-label">
                            <?=$this->lang->line("amz_excl_type");?> 
                        </label>
                        <div class="col-sm-6">
			
			<?php
 echo form_dropdown("amz_excl_id", $aln_datatypes, set_value("amz_excl_id"), "id='amz_excl_id' class='form-control select2'");
                        ?>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('amz_excl_id'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('amz_excl_value'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="amz_excl_value" class="col-sm-2 control-label">
                            <?=$this->lang->line("amz_excl_value");?> 
                        </label>
                        <div class="col-sm-6">
			 <select  name="amz_excl_value[]"  id="amz_excl_value" class="form-control select2" multiple="multiple">
                                </select>

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('amz_excl_value[]'); ?>
                        </span>
			<span> <input type="checkbox" id="checkbox_excl" >Select All</span>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_marketzone")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$('#amz_incl_id').trigger('change');
$('#amz_excl_id').trigger('change');
$('#amz_level_id').trigger('change');
});

$( ".select2" ).select2({closeOnSelect:false
		         });

$("#checkbox_level").click(function(){
    if($("#checkbox_level").is(':checked') ){
        $("#amz_level_value > option").prop("selected","selected");
        $("#amz_level_value").trigger("change");
    }else{
        $("#amz_level_value > option").removeAttr("selected");
         $("#amz_level_value").trigger("change");
     }
});


$("#checkbox_incl").click(function(){
    if($("#checkbox_incl").is(':checked') ){
        $("#amz_incl_value > option").prop("selected","selected");
        $("#amz_incl_value").trigger("change");
    }else{
        $("#amz_incl_value > option").removeAttr("selected");
         $("#amz_incl_value").trigger("change");
     }
});




$("#checkbox_excl").click(function(){
    if($("#checkbox_excl").is(':checked') ){
        $("#amz_excl_value > option").prop("selected","selected");
        $("#amz_excl_value").trigger("change");
    }else{
        $("#amz_excl_value > option").removeAttr("selected");
         $("#amz_excl_value").trigger("change");
     }
});




$('#amz_level_id').change(function(event) {    
	$('#amz_level_value').val(null).trigger('change')
  var level_id = $(this).val();                 
$.ajax({     async: false,            
	     type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + level_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#amz_level_value').html(data); }        
      });       
});

$('#amz_incl_id').change(function(event) {    
	$('#amz_incl_value').val(null).trigger('change');
  var incl_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + incl_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#amz_incl_value').html(data); }        
      });       
});



$('#amz_excl_id').change(function(event) {    
	$('#amz_excl_value').val(null).trigger('change')
  var excl_id = $(this).val();                 
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('marketzone/getSubdataTypes')?>",            
             data: "id=" + excl_id,            
             dataType: "html",                                  
             success: function(data) {               
             $('#amz_excl_value').html(data); }        
      });       
});



</script>
