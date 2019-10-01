 <div class="well">
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">            
              <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>             
              <li><a href="<?=base_url("season/index")?>"><?php //echo $this->lang->line('menu_season'); ?>Back</a></li>             
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
					 <p><span><?=$this->lang->line("season_name")?> </span>: <?=$season->season_name?></p>
					 <p><span><?=$this->lang->line("season_airline")?> </span>: <?=$season->airline_name.'('.$season->airline_code.')'?></p>
					 <p><span><?=$this->lang->line("season_start_date")?> </span>: <?=$season->ams_season_start_date?></p>
					 <p><span><?=$this->lang->line("season_end_date")?> </span>: <?=$season->ams_season_end_date?></p>
					 <p><span><?=$this->lang->line("orig_level")?> </span>: <?=$season->orig_level?></p>
					 <p><span><?=$this->lang->line("orig_level_value")?> </span>: <?=$season->orig_level_values?></p>
					 <p><span><?=$this->lang->line("dest_level")?> </span>: <?=$season->dest_level?></p>
					 <p><span><?=$this->lang->line("dest_level_value")?> </span>: <?=$season->dest_level_values?></p>
					 <p><span><?=$this->lang->line("is_return_inclusive")?> </span>: <?=$season->is_return_inclusive?></p>
					 <p><span><?=$this->lang->line("season_color")?> </span>: <span class="season-view-color" style="background:<?=$season->season_color?>;width:80px;"></span></p>
					
					<!-- <input type="text" id="season_calender" /> -->
					 
				</div>  
			</div>
		</div>
  </section>
</div>
 <!--<script>
   var eventDates = {};
  eventDates[ new Date( '12/04/2019' )] = new Date( '12/04/2014' );
  eventDates[ new Date( '12/06/2019' )] = new Date( '12/06/2014' );
  eventDates[ new Date( '12/20/2019' )] = new Date( '12/20/2014' );
  eventDates[ new Date( '12/25/2019' )] = new Date( '12/25/2014' );
 
 $(document).ready(function() {	 
      $('#season_calendar').datepicker({
            beforeShowDay: function( date ) {
                var highlight = eventDates[date];
                if( highlight ) {
                     return [true, "event", highlight];
                } else {
                     return [true, '', ''];
                }
             }
        }); 
		
}); 
 $('#season_calendar').datepicker();
</script> -->
 


