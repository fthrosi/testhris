 <div class="nk-sidebar" data-content="sidebarMenu">
    <div class="nk-sidebar-inner" data-simplebar>
        <ul class="nk-menu nk-menu-md">
            <li class="nk-menu-heading">
                <a href="#" class="link link-text" data-toggle="modal" data-target="#create-request"><em class="icon-circle icon ni ni-plus"></em> <span>Create New</span></a> 
            </li> 
            <hr>
            <li class="nk-menu-heading">
                <a class="nk-ibx-menu-item" href="<?= site_url('home/request'); ?>">
                    <em class="icon ni ni-edit"></em>
                    <span class="nk-ibx-menu-text">My Submission</span>
                </a>
            </li>
            <li class="nk-menu-heading">
                <a class="nk-ibx-menu-item" href="<?= site_url('inbox/approval'); ?>">
                    <em class="icon ni ni-file-docs"></em>
                    <span class="nk-ibx-menu-text">Approval List</span>
                    <span class="badge badge-pill badge-primary"><?=($count_approval == 0) ? '' : $count_approval;?></span>
                </a>
            </li>

            <?php if ($this->session->userdata('access_employee') == '2' || $this->session->userdata('access_employee') == '99') { ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Management</h6>
                </li>

                <li class="nk-menu-heading">
                    <a class="nk-ibx-menu-item" href="<?= site_url('inbox/pa_management'); ?>">
                        <em class="icon ni ni-folder-check"></em>
                        <span class="nk-ibx-menu-text">Performance Appraisal</span>
                    </a>
                </li>

                <li class="nk-menu-heading">
                    <a class="nk-ibx-menu-item" href="<?= site_url('inbox/mgmt'); ?>">
                        <em class="icon ni ni-folder-check"></em>
                        <span class="nk-ibx-menu-text">Summary</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('access_employee') == '3' || $this->session->userdata('access_employee') == '99') { ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Management</h6>
                </li>

                <li class="nk-menu-heading">
                    <a class="nk-ibx-menu-item" href="<?= site_url('inbox/pa_management'); ?>">
                        <em class="icon ni ni-folder-check"></em>
                        <span class="nk-ibx-menu-text">Performance Appraisal</span>
                    </a>
                </li>

                <li class="nk-menu-heading">
                    <a class="nk-ibx-menu-item" href="<?= site_url('dashboard/c'); ?>">
                        <em class="icon ni ni-folder-check"></em>
                        <span class="nk-ibx-menu-text">Summary</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('access_employee') == '4' || $this->session->userdata('access_employee') == '99') { ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Management</h6>
                </li>

                <li class="nk-menu-heading">
                    <a class="nk-ibx-menu-item" href="<?= site_url('dashboard/pa_management'); ?>">
                        <em class="icon ni ni-folder-check"></em>
                        <span class="nk-ibx-menu-text">Performance Appraisal</span>
                    </a>
                </li>

                <li class="nk-menu-heading">
                    <a class="nk-ibx-menu-item" href="<?= site_url('dashboard/mgmt'); ?>">
                        <em class="icon ni ni-folder-check"></em>
                        <span class="nk-ibx-menu-text">Division Summary</span>
                    </a>
                </li>

                <li class="nk-menu-heading">
                    <a class="nk-ibx-menu-item" href="<?= site_url('dashboard/m'); ?>">
                        <em class="icon ni ni-folder-check"></em>
                        <span class="nk-ibx-menu-text">All Summary</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('access_employee') == '11' || $this->session->userdata('access_employee') == '99') { ?>
            <li class="nk-menu-heading">
                <h6 class="overline-title text-primary-alt">Human Resource</h6>
            </li>
            <li class="nk-menu-heading">
                <a class="nk-ibx-menu-item" href="<?= site_url('inbox/hr_division'); ?>">
                    <em class="icon ni ni-reports"></em>
                    <span class="nk-ibx-menu-text">Division Review</span>
                </a>
            </li>
            <li class="nk-menu-heading">
                <a class="nk-ibx-menu-item" href="<?= site_url('inbox/hr_confirmed'); ?>">
                    <em class="icon ni ni-reports"></em>
                    <span class="nk-ibx-menu-text">Confirmed PA & Plan</span>
                </a>
            </li>
            <li class="nk-menu-heading">
                <a class="nk-ibx-menu-item" href="<?= site_url('dashboard/h'); ?>">
                    <em class="icon ni ni-folder-check"></em>
                    <span class="nk-ibx-menu-text">All Summary</span>
                </a>
            </li>
            <?php } ?>

            <?php if ($this->session->userdata('access_employee') == '99') { ?>
            <li class="nk-menu-heading">
                <h6 class="overline-title text-primary-alt">Configuration</h6>
            </li>
            <li class="nk-menu-heading">
                <a class="nk-ibx-menu-item" href="<?= site_url('master/employee'); ?>">
                    <em class="icon ni ni-reports"></em>
                    <span class="nk-ibx-menu-text">Master Employee</span>
                </a>
            </li>
            <?php } ?>

        </ul>
    </div>
</div>