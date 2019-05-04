 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("season/index")?>"><?=$this->lang->line('menu_season')?></a></li>             
              <li class="active"><?=$this->lang->line('view')?></li>            
            </ol>
         </div>
   </div>
 </div>
<div id="printablediv">
   <section class="panel">		
		<div class="panel-body profile-view-dis">
			<h1><?=$this->lang->line("airport_information")?></h1>
			<div class="row">				
				 <div class="profile-view-tab"> 
					<!-- <p><span><?=$this->lang->line("master_airport")?> </span>: <?=$airport->airport?></p>
					 <p><span><?=$this->lang->line("master_country")?> </span>: <?=$airport->country?></p>
					 <p><span><?=$this->lang->line("master_state")?> </span>: <?=$airport->state?></p>
					 <p><span><?=$this->lang->line("master_region")?> </span>: <?=$airport->region?></p>
					 <p><span><?=$this->lang->line("master_area")?> </span>: <?=$airport->area?></p>
					 <p><span><?=$this->lang->line("master_code")?> </span>: <?=$airport->code?></p>
					 <p><span><?=$this->lang->line("master_active")?> </span>: <?=$airport->active?></p>
					 <p><span><?=$this->lang->line("master_latitude")?> </span>: <?=$airport->lat?></p>
					 <p><span><?=$this->lang->line("master_longitude")?> </span>: <?=$airport->lng?></p>
					 <p><span><?=$this->lang->line("airport_created_user")?> </span>: <?=$airport->modify_by?></p>
					 <p><span><?=$this->lang->line("airport_created_date")?> </span>: <?=date('d/m/Y',$airport->modify_date)?></p>-->
					 <input type="text" id="season_calender" />
					 
				</div>  
			</div>
		</div>
  </section>
</div>
 <script>
/*   var eventDates = {};
  eventDates[ new Date( '12/04/2019' )] = new Date( '12/04/2014' );
  eventDates[ new Date( '12/06/2019' )] = new Date( '12/06/2014' );
  eventDates[ new Date( '12/20/2019' )] = new Date( '12/20/2014' );
  eventDates[ new Date( '12/25/2019' )] = new Date( '12/25/2014' );
 
 $(document).ready(function() {	 
    /*  $('#season_calendar').datepicker({
            beforeShowDay: function( date ) {
                var highlight = eventDates[date];
                if( highlight ) {
                     return [true, "event", highlight];
                } else {
                     return [true, '', ''];
                }
             }
        }); 
		
}); */
 $('#season_calendar').datepicker();
</script> 
 


