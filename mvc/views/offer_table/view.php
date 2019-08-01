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
			$cash_percentage =  $ofr[0]->cash_percentage;
			$miles_percentage = round(100 - $cash_percentage);
                ?>

			<p>
				<span>Offer AND BID Information</span>
				<span>Offer Id:<?php echo $ofr[0]->offer_id?></span>
				<span>Request:<?php echo date('d/m/Y',$ofr[0]->offer_date)?></span>
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
			<p>Passenger type : <b>Leisure</b></p>
			<p><strong>Contact Info</strong><br>
				<span>Email:</span><b><?php echo $pp_data[2]?></b><br>
				<span>Phone:</span><b><?php echo $pp_data[3]?></b>
			</p>
			<div class="off-comment"><p><strong>Autopillot comment</strong> : Queed for analyst evaluation</p></div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="off-status">
			<p><b>Offer Price</b><br>
				<span>Total Price:</span><?php echo array_sum(array_column($ofr,'bid_value'));?><br>
				<span>Mode:</span> <?php echo $cash_percentage;?>%  Cash, <?php echo $miles_percentage?>% Miles<br>
				<span>Miles:</span> <?php echo array_sum(array_column($ofr,'miles'));?> <br>
				<span>Cash:</span> <?php echo array_sum(array_column($ofr,'cash'));?>
			</p>
		</div>
	</div>
	<div class="col-md-12">
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
					  $inv = array();
			                        $inv['flight_nbr'] = $data->flight_number;
                        			$inv['airline_id'] = $data->carrier_code;
                        			$inv['departure_date'] = $data->flight_date;
						$inv['origin_airport'] = $data->from_city_code;
						$inv['dest_airport'] = $data->to_city_code;
						$inv['cabin'] = $data->to_cabin_code;
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
						<td>3</td>
						<td><?php echo $empty_seats ? $empty_seats : 0 ?></td>


						<td>
						<?php
							if ($data->offer_status == 'Bid Completed' ) { 
						?>
				<a href="<?php echo base_url('offer_table/processbid/'.$data->offer_id.'/'.$data->flight_number.'/accept'); ?>" onclick="<?php if( $empty_seats < $p_cnt) {?> alert('Insufficient seats'); return false; <?php } ?> ; var status = '<?php echo $data->offer_status; ?>'; if( status != 'Bid Completed' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"><i class="fa fa-check-circle" aria-hidden="true"></i> </a>

					<a href="<?php echo base_url('offer_table/processbid/'.$data->offer_id.'/'.$data->flight_number.'/reject'); ?>"  onclick="var status = '<?php echo $data->offer_status; ?>'; if( status != 'Bid Completed' )  {alert('Bid Status should be in Complete state but the Bid Status ' + status  ); return false;}"  ><i class="fa fa-times-circle-o" aria-hidden="true"></i></a></td>

							<?php } else {
								echo $data->offer_status;
							}?>
					</tr>
			<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>
