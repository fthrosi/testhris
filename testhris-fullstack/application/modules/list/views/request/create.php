<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="d-flex justify-content-center">

                    <div class="nk-block nk-block-xl">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="title nk-block-title">Create Approval Request</h4>
                                <div class="nk-block-des">
                                    <p>Just follow step by step.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="<?= base_url('list/request/saveForm'); ?>" method="post" enctype="multipart/form-data" id="formRequest" class="nk-wizard nk-wizard-simple is-alter form-validate">
                                    <div class="nk-wizard-head">
                                        <h5>Header Information</h5>
                                    </div>
                                    <div class="nk-wizard-content">
                                        <div class="row gy-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="formPurpose">Purpose <b class="text-danger">*</b></label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" data-msg="Required" class="form-control required" id="formPurpose" name="formPurpose" placeholder="Example: Need Approval for 2020 IBS Outing Event" required>
                                                    </div>
                                                </div>
                                            </div>
                                          <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="formType">Form Category <b class="text-danger">*</b></label>
                                                    <div class="form-control-wrap ">
                                                        <select class="form-control form-control-md " data-search="on" id="formType" name="formType" required>
                                                            <?= $formType; ?>
                                                        </select>
                                                        <input type="text" name="formCategory" id="formCategory">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="formNotes">Description <b class="text-danger">*</b></label>
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-md required" data-msg="Required" name="formNotes" id="formNotes" placeholder="Describe your request..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="additionalNotes">Additional Notes</label>
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-md" name="additionalNotes" id="additionalNotes" placeholder="Give your notes here... if any.."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tipe form -->
                                    <div class="nk-wizard-head">
                                        <h5>Request Details</h5>
                                    </div>
                                    <div class="nk-wizard-content">

                                        <!-- upload -->
                                        <div style="display: none;" id="formUpload">
                                            <div class="row gy-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="approvalFormScanned">Approval Form Scanned <b class="text-danger">*</b></label>
                                                        <a style="display: none" class="btn btn-sm btn-success" id="templateForm" href="" target="_blank">Download Form Template</a>
                                                        <div class="form-control-wrap">
                                                            <div class="custom-file">
                                                                <input type="file" name="approvalFormScanned" id="approvalFormScanned" required>
                                                                <label for="approvalFormScanned"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row gy-3">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="myId">Supporting Files [Photo, Word, Excel, PPT]</label>
                                                        <div class="form-control-wrap">
                                                            <div style="height: 200px; width:920px;" id="myId" class="dropzone"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- dedicated -->
                                        <div style="display: none;" id="formDedicated">
                                            <div class="nk-wizard-content" style="display: none;" id="form_AM">
                                                <div class="row gy-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                           <label>APPRROVAL MEMO</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="nk-wizard-content" style="display: none;" id="form_TSA">
                                                <div class="row gy-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                           <label>TOWER SITE APPROVAL (NEW BUILD)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="nk-wizard-content" style="display: none;" id="form_ABF">
                                                <div class="row gy-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                           <label>ADDITIONAL BUDGET FORM - TOWER</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="nk-wizard-content" style="display: none;" id="form_ABFFO">
                                                <div class="row gy-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                           <label>ADDITIONAL BUDGET FORM - FO</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- APPROVAL LAYER -->
                                    <div class="nk-wizard-head">
                                        <h5>Approval Layer</h5>
                                    </div>

                                    <div class="nk-wizard-content">
                                        <!-- manual-->
                                        <div style="display: none;" id="manual_layer">
                                            <div class="row gy-3">
                                                <div class="col-md-12">
                                                    <div class="card card-bordered card-full" style="width:920px;">
                                                        <div class="card-inner-group">
                                                            <div class="card-inner">
                                                                <div class="card-title-group">
                                                                    <div class="card-title">
                                                                        <h6 class="title">Select Approval Layer</h6>
                                                                    </div>
                                                                    <div class="card-tools">
                                                                        <button type="button" name="add" id="add" class="btn btn-primary">
                                                                            <span id="addLayerText" style="display: show;">Add</span>
                                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="loadLayerSpinner" style="display: none;"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="dynamic_field">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- matrix-->
                                        <div style="display: none;" id="matrix_layer">
                                            <div class="row gy-3">
                                                <div class="col-md-12">
                                                    <div class="card card-bordered card-full" style="width:920px;">
                                                        <div class="card-inner-group">
                                                            <div class="card-inner">
                                                                <div class="card-title-group">
                                                                    <div class="card-title">
                                                                        <h6 class="title">Approval Matrix</h6>
                                                                    </div>
                                                                    <div class="card-tools">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="matrix_approval">
                                                            </div>
                                                        </div>
                                                    </div>
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
    </div>
</div>