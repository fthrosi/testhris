<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="<?= base_url(); ?>">
    <meta charset="utf-8">
    <meta name="author" content="ffadlifadd">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@@ibs-eapproval">
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/ibs-icon.ico">

    <title>i-Approve</title>

    <link rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/dashlite.css?ver=2.6.0">
    <link id="skin-default" rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/theme.css?ver=2.6.0">
</head>

<body class="nk-body layout-apps has-apps-sidebar npc-apps-chat">
    <div class="nk-app-root">
        <!-- Sidebar -->
        <?= $this->load->view('sidebar'); ?>

        <div class="nk-main ">
            <div class="nk-wrap ">
                <!-- Header -->
                <?= $this->load->view('header'); ?>
                <!-- Content -->
                <?= $this->load->view($content); ?>
            </div>
        </div>
    </div>

    <script src="<?= base_url(); ?>/assets/v2/js/bundle.js?ver=2.6.0"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/scripts.js?ver=2.6.0"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/apps/chats.js?ver=2.6.0"></script>

    <script src="<?= base_url(); ?>/assets/v2/js/eapp/request.js"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/approval.js"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/register.js"></script>
    <script src="<?= base_url(); ?>/assets/v2/js/eapp/e-approval.js"></script>

    
</body>

</html>
