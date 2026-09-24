////////////////////////////////////////// Create Request
$("#create_step_one").click(function (e) {
  e.preventDefault();

  var formType = $("#formType").val();

  if (formType == "") {
    alert("Please select form");
    return false;
  } else if (formType == "TM") {
    window.location.href = "form/overview/" + formType;
    return false;
  }

  $.ajax({
    url: "form/initial_create/" + formType,
    type: "POST",
    dataType: "json",
    beforeSend: function () {
      $(".textCreateForm").html("Please wait..");
    },
    success: function (response) {
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
    },
    error: function (response) {
      $(".textCreateForm").html("Proceed");
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Something wrong. Please re-login and try again.",
        showConfirmButton: false,
        timer: 2000,
      });
    },
  });
});


$("#submit_new_request").click(function (e) {
  e.preventDefault();

  // validation
  var kpi_departemen = $("#kpi_departemen").val();
  var atasan_langsung = $("#atasan_langsung").val();
  var sub_total_weight = parseFloat(
    document.getElementById("kpi_total_weight").value
  );
  var kpi_total_assesment = $("#kpi_total_assesment").val();
  var work_efficiency = $("#plan_score_1").val();
  var work_quality = $("#plan_score_2").val();
  var communication = $("#plan_score_3").val();
  var planing = $("#plan_score_4").val();
  var problem_solving = $("#plan_score_5").val();
  var team_work = $("#plan_score_6").val();
  var potential = $("#plan_score_7").val();
  var initiative = $("#plan_score_8").val();
  var leadership = $("#plan_score_9").val();
  var area_improvement = $("#area_improvement").val();
  var development_plan = $("#development_plan").val();
  var plan_total_weight = $("#plan_total_weight").val();
  var list = document.getElementsByName("email[]");
  var countKpi = $("#countKpi").val();
  var countPlanFinancial = parseFloat($("#countPlanFinancial").val());
  var countPlanCustomer = parseFloat($("#countPlanCustomer").val());
  var countPlanInternal = parseFloat($("#countPlanInternal").val());
  var countPlanLearning = parseFloat($("#countPlanLearning").val());
  var countTraining = $("#countTraining").val();
  var countScoreIsi = $("#countScoreIsi").val();

  console.log(countKpi);
  if (countScoreIsi != countKpi) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "KPI Measurement must be filled full.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  // if (countTraining == 0 || countTraining == "") {
  //   Swal.fire({
  //     position: "top-end",
  //     icon: "error",
  //     title: "Please insert development plan, minimum 1",
  //     showConfirmButton: false,
  //     timer: 3000,
  //   });
  //   return false;
  // }

  // if (
  //   countPlanFinancial > 2 ||
  //   countPlanCustomer > 2 ||
  //   countPlanInternal > 2 ||
  //   countPlanLearning > 2
  // ) {
  //   Swal.fire({
  //     position: "top-end",
  //     icon: "error",
  //     title: "Check Performance Plan. Must be 2 rows on each perspective.",
  //     showConfirmButton: false,
  //     timer: 3000,
  //   });
  //   return false;
  // }

  var total_plan = parseFloat(
    countPlanFinancial +
    countPlanCustomer +
    countPlanInternal +
    countPlanLearning
  );

  if (total_plan < 1) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title:
        "Minimum total Performance Plan must be 1 objective",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (countKpi < 1) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Minimum KPI Measurement rows are 1 rows.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  // if (countKpi > 5) {
  //   Swal.fire({
  //     position: "top-end",
  //     icon: "error",
  //     title: "Maximum KPI Measurement rows are 5 rows.",
  //     showConfirmButton: false,
  //     timer: 3000,
  //   });
  //   return false;
  // }

  // if (total_plan < 3 || total_plan > 5) {
  //   Swal.fire({
  //     position: "top-end",
  //     icon: "error",
  //     title:
  //       "Minimum total Performance Plan must be 3 objective and Maximum 5 objective.",
  //     showConfirmButton: false,
  //     timer: 3000,
  //   });
  //   return false;
  // }

  // if (atasan_langsung == "") {
  //   Swal.fire({
  //     position: "top-end",
  //     icon: "error",
  //     title: "Div Head / C-Level are required.",
  //     showConfirmButton: false,
  //     timer: 3000,
  //   });
  //   return false;
  // }

  if (
    sub_total_weight != 100
  ) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Total weight must be 100%",
      showConfirmButton: false,
      timer: 3000,
    });
    $("#alert_weight").show();
    return false;
  }

  if (
    kpi_total_assesment == "" ||
    kpi_total_assesment == "NaN" ||
    work_efficiency == "" ||
    work_quality == "" ||
    communication == "" ||
    planing == "" ||
    problem_solving == "" ||
    team_work == "" ||
    potential == "" ||
    initiative == "" ||
    leadership == ""
  ) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Please complete Qualitative Assesment Score.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (area_improvement == "" || development_plan == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      // title: "Area Improvement & Development Plan are required.",
      title: "Area Improvement are required.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (countTraining == "" || countTraining == 0) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Development Plan are required.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (list.length == "0") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Please select approval layer.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (list.length > 2) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Max 2 layer approval.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (plan_total_weight != 100) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Performance Plan total weight must be 100.",
      showConfirmButton: false,
      timer: 3000,
    });
    $("#alert_plan_weight").show();
    return false;
  }

  var email = [];
  for (var i = 0; i < list.length; i++) {
    var a = list[i];
    // alert(a.value);
    email.push(a.value);
  }

  var id = $("#id_request").val();
  var id_form_request = $("#id_form_request").val();
  var is_status = $("#is_status").val();
  var kpi_departemen = $("#kpi_departemen").val();
  var atasan_langsung = $("#atasan_langsung").val();
  var result_work_efficiency = $("#plan_result_1").val();
  var result_work_quality = $("#plan_result_2").val();
  var result_communication = $("#plan_result_3").val();
  var result_planing = $("#plan_result_4").val();
  var result_problem_solving = $("#plan_result_5").val();
  var result_team_work = $("#plan_result_6").val();
  var result_potential = $("#plan_result_7").val();
  var result_initiative = $("#plan_result_8").val();
  var result_leadership = $("#plan_result_9").val();
  var comment_employee = $("#comment_employee").val();
  var comment_head_1 = $("#comment_head_1").val();
  var comment_head_2 = $("#comment_head_2").val();
  var sub_total_kpi = $("#kpi_total_score").val();
  var sub_total_qualitative = $("#total_qualitative").val();
  var grand_total_kpi = $("#grand_total_kpi").val();
  var grand_total_qualitative = $("#grand_total_qualitative").val();
  var pre_final_score = $("#pre_final_score").val();
  var postData = {
    id: id,
    id_form_request: id_form_request,
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
    result_work_efficiency: result_work_efficiency,
    result_work_quality: result_work_quality,
    result_communication: result_communication,
    result_planing: result_planing,
    result_problem_solving: result_problem_solving,
    result_team_work: result_team_work,
    result_potential: result_potential,
    result_initiative: result_initiative,
    result_leadership: result_leadership,
    comment_employee: comment_employee,
    comment_head_1: comment_head_1,
    comment_head_2: comment_head_2,
    plan_total_weight: plan_total_weight,
    area_improvement: area_improvement,
    development_plan: development_plan,
    sub_total_weight: sub_total_weight,
    sub_total_kpi: sub_total_kpi,
    sub_total_qualitative: sub_total_qualitative,
    grand_total_kpi: grand_total_kpi,
    grand_total_qualitative: grand_total_qualitative,
    pre_final_score: pre_final_score,
    approval_layer: email,
  };

  // console.log(postData);
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "We will send an email notification to your first approval layer.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure!",
      cancelButtonText: "Cancel",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: "form/save/submit/KPI",
          type: "post",
          data: postData,
          dataType: "json",
          beforeSend: function () {
            Swal.fire({
              position: "center",
              title: "Please Wait...",
              onBeforeOpen: () => {
                Swal.showLoading();
              },
              allowOutsideClick: false,
              allowEscapeKey: false
            });
          },
          success: function (response) {
            if (response.status == 1) {
              swalWithBootstrapButtons.fire(
                "Nice!",
                "Your request has been submitted.",
                "success"
              );
              window.location.href = "home/request";
            } else if (response.status == 33) {
              Swal.fire({
                position: "top-end",
                icon: "error",
                title:
                  "Oops! Your score exceeds the normal curve quota because one of your employees already has that score.",
                showConfirmButton: false,
                timer: 2000,
              });
              // window.location.href = "home/request";
            } else {
              Swal.fire({
                position: "top-end",
                icon: "error",
                title:
                  "Oops! Sorry, there's something wrong. Please refresh the page and try again.",
                showConfirmButton: false,
                timer: 2000,
              });
              // window.location.href = "home/request";
            }
          },
          error: function (response) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title:
                "Oops! There's something wrong. Please refresh the page and try again.",
              showConfirmButton: false,
              timer: 2000,
            });
            // window.location.href = "home/request";
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Action has been cancelled.",
          "success"
        );
      }
    });
});

$("#submit_new_employee").click(function (e) {
  e.preventDefault();
  // validation
  var kpi_departemen = $("#kpi_departemen").val();
  var atasan_langsung = $("#atasan_langsung").val();
  var plan_total_weight = $("#plan_total_weight").val();
  // var list = $(".approvalLayer").find(":selected");
  var list = document.getElementsByName("email[]");
  var countPlanFinancial = $("#countPlanFinancial").val();
  var countPlanCustomer = $("#countPlanCustomer").val();
  var countPlanInternal = $("#countPlanInternal").val();
  var countPlanLearning = $("#countPlanLearning").val();

  var total_plan = parseFloat(
    countPlanFinancial +
    countPlanCustomer +
    countPlanInternal +
    countPlanLearning
  );

  if (total_plan < 1) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title:
        "Minimum total Performance Plan must be 1 objective",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  // if (
  //   countPlanFinancial > 2 ||
  //   countPlanCustomer > 2 ||
  //   countPlanInternal > 2 ||
  //   countPlanLearning > 2
  // ) {
  //   Swal.fire({
  //     position: "top-end",
  //     icon: "error",
  //     title: "Check Performance Plan. Must be 2 rows on each perspective.",
  //     showConfirmButton: false,
  //     timer: 3000,
  //   });
  //   return false;
  // }

  if (atasan_langsung == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Div Head / C-Level are required.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (list.length == "0") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Please select approval layer.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }
  if (list.length > 2) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Max 2 layer approval.",
      showConfirmButton: false,
      timer: 3000,
    });
    return false;
  }

  if (plan_total_weight != 100) {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Performance Plan total weight must be 100.",
      showConfirmButton: false,
      timer: 3000,
    });
    $("#alert_plan_weight").show();
    return false;
  }

  var email = [];
  for (var i = 0; i < list.length; i++) {
    // alert(list[i].value);
    email.push(list[i].value);
  }

  // return false;

  var id = $("#id_request").val();
  var is_status = $("#is_status").val();
  var kpi_departemen = $("#kpi_departemen").val();
  var atasan_langsung = $("#atasan_langsung").val();
  var id_form_request = $("#id_form_request").val();
  var postData = {
    id: id,
    id_form_request: id_form_request,
    is_status: is_status,
    kpi_departemen: kpi_departemen,
    atasan_langsung: atasan_langsung,
    plan_total_weight: plan_total_weight,
    approval_layer: email,
  };

  // console.log(postData);
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "We will send an email notification to your first approval layer.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure!",
      cancelButtonText: "Cancel",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: "form/save/submit_new_employee/PLAN",
          type: "post",
          data: postData,
          dataType: "json",
          success: function (response) {
            console.log(response);
            if (response.status == 1) {
              swalWithBootstrapButtons.fire(
                "Nice!",
                "Your request has been submitted.",
                "success"
              );
              window.location.href = "home/request";
            } else {
              Swal.fire({
                position: "top-end",
                icon: "error",
                title:
                  "Oops! Sorry, there's something wrong. Please refresh the page and try again.",
                showConfirmButton: false,
                timer: 2000,
              });
              window.location.href = "home/request";
            }
          },
          error: function (response) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title:
                "Oops! There's something wrong. Please refresh the page and try again.",
              showConfirmButton: false,
              timer: 2000,
            });
            window.location.href = "home/request";
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Action has been cancelled.",
          "success"
        );
      }
    });
});

// Add Approval Layer
$(document).ready(function () {
  var i = 0;
  $("#add").click(function (e) {
    e.preventDefault();
    i++;
    $.ajax({
      url: "list/request/getUserList",
      datatype: "json",
      type: "post",
      beforeSend: function () {
        $("#addLayerText").hide();
        $("#loadLayerSpinner").show();
      },
      success: function (data) {
        $("#addLayerText").show();
        $("#loadLayerSpinner").hide();
        // console.log(JSON.parse(data));

        var row = "";
        row =
          '<div class="card-inner card-inner-md" id="row' +
          i +
          '"><div class="user-card"><div class="user-avatar bg-primary-dim"><span><em class="icon ni ni-downward-ios"></em></span></div><div class="user-info"><div class="form-group"><div class="form-control-wrap" style="width:300px;"><select class="form-control form-control-md approval approvalLayer" data-search="on" id="emailUsers' +
          i +
          '" name="email[]" required><option values=""></option></select></div></div></div><div class="user-action"><button type="button" name="remove" id="' +
          i +
          '" class="btn btn-danger btn_remove"><i class="fa fa-remove"></i>Remove</button></div></div></div>';
        $("#dynamic_field").append(row);
        $.each(JSON.parse(data), function (key, value) {
          $("#emailUsers" + i).append(
            $("<option></option>")
              .attr("value", value.user_email)
              .text(value.user_email)
          );
          $("#emailUsers" + i).select2();
        });
      },
    });
  });

  $(document).on("click", ".btn_remove", function () {
    var button_id = $(this).attr("id");
    $("#row" + button_id + "").remove();
  });
});

// Update Layer
$(document).ready(function () {
  var base_url = window.location.origin;

  $("#add_update_layer").click(function () {
    var i = $("#appPrior").val();
    i++;
    $.ajax({
      url: "form/getUserList",
      datatype: "json",
      type: "get",
      beforeSend: function () {
        $("#updateLayerText").hide();
        $("#loadLayerSpinner").show();
      },
      success: function (data) {
        $("#updateLayerText").show();
        $("#loadLayerSpinner").hide();

        var row = "";
        row =
          '<tr id="row' +
          i +
          '" class="dynamic-added"><td style="width: 100%;"><div class="form-group"><div class="option-group"><select class="form-control approvalLayer" id="emailUsers' +
          i +
          '" name="email[]" required><option values=""></option></select></div></div ></td><td style="width: 20%;"><button type="button" name="remove" id="' +
          i +
          '" class="btn btn-danger btn_remove"><i class="fa fa-remove"></i>Remove</button></td></tr>';
        $("#update_layer").append(row);
        $.each(JSON.parse(data), function (key, value) {
          $("#emailUsers" + i).append(
            $("<option></option>")
              .attr("value", value.user_email)
              .text(value.user_email)
          );
          $("#emailUsers" + i).select2();
        });

        $("#appPrior").val(i);
      },
    });
  });

  $(document).on("click", ".btn_remove", function () {
    var button_id = $(this).attr("id");
    $("#row" + button_id + "").remove();
  });
});

$("#eapp-pullback").click(function (e) {
  e.preventDefault();
  var id = $("#id_request").val();
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "Approval will be reset!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Reset approval.",
      cancelButtonText: "Cancel.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: "form/pullBack",
          type: "post",
          data: "id=" + id,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              Swal.fire({
                position: "top-end",
                icon: "info",
                title: "Your request has been canceled.",
                showConfirmButton: false,
                timer: 3000,
              }).then(function () {
                window.location = "home/request";
              });
            } else {
              swalWithBootstrapButtons.fire("error", response.message, "error");
              // window.location.href = "home/request";
            }
          },
          error: function (response) {
            alert(
              "Oops! There's something wrong, it might be slow network or expired user session. Please refresh this page and try again."
            );
            // window.location.href = "home/request";
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Action has been cancelled.",
          "success"
        );
      }
    });
});

// RESPONSE
$("#eapp-approvedMDCR").click(function (e) {
  var id = $("#id_request").val();
  var request_number = $("#request_number").val();
  //alert(id);
  //return false;
  e.preventDefault();

  var timer = setInterval(function () {
    var count = parseInt($("#myTimer").html());
    if (count !== 0) {
      $("#myTimer").html(count - 1);
    } else {
      clearInterval(timer);
      $("#divResendCode").show();
      $("#textTimer").hide();
    }
  }, 1000);

  $.ajax({
    url: "login/sendotpMDCR/send/sms",
    type: "post",
    data: { id: id },
    success: function (response) {
      if (response == 1) {
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
          },
          buttonsStyling: false,
        });

        swalWithBootstrapButtons.fire({
          title: "<strong>We need to verify it's you.</strong>",
          icon: "question",
          html:
            '<div class="row">' +
            '<div class="col-md-12">' +
            "<center><b>6 digit code has been sent to your phone number.</b></center><br>" +
            "<center><b>OTP code valid until this window is closed.</b></center>" +
            "<center><b>If you do resend and have more than one messages, use the last one.</b></center><br>" +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="d-flex justify-content-center">' +
            '<div class="col-md-8"></div>' +
            '<div class="col-md-6">' +
            '<input class="form-control form-control-lg" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return validateCodeApprovedMDCR();" maxlength="6" min="1" max="999" id="otp_code" />' +
            "</div>" +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="col-md-12">' +
            "<center><h6><b>You're going to approve</b></h6></center><br>" +
            "<center><h6><b>" +
            request_number +
            "</b></h6></center><br>" +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="col-md-12" id="divResendCode" style="display:none;">' +
            '<button type="button" class="btn btn-dim btn-sm btn-outline-success" onclick="return OTPmdcrResend()" id="eapp-approvedMDCR"> Resend code</button>' +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="col-md-12" id="textTimer" style="display:show;">' +
            '<div class="d-flex justify-content-center">' +
            '<center><h6><b>The resend button will be enable in:</b></h6><b><span id="myTimer">45</span></b></center>' +
            "</div>" +
            "</div>" +
            "</div><br>" +
            "<hr>",
          showCloseButton: false,
          showCancelButton: true,
          showConfirmButton: false,
          focusConfirm: false,
          allowOutsideClick: false,
          confirmButtonText: '<i class="fa fa-check-square-o"> Confirm</i>',
          confirmButtonAriaLabel: "Confirm",
          cancelButtonText: "Cancel",
          cancelButtonAriaLabel: "Cancel",
        });
      } else {
        alert(
          "There's something wrong, it might be slow network or expired user session. Please refresh the page and try again"
        );
      }
    },
  });
});

function validateCodeApprovedMDCR() {
  //e.preventDefault();
  var request_id = $("#id_request").val();
  // var approval_id = $('#approval_id').val();
  // var request_number = $('#request_number').val();
  var otp = $("#otp_code").val();
  //return false;

  $.ajax({
    url: "login/validateMDCR/Approved",
    type: "post",
    data: { request_id: request_id, otp: otp },
    dataType: "json",
    success: function (response) {
      if (response.status == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: response.message,
          showConfirmButton: false,
          timer: 1000,
        });
        window.location.href = "dashboard";
      } else {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: response.message,
          showConfirmButton: false,
          timer: 5000,
        });
        window.location.href = "inbox/approval";
      }
    },
    error: function (response) {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title:
          "There's something wrong, it might be slow network or expired user session. Please refresh the page or try again later.",
        showConfirmButton: false,
        timer: 3500,
      });
    },
  });
}

function responseRequest(type) {
  var id = $("#request_id").val();
  //return false;

  if (type == "Revised" || type == "Reject" || type == "RejectLoc") {

    Swal.fire({
      title: 'Processing...',
      text: 'Please wait while we process your data.',
      showConfirmButton: false,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    var url = "inbox/cekNote";
    $.ajax({
      url: url,
      dataType: "json",
      type: "POST",
      data: { id: id },
      success: function (data) {
        if (data == true) {
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: "btn btn-primary",
              cancelButton: "btn btn-light",
            },
            buttonsStyling: false,
          });

          swalWithBootstrapButtons
            .fire({
              title: "Are you sure?",
              //text: "Revise this request",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, sure.",
              cancelButtonText: "Cancel.",
              reverseButtons: true,
              allowOutsideClick: false,
            })
            .then((result) => {
              if (result.value) {
                $.ajax({
                  url: "inbox/responseRequest",
                  type: "post",
                  data: "id=" + id + "&resp=" + type,
                  dataType: "json",
                  success: function (response) {
                    if (response.status == 1) {
                      Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Response has been saved.",
                        showConfirmButton: false,
                        timer: 3000,
                      }).then(function () {
                        window.location.href = "inbox/approval";
                      });
                    } else {
                      swalWithBootstrapButtons.fire(
                        "Oops!",
                        "Something went wrong. Please try again.",
                        "error"
                      );
                    }
                  },
                  error: function (response) {
                    alert(
                      "Oops! There's something wrong, it might be slow network or expired user session. Please refresh this page and try again."
                    );
                  },
                });
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                  "Cancelled",
                  "Action has been cancelled.",
                  "success"
                );
              }
            });
        } else {
          Swal.fire({
            position: "center",
            icon: "warning",
            title: "Dimohon untuk mengisi note",
            showConfirmButton: false,
            timer: 1500,
          });
        }
      },
      error: function (data) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Data tidak dapat diproses",
          showConfirmButton: false,
          timer: 1500,
        });
      },
    });
  } else {
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-light",
      },
      buttonsStyling: false,
    });

    swalWithBootstrapButtons
      .fire({
        title: "Are you sure?",
        //text: "Revise this request",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, sure.",
        cancelButtonText: "Cancel.",
        reverseButtons: true,
        allowOutsideClick: false,
      })
      .then((result) => {
        if (result.value) {

          Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we process your data.',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          $.ajax({
            url: "inbox/responseRequest",
            type: "post",
            data: "id=" + id + "&resp=" + type,
            dataType: "json",
            success: function (response) {
              if (response.status == 1) {
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Response has been saved.",
                  showConfirmButton: false,
                  timer: 3000,
                }).then(function () {
                  /////////////////////////////////START TIME MANAGEMENT 2024////////////////////////////////////
                  if (response.tipe_form == 'TM') {
                    window.location.href = "inbox/approval_TM_ztm";
                  } else {
                    window.location.href = "inbox/approval";
                  }
                  /////////////////////////////////END TIME MANAGEMENT 2024////////////////////////////////////
                });
              } else {
                swalWithBootstrapButtons.fire(
                  "Oops!",
                  "Something went wrong. Please try again.",
                  "error"
                );
              }
            },
            error: function (response) {
              alert(
                "Oops! There's something wrong, it might be slow network or expired user session. Please refresh this page and try again."
              );
            },
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelled",
            "Action has been cancelled.",
            "success"
          );
        }
      });
  }
}

function responseDivision(type, attr) {
  var url = "";
  var redirect = "";

  if (type == "Revised") {
    var performance_division_id = $("#performance_division_id").val();
    url = "inbox/save/" + type + "/" + performance_division_id;
    rdr = "inbox/hr_division";
    msg = "This division PA has been revised to it's Division Head.";
    title = "Revised!";
  } else if (type == "Confirm") {
    var performance_division_id = $("#performance_division_id").val();
    url = "inbox/save/" + type + "/" + performance_division_id;
    rdr = "inbox/hr_division";
    msg = "This division PA has been moved to Confirmed PA & Plan.";
    title = "Confirmed successfully!";
  } else if (type == "submit_to_hr_mgmt") {
    url = "inbox/save/submit_to_hr";
    rdr = "dashboard/mgmt_mul";
    msg = "Your division PA has been submitted.";
    title = "Success!";
  } else if (type == "submit_to_hr_second_division_mgmt") {
    url = "inbox/save/submit_to_hr_second_division";
    rdr = "dashboard/mgmt_mul";
    msg = "Your division PA has been submitted.";
    title = "Success!";
  } else if (type == "submit_to_hr_ops") {
    url = "inbox/save/submit_to_hr_ops";
    rdr = "dashboard/c_view/Regional%20Central";
    msg = "Your division PA has been submitted.";
    title = "Success!";
  } else {
    url = "inbox/save/" + type + "/_/" + attr;
    rdr = "inbox/mgmt_mul";
    msg = "Your division PA has been submitted.";
    title = "Success";
  }

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure.",
      cancelButtonText: "Cancel.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: url,
          type: "post",
          dataType: "json",
          beforeSend: function () {
            Swal.fire({
              position: "center",
              title: "Please Wait...",
              onBeforeOpen: () => {
                Swal.showLoading();
              },
              allowOutsideClick: false,
              allowEscapeKey: false
            });
          },
          success: function (response) {
            if (response.status == 1) {
              Swal.fire({
                title: title,
                text: msg,
                icon: "success",
                timer: 2500
              }).then(function () {
                window.location.href = rdr;
              });
            } else {
              swalWithBootstrapButtons.fire(
                "Oops!",
                "Something went wrong. Please try again.",
                "error"
              );
            }
          },
          error: function (response) {
            alert(
              "Oops! There's something wrong. Please refresh this page and try again."
            );
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Action has been cancelled.",
          "success"
        );
      }
    });
}

function save_response_notes() {
  if ($("#response-notes").val() == "") {
    return false;
  }
  var base_url = window.location.origin;
  var id = $("#id_request").val();
  var approval_id = $("#approval_id").val();
  var notes = $("#response-notes").val();
  var postData = {
    request_id: id,
    approval_id: approval_id,
    notes: notes,
  };
  $.ajax({
    method: "post",
    url: "inbox/save/notes",
    data: postData,
    dataType: "json",
    beforeSend: function () {
      console.log(postData);
      $("#text-notes-response").html("Please wait...");
    },
    success: function (response) {
      $("#text-notes-response").html("Save");

      if (response.status == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: response.messages,
          showConfirmButton: false,
          timer: 2500,
        }).then(function () {
          $("#modalAddNotes").modal("toggle");
          location.reload();
        });
      } else {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: response.messages,
          showConfirmButton: false,
          timer: 5000,
        });
      }
    },
  });
}

function delete_notes(id) {
  var id_request = $("#id_request").val();

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure!",
      cancelButtonText: "Cancel.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          method: "post",
          url: "inbox/delete_notes/" + id + "/" + id_request,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: response.messages,
                showConfirmButton: false,
                timer: 2500,
              }).then(function () {
                location.reload();
              });
            } else {
              Swal.fire({
                position: "top-end",
                icon: "error",
                title: response.messages,
                showConfirmButton: false,
                timer: 5000,
              });
            }
          },
          error: function (response) {
            alert(
              "Oops! Internal error. Please refresh this page and try again."
            );
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Action has been cancelled.",
          "success"
        );
      }
    });
}

function delete_draft(id) {
  if (id == "") {
    alert("Please refresh the page and try again.");
    return false;
  }

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure!",
      cancelButtonText: "Cancel.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          method: "post",
          url: "home/request/delete/" + id,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: response.messages,
                showConfirmButton: false,
                timer: 2500,
              }).then(function () {
                window.location.href = "home/request/";
              });
            } else {
              Swal.fire({
                position: "center",
                icon: "error",
                title: response.messages,
                showConfirmButton: false,
                timer: 5000,
              });
            }
          },
          error: function (response) {
            alert(
              "Oops! Internal error. Please refresh this page and try again."
            );
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Action has been cancelled.",
          "success"
        );
      }
    });
}

function copyToClipboard(text) {
  var sampleTextarea = document.createElement("textarea");
  document.body.appendChild(sampleTextarea);
  sampleTextarea.value = text; //save main text in it
  sampleTextarea.select(); //select textarea contenrs
  document.execCommand("copy");
  document.body.removeChild(sampleTextarea);
}

function copy_reqnum() {
  var copyText = document.getElementById("copy_reqnum");
  copyToClipboard(copyText.value);
}

//////////////////////////////////////////// Approval List
function search_approval() {
  let input = document.getElementById("search_approval").value;
  input = input.toLowerCase();
  let x = document.getElementsByClassName("nk-ibx-item");

  for (i = 0; i < x.length; i++) {
    if (!x[i].innerHTML.toLowerCase().includes(input)) {
      x[i].style.display = "none";
    } else {
      x[i].style.display = "";
    }
  }
}

function clearSearch() {
  let x = document.getElementsByClassName("nk-ibx-item");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "";
  }
}

//////////////////////////////////////////// Approval List MDCR
function search_approval_mdcr() {
  let input = document.getElementById("search_approval_mdcr").value;
  input = input.toLowerCase();
  let x = document.getElementsByClassName("SearchMDCR");

  for (i = 0; i < x.length; i++) {
    if (!x[i].innerHTML.toLowerCase().includes(input)) {
      x[i].style.display = "none";
    } else {
      x[i].style.display = "";
    }
  }
}

function clearSearchMdcr() {
  let x = document.getElementsByClassName("SearchMDCR");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "";
  }
}

//////////////////////////////////////// inbox
function quickView(id) {
  var postData = { id: id };
  $.ajax({
    url: "inbox/quickView/",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);
      $("#grade").text("");
      $("#emp_name").text(response.employee_name);
      $("#emp_position").text(response.position);
      $("#emp_join_date").text(response.join_date);
      $("#emp_type").text(response.employment_status);
      $("#subtotal_kpi").text(response.sub_total_kpi);
      $("#grandtotal_kpi").text(response.grand_total_kpi);
      $("#subtotal_qualitative").text(response.sub_total_qualitative);
      $("#grandtotal_qualitative").text(response.grand_total_qualitative);
      $("#pre_final_score").text(response.pre_final_score);
      $("#final_score").val(response.final_score);
      $("#req_id_modal").val(id);

      if (response.new_employee_flag == 1) {
        $("#final_score_title").show();
      } else {
        $("#final_score_title").hide();
      }

      $("#modalQuickView").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function quickViewReadonly(id) {
  var postData = { id: id };
  $.ajax({
    url: "inbox/quickView/",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);
      $("#emp_name_ro").text(response.employee_name);
      $("#emp_position_ro").text(response.position);
      $("#emp_join_date_ro").text(response.join_date);
      $("#emp_type_ro").text(response.employment_status);
      $("#subtotal_kpi_ro").text(response.sub_total_kpi);
      $("#grandtotal_kpi_ro").text(response.grand_total_kpi);
      $("#subtotal_qualitative_ro").text(response.sub_total_qualitative);
      $("#grandtotal_qualitative_ro").text(response.grand_total_qualitative);
      $("#pre_final_score_ro").text(response.pre_final_score);
      $("#final_score_ro").text(response.final_score);
      $("#req_id_modal_ro").val(id);

      if (response.new_employee_flag == 1) {
        $("#final_score_title_ro").show();
      } else {
        $("#final_score_title_ro").hide();
      }

      $("#modalQuickViewReadonly").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

// view summary request
function viewSummaryByDivision(status) {
  var postData = { status: status };
  console.log(postData)
  $.ajax({
    url: "inbox/viewSummary/division",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      $("#tableViewSummary").html("");
      $.each(response.data, function (i, data) {
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.employee_nik),
            $("<td>").text(data.employee_name),
            $("<td>").text(data.updated_at)
          )
          .appendTo("#tableViewSummary");
      });

      $("#modalViewSummary").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function viewSummaryByDivisionMul(status, no, division) {
  var postData = { status: status, division: division };
  var no = no;
  var mod = "#modalViewSummary" + no;
  var table = "#tableViewSummary" + no;

  $.ajax({
    url: "inbox/viewSummaryMul/division",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      $(table).html("");
      $.each(response.data, function (i, data) {
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.employee_nik),
            $("<td>").text(data.employee_name),
            $("<td>").text(data.updated_at)
          )
          .appendTo(table);
      });

      $(mod).modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function viewSummaryBySecondDivision(status) {
  var postData = { status: status };
  $.ajax({
    url: "inbox/viewSummary/second_division",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      $("#tableViewSummary").html("");
      $.each(response.data, function (i, data) {
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.employee_nik),
            $("<td>").text(data.employee_name),
            $("<td>").text(data.updated_at)
          )
          .appendTo("#tableViewSummary");
      });

      $("#modalViewSummary").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

// Helper
function maxLengthCheck(object) {
  if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength);
}

// function isNumeric(evt) {
//   var theEvent = evt || window.event;
//   var key = theEvent.keyCode || theEvent.which;
//   key = String.fromCharCode(key);
//   var regex = /[0-9]|\./;
//   if (!regex.test(key)) {
//     theEvent.returnValue = false;
//     if (theEvent.preventDefault) theEvent.preventDefault();
//   }
// }

function rupiah(angka, code = true) {
  var rp = code ? "Rp. " : "";

  var rupiah = "";
  var angkarev = angka.toString().split("").reverse().join("");
  for (var i = 0; i < angkarev.length; i++)
    if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
  return (
    rp +
    rupiah
      .split("", rupiah.length - 1)
      .reverse()
      .join("")
  );
}

function setTwoNumberDecimal(event) {
  this.value = parseFloat(this.value).toFixed(3);
  // rupiah(this.value);
}

function CallBacksFunction() {
  console.log("#eapp-approvedMDCR");
}

function OTPmdcrResend() {
  var id = $("#id_request").val();
  var request_number = $("#request_number").val();
  //alert(id);
  //return false;

  var timer = setInterval(function () {
    var count = parseInt($("#myTimer").html());
    if (count !== 0) {
      $("#myTimer").html(count - 1);
    } else {
      clearInterval(timer);
      $("#divResendCode").show();
      $("#textTimer").hide();
    }
  }, 1000);

  $.ajax({
    url: "login/sendotpMDCR/send/sms",
    type: "post",
    data: { id: id },
    success: function (response) {
      if (response == 1) {
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
          },
          buttonsStyling: false,
        });

        swalWithBootstrapButtons.fire({
          title: "<strong>We need to verify it's you.</strong>",
          icon: "question",
          html:
            '<div class="row">' +
            '<div class="col-md-12">' +
            "<center><b>6 digit code has been sent to your phone number.</b></center><br>" +
            "<center><b>OTP code valid until this window is closed.</b></center>" +
            "<center><b>If you do resend and have more than one messages, use the last one.</b></center><br>" +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="d-flex justify-content-center">' +
            '<div class="col-md-8"></div>' +
            '<div class="col-md-6">' +
            '<input class="form-control form-control-lg" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return validateCodeApprovedMDCR();" maxlength="6" min="1" max="999" id="otp_code" />' +
            "</div>" +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="col-md-12">' +
            "<center><h6><b>You're going to approve</b></h6></center><br>" +
            "<center><h6><b>" +
            request_number +
            "</b></h6></center><br>" +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="col-md-12" id="divResendCode" style="display:none;">' +
            '<button type="button" class="btn btn-dim btn-sm btn-outline-success" onclick="return OTPmdcrResend()" id="eapp-approvedMDCR"> Resend code</button>' +
            "</div>" +
            "</div><br>" +
            '<div class="row">' +
            '<div class="col-md-12" id="textTimer" style="display:show;">' +
            '<div class="d-flex justify-content-center">' +
            '<center><h6><b>The resend button will be enable in:</b></h6><b><span id="myTimer">45</span></b></center>' +
            "</div>" +
            "</div>" +
            "</div><br>" +
            "<hr>",
          showCloseButton: false,
          showCancelButton: true,
          showConfirmButton: false,
          focusConfirm: false,
          allowOutsideClick: false,
          confirmButtonText: '<i class="fa fa-check-square-o"> Confirm</i>',
          confirmButtonAriaLabel: "Confirm",
          cancelButtonText: "Cancel",
          cancelButtonAriaLabel: "Cancel",
        });
      } else {
        alert(
          "There's something wrong, it might be slow network or expired user session. Please refresh the page and try again"
        );
      }
    },
  });
}

//////////////////////////////////////////////////// START TIME MANAGEMENT 2024 ////////////////////////////////////////////////////
var base_url = window.location.origin;

$(document).ready(function () {
  loadTotal();
  if (window.location == base_url + "/form/overview/TM") {
    var url = "form/getTimeOffType/";
    $.ajax({
      type: "POST",
      url: url,
      dataType: "json",
      success: function (response) {
        const listTypes = [];
        for (var i = 0; i < response.length; i++) {
          if (i != 0) {
            if (response[i].kode === response[i - 1].kode) {
              continue;
            } else {
              listTypes.push({
                nama: response[i].nama,
                kode: response[i].kode,
              });
            }
          } else {
            listTypes.push({
              nama: response[i].nama,
              kode: response[i].kode,
            });
          }
        }
        // alert(listTypes);

        $.each(listTypes, function (key, value) {
          $("#time_off_type").append(
            $("<option></option>")
              .attr({ value: value["nama"], id: value["kode"] })
              .text(value["nama"])
          );
          $("#time_off_code").append(
            $("<option></option>")
              .attr({ value: value["kode"], id: "kode" + value["kode"] })
              .text(value["kode"])
          );
        });
      },
    });

    loadCIH();

    $.ajax({
      type: "POST",
      url: "form/getMaritalStatus",
      dataType: "json",
      success: function (response) {
        if (response == "not_married_female") {
          $("#CL").attr("disabled", true);
          $("#CK").attr("disabled", true);
          $("#CIM").attr("disabled", true);
          $("#CMA").attr("disabled", true);
          $("#CKA").attr("disabled", true);
          $("#CBA").attr("disabled", true);
        } else if (response == "not_married_male") {
          $("#CL").attr("disabled", true);
          $("#CK").attr("disabled", true);
          $("#CIM").attr("disabled", true);
          $("#CMA").attr("disabled", true);
          $("#CKA").attr("disabled", true);
          $("#CBA").attr("disabled", true);
        } else if (response == "married_male") {
          $("#CL").attr("disabled", true);
          $("#CK").attr("disabled", true);
          $("#CIM").attr("disabled", false);
          $("#CMA").attr("disabled", false);
          $("#CKA").attr("disabled", false);
          $("#CBA").attr("disabled", false);
        } else if (response == "married_female") {
          $("#CL").attr("disabled", false);
          $("#CK").attr("disabled", false);
          $("#CIM").attr("disabled", true);
          $("#CMA").attr("disabled", false);
          $("#CKA").attr("disabled", false);
          $("#CBA").attr("disabled", false);
        }
      },
    });

    $.ajax({
      type: "POST",
      url: "form/getHROnly",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#management_module").append(
            $("<option></option>")
              .attr({ value: response[x].nama, id: response[x].kode })
              .text(response[x].nama)
          );
          $("#module_code").append(
            $("<option></option>")
              .attr({ value: response[x].kode, id: "kode" + response[x].kode })
              .text(response[x].kode)
          );
        }
      },
    });

    $.ajax({
      type: "POST",
      url: "form/getEmployee",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#employee_name").append(
            $("<option></option>")
              .attr("value", response[x].email)
              .text(response[x].nik + " - " + response[x].complete_name)
          );
          $("#employee_name_single").append(
            $("<option></option>")
              .attr("value", response[x].nik)
              .text(response[x].nik + " - " + response[x].complete_name)
          );
        }
      },
    });

    $.ajax({
      type: 'POST',
      url: 'form/getDayOff',
      dataType: 'json',
      success: function (response) {
        for (let x in response) {
          $('#date_submit_dayoff').append($('<option></option>').attr('value', response[x].date).text(response[x].date + ' - ' + response[x].holiday_calendar));
        }
      }
    });

    $.ajax({
      type: 'POST',
      url: 'form/getYears',
      dataType: 'json',
      success: function (response) {
        for (let x in response) {
          $('#adj_pg_year').append($('<option></option>').attr('value', response[x].date).text(response[x].date));
        }
      }
    });

    loadCTAB();
  }
});

function loadCIH() {
  var url3 = "form/getAlreadyRequested/";
  $.ajax({
    type: "POST",
    url: url3,
    dataType: "json",
    success: function (response) {
      if (response.length > 0) {
        $("#CIH").attr("disabled", true);
      } else {
        $("#CIH").attr("disabled", false);
      }
    },
  });
  var url2 = "form/getJoinDate/";
  $.ajax({
    type: "POST",
    url: url2,
    dataType: "json",
    success: function (response) {
      var tgl1 = new Date(response);
      var tgl2 = new Date();
      tgl2.setHours(0, 0, 0, 0);
      jarak_time = Date.parse(tgl2) - Date.parse(tgl1);
      jarak_tahun = jarak_time / 31556952000;
      if (jarak_tahun < 3) {
        $("#CIH").attr("disabled", true);
      } else {
        $("#CIH").attr("disabled", false);
      }
    },
  });
}

function loadCTAB() {
  $.ajax({
    type: "POST",
    url: "form/getCutiTidakAbsen",
    dataType: "json",
    success: function (response) {
      $("#req_absent_date").empty();
      $("#req_absent_date").append(
        $("<option></option>").attr({ value: " ", id: "req_1" }).text("")
      );
      for (let x in response) {
        $("#req_absent_date").append(
          $("<option></option>")
            .attr({ value: response[x], id: "date" + x })
            .text(response[x])
        );
      }
    },
  });
}

function loadTotal() {
  var url = "form/getTotalCuti/";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    success: function (response) {
      console.log(response);
      if (response == 0) {
        $("#sisa h2").html("0");
      } else {
        $("#sisa h2").html(response[0].total_cuti);
        if (response[0].total_cuti < 0) {
          $('.sisa_cuti').show();
          $('.sisa_cuti').html('<div id="sisa_cuti" class="sisa_cuti alert alert-fill alert-danger alert-icon alert-dismissible" style="padding-bottom: 10px; margin-bottom: 4px;"><em class="icon ni ni-alert-circle sisa_cuti"></em><strong><marquee direction="right" behavior="alternate"><h6>Mohon diperhatikan sisa cuti anda ' + response[0].total_cuti + '</h6></marquee></strong><button class="close sisa_cuti" data-dismiss="alert"></button></div>');
        } else {
          $('.sisa_cuti').hide();
        }
      }
    },
  });
}

$(document).ready(function () {
  if (window.location == base_url + "/form/overview/TM") {
    loadTotal();
    $("#employee_name").select2();
    $("#employee_name option:selected").prop("selected", false);
    $("#employee_name option:selected").removeAttr("selected");
    $("#employee_name_single").select2({
      dropdownParent: $("#modalManageEmployeeTO"),
    });


    $.ajax({
      type: "GET",
      url: "form/getLastDay/",
      dataType: "json",
      success: function (response) {
        var today = new Date();
        // var nik = $("#req_to_nik").val();
        if (today.getDate() > 17) {
          var this_month = new Date(today.getFullYear(), today.getMonth(), 1);
          $("#start_date_request_time_off").datepicker("setStartDate", this_month);
          $("#end_date_request_time_off").datepicker("setStartDate", this_month);
          $("#start_date_request_time_off").datepicker("setEndDate", new Date(response));
          $("#end_date_request_time_off").datepicker("setEndDate", new Date(response));
        } else {
          var lastMonth = new Date(today.getFullYear(), (today.getMonth() - 1), 1);
          $("#start_date_request_time_off").datepicker("setStartDate", lastMonth);
          $("#end_date_request_time_off").datepicker("setStartDate", lastMonth);
          $("#start_date_request_time_off").datepicker("setEndDate", new Date(response));
          $("#end_date_request_time_off").datepicker("setEndDate", new Date(response));
        }
      },
    });
  }

  $('input.checkAll').click(function () {
    $('input.checkShift').prop('checked', this.checked);
  });
});

function inputCount() {
  var display = document.getElementById("counter");
  var sisa = 255 - $("#notes_time_off").val().length;
  display.innerHTML = sisa + "/255";
}

$(".request_time_off").click(function () {
  loadCIH();
  var jenis = $("#time_off_type").val();
  var kode = $("#time_off_code").val();
  var start_date = $("#start_date_request_time_off").val();
  var end_date = $("#end_date_request_time_off").val();
  var waktu_masuk = 0;
  var waktu_keluar = 0;
  var upload_file = $("#upload_file").val();
  var note = $("#notes_time_off").val();
  if (kode == "IDT") {
    waktu_masuk = $("#request_masuk").val();
  } else if (kode == "IPC") {
    waktu_keluar = $("#request_keluar").val();
  }
  if ($("#radioCutiHalf").is(":checked")) {
    jenis = "Cuti Tahunan Setengah Hari";
  }
  var url = "form/request_time_off";
  //alert(start_date);
  if (
    start_date == "" ||
    start_date === undefined ||
    end_date == "" ||
    end_date === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Tanggal Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (jenis == " " || jenis === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Tipe Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (
    kode == "CT" &&
    !$("#radioCutiHalf").is(":checked") &&
    !$("#radioCutiFull").is(":checked")
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Jenis Cuti Tahunan tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (kode == "IDT" && $("#request_masuk").val() == "") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Waktu Masuk tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (kode == "IPC" && $("#request_keluar").val() == "") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Waktu Keluar tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (kode == "S" && (upload_file == "" || upload_file === undefined)) {
    var cek_tgl = checkDate();
    if (cek_tgl > 0) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Upload File tidak boleh kosong",
        showConfirmButton: false,
        timer: 1500,
      });
      return false;
    }
  } else if (kode == "CK" && (upload_file == "" || upload_file === undefined)) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Upload File tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (upload_file == "" || upload_file === undefined) {
    var status_file = 0;
  } else {
    var status_file = 1;
  }

  var form_data = new FormData($("#form_time_off")[0]);
  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your data.',
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
  $.ajax({
    url: url,
    dataType: "json",
    type: "POST",
    data: {
      jenis: jenis,
      kode: kode,
      start_date: start_date,
      end_date: end_date,
      note: note,
      waktu_masuk: waktu_masuk,
      waktu_keluar: waktu_keluar,
      status_file: status_file,
    },
    success: function (data) {
      if (data == true) {
        if (kode == "CK" || (kode == "S" && upload_file != "")) {
          $.ajax({
            type: "POST",
            url: "form/save_file/upload_file",
            data: form_data,
            processData: false,
            contentType: false,
            success: function (res) {
              var title = [
                "Ukuran file telah melebihi batas maksimum",
                "File hanya terupload separuh",
                "Direktori file tidak ditemukan",
                "Error saat menyimpan file",
                "Tipe file tidak sesuai",
                "Tidak dapat mengupload file",
              ];
              if (res == "true") {
                $("#table_request_time_off").DataTable().ajax.reload();
                $("#table_balance_log").DataTable().ajax.reload();
                // $("#sisa").load(loadTotal());
                loadTotal();
                Swal.fire({
                  position: "center",
                  icon: "success",
                  title: "Request berhasil dikirimkan",
                  showConfirmButton: false,
                  timer: 1500,
                });
                $("#modalRequestTimeOff").find("input,textarea").val("").end();
                $(".custom-file-label").text("Choose file");
                $("#time_off_type").val(" ").trigger("change");
                loadCIH();
              } else {
                Swal.fire({
                  position: "center",
                  icon: "error",
                  title: title[res],
                  showConfirmButton: false,
                  timer: 2500,
                });
                return false;
              }
            },
          });
        } else {
          $("#table_request_time_off").DataTable().ajax.reload();
          $("#table_balance_log").DataTable().ajax.reload();
          // $("#sisa").load(loadTotal());
          loadTotal();
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Request berhasil dikirimkan",
            showConfirmButton: false,
            timer: 1500,
          });
          $("#modalRequestTimeOff").find("input,textarea").val("").end();
          $(".custom-file-label").text("Choose file");
          $("#time_off_type").val(" ").trigger("change");
          loadCIH();
        }
        loadTotal();
        $("#end_date_request_time_off").datepicker("setStartDate", "0d");
        $("#end_date_request_time_off").datepicker("setEndDate", false);
      } else if (data == "start_end") {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "Tidak bisa request karena,<br>end date sebelum start date",
          showConfirmButton: false,
          timer: 3000,
        });
      } else if (
        data == "prev_sakit" &&
        (upload_file == "" || upload_file === undefined)
      ) {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "Tidak bisa request sebelum<br>surat keterangan disertakan",
          showConfirmButton: false,
          timer: 3000,
        });
      } else if (
        data == "next_sakit" &&
        (upload_file == "" || upload_file === undefined)
      ) {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "Tidak bisa request sebelum<br>surat keterangan disertakan",
          showConfirmButton: false,
          timer: 3000,
        });
      } else if (data == "minus_six") {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Tidak bisa request karena<br>sisa cuti diatas -6",
          showConfirmButton: false,
          timer: 3000,
        });
      } else if (data == "holiday") {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Tidak bisa request pada<br>Hari Libur Nasional",
          showConfirmButton: false,
          timer: 3000,
        });
      }
      // $("#sisa").load(loadTotal());
      loadTotal();
    },
    error: function (data) {
      $("#table_request_time_off").DataTable().ajax.reload();
      $("#table_balance_log").DataTable().ajax.reload();
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Request tidak dapat dikirimkan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

function delete_request_time_off(DeleteTimeOff) {
  Swal.fire({
    title: "Are you sure?",
    text: "Request tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Delete",
  }).then((result) => {
    if (result.isConfirmed) {

      Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we process your data.',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      var id = document.getElementById(DeleteTimeOff).getAttribute("id");
      var url = "form/getDeleteRequestTimeOff/";
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $("#table_request_time_off").DataTable().ajax.reload();
            $("#table_balance_log").DataTable().ajax.reload();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Request telah dibatalkan",
              showConfirmButton: false,
              timer: 1500,
            });
            loadCIH();
            loadCTAB();
          } else {
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Request tidak dapat dibatalkan",
              showConfirmButton: false,
              timer: 1500,
            });
          }
          // $("#sisa").load(loadTotal());
          loadTotal();
        },
        error: function (data) {
          $("#table_request_time_off").DataTable().ajax.reload();
          $("#table_balance_log").DataTable().ajax.reload();
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Request tidak dapat dibatalkan",
            showConfirmButton: false,
            timer: 1500,
          });
        },
      });
    }
  });
}

function detail_approval_time_off(request_id) {
  window.location.href = "form/detail_approval/TM/" + request_id;
}

$("#start_date_request_time_off").change(function () {
  var start_date = $(this).val();
  var tipe_time_off = $('#time_off_type').val(); // TIME MANAGEMENT 2.0
  $.ajax({
    type: "POST",
    url: "form/getAlreadyRequestedDay",
    dataType: "json",
    data: { start_date: start_date, tipe_time_off: tipe_time_off }, // TIME MANAGEMENT 2.0
    success: function (response) {
      if (response[0] == true) {
        if (response[1] == "day_off") {
          Swal.fire({
            position: "center",
            icon: "warning",
            title: "Anda memiliki jadwal Day Off di tanggal tersebut",
            showConfirmButton: false,
            timer: 2000,
          });
        } else {
          Swal.fire({
            position: "center",
            icon: "warning",
            title:
              "Anda sudah melakukan request<br>" +
              response[1] +
              "<br>di tanggal<br>" + response[2] + " - " + response[3],
            showConfirmButton: true,
            // timer: 2000,
          });
        }
        $("#start_date_request_time_off").val("");
        $("#end_date_request_time_off").val("");
        $("#end_date_request_time_off").datepicker("setStartDate", "0d");
        $("#end_date_request_time_off").datepicker("setEndDate", false);
        return false;
      }
    },
  });

  if (
    $("#time_off_code").val() == "IDT" ||
    $("#time_off_code").val() == "IPC" ||
    $("#radioCutiHalf").is(":checked") ||
    $("#time_off_code").val() == "CRM"
  ) {
    $("#end_date_request_time_off").val($(this).val());
  } else if ($("#time_off_code").val() == "S") {
    checkDate();
    date_range = checkNewDate();
    if (date_range[0] < 0) {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        date_range[0] + "d"
      );
    } else {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        "+" + date_range[0] + "d"
      );
    }
    $("#end_date_request_time_off").val("");
  } else if ($("#time_off_code").val() == "CM") {
    date_range = checkNewDate();
    end_date = date_range[0] + date_range[1] + 2;
    if (date_range[0] < 0) {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        date_range[0] + "d"
      );
    } else {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        "+" + date_range[0] + "d"
      );
    }
    if (end_date < 0) {
      $("#end_date_request_time_off").datepicker("setEndDate", end_date + "d");
    } else {
      $("#end_date_request_time_off").datepicker(
        "setEndDate",
        "+" + end_date + "d"
      );
    }
    $("#end_date_request_time_off").val("");
  } else if (
    $("#time_off_code").val() == "CMA" ||
    $("#time_off_code").val() == "CKA" ||
    $("#time_off_code").val() == "CBA" ||
    $("#time_off_code").val() == "CKM" ||
    $("#time_off_code").val() == "CIM"
  ) {
    date_range = checkNewDate();
    end_date = date_range[0] + date_range[1] + 1;
    if (date_range[0] < 0) {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        date_range[0] + "d"
      );
    } else {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        "+" + date_range[0] + "d"
      );
    }
    if (end_date < 0) {
      $("#end_date_request_time_off").datepicker("setEndDate", end_date + "d");
    } else {
      $("#end_date_request_time_off").datepicker(
        "setEndDate",
        "+" + end_date + "d"
      );
    }
    $("#end_date_request_time_off").val("");
  } else if (
    $("#time_off_code").val() == "CL" ||
    $("#time_off_code").val() == "CK"
  ) {
    time_off_code = $("#time_off_code").val();
    date_range = checkMonths(time_off_code);
    end_date = date_range[0] + date_range[1];
    if (date_range[0] < 0) {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        date_range[0] + "d"
      );
    } else {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        "+" + date_range[0] + "d"
      );
    }
    if (end_date < 0) {
      $("#end_date_request_time_off").datepicker("setEndDate", end_date + "d");
    } else {
      $("#end_date_request_time_off").datepicker(
        "setEndDate",
        "+" + end_date + "d"
      );
    }
    $("#end_date_request_time_off").val("");
  } else {
    date_range = checkNewDate();
    if (date_range[0] < 0) {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        date_range[0] + "d"
      );
    } else {
      $("#end_date_request_time_off").datepicker(
        "setStartDate",
        "+" + date_range[0] + "d"
      );
    }
    $("#end_date_request_time_off").val("");
  }
});

$("#end_date_request_time_off").change(function () {
  if ($("#time_off_code").val() == "S") {
    checkDate();
  }
  var start_date = $("#start_date_request_time_off").val();
  var tipe_time_off = $('#time_off_type').val(); // TIME MANAGEMENT 2.0
  var end_date = $(this).val();
  $.ajax({
    type: "POST",
    url: "form/getAlreadyRequestedDay/end",
    dataType: "json",
    data: { start_date: start_date, end_date: end_date, tipe_time_off: tipe_time_off },
    success: function (response) {
      if (response[0] == true) {
        Swal.fire({
          position: "center",
          icon: "warning",
          title:
            "Anda sudah melakukan request<br>" +
            response[1] +
            "<br>di tanggal<br>" + response[2] + " - " + response[3],
          showConfirmButton: true,
          // timer: 2000,
        });
        $("#end_date_request_time_off").val("");
        return false;
      }
    },
  });
});

$("#time_off_type").change(function () {
  var id = $(this).children(":selected").attr("id");
  var code = "kode";
  var add = code.concat(id);
  var getVal = document.getElementById(add).text;

  $("div.kode_time_off select").val(getVal).change();
  $("#modalRequestTimeOff").find("input,textarea").val("").end();
  $("input[name=customRadio]").prop("checked", false);
  $("#end_date_request_time_off").attr("disabled", false);
  $("#end_date_request_time_off").datepicker("setStartDate", "0d");
  $("#end_date_request_time_off").datepicker("setEndDate", false);
  $(".custom-file-label").text("Choose file");

  $("#jenis_cuti").attr("hidden", true);
  $("#waktu").attr("hidden", true);
  $("#upload").attr("hidden", true);

  if ($("#time_off_code").val() == "IDT") {
    $("#waktu").attr("hidden", false);
    $("#waktuMasuk").attr("hidden", false);
    $("#waktuKeluar").attr("hidden", true);
    $("#end_date_request_time_off").attr("disabled", true);
  } else if ($("#time_off_code").val() == "IPC") {
    $("#waktu").attr("hidden", false);
    $("#waktuMasuk").attr("hidden", true);
    $("#waktuKeluar").attr("hidden", false);
    $("#end_date_request_time_off").attr("disabled", true);
  } else if ($("#time_off_code").val() == "CT") {
    $("#jenis_cuti").attr("hidden", false);
  } else if ($("#time_off_code").val() == "CRM") {
    $("#end_date_request_time_off").attr("disabled", true);
  } else if (
    $("#time_off_code").val() == "CK" ||
    $("#time_off_code").val() == "S"
  ) {
    $("#upload").attr("hidden", false);
  } else {
  }
});

// WORKHOUR
// $('#start_date_request_time_off').datepicker({
//     daysOfWeekDisabled: "0,6",
//     autoclose: true,
//     todayHighlight:'TRUE',
//  });
// $('#end_date_request_time_off').datepicker({
//     daysOfWeekDisabled: "0,6",
//     autoclose: true,
//     todayHighlight:'TRUE',
// });
//

$("#radioCutiHalf").click(function () {
  $("#end_date_request_time_off").attr("disabled", true);
  $("#modalRequestTimeOff").find("input,textarea").val("").end();
});
$("#radioCutiFull").click(function () {
  $("#end_date_request_time_off").attr("disabled", false);
  $("#modalRequestTimeOff").find("input,textarea").val("").end();
});

function checkDate() {
  // var tgl1 = new Date($("#start_date_request_time_off").val());
  // var tgl2 = new Date($("#end_date_request_time_off").val());
  // var jarak_time = tgl2.getTime() - tgl1.getTime();
  // var jarak_tgl = jarak_time / 1000 / 60 / 60 / 24;
  var startDate = new Date($("#start_date_request_time_off").val());
  var endDate = new Date($("#end_date_request_time_off").val());

  var days_difference = (endDate.getTime() - startDate.getTime()) / 86400000;

  var weekdends = Math.floor(days_difference / 7) * 2;

  (days_difference % 7) + startDate.getDay() == 6 ? weekdends += 2 :
    (days_difference % 7) + startDate.getDay() == 5 ? weekdends += 1 :
      weekdends;

  var jarak_tgl = days_difference - weekdends
  return jarak_tgl;
}

function checkNewDate() {
  var tgl1 = new Date($("#start_date_request_time_off").val());
  var tgl2 = new Date();
  tgl2.setHours(0, 0, 0, 0);
  jarak_time = Date.parse(tgl1) - Date.parse(tgl2);
  jarak_tgl = jarak_time / 1000 / 60 / 60 / 24;

  if (tgl1.getDay() === 4 || tgl1.getDay() === 5) {
    return [jarak_tgl, 2];
  } else {
    return [jarak_tgl, 0];
  }
}

function checkMonths(time_off_code) {
  var tgl1 = new Date($("#start_date_request_time_off").val());
  var tgl2 = new Date();
  var set_month;
  tgl2.setHours(0, 0, 0, 0);
  jarak_time = Date.parse(tgl1) - Date.parse(tgl2);
  jarak_tgl = jarak_time / 1000 / 60 / 60 / 24;

  new_month = new Date($("#start_date_request_time_off").val());
  if (time_off_code == "CL") {
    set_month = new Date(new_month.setMonth(tgl1.getMonth() + 3));
  } else if (time_off_code == "CK") {
    set_month = new Date(new_month.setMonth(tgl1.getMonth() + 1));
    var last_month = new Date(
      set_month.getFullYear(),
      set_month.getMonth() + 1,
      0
    ).getDate();
    set_month = new Date(
      set_month.setDate(set_month.getDate() + last_month / 2)
    );
  }
  jarak_time2 = Date.parse(set_month) - Date.parse(tgl1);
  jarak_bulan = jarak_time2 / 1000 / 60 / 60 / 24;
  return [jarak_tgl, jarak_bulan];
}

$('.adjust_employee_to').click(function () {
  var module = $("#management_module").val();
  var code = $("#module_code").val();
  var name = $("#employee_name").val();
  var amount = $("#amount").val();
  var sign = '';
  var emp_name = $("#employee_name_single").val();
  var date = $("#adj_ctab").val();
  var month = $("#adj_pg_month").val();
  var year = $("#adj_pg_year").val();
  var url = "form/adjustEmployeeTO";
  if (code == 'CTAB') {
    name = '';
    amount = '';

    if ((emp_name == " ") || (emp_name === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Karyawan tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    } else if ((date == " ") || (date == null) || (date === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Tanggal tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
  } else if (code == 'PG') {
    name = '';
    date = '';

    if ((emp_name == " ") || (emp_name === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Karyawan tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    } else if ((amount == "") || (name === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Jumlah tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
  } else {
    emp_name = '';
    date = '';

    if ((name == "") || (name === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Karyawan tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    } else if ((code == 'ACT') && (!($('#radioPlus').is(":checked"))) && (!($('#radioMinus').is(":checked")))) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Jenis perubahan tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    } else if ((amount == "") || (name === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Jumlah tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
  }
  if ($('#radioPlus').is(":checked")) {
    var sign = 'plus';
  } else if ($('#radioMinus').is(":checked")) {
    var sign = 'minus';
  }

  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your data.',
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { module: module, code: code, name: name, amount: amount, sign: sign, emp_name: emp_name, date: date, month: month, year: year },
    success: function (data) {
      $('#table_request_adjustment').DataTable().ajax.reload();
      // $('#table_balance_log').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Adjustment berhasil dilakukan',
        showConfirmButton: false,
        timer: 1500
      });
      $('#modalManageEmployeeTO').find("input").val('').end();
      // $("#employee_name").val(null).trigger("change");
      $("#employee_name option:selected").prop("selected", false);
      $("#employee_name option:selected").removeAttr("selected");
      $('input[name=customRadio]').prop('checked', false);
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Adjustment tidak dapat dilakukan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$("#management_module").change(function () {
  var id = $(this).children(":selected").attr("id");
  var code = "kode";
  var add = code.concat(id);
  var getVal = document.getElementById(add).text;

  $("div.kode_modul select").val(getVal).change();
  $("#modalManageEmployeeTO").find("input").val("").end();
  $("input[name=customRadio]").prop("checked", false);
  // $("#employee_name").select2("val", "");
  // $("#employee_name_single").select2("val", "");
  $("#employee_name option:selected").prop("selected", false);
  $("#employee_name option:selected").removeAttr("selected");
  // $("#employee_name").val("").trigger("change");

  $("#employee_name_single").val("").trigger("change");

  if ($('#module_code').val() == 'PG') {
    $('#emp_multi').attr('hidden', true);
    $('#adjustment_type').attr('hidden', true);
    $('#adj_amount').attr('hidden', false);
    $('#emp_single').attr('hidden', false);
    $('#ctab_date').attr('hidden', true);
    $('#adj_month').attr('hidden', false);
    $('#adj_year').attr('hidden', false);
  } else if ($('#module_code').val() == 'CTAB') {
    $('#emp_multi').attr('hidden', true);
    $('#adjustment_type').attr('hidden', true);
    $('#adj_amount').attr('hidden', true);
    $('#emp_single').attr('hidden', false);
    $('#ctab_date').attr('hidden', false);
    $('#adj_month').attr('hidden', true);
    $('#adj_year').attr('hidden', true);
  } else if ($('#module_code').val() == 'ACT') {
    $('#emp_multi').attr('hidden', false);
    $('#adjustment_type').attr('hidden', false);
    $('#adj_amount').attr('hidden', false);
    $('#emp_single').attr('hidden', true);
    $('#ctab_date').attr('hidden', true);
    $('#adj_month').attr('hidden', true);
    $('#adj_year').attr('hidden', true);
  }
});

$("#employee_name_single").change(function () {
  var emp_nik = $(this).val();
  $.ajax({
    type: "POST",
    url: "form/getCutiTidakAbsenHR/" + emp_nik,
    dataType: "json",
    success: function (response) {
      $("#adj_ctab").empty();
      for (let x in response) {
        $("#adj_ctab").append(
          $("<option></option>")
            .attr({ value: response[x] })
            .text(response[x])
        );
      }
    },
  });
});

$("#modalManageEmployeeTO").on("hidden.bs.modal", function () {
  // $("#employee_name").val("").trigger("change");
  $("#employee_name option:selected").prop("selected", false);
  $("#employee_name option:selected").removeAttr("selected");
  $("#employee_name_single").val("").trigger("change");
});

$("#req_absent_date").change(function () {
  var val = $(this).children(":selected").attr("value");

  if (val == " ") {
    $("#req_absent_schedule_in").val(null).trigger("change");
    $("#req_absent_schedule_out").val(null).trigger("change");
    $("#req_absent_clock_in").val(null).trigger("change");
    $("#req_absent_clock_in").attr("disabled", false);
    $("#req_absent_is_status").val(null);
  } else {
    $.ajax({
      type: "POST",
      url: "form/getDateSchedule/" + val,
      dataType: "json",
      success: function (response) {
        $("#req_absent_schedule_in")
          .val(response[0]["schedule_in"])
          .trigger("change");
        $("#req_absent_schedule_out")
          .val(response[0]["schedule_out"])
          .trigger("change");
        if (response[0]["check_in"] == "" || response[0]["check_in"] == null) {
          $("#req_absent_clock_in").val("");
          $("#req_absent_clock_in").attr("disabled", false);
          $("#req_absent_is_status").val(0);
        } else {
          $("#req_absent_clock_in")
            .val(response[0]["check_in"])
            .trigger("change");
          $("#req_absent_clock_in").attr("disabled", true);
          $("#req_absent_is_status").val(1);
        }
      },
    });
  }
});

$(".request_absent").click(function () {
  var date = $("#req_absent_date").val();
  var clock_in = $("#req_absent_clock_in").val();
  var clock_out = $("#req_absent_clock_out").val();
  // var upload_file = $("#req_absent_upload_file").val();
  var is_status = $("#req_absent_is_status").val();

  var note = $("#req_absent_notes").val();
  var url = "form/request_attendance";

  if (
    clock_in == "" ||
    clock_in === undefined ||
    clock_out == "" ||
    clock_out === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Waktu absen tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (date == " " || date === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Tanggal absen tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }
  // else if ((upload_file == "") || (upload_file === undefined)) {
  //     Swal.fire({
  //       position: 'center',
  //       icon: 'error',
  //       title: 'Upload dokumen tidak boleh kosong',
  //       showConfirmButton: false,
  //       timer: 1500
  //     });
  //     return false;
  // }
  else if (note == "" || note === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Deskripsi kronologi tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your data.',
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  $.ajax({
    url: url,
    dataType: "json",
    type: "POST",
    data: {
      date: date,
      clock_in: clock_in,
      clock_out: clock_out,
      note: note,
      is_status: is_status,
    },
    success: function (data) {
      if (data == true) {
        $("#table_request_time_off").DataTable().ajax.reload();
        $("#table_balance_log").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Request berhasil dikirimkan",
          showConfirmButton: false,
          timer: 1500,
        });
        $("#modalRequestAttendance").find("input,textarea").val("").end();
        $(".custom-file-label").text("Choose file");
        $("#req_absent_date").find("option:selected").remove();
      }
    },
    error: function (data) {
      $("#table_request_time_off").DataTable().ajax.reload();
      $("#table_balance_log").DataTable().ajax.reload();
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Request tidak dapat dikirimkan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

$("#print_out_req_tm").click(function () {
  var request_id = $("#request_id").val();
  window.open(
    "form/print_out_absen/" + request_id,
    "_blank",
    "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600"
  );
});

//////////////////// TIME MANAGEMENT 2.0 ////////////////////
$('#submit_shift_schedule').click(function () {
  var start_date = encodeURIComponent(JSON.stringify($("#start_date_submit_shift").val()));
  var end_date = encodeURIComponent(JSON.stringify($("#end_date_submit_shift").val()));
  $.ajax({
    type: 'POST',
    url: 'form/checkSchedule',
    dataType: 'json',
    data: 'start_date=' + start_date + '&end_date=' + end_date,
    success: function (response) {
      if (response == true) {
        window.location.href = "form/submit_schedule_shift?type=shift&start_date=" + start_date + "&end_date=" + end_date;
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Tidak terdapat jadwal shift pada Tanggal tersebut.',
          showConfirmButton: false,
          timer: 1500
        });
        return false;
      }
    }
  });

});

function responseRequestTMHR(type) {

  var id = $('#request_id').val();
  //return false;

  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your data.',
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  if (type == 'Reject') {

    var url = 'inbox/cekNote'
    $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data: { id: id },
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
                url: "inbox/responseRequestTMHR",
                type: 'post',
                data: 'id=' + id + '&resp=' + type,
                dataType: 'json',
                success: function (response) {

                  if (response.status == 1) {

                    window.location.href = 'inbox/approval';
                    swalWithBootstrapButtons.fire('Thank You!', 'Response has been saved.', 'success')

                  } else {
                    swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
                  }

                },
                error: function (response) {
                  alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                }
              });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
            }
          })

        } else {

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

  } else {

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
          url: "inbox/responseRequestTMHR",
          type: 'post',
          data: 'id=' + id + '&resp=' + type,
          dataType: 'json',
          success: function (response) {

            if (response.status == 1) {

              window.location.href = 'inbox/approval';
              swalWithBootstrapButtons.fire('Thank You!', 'Response has been saved.', 'success')

            } else {
              swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
            }

          },
          error: function (response) {
            alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
      }
    })

  }
}

function submitRequestTM(type) {

  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your data.',
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  var nik = $('#request_nik').val();
  var desc = $('#description_schedule').val();
  if (type == 'shift') {
    var start_date = $('#request_start_date').val();
    var end_date = $('#request_end_date').val();
    var content = 'nik=' + nik + '&tipe=' + type + '&start_date=' + start_date + '&end_date=' + end_date + '&desc=' + desc;
  } else {
    var purpose = $('#description_schedule').val();
    var location = $('#location_schedule').val();

    if ((purpose == "") || (purpose === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Deskripsi tujuan bekerja tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
    if ((location == "") || (location === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Lokasi pekerjaan tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return f
      alse;
    }
    var date = $('#request_date').val();
    var content = 'nik=' + nik + '&tipe=' + type + '&date=' + date + '&purpose=' + purpose + '&location=' + location;
  }

  var email1 = $('#shift_email1').text();
  var email2 = $('#shift_email2').text();
  if (email1 == "none" || email2 == "none") {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: "Email Approver tidak tersedia!",
      showConfirmButton: false,
      timer: 1500
    });
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
        url: "form/submitRequestTM",
        type: 'post',
        data: content,
        dataType: 'json',
        success: function (response) {

          if (response.status == true) {

            window.location.href = "form/detail_approval_tm_schedule/TM/" + response.request_id;
            swalWithBootstrapButtons.fire('Success!', 'Schedule has been submitted.', 'success')

          } else {
            swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
          }

        },
        error: function (response) {
          alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
    }
  })

}

function detail_approval_req_adj(request_num) {
  window.location.href = "form/detail_approval_hr_adjust/TM/" + request_num;
}

function delete_request_adjustment(DeleteReqAdj) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Request tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {

      Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we process your data.',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });


      var id = document.getElementById(DeleteReqAdj).getAttribute("id");
      var url = 'form/getDeleteRequestAdjustment/hr_adj';
      $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#table_request_adjustment').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Request telah dibatalkan',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Request tidak dapat dibatalkan',
              showConfirmButton: false,
              timer: 1500
            });
          }
        },
        error: function (data) {
          $('#table_request_adjustment').DataTable().ajax.reload();
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Request tidak dapat dibatalkan',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  })
}

function detail_approval_sch_req(request_id) {
  window.location.href = "form/detail_approval_tm_schedule/TM/" + request_id;
}

function delete_request_schedule(DeleteReqSch) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Request tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {

      Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we process your data.',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      var id = document.getElementById(DeleteReqSch).getAttribute("id");
      var url = 'form/getDeleteRequestAdjustment/tm_sch';
      $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#table_schedule_request').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Request telah dibatalkan',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Request tidak dapat dibatalkan',
              showConfirmButton: false,
              timer: 1500
            });
          }
        },
        error: function (data) {
          $('#table_schedule_request').DataTable().ajax.reload();
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Request tidak dapat dibatalkan',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  })
}

$('#print_out_req_sch').click(function () {
  var request_id = $("#request_id").val();
  window.open("form/print_out_schedule/" + request_id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");
});

$('#print_out_req_hol').click(function () {
  var request_id = $("#request_id").val();
  window.open("form/print_out_schedule_hol/" + request_id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");
});

function responseRequestSchedule(type) {

  var id = $('#request_id').val();

  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your data.',
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  if (type == 'Reject' || type == 'Revised' || type == 'RevisedHR') {

    var list_shift = new Array();
    var list_shift_un = new Array();
    $(".checked_id_shift").each(function () {
      var ischecked = $(this).is(':checked');
      if (ischecked) {
        list_shift.push($(this).val());
      } else {
        list_shift_un.push($(this).val());
      }
    });
    if (list_shift == '') {
      list_shift.push('');
    }
    if (list_shift_un == '') {
      list_shift_un.push('');
    }
    var url = 'form/check_shift_by_hr/';

    $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data: { type: type, list_shift: list_shift, list_shift_un: list_shift_un, id: id },
      beforeSend: function () {
        Swal.fire({
          position: "center",
          title: "Please Wait...",
          onBeforeOpen: () => {
            Swal.showLoading();
          },
        });
      },
      success: function (data) {
        if (data == true) {
          $('#table_shift_schedule').DataTable().ajax.reload();
          // Swal.fire({
          //   position: 'center',
          //   icon: 'info',
          //   title: 'Data telah diperbaharui',
          //   showConfirmButton: true,
          //   timer: 1500
          // });
        }
      },
      error: function (error) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
        return false;
      }
    });

    var url = 'inbox/cekNote/TM'
    $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data: { id: id },
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
                url: "inbox/responseRequestSchedule",
                type: 'post',
                data: 'id=' + id + '&resp=' + type,
                dataType: 'json',
                success: function (response) {

                  if (response.status == 1) {

                    window.location.href = 'inbox/approval_TM_ztm';
                    swalWithBootstrapButtons.fire('Thank You!', 'Response has been saved.', 'success')

                  } else {
                    swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
                  }

                },
                error: function (response) {
                  alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                }
              });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
            }
          })

        } else {

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

  } else {

    if (type == 'Checked') {
      var list_shift = new Array();
      var list_shift_un = new Array();
      $(".checked_id_shift").each(function () {
        var ischecked = $(this).is(':checked');
        if (ischecked) {
          list_shift.push($(this).val());
        } else {
          list_shift_un.push($(this).val());
        }
      });

      if (list_shift_un != 0) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Tidak dapat melanjutkan proses sebelum selesai diperiksa semua.',
          showConfirmButton: false,
          timer: 3000
        });
        return false;
      }

      var list_shift = new Array();
      var list_shift_un = new Array();
      $(".checked_id_shift").each(function () {
        var ischecked = $(this).is(':checked');
        if (ischecked) {
          list_shift.push($(this).val());
        } else {
          list_shift_un.push($(this).val());
        }
      });
      if (list_shift == '') {
        list_shift.push('');
      }
      if (list_shift_un == '') {
        list_shift_un.push('');
      }
      var url = 'form/check_shift_by_hr/';

      $.ajax({
        url: url,
        dataType: 'json',
        type: 'POST',
        data: { type: type, list_shift: list_shift, list_shift_un: list_shift_un, id: id },
        beforeSend: function () {
          Swal.fire({
            position: "center",
            title: "Please Wait...",
            onBeforeOpen: () => {
              Swal.showLoading();
            },
          });
        },
        success: function (data) {
          if (data == true) {
            $('#table_shift_schedule').DataTable().ajax.reload();
            // Swal.fire({
            //   position: 'center',
            //   icon: 'info',
            //   title: 'Data telah diperbaharui',
            //   showConfirmButton: true,
            //   timer: 1500
            // });
          }
        },
        error: function (error) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Data tidak dapat diperbaharui',
            showConfirmButton: false,
            timer: 1500
          });
          return false;
        }
      });
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
          url: "inbox/responseRequestSchedule",
          type: 'post',
          data: 'id=' + id + '&resp=' + type,
          dataType: 'json',
          success: function (response) {

            if (response.status == 1) {

              if (type != 'Resubmitted') {
                window.location.href = 'inbox/approval_TM_ztm';
              } else {
                window.location.href = 'home/request';
              }
              swalWithBootstrapButtons.fire('Thank You!', 'Response has been saved.', 'success')

            } else {
              swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
            }

          },
          error: function (response) {
            alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
      }
    })

  }
}

$('#submit_holiday_schedule').click(function () {
  var date = encodeURIComponent(JSON.stringify($("#date_submit_dayoff").val()));

  window.location.href = "form/submit_schedule_holiday/holiday/" + date;

});

function edit_shift_check_time(time, shift_atd, type, shift_type) {
  var id = document.getElementById(shift_atd).getAttribute("id");
  $("#edit_check_time_id").val(id);
  $("#edit_check_time").val(time);
  $("#edit_check_time_type").val(type);
  $("#edit_check_time_shift_type").val(shift_type);
}

$('.update_shift_check_time').click(function () {
  var id = $("#edit_check_time_id").val();
  var time = $("#edit_check_time").val();
  var type = $("#edit_check_time_type").val();
  var shift_type = $("#edit_check_time_shift_type").val();

  $.ajax({
    url: 'form/editShiftAttendance',
    dataType: 'json',
    type: 'POST',
    data: { id: id, time: time, type: type, shift_type: shift_type },
    success: function (data) {
      $('#table_shift_schedule').DataTable().ajax.reload(() => {
        document.body.scrollTop = startPos;
      }, false);
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Data telah diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    },
    error: function (data) {
      $('#table_shift_schedule').DataTable().ajax.reload(() => {
        document.body.scrollTop = startPos;
      }, false);
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function edit_shift_check_date(date, shift_atd, type) { //TIME MANAGEMENT 2.4
  var id = document.getElementById(shift_atd).getAttribute("id");

  $("#edit_check_date_id").val(id);
  $("#edit_check_date").val(date);
  $("#edit_check_date_type").val(type);
}

$('.update_shift_check_date').click(function () {
  var id = $("#edit_check_date_id").val();
  var date = $("#edit_check_date").val();
  var type = $("#edit_check_date_type").val();

  $.ajax({
    url: 'form/editShiftAttendanceDate',
    dataType: 'json',
    type: 'POST',
    data: { id: id, date: date, type: type },
    success: function (data) {
      $('#table_shift_schedule').DataTable().ajax.reload(() => {
        document.body.scrollTop = startPos;
      }, false);
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Data telah diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    },
    error: function (data) {
      $('#table_shift_schedule').DataTable().ajax.reload(() => {
        document.body.scrollTop = startPos;
      }, false);
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$('.check_shift_row').click(function () {
  var id = $("#request_id").val();
  var list_shift = new Array();
  var list_shift_un = new Array();
  $(".checked_id_shift").each(function () {
    var ischecked = $(this).is(':checked');
    if (ischecked) {
      list_shift.push($(this).val());
    } else {
      list_shift_un.push($(this).val());
    }
  });
  if (list_shift == '') {
    list_shift.push('');
  }
  if (list_shift_un == '') {
    list_shift_un.push('');
  }
  var url = 'form/check_shift_by_hr/';

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { list_shift: list_shift, list_shift_un: list_shift_un, id: id },
    beforeSend: function () {
      Swal.fire({
        position: "center",
        title: "Please Wait...",
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (data) {
      if (data == true) {
        $('#table_shift_schedule').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (error) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$('.update_additional_info_holiday').click(function () {
  var id = $("#request_id").val();
  var pur = $("#description_schedule").val();
  var loc = $("#location_schedule").val();

  $.ajax({
    url: 'form/update_info_holiday/',
    dataType: 'json',
    type: 'POST',
    data: { pur: pur, loc: loc, id: id },
    success: function (data) {
      if (data == true) {
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (error) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$('.update_additional_info_shift').click(function () {
  var id = $("#request_id").val();
  var pur = $("#description_schedule").val();

  $.ajax({
    url: 'form/update_info_shift/',
    dataType: 'json',
    type: 'POST',
    data: { pur: pur, id: id },
    success: function (data) {
      if (data == true) {
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (error) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function edit_shift_type(type, shift_atd) {
  var id = document.getElementById(shift_atd).getAttribute("id");

  $("#edit_check_shift_id").val(id);
  $("input[name=customRadio]").prop("checked", false);

  var shift_type = "#radio".concat(type);
  $(shift_type).prop("checked", true);
}

$('.update_shift_type').click(function () {
  var id = $("#edit_check_shift_id").val();
  var shift_type = $('input[name="customRadio"]:checked').val();

  $.ajax({
    url: 'form/editShiftType',
    dataType: 'json',
    type: 'POST',
    data: { id: id, shift_type: shift_type },
    success: function (data) {
      $('#table_shift_schedule').DataTable().ajax.reload(() => {
        document.body.scrollTop = startPos;
      }, false);
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Data telah diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    },
    error: function (data) {
      $('#table_shift_schedule').DataTable().ajax.reload(() => {
        document.body.scrollTop = startPos;
      }, false);
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});
////////////////////////////////////////////////////////////////////////

// START CR 3 TM
$(".request_location").click(function () {
  var date = $("#date_req_loc").val();
  var loc_in = 0;
  var loc_out = 0;
  if ($("#req_loc_in").val() == 1) {
    var upload_in = $("#req_loc_in_upload_file").val();
    loc_in++;
  } else {
    var upload_in = "";
  }
  if ($("#req_loc_out").val() == 1) {
    var upload_out = $("#req_loc_out_upload_file").val();
    loc_out++;
  } else {
    var upload_out = "";
  }
  var url = "form/request_location";

  if (date == "" || date === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Tanggal request tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }
  else if ((upload_in == "" || upload_in === undefined) && (upload_out == "" || upload_out === undefined)) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Upload bukti tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }
  else if ((loc_in == 1 && loc_out == 1) && ((upload_in == "" || upload_in === undefined) || (upload_out == "" || upload_out === undefined))) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Upload bukti tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  var form_data = new FormData($("#form_req_loc")[0]);
  $.ajax({
    type: "POST",
    url: "form/save_file_location/" + loc_in + '/' + loc_out,
    data: form_data,
    processData: false,
    contentType: false,
    beforeSend: function () {
      Swal.fire({
        position: "center",
        title: "Please Wait...",
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });
    },
    success: function (res) {
      var title = [
        "Ukuran file telah melebihi batas maksimum",
        "File hanya terupload separuh",
        "Direktori file tidak ditemukan",
        "Error saat menyimpan file",
        "Tipe file tidak sesuai",
        "Tidak dapat mengupload file",
      ];
      if (
        res == 0 ||
        res == 1 ||
        res == 2 ||
        res == 3 ||
        res == 4 ||
        res == 5
      ) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: title[res],
          showConfirmButton: false,
          timer: 2500,
        });
        return false;
      } else {
        var result = JSON.parse(res);
        var file_in = result[0];
        var file_out = result[1];
        $.ajax({
          type: "POST",
          url: url,
          dataType: "json",
          data: { date: date, file_in: file_in, file_out: file_out },
          success: function (response) {
            if (response) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Request Lokasi berhasil",
                showConfirmButton: false,
                timer: 2500,
              }).then(function () {
                window.location.href = "form/detail_approval/TM/" + response;
              });
            } else {
              Swal.fire({
                position: "center",
                icon: "error",
                title: "Request Lokasi gagal",
                showConfirmButton: false,
                timer: 1500,
              });
            }

            $(".custom-file-label").text("Choose file");
          },
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Request gagal diajukan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

$("#end_date_request_time_off").change(function () {
  var start_date = $("#start_date_request_time_off").val();
  var end_date = $("#end_date_request_time_off").val();
  const s_date = new Date(start_date);
  const e_date = new Date(end_date);
  if(start_date != '' && start_date != null){
    if (s_date <= e_date) {
      $.ajax({
        type: "POST",
        url: "form/getCalendarEmployee",
        dataType: "json",
        data: { end_date: end_date},
        success: function (response) {
          if (response == false) {
              Swal.fire({
                position: "center",
                icon: "warning",
                title: "Kalender Karyawan belum terbentuk ditanggal tersebut,<br>silahkan hubungi tim HR untuk konfirmasi lebih lanjut",
                showConfirmButton: true,
                // timer: 2000,
              });
              
              $(".request_time_off").prop("disabled", true);
              
          }else{

              $(".request_time_off").prop("disabled", false);

          }
        },
      });

    } else {

        Swal.fire({
          position: "center",
          icon: "warning",
          title: "You cannot submit the data because End Date is earlier than Start Date",
          showConfirmButton: false,
          timer: 3000,
        });
        return false;
    }
  }
});

/////////////////////////////////////////////////////// END TIME MANAGEMENT 2024 /////////////////////////////////////////////////////////