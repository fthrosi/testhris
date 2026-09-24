<div class="nk-ibx-head">
    <?php 

    $join_date           = strtotime(decrypt($this->session->userdata('join_date')));
    $join_date           = date('Y-m-d', $join_date);
    $today               = date("Y-m-d");

    $diff                = abs(strtotime($today) - strtotime($join_date));
    $join_years          = floor($diff / (365*60*60*24));
    $join_months         = floor(($diff - $join_years * 365*60*60*24) / (30*60*60*24));
    $join_days           = floor(($diff - $join_years * 365*60*60*24 - $join_months*30*60*60*24)/ (60*60*24));

    printf("%d years, %d months, %d days\n", $join_years, $join_months, $join_days);

    if(!empty($personal_detail[0]['usrid_long5'])){
        $approval_email = $personal_detail[0]['usrid_long5'];
        $approval_email2 = $personal_detail[0]['usrid_long3'];
    } else if (!empty($personal_detail[0]['usrid_long2'])){
        $approval_email = $personal_detail[0]['usrid_long2'];
        $approval_email2 = $personal_detail[0]['usrid_long3'];
    } else if (!empty($personal_detail[0]['usrid_long3'])){
        $approval_email = $personal_detail[0]['usrid_long3'];
        $approval_email2 = $personal_detail[0]['usrid_long4'];
    } else if (!empty($personal_detail[0]['usrid_long4'])){
        $approval_email = $personal_detail[0]['usrid_long4'];
        $approval_email2 = $personal_detail[0]['usrid_long4'];
    } else {
        $approval_email = encrypt('none');
    }

    $start_date = date("Y-m-d", strtotime(trim($start_date, '"')));
    $end_date = date("Y-m-d", strtotime(trim($end_date, '"')));
    ?>

    <input type="hidden" id="request_nik" name="request_nik" value="<?=$personal_detail[0]['nik'];?>">
    <input type="hidden" id="request_start_date" name="request_start_date" value="<?=$start_date;?>">
    <input type="hidden" id="request_end_date" name="request_end_date" value="<?=$end_date;?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
                <a href="<?= site_url('form/overview/TM'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back to Time Management
                </a>
            </li>
            <li>
                <a class="btn btn-icon btn-tooltip" onclick="return submitRequestTM(this.id);" id="shift">
                    <em class="icon ni ni-send"></em>
                    Submit
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <!-- Header Request -->
    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title"><span class="text-soft">TIME MANAGEMENT: </span>SHIFT SCHEDULE</h4>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <strong>Date: <?=date('Y-m-d H:i:s');?></strong>
                </li>
            </ul>
        </div>
    </div>

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
                                                    <th class="w-auto">Layer</th>
                                                    <th class="w-auto">Approval Position</th>
                                                    <th class="w-auto">Approval Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Manager</td>
                                                    <td id='shift_email1'><?= decrypt(strtoupper($approval_email));?></td>
                                                </tr>
                                                <tr>
                                                    <td>2.</td>
                                                    <td>Division Head</td>
                                                    <!-- <td id='shift_email2'><?= decrypt(strtoupper($personal_detail[0]['usrid_long3']));?></td> -->
                                                    <td id='shift_email2'><?= decrypt(strtoupper($approval_email2));?></td>
                                                </tr>
                                                <tr>
                                                    <td>3.</td>
                                                    <td>Human Resource</td>
                                                    <td>HR</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time-Off Form -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Shift And Overtime Form</h5> 
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
                                            <span class="tb-odr-id text-soft">Jabatan/Golongan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= decrypt($personal_detail[0]['position']); ?>
                                            </span>
                                        </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Division</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($personal_detail[0]['division']); ?>
                                            </span>
                                         </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">II. SCHEDULE INFORMATION</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <table class="nowrap table shift_schedule-table table-striped" id="table_shift_schedule" data-ajaxsource="<?= site_url('form/shift_schedule_table/' . $start_date . '/' . $end_date); ?>">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Schedule</th>
                                        <th>Schedule In</th>
                                        <th>Schedule Out</th>
                                        <th>Check In</th> <!-- ADDED 19.10.2023 -->
                                        <th>Check Out</th> <!-- ADDED 19.10.2023 -->
                                        <th>Actual In</th>
                                        <th>Actual Out</th>
                                        <th>Shift Type</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
                        <div class="card card-bordered card-preview">
                            <div class="m-3">
                                <div class="form-group">
                                    <label class="form-label">Description:</label>
                                    <textarea class="form-control" placeholder="Deskripsi Perubahan Jadwal (Maksimum input karakter: 255)" name="description_schedule" id="description_schedule" maxlength="255"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                                            
        </div>
        
    </div>
</div>

<!-- //////////////////////////////////////////Modal//////////////////////////////////// -->

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
                        <input type="hidden" id="edit_check_time_shift_type" name="edit_check_time_shift_type" value=""> <!-- ADDED 19.10.2023 -->
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