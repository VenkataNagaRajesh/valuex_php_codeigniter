 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("preference/index")?>"><?php //echo$this->lang->line('menu_preference');?>Back</a></li>             
              <li class="active"><?=$this->lang->line('view')?> <?=$this->lang->line('menu_preference')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">		
		<div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("preference_information")?></h1>
			<div class="row">				
				 <div class="profile-view-tab"> 
					 <p><span><?=$this->lang->line("preference_id")?> </span>: <?=$preference->VX_aln_preferenceID?></p>
					 <p><span><?=$this->lang->line("preference_category")?> </span>: <?=$preference->category?></p>
					 <p><span><?=$this->lang->line("preference_type")?> </span>: <?=$preference->type?></p>
					 <p><span><?=$this->lang->line("preference_code")?> </span>: <?=$preference->pref_code?></p>
					 <p><span><?=$this->lang->line("preference_display_name")?> </span>: <?=$preference->pref_display_name?></p>
					 <p><span><?=$this->lang->line("preference_value")?> </span>: <?=$preference->pref_value?></p>
					 <p><span><?=$this->lang->line("preference_get_value_type")?> </span>: <?=$preference->valuetype?></p>
					 <p><span><?=$this->lang->line("preference_get_value")?> </span>: <?=$preference->value?></p>
					 <p><span><?=$this->lang->line("preference_create_user")?> </span>: <?=$preference->user?></p>
					 <p><span><?=$this->lang->line("preference_create_date")?> </span>: <?=date('d-m-Y',$preference->modify_date)?></p>				 
				</div>  
			</div>
		</div>
  </section>
</div>
  
 


