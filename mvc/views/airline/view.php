 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("airline/index")?>"><?php //echo $this->lang->line('menu_airline'); ?>Back</a></li>             
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
				     <p><span><?=$this->lang->line("airline_id")?> </span>: <?=$airline->vx_aln_data_defnsID?></p>
					 <p><span><?=$this->lang->line("airline_name")?> </span>: <?=$airline->airline_name?></p>
					 <p><span><?=$this->lang->line("airline_code")?> </span>: <?=$airline->code?></p>
					 <p><span><?=$this->lang->line("airline_active")?> </span>: <?=($airline->active)?'Anable':'Disable'?></p>
					 <p><span><?=$this->lang->line("airline_created_user")?> </span>: <?=$airline->modify_by?></p>
					 <p><span><?=$this->lang->line("airline_created_date")?> </span>: <?=date('d/m/Y',$airline->modify_date)?></p>
					
					 
				</div>
                <div class="profile-view-tab">
				    <p><span><?=$this->lang->line("airline_flights")?> </span>: <?=$airline->flights?></p>
                </div>				
			</div>
			<div class="col-md-12 airline-cabin-img" style="padding:0">
		<h2>Logo & Videos</h2>
           
            <?php
                         $array = array(
                    "src" => base_url('uploads/images/'.$airline->logo),
                            'width' => '150px',
                            'height' => '150px',
                            'class' => 'img-rounded'
                    );
				echo img($array);
            ?>
			
			<div class="col-md-3">
				<iframe src="<?=str_replace('watch?v=','embed/',$airline->video_links)?>" width="100%" height="130"></iframe>
			</div>
        </div>
		</div>
  </section>
</div>
  
 


