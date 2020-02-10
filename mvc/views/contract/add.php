
<div class="box">
    <div class="box-header" style="width:100%;">
        <h3 class="box-title"><i class="fa icon-role"></i> <?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("contract/index")?>"></i> <?php //echo$this->lang->line('menu_usertype'); ?>Back</a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_contract')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="post">
                <div class="form-group">
                <div class="col-md-6">
                <?php 
                        if(form_error('name')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="contract_name" class="col-sm-4 control-label">
                            <?=$this->lang->line("contract_name")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">                        				 
                           <input type="text" class="form-control"  id="name" name="name" value="<?=set_value('name')?>" > 
                           <span class="control-label">
                                <?php echo form_error('name'); ?>
                            </span>							 
                        </div>                     
                    </div>
                    </div>
                    <div class="col-md-6">
                    <?php 
                        if(form_error('airlineID')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="airlineID" class="col-sm-3 control-label">
                            <?=$this->lang->line("airline_product")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-9">                          				 
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
                            <span class="control-label">
                                <?php echo form_error('airlineID'); ?>
                            </span>                         
                        </div>                      
                    </div>
                    </div>
                </div>
                <?php 
                   $productslist[0]=$this->lang->line("select_product");					
                   foreach($products as $product){	
                       $productslist[$product->productID] = $product->name;	                  
                   } 
                   $i = 1;
                   while(count($products) >= $i) {
                ?>
                  <div class="form-group" style="margin: 0 0 10px;border: solid 1px #ddd;padding: 19px 0 0;">
                  <div class="col-md-6">
                    <?php 
                    if(form_error('pmod'.$i.'-productID')) 
                        echo "<div class='form-group has-error' >";
                    else     
                        echo "<div class='form-group' >";
                    ?>
                    <label for="products" class="col-sm-4 control-label">
                            <?=$this->lang->line("product_name")?><span class="text-red">*</span>
                    </label>
                        <div class="col-sm-8">
                           <!-- <select name="products[]" id="products" class="form-control select2" multiple="multiple"> -->				 
                            <?php 
                             echo form_dropdown("pmod$i-productID", $productslist, set_value("pmod".$i."-productID"), "id='pmod$i-productID' class='form-control hide-dropdown-icon'");                               
                            ?>
                          <!--  </select> -->  
                            <span class="control-label">
                                <?php echo form_error('pmod'.$i.'-productID'); ?>
                             </span>                         
                        </div>                                              
                   </div>
                       
                    <?php
                        if(form_error('pmod'.$i.'-no-users'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pmod<?=$i?>-no-users" class="col-sm-4 control-label">
                            <?=$this->lang->line("no_users")?> <span class="text-red">*</span>
                        </label>                        
                        <div class="col-sm-8">                         
							<input type="number" class="form-control"  id="pmod<?=$i?>-no-users" name="pmod<?=$i?>-no-users" value="<?=set_value('pmod'.$i.'-no-users')?>" >							
                            
                           <span class="control-label">
                            <?php echo form_error('pmod'.$i.'-no-users'); ?>
                           </span>
                        </div>				                                          
                      </div>
                    </div>  
                    <div class="col-md-6">          
                    <?php
                        if(form_error('pmod'.$i.'-start-date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pmod<?=$i?>-start-date" class="col-sm-4 control-label">
                            <?=$this->lang->line("start_date")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control hasDatepicker"  id="pmod<?=$i?>-start-date" name="pmod<?=$i?>-start-date" value="<?=set_value('pmod'.$i.'-start-date')?>" >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                            <span class="control-label">
                                <?php echo form_error('pmod'.$i.'-start-date'); ?>
                             </span>
                        </div>
                    </div>           
                    <?php
                        if(form_error('pmod'.$i.'-end-date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="pmod<?=$i?>-end-date" class="col-sm-4 control-label">
                            <?=$this->lang->line("end_date")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control hasDatepicker"  id="pmod<?=$i?>-end-date" name="pmod<?=$i?>-end-date" value="<?=set_value('pmod'.$i.'-end-date')?>" >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                            <span class="control-label">
                            <?php echo form_error('pmod'.$i.'-end-date'); ?>
                        </span>
                        </div>
                    </div> 
                    </div>  
                    </div>  
                   <?php $i++; } ?> 
                    <div class='form-group' > 
                        <label for="end-date" class="col-sm-2 control-label">
                            <?=$this->lang->line("contract_active")?> <span class="text-red">*</span>
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
                        <div class="col-md-4">
                            <div class="pull-right">
                                <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_contract")?>" >
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<script>
 $('#airlineID').select2();
 $('#active').select2();
 $( ".select2" ).select2();
 
 <?php $i=1; while(count($products) >= $i){ ?>
   $("#pmod<?=$i?>-productID").select2();
    $("#pmod<?=$i?>-start-date").datepicker();
    $("#pmod<?=$i?>-end-date").datepicker();
 <?php $i++; } ?>
 
</script>
