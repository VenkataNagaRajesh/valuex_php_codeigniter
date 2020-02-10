
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("client/index")?>">Back</a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_airline_client')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    <?php 
                        if(form_error('airlineID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
					   <label for="airlineID" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_airline")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
						 <!-- <select name="airlineID[]" id="airlineID" class="form-control select2" multiple="multiple"> -->
                            <?php 
                              $airlines[0]=$this->lang->line("client_select_airline");
							  foreach($airlinelist as $airline){
								  $airlines[$airline->vx_aln_data_defnsID] = $airline->code;
								 // echo '<option value="'.$airline->vx_aln_data_defnsID.'">'.$airline->code.'</option>';
							  } 
							      echo form_dropdown("airlineID", $airlines,set_value("airlineID",$client->airlineID), "id='airlineID' class='form-control hide-dropdown-icon select2'");
							?>
							<!-- </select> -->
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('airlineID'); ?>
                        </span>
                    </div>
					
                    <?php
                        if(form_error('name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="name" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" name="name" value="<?=set_value('name',$client->name)?>" >
                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('name'); ?>
                        </span>
                    </div>
                    <?php
                        if(form_error('domain'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="domain" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_domain")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="domain" name="domain" value="<?=set_value('domain',$client->domain)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('domain'); ?>
                        </span>
                    </div>
                    <?php
                        if(form_error('email'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="email" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_email")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email" value="<?=set_value('email',$client->email)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('email'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('phone'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="phone" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_phone")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone',$client->phone)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('phone'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('address'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="address" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_address")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="address" name="address" value="<?=set_value('address',$client->address)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('address'); ?>
                        </span>
                    </div>

                   <?php
                        if(form_error('photo'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="photo" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_photo")?>
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" disabled="disabled">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                        <span class="fa fa-remove"></span>
                                        <?=$this->lang->line('client_clear')?>
                                    </button>
                                    <div class="btn btn-success image-preview-input">
                                        <span class="fa fa-repeat"></span>
                                        <span class="image-preview-input-title">
                                        <?=$this->lang->line('client_file_browse')?></span>
                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="photo"/>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <span class="col-sm-4">
                            <?php echo form_error('photo'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('roleID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                       <label for="role" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_role")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                             <?php 
                                    $rarray[0] = 'Select Role';

                                    if(count($roles)) {
                                        foreach ($roles as $key => $role) {                                           
                                            $rarray[$role->roleID] = $role->role;                                          
                                        }
                                    }
                                    echo form_dropdown("roleID", $rarray,
                                        set_value("roleID",$client->roleID), "id='roleID' class='form-control hide-dropdown-icon'"
                                    );
                            ?>
                        </div>
                        <span class="col-sm-4">
                            <?php echo form_error('roleID'); ?>
                        </span>
                    </div>		

                    <?php
                        if(form_error('username'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="username" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_username")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username" name="username" value="<?=set_value('username',$client->username)?>" >
                        </div>
                         <span class="col-sm-4 control-label">
                            <?php echo form_error('username'); ?>
                        </span>
                    </div>

                   <?php 
                        if(form_error('active')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
					   <label for="active" class="col-sm-2 control-label">
                            <?=$this->lang->line("client_active")?><span class="text-red">*</span>
                       </label>
                        <div class="col-sm-6">
                            <?php 
							  $status = array('Disable','Enable');
							  echo form_dropdown("active", $status,set_value("active",$client->active), "id='active' class='form-control hide-dropdown-icon select2'");
							?>
                        </div>
						<span class="col-sm-4 control-label">
                            <?php echo form_error('active'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_client")?>" >
                        </div>
                    </div>

                </form>		   
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$( ".select2" ).select2({closeOnSelect:false,
		         placeholder: "Select airline"});
				 
$(document).ready(function(){
	//var airlines = [<?=$client->airlineIDs?>];
	//$('#airlineID').val(airlines).trigger('change');  				 
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
        $(".image-preview-input-title").text("<?=$this->lang->line('client_file_browse')?>");
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
            $(".image-preview-input-title").text("<?=$this->lang->line('client_file_browse')?>");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
            $('.content').css('padding-bottom', '100px');
        }
        reader.readAsDataURL(file);
    });
});

$(document).on('click', '#close-preview', function(){
    $('.mail-logo-preview').popover('hide');
    // Hover befor close the preview
    $('.mail-logo-preview').hover(
        function () {
           $('.mail-logo-preview').popover('show');
           $('.content').css('padding-bottom', '100px');
        },
         function () {
           $('.mail-logo-preview').popover('hide');
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
    $('.mail-logo-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.mail-logo-preview-clear').click(function(){
        $('.mail-logo-preview').attr("data-content","").popover('hide');
        $('.mail-logo-preview-filename').val("");
        $('.mail-logo-preview-clear').hide();
        $('.mail-logo-preview-input input:file').val("");
        $(".mail-logo-preview-input-title").text("<?=$this->lang->line('client_upload_mail_logo')?>");
    });
	
	 // Create the preview image
    $(".mail-logo-preview-input input:file").change(function (){
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
            $(".mail-logo-preview-input-title").text("<?=$this->lang->line('client_upload_mail_logo')?>");
            $(".mail-logo-preview-clear").show();
            $(".mail-logo-preview-filename").val(file.name);
        }
        reader.readAsDataURL(file);
    });
});

</script>
