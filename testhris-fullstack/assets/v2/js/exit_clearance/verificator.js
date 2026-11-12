$(document).on('click', '#btn-verificator', function(e) {
        const myNote = $('textarea.my-note');
        const id_my_note = myNote.length !== 0 ? myNote.attr('id').replace('note-', '') : '';
        const newNote = $('#note-approve');
        const button = $(this);
        const data = button.data('submit-data');
        const dataValue = button.data('value');
        const data_decode = JSON.parse(atob(data));
        const sectionId = data_decode.section_id;
        const sectionSavedId = data_decode.section_saved_id;
        const idForm = data_decode.id_form;
        const idEc = data_decode.id_ec;
        const idRequest = data_decode.id_request;
        const word = dataValue === 'revised' ? 'Revising Data' : 'Approving Data';

        const note = myNote.length
        ? myNote.val()
        : newNote.val();
        
        $.ajax({
            url: base_url + 'inbox/do_approval_exit_clearance',
            type: 'POST',
                data: {
                        id_section: sectionId,
                        id_section_saved: sectionSavedId,
                        id_form: idForm,
                        id_exit_clearance: idEc,
                        id_request: idRequest,
                        notes: note,
                        status: dataValue,
                        type: 'verificator',
                        id_note: id_my_note
                        },
                dataType: 'json',
                beforeSend: function () {
                        Swal.fire({
                                title: word,
                                allowOutsideClick: false,
                                onOpen: function () {
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
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                                Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                            }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
        });


        
});