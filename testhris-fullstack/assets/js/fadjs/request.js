// Archive
// Datatable Init
$(document).ready(function () {

    $('.fdata').each(function () {
        var id = $(this).attr('id');
        var data = $(this).attr('data-ajaxsource');

        $('#' + id).dataTable({
            ajax: {
                url: data,
                type: 'POST',
            },
            order: [[ 2, "asc" ]],
            responsive: !0,
            autoWidth: !1,
            dom: '<"row justify-between g-2"<"col-7 col-sm-6 text-left"f><"col-5 col-sm-6 text-right"<"datatable-filter"l>>><"datatable-wrap my-3"t><"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-left text-md-right"i>>',
            language: {
                search: "",
                searchPlaceholder: "Type in to Search",
                lengthMenu: "<span class='d-none d-sm-inline-block'>Show</span><div class='form-control-select'> _MENU_ </div>",
                info: "_START_ -_END_ of _TOTAL_",
                infoEmpty: "No records found",
                infoFiltered: "( Total _MAX_  )",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Prev"
                }
            }
        });
    });

    // $('.listOpname').each(function () {
    //     var id = $(this).attr('id');
    //     var data = $(this).attr('data-ajaxsource');

    //     $('#' + id).dataTable({
    //         ajax: {
    //             url: data,
    //             type: 'POST',
    //         },
    //         order: [[ 2, "asc" ]],
    //         responsive: !0,
    //         autoWidth: !1,
    //         dom: '<"row justify-between g-2"<"col-7 col-sm-6 text-left"f><"col-5 col-sm-6 text-right"<"datatable-filter"l>>><"datatable-wrap my-3"t><"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-left text-md-right"i>>',
    //     });
    // });
    
});

// Create Request
if (document.getElementById('formRequest')) {
    Dropzone.autoDiscover = false;
}

$(document).ready(function () {

    if (document.getElementById('formRequest')) {
        var myDropzone = new Dropzone("#myId", {
            url: '#',
            autoProcessQueue: false,
            addRemoveLinks: true,
            acceptedFiles: '.jpg, .jpeg, .png, .pptx, .doc, .docx, .pdf, .xls, .xlsx, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf',
        });
    }

});

$('#formType').change(function (e) {
    e.preventDefault();
    var code = $('#formType').val();

    if ((code == 'IOM') || (code == 'KRO') || (code == 'SKEEP')) {
        $('#templateForm').hide();
    } else {
        $('#templateForm').show();
        $.ajax({
            url: "list/request/getTemplateForm",
            type: 'post',
            data: 'code=' + code,
            dataType: 'json',
            success: function (response) {
                var base_url = window.location.origin;
                var pathTemplateForm = base_url + response;
                $('#templateForm').attr('href', pathTemplateForm);
            },
            error: function (response) {
                console.log(response);
            }
        });

    }
});

// Add Approval Layer
$(document).ready(function () {
    var i = 0;
    $('#add').click(function (e) {
        e.preventDefault();
        i++;
        $.ajax({
            url: 'list/request/getUserList',
            datatype: 'json',
            type: "post",
            beforeSend: function () {
                $('#addLayerText').hide();
                $('#loadLayerSpinner').show();
            },
            success: function (data) {

                $('#addLayerText').show();
                $('#loadLayerSpinner').hide();
                // console.log(JSON.parse(data));

                var row = '';
                row = '<div class="card-inner card-inner-md" id="row' + i + '"><div class="user-card"><div class="user-avatar bg-primary-dim"><span><em class="icon ni ni-downward-ios"></em></span></div><div class="user-info"><div class="form-group"><div class="form-control-wrap" style="width:500px;"><select class="form-control form-control-md" data-search="on" id="emailUsers' + i + '" name="email[]" required><option values=""></option></select></div></div></div><div class="user-action"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-remove"></i>Remove</button></div></div></div>';
                $('#dynamic_field').append(row);
                $.each(JSON.parse(data), function (key, value) {
                    $('#emailUsers' + i).append($("<option></option>").attr("value", value.user_email).text(value.user_email));
                    $('#emailUsers' + i).select2();
                });
            }
        });
    });

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
});

// Document Upload Validation
$("#approvalFormScanned").change(function () {
    var file = this.files[0];
    var fileType = file.type;
    var match = ['application/pdf'];
    if (!((fileType == match[0]))) {
        alert('Oops, Approval Form Scanned must be PDF.');
        $("#approvalFormScanned").val('');
        return false;
    }
});

$("#multiSupportingFiles").change(function () {
    var file = this.files[0];
    var fileType = file.type;
    var match = ['image/jpg',
        'image/jpeg',
        'image/png',
        'application/msword', // .doc
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
        'application/vnd.ms-excel', // xls
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', //xlsx
        'application/vnd.ms-powerpoint', // ppt
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', // pptx
        'application/pdf'
    ];
    if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]) || (fileType == match[6]) || (fileType == match[7]) || (fileType == match[8]) || (fileType == match[9]))) {
        alert('Sorry, Please check your Supporting Files format.');
        $("#multiSupportingFiles").val('');
        return false;
    }
});

// Requestor Notes
$("#send_requestor_notes").click(function (e) {
    e.preventDefault();

    var id = $('#request_id').val();
    var requestor_notes = $('textarea#requestor_notes').val();

    $.ajax({
        url: "list/request/add_notes",
        type: 'post',
        data: 'request_id=' + id + '&requestor_notes=' + requestor_notes,
        // dataType: 'json',
        success: function (response) {

            if (response == 1) {
                $('textarea#requestor_notes').val('');
                viewRequest(id);

            } else {
                toastr.clear(), o.Toast("This is a note for bottom left toast message.", "info", {
                    position: "bottom-left"
                })
            }

        },
        error: function (response) {
            alert('internal error');
        }
    });

});


