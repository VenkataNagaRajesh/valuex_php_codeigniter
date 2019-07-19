
<div class="box">
    <div class="box-header"  style="width:100%">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline/index")?>"></i> <?=$this->lang->line('menu_airline')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_airline')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                    <?php 
                        if(form_error('airlineID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
					   <label for="airlineID" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php 
                              $airlines[0]=$this->lang->line("select_airline");					
							   foreach($airlinelist as $airline){
								  $airlines[$airline->vx_aln_data_defnsID] = $airline->airline_name;
							  } 
							  echo form_dropdown("airlineID", $airlines,set_value("airlineID",$id), "id='airlineID' class='form-control hide-dropdown-icon select2'");
							?>
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('airlineID'); ?>
                        </span>
                    </div>
					
					<div class='form-group' >
                        <label for="flights" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_aircraft")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="aircraft" name="aircraft" value="<?=set_value('aircraft')?>" readonly >
                        </div>                       
                    </div>
					
					<div class='form-group' >
                        <label for="flights" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_seat_capacity")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="seat_capacity" name="seat_capacity" value="<?=set_value('seat_capacity')?>" readonly >
                        </div>                       
                    </div>
					
                    <?php 
                        if(form_error('flights')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="flights" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_flights")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="flights" name="flights" value="<?=set_value('flights')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('flights'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-danger" value="<?=$this->lang->line("add_flights")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	 var airlineID = $('#airlineID').val();
	  if(airlineID != 0){
	   $('#airlineID').trigger('change');
	  }
});
 $('#airlineID').change( function(){
	 var airlineID = $(this).val();
	  if(airlineID == 0){
		$('#aircraft').val('');  
		$('#seat_capacity').val(''); 		
	  } else {
		  $.ajax({ 
			 async: false,            
			 type: 'POST',            
			 url: "<?=base_url('airline/getAirline')?>",            
			 data: {"airlineID": airlineID},            
			 dataType: "html",                                  
			 success: function(data) {
				info = JSON.parse(data); //console.log(info['data'].aircraft);			  			 
			   $('#aircraft').val(info['data'].aircraft);
			   $('#seat_capacity').val(info['data'].seat_capacity);
			 }
		  });
	 }
 }); 
</script>