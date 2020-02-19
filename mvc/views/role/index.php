
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_role')?></li>
        </ol>
    </div><!-- /.box-header -->
	<?php 
         $usertype = $this->session->userdata("usertype");
         if(permissionChecker('role_add')) {?>
         <h5 class="page-header">
             <a href="<?php echo base_url('role/add') ?>" data-toggle="tooltip" data-title="Add Role" data-placement="left" class="btn btn-danger">
                 <i class="fa fa-plus"></i> 
             </a>
         </h5>
     <?php } ?>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-2"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-4"><?=$this->lang->line('role_role')?></th>
                                <th class="col-lg-4"><?=$this->lang->line('role_usertype')?></th>
                                <?php if(permissionChecker('role_edit') || permissionChecker('role_delete')) { ?>
                                <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($roles)) {$i = 1; foreach($roles as $role) {                                 
								?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                      
                                    </td>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $role->usertype; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('role_role')?>">
                                        <?php echo $role->role; ?>
                                    </td>
                                    <?php if(permissionChecker('role_edit') || permissionChecker('role_delete')) { ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
                                        <?php
                                            $reletionarray = array(1,2,3,4,5,6);                                           
                                            if(!in_array($role->roleID, $reletionarray)) {
                                                echo btn_edit('role/edit/'.$role->roleID, $this->lang->line('edit'));
                                                echo btn_delete('role/delete/'.$role->roleID, $this->lang->line('delete'));
                                            }
                                        ?>
                                    </td>                                    
                                </tr>
								   <?php $i++; } }} ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
