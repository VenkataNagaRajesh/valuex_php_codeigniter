<?php $this->load->view("components/page_header"); ?>
<?php $this->load->view("components/page_topbar"); ?>
<?php $this->load->view("components/page_menu"); ?>

        <aside class="right-side">
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <?php 
                          if(($this->session->userdata('usertypeID') == 1 || $this->session->userdata('usertypeID') == 5) && ($this->data["siteinfos"]->show_performance == 1)){
                            $this->benchmark->mark('code_start');
                            $this->load->view($subview);
                            $this->benchmark->mark('code_end');                                                 
                          } else {
                            $this->load->view($subview); 
                          } ?>
                    </div>
                </div>
            </section>
        </aside>

        <footer class="main-footer col-md-12">
            <div class="col-md-4">
                <strong><?=$siteinfos->footer?></strong>
            </div>
            <div class="col-md-4">
                <div>
                    <?php 
                        if(($this->session->userdata('usertypeID') == 1 || $this->session->userdata('usertypeID') == 5) && ($this->data["siteinfos"]->show_performance == 1)){         
                            echo "<b> Time : </b>".$this->benchmark->elapsed_time('code_start', 'code_end').' sec';
                            echo "<b> | Memory Usage : </b>".$this->benchmark->memory_usage();  
                                $queries = $this->db->queries;
                                if($this->session->userdata('usertypeID') == 5){      
                            echo "<b> | Queries : </b>".count($queries);
                                }
                      
                                    }              ?>  
                 </div>
            </div>
            <div class="col-md-4">
                <div class="hidden-xs">
                    <!--<b>v</b> <?=config_item('ini_version')?>-->
                    <a href="<?=base_url()?>">www.valuex.sweken.com</a>
                </div>
          	</div>
			
        </footer>
<?php $this->load->view("components/page_footer"); ?>


