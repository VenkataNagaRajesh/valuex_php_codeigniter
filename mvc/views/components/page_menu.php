            <!-- Left side column. contains the logo and sidebar -->
            <div class="sidebar-wrap">
            <aside class="left-side main-sidebar">
                
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
           <i class="right user-bx fa fa-user"></i>
        </div>
        <div class="pull-left info">
          <a href="#" class="d-block">
                	     <?php
                              $name = $this->session->userdata("name");
                              if(strlen($name) > 11) {
                                $name = substr($name, 0,11). "..";
                              }
                              echo "<p>".$name."</p>";
                             ?>
                	  </a>
        </div>
        <!-- search form -->
      <div class="sidebar-form">
                     <!--<a href="<?=base_url("profile/index")?>">-->
                     <!--    <i class="fa fa-hand-o-right color-orange"></i>-->
                     <!--    <?=$this->session->userdata("usertype")."->".$this->session->userdata("role")?>-->
                     <!-- </a>-->
            	<?php
            // 	if($this->session->userdata('usertypeID') == 1 && $this->session->userdata('roleID') != 1 && $this->session->userdata('roleID') != 5){ 
            // 	     $carray[0] = 'Select Carrier';
            // 	     foreach($loginairlines as $airline){ 
            // 	       $carray[$airline->vx_aln_data_defnsID] = $airline->code;
            // 	     }
            // 	     echo '<div class="col-sm-12 airline-type">';
            // 	     echo form_dropdown("login_airline", $carray,set_value("login_airline",$this->session->userdata('default_airline')), "id='login_airline' class='form-control' "); 
            // 	     echo '</div>';  
            // 	 }
            	 ?>
      </div>
      <!-- /.search form -->
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
          
           <?php 
        //   echo "<pre>";
        //   print_r($dbMenus);
        //   echo "</pre>";
           if(count($dbMenus) > 0){ foreach($dbMenus as $menu){
              $per = 1; if ($menu['link'] != '#'){
		if( permissionChecker($menu['link'])) { $per = 1;} else { $per = 0; }
                } else { if(count($menu['child'])>0){$per=1;} else { $per = 0; } }
               if($per == 1){ 
        ?>
    <?php if($menu['link']==$this->router->fetch_class()){
         $menuactive ='active';
        }  else {
            if(in_array($this->router->fetch_class(),array_column($menu['child'],'link'))){
              $menuactive ="active";
            } else {
            $menuactive ='';

           }
        }
    ?>
          <li class="treeview <?=(count($menu['child'])>0)?'has-treeview':''?> <?=$menuactive?>">
            <a href="<?= base_url($menu['link']) ?>" class="nav-link">
              <i class="nav-icon fa <?=$menu['icon']?>"></i>
              <span>
                <?=$menu['menuName']?></span>
                 <span class="pull-right-container">
                  <?php if(count($menu['child'])>0){ ?> <i class="right fa fa-angle-left"></i><?php } ?>
              </span>
            </a>
            <?php if(count($menu['child']) > 0) { ?>
            <ul class="treeview-menu">
            <?php foreach($menu['child'] as $child) {
                        if(permissionChecker($child['link'])) {
 ?>
              <li class="nav-item  <?=($child['link']==$this->router->fetch_class())?'active':''?>">
                <a href="<?=base_url($child['link'])?>" class="nav-link">
                  <i class="fa <?=$child['icon']?> nav-icon"></i>
                  <span><?=$child['menuName']?></span   >
                </a>
              </li>
            <?php } } ?>
            </ul>
            <?php } ?>
          </li>
        <?php } } } ?>
          
          
       <!--- <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="https://adminlte.io/themes/AdminLTE/index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="https://adminlte.io/themes/AdminLTE/index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="https://adminlte.io/themes/AdminLTE/pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> --->
      </ul>
    </section>
    <!-- /.sidebar -->
   
  </aside>
   </div>
			
			<script>
			  $('#login_airline').change( function(){
				  $.ajax({
					  async: false,
					  type: 'POST',
					  url: "<?=base_url('general/defaultAirline')?>",          
					  data: {"airline":$(this).val()},
					  dataType: "html",                     
					  success: function(data) {
						window.location.reload(true);			
					 }
				 });
			  });
			
			</script>
