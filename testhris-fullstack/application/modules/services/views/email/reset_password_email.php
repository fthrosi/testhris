<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>MDCR Form - Notification</title>
	<style type="text/css" media="screen">
		.body-wrap,body{background-color:#f6f6f6}.content,.content-wrap{padding:20px}.aligncenter,.btn-primary{text-align:center}*{margin:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px}img{max-width:100%}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;line-height:1.6em}table td{vertical-align:top}.body-wrap{width:100%}.container{display:block!important;max-width:1000px!important;margin:0 auto!important;clear:both!important}.clear,.footer{clear:both}.content{max-width:1000px;margin:0 auto;display:block}.main{background-color:#fff;border:1px solid #e9e9e9;border-radius:3px}.content-block{padding:0 0 20px}.header{width:100%;margin-bottom:20px}.footer{width:100%;color:#999;padding:20px}.footer a,.footer p,.footer td{color:#999;font-size:12px}h1,h2,h3{font-family:"Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;color:#000;margin:40px 0 0;line-height:1.2em;font-weight:400}h1{font-size:32px;font-weight:500}h2{font-size:24px}h3{font-size:18px}h4{font-size:14px;font-weight:600}ol,p,ul{margin-bottom:10px;font-weight:400}ol li,p li,ul li{margin-left:5px;list-style-position:inside}a{color:#348eda;text-decoration:underline}.alert a,.btn-primary{text-decoration:none}.btn-primary{color:#FFF;background-color:#348eda;border:solid #348eda;border-width:10px 20px;line-height:2em;font-weight:700;cursor:pointer;display:inline-block;border-radius:5px;text-transform:capitalize}.alert,.alert a{color:#fff;font-weight:500;font-size:16px}.last{margin-bottom:0}.first{margin-top:0}.alignright{text-align:right}.alignleft{text-align:left}.alert{padding:20px;text-align:center;border-radius:3px 3px 0 0}.alert.alert-warning{background-color:#FF9F00}.alert.alert-bad{background-color:#D0021B}.alert.alert-good{background-color:#75a6f4}.invoice{margin:40px auto;text-align:left;width:80%}.invoice td{padding:5px 0}.invoice .invoice-items{width:100%}.invoice .invoice-items td{border-top:#eee 1px solid}.invoice .invoice-items .total td{border-top:2px solid #333;border-bottom:2px solid #333;font-weight:700}@media only screen and (max-width:1040px){.container,.content,body{padding:0!important}.container,.invoice{width:100%!important}h1,h2,h3,h4{font-weight:800!important;margin:20px 0 5px!important}h1{font-size:22px!important}h2{font-size:18px!important}h3{font-size:16px!important}.content-wrap{padding:10px!important}}

		.table { border: 1px solid blue; border-collapse: collapse; width: 100%;} th, td {text-align: left;padding: 8px;} tr:nth-child(even) {background-color: #f2f2f2;}
	</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">

<table class="body-wrap" width="100%">
	<tr>
		<td></td>
		<td class="container" width="100%">
			<div class="content">
				<table class="main" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="content-wrap">
							<table width="100%" cellpadding="0" cellspacing="0" style="text-align: justify;">
								<tr>
									<td class="content-block">
										Dear <b><?php echo ($fullname); ?></b>, <br><br>
										Anda telah melakukan permintaan reset password untuk aplikasi Medical Claim, jika anda tidak merasa melakukan hal ini silahkan hubungi department IT.<br><br>
										Password baru anda : <?php echo ($new_password); ?>
										<br>

										Gunakan pada saat melakukan login menggunakan alamat email anda dan password yang baru, <a href="<?php echo base_url();?>">klik disini untuk melakukan login.</a>
									</td>
								</tr>	
							</table>
						</td>
					</tr>
					<tr>
						<td class="content-wrap">
							<table width="100%" cellpadding="0" cellspacing="0" style="text-align: justify;">
								<tr>
									<td class="content-block">
										Thanks and Regards,<br>
										HRIS
									</td>
								</tr>	
							</table>
						</td>
					</tr>
				</table>
				<div class="footer">
					<table width="100%">
						<tr>
							<td class="aligncenter content-block">
								This is an automated message, do not reply this email.<br>
							</td>
						</tr>
						<tr>
							<td class="aligncenter content-block">
								Copyright © 2020 PT. Infrastruktur Bisnis Sejahtera. All rights reserved.
							</td>
						</tr>
					</table>
				</div>
			</div>
		</td>
		<td></td>
	</tr>
</table>

</body>
</html>
