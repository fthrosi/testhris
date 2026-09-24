<html><head>
    <meta charset="utf-8">
    <title>Fully PAID</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4">
    <tbody><tr>
        <td align="center" style="padding:30px 15px;">

            <table width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-radius:8px;overflow:hidden;">

               <!-- Header -->
                <tbody><tr>
                    <td style="background-color:#00c9a3;padding:20px;">
                        <h2 style="margin:0;color:#ffffff;font-size:18px;">
                            [HRIS-MDCR] Medical Claim Fully PAID
                        </h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;color:#333333;font-size:14px;line-height:1.7;">

                        

                        <p></p>

                        <p>
                            <?php if (!empty($data_employee_approver)): ?>
								Dear Mr/Mrs <strongb><?php echo (decrypt($data_employee_approver->complete_name)); ?></strong>
							<?php else: ?>
								Dear Mr/Mrs <strong><?php echo $complete_name; ?></strong>
							<?php endif ?>
                        </p>

                        <p>
                           Your medical claim request has been paid into your Sinarmas Account. Please check.
						   <br> 
                        </p>

                        <h3 style="margin-top:25px;color:#744700;font-size:15px;">
                            Request Details
                        </h3>

                        <table width="100%" cellpadding="6" cellspacing="0" border="0" style="font-size:14px;">
                            <tbody><tr>
                                <td width="180"><strong>Request Number</strong></td>
                                <td>: <?php echo $form_request['request_number']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Modul</strong></td>
                                <td>: <?php echo $form_request['form_type']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Request Date</strong></td>
                                <td>: <?php echo $form_request['created_at']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: FULLY PAID</td>
                            </tr>
                        <tr>
                                <td><strong>Total Claim Request</strong></td>
                                <td>: Rp. <?php echo number_format($get_data_claim); ?></td>
                            </tr></tbody></table>
							<br>

                        

                        

                        

                        <p>
                            For any questions or system issues, please contact HR team.
                                                                                                                                             <p></p><p>

                                                                                                                                             <p></p></p></p>

                        
                        <p>
						<br>
						<br>
                            Thanks and Regards,<br>
							<br>
							<br>
                            <strong>HRIS - Human Resources Information System</strong>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f0f0f0;padding:12px;text-align:center;font-size:12px;color:#777;">
                        *** This is an auto-generated email from HRIS. Please do not reply. ***
                        <br><br>
                        Copyright &copy; <?=date("Y")?> PT. Infrastruktur Bisnis Sejahtera. All rights reserved.
                    </td>
                </tr>

            </tbody></table>

        </td>
    </tr>
</tbody></table>


</body></html>