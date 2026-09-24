/* Initialize URL Request */

    var F = F || {};

    /* Split an array pathname */
    F.pathname = location.pathname.split('/');

    /**
     * Base URL
     * Create a local URL based on your basepath.
     * Segments can be passed in as a string or an array, same as site_url
     * or a URL to a file can be passed in, e.g. to an image file.
     * @return  string
     */
    F.base_url = function(){
        return base_url;
    }

    /**
     * Current URL
     * Returns the full URL (including segments) of the page where this
     * function is placed
     */
    F.current_url = function(){
        return current_url;
    }

    /**
     * URL String
     * Returns the URI segments.
     * example  : http://domain.com/controller/method/param
     * result   : controller/method/param
     * @return  string
     */
    F.uri_string = function(){
        return uri_string;
    }

    /* 
     * Fetch URI Segment
     * @param   Integer
     * @return  mixed
     */
    F.uri_segment = function(segment) {
        if (typeof segment == 'undefined') {
            throw new Error('Not initialize segment number !');
        } 
        else if (typeof segment != 'number') {
            throw new Error('Segment must be a number !');  
        } 
        else {
            var url = F.current_url().split(F.base_url())[1].split('/');
            return url[segment];
        }
    }

$(document).ready(function(){

/* Initialize jstree
 * Config for list treeview in role user
 */
    if (F.uri_segment(1) == 'role') {

        $('#tree_2').jstree({
            'plugins' : ["checkbox", "types"], //"wholerow"
            'checkbox' : {
                'three_state' : false 
            },
            'core' : {
                "themes" : {
                    "responsive" : false
                },

                'data' : tree_2
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder text-primary"
                }
            }
        }).bind("loaded.jstree", function(event, data) {
            data.instance.open_all();
        });

        $('#getChecked').click(function(){
            var role = $('#tree_2').jstree('get_selected');

            $.confirm({
                title: 'Konfirmasi',
                content: 'Simpan Pengaturan?',
                buttons: {
                    confirm: {
                        text: 'Ya, Simpan',
                        btnClass: 'btn-success',
                        action: function(){
                            $.ajax({
                                type: 'POST',
                                url: $('.myForm').attr('action'),
                                data: 'menu='+role,
                                dataType: 'json',
                                beforeSend: function(){
                                    $('.buttonAct').attr('disabled', true);
                                    $('.buttonText').text(' Processing . . .');
                                },
                                success: function(data) {
                                    toastr.success('Pengaturan tersimpan');
                                    $('.buttonAct').attr('disabled', false);
                                    $('.buttonText').text(' Simpan Pengaturan');
                                }
                            });
                        }
                    },
                    cancel: function(){
                        //$.alert('Canceled!');
                    }
                }
            });
        });
    }

/* For confirm with jquery.confirm
 */
    $('.withConfirm').click(function(){
        var formData = $(this).closest('form').serialize();
        var formAction = $(this).closest('form').attr('action');

        $.confirm({
            title: 'Confirm',
            content: 'Are you sure to continue?',
            buttons: {
                confirm: {
                    text: 'Yes, Process',
                    btnClass: 'btn-success',
                    action: function(){
                        $.ajax({
                            type: 'POST',
                            url: formAction,
                            data: formData,
                            dataType: 'json',
                            beforeSend: function(){
                                $('.buttonAct').attr('disabled', true);
                                $('.buttonText').text(' Processing . . .');
                            },
                            success: function(data) {

                                console.log(data);

                                $('.buttonAct').attr('disabled', false);

                                if ($('.buttonText').attr('value') == undefined) {
                                    $('.buttonText').text( 'Simpan');
                                }
                                else {
                                    $('.buttonText').text($('.buttonText').attr('value'));
                                }

                                if (data.status) {
                                    if (data.redirect) {
                                        window.location = data.redirect;
                                    }
                                    else {
                                        toastr.success('Successfully updated');
                                    }
                                }
                                else {
                                    if (data.error) {
                                        toastr.error(data.error);
                                        console.log(data.error);
                                    }
                                    else {
                                        toastr.error('Data input failed. Check again');
                                    }
                                }

                            }
                        });
                    }
                },
                cancel: function(){
                    //$.alert('Canceled!');
                }
            }
        });
    });

/* Button Ajax */ 
    $('.buttonAjax').click(function(){
        var formData = $(this).closest('form').serialize();
        var formAction = $(this).closest('form').attr('action');

        $.ajax({
            type: 'POST',
            url: formAction,
            data: formData,
            dataType: 'json',
            beforeSend: function(){
                $(this).attr('disabled', true);
            },
            success: function(data) {

                $(this).attr('disabled', false);

                if (data.status) {
                    toastr.success('Data disimpan');
                }
                else {
                    if (data.error) {
                        toastr.error(data.error);
                    }
                    else {
                        toastr.error('Data input failed. Check again');
                    }
                }
            }
        });

    });

/* Initialize jquery.nestable
 * Config for nestable menu
 */
    if (uri_string == 'page/order' || uri_string == 'menu/order') {
        var lastTouched = '';
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if(window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));

                $.post(current_url+'/update', { 
                   'whichnest' : lastTouched, 
                   'output' : output.val() 
                }, 
                function(data) {
                    // console.log(data);
                });

            }
            else {
                output.val('JSON browser support required for this demo.');
            }
        };

        $('#nestable').nestable({
            maxDepth : (uri_string == 'menu/order') ? 2 : 15, 
            group: 1,
            json: nested,
            contentCallback: function(item) {
                var content = item.content || '' ? item.content : item.id;
                // content += ' <i>(id = ' + item.id + ')</i>';

                return content;
            }
        }).on('change', updateOutput);

        // updateOutput($('#nestable').data('output', $('#savedNested')));
        updateOutput($('#nestable').data('output', $('#nestableOutput')));
        
        $('#nestable-menu').on('click', function(e) {
            var target = $(e.target),
                    action = target.data('action');
            if(action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if(action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
    }

/* Initialize status alert */
    function getUrlVars(str) 
    {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
            vars[key] = value;
        });
        return vars[str];
    }

    var status = getUrlVars('status');
    var msg = decodeURI(getUrlVars('msg'));

    if (status != undefined) {

        if (status == 'success') {

            if (msg) {
                var successText = msg;
            }
            else {
                var successText = 'Data tersimpan';
            }

            toastr.success(successText);
            window.history.pushState('success', 'Title', current_url);
        }
        else {
            
            if (msg) {
                var errorText = msg;
            }
            else {
                var errorText = 'Data input failed. Check again';
            }

            toastr.error(errorText);
            window.history.pushState('failed', 'Title', current_url);
        }
    }

/* Initialize table */
    $('.datatable').each(function(){
        var responsiveHelper = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone : 480
        };

        var id    = $(this).attr('id');
        var data  = $(this).attr('data-ajaxsource');

        if (data == undefined) {
            // isNumeric for module user_role
            var dataSource = ($.isNumeric(F.uri_segment(2)) ? 'read/'+F.uri_segment(2) : current_url+'/read');
        }
        else {
            var dataSource = data;
        }

        $('#'+id).DataTable({
            "ajax": {
                "url": dataSource,
                "type": "POST",
                
                error: function(){
                    console.log();
                }
            },

            "processing": true,
            "serverSide": true,

            "columnDefs" : [{
                'targets' : [ 0 ],
                'sortable': false,
                'width': '50px',
                'class'   : 'col-small center'
            }, {
                'targets' : [ 1 ],
                'width': ((F.uri_segment(0) == 'invoice' && F.uri_segment(1) == 'update') ? '' : '50px')
            }, {
                // 'targets' : ((F.uri_segment(1) == 'role') ? [-1, -2, -3, -4] : [-1]),
                'targets' : [-1],
                'sortable': false,
                'width':  ( (F.uri_segment(0) == 'invoice' && F.uri_segment(1) == 'update') ? '170px' : '100px'),
                'class'   : ((F.uri_string() == '' || F.uri_string() == 'dashboard' ) ? '' : 'col-small center')
            }],

            "order": [[ 1, "asc" ]],
            "bPaginate": (( (F.uri_segment(0) == 'setting' && F.uri_segment(1) == '')  || F.uri_segment(1) == 'role') ? false : true),
            "bLengthChange": (( (F.uri_segment(0) == 'setting' && F.uri_segment(1) == '')  || F.uri_segment(1) == 'role') ? false : true),

            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],


            'ordering': ((F.uri_segment(0) == 'invoice' && F.uri_segment(1) == 'update') ? false : true),
            "bInfo": ((F.uri_segment(0) == 'invoice' && F.uri_segment(1) == 'update') ? false : true),
            'bPaginate': ((F.uri_segment(0) == 'invoice' && F.uri_segment(1) == 'update') ? false : true),
            'bFilter': ((F.uri_segment(0) == 'invoice' && F.uri_segment(1) == 'update') ? false : true),
            "autoWidth"   : false,

            preDrawCallback: function(){
                if (!responsiveHelper) {
                    responsiveHelper = new ResponsiveDatatablesHelper($('#'+id), breakpointDefinition);
                }
            },
            rowCallback    : function(nRow) {
                responsiveHelper.createExpandIcon(nRow);
            },
            drawCallback   : function(oSettings) {
                responsiveHelper.respond();
            }
        });
    });

/* Initialize Select2 */
    $(".e2").select2();
    $(".e2-nosearch").select2({
        minimumResultsForSearch: -1
    });
    $(".e2-tag").select2({
        tags: true,
        tokenSeparators: [',']
    });

/* Reset value on modal hide */
    $('.modal').on('hidden.bs.modal', function(){
        $('.modal-dialog').removeClass('modal-lg');
        $('.modalTitle').text('');
        $('.showForm').html('');
        $('.showForm :input').val('');
    });

/* Get default on show modal */
    $('.modal').on('shown.bs.modal', function(){
        Materialize.updateTextFields();
        $(this).find('[autofocus]').focus();
    });

});

/* Function is_parent
 * Condition check for redirect button in 'page'
 * Call in showModal clicked
 */
    function isParent() {
        $('#is_parent').change(function(){
            if ( $('#is_parent').val() == 'N' ) {
                $('.buttonAct').attr('id', 'buttonHref');
                $('#div_parent').show();
                $('#parent').attr('required', true);
            }
            else {
                $('.buttonAct').attr('id', 'buttonAjax');
                $('#div_parent').hide();
                $('#parent').attr('required', false);
            }
        });
    }

/* Class showModal
 * @event   onClick
 * Digunakan pada class button show, create, update untuk menampilkan modal crud
 */
    $(document).on('click', '.showModal', function(){
        modalTitle = $(this).attr('data-modal-title');
        modalSize = $(this).attr('data-modal-size');
        $.ajax({
            url: $(this).attr('data-href'),
            dataType: 'html',
            success:function(data) {
                $('.modalTitle').html(modalTitle);
                $('.modal-dialog').addClass(modalSize);
                $('.showForm').html(data);
                $(".select").selectpicker();
                $(".e2").select2();
                $('.e2-nosearch').select2({
                    minimumResultsForSearch: -1
                });
                // $.AdminBSB.input.activate();
                isParent();

                $(".datepicker").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });

            }
        });   
    });

/* Function save
 * @event   onClick
 * Digunakan untuk simpan dan ubah data pada modal
 */
    function save()
    {
        var selector = $('.buttonAct');
        var action   = $('.myForm').attr('action');
        var method   = $('.myForm').attr('method');
        var formData = $('.myForm').serialize();

        isValidate();

        $('.myForm').ajaxForm({
            url: action,
            type: method,
            data: formData,
            cache: false,
            dataType: "json",
            beforeSend: function(){
                console.log(formData);
                
                $('.buttonAct').attr('disabled', true);
                $('.buttonText').text(' Processing . . .');
            },
            success:function(data) {
                toastr.clear();
                $('.buttonAct').attr('disabled', false);
                if ($('.buttonText').attr('value')) {
                    $('.buttonText').text($('.buttonText').attr('value'));
                }
                else {
                    $('.buttonText').text(' Simpan');
                }
                
                if (data.status) {
                    $('#crudModal').modal('hide');

                    if ($('.buttonAct').attr('id') == 'buttonHref') {
                        window.location = data.redirect;
                    }
                    else {
                        $('.datatable').DataTable().ajax.reload(null, false);
                        $('.tableTCx').DataTable().ajax.reload(null, false);
                        toastr.success(selector.attr('data-message-success'));
                    }
                }
                else {
                    if (data.error) {
                        toastr.error(data.error);
                        console.log(data.error);
                    }
                    else {
                        toastr.error('Data input failed. Check again');
                    }
                }
            },
        });
    }

/* Function deleteAll - jquery.confirm
 * Delete list table on checkbox table checked
 * @event onClick
 */
    function deleteAll(url)
    {
        checked = new Array();
        i = 0;
        $('input#checkbox:checked').each(function(){
            checked[i] = $(this).val();
            i++;
        });
        
        if (checked.length > 0) {
            $.confirm({
                title: 'Delete',
                content: 'The selected data will be deleted?',
                buttons: {
                    confirm: {
                        text: 'Yes, Delete',
                        btnClass: 'btn-red',
                        action: function(){
                            $.ajax({
                                type : 'POST',
                                url: url+'/delete',
                                data : 'id='+checked,
                                dataType: 'json',
                                beforeSend: function(){
                                    // $('.panel-refresh').click();
                                },
                                success: function(data) {
                                    if (data.status) {
                                        $('.datatable').DataTable().ajax.reload(null, false);
                                        toastr.success('Successfully removed');
                                    }
                                    else {
                                        if (data.error) {
                                            toastr.error(data.error);
                                        }
                                        else {
                                            toastr.error('Failed to delete data');
                                        }
                                    }
                                }
                            });
                        }
                    },
                    cancel: function(){
                        //$.alert('Canceled!');
                    }
                }
            });
        }
        else {
            toastr.error('No data selected');
        }
    }

/* Function deleteOne - jquery.confirm
 * @event onClick
 */
    function deleteOne(url)
    {
        $.confirm({
            bgOpacity: 0.5,
            title: 'Delete Data',
            content: 'Are you sure to continue?',
            buttons: {
                confirm: {
                    text: 'Yes, Delete',
                    btnClass: 'btn-red',
                    action: function(){
                        $.ajax({
                            type : 'POST',
                            url: url,
                            dataType: 'json',
                            beforeSend: function(){
                                // alert(file);
                            },
                            success: function(data) {
                                if (data.status) {        

                                    console.log(data);

                                    $('.datatable').DataTable().ajax.reload(null, false);
                                    $('#tableTCx').DataTable().ajax.reload(null, false);

                                    if (F.uri_segment(0) == "ca" ) 
                                    {
                                        $('#amount_subtotal_tb').text(parseInt(data.data));
                                        $('#subtotal').val(rupiah(data.data));
                                    }

                                    if (F.uri_segment(0) == "settlement" ) 
                                    {
                                        $('#amount_subtotal_tb').text(parseInt(data.data));
                                        $('#subtotal_settlement').val(rupiah(data.data));
                                    }

                                    if (F.uri_segment(0) == "reimburse" ) 
                                    {
                                        $('#amount_subtotal_tb').text(parseInt(data.data));
                                        $('#subtotal').val(rupiah(data.data));
                                    }

                                    toastr.success('Successfully removed');
                                }
                                else {
                                    toastr.error('Removed Data Failed');
                                }
                            }
                        });
                    }
                },
                cancel: function(){
                    //$.alert('Canceled!');
                }
            }
        });
    }

/* Function isValidate
 * Digunakan untuk validasi seluruh form input pada class myForm
 */
    function isValidate() 
    {

        $.validator.addMethod('decimal', function(value, element) {
            return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
        }, "Please enter a correct number, format 0.0");

        $(".myForm").validate({
            rules: {
                user_password: {
                    minlength:8,
                },
                re_password: {
                    equalTo: "#user_password"
                },
                value_percent: {
                    required: true,
                    decimal: true
                }
            },

            // For Materialize 

            // highlight: function (input) {
            //     $(input).parents('.form-group').addClass('has-error');
            //     $('.select2-selection', '.has-error').css('border', '1px solid #DD4B39');
            // },
            // unhighlight: function (input) {
            //     $(input).parents('.form-group').removeClass('has-error');
            // },
            // errorPlacement: function (error, element) {
            //     $(element).parents('.form-group').append(error);
            // },

            // errorElement: 'label',
            // errorClass: 'error'

            // For Bootstrap 

            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
                $('.select2-selection', '.has-error').css('border', '1px solid #DD4B39');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('select2-hidden-accessible')) {
                    error.insertAfter(element.closest('.has-error').find('.select2'));
                } else if (element.parent('.input-group').length) { 
                    error.insertAfter(element.parent());
                } else {                                      
                    error.insertAfter(element);
                }
            },

            errorElement: 'p',
            errorClass: 'help-block'

        });
    }


// Not Used

/* ValidateImage
 * @function validateFileExtension
 * @function validateFileSize
 * Digunakan pada function imageForm()
 */
    function validateFileExtension(component, msg_id, msg, extns)
    {
        var flag = 0;
        with (component)
        {
            var ext = value.substring(value.lastIndexOf('.') + 1);
            if (ext) {
                for (i = 0; i < extns.length; i++)
                {
                    if (ext == extns[i])
                    {
                        flag = 0;
                        break;
                    }
                    else
                    {
                        flag = 1;
                    }
                }
                if (flag != 0)
                {
                    document.getElementById(msg_id).innerHTML = msg;
                    component.value = "";
                    component.focus();

                    $(component).closest('.parent').addClass('has-error');

                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }

    function validateFileSize(component, maxSize, msg_id, msg)
    {
        if (navigator.appName == "Microsoft Internet Explorer")
        {
            if (component.value)
            {
                var oas = new ActiveXObject("Scripting.FileSystemObject");
                var e = oas.getFile(component.value);
                var size = e.size;
            }
        }
        else
        {
            if (component.files[0] != undefined)
            {
                size = component.files[0].size;
            }
        }
        if (size != undefined && size > maxSize)
        {
            document.getElementById(msg_id).innerHTML = msg;
            component.value = "";
            component.style.backgroundColor = "#eab1b1";
            component.style.border = "thin solid #000000";
            component.focus();
            return false;
        }
        else
        {
            return true;
        }
    }

/* Function imageUpload with ajaxupload.3.5.js (Single Upload)
 * Upload file with ajax request
 * @btnUpload = button on click
 * @divImage  = tag <div> for position image replace
 * @appendTo  = append new image in <div> in <div @divImage>  
 */
    function imageUpload(btnUpload, divImage, appendTo) 
    {
        var button      = $('.'+btnUpload);
        var divImage    = $('#'+divImage);
        
        var action      = $(button).attr('dataAction');
        var imageSource = $(button).attr('imageSource');
        var selector    = $('#'+btnUpload);
        var explode     = appendTo.split(' ');

        new AjaxUpload(button, {
            action: action,
            name: 'uploadfile',
            onSubmit: function(file, ext) {
                if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    toastr.warning( 'Type file tidak didukung', 'Warning' );
                    return false;
                }
                //toastr.info( 'Mengunggah file', 'Uploading . . .' );
            },
            onComplete: function(file, response){
                $('.'+explode[1]).remove();
                if (response != 0) {
                    selector.val(response);
                    toastr.success( 'Upload berhasil', 'Success' );
                    $('<div></div>').appendTo(divImage).html('<img src="'+imageSource+'/'+data+'" />').addClass(appendTo);
                }
                else {
                    selector.val('');
                    toastr.error( 'Gagal mengupload file', 'Terjadi Kesalahan' );
                }
            }
        });
    }

