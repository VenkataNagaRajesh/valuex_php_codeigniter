 <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>
 <script>
    $(document).ready(function(){

        CKEDITOR.replace( 'email_template', {
        disallowedContent : 'img{width,height}',
        customConfig: '../ckeditor/config.js',
        uiColor: '#3592E0',
        codeSnippet_theme: 'atelier-dune.light',
		/* fullPage: true,
	    allowedContent: true */
    });
    });

</script>
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa icon-template"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("mailandsmstemplate/index")?>"><?php //echo $this->lang->line('menu_mailandsmstemplate'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_mailandsmstemplate')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">		
                <form class="form-horizontal" role="form" method="post">                 
                       <?php
                           if(form_error('email_name'))
                               echo "<div class='form-group has-error' >";
                           else
                               echo "<div class='form-group' >";
                       ?>
                           <label for="email_name" class="col-sm-1 control-label">
                               <?=$this->lang->line("mailandsmstemplate_name")?>
                           </label>
                           <div class="col-sm-4">
                               <input type="text" class="form-control" id="email_name" name="email_name" value="<?=set_value('email_name',$mailtemplate->name)?>" >
                           </div>
                           <span class="col-sm-4 control-label">
                               <?php echo form_error('email_name'); ?>
                           </span>
                       </div>					  
					
						<?php
                           if(form_error('category'))
                               echo "<div class='form-group has-error' >";
                           else
                               echo "<div class='form-group' >";
                       ?>
                           <label for="email_user" class="col-sm-1 control-label">
                               <?=$this->lang->line("mailandsmstemplate_category")?>
                           </label>
                           <div class="col-sm-4">
                               <?php                                                                   
                                  foreach ($categories as $category) {
                                    $cat[$category->catID] = $category->name;
                                  }                                                  
                                echo form_dropdown("category", $cat, set_value("category",$mailtemplate->catID), "id='category' class='form-control'");
                               ?>
                           </div>
                           <span class="col-sm-4 control-label">
                               <?php echo form_error('category'); ?>
                           </span>
                       </div>
					   
					   <?php
                           if(form_error('airlineID'))
                               echo "<div class='form-group has-error' >";
                           else
                               echo "<div class='form-group' >";
                       ?>
                           <label for="email_user" class="col-sm-1 control-label">
                               <?=$this->lang->line("mailandsmstemplate_airline")?>
                           </label>
                           <div class="col-sm-4">
                               <?php                                                                   
                                  foreach ($airlines as $airline) {
                                    $carrier[$airline->vx_aln_data_defnsID] = $airline->code;
                                  }                                                  
                                echo form_dropdown("airlineID", $carrier, set_value("airlineID",$mailtemplate->airlineID), "id='airlineID' class='form-control'");
                               ?>
                           </div>
                           <span class="col-sm-4 control-label">
                               <?php echo form_error('airlineID'); ?>
                           </span>
                       </div>
                      
					   <div class='form-group' >
						   <label for="default" class="col-sm-1 control-label">
                               <?="Set Default"?>
                            </label>
                            <div class="col-sm-1">
                              <input type="checkbox" name="default" class="form-control" id="default" style="height:19px"<?=($mailtemplate->default == 1)?"checked":''?>/>
                             </div>
                        </div>					   
						
						<div class="form-group">
							<div class="col-sm-1 control-label">
							<label>Description: </label>
							</div>
							<div class="col-sm-7 col-lg-7">
							  <?php //echo $this->ckeditor->editor("email_template","email_template"); ?>
							 <textarea  rows="5" cols="30" id="email_template" name="email_template" class="form-control"
                                           placeholder="email_template"><?= set_value('activation_content',$mailtemplate->template) ?></textarea>
                            </div>
						</div>
												
                       <div class="form-group">
                           <div class="col-sm-offset-1 col-sm-8">
                               <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_template")?>" >
                           </div>
                       </div>
                   </form>
             </div>
        </div>
     </div>
</div>

