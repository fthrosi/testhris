$(document).on('submit', '#exitInterviewForm', function (e) {
    e.preventDefault();
    const idFormExit = $('#id_form_interview').val();
    const idFormRequest = $('#id_form_request').val();
    const form = $(this)[0];
    const formData = new FormData(form);
    formData.append('idFormExit', idFormExit);
    $.ajax({
        url: base_url + 'form/saveInterview',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            Swal.fire({
                title: 'Saving Data...',
                allowOutsideClick: false,
                onOpen: function () {
                    Swal.showLoading();
                }
            });

        },

        success: function (response) {
            $('#exitInterviewForm').find('input, textarea, select').attr('disabled', true);
            swal.fire({
                icon: response.status ? 'success' : 'error',
                title: response.status ? 'Success' : 'Failed',
                text: response.message,
                timer: 5000,
                timerProgressBar: true,
                
            }).then(() => {
                window.location.href = base_url + 'form/home_exit_clearance/' + idFormRequest;
            });
            
        },
        error: function (xhr) {
            swal.close();
            swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Failed to submit the form. Please try again later.',
                timer: 5000,
                timerProgressBar: true
            });
        }

    });
});
$(document).on('click', '#update-interview', function (e) {
    e.preventDefault();
    const btn = $(this);
    const idFormExit = $('#id_form_interview').val();
    btn.prop('disabled', true);
    btn.text('waiting...');
    $('#back-btn').prop('disabled', true);
    $.ajax({
        url: base_url + 'form/editInterview',
        type: 'POST',
        data: {
            idFormExit: idFormExit
        },
        success: function (response) {
            btn.prop('disabled', false);
            $('#back-btn').prop('disabled', false);
            btn.prop('type', 'submit');
            btn.prop('id', 'submit-btn-interview');
            btn.text('Submit');
            $('#exitInterviewForm').find('input, textarea, select').attr('disabled', false);
        },
        error: function (xhr) {
            swal.close();
            swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Failed to update the form. Please try again later.',
                timer: 5000,
                timerProgressBar: true
            });
        }
    })
});
$(document).on('click', '#back-btn', function () {
    const idFormRequest = $('#id_form_request').val();
    window.location.href = base_url + 'form/home_exit_clearance/' + idFormRequest;
});