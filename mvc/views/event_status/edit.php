<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("event_status/index")?>"><?=$this->lang->line('menu_event_status')?></a></li>
            <li class="active"><?=$this->lang->line('edit_event_status')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">

		 <?php
                        if(form_error('event_id'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="event_id" class="col-sm-2 control-label">
                            <?=$this->lang->line("event_id")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                        <?php
			$booking_status['0'] = 'Select Event Name';
			ksort($booking_status);
                        echo form_dropdown("event_id", $booking_status, set_value("event_id",$es->event_id), "id='event_id' class='form-control select2'");
                        ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('event_id'); ?>
                        </span>
                    </div>



                      <?php
                        if(form_error('current_status'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="current_status" class="col-sm-2 control-label">
                            <?=$this->lang->line("current_status")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6"> 
			<?php 
			 $booking_status['0'] = 'Select Current Status';
                        ksort($booking_status);
                        echo form_dropdown("current_status", $booking_status, set_value("current_status",$es->current_status), "id='current_status' class='form-control select2'");

			?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('current_status'); ?>
                        </span>
                    </div>


                    <?php
                        if(form_error('next_status'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="next_status" class="col-sm-2 control-label">
                            <?=$this->lang->line("next_status")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6"> <?php
				$booking_status['0'] = 'Select Next Status';
				ksort($booking_status);
				$n_status = explode(",",$es->next_status);
				echo form_multiselect("next_status[]", $booking_status, set_value("next_status",$n_status), "id='next_status' class='form-control select2'");
?>                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('next_status'); ?>
                        </span>
                    </div>
            <?php
                        if(form_error('isInternalStatus'))
                            echo "<div class='form-group has-error' >";
                        else
                           echo "<div class='form-group' >";
                    ?>
                                           <label for="isInternalStatus" class="col-sm-2 control-label">
                            <?=$this->lang->line('isInternalStatus');?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php
                                                          $toggle[1] = "Yes";
                                                          $toggle[0] = "No";
                                                          echo form_dropdown("isInternalStatus", $toggle,set_value("isInternalStatus",$es->isInternalStatus), "id='isInternalStatus' class='form-control hide-dropdown-icon'");
                                                        ?>
                        </div>
                                                <span class="col-sm-4 control-label">
                            <?php echo form_error('isInternalStatus'); ?>
                        </span>
                    </div>


		<br>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_event_status")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Next Status'
		         });

});


</script>
