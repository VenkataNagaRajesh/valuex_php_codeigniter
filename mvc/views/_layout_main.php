<?php $this->load->view("components/page_header"); ?>
<?php $this->load->view("components/page_topbar"); ?>
<?php $this->load->view("components/page_menu"); ?>

        <aside class="right-side">
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <?php 
                          $this->benchmark->mark('code_start');
                            $this->load->view($subview);
                          $this->benchmark->mark('code_end');
                          echo "<b> Time : </b>".$this->benchmark->elapsed_time('code_start', 'code_end');
                          echo "<b> | Memory Usage : </b>".$this->benchmark->memory_usage();  
                          $queries = $this->db->queries;
                         // print_r($queries);
                          echo "<b> | Queries : </b>".count($queries);
                          echo "<br>";                           
                           ?>
                    </div>
                </div>
            </section>
        </aside>

        <footer class="main-footer">
          	<div class="pull-right hidden-xs">
            	<!--<b>v</b> <?=config_item('ini_version')?>-->
				<a href="<?=base_url()?>">www.valuex.sweken.com</a>
          	</div>
          	<strong><?=$siteinfos->footer?></strong>
			
        </footer>
<?php $this->load->view("components/page_footer"); ?>


