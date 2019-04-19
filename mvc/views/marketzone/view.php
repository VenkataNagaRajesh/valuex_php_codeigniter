 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("marketzone/index")?>"><?=$this->lang->line('menu_marketzone')?></a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">		
		<div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("marketzone_information")?></h1>
			<div class="row">				
				 <div class="profile-view-tab"> 
					 <p><span><?=$this->lang->line("market_id")?> </span>: 
								<?=$marketzone->market_id?></p>
					 <p><span><?=$this->lang->line("market_name")?> </span>: 
								<?=$marketzone->market_name?></p>
					 <p><span><?=$this->lang->line("level_type")?> </span>: 
						<?php echo $this->marketzone_m->getAlndataType($marketzone->amz_level_id);?></p>
					 <p><span><?=$this->lang->line("amz_level_value")?> </span>: 
						<?php echo $this->marketzone_m->getALndataTypeValues($marketzone->amz_level_name);?></p>
					 <p><span><?=$this->lang->line("amz_incl_type")?> </span>: 
						<?php echo $this->marketzone_m->getAlndataType($marketzone->amz_incl_id)?></p>
					 <p><span><?=$this->lang->line("amz_incl_value")?> </span>: 
						<?php echo $this->marketzone_m->getALndataTypeValues($marketzone->amz_incl_name);?></p>
					 <p><span><?=$this->lang->line("amz_excl_type")?> </span>: 
						<?php echo $this->marketzone_m->getAlndataType($marketzone->amz_excl_id);?></p>
					 <p><span><?=$this->lang->line("amz_excl_value")?> </span>: 
						<?php echo $this->marketzone_m->getALndataTypeValues($marketzone->amz_excl_name);?></p>
					 <p><span><?=$this->lang->line("marketzone_create_user")?> </span>: 
							<?php echo $this->user_m->get_username_byid($marketzone->create_userID)?></p>
					 <p><span><?=$this->lang->line("marketzone_modify_user")?> </span>:
                                                        <?php echo $this->user_m->get_username_byid($marketzone->modify_userID)?></p>

					 <p><span><?=$this->lang->line("marketzone_create_date")?> </span>:
							 <?=date('d/m/Y',$marketzone->create_date)?></p>

					<p><span><?=$this->lang->line("marketzone_modify_date")?> </span>:
                                                         <?=date('d/m/Y',$marketzone->modify_date)?></p>


					 
				</div>  
			</div>
		</div>
  </section>
</div>
