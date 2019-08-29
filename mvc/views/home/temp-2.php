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
	}
</style>
</head>
<body>
<div style="min-width: 245px;max-width: 1100px;position: relative;padding: 10px;margin:0 auto;">
	<div style="margin-left:auto;margin-right:auto;width:100%;padding-left: 15px;padding-right: 15px;background: #333;">
		<img style="width:120px;" src="{base_url}assets/home/images/emir.png" alt="logo">
	</div>
	<div style="border: solid 1px #ddd;width:100%;margin:0px auto;padding:10px 15px;display:inline-block;">
		<div class="data-block" style="width:70%;position: relative;min-height: 1px;float: left;padding-right:15px;">
			<div>
				<img style="margin-right: auto;margin-left: auto;display: block;max-width: 100%;height: auto;" src="{base_url}assets/home/images/temp2-logo.jpg" alt="temp bnr">
			</div>
			<h1 style="margin-bottom: 10px;color: #ff6633;font-weight: bold;text-align: center;font-size: 30px;margin-top: 1em;">Hi {first_name}</h1>
			<p style="text-align: center;margin-bottom:10px;font-size: 14px;">
				With AC Bid Upgrade you can enhance your travel experince by enjoying priority. One or more of yourupcoming flight (s) are eligible for bids
			</p>
			<p style="text-align: center"><a style="background: #ff6633;font-weight: bold;padding: 8px 26px;font-size: 23px;border-radius: 33px;border: none;color: #fff;text-decoration: none;" href="{bidnow_link}" class="btn btn-danger" type="button">BID NOW</a></p>
			<p style="text-align: center;font-size:12px">
				<span>Value X S.r.l. via Paleocapa, 7 - 20121 Milan - Italy - Tax code and VAT number: IT11876271005</span><br>
				You are receiving this email because you subscribed to the Travel Alert service, accepting Value X-  Terms of Service and Privacy Policy .
			</p>
			<div style="font-family:calibri;font-weight:500;position: relative;min-height: 1px;margin-top:10px;margin-bottom:10px;overflow: auto;width:100%;">
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
		</div>
		<div class="img-block" style="width: 30%;float: left;position: relative;margin: 12px 0;">
			<img style="display: block;height: auto;width:100%;" src="{base_url}assets/home/images/temp2-bnr.jpg" alt="temp2 bnr">
			<p style="text-align: center;float: right !important;border: dotted 1px #333;margin: 10px 0px;padding: 3px 15px;"><b>BOOKING REFERENECE: <span style="color:#ff6633;">{pnr_ref}</span></b></p>
		</div>
		<div class="share">
			<p><b>SHARE: </b></p>
			<ul style="list-style: none;padding-left: 0;display: table;">
				<li style="float: left;margin-right: 10px;"><a href="www.facebook.com"><img style="width:39px;display: block;height:auto;" src="<?=base_url()?>assets/home/images/fb.png" alt="fb"></a></li>
				<li style="float: left;margin-right: 10px;"><a href="www.pintrest.com"><img style="width:39px;display: block;height:auto;" src="<?=base_url()?>assets/home/images/pinterest.png" alt="pinterest"></a></li>
				<li style="float: left;margin-right: 10px;"><a href="www.twitter.com"><img style="width:39px;display: block;height:auto;" src="<?=base_url()?>assets/home/images/twitter.png" alt="twitter"></a></li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>
