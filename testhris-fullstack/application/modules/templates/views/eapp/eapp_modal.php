<!-- Create Request Modal -->
<div class="modal fade" tabindex="-1" id="create-request" role="dialog">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="form-cat">Select Form</label>
                    <select class="form-select required" data-search="on" data-msg="Required" id="formType" name="formType" required>
                        <?= $formType; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <button id="create_step_one" name="create_step_one" class="btn btn-md btn-primary textCreateForm">
                        Proceed
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Aging Modal -->
<div class="modal fade" tabindex="-1" id="modalAging">
    <div class="modal-dialog modal-dialog-top modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-header modal-header-sm">
                <h4 class="title">Approval Aging</h5>
            </div>

            <div class="modal-body modal-body-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Request Tracking Modal -->
<div class="modal fade" tabindex="-1" id="modalTracking">
    <div class="modal-dialog modal-dialog-top modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-header modal-header-sm">
                <h4 class="title">Tracking</h5>
            </div>

            <div class="modal-body modal-body-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- History Modal -->
<div class="modal fade" tabindex="-1" id="modalHistory">
    <div class="modal-dialog modal-dialog-top modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-header modal-header-sm">
                <h4 class="title">History</h5>
            </div>

            <div class="modal-body modal-body-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Request Notes -->
<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modalAddNotes">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Notes</h5>
                    </div>
                    <div class="card-content">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <textarea class="form-control form-control-sm" id="request-notes" name="request-notes" placeholder="Write your notes here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sp-package-action">
                    <a href="#" class="btn btn-dim btn-danger" data-dismiss="modal" data-toggle="modal">Cancel</a>
                    <button type="button" onclick="return save_request_notes();" class="btn btn-md btn-primary"><span id="text-request-notes"> Save</span></button>
                </div>

            </div>
        </div>
    </div>
</div>