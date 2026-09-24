////////////////////////////////////////// Create Request
$("#create_step_one").click(function (e) {
    e.preventDefault();

    var formType = $('#formType').val();

    if (formType == '') {
        alert('Please select form');
        return false;
    }

    $.ajax({
        url: 'form/initial_create/' + formType,
        type: "POST",
        dataType: "json",
        beforeSend: function () {
            $('.textCreateForm').html("Please wait..");
        },
        success: function (response) {
            /////////////////////////////////////////START Update source code Performance Appraisal 2024////////////////////////////////////////////
            if (response.status == 1) {
                $(".textCreateForm").html("Proceed");
                Swal.fire({
                  position: "top-end",
                  icon: "info",
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500,
                });
        
                if (formType != "KPI" && formType != "PLAN") {
                  window.location.href =
                    "form/detail/" + response.form + "/" + response.id;
                } else {
                  window.location.href =
                    "form/detailpa/" + response.form + "/" + response.id;
                }
            } else {
                if (response.status == 2) {
                  Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 4500,
                  });
                  // location.reload();
                } else if (response.status == 9) {
                  Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 4500,
                  });
                  return false;
                } else {
                  console.log(response);
                  alert("Oops, please refresh the page and try again.");
                }
            }
            /////////////////////////////////////////END Update source code Performance Appraisal 2024////////////////////////////////////////////
        },
        error: function (response) {
            $('.textCreateForm').html("Proceed");
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Something wrong. Please re-login and try again.',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
});

$("#submit_new_request").click(function (e) {
    e.preventDefault();

    // validation
    var kpi_departemen = $('#kpi_departemen').val();
    var atasan_langsung = $('#atasan_langsung').val();
    var sub_total_weight = parseFloat(document.getElementById("kpi_total_weight").value);
    var kpi_total_assesment = $('#kpi_total_assesment').val();
    var work_efficiency = $('#plan_score_1').val();
    var work_quality = $('#plan_score_2').val();
    var communication = $('#plan_score_3').val();
    var planing = $('#plan_score_4').val();
    var problem_solving = $('#plan_score_5').val();
    var team_work = $('#plan_score_6').val();
    var potential = $('#plan_score_7').val();
    var initiative = $('#plan_score_8').val();
    var leadership = $('#plan_score_9').val();
    var area_improvement = $('#area_improvement').val();
    var development_plan = $('#development_plan').val();
    var plan_total_weight = $('#plan_total_weight').val();
    var list = $('.approvalLayer').find(':selected');
    var countKpi = $('#countKpi').val();
    var countPlanFinancial = $('#countPlanFinancial').val();
    var countPlanCustomer = $('#countPlanCustomer').val();
    var countPlanInternal = $('#countPlanInternal').val();
    var countPlanLearning = $('#countPlanLearning').val();

    if ((countKpi < 3)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Minimum KPI Measurement rows are 3 rows.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((countKpi > 5)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Mximum KPI Measurement rows are 5 rows.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((countPlanFinancial > 2) || (countPlanCustomer > 2) || (countPlanInternal > 2) || (countPlanLearning > 2)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Check Performance Plan. Must be 2 rows on each perspective.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((atasan_langsung == '')) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Div Head / C-Level are required.',showConfirmButton: false, timer: 3000});
        return false;
    }


    if ((sub_total_weight > 100) || (sub_total_weight == '') || (sub_total_weight == '0')) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Total max weight must be 100.',showConfirmButton: false, timer: 3000});
        $('#alert_max_weight').show();
        return false;
    }

    if ((kpi_total_assesment == '') || (kpi_total_assesment == 'NaN') || (work_efficiency == '') || (work_quality == '') || (communication == '') || (planing == '') || (problem_solving == '') || (team_work == '') || (potential == '') || (initiative == '') || (leadership == '')) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Please complete Qualitative Assesment Score.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((area_improvement == '') || (development_plan == '')) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Area Improvement & Development Plan are required.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((list.length == '0')) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Please select approval layer.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((list.length > 2)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Max 2 layer approval.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((plan_total_weight == 0) || (plan_total_weight != 100)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Performance Plan total weight must be 100.',showConfirmButton: false, timer: 3000});
        $('#alert_plan_weight').show();
        return false;
    }

    var email = [];
    for (var i = 0; i < list.length; i++) {
        email.push(list[i].label);
    }

    var id = $('#id_request').val();
    var is_status = $('#is_status').val();
    var kpi_departemen = $('#kpi_departemen').val();
    var atasan_langsung = $('#atasan_langsung').val();
    var result_work_efficiency = $('#plan_result_1').val();
    var result_work_quality = $('#plan_result_2').val();
    var result_communication = $('#plan_result_3').val();
    var result_planing = $('#plan_result_4').val();
    var result_problem_solving = $('#plan_result_5').val();
    var result_team_work = $('#plan_result_6').val();
    var result_potential = $('#plan_result_7').val();
    var result_initiative = $('#plan_result_8').val();
    var result_leadership = $('#plan_result_9').val();
    var comment_employee = $('#comment_employee').val();
    var comment_head_1 = $('#comment_head_1').val();
    var comment_head_2 = $('#comment_head_2').val();
    var sub_total_kpi = $('#kpi_total_score').val();
    var sub_total_qualitative = $('#total_qualitative').val();
    var grand_total_kpi = $('#grand_total_kpi').val();
    var grand_total_qualitative = $('#grand_total_qualitative').val();
    var pre_final_score = $('#pre_final_score').val();
    var postData = {
        id: id,
        is_status: is_status,
        kpi_departemen: kpi_departemen,
        atasan_langsung: atasan_langsung,
        work_efficiency: work_efficiency,
        work_quality: work_quality,
        communication: communication,
        planing: planing,
        problem_solving: problem_solving,
        team_work: team_work,
        potential: potential,
        initiative: initiative,
        leadership: leadership,
        result_work_efficiency :result_work_efficiency,
        result_work_quality :result_work_quality,
        result_communication :result_communication,
        result_planing :result_planing,
        result_problem_solving :result_problem_solving,
        result_team_work :result_team_work,
        result_potential :result_potential,
        result_initiative :result_initiative,
        result_leadership :result_leadership,
        comment_employee: comment_employee,
        comment_head_1: comment_head_1,
        comment_head_2: comment_head_2,
        plan_total_weight: plan_total_weight,
        area_improvement: area_improvement,
        development_plan: development_plan,
        sub_total_weight:sub_total_weight,
        sub_total_kpi:sub_total_kpi,
        sub_total_qualitative:sub_total_qualitative,
        grand_total_kpi: grand_total_kpi,
        grand_total_qualitative: grand_total_qualitative,
        pre_final_score: pre_final_score,
        approval_layer: email,
    }

    // console.log(postData);
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "We will send an email notification to your first approval layer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/save/submit/KPI",
                type: 'post',
                data: postData,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {
                        swalWithBootstrapButtons.fire('Nice!', 'Your request has been submitted.', 'success')
                        window.location.href = 'home/request';

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        window.location.href = 'home/request';
                    }

                },
                error: function (response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops! There\'s something wrong. Please refresh the page and try again.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    window.location.href = 'home/request';
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })

});

$("#submit_new_employee").click(function (e) {
    e.preventDefault();

    // validation
    var kpi_departemen = $('#kpi_departemen').val();
    var atasan_langsung = $('#atasan_langsung').val();
    var plan_total_weight = $('#plan_total_weight').val();
    var list = $('.approvalLayer').find(':selected');
    var countPlanFinancial = $('#countPlanFinancial').val();
    var countPlanCustomer = $('#countPlanCustomer').val();
    var countPlanInternal = $('#countPlanInternal').val();
    var countPlanLearning = $('#countPlanLearning').val();

    if ((countPlanFinancial > 2) || (countPlanCustomer > 2) || (countPlanInternal > 2) || (countPlanLearning > 2)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Check Performance Plan. Must be 2 rows on each perspective.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((atasan_langsung == '')) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Div Head / C-Level are required.',showConfirmButton: false, timer: 3000});
        return false;
    }


    if ((list.length == '0')) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Please select approval layer.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((list.length > 2)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Max 2 layer approval.',showConfirmButton: false, timer: 3000});
        return false;
    }

    if ((plan_total_weight == 0) || (plan_total_weight != 100)) {
        Swal.fire({ position: 'top-end',icon: 'error', title: 'Performance Plan total weight must be 100.',showConfirmButton: false, timer: 3000});
        $('#alert_plan_weight').show();
        return false;
    }

    var email = [];
    for (var i = 0; i < list.length; i++) {
        email.push(list[i].label);
    }

    var id = $('#id_request').val();
    var is_status = $('#is_status').val();
    var kpi_departemen = $('#kpi_departemen').val();
    var atasan_langsung = $('#atasan_langsung').val();
    var postData = {
        id: id,
        is_status: is_status,
        kpi_departemen: kpi_departemen,
        atasan_langsung: atasan_langsung,
        plan_total_weight: plan_total_weight,
        approval_layer: email,
    }

    // console.log(postData);
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "We will send an email notification to your first approval layer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/save/submit_new_employee/PLAN",
                type: 'post',
                data: postData,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {
                        swalWithBootstrapButtons.fire('Nice!', 'Your request has been submitted.', 'success')
                        window.location.href = 'home/request';

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        window.location.href = 'home/request';
                    }

                },
                error: function (response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops! There\'s something wrong. Please refresh the page and try again.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    window.location.href = 'home/request';
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })

});

// Add Approval Layer
$(document).ready(function () {
    var i = 0;
    $('#add').click(function (e) {
        e.preventDefault();
        i++;
        $.ajax({
            url: 'list/request/getUserList',
            datatype: 'json',
            type: "post",
            beforeSend: function () {
                $('#addLayerText').hide();
                $('#loadLayerSpinner').show();
            },
            success: function (data) {

                $('#addLayerText').show();
                $('#loadLayerSpinner').hide();
                // console.log(JSON.parse(data));

                var row = '';
                row = '<div class="card-inner card-inner-md" id="row' + i + '"><div class="user-card"><div class="user-avatar bg-primary-dim"><span><em class="icon ni ni-downward-ios"></em></span></div><div class="user-info"><div class="form-group"><div class="form-control-wrap" style="width:300px;"><select class="form-control form-control-md approval approvalLayer" data-search="on" id="emailUsers' + i + '" name="email[]" required><option values=""></option></select></div></div></div><div class="user-action"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-remove"></i>Remove</button></div></div></div>';
                $('#dynamic_field').append(row);
                $.each(JSON.parse(data), function (key, value) {
                    $('#emailUsers' + i).append($("<option></option>").attr("value", value.user_email).text(value.user_email));
                    $('#emailUsers' + i).select2();
                });
            }
        });
    });

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
});

// Update Layer
$(document).ready(function () {
   
    var base_url = window.location.origin;

    $('#add_update_layer').click(function () {

        var i = $('#appPrior').val();
        i++;
        $.ajax({
            url: 'form/getUserList',
            datatype: 'json',
            type: "get",
            beforeSend: function () {
                $('#updateLayerText').hide();
                $('#loadLayerSpinner').show();
            },
            success: function (data) {
                
                $('#updateLayerText').show();
                $('#loadLayerSpinner').hide();

                var row = '';
                row = '<tr id="row' + i + '" class="dynamic-added"><td style="width: 100%;"><div class="form-group"><div class="option-group"><select class="form-control approvalLayer" id="emailUsers' + i + '" name="email[]" required><option values=""></option></select></div></div ></td><td style="width: 20%;"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-remove"></i>Remove</button></td></tr>';
                $('#update_layer').append(row);
                $.each(JSON.parse(data), function (key, value) {
                    $('#emailUsers' + i).append($("<option></option>").attr("value", value.user_email).text(value.user_email));
                    $('#emailUsers' + i).select2();
                });

                $('#appPrior').val(i);
            }
        });
    });

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
});

$("#eapp-pullback").click(function (e) {
    e.preventDefault();
    var id = $('#id_request').val();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "Approval will be reset!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Reset approval.',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/pullBack",
                type: 'post',
                data: 'id=' + id,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {
                        swalWithBootstrapButtons.fire('Allright', 'Your request has been canceled.', 'success')
                        window.location.href = 'home/request';

                    } else {
                        swalWithBootstrapButtons.fire('error', response.message, 'error')
                        window.location.href = 'home/request';
                    }

                },
                error: function (response) {
                    alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                    window.location.href = 'home/request';
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })
});

// RESPONSE
$("#eapp-approvedMDCR").click(function (e) {

    var id = $('#id_request').val();
    var request_number = $('#request_number').val();
    //alert(id);
    //return false;
    e.preventDefault();

    var timer = setInterval(function () {
        var count = parseInt($('#myTimer').html());
        if (count !== 0) {
            $('#myTimer').html(count - 1);
        } else {
            clearInterval(timer);
            $("#divResendCode").show();
            $("#textTimer").hide();
        }
    }, 1000);


    $.ajax({
        url: "login/sendotpMDCR/send/sms",
        type: 'post',
        data: { id: id },
        success: function (response) {

            if (response == 1) {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: '<strong>We need to verify it\'s you.</strong>',
                    icon: 'question',
                    html: '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><b>6 digit code has been sent to your phone number.</b></center><br>' +
                        '<center><b>OTP code valid until this window is closed.</b></center>' +
                        '<center><b>If you do resend and have more than one messages, use the last one.</b></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="d-flex justify-content-center">' +
                        '<div class="col-md-8"></div>' +
                        '<div class="col-md-6">' +
                        '<input class="form-control form-control-lg" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return validateCodeApprovedMDCR();" maxlength="6" min="1" max="999" id="otp_code" />' +
                        '</div>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><h6><b>You\'re going to approve</b></h6></center><br>' +
                        '<center><h6><b>' + request_number + '</b></h6></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="divResendCode" style="display:none;">' +
                        '<button type="button" class="btn btn-dim btn-sm btn-outline-success" onclick="return OTPmdcrResend()" id="eapp-approvedMDCR"> Resend code</button>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="textTimer" style="display:show;">' +
                        '<div class="d-flex justify-content-center">' +
                        '<center><h6><b>The resend button will be enable in:</b></h6><b><span id="myTimer">45</span></b></center>' +
                        '</div>' +
                        '</div>' +
                        '</div><br>' +
                        '<hr>',
                    showCloseButton: false,
                    showCancelButton: true,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: false,
                    confirmButtonText: '<i class="fa fa-check-square-o"> Confirm</i>',
                    confirmButtonAriaLabel: 'Confirm',
                    cancelButtonText: 'Cancel',
                    cancelButtonAriaLabel: 'Cancel',
                })
            
            } else {
                alert('There\'s something wrong, it might be slow network or expired user session. Please refresh the page and try again');
            }
        }

    });

});

function validateCodeApprovedMDCR() {
    //e.preventDefault();
    var request_id = $('#id_request').val();
    // var approval_id = $('#approval_id').val();
    // var request_number = $('#request_number').val();
    var otp = $('#otp_code').val();
    //return false;

    $.ajax({
        url: "login/validateMDCR/Approved",
        type: 'post',
        data: { request_id: request_id, otp : otp },
        dataType: 'json',
        success: function (response) {

            if (response.status == 1) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1000
                });
                window.location.href = "dashboard";

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 5000
                });
                window.location.href = "inbox/approval";

            }

        },
        error: function (response) {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'There\'s something wrong, it might be slow network or expired user session. Please refresh the page or try again later.',
                showConfirmButton: false,
                timer: 3500
            });
        }
    });
}


function responseRequest(type) {
    
    var id = $('#request_id').val();
    //return false;
    // alert();
    // alert(type);
    if(type == 'Revised' || type == 'Reject'){
      // if ($('#new-response-notes').val() == '' || $('#new-response-notes').val() == null) {
      //   Swal.fire({
      //     position: 'center',
      //     icon: 'warning',
      //     title: 'Dimohon untuk mengisi note',
      //     showConfirmButton: false,
      //     timer: 1500
      //   });

      // } else {
        var url = 'inbox/cekNote'
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            data: { id : id },
            success: function (data) {
              if (data == true) {
                
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light'
                    },
                    buttonsStyling: false
                })
            
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    //text: "Revise this request",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, sure.',
                    cancelButtonText: 'Cancel.',
                    reverseButtons: true,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "inbox/responseRequest",
                            type: 'post',
                            data: 'id=' + id + '&resp=' + type,
                            dataType: 'json',
                            success: function (response) {
            
                                if (response.status == 1) {
            
                                    window.location.href = 'inbox/approval';
                                    swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success')
            
                                } else {
                                    swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
                                }
                                
                            },
                            error: function (response) {
                                alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire('Cancelled','Action has been cancelled.','success')
                    }
                })

              }else{

                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Dimohon untuk mengisi note',
                    showConfirmButton: false,
                    timer: 1500
                  });

              }
            },
            error: function (data) {
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Data tidak dapat diproses',
                showConfirmButton: false,
                timer: 1500
              });
            }
        });

      // }

    }else{

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light'
            },
            buttonsStyling: false
        })
    
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            //text: "Revise this request",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, sure.',
            cancelButtonText: 'Cancel.',
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "inbox/responseRequest",
                    type: 'post',
                    data: 'id=' + id + '&resp=' + type,
                    dataType: 'json',
                    success: function (response) {
    
                        if (response.status == 1) {
    
                            window.location.href = 'inbox/approval';
                            swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success')
    
                        } else {
                            swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
                        }
                        
                    },
                    error: function (response) {
                        alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled','Action has been cancelled.','success')
            }
        })

    }

    
}

function responseDivision(type) {
    var url = '';
    var redirect = '';

    if ((type == 'Revised')) {
        var performance_division_id = $('#performance_division_id').val();
        url = "inbox/save/"+type+"/"+performance_division_id;
        rdr = 'inbox/hr_division';
        msg = 'This division PA has been revised to it\'s Division Head.';
        title = "Revised!";

    } else if ((type == 'Confirm')) {
        var performance_division_id = $('#performance_division_id').val();
        url = "inbox/save/"+type+"/"+performance_division_id;
        rdr = 'inbox/hr_division';
        msg = 'This division PA has been moved to Confirmed PA & Plan.';
        title = "Confirmed successfully!";

    } else if ((type == 'submit_to_hr_mgmt')) {
        url = "inbox/save/submit_to_hr";
        rdr = 'dashboard/mgmt';
        msg = 'Your division PA has been submitted.';
        title = "Success!";

    } else if ((type == 'submit_to_hr_second_division_mgmt')) {
        url = "inbox/save/submit_to_hr_second_division";
        rdr = 'dashboard/mgmt';
        msg = 'Your division PA has been submitted.';
        title = "Success!";

    } else if ((type == 'submit_to_hr_ops')) {
        url = "inbox/save/submit_to_hr_ops";
        rdr = 'dashboard/c_view/Regional%20Central';
        msg = 'Your division PA has been submitted.';
        title = "Success!";

    } else {
        url = "inbox/save/"+type;
        rdr = 'inbox/mgmt';
        msg = 'Your division PA has been submitted.';
        title = "Success";
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure.',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {

                        Swal.fire({
                            title: title,
                            text: msg,
                            icon: "success"
                        }).then(function() {
                            window.location.href = rdr;
                        });


                    } else {
                        swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
                    }
                    
                },
                error: function (response) {
                    alert('Oops! There\'s something wrong. Please refresh this page and try again.');
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled','Action has been cancelled.','success')
        }
    })
}

function save_response_notes() {
  // alert();
    if (($('#response-notes').val() == "")) {
        return false;
    }

    var base_url = window.location.origin;
    var id = $('#id_request').val();
    var approval_id = $('#approval_id').val();
    var notes = $('#response-notes').val();
    var form_type = $('#form_type-note').val();
    if ($("#is-revise").val() == 1) {
      var type = 1;
    } else {
      var type = null;
    } 
    
    var postData = {
        request_id: id,
        approval_id: approval_id,
        notes: notes,
        form_type: form_type,
        type: type
    }
    $.ajax({
        method: 'post',
        url:  '/inbox/save/notes',
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
            $('#text-notes-response').html('Please wait...');
        },
        success: function (response) {
            
            $('#text-notes-response').html('Save');
            
            if (response.status == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.messages,
                    showConfirmButton: false,
                    timer: 1500
                });
                // window.location.href = 'inbox/view/' + response.id;
                
                $('#modalAddNotes').modal('toggle');
                location.reload();

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: response.messages,
                    showConfirmButton: false,
                    timer: 5000
                });
            }
        }
    });
}

function delete_notes(id) {
    var id_request = $('#id_request').val();

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure!',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {

        if (result.value) {
            $.ajax({
                method: 'post',
                url: 'inbox/delete_notes/' + id + '/' + id_request,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        location.reload();
                        // window.location.href = 'inbox/view/' + response.id;

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                },
                error: function (response) {
                    alert('Oops! Internal error. Please refresh this page and try again.');
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })
}


function delete_draft(id) {

    if ((id == '')) {
        alert('Please refresh the page and try again.');
        return false;
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure!',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: 'post',
                url: 'home/request/delete/' + id,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 1) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 5000
                        });

                        window.location.href = 'home/request/';

                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                },
                error: function (response) {
                    alert('Oops! Internal error. Please refresh this page and try again.');
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })
}

function copyToClipboard(text) {
    var sampleTextarea = document.createElement("textarea");
    document.body.appendChild(sampleTextarea);
    sampleTextarea.value = text; //save main text in it
    sampleTextarea.select(); //select textarea contenrs
    document.execCommand("copy");
    document.body.removeChild(sampleTextarea);
}

function copy_reqnum(){
    var copyText = document.getElementById("copy_reqnum");
    copyToClipboard(copyText.value);
}

/////////////////////////////// FORM PERFORMANCE APPRAISAL (KPI)
// Add Item KPI
$("#add_item_kpi").click(function (e) {
    e.preventDefault();
    var id = $('#id_request').val();
    var countKpi = parseInt($('#countKpi').val());
    var totalRowKpi = parseInt(countKpi + 1);

    var objective = document.getElementById("kpi_objective").value;
    var measurement = document.getElementById("kpi_measurement").value;
    var target = document.getElementById("kpi_target").value;
    var achievement = document.getElementById("kpi_achievement").value;
    var target_vs_achievement = document.getElementById("kpi_target_vs_achievement").value;

    var score = document.getElementById("kpi_score").value;
    var time = parseFloat(document.getElementById("kpi_time").value);
    var total_row = parseFloat(document.getElementById("kpi_total").value);

    var current_total_weight = parseFloat(document.getElementById("kpi_total_weight").value);
    var current_total_kpi = parseFloat(document.getElementById("kpi_total_score").value);

    var total_weight = parseFloat(time + current_total_weight);
    var kpi = parseFloat(total_row + current_total_kpi);
    var total_kpi = parseFloat(kpi).toFixed(3);

    // pre final score
    var grand_total_kpi = total_kpi * (85/100);
    var roundGrandKPI = grand_total_kpi.toFixed(3);
    var grand_total_qualitative = parseFloat($('#grand_total_qualitative').val());
    var pre_final_score = parseFloat(grand_total_qualitative + grand_total_kpi);
    var roundFinalScore = pre_final_score.toFixed(3);

    if ((score > 10)) {
        alert('Please enter Score value less than or equal to 10.');
        return false;
    }

    if ((time > 100)) {
        alert('Please enter Weight value less than or equal to 100.');
        return false;
    }

    if ((objective.length == '') 
        || (measurement.length == '') 
        || (target.length == '') 
        || (achievement.length == '') 
        || (target_vs_achievement.length == '') 
        || (score == '')
        || (time == '') 
        || (total_row == '0')
        ) {

        alert('All field is required.');
        return false;

    } else {

        var postData = {
            request_id: id,
            kpi_objective: objective,
            kpi_measurement: measurement,
            kpi_target: target,
            kpi_achievement: achievement,
            kpi_target_vs_achievement : target_vs_achievement,
            kpi_score : score,
            kpi_time : time,
            kpi_total_row : total_row,
            total_weight : total_weight,
            total_kpi : total_kpi,
            grand_total_kpi : roundGrandKPI,
            grand_total_qualitative : grand_total_qualitative,
            pre_final_score : roundFinalScore,
        }

        $.ajax({
            method: 'post',
            url: 'form/save/add_kpi',
            data: postData,
            dataType: 'json',
            success: function (response) {

                if (response.status == 1) {

                    var table = document.getElementById("table_kpi_achievement");
                    var table_len = (table.rows.length) - 1;
                    var row = table.insertRow(table_len).outerHTML = "<tr id='kpi_row-" + response.id + "'>"+
                                                                    "<td><a onclick='delete_kpi_row(" + response.id + ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-cross-circle-fill'></em></a><br><a onclick='update_kpi_row(" + response.id + ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-edit'></em></a></td>"+
                                                                    "<td id='kpi_objective_row" +  response.id + "'><textarea disabled class='form-control' id='kpi_row_objective-" +  response.id + "' >" + objective + "</textarea></td>"+
                                                                    "<td id='kpi_measurement_row" +  response.id + "'><textarea disabled class='form-control' id='kpi_row_measurement-" +  response.id + "' >" + measurement + "</textarea></td>"+
                                                                    "<td id='kpi_target_row" +  response.id + "'><span id='kpi_row_target_per_year-" +  response.id + "'> " + target + "</span></td>"+
                                                                    "<td id='kpi_achievement_row" +  response.id + "'><span id='kpi_row_achievement-" +  response.id + "'> " + achievement + "</span></td>"+
                                                                    "<td id='kpi_target_vs_achievement_row" +  response.id + "'><span id='kpi_row_target_vs_achievement-" +  response.id + "'> " + target_vs_achievement + "</span></td>"+
                                                                    "<td id='kpi_score_row" +  response.id + "'><span id='kpi_row_score-" +  response.id + "'> " + score + "</span></td>"+
                                                                    "<td id='kpi_row_time-" +  response.id + "'><b id='kpi_row_time-" +  response.id + "'> " + time + "</b></td>"+
                                                                    "<td id='kpi_row_total-" +  response.id + "'><b id='kpi_row_total-" +  response.id + "'> " + total_row + "</b></td>"+
                                                                    "</tr>";
                    document.getElementById("kpi_objective").value = "";
                    document.getElementById("kpi_measurement").value = "";
                    document.getElementById("kpi_target").value = "";
                    document.getElementById("kpi_achievement").value = ""; 
                    document.getElementById("kpi_target_vs_achievement").value = "";
                    document.getElementById("kpi_score").value = "";
                    document.getElementById("kpi_time").value = "";
                    document.getElementById("kpi_total").value = "";

                    $('#countKpi').val(totalRowKpi);
                    $('#kpi_total_weight').val(total_weight);
                    $('#kpi_total_score').val(total_kpi);

                    $('#total_kpi_score').val(total_kpi);
                    $('#grand_total_kpi').val(roundGrandKPI);
                    $('#pre_final_score').val(roundFinalScore);

                    if (total_weight > 100) {
                        $('#alert_max_weight').show();
                    } else {
                        $('#alert_max_weight').hide();
                    }

                } else {
                   alert('Something went wrong. Please try again.');
                }
            }
        });
    }

});

function delete_kpi_row(id) {
    
    var request_id = $('#id_request').val();
    var countKpi = parseInt($('#countKpi').val());
    var totalRowKpi = parseInt(countKpi - 1);

    var kpi_row_time = $('#kpi_row_time-'+id).text();
    var kpi_row_total = $('#kpi_row_total-'+id).text();
    var current_total_weight = $('#kpi_total_weight').val();
    var current_total_kpi = $('#kpi_total_score').val();
    var kpi = parseFloat(current_total_kpi - kpi_row_total);
    var total_kpi = parseFloat(kpi).toFixed(3);
    var total_weight = parseFloat(current_total_weight - kpi_row_time);

    // pre final score
    var pre_final_score = parseFloat($('#pre_final_score').val());
    var grand_total_qualitative = parseFloat($('#grand_total_qualitative').val());
    var grand_total_kpi = total_kpi * (85/100);
    var roundGrandKPI = grand_total_kpi.toFixed(3);
                    
    var new_pre_final_score = parseFloat(grand_total_qualitative + grand_total_kpi);
    var roundFinalScore = new_pre_final_score.toFixed(3);

    var postData = {
        measurement_id: id, 
        request_id: request_id, 
        total_kpi: total_kpi, 
        total_weight: total_weight, 
        grand_total_qualitative: grand_total_qualitative, 
        grand_total_kpi: roundGrandKPI, 
        pre_final_score: roundFinalScore, 
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove!',
        cancelButtonText: 'No.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/delete/kpi_item",
                type: 'post',
                data: postData,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {

                        document.getElementById("kpi_row-" + id + "").outerHTML = "";
                        $('#kpi_total_weight').val(total_weight);
                        $('#kpi_total_score').val(total_kpi); // total kpi per row

                        $('#total_kpi_score').val(total_kpi); // sub total kpi
                        $('#grand_total_kpi').val(roundGrandKPI); // grand total kpi
                        $('#pre_final_score').val(roundFinalScore); 

                        $('#countKpi').val(totalRowKpi);
                        
                        if (total_weight > 100) {
                            $('#alert_max_weight').show();
                        } else {
                            $('#alert_max_weight').hide();
                        }

                        swalWithBootstrapButtons.fire('Removed!', 'Deleted', 'success')

                    } else {
                        swalWithBootstrapButtons.fire('error', 'Something went wrong.', 'error')
                    }

                },
                error: function (response) {
                    alert('Oops! There\'s something wrong. Please refresh this page and try again.');
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })

}

function update_kpi_row(id) {

    $('#id_detail_update').val(id);
    var objective = $('#kpi_row_objective-'+id).text();
    var measurement = $("#kpi_row_measurement-"+id).text();
    var target = $("#kpi_row_target_per_year-"+id).text();
    var achievement = $("#kpi_row_achievement-"+id).text();
    var target_vs_achievement = $("#kpi_row_target_vs_achievement-"+id).text();
    var score = $("#kpi_row_score-"+id).text();
    var time = parseFloat($("#kpi_row_time-"+id).text());
    var total_row = parseFloat($("#kpi_row_total-"+id).text());

    $('#update_kpi_objective').val(objective);
    $('#update_kpi_measurement').val(measurement);
    $('#update_kpi_target').val(target);
    $('#update_kpi_achievement').val(achievement);
    $('#update_kpi_target_vs_achievement').val(target_vs_achievement);
    $('#update_kpi_score').val(score);
    $('#update_kpi_time').val(time);
    $('#update_kpi_total').val(total_row);

    $('#modalUpdateKPI').modal('toggle');
}

$("#update_item_kpi").click(function (e) {
    e.preventDefault();
    
    var id = $('#id_request').val();
    var id_detail = $('#id_detail_update').val();

    var objective = document.getElementById("update_kpi_objective").value;
    var measurement = document.getElementById("update_kpi_measurement").value;
    var target = document.getElementById("update_kpi_target").value;
    var achievement = document.getElementById("update_kpi_achievement").value;
    var target_vs_achievement = document.getElementById("update_kpi_target_vs_achievement").value;
    var score = document.getElementById("update_kpi_score").value;

    // before update
    var previous_time = parseFloat($("#kpi_row_time-"+id_detail).text());
    var previous_total_row = parseFloat($("#kpi_row_total-"+id_detail).text());
    var previous_total_weight = parseFloat(document.getElementById("kpi_total_weight").value);
    var previous_total_kpi = parseFloat(document.getElementById("kpi_total_score").value);
    var total_weight = parseFloat(previous_total_weight - previous_time);
    var total_kpi = parseFloat(previous_total_kpi - previous_total_row);

    // start update
    var new_time = parseFloat(document.getElementById("update_kpi_time").value);
    var new_total_row = parseFloat(document.getElementById("update_kpi_total").value);
    var new_total_weight = parseFloat(new_time + total_weight);
    var kpi = parseFloat(new_total_row + total_kpi);
    var new_total_kpi = parseFloat(kpi).toFixed(3);

    // pre final score
    var pre_final_score = parseFloat($('#pre_final_score').val());
    var grand_total_qualitative = parseFloat($('#grand_total_qualitative').val());
    var grand_total_kpi = new_total_kpi * (85/100);
    var roundGrandKPI = grand_total_kpi.toFixed(3);
                    
    var new_pre_final_score = parseFloat(grand_total_qualitative + grand_total_kpi);
    var roundFinalScore = new_pre_final_score.toFixed(3);

    if ((score > 10)) {
        alert('Please enter Score value less than or equal to 10.');
        return false;
    }

    if ((new_time > 100)) {
        alert('Please enter Weight value less than or equal to 100.');
        return false;
    }

    if ((objective.length == '') 
        || (measurement.length == '') 
        || (target.length == '') 
        || (achievement.length == '') 
        || (target_vs_achievement.length == '') 
        || (score == '')
        || (new_time == '') 
        || (new_total_row == '0')
        ) {

        alert('All field is required.');
        return false;

    } else {

        var postData = {
            request_id: id,
            id_detail: id_detail,
            kpi_objective: objective,
            kpi_measurement: measurement,
            kpi_target: target,
            kpi_achievement: achievement,
            kpi_target_vs_achievement : target_vs_achievement,
            kpi_score : score,
            kpi_time : new_time,
            kpi_total_row : new_total_row,
            total_weight : new_total_weight,
            total_kpi : new_total_kpi,
            grand_total_qualitative: grand_total_qualitative, 
            grand_total_kpi: roundGrandKPI, 
            pre_final_score: roundFinalScore, 
        }

        $.ajax({
            method: 'post',
            url: 'form/save/update_kpi',
            data: postData,
            dataType: 'json',
            success: function (response) {

                if (response.status == 1) {

                    document.getElementById("update_kpi_objective").value = "";
                    document.getElementById("update_kpi_measurement").value = "";
                    document.getElementById("update_kpi_target").value = "";
                    document.getElementById("update_kpi_achievement").value = ""; 
                    document.getElementById("update_kpi_target_vs_achievement").value = "";
                    document.getElementById("update_kpi_score").value = "";
                    document.getElementById("update_kpi_time").value = "";
                    document.getElementById("update_kpi_total").value = "";

                    $('#kpi_row_objective-'+id_detail).text(objective);
                    $('#kpi_row_measurement-'+id_detail).text(measurement);
                    $('#kpi_row_target_per_year-'+id_detail).text(target);
                    $('#kpi_row_achievement-'+id_detail).text(achievement);
                    $('#kpi_row_target_vs_achievement-'+id_detail).text(target_vs_achievement);
                    $('#kpi_row_score-'+id_detail).text(score);
                    $('#kpi_row_time-'+id_detail).text(new_time);
                    $('#kpi_row_total-'+id_detail).text(new_total_row);

                    $('#kpi_total_weight').val(new_total_weight);
                    $('#kpi_total_score').val(new_total_kpi);

                    // calculate total
                    $('#total_kpi_score').val(new_total_kpi); // sub total kpi
                    $('#grand_total_kpi').val(roundGrandKPI); // grand total kpi
                    $('#pre_final_score').val(roundFinalScore); 

                    if (new_total_weight > 100) {
                        $('#alert_max_weight').show();
                    } else {
                        $('#alert_max_weight').hide();
                    }

                    $('#modalUpdateKPI').modal('toggle');

                } else {
                   alert('Something went wrong. Please try again.');
                }
            }
        });
    }

});

function calculate_kpi_item(id)
{
    var kpi_score = $('#kpi_score').val();
    var kpi_time = $('#kpi_time').val();
    var total = kpi_score * (kpi_time/100);
    var roundTotal = total.toFixed(3);
    $('#kpi_total').val(roundTotal);
}

function calculate_update_kpi(id)
{
    var kpi_score = $('#update_kpi_score').val();
    var kpi_time = $('#update_kpi_time').val();
    var total = kpi_score * (kpi_time/100);
    var roundTotal = total.toFixed(3);
    $('#update_kpi_total').val(roundTotal);
}

// Qualitative
function calculate_assesment(id)
{
    var plan_weight = $('#plan_weight_'+id).val();
    var plan_score = $('#plan_score_'+id).val();
    var total = plan_score * (plan_weight/100);
    var roundTotal = total.toFixed(3);
    $('#plan_result_'+id).val(roundTotal);
    $('#tb_plan_result_'+id).text(roundTotal);

    if ((plan_score > 10)) {
        $('#tr_'+id).css('color', '#fff');
        $('#tr_'+id).css('background', 'red');
        $('#alert_plan_'+id).show();
    } else {
        $('#tr_'+id).css('color', '');
        $('#tr_'+id).css('background', '');
        $('#alert_plan_'+id).hide();
    }

    calculate_assesment_total();
}

function calculate_assesment_total()
{
    var total_1 = parseFloat($('#plan_result_1').val());
    var total_2 = parseFloat($('#plan_result_2').val());
    var total_3 = parseFloat($('#plan_result_3').val());
    var total_4 = parseFloat($('#plan_result_4').val());
    var total_5 = parseFloat($('#plan_result_5').val());
    var total_6 = parseFloat($('#plan_result_6').val());
    var total_7 = parseFloat($('#plan_result_7').val());
    var total_8 = parseFloat($('#plan_result_8').val());
    var total_9 = parseFloat($('#plan_result_9').val());

    var subtotal = parseFloat(total_1 + total_2 + total_3 + total_4 + total_5 + total_6 + total_7 + total_8 + total_9);

    var total_assesment = parseFloat(subtotal).toFixed(3);
    $('#kpi_total_assesment').val(total_assesment);
    $('#total_qualitative').val(total_assesment);

    var grand_total = total_assesment * (15/100);
    var roundGrandTotal = grand_total.toFixed(3);
    $('#grand_total_qualitative').val(roundGrandTotal);

    // pre final score
    var grand_total_kpi = parseFloat($('#grand_total_kpi').val());
    var pre_final_score = parseFloat(grand_total_kpi + grand_total);
    var roundFinalScore = pre_final_score.toFixed(3);
    $('#pre_final_score').val(roundFinalScore);
}

function calculate_pre_final_score()
{
    var grand_total_kpi = parseFloat($('#grand_total_kpi').val());
    var grand_total_qualitative = parseFloat($('#grand_total_qualitative').val());
    var pre_final_score = parseFloat(grand_total_qualitative + grand_total_kpi);
    var roundFinal = pre_final_score.toFixed(3);

    var postData = {
        grand_total_kpi:grand_total_kpi,
        grand_total_qualitative:grand_total_qualitative,
        pre_final_score:roundFinal,
    }

    $.ajax({
        method: 'post',
        url: 'form/save/pre_final_score',
        data: postData,
        dataType: 'json',
        success: function (response) {

            if (response.status == 1) {
                $('#pre_final_score').val(roundFinal);

            } else {
                alert('Something went wrong. Please try again.');
            }
        }
    });
    
}

function calculate_final_score()
{
    var grade = '';
    var score = $('#final_score').val();
    if (score == '') {
    	$('#grade').text('');
    	return false;
    }

    var final_score = parseFloat($('#final_score').val());
    // var final_score = x_final_score.toFixed(1);
    
    if ((final_score >= '9.1') || (final_score == '10.0')) {
    	grade = 'A';
    } else if ((final_score >= '8.1') && (final_score < '9.1')) {
    	grade = 'B';
    } else if ((final_score >= '6.9') && (final_score < '8.1')) {
    	grade = 'C';
    } else if ((final_score >= '5.6') && (final_score < '6.9')) {
    	grade = 'D';
   	} else if ((final_score >= '0.0') && (final_score < '5.6')) {
   		grade = 'E';
    } else {
    	grade = '';
    }

    if ((final_score > 10)) {
        $('#tr_final_score').css('color', '#fff');
        $('#tr_final_score').css('background', 'red');
        $('#alert_fs').show();

    } else {
        $('#tr_final_score').css('color', '');
        $('#tr_final_score').css('background', '');
        $('#alert_fs').hide();

	    $('#grade').text(grade);
    }
}

function save_final_score()
{
    var id = $('#req_id_modal').val();
    var score = $('#final_score').val();
    if (score == '') {
        $('#tr_final_score').css('color', '#fff');
        $('#tr_final_score').css('background', 'red');
        $('#alert_fs').show();
        $('#grade').text('');
    	return false;

    } else {
        $('#tr_final_score').css('color', '');
        $('#tr_final_score').css('background', '');
        $('#alert_fs').hide();
    }

    var final_score = parseFloat($('#final_score').val());
    var postData = {
        id: id,
        final_score: final_score,
    }

    $.ajax({
        method: 'post',
        url: 'inbox/save/final_score',
        data: postData,
        dataType: 'json',
        beforeSend: function () {
        	$('#update-final').text('Please wait..');
        },
        success: function (response) {

            if (response.status == 1) {
            	$('#update-final').text('Done.');

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Final Score updated successfully.',
                    showConfirmButton: false,
                    timer: 1000
                });

                $('#modalQuickView').modal('toggle');
                window.location.href = "dashboard/c";
                // window.location.href = "inbox/mgmt";


            } else {
                alert('Something went wrong. Please try again.');
            }
        }
    });
    
}

// Performance Plan
function modal_add_plan(type)
{
    if (type == 'f') {
        $('#title_modal_plan').text('Financial Perspective');
        $('#table_type').val('financial_perspective');
    } else if (type == 'c') {
        $('#title_modal_plan').text('Customers Perspective');
        $('#table_type').val('cust_perspective');
    } else if (type == 'i') {
        $('#title_modal_plan').text('Internal Process Perspective');
        $('#table_type').val('intern_perspective');
    } else if (type == 'l') {
        $('#title_modal_plan').text('Learning & Growth Perspective');
        $('#table_type').val('learn_perspective');
    }

    $('#modalAddPlan').modal('toggle');
}

$("#add_plan").click(function (e) {
    e.preventDefault();
    var id = $('#id_request').val();
    var count_fin = parseInt($('#countPlanFinancial').val());
    var count_cust = parseInt($('#countPlanCustomer').val());
    var count_int = parseInt($('#countPlanInternal').val());
    var count_learn = parseInt($('#countPlanLearning').val());

    var total_count_fin = parseInt(count_fin + 1);
    var total_count_cust = parseInt(count_cust + 1);
    var total_count_int = parseInt(count_int + 1);
    var total_count_learn = parseInt(count_learn + 1);

    var type = $('#table_type').val();
    var objective = document.getElementById("plan_objective").value;
    var measurement = document.getElementById("plan_measurement").value;
    var time = parseFloat(document.getElementById("plan_time").value);
    var unit = document.getElementById("plan_unit").value;
    var target = document.getElementById("plan_target").value;
    var semester_1 = document.getElementById("plan_semester_1").value;
    var semester_2 = document.getElementById("plan_semester_2").value;
    var total = document.getElementById("plan_total").value;
    var current_total_weight = parseFloat(document.getElementById("plan_total_weight").value);
    var total_weight = parseFloat(time + current_total_weight);

    if ((time > 100)) {
        alert('Please input weight value less than or equal to 100');
        return false;
    }

    if ((objective == '') 
        || (measurement == '') 
        || (time == '') 
        || (unit == '') 
        || (target == '') 
        || (semester_1 == '')
        || (semester_2 == '') 
        || (total == '')
        ) {

        alert('All field is required.');
        return false;

    } else {

        var postData = {
            request_id: id,
            objective: objective,
            measurement: measurement,
            time: time,
            unit: unit,
            target : target,
            semester_1 : semester_1,
            semester_2 : semester_2,
            total : total,
            plan_perspective : type,
            plan_total_weight : total_weight,
        }

        $.ajax({
            method: 'post',
            url: 'form/save/add_plan',
            data: postData,
            dataType: 'json',
            success: function (response) {

                if (response.status == 1) {

                    var table = document.getElementById(type);
                    var table_len = (table.rows.length) - 1;
                    var row = table.insertRow(table_len).outerHTML = "<tr id='plan_row-" + response.id + "'>"+
                                                                    "<td><a onclick='delete_plan_row(" + response.id + ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-cross-circle-fill'></em></a><br><a onclick='modal_update_plan(" + response.id + "," + type + ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-edit'></em></a></td>"+
                                                                    "<td id='plan_row_objective" +  response.id + "'><textarea disabled class='form-control' id='kpi_plan_objective-" +  response.id + "' >" + objective + "</textarea></td>"+
                                                                    "<td id='plan_row_measurement" +  response.id + "'><textarea disabled class='form-control' id='kpi_plan_measurement-" +  response.id + "' >" + measurement + "</textarea></td>"+
                                                                    "<td id='plan_row_time" +  response.id + "'><span id='kpi_plan_time-" +  response.id + "'> " + time + "</span></td>"+
                                                                    "<td id='plan_row_unit" +  response.id + "'><span id='kpi_plan_unit-" +  response.id + "'> " + unit + "</span></td>"+
                                                                    "<td id='plan_row_target" +  response.id + "'><span id='kpi_plan_target-" +  response.id + "'> " + target + "</span></td>"+
                                                                    "<td id='plan_row_semester_1" +  response.id + "'><span id='kpi_plan_semester_1-" +  response.id + "'> " + semester_1 + "</span></td>"+
                                                                    "<td id='plan_row_plan_semester_2" +  response.id + "'><span id='kpi_plan_semester_2-" +  response.id + "'> " + semester_2 + "</span></td>"+
                                                                    "<td id='plan_row_total-" +  response.id + "'><b id='kpi_plan_total-" +  response.id + "'> " + total + "</b></td>"+
                                                                    "</tr>";

                    document.getElementById("plan_objective").value = "";
                    document.getElementById("plan_measurement").value = "";
                    document.getElementById("plan_time").value = "";
                    document.getElementById("plan_unit").value = ""; 
                    document.getElementById("plan_target").value = "";
                    document.getElementById("plan_semester_1").value = "";
                    document.getElementById("plan_semester_2").value = "";
                    document.getElementById("plan_total").value = "";

                    $('#plan_total_weight').val(total_weight);
                    $('#modalAddPlan').modal('toggle');

                    if (type == 'financial_perspective') {
                        $('#countPlanFinancial').val(total_count_fin);
                    } else if (type == 'cust_perspective') {
                        $('#countPlanCustomer').val(total_count_cust);
                    } else if (type == 'intern_perspective') {
                        $('#countPlanInternal').val(total_count_int);
                    } else if (type == 'learn_perspective') {
                        $('#countPlanLearning').val(total_count_learn);
                    }

                    if (total_weight > 100) {
                        $('#alert_plan_weight').show();
                    } else {
                        $('#alert_plan_weight').hide();
                    }


                } else {
                   alert('Something went wrong. Please try again.');
                }
            }
        });
    }

});

function delete_plan_row(id) 
{    
    var request_id = $('#id_request').val();
    var deleted_time = parseFloat($('#kpi_plan_time-'+id).text());
    var current_total_weight = parseFloat(document.getElementById("plan_total_weight").value);
    var total_weight = parseFloat(current_total_weight - deleted_time);

    var count_fin = parseInt($('#countPlanFinancial').val());
    var count_cust = parseInt($('#countPlanCustomer').val());
    var count_int = parseInt($('#countPlanInternal').val());
    var count_learn = parseInt($('#countPlanLearning').val());

    var total_count_fin = parseInt(count_fin - 1);
    var total_count_cust = parseInt(count_cust - 1);
    var total_count_int = parseInt(count_int - 1);
    var total_count_learn = parseInt(count_learn - 1);

    var postData = {
        plan_id: id, 
        request_id: request_id, 
        plan_total_weight: total_weight, 
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove!',
        cancelButtonText: 'No.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/delete/plan_item",
                type: 'post',
                data: postData,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {

                        document.getElementById("plan_row-" + id + "").outerHTML = "";
                        
                        $('#plan_total_weight').val(total_weight);

                        if (response.perspective == 'financial') {
                            $('#countPlanFinancial').val(total_count_fin);
                        } else if (response.perspective == 'customer') {
                            $('#countPlanCustomer').val(total_count_cust);
                        } else if (response.perspective == 'internal') {
                            $('#countPlanInternal').val(total_count_int);
                        } else if (response.perspective == 'learning') {
                            $('#countPlanLearning').val(total_count_learn);
                        }

                        if (total_weight > 100) {
                            $('#alert_plan_weight').show();
                        } else {
                            $('#alert_plan_weight').hide();
                        }
                        swalWithBootstrapButtons.fire('Removed!', 'Deleted', 'success')

                    } else {
                        swalWithBootstrapButtons.fire('error', 'Something went wrong.', 'error')
                    }

                },
                error: function (response) {
                    alert('Oops! There\'s something wrong. Please refresh this page and try again.');
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })

}

function modal_update_plan(id) {

    var postData = { plan_id: id }

    $.ajax({
        url: "form/get_plan/",
        type: 'post',
        data: postData,
        dataType: 'json',
        success: function (response) {

            if (response == 'financial_perspective') {
                $('#title_modal_plan_update').text('Financial Perspective');
                $('#table_type_update').val('financial_perspective');
            } else if (response == 'cust_perspective') {
                $('#title_modal_plan_update').text('Customers Perspective');
                $('#table_type_update').val('cust_perspective');
            } else if (response == 'intern_perspective') {
                $('#title_modal_plan_update').text('Internal Process Perspective');
                $('#table_type_update').val('intern_perspective');
            } else if (response == 'learn_perspective') {
                $('#title_modal_plan_update').text('Learning & Growth Perspective');
                $('#table_type_update').val('learn_perspective');
            }

            var objective = $('#kpi_plan_objective-'+id).text();
            var measurement = $("#kpi_plan_measurement-"+id).text();
            var time = parseFloat($("#kpi_plan_time-"+id).text());
            var unit = $("#kpi_plan_unit-"+id).text();
            var target = $("#kpi_plan_target-"+id).text();
            var semester_1 = $("#kpi_plan_semester_1-"+id).text();
            var semester_2 = $("#kpi_plan_semester_2-"+id).text();
            var total = $("#kpi_plan_total-"+id).text();
            $('#update_plan_objective').val(objective);
            $('#update_plan_measurement').val(measurement);
            $('#update_plan_time').val(time);
            $('#update_plan_unit').val(unit);
            $('#update_plan_target').val(target);
            $('#update_plan_semester_1').val(semester_1);
            $('#update_plan_semester_2').val(semester_2);
            $('#update_plan_total').val(total);
            $('#id_plan_update').val(id);
            $('#modalUpdatePlan').modal('toggle');

        },
        error: function (response) {
            alert('Oops! There\'s something wrong. Please refresh this page and try again.');
        }
    });
}

$("#update_plan").click(function (e) {
    e.preventDefault();
    var id = $('#id_request').val();
    var id_detail = $('#id_plan_update').val();
    var previous_time = parseFloat($("#kpi_plan_time-"+id_detail).text());
    var objective = document.getElementById("update_plan_objective").value;
    var measurement = document.getElementById("update_plan_measurement").value;
    var new_time = parseFloat(document.getElementById("update_plan_time").value);
    var unit = document.getElementById("update_plan_unit").value;
    var target = document.getElementById("update_plan_target").value;
    var semester_1 = document.getElementById("update_plan_semester_1").value;
    var semester_2 = document.getElementById("update_plan_semester_2").value;
    var total = document.getElementById("update_plan_total").value;
    var previous_total_weight = parseFloat(document.getElementById("plan_total_weight").value);
    var weight = parseFloat(previous_total_weight - previous_time);
    var new_total_weight = parseFloat(weight + new_time);

    if ((new_time > 100)) {
        alert('Please input weight value less than or equal to 100');
        return false;
    }

    if ((objective.length == '') 
        || (measurement.length == '') 
        || (new_time.length == '') 
        || (unit.length == '') 
        || (target.length == '') 
        || (semester_1 == '')
        || (semester_2 == '') 
        || (total == '')
        ) {

        alert('All field is required.');
        return false;

    } else {

        var postData = {
            request_id: id,
            id_detail: id_detail,
            plan_objective: objective,
            plan_measurement: measurement,
            plan_new_time: new_time,
            plan_unit: unit,
            plan_target : target,
            plan_semester_1 : semester_1,
            plan_semester_2 : semester_2,
            plan_total : total,
            new_total_weight : new_total_weight,
        }

        $.ajax({
            method: 'post',
            url: 'form/save/update_plan',
            data: postData,
            dataType: 'json',
            success: function (response) {

                if (response.status == 1) {


                    document.getElementById("update_plan_objective").value = "";
                    document.getElementById("update_plan_measurement").value = "";
                    document.getElementById("update_plan_time").value = "";
                    document.getElementById("update_plan_unit").value = ""; 
                    document.getElementById("update_plan_target").value = "";
                    document.getElementById("update_plan_semester_1").value = "";
                    document.getElementById("update_plan_semester_2").value = "";
                    document.getElementById("update_plan_total").value = "";

                    $('#kpi_plan_objective-'+id_detail).text(objective);
                    $('#kpi_plan_measurement-'+id_detail).text(measurement);
                    $('#kpi_plan_time-'+id_detail).text(new_time);
                    $('#kpi_plan_unit-'+id_detail).text(unit);
                    $('#kpi_plan_target-'+id_detail).text(target);
                    $('#kpi_plan_semester_1-'+id_detail).text(semester_1);
                    $('#kpi_plan_semester_2-'+id_detail).text(semester_2);
                    $('#kpi_plan_total-'+id_detail).text(total);

                    $('#plan_total_weight').val(new_total_weight);

                    if (new_total_weight > 100) {
                        $('#alert_plan_weight').show();
                    } else {
                        $('#alert_plan_weight').hide();
                    }

                    $('#modalUpdatePlan').modal('toggle');

                } else {
                   alert('Something went wrong. Please try again.');
                }
            }
        });
    }

});

//////////////////////////////////////////// Approval List
function search_approval() {
    let input = document.getElementById('search_approval').value
    input = input.toLowerCase();
    let x = document.getElementsByClassName('nk-ibx-item');

    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display = "none";
        } else {
            x[i].style.display = "";
        }
    }
}

function clearSearch() {
    let x = document.getElementsByClassName('nk-ibx-item');
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "";
    }
}

//////////////////////////////////////////// Approval List MDCR
function search_approval_mdcr() {
    let input = document.getElementById('search_approval_mdcr').value
    input = input.toLowerCase();
    let x = document.getElementsByClassName('SearchMDCR');

    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display = "none";
        } else {
            x[i].style.display = "";
        }
    }
}

function clearSearchMdcr() {
    let x = document.getElementsByClassName('SearchMDCR');
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "";
    }
}

//////////////////////////////////////// inbox 
function quickView(id) {
    var postData = { id: id }
    $.ajax({
        url: "inbox/quickView/",
        type: 'post',
        data: postData,
        dataType: 'json',
        success: function (response) {

            console.log(response);
            $('#grade').text('');
            $('#emp_name').text(response[0].employee_name);
            $("#emp_position").text(response[0].position);
            $("#emp_join_date").text(response[0].join_date);
            $("#emp_type").text(response[0].employment_status);
            $("#subtotal_kpi").text(response[0].sub_total_kpi);
            $("#grandtotal_kpi").text(response[0].grand_total_kpi);
            $("#subtotal_qualitative").text(response[0].sub_total_qualitative);
            $("#grandtotal_qualitative").text(response[0].grand_total_qualitative);
            $("#pre_final_score").text(response[0].pre_final_score);
            $("#final_score").val(response[0].final_score);
            $("#req_id_modal").val(id);

            if (response[0].new_employee_flag == 1) {
                $("#final_score_title").show();
            } else {
                $("#final_score_title").hide();
            }

            $('#modalQuickView').modal('toggle');

        },
        error: function (response) {
            alert('Oops! There\'s something wrong. Please refresh this page and try again.');
        }
    });
}

// view summary request
function viewSummaryByDivision(status) {
    var postData = { status: status }
    $.ajax({
        url: "inbox/viewSummary/division",
        type: 'post',
        data: postData,
        dataType: 'json',
        success: function (response) {

            console.log(response);

            var no = 0;
            $('#tableViewSummary').html('');
            $.each(response.data, function (i, data) {
                no++;
                var $tr = $('<tr>').append(
                    $('<td>').text(no),
                    $('<td>').text(data.employee_nik),
                    $('<td>').text(data.employee_name),
                    $('<td>').text(data.updated_at),
                ).appendTo('#tableViewSummary');
            });

           
            $('#modalViewSummary').modal('toggle');

        },
        error: function (response) {
            alert('Oops! There\'s something wrong. Please refresh this page and try again.');
        }
    });
}

function viewSummaryBySecondDivision(status) {
    var postData = { status: status }
    $.ajax({
        url: "inbox/viewSummary/second_division",
        type: 'post',
        data: postData,
        dataType: 'json',
        success: function (response) {

            console.log(response);

            var no = 0;
            $('#tableViewSummary').html('');
            $.each(response.data, function (i, data) {
                no++;
                var $tr = $('<tr>').append(
                    $('<td>').text(no),
                    $('<td>').text(data.employee_nik),
                    $('<td>').text(data.employee_name),
                    $('<td>').text(data.updated_at),
                ).appendTo('#tableViewSummary');
            });

           
            $('#modalViewSummary').modal('toggle');

        },
        error: function (response) {
            alert('Oops! There\'s something wrong. Please refresh this page and try again.');
        }
    });
}



// Helper
function maxLengthCheck(object) {
    if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
}

function isNumeric(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

function rupiah(angka, code = true) {
    
    var rp = (code) ? 'Rp. ' : '';

    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rp +rupiah.split('',rupiah.length-1).reverse().join('');
}

function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(3);
    // rupiah(this.value); 
}

function CallBacksFunction() {
    console.log('#eapp-approvedMDCR');
}

function OTPmdcrResend(){
    var id = $('#id_request').val();
    var request_number = $('#request_number').val();
    //alert(id);
    //return false;

    var timer = setInterval(function () {
        var count = parseInt($('#myTimer').html());
        if (count !== 0) {
            $('#myTimer').html(count - 1);
        } else {
            clearInterval(timer);
            $("#divResendCode").show();
            $("#textTimer").hide();
        }
    }, 1000);


    $.ajax({
        url: "login/sendotpMDCR/send/sms",
        type: 'post',
        data: { id: id },
        success: function (response) {

            if (response == 1) {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: '<strong>We need to verify it\'s you.</strong>',
                    icon: 'question',
                    html: '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><b>6 digit code has been sent to your phone number.</b></center><br>' +
                        '<center><b>OTP code valid until this window is closed.</b></center>' +
                        '<center><b>If you do resend and have more than one messages, use the last one.</b></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="d-flex justify-content-center">' +
                        '<div class="col-md-8"></div>' +
                        '<div class="col-md-6">' +
                        '<input class="form-control form-control-lg" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return validateCodeApprovedMDCR();" maxlength="6" min="1" max="999" id="otp_code" />' +
                        '</div>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><h6><b>You\'re going to approve</b></h6></center><br>' +
                        '<center><h6><b>' + request_number + '</b></h6></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="divResendCode" style="display:none;">' +
                        '<button type="button" class="btn btn-dim btn-sm btn-outline-success" onclick="return OTPmdcrResend()" id="eapp-approvedMDCR"> Resend code</button>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="textTimer" style="display:show;">' +
                        '<div class="d-flex justify-content-center">' +
                        '<center><h6><b>The resend button will be enable in:</b></h6><b><span id="myTimer">45</span></b></center>' +
                        '</div>' +
                        '</div>' +
                        '</div><br>' +
                        '<hr>',
                    showCloseButton: false,
                    showCancelButton: true,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: false,
                    confirmButtonText: '<i class="fa fa-check-square-o"> Confirm</i>',
                    confirmButtonAriaLabel: 'Confirm',
                    cancelButtonText: 'Cancel',
                    cancelButtonAriaLabel: 'Cancel',
                })
            
            } else {
                alert('There\'s something wrong, it might be slow network or expired user session. Please refresh the page and try again');
            }
        }
    });
}