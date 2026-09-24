<div style="overflow-x:auto;">
<table class="table table-striped" id="table_item_mdcr">
	<thead>
			<tr>
				<th style='width: 25%'>Request Number</th>
				<th style='width: 20%'>Employee ID</th>
				<th style='width: 25%'>Status</th>
				<th style='width: 30%'>Action</th>
			</tr>
	</thead>
	<tbody>
		<?php
			foreach($header_mdcr_after_grouping_per_item as $key => $value){
					// dumper($header_mdcr_after_grouping_per_item);
				echo"
					<tr>
					<td style='width: 25%'>".$value['request_number']."</td>
					<td style='width: 20%'>".$value['employee_id']."</td>
					<td style='width: 25%'>".status_mdcr_color($value['is_status_progress'])."</td>
					<td style='width: 30%'>";

					if ($value['is_status_progress'] == 6) {
						if ($this->session->userdata('access_employee') == '14') {
							// echo "<a data-toggle='modal' data-offset='-4,0' id=".$value['id']." class='btn btn-outline-info mr-1' title='Re send email'><em class='icon ni ni-send'></em></a>";
							// echo "<button type='button' onClick='re_send_email(".$value['request_number'].", ".$value['employee_id'].")'  class='btn btn-outline-info mr-1' title='Re send email'><em class='icon ni ni-send'></em></button>";
							echo "<button type='button' onClick='re_send_email(this)' data-request='".$value['request_number']."' data-nik='".$value['employee_id']."' class='btn btn-outline-info mr-1' title='Re send email'><em class='icon ni ni-send'></em></button>";
						}
					}

					if ($value['is_status_divhead_hr'] == 1){
							echo "<a data-toggle='modal' data-offset='-4,0' id=".$value['id']." onClick='print_out_req_mdcr_per_employee_ap(".$value['id'].")' class='btn btn-outline-warning' title='Medical Control Sheets'><em class='icon ni ni-printer'></em></a></td>";
					}else{
							echo "</td>";
					}
				echo "</tr>";
			}
		?>
	</tbody>
</table>
</div>