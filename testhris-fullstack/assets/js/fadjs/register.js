//****************** ffadlifadd@gitlab.com - fadli.itdev@gmail.com **********************//
// Verification
$("#btnPhoneNumber").click(function (e) {
    e.preventDefault();
    var phoneNumber = $('#phoneNumber').val();
    $.ajax({
        url: "register/sendCode",
        type: 'post',
        data: 'phoneNumber=' + phoneNumber,
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
                    title: '<strong>Confirm your phone number.</strong>',
                    icon: 'question',
                    html: '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><b>6 digit code has been sent to your phone number.</b></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="d-flex justify-content-center">' +
                        '<div class="col-md-8"></div>' +
                        '<div class="col-md-6">' +
                        '<input class="form-control form-control-lg" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return verification();" maxlength="6" min="1" max="999" id="otp_code" />' +
                        '</div>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '</div><br>' +
                        '<hr>',
                    showCloseButton: false,
                    showCancelButton: true,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: false,
                    confirmButtonText: '<i class="fa fa-check-square-o"> Confirm</i>',
                    confirmButtonAriaLabel: 'Confirm',
                    cancelButtonText: '<i class="fa fa-remove"> Cancel</i>',
                    cancelButtonAriaLabel: 'Cancel',
                })

            } else {
                alert('Please enter your phone number!');
            }
        }
    });
});

function verification() {
    var otp = $('#otp_code').val();
    var phoneNumber = $('#phoneNumber').val();

    $.ajax({
        url: "register/verify",
        type: 'post',
        data: 'otp=' + otp + '&phoneNumber=' + phoneNumber,
        dataType: 'json',
        success: function (response) {

            $('#otp_code').val();

            if (response == 1) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Well done! You are verified.',
                    showConfirmButton: false,
                    timer: 5000
                });
                window.location.href = 'list/ebast';

            } else {

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops! Authentication failed. Please try again.',
                    showConfirmButton: false,
                    timer: 3500
                });

            }
            
        },
        error: function (response) {
            alert('Please enter your phone number!');
        }
    });
}

// Update Phone Number

$("#btnUpdatePhoneNumber").click(function (e) {
    e.preventDefault();
    var phoneNumber = $('#phoneNumber').val();
    $.ajax({
        url: "users/sendCode",
        type: 'post',
        data: 'phoneNumber=' + phoneNumber,
        success: function (response) {
            if (response == 1) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-info',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: '<strong>Confirm your phone number.</strong>',
                    icon: 'question',
                    html: '<div class="row">' +
                        '<div class="col-md-8 col-md-offset-2 align-center">' +
                        '<span class="input input--kuro">' +
                        '<input class="input__field input__field--kuro" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return verifyUpdatePhone();" maxlength="6" min="1" max="999" type="number" id="otp_code" />' +
                        '<label class="input__label input__label--kuro" for="input-9">' +
                        '<span class="input__label-content input__label-content--kuro">Enter OTP Code</span>' +
                        '</label>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><b>6 digit code has been sent to your phone number.</b></center><br>' +
                        '</div>' +
                        '</div><br>',
                    showCloseButton: false,
                    showCancelButton: true,
                    showConfirmButton: false,
                    focusConfirm: false,
                    allowOutsideClick: false,
                    confirmButtonText: '<i class="fa fa-check-square-o"> Confirm</i>',
                    confirmButtonAriaLabel: 'Confirm',
                    cancelButtonText: '<i class="fa fa-remove"> Cancel</i>',
                    cancelButtonAriaLabel: 'Cancel',
                })

            } else {
                alert('Please enter your phone number!');
            }
        }
    });
});

function verifyUpdatePhone() {
    var otp = $('#otp_code').val();
    var phoneNumber = $('#phoneNumber').val();

    $.ajax({
        url: "users/verify",
        type: 'post',
        data: 'otp=' + otp + '&phoneNumber=' + phoneNumber,
        dataType: 'json',
        success: function (response) {

            if (response == 1) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Thank you! You new phone are verified.',
                    showConfirmButton: false,
                    timer: 3000
                });
                window.location.href = '/form/approval';

            } else {

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops! Authentication failed. Please try again.',
                    showConfirmButton: false,
                    timer: 3500
                });

            }
            
        },
        error: function (response) {
            alert('Please enter your phone number!');
        }
    });
}

