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
                //dumper($header_mdcr_after_grouping_per_item);
            echo"
            <tr>
            <td style='width: 25%'>".$value['request_number']."</td>
            <td style='width: 20%'>".$value['employee_id']."</td>
            <td style='width: 25%'>".status_mdcr_color($value['is_status_progress'])."</td>
            <td style='width: 30%'><a data-toggle='modal' data-offset='-4,0' id=".$value['id']." onClick='print_out_req_mdcr_at_resume(".$value['id'].")' class='btn btn-outline-primary' title='Medical Claim Form'><em class='icon ni ni-printer'></em></a>
            ";
            if ($value['is_status_divhead_hr'] == 1){
                echo "<a data-toggle='modal' data-offset='-4,0' id=".$value['id']." onClick='print_out_req_mdcr_per_employee(".$value['id'].")' class='btn btn-outline-warning' title='Medical Control Sheets'><em class='icon ni ni-printer'></em></a></td>";
            }else{
                echo "</td>";
            }
            echo "</tr>";
            }
        ?>
        </tbody>
</table>
</div>