 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("airline_cabin/index")?>"><?=$this->lang->line('menu_airline_cabin')?></a></li>             
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
					 <p><span><?=$this->lang->line("name")?> </span>: 
								<?=$airline_cabin->name?></p>
					 <p><span><?=$this->lang->line("airline_name")?> </span>: 
						<?=$airlinesdata[$airline_cabin->airline_code];?></p>
					 <p><span><?=$this->lang->line("airline_class")?> </span>: 
						<?=$airlineclass[$airline_cabin->airline_class];?></p>
					<p><span><?=$this->lang->line("airline_cabin")?> </span>:  
                                                <?=$airlineclass[$airline_cabin->airline_class];?></p>
					<p><span><?=$this->lang->line("airline_video")?> </span>:
<?php	
						 if ( !empty($airline_cabin->video_links) ){?>
                                <a target="_new" href="<?=$airline_cabin->video_links;?>" data-placement="top" data-toggle="tooltip" class="btn btn-success btn-xs">Video</a>
               <?php  } ?>


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


          <?php if(!empty($airline_cabin->gallery)){ ?>
                <div class="tab-content col-md-12 adm-brands">
                        <h2>Gallery</h2>
                        <?php foreach($airline_cabin->gallery as $gallery){ ?>
                        <div class="col-md-2" id="img-gallery">
                                <div class="img-box">
                                        <img src="<?php echo base_url('uploads/images/'.$gallery->image); ?>" class="img-responsive image">
                                        <div class="middle">
                                                <!--<button type="button" class="btn btn-danger btn-sm btn-gdel"><i class="fa fa-trash"></i></button>-->
                                                <a href="<?php echo base_url('airline_cabin/deleteAirlineCabinimage/'.$gallery->cabin_images_id); ?>" onclick="return confirm('you are about to delete a record. This cannot be undone. are you sure?')" class="btn btn-danger btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash-o" ></i></a>
                                        </div>
                                </div>
                        </div>
                        <?php } ?>
   </div>
                <?php } ?>
  </section>
</div>

        <script>
                $(".btn-gdel").click(function(){
                        $("#img-gallery").remove();
                });
        </script>

