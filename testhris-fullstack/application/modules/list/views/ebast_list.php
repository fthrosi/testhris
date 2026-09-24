<div class="nk-content p-0">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-chat">

                <div class="nk-chat-aside">
                    <div class="nk-chat-aside-head">
                        <div class="nk-chat-aside-user">
                            <div class="title">E-BAST List</div>
                        </div>
                        <ul class="nk-chat-aside-tools g-2">
                            <li>
                                <a href="<?= base_url('list/ebast'); ?>" class="btn btn-round btn-icon btn-light">
                                    <em class="icon ni ni-reload-alt"></em>
                                </a>
                                <!-- <a href="<?= base_url('list/ebast'); ?>" class="btn btn-round btn-icon btn-light">
                                    <em class="icon ni ni-reload-alt"></em>
                                </a> -->
                            </li>
                        </ul>
                    </div>

                    <div class="nk-chat-aside-body" data-simplebar>
                        <div class="nk-chat-aside-search">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <input type="text" onkeyup="search_request()" class="form-control form-round" id="search_request" placeholder="Search">
                                </div>
                            </div>
                        </div>

                        <div class="nk-chat-list">
                            <ul class="chat-list">

                                <?php if (!empty($ebast)) { ?>
                                    <?php foreach ($ebast as $key) {
                                        $jam = str_replace('.000', '', getTime($key->created_at));
                                        $tglBln = getTanggalBulan($key->created_at);
                                    ?>

                                        <li id="request-<?= $key->id; ?>" class="chat-item">
                                            <a class="chat-link chat-open" id="<?= $key->id; ?>" onclick="return viewEbast(this.id)">
                                                <div class="chat-media user-avatar bg-red">
                                                    <span>
                                                        <?php
                                                        $username = $key->created_by;
                                                        echo strtoupper($username[0]);
                                                        ?>
                                                    </span>
                                                </div>
                                                <div class="chat-info">
                                                    <div class="chat-from">
                                                        <div class="name"><?= $key->po_number; ?></div>
                                                        <span class="time" id="status_list-<?= $key->id; ?>"><?= ebast_status($key->is_status); ?></span>
                                                    </div>
                                                    <div class="chat-context">
                                                        <div class="text"><?= $key->wbs_id . '-' . $key->request_number . '-' . $key->request_number; ?></div>
                                                        <div class="status read" id="status_read-<?= $key->id; ?>">

                                                            <?php if ($key->is_status != 3) { ?>
                                                                <em class="icon ni ni-bullet-fill" id="is_active-<?= $key->id; ?>" style="display: show;"></em>
                                                            <?php } else { ?>
                                                                <em class="icon ni ni-check-circle-fill" id="is_read-<?= $key->id; ?>" style="display: show;"></em>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                    <?php } ?>

                                <?php } else { ?>

                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="nk-chat-body" id="nothing-select" style="display:show;">
                </div>

                <div class="nk-chat-body profile-shown" id="viewDetail" style="display:none;">
                    <div class="nk-chat-head">
                        <ul class="nk-chat-head-info">
                            <li class="nk-chat-body-close">
                                <a href="#" class="btn btn-icon btn-trigger nk-chat-hide ml-n1"><em class="icon ni ni-arrow-left"></em></a>
                            </li>
                            <li class="nk-chat-head-user">
                                <div class="user-card">
                                    <div class="user-info">
                                        <div class="lead-text" id="requestor_name"></div>
                                        <div class="sub-text">
                                            Request Created Date: &nbsp;<span class="d-none d-sm-inline mr-1" id="requestDate"></span> -
                                            Status: &nbsp;<span class="d-none d-sm-inline mr-1" id="requestStatus"></span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <ul class="nk-chat-head-tools">
                            <li class="mr-n1 mr-md-n2"><a href="#" class="btn btn-icon btn-trigger text-primary chat-profile-toggle"><em class="icon ni ni-alert-circle-fill"></em></a></li>
                        </ul>

                        <div class="nk-chat-head-search">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <input type="text" class="form-control form-round" id="chat-search" placeholder="Approval Progress Bar">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nk-chat-panel" style="height: 600px;">
                        <blockquote class="blockquote text-right">
                            <footer class="blockquote-footer text-dark" id="requestNumber"></footer>
                        </blockquote>

                        <table class="table table-tranx is-compact">
                            <tbody>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <span class="text-dark">WBS ID </span>
                                    </td>
                                    <td class="tb-tnx-info">
                                        <div class="tb-tnx-desc">
                                            <span class="title" id="wbs_id"></span>
                                        </div>
                                        <div class="tb-tnx-date">
                                            <span class="date"></span>
                                            <span class="date text-dark"><b> Milestone</b></span>
                                        </div>
                                    </td>
                                    <td class="tb-tnx-amount">
                                        <div class="tb-tnx-total">
                                            <span class="amount" id="milestone"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <span class="text-dark">Site ID</span>
                                    </td>
                                    <td class="tb-tnx-info">
                                        <div class="tb-tnx-desc">
                                            <span class="title" id="site_id"></span>
                                        </div>
                                        <div class="tb-tnx-date">
                                            <span class="date"></span>
                                            <span class="date text-dark"><b> Worktype</b></span>
                                        </div>
                                    </td>
                                    <td class="tb-tnx-amount">
                                        <div class="tb-tnx-total">
                                            <span class="amount" id="worktype"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <span class="text-dark">Site Name</span>
                                    </td>
                                    <td class="tb-tnx-info">
                                        <div class="tb-tnx-desc">
                                            <span class="title" id="site_name"></span>
                                        </div>
                                        <div class="tb-tnx-date">
                                            <span class="date"></span>
                                            <span class="date text-dark"><b> PO Number</b></span>
                                        </div>
                                    </td>
                                    <td class="tb-tnx-amount">
                                        <div class="tb-tnx-total">
                                            <span class="amount" id="po_number"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <span class="text-dark">Region</span>
                                    </td>
                                    <td class="tb-tnx-info">
                                        <div class="tb-tnx-desc">
                                            <span class="title" id="region"></span>
                                        </div>
                                        <div class="tb-tnx-date">
                                            <span class="date"></span>
                                            <span class="date text-dark"><b> PO Date</b></span>
                                        </div>
                                    </td>
                                    <td class="tb-tnx-amount">
                                        <div class="tb-tnx-total">
                                            <span class="amount" id="po_created_date"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="nk-chat-panel" data-simplebar>
                        <div id="preview_documents">
                            <ul class="nav nav-tabs">
                                <li class="nav-item" id="li-bast" style="display: show;">
                                    <a class="nav-link active" data-toggle="tab" href="#bast">BAST</a>
                                </li>
                                <li class="nav-item" id="li-rfi" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#rfi">RFI-RFE</a>
                                </li>
                                <li class="nav-item" id="li-receipt" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#receipt">Receipt</a>
                                </li>
                                <li class="nav-item" id="li-wtcr" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#wtcr">WTCR</a>
                                </li>
                                <li class="nav-item" id="li-boq_final" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#boq_final">BOQ Final</a>
                                </li>
                                <li class="nav-item" id="li-bast2" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#bast2">BAST 2</a>
                                </li>

                                <li class="nav-item" id="li-ba_progress" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#ba_progress">BA Progress</a>
                                </li>

                                <li class="nav-item" id="li-bamt_preview" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#bamt_imm">BAMT</a>
                                </li>

                                <li class="nav-item" id="li-upload_docs" style="display: none;">
                                    <a class="nav-link" data-toggle="tab" href="#upload_docs">Additional Document</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="bast">
                                   <button type="button" class="btn btn-sm btn-primary" id="btn-preview-bast" data-toggle="modal" data-target="#previewBAST"> Preview BAST Certificate</button>
                                </div>
                                
                                <div class="tab-pane" id="rfi">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnPreviewRFI"> Preview RFI-RFE Certificate</button>
                                </div>

                                <div class="tab-pane" id="receipt">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnPreviewReceipt"> Preview Receipt Document</button>
                                </div>

                                <div class="tab-pane" id="wtcr">
                                    <div class="row">
                                       <div class="col-md-3">
                                            <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#formWTCR"> Update WTCR</button>
                                        </div>

                                        <div class="col-3">
                                            <button type="button" class="btn btn-sm btn-primary" id="btnPreviewWtcr"> Preview WTCR</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="boq_final">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnPreviewBoqFinal"> Preview BOQ Final</button>
                                </div>

                                <div class="tab-pane" id="ba_progress">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#previewBAprogress"> Preview BA Progress</button>
                                </div>

                                <div class="tab-pane" id="bast2">
                                    <button type="button" class="btn btn-sm btn-primary" id="btn-preview-bast2" data-toggle="modal" data-target="#previewBAST2"> Preview BAST 2 Certificate</button>
                                </div>

                                <div class="tab-pane" id="bamt_imm">
                                    <div class="row">
                                       <div class="col-md-3">
                                            <button type="button" class="btn btn-sm btn-primary" id="btnPreviewBAMT"> Summary BAMT</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane" id="upload_docs">
                                    <div class="card card-bordered">

                                        <table class="table table-ulogs">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Documents Name</th>
                                                    <th>Uploaded Files</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="font-size: small; display: none;" id="foto_biaya_koordinasi_field">
                                                    <td class="align-middle">
                                                        Foto-foto <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="foto_biaya_koordinasi">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="bukti_bayar_field">
                                                    <td class="align-middle">
                                                        Bukti bayar <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="bukti_bayar">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="upload_boq_final_fields">
                                                    <td class="align-middle">
                                                        BOQ Final <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="upload_boq_final">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="upload_foto_general_fields">
                                                    <td class="align-middle">
                                                        Foto General <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="upload_foto_general">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="ktp_kwitansi_field">
                                                    <td class="align-middle">
                                                        KTP Kwitansi <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="ktp_kwitansi">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="scanned_id_field">
                                                    <td class="align-middle">
                                                        Scanned IW <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="scanned_id">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="copy_cme_field">
                                                    <td class="align-middle">
                                                        Copy of CME PO (if any) <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="copy_cme">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="bamt_field">
                                                    <td class="align-middle">
                                                        BAMT (Berita Acara Material Terpasang) <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="bamt">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="ori_bpujl_field">
                                                    <td class="align-middle">
                                                        Original BPUJL (if PLN Scope included) <span class="form-required">*</span>
                                                    </td>

                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="ori_bpujl">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="cme_opname_field">
                                                    <td class="align-middle">
                                                        CME Opname Photos <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="cme_opname">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="final_doc_field">
                                                    <td class="align-middle">
                                                        Copy of Final Documents <span class="form-required">*</span>
                                                    </td>

                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="final_doc">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="ba_stock_field">
                                                    <td class="align-middle">
                                                        BA Stock Opname ( @warehouse ) <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="ba_stock">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="nod_field">
                                                    <td class="align-middle">
                                                        NOD <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="nod">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="fo_progress_photos_field">
                                                    <td class="align-middle">
                                                        FO Progress Foto <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="fo_progress_photos">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="add_sitac_field">
                                                    <td class="align-middle">
                                                        Scanned RFC <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="add_sitac">View</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="font-size: small; display: none;" id="additional_doc_field">
                                                    <td class="align-middle">
                                                        Additional Documents <span class="form-required">*</span>
                                                    </td>
                                                    <td width="250">
                                                        <div class="text-left">
                                                            <a target="_blank" href="" id="additional_doc">View</a>
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

                    <div class="nk-chat-profile visible" data-simplebar>
                        <div class="chat-profile">

                            <div class="chat-profile-group">
                                <a href="#" class="chat-profile-head" data-toggle="collapse" data-target="#chat-members">
                                    <h6 class="title overline-title text-dark">Approval Info</h6>
                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                </a>
                                <div class="chat-profile-body collapse show" id="chat-members">
                                    <div class="chat-profile-body-inner">
                                        <ul class="chat-members" id="ebast_approval_info"></ul>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-profile-group">
                                <a href="#" class="chat-profile-head" data-toggle="collapse" data-target="#response-panel">
                                    <h6 class="title overline-title text-dark">Response</h6>
                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                </a>
                                <div class="chat-profile-body collapse show" id="response-panel">

                                    <input type="hidden" name="ebast_id" id="ebast_id" value="">
                                    <input type="hidden" name="request_number" id="request_number" value="">
                                    <input type="hidden" name="approval_id" id="approval_id" value="">
                                    <input type="hidden" name="requestor" id="requestor" value="">

                                    <div class="chat-profile-body-inner" id="button_response_panel" style="display: show;">
                                        <ul>
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control form-control-sm no-resize" id="response-notes" placeholder="Write your note here..."></textarea>
                                                </div>
                                            </div>
                                        </ul>
                                        <br>

                                         <ul class="align-center g-4">
                                            <li id="li_evaluation_proc" style="display: none;">
                                                <a id="ebast-evaluation-proc" title="Review Vendor Evaluation" class="btn btn-white btn-md btn-outline-dark">
                                                    <em class="icon ni ni-eye"></em><span>Review Vendor Evaluation &nbsp;&nbsp;</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <ul class="align-center g-2">
                                            
                                            <li id="li_approved">
                                                <a id="ebast-approved" title="Approve this request" class="btn btn-white btn-dim btn-md btn-outline-primary">
                                                    <em class="icon ni ni-check"></em><span>Approve &nbsp;&nbsp;</span>
                                                </a>
                                            </li>

                                            <li id="li_evaluation" style="display: none;">
                                                <a id="ebast-evaluation" title="Evaluation Vendor Form" class="btn btn-white btn-md btn-outline-dark">
                                                    <em class="icon ni ni-check"></em><span>Evaluation &nbsp;&nbsp;</span>
                                                </a>
                                            </li>

                                            <li>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle btn btn-round btn-light" data-toggle="dropdown">More Response <em class="icon ni ni-chevron-down"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a class="dropdown-item" style='cursor:pointer;' id="revise_vendor" onclick="return ebastRevise(this.id)"><em class="icon ni ni-curve-up-left"></em><span>Revise to Vendor</a></li>

                                                            <div id="revise_proc" style="display: none;">
                                                               
                                                                <li class="divider"></li>
                                                                <li><a class="dropdown-item" style='cursor:pointer;' id="revise_rpm" onclick="return ebastRevise(this.id)"><em class="icon ni ni-curve-up-left"></em><span>Revise to RPM</a></li>

                                                                <li class="divider"></li>
                                                                <li><a class="dropdown-item" style='cursor:pointer;' id="rollback_ebast" onclick="return ebastRevise(this.id)"><em class="icon ni ni-curve-up-left"></em><span>Rollback</a></li>
                                                                
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="chat-profile-body-inner" id="button_response_panel_success" style="display: none;">
                                        <ul class="align-center g-2">
                                            <li>
                                                <h3 class="ff-base fw-medium">
                                                    <small class="text-dark"></small>
                                                </h3>
                                            </li>
                                        </ul>
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

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewBAST">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>BERITA ACARA SERAH TERIMA</b></h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <p>Pada hari ini <span id="on_this_date_bast"></span> yang bertandatangan di bawah ini :</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Nama</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast_vendor_name"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Jabatan</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast_vendor_title"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>dalam hal ini bertindak untuk dan atas nama <span id="bast_vendor"></span>, yang selanjutnya disebut “<b>Kontraktor</b>”, dan</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Nama</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast_ibs_name"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Jabatan</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast_ibs_title"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>dalam hal ini bertindak untuk dan atas nama PT. Infrastruktur Bisnis Sejahtera, yang selanjutnya disebut <b>"IBSW"</b>.</p>
                        <p>Pihak Pertama dan Pihak Kedua secara bersama-sama selanjutnya disebut "Para Pihak".</p>
                        <p>Para Pihak dengan ini terlebih dahulu menyatakan hal-hal sebagai berikut:</p>
                        <p>Para Pihak telah melakukan serah terima dokumen dan atau pekerjaan dari Kontraktor kepada IBSW untuk pekerjaan berikut :</p>
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">No. Purchase Order (PO)</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b id="bast_po_number"></b></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">WBS ID / Nama Site</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b id="bast_wbs_id"></b> / <b id="bast_site_name"></b> </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Ruang Lingkup - Tipe Pekerjaan</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b id="bast_worktype"></b> - <b id="bast_milestone"></b> (<i>atau sesuai lampiran</i>)*</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Status Pekerjaan</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b>Telah selesai dan diterima</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p><i>*) Jika ada lampiran harus ditandatangani oleh pejabat yang berwenang dari masing-masing Pihak</i></p>
                        <p>Jangka waktu masa pemeliharaan atas pekerjaan adalah <b id="masa_bast"> </b> berlaku sejak tanggal BAST.</p>
                        <p>Setiap kekurangan atau kerusakan yang timbul selama masa pemeliharaan yang disebabkan karena pelaksanaan atau kualitas pekerjaan atau material yang tidak sesuai spesifikasi, menjadi tanggung jawab kontraktor untuk melakukan perbaikan atau penggantian terhadap kekurangan atau kerusakan dimaksud.</p>
                        <p>Demikian Berita Acara Serah Terima ini dibuat dan ditandatangani secara bersama – sama, yang dapat dipertanggungjawabkan kebenaran dan keabsahannya, untuk dapat dipergunakan sebagaimana mestinya dalam proses selanjutnya.</p>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <p>Diserahkan oleh, <br><b id="bast_received_by"></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>Diterima dan disetujui oleh,</br><b>PT. Infrastruktur Bisnis Sejahtera</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <br>
                            <p><b>Nama: <span id="bast_ttd_vendor_name"></span> </b><br><b>Jabatan: <span id="bast_ttd_vendor_title"></span></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <br>
                            <p><b>Nama: <span id="bast_ttd_ibs_name"></span></b><br><b>Jabatan: <span id="bast_ttd_ibs_title"></span></b></p>
                        </div>
                    </div>

                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewBAprogress">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>BERITA ACARA PROGRESS</b></h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <p>Pada hari ini <span id="on_this_date_ba_progress"></span> yang bertandatangan di bawah ini :</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Nama</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="ba_progress_vendor_name"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Jabatan</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="ba_progress_vendor_title"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>dalam hal ini bertindak untuk dan atas nama <span id="ba_progress_vendor"></span>, yang selanjutnya disebut “<b>Kontraktor</b>”, dan</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Nama</th>
                                        <td>:</td>
                                        <td style="text-align: left;"</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Jabatan</th>
                                        <td>:</td>
                                        <td style="text-align: left;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>dalam hal ini bertindak untuk dan atas nama PT. Infrastruktur Bisnis Sejahtera, yang selanjutnya disebut <b>"IBSW"</b>.</p>
                        <p>Pihak Pertama dan Pihak Kedua secara bersama-sama selanjutnya disebut "Para Pihak".</p>
                        <p>Para Pihak dengan ini terlebih dahulu menyatakan hal-hal sebagai berikut:</p>
                        <p>Para Pihak menyepakati bahwa telah dilakukan pekerjaan oleh kontraktor kepada IBSW sebagai berikut: :</p>
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">No. Purchase Order (PO)</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b id="ba_progress_po_number"></b></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">WBS ID / Nama Site</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b id="ba_progress_wbs_id"></b> / <b id="ba_progress_site_name"></b></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Ruang Lingkup - Tipe Pekerjaan</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b id="ba_progress_worktype"></b> - <b id="ba_progress_milestone"></b> (<i>atau sesuai lampiran</i>)*</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Status Pekerjaan</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b>Pekerjaan telah dilakukan sesuai progress yang dilaporkan.</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p><i>*) Jika ada lampiran harus ditandatangani oleh pejabat yang berwenang dari masing-masing Pihak</i></p>
                        <p>Demikian Berita Acara Progress ini dibuat dan ditandatangani secara bersama – sama, yang dapat dipertanggungjawabkan kebenaran dan keabsahannya, untuk dapat dipergunakan sebagaimana mestinya dalam proses selanjutnya.</p>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <p>Diserahkan oleh, <br><b id="ba_progress_received_by"></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>Diterima dan disetujui oleh,</br><b>PT. Infrastruktur Bisnis Sejahtera</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <br>
                            <p><b>Nama: <span id="ba_progress_ttd_vendor_name"></span></b><br><b>Jabatan: <span id="ba_progress_ttd_vendor_title"></span></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <br>
                            <p><b>Nama: </b><br><b>Jabatan:</b></p>
                        </div>
                    </div>

                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewBASTopname">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>BERITA ACARA SERAH TERIMA</b></h5>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <table class="table table-bordered" id="listOpname">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Deskripsi Material</th>
                                    <th scope="col">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="materialTable">
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row">
                        <p>Pada hari ini ..., yang bertandatangan di bawah ini :</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Nama</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b>YANWARIE ADIKRISHNA</b></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Jabatan</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b>Logistik</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <p>Dalam hal ini bertindak untuk dan atas nama PT. Infrastruktur Bisnis Sejahtera (selanjutnya disebut IBSW), sdan</p>
                    </div>
                    <div class="row">

                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Nama</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast_opname_vendor_name"><b></b></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Jabatan</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast_opname_vendor_title"><b></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>Dalam hal ini bertindak untuk dan atas nama <b><span id="bast_opname_vendor"></span></b> (selanjutnya disebut SUPPLIER).</p>
                    </div>
                    <br>
                    <div class="row">
                        <p>Berdasarkan Puchase Order Nomor : <span id="bast_opname_po_number"></span>,  IBSW dan SUPPLIER menyatakan sebagai berikut :</p>
                        <p>1). SUPPLIER telah menyelesaikan pekerjaan beserta detailnya dengan baik kepada IBSW di warehouse  SUPPLIER sesuai dengan Purchase Order tersebut diatas.</p>
                        <p>2). IBSW telah menerima pekerjaan beserta detailnya dengan baik dengan ketentuan :</p>
                        <p>a.   Penyelesaian pekerjaan tidak mengalami keterlambatan.</p>
                        <p>b.  Jaminan dari SUPPLIER untuk kualitas yang telah disepakati selama 6 bulan terhitung dari tanggal PO terbit oleh IBSW kepada SUPPLIER.</p>
                        <p>c.   Jaminan dari SUPPLIER memberikan tempat penyimpanan/warehouse untuk Material yang telah selesai diproduksi oleh SUPPLIER namun belum diambil (NOD) oleh IBSW.</p>
                        <p>d.   Sisa Material di Warehouse SUPPLIER yang belum diambil (NOD) oleh IBSW tetap menjadi tanggung jawab SUPPLIER jika ada kerusakan  dan kehilangan.</p>
                        <p>e.   Setiap kerusakan yang timbul akibat kekeliruan desain dan produksi menjadi tanggung jawab SUPPLIER untuk melakukan perbaikan dan penggantian akibat kerusakan yang dimaksud.</p>
                        <br>
                        <p>Berita Acara ini dibuat rangkap 3 (tiga) asli di atas materai yang cukup yang masing-masing mempunyai kekuatan hukum yang sama, setelah ditandatangani oleh wakil sah masing-masing pihak.</p>
                    </div>

                    <br><br><br><br><br>
                    <div class="row">
                        <div class="col-4">
                            <p><b><span id="bast_opname_ttd_vendor"></span></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p><b>PT. Infrastruktur Bisnis Sejahtera</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <br>
                            <p>Nama: <b><span id="bast_opname_ttd_vendor_name"></span></b><br>Jabatan: <b><span id="bast_opname_ttd_vendor_title"></span></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <br>
                            <p>Nama: <b></b><br>Jabatan: <b></b></p>
                        </div>
                    </div>

                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewRFI">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>Ready For Equipment/Installation (RFE/RFI) Certificate</b></h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">WBS ID <br><small>Nomor Lokasi</small></th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="rfi_wbs_id"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Site Name <br> <small>Nama Lokasi</small></th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="rfi_site_name"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Type of Work(s) <br> <small>Jenis Pekerjaan</small></th>
                                        <td>:</td>
                                        <td style="text-align: left;">
                                            <p><input type="checkbox" id="tow_erection"><strong> TOWER ERECTION &amp; PAINTING</strong></p>
                                            <p><input type="checkbox" id="tow_me"><strong> CIVIL, MECHANICAL & ELETRICAL</strong></p>
                                            <p><input type="checkbox" id="tow_power"><strong> POWER</strong></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p><b>Deliverable Items are to be organized by PT. Infrastruktur Bisnis Sejahtera </b> <br> Hal-hal yang harus dicapai akan diatur oleh PT. Infrastruktur Bisnis Sejahtera </p>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>NA</th>
                                        <th style="text-align: center">Deliverable Items (Hal-hal yang harus dicapai)</th>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" id="erection_yes"></td>
                                        <td><input type="checkbox" id="erection_no"></td>
                                        <td><input type="checkbox" id="erection_na"></td>
                                        <td style="text-align: left;">
                                            <p>Is RFE/RFI checklist of Tower Erection and Painting completed and acceptable? <br> Apakah RFE/RFI Checklist untuk ereksi dan Pengecatan tower terlengkapi dan dapat diterima? </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" id="me_yes"></td>
                                        <td><input type="checkbox" id="me_no"></td>
                                        <td><input type="checkbox" id="me_na"></td>
                                        <td style="text-align: left;">
                                            <p>Is RFE/RFI checklist of Mechanical and Electrical completed and acceptable? <br> Apakah RFE/RFI Checklist untuk Mekanikal dan Elektrikal lengkap dan dapat diterima? </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" id="pln_yes"></td>
                                        <td><input type="checkbox" id="pln_no"></td>
                                        <td><input type="checkbox" id="pln_na"></td>
                                        <td style="text-align: left;">
                                            <p>Is Power Supply connected and available for use? <br> Apakah Power (PLN/Genset) tersambung and dapat digunakan? </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th></th>
                                        <th style="text-align: center">CONCLUDING SUMMARY (Kesimpulan)</th>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" id="sum_yes"></td>
                                        <td><input type="checkbox" id="sum_no"></td>
                                        <td></td>
                                        <td style="text-align: left;">
                                            <p>Does the inspection indicate that installation of electronic can start ? <br> Apakah inspeksi ini menandakan bahwa instalasi untuk elektronik dapat dimulai? </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br><br>
                    <div class="row">
                        <div class="col-7"></div>
                        <div class="col-5"><b>PT. Infrastruktur Bisnis Sejahtera</b></div>
                    </div>
                    <div class="row">
                        <div class="col-7"></div>
                        <div class="col-5">
                            <br>
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7"></div>
                        <div class="col-5">
                            <p><b> Nama: <span id="rfi_ibs_name"></span><br>Jabatan: <span id="rfi_ibs_title"></span></b></p>
                        </div>
                    </div>
                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewReceipt">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <br><br>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>TANDA TERIMA DOKUMEN</b></h5>
                        </div>
                    </div>
                    <hr><br>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Site Name</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="receipt_site_name"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">WBS ID</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="receipt_wbs_id"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>

                    <div class="col-12" >
                        <table class="table table-bordered" id="listReceipt">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Item Pekerjaan</th>
                                    <th scope="col">Lengkap / Tidak Lengkap</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="receiptTable">
                            </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-faded">
                                    <div class="card-detail">
                                        Notes:
                                    </div>
                                    <div class="card-body">
                                        <p id="prev_receipt_notes"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Diserahkan oleh, <br><b id="receipt_vendor"></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>Diterima dan disetujui oleh,</br><b>PT. Infrastruktur Bisnis Sejahtera</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <br>
                            <p><b>Nama: <span id="receipt_vendor_name"></span></b><br><b>Jabatan: <span id="receipt_vendor_title"></span></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <br>
                            <p><b>Nama: <span id="receipt_ibs_name"></span></b><br><b>Jabatan: <span id="receipt_ibs_title"></span></b></p>
                        </div>
                    </div>
                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewBAMT">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Summary Pelaporan Material</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <table class="table table-tranx" >
                        <tr>
                            <td><b>PO Project Number</b></td>
                            <td id="prev_bamt_po"></td>
                            <td><b>IBS PIC Project Name</b></td>
                            <td id="prev_bamt_pic_ibs_name"></td>
                        </tr>
                        <tr>
                            <td><b>WBS ID</b></td>
                            <td id="prev_bamt_wbs_id"></td>
                            <td><b>IBS PIC Phone</b></td>
                            <td id="prev_bamt_pic_phone"></td>
                        </tr>
                        <tr>
                            <td><b>Project Name</b></td>
                            <td colspan="3" id="prev_bamt_project_name"></td>
                        </tr>
                        <tr>
                            <td><b>Segment/Site Name</b></td>
                            <td id="prev_bamt_sitename"></td>
                            <td><b>Regional</b></td>
                            <td id="prev_bamt_regional"></td>
                        </tr>
                        <tr>
                            <td><b>Contractor</b></td>
                            <td id="prev_bamt_vendor"></td>
                            <td><b>PIC Material Contractor Phone</b></td>
                            <td id="prev_bamt_vendor_phone"></td>
                        </tr>
                        <tr>
                            <td><b>PIC Material Contractor Name</b></td>
                            <td id="prev_bamt_vendor_name"></td>
                            <td><b>PIC Material Contractor Email</b></td>
                            <td id="prev_bamt_vendor_email"></td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-tranx" >
                        <thead>
                            <tr class="tb-tnx-head">
                                <th>No.</th>
                                <th>NOD Number</th>
                                <th>PO Number</th>
                                <th>Material Code</th>
                                <th>Material Type</th>
                                <th>Quantity</th>
                                <th>Terpasang</th>
                                <th>Sisa</th>
                                <th>Rusak</th>
                                <th>Hilang</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="summary_material_bamt">
                           
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewBoqFinal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>BOQ Final</b></h5>
                        </div>
                    </div>
                    <hr><br>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tbody>
                                     <tr>
                                        <th style="text-align: left">Uploaded Files</th>
                                        <td>:</td>
                                        <td style="text-align: left;">
                                            <div class="text-left">
                                                <a target="_blank" href="" id="files_boq_final">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left">Input Nominal</th>
                                        <td>:</td>
                                        <td style="text-align: left;">
                                            <input disabled type="text" name="nominal_boq" id="nominal_boq">
                                            <a onclick="return save_nominal_boq()" style="display: none" id="save_nominal_boq" class="btn btn-sm btn-default">
                                                Update
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left">Nominal Boq Final (Rp)</th>
                                        <td>:</td>
                                        <td style="text-align: left;">
                                            <input disabled type="text" name="current_nominal_boq" id="current_nominal_boq">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewWTCR">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>WORK TIME COMPLETION REPORT <br> (WTCR) </b></h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Type of Works</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="wtcr_tow"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">WBS ID </th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="wtcr_wbs"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Site Name</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="wtcr_sitename"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">PO Number</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="wtcr_po"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <p>On this date: ..., the work at project location mentioned above has been successfully completed.</p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <p>The result as follows:</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class='table'>
                                <tbody>
                                    <tr>
                                        <td>Duration of execution of work based on the amended KOM</td>
                                        <td>:</td>
                                        <td><span id="prev_execution_time" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp; - Work is started on (based on KOM)</td>
                                        <td>:</td>
                                        <td colspan="2">
                                            <span id="prev_start_date" class="text-dark fw-bold"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp; - Work should be finished on ( based on KOM)/td>
                                        <td>:</td>
                                        <td colspan="2">
                                            <span id="prev_finish_date" class="text-dark fw-bold"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp; - Work has been finished on (PAT date)</td>
                                        <td>:</td>
                                        <td colspan="2">
                                            <span id="prev_actual_finish_date" class="text-dark fw-bold"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>The actual duration of execution of work (based on KOM)</td>
                                        <td>:</td>
                                        <td> <span id="prev_actual_execution_time" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>
                                    <tr>
                                        <td><b>Job Acceleration / Delay (A)</b></td>
                                        <td>:</td>
                                        <td> <span id="prev_job_acceleration_a_1" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <p>The reason of delay in the execution of work are :</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class='table'>
                                <tbody>
                                    <tr>
                                        <td>1. Raining</td>
                                        <td>:</td>
                                        <td> <span id="prev_reason_raining" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td>2. Change of Scope of Work</td>
                                        <td>:</td>
                                        <td> <span id="prev_reason_change_sow" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td>3. Discontinuance by IBS / Owner of the building</td>
                                        <td>:</td>
                                        <td> <span id="prev_reason_discontinuance" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">4. Others</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp; a. <span id="prev_reason_others_a" class="text-dark fw-bold"></span></td>
                                        <td>:</td>
                                        <td> <span id="prev_reason_others_a_days" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp; b. <span id="prev_reason_others_b" class="text-dark fw-bold"></span></td>
                                        <td>:</td>
                                        <td> <span id="prev_reason_others_b_days" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp; c. <span id="prev_reason_others_c" class="text-dark fw-bold"></span></td>
                                        <td>:</td>
                                        <td> <span id="prev_reason_others_c_days" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp; d. <span id="prev_reason_others_d" class="text-dark fw-bold"></span></td>
                                        <td>:</td>
                                        <td> <span id="prev_reason_others_d_days" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td><b>Total ( B )</b></td>
                                        <td>:</td>
                                        <td> <span id="prev_total_b" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>

                                    <tr>
                                        <td><b>Job Acceleration / Delay (A)</b></td>
                                        <td>:</td>
                                        <td> <span id="prev_job_acceleration_a_2" class="text-dark fw-bold"></span></td>
                                        <td>Calendar Days</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <table class='table'>
                                <tr>
                                    <td colspan="3"><b>Penalty Calculation (Filled by IBS Procurement)</b></td>
                                </tr>
                                <tr>
                                    <td>PO Value </td>
                                    <td>:</td>
                                    <td>
                                        <p id="current_po_value"></p>
                                        <input disabled type="text" name="ebast_po_value" id="ebast_po_value">
                                        <a onclick="return calculate_po_penalty()" style="display: none" id="calculate_po_penalty" class="btn btn-round btn-icon btn-light">
                                            <em class="icon ni ni-reload-alt"></em>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1. Late Completion (0,5% from PO Value X E) max 10% </td>
                                    <td>:</td>
                                    <td>
                                        <p id="current_penalty"></p>
                                        <input type="text" readonly name="wtcr_late_completion" id="wtcr_late_completion"> 
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br><br><br><br><br>
                    <div class="row">
                        <div class="col-4">
                            <p>Prepared by, <br><b id="wtcr_vendor"></b></p>
                        </div>
                        <div class="col-4">
                            <p>Approved by, <br><b>PT. Infrastruktur Bisnis Sejahtera</b></p>
                        </div>
                        <div class="col-4">
                            <p>Acknowledge by, <br><b>PT. Infrastruktur Bisnis Sejahtera</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <br>
                            <p>Name: <b id="wtcr_vendor_name"></b><br>Title: <b id="wtcr_vendor_title"></b></p>
                        </div>
                        <div class="col-4">
                            <br>
                            <p>Name: <b id="wtcr_ibs_pm"> </b><br>Title: <b id="wtcr_ibs_pm_title"> </b></p>
                        </div>
                        <div class="col-4">
                            <br>
                            <p>Name: <b id="wtcr_ibs_procurement"></b><br>Title: <b>Procurement Manager</b></p>
                        </div>
                    </div>
                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="formWTCR">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update WTCR</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">
                        <table class="table table-condensed">
                            <tr class="warning">
                                <th>
                                    <p style="width: 400px;">Duration of execution of work based on the amended KOM <small><i style="color: red;"><b>*Automatic by system</b></i></small></p>
                                </th>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="execution_time" id="execution_time" type="text" value="" autocomplete="off" readonly>
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr class="warning">
                                <td>- Work is started on (based on KOM)</td>
                                <td style="width:150px;">
                                    <input type="text" name="start_date" id="start_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>- Work should be finished on ( based on KOM)</td>
                                <td style="width:150px;">
                                    <input type="text" name="finish_date" id="finish_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>- Work has been finished on (PAT date)</td>
                                <td style="width:150px;">
                                    <input type="text" name="actual_finish_date" id="actual_finish_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                </td>
                                <td></td>
                            </tr>
                            <tr class="warning">
                                <td>
                                    <p style="width: 400px;">The actual duration of execution of work (based on KOM) <small><i style="color: red;"><b>*Automatic by system</b></i></small></p>

                                </td>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="actual_execution_time" id="actual_execution_time" type="text" value="" autocomplete="off" readonly>
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <table class="table table-condensed">
                            <tr class="warning">
                                <th>
                                    <p style="width: 400px;">Job Acceleration / Delay (A) <small><i style="color: red;"><b>*Automatic by system</b></i></small></p>
                                </th>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="job_acceleration_a_1" id="job_acceleration_a_1" type="text" value="" autocomplete="off" readonly>
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>1. Raining</td>
                                <td style="width:150px;">
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="reason_raining" id="reason_raining" type="number" value="0" autocomplete="off">
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2. Change of Scope of Work</td>
                                <td style="width:150px;">
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="reason_change_sow" id="reason_change_sow" type="number" value="0" autocomplete="off">
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3. Discontinuance by IBS / Owner of the building</td>
                                <td style="width:150px;">
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="reason_discontinuance" id="reason_discontinuance" type="number" value="0" autocomplete="off">
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4. Others</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="color: black;">a</span>&nbsp;&nbsp;
                                        <input class="form-control" name="reason_others_a" id="reason_others_a" type="text" value="" autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="reason_others_a_days" id="reason_others_a_days" type="number" value="0" autocomplete="off">
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="color: black;">b</span>&nbsp;&nbsp;
                                        <input class="form-control" name="reason_others_b" id="reason_others_b" type="text" value="" autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="reason_others_b_days" id="reason_others_b_days" type="number" value="0" autocomplete="off">
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="color: black;">c</span>&nbsp;&nbsp;
                                        <input class="form-control" name="reason_others_c" id="reason_others_c" type="text" value="" autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="reason_others_c_days" id="reason_others_c_days" type="number" value="0" autocomplete="off">
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="color: black;">d</span>&nbsp;&nbsp;
                                        <input class="form-control" name="reason_others_d" id="reason_others_d" type="text" value="" autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="reason_others_d_days" id="reason_others_d_days" type="number" value="0" autocomplete="off">
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <table class="table table-condensed">
                            <tr class="warning">
                                <th>TOTAL (B)
                                    <small><i style="color: red;"><b>*Automatic by system</b></i></small>
                                </th>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="total_b" id="total_b" type="text" value="" autocomplete="off" readonly>
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr class="warning">
                                <th>Job Acceleration / Delay (A)
                                    <small><i style="color: red;"><b>*Automatic by system</b></i></small>
                                </th>
                                <td>
                                    <div class="input-group" style="width: 180px;">
                                        <input class="form-control" name="job_acceleration_a_2" id="job_acceleration_a_2" type="text" value="" autocomplete="off" readonly>
                                        &nbsp;&nbsp;&nbsp;<span class="input-group-addon" style="color: black;">Calendar Days</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="javascript:save_wtcr();" class="btn btn-sm btn-primary"><span class="textModalWtcr" value=" Calculate & Save"> Calculate & Save</span></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
               <!--  <div class="form-group">
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-secondary">Finish</button>
                </div> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="previewBAST2">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>FINAL ACCEPTANCE CERTIFICATE <br> (BERITA ACARA SERAH TERIMA II) </b></h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-7">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Type of Works</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast2_tow"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">WBS ID / Site Name</th>
                                        <td>:</td>
                                        <td style="text-align: left;"> <span id="bast2_wbs_id"></span> / <span id="bast2_site_name"></span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p>On this date: , we the undersigned</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Name</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast2_ibs_name1"></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Title</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast2_ibs_title1"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p>On this matter acting for and on behalf of PT. Infrastruktur Bisnis Sejahtera, (herein after referred to as “IBS“), and "IBSW"</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">Name</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast2_vendor_name1"> </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Title</th>
                                        <td>:</td>
                                        <td style="text-align: left;" id="bast2_vendor_title1"> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p>On this matter acting for and on behalf of <span id="bast2_vendor1"></span> , (herein after referred to as “Contractor“).</p>
                        </div>
                    </div>
                    <div>
                        <p>By virtue of :</p>
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: left">1. CME Purchase Order (PO)</th>
                                        <td>:</td>
                                        <td style="text-align: left;"><b id="bast2_po"></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>IBS and Contractor hereby state the followings:</p>
                        <p>1. Contractor has transferred the Conformance Period to IBS at the Location in accordance with Purchase Order referred to above.</p>
                        <p>2. IBS has accepted the Services and the title thereof satisfactorily, provided that punch list clearance certificate.</p>
                    </div>

                    <br><br><br><br><br>
                    <div class="row">
                        <div class="col-4">
                            <p><b id="bast2_vendor"></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p><b>PT. Infrastruktur Bisnis Sejahtera</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p>
                                <span style='color:#BFBFBF'>
                                    <center><small><b><i>PREVIEW</i></b></small></center>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <br>
                            <p>Nama: <b id="bast2_vendor_name"></b><br>Jabatan: <b id="bast2_vendor_title"></b></p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <br>
                            <p>Nama: <b id="bast2_ibs_name"></b><br>Jabatan: <b id="bast2_ibs_title"></b></p>
                        </div>
                    </div>

                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade zoom" tabindex="-1" data-backdrop="static" data-keyboard="false" id="formEvaluation">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EVALUATION VENDOR FORM</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
            	<div class="card card-bordered">
                    <div class="card-inner">
                        <form action="#" class="form-validate" id="formEvaluationVendor">
                            
                            <div class="nk-wizard-content">
                            	<div class="row">
                                    <div class="col-12">
                                        <h5>PENCAPAIAN</h5>
                                    </div>

                                    <div class="col-6">
                                        <hr>
			                            <table class="table table-condensed">
			                                <tr class="warning">
			                                    <th>
			                                        Project Name <i style="color: red;">*</i>
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
                                                        <select class="form-select form-control required" name="eval_project_name" id="eval_project_name" data-search="on">
                                                        </select>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>

			                                <tr class="warning">
			                                    <th>
			                                        Project Manager
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
			                                            <input class="form-control" name="eval_rpm" id="eval_rpm" type="text" readonly>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>

			                                <tr class="warning">
			                                    <th>
			                                        Regional
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
			                                            <input class="form-control" name="eval_regional" id="eval_regional" type="text" readonly>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>
			                                
			                                <tr class="warning">
			                                    <th>
			                                        Contractor Name
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
			                                            <input class="form-control" name="eval_vendor_name" id="eval_vendor_name" type="text" readonly>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>
			                            </table>
			                        </div>

			                        <div class="col-6">
                                        <hr>

			                            <table class="table table-condensed">
			                            	<tr class="warning">
			                                    <th>
			                                        Worktype
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
			                                            <input class="form-control" name="eval_worktype" id="eval_worktype" type="text" readonly>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>
			                                <tr class="warning">
			                                    <th>
			                                        PO Number
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
			                                            <input class="form-control" name="eval_po_number" id="eval_po_number" type="text" readonly>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>
			                                <tr class="warning">
			                                    <th>
			                                        WBS ID
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
			                                            <input class="form-control" name="eval_wbs" id="eval_wbs" type="text" readonly>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>
			                                <tr class="warning">
			                                    <th>
			                                        Site/Segment Name
			                                    </th>
			                                    <td>
			                                        <div class="input-group">
			                                            <input class="form-control" name="eval_site_name" id="eval_site_name" type="text" readonly>
			                                        </div>
			                                    </td>
			                                    <td></td>
			                                </tr>
			                            </table>
			                        </div>
			                    </div>

			                    <br>
			                    <div class="row">
			                        <div class="col-12">
			                            
			                            <table class="table table-tranx">
			                                <thead>
			                                    <tr class="tb-tnx-head">
			                                        <th class="tb-tnx-item" style="width: 300px;">Time <i style="color: red;">*</i></th>
			                                        <th class="tb-tnx-item" style="width: 300px;">Quality <i style="color: red;">*</i></th>
			                                        <th class="tb-tnx-item" style="width: 300px;">Safety <i style="color: red;">*</i></th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                    <tr class="table-bordered">
			                                        <td style="height: 50px;" id="td_score_acv">
			                                            <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="4" min="1" max="5.00" onchange="setTwoNumberDecimal" step=".01" value="0.00" class="form-control form-control-lg form-control-number" name="eval_achievement" id="eval_achievement">
                                                        <p id="alert_td_acv" style="display: none;">Please input score less than or equal to 5</p>
			                                        </td>
			                                        <td style="height: 50px;" id="td_score_qlt">
			                                            <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="4" min="1" max="5.00" onchange="setTwoNumberDecimal" step=".01" value="0.00" class="form-control form-control-lg form-control-number" name="eval_quality" id="eval_quality">
                                                        <p id="alert_td_qlt" style="display: none;">Please input score less than or equal to 5</p>
			                                        </td>
			                                        <td style="height: 50px;">
			                                            <input type="number" readonly value="0.00" class="form-control form-control-lg form-control-number error" name="eval_safety" id="eval_safety">
			                                        </td>
			                                    </tr>
			                                    <tr class="table-bordered">
			                                        <td style="height: 50px;">
			                                            <p><a id="download_kriteria_time" target="_blank" href=""><b><u>Download Kriteria Penilaian:</u> </b></a></p>
                                                        <p id="div_upload_fo_time" style="display: none;">
                                                            <input type="file" name="fo_criteria_time" id="fo_criteria_time">
                                                        </p>
			                                        </td>
			                                        <td>
                                                        <p><a id="download_kriteria_quality" target="_blank" href=""><b><u>Download Kriteria Penilaian:</u></b></a></p>
                                                        <p id="div_upload_fo_quality" style="display: none;">
                                                            <input type="file" name="fo_criteria_quality" id="fo_criteria_quality">
                                                        </p>
			                                        </td>
			                                        <td>
			                                            <p><i style="color: blue;">Nilai Safety akan terisi otomatis setelah memasukan nilai pada tabel ceklist penerapan K3 dibawah ini. </i></p>
			                                        </td>
			                                    </tr>
			                                </tbody>
			                            </table>
			                        
			                        </div>
			                    </div>
                            </div>
                            <br><br>
                            <div class="nk-wizard-content">
                                <div class="row">
                                    <div class="col-12">
                                        <h5>CEKLIS PENERAPAN K3</h5>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                        <table class="table table-tranx is-compact">
                                            <thead>
                                                <tr class="tb-tnx-head">
                                                    <th class="tb-tnx-id">No.</th>
                                                    <th class="tb-tnx-info">Kriteria Penilaian</th>
                                                    <th class="tb-tnx-info">Keterangan</th>
                                                    <th>Bobot (%)</th>
                                                    <th>Penilaian</th>
                                                    <th style="width: 15px;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableCeklis">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="nk-wizard-content">
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Time Remarks </h5>
                                    </div>

                                    <div style="display: none;" id="eval_time_permit">
                                        <br>
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>RFS</b> based on KOM:</label>
                                                        <input type="text" name="rfs_start_date" id="rfs_start_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>RFS</b> Actual Date:</label>
                                                        <input type="text" name="rfs_end_date" id="rfs_end_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>WTCR</b> Start Date:</label>
                                                        <input type="text" name="wtc_start_date" id="wtc_start_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>WTCR</b> Finish Date:</label>
                                                        <input type="text" name="wtc_end_date" id="wtc_end_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <table class="table table-tranx">
                                            <thead>
                                                <tr class="tb-tnx-head">
                                                    <th>Permit Name</th>
                                                    <th>Permit Start Date</th>
                                                    <th>Permit End Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="permit_table">
                                            </tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-select form-control form-control-sm" name="permit_name" id="permit_name" data-search="on">
                                                        <option value=""> Select </option>
                                                        <option value="Kota">Kota</option>
                                                        <option value="Provinsi">Provinsi</option>
                                                        <option value="Kabupaten">Kabupaten</option>
                                                        <option value="Nasional">Nasional</option>
                                                        <option value="Kawasan">Kawasan</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="permit_start_date" id="permit_start_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                </td>
                                                <td>
                                                    <input type="text" name="permit_end_date" id="permit_end_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                </td>
                                                <td><input type="button" class="btn btn-sm btn-primary" onclick="return add_permit()" value="Add Permit Date"></td>
                                            </tr>
                                        </table>

                                        <input type="hidden" name="count_permit" id="count_permit" value="">

                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                        <span><p style="color: red;" id="countRemarksTime"></p></span>
                                        <div class="form-group">
                                            <textarea name="eval_remarks_time" id="eval_remarks_time" class="form-control form-control-simple no-resize" placeholder="Write your Time Remarks here.. *Minimum 200 character."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-wizard-content">
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Quality Remarks</h5>
                                        <span><p style="color: red;" id="countRemarksQuality"></p></span>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                        <div class="form-group">
                                            <textarea name="eval_remarks_quality" id="eval_remarks_quality" class="form-control form-control-simple no-resize" placeholder="Wirte your Quality Remarks here... *Minimum 200 character"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="nk-wizard-content" id="submitEvalForm">
                                <div class="row">
                                    <div class="col-12">

                                        <input type="hidden" name="eval_vendor_code" id="eval_vendor_code" value="">
                                        <input type="hidden" name="eval_numbering" id="eval_numbering" value="">
                                        <input type="hidden" name="eval_ebast_id" id="eval_ebast_id" value="">

                                        <div id="showSubmitButton" style="display: none;">
                                            <button type="button" onclick="javascript:save_evaluation();" class="btn btn-lg btn-block btn-primary">
                                                <span class="textModalEvaluation" value=" Submit"> Submit</span>
                                            </button>
                                        </div>
                                        
                                        <div id="hideSubmitButton" style="display: show;">
                                            <center>
                                                <h5>
                                                    Submit button will be enable after you complete the form.
                                                </h5>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade zoom" tabindex="-1" data-backdrop="static" data-keyboard="false" id="PreviewEvaluation">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EVALUATION VENDOR FORM</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="card card-bordered">
                    <div class="card-inner">
                            
                        <div class="nk-wizard-content">
                            <div class="row">
                                <div class="col-12">
                                    <h5>PENCAPAIAN</h5>
                                </div>

                                <div class="col-6">
                                    <hr>
                                    <table class="table table-condensed">
                                        <tr class="warning">
                                            <th>
                                                Project Name <i style="color: red;">*</i>
                                            </th>
                                            <td id="review_project_name"></td>
                                            <td></td>
                                        </tr>

                                        <tr class="warning">
                                            <th>
                                                Project Manager
                                            </th>
                                            <td id="id="review_project_manager></td>
                                            <td></td>
                                        </tr>

                                        <tr class="warning">
                                            <th>
                                                Regional
                                            </th>
                                            <td id="id="review_regional></td>
                                            <td></td>
                                        </tr>
                                        
                                        <tr class="warning">
                                            <th>
                                                Contractor Name
                                            </th>
                                            <td id="id="review_vendor_name></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-6">
                                    <hr>

                                    <table class="table table-condensed">
                                        <tr class="warning">
                                            <th>
                                                Worktype
                                            </th>
                                            <td id="id="review_worktype></td>
                                            <td></td>
                                        </tr>
                                        <tr class="warning">
                                            <th>
                                                PO Number
                                            </th>
                                            <td id="review_po_number"></td>
                                            <td></td>
                                        </tr>
                                        <tr class="warning">
                                            <th>
                                                WBS ID
                                            </th>
                                            <td id="id="review_wbs_id></td>
                                            <td></td>
                                        </tr>
                                        <tr class="warning">
                                            <th>
                                                Site/Segment Name
                                            </th>
                                            <td id="review_site_name"></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-12">
                                    
                                    <table class="table table-tranx">
                                        <thead>
                                            <tr class="tb-tnx-head">
                                                <th class="tb-tnx-item" style="width: 300px;">Time <i style="color: red;">*</i></th>
                                                <th class="tb-tnx-item" style="width: 300px;">Quality <i style="color: red;">*</i></th>
                                                <th class="tb-tnx-item" style="width: 300px;">Safety <i style="color: red;">*</i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-bordered">
                                                <td style="height: 50px;" readonly id="td_score_acv">
                                                    <input type="number" value="" class="form-control form-control-lg form-control-number" name="review_achievement" id="review_achievement">
                                                </td>
                                                <td style="height: 50px;" readonly id="td_score_qlt">
                                                    <input type="number" value="" class="form-control form-control-lg form-control-number" name="review_quality" id="review_quality">
                                                </td>
                                                <td style="height: 50px;">
                                                    <input type="number" readonly value="0.00" class="form-control form-control-lg form-control-number error" name="review_safety" id="review_safety">
                                                </td>
                                            </tr>
                                            <tr class="table-bordered">
                                                <td style="height: 50px;">
                                                    <p><a id="review_kriteria_time" target="_blank" href=""><b><u>Uploaded Time Criteria </u> </b></a></p>
                                                </td>
                                                <td>
                                                    <p><a id="review_kriteria_quality" target="_blank" href=""><b><u>Uploaded Quality Criteria</u></b></a></p>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="nk-wizard-content">
                            <div class="row">
                                <div class="col-12">
                                    <h5>CEKLIS PENERAPAN K3</h5>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <table class="table table-tranx is-compact">
                                        <thead>
                                            <tr class="tb-tnx-head">
                                                <th class="tb-tnx-id">No.</th>
                                                <th class="tb-tnx-info">Kriteria Penilaian</th>
                                                <th class="tb-tnx-info">Keterangan</th>
                                                <th>Bobot (%)</th>
                                                <th>Penilaian</th>
                                                <th style="width: 15px;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableCeklisReview">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="nk-wizard-content">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Time Remarks </h5>
                                </div>

                                <div style="display: none;" id="review_time_permit">
                                    <div class="col-12">
                                        <br>
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>RFS</b> based on KOM:</label>
                                                        <input type="text" name="rfs_start_date" id="rfs_start_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>RFS</b> Actual Date:</label>
                                                        <input type="text" name="rfs_end_date" id="rfs_end_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>WTCR</b> Start Date:</label>
                                                        <input type="text" name="wtc_start_date" id="wtc_start_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="text-dark"><b>WTCR</b> Finish Date:</label>
                                                        <input type="text" name="wtc_end_date" id="wtc_end_date" class="form-control date-picker" autocomplete="off" placeholder="Select Date" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <table class="table table-tranx">
                                            <thead>
                                                <tr class="tb-tnx-head">
                                                    <th>Permit Name</th>
                                                    <th>Permit Start Date</th>
                                                    <th>Permit End Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody id="review_permit_table">
                                            </tbody>
                                        </table>
                                    <div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-group">
                                        <textarea name="review_remarks_time" id="review_remarks_time" class="form-control form-control-simple no-resize"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-wizard-content">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Quality Remarks</h5>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-group">
                                        <textarea name="review_remarks_quality" id="review_remarks_quality" class="form-control form-control-simple no-resize"></textarea>
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

