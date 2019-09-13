<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> Airline Preferences</h3>        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_preference')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal pref-setting" role="form" method="post" enctype="multipart/form-data">


		       <?php
                        if(form_error('airline_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group'>";
                    ?>
                        <label for="airline_id" class="col-sm-2 control-label">
                            Select Carrier
                        </label>
                        <div class="col-sm-2">
                           <?php

                                                     foreach($airlines as $airline){
                                                                 $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;
                                                        }
                                                        $userTypeID = $this->session->userdata('usertypeID');
                                                        if($userTypeID == 2){
                                                                $default_airlineID =  key($airlinelist);
                                                                                                                } else {
                                                                $default_airlineID = 0;
                                                        }



                                                   echo form_dropdown("airline_id", $airlinelist,set_value("airline_id"), "id='airline_id' class='form-control hide-dropdown-icon select2'");
                                                   ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airline_id'); ?>
                        </span>
                    </div>


			<div id='airline_pref_values'  >

			</div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_preference")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
   $( ".select2" ).select2( { placeholder: "SELECT" } );
$(document).ready(function() { 
$('#airline_id').change(function(event) {    
  var type_id = 24;
  var airline_id = $('#airline_id').val();
$.ajax({     async: false,            
             type: 'POST',            
             url: "<?=base_url('pref_setting/getPreferencesbyType')?>",            
              data: {
                           "pref_type_id":type_id,
			   "id":airline_id,
                    },
             dataType: "html",                                  
             success: function(data) {               
				$('#airline_pref_values').html(data);
				
				
            }        
      });       
});

<?php if ( $airlineID > 0) { ?>
$('#airline_id').val('<?=$airlineID?>').trigger('change');
<?php } else {?>
   $('#airline_id').trigger('change');
<?php } ?>
});
</script>
