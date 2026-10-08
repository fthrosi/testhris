<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="<?= base_url(); ?>">
    <meta charset="utf-8">
    <meta name="author" content="ffadlifadd">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-status-bar-style" content="black">
    <meta name="description" content="@@ibs-mdcr">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/logo-ibsw-5.png">

    <title>Human Resource Information System - PT. Infrastruktur Bisnis Sejahtera</title>

    <!-- Dropzone -->
    <!-- <link href="<?= base_url() ?>assets/v2/css/dropzone/basic.css" rel="stylesheet"> -->
    <!-- <link href="<?= base_url() ?>assets/v2/css/dropzone/dropzone.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/dashlite.css?ver=2.6.0">
    <link id="skin-default" rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/theme.css?ver=2.6.0">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/ec.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/content.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/qrcode.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/homeEC.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">

    <!-- Add the evo-calendar.css for styling -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/v2/css/evo-calendar.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/v2/css/evo-calendar.royal-navy.css"/>

    <style type="text/css">
        #playlist {
            display:table;
        }
        #playlist li{
            cursor:pointer;
            padding:8px;
        }

        #playlist li:hover{
            color:blue;                        
        }
        #videoarea {
            float:left;
            width:640px;
            height:460px;
            margin:10px;    
            border:1px solid silver;
        }
    </style>
</head>

<body class="nk-body npc-apps apps-only has-apps-sidebar npc-apps-inbox no-touch nk-nio-theme has-sidebar">
    <div class="nk-app-root">
        <div class="nk-apps-sidebar is-theme">
            <div class="nk-apps-brand">
                <a href="#" class="logo-link"></a>
            </div>

            <!-- Sidebar -->
            <?= $this->load->view('eapp_sidebar'); ?>
        </div>

        <div class="nk-main ">
            <div class="nk-wrap ">
                <!-- Header -->
                <?= $this->load->view('eapp_header'); ?>
                
                <!-- Header -->
                <?= $this->load->view('eapp_sidebarMenu'); ?>
                
                <!-- Content -->
                <div class="nk-content p-0">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-ibx">

                                <?= $this->load->view('eapp_main-aside-menu'); ?>
                                
                                <div class="nk-ibx-body bg-white">
                                    <?= $this->load->view($content); ?>
                                </div>

                            </div><!-- .nk-ibx -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?=$this->load->view('templates/eapp/eapp_modal');?>

    <?php $version= date('Y-m-d H:i:s');?>
    <script>
        const BASE_URL = '<?= base_url() ?>';
        const SITE_URL = '<?= site_url() ?>';
        const base_url = '<?= site_url() ?>';
        const baseUrl  = '<?= site_url() ?>';
    </script>
    <script src="<?= base_url(); ?>/assets/v2/js/bundle.js?ver=2.6.0"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/scripts.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/toastr.js?ver=2.6.0"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/apps/inbox.js?ver=2.6.0"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/libs/tagify.js?ver=2.6.0"></script>
    
    <!-- <script src="<?= base_url(); ?>/assets/v2/js/charts/gd-analytics.js?ver=2.6.0"></script> -->
    <!-- <script src="<?= base_url(); ?>/assets/v2/js/charts/chart-analytics.js?ver=2.6.0"></script> -->
    <script src="<?= base_url(); ?>/assets/v2/js/libs/jqvmap.js?ver=2.6.0"></script>
    <!-- Dropzone -->
    <!-- <script src="<?= base_url() ?>/assets/v2/js/dropzone.js"></script> -->

    <script src="<?= base_url(); ?>/assets/v2/js/eapp/request.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/register.js"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/e-approval.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/dashboard.js?ver=<?= $version;?>"></script>

    <!-- /////////////////////////////////////////START Performance Appraisal 2025///////////////////////////////////////////// -->
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/e-approval_pa.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/dashboard_pa.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/pa-scripts.js?ver=<?= $version;?>"></script>
    <!-- /////////////////////////////////////////END Performance Appraisal 2025//////////////////////////////////////////// -->

        <!-- /////////////////////////////////////////START TIME MANAGEMENT 2024///////////////////////////////////////////// -->
    <!-- <script src="<?= base_url(); ?>/assets/v2/js/script_reports.js?ver=<?= $version;?>"></script> -->
    <script src="<?= base_url(); ?>assets/v2/js/tm-scripts.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>assets/v2/js/evo-calendar.js?ver=<?= $version;?>"></script>
    <!-- /////////////////////////////////////////END TIME MANAGEMENT 2024///////////////////////////////////////////// -->
    
    <!-- DataTables core -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->

    <!-- Buttons -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> -->
    <!-- /////////////////////////////////////////START EXIT CLEARANCE 2026///////////////////////////////////////////// -->
    <script src="<?= base_url(); ?>assets/v2/js/exit_clearance/ec.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>assets/v2/js/exit_clearance/ec_form.js?ver=<?= $version;?>"></script>
    <script src="<?= base_url(); ?>assets/v2/js/exit_clearance/handover.js?ver=<?= $version;?>"></script>
    <!-- /////////////////////////////////////////END EXIT CLEARANCE 2026///////////////////////////////////////////// -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/editors/quill.css?ver=2.6.0">
</body>

</html>
