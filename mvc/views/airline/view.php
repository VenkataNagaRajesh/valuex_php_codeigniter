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
			<?php if(!empty($airline->logo) || !empty($airline->video_links)){ ?>
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
			<?php if(!empty($airline->video_links)){ ?>
			<div class="col-md-3">
				<iframe src="<?=str_replace('watch?v=','embed/',$airline->video_links)?>" width="100%" height="130"></iframe>
			</div>
			<?php } ?>
        </div>
			<?php } ?>
		<?php if(!empty($airline->gallery)){ ?>
		<div class="adm-brands">
			<div class="col-md-12 airline-cabin-img" style="padding:0">
				<h2>Gallery</h2>				
				  <?php
					 foreach($airline->gallery as $image){ ?>
					 <div class="col-md-2" id="al-gallery-<?=$image->galleryID?>">
						 <div class="img-box"> 
							<?php $array = array("src" => base_url('uploads/images/'.$image->image),
											'width' => '150px',
											'height' => '150px',
											'class' => 'img-rounded image'
									  );
							echo img($array); ?>
							<div class="middle">
								<button type="button" class="btn btn-danger btn-sm btn-del" id="del-btn-<?=$image->galleryID?>"><i class="fa fa-trash"></i></button>
							</div>
						</div>
					</div>
					<?php }?>
			  </div>
		 </div>
		<?php } ?>
			<div class="col-md-12 airline-view-hdr adm-brands" style="padding:0">
			   <?php if(!empty($airline->upgrade_offer_mail_template1)) { ?>
				<div class="col-md-3">
				  <h2>Upgrade Offer Mail Template 1</h2>
							  
				  <?php	 foreach($airline->upgrade_offer_mail_template1 as $image){ ?>
				    <div class="col-md-12" id="al-gallery-<?=$image->galleryID?>">
					  <div class="img-box"> 
					  <?php $array = array("src" => base_url('uploads/images/'.$image->image),
										'width' => '100%',
										'height' => '180px',
										'class' => 'img-rounded'
								  );
						echo img($array); ?>
						<div class="middle">
								<button type="button" class="btn btn-danger btn-sm btn-del" id="del-btn-<?=$image->galleryID?>"><i class="fa fa-trash"></i></button>
							</div>
						</div>
					</div>
					 <?php } ?>					
				</div>
			   <?php } ?>
			   <?php if(!empty($airline->upgrade_offer_mail_template2)) { ?>
				<div class="col-md-3">
					<h2>Upgrade Offer Mail Template 2</h2>			  
					  <?php
						 foreach($airline->upgrade_offer_mail_template2 as $image){?>
				          <div class="col-md-12" id="al-gallery-<?=$image->galleryID?>">
					        <div class="img-box"> 
							<?php $array = array("src" => base_url('uploads/images/'.$image->image),
												'width' => '100%',
												'height' => '180px',
												'class' => 'img-rounded'
										  );
								echo img($array); ?>
							  <div class="middle">
									<button type="button" class="btn btn-danger btn-sm btn-del" id="del-btn-<?=$image->galleryID?>"><i class="fa fa-trash"></i></button>
								</div>
							</div>
					    </div>
					 <?php } ?>
				</div>
				 <?php } ?>
			   <?php if(!empty($airline->upgrade_offer_mail_template3)) { ?>
				<div class="col-md-3">
					<h2>Upgrade Offer Mail Template 3</h2>				  
					  <?php
						 foreach($airline->upgrade_offer_mail_template3 as $image){?>
				          <div class="col-md-12" id="al-gallery-<?=$image->galleryID?>">
					        <div class="img-box"> 
							<?php $array = array("src" => base_url('uploads/images/'.$image->image),
											'width' => '100%',
											'height' => '180px',
											'class' => 'img-rounded'
									  );
							 echo img($array); ?>
							  <div class="middle">
									<button type="button" class="btn btn-danger btn-sm btn-del" id="del-btn-<?=$image->galleryID?>"><i class="fa fa-trash"></i></button>
							   </div>
							</div>
					     </div>
					 <?php } ?>
				</div>
				 <?php } ?>
			   <?php if(!empty($airline->airline_logo)) { ?>
				<div class="col-md-3">
					<h2>Airline Logo for Mail Template(84*60)</h2>	  
					  <?php foreach($airline->airline_logo as $image){ ?>
				          <div class="col-md-12" id="al-gallery-<?=$image->galleryID?>">
					        <div class="img-box"> 
							<?php $array = array("src" => base_url('uploads/images/'.$image->image),
											'width' => '100%',
											'height' => '180px',
											'class' => 'img-rounded'
									  );
							echo img($array); ?>
							  <div class="middle">
									<button type="button" class="btn btn-danger btn-sm btn-del" id="del-btn-<?=$image->galleryID?>"><i class="fa fa-trash"></i></button>
							   </div>
							</div>
					    </div>
					 <?php } ?>
				</div>
			   <?php } ?>
			</div>
		</div>
	</div>
 </section>
  <script>
  <?php  foreach($airline->gallery as $image){ ?>
		$("#del-btn-<?=$image->galleryID?>").click(function(){
			$.ajax({ 
			 async: false,            
			 type: 'POST',            
			 url: "<?=base_url('airline/deleteImage')?>",            
			 data: {"galleryID": <?=$image->galleryID?>},            
			 dataType: "html",                                  
			 success: function(data) {
				$("#al-gallery-<?=$image->galleryID?>").remove();
			 }
		  });			
		});
	 <?php } ?>
	 
	  <?php  foreach($airline->upgrade_offer_mail_template1 as $image){ ?>
		$("#del-btn-<?=$image->galleryID?>").click(function(){
			$.ajax({ 
			 async: false,            
			 type: 'POST',            
			 url: "<?=base_url('airline/deleteImage')?>",            
			 data: {"galleryID": <?=$image->galleryID?>},            
			 dataType: "html",                                  
			 success: function(data) {
				$("#al-gallery-<?=$image->galleryID?>").remove();				
			 }
		  });			
		});
	 <?php } ?>
	  <?php  foreach($airline->upgrade_offer_mail_template2 as $image){ ?>
		$("#del-btn-<?=$image->galleryID?>").click(function(){
			$.ajax({ 
			 async: false,            
			 type: 'POST',            
			 url: "<?=base_url('airline/deleteImage')?>",            
			 data: {"galleryID": <?=$image->galleryID?>},            
			 dataType: "html",                                  
			 success: function(data) {
				$("#al-gallery-<?=$image->galleryID?>").remove();
			 }
		  });			
		});
	 <?php } ?>
	  <?php  foreach($airline->upgrade_offer_mail_template3 as $image){ ?>
		$("#del-btn-<?=$image->galleryID?>").click(function(){
			$.ajax({ 
			 async: false,            
			 type: 'POST',            
			 url: "<?=base_url('airline/deleteImage')?>",            
			 data: {"galleryID": <?=$image->galleryID?>},            
			 dataType: "html",                                  
			 success: function(data) {
				$("#al-gallery-<?=$image->galleryID?>").remove();
			 }
		  });			
		});
	 <?php } ?>
	  <?php foreach($airline->airline_logo as $image){ ?>
		$("#del-btn-<?=$image->galleryID?>").click(function(){
			$.ajax({ 
			 async: false,            
			 type: 'POST',            
			 url: "<?=base_url('airline/deleteImage')?>",            
			 data: {"galleryID": <?=$image->galleryID?>},            
			 dataType: "html",                                  
			 success: function(data) {
				$("#al-gallery-<?=$image->galleryID?>").remove();
			 }
		  });			
		});
	 <?php } ?>
	</script>
</div>
  
 


