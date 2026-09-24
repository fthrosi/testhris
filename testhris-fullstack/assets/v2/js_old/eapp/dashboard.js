function quickViewDashboard(id) {
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

function save_final_score_dashboard() {
  var id = $("#req_id_modal").val();
  var score = $("#final_score").val();
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
    url: "inbox/save/dashboard_final_score",
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
          timer: 2500,
        }).then(function() {
          $("#modalQuickView").modal("toggle");
          window.location.href = "dashboard/m";
        });
      } else {
        alert("Something went wrong. Please try again.");
      }
    },
  });
}

function save_final_score_dashboard_c() {
  var id = $("#req_id_modal").val();
  var score = $("#final_score").val();
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
    url: "inbox/save/dashboard_final_score",
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
          timer: 2500,
        }).then(function() {
          $("#modalQuickView").modal("toggle");
          window.location.href = "dashboard/c";
        });
      } else {
        alert("Something went wrong. Please try again.");
      }
    },
  });
}

function gradeView(grade) {
  window.location.href = "dashboard/gradeView/" + grade;
}

function gradeViewHr(grade) {
  window.location.href = "dashboard/gradeViewHr/" + grade;
}

function gradeViewC(grade) {
  window.location.href = "dashboard/gradeViewC/" + grade;
}

function dashboardSummaryByDivision(status) {
  var postData = { status: status };
  $.ajax({
    url: "dashboard/viewSummary/division",
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

function viewDivisionC() {
  $.ajax({
    url: "dashboard/viewDivision",
    type: "post",
    dataType: "json",
    success: function (response) {
      console.log("hohohooh" + response.data);

      var no = 0;
      $("#tableViewDivision").html("");
      $.each(response.data, function (i, data) {
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.division_name),
            $("<td>").text(data.divhead_name),
            $("<td>").text(data.updated_by),
            $("<td>").text(hr_status(data.is_status))
          )
          .appendTo("#tableViewDivision");
      });

      $("#modalCdivision").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function viewDivisionM() {
  $.ajax({
    url: "dashboard/viewDivision_M",
    type: "post",
    dataType: "json",
    success: function (response) {
      console.log(response);

      var no = 0;
      $("#tableViewDivisionM").html("");
      $.each(response.data, function (i, data) {
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.division_name),
            $("<td>").text(data.divhead_name),
            $("<td>").text(hr_status(data.is_status))
          )
          .appendTo("#tableViewDivisionM");
      });

      $("#modalMdivision").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function hr_status(type) {
  var status = "";
  if (type == 0) {
    status = "Not Submitted";
  } else if (type == 1) {
    status = "Submitted to HR";
  } else if (type == 2) {
    status = "Revised by HR";
  } else if (type == 3) {
    status = "HR Confirmed";
  }

  return status;
}

function pa_status(type) {
  var status = "";
  if (type == 0) {
    status = "Draft";
  } else if (type == 1) {
    status = "Waiting Approval";
  } else if (type == 2) {
    status = "Revised";
  } else if (type == 3) {
    status = "Full Approved";
  } else if (type == 7) {
    status = "Canceled";
  } else if (type == null) {
    status = "-";
  }

  return status;
}

function eligible_status(type) {
  var status = "";
  if (type == 0) {
    status = "Not Eligible";
  } else if (type == 1) {
    status = "Eligible";
  }

  return status;
}

function viewNotSubmitted(type) {
  $.ajax({
    url: "dashboard/viewNotSubmitted/" + type,
    type: "post",
    dataType: "json",
    success: function (response) {
      //   alert(response);
      var no = 0;
      var status = "";
      $("#tableNotSubmit").html("");
      $.each(response.data, function (i, data) {
        no++;
        var $tr = $("<tr>")
          .append(
            $("<td>").text(no),
            $("<td>").text(data.employee_name),
            $("<td>").text(data.division),
            $("<td>").text(data.position),
            $("<td>").text(eligible_status(data.eligible_status))
            // $('<td>').text(pa_status(data.is_status)),
          )
          .appendTo("#tableNotSubmit");
      });

      $("#modalNotSubmit").modal("toggle");
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}


$(document).ready(function() {
    $('#MySlip').DataTable({
        order: [[3, 'desc']],
        pageLength: 10,
        responsive: true,
        language: {
            emptyTable: "SLIP NOT FOUND",
            search: "Search : ",
            lengthMenu: "Show &nbsp;_MENU_",
            zeroRecords: "Data not found",
            info: "Showing _START_ - _END_ of _TOTAL_ data",
            infoEmpty: "Data is empty",
            infoFiltered: "(Filtered from _MAX_ total data)"
        }
    });
});