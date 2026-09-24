<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$ci = new CI_Controller();
$ci =& get_instance();
$ci->load->helper('url');
?>

<!DOCTYPE html>

<html lang="en">

<head> 
    <meta charset="utf-8"><meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="https://hris.ibstower.com/assets/v2/images/ibs-icon.ico">
    <title>Error 404 | HRIS</title>
    <link rel="stylesheet" href="https://hris.ibstower.com/assets/v2/css/dashlite.css?ver=2.6.0">
    <link id="skin-default" rel="stylesheet" href="https://hris.ibstower.com/assets/v2/css/theme.css?ver=2.6.0">
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
                                                                <img class="nk-error-gfx" src="https://hris.ibstower.com/assets/images/error-404.svg" alt="">
                                                                <div class="wide-xs mx-auto"><h3 class="nk-error-title">
                                                                    Oops! Why you’re here?</h3><p class="nk-error-text">We are very sorry for inconvenience. It looks like you’re try to access a page that either has been deleted or never existed.</p>
                                                                </div>
                                                </div>
                                    </div>
                        </div>
                </div>
        </div>
    </div>
</body>



</html>