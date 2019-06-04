
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>      
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airports_master/index")?>"></i> <?=$this->lang->line('menu_airports_master')?></a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_airport')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                   <div class='form-group' >
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_airport")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="airport" name="airport" value="<?=set_value('airport', $airport->airport)?>" readonly>
                        </div>                        
                    </div>
					
					 <?php
                        if(form_error('areaID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="areaID" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_area")?>
                        </label>
                        <div class="col-sm-6">						     
                             <?php
						     foreach($areaslist as $area){
								 $alist[$area->vx_aln_data_defnsID] = $area->aln_data_value;
							 }
							
						   echo form_dropdown("areaID", $alist,set_value("areaID", $airport->areaID), "id='areaID' class='form-control hide-dropdown-icon select2'"); 
						   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('areaID'); ?>
                        </span>
                     </div>
					 
					  <?php
                        if(form_error('regionID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="regionID" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_region")?>
                        </label>
                        <div class="col-sm-6">
						     
                             <select name="regionID" id="regionID" class="form-control">
							
							 </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('regionID'); ?>
                        </span>
                     </div>
					
					<div class='form-group'>
                        <label for="countryID" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_country")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                           <select name="countryID" id="countryID" class="form-control">
							
							 </select>
                        </div>   
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('countryID'); ?>
                        </span>						
                    </div>
					
					<?php
                        if(form_error('cityID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="cityID" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_city")?>
                        </label>
                        <div class="col-sm-6">					     
                             <select name="cityID" id="cityID" class="form-control">
							
							 </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('cityID'); ?>
                        </span>
                     </div>
					
					
					<div class='form-group'>
					   <label for="district" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_active")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php 
							  $status = array('Disable','Enable');
							  echo form_dropdown("active", $status,set_value("active", $airport->active), "id='active' class='form-control hide-dropdown-icon'");
							?>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_airport")?>" >
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
	$("#areaID").trigger("change");
	$("#regionID").trigger("change");
	$("#countryID").trigger("change");
});

  $('#countryID').on('change',function(event) {
   var countryID = $(this).val();
    var cityID = <?php echo $airport->cityID; ?>;   
   if(countryID == null) {
        $('#cityID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportCities')?>",          
		   data: {"countryID" :countryID,"cityID":cityID},
            dataType: "html",			
            success: function(data) {
               $('#cityID').html(data);
            }
        }); 		
	}
});	

$('#areaID').on('change',function(e) {
	e.preventDefault();
   var areaID = $(this).val();  
   var regionID = <?php echo $airport->regionID; ?>;   
	if(areaID === null) {
        $('#regionID').val(0);
    } else {
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportRegions')?>",          
		   data: {"areaID": areaID,"regionID":regionID},
            dataType: "html",			
            success: function(data) {
               $('#regionID').html(data);
            }
        }); 		
	}
});

$('#regionID').on('change', function(event) {
   var regionID = $(this).val();
    var countryID = <?php echo $airport->countryID; ?>;  
	if(regionID === null) {
        $('#countryID').val(0);
    } else {  
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('general/getAirportCountries')?>",          
		   data: {"regionID" :regionID,"countryID":countryID},
            dataType: "html",			
            success: function(data) {
               $('#countryID').html(data);			   
            }
        }); 		
	}
});
</script>
