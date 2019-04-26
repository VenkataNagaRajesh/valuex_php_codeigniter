<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_cabin/index")?>"><?=$this->lang->line('menu_airline_cabin')?></a></li>
            <li class="active"><?=$this->lang->line('add_airline_cabin')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">

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
                            <input type="text" class="form-control" id="name" name="name" value="<?=set_value('name')?>" >
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
                        echo form_dropdown("airline_code", $airlinesdata, set_value("airline_code"), "id='airline_code' class='form-control select2'");
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
                            <?=$this->lang->line("airline_class")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6"> <?php
				$airlineclass['0'] = 'Select Class';
				echo form_dropdown("airline_class", $airlineclass, set_value("airline_class"), "id='airline_class' class='form-control select2'");
?>                        </div>
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
                            <?=$this->lang->line("airline_cabin")?>  <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
			<?php
			
				$alphas = range('A', 'Z');
				ksort($alphas);

				echo form_multiselect("airline_cabin[]", $alphas, set_value("airline_cabin"), "id='airline_cabin' class='form-control select2'");
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
                            <?=$this->lang->line("airline_video")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="video" name="video" value="<?=set_value('video')?>" >
                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('video'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_airline_cabin")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

$( ".select2" ).select2({closeOnSelect:false, placeholder:'Select Cabin'
		         });
});

$(document).on('click', '#close-preview', function(){
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
           $('.content').css('padding-bottom', '100px');
        },
         function () {
           $('.image-preview').popover('hide');
           $('.content').css('padding-bottom', '20px');
        }
    );
});



$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("<?=$this->lang->line('airline_file_browse')?>");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function (){
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200,
            overflow:'hidden'
        });
                          
       var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("<?=$this->lang->line('airline_file_browse')?>");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
            $('.content').css('padding-bottom', '100px');
        }
        reader.readAsDataURL(file);
    });
});



</script>
