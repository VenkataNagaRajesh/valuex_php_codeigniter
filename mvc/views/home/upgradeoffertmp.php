<!doctype html>
<html dir="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title></title>
<style>
	@media screen and (min-width: 320px) and (max-width: 850px) {
		.strip{
			float: none !important;
			width: 100% !important;
		}
		.note{
			width:100% !important;
		}
		.card{
			width:100% !important;
		}
	}
</style>
</head>
<body>
<div style="min-width: 245px;max-width: 1100px;position: relative;padding: 10px;margin:0 auto;font-family:century gothic;">
	<div style="margin-left:auto;margin-right:auto;width:100%;padding-left: 15px;padding-right: 15px;background: #333;">
		<img style="width:120px;" src="{base_url}assets/home/images/emir.png" alt="logo">
	</div>
	<div style="border: solid 1px #ddd;width:100%;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;display:inline-block;">
		<div style="width:100%;margin-top:10px;">
			<div style="width:10%;float:left;">
				<img style="width:auto;display: block;height:54px;" src="{base_url}assets/home/images/temp2-logo.jpg" alt="logo">
			</div>
			<div class="strip" style="width:90%;float:left;">
				<div style="background: #f5f5f5;height: 38px;margin: 16px 0;"></div>
			</div>
		</div>
		<div style="width:100%;">
			<p style="font-size: 14px;color: #ff6633;font-weight: bold;margin-right: 8px;">Congratulations {first_name} {last_name}</p>
			<p style="font-size: 14px;">Emirates Airlines has accepted your Upgrade Offer!</p>
			<ul>
				<li style="font-size: 14px;line-height:20px;margin: 0 0 12px;">Your Flight has been Upgraded to {upgrade_to} at the Time of your Check-in, You will Receive a {upgrade_to} boarding pass</li>
				<li style="font-size: 14px;line-height:20px;margin: 0 0 12px;">You will also Shortly Receive a new E-ticket via Email reflecting this Upgrade!</li>
			</ul>
			<p style="font-size: 14px;color:#ff6633;"><b>Summary of your Upgrade</b></p>
		</div>
		<div style="font-weight:500;position: relative;min-height: 1px;margin-top:10px;margin-bottom:10px;overflow: auto;width:100%;">
			<table style="border-collapse: collapse;border-spacing: 0;width:100%;">
				<thead style="background: #ff6633;color: #fff;text-transform: capitalize;">
					<tr style="white-space:nowrap;">
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Date</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Flight</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Time</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Origin</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Destination</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Cabin no</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Seat No</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Offer</th>
					</tr>
				</thead>
			  <tbody>
					<tr style="white-space:nowrap;">
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{dep_date}</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{carrier_code}{flight_number}</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{dep_time}</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{from_city}</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{to_city}</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{cabin} Class</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{seat_no}</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">${cash} USD</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="note" style="width:60%;position: relative;float:left;">
			<p style="font-size: 14px;">
				<span>(Note : Prices Shown are in united Sates Dollars.)</span><br>
				<span>Welcome Onboard!</span>
			</p>
			<p style="font-size: 14px;"><b>Valuex Travels,</b> Emirates Airlines</p>
			<p style="font-size: 14px;">
				<span style="font-weight: bold;color: #ff6633;">----</span><br>
				<span style="font-weight: bold;color: #ff6633;">www.valuex.com</span>
			</p>
		</div>
		<div class="card" style="width:40%;position: relative;float:left;">
			<div style="background: #f5f5f5;padding: 15px;margin-bottom: 10px;">
				<ul style="list-style: none;padding-left: 0;">
					<li><span style="display: inline-block;width: 38%;font-weight: bold;text-transform: capitalize;font-size: 12px;">Card No:</span> {card_number}</li>
					<li><span style="display: inline-block;width: 38%;font-weight: bold;text-transform: capitalize;font-size: 12px;">Cash Pai:</span> ${cash_paid}</li>
					<li><span style="display: inline-block;width: 38%;font-weight: bold;text-transform: capitalize;font-size: 12px;">Loyality No:</span> 134568</li>
					<li><span style="display: inline-block;width: 38%;font-weight: bold;text-transform: capitalize;font-size: 12px;">Miles Used:</span> {miles_used} Miles</li>
				</ul>
			</div>
			<div style="float:left;">
				<p><b>SHARE: </b></p>
				<ul style="list-style: none;padding-left: 0;display: table;">
					<li style="float: left;margin-right: 10px;"><a href="www.facebook.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/fb.png" alt="fb"></a></li>
					<li style="float: left;margin-right: 10px;"><a href="www.pintrest.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/pinterest.png" alt="pinterest"></a></li>
					<li style="float: left;margin-right: 10px;"><a href="www.twitter.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/twitter.png" alt="twitter"></a></li>
				</ul>
			</div>
			<div style="margin-top:3em;margin-bottom:2em;">
				<a href="{feedback_link}" type="button"><button type="button" style="color:#fff;background:#ff6633;border:none;padding: 5px;border-radius:2px;margin-right:3px;font-weight:bold;font-size:14px;"><i class="fa fa-comments-o" aria-hidden="true"></i> Give Feedback</button></a>
			</div>
		</div>
	</div>
</div>
</body>
</html>
