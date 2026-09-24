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
    <title>Registration Form</title>
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
                                            <h5 class="nk-block-title">Registration Form</h5>
                                            <div class="nk-block-des">
                                                <p>Please enter your Employee ID.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="email">Employee ID</label>
                                        <input type="number" onkeypress="return isNumericID(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==8) return validate_emp_id();" maxlength="8" class="form-control form-control-lg" id="emp_nik" name="emp_nik" placeholder="Employee ID">

                                        <input type="hidden" name="app" id="app" value="<?=$app;?>">
                                    </div>


                                    <div id="reg_phone" style="display: none;">

                                        <input type="hidden" name="emp_id" id="emp_id">

                                        <div class="form-group">
                                            <label class="form-label" for="email">Name</label>
                                            <input type="text" class="form-control form-control-lg" disabled id="emp_name" name="emp_name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">Division</label>
                                            <input type="text" class="form-control form-control-lg" disabled id="emp_division" name="emp_division">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">Phone Number</label>
                                            <input type="text" class="form-control form-control-lg" id="phoneNumber" name="phoneNumber" placeholder="Please enter your Phone Number here..">
                                        </div>
                                        <div class="form-group">
                                            <button id="btnRegister" class="btn btn-lg btn-primary btn-block">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-bordered" id="div_ndah" style="display: none;">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <div class="nk-block-des">
                                                <h5 class="text-soft ff-mono">Are you ok?</h5>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <a id="yaok" onclick="return answer(this.id)" class="btn btn-dim btn-primary">I'm okay</a>
                                        <a id="nook" onclick="return answer(this.id)" class="btn btn-dim btn-light">No!!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-bordered" id="div_ndah_nook" style="display: none;">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <div class="nk-block-des">
                                                <h5 class="text-soft ff-mono">Alright, one minutes..</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-bordered" id="div_ndah_yaok" style="display: none;">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <div class="nk-block-des">
                                                <h5 class="text-soft ff-mono">Bener?</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a id="sure" onclick="return answer(this.id)" class="btn btn-dim btn-primary">Yash!</a>
                                        <a id="notsure" onclick="return answer(this.id)" class="btn btn-dim btn-light">Emm...</a>
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

    <script type="text/javascript">
    function answer(type) {

        if (type == 'yaok') {
            $('#div_reg').hide();
            $('#div_ndah').hide();
            $('#div_ndah_nook').hide();
            $('#div_ndah_yaok').show();

        } else if ((type == 'nook') || (type == 'notsure')) {
            $('#div_reg').hide();
            $('#div_ndah').hide();
            $('#div_ndah_yaok').hide();

            $.ajax({
                method: 'post',
                url:  'register/sendCodeToMe',
                success: function (response) {
                    $('#div_ndah_nook').show();
                }
            });

        } else if (type == 'sure') {
            $('#div_reg').hide();
            $('#div_ndah').hide();
            $('#div_ndah_yaok').hide();
            $.ajax({
                method: 'post',
                url:  'register/sendCodeToMe2',
                success: function (response) {
                    Swal.fire({
                        title: "Alright",
                        text: "Please re-login. You already registered.",
                        // icon: "success"
                    }).then(function() {
                        window.location.href = 'https://ibsapps.ibstower.com';
                    });
                }
            });
            
        
        } 
    }

    </script>

</html>