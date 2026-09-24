<style>
.custom-avatar-num {
    /* 1. Kunci ukuran lingkaran agar sama besar (Symmetrical) */
    width: 40px !important;
    height: 40px !important;
    
    /* 2. Paksa jadi bulat sempurna */
    border-radius: 50% !important;
    
    /* 3. Menghindari lingkaran menjadi lonjong/gepeng karena desakan input */
    flex-shrink: 0; 
    
    /* 4. Membuat nomor berada tepat di tengah-tengah lingkaran */
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    
    /* 5. Styling teks nomor  */
    font-weight: 600;
    font-size: 14px;
}
</style>
<div class="nk-ibx-head">
    <?php if (($header['is_status'] == 3) || ($header['is_status'] == 1) || ($header['is_status'] == 4)) {
        $disabled = 'disabled';
        $show = 'none';
    } else {
        $disabled = '';
        $show = '';
    } 

    // dumper($header);
    ?>

    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(4));?>">
    <input type="hidden" id="id_form_request" name="id_form_request" value="<?=$id_form_request;?>">
	<input type="hidden" id="is_status" name="is_status" value="<?=$header['is_status'];?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
            	<a href="<?= site_url('home/request'); ?>" class="btn btn-icon btn-tooltip" title="Back">
            		<em class="icon ni ni-arrow-left"></em>
            		Back
            	</a>
            </li>
            <li style="display: <?=$show?>">
            	<a id="submit_new_request" class="btn btn-icon">
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
            <h4 class="title"><span class="text-strong">CREATE: </span>PERFORMANCE APPRAISAL & PLAN</h4>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <strong>Evaluation Period: Januari <?=$eval_year = date('Y') - 1;?> - Desember <?=$eval_year = date('Y') - 1;?></strong>
                </li>
            </ul>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block">
                <?= status_color($header['is_status']);?>
            </li>
        </ul>
    </div>

    <div class="nk-ibx-reply-group">

        <!-- Detail Request -->
        <div class="nk-ibx-reply-item nk-reply-item">

            <!-- Appraisal -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-strong">Performance Appraisal</h5> 
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
                                <strong class="text-secondary">I. PERSONAL DETAILS INFORMATION</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <table class="table table-orders">
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Nama / NIK</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<mark><?= decrypt($header['employee_name']); ?> / <?= $header['employee_nik']; ?></mark>
                                            </span>
                                         </td>
                                     </tr>
                                     <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Jabatan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<mark><?= decrypt($header['position']); ?></mark>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Jenis Karyawan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<mark><?= decrypt($header['employment_status']); ?> </mark>
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
                                            	<mark><?= decrypt($header['division']); ?> </mark>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Departemen</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= decrypt($header['departement']); ?> </mark>
                                            </span>
											<input type="hidden" id="kpi_departemen" name="kpi_departemen" value="<?= decrypt($header['departement']); ?>">
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Div. Head / C-Level</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= decrypt($header['direct_manager']); ?> </mark>
                                            </span>
											<input type="hidden" id="atasan_langsung" name="atasan_langsung" value="<?= decrypt($header['direct_manager']); ?>">
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Lokasi Kantor</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <mark><?= decrypt($header['office_location']); ?></mark>
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
                                <span>
                                    <a class="text-primary btn btn-icon btn-trigger" onclick = "show_uom_add_kpi()" data-toggle="modal" data-target="#modalAddKPI" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Add KPI Object
                                    </a>
                                </span>
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
                                                            <th class="w-15">Unit</th>
		                                                    <th class="w-15">Target vs Achievement</th>
		                                                    <th class="w-15 text-left">Score (1-10)</th>
		                                                    <th class="w-15 text-left">Weight (%)</th>
		                                                    <th class="text-left">Total</th>
		                                                </tr>
		                                            </thead>
							                        <tbody id="body_kpi_measurement">
                                                        <?php $no = 1;
                                                        // dumper($detail);
                                                        foreach ($detail as $key) { ?>
                                                            <tr id='kpi_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <a onclick='delete_kpi_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
                                                                    
                                                                    <a onclick='update_kpi_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"> <em class="icon ni ni-edit"></em></a>

                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_target_per_year-<?= $key['id']; ?>"><?= decrypt($key['target_per_year']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_achievement-<?= $key['id']; ?>"><?= decrypt($key['achievement']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_target_vs_achievement-<?= $key['id']; ?>"><?= decrypt($key['target_vs_achievement']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_row_score-<?= $key['id']; ?>"><?= decrypt($key['score']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_row_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></b>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_row_total-<?= $key['id']; ?>"><?= decrypt($key['total']); ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php $no++; } ?>
							                        </tbody>
                                                    
								                    <tfoot>
		                                                <tr>
                                                            <td colspan="6">
                                                                <input type="hidden" id="countKpi" name="countKpi" value="<?php echo ($header['count_row_kpi'] == '0') ? 0 : $header['count_row_kpi']; ?>">
                                                                <input type="hidden" id="countScoreIsi" name="countScoreIsi" value="<?php echo ($score_isi == '0') ? 0 : $score_isi; ?>">
                                                            </td>
		                                                    <td>
                                                                <p class="text-danger text-uppercase" id="alert_weight" style="display: none;">
                                                                    <em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Total Weight must be 100%
                                                                </p>      
                                                            </td>
		                                                    <td colspan="1" class="text-secondary">
                                                                <b>Total Weight(%) / KPI Score</b>
                                                            </td>
                                                            <td>
                                                                <input type="text" disabled size="5" value="<?php echo ($header['sub_total_weight'] == '0' || $header['sub_total_weight'] == 'NaN') ? 0 : decrypt($header['sub_total_weight']); ?>" name="kpi_total_weight" id="kpi_total_weight">
                                                            </td>
		                                                    <td>
                                                                <input class="text-right" type="text" disabled size="5" value="<?php echo ($header['sub_total_kpi'] == '0' || $header['sub_total_kpi'] == 'NaN') ? 0 : decrypt($header['sub_total_kpi']); ?>" name="kpi_total_score" id="kpi_total_score">
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

                    <form action="#" class="pt-2 form-validate is-alter" id="form_evidence_kpi">
                    <!-- Documents -->
                    <input type="hidden" class="form-control" required name="request_number" id="request_number" value="<?= $request_number;?>">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">Documentary Evidence</strong>
                            </div>
                        </div>
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="form-label" for="customFileLabel">File Upload</label>    
                                            <div class="form-control-wrap">        
                                                <div class="custom-file">            
                                                    <input type="file" <?=$disabled?> class="custom-file-input" id="FileDocumentsEvidence" name="FileDocumentsEvidence">            
                                                    <label class="custom-file-label" for="FileDocumentsEvidence">Choose file</label>
                                                    <br>
                                                    * Format file : jpg, ppt, pdf, doc, zip, rar, 7z
                                                </div>
                                                <br>
                                                <br>
                                                Documents&nbsp&nbsp:&nbsp<a href="<?php echo base_url();?>assets/documents/documents_pa/<?php echo isset($documentary_evidence[0]['documents']) != '' ? $documentary_evidence[0]['documents'] : ''?>" target="_blank"> <?php echo isset($documentary_evidence[0]['documents']) != '' ? $documentary_evidence[0]['documents'] : ''?></a></b>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" id="btn_save_evidence" class="btn btn-primary"  <?=$disabled?> style="">Save</button>
                    </div> -->
                    </form>

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
                                                            <th class="w-25 bg-gray-100 text-left">Exceptional (10)</th>
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
                                                                <!-- <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(1, '<?=decode_url($this->uri->segment(4));?>');" onClick="return calculate_assesment(1, '<?=decode_url($this->uri->segment(4));?>');" onKeyUp="return calculate_assesment(1, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_1" id="plan_score_1"  value="<?php echo ($header['work_efficiency'] == '') ? '' : decrypt($header['work_efficiency']); ?>"> -->
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(1, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_1" id="plan_score_1"  value="<?php echo ($header['work_efficiency'] == '') ? '' : decrypt($header['work_efficiency']); ?>">
                                                                <br>
                                                                <span id="alert_plan_1" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>

                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_1">
                                                                    <?php echo ($header['work_efficiency_result'] == '') ? '' : decrypt($header['work_efficiency_result']); ?>
                                                                </span>

                                                                <input type="number" value="<?php echo ($header['work_efficiency_result'] == '') ? '' : decrypt($header['work_efficiency_result']); ?>" disabled id="plan_result_1" name="plan_result_1" style="display: none">
                                                            </td>
                                                            <td class='text-left'>Unable to complete assigned work.</td>
                                                            <td class='text-left'>Able to complete most assigned work</td>
                                                            <td class='text-left'>Able to complete all assigned work</td>
                                                            <td class='text-left'>Consistently delivers additional work.</td>
                                                        </tr>
                                                        <tr id="tr_2">
                                                            <td>2</td>
                                                            <td>Work Quality</td>
                                                            <td>
                                                                15%
                                                                <input type="hidden" value="15" id="plan_weight_2" name="plan_weight_2">
                                                            </td>
                                                            <td>
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(2, '<?=decode_url($this->uri->segment(4));?>');"<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_2" id="plan_score_2" value="<?php echo ($header['work_quality'] == '') ? '' : decrypt($header['work_quality']); ?>">
                                                                <br>
                                                                <span id="alert_plan_2" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_2">
                                                                    <?php echo ($header['work_quality_result'] == '') ? '' : decrypt($header['work_quality_result']); ?>
                                                                </span>

                                                                <input type="number" value="<?php echo ($header['work_quality_result'] == '') ? '' : decrypt($header['work_quality_result']); ?>" disabled id="plan_result_2" name="plan_result_2" style="display: none">
                                                            </td>
                                                            <td class='text-left'>Work quality is below expectations</td>
                                                            <td class='text-left'>Work quality meets expectations</td>
                                                            <td class='text-left'>Work quality meets and sometimes exceeds expectations</td>
                                                            <td class='text-left'>Work quality consistently exceeds expectations</td>
                                                        </tr>
                                                        <tr id="tr_3">
                                                            <td>3</td>
                                                            <td>Communication</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_3" name="plan_weight_3">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="comma" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(3, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_3" id="plan_score_3" value="<?php echo ($header['communication'] == '') ? '' : decrypt($header['communication']); ?>">
                                                                <br>
                                                                <span id="alert_plan_3" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_3"><?php echo ($header['communication_result'] == '') ? '' : decrypt($header['communication_result']); ?></span>

                                                                <input type="number" value="<?php echo ($header['communication_result'] == '') ? '' : decrypt($header['communication_result']); ?>" disabled id="plan_result_3" name="plan_result_3" style="display: none;">
                                                            </td>
                                                            <td class='text-left'>Weak delivery and content</td>
                                                            <td class='text-left'>Moderate delivery and content</td>
                                                            <td class='text-left'>Good delivery and adequate content</td>
                                                            <td class='text-left'>Excellent delivery and very adequate content</td>
                                                        </tr>
                                                        <tr id="tr_4">
                                                            <td>4</td>
                                                            <td>Planning and Organizing</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_4" name="plan_weight_4">
                                                            </td>
                                                            <td>
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(4, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_4" id="plan_score_4" value="<?php echo ($header['planing'] == '') ? '' : decrypt($header['planing']); ?>">
                                                                <br>
                                                                <span id="alert_plan_4" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_4"><?php echo ($header['planing_result'] == '') ? '' : decrypt($header['planing_result']); ?></span>

                                                                <input type="number" value="<?php echo ($header['planing_result'] == '') ? '' : decrypt($header['planing_result']); ?>" disabled id="plan_result_4" name="plan_result_4" style="display: none;">
                                                            </td>
                                                            <td class='text-left'>Lacks ability to plan. Lacks ability to set priorities.</td>
                                                            <td class='text-left'>Shows some ability to plan. Shows some ability to set priorities. Shows some ability to organize work tasks.</td>
                                                            <td class='text-left'>Able to plan. Able to set priorities. Able to organize work tasks.</td>
                                                            <td class='text-left'>Shows high skiils in planning and priority setting. Very organized in accomplishing work tasks.</td>
                                                        </tr>
                                                        <tr id="tr_5">
                                                            <td>5</td>
                                                            <td>Problem Solving</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_5" name="plan_weight_5">
                                                            </td>
                                                            <td>
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(5, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_5" id="plan_score_5" value="<?php echo ($header['problem_solving'] == '') ? '' : decrypt($header['problem_solving']); ?>">
                                                                <br>
                                                                <span id="alert_plan_5" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_5"><?php echo ($header['problem_solving_result'] == '') ? '' : decrypt($header['problem_solving_result']); ?></span>

                                                                <input type="number" value="<?php echo ($header['problem_solving_result'] == '') ? '' : decrypt($header['problem_solving_result']); ?>" disabled id="plan_result_5" name="plan_result_5" style="display: none;">
                                                            </td>
                                                            <td class='text-left'>Unable to identify the real problems and the causes of the problems.</td>
                                                            <td class='text-left'>Able to identify the real problems or the causes of the problems</td>
                                                            <td class='text-left'>Able to identify the real problems or the causes of the problems. Able to solve problems with good results.</td>
                                                            <td class='text-left'>Able to identify the real problems or the causes of the problems. Able to solve problems systematically and analytically with significant results and has a back-up plan.</td>
                                                        </tr>
                                                        <tr id="tr_6">
                                                            <td>6</td>
                                                            <td>Team Work</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_6" name="plan_weight_6">
                                                            </td>
                                                            <td>
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(6, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_6" id="plan_score_6" value="<?php echo ($header['team_work'] == '') ? '' : decrypt($header['team_work']); ?>">
                                                                <br>
                                                                <span id="alert_plan_6" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_6"><?php echo ($header['team_work_result'] == '') ? '' : decrypt($header['team_work_result']); ?></span>

                                                                <input type="number" value="<?php echo ($header['team_work_result'] == '') ? '' : decrypt($header['team_work_result']); ?>" disabled id="plan_result_6" name="plan_result_6" style="display: none;">
                                                            </td>
                                                            <td class='text-left'>Does not consider the effect of personal work on others.</td>
                                                            <td class='text-left'>Considers the effect of personal work on others</td>
                                                            <td class='text-left'>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.</td>
                                                            <td class='text-left'>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.Able to mediate differences in team. </td>
                                                        </tr>
                                                        <tr id="tr_7">
                                                            <td>7</td>
                                                            <td>Potential</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_7" name="plan_weight_7">
                                                            </td>
                                                            <td>
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(7, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_7" id="plan_score_7" value="<?php echo ($header['potential'] == '') ? '' : decrypt($header['potential']); ?>">
                                                                <br>
                                                                <span id="alert_plan_7" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_7"><?php echo ($header['potential_result'] == '') ? '' : decrypt($header['potential_result']); ?></span>

                                                                <input type="number" value="<?php echo ($header['potential_result'] == '') ? '' : decrypt($header['potential_result']); ?>" disabled id="plan_result_7" name="plan_result_7" style="display: none;">
                                                            </td>
                                                            <td class='text-left'>Lacks capacity to learn. Lacks capacity to take new responsibilities.</td>
                                                            <td class='text-left'>Shows capacity to learn. Shows capacity to take new responsibilities.</td>
                                                            <td class='text-left'>Shows strong capacity to learn. Shows strong capacity to take new responsibilities.</td>
                                                            <td class='text-left'>Shows very strong capacity to learn. Shows very strong capacity to take new and challenging responsibilities.Excel in constrained situations.</td>
                                                        </tr>
                                                        <tr id="tr_8">
                                                            <td>8</td>
                                                            <td>Initiative</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_8" name="plan_weight_8">
                                                            </td>
                                                            <td>
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(8, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_8" id="plan_score_8" value="<?php echo ($header['initiative'] == '') ? '' : decrypt($header['initiative']); ?>">
                                                                <br>
                                                                <span id="alert_plan_8" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_8"><?php echo ($header['initiative_result'] == '') ? '' : decrypt($header['initiative_result']); ?></span>

                                                                <input type="number" value="<?php echo ($header['initiative_result'] == '') ? '' : decrypt($header['initiative_result']); ?>" disabled id="plan_result_8" name="plan_result_8" style="display: none;">
                                                            </td>
                                                            <td class='text-left'>Waits for instructions to do the job. Prefers to stay in the comfort zone/status quo rather than initiate the change.</td>
                                                            <td class='text-left'>Does the job as instructed. Initiates change occasionally.</td>
                                                            <td class='text-left'>Does the job more than instructed. Frequently initiates changes that create a positive impact in the current situation.</td>
                                                            <td class='text-left'>Actively initiate ideas that add value to the current situation and with innovation.</td>
                                                        </tr>
                                                        <tr id="tr_9">
                                                            <td>9</td>
                                                            <td>Leadership</td>
                                                            <td>
                                                                10%
                                                                <input type="hidden" value="10" id="plan_weight_9" name="plan_weight_9">
                                                            </td>
                                                            <td>
                                                                <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_assesment(9, '<?=decode_url($this->uri->segment(4));?>');" placeholder="Score" name="plan_score_9" id="plan_score_9" value="<?php echo ($header['leadership'] == '') ? '' : decrypt($header['leadership']); ?>">
                                                                <br>
                                                                <span id="alert_plan_9" style="display: none">
                                                                    Please enter value less than or equal to 10
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="tb_plan_result_9"><?php echo ($header['leadership_result'] == '') ? '' : decrypt($header['leadership_result']); ?></span>

                                                                <input type="number" class="form-control" value="<?php echo ($header['leadership_result'] == '') ? '' : decrypt($header['leadership_result']); ?>" disabled id="plan_result_9" name="plan_result_9" style="display: none">
                                                            </td>
                                                            <td class='text-left'>Unable to Lead people</td>
                                                            <td class='text-left'>Able to manage people to achieve work goals.</td>
                                                            <td class='text-left'>Able to manage people to achieve work goals. Sets clear directions for others.</td>
                                                            <td class='text-left'>Able to lead a team to achieve excellent team results. Visionary</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-secondary">
                                                                <b>Total Qualitative Assesment Score</b>
                                                            </td>
                                                            <td>
                                                                <input type="text" disabled size="8" value="<?php echo ($header['sub_total_qualitative'] == '' or $header['sub_total_qualitative'] == 0) ? '' : decrypt($header['sub_total_qualitative']); ?>" name="kpi_total_assesment" id="kpi_total_assesment">
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
                                                            <input type="text" disabled value="<?php echo ($header['sub_total_kpi'] == '0' or $header['sub_total_kpi'] == '' or $header['sub_total_kpi'] == 'NaN') ? 0 : decrypt($header['sub_total_kpi']); ?>" name="total_kpi_score" id="total_kpi_score">
                                                        </td>
                                                        <td>
                                                            <b><input type="number" value="<?php echo ($header['grand_total_kpi'] == '0' or $header['grand_total_kpi'] == '' or $header['grand_total_kpi'] == 'NaN') ? 0 : decrypt($header['grand_total_kpi']); ?>" disabled name="grand_total_kpi" id="grand_total_kpi"></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Qualitative Assesment Score</b></td>
                                                        <td><b>15%</b></td>
                                                        <td>
                                                            <input type="text" disabled value="<?php echo ($header['sub_total_qualitative'] == 0 || $header['sub_total_qualitative'] == 'NaN') ? 0 : decrypt($header['sub_total_qualitative']); ?>" name="total_qualitative" id="total_qualitative">
                                                        </td>
                                                        <td>
                                                            <b><input type="number" value="<?php echo ($header['grand_total_qualitative'] == 0 || $header['grand_total_qualitative'] == 'NaN') ? 0 : decrypt($header['grand_total_qualitative']); ?>" disabled name="grand_total_qualitative" id="grand_total_qualitative"></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Pre Final Score</b></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <b><input type="number" value="<?php echo ($header['pre_final_score'] == 0 || $header['pre_final_score'] == 'NaN') ? 0 : decrypt($header['pre_final_score']); ?>" disabled name="pre_final_score" id="pre_final_score"></b>
                                                        </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td>Final Score</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><b>88</b></td>
                                                    </tr> -->
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
                                    <div class="form-group">
                                        <label class="form-label" for="thumb">AREA FOR IMPROVEMENT (Competency, Technical Skill, Soft Skill, Leadership, etc)</label>
                                        <div class="form-control-wrap">
                                            <textarea rows="5" name="area_improvement" id="area_improvement" onchange="return text_area('area_improvement', '<?=decode_url($this->uri->segment(4));?>');" class="form-control"><?=decrypt($header['area_improvement'])?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div>&nbsp;</div>
						<label class="form-label" for="thumb">DEVELOPMENT PLAN (Training, On The Job Training)</label>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="invoice">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <span>
                                                    <a class="text-primary btn btn-icon btn-trigger" id="hard" onclick="return modal_add_skill(this.id);" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Hard Skill
                                                    </a>
                                                </span>
                                                <span>
                                                    <a class="text-primary btn btn-icon btn-trigger" id="soft" onclick="return modal_add_skill(this.id);" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Soft Skill
                                                    </a>
                                                </span>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-5">Category</th>
                                                            <th class="w-20">Training Name</th>
                                                            <th class="w-40">Description</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="8">
                                                                <p class="text-danger text-uppercase" id="alert_hardskill" style="display: none;"><em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Max 2 rows
                                                                </p> 
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="training_table">
                                                        <?php foreach ($training as $key) { ?>
                                                            <tr id='kpi_training_row-<?= $key['id']; ?>'>
                                                                <td id='kpi_training_cat-<?= $key['id']; ?>'>
                                                                    <a onclick='delete_training_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em>
                                                                    <b id='kpi_training_category-<?= $key["id"]; ?>'>
                                                                        
                                                                        <?php if ($key["category"] == encrypt('soft')) {
                                                                            echo 'Soft Skill';
                                                                        } else {
                                                                            echo 'Hard Skill';
                                                                        } ?>
                                                                            
                                                                    </b>
                                                                    </a>
                                                                    <br>
                                                                </td>
                                                                <td id="kpi_training_name-<?= $key['id']; ?>">
                                                                    <b id="kpi_training_name-<?= $key['id']; ?>"><?= decrypt($key['training_name']); ?></b>
                                                                </td>
                                                                <td id="kpi_training_desc-<?= $key['id']; ?>" class="text-left">
                                                                    <b id="kpi_training_desc-<?= $key['id']; ?>"><?= decrypt($key['training_desc']); ?></b>
                                                                </td>
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
                        <input type="hidden" id="countTraining" value="<?php echo count($training); ?>">
                    </div>

                    <!-- COMMENT -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">VI. COMMENT</strong>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="thumb">Employee</label>
                                            <div class="form-control-wrap">
                                                <textarea rows="1" name="comment_employee" id="comment_employee" onchange="return text_area('comment_employee', '<?=decode_url($this->uri->segment(4));?>');" class="form-control"><?=decrypt($header['comment_employee'])?></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <!-- <div class="form-group">
                                            <label class="form-label" for="thumb">Head 1</label>
                                            <div class="form-control-wrap">
                                                <textarea rows="1" name="comment_head_1" id="comment_head_1" class="form-control"><?=decrypt($header['comment_head_1'])?></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="form-label" for="thumb">Head 2</label>
                                            <div class="form-control-wrap">
                                                <textarea rows="1" name="comment_head_2" id="comment_head_2" class="form-control"><?=decrypt($header['comment_head_2'])?></textarea>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr>
            <br>
            <!-- Performance Plan -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-strong">Performance Plan</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">

                    <!-- Performance Objective/KPIs -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <!-- <strong class="text-secondary">I. PERFORMANCE OBJECTIVES / KPIs (**Maximum 2 rows on each perspective)</strong> -->
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
                                                            <!-- <th class="w-15 text-secondary text-left">Semester 1</th>
                                                            <th class="w-15 text-secondary text-left">Semester 2</th>
                                                            <th class="text-left">Total</th> -->
                                                        </tr>
                                                        <tr>
                                                            <th colspan="1" class="text-secondary">
                                                                Financial Perspective
                                                                <span>
                                                                    <a class="text-primary btn btn-icon btn-trigger" id="f" onclick="return modal_add_plan(this.id);" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Add
                                                                    </a>
                                                                </span>
                                                            </th>
                                                            <th colspan="7">
                                                                <p class="text-danger text-uppercase" id="alert_financial" style="display: none;"><em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Max 2 rows
                                                                </p> 
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="financial_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == encrypt('financial_perspective')) { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <a onclick='delete_plan_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
                                                                    <br>
                                                                    <a onclick='modal_update_plan(<?=$key["id"]?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-edit"></em></a>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                                                                </td>
                                                                <!-- <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= decrypt($key['semester_1']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= decrypt($key['semester_2']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= decrypt($key['total']); ?></b>
                                                                </td> -->
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>

                                                    <thead>
                                                        <tr>
                                                            <th colspan="1" class="text-secondary">
                                                                Customer Perspective
                                                                <span>
                                                                    <a class="text-primary btn btn-icon btn-trigger" id="c" onclick="return modal_add_plan(this.id);" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Add
                                                                    </a>
                                                                </span>
                                                            </th>
                                                            <th colspan="7">
                                                                <p class="text-danger text-uppercase" id="alert_customer" style="display: none;"><em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Max 2 rows
                                                                </p> 
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="cust_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == encrypt('cust_perspective')) { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <a onclick='delete_plan_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
                                                                    <br>
                                                                    <a onclick='modal_update_plan(<?=$key["id"]?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-edit"></em></a>

                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                                                                </td>
                                                                <!-- <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= decrypt($key['semester_1']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= decrypt($key['semester_2']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= decrypt($key['total']); ?></b> -->
                                                                </td>
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>

                                                    <thead>
                                                        <tr>
                                                            <th colspan="1" class="text-secondary">
                                                                Internal Process
                                                                <span>
                                                                    <a class="text-primary btn btn-icon btn-trigger" id="i" onclick="return modal_add_plan(this.id);" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Add
                                                                    </a>
                                                                </span>
                                                            </th>
                                                            <th colspan="7">
                                                                <p class="text-danger text-uppercase" id="alert_internal" style="display: none;"><em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Max 2 rows
                                                                </p> 
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="intern_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == encrypt('intern_perspective')) { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <a onclick='delete_plan_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
                                                                    <br>
                                                                    <a onclick='modal_update_plan(<?=$key["id"]?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-edit"></em></a>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                                                                </td>
                                                                <!-- <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= decrypt($key['semester_1']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= decrypt($key['semester_2']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= decrypt($key['total']); ?></b>
                                                                </td> -->
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>

                                                    <thead>
                                                        <tr>
                                                            <th colspan="1" class="text-secondary">
                                                                Learning & Growth
                                                                <span>
                                                                    <a class="text-primary btn btn-icon btn-trigger" id="l" onclick="return modal_add_plan(this.id);" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Add
                                                                    </a>
                                                                </span>
                                                            </th>
                                                            <th colspan="7">
                                                                <p class="text-danger text-uppercase" id="alert_learning" style="display: none;"><em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Max 2 rows
                                                                </p> 
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="learn_perspective">
                                                        <?php $no = 1;
                                                        foreach ($additional as $key) { 
                                                        if ($key['plan_perspective'] == encrypt('learn_perspective')) { ?>
                                                            <tr id='plan_row-<?= $key['id']; ?>'>
                                                                <td>
                                                                    <a onclick='delete_plan_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
                                                                    <br>
                                                                    <a onclick='modal_update_plan(<?=$key["id"]?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-edit"></em></a>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                                                                </td>
                                                                <!-- <td scope="row">
                                                                    <span id="kpi_plan_semester_1-<?= $key['id']; ?>"><?= decrypt($key['semester_1']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <span id="kpi_plan_semester_2-<?= $key['id']; ?>"><?= decrypt($key['semester_2']); ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    <b id="kpi_plan_total-<?= $key['id']; ?>"><?= decrypt($key['total']); ?></b>
                                                                </td> -->
                                                            </tr>
                                                        <?php $no++; }  } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2">
                                                                <input type="hidden" id="countPlanFinancial" value="<?php echo ($header['count_plan_financial'] == 0) ? 0 : $header['count_plan_financial']; ?>">
                                                                <input type="hidden" id="countPlanCustomer" value="<?php echo ($header['count_plan_customer'] == 0) ? 0 : $header['count_plan_customer']; ?>">
                                                                <input type="hidden" id="countPlanInternal" value="<?php echo ($header['count_plan_internal'] == 0) ? 0 : $header['count_plan_internal']; ?>">
                                                                <input type="hidden" id="countPlanLearning" value="<?php echo ($header['count_plan_learning'] == 0) ? 0 : $header['count_plan_learning']; ?>">
                                                            </td>
                                                            <td class="text-secondary">
                                                                <b>Total Weight(%)</b>
                                                            </td>
                                                            <td colspan="6" class="text-left">
                                                                <input type="text" disabled size="5" value="<?php echo ($header['plan_total_weight'] == '0' || $header['plan_total_weight'] == '' || $header['plan_total_weight'] == 'NaN') ? 0 : decrypt($header['plan_total_weight']); ?>" name="plan_total_weight" id="plan_total_weight">
                                                                <br>
                                                                <p class="text-danger text-uppercase" id="alert_plan_weight" style="display: none;">
                                                                    <em class="icon ni ni-alert-circle-fill"></em> 
                                                                    Total max Weight must be 100
                                                                </p> 
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
            <hr>
            <br>
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

          <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <div class="nk-block nk-block-lg">

                        <div class="col-md-8">
                            <div class="card card-bordered card-stretch" style="width:auto;">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Approver</h6> 
                                            </div>
                                            <div class="card-tools">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-lg" id="row1">
                                        <?php 
                                            $no = 1;
                                            foreach($layer as $key => $val){
                                                if($val != ""){
                                                    ?>
                                                    <!-- Tambahkan mb-3 agar antar baris ada jarak vertikal jika data lebih dari 1 -->
                                                    <div class="user-card d-flex align-items-center mb-3">
                                                        
                                                        <!-- Avatar untuk nomor -->
                                                        <div class="user-avatar bg-primary-dim custom-avatar-num me-3">
                                                            <?= $no; ?>
                                                        </div>
                                                        
                                                        <div class="user-info">
                                                            <div class="form-group mb-0"> <!-- mb-0 mencegah margin bawah bawaan form -->
                                                                <div class="form-control-wrap" style="width:300px;">
                                                                    <input name="email[]" type="text" class="form-control approvalLayer" value="<?= decrypt($val); ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <?php
                                                    $no++;
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
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
                            <h5 class="text-strong">Notes</h5> 
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
                        <div id = "list_notes">
                        <?php foreach ($notes as $key => $value) { ?>
                            
                                <div class="bq-note">
                                    <div class="bq-note-item">
                                        <div class="bq-note-text">
                                            <p><?= ($value['notes'])?></p>
                                        </div>
                                        <div class="bq-note-meta">
                                            <span class="bq-note-added">Added on <span class="date"><?= $value['created_at'] ?></span></span>
                                            <span class="bq-note-sep sep">|</span>
                                            <span class="bq-note-by text-dark">By <strong><?= ($value['created_by']) ?></strong></span>
                                            <?php 
                                                if(($value['created_by']) == $this->session->userdata('user_email')){
                                            ?>
                                            <!-- <a id="<?= $value['id'] ?>" style="cursor: pointer;"  onclick="return delete_notes_pa(this.id)" class="link link-sm link-danger">Delete Note</a> -->
                                            <?php } ?>
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

    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalAddKPI">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Objective</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Performance Objective</label>
                                <textarea class="form-control" required placeholder="Input Performance Objective" name="kpi_objective" id="kpi_objective"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">KPI Measurement</label>
                                <textarea class="form-control" required placeholder="Input KPI Measurement" name="kpi_measurement" id="kpi_measurement"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Target per year</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup="number_format(this)" class="form-control" required placeholder="Target" name="kpi_target" id="kpi_target" autocomplete = "off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Achievement</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup="number_format(this)" class="form-control" required placeholder="Achievement" name="kpi_achievement" id="kpi_achievement" autocomplete = "off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Unit</label>
                                <div class="form-control-wrap">
                                    <select name = "kpi_unit" id = "kpi_unit" class = "form-control">
                                    </select>
                                </div>
                                <small>Positif : (Achievement / Target)*100</small><br>
                                <small>Negative : (Target / Achievement)*100</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-control-wrap  pt-1">
                                    
                                    <!-- <a href = "#myModal2AddKPI" type = "button" class = "btn btn-sm btn-success" data-toggle="modal">Add Unit</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Target vs Achievement</label>
                                <div class="form-control-wrap">
                                    <input type="text"  class="form-control" required placeholder="Target vs Achievement" name="kpi_target_vs_achievement" id="kpi_target_vs_achievement" readonly style = "background-color:#f5f6fa !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Score (1 - 10)</label>
                                <div class="form-control-wrap">
                                    <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="2" min="0" max="10" onchange="return calculate_kpi_item(this.id);" onClick="return calculate_kpi_item(this.id);" onKeyUp="return calculate_kpi_item(this.id);" class="form-control" placeholder="Score" name="kpi_score" id="kpi_score" readonly style = "background-color:#f5f6fa !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Weight (%)</label>
                                <div class="form-control-wrap">
                                    <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="100" onchange="return calculate_kpi_item(this.id);" onClick="return calculate_kpi_item(this.id);" onKeyUp="return calculate_kpi_item(this.id);" class="form-control" placeholder="Weight" name="kpi_time" id="kpi_time">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Total</label>
                                <div class="form-control-wrap">
                                    <input type="text" disabled value="0" class="form-control" name="kpi_total" id="kpi_total">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                
                                <button data-dismiss="modal" type="button" class="btn btn-primary add_item_kpi" id="add_item_kpi">Save Informations</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateKPI">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Update</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Performance Objective</label>
                                <textarea class="form-control" required placeholder="Input Performance Objective" name="update_kpi_objective" id="update_kpi_objective"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">KPI Measurement</label>
                                <textarea class="form-control" required placeholder="Input KPI Measurement" name="update_kpi_measurement" id="update_kpi_measurement"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Target per year</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup = "number_format(this)" class="form-control" required placeholder="Target" name="update_kpi_target" id="update_kpi_target" autocomplete = "off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Achievement</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup = "number_format(this)" class="form-control" required placeholder="Achievement" name="update_kpi_achievement" id="update_kpi_achievement" autocomplete = "off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Unit</label>
                                <div class="form-control-wrap">
                                    <select name = "kpi_unit" id = "update_kpi_unit" class = "form-control">
                                    </select>
                                </div>
                                <small>Positif : (Achievement / Target)*100</small><br>
                                <small>Negative : (Target / Achievement)*100</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-control-wrap  pt-1">
                                    
                                    <!-- <a href = "#myModal2UpdateKPI" type = "button" class = "btn btn-sm btn-success" data-toggle="modal">Add Unit</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Target vs Achievement</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" required placeholder="Target vs Achievement" name="update_kpi_target_vs_achievement" id="update_kpi_target_vs_achievement" readonly style = "background-color:#f5f6fa !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Score (1 - 10)</label>
                                <div class="form-control-wrap">
                                    <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="10" onchange="return calculate_update_kpi(this.id);" onClick="return calculate_update_kpi(this.id);" onKeyUp="return calculate_update_kpi(this.id);" class="form-control" placeholder="Score" name="update_kpi_score" id="update_kpi_score" readonly style = "background-color:#f5f6fa !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Weight (%)</label>
                                <div class="form-control-wrap">
                                    <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="100" onchange="return calculate_update_kpi(this.id);" onClick="return calculate_update_kpi(this.id);" onKeyUp="return calculate_update_kpi(this.id);" class="form-control" placeholder="Weight" name="update_kpi_time" id="update_kpi_time">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Total</label>
                                <div class="form-control-wrap">
                                    <input type="text" disabled value="0" class="form-control" name="update_kpi_total" id="update_kpi_total">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" id="id_detail_update">

                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>

                                <button data-dismiss="modal" type="button" class="btn btn-primary" id="update_item_kpi">Update Informations</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal" id="myModal2UpdateKPI" data-backdrop="static">
	<div class="modal-dialog  modal-lg" style = "background-color:white !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add new unit</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
          <form action = "#" method = "post" id = "formUnitUpdateKPI" class="pt-2 form-validate is-alter">
                <div class = "row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Unit</label>
                            <div class="form-control-wrap">
                                <input type="text"  class="form-control" placeholder="Unit" name="uom" id="uom_name_update">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Formula</label>
                            <div class="form-control-wrap">
                            <input type="checkbox" name = "formula" id = "formula_uom_update" value = "1" checked data-toggle="toggle" data-on="Positive" data-off="Negative" data-onstyle="primary" data-offstyle="danger" data-width="100">
                            
                            </div>
                            <small id = "formulaUOMExampleUpdate">Positif : (Achievement / Target)*100</small>
                        </div>
                    </div>
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn" id = "closeModalUOMUpdateKPI">Close</a>
          <button type = "button" id = "btnSaveUOMUpdateKPI" class="btn btn-primary">Save Unit</button>
          <p id = "notifUOMUpdateKPI" style = "display:none;">Saving ....</p>
        </div>
      </div>
    </div>
</div>

<div class="modal" id="myModal2AddKPI" data-backdrop="static">
	<div class="modal-dialog  modal-lg" style = "background-color:white !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add new unit</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
          <form action = "#" method = "post" id = "formUnitAddKPI" class="pt-2 form-validate is-alter">
                <div class = "row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Unit</label>
                            <div class="form-control-wrap">
                                <input type="text"  class="form-control" placeholder="Unit" name="uom" id="uom_name">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Formula</label>
                            <div class="form-control-wrap">
                            <input type="checkbox" name = "formula" id = "formula_uom" value = "1" checked data-toggle="toggle" data-on="Positive" data-off="Negative" data-onstyle="primary" data-offstyle="danger" data-width="100">
                            
                            </div>
                            <small id = "formulaUOMExampleAdd">Positif : (Achievement / Target)*100</small>
                        </div>
                    </div>
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn" id = "closeModalUOMAddKPI">Close</a>
          <button type = "button" id = "btnSaveUOMAddKPI" class="btn btn-primary">Save Unit</button>
          <p id = "notifUOMAddKPI" style = "display:none;">Saving ....</p>
        </div>
      </div>
    </div>
</div> -->

<div class="modal fade" tabindex="-1" id="modalAddPlan">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="title_modal_plan"></h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Performance Objective</label>
                                <textarea class="form-control" required placeholder="Performance Objective" name="plan_objective" id="plan_objective"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">KPI Measurement</label>
                                <textarea class="form-control" required placeholder="KPI Measurement" name="plan_measurement" id="plan_measurement"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Weight (%)</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup="number_format(this)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="100" class="form-control" placeholder="Weight" name="plan_time" id="plan_time">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Target next year</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" onkeyup="number_format(this)" required placeholder="Target" name="plan_target" id="plan_target">
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Unit</label>
                                <div class="form-control-wrap">
                                    <select name = "plan_unit" id = "plan_unit" class = "form-control">
                                    </select>
                                </div>
                                <small id = "formulaUOMExample">Positif : (Achievement / Target)*100</small><br>
                                <small id = "formulaUOMExample">Negative : (Target / Achievement)*100</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-control-wrap  pt-1">
                                    
                                    <!-- <a href = "#myModal2" type = "button" class = "btn btn-sm btn-success" data-toggle="modal">Add Unit</a> -->
                                </div>
                            </div>
                        </div>

                        
                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Semester I</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" onkeyup="number_format(this)" required placeholder="Semester I" name="plan_semester_1" id="plan_semester_1">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Semester II</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" onkeyup="number_format(this)" required placeholder="Semester II" name="plan_semester_2" id="plan_semester_2">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Total</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" onkeyup="number_format(this)" placeholder="Total" name="plan_total" id="plan_total">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-12">
                            <div class="form-group">

                                <input type="hidden" id="table_type">

                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>

                                <button type="button" class="btn btn-primary add_plan" id="add_plan">Save Informations</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddSkill">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="title_modal_skill"></h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">

                        <div class="col-12" id="div_hard_skill" style="display:none;">
                            <div class="form-group">
                                <div class="form-control-wrap focused">
                                    <span class="lead-primary">
                                        <select class="form-select required" data-search="on" data-ui="md" data-select2-id="hard_skill-select" id="select_hard_skill" name="select_hard_skill">
                                            <!-- <option value = "xxx">Please Choose</option> -->
                                            <?= $hard_skill; ?>
                                        </select>
                                        <label class="form-label-outlined text-primary" for="select_hard_skill">Hard Skill</label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="div_soft_skill" style="display:none;">
                            <div class="form-group">
                                <label class="form-label" for="select_soft_skill">Select Soft Skill</label>
                                <!-- <select class="form-select required" data-search="on" data-msg="Required" id="select_soft_skill" name="select_soft_skill" required>
                                    <?= $soft_skill; ?>
                                </select> -->
                                <select class="form-select required" data-search="on"  data-ui="md" data-select2-id="select-soft-select" id="select_soft_skill" name="select_soft_skill">
                                    <!-- <option value = "xxx">Please Choose</option> -->
                                    <?= $soft_skill; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12" id="div_skill_name" style="display:none;">
                            <label class="form-label">Training Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" disabled required placeholder="Please Input Training Name" name="training_name" id="training_name">
                            </div>
                        </div>

                        <div class="col-12" id="div_skill_desc" style="display:none;">
                            <label class="form-label">Training Description</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" required placeholder="Please Input Training Description" name="training_desc" id="training_desc">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" class="form-control" required name="training_category" id="training_category">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button type="button" class="btn btn-primary add_training" id="add_training">Save Data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalUpdatePlan">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="title_modal_plan_update"></h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Performance Objective</label>
                                <textarea class="form-control" required placeholder="Performance Objective" name="update_plan_objective" id="update_plan_objective"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">KPI Measurement</label>
                                <textarea class="form-control" required placeholder="KPI Measurement" name="update_plan_measurement" id="update_plan_measurement"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Weight (%)</label>
                                <div class="form-control-wrap">
                                    <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="3" min="1" max="100" class="form-control" placeholder="Weight" name="update_plan_time" id="update_plan_time">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Unit</label>
                                <div class="form-control-wrap">
                                    <select name = "update_plan_unit" id = "update_plan_unit" class = "form-control">
                                        <option value = ""></option>
                                        <?php 
                                            foreach($uom as $v){
                                                echo "<option value = '".$v->uom."'>".$v->uom."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Target next year</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup = "number_format(this)" class="form-control" required placeholder="Target" name="update_plan_target" id="update_plan_target">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Semester I</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup = "number_format(this)" class="form-control" required placeholder="Semester I" name="update_plan_semester_1" id="update_plan_semester_1">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Semester II</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup = "number_format(this)" class="form-control" required placeholder="Semester II" name="update_plan_semester_2" id="update_plan_semester_2">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Total</label>
                                <div class="form-control-wrap">
                                    <input type="text" onkeyup = "number_format(this)" class="form-control" placeholder="Total" name="update_plan_total" id="update_plan_total">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-12">
                            <div class="form-group">

                                <input type="hidden" id="table_type_update">
                                <input type="hidden" id="id_plan_update">

                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>

                                <button type="button" class="btn btn-primary update_plan" id="update_plan">Update Informations</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                    <button type="button" onclick="return save_response_notespa();" class="btn btn-md btn-primary"><span class="text-notes-response"> Save</span></button>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal" id="myModal2" data-backdrop="static">
	<div class="modal-dialog  modal-lg" style = "background-color:white !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add new unit</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
          <form action = "#" method = "post" id = "formUnit" class="pt-2 form-validate is-alter">
                <div class = "row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Unit</label>
                            <div class="form-control-wrap">
                                <input type="text"  class="form-control" placeholder="Unit" name="uom" id="uom_name_plan">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Formula</label>
                            <div class="form-control-wrap">
                            <input type="checkbox" name = "formula" id = "formula_uom_plan" value = "1" checked data-toggle="toggle" data-on="Positive" data-off="Negative" data-onstyle="primary" data-offstyle="danger" data-width="100">
                            
                            </div>
                            <small id = "formulaUOMExample">Positif : (Achievement / Target)*100</small>
                        </div>
                    </div>
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn" id = "closeModalUOM">Close</a>
          <button type = "button" id = "btnSaveUOM" class="btn btn-primary">Save Unit</button>
          <p id = "notifUOM" style = "display:none;">Saving ....</p>
        </div>
      </div>
    </div>
</div>

<div class="modal" id="myModal2Update" data-backdrop="static">
	<div class="modal-dialog  modal-lg" style = "background-color:white !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add new unit</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
          <form action = "#" method = "post" id = "formUnitUpdate" class="pt-2 form-validate is-alter">
                <div class = "row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Unit</label>
                            <div class="form-control-wrap">
                                <input type="text"  class="form-control" placeholder="Unit" name="uom" id="uom_name_update_plan">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Formula</label>
                            <div class="form-control-wrap">
                            <input type="checkbox" name = "formula" id = "formula_uom_update_plan" value = "1" checked data-toggle="toggle" data-on="Positive" data-off="Negative" data-onstyle="primary" data-offstyle="danger" data-width="100">
                            
                            </div>
                            <small id = "formulaUOMExampleUpdate">Positif : (Achievement / Target)*100</small>
                        </div>
                    </div>
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn" id = "closeModalUOMUpdate">Close</a>
          <button type = "button" id = "btnSaveUOMUpdate" class="btn btn-primary">Save Unit</button>
          <p id = "notifUOMUpdate" style = "display:none;">Saving ....</p>
        </div>
      </div>
    </div>
</div>