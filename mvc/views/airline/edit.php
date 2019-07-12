
<div class="box">
    <div class="box-header"  style="width:100%">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>      
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

<script>
$( ".select2" ).select2();

$(document).ready(function (){	
	 var countryID = $('#countryID').val();
	 var stateID = <?php echo $airport->stateID; ?>;	
	 var regionID = <?=$airport->regionID?>;
	 var areaID = <?=$airport->areaID?>;
    if(stateID === null || countryID == null) {
        $('#stateID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportStates')?>",          
		   data: {"countryID" :countryID , "stateID": stateID},
            dataType: "html",			
            success: function(data) {
               $('#stateID').html(data);
            }
        }); 		
	}
	
	if(stateID === null || regionID == null) {
        $('#regionID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportRegions')?>",          
		   data: {"regionID" :regionID , "stateID": stateID},
            dataType: "html",			
            success: function(data) {
               $('#regionID').html(data);
            }
        }); 		
	}
	
	if(regionID === null || areaID == null) {
        $('#areaID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportAreas')?>",          
		   data: {"regionID" :regionID , "areaID": areaID},
            dataType: "html",			
            success: function(data) {
               $('#areaID').html(data);
            }
        }); 		
	}
});

$('#countryID').on('change',function(event) {
   var countryID = $(this).val();
 if(countryID == null) {
        $('#stateID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportStates')?>",          
		   data: {"countryID" :countryID},
            dataType: "html",			
            success: function(data) {
               $('#stateID').html(data);
            }
        }); 		
	}
});	

$('#stateID').on('change',function(e) {
	e.preventDefault();
   var stateID = $(this).val();   
	if(stateID === null) {
        $('#regionID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportRegions')?>",          
		   data: {"stateID": stateID},
            dataType: "html",			
            success: function(data) {
               $('#regionID').html(data);
            }
        }); 		
	}
});

$('#regionID').on('change', function(event) {
   var regionID = $(this).val();
	if(regionID === null) {
        $('#areaID').val(0);
    } else { console.log(regionID);   
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportAreas')?>",          
		   data: {"regionID" :regionID},
            dataType: "html",			
            success: function(data) {
               $('#areaID').html(data);
            }
        }); 		
	}
});
</script>
