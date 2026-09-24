<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="HRIS Applications - IBSW.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/logo-ibsw-5.png">
    <!-- Page Title  -->
    <title>Login | Human Resource Information System - PT. Infrastruktur Bisnis Sejahtera</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/dashlite.css?ver=2.9.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/theme.css?ver=2.9.0">
    <!-- loading_bar -->
    <script src="<?php echo base_url(); ?>assets/v2/js/pace.js"></script>
</head>
<style>
    .bgdiv {
   /* Background pattern from Toptal Subtle Patterns */
   background-image: url("<?php echo base_url(); ?>/assets/images/skybuilding.jpg");
   background-size: 90% 100%;
   height: 100%;
   width: 100%;
}
    </style>
<body class="nk-body bg-white npc-default pg-auth no-touch nk-nio-theme">
    <div class="nk-app-root"><div class="nk-main "><div class="nk-wrap nk-wrap-nosidebar">
        <div class="nk-content bgdiv">
            <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                <div class="brand-logo pb-4 text-center">
                    <a href="<?php echo base_url(); ?>" class="logo-link">
                            <img class="logo-dark" style="width:380px; height:60px;" src="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" srcset="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" alt="logo">
                            <!-- <img class="logo-dark" style="width:380px; height:60px; padding-top: 0px;padding-bottom: 0px;" src="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" srcset="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" alt="logo-dark"> -->
                    </a>
                </div>
                <div class="card" style="background-color:#ffffffdb;">
                    <div class="card-inner card-inner-lg" id="indexPage">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Sign-In</h4>
                                <div class="nk-block-des">
                                    <p>Access the HRIS using your email and passcode.</p>
                                </div>
                            </div>
                        </div>
                        <form action="<?=base_url();?>login/proses_login" class="form-validate is-alter" autocomplete="off" method="post">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="default-01">Email</label>
                                </div>
                                <div class="form-control-wrap">
                                    <input autocomplete="email" type="email" class="form-control form-control-lg" required id="email-address" name="email" placeholder="Enter your email address">
                                </div>
                            </div>
                           <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">Passcode</label>
                                </div>
                                <div class="form-control-wrap">
                                    <a href="#" class="form-icon form-icon-right passcode-switch lg is-hidden" data-target="password">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input autocomplete="new-password" type="password" class="form-control form-control-lg" required id="password" name="password" placeholder="Enter your passcode">
                                </div>
                            </div>
                            <div class="form-group">
                              <button style="background-color: #cc0000; "class="btn btn-lg btn-danger btn-block">Sign in</button>
                              <button style="background-color: #385a64;" id="btnForgotPass" class="btn btn-lg btn-success btn-block">Forgot Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="background:#cc0000" class="nk-footer nk-auth-footer-full">
                <div class="container wide-lg">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="nk-block-content text-center text-lg-left">
                                <p style="color:#ffffff;" class="text">© 2022 Infrastruktur Bisnis Sejahtera. All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/js/bundle.js?ver=2.9.0"></script>
    <script src="<?php echo base_url(); ?>/assets/js/scripts.js?ver=2.9.0"></script>
    <script src="<?= base_url(); ?>assets/v2/js/eapp/reset_password.js"></script>
</html>