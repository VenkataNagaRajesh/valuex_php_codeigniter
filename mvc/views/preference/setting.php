<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> Application Preferences</h3>        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_preference')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal pref-setting" role="form" method="post" enctype="multipart/form-data">
				   <?php foreach($preferences as $pref) { if($pref->active == 1) { ?>
                    <?php
                        if(form_error('prefvalue-'.$pref->VX_aln_preferenceID)) 
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="<?php echo 'prefvalue-'.$pref->VX_aln_preferenceID; ?>" class="col-sm-2 control-label ">
                            <?=$pref->pref_display_name?>                          
                        </label>

                        <div class="col-sm-6">
						  <?php if($pref->pref_get_value_type == 10 ) {?>
                            <input type="text" class="form-control" id="<?php echo 'prefvalue-'.$pref->VX_aln_preferenceID; ?>" name="<?php echo 'prefvalue-'.$pref->VX_aln_preferenceID; ?>" value="<?=set_value('prefvalue-'.$pref->VX_aln_preferenceID, $pref->pref_value)?>" >
						  <?php } else if($pref->pref_get_value_type == 9) {?>
						     <input type="radio" id="<?php echo 'prefvalue-'.$pref->VX_aln_preferenceID; ?>" name="<?php echo 'prefvalue-'.$pref->VX_aln_preferenceID; ?>" value="1" <?php echo ($pref->pref_value == 1)?'checked':''; ?>> TRUE
							<input type="radio" id="<?php echo 'prefvalue-'.$pref->VX_aln_preferenceID; ?>" name="<?php echo 'prefvalue-'.$pref->VX_aln_preferenceID; ?>" value="0" <?php echo ($pref->pref_value == 0)?'checked':''; ?>> FALSE
						  <?php } else { 
						     $list =$this->airports_m->getDefns($pref->pref_get_value);
							  $typelist[0] = "Select Value";
						      foreach($list as $defn){
								 $typelist[$defn->vx_aln_data_defnsID] = $defn->aln_data_value;
							 }							
						   echo form_dropdown("prefvalue-".$pref->VX_aln_preferenceID, $typelist,set_value("prefvalue-".$pref->VX_aln_preferenceID,$pref->pref_value), "id='pref_value-$pref->VX_aln_preferenceID' class='form-control hide-dropdown-icon select2'"); 
						   } ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('pref_value-'.$pref->VX_aln_preferenceID); ?>
                        </span>
                    </div> 
				   <?php } } ?>					
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
</script>
