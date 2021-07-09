<div class="box">
  <div class="box-header" style="width:100%;">
  </div>
        <h3 class="box-title"><?=$this->lang->line('panel_title')?></h3>       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><?=$this->lang->line('menu_dashboard')?></a></li>
			<li><a href="<?=base_url("$return/index")?>"><?="Back"?></a></li>
            <li class="active"><?=$this->lang->line('panel_title')?> <?="view"?></li>
        </ol>
  <!-- /.box-header -->
  <div class="off-dtl-page">
	<div class="col-md-8">
		<div class="title-bar">
		</div>
		<div class="off-pass-dtls">


			<p>
				<span>Passenger Details:</span>
				<span><b>PNR :<?php echo $pnr_ref?></b></span>
				<span><b>No of passengers :<?php echo $paassenger_cnt?></b></span>
			</p>
		</div>
		<div class="off-list">
			<ul>

			<?php  
				foreach ($ps_data as $pp ) {
					$p = explode(':', $pp);
					?>
				<li><span><?php echo $p[0];?></span><span><?php echo $p[1];?></span><span><?php echo $p[4];?></span><span><?php echo $tier_array[$p[5]];?></span></li>
				<?php }?>
			</ul>

			<?php $pp_data = explode(':',$ps_data[0]);?>
			<p><strong>Contact Info</strong><br>
				<span>Email:</span><b><?php echo $pp_data[2]?></b><br>
				<span>Phone:</span><b><?php echo $pp_data[3]?></b>
			</p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="off-status">
			<p><b>Offer Payment Summary </b><br>
				<span>Order #: </span>  <?php echo $offer_dt_full_total->orders;?><br>
				<span><nobr>Total Payment: </span> $ <?php echo $offer_dt_full_total->amount;?></nobr><br>
				<span>Cash: </span> $ <?php echo $offer_dt_full_total->cash;?><br>
				<span>Miles: </span> <?php echo $offer_dt_full_total->miles;?><br>
<?php
				$cash_percentage = round(($offer_dt_full_total->cash*100)/$offer_dt_full_total->amount);
				$miles_percentage = round(100 - $cash_percentage); 
?>
				<span><nobr>Payment Mode:&nbsp;&nbsp; </span> <?php echo $cash_percentage . "%  Cash, " . $miles_percentage . "% Miles</nobr>";?>
			</p>
		</div>
	</div>
	<div class="col-md-12">
<?php if ( isset($upgrade_offer) && $upgrade_offer) {
				foreach ($offer_dt_sub_total as $dt ) {
					if($dt->productID==1){
						$ofr = $dt;
					break;
					}
				}
?>
	<h4>Upgrade Details</h4>
			<p>
				<span><b>Offer Id:&nbsp; </b><?php echo $ofr->offer_id?></span>
				&nbsp;&nbsp;<span><b>Offer Date:&nbsp; </b><?php echo date('d/m/Y',$ofr->offer_date)?></span>
				&nbsp;&nbsp;<span><b>Bid Value:&nbsp;$ </b><?php echo $ofr->bid_value?></span>
			</p>
		<div class="table-responsive">
			<table class="table-hover">
				<thead>
					<tr>
						<th>BID ID</th>
						<th>Flight</th>
						<th>Date</th>
						<th>Origin</th>
						<th>Desti</th>
						<th>Booked C/R</th>
						<th>Upgrade Cabin</th>
						<th>Offer Price</th>
						<th>Min</th>
						<th>Max</th> 
						<th>Rank</th>
						<th>Avial seats</th>
						<th>Accept / Reject</th>
					</tr>
				</thead>
				<tbody>

				<?php foreach ($offer_dt as $dt ) {
					if($dt->productID==1){
					  $inv = array();

					$inv['flight_nbr'] = $dt->flight_number;
					$inv['airline_id'] = $dt->carrier_code;
					$inv['departure_date'] = $dt->flight_date;
						$inv['origin_airport'] = $dt->from_city_code;
						$inv['dest_airport'] = $dt->to_city_code;
						$inv['cabin'] = $dt->upgrade_type;
			            $seats_data = $this->invfeed_m->getEmptyCabinSeats($inv);
                       	$empty_seats = $seats_data->empty_seats - $seats_data->sold_seats;
				?>

					<tr>
			
						<td><?=$dt->bid_id?></td>
						<td><?=$dt->carrier.$dt->flight_number?></td>
						<td><?php echo date('d/m/Y',$dt->flight_date)?></td>
						<td><?php echo $dt->from_city;?></td>
						<td><?php echo $dt->to_city;?></td>
						<td><?php echo $dt->from_cabin;?></td>
						<td><?php echo $dt->to_cabin;?></td>
						<td><?php echo $dt->bid_value;?></td>
						<td><?php echo $dt->min;?></td>
						<td><?php echo $dt->max;?></td>
						<td><?php echo $dt->rank;?></td>
						<td><?php echo $empty_seats ? $empty_seats : 0 ?></td>


						<td>
						<?php
							if(count($empty_seats)==0 || empty($empty_seats) || $empty_seats=='' || $empty_seats== NULL)
							{ ?>
						
								<a href="<?php echo base_url('offer_table/processbid/'.$dt->offer_id.'/'.$dt->flight_number.'/accept'); ?>" onclick="function(e){e.preventDefault();return false;}"><i class="fa fa-check-circle" aria-hidden="true"></i> </a>
						<?php	}
						
						
							else if ($dt->offer_status == 'Bid Received' ) { 
						?>
				<a href="<?php echo base_url('offer_table/processbid/'.$dt->offer_id.'/'.$dt->flight_number.'/accept'); ?>" onclick="<?php if( $empty_seats < $p_cnt) {?> alert('Insufficient seats'); return false; <?php } ?> ; var status = '<?php echo $dt->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"><i class="fa fa-check-circle" aria-hidden="true"></i> </a>

					<a href="<?php echo base_url('offer_table/processbid/'.$dt->offer_id.'/'.$dt->flight_number.'/reject'); ?>"  onclick="var status = '<?php echo $dt->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"  ><i class="fa fa-times-circle-o" aria-hidden="true"></i></a></td>

							<?php } else {
								echo $dt->offer_status;
							}?>
					</tr>
			<?php }?>
			<?php }?>
				</tbody>
			</table>
		</div>
	<?php } ?>
	</div>
	<div class="col-md-12">
<?php if ( isset($baggage_offer) && $baggage_offer) {
				foreach ($offer_dt_sub_total as $dt ) {
					if($dt->productID==2){
						$ofr = $dt;
					break;
					}
				}
?>
	<h4>Baggage Details</h4>
			<p>
				<span><b>Offer Id:&nbsp; </b><?php echo $ofr->offer_id?></span>
				&nbsp;&nbsp;<span><b>Offer Date:&nbsp; </b><?php echo date('d/m/Y',$ofr->offer_date)?></span>
				&nbsp;&nbsp;<span><b>Purchase Value:&nbsp;$ </b><?php echo $ofr->bid_value?></span>
			</p>
		<div class="table-responsive">
		
			<table class="table-hover">
				<thead>
					<tr>
						<th>BID ID</th>
						<th>Flight</th>
						<th>Date</th>
						<th>Origin</th>
						<th>Destination</th>
						<th>Booked C/R</th>
						<th>Offer Price</th>
						<th>Weight</th>
						<th>Accept / Reject</th>
					</tr>
				</thead>
				<tbody>

				<?php foreach ($offer_dt as $dt ) {
					if($dt->productID==2){
				?>

					<tr>
			
						<td><?=$dt->bid_id?></td>
						<td><?=$dt->carrier.$dt->flight?></td>
						<td><?php echo date('d/m/Y',$dt->flight_date)?></td>
						<td><?php echo $dt->from_city;?></td>
						<td><?php echo $dt->to_city;?></td>
						<td><?php echo $dt->from_cabin;?></td>
						<td><?php echo $dt->bid_value;?></td>
						<td><?php echo $dt->weight;?></td>
						<td>
						<?php
							if ($dt->offer_status == 'Bid Received' ) { 
						?>
				<a href="<?php echo base_url('offer_table/processbid/'.$dt->offer_id.'/'.$dt->ond.'/accept'); ?>" onclick="<?php if( $empty_seats < $p_cnt) {?> alert('Insufficient seats'); return false; <?php } ?> ; var status = '<?php echo $dt->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"><i class="fa fa-check-circle" aria-hidden="true"></i> </a>
&nbsp;&nbsp;&nbsp;
					<a href="<?php echo base_url('offer_table/processbid/'.$dt->offer_id.'/'.$dt->ond.'/reject'); ?>"  onclick="var status = '<?php echo $dt->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"  ><i class="fa fa-times-circle-o" aria-hidden="true"></i></a></td>

							<?php } else {
								echo $dt->offer_status;
								
							}?>
					</tr>
			<?php }?>
			<?php } ?>
				</tbody>			
			</table>
		</div>
	<?php } ?>
	</div>
</div>
</div>
