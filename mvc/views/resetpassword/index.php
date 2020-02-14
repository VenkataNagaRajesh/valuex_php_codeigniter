
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa icon-reset_password"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_resetpassword')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post">
                   
                <?php 
                        if(form_error('usertype')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("resetpassword_usertype")?>
                        </label>
                        <div class="col-sm-6">
                           <?php
                                $utarray = array(
                                    0 => $this->lang->line("resetpassword_select_usertype"));
                                if(count($usertypes)) {
                                    foreach ($usertypes as $key => $usertype) {
                                        $utarray[$usertype->usertypeID] = $usertype->usertype;
                                    }
                                }
                                
                                echo form_dropdown("usertype", $utarray, set_value("usertype"), "id='usertype' class='form-control'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('usertype'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error('users')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="users" class="col-sm-2 control-label">
                            <?=$this->lang->line("resetpassword_role")?>
                        </label>
                        <div class="col-sm-6">
                           <?php
                                $array = array(
                                    0 => $this->lang->line("resetpassword_select_role"));
                                if(count($roles)) {
                                    foreach ($roles as $key => $role) {
                                        $array[$role->roleID] = $role->role;
                                    }
                                }
                                
                                echo form_dropdown("users", $array, set_value("users"), "id='users' class='form-control'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('users'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error('username')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="username" class="col-sm-2 control-label">
                            <?=$this->lang->line("resetpassword_username")?>
                        </label>
                        <div class="col-sm-6">
                            <div class="select2-wrapper">

                                <?php
                                    $array = array();
                                    $array[0] = $this->lang->line("resetpassword_select_username");
               
                                    if($usernames != "empty") {
                                        foreach ($usernames as $usernamea) {
                                            if($usernamea->roleID == 1) {
                                                $array[$usernamea->systemadminID] = $usernamea->username;
                                            } elseif($usernamea->roleID == 2) {
                                                $array[$usernamea->teacherID] = $usernamea->username;
                                            } elseif($usernamea->roleID == 3) {
                                                $array[$usernamea->studentID] = $usernamea->username;
                                            } elseif($usernamea->roleID == 4) {
                                                $array[$usernamea->parentsID] = $usernamea->username;
                                            } else {
                                                 $array[$usernamea->userID] = $usernamea->username;
                                            }
                                        }
                                    }

                                    $usrID = 0;
                                    if($username == 0) {
                                        $usrID = 0;
                                    } else {
                                        $usrID = $username;
                                    }

                                    echo form_dropdown("username", $array, set_value("username", $usrID), "id='username' class='form-control'");
                                ?>

                            </div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('username'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error('new_password')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="new_password" class="col-sm-2 control-label">
                            <?=$this->lang->line("resetpassword_new_password")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="new_password" name="new_password" >
                        </div>
                         <span class="col-sm-4 control-label">
                            <?php echo form_error('new_password'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error('re_password')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="re_password" class="col-sm-2 control-label">
                            <?=$this->lang->line("resetpassword_re_password")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="re_password" name="re_password" >
                        </div>
                         <span class="col-sm-4 control-label">
                            <?php echo form_error('re_password'); ?>
                        </span>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("resetpassword")?>" >
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('.select2').select2();
$('#users').click(function(event) {
    var users = $(this).val();
    if(users === '0') {
        $('#users').val(0);
    } else {
        $.ajax({
            type: 'POST',
            url: "<?=base_url('resetpassword/userscall')?>",
            data: {"users":users,"usertype":$("#usertype").val()},
            dataType: "html",
            success: function(data) {
               $('#username').html(data);
            }
        });
    }
});

</script>

