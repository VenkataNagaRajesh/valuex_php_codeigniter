
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_datatype')?></li>
        </ol>
    </div><!-- /.box-header -->
	 <?php 
         $usertype = $this->session->userdata("usertype");
         if(permissionChecker('usertype_add')) { ?>
         <h5 class="page-header">
             <a href="<?php echo base_url('datatype/add') ?>" data-toggle="tooltip" data-title="Add Datatype" data-placement="left" class="btn btn-danger">
                 <i class="fa fa-plus"></i> 
                 <!--<?=$this->lang->line('add_title')?>-->
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
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-4"><?=$this->lang->line('datatype_name')?></th>
								<th class="col-lg-4"><?=$this->lang->line('datatype_alias')?></th>
                                <?php if(permissionChecker('usertype_edit') || permissionChecker('usertype_delete')) { ?>
                                <th class="col-lg-2"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($datatypes)) {$i = 1; foreach($datatypes as $datatype) { ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('datatype_name')?>">
                                        <?php echo $datatype->name; ?>
                                    </td>
									<td data-title="<?=$this->lang->line('datatype_alias')?>">
                                        <?php echo $datatype->alias; ?>
                                    </td>
                                    <?php if(permissionChecker('datatype_edit') || permissionChecker('datatype_delete')) { ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
                                        <?php                                           
                                            echo btn_edit('datatype/edit/'.$datatype->vx_aln_data_typeID, $this->lang->line('edit'));                                           
                                          //  echo btn_delete('datatype/delete/'.$datatype->vx_aln_data_typeID, $this->lang->line('delete'));                                        
                                        ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php $i++; }} ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
