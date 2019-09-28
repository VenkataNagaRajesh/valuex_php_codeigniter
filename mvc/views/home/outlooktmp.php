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

   /* Remove space around the email design. */
   html,
   body {
       margin: 0 auto !important;
       padding: 0 !important;
       height: 100% !important;
       width: 100% !important;
   } 

   /* Stop Outlook resizing small text. */
   * {
       -ms-text-size-adjust: 100%;
   } 

   /* Stop Outlook from adding extra spacing to tables. */
   table,
   td {
       mso-table-lspace: 0pt !important;
       mso-table-rspace: 0pt !important;
   }
   /* Use a better rendering method when resizing images in Outlook IE. */
   img {
       -ms-interpolation-mode:bicubic;
   }
 /* Prevent Windows 10 Mail from underlining links. Styles for underlined links should be inline. */
   a {
       text-decoration: none;
   }

</style>
</head>
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly;">
<div style="min-width: 245px;max-width: 1100px;position: relative;padding: 10px;margin:0 auto;">
	<div style="margin-left:auto;margin-right:auto;width:100%;background: #333;">
		<img style="width:120px;" src="{logo}" alt="logo">
	</div>
	<div style="border: solid 1px #ddd;width:100%;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;">
		<div style="position: relative;min-height: 1px;padding:12px;">
			<div class="mobile" style="background-image: url({base_url}/assets/home/images/temp1-hdr-bg.jpg);margin-top: 15px;background-repeat: no-repeat;width: 100%;background-size: cover;">
				<h1 style="margin-bottom:8px;color: #fff;font-size: 14px;font-weight: bold;padding:12px;font-family:calibri;"><span>Hi {first_name}! </span><span style="float: right;color:#333;">Booking Reference : {pnr_ref}<b></b></span></h1>
			</div>
			<div>
				<img style="width: 100%;display: block;max-width: 100%;height: auto;" src="{upgrade_offer_mail_template1}" alt="temp bnr">
			</div>
		</div>
		<div style="font-weight:500;position: relative;min-height: 1px;overflow: auto;width:100%;margin-bottom: 20px;">
			<table style="border-collapse: collapse;border-spacing: 0;width:100%;" role="presentation" cellspacing="0" cellpadding="0" border="0">
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
		<div style="width; 50%; display: inline-block;">
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
