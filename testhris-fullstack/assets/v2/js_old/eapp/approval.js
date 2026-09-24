// List
function search_request() {
    let input = document.getElementById('search_request').value
    input = input.toLowerCase();
    let x = document.getElementsByClassName('chat-item');

    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display = "none";
        } else {
            x[i].style.display = "list-item";
        }
    }
}

// Add Layer
$(document).ready(function (e) {
    $("#form-add-layer").on('submit', function (e) {
        e.preventDefault();
        var id = $('#request_id').val();

        $.ajax({
            type: 'POST',
            url: 'list/request/update/save-add-layer',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#text-add-layer').html('Please wait...');
            },
            success: function (response) {

                if (response.status == 1) {

                    if (response.request_status == 1) { 
                        $("#status_list-" + id).html('<span class="text-primary"> Waiting Approval</span>');
                        $("#status_read-" + id).html('<em class="icon ni ni-bullet-fill" id="is_read-' + id + '" style="display: show;"></em>');

                    } else if (response.request_status == 3) {
                        $("#status_list-" + id).html('<span class="text-gray"> Approved</span>');
                        $("#status_read-" + id).html('<em class="icon ni ni-check-circle-fill" id="is_read-' + id + '" style="display: show;"></em>');
                    }
                    
                    $('#text-add-layer').html('Save');
                    $('#modal-add-layer').modal('toggle');

                    viewRequest(id);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'New layer has been added.',
                        showConfirmButton: false,
                        timer: 1000
                    });

                } else {

                    $('#text-add-layer').html('Save');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops! Sorry, there\'s something wrong. Please try again.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    });
});

$("#add-layer").click(function (e) {
    e.preventDefault();
    var id = $('#request_id').val();

    $.ajax({
        type: 'post',
        url: "list/request/update/add-layer",
        data: 'id=' + id,
        dataType: 'json',
        beforeSend: function () {
        },
        success: function (response) {

            if (response) {
                
                $('#req_id_add_layer').val(response.id);
                $('#modal-add-layer').modal('toggle');
                $('#select_add_layer').val('').trigger('change');

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops! Sorry, there\'s something wrong. Please try again.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    });

});

// Change Layer
$(document).ready(function (e) {
    $("#form-change-layer").on('submit', function (e) {
        e.preventDefault();
        var id = $('#request_id').val();

        $.ajax({
            type: 'POST',
            url: 'list/request/update/save-change-layer',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#text-change-layer').html('Please wait...');
            },
            success: function (response) {

                if (response.status == 1) {

                    $('#text-change-layer').html('Save');
                    $('#modal-change-layer').modal('toggle');
                    viewRequest(id);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Layer has been changed.',
                        showConfirmButton: false,
                        timer: 1000
                    });

                } else {

                    $('#text-change-layer').html('Save');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops! Sorry, there\'s something wrong. Please try again.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    });
});

function change_layer(approval_id) {
    var id = $('#request_id').val();

    $('#req_id_change_layer').val(id);
    $('#app_id_change_layer').val(approval_id);
    $('#modal-change-layer').modal('toggle');
    $('#select_change_layer').val('').trigger('change');
}

// Delete Layer
function delete_layer(approval_id) {
    var id = $('#request_id').val();

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove!',
        cancelButtonText: 'Emm, nope.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "list/request/update/remove-layer",
                type: 'post',
                data: 'id=' + id + '&approval_id=' + approval_id,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {

                        if (response.request_status == 1) {
                            $("#status_list-" + id).html('<span class="text-primary"> Waiting Approval</span>');
                            $("#status_read-" + id).html('<em class="icon ni ni-bullet-fill" id="is_read-' + id + '" style="display: show;"></em>');

                        } else if (response.request_status == 3) {
                            $("#status_list-" + id).html('<span class="text-gray"> Approved</span>');
                            $("#status_read-" + id).html('<em class="icon ni ni-check-circle-fill" id="is_read-' + id + '" style="display: show;"></em>');
                        }

                        viewRequest(id);
                        swalWithBootstrapButtons.fire('Removed!', response.message, 'success')

                    } else {
                        swalWithBootstrapButtons.fire('error', response.message, 'error')
                    }

                },
                error: function (response) {
                    alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelled', 'Action has been cancelled.', 'success')
        }
    })

}

// Reviewer
function sendToReviewer() {
    var id = $('#request_id').val();
    var approval_id = $('#approval_id').val();
    var form = new FormData(document.getElementById("formSendToReviewer"));
    var emailuser = form.get("emailuser");

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-default'
        },
        buttonsStyling: false
    })

    $.ajax({
        url: "list/approval/responseRequest",
        type: 'post',
        data: 'id=' + id + '&resp=SendToReviewer' + '&approval_id=' + approval_id + '&emailuser=' + emailuser,
        dataType: 'json',
        beforeSend: function () {
            $('#textSendToReviewer').html('Please wait...');
        },
        success: function (response) {

            console.log(response);
            
            if (response.status == 1) {

                $('#textSendToReviewer').html('Send');
                $('#modalSendToReviewer').modal('toggle');

                $("#status_list-" + id).html('<span class="text-default"> Review</span>');
                $("#status_read-" + id).html('<em class="icon ni ni-bullet-fill" id="is_read-' + id + '" style="display: show;"></em>')
                viewRequest(id);
                $("#reviewer-notes").html("<li class='text-primary'>On Review.</li>");
                Swal.fire({icon: 'success',title: 'Request has been sent to reviewer.'});


            } else {
                $('#textSendToReviewer').html('Send');
                swalWithBootstrapButtons.fire('Oops!', 'Sorry, There\' something wrongs. Please try again.', 'error')
            }

        }
    });
}

$("#submit-review").click(function (e) {
    e.preventDefault();
    var id = $('#request_id').val();
    var review_id = $('#review_id').val();
    var review_notes = $('textarea#review-notes').val();

    if (review_notes == "") {
        Swal.fire({icon: 'warning',title: 'Please, give review notes...'})
    } else { 

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "We will sending an email notification.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, sure!',
            cancelButtonText: 'Not now.',
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "list/review/submit",
                    type: 'post',
                    data: 'id=' + id + '&review_id=' + review_id + '&review_notes=' + review_notes,
                    dataType: 'json',
                    success: function (response) {

                        if (response.status == 1) {

                            $("#status_list-" + id).html('<span class="text-primary"> Waiting Approval</span>');
                            $("#status_read-" + id).html('<em class="icon ni ni-bullet-fill" id="is_read-' + id + '" style="display: show;"></em>');
                            swalWithBootstrapButtons.fire('Thank you!', 'Your review has been submitted.', 'success')
                            viewRequest(id);

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
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Oops! There\'s something wrong, it might be slow network. Please refresh the page and try again.',
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

});

$(document).ready(function (e) {
    $("#form-upload-review").on('submit', function (e) {
        e.preventDefault();
        var id = $('#request_id').val();

        $.ajax({
            type: 'POST',
            url: 'list/review/upload/save_upload',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#text-upload-review').html('Uploading. Please wait...');
            },
            success: function (response) {

                $('#form-upload-review')[0].reset();

                if (response.status == 1) {

                    $('#text-upload-review').html('Done!');
                    $('#text-upload-review').html('Start Upload');
                    $('#modal-upload-review').modal('toggle');
                    viewRequest(id);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Nice! Your Files has been uploaded.',
                        showConfirmButton: false,
                        timer: 1000
                    });

                } else {

                    $('#text-upload-review').html('Save Information');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops! Sorry, there\'s something wrong. Please try again.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    });
});

$("#upload-review").click(function (e) {
    e.preventDefault();
    var id = $('#request_id').val();
    var req_number = $('#request_number').val();

    $.ajax({
        type: 'post',
        url: "list/review/upload/show_modal_upload",
        data: 'id=' + id + '&req_number=' + req_number,
        dataType: 'json',
        beforeSend: function () {},
        success: function (response) {

            if (response) {
               
                $('#modalrequest_id').val(id);
                $('#modalrequest_number').val(req_number);
                $('#modal-upload-review').modal('toggle');

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops! Sorry, there\'s something wrong. Please try again.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    });

});

// E-BAST
$('li > a').click(function () {
    $('li').removeClass('active');
    $(this).parent().addClass('active');
});

function viewEbast(id) {
    return $.ajax({
        url: "list/ebast/viewRequest",
        type: 'post',
        data: 'id=' + id,
        dataType: 'json',
        beforeSend: function () {
            $('li').removeClass('active');
        },
        success: function (response) {

            // evaluation vendor
            $('#permit_start_date').val('');
            $('#permit_end_date').val('');
            $('#rfs_start_date').val('');
            $('#rfs_end_date').val('');
            $('#wtc_start_date').val('');
            $('#wtc_end_date').val('');
            document.getElementById("fo_criteria_time").value = null;
            document.getElementById("fo_criteria_quality").value = null;
            
            // hide preview document
        	$('#li-bast').hide();
            $('#li-rfi').hide();
            $('#li-receipt').hide();
            $('#li-wtcr').hide();
            $('#li-boq_final').hide();
            $('#li-bast2').hide();
            $('#li-upload_docs').hide();
            $('#li-ba_progress').hide();
            $('#li-bamt_preview').hide();

        	// hide additional upload
            $('#foto_biaya_koordinasi_field').hide();
            $('#ktp_kwitansi_field').hide();
            $('#scanned_id_field').hide();
            $('#copy_cme_field').hide();
            $('#ori_bpujl_field').hide();
            $('#cme_opname_field').hide();
            $('#final_doc_field').hide();
            $('#ba_stock_field').hide();
            $('#nod_field').hide();
            $('#additional_doc_field').hide();
            $('#upload_boq_final_fields').hide();
            $('#add_sitac_field').hide();

            // console.log(response);
            var base_url = window.location.origin;
            var requestNumber = response.request.request_number;

            $("#ebast_approval_info").html('');
            $('#button_response_panel').show();
            $('#button_response_panel_success').hide();
            $('#nothing-select').hide();

            if (response.request.is_status == 2) {
                $('#button_response_panel').show();
                $('#button_response_panel_success').hide();
            } else if (response.request.is_status == 3) {
                $('#button_response_panel').hide();
                $('#button_response_panel_success').show();
            } else if (response.request.is_status == 4) {
                $('#button_response_panel').hide();
                $('#button_response_panel_success').show();
            } else if (response.request.is_status == 5) {
                $('#button_response_panel').hide();
                $('#button_response_panel_success').show();
            } else {
                $('#button_response_panel').hide();
                $('#button_response_panel_success').hide();
            } 

            // Evaluation Vendor
            if ( (response.worktype == 'FIBER OPTIC') ) {

                if (response.evaluation_flag == 1) {

                    $('#li_approved').hide();
                    var path_time = 'https://e-approval.ibstower.com/file/ebast/Time_FO.pdf';
                    var path_quality = 'https://e-approval.ibstower.com/file/ebast/Quality_FO.pdf';
                    $('#download_kriteria_time').attr('href', path_time);
                    $('#download_kriteria_quality').attr('href', path_quality);
                    $('#div_upload_fo_time').show();
                    $('#div_upload_fo_quality').show();
                    $('#li_evaluation').show();

                     // evaluation permit
                    $.each(response.evaluation_permit, function (i, permit) {
                        var name = permit.permit_name;
                        var permit_start = permit.permit_start;
                        var permit_end = permit.permit_end;
                        var $tr = $('<tr>').append(
                            $('<td>').text(name.replace('00:00:00.000', '')),
                            $('<td>').text(permit_start.replace('00:00:00.000', '')),
                            $('<td>').text(permit_end.replace('00:00:00.000', ''))
                        ).appendTo('#permit_table');
                    });

                    $('#count_permit').val(response.count_permit);

                } else {
                    $('#li_approved').show();
                    $('#li_evaluation').hide();
                }

            } else if ( (response.worktype == 'SITAC') || (response.worktype == 'CME') ) {

                if (response.evaluation_flag == 1) {

                    $('#li_approved').hide();
                    var path_time = 'https://e-approval.ibstower.com/file/ebast/Time_Tower.pdf';
                    var path_quality = 'https://e-approval.ibstower.com/file/ebast/Quality_Tower.pdf';
                    $('#download_kriteria_time').attr('href', path_time);
                    $('#download_kriteria_quality').attr('href', path_quality);
                    $('#div_upload_fo_time').hide();
                    $('#div_upload_fo_quality').hide();
                    $('#li_evaluation').show();

                } else {
                    $('#li_approved').show();
                    $('#li_evaluation').hide();
                }

            }  else {
                $('#li_approved').show();
                $('#li_evaluation').hide();
            }

            // Response Panel
            $('#ebast_id').val(response.request.id);
            $('#request_number').val(response.request.request_number);
            $('#requestor').val(response.request.created_by);
            $('#approval_id').val(response.approval_id);
            $('#eval_vendor_code').val(response.request.vendor_id);

            if (response.priority == 3 || response.priority == 4 ) {
                $('#revise_proc').show();
                $('#li_evaluation_proc').show();

            }else{
                $('#revise_proc').hide();
                $('#li_evaluation_proc').hide();

            }

            // Detail request
            $('#requestor_name').html(response.request.created_by);
            $('#requestDate').html(response.request.created_at);
            $('#requestStatus').html(response.status);
            $('#requestNumber').html(requestNumber);
            $('#wbs_id').html(response.request.wbs_id);
            $('#site_id').html(response.request.site_id);
            $('#site_name').html(response.request.site_name);
            $('#region').html(response.request.region);
            $('#worktype').html(response.worktype);
            $('#milestone').html(response.milestone);
            $('#po_number').html(response.request.po_number);
            $('#po_created_date').html(response.request.po_created_date);

            // Approval Info
            $.each(response.progress, function (i, approver_info) {

                if (approver_info.approval_status == 'Approved') {
                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-primary'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                } else if ((approver_info.approval_status == 'Revised') || (approver_info.approval_status == 'In Progress')) {
                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-warning'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                } else if (approver_info.approval_status == 'Rejected') {
                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-danger'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                } else {
                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-light'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");
                }

            });

            // Preview Document
            if (response.form.bast_form) {
                $("#bast").addClass("active");
                $("#rfi").removeClass("active");
                $("#bast2").removeClass("active");
                $("#ba_progress").removeClass("active");
                $('#li-bast').show();

                if (response.worktype == 'INVENTORY' && response.milestone == 'Opname') {

                    $.ajax({
                        url: 'list/ebast/preview/inventory_opname/' + id,
                        type: "POST",
                        dataType: "json",
                        success: function (result) {
                            var no = 0;
                            $('#materialTable').html('');
                            $.each(result, function (i, item) {
                                no++;
                                var $tr = $('<tr>').append(
                                    $('<td>').text(no),
                                    $('<td>').text(item.material_desc),
                                    $('<td>').text(item.qty_material)
                                ).appendTo('#materialTable');
                            });
                        }
                    });

                    $('#on_this_date_bast_opname').text(response.bast_date.updated_at);
                    $('#masa_bast_opname').text(response.masa_bast);
                    $('#bast_opname_po_number').text(response.request.po_number);
                    $('#bast_opname_wbs_id').text(response.request.wbs_id);
                    $('#bast_opname_site_name').text(response.request.site_name);
                    $('#bast_opname_worktype').text(response.worktype);
                    $('#bast_opname_milestone').text(response.milestone);

                    $('#bast_opname_vendor_name').text(response.request.vendor_name);
                    $('#bast_opname_vendor_title').text(response.request.vendor_title);
                    $('#bast_opname_vendor').text(response.vendor.vendor_name);

                    $('#bast_opname_received_by').text(response.vendor.vendor_name);
                    $('#bast_opname_ttd_vendor').text(response.vendor.vendor_name);
                    $('#bast_opname_ttd_vendor_name').text(response.request.vendor_name);
                    $('#bast_opname_ttd_vendor_title').text(response.request.vendor_title);

                    $('#btn-preview-bast').attr('data-target','#previewBASTopname');

                } else if (response.worktype != 'INVENTORY') {

                    $('#on_this_date_bast').text(response.bast_date.updated_at);
                    $('#masa_bast').text(response.masa_bast);
                    $('#bast_po_number').text(response.request.po_number);
                    $('#bast_wbs_id').text(response.request.wbs_id);
                    $('#bast_site_name').text(response.request.site_name);
                    $('#bast_worktype').text(response.worktype);
                    $('#bast_milestone').text(response.milestone);

                    $('#bast_vendor_name').text(response.request.vendor_name);
                    $('#bast_vendor_title').text(response.request.vendor_title);
                    $('#bast_vendor').text(response.vendor.vendor_name);
                    $('#bast_ibs_name').text(response.progress[1].approval_name);
                    $('#bast_ibs_title').text(response.progress[1].approval_title);

                    $('#bast_received_by').text(response.vendor.vendor_name);
                    $('#bast_ttd_vendor_name').text(response.request.vendor_name);
                    $('#bast_ttd_vendor_title').text(response.request.vendor_title);
                    $('#bast_ttd_ibs_name').text(response.progress[1].approval_name);
                    $('#bast_ttd_ibs_title').text(response.progress[1].approval_title);

                    $('#btn-preview-bast').attr('data-target','#previewBAST');
                }
            }

            if (response.form.bamt_form) {
                $('#li-bamt_preview').show();   
            }

            if (response.form.ba_progress_form) {
                $("#ba_progress").addClass("active");
                $("#bast").removeClass("active");
                $("#bast2").removeClass("active");
                $("#rfi").removeClass("active");
                $('#li-ba_progress').show();

                $('#on_this_date_ba_progress').text(response.bast_date.updated_at);
                $('#ba_progress_po_number').text(response.request.po_number);
                $('#ba_progress_wbs_id').text(response.request.wbs_id);
                $('#ba_progress_site_name').text(response.request.site_name);
                $('#ba_progress_worktype').text(response.worktype);
                $('#ba_progress_milestone').text(response.milestone);

                $('#ba_progress_vendor_name').text(response.request.vendor_name);
                $('#ba_progress_vendor_title').text(response.request.vendor_title);
                $('#ba_progress_vendor').text(response.vendor.vendor_name);
                // $('#ba_progress_ibs_name').text(response.progress[1].approval_name);
                // $('#ba_progress_ibs_title').text(response.progress[1].approval_title);

                $('#ba_progress_received_by').text(response.vendor.vendor_name);
                $('#ba_progress_ttd_vendor_name').text(response.request.vendor_name);
                $('#ba_progress_ttd_vendor_title').text(response.request.vendor_title);
                $('#ba_progress_ttd_ibs_name').text(response.progress[1].approval_name);
                $('#ba_progress_ttd_ibs_title').text(response.progress[1].approval_title);
            }
            if (response.form.rfi_form) {
                $("#bast").removeClass("active");
                $("#bast2").removeClass("active");
                $("#ba_progress").removeClass("active");
                $("#rfi").addClass("active");
                $('#li-rfi').show();
            }
            if (response.form.boq_final) {
            	if (response.boq != null) {
                	$('#current_nominal_boq').val(parseInt(response.boq.nominal_boq));
            	} else {
                	$('#current_nominal_boq').val(0);
            	}
                $('#li-boq_final').show();
            }
            if (response.form.ttd_form) {
                $('#li-receipt').show();
            }
            if (response.form.wtcr_form) {

            	if (response.wtcr != null) {
                	$('#current_po_value').text(parseInt(response.wtcr.po_value));
                	$('#current_penalty').text(parseInt(response.wtcr.late_completion));
            	} else {
            		$('#current_po_value').text('0');
                	$('#current_penalty').text('0');
            	}

                $('#li-wtcr').show();
            }
            if (response.form.bast2_form) {
                $("#bast2").addClass("active");
                $("#bast").removeClass("active");
                $("#ba_progress").removeClass("active");
                $("#rfi").removeClass("active");
                $('#li-bast2').show();

                $('#bast2_tow').text(response.worktype);
                $('#bast2_wbs_id').text(response.request.wbs_id);
                $('#bast2_site_name').text(response.request.site_name);
                $('#bast2_ibs_name1').text(response.progress[1].approval_name);
                $('#bast2_ibs_title1').text(response.progress[1].approval_title);
                $('#bast2_vendor_name1').text(response.request.vendor_name);
                $('#bast2_vendor_title1').text(response.request.vendor_title);
                $('#bast2_po').text(response.request.po_number);
                $('#bast2_vendor').text(response.vendor.vendor_name);
                $('#bast2_vendor1').text(response.vendor.vendor_name);
                $('#bast2_vendor_name').text(response.request.vendor_name);
                $('#bast2_vendor_title').text(response.request.vendor_title);
                $('#bast2_ibs_name').text(response.progress[1].approval_name);
                $('#bast2_ibs_title').text(response.progress[1].approval_title);
            }
            if (response.form.upload_docs) {

                $('#li-upload_docs').show();
                
                if (response.docs.scanned_iw != null) {
                    $('#scanned_id_field').show();
                    var path_scanned_id = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.scanned_iw.file_path;
                    $('#scanned_id').attr('href', path_scanned_id);
                } 

                if (response.docs.boq_final != null) {
                    $('#upload_boq_final_fields').show();
                    var path_upload_boq_final = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.boq_final.file_path;
                    $('#upload_boq_final').attr('href', path_upload_boq_final);
                } 

                if (response.docs.foto_general != null) {
                    $('#upload_foto_general_fields').show();
                    var path_upload_boq_final = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.foto_general.file_path;
                    $('#upload_foto_general').attr('href', path_upload_boq_final);
                } 

                if (response.docs.add_sitac != null) {
                    $('#add_sitac_field').show();
                    var path_add_sitac = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.add_sitac.file_path;
                    $('#add_sitac').attr('href', path_add_sitac);
                } 

                if (response.docs.foto_biaya_koordinasi != null) {
                    $('#foto_biaya_koordinasi_field').show();
                    var path_foto_biaya_koordinasi = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.foto_biaya_koordinasi.file_path;
                    $('#foto_biaya_koordinasi').attr('href', path_foto_biaya_koordinasi);
                } 

                if (response.docs.bukti_bayar != null) {
                    $('#bukti_bayar_field').show();
                    var path_bukti_bayar = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.bukti_bayar.file_path;
                    $('#bukti_bayar').attr('href', path_bukti_bayar);
                } 

                if (response.docs.ktp_kwitansi != null) {
                    $('#ktp_kwitansi_field').show();
                    var path_ktp_kwitansi = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.ktp_kwitansi.file_path;
                    $('#ktp_kwitansi').attr('href', path_ktp_kwitansi);
                } 
                
                if (response.docs.copy_of_cme != null) {
                    $('#copy_cme_field').show();
                    var path_copy_cme = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.copy_of_cme.file_path;
                    $('#copy_cme').attr('href', path_copy_cme);
                } 

                if (response.docs.bamt != null) {
                    $('#bamt_field').show();
                    var path_bamt = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.bamt.file_path;
                    $('#bamt').attr('href', path_bamt);
                } 

                if (response.docs.original_bpujl != null) {
                    $('#ori_bpujl_field').show();
                    var path_ori_bpujl = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.original_bpujl.file_path;
                    $('#ori_bpujl').attr('href', path_ori_bpujl);
                } 

                if (response.docs.cme_opname_photos != null) {
                    $('#cme_opname_field').show();
                    var path_cme_opname = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.cme_opname_photos.file_path;
                    $('#cme_opname').attr('href', path_cme_opname);
                } 

                if (response.docs.copy_of_document_final != null) {
                    $('#final_doc_field').show();
                    var path_final_doc = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.copy_of_document_final.file_path;
                    $('#final_doc').attr('href', path_final_doc);
                }

                if (response.docs.ba_stock_opname != null) {
                    $('#ba_stock_field').show();
                    var path_ba_stock = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.ba_stock_opname.file_path;
                    $('#ba_stock').attr('href', path_ba_stock);
                } 

                if (response.docs.nod != null) {
                    $('#nod_field').show();
                    var path_nod = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.nod.file_path;
                    $('#nod').attr('href', path_nod);
                } 

                if (response.docs.additional != null) {
                    $('#additional_doc_field').show();
                    var path_additional_doc = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.additional.file_path;
                    $('#additional_doc').attr('href', path_additional_doc);
                } 

                if (response.docs.fo_progress_photos != null) {
                    $('#fo_progress_photos_field').show();
                    var path_fo_progress_photos = 'https://fad.ibstower.com/ilink4/vendor/' + response.docs.fo_progress_photos.file_path;
                    $('#fo_progress_photos').attr('href', path_fo_progress_photos);
                } 

            }

            // Show View Detail
            $('#viewDetail').show();

        },
        error: function (response) {
            alert('Oops! There\'s something wrong while getting data. Please refresh the page and try again.');
        }
    });
}

// BAST Inventory Opname
$("#btnPreviewInventoryOpname").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();
    $.ajax({
        url: 'list/ebast/preview/inventory_opname/' + id,
        type: "POST",
        dataType: "json",
        success: function (result) {

            console.log(result);

            if (result == null) {

                alert('Please update Material Description before preview.');

            } else { 

                var no = 0;
                $('#materialTable').html('');
                $.each(result, function (i, item) {
                    no++;
                    var $tr = $('<tr>').append(
                        $('<td>').text(no),
                        $('<td>').text(item.material_desc),
                        $('<td>').text(item.qty_material)
                    ).appendTo('#materialTable');
                });

                $('#previewBASTopname').modal('toggle');

            }
            
        }
    });
});

$("#btnPreviewReceipt").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();

    $.ajax({
        url: 'list/ebast/preview/receipt/' + id,
        type: "POST",
        dataType: "json",
        success: function (result) {
            
            $('#receipt_site_name').text(result.request.site_name);
            $('#receipt_wbs_id').text(result.request.wbs_id);
            $('#receipt_vendor_name').text(result.request.vendor_name);
            $('#receipt_vendor_title').text(result.request.vendor_title);
            $('#receipt_ibs_name').text(result.rpm.approval_name);
            $('#receipt_ibs_title').text(result.rpm.approval_title);
            $('#receipt_vendor').text(result.vendor.vendor_name);

            var no = 0;
            $('#receiptTable').html('');
            $.each(result.item, function (i, item) {
                no++;
                var $tr = $('<tr>').append(
                    $('<td>').text(no),
                    $('<td>').text(item.work_item),
                    $('<td>').text(item.checklist),
                    $('<td>').text(item.remarks)
                ).appendTo('#receiptTable');
            });

            $('#prev_receipt_notes').text(result.notes.notes);
            $('#previewReceipt').modal('toggle');

        }
    });
});

$("#btnPreviewBAMT").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();

    $.ajax({
        url: 'list/ebast/preview/bamt/' + id,
        type: "POST",
        dataType: "json",
        success: function (result) {

            console.log(result);

            if (result.header == null) {

                alert('NOD has been reported on IMM. No BAMT Required. Please make sure to vendor.');
                return false;

            } else {
                $('#prev_bamt_po').text(result.request.po_number);
                $('#prev_bamt_pic_ibs_name').text(result.header.pic_project);
                $('#prev_bamt_wbs_id').text(result.request.wbs_id);
                $('#prev_bamt_pic_phone').text(result.header.pic_phone);
                $('#prev_bamt_project_name').text(result.header.project_name);
                $('#prev_bamt_sitename').text(result.header.segment_name);
                $('#prev_bamt_regional').text(result.header.region);
                $('#prev_bamt_vendor').text(result.vendor.vendor_name);
                $('#prev_bamt_vendor_phone').text(result.header.pic_material_contr_phone);
                $('#prev_bamt_vendor_name').text(result.header.pic_material_contr_name);
                $('#prev_bamt_vendor_email').text(result.header.pic_material_contr_email);

                var no = 0;
                $('#summary_material_bamt').html('');
                $.each(result.summary, function (i, item) {
                    no++;
                    var $tr = $('<tr>').append(
                        $('<td>').text(no),
                        $('<td>').text(item.nod_number),
                        $('<td>').text(item.po_number),
                        $('<td>').text(item.material_code),
                        $('<td>').text(item.material_type),
                        $('<td>').text(item.total_qty),
                        $('<td>').text(item.total_install),
                        $('<td>').text(item.total_idle),
                        $('<td>').text(item.total_waste),
                        $('<td>').text(item.total_loss),
                    ).appendTo('#summary_material_bamt');
                });
                $('#previewBAMT').modal('toggle');
            }

        }
    });
});

$("#btnPreviewRFI").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();

    $.ajax({
        url: 'list/ebast/preview/rfi/' + id,
        type: "POST",
        dataType: "json",
        success: function (result) {

            $('#rfi_wbs_id').text(result.request.wbs_id);
            $('#rfi_site_name').text(result.request.site_name);
            $('#rfi_ibs_name').text(result.rpm.approval_name);
            $('#rfi_ibs_title').text(result.rpm.approval_title);

            result.rfi.erection_na == 1 ? $("#previewRFI #erection_na").prop("checked", true) : $("#erection_na").prop("checked", false);
            result.rfi.erection_no == 1 ? $("#previewRFI #erection_no").prop("checked", true) : $("#erection_no").prop("checked", false);
            result.rfi.erection_yes == 1 ? $("#previewRFI #erection_yes").prop("checked", true) : $("#erection_yes").prop("checked", false);
            result.rfi.me_na == 1 ? $("#previewRFI #me_na").prop("checked", true) : $("#me_na").prop("checked", false);
            result.rfi.me_no == 1 ? $("#previewRFI #me_no").prop("checked", true) : $("#me_no").prop("checked", false);
            result.rfi.me_yes == 1 ? $("#previewRFI #me_yes").prop("checked", true) : $("#me_yes").prop("checked", false);
            result.rfi.pln_na == 1 ? $("#previewRFI #pln_na").prop("checked", true) : $("#pln_na").prop("checked", false);
            result.rfi.pln_no == 1 ? $("#previewRFI #pln_no").prop("checked", true) : $("#pln_no").prop("checked", false);
            result.rfi.pln_yes == 1 ? $("#previewRFI #pln_yes").prop("checked", true) : $("#pln_yes").prop("checked", false);
            result.rfi.sum_no == 1 ? $("#previewRFI #sum_no").prop("checked", true) : $("#sum_no").prop("checked", false);
            result.rfi.sum_yes == 1 ? $("#previewRFI #sum_yes").prop("checked", true) : $("#sum_yes").prop("checked", false);
            result.rfi.tow_erection == 1 ? $("#previewRFI #tow_erection").prop("checked", true) : $("#tow_erection").prop("checked", false);
            result.rfi.tow_me == 1 ? $("#previewRFI #tow_me").prop("checked", true) : $("#tow_me").prop("checked", false);
            result.rfi.tow_power == 1 ? $("#previewRFI #tow_power").prop("checked", true) : $("#tow_power").prop("checked", false);
            $('#previewRFI').modal('toggle');

        }
    });
});

$("#btnPreviewWtcr").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();

    $.ajax({
        url: 'list/ebast/preview/wtcr/' + id,
        type: "POST",
        dataType: "json",
        success: function (result) {

            $('#ebast_po_value').val(""); 
            $('#wtcr_late_completion').val(""); 

            $('#wtcr_tow').text(result.worktype);
            $('#wtcr_wbs').text(result.request.wbs_id);
            $('#wtcr_sitename').text(result.request.site_name);
            $('#wtcr_po').text(result.request.po_number);
            
            $('#prev_execution_time').text(result.wtcr[0].execution_time);
            $('#prev_start_date').text(result.wtcr[0].start_date);
            $('#prev_finish_date').text(result.wtcr[0].finish_date);
            $('#prev_actual_finish_date').text(result.wtcr[0].actual_finish_date);
            $('#prev_actual_execution_time').text(result.wtcr[0].actual_execution_time);
            $('#prev_job_acceleration_a_1').text(result.wtcr[0].job_acceleration_a_1);
            $('#prev_reason_raining').text(result.wtcr[0].reason_raining);
            $('#prev_reason_change_sow').text(result.wtcr[0].reason_change_sow);
            $('#prev_reason_discontinuance').text(result.wtcr[0].reason_discontinuance);
            $('#prev_reason_others_a').text(result.wtcr[0].reason_others_a);
            $('#prev_reason_others_a_days').text(result.wtcr[0].reason_others_a_days);
            $('#prev_reason_others_b').text(result.wtcr[0].reason_others_b);
            $('#prev_reason_others_b_days').text(result.wtcr[0].reason_others_b_days);
            $('#prev_reason_others_c').text(result.wtcr[0].reason_others_c);
            $('#prev_reason_others_c_days').text(result.wtcr[0].reason_others_c_days);
            $('#prev_reason_others_d').text(result.wtcr[0].reason_others_d);
            $('#prev_reason_others_d_days').text(result.wtcr[0].reason_others_d_days);
            $('#prev_total_b').text(result.wtcr[0].total_b);
            $('#prev_job_acceleration_a_2').text(result.wtcr[0].job_acceleration_a_2);

            $('#wtcr_vendor').text(result.vendor.vendor_name);
            $('#wtcr_vendor_name').text(result.request.vendor_name);
            $('#wtcr_vendor_title').text(result.request.vendor_title);
            $('#wtcr_ibs_pm').text(result.rpm.approval_name);
            $('#wtcr_ibs_pm_title').text(result.rpm.approval_title);
            $('#wtcr_ibs_procurement').text(result.procurement.approval_name);

            // Flag Procurement for Update PO Penalty
            if (result.approval_priority == 3) {
                $('#ebast_po_value').prop("disabled", false); 
                $("#calculate_po_penalty").show();
            }

            $('#previewWTCR').modal('toggle');

        }
    });
});

function calculate_po_penalty() {
    var ebast_id = $('#ebast_id').val();
    var po_value = $('#ebast_po_value').val();
    var job_acceleration_a_2 = $('#prev_job_acceleration_a_2').text();

    // alert(job_acceleration_a_2);

    var postData = {
        ebast_id: ebast_id,
        po_value: po_value,
        job_acceleration_a_2: job_acceleration_a_2
    }

    $.ajax({
        method: 'POST',
        url: 'list/ebast/calculate/po_penalty',
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
        },
        success: function (response) {
            if (response.status) {
                console.log(response);
                $('#wtcr_late_completion').val(parseInt(response.data.late_completion));
                $('#current_po_value').text(parseInt(po_value));
            } else {
                console.log(response);
                alert("Oops, please refresh the page and try again.");
            }
        }
    });
}

function save_wtcr() {

    var id = $('#ebast_id').val();
    var start_date = $('#start_date').val();
    var finish_date = $('#finish_date').val();
    var actual_finish_date = $('#actual_finish_date').val();
    var reason_raining = $('#reason_raining').val();
    var reason_change_sow = $('#reason_change_sow').val();
    var reason_discontinuance = $('#reason_discontinuance').val();
    var reason_others_a = $('#reason_others_a').val();
    var reason_others_a_days = $('#reason_others_a_days').val();
    var reason_others_b = $('#reason_others_b').val();
    var reason_others_b_days = $('#reason_others_b_days').val();
    var reason_others_c = $('#reason_others_c').val();
    var reason_others_c_days = $('#reason_others_c_days').val();
    var reason_others_d = $('#reason_others_d').val();
    var reason_others_d_days = $('#reason_others_d_days').val();

    var postData = {
        id: id,
        start_date: start_date,
        finish_date: finish_date,
        actual_finish_date: actual_finish_date,
        reason_raining: reason_raining,
        reason_change_sow: reason_change_sow,
        reason_discontinuance: reason_discontinuance,
        reason_others_a: reason_others_a,
        reason_others_a_days: reason_others_a_days,
        reason_others_b: reason_others_b,
        reason_others_b_days: reason_others_b_days,
        reason_others_c: reason_others_c,
        reason_others_c_days: reason_others_c_days,
        reason_others_d: reason_others_d,
        reason_others_d_days: reason_others_d_days
    }

    $.ajax({
        method: 'POST',
        url: "list/ebast/save_form/wtcr",
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
            $('.textModalWtcr').html("Calculating and saving your data, please wait...");
        },
        success: function (response) {
            console.log(response);

            if (response.status) {

                $('.textModalWtcr').html("Calculated successfully!");

                $('#start_date').val(response.data.start_date);
                $('#finish_date').val(response.data.finish_date);
                $('#actual_finish_date').val(response.data.actual_finish_date);
                $('#reason_raining').val(response.data.reason_raining);
                $('#reason_change_sow').val(response.data.reason_change_sow);
                $('#reason_discontinuance').val(response.data.reason_discontinuance);
                $('#reason_others_a').val(response.data.reason_others_a);
                $('#reason_others_a_days').val(response.data.reason_others_a_days);
                $('#reason_others_b').val(response.data.reason_others_b);
                $('#reason_others_b_days').val(response.data.reason_others_b_days);
                $('#reason_others_c').val(response.data.reason_others_c);
                $('#reason_others_c_days').val(response.data.reason_others_c_days);
                $('#reason_others_d').val(response.data.reason_others_d);
                $('#reason_others_d_days').val(response.data.reason_others_d_days);

                $('#execution_time').val(response.data.execution_time);
                $('#actual_execution_time').val(response.data.actual_execution_time);
                $('#job_acceleration_a_1').val(response.data.job_acceleration_a_1);
                $('#total_b').val(response.data.total_b);
                $('#job_acceleration_a_2').val(response.data.job_acceleration_a_2);

                $('.textModalWtcr').html("Calculate & Save");

            }
        }
    });
}

$("#btnPreviewBoqFinal").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();

    $.ajax({
        url: 'list/ebast/preview/boq_final/' + id,
        type: "POST",
        dataType: "json",
        success: function (result) {

        	if (result.boq != null) {

        		if (result.boq.nominal_boq != null) {
            		$('#nominal_boq').val(result.boq.nominal_boq); 
	            } else {
	            	$('#nominal_boq').val(0); 
                    alert('Nominal BOQ Final is empty.');
	            }

	            if (result.approval_priority == 3) {
	                $('#nominal_boq').prop("disabled", false); 
	                $("#save_nominal_boq").show();
	            } 

                if (result.doc_boq == null) {
                    alert("BOQ Final file is not uploaded.");
                } 
                
                if (result.doc_boq.file_path != null) {
                    var path_doc_boq = 'https://fad.ibstower.com/ilink4/vendor/' + result.doc_boq.file_path;
                    $('#files_boq_final').attr('href', path_doc_boq);
                } 


        	}

            $('#previewBoqFinal').modal('toggle');

        }
    });
});

function save_nominal_boq() {
    var ebast_id = $('#ebast_id').val();
    var nominal = $('#nominal_boq').val();

    var postData = {
        ebast_id: ebast_id,
        nominal: nominal
    }

    $.ajax({
        method: 'POST',
        url: 'list/ebast/calculate/boq_final',
        data: postData,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
        },
        success: function (response) {
            if (response.status) {
                console.log(response);
                $('#nominal_boq').val(parseInt(response.data.nominal_boq));
                $('#current_nominal_boq').val(parseInt(response.data.nominal_boq));
                alert("Nominal BOQ Final has been saved.");

            } else {
                console.log(response);
                alert("Oops, please refresh the page and try again.");
            }
        }
    });
}


// EVALUATION FORM VENDOR
$(document).ready(function () {
    document.getElementById('eval_remarks_time').onkeyup = function () {
    	var charRemarks = 1 - this.value.length;

    	if (charRemarks <= 0 ) {
    		document.getElementById('countRemarksTime').innerHTML = "";
            $('#showSubmitButton').hide();
            $('#hideSubmitButton').show();

    	} else{
            $('#showSubmitButton').hide();
            $('#hideSubmitButton').show();
    		document.getElementById('countRemarksTime').innerHTML = "Minimum characters left: " + (200 - this.value.length);
    	}
    };

    document.getElementById('eval_remarks_quality').onkeyup = function () {
        var charRemarks = 1 - this.value.length;

        if (charRemarks <= 0 ) {
            document.getElementById('countRemarksQuality').innerHTML = "";
            $('#showSubmitButton').show();
            $('#hideSubmitButton').hide();

        } else{
            $('#showSubmitButton').hide();
            $('#hideSubmitButton').show();
            document.getElementById('countRemarksQuality').innerHTML = "Minimum characters left: " + (200 - this.value.length);
        }

    };

    document.getElementById('eval_achievement').onkeyup = function () {
        var score_acv = this.value;
        if ((score_acv > 5)) {
            $('#td_score_acv').css('color', '#fff');
            $('#td_score_acv').css('background', 'red');
            $('#alert_td_acv').show();
        } else {
            $('#td_score_acv').css('color', '');
            $('#td_score_acv').css('background', '');
            $('#alert_td_acv').hide();
        }
    };

    document.getElementById('eval_quality').onkeyup = function () {
        var score_qlt = this.value;
        if ((score_qlt > 5)) {
            $('#td_score_qlt').css('color', '#fff');
            $('#td_score_qlt').css('background', 'red');
            $('#alert_td_qlt').show();
        } else {
            $('#td_score_qlt').css('color', '');
            $('#td_score_qlt').css('background', '');
            $('#alert_td_qlt').hide();
        }
    };
});


function add_permit() {
   
    var id = $('#ebast_id').val();
    var permit_name = $('#permit_name').val();
    var permit_start = $('#permit_start_date').val();
    var permit_end = $('#permit_end_date').val();
    var count_numbering = $('#count_permit').val();

    if ((permit_name != "") && (permit_start != "") && (permit_end != "") ) {
    
        var postData = {
            ebast_id: id,
            permit_name:permit_name,
            permit_start:permit_start,
            permit_end:permit_end
        }

        $.ajax({
            method: 'post',
            url: 'list/ebast/save_form/evaluation_permit_date',
            data: postData,
            dataType: 'json',
            success: function (response) {

                if ((count_numbering >= 5)) {

                   alert('Max Permit Date (5)');

                } else {
                    if (response.status == 1) {
                        count_numbering++;
                        var table = document.getElementById("permit_table");
                        var table_len = (table.rows.length) - 1;
                        var row = table.insertRow(table_len).outerHTML = "<tr id='row" +response.permit_id + "'><td id='permit_name_row" + table_len + "'>" + permit_name + "</td><td id='permit_start_row" + table_len + "'>" + permit_start + "</td><td id='permit_end_row" + table_len + "'>" + permit_end + "</td><td><input type='button' value='Delete' class='btn btn-sm btn-danger delete' onclick='delete_permit(" + response.permit_id + ")'></td></tr>";
                        document.getElementById("permit_name").value = "";
                        document.getElementById("permit_start_date").value = "";
                        document.getElementById("permit_end_date").value = "";
                        $('#count_permit').val(count_numbering);

                    } else {
                       alert(response.messages);
                    }
                }
                
            }
        });

    } else {
        alert('Permit Name, Start date & End Date are required.');
        return false;
    }

};

function delete_permit(permit_id) {
    var id = $('#ebast_id').val();
    var count_numbering = $('#count_permit').val();

    var postData = {
        ebast_id: id,
        permit_id: permit_id
    }
    $.ajax({
        method: 'post',
        url: 'list/ebast/save_form/evaluation_permit_del',
        data: postData,
        dataType: 'json',
        success: function (response) {
            if (response.status == 1) {

                count_numbering--; 
                $('#count_permit').val(count_numbering);

                document.getElementById("row" + permit_id + "").outerHTML = "";
            } else {
                alert('Delete item failed. Please refresh the page and try again.');
            }
        }
    });
}


function save_evaluation() {

    var ebast_id = $('#ebast_id').val();
    var eval_vendor_code = $('#eval_vendor_code').val();
    var eval_rpm = $('#eval_rpm').val();
    var eval_project_name = $('#eval_project_name').val();
    var eval_worktype = $('#eval_worktype').val();
    var eval_po_number = $('#eval_po_number').val();
    var eval_wbs = $('#eval_wbs').val();
    var eval_regional = $('#eval_regional').val();
    var eval_site_name = $('#eval_site_name').val();
    var eval_achievement = document.getElementById("eval_achievement").value;
    var eval_quality = $('#eval_quality').val();
    var eval_safety = $('#eval_safety').val();
    var count_ceklist_k3 = $('#eval_numbering').val();
    var eval_remarks_time = $('textarea#eval_remarks_time').val();
    var eval_remarks_quality = $('textarea#eval_remarks_quality').val();
    var rfs_start_date = $('#rfs_start_date').val();
    var rfs_end_date = $('#rfs_end_date').val();
    var wtc_start_date = $('#wtc_start_date').val();
    var wtc_end_date = $('#wtc_end_date').val();

    if (count_ceklist_k3 = 4) {
        var input_penilaian_1 = $('#input_penilaian-1').val();
        var input_penilaian_2 = $('#input_penilaian-2').val();
        var input_penilaian_3 = $('#input_penilaian-3').val();
        var input_penilaian_4 = $('#input_penilaian-4').val();
        var total_penilaian_1 = $('#total_penilaian-1').val();
        var total_penilaian_2 = $('#total_penilaian-2').val();
        var total_penilaian_3 = $('#total_penilaian-3').val();
        var total_penilaian_4 = $('#total_penilaian-4').val();

    } else {
        // ceklist fo
    }

    if ((eval_achievement == '0.00') || (eval_quality == '0.00')) {
        alert('Please input Time & Quality score.');
        return false;
    }

    if ((eval_achievement > 5) || (eval_quality > 5)) {
        alert('Time & Quality score must be less than or equal to 5.');
        return false;
    }

    if ((input_penilaian_1 == '0.00') || (input_penilaian_2 == '0.00') || (input_penilaian_3 == '0.00') || (input_penilaian_4 == '0.00')) {
        alert('Please complete Ceklist K3 Score.');
        return false;
    } 

    if ((input_penilaian_1 > 5) || (input_penilaian_2 > 5) || (input_penilaian_3 > 5) || (input_penilaian_4 > 5)) {
        alert('Please input K3 Score less than or equal to 5.');
        return false;
    } 

    if (eval_project_name == '0') {
        alert('Please select Project Name');
        return false;
    } 

    if ((eval_remarks_time == '') || (eval_remarks_quality == '')) {
    	alert('Remarks cannot be empty');
        return false;
    } 

    if ((rfs_start_date == '') || (rfs_end_date == '') || (wtc_start_date == '') || (wtc_end_date == '')) {
        alert('Please check Time Remarks section. All field is required.');
        return false;
    } 

    if (eval_worktype == "FIBER OPTIC"){
        if ( (document.getElementById("fo_criteria_time").files.length === 0) || (document.getElementById("fo_criteria_quality").files.length === 0) ){
            alert("Please Upload Time & Quality Criteria File.");
            return false;
        }
    }

    var form = $('#formEvaluationVendor')[0]; 
    var postData = new FormData(form);

    var fo_criteria_time = $('#fo_criteria_time').prop('files')[0];   
    postData.append('file', fo_criteria_time);

    var fo_criteria_quality = $('#fo_criteria_quality').prop('files')[0];   
    postData.append('file', fo_criteria_quality);

    $.ajax({
        method: 'POST',
        url: 'list/ebast/save_form/evaluation',
        data: postData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            console.log(postData);
            $('.textModalEvaluation').html("Saving your data, please wait...");
        },
        success: function (response) {
            if (response.status) {

                $('.textModalEvaluation').html("Done!");
                $('.textModalEvaluation').html("Submit");

                $('#formEvaluation').modal('toggle');

                $('#li_approved').show();
                $('#li_evaluation').hide();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Nice! Evaluation Form has been saved.',
                    showConfirmButton: false,
                    timer: 1000
                });

            } else {
                console.log(response);
                alert("Oops, please refresh the page and try again.");
            }
        }
    });

}

function ebastRevise(type) {

    var title = '';
    var text = '';

    if (type == 'revise_vendor') {
        title = 'Revise to Vendor';
        text = 'Are you sure?';
    } else if (type == 'revise_rpm') {
        title = 'Revise to RPM';
        text = 'Are you sure?';
    } else if (type == 'rollback_ebast') {
        title = 'Rollback to First Layer';
        text = 'Are you sure?';
    }

    if (($('#response-notes').val() == "")) {
        
        Swal.fire({icon: 'warning', title: 'Please, give notes...'})

    } else {
        
        var id = $('#ebast_id').val();
        var note = $('textarea#response-notes').val();
        var approval_id = $('#approval_id').val();
        var requestor = $('#requestor').val();

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, sure!',
            cancelButtonText: 'Cancel!',
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "list/ebast/response/"+ type,
                    type: 'post',
                    data: 'id=' + id + '&note=' + note + '&approval_id=' + approval_id + '&requestor=' + requestor,
                    dataType: 'json',
                    success: function (response) {

                        if (response.status == 1) {

                            $('#button_response_panel').hide();
                            $('#button_response_panel_success').show();
                            $('#requestStatus').html(response.request_status);
                            $('#ebast_approval_info').html('');
                            $('textarea#response-notes').val('');

                            $("#status_list-" + id).html('<span class="text-warning"> Revised</span>');
                            $("#status_read-" + id).html('<em class="icon ni ni-bullet-fill" id="is_read-' + id + '" style="display: show;"></em>');
                            
                            // Approval Info
                            $.each(response.progress, function (i, approver_info) {
                                if (approver_info.approval_status == 'Approved') {
                                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-primary'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                                } else if ((approver_info.approval_status == 'Revised') || (approver_info.approval_status == 'In Progress')) {
                                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-warning'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                                } else if (approver_info.approval_status == 'Rejected') {
                                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-danger'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                                } else {
                                    $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-light'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");
                                }
                            });
                            
                            swalWithBootstrapButtons.fire('Thank You!','Response successfully.','success')

                        } else {
                            swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please refresh & try again.', 'error')
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
}

$("#ebast-evaluation").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();

    $.ajax({
        url: 'list/ebast/preview/evaluation/' + id,
        type: "POST",
        dataType: "json",
        beforeSend: function () {
            $('#eval_project_name').html('');
            $('#eval_achievement').val('0.00');
            $('#eval_quality').val('0.00');
            $('#eval_remarks_quality').val('');
            $('#eval_remarks_time').val('');
            $('#eval_ebast_id').val('');
        },
        success: function (result) {

            $('#eval_vendor_name').val(result.vendor.vendor_name);
            $('#eval_rpm').val(result.rpm.approval_name);
            $('#eval_regional').val(result.request.region);
            $('#eval_po_number').val(result.request.po_number);
            $('#eval_wbs').val(result.request.wbs_id);
            $('#eval_sitename').val(result.request.site_name);
            $('#eval_worktype').val(result.worktype);

            if ((result.worktype == 'SITAC') || (result.worktype == 'CME')) {
                $('#eval_project_name').append('<option value="0">Please Select</option>');
                $('#eval_project_name').append('<option value="B2S">B2S</option>');
                $('#eval_project_name').append('<option value="Colocation">Colocation</option>');
                $('#eval_project_name').append('<option value="Strengthening">Strengthening</option>');
                $('#eval_time_permit').hide();

            } else if ((result.worktype == 'FIBER OPTIC')) {
                $('#eval_project_name').append('<option value="0">Please Select</option>');
                $('#eval_project_name').append('<option value="OSP">OSP (Lease-Core)</option>');
                $('#eval_project_name').append('<option value="BTSH">BTSH</option>');
                $('#eval_project_name').append('<option value="MMP">MMP</option>');
                $('#eval_project_name').append('<option value="Local_Loop">Local Loop</option>');
                $('#eval_project_name').append('<option value="Metro_E">Metro-E</option>');
                $('#eval_project_name').append('<option value="Partnership">Partnership</option>');
                $('#eval_project_name').append('<option value="Relokasi">Relokasi</option>');
                $('#eval_time_permit').show();
            } 

            var table_ceklist;
            var number;
            var count_numbering = 0;

            for (var i = result.master_checklist.length - 1; i >= 0; i--) {
                
                if (result.master_checklist[i].numbering == 0) {
                    number = '';
                    bobot = '';
                    input_bobot = '';
                    input_penilaian = '';
                    total_penilaian = '';
                } else {
                    count_numbering++;
                    number = result.master_checklist[i].numbering;
                    bobot = result.master_checklist[i].bobot_penilaian;
                    input_bobot = '<input type="text" size="4" disabled readonly id="input_bobot-'+result.master_checklist[i].numbering+'" value="'+bobot+'">';
                    input_penilaian = '<input type="number"size="10" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="4" min="1" max="5.00" onchange="setTwoNumberDecimal" onClick="return calculate_eval_k3(this.id);" step="0.01" value="0.00" onKeyUp="return calculate_eval_k3(this.id);" required id="input_penilaian-'+result.master_checklist[i].numbering+'" name="input_penilaian-'+result.master_checklist[i].numbering+'">';
                    total_penilaian = '<input type="text" size="4" onchange="setTwoNumberDecimal" step="0.01" value="0.00" readonly id="total_penilaian-'+result.master_checklist[i].numbering+'" name="total_penilaian-'+result.master_checklist[i].numbering+'">';
                }

                table_ceklist += '<tr class="tb-tnx-item"><td class="tb-tnx-id">'+number+'</td><td class="tb-tnx-info">'+result.master_checklist[i].kriteria_penilaian+'</td><td class="tb-tnx-info">'+result.master_checklist[i].keterangan+'</td><td>'+input_bobot+'</td><td id="td_input-'+result.master_checklist[i].numbering+'">'+input_penilaian+'<p id="alert_k3_input-'+result.master_checklist[i].numbering+'" style="display:none;">Score 1-5</p></td><td>'+total_penilaian+'</td></tr>';
            }

            $('#eval_numbering').val(count_numbering);
            $('#eval_ebast_id').val(id);

            $('#tableCeklis').html(table_ceklist);

            $('#formEvaluation').modal('toggle');
        }
    });

});

$("#ebast-evaluation-proc").click(function (e) {
    e.preventDefault();
    var id = $('#ebast_id').val();

    $.ajax({
        url: 'list/ebast/preview/evaluation_proc/' + id,
        type: "POST",
        dataType: "json",
        success: function (result) {

            $('#review_vendor_name').text(result.vendor.vendor_name);
            $('#review_rpm').text(result.rpm.approval_name);
            $('#review_regional').text(result.request.region);
            $('#review_po_number').text(result.request.po_number);
            $('#review_wbs').text(result.request.wbs_id);
            $('#review_sitename').text(result.request.site_name);
            $('#review_worktype').text(result.worktype);
            $('#review_project_name').text(result.project_name);

                // var table_ceklist;
                // var number;
                // var count_numbering = 0;

                // for (var i = result.master_checklist.length - 1; i >= 0; i--) {
                    
                //     if (result.master_checklist[i].numbering == 0) {
                //         number = '';
                //         bobot = '';
                //         input_bobot = '';
                //         input_penilaian = '';
                //         total_penilaian = '';
                //     } else {
                //         count_numbering++;
                //         number = result.master_checklist[i].numbering;
                //         bobot = result.master_checklist[i].bobot_penilaian;
                //         input_bobot = '<input type="text" size="4" disabled readonly id="input_bobot-'+result.master_checklist[i].numbering+'" value="'+bobot+'">';
                //         input_penilaian = '<input type="number"id="input_penilaian-'+result.master_checklist[i].numbering+'" name="input_penilaian-'+result.master_checklist[i].numbering+'">';
                //         total_penilaian = '<input type="text" size="4" onchange="setTwoNumberDecimal" step="0.01" value="0.00" readonly id="total_penilaian-'+result.master_checklist[i].numbering+'" name="total_penilaian-'+result.master_checklist[i].numbering+'">';
                //     }

                //     table_ceklist += '<tr class="tb-tnx-item"><td class="tb-tnx-id">'+number+'</td><td class="tb-tnx-info">'+result.master_checklist[i].kriteria_penilaian+'</td><td class="tb-tnx-info">'+result.master_checklist[i].keterangan+'</td><td>'+input_bobot+'</td><td id="td_input-'+result.master_checklist[i].numbering+'">'+input_penilaian+'<p id="alert_k3_input-'+result.master_checklist[i].numbering+'" style="display:none;">Score 1-5</p></td><td>'+total_penilaian+'</td></tr>';
                // }

            // $('#tableCeklisReview').html(table_ceklist);

            $('#PreviewEvaluation').modal('toggle');
        }
    });

});

function calculate_eval_k3(id)
{
    var count_question = $('#eval_numbering').val();
    var penilaian_value = $('#'+id).val();
    var id_input = id.slice(-1);
    var bobot = $('#input_bobot-'+id_input).val();

    if (penilaian_value > 5) {
        $('#td_input-'+id_input).css('color', '#fff');
        $('#td_input-'+id_input).css('background', 'red');
        $('#alert_k3_input-'+id_input).show();
    } else {
        $('#td_input-'+id_input).css('color', '');
        $('#td_input-'+id_input).css('background', '');
        $('#alert_k3_input-'+id_input).hide();
    }

    var total = penilaian_value * (bobot/100);
    var roundTotal = total.toFixed(2);

    $('#total_penilaian-'+id_input).val(roundTotal);
    calculate_eval_safety(count_question);
}

function calculate_eval_safety(count_question)
{
    var eval_safety = $('#eval_safety').val();

    if (count_question == 4) {
        var total_1 = parseFloat($('#total_penilaian-1').val());
        var total_2 = parseFloat($('#total_penilaian-2').val());
        var total_3 = parseFloat($('#total_penilaian-3').val());
        var total_4 = parseFloat($('#total_penilaian-4').val());

        var grand_total = parseFloat(total_1 + total_2 + total_3 + total_4);
    
    } else {
        console.log('check count question.');
    }
    
    var safety_value = parseFloat(grand_total).toFixed(2);
    $('#eval_safety').val(safety_value);

}

$("#ebast-approved").click(function (e) {
    e.preventDefault();
    var ReqId = $('#ebast_id').val();
    var ReqNum = $('#request_number').val();

    var timer = setInterval(function () {
        var count = parseInt($('#myTimer').html());
        if (count !== 0) {
            $('#myTimer').html(count - 1);
        } else {
            clearInterval(timer);
            $("#divResendCode").show();
            $("#textTimer").hide();
        }
    }, 1000);

    $.ajax({
        url: "services/authen/verify_ebast",
        type: 'post',
        data: 'id=' + ReqId + '&request_number=' + ReqNum,
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
                    title: '<strong>We need to verify it\'s you.</strong>',
                    icon: 'question',
                    html: '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><b>6 digit code has been sent to your phone number.</b></center><br>' +
                        '<center><b>OTP code valid until this window is closed.</b></center>' +
                        '<center><b>If you do resend and have more than one messages, use the last one.</b></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="d-flex justify-content-center">' +
                        '<div class="col-md-8"></div>' +
                        '<div class="col-md-6">' +
                        '<input class="form-control form-control-lg" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return validateEbastApproved();" maxlength="6" min="1" max="999" id="ebast_code_approved" />' +
                        '</div>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><h6><b>You\'re going to approve</b></h6></center><br>' +
                        '<center><h6><b>' + ReqNum + '</b></h6></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="divResendCode" style="display:none;">' +
                        '<button type="button" class="btn btn-dim btn-sm btn-outline-success" id="btnResendCode"> Resend code</button>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="textTimer" style="display:show;">' +
                        '<div class="d-flex justify-content-center">' +
                        '<center><h6><b>The resend button will be enable in:</b></h6><b><span id="myTimer">45</span></b></center>' +
                        '</div>' +
                        '</div>' +
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
                alert('There\'s something wrong, it might be slow network or expired user session. Please refresh the page and try again');
            }
        }
    });
});

$("#ebast-rejected").click(function (e) {
    e.preventDefault();
    var ReqId = $('#ebast_id').val();
    var ReqNum = $('#request_number').val();

    var timer = setInterval(function () {
        var count = parseInt($('#myTimer').html());
        if (count !== 0) {
            $('#myTimer').html(count - 1);
        } else {
            clearInterval(timer);
            $("#divResendCode").show();
            $("#textTimer").hide();
        }
    }, 1000);

    $.ajax({
        url: "services/authen/verify_ebast",
        type: 'post',
        data: 'id=' + ReqId + '&request_number=' + ReqNum,
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
                    title: '<strong>We need to verify it\'s you.</strong>',
                    icon: 'question',
                    html: '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><b>6 digit code has been sent to your phone number.</b></center><br>' +
                        '<center><b>OTP code valid until this window is closed.</b></center>' +
                        '<center><b>If you do resend and have more than one messages, use the last one.</b></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="d-flex justify-content-center">' +
                        '<div class="col-md-8"></div>' +
                        '<div class="col-md-6">' +
                        '<input class="form-control form-control-lg" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" onKeyUp="if(this.value.length==6) return validateEbastReject();" maxlength="6" min="1" max="999" id="ebast_code_reject" />' +
                        '</div>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<center><h6><b>You\'re going to reject</b></h6></center><br>' +
                        '<center><h6><b>' + ReqNum + '</b></h6></center><br>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="divResendCode" style="display:none;">' +
                        '<button type="button" class="btn btn-dim btn-sm btn-outline-success" id="btnResendCode"> Resend code</button>' +
                        '</div>' +
                        '</div><br>' +
                        '<div class="row">' +
                        '<div class="col-md-12" id="textTimer" style="display:show;">' +
                        '<div class="d-flex justify-content-center">' +
                        '<center><h6><b>The resend button will be enable in:</b></h6><b><span id="myTimer">45</span></b></center>' +
                        '</div>' +
                        '</div>' +
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
                alert('There\'s something wrong, it might be slow network or expired user session. Please refresh the page and try again');
            }
        }
    });
});

function validateEbastApproved() {
    // e.preventDefault();
    var request_id = $('#ebast_id').val();
    var approval_id = $('#approval_id').val();
    var requestor = $('#requestor').val();
    var request_number = $('#request_number').val();
    var otp = $('#ebast_code_approved').val();
    var note = $('textarea#response-notes').val();

    $.ajax({
        url: "services/authen/validate_ebast/Approved",
        type: 'post',
        data: 'id=' + request_id + '&otp=' + otp + '&request_number=' + request_number + '&approval_id=' + approval_id + '&requestor=' + requestor + '&approval_note=' + note,
        dataType: 'json',
        success: function (response) {

            var messages = response.message;

            if (response.status == 1) {

                $('#button_response_panel').hide();
                $('#button_response_panel_success').show();
                $("#status_list-" + request_id).html('<span class="text-success"> Approved</span>');
                $("#status_read-" + request_id).html('<em class="icon ni ni-check-circle-fill" id="is_read-' + request_id + '" style="display: show;"></em>');
                $('#requestStatus').html(response.response);
                $('#ebast_approval_info').html('');

                // Approval Info
                $.each(response.progress, function (i, approver_info) {
                    if (approver_info.approval_status == 'Approved') {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-primary'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                    } else if ((approver_info.approval_status == 'Revised') || (approver_info.approval_status == 'In Progress')) {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-warning'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                    } else if (approver_info.approval_status == 'Rejected') {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-danger'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                    } else {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-light'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");
                    }
                });

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: messages,
                    showConfirmButton: false,
                    timer: 1000
                });

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: messages,
                    showConfirmButton: false,
                    timer: 5000
                });
            }

        },
        error: function (response) {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'There\'s something wrong, it might be slow network or expired user session. Please refresh the page or try again later.',
                showConfirmButton: false,
                timer: 3500
            });
        }
    });
}

function validateEbastReject() {
    // e.preventDefault();
    var request_id = $('#ebast_id').val();
    var approval_id = $('#approval_id').val();
    var requestor = $('#requestor').val();
    var request_number = $('#request_number').val();
    var otp = $('#ebast_code_reject').val();
    var note = $('textarea#response-notes').val();

    $.ajax({
        url: "services/authen/validate_ebast/Rejected",
        type: 'post',
        data: 'id=' + request_id + '&otp=' + otp + '&request_number=' + request_number + '&approval_id=' + approval_id + '&requestor=' + requestor + '&approval_note=' + note,
        dataType: 'json',
        success: function (response) {

            var messages = response.message;

            if (response.status == 1) {

                $('#button_response_panel').hide();
                $('#button_response_panel_success').show();
                $('#requestStatus').html(response.response);
                $('#ebast_approval_info').html('');
                
                $("#status_list-" + request_id).html('<span class="text-danger"> Rejected</span>');
                $("#status_read-" + request_id).html('<em class="icon ni ni-check-circle-fill" id="is_read-' + request_id + '" style="display: show;"></em>');
                
                // Approval Info
                $.each(response.progress, function (i, approver_info) {
                    if (approver_info.approval_status == 'Approved') {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-primary'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                    } else if ((approver_info.approval_status == 'Revised') || (approver_info.approval_status == 'In Progress')) {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-warning'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                    } else if (approver_info.approval_status == 'Rejected') {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-danger'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");

                    } else {
                        $("#ebast_approval_info").append("<li><div class='user-card'><a><div class='user-avatar sm bg-light'><span> " + approver_info.approval_priority + " </span></div><div class='user-name'> " + approver_info.approval_email + " </div><div class='user-role'> " + approver_info.approval_status + " </div></a></div></li>");
                    }
                });

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: messages,
                    showConfirmButton: false,
                    timer: 1000
                });

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: messages,
                    showConfirmButton: false,
                    timer: 5000
                });
            }

        },
        error: function (response) {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'There\'s something wrong, it might be slow network or expired user session. Please refresh the page or try again later.',
                showConfirmButton: false,
                timer: 3500
            });
        }
    });
}

// Helper
function maxLengthCheck(object) {
    if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
}

function isNumeric(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

function rupiah(angka, code = true) {
    
    var rp = (code) ? 'Rp. ' : '';

    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rp +rupiah.split('',rupiah.length-1).reverse().join('');
}

function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
    // rupiah(this.value); 
}


