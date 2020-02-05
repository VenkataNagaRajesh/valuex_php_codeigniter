
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("airline_product/index")?>"></i> <?php //echo$this->lang->line('menu_usertype'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_airline_product')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">

                <?php 
                        if(form_error('name')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="contract_name" class="col-sm-2 control-label">
                            <?=$this->lang->line("contract_name")?>
                        </label>
                        <div class="col-sm-6">                        				 
                           <input type="text" class="form-control"  id="name" name="name" value="<?=set_value('name')?>" > 							 
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('name'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error('airlineID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airlineID" class="col-sm-2 control-label">
                            <?=$this->lang->line("airline_product")?>
                        </label>
                        <div class="col-sm-6">                          				 
                              <?php 
                                  $airlines[0]=$this->lang->line("select_airline");					
							      foreach($airlinelist as $airline){	
                                      $airlines[$airline->vx_aln_data_defnsID] = $airline->code;							
								   // echo '<option value="'.$airline->vx_aln_data_defnsID.'">'.$airline->code.'</option>';
                                  } 
                                  
                                 echo form_dropdown("airlineID", $airlines,
                                  set_value("airlineID",$airlineID), "id='airlineID' class='form-control hide-dropdown-icon'"
                                 ); 
							  ?>                           
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('airlineID'); ?>
                        </span>
                    </div>

                    <?php 
                        if(form_error('productID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="productID" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_name")?>
                        </label>
                        <div class="col-sm-6">                        				 
                              <?php 
                                  $productslist[0]=$this->lang->line("select_product");				
							      foreach($products as $product){								
								    $productslist[$product->productID] = $product->name;
                                  }                                  
                                  echo form_dropdown("productID", $productslist,
                                  set_value("productID"), "id='productID' class='form-control hide-dropdown-icon'"
                                 );                                   							
							  ?>							 
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productID'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('start_date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="start_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("start_date")?> <span class="text-red">*</span>
                        </label>                        
                        <div class="col-sm-6">
                          <div class="input-group">
							<input type="text" class="form-control hasDatepicker"  id="start_date" name="start_date" value="<?=set_value('start_date')?>" >
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                           </div>
						</div>                        
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('start_date'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('end_date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="end_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("end_date")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control hasDatepicker"  id="end_date" name="end_date" value="<?=set_value('end_date')?>" >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('end_date'); ?>
                        </span>
                    </div>

                    <div class='form-group' > 
                        <label for="end_date" class="col-sm-2 control-label">
                            <?=$this->lang->line("end_date")?> <span class="text-red">*</span>
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
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_contract")?>" >
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>
<script>
 $('#airlineID').select2();
 $('#productID').select2();
 
 $("#start_date").datepicker({    
    onSelect: function(dateText) {
       	var dateinfo = this.value.split('/');
		console.log(dateinfo[2]+','+dateinfo[0]+','+dateinfo[1]);
		$("#end_date").datepicker("setDate", new Date(dateinfo[2],dateinfo[0],dateinfo[1]) );
    }
});
 $('#end_date').datepicker();
</script>
