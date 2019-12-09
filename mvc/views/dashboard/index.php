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

function allModuleArray($usertypeID='1', $dashboardWidget) {
  $userAllModuleArray = array(
    $usertypeID => array(
       'service_provider' => $dashboardWidget['service_providers'],
        'bookings'   => $dashboardWidget['bookings'],
        'customers'   => $dashboardWidget['customers'],
        'branch'   => $dashboardWidget['branches']
    )
  );
  return $userAllModuleArray;
}

$userArray = array(
 '1' => array(
        'marketzone'        => $dashboardWidget['marketzone'],
        'season'            => $dashboardWidget['season'],
        'airports_master'   => $dashboardWidget['airports'],
        'client'            => $dashboardWidget['clients'],
		'user'              => $dashboardWidget['users'],
 		'acsr'              => $dashboardWidget['acsr'],
		'eligibility_exclusion'=> $dashboardWidget['eerule'],
		'sent_offer_mails'  => $dashboardWidget['sent_offer_mails']->count,
		'bid_complete'      => $dashboardWidget['bid_complete']->count,
		'feedback'          => $dashboardWidget['feedback']->count
  ),
  '5' => array(
        'marketzone'        => $dashboardWidget['marketzone'],
        'season'            => $dashboardWidget['season'],
        'airports_master'   => $dashboardWidget['airports'],
        'client'            => $dashboardWidget['clients'],
		'user'              => $dashboardWidget['users'],
 		'acsr'              => $dashboardWidget['acsr'],
		'eligibility_exclusion'=> $dashboardWidget['eerule'],
		'sent_offer_mails'  => $dashboardWidget['sent_offer_mails']->count,
		'bid_complete'      => $dashboardWidget['bid_complete']->count,
		'feedback'          => $dashboardWidget['feedback']->count
  ),
  '2' => array(
        'marketzone'        => $dashboardWidget['marketzone'],
        'season'            => $dashboardWidget['season']
  ),
  '3' => array(
        'marketzone'        => $dashboardWidget['marketzone'],
        'season'            => $dashboardWidget['season'],
        'airports_master'   => $dashboardWidget['airports'],
        'client'            => $dashboardWidget['clients'],
		'user'              => $dashboardWidget['users'],
 		'acsr'              => $dashboardWidget['acsr'],
		'eligibility_exclusion'=> $dashboardWidget['eerule'],
		'sent_offer_mails'  => $dashboardWidget['sent_offer_mails']->count,
		'bid_complete'      => $dashboardWidget['bid_complete']->count
  ),
 '4' => array(
        'marketzone'        => $dashboardWidget['marketzone'],
        'season'            => $dashboardWidget['season'],
        'airports_master'   => $dashboardWidget['airports'],
        'client'            => $dashboardWidget['clients'],
		'user'              => $dashboardWidget['users'],
 		'acsr'              => $dashboardWidget['acsr'],
		'eligibility_exclusion'=> $dashboardWidget['eerule'],
		'sent_offer_mails'  => $dashboardWidget['sent_offer_mails']->count,
		'bid_complete'      => $dashboardWidget['bid_complete']->count
  )  
);
//print_r($userArray); exit;
$generateBoxArray = array();
$counter = 0;
$getActiveUserID = $this->session->userdata('usertypeID');


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
if(count($generateBoxArray)) {  
    foreach ($generateBoxArray as $generateBoxArrayKey => $generateBoxValue) { ?>
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
						  <?php echo $generateBoxValue['menu']; ?>
					  </p>
				  </div>
			  </a>
		  </div>
	  </div>  
  <?php } 
    } ?>
</div>






