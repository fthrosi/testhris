<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#time_off" data-toggle="tab"><em class="icon ni ni-calendar-fill"></em><span>Set Up Schedule</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        
            <div class="tab-pane active"  id="time_management">
            <div class="card-inner">
                
            <div class="btn-group">
						<h4>Type of Schedule</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahSchedule" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Schedule
                    </a>
                </span>
                <span style="float:right">
                    <a class="btn btn-dim btn-primary" data-toggle="modal" data-target="#modalUploadPattern" data-offset="-4,0">Upload Pattern Shift</a>
                    &nbsp;&nbsp;
                    <a class="btn btn-dim btn-primary" data-toggle="modal" data-target="#modalAssignSchedule" data-offset="-4,0">Assign Work Schedule</a>
                </span>
                <br>
                <br>
                <table class="nowrap table schedule-table table-striped" id="table_schedule" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/schedule/'); ?>">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Company Name</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Schedule In</th>
                            <th>Schedule Out</th>
                            <th>Shift Type</th>
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
            </div>
    </div>
</div>
</div>

<!-- //////////////////////////////////////////Modal//////////////////////////////////// -->

<!-- /////////////////////////////////////////////Modal Tambah Pagu Rawat Jalan////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahSchedule">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Schedule</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Schedule</label>
                                <input type="text" class="form-control" placeholder="Nama Schedule (Maks. 99)" name="nama_tambah_schedule" id="nama_tambah_schedule" maxlength="99">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Schedule</label>
                                <input type="text" class="form-control" placeholder="Kode Schedule (Maks. 10)" name="kode_tambah_schedule" id="kode_tambah_schedule" maxlength="10">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Perusahaan</label>   
                                <div class="form-control-wrap company_name">        
                                    <select class="form-select" name="company_name_tambah_time_off" id="company_name_tambah_time_off">
                                        <option value="PT. Infrastruktur Bisnis Sejahtera" id="IBS" selected>PT. Infrastruktur Bisnis Sejahtera</option>
                                        <option value="PT. Teknovatus Solusi Sejahtera" id="TSS">PT. Teknovatus Solusi Sejahtera</option>
                                        <option value="PT. Bintang Timur Persada" id="BTP">PT. Bintang Timur Persada</option>
                                        <option value="PT. Tekno Infrastruktur Sukses" id="TIS">PT. Tekno Infrastruktur Sukses</option>
                                        <option value="PT. Integra Putra Mandiri" id="IPM">PT. Integra Putra Mandiri</option>
                                        <option value="PT. Elang Nusantara Air" id="ENA">PT. Elang Nusantara Air</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Perusahaan</label>   
                                <div class="form-control-wrap company_code">        
                                    <select class="form-select" name="company_code_tambah_time_off" id="company_code_tambah_time_off" disabled>
                                        <option value="1200" id="kodeIBS" selected>1200</option>
                                        <option value="1300" id="kodeTSS">1300</option>
                                        <option value="1700" id="kodeBTP">1700</option>
                                        <option value="1800" id="kodeTIS">1800</option>
                                        <option value="2000" id="kodeIPM">2000</option>
                                        <option value="2100" id="kodeENA">2100</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_tambah_schedule" id="start_date_tambah_schedule">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_tambah_schedule" id="end_date_tambah_schedule" disabled>    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Schedule In</label>    
                                    <div class="form-control-wrap">        
                                        <input type="time" step="1" class="form-control" name="tambah_schedule_in" id="tambah_schedule_in">    
                                    </div>    
                                    <div class="form-note">Time format <code>HH:mm</code>
                                    </div>
                                    <br>
                                    <label class="form-label">Schedule Out</label>    
                                    <div class="form-control-wrap">        
                                        <input type="time" step="1" class="form-control" name="tambah_schedule_out" id="tambah_schedule_out">    
                                    </div>    
                                    <div class="form-note">Time format <code>HH:mm</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Tipe Shift</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="shift_type_tambah_time_off" id="shift_type_tambah_time_off">
                                        <option value="-" selected>-</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_schedule" id="tambah_schedule">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////Modal Ubah///////////////////////////////////// -->

<div class="modal fade" role="dialog" id="modalEditSchedule">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Schedule</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_schedule" id="id_edit_schedule">
                    <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Schedule</label>
                                <input type="text" class="form-control" placeholder="Nama Schedule (Maks. 99)" name="nama_edit_schedule" id="nama_edit_schedule" maxlength="99">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Schedule</label>
                                <input type="text" class="form-control" placeholder="Kode Schedule (Maks. 5)" name="kode_edit_schedule" id="kode_edit_schedule" maxlength="5">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Perusahaan</label>   
                                <div class="form-control-wrap company_name_edit">        
                                    <select class="form-select" name="company_name_edit_time_off" id="company_name_edit_time_off" disabled>
                                        <option value="PT. Infrastruktur Bisnis Sejahtera" id="IBS" selected>PT. Infrastruktur Bisnis Sejahtera</option>
                                        <option value="PT. Teknovatus Solusi Sejahtera" id="TSS">PT. Teknovatus Solusi Sejahtera</option>
                                        <option value="PT. Bintang Timur Persada" id="BTP">PT. Bintang Timur Persada</option>
                                        <option value="PT. Tekno Infrastruktur Sukses" id="TIS">PT. Tekno Infrastruktur Sukses</option>
                                        <option value="PT. Integra Putra Mandiri" id="IPM">PT. Integra Putra Mandiri</option>
                                        <option value="PT. Elang Nusantara Air" id="ENA">PT. Elang Nusantara Air</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Perusahaan</label>   
                                <div class="form-control-wrap company_code_edit">        
                                    <select class="form-select" name="company_code_edit_time_off" id="company_code_edit_time_off" disabled>
                                        <option value="1200" id="kodeIBS" selected>1200</option>
                                        <option value="1300" id="kodeTSS">1300</option>
                                        <option value="1700" id="kodeBTP">1700</option>
                                        <option value="1800" id="kodeTIS">1800</option>
                                        <option value="2000" id="kodeIPM">2000</option>
                                        <option value="2100" id="kodeENA">2100</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_edit_schedule" id="start_date_edit_schedule">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_edit_schedule" id="end_date_edit_schedule" disabled>    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Schedule In</label>    
                                    <div class="form-control-wrap">        
                                        <input type="time" step="1" class="form-control" name="edit_schedule_in" id="edit_schedule_in">    
                                    </div>    
                                    <div class="form-note">Time format <code>hh:mm</code>
                                    </div>
                                    <br>
                                    <label class="form-label">Schedule Out</label>    
                                    <div class="form-control-wrap">        
                                        <input type="time" step="1" class="form-control" name="edit_schedule_out" id="edit_schedule_out">    
                                    </div>    
                                    <div class="form-note">Time format <code>hh:mm</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Tipe Shift</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="shift_type_edit_time_off" id="shift_type_edit_time_off">
                                        <option value="-" selected>-</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_schedule" id="ubah_schedule">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalUploadPattern">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Upload Pattern Shift</h5>
                <form action="#" class="pt-2 form-validate is-alter" id="form_pattern_shift">
                    <div class="row gy-3 gx-gs">
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
                                <button data-dismiss="modal" type="button" class="btn btn-primary assign_work_schedule_pattern" id="assign_work_schedule_pattern">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="modalAssignSchedule">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Assign Employee Work Schedule</h5>
                <form action="#" class="pt-2 form-validate is-alter" id='form_assign_schedule'>
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Action</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="assign_schedule_action" id="assign_schedule_action">
                                        <option value="single" selected>Single</option>
                                        <option value="multiple">Multiple</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6" id="schedule_emp_name">
                            <div class="form-group">
                                <label class="form-label">Employee Name</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" name="assign_schedule_employee_name" id="assign_schedule_employee_name">
                                        <option value=" " selected></option>
                                        
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-6" id="schedule_type">
                            <div class="form-group">
                                <label class="form-label">Work Schedule</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" name="assign_schedule_type" id="assign_schedule_type">
                                        
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-9" id="branch" hidden>
                            <div class="form-group">
                                <label class="form-label">Branch</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" name="assign_schedule_branch" id="assign_schedule_branch">
                                        
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-6" id="current_schedule" hidden>
                            <div class="form-group">
                                <label class="form-label">Current Schedule</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" name="assign_schedule_current" id="assign_schedule_current">
                                        
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-6" id="new_schedule" hidden>
                            <div class="form-group">
                                <label class="form-label">New Schedule</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" name="assign_schedule_new" id="assign_schedule_new">
                                        
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="assign_schedule_start_date" id="assign_schedule_start_date">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="assign_schedule_end_date" id="assign_schedule_end_date" disabled>    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary assign_work_schedule_single" id="assign_work_schedule_single">Assign</button>
                                <button data-dismiss="modal" type="button" class="btn btn-primary assign_work_schedule_multi" id="assign_work_schedule_multi" hidden>Assign</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>