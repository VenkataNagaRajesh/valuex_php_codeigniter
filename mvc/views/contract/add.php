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
            <div class="col-sm-9">
                <form class="form-horizontal" role="form" method="post">
                <div class="form-group">
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
                           <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name" value="<?=set_value('name')?>" > 
                           <span class="control-label">
                                <?php echo form_error('name'); ?>
                            </span>							 
                        </div>                     
                    </div>
                    </div>
                </div>
                <div class="form-group">
                <div class="col-md-6">
                <?php 
                        if(form_error('email_id')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="email_id" class="col-sm-4 control-label">
                            Email <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">                        				 
                           <input type="text" class="form-control" placeholder="Enter Email id" id="email_id" name="email_id" value="<?=set_value('email_id')?>" > 
                           <span class="control-label">
                                <?php echo form_error('email_id'); ?>
                            </span>							 
                        </div>                     
                    </div>
                    </div>
                    <div class="col-md-6">
                    <?php 
                        if(form_error('designation')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="designation" class="col-sm-3 control-label">
                        Designation<span class="text-red">*</span>
                        </label>
                        <div class="col-sm-9">                          				 
                        <input type="text" class="form-control" placeholder="Enter Desigination" id="designation" name="designation" value="<?=set_value('designation')?>" > 
                            <span class="control-label">
                                <?php echo form_error('designation'); ?>
                            </span>                         
                        </div>                      
                    </div>
                    </div>
                </div>
                <div class="form-group">
                <div class="col-md-6">
                <?php 
                        if(form_error('telephone')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="telephone" class="col-sm-4 control-label">
                        Telephone<span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">                        				 
                           <input type="number" class="form-control" placeholder="Enter Telephone" id="telephone" name="telephone" value="<?=set_value('telephone')?>" > 
                           <span class="control-label">
                                <?php echo form_error('telephone'); ?>
                            </span>							 
                        </div>                     
                    </div>
                    </div>
                    <div class="col-md-6">
                    <?php 
                        if(form_error('ext_no')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="ext_no" class="col-sm-3 control-label">
                            Extension Number<span class="text-red">*</span>
                        </label>
                        <div class="col-sm-9">       
                        <input type="number" class="form-control" placeholder="Enter Extension Number" id="ext_no" name="ext_no" value="<?=set_value('ext_no')?>" >                    				 
                               
                            <span class="control-label">
                                <?php echo form_error('ext_no'); ?>
                            </span>                         
                        </div>                      
                    </div>
                    </div>
                </div>
                <div class="form-group">
                <div class="col-md-6">
                <?php 
                        if(form_error('mobile_number')) 
                            echo "<div class='form-group has-error' >";
                        else     
                            echo "<div class='form-group' >";
                    ?>
                        <label for="mobile_number" class="col-sm-4 control-label">
                           Mobile Number<span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">                        				 
                           <input type="number" class="form-control" placeholder="Enter Mobile Number" id="mobile_number" name="mobile_number" value="<?=set_value('mobile_number')?>" > 
                           <span class="control-label">
                                <?php echo form_error('mobile_number'); ?>
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
                        
                        
                        <div class="col-sm-9">                          				 
                                                    
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
                  <div class="col-md-7">
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
                    <div class="col-md-5">          
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
                            <div class="input-group" style="margin-bottom: 0">
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
                            <div class="input-group" style="margin-bottom: 0">
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

                   <div class='form-group' id="select-client" style="display:none;">                   
                        <label for="phone" class="col-sm-2 control-label">
                            <?="Create Client"?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-4">
                          <select name="create_client"  class='form-control'" id="create_client" >
                          </select>                          
                        </div>                       
                  </div>
                   
                   <!-- Client Registration Module -->
                 <div id="client-reg" style="display:none;"> 
                    <h4>Client Details</h4>
                    <input type="hidden" id="client-registration" name="client-registration" value="<?=set_value('client-registration')?>" />
                  <div class="form-group" style="margin: 0 0 10px;border: solid 1px #ddd;padding: 19px 0 0;">
                  <div class="col-md-6">
                   <?php
                        if(form_error('client_name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="name" class="col-sm-4 control-label">
                            <?=$this->lang->line("client_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="client_name" name="client_name" value="<?=set_value('client_name')?>" >
                            <span class="control-label">
                              <?php echo form_error('client_name'); ?>
                            </span>
                        </div>                        
                    </div>
                    <?php
                        if(form_error('client_phone'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="phone" class="col-sm-4 control-label">
                            <?=$this->lang->line("client_phone")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="client_phone" name="client_phone" value="<?=set_value('client_phone')?>" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" >
                            <span class="control-label">
                              <?php echo form_error('client_phone'); ?>
                            </span>
                        </div>                       
                    </div>
                </div>
                <div class="col-md-6">                  
                    <?php
                        if(form_error('client_domain'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="client_domain" class="col-sm-4 control-label">
                            <?=$this->lang->line("client_domain")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="client_domain" name="client_domain" value="<?=set_value('client_domain')?>" >
                            <span class="control-label">
                            <?php echo form_error('client_domain'); ?>
                            </span>
                        </div>                        
                    </div>
                    <?php
                        if(form_error('client_email'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="client_email" class="col-sm-4 control-label">
                            <?=$this->lang->line("client_email")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="client_email" name="client_email" value="<?=set_value('client_email')?>" >
                            <span class="control-label">
                            <?php echo form_error('client_email'); ?>
                            </span>
                        </div>                        
                    </div>
                   </div>
                   <div class="col-md-6">                   
                    <?php
                        if(form_error('client_username'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="client_username" class="col-sm-4 control-label">
                            <?=$this->lang->line("client_username")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="client_username" name="client_username" value="<?=set_value('client_username')?>" >
                            <span class="control-label">
                                <?php echo form_error('client_username'); ?>
                            </span>
                        </div>                         
                    </div>
                  </div>
                  <div class="col-md-6">
                    <?php
                        if(form_error('client_password'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="client_password" class="col-sm-4 control-label">
                            <?=$this->lang->line("client_password")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="client_password" name="client_password" value="<?=set_value('client_password')?>" >
                            <span class="control-label">
                            <?php echo form_error('client_password'); ?>
                            </span>
                        </div>                         
                    </div>
                 </div>
                 </div>
                </div>
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
                        <div class="col-md-4 col-md-offset-3">
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

$(document).ready(function(){
    $('#airlineID').trigger('change');
});
 $('#airlineID').select2();
 $('#active').select2();
 $( ".select2" ).select2();
 
 <?php $i=1; while(count($products) >= $i){ ?>
    $("#pmod<?=$i?>-productID").select2();
    $("#pmod<?=$i?>-start-date").datepicker();
    $("#pmod<?=$i?>-end-date").datepicker();
 <?php $i++; } ?>

 $('#airlineID').change(function(){
     if($(this).val() != 0){
        $.ajax({
            async: false,
            type: 'POST',
            url: "<?=base_url('contract/checkClientByAirline')?>",          
            data: {"airlineID":$(this).val()},
            dataType: "html",                     
            success: function(data) {
                var result = JSON.parse(data);	
                if(result.status == 0){
                    $('#create_client').html('');
                    $('#select-client').css('display','none');
                    $('#client-registration').val(1);               
                    $('#client-reg').css('display','block');
                } else {
                    $('#client-registration').val(0); 
                    $('#client-reg').css('display','none');
                    $('#create_client').html(result.status);
                    $('#select-client').css('display','block');
                    console.log(result);
                }		
            }
        });
     }
 });
 
</script>
