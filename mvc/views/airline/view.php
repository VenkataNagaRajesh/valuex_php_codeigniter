 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("airline/index")?>"><?=$this->lang->line('menu_airline')?></a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">		
		<div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("airline_information")?></h1>
			<div class="row">				
				 <div class="profile-view-tab"> 
				     <p><span><?=$this->lang->line("airline_id")?> </span>: <?=$airline->VX_aln_airlineID?></p>
					 <p><span><?=$this->lang->line("airline_name")?> </span>: <?=$airline->name?></p>
					 <p><span><?=$this->lang->line("airline_code")?> </span>: <?=$airline->code?></p>
					 <p><span><?=$this->lang->line("airline_active")?> </span>: <?=$airline->active?></p>
					 <p><span><?=$this->lang->line("airline_created_user")?> </span>: <?=$airline->modify_by?></p>
					 <p><span><?=$this->lang->line("airline_created_date")?> </span>: <?=date('d/m/Y',$airline->modify_date)?></p>
					 <p><span><?=$this->lang->line("airline_flights")?> </span>: <?=$airline->flights?></p>
					 
				</div>  
			</div>
		</div>
  </section>
</div>
  
 


