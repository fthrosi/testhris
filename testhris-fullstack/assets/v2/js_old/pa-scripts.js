$(document).ready(function () {
  var path = window.location.pathname;
  const path2 = path.split("/");
  let req_num = decodeURIComponent(path2[4]);
  if (path2[3] == "KPI") {
    get_qa(req_num);  
  }
  
});

function get_qa(id) {
  console.log(id);
  // alert('test');
  var url = 'form/PA/get_qa/';

  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
     
      var id = response[0].id;
      var req_id_pa = response[0].req_id_pa;
      var request_number = response[0].request_number;
      var work_efficiency = response[0].work_efficiency;
      var work_quality = response[0].work_quality;
      var communication = response[0].communication;
      var planning_organizing = response[0].planning_organizing;
      var problem_solving = response[0].problem_solving;
      var team_work = response[0].team_work;
      var potential = response[0].potential;
      var initiative = response[0].initiative;
      var leadership = response[0].leadership;
      var area_improvement = response[0].area_improvement;
      var comment_employee = response[0].comment_employee;
      var created_at = response[0].created_at;
      var created_by = response[0].created_by;

      if (work_efficiency != '' && work_efficiency != null) {
          $("#plan_score_1").val(work_efficiency);
          calculate_assesment_draft(1);
      }
      if (work_quality != '' && work_quality != null) {
          $("#plan_score_2").val(work_quality);
          calculate_assesment_draft(2);
      }
      if (communication != '' && communication != null) {
          $("#plan_score_3").val(communication);
          calculate_assesment_draft(3);
      }
      if (planning_organizing != '' && planning_organizing != null) {
        $("#plan_score_4").val(planning_organizing);
        calculate_assesment_draft(4);
      }
      if (problem_solving != '' && problem_solving != null) {
        $("#plan_score_5").val(problem_solving);
        calculate_assesment_draft(5);
      }
      if (team_work != '' && team_work != null) {
        $("#plan_score_6").val(team_work);
        calculate_assesment_draft(6);
      }
      if (potential != '' && potential != null) {
        $("#plan_score_7").val(potential);
        calculate_assesment_draft(7);
      }
      if (initiative != '' && initiative != null) {
        $("#plan_score_8").val(initiative);
        calculate_assesment_draft(8);
      }
      if (leadership != '' && leadership != null) {
        $("#plan_score_9").val(leadership);
        calculate_assesment_draft(9);
      }
      if (area_improvement != '' && area_improvement != null) {
        $("#area_improvement").val(area_improvement);
      }
      if (comment_employee != '' && comment_employee != null) {
        $("#comment_employee").val(comment_employee);
      }
      
    },error: function (response) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Request not found",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
}

function text_area(type, id_req) {
  var content = $("#"+type).val();
  
    var url = 'form/PA/post_content_pa/';
    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'json',
      data: { content: content, type: type, id_req: id_req},
      success: function (response) {
        if (response == 1) {
            console.log('Update content '+content+' berhasil');
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

// Qualitative
function calculate_assesment_draft(id) {
  var plan_weight = $("#plan_weight_" + id).val();
  var plan_score = $("#plan_score_" + id).val();
  var total = plan_score * (plan_weight / 100);
  var roundTotal = total.toFixed(3);
  $("#plan_result_" + id).val(roundTotal);
  $("#tb_plan_result_" + id).text(roundTotal);

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

  calculate_assesment_total_draft();
}

function calculate_assesment_total_draft() {
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

$('.btn-update-deviasi').click(function () {

  var team_eligible     = $("#hr_te").val();
  var total_employee    = $("#hr_tot").val();
  var division_name     = $("#division_name").val();
  var basic_line_a      = Number($("#hr_basic_line_a_field").val());
  var basic_line_b      = Number($("#hr_basic_line_b_field").val());
  var basic_line_c      = Number($("#hr_basic_line_c_field").val());
  var basic_line_d      = Number($("#hr_basic_line_d_field").val());
  var basic_line_e      = Number($("#hr_basic_line_e_field").val());
  var total_dbl         = basic_line_a + basic_line_b + basic_line_c + basic_line_d + basic_line_e;

  if ((division_name == "") || (division_name === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'System cannot get division name.',
        text: 'Please contact the administrator',
        showConfirmButton: false,
        timer: 3500
      });
      return false;
  }

  if ((team_eligible == "") || (team_eligible === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'System cannot get total team eligible.',
        text: 'Please contact the administrator',
        showConfirmButton: false,
        timer: 3500
      });
      return false;
  }
  
  if ((total_employee == "") || (total_employee === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'System cannot get total_employee.',
        text: 'Please contact the administrator',
        showConfirmButton: false,
        timer: 3500
      });
      return false;
  }
  
  if(team_eligible != total_dbl){
      Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Total basic line deviation is not the same as total team eligible.',
        text: division_name,
        showConfirmButton: false,
        timer: 3500
      });
      return false;
  }

  $.ajax({
    url: 'inbox/kurva_devisiasi_hr',
    dataType: 'json',
    type: 'POST',
    data: { team_eligible: team_eligible, total_employee: total_employee, division_name: division_name, total_dbl: total_dbl, basic_line_a: basic_line_a, basic_line_b: basic_line_b, basic_line_c: basic_line_c, basic_line_d: basic_line_d, basic_line_e: basic_line_e },
    success: function (data) {
      if (data == true) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data has been saved',
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
        }).then(function(){ 
          location.reload();
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data cannot be saved',
        showConfirmButton: false,
        timer: 3500
      });
      return false;
    }
  });
});

// $('#btn_save_evidence').click(function () {
$('#FileDocumentsEvidence').change(function () {

    var form_data = new FormData($('#form_evidence_kpi')[0]);

    $.ajax({
      type: "POST",
      url: "form/PA/save_documents_evidence",
      data: form_data,
      processData: false,
      contentType: false,
      success: function (res) {
        res = ((res.replace(/(<([^>]+)>)/ig, " ").replace(/""/,"<br>")));
        if (res == 'true') {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Documents Uploaded',
            showConfirmButton: false,
            timer: 2500
          });
          location.reload();
        } else if(res == 'false') {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: "Oops! There's something wrong",
            showConfirmButton: false,
            timer: 3500
          });
          return false;
        } else {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: res,
            showConfirmButton: false,
            timer: 3500
          });
          return false;
        }
      }
    });
});
