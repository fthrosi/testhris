<html><head>
    <meta charset="utf-8">
    <title>Cancel Request</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4">
    <tbody><tr>
        <td align="center" style="padding:30px 15px;">

            <table width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-radius:8px;overflow:hidden;">

                <!-- Header -->
                <tbody><tr>
                    <td style="background-color:#990000;padding:20px;">
                        <h2 style="margin:0;color:#ffffff;font-size:18px;">
                            [HRIS-PA] Request Cancel
                        </h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;color:#333333;font-size:14px;line-height:1.7;">

                        

                        <p></p>

                        <p>
                            Dear Mr/Mrs
                            <strong><?=$approval_alias?></strong>.
                        </p>

                        <p>
                            For your information, the request below has been canceled by requestor.<br> 
                        </p>

                        <h3 style="margin-top:25px;color:#744700;font-size:15px;">
                            Request Details
                        </h3>

                        <table width="100%" cellpadding="6" cellspacing="0" border="0" style="font-size:14px;">
                            <tbody><tr>
                                <td width="180"><strong>Request Number</strong></td>
                                <td>: <?= $detail['request_number']; ?></td>
                            </tr>
							<tr>
                                <td><strong>Request Name</strong></td>
                                <td>: <?= decrypt($detail['employee_name']).' ('.$detail['employee_nik'].')'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Modul</strong></td>
                                <td>: Performance Appraisal / Performance Plan</td>
                            </tr>
							<tr>
                                <td><strong>Status</strong></td>
                                <td>: <?=$is_status?></td>
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