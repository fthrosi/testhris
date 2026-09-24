<style>
  .select3-basic {display:none;}
</style>
<div class="nk-ibx-head">
<?php
//dumper($additional);

?>
    <?php 

    $join_date           = strtotime(decrypt($this->session->userdata('join_date')));
    $join_date           = date('Y-m-d', $join_date);
    //encrypt('16.03.2022');
    //dumper(encrypt('20131111'));
    $today               = date("Y-m-d");

    $diff                = abs(strtotime($today) - strtotime($join_date));
    $join_years          = floor($diff / (365*60*60*24));
    $join_months         = floor(($diff - $join_years * 365*60*60*24) / (30*60*60*24));
    $join_days           = floor(($diff - $join_years * 365*60*60*24 - $join_months*30*60*60*24)/ (60*60*24));

    // $datediff            = abs(strtotime($today) - strtotime($join_date));
    // $masa_kerja          = round($datediff / (60 * 60 * 24));

    printf("%d years, %d months, %d days\n", $join_years, $join_months, $join_days);
    
    $eval_year = new DateTime($form_request['created_at']);
    $eval_year = $eval_year->format('Y');

    $is_status = number_format($form_request['is_status']);
    if ($is_status == 3) {
        $disabled = 'disabled';
        $show = '';
    } else {
        $show = 'none';
    }
    $gender = $this->session->userdata('gender');
    if (( decrypt($gender) == 'Male' OR decrypt($gender) == 'Female' ) AND decrypt($header['marital_status']) == 'Single') {
        $dis        = 'disabled';
        $dis_d      = '';
    } else if (( decrypt($gender) == 'Male') AND (decrypt($header['marital_status']) == 'Marr.')){
        $dis        = '';
        $dis_d      = '';
    } else if (( decrypt($gender) == 'Male') AND (decrypt($header['marital_status']) == 'Div.' OR decrypt($header['marital_status']) == 'Wid.')){
        $dis_d      = 'disabled';
        $dis        = '';
    } else if (( decrypt($gender) == 'Female') AND (decrypt($header['marital_status']) == 'Div.' OR decrypt($header['marital_status']) == 'Wid.')){
        $dis_d      = 'disabled';
        $dis        = '';
    } else if (( decrypt($gender) == 'Female') AND (decrypt($header['marital_status']) == 'Marr.') AND ($couple['hak_pengajuan'] == $header['employee_id'])){
        $dis_d      = '';
        $dis        = '';
    } else if (( decrypt($gender) == 'Female') AND (decrypt($header['marital_status']) == 'Marr.')){
        $dis_d      = '';
        $dis        = 'disabled';
    } else {
        $dis        = '';
        $dis_d      = '';
    }

    //dumper($form_request);
    
    if (!empty($additional)){
        if ($additional[0]['resep'] == 1){
            $checked_r = 'checked';
        } else {
            $checked_r = '';
        }
    }else{
        $checked_r = '';
    }
    ?>

    


    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(4));?>">
    <input type="hidden" name="request_number" id="request_number" value="<?= $form_request['request_number'];?>">
	<input type="hidden" id="is_status" name="is_status" value="<?=$is_status;?>">
    <input type="hidden" id="join_years" name="join_years" value="<?=$join_years;?>">
    <input type="hidden" id="join_months" name="join_months" value="<?=$join_months;?>">
    <input type="hidden" id="employee_subgroup" name="employee_subgroup" value="<?=decrypt($this->session->userdata('employee_subgroup'));?>">
    <input type="hidden" id="action" name="action" value="<?=decrypt($this->session->userdata('action'));?>">
    <input type="hidden" id="submited_at" name="submited_at" value="<?= $approval[0]['created_at'];?>">


    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
            	<a href="<?= site_url('home/request'); ?>" class="btn btn-icon btn-tooltip" title="Back">
            		<em class="icon ni ni-arrow-left"></em>
            		Back
            	</a>
            </li>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <!-- Header Request -->
    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title"><span class="text-soft">CREATE: </span>MEDICAL REIMBURSEMENT</h4>
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
                    <strong>Submited At : <?=$approval[0]['created_at']?></strong>
                </li>
            </ul>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block">
                <?= status_color($is_status);?>
            </li>
            <a id="print_out_req_mdcr" class="btn btn-icon">
                <em class="icon ni ni-file-pdf"></em>
            	    Print
            </a>
        </ul>
    </div>
    <?php
    if($form_request['is_status_admin_hr'] == 1){
        echo "<div class='bg-teal-dim text-success'><center><b>Checked By HR Support</b></center></div>";
    } 
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
            <?php if ($is_status != 0) { ?>
                <div class="nk-reply-body nk-ibx-reply-body is-shown">
                    <div class="nk-reply-entry entry">
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered card-stretch">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <!-- <div class="invoice">
                                            <div class="invoice-bills"> -->
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-tranx is-compact fs-13px" id="table_matrix_prev">
                                                        <thead>
                                                            <tr>
                                                                <th class="w-5">Layer</th>
                                                                <th class="w-20">Approval Name</th>
                                                                <th class="w-20">Approval Email</th>
                                                                <th class="w-10">Status</th>
                                                                <th class="w-10 text-left">Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($approval as $key => $value) {  ?>
                                                            <tr>
                                                                <td><?=$value['approval_priority'];?>.</td>
                                                                <td width="25%"><?=$value['approval_alias'];?></td>
                                                                <td width="25%"><?=$value['approval_email'];?></td>
                                                                <td><?=approval_status($value['approval_status']);?></td>
                                                                <td class="text-left">
                                                                    <?= str_replace('.000','', $value['updated_at']);?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <!-- </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Medical Claim Form -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">MEDICAL CLAIM FORM</h5> 
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
                                            <span class="tb-odr-id text-soft">Nama</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($header['complete_name']); ?>
                                            </span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Departemen/Bagian</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($header['department']); ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Jabatan/Golongan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= decrypt($header['employee_group']); ?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Regional</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= decrypt($header['personnel_area']); ?>
                                            </span>
                                         </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">No. Karyawan</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            	<?= $header['employee_id'];?>
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                        <span class="tb-odr-id text-soft">No. Telepon</span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= decrypt($header['phone_number']);?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Type of Reimbursement -->
                    <div class="nk-block nk-block-lg">
                    	<div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">II. Type of Reimbursement</strong>
                                <span>
                                    <!--a class="text-primary btn btn-icon btn-trigger" style="display: <?=$show?>" data-toggle="modal" id="resModAddClaim" data-target="#modalAddClaim" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Add Type of Reimbursement
                                    </a-->
                                </span>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch nk-ibx-reply nk-reply">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                            <div class="table-responsive">
                                                        <table class="table ToR-table table-striped" width="100%" id="ToR" data-export-title="Export Data" data-ajaxsource="<?= site_url('form/read/ToR/'.$header['request_id']); ?>">
                                                        <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>JENIS PENGGANTIAN</th>
                                                                    <th>JUMLAH KUITANSI  (lbr)</th>
                                                                    <th>TOTAL NOMINAL KUITANSI (Rp)</th>
                                                                    <th>TANGGAL KUITANSI</th>
                                                                    <th>PENGGANTIAN</th>
                                                                    <th>KETERANGAN</th>
                                                                    <th>KAMAR</th>
                                                                    <th>DOKTER</th>
                                                                    <th>DIAGNOSA</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                            </tfoot>
                                                        </table>
		                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">III. TOTAL INFORMATION</strong>
                            </div>
                        </div>
                        
                        <table class="table table-orders" border="0">
                                <tbody class="tb-odr-body">
                                    <!-- <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="60%">
                                            <span class="tb-odr-id text-soft">POTONGAN (kelebihan atas Jatah Tahunan)</span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft"></span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            <input type="text" class="form-control" readonly value="0" style= "border: none; background-color: transparent;">
                                            </span>
                                        </td>
                                    </tr> -->
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="20%">
                                            <span class="tb-odr-id text-soft">Rawat Jalan</span>
                                        </td>
                                        <td class="tb-odr-info">
                                        </td>
                                        <td class="tb-odr-info">
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <input type="text" class="" readonly value="<?= number_format($sum_penggantian_jalan[0]->sum_penggantian); ?>" style= "border: none; text-align:left; background-color: transparent;" name="sum_penggantian_jalan" id="sum_penggantian_jalan">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="20%">
                                            <span class="tb-odr-id text-soft">Rawat Inap</span>
                                        </td>
                                        <td class="tb-odr-info">
                                        </td>
                                        <td class="tb-odr-info">
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <input type="text" class="" readonly value="<?= number_format($sum_penggantian_inap[0]->sum_penggantian); ?>" style= "border: none; text-align:left; background-color: transparent;" name="sum_penggantian_inap" id="sum_penggantian_inap">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="20%">
                                            <span class="tb-odr-id text-soft">Kacamata</span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <span class="tb-odr-id text-soft">One Focus : 
                                            <input type="text" class="" readonly value="<?= number_format($sum_penggantian_kacamata[0]->sum_one_focus); ?>" style= "border: none; text-align:left; background-color: transparent;" name="sum_penggantian_kacamata_one_focus" id="sum_penggantian_kacamata_one_focus">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                        <td class="tb-odr-info">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <span class="tb-odr-id text-soft">Two Focus : 
                                            <input type="text" class="" readonly value="<?= number_format($sum_penggantian_kacamata[0]->sum_two_focus); ?>" style= "border: none; text-align:left; background-color: transparent;" name="sum_penggantian_kacamata_two_focus" id="sum_penggantian_kacamata_two_focus">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                        <td class="tb-odr-info">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <span class="tb-odr-id text-soft">Frame : 
                                            <input type="text" class="" readonly value="<?= number_format($sum_penggantian_kacamata[0]->sum_frame); ?>" style= "border: none; text-align:left; background-color: transparent;" name="sum_penggantian_kacamata_frame" id="sum_penggantian_kacamata_frame">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                        
                    </div>

                    <!-- Remaining Reimbursement Limit -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary text-uppercase">IV. Remaining Reimbursement Limit</strong>
                            </div>
                        </div>
                        
                        <table class="table table-orders" border="0">
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="20%">
                                            <span class="tb-odr-id text-soft">Rawat Jalan</span>
                                         </td>
                                         <td class="tb-odr-info">

                                        </td>
                                        <td class="tb-odr-info">
                                           
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <input type="hidden" class="" readonly value="0" style= "border: none; text-align:left; background-color: transparent;" name="temp_limit_rawat_jalan" id="temp_limit_rawat_jalan">
                                            <input type="text" class="" readonly value="<?= number_format($reimaning_pagu['pagu_jalan_tahun']); ?>" style= "border: none; text-align:left; background-color: transparent;" name="limit_rawat_jalan" id="limit_rawat_jalan">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="20%">
                                            <span class="tb-odr-id text-soft">Rawat Inap</span>
                                        </td>
                                        <td class="tb-odr-info">
                                           
                                        </td>
                                        <td class="tb-odr-info">
                                        <span class="tb-odr-id text-soft">Pagu Kamar : 
                                            <input type="hidden" class="" readonly value="0" style= "border: none; text-align:left; background-color: transparent;" name="temp_limit_rawat_inap_kamar" id="temp_limit_rawat_inap_kamar">
                                            <input type="text" class="" readonly value="<?= number_format($reimaning_pagu['pagu_inap_kamar']); ?>" style= "border: none; text-align:left; background-color: transparent;" name="limit_rawat_inap_kamar" id="limit_rawat_inap_kamar">
                                            </span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft">Pagu Tahunan :
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <input type="hidden" class="" readonly value="0" style= "border: none; text-align:left; background-color: transparent;" name="temp_limit_rawat_inap" id="temp_limit_rawat_inap">
                                            <input type="text" class="" readonly value="<?= number_format($reimaning_pagu['pagu_inap_tahun']); ?>" style= "border: none; text-align:left; background-color: transparent;" name="limit_rawat_inap" id="limit_rawat_inap">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="20%">
                                            <span class="tb-odr-id text-soft">Kacamata</span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <span class="tb-odr-id text-soft">One Focus : 
                                            <input type="hidden" class="" readonly value="0" style= "border: none; text-align:left; background-color: transparent;" name="temp_limit_kacamata_one_focus" id="temp_limit_kacamata_one_focus">
                                            <input type="text" class="" readonly value="<?= number_format($reimaning_pagu['pagu_one_focus_tahun']); ?>" style= "border: none; text-align:left; background-color: transparent;" name="limit_kacamata_one_focus" id="limit_kacamata_one_focus">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                        <td class="tb-odr-info">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <span class="tb-odr-id text-soft">Two Focus : 
                                            <input type="hidden" class="" readonly value="0" style= "border: none; text-align:left; background-color: transparent;" name="temp_limit_kacamata_two_focus" id="temp_limit_kacamata_two_focus">
                                            <input type="text" class="" readonly value="<?= number_format($reimaning_pagu['pagu_two_focus_tahun']); ?>" style= "border: none; text-align:left; background-color: transparent;" name="limit_kacamata_two_focus" id="limit_kacamata_two_focus">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                        <td class="tb-odr-info">
                                            <!-- <span class="tb-odr-id lead-primary fw-bold text-uppercase"> -->
                                            <span class="tb-odr-id text-soft">Frame : 
                                            <input type="hidden" class="" readonly value="0" style= "border: none; text-align:left; background-color: transparent;" name="temp_limit_kacamata_frame" id="temp_limit_kacamata_frame">
                                            <input type="text" class="" readonly value="<?= number_format($reimaning_pagu['pagu_frame_dua_tahun']); ?>" style= "border: none; text-align:left; background-color: transparent;" name="limit_kacamata_frame" id="limit_kacamata_frame">
                                            </span>
                                            <!-- </span> -->
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                        
                    </div>
                    
                    <div class="nk-block-head-content">
                        <strong class="text-secondary text-uppercase">* Additional Information</strong>
                    </div>
                    <div class="card card-bordered card-stretch nk-ibx-reply nk-reply">
                    <div class="card-inner-group">
                    <div class="card-inner">
                        <!-- Submitted original receipt -->
                        <div class="nk-block nk-block-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <strong class="text-secondary text-uppercase">V. Submitted original receipt</strong>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" required name="request_id_additional" id="request_id_additional" value="<?= $header['request_id'];?>">
                            <table class="table table-orders">
                                    <tbody class="tb-odr-body">
                                            
                                            <div class="col-6">
                                            <div class="form-group">
                                            <label class="custom-label" for="kuitansi">Jenis Kuitansi (Dokter, Apotik, Rumah Sakit, Klinik, Laboratorium)</label>
                                                <br>
                                                <select class="form-select select-kuitansi kuitansi" <?=$disabled?> required name="kuitansi" id="kuitansi">
                                                    <option value="<?= isset($additional[0]['kuitansi']) != '' ? $additional[0]['kuitansi'] : '' ?>"><?= isset($additional[0]['kuitansi']) != '' ? $additional[0]['kuitansi'] : '' ?></option>
                                                    <option value="Asli">Asli</option>
                                                    <option value="Digital">Digital</option>
                                                    <option value="Campur">Campur</option>
                                                </select>  
                                            </div>
                                            </div>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info" >
                                            <div class="custom-control custom-checkbox custom-control-sm">
                                                <input type="checkbox" <?=$disabled?> class="custom-control-input" <?= $checked_r ?> id="resep" name="resep">    
                                                <label class="custom-control-label" for="resep">Copy Resep Dokter
                                                / Copy of Medical Prescription</label>
                                            </div>
                                            </td>
                                        </tr>
                                    </tbody>
                            </table>
                        </div>

                        <!-- Documents -->
                        <div class="nk-block nk-block-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <strong class="text-secondary">VI. DOCUMENTS</strong>
                                </div>
                            </div>
                                <div class="card-inner-group">
                                    <div class="card-inner p-0">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <div class="form-control-wrap">        
                                                    Documents&nbsp&nbsp:&nbsp<a href="<?php echo base_url();?>assets/documents/documents_hris/<?php echo isset($additional[0]['documents']) != '' ? $additional[0]['documents'] : ''?>" target="_blank"> <?php echo isset($additional[0]['documents']) != '' ? $additional[0]['documents'] : ''?></a></b>    
                                                </div>
                                            
                                            </div>
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
                                        <!-- <a id="<?= $value['id'] ?>" style="cursor: pointer;"  onclick="return delete_notes(this.id)" class="link link-sm link-danger">Delete Note</a> -->
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

<div class="modal fade" tabindex="-1" id="modalAddClaim">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Type of Reimbursement</h5>
                <!-- <form action="#" class="pt-2 form-validate is-alter"> -->
                <form action="#" id="form_Add_Claim" class="pt-2 form-validate is-alter">
                <input type="hidden" class="form-control" required name="request_id" id="request_id" value="<?= $header['request_id'];?>">
                <input type="hidden" class="form-control" required name="marital_status" id="marital_status" value="<?= decrypt($header['marital_status']);?>">
                <input type="hidden" class="form-control" required name="join_date" id="join_date" value="<?= $join_date;?>">
                
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="request_grandparent_tambah">Jenis Penggantian</label>           
                                    <select class="form-select select-search request_grandparent_tambah" required name="request_grandparent_tambah" placeholder="Jenis Penggantian" id="request_grandparent_tambah">
                                                
                                    </select>    
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">        
                            <label class="form-label" for="request_parent_tambah">Sub Penggantian</label>
                                <select class="form-select select-search request_parent_tambah" required name="request_parent_tambah" placeholder="Sub Penggantian" id="request_parent_tambah">
                                            <!-- <option value="">Select Parent</option> -->
                                </select>    
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">       
                            <label class="form-label" for="request_child_tambah">Detail Penggantian</label> 
                                <select class="form-select select-search request_child_tambah" required name="request_child_tambah" placeholder="Penggantian" id="request_child_tambah">
                                            <!-- <option value="">Select Child</option> -->
                                </select>    
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group form-control-hide s_harga_kamar" name="s_harga_kamar">
                                <label class="form-label">Harga Kamar</label>
                                <input type="number" class="form-control" placeholder="Harga Kamar" name="harga_kamar" id="harga_kamar">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Kuitansi</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Kuitansi" name="jumlah_kuitansi" id="jumlah_kuitansi">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Kuitansi</label>    
                                    <input type="text" class="form-control date-picker" data-date-end-date="0d" required name="tanggal_kuitansi" id="tanggal_kuitansi">    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Total Nominal Kuitansi</label>
                                <input type="number" class="form-control" required min="1" placeholder="Total Nominal Kuitansi" name="total_nominal_kuitansi" id="total_nominal_kuitansi">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Docter</label>
                                <input type="text" class="form-control" placeholder="Docter Name" name="docter" id="docter">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label class="form-label">Diagnosa</label>
                                <textarea rows="1" name="diagnosa" required id="diagnosa" placeholder="Diagnosa" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Penggantian</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" required placeholder="Penggantian" readonly name="penggantian" id="penggantian">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <br>
                                <div class="custom-control custom-radio custom-control-sm">
                                    <input type="radio" class="custom-control-input" value="Diri Sendiri" name="customRadioTor" id="dirisendiri">    
                                    <label class="custom-control-label" for="dirisendiri">Diri Sendiri</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-sm">
                                    <input type="radio" class="custom-control-input" <?=$dis?> <?=$dis_d?> value="Pasangan" name="customRadioTor" id="pasangan">    
                                    <label class="custom-control-label" for="pasangan">Pasangan</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-sm">
                                    <input type="radio" class="custom-control-input" <?=$dis?> value="Anak" name="customRadioTor" id="anak">    
                                    <label class="custom-control-label" for="anak">Anak</label>
                                </div>
                            </div>
                            <select name="listanak" class="form-control form-select-ds col-6 listanak" id="listanak" data-placeholder="Select Child">
                                <option value="">Pilih Anak</option>
                            </select>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger close_tor" data-dismiss="modal"> Cancel</a>
                                <button type="button" class="btn btn-primary req_medical_tambah" id="req_medical_tambah">Save Informations</button>
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
                    <button type="button" onclick="return save_response_notes();" class="btn btn-md btn-primary"><span class="text-notes-response"> Save</span></button>
                </div>

            </div>
        </div>
    </div>
</div>



<!-- <table class="table table-striped" id="table_kpi_achievement">
		                                    		<thead>
                                                        <tr>
		                                                    <th>#</th>
		                                                    <th class="w-25">JENIS PENGGANTIAN</th>
		                                                    <th class="w-15">JUMLAH KUITANSI  (lbr)</th>
		                                                    <th class="w-15">TOTAL NOMINAL KUITANSI (Rp)</th>
		                                                    <th class="w-15">PENGGANTIAN</th>
		                                                    <th class="w-15">KETERANGAN</th>
		                                                </tr>
		                                            </thead>
							                        <tbody id="body_claim">
                                                    <?php $no = 1;
                                                        //foreach ($detail as $key) { ?>
                                                            <tr id='claim_row-<?php //$key['id'];?>'>
                                                                <td>
                                                                    <a onclick='delete_calim_row(<?php //$key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
                                                                    <a onclick='update_claim_row(<?php //$key["id"]; ?>)' class="btn btn-icon btn-trigger"> <em class="icon ni ni-edit"></em></a>

                                                                </td>
                                                                <td scope="row">
                                                                    Apotik
                                                                    <span id="claim_row_type_of_reimbursement-<?php //$key['id']; ?>"><?php //$key['type_of_reimbursement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    1
                                                                    <span id="claim_row_number_of_original_receipt-<?php //$key['id']; ?>"><?php //$key['number_of_original_receipt']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    99.000
                                                                    <span id="claim_row_total_amount_of_original_receipt-<?php //$key['id']; ?>"><?php //$key['total_amount_of_original_receipt']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    99.000
                                                                    <span id="claim_row_reimbursement-<?php //$key['id']; ?>"><?php //$key['reimbursement']; ?></span>
                                                                </td>
                                                                <td scope="row">
                                                                    Diri Sendiri
                                                                    <span id="claim_row_keterangan-<?php //$key['id']; ?>"><?php //$key['keterangan']; ?></span>
                                                                </td>
                                                            </tr>
                                                        <?php// $no++; } ?>
							                        </tbody>
								                    <tfoot>
		                                                <tr>
                                                            <td colspan="1">
                                                            </td>
		                                                    <td colspan="1" class="text-secondary">
                                                                <b>Total</b>
                                                            </td>
                                                            <td>
                                                                <input type="text" disabled size="5" value="1" name="claim_total_kwitansi" id="claim_total_kwitansi">
                                                            </td>
		                                                    <td>
                                                                <input type="text" disabled size="5" value="99.000" name="claim_total_nominal_kwitansi" id="claim_total_nominal_kwitansi">
                                                            </td>
                                                            <td>
                                                                <input type="text" disabled size="5" value="99.000" name="claim_total_penggantian" id="claim_total_penggantian">
                                                            </td>
                                                            <td colspan="1">
                                                            </td>
		                                                </tr>
		                                            </tfoot>
		                                    	</table> -->