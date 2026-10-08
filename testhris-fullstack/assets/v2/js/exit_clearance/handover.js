$(document).on('click', '#back-btn', function () {
    const idFormRequest = $('#id_form_request').val();
    window.location.href = base_url + 'form/home_exit_clearance/' + idFormRequest;
});
$(document).on('click', '.add-handover', function () {
    $('#handover-modal').modal('show');
    $('#handover-modal .modal-title').text('Add Handover');
    $('#handover-form')[0].reset();
    setPicType('employee');
    $('#pic-type-section').show();
});

function setPicType(type) {

    if (type === 'employee') {

        $('#employee-pic-section').show();
        $('#non-employee-pic-section').hide();

        $('#pic').prop('disabled', false);
        $('#employee-name').prop('disabled', false);
        $('#employee-email').prop('disabled', false);
        $('#employee-status').prop('disabled', false);

        $('#non-employee-name').prop('disabled', true).val('');
        $('#non-employee-email').prop('disabled', true).val('');
        $('#non-employee-status').prop('disabled', true).val('');

    } else {

        $('#employee-pic-section').hide();
        $('#non-employee-pic-section').show();

        $('#pic').prop('disabled', true).val('');
        $('#employee-name').prop('disabled', true).val('');
        $('#employee-email').prop('disabled', true).val('');
        $('#employee-status').prop('disabled', true).val('');

        $('#non-employee-name').prop('disabled', false);
        $('#non-employee-email').prop('disabled', false);
        $('#non-employee-status').prop('disabled', false);
    }
}

$(document).on('change', 'input[name="pic_type"]', function () {
    setPicType($(this).val());
});
// $(document).on('shown.bs.modal', '#handover-modal', function () {
//     const type = $('input[name="pic_type"]:checked').val();

//     setPicType(type);
// });
$(document).on('change', '#pic', function () {

    const option = $(this).find(':selected');

    const name = option.data('name') || '';
    const email = option.data('email') || '';

    $('#employee-name').val(name);
    $('#employee-email').val(email);

});
$(document).on('click', '#btn-save', function () {
    const idHandover = $('#id_handover').val();
    const form = $('#handover-form')[0];
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    const formData = new FormData(form);
    formData.append('id_handover', idHandover);
    $.ajax({
        url: base_url + 'form/savePicHandover',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            Swal.fire({
                title: 'Saving data...',
                allowOutsideClick: false,
                onOpen: function () {
                    Swal.showLoading();
                }
            });

        },

        success: function (response) {
            swal.close();
            swal.fire({
                icon: response.status ? 'success' : 'error',
                title: response.status ? 'Success' : 'Failed',
                text: response.message,
                timer: 5000,
                timerProgressBar: true
            }).then(() => {
                // kalau mau reload setelah submit
                location.reload();
            });
        },
        error: function (xhr) {
            swal.close();
            swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menyimpan data.'
            }).then(() => {
                // kalau mau reload setelah submit
                location.reload();
            });
        }

    });
});

$(document).on('click', '.btn-edit-handover', function () {

    const id = $(this).data('id');
    const notes = $(this).data('notes');
    const toolName = $(this).data('tool-name');
    const quantity = $(this).data('quantity');
    const status = $(this).data('status');
    const name = $(this).data('name');
    const email = $(this).data('email');
    console.log('id:', id);
    $('#id_handover').val(id);

    setPicType('non-employee');

    // Yang bisa diedit
    $('#toolName').val(toolName);
    $('#quantity').val(quantity);
    $('#description').val(notes);

    // Title & button
    $('#handover-modal .modal-title').text('Edit Handover');
    $('#btn-save').text('Update');
    $('#btn-save').prop('id', 'btn-update');

    // // Hide PIC Type
    $('#pic-type-section').hide();
    $('#pic-type-section input[name="pic_type"]').prop('disabled', true);

    // Isi data PIC
    $('#non-employee-name').val(name);
    $('#non-employee-email').val(email);
    $('#non-employee-status').val(status);

    // PIC tidak boleh diedit
    $('#non-employee-name').prop('disabled', true);
    $('#non-employee-email').prop('disabled', true);

    $('#handover-modal').modal('show');
});

$(document).on('click', '#btn-update', function () {
    const idPic = $('#id_handover').val();
    const form = $('#handover-form')[0];
    const formData = new FormData(form);
    formData.append('employee_id', idPic);
    formData.append('pic_type', 'employee');
    $.ajax({
        url: base_url + 'form/savePicHandover',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            Swal.fire({
                title: 'Updating data...',
                allowOutsideClick: false,
                onOpen: function () {
                    Swal.showLoading();
                }
            });

        },
        success: function (response) {
            swal.close();
            swal.fire({
                icon: response.status ? 'success' : 'error',
                title: response.status ? 'Success' : 'Failed',
                text: response.message,
                timer: 5000,
                timerProgressBar: true
            }).then(() => {
                // kalau mau reload setelah submit
                location.reload();
            });
        },
        error: function (xhr) {
            swal.close();
            swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menyimpan data.'
            }).then(() => {
                // kalau mau reload setelah submit
                location.reload();
            });
        }

    });
});
$(document).on('click', '.btn-delete-handover', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + 'form/deletePicHandover',
                type: 'POST',
                data: { id_pic: id },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Deleting data...',
                        allowOutsideClick: false,
                        onOpen: function () {
                            Swal.showLoading();
                        }
                    });
                },
                success: function (response) {
                    swal.close();
                    swal.fire({
                        icon: response.status ? 'success' : 'error',
                        title: response.status ? 'Success' : 'Failed',
                        text: response.message,
                        timer: 5000,
                        timerProgressBar: true
                    }).then(() => {
                        // kalau mau reload setelah submit
                        location.reload();
                    }
                    );
                },
                error: function (xhr) {
                    swal.close();
                    swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: xhr.message || 'An error occurred while deleting the handover.'
                    }).then(() => {
                        // kalau mau reload setelah submit
                        location.reload();
                    });
                }
            });
        }
    });
});
$(document).on('click', '#submit-btn-handover', function () {
    const isSelectEmpty = $('#is_select_empty').val() === 'true';
    if(!isSelectEmpty) {
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Please select at least one PIC before submitting the handover.',
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }
    const idFormRequest = $('#id_form_request').val();
    const id_form_handover = $(this).data('id');
    $.ajax({
        url: base_url + 'form/saveHandover',
        type: 'POST',
        data: { 
            id_form_handover: id_form_handover,
            status: 1
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Submitting data...',
                allowOutsideClick: false,
                onOpen: function () {
                    Swal.showLoading();
                }
            });
        },
        success: function (response) {
            swal.close();
            
            swal.fire({
                icon: response.status ? 'success' : 'error',
                title: response.status ? 'Success' : 'Failed',
                text: response.message,
                timer: 5000,
                timerProgressBar: true
            }).then(() => {
                window.location.href = base_url + 'form/home_exit_clearance/' + idFormRequest;
            }
            );
        },
        error: function (xhr) {
            swal.close();
            swal.fire({
                icon: 'error',
                title: 'Failed',
                text: xhr.message || 'An error occurred while submitting the handover.'
            }).then(() => {
                // kalau mau reload setelah submit
                location.reload();
            });
        }
    });
});
$(document).on('click', '#update-handover', function () {
    const id_form_handover = $(this).data('id');
    const button = $(this);
    button.text('updating...');
    button.prop('disabled', true);
    $('#back-btn').prop('disabled', true);
    $.ajax({
        url: base_url + 'form/saveHandover',
        type: 'POST',
        data: { 
            id_form_handover: id_form_handover,
            status: 0
        },
        success: function (response) {
            if (response.status) {
                button.text('Save');
                button.prop('type', 'submit');
                button.prop('id', 'submit-btn-handover');
                button.prop('disabled', false);
                $('#back-btn').prop('disabled', false);
                $('#btn-add').prop('disabled', false);
                $('.btn-edit-handover').prop('disabled', false);
                $('.btn-delete-handover').prop('disabled', false);
                
            }
        },
        error: function (xhr) {
            swal.close();
            swal.fire({
                icon: 'error',
                title: 'Failed',
                text: xhr.message || 'An error occurred while submitting the handover.'
            }).then(() => {
                // kalau mau reload setelah submit
                location.reload();
            });
        }
    });
});