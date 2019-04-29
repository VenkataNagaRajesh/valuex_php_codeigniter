<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_cabin/index")?>"><?=$this->lang->line('menu_airline_cabin')?></a></li>
            <li class="active"><?=$this->lang->line('update_airline_cabin')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post" id='edit_airline_cabin' enctype="multipart/form-data">

		            <?php
                        if(form_error('name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="name" class="col-sm-2 control-label">
                            <?=$this->lang->line("name")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" name="name" value="<?=set_value('name',$airline->name)?>" >
                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('name'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('airline_code'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline_code" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
			<?php
	
			 $airlinesdata['0'] = 'Select Airlines';
                        ksort($airlinesdata);
				echo form_dropdown("airline_code", $airlinesdata, set_value("airline_code",$airline->airline_code), "id='airline_code' class='form-control select2'");
			?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airline_code'); ?>
                        </span>
                    </div>


                    <?php
                        if(form_error('airline_class'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline_class" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_class")?>
                        </label>
                        <div class="col-sm-6">
				
<?php		        	$airlineclass['0'] = 'Select Class';       
			echo form_dropdown("airline_class", $airlineclass, set_value("airline_class",$airline->airline_class), "id='airline_code' class='form-control select2'");
?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airline_class'); ?>
                        </span>

                    </div>

                    <?php
                        if(form_error('airline_cabin'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline_cabin" class="col-sm-2 control-label">
				<?=$this->lang->line("airline_cabin")?>
                        </label>
                        <div class="col-sm-6">
			<?php
   $alphas = range('A', 'Z');
                                ksort($alphas);
			$cabins = explode(',',$airline->airline_cabin);
                 echo form_multiselect("airline_cabin[]", $alphas, set_value("airline_cabin[]",$cabins), "id='airline_cabin' class='form-control select2'");

			?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airline_cabin'); ?>
                        </span>
                    </div>


		                    <?php
                        if(form_error('video'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="video" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_video")?> <span class="text-red">*</span>
                        </label> <span class="btn btn-success mrg fa fa-plus" id='add_box'></span>
                                 <span class="btn btn-success mrg fa fa-minus" id='remove_box'></span>


                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="video" name="video[]" value="<?=set_value('video')?>" >
			 <div class="appending_div">
                                <div>

                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('video'); ?>
                        </span>
                    </div>
			<br>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_airline_cabin")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$( ".select2" ).select2();
 $(document).ready(function(){
  var form_data = $('#edit_airline_cabin').serialize();
  $('#edit_airline_cabin').submit(function () {
      if ( form_data == $(this).serialize() ) {
	event.preventDefault();
	window.location.replace('<?=base_url('airline_cabin/index')?>');
      }
   });
var i = 1;
  $('#add_box').on('click', function() {
	var field = '<br><div><input type="text" id="video'+i+'" class="form-control" name="video[]"> </div>';
    $('.appending_div').append(field);
        i = i+1;

  })

$('#remove_box').on('click', function() {
        $(".appending_div").children().last().remove();
        $(".appending_div").children().last().remove();
  })
var jQueryArray = <?php echo json_encode(explode(',',$airline->video_links)); ?>;
        $.each(jQueryArray, function(index, value){
		if ( index == '0' ) {
			$('#video').val(value);;
		} else {
			var field = '<br><div><input type="text" id="video'+index+'" class="form-control" name="video[]"> </div>';
    			$('.appending_div').append(field);
			$('#video'+index).val(value);
		}
        });

});

</script>
