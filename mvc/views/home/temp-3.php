<!doctype html>
<html dir="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
<title></title>
<style>
	@media screen and (min-width: 320px) and (max-width: 850px) {
		.upgrade-title span{
			float: none !important;
			display: table;
		}
		.head-title span{
			float: none !important;
			display: table;
		}
	}
</style>
</head>
<body>
<div style="min-width: 245px;max-width: 1100px;position: relative;padding: 10px;margin:0 auto;">
	<div style="margin-left:auto;margin-right:auto;width:100%;padding-left: 15px;padding-right: 15px;background: #333;">
		<img style="width:120px;" src="{logo}" alt="logo">
	</div>
	<div style="border: solid 1px #ddd;width:100%;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;">
		<div style="margin-top:12px;" class="upgrade-title">
			<h3 style="margin:0;font-weight: bold;font-size: 18px;color: #333;">Subject: Upgrade Offer</h3>
			<p style="margin-bottom: 10px;font-size:13px">
				<span>you <valux@info.com> Unsubscribe</span>
				<span style="float: right;">Apr 11, 2019, 8:18 AM (1 day ago)</span>
			</p>
		</div>
		<div style="width: 100%;">
			<img style="margin:0 auto;display: block;max-width: 100%;height: auto;" src="{airline_logo}" alt="temp bnr">
		</div>
		<div style="width:100%;display:table;">
			<h1 class="head-title" style="margin:0;color: #ff6633;font-weight: bold;font-size: 16px;">Hi !<span style="float: right;"><a href="#">Help Center | I'm Not Intrested</a></span></h1>
			<p style="font-size:14px;margin: 10px 0;text-align:center;">
				With AC Bid Upgrade you can enhance your travel experince by enjoying priority. One or more of yourupcoming flight (s) are eligible for bids	
			</p>
			<img style="display: block;max-width: 100%;height: auto;width: 100%;" src="{upgrade_offer_mail_template3}" alt="temp bnr">
			<p class="col-md-4" style="position: relative;top: -50px;left: 30px;border: dotted 1px #f5f5f5;font-size: 15px;"><b>BOOKING REFERENECE: <b style="color:#fff;"><?=$pax_data->pnr_ref?></b></b></p>
		</div>
		<div style="font-weight:500;position: relative;min-height: 1px;margin-top: -25px;overflow: auto;width:100%;margin-bottom: 20px;">
			<table style="border-collapse: collapse;border-spacing: 0;width:100%;">
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
			</table>
		</div>
		<div style="width:100%;margin:0px 0 20px;">
			<div style="margin-top:0px;">
				<p style="font-size:14px;text-align:center;">
					<span>Value X S.r.l. via Paleocapa, 7 - 20121 Milan - Italy - Tax code and VAT number: IT11876271005</span><br>
					You are receiving this email because you subscribed to the Travel Alert service, accepting Value X-  Terms of Service and Privacy Policy .
				</p>
				<p style="text-align:center;margin-top:12px;"><a type="button" href="{bidnow_link}" style="background: #ff6633;font-weight:bold;padding:8px 26px;font-size: 23px;border-radius: 33px;border:none;color:#fff;font-family:century gothic;text-decoration:none;">BID NOW</a></p>
			</div>
		</div>
		<div class="share">
			<p><b>SHARE: </b></p>
			<ul style="list-style: none;padding-left: 0;display: table;">
				<li style="float: left;margin-right: 10px;"><a href="www.facebook.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/fb.png" alt="fb"></a></li>
				<li style="float: left;margin-right: 10px;"><a href="www.pintrest.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/pinterest.png" alt="pinterest"></a></li>
				<li style="float: left;margin-right: 10px;"><a href="www.twitter.com"><img style="width:39px;display: block;height:auto;" src="{base_url}assets/home/images/twitter.png" alt="twitter"></a></li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>