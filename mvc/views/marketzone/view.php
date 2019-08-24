 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("marketzone/index")?>"><?php //echo $this->lang->line('menu_marketzone'); ?>Back</a></li>             
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
								<?=$marketzone[0]->market_id?></p>
					 <p><span><?=$this->lang->line("market_name")?> </span>: 
								<?=$marketzone[0]->market_name?></p>
					 <p><span><?=$this->lang->line("level_type")?> </span>: 
						<?=$marketzone[0]->lname?></p>
					 <p><span><?=$this->lang->line("amz_level_value")?> </span>: 
						<?=$marketzone[0]->levelname?></p>
					 <p><span><?=$this->lang->line("amz_incl_type")?> </span>: 
						<?=$marketzone[0]->iname?></p>
					 <p><span><?=$this->lang->line("amz_incl_value")?> </span>: 
						<?=$marketzone[0]->inclname;?></p>
					 <p><span><?=$this->lang->line("amz_excl_type")?> </span>: 
						<?=$marketzone[0]->ename;?></p>
					 <p><span><?=$this->lang->line("amz_excl_value")?> </span>: 
						<?=$marketzone[0]->exclname?></p>
					 <p><span><?=$this->lang->line("marketzone_create_user")?> </span>: 
							<?php echo $this->user_m->get_username_byid($marketzone[0]->create_userID)?></p>
					 <p><span><?=$this->lang->line("marketzone_modify_user")?> </span>:
                                                        <?php echo $this->user_m->get_username_byid($marketzone[0]->modify_userID)?></p>

					 <p><span><?=$this->lang->line("marketzone_create_date")?> </span>:
							 <?=date('d/m/Y',$marketzone[0]->create_date)?></p>

					<p><span><?=$this->lang->line("marketzone_modify_date")?> </span>:
                                                         <?=date('d/m/Y',$marketzone[0]->modify_date)?></p>


					 
				</div>  
			</div>
		</div>
  </section>
</div>
