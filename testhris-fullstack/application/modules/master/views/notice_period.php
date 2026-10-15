<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#question" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>Notice Period</span></a>
    </li>
</ul>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview responsive-table">
        <div class="tab-content">
                <div class="tab-pane table-responsive active" id="question">
                    <div class="card-inner">
                        <div class="btn-group">
                            <h4>DATA NOTICE PERIOD</h4>
                        </div>
                        <hr>
                        <span>
                            <a class="text-primary btn btn-icon btn-add-notice" data-toggle="modal" data-target="#modalNoticePeriod" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Add Notice Period
                            </a>
                        </span>
                        <br>
                        <table class="nowrap table period-table table-striped display" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Grade</th>
                                    <th>Time</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalNoticePeriod">
    <input type="hidden" id="edit_notice_id" name="edit_notice_id">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Notice Period</h5>
                <form action="#" id="form_notice_period" data-mode="add" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Grade</label>
                                <input required type="text" class="form-control" placeholder="grade" name="grade" id="grade_period">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Time</label>
                                <input required type="number" onwheel="this.blur()" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control" placeholder="Time Period" name="month" id="month_period">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input required type="text" class="form-control date-picker" name="start_date_period" id="start_date_period">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_period" id="end_date_period">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button type="button" class="btn btn-primary" id="save_notice_period">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>