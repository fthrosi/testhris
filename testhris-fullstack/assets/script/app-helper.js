/* Page Loader */
    $(window).load(function(){
        setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 3000);
    });

/* Back-to-top */
    $(window).scroll(function(){
        $(this).scrollTop()>10?$("#back-to-top").fadeIn():$("#back-to-top").fadeOut()
    }),
    $("#back-to-top").click(function(){
        return $("body,html").animate({scrollTop:0},250),!1
    });

/* Check all and uncheck all table rows */
    $(':checkbox:checked').prop('checked',false);
    $('.table > thead > tr > th:first-child > input[type="checkbox"]').change(function() {
        var check = false;
        if ($(this).is(':checked')) {
            check = true;
        }
        $(this).parents('thead').next().find('tr > td:first-child > input[type="checkbox"]').prop('checked', check);
    })

    $('.table > tbody > tr > td:first-child > input[type="checkbox"]').change(function() {
        var check = false;
        if ($(this).is(':checked')) {
            check = true;
        }
        if (!check) {
            $('.table > thead > tr > th:first-child > input[type="checkbox"]').prop('checked', false);
        }
    });

    $('#checkAll').change(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

// CheckBox Treeview
    $(".acidjs-css3-treeview").delegate("label input:checkbox", "change", function() {
        var
            checkbox = $(this),
            nestedList = checkbox.parent().next().next(),
            selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");
     
        if(checkbox.is(":checked")) {
            return selectNestedListCheckbox.prop("checked", true);
        }
        selectNestedListCheckbox.prop("checked", false);
    });

/* Init Tooltip */
    $('[data-rel=tooltip]').tooltip({
        trigger: "hover",
        html: true
    });

    $('[data-toggle="popover"]').popover({
        container: 'body'
    }); 

/* Initialize toastr
 * Digunakan untuk menampilkan toastr
 */
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

/* Case for button collapse and expand in page */
    $('#buttonC').click(function(){
        $('#buttonC').hide();
        $('#buttonE').show();
    });
    $('#buttonE').click(function(){
        $('#buttonE').hide();
        $('#buttonC').show();
    });

// Custom for feature Materialize // from materialize.js

$(document).ready(function() {

    Materialize = {};

    // Function to update labels of text fields
    Materialize.updateTextFields = function() {
        var input_selector = 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], textarea';
        $(input_selector).each(function(index, element) {
            
            if ($(this).parent().parent().hasClass('form-float')) {

                if ($(element).val().length > 0 || element.autofocus || $(this).attr('placeholder') !== undefined || $(element)[0].validity.badInput === true) {
                    // $(this).siblings('label').addClass('active');
                    $(this).parent('.form-line').addClass('focused');
                }
                else {
                    // $(this).siblings('label').removeClass('active');
                    $(this).parent('.form-line').removeClass('focused');
                }
            }

        });
    };

    // Text based inputs
    var input_selector = 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], textarea';

    // Add active if form auto complete
    $(document).on('change', input_selector, function () {
        if($(this).val().length !== 0 || $(this).attr('placeholder') !== undefined) {
            // $(this).siblings('label').addClass('active');
            $(this).parent('.form-line').addClass('focused');
        }
        // validate_field($(this));
    });

    // Add active if input element has been pre-populated on document ready
    $(document).ready(function() {
        Materialize.updateTextFields();
    });

    // HTML DOM FORM RESET handling
    $(document).on('reset', function(e) {
        var formReset = $(e.target);
        if (formReset.is('form')) {
            formReset.find(input_selector).removeClass('valid').removeClass('invalid');
            formReset.find(input_selector).each(function () {
                if ($(this).attr('value') === '') {
                    $(this).siblings('label').removeClass('active');
                }
            });

            // Reset select
            formReset.find('select.initialized').each(function () {
                var reset_text = formReset.find('option[selected]').text();
                formReset.siblings('input.select-dropdown').val(reset_text);
            });
        }
    });
});


/**
 * Init editTable()
 * Edit list table on click table edit
 * @event onClick
 */

// $('table .editable').editable({
//     edit: function(values) {

//         $(".edit", this)
//             .removeClass('btn-primary')
//             .addClass('btn-success')
//             .attr('title', 'Simpan');

//         $(".edit i", this)
//             .removeClass('fa-pencil')
//             .addClass('fa-check');
//     },
//     save: function(values) {
//         $(".edit", this)
//             .removeClass('btn-success')
//             .addClass('btn-primary')
//             .attr('title', 'Edit');

//         $(".edit i", this)
//             .removeClass('fa-check')
//             .addClass('fa-pencil');

//         var id = $(this).data('id');

//         $.ajax({
//             url: base_url+''+F.uri_segment(0)+'/save_competency/'+id,
//             data: values,
//             type: "POST",
//             dataType: "json",
//             success: function(response){
//                 if (response.status) {
//                     toastr.success('Data berhasil diperbaharui');
//                 }
//                 else {
//                     toastr.error(response.error);
//                 }
                
//                 // console.log(response);
//             }
//         })
        
//     },
//     cancel: function(values) {
//         $(".edit i", this)
//             .removeClass('fa-save')
//             .addClass('fa-pencil')
//             .attr('title', 'Edit');
//     }
// });