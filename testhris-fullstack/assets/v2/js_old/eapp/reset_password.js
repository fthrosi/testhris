function validate_emp_id() {
    var emp_nik = $('#emp_nik').val();
    $.ajax({
      url: "register/validate/emp_nik",
      type: 'post',
      data: 'emp_nik=' + emp_nik,
      dataType: 'json',
      beforeSend: function () {
          $('#div_ndah').hide();
          $('#div_ndah_yaok').hide();
          $('#div_ndah_sure').hide();
      },
      success: function (response) {

          if (response.status == 1) {

              $('#emp_name').val(response.employee.employee_name);
              $('#emp_id').val(response.employee.id);
              $('#emp_division').val(response.employee.division);

              $('#reg_phone').show();
              $('#div_ndah').hide();

          } else {
            
            $('#reg_phone').hide();
            $('#div_ndah').hide();
            $('#div_ndah_yaok').hide();
            $('#div_ndah_sure').hide();

              Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: 'ID not found!.',
                  showConfirmButton: false,
                  timer: 1000
              });
          }
      },
      error: function (response) {
        $('#reg_phone').hide();
        $('#div_ndah').hide();
        $('#div_ndah_yaok').hide();
        $('#div_ndah_sure').hide();
          alert('Something went wrong. Please try again.');
      }
    });
}

$("#btnForgotPass").click(function (e) {
  e.preventDefault();
  $.ajax({
    type: 'GET',
    url: "login/forgot_password",
    dataType: 'json',
    data: { 
      kind: 'forgot_password'
      },
    success: function (response) {
      $("#indexPage").html(response);
    }
  });
});

function resetPass() {
  
  var email = $("#email").val();
  // $(this).html('Please Wait ...');
  $.ajax({
    url: "login/reset_password",
    type: 'post',
    dataType: 'json',
    data: {
      email: email
      },
    success: function (response) {
      if (response.status == 1) {
        $("#indexPage").html(response.data['content']);
      } else {
        $(".message").show();
        $(".message").html(response.message);
        $("#email").val(null);
      }
    },
    error: function (response) {
    }
  });
};

function loginPage() {
  window.location = "http://medclaim.ibsmulti.com/";
};


