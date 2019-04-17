
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
					
					<div class='form-group'>
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_country")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                           <?php
						     foreach($countrylist as $country){
								 $clist[$country->vx_aln_data_defnsID] = $country->aln_data_value;
							 }
							
						   echo form_dropdown("countryID", $clist,set_value("countryID", $airport->countryID), "id='countryID' class='form-control hide-dropdown-icon select2'"); 
						   ?>
                        </div>                        
                    </div>
					
					<div class='form-group'>
					   <label for="district" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_state")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <select name="stateID" id="stateID" class="form-control">
							  
							</select>
                        </div>
                    </div>
					
					<div class='form-group'>
					   <label for="district" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_region")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <select name="regionID" id="regionID" class="form-control">
							  
							</select>
                        </div>
                    </div>
					
					<div class='form-group'>
					   <label for="district" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_area")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <select name="areaID" id="areaID" class="form-control ">
							  
							</select>
                        </div>
                    </div>
					
					<div class='form-group' >
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_latitude")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="latitude" name="latitude" value="<?=set_value('latitude', $airport->lat)?>">
                        </div>                        
                    </div>
					
					<div class='form-group' >
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_longitude")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="longitude" name="longitude" value="<?=set_value('longitude', $airport->lng)?>">
                        </div>                        
                    </div>
					
					<div class='form-group'>
					   <label for="district" class="col-sm-2 control-label">
                            <?=$this->lang->line("master_area")?><span class="text-red">*</span>
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
        $('#stateID').val(0);
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

$('#countryID').change(function(event) {
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
		   data: {"regionID" :regionID , "areaID": areaID},
            dataType: "html",			
            success: function(data) {
               $('#areaID').html(data);
            }
        }); 		
	}
});
</script>
