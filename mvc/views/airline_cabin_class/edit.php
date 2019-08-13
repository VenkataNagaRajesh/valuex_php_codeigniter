<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_cabin_class/index")?>"><?php //echo $this->lang->line('menu_airline_cabin_class'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('edit_airline_cabin_class')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">
		<div id='key-events'>
		 <?php
                        if(form_error('carrier'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="carrier" class="col-sm-2 control-label">
                            <?=$this->lang->line("carrier")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-4">
			<input type="text" class="form-control" id="carrier_name" name="carrier_name" value="<?=set_value('carrier_name', $carrier_details->code)?>" readonly>

			 <input type="hidden" class="form-control" id="carrier" name="carrier" value="<?=set_value("carrier",$airline['carrier'])?>" >

                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('carrier'); ?>
                        </span>
                    </div>

<?php    echo "<div class='form-group' >"; ?>

                <div class="col-sm-1">
                <b style="color:orange;"><?php echo "Class";?> </b>
                </div>

                <div class="col-sm-2">
                     <b style="color:orange;"><?php echo "Cabin";?></b>
                </div>


                <div class="col-sm-3">
                        <b style="color:orange;"><?php echo "Revenue/Non-revenue";?></b>
                </div>


                <div class="col-sm-1">
                       <b style="color:orange;"> <?php echo "Order";?></b>
                </div>

		 <div class="col-sm-2">
                       <b style="color:orange;"> <?php echo "RBD Markup in %";?></b>
                </div>
</div>


		<?php  $alphas = range('A', 'Z');
			foreach ($alphas as $cl) {

			echo "<div class='form-group' >"; ?>	
		        <div class="col-sm-1">
			<?php $val = "airdata[".$cl."][class]"; ?>
                            <input type="text" class="form-control" id ="<?=$val?>"  name="<?=$val?>"  value="<?=set_value($val,$cl)?>" disabled >
                        </div>
			
			<?php $val = "airdata[".$cl."][map_id]"; ?>
			<input type="hidden" id="<?=$val?>" name="<?=$val?>" value="<?=set_value($val,$airline[$cl]['map_id'])?>">



                        <div class="col-sm-2"> <?php
				$airlinecabins['0'] = 'Select cabin';
				ksort($airlinecabins);
				$val = "airdata[".$cl."][cabin]";
				echo form_dropdown($val, $airlinecabins, set_value($val,$airline[$cl][cabin]), "id=$val   class='form-control hide-dropdown-icon select2'");
?>                        </div>



			 <div class="col-sm-3">
                            <?php
                                                          $toggle[1] = "Revenue";
                                                          $toggle[0] = "Non-Revenue";
				 $val = "airdata[".$cl."][is_revenue]";
                     echo form_dropdown($val, $toggle,set_value($val,$airline[$cl][is_revenue]), "id='$val' class='form-control hide-dropdown-icon select2'");
                                                        ?>
                        </div>



			 <div class="col-sm-1">
				<?php $val = "airdata[".$cl."][order]"; 
				?>

			    <input type="text" class="form-control"  id="order_list" name="<?=$val?>" value="<?=set_value($val,$airline[$cl][order])?>" >
                        </div>

			  <div class="col-sm-1">
                                <?php $val = "airdata[".$cl."][rbd_markup]";
                                ?>

                            <input type="text" class="form-control markup"  id="markup_list" name="<?=$val?>" value="<?=set_value($val,$airline[$cl][rbd_markup])?>" >
                        </div>

</div>
<?php } ?>

<br>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="Save" >
                        </div>
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


$(document).keypress(function (e) {
            if (e.which == 13 && e.target.tagName != 'TEXTAREA') {
              
              var txt = $(e.target);
             var allOther= $("input[type=text]:not([disabled])");
              var index = jQuery.inArray(txt[0], allOther);
             var next= $(allOther[index+1]);
              if(next) next.focus();
              debugger;
              //Need to set focus to next active text field here.
                return false;
            }
        });

});
$(document).ready(function () {
    $('input').keyup(function (e) {
        if (e.which == 39)
            $(this).closest('div').next().find('input').focus();
        else if (e.which == 37){
            $(this).closest('div').prev().find('input').focus();
		}
        else if (e.which == 40){
		var cur_e_name = $(this).attr('id');
		$(this).closest('.form-group').next().find('input[id='+cur_e_name+']').focus();
		}
        else if (e.which == 38){
		var cur_e_name = $(this).attr('id');
                $(this).closest('.form-group').prev().find('input[id='+cur_e_name+']').focus();
	}
    });
});

</script>
