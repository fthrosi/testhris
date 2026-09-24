<style>
.sch {
    color: #12b62d; 
    font-weight: 500;
}

.act {
    color: #f14e8d; 
    font-weight: bold;
}
</style>
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
<!-- TIME MANAGEMENT 2.0 -->
<?php 
    if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '5' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){
        $is_head = false;
        $is_hr = true;
        $company = '1200';
    } else {
        $company = $this->session->userdata('company_code');
        $is_hr = false;
    }
?>
<!-- /////////////////// -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        <div class="tab-pane active"  id="attendance">
            <div class="card-inner">
                <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '5' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){ ?>
                <div class="d-flex justify-content-center pb-3">
                    <table cellpadding="8" style="font-size:100%; width:100%; text-align:center; border: 3px;" class="table">

                        <!-- HEADER -->
                        <tr>
                            <th>CLOCK IN</th>
                            <th>ON TIME</th>
                            <th>CUTI</th>
                            <th>ABSEN IN</th>
                            <th>WORKING DAYS</th>
                        </tr>

                        <!-- DATA -->
                        <tr>
                            <td>
                                <span id="hadir_in">0</span>
                                <!-- <small>(<span id="hadirin_percent">0</span>%)</small> -->
                            </td>
                            <td>
                                <span id="on_time">0</span>
                                <!-- <small>(<span id="ontime_percent">0</span>%)</small> -->
                            </td>
                            <td>
                                <span id="cuti">0</span>
                                <!-- <small>(<span id="cuti_percent">0</span>%)</small> -->
                            </td>
                            <td>
                                <span id="tidak_hadir_in">0</span>
                                <!-- <small>(<span id="tidakhadirin_percent">0</span>%)</small> -->
                            </td>
                            <td id="hari_kerja">
                                <span class="sch" id="hari_kerja_sch">0</span>  Days (sch) |
                                <span class="act" id="hari_kerja_act">0</span> Days (act)
                            </td>
                        </tr>

                        <!-- HEADER 2 -->
                        <tr>
                            <th>CLOCK OUT</th>
                            <th>LATE IN</th>
                            <th>SAKIT</th>
                            <th>ABSEN OUT</th>
                            <th>WORKING HOURS</th>
                        </tr>

                        <!-- DATA 2 -->
                        <tr>
                            <td>
                                <span id="hadir_out">0</span>
                                <!-- <small>(<span id="hadirout_percent">0</span>%)</small> -->
                            </td>
                            <td>
                                <span id="telat">0</span>
                                <!-- <small>(<span id="telat_percent">0</span>%)</small> -->
                            </td>
                            <td>
                                <span id="sakit">0</span>
                                <!-- <small>(<span id="sakit_percent">0</span>%)</small> -->
                            </td>
                            <td>
                                <span id="tidak_hadir_out">0</span>
                                <!-- <small>(<span id="tidakhadirout_percent">0</span>%)</small> -->
                            </td>
                            <td id="jam_kerja">
                                <span class="sch" id="jam_kerja_sch">0.00</span> Hours (sch) |
                                <span class="act" id="jam_kerja_act">0.00</span> Hours (act)
                            </td>
                        </tr>

                    </table>
                </div>
                <?php } else { ?>
                <div class="d-flex justify-content-center pb-3">
                    <table cellpadding="8" style="font-size:100%; width:100%; text-align:center; border: 3px;" class="table">

                        <!-- HEADER -->
                        <tr>
                            <th>CLOCK IN</th>
                            <th>ON TIME</th>
                            <th>CUTI</th>
                            <th>ABSEN IN</th>
                            <th>WORKING DAYS</th>
                        </tr>

                        <!-- DATA -->
                        <tr>
                            <td id="hadir_in">0</td>
                            <td id="on_time">0</td>
                            <td id="cuti">0</td>
                            <td id="tidak_hadir_in">0</td>
                            <td id="hari_kerja">
                                <span class="sch" id="hari_kerja_sch">0</span>  Days (sch) |
                                <span class="act" id="hari_kerja_act">0</span> Days (act)
                            </td>
                        </tr>

                        <!-- HEADER 2 -->
                        <tr>
                            <th>CLOCK OUT</th>
                            <th>LATE IN</th>
                            <th>SAKIT</th>
                            <th>ABSEN OUT</th>
                            <th>WORKING HOURS</th>
                        </tr>

                        <!-- DATA 2 -->
                        <tr>
                            <td id="hadir_out">0</td>
                            <td id="telat">0</td>
                            <td id="sakit">0</td>
                            <td id="tidak_hadir_out">0</td>
                            <td id="jam_kerja">
                                <span class="sch" id="jam_kerja_sch">0.00</span> Hours (sch) |
                                <span class="act" id="jam_kerja_act">0.00</span> Hours (act)
                            </td>
                        </tr>

                    </table>
                </div>
                <?php } ?>

                <div class="pb-3 d-flex justify-content-center">
                    <a class="btn btn-dim btn-primary" data-toggle="modal" data-target="#modalAdvancedSearch" data-offset="-4,0">Advanced Search
                    <em class="icon ni ni-search pl-1"></em>
                    </a>

                    <!-- TIME MANAGEMENT 2.0 -->
                    <?php if ($is_head == true){ ?>
                        <div class="pl-3">
                            <a class="btn btn-dim btn-secondary" href="<?= site_url('report/tm_report_head'); ?>">Employee's Leave Balance Report
                            <em class="icon ni ni-chevron-right pl-1"></em>
                            </a>
                        </div>
                    <?php } ?>
                    <!-- /////////////////// -->
                </div>

                <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '5' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){ ?>
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" onClick="company_select('1200')" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>IBSW</span></a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#" onClick="company_select('2000')" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>IPM</span></a>
                    </li> -->
                </ul>
                <?php } ?>

                <input type="hidden" id="attendance_company" name="attendance_company" value="<?= $company ?>">
                <input type="hidden" id="attendance_head" name="attendance_head" value="<?= $is_head ?>">
                <input type="hidden" id="attendance_hr" name="attendance_hr" value="<?= $is_hr ?>">
                <input type="hidden" id="attendance_nik" name="attendance_nik" value="<?= $this->session->userdata('nik') ?>">
                <input type="hidden" id="attendance_dept" name="attendance_dept" value="<?= decrypt($this->session->userdata('department')) ?>">

                <!-- <table class="nowrap table attendance-table table-striped" id="table_attendance" data-ajaxsource="<?= site_url('report/attendance_table'); ?>"> -->
                <table class="nowrap table table-responsive r_attendance-table table-striped" id="table_attendance">
                    <thead>
                        <tr> <!-- TIME MANAGEMENT 2.0 -->
                            <?php if ($this->session->userdata('access_level') == '7' || $this->session->userdata('access_employee') == '12'){ ?>
                                <th>Action</th>
                            <?php } else { ?>
                                <th> </th>
                            <?php } ?> 
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Personnel Area</th>
                            <th>Personnel Subarea</th>
                            <th>Date</th>
                            <th>Schedule</th>
                            <th>Schedule In</th>
                            <th>Schedule Out</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Working Hours</th>
                            <th>Attendance Code</th>
                            <th>Time Off Code</th>
                            <th>Notes</th>
                            <th>Office In</th>
                            <th>Check In Location</th>
                            <th>Coordinates In</th>
                            <th>DMS In</th>
                            <th>Office Out</th>
                            <th>Check Out Location</th>
                            <th>Coordinates Out</th>
                            <th>DMS Out</th>
                        </tr> <!-- ////////////////// -->
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <div>
                    <h6 class="title">Legends</h6>
                    <span class="dot dot-lg sq" data-bg="#4DFF65"></span>
                    <span>Office Area</span>
                    <span class="dot dot-lg sq" data-bg="#FF4D4D"></span>
                    <span>Non Office Area</span>
                </div>
                <hr>
                <br>
            </div>
        </div>
    </div>
</div>
</div>

<!-- ///////////////////////////////////////////////////// Modal /////////////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalAdvancedSearch">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Advanced Search</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Employee ID</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="search_employee_id" id="search_employee_id"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Employee Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="search_employee_name" id="search_employee_name"> 
                                </div>
                            </div>
                        </div> -->
                        <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '5' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7' || $is_head == true){ ?> <!-- TIME MANAGEMENT 2.0 -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Employee</label>   
                                <div class="form-control-wrap employee">        
                                    <select class="form-select" name="employee_name[]" id="search_employee_names" multiple="multiple">

                                    </select>    
                                </div>
                            </div>
                        </div> 
                        <?php } else { ?>
                        <input type="hidden" id="check_access_level" name="check_access_level" value="<?php echo $this->session->userdata('nik') ?>">
                        <?php } ?>

                        <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '5' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){ ?>
                        
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Directorate</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="search_dir_names" id="search_dir_names">
                                        <option value=""></option>
                                    </select>    
                                </div>
                            </div>
                        </div> 
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Division</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="search_div_names" id="search_div_names">
                                        <option value=""></option>
                                    </select>    
                                </div>
                            </div>
                        </div> 
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Department</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="search_dept_names" id="search_dept_names">
                                        <option value=""></option>
                                    </select>    
                                </div>
                                <div class="form-note">Note: <code>Filter direktorat dan divisi hanya dapat mencari data dalam jangkauan satu bulan.</code>
                                </div>
                            </div>
                        </div> 
                        <?php } ?>

                        <?php if ($is_head == true){ ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Department</label>   
                                <div class="form-control-wrap employee">        
                                    <select class="form-select" name="department[]" id="search_employee_department" multiple="multiple">

                                    </select>    
                                </div>
                            </div>
                        </div> 
                        <?php } ?>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="search_start_date" id="search_start_date" autocomplete="off">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="search_end_date" id="search_end_date" autocomplete="off" disabled>    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary advance_search" id="advance_search">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////Modal Ubah///////////////////////////////////// -->

<div class="modal fade" role="dialog" id="modalEditAttendance">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Employee Attendance</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_emp_atd" id="id_edit_emp_atd">
                    <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" name="nik_edit_emp_atd" id="nik_edit_emp_atd" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="nama_edit_emp_atd" id="nama_edit_emp_atd" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" name="date_edit_emp_atd" id="date_edit_emp_atd" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Schedule</label>
                                <input type="text" class="form-control" name="schedule_edit_emp_atd" id="schedule_edit_emp_atd" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Check In</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" name="clock_in_emp_atd" id="clock_in_emp_atd"> 
                                </div>
                            </div>  
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Check Out</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" name="clock_out_emp_atd" id="clock_out_emp_atd"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Check In Location</label>
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="clock_in_loc_emp_atd" id="clock_in_loc_emp_atd">
                                        <option value="empty"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <input type="hidden" id="lat_in_emp_atd" name="lat_in_emp_atd" value="">
                        <input type="hidden" id="long_in_emp_atd" name="long_in_emp_atd" value=""> -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Check Out Location</label>
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="clock_out_loc_emp_atd" id="clock_out_loc_emp_atd">
                                        <option value="empty"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <input type="hidden" id="lat_out_emp_atd" name="lat_out_emp_atd" value="">
                        <input type="hidden" id="long_out_emp_atd" name="long_out_emp_atd" value=""> -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Attendance Code</label>
                                <div class="form-control-wrap atd_code">        
                                    <select class="form-select" name="atd_code_emp_atd" id="atd_code_emp_atd" disabled>
                                        <option value="empty"></option>
                                        <option value="H">H</option>
                                        <option value="CTAB">CTAB</option>
                                        <option value="HCTAB">HCTAB</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Time Off Code</label>
                                <div class="form-control-wrap to_code">        
                                    <select class="form-select" name="to_code_emp_atd" id="to_code_emp_atd" disabled>
                                        <option value="empty"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Working Hour</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="working_hour_emp_atd_t" id="working_hour_emp_atd_t" disabled> 
                                    <input type="hidden" class="form-control" name="working_hour_emp_atd_d" id="working_hour_emp_atd_d" disabled> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" placeholder="Deskripsi Perubahan" name="notes_edit_emp_atd" id="notes_edit_emp_atd"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_emp_atd" id="ubah_emp_atd">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- START CR 3 TM -->
<div class="modal fade" tabindex="-1" id="modalRequestLocation">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Request Attendance Location Masuk</h5>
                <form action="#" class="pt-2 form-validate is-alter" id="form_req_loc">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>   
                                <div class="form-control-wrap">        
                                <input type="text" class="form-control date-picker" name="date_req_loc" id="date_req_loc" disabled>    
                                </div>
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Bukti Lokasi Absen Masuk</label>
                                <div class="form-control-wrap">        
                                    <div class="custom-file">  
                                        <input type="hidden" id="req_loc_in" name="req_loc_in" value="0">
                                        <input type="file" class="custom-file-input" name="req_loc_in_upload_file" id="req_loc_in_upload_file"> 
                                        <label class="custom-file-label" for="req_loc_in_upload_file">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Bukti Lokasi Absen Keluar</label>
                                <div class="form-control-wrap">        
                                    <div class="custom-file">  
                                        <input type="hidden" id="req_loc_out" name="req_loc_out" value="0">
                                        <input type="file" class="custom-file-input" name="req_loc_out_upload_file" id="req_loc_out_upload_file"> 
                                        <label class="custom-file-label" for="req_loc_out_upload_file">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary request_location" id="request_location">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END CR 3 TM -->