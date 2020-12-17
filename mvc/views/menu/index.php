
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-bars"></i> Menu Management</h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active">Menu Management</li>
        </ol>
    </div><!-- /.box-header -->
	<h5 class="page-header">
         <a href="<?php echo base_url('menu/add') ?>" data-toggle="tooltip" data-title="Add Menu" data-placement="left" class="btn btn-danger">
             <i class="fa fa-plus"></i>
         </a>
     </h5>
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
				<div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1">#</th>
                                <th class="col-lg-2">Menu Name</th>
                                <th class="col-lg-1">Parent ID</th>
                                <th class="col-lg-2">Menu Link</th>
                                <th class="col-lg-2">Menu Icon</th>
                                <th class="col-lg-1">Menu Pull</th>
                                <th class="col-lg-1">Priority</th>
                                <th class="col-lg-1">Status</th>
                                <th class="col-lg-2 noExport">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($menus)) {$i = 1; foreach($menus as $menu) { ?>
                                <tr>
                                    <td data-title="">
                                        <?php echo $menu->menuID; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo $menu->menuName; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo $menu->parentID; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo $menu->link; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo $menu->icon; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo $menu->pullRight; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo $menu->priority; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo $menu->status; ?>
                                    </td>
                                    <td data-title="">
                                        <?php echo btn_edit('menu/edit/'.$menu->menuID, 'Edit') ?>
                                        <?php echo btn_delete('menu/delete/'.$menu->menuID, 'Delete') ?>
                                    </td>
                                </tr>
                            <?php $i++; }} ?>
                        </tbody>
                    </table>
                </div>


            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->
