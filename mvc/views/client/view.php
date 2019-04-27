 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("client/index")?>"><?=$this->lang->line('menu_airline_client')?></a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">
        <div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("client_information")?></h1>
			<div class="row">				
				 <div class="profile-view-tab"> 
					 <p><span><?=$this->lang->line("client_id")?> </span>: <?=$client->VX_aln_clientID?></p>
					 <p><span><?=$this->lang->line("client_name")?> </span>: <?=$client->name?></p>
					 <p><span><?=$this->lang->line("client_email")?> </span>: <?=$client->email?></p>
					 <p><span><?=$this->lang->line("client_phone")?> </span>: <?=$client->phone?></p>
					 <p><span><?=$this->lang->line("client_airline")?> </span>: <?=$client->airline?></p>
					 <p><span><?=$this->lang->line("client_status")?> </span>: <?=$client->active?></p>
					 <p><span><?=$this->lang->line("client_username")?> </span>: <?=$client->username?></p>
					
				</div>  
			</div>
		</div>
  </section>
</div>
  
 


