$("#mySelect2").select2({
  dropdownParent: $("#modalDivisionChange"),
});

function cekValidKurva() {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  var total_a = $("#total_score_a").val();
  var total_b = $("#total_score_b").val();
  var total_c = $("#total_score_c").val();
  var total_d = $("#total_score_d").val();
  var total_e = $("#total_score_e").val();

  var basic_line_a = $("#basic_line_a").val();
  var basic_line_b = $("#basic_line_b").val();
  var basic_line_c = $("#basic_line_c").val();
  var basic_line_d = $("#basic_line_d").val();
  var basic_line_e = $("#basic_line_e").val();

  var min_line_a = $("#min_line_a").val();
  var min_line_b = $("#min_line_b").val();
  var min_line_c = $("#min_line_c").val();
  var min_line_d = $("#min_line_d").val();
  var min_line_e = $("#min_line_e").val();

  var max_line_a = $("#max_line_a").val();
  var max_line_b = $("#max_line_b").val();
  var max_line_c = $("#max_line_c").val();
  var max_line_d = $("#max_line_d").val();
  var max_line_e = $("#max_line_e").val();

  if (min_line_a == "") {
    min_line_a = 0;
  }
  if (max_line_a == "") {
    max_line_a = 0;
  }
  if (min_line_b == "") {
    min_line_b = 0;
  }
  if (max_line_b == "") {
    max_line_b = 0;
  }
  if (min_line_c == "") {
    min_line_c = 0;
  }
  if (max_line_c == "") {
    max_line_c = 0;
  }
  if (min_line_d == "") {
    min_line_d = 0;
  }
  if (max_line_d == "") {
    max_line_d = 0;
  }
  if (min_line_e == "") {
    min_line_e = 0;
  }
  if (max_line_e == "") {
    max_line_e = 0;
  }

  var notvalid = 0;

  // if (
  //   total_a == basic_line_a ||
  //   total_a == min_line_a ||
  //   total_a == max_line_a
  // ) {
  //   $("#note_a").html("<b style = 'color:green;'>Valid</b>");
  // } else {
  //   $("#note_a").html("<b style = 'color:red;'>Need To Revise</b>");
  //   notvalid++;
  //   // alert("A"+notvalid);
  // }

  // if (
  //   total_b == basic_line_b ||
  //   total_b == min_line_b ||
  //   total_b == max_line_b
  // ) {
  //   $("#note_b").html("<b style = 'color:green;'>Valid</b>");
  // } else {
  //   $("#note_b").html("<b style = 'color:red;'>Need To Revise</b>");
  //   notvalid++;
  //   // alert("B"+notvalid);
  // }

  // if (
  //   total_c == basic_line_c ||
  //   total_c == min_line_c ||
  //   total_c == max_line_c
  // ) {
  //   $("#note_c").html("<b style = 'color:green;'>Valid</b>");
  // } else {
  //   $("#note_c").html("<b style = 'color:red;'>Need To Revise</b>");
  //   notvalid++;
  //   // alert("C"+notvalid);
  // }

  // if (
  //   total_d == basic_line_d ||
  //   total_d == min_line_d ||
  //   total_d == max_line_d
  // ) {
  //   $("#note_d").html("<b style = 'color:green;'>Valid</b>");
  // } else {
  //   $("#note_d").html("<b style = 'color:red;'>Need To Revise</b>");
  //   notvalid++;
  //   // alert("D"+notvalid);
  // }

  // if (
  //   total_e == basic_line_e ||
  //   total_e == min_line_e ||
  //   total_e == max_line_e
  // ) {
  //   $("#note_e").html("<b style = 'color:green;'>Valid</b>");
  // } else {
  //   $("#note_e").html("<b style = 'color:red;'>Need To Revise</b>");

  //   notvalid++;
  //   // alert("MIN LINE E " + min_line_e);
  //   // alert("MAX LINE E " + max_line_e);
  //   // alert("E"+notvalid);
  // }


  if(total_a == min_line_a || total_a == max_line_a || total_a == basic_line_a){
    $("#note_a").html("<b style = 'color:green;'>Valid</b>");
  }else{
    if(total_a <= max_line_a && total_a >= min_line_a){
      $("#note_a").html("<b style = 'color:green;'>Valid</b>");
    }else{
      $("#note_a").html("<b style = 'color:red;'>Need To Revise</b>");
      notvalid++;
    }
  }
  
  if(total_b == min_line_b || total_b == max_line_b || total_b == basic_line_b){
    $("#note_b").html("<b style = 'color:green;'>Valid</b>");
  }else{
    if(total_b <= max_line_b && total_b >= min_line_b){
      $("#note_b").html("<b style = 'color:green;'>Valid</b>");
    }else{
      $("#note_b").html("<b style = 'color:red;'>Need To Revise</b>");
      notvalid++;
    }
  }
  
  if(total_c == min_line_c || total_c == max_line_c || total_c == basic_line_c){
    $("#note_c").html("<b style = 'color:green;'>Valid</b>");
  }else{
    if(total_c <= max_line_c && total_c >= min_line_c){
      $("#note_c").html("<b style = 'color:green;'>Valid</b>");
    }else{
      $("#note_c").html("<b style = 'color:red;'>Need To Revise</b>");
      notvalid++;
    }
  }
  
  if(total_d == min_line_d || total_d == max_line_d || total_d == basic_line_d){
    $("#note_d").html("<b style = 'color:green;'>Valid</b>");
  }else{
    if(total_d <= max_line_d && total_d >= min_line_d){
      $("#note_d").html("<b style = 'color:green;'>Valid</b>");
    }else{
      $("#note_d").html("<b style = 'color:red;'>Need To Revise</b>");
      notvalid++;
    }
  }
  
  if(total_e == min_line_e || total_e == max_line_e || total_e == basic_line_e){
    $("#note_e").html("<b style = 'color:green;'>Valid</b>");
  }else{
    if(total_e <= max_line_e && total_e >= min_line_e){
      $("#note_e").html("<b style = 'color:green;'>Valid</b>");
    }else{
      $("#note_e").html("<b style = 'color:red;'>Need To Revise</b>");
      notvalid++;
    }
  }
  // alert(notvalid);
  // update_grade_pa_c
  if (notvalid == 0) {
    $("#is_valid").val("valid");
    $("#update_grade_pa_c").css("display", "");
    $("#notifKurvaNotValid").css("display", "none");
  } else {
    $("#is_valid").val("not valid");
    $("#update_grade_pa_c").css("display", "none");
    $("#notifKurvaNotValid").css("display", "");
    // alert(
    //   "If there is a change in value, please adjust the value of the entire team so that the results match the curve above."
    // );
  }
}

function quickViewDashboard(id, division) {
  // alert(id);
  // alert("heheeheh");
  // return false;
  $.ajax({
    url: "dashboard/view_kurva_c/" + division + "/",
    type: "get",
    dataType: "json",
    success: function (response) {
      console.log(response);
      // alert(response.total_a);
      $("#total_a").html(response.total_a);
      $("#total_score_a").val(response.total_a);
      $("#total_b").html(response.total_b);
      $("#total_score_b").val(response.total_b);
      $("#total_c").html(response.total_c);
      $("#total_score_c").val(response.total_c);
      $("#total_d").html(response.total_d);
      $("#total_score_d").val(response.total_d);
      $("#total_e").html(response.total_e);
      $("#total_score_e").val(response.total_e);

      //===================BASIC LINE============//
      var total_team = response.total_team;
      var persen_a = $("#persentase_a").val();
      var persen_b = $("#persentase_b").val();
      var persen_c = $("#persentase_c").val();
      var persen_d = $("#persentase_d").val();
      var persen_e = $("#persentase_e").val();

      $("#divisionShow").html(response.division_decrypt);
      $("#division_encrypt").val(division);

      if (response.devisiasi_basic_line_a == "") {
        var basic_line_a = Math.round(
          parseFloat(parseFloat(total_team) * parseFloat(persen_a)) / 100
        );  
    }else{
      var basic_line_a = response.devisiasi_basic_line_a;
    }
    
    if (response.devisiasi_basic_line_b == "") {
        var basic_line_b = Math.round(
          parseFloat(parseFloat(total_team) * parseFloat(persen_b)) / 100
        );  
    }else{
      var basic_line_b = response.devisiasi_basic_line_b;
    }

    if (response.devisiasi_basic_line_c == "") {
        var basic_line_c = Math.round(
          parseFloat(parseFloat(total_team) * parseFloat(persen_c)) / 100
        );  
    }else{
      var basic_line_c = response.devisiasi_basic_line_c;
    }

    if (response.devisiasi_basic_line_d == "") {
        var basic_line_d = Math.round(
          parseFloat(parseFloat(total_team) * parseFloat(persen_d)) / 100
        );  
    }else{
      var basic_line_d = response.devisiasi_basic_line_d;
    }

    if (response.devisiasi_basic_line_e == "") {
        var basic_line_e = Math.round(
          parseFloat(parseFloat(total_team) * parseFloat(persen_e)) / 100
        );  
    }else{
      var basic_line_e = response.devisiasi_basic_line_e;
    }

      // var basic_line_a = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_a)) / 100
      // );

      // var basic_line_b = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_b)) / 100
      // );

      // var basic_line_c = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_c)) / 100
      // );

      // var basic_line_d = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_d)) / 100
      // );

      // var basic_line_e = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_e)) / 100
      // );

      var total_line =
          parseInt(basic_line_a) +
          parseInt(basic_line_b) +
          parseInt(basic_line_c) +
          parseInt(basic_line_d) +
          parseInt(basic_line_e);

      if(total_line > total_team){
          basic_line_e = basic_line_e-1;
      }else if(total_line < total_team){
          var total_tambah = total_team - total_line;
          basic_line_c = basic_line_c + total_tambah;
      }
      // if (total_line > total_team) {
      //   basic_line_e = parseInt(basic_line_e) - 1;
      // } else if ($total_line < $total_team_eligible) {
      //   basic_line_c = parseInt(basic_line_c) + 1;
      // }

      $("#basic_a").html(basic_line_a);
      // alert(basic_line_a);

      $("#basic_line_a").val(basic_line_a);

      $("#id_pa").val(id);

      $("#basic_b").html(basic_line_b);
      $("#basic_line_b").val(basic_line_b);

      $("#basic_c").html(basic_line_c);
      $("#basic_line_c").val(basic_line_c);

      $("#basic_d").html(basic_line_d);
      $("#basic_line_d").val(basic_line_d);

      $("#basic_e").html(basic_line_e);
      $("#basic_line_e").val(basic_line_e);

      cekValidKurva();
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });

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

function calculate_final_score_dashboard(idpa) {
  var division = $("#division_encrypt").val();
  var id_pa = idpa;
  // alert(division);
  // return false;
  var grade = "";
  var score = $("#final_score" + id_pa).val();
  if (score == "") {
    $("#grade" + id_pa).text("");
    return false;
  }

  var final_score = parseFloat($("#final_score" + id_pa).val());
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

    $("#grade" + id_pa).text(grade);

    var postData = {
      score_dummy: final_score,
      id: id_pa,
    };

    // alert("dashboard/view_kurva_c/"+division+"");

    $.ajax({
      url: "dashboard/update_score_dummy/",
      type: "post",
      data: postData,
      dataType: "json",
      success: function (response) {
        $.ajax({
          url: "dashboard/view_kurva_c/" + division + "",
          type: "get",
          dataType: "json",
          success: function (response) {
            console.log(response);
            // alert(response.total_a);
            $("#total_a").html(response.total_a);
            $("#total_score_a").val(response.total_a);
            $("#total_b").html(response.total_b);
            $("#total_score_b").val(response.total_b);
            $("#total_c").html(response.total_c);
            $("#total_score_c").val(response.total_c);
            $("#total_d").html(response.total_d);
            $("#total_score_d").val(response.total_d);
            $("#total_e").html(response.total_e);
            $("#total_score_e").val(response.total_e);

            //===================BASIC LINE============//
            var total_team = response.total_team;
            var persen_a = $("#persentase_a").val();
            var persen_b = $("#persentase_b").val();
            var persen_c = $("#persentase_c").val();
            var persen_d = $("#persentase_d").val();
            var persen_e = $("#persentase_e").val();

            $("#divisionShow").html(response.division_decrypt);
            $("#division_encrypt").val(division);

            var basic_line_a = Math.round(
              parseFloat(parseFloat(total_team) * parseFloat(persen_a)) / 100
            );

            var basic_line_b = Math.round(
              parseFloat(parseFloat(total_team) * parseFloat(persen_b)) / 100
            );

            var basic_line_c = Math.round(
              parseFloat(parseFloat(total_team) * parseFloat(persen_c)) / 100
            );

            var basic_line_d = Math.round(
              parseFloat(parseFloat(total_team) * parseFloat(persen_d)) / 100
            );

            var basic_line_e = Math.round(
              parseFloat(parseFloat(total_team) * parseFloat(persen_e)) / 100
            );

            var total_line =
              parseInt(basic_line_a) +
              parseInt(basic_line_b) +
              parseInt(basic_line_c) +
              parseInt(basic_line_d) +
              parseInt(basic_line_e);

            // alert(total_team + "yy");
            // alert(total_line + "yy");
            if (total_line > total_team) {
              basic_line_e = parseInt(basic_line_e) - 1;
            } else if ($total_line < $total_team_eligible) {
              basic_line_c = parseInt(basic_line_c) + 1;
            }

            $("#basic_a").html(basic_line_a);
            $("#basic_line_a").val(basic_line_a);

            $("#id_pa").val(id_pa);

            $("#basic_b").html(basic_line_b);
            $("#basic_line_b").val(basic_line_b);

            $("#basic_c").html(basic_line_c);
            $("#basic_line_c").val(basic_line_c);

            $("#basic_d").html(basic_line_d);
            $("#basic_line_d").val(basic_line_d);

            $("#basic_e").html(basic_line_e);
            $("#basic_line_e").val(basic_line_e);

            cekValidKurva();
          },
          error: function (response) {
            alert("error");
            alert(
              "Oops! There's something wrong. Please refresh this page and try again."
            );
          },
        });
      },
      error: function (response) {
        alert(response + " ....");
        alert(
          "Oops! There's something wrong. Please refresh this page and try again."
        );
      },
    });

    viewKurvaAdjustmentC(division);
  }
}

function reset_final_score_dummy() {
  var division = $("#division_encrypt").val();
  var id_pa = $("#id_pa").val();

  var postData = {
    score_dummy: "",
    id: id_pa,
  };

  $.ajax({
    url: "dashboard/reset_score_dummy/",
    type: "post",
    data: postData,
    dataType: "json",
    success: function (response) {
      // alert("OKE");
    },
    error: function (response) {
      alert(response);
      alert(
        "Oops! There's szazazaomething wrong. Please refresh this page and try again."
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
          timer: 1000,
        });

        $("#modalQuickView").modal("toggle");
        window.location.href = "dashboard/m";
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
          timer: 1000,
        });

        $("#modalQuickView").modal("toggle");
        window.location.href = "dashboard/c";
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

function viewKurvaAdjustmentC(division) {

  $.ajax({
    url: "dashboard/view_kurva_c/" + division + "/",
    type: "get",
    dataType: "json",
    success: function (response) {
      console.log(response);
      $("#total_a").html(response.total_a);
      $("#total_score_a").val(response.total_a);
      $("#total_b").html(response.total_b);
      $("#total_score_b").val(response.total_b);
      $("#total_c").html(response.total_c);
      $("#total_score_c").val(response.total_c);
      $("#total_d").html(response.total_d);
      $("#total_score_d").val(response.total_d);
      $("#total_e").html(response.total_e);
      $("#total_score_e").val(response.total_e);

      //===================BASIC LINE============//
      var total_team = response.total_team;
      var total_team_eligible = response.total_team;
      // alert(total_team);

      var persen_a = $("#persentase_a").val();
      var persen_b = $("#persentase_b").val();
      var persen_c = $("#persentase_c").val();
      var persen_d = $("#persentase_d").val();
      var persen_e = $("#persentase_e").val();

      $("#divisionShow").html(response.division_decrypt);
      $("#division_encrypt").val(division);

      if (response.devisiasi_basic_line_a == "") {
          var basic_line_a = Math.round(
            parseFloat(parseFloat(total_team) * parseFloat(persen_a)) / 100
          );  
      }else{
        var basic_line_a = response.devisiasi_basic_line_a;
      }
      
      if (response.devisiasi_basic_line_b == "") {
          var basic_line_b = Math.round(
            parseFloat(parseFloat(total_team) * parseFloat(persen_b)) / 100
          );  
      }else{
        var basic_line_b = response.devisiasi_basic_line_b;
      }

      if (response.devisiasi_basic_line_c == "") {
          var basic_line_c = Math.round(
            parseFloat(parseFloat(total_team) * parseFloat(persen_c)) / 100
          );  
      }else{
        var basic_line_c = response.devisiasi_basic_line_c;
      }

      if (response.devisiasi_basic_line_d == "") {
          var basic_line_d = Math.round(
            parseFloat(parseFloat(total_team) * parseFloat(persen_d)) / 100
          );  
      }else{
        var basic_line_d = response.devisiasi_basic_line_d;
      }

      if (response.devisiasi_basic_line_e == "") {
          var basic_line_e = Math.round(
            parseFloat(parseFloat(total_team) * parseFloat(persen_e)) / 100
          );  
      }else{
        var basic_line_e = response.devisiasi_basic_line_e;
      }

      // var basic_line_a = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_a)) / 100
      // );  

      // var basic_line_b = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_b)) / 100
      // );

      // var basic_line_c = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_c)) / 100
      // );

      // var basic_line_d = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_d)) / 100
      // );

      // var basic_line_e = Math.round(
      //   parseFloat(parseFloat(total_team) * parseFloat(persen_e)) / 100
      // );

      var total_line =
        parseInt(basic_line_a) +
        parseInt(basic_line_b) +
        parseInt(basic_line_c) +
        parseInt(basic_line_d) +
        parseInt(basic_line_e);

      // alert(total_team + "zz");
      // alert(total_line + "zz");

      if(total_line > total_team){
          basic_line_e = basic_line_e-1;
      }else if(total_line < total_team){
          var total_tambah = total_team - total_line;
          basic_line_c = basic_line_c + total_tambah;
      }
      // if (total_line > total_team) {
      //   basic_line_e = parseInt(basic_line_e) - 1;
      // } else if (total_line < total_team_eligible) {
      //   basic_line_c = parseInt(basic_line_c) + 1;
      // }
      
      $("#basic_a").html(basic_line_a);
      $("#basic_line_a").val(basic_line_a);
      // alert("sasasasa");
      $("#basic_b").html(basic_line_b);
      $("#basic_line_b").val(basic_line_b);

      $("#basic_c").html(basic_line_c);
      $("#basic_line_c").val(basic_line_c);

      $("#basic_d").html(basic_line_d);
      $("#basic_line_d").val(basic_line_d);

      $("#basic_e").html(basic_line_e);
      $("#basic_line_e").val(basic_line_e);

      cekValidKurva();
    },
    error: function (response) {
      alert(
        "Oops! There's something wrong. Please refresh this page and try again."
      );
    },
  });
}

function update_dummy_score_to_real(division) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
  });

  var is_valid = $("#is_valid").val();

  if (is_valid == "not valid") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Can't update the score because there is still an invalid curve",
      showConfirmButton: false,
      timer: 8000,
    });
    return false;
  }

  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "We will update the final score according to what you change.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, sure!",
      cancelButtonText: "Cancel",
      reverseButtons: true,
      allowOutsideClick: false,
    })
    .then((result) => {
      if (result.value) {
        // alert("OKE");
        var postData = {
          division: division,
        };

        $.ajax({
          method: "post",
          url: "dashboard/update_dummy_score_to_real",
          data: postData,
          dataType: "json",
          beforeSend: function () {},
          success: function (response) {
            if (response == 1) {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Final Score updated successfully.",
                showConfirmButton: false,
                timer: 1000,
              });

              location.reload();
            } else {
              alert("Something went wrong. Please try again.");
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
