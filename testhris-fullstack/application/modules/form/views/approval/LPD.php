<!-- APPROVAL -->

<div class="nk-ibx-head">

    <?php if ($form_request['is_status'] == 3 || $form_request['is_status'] == 1 || $form_request['is_status'] == 4 || $form_request['is_status'] == 5 || $form_request['is_status'] == 6) {
        $disabled = 'disabled';
        $show = 'none';
    } else {
        $disabled = '';
        $show = '';
    } ?>

    <?php if (!empty($approval)) {
        $kadiv = ($approval['kadiv'] == '1') ? 'checked' : '';
        $c_level = ($approval['c_level'] == '1') ? 'checked' : '';
    } else {
        $kadiv = '';
        $c_level = '';
    } ?>

    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(4));?>">
    <input type="hidden" id="id_header" name="id_header" value="<?=$header['id'];?>">
    <input type="hidden" id="is_status" name="is_status" value="<?=$form_request['is_status'];?>">
    <input type="hidden" id="request_number" name="request_number" value="<?=$form_request['request_number'];?>">

    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <div class="btn-group-sm" aria-label="Basic example">  
                <button type="button" onclick="location.href='<?= site_url('home/submission'); ?>'" class="btn btn-dim btn-gray"><em class="icon ni ni-arrow-left"></em> &nbsp;</button>  
                
                <?php if ($form_request['is_status'] == 1) { ?>
                <button type="button" id="pullback" class="btn btn-dim btn-danger"><em class="icon ni ni-reply-all-fill"></em>&nbsp; Pullback Request</button>  
                <?php } ?>

                <?php if ($form_request['is_status'] == 2) { ?>
                <button type="button" id="resubmit_lpd" class="btn btn-dim btn-gray" style="display: <?=$show?>"><em class="icon ni ni-send"></em>&nbsp; Submit</button>  
                <?php } else { ?>
                <button type="button" id="submit_lpd" class="btn btn-dim btn-gray" style="display: <?=$show?>"><em class="icon ni ni-send"></em> &nbsp;Submit</button>
                <?php } ?>

                <button type="button" id="save_lpd" class="btn btn-dim btn-gray" style="display: <?=$show?>"><em class="icon ni ni-save"></em>&nbsp; Save</button>

                <?php if ($form_request['is_status'] == 3) { ?>
                <button type="button" id="print_result" class="btn btn-dim btn-gray"><em class="icon ni ni-printer"></em>&nbsp; Print</button>
                    <?php if ($form_request['submit_finance_flag'] == 0) { ?>
                        <button type="button" id="prepare_submit_to_finance" class="btn btn-dim btn-gray"><em class="icon ni ni-money"></em><b id="text_prepare_submit"> &nbsp;Submit to Finance</b></button>
                    <?php } ?>
                <?php } ?>

                <button type="button" data-toggle="modal" data-target="#modalAddNotes" class="btn btn-dim btn-gray"><em class="icon ni ni-notes"></em>&nbsp; Add Notes</button>

            </div>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

<div class="nk-ibx-reply-head">
        <div>
            <h5 class="title">LAPORAN PERJALANAN DINAS</h5>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <span class="badge badge-xs badge-dim badge-dark"> Dibuat oleh: &nbsp; <b><?= strtolower($form_request['created_by']);?></b></span>
                </li>
                <!-- <li class="btn-group is-tags">
                    <span class="badge badge-sm badge-dim badge-dark">Submit Date: &nbsp; <b><?= str_replace('.000', '', $form_request['created_at']);?></b>    </span>
                </li> -->
                <li class="btn-group is-tags">
                    <input type="text" class="btn btn-xs btn-primary eg-toastr-copy-reqnum" onClick="copy_reqnum();" id="copy_reqnum" value="<?= $form_request['request_number'];?>">
                    <a class="btn btn-xs btn-icon btn-primary btn-dim eg-toastr-copy-reqnum" onClick="copy_reqnum();">
                        <em class="icon ni ni-copy"></em>Salin &nbsp;
                    </a>
                </li>
                <li class="btn-group is-tags">
                    <a class="btn btn-xs btn-dim btn-info" data-toggle="modal" data-target="#modalHistory"> &nbsp; Log</a>
                    <a class="btn btn-xs btn-icon btn-info btn-dim" data-toggle="modal" data-target="#modalHistory">
                        <em class="icon ni ni-reports-alt"></em>
                    </a>
                </li>
                <!-- <li class="btn-group is-tags">
                    <a class="btn btn-sm btn-dim btn-danger" data-toggle="modal" data-target="#modalAddNotes">Request Notes</a>
                    <a class="btn btn-sm btn-icon btn-danger btn-dim" data-toggle="modal" data-target="#modalAddNotes">
                        <em class="icon ni ni-reports-alt"></em>
                    </a>
                </li> -->
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
                            <h5 class="text-soft">Request Detail</h5> 
                        </div>
                        <div class="nk-reply-msg-excerpt">Click to view</div>
                    </div>
                </div>
            </div>
            <div class="nk-reply-body nk-ibx-reply-body is-shown">
                <div class="nk-reply-entry entry">
                    <div class="nk-block nk-block-lg">
                         <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">
                                                PPD Request Number
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><b>EAPP_PPD_V2</b></span>
                                                </div>
                                                <input type="number" name="ppd_request_number" id="ppd_request_number"class="form-control" placeholder="XXXXXX" required>
                                                <div class="input-group-prepend">
                                                    <button id="btn_check_ppd" class="btn btn-sm btn-primary">
                                                        <span id="text-check">Check</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <span class="text-danger" id="ppd_check_text"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card card-bordered card-preview">
                                <table class="table table-tranx">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                            <div class="form-group">
                                                <div class="form-control-wrap focused">
                                                    <span class="tb-odr-id lead-primary w-50">
                                                        <input type="number" oninput="maxLengthCheck(this)" maxlength="8" min="1" max="8" onkeypress="return isNumeric(event)" <?=$disabled?> name="lpd_employee_nik" id="lpd_employee_nik" class="form-control form-control-outlined form-control-md" placeholder="Masukan 8 digit NIK lalu tekan Enter" value="<?php if (!empty($detail["requestor_nik"])) echo $detail["requestor_nik"]; ?>">
                                                        <label class="form-label-outlined text-primary" for="employee_nik">NIK Pejalan Dinas</label>
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
                                                        <input type="text"  name="nama_pejalan_dinas" id="nama_pejalan_dinas" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail["nama_pejalan_dinas"])) echo $detail["nama_pejalan_dinas"]; ?>">
                                                        <label class="form-label-outlined text-primary" for="nama_pejalan_dinas">Nama Pejalan Dinas </label>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-odr-info">
                                            <div class="form-group">
                                                <div class="form-control-wrap focused">
                                                    <span class="tb-odr-id lead-primary w-50">
                                                        <input type="text"  name="employee_email" id="employee_email" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail["email_pejalan_dinas"])) echo $detail["email_pejalan_dinas"]; ?>">
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
                                                        <input type="text"  name="employee_division" id="employee_division" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail["divisi"])) echo $detail["divisi"]; ?>">
                                                        <label class="form-label-outlined text-primary" for="employee_division">Divisi </label>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-odr-info">
                                            <div class="form-group">
                                                <div class="form-control-wrap focused">
                                                    <span class="tb-odr-id lead-primary w-50">
                                                        <input type="text"  name="employee_position" id="employee_position" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail["posisi"])) echo $detail["posisi"]; ?>">
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
                                                        <input type="text"  name="cost_center" id="cost_center" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail["cost_center"])) { echo $detail["cost_center"]; } ?>">
                                                        <label class="form-label-outlined text-primary" for="cost_center">Cost Center</label>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-odr-info">
                                            <div class="form-group">
                                                <div class="form-control-wrap focused">
                                                    <span class="tb-odr-id lead-primary w-50">
                                                        <input type="text"  name="jarak_mobil_kantor" id="jarak_mobil_kantor" class="form-control form-control-outlined form-control-md" value="<?php if (!empty($detail["jarak_mobil_kantor"])) { echo $detail["jarak_mobil_kantor"]; } ?>">
                                                        <label class="form-label-outlined text-primary" for="jarak_mobil_kantor">Bila menggunakan Mobil Kantor, Jarak (KM)</label>
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
                                                            <select class="form-select required" <?=$disabled;?> placeholder="Pilih Kota Keberangkatan" data-ui="md" data-select2-id="kota_berangkat-select" id="kota_berangkat" name="kota_berangkat">
                                                                <?php if (!empty($detail['kota_berangkat'])) { ?>
                                                                    <option selected='selected' value="<?=$detail['kota_berangkat']?>"><?=$detail['kota_berangkat']?></option>
                                                                <?php } ?>
                                                                <?= $list_city; ?>
                                                            </select>
                                                            <label class="form-label-outlined text-primary" for="kota_berangkat">Kota Keberangkatan</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <select class="form-select required" <?=$disabled;?> placeholder="Pilih Kota Tujuan" data-ui="md" data-select2-id="kota_tujuan-select" id="kota_tujuan" name="kota_tujuan">
                                                                <?php if (!empty($detail['kota_tujuan'])) { ?>
                                                                    <option selected='selected' value="<?=$detail['kota_tujuan']?>"><?=$detail['kota_tujuan']?></option>
                                                                <?php } ?>
                                                                <?= $list_city; ?>
                                                            </select>
                                                            <label class="form-label-outlined text-primary" for="kota_tujuan">Kota Tujuan</label>
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
                                                            <input type="text" <?=$disabled;?> name="lpd_tgl_berangkat" id="lpd_tgl_berangkat" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md date-picker" autocomplete="off" placeholder="Pilih Tanggal" required value="<?php if (!empty($detail["tgl_berangkat"])) echo str_replace('00:00:00.000', '', $detail["tgl_berangkat"]); ?>">
                                                            <label class="form-label-outlined text-primary" for="tgl_berangkat">Tgl. Keberangkatan</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <input type="text" <?=$disabled;?> name="lpd_tgl_kembali" id="lpd_tgl_kembali" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md date-picker" autocomplete="off" placeholder="Pilih Tanggal" required value="<?php if (!empty($detail["tgl_kembali"])) echo str_replace('00:00:00.000', '', $detail["tgl_kembali"]); ?>">
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
                                                            <input type="text" <?=$disabled;?> name="waktu_berangkat" id="waktu_berangkat" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md time-picker" autocomplete="off" placeholder="Pilih Jam" required value="<?php if (!empty($detail["waktu_berangkat"])) echo str_replace('.0000000', '', $detail["waktu_berangkat"]); ?>">
                                                            <label class="form-label-outlined text-primary" for="waktu_berangkat">Waktu Keberangkatan</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-odr-info">
                                                <div class="form-group">
                                                    <div class="form-control-wrap focused">
                                                        <span class="lead-primary">
                                                            <input type="text" <?=$disabled;?> name="waktu_kembali" id="waktu_kembali" onchange="return calculate_total_hari_ppd();" class="form-control form-control-outlined form-control-md time-picker" autocomplete="off" placeholder="Pilih Jam" required value="<?php if (!empty($detail["waktu_kembali"])) echo str_replace('.0000000', '', $detail["waktu_kembali"]); ?>">
                                                            <label class="form-label-outlined text-primary" for="waktu_kembali">Waktu Kembali</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <span>
                                    <a class="text-primary btn btn-icon btn-trigger" onClick="return modal_add_lpd();" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Tambah Item LPD
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="invoice">
                                        <div class="invoice-bills">
                                            <div class="table-responsive-sm">
                                                <table class="table table-striped table-tranx is-compact fs-13px" id="table_lpd_detail" data-ajaxsource="<?= site_url('form/LPD/read/'.$header['id']); ?>">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="w-15">Tgl</th>
                                                            <th class="w-20">Remark</th>
                                                            <th class="w-5">Kurs</th>
                                                            <th class="w-15">Transport</th>
                                                            <th class="w-15">Hotel</th>
                                                            <th class="w-15">Per Diem</th>
                                                            <th class="w-15">Lain-lain</th>
                                                            <th class="w-20">Total</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <table class="table table-tranx is-compact fs-13px">
                                                    </tr>
                                                        <td>TOTAL DIEM <span id="max_total_diem"></span></td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" name="total_perdiem_tb" id="total_perdiem_tb" value="<?php echo ($detail['total_perdiem'] == 0) ? 0 : rupiah($detail['total_perdiem']); ?>">

                                                            <input type="hidden" class="form-control" name="total_perdiem" id="total_perdiem" value="<?php echo ($detail['total_perdiem'] == 0) ? 0 : $detail['total_perdiem']; ?>">
                                                        </td>
                                                    <tr>
                                                    </tr>
                                                        <td>TOTAL HOTEL <span id="max_total_hotel"></span></td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" name="total_hotel_tb" id="total_hotel_tb" value="<?php echo ($detail['total_hotel'] == 0) ? 0 : rupiah($detail['total_hotel']); ?>">

                                                            <input type="hidden" class="form-control" name="total_hotel" id="total_hotel" value="<?php echo ($detail['total_hotel'] == 0) ? 0 : $detail['total_hotel']; ?>">
                                                        </td>
                                                    <tr>
                                                    <tr>
                                                        <td>TOTAL TRANSPORT</td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" name="total_transport_tb" id="total_transport_tb" value="<?php echo ($detail['total_transport'] == 0) ? 0 : rupiah($detail['total_transport']); ?>">

                                                            <input type="hidden" class="form-control" name="total_transport" id="total_transport" value="<?php echo ($detail['total_transport'] == 0) ? 0 : $detail['total_transport']; ?>">
                                                        </td>
                                                    <tr>
                                                    </tr>
                                                        <td>TOTAL LAIN-LAIN</td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" name="total_others_tb" id="total_others_tb" value="<?php echo ($detail['total_others'] == 0) ? 0 : rupiah($detail['total_others']); ?>">

                                                            <input type="hidden" class="form-control" name="total_others" id="total_others" value="<?php echo ($detail['total_others'] == 0) ? 0 : $detail['total_others']; ?>">
                                                        </td>
                                                    <tr>
                                                    </tr>
                                                        <td>TOTAL UANG MUKA</td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" name="grand_total_tb" id="grand_total_tb" value="<?php echo ($detail['claim_total'] == 0) ? 0 : rupiah($detail['claim_total']); ?>">

                                                            <input type="hidden" class="form-control" name="grand_total" id="grand_total" value="<?php echo ($detail['claim_total'] == 0) ? 0 : $detail['claim_total']; ?>">
                                                        </td>
                                                    </tr>
                                                    </tr>
                                                        <td>NOMINAL PPD</td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" name="nominal_ppd_tb" id="nominal_ppd_tb" value="">

                                                            <input type="hidden" class="form-control" name="nominal_ppd" id="nominal_ppd" value="">
                                                        </td>
                                                    </tr>
                                                    </tr>
                                                        <td>SISA LEBIH (KURANG)</td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" name="sisa_lebih_tb" id="sisa_lebih_tb" value="<?php echo ($detail['sisa_lebih'] == 0) ? 0 : rupiah($detail['sisa_lebih']); ?>">

                                                            <input type="hidden" class="form-control" name="sisa_lebih" id="sisa_lebih" value="<?php echo ($detail['sisa_lebih'] == 0) ? 0 : $detail['sisa_lebih']; ?>">
                                                        </td>
                                                    </tr>
                                                    </tr>
                                                        <td>SISA LEBIH TERSEBUT TELAH DISELESAIKAN</td>
                                                        <td>
                                                            <div class="custom-control custom-radio">
                                                                <input type="checkbox" <?=$disabled;?> class="custom-control-input" <?php if (!empty($detail["sisa_lebih_sudah_dibayar"]) && $detail["sisa_lebih_sudah_dibayar"] == "Y") echo 'checked'; ?> id="sisa_lebih_sudah_dibayar" value="1" tabIndex="1">
                                                                <label class="custom-control-label form-label" for="sisa_lebih_sudah_dibayar">YA</label>
                                                            </div>
                                                            <span>&nbsp;</span>
                                                            <div class="custom-control custom-radio">
                                                                <input type="checkbox" <?=$disabled;?> class="custom-control-input" <?php if (!empty($detail["sisa_lebih_belum_dibayar"]) && $detail["sisa_lebih_belum_dibayar"] == "Y") echo 'checked'; ?> id="sisa_lebih_belum_dibayar" value="1" tabIndex="1">
                                                                <label class="custom-control-label form-label" for="sisa_lebih_belum_dibayar">BELUM</label>
                                                            </div>
                                                        </td>
                                                    </tr>
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
            <?php if ($form_request['is_status'] != 0 && $form_request['is_status'] != 2) { ?>
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
            <?php } else { ?>
                <div class="nk-reply-body nk-ibx-reply-body is-shown">
                    <div class="nk-reply-entry entry">
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered card-stretch">
                                <div class="card-inner-group">
                                    <div class="card-inner p-0">
                                        <div class="invoice">
                                            <div class="invoice-bills">
                                                <div class="table-responsive">
                                                    <table class="table table-orders" id="table_matrix">
                                                        <thead>
                                                            <tr>
                                                                <!-- <th class="w-5">Layer</th> -->
                                                                <th class="w-25">Approval Email</th>
                                                                <th class="w-10"></th>
                                                                <th class="w-30"></th>
                                                                <th class="w-10"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="row_requestor">
                                                                <!-- <td>
                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="requestor_layer" checked disabled tabIndex="1">
                                                                        <label class="custom-control-label" for="requestor_layer">REQUESTOR</label>
                                                                    </div>
                                                                </td> -->
                                                                <td>
                                                                    <input type="text" class="form-control" disabled name="requestor_email" id="requestor_email" value="">
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <!-- <td>
                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="regional_pm" tabIndex="1" checked disabled>
                                                                        <label class="custom-control-label" for="regional_pm">Regional PM</label>
                                                                    </div>
                                                                </td> -->
                                                                <td>
                                                                    <input type="text" class="form-control" disabled name="layer_1" id="layer_1" value="">
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <!-- <tr>
                                                                <td>
                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="depthead" checked tabIndex="1" disabled>
                                                                        <label class="custom-control-label" for="depthead">Dept. Head</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" disabled name="layer_2" id="layer_2" value="<?= !empty($layer_2) ? $layer_2: '';?>">
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr> -->
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
            <?php } ?>

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
            <?php if ($form_request['is_status'] == 0 || $form_request['is_status'] == 2) { ?>
                <div class="nk-reply-body nk-ibx-reply-body is-shown">
                    <div class="nk-reply-entry entry">
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered card-preview">
                                <div class="table-responsive">
                                    <table class="table nk-tb-list table-tranx fs-13px is-compact table_documents_eapp" id="table_documents_eapp" data-ajaxsource="<?= site_url('form/read_documents/'.$form_request['request_number']); ?>">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary">Nama File</th>
                                                <th class="text-secondary">Ukuran</th>
                                                <th class="text-secondary">Hapus</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-tranx is-compact">
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info text-secondary"><mark>Maximum 10MB per file.</mark></td>
                                        </tr>
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <div class="card card-bordered card-stretch">
                                                    <div class="card-inner-group">
                                                        <input type="hidden" id="upload_zone" value="eapp">
                                                        <div class="upload-zone" data-max-file-size="10">    
                                                            <div class="dz-message" data-dz-message>        
                                                                <span class="dz-message-text">Drag and drop file</span>      
                                                                <span class="dz-message-or">or</span>        
                                                                <button class="btn btn-primary">SELECT</button>      
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
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
            <?php } ?>
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
                        <?php if (!empty($request_notes)) {
                            foreach ($request_notes as $key => $value) { ?>
                            <div class="bq-note">
                                <div class="bq-note-item">
                                    <div class="bq-note-meta">
                                        <span class="bq-note-added">Added on <span class="date"><?= str_replace('.000','',$value['created_at']); ?></span></span>
                                        <span class="bq-note-sep sep">|</span>
                                        <span class="bq-note-by text-dark">By <strong><?= $value['created_by'] ?></strong></span>
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

<div class="modal fade" tabindex="-1" id="modalAddLPD">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add LPD Item</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control date-picker" required name="modal_date" id="modal_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Remarks (keterangan)</label>
                                <div class="form-control-wrap">
                                <input type="text" class="form-control" required name="modal_remarks" id="modal_remarks">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="idr" value="3" tabIndex="1">
                                        <label class="custom-control-label form-label" for="idr">IDR</label>
                                    </div>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="usd" value="4" tabIndex="1">
                                        <label class="custom-control-label form-label" for="usd">USD</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_material_code">Transport</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="modal_transport" id="modal_transport">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_material_code">Hotel (Akomodasi)</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="modal_hotel" id="modal_hotel">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_material_code">Diem</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="modal_perdiem" id="modal_perdiem">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="modal_material_code">Others (Laundry, etc)</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="modal_others" id="modal_others">
                            </div>
                        </div>                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Total</label>
                                <div class="form-control-wrap">
                                    <input type="text" disabled value="0" class="form-control" name="modal_subtotal" id="modal_subtotal">
                                    <input type="hidden" name="modal_subtotal_hidden" id="modal_subtotal_hidden">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary add_lpd_item" id="add_lpd_item">
                                    <span id="text-save-lpd">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalUpdateLPD">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Update LPD Item</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control date-picker" required name="update_modal_date" id="update_modal_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Remarks (keterangan)</label>
                                <div class="form-control-wrap">
                                <input type="text" class="form-control" required name="update_modal_remarks" id="update_modal_remarks">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="update_idr" name="update_idr" tabIndex="1">
                                        <label class="custom-control-label form-label" for="update_idr">IDR</label>
                                    </div>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="update_usd" name='update_usd' tabIndex="1">
                                        <label class="custom-control-label form-label" for="update_usd">USD</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="update_modal_material_code">Transport</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="update_modal_transport" id="update_modal_transport">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="update_modal_material_code">Hotel (Akomodasi)</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="update_modal_hotel" id="update_modal_hotel">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="update_modal_material_code">Diem</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="update_modal_perdiem" id="update_modal_perdiem">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="update_modal_material_code">Others (Laundry, etc)</label>
                                <input type="number" onkeypress="return isNumeric(event)" onchange="return calculate_lpd_item();" onClick="return calculate_lpd_item();" onKeyUp="return calculate_lpd_item();" class="form-control" required name="update_modal_others" id="update_modal_others">
                            </div>
                        </div>                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Total</label>
                                <div class="form-control-wrap">
                                    <input type="text" disabled value="0" class="form-control" name="update_modal_subtotal" id="update_modal_subtotal">
                                    <input type="hidden" name="update_modal_subtotal_hidden" id="update_modal_subtotal_hidden">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" id="id_detail_update" name="id_detail_update">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary update_lpd_item" id="update_lpd_item">
                                    <span id="text-save-update-lpd">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


