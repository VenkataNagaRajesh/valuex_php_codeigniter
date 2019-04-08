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

<?php } ?>
<?php
$arrayColor = array(
    'bg-orange-dark',
    'bg-teal-light',
    'bg-pink-light',
    'bg-purple-light'
);

function allModuleArray($usertypeID='1', $dashboardWidget) {
  $userAllModuleArray = array(
    $usertypeID => array(      
        'event'     => $dashboardWidget['events'],
        'issue'     => $dashboardWidget['issues'],
        'holiday'   => $dashboardWidget['holidays'],
        'invoice'   => $dashboardWidget['invoices'],
    )
  );
  return $userAllModuleArray;
}

$userArray = array(
  '1' => array(
        'event'     => $dashboardWidget['events'],
        'issue'     => $dashboardWidget['issues'],
        'holiday'   => $dashboardWidget['holidays'],
        'invoice'   => $dashboardWidget['invoices']
  )
);

$generateBoxArray = array();
$counter = 0;
$getActiveUserID = $this->session->userdata('usertypeID');
$getAllSessionDatas = $this->session->userdata('master_permission_set');
foreach ($getAllSessionDatas as $getAllSessionDataKey => $getAllSessionData) {
    if($getAllSessionData == 'yes') {
        if(isset($userArray[$getActiveUserID][$getAllSessionDataKey])) {
            if($counter == 4) {
              break;
            }

            $generateBoxArray[$getAllSessionDataKey] = array(
                'icon' => $dashboardWidget['allmenu'][$getAllSessionDataKey],
                'color' => $arrayColor[$counter],
                'link' => $getAllSessionDataKey,
                'count' => $userArray[$getActiveUserID][$getAllSessionDataKey],
                'menu' => $dashboardWidget['allmenulang'][$getAllSessionDataKey],
            );
            $counter++;
        }

    }
}


$icon = '';
$menu = '';
if($counter < 4) {
  $userArray = allModuleArray($getActiveUserID, $dashboardWidget);
  foreach ($getAllSessionDatas as $getAllSessionDataKey => $getAllSessionData) {
      if($getAllSessionData == 'yes') {
          if(isset($userArray[$getActiveUserID][$getAllSessionDataKey])) {
              if($counter == 4) {
                break;
              }

              if(!isset($generateBoxArray[$getAllSessionDataKey])) {
                  $generateBoxArray[$getAllSessionDataKey] = array(
                      'icon' => $dashboardWidget['allmenu'][$getAllSessionDataKey],
                      'color' => $arrayColor[$counter],
                      'link' => $getAllSessionDataKey,
                      'count' => $userArray[$getActiveUserID][$getAllSessionDataKey],
                      'menu' => $dashboardWidget['allmenulang'][$getAllSessionDataKey]
                  );
                  $counter++;
              }
          }

      }
  }
}

if(count($generateBoxArray)) {
    foreach ($generateBoxArray as $generateBoxArrayKey => $generateBoxValue) {
?>
  <div class="col-lg-3 col-xs-6">
      <div class="small-box ">
          <a class="small-box-footer <?=$generateBoxValue['color']?>" href="<?=base_url($generateBoxValue['link'])?>">
              <div class="icon <?=$generateBoxValue['color']?>" style="padding: 9.5px 18px 8px 18px;">
                  <i class="fa <?=$generateBoxValue['icon']?>"></i>
              </div>
              <div class="inner ">
                  <h3 class="text-white">
                      <?=$generateBoxValue['count']?>
                  </h3 class="text-white">
                  <p class="text-white">
                      <?=$this->lang->line('menu_'.$generateBoxValue['menu'])?>
                  </p>
              </div>
          </a>
      </div>
  </div>

<?php
    }
}

?>
</div>


