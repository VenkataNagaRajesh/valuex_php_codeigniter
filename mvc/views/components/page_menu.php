   <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <!--<img style="display:block" src="<?=base_url("uploads/images/".$this->session->userdata('photo'));
                                ?>" class="img-circle" alt="" />-->
							<span class="user-icon"><i class="fa fa-user"></i></span>
                        </div>

                        <div class="pull-left info">
                            <?php
                                $name = $this->session->userdata("name");
                                if(strlen($name) > 11) {
                                   $name = substr($name, 0,11). "..";
                                }
                                echo "<p>".$name."</p>";
                            ?>
							
							
                            <a href="<?=base_url("profile/index")?>">
                                <i class="fa fa-hand-o-right color-green"></i>
                                <?=$this->session->userdata("usertype")?>
                            </a>
							
							<?php if($this->session->userdata('usertypeID') == 2 && $this->router->fetch_class()=='dashboard'){ 
								$carray[0] = 'Select Carrier';
								      foreach($loginairlines as $airline){ 
								        $carray[$airline->vx_aln_data_defnsID] = $airline->code;
									  }
							   echo '<div class="col-sm-12 airline-type">';
							   echo form_dropdown("login_airline", $carray,set_value("login_airline",$carrier), "id='login_airline' class='form-control' "); 
								echo '</div>';  
							 } ?>
						
                        </div>
						
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <?php $usertype = $this->session->userdata("usertype"); ?>
                    <ul class="sidebar-menu custom-menu">
                        <?php
                            if(count($dbMenus)) {
                                $menuDesign = '';
                                display_menu($dbMenus, $menuDesign);
                                echo $menuDesign;
                            }
                        ?>

                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
			
			<script>
			  $('#login_airline').change( function(){
				if($(this).val() == 0){
				  window.location = "<?=base_url('dashboard/index')?>"; 	
				} else {
				  window.location = "<?=base_url('dashboard/index?carrier=')?>" +$(this).val();
				}
			  });
			
			</script>