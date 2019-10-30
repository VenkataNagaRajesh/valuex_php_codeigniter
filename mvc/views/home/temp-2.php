<!doctype html>
<html dir="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
<title></title>
<style>
	@media screen and (min-width: 320px) and (max-width: 850px) {
		.data-block{
			width:100% !important;
		}
		.img-block{
			width:100% !important;
		}
		.mob-table ul li{
			list-style-type:none;
		}
		.mob-table ul li span{
			font-weight: bold;
			float: left;
			width: 38%;
			display: inline-block;
		}
		.mob-table ul{
			padding-left:0;
		}
		.mob-table ul li p{
			display:table;
		}
		.mob-table ul li:nth-child(even){
			background: #ddd;
			padding: 2px 8px 1px;
			border-bottom: solid 1px #ddd;
		}
		.mob-table ul li:nth-child(odd){
			background: #f5f5f5;
			padding: 2px 8px 1px;
			border-bottom: solid 1px #ddd;
		}
	}
</style>
</head>
<body>
<div style="min-width: 245px;max-width: 1100px;position: relative;padding: 10px;margin:0 auto;">
	<div style="background: {mail_header_color};">
		<img style="width:120px;" src="{logo}" alt="logo" width="120">
	</div>
	<div style="width:100%;margin:0px auto;padding:10px 0;display:inline-block;">
		<div style="width:100%;">
			<table style="width:70%;float:left;" align="left">
				<tr>
					<td>
						<div style="padding-right:15px;">
							<h1 style="margin-bottom: 10px;color: {mail_header_color};font-weight: bold;text-align: center;font-size: 30px;margin-top: 1em;">Hi {first_name}</h1>
							<p style="text-align: center;margin-bottom:10px;font-size: 14px;">
								With AC Bid Upgrade you can enhance your travel experince by enjoying priority. One or more of yourupcoming flight (s) are eligible for bids
							</p>
							<p style="text-align: center"><a style="background: {mail_header_color};font-weight: bold;padding: 8px 26px;font-size: 23px;border-radius: 33px;border: none;color: #fff;text-decoration: none;" href="{bidnow_link}" class="btn btn-danger" type="button">&nbsp;&nbsp; BID NOW &nbsp;&nbsp;</a></p>
							<p style="text-align: center;font-size:14px">
								<span>Value X S.r.l. via Paleocapa, 7 - 20121 Milan - Italy - Tax code and VAT number: IT11876271005</span><br><br>
								You are receiving this email because you subscribed to the Travel Alert service, accepting Value X-  Terms of Service and Privacy Policy .
							</p>
						</div>
						<div style="font-family:calibri;font-weight:500;position: relative;min-height: 1px;margin-top:10px;margin-bottom:10px;overflow: auto;width:98%;padding-right:8px;" class="hidden-xs">
							<table style="border-collapse: collapse;border-spacing: 0;width:100%;">
								<thead style="background: {mail_header_color};color: #fff;text-transform: capitalize;">
									<tr style="white-space:nowrap;">
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Date</th>
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Flight</th>
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Time</th>
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Origin</th>
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Destination</th>
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Current Cabin</th>
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Seat No</th>
										<th style="padding: 6px 3px;text-align:center;font-size:14px;">Upgrade To</th>
									</tr>
								</thead>
							  <tbody>						
									<!--{offer_data}-->
								  <tr style="white-space:nowrap;">
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{dep_date}</td>
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{carrier_code}{flight_number}</td>
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{dep_time}</td>
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{from_city_code}</td>
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{to_city_code}</td>
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{current_cabin}</td>
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">{seat_no}</td>
									<td style="padding: 6px 3px;text-align:center;font-size:14px;color: #333;background: #f5f5f5;">						
									{cabins}
									 <p>{cabin_name}</p>
									{/cabins}						
									</td>						
								  </tr>
								<!--{/offer_data}-->
								</tbody>
							</table>
						</div>	
					</td>
				</tr>
			</table>
			<div style="font-weight:500;position: relative;min-height: 1px;overflow: auto;width:100%;margin-bottom: 20px;font-family:calibri;" class="hidden-lg hidden-sm hidden-md">
				<div style="width:100%;" class="mob-table">
					<ul>
						<li><span>Date</span><p>{dep_date}</p></li>
						<li><span>Flight</span><p>{carrier_code}{flight_number}</p></li>
						<li><span>Time</span><p>{dep_time}</p></li>
						<li><span>Origin</span><p>{from_city_code}</p></li>
						<li><span>Destination</span><p>{to_city_code}</p></li>
						<li><span>Current Cabin</span><p>{current_cabin}</p></li>
						<li><span>Seat No</span><p>{seat_no}</p></li>
						<li><span>Upgrade To</span><p>{cabins} <br>{cabin_name}<br>{/cabins}</p></li>
					</ul>
				</div>
			</div>
			<table style="width:30%;" align="right">
				<tr>
					<td>
						<img style="display: block;height: auto;width:100%;" src="{upgrade_offer_mail_template2}" alt="temp2 bnr" width="402">
						<p style="text-align: center;float: right !important;border: dotted 1px #333;margin: 10px 0px;padding: 3px 15px;"><b>BOOKING REFERENECE: <span style="color:{mail_header_color};">{pnr_ref}</span></b></p>
					</td>
				</tr>
			</table>
		</div>
		<table style="width:10%;">
		        <tr>
					<td>
						<h5><b>SHARE</b></h5>
					</td>
				</tr>
		  		<tr>				
					<td>
						<a href="www.facebook.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/fb.png" alt="fb" width="50"></a>
					</td>
					<td>
						<a href="www.twitter.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/twitter.png" alt="twitter" width="50"></a>
					</td>
					<td>
						<a href="www.pinterest.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/pinterest.png" alt="pinterest" width="50"></a>
					</td>
				</tr>
			</table>
	</div>
</div>
</body>
</html>
