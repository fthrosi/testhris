<!DOCTYPE html>

<html lang="en">

<head> 
    <meta charset="utf-8"><meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/logo-ibsw-5.png">
    <title>Maintenance 503 | HRIS</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/v2/css/dashlite.css?ver=2.6.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>/assets/v2/css/theme.css?ver=2.6.0">
</head>

<body class="nk-body npc-default pg-error no-touch nk-nio-theme">
    <?php
        $test = base_url();
        //dumper($test);
    ?>
    <div class="nk-app-root">
        <div class="nk-main ">
                <div class="nk-wrap nk-wrap-nosidebar">
                        <div class="nk-content ">
                                    <div class="nk-block nk-block-middle wide-md mx-auto">
                                                <div class="nk-block-content nk-error-ld text-center">
                                                                <img class="nk-error" width="70%" src="<?php echo base_url(); ?>/assets/images/503_maintenance_2.svg" alt="">
                                                                <br>
                                                                <a href="<?php echo base_url(); ?>" class="btn btn-primary">Back</a>
                                                                <br><br>
                                                                <div class="wide-xs mx-auto">
                                                                    <h3 class="nk-error-title">
                                                                    Oops! Service Maintenance</h3>
                                                                    <p class="nk-error-text">We are very sorry for inconvenience. It looks like you’re try to access a page that either has been maintenance or out of service.</p>
                                                                </div>
                                                </div>
                                    </div>
                        </div>
                </div>
        </div>
    </div>
</body>



</html>