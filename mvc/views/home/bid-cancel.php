<!doctype html>
<html dir="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
<title></title>
<style>
	@media screen and (min-width: 320px) and (max-width: 850px) {
		.strip{
			float: none !important;
			width: 100% !important;
		}
	}
</style>
</head>
<body>
	<div style="min-width: 245px;max-width: 1100px;position: relative;padding: 10px;margin:0 auto;">
		<div style="margin-left:auto;margin-right:auto;width:100%;padding-left: 15px;padding-right: 15px;background: {mail_header_color};">
			<img style="width:120px;" src="{logo}" alt="logo" width="120">
		</div>
		<div style="width:100%;margin:0px auto;padding:10px 14px;display:inline-block;">
			<div style="width:100%;margin-top:10px;">
				<div style="width:10%;float:left;">
					<img style="width:auto;display: block;height:54px;" src="{airline_logo}" alt="logo">
				</div>
				<div class="strip" style="width:90%;float:left;">
					<div style="background: #f5f5f5;height: 38px;margin: 16px 0;"></div>
				</div>
			</div>
			<div style="width:100%;">
				<p style="font-size: 14px;color: #ff6633;font-weight: bold;margin-right: 8px;">{first_name} {last_name}</p>
				<p style="font-size: 14px;">Booking Reference : {pnr_ref}</p>			  	
				<ul>
					<li style="font-size: 14px;line-height:20px;margin: 0 0 12px;">we hope to serve you better next time and your cancellation is not due to our service delimitations.</li>
					<li style="font-size: 14px;line-height:20px;margin: 0 0 12px;">The Bidding is retrieved back  and itinerary remains unchanged.</li>
				</ul>
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
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Cabin</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Upgrade To</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Seat No</th>
						<th style="padding: 6px 3px;text-align:center;font-size:14px;">Bid</th>
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
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{upgrade_type} Class</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{seat_no}</td>
						<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">${cash} USD</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</body>
</html>
