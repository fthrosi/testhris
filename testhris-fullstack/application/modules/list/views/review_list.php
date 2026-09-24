<div class="nk-content p-0">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-chat">

                <div class="nk-chat-aside">
                    <div class="nk-chat-aside-head">
                        <div class="nk-chat-aside-user">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle dropdown-indicator" data-toggle="dropdown">
                                    <div class="title">Review List</div>
                                </a>
                                <div class="dropdown-menu">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="<?= base_url('list/request'); ?>"><span>My Request</span></a></li>
                                        <li><a href="<?= base_url('list/approval'); ?>"><span>Approval List</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?= base_url('list/ebast'); ?>"><span>E-BAST</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <ul class="nk-chat-aside-tools g-2">
                            <li>
                                <a href="<?= base_url('list/review'); ?>" class="btn btn-round btn-icon btn-light">
                                    <em class="icon ni ni-reload-alt"></em>
                                </a>
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

                                <?php if (!empty($review)) { ?>
                                    <?php foreach ($review as $key) {
                                        $jam = str_replace('.000', '', getTime($key->created_at));
                                        $tglBln = getTanggalBulan($key->created_at);
                                    ?>

                                        <li id="request-<?= $key->id; ?>" class="chat-item">
                                            <a class="chat-link chat-open" id="<?= $key->id; ?>" onclick="return viewRequest(this.id)">
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
                                                        <div class="name"><?= email_name($key->created_by); ?></div>
                                                        <span class="time" id="status_list-<?= $key->id; ?>"><?= status_list($key->is_status); ?></span>
                                                    </div>
                                                    <div class="chat-context">
                                                        <div class="text"><?= $key->formPurpose . '-' . $key->requestNumber; ?></div>
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
                                            Request Date: &nbsp;<span class="d-none d-sm-inline mr-1" id="requestDate"></span> -
                                            Request Status: &nbsp;<span class="d-none d-sm-inline mr-1" id="requestStatus"></span>
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
                                        <span class="text-gray">Purpose: </span>
                                    </td>
                                </tr>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <h6 class="ff-base fw-medium" id="formPurpose"></h6>
                                    </td>
                                </tr>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <span class="text-gray">Description: </span>
                                    </td>
                                </tr>
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-id">
                                        <h6 class="ff-base fw-medium" id="formNotes"></h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="nk-chat-panel" data-simplebar>
                        <div class="chat-sap">
                            <div class="chat-sap-meta"><span class="text-dark">Request Notes</span></div>
                        </div>

                        <div id="approval_notes">
                        </div>
                    </div>

                    <div class="nk-chat-profile visible" data-simplebar>
                        <div class="chat-profile">

                            <div class="chat-profile-group">
                                <a href="#" class="chat-profile-head" data-toggle="collapse" data-target="#action-review">
                                    <h6 class="title overline-title text-dark"> Add Review</h6>
                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                </a>
                                <div class="chat-profile-body collapse show" id="action-review">

                                    <input type="hidden" name="request_id" id="request_id" value="">
                                    <input type="hidden" name="request_number" id="request_number" value="">
                                    <input type="hidden" name="approval_id" id="approval_id" value="">
                                    <input type="hidden" name="review_id" id="review_id" value="">
                                    <input type="hidden" name="requestor" id="requestor" value="">

                                    <div class="chat-profile-body-inner" id="button_action_review" style="display: show;">

                                        <ul>
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control form-control-sm no-resize" id="review-notes" placeholder="Write your notes here..."></textarea>
                                                </div>
                                            </div>
                                        </ul>
                                        <br>

                                        <ul class="align-center g-2">
                                            <li>
                                                <a id="upload-review" title="Upload supporting files" class="btn btn-round btn-dim btn-md btn-outline-light">
                                                    <em class="icon ni ni-upload"></em><span>Upload &nbsp;&nbsp;</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a id="submit-review" title="Finish review" class="btn btn-round btn-dim btn-md btn-outline-primary">
                                                    <em class="icon ni ni-check"></em><span>Submit Review&nbsp;&nbsp;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="chat-profile-body-inner" id="button_action_review_done" style="display: none;">
                                        <ul class="align-center g-2">
                                            <li>
                                                <h5 class="ff-base fw-medium">
                                                    <small class="text-dark">Thank you for your review.</small>
                                                </h5>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <div class="chat-profile-group">
                                <a href="#" class="chat-profile-head" data-toggle="collapse" data-target="#chat-members">
                                    <h6 class="title overline-title text-dark">Approval Info</h6>
                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                </a>
                                <div class="chat-profile-body collapse show" id="chat-members">
                                    <div class="chat-profile-body-inner">
                                        <ul class="chat-members" id="li_approval_info"></ul>
                                        <br>
                                        <ul class="chat-members">
                                            <li><a class="chat-members-link add-opt" id="add-layer" style='cursor:pointer;'><em class="icon icon-circle sm bg-success ni ni-plus-sm"></em><span class="sub-text text-primary"> Add Layer</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-profile-group">
                                <a href="#" class="chat-profile-head" data-toggle="collapse" data-target="#supporting-files">
                                    <h6 class="title overline-title text-dark">Documents</h6>
                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                </a>
                                <div class="chat-profile-body collapse show" id="supporting-files">
                                    <div class="chat-profile-body-inner">
                                        <ul class="chat-profile-settings">
                                            <li>
                                                <a class="chat-option-link" href="#" target="_blank" id="prevApprovalForm">
                                                    <em class="icon icon-circle bg-light ni ni-file-pdf"></em>
                                                    <div>
                                                        <span class="lead-text text-primary">Approval Form</span>
                                                        <span class="sub-text" id="approvalFormName"></span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <span class="lead-text text-primary">Supporting Files</span>
                                            </li>
                                            <li id="document_reviewer">
                                                <a class="chat-option-link" href="#">
                                                    <div>
                                                        <span class="sub-text">Not Found.</span>
                                                    </div>
                                                </a>
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

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modal-upload-review">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Upload Supporting Files</h6>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <form id="form-upload-review" class="gy-3" enctype="multipart/form-data">

                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label">Multiple Supporting Files</label>
                                        <span class="form-note">Allowed format: Photo, Docs, Excel, PPT.</span>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="file" multiple="" id="multiSupportingFiles" name="multiSupportingFiles[]">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-7 offset-lg-5">
                                    <div class="form-group mt-2">
                                        <input type="hidden" id="modalrequest_id" name="modalrequest_id" value="">
                                        <input type="hidden" id="modalrequest_number" name="modalrequest_number" value="">
                                        <button type="submit" id="btn-upload-review" class="btn btn-md btn-primary"><span id="text-upload-review"> Start Upload</span></button>
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

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modal-add-layer">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="justify-between gx-5 mb-1">
                    <div>
                        <h6 class="modal-title text-primary">Add Approval Layer</h6>
                    </div>
                </div>
                <form id="form-add-layer">
                    <div class="form-group">
                        <label class="form-label">Select user email</label>
                        <div class="form-control-wrap">
                            <select class="form-select form-control form-control-lg" id="select_add_layer" name="emailuser" data-search="on">
                                <?= $userList; ?>
                            </select>
                        </div>
                    </div>
                    <div class="align-center justify-between mt-3">
                        <ul class="btn-toolbar g-1">
                            <input type="hidden" id="req_id_add_layer" name="req_id_add_layer" value="">
                            <li><a data-dismiss="modal" class="btn btn-dim btn-danger">Cancel</a></li>
                            <li><button type="submit" class="btn btn-md btn-primary"><span id="text-add-layer"> Save</span></button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modal-change-layer">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="justify-between gx-5 mb-1">
                    <div>
                        <h6 class="modal-title text-primary">Change Approval Layer</h6>
                    </div>
                </div>
                <form id="form-change-layer">
                    <div class="form-group">
                        <label class="form-label">Select user email</label>
                        <div class="form-control-wrap">
                            <select class="form-select form-control form-control-lg" id="select_change_layer" name="email_user" data-search="on">
                                <?= $userList; ?>
                            </select>
                        </div>
                    </div>
                    <div class="align-center justify-between mt-3">
                        <ul class="btn-toolbar g-1">
                            <input type="hidden" id="req_id_change_layer" name="req_id_change_layer" value="">
                            <input type="hidden" id="app_id_change_layer" name="app_id_change_layer" value="">
                            <li><a data-dismiss="modal" class="btn btn-dim btn-danger">Cancel</a></li>
                            <li><button type="submit" class="btn btn-md btn-primary"><span id="text-change-layer"> Save</span></button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>