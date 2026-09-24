<style>
    .submenu_color li:hover { background: #ff00007d; border-radius: 3px; }
    .submenu_color li.active { background: #ff00007d; border-radius: 3px; }
</style>
<div class="nk-ibx-aside" data-content="inbox-aside" data-toggle-overlay="true" data-toggle-screen="lg">
    <?php
        if($this->session->userdata('access_employee') != '13'){
    ?>
    <div class="nk-ibx-head">
        <div class="mr-n1">
            <a href="#" class="link link-text" data-toggle="modal" data-target="#create-request"><em class="icon-circle icon ni ni-plus-c"></em> <span>Create New</span></a> 
        </div>
    </div>
    <?php
        }
    ?>

    <div class="nk-ibx-nav" data-simplebar>

        <ul class="nk-ibx-menu">

            <li>
            <li <?php echo ($this->uri->segment(2) == 'dashboard') ? 'class="active"' : ''; ?>>
                <a class="nk-ibx-menu-item" href="<?= site_url('dashboard/dashboard'); ?>">
                    <em class="icon ni ni-dashboard"></em>
                    <span class="nk-ibx-menu-text">Dashboard</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'request') ? 'class="active"' : ''; ?>>
                <a class="nk-ibx-menu-item" href="<?= site_url('home/request'); ?>">
                    <em class="icon ni ni-edit"></em>
                    <span class="nk-ibx-menu-text">My Submission <span class="badge badge-pill badge-primary"><?=($count_mysubmission == 0) ? '' : $count_mysubmission;?></span></span>
                </a>
            </li>
            <?php if ($this->session->userdata('access_employee') == '12'){ ?>
            <!--li class="menu-item_2">
                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                    <span class="nk-ibx-menu-text">Approval List</span>
                </a>
                <ul class="sub-menu_2 nk-ibx-menu-sub">
                    <li class="nk-ibx-menu-item">
                    <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval'); ?>">
                    <em class="icon ni ni-file-docs"></em>
                    <span class="nk-ibx-menu-text">Approval All <span class="badge badge-pill badge-primary"><?=($count_approval == 0) ? '' : $count_approval;?></span></span>
                    </a>
                    </li>
                    <li class="nk-ibx-menu-item">
                    <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_mdcr'); ?>">
                        <span class="nk-ibx-menu-text">Medical Approval<span class="badge badge-pill badge-primary"><?=($count_need_mdcr_cek == 0) ? '' : $count_need_mdcr_cek;?></span></span>
                    </a>
                    </li>
                </ul>
            </li -->
            <li class="menu-item_2">
                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                    <span class="nk-ibx-menu-text">Approval List</span>
                </a>
                <!-- <ul class="sub-menu_2 nk-ibx-menu-sub"> -->
                <ul class="sub-menu_2 submenu_color">
                    <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval'); ?>">
                            <span class="nk-ibx-menu-text">Approval All <span class="badge badge-pill badge-primary"><?=($count_approval == 0) ? '' : $count_approval;?></span></span>
                        </a>
                    </li>
                    <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_mdcr'); ?>">
                            <span class="nk-ibx-menu-text">Medical Approval<span class="badge badge-pill badge-primary"><?=($count_need_mdcr_cek == 0) ? '' : $count_need_mdcr_cek;?></span></span>
                        </a>
                    </li>
                    <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
                    <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_TM_ztm'); ?>">
                            <!-- <span class="nk-ibx-menu-text">Time Off Approval<span class="badge badge-pill badge-primary"><?=(($count_need_tm_cek + $count_need_tm_hr + $count_need_tm_shift) == 0) ? '' : ($count_need_tm_cek + $count_need_tm_hr + $count_need_tm_shift);?></span></span> -->
                            <span class="nk-ibx-menu-text">Time Off Approval</span>
                        </a>
                    </li>
                    <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->
                    <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approvalpa'); ?>">
                            <span class="nk-ibx-menu-text">Appraisal Approval<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item_2">
                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                    <span class="nk-ibx-menu-text">Medical Report</span>
                </a>
                <ul class="sub-menu_2 nk-ibx-menu-sub">
                    <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('report/medical_control_sheets'); ?>">
                            <span class="nk-ibx-menu-text">Medical Control Sheets<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                    </li>
                    <!-- <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('report/medical_monthly_report'); ?>">
                            <span class="nk-ibx-menu-text">Medical Monthly Report<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                    </li> -->
                    <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('report/medical_claim_and_balance'); ?>">
                            <span class="nk-ibx-menu-text">Medical Claim and Balance<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
            <li class="menu-item_2">
                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                    <span class="nk-ibx-menu-text">Time Management Report</span>
                </a>
                <ul class="sub-menu_2 nk-ibx-menu-sub">
                    <li>
                        <a class="nk-ibx-menu-item" href="<?= site_url('report/attendance'); ?>">
                            <span class="nk-ibx-menu-text">Attendance Report<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-ibx-menu-item" href="<?= site_url('report/time_management_report'); ?>">
                            <span class="nk-ibx-menu-text">Leave Balance Report<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-ibx-menu-item" href="<?= site_url('report/attendance_summary_and_detail'); ?>">
                            <span class="nk-ibx-menu-text">Employee Time Tracking Report<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->
            <?php } elseif ($this->session->userdata('access_employee') == '13'){ ?>
                <li class="menu-item_2">
                    <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                        <span class="nk-ibx-menu-text">Medical Report</span>
                    </a>
                    <ul class="sub-menu_2 nk-ibx-menu-sub">
                        <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('report/medical_control_sheets'); ?>">
                            <span class="nk-ibx-menu-text">Medical Control Sheets<span class="badge badge-pill badge-primary"></span></span>
                        </a>
                        </li>
                    </ul>
                        
                </li>
            <?php } elseif ($this->session->userdata('access_level') == '9'){ ?>
                <li class="menu-item_2">
                    <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                        <span class="nk-ibx-menu-text">Approval List</span>
                    </a>
                    <!-- <ul class="sub-menu_2 nk-ibx-menu-sub"> -->
                    <ul class="sub-menu_2 submenu_color">
                        <li class="nk-ibx-menu-item">
                            <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval'); ?>">
                                <span class="nk-ibx-menu-text">Approval All <span class="badge badge-pill badge-primary"><?=($count_approval == 0) ? '' : $count_approval;?></span></span>
                            </a>
                        </li>
                        <li class="nk-ibx-menu-item">
                            <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_mdcr_to_fi'); ?>">
                                <span class="nk-ibx-menu-text">Medical Approval<span class="badge badge-pill badge-primary"><?=($count_mdcr_after_grouping_need_approved == 0) ? '' : $count_mdcr_after_grouping_need_approved;?></span></span>
                            </a>
                        </li>
                        <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
                        <li class="nk-ibx-menu-item">
                            <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_TM_ztm'); ?>">
                                <!-- <span class="nk-ibx-menu-text">Time Off Approval<span class="badge badge-pill badge-primary"><?=($count_need_tm_cek == 0) ? '' : $count_need_tm_cek;?></span></span> -->
                                <span class="nk-ibx-menu-text">Time Off Approval</span>
                            </a>
                        </li>
                        <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->
                        <li class="nk-ibx-menu-item">
                            <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approvalpa'); ?>">
                                <span class="nk-ibx-menu-text">Appraisal Approval<span class="badge badge-pill badge-primary"></span></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
                <li>
                    <a class="nk-ibx-menu-item" href="<?= site_url('report/attendance'); ?>">
                        <em class="icon ni ni-clock"></em>
                        <span class="nk-ibx-menu-text">Attendance Report<span class="badge badge-pill badge-primary"></span></span>
                    </a>
                </li>
            <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->   
            <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
            <?php } elseif ($this->session->userdata('access_level') == '6' || $this->session->userdata('access_level') == '7' || $this->session->userdata('user_role') == '12'){ ?>
                            <li class="menu-item_2">
                                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                                    <span class="nk-ibx-menu-text">Approval List</span>
                                </a>
                                <ul class="sub-menu_2 nk-ibx-menu-sub">
                                    <li class="nk-ibx-menu-item">
                                    <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval'); ?>">
                                    <!-- <em class="icon ni ni-file-docs"></em> -->
                                    <span class="nk-ibx-menu-text">Approval All <span class="badge badge-pill badge-primary"><?=($count_approval == 0) ? '' : $count_approval;?></span></span>
                                    </a>
                                    </li>
                                    <li class="nk-ibx-menu-item">
                                    <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_TM_ztm'); ?>">
                                        <!-- <span class="nk-ibx-menu-text">Time Off Approval<span class="badge badge-pill badge-primary"><?=(($count_need_tm_cek + $count_need_tm_hr) == 0) ? '' : ($count_need_tm_cek + $count_need_tm_hr);?></span></span> -->
                                        <span class="nk-ibx-menu-text">Time Off Approval</span>
                                    </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item_2">
                            <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                                <span class="nk-ibx-menu-text">Time Management Report</span>
                            </a>
                            <ul class="sub-menu_2 nk-ibx-menu-sub">
                                <li>
                                    <a class="nk-ibx-menu-item" href="<?= site_url('report/attendance'); ?>">
                                        <span class="nk-ibx-menu-text">Attendance Report<span class="badge badge-pill badge-primary"></span></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nk-ibx-menu-item" href="<?= site_url('report/time_management_report'); ?>">
                                        <span class="nk-ibx-menu-text">Leave Balance Report<span class="badge badge-pill badge-primary"></span></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nk-ibx-menu-item" href="<?= site_url('report/attendance_summary_and_detail'); ?>">
                                        <span class="nk-ibx-menu-text">Employee Time Tracking Report<span class="badge badge-pill badge-primary"></span></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->         
            <?php } else { ?>
                <li class="menu-item_2">
                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-file-docs"></em>
                    <span class="nk-ibx-menu-text">Approval List</span>
                </a>
                    <!-- <ul class="sub-menu_2 nk-ibx-menu-sub"> -->
                    <ul class="sub-menu_2 submenu_color">
                        <li class="nk-ibx-menu-item">
                            <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval'); ?>">
                                <span class="nk-ibx-menu-text">Approval All <span class="badge badge-pill badge-primary"><?=($count_approval == 0) ? '' : $count_approval;?></span></span>
                            </a>
                        </li>
                        <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
                        <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_TM_ztm'); ?>">
                            <!-- <span class="nk-ibx-menu-text">Time Off Approval<span class="badge badge-pill badge-primary"><?=($count_need_tm_cek == 0) ? '' : $count_need_tm_cek;?></span></span> -->
                            <span class="nk-ibx-menu-text">Time Off Approval <span class="badge badge-pill badge-primary"><?=($count_need_tm_cek == 0) ? '' : $count_need_tm_cek;?></span></span>
                        </a>
                        </li>
                        <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->                        
                        <li class="nk-ibx-menu-item">
                            <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approvalpaAll'); ?>">
                                <span class="nk-ibx-menu-text">Appraisal Approval<span class="badge badge-pill badge-primary"></span></span>
                            </a>
                        </li>
                        <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
                        <li class="nk-ibx-menu-item">
                        <a class="nk-ibx-menu-link" href="<?= site_url('inbox/approval_resignation_letter'); ?>">
                            <span class="nk-ibx-menu-text">Exit Clearance <span class="badge badge-pill badge-primary"><?=($count_approval_ec == 0) ? '' : $count_approval_ec;?></span></span>
                        </a>
                        </li>
                        <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->                        
                    </ul>
                </li>
                <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
                <li>
                    <a class="nk-ibx-menu-item" href="<?= site_url('report/attendance'); ?>">
                        <em class="icon ni ni-clock"></em>
                        <span class="nk-ibx-menu-text">Attendance Report<span class="badge badge-pill badge-primary"></span></span>
                    </a>
                </li>
                <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->
            <?php } ?>
                <!-- ////////////////////////////////START TIME MANAGEMENT 2024//////////////////////////////////// -->
            
								<?php if ($this->session->userdata('access_employee') == '13' || $this->session->userdata('access_employee') == '14'){ ?>
									<li>
											<a class="nk-ibx-menu-item" href="<?= site_url('report/medical_reports_ap'); ?>">
												<em class="icon ni ni-invest"></em>
												<span class="nk-ibx-menu-text">Medical Process<span class="badge badge-pill badge-primary"></span></span>
											</a>
									</li>
								<?php } ?>

						<li>
                    <a class="nk-ibx-menu-item" href="<?= site_url('report/calendar'); ?>">
                        <em class="icon ni ni-calendar"></em>
                        <span class="nk-ibx-menu-text">Calendar<span class="badge badge-pill badge-primary"></span></span>
                    </a>
            </li>
						
		

            <!-- ////////////////////////////////END TIME MANAGEMENT 2024//////////////////////////////////// -->
        </ul>

        <?php if ($this->session->userdata('access_employee') == '11' || $this->session->userdata('access_employee') == '2' || $this->session->userdata('access_employee') == '99') { ?>
        <div class="nk-ibx-nav-head">
            <h6 class="title">Management</h6>
        </div>
        <ul class="nk-ibx-label">

            <li <?php echo ($this->uri->segment(2) == 'pa_management') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('inbox/pa_management'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-danger"></span>
                    <span class="nk-ibx-label-text">Performance Appraisal</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'mgmt_mul') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('inbox/mgmt_mul'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-danger"></span>
                    <span class="nk-ibx-label-text">Division Summary</span>
                </a>
            </li>
            <?php 
            $check_access_divhead = check_pa_leaving($this->session->userdata('division'));
            $check_access_directorate = $this->session->userdata('directorate');
            $check_access_user_email = $this->session->userdata('user_email');
            if(!empty($check_access_divhead[0]->id)){
                if($check_access_divhead[0]->id > 0){
                    ?>
                    <li <?php echo ($this->uri->segment(2) == 'add_pa_leaving_employee') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('inbox/add_pa_leaving_employee'); ?>">
                            <span class="nk-ibx-label-dot dot dot-xl dot-label bg-warning"></span>
                            <span class="nk-ibx-label-text">Add PA leaving employee</span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <?php } ?>

        <?php if ($this->session->userdata('access_employee') == '3' || $this->session->userdata('access_employee') == '99') { ?>
        <div class="nk-ibx-nav-head">
            <h6 class="title">Management</h6>
        </div>
        <ul class="nk-ibx-label">

            <li <?php echo ($this->uri->segment(2) == 'pa_management') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('inbox/pa_management'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-danger"></span>
                    <span class="nk-ibx-label-text">Performance Appraisal</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'mgmt_mul') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('inbox/mgmt_mul'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-danger"></span>
                    <span class="nk-ibx-label-text">Division Summary</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'listDivisionC') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/listDivisionC'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Directorate Summary</span>
                </a>
            </li>
            
            <li <?php echo ($this->uri->segment(2) == 'c') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/c'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Summary</span>
                </a>
            </li>
        </ul>
        <?php } ?>

        <?php if ($this->session->userdata('access_employee') == '4' || $this->session->userdata('access_employee') == '99') { ?>
        <div class="nk-ibx-nav-head">
            <h6 class="title">Management</h6>
        </div>
        <ul class="nk-ibx-label">
            <li <?php echo ($this->uri->segment(2) == 'pa_management') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/pa_management'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-danger"></span>
                    <span class="nk-ibx-label-text">Performance Appraisal</span>
                </a>
            </li>
            <!-- <li <?php echo ($this->uri->segment(2) == 'mgmt') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/mgmt'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-danger"></span>
                    <span class="nk-ibx-label-text">Division Summary</span>
                </a>
            </li> -->
            <li <?php echo ($this->uri->segment(2) == 'mgmt_mul') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('inbox/mgmt_mul'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-danger"></span>
                    <span class="nk-ibx-label-text">Division Summary</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'listDivisionC') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/listDivisionC'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Directorate Summary</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'listAllDirectorate') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/listAllDirectorate'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">All Directorate Summary</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/m'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">All Summary</span>
                </a>
            </li>
        </ul>
        <?php } ?>

        <!-- ///////////////////////////////////START TIME MANAGEMENT 2024 Menu Shifting Dept Head/RPM /////////////////////////////////// -->
        <?php if ($this->session->userdata('access_employee') == '27' || $this->session->userdata('access_employee') == '12') { ?>
        <div class="nk-ibx-nav-head">
            <h6 class="title">Shift Management</h6>
        </div>
        <ul class="nk-ibx-label">
            <li>
                <a class="nk-ibx-menu-item" href="<?= site_url('master/shifting_menu'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-primary"></span>
                    <span class="nk-ibx-label-text">Employee Shift</span>
                </a>
            </li>
        </ul>
        <?php } ?>
        <!-- ///////////////////////////////////END TIME MANAGEMENT Menu Shifting Dept Head/RPM /////////////////////////////////// -->
         
        <?php if ($this->session->userdata('access_employee') == '11' || $this->session->userdata('access_employee') == '99') { ?>
        <div class="nk-ibx-nav-head">
            <h6 class="title">Human Resource</h6>
        </div>
        <ul class="nk-ibx-menu" style="padding-top: 0rem;">
            <li class="menu-item_2">
                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-opt-dot-alt"></em>
                    <span class="nk-ibx-menu-text">Setting PA</span>
                </a>
                <ul class="sub-menu_2 submenu_color">
                    <li <?php echo ($this->uri->segment(2) == 'hr_division_employee') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('inbox/hr_division_employee'); ?>">
                            <span class="nk-ibx-label-text">Division Employee</span>
                        </a>
                        <br>
                    </li>
                    <!--<li <?php echo ($this->uri->segment(2) == 'hr_uom') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('inbox/hr_uom'); ?>">
                            <span class="nk-ibx-label-text">Master UOM</span>
                        </a>
                        <br>
                    </li>-->
                    <li <?php echo ($this->uri->segment(2) == 'hr_preparation_pa') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('inbox/hr_preparation_pa'); ?>">
                            <span class="nk-ibx-label-text">Preparation Division For PA</span>
                        </a>
                        <br>
                    </li>
                    <!-- <li <?php echo ($this->uri->segment(2) == 'ga_kurva') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('inbox/ga_kurva'); ?>">
                            <span class="nk-ibx-label-text">GA Kurva</span>
                        </a>
                        <br>
                    </li> -->
                    <li <?php echo ($this->uri->segment(2) == 'change_division_leaving_employee') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('inbox/change_division_leaving_employee'); ?>">
                            <span class="nk-ibx-label-text">Change division for leaving employee</span>
                        </a>
                        <br>
                    </li>
                    <li <?php echo ($this->uri->segment(2) == 'divhead_pa_leaving_employee') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('inbox/divhead_pa_leaving_employee'); ?>">
                            <span class="nk-ibx-label-text">Access PA for leaving employee</span>
                        </a>
                        <br>
                    </li>
                    <li <?php echo ($this->uri->segment(2) == 'add_multi_division') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('master/add_multi_division'); ?>">
                            <span class="nk-ibx-label-text">Update Division Head</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nk-ibx-menu" style="padding-top: 0rem;">
            <li class="menu-item_2">
                <a href="#" class="nk-ibx-menu-item nk-menu-toggle"><em class="icon ni ni-opt-dot-alt"></em>
                    <span class="nk-ibx-menu-text">Report</span>
                </a>
                <!-- <ul class="sub-menu_2 nk-ibx-menu-sub"> -->
                <ul class="sub-menu_2 submenu_color">
                    <li <?php echo ($this->uri->segment(2) == 'report_pa') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('dashboard/report_pa'); ?>">
                            <span class="nk-ibx-label-text">Report Performance Appraisal</span>
                        </a>
                        <br>
                    </li>
                    <li <?php echo ($this->uri->segment(2) == 'report_training') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('dashboard/report_training'); ?>">
                            <span class="nk-ibx-label-text">Analysis Training</span>
                        </a>
                        <br>
                    </li>
                    <!-- <li <?php echo ($this->uri->segment(2) == 'report_ninebox') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('dashboard/report_ninebox'); ?>">
                            <span class="nk-ibx-label-text">Report Nine Box Talent Map</span>
                        </a>
                        <br>
                    </li> -->
                    <li <?php echo ($this->uri->segment(2) == 'history_pa') ? 'class="active"' : ''; ?>>
                        <a href="<?= site_url('dashboard/history_pa'); ?>">
                            <span class="nk-ibx-label-text">History Performance Appraisal</span>
                        </a>
                        <br>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nk-ibx-label">
            <li <?php echo ($this->uri->segment(2) == 'hr_division') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('inbox/hr_division'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Division Review</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'hr_confirmed') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('inbox/hr_confirmed'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Confirmed PA & Plan</span>
                </a>
            </li>
           <li <?php echo ($this->uri->segment(2) == 'h') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('dashboard/h'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">All Summary</span>
                </a>
            </li>
        </ul>
        <?php } ?>

        <?php if ($this->session->userdata('access_employee') == '12' || $this->session->userdata('access_employee') == '99') { ?>
        <div class="nk-ibx-nav-head">
            <h6 class="title">Configuration</h6>
        </div>
        <ul class="nk-ibx-label">
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
              <a href="<?= site_url('master/employee'); ?>">
                <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                <span class="nk-ibx-label-text">Master Employee</span>
              </a>
            </li>
<!--             <li <?#php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
              <a href="<?#= site_url('master/regional_pm'); ?>">
                <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                <span class="nk-ibx-label-text">Master RPM</span>
              </a>
            </li> -->
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
              <a href="<?= site_url('master/users'); ?>">
                <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                <span class="nk-ibx-label-text">Users</span>
              </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
              <a href="<?= site_url('master/medical_plafon'); ?>">
                <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                <span class="nk-ibx-label-text">Medical - Plafon</span>
              </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
              <a href="<?= site_url('master/medical_type_of_reimbursment'); ?>">
                <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                <span class="nk-ibx-label-text">Medical - Type of Reimbursment</span>
              </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('master/time_off'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">TM - Time-Off</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('master/schedule'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">TM - Schedule</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('master/office'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">TM - Office Location</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('report/time_management_logs'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Log Activity</span>
                </a>
            </li>
        </ul>
        <?php } else if ($this->session->userdata('access_level') == '7' || $this->session->userdata('access_employee') == '12') { ?>
            <div class="nk-ibx-nav-head">
            <h6 class="title">Configuration</h6>
        </div>
        <ul class="nk-ibx-label">
            <li <?php echo ($this->uri->segment(2) == 'employee') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('master/employee'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Master Employee</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('master/time_off'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">TM - Time-Off</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('master/schedule'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">TM - Schedule</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('master/office'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">TM - Office Location</span>
                </a>
            </li>
            <li <?php echo ($this->uri->segment(2) == 'm') ? 'class="active"' : ''; ?>>
                <a href="<?= site_url('report/time_management_logs'); ?>">
                    <span class="nk-ibx-label-dot dot dot-xl dot-label bg-info"></span>
                    <span class="nk-ibx-label-text">Log Activity</span>
                </a>
            </li>
        </ul>
        <?php } ?>
        <ul>
            <li class="nk-ibx-menu-item">
            </li>
            <li class="nk-ibx-menu-item">
            </li>
        </ul>
    </div>
</div><!-- .nk-ibx-aside -->