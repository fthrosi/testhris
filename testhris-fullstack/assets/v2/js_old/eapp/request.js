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

});

// $('#formType').change(function (e) {
//     e.preventDefault();

//     var formType = $('#formType').val();
//     $.ajax({
//         url: "list/request/getFormCategory",
//         type: 'post',
//         data: 'formType=' + formType,
//         dataType: 'json',
//         beforeSend: function () {
//             console.log();
//         },
//         success: function (response) {

//             console.log();

//             var formCategory = $('#formCategory').val(response);

//             //alert(formCategory[0]);

//             if (response = 'dedicated') {

//                 $('#formUpload').hide();
//                 $('#formDedicated').show();
//                 $('#form_'+formType).show();

//             } else {
                
//                 $('#formUpload').show();
//                 $('#formDedicated').hide();

//                 if ((formType == 'KRO') || (formType == 'SKEEP')) {
//                     $('#templateForm').hide();
//                 } else {
//                     $('#templateForm').show();
//                     $.ajax({
//                         url: "list/request/getTemplateForm",
//                         type: 'post',
//                         data: 'code=' + formType,
//                         dataType: 'json',
//                         success: function (response) {
//                             var base_url = window.location.origin;
//                             var pathTemplateForm = base_url + response;
//                             $('#templateForm').attr('href', pathTemplateForm);
//                         },
//                         error: function (response) {
//                             console.log(response);
//                         }
//                     });
//                 }

//             }

//         },
//         error: function (response) {
//             console.log(response);
//         }
//     });
// });

function save_request_notes() {

    if (($('#request-notes').val() == "")) {  return false;}

    var base_url = window.location.origin;
    var id = $('#request_id').val();
    var notes = $('#request-notes').val();
    var postData = {
        request_id: id,
        notes: notes
    }
    $.ajax({
        method: 'post',
        url:  'form/save/request_notes/'+id,
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            $('#text-request-notes').text('Please wait...');
        },
        success: function (response) {
            
            $('#text-request-notes').text('Save');
            
            if (response.status == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.messages,
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#modalAddNotes').modal('toggle');
                $('#request-notes').val('');
                $("#request_notes_area").load(" #request_notes_area > *");

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: response.messages,
                    showConfirmButton: false,
                    timer: 5000
                });
            }
        }
    });
}

function delete_notes(id) {
    var id_request = $('#id_request').val();
    var postData = {
        id_notes: id,
        id_request: id_request
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure!',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {

        if (result.value) {
            $.ajax({
                method: 'post',
                url: 'form/save/delete_request_notes/' + id,
                data: postData,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $("#request_notes_area").load(" #request_notes_area > *");

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                },
                error: function (response) {
                    alert('Oops! Internal error. Please refresh this page and try again.');
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })
}

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


//////////////////////////////// Master RPM
$('#rpm_employee_id').keydown(function (e){
    // e.preventDefault(); 
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    if(e.keyCode == 13){
        var employee_nik = $('#rpm_employee_id').val();

        $.ajax({
            url: "form/PPD/getDetailEmployee",
            type: 'post',
            data: 'employee_nik=' + employee_nik,
            dataType: 'json',
            success: function (response) {

                if (response.status) {
                    
                    $('#rpm_not_found').text('');
                    $('#rpm_email').val(response.email);
                    $('#rpm_full_name').val(response.name);

                } else {
                    
                    $('#rpm_not_found').text('NIK Not Found');

                }

            },
            error: function (response) {
                console.log(response);
            }
        });
    }

});

$("#add_rpm").click(function (e) {
    e.preventDefault();
    var rpm_employee_id = $('#rpm_employee_id').val();
    var rpm_email = $('#rpm_email').val();
    var rpm_full_name = $('#rpm_full_name').val();
    var rpm_region = $('#rpm_region').val();

    var postData = {
        rpm_employee_id:rpm_employee_id,
        rpm_email:rpm_email,
        rpm_full_name:rpm_full_name,
        rpm_region:rpm_region,
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    $.ajax({
        url: "master/add_rpm",
        type: 'post',
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
            $('#text-save-rpm').text('Please wait..');
        },
        success: function (response) {

            $('#text-save-rpm').text('Save');
            
            if (response.status == 1) {
                swalWithBootstrapButtons.fire('Saved!', 'Data form has been saved.', 'success')
                // $('#table_list_rpm').DataTable().ajax.reload();

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }

        },
        error: function (response) {
            $('#text-save-rpm').text('Save');
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Oops! There\'s something wrong. Please refresh the page and try again.',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
});

/////////////////////////////// FORM PPD
$('#paid_to').change(function (e) {
    e.preventDefault();

    if ($('#employee_nik').val() === '') {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Pilih NIK Pejalan Dinas terlebih dahulu.',
            showConfirmButton: false,
            timer: 2000
        });
        return false;
    }

    var nik = $('#employee_nik').val();
    var bank = $('#paid_to').val();

    $.ajax({
        url: "form/PPD/getBankAccount",
        type: 'post',
        data: 'nik=' + nik + '&bank=' + bank,
        dataType: 'json',
        success: function (response) {

            console.log(response);

            if (response.status) {
                $('#norek').val(response.acc_number);
                $('#atas_nama').val(response.acc_name);    
            } else {
                alert(response.message);
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
});

$('#employee_nik').keydown(function (e){
    // e.preventDefault(); 
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    if(e.keyCode == 13){
        var employee_nik = $('#employee_nik').val();
        var created_by = $('#created_by').val();

        var count_nik = employee_nik.length;
        if (count_nik < 8) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Mohon masukan 8 digit NIK.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        $.ajax({
            url: "form/PPD/getDetailEmployee",
            type: 'post',
            data: 'employee_nik=' + employee_nik,
            dataType: 'json',
            success: function (response) {

                if (response.status) {

                    $("#nominal_hotel").attr({
                       "maxlength" : response.nom_hotel,
                       "max" : response.nom_hotel,
                       "min" : 0
                    });

                    $('#employee_email').val(response.email);
                    $('#cost_center').val(response.cost_center);
                    $('#employee_division').val(response.division);
                    $('#employee_position').val(response.position);
                    $('#nama_pejalan_dinas').val(response.name);
                    $('#lokasi_kantor').val(response.lokasi_kantor);
                    $('#personnel_subarea').val(response.personnel_subarea);
                    $('#range_grade').val(response.range_grade);

                    if ($('#tujuan_ppd_ya').is(":checked")) {
                        var setengah_diem = parseFloat(response.nom_diem * 0.5);
                        $('#nominal_diem').val(setengah_diem);
                        $('#nominal_diem_tb').val(rupiah(setengah_diem));
                    } else {
                        $('#nominal_diem').val(response.nom_diem);
                        $('#nominal_diem_tb').val(rupiah(response.nom_diem));
                    }
                    
                    calculate_total_hari_ppd();
                    calculate_ppd();

                    if (response.email !== created_by) {
                        $('#row_requestor').show();
                        $('#requestor_email').val(response.email);
                    } else {
                        $('#row_requestor').hide();
                        $('#requestor_email').val('');
                    }

                    $('#layer_1').val(response.layer_1);
                    $('#hr_layer_1').val(response.hr_layer_1);
                    $('#hr_layer_2').val(response.hr_layer_2);

                } else {
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    $('#employee_email').val('');
                    $('#cost_center').val('');
                    $('#employee_division').val('');
                    $('#employee_position').val('');
                    $('#nama_pejalan_dinas').val('');
                    $('#lokasi_kantor').val('');
                    $('#personnel_subarea').val('');
                    $('#range_grade').val('');
                    $('#nominal_diem').val('0');
                    $('#nominal_diem_tb').val('0');
                    
                    // calculate_ppd();

                    $('#row_requestor').hide();
                    $('#requestor_email').val('');
                    $('#layer_1').val('');
                    $('#hr_layer_1').val('');
                    $('#hr_layer_2').val('');

                }

            },
            error: function (response) {
                console.log(response);
            }
        });
    }

});

function check_max_hotel()
{
    var employee_nik = $('#employee_nik').val();
    var kota_tujuan = $('#kota_tujuan').val();
    var input_nom_hotel = parseInt($('#nominal_hotel').val());

    if (kota_tujuan === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Pilih Kota Tujuan terlebih dahulu.',showConfirmButton: false,timer: 2000});
        $('#nominal_hotel').val(0);
        return false;
    }

    var postData = {
        employee_nik:employee_nik,
        kota_tujuan:kota_tujuan,
    }

    $.ajax({
        url: "form/PPD/check_max_hotel",
        type: 'post',
        data: postData,
        dataType: 'json',
        success: function (response) {

            if (response.status) {

                var max_hotel = parseInt(response.nom_hotel);

                if (input_nom_hotel > max_hotel) {
                    $('#text_max_hotel').text("Maksimum nominal hotel: " + rupiah(response.nom_hotel));
                } else {
                    $('#text_max_hotel').text("");
                    return false;
                }

            } else {
                
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });

            }

        },
        error: function (response) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: "Something went wrong. Please refresh the page and try again.",
                showConfirmButton: false,
                timer: 2000
            });
            console.log(response);
        }
    });
}

function calculate_ppd()
{
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    if ($('#employee_nik').val() === '') {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Masukan NIK terlebih dahulu lalu tekan Enter.',
            showConfirmButton: false,
            timer: 2000
        });
        return false;
    }

    if ($('#tgl_berangkat').val() === '' || $('#tgl_kembali').val() === '') {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Input Tgl. Keberangkatan dan Tgl. Kembali.',
            showConfirmButton: false,
            timer: 2000
        });
        return false;
    }

    var x_diem = (document.getElementById("x_diem").value == '') ? 0 : parseFloat(document.getElementById("x_diem").value); 
    var nominal_diem = (document.getElementById("nominal_diem").value == '') ? 0 : parseFloat(document.getElementById("nominal_diem").value); 
    var total_diem  = (parseFloat(document.getElementById("total_diem").value) == '') ? 0 : parseFloat(document.getElementById("total_diem").value); 
    var x_hotel = (document.getElementById("x_hotel").value == '') ? 0 : parseFloat(document.getElementById("x_hotel").value); 
    var nominal_hotel = (document.getElementById("nominal_hotel").value == '') ? 0 : parseFloat(document.getElementById("nominal_hotel").value); 
    var total_hotel  = (parseFloat(document.getElementById("total_hotel").value) == '') ? 0 : parseFloat(document.getElementById("total_hotel").value); 
    var x_lain_lain = (document.getElementById("x_lain_lain").value == '') ? 0 : parseFloat(document.getElementById("x_lain_lain").value); 
    var nominal_lain_lain = (document.getElementById("nominal_lain_lain").value == '') ? 0 : parseFloat(document.getElementById("nominal_lain_lain").value); 
    var total_lain_lain  = (parseFloat(document.getElementById("total_lain_lain").value) == '') ? 0 : parseFloat(document.getElementById("total_lain_lain").value);     
    var x_transport = (document.getElementById("x_transport").value == '') ? 0 : parseFloat(document.getElementById("x_transport").value); 
    var nominal_transport = (document.getElementById("nominal_transport").value == '') ? 0 : parseFloat(document.getElementById("nominal_transport").value); 
    var total_transport  = (parseFloat(document.getElementById("total_transport").value) == '') ? 0 : parseFloat(document.getElementById("total_transport").value);     
    var total_hari_ppd = $('#total_hari').val();
    var pengali_diem = $('#pengali_diem').val();

    if (x_hotel >= total_hari_ppd) {
        $('#text_hotel').text("Maksimum hotel adalah total hari PPD - 1");
    } else {
        $('#text_hotel').text("");
    }

    total_diem = parseFloat(x_diem * nominal_diem);
    total_hotel = parseFloat(x_hotel * nominal_hotel);
    total_transport = parseFloat(x_transport * nominal_transport);
    total_lain_lain = parseFloat(x_lain_lain * nominal_lain_lain);
    var grand_total = parseFloat(total_diem + total_hotel + total_transport + total_lain_lain);

    $('#total_diem').val(total_diem);
    $('#total_diem_tb').val(rupiah(total_diem));
    $('#total_hotel').val(total_hotel);
    $('#total_hotel_tb').val(rupiah(total_hotel));
    $('#total_transport').val(total_transport);
    $('#total_transport_tb').val(rupiah(total_transport));
    $('#total_lain_lain').val(total_lain_lain);
    $('#total_lain_lain_tb').val(rupiah(total_lain_lain));
    $('#total_uang_muka').val(grand_total);
    $('#total_uang_muka_tb').val(rupiah(grand_total));

}

$("#tgl_berangkat").datepicker({
    todayBtn:  1,
    autoclose: true,
}).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#tgl_kembali').datepicker('setStartDate', minDate);
    $('#tgl_kembali').datepicker('setDate', minDate); 
});

function calculate_total_hari_ppd()
{
    var tgl_berangkat = new Date(document.getElementById("tgl_berangkat").value); 
    var tgl_kembali = new Date(document.getElementById("tgl_kembali").value); 
    var waktu_berangkat = new Date(document.getElementById("waktu_berangkat").value); 
    var waktu_kembali = new Date(document.getElementById("waktu_kembali").value); 
    
    var days = new Date(tgl_kembali - tgl_berangkat) / (1000 * 60 * 60 * 24);
    var total_hari = Math.round(days);

    // alert($('#waktu_berangkat').val());
    // alert(waktu_berangkat); return false;
    // alert($('#waktu_kembali').val());
    // alert(waktu_kembali);return false;
    // alert(total_hari);return false;

    if(isNaN(total_hari)) {
        $('#total_hari').val(0);
        $('#x_diem').val(0);
    } else {

        if (total_hari > 14) {
            $('#text_total_hari').text("* Maksimum total hari PPD adalah 14 hari.");    
        } else {
            $('#text_total_hari').text("");
        }

        $('#total_hari').val(total_hari);
        $('#x_diem').val(total_hari); 
        calculate_ppd(); 
    }
}

$("#tujuan_ppd_ya").click(function (e) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    $('#tujuan_ppd_tidak').prop('checked', false);

    if ($('#tgl_berangkat').val() === '' || $('#tgl_kembali').val() === '') {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Mohon isi tanggal keberangkatan dan tanggal kembali terlebih dahulu.',
            showConfirmButton: false,
            timer: 2000
        });
        return false;
    }

    var employee_nik = $('#employee_nik').val();
    var x_diem = (document.getElementById("x_diem").value == '') ? 0 : parseFloat(document.getElementById("x_diem").value);
    var total_diem = (document.getElementById("total_diem").value == '') ? 0 : parseFloat(document.getElementById("total_diem").value);

    $.ajax({
        url: "form/PPD/getDetailEmployee",
        type: 'post',
        data: 'employee_nik=' + employee_nik,
        dataType: 'json',
        success: function (response) {

            if (response.status) {

                var nominal_diem = response.nom_diem;

                if ($('#tujuan_ppd_ya').is(":checked")) {
                    $('#tujuan_ppd_tidak').prop('checked', false);
                    $('#pengali_diem').val('0.5');
                    $('#pengali_diem_text').text('Nominal diem dikalikan 0.5');

                    var diem = parseFloat(nominal_diem * 0.5);
                    $('#nominal_diem').val(diem);
                    $('#nominal_diem_tb').val(rupiah(diem));
                    total_diem = parseFloat(x_diem * diem);
                    $('#total_diem').val(total_diem);
                    $('#total_diem_tb').val(rupiah(total_diem));
                } else {
                    
                    $('#pengali_diem').val('1');
                    $('#pengali_diem_text').text('Nominal diem normal');
                    $('#nominal_diem').val(nominal_diem);
                    $('#nominal_diem_tb').val(rupiah(nominal_diem));
                    total_diem = parseFloat(x_diem * nominal_diem);
                    $('#total_diem').val(total_diem);
                    $('#total_diem_tb').val(rupiah(total_diem));
                }

                calculate_ppd();

            } else {
                
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });

            }

        },
        error: function (response) {
            console.log(response);
        }
    });
});

$("#tujuan_ppd_tidak").click(function (e) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    $('#tujuan_ppd_ya').prop('checked', false);

    if ($('#tgl_berangkat').val() === '' || $('#tgl_kembali').val() === '') {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Mohon isi tanggal keberangkatan dan tanggal kembali terlebih dahulu.',
            showConfirmButton: false,
            timer: 2000
        });
        return false;
    }

    var employee_nik = $('#employee_nik').val();
    var x_diem = (document.getElementById("x_diem").value == '') ? 0 : parseFloat(document.getElementById("x_diem").value);
    var total_diem = (document.getElementById("total_diem").value == '') ? 0 : parseFloat(document.getElementById("total_diem").value);

    $.ajax({
        url: "form/PPD/getDetailEmployee",
        type: 'post',
        data: 'employee_nik=' + employee_nik,
        dataType: 'json',
        success: function (response) {

            if (response.status) {

                var nominal_diem = response.nom_diem;

                if ($('#tujuan_ppd_tidak').is(":checked")) {
                    $('#tujuan_ppd_ya').prop('checked', false);
                    $('#pengali_diem').val('1');
                    $('#pengali_diem_text').text('Nominal diem normal');
                    $('#nominal_diem').val(nominal_diem);
                    $('#nominal_diem_tb').val(rupiah(nominal_diem));
                    total_diem = parseFloat(x_diem * nominal_diem);
                    $('#total_diem').val(total_diem);
                    $('#total_diem_tb').val(rupiah(total_diem));

                } else {
                    $('#pengali_diem').val('0.5');
                    $('#pengali_diem_text').text('Nominal diem dikalikan 0.5');
                    var diem = parseFloat(nominal_diem * 0.5);
                    $('#nominal_diem').val(diem);
                    $('#nominal_diem_tb').val(rupiah(diem));
                    total_diem = parseFloat(x_diem * diem);
                    $('#total_diem').val(total_diem);
                    $('#total_diem_tb').val(rupiah(total_diem));
                }

                calculate_ppd();

            } else {
                
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });

            }

        },
        error: function (response) {
            console.log(response);
        }
    });
});

$("#dalam_negeri").click(function (e) {
    $('#luar_negeri').prop('checked', false);
});

$("#luar_negeri").click(function (e) {
    $('#dalam_negeri').prop('checked', false);
});

$("#IDR").click(function (e) {
    $('#USD').prop('checked', false);
});

$("#USD").click(function (e) {
    $('#IDR').prop('checked', false);
});

$('#waktu_berangkat').change(function (e) {
    alert('a');
});

$('#kota_tujuan').change(function (e) {
    check_max_hotel();
});

$("#save_ppd").click(function (e) {
    e.preventDefault();
    var id_request = $('#id_request').val();
    var id_header = $('#id_header').val();
    var beban_pt = $('#beban_pt').val();
    // var required_date = $('#required_date').val();
    var employee_nik = $('#employee_nik').val()
    var nama_pejalan_dinas = $('#nama_pejalan_dinas').val();
    var email_pejalan_dinas = $('#employee_email').val();
    var cost_center = $('#cost_center').val();
    var range_grade = $('#range_grade').val();
    var employee_position = $('#employee_position').val();
    var employee_division = $('#employee_division').val()
    var lokasi_kantor = $('#lokasi_kantor').val();
    var personnel_subarea = $('#personnel_subarea').val();
    var kota_berangkat = $('#kota_berangkat').val();
    var tgl_berangkat = $('#tgl_berangkat').val();
    var waktu_berangkat = $('#waktu_berangkat').val();
    var kota_tujuan = $('#kota_tujuan').val();
    var tgl_kembali = $('#tgl_kembali').val();
    var waktu_kembali = $('#waktu_kembali').val();
    var x_diem = $('#x_diem').val();
    var nominal_diem = $('#nominal_diem').val();
    var total_diem = $('#total_diem').val();
    var x_hotel = $('#x_hotel').val();
    var nominal_hotel = $('#nominal_hotel').val();
    var total_hotel = $('#total_hotel').val();
    var x_transport = $('#x_transport').val();
    var nominal_transport = $('#nominal_transport').val();
    var total_transport = $('#total_transport').val();
    var x_lain_lain = $('#x_lain_lain').val();
    var nominal_lain_lain = $('#nominal_lain_lain').val();
    var total_lain_lain = $('#total_lain_lain').val();
    var total_uang_muka = $('#total_uang_muka').val();
    var norek = $('#norek').val();
    var paid_to = $('#paid_to').val();
    var atas_nama = $('#atas_nama').val();
    var tujuan_keperluan = $('#tujuan_keperluan').val();
    var total_hari = $('#total_hari').val();
    var specific_location = $('#specific_location').val();
    var kendaraan_dinas = $('#kendaraan_dinas').is(":checked") ? 'Y' : 'N';
    var kapal = $('#kapal').is(":checked") ? 'Y' : 'N';
    var pesawat = $('#pesawat').is(":checked") ? 'Y' : 'N';
    var kereta_api = $('#kereta_api').is(":checked") ? 'Y' : 'N';
    var kendaraan_pribadi = $('#kendaraan_pribadi').is(":checked") ? 'Y' : 'N';
    var travel = $('#travel').is(":checked") ? 'Y' : 'N';
    var kendaraan_umum = $('#kendaraan_umum').is(":checked") ? 'Y' : 'N';
    var currency = $('#luar_negeri').is(":checked") ? 'USD' : 'IDR';
    var luar_dalam_negeri = $('#luar_negeri').is(":checked") ? 'Luar Negeri' : 'Dalam Negeri';
    var tujuan_pelatihan = $('#tujuan_ppd_ya').is(":checked") ? 'YA' : 'TIDAK';

    var requestor_email = $('#requestor_email').val();
    var layer_1 = $('#layer_1').val();
    var layer_2 = $('#layer_2').val();
    var hr_layer_1 = $('#hr_layer_1').val();
    var hr_layer_2 = $('#hr_layer_2').val();

    var postData = {
        request_id:id_request,
        id_header:id_header,
        beban_pt:beban_pt,
        // required_date:required_date,
        employee_nik: employee_nik,
        nama_pejalan_dinas:nama_pejalan_dinas,
        email_pejalan_dinas:email_pejalan_dinas,
        cost_center: cost_center,
        range_grade: range_grade,
        employee_division: employee_division,
        employee_position: employee_position,
        lokasi_kantor: lokasi_kantor,
        personnel_subarea:personnel_subarea,
        luar_dalam_negeri:luar_dalam_negeri,
        kota_berangkat:kota_berangkat,
        kota_tujuan:kota_tujuan,
        tgl_berangkat:tgl_berangkat,
        tgl_kembali:tgl_kembali,
        waktu_berangkat:waktu_berangkat,
        waktu_kembali:waktu_kembali,
        total_hari:total_hari,
        x_diem:x_diem,
        nominal_diem:nominal_diem,
        total_diem:total_diem,
        x_hotel:x_hotel,
        nominal_hotel:nominal_hotel,
        total_hotel:total_hotel,
        x_transport:x_transport,
        nominal_transport:nominal_transport,
        total_transport:total_transport,
        x_lain_lain:x_lain_lain,
        nominal_lain_lain:nominal_lain_lain,
        total_lain_lain:total_lain_lain,
        total_uang_muka:total_uang_muka,
        norek:norek,
        paid_to:paid_to,
        atas_nama:atas_nama,
        tujuan_keperluan:tujuan_keperluan,
        currency:currency,
        tujuan_pelatihan:tujuan_pelatihan,
        specific_location:specific_location,
        pesawat:pesawat,
        kendaraan_dinas:kendaraan_dinas,
        kapal:kapal,
        kereta_api:kereta_api,
        kendaraan_pribadi:kendaraan_pribadi,
        travel:travel,
        kendaraan_umum:kendaraan_umum,
        requestor_email:requestor_email,
        layer_1:layer_1,
        layer_2:layer_2,
        hr_layer_1:hr_layer_1,
        hr_layer_2:hr_layer_2
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    $.ajax({
        url: "form/PPD/save/ppd_draft",
        type: 'post',
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
            $('#text-save-ppd').text('Please wait..');
        },
        success: function (response) {

            $('#text-save-ppd').text('Save');
            
            if (response.status == 1) {
                swalWithBootstrapButtons.fire('Saved!', 'Data form has been saved.', 'success')

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }

        },
        error: function (response) {
            $('#text-save-ppd').text('Save');
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Oops! there\'s something wrong. Please refresh the page and try again.',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
});

$("#submit_ppd").click(function (e) {
    e.preventDefault();

    if (validatePPD()) {

        var id_request = $('#id_request').val();
        var id_header = $('#id_header').val();
        var beban_pt = $('#beban_pt').val();
        // var required_date = $('#required_date').val();
        var nama_pejalan_dinas = $('#nama_pejalan_dinas').val();
        var cost_center = $('#cost_center').val();
        var email_pejalan_dinas = $('#employee_email').val();
        var lokasi_kantor = $('#lokasi_kantor').val();
        var employee_nik = $('#employee_nik').val()
        var employee_division = $('#employee_division').val()
        var employee_position = $('#employee_position').val();
        var kota_berangkat = $('#kota_berangkat').val();
        var tgl_berangkat = $('#tgl_berangkat').val();
        var waktu_berangkat = $('#waktu_berangkat').val();
        var kota_tujuan = $('#kota_tujuan').val();
        var tgl_kembali = $('#tgl_kembali').val();
        var waktu_kembali = $('#waktu_kembali').val();
        var x_diem = $('#x_diem').val();
        var nominal_diem = $('#nominal_diem').val();
        var total_diem = $('#total_diem').val();
        var x_hotel = $('#x_hotel').val();
        var nominal_hotel = $('#nominal_hotel').val();
        var total_hotel = $('#total_hotel').val();
        var x_transport = $('#x_transport').val();
        var nominal_transport = $('#nominal_transport').val();
        var total_transport = $('#total_transport').val();
        var x_lain_lain = $('#x_lain_lain').val();
        var nominal_lain_lain = $('#nominal_lain_lain').val();
        var total_lain_lain = $('#total_lain_lain').val();
        var total_uang_muka = $('#total_uang_muka').val();
        var norek = $('#norek').val();
        var paid_to = $('#paid_to').val();
        var atas_nama = $('#atas_nama').val();
        var tujuan_keperluan = $('#tujuan_keperluan').val();
        var total_hari = $('#total_hari').val();
        var specific_location = $('#specific_location').val();
        var kendaraan_dinas = $('#kendaraan_dinas').is(":checked") ? 'Y' : 'N';
        var kapal = $('#kapal').is(":checked") ? 'Y' : 'N';
        var pesawat = $('#pesawat').is(":checked") ? 'Y' : 'N';
        var kereta_api = $('#kereta_api').is(":checked") ? 'Y' : 'N';
        var kendaraan_pribadi = $('#kendaraan_pribadi').is(":checked") ? 'Y' : 'N';
        var travel = $('#travel').is(":checked") ? 'Y' : 'N';
        var kendaraan_umum = $('#kendaraan_umum').is(":checked") ? 'Y' : 'N';
        var currency = $('#luar_negeri').is(":checked") ? 'USD' : 'IDR';
        var luar_dalam_negeri = $('#luar_negeri').is(":checked") ? 'Luar Negeri' : 'Dalam Negeri';
        var tujuan_pelatihan = $('#tujuan_ppd_ya').is(":checked") ? 'YA' : 'TIDAK';
        var range_grade = $('#range_grade').val();
        var personnel_subarea = $('#personnel_subarea').val();
        var requestor_email = $('#requestor_email').val();
        var layer_1 = $('#layer_1').val();
        var layer_2 = $('#layer_2').val();
        var hr_layer_1 = $('#hr_layer_1').val();
        var hr_layer_2 = $('#hr_layer_2').val();

        var postData = {
            request_id:id_request,
            id_header:id_header,
            beban_pt:beban_pt,
            range_grade: range_grade,
            // required_date:required_date,
            lokasi_kantor: lokasi_kantor,
            cost_center: cost_center,
            email_pejalan_dinas:email_pejalan_dinas,
            employee_nik: employee_nik,
            employee_position: employee_position,
            employee_division: employee_division,
            nama_pejalan_dinas:nama_pejalan_dinas,
            luar_dalam_negeri:luar_dalam_negeri,
            kota_berangkat:kota_berangkat,
            tgl_berangkat:tgl_berangkat,
            waktu_berangkat:waktu_berangkat,
            kota_tujuan:kota_tujuan,
            tgl_kembali:tgl_kembali,
            waktu_kembali:waktu_kembali,
            total_hari:total_hari,
            x_diem:x_diem,
            nominal_diem:nominal_diem,
            total_diem:total_diem,
            x_hotel:x_hotel,
            nominal_hotel:nominal_hotel,
            total_hotel:total_hotel,
            x_transport:x_transport,
            nominal_transport:nominal_transport,
            total_transport:total_transport,
            x_lain_lain:x_lain_lain,
            nominal_lain_lain:nominal_lain_lain,
            total_lain_lain:total_lain_lain,
            total_uang_muka:total_uang_muka,
            norek:norek,
            paid_to:paid_to,
            atas_nama:atas_nama,
            tujuan_keperluan:tujuan_keperluan,
            currency:currency,
            tujuan_pelatihan:tujuan_pelatihan,
            specific_location:specific_location,
            pesawat:pesawat,
            kendaraan_dinas:kendaraan_dinas,
            kapal:kapal,
            kereta_api:kereta_api,
            kendaraan_pribadi:kendaraan_pribadi,
            travel:travel,
            kendaraan_umum:kendaraan_umum,
            requestor_email:requestor_email,
            layer_1:layer_1,
            layer_2:layer_2,
            hr_layer_1:hr_layer_1,
            hr_layer_2:hr_layer_2,
            personnel_subarea:personnel_subarea
        }

        const swalWithBootstrapButtons = Swal.mixin({customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false})
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "We will send an email notification to your first approval layer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, sure!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "form/PPD/save/submit_ppd",
                    type: 'post',
                    data: postData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#text-submit-ppd').text('Please wait..');
                    },
                    success: function (response) {
                        
                        $('#text-submit-ppd').text('Save');


                        if (response.status == 1) {
                            swalWithBootstrapButtons.fire('Nice!', 'Request has been submitted.', 'success')
                            window.location.href = 'form/detail/PPD/' + response.request_id;

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }

                    },
                    error: function (response) {
                        $('#text-submit-ppd').text('Save');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops! There\'s something wrong. Please refresh the page and try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
            }
        })

    } else {

        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'All field are required.',
            showConfirmButton: false,
            timer: 2000
        });

    }
    
});

function submitPPD (type) {

    var is_validate = validatePPD();

    if (is_validate === true) {

        var id_request = $('#id_request').val();
        var id_header = $('#id_header').val();
        var beban_pt = $('#beban_pt').val();
        // var required_date = $('#required_date').val();
        var nama_pejalan_dinas = $('#nama_pejalan_dinas').val();
        var cost_center = $('#cost_center').val();
        var email_pejalan_dinas = $('#employee_email').val();
        var lokasi_kantor = $('#lokasi_kantor').val();
        var employee_nik = $('#employee_nik').val()
        var employee_division = $('#employee_division').val()
        var employee_position = $('#employee_position').val();
        var kota_berangkat = $('#kota_berangkat').val();
        var tgl_berangkat = $('#tgl_berangkat').val();
        var waktu_berangkat = $('#waktu_berangkat').val();
        var kota_tujuan = $('#kota_tujuan').val();
        var tgl_kembali = $('#tgl_kembali').val();
        var waktu_kembali = $('#waktu_kembali').val();
        var x_diem = $('#x_diem').val();
        var nominal_diem = $('#nominal_diem').val();
        var total_diem = $('#total_diem').val();
        var x_hotel = $('#x_hotel').val();
        var nominal_hotel = $('#nominal_hotel').val();
        var total_hotel = $('#total_hotel').val();
        var x_transport = $('#x_transport').val();
        var nominal_transport = $('#nominal_transport').val();
        var total_transport = $('#total_transport').val();
        var x_lain_lain = $('#x_lain_lain').val();
        var nominal_lain_lain = $('#nominal_lain_lain').val();
        var total_lain_lain = $('#total_lain_lain').val();
        var total_uang_muka = $('#total_uang_muka').val();
        var norek = $('#norek').val();
        var paid_to = $('#paid_to').val();
        var atas_nama = $('#atas_nama').val();
        var tujuan_keperluan = $('#tujuan_keperluan').val();
        var total_hari = $('#total_hari').val();
        var specific_location = $('#specific_location').val();
        var kendaraan_dinas = $('#kendaraan_dinas').is(":checked") ? 'Y' : 'N';
        var kapal = $('#kapal').is(":checked") ? 'Y' : 'N';
        var pesawat = $('#pesawat').is(":checked") ? 'Y' : 'N';
        var kereta_api = $('#kereta_api').is(":checked") ? 'Y' : 'N';
        var kendaraan_pribadi = $('#kendaraan_pribadi').is(":checked") ? 'Y' : 'N';
        var travel = $('#travel').is(":checked") ? 'Y' : 'N';
        var kendaraan_umum = $('#kendaraan_umum').is(":checked") ? 'Y' : 'N';
        var currency = $('#luar_negeri').is(":checked") ? 'USD' : 'IDR';
        var luar_dalam_negeri = $('#luar_negeri').is(":checked") ? 'Luar Negeri' : 'Dalam Negeri';
        var tujuan_pelatihan = $('#tujuan_ppd_ya').is(":checked") ? 'YA' : 'TIDAK';
        var range_grade = $('#range_grade').val();
        var personnel_subarea = $('#personnel_subarea').val();
        var requestor_email = $('#requestor_email').val();
        var layer_1 = $('#layer_1').val();
        var layer_2 = $('#layer_2').val();
        var hr_layer_1 = $('#hr_layer_1').val();
        var hr_layer_2 = $('#hr_layer_2').val();

        var postData = {
            request_id:id_request,
            id_header:id_header,
            beban_pt:beban_pt,
            range_grade: range_grade,
            // required_date:required_date,
            lokasi_kantor: lokasi_kantor,
            cost_center: cost_center,
            email_pejalan_dinas:email_pejalan_dinas,
            employee_nik: employee_nik,
            employee_position: employee_position,
            employee_division: employee_division,
            nama_pejalan_dinas:nama_pejalan_dinas,
            luar_dalam_negeri:luar_dalam_negeri,
            kota_berangkat:kota_berangkat,
            tgl_berangkat:tgl_berangkat,
            waktu_berangkat:waktu_berangkat,
            kota_tujuan:kota_tujuan,
            tgl_kembali:tgl_kembali,
            waktu_kembali:waktu_kembali,
            total_hari:total_hari,
            x_diem:x_diem,
            nominal_diem:nominal_diem,
            total_diem:total_diem,
            x_hotel:x_hotel,
            nominal_hotel:nominal_hotel,
            total_hotel:total_hotel,
            x_transport:x_transport,
            nominal_transport:nominal_transport,
            total_transport:total_transport,
            x_lain_lain:x_lain_lain,
            nominal_lain_lain:nominal_lain_lain,
            total_lain_lain:total_lain_lain,
            total_uang_muka:total_uang_muka,
            norek:norek,
            paid_to:paid_to,
            atas_nama:atas_nama,
            tujuan_keperluan:tujuan_keperluan,
            currency:currency,
            tujuan_pelatihan:tujuan_pelatihan,
            specific_location:specific_location,
            pesawat:pesawat,
            kendaraan_dinas:kendaraan_dinas,
            kapal:kapal,
            kereta_api:kereta_api,
            kendaraan_pribadi:kendaraan_pribadi,
            travel:travel,
            kendaraan_umum:kendaraan_umum,
            requestor_email:requestor_email,
            layer_1:layer_1,
            layer_2:layer_2,
            hr_layer_1:hr_layer_1,
            hr_layer_2:hr_layer_2,
            personnel_subarea:personnel_subarea,
            type: type,
        }

        const swalWithBootstrapButtons = Swal.mixin({customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false})
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "We will send an email notification to your first approval layer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, sure!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "form/PPD/save/" + type,
                    type: 'post',
                    data: postData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#text-'+type).text('Please wait..');
                    },
                    success: function (response) {
                        
                        $('#text-'+type).text('Save');


                        if (response.status == 1) {
                            swalWithBootstrapButtons.fire('Nice!', 'Request has been submitted.', 'success')
                            window.location.href = 'form/detail/PPD/' + response.request_id;

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }

                    },
                    error: function (response) {
                        $('#text-'+type).text('Save');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops! There\'s something wrong. Please refresh the page and try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
            }
        })

    } 
};

$("#pullback_ppd").click(function (e) {
    e.preventDefault();

    var id_request = $('#id_request').val();
    var postData = {
            request_id:id_request,
        }

    const swalWithBootstrapButtons = Swal.mixin({customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false})
    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "We will cancel your request.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/PPD/save/pullback_ppd",
                type: 'post',
                data: postData,
                dataType: 'json',
                beforeSend: function () {
                    $('#text-pullback-ppd').text('Please wait..');
                },
                success: function (response) {
                    
                    $('#text-pullback-ppd').text('Pullback Request');

                    if (response.status == 1) {
                        swalWithBootstrapButtons.fire('Cancelled!', 'Request has been cancelled.', 'success')
                        window.location.href = 'form/detail/PPD/' + response.request_id;

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }

                },
                error: function (response) {
                    $('#text-pullback-ppd').text('Pullback Request');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops! There\'s something wrong. Please refresh the page and try again.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })
});


function validatePPD() {
    const swalWithBootstrapButtons = Swal.mixin({customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false})
    var created_by = $('#created_by').val();
    var id_request = $('#id_request').val();
    var id_header = $('#id_header').val();
    var nama_pejalan_dinas = $('#nama_pejalan_dinas').val();
    var cost_center = $('#cost_center').val();
    var email_pejalan_dinas = $('#employee_email').val();
    var lokasi_kantor = $('#lokasi_kantor').val();
    var employee_nik = $('#employee_nik').val()
    var employee_division = $('#employee_division').val()
    var employee_position = $('#employee_position').val();
    var kota_berangkat = $('#kota_berangkat').val();
    var kota_tujuan = $('#kota_tujuan').val();
    var tgl_berangkat = $('#tgl_berangkat').val();
    var tgl_kembali = $('#tgl_kembali').val();
    var waktu_berangkat = $('#waktu_berangkat').val();
    var waktu_kembali = $('#waktu_kembali').val();
    var x_diem = $('#x_diem').val();
    var nominal_diem = $('#nominal_diem').val();
    var total_diem = $('#total_diem').val();
    var x_hotel = $('#x_hotel').val();
    var nominal_hotel = $('#nominal_hotel').val();
    var total_hotel = $('#total_hotel').val();
    var x_transport = $('#x_transport').val();
    var nominal_transport = $('#nominal_transport').val();
    var total_transport = $('#total_transport').val();
    var x_lain_lain = $('#x_lain_lain').val();
    var nominal_lain_lain = $('#nominal_lain_lain').val();
    var total_lain_lain = $('#total_lain_lain').val();
    var total_uang_muka = $('#total_uang_muka').val();
    var norek = $('#norek').val();
    var paid_to = $('#paid_to').val();
    var atas_nama = $('#atas_nama').val();
    var tujuan_keperluan = $('#tujuan_keperluan').val();
    var total_hari = $('#total_hari').val();
    var specific_location = $('#specific_location').val();
    var kendaraan_dinas = $('#kendaraan_dinas').is(":checked") ? 'Y' : 'N';
    var kapal = $('#kapal').is(":checked") ? 'Y' : 'N';
    var pesawat = $('#pesawat').is(":checked") ? 'Y' : 'N';
    var kereta_api = $('#kereta_api').is(":checked") ? 'Y' : 'N';
    var kendaraan_pribadi = $('#kendaraan_pribadi').is(":checked") ? 'Y' : 'N';
    var travel = $('#travel').is(":checked") ? 'Y' : 'N';
    var kendaraan_umum = $('#kendaraan_umum').is(":checked") ? 'Y' : 'N';
    var currency = $('#luar_negeri').is(":checked") ? 'USD' : 'IDR';
    var luar_dalam_negeri = $('#luar_negeri').is(":checked") ? 'Luar Negeri' : 'Dalam Negeri';
    var tujuan_pelatihan = $('#tujuan_ppd_ya').is(":checked") ? 'YA' : 'TIDAK';
    var range_grade = $('#range_grade').val();
    var personnel_subarea = $('#personnel_subarea').val();
    var requestor_email = $('#employee_email').val();
    var layer_1 = $('#layer_1').val();
    var layer_2 = $('#layer_2').val();
    var hr_layer_1 = $('#hr_layer_1').val();
    var hr_layer_2 = $('#hr_layer_2').val();
    var is_validate = true;

    if (employee_nik === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'NIK tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        is_validate = false;
        return is_validate;
    }

    var count_nik = employee_nik.length;
    if (count_nik < 8) {
        Swal.fire({position: 'center',icon: 'warning',title: 'NIK harus 8 digit.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (nama_pejalan_dinas === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Nama Pejalan Dinas tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (email_pejalan_dinas === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Email Pejalan Dinas tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (lokasi_kantor === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Lokasi Kantor tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (employee_division === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Divisi tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (employee_position === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Posisi tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if(currency === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Mohon pilih Luar atau Dalam Negeri.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if ($('#luar_negeri').is(":checked") || $('#dalam_negeri').is(":checked")) {
    } else {
        Swal.fire({position: 'center', icon: 'warning', title: 'Mohon pilih Luar atau Dalam Negeri.', showConfirmButton: false, timer: 2000});
        return false;
    }
    
    if (kota_berangkat === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Kota keberangkatan tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (kota_tujuan === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Kota Tujuan tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (tgl_berangkat === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Tgl Berangkat tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (tgl_kembali === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Tgl Kembali tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (waktu_berangkat === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Waktu Berangkat tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (waktu_kembali === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Waktu Kembali tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if(specific_location === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Spesifik Lokasi tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if ($('#kendaraan_dinas').is(":checked") || $('#kapal').is(":checked") || $('#pesawat').is(":checked") || $('#kereta_api').is(":checked") || $('#kendaraan_pribadi').is(":checked") || $('#travel').is(":checked") || $('#kendaraan_umum').is(":checked")) {
    } else {
        Swal.fire({position: 'center', icon: 'warning', title: 'Mohon pilih alat transportasi.', showConfirmButton: false, timer: 2000});
        return false;
    }

    if(tujuan_keperluan === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Tujuan Keperluan tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if (x_diem === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Diem tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    if (nominal_diem === '') {
        Swal.fire({position: 'center',icon: 'warning',title: 'Nominal Diem tidak boleh kosong.',showConfirmButton: false,timer: 2000});
        return false;
    }

    // if (total_diem === '') {
    //     Swal.fire({position: 'center',icon: 'warning',title: 'Total Diem tidak boleh kosong.',showConfirmButton: false,timer: 2000});
    //     return false;
    // }

    // if (x_hotel === '') {
    //     Swal.fire({position: 'center',icon: 'warning',title: 'Jumlah hari Hotel tidak boleh kosong.',showConfirmButton: false,timer: 2000});
    //     return false;
    // }

    // if(nominal_hotel === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'nominal_hotel tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    // if(total_hotel === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'total_hotel tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    // if(x_transport === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'x_transport tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    // if(nominal_transport === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'nominal_transport tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    // if(total_transport === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'total_transport tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    // if(x_lain_lain === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'x_lain_lain tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    // if(nominal_lain_lain === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'nominal_lain_lain tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    // if(total_lain_lain === '') {
    //     Swal.fire({position: 'center', icon: 'warning', title: 'total_lain_lain tidak boleh kosong.', showConfirmButton: false, timer: 2000});
    //     return false;
    // } 

    if(total_uang_muka === '' || total_uang_muka === 0) {
        Swal.fire({position: 'center', icon: 'warning', title: 'Total Uang Muka tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if(norek === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Nomor Rekening tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if(paid_to === '') {
        Swal.fire({position: 'center', icon: 'warning', title: ' Nama Bank tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if(atas_nama === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Nama Bank Account tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if(total_hari === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Total Hari tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if(tujuan_pelatihan === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Tujuan Pelatihan tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if(range_grade === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Range Grade tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    if(personnel_subarea === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Area Lokasi tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    } 

    // Approval
    if(created_by !== requestor_email) {
        
        if(requestor_email === '') {
            Swal.fire({position: 'center', icon: 'warning', title: 'Periksa approval layer. Jika kosong, masukan kembali NIK Pejalan Dinas lalu tekan Enter.', showConfirmButton: false, timer: 5000});
            return false;
        }

        if(layer_1 === '') {
            Swal.fire({position: 'center', icon: 'warning', title: 'Periksa approval layer. Jika kosong, masukan kembali NIK Pejalan Dinas lalu tekan Enter.', showConfirmButton: false, timer: 5000});
            // Swal.fire({position: 'center', icon: 'warning', title: 'Layer 1 tidak boleh kosong.', showConfirmButton: false, timer: 2000});
            return false;
        }

    } else {

        if(layer_1 === '') {
            Swal.fire({position: 'center', icon: 'warning', title: 'Periksa approval layer. Jika kosong, masukan kembali NIK Pejalan Dinas lalu tekan Enter.', showConfirmButton: false, timer: 5000});
            // Swal.fire({position: 'center', icon: 'warning', title: 'Layer 1 tidak boleh kosong.', showConfirmButton: false, timer: 2000});
            return false;
        }

        if(layer_2 === '') {
            Swal.fire({position: 'center', icon: 'warning', title: 'Periksa approval layer. Jika kosong, masukan kembali NIK Pejalan Dinas lalu tekan Enter.', showConfirmButton: false, timer: 5000});

            // Swal.fire({position: 'center', icon: 'warning', title: 'Layer 2 tidak boleh kosong.', showConfirmButton: false, timer: 2000});
            return false;
        }

    }

    if (range_grade === 'A' || range_grade === 'B-C-D-E' || range_grade === 'F-G') {

        if(hr_layer_2 === '') {
            Swal.fire({position: 'center', icon: 'warning', title: 'Periksa approval layer. Jika kosong, masukan kembali NIK Pejalan Dinas lalu tekan Enter.', showConfirmButton: false, timer: 5000});

            // Swal.fire({position: 'center', icon: 'warning', title: 'HR Layer 2 tidak boleh kosong.', showConfirmButton: false, timer: 2000});
            return false;
        }

    } 

    if (hr_layer_1 === '') {
        Swal.fire({position: 'center', icon: 'warning', title: 'Periksa approval layer. Jika kosong, masukan kembali NIK Pejalan Dinas lalu tekan Enter.', showConfirmButton: false, timer: 5000});

        // Swal.fire({position: 'center', icon: 'warning', title: 'HR Layer 1 tidak boleh kosong.', showConfirmButton: false, timer: 2000});
        return false;
    }  

    return true;   
}

function responseTravel(response)
{
    var id = $('#request_id').val();
    var text_resp = '';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    if (response == 'Revised_Prev') {
        text_resp = 'Revise to previous layer';
    } else if (response == 'Revised') {
        text_resp = 'Revise this request';
    } else if (response == 'Approved') {
        text_resp = 'Approve this request';
    }

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: text_resp,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure.',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/PPD/response/",
                type: 'post',
                data: 'id=' + id + '&response=' + response,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {
                        swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success')

                        window.location.href = 'form/detail_approval/PPD/' + response.id;

                    } else {
                        swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please refresh this page and try again.', 'error')
                    }
                    
                },
                error: function (response) {
                    alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled','Action has been cancelled.','success')
        }
    })
}

/////////////////////////////// LPD
$('#lpd_employee_nik').keydown(function (e){
    // e.preventDefault(); 
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    if(e.keyCode == 13){
        var employee_nik = $('#lpd_employee_nik').val();

        var count_nik = employee_nik.length;
        if (count_nik < 8) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Mohon masukan 8 digit NIK.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        $.ajax({
            url: "form/PPD/getDetailEmployee",
            type: 'post',
            data: 'employee_nik=' + employee_nik,
            dataType: 'json',
            success: function (response) {

                if (response.status) {

                    $('#employee_email').val(response.email);
                    $('#cost_center').val(response.cost_center);
                    $('#employee_division').val(response.division);
                    $('#employee_position').val(response.position);
                    $('#nama_pejalan_dinas').val(response.name);

                    if (response.detail.created_by === response.detail.email_pejalan_dinas) {
                        $('#requestor_email').val(response.layer_1);
                        // $('#layer_1').val(response.layer_2);
                    } else {
                        $('#requestor_email').val(response.layer_1);
                        $('#layer_1').val(response.layer_2);
                    }

                } else {
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    $('#employee_division').val('');
                    $('#employee_position').val('');
                    $('#cost_center').val('');
                    $('#jarak_mobil_kantor').val('');
                    $('#nama_pejalan_dinas').val('');
                    $('#employee_email').val('');
                    $('#kota_berangkat').val('');
                    $('#kota_tujuan').val('');
                    $('#lpd_tgl_berangkat').val('');
                    $('#lpd_tgl_kembali').val('');
                    $('#waktu_berangkat').val('');
                    $('#waktu_kembali').val('');

                    $('#requestor_email').val('');
                    $('#layer_1').val('');

                }

            },
            error: function (response) {
                console.log(response);
            }
        });
    }

});

$('#idr').click(function() {
    if ($('#idr').is(":checked")) {
        $('#usd').prop('checked', false);
    }
});

$('#usd').click(function() {
    if ($('#usd').is(":checked")) {
        $('#idr').prop('checked', false);
    }
});

$('#update_idr').click(function() {
    if ($('#update_idr').is(":checked")) {
        $('#update_usd').prop('checked', false);
    }
});

$('#update_usd').click(function() {
    if ($('#update_usd').is(":checked")) {
        $('#update_idr').prop('checked', false);
    }
});

function calculate_lpd_item(){
    var transport = (document.getElementById("modal_transport").value != '') ? parseFloat(document.getElementById("modal_transport").value) : 0;
    var hotel = (document.getElementById("modal_hotel").value != '') ? parseFloat(document.getElementById("modal_hotel").value) : 0;
    var diem = (document.getElementById("modal_perdiem").value != '') ? parseFloat(document.getElementById("modal_perdiem").value) : 0;
    var others = (document.getElementById("modal_others").value != '') ? parseFloat(document.getElementById("modal_others").value) : 0;
    var total = parseFloat(transport + hotel + diem + others);

    var update_transport = (document.getElementById("update_modal_transport").value != '') ? parseFloat(document.getElementById("update_modal_transport").value) : 0;
    var update_hotel = (document.getElementById("update_modal_hotel").value != '') ? parseFloat(document.getElementById("update_modal_hotel").value) : 0;
    var update_diem = (document.getElementById("update_modal_perdiem").value != '') ? parseFloat(document.getElementById("update_modal_perdiem").value) : 0;
    var update_others = (document.getElementById("update_modal_others").value != '') ? parseFloat(document.getElementById("update_modal_others").value) : 0;
    var update_total = parseFloat(update_transport + update_hotel + update_diem + update_others);

    $('#modal_subtotal').val(rupiah(total));
    $('#modal_subtotal_hidden').val(total);
    $('#update_modal_subtotal').val(rupiah(update_total));
    $('#update_modal_subtotal_hidden').val(update_total);
}

$("#btn_check_ppd").click(function (e) {
    var ppd_reqnum = $('#ppd_request_number').val();
    var total_uang_muka = $('#grand_total').val();

    if (ppd_reqnum == '') {
        alert('Please input PPD Request Number');
        return false;
    }

    $.ajax({
        method: 'post',
        url: 'form/PPD/check_ppd/'+ ppd_reqnum,
        dataType: 'json',
        beforeSend: function () {
            console.log(total_uang_muka);
            $('#text-check').text('Please wait..');
        },
        success: function (response) {

            $('#text-check').text('Check');

            if (response.status == 1) {

                 $('#ppd_check_text').text('');

                 $('#lpd_employee_nik').val(response.detail.requestor_nik);
                 $('#employee_division').val(response.detail.divisi);
                 $('#employee_position').val(response.detail.posisi);
                 $('#cost_center').val(response.detail.cost_center);
                 $('#jarak_mobil_kantor').val(response.detail.jarak_mobil_kantor);
                 $('#nama_pejalan_dinas').val(response.detail.nama_pejalan_dinas);
                 $('#employee_email').val(response.detail.email_pejalan_dinas);
                 $('#kota_berangkat').val(response.detail.kota_berangkat);
                 $('#kota_tujuan').val(response.detail.kota_tujuan);
                 
                 var tgl_berangkat = response.detail.tgl_berangkat;
                 var tgl_kembali = response.detail.tgl_kembali;
                 var waktu_berangkat = response.detail.waktu_berangkat;
                 var waktu_kembali = response.detail.waktu_kembali;
                 $('#lpd_tgl_berangkat').val(tgl_berangkat.replace('00:00:00.000', ''));
                 $('#lpd_tgl_kembali').val(tgl_kembali.replace('00:00:00.000', ''));
                 $('#waktu_berangkat').val(waktu_berangkat.replace(':00.0000000', ''));
                 $('#waktu_kembali').val(waktu_kembali.replace(':00.0000000', ''));

                 $('#nominal_ppd').val(response.header.claim_total);
                 $('#nominal_ppd_tb').val(rupiah(response.header.claim_total));

                 if (total_uang_muka !== '') {
                    var sisa_lebih = parseFloat(total_uang_muka - response.header.claim_total);
                    $('#sisa_lebih').val(sisa_lebih);
                    $('#sisa_lebih_tb').val(rupiah(sisa_lebih));
                 }

                if (response.detail.created_by === response.detail.email_pejalan_dinas) {
                    $('#requestor_email').val(response.layer_1);
                    // $('#layer_1').val(response.layer_2);
                } else {
                    $('#requestor_email').val(response.layer_1);
                    $('#layer_1').val(response.layer_2);
                }

            } else {

                 $('#ppd_check_text').text(response.message);
                 $('#lpd_employee_nik').val('');
                 $('#employee_division').val('');
                 $('#employee_position').val('');
                 $('#cost_center').val('');
                 $('#jarak_mobil_kantor').val('');
                 $('#nama_pejalan_dinas').val('');
                 $('#employee_email').val('');
                 $('#kota_berangkat').val('');
                 $('#kota_tujuan').val('');
              
                 $('#lpd_tgl_berangkat').val('');
                 $('#lpd_tgl_kembali').val('');
                 $('#waktu_berangkat').val('');
                 $('#waktu_kembali').val('');

                 $('#nominal_ppd').val('');
                 $('#nominal_ppd_tb').val('');
                 $('#sisa_lebih').val('');
                 $('#sisa_lebih_tb').val('');
                 $('#requestor_email').val('');
                 $('#layer_1').val('');
            }
        }
    });

});

function update_lpd_item(id) {
    var postData = {detail_id: id}

    $.ajax({
        url: "form/LPD/get/lpd_item",
        type: 'post',
        data: postData,
        dataType: 'json',
        success: function (response) {

            if (response.status == 1) {

                $('#id_detail_update').val(id);
                if (response.detail[0].currency === "IDR") {
                    $('#update_idr').prop('checked', true);
                    $('#update_usd').prop('checked', false);
                } else {
                    $('#update_idr').prop('checked', false);
                    $('#update_usd').prop('checked', true);
                }
                $('#update_modal_date').val(response.detail[0].date_travel);
                $('#update_modal_remarks').val(response.detail[0].remarks);
                $('#update_modal_transport').val(response.detail[0].transport);
                $('#update_modal_hotel').val(response.detail[0].hotel);
                $('#update_modal_perdiem').val(response.detail[0].diem);
                $('#update_modal_others').val(response.detail[0].others);
                $('#update_modal_subtotal').val(rupiah(response.detail[0].subtotal));
            
                $('#modalUpdateLPD').modal('toggle');

            } else {
                swalWithBootstrapButtons.fire('error', response.messages, 'error')
            }
        },
        error: function (response) {
            alert('Oops! There\'s something wrong. Please refresh this page and try again.');
        }
    });
}

$("#update_lpd_item").click(function (e) {
    e.preventDefault();

    var id = $('#id_request').val();
    var id_header = $('#id_header').val();
    var id_detail = $('#id_detail_update').val();

    var date = document.getElementById("update_modal_date").value;
    var remarks = document.getElementById("update_modal_remarks").value;
    var transport = parseFloat(document.getElementById("update_modal_transport").value);
    var hotel = parseFloat(document.getElementById("update_modal_hotel").value);
    var perdiem = parseFloat(document.getElementById("update_modal_perdiem").value);
    var others = parseFloat(document.getElementById("update_modal_others").value);
    var subtotal = parseFloat(document.getElementById("update_modal_subtotal_hidden").value);
    var currency = '';

    var prev_total_transport = parseFloat(document.getElementById("total_transport").value);
    var prev_total_hotel = parseFloat(document.getElementById("total_hotel").value);
    var prev_total_perdiem = parseFloat(document.getElementById("total_perdiem").value);
    var prev_total_others = parseFloat(document.getElementById("total_others").value);
    var prev_grand_total = parseFloat(document.getElementById("grand_total").value);

    if ($('#update_idr').is(":checked")) {
        currency = 'IDR';
    } else if ($('#update_usd').is(":checked")) {
        currency = 'USD';
    }

    if ((date.length == '') 
        || (remarks.length == '') 
        || (subtotal.length == '0') 
        ) {

        alert('Date & Remarks are required. Total must be greater than 0.');
        return false;

    } else {

        var postData = {
            request_id: id,
            header_id: id_header,
            detail_id: id_detail,
            date: date,
            remarks: remarks,
            currency: currency,
            transport: transport,
            hotel: hotel,
            perdiem: perdiem,
            others: others,
            subtotal: subtotal,
            prev_total_transport:prev_total_transport,
            prev_total_hotel:prev_total_hotel,
            prev_total_perdiem:prev_total_perdiem,
            prev_total_others:prev_total_others,
            prev_grand_total:prev_grand_total
        }

        $.ajax({
            method: 'post',
            url: 'form/LPD/save/update_lpd_item',
            data: postData,
            dataType: 'json',
            beforeSend: function () {
                $('#text-save-update-lpd').text('Please wait..');
            },
            success: function (response) {

                $('#text-save-update-lpd').text('Save');

                if (response.status == 1) {

                    $('#update_idr').prop('checked', false);
                    $('#update_usd').prop('checked', false);
                    document.getElementById("update_modal_date").value = "";
                    document.getElementById("update_modal_remarks").value = "";
                    document.getElementById("update_modal_transport").value = "";
                    document.getElementById("update_modal_hotel").value = ""; 
                    document.getElementById("update_modal_perdiem").value = "";
                    document.getElementById("update_modal_others").value = "";
                    document.getElementById("update_modal_subtotal").value = "";

                    $('#table_lpd_detail').DataTable().ajax.reload();
                    $('#total_transport').val(response.data.total_transport);
                    $('#total_hotel').val(response.data.total_hotel);
                    $('#total_perdiem').val(response.data.total_perdiem);
                    $('#total_others').val(response.data.total_others);
                    $('#grand_total').val(response.data.claim_total);

                } else {
                   alert(response.messages);
                }
            }
        });
    }

});

function modal_add_lpd() {
    var nik = $('#lpd_employee_nik').val();
    var count_nik = nik.length;

    if (nik == '') {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Mohon masukan NIK terlebih dahulu.',
            showConfirmButton: false,
            timer: 2000
        });
        return false;
    }

    if (count_nik < 8) {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'NIK harus 8 digit.',
            showConfirmButton: false,
            timer: 2000
        });
        return false;
    }

    $('#modalAddLPD').modal('toggle');
    
};

function check_max_diem_lpd()
{
    var employee_nik = $('#lpd_employee_nik').val();
    var input_nom_diem = parseInt($('#modal_perdiem').val());

    $.ajax({
        url: "form/PPD/getDetailEmployee",
        type: 'post',
        data: 'employee_nik=' + employee_nik,
        dataType: 'json',
        success: function (response) {

            if (response.status) {

                var max_diem = parseInt(response.nom_diem);

                if (input_nom_diem > max_diem) {
                    $('#text_max_diem_lpd').text("Maksimum: " + rupiah(response.nom_diem));
                } else {
                    $('#text_max_diem_lpd').text("");
                    return false;
                }

            } else {
                alert("Something went wrong. Please refresh the page and try again.");
            }
        },
        error: function (response) {
            alert("Something went wrong. Please refresh the page and try again.");
            console.log(response);
        }
    });
}

function check_max_hotel_lpd()
{
    var employee_nik = $('#lpd_employee_nik').val();
    var input_nom_hotel = parseInt($('#modal_hotel').val());

    $.ajax({
        url: "form/PPD/getDetailEmployee",
        type: 'post',
        data: 'employee_nik=' + employee_nik,
        dataType: 'json',
        success: function (response) {

            if (response.status) {

                var max_hotel = parseInt(response.nom_hotel);

                if (input_nom_hotel > max_hotel) {
                    $('#text_max_hotel_lpd').text("Maksimum: " + rupiah(response.nom_hotel));
                } else {
                    $('#text_max_hotel_lpd').text("");
                    return false;
                }

            } else {
                alert("Something went wrong. Please refresh the page and try again.");
            }
        },
        error: function (response) {
            alert("Something went wrong. Please refresh the page and try again.");
            console.log(response);
        }
    });
}

$("#add_lpd_item").click(function (e) {
    e.preventDefault();

    var id = $('#id_request').val();
    var id_header = $('#id_header').val();
    var nik = $('#lpd_employee_nik').val();

    var date = document.getElementById("modal_date").value;
    var remarks = document.getElementById("modal_remarks").value;
    var transport = parseFloat(document.getElementById("modal_transport").value);
    var hotel = parseFloat(document.getElementById("modal_hotel").value);
    var perdiem = parseFloat(document.getElementById("modal_perdiem").value);
    var others = parseFloat(document.getElementById("modal_others").value);
    var subtotal = parseFloat(document.getElementById("modal_subtotal_hidden").value);
    var currency = '';

    var prev_total_transport = parseFloat(document.getElementById("total_transport").value);
    var prev_total_hotel = parseFloat(document.getElementById("total_hotel").value);
    var prev_total_perdiem = parseFloat(document.getElementById("total_perdiem").value);
    var prev_total_others = parseFloat(document.getElementById("total_others").value);
    var prev_grand_total = parseFloat(document.getElementById("grand_total").value);

    var total_transport = parseFloat(transport + prev_total_transport);
    var total_hotel = parseFloat(hotel + prev_total_hotel);
    var total_perdiem = parseFloat(perdiem + prev_total_perdiem);
    var total_others = parseFloat(others + prev_total_others);
    var grand_total = + parseFloat(subtotal + prev_grand_total);

    var nominal_ppd = parseFloat(document.getElementById("nominal_ppd").value);
    var sisa_lebih = parseFloat(grand_total - nominal_ppd);

    if ($('#idr').is(":checked")) {
        currency = 'IDR';
    } else if ($('#usd').is(":checked")) {
        currency = 'USD';
    }

    if ((date.length == '') 
        || (remarks.length == '') 
        || (subtotal.length == '0') 
        ) {

        alert('Date & Remarks are required. Total must be greater than 0.');
        return false;

    } else {

        var postData = {
            request_id: id,
            header_id: id_header,
            nik: nik,
            date: date,
            remarks: remarks,
            currency: currency,
            transport: transport,
            hotel: hotel,
            perdiem: perdiem,
            others: others,
            subtotal: subtotal,
            total_transport:total_transport,
            total_hotel:total_hotel,
            total_perdiem:total_perdiem,
            total_others:total_others,
            grand_total:grand_total
        }

        console.log(postData);

        $.ajax({
            method: 'post',
            url: 'form/LPD/save/add_lpd_item',
            data: postData,
            dataType: 'json',
            beforeSend: function () {
                $('#text-save-lpd').text('Please wait..');
            },
            success: function (response) {

                $('#text-save-lpd').text('Save');

                if (response.status == 1) {

                    $('#idr').prop('checked', false);
                    $('#usd').prop('checked', false);
                    document.getElementById("modal_date").value = "";
                    document.getElementById("modal_remarks").value = "";
                    document.getElementById("modal_transport").value = "";
                    document.getElementById("modal_hotel").value = ""; 
                    document.getElementById("modal_perdiem").value = "";
                    document.getElementById("modal_others").value = "";
                    document.getElementById("modal_subtotal").value = "";

                    $('#table_lpd_detail').DataTable().ajax.reload();
                    $('#total_transport').val(total_transport);
                    $('#total_hotel').val(total_hotel);
                    $('#total_perdiem').val(total_perdiem);
                    $('#total_others').val(total_others);
                    $('#grand_total').val(grand_total);
                    $('#sisa_lebih').val(sisa_lebih);

                    $('#total_transport_tb').val(rupiah(total_transport));
                    $('#total_hotel_tb').val(rupiah(total_hotel));
                    $('#total_perdiem_tb').val(rupiah(total_perdiem));
                    $('#total_others_tb').val(rupiah(total_others));
                    $('#grand_total_tb').val(rupiah(grand_total));
                    $('#sisa_lebih_tb').val(rupiah(sisa_lebih));

                } else {
                   alert(response.messages);
                }
            }
        });
    }

});

function delete_lpd_item(id) {
    var header_id = $('#id_header').val();

    var nominal_ppd = $('#nominal_ppd').val();
    var total_transport = $('#total_transport').val();
    var total_diem = $('#total_perdiem').val();
    var total_hotel = $('#total_hotel').val();
    var total_others = $('#total_others').val();
    var grand_total = $('#grand_total').val();
    var postData = {
        header_id: header_id, 
        detail_id: id, 
        total_transport:total_transport,
        total_diem:total_diem,
        total_hotel:total_hotel,
        total_others:total_others,
        grand_total:grand_total
    }

    console.log(postData);

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete.',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/LPD/delete/lpd_item",
                type: 'post',
                data: postData,
                dataType: 'json',
                success: function (response) {

                    if (response.status === 1) {

                        $('#table_lpd_detail').DataTable().ajax.reload();

                        $('#total_transport_tb').val(rupiah(response.data.total_transport));
                        $('#total_hotel_tb').val(rupiah(response.data.total_hotel));
                        $('#total_perdiem_tb').val(rupiah(response.data.total_perdiem));
                        $('#total_others_tb').val(rupiah(response.data.total_others));
                        $('#grand_total_tb').val(rupiah(response.data.claim_total));

                        $('#total_transport').val(response.data.total_transport);
                        $('#total_hotel').val(response.data.total_hotel);
                        $('#total_perdiem').val(response.data.total_perdiem);
                        $('#total_others').val(response.data.total_others);
                        $('#grand_total').val(response.data.claim_total);

                        var sisa_lebih = parseFloat(response.data.claim_total - nominal_ppd);
                        $('#sisa_lebih').val(sisa_lebih);
                        $('#sisa_lebih_rb').val(rupiah(sisa_lebih));


                        swalWithBootstrapButtons.fire('Item has been deleted.', 'Deleted successfully', 'success')
                    } else {
                        swalWithBootstrapButtons.fire('error', 'Something went wrong.', 'error')
                    }
                },
                error: function (response) {
                    alert('Oops! There\'s something wrong. Please refresh this page and try again.');
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })
}

$("#save_lpd").click(function (e) {
    e.preventDefault();
    var id_request = $('#id_request').val();
    var id_header = $('#id_header').val();
    var employee_nik = $('#lpd_employee_nik').val()
    var nama_pejalan_dinas = $('#nama_pejalan_dinas').val();
    var email_pejalan_dinas = $('#employee_email').val();
    var employee_position = $('#employee_position').val();
    var employee_division = $('#employee_division').val()
    var kota_berangkat = $('#kota_berangkat').val();
    var kota_tujuan = $('#kota_tujuan').val();
    var tgl_berangkat = $('#lpd_tgl_berangkat').val();
    var tgl_kembali = $('#lpd_tgl_kembali').val();
    var waktu_berangkat = $('#waktu_berangkat').val();
    var waktu_kembali = $('#waktu_kembali').val();
    var cost_center = $('#cost_center').val();
    var jarak_mobil_kantor = $('#jarak_mobil_kantor').val();
    var ppd_request_number = $('#ppd_request_number').val();
    var total_perdiem = $('#total_perdiem').val();
    var total_hotel = $('#total_hotel').val();
    var total_transport = $('#total_transport').val();
    var total_others = $('#total_others').val();
    var claim_total = $('#claim_total').val();
    var nominal_ppd = $('#nominal_ppd').val();
    var sisa_lebih = $('#sisa_lebih').val();
    var sisa_lebih_sudah_dibayar = $('#sisa_lebih_sudah_dibayar_ya').is(":checked") ? 'Y' : 'N';
    var requestor_email = $('#requestor_email').val();
    var layer_1 = $('#layer_1').val();
    var hr_layer_1 = $('#hr_layer_1').val();
    var hr_layer_2 = $('#hr_layer_2').val();

    var postData = {
        request_id:id_request,
        id_header:id_header,
        employee_nik: employee_nik,
        nama_pejalan_dinas:nama_pejalan_dinas,
        email_pejalan_dinas:email_pejalan_dinas,
        employee_division: employee_division,
        employee_position: employee_position,
        kota_berangkat:kota_berangkat,
        kota_tujuan:kota_tujuan,
        tgl_berangkat:tgl_berangkat,
        tgl_kembali:tgl_kembali,
        waktu_berangkat:waktu_berangkat,
        waktu_kembali:waktu_kembali,
        cost_center: cost_center,
        jarak_mobil_kantor: jarak_mobil_kantor,
        ppd_request_number:ppd_request_number,
        total_perdiem:total_perdiem,
        total_hotel:total_hotel,
        total_transport:total_transport,
        total_others:total_others,
        claim_total:claim_total,
        nominal_ppd:nominal_ppd,
        sisa_lebih:sisa_lebih,
        sisa_lebih_sudah_dibayar:sisa_lebih_sudah_dibayar,
        requestor_email:requestor_email,
        layer_1:layer_1,
        hr_layer_1: hr_layer_1,
        hr_layer_2: hr_layer_2,
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    $.ajax({
        url: "form/LPD/save/lpd_draft",
        type: 'post',
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
            $('#text-save-lpd').text('Please wait..');
        },
        success: function (response) {

            $('#text-save-lpd').text('Save');
            
            if (response.status == 1) {
                swalWithBootstrapButtons.fire('Saved!', 'Data form has been saved.', 'success')

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }

        },
        error: function (response) {
            $('#text-save-lpd').text('Save');
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Oops! there\'s something wrong. Please refresh the page and try again.',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
});



$("#submit_lpd").click(function (e) {
    e.preventDefault();
    var id_request = $('#id_request').val();
    var id_header = $('#id_header').val();
    var employee_nik = $('#lpd_employee_nik').val()
    var nama_pejalan_dinas = $('#nama_pejalan_dinas').val();
    var email_pejalan_dinas = $('#employee_email').val();
    var employee_position = $('#employee_position').val();
    var employee_division = $('#employee_division').val()
    var kota_berangkat = $('#kota_berangkat').val();
    var kota_tujuan = $('#kota_tujuan').val();
    var tgl_berangkat = $('#tgl_berangkat').val();
    var tgl_kembali = $('#tgl_kembali').val();
    var waktu_berangkat = $('#waktu_berangkat').val();
    var waktu_kembali = $('#waktu_kembali').val();
    var cost_center = $('#cost_center').val();
    var jarak_mobil_kantor = $('#jarak_mobil_kantor').val();
    var ppd_request_number = $('#ppd_request_number').val();
    var total_perdiem = $('#total_perdiem').val();
    var total_hotel = $('#total_hotel').val();
    var total_transport = $('#total_transport').val();
    var total_others = $('#total_others').val();
    var claim_total = $('#claim_total').val();
    var total_ppd = $('#total_ppd').val();
    var sisa_lebih = $('#sisa_lebih').val();
    var sisa_lebih_sudah_dibayar = $('#sisa_lebih_sudah_dibayar').is(":checked") ? 'Y' : 'N';
    var requestor_email = $('#requestor_email').val();
    var layer_1 = $('#layer_1').val();
    var hr_layer_1 = $('#hr_layer_1').val();
    var hr_layer_2 = $('#hr_layer_2').val();

    var postData = {
        request_id:id_request,
        id_header:id_header,
        employee_nik: employee_nik,
        nama_pejalan_dinas:nama_pejalan_dinas,
        email_pejalan_dinas:email_pejalan_dinas,
        employee_division: employee_division,
        employee_position: employee_position,
        kota_berangkat:kota_berangkat,
        kota_tujuan:kota_tujuan,
        tgl_berangkat:tgl_berangkat,
        tgl_kembali:tgl_kembali,
        waktu_berangkat:waktu_berangkat,
        waktu_kembali:waktu_kembali,
        cost_center: cost_center,
        jarak_mobil_kantor: jarak_mobil_kantor,
        ppd_request_number:ppd_request_number,
        total_perdiem:total_perdiem,
        total_hotel:total_hotel,
        total_transport:total_transport,
        total_others:total_others,
        claim_total:claim_total,
        total_ppd:total_ppd,
        sisa_lebih:sisa_lebih,
        sisa_lebih_sudah_dibayar:sisa_lebih_sudah_dibayar,
        requestor_email:requestor_email,
        layer_1:layer_1,
        hr_layer_1: hr_layer_1,
        hr_layer_2: hr_layer_2,
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-light'}, buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "We will send an email notification to your first approval layer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "form/LPD/save/submit_lpd",
                type: 'post',
                data: postData,
                dataType: 'json',
                beforeSend: function () {
                    $('#text-submit-lpd').text('Please wait..');
                },
                success: function (response) {
                    
                    $('#text-submit-lpd').text('Save');


                    if (response.status == 1) {
                        swalWithBootstrapButtons.fire('Nice!', 'Request has been submitted.', 'success')
                        window.location.href = 'form/detail/LPD/' + response.request_id;

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops! Sorry, there\'s something wrong. Please refresh the page and try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }

                },
                error: function (response) {
                    $('#text-submit-lpd').text('Save');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops! There\'s something wrong. Please refresh the page and try again.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })
    
});

