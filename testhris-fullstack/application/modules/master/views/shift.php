<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#shift" data-toggle="tab"><em class="icon ni ni-list-thumb-fill"></em><span>Shift</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        <div class="tab-pane table-responsive active" id="shift">
            <div class="card-inner">
                <div class="btn-group">
                    <h4>Upload Shift Pattern</h4>
                </div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalUploadShift" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> New Schedule
                    </a>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalGetWorkSchedule" data-offset="-4,0"><em class="icon ni ni-help"></em>DWS Information
                    </a>
                </span>
                <hr>
                <table class="nowrap table request_time_off-table table-striped" id="table_upload_shift" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/upload_shift'); ?>">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Request Number</th>
                            <th>Periode</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
            </div>
            <div class="card-inner">
                <div class="btn-group">
                    <h4>Employeee Shift Schedule</h4>
                </div>
                <hr>
                <table class="nowrap table employee_shift-table table-striped" id="table_employee_shift" data-ajaxsource="<?= site_url('master/employee_shift_schedule'); ?>">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
            </div>
        </div>
    </div>
</div>
</div>


<!-- //////////////////////////////////////////// MODAL //////////////////////////////////////////// -->
<div class="modal fade" tabindex="-1" id="modalDetailSchedule">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h4 class="title" id='nama_detail_schedule'></h4>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="card card-preview">
                        <div class="pl-4 pt-1 d-flex">
                            <div class="pl-0 col-2">
                                <div class="form-group">
                                    <label class="form-label">Month</label>   
                                    <div class="form-control-wrap">        
                                        <select class="form-select" name="detail_schedule_month" id="detail_schedule_month">
                                            <option value="01" selected>Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>   
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label class="form-label">Year</label>   
                                    <div class="form-control-wrap">        
                                        <select class="form-select" name="detail_schedule_year" id="detail_schedule_year">
                                            <option value=""></option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="detail_schedule_nik" name="detail_schedule_nik" value="">
                        </div>
                        <div class="tab-content">
                            <div class="card-inner">
                                <table class="nowrap table detail_shift_schedule-table table-striped" id="table_detail_shift_schedule">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Full Name</th>
                                            <th>Date</th>
                                            <th>Schedule</th>
                                            <th>Schedule In</th>
                                            <th>Schedule Out</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Attendance Code</th>
                                            <th>Time Off Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalUploadShift">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Upload Pattern Shift</h5>
                <form action="#" class="pt-2 form-validate is-alter" id="form_pattern_shift">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Month</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="upload_shift_schedule_month" id="upload_shift_schedule_month">
                                        <option value="01" selected>Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Year</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="upload_shift_schedule_year" id="upload_shift_schedule_year">
                                        <option value=""></option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group" id="upload_schedule">
                                <label class="form-label">Upload File</label>
                                <div class="form-control-wrap">        
                                    <div class="custom-file">  
                                        <input type="file" class="custom-file-input" name="upload_schedule_file" id="upload_schedule_file"> 
                                        <label class="custom-file-label" for="upload_schedule_file">Choose file</label>
                                        <div class="form-note"><code>template file upload:</code> <a href="./assets/documents/master_documents/SHIFT_PATTERN_MONTH_YEAR.csv">SHIFT_PATTERN_MONTH_YEAR.csv</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary assign_shift_schedule_pattern" id="assign_shift_schedule_pattern">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalGetWorkSchedule">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h4 class="title" id='nama_detail_schedule'></h4>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="card card-preview">
                        <div class="tab-content">
                            <div class="card-inner">
                                <h4>DWS and Time Off Code Information</h4>
                                <table class="nowrap table dws_to_info-table table-striped" id="table_dws_to_code"  data-ajaxsource="<?= site_url('master/getDwsTOCode'); ?>">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Schedule In</th>
                                            <th>Schedule Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>