<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_cabin_class/index")?>"><?php //echo $this->lang->line('menu_airline_cabin_class'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('add_airline_cabin_class')?></li>
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
                        <div class="col-sm-6">
                        <?php
			$airlinesdata['0'] = 'Select carrier';
			ksort($airlinesdata);
                        echo form_dropdown("carrier", $airlinesdata, set_value("carrier"), "id='carrier' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('carrier'); ?>
                        </span>
                    </div>
<?php	 echo "<div class='form-group' >"; ?>

		<div class="col-sm-1">
		<b style="color:orange;"><?php echo "Class";?> </b>
		</div>

		<div class="col-sm-2">
                     <b style="color:orange;"><?php echo "Cabin";?></b>
                </div>


		<div class="col-sm-2">
                        <b style="color:orange;"><?php echo "Revenue/Non-revenue";?></b>
                </div>


		<div class="col-sm-1">
                       <b style="color:orange;"> <?php echo "Order";?></b>
                </div>
</div>

		<?php  $alphas = range('A', 'Z');
			foreach ($alphas as $cl) {

			echo "<div class='form-group' >"; ?>	
		        <div class="col-sm-1">
			<?php $val = "airdata[".$cl."][class]"; ?>
                            <input type="text" class="form-control" id ="<?=$val?>"  name="<?=$val?>"  value="<?=set_value($val,$cl)?>" disabled >
                        </div>



                        <div class="col-sm-2"> <?php
				$airlinecabins['0'] = 'Select cabin';
				ksort($airlinecabins);
				$val = "airdata[".$cl."][cabin]";
				echo form_dropdown($val, $airlinecabins, set_value($val), "id=$val   class='form-control hide-dropdown-icon'");
?>                        </div>



			 <div class="col-sm-2">
                            <?php
                                                          $toggle[1] = "Revenue";
                                                          $toggle[0] = "Non-Revenue";
				 $val = "airdata[".$cl."][is_revenue]";
                     echo form_dropdown($val, $toggle,set_value($val,1), "id='$val' class='form-control hide-dropdown-icon'");
                                                        ?>
                        </div>



			 <div class="col-sm-1">
				<?php $val = "airdata[".$cl."][order]"; ?>

			    <input type="text" class="form-control"  name="<?=$val?>" id ="<?=$val?>" value="<?=set_value($val)?>" >
                        </div>
</div>
<?php } ?>

<br>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_airline_cabin_class")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Class'
		         });

});



</script>
