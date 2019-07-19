<div class="container top-bar">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-2">
				<img class="img-responsive" src="www.valuex.sweken.comassets/home/images/emir.png" alt="logo">
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-1">
			<img class="img-responsive" src="www.valuex.sweken.comassets/home/images/temp2-logo.jpg" alt="logo">
		</div>
		<div class="col-md-11">
			<div class="bid-strip"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="bid-success-box">
				<p class="congo-info"><span>Congratulations {first_name}</span></p>
				<p>Emirates Airlines has accepted your Upgrade Offer!</p>
				<ul class="upgrade-list">
					<li>Your Flight has been Upgraded to {to_cabin} at the Time of your Check-in, You will Receive a Business boarding pass</li>
					<li>You will also Shortly Receive a new E-ticket via Email reflecting this Upgrade!</li>
				</ul>
				<p class="track-info">
					<span>Summary of your Upgrade</span>
				</p>
				<div class="table">
					<table class="table-hover">
						<thead>
							<tr>
								<th scope="col">Date</th>
								<th scope="col">Flight</th>
								 <th scope="col">Time</th>
								<th scope="col">Origin</th>
								<th scope="col">Destination</th>
								<th scope="col">Upgraded to</th>
								<th scope="col">Offer</th>
							</tr>
						</thead>
					  <tbody>
					      {offer_list}
							<tr>
								<td>{date_start}</td>
								<td>{flight_no}</td>
								<td>{time}</td>
								<td>{origin}</td>
								<td>{destination}</td>
								<td>{upgrade_to}</td>
								<td>{cash_paid}</td>
							</tr>
						 {/offer_list}
						</tbody>
					</table>
				</div>
				<div class="note-ex-info col-md-9">
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
				<div class="col-md-3">
					<div class="upgrade-card-info">
						<ul>
							<li><span>Card No:</span> {card_no}</li>
							<li><span>Cash Paid:</span> {cash_paid}</li>
							<li><span>Loyality No:</span> 134568</li>
							<li><span>Miles Used:</span> {miles_used} Miles</li>
						</ul>
					</div>
					<div class="share">
						<p>Share:</p>
						<ul>
							<li><i class="fa fa-facebook"></i></li>
							<li><i class="fa fa-twitter"></i></li>
							<li><i class="fa fa-pinterest"></i></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>