<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-lg-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-app-name">
                <div class="nk-header-app-logo">
                    <!-- <em class="icon ni ni-layers bg-primary-dim"></em> -->
                    <img class="" src="<?= base_url(); ?>/assets/v2/images/logo_IBS.jpeg" alt="logo">
                </div>
                <div class="nk-header-app-info">
                    <span class="lead-text">i-Approve</span>
                    <span class="sub-text">E-BAST</span>
                </div>
            </div>
            <div class="nk-header-menu is-light" data-content="headerNav">
                <div class="nk-header-mobile">
                    <div class="nk-header-brand">
                        <a href="<?= base_url(); ?>" class="logo-link"></a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div>
                <div class="nk-header-menu-inner">
                    <div class="nk-header-app-switch d-lg-none">
                        <ul class="nk-header-app-list">
                           
                        </ul>
                    </div>
                    <!-- Menu -->
                </div>
            </div>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">

                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-status user-status-unverified"><?= $this->session->userdata('user_email');?></div>
                                    <div class="user-name dropdown-indicator"><?= $this->session->userdata('user_email');?></div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span>
                                            <?php
                                            $username = $this->session->userdata('user_email');
                                            echo strtoupper($username[0]);
                                            ?>
                                        </span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text"><?= $this->session->userdata('user_email');?></span>
                                        <span class="sub-text"><?= $this->session->userdata('user_email');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="<?= site_url('login/do_logout');?>"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>