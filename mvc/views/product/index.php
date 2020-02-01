
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>

        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_product')?></li>
        </ol>
    </div><!-- /.box-header -->
	<?php 
         
         if(permissionChecker('product_add')) {?>
         <h5 class="page-header">
             <a href="<?php echo base_url('product/add') ?>" data-toggle="tooltip" data-title="Add Product" data-placement="left" class="btn btn-danger">
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
                                <th class="col-lg-8"><?=$this->lang->line('product_name')?></th>
                                <?php if(permissionChecker('product_edit') || permissionChecker('product_delete')) { ?>
                                <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $product) { ?>
                                  
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $product->productID; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('product_name')?>">
                                        <?php echo $product->name; ?>
                                    </td>
                                    <?php if(permissionChecker('product_edit') || permissionChecker('product_delete')) { ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
                                        <?php                                          
                                            echo btn_edit('product/edit/'.$product->productID, $this->lang->line('edit'));
                                            echo btn_delete('product/delete/'.$product->productID, $this->lang->line('delete'));                                           
                                        ?>
                                    </td>
                                    <?php } ?>
                                </tr>
							<?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
