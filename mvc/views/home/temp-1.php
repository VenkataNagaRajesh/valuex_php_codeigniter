<!doctype html>
<html dir="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
<title></title>
<style>
	@media screen and (min-width: 320px) and (max-width: 850px) {
		.mobile h1 span{
			float:none !important;
			display:table;
		}
	}
</style>
</head>
<body style="margin-bottom: 0; -webkit-text-size-adjust: 100%; padding-bottom: 0;  margin-top: 0; margin-right: 0; -ms-text-size-adjust: 100%; margin-left: 0; padding-top: 0; padding-right: 0; padding-left: 0; width: 100%;">
	<table style="border-collapse: collapse;border-spacing: 0;width:66%;margin:0 auto;border:solid 1px #999;">
		<table style="border-collapse: collapse;border-spacing: 0;width:66%;margin:0 auto;">
			<tr>
				<td>
					<div style="margin-left:auto;margin-right:auto;width:100%;background: #333;">
						<img style="width:120px;" src="{logo}" alt="logo">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="mobile" style="background-image: url({base_url}/assets/home/images/temp1-hdr-bg.jpg);margin-top: 15px;background-repeat: no-repeat;width: 100%;background-size: cover;">
						<h1 style="margin-bottom:8px;color: #fff;font-size: 14px;font-weight: bold;padding:12px;font-family:calibri;"><span>Hi {first_name}! </span><span style="float: right;color:#333;">Booking Reference : {pnr_ref}<b></b></span></h1>
					</div>
				</td>
			</tr>
		</table>
		<table style="border-collapse: collapse;border-spacing: 0;width:50%;margin:0 auto;">
			<thead style="background: #ff6633;color: #fff;text-transform: capitalize;">
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
		</table><br>
		<table style="border-collapse: collapse;border-spacing: 0;width:66%;margin:0 auto;">
			<tr>
				<td>
					<div style="position: relative;min-height: 1px;padding-left: 15px;padding-right:15px;">
						<p style="margin-bottom: 10px;font-size: 14px;color: #333;font-family:calibri;font-weight:500;text-align:center;">
							With AC Bid Upgrade you can enhance your travel experince by enjoying priority. One or more of yourupcoming flight (s) are eligible for bids
						</p>
						<p style="text-align:center;"><a type="button" href="{bidnow_link}" style="background: #ff6633;font-weight:bold;padding:8px 26px;font-size: 23px;border-radius: 33px;border:none;color:#fff;font-family:calibri;text-decoration:none;">BID NOW</a></p>
						<div class="info">
							<p style="margin-bottom: 10px;font-weight:500;font-size: 14px;color: #333;font-family: calibri;text-align:center;">
								<span><b>Help Center | I'm Not Intrested</b></span><br>
								<span>Value X S.r.l. via Paleocapa, 7 - 20121 Milan - Italy - Tax code and VAT number: IT11876271005</span><br>
								You are receiving this email because you subscribed to the Travel Alert service, accepting Value X-  Terms of Service and Privacy Policy .
							</p>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="width:100%;position:relative;">
						<p><b>SHARE: </b></p>
						<ul style="list-style: none;padding-left: 0;display: table;">
							<li style="float: left;margin-right: 10px;"><a href="www.facebook.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/fb.png" alt="fb"></a></li>
							<li style="float: left;margin-right: 10px;"><a href="www.pintrest.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/pinterest.png" alt="pinterest"></a></li>
							<li style="float: left;margin-right: 10px;"><a href="www.twitter.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/twitter.png" alt="twitter"></a></li>
						</ul>
					</div>
				</td>
			</tr>
		</table>
	</table>
</body>
</html>
