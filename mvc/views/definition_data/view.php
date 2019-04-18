 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("definition_data/index")?>"><?=$this->lang->line('menu_defdata')?></a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">		
		<div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("defdata_information")?></h1>
			<div class="row">				
				 <div class="profile-view-tab"> 
					 <p><span><?=$this->lang->line("defdata_type")?> </span>: <?=$defdata->type?></p>
					 <p><span><?=$this->lang->line("defdata_value")?> </span>: <?=$defdata->aln_data_value?></p>
					 <p><span><?=$this->lang->line("defdata_parent")?> </span>: <?=$defdata->parent?></p>
					 <p><span><?=$this->lang->line("defdata_code")?> </span>: <?=$defdata->code?></p>
					 <p><span><?=$this->lang->line("defdata_active")?> </span>: <?=$defdata->active?></p>
					 <p><span><?=$this->lang->line("defdata_user")?> </span>: <?=$defdata->modify_by?></p>
					 <p><span><?=$this->lang->line("defdata_date")?> </span>: <?=date('d-m-Y',$defdata->modify_date)?></p>				 
				</div>  
			</div>
		</div>
  </section>
</div>
  
 


