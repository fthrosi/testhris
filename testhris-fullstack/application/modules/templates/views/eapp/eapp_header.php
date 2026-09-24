<?php 
$CI =& get_instance();
$CI->load->model('form/form_model');
$result = $CI->form_model->getTotalCuti($this->session->userdata('employee_id'));
?>  
<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <!-- <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a> -->
            </div>
            <div class="nk-header-app-name">
                <div class="nk-header-app-logo">
                    <!-- <em class="icon ni ni-inbox bg-purple-dim"></em> -->
                    <img class="" src="<?php echo base_url(); ?>/assets/images/logo-ibsw-5.png" alt="logo">
                </div>
                <div class="nk-header-app-info">
                    <span class="lead-text">my HR</span>
                    <span class="sub-text">Human Resources Information System - IBSW</span>
                </div>
            </div>
            <!-- <marquee id="sisa_cuti" class="sisa_cuti" direction="right"><b><h5 style="color:#f64444; border-radius: 25px; font-size: 18px; font-family:Aharoni, sans-serif, Helvetica Neue, Arial, Noto Sans, sans-serif;"></h5></b></marquee> -->
                <!-- <div class="alert alert-fill alert-icon alert-primary" role="alert">    <em class="icon ni ni-alert-circle"></em>     <strong>Order has been placed</strong>. Your will be redirect for make your payment. </div> -->
                <?php 
                if (!empty($result)){
                    if($result[0]->total_cuti < 0){
            ?>
            <!-- <marquee style="color:red; border-radius: 25px; font-size: 25px; font-family:Aharoni, sans-serif, Helvetica Neue, Arial, Noto Sans, sans-serif;" direction="right"><b>SISA CUTI ANDA <?= $result[0]->total_cuti;?></b></marquee> -->
            <?php 
                    } 
                } 
            ?>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt-fill"></em>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar" style="width:42px;position:relative;">
                                 	<div id="alpha">
					    <span>
                                            <?php
                                            $username = $this->session->userdata('user_email');
                                            echo strtoupper($username[0]);
                                            ?>
                                        </span>
						</div>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text" style="font-size:11px;"><?= $this->session->userdata('employee_name');?></span>
                                        <span class="sub-text" style="font-size:9px;"><?= $this->session->userdata('user_email');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                     <li><a href="<?= site_url('master/Arv');?>"><em class="icon ni ni-download"></em><span>Apps Release Versions</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                     <li><a href="<?= site_url('register/ChangePassword');?>"><em class="icon ni ni-lock"></em><span>Change Passcode</span></a></li>
                                </ul>
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
<div id="sisa_cuti" class="sisa_cuti">
</div>