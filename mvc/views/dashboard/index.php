<div class="row">
<?php if(config_item('demo')) { ?>
    <div class="col-sm-12" id="resetDummyData">
        <div class="callout callout-danger">
            <h4>Reminder!</h4>
            <p>Dummy data will be reset in every <code>30</code> minutes</p>
        </div>
    </div>
   
    <script type="text/javascript"> 
      $(document).ready(function() {
          var count = 7;
          var countdown = setInterval(function(){
            $("p.countdown").html(count + " seconds remaining!");
            if (count == 0) {
              clearInterval(countdown);
              $('#resetDummyData').hide();
            }
            count--;
          }, 1000);
      });
    </script>
//comment added new
<?php } ?>
<?php
/*
$arrayColor = array(
    'bg-orange-dark',
    'bg-teal-light',
    'bg-pink-light',
    'bg-purple-light',
	'bg-blue-light',
	'bg-pink-light',
	'bg-teal-light',
	'bg-orange-dark',
    'bg-pink-light',
    'bg-purple-light',
	'bg-blue-light',
	'bg-pink-light',
	'bg-teal-light',
    'bg-pink-light'
);
*/

$arrayColor = array(
    'txt-bg-colr1',
    'txt-bg-colr2',
    'txt-bg-colr3',
        'txt-bg-colr4',
        'txt-bg-colr5',
        'txt-bg-colr6',
        'txt-bg-colr7',
    'txt-bg-colr8',
    'txt-bg-colr9',
        'txt-bg-colr10',
        'bg-pink-light',
        'bg-teal-light',
    'bg-pink-light'
);

function allModuleArray($roleID='1', $dashboardWidget) {
  $userAllModuleArray = array(
    $roleID => array(
       'service_provider' => $dashboardWidget['service_providers'],
        'bookings'   => $dashboardWidget['bookings'],
        'customers'   => $dashboardWidget['customers'],
        'branch'   => $dashboardWidget['branches']
    )
  );
  return $userAllModuleArray;

  return $userAllModuleArray;
}
$wdgets = array();
foreach($dashboardWidget as $key => $value){
    if($key != 'allmenu' && $key != 'allmenulang'){
        $widget[$key] = !is_object($value)?$value:$value->count;
    }
} 
$userArray[$this->session->userdata('roleID')] = $widget;
$generateBoxArray = array();
$counter = 0;
$getActiveUserID = $this->session->userdata('roleID');
$getAllSessionDatas = $this->session->userdata('master_permission_set');

foreach ($getAllSessionDatas as $getAllSessionDataKey => $getAllSessionData) {
    if($getAllSessionData == 'yes') {     
        if(isset($userArray[$getActiveUserID][$getAllSessionDataKey])) {
				
           /*  if($counter == 4) {
              break;
            } */

            $generateBoxArray[$getAllSessionDataKey] = array(
                'icon' => $dashboardWidget['allmenu'][$getAllSessionDataKey]?$dashboardWidget['allmenu'][$getAllSessionDataKey]:$dashboardWidget[$getAllSessionDataKey]->icon,
                'color' => $arrayColor[$counter],
                'link' => $dashboardWidget[$getAllSessionDataKey]->link?$dashboardWidget[$getAllSessionDataKey]->link:$getAllSessionDataKey,
                'count' => $userArray[$getActiveUserID][$getAllSessionDataKey],
                'menu' => $dashboardWidget['allmenulang'][$getAllSessionDataKey]?$dashboardWidget['allmenulang'][$getAllSessionDataKey]:$dashboardWidget[$getAllSessionDataKey]->menu,
            );
            $counter++;
        }		
    }
}

//print_r($generateBoxArray); exit;
?>
<div id="notice-warning" style="display:none;" class="col-md-12">
    <div class="alert alert-warning" style="margin-top:20px;">
        <i class="fa fa-check-circle"></i>
        <ul id="notice-list">
        </ul>
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
</div>
<?php
if(count($generateBoxArray)) {
    $i=1;
    foreach ($generateBoxArray as $generateBoxArrayKey => $generateBoxValue) { ?>
          <div class="col-lg-3 col-xs-6">
                  <div class="small-box ">
                          <a class="small-box-footer" href="<?=base_url($generateBoxValue['link'])?>">
                                  <div class="icon" style="padding: 9.5px 18px 8px 18px;">
                                      <div class="icon-box<?= $i ?>">
                                         <i class="fa <?=$generateBoxValue['icon']?>"></i>
                                         </div>
                                  </div>
                                  <div class="inner">
                                          <h3 class="text-white">
                                                  <?=$generateBoxValue['count']?>
                                          </h3 class="text-white">
                                          <p class="txt-box <?=$generateBoxValue['color']?>">
                                                  <?php echo $generateBoxValue['menu']; ?>
                                          </p>
                                  </div>
                          </a>
                  </div>
          </div>
  <?php
  $i++;

    }
    } ?>
</div>
<!--<a class="btn btn-danger" href="<?=base_url('report/dragchart1')?>"> <b>Drag chart type 2 <b></a>-->
<script>
<?php if($show_notice){ ?>
   $('#notice-list').html('<?=$show_notice?>');
   $('#notice-warning').css('display','block');
<?php } ?>
</script>
