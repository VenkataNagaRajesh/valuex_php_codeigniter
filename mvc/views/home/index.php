<div id="fh5co-wrapper">
	<div id="fh5co-page">
		<div class="container top-bar">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<img class="img-responsive" src="<?php echo base_url('assets/home/images/emir.png'); ?>" alt="logo">
					</div>
				</div>
			</div>
		</div>
		<div class="fh5co-hero">
			<div class="fh5co-cover container">
				<img class="img-responsive" src="<?php echo base_url('assets/home/images/login-bg.png'); ?>" alt="login bg">
			</div>
		</div>
		<div class="container pnr-box">
			<div class="row">
				<div class="col-sm-5 col-md-4 col-md-offset-2">
					<div class="tabulation animate-box">
						<h2>Upgrade for Sure</h2>
					</div>
					<div class="tabulation animate-box">
						<iframe src="https://www.youtube.com/embed/_O2_nTt1N6w" width="100%" height="198"></iframe>
					</div>
				</div>
				<div class="col-sm-5 col-md-4">
							<span>	<?=$error?> </span>
							
					<div class="pnr-form">
						<form class="form-horizontal" method="post" role="form">
							<div class="form-group">
								<?php 
									if(form_error('pnr')) 
										echo "<div class='col-sm-12 has-error' >";
									else     
										echo "<div class='col-sm-12' >";
								  ?>
									<input type="text" class="form-control" id="pnr" name="pnr" placeholder="PNR" value="<?=set_value('pnr')?>" >
									 <span>
										<?php echo form_error('pnr'); ?>
									</span>
								</div>
							</div>
							<div class="form-group">
								<?php 
									if(form_error('code')) 
										echo "<div class='col-sm-12  has-error' >";
									else     
										echo "<div class='col-sm-12' >";
								  ?>								
									<input type="text" class="form-control" id="code" name="code" placeholder="Code" value="<?=set_value('code')?>" >
									 <span>
										<?php echo form_error('code'); ?>
									</span>
								</div>
							</div>
							<?php 
							   if(form_error('g-recaptcha-response')) 
							   	echo "<div class='col-md-12  has-error' style='margin-left:-6px;'>";
							   else     
							   	echo "<div class='col-md-12 hidden-xs' style='margin-left:-6px;'>";
							  ?>
								<?php echo $widget;?>
                                <?php echo $script;?>
								 <span>
										<?php echo form_error('g-recaptcha-response'); ?>
								 </span>
							</div>
							<div class="form-group">
								<div class="col-md-4 col-md-offset-4">
									<button type="submit" class="btn btn-dander btn-lg">Proceed</button>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<i class="more-less glyphicon glyphicon-chevron-down" aria-hidden="true"></i>
										Upgrade for Sure "UFS" Offer for INternational and Domestic Passengers
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
									  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
								</div>
							</div>
						</div>
					</div><!-- panel-group -->	
				</div>
			</div>
		</div>
	</div>
</div>


