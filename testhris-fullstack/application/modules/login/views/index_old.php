<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="HRIS Applications - IBST.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/logo40.png">
    <!-- Page Title  -->
    <title>Login | Human Resource Information System - PT. Infrastruktur Bisnis Sejahtera</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/dashlite.css?ver=2.9.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/theme.css?ver=2.9.0">
</head>

<body class="nk-body npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-md">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="<?php echo base_url(); ?>" class="logo-link">
                                        <img class="logo-light" style="width:400px; height:80px;" src="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" srcset="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" alt="logo">
                                        <img class="logo-dark" style="width:400px; height:80px;" src="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" srcset="<?php echo base_url(); ?>/assets/images/logo_ibsw.png" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Sign-In</h5>
                                        <div class="nk-block-des">
                                            <p>Access the HRIS panel using your email and passcode.
                                            <br>
                                            For best experience use <b>Google Chrome</b></p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <form action="<?=base_url();?>login/proses_login" class="form-validate is-alter" autocomplete="off" method="post">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email-address">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input autocomplete="email" type="email" class="form-control form-control-lg" required id="email-address" name="email" placeholder="Enter your email address">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Passcode</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input autocomplete="new-password" type="password" class="form-control form-control-lg" required id="password" name="password" placeholder="Enter your passcode">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                                    </div>
                                </form><!-- form -->
                            </div><!-- .nk-block -->
                            <div class="nk-block nk-auth-footer">
                                <div class="mt-3">
                                    <p>&copy; 2022 HRIS - PT. Infrastruktur Bisnis Sejahtera.</p>
                                </div>
                            </div><!-- .nk-block -->
                        </div><!-- .nk-split-content -->
                        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-4 m-auto">
                                <div class="slider-init" data-slick='{"dots":true, "arrows":false, "autoplay":true, "fade":true, "autoplaySpeed":2000, "speed":2000}'>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="<?php echo base_url(); ?>/assets/images/slides/gambar6.jpg" srcset="<?php echo base_url(); ?>/assets/images/slides/gambar6.jpg 2x" alt="">
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>HRIS</h4>
                                        <p>PT. Infrastruktur Bisnis Sejahtera.</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="<?php echo base_url(); ?>/assets/images/slides/gambar5.jpg" srcset="<?php echo base_url(); ?>/assets/images/slides/gambar5.jpg 2x" alt="">
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>HRIS</h4>
                                              <p>PT. Infrastruktur Bisnis Sejahtera.</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="<?php echo base_url(); ?>/assets/images/slides/gambar4.jpg" srcset="<?php echo base_url(); ?>/assets/images/slides/gambar4.jpg 2x" alt="">
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>HRIS</h4>
                                                <p>PT. Infrastruktur Bisnis Sejahtera.</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                </div><!-- .slider-init -->
                                <div class="slider-dots"></div>
                                <div class="slider-arrows"></div>
                            </div><!-- .slider-wrap -->
                        </div><!-- .nk-split-content -->
                    </div><!-- .nk-split -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/js/bundle.js?ver=2.9.0"></script>
    <script src="<?php echo base_url(); ?>/assets/js/scripts.js?ver=2.9.0"></script>
</html>