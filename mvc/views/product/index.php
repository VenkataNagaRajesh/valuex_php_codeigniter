
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-list"></i> <?=$this->lang->line('panel_title')?></h3>

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
            <div class="col-md-12">
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-2"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-6"><?=$this->lang->line('product_name')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('product_status')?></th>
                                <?php if(permissionChecker('product_edit') || permissionChecker('product_delete')) { ?>
                                <th class="col-lg-2 noExport"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($products as $product) { ?>
                                  
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php //echo $product->productID; ?>
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('product_name')?>">
                                        <?php echo $product->name; ?>
                                    </td>
                                    <?php if(permissionChecker('product_edit')) { ?>
                                    <td data-title="<?=$this->lang->line('product_status')?>">
                                      <div class="onoffswitch-small" id="<?=$product->productID?>">
                                          <input type="checkbox" id="myonoffswitch<?=$product->productID?>" class="onoffswitch-small-checkbox" name="paypal_demo"  <?php if($product->active === '1') echo "checked='false'"; ?>>
                                          <label for="myonoffswitch<?=$product->productID?>" class="onoffswitch-small-label">
                                              <span class="onoffswitch-small-inner"></span>
                                              <span class="onoffswitch-small-switch"></span>
                                          </label>
                                      </div>           
                                    </td>
                                    <?php } ?>
                                    <?php if(permissionChecker('product_edit') || permissionChecker('product_delete')) { ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
                                        <?php                                          
                                            echo btn_edit('product/edit/'.$product->productID, $this->lang->line('edit'));
                                            echo btn_delete('product/delete/'.$product->productID, $this->lang->line('delete'));                                           
                                        ?>
                                    </td>
                                    <?php } ?>
                                </tr>
							<?php $i++; } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
  var status = '';
  var id = 0;
  $('.onoffswitch-small-checkbox').click(function() {
      
      if($(this).prop('checked')) {
          status = 'chacked';
          id = $(this).parent().attr("id");
      } else {
          status = 'unchacked';
          id = $(this).parent().attr("id");
      }
      if((status != '' || status != null) && (id !='')) {
          $.ajax({
              type: 'POST',
              url: "<?=base_url('product/active')?>",
              data: "id=" + id + "&status=" + status,
              dataType: "html",
              success: function(data) {
                  if(data == 'Success') {
                      toastr["success"]("Success")
                      toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "500",
                        "hideDuration": "500",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                  } else {
                      //toastr["error"]("Error")
                      toastr["error"](data)
                      toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "500",
                        "hideDuration": "500",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                  }
              }
          });
      }
  }); 
</script>