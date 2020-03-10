
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa icon-user"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("partner/index")?>"></i> <?php //echo$this->lang->line('menu_usertype');?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_partner')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">           
                <form class="form-horizontal" partner="form" method="post">
                    <?php 
                        if(form_error('partner_carrierID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("partner_carrier")?>
                        </label>
                        <div class="col-sm-6">
                            <?php  $alist[0] = "Select Carrier";
                            foreach($airlines as $airline){
                                $alist[$airline->vx_aln_data_defnsID] = $airline->code;
                            }
                            echo form_dropdown("partner_carrierID", $alist,
                                        set_value("partner_carrierID",$partner->partner_carrierID), "id='partner_carrierID' class='form-control hide-dropdown-icon select2'"
                                    );
                                ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('partner_carrierID'); ?>
                        </span>
                    </div>

                    <?php 
                        $aln_datatypes['0'] = "SELECT LEVEL";
                        ksort($aln_datatypes);
                    ?>
                    <?php
                        if(form_error('origin_level'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="origin_level" class="col-sm-2 control-label">
                            <?=$this->lang->line("partner_origin_level")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                        <?php
                        echo form_dropdown("origin_level", $aln_datatypes, set_value("origin_level",$partner->origin_level), "id='origin_level' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('origin_level'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('origin_content[]'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="origin_content" class="col-sm-2 control-label">
                            <?=$this->lang->line("partner_origin_content")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <select  name="origin_content[]"  id="origin_content" class="form-control select2" multiple="multiple">
                            </select> 
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('origin_content[]'); ?>
                        </span>
                        <span> <input type="checkbox" id="origin_checkbox_level" >Select All</span>
                    </div>

                    <?php
                        if(form_error('dest_level'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="dest_level" class="col-sm-2 control-label">
                            <?=$this->lang->line("partner_destination_level")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                        <?php
                        echo form_dropdown("dest_level", $aln_datatypes, set_value("dest_level",$partner->dest_level), "id='dest_level' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('dest_level'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('dest_content[]'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="dest_content" class="col-sm-2 control-label">
                            <?=$this->lang->line("partner_destination_content")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <select  name="dest_content[]"  id="dest_content" class="form-control select2" multiple="multiple">
                            </select> 
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('dest_content[]'); ?>
                        </span>
                        <span> <input type="checkbox" id="dest_checkbox_level" >Select All</span>
                    </div>

                    <?php
                        if(form_error('start_date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="start_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("partner_start_date")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group" style="margin-bottom: 0">
                                <input type="text" class="form-control hasDatepicker"  id="start_date" name="start_date" value="<?=set_value('start_date',date('d-m-y',$partner->start_date))?>" >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('start_date'); ?>
                        </span>                        
                    </div> 

                    <?php
                        if(form_error('end_date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="end_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("partner_end_date")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group" style="margin-bottom: 0">
                                <input type="text" class="form-control hasDatepicker"  id="end_date" name="end_date" value="<?=set_value('end_date',date('d-m-Y',$partner->end_date))?>" >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('end_date'); ?>
                        </span>                        
                    </div> 

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_partner")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$('.select2').select2();
$('#start_date').datepicker();
$('#end_date').datepicker();
$(document).ready(function(){
    $('#origin_level').trigger('change');
    var origin_content = [<?php echo $partner->origin_content ?>];
    $('#origin_content').val(origin_content).trigger('change');
    $('#dest_level').trigger('change');
    var dest_content = [<?php echo $partner->dest_content ?>];
    $('#dest_content').val(dest_content).trigger('change');
});
$('#origin_level').change(function(event) {    
	$('#origin_content').val(null).trigger('change')
    var level_id = $(this).val();                   
    var airline_id = $('#partner_carrierID').val();  
	if( level_id == '17' ) {
		if($('#partner_carrierID').val() == '0') {
			alert('select Airline');
			$("#origin_level").val(0);
            $('#origin_level').trigger('change');
			return false;
		}
	}               
    $.ajax({     async: false,            
	    type: 'POST',            
        url: "<?=base_url('marketzone/getSubdataTypes')?>",            
        data: {"id":level_id,"airline_id":airline_id},           
        dataType: "html",                                  
        success: function(data) {               
        $('#origin_content').html(data); }        
    });       
});
$('#dest_level').change(function(event) {    
	$('#dest_content').val(null).trigger('change')
    var level_id = $(this).val(); 
    var airline_id = $('#partner_carrierID').val();  
	if( level_id == '17' ) {
		if($('#partner_carrierID').val() == '0') {
			alert('select Airline');
			$("#dest_level").val(0);
            $('#dest_level').trigger('change');
			return false;
		}
	}                               
    $.ajax({     async: false,            
	    type: 'POST',            
        url: "<?=base_url('marketzone/getSubdataTypes')?>",            
        data: {"id":level_id,"airline_id":airline_id},           
        dataType: "html",                                  
        success: function(data) {               
        $('#dest_content').html(data); }        
    });       
});
$("#origin_checkbox_level").click(function(){
    if($("#origin_checkbox_level").is(':checked') ){
        $("#origin_content > option").prop("selected","selected");
        $("#origin_content").trigger("change");
    } else {
        $("#origin_content > option").removeAttr("selected");
        $("#origin_content").trigger("change");
    }
});
$("#dest_checkbox_level").click(function(){
    if($("#dest_checkbox_level").is(':checked') ){
        $("#dest_content > option").prop("selected","selected");
        $("#dest_content").trigger("change");
    } else {
        $("#dest_content > option").removeAttr("selected");
        $("#dest_content").trigger("change");
    }
});
$('#partner_carrierID').change(function(event) {
	if ($('#origin_level').val() == 17 ) {
		$('#origin_level').trigger('change');
	}
	if ($('#dest_level').val() == 17 ) {
		$('#dest_level').trigger('change');
	}
});
</script>
