<div class="nk-ibx-head">

    <?php if ($header['new_employee_flag'] == 1) {
        $title = 'NEW EMPLOYEE PERFORMANCE PLAN';
    } else {
        $title = 'PERFORMANCE APPRAISAL & PLAN';
    } ?>

    <?php if ($header['is_status'] == 3) {
        $disabled = 'disabled';
        $show = 'none';
        $print = '';

    } else {
        $disabled = '';
        $show = '';
        $print = 'none';
    } ?>

    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(3));?>">
    <input type="hidden" id="approval_id" name="approval_id" value="<?=$approval_id['id'];?>">
    <input type="hidden" id="request_number" name="request_number" value="<?=$header['request_number'];?>">
    <input type="hidden" id="new_employee_flag" name="new_employee_flag" value="<?=$header['new_employee_flag'];?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
                <a href="<?= site_url('inbox/hr_confirmed'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back 
                </a>
            </li>
            <li style="display: <?=$print?>">
                <a href="<?= site_url('services/generate/result_document/kpi/' . $this->uri->segment(3) . '/' . $header['request_number']); ?>" target="_blank" class="btn btn-icon btn-trigger btn-tooltip" title="" data-original-title="Print">
                    <em class="icon ni ni-printer"></em> Print
                </a>
            </li>

        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <!-- Header Request -->
    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title">
                <span class="text-soft"></span><?=$title?>
            </h4>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <span class="badge badge-soft"><?= $header['created_by'];?></span>
                </li>
                <li class="btn-group is-tags">
                    <span class="badge badge-primary"><?= $header['request_number'];?></span>
                </li>
                <li class="btn-group is-tags">
                    <strong>Evaluation Period: Januari <?=$eval_year = date('Y') - 1;?> - Desember <?=$eval_year = date('Y') - 1;?></strong>
                </li>
            </ul>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block" id="request_status">
                <?= status_color($header['is_status']);?>
            </li>
        </ul>
    </div>

    <div class="nk-ibx-reply-group">

        <!-- Detail Request -->
        <div class="nk-ibx-reply-item nk-reply-item">

            <!-- Appraisal -->
            <div class="nk-reply-header nk-ibx-reply-header is-collapsed">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Performance Appraisal</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body">
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
                                            <span class="tb-odr-id text-soft">Nama / NIK</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['employee_name']; ?> / <?= $header['employee_nik']; ?></mark>
                                            </span>
                                         </td>
                                     </tr>
                                     <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Jabatan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['position']; ?></mark>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Jenis Karyawan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['employment_status']; ?> </mark>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Tanggal Bergabung</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['join_date']; ?> </mark>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Divisi</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['division']; ?> </mark>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Departemen</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['departement']; ?> </mark>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Div. Head / C-Level</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['direct_manager']; ?> </mark>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Lokasi Kantor</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= $header['office_location']; ?></mark>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- KPI Achievement -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">II. KPI MEASUREMENT</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="invoice">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table_kpi_achievement">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="w-25">Performance Objective</th>
                                                            <th class="w-25">KPI Measurement</th>
                                                            <th>Target</th>
                                                            <th class="w-15">Achievement</th>
                                                            <th class="w-15">Target vs Achievement</th>
                                                            <th class="w-15 text-left">Score (1-10)</th>
                                                            <th class="w-15 text-left">Weight (%)</th>
                                                            <th class="text-left">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        foreach ($detail as $key) { ?>
                                                            <tr id='kpi_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                     <?=$no;?>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_objective-<?= $key['id']; ?>"><?= $key['objective']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_measurement-<?= $key['id']; ?>"><?= $key['measurement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_target_per_year-<?= $key['id']; ?>"><?= $key['target_per_year']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_achievement-<?= $key['id']; ?>"><?= $key['achievement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_target_vs_achievement-<?= $key['id']; ?>"><?= $key['target_vs_achievement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_score-<?= $key['id']; ?>"><?= $key['score']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_row_time-<?= $key['id']; ?>"><?= $key['time']; ?></b>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_row_total-<?= $key['id']; ?>"><?= $key['total']; ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php $no++; } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5"></td>
                                                            <td>
                                                                <p class="text-danger text-uppercase" id="alert_max_weight" style="display: none;">
                                                                    <em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Total max Weight must be 100
                                                                </p>      
                                                            </td>
                                                            <td colspan="1" class="text-secondary">
                                                                <b>Total Weight(%) / KPI Score</b>
                                                            </td>
                                                            <td>
                                                                <input type="text" disabled size="5" value="<?php echo ($header['sub_total_weight'] == 0) ? 0 : $header['sub_total_weight']; ?>" name="kpi_total_weight" id="kpi_total_weight">
                                                            </td>
                                                            <td>
                                                                <input class="text-right" type="text" disabled size="5" value="<?php echo ($header['sub_total_kpi'] == 0) ? 0 : $header['sub_total_kpi']; ?>" name="kpi_total_score" id="kpi_total_score">
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Qualitative Assesment -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">III. QUALITATIVE ASSESMENT</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="invoice">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table_kpi_achievement">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-gray-100">No.</th>
                                                            <th class="w-20 bg-gray-100">COMPETENCIES</th>
                                                            <th class="bg-gray-100">WEIGHT</th>
                                                            <th class="w-15 bg-gray-100">SCORE (1-10)</th>
                                                            <th class="bg-gray-100">Score vs Weight</th>
                                                            <th class="w-25 bg-gray-100">Weak (1-5)</th>
                                                            <th class="w-25 bg-gray-100">Moderate (6-7)</th>
                                                            <th class="w-25 bg-gray-100">Strong (8-9)</th>
                                                            <th class="w-25 bg-gray-100">Exceptional (10)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="tr_1">
                                                            <td>1</td>
                                                            <td>Work Efficiency</td>
                                                            <td>
                                                                15%
                                                                <input type="hidden" value="15" id="plan_weight_1" name="plan_weight_1">
                                                            </td>
                                                            <td>
                                                                <?= $header['work_efficiency']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['work_efficiency_result']; ?>
                                                            </td>
                                                            <td>Unable to complete assigned work.</td>
                                                            <td>Able to complete most assigned work</td>
                                                            <td>Able to complete all assigned work</td>
                                                            <td>Consistently delivers additional work.</td>
                                                        </tr>
                                                        <tr id="tr_2">
                                                            <td>2</td>
                                                            <td>Work Quality</td>
                                                            <td>
                                                                15%
                                                                <input type="hidden" value="15" id="plan_weight_2" name="plan_weight_2">
                                                            </td>
                                                            <td>
                                                                <?= $header['work_quality']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['work_quality_result']; ?>
                                                            </td>
                                                            <td>Work quality is below expectations</td>
                                                            <td>Work quality meets expectations</td>
                                                            <td>Work quality meets and sometimes exceeds expectations</td>
                                                            <td>Work quality consistently exceeds expectations</td>
                                                        </tr>
                                                        <tr id="tr_3">
                                                            <td>3</td>
                                                            <td>Communication</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_3" name="plan_weight_3">
                                                            </td>
                                                            <td>
                                                                <?= $header['communication']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['communication_result']; ?>
                                                            </td>
                                                            <td>Weak delivery and content</td>
                                                            <td>Moderate delivery and content</td>
                                                            <td>Good delivery and adequate content</td>
                                                            <td>Excellent delivery and very adequate content</td>
                                                        </tr>
                                                        <tr id="tr_4">
                                                            <td>4</td>
                                                            <td>Planning and Organizing</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_4" name="plan_weight_4">
                                                            </td>
                                                            <td>
                                                                <?= $header['planing']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['planing_result']; ?>
                                                            </td>
                                                            <td>Lacks ability to plan. Lacks ability to set priorities.</td>
                                                            <td>Shows some ability to plan. Shows some ability to set priorities. Shows some ability to organize work tasks.</td>
                                                            <td>Able to plan. Able to set priorities. Able to organize work tasks.</td>
                                                            <td>Shows high skiils in planning and priority setting. Very organized in accomplishing work tasks.</td>
                                                        </tr>
                                                        <tr id="tr_5">
                                                            <td>5</td>
                                                            <td>Problem Solving</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_5" name="plan_weight_5">
                                                            </td>
                                                            <td>
                                                                <?= $header['problem_solving']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['problem_solving_result']; ?>
                                                            </td>
                                                            <td>Unable to identify the real problems and the causes of the problems.</td>
                                                            <td>Able to identify the real problems or the causes of the problems</td>
                                                            <td>Able to identify the real problems or the causes of the problems. Able to solve problems with good results.</td>
                                                            <td>Able to identify the real problems or the causes of the problems. Able to solve problems systematically and analytically with significant results and has a back-up plan.</td>
                                                        </tr>
                                                        <tr id="tr_6">
                                                            <td>6</td>
                                                            <td>Team Work</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_6" name="plan_weight_6">
                                                            </td>
                                                            <td>
                                                                <?= $header['team_work']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['team_work_result']; ?>
                                                            </td>
                                                            <td>Does not consider the effect of personal work on others.</td>
                                                            <td>Considers the effect of personal work on others</td>
                                                            <td>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.</td>
                                                            <td>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.Able to mediate differences in team. </td>
                                                        </tr>
                                                        <tr id="tr_7">
                                                            <td>7</td>
                                                            <td>Potential</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_7" name="plan_weight_7">
                                                            </td>
                                                            <td>
                                                                <?= $header['potential']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['potential_result']; ?>
                                                            </td>
                                                            <td>Lacks capacity to learn. Lacks capacity to take new responsibilities.</td>
                                                            <td>Shows capacity to learn. Shows capacity to take new responsibilities.</td>
                                                            <td>Shows strong capacity to learn. Shows strong capacity to take new responsibilities.</td>
                                                            <td>Shows very strong capacity to learn. Shows very strong capacity to take new and challenging responsibilities.Excel in constrained situations.</td>
                                                        </tr>
                                                        <tr id="tr_8">
                                                            <td>8</td>
                                                            <td>Initiative</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_8" name="plan_weight_8">
                                                            </td>
                                                            <td>
                                                                <?= $header['initiative']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['initiative_result']; ?>
                                                            </td>
                                                            <td>Waits for instructions to do the job. Prefers to stay in the comfort zone/status quo rather than initiate the change.</td>
                                                            <td>Does the job as instructed. Initiates change occasionally.</td>
                                                            <td>Does the job more than instructed. Frequently initiates changes that create a positive impact in the current situation.</td>
                                                            <td>Actively initiate ideas that add value to the current situation and with innovation.</td>
                                                        </tr>
                                                        <tr id="tr_9">
                                                            <td>9</td>
                                                            <td>Leadership</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_9" name="plan_weight_9">
                                                            </td>
                                                            <td>
                                                                <?= $header['leadership']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $header['leadership_result']; ?>
                                                            </td>
                                                            <td>Unable to Lead people</td>
                                                            <td>Able to manage people to achieve work goals.</td>
                                                            <td>Able to manage people to achieve work goals. Sets clear directions for others.</td>
                                                            <td>Able to lead a team to achieve excellent team results. Visionary</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-secondary">
                                                                <b>Total Qualitative Assesment Score</b>
                                                            </td>
                                                            <td class="lead-text">
                                                                <?= $header['sub_total_qualitative']; ?>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">IV. TOTAL KPI & QUALITATIVE ASSESMENT SCORE</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="invoice">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table_kpi_achievement">
                                                    <tr>
                                                        <td class="w-60"><b>KPI Score</b></td>
                                                        <td class="w-15"><b>85%</b></td>
                                                        <td>
                                                            <input type="text" disabled value="<?php echo ($header['sub_total_kpi'] == 0) ? 0 : $header['sub_total_kpi']; ?>" name="total_kpi_score" id="total_kpi_score">
                                                        </td>
                                                        <td>
                                                            <b><input type="number" value="<?php echo ($header['grand_total_kpi'] == 0) ? 0 : $header['grand_total_kpi']; ?>" disabled name="grand_total_kpi" id="grand_total_kpi"></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Qualitative Assesment Score</b></td>
                                                        <td><b>15%</b></td>
                                                        <td>
                                                            <input type="text" disabled value="<?php echo ($header['sub_total_qualitative'] == 0) ? 0 : $header['sub_total_qualitative']; ?>" name="total_qualitative" id="total_qualitative">
                                                        </td>
                                                        <td>
                                                            <b><input type="number" value="<?php echo ($header['grand_total_qualitative'] == 0) ? 0 : $header['grand_total_qualitative']; ?>" disabled name="grand_total_qualitative" id="grand_total_qualitative"></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Pre Final Score</b></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <b><input type="number" value="<?php echo ($header['pre_final_score'] == 0) ? 0 : $header['pre_final_score']; ?>" disabled name="pre_final_score" id="pre_final_score"></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Final Score</b></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <b>
                                                                <input type="number" oninput="maxLengthCheck(this)" maxlength="5" min="1" max="10" onkeypress="return isNumeric(event)" <?=$disabled?> class="form-control" name="final_score" id="final_score" value="<?=$header['final_score']?>" >
                                                            </b>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                                <table class="table table-striped" style="width: 500px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Description</th>
                                                            <th>Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><b>Actual Performance > 110%</b></td>
                                                            <td><b>A (9.1 - 10)</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>100% - 110%</b></td>
                                                            <td><b>B (8.1 - 9.0)</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>80% - 99%</b></td>
                                                            <td><b>C (6.9 - 8.0)</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>60% - 79%</b></td>
                                                            <td><b>D (5.6 - 6.8)</b></td>
                                                        </tr>
                                                         <tr>
                                                            <td><b>< 60%</b></td>
                                                            <td><b>E (0.0 - 5.5)</b></td>
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

                    <!-- DEVELOPMENT PLAN & RECOMMENDATION -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">V. DEVELOPMENT PLAN & RECOMMENDATION</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="thumb">AREA FOR IMPROVEMENT (Competency, Technical Skill, Soft Skill, Leadership, etc)</label>
                                            <div class="form-control-wrap">
                                                <textarea rows="5" name="area_improvement" id="area_improvement" class="form-control"><?= $header['area_improvement']; ?></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="form-label" for="thumb">DEVELOPMENT PLAN (Training, On The Job Training)</label>
                                            <div class="form-control-wrap">
                                                <textarea rows="5" name="development_plan" id="development_plan" class="form-control"><?= $header['development_plan']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- COMMENT -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">VI. COMMENT</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="w-40">
                                        <div class="form-group">
                                            <label class="form-label" for="thumb">Employee</label>
                                            <textarea rows="3" id="comment_employee" name="comment_employee" class="form-control"><?= $header['comment_employee']; ?></textarea>
                                        </div>
                                    </td>
                                    <td class="w-40">
                                        <div class="form-group">
                                            <label class="form-label" for="thumb">Head 1</label>
                                            <textarea rows="3" id="comment_head_1" name="comment_head_1" class="form-control"><?= $header['comment_head_1']; ?></textarea>
                                        </div>
                                    </td>
                                    <td class="w-40">
                                        <div class="form-group">
                                            <label class="form-label" for="thumb">Head 2</label>
                                            <textarea rows="3" id="comment_head_2" name="comment_head_2" class="form-control"><?= $header['comment_head_2']; ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <br>
            <!-- Performance Plan -->
            <div class="nk-reply-header nk-ibx-reply-header is-collapsed">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Performance Plan</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body">
                <div class="nk-reply-entry entry">

                    <!-- Performance Objective/KPIs -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">I. PERFORMANCE OBJECTIVES / KPIs</strong>
                                
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="invoice">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="w-20">Performance Objective</th>
                                                            <th class="w-20">KPI Measurement</th>
                                                            <th class="w-15">Weight %</th>
                                                            <th class="text-left">Unit</th>
                                                            <th class="w-15 text-secondary text-left">Target <?= $nextYear = date('Y'); ?></th>
                                                            <th class="w-15 text-secondary text-left">Semester 1</th>
                                                            <th class="w-15 text-secondary text-left">Semester 2</th>
                                                            <th class="text-left">Total</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2" class="text-secondary">
                                                                Financial Perspective
                                                            </th>
                                                            <th colspan="7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="financial_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == 'financial_perspective') { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <?=$no;?>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= $key['objective']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= $key['measurement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= $key['time']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= $key['unit']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= $key['target']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= $key['semester_1']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= $key['semester_2']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= $key['total']; ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>

                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-secondary">
                                                                Customer Perspective
                                                            </th>
                                                            <th colspan="7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="cust_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == 'cust_perspective') { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <?=$no;?>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= $key['objective']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= $key['measurement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= $key['time']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= $key['unit']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= $key['target']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= $key['semester_1']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= $key['semester_2']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= $key['total']; ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>

                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-secondary">
                                                                Internal Process
                                                            </th>
                                                            <th colspan="7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="intern_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == 'intern_perspective') { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <?=$no;?>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= $key['objective']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= $key['measurement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= $key['time']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= $key['unit']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= $key['target']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= $key['semester_1']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= $key['semester_2']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= $key['total']; ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>

                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-secondary">
                                                                Learning & Growth
                                                            </th>
                                                            <th colspan="7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="learn_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == 'learn_perspective') { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <?=$no;?>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= $key['objective']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= $key['measurement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= $key['time']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= $key['unit']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= $key['target']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= $key['semester_1']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= $key['semester_2']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= $key['total']; ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td class="text-secondary">
                                                                <b>Total Weight(%)</b>
                                                            </td>
                                                            <td colspan="6" class="text-left">
                                                                <input type="text" disabled size="5" value="<?php echo ($header['plan_total_weight'] == 0) ? 0 : $header['plan_total_weight']; ?>" name="plan_total_weight" id="plan_total_weight">
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <!-- Approval Layer -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Approval Summary</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">

                    <div class="nk-block nk-block-lg">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Layer</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($approval as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value['approval_priority']; ?></td>
                                        <td><?= $value['approval_alias']; ?></td>
                                        <td><?= approval_status($value['approval_status']); ?></td>
                                        <td><?= str_replace('.000', '', $value['updated_at']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
                        <div class="nk-block-head nk-block-head-sm nk-block-between">
                            <a data-toggle="modal" data-target="#modalAddNotes" class="btn btn-md text-primary">+ Add Note</a>
                        </div>
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
                                        <a id="<?= $value['id'] ?>" style="cursor: pointer;"  onclick="return delete_notes(this.id)" class="link link-sm link-danger">Delete Note</a>
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