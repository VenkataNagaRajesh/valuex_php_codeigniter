 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("airline_cabin/index")?>">Back</a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">		
		<div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("airline_cabin_information")?></h1>
			<div class="row">				
				 <div class="profile-view-tab"> 
					 <p><span><?=$this->lang->line("airline_cabin_map_id")?> </span>: 
								<?=$airline_cabin->cabin_map_id?></p>
					 <p><span><?=$this->lang->line("airline_name")?> </span>: 
						<?=$airline_cabin->airline;?></p>
					 <p><span><?=$this->lang->line("airline_aircraft")?> </span>:
						<?=$airline_cabin->aircraft_name;?></p>
					 <p><span><?=$this->lang->line("airline_cabin")?> </span>: 
						<?=$airline_cabin->cabin?></p>
					<p><span><?=$this->lang->line("airline_video")?> </span>:
<?php	
						 if ( !empty($airline_cabin->video_links) ){
					 $links = explode(',', $airline_cabin->video_links );
                        			foreach ($links as $k=>$link) {?>
                                <a target="_new" href="<?=$link;?>" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs">link<?=$k+1?></a>&nbsp;&nbsp;
               <?php } } ?>


						
					 <p><span><?=$this->lang->line("airline_cabin_create_user")?> </span>: 
							<?php echo $this->user_m->get_username_byid($airline_cabin->create_userID)?></p>
					 <p><span><?=$this->lang->line("airline_cabin_modify_user")?> </span>:
                                                        <?php echo $this->user_m->get_username_byid($airline_cabin->modify_userID)?></p>

					 <p><span><?=$this->lang->line("airline_cabin_create_date")?> </span>:
							 <?=date('d/m/Y',$airline_cabin->create_date)?></p>

					<p><span><?=$this->lang->line("airline_cabin_modify_date")?> </span>:
                                                         <?=date('d/m/Y',$airline_cabin->modify_date)?></p>


					 
				</div>  
			</div>
		</div>
 <div>
                        <?php foreach($airline_cabin->gallery as $gallery){

                                     $array = array(
                                "src" => base_url('uploads/images/'.$gallery->image),
                                        'width' => '150px',
                                        'height' => '150px',
                                        'class' => 'img-rounded'
                                );
				echo img($array);

                        }?>
                        </div>


  </section>
</div>


