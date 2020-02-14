
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("role/index")?>"></i> <?php //echo$this->lang->line('menu_usertype');?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_role')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                    
                     <?php 
                        if(form_error('usertypeID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("role_usertype")?>
                        </label>
                        <div class="col-sm-6">
                              <?php $utarray[0] = "Select Usertype";
                               foreach($usertypes as $usertype){
                                   $utarray[$usertype->usertypeID] = $usertype->usertype;
                               }
                               echo form_dropdown("usertypeID", $utarray,
                                        set_value("usertypeID",$role->usertypeID), "id='usertypeID' class='form-control hide-dropdown-icon'"
                                ); ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('usertypeID'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error('role')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="role" class="col-sm-2 control-label">
                            <?=$this->lang->line("role_role")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="role" name="role" value="<?=set_value('role', $role->role)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('role'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_role")?>" >
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>
