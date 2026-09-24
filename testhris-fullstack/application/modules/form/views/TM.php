<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li class="mr-n1 d-lg-none">
                <a href="#" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em
                        class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
</div>
<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        <div class="tab-pane active"  id="time_management">
            <div class="card-inner">
                <h4 class="title">Your time off information</h4>
                
                <!-- //REMOVE LATER -->
                <!-- <input type="hidden" id="req_to_nik" name="req_to_nik" value="<?= $this->session->userdata('nik'); ?>"> -->
 
                <div class="pt-3 pb-3 d-flex justify-content-between">
                    <div class="d-inline-flex">
                        <?php if (decrypt($this->session->userdata('employee_subgroup')) == 'Outsource'){ ?>
                            <!-- <button class="btn btn-secondary mr-1" disabled>REQUEST TIME OFF</button>
                            <button class="btn btn-secondary mr-1" disabled>REQUEST ATTENDANCE</button> -->
                            <a class="btn btn-dim btn-primary mr-1" data-toggle="modal" data-target="#modalRequestTimeOff" data-offset="-4,0">REQUEST TIME OFF
                            </a>
                            <a class="btn btn-dim btn-primary mr-1" data-toggle="modal" data-target="#modalRequestAttendance" data-offset="-4,0">REQUEST ATTENDANCE
                            </a>
                        <?php } else {?>
                            <a class="btn btn-dim btn-primary mr-1" data-toggle="modal" data-target="#modalRequestTimeOff" data-offset="-4,0">REQUEST TIME OFF
                            </a>
                            <a class="btn btn-dim btn-primary mr-1" data-toggle="modal" data-target="#modalRequestAttendance" data-offset="-4,0">REQUEST ATTENDANCE
                            </a>
                        <?php }?>
                        <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){ ?>
                            <a class="btn btn-dim btn-secondary mr-1" data-toggle="modal" data-target="#modalManageEmployeeTO" data-offset="-4,0">MANAGE EMPLOYEE TIME OFF
                            </a>
                        <?php } ?>
                    </div>
                    <!-- <div class="d-inline-flex">
                        <a class="btn btn-dim btn-success" href="<?= site_url('report/attendance'); ?>">ATTENDANCE REPORT</a>
                    </div> -->
                </div>
                <div class="pb-3 d-inline-flex">
                    <a class="btn btn-dim btn-success mr-1" data-toggle="modal" data-target="#modalShiftSchedule" data-offset="-4,0" style="display:none;" >SUBMIT SHIFT SCHEDULE
                    </a>
                    <a class="btn btn-dim btn-success mr-1" data-toggle="modal" data-target="#modalDOSchedule" data-offset="-4,0" style="display:none;" >SUBMIT HOLIDAY ASSIGNMENT
                    </a>
                </div>
                <div class="d-flex justify-content-center pb-1" id="balance_log">
                    <h5 data-toggle="modal" data-target="#modalBalanceLog">CUTI TAHUNAN <em class="icon ni ni-view-row-wd"></em> </h5>
                </div>
                <div class="d-flex justify-content-center" id="sisa">
                    <h2 class="title">0</h2>
                    <h5 class="ml-1">days</h5>
                </div>

                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tm_req" role="tab" data-toggle="tab"><em class="icon ni ni-clock"></em><span>Time Off Request</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sch_req" role="tab" data-toggle="tab"><em class="icon ni ni-list-thumb"></em><span>Shift Schedule Request</span></a>
                    </li>
                    <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '5' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#hr_req" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>HR Adjustment Request</span></a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane table-responsive active" id="tm_req">
                        <table class="nowrap table request_time_off-table table-striped" id="table_request_time_off" data-ajaxsource="<?= site_url('form/request_table'); ?>">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Request Number</th>
                                    <th>Time-Off Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane table-responsive" id="sch_req">
                        <table class="nowrap table request_adjustment-table table-striped" id="table_schedule_request" data-ajaxsource="<?= site_url('form/schedule_request_table'); ?>">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Request Number</th>
                                    <th>Schedule Type</th>
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
                <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '5' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){ ?>
                    <div class="tab-pane table-responsive" id="hr_req">
                        <table class="nowrap table request_adjustment-table table-striped" id="table_request_adjustment" data-ajaxsource="<?= site_url('form/hr_request_table'); ?>">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Request Number</th>
                                    <th>Adjustment Type</th>
                                    <th>Effective Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                </div>
                <br>
                <hr>
                <br>
            </div>
        </div>
    </div>
</div>
</div>

<!-- //////////////////////////////////////////Modal//////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalRequestTimeOff">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Request Time-Off</h5>
                <form action="#" class="pt-2 form-validate is-alter" id="form_time_off">
                    <div class="row gy-3 gx-gs">
                        <div class="col-9">
                            <div class="form-group">
                                <label class="form-label">Time-Off Type</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="time_off_type" id="time_off_type">
                                        <option value=" " selected id="TO">  </option>
                                        
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Code</label>   
                                <div class="form-control-wrap kode_time_off">        
                                    <select class="form-select" name="time_off_code" id="time_off_code" disabled>
                                        <option value=" "  selected id="kodeTO"> </option>
                                        
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group" id="jenis_cuti" hidden>
                                <label class="form-label">Tipe Cuti</label>
                                <div class="swal2-radio">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioCutiFull" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="radioCutiFull">Cuti Tahunan Full</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioCutiHalf" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="radioCutiHalf">Cuti Tahunan Half-day</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                            <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" readonly class="form-control date-picker" name="start_date_request_time_off" id="start_date_request_time_off">    
                                    </div>    
                                    <!-- <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div> -->
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" readonly class="form-control date-picker" name="end_date_request_time_off" id="end_date_request_time_off">    
                                    </div>    
                                    <!-- <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div> -->
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group" id="waktu" hidden>
                                    <div class="form-control-wrap" id="waktuMasuk" hidden>    
                                        <label class="form-label">Waktu Masuk</label>     
                                        <input type="time" class="form-control" name="request_masuk" id="request_masuk">  
                                        <div class="form-note">Time format <code>HH:mm</code>
                                        </div>  
                                    </div>  
                                    <div class="form-control-wrap" id="waktuKeluar" hidden>  
                                        <label class="form-label">Waktu Keluar</label>       
                                        <input type="time" class="form-control" name="request_keluar" id="request_keluar">      
                                        <div class="form-note">Time format <code>HH:mm</code>
                                        </div>
                                    </div>  
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group" id="upload" hidden>
                                <label class="form-label">Upload File</label>
                                <div class="form-control-wrap">        
                                    <div class="custom-file">  
                                        <input type="file" class="custom-file-input" name="upload_file" id="upload_file"> 
                                        <label class="custom-file-label" for="upload_file">Choose file</label>
                                        <div class="form-note">Gunakan <code>.zip/.rar/.7zip</code> Jika File lebih dari 1
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" placeholder="Deskripsi Time-Off (Maksimum input karakter: 255)" name="notes_time_off" id="notes_time_off" maxlength="255" onkeyup="inputCount()"></textarea>
                                <p id="counter">255/255</p>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary request_time_off" id="request_time_off">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalBalanceLog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Balance Log</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="card card-preview">
                        <div class="tab-content">
                            
                                <div class="card-inner">
                                <table class="nowrap table log_balance-table table-striped" id="table_balance_log">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Created At</th>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total</th>
                                            <th>Change Log</th>
                                            <th>Status</th>
                                            <th>Documents</th>
                                            <th>Updated At</th>
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

<div class="modal fade" id="modalManageEmployeeTO">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Manage Employee Time-Off</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-9">
                            <div class="form-group">
                                <label class="form-label">Module</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="management_module" id="management_module">
                                        <option value="Adjustment CUTI TAHUNAN" id="ACT" selected>ADJUST CUTI TAHUNAN</option>
                                        
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Code</label>   
                                <div class="form-control-wrap kode_modul">        
                                    <select class="form-select" name="module_code" id="module_code" disabled>
                                        <option value="ACT" id="kodeACT" selected>ACT</option>
                                        
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id='emp_multi'>
                            <div class="form-group">
                                <label class="form-label">Employee</label>   
                                <div class="form-control-wrap employee">        
                                    <select class="form-select" name="employee_name[]" id="employee_name" multiple="multiple">

                                    </select>    
                                </div>
                            </div>
                        </div> 
                        <div class="col-7" id='emp_single' hidden>
                            <div class="form-group">
                                <label class="form-label">Employee</label>   
                                <div class="form-control-wrap employee">        
                                    <select class="form-select" name="employee_name_single" id="employee_name_single">
                                        <option value=" " id="emp1" selected></option>

                                    </select>    
                                </div>
                            </div>
                        </div> 
                        <div class="col-5" id='ctab_date' hidden>
                        <div class="form-group">
                                <label class="form-label">Date</label>   
                                <div class="form-control-wrap employee">        
                                    <select class="form-select" name="adj_ctab" id="adj_ctab">

                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group" id="adjustment_type">
                                <label class="form-label">Adjustment Type</label>
                                <div class="swal2-radio">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioPlus" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="radioPlus">+</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioMinus" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="radioMinus">-</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5" id='adj_month' hidden>
                            <div class="form-group">
                                <label class="form-label">Month</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="adj_pg_month" id="adj_pg_month">
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
                        <div class="col-4" id='adj_year' hidden>
                            <div class="form-group">
                                <label class="form-label">Year</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="adj_pg_year" id="adj_pg_year">

                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-3" id='adj_amount'>
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="amount" id="amount"> 
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary adjust_employee_to" id="adjust_employee_to">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalRequestAttendance">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
             <div id="loading-schedule"
                    style="display:none;
                            position:absolute;
                            top:0; left:0;
                            width:100%; height:100%;
                            background:rgba(255,255,255,0.7);
                            z-index:9999;
                            text-align:center;
                            padding-top:20%;">
                    Loading schedule...
                </div>
            <div class="modal-body modal-body-md">
                <h5 class="title">Request Attendance</h5>
                <form action="#" class="pt-2 form-validate is-alter" id="form_req_absent">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="req_absent_date" id="req_absent_date">
                                        
                                    </select>    
                                </div>
                                <?php if($check_ctab >= 3){ ?>
                                    <div class="form-note text-danger">You have reached request limit in <?= (date('d') <= 10) ? date('F', strtotime('first day of previous month')) : date('F'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Schedule In</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="req_absent_schedule_in" id="req_absent_schedule_in" disabled> 
                                </div>
                            </div>  
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Schedule Out</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="req_absent_schedule_out" id="req_absent_schedule_out" disabled> 
                                </div>
                            </div>  
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Clock In</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" name="req_absent_clock_in" id="req_absent_clock_in"> 
                                </div>
                            </div>  
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Clock Out</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" name="req_absent_clock_out" id="req_absent_clock_out"> 
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="req_absent_is_status" name="req_absent_is_status" value="">
                        <!-- <div class="col-12">
                            <div class="form-group" id="upload">
                                <label class="form-label">Upload File</label>
                                <div class="form-control-wrap">        
                                    <div class="custom-file">  
                                        <input type="file" class="custom-file-input" name="req_absent_upload_file" id="req_absent_upload_file"> 
                                        <label class="custom-file-label" for="req_absent_upload_file">Choose file</label>
                                        <div class="form-note">Gunakan <code>.zip/.rar/.7zip</code> Jika File lebih dari 1
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Digital Chronology</label>
                                <textarea class="form-control" placeholder="Sertakan Alasan: (Maksimum input karakter: 255)" name="req_absent_notes" id="req_absent_notes" maxlength="255"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary request_absent" id="request_absent">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <div id="loading-schedule" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:#00000050; color:#fff; text-align:center; padding-top:20%;">
  Loading...
</div> -->

<!-- ////////////////////////////////////////// TIME MANAGEMENT 2.0 ////////////////////////////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalShiftSchedule">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Check Shift Schedule</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <label class="form-label">Start Date</label>    
                            <div class="form-control-wrap">        
                                <input type="text" class="form-control date-picker" name="start_date_submit_shift" id="start_date_submit_shift">    
                            </div>    
                            <div class="form-note">Date format <code>mm/dd/yyyy</code>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">End Date</label>    
                            <div class="form-control-wrap">        
                                <input type="text" class="form-control date-picker" name="end_date_submit_shift" id="end_date_submit_shift">    
                            </div>    
                            <div class="form-note">Date format <code>mm/dd/yyyy</code>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary submit_shift_schedule" id="submit_shift_schedule">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalDOSchedule">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Check Holiday Schedule</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <label class="form-label">Available Date</label>
                            <div class="form-control-wrap avail_date">        
                                <select class="form-select" name="date_submit_dayoff[]" id="date_submit_dayoff" multiple="multiple">

                                </select>    
                            </div> 
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary submit_holiday_schedule" id="submit_holiday_schedule">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////// TIME MANAGEMENT 2.0 ////////////////////////////////////////////////////////////// -->