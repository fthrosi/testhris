<html><head>
    <meta charset="utf-8">
    <title>GA Verification Request</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4">
    <tbody><tr>
        <td align="center" style="padding:30px 15px;">

            <table width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-radius:8px;overflow:hidden;">

                <!-- Header -->
                <tbody><tr>
                    <td style="background-color:#2d98da;padding:20px;">
                        <h2 style="margin:0;color:#ffffff;font-size:18px;">
                            [HRIS-EC] Exit Clearance Verification Request
                        </h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;color:#333333;font-size:14px;line-height:1.7;">

                        

                        <p></p>

                        <p>
                            Dear Mr/Mrs
                            <strong>GA Teams</strong>.
                        </p>

                        <p>
							Please review and verify the company assets assigned to the employee based on the information below :
                        </p>

                        <h3 style="margin-top:25px;color:#744700;font-size:15px;">
                            Request Details
                        </h3>

                        <table width="100%" cellpadding="6" cellspacing="0" border="0" style="font-size:14px;">
                            <tbody><tr>
                                <td width="180"><strong>Request Number</strong></td>
                                <td>: <?= $req_number ?></td>
                            </tr>
							<tr>
                                <td><strong>Request Name</strong></td>
                                <td>: <?= $req_name ?> (<?= $req_nik ?>)</td>
                            </tr>
							<tr>
                                <td><strong>Position</strong></td>
                                <td>: <?= $position_name ?></td>
                            </tr>
                            <tr>
                                <td><strong>Modul</strong></td>
                                <td>: <?= $module ?></td>
                            </tr>
                            <tr>
                                <td><strong>Resignation Date</strong></td>
                                <td>: <?= $resign_date ?></td>
                            </tr>
							<tr>
                                <td><strong>Additional Notes</strong></td>
                                <td>: <?= $notes ?></td>
                            </tr>
							<tr>
                                <td><strong>Status</strong></td>
                                <td>: <?= $status ?></td>
                            </tr></tbody></table>
							<br>

                        

						<p>
							Notes History</p>
						
						<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; font-size:13px;">
							<thead>
								<tr style="background:#f5f5f5;">
									<th style="border:0,5px solid #ddd; text-align:left;">No</th>
									<th style="border:0,5px solid #ddd; text-align:left;">Created By</th>
									<th style="border:0,5px solid #ddd; text-align:left;">Notes</th>
									<th style="border:0,5px solid #ddd; text-align:left;">Date</th>
								</tr>
							</thead>
                            <tbody>
                                <?php $no = 1; foreach ($notes_history as $note) : ?>
                                <tr>
                                    <td style="border:0,5px solid #ddd;"><?= $no++ ?></td>
                                    <td style="border:0,5px solid #ddd;"><?= $note['created_by'] ?></td>
                                    <td style="border:0,5px solid #ddd;"><?= $note['note'] ?></td>
                                    <td style="border:0,5px solid #ddd;"><?= $note['created_at'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
						</table><br>                        

                        
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
                        *** This is an auto-generated email from HRIS. Please do not reply. ***<br>
						<br>
						Copyright © 2026 PT. Infrastruktur Bisnis Sejahtera. All rights reserved.
                    </td>
                </tr>

            </tbody></table>

        </td>
    </tr>
</tbody></table>


</body></html>