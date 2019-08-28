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
<div style="min-width: 245px;max-width: 1100px;position: relative;padding: 10px;margin:0 auto;font-family:century gothic;">
	<div style="margin-left:auto;margin-right:auto;width:100%;padding-left: 15px;padding-right: 15px;background: #333;">
		<img style="width:120px;" src="<?=base_url()?>assets/home/images/emir.png" alt="logo">
	</div>
	<div style="border: solid 1px #ddd;width:100%;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;">
		<div style="width:100%;margin-top:10px;">
			<div style="width:10%;float:left;">
				<img style="width:auto;display: block;height:54px;" src="<?=base_url()?>assets/home/images/temp2-logo.jpg" alt="logo">
			</div>
			<div class="strip" style="width:90%;float:left;">
				<div style="background: #f5f5f5;height: 38px;margin: 16px 0;"></div>
			</div>
		</div>
		<div style="width:100%;">
			<p style="font-size: 14px;"><span style="color: #ff6633;font-weight: bold;margin-right: 8px;">Congratulations,</span> your bid has been Successfully Submitted</p>
			<p style="font-size: 14px;">
				<span style="font-weight: bold;color: #ff6633;">What to do Now:</span><br>
				Lorem Ipsum is simply dummy text of the Printing and typecasting Industry. Lorem Ipsum has been the Industry's Standard Dummy Text ever since the 1500s,
			</p>
			<p style="font-size: 14px;"><b><span style="color:#ff6633;">Bid Summary : </span> Bid Reference No : {pnr_ref}</b></p>
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
		<div style="width:100%;">
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