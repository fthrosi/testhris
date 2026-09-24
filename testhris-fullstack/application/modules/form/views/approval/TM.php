<div class="nk-ibx-head">
    <?php 

    $join_date           = strtotime(decrypt($this->session->userdata('join_date')));
    $join_date           = date('Y-m-d', $join_date);
    $today               = date("Y-m-d");

    $diff                = abs(strtotime($today) - strtotime($join_date));
    $join_years          = floor($diff / (365*60*60*24));
    $join_months         = floor(($diff - $join_years * 365*60*60*24) / (30*60*60*24));
    $join_days           = floor(($diff - $join_years * 365*60*60*24 - $join_months*30*60*60*24)/ (60*60*24));

    $getMonth = date('Y-m', strtotime($header['start_date']));

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
            break;
        }
    }

    if ($form_request['is_status_admin_hr'] == 8){
        $appr_loc = 'Loc';
        $rej_loc = 'Loc';
    } else {
        $appr_loc = '';
        $rej_loc = '';
    }

    ?>
    <input type="hidden" id="request_id" name="request_id" value="<?=decode_url($this->uri->segment(4));?>">
    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(4));?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <?php if (($form_request['employee_id'] != $this->session->userdata('nik')) || ($this->session->userdata('nik') == '20110014')) { ?>
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
                            <li><a class="dropdown-item" onclick="return responseRequest(this.id);" id="Approved<?=$appr_loc;?>"><span>Approve</span></a></li>
                            <?php } ?>
                            <?php if (!(($is_status == 3) && ($today > date('Y-m-d', strtotime('+1 Month', strtotime($getMonth.'-10')))))) { ?>
                                <li><a class="dropdown-item" onclick="return responseRequest(this.id);" id="Reject<?=$rej_loc;?>"><span>Reject</span></a></li>
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
            <?php } ?>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <!-- Header Request -->
    <!-- <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title"><span class="text-soft">TIME MANAGEMENT: </span>TIME-OFF</h4>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <strong>Period: Januari <?=$eval_year;?> - Desember <?=$eval_year;?></strong>
                </li>
            </ul>
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
                if($header['jenis'] == 'Request Attendance'){
                    echo "<a id='print_out_req_tm' class='btn btn-icon'>
                    <em class='icon ni ni-file-pdf'></em>
                        Print
                    </a>";
                } 
            ?>
        </ul>
    </div> -->
    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title">
                <span class="text-strong"></span>TIME MANAGEMENT: TIME-OFF
            </h4>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <span class="badge badge-soft"><?= $form_request['created_by'];?></span>
                </li>
                <li class="btn-group is-tags">
                    <span class="badge badge-primary"><?=$form_request['request_number']?></span>
                </li>
                <li class="btn-group is-tags">
                    <strong>Period: Januari <?=$eval_year;?> - Desember <?=$eval_year;?></strong>
                </li>
            </ul>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block" id="request_status">
                <?= status_color($is_status);?>
            </li>
            <?php
                if($header['jenis'] == 'Request Attendance' && $is_status != 8 && $is_status != 4){
                    echo "<a id='print_out_req_tm' class='btn btn-icon'>
                    <em class='icon ni ni-file-pdf'></em>
                        Print
                    </a>";
                } 
            ?>
        </ul>
    </div>
    
    <div class="nk-ibx-reply-group">
        <!-- Detail Request -->
        <div class="nk-ibx-reply-item nk-reply-item">
            <!-- Approval Layer -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-strong">Approval Layer</h5> 
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
                                                        
                                                        <?php if ($value['approval_priority'] == 2){ ?>
                                                            <td><?=$value['approval_priority'];?>.</td>
                                                            <?php if ($value['approval_priority'] == 2 && $value['approval_status'] == 'Approved'){ ?>
                                                                <td><?=strtoupper($value['updated_by']);?></td>
                                                            <?php } else { ?>
                                                                <td><?=$value['approval_alias'];?></td>
                                                            <?php } ?>
                                                            <td><?=approval_status($value['approval_status']);?></td>
                                                            <td class="text-left">
                                                                <?= str_replace('.000','', $value['updated_at']);?>
                                                            </td>
                                                        <?php break;
                                                        } else if ($value['approval_priority'] == 1){ ?>
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
            <hr>
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-strong">Personal Details</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">

                	<!-- Personal Details -->
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <table class="table table-orders">
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Nama</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($personal_detail[0]['complete_name']); ?>
                                            </span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Departemen/Bagian</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($personal_detail[0]['department']); ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Jabatan/Golongan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= decrypt($personal_detail[0]['employee_group']); ?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Regional</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($personal_detail[0]['personnel_area']); ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">No. Karyawan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $header['nik'];?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                        <span class="tb-odr-id text-soft">No. Telepon</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= decrypt($personal_detail[0]['phone_number']);?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
            <hr>
            <!-- Time-Off Form -->
            <!-- <div class="nk-reply-header nk-ibx-reply-header is-collapsed"> -->
            <div class="nk-reply-header nk-ibx-reply-header is-shown">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-strong">Time-Off Details</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <!-- Time-Off Information -->
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <table class="table table-orders">
                            <tbody class="tb-odr-body">
                                    <?php if ($form_request['is_status_admin_hr'] == 8){ ?>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Tipe Time-Off</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $header['jenis']; ?>
                                            </span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Date</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $header['start_date']; ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                    <?php if (!empty($header['waktu_masuk'])) { ?>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Bukti Lokasi In</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <a href="<?php echo base_url();?>assets/documents/documents_tm/request_location/<?= $header['waktu_masuk']; ?>" target="_blank"><?= $header['waktu_masuk']; ?></a>
                                            </span>
                                        </td>
                                    <?php } if (!empty($header['waktu_keluar'])) { ?>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Bukti Lokasi Out</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <a href="<?php echo base_url();?>assets/documents/documents_tm/request_location/<?= $header['waktu_keluar']; ?>" target="_blank"><?= $header['waktu_keluar']; ?></a>
                                            </span>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    <?php } else { ?> 
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Tipe Time-Off</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $header['jenis']; ?>
                                            </span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Notes</span>
                                            <span class="text-wrap lead-primary fw-bold text-uppercase">
                                            	<?= $header['note']; ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Start Date</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= $header['start_date']; ?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">End Date</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $header['end_date']; ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                    <?php if (!empty($header['waktu_masuk'])) { ?>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Waktu Masuk</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= $header['waktu_masuk']; ?>
                                            </span>
                                        </td>
                                    <?php } if (!empty($header['waktu_keluar'])) { ?>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Waktu Keluar</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= $header['waktu_keluar']; ?>
                                            </span>
                                        </td>
                                    <?php } if (!empty($header['files'])){ ?>
                                        <td class="tb-odr-info" colspan="2">
                                            <span class="tb-odr-id text-soft">Files</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <a href="<?php echo base_url();?>assets/documents/documents_tm/<?= $header['files']; ?>" target="_blank"><?= $header['files']; ?></a>
                                            </span>
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
            <hr>
        </div>

        <!-- Request Notes -->
        <div class="nk-ibx-reply-item nk-reply-item">
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-strong">Notes</h5> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <div class="nk-block">
                        <?php if ($form_request['employee_id'] != $this->session->userdata('nik') || ($this->session->userdata('nik') == '20110014')){ ?>
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