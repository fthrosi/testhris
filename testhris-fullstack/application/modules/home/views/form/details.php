<style>
  .select3-basic {display:none;}
</style>
<div class="nk-ibx-head">

    <?php 
    //dumper($header);
    if ($header['is_status'] == 1) {
        $disabled = 'disabled';
        $show = 'none';
    } else {
        $disabled = '';
        $show = '';
    } ?>

    <input type="hidden" id="id_request" name="id_request" value="<?=decode_url($this->uri->segment(4));?>">
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
            	<a id="submit_new_request_mdcr" class="btn btn-icon">
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
            <h4 class="title"><span class="text-soft">FORM : </span>MEDICAL REIMBURSEMENT</h4>
            <ul class="nk-ibx-tags g-1">
                <li class="btn-group is-tags">
                    <strong>Period: Januari <?=$eval_year = date('Y') - 1;?> - Desember <?=$eval_year = date('Y') - 1;?></strong>
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
                                    <a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" id="resModAddClaim" data-target="#modalAddClaim" data-offset="-8,0"><em class="icon ni ni-plus-circle"></em> Add Type of Reimbursement
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="card card-bordered card-stretch nk-ibx-reply nk-reply">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                            <!-- <div class="table-responsive"> -->
                                                        <table class="table ToR-table table-striped"  width="100%" id="ToR" data-export-title="Export Data" data-ajaxsource="<?= site_url('form/read/ToR/'.$header['request_id']); ?>">
                                                        <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>JENIS PENGGANTIAN</th>
                                                                    <th>JUMLAH KUITANSI  (lbr)</th>
                                                                    <th>TOTAL NOMINAL KUITANSI (Rp)</th>
                                                                    <th>PENGGANTIAN</th>
                                                                    <th>KETERANGAN</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                            </tfoot>
                                                        </table>
		                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">III. INFORMATION</strong>
                            </div>
                        </div>
                        
                        <table class="table table-orders" >
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="60%">
                                            <span class="tb-odr-id text-soft">POTONGAN (kelebihan atas Jatah Tahunan)</span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft"></span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            <input type="text" class="form-control" readonly value="0" style= "border: none; background-color: transparent;">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="60%">
                                            <span class="tb-odr-id text-soft">TOTAL PENGGANTIAN YANG DISETUJUI</span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft"></span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            <input type="text" class="form-control" readonly value="<?= number_format($sum_penggantian[0]->sum_penggantian); ?>" style= "border: none; background-color: transparent;" name="sum_penggantian" id="sum_penggantian">
                                            </span>
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
                        
                        <table class="table table-orders">
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="60%">
                                            <span class="tb-odr-id text-soft">Rawat Jalan</span>
                                         </td>
                                         <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft"></span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                            <?= number_format($reimaning_pagu['pagu_jalan_tahun']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" width="60%">
                                            <span class="tb-odr-id text-soft">Rawat Inap</span>
                                        </td>
                                        <td class="tb-odr-info">
                                            <span class="tb-odr-id text-soft"></span>
                                            <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                                <?= number_format($reimaning_pagu['pagu_inap_tahun']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                        
                    </div>
                    
                    <!-- Submitted original receipt -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary text-uppercase">V. Submitted original receipt</strong>
                            </div>
                        </div>
                       
                        <table class="table table-orders">
                                <tbody class="tb-odr-body">
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info">
                                        <div class="custom-control custom-checkbox custom-control-sm">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">    
                                            <label class="custom-control-label" for="customCheck1">Kuitansi asli (Dokter, Apotik, Rumah Sakit, Klinik, Laboratorium)
                                            / Original receipt (doctor, pharmacist, hospital, clinic, laboratory)</label>
                                        </div> 
                                        </td>
                                    </tr>
                                    <tr class="tb-odr-item">
                                        <td class="tb-odr-info" >
                                        <div class="custom-control custom-checkbox custom-control-sm">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">    
                                            <label class="custom-control-label" for="customCheck2">Copy Resep Dokter
                                            / Copy of Medical Prescription</label>
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>

                    <!-- DIAGNOSA -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <strong class="text-secondary">VI. DIAGNOSA</strong>
                            </div>
                        </div>
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <label class="form-label">Dokter :</label>
                                                <input type="text" class="form-control" required placeholder="Docter Name" name="docter" id="docter">
                                                <label class="form-label">Diagnosa :</label>
                                                <textarea rows="1" name="diagnosa" id="diagnosa" placeholder="Diagnosa" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        
                                            <label class="form-label" for="customFileLabel">File Upload</label>    
                                            <div class="form-control-wrap">        
                                                <div class="custom-file">            
                                                    <input type="file" class="custom-file-input" id="FileDocumentsClaim">            
                                                    <label class="custom-file-label" for="FileDocumentsClaim">Choose file</label>        
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
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" class="form-control" required name="request_id" id="request_id" value="<?= $header['request_id'];?>">
                                <label class="form-label" for="kpi-objective">Type of Reimbursement</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select request_grandparent_tambah" required name="request_grandparent_tambah" placeholder="Select Grandparent" id="request_grandparent_tambah">
                                                <option value="">Select Grandparent</option>
                                    </select>    
                                </div>
                                <br>
                                <div class="form-control-wrap">        
                                    <select class="form-select request_parent_tambah" required name="request_parent_tambah" placeholder="Select Parent" id="request_parent_tambah">
                                                <option value="">Select Parent</option>
                                    </select>    
                                </div>
                                <br>
                                <div class="form-control-wrap">        
                                    <select class="form-select request_child_tambah" required name="request_child_tambah" placeholder="Select Child" id="request_child_tambah">
                                                <option value="">Select Child</option>
                                    </select>    
                                </div>
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
                                <label class="form-label">Total Nominal Kuitansi</label>
                                <input type="number" class="form-control" required min="1" placeholder="Total Nominal Kuitansi" name="total_nominal_kuitansi" id="total_nominal_kuitansi">
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
                                    <input type="radio" class="custom-control-input" value="Istri" name="customRadioTor" id="istri">    
                                    <label class="custom-control-label" for="istri">Istri</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-sm">
                                    <input type="radio" class="custom-control-input" value="Anak" name="customRadioTor" id="anak">    
                                    <label class="custom-control-label" for="anak">Anak</label>
                                </div>
                            </div>
                            <select name="listanak" class="form-control form-select-ds col-6" id="listanak" data-placeholder="Select Child">
                                <option value="Anak 1">Anak 1</option>
                                <option value="Anak 2">Anak 2</option>
                                <option value="Anak 3">Anak 3</option>
                            </select>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button type="button" class="btn btn-primary req_medical_tambah" id="req_medical_tambah">Save Informations</button>
                            </div>
                        </div>
                    </div>
                </form>
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