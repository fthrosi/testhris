<html><head>
    <meta charset="utf-8">
    <title>Approved Time Off</title>
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
                            <?php echo $title; ?>
                        </h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;color:#333333;font-size:14px;line-height:1.7;">

                        

                        <p></p>

                        <p>
                            Dear Mr/Mrs
                            <strong><?php echo $full_name; ?></strong>.
                        </p>

                        <p>
							Your request has been rejected by <?php echo strtolower($form_request['updated_by']); ?>.<br> 
							<strong>For the detail, please sign in to HRIS Application</strong>. 

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
                                <td><strong>Time Off Date</strong></td>
                                <td>: <?php 
											$start_date = DateTime::createFromFormat('Y-m-d', $request_to['start_date'])->format('d.m.Y');
											$end_date = DateTime::createFromFormat('Y-m-d', $request_to['end_date'])->format('d.m.Y');
											echo $start_date . " - " . $end_date;
										?></td>
                            </tr>
							<tr>
                                <td><strong>Time Off Type</strong></td>
                                <td>: <?php echo $request_to['jenis']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Note</strong></td>
                                <td>: <?php echo $request_to['note']; ?></td>
                            </tr>
                        <tr>
                                <td><strong>Status</strong></td>
                                <td>: <?php echo status_color($form_request['is_status']); ?></td>
                            </tr></tbody></table>
							<br>

                        

                        <p>Notes History</p>
						
						<!-- <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; font-size:13px;"> -->
							<table width="100%" cellpadding="3" cellspacing="0" style="border-collapse: collapse; text-align: left; margin-top: 5px; border: 1px solid #999; font-size: 13px;">
								<tr style="background-color: #f2f2f2;">
									<th width="5%" style="border:1px solid #999; padding:1px;">No</th>
									<th width="25%" style="border:1px solid #999; padding:1px;">Created By</th>
									<th width="50%" style="border:1px solid #999; padding:1px;">Notes</th>
									<th width="20%" style="border:1px solid #999; padding:1px;">Date</th>
								</tr>
								<?php
								if ($notes) {
									$no = 1;
									foreach ($notes as $key => $val) {
										echo "
										<tr>
											<td style='border:1px solid #999; padding:3px; text-align:center; vertical-align:top;'>" . $no++ . "</td>
											<td style='border:1px solid #999; padding:3px; vertical-align:top;'>" . htmlspecialchars($val['created_by']) . "</td>
											<td style='border:1px solid #999; padding:3px; vertical-align:top; white-space:pre-line;'>" . nl2br(htmlspecialchars($val['notes'])) . "</td>
											<td style='border:1px solid #999; padding:3px; vertical-align:top;'>" . date('d.m.Y H:i', strtotime($val['created_at'])) . "</td>
										</tr>";
									}
								} else {
									echo "
									<tr>
										<td colspan='4' style='border:1px solid #999; padding:1px; text-align:center;'>
											No notes found for this request.
										</td>
									</tr>";
								}
								?>
							</table>
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