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
        <div class="tab-pane active">
            <div class="card-inner">
                <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7'){ ?>
                <div class="d-flex justify-content-between">
                    <div class="d-inline-flex">
                        <!-- <div class="form-group pr-3">
                            <button id="create_employee_calendar" name="create_employee_calendar" class="btn btn-md btn-primary">
                                Generate Employee Calendar
                            </button>
                        </div> -->
                        <div class="form-group">
                            <a class="btn btn-dim btn-primary" data-toggle="modal" data-target="#modalAddHoliday" data-offset="-4,0">Add Holiday Calendar</a>
                            <!-- <button class="btn btn-secondary" disabled>Add Holiday Calendar</button> -->
                        </div>
                    </div>
                    <!-- <div class="d-inline-flex">
                        <div class="form-group">
                            <a class="btn btn-dim btn-primary" data-toggle="modal" data-target="#modalUploadPattern" data-offset="-4,0">Upload Pattern Shift</a>
                        </div>
                        <div class="form-group pl-3">
                            <a class="btn btn-dim btn-primary" data-toggle="modal" data-target="#modalAssignSchedule" data-offset="-4,0">Assign Work Schedule</a>
                        </div>
                    </div> -->
                </div>
                <hr class="pb-2">
                <?php } ?>
                <div id="calendar"></div>
                <br>
                <div>
                    <h6 class="title">Legends</h6>
                    <span class="dot dot-lg sq" data-bg="#f5cb25" style="background: rgb(249, 140, 69);"></span>
                    <span>Cuti</span>
                    <span class="dot dot-lg sq" data-bg="#21d952" style="background: rgb(156, 171, 255);"></span>
                    <span>Ulang Tahun</span>
                    <span class="dot dot-lg sq" data-bg="#eb1a1a" style="background: rgb(143, 234, 197);"></span>
                    <span>Libur Nasional</span>
                    <span class="dot dot-lg sq" data-bg="#6b79c8" style="background: rgb(107, 121, 200);"></span>
                    <span>Cuti Bersama</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- ///////////////////////////////////////////////////// Modal /////////////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalAddHoliday">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Holiday Event</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label">Holiday Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="add_holiday_name" id="add_holiday_name"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Holiday Type</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="add_holiday_ct">
                                    <label class="custom-control-label" for="add_holiday_ct">Cuti Tahunan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="add_holiday_start_date" id="add_holiday_start_date">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="add_holiday_end_date" id="add_holiday_end_date" disabled>    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary create_holiday_event" id="create_holiday_event">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade" tabindex="-1" id="modalAssignSchedule">
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
</div> -->

<!-- <div class="modal fade" tabindex="-1" id="modalUploadPattern">
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
                                        <div class="form-note"><code>template file upload:</code> <a href="./assets/documents/documents_tm/SHIFT_PATTERN_[MONTH]_[YEAR].csv">SHIFT_PATTERN_[MONTH]_[YEAR].csv</a>
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
</div> -->