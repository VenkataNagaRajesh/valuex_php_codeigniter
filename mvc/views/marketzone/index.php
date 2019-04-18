
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_marketzone')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php 
                    if(permissionChecker('user_add')) {
                ?>
                    <h5 class="page-header">
                        <a href="<?php echo base_url('marketzone/add') ?>">
                            <i class="fa fa-plus"></i> 
                            <?=$this->lang->line('add_title')?>
                        </a>
                    </h5>
                <?php } ?>

                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('market_name')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('level_type')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('amz_level_value')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('amz_incl_type')?></th>
				<th class="col-lg-1"><?=$this->lang->line('amz_incl_value')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('amz_excl_type')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('amz_excl_value')?></th>
                                <?php if(permissionChecker('marketzone_edit')) { ?>
                                <th class="col-lg-1"><?=$this->lang->line('marketzone_status')?></th>
                                <?php } ?>
                                <?php if(permissionChecker('marketzone_edit') || permissionChecker('marketzone_delete')) { ?>
                                <th class="col-lg-2"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($marketzones)) {$i = 1; foreach($marketzones as $marketzone) { ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('market_name')?>">
                                        <?php echo $marketzone->market_name; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('level_type')?>">
                                        <?php echo $this->marketzone_m->getAlndataType($marketzone->amz_level_id); ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('amz_level_value')?>">
                                        <?php echo $this->marketzone_m->getALndataTypeValues($marketzone->amz_level_name);?>
                                    </td>

				    <td data-title="<?=$this->lang->line('amz_incl_type')?>">
                                        <?php echo $this->marketzone_m->getAlndataType($marketzone->amz_incl_id); ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('amz_incl_value')?>">
                                        <?php echo $this->marketzone_m->getALndataTypeValues($marketzone->amz_incl_name);?>
                                    </td>

				    <td data-title="<?=$this->lang->line('amz_excl_type')?>">
                                        <?php echo $this->marketzone_m->getAlndataType($marketzone->amz_excl_id); ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('amz_excl_value')?>">
                                        <?php echo $this->marketzone_m->getALndataTypeValues($marketzone->amz_excl_name);?>
                                    </td>


                                    <?php if(permissionChecker('marketzone_edit')) { ?>
                                    <td data-title="<?=$this->lang->line('marketzone_status')?>">
                                      <div class="onoffswitch-small" id="<?=$marketzone->market_id?>">
                                          <input type="checkbox" id="myonoffswitch<?=$marketzone->market_id?>" class="onoffswitch-small-checkbox" name="paypal_demo" <?php if($marketzone->active === '1') echo "checked='checked'"; ?>>
                                          <label for="myonoffswitch<?=$marketzone->market_id?>" class="onoffswitch-small-label">
                                              <span class="onoffswitch-small-inner"></span>
                                              <span class="onoffswitch-small-switch"></span>
                                          </label>
                                      </div>           
                                    </td>
                                    <?php } ?>
                                    <?php if(permissionChecker('marketzone_edit') || permissionChecker('marketzone_delete')) { ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
                                        <?php echo btn_edit('marketzone/edit/'.$marketzone->market_id, $this->lang->line('edit')); ?>
                                        <?php echo btn_delete('marketzone/delete/'.$marketzone->market_id, $this->lang->line('delete')); ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php $i++; }} ?>
                        </tbody>
                    </table>
                </div>


            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

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
              url: "<?=base_url('marketzone/active')?>",
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
                      toastr["error"]("Error")
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
