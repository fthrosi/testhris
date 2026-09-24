// RESPONSE
$("#eapp-approved_pa").click(function (e) {
  e.preventDefault();
  $("#modalComment").modal("toggle");

  var ReqId = $("#id_request").val();
  var ReqNum = $("#request_number").val();
  var ReqNumDecrypt = $("#request_number_decrypt").val();
  var final_score = $("#final_score").val();
  var new_employee_flag = $("#new_employee_flag").val();

  if (new_employee_flag == 1) {
  } else {
    if (final_score == 0 || final_score == "") {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Please check Final Score.",
        showConfirmButton: false,
        timer: 2000,
      });
      return false;
    }

    if (final_score > 10) {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Please enter Final Score less than or equal to 10.",
        showConfirmButton: false,
        timer: 2000,
      });
      return false;
    }
  }

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
  
  if (ReqId != "" || ReqId != "undefined") {

    // e.preventDefault();
    var request_id = $("#id_request").val();
    var id_form_request = $("#id_form_request").val();
    var approval_id = $("#approval_id").val();
    var request_number = $("#request_number").val();
    var otp = $("#otp_code").val();
    var final_score = $("#final_score").val();
    var comment_head_approve = $("#comment_head_approve").val();

    $.ajax({
      url: "form/approve_pa/Approved",
      type: "post",
      data:
        "id=" +
        request_id +
        "&id_form_request=" +
        id_form_request +
        "&request_number=" +
        request_number +
        "&approval_id=" +
        approval_id +
        "&final_score=" +
        final_score +
        "&comment_head_approve=" +
        comment_head_approve,
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
            position: "top-end",
            icon: "success",
            title: response.message,
            showConfirmButton: false,
            timer: 2500,
          }).then(function() {
            window.history.back();
          });
          // window.location.href = "inbox/approval";
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: response.message,
            showConfirmButton: false,
            timer: 2500,
          }).then(function() {
            window.history.back();
          });
          // window.location.href = "inbox/approval";
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
  } else {
    alert("Request ID Not Found.");
    return false;
  }
});

function show_uom() {
  $.ajax({
    url: "inbox/read_uom2",
    method: "get",
    dataType: "json",
    success: function (data) {
      // console.log(data)
      $("#plan_unit").html("<option value = ''></option>");
      $.each(data, function (i, item) {
        // alert(data[i].uom);
        $("#plan_unit").append(
          "<option value = '" +
            data[i].uom +
            ";" +
            data[i].formula +
            "'>" +
            data[i].uom +
            " [" +
            data[i].formula +
            "]</option>"
        );
      });
    },
  });
}

function show_uom_update(unit) {
  var selected = "";
  $.ajax({
    url: "inbox/read_uom2",
    method: "get",
    dataType: "json",
    success: function (data) {
      // console.log(data)
      // alert(unit);
      $("#update_plan_unit").html("<option value = '' ></option>");
      $.each(data, function (i, item) {
        // alert(data[i].uom);
        if (unit.replace(/ /g, "") == data[i].uom + ";" + data[i].formula) {
          // alert("sama");
          selected = "selected";
        } else {
          selected = "";
        }
        $("#update_plan_unit").append(
          "<option value = '" +
            data[i].uom +
            ";" +
            data[i].formula +
            "' " +
            selected +
            ">" +
            data[i].uom +
            " [" +
            data[i].formula +
            "]</option>"
        );
      });
    },
  });
}

function show_uom_kpi() {
  $.ajax({
    url: "inbox/read_uom2",
    method: "get",
    dataType: "json",
    success: function (data) {
      // console.log(data)
      $("#kpi_unit").html("<option value = ''></option>");
      $.each(data, function (i, item) {
        // alert(data[i].uom);
        $("#kpi_unit").append(
          "<option value = '" +
            data[i].uom +
            ";" +
            data[i].formula +
            "'>" +
            data[i].uom +
            " [" +
            data[i].formula +
            "]</option>"
        );
      });
    },
  });
}

function show_uom_update_kpi(unit) {
  var selected = "";
  $.ajax({
    url: "inbox/read_uom2",
    method: "get",
    dataType: "json",
    success: function (data) {
      // alert(data);
      // console.log(data)
      // alert(unit + "xxxx");
      $("#update_kpi_unit").html("<option value = '' checked></option>");
      $("#update_plan_unit").html("<option value = '' checked></option>");
      $.each(data, function (i, item) {
        $("#update_kpi_unit").append(
          "<option value = '" +
            data[i].uom +
            ";" +
            data[i].formula +
            "' " +
            selected +
            ">" +
            data[i].uom +
            " [" +
            data[i].formula +
            "]</option>"
        );
      });
      $("#update_kpi_unit").val(unit.replace(/ /g, "")).change();
      $("#update_plan_unit").val(unit.replace(/ /g, "")).change();
    },
  });
}

function show_uom_add_kpi(unit) {
  var selected = "";
  $.ajax({
    url: "inbox/read_uom2",
    method: "get",
    dataType: "json",
    success: function (data) {
      // alert(data);
      // console.log(data)
      $("#kpi_unit").html("<option value = '' checked></option>");
      $.each(data, function (i, item) {
        // alert(data[i].uom);
        if (unit == data[i].uom + ";" + data[i].formula) {
          selected = "selected";
        } else {
          selected = "";
        }
        $("#kpi_unit").append(
          "<option value = '" +
            data[i].uom +
            ";" +
            data[i].formula +
            "' " +
            selected +
            ">" +
            data[i].uom +
            " [" +
            data[i].formula +
            "]</option>"
        );
      });
    },
  });
}

function validateCodeApproved() {
  // e.preventDefault();
  var request_id = $("#id_request").val();
  var id_form_request = $("#id_form_request").val();
  var approval_id = $("#approval_id").val();
  var request_number = $("#request_number").val();
  var otp = $("#otp_code").val();
  var final_score = $("#final_score").val();
  var comment_head_approve = $("#comment_head_approve").val();

  $.ajax({
    url: "services/authen/validate/Approved",
    type: "post",
    data:
      "id=" +
      request_id +
      "&id_form_request=" +
      id_form_request +
      "&otp=" +
      otp +
      "&request_number=" +
      request_number +
      "&approval_id=" +
      approval_id +
      "&final_score=" +
      final_score +
      "&comment_head_approve=" +
      comment_head_approve,
    dataType: "json",
    success: function (response) {
      if (response.status == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: response.message,
          showConfirmButton: false,
          timer: 2500,
        }).then(function() {
          window.history.back();
        });
        // window.location.href = "inbox/approval";
      } else {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: response.message,
          showConfirmButton: false,
          timer: 2500,
        }).then(function() {
          window.history.back();
        });
        // window.location.href = "inbox/approval";
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

function responseRequestPa(type) {
  var id = $("#id_request").val();
  var approval_id = $("#approval_id").val();
  var comment_head = $("#comment_head_revise").val();
  if (type === "Revised") {
    if (comment_head == "") {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Please fill in the notes column',
        showConfirmButton: false,
        timer: 2500
      });
      return false;
    }
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
      title: "Are you sure? Don't forget to give notes.",
      text: "Revise this request",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure.",
      cancelButtonText: "Cancel.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        // alert("inbox/responserequest");
        // alert("id = " + id);
        // alert("resp = " + type);
        // alert("approval_id = " + approval_id);
        $.ajax({
          url: "inbox/responseRequestPa",
          type: "post",
          data: "id=" + id + "&resp=" + type + "&approval_id=" + approval_id + "&comment_pa=" + comment_head,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              // window.location.href = "inbox/approval";
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Response has been saved.",
                showConfirmButton: false,
                timer: 3000,
              }).then(function() {
                window.history.back();
              });
              // swalWithBootstrapButtons.fire(
              //   "Thank You!",
              //   "Response has been saved.",
              //   "success"
              // );
              // window.history.back();
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

function responseRequestPa2(type) {
  var id_pa = $("#id_request").val();
  var id = $("#id_form_request").val();
  var approval_id = $("#approval_id").val();

  if (type === "Revised" || type === "Reject") {
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
              text: "Revise this request",
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
                  url: "inbox/responseRequestPa2",
                  type: "post",
                  data: "id=" + id_pa + "&resp=" + type + "&approval_id=" + approval_id,
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
                      // window.location.href = "inbox/approval";
                      Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Response has been saved.",
                        showConfirmButton: false,
                        timer: 3000,
                      }).then(function() {
                        window.history.back();
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
            title: "Please fill out the notes column before revise",
            showConfirmButton: false,
            timer: 2500,
          });
        }
      },
      error: function (data) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Something went wrong. Please try again",
          showConfirmButton: false,
          timer: 1500,
        });
      },
    });
  }else{
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Something went wrong. Please try again",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }
}

function delete_draft_pa(id) {
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
          url: "home/request/delete_pa/" + id,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: response.messages,
                showConfirmButton: false,
                timer: 2500,
              }).then(function() {
                window.location.href = "home/request/";
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

function modal_add_skill(type) {
  if (type == "hard") {
    $("#title_modal_skill").text("Hard Skill");
    $("#div_soft_skill").hide();
    $("#div_hard_skill").show();
  } else if (type == "soft") {
    $("#div_hard_skill").hide();
    $("#div_soft_skill").show();
    $("#title_modal_skill").text("Soft Skill");
  }

  $("#training_category").val(type);
  $("#training_name").val("");
  $("#training_desc").val("");
  $("#div_skill_name").hide();
  $("#div_skill_desc").hide();
  $("#modalAddSkill").modal("toggle");
}

$("#select_hard_skill").change(function (e) {
  e.preventDefault();
  var skill = $("#select_hard_skill").val();

  if (skill == "Others") {
    $("#training_name").val("");
    $("#training_name").prop("disabled", false);
  } else {
    $("#training_name").prop("disabled", true);
    $("#training_name").val(skill);
  }

  $("#training_desc").val("");
  $("#div_skill_name").show();
  $("#div_skill_desc").show();
});

$("#select_soft_skill").change(function (e) {
  e.preventDefault();
  var skill = $("#select_soft_skill").val();

  if (skill == "Others") {
    $("#training_name").val("");
    $("#training_name").prop("disabled", false);
  } else {
    $("#training_name").prop("disabled", true);
    $("#training_name").val(skill);
  }

  $("#training_desc").val("");
  $("#div_skill_name").show();
  $("#div_skill_desc").show();
});

// Performance Plan
function modal_add_plan(type) {
  var count_fin = parseInt($("#countPlanFinancial").val());
  var count_cust = parseInt($("#countPlanCustomer").val());
  var count_int = parseInt($("#countPlanInternal").val());
  var count_learn = parseInt($("#countPlanLearning").val());

  var total_count_fin = parseInt(count_fin + 1);
  var total_count_cust = parseInt(count_cust + 1);
  var total_count_int = parseInt(count_int + 1);
  var total_count_learn = parseInt(count_learn + 1);

  var total_plan = parseInt(count_fin + count_cust + count_int + count_learn);
  // if (total_plan >= 5) {
  //   Swal.fire({
  //     position: "center",
  //     icon: "warning",
  //     title: "Maximum 5 Plan",
  //     showConfirmButton: false,
  //     timer: 1500,
  //   });
  //   return false;
  // }

  if (type == "f") {
    $("#title_modal_plan").text("Financial Perspective");
    $("#table_type").val("financial_perspective");

    // if (count_fin >= 4) {
    //   Swal.fire({
    //     position: "center",
    //     icon: "warning",
    //     title: "Maximum 4 Plan per Perspective",
    //     showConfirmButton: false,
    //     timer: 1500,
    //   });
    //   return false;
    // }
  } else if (type == "c") {
    $("#title_modal_plan").text("Customers Perspective");
    $("#table_type").val("cust_perspective");
    // if (count_cust >= 4) {
    //   Swal.fire({
    //     position: "center",
    //     icon: "warning",
    //     title: "Maximum 4 Plan per Perspective",
    //     showConfirmButton: false,
    //     timer: 1500,
    //   });
    //   return false;
    // }
  } else if (type == "i") {
    $("#title_modal_plan").text("Internal Process Perspective");
    $("#table_type").val("intern_perspective");
    // if (count_int >= 4) {
    //   Swal.fire({
    //     position: "center",
    //     icon: "warning",
    //     title: "Maximum 4 Plan per Perspective",
    //     showConfirmButton: false,
    //     timer: 1500,
    //   });
    //   return false;
    // }
  } else if (type == "l") {
    $("#title_modal_plan").text("Learning & Growth Perspective");
    $("#table_type").val("learn_perspective");
    // if (count_learn >= 4) {
    //   Swal.fire({
    //     position: "center",
    //     icon: "warning",
    //     title: "Maximum 4 Plan per Perspective",
    //     showConfirmButton: false,
    //     timer: 1500,
    //   });
    //   return false;
    // }
  }

  show_uom();

  $("#modalAddPlan").modal("toggle");
}

$("#add_training").click(function (e) {
  e.preventDefault();

  var id = $("#id_request").val();
  var training_name = $("#training_name").val();
  var training_desc = $("#training_desc").val();
  var training_category = $("#training_category").val();
  var category = "";

  if (training_category == "hard") {
    category = "Hard Skill";
  } else {
    category = "Soft Skill";
  }

  if (id == "" || training_name == "" || training_name == "xxx") {
    alert("All field is required.");
    return false;
  } else {
    var postData = {
      request_id: id,
      training_name: training_name,
      training_desc: training_desc,
      training_category: training_category,
    };

    $.ajax({
      method: "post",
      url: "form/save/add_training",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          var table = document.getElementById("training_table");
          var table_len = table.rows.length - 1;
          var row = (table.insertRow(table_len).outerHTML =
            "<tr id='kpi_training_row-" +
            response.id +
            "'>" +
            "<td id='kpi_training_cat-" +
            response.id +
            "'><a onclick='delete_training_row(" +
            response.id +
            ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-cross-circle-fill'></em></a><b id='kpi_training_category-" +
            response.id +
            "'> " +
            category +
            "</b></td>" +
            "<td id='kpi_training_name-" +
            response.id +
            "'><b id='kpi_training_name-" +
            response.id +
            "'> " +
            training_name +
            "</b></td>" +
            "<td id='kpi_training_desc-" +
            response.id +
            "'><b id='kpi_training_desc-" +
            response.id +
            "'> " +
            training_desc +
            "</b></td>" +
            "</tr>");

          document.getElementById("training_name").value = "";
          document.getElementById("training_desc").value = "";
          $("#select_hard_skill").val("xxx").change();
          $("#select_soft_skill").val("xxx").change();
          $("#countTraining").val(response.count_training);
          $("#modalAddSkill").modal("toggle");
        } else if (response.status == 2) {
          alert("Duplicate training. Pleace choose another");
        } else {
          alert("Something went wrong. Please try again.");
        }
      },
    });
  }
});

function delete_training_row(id_training) {
  var id = $("#id_request").val();
  var postData = {
    id_training: id_training,
    id_request: id,
  };

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-danger",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, remove!",
      cancelButtonText: "No.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: "form/save/delete_training",
          type: "post",
          data: postData,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              swalWithBootstrapButtons.fire("Removed!", "Deleted", "success");
              document.getElementById(
                "kpi_training_row-" + id_training + ""
              ).outerHTML = "";
              console.log(response);
              $("#countTraining").val(response.count_training);
            } else {
              swalWithBootstrapButtons.fire(
                "error",
                "Something went wrong.",
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

function show_uom_update_plan(unit) {
  var selected = "";
  $.ajax({
    url: "inbox/read_uom2",
    method: "get",
    dataType: "json",
    success: function (data) {
      // alert(data);
      // console.log(data)
      alert(unit + "xxxx");
      var unitx = unit.replace(/ /g, "");
      $("#update_plan_unit").html("<option value = '' checked></option>");
      $.each(data, function (i, item) {
        $("#update_kpi_unit").append(
          "<option value = '" +
            data[i].uom +
            ";" +
            data[i].formula +
            "' " +
            selected +
            ">" +
            data[i].uom +
            " [" +
            data[i].formula +
            "]</option>"
        );
        if (unitx == data[i].uom + ";" + data[i].formula) {
          alert("sama");
        }
      });

      alert("hihi");
    },
  });
}

function modal_update_plan(id) {
  var postData = { plan_id: id };
  $.ajax({
    url: "form/get_plan/",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      if (response == "financial_perspective") {
        $("#title_modal_plan_update").text("Financial Perspective");
        $("#table_type_update").val("financial_perspective");
      } else if (response == "cust_perspective") {
        $("#title_modal_plan_update").text("Customers Perspective");
        $("#table_type_update").val("cust_perspective");
      } else if (response == "intern_perspective") {
        $("#title_modal_plan_update").text("Internal Process Perspective");
        $("#table_type_update").val("intern_perspective");
      } else if (response == "learn_perspective") {
        $("#title_modal_plan_update").text("Learning & Growth Perspective");
        $("#table_type_update").val("learn_perspective");
      }

      var objective = $("#kpi_plan_objective-" + id).text();
      var measurement = $("#kpi_plan_measurement-" + id).text();
      var time = parseFloat($("#kpi_plan_time-" + id).text());
      var unit = $("#kpi_plan_unit-" + id).text();
      // alert("unit load = " + unit);
      const unit_split = unit.split(";");
      // show_uom_update_plan(unit);
      $("#update_plan_unit").val(unit).change();
      // alert(unit_split[0]);
      var target = $("#kpi_plan_target-" + id).text();
      // show_uom_update_kpi(unit);
      // var semester_1 = $("#kpi_plan_semester_1-" + id).text();
      // var semester_2 = $("#kpi_plan_semester_2-" + id).text();
      // var total = $("#kpi_plan_total-" + id).text();
      // alert(unit);

      // alert("hohehehe");
      $("#update_plan_objective").val(objective);
      $("#update_plan_measurement").val(measurement);
      $("#update_plan_time").val(time);
      $("#update_plan_target").val(target);
      // $("#update_plan_semester_1").val(semester_1);
      // $("#update_plan_semester_2").val(semester_2);
      // $("#update_plan_total").val(total);
      $("#id_plan_update").val(id);
      show_uom_update(unit);
      $("#modalUpdatePlan").modal("toggle");
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

function formatAngkaRupiah(angka) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return rupiah;
}

function number_format(el) {
  el.value = formatAngkaRupiah(el.value);
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

$("#modalUOM").on("shown.bs.modal", function () {
  $("#uom").focus();
});

$("#submitUOM").click(function () {
  // alert("hehehe");
  var data = $("#formUOM").serialize();
  var uom = $("#uom").val();
  var id = $("#id_uom").val();
  if (uom == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Name must be filled.",
      showConfirmButton: false,
      timer: 2000,
    });
    return false;
  }

  $.ajax({
    url: "inbox/save_uom/" + id,
    data: data,
    method: "post",
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Success",
          showConfirmButton: false,
          timer: 2500,
        }).then(function() {
          window.location.href = "inbox/hr_uom";
        });
      }
    },
  });
});

function openModalUOM(id) {
  // alert(id);
  $("#modalUOM").modal("show");

  $.ajax({
    type: "get",
    url: "inbox/get_uom/" + id,
    dataType: "json",
    success: function (data) {
      console.log(data);
      $.each(data, function (index, element) {
        // alert(element.uom);
        // $("#active_field").css("display","");
        // $("#is_active").prop("disabled",false);
        $("#uom").val(element.uom);
        $("#formula").val(element.formula).change();
        // $("#is_active").val(element.is_active).change();
        $("#id_uom").val(element.id);
      });
    },
  });
}

$(function () {
  $("#datepicker2")
    .datepicker({
      yearRange: "c-100:c",
      changeMonth: false,
      changeYear: true,
      showButtonPanel: false,
      closeText: "Select",
      currentText: "This year",
      onClose: function (dateText, inst) {
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).val($.datepicker.formatDate("yy", new Date(year, 1, 1)));
      },
    })
    .focus(function () {
      $(".ui-datepicker-month").hide();
      $(".ui-datepicker-calendar").hide();
      $(".ui-datepicker-current").hide();
      $(".ui-datepicker-prev").hide();
      $(".ui-datepicker-next").hide();
      $("#ui-datepicker-div").position({
        my: "left top",
        at: "left bottom",
        of: $(this),
      });
    })
    .attr("readonly", false);
});

$("#btnSaveUOM").click(function () {
  var data = $("#formUnit").serialize();
  var uom = $("#uom_name_plan").val();
  if (uom == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Name must be filled.",
      showConfirmButton: false,
      timer: 2000,
    });
    return false;
  }
  $("#btnSaveUOM").css("display", "none");
  $("#notifUOM").css("display", "");
  $.ajax({
    url: "inbox/save_uom",
    data: data,
    method: "post",
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Success add new unit",
          showConfirmButton: false,
          timer: 1000,
        });
        show_uom();
        $("#btnSaveUOM").css("display", "");
        $("#notifUOM").css("display", "none");
        $("#uom_name_plan").val("");
        $("#closeModalUOM").trigger("click");
      }
    },
    error: function (data) {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Something wrong.",
        showConfirmButton: false,
        timer: 2000,
      });
      return false;
    },
  });
});

$("#btnSaveUOMUpdate").click(function () {
  var data = $("#formUnitUpdate").serialize();
  var uom = $("#uom_name_update").val();
  if (uom == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Name must be filled.",
      showConfirmButton: false,
      timer: 2000,
    });
    return false;
  }

  $("#btnSaveUOMUpdate").css("display", "none");
  $("#notifUOMUpdate").css("display", "");
  $.ajax({
    url: "inbox/save_uom",
    data: data,
    method: "post",
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Success add new unit",
          showConfirmButton: false,
          timer: 1000,
        });
        show_uom_update($("#update_plan_unit option:selected").val());
        $("#btnSaveUOMUpdate").css("display", "");
        $("#notifUOMUpdate").css("display", "none");
        $("#uom_name_update").val("");
        $("#closeModalUOMUpdate").trigger("click");
      }
    },
    error: function (data) {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Something wrong.",
        showConfirmButton: false,
        timer: 2000,
      });
      return false;
    },
  });
});

$("#formula_uom").on("change.bootstrapSwitch", function (e) {
  // console.log(e.target.checked);
  if (e.target.checked) {
    $("#formulaUOMExample").html("Positif : (Achievement / Target)*100%");
  } else {
    $("#formulaUOMExample").html("Negative : (Target / Achievement )*100%");
  }
});

$("#formula_uom_update").on("change.bootstrapSwitch", function (e) {
  // console.log(e.target.checked);
  if (e.target.checked) {
    $("#formulaUOMExampleUpdate").html("Positif : (Achievement / Target)*100%");
  } else {
    $("#formulaUOMExampleUpdate").html(
      "Negative : (Target / Achievement )*100%"
    );
  }
});

/////////////////////////////// FORM PERFORMANCE APPRAISAL (KPI)
// Add Item KPI
$("#add_item_kpi").click(function (e) {
  e.preventDefault();
  var id = $("#id_request").val();
  var countKpi = parseInt($("#countKpi").val());
  var totalRowKpi = parseInt(countKpi + 1);

  var objective = document.getElementById("kpi_objective").value;
  var measurement = document.getElementById("kpi_measurement").value;
  var target = document.getElementById("kpi_target").value;
  var achievement = document.getElementById("kpi_achievement").value;
  var target_vs_achievement = document.getElementById("kpi_target_vs_achievement").value;
  var unit = $("#kpi_unit option:selected").val();
  var score = document.getElementById("kpi_score").value;
  var time = parseFloat(document.getElementById("kpi_time").value);
  var total_row = parseFloat(document.getElementById("kpi_total").value);

  var current_total_weight = parseFloat(
    document.getElementById("kpi_total_weight").value
  );
  var current_total_kpi = parseFloat(
    document.getElementById("kpi_total_score").value
  );

  var total_weight = parseFloat(time + current_total_weight);
  var kpi = parseFloat(total_row + current_total_kpi);
  var total_kpi = parseFloat(kpi).toFixed(3);

  // pre final score
  var grand_total_kpi = total_kpi * (85 / 100);
  var roundGrandKPI = grand_total_kpi.toFixed(3);
  var grand_total_qualitative = parseFloat($("#grand_total_qualitative").val());
  var pre_final_score = parseFloat(grand_total_qualitative + grand_total_kpi);
  var roundFinalScore = pre_final_score.toFixed(3);

  if (score > 10) {
    alert("Please enter Score value less than or equal to 10.");
    return false;
  }

  if (time > 100) {
    alert("Please enter Weight value less than or equal to 100.");
    return false;
  }

  if (
    objective.length == "" ||
    measurement.length == "" ||
    target.length == "" ||
    achievement.length == "" ||
    target_vs_achievement.length == "" ||
    score == "" ||
    time == "" ||
    // total_row == "" ||
    unit == ""
  ) {
    alert("All field is required.");
    return false;
  } else {
    var postData = {
      request_id: id,
      kpi_objective: objective,
      kpi_measurement: measurement,
      kpi_target: target,
      kpi_achievement: achievement,
      kpi_target_vs_achievement: target_vs_achievement,
      kpi_score: score,
      kpi_time: time,
      kpi_total_row: total_row,
      total_weight: total_weight,
      total_kpi: total_kpi,
      grand_total_kpi: roundGrandKPI,
      grand_total_qualitative: grand_total_qualitative,
      pre_final_score: roundFinalScore,
      unit: unit,
    };
    $("#add_item_kpi").css("display", "none");
    $.ajax({
      method: "post",
      url: "form/save/add_kpi",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          var table = document.getElementById("table_kpi_achievement");
          var table_len = table.rows.length - 1;
          var row = (table.insertRow(table_len).outerHTML =
            "<tr id='kpi_row-" +
            response.id +
            "'>" +
            "<td><a onclick='delete_kpi_row(" +
            response.id +
            ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-cross-circle-fill'></em></a><br><a onclick='update_kpi_row(" +
            response.id +
            ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-edit'></em></a></td>" +
            "<td id='kpi_objective_row" +
            response.id +
            "'><textarea disabled class='form-control' id='kpi_row_objective-" +
            response.id +
            "' >" +
            objective +
            "</textarea></td>" +
            "<td id='kpi_measurement_row" +
            response.id +
            "'><textarea disabled class='form-control' id='kpi_row_measurement-" +
            response.id +
            "' >" +
            measurement +
            "</textarea></td>" +
            "<td id='kpi_target_row" +
            response.id +
            "'><span id='kpi_row_target_per_year-" +
            response.id +
            "'> " +
            target +
            "</span></td>" +
            "<td id='kpi_achievement_row" +
            response.id +
            "'><span id='kpi_row_achievement-" +
            response.id +
            "'> " +
            achievement +
            "</span></td>" +
            "<td id='kpi_unit_row" +
            response.id +
            "'><span id='kpi_row_unit-" +
            response.id +
            "'> " +
            unit +
            "</span></td>" +
            "<td id='kpi_target_vs_achievement_row" +
            response.id +
            "'><span id='kpi_row_target_vs_achievement-" +
            response.id +
            "'> " +
            target_vs_achievement +
            "</span></td>" +
            "<td id='kpi_score_row" +
            response.id +
            "'><span id='kpi_row_score-" +
            response.id +
            "'> " +
            score +
            "</span></td>" +
            "<td id='kpi_row_time-" +
            response.id +
            "'><b id='kpi_row_time-" +
            response.id +
            "'> " +
            time +
            "</b></td>" +
            "<td id='kpi_row_total-" +
            response.id +
            "'><b id='kpi_row_total-" +
            response.id +
            "'> " +
            total_row +
            "</b></td>" +
            "</tr>");
          document.getElementById("kpi_objective").value = "";
          document.getElementById("kpi_measurement").value = "";
          document.getElementById("kpi_target").value = "";
          document.getElementById("kpi_achievement").value = "";
          document.getElementById("kpi_target_vs_achievement").value = "";
          document.getElementById("kpi_score").value = "";
          document.getElementById("kpi_time").value = "";
          document.getElementById("kpi_total").value = "";
          
          $("#countScoreIsi").val(response.update_score_isi);
          $("#countKpi").val(response.count_row_kpi);
          $("#kpi_total_weight").val(total_weight);
          $("#kpi_total_score").val(total_kpi);

          $("#total_kpi_score").val(total_kpi);
          $("#grand_total_kpi").val(roundGrandKPI);
          $("#pre_final_score").val(roundFinalScore);

          if (total_weight != 100) {
            $("#alert_weight").show();
          } else {
            $("#alert_weight").hide();
          }
          $("#add_item_kpi").css("display", "");
        } else {
          alert("Something went wrong. Please try again.");
          $("#add_item_kpi").css("display", "");
        }
      },
    });
  }
});

function delete_kpi_row(id) {
  var request_id = $("#id_request").val();
  var countKpi = parseInt($("#countKpi").val());
  var totalRowKpi = parseInt(countKpi - 1);

  var kpi_row_time = $("#kpi_row_time-" + id).text();
  var kpi_row_total = $("#kpi_row_total-" + id).text();
  var current_total_weight = $("#kpi_total_weight").val();
  var current_total_kpi = $("#kpi_total_score").val();
  var kpi = parseFloat(current_total_kpi - kpi_row_total);
  var total_kpi = parseFloat(kpi).toFixed(3);
  var total_weight = parseFloat(current_total_weight - kpi_row_time);

  // pre final score
  var pre_final_score = parseFloat($("#pre_final_score").val());
  var grand_total_qualitative = parseFloat($("#grand_total_qualitative").val());
  var grand_total_kpi = total_kpi * (85 / 100);
  var roundGrandKPI = grand_total_kpi.toFixed(3);

  var new_pre_final_score = parseFloat(
    grand_total_qualitative + grand_total_kpi
  );
  var roundFinalScore = new_pre_final_score.toFixed(3);
  // console.log(total_weight);
  // return false;

  var postData = {
    measurement_id: id,
    request_id: request_id,
    total_kpi: total_kpi,
    total_weight: total_weight,
    grand_total_qualitative: grand_total_qualitative,
    grand_total_kpi: roundGrandKPI,
    pre_final_score: roundFinalScore,
  };

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-danger",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, remove!",
      cancelButtonText: "No.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: "form/delete/kpi_item",
          type: "post",
          data: postData,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              document.getElementById("kpi_row-" + id + "").outerHTML = "";
              $("#kpi_total_weight").val(total_weight);
              $("#kpi_total_score").val(total_kpi); // total kpi per row

              $("#total_kpi_score").val(total_kpi); // sub total kpi
              $("#grand_total_kpi").val(roundGrandKPI); // grand total kpi
              $("#pre_final_score").val(roundFinalScore);

              $("#countScoreIsi").val(response.update_score_isi);
              $("#countKpi").val(totalRowKpi);

              if (total_weight != 100) {
                $("#alert_weight").show();
              } else {
                $("#alert_weight").hide();
              }

              swalWithBootstrapButtons.fire("Removed!", "Deleted", "success");
            } else {
              swalWithBootstrapButtons.fire(
                "error",
                "Something went wrong.",
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

function update_kpi_row(id) {
  $("#id_detail_update").val(id);
  var objective = $("#kpi_row_objective-" + id).text();
  var measurement = $("#kpi_row_measurement-" + id).text();
  var target = $("#kpi_row_target_per_year-" + id).text();
  var achievement = $("#kpi_row_achievement-" + id).text();
  var target_vs_achievement = $("#kpi_row_target_vs_achievement-" + id).text();
  var unit = $("#kpi_row_unit-" + id).text();
  var score = $("#kpi_row_score-" + id).text();
  var time = parseFloat($("#kpi_row_time-" + id).text());
  var total_row = parseFloat($("#kpi_row_total-" + id).text());
  const unit_split = unit.split(";");
  // alert(unit_split[0]);
  show_uom_update_kpi(unit);

  $("#update_kpi_objective").val(objective);
  $("#update_kpi_measurement").val(measurement);
  $("#update_kpi_target").val(target);
  $("#update_kpi_achievement").val(achievement);
  $("#update_kpi_target_vs_achievement").val(target_vs_achievement);
  $("#update_kpi_score").val(score);
  $("#update_kpi_time").val(time);
  $("#update_kpi_total").val(total_row);
  $("#modalUpdateKPI").modal("toggle");
}

$("#update_item_kpi").click(function (e) {
  e.preventDefault();

  var id = $("#id_request").val();
  var id_detail = $("#id_detail_update").val();

  var objective = document.getElementById("update_kpi_objective").value;
  var measurement = document.getElementById("update_kpi_measurement").value;
  var target = document.getElementById("update_kpi_target").value;
  var achievement = document.getElementById("update_kpi_achievement").value;
  var target_vs_achievement = document.getElementById("update_kpi_target_vs_achievement").value;
  var unit = $("#update_kpi_unit option:selected").val();
  var score = document.getElementById("update_kpi_score").value;

  // before update
  var previous_time = parseFloat($("#kpi_row_time-" + id_detail).text());
  var previous_total_row = parseFloat($("#kpi_row_total-" + id_detail).text());
  if (isNaN(previous_total_row)) {
    previous_total_row = 0;
  }
  var previous_total_weight = parseFloat(document.getElementById("kpi_total_weight").value);
  var previous_total_kpi = parseFloat(document.getElementById("kpi_total_score").value);
  // alert("Previous total kpi = " + previous_total_kpi);
  // alert("Previous total row = " + previous_total_row);
  var total_weight = parseFloat(previous_total_weight - previous_time);
  var total_kpi = parseFloat(previous_total_kpi - previous_total_row);
  // console.log("previous_total_kpi = "+previous_total_kpi);
  // console.log("previous_total_row = "+previous_total_row);
  // return false;
  // start update
  var new_time = parseFloat(document.getElementById("update_kpi_time").value);
  var new_total_row = parseFloat(document.getElementById("update_kpi_total").value);
  var new_total_weight = parseFloat(new_time + total_weight);
  var kpi = parseFloat(new_total_row + total_kpi);
  console.log(kpi);
  var new_total_kpi = parseFloat(kpi).toFixed(3);

  // pre final score
  var pre_final_score = parseFloat($("#pre_final_score").val());
  var grand_total_qualitative = parseFloat($("#grand_total_qualitative").val());
  var grand_total_kpi = new_total_kpi * (85 / 100);
  var roundGrandKPI = grand_total_kpi.toFixed(3);

  var new_pre_final_score = parseFloat(
    grand_total_qualitative + grand_total_kpi
  );
  var roundFinalScore = new_pre_final_score.toFixed(3);

  if (score > 10) {
    alert("Please enter Score value less than or equal to 10.");
    return false;
  }

  if (new_time > 100) {
    alert("Please enter Weight value less than or equal to 100.");
    return false;
  }

  if (
    objective.length == "" ||
    measurement.length == "" ||
    target.length == "" ||
    achievement.length == "" ||
    target_vs_achievement.length == "" ||
    score == "" ||
    new_time == "" ||
    // new_total_row == "0" ||
    unit == ""
  ) {
    alert("All field is required.");
    return false;
  } else {
    var postData = {
      request_id: id,
      id_detail: id_detail,
      kpi_objective: objective,
      kpi_measurement: measurement,
      kpi_target: target,
      kpi_achievement: achievement,
      kpi_target_vs_achievement: target_vs_achievement,
      kpi_score: score,
      kpi_time: new_time,
      kpi_total_row: new_total_row,
      total_weight: new_total_weight,
      total_kpi: new_total_kpi,
      grand_total_qualitative: grand_total_qualitative,
      grand_total_kpi: roundGrandKPI,
      pre_final_score: roundFinalScore,
      unit: unit,
    };
    
    $("#update_item_kpi").css("display", "none");
    $.ajax({
      method: "post",
      url: "form/save/update_kpi",
      data: postData,
      dataType: "json",
      success: function (response) {

        if (response.status == 1) {
          document.getElementById("update_kpi_objective").value = "";
          document.getElementById("update_kpi_measurement").value = "";
          document.getElementById("update_kpi_target").value = "";
          document.getElementById("update_kpi_achievement").value = "";
          document.getElementById("update_kpi_target_vs_achievement").value ="";
          document.getElementById("update_kpi_score").value = "";
          document.getElementById("update_kpi_time").value = "";
          document.getElementById("update_kpi_total").value = "";
          $("#update_kpi_unit").val("").change();

          $("#kpi_row_objective-" + id_detail).text(objective);
          $("#kpi_row_measurement-" + id_detail).text(measurement);
          $("#kpi_row_target_per_year-" + id_detail).text(target);
          $("#kpi_row_achievement-" + id_detail).text(achievement);
          $("#kpi_row_unit-" + id_detail).text(unit);
          $("#kpi_row_target_vs_achievement-" + id_detail).text(target_vs_achievement);
          $("#kpi_row_score-" + id_detail).text(score);
          $("#kpi_row_time-" + id_detail).text(new_time);
          $("#kpi_row_total-" + id_detail).text(new_total_row);

          $("#kpi_total_weight").val(new_total_weight);
          $("#kpi_total_score").val(new_total_kpi);

          // calculate total
          $("#total_kpi_score").val(new_total_kpi); // sub total kpi
          $("#grand_total_kpi").val(roundGrandKPI); // grand total kpi
          $("#pre_final_score").val(roundFinalScore);

          if (new_total_weight != 100) {
            $("#alert_weight").show();
          } else {
            $("#alert_weight").hide();
          }

          $("#countScoreIsi").val(response.update_score_isi);
          $("#update_item_kpi").css("display", "");
          // $("#modalUpdateKPI").modal("toggle");
        } else {
          $("#update_item_kpi").css("display", "");
          alert("Something went wrong. Please try again.");
        }
      },
    });
  }
});

function calculate_kpi_item(id) {
  var kpi_score = $("#kpi_score").val();
  var kpi_time = $("#kpi_time").val();
  var total = kpi_score * (kpi_time / 100);
  var roundTotal = total.toFixed(3);
  $("#kpi_total").val(roundTotal);
}

function calculate_update_kpi(id) {
  var kpi_score = $("#update_kpi_score").val();
  var kpi_time = $("#update_kpi_time").val();
  var total = kpi_score * (kpi_time / 100);
  var roundTotal = total.toFixed(3);
  $("#update_kpi_total").val(roundTotal);
}

// Qualitative
function calculate_assesment(id, id_req) {
  var plan_weight = $("#plan_weight_" + id).val();
  var plan_score = $("#plan_score_" + id).val();
  var total = plan_score * (plan_weight / 100);
  var roundTotal = total.toFixed(3);
  $("#plan_result_" + id).val(roundTotal);
  $("#tb_plan_result_" + id).text(roundTotal);
  ///////////////////Start Menambahkan nilai draft QA 2025/////////////////////
  if(plan_score != '' && plan_score != 0){
    
    var url = 'form/PA/post_qa/';
    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'json',
      data: { id: id, plan_score: plan_score, id_req: id_req},
      success: function (response) {
        if (response == 1) {
            console.log('Update plan '+id+' berhasil');
        }else{
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Data can not save",
              showConfirmButton: false,
              timer: 1500,
            });
        }
      },error: function (response) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Data can not save",
            showConfirmButton: false,
            timer: 1500,
        });
    },
    });
  }
  ///////////////////End Menambahkan nilai draft QA 2025/////////////////////

  if (plan_score > 10) {
    $("#tr_" + id).css("color", "#fff");
    $("#tr_" + id).css("background", "red");
    $("#alert_plan_" + id).show();
    $("#plan_score_" + id).val(10);
  } else {
    $("#tr_" + id).css("color", "");
    $("#tr_" + id).css("background", "");
    $("#alert_plan_" + id).hide();
  }

  calculate_assesment_total();
}

function calculate_assesment_total() {
  var total_1 = parseFloat($("#plan_result_1").val());
  var total_2 = parseFloat($("#plan_result_2").val());
  var total_3 = parseFloat($("#plan_result_3").val());
  var total_4 = parseFloat($("#plan_result_4").val());
  var total_5 = parseFloat($("#plan_result_5").val());
  var total_6 = parseFloat($("#plan_result_6").val());
  var total_7 = parseFloat($("#plan_result_7").val());
  var total_8 = parseFloat($("#plan_result_8").val());
  var total_9 = parseFloat($("#plan_result_9").val());

  var subtotal = parseFloat(
    total_1 +
      total_2 +
      total_3 +
      total_4 +
      total_5 +
      total_6 +
      total_7 +
      total_8 +
      total_9
  );

  var total_assesment = parseFloat(subtotal).toFixed(3);
  $("#kpi_total_assesment").val(total_assesment);
  $("#total_qualitative").val(total_assesment);

  var grand_total = total_assesment * (15 / 100);
  var roundGrandTotal = grand_total.toFixed(3);
  $("#grand_total_qualitative").val(roundGrandTotal);

  // pre final score
  var grand_total_kpi = parseFloat($("#grand_total_kpi").val());
  var pre_final_score = parseFloat(grand_total_kpi + grand_total);
  var roundFinalScore = pre_final_score.toFixed(3);
  $("#pre_final_score").val(roundFinalScore);
}

function calculate_pre_final_score() {
  var grand_total_kpi = parseFloat($("#grand_total_kpi").val());
  var grand_total_qualitative = parseFloat($("#grand_total_qualitative").val());
  var pre_final_score = parseFloat(grand_total_qualitative + grand_total_kpi);
  var roundFinal = pre_final_score.toFixed(3);

  var postData = {
    grand_total_kpi: grand_total_kpi,
    grand_total_qualitative: grand_total_qualitative,
    pre_final_score: roundFinal,
  };

  $.ajax({
    method: "post",
    url: "form/save/pre_final_score",
    data: postData,
    dataType: "json",
    success: function (response) {
      if (response.status == 1) {
        $("#pre_final_score").val(roundFinal);
      } else {
        alert("Something went wrong. Please try again.");
      }
    },
  });
}

function calculate_final_score() {
  // alert("sajksasa");
  // return false;
  var grade = "";
  var score = $("#final_score").val();
  if (score == "") {
    $("#grade").text("");
    return false;
  }

  var final_score = parseFloat($("#final_score").val());
  // var final_score = x_final_score.toFixed(1);

  if (final_score >= "9.1" || final_score == "10.0") {
    grade = "A";
  } else if (final_score >= "8.1" && final_score < "9.1") {
    grade = "B";
  } else if (final_score >= "6.9" && final_score < "8.1") {
    grade = "C";
  } else if (final_score >= "5.6" && final_score < "6.9") {
    grade = "D";
  } else if (final_score >= "0.0" && final_score < "5.6") {
    grade = "E";
  } else {
    grade = "";
  }

  if (final_score > 10) {
    $("#tr_final_score").css("color", "#fff");
    $("#tr_final_score").css("background", "red");
    $("#alert_fs").show();
  } else {
    $("#tr_final_score").css("color", "");
    $("#tr_final_score").css("background", "");
    $("#alert_fs").hide();

    $("#grade").text(grade);
  }
}

function save_final_score() {
  var id = $("#req_id_modal").val();
  var score = $("#final_score").val();
  var access_employee = $("#access_employee").val();
  if (score == "") {
    $("#tr_final_score").css("color", "#fff");
    $("#tr_final_score").css("background", "red");
    $("#alert_fs").show();
    $("#grade").text("");
    return false;
  } else {
    $("#tr_final_score").css("color", "");
    $("#tr_final_score").css("background", "");
    $("#alert_fs").hide();
  }

  var final_score = parseFloat($("#final_score").val());
  var postData = {
    id: id,
    final_score: final_score,
  };

  $.ajax({
    method: "post",
    url: "inbox/save/final_score",
    data: postData,
    dataType: "json",
    beforeSend: function () {
      $("#update-final").text("Please wait..");
    },
    success: function (response) {
      if (response.status == 1) {
        $("#update-final").text("Done.");

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Final Score updated successfully.",
          showConfirmButton: false,
          timer: 1000,
        });

        $("#modalQuickView").modal("toggle");
        if (access_employee == 4) {
          // window.location.href = "dashboard/mgmt";
          window.location.reload()
        } else {
          window.location.reload()
        }
      } else {
        alert("Something went wrong. Please try again.");
      }
    },
  });
}

$("#add_plan").click(function (e) {
  e.preventDefault();
  var id = $("#id_request").val();
  var count_fin = parseInt($("#countPlanFinancial").val());
  var count_cust = parseInt($("#countPlanCustomer").val());
  var count_int = parseInt($("#countPlanInternal").val());
  var count_learn = parseInt($("#countPlanLearning").val());

  var total_count_fin = parseInt(count_fin + 1);
  var total_count_cust = parseInt(count_cust + 1);
  var total_count_int = parseInt(count_int + 1);
  var total_count_learn = parseInt(count_learn + 1);

  var type = $("#table_type").val();
  var objective = document.getElementById("plan_objective").value;
  var measurement = document.getElementById("plan_measurement").value;
  var time = parseFloat(document.getElementById("plan_time").value);
  var unit = $("#plan_unit option:selected").val();
  // alert(unit);
  var target = document.getElementById("plan_target").value;
  // var semester_1 = document.getElementById("plan_semester_1").value;
  // var semester_2 = document.getElementById("plan_semester_2").value;
  // var total = document.getElementById("plan_total").value;

  var current_total_weight = parseFloat(
    document.getElementById("plan_total_weight").value
  );
  var total_weight = parseFloat(time + current_total_weight);

  if (time > 100) {
    alert("Please input weight value less than or equal to 100");
    return false;
  }

  if (
    objective == "" ||
    measurement == "" ||
    time == "" ||
    unit == "" ||
    target == ""
  ) {
    alert("All field is required.");
    return false;
  } else {
    $("#add_plan").css("display", "none");
    var postData = {
      request_id: id,
      objective: objective,
      measurement: measurement,
      time: time,
      unit: unit,
      target: target,
      // semester_1: semester_1,
      // semester_2: semester_2,
      // total: total,
      plan_perspective: type,
      plan_total_weight: total_weight,
    };
    $.ajax({
      method: "post",
      url: "form/save/add_plan",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          var table = document.getElementById(type);
          var table_len = table.rows.length - 1;
          // +
          // "," +
          // type
          var row = (table.insertRow(table_len).outerHTML =
            "<tr id='plan_row-" +
            response.id +
            "'>" +
            "<td><a onclick='delete_plan_row(" +
            response.id +
            ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-cross-circle-fill'></em></a><br><a onclick='modal_update_plan(" +
            response.id +
            ")' class='btn btn-icon btn-trigger'><em class='icon ni ni-edit'></em></a></td>" +
            "<td id='plan_row_objective" +
            response.id +
            "'><textarea disabled class='form-control' id='kpi_plan_objective-" +
            response.id +
            "' >" +
            objective +
            "</textarea></td>" +
            "<td id='plan_row_measurement" +
            response.id +
            "'><textarea disabled class='form-control' id='kpi_plan_measurement-" +
            response.id +
            "' >" +
            measurement +
            "</textarea></td>" +
            "<td id='plan_row_time" +
            response.id +
            "'><span id='kpi_plan_time-" +
            response.id +
            "'> " +
            time +
            "</span></td>" +
            "<td id='plan_row_unit" +
            response.id +
            "'><span id='kpi_plan_unit-" +
            response.id +
            "'> " +
            unit +
            "</span></td>" +
            "<td id='plan_row_target" +
            response.id +
            "'><span id='kpi_plan_target-" +
            response.id +
            "'> " +
            target +
            "</span></td>" +
            "</tr>");

          document.getElementById("plan_objective").value = "";
          document.getElementById("plan_measurement").value = "";
          document.getElementById("plan_time").value = "";
          document.getElementById("plan_unit").value = "";
          document.getElementById("plan_target").value = "";
          // document.getElementById("plan_semester_1").value = "";
          // document.getElementById("plan_semester_2").value = "";
          // document.getElementById("plan_total").value = "";

          $("#plan_total_weight").val(total_weight);
          $("#modalAddPlan").modal("toggle");

          if (type == "financial_perspective") {
            $("#countPlanFinancial").val(total_count_fin);
          } else if (type == "cust_perspective") {
            $("#countPlanCustomer").val(total_count_cust);
          } else if (type == "intern_perspective") {
            $("#countPlanInternal").val(total_count_int);
          } else if (type == "learn_perspective") {
            $("#countPlanLearning").val(total_count_learn);
          }

          if (total_weight != 100) {
            $("#alert_plan_weight").show();
          } else {
            $("#alert_plan_weight").hide();
          }
          $("#add_plan").css("display", "");
        } else {
          alert("Something went wrong. Please try again.");
          $("#add_plan").css("display", "");
        }
      },
    });
  }
});

function delete_plan_row(id) {
  var request_id = $("#id_request").val();
  var deleted_time = parseFloat($("#kpi_plan_time-" + id).text());
  var current_total_weight = parseFloat(
    document.getElementById("plan_total_weight").value
  );
  var total_weight = parseFloat(current_total_weight - deleted_time);

  var count_fin = parseInt($("#countPlanFinancial").val());
  var count_cust = parseInt($("#countPlanCustomer").val());
  var count_int = parseInt($("#countPlanInternal").val());
  var count_learn = parseInt($("#countPlanLearning").val());

  var total_count_fin = parseInt(count_fin - 1);
  var total_count_cust = parseInt(count_cust - 1);
  var total_count_int = parseInt(count_int - 1);
  var total_count_learn = parseInt(count_learn - 1);

  var postData = {
    plan_id: id,
    request_id: request_id,
    plan_total_weight: total_weight,
  };

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-danger",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, remove!",
      cancelButtonText: "No.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: "form/delete/plan_item",
          type: "post",
          data: postData,
          dataType: "json",
          success: function (response) {
            if (response.status == 1) {
              document.getElementById("plan_row-" + id + "").outerHTML = "";

              $("#plan_total_weight").val(total_weight);

              if (response.perspective == "financial") {
                $("#countPlanFinancial").val(total_count_fin);
              } else if (response.perspective == "customer") {
                $("#countPlanCustomer").val(total_count_cust);
              } else if (response.perspective == "internal") {
                $("#countPlanInternal").val(total_count_int);
              } else if (response.perspective == "learning") {
                $("#countPlanLearning").val(total_count_learn);
              }

              if (total_weight != 100) {
                $("#alert_plan_weight").show();
              } else {
                $("#alert_plan_weight").hide();
              }
              swalWithBootstrapButtons.fire("Removed!", "Deleted", "success");
            } else {
              swalWithBootstrapButtons.fire(
                "error",
                "Something went wrong.",
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

$("#update_plan").click(function (e) {
  e.preventDefault();
  var id = $("#id_request").val();
  var id_detail = $("#id_plan_update").val();
  var previous_time = parseFloat($("#kpi_plan_time-" + id_detail).text());
  var objective = document.getElementById("update_plan_objective").value;
  var measurement = document.getElementById("update_plan_measurement").value;
  var new_time = parseFloat(document.getElementById("update_plan_time").value);
  var unit = document.getElementById("update_plan_unit").value;
  var target = document.getElementById("update_plan_target").value;
  // var semester_1 = document.getElementById("update_plan_semester_1").value;
  // var semester_2 = document.getElementById("update_plan_semester_2").value;
  // var total = document.getElementById("update_plan_total").value;
  var previous_total_weight = parseFloat(
    document.getElementById("plan_total_weight").value
  );
  var weight = parseFloat(previous_total_weight - previous_time);
  var new_total_weight = parseFloat(weight + new_time);

  if (new_time > 100) {
    alert("Please input weight value less than or equal to 100");
    return false;
  }

  if (
    objective.length == "" ||
    measurement.length == "" ||
    new_time.length == "" ||
    unit.length == "" ||
    target.length == ""
  ) {
    alert("All field is required.");
    return false;
  } else {
    var postData = {
      request_id: id,
      id_detail: id_detail,
      plan_objective: objective,
      plan_measurement: measurement,
      plan_new_time: new_time,
      plan_unit: unit,
      plan_target: target,
      // plan_semester_1: semester_1,
      // plan_semester_2: semester_2,
      // plan_total: total,
      new_total_weight: new_total_weight,
    };
    console.log(postData);
    $("#update_plan").css("display", "none");

    $.ajax({
      method: "post",
      url: "form/save/update_plan",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          document.getElementById("update_plan_objective").value = "";
          document.getElementById("update_plan_measurement").value = "";
          document.getElementById("update_plan_time").value = "";
          document.getElementById("update_plan_unit").value = "";
          document.getElementById("update_plan_target").value = "";
          // document.getElementById("update_plan_semester_1").value = "";
          // document.getElementById("update_plan_semester_2").value = "";
          // document.getElementById("update_plan_total").value = "";

          $("#kpi_plan_objective-" + id_detail).text(objective);
          $("#kpi_plan_measurement-" + id_detail).text(measurement);
          $("#kpi_plan_time-" + id_detail).text(new_time);
          $("#kpi_plan_unit-" + id_detail).text(unit);
          $("#kpi_plan_target-" + id_detail).text(target);
          // $("#kpi_plan_semester_1-" + id_detail).text(semester_1);
          // $("#kpi_plan_semester_2-" + id_detail).text(semester_2);
          // $("#kpi_plan_total-" + id_detail).text(total);

          $("#plan_total_weight").val(new_total_weight);

          if (new_total_weight != 100) {
            $("#alert_plan_weight").show();
          } else {
            $("#alert_plan_weight").hide();
          }

          $("#modalUpdatePlan").modal("toggle");
          $("#update_plan").css("display", "");
        } else {
          alert("Something went wrong. Please try again.");
          $("#update_plan").css("display", "");
        }
      },
    });
  }
});

$("#btnSaveUOMUpdateKPI").click(function () {
  var data = $("#formUnitUpdateKPI").serialize();
  var uom = $("#uom_name_update").val();
  if (uom == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Name must be filled.",
      showConfirmButton: false,
      timer: 2000,
    });
    return false;
  }

  $("#btnSaveUOMUpdateKPI").css("display", "none");
  $("#notifUOMUpdateKPI").css("display", "");

  $.ajax({
    url: "inbox/save_uom",
    data: data,
    method: "post",
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Success add new unit",
          showConfirmButton: false,
          timer: 1000,
        });
        show_uom_update_kpi($("#update_kpi_unit option:selected").val());
        $("#btnSaveUOMUpdateKPI").css("display", "");
        $("#notifUOMUpdateKPI").css("display", "none");
        $("#uom_name_update").val("");
        $("#closeModalUOMUpdateKPI").trigger("click");
      }
    },
    error: function (data) {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Something wrong.",
        showConfirmButton: false,
        timer: 2000,
      });
      return false;
    },
  });
});

$("#btnSaveUOMAddKPI").click(function () {
  var data = $("#formUnitAddKPI").serialize();
  var uom = $("#uom_name").val();
  if (uom == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Name must be filled.",
      showConfirmButton: false,
      timer: 2000,
    });
    return false;
  }

  $("#btnSaveUOMAddKPI").css("display", "none");
  $("#notifUOMAddKPI").css("display", "");

  $.ajax({
    url: "inbox/save_uom",
    data: data,
    method: "post",
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Success add new unit",
          showConfirmButton: false,
          timer: 1000,
        });
        show_uom_add_kpi($("#kpi_unit option:selected").val());
        $("#btnSaveUOMAddKPI").css("display", "");
        $("#notifUOMAddKPI").css("display", "none");
        $("#uom_name").val("");
        $("#closeModalUOMAddKPI").trigger("click");
      }
    },
    error: function (data) {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Something wrong.",
        showConfirmButton: false,
        timer: 2000,
      });
      return false;
    },
  });
});

// function formula_score(achievement){
//   var score = 0;

//   return score;
// }

function target_vs_achievement_update() {
  var achievment = $("#update_kpi_achievement").val().split(".").join("");
  console.log(achievment)
  var target = $("#update_kpi_target").val().split(".").join("");
  var uom = $("#update_kpi_unit").find(":selected").val();
  var explode = uom.split(";");
  var formula = explode[1];
  // console.log(formula);
  if (formula == "positive" || formula == "Positive") {
    var total = parseFloat(parseFloat((achievment).replace(',', '.')) / parseFloat((target).replace(',', '.'))) * 100;
  } else if (formula == "negative" || formula == "Negative") {
    if(achievment == 0){
      var total = 0;
    }else{
      var total = parseFloat(parseFloat((target).replace(',', '.')) / parseFloat((achievment).replace(',', '.'))) * 100;
    }
  }

  if (total == undefined || isNaN(total)) {
    $("#update_kpi_target_vs_achievement").val("");
  } else {
    total = total.toFixed(1);
    $("#update_kpi_target_vs_achievement").val(total.toLocaleString("pt-BR"));
  }

  if (total >= 0) {
    // alert(total);
    $.ajax({
      url: "form/formula_score/" + total,
      type: "post",
      data: "",
      success: function (response) {
        // alert(response);
        // alert(score);
        $("#update_kpi_score").val(response);
        calculate_update_kpi();
      },
      error: function (response) {},
    });
  } else {
    $("#update_kpi_score").val("0");
    calculate_kpi_item();
  }

  // console.log(total);
}
//update_kpi_score
function target_vs_achievement() {
  var achievment = $("#kpi_achievement").val().split(".").join("");
  var target = $("#kpi_target").val().split(".").join("");
  var uom = $("#kpi_unit").find(":selected").val();
  var explode = uom.split(";");
  var formula = explode[1];
  console.log(formula);
  if (formula == "positive" || formula == "Positive") {
    var total = parseFloat(parseFloat(achievment) / parseFloat(target)) * 100;
  } else if (formula == "negative" || formula == "Negative") {
    if(achievment == 0){
      var total = 0;
    }else{
      var total = parseFloat(parseFloat(target) / parseFloat(achievment)) * 100;
    }
  }

  if (total == undefined || isNaN(total)) {
    $("#kpi_target_vs_achievement").val("");
  } else {
    total = total.toFixed(1);
    $("#kpi_target_vs_achievement").val(total.toLocaleString("pt-BR"));
  }

  if (total >= 0) {
    $.ajax({
      url: "form/formula_score/" + total,
      type: "post",
      data: "",
      success: function (response) {
        // alert(response);
        // alert(score);
        $("#kpi_score").val(response);
        calculate_kpi_item();
      },
      error: function (response) {},
    });
  } else {
    $("#kpi_score").val("0");
    calculate_kpi_item();
  }

  // console.log(total);

  // console.log("kpi score = "+kpiscore);
}

$("#update_kpi_target").keyup(function () {
  target_vs_achievement_update();
});

$("#update_kpi_achievement").keyup(function () {
  target_vs_achievement_update();
});

$("#update_kpi_unit").change(function () {
  // alert('hehehe');
  target_vs_achievement_update();
});

$("#kpi_target").keyup(function () {
  target_vs_achievement();
});

$("#kpi_achievement").keyup(function () {
  target_vs_achievement();
});

$("#kpi_unit").change(function () {
  // alert('hehehe');
  target_vs_achievement();
});

//view team member//
function viewTeamMember(division, no) {
  var no = no;
  var mod = "#modalViewTeamMember"+no;
  var table = "#tableViewTeamMember"+no;
  var postData = { division: division};
  $.ajax({
    url: "inbox/viewTeamMember/kadiv",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      // alert(response.data);
      $(table).html("");
      $.each(response.data, function (i, data) {
        // alert('salsjals');
        // alert(data.email);
        // console.log(data.email);
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.nik),
            $("<td>").text(data.complete_name),
            $("<td>").text(data.email),
            $("<td>").text(data.position)
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

function viewTeamMemberMul(division, no) {
  var no = no;
  var mod = "#modalViewTeamMember"+no;
  var table = "#tableViewTeamMember"+no;
  var postData = { division: division};
  $.ajax({
    url: "inbox/viewTeamMemberMul/kadiv",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      // alert(response.data);
      $(table).html("");
      $.each(response.data, function (i, data) {
        // alert('salsjals');
        // alert(data.email);
        // console.log(data.email);
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.nik),
            $("<td>").text(data.complete_name),
            $("<td>").text(data.email),
            $("<td>").text(data.position),
            $("<td>").text(data.status)
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

// function viewScoreSummary() {
//   var postData = { email: '' };
//   $.ajax({
//     url: "inbox/scorepa",
//     type: "post",
//     data: postData,
//     dataType: "json",
//     success: function (response) {
//       // console.log(response);

//       var no = 0;
//       // alert(response.data);
//       $("#tableScoreSummary").html("");
//       $.each(response.data, function (i, data) {
//         // alert('salsjals');
//         // alert(data.email);
//         // console.log(data.email);
//         no++;
//         var $tr = $("<tr>")
//           .append(
//             $("<td>").text(no),
//             $("<td>").text(data.nik),
//             $("<td>").text(data.complete_name),
//             $("<td>").text(data.email),
//             $("<td>").text(data.position),
//           )
//           .appendTo("#tableViewTeamMember");
//       });

//       $("#modalViewTeamMember").modal("toggle");
//     },
//     error: function (response) {
//       alert(
//         "Oops! There's something wrong. Please refresh this page and try again."
//       );
//     },
//   });
// }

function result_nine_box(performance, potential) {
  if (performance > 0 && potential > 0) {
    if (performance == 1 && potential == 1) {
      return "Low Contributor";
    } else if (performance == 1 && potential == 2) {
      return "Inconsistent Player";
    } else if (performance == 1 && potential == 3) {
      return "Potential Performer";
    } else if (performance == 2 && potential == 1) {
      return "Average Performer";
    } else if (performance == 2 && potential == 2) {
      return "Core Player";
    } else if (performance == 2 && potential == 3) {
      return "High Potential";
    } else if (performance == 3 && potential == 1) {
      return "Solid Performer";
    } else if (performance == 3 && potential == 2) {
      return "High Performer";
    } else if (performance == 3 && potential == 3) {
      return "Star";
    } else {
      return "";
    }
  } else {
    return "";
  }
}

function get_nine_box(note) {
  $("#ninebox").load(location.href + " #ninebox");
  // $.ajax({
  //   url: "inbox/get_nine_box/"+note,
  //   type: "post",
  //   dataType:'json',
  //   success: function (response) {
  //     $("#"+response.id).html("");
  //     console.log(response.data);
  //     console.log(response.id);
  //     jQuery.each(response.data, function (index, item) {
  //         // do something with `item` (or `this` is also `item` if you like)
  //         // console.log("index= " + index);
  //         // console.log("item = " + item.employee_name);
  //         $("#"+response.id).append(item.employee_name+"<br>");
  //     });
  //   }
  // })
}

function get_nine_box_pmo(note) {
  $("#ninebox_pmo").load(location.href + " #ninebox_pmo");
}

function countTalentTeam() {
  $.ajax({
    url: "inbox/countTalentMap/",
    type: "post",
    success: function (response) {
      console.log("talent = " + response);
      if (response == 1) {
        $("#submit_to_hr").css("display", "");
        $("#noteKurva").html("Ready To Submit");
        $("#noteKurva").css("color", "black");
      } else {
        $("#submit_to_hr").css("display", "none");
        $("#noteKurva").html("Need To Revise Or Talent Map not filled yet");
        $("#noteKurva").css("color", "red");
      }
    },
  });
}

function countTalentTeamSecond() {
  $.ajax({
    url: "inbox/countTalentMap/",
    type: "post",
    success: function (response) {
      console.log("talent = " + response);
      if (response == 1) {
        $("#submit_to_hr_second").css("display", "");
        $("#noteKurvaSecond").html("Ready To Submit");
        $("#noteKurvaSecond").css("color", "black");
      } else {
        $("#submit_to_hr_second").css("display", "none");
        $("#noteKurvaSecond").html("Need To Revise Or Talent Map not filled yet");
        $("#noteKurvaSecond").css("color", "red");
      }
    },
  });
}

function performance(id) {
  // alert(id);
  per = $("#performance_" + id + " option:selected").val();
  pot = $("#potential_" + id + " option:selected").val();
  note = result_nine_box(per, pot);
  // alert(val);
  $.ajax({
    url: "inbox/update_ninebox/performance/" + id + "/" + per + "/" + note,
    type: "post",
    success: function (response) {
      // alert(response);
      get_nine_box(response);
      $("#note_" + id).html(note);
      countTalentTeam();
    },
  });
}

function performance_pmo(id) {
  // alert(id);
  per = $("#performance_" + id + " option:selected").val();
  pot = $("#potential_" + id + " option:selected").val();
  note = result_nine_box(per, pot);
  // alert(val);
  $.ajax({
    url: "inbox/update_ninebox/performance/" + id + "/" + per + "/" + note,
    type: "post",
    success: function (response) {
      // alert(response);
      get_nine_box_pmo(response);
      $("#note_" + id).html(note);
      countTalentTeamSecond();
    },
  });
}

function potential(id) {
  // alert(id);
  pot = $("#potential_" + id + " option:selected").val();
  per = $("#performance_" + id + " option:selected").val();
  note = result_nine_box(per, pot);
  // alert(val);
  $.ajax({
    url: "inbox/update_ninebox/potential/" + id + "/" + pot + "/" + note,
    type: "post",
    success: function (response) {
      get_nine_box(response);
      $("#note_" + id).html(note);
      countTalentTeam();
    },
  });
}

function potential_pmo(id) {
  // alert(id);
  pot = $("#potential_" + id + " option:selected").val();
  per = $("#performance_" + id + " option:selected").val();
  note = result_nine_box(per, pot);
  // alert(val);
  $.ajax({
    url: "inbox/update_ninebox/potential/" + id + "/" + pot + "/" + note,
    type: "post",
    success: function (response) {
      get_nine_box_pmo(response);
      $("#note_" + id).html(note);
      countTalentTeamSecond();
    },
  });
}

function viewTeamMemberCEO(email) {
  var postData = { email: email };
  $.ajax({
    url: "inbox/viewTeamMember/ceo",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      // alert(response.data);
      $("#tableViewTeamMember").html("");
      $.each(response.data, function (i, data) {
        // alert('salsjals');
        // alert(data.email);
        // console.log(data.email);
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.nik),
            $("<td>").text(data.complete_name),
            $("<td>").text(data.email)
          )
          .appendTo("#tableViewTeamMember");
      });

      $("#modalViewTeamMember").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function viewTeamMemberPMO() {
  $.ajax({
    url: "inbox/viewTeamMember/pmo",
    type: "post",
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      $("#tableViewTeamMember").html("");
      $.each(response.data, function (i, data) {
        // alert('salsjals');
        // alert(data.email);
        // console.log(data.email);
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.nik),
            $("<td>").text(data.complete_name),
            $("<td>").text(data.email)
          )
          .appendTo("#tableViewTeamMember");
      });

      $("#modalViewTeamMember").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function is_valid_deviasi() {
  var is_valid = 0;
  var total_team = $("#hr_total_team").val();

  var a = $("#hr_basic_line_a_field").val();
  var b = $("#hr_basic_line_b_field").val();
  var c = $("#hr_basic_line_c_field").val();
  var d = $("#hr_basic_line_d_field").val();
  var e = $("#hr_basic_line_e_field").val();

  if (a == "" || b == "" || c == "" || d == "" || e == "") {
    is_valid++;
  }

  var total =
    parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(e);

  if (total != total_team) {
    is_valid++;
  }

  // if(is_valid > 0){
  //   $("#btn-revise").css('display','none')
  // }else{
  //   $("#btn-revise").css('display','')
  // }
}

function hrBasicLine(grade, total) {
  var total_team = $("#hr_total_team").val();
  // alert(total_team);
  if (grade == "a") {
    if (total_team < 1) {
      var min_line_a = 0;
      var max_line_a = Math.round(0.6);
      if (total >= 0) {
        $("#hr_min_line_a").html(min_line_a);
        $("#hr_max_line_a").html(max_line_a);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_a").html("");
        $("#hr_max_line_a").html("");
      }
    } else {
      var min_line_a = Math.round(Math.round(0.6) - 3);
      var max_line_a = Math.round(0.6);
      // alert(total);
      if (total >= 0) {
        // alert(total);
        $("#hr_min_line_a").html(min_line_a);
        $("#hr_max_line_a").html(max_line_a);
      }

      // alert('hehehe');
      if (total == "" || total == null) {
        $("#hr_min_line_a").html("");
        $("#hr_max_line_a").html("");
      }
    }
  } else if (grade == "b") {
    if (total_team < 1) {
      var min_line_b = 0;
      var max_line_b = Math.round((total_team * 5) / 100);
      if (total >= 0) {
        $("#hr_min_line_b").html(min_line_b);
        $("#hr_max_line_b").html(max_line_b);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_b").html("");
        $("#hr_max_line_b").html("");
      }
    } else {
      var min_line_b = Math.round(Math.round((total_team * 32) / 100) - 1); //round(round(($total_team*32)/100)-1)
      var max_line_b = Math.round(Math.round((total_team * 32) / 100) + 1); //round(round(($total_team*32)/100)+1)

      if (total >= 0) {
        $("#hr_min_line_b").html(min_line_b);
        $("#hr_max_line_b").html(max_line_b);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_b").html("");
        $("#hr_max_line_b").html("");
      }
    }
  } else if (grade == "c") {
    if (total_team < 1) {
      var min_line_c = 0;
      var max_line_c = Math.round((total_team * 5) / 100);
      if (total >= 0) {
        $("#hr_min_line_c").html(min_line_c);
        $("#hr_max_line_c").html(max_line_c);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_c").html("");
        $("#hr_max_line_c").html("");
      }
    } else {
      var min_line_c = Math.round(Math.round((total_team * 43) / 100) - 1); //round(round(($total_team*32)/100)-1)
      var max_line_c = Math.round(Math.round((total_team * 43) / 100) + 1); //round(round(($total_team*32)/100)+1)

      if (total >= 0) {
        $("#hr_min_line_c").html(min_line_c);
        $("#hr_max_line_c").html(max_line_c);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_c").html("");
        $("#hr_max_line_c").html("");
      }
    }
  } else if (grade == "d") {
    if (total_team < 1) {
      var min_line_d = 0;
      var max_line_d = Math.round((total_team * 5) / 100);
      if (total >= 0) {
        $("#hr_min_line_d").html(min_line_d);
        $("#hr_max_line_d").html(max_line_d);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_d").html("");
        $("#hr_max_line_d").html("");
      }
    } else {
      var min_line_d = Math.round(Math.round((total_team * 15) / 100) - 1); //round(round(($total_team*32)/100)-1)
      var max_line_d = Math.round(Math.round((total_team * 15) / 100) + 1); //round(round(($total_team*32)/100)+1)

      if (total >= 0) {
        $("#hr_min_line_d").html(min_line_d);
        $("#hr_max_line_d").html(max_line_d);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_d").html("");
        $("#hr_max_line_d").html("");
      }
    }
  } else if (grade == "e") {
    if (total_team < 1) {
      var min_line_e = 0;
      var max_line_e = Math.round((total_team * 5) / 100);
      if (total >= 0) {
        $("#hr_min_line_e").html(min_line_e);
        $("#hr_max_line_e").html(max_line_e);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_e").html("");
        $("#hr_max_line_e").html("");
      }
    } else {
      var min_line_e = Math.round(Math.round((total_team * 5) / 100) - 1); //round(round(($total_team*32)/100)-1)
      var max_line_e = Math.round(Math.round((total_team * 5) / 100) + 1); //round(round(($total_team*32)/100)+1)

      if (total >= 0) {
        $("#hr_min_line_e").html(min_line_e);
        $("#hr_max_line_e").html(max_line_e);
      }

      if (total == "" || total == null) {
        $("#hr_min_line_e").html("");
        $("#hr_max_line_e").html("");
      }
    }
  }

  is_valid_deviasi();
}

function addChangeDivision(nik) {
  $.ajax({
    url: "inbox/get_info_employee/" + nik,
    type: "post",
    success: function (response) {
      var parsedJson = $.parseJSON(response);
      $(parsedJson).each(function (i, val) {
        $.each(val, function (k, v) {
          // console.log(k + " : " + v);

          if (k == "division") {
            $("#existing_division").html(v);
          }

          if (k == "depthead_name") {
            $("#existing_depthead").html(v);
          }

          if (k == "divhead_name") {
            $("#existing_divhead").html(v);
          }

          if (k == "director_name") {
            $("#existing_director").html(v);
          }
        });
      });

      $("#form-change").css("display", "");
    },
  });
}

$("#change_division").change(function () {
  division = $(this).find(":selected").attr("data-div"); //$(this).attr("data-div");
  $.ajax({
    url: "inbox/get_bos_division/" + division,
    type: "post",
    success: function (response) {
      $("#change_depthead").empty();
      $("#change_divhead").html("");
      $("#change_director").html("");
      $("#divhead").val("");
      $("#director").val("");
      // console.log(response);
      var parsedJson = $.parseJSON(response);
      $(parsedJson).each(function (i, val) {
        $.each(val, function (k, v) {
          // console.log(k + " : " + v);
          if (k == "depthead") {
            // console.log(k + " : " + v);
            if (v != "") {
              myArray = v.toString().split(",");
              // console.log(myArray);
              $("#change_depthead").append("<option value = ''></option>");
              for (i = 0; i < myArray.length; ++i) {
                // do something with `substr[i]`
                // console.log(myArray[i]);
                $("#change_depthead").append(
                  "<option value = '" +
                    myArray[i] +
                    "'>" +
                    myArray[i] +
                    "</option>"
                );
              }
            }
          }

          if (k == "divhead") {
            // console.log(v);
            myArray = v.toString().split(",");
            // console.log(myArray);
            for (i = 0; i < myArray.length; ++i) {
              $("#change_divhead").html(myArray[i]);
              $("#divhead").val(myArray[i]);
            }
          }

          if (k == "director") {
            // console.log(v);
            myArray = v.toString().split(",");
            // console.log(myArray);
            for (i = 0; i < myArray.length; ++i) {
              $("#change_director").html(myArray[i]);
              $("#director").val(myArray[i]);
            }
          }
        });
      });
    },
  });
});

function deleteChangeDivision(id) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure to delete change division for this employee?",
      text: "Delete change division",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure.",
      cancelButtonText: "Cancel.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        // alert("inbox/responserequest");
        // alert("id = " + id);
        // alert("resp = " + type);
        // alert("approval_id = " + approval_id);
        $.ajax({
          url: "inbox/hr_preparation_pa_delete/",
          type: "post",
          data: "id=" + id,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              Swal.fire({
                position: "top-end",
                text: "Delete success",
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1000,
              });
              location.reload();
            } else {
              swalWithBootstrapButtons.fire(
                "Oops!",
                "Something went wrong. Please try again.",
                "error"
              );
            }
          },
          error: function (response) {
            swalWithBootstrapButtons.fire(
              "Oops!",
              "Something went wrong. Please try again.",
              "error"
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

function readyForPA(year) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure open proses PA " + year + " ?",
      text: "Open PA Schedule",
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
          url: "inbox/ready_for_pa/",
          type: "post",
          data: "year=" + year,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              Swal.fire({
                position: "top-end",
                text: "Open PA Success",
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1000,
              });
              location.reload();
            } else {
              swalWithBootstrapButtons.fire(
                "Oops!",
                "Something went wrong. Please try again.",
                "error"
              );
            }
          },
          error: function (response) {
            swalWithBootstrapButtons.fire(
              "Oops!",
              "Something went wrong. Please try again.",
              "error"
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

function cancelReadyForPA(year) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure to cancel proses PA " + year + " ?",
      text: "Cancel PA Schedule",
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
          url: "inbox/cancel_for_pa/",
          type: "post",
          data: "year=" + year,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              Swal.fire({
                position: "top-end",
                text: "Cancel PA Success",
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1000,
              });
              location.reload();
            } else {
              swalWithBootstrapButtons.fire(
                "Oops!",
                "Something went wrong. Please try again.",
                "error"
              );
            }
          },
          error: function (response) {
            swalWithBootstrapButtons.fire(
              "Oops!",
              "Something went wrong. Please try again.",
              "error"
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

function gaBasicLine(totalTeam) {
  var total_a = $("#ga_basic_line_a_field").val();
  if (total_a == "") {
    total_a = 0;
  }
  var total_b = $("#ga_basic_line_b_field").val();
  if (total_b == "") {
    total_b = 0;
  }
  var total_c = $("#ga_basic_line_c_field").val();
  if (total_c == "") {
    total_c = 0;
  }
  var total_d = $("#ga_basic_line_d_field").val();
  if (total_d == "") {
    total_d = 0;
  }
  var total_e = $("#ga_basic_line_e_field").val();
  if (total_e == "") {
    total_e = 0;
  }

  var total =
    parseInt(total_a) +
    parseInt(total_b) +
    parseInt(total_c) +
    parseInt(total_d) +
    parseInt(total_e);

  if (totalTeam == total) {
    $("#submitKurvaGA").css("display", "");
  } else {
    $("#submitKurvaGA").css("display", "none");
  }
  console.log("hehe = " + total);
}

function readyForPAGA(year) {
  var formData = $("#formKurvaGA").serialize();

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure to set kurva for GA " + year + " ?",
      text: "Kurva GA",
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
          url: "inbox/set_kurva_ga/",
          type: "post",
          data: formData,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              Swal.fire({
                position: "top-end",
                text: "Set Kurva GA Success",
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1000,
              });
              location.reload();
            } else {
              swalWithBootstrapButtons.fire(
                "Oops!",
                "Something went wrong. Please try again.",
                "error"
              );
            }
          },
          error: function (response) {
            swalWithBootstrapButtons.fire(
              "Oops!",
              "Something went wrong. Please try again.",
              "error"
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

$("#submitDIVHEADPA").click(function () {
  var data = $("#formDIVHEADPA").serialize();
  var id = $("#id_access_divhead").val();

  $.ajax({
    url: "inbox/save_access_divhead_pa_leaving/" + id,
    data: data,
    method: "post",
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Success",
          showConfirmButton: false,
          timer: 2500,
        }).then(function() {
          window.location.href = "inbox/divhead_pa_leaving_employee";
        });
      }
    },
  });
});

function openModalDIVHEAD(id) {
  // alert(id);
  $("#modalUOM").modal("show");

  $.ajax({
    type: "get",
    url: "inbox/get_access_divhead_pa_leaving/" + id,
    dataType: "json",
    success: function (data) {
      console.log(data);
      $.each(data, function (index, element) {
        // alert(element.uom);
        $("#active_field").css("display","");
        $("#is_active").prop("disabled",false);
        $("#division").val(element.division).change();
        $("#is_active").val(element.is_active).change();
        $("#id_access_divhead").val(element.id);
      });
    },
  });
}

function deleteDIVHEADPA(id) {
  // alert(id);

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure to delete this record?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure.",
      cancelButtonText: "Cancel.",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        // alert("inbox/responserequest");
        // alert("id = " + id);
        // alert("resp = " + type);
        // alert("approval_id = " + approval_id);
        $.ajax({
          url: "inbox/delete_access_divhead_pa_leaving/" + id,
          data: "",
          method: "post",
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Success",
                showConfirmButton: false,
                timer: 2500,
              }).then(function() {
                window.location.href = "inbox/divhead_pa_leaving_employee";
              });
            }
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

function save_response_notespa() {
  if ($("#response-notes").val() == "") {
    return false;
  }

  var base_url = window.location.origin;
  var id = $("#id_form_request").val();
  var approval_id = $("#approval_id").val();
  var notes = $("#response-notes").val();
  var postData = {
    request_id: id,
    approval_id: approval_id,
    notes: notes,
  };
  $.ajax({
    method: "post",
    url: "inbox/save/notespa",
    data: postData,
    dataType: "json",
    beforeSend: function () {
      // console.log(postData);
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
          timer: 1500,
        });
        // window.location.href = 'inbox/view/' + response.id;

        $("#modalAddNotes").modal("toggle");
        // alert("lolololo");
        var datan = [];
        datan["id"] = id;
        console.log(datan);
        $.ajax({
          method: "post",
          url: "form/loadNotePa/" + id,
          data: datan,
          dataType: "json",
          success: function (data) {
            $("#list_notes").html("");
            $.each(data, function (i, item) {
              console.log(data);
              console.log(data[i].id);
              // var delete = '<a id="id" style="cursor: pointer;"  onclick="return delete_notes(this.id)" class="link link-sm link-danger">Delete Note</a>';
              if (data[i].delete != 1) {
                $("#list_notes").append(
                  '<div class="bq-note"> <div class="bq-note-item"> <div class="bq-note-text"> <p>' +
                    data[i].notes +
                    '</p> </div> <div class="bq-note-meta"> <span class="bq-note-added">Added on <span class="date">' +
                    data[i].created_at +
                    '</span></span> <span class="bq-note-sep sep">|</span> <span class="bq-note-by text-dark">By <strong>' +
                    data[i].created_by +
                    "</strong></span><a></div></div></div>"
                );
              } else {
                $("#list_notes").append(
                  '<div class="bq-note"> <div class="bq-note-item"> <div class="bq-note-text"> <p>' +
                    data[i].notes +
                    '</p> </div> <div class="bq-note-meta"> <span class="bq-note-added">Added on <span class="date">' +
                    data[i].created_at +
                    '</span></span> <span class="bq-note-sep sep">|</span> <span class="bq-note-by text-dark">By <strong>' +
                    data[i].created_by +
                    '</strong></span><a id="' +
                    data[i].id +
                    '" style="cursor: pointer;"  onclick="return delete_notes_pa(this.id)" class="link link-sm link-danger">Delete Note</a></div></div></div>'
                );
              }
            });
          },
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

function delete_notes_pa(id) {
  var id_request = $("#id_request").val();
  var ids = $("#id_form_request").val();
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
            // alert(response.status);
            if (response.status == 1) {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: response.messages,
                showConfirmButton: false,
                timer: 1500,
              });

              var datan = [];
              datan["id"] = ids;
              $("#list_notes").html("");
              $.ajax({
                method: "post",
                url: "form/loadNotePa/" + ids,
                data: datan,
                dataType: "json",
                success: function (data) {
                  $.each(data, function (i, item) {
                    console.log(data);
                    console.log(data[i].id);
                    // var delete = '<a id="id" style="cursor: pointer;"  onclick="return delete_notes(this.id)" class="link link-sm link-danger">Delete Note</a>';
                    if (data[i].delete != 1) {
                      $("#list_notes").append(
                        '<div class="bq-note"> <div class="bq-note-item"> <div class="bq-note-text"> <p>' +
                          data[i].notes +
                          '</p> </div> <div class="bq-note-meta"> <span class="bq-note-added">Added on <span class="date">' +
                          data[i].created_at +
                          '</span></span> <span class="bq-note-sep sep">|</span> <span class="bq-note-by text-dark">By <strong>' +
                          data[i].created_by +
                          "</strong></span><a></div></div></div>"
                      );
                    } else {
                      $("#list_notes").append(
                        '<div class="bq-note"> <div class="bq-note-item"> <div class="bq-note-text"> <p>' +
                          data[i].notes +
                          '</p> </div> <div class="bq-note-meta"> <span class="bq-note-added">Added on <span class="date">' +
                          data[i].created_at +
                          '</span></span> <span class="bq-note-sep sep">|</span> <span class="bq-note-by text-dark">By <strong>' +
                          data[i].created_by +
                          '</strong></span><a id="' +
                          data[i].id +
                          '" style="cursor: pointer;"  onclick="return delete_notes_pa(this.id)" class="link link-sm link-danger">Delete Note</a></div></div></div>'
                      );
                    }
                  });
                },
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

$("#add_multi_divisions").click(function () {
  var nik     = $("#employee_id_tambah").val();
  var divisi  = $("#tambah_divisi").val();
  var year  = $("#year_picker").val();

  if (nik == 0 || nik == "" || divisi == 0 || divisi == "" || year == 0 || year == "") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Please check data.",
      showConfirmButton: false,
      timer: 2000,
    });
    return false;
  }

  $.ajax({
    url: "master/save_add_multi_division",
    dataType: "json",
    type: "POST",
    data: { nik: nik, divisi: divisi, year: year },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Success",
          showConfirmButton: false,
          timer: 2500,
        }).then(function() {
          window.location.href = "master/add_multi_division";
        });
      }else if(data == 2){
        Swal.fire({
          position: "center",
          icon: "info",
          title: "Data already entered",
          showConfirmButton: false,
          timer: 2500,
        });
        return false;
      }else if(data == 3){
        Swal.fire({
          position: "center",
          icon: "info",
          title: "Data is the same as someone else's",
          showConfirmButton: false,
          timer: 2500,
        });
        return false;
      }
    },
  });
});

// $(document).on("keyup", '.tagsinput', function (e) {
//   if (e.keyCode == 188) { // KeyCode For comma is 188
//       alert('comma added');
//   }
// });
