
<div class="box">
    <div class="box-header"  style="width:100%">
        <h3 class="box-title"><i class="fa <?=$icon?>"></i> <?=$this->lang->line('panel_title')?></h3>      
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline/index")?>"></i> <?php //echo $this->lang->line('menu_airline');?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_airline')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                  <?php 
                        if(form_error('airline')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airline" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_name")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="airline" name="airline" value="<?=set_value('airline', $airline->aln_data_value)?>" >
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('airline'); ?>
                        </span>
                    </div>
					
					<?php
                        if(form_error('photo'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="photo" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_logo")?> (392 * 105)
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" disabled="disabled">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                        <span class="fa fa-remove"></span>
                                        <?=$this->lang->line('airline_clear')?>
                                    </button>
                                    <div class="btn btn-success image-preview-input">
                                        <span class="fa fa-repeat"></span>
                                        <span class="image-preview-input-title">
                                        <?=$this->lang->line('airline_file_browse')?></span>
                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="photo"/>
										
                                    </div>
                                </span>								
                            </div>
                        </div>

                        <span class="col-sm-4">
                            <?php echo form_error('photo'); ?>
                        </span>
						<?php if(!empty($airline->logo)){
       							$array = array(
								"src" => base_url('uploads/images/'.$airline->logo),
								'width' => '50px',
								'height' => '35px'
								//'class' => 'img-rounded'
							   );	?>
			
		<a href="<?php echo base_url('airline/deleteAirlineLogo/'.$airline->vx_aln_data_defnsID); ?>" onclick="return confirm('you are about to delete a record. This cannot be undone. are you sure?')" class="btn btn-danger btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Delete"><?php echo img($array)?></a>
										<?php } ?>
                    </div>
					
					 <div class='form-group' >
                        <label for="airline" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_video_links")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="video_links" name="video_links" value="<?=set_value('video_links', $airline->video_links)?>" >
                        </div>                     
                    </div>
					<div class='form-group' >
                        <label for="airline" class="col-sm-2 control-label">
                            Mail template header color
                        </label>
                        <div class="col-sm-2">
                            <input type="color" class="form-control" id="mail_header_color" name="mail_header_color" value="<?=set_value('mail_header_color',$airline->mail_header_color)?>" >
                        </div>                     
                    </div>
					
					
					<?php 
                      /*   if(form_error('aircraft')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >"; */
                    ?>
                        <!--<label for="aircraft" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_aircraft")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="aircraft" name="aircraft" value="<?=set_value('aircraft', $airline->aircraft)?>">
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('aircraft'); ?>
                        </span>
                    </div>-->
					
					<?php 
                       /*  if(form_error('seat_capacity')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >"; */
                    ?>
                       <!-- <label for="seat_capacity" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_seat_capacity")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="seat_capacity" name="seat_capacity" value="<?=set_value('seat_capacity', $airline->seat_capacity)?>">
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('seat_capacity'); ?>
                       </span>
                    </div>-->
					
					<?php 
                       /*  if(form_error('code')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >"; */
                    ?>
                       <!-- <label for="code" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_code")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="code" name="code" value="<?=set_value('code', $airline->code)?>">
                        </div>                        
                       <span class="col-sm-4 control-label">
                            <?php echo form_error('code'); ?>
                       </span>
                    </div>-->
					
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-danger" value="<?=$this->lang->line("update_airline")?>" >
                        </div>
                    </div>	
				</form>
            </div>
        </div>
    </div>
</div>

<script>
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
            $(".image-preview-input-title").text("<?=$this->lang->line(airline_file_browse)?>");
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
