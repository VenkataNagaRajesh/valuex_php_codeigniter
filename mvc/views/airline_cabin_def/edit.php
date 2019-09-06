<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_cabin_def/index")?>"><?php //echo $this->lang->line('menu_airline_cabin'); ?> Back</a></li>
            <li class="active"><?=$this->lang->line('edit_airline_cabin_def')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">


		 <?php
                        if(form_error('carrier'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="carrier" class="col-sm-2 control-label">
                            <?=$this->lang->line("carrier")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-3">
                        <input type="text" class="form-control" id="carrier_name" name="carrier_name" value="<?=set_value('carrier_name', $carrier_details->code)?>" readonly>

                         <input type="hidden" class="form-control" id="carrier" name="carrier" value="<?=set_value("carrier",$airline['carrier'])?>" >

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('carrier'); ?>
                        </span>
                    </div>



<?php    echo "<div class='form-group' >"; ?>

                <div class="col-sm-1">
                <b style="color:orange;"><?php echo "Level";?> </b>
                </div>

                <div class="col-sm-1">
                     <b style="color:orange;"><?php echo "Cabin";?></b>
                </div>


                <div class="col-sm-2">
                        <b style="color:orange;"><?php echo "Cabin Description";?></b>
                </div>



</div>
	<?php 

		$level_list = range('1','4');
		foreach($level_list as $level ) {
			echo "<div class='form-group' >"; ?>
                        <div class="col-sm-1">
                        <?php $val = "airdata[".$level."][level]"; ?>
                            <input type="text" class="form-control" id ="<?=$val?>"  name="<?=$val?>"  value="<?=set_value($val,$level)?>" disabled >
                        </div>

			 <div class="col-sm-1">
                                <?php $val = "airdata[".$level."][cabin]"; ?>

                            <input type="text" class="form-control"  name="<?=$val?>" id ="cabin_list" value="<?=set_value($val,$airline[$level][cabin])?>" >
                        </div>

                          <div class="col-sm-2">
                                <?php $val = "airdata[".$level."][desc]"; ?>

                            <input type="text" class="form-control"  name="<?=$val?>" id ='desc_list' value="<?=set_value($val,$airline[$level][desc])?>" >
                        </div>

	</div>
			
	<?php	}
	?>


		<br>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="Save" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$('#carrier').trigger('change');
$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Class'
		         });

});
</script>
