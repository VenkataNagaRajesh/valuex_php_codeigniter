   <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="image" style="text-align:center;">
                           <?php if($this->session->userdata('photo') == 'defualt.png' || empty($this->session->userdata('photo'))){ ?>                               
                               <span class="user-icon"><i class="fa fa-user"></i></span>
							  <?php }else{ ?>
							   <img src="<?=base_url("uploads/images/".$this->session->userdata('photo')); 
                                ?>" class="user-logo" alt="" />
							  <?php } ?>
                        </div>

                        <div class="info" style="text-align:center;">
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
							
							<?php if($this->session->userdata('usertypeID') != 1){ 
								$carray[0] = 'Select Carrier';
								      foreach($loginairlines as $airline){ 
								        $carray[$airline->vx_aln_data_defnsID] = $airline->code;
									  }
							   echo '<div class="col-sm-12 airline-type">';
							   echo form_dropdown("login_airline", $carray,set_value("login_airline",$this->session->userdata('default_airline')), "id='login_airline' class='form-control' "); 
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