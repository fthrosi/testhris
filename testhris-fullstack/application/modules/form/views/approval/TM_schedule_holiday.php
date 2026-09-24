<div class="nk-ibx-head">
    <?php 

    $join_date           = strtotime(decrypt($this->session->userdata('join_date')));
    $join_date           = date('Y-m-d', $join_date);
    $today               = date("Y-m-d");

    $diff                = abs(strtotime($today) - strtotime($join_date));
    $join_years          = floor($diff / (365*60*60*24));
    $join_months         = floor(($diff - $join_years * 365*60*60*24) / (30*60*60*24));
    $join_days           = floor(($diff - $join_years * 365*60*60*24 - $join_months*30*60*60*24)/ (60*60*24));

    $getMonth = date('Y-m', strtotime($form_request['created_at']));

    printf("%d years, %d months, %d days\n", $join_years, $join_months, $join_days);
    $eval_year = new DateTime($form_request['created_at']);
    $eval_year = $eval_year->format('Y');
    $is_status = number_format($form_request['is_status']);
    if (($is_status == 1) || ($is_status == 3)) {
        $disabled = 'disabled';
        $show = '';
    } else {
        $disabled = '';
        $show = 'none';
    }
    if (($is_status == 3) && ($today > date('Y-m-d', strtotime('+1 Month', strtotime($getMonth.'-10'))))){
        $disabled = '';
        $show = 'none';
    } 
    $gender = $this->session->userdata('gender');
    $marital_status = $this->session->userdata('marital_status');
    if (( decrypt($gender) == 'Male' OR decrypt($gender) == 'Female' ) AND decrypt($marital_status) == 'Single') {
        $dis        = 'disabled';
        $dis_d      = '';
    } else if (( decrypt($gender) == 'Male') AND (decrypt($marital_status) == 'Marr.')){
        $dis        = '';
        $dis_d      = '';
    } else if (( decrypt($gender) == 'Male') AND (decrypt($marital_status) == 'Div.' OR decrypt($marital_status) == 'Wid.')){
        $dis_d      = 'disabled';
        $dis        = '';
    } else if (( decrypt($gender) == 'Female') AND (decrypt($marital_status) == 'Div.' OR decrypt($marital_status) == 'Wid.')){
        $dis_d      = 'disabled';
        $dis        = '';
    } else if (( decrypt($gender) == 'Female') AND (decrypt($marital_status) == 'Marr.')){
        $dis_d      = '';
        $dis        = 'disabled';
    } else {
        $dis        = '';
        $dis_d      = '';
    }

    $visible = false;
    foreach ($approval as $value){
        if (strtolower($value['approval_email']) == strtolower($this->session->userdata('user_email')) && $value['approval_status'] == 'In Progress'){
            $visible = true;
            $show = '';
            break;
        } else if ($this->session->userdata('access_employee') == '12' && $form_request['is_status_admin_hr'] != 1){
            $show = '';
        } else {
            $show = 'none';
        }
    }

    foreach ($approval as $key => $value) {
        if (strtolower($value['approval_email']) == strtolower($this->session->userdata('user_email')) && $value['approval_priority'] == 3){
            if ($approval[1]['approval_status'] == 'Approved'){
                $set_id = 'RevisedHR';
                break;
            }
        } else {
            $set_id = 'Revised';
        }
    }

    if(!empty($personal_detail[0]['usrid_long5'])){
        $manager = ucwords(strtolower(decrypt($personal_detail[0]['rpm_name'])));
    } else if (!empty($personal_detail[0]['usrid_long2'])){
        $manager = ucwords(strtolower(decrypt($personal_detail[0]['depthead_name'])));
    } else if (!empty($personal_detail[0]['usrid_long3'])){
        $manager = ucwords(strtolower(decrypt($personal_detail[0]['divhead_name'])));
    } else if (!empty($personal_detail[0]['usrid_long4'])){
        $manager = ucwords(strtolower(decrypt($personal_detail[0]['director_name'])));
    }

    if (decrypt($personal_detail[0]['company_code']) == '1200'){
        $group = 'IBSW';
    } else if (decrypt($personal_detail[0]['company_code']) == '2000'){
        $group = 'IPM';
    }

    ?>
    <input type="hidden" id="request_id" name="request_id" value="<?=decode_url($this->uri->segment(4));?>">
    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(4));?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <?php if ($form_request['employee_id'] != $this->session->userdata('nik')){ ?>
            <li class="ml-n2">
                <a href="<?= site_url('inbox/approval_TM_ztm'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back to Approval List
                </a>
            </li>
            <li style="display: <?=$show?>">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                        <em class="icon ni ni-more-v"></em> Response
                    </a>
                    <div class="dropdown-menu">
                        <ul class="link-list-opt no-bdr">
                            <?php if (($is_status == 1) && ($visible == true)) { ?>
                            <li><a class="dropdown-item" onclick="return responseRequestSchedule(this.id);" id="Approved"><span>Approve</span></a></li>
                            <?php } ?>
                            <?php if ($this->session->userdata('access_employee') == '12') { ?>
                            <li><a class="dropdown-item" onclick="return responseRequestSchedule(this.id);" id="Checked"><span>Check</span></a></li>
                            <?php } ?>
                            <?php if ((!($is_status == 3)) && (!($is_status == 2))) { ?>
                            <li><a class="dropdown-item" onclick="return responseRequestSchedule(this.id);" id="<?=$set_id?>"><span>Revise</span></a></li>
                            <?php } ?>
                            <?php if (!(($is_status == 3) && ($today > date('Y-m-d', strtotime('+1 Month', strtotime($getMonth.'-10')))))) { ?>
                                <li><a class="dropdown-item" onclick="return responseRequestSchedule(this.id);" id="Reject"><span>Reject</span></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </li>
            <?php } else { ?>
            <li class="ml-n2">
                <a href="<?= site_url('form/overview/TM'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back to Time Management
                </a>
            </li>
            <?php if ($is_status == 2) { ?>
                <li>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                            <em class="icon ni ni-more-v"></em> Response
                        </a>
                        <div class="dropdown-menu">
                            <ul class="link-list-opt no-bdr">
                                <li><a class="dropdown-item" onclick="return responseRequestSchedule(this.id);" id="Resubmitted"><span>Resubmit</span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <!-- Header Request -->
    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title"><span class="text-soft">TIME MANAGEMENT: </span>HOLIDAY SCHEDULE</h4>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <strong>Request Number : <?=$form_request['request_number']?></strong>
                </li>
            </ul>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <strong>Create Date : <?=$form_request['created_at']?></strong>
                </li>
            </ul>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block">
                <?= status_color($is_status);?>
            </li>
            <?php
                if(($form_request['employee_id'] != $this->session->userdata('nik') && $is_status != 2) || ($form_request['employee_id'] == $this->session->userdata('nik') && $form_request['is_status_admin_hr'] == 1 && $is_status != 2)){ //UPDATED 19.10.2023
                    echo "<a id='print_out_req_hol' class='btn btn-icon'>
                    <em class='icon ni ni-file-pdf'></em>
                        Print
                    </a>";
                }
            ?>
        </ul>
    </div>
    <?php
    if($form_request['is_status_admin_hr'] == 1){
        echo "<div class='bg-teal-dim text-success'><center><b>Checked By HR Support</b></center></div>";
    } 

    $date = rawurlencode(json_encode(unserialize($header['date'])));
    ?>
    <div class="nk-ibx-reply-group">
        <!-- Detail Request -->
        <div class="nk-ibx-reply-item nk-reply-item">
            <!-- Approval Layer -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Approval Layer</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <?php if (($is_status != 0) && ($is_status != 4)) { ?>
                <div class="nk-reply-body nk-ibx-reply-body is-shown">
                    <div class="nk-reply-entry entry">
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered card-stretch">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-tranx is-compact fs-13px" id="table_matrix_prev">
                                                <thead>
                                                    <tr>
                                                        <th class="w-5">Layer</th>
                                                        <th class="w-20">Approval Email</th>
                                                        <th class="w-10">Status</th>
                                                        <th class="w-10 text-left">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($approval as $key => $value) {  ?>
                                                    <tr>
                                                        
                                                        <?php if ($value['approval_priority'] == 3){ ?>
                                                            <td><?=$value['approval_priority'];?>.</td>
                                                            <?php if ($value['approval_priority'] == 3 && $value['approval_status'] == 'Approved'){ ?>
                                                                <td><?=strtoupper($value['updated_by']);?></td>
                                                            <?php } else { ?>
                                                                <td><?=$value['approval_alias'];?></td>
                                                            <?php } ?>
                                                            <?php if (empty($value['approval_status']) && ($approval[$key-1]['approval_priority'] == 2 && $approval[$key-1]['approval_status'] == 'Approved')){ ?>
                                                                <td><?=approval_status('In Progress');?></td>
                                                            <?php } else { ?>
                                                                <td><?=approval_status($value['approval_status']);?></td>
                                                            <?php } ?>
                                                            <td class="text-left">
                                                                <?= str_replace('.000','', $value['updated_at']);?>
                                                            </td>
                                                        <?php break;
                                                        } else { ?>
                                                            <td><?=$value['approval_priority'];?>.</td>
                                                            <td><?=strtoupper($value['approval_email']);?></td>
                                                            <td><?=approval_status($value['approval_status']);?></td>
                                                            <td class="text-left">
                                                                <?= str_replace('.000','', $value['updated_at']);?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Time-Off Form -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">ASSIGNMENT TO WORK ON HOLIDAY(S)</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">

                	<!-- Personal Details -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">I. PERSONAL DETAILS</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <table class="table table-orders">
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">No. Karyawan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $personal_detail[0]['nik'];?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Nama</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($personal_detail[0]['complete_name']); ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Nama Manager</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $manager;?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Division</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= decrypt($personal_detail[0]['division']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Cost Center</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($personal_detail[0]['cost_center']); ?>
                                            </span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Group</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $group ?>
                                            </span>
                                         </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Time-Off Information -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">II. SCHEDULE INFORMATION</strong>
                            </div>
                        </div>
                        <div class="card">
                            <table class="nowrap table holiday_schedule-table table-striped" id="table_shift_schedule" data-ajaxsource="<?= site_url('form/holiday_schedule_table/' . $date . '/' . $header['nik']); ?>">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Employee ID</th>
                                        <th>START Date</th>
                                        <th>START Time</th>
                                        <th>ACTUAL In</th> <!-- ADDED 30.10.2023 -->
                                        <th>FINISH Date</th>
                                        <th>FINISH Time</th>
                                        <th>ACTUAL Out</th> <!-- ADDED 30.10.2023 -->
                                        <th>Notes</th>
                                        
                                        <?php if($this->session->userdata('access_employee') == '12'){ ?>
                                            <th>Check All <input type="checkbox" class="checkAll"></th>
                                        <?php } else { ?>
                                            <th>Description </th>
                                        <?php } ?>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <?php if($this->session->userdata('access_employee') == '12'){ ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary check_shift_row">Proceed</button>
                                        </td>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <!-- Additional Details -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">III. ADDITIONAL INFORMATION</strong>
                            </div>
                        </div>
                        <?php 
                            if ($form_request['employee_id'] == $this->session->userdata('nik') && $is_status == 2){
                                $revise_dis = '';
                            } else {
                                $revise_dis = 'disabled';
                            }
                        ?>
                        <div class="card card-bordered card-preview">
                            <div class="m-3">
                                <div class="form-group">
                                    <label class="form-label">Purpose of Working on Holiday(s):</label>
                                    <textarea class="form-control" placeholder="Deskripsi Tujuan Bekerja (Maksimum input karakter: 255)" name="description_schedule" id="description_schedule" maxlength="255" <?= $revise_dis;?>><?= $header['ket'];?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Location of Work:</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control"  placeholder="Lokasi Pekerjaan" name="location_schedule" id="location_schedule" value="<?= $header['lokasi'];?>" <?= $revise_dis;?>> 
                                    </div>
                                </div>
                                <?php if ($form_request['employee_id'] == $this->session->userdata('nik') && $is_status == 2) { ?>
                                    <button type="button" class="btn btn-primary update_additional_info_holiday">UPDATE</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                                            
        </div>

        <!-- Request Notes -->
        <div class="nk-ibx-reply-item nk-reply-item">
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Notes</h5> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <div class="nk-block">
                        <?php if ($form_request['employee_id'] != $this->session->userdata('nik')){ ?>
                        <div class="nk-block-head nk-block-head-sm nk-block-between">
                            <a data-toggle="modal" data-target="#modalAddNotes" class="btn btn-md text-primary">+ Add Note</a>
                        </div>
                        <?php } ?>
                        <?php foreach ($notes as $key => $value) { ?>
                            <div class="bq-note">
                                <div class="bq-note-item">
                                    <div class="bq-note-text">
                                        <p><?= $value['notes']?></p>
                                    </div>
                                    <div class="bq-note-meta">
                                        <span class="bq-note-added">Added on <span class="date"><?= $value['created_at'] ?></span></span>
                                        <span class="bq-note-sep sep">|</span>
                                        <span class="bq-note-by text-dark">By <strong><?= $value['created_by'] ?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ///////////////////////////////////////////////////////// Modal /////////////////////////////////////////////////////////-->
<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modalAddNotes">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Notes</h5>
                    </div>
                    <div class="card-content">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <textarea class="form-control form-control-sm" id="response-notes" name="response-notes" placeholder="Write your notes here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sp-package-action">
                    <a href="#" class="btn btn-dim btn-danger" data-dismiss="modal" data-toggle="modal">Cancel</a>
                    <button type="button" onclick="return save_response_notes();" class="btn btn-md btn-primary"><span class="text-notes-response"> Save</span></button>
                </div>

            </div>
        </div>
    </div>
</div>

<?php if (($form_request['employee_id'] == $this->session->userdata('nik')) && $is_status == 2){ ?>
<div class="modal fade" tabindex="-1" id="modalEditCheckTime">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Attendance</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" name="edit_check_time" id="edit_check_time" step="2">  
                            <div class="form-note">Time format <code>HH:mm:ss</code>
                            </div>
                        </div>
                        <input type="hidden" id="edit_check_time_id" name="edit_check_time_id" value="">
                        <input type="hidden" id="edit_check_time_type" name="edit_check_time_type" value="">
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary update_shift_check_time" id="update_shift_check_time">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalEditCheckDate">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Attendance</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <label class="form-label">Date</label>
                            <div class="form-control-wrap">        
                                <input type="text" class="form-control date-picker" name="edit_check_date" id="edit_check_date">    
                            </div>    
                            <div class="form-note">Date format <code>mm/dd/yyyy</code>
                            </div>
                        </div>
                        <input type="hidden" id="edit_check_date_id" name="edit_check_date_id" value="">
                        <input type="hidden" id="edit_check_date_type" name="edit_check_date_type" value="">
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary update_shift_check_date" id="update_shift_check_date">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>