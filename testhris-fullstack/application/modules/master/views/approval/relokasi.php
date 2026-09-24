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
            $show = ''; 
            break;
        }
    }

    ?>
    <input type="hidden" id="request_id" name="request_id" value="<?=decode_url($this->uri->segment(4));?>">
    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(4));?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <?php if (($form_request['employee_id'] != $this->session->userdata('nik'))) { ?>
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
                            <li><a class="dropdown-item" onclick="return responseRequestReloc(this.id);" id="Approved"><span>Approve</span></a></li>
                            <?php } ?>
                            <?php if (!(($is_status == 3) && ($today > date('Y-m-d', strtotime('+1 Month', strtotime($getMonth.'-10')))))) { ?>
                                <li><a class="dropdown-item" onclick="return responseRequestReloc(this.id);" id="Reject"><span>Reject</span></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </li>
            <?php } else { ?>
            <li class="ml-n2">
                <a href="<?= site_url('master/office'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back to Master Office
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <!-- Header Request -->
    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title"><span class="text-soft">MASTER OFFICE: </span>TEMPORARY RELOCATION</h4>
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
                                                        <?php break; }?>
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
            <?php } ?>

            <!-- Time-Off Form -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">TEMPORARY RELOCATION FORM</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">

                    <!-- Schedule Information -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">I. RELOCATION INFORMATION</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <table class="table table-orders">
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Employee ID</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= $header['nik']; ?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Employee Name</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= $header['full_name']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Original PA</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= $header['pa_awal']; ?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Relocated PA</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= $header['pa_akhir']; ?>
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
                                </tbody>
                            </table>
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
                        <?php if ($form_request['employee_id'] != $this->session->userdata('nik') || $is_status != 1){ ?>
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