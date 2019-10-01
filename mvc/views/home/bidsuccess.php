<div class="container top-bar">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-2">
				<img class="img-responsive" src="<?php echo base_url('assets/home/images/emir.png'); ?>" alt="logo">
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-1">
			<img class="img-responsive" src="<?php echo base_url('assets/home/images/temp2-logo.jpg'); ?>" alt="logo">
		</div>
		<div class="col-md-11">
			<div class="bid-strip"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="bid-success-box">
				<p class="congo-info"><span>Congratulations,</span> your bid has been Successfully Submitted</p>
				<p class="track-info">
					<span>What to do Now:</span><br>
					Lorem Ipsum is simply dummy text of the Printing and typecasting Industry. Lorem Ipsum has been the Industry's Standard Dummy Text ever since the 1500s,
				</p>
				<p><b><span style="color:#ff6633;">Bid Summary : </span> Bid Reference No : <?=$offer_data->pnr_ref?></b></p>
				<div class="table">
					<table class="table-hover">
						<thead>
							<tr>
								<th scope="col">Date</th>
								<th scope="col">Flight</th>
								 <th scope="col">Time</th>
								<th scope="col">Origin</th>
								<th scope="col">Destination</th>
								<th scope="col">Cabin</th>
								<th scope="col">Seat No</th>
								<th scope="col">Offer</th>
							</tr>
						</thead>
					  <tbody>
							<tr>
								<td>13/06/2019</td>
								<td><?=$offer_data->carrier_code.$offer_data->flight_number?></td>
								<td>13:15 pm</td>
								<td><?=$offer_data->from_city?></td>
								<td><?=$offer_data->to_city?></td>
								<td>Business Class</td>
								<td><?=$offer_data->cabin?></td>
								<td>$775 USD</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="note-ex-info">
					<p>
						<span>(Note : Prices Shown are in united Sates Dollars.)</span><br>
						<span>Welcome Onboard!</span>
					</p>
					<p><b>Valuex Travels,</b> Emirates Airlines</p>
					<p class="web-link">
						<span>----</span><br>
						<span>www.valuex.com</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>