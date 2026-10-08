$('.icon-acc').on('click', function () {
    $(this).toggleClass('icon-acc-open');
});
let EL = null;

$(document).on('click', '.btn-add-pic', function () {
    if ($(this).hasClass('disabled')) {
        return;
    }

    const wrapper = $(this).closest('.pic-assignment');

    const totalPIC = wrapper.find('.pic-item').length;

    if (totalPIC >= 3) {
        return;
    }
    if (EL !== null) {
        console.log('EL is not null');
        showEmployeeSelect(wrapper);

        return;
    }

    $.ajax({
        url: base_url + 'form/getAllEmployee',
        type: 'GET',
        dataType: 'json',

        beforeSend: function () {

            Swal.fire({
                title: 'Loading Employee Data...',
                allowOutsideClick: false,
                onOpen: function () {
                    Swal.showLoading();
                }
            });

        },

        success: function (response) {

            Swal.close();

            if (!response.status) {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Employee data not found.'
                });

                return;
            }

            // SIMPAN
            EL = response.data;
            // Tampilkan pilihan
            showEmployeeSelect(wrapper);


        },

        error: function (xhr) {

            console.error(xhr);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load employee data.'
            });

        }
    });

});

function showEmployeeSelect(wrapper) {

    // ============================
    // 1. Ambil ID employee yang
    //    sudah dipilih
    // ============================

    const selectedEmployeeIds = [];

    wrapper.find('.pic-item').each(function () {

        const employeeId = $(this).attr('data-value');

        if (employeeId) {
            selectedEmployeeIds.push(String(employeeId).trim());
        }

    });


    // ============================
    // 2. Filter employee
    //    yang belum dipilih
    // ============================

    const availableEmployees = EL.filter(function (employee) {

        return !selectedEmployeeIds.includes(
            String(employee.nik).trim()
        );

    });


    // ============================
    // 3. Buat option select
    // ============================

    let options = `
        <option value=""></option>
    `;

    availableEmployees.forEach(function (employee) {

        options += `
            <option value="${employee.nik}">
                ${employee.complete_name} - (${employee.nik})
            </option>
        `;

    });


    // ============================
    // 4. SweetAlert
    // ============================

    Swal.fire({

        title: 'Choose PIC Assignment',

        html: `
            <select id="select-employee"
                    class="form-control"
                    style="width: 100%;">

                ${options}

            </select>
        `,

        showCancelButton: true,

        confirmButtonText: 'Add',

        cancelButtonText: 'Cancel',

        onOpen: function () {

            $('#select-employee').select2({

                dropdownParent: $('.swal2-popup'),

                placeholder: 'Search Employee...',

                allowClear: true,

                width: '100%'

            });

        },

        preConfirm: function () {

            const employeeId =
                $('#select-employee').val();

            if (!employeeId) {

                Swal.showValidationMessage(
                    'Please select an employee.'
                );

                return false;
            }

            return employeeId;

        }

    }).then(function (result) {

        // User klik Batal
        if (!result.isConfirmed) {
            return;
        }


        // ============================
        // 5. Ambil employee yang dipilih
        // ============================

        const employeeId = result.value;

        const employee = EL.find(function (item) {

            return String(item.nik) === String(employeeId);

        });


        if (!employee) {
            return;
        }


        // ============================
        // 6. Masukkan ke list PIC
        // ============================

        const item = `

            <div class="pic-item"
                data-type="internal"
                data-value="${employee.nik}">

                <span>${employee.complete_name} - (${employee.nik})</span>

                <i class="fa-solid fa-xmark pic-remove"></i>

                <input
                    type="hidden"
                    name="pic[${wrapper.data('question-id')}][]"
                    value="${employee.nik}"
                    data-value-compose = "${employee.complete_name}-${employee.nik}-${employee.email}"
                >
            </div>

        `;

        wrapper.find('.pic-list').append(item);
        const totalPIC = wrapper.find('.pic-item').length;
        if (totalPIC >= 3) {
            wrapper.find('.btn-add-pic').hide();
        }

    });

}

$(document).on('click', '.pic-remove', function () {
    const wrapper = $(this).closest('.pic-assignment');
    const totalPIC = wrapper.find('.pic-item').length;
    $(this).closest('.pic-item').remove();
    if (totalPIC <= 3) {
        wrapper.find('.btn-add-pic').show();
    }
});

$(document).on('submit', '#formAccordion', function (e) {
    e.preventDefault();
    const idFormExit = $('#id_form_exit').val();
    const idFormRequest = $('#id_form_request').val();
    const unsavedSections = [];

    $('.wrap-section').each(function () {
        const section = $(this);
        const sectionId = section.data('section-id');
        const sectionName = section.data('section-name');
        const saved = $('#saved-' + sectionId).val() === '1';

        if (!saved) {
            unsavedSections.push(sectionName);
        }
    });

    if (unsavedSections.length > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Failed to submit',
            text: 'Please save all sections before submitting the form. Unsaved sections: ' + unsavedSections.join(', ')
        });

        return;
    }


    $.ajax({
        url: base_url + 'form/saveFormExitClearance',
        type: 'POST',
        data: {
            idFormExit: idFormExit
        },
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
            $('#submit-btn').hide();
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

$(document).on('click', '.btn-save-section', function () {
    const idFormExit = $('#id_form_exit').val();
    const button = $(this);
    const section = button.closest('.wrap-section');
    const sectionId = section.data('section-id');
    const noteInput = section.find('textarea[name="note-' + sectionId + '"]');
    const noteValue = noteInput.val();

    const formData = new FormData();

    formData.append('id_form_exit', idFormExit);
    formData.append('note', noteValue);

    // section ID
    formData.append('section_id', sectionId);
    let isValid = true;
    // ambil semua input dalam section
    section.find(':input[name]').each(function () {

        const input = $(this);

        // disabled tidak ikut
        if (input.is(':disabled')) {
            return;
        }


        // checkbox yang tidak dipilih tidak ikut
        if (input.is(':checkbox') && !input.is(':checked')) {
            return;
        }

        // checkbox yang tidak dicentang tidak ikut
        if (input.is(':checkbox') && !input.is(':checked')) {
            return;
        }
        const pic = input.closest('.pic-item').length;
        const value = pic
            ? input.data('value-compose')
            : input.val();

        formData.append(
            input.attr('name'),
            value
        );
    });
    if(sectionId === 1){
        const picAssignment = section.find('.pic-assignment');
        const idParent = picAssignment.data('parent-id');
        const parentInput = idParent ? section.find('#question-' + idParent) : null;
        const picLength = section.find('.pic-item').length;
        if (parentInput && parentInput.length && parentInput.is(':checked') && picLength === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'PIC Assignment Required',
                text: 'Please select at least one PIC before saving this section.'
            });
            return;
        }
    }

    $.ajax({
        url: base_url + 'form/saveSection',
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

            if (response.status) {
                $('#saved-' + sectionId).val('1');
                $('#cancel-' + sectionId).addClass('unsave');
                $('#flag-' + sectionId)
                .removeClass('unsave')
                .addClass('save')
                $('#flag-text-' + sectionId)
                .text('Saved');
                button
                    .removeClass('btn-save-section')
                    .addClass('btn-edit-section')
                    .text('Edit');
                
                section.find(':input[name]')
                    .prop('disabled', true)
                    .prop('readonly', true);
                $('#submit-btn').show();
                $('.btn-add-pic').addClass('disabled');
                $('.pic-remove').addClass('disabled');
            }

            swal.fire({
                icon: response.status ? 'success' : 'error',
                title: response.status ? 'Success' : 'Failed',
                text: response.message,
                timer: 5000,
                timerProgressBar: true
            });
        },
        error: function (xhr) {
            swal.close();
            swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menyimpan data.'
            });
        }

    });
});

function syncQuestionChildren(section) {
    const sectionId = section.data('section-id');
    const sectionSaved = $('#saved-' + sectionId).val() === '1';

    section.find('[data-parent-id]').each(function () {
        const child = $(this);
        const parentId = child.data('parent-id');
        const parent = section.find('#question-' + parentId);

        if (!parent.length) {
            return;
        }

        const parentAnswered = parent.is(':checkbox')
            ? parent.is(':checked')
            : String(parent.val() || '') !== '';
        const inputs = child.is(':input') ? child : child.find(':input');

        inputs.prop('disabled', !parentAnswered);

        if (child.data('question-type') === 'special') {
            child.find('.btn-add-pic')
                .toggleClass('disabled', sectionSaved || !parentAnswered);
        }
    });
}

$(function () {
    $('.wrap-section').each(function () {
        syncQuestionChildren($(this));
    });
});

$(document).on('change', '.question-checkbox', function () {
    syncQuestionChildren($(this).closest('.wrap-section'));
});

$(document).on('click', '.btn-edit-section', function () {
    const button = $(this);
    const section = button.closest('.wrap-section');
    const sectionId = section.data('section-id');
    section.data('original-html', section.html());
    $('#saved-' + sectionId).val('0');
    $('#flag-' + sectionId)
        .removeClass('save')
        .addClass('unsave')
    $('#cancel-' + sectionId).removeClass('unsave');
    section.find(':input[name]')
        .prop('disabled', false)
        .prop('readonly', false);

    section.find('.btn-add-pic').removeClass('disabled');
    section.find('.pic-remove').removeClass('disabled');

    syncQuestionChildren(section);

    section.find('.pic-assignment').each(function () {
        const wrapper = $(this);
        const totalPIC = wrapper.find('.pic-item').length;

        if (totalPIC >= 3) {
            wrapper.find('.btn-add-pic').hide();
        } else {
            wrapper.find('.btn-add-pic').show();
        }
    });

    button
        .removeClass('btn-edit-section')
        .addClass('btn-save-section')
        .text('Save');
});
$(document).on('click', '.btn-cancel-section', function () {
    const button = $(this);
    const section = button.closest('.wrap-section');
    const originalHtml = section.data('original-html');
    section.html(originalHtml);
});
$(document).on('click', '#back-btn', function () {
    const idFormRequest = $('#id_form_request').val();
    window.location.href = base_url + 'form/home_exit_clearance/' + idFormRequest;
});
$('.collapse').on('hidden.bs.collapse', function () {
    $(this)
        .closest('.wrap-section')
        .find('.icon-acc')
        .removeClass('icon-acc-open');
});
$(document).on('click', '#cantAccess', function () {
    Swal.fire({
        icon: 'warning',
        title: 'Access Denied',
        text: 'You cannot open this section because the previous section has not been completed yet. Please complete the previous section first.'
    });
});