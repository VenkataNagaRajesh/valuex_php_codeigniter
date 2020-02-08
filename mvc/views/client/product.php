
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("client/index")?>"></i> <?php //echo$this->lang->line('menu_usertype'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_client_product')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

                    <?php 
                        if(form_error('airlineID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airlineID" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_airline")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">                          				 
                              <?php 
                                  $airlinelist[0]=$this->lang->line("select_airline");					
							      foreach($airlines as $airline){	
                                      $airlinelist[$airline->vx_aln_data_defnsID] = $airline->code;							   
                                  } 
                                  
                                 echo form_dropdown("airlineID", $airlinelist,
                                  set_value("airlineID",$airlineID), "id='airlineID' class='form-control hide-dropdown-icon'"
                                 ); 
							  ?>                           
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airlineID'); ?>
                        </span>
                    </div>

                    <?php 
                    if(form_error('contractID')) 
                        echo "<div class='form-group has-error' >";
                    else     
                        echo "<div class='form-group' >";
                    ?>
                    <label for="contractID" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_contract")?><span class="text-red">*</span>
                    </label>
                    <div class="col-sm-6">
                        <select name="contractID" id="contractID" class="form-control select2">				 
                       
                        </select>
                    </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('contractID'); ?>
                        </span>                           
                   </div>  
                  
                    <?php 
                    if(form_error('productID')) 
                        echo "<div class='form-group has-error' >";
                    else     
                        echo "<div class='form-group' >";
                    ?>
                    <label for="productID" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_product")?><span class="text-red">*</span>
                    </label>
                        <div class="col-sm-6">
                            <select name="productID" id="productID" class="form-control select2">				 
                           
                            </select>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productID'); ?>
                        </span>                           
                   </div>       

                    <!--<div class='form-group' > 
                        <label for="end_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_active")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                          <?php 
                             $array[1] = "Active";
                             $array[0] = "Inactive";
                             echo form_dropdown("active", $array,
                                  set_value("active"), "id='active' class='form-control hide-dropdown-icon'"
                                 ); 
                        ?>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("product_add")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
 $('#airlineID').select2();
 $('#contractID').select2();
 $('#productID').select2();
 $('#active').select2();

 $('#airlineID').change(function (){
    $.ajax({ async: false,            
        type: 'POST',            
        url: "<?=base_url('contract/getContractsByAirline')?>",            
        data: "airlineID=" + $(this).val(),            
        dataType: "html",                                  
        success: function(data) {               
		    $('#contractID').html(data);				 
        }        
    });  
 });

 $('#contractID').change(function (){
    $.ajax({ async: false,            
        type: 'POST',            
        url: "<?=base_url('contract/getProductsByContract')?>",            
        data: "contractID=" + $(this).val(),            
        dataType: "html",                                  
        success: function(data) {               
		    $('#productID').html(data);				 
        }        
    });  
 });

</script>
