<!-- Detail Approver -->
<div class="nk-ibx-head">

    <?php if ($form_request['is_status'] == 3 || $form_request['is_status'] == 1 || $form_request['is_status'] == 4 || $form_request['is_status'] == 5 || $form_request['is_status'] == 6) {
        $disabled = 'disabled';
        $show = 'none';
    } else {
        $disabled = '';
        $show = '';
    } ?>

    <?php if ($form_request['is_status'] == 1) {
        $show_response = 'show';
    } else {
        $show_response = 'none';
    } ?>

    <input type="hidden" id="request_id" name="request_id" value="<?=decode_url($this->uri->segment(4));?>">
    <input type="hidden" id="id_header" name="id_header" value="<?=$header['id'];?>">
    <input type="hidden" id="is_status" name="is_status" value="<?=$form_request['is_status'];?>">
    <input type="hidden" id="created_by" name="created_by" value="<?= strtolower($form_request['created_by']);?>">
    <input type="hidden" id="request_number" name="request_number" value="<?=$form_request['request_number'];?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
                <a href="<?= site_url('inbox/approval'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back to Approval List
                </a>
            </li>
            <li style="display: <?=$show_response;?>">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                        <em class="icon ni ni-more-v"></em> Response
                    </a>
                    <div class="dropdown-menu">
                        <ul class="link-list-opt no-bdr">
                            <!-- <li><a class="dropdown-item" id="eapp-approved"><span>Approve</span></a></li> -->
                            <li><a class="dropdown-item" style='cursor:pointer;' onclick="return responseTravel(this.id);" id="Approved"><span>Approve</span></a></li>
                            <!-- <li><a class="dropdown-item" style='cursor:pointer;' onclick="return responseTravel(this.id);" id="Revised"><span>Revise</span></a></li> -->
                            <li><a class="dropdown-item" style='cursor:pointer;' onclick="return responseTravel(this.id);" id="Revised_Prev"><span>Revise</span></a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <button type="button" data-toggle="modal" data-target="#modalAddNotes" class="btn btn-dim btn-default"><em class="icon ni ni-notes"></em>&nbsp; Add Notes</button>
            </li>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <div class="nk-ibx-reply-head">
        <div>
            <h5 class="title">FORM PERJALANAN DINAS</h5>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <input type="text" class="btn btn-xs btn-primary eg-toastr-copy-reqnum" onClick="copy_reqnum();" id="copy_reqnum" value="<?= $form_request['request_number'];?>">
                    <a class="btn btn-xs btn-icon btn-primary btn-dim eg-toastr-copy-reqnum" onClick="copy_reqnum();">
                        <em class="icon ni ni-copy"></em>Salin &nbsp;
                    </a>
                </li>
                <li class="btn-group is-tags">
                    <a class="btn btn-xs btn-dim btn-info" data-toggle="modal" data-target="#modalHistory"> &nbsp; Histori</a>
                    <a class="btn btn-xs btn-icon btn-info btn-dim" data-toggle="modal" data-target="#modalHistory">
                        <em class="icon ni ni-reports-alt"></em>
                    </a>
                </li>
            </ul>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <span class="badge badge-xs badge-dim badge-dark"> Dibuat oleh: &nbsp; 
                        <b><?= strtolower($form_request['created_by']);?></b>
                    </span>
                </li>
                <li class="btn-group is-tags">
                    <span class="badge badge-xs badge-dim badge-dark">Tanggal Submit: &nbsp; <b></b>    </span>
                </li>
                <li class="btn-group is-tags">
                    <span class="badge badge-xs badge-dim badge-dark">Reminder Settle 1: &nbsp; <b>Delivered</b>    </span>
                </li>
                <li class="btn-group is-tags">
                    <span class="badge badge-xs badge-dim badge-dark">Reminder Settle 2: &nbsp; 
                        <b>
                            <?php 
                                $date = strtotime($form_request['created_at']);
                                $created_date = date('d-m-Y', $date);
                                echo $created_date;
                            ?>
                        </b>    
                    </span>
                </li>
            </ul>
        </div>
        <ul class="d-flex g-1">
            <li class="mr-n1">
                <?= status_color($form_request['is_status']);?>
            </li>
        </ul>
    </div>

    <div class="nk-ibx-reply-group">

        <!-- Detail Request -->
        <div class="nk-ibx-reply-item nk-reply-item">

            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Detil Pengajuan</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Klik untuk lihat</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="table-responsive">
                                <table class="table table-tranx">
                                    <tbody class="tb-odr-body">
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="number" disabled name="employee_nik" id="employee_nik" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["requestor_nik"])) echo $detail[0]["requestor_nik"]; ?>">
                                                            <label class="form-label-outlined text-primary" for="employee_nik">NIK Pejalan Dinas</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <span class="lead-primary">
                                                            <select class="form-select required" disabled data-ui="md" data-select2-id="beban-pt-select" id="beban_pt" name="beban_pt">
                                                                <option value="IBST" <?php if (!empty($detail[0]["beban_pt"]) && $detail[0]["beban_pt"] == "IBST") echo 'selected="selected"'; ?> >IBST</option>
                                                                <option value="IBSW" <?php if (!empty($detail[0]["beban_pt"]) && $detail[0]["beban_pt"] == "IBSW") echo 'selected="selected"'; ?> >IBSW</option>
                                                                <option value="TIS" <?php if (!empty($detail[0]["beban_pt"]) && $detail[0]["beban_pt"] == "TIS") echo 'selected="selected"'; ?> >TIS</option>
                                                                <option value="IPM" <?php if (!empty($detail[0]["beban_pt"]) && $detail[0]["beban_pt"] == "IPM") echo 'selected="selected"'; ?> >IPM</option>
                                                                <option value="TVSS" <?php if (!empty($detail[0]["beban_pt"]) && $detail[0]["beban_pt"] == "TVSS") echo 'selected="selected"'; ?> >TVSS</option>
                                                            </select>
                                                            <label class="form-label-outlined text-primary" for="beban_pt">Beban PT</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="nama_pejalan_dinas" id="nama_pejalan_dinas" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["nama_pejalan_dinas"])) echo $detail[0]["nama_pejalan_dinas"]; ?>">
                                                            <label class="form-label-outlined text-primary" for="nama_pejalan_dinas">Nama Pejalan Dinas </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="employee_email" id="employee_email" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["email_pejalan_dinas"])) echo $detail[0]["email_pejalan_dinas"]; ?>">
                                                            <label class="form-label-outlined text-primary" for="employee_email">Email Pejalan Dinas </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="employee_division" id="employee_division" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["divisi"])) echo $detail[0]["divisi"]; ?>">
                                                            <label class="form-label-outlined text-primary" for="employee_division">Divisi </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="employee_position" id="employee_position" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["posisi"])) echo $detail[0]["posisi"]; ?>">
                                                            <label class="form-label-outlined text-primary" for="employee_position">Posisi </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="cost_center" id="cost_center" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["cost_center"])) { echo $detail[0]["cost_center"]; } ?>">
                                                            <label class="form-label-outlined text-primary" for="cost_center">Cost Center</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="range_grade" id="range_grade" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["range_grade"])) { echo $detail[0]["range_grade"]; } ?>">
                                                            <label class="form-label-outlined text-primary" for="range_grade">Range Grade</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="lokasi_kantor" id="lokasi_kantor" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["lokasi_kantor"])) { echo $detail[0]["lokasi_kantor"]; } ?>">
                                                            <label class="form-label-outlined text-primary" for="lokasi_kantor">Lokasi Kantor</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="personnel_subarea" id="personnel_subarea" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail[0]["personnel_subarea"])) { echo $detail[0]["personnel_subarea"]; } ?>">
                                                            <label class="form-label-outlined text-primary" for="personnel_subarea">Area Lokasi</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="table-responsive">
                                <table class="table table-tranx">
                                    <tbody class="tb-odr-body">
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <span class="lead-primary">
                                                            <div class="custom-control custom-checkbox checked">
                                                                <input type="checkbox" disabled class="custom-control-input custom-control-input-sm" <?php if (!empty($detail[0]["luar_dalam_negeri"]) && $detail[0]["luar_dalam_negeri"] == "Dalam Negeri") echo 'checked'; ?> id="dalam_negeri" value="1" tabIndex="1">
                                                                <label class="custom-control-label form-label" for="dalam_negeri">Dalam Negeri - IDR</label>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <span class="lead-primary">
                                                            <div class="custom-control custom-checkbox checked">
                                                                <input type="checkbox" disabled class="custom-control-input form-control-sm" <?php if (!empty($detail[0]["luar_dalam_negeri"]) && $detail[0]["luar_dalam_negeri"] == "Luar Negeri") echo 'checked'; ?> id="luar_negeri" value="1" tabIndex="1">
                                                                <label class="custom-control-label form-label" for="luar_negeri">Luar Negeri - USD</label>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display:none;">
                                                    <div class="form-control-wrap">
                                                        <span class="lead-primary">
                                                            <div class="custom-control custom-checkbox checked">
                                                                <input type="checkbox" class="custom-control-input" <?php if (!empty($detail[0]["currency"]) && $detail[0]["currency"] == "IDR") echo 'checked'; ?> id="IDR" value="1" tabIndex="1">
                                                                <label class="custom-control-label form-label" for="IDR">IDR</label>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display:none;">
                                                    <div class="form-control-wrap">
                                                        <span class="lead-primary">
                                                            <div class="custom-control custom-checkbox checked">
                                                                <input type="checkbox" class="custom-control-input" <?php if (!empty($detail[0]["currency"]) && $detail[0]["currency"] == "USD") echo 'checked'; ?> id="USD" value="1" tabIndex="1">
                                                                <label class="custom-control-label form-label" for="USD">USD</label>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="kota_keberangkatan" id="kota_keberangkatan" class="form-control form-control-outlined form-control-md" value="<?= $kota_berangkat;?>">
                                                            <label class="form-label-outlined text-primary" for="kota_keberangkatan">Kota Keberangkatan</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="tb-odr-id lead-primary w-50">
                                                            <input type="text" disabled name="kota_tujuan" id="kota_tujuan" class="form-control form-control-outlined form-control-md" value="<?=$kota_tujuan;?>">
                                                            <label class="form-label-outlined text-primary" for="kota_tujuan">Kota Tujuan - <?=$category_city;?></label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <input type="text" disabled name="tgl_berangkat" id="tgl_berangkat" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md date-picker" autocomplete="off" placeholder="Pilih Tanggal" required value="<?php if (!empty($detail[0]["tgl_berangkat"])) echo str_replace('00:00:00.000', '', $detail[0]["tgl_berangkat"]); ?>">
                                                            <label class="form-label-outlined text-primary" for="tgl_berangkat">Tgl. Keberangkatan</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <input type="text" disabled name="tgl_kembali" id="tgl_kembali" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md date-picker" autocomplete="off" placeholder="Pilih Tanggal" required value="<?php if (!empty($detail[0]["tgl_kembali"])) echo str_replace('00:00:00.000', '', $detail[0]["tgl_kembali"]); ?>">
                                                            <label class="form-label-outlined text-primary" for="tgl_kembali">Tgl. Kembali</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <input type="text" disabled name="waktu_berangkat" id="waktu_berangkat" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md time-picker" autocomplete="off" placeholder="Pilih Jam" required value="<?php if (!empty($detail[0]["waktu_berangkat"])) echo str_replace(':00.0000000', '', $detail[0]["waktu_berangkat"]); ?>">
                                                            <label class="form-label-outlined text-primary" for="waktu_berangkat">Waktu Keberangkatan</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <input type="text" disabled name="waktu_kembali" id="waktu_kembali" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md time-picker" autocomplete="off" placeholder="Pilih Jam" required value="<?php if (!empty($detail[0]["waktu_kembali"])) echo str_replace(':00.0000000', '', $detail[0]["waktu_kembali"]); ?>">
                                                            <label class="form-label-outlined text-primary" for="waktu_kembali">Waktu Kembali</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info" colspan="2">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <input type="text" disabled name="specific_location" id="specific_location" placeholder="Spesifik lokasi tujuan. Ex: Bandung, Semarang, Yogyakarta" class="form-control form-control-outlined form-control-md" autocomplete="off" required value="<?php if (!empty($detail[0]["specific_location"])) echo $detail[0]["specific_location"]; ?>">
                                                            <label class="form-label-outlined text-primary" for="specific_location">Spesifik Lokasi Tujuan</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                         <div class="nk-block-head">
                            <br>
                            <div class="card card-bordered card-preview">
                                <table class="table" id="table_ppd">
                                    <tbody>
                                        <tr>
                                            <td>Alat Transportasi</td>
                                            <td colspan="5">
                                                 <div class="row g-3 align-center">
                                                    <div class="col-lg-10">
                                                        <ul class="custom-control-group g-3 align-center flex-wrap">
                                                            <li>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["pesawat"]) && $detail[0]["pesawat"] == "Y") echo 'checked'; ?> id="pesawat" value="1" tabIndex="1">
                                                                    <label class="custom-control-label form-label" for="pesawat">Pesawat Udara</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-radio">
                                                                   <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["kendaraan_dinas"]) && $detail[0]["kendaraan_dinas"] == "Y") echo 'checked'; ?> id="kendaraan_dinas" value="1" tabIndex="1">
                                                                    <label class="custom-control-label form-label" for="kendaraan_dinas">Kend. Dinas</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["kereta_api"]) && $detail[0]["kereta_api"] == "Y") echo 'checked'; ?> id="kereta_api" value="1" tabIndex="1">
                                                                    <label class="custom-control-label form-label" for="kereta_api">Kereta Api</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["kendaraan_pribadi"]) && $detail[0]["kendaraan_pribadi"] == "Y") echo 'checked'; ?> id="kendaraan_pribadi" value="1" tabIndex="1">
                                                                    <label class="custom-control-label form-label" for="kendaraan_pribadi">Kend. Pribadi</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["travel"]) && $detail[0]["travel"] == "Y") echo 'checked'; ?> id="travel" value="1" tabIndex="1">
                                                                    <label class="custom-control-label form-label" for="travel">Travel</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["kendaraan_umum"]) && $detail[0]["kendaraan_umum"] == "Y") echo 'checked'; ?> id="kendaraan_umum" value="1" tabIndex="1">
                                                                    <label class="custom-control-label form-label" for="kendaraan_umum">Kend. Umum</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["kapal"]) && $detail[0]["kapal"] == "Y") echo 'checked'; ?> id="kapal" value="1" tabIndex="1">
                                                                    <label class="custom-control-label form-label" for="kapal">Kapal</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Keperluan/Tujuan</td>
                                            <td colspan="5"><input type="text" disabled name="tujuan_keperluan" id="tujuan_keperluan" placeholder="Keperluan Perjalanan Dinas" class="form-control" value="<?php if (!empty($detail[0]["tujuan_keperluan"])) echo $detail[0]["tujuan_keperluan"]; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <b>Apakah tujuan PPD untuk Orientasi, Pelatihan, Seminar, Pelatihan External/Konferensi dan sejenisnya? </b>
                                            </td>
                                            <td>
                                                <ul class="custom-control-group g-3 align-center flex-wrap">
                                                    <li>
                                                        <div class="custom-control custom-radio">
                                                            <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["flag_pelatihan"]) && $detail[0]["flag_pelatihan"] == "YA") echo 'checked'; ?> id="tujuan_ppd_ya" value="1" tabIndex="1">
                                                            <label class="custom-control-label form-label" for="tujuan_ppd_ya">Ya</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-radio">
                                                           <input type="checkbox" disabled class="custom-control-input" <?php if (!empty($detail[0]["flag_pelatihan"]) && $detail[0]["flag_pelatihan"] == "TIDAK") echo 'checked'; ?> id="tujuan_ppd_tidak" value="1" tabIndex="1">
                                                            <label class="custom-control-label form-label" for="tujuan_ppd_tidak">Tidak</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch" id="detail_diem_ppd">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="invoice">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table" id="table_ppd">
                                                    <tbody>
                                                        <tr>
                                                            <td>Total hari PPD:</td>
                                                            <td><input type="text" readonly class="form-control" id="total_hari" value="<?php if (!empty($detail[0]["total_hari"])) echo $detail[0]["total_hari"]; ?>"></td>
                                                            <td><span class="badge badge-md badge-dim badge-danger" id="text_total_hari" class="text-left"></span></td>
                                                            <td>
                                                                <span id="pengali_diem_text" class="text-success"></span>
                                                                <input type="hidden" name="pengali_diem" id="pengali_diem" value="1">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Per Diem</td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">X</span>
                                                                        </div>
                                                                        <input name="x_diem" id="x_diem" readonly type="number" onkeypress="return isNumeric(event)" onchange="return calculate_ppd();" onClick="return calculate_ppd();" onKeyUp="return calculate_ppd();" class="form-control" required value="<?php if (!empty($detail[0]["x_diem"])) echo $detail[0]["x_diem"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Nominal</span>
                                                                        </div>
                                                                        <input disabled name="nominal_diem_tb" id="nominal_diem_tb" type="text" class="form-control" required value="<?php if (!empty($detail[0]["nominal_diem"])) echo rupiah($detail[0]["nominal_diem"]); ?>">
                                                                        <input name="nominal_diem" id="nominal_diem" type="hidden" class="form-control" required value="<?php if (!empty($detail[0]["nominal_diem"])) echo $detail[0]["nominal_diem"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">=</span>
                                                                        </div>
                                                                        <input type="text" disabled name="total_diem_tb" id="total_diem_tb" class="form-control" required value="<?php if (!empty($detail[0]["total_diem"])) echo rupiah($detail[0]["total_diem"]); ?>">
                                                                        <input type="hidden" name="total_diem" id="total_diem" class="form-control" required value="<?php if (!empty($detail[0]["total_diem"])) echo $detail[0]["total_diem"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Hotel</td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">X</span>
                                                                        </div>
                                                                        <input type="number" disabled onkeypress="return isNumeric(event)" onchange="return calculate_ppd();" onClick="return calculate_ppd();" onKeyUp="return calculate_ppd();" name="x_hotel" id="x_hotel" class="form-control" required value="<?php if (!empty($detail[0]["x_hotel"])) echo $detail[0]["x_hotel"]; ?>">
                                                                        <span class="badge badge-sm badge-dim badge-danger" id="text_hotel" class="text-left">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Nominal</span>
                                                                        </div>
                                                                        <input type="text" disabled name="nominal_hotel_tb" id="nominal_hotel_tb" class="form-control" value="<?php if (!empty($detail[0]["nominal_hotel"])) echo rupiah($detail[0]["nominal_hotel"]); ?>">
                                                                        <input type="hidden" name="nominal_hotel" id="nominal_hotel" class="form-control" required value="<?php if (!empty($detail[0]["nominal_hotel"])) echo $detail[0]["nominal_hotel"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">=</span>
                                                                        </div>
                                                                        <input type="text" disabled name="total_hotel_tb" id="total_hotel_tb" class="form-control" required value="<?php if (!empty($detail[0]["total_hotel"])) echo rupiah($detail[0]["total_hotel"]); ?>">
                                                                        <input type="hidden" name="total_hotel" id="total_hotel" class="form-control" required value="<?php if (!empty($detail[0]["total_hotel"])) echo $detail[0]["total_hotel"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Transport</td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">X</span>
                                                                        </div>
                                                                        <input type="number" disabled onkeypress="return isNumeric(event)" onchange="return calculate_ppd();" onClick="return calculate_ppd();" onKeyUp="return calculate_ppd();" name="x_transport" id="x_transport" class="form-control" required value="<?php if (!empty($detail[0]["x_transport"])) echo $detail[0]["x_transport"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Nominal</span>
                                                                        </div>
                                                                        <input type="number" disabled onkeypress="return isNumeric(event)" onchange="return calculate_ppd();" onClick="return calculate_ppd();" onKeyUp="return calculate_ppd();" name="nominal_transport" id="nominal_transport" class="form-control" required value="<?php if (!empty($detail[0]["nominal_transport"])) echo $detail[0]["nominal_transport"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">=</span>
                                                                        </div>
                                                                        <input type="text" disabled name="total_transport_tb" id="total_transport_tb" class="form-control" required value="<?php if (!empty($detail[0]["total_transport"])) echo rupiah($detail[0]["total_transport"]); ?>">
                                                                        <input type="hidden" name="total_transport" id="total_transport" class="form-control" required value="<?php if (!empty($detail[0]["total_transport"])) echo $detail[0]["total_transport"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lain Lain</td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">X</span>
                                                                        </div>
                                                                        <input type="number" disabled onkeypress="return isNumeric(event)" onchange="return calculate_ppd();" onClick="return calculate_ppd();" onKeyUp="return calculate_ppd();" name="x_lain_lain" id="x_lain_lain" class="form-control" required value="<?php if (!empty($detail[0]["x_lain_lain"])) echo $detail[0]["x_lain_lain"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Nominal</span>
                                                                        </div>
                                                                        <input type="number" disabled onkeypress="return isNumeric(event)" onchange="return calculate_ppd();" onClick="return calculate_ppd();" onKeyUp="return calculate_ppd();" name="nominal_lain_lain" id="nominal_lain_lain" class="form-control" required value="<?php if (!empty($detail[0]["nominal_lain_lain"])) echo $detail[0]["nominal_lain_lain"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">=</span>
                                                                        </div>
                                                                        <input type="text" disabled name="total_lain_lain_tb" id="total_lain_lain_tb" class="form-control" required value="<?php if (!empty($detail[0]["total_lain_lain"])) echo rupiah($detail[0]["total_lain_lain"]); ?>">
                                                                        <input type="hidden" name="total_lain_lain" id="total_lain_lain" class="form-control" required value="<?php if (!empty($detail[0]["total_lain_lain"])) echo $detail[0]["total_lain_lain"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mengambil Uang Muka</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Total</span>
                                                                        </div>
                                                                        <input type="text" disabled name="total_uang_muka_tb" id="total_uang_muka_tb" class="form-control" required value="<?php if (!empty($header["claim_total"])) echo rupiah($header["claim_total"]); ?>">
                                                                        <input type="hidden" name="total_uang_muka" id="total_uang_muka" class="form-control" required value="<?php if (!empty($header["claim_total"])) echo $header["claim_total"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mohon Transfer Uang Ke</td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                       <!--  <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Bank & Cabang</span>
                                                                        </div> -->
                                                                        <select class="form-select required" disabled data-search="on" data-msg="Required" id="paid_to" name="paid_to" required>
                                                                        <option value="">Select</option>
                                                                        <option value="BSM" <?php if (!empty($header["paid_to"]) && $header["paid_to"] == "BSM") echo 'selected="selected"'; ?>>Bank Sinarmas</option>
                                                                        <option value="MDR" <?php if (!empty($header["paid_to"]) && $header["paid_to"] == "MDR") echo 'selected="selected"'; ?>>Bank Mandiri</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">No. Rek</span>
                                                                        </div>
                                                                        <input type="text" disabled name="norek" id="norek" class="form-control" required value="<?php if (!empty($header["account_number"])) echo $header["account_number"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-control-wrap">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Atas Nama</span>
                                                                        </div>
                                                                        <input type="text" disabled name="atas_nama" id="atas_nama" class="form-control" required value="<?php if (!empty($header["account_name"])) echo $header["account_name"]; ?>">
                                                                    </div>
                                                                </div>
                                                            </td>
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
                </div>
            </div>

            <br>
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
                                    <!-- <div class="invoice">
                                        <div class="invoice-bills"> -->
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
                                                        <?php foreach ($approval_progress as $key => $value) {  ?>
                                                        <tr>
                                                            <td><?=$value['approval_priority'];?>.</td>
                                                            <td><?=$value['approval_email'];?></td>
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

            <br>
            <!-- Document Upload -->
            <div class="nk-reply-header nk-ibx-reply-header">
                <div class="nk-reply-desc">
                    <div class="nk-reply-info">
                        <div class="nk-reply-author lead-text">
                            <h5 class="text-soft">Dokumen Pendukung</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Klik untuk lihat</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <div class="nk-block nk-block-lg">
                    
                        <div class="table-responsive">
                            <table class="table table-tranx is-compact fs-12px">
                                <thead>
                                    <tr>
                                        <th>Nama File</th>
                                        <th>Ukuran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($uploaded_document as $key => $value): ?>
                                    <tr>
                                        <td>
                                            <a target="_blank" href="<?=base_url().$value['path'];?>"><?=$value['name'];?></a>
                                        </td>
                                        <td><?=$value['size'];?></td>
                                    </tr>
                                <?php endforeach ?>
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
                            <h5 class="text-soft">Request Notes</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <div class="nk-block">
                        <!-- <div class="nk-block-head nk-block-head-sm nk-block-between">
                            <a data-toggle="modal" data-target="#modalAddNotes" class="btn btn-md text-primary">+ Add Note</a>
                        </div> -->
                        
                        <div id="request_notes_area">
                        <?php if (!empty($notes)) {
                            foreach ($notes as $key => $value) { ?>
                            <div class="bq-note">
                                <div class="bq-note-item">
                                    <div class="bq-note-meta">
                                        <span class="bq-note-added">Added on <span class="date"><?= str_replace('.000','',$value['created_at']); ?></span></span>
                                        <span class="bq-note-sep sep">|</span>
                                        <span class="bq-note-by text-dark">By <strong><?= strtolower($value['created_by']); ?></strong></span>
                                        <?php if ($value['created_by'] == $this->session->userdata['user_email']) { ?>
                                        <a id="<?= $value['id'] ?>" style="cursor: pointer;"  onclick="return delete_notes(this.id)" class="link link-sm link-danger">Delete Note</a>
                                        <?php } ?>
                                    </div>
                                    <div class="bq-note-text">
                                    <textarea readonly class="bg-white form-control form-control-sm"><?= $value['notes']?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        <?php } ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

