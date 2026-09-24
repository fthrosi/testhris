<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@@page-discription">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/ibs-icon.ico">
    <!-- Page Title  -->
    <title>Change Password</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/dashlite.css?ver=2.6.0">
    <link id="skin-default" rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/theme.css?ver=2.6.0">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                        </div>

                        <div class="card card-bordered" id="div_reg">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h5 class="nk-block-title">Change Passcode</h5>
                                            <div class="nk-block-des">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="emp_id" id="emp_id">
                                    <div class="form-group">
                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="newpasscode">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input autocomplete="new-password" type="password" class="form-control form-control-lg" required id="newpasscode" name="newpasscode" placeholder="Enter your new passcode" required="true">
                                    </div>
                                    <div class="form-group">
                                      <input autocomplete="new-password" type="password" class="form-control form-control-lg" required id="confpasscode" name="confpasscode" placeholder="Confirmation your passcode" required="true">
                                    </div>
                                    <div class="form-group">
                                        <button id="btnUpdatePassword" class="btn btn-lg btn-primary btn-block">Confirm</button>
                                    </div>
                                    <div class="form-group">
                                        <a href="<?= site_url('dashboard');?>"><button class="btn btn-lg btn-primary btn-block"><span>Back to dashboard</span></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?= base_url(); ?>/assets/v2/js/bundle.js?ver=2.6.0"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/scripts.js?ver=2.6.0"></script>
    <script src="<?= base_url(); ?>assets/v2/js/eapp/register.js"></script>
</html>