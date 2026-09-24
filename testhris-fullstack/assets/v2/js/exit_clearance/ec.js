var isSubmitted = $('#is_submitted').val() === '1';

function initResignationDatepicker() {
    if (!$('#resignation_date').hasClass('hasDatepicker')) {
        $('#resignation_date').datepicker({
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });
    }
}

if (!isSubmitted) {
    initResignationDatepicker();
}

$('#resignation_date').on('changeDate', function(e) {
    var date = $(this).val();
    var notice_period = parseInt($('#notice_period').val());
    var formattedDate = calculate_last_day(date, notice_period);
    $('#is_generated').val('0');
    $('#filename').val('');
    $('#last_working_date').val(formattedDate);
    $('#generated_rl_pdf').hide();
    updateGenerateButton();
});
$(document).on('click', '#cancel_btn_edit', function() {
    var is_user = $('#is_user').val() === '1';
     if (!is_user) {
        window.location.href = base_url + 'inbox/approval_resignation_letter';
    } else {
        window.location.href = base_url + 'home/request';
    }
});
$(document).on('click', '#approve_back', function() {
    var can_approve = $('#can_approve').val() === '1';
    if (can_approve) {
        window.location.href = base_url + 'inbox/approval_resignation_letter';
    } else {
        window.location.href = base_url + 'home/request';
    }
});
$(document).on('click', '#cancel_btn', function() {
    var request_id = $('#request_id').val();
    Swal.fire({
        title: 'Are you sure?',
        text: "Your resignation request will be canceled.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + 'form/updateStatus',
                type: 'POST',
                data: {
                    status: 4,
                    request_id: request_id
                },
                success: function(response) {
                    if (response.status) {
                        window.location.href = base_url + 'home/request';
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    }
                }
            });
        }
    });
});

var generatedResignationDate = '';

function updateGenerateButton() {
    var resignationDate = $('#resignation_date').val();
    var is_submitted = $('#is_submitted').val() === '1';
    var just_view = $('#just_view').val() === '1'; 
    var $filename = $('#filename').val() !== '';
    if (is_submitted || just_view || $filename) {
        $('#generate_rl').prop('disabled', true);
        return;
    }else{
       var canGenerate = resignationDate && resignationDate !== generatedResignationDate;

        $('#generate_rl').prop('disabled', !canGenerate); 
    }
    
}

// $('#resignation_date').on('input change', updateGenerateButton);
// updateGenerateButton();

function calculate_last_day($resignationDate, $noticeMonth)
    {
        const date = new Date($resignationDate);
        const originalDay =  date.getDate();
        // Pindah ke tanggal 1 untuk menghindari masalah
        // ketika tanggal asli adalah 29, 30, atau 31
        date.setDate(1);

        // Tambahkan notice period
        date.setMonth(date.getMonth() + $noticeMonth);
        
        

        // Jumlah hari pada bulan tujuan
        const daysInTargetMonth = new Date(
            date.getFullYear(),
            date.getMonth() + 1,
            0
        ).getDate();

        // jika tidak gunakan tanggal terakhir bulan tersebut
        const targetDay = Math.min(originalDay, daysInTargetMonth);

        date.setDate(
            targetDay
        );
        console.log("ini disini date awal",date);

        // Jika tanggal asli tersedia di bulan tujuan,
        // kurangi 1 hari.
        // Jika tidak tersedia, tetap di akhir bulan.
        if (originalDay <= daysInTargetMonth) {
            date.setHours(date.getHours() - 24);
        }
        console.log("ini disini date akhir",date);
        return formatDateIndonesia(date);
    }
function formatDateIndonesia(date) {
    const months = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}

$('#generate_rl').on('click', function() {
    var request_id = $('#request_id').val();
    var resignation_date = $('#resignation_date').val();
    var last_working_date = $('#last_working_date').val();
    var notes = $('#notes').val();

    if (!resignation_date || !last_working_date) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Data',
            text: 'Please fill in both resignation date and last working date.',
            timer: 5000,
            timerProgressBar: true,
        });
        return;
    }
    Swal.fire({
        title: 'Generate Resignation Letter',
        text: 'Please wait...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: base_url + 'form/generate_resignation_letter',
        type: 'POST',
        data: {
            request_id: request_id,
            resignation_date: resignation_date,
            notes: notes,
            last_working_date: last_working_date
        },
        dataType: 'json',

        success: function (response) {

            if (response.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Resignation letter generated successfully.',
                    confirmButtonText: 'Close',
                    timer: 5000,
                    timerProgressBar: true,
                });
                $('#filename').val(response.filename);
                generatedResignationDate = resignation_date;
                $('#generate_rl').prop('disabled', true);
                $('#generated_rl_pdf').show();
                $('#is_generated').val('1');

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: response.message || 'Failed to generate resignation letter.',
                    timer: 5000,
                    timerProgressBar: true,
                });

            }
        },

        error: function (xhr) {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong while generating the letter.',
                timer: 5000,
                timerProgressBar: true,
            });

        }
    });

});
$('#generated_rl_pdf').on('click', function() {
    var filename = $('#filename').val();
    var employee_id = $('#employee_id').val();
    if (filename) {
        var url = base_url + 'form/view_resignation_letter/' + employee_id + '/' + filename;
        window.open(url, '_blank');
    }
});

$('#form-submit-rl').on('submit', function(e) {
    e.preventDefault();

    var form = $(this);

    var resignation_date = $('#resignation_date').val();
    var last_working_date = $('#last_working_date').val();
    var notes = $('#notes').val();
    var id_request = $('#id_encode').val();

    if (!resignation_date || !last_working_date) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Data',
            text: 'Please fill in the resignation date and last working date.',
            timer: 5000,
        timerProgressBar: true,
        });

        return;
    }
    if ($('#is_generated').val() !== '1') {
        Swal.fire({
            icon: 'warning',
            title: 'Resignation Letter Not Generated',
            text: 'Please generate the resignation letter before submitting.',
            timer: 5000,
        timerProgressBar: true,
        });
        return;
    }

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: {
            request_id: $('#request_id').val(),
            resignation_date: resignation_date,
            last_working_date: last_working_date,
            notes: notes
        },
        dataType: 'json',

        beforeSend: function() {
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },

        success: function(response) {

            if (response.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 5000,
                    timerProgressBar: true,
                }).then(() => {
                    // kalau mau reload setelah submit
                    // location.reload();
                    window.location.href = base_url + 'inbox/detail_req_resignation_letter/' + id_request;
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: response.message,
                    timer: 5000,
                    timerProgressBar: true
                });

            }
        },

        error: function(xhr) {

            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong while submitting the resignation request.',
                timer: 5000,
                timerProgressBar: true
            });
        }
        });
});

$('#btn_edit').on('click', function(e) {
    var button = $(this);
    button.text('Processing...');
    button.prop('disabled', true);
    var request_id = $('#request_id').val();
    $.ajax({
        url: base_url + 'form/updateStatus',
        type: 'POST',
        data: {
            status: 0,
            request_id: request_id
        },
        success: function(response) {
            if (response.status) {
                button.hide();
                $('#is_submitted').val('0');
                $('#just_view').val('0');
                $('#cancel_btn').hide();
                $('#edit_mode').val('1');
                $('#resignation_date, #notes').prop('readonly', false);
                $('#submit_btn').show();
                initResignationDatepicker();
                updateGenerateButton();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    timer: 5000,
                    timerProgressBar: true
                });
            }
        }
    });
});
$('#revise_btn').on('click', function(e) {
    e.preventDefault();

    var id = $('#id_form_request').val();

    Swal.fire({
        title: 'Revise Resignation Letter',
        text: 'Please provide a reason for revision.',
        input: 'textarea',
        inputPlaceholder: 'Enter your reason...',
        inputAttributes: {
            'aria-label': 'Enter your reason'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        reverseButtons: true,

        inputValidator: (value) => {
            if (!value || !value.trim()) {
                return 'Reason is required!';
            }
        }
    }).then((result) => {

        if (result.isConfirmed) {

            const notes = result.value;
            $.ajax({
                url: base_url + 'inbox/do_approval_resignation_letter',
                type: 'POST',
                data: {
                    id: id,
                    status: "Revised",
                    notes: notes,
                },
                dataType: 'json',

                beforeSend: function() {
                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },

                success: function(response) {

                    if (response.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 5000,
                            timerProgressBar: true,
                        }).then(() => {
                            // kalau mau reload setelah submit
                            // location.reload();
                            window.location.href = base_url + 'inbox/approval_resignation_letter';
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: response.message,
                            timer: 5000,
                            timerProgressBar: true
                        });

                    }
                },

                error: function(xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong while submitting the resignation request.',
                        timer: 5000,
                        timerProgressBar: true
                    });
                }
            });
        }
    });
    
});
$('#approve_btn').on('click', function(e) {
    e.preventDefault();

    var id = $('#id_form_request').val();

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Approve it!',
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: base_url + 'inbox/do_approval_resignation_letter',
                type: 'POST',
                data: {
                    id: id,
                    status: "Approved",
                },
                dataType: 'json',

                beforeSend: function() {
                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },

                success: function(response) {

                    if (response.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 5000,
                            timerProgressBar: true,
                        }).then(() => {
                            // kalau mau reload setelah submit
                            // location.reload();
                            window.location.href = base_url + 'inbox/approval_resignation_letter';
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: response.message,
                            timer: 5000,
                            timerProgressBar: true
                        });

                    }
                },

                error: function(xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong while submitting the resignation request.',
                        timer: 5000,
                        timerProgressBar: true
                    });
                }
            });
        }
    });
    
});
$('#add_note').on('click', function(e) {
    e.preventDefault();

    var id = $('#request_id').val();

    Swal.fire({
        title: 'Note',
        input: 'textarea',
        inputPlaceholder: 'Enter your note here',
        inputAttributes: {
            'aria-label': 'Enter your note here'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        reverseButtons: true,

        inputValidator: (value) => {
            if (!value || !value.trim()) {
                return 'Note is required!';
            }
        }
    }).then((result) => {

        if (result.isConfirmed) {

            const notes = result.value;
            $.ajax({
                url: base_url + 'inbox/addNote',
                type: 'POST',
                data: {
                    id: id,
                    notes: notes,
                },
                dataType: 'json',

                beforeSend: function() {
                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },

                success: function(response) {

                    if (response.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 5000,
                            timerProgressBar: true,
                        }).then(() => {
                            // kalau mau reload setelah submit
                            location.reload();
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: response.message,
                            timer: 5000,
                            timerProgressBar: true
                        });

                    }
                },

                error: function(xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong while submitting the resignation request.',
                        timer: 5000,
                        timerProgressBar: true
                    });
                }
            });
        }
    });
    
});