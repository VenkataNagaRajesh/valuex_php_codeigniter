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

 <?php

                        $list = array_column($ofr,'offer_id');
                        $offer_id = $list[0];
                        $p_cnt = count(explode('<br>',$ofr[0]->p_list));
                        $pnr_ref = array_column($ofr,'pnr_ref');
			$total_bid_price = array_sum(array_column($ofr,'bid_value'));
			$total_cash_paid = array_sum(array_column($ofr,'cash'));
			$cash_percentage =  round($total_cash_paid*100/$total_bid_price);
			$miles_percentage = round(100 - $cash_percentage);
                ?>

			<p>
				<span>Offer AND BID Information</span>
				<span>Offer Id:<?php echo $ofr[0]->offer_id?></span>
				<span>Offer Date:<?php echo date('d/m/Y',$ofr[0]->offer_date)?></span>
			</p>
		</div>
		<div class="off-pass-dtls">


			<p>
				<span>Passenger Details:</span>
				<span><b>PNR :<?php echo $ofr[0]->pnr_ref?></b></span>
				<span><b>No of passengers :<?php echo $p_cnt?></b></span>
			</p>
		</div>
		<div class="off-list">
			<ul>

			<?php  
				$ps_data = explode('<br>',$ofr[0]->p_list);
				
				foreach ($ps_data as $pp ) {
					$p = explode(':', $pp);
					$tier_array = array('1' => 'Platinum', '2' => 'Gold', '3' => 'Silver','4' => 'Bronze');
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

			<div class="auto-gen">
                                <?php
                                        $offer_list = $this->session->userdata('offers_list_view');
                                        $cur_key = array_search($offer_id,$offer_list);
                                        $next_offer = $offer_list[$cur_key + 1 ];
                                        $prev_offer = $offer_list[$cur_key - 1 ];
                                ?>

				<?php if($prev_offer) {?>
                                 <a href="<?php echo base_url('offer_table/view/'.$prev_offer) ?>">
                                 Prev
                                </a>
				<?php }?>
                                &nbsp;&nbsp;
				<?php if($next_offer) { ?>
                           		<a href="<?php echo base_url('offer_table/view/'.$next_offer) ?>">
                                 	Next
                        		</a>
				<?php } ?>
				
                        </div>



			<p><b>Offer Price</b><br>
				<span>Total Price:</span><?php echo array_sum(array_column($ofr,'bid_value'));?><br>
				<span>Mode:</span> <?php echo $cash_percentage;?>%  Cash, <?php echo $miles_percentage?>% Miles<br>
				<span>Miles:</span> <?php echo number_format(array_sum(array_column($ofr,'miles')));?> <br>
				<span>Cash:</span> <?php echo array_sum(array_column($ofr,'cash'));?>
			</p>
		</div>
	</div>
<?php if ( isset($upgrade_offer) && $upgrade_offer) {
?>
	<div class="col-md-12">
	<h4>Upgrade Details</h4>
		<div class="table-responsive">
			<table class="table-hover">
				<thead>
					<tr>
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

				<?php foreach ($ofr as $data ) {
					if($data->productID==1){
					  $inv = array();
			                        $inv['flight_nbr'] = $data->flight_number;
                        			$inv['airline_id'] = $data->carrier_code;
                        			$inv['departure_date'] = $data->flight_date;
						$inv['origin_airport'] = $data->from_city_code;
						$inv['dest_airport'] = $data->to_city_code;
						$inv['cabin'] = $data->upgrade_type;
			                        $seats_data = $this->invfeed_m->getEmptyCabinSeats($inv);
                        			$empty_seats = $seats_data->empty_seats - $seats_data->sold_seats;
				?>

					<tr>
			
						<td><?=$data->carrier.$data->flight_number?></td>
						<td><?php echo date('d/m/Y',$data->flight_date)?></td>
						<td><?php echo $data->from_city;?></td>
						<td><?php echo $data->to_city;?></td>
						<td><?php echo $data->from_cabin;?></td>
						<td><?php echo $data->to_cabin;?></td>
						<td><?php echo $data->bid_value;?></td>
						<td><?php echo $p_cnt * $data->min;?></td>
						<td><?php echo $p_cnt * $data->max;?></td>
						<td><?php echo $data->rank;?></td>
						<td><?php echo $empty_seats ? $empty_seats : 0 ?></td>


						<td>
						<?php
							if ($data->offer_status == 'Bid Received' ) { 
						?>
				<a href="<?php echo base_url('offer_table/processbid/'.$data->offer_id.'/'.$data->flight_number.'/accept'); ?>" onclick="<?php if( $empty_seats < $p_cnt) {?> alert('Insufficient seats'); return false; <?php } ?> ; var status = '<?php echo $data->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"><i class="fa fa-check-circle" aria-hidden="true"></i> </a>

					<a href="<?php echo base_url('offer_table/processbid/'.$data->offer_id.'/'.$data->flight_number.'/reject'); ?>"  onclick="var status = '<?php echo $data->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"  ><i class="fa fa-times-circle-o" aria-hidden="true"></i></a></td>

							<?php } else {
								echo $data->offer_status;
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
?>
	<h4>Baggage Details</h4>
		<div class="table-responsive">
		
			<table class="table-hover">
				<thead>
					<tr>
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

				<?php foreach ($ofr as $data ) {
					if($data->productID==2){
					  $inv = array();
			                        $inv['flight_nbr'] = $data->flight_number;
                        			$inv['airline_id'] = $data->carrier_code;
                        			$inv['departure_date'] = $data->flight_date;
						$inv['origin_airport'] = $data->from_city_code;
						$inv['dest_airport'] = $data->to_city_code;
						$inv['cabin'] = $data->from_cabin;
						$seats_data = $this->invfeed_m->getSoldWeight($inv);
                        			$empty_seats = $seats_data->empty_seats - $seats_data->sold_seats;
				?>

					<tr>
			
						<td><?=$data->carrier.$data->flight?></td>
						<td><?php echo date('d/m/Y',$data->flight_date)?></td>
						<td><?php echo $data->from_city;?></td>
						<td><?php echo $data->to_city;?></td>
						<td><?php echo $data->from_cabin;?></td>
						<td><?php echo $data->bid_value;?></td>
						<td><?php echo $data->weight;?></td>
						<td>
						<?php
							if ($data->offer_status == 'Bid Received' ) { 
						?>
				<a href="<?php echo base_url('offer_table/processbid/'.$data->offer_id.'/'.$data->flight_number.'/accept'); ?>" onclick="<?php if( $empty_seats < $p_cnt) {?> alert('Insufficient seats'); return false; <?php } ?> ; var status = '<?php echo $data->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"><i class="fa fa-check-circle" aria-hidden="true"></i> </a>

					<a href="<?php echo base_url('offer_table/processbid/'.$data->offer_id.'/'.$data->flight_number.'/reject'); ?>"  onclick="var status = '<?php echo $data->offer_status; ?>'; if( status != 'Bid Received' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"  ><i class="fa fa-times-circle-o" aria-hidden="true"></i></a></td>

							<?php } else {
								echo $data->offer_status;
								
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
