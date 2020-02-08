 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("client/index")?>"><?php //echo $this->lang->line('menu_airline_client'); ?>Back</a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">
        <div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("client_information")?></h1>
			<a href="<?=base_url('client/add_product/'.$client->userID)?>" class="btn btn-danger">Add Product</a>

			<div class="row">				
				 <div class="profile-view-tab"> 
					 <p><span><?=$this->lang->line("client_id")?> </span>: <?=$client->userID?></p>
					 <p><span><?=$this->lang->line("client_name")?> </span>: <?=$client->name?></p>
					 <p><span><?=$this->lang->line("client_email")?> </span>: <?=$client->email?></p>
					 <p><span><?=$this->lang->line("client_phone")?> </span>: <?=$client->phone?></p>
					 <p><span><?=$this->lang->line("client_airline")?> </span>: <?=$client->airlines?></p>
					 <p><span><?=$this->lang->line("client_status")?> </span>: <?=($client->active)?'Anable':'Disable'?></p>
					 <p><span><?=$this->lang->line("client_username")?> </span>: <?=$client->username?></p>					
				</div>				
			</div>			
		</div>
  </section>
 <?php  if(count($products) > 0){ ?>
  <section class="panel">
        <div class="panel-body profile-view-dis">
			<h1>Client Products List</h1>
			<div class="row">				
				 <div class="profile-view-tabddd"> 
				 <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('client_airline')?></th>
								<th class="col-lg-2"><?=$this->lang->line('product_contract')?></th>
								<th class="col-lg-1"><?=$this->lang->line('product_product')?></th>
                                <?php if(permissionChecker('client_product_delete')) { ?>
                                <th class="col-lg-1 noExport"><?=$this->lang->line('action')?></th>
								<?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($products as $product) { ?>                                   
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('client_airline')?>">
                                        <?php echo $product->carrier; ?>
                                    </td>
									<td data-title="<?=$this->lang->line('product_contract')?>">
                                        <?php echo $product->contract_name; ?>
                                    </td>
									<td data-title="<?=$this->lang->line('product_product')?>">
                                        <?php echo $product->product_name; ?>
                                    </td>
                                    <?php if(permissionChecker('client_product_delete')) { ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
									<a href="<?=base_url('client/delete_product/'.$product->client_productID)?>" onclick="return confirm('you are about to delete a record. This cannot be undone. are you sure?')" class="btn btn-danger btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                    <?php } ?>
                                </tr>
								   <?php $i++; } ?>
                        </tbody>
                    </table>				
				</div>				
			</div>			
		</div>
  </section>
									<?php } ?>
</div>
  
 


