"use strict";

!function (NioApp, $) {
  "use strict";

  NioApp.Package.name = "DashLite";
  NioApp.Package.version = "2.3";
  var $win = $(window),
    $body = $('body'),
    $doc = $(document),
    //class names
    _body_theme = 'nio-theme',
    _menu = 'nk-menu',
    _mobile_nav = 'mobile-menu',
    _header = 'nk-header',
    _header_menu = 'nk-header-menu',
    _sidebar = 'nk-sidebar',
    _sidebar_mob = 'nk-sidebar-mobile',
    _app_sidebar = 'nk-apps-sidebar',
    //breakpoints
    _break = NioApp.Break;

  function extend(obj, ext) {
    Object.keys(ext).forEach(function (key) {
      obj[key] = ext[key];
    });
    return obj;
  } // ClassInit @v1.0


  NioApp.ClassBody = function () {
    NioApp.AddInBody(_sidebar);
    NioApp.AddInBody(_app_sidebar);
  }; // ClassInit @v1.0


  NioApp.ClassNavMenu = function () {
    NioApp.BreakClass('.' + _header_menu, _break.lg, {
      timeOut: 0
    });
    NioApp.BreakClass('.' + _sidebar, _break.lg, {
      timeOut: 0,
      classAdd: _sidebar_mob
    });
    $win.on('resize', function () {
      NioApp.BreakClass('.' + _header_menu, _break.lg);
      NioApp.BreakClass('.' + _sidebar, _break.lg, {
        classAdd: _sidebar_mob
      });
    });
  }; // Code Prettify @v1.0


  NioApp.Prettify = function () {
    window.prettyPrint && prettyPrint();
  }; // Copied @v1.0


  NioApp.Copied = function () {
    var clip = '.clipboard-init',
      target = '.clipboard-text',
      sclass = 'clipboard-success',
      eclass = 'clipboard-error'; // Feedback

    function feedback(el, state) {
      var $elm = $(el),
        $elp = $elm.parent(),
        copy = {
          text: 'Copy',
          done: 'Copied',
          fail: 'Failed'
        },
        data = {
          text: $elm.data('clip-text'),
          done: $elm.data('clip-success'),
          fail: $elm.data('clip-error')
        };
      copy.text = data.text ? data.text : copy.text;
      copy.done = data.done ? data.done : copy.done;
      copy.fail = data.fail ? data.fail : copy.fail;
      var copytext = state === 'success' ? copy.done : copy.fail,
        addclass = state === 'success' ? sclass : eclass;
      $elp.addClass(addclass).find(target).html(copytext);
      setTimeout(function () {
        $elp.removeClass(sclass + ' ' + eclass).find(target).html(copy.text).blur();
        $elp.find('input').blur();
      }, 2000);
    } // Init ClipboardJS


    if (ClipboardJS.isSupported()) {
      var clipboard = new ClipboardJS(clip);
      clipboard.on('success', function (e) {
        feedback(e.trigger, 'success');
        e.clearSelection();
      }).on('error', function (e) {
        feedback(e.trigger, 'error');
      });
    } else {
      $(clip).css('display', 'none');
    }

    ;
  }; // CurrentLink Detect @v1.0


  NioApp.CurrentLink = function () {
    var _link = '.nk-menu-link, .menu-link, .nav-link',
      _currentURL = window.location.href,
      fileName = _currentURL.substring(0, _currentURL.indexOf("#") == -1 ? _currentURL.length : _currentURL.indexOf("#")),
      fileName = fileName.substring(0, fileName.indexOf("?") == -1 ? fileName.length : fileName.indexOf("?"));

    $(_link).each(function () {
      var self = $(this),
        _self_link = self.attr('href');

      if (fileName.match(_self_link)) {
        self.closest("li").addClass('active current-page').parents().closest("li").addClass("active current-page");
        self.closest("li").children('.nk-menu-sub').css('display', 'block');
        self.parents().closest("li").children('.nk-menu-sub').css('display', 'block');
      } else {
        self.closest("li").removeClass('active current-page').parents().closest("li:not(.current-page)").removeClass("active");
      }
    });
  }; // PasswordSwitch @v1.0


  NioApp.PassSwitch = function () {
    NioApp.Passcode('.passcode-switch');
  }; // Toastr Message @v1.0 


  NioApp.Toast = function (msg, ttype, opt) {
    var ttype = ttype ? ttype : 'info',
      msi = '',
      ticon = ttype === 'info' ? 'ni ni-info-fill' : ttype === 'success' ? 'ni ni-check-circle-fill' : ttype === 'error' ? 'ni ni-cross-circle-fill' : ttype === 'warning' ? 'ni ni-alert-fill' : '',
      def = {
        position: 'bottom-right',
        ui: '',
        icon: 'auto',
        clear: false
      },
      attr = opt ? extend(def, opt) : def;
    attr.position = attr.position ? 'toast-' + attr.position : 'toast-bottom-right';
    attr.icon = attr.icon === 'auto' ? ticon : attr.icon ? attr.icon : '';
    attr.ui = attr.ui ? ' ' + attr.ui : '';
    msi = attr.icon !== '' ? '<span class="toastr-icon"><em class="icon ' + attr.icon + '"></em></span>' : '', msg = msg !== '' ? msi + '<div class="toastr-text">' + msg + '</div>' : '';

    if (msg !== "") {
      if (attr.clear === true) {
        toastr.clear();
      }

      var option = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": attr.position + attr.ui,
        "closeHtml": '<span class="btn-trigger">Close</span>',
        "preventDuplicates": true,
        "showDuration": "1500",
        "hideDuration": "1500",
        "timeOut": "2000",
        "toastClass": "toastr",
        "extendedTimeOut": "3000"
      };
      toastr.options = extend(option, attr);
      toastr[ttype](msg);
    }
  }; // Toggle Screen @v1.0


  NioApp.TGL.screen = function (elm) {
    if ($(elm).exists()) {
      $(elm).each(function () {
        var ssize = $(this).data('toggle-screen');

        if (ssize) {
          $(this).addClass('toggle-screen-' + ssize);
        }
      });
    }
  }; // Toggle Content @v1.0


  NioApp.TGL.content = function (elm, opt) {
    var toggle = elm ? elm : '.toggle',
      $toggle = $(toggle),
      $contentD = $('[data-content]'),
      toggleBreak = true,
      toggleCurrent = false,
      def = {
        active: 'active',
        content: 'content-active',
        "break": toggleBreak
      },
      attr = opt ? extend(def, opt) : def;
    NioApp.TGL.screen($contentD);
    $toggle.on('click', function (e) {
      toggleCurrent = this;
      NioApp.Toggle.trigger($(this).data('target'), attr);
      e.preventDefault();
    });
    $doc.on('mouseup', function (e) {
      if (toggleCurrent) {
        var $toggleCurrent = $(toggleCurrent),
          $s2c = $('.select2-container'),
          $dpd = $('.datepicker-dropdown'),
          $tpc = $('.ui-timepicker-container');

        if (!$toggleCurrent.is(e.target) && $toggleCurrent.has(e.target).length === 0 && !$contentD.is(e.target) && $contentD.has(e.target).length === 0 && !$s2c.is(e.target) && $s2c.has(e.target).length === 0 && !$dpd.is(e.target) && $dpd.has(e.target).length === 0 && !$tpc.is(e.target) && $tpc.has(e.target).length === 0) {
          NioApp.Toggle.removed($toggleCurrent.data('target'), attr);
          toggleCurrent = false;
        }
      }
    });
    $win.on('resize', function () {
      $contentD.each(function () {
        var content = $(this).data('content'),
          ssize = $(this).data('toggle-screen'),
          toggleBreak = _break[ssize];

        if (NioApp.Win.width > toggleBreak) {
          NioApp.Toggle.removed(content, attr);
        }
      });
    });
  }; // ToggleExpand @v1.0


  NioApp.TGL.expand = function (elm, opt) {
    var toggle = elm ? elm : '.expand',
      def = {
        toggle: true
      },
      attr = opt ? extend(def, opt) : def;
    $(toggle).on('click', function (e) {
      NioApp.Toggle.trigger($(this).data('target'), attr);
      e.preventDefault();
    });
  }; // Dropdown Menu @v1.0


  NioApp.TGL.ddmenu = function (elm, opt) {
    var imenu = elm ? elm : '.nk-menu-toggle',
      def = {
        active: 'active',
        self: 'nk-menu-toggle',
        child: 'nk-menu-sub'
      },
      attr = opt ? extend(def, opt) : def;
    $(imenu).on('click', function (e) {
      if (NioApp.Win.width < _break.lg || $(this).parents().hasClass(_sidebar)) {
        NioApp.Toggle.dropMenu($(this), attr);
      }

      e.preventDefault();
    });
  }; // Show Menu @v1.0


  NioApp.TGL.showmenu = function (elm, opt) {
    var toggle = elm ? elm : '.nk-nav-toggle',
      $toggle = $(toggle),
      $contentD = $('[data-content]'),
      toggleBreak = $contentD.hasClass(_header_menu) ? _break.lg : _break.xl,
      toggleOlay = _sidebar + '-overlay',
      toggleClose = {
        profile: true,
        menu: false
      },
      def = {
        active: 'toggle-active',
        content: _sidebar + '-active',
        body: 'nav-shown',
        overlay: toggleOlay,
        "break": toggleBreak,
        close: toggleClose
      },
      attr = opt ? extend(def, opt) : def;
    $toggle.on('click', function (e) {
      NioApp.Toggle.trigger($(this).data('target'), attr);
      e.preventDefault();
    });
    $doc.on('mouseup', function (e) {
      if (!$toggle.is(e.target) && $toggle.has(e.target).length === 0 && !$contentD.is(e.target) && $contentD.has(e.target).length === 0 && NioApp.Win.width < toggleBreak) {
        NioApp.Toggle.removed($toggle.data('target'), attr);
      }
    });
    $win.on('resize', function () {
      if (NioApp.Win.width < _break.xl || NioApp.Win.width < toggleBreak) {
        NioApp.Toggle.removed($toggle.data('target'), attr);
      }
    });
  }; // Animate FormSearch @v1.0


  NioApp.Ani.formSearch = function (elm, opt) {
    var def = {
      active: 'active',
      timeout: 400,
      target: '[data-search]'
    },
      attr = opt ? extend(def, opt) : def;
    var $elem = $(elm),
      $target = $(attr.target);

    if ($elem.exists()) {
      $elem.on('click', function (e) {
        e.preventDefault();
        var $self = $(this),
          the_target = $self.data('target'),
          $self_st = $('[data-search=' + the_target + ']'),
          $self_tg = $('[data-target=' + the_target + ']');

        if (!$self_st.hasClass(attr.active)) {
          $self_tg.add($self_st).addClass(attr.active);
          $self_st.find('input').focus();
        } else {
          $self_tg.add($self_st).removeClass(attr.active);
          setTimeout(function () {
            $self_st.find('input').val('');
          }, attr.timeout);
        }
      });
      $doc.on({
        keyup: function keyup(e) {
          if (e.key === "Escape") {
            $elem.add($target).removeClass(attr.active);
          }
        },
        mouseup: function mouseup(e) {
          if (!$target.find('input').val() && !$target.is(e.target) && $target.has(e.target).length === 0 && !$elem.is(e.target) && $elem.has(e.target).length === 0) {
            $elem.add($target).removeClass(attr.active);
          }
        }
      });
    }
  }; // Animate FormElement @v1.0


  NioApp.Ani.formElm = function (elm, opt) {
    var def = {
      focus: 'focused'
    },
      attr = opt ? extend(def, opt) : def;

    if ($(elm).exists()) {
      $(elm).each(function () {
        var $self = $(this);

        if ($self.val()) {
          $self.parent().addClass(attr.focus);
        }

        $self.on({
          focus: function focus() {
            $self.parent().addClass(attr.focus);
          },
          blur: function blur() {
            if (!$self.val()) {
              $self.parent().removeClass(attr.focus);
            }
          }
        });
      });
    }
  }; // Form Validate @v1.0


  NioApp.Validate = function (elm, opt) {
    if ($(elm).exists()) {
      $(elm).each(function () {
        var def = {
          errorElement: "span"
        },
          attr = opt ? extend(def, opt) : def;
        $(this).validate(attr);
      });
    }
  };

  NioApp.Validate.init = function () {
    NioApp.Validate('.form-validate', {
      errorElement: "span",
      errorClass: "invalid",
      errorPlacement: function errorPlacement(error, element) {
        if (element.parents().hasClass('input-group')) {
          error.appendTo(element.parent().parent());
        } else {
          error.appendTo(element.parent());
        }
      }
    });
  };

  // Dropzone @v1.1
  NioApp.Dropzone = function (elm, opt) {
    if ($(elm).exists()) {
      $(elm).each(function () {
        var maxFiles = $(elm).data('max-files'),
          maxFiles = maxFiles ? maxFiles : null;
        var maxFileSize = $(elm).data('max-file-size'),
          maxFileSize = maxFileSize ? maxFileSize : 256;
        var acceptedFiles = $(elm).data('accepted-files'),
          acceptedFiles = acceptedFiles ? acceptedFiles : null;
        var def = {
          autoDiscover: false,
          maxFiles: maxFiles,
          maxFilesize: maxFileSize,
          acceptedFiles: acceptedFiles
        },
          attr = opt ? extend(def, opt) : def;
        $(this).addClass('dropzone').dropzone(attr);
      });
    }
  }; // Dropzone Init @v1.0


  // // Dropzone Init @v1.0
  NioApp.Dropzone.init = function () {

    var request_number = $('#request_number').val();
    var upload_zone = $('#upload_zone').val();
    var table_id = '#table_documents_eapp';

    NioApp.Dropzone('.upload-zone', {
      url: "form/upload_documents/eapp/" + request_number,
      addRemoveLinks: true,
      init: function () {
        this.on("success", function (file, responseText) {
          this.removeFile(file);
          $(table_id).DataTable().ajax.reload();
        });
      }
    });
  };  // Wizard @v1.0


  NioApp.Wizard = function () {
    var $wizard = $(".nk-wizard").show();
    $wizard.steps({
      headerTag: ".nk-wizard-head",
      bodyTag: ".nk-wizard-content",
      labels: {
        finish: "Submit",
        next: "Next",
        previous: "Prev",
        loading: "Loading ..."
      },
      onStepChanging: function onStepChanging(event, currentIndex, newIndex) {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex) {
          return true;
        } // Needed in some cases if the user went back (clean up)


        if (currentIndex < newIndex) {
          // To remove error styles
          $wizard.find(".body:eq(" + newIndex + ") label.error").remove();
          $wizard.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }

        $wizard.validate().settings.ignore = ":disabled,:hidden";
        return $wizard.valid();
      },
      onFinishing: function onFinishing(event, currentIndex) {
        $wizard.validate().settings.ignore = ":disabled";
        return $wizard.valid();
      },
      onFinished: function onFinished(event, currentIndex) {
        window.location.href = "#";
      }
    }).validate({
      errorElement: "span",
      errorClass: "invalid",
      errorPlacement: function errorPlacement(error, element) {
        error.appendTo(element.parent());
      }
    });
  }; // DataTable @1.1


  NioApp.DataTable = function (elm, opt) {
    if ($(elm).exists()) {
      $(elm).each(function () {
        var id = $(this).attr('id');
        var data = $(this).attr('data-ajaxsource');

        var auto_responsive = $(this).data('auto-responsive'),
          has_export = typeof opt.buttons !== 'undefined' && opt.buttons ? true : false;
        var export_title = $(this).data('export-title') ? $(this).data('export-title') : 'Export';
        var btn = has_export ? '<"dt-export-buttons d-flex align-center"<"dt-export-title d-none d-md-inline-block">B>' : '',
          btn_cls = has_export ? ' with-export' : '';
        var dom_normal = '<"row justify-between g-2' + btn_cls + '"<"col-7 col-sm-4 text-left"f><"col-5 col-sm-8 text-right"<"datatable-filter"<"d-flex justify-content-end g-2"' + btn + 'l>>>><"datatable-wrap my-3"t><"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-left text-md-right"i>>';
        var dom_separate = '<"row justify-between g-2' + btn_cls + '"<"col-7 col-sm-4 text-left"f><"col-5 col-sm-8 text-right"<"datatable-filter"<"d-flex justify-content-end g-2"' + btn + 'l>>>><"my-3"t><"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-left text-md-right"i>>';
        var dom = $(this).hasClass('is-separate') ? dom_separate : dom_normal;
        var def = {
          ajax: {
            url: data,
            type: 'POST',
          },
          responsive: true,
          autoWidth: false,
          dom: dom,
          language: {
            search: "",
            searchPlaceholder: "Type in to Search",
            lengthMenu: "<span class='d-none d-sm-inline-block'>Show</span><div class='form-control-select'> _MENU_ </div>",
            info: "_START_ -_END_ of _TOTAL_",
            infoEmpty: "No records found",
            infoFiltered: "( Total _MAX_  )",
            paginate: {
              "first": "First",
              "last": "Last",
              "next": "Next",
              "previous": "Prev"
            }
          }
        },
          attr = opt ? extend(def, opt) : def;
        attr = auto_responsive === false ? extend(attr, {
          responsive: false
        }) : attr;
        $(this).DataTable(attr);
        $('.dt-export-title').text(export_title);
      });
    }
  }; // DataTable Init @v1.0


  NioApp.DataTable.init = function () {
    NioApp.DataTable('.datatable-init', {
      responsive: {
        details: true
      }
    });

    NioApp.DataTable('.datatable-init-export', {
      responsive: {
        details: true
      },
      columnDefs: [
        { 'visible': false, 'targets': [0, 2, 3, 5, 7, 8, 11, 12, 13] }
      ],
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.tableDashboard', {
      // responsive: {
      //   details: true
      // },
      scrollX: true,
      columnDefs: [
        { 'visible': false, 'targets': [3, 9] }
      ],
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.table_documents_eapp', {
      responsive: {
        details: true
      },
      lengthChange: false, bFilter: false, bInfo: false, paging: false,
    });

    NioApp.DataTable('.hrd-table', {
      responsive: {
        details: true
      },
      columnDefs: [
        { 'visible': false, 'targets': [3, 5, 6, 7, 8, 9, 12, 13, 14, 15] }
      ],
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('#table_lpd_detail', {
      responsive: {
        details: true
      },
      // order: [[ 0, "desc" ]],
      columnDefs: [
        // { 'visible': false, 'targets': [0] }
      ],
      lengthChange: false, bFilter: false, bInfo: false, paging: false,
    });

    NioApp.DataTable(".list_div-table", {
      responsive: {
        details: true,
      },
      buttons: ["copy", "excel"],
    });

    NioApp.DataTable(".list_div_dir-table", {
      responsive: {
        details: true,
      },
      buttons: ["copy", "excel"],
      order: [2, 'asc']
    });

    NioApp.DataTable('.employee-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.dashboard_employee-table', {
      responsive: {
        details: true
      },
      order: [0, 'desc']
    });

    NioApp.DataTable('.family-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.pagu_rawat_jalan-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.pagu_rawat_inap-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.pagu_maternity-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.pagu_kacamata-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.grandparent-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.parent-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.child-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.e_kuitansi-table', {
      responsive: {
        details: true
      },
      order: [1, 'DESC']
    });

    NioApp.DataTable('.ToR-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']

    });

    NioApp.DataTable('.users-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });
    ////////////////////////////PA 2024//////////////////////////////
    NioApp.DataTable('.mulDiv-table', {
      responsive: {
        details: true
      },
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable('.m-table', {
      responsive: {
        details: true
      },
      columnDefs: [
        { 'visible': false, 'targets': [] }
      ],
      order: [[4, "desc"]],
      buttons: ['copy', 'excel']
    });

    NioApp.DataTable(".score-pa", {
      responsive: {
        details: false,
      },
      lengthChange: false,
      bFilter: false,
      bInfo: false,
      paging: false,
    });

    NioApp.DataTable(".tableDashboardNinebox", {
      responsive: {
        details: true,
      },
      buttons: ["copy", "excel"],
    });

    NioApp.DataTable(".tableTraining", {
      responsive: {
        details: true,
      },
      buttons: ["copy", "excel"],
    });

    ////////////////////////////////////////PA 2024///////////////////////////

    /////////////////////////////////////START Time Management DataTable 2024/////////////////////////////////////////
    NioApp.DataTable(".time_off-table", {
      responsive: {
        details: true,
      },
      columnDefs: [
        {
          defaultContent: " ",
          targets: "_all",
        },
      ],
      order: [
        [0, "asc"],
        [2, "asc"],
      ],
      buttons: ["copy", "excel"],
    });

    NioApp.DataTable(".request_time_off-table", {
      responsive: {
        details: true,
      },
      scrollX: true,
      columnDefs: [
        {
          defaultContent: " ",
          targets: "_all",
        },
      ],
    });

    //TIME MANAGEMENT 2.0
    NioApp.DataTable('.request_adjustment-table', {
      responsive: {
        details: true
      },
      columnDefs: [{
        "defaultContent": " ",
        "targets": "_all"
      }],
    });

    NioApp.DataTable(".dws_to_info-table", {
      responsive: {
        details: true,
      },
      ordering: false,
      buttons: ["copy", "excel"],
    });
    //////////////////////

    NioApp.DataTable(".schedule-table", {
      responsive: {
        details: true,
      },
      columnDefs: [
        {
          defaultContent: " ",
          targets: "_all",
        },
      ],
      order: [
        [0, "asc"],
        [2, "asc"],
      ],
      buttons: ["copy", "excel"],
    });

    NioApp.DataTable(".balance_log-table", {
      responsive: {
        details: true,
      },
      scrollX: true,
      columnDefs: [
        {
          defaultContent: " ",
          targets: "_all",
        },
      ],
      order: [[0, "desc"]],
      buttons: ["copy", "excel"],
    });

    NioApp.DataTable(".attendance-table", {
      responsive: {
        details: true,
      },
      scrollX: true,
      columnDefs: [
        {
          defaultContent: " ",
          targets: "_all",
        },
      ],
      pageLength: 100,
      lengthMenu: [
        [50, 100, 200, 500],
        [50, 100, 200, 500],
      ],
      order: [
        [0, "asc"],
        [2, "desc"],
      ],
      buttons: ["copy", "excel"],
    });

    NioApp.DataTable(".tm_report-table", {
      responsive: {
        details: true,
      },
      columnDefs: [
        {
          defaultContent: " ",
          targets: "_all",
        },
      ],
      order: [[0, "asc"]],
      buttons: ["copy", "excel"],
    });

    //TIME MANAGEMENT 2.0
    NioApp.DataTable('.shift_schedule-table', {
      responsive: false,
      dom: "<'row'<'col-sm-6'B><'col-sm-6 text-right'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4 text-left'l>>" +
        "<'row'<'col-sm-8 text-right'p>>" +
        "<'row'<'col-sm-2'i>>",
      columnDefs: [{
        "defaultContent": " ",
        "targets": "_all"
      }],
      order: [[0, 'asc']],
      buttons: ['copy', 'excel'],
      scrollY: '50vh',
      scrollX: true,
      paging: false
    });

    NioApp.DataTable('.holiday_schedule-table', {
      responsive: false,
      dom: "<'row'<'col-sm-6'B><'col-sm-6 text-right'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4 text-left'l>>" +
        "<'row'<'col-sm-8 text-right'p>>" +
        "<'row'<'col-sm-2'i>>",
      columnDefs: [{
        "defaultContent": " ",
        "targets": "_all"
      }],
      order: [[0, 'asc']],
      buttons: ['copy', 'excel'],
      scrollX: true,
      paging: false
    });

    // START CR 2 TM
    NioApp.DataTable(".employee_shift-table", {
      responsive: {
        details: true,
      },
      columnDefs: [
        {
          defaultContent: " ",
          targets: "_all",
        },
      ],
      lengthMenu: [
        [5, 10, 20, 50],
        [5, 10, 20, 50],
      ],
      order: [[0, 'asc']],
      buttons: ["copy", "excel"],
    });
    /////////////////////////////////////END Time Management DataTable 2024/////////////////////////////////////////
    $.fn.DataTable.ext.pager.numbers_length = 7;
  }; // BootStrap Extended


  NioApp.BS.ddfix = function (elm, exc) {
    var dd = elm ? elm : '.dropdown-menu',
      ex = exc ? exc : 'a:not(.clickable), button:not(.clickable), a:not(.clickable) *, button:not(.clickable) *';
    $(dd).on('click', function (e) {
      if (!$(e.target).is(ex)) {
        e.stopPropagation();
        return;
      }
    });

    if (NioApp.State.isRTL) {
      var $dMenu = $('.dropdown-menu');
      $dMenu.each(function () {
        var $self = $(this);

        if ($self.hasClass('dropdown-menu-right') && !$self.hasClass('dropdown-menu-center')) {
          $self.prev('[data-toggle="dropdown"]').dropdown({
            popperConfig: {
              placement: 'bottom-start'
            }
          });
        } else if (!$self.hasClass('dropdown-menu-right') && !$self.hasClass('dropdown-menu-center')) {
          $self.prev('[data-toggle="dropdown"]').dropdown({
            popperConfig: {
              placement: 'bottom-end'
            }
          });
        }
      });
    }
  }; // BootStrap Specific Tab Open


  NioApp.BS.tabfix = function (elm) {
    var tab = elm ? elm : '[data-toggle="modal"]';
    $(tab).on('click', function () {
      var _this = $(this),
        target = _this.data('target'),
        target_href = _this.attr('href'),
        tg_tab = _this.data('tab-target');

      var modal = target ? $body.find(target) : $body.find(target_href);

      if (tg_tab && tg_tab !== '#' && modal) {
        modal.find('[href="' + tg_tab + '"]').tab('show');
      } else if (modal) {
        var tabdef = modal.find('.nk-nav.nav-tabs');
        var link = $(tabdef[0]).find('[data-toggle="tab"]');
        $(link[0]).tab('show');
      }
    });
  }; // Dark Mode Switch @since v2.0


  NioApp.ModeSwitch = function () {
    var toggle = $('.dark-switch');

    if ($body.hasClass('dark-mode')) {
      toggle.addClass('active');
    } else {
      toggle.removeClass('active');
    }

    toggle.on('click', function (e) {
      e.preventDefault();
      $(this).toggleClass('active');
      $body.toggleClass('dark-mode');
    });
  }; // Knob @v1.0


  NioApp.Knob = function (elm, opt) {
    if ($(elm).exists() && typeof $.fn.knob === 'function') {
      var def = {
        min: 0
      },
        attr = opt ? extend(def, opt) : def;
      $(elm).each(function () {
        $(this).knob(attr);
      });
    }
  }; // Knob Init @v1.0


  NioApp.Knob.init = function () {
    var knob = {
      "default": {
        readOnly: true,
        lineCap: "round"
      },
      half: {
        angleOffset: -90,
        angleArc: 180,
        readOnly: true,
        lineCap: "round"
      }
    };
    NioApp.Knob('.knob', knob["default"]);
    NioApp.Knob('.knob-half', knob.half);
  }; // Range @v1.0.1


  NioApp.Range = function (elm, opt) {
    if ($(elm).exists() && typeof noUiSlider !== 'undefined') {
      $(elm).each(function () {
        var $self = $(this),
          self_id = $self.attr('id');

        var _start = $self.data('start'),
          _start = /\s/g.test(_start) ? _start.split(' ') : _start,
          _start = _start ? _start : 0,
          _connect = $self.data('connect'),
          _connect = /\s/g.test(_connect) ? _connect.split(' ') : _connect,
          _connect = typeof _connect == 'undefined' ? 'lower' : _connect,
          _min = $self.data('min'),
          _min = _min ? _min : 0,
          _max = $self.data('max'),
          _max = _max ? _max : 100,
          _min_distance = $self.data('min-distance'),
          _min_distance = _min_distance ? _min_distance : null,
          _max_distance = $self.data('max-distance'),
          _max_distance = _max_distance ? _max_distance : null,
          _step = $self.data('step'),
          _step = _step ? _step : 1,
          _orientation = $self.data('orientation'),
          _orientation = _orientation ? _orientation : 'horizontal',
          _tooltip = $self.data('tooltip'),
          _tooltip = _tooltip ? _tooltip : false;

        var target = document.getElementById(self_id);
        var def = {
          start: _start,
          connect: _connect,
          direction: NioApp.State.isRTL ? "rtl" : "ltr",
          range: {
            'min': _min,
            'max': _max
          },
          margin: _min_distance,
          limit: _max_distance,
          step: _step,
          orientation: _orientation,
          tooltips: _tooltip
        },
          attr = opt ? extend(def, opt) : def;
        noUiSlider.create(target, attr);
      });
    }
  }; // Range Init @v1.0


  NioApp.Range.init = function () {
    NioApp.Range('.form-control-slider');
    NioApp.Range('.form-range-slider');
  };

  NioApp.Select2.init = function () {
    // NioApp.Select2('.select');
    NioApp.Select2('.form-select');
  }; // Slick Slider @v1.0.1


  NioApp.Slick = function (elm, opt) {
    if ($(elm).exists() && typeof $.fn.slick === 'function') {
      $(elm).each(function () {
        var def = {
          'prevArrow': '<div class="slick-arrow-prev"><a href="javascript:void(0);" class="slick-prev"><em class="icon ni ni-chevron-left"></em></a></div>',
          'nextArrow': '<div class="slick-arrow-next"><a href="javascript:void(0);" class="slick-next"><em class="icon ni ni-chevron-right"></em></a></div>',
          rtl: NioApp.State.isRTL
        },
          attr = opt ? extend(def, opt) : def;
        $(this).slick(attr);
      });
    }
  }; // Slick Init @v1.0


  NioApp.Slider.init = function () {
    NioApp.Slick('.slider-init');
  }; // Magnific Popup @v1.0.0


  NioApp.Lightbox = function (elm, type, opt) {
    if ($(elm).exists()) {
      $(elm).each(function () {
        var def = {};

        if (type == 'video' || type == 'iframe') {
          def = {
            type: 'iframe',
            removalDelay: 160,
            preloader: true,
            fixedContentPos: false,
            callbacks: {
              beforeOpen: function beforeOpen() {
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                this.st.mainClass = this.st.el.attr('data-effect');
              }
            }
          };
        } else if (type == 'content') {
          def = {
            type: 'inline',
            preloader: true,
            removalDelay: 400,
            mainClass: 'mfp-fade content-popup'
          };
        } else {
          def = {
            type: 'image',
            mainClass: 'mfp-fade image-popup'
          };
        }

        var attr = opt ? extend(def, opt) : def;
        $(this).magnificPopup(attr);
      });
    }
  }; // Controls @v1.0.0


  NioApp.Control = function (elm) {
    var control = document.querySelectorAll(elm);
    control.forEach(function (item, index, arr) {
      item.checked ? item.parentNode.classList.add('checked') : null;
      item.addEventListener("change", function () {
        if (item.type == "checkbox") {
          item.checked ? item.parentNode.classList.add('checked') : item.parentNode.classList.remove('checked');
        }

        if (item.type == "radio") {
          document.querySelectorAll('input[name="' + item.name + '"]').forEach(function (item, index, arr) {
            item.parentNode.classList.remove('checked');
          });
          item.checked ? item.parentNode.classList.add('checked') : null;
        }
      });
    });
  }; // Number Spinner @v1.0


  NioApp.NumberSpinner = function (elm, opt) {
    var plus = document.querySelectorAll("[data-number='plus']");
    var minus = document.querySelectorAll("[data-number='minus']");
    plus.forEach(function (item, index, arr) {
      var parent = plus[index].parentNode;
      plus[index].addEventListener("click", function () {
        var child = plus[index].parentNode.children;
        child.forEach(function (item, index, arr) {
          if (child[index].classList.contains("number-spinner")) {
            var value = !child[index].value == "" ? parseInt(child[index].value) : 0;
            var step = !child[index].step == "" ? parseInt(child[index].step) : 1;
            var max = !child[index].max == "" ? parseInt(child[index].max) : Infinity;

            if (max + 1 > value + step) {
              child[index].value = value + step;
            } else {
              child[index].value = value;
            }
          }
        });
      });
    });
    minus.forEach(function (item, index, arr) {
      var parent = minus[index].parentNode;
      minus[index].addEventListener("click", function () {
        var child = minus[index].parentNode.children;
        child.forEach(function (item, index, arr) {
          if (child[index].classList.contains("number-spinner")) {
            var value = !child[index].value == "" ? parseInt(child[index].value) : 0;
            var step = !child[index].step == "" ? parseInt(child[index].step) : 1;
            var min = !child[index].min == "" ? parseInt(child[index].min) : 0;

            if (min - 1 < value - step) {
              child[index].value = value - step;
            } else {
              child[index].value = value;
            }
          }
        });
      });
    });
  }; // Extra @v1.1


  NioApp.OtherInit = function () {
    NioApp.ClassBody();
    NioApp.PassSwitch();
    NioApp.CurrentLink();
    NioApp.LinkOff('.is-disable');
    NioApp.ClassNavMenu();
    NioApp.SetHW('[data-height]', 'height');
    NioApp.SetHW('[data-width]', 'width');
    NioApp.NumberSpinner();
    NioApp.Lightbox('.popup-video', 'video');
    NioApp.Lightbox('.popup-iframe', 'iframe');
    NioApp.Lightbox('.popup-image', 'image');
    NioApp.Lightbox('.popup-content', 'content');
    NioApp.Control('.custom-control-input');
  }; // Animate Init @v1.0


  NioApp.Ani.init = function () {
    NioApp.Ani.formElm('.form-control-outlined');
    NioApp.Ani.formSearch('.toggle-search');
  }; // BootstrapExtend Init @v1.0


  NioApp.BS.init = function () {
    NioApp.BS.menutip('a.nk-menu-link');
    NioApp.BS.tooltip('.nk-tooltip');
    NioApp.BS.tooltip('.btn-tooltip', {
      placement: 'top'
    });
    NioApp.BS.tooltip('[data-toggle="tooltip"]');
    NioApp.BS.tooltip('.tipinfo,.nk-menu-tooltip', {
      placement: 'right'
    });
    NioApp.BS.popover('[data-toggle="popover"]');
    NioApp.BS.progress('[data-progress]');
    NioApp.BS.fileinput('.custom-file-input');
    NioApp.BS.modalfix();
    NioApp.BS.ddfix();
    NioApp.BS.tabfix();
  }; // Picker Init @v1.0


  NioApp.Picker.init = function () {
    NioApp.Picker.date('.date-picker');
    NioApp.Picker.dob('.date-picker-alt');
    NioApp.Picker.time('.time-picker');
    NioApp.Picker.date('.date-picker-range', {
      todayHighlight: false,
      autoclose: false
    });
  }; // Addons @v1


  NioApp.Addons.Init = function () {
    NioApp.Knob.init();
    NioApp.Range.init();
    NioApp.Select2.init();
    NioApp.Dropzone.init();
    NioApp.Slider.init();
    NioApp.DataTable.init();
  }; // Toggler @v1


  NioApp.TGL.init = function () {
    NioApp.TGL.content('.toggle');
    NioApp.TGL.expand('.toggle-expand');
    NioApp.TGL.expand('.toggle-opt', {
      toggle: false
    });
    NioApp.TGL.showmenu('.nk-nav-toggle');
    NioApp.TGL.ddmenu('.' + _menu + '-toggle', {
      self: _menu + '-toggle',
      child: _menu + '-sub'
    });
  };

  NioApp.BS.modalOnInit = function () {
    $('.modal').on('shown.bs.modal', function () {
      NioApp.Select2.init();
      NioApp.Validate.init();
    });
  }; // Initial by default
  /////////////////////////////


  NioApp.init = function () {
    NioApp.coms.docReady.push(NioApp.OtherInit);
    NioApp.coms.docReady.push(NioApp.Prettify);
    NioApp.coms.docReady.push(NioApp.ColorBG);
    NioApp.coms.docReady.push(NioApp.ColorTXT);
    NioApp.coms.docReady.push(NioApp.Copied);
    NioApp.coms.docReady.push(NioApp.Ani.init);
    NioApp.coms.docReady.push(NioApp.TGL.init);
    NioApp.coms.docReady.push(NioApp.BS.init);
    NioApp.coms.docReady.push(NioApp.Validate.init);
    NioApp.coms.docReady.push(NioApp.Picker.init);
    NioApp.coms.docReady.push(NioApp.Addons.Init);
    NioApp.coms.docReady.push(NioApp.Wizard);
    NioApp.coms.winLoad.push(NioApp.ModeSwitch);
  };

  NioApp.init();
  return NioApp;
}(NioApp, jQuery);

// $('#btn_refresh').click(function() {
//   $('#example').DataTable().ajax.reload();
// });

//////////////////////////////////////Start HRIS////////////////////////////////////////////////

$(document).ready(function () {

  $('.sub-menu_2').hide();
  $('.menu-item_2 > a').click(function (e) {
    e.preventDefault();
    $(this).next('.sub-menu_2').slideToggle();
  });

  $('input.check11').on('click', function () {
    $('input.check22')
      .prop('checked', this.checked)
      .trigger('change');
  });
});


/////////////////////////////////////////Login HRIS//////////////////////////////////////////

$('#sign_in').click(function () {
  var email = $("#email-address").val();
  var password = $("#password").val();
});

//////////////////////////////////// Master Pagu Medical ////////////////////////////////////////////

$('.tambah_pagu_rawat_jalan').click(function () {

  var start_date = $("#start_date_tambah_rawat_jalan").val();
  var end_date = $("#end_date_tambah_rawat_jalan").val();
  var grade = $("#grade_tambah_rawat_jalan").val();
  var pagu_tahun = $("#pagu_tahun_tambah_rawat_jalan").val();
  var url = "master/tambah_pagu_rawat_jalan";
  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_tahun == "") || (pagu_tahun === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Tahunan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { start_date: start_date, end_date: end_date, grade: grade, pagu_tahun: pagu_tahun },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_rawat_jalan').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_rawat_jalan').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});


$('.tambah_pagu_rawat_inap').click(function () {

  var start_date = $("#start_date_tambah_rawat_inap").val();
  var end_date = $("#end_date_tambah_rawat_inap").val();
  var grade = $("#grade_tambah_rawat_inap").val();
  var pagu_kamar = $("#pagu_kamar_tambah_rawat_inap").val();
  var pagu_tahun = $("#pagu_tahun_tambah_rawat_inap").val();
  var url = "master/tambah_pagu_rawat_inap";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_kamar == "") || (pagu_kamar === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Kamar tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_tahun == "") || (pagu_tahun === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Tahunan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { start_date: start_date, end_date: end_date, grade: grade, pagu_kamar: pagu_kamar, pagu_tahun: pagu_tahun },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_rawat_inap').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_rawat_inap').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$('.tambah_pagu_maternity').click(function () {

  var start_date = $("#start_date_tambah_maternity").val();
  var end_date = $("#end_date_tambah_maternity").val();
  var melahirkan = $("#melahirkan_tambah_maternity").val();
  var grade = $("#grade_tambah_maternity").val();
  var pagu_tahun = $("#pagu_tahun_tambah_maternity").val();
  var url = "master/tambah_pagu_maternity";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((melahirkan == "") || (melahirkan === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis melahirkan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_tahun == "") || (pagu_tahun === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Tahunan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { start_date: start_date, end_date: end_date, melahirkan: melahirkan, grade: grade, pagu_tahun: pagu_tahun },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_maternity').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_maternity').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});


$('.tambah_pagu_kacamata').click(function () {
  var start_date = $("#start_date_tambah_kacamata").val();
  var end_date = $("#end_date_tambah_kacamata").val();
  var grade = $("#grade_tambah_kacamata").val();
  var pagu_one_focus = $("#pagu_lensa_one_focus_tambah_kacamata").val();
  var pagu_two_focus = $("#pagu_lensa_two_focus_tambah_kacamata").val();
  var pagu_frame = $("#pagu_frame_tambah_kacamata").val();
  var url = "master/tambah_pagu_kacamata";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_one_focus == "") || (pagu_one_focus === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu One Focus tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_two_focus == "") || (pagu_two_focus === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Two Focus tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_frame == "") || (pagu_frame === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Frame tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { start_date: start_date, end_date: end_date, grade: grade, pagu_one_focus: pagu_one_focus, pagu_two_focus: pagu_two_focus, pagu_frame: pagu_frame },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_kacamata').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_kacamata').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });


});

function edit_pagu_rawat_jalan(edit_rawat_jalan) {
  var id = document.getElementById(edit_rawat_jalan).getAttribute("id");
  var url = 'master/getEditPaguRawatJalan/';

  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      //$('.data_edit_pagu_rawat_jalan').modal('show');
      var id = response[0].id;
      var start_date = response[0].start_date;
      var end_date = response[0].end_date;
      var grade = response[0].grade;
      var pagu_tahun = response[0].pagu_tahun;

      $("#id_edit_rawat_jalan").val(id);
      $("#start_date_edit_rawat_jalan").val(start_date);
      $("#end_date_edit_rawat_jalan").val(end_date);
      $("#grade_edit_rawat_jalan").val(grade).change();
      $("#pagu_tahun_edit_rawat_jalan").val(pagu_tahun);
    }
  });
}

$('.ubah_pagu_rawat_jalan').click(function () {

  var id = $("#id_edit_rawat_jalan").val();
  var start_date = $("#start_date_edit_rawat_jalan").val();
  var end_date = $("#end_date_edit_rawat_jalan").val();
  var grade = $("#grade_edit_rawat_jalan").val();
  var pagu_tahun = $("#pagu_tahun_edit_rawat_jalan").val();
  var url = "master/ubah_pagu_rawat_jalan";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_tahun == "") || (pagu_tahun === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Tahunan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, start_date: start_date, end_date: end_date, grade: grade, pagu_tahun: pagu_tahun },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_rawat_jalan').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_rawat_jalan').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_pagu_rawat_jalan(DeletePaguRawatJalan) {
  var id = document.getElementById(DeletePaguRawatJalan).getAttribute("id");
  var url = 'master/getDeletePaguRawatJalan/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_rawat_jalan').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dihapus',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
}

function edit_pagu_rawat_inap(edit_rawat_inap) {
  var id = document.getElementById(edit_rawat_inap).getAttribute("id");
  var url = 'master/getEditPaguRawatInap/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      //$('.data_edit_pagu_rawat_inap').modal('show');
      var id = response[0].id;
      var start_date = response[0].start_date;
      var end_date = response[0].end_date;
      var grade = response[0].grade;
      var pagu_tahun = response[0].pagu_tahun;
      var pagu_kamar_hari = response[0].pagu_kamar_hari;

      $("#id_edit_rawat_inap").val(id);
      $("#start_date_edit_rawat_inap").val(start_date);
      $("#end_date_edit_rawat_inap").val(end_date);
      $("#grade_edit_rawat_inap").val(grade).change();
      $("#pagu_kamar_edit_rawat_inap").val(pagu_kamar_hari);
      $("#pagu_tahun_edit_rawat_inap").val(pagu_tahun);
    }
  });
}

$('.ubah_pagu_rawat_inap').click(function () {

  var id = $("#id_edit_rawat_inap").val();
  var start_date = $("#start_date_edit_rawat_inap").val();
  var end_date = $("#end_date_edit_rawat_inap").val();
  var grade = $("#grade_edit_rawat_inap").val();
  var pagu_kamar = $("#pagu_kamar_edit_rawat_inap").val();
  var pagu_tahun = $("#pagu_tahun_edit_rawat_inap").val();
  var url = "master/ubah_pagu_rawat_inap";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_kamar == "") || (pagu_kamar === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Kamar tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_tahun == "") || (pagu_tahun === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Tahunan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, start_date: start_date, end_date: end_date, grade: grade, pagu_kamar: pagu_kamar, pagu_tahun: pagu_tahun },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_rawat_inap').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_rawat_inap').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_pagu_rawat_inap(DeletePaguRawatInap) {
  var id = document.getElementById(DeletePaguRawatInap).getAttribute("id");
  var url = 'master/getDeletePaguRawatInap/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_rawat_inap').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dihapus',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
}


function edit_pagu_maternity(edit_maternity) {
  var id = document.getElementById(edit_maternity).getAttribute("id");
  var url = 'master/getEditPaguMaternity/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      //$('.data_edit_pagu_rawat_inap').modal('show');
      var id = response[0].id;
      var start_date = response[0].start_date;
      var end_date = response[0].end_date;
      var melahirkan = response[0].melahirkan;
      var grade = response[0].grade;
      var pagu_tahun = response[0].pagu_tahun;
      $("#id_edit_maternity").val(id);
      $("#start_date_edit_maternity").val(start_date);
      $("#end_date_edit_maternity").val(end_date);
      $("#melahirkan_edit_maternity").val(melahirkan).change();
      $("#grade_edit_maternity").val(grade).change();
      $("#pagu_tahun_edit_maternity").val(pagu_tahun);
    }
  });
}

$('.ubah_pagu_maternity').click(function () {

  var id = $("#id_edit_maternity").val();
  var start_date = $("#start_date_edit_maternity").val();
  var end_date = $("#end_date_edit_maternity").val();
  var melahirkan = $("#grade_edit_melahirkan").val();
  var grade = $("#grade_edit_maternity").val();
  var pagu_tahun = $("#pagu_tahun_edit_maternity").val();
  var url = "master/ubah_pagu_maternity";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((melahirkan == "") || (melahirkan === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Melahirkan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_tahun == "") || (pagu_tahun === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Tahunan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, start_date: start_date, end_date: end_date, melahirkan: melahirkan, grade: grade, pagu_kamar: pagu_kamar, pagu_tahun: pagu_tahun },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_maternity').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_maternity').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_pagu_maternity(DeletePaguMaternity) {
  var id = document.getElementById(DeletePaguMaternity).getAttribute("id");
  var url = 'master/getDeletePaguMaternity/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_maternity').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dihapus',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
}


function edit_pagu_kacamata(edit_kacamata) {
  var id = document.getElementById(edit_kacamata).getAttribute("id");
  var url = 'master/getEditPaguKacamata/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      //$('.data_edit_pagu_kacamata').modal('show');
      var id = response[0].id;
      var start_date = response[0].start_date;
      var end_date = response[0].end_date;
      var grade = response[0].grade;
      var pagu_frame_dua_tahun = response[0].pagu_frame_dua_tahun;
      var pagu_one_focus = response[0].pagu_one_focus_tahun;
      var pagu_two_focus = response[0].pagu_two_focus_tahun;

      $("#id_edit_kacamata").val(id);
      $("#start_date_edit_kacamata").val(start_date);
      $("#end_date_edit_kacamata").val(end_date);
      $("#grade_edit_kacamata").val(grade).change();
      $("#pagu_lensa_one_focus_edit_kacamata").val(pagu_one_focus);
      $("#pagu_lensa_two_focus_edit_kacamata").val(pagu_two_focus);
      $("#pagu_frame_edit_kacamata").val(pagu_frame_dua_tahun);
    }
  });
}

$('.ubah_pagu_kacamata').click(function () {

  var id = $("#id_edit_kacamata").val();
  var start_date = $("#start_date_edit_kacamata").val();
  var end_date = $("#end_date_edit_kacamata").val();
  var grade = $("#grade_edit_kacamata").val();
  var pagu_one_focus = $("#pagu_lensa_one_focus_edit_kacamata").val();
  var pagu_two_focus = $("#pagu_lensa_two_focus_edit_kacamata").val();
  var pagu_frame = $("#pagu_frame_edit_kacamata").val();
  var url = "master/ubah_pagu_kacamata";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_one_focus == "") || (pagu_one_focus === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu One Focus tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_two_focus == "") || (pagu_two_focus === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Two Focus tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pagu_frame == "") || (pagu_frame === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Pagu Frame tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, start_date: start_date, end_date: end_date, grade: grade, pagu_one_focus: pagu_one_focus, pagu_two_focus: pagu_two_focus, pagu_frame: pagu_frame },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_kacamata').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_pagu_kacamata').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });


});

function delete_pagu_kacamata(DeletePaguKacamata) {
  var id = document.getElementById(DeletePaguKacamata).getAttribute("id");
  var url = 'master/getDeletePaguKacamata/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == true) {
        $('#table_pagu_kacamata').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dihapus',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
}


//////////////////////////////////// Master Type of Reimbursment ////////////////////////////////////////////

$(document).ready(function () {

  var get_Grandparent = "master/get_Grandparent";
  $.ajax({
    url: get_Grandparent,
    dataType: 'json',
    type: 'POST',
    data: {},
    success: function (data) {
      $('#parent_grandparent_tambah').html(data);
      $('#child_grandparent_tambah').html(data);
      $('#request_grandparent_tambah').html(data);
    }
  });


});

$('.tambah_grandparent').click(function () {

  var grandparent_tambah = $("#grandparent_tambah").val();
  var description_grandparent_tambah = $("#description_grandparent_tambah").val();
  var url = "master/tambah_grandparent";

  if ((grandparent_tambah == "") || (grandparent_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { grandparent_tambah: grandparent_tambah, description_grandparent_tambah: description_grandparent_tambah },
    success: function (data) {
      if (data == true) {
        $('#table_grandparent').DataTable().ajax.reload();
        var url = "master/get_Grandparent";
        var id = "";
        $.ajax({
          url: url,
          dataType: 'json',
          type: 'POST',
          data: { id: id },
          success: function (data) {
            $('#parent_grandparent_tambah').html(data);
            $('#child_grandparent_tambah').html(data);
          }
        });

        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_grandparent').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });

});


$('.tambah_parent').click(function () {

  var parent_grandparent_tambah = $("#parent_grandparent_tambah").val();
  var parent_tambah = $("#parent_tambah").val();
  var description_parent_tambah = $("#description_parent_tambah").val();
  var url = "master/tambah_parent";

  if ((parent_grandparent_tambah == "") || (parent_grandparent_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((parent_tambah == "") || (parent_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { parent_grandparent_tambah: parent_grandparent_tambah, parent_tambah: parent_tambah, description_parent_tambah: description_parent_tambah },
    success: function (data) {
      if (data == true) {
        $('#table_parent').DataTable().ajax.reload();

        var url = "master/get_Parent";
        var id = "";
        $.ajax({
          url: url,
          dataType: 'json',
          type: 'POST',
          data: { id: id },
          success: function (data) {
            $('#child_parent_tambah').html(data);
          }
        });
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_parent').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$('.tambah_child').click(function () {

  var start_date = $("#start_date_tambah_child").val();
  var end_date = $("#end_date_tambah_child").val();
  var child_grandparent_tambah = $("#child_grandparent_tambah").val();
  var child_parent_tambah = $("#child_parent_tambah").val();
  var child_tambah = $("#child_tambah").val();
  var claim_percentage_child_tambah = $("#claim_percentage_child_tambah").val();
  var description_child_tambah = $("#description_child_tambah").val();
  var url = "master/tambah_child";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((child_grandparent_tambah == "") || (child_grandparent_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((child_parent_tambah == "") || (child_parent_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((child_tambah == "") || (child_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Detail Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((claim_percentage_child_tambah == "") || (claim_percentage_child_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Claim Percentage tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { start_date: start_date, end_date: end_date, child_grandparent_tambah: child_grandparent_tambah, child_parent_tambah: child_parent_tambah, child_tambah: child_tambah, claim_percentage_child_tambah: claim_percentage_child_tambah, description_child_tambah: description_child_tambah },
    success: function (data) {
      if (data == true) {
        $('#table_child').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_child').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$('#child_grandparent_tambah').change(function () {
  var grandparent = $('#child_grandparent_tambah').val();
  if (grandparent != '') {
    var get_Parent = "master/get_Parent";
    $.ajax({
      url: get_Parent,
      method: 'POST',
      data: { grandparent: grandparent },
      success: function (data) {
        $('#child_parent_tambah').html(data);
      }
    });
  }
  else {
    $('#child_parent_tambah').html('<option value="">Sub Penggantian</option>');
  }
});

$('#request_grandparent_tambah').change(function () {
  var grandparent = $('#request_grandparent_tambah').val();
  if (grandparent != '') {
    var get_Parent = "master/get_Parent";
    var employee_group = $('#employee_group').val();
    var gender = $('#gender').val();
    $.ajax({
      url: get_Parent,
      method: 'POST',
      data: { grandparent: grandparent, employee_group: employee_group },
      success: function (data) {
        $('#request_parent_tambah').html(data);
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });

  }
  else {
    $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
    $('#request_child_tambah').html('<option value="">Penggantian</option>');
  }
});

$('#request_parent_tambah').change(function () {
  var parent = $('#request_parent_tambah').val();

  if (parent != '') {
    var get_Child = "master/get_Child";
    var employee_group = $('#employee_group').val();

    $.ajax({
      url: get_Child,
      method: 'POST',
      data: { parent: parent, employee_group: employee_group },
      success: function (data) {
        $('#request_child_tambah').html(data);

        // if (employee_group == 'GOL A') {
        //   $('#dirisendiri').prop('checked', false);
        //   $('#pasangan').prop('checked', false);
        //   $('#pasangan').prop('disabled', true);
        //   $('#listpasangan').hide();
        //   $('#anak').prop('disabled', true);
        //   $('#listanak').hide();
        // } else {
        //   $('#dirisendiri').prop('checked', false);
        //   $('#pasangan').prop('checked', false);
        //   $('#pasangan').prop('disabled', true);
        //   $('#anak').prop('checked', false);
        //   $('#anak').prop('disabled', true);
        //   $('#listanak').hide();
        //   $('#listpasangan').hide();
        // }
      }
    });
  }
  else {
    $('#request_child_tambah').html('<option value="">Penggantian</option>');
  }
});


function edit_grandparent(edit_grandparent) {
  var id = document.getElementById(edit_grandparent).getAttribute("id");
  var url = 'master/getEditGrandparent/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      //$('.data_edit_pagu_rawat_jalan').modal('show');
      var id = response[0].id;
      var grandparent = response[0].grandparent;
      var description = response[0].description;

      $("#id_grandparent_edit").val(id);
      $("#grandparent_edit").val(grandparent);
      $("#description_grandparent_edit").val(description);
    }
  });
}

$('.ubah_grandparent').click(function () {

  var id = $("#id_grandparent_edit").val();
  var grandparent = $("#grandparent_edit").val();
  var description = $("#description_grandparent_edit").val();
  var url = "master/ubah_grandparent";

  if ((grandparent == "") || (grandparent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, grandparent: grandparent, description: description },
    success: function (data) {
      if (data == true) {
        $('#table_grandparent').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah berhasil dirubah',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dirubah',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dirubah',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_grandparent(delete_grandparent) {
  var id = document.getElementById(delete_grandparent).getAttribute("id");
  var url = 'master/getDeleteGrandparent/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == true) {
        $('#table_grandparent').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dihapus',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
}

function edit_parent(edit_parent) {
  var id = document.getElementById(edit_parent).getAttribute("id");
  var url = 'master/getEditParent/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      //$('.data_edit_pagu_rawat_jalan').modal('show');
      var id = response[0].id;
      var grandparent = response[0].grandparent;
      var parent = response[0].parent;
      var description = response[0].description;
      var url_edit_get = "master/edit_get_Grandparent";

      $.ajax({
        url: url_edit_get,
        dataType: 'json',
        type: 'POST',
        data: { grandparent: grandparent },
        success: function (data) {
          $("#parent_grandparent_edit").html(data);
        }
      });

      $("#id_parent_edit").val(id);
      $("#parent_edit").val(parent);
      $("#description_parent_edit").val(description);
    }
  });
}

$('.ubah_parent').click(function () {

  var id = $("#id_parent_edit").val();
  var grandparent = $("#parent_grandparent_edit").val();
  var parent = $("#parent_edit").val();
  var description = $("#description_parent_edit").val();
  var url = "master/ubah_parent";

  if ((grandparent == "") || (grandparent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((parent == "") || (parent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, grandparent: grandparent, parent: parent, description: description },
    success: function (data) {
      if (data == true) {
        $('#table_parent').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah berhasil dirubah',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dirubah',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dirubah',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_parent(delete_parent) {
  var id = document.getElementById(delete_parent).getAttribute("id");
  var url = 'master/getDeleteParent/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == true) {
        $('#table_parent').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dihapus',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
}


function edit_child(edit_child) {
  var id = document.getElementById(edit_child).getAttribute("id");
  var url = 'master/getEditChild/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      //$('.data_edit_pagu_rawat_jalan').modal('show');
      var id = response[0].id;
      var grandparent = response[0].grandparent;
      var parent = response[0].parent;
      var child = response[0].child;
      var start_date = response[0].start_date;
      var end_date = response[0].end_date;
      var claim_percentage = response[0].claim_percentage;
      var claim_value = response[0].claim_value;
      var description = response[0].description;
      var url_edit_get_g = "master/edit_get_Grandparent";
      var url_edit_get_p = "master/edit_get_Parent";

      $.ajax({
        url: url_edit_get_g,
        dataType: 'json',
        type: 'POST',
        data: { grandparent: grandparent },
        success: function (data) {
          $("#child_grandparent_edit").html(data);
        }
      });

      $.ajax({
        url: url_edit_get_p,
        dataType: 'json',
        type: 'POST',
        data: { parent: parent },
        success: function (data) {
          $("#child_parent_edit").html(data);
        }
      });
      $("#id_child_edit").val(id);
      $("#child_edit").val(child);
      $("#start_date_edit_child").val(start_date);
      $("#end_date_edit_child").val(end_date);
      $("#claim_percentage_child_edit").val(claim_percentage);
      $("#claim_value_child_edit").val(claim_value);
      $("#description_child_edit").val(description);
    }
  });
}

$('.ubah_child').click(function () {

  var id = $("#id_child_edit").val();
  var start_date = $("#start_date_edit_child").val();
  var end_date = $("#end_date_edit_child").val();
  var child_grandparent = $("#child_grandparent_edit").val();
  var child_parent = $("#child_parent_edit").val();
  var child = $("#child_edit").val();
  var claim_percentage_child = $("#claim_percentage_child_edit").val();
  var claim_value_child = $("#claim_value_child_edit").val();
  var description_child = $("#description_child_edit").val();
  var url = "master/ubah_child";

  if ((start_date == "") || (start_date === undefined) || (end_date == "") || (end_date === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((child_grandparent == "") || (child_grandparent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((child_parent == "") || (child_parent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((child == "") || (child === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Detail Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((claim_percentage_child == "") || (claim_percentage_child === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Claim Percentage tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, start_date: start_date, end_date: end_date, child_grandparent: child_grandparent, child_parent: child_parent, child: child, claim_percentage_child: claim_percentage_child, claim_value_child: claim_value_child, description_child: description_child },
    success: function (data) {
      if (data == true) {
        $('#table_child').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah berhasil dirubah',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_child').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak berhasil dirubah',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_child(delete_child) {
  var id = document.getElementById(delete_child).getAttribute("id");
  var url = 'master/getDeleteChild/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == true) {
        $('#table_child').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Data telah dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dihapus',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dihapus',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
}


//////////////////////////////////////Master Couple//////////////////////////////////

$('#getCoupleEmployee').click(function () {

  $('#form_add_couple').trigger("reset");

  var getMaleEmployee = "master/getMaleEmployee";
  $.ajax({
    url: getMaleEmployee,
    dataType: 'json',
    type: 'POST',
    data: {},
    success: function (data) {
      $('#full_name_male_add_couple').html(data);
    }
  });

  var getFemaleEmployee = "master/getFemaleEmployee";
  $.ajax({
    url: getFemaleEmployee,
    dataType: 'json',
    type: 'POST',
    data: {},
    success: function (data) {
      $('#full_name_female_add_couple').html(data);
    }
  });

});

$('#full_name_male_add_couple').change(function () {
  var full_name_male_add_couple = $('#full_name_male_add_couple').val();
  if (full_name_male_add_couple != '') {
    var get_DataEmployeeMale = "master/get_DataEmployeeMale";
    $.ajax({
      url: get_DataEmployeeMale,
      method: 'POST',
      dataType: 'json',
      data: { full_name_male_add_couple: full_name_male_add_couple },
      success: function (data) {
        var nik = data.nik;
        $('#employee_id_male').val(nik);
      }
    });
  }
});

$('#full_name_female_add_couple').change(function () {
  var full_name_female_add_couple = $('#full_name_female_add_couple').val();
  if (full_name_female_add_couple != '') {
    var get_DataEmployeeFemale = "master/get_DataEmployeeFemale";
    $.ajax({
      url: get_DataEmployeeFemale,
      method: 'POST',
      dataType: 'json',
      data: { full_name_female_add_couple: full_name_female_add_couple },
      success: function (data) {
        var nik = data.nik;
        $('#employee_id_female').val(nik);
      }
    });
  }
});

$('.add_couple_employee').click(function () {

  var complete_name_male = $("#full_name_male_add_couple").val();
  var complete_name_female = $("#full_name_female_add_couple").val();
  var employee_id_male = $("#employee_id_male").val();
  var employee_id_female = $("#employee_id_female").val();
  ///////////////////////////////Start Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////
  var start_date_couple = $("#start_date_couple").val();
  var end_date_couple = $("#end_date_couple").val();
  ///////////////////////////////End Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////

  var url = "master/add_couple_employee";

  if ((employee_id_male == "") || (employee_id_male === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Nomor Induk Karyawan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((employee_id_female == "") || (employee_id_female === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Nomor Induk Karyawan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
    ///////////////////////////////Start Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////
  } else if ((start_date_couple == "") || (start_date_couple === undefined) || (end_date_couple == "") || (end_date_couple === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Start date atau End date tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
    ///////////////////////////////End Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////
  }
  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    ///////////////////////////////Start Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////
    data: { employee_id_male: employee_id_male, employee_id_female: employee_id_female, complete_name_male: complete_name_male, complete_name_female: complete_name_female, start_date_couple: start_date_couple, end_date_couple: end_date_couple },
    ///////////////////////////////End Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////
    success: function (data) {
      if (data == true) {
        $('#table_couple').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_couple').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function act_child(act_child) {
  var id = document.getElementById(act_child).getAttribute("id");
  var isChecked = $('#' + id).prop('checked');
  var st_act = "";
  if (isChecked == true) {
    st_act = "Y";
  } else {
    st_act = "N";
  }

  var url = 'master/save_act_child/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id, st_act: st_act },
    success: function (data) {
      $('#table_family').DataTable().ajax.reload();

      Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Switched',
        showConfirmButton: false,
        timer: 1500
      });

    }
  });

}

//////////////////////////////////////Users//////////////////////////////////////////


$('#getEmployeeToUsers').click(function () {

  $('#form_tambah_users').trigger("reset");

  var getEmployeeToUsers = "master/getEmployeeToUsers";
  $.ajax({
    url: getEmployeeToUsers,
    dataType: 'json',
    type: 'POST',
    data: {},
    success: function (data) {
      $('#full_name_tambah_users').html(data);
    }
  });
});

$('#full_name_tambah_users').change(function () {
  var full_name_tambah_users = $('#full_name_tambah_users').val();
  if (full_name_tambah_users != '') {
    var get_Data_Employee = "master/get_DataEmployeeToUsers";
    $.ajax({
      url: get_Data_Employee,
      method: 'POST',
      dataType: 'json',
      data: { full_name_tambah_users: full_name_tambah_users },
      success: function (data) {
        var email = data.email;
        var nik = data.nik;
        var phone_number = data.phone_number;
        $('#employee_id_tambah').val(nik);
        $('#email_tambah').val(email);
        $('#phone_tambah').val(phone_number);
      }
    });
  }
});

$('.tambah_user').click(function () {

  var complete_name = $("#full_name_tambah_users").val();
  var nik = $("#employee_id_tambah").val();
  var email = $("#email_tambah").val();
  var phone_number = $("#phone_tambah").val();
  var password = $("#password_tambah").val();
  var role = $("#role_tambah").val();
  var access = $("#access_tambah").val();
  var verification = $("#verification_tambah").val();
  var url = "master/tambah_user";

  if ((nik == "") || (nik === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Nomor Induk Karyawan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((password == "") || (password === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Password tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }
  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { nik: nik, complete_name: complete_name, email: email, phone_number: phone_number, password: password, role: role, access: access, verification: verification },
    success: function (data) {
      if (data == true) {
        $('#table_users').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_users').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

///////////////////////////////////////////tambah item TOR Medical Reimbursement/////////////////////////////////////////

function hitungSelisihHari(tgl1, tgl2) {
  var miliday = 24 * 60 * 60 * 1000;
  var tanggal1 = new Date(tgl1);
  var tanggal2 = new Date(tgl2);
  var tglPertama = Date.parse(tanggal1);
  var tglKedua = Date.parse(tanggal2);
  var selisih = (tglKedua - tglPertama) / miliday;
  return selisih;
}

const formatRupiah = new Intl.NumberFormat('id-ID', {
  // style: 'currency',
  // currency: 'IDR',
  minimumFractionDigits: 0
});

$(document).ready(function () {


  var request_id = $("#request_id").val();

  var get_sum_penggantian_jalan = "form/get_sum_penggantian_jalan";
  $.ajax({
    url: get_sum_penggantian_jalan,
    method: 'POST',
    dataType: 'json',
    data: { request_id: request_id },
    success: function (data_jalan) {
      var sum_penggantian_jalan = Intl.NumberFormat().format(data_jalan[0].sum_penggantian);
      $('#sum_penggantian_jalan').val(sum_penggantian_jalan);
      var limit_rawat_jalan = $("#limit_rawat_jalan").val();
      sum_penggantian_jalan = parseFloat(sum_penggantian_jalan.replace(/,/g, ''));
      limit_rawat_jalan = parseFloat(limit_rawat_jalan.replace(/,/g, ''));
      var sisa_pagu_jalan = limit_rawat_jalan - sum_penggantian_jalan;
      $('#temp_limit_rawat_jalan').val(sisa_pagu_jalan);
    }
  });

  var get_sum_penggantian_inap = "form/get_sum_penggantian_inap";
  $.ajax({
    url: get_sum_penggantian_inap,
    method: 'POST',
    dataType: 'json',
    data: { request_id: request_id },
    success: function (data_inap) {
      var sum_penggantian_inap = Intl.NumberFormat().format(data_inap[0].sum_penggantian);
      $('#sum_penggantian_inap').val(sum_penggantian_inap);
      var limit_rawat_inap = $("#limit_rawat_inap").val();
      sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));
      limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));
      var sisa_pagu_inap = limit_rawat_inap - sum_penggantian_inap;
      $('#temp_limit_rawat_inap').val(sisa_pagu_inap);
    }
  });

  var get_sum_penggantian_kacamata = "form/get_sum_penggantian_kacamata";
  $.ajax({
    url: get_sum_penggantian_kacamata,
    method: 'POST',
    dataType: 'json',
    data: { request_id: request_id },
    success: function (data_kacamata) {
      var sum_penggantian_kacamata_frame = Intl.NumberFormat().format(data_kacamata[0].sum_frame);
      $('#sum_penggantian_kacamata_frame').val(sum_penggantian_kacamata_frame);
      var limit_kacamata_frame = $("#limit_kacamata_frame").val();
      // sum_penggantian_kacamata_frame = parseFloat(sum_penggantian_kacamata_frame.replace(/,/g, ''));
      sum_penggantian_kacamata_frame = sum_penggantian_kacamata_frame.replaceAll(".", "").replaceAll(",", '');

      // limit_kacamata_frame = parseFloat(limit_kacamata_frame.replace(/,/g, ''));
      limit_kacamata_frame = parseInt(limit_kacamata_frame.replaceAll(',', '').replaceAll(".", ''));
      var sisa_pagu_frame = limit_kacamata_frame - sum_penggantian_kacamata_frame;
      $('#temp_limit_kacamata_frame').val(sisa_pagu_frame);

      var sum_penggantian_kacamata_one_focus = Intl.NumberFormat().format(data_kacamata[0].sum_one_focus);
      $('#sum_penggantian_kacamata_one_focus').val(sum_penggantian_kacamata_one_focus);
      var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
      sum_penggantian_kacamata_one_focus = parseInt(sum_penggantian_kacamata_one_focus.replaceAll('.', '').replaceAll(".", ''));
      // limit_kacamata_one_focus = parseFloat(limit_kacamata_one_focus.replace(/,/g, ''));
      limit_kacamata_one_focus = parseInt(limit_kacamata_one_focus.replaceAll(',', '').replaceAll(".", ''));
      var sisa_pagu_one_focus = limit_kacamata_one_focus - sum_penggantian_kacamata_one_focus;
      $('#temp_limit_kacamata_one_focus').val(sisa_pagu_one_focus);

      var sum_penggantian_kacamata_two_focus = Intl.NumberFormat().format(data_kacamata[0].sum_two_focus);
      $('#sum_penggantian_kacamata_two_focus').val(sum_penggantian_kacamata_two_focus);
      var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
      // console.log(sum_penggantian_kacamata_two_focus);
      sum_penggantian_kacamata_two_focus = parseFloat(sum_penggantian_kacamata_two_focus.replace(/,/g, ''));
      limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replace(/,/g, ''));
      var sisa_pagu_two_focus = limit_kacamata_two_focus - sum_penggantian_kacamata_two_focus;
      $('#temp_limit_kacamata_two_focus').val(sisa_pagu_two_focus);

    }
  });

});

$(document).ready(function () {

  $('#modalAddClaim').on('hidden.bs.modal', function () {
      $('body').css('overflow', 'auto');
  });

  $('.select-search').select2({
    dropdownParent: $('#modalAddClaim')
  });

  $('.select-search_edit_claim').select2({
    dropdownParent: $('#modalEditToR')
  });

  $('.select-search_couple').select2({
    dropdownParent: $('#modalAddCouple')
  });

  $('.select-kuitansi').select2({
    tags: true
  });  

  $('.select-search_user_hris').select2({
    dropdownParent: $('#modalTambahUser')
  });

  // var join_date = $('#join_date').val();
  // var today = new Date(); 
  // var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

  // if((grandparent == 3) || (marital_status == 'Single')){
  //   document.getElementById("pasangan").disabled = true;
  //   document.getElementById("anak").disabled = true;
  // }else{
  //   document.getElementById("pasangan").disabled = false;
  //   document.getElementById("anak").disabled = false;
  // }


});

$('[name="customRadioTor"]').on('change', function () {
  var state = this.id == 'anak';
  $('[name="listanak"]').toggle(state);

  var state_p = this.id == 'pasangan';
  $('[name="listpasangan"]').toggle(state_p);

  var tanggal_kuitansi = $("#tanggal_kuitansi").val();

  if ((tanggal_kuitansi == "") || (tanggal_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Tanggal Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });

    $('.listanak').hide();
    var ele = document.getElementsByName("customRadioTor");
    for (var i = 0; i < ele.length; i++)
      ele[i].checked = false;

    $('.listpasangan').hide();
    var elee = document.getElementsByName("customRadioTor");
    for (var j = 0; j < elee.length; j++)
      elee[j].checked = false;

    return false;
  }

  var getFamilyChild = "form/getFamilyChild";
  $.ajax({
    url: getFamilyChild,
    dataType: 'json',
    type: 'POST',
    data: { tanggal_kuitansi: tanggal_kuitansi },
    success: function (data) {
      $('#listanak').html(data);
    }
  });

  var getFamilySpouse = "form/getFamilySpouse";
  $.ajax({
    url: getFamilySpouse,
    dataType: 'json',
    type: 'POST',
    data: { tanggal_kuitansi: tanggal_kuitansi },
    success: function (data) {
      $('#listpasangan').html(data);
    }
  });

});

$('#request_grandparent_tambah').on('change', function () {
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();

  var grandparent = $('#request_grandparent_tambah').val();
  var gender = $('#gender').val();
  var marital_status = $('#marital_status').val();
  var hak_pengajuan = $('#hak_pengajuan').val();
  var nik = $('#employee_id').val();
  var tanggal_kuitansi = $("#tanggal_kuitansi").val(); //penambahan zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih

  var employee_group = $("#employee_group").val();
  // if (((grandparent == 3)) && (join_years < 1)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'warning',
  //     title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
  //     showConfirmButton: false,
  //     timer: 2500
  //   });
  //   document.getElementById('form_Add_Claim').reset();
  //   $('#form_Add_Claim').trigger('reset');
  //   var get_Grandparent = "form/get_Grandparent";
  //   $.ajax({
  //     url: get_Grandparent,
  //     dataType: 'json',
  //     type: 'POST',
  //     data: {},
  //     success: function (data) {
  //       $('#request_grandparent_tambah').html(data);
  //       $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
  //       $('#request_child_tambah').html('<option value="">Penggantian</option>');
  //     }
  //   });
  //   return false;

  // } else if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'info',
  //     title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
  //     showConfirmButton: false,
  //     timer: 2500
  //   });
  //   document.getElementById('form_Add_Claim').reset();
  //   $('#form_Add_Claim').trigger('reset');
  //   var get_Grandparent = "form/get_Grandparent";
  //   $.ajax({
  //     url: get_Grandparent,
  //     dataType: 'json',
  //     type: 'POST',
  //     data: {},
  //     success: function (data) {
  //       $('#request_grandparent_tambah').html(data);
  //       $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
  //       $('#request_child_tambah').html('<option value="">Penggantian</option>');
  //     }
  //   });
  //   return false;
  // }

  //penambahan zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih
  if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else if ((employee_subgroup == 'Contract') && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    //penambahan zulvan menampilkan tahun pagu dan sisa limit pagu saat buat dokumen medclaim  
    if (grandparent == 3) {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
        showConfirmButton: false,
        timer: 2500
      });
      document.getElementById('form_Add_Claim').reset();
      $('#form_Add_Claim').trigger('reset');
      var get_Grandparent = "form/get_Grandparent";
      $.ajax({
        url: get_Grandparent,
        dataType: 'json',
        type: 'POST',
        data: {},
        success: function (data) {
          $('#request_grandparent_tambah').html(data);
          $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
          $('#request_child_tambah').html('<option value="">Penggantian</option>');
        }
      });
      return false;
    } else {
      if (tanggal_kuitansi !== null && tanggal_kuitansi !== '') {
        var cek_limit_pagu = "form/cek_limit_pagu";

        $.ajax({
          url: cek_limit_pagu,
          dataType: 'json',
          type: 'POST',
          data: {
            tanggal_kuitansi: tanggal_kuitansi,
            employee_nik: nik,
            employee_group: employee_group,
            grandparent: grandparent
          },
          success: function (pagu_remaining) {
            var pagu_remaining = pagu_remaining;
            if (pagu_remaining != false) {
              $("#pagu_tahun").val(tanggal_kuitansi.substr(-4));
              if (grandparent == '1') {
                var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(",", "").replaceAll(".", '');
                var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
                $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
              } else {
                if (grandparent == '2') {
                  var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(",", "").replaceAll(".", '');
                  var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
                  $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
                }
              }
            }
          }
        });
      }
    }
  } else {
    if (tanggal_kuitansi !== null && tanggal_kuitansi !== '') {
      var cek_limit_pagu = "form/cek_limit_pagu";

      $.ajax({
        url: cek_limit_pagu,
        dataType: 'json',
        type: 'POST',
        data: {
          tanggal_kuitansi: tanggal_kuitansi,
          employee_nik: nik,
          employee_group: employee_group,
          grandparent: grandparent
        },
        success: function (pagu_remaining) {
          var pagu_remaining = pagu_remaining;
          if (pagu_remaining != false) {
            $("#pagu_tahun").val(tanggal_kuitansi.substr(-4));
            if (grandparent == '1') {
              var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(",", "").replaceAll(".", '');
              var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
              $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
            } else if (grandparent == '2') {
              var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(",", "").replaceAll(".", '');
              var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
              $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
            } else {
              // $("#pagu_tahun").val(null);
              $("#sisa_limit").val(null);
            }
          }
        }
      });
    } else {
      $("#sisa_limit").val(null);
    }
  }



  // $("#pagu_tahun").val(null);
  // $("#sisa_limit").val(null);

  var kosong = "";
  $('#total_nominal_kuitansi').val(kosong);
  $('#harga_kamar').val(kosong);
  $('#penggantian').val(kosong);


  if (grandparent == 2) {
    $('.s_harga_kamar').show();
  } else {
    $('.s_harga_kamar').hide();
  }

  if ((grandparent == 3)) {
    document.getElementById("pasangan").disabled = true;
    document.getElementById("anak").disabled = true;
  }

  // alert(nik);
  if (grandparent == 3) {
    $('#dirisendiri').prop('checked', false);
    $('#pasangan').prop('checked', false);
    $('#pasangan').prop('disabled', true);
    $('#anak').prop('checked', false);
    $('#anak').prop('disabled', true);
    $('#listanak').hide();
    $('#listanak').val(null);
    $('#listpasangan').hide();
    $('#listpasangan').val(null);
  } else {

    ///////////Start cek data couple 2025/////////////
    var tanggal_kuitansi = $("#tanggal_kuitansi").val();
    if (tanggal_kuitansi == null || tanggal_kuitansi == '' || tanggal_kuitansi === undefined) {
      var tanggal_kuitansi = new Date();
      var dd = String(tanggal_kuitansi.getDate()).padStart(2, '0');
      var mm = String(tanggal_kuitansi.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = tanggal_kuitansi.getFullYear();
      tanggal_kuitansi = mm + '/' + dd + '/' + yyyy;
    }

    var employee_nik = $("#employee_id").val();
    var cek_data_couple = "form/cek_data_couple";
    $.ajax({
      url: cek_data_couple,
      dataType: 'json',
      type: 'POST',
      data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
      success: function (data) {
        var employee_nik = $("#employee_id").val();
        var gender = $('#gender').val();
        var marital_status = $('#marital_status').val();

        if (marital_status == 'Single') {
          $('#dirisendiri').prop('checked', false);
          $('#pasangan').prop('checked', false);
          $('#pasangan').prop('disabled', true);
          $('#anak').prop('checked', false);
          $('#anak').prop('disabled', true);
          $('#listanak').hide();
          $('#listpasangan').hide();
        } else if (marital_status == 'Marr.') {
          if (gender == 'Male') {
            $('#dirisendiri').prop('checked', false);
            $('#dirisendiri').prop('disabled', false);
            $('#pasangan').prop('checked', false);
            $('#pasangan').prop('disabled', false);
            $('#anak').prop('checked', false);
            $('#anak').prop('disabled', false);
            $('#listpasangan').hide();
            $('#listpasangan').val(null);
            $('#listanak').hide();
            $('#listanak').val(null);
          } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
            // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
            $('#dirisendiri').prop('checked', false);
            $('#dirisendiri').prop('disabled', false);
            $('#pasangan').prop('checked', false);
            $('#pasangan').prop('disabled', false);
            $('#anak').prop('checked', false);
            $('#anak').prop('disabled', false);
          } else {
            $('#dirisendiri').prop('checked', false);
            $('#dirisendiri').prop('disabled', false);
            $('#pasangan').prop('checked', false);
            $('#pasangan').prop('disabled', true);
            $('#anak').prop('checked', false);
            $('#anak').prop('disabled', true);
          }
        } else {
          $('#dirisendiri').prop('checked', false);
          $('#pasangan').prop('checked', false);
          $('#pasangan').prop('disabled', true);
          $('#anak').prop('checked', false);
          $('#anak').prop('disabled', false);
          $('#listanak').hide();
          $('#listanak').val(null);
          $('#listpasangan').hide();
          $('#listpasangan').val(null);
        }
      },
      error: function (data) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat ditemukan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    });
    ///////////End cek data couple 2025/////////////
  }


  //else{
  //   document.getElementById("pasangan").disabled = false;
  //   document.getElementById("anak").disabled = false;
  // }

});

$('#request_parent_tambah').on('change', function () {
  var parent = $('#request_parent_tambah').val();
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();
  var employee_group = $("#employee_group").val();
  var marital_status = $('#marital_status').val();
  var gender = $('#gender').val();
  var hak_pengajuan = $('#hak_pengajuan').val();
  var nik = $('#employee_id').val();
  var grandparent = $('#request_grandparent_tambah').val();

  // if (((parent == 4) || (parent == 7)) && (join_years < 1)) {
  if ((parent == 4) && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    if (gender == 'Male' && marital_status != 'Marr.') {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Maaf Marital Status anda tidak bisa mengajukan<br>Klaim Kehamilan dan Melahirkan',
        showConfirmButton: false,
        timer: 2500
      });
    } else {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
        showConfirmButton: false,
        timer: 2500
      });
    }
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else if ((parent == 6 || parent == 5) && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan lensa<br>Masa kerja masih kurang dari satu tahun',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
    // } else if ((parent == 5) && (join_years < 2)) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan Frame<br>Masa kerja masih kurang dari dua tahun',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    if (gender == 'Male' && marital_status != 'Marr.') {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Maaf Marital Status anda tidak bisa mengajukan<br>Klaim Kehamilan dan Melahirkan',
        showConfirmButton: false,
        timer: 2500
      });
    } else {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
        showConfirmButton: false,
        timer: 2500
      });
    }
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else if (((marital_status == 'Div.') || (marital_status == 'Wid.') || (marital_status == 'Single')) && ((parent == 4) || (parent == 7))) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Maaf Marital Status anda tidak bisa mengajukan<br>Klaim Kehamilan dan Melahirkan',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  }

  var kosong = "";
  $('#total_nominal_kuitansi').val(kosong);
  $('#penggantian').val(kosong);

  if ((grandparent == 3)) {
    document.getElementById("pasangan").disabled = true;
    document.getElementById("anak").disabled = true;
  }
  if (grandparent == 3) {
    $('#dirisendiri').prop('checked', false);
    $('#pasangan').prop('checked', false);
    $('#pasangan').prop('disabled', true);
    $('#anak').prop('checked', false);
    $('#anak').prop('disabled', true);
    $('#listanak').hide();
    $('#listanak').val(null);
    $('#listpasangan').hide();
    $('#listpasangan').val(null);
  } else {

    if (parent == 9) {
      if (employee_group == 'GOL A') {
        $('#dirisendiri').prop('checked', false);
        $('#pasangan').prop('checked', false);
        $('#pasangan').prop('disabled', true);
        $('#listpasangan').hide();
        $('#anak').prop('disabled', true);
        $('#listanak').hide();
      } else {
        $('#dirisendiri').prop('checked', false);
        $('#pasangan').prop('checked', false);
        $('#pasangan').prop('disabled', true);
        $('#anak').prop('checked', false);
        $('#anak').prop('disabled', true);
        $('#listanak').hide();
        $('#listpasangan').hide();
      }
    } else {

      ///////////Start cek data couple 2025/////////////
      var tanggal_kuitansi = $("#tanggal_kuitansi").val();
      if (tanggal_kuitansi == null || tanggal_kuitansi == '' || tanggal_kuitansi === undefined) {
        var tanggal_kuitansi = new Date();
        var dd = String(tanggal_kuitansi.getDate()).padStart(2, '0');
        var mm = String(tanggal_kuitansi.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = tanggal_kuitansi.getFullYear();
        tanggal_kuitansi = mm + '/' + dd + '/' + yyyy;
      }
      var employee_nik = $("#employee_id").val();
      var cek_data_couple = "form/cek_data_couple";
      $.ajax({
        url: cek_data_couple,
        dataType: 'json',
        type: 'POST',
        data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
        success: function (data) {
          var employee_nik = $("#employee_id").val();
          var gender = $('#gender').val();
          var marital_status = $('#marital_status').val();

          if (marital_status == 'Single') {
            $('#dirisendiri').prop('checked', false);
            $('#pasangan').prop('checked', false);
            $('#pasangan').prop('disabled', true);
            $('#anak').prop('checked', false);
            $('#anak').prop('disabled', true);
            $('#listanak').hide();
            $('#listpasangan').hide();
          } else if (marital_status == 'Marr.') {
            if (gender == 'Male') {
              if (parent == 4 || parent == 7) {
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', true);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', false);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', true);
                $('#listpasangan').hide();
                $('#listpasangan').val(null);
                $('#listanak').hide();
                $('#listanak').val(null);
              } else {
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', false);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', false);
                $('#listpasangan').hide();
                $('#listpasangan').val(null);
                $('#listanak').hide();
                $('#listanak').val(null);
              }
            } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
              // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
              if (parent == 4 || parent == 7) {
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', true);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', true);
              } else {
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', false);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', false);
              }
            } else {
              if (parent == 4 || parent == 7) {
                $('#dirisendiri').prop('checked', true);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', true);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', true);
              } else {
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', true);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', true);
              }
            }
          } else {
            $('#dirisendiri').prop('checked', false);
            $('#pasangan').prop('checked', false);
            $('#pasangan').prop('disabled', true);
            $('#anak').prop('checked', false);
            $('#anak').prop('disabled', false);
            $('#listanak').hide();
            $('#listanak').val(null);
            $('#listpasangan').hide();
            $('#listpasangan').val(null);
          }
        },
        error: function (data) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Data tidak dapat ditemukan',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
      ///////////End cek data couple 2025/////////////
    }
  }

  // if (parent == 7 || parent == 4) {
  //   if (gender == 'Male') {
  //     $('#dirisendiri').prop('checked', false);
  //     $('#dirisendiri').prop('disabled', true);
  //     $('#pasangan').prop('checked', false);
  //     $('#pasangan').prop('disabled', false);
  //     $('#anak').prop('checked', false);
  //     $('#anak').prop('disabled', true);
  //   } else {
  //     $('#dirisendiri').prop('checked', false);
  //     $('#dirisendiri').prop('disabled', false);
  //     $('#pasangan').prop('checked', false);
  //     $('#pasangan').prop('disabled', true);
  //     $('#anak').prop('checked', false);
  //     $('#anak').prop('disabled', true);
  //   }
  // } else {
  //   $('#dirisendiri').prop('disabled', false);
  //   $('#pasangan').prop('disabled', false);
  //   $('#anak').prop('disabled', false);
  // }


});

$('#request_child_tambah').on('change', function () {
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var grandparent = $('#request_grandparent_tambah').val();
  var parent = $('#request_parent_tambah').val();
  var child = $('#request_child_tambah').val();
  var employee_subgroup = $("#employee_subgroup").val();
  var hak_pengajuan = $('#hak_pengajuan').val();
  var nik = $('#employee_id').val();
  var employee_group = $("#employee_group").val();
  var tanggal_kuitansi = $("#tanggal_kuitansi").val();

  if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  }

  if (tanggal_kuitansi !== null && tanggal_kuitansi !== '') {
    var cek_limit_pagu = "form/cek_limit_pagu";

    $.ajax({
      url: cek_limit_pagu,
      dataType: 'json',
      type: 'POST',
      data: {
        tanggal_kuitansi: tanggal_kuitansi,
        employee_nik: nik,
        employee_group: employee_group,
        grandparent: grandparent,
        parent: parent,
        child: child,
      },
      success: function (pagu_remaining) {
        var pagu_remaining = pagu_remaining;
        if (pagu_remaining != false) {
          $("#pagu_tahun").val(tanggal_kuitansi.substr(-4));
          switch (grandparent) {
            case '1': //rawat_jalan
              var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(".", "").replaceAll(",", '');
              var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
              $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
              break;
            case '2': //rawat_inap
              var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(".", "").replaceAll(",", '');
              var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
              $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
              break;
            default: //kacamata
              if (child == '' || child == null) {
                $("#sisa_limit").val(null);
              } else {
                switch (child) {
                  case '12':
                    var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val().replaceAll(".", "").replaceAll(",", '');
                    var sisa_limit_kacamata_frame = parseInt(pagu_remaining['pagu_frame_dua_tahun']) - parseInt(sum_penggantian_kacamata_frame);
                    $("#sisa_limit").val(formatRupiah.format(sisa_limit_kacamata_frame));
                    break;
                  case '13':
                    var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val().replaceAll(".", "").replaceAll(",", '');
                    var sisa_limit_one_focus = parseInt(pagu_remaining['pagu_one_focus_tahun']) - parseInt(sum_penggantian_kacamata_one_focus);
                    $("#sisa_limit").val(formatRupiah.format(sisa_limit_one_focus));
                    break;
                  default:
                    var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val().replaceAll(".", "").replaceAll(",", '');
                    var sisa_limit_two_focus = parseInt(pagu_remaining['pagu_two_focus_tahun']) - parseInt(sum_penggantian_kacamata_two_focus);
                    $("#sisa_limit").val(formatRupiah.format(sisa_limit_two_focus));
                    break;
                }
              }
              break;
          }
        }
      }
    });
  }


  var kosong = "";
  $('#total_nominal_kuitansi').val(kosong);
  $('#penggantian').val(kosong);

  // if ((grandparent == 2) && (parent == 2) && (child == 4)) {
  //   $('.s_harga_kamar').show();
  // } else if ((grandparent == 2) && (parent == 2) && (child != 4)) {
  //   $('.s_harga_kamar').hide();
  // }

  if ((grandparent == 2) && (parent == 2 || parent == 3 || parent == 4) && (child == 4 || child == 15 || child == 9 || child == 10 || child == 11)) {
    $('.s_harga_kamar').show();
  } else {
    $('.s_harga_kamar').hide();
  }
});

$('#harga_kamar').on('change', function () {
  var kosong = "";
  $('#total_nominal_kuitansi').val(kosong);
  $('#penggantian').val(kosong);

});

$('#tanggal_kuitansi').on('change', function () {
  var request_id = $("#request_id").val();
  var grandparent = $('#request_grandparent_tambah').val();
  if ((grandparent == 3)) {
    document.getElementById("pasangan").disabled = true;
    document.getElementById("anak").disabled = true;
  }
  // $('#total_nominal_kuitansi').val(null);
  // $('#penggantian').val(null);

  $('.listanak').hide();
  var ele = document.getElementsByName("customRadioTor");
  for (var i = 0; i < ele.length; i++)
    ele[i].checked = false;

  var tanggal_kuitansi = $("#tanggal_kuitansi").val();
  var hak_pengajuan = $('#hak_pengajuan').val();

  var dateObjTanggalKuitansi = new Date(tanggal_kuitansi);
  var today = new Date();
  var selisih = Math.floor(hitungSelisihHari(tanggal_kuitansi, today));
  var passed = 1;
  var get_medical_item_year = "form/get_medical_item_year";
  $.ajax({
    url: get_medical_item_year,
    dataType: 'json',
    type: 'POST',
    data: { request_id: request_id },
    success: function (data) {
      if (data == null || data == '') {
        var cek_efektifitas_kuitansi = "form/cek_efektifitas_kuitansi";
        $.ajax({
          url: cek_efektifitas_kuitansi,
          dataType: 'json',
          type: 'POST',
          data: { tanggal_kuitansi: tanggal_kuitansi },
          success: function (efektifitas) {
            var efektifitas = efektifitas;
            if (efektifitas != false) {

              // ///////////Start cek data couple 2025/////////////
              // var employee_nik = $("#employee_id").val();
              // var cek_data_couple = "form/cek_data_couple";
              // $.ajax({
              //   url: cek_data_couple,
              //   dataType: 'json',
              //   type: 'POST',
              //   data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
              //   success: function (data) {
              //     var employee_nik = $("#employee_id").val();
              //     var gender = $('#gender').val();
              //     var marital_status = $('#marital_status').val();

              //     if (marital_status == 'Single') {
              //       $('#dirisendiri').prop('checked', false);
              //       $('#pasangan').prop('checked', false);
              //       $('#pasangan').prop('disabled', true);
              //       $('#anak').prop('checked', false);
              //       $('#anak').prop('disabled', true);
              //       $('#listanak').hide();
              //       $('#listpasangan').hide();
              //     } else if (marital_status == 'Marr.') {
              //       if (gender == 'Male') {
              //         $('#dirisendiri').prop('checked', false);
              //         $('#dirisendiri').prop('disabled', false);
              //         $('#pasangan').prop('checked', false);
              //         $('#pasangan').prop('disabled', false);
              //         $('#anak').prop('checked', false);
              //         $('#anak').prop('disabled', false);
              //         $('#listpasangan').hide();
              //         $('#listpasangan').val(null);
              //         $('#listanak').hide();
              //         $('#listanak').val(null);
              //       } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
              //         // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
              //         $('#dirisendiri').prop('checked', false);
              //         $('#dirisendiri').prop('disabled', false);
              //         $('#pasangan').prop('checked', false);
              //         $('#pasangan').prop('disabled', false);
              //         $('#anak').prop('checked', false);
              //         $('#anak').prop('disabled', false);
              //       } else {
              //         $('#dirisendiri').prop('checked', false);
              //         $('#dirisendiri').prop('disabled', false);
              //         $('#pasangan').prop('checked', false);
              //         $('#pasangan').prop('disabled', true);
              //         $('#anak').prop('checked', false);
              //         $('#anak').prop('disabled', true);
              //       }
              //     } else {
              //       $('#dirisendiri').prop('checked', false);
              //       $('#pasangan').prop('checked', false);
              //       $('#pasangan').prop('disabled', true);
              //       $('#anak').prop('checked', false);
              //       $('#anak').prop('disabled', false);
              //       $('#listanak').hide();
              //       $('#listanak').val(null);
              //       $('#listpasangan').hide();
              //       $('#listpasangan').val(null);
              //     }

                  if ((selisih > efektifitas)) {
                    passed = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Kuitansi sudah tidak bisa diajukan, <br> Kuitansi berlaku sebelum ' + efektifitas + ' Hari pengajuan',
                      showConfirmButton: false,
                      timer: 3500
                    });
                    var kosong = "";
                    $('#tanggal_kuitansi').val(kosong);
                    return false;
                  } else {
                    //Penambahan zulvan
                    var employee_nik = $("#employee_id").val();
                    var employee_group = $("#employee_group").val();
                    var grandparent = $("#request_grandparent_tambah").val();
                    var parent = $("#request_parent_tambah").val();
                    var child = $("#request_child_tambah").val();

                    var cek_limit_pagu = "form/cek_limit_pagu";

                    $.ajax({
                      url: cek_limit_pagu,
                      dataType: 'json',
                      type: 'POST',
                      data: {
                        tanggal_kuitansi: tanggal_kuitansi,
                        employee_nik: employee_nik,
                        employee_group: employee_group,
                        grandparent: grandparent,
                        parent: parent,
                        child: child,
                      },
                      success: function (pagu_remaining) {
                        var pagu_remaining = pagu_remaining;
                        if (pagu_remaining != false) {
                          $("#pagu_tahun").val(tanggal_kuitansi.substr(-4));
                          switch (grandparent) {
                            case '1': //rawat_jalan
                              var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(".", "").replaceAll(",", "");
                              var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
                              $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
                              break;
                            case '2': //rawat_inap
                              var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(".", "").replaceAll(",", "");
                              var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
                              $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
                              break;
                            default: //kacamata

                              if (child == '' || child == null) {
                                $("#sisa_limit").val(null);
                              } else {
                                switch (child) {
                                  case '12':
                                    var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val().replaceAll(".", "").replaceAll(",", "");
                                    var sisa_limit_kacamata_frame = parseInt(pagu_remaining['pagu_frame_dua_tahun']) - parseInt(sum_penggantian_kacamata_frame);
                                    $("#sisa_limit").val(formatRupiah.format(sisa_limit_kacamata_frame));
                                    break;
                                  case '13':
                                    var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val().replaceAll(".", "").replaceAll(",", "");
                                    var sisa_limit_one_focus = parseInt(pagu_remaining['pagu_one_focus_tahun']) - parseInt(sum_penggantian_kacamata_one_focus);
                                    $("#sisa_limit").val(formatRupiah.format(sisa_limit_one_focus));
                                    break;
                                  default:

                                    var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val().replaceAll(".", "").replaceAll(",", "");
                                    var sisa_limit_two_focus = parseInt(pagu_remaining['pagu_two_focus_tahun']) - parseInt(sum_penggantian_kacamata_two_focus);
                                    $("#sisa_limit").val(formatRupiah.format(sisa_limit_two_focus));
                                    break;
                                }
                              }
                              break;
                          }
                        }
                      }
                    });
                  }

              //   },
              //   error: function (data) {
              //     Swal.fire({
              //       position: 'center',
              //       icon: 'error',
              //       title: 'Data tidak dapat ditemukan',
              //       showConfirmButton: false,
              //       timer: 1500
              //     });
              //   }
              // });
              // ///////////End cek data couple 2025/////////////

            } else {
              passed = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Kuitansi sudah tidak bisa diajukan',
                showConfirmButton: false,
                timer: 3500
              });
              var kosong = "";
              $('#tanggal_kuitansi').val(kosong);
              return false;
            }
          }
        });
      } else {
        var year = new Date(data[0]['tanggal_kuitansi']);
        if (dateObjTanggalKuitansi.getFullYear() != year.getFullYear()) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Kuitansi Medical tahun ' + dateObjTanggalKuitansi.getFullYear() + ' tidak dapat digabung dengan tahun ' + year.getFullYear() + ', silahkan melakukan pengajuan sesuai pengelompokan tahun kuitansi',
            showConfirmButton: true
          });
          $("#tanggal_kuitansi").val(null);
        } else {


          // ///////////Start cek data couple 2025/////////////
          // var employee_nik = $("#employee_id").val();
          // var cek_data_couple = "form/cek_data_couple";
          // $.ajax({
          //   url: cek_data_couple,
          //   dataType: 'json',
          //   type: 'POST',
          //   data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
          //   success: function (data) {
          //     var employee_nik = $("#employee_id").val();
          //     var gender = $('#gender').val();
          //     var marital_status = $('#marital_status').val();
          //     if (marital_status == 'Single') {
          //       $('#dirisendiri').prop('checked', false);
          //       $('#pasangan').prop('checked', false);
          //       $('#pasangan').prop('disabled', true);
          //       $('#anak').prop('checked', false);
          //       $('#anak').prop('disabled', true);
          //       $('#listanak').hide();
          //       $('#listpasangan').hide();
          //     } else if (marital_status == 'Marr.') {
          //       if (gender == 'Male') {
          //         $('#dirisendiri').prop('checked', false);
          //         $('#dirisendiri').prop('disabled', false);
          //         $('#pasangan').prop('checked', false);
          //         $('#pasangan').prop('disabled', false);
          //         $('#anak').prop('checked', false);
          //         $('#anak').prop('disabled', false);
          //         $('#listpasangan').hide();
          //         $('#listpasangan').val(null);
          //         $('#listanak').hide();
          //         $('#listanak').val(null);
          //       } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
          //         // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?

          //         $('#dirisendiri').prop('checked', false);
          //         $('#dirisendiri').prop('disabled', false);
          //         $('#pasangan').prop('checked', false);
          //         $('#pasangan').prop('disabled', false);
          //         $('#anak').prop('checked', false);
          //         $('#anak').prop('disabled', false);
          //       } else {

          //         $('#dirisendiri').prop('checked', false);
          //         $('#dirisendiri').prop('disabled', false);
          //         $('#pasangan').prop('checked', false);
          //         $('#pasangan').prop('disabled', true);
          //         $('#anak').prop('checked', false);
          //         $('#anak').prop('disabled', true);
          //       }
          //     } else {
          //       $('#dirisendiri').prop('checked', false);
          //       $('#pasangan').prop('checked', false);
          //       $('#pasangan').prop('disabled', true);
          //       $('#anak').prop('checked', false);
          //       $('#anak').prop('disabled', false);
          //       $('#listanak').hide();
          //       $('#listanak').val(null);
          //       $('#listpasangan').hide();
          //       $('#listpasangan').val(null);
          //     }
          
              var cek_efektifitas_kuitansi = "form/cek_efektifitas_kuitansi";
              $.ajax({
                url: cek_efektifitas_kuitansi,
                dataType: 'json',
                type: 'POST',
                data: { tanggal_kuitansi: tanggal_kuitansi },
                success: function (efektifitas) {
                  var efektifitas = efektifitas;
                  if (efektifitas != false) {
                    if ((selisih > efektifitas)) {
                      passed = 0;
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Kuitansi sudah tidak bisa diajukan, <br> Kuitansi berlaku sebelum ' + efektifitas + ' Hari pengajuan',
                        showConfirmButton: false,
                        timer: 3500
                      });
                      var kosong = "";
                      $('#tanggal_kuitansi').val(kosong);
                      return false;
                    } else {
                      //Penambahan zulvan
                      var employee_nik = $("#employee_id").val();
                      var employee_group = $("#employee_group").val();
                      var grandparent = $("#request_grandparent_tambah").val();
                      var parent = $("#request_parent_tambah").val();
                      var child = $("#request_child_tambah").val();

                      var cek_limit_pagu = "form/cek_limit_pagu";

                      $.ajax({
                        url: cek_limit_pagu,
                        dataType: 'json',
                        type: 'POST',
                        data: {
                          tanggal_kuitansi: tanggal_kuitansi,
                          employee_nik: employee_nik,
                          employee_group: employee_group,
                          grandparent: grandparent,
                          parent: parent,
                          child: child,
                        },
                        success: function (pagu_remaining) {
                          var pagu_remaining = pagu_remaining;
                          if (pagu_remaining != false) {
                            $("#pagu_tahun").val(tanggal_kuitansi.substr(-4));
                            switch (grandparent) {
                              case '1': //rawat_jalan
                                var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(".", "").replaceAll(",", "");
                                var sisa_limit_jalan = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
                                $("#sisa_limit").val(formatRupiah.format(sisa_limit_jalan));
                                // console.log(formatRupiah.format(sisa_limit_jalan));
                                break;
                              case '2': //rawat_inap
                                var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(".", "").replaceAll(",", "");
                                var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
                                $("#sisa_limit").val(formatRupiah.format(sisa_limit_inap));
                                break;
                              default: //kacamata
                                if (child == '' || child == null) {
                                  $("#sisa_limit").val(null);
                                } else {
                                  switch (child) {
                                    case '12':
                                      var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val().replaceAll(".", "").replaceAll(",", "");
                                      var sisa_limit_kacamata_frame = parseInt(pagu_remaining['pagu_frame_dua_tahun']) - parseInt(sum_penggantian_kacamata_frame);
                                      $("#sisa_limit").val(formatRupiah.format(sisa_limit_kacamata_frame));
                                      break;
                                    case '13':
                                      var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val().replaceAll(".", "").replaceAll(",", "");
                                      var sisa_limit_one_focus = parseInt(pagu_remaining['pagu_one_focus_tahun']) - parseInt(sum_penggantian_kacamata_one_focus);
                                      $("#sisa_limit").val(formatRupiah.format(sisa_limit_one_focus));
                                      break;
                                    default:

                                      var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val().replaceAll(".", "").replaceAll(",", "");
                                      var sisa_limit_two_focus = parseInt(pagu_remaining['pagu_two_focus_tahun']) - parseInt(sum_penggantian_kacamata_two_focus);
                                      $("#sisa_limit").val(formatRupiah.format(sisa_limit_two_focus));
                                      break;
                                  }
                                }
                                break;
                            }
                          }
                        }
                      });
                    }


                  } else {
                    passed = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Kuitansi sudah tidak bisa diajukan',
                      showConfirmButton: false,
                      timer: 3500
                    });
                    var kosong = "";
                    $('#tanggal_kuitansi').val(kosong);
                    return false;
                  }
                }
              });
              
          //   },
          //   error: function (data) {
          //     Swal.fire({
          //       position: 'center',
          //       icon: 'error',
          //       title: 'Data tidak dapat ditemukan',
          //       showConfirmButton: false,
          //       timer: 1500
          //     });
          //   }
          // });
          // ///////////End cek data couple/////////////

        }
      }
    }
  });

});

$('#total_nominal_kuitansi').on('change', function () {
  var request_id = $("#request_id").val();
  var tanggal_kuitansi = $("#tanggal_kuitansi").val();
  var total = $("#total_nominal_kuitansi").val();
  total = parseFloat(total.replace(/\D+/g, ""));
  var persentase = 100 / 100;
  var request_grandparent_tambah = $("#request_grandparent_tambah").val();
  var request_parent_tambah = $("#request_parent_tambah").val();
  var request_child_tambah = $("#request_child_tambah").val();
  var harga_kamar = $("#harga_kamar").val();
  harga_kamar = parseFloat(harga_kamar.replace(/\D+/g, ""));

  //return false;

  // alert(request_grandparent_tambah);
  // console.log(request_grandparent_tambah);


  if ((request_grandparent_tambah == "") || (request_grandparent_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    var kosong = "";
    $('#total_nominal_kuitansi').val(kosong);
    return false;

  } else if ((request_parent_tambah == "") || (request_parent_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    var kosong = "";
    $('#total_nominal_kuitansi').val(kosong);
    return false;

  } else if ((request_child_tambah == "") || (request_child_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Detil Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    var kosong = "";
    $('#total_nominal_kuitansi').val(kosong);
    return false;

  } else if (request_grandparent_tambah == 1) {

    // ==================================== old ====================================
    // var temp_limit_rawat_jalan = $("#temp_limit_rawat_jalan").val();
    // temp_limit_rawat_jalan = parseFloat(temp_limit_rawat_jalan.replace(/,/g, ''));

    // var sum_penggantian_jalan = $("#sum_penggantian_jalan").val();
    // sum_penggantian_jalan = parseFloat(sum_penggantian_jalan.replace(/,/g, ''));

    // var limit_rawat_jalan = $("#limit_rawat_jalan").val();
    // limit_rawat_jalan = parseFloat(limit_rawat_jalan.replace(/,/g, ''));

    // var pengganti = total * persentase;

    // if (temp_limit_rawat_jalan <= 0 ){
    //   var penggantian = 0;
    //   Swal.fire({
    //     position: 'center',
    //     icon: 'info',
    //     title: 'Pagu Rawat Jalan anda telah habis',
    //     showConfirmButton: true
    //   });
    // }else if(temp_limit_rawat_jalan >= pengganti){
    //   var penggantian = pengganti;
    // }else if(temp_limit_rawat_jalan < pengganti){
    //   var penggantian = temp_limit_rawat_jalan;
    //   Swal.fire({
    //     position: 'center',
    //     icon: 'info',
    //     title: 'Total Kuitansi lebih besar dari Pagu Rawat Jalan, <br>Akan dilakukan penyesuaian penggantian',
    //     showConfirmButton: true
    //   });
    // }

    // ==================================== new ====================================
    //revisi zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih
    var temp_limit = $("#sisa_limit").val();
    temp_limit = parseFloat(temp_limit.replaceAll(".", '').replaceAll(",", ''));

    var pengganti = total * persentase;

    if (temp_limit <= 0) {
      var penggantian = 0;
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Pagu Rawat Jalan anda telah habis',
        showConfirmButton: true
      });
    } else if (temp_limit >= pengganti) {
      var penggantian = pengganti;
    } else if (temp_limit < pengganti) {
      var penggantian = temp_limit;
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Total Kuitansi lebih besar dari Pagu Rawat Jalan, <br>Akan dilakukan penyesuaian penggantian',
        showConfirmButton: true
      });
    }
    $('#penggantian').val(penggantian);
  } else if (request_grandparent_tambah == 2) {

    // ==================================== old ====================================
    // var temp_limit_rawat_inap = $("#temp_limit_rawat_inap").val();
    // temp_limit_rawat_inap = parseFloat(temp_limit_rawat_inap.replace(/,/g, ''));

    // var sum_penggantian_inap = $("#sum_penggantian_inap").val();
    // sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));

    // var limit_rawat_inap = $("#limit_rawat_inap").val();
    // limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));

    // ==================================== new ====================================
    //revisi zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih

    var temp_limit = $("#sisa_limit").val();
    temp_limit = parseFloat(temp_limit.replaceAll('.', '').replaceAll(",", ''));

    // var sum_penggantian_inap = $("#sum_penggantian_inap").val();
    // sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));

    // var limit_rawat_inap = $("#limit_rawat_inap").val();
    // limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));

    // if((grandparent == 2) && (parent == 3) && (child == 18)){
    //   $('.s_harga_kamar').show();
    // }else if ((grandparent == 2) && (parent == 3) && (child != 18)){
    //   $('.s_harga_kamar').hide();
    // }

    if ((request_parent_tambah == 3) && (request_child_tambah == 15) && (harga_kamar == "") || (harga_kamar === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Harga kamar tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    } else if ((request_parent_tambah != 3) && (request_child_tambah != 15) && (harga_kamar == "") || (harga_kamar === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Harga kamar tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    } else if ((request_parent_tambah == 3) && (request_child_tambah != 15) && (harga_kamar == "") || (harga_kamar === undefined)) {

    }


    if (request_child_tambah == 9) {
      var status = 'Normal';
      var cek_limit_maternity = "form/cek_limit_maternity";
      $.ajax({
        url: cek_limit_maternity,
        dataType: 'json',
        type: 'POST',
        data: { status: status },
        success: function (data_lim_mat) {
          var lim_mat = data_lim_mat;
          if (lim_mat < total) {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Total Kuitansi lebih besar dari Pagu Maternity (Kelahiran Normal), <br>Akan dilakukan penyesuaian penggantian',
              showConfirmButton: true
            });

            //total = lim_mat;
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);

                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * (total * persentase)));
                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit < lim_mat) {
                          var penggantian = temp_limit;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit;
                      }
                      // var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {
                  var pengganti = total * persentase;

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit < lim_mat) {
                          var penggantian = temp_limit;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit;
                      }
                      // var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian').val(penggantian);
              }
            });


          } else {
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);
                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian').val(penggantian);
              }
            });

          }


        }
      });


    } else if (request_child_tambah == 10) {

      var status = 'Caesar';
      var cek_limit_maternity = "form/cek_limit_maternity";
      $.ajax({
        url: cek_limit_maternity,
        dataType: 'json',
        type: 'POST',
        data: { status: status },
        success: function (data_lim_mat) {
          var lim_mat = data_lim_mat;
          if (lim_mat < total) {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Total Kuitansi lebih besar dari Pagu Maternity (Kelahiran Caesar), <br>Akan dilakukan penyesuaian penggantian',
              showConfirmButton: true
            });

            // total = lim_mat;
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);

                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * (total * persentase)));

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });

                      if (pengganti >= lim_mat) {
                        if (temp_limit < lim_mat) {
                          var penggantian = temp_limit;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit;
                      }
                      // var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {
                  var pengganti = total * persentase;

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit < lim_mat) {
                          var penggantian = temp_limit;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit;
                      }
                      // var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian').val(penggantian);
              }
            });


          } else {
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);
                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian').val(penggantian);
              }
            });

          }


        }
      });


    } else if (request_child_tambah == 11) {

      var status = 'Normal';
      var cek_limit_maternity = "form/cek_limit_maternity";
      $.ajax({
        url: cek_limit_maternity,
        dataType: 'json',
        type: 'POST',
        data: { status: status },
        success: function (data_lim_mat) {
          var lim_mat = data_lim_mat;
          lim_mat = (lim_mat * (50 / 100));
          if (lim_mat <= total) {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Total Kuitansi lebih besar dari Pagu Maternity (Keguguran), <br>Akan dilakukan penyesuaian penggantian',
              showConfirmButton: true
            });

            // total = lim_mat;
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = data_limit;

                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * (total * persentase)));

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });

                      if (pengganti >= lim_mat) {
                        if (temp_limit < lim_mat) {
                          var penggantian = temp_limit;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit;
                      }
                      // var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit < lim_mat) {
                          var penggantian = temp_limit;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit;
                      }
                      // var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian').val(penggantian);
              }
            });


          } else {
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = data_limit;
                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      var penggantian = temp_limit;
                    } else if (temp_limit >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian').val(penggantian);
              }
            });

          }


        }
      });

    } else {
      var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
      $.ajax({
        url: cek_limit_harga_kamar,
        dataType: 'json',
        type: 'POST',
        data: {},
        success: function (data_limit) {
          var limit_kamar = parseFloat(data_limit);

          if (limit_kamar < harga_kamar) {

            var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

            if (temp_limit <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu rawat inap anda sudah habis',
                showConfirmButton: true
              });
            } else {
              if (temp_limit < pengganti) {
                Swal.fire({
                  position: 'center',
                  icon: 'info',
                  title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                  showConfirmButton: true
                });
                var penggantian = temp_limit;
              } else if (temp_limit >= pengganti) {
                var penggantian = pengganti;
              }

            }

          } else {

            var pengganti = total * persentase;

            if (temp_limit <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu rawat inap anda sudah habis',
                showConfirmButton: true
              });
            } else {
              if (temp_limit < pengganti) {
                Swal.fire({
                  position: 'center',
                  icon: 'info',
                  title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                  showConfirmButton: true
                });
                var penggantian = temp_limit;
              } else if (temp_limit >= pengganti) {
                var penggantian = pengganti;
              }

            }

          }

          $('#penggantian').val(penggantian);
        }
      });
    }
  } else if (request_grandparent_tambah == 3) {
    if ((request_parent_tambah == 5) && (request_child_tambah == 12)) {

      var cek_tanggal_pengambilan_kacamata = "form/cek_tanggal_pengambilan_kacamata";
      $.ajax({
        url: cek_tanggal_pengambilan_kacamata,
        dataType: 'json',
        type: 'POST',
        data: {
          request_id: request_id,
          request_grandparent_tambah: request_grandparent_tambah,
          request_parent_tambah: request_parent_tambah,
          request_child_tambah: request_child_tambah,
          kind: 'tambah'
        },
        success: function (response) {
          if (response['tanggal_req'] == 'Kosong') {
            //var jarak_tahun = 1;
          } else {
            // var data_tanggal = new Date(data_tanggal);
            // var today = new Date();
            // var tahun_last_req = data_tanggal.getFullYear();
            // var tahun_new_req = today.getFullYear();
            // var jarak_tahun = tahun_new_req - tahun_last_req;


            var data_tanggal = new Date(response['tanggal_req']);
            var today = new Date();
            var last_req = new Date(data_tanggal.getMonth() + 1 + "/" + data_tanggal.getDate() + "/" + data_tanggal.getFullYear());
            var tgl_pengajuan = new Date(tanggal_kuitansi);

            var selisih_tanggal = tgl_pengajuan.getTime() - last_req.getTime();
            var selisih_tahun_dalam_hari = ((selisih_tanggal / (1000 * 3600 * 24)) / 2);
          }

          // if ((jarak_tahun >= 2) || (data_tanggal == 'Kosong')) {
          if ((selisih_tahun_dalam_hari >= 365) || (response['tanggal_req'] == 'Kosong')) {
            // ==================================== old ====================================
            // var temp_limit_kacamata_frame = $("#temp_limit_kacamata_frame").val();
            // temp_limit_kacamata_frame = parseFloat(temp_limit_kacamata_frame.replace(/,/g, ''));

            // var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val();
            // sum_penggantian_kacamata_frame = parseFloat(sum_penggantian_kacamata_frame.replace(/,/g, ''));

            // var limit_kacamata_frame = $("#limit_kacamata_frame").val();
            // limit_kacamata_frame = parseFloat(limit_kacamata_frame.replace(/,/g, ''));

            // var pengganti = total * persentase;

            // ==================================== new ====================================
            //revisi zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih
            var limit_kacamata_frame = $("#sisa_limit").val();
            console.log(limit_kacamata_frame);
            limit_kacamata_frame = parseFloat(limit_kacamata_frame.replaceAll(".", "").replaceAll(",", ''));

            var pengganti = total * persentase;
            if (limit_kacamata_frame <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu kacamata frame anda telah habis',
                showConfirmButton: true
              });
            } else if (limit_kacamata_frame >= pengganti) {
              var penggantian = pengganti;
            } else if (limit_kacamata_frame < pengganti) {
              var penggantian = limit_kacamata_frame;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Total Kuitansi lebih besar dari Pagu Kacamata (Frame), <br>Akan dilakukan penyesuaian penggantian',
                showConfirmButton: true
              });
            }

            $('#penggantian').val(penggantian);

          } else {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Anda sudah pernah melakukan klaim penggantian kacamata untuk frame, <br>klaim berlaku 2 tahun sekali',
              showConfirmButton: true
            });

          }

        }
      });

    } else if ((request_parent_tambah == 6) && (request_child_tambah == 13)) {

      var cek_tanggal_pengambilan_kacamata = "form/cek_tanggal_pengambilan_kacamata";
      $.ajax({
        url: cek_tanggal_pengambilan_kacamata,
        dataType: 'json',
        type: 'POST',
        data: {
          request_id: request_id,
          request_grandparent_tambah: request_grandparent_tambah,
          request_parent_tambah: request_parent_tambah,
          request_child_tambah: request_child_tambah,
          kind: 'tambah'
        },
        success: function (response) {
          if (response['tanggal_req'] == 'Kosong') {
            //var jarak_tahun = 1;
          } else {
            // var data_tanggal = new Date(data_tanggal);
            // var today = new Date();
            // var tahun_last_req = data_tanggal.getFullYear();
            // var tahun_new_req = today.getFullYear();
            // var jarak_tahun = tahun_new_req - tahun_last_req;
            var data_tanggal = new Date(response['tanggal_req']);
            var today = new Date();
            var last_req = new Date(data_tanggal.getMonth() + 1 + "/" + data_tanggal.getDate() + "/" + data_tanggal.getFullYear());
            var tgl_pengajuan = new Date(tanggal_kuitansi);

            var selisih_tanggal = tgl_pengajuan.getTime() - last_req.getTime();
            var selisih_tahun_dalam_hari = selisih_tanggal / (1000 * 3600 * 24);
          }

          if ((selisih_tahun_dalam_hari >= 365) || (response['tanggal_req'] == 'Kosong')) {
            // ==================================== old ====================================

            // var temp_limit_kacamata_one_focus = $("#temp_limit_kacamata_one_focus").val();
            // temp_limit_kacamata_one_focus = parseFloat(temp_limit_kacamata_one_focus.replace(/,/g, ''));

            // var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val();
            // sum_penggantian_kacamata_one_focus = parseFloat(sum_penggantian_kacamata_one_focus.replace(/,/g, ''));

            // var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
            // limit_kacamata_one_focus = parseFloat(limit_kacamata_one_focus.replace(/,/g, ''));

            // var pengganti = total * persentase;

            // ==================================== new ====================================
            //revisi zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih
            var limit_kacamata_one_focus = $("#sisa_limit").val();
            limit_kacamata_one_focus = parseInt(limit_kacamata_one_focus.replaceAll(".", "").replaceAll(",", ''));

            var pengganti = total * persentase;

            if (limit_kacamata_one_focus <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu kacamata one focus anda telah habis',
                showConfirmButton: true
              });
            } else if (limit_kacamata_one_focus >= pengganti) {
              var penggantian = pengganti;
            } else if (limit_kacamata_one_focus < pengganti) {
              var penggantian = limit_kacamata_one_focus;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Total Kuitansi lebih besar dari Pagu Kacamata (One Focus), <br>Akan dilakukan penyesuaian penggantian',
                showConfirmButton: true
              });
            }

            $('#penggantian').val(penggantian);

          } else {
            console.log('zul3');

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Anda sudah pernah melakukan klaim penggantian kacamata untuk lensa, <br>klaim berlaku 1 tahun sekali',
              showConfirmButton: true
            });

            document.getElementById('form_Add_Claim').reset();
            $('#form_Add_Claim').trigger('reset');
            var get_Grandparent = "form/get_Grandparent";
            $.ajax({
              url: get_Grandparent,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data) {
                $('#request_grandparent_tambah').html(data);
                $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
                $('#request_child_tambah').html('<option value="">Penggantian</option>');
              }
            });

          }
        }

      });

    } else if ((request_parent_tambah == 6) && (request_child_tambah == 14)) {

      var cek_tanggal_pengambilan_kacamata = "form/cek_tanggal_pengambilan_kacamata";
      $.ajax({
        url: cek_tanggal_pengambilan_kacamata,
        dataType: 'json',
        type: 'POST',
        data: {
          request_id: request_id,
          request_grandparent_tambah: request_grandparent_tambah,
          request_parent_tambah: request_parent_tambah,
          request_child_tambah: request_child_tambah,
          kind: 'tambah'
        },
        success: function (response) {
          if (response['tanggal_req'] == 'Kosong') {
            //var jarak_tahun = 1;
          } else {
            // var data_tanggal = new Date(data_tanggal);
            // var today = new Date();
            // var tahun_last_req = data_tanggal.getFullYear();
            // var tahun_new_req = today.getFullYear();
            // var jarak_tahun = tahun_new_req - tahun_last_req;

            var data_tanggal = new Date(response['tanggal_req']);
            var today = new Date();
            var last_req = new Date(data_tanggal.getMonth() + 1 + "/" + data_tanggal.getDate() + "/" + data_tanggal.getFullYear());
            var tgl_pengajuan = new Date(tanggal_kuitansi);

            var selisih_tanggal = tgl_pengajuan.getTime() - last_req.getTime();
            var selisih_tahun_dalam_hari = selisih_tanggal / (1000 * 3600 * 24);
          }

          if ((selisih_tahun_dalam_hari >= 365) || (response['tanggal_req'] == 'Kosong')) {
            // ==================================== old ====================================
            // var temp_limit_kacamata_two_focus = $("#temp_limit_kacamata_two_focus").val();
            // temp_limit_kacamata_two_focus = parseFloat(temp_limit_kacamata_two_focus.replace(/,/g, ''));

            // var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val();
            // sum_penggantian_kacamata_two_focus = parseFloat(sum_penggantian_kacamata_two_focus.replace(/,/g, ''));

            // var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
            // limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replace(/,/g, ''));

            // var pengganti = total * persentase;

            // ==================================== new ====================================
            //revisi zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih

            var limit_kacamata_two_focus = $("#sisa_limit").val();
            console.log(limit_kacamata_two_focus);
            limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replaceAll(".", "").replaceAll(",", ''));
            var pengganti = total * persentase;
            if (limit_kacamata_two_focus <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu kacamata two focus anda telah habis',
                showConfirmButton: true
              });
            } else if (limit_kacamata_two_focus >= pengganti) {
              var penggantian = pengganti;
            } else if (limit_kacamata_two_focus < pengganti) {
              var penggantian = limit_kacamata_two_focus;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Total Kuitansi lebih besar dari Pagu Kacamata (Two Focus), <br>Akan dilakukan penyesuaian penggantian',
                showConfirmButton: true
              });
            }

            $('#penggantian').val(penggantian);

          } else {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Anda sudah pernah melakukan klaim penggantian kacamata untuk lensa, <br>klaim berlaku 1 tahun sekali',
              showConfirmButton: true
            });

            document.getElementById('form_Add_Claim').reset();
            $('#form_Add_Claim').trigger('reset');
            var get_Grandparent = "form/get_Grandparent";
            $.ajax({
              url: get_Grandparent,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data) {
                $('#request_grandparent_tambah').html(data);
                $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
                $('#request_child_tambah').html('<option value="">Penggantian</option>');
              }
            });

          }
        }

      });
    }

  }

});


$('.req_medical_tambah').click(function () {
  var request_id = $("#request_id").val();
  var tor_grandparent = $("#request_grandparent_tambah").val();
  var tor_parent = $("#request_parent_tambah").val();
  var tor_child = $("#request_child_tambah").val();
  var jumlah_kuitansi = $("#jumlah_kuitansi").val();
  var total_kuitansi = $("#total_nominal_kuitansi").val();
  total_kuitansi = parseFloat(total_kuitansi.replace(/\D+/g, ""));
  var tanggal_kuitansi = $("#tanggal_kuitansi").val();
  var dateObjTanggalKuitansi = new Date(tanggal_kuitansi);
  var docter = $("#docter").val();
  var diagnosa = $("#diagnosa").val();
  var harga_kamar = $("#harga_kamar").val();
  harga_kamar = parseFloat(harga_kamar.replace(/\D+/g, ""));
  var penggantian = $("#penggantian").val();

  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();
  var nik = $('#employee_id').val();
  var today = new Date();
  var selisih = Math.floor(hitungSelisihHari(tanggal_kuitansi, today));

  if ((tor_grandparent == "") || (tor_grandparent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((tor_parent == "") || (tor_parent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((tor_child == "") || (tor_child === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Detail Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((jumlah_kuitansi == "") || (jumlah_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jumlah Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((total_kuitansi == "") || (total_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Total Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((docter == "") || (docter === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Dokter tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((diagnosa == "") || (diagnosa === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Diagnosa tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((tanggal_kuitansi == "") || (tanggal_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Tanggal Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((penggantian == "") || (penggantian === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((penggantian <= 0)) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Saldo Penggantian telah habis',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if (((tor_grandparent == 3) || (tor_parent == 4)) && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
      showConfirmButton: false,
      timer: 2500
    });
    return false;
  } else if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
      showConfirmButton: false,
      timer: 2500
    });
    return false;
  } else if ((selisih > 45)) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Kuitansi sudah tidak bisa diajukan',
      showConfirmButton: false,
      timer: 2500
    });
    return false;
  }


  var request_family_a = document.getElementsByName('customRadioTor');
  var request_family;
  for (var i = 0; i < request_family_a.length; i++) {
    if (request_family_a[i].checked) {
      request_family = request_family_a[i].value;
    }
  }
  if (request_family === undefined) {
    request_family = ''
  }

  if ((request_family == "") || (request_family === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Keterangan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  var anak = $("#listanak").val();
  var pasangan = $("#listpasangan").val();

  if (request_family === 'Diri Sendiri') {
    var additional = 'Diri Sendiri';
  } else if (request_family === 'Pasangan') {
    if ((pasangan == "") || (pasangan === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Pasangan tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
    var additional = pasangan;
  } else if (request_family === 'Anak') {
    if ((anak == "") || (anak === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Anak tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
    var additional = anak;
  }

  var get_medical_item_year = "form/get_medical_item_year";
  $.ajax({
    url: get_medical_item_year,
    dataType: 'json',
    type: 'POST',
    data: { request_id: request_id },
    success: function (data) {
      if (data == null || data == '') {
        var url = "form/tambah_tor";

        $.ajax({
          url: url,
          dataType: 'json',
          type: 'POST',
          data: {
            request_id: request_id,
            tor_grandparent: tor_grandparent,
            tor_parent: tor_parent,
            tor_child: tor_child,
            jumlah_kuitansi: jumlah_kuitansi,
            total_kuitansi: total_kuitansi,
            penggantian: penggantian,
            request_family: request_family,
            additional: additional,
            docter: docter,
            diagnosa: diagnosa,
            tanggal_kuitansi: tanggal_kuitansi,
            harga_kamar: harga_kamar
          },
          success: function (data) {
            if (data == true) {
              $('#ToR').DataTable().ajax.reload();
              $('#form_Add_Claim').trigger("reset");
              $("#request_grandparent_tambah").select2('', 'Jenis Penggantian');
              $('#request_parent_tambah').html('<option value=""></option>');
              $('#request_child_tambah').html('<option value=""></option>');
              // $('#modalAddClaim').modal('toggle');
              $('#modalAddClaim').modal('hide');

              var get_sum_penggantian_jalan = "form/get_sum_penggantian_jalan";
              $.ajax({
                url: get_sum_penggantian_jalan,
                method: 'POST',
                dataType: 'json',
                data: { request_id: request_id },
                success: function (data_jalan) {
                  var sum_penggantian_jalan = Intl.NumberFormat().format(data_jalan[0].sum_penggantian);
                  $('#sum_penggantian_jalan').val(sum_penggantian_jalan);
                  var limit_rawat_jalan = $("#limit_rawat_jalan").val();
                  sum_penggantian_jalan = parseInt(sum_penggantian_jalan.replaceAll('.', '').replaceAll(",", ''));
                  limit_rawat_jalan = parseInt(limit_rawat_jalan.replace(/,/g, ''));
                  var sisa_pagu_jalan = limit_rawat_jalan - sum_penggantian_jalan;
                  $('#temp_limit_rawat_jalan').val(sisa_pagu_jalan);

                  if (sum_penggantian_jalan > limit_rawat_jalan) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit rawat jalan',
                      showConfirmButton: true
                    });
                  }
                }
              });

              var get_sum_penggantian_inap = "form/get_sum_penggantian_inap";
              $.ajax({
                url: get_sum_penggantian_inap,
                method: 'POST',
                dataType: 'json',
                data: { request_id: request_id },
                success: function (data_inap) {
                  var sum_penggantian_inap = Intl.NumberFormat().format(data_inap[0].sum_penggantian);
                  $('#sum_penggantian_inap').val(sum_penggantian_inap);
                  var limit_rawat_inap = $("#limit_rawat_inap").val();
                  sum_penggantian_inap = parseInt(sum_penggantian_inap.replaceAll('.', '').replaceAll(",", ''));
                  limit_rawat_inap = parseInt(limit_rawat_inap.replace(/,/g, ''));
                  var sisa_pagu_inap = limit_rawat_inap - sum_penggantian_inap;
                  $('#temp_limit_rawat_inap').val(sisa_pagu_inap);
                  if (sum_penggantian_inap > limit_rawat_inap) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit rawat inap',
                      showConfirmButton: true
                    });
                  }
                }
              });

              var get_sum_penggantian_kacamata = "form/get_sum_penggantian_kacamata";
              $.ajax({
                url: get_sum_penggantian_kacamata,
                method: 'POST',
                dataType: 'json',
                data: { request_id: request_id },
                success: function (data_kacamata) {

                  var sum_penggantian_kacamata_frame = Intl.NumberFormat().format(data_kacamata[0].sum_frame);
                  $('#sum_penggantian_kacamata_frame').val(sum_penggantian_kacamata_frame);
                  var limit_kacamata_frame = $("#limit_kacamata_frame").val();
                  sum_penggantian_kacamata_frame = parseInt(sum_penggantian_kacamata_frame.replaceAll('.', '').replaceAll(",", ''));
                  limit_kacamata_frame = parseInt(limit_kacamata_frame.replaceAll(',', '').replaceAll(".", ''));
                  var sisa_pagu_frame = limit_kacamata_frame - sum_penggantian_kacamata_frame;
                  $('#temp_limit_kacamata_frame').val(sisa_pagu_frame);

                  if (sum_penggantian_kacamata_frame > limit_kacamata_frame) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit frame kacamata',
                      showConfirmButton: true
                    });
                  }

                  var sum_penggantian_kacamata_one_focus = Intl.NumberFormat().format(data_kacamata[0].sum_one_focus);
                  $('#sum_penggantian_kacamata_one_focus').val(sum_penggantian_kacamata_one_focus);
                  var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
                  sum_penggantian_kacamata_one_focus = parseInt(sum_penggantian_kacamata_one_focus.replaceAll('.', '').replaceAll(",", ''));
                  limit_kacamata_one_focus = parseInt(limit_kacamata_one_focus.replaceAll(',', '').replaceAll(".", ''));
                  var sisa_pagu_one_focus = limit_kacamata_one_focus - sum_penggantian_kacamata_one_focus;
                  $('#temp_limit_kacamata_one_focus').val(sisa_pagu_one_focus);

                  if (sum_penggantian_kacamata_one_focus > limit_kacamata_one_focus) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit kacamata one focus',
                      showConfirmButton: true
                    });
                  }

                  var sum_penggantian_kacamata_two_focus = Intl.NumberFormat().format(data_kacamata[0].sum_two_focus);
                  $('#sum_penggantian_kacamata_two_focus').val(sum_penggantian_kacamata_two_focus);
                  var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
                  sum_penggantian_kacamata_two_focus = parseInt(sum_penggantian_kacamata_two_focus.replaceAll('.', '').replaceAll(",", ''));
                  limit_kacamata_two_focus = parseInt(limit_kacamata_two_focus.replaceAll(',', '').replaceAll(".", ''));
                  var sisa_pagu_two_focus = limit_kacamata_two_focus - sum_penggantian_kacamata_two_focus;
                  $('#temp_limit_kacamata_two_focus').val(sisa_pagu_two_focus);

                  if (sum_penggantian_kacamata_two_focus > limit_kacamata_two_focus) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit kacamata two focus',
                      showConfirmButton: true
                    });
                  }

                }
              });

             Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data telah ditambahkan',
                showConfirmButton: false,
                timer: 2500
              });

            }
          },
          error: function (data) {
            $('#ToR').DataTable().ajax.reload();
            document.getElementById("form_Add_Claim").reset();
            $('#form_Add_Claim').trigger("reset");
            $("#request_grandparent_tambah").select2('', 'Jenis Penggantian');
            $('#request_parent_tambah').html('<option value=""></option>');
            $('#request_child_tambah').html('<option value=""></option>');
            // $('#modalAddClaim').modal('toggle');
            $('#modalAddClaim').modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Data tidak dapat ditambahkan',
              showConfirmButton: false,
              timer: 1500
            });
          }``
        });
      } else {
        var year = new Date(data[0]['tanggal_kuitansi']);
        if (dateObjTanggalKuitansi.getFullYear() != year.getFullYear()) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Kuitansi Medical tahun ' + dateObjTanggalKuitansi.getFullYear() + ' tidak dapat digabung dengan tahun ' + year.getFullYear() + ', silahkan melakukan pengajuan sesuai pengelompokan tahun kuitansi',
            showConfirmButton: true
          });
        } else {
          var url = "form/tambah_tor";

          $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            data: {
              request_id: request_id,
              tor_grandparent: tor_grandparent,
              tor_parent: tor_parent,
              tor_child: tor_child,
              jumlah_kuitansi: jumlah_kuitansi,
              total_kuitansi: total_kuitansi,
              penggantian: penggantian,
              request_family: request_family,
              additional: additional,
              docter: docter,
              diagnosa: diagnosa,
              tanggal_kuitansi: tanggal_kuitansi,
              harga_kamar: harga_kamar
            },
            success: function (data) {
              if (data == true) {
                $('#ToR').DataTable().ajax.reload();
                $('#form_Add_Claim').trigger("reset");
                $("#request_grandparent_tambah").select2('', 'Jenis Penggantian');
                $('#request_parent_tambah').html('<option value=""></option>');
                $('#request_child_tambah').html('<option value=""></option>');
                // $('#modalAddClaim').modal('toggle');
                $('#modalAddClaim').modal('hide');

                var get_sum_penggantian_jalan = "form/get_sum_penggantian_jalan";
                $.ajax({
                  url: get_sum_penggantian_jalan,
                  method: 'POST',
                  dataType: 'json',
                  data: { request_id: request_id },
                  success: function (data_jalan) {
                    var sum_penggantian_jalan = Intl.NumberFormat().format(data_jalan[0].sum_penggantian);
                    $('#sum_penggantian_jalan').val(sum_penggantian_jalan);
                    var limit_rawat_jalan = $("#limit_rawat_jalan").val();
                    sum_penggantian_jalan = parseInt(sum_penggantian_jalan.replaceAll('.', '').replaceAll(",", ''));
                    limit_rawat_jalan = parseInt(limit_rawat_jalan.replaceAll(',', '').replaceAll(".", ''));
                    var sisa_pagu_jalan = limit_rawat_jalan - sum_penggantian_jalan;
                    $('#temp_limit_rawat_jalan').val(sisa_pagu_jalan);

                    if (sum_penggantian_jalan > limit_rawat_jalan) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit rawat jalan',
                        showConfirmButton: true
                      });
                    }
                  }
                });

                var get_sum_penggantian_inap = "form/get_sum_penggantian_inap";
                $.ajax({
                  url: get_sum_penggantian_inap,
                  method: 'POST',
                  dataType: 'json',
                  data: { request_id: request_id },
                  success: function (data_inap) {
                    var sum_penggantian_inap = Intl.NumberFormat().format(data_inap[0].sum_penggantian);
                    $('#sum_penggantian_inap').val(sum_penggantian_inap);
                    var limit_rawat_inap = $("#limit_rawat_inap").val();
                    sum_penggantian_inap = parseInt(sum_penggantian_inap.replaceAll('.', '').replaceAll(",", ''));
                    limit_rawat_inap = parseInt(limit_rawat_inap.replaceAll(',', '').replaceAll(".", ''));
                    var sisa_pagu_inap = limit_rawat_inap - sum_penggantian_inap;
                    $('#temp_limit_rawat_inap').val(sisa_pagu_inap);
                    if (sum_penggantian_inap > limit_rawat_inap) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit rawat inap',
                        showConfirmButton: true
                      });
                    }
                  }
                });

                var get_sum_penggantian_kacamata = "form/get_sum_penggantian_kacamata";
                $.ajax({
                  url: get_sum_penggantian_kacamata,
                  method: 'POST',
                  dataType: 'json',
                  data: { request_id: request_id },
                  success: function (data_kacamata) {

                    var sum_penggantian_kacamata_frame = Intl.NumberFormat().format(data_kacamata[0].sum_frame);
                    $('#sum_penggantian_kacamata_frame').val(sum_penggantian_kacamata_frame);
                    var limit_kacamata_frame = $("#limit_kacamata_frame").val();
                    sum_penggantian_kacamata_frame = parseInt(sum_penggantian_kacamata_frame.replaceAll('.', '').replaceAll(",", ''));
                    limit_kacamata_frame = parseInt(limit_kacamata_frame.replaceAll(',', '').replaceAll(".", ''));
                    var sisa_pagu_frame = limit_kacamata_frame - sum_penggantian_kacamata_frame;
                    $('#temp_limit_kacamata_frame').val(sisa_pagu_frame);

                    if (sum_penggantian_kacamata_frame > limit_kacamata_frame) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit frame kacamata',
                        showConfirmButton: true
                      });
                    }

                    var sum_penggantian_kacamata_one_focus = Intl.NumberFormat().format(data_kacamata[0].sum_one_focus);
                    $('#sum_penggantian_kacamata_one_focus').val(sum_penggantian_kacamata_one_focus);
                    var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
                    sum_penggantian_kacamata_one_focus = parseInt(sum_penggantian_kacamata_one_focus.replaceAll('.', '').replaceAll(",", ''));
                    limit_kacamata_one_focus = parseInt(limit_kacamata_one_focus.replaceAll(',', '').replaceAll(".", ''));
                    var sisa_pagu_one_focus = limit_kacamata_one_focus - sum_penggantian_kacamata_one_focus;
                    $('#temp_limit_kacamata_one_focus').val(sisa_pagu_one_focus);

                    if (sum_penggantian_kacamata_one_focus > limit_kacamata_one_focus) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit kacamata one focus',
                        showConfirmButton: true
                      });
                    }

                    var sum_penggantian_kacamata_two_focus = Intl.NumberFormat().format(data_kacamata[0].sum_two_focus);
                    $('#sum_penggantian_kacamata_two_focus').val(sum_penggantian_kacamata_two_focus);
                    var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
                    sum_penggantian_kacamata_two_focus = parseInt(sum_penggantian_kacamata_two_focus.replaceAll('.', '').replaceAll(",", ''));
                    limit_kacamata_two_focus = parseInt(limit_kacamata_two_focus.replaceAll(',', '').replaceAll(".", ''));
                    var sisa_pagu_two_focus = limit_kacamata_two_focus - sum_penggantian_kacamata_two_focus;
                    $('#temp_limit_kacamata_two_focus').val(sisa_pagu_two_focus);

                    if (sum_penggantian_kacamata_two_focus > limit_kacamata_two_focus) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit kacamata two focus',
                        showConfirmButton: true
                      });
                    }

                  }
                });

                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Data telah ditambahkan',
                  showConfirmButton: false,
                  timer: 2500
                });


              }
            },
            error: function (data) {
              $('#ToR').DataTable().ajax.reload();
              document.getElementById("form_Add_Claim").reset();
              $('#form_Add_Claim').trigger("reset");
              $("#request_grandparent_tambah").select2('', 'Jenis Penggantian');
              $('#request_parent_tambah').html('<option value=""></option>');
              $('#request_child_tambah').html('<option value=""></option>');
              // $('#modalAddClaim').modal('toggle');
              $('#modalAddClaim').modal('hide');
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Data tidak dapat ditambahkan',
                showConfirmButton: false,
                timer: 1500
              });
            }``
          });
        }
      }
    }
  });
});

function delete_tor(delete_tor) {
  var id = document.getElementById(delete_tor).getAttribute("id");
  var request_id = $(".delete_tor").attr("data");

  var url = 'form/delete_tor/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      $('#ToR').DataTable().ajax.reload();

      var get_sum_penggantian_jalan = "form/get_sum_penggantian_jalan";
      $.ajax({
        url: get_sum_penggantian_jalan,
        method: 'POST',
        dataType: 'json',
        data: { request_id: request_id },
        success: function (data_jalan) {
          var sum_penggantian_jalan = Intl.NumberFormat().format(data_jalan[0].sum_penggantian);
          $('#sum_penggantian_jalan').val(sum_penggantian_jalan);
          sum_penggantian_jalan = parseInt(sum_penggantian_jalan.replaceAll('.', '').replaceAll(",", ''));
          var limit_rawat_jalan = $("#limit_rawat_jalan").val();
          limit_rawat_jalan = parseInt(limit_rawat_jalan.replaceAll(',', '').replaceAll(".", ''));
          var sisa_pagu_jalan = limit_rawat_jalan - sum_penggantian_jalan;
          $('#temp_limit_rawat_jalan').val(sisa_pagu_jalan);

        }
      });

      var get_sum_penggantian_inap = "form/get_sum_penggantian_inap";
      $.ajax({
        url: get_sum_penggantian_inap,
        method: 'POST',
        dataType: 'json',
        data: { request_id: request_id },
        success: function (data_inap) {
          var sum_penggantian_inap = Intl.NumberFormat().format(data_inap[0].sum_penggantian);
          $('#sum_penggantian_inap').val(sum_penggantian_inap);
          sum_penggantian_inap = parseInt(sum_penggantian_inap.replaceAll('.', '').replaceAll(",", ''));
          var limit_rawat_inap = $("#limit_rawat_inap").val();
          limit_rawat_inap = parseInt(limit_rawat_inap.replaceAll(',', '').replaceAll(",", ''));
          var sisa_pagu_inap = limit_rawat_inap - sum_penggantian_inap;
          $('#temp_limit_rawat_inap').val(sisa_pagu_inap);

        }
      });

      var get_sum_penggantian_kacamata = "form/get_sum_penggantian_kacamata";
      $.ajax({
        url: get_sum_penggantian_kacamata,
        method: 'POST',
        dataType: 'json',
        data: { request_id: request_id },
        success: function (data_kacamata) {
          var sum_penggantian_kacamata_frame = Intl.NumberFormat().format(data_kacamata[0].sum_frame);
          $('#sum_penggantian_kacamata_frame').val(sum_penggantian_kacamata_frame);
          sum_penggantian_kacamata_frame = parseInt(sum_penggantian_kacamata_frame.replaceAll('.', '').replaceAll(",", ''));
          var limit_kacamata_frame = $("#limit_kacamata_frame").val();
          limit_kacamata_frame = parseInt(limit_kacamata_frame.replaceAll(',', '').replaceAll(".", ''));
          var sisa_pagu_frame = limit_kacamata_frame - sum_penggantian_kacamata_frame;
          $('#temp_limit_kacamata_frame').val(sisa_pagu_frame);

          var sum_penggantian_kacamata_one_focus = Intl.NumberFormat().format(data_kacamata[0].sum_one_focus);
          $('#sum_penggantian_kacamata_one_focus').val(sum_penggantian_kacamata_one_focus);
          sum_penggantian_kacamata_one_focus = parseInt(sum_penggantian_kacamata_one_focus.replaceAll('.', '').replaceAll(",", ''));
          var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
          limit_kacamata_one_focus = parseInt(limit_kacamata_one_focus.replaceAll(',', '').replaceAll(".", ''));
          var sisa_pagu_one_focus = limit_kacamata_one_focus - sum_penggantian_kacamata_one_focus;
          $('#temp_limit_kacamata_one_focus').val(sisa_pagu_one_focus);

          var sum_penggantian_kacamata_two_focus = Intl.NumberFormat().format(data_kacamata[0].sum_two_focus);
          $('#sum_penggantian_kacamata_two_focus').val(sum_penggantian_kacamata_two_focus);
          sum_penggantian_kacamata_two_focus = parseInt(sum_penggantian_kacamata_two_focus.replaceAll('.', '').replaceAll(",", ''));
          var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
          limit_kacamata_two_focus = parseInt(limit_kacamata_two_focus.replaceAll(',', '').replaceAll(".", ''));
          var sisa_pagu_two_focus = limit_kacamata_two_focus - sum_penggantian_kacamata_two_focus;
          $('#temp_limit_kacamata_two_focus').val(sisa_pagu_two_focus);

        }
      });

      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Item deleted',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
  });
};

function edit_tor(edit_tor) {
  var id = document.getElementById(edit_tor).getAttribute("id");
  var url = 'form/edit_tor/';
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();
  var employee_group = $("#employee_group").val();
  var marital_status = $('#marital_status').val();
  var gender = $('#gender').val();
  // var tanggal_kuitansi_edit = $("#tanggal_kuitansi_edit").val();
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      var get_Grandparent = "form/edit_Grandparent";
      $.ajax({
        url: get_Grandparent,
        dataType: 'json',
        type: 'POST',
        data: { id: response[0].tor_grandparent },
        success: function (data) {
          $('#request_grandparent_edit').html(data);
        }
      });

      var get_Parent = "form/edit_Parent";
      $.ajax({
        url: get_Parent,
        dataType: 'json',
        type: 'POST',
        data: { id: id },
        success: function (data) {
          $('#request_parent_edit').html(data);
        }
      });

      var get_Child = "form/edit_Child";
      $.ajax({
        url: get_Child,
        dataType: 'json',
        type: 'POST',
        data: { id: id },
        success: function (data) {
          $('#request_child_edit').html(data);
        }
      });

      if (response[0].keterangan == 'Diri Sendiri') {
        if (marital_status == 'Single') {
          // $('#dirisendiri_edit').prop('checked', false);
          $('#pasangan_edit').prop('checked', false);
          $('#pasangan_edit').prop('disabled', true);
          $('#anak_edit').prop('checked', false);
          $('#anak_edit').prop('disabled', true);
          $('#listanak_edit').hide();
          $('#listpasangan_edit').hide();
        } else if (marital_status == 'Marr.') {
          if (gender == 'Male') {
            $('#dirisendiri_edit').prop('checked', true);
            $('#pasangan_edit').prop('checked', false);
            $('#pasangan_edit').prop('disabled', false);
            $('#anak_edit').prop('checked', false);
            $('#anak_edit').prop('disabled', false);
          } else {
            $('#dirisendiri_edit').prop('checked', true);
            $('#pasangan_edit').prop('checked', false);
            $('#pasangan_edit').prop('disabled', true);
            $('#anak_edit').prop('checked', false);
            $('#anak_edit').prop('disabled', true);
          }
        } else {
          $('#dirisendiri_edit').prop('checked', true);
          $('#pasangan_edit').prop('checked', false);
          $('#pasangan_edit').prop('disabled', true);
          $('#anak_edit').prop('checked', false);
          $('#anak_edit').prop('disabled', false);
          // $('#listanak').hide();
          // $('#listpasangan').hide();
        }
        ////---old---
        // $('#dirisendiri_edit').prop('checked', true);
        // $('#pasangan_edit').prop('disabled', true);
        // $('#anak_edit').prop('disabled', true);
        // $('#listpasangan_edit').hide();
        // // $('#listpasangan_edit').val(null);
        // $('#listanak_edit').hide();
        // $('#listanak_edit').val(null);        
      } else if (response[0].keterangan == 'Pasangan') {
        var get_FamilySpouse = "form/getDetailFamilySpouse";
        $.ajax({
          url: get_FamilySpouse,
          dataType: 'json',
          type: 'POST',
          data: { id: response[0].additional, employee_id: response[0].employee_id },
          success: function (data) {
            if (marital_status == 'Single') {
              $('#dirisendiri_edit').prop('checked', false);
              // $('#pasangan_edit').prop('checked', false);
              // $('#pasangan_edit').prop('disabled', true);
              $('#anak_edit').prop('checked', false);
              $('#anak_edit').prop('disabled', true);
              $('#listanak_edit').hide();
              // $('#listpasangan_edit').hide();
            } else if (marital_status == 'Marr.') {
              if (gender == 'Male') {
                $('#dirisendiri_edit').prop('checked', false);
                // $('#pasangan_edit').prop('checked', false);
                // $('#pasangan_edit').prop('disabled', false);
                $('#anak_edit').prop('checked', false);
                $('#anak_edit').prop('disabled', false);
              } else {
                $('#dirisendiri_edit').prop('checked', false);
                // $('#pasangan_edit').prop('checked', false);
                // $('#pasangan_edit').prop('disabled', true);
                $('#anak_edit').prop('checked', false);
                $('#anak_edit').prop('disabled', true);
              }
            } else {
              $('#dirisendiri_edit').prop('checked', false);
              // $('#pasangan_edit').prop('checked', false);
              // $('#pasangan_edit').prop('disabled', true);
              $('#anak_edit').prop('checked', false);
              $('#anak_edit').prop('disabled', false);
              $('#listanak').hide();
              // $('#listpasangan').hide();
            }
            $('#pasangan_edit').prop('checked', true);
            // $('#dirisendiri_edit').prop('disabled', true);
            // $('#anak_edit').prop('disabled', true);
            $('#listpasangan_edit').show();
            $('#listpasangan_edit').html(data);
            // $('#request_child_edit').html(data);
          }
        });
      } else if (response[0].keterangan == 'Anak') {
        var get_FamilyChild = "form/getDetailFamilyChild";
        $.ajax({
          url: get_FamilyChild,
          dataType: 'json',
          type: 'POST',
          data: { id: response[0].additional, tanggal_kuitansi: response[0].tanggal_kuitansi, employee_id: response[0].employee_id },
          success: function (data) {
            if (marital_status == 'Single') {
              $('#dirisendiri_edit').prop('checked', false);
              $('#pasangan_edit').prop('checked', false);
              $('#pasangan_edit').prop('disabled', true);
              // $('#anak_edit').prop('checked', false);
              // $('#anak_edit').prop('disabled', true);
              // $('#listanak_edit').hide();
              $('#listpasangan_edit').hide();
            } else if (marital_status == 'Marr.') {
              if (gender == 'Male') {
                $('#dirisendiri_edit').prop('checked', false);
                $('#pasangan_edit').prop('checked', false);
                $('#pasangan_edit').prop('disabled', false);
                // $('#anak_edit').prop('checked', false);
                // $('#anak_edit').prop('disabled', false);
              } else {
                $('#dirisendiri_edit').prop('checked', false);
                $('#pasangan_edit').prop('checked', false);
                $('#pasangan_edit').prop('disabled', true);
                // $('#anak_edit').prop('checked', false);
                // $('#anak_edit').prop('disabled', true);
              }
            } else {
              $('#dirisendiri_edit').prop('checked', false);
              $('#pasangan_edit').prop('checked', false);
              $('#pasangan_edit').prop('disabled', true);
              // $('#anak_edit').prop('checked', false);
              // $('#anak_edit').prop('disabled', false);
              // $('#listanak').hide();
              $('#listpasangan').hide();
            }
            $('#anak_edit').prop('checked', true);
            // $('#dirisendiri_edit').prop('disabled', true);
            // $('#pasangan_edit').prop('disabled', true);
            $('#listanak_edit').show();
            $('#listanak_edit').html(data);
          }
        });
      } else {
      };

      if (response[0].tanggal_kuitansi != '' && response[0].tanggal_kuitansi != null) {
        var grandparent = response[0].tor_grandparent;
        var child = response[0].tor_child;
        var cek_limit_pagu = "form/cek_limit_pagu";
        $.ajax({
          url: cek_limit_pagu,
          dataType: 'json',
          type: 'POST',
          data: {
            tanggal_kuitansi: response[0].tanggal_kuitansi,
            employee_nik: response[0].employee_id,
            employee_group: employee_group,
            grandparent: grandparent
          },
          success: function (pagu_remaining) {
            var pagu_remaining = pagu_remaining;
            if (pagu_remaining != false) {
              $("#pagu_tahun_edit").val(response[0].tanggal_kuitansi.substring(0, 4));
              switch (grandparent) {
                case '1': //rawat_jalan
                  var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(".", "").replaceAll(",", '');
                  var sisa_limit_jalan = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
                  $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_jalan));
                  break;
                case '2': //rawat_inap
                  var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(".", "").replaceAll(",", '');
                  var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
                  $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
                  break;
                default: //kacamata
                  if (child == '' || child == null) {
                    $("#sisa_limit_edit").val(null);
                  } else {
                    switch (child) {
                      case '12':
                        var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val().replaceAll(".", "").replaceAll(",", '');
                        var sisa_limit_kacamata_frame = parseInt(pagu_remaining['pagu_frame_dua_tahun']) - parseInt(sum_penggantian_kacamata_frame);
                        $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_kacamata_frame));
                        break;
                      case '13':
                        var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val().replaceAll(".", "").replaceAll(",", '');
                        var sisa_limit_one_focus = parseInt(pagu_remaining['pagu_one_focus_tahun']) - parseInt(sum_penggantian_kacamata_one_focus);
                        $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_one_focus));
                        break;
                      default:
                        var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val().replaceAll(".", "").replaceAll(",", '');
                        var sisa_limit_two_focus = parseInt(pagu_remaining['pagu_two_focus_tahun']) - parseInt(sum_penggantian_kacamata_two_focus);
                        $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_two_focus));
                        break;
                    }
                  }
                  break;
              }
            }
          }
        });
      }
      console.log('hehe');
      var kuitansi_date = response[0].tanggal_kuitansi;
      var [year, month, day] = kuitansi_date.split('-');
      var result_date = [month, day, year].join('/');
      $("#req_medical_ubah").attr('item_value', id);
      $("#sisa_limit_edit").addClass('sisaLimitEdit' + id);
      $("#jumlah_kuitansi_edit").val(response[0].jumlah_kuitansi);
      $("#tanggal_kuitansi_edit").val(result_date);
      $("#total_nominal_kuitansi_edit").val(formatRupiah.format(response[0].total_nominal_kuitansi));
      $("#total_nominal_kuitansi_edit").attr('item_id', edit_tor);
      $("#docter_edit").val(response[0].docter);
      $("#diagnosa_edit").val(response[0].diagnosa);
      $("#penggantian_edit").val(response[0].penggantian);
      if (response[0].harga_kamar > 0) {
        $('.s_harga_kamar').show();
        $("#harga_kamar_edit").val(response[0].harga_kamar);
      }
      $("#pagu_tahun_edit").val(response[0].tanggal_kuitansi.substring(0, 4));

      //$('.data_edit_pagu_rawat_inap').modal('show');
      // var id = response[0].id;
      // var start_date = response[0].start_date;
      // var end_date = response[0].end_date;
      // var grade = response[0].grade;
      // var pagu_tahun = response[0].pagu_tahun;
      // var pagu_kamar_hari = response[0].pagu_kamar_hari;

      // $("#id_edit_rawat_inap").val(id);
      // $("#start_date_edit_rawat_inap").val(start_date);
      // $("#end_date_edit_rawat_inap").val(end_date);
      // $("#grade_edit_rawat_inap").val(grade).change();
      // $("#pagu_kamar_edit_rawat_inap").val(pagu_kamar_hari);
      // $("#pagu_tahun_edit_rawat_inap").val(pagu_tahun);
    }
  });

}



// $('#request_grandparent_edit').change(function () {
//   var grandparent = $('#request_grandparent_edit').val();
//   if (grandparent != '') {
//     var get_Parent = "master/get_Parent";
//     $.ajax({
//       url: get_Parent,
//       method: 'POST',
//       data: { grandparent: grandparent },
//       success: function (data) {
//         $('#request_parent_edit').html(data);
//         $('#request_child_edit').html('<option value="">Penggantian</option>');
//       }
//     });

//   }
//   else {
//     $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
//     $('#request_child_edit').html('<option value="">Penggantian</option>');
//   }
// });

$('[name="customRadioTorEdit"]').on('change', function () {
  var state = this.id == 'anak';
  $('[name="listanak_edit"]').toggle(state);

  var state_p = this.id == 'pasangan';
  $('[name="listpasangan_edit"]').toggle(state_p);

  var tanggal_kuitansi = $("#tanggal_kuitansi_edit").val();

  if ((tanggal_kuitansi == "") || (tanggal_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Tanggal Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });

    $('.listanak_edit').hide();
    var ele = document.getElementsByName("customRadioTorEdit");
    for (var i = 0; i < ele.length; i++)
      ele[i].checked = false;

    $('.listpasangan_edit').hide();
    var elee = document.getElementsByName("customRadioTorEdit");
    for (var j = 0; j < elee.length; j++)
      elee[j].checked = false;

    return false;
  } else {
    var value = $(this).val();
    if (value == 'Anak') {
      var getFamilyChild = "form/getFamilyChild";
      $.ajax({
        url: getFamilyChild,
        dataType: 'json',
        type: 'POST',
        data: { tanggal_kuitansi: tanggal_kuitansi },
        success: function (data) {
          $('#listanak_edit').show();
          $('#listanak_edit').html(data);
        }
      });
    } else if (value == 'Pasangan') {
      var getFamilySpouse = "form/getFamilySpouse";
      $.ajax({
        url: getFamilySpouse,
        dataType: 'json',
        type: 'POST',
        data: { tanggal_kuitansi: tanggal_kuitansi },
        success: function (data) {
          $('#listpasangan_edit').show();
          $('#listpasangan_edit').html(data);
        }
      });
    } else {
      $('#listpasangan_edit').hide();
      $('#listpasangan_edit').val('');
      $('#listanak_edit').hide();
      $('#listanak_edit').val('data');
    }
  }
});

$('#request_grandparent_edit').on('change', function () {
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();
  var employee_group = $("#employee_group").val();
  var grandparent = $('#request_grandparent_edit').val();
  var gender = $('#gender').val();
  var marital_status = $('#marital_status').val();
  var nik = $('#employee_id').val();
  var hak_pengajuan = $("#hak_pengajuan").val();
  //penambahan zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih
  var tanggal_kuitansi = $("#tanggal_kuitansi_edit").val();

  if (((employee_subgroup != 'Contract') && (grandparent == 3)) && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'warning',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Edit_Claim').reset();
    $('#form_Edit_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_edit').html(data);
        $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
        $('#request_child_edit').html('<option value="">Penggantian</option>');
      }
    });
    return false;

  } else if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Edit_Claim').reset();
    $('#form_Edit_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_edit').html(data);
        $('#request_parent_edit').val('<option value="">Sub Penggantian</option>');
        $('#request_child_edit').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else {
    // document.getElementById('form_Edit_Claim').reset();
    // $('#form_Edit_Claim').trigger('reset');
    var get_Parent = "form/get_Parent";
    $.ajax({
      url: get_Parent,
      dataType: 'json',
      type: 'POST',
      data: { grandparent: grandparent, employee_group: employee_group },
      success: function (data) {
        $('#request_parent_edit').html(data);
        $('#request_child_edit').html('<option value="">Penggantian</option>');
        var kosong = "";
        $('#jumlah_kuitansi_edit').val(kosong);
        $('#total_nominal_kuitansi_edit').val(kosong);
        $('#harga_kamar_edit').val(kosong);
        $('#penggantian_edit').val(kosong);

        // $('#dirisendiri_edit').prop('checked', false);
        // $('#pasangan_edit').prop('checked', false);
        // $('#anak_edit').prop('checked', false);
        // $('#listanak_edit').val(null);
        // $('#listanak_edit').hide();
        // $('#listpasangan_edit').val(null);
        // $('#listpasangan_edit').hide();
        // $('#dirisendiri_edit').prop('disabled', true);
        // $('#pasangan_edit').prop('disabled', true);
        // $('#anak_edit').prop('disabled', true);

        if (grandparent == 2) {
          $('.s_harga_kamar').show();
        } else {
          $('.s_harga_kamar').hide();
          $('#harga_kamar_edit').val(null);
        }

        if ((grandparent == 3)) {
          document.getElementById("pasangan_edit").disabled = true;
          document.getElementById("anak_edit").disabled = true;
        }

        ///////////Start cek data couple 2025/////////////
        var tanggal_kuitansi = $("#tanggal_kuitansi").val();
        if (tanggal_kuitansi == null || tanggal_kuitansi == '' || tanggal_kuitansi === undefined) {
          var tanggal_kuitansi = new Date();
          var dd = String(tanggal_kuitansi.getDate()).padStart(2, '0');
          var mm = String(tanggal_kuitansi.getMonth() + 1).padStart(2, '0'); //January is 0!
          var yyyy = tanggal_kuitansi.getFullYear();
          tanggal_kuitansi = mm + '/' + dd + '/' + yyyy;
        }
        var employee_nik = $("#employee_id").val();
        var cek_data_couple = "form/cek_data_couple";
        $.ajax({
          url: cek_data_couple,
          dataType: 'json',
          type: 'POST',
          data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
          success: function (data) {
            var employee_nik = $("#employee_id").val();
            var gender = $('#gender').val();
            var marital_status = $('#marital_status').val();

            if (marital_status == 'Single') {
              $('#dirisendiri').prop('checked', false);
              $('#pasangan').prop('checked', false);
              $('#pasangan').prop('disabled', true);
              $('#anak').prop('checked', false);
              $('#anak').prop('disabled', true);
              $('#listanak').hide();
              $('#listpasangan').hide();
            } else if (marital_status == 'Marr.') {
              if (gender == 'Male') {
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', false);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', false);
                $('#listpasangan').hide();
                $('#listpasangan').val(null);
                $('#listanak').hide();
                $('#listanak').val(null);
              } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', false);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', false);
              } else {
                $('#dirisendiri').prop('checked', false);
                $('#dirisendiri').prop('disabled', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', true);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', true);
              }
            } else {
              $('#dirisendiri').prop('checked', false);
              $('#pasangan').prop('checked', false);
              $('#pasangan').prop('disabled', true);
              $('#anak').prop('checked', false);
              $('#anak').prop('disabled', false);
              $('#listanak').hide();
              $('#listanak').val(null);
              $('#listpasangan').hide();
              $('#listpasangan').val(null);
            }
          },
          error: function (data) {
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Data tidak dapat ditemukan',
              showConfirmButton: false,
              timer: 1500
            });
          }
        });
        ///////////End cek data couple 2025/////////////

        //penambahan zulvan menampilkan tahun pagu dan sisa limit pagu saat buat dokumen medclaim  
        if (tanggal_kuitansi !== null && tanggal_kuitansi !== '') {
          var cek_limit_pagu = "form/cek_limit_pagu";

          $.ajax({
            url: cek_limit_pagu,
            dataType: 'json',
            type: 'POST',
            data: {
              tanggal_kuitansi: tanggal_kuitansi,
              employee_nik: nik,
              employee_group: employee_group,
              grandparent: grandparent
            },
            success: function (pagu_remaining) {
              var pagu_remaining = pagu_remaining;
              if (pagu_remaining != false) {
                $("#pagu_tahun_edit").val(tanggal_kuitansi.substr(-4));
                if (grandparent == '1') {
                  var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(",", "").replaceAll(".", '');
                  var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
                  $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
                } else if (grandparent == '2') {
                  var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(",", "").replaceAll(".", '');
                  var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
                  $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
                } else {
                  // $("#pagu_tahun").val(null);
                  $("#sisa_limit_edit").val(null);
                }
              }
            }
          });
        }

      }
      // error: function (data) {
      // }
    });
    return false;
  }


  //else{
  //   document.getElementById("pasangan").disabled = false;
  //   document.getElementById("anak").disabled = false;
  // }

});

$('#request_parent_edit').change(function () {
  // var parent = $('#request_parent_edit').val();

  // if (parent != '') {
  //   var get_Child = "master/get_Child";
  //   $.ajax({
  //     url: get_Child,
  //     method: 'POST',
  //     data: { parent: parent },
  //     success: function (data) {
  //       $('#request_child_edit').html(data);
  //       $('#harga_kamar_edit').val(null);
  //       $('.s_harga_kamar').hide();

  //     }
  //   });
  // }
  // else {
  //   $('#request_child_edit').html('<option value="">Penggantian</option>');
  // }

  var parent = $('#request_parent_edit').val();
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();
  var employee_group = $("#employee_group").val();
  var marital_status = $('#marital_status').val();
  var gender = $('#gender').val();
  var hak_pengajuan = $("#hak_pengajuan").val();
  // if (((parent == 4) || (parent == 7)) && (join_years < 1)) {
  if (((parent == 4)) && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    if (gender == 'Male' && marital_status != 'Marr.') {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Maaf Marital Status anda tidak bisa mengajukan<br>Klaim Kehamilan dan Melahirkan',
        showConfirmButton: false,
        timer: 2500
      });
    } else {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
        showConfirmButton: false,
        timer: 2500
      });
    }
    document.getElementById('form_Edit_Claim').reset();
    $('#form_Edit_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_edit').html(data);
        $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
        $('#request_child_edit').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else if ((parent == 6 || parent == 5) && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan lensa<br>Masa kerja masih kurang dari satu tahun',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Add_Claim').reset();
    $('#form_Add_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_tambah').html(data);
        $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
        $('#request_child_tambah').html('<option value="">Penggantian</option>');
      }
    });
    return false;
    // } else if ((parent == 5) && (join_years < 2)) {
    //   Swal.fire({
    //     position: 'center',
    //     icon: 'info',
    //     title: 'Belum bisa melakukan pengajuan frame<br>Masa kerja masih kurang dari dua tahun',
    //     showConfirmButton: false,
    //     timer: 2500
    //   });
    //   document.getElementById('form_Add_Claim').reset();
    //   $('#form_Add_Claim').trigger('reset');
    //   var get_Grandparent = "form/get_Grandparent";
    //   $.ajax({
    //     url: get_Grandparent,
    //     dataType: 'json',
    //     type: 'POST',
    //     data: {},
    //     success: function (data) {
    //       $('#request_grandparent_tambah').html(data);
    //       $('#request_parent_tambah').html('<option value="">Sub Penggantian</option>');
    //       $('#request_child_tambah').html('<option value="">Penggantian</option>');
    //     }
    //   });
    //   return false;

  } else if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    if (gender == 'Male' && marital_status != 'Marr.') {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Maaf Marital Status anda tidak bisa mengajukan<br>Klaim Kehamilan dan Melahirkan',
        showConfirmButton: false,
        timer: 2500
      });
    } else {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
        showConfirmButton: false,
        timer: 2500
      });
    }
    document.getElementById('form_Edit_Claim').reset();
    $('#form_Edit_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_edit').html(data);
        $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
        $('#request_child_edit').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else if (((marital_status == 'Div.') || (marital_status == 'Wid.') || (marital_status == 'Single')) && ((parent == 4) || (parent == 7))) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Maaf Marital Status anda tidak bisa mengajukan<br>Klaim Kehamilan dan Melahirkan',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Edit_Claim').reset();
    $('#form_Edit_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_edit').html(data);
        $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
        $('#request_child_edit').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  } else {
    var get_Child = "form/get_Child";
    $.ajax({
      url: get_Child,
      method: 'POST',
      data: { parent: parent },
      success: function (data) {
        var kosong = "";
        $('#request_child_edit').html(data);

        $('#harga_kamar_edit').val(null);
        $('.s_harga_kamar').hide();
        $('#total_nominal_kuitansi_edit').val(kosong);
        $('#penggantian_edit').val(kosong);

        if (parent == 9) {
          if (employee_group == 'GOL A') {
            $('#dirisendiri_edit').prop('checked', false);
            $('#dirisendiri_edit').prop('disabled', false);
            $('#pasangan_edit').prop('checked', false);
            $('#pasangan_edit').prop('disabled', false);
            $('#listpasangan_edit').hide();
            $('#listpasangan_edit').val(null);
            $('#anak_edit').prop('checked', false);
            $('#anak_edit').prop('disabled', true);
            $('#listanak_edit').hide();
            $('#listanak_edit').val(null);
          } else {
            $('#dirisendiri_edit').prop('checked', false);
            $('#dirisendiri_edit').prop('disabled', false);
            $('#pasangan_edit').prop('checked', false);
            $('#pasangan_edit').prop('disabled', true);
            $('#listpasangan_edit').hide();
            $('#listpasangan_edit').val(null);
            $('#anak_edit').prop('checked', false);
            $('#anak_edit').prop('disabled', true);
            $('#listanak_edit').hide();
            $('#listanak_edit').val(null);
          }
        } else if (parent == 7) {
          if (gender == 'Male') {
            $('#dirisendiri_edit').prop('checked', false);
            $('#dirisendiri_edit').prop('disabled', true);
            $('#pasangan_edit').prop('checked', false);
            $('#pasangan_edit').prop('disabled', false);
            $('#anak_edit').prop('checked', false);
            $('#anak_edit').prop('disabled', true);
            $('#listanak_edit').hide();
            $('#listanak_edit').val(null);
            $('#listpasangan_edit').hide();
            $('#listpasangan_edit').val(null);
          } else {
            $('#dirisendiri_edit').prop('checked', false);
            $('#dirisendiri_edit').prop('disabled', false);
            $('#pasangan_edit').prop('checked', false);
            $('#pasangan_edit').prop('disabled', true);
            $('#anak_edit').prop('checked', false);
            $('#anak_edit').prop('disabled', true);
            $('#listanak_edit').hide();
            $('#listanak_edit').val(null);
            $('#listpasangan_edit').hide();
            $('#listpasangan_edit').val(null);
          }
        } else {
          ///////////Start cek data couple 2025/////////////
          var tanggal_kuitansi = $("#tanggal_kuitansi").val();
          if (tanggal_kuitansi == null || tanggal_kuitansi == '' || tanggal_kuitansi === undefined) {
            var tanggal_kuitansi = new Date();
            var dd = String(tanggal_kuitansi.getDate()).padStart(2, '0');
            var mm = String(tanggal_kuitansi.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = tanggal_kuitansi.getFullYear();
            tanggal_kuitansi = mm + '/' + dd + '/' + yyyy;
          }
          var employee_nik = $("#employee_id").val();
          var cek_data_couple = "form/cek_data_couple";
          $.ajax({
            url: cek_data_couple,
            dataType: 'json',
            type: 'POST',
            data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
            success: function (data) {
              var employee_nik = $("#employee_id").val();
              var gender = $('#gender').val();
              var marital_status = $('#marital_status').val();

              if (marital_status == 'Single') {
                $('#dirisendiri').prop('checked', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', true);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', true);
                $('#listanak').hide();
                $('#listpasangan').hide();
              } else if (marital_status == 'Marr.') {
                if (gender == 'Male') {
                  $('#dirisendiri').prop('checked', false);
                  $('#dirisendiri').prop('disabled', false);
                  $('#pasangan').prop('checked', false);
                  $('#pasangan').prop('disabled', false);
                  $('#anak').prop('checked', false);
                  $('#anak').prop('disabled', false);
                  $('#listpasangan').hide();
                  $('#listpasangan').val(null);
                  $('#listanak').hide();
                  $('#listanak').val(null);
                } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                  // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                  $('#dirisendiri').prop('checked', false);
                  $('#dirisendiri').prop('disabled', false);
                  $('#pasangan').prop('checked', false);
                  $('#pasangan').prop('disabled', false);
                  $('#anak').prop('checked', false);
                  $('#anak').prop('disabled', false);
                } else {
                  $('#dirisendiri').prop('checked', false);
                  $('#dirisendiri').prop('disabled', false);
                  $('#pasangan').prop('checked', false);
                  $('#pasangan').prop('disabled', true);
                  $('#anak').prop('checked', false);
                  $('#anak').prop('disabled', true);
                }
              } else {
                $('#dirisendiri').prop('checked', false);
                $('#pasangan').prop('checked', false);
                $('#pasangan').prop('disabled', true);
                $('#anak').prop('checked', false);
                $('#anak').prop('disabled', false);
                $('#listanak').hide();
                $('#listanak').val(null);
                $('#listpasangan').hide();
                $('#listpasangan').val(null);
              }
            },
            error: function (data) {
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Data tidak dapat ditemukan',
                showConfirmButton: false,
                timer: 1500
              });
            }
          });
          ///////////End cek data couple 2025/////////////
          // $('#dirisendiri_edit').prop('checked', false);
          // $('#dirisendiri_edit').prop('disabled', false);
          // $('#pasangan_edit').prop('checked', false);
          // $('#pasangan_edit').prop('disabled', false);
          // $('#anak_edit').prop('checked', false);
          // $('#anak_edit').prop('disabled', false);
          // $('#listanak_edit').hide();
          // $('#listanak_edit').val(null);
          // $('#listpasangan_edit').hide();
          // $('#listpasangan_edit').val(null);
        }
      }
    });
  }



});

$('#request_child_edit').on('change', function () {
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var grandparent = $('#request_grandparent_edit').val();
  var parent = $('#request_parent_edit').val();
  var child = $('#request_child_edit').val();
  var employee_subgroup = $("#employee_subgroup").val();

  var marital_status = $('#marital_status').val();
  var hak_pengajuan = $('#hak_pengajuan').val();
  var gender = $('#gender').val();

  var nik = $('#employee_id').val();
  var employee_group = $("#employee_group").val();
  var tanggal_kuitansi = $("#tanggal_kuitansi_edit").val();

  if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
      showConfirmButton: false,
      timer: 2500
    });
    document.getElementById('form_Edit_Claim').reset();
    $('#form_Edit_Claim').trigger('reset');
    var get_Grandparent = "form/get_Grandparent";
    $.ajax({
      url: get_Grandparent,
      dataType: 'json',
      type: 'POST',
      data: {},
      success: function (data) {
        $('#request_grandparent_edit').html(data);
        $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
        $('#request_child_edit').html('<option value="">Penggantian</option>');
      }
    });
    return false;
  }

  if (tanggal_kuitansi !== null && tanggal_kuitansi !== '') {
    var cek_limit_pagu = "form/cek_limit_pagu";

    $.ajax({
      url: cek_limit_pagu,
      dataType: 'json',
      type: 'POST',
      data: {
        tanggal_kuitansi: tanggal_kuitansi,
        employee_nik: nik,
        employee_group: employee_group,
        grandparent: grandparent,
        parent: parent,
        child: child,
      },
      success: function (pagu_remaining) {
        var pagu_remaining = pagu_remaining;
        if (pagu_remaining != false) {
          $("#pagu_tahun_edit").val(tanggal_kuitansi.substr(-4));
          switch (grandparent) {
            case '1': //rawat_jalan
              var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(",", "").replaceAll(".", '');
              var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
              $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
              break;
            case '2': //rawat_inap
              var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(",", "").replaceAll(".", '');
              var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
              $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
              break;
            default: //kacamata
              if (child == '' || child == null) {
                $("#sisa_limit_edit").val(null);
              } else {
                switch (child) {
                  case '12':
                    var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val().replaceAll(",", "").replaceAll(".", '');
                    var sisa_limit_kacamata_frame = parseInt(pagu_remaining['pagu_frame_dua_tahun']) - parseInt(sum_penggantian_kacamata_frame);
                    $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_kacamata_frame));
                    break;
                  case '13':
                    var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val().replaceAll(",", "").replaceAll(".", '');
                    var sisa_limit_one_focus = parseInt(pagu_remaining['pagu_one_focus_tahun']) - parseInt(sum_penggantian_kacamata_one_focus);
                    $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_one_focus));
                    break;
                  default:
                    var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val().replaceAll(",", "").replaceAll(".", '');
                    var sisa_limit_two_focus = parseInt(pagu_remaining['pagu_two_focus_tahun']) - parseInt(sum_penggantian_kacamata_two_focus);
                    $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_two_focus));
                    break;
                }
              }
              break;
          }
        }
      }
    });
  }

  var kosong = "";
  $('#total_nominal_kuitansi_edit').val(kosong);
  $('#penggantian_edit').val(kosong);

  // if ((grandparent == 2) && (parent == 3) && (child == 18)) {
  //   $('.s_harga_kamar').show();
  // } else if ((grandparent == 2) && (parent == 3) && (child != 18)) {
  //   $('.s_harga_kamar').hide();
  // }

  if ((grandparent == 2) && (parent == 2 || parent == 3 || parent == 4) && (child == 4 || child == 15 || child == 9 || child == 10 || child == 11)) {
    $('.s_harga_kamar').show();
  } else {
    $('.s_harga_kamar').hide();
  }

  if (parent == 7) {
    if (gender == 'Male') {
      $('#dirisendiri_edit').prop('disabled', true);
      $('#anak_edit').prop('disabled', true);
    } else {
      $('#pasangan_edit').prop('disabled', true);
      $('#anak_edit').prop('disabled', true);
    }
  } else {
    //old untuk perubahan penampilan pasangan dan anak untuk yg memiliki hak pengajuan
    // $('#dirisendiri').prop('disabled', false);
    // $('#pasangan').prop('disabled', false);
    // $('#anak').prop('disabled', false);
    if (marital_status == 'Single') {
      $('#dirisendiri_edit').prop('checked', false);
      $('#pasangan_edit').prop('checked', false);
      $('#pasangan_edit').prop('disabled', true);
      $('#anak_edit').prop('checked', false);
      $('#anak_edit').prop('disabled', true);
      $('#listanak_edit').hide();
      $('#listpasangan_edit').hide();
    } else if (marital_status == 'Marr.') {
      if (gender == 'Male') {
        $('#dirisendiri_edit').prop('checked', false);
        $('#dirisendiri_edit').prop('disabled', false);
        $('#pasangan_edit').prop('checked', false);
        $('#pasangan_edit').prop('disabled', false);
        $('#anak_edit').prop('checked', false);
        $('#anak_edit').prop('disabled', false);
        $('#listpasangan_edit').hide();
        $('#listpasangan_edit').val(null);
        $('#listanak_edit').hide();
        $('#listanak_edit').val(null);
      } else if (gender == 'Female' && (nik == hak_pengajuan) && (nik == '20180115' || nik == '20210083' || nik == '20100016' || nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
        // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
        $('#dirisendiri_edit').prop('checked', false);
        $('#dirisendiri_edit').prop('disabled', false);
        $('#pasangan_edit').prop('checked', false);
        $('#pasangan_edit').prop('disabled', false);
        $('#anak_edit').prop('checked', false);
        $('#anak_edit').prop('disabled', false);
      } else {
        $('#dirisendiri_edit').prop('checked', false);
        $('#dirisendiri_edit').prop('disabled', false);
        $('#pasangan_edit').prop('checked', false);
        $('#pasangan_edit').prop('disabled', true);
        $('#anak_edit').prop('checked', false);
        $('#anak_edit').prop('disabled', true);
      }
    } else {
      $('#dirisendiri_edit').prop('checked', false);
      $('#pasangan_edit').prop('checked', false);
      $('#pasangan_edit').prop('disabled', true);
      $('#anak_edit').prop('checked', false);
      $('#anak_edit').prop('disabled', false);
      $('#listanak_edit').hide();
      $('#listanak_edit').val(null);
      $('#listpasangan_edit').hide();
      $('#listpasangan_edit').val(null);
    }
  }

});

$('#harga_kamar_edit').on('change', function () {
  return change_kuitansi_or_kamar(null);
});

// baru_nzul
$('#tanggal_kuitansi_edit').on('change', function () {
  var request_id = $("#request_id").val();
  var item_value = $("#req_medical_ubah").attr('item_value');
  // $('#total_nominal_kuitansi_edit').val(null);
  // $('#penggantian_edit').val(null);
  $('.listanak_edit').hide();
  var ele = document.getElementsByName("customRadioTor");
  for (var i = 0; i < ele.length; i++)
    ele[i].checked = false;

  var tanggal_kuitansi = $("#tanggal_kuitansi_edit").val();
  var hak_pengajuan = $("#hak_pengajuan").val();
  var dateObjTanggalKuitansi = new Date(tanggal_kuitansi);
  var today = new Date();
  var submited_date = $('#submited_at').val();

  if (submited_date != null && submited_date != '') {
    var compare_date = submited_date;
  } else {
    var compare_date = new Date();
  }

  var selisih = Math.floor(hitungSelisihHari(tanggal_kuitansi, compare_date));


  var get_medical_item_year = "form/get_medical_item_year";
  $.ajax({
    url: get_medical_item_year,
    dataType: 'json',
    type: 'POST',
    data: { request_id: request_id },
    success: function (data) {
      if (data[0]['totalId'] == 1) {
        var cek_efektifitas_kuitansi = "form/cek_efektifitas_kuitansi";
        $.ajax({
          url: cek_efektifitas_kuitansi,
          dataType: 'json',
          type: 'POST',
          data: { tanggal_kuitansi: tanggal_kuitansi },
          success: function (efektifitas) {
            var efektifitas = efektifitas;
            if (efektifitas != false) {
              if ((selisih > efektifitas)) {
                Swal.fire({
                  position: 'center',
                  icon: 'info',
                  title: 'Kuitansi sudah tidak bisa diajukan, <br> Kuitansi berlaku sebelum ' + efektifitas + ' Hari pengajuan',
                  showConfirmButton: false,
                  timer: 3500
                });
                var kosong = "";
                $('#tanggal_kuitansi_edit').val(kosong);
                return false;
              } else {

                ///////////Start cek data couple 2025/////////////
                var employee_nik = $("#employee_id").val();
                var cek_data_couple = "form/cek_data_couple";
                $.ajax({
                  url: cek_data_couple,
                  dataType: 'json',
                  type: 'POST',
                  data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
                  success: function (data) {
                    var employee_nik = $("#employee_id").val();
                    var gender = $('#gender').val();
                    var marital_status = $('#marital_status').val();

                    if (marital_status == 'Single') {
                      $('#dirisendiri').prop('checked', false);
                      $('#pasangan').prop('checked', false);
                      $('#pasangan').prop('disabled', true);
                      $('#anak').prop('checked', false);
                      $('#anak').prop('disabled', true);
                      $('#listanak').hide();
                      $('#listpasangan').hide();
                    } else if (marital_status == 'Marr.') {
                      if (gender == 'Male') {
                        $('#dirisendiri').prop('checked', false);
                        $('#dirisendiri').prop('disabled', false);
                        $('#pasangan').prop('checked', false);
                        $('#pasangan').prop('disabled', false);
                        $('#anak').prop('checked', false);
                        $('#anak').prop('disabled', false);
                        $('#listpasangan').hide();
                        $('#listpasangan').val(null);
                        $('#listanak').hide();
                        $('#listanak').val(null);
                      } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                        // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                        $('#dirisendiri').prop('checked', false);
                        $('#dirisendiri').prop('disabled', false);
                        $('#pasangan').prop('checked', false);
                        $('#pasangan').prop('disabled', false);
                        $('#anak').prop('checked', false);
                        $('#anak').prop('disabled', false);
                      } else {
                        $('#dirisendiri').prop('checked', false);
                        $('#dirisendiri').prop('disabled', false);
                        $('#pasangan').prop('checked', false);
                        $('#pasangan').prop('disabled', true);
                        $('#anak').prop('checked', false);
                        $('#anak').prop('disabled', true);
                      }
                    } else {
                      $('#dirisendiri').prop('checked', false);
                      $('#pasangan').prop('checked', false);
                      $('#pasangan').prop('disabled', true);
                      $('#anak').prop('checked', false);
                      $('#anak').prop('disabled', false);
                      $('#listanak').hide();
                      $('#listanak').val(null);
                      $('#listpasangan').hide();
                      $('#listpasangan').val(null);
                    }

                    //penambahan zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih
                    var employee_nik = $("#employee_id").val();
                    var employee_group = $("#employee_group").val();
                    var grandparent = $("#request_grandparent_edit").val();
                    var parent = $("#request_parent_edit").val();
                    var child = $("#request_child_edit").val();

                    var cek_limit_pagu = "form/cek_limit_pagu";

                    $.ajax({
                      url: cek_limit_pagu,
                      dataType: 'json',
                      type: 'POST',
                      data: {
                        tanggal_kuitansi: tanggal_kuitansi,
                        employee_nik: employee_nik,
                        employee_group: employee_group,
                        grandparent: grandparent,
                        parent: parent,
                        child: child,
                      },
                      success: function (pagu_remaining) {
                        console.log(pagu_remaining);
                        var pagu_remaining = pagu_remaining;
                        if (pagu_remaining != false) {
                          $("#pagu_tahun_edit").val(tanggal_kuitansi.substr(-4));
                          switch (grandparent) {
                            case '1': //rawat_jalan
                              var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(".", "").replaceAll(",", '');
                              var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
                              $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
                              break;
                            case '2': //rawat_inap
                              var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(".", "").replaceAll(",", '');
                              var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
                              $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
                              break;
                            default: //kacamata
                              if (child == '' || child == null) {
                                $("#sisa_limit_edit").val(null);
                              } else {
                                switch (child) {
                                  case '12':
                                    var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val().replaceAll(".", "").replaceAll(",", '');
                                    var sisa_limit_kacamata_frame = parseInt(pagu_remaining['pagu_frame_dua_tahun']) - parseInt(sum_penggantian_kacamata_frame);
                                    $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_kacamata_frame));
                                    break;
                                  case '13':
                                    var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val().replaceAll(".", "").replaceAll(",", '');
                                    var sisa_limit_one_focus = parseInt(pagu_remaining['pagu_one_focus_tahun']) - parseInt(sum_penggantian_kacamata_one_focus);
                                    $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_one_focus));
                                    break;
                                  default:
                                    var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val().replaceAll(".", "").replaceAll(",", '');
                                    var sisa_limit_two_focus = parseInt(pagu_remaining['pagu_two_focus_tahun']) - parseInt(sum_penggantian_kacamata_two_focus);
                                    $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_two_focus));
                                    break;
                                }
                              }
                              break;
                          }
                        }
                      }
                    });

                  },
                  error: function (data) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Data tidak dapat ditemukan',
                      showConfirmButton: false,
                      timer: 1500
                    });
                  }
                });
              }
            } else {
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Kuitansi sudah tidak bisa diajukan',
                showConfirmButton: false,
                timer: 3500
              });
              var kosong = "";
              $('#tanggal_kuitansi_edit').val(kosong);
              return false;
            }
          }
        });
      } else {
        var year = new Date(data[0]['tanggal_kuitansi']);
        if (dateObjTanggalKuitansi.getFullYear() != year.getFullYear()) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Pengajuan Medical Claim Tahun ' + dateObjTanggalKuitansi.getFullYear() + ' tidak dapat digabung dengan Tahun ' + year.getFullYear() + ', silahkan buat pengajuan terpisah sesuai dengan pengelompok kan Tahun kuitansi',
            showConfirmButton: true
          });
          $("#tanggal_kuitansi_edit").val(null);
        } else {
          var cek_efektifitas_kuitansi = "form/cek_efektifitas_kuitansi";
          $.ajax({
            url: cek_efektifitas_kuitansi,
            dataType: 'json',
            type: 'POST',
            data: { tanggal_kuitansi: tanggal_kuitansi },
            success: function (efektifitas) {
              var efektifitas = efektifitas;
              if (efektifitas != false) {
                if ((selisih > efektifitas)) {
                  Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: 'Kuitansi sudah tidak bisa diajukan, <br> Kuitansi berlaku sebelum ' + efektifitas + ' Hari pengajuan',
                    showConfirmButton: false,
                    timer: 3500
                  });
                  var kosong = "";
                  $('#tanggal_kuitansi_edit').val(kosong);
                  return false;
                } else {

                  ///////////Start cek data couple 2025/////////////
                  var employee_nik = $("#employee_id").val();
                  var cek_data_couple = "form/cek_data_couple";
                  $.ajax({
                    url: cek_data_couple,
                    dataType: 'json',
                    type: 'POST',
                    data: { employee_nik: employee_nik, tanggal_kuitansi: tanggal_kuitansi },
                    success: function (data) {
                      var employee_nik = $("#employee_id").val();
                      var gender = $('#gender').val();
                      var marital_status = $('#marital_status').val();

                      if (marital_status == 'Single') {
                        $('#dirisendiri').prop('checked', false);
                        $('#pasangan').prop('checked', false);
                        $('#pasangan').prop('disabled', true);
                        $('#anak').prop('checked', false);
                        $('#anak').prop('disabled', true);
                        $('#listanak').hide();
                        $('#listpasangan').hide();
                      } else if (marital_status == 'Marr.') {
                        if (gender == 'Male') {
                          $('#dirisendiri').prop('checked', false);
                          $('#dirisendiri').prop('disabled', false);
                          $('#pasangan').prop('checked', false);
                          $('#pasangan').prop('disabled', false);
                          $('#anak').prop('checked', false);
                          $('#anak').prop('disabled', false);
                          $('#listpasangan').hide();
                          $('#listpasangan').val(null);
                          $('#listanak').hide();
                          $('#listanak').val(null);
                        } else if (gender == 'Female' && (employee_nik == hak_pengajuan) && (employee_nik == '20180115' || employee_nik == '20210083' || employee_nik == '20100016' || employee_nik == '20130162')) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                          // } else if (gender == 'Female' && (employee_nik == data.hak_pengajuan) && (employee_nik == data.female_nik)) { //cek fungsi dari nik == hak_pengajuan ini apa ?
                          $('#dirisendiri').prop('checked', false);
                          $('#dirisendiri').prop('disabled', false);
                          $('#pasangan').prop('checked', false);
                          $('#pasangan').prop('disabled', false);
                          $('#anak').prop('checked', false);
                          $('#anak').prop('disabled', false);
                        } else {
                          $('#dirisendiri').prop('checked', false);
                          $('#dirisendiri').prop('disabled', false);
                          $('#pasangan').prop('checked', false);
                          $('#pasangan').prop('disabled', true);
                          $('#anak').prop('checked', false);
                          $('#anak').prop('disabled', true);
                        }
                      } else {
                        $('#dirisendiri').prop('checked', false);
                        $('#pasangan').prop('checked', false);
                        $('#pasangan').prop('disabled', true);
                        $('#anak').prop('checked', false);
                        $('#anak').prop('disabled', false);
                        $('#listanak').hide();
                        $('#listanak').val(null);
                        $('#listpasangan').hide();
                        $('#listpasangan').val(null);
                      }

                      //penambahan zulvan terkait liat pagu tahun dan sisa pagu tahun di pilih
                      var employee_nik = $("#employee_id").val();
                      var employee_group = $("#employee_group").val();
                      var grandparent = $("#request_grandparent_edit").val();
                      var parent = $("#request_parent_edit").val();
                      var child = $("#request_child_edit").val();

                      var cek_limit_pagu = "form/cek_limit_pagu";

                      $.ajax({
                        url: cek_limit_pagu,
                        dataType: 'json',
                        type: 'POST',
                        data: {
                          tanggal_kuitansi: tanggal_kuitansi,
                          employee_nik: employee_nik,
                          employee_group: employee_group,
                          grandparent: grandparent,
                          parent: parent,
                          child: child,
                        },
                        success: function (pagu_remaining) {
                          var pagu_remaining = pagu_remaining;
                          if (pagu_remaining != false) {
                            $("#pagu_tahun_edit").val(tanggal_kuitansi.substr(-4));
                            switch (grandparent) {
                              case '1': //rawat_jalan
                                var sum_penggantian_jalan = $("#sum_penggantian_jalan").val().replaceAll(".", "").replaceAll(",", '');
                                var sisa_limit_inap = parseInt(pagu_remaining['pagu_jalan_tahun']) - parseInt(sum_penggantian_jalan);
                                $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
                                break;
                              case '2': //rawat_inap
                                var sum_penggantian_inap = $("#sum_penggantian_inap").val().replaceAll(".", "").replaceAll(",", '');
                                var sisa_limit_inap = parseInt(pagu_remaining['pagu_inap_tahun']) - parseInt(sum_penggantian_inap);
                                $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_inap));
                                break;
                              default: //kacamata
                                if (child == '' || child == null) {
                                  $("#sisa_limit_edit").val(null);
                                } else {
                                  switch (child) {
                                    case '12':
                                      var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val().replaceAll(".", "").replaceAll(",", '');
                                      var sisa_limit_kacamata_frame = parseInt(pagu_remaining['pagu_frame_dua_tahun']) - parseInt(sum_penggantian_kacamata_frame);
                                      $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_kacamata_frame));
                                      break;
                                    case '13':
                                      var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val().replaceAll(".", "").replaceAll(",", '');
                                      var sisa_limit_one_focus = parseInt(pagu_remaining['pagu_one_focus_tahun']) - parseInt(sum_penggantian_kacamata_one_focus);
                                      $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_one_focus));
                                      break;
                                    default:
                                      var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val().replaceAll(".", "").replaceAll(",", '');
                                      var sisa_limit_two_focus = parseInt(pagu_remaining['pagu_two_focus_tahun']) - parseInt(sum_penggantian_kacamata_two_focus);
                                      $("#sisa_limit_edit").val(formatRupiah.format(sisa_limit_two_focus));
                                      break;
                                  }
                                }
                                break;
                            }
                          }
                        }
                      });
                    },
                    error: function (data) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Data tidak dapat ditemukan',
                        showConfirmButton: false,
                        timer: 1500
                      });
                    }
                  });
                }
              } else {
                Swal.fire({
                  position: 'center',
                  icon: 'info',
                  title: 'Kuitansi sudah tidak bisa diajukan',
                  showConfirmButton: false,
                  timer: 3500
                });
                var kosong = "";
                $('#tanggal_kuitansi_edit').val(kosong);
                return false;
              }
            }
          });
        }
      }
    }
  });

});

$('#total_nominal_kuitansi_edit').on('change', function () {
  return change_kuitansi_or_kamar($(this).attr('item_id'));
});

function change_kuitansi_or_kamar(item_id) {
  var request_id = $("#request_id").val();
  if ($("#penggantian_revisi").length) {
    var total = $("#penggantian_revisi").val();
  } else {
    var total = $("#total_nominal_kuitansi_edit").val();
  }

  total = parseFloat(total.replace(/\D+/g, ""));
  var persentase = 100 / 100;
  var request_grandparent_edit = $("#request_grandparent_edit").val();
  var request_parent_edit = $("#request_parent_edit").val();
  var request_child_edit = $("#request_child_edit").val();
  var harga_kamar = $("#harga_kamar_edit").val();
  if (harga_kamar == null || harga_kamar == '' || harga_kamar == ' ') {
  } else {
    harga_kamar = parseFloat(harga_kamar.replace(/\D+/g, ""));
  }

  //return false;


  if ((request_grandparent_edit == "") || (request_grandparent_edit === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    var kosong = "";
    $('#total_nominal_kuitansi_edit').val(kosong);
    return false;

  } else if ((request_parent_edit == "") || (request_parent_edit === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    var kosong = "";
    $('#total_nominal_kuitansi_edit').val(kosong);
    return false;

  } else if ((request_child_edit == "") || (request_child_edit === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Detil Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    var kosong = "";
    $('#total_nominal_kuitansi_edit').val(kosong);
    return false;

  } else if (request_grandparent_edit == 1) {
    //zulvan
    // var temp_limit_rawat_jalan = $("#temp_limit_rawat_jalan").val();
    var temp_limit_rawat_jalan = $("#limit_rawat_jalan").val();
    temp_limit_rawat_jalan = parseFloat(temp_limit_rawat_jalan.replace(/,/g, ''));

    var sum_penggantian_jalan = $("#sum_penggantian_jalan").val();
    sum_penggantian_jalan = parseFloat(sum_penggantian_jalan.replace(/,/g, ''));

    var limit_rawat_jalan = $("#limit_rawat_jalan").val();
    limit_rawat_jalan = parseFloat(limit_rawat_jalan.replace(/,/g, ''));

    var pengganti = total * persentase;
    if (temp_limit_rawat_jalan <= 0) {
      var penggantian = 0;
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Pagu Rawat Jalan anda telah habis',
        showConfirmButton: true
      });
    } else if (temp_limit_rawat_jalan >= pengganti) {
      var penggantian = pengganti;
    } else if (temp_limit_rawat_jalan < pengganti) {
      var penggantian = temp_limit_rawat_jalan;
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Total Kuitansi lebih besar dari Pagu Rawat Jalan, <br>Akan dilakukan penyesuaian penggantian',
        showConfirmButton: true
      });
    }


    $('#penggantian_edit').val(penggantian);

  } else if (request_grandparent_edit == 2) {
    var temp_limit_rawat_inap = $("#temp_limit_rawat_inap").val();
    temp_limit_rawat_inap = parseFloat(temp_limit_rawat_inap.replace(/,/g, ''));

    var sum_penggantian_inap = $("#sum_penggantian_inap").val();
    sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));

    var limit_rawat_inap = $("#limit_rawat_inap").val();
    limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));

    // if((grandparent == 2) && (parent == 3) && (child == 18)){
    //   $('.s_harga_kamar').show();
    // }else if ((grandparent == 2) && (parent == 3) && (child != 18)){
    //   $('.s_harga_kamar').hide();
    // }

    // if ((request_parent_edit == 3) && (request_child_edit == 18) && (harga_kamar == "") || (harga_kamar === undefined)) {
    if ((request_parent_edit == 2) && (request_child_edit == 4) && (harga_kamar == "") || (harga_kamar === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Harga kamar tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });

      return false;
      // } else if ((request_parent_edit != 3) && (request_child_edit != 18) && (harga_kamar == "") || (harga_kamar === undefined)) {
    }
    // else if ((request_parent_edit != 2) && (request_child_edit != 4) && (harga_kamar == "") || (harga_kamar === undefined)) {     

    //   Swal.fire({
    //     position: 'center',
    //     icon: 'error',
    //     title: 'Harga kamar tidak boleh kosong',
    //     showConfirmButton: false,
    //     timer: 1500
    //   });
    //   return false;
    // } 
    else if ((request_parent_edit == 2) && (request_child_edit != 4) && (harga_kamar == "") || (harga_kamar === undefined)) {

    }
    if (request_child_edit == 9) {
      var status = 'Normal';
      var cek_limit_maternity = "form/cek_limit_maternity";
      $.ajax({
        url: cek_limit_maternity,
        dataType: 'json',
        type: 'POST',
        data: { status: status },
        success: function (data_lim_mat) {
          var lim_mat = data_lim_mat;
          if (lim_mat < total) {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Total Kuitansi lebih besar dari Pagu Maternity (Kelahiran Normal), <br>Akan dilakukan penyesuaian penggantian',
              showConfirmButton: true
            });

            //total = lim_mat;
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);

                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * (total * persentase)));
                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {
                  var pengganti = total * persentase;

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian_edit').val(penggantian);
              }
            });


          } else {
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);
                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian_edit').val(penggantian);
              }
            });

          }


        }
      });


    } else if (request_child_edit == 10) {

      var status = 'Caesar';
      var cek_limit_maternity = "form/cek_limit_maternity";
      $.ajax({
        url: cek_limit_maternity,
        dataType: 'json',
        type: 'POST',
        data: { status: status },
        success: function (data_lim_mat) {
          var lim_mat = data_lim_mat;
          if (lim_mat < total) {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Total Kuitansi lebih besar dari Pagu Maternity (Kelahiran Caesar), <br>Akan dilakukan penyesuaian penggantian',
              showConfirmButton: true
            });

            // total = lim_mat;
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);

                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * (total * persentase)));

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {
                  var pengganti = total * persentase;

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian_edit').val(penggantian);
              }
            });


          } else {
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = parseFloat(data_limit);
                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian_edit').val(penggantian);
              }
            });

          }


        }
      });

    } else if (request_child_edit == 11) {

      var status = 'Normal';
      var cek_limit_maternity = "form/cek_limit_maternity";
      $.ajax({
        url: cek_limit_maternity,
        dataType: 'json',
        type: 'POST',
        data: { status: status },
        success: function (data_lim_mat) {
          var lim_mat = data_lim_mat;
          lim_mat = (lim_mat * (50 / 100));
          if (lim_mat <= total) {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Total Kuitansi lebih besar dari Pagu Maternity (Keguguran), <br>Akan dilakukan penyesuaian penggantian',
              showConfirmButton: true
            });

            // total = lim_mat;
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = data_limit;

                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * (total * persentase)));

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian_edit').val(penggantian);
              }
            });


          } else {
            var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
            $.ajax({
              url: cek_limit_harga_kamar,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data_limit) {
                var limit_kamar = data_limit;
                if (limit_kamar < harga_kamar) {

                  var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                } else {

                  var pengganti = total * persentase;

                  if (temp_limit_rawat_inap <= 0) {
                    var penggantian = 0;
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: 'Pagu rawat inap anda sudah habis',
                      showConfirmButton: true
                    });
                  } else {
                    if (temp_limit_rawat_inap < pengganti) {
                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                        showConfirmButton: true
                      });
                      if (pengganti >= lim_mat) {
                        if (temp_limit_rawat_inap < lim_mat) {
                          var penggantian = temp_limit_rawat_inap;
                        } else {
                          var penggantian = lim_mat;
                        }
                      } else {
                        var penggantian = temp_limit_rawat_inap;
                      }
                      // var penggantian = temp_limit_rawat_inap;
                    } else if (temp_limit_rawat_inap >= pengganti) {
                      if (pengganti >= lim_mat) {
                        var penggantian = lim_mat;
                      } else {
                        var penggantian = pengganti;
                      }
                    }

                  }

                }

                $('#penggantian_edit').val(penggantian);
              }
            });

          }


        }
      });

    } else {
      var cek_limit_harga_kamar = "form/cek_limit_harga_kamar";
      $.ajax({
        url: cek_limit_harga_kamar,
        dataType: 'json',
        type: 'POST',
        data: {},
        success: function (data_limit) {
          var limit_kamar = parseFloat(data_limit);

          if (limit_kamar < harga_kamar) {

            var pengganti = Math.round(((limit_kamar / harga_kamar) * total) * persentase);

            // if (temp_limit_rawat_inap <= 0) {
            //   var penggantian = 0;
            //   Swal.fire({
            //     position: 'center',
            //     icon: 'info',
            //     title: 'Pagu rawat inap anda sudah habis',
            //     showConfirmButton: true
            //   });
            // } else {
            if (temp_limit_rawat_inap < pengganti) {
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                showConfirmButton: true
              });
              var penggantian = temp_limit_rawat_inap;
            } else if (temp_limit_rawat_inap >= pengganti) {
              var penggantian = pengganti;
            }

            // }

          } else {

            var pengganti = total * persentase;

            if (temp_limit_rawat_inap <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu rawat inap anda sudah habis',
                showConfirmButton: true
              });
            } else {
              if (temp_limit_rawat_inap < pengganti) {
                Swal.fire({
                  position: 'center',
                  icon: 'info',
                  title: 'Total Kuitansi lebih besar dari Pagu Rawat Inap, <br>Akan dilakukan penyesuaian penggantian',
                  showConfirmButton: true
                });
                var penggantian = temp_limit_rawat_inap;
              } else if (temp_limit_rawat_inap >= pengganti) {
                var penggantian = pengganti;
              }

            }

          }

          $('#penggantian_edit').val(penggantian);
        }
      });
    }
  } else if (request_grandparent_edit == 3) {
    if ((request_parent_edit == 5) && (request_child_edit == 12)) {

      var cek_tanggal_pengambilan_kacamata = "form/cek_tanggal_pengambilan_kacamata";
      $.ajax({
        url: cek_tanggal_pengambilan_kacamata,
        dataType: 'json',
        type: 'POST',
        data: {
          request_id: request_id,
          request_grandparent_edit: request_grandparent_edit,
          request_parent_edit: request_parent_edit,
          request_child_edit: request_child_edit,
          kind: 'edit'
        },
        success: function (response) {
          if (response['tanggal_req'] == 'Kosong') {
            //var jarak_tahun = 1;
          } else {
            // var data_tanggal = new Date(data_tanggal);
            // var today = new Date();
            // var tahun_last_req = data_tanggal.getFullYear();
            // var tahun_new_req = today.getFullYear();
            // var jarak_tahun = tahun_new_req - tahun_last_req;
            var data_tanggal = new Date(response['tanggal_req']);
            var today = new Date();
            var last_req = new Date(data_tanggal.getMonth() + 1 + "/" + data_tanggal.getDate() + "/" + data_tanggal.getFullYear());
            var tgl_pengajuan = new Date(tanggal_kuitansi);

            var selisih_tanggal = tgl_pengajuan.getTime() - last_req.getTime();
            var selisih_tahun_dalam_hari = ((selisih_tanggal / (1000 * 3600 * 24)) / 2);
          }

          //z1
          if ((selisih_tahun_dalam_hari >= 365) || (response['tanggal_req'] == 'Kosong') || (response['item_id'] == item_id)) {
            var temp_limit_kacamata_frame = $("#temp_limit_kacamata_frame").val();
            // temp_limit_kacamata_frame = parseFloat(temp_limit_kacamata_frame.replace(/,/g, ''));

            if (response['item_id'] == item_id) {
              temp_limit_kacamata_frame = parseInt(temp_limit_kacamata_frame.replaceAll(",", '').replaceAll(".", '')) + parseInt(response['penggantian']);
            } else {
              temp_limit_kacamata_frame = temp_limit_kacamata_frame.replaceAll(",", '').replaceAll(".", '');
            }

            var sum_penggantian_kacamata_frame = $("#sum_penggantian_kacamata_frame").val();
            // sum_penggantian_kacamata_frame = parseFloat(sum_penggantian_kacamata_frame.replace(/,/g, ''));
            sum_penggantian_kacamata_frame = sum_penggantian_kacamata_frame.replaceAll(",", '').replaceAll(".", '');

            var limit_kacamata_frame = $("#limit_kacamata_frame").val();
            // limit_kacamata_frame = parseFloat(limit_kacamata_frame.replace(/,/g, ''));
            limit_kacamata_frame = limit_kacamata_frame.replaceAll(",", '').replaceAll(".", '');

            var pengganti = total * persentase;

            if (temp_limit_kacamata_frame <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu kacamata frame anda telah habis',
                showConfirmButton: true
              });
            } else if (temp_limit_kacamata_frame >= pengganti) {
              var penggantian = pengganti;
            } else if (temp_limit_kacamata_frame < pengganti) {
              var penggantian = temp_limit_kacamata_frame;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Total Kuitansi lebih besar dari Pagu Kacamata (Frame), <br>Akan dilakukan penyesuaian penggantian',
                showConfirmButton: true
              });
            }

            // console.log();
            $('#penggantian_edit').val(penggantian);
            if (isNaN($("#total_nominal_kuitansi_edit").val()) || $("#total_nominal_kuitansi_edit").val() == null || $("#total_nominal_kuitansi_edit").val() == '') {
              $('.sisaLimitEdit' + item_id).val(parseInt(limit_kacamata_frame) - 0);
            } else {
              $('.sisaLimitEdit' + item_id).val(parseInt(limit_kacamata_frame) - parseInt(penggantian));
            }

          } else {

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Anda sudah pernah melakukan klaim penggantian kacamata untuk frame, <br>klaim berlaku 2 tahun sekali',
              showConfirmButton: true
            });

          }

        }
      });

    } else if ((request_parent_edit == 6) && (request_child_edit == 13)) {

      var cek_tanggal_pengambilan_kacamata = "form/cek_tanggal_pengambilan_kacamata";
      $.ajax({
        url: cek_tanggal_pengambilan_kacamata,
        dataType: 'json',
        type: 'POST',
        data: {
          request_id: request_id,
          request_grandparent_edit: request_grandparent_edit,
          request_parent_edit: request_parent_edit,
          request_child_edit: request_child_edit,
          kind: 'edit'
        },
        success: function (response) {
          if (response['tanggal_req'] == 'Kosong') {
            //var jarak_tahun = 1;
          } else {
            // var data_tanggal = new Date(data_tanggal);
            // var today = new Date();
            // var tahun_last_req = data_tanggal.getFullYear();
            // var tahun_new_req = today.getFullYear();
            // var jarak_tahun = tahun_new_req - tahun_last_req;


            var data_tanggal = new Date(response['tanggal_req']);
            var today = new Date();
            var last_req = new Date(data_tanggal.getMonth() + 1 + "/" + data_tanggal.getDate() + "/" + data_tanggal.getFullYear());
            var tgl_pengajuan = new Date(tanggal_kuitansi);

            var selisih_tanggal = tgl_pengajuan.getTime() - last_req.getTime();
            var selisih_tahun_dalam_hari = (selisih_tanggal / (1000 * 3600 * 24));
          }

          if ((selisih_tahun_dalam_hari >= 365) || (response['tanggal_req'] == 'Kosong') || (response['item_id'] == item_id)) {
            var temp_limit_kacamata_one_focus = $("#temp_limit_kacamata_one_focus").val();
            // temp_limit_kacamata_one_focus = parseFloat(temp_limit_kacamata_one_focus.replace(/,/g, ''));

            if (response['item_id'] == item_id) {
              temp_limit_kacamata_one_focus = parseInt(temp_limit_kacamata_one_focus.replaceAll(",", '').replaceAll(".", '')) + parseInt(response['penggantian']);
            } else {
              temp_limit_kacamata_one_focus = temp_limit_kacamata_one_focus.replaceAll(",", '').replaceAll(".", '');
            }

            var sum_penggantian_kacamata_one_focus = $("#sum_penggantian_kacamata_one_focus").val();
            sum_penggantian_kacamata_one_focus = parseFloat(sum_penggantian_kacamata_one_focus.replace(/,/g, ''));

            var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
            limit_kacamata_one_focus = parseFloat(limit_kacamata_one_focus.replace(/,/g, ''));

            var pengganti = total * persentase;

            if (temp_limit_kacamata_one_focus <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu kacamata one focus anda telah habis',
                showConfirmButton: true
              });
            } else if (temp_limit_kacamata_one_focus >= pengganti) {
              var penggantian = pengganti;
            } else if (temp_limit_kacamata_one_focus < pengganti) {
              var penggantian = temp_limit_kacamata_one_focus;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Total Kuitansi lebih besar dari Pagu Kacamata (One Focus), <br>Akan dilakukan penyesuaian penggantian',
                showConfirmButton: true
              });
            }

            $('#penggantian_edit').val(penggantian);
            if (isNaN($("#total_nominal_kuitansi_edit").val()) || $("#total_nominal_kuitansi_edit").val() == null || $("#total_nominal_kuitansi_edit").val() == '') {
              $('.sisaLimitEdit' + item_id).val(parseInt(limit_kacamata_one_focus) - 0);
            } else {
              $('.sisaLimitEdit' + item_id).val(parseInt(limit_kacamata_one_focus) - parseInt(penggantian));
            }
          } else {
            console.log('zul1');
            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Anda sudah pernah melakukan klaim penggantian kacamata untuk lensa, <br>klaim berlaku 1 tahun sekali',
              showConfirmButton: true
            });

            document.getElementById('form_Edit_Claim').reset();
            $('#form_Edit_Claim').trigger('reset');
            var get_Grandparent = "form/get_Grandparent";
            $.ajax({
              url: get_Grandparent,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data) {
                $('#request_grandparent_edit').html(data);
                $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
                $('#request_child_edit').html('<option value="">Penggantian</option>');
              }
            });

          }
        }

      });

    } else if ((request_parent_edit == 6) && (request_child_edit == 14)) {

      var cek_tanggal_pengambilan_kacamata = "form/cek_tanggal_pengambilan_kacamata";
      $.ajax({
        url: cek_tanggal_pengambilan_kacamata,
        dataType: 'json',
        type: 'POST',
        data: {
          request_id: request_id,
          request_grandparent_edit: request_grandparent_edit,
          request_parent_edit: request_parent_edit,
          request_child_edit: request_child_edit,
          kind: 'edit'
        },
        success: function (data_tanggal) {
          if (data_tanggal == 'Kosong') {
            //var jarak_tahun = 1;
          } else {
            // var data_tanggal = new Date(data_tanggal);
            // var today = new Date();
            // var tahun_last_req = data_tanggal.getFullYear();
            // var tahun_new_req = today.getFullYear();
            // var jarak_tahun = tahun_new_req - tahun_last_req;

            var data_tanggal = new Date(data_tanggal);
            var today = new Date();
            var last_req = new Date(data_tanggal.getMonth() + 1 + "/" + data_tanggal.getDate() + "/" + data_tanggal.getFullYear());
            var tgl_pengajuan = new Date(tanggal_kuitansi);

            var selisih_tanggal = tgl_pengajuan.getTime() - last_req.getTime();
            var selisih_tahun_dalam_hari = (selisih_tanggal / (1000 * 3600 * 24));
          }

          if ((selisih_tahun_dalam_hari >= 365) || (data_tanggal == 'Kosong')) {

            var temp_limit_kacamata_two_focus = $("#temp_limit_kacamata_two_focus").val();
            temp_limit_kacamata_two_focus = parseFloat(temp_limit_kacamata_two_focus.replace(/,/g, ''));

            var sum_penggantian_kacamata_two_focus = $("#sum_penggantian_kacamata_two_focus").val();
            sum_penggantian_kacamata_two_focus = parseFloat(sum_penggantian_kacamata_two_focus.replace(/,/g, ''));

            var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
            limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replace(/,/g, ''));

            var pengganti = total * persentase;

            if (temp_limit_kacamata_two_focus <= 0) {
              var penggantian = 0;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Pagu kacamata two focus anda telah habis',
                showConfirmButton: true
              });
            } else if (temp_limit_kacamata_two_focus >= pengganti) {
              var penggantian = pengganti;
            } else if (temp_limit_kacamata_two_focus < pengganti) {
              var penggantian = temp_limit_kacamata_two_focus;
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Total Kuitansi lebih besar dari Pagu Kacamata (Two Focus), <br>Akan dilakukan penyesuaian penggantian',
                showConfirmButton: true
              });
            }

            $('#penggantian_edit').val(penggantian);

          } else {
            console.log('zul2');

            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Anda sudah pernah melakukan klaim penggantian kacamata untuk lensa, <br>klaim berlaku 1 tahun sekali',
              showConfirmButton: true
            });

            document.getElementById('form_Edit_Claim').reset();
            $('#form_Edit_Claim').trigger('reset');
            var get_Grandparent = "form/get_Grandparent";
            $.ajax({
              url: get_Grandparent,
              dataType: 'json',
              type: 'POST',
              data: {},
              success: function (data) {
                $('#request_grandparent_edit').html(data);
                $('#request_parent_edit').html('<option value="">Sub Penggantian</option>');
                $('#request_child_edit').html('<option value="">Penggantian</option>');
              }
            });

          }
        }

      });
    }

  }

};



$('.req_medical_ubah').click(function () {
  var request_id = $("#request_id").val();
  var item_id = $("#req_medical_ubah").attr('item_value');
  var tor_grandparent = $("#request_grandparent_edit").val();
  var tor_parent = $("#request_parent_edit").val();
  var tor_child = $("#request_child_edit").val();
  var jumlah_kuitansi = $("#jumlah_kuitansi_edit").val();
  var total_kuitansi = $("#total_nominal_kuitansi_edit").val();
  total_kuitansi = parseFloat(total_kuitansi.replace(/\D+/g, ""));
  var tanggal_kuitansi = $("#tanggal_kuitansi_edit").val();
  var dateObjTanggalKuitansi = new Date(tanggal_kuitansi);
  var docter = $("#docter_edit").val();
  var diagnosa = $("#diagnosa_edit").val();
  var harga_kamar = $("#harga_kamar_edit").val();
  harga_kamar = parseFloat(harga_kamar.replace(/\D+/g, ""));
  var penggantian = $("#penggantian_edit").val();

  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();

  //old
  // var today = new Date();
  // var selisih = Math.floor(hitungSelisihHari(tanggal_kuitansi, today));

  //revisi zulvan 02-03-2023 (edit nominal kwitansi berdasarkan tanggal submit dokumen)
  var submited_date = $('#submited_at').val();

  if (submited_date != null && submited_date != '') {
    var compare_date = submited_date;
  } else {
    var compare_date = new Date();
  }

  var selisih = Math.floor(hitungSelisihHari(tanggal_kuitansi, compare_date));

  if ((tor_grandparent == "") || (tor_grandparent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jenis Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((tor_parent == "") || (tor_parent === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sub Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((tor_child == "") || (tor_child === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Detail Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((jumlah_kuitansi == "") || (jumlah_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Jumlah Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((total_kuitansi == "") || (total_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Total Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((docter == "") || (docter === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Dokter tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((diagnosa == "") || (diagnosa === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Diagnosa tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((tanggal_kuitansi == "") || (tanggal_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Tanggal Kuitansi tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((penggantian == "") || (penggantian === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Penggantian tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((penggantian <= 0)) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Saldo Penggantian telah habis',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if (((tor_grandparent == 3) || (tor_parent == 4)) && (join_years < 1) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
      showConfirmButton: false,
      timer: 2500
    });
    return false;
  } else if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3) && (nik != '20240059') && (nik != '20240063') && (nik != '20240067')) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
      showConfirmButton: false,
      timer: 2500
    });
    return false;
  } else if ((selisih > 45)) {
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Kuitansi sudah tidak bisa diajukan',
      showConfirmButton: false,
      timer: 2500
    });
    return false;
  }


  var request_family_a = document.getElementsByName('customRadioTorEdit');
  var request_family;
  for (var i = 0; i < request_family_a.length; i++) {
    if (request_family_a[i].checked) {
      request_family = request_family_a[i].value;
    }
  }
  if (request_family === undefined) {
    request_family = ''
  }

  if ((request_family == "") || (request_family === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Keterangan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  var anak = $("#listanak_edit").val();
  var pasangan = $("#listpasangan_edit").val();

  if (request_family === 'Diri Sendiri') {
    var additional = 'Diri Sendiri';
  } else if (request_family === 'Pasangan') {
    if ((pasangan == "") || (pasangan === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Pasangan tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
    var additional = pasangan;
  } else if (request_family === 'Anak') {
    if ((anak == "") || (anak === undefined)) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Anak tidak boleh kosong',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
    var additional = anak;
  }

  var get_medical_item_year = "form/get_medical_item_year";
  $.ajax({
    url: get_medical_item_year,
    dataType: 'json',
    type: 'POST',
    data: { request_id: request_id },
    success: function (data) {
      var year = new Date(data[0]['tanggal_kuitansi']);
      if (data[0]['totalId'] == 1) {
        var url = "form/update_tor";

        $.ajax({
          url: url,
          dataType: 'json',
          type: 'POST',
          data: {
            request_id: item_id,
            tor_grandparent: tor_grandparent,
            tor_parent: tor_parent,
            tor_child: tor_child,
            jumlah_kuitansi: jumlah_kuitansi,
            total_kuitansi: total_kuitansi,
            penggantian: penggantian,
            request_family: request_family,
            additional: additional,
            docter: docter,
            diagnosa: diagnosa,
            tanggal_kuitansi: tanggal_kuitansi,
            harga_kamar: harga_kamar
          },
          success: function (data) {
            if (data == true) {
              $('#ToR').DataTable().ajax.reload();
              // $('#form_Edit_Claim').trigger("reset");
              // $("#request_grandparent_edit").select2('', 'Jenis Penggantian');
              // $('#request_parent_edit').html('<option value=""></option>');
              // $('#request_child_edit').html('<option value=""></option>');
              // $('#modalEditClaim').hide('toggle');
              $('#modalEditToR').modal('toggle');



              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data telah diubah',
                showConfirmButton: false,
                timer: 2500
              });

              var get_sum_penggantian_jalan = "form/get_sum_penggantian_jalan";
              $.ajax({
                url: get_sum_penggantian_jalan,
                method: 'POST',
                dataType: 'json',
                data: { request_id: request_id },
                success: function (data_jalan) {
                  var sum_penggantian_jalan = Intl.NumberFormat().format(data_jalan[0].sum_penggantian);
                  $('#sum_penggantian_jalan').val(sum_penggantian_jalan);
                  var limit_rawat_jalan = $("#limit_rawat_jalan").val();
                  sum_penggantian_jalan = parseFloat(sum_penggantian_jalan.replace(/,/g, ''));
                  limit_rawat_jalan = parseFloat(limit_rawat_jalan.replace(/,/g, ''));
                  var sisa_pagu_jalan = limit_rawat_jalan - sum_penggantian_jalan;
                  $('#temp_limit_rawat_jalan').val(sisa_pagu_jalan);

                  if (sum_penggantian_jalan > limit_rawat_jalan) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit rawat jalan',
                      showConfirmButton: true
                    });
                  }
                }
              });

              var get_sum_penggantian_inap = "form/get_sum_penggantian_inap";
              $.ajax({
                url: get_sum_penggantian_inap,
                method: 'POST',
                dataType: 'json',
                data: { request_id: request_id },
                success: function (data_inap) {
                  var sum_penggantian_inap = Intl.NumberFormat().format(data_inap[0].sum_penggantian);
                  $('#sum_penggantian_inap').val(sum_penggantian_inap);
                  var limit_rawat_inap = $("#limit_rawat_inap").val();
                  sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));
                  limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));
                  var sisa_pagu_inap = limit_rawat_inap - sum_penggantian_inap;
                  $('#temp_limit_rawat_inap').val(sisa_pagu_inap);
                  if (sum_penggantian_inap > limit_rawat_inap) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit rawat inap',
                      showConfirmButton: true
                    });
                  }
                }
              });

              var get_sum_penggantian_kacamata = "form/get_sum_penggantian_kacamata";
              $.ajax({
                url: get_sum_penggantian_kacamata,
                method: 'POST',
                dataType: 'json',
                data: { request_id: request_id },
                success: function (data_kacamata) {

                  var sum_penggantian_kacamata_frame = Intl.NumberFormat().format(data_kacamata[0].sum_frame);
                  $('#sum_penggantian_kacamata_frame').val(sum_penggantian_kacamata_frame);
                  var limit_kacamata_frame = $("#limit_kacamata_frame").val();
                  sum_penggantian_kacamata_frame = parseFloat(sum_penggantian_kacamata_frame.replace(/,/g, ''));
                  limit_kacamata_frame = parseFloat(limit_kacamata_frame.replace(/,/g, ''));
                  var sisa_pagu_frame = limit_kacamata_frame - sum_penggantian_kacamata_frame;
                  console.log('z2');
                  $('#temp_limit_kacamata_frame').val(sisa_pagu_frame);

                  if (sum_penggantian_kacamata_frame > limit_kacamata_frame) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit frame kacamata',
                      showConfirmButton: true
                    });
                  }

                  var sum_penggantian_kacamata_one_focus = Intl.NumberFormat().format(data_kacamata[0].sum_one_focus);
                  $('#sum_penggantian_kacamata_one_focus').val(sum_penggantian_kacamata_one_focus);
                  var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
                  sum_penggantian_kacamata_one_focus = parseFloat(sum_penggantian_kacamata_one_focus.replace(/,/g, ''));
                  limit_kacamata_one_focus = parseFloat(limit_kacamata_one_focus.replace(/,/g, ''));
                  var sisa_pagu_one_focus = limit_kacamata_one_focus - sum_penggantian_kacamata_one_focus;
                  $('#temp_limit_kacamata_one_focus').val(sisa_pagu_one_focus);

                  if (sum_penggantian_kacamata_one_focus > limit_kacamata_one_focus) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit kacamata one focus',
                      showConfirmButton: true
                    });
                  }

                  var sum_penggantian_kacamata_two_focus = Intl.NumberFormat().format(data_kacamata[0].sum_two_focus);
                  $('#sum_penggantian_kacamata_two_focus').val(sum_penggantian_kacamata_two_focus);
                  var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
                  sum_penggantian_kacamata_two_focus = parseFloat(sum_penggantian_kacamata_two_focus.replace(/,/g, ''));
                  limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replace(/,/g, ''));
                  var sisa_pagu_two_focus = limit_kacamata_two_focus - sum_penggantian_kacamata_two_focus;
                  $('#temp_limit_kacamata_two_focus').val(sisa_pagu_two_focus);

                  if (sum_penggantian_kacamata_two_focus > limit_kacamata_two_focus) {
                    Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Over limit kacamata two focus',
                      showConfirmButton: true
                    });
                  }

                }
              });

              return edit_tor(request_id);

            }
          },
          error: function (data) {
            $('#ToR').DataTable().ajax.reload();
            // document.getElementById("form_Edit_Claim").reset();
            // $('#form_Edit_Claim').trigger("reset");
            // $("#request_grandparent_edit").select2('', 'Jenis Penggantian');
            // $('#request_parent_edit').html('<option value=""></option>');
            // $('#request_child_edit').html('<option value=""></option>');
            $('#modalEditTor').modal('toggle');
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Data tidak dapat ditambahkan',
              showConfirmButton: false,
              timer: 1500
            });
          }
        });
      } else {

        if (dateObjTanggalKuitansi.getFullYear() != year.getFullYear()) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Pengajuan Medical Claim Tahun ' + dateObjTanggalKuitansi.getFullYear() + ' tidak dapat digabung dengan Tahun ' + year.getFullYear() + ', silahkan buat pengajuan terpisah sesuai dengan pengelompok kan Tahun kuitansi',
            showConfirmButton: true
          });
        } else {
          var url = "form/update_tor";

          $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            data: {
              request_id: item_id,
              tor_grandparent: tor_grandparent,
              tor_parent: tor_parent,
              tor_child: tor_child,
              jumlah_kuitansi: jumlah_kuitansi,
              total_kuitansi: total_kuitansi,
              penggantian: penggantian,
              request_family: request_family,
              additional: additional,
              docter: docter,
              diagnosa: diagnosa,
              tanggal_kuitansi: tanggal_kuitansi,
              harga_kamar: harga_kamar
            },
            success: function (data) {
              if (data == true) {
                $('#ToR').DataTable().ajax.reload();
                // $('#form_Edit_Claim').trigger("reset");
                // $("#request_grandparent_edit").select2('', 'Jenis Penggantian');
                // $('#request_parent_edit').html('<option value=""></option>');
                // $('#request_child_edit').html('<option value=""></option>');
                // $('#modalEditClaim').hide('toggle');
                $('#modalEditToR').modal('toggle');



                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Data telah diubah',
                  showConfirmButton: false,
                  timer: 2500
                });

                var get_sum_penggantian_jalan = "form/get_sum_penggantian_jalan";
                $.ajax({
                  url: get_sum_penggantian_jalan,
                  method: 'POST',
                  dataType: 'json',
                  data: { request_id: request_id },
                  success: function (data_jalan) {
                    var sum_penggantian_jalan = Intl.NumberFormat().format(data_jalan[0].sum_penggantian);
                    $('#sum_penggantian_jalan').val(sum_penggantian_jalan);
                    var limit_rawat_jalan = $("#limit_rawat_jalan").val();
                    sum_penggantian_jalan = parseFloat(sum_penggantian_jalan.replace(/,/g, ''));
                    limit_rawat_jalan = parseFloat(limit_rawat_jalan.replace(/,/g, ''));
                    var sisa_pagu_jalan = limit_rawat_jalan - sum_penggantian_jalan;
                    $('#temp_limit_rawat_jalan').val(sisa_pagu_jalan);

                    if (sum_penggantian_jalan > limit_rawat_jalan) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit rawat jalan',
                        showConfirmButton: true
                      });
                    }
                  }
                });

                var get_sum_penggantian_inap = "form/get_sum_penggantian_inap";
                $.ajax({
                  url: get_sum_penggantian_inap,
                  method: 'POST',
                  dataType: 'json',
                  data: { request_id: request_id },
                  success: function (data_inap) {
                    var sum_penggantian_inap = Intl.NumberFormat().format(data_inap[0].sum_penggantian);
                    $('#sum_penggantian_inap').val(sum_penggantian_inap);
                    var limit_rawat_inap = $("#limit_rawat_inap").val();
                    sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));
                    limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));
                    var sisa_pagu_inap = limit_rawat_inap - sum_penggantian_inap;
                    $('#temp_limit_rawat_inap').val(sisa_pagu_inap);
                    if (sum_penggantian_inap > limit_rawat_inap) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit rawat inap',
                        showConfirmButton: true
                      });
                    }
                  }
                });

                var get_sum_penggantian_kacamata = "form/get_sum_penggantian_kacamata";
                $.ajax({
                  url: get_sum_penggantian_kacamata,
                  method: 'POST',
                  dataType: 'json',
                  data: { request_id: request_id },
                  success: function (data_kacamata) {

                    var sum_penggantian_kacamata_frame = Intl.NumberFormat().format(data_kacamata[0].sum_frame);
                    $('#sum_penggantian_kacamata_frame').val(sum_penggantian_kacamata_frame);
                    var limit_kacamata_frame = $("#limit_kacamata_frame").val();
                    sum_penggantian_kacamata_frame = parseFloat(sum_penggantian_kacamata_frame.replace(/,/g, ''));
                    limit_kacamata_frame = parseFloat(limit_kacamata_frame.replace(/,/g, ''));
                    var sisa_pagu_frame = limit_kacamata_frame - sum_penggantian_kacamata_frame;
                    console.log('z3');
                    $('#temp_limit_kacamata_frame').val(sisa_pagu_frame);

                    if (sum_penggantian_kacamata_frame > limit_kacamata_frame) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit frame kacamata',
                        showConfirmButton: true
                      });
                    }

                    var sum_penggantian_kacamata_one_focus = Intl.NumberFormat().format(data_kacamata[0].sum_one_focus);
                    $('#sum_penggantian_kacamata_one_focus').val(sum_penggantian_kacamata_one_focus);
                    var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
                    sum_penggantian_kacamata_one_focus = parseFloat(sum_penggantian_kacamata_one_focus.replace(/,/g, ''));
                    limit_kacamata_one_focus = parseFloat(limit_kacamata_one_focus.replace(/,/g, ''));
                    var sisa_pagu_one_focus = limit_kacamata_one_focus - sum_penggantian_kacamata_one_focus;
                    $('#temp_limit_kacamata_one_focus').val(sisa_pagu_one_focus);

                    if (sum_penggantian_kacamata_one_focus > limit_kacamata_one_focus) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit kacamata one focus',
                        showConfirmButton: true
                      });
                    }

                    var sum_penggantian_kacamata_two_focus = Intl.NumberFormat().format(data_kacamata[0].sum_two_focus);
                    $('#sum_penggantian_kacamata_two_focus').val(sum_penggantian_kacamata_two_focus);
                    var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
                    sum_penggantian_kacamata_two_focus = parseFloat(sum_penggantian_kacamata_two_focus.replace(/,/g, ''));
                    limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replace(/,/g, ''));
                    var sisa_pagu_two_focus = limit_kacamata_two_focus - sum_penggantian_kacamata_two_focus;
                    $('#temp_limit_kacamata_two_focus').val(sisa_pagu_two_focus);

                    if (sum_penggantian_kacamata_two_focus > limit_kacamata_two_focus) {
                      Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Over limit kacamata two focus',
                        showConfirmButton: true
                      });
                    }

                  }
                });

                return edit_tor(request_id);

              }
            },
            error: function (data) {
              $('#ToR').DataTable().ajax.reload();
              // document.getElementById("form_Edit_Claim").reset();
              // $('#form_Edit_Claim').trigger("reset");
              // $("#request_grandparent_edit").select2('', 'Jenis Penggantian');
              // $('#request_parent_edit').html('<option value=""></option>');
              // $('#request_child_edit').html('<option value=""></option>');
              $('#modalEditTor').modal('toggle');
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Data tidak dapat ditambahkan',
                showConfirmButton: false,
                timer: 1500
              });
            }
          });
        }
      }
    }
  });



});

function edit_price(edit_price) {
  var id = document.getElementById(edit_price).getAttribute("id");
  var url = 'form/edit_tor/';
  var join_years = $("#join_years").val();
  var join_months = $("#join_months").val();
  var employee_subgroup = $("#employee_subgroup").val();
  var employee_group = $("#employee_group").val();
  var marital_status = $('#marital_status').val();
  var gender = $('#gender').val();

  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      var get_Grandparent = "form/edit_Grandparent";
      $.ajax({
        url: get_Grandparent,
        dataType: 'json',
        type: 'POST',
        data: { id: response[0].tor_grandparent },
        success: function (data) {
          $('#request_grandparent_edit').html(data);
        }
      });

      var get_Parent = "form/edit_Parent";
      $.ajax({
        url: get_Parent,
        dataType: 'json',
        type: 'POST',
        data: { id: id },
        success: function (data) {
          $('#request_parent_edit').html(data);
        }
      });

      var get_Child = "form/edit_Child";
      $.ajax({
        url: get_Child,
        dataType: 'json',
        type: 'POST',
        data: { id: id },
        success: function (data) {
          $('#request_child_edit').html(data);
        }
      });


      if (response[0].keterangan == 'Diri Sendiri') {
        $('#dirisendiri_edit').prop('checked', true);
        $('#dirisendiri_edit').prop('disabled', true);
        $('#pasangan_edit').prop('checked', false);
        $('#pasangan_edit').prop('disabled', true);
        $('#anak_edit').prop('checked', false);
        $('#anak_edit').prop('disabled', true);
        $('#listpasangan_edit').hide();
        $('#listpasangan_edit').val(null);
        $('#listanak_edit').hide();
        $('#listanak_edit').val(null);
      } else if (response[0].keterangan == 'Pasangan') {
        var get_FamilySpouse = "form/getDetailFamilySpouse";
        $.ajax({
          url: get_FamilySpouse,
          dataType: 'json',
          type: 'POST',
          data: { id: response[0].additional, employee_id: response[0].employee_id },
          success: function (data) {
            $('#dirisendiri_edit').prop('checked', false);
            $('#dirisendiri_edit').prop('disabled', true);
            $('#pasangan_edit').prop('checked', true);
            $('#pasangan_edit').prop('disabled', true);
            $('#anak_edit').prop('checked', false);
            $('#anak_edit').prop('disabled', true);
            $('#listpasangan_edit').show();
            $('#listpasangan_edit').html(data);
            $('#listpasangan_edit').prop('disabled', true);
            $('#listanak_edit').hide();
            $('#listanak_edit').val(null);
          }
        });
      } else if (response[0].keterangan == 'Anak') {
        var get_FamilyChild = "form/getDetailFamilyChild";
        $.ajax({
          url: get_FamilyChild,
          dataType: 'json',
          type: 'POST',
          data: { id: response[0].additional, tanggal_kuitansi: response[0].tanggal_kuitansi, employee_id: response[0].employee_id },
          success: function (data) {
            $('#dirisendiri_edit').prop('checked', false);
            $('#dirisendiri_edit').prop('disabled', true);
            $('#pasangan_edit').prop('checked', false);
            $('#pasangan_edit').prop('disabled', true);
            $('#anak_edit').prop('checked', true);
            $('#anak_edit').prop('disabled', true);
            $('#listpasangan_edit').hide();
            $('#listpasangan_edit').val(null);
            $('#listanak_edit').show();
            $('#listanak_edit').html(data);
            $('#listanak_edit').prop('disabled', true);
          }
        });
      } else {

      };

      var kuitansi_date = response[0].tanggal_kuitansi;
      var [year, month, day] = kuitansi_date.split('-');
      var result_date = [month, day, year].join('/');

      $("#req_medical_ubah").attr('item_value', id);
      $("#jumlah_kuitansi_edit").val(response[0].jumlah_kuitansi);
      $("#tanggal_kuitansi_edit").val(result_date);
      $("#total_nominal_kuitansi_edit").val(response[0].total_nominal_kuitansi);
      $("#docter_edit").val(response[0].docter);
      $("#diagnosa_edit").val(response[0].diagnosa);
      // $("#penggantian_edit").val(response[0].penggantian);
      $("#record_id").val(id);
      if (response[0].penggantian_sebelum == null || response[0].penggantian_sebelum == '') {
        $("#old_penggantian").val(response[0].penggantian);
        $("#penggantian_revisi").val(response[0].penggantian_sebelum);
      } else {
        $("#old_penggantian").val(response[0].penggantian_sebelum);
        $("#penggantian_revisi").val(response[0].penggantian);
      }
      $("#note_penggantian").val(response[0].note_penggantian);
      if (response[0].harga_kamar > 0) {
        $('.s_harga_kamar').show();
        $("#harga_kamar_edit").val(response[0].harga_kamar);
      }

      //$('.data_edit_pagu_rawat_inap').modal('show');
      // var id = response[0].id;
      // var start_date = response[0].start_date;
      // var end_date = response[0].end_date;
      // var grade = response[0].grade;
      // var pagu_tahun = response[0].pagu_tahun;
      // var pagu_kamar_hari = response[0].pagu_kamar_hari;

      // $("#id_edit_rawat_inap").val(id);
      // $("#start_date_edit_rawat_inap").val(start_date);
      // $("#end_date_edit_rawat_inap").val(end_date);
      // $("#grade_edit_rawat_inap").val(grade).change();
      // $("#pagu_kamar_edit_rawat_inap").val(pagu_kamar_hari);
      // $("#pagu_tahun_edit_rawat_inap").val(pagu_tahun);
    }
  });


  // $.ajax({
  //   type: 'POST',
  //   url: url,
  //   dataType: 'json',
  //   data: { id: id },
  //   success: function (response) {
  //     $("#record_id").val(id);
  //     $("#old_penggantian").val(response[0].penggantian_sebelum);
  //     $("#penggantian_revisi").val(response[0].penggantian);
  //     $("#note_penggantian").val(response[0].note_penggantian);
  //   }
  // });

}

$('.req_medical_ubah_harga').click(function () {

  var record_id = $("#record_id").val();
  var item_id = $("#req_medical_ubah").attr('item_value');
  var harga_kamar = $("#harga_kamar_edit").val();
  var old_penggantian = $("#old_penggantian").val();
  var penggantian_revisi = $("#penggantian_revisi").val();
  var note_penggantian = $("#note_penggantian").val();

  // var join_years = $("#join_years").val();
  // var join_months = $("#join_months").val();
  // var employee_subgroup = $("#employee_subgroup").val();
  // var today = new Date();
  // var selisih = Math.floor(hitungSelisihHari(tanggal_kuitansi, today));

  // if ((tor_grandparent == "") || (tor_grandparent === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Jenis Penggantian tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((tor_parent == "") || (tor_parent === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Sub Penggantian tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((tor_child == "") || (tor_child === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Detail Penggantian tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((jumlah_kuitansi == "") || (jumlah_kuitansi === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Jumlah Kuitansi tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((total_kuitansi == "") || (total_kuitansi === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Total Kuitansi tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((docter == "") || (docter === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Dokter tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((diagnosa == "") || (diagnosa === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Diagnosa tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((tanggal_kuitansi == "") || (tanggal_kuitansi === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Tanggal Kuitansi tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((penggantian == "") || (penggantian === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Penggantian tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if ((penggantian <= 0)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'info',
  //     title: 'Saldo Penggantian telah habis',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // } else if (((tor_grandparent == 3) || (tor_parent == 4)) && (join_years < 1)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'info',
  //     title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari satu tahun',
  //     showConfirmButton: false,
  //     timer: 2500
  //   });
  //   return false;
  // } else if ((employee_subgroup != 'Contract') && (join_years < 1) && (join_months < 3)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'info',
  //     title: 'Belum bisa melakukan pengajuan<br>Masa kerja masih kurang dari tiga bulan',
  //     showConfirmButton: false,
  //     timer: 2500
  //   });
  //   return false;
  // } else if ((selisih > 45)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'info',
  //     title: 'Kuitansi sudah tidak bisa diajukan',
  //     showConfirmButton: false,
  //     timer: 2500
  //   });
  //   return false;
  // }


  // var request_family_a = document.getElementsByName('customRadioTorEdit');
  // var request_family;
  // for (var i = 0; i < request_family_a.length; i++) {
  //   if (request_family_a[i].checked) {
  //     request_family = request_family_a[i].value;
  //   }
  // }
  // if (request_family === undefined) {
  //   request_family = ''
  // }

  // if ((request_family == "") || (request_family === undefined)) {
  //   Swal.fire({
  //     position: 'center',
  //     icon: 'error',
  //     title: 'Keterangan tidak boleh kosong',
  //     showConfirmButton: false,
  //     timer: 1500
  //   });
  //   return false;
  // }

  // var anak = $("#listanak_edit").val();
  // var pasangan = $("#listpasangan_edit").val();

  // if (request_family === 'Diri Sendiri') {
  //   var additional = 'Diri Sendiri';
  // } else if (request_family === 'Pasangan') {
  //   if ((pasangan == "") || (pasangan === undefined)) {
  //     Swal.fire({
  //       position: 'center',
  //       icon: 'error',
  //       title: 'Pasangan tidak boleh kosong',
  //       showConfirmButton: false,
  //       timer: 1500
  //     });
  //     return false;
  //   }
  //   var additional = pasangan;
  // } else if (request_family === 'Anak') {
  //   if ((anak == "") || (anak === undefined)) {
  //     Swal.fire({
  //       position: 'center',
  //       icon: 'error',
  //       title: 'Anak tidak boleh kosong',
  //       showConfirmButton: false,
  //       timer: 1500
  //     });
  //     return false;
  //   }
  //   var additional = anak;
  // }

  // var url = "form/update_tor";
  var url = "form/update_price";

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: {
      record_id: record_id,
      harga_kamar: harga_kamar,
      old_penggantian: old_penggantian,
      penggantian_revisi: penggantian_revisi,
      note_penggantian: note_penggantian
    },
    success: function (data) {
      if (data == true) {
        $('#ToR').DataTable().ajax.reload();
        // $('#form_Edit_Claim').trigger("reset");
        // $("#request_grandparent_edit").select2('', 'Jenis Penggantian');
        // $('#request_parent_edit').html('<option value=""></option>');
        // $('#request_child_edit').html('<option value=""></option>');
        // $('#modalEditClaim').hide('toggle');
        $('#modalEditPrice').modal('toggle');



        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah diubah',
          showConfirmButton: false,
          timer: 2500
        });

        // var get_sum_penggantian_jalan = "form/get_sum_penggantian_jalan";
        // $.ajax({
        //   url: get_sum_penggantian_jalan,
        //   method: 'POST',
        //   dataType: 'json',
        //   data: { request_id: request_id },
        //   success: function (data_jalan) {
        //     var sum_penggantian_jalan = Intl.NumberFormat().format(data_jalan[0].sum_penggantian);
        //     $('#sum_penggantian_jalan').val(sum_penggantian_jalan);
        //     var limit_rawat_jalan = $("#limit_rawat_jalan").val();
        //     sum_penggantian_jalan = parseFloat(sum_penggantian_jalan.replace(/,/g, ''));
        //     limit_rawat_jalan = parseFloat(limit_rawat_jalan.replace(/,/g, ''));
        //     var sisa_pagu_jalan = limit_rawat_jalan - sum_penggantian_jalan;
        //     $('#temp_limit_rawat_jalan').val(sisa_pagu_jalan);

        //     if (sum_penggantian_jalan > limit_rawat_jalan) {
        //       Swal.fire({
        //         position: 'center',
        //         icon: 'error',
        //         title: 'Over limit rawat jalan',
        //         showConfirmButton: true
        //       });
        //     }
        //   }
        // });

        // var get_sum_penggantian_inap = "form/get_sum_penggantian_inap";
        // $.ajax({
        //   url: get_sum_penggantian_inap,
        //   method: 'POST',
        //   dataType: 'json',
        //   data: { request_id: request_id },
        //   success: function (data_inap) {
        //     var sum_penggantian_inap = Intl.NumberFormat().format(data_inap[0].sum_penggantian);
        //     $('#sum_penggantian_inap').val(sum_penggantian_inap);
        //     var limit_rawat_inap = $("#limit_rawat_inap").val();
        //     sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));
        //     limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));
        //     var sisa_pagu_inap = limit_rawat_inap - sum_penggantian_inap;
        //     $('#temp_limit_rawat_inap').val(sisa_pagu_inap);
        //     if (sum_penggantian_inap > limit_rawat_inap) {
        //       Swal.fire({
        //         position: 'center',
        //         icon: 'error',
        //         title: 'Over limit rawat inap',
        //         showConfirmButton: true
        //       });
        //     }
        //   }
        // });

        // var get_sum_penggantian_kacamata = "form/get_sum_penggantian_kacamata";
        // $.ajax({
        //   url: get_sum_penggantian_kacamata,
        //   method: 'POST',
        //   dataType: 'json',
        //   data: { request_id: request_id },
        //   success: function (data_kacamata) {

        //     var sum_penggantian_kacamata_frame = Intl.NumberFormat().format(data_kacamata[0].sum_frame);
        //     $('#sum_penggantian_kacamata_frame').val(sum_penggantian_kacamata_frame);
        //     var limit_kacamata_frame = $("#limit_kacamata_frame").val();
        //     sum_penggantian_kacamata_frame = parseFloat(sum_penggantian_kacamata_frame.replace(/,/g, ''));
        //     limit_kacamata_frame = parseFloat(limit_kacamata_frame.replace(/,/g, ''));
        //     var sisa_pagu_frame = limit_kacamata_frame - sum_penggantian_kacamata_frame;
        //     $('#temp_limit_kacamata_frame').val(sisa_pagu_frame);

        //     if (sum_penggantian_kacamata_frame > limit_kacamata_frame) {
        //       Swal.fire({
        //         position: 'center',
        //         icon: 'error',
        //         title: 'Over limit frame kacamata',
        //         showConfirmButton: true
        //       });
        //     }

        //     var sum_penggantian_kacamata_one_focus = Intl.NumberFormat().format(data_kacamata[0].sum_one_focus);
        //     $('#sum_penggantian_kacamata_one_focus').val(sum_penggantian_kacamata_one_focus);
        //     var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
        //     sum_penggantian_kacamata_one_focus = parseFloat(sum_penggantian_kacamata_one_focus.replace(/,/g, ''));
        //     limit_kacamata_one_focus = parseFloat(limit_kacamata_one_focus.replace(/,/g, ''));
        //     var sisa_pagu_one_focus = limit_kacamata_one_focus - sum_penggantian_kacamata_one_focus;
        //     $('#temp_limit_kacamata_one_focus').val(sisa_pagu_one_focus);

        //     if (sum_penggantian_kacamata_one_focus > limit_kacamata_one_focus) {
        //       Swal.fire({
        //         position: 'center',
        //         icon: 'error',
        //         title: 'Over limit kacamata one focus',
        //         showConfirmButton: true
        //       });
        //     }

        //     var sum_penggantian_kacamata_two_focus = Intl.NumberFormat().format(data_kacamata[0].sum_two_focus);
        //     $('#sum_penggantian_kacamata_two_focus').val(sum_penggantian_kacamata_two_focus);
        //     var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
        //     sum_penggantian_kacamata_two_focus = parseFloat(sum_penggantian_kacamata_two_focus.replace(/,/g, ''));
        //     limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replace(/,/g, ''));
        //     var sisa_pagu_two_focus = limit_kacamata_two_focus - sum_penggantian_kacamata_two_focus;
        //     $('#temp_limit_kacamata_two_focus').val(sisa_pagu_two_focus);

        //     if (sum_penggantian_kacamata_two_focus > limit_kacamata_two_focus) {
        //       Swal.fire({
        //         position: 'center',
        //         icon: 'error',
        //         title: 'Over limit kacamata two focus',
        //         showConfirmButton: true
        //       });
        //     }

        //   }
        // });

        return edit_tor(request_id);

      }
    },
    error: function (data) {
      $('#ToR').DataTable().ajax.reload();
      // document.getElementById("form_Edit_Claim").reset();
      // $('#form_Edit_Claim').trigger("reset");
      // $("#request_grandparent_edit").select2('', 'Jenis Penggantian');
      // $('#request_parent_edit').html('<option value=""></option>');
      // $('#request_child_edit').html('<option value=""></option>');
      $('#modalEditPrice').modal('toggle');
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});


///////////////////////////////////New Request MDCR/////////////////////////////////

$('#submit_new_request_mdcr').click(function () {
  var request_id = $("#id_request").val();
  var is_status = $("#is_status").val();

  var action = $("#action").val();

  var limit_rawat_jalan = $("#limit_rawat_jalan").val();
  limit_rawat_jalan = parseFloat(limit_rawat_jalan.replace(/,/g, ''));
  var sum_penggantian_jalan = $("#sum_penggantian_jalan").val();
  sum_penggantian_jalan = parseFloat(sum_penggantian_jalan.replace(/,/g, ''));

  var limit_rawat_inap = $("#limit_rawat_inap").val();
  limit_rawat_inap = parseFloat(limit_rawat_inap.replace(/,/g, ''));
  var sum_penggantian_inap = $("#sum_penggantian_inap").val();
  sum_penggantian_inap = parseFloat(sum_penggantian_inap.replace(/,/g, ''));

  var limit_kacamata_frame = $("#limit_kacamata_frame").val();
  limit_kacamata_frame = parseFloat(limit_kacamata_frame.replace(/,/g, ''));
  var sum_penggantian_kacamata_frame = $('#sum_penggantian_kacamata_frame').val();
  sum_penggantian_kacamata_frame = parseFloat(sum_penggantian_kacamata_frame.replace(/,/g, ''));

  var limit_kacamata_one_focus = $("#limit_kacamata_one_focus").val();
  limit_kacamata_one_focus = parseFloat(limit_kacamata_one_focus.replace(/,/g, ''));
  var sum_penggantian_kacamata_one_focus = $('#sum_penggantian_kacamata_one_focus').val();
  sum_penggantian_kacamata_one_focus = parseFloat(sum_penggantian_kacamata_one_focus.replace(/,/g, ''));

  var limit_kacamata_two_focus = $("#limit_kacamata_two_focus").val();
  limit_kacamata_two_focus = parseFloat(limit_kacamata_two_focus.replace(/,/g, ''));
  var sum_penggantian_kacamata_two_focus = $('#sum_penggantian_kacamata_two_focus').val();
  sum_penggantian_kacamata_two_focus = parseFloat(sum_penggantian_kacamata_two_focus.replace(/,/g, ''));


  var url_tor = "form/cek_tor";
  $.ajax({
    url: url_tor,
    method: 'POST',
    dataType: 'json',
    data: { request_id: request_id },
    success: function (cek_data_tor) {
      var cek_data_tor = cek_data_tor;
      if (cek_data_tor == 0) {

        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Silahkan isi pengajuan klaim,<br>klik "Add Type of Reimbursement"',
          showConfirmButton: false,
          timer: 2500
        });
        return false;

      } else {

        if (limit_rawat_jalan < sum_penggantian_jalan) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Over limit rawat jalan',
            showConfirmButton: true
          });
          return false;
        }

        if (limit_rawat_inap < sum_penggantian_inap) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Over limit rawat inap',
            showConfirmButton: true
          });
          return false;
        }

        if (limit_kacamata_frame < sum_penggantian_kacamata_frame) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Over limit frame kacamata',
            showConfirmButton: true
          });
          return false;
        }

        if (limit_kacamata_one_focus < sum_penggantian_kacamata_one_focus) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Over limit kacamata one focus',
            showConfirmButton: true
          });
          return false;
        }

        if (limit_kacamata_two_focus < sum_penggantian_kacamata_two_focus) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Over limit kacamata two focus',
            showConfirmButton: true
          });
          return false;
        }

        if (action == 'Leaving') {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Anda sudah tidak bisa mengajukan Medical Reimbursment',
            showConfirmButton: true
          });
          return false;
        }

        var url = "form/cek_addtional_mdcr";
        $.ajax({
          url: url,
          method: 'POST',
          dataType: 'json',
          data: { request_id: request_id },
          success: function (cek_data) {
            if ((cek_data == "") || (cek_data === undefined)) {

              var form_data = new FormData($('#form_additional_mdcr')[0]);
              var cek_resep = 0;
              var cek_doc;
              var cek_kuitansi;
              for (let [name, value] of form_data) {
                if (name == 'resep') {
                  cek_resep = (name = value);
                }
                if (name == 'kuitansi') {
                  cek_kuitansi = (name = value);
                }
              }
              if (cek_resep == "on") {
                cek_resep = 1;
              };

              if (((cek_resep == "") || (cek_resep === undefined)) && ((cek_kuitansi == "") || (cek_kuitansi === undefined))) {
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Additional Information harus diisi,<br>kemudian klik SAVE',
                  showConfirmButton: false,
                  timer: 2500
                });
              } else {
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Jika sudah isi Additional Information,<br>kemudian klik SAVE',
                  showConfirmButton: false,
                  timer: 2500
                });
              }
              return false;
            } else {
              var doc = cek_data[0].documents;
              var kuitansi = cek_data[0].kuitansi;
              var resep = cek_data[0].resep;

              if ((doc == "") || (doc === undefined)) {
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Documents harus diisi',
                  showConfirmButton: false,
                  timer: 1500
                });
                return false;

              } else if ((kuitansi == "") || (kuitansi === undefined)) {
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Kuitansi harus diisi',
                  showConfirmButton: false,
                  timer: 1500
                });
                return false;

              } else {

                var url_apotik = "form/cek_detail_tor_for_apotik";
                $.ajax({
                  url: url_apotik,
                  method: 'POST',
                  dataType: 'json',
                  data: { request_id: request_id, is_status: is_status },
                  success: function (cek_data_apotik) {
                    var cek_data_apotik = cek_data_apotik;

                    if ((cek_data_apotik == "apotik") && (resep == 0)) {


                      Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Copy Resep Dokter harus ditandai<br>pada form additional information',
                        showConfirmButton: false,
                        timer: 2500
                      });
                      return false;


                    } else {

                      Swal.fire({
                        title: 'Are you sure?',
                        text: '',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Submit'
                      }).then((result) => {
                        if (result.isConfirmed) {
                          Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we save your data.',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                              Swal.showLoading();
                            }
                          });

                          var url_sbt = "form/request_submited_mdcr";
                          $.ajax({
                            url: url_sbt,
                            method: 'POST',
                            dataType: 'json',
                            data: { request_id: request_id, is_status: is_status },
                            success: function (data) {
                              Swal.close();

                              Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Your form has been submited.',
                                showConfirmButton: false,
                                timer: 1500
                              });
                              window.location.href = 'home/request'

                            }
                          });
                        }
                      })

                    }

                  }
                });


              }

            }

          },
          error: function (cek_data) {
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Error',
              showConfirmButton: false,
              timer: 1500
            });
            return false;
          }
        });


      }
    },
    error: function (cek_data_tor) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Error',
        showConfirmButton: false,
        timer: 1500
      });
      return false;
    }
  });

  // Swal.fire({
  //   title: 'Are you sure?',
  //   text: '',
  //   icon: 'warning',
  //   showCancelButton: true,
  //   confirmButtonColor: '#3085d6',
  //   cancelButtonColor: '#d33',
  //   confirmButtonText: 'Submit'
  // }).then((result) => {
  //   if (result.isConfirmed) {

  //     var url = "form/request_submited_mdcr";
  //       $.ajax({
  //         url: url,
  //         method:'POST',
  //         dataType: 'json',
  //         data:{request_id : request_id},
  //         success:function(data)
  //         {
  //           // Swal.fire(
  //           //   'Submit',
  //           //   'Your form has been submited.',
  //           //   'success'
  //           // )
  //           Swal.fire({
  //             position: 'center',
  //             icon: 'success',
  //             title: 'Your form has been submited.',
  //             showConfirmButton: false,
  //             timer: 1500             
  //           });
  //           window.location.href = 'home/request'

  //         }
  //     });

  //   }
  // })

});

$('.close_tor').click(function () {
  $('#form_Add_Claim').trigger("reset");
  $("#request_grandparent_tambah").select2('', 'Jenis Penggantian');
  $('#request_parent_tambah').html('<option value=""></option>');
  $('#request_child_tambah').html('<option value=""></option>');
  ///
  // $("#request_grandparent_edit").select2('', 'Jenis Penggantian');

});


function success() {
  Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'Your form has been submited.',
    showConfirmButton: false,
    timer: 1500
  });
}

$('#print_out_req_mdcr').click(function () {
  var request_id = $("#request_id").val();
  var request_number = $("#request_number").val();
  window.open("form/print_out_req_mdcr/" + request_id + "/" + request_number, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");

});


function delete_couple(delete_couple) {
  var id = document.getElementById(delete_couple).getAttribute("id");
  var url = 'master/delete_couple/';

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
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#table_couple').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Data telah dihapus',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Data tidak dapat dihapus',
              showConfirmButton: false,
              timer: 1500
            });
          }
        },
        error: function (data) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Data tidak dapat dihapus',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });

    }
  })


}

//Blfrtip

$(document).ready(function () {
  // $('.test-table thead tr')
  //     .clone(true)
  //     .addClass('filters')
  //     .appendTo('.test-table thead');

  var table = $('.test-table').DataTable({
    ajax: 'master/read/employee/',
    //scrollY: '100%',
    scrollX: true,
    ordering: true,
    searching: true,
    dom:
      "<'row'<'col-sm-6'B><'col-sm-5 text-right'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4 text-left'l>>" +
      "<'row'<'col-sm-8 text-right'p>>" +
      "<'row'<'col-sm-2'i>>",
    buttons: [
      {
        extend: 'copy',
        text: 'Copy to clipboard'
      },
      'excel',
      'csv',
      // 'pdf',
      'colvis'
    ],
    autoWidth: true,
    pagingType: 'full_numbers',
    orderCellsTop: true,
    fixedHeader: true,
    initComplete: function () {
      var api = this.api();

      api
        .columns()
        .eq(0)
        .each(function (colIdx) {
          var cell = $('.filters th').eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          $(cell).html('<input type="text" placeholder="' + title + '" />');

          $(
            'input',
            $('.filters th').eq($(api.column(colIdx).header()).index())
          )
            .off('keyup change')
            .on('change', function (e) {
              // Get the search value
              $(this).attr('title', $(this).val());
              var regexr = '({search})';

              var cursorPosition = this.selectionStart;
              api
                .column(colIdx)
                .search(
                  this.value != ''
                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                    : '',
                  this.value != '',
                  this.value == ''
                )
                .draw();
            })
            .on('keyup', function (e) {
              e.stopPropagation();

              $(this).trigger('change');
              $(this)
                .focus()[0]
                .setSelectionRange(cursorPosition, cursorPosition);
            });
        });
    },
  });


  $('.tableDashboardX thead tr')
    .clone(true)
    .addClass('filters')
    .appendTo('.tableDashboardX thead');

  var td = $('.tableDashboardX').DataTable({
    ajax: 'dashboard/read_hr/all',
    scrollX: true,
    ordering: true,
    searching: true,
    // processing: true,
    //     language: {
    //       sLoadingRecords: '<img style="width:100px; height:100px;" src="./assets/images/kucinghitam.gif" />'
    //     },
    dom:
      "<'row'<'col-sm-6'B><'col-sm-5 text-right'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4 text-left'l>>" +
      "<'row'<'col-sm-8 text-right'p>>" +
      "<'row'<'col-sm-2'i>>",
    buttons: [
      {
        extend: 'copy',
        text: 'Copy to clipboard'
      },
      'excel',
      'colvis',
    ],
    columnDefs: [
      { 'visible': false, 'targets': [3, 9, 15, 17] }
    ],
    autoWidth: true,
    // pagingType: 'full_numbers',
    orderCellsTop: true,
    fixedHeader: true,
    initComplete: function () {
      var api = this.api();

      api
        .columns()
        .eq(0)
        .each(function (colIdx) {
          var cell = $('.filters th').eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          if ($(api.column(colIdx).header()).index() >= 0 && title != 'Action') {
            $(cell).html('<input type="text" placeholder="' + title + '"/>');
          } else {
            $(cell).html('');
          }
          $(
            'input',
            $('.filters th').eq($(api.column(colIdx).header()).index())
          )
            .off('keyup change')
            .on('change', function (e) {
              // Get the search value
              $(this).attr('title', $(this).val());
              var regexr = '({search})';

              var cursorPosition = this.selectionStart;
              api
                .column(colIdx)
                .search(
                  this.value != ''
                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                    : '',
                  this.value != '',
                  this.value == ''
                )
                .draw();
            })
            .on('keyup', function (e) {
              e.stopPropagation();

              $(this).trigger('change');
              $(this)
                .focus()[0]
                .setSelectionRange(cursorPosition, cursorPosition);
            });
        });
    },
  });

  // $('.tableDashboardX').DataTable()
  //   .columns.adjust()
  //   .scroller.measure()
  //   .relayout();

});

$(document).ready(function () {

  var id_request = $("#id_request").val();
  var form_type = $("#form_type").val();
  var employee_id = $("#employee_id").val();
  var is_status = $("#is_status").val();
  var hak_pengajuan = $("#hak_pengajuan").val();

  //Cek Couple MDCR
  if ((form_type == 'MDCR') && (is_status == 0)) {

    if (employee_id != hak_pengajuan) {

      var url = "form/cek_hak_pengajuan";
      $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: { hak_pengajuan: hak_pengajuan, id_request: id_request },
        success: function (cek_data) {
          Swal.fire({
            position: 'center',
            icon: 'info',
            title: 'Tidak Bisa Melakukan Pengajuan Medical, <br> Hak Pengajuan Anda Ditanggung Oleh ' + cek_data,
            showConfirmButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'dashboard/dashboard'
            }
          })

        }
      });

    }
  }

});

$('#btn_save_add_info').click(function () {

  var request_id = $("#id_request").val();
  var is_status = $("#is_status").val();
  var kuitansi = $("#kuitansi").val();
  var FileDocumentsClaim = $("#FileDocumentsClaim").val();

  if ((kuitansi == "") || (kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Kuitansi harus diisi',
      showConfirmButton: false,
      timer: 1500
    });
    return false;

  }

  var url_doc = "form/cek_detail_add_info_for_doc";
  $.ajax({
    url: url_doc,
    method: 'POST',
    dataType: 'json',
    data: { request_id: request_id, is_status: is_status },
    success: function (cek_data_doc) {
      var cek_data_doc = cek_data_doc;

      if ((cek_data_doc == "no_doc") && ((FileDocumentsClaim == "") || (FileDocumentsClaim === undefined))) {

        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Documents harus diisi',
          showConfirmButton: false,
          timer: 1500
        });
        return false;

      } else {

        var form_data = new FormData($('#form_additional_mdcr')[0]);
        var resep = 0;
        for (let [name, value] of form_data) {
          if (name == 'resep') {
            resep = (name = value);
          }
        }
        if (resep == "on") {
          resep = 1;
        };

        var url_apotik = "form/cek_detail_tor_for_apotik";
        $.ajax({
          url: url_apotik,
          method: 'POST',
          dataType: 'json',
          data: { request_id: request_id, is_status: is_status },
          success: function (cek_data_apotik) {
            var cek_data_apotik = cek_data_apotik;

            if ((cek_data_apotik == "apotik") && (resep == 0)) {


              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Copy Resep Dokter harus ditandai<br>pada form additional information',
                showConfirmButton: false,
                timer: 2500
              });
              return false;


            } else {

              $.ajax({
                type: "POST",
                url: "form/save_additional_mdcr",
                data: form_data,
                processData: false,
                contentType: false,
                success: function (res) {
                  if (res) {
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Success submitting Additional Information',
                      showConfirmButton: false,
                      timer: 2500
                    });
                    location.reload();
                  } else {
                    Swal.fire({
                      position: 'center',
                      icon: 'Error',
                      title: 'Error submitting Additional Information',
                      showConfirmButton: false,
                      timer: 2500
                    });
                    return false;
                  }
                }
              });
            }

          }
        });

      }
    }
  });

});

$('#tambah_efektifitas_kuitansi').click(function () {
  var efektif_kuitansi_tambah = $("#efektif_kuitansi_tambah").val();
  var start_date_tambah_efektif_kuitansi = $("#start_date_tambah_efektif_kuitansi").val();

  if ((efektif_kuitansi_tambah == "") || (efektif_kuitansi_tambah === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Hari harus diisi',
      showConfirmButton: false,
      timer: 1500
    });
    return false;

  }
  if ((start_date_tambah_efektif_kuitansi == "") || (start_date_tambah_efektif_kuitansi === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Tanggal harus diisi',
      showConfirmButton: false,
      timer: 1500
    });
    return false;

  }
  var url = "master/tambah_efektifitas_kuitansi";

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { efektif_kuitansi_tambah: efektif_kuitansi_tambah, start_date_tambah_efektif_kuitansi: start_date_tambah_efektif_kuitansi },
    success: function (data) {
      if (data == true) {
        $('#table_e_kuitansi').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      } else if (data == 'jarak_minus') {
        $('#table_e_kuitansi').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'warning',
          title: 'Tidak bisa ditambahkan karena,<br> start date masuk dalam kategori role sebelumnya',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_e_kuitansi').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });


});

function delete_ekuitansi(delete_ekuitansi) {

  Swal.fire({
    title: 'Delete',
    text: 'Are you sure?',
    icon: 'warning',
    width: 'auto',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {

      var id = document.getElementById(delete_ekuitansi).getAttribute("id");
      var url = 'master/getDeleteEkuitansi/';
      $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#table_e_kuitansi').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Data telah dihapus',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Data tidak dapat dihapus',
              showConfirmButton: false,
              timer: 1500
            });
          }
        },
        error: function (data) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Data tidak dapat dihapus',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });

    }
  })
}

$('.checked_id_mdcr').click(function () {
  // alert('z');
  // alert($(this).attr('cost_center'));
  var n = $(".checked_id_mdcr:checked").length;
  if (n > 0) {
    if ($(this).attr('kind') == 1) {
      $(".kind2").prop('disabled', 'true');
      $(".kind1").removeAttr('disabled');
    } else {
      $(".kind1").prop('disabled', 'true');
      $(".kind2").removeAttr('disabled');
    }
  } else {
    $(".checked_id_mdcr").removeAttr('disabled');
  }
});



function responseRequest_CekMDCR(type) {

  var id = $('#request_id').val();
  //return false;

  if (type == 'Checked_List_MDCR') {

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-light'
      },
      buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, sure.',
      cancelButtonText: 'Cancel.',
      reverseButtons: true,
      allowOutsideClick: false
    }).then((result) => {
      if (result.value) {
        Swal.fire({
          title: 'Processing...',
          text: 'Please wait while we save your data.',
          showConfirmButton: false,
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          url: "form/responseRequestFromAdminHR",
          type: 'post',
          data: 'id=' + id + '&resp=' + type,
          dataType: 'json',
          success: function (response) {
            if (response == true) {
              window.location.href = 'inbox/approval_mdcr';
              Swal.close();
              swalWithBootstrapButtons.fire({
                title: 'Thank You!',
                icon: 'success',
                text: 'Response has been saved.',
                showConfirmButton: false,
                allowOutsideClick: false,
              });
            }
          },
          error: function (response) {
            Swal.fire({
              position: 'center',
              icon: 'info',
              title: 'Oops! There\'s something wrong, <br>it might be slow network or expired user session.<br>Please refresh this page and try again.',
              showConfirmButton: false,
              timer: 1500
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          position: 'center',
          icon: 'info',
          title: 'Action has been cancelled.',
          showConfirmButton: false,
          timer: 1500
        });
      }
    })

  } else {

    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Aksi tidak dapat diproses',
      showConfirmButton: false,
      timer: 1500
    });

  }

}

function viewResumeNoReqToFI(noreq) {
  const no_req = noreq.getAttribute('data-no_req');

  window.open("inbox/mod_resume_no_req_to_fi/" + no_req, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=400");

}

function btn_modal_ap(data) {
	const id = data.getAttribute('data-id');

	$.ajax({
		url: '/report/mod_resume_no_req_ap/' + id,
		type: 'GET',
		dataType: 'json',
		success: function (response) {
			// console.log(response);
			$('#content-modal').html(response.preview);
		},
		error: function (xhr, status, error) {
			console.error(error);
		}
	});
}

function re_send_email(data) {
	const { request, nik } = data.dataset;

	data.disabled = true;
	const originalHTML = data.innerHTML;
	
	data.innerHTML = '<em class="icon ni ni-loader ni-spin"></em>';

	$.ajax({
		url: '/report/re_send_email/' + request + '/' + nik,
		type: 'GET',
		dataType: 'json',
		success: function (response) {

			data.disabled = false;
			data.innerHTML = originalHTML;

			data.innerHTML = '<em class="icon ni ni-send"></em>';

			Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Re send email was successfully',
        showConfirmButton: true,
        timer: 1500
      });
		},
		error: function (xhr, status, error) {
			Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Oopss there are something wrong',
        showConfirmButton: false,
        timer: 1500
      });

			data.disabled = false;
			data.innerHTML = originalHTML;

			data.innerHTML = '<em class="icon ni ni-send"></em>';

			// console.log('/report/re_send_email/' + request + nik);
		}
	});

	// window.open("report/re_send_email/" + request + "/" + nik, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");

	// console.log(request);
	// console.log(nik);
	
	
}

function print_out_req_mdcr_at_resume(noreq) {
  var no_req = document.getElementById(noreq).getAttribute("id");
  const d = new Date();
  var dY = d.getFullYear;
  var rand = 'MDCR' + (Math.floor(Math.random() * 1000 + 1));
  window.open("form/print_out_req_mdcr/" + no_req + "/" + rand, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");

}

function print_out_req_mdcr_all_per_day(noreqMDCR) {
  const no_req = noreqMDCR.getAttribute('data-no_req');
  const d = new Date();
  var dY = d.getFullYear;
  var rand = 'MDCR' + (Math.floor(Math.random() * 1000 + 1));
  window.open("form/print_out_req_mdcr_all_per_day/" + no_req + "/" + rand, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");

}

function print_out_req_mdcr_all_per_day_ap(noreqMDCR) {
  const no_req = noreqMDCR.getAttribute('data-no_req');
  const d = new Date();
  var dY = d.getFullYear;
  var rand = 'MDCR' + (Math.floor(Math.random() * 1000 + 1));
  window.open("form/print_out_req_mdcr_all_per_day/" + no_req + "/" + rand);

}

function print_out_req_mdcr_per_employee(no) {
  var no_req = document.getElementById(no).getAttribute("id");

  // const myArray = no_req.split("-");
  // var employee_id = myArray[0];
  // var year = myArray[1];


  window.open("form/print_out_req_mdcr_all_per_employee/" + no_req, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");

}

function print_out_req_mdcr_per_employee_ap(no) {
  var no_req = document.getElementById(no).getAttribute("id");
  // window.open("form/print_out_req_mdcr_all_per_employee/" + no_req, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=700,left=700,width=600,height=600");

	window.open('form/print_out_req_mdcr_all_per_employee/' + no_req); 
}

function action_approve_devhead_hr(no) {
  // var no_req = document.getElementById(no).getAttribute("id");
  const no_req = no.getAttribute('data-no_req');

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary',
      cancelButton: 'btn btn-light'
    },
    buttonsStyling: false
  })
  swalWithBootstrapButtons.fire({
    title: 'Are you sure to approve this request ' + no_req + ' ?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, sure.',
    cancelButtonText: 'Cancel.',
    reverseButtons: true,
    allowOutsideClick: false
  }).then((result) => {
    if (result.value) {
      //return false;
      $.ajax({
        url: "form/responseRequestMDCRtoFI",
        type: 'post',
        data: 'no_req=' + no_req,
        dataType: 'json',
        success: function (response) {
          if (response == true) {
            window.location.href = 'inbox/approval_mdcr_to_fi';
            swalWithBootstrapButtons.fire('Thank You!', 'Response has been saved.', 'success')
          }
        },
        error: function (response) {
          Swal.fire({
            position: 'center',
            icon: 'info',
            title: 'Oops! There\'s something wrong, <br>it might be slow network or expired user session.<br>Please refresh this page and try again.',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Action has been cancelled.',
        showConfirmButton: false,
        timer: 1500
      });
    }
  })

}


$(document).ready(function () {

  var total_nominal_kuitansi = document.getElementById("total_nominal_kuitansi");
  total_nominal_kuitansi.addEventListener("keyup", function (e) {
    total_nominal_kuitansi.value = formatDot(this.value, "");
  });

  var harga_kamar = document.getElementById("harga_kamar");
  harga_kamar.addEventListener("keyup", function (e) {
    harga_kamar.value = formatDot(this.value, "");
  });

});

function formatDot(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split("."),
    sisa = split[0].length % 3,
    angka = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    var separator = sisa ? "." : "";
    angka += separator + ribuan.join(".");
  }

  angka = split[1] != undefined ? angka + "." + split[1] : angka;
  return prefix == undefined ? angka : angka ? angka : "";
}

$('#search_mcs').click(function () {
  var l = window.location;
  var access_employee = $("#access_employee").val();
  var employee_nik = $("#employee_nik").val();
  if (access_employee == '12' && employee_nik == '00000000') {
    var nik = $("#nik_mcs").val();
    var no_req_group = $("#req_group_mcs").val();
    var tahun = $("#tahun_mcs").val();
    if (nik == '') {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'NIK tidak boleh kosong!',
        showConfirmButton: false,
        timer: 1500
      });
    } else if (tahun == '') {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Tahun tidak boleh kosong!',
        showConfirmButton: false,
        timer: 1500
      });
    } else {
      no_req_group = 'HRIS_MDCR' + no_req_group;
      var newParams = [
        ['nik', nik],
        ['no_req_group', no_req_group],
        ['tahun', tahun]
      ];
      var search = insertParams(newParams);
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Searching.',
        showConfirmButton: false,
        timer: 2500
      });
      l.search = search;
    }
  } else {
    var nik = $("#nik_mcs").val();
    var no_req_group = $("#req_group_mcs").val();
    if (nik == '') {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'NIK tidak boleh kosong!',
        showConfirmButton: false,
        timer: 1500
      });
    } else if (no_req_group == '') {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'FI Request Number tidak boleh kosong!',
        showConfirmButton: false,
        timer: 1500
      });
    } else {
      no_req_group = 'HRIS_MDCR' + no_req_group;
      var newParams = [
        ['nik', nik],
        ['no_req_group', no_req_group]
      ];
      var search = insertParams(newParams);
      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Searching.',
        showConfirmButton: false,
        timer: 2500
      });
      l.search = search;
    }
  }
});

$('#search_mmr').click(function () {
  var l = window.location;
  var access_employee = $("#access_employee").val();
  var employee_nik = $("#employee_nik").val();

  var bulan = $("#bulan_mmr").val();
  if (bulan == '' || bulan == null) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Bulan tidak boleh kosong!',
      showConfirmButton: false,
      timer: 1500
    });
  } else {
    // alert(bulan);
    var newParams = [
      ['bulan', bulan]
    ];
    var search = insertParams(newParams);
    Swal.fire({
      position: 'center',
      icon: 'info',
      title: 'Searching.',
      showConfirmButton: false,
      timer: 2500
    });
    l.search = search;
  }
});


function insertParams(params) {
  var result;
  var ii = params.length;
  var queryString = document.location.search.substr(1);
  var kvps = queryString ? queryString.split('&') : [];
  var kvp;
  var skipParams = [];
  var i = kvps.length;
  while (i--) {
    kvp = kvps[i].split('=');
    if (kvp[0].slice(-2) != '[]') {
      var ii = params.length;
      while (ii--) {
        if (params[ii][0] == kvp[0]) {
          kvp[1] = params[ii][1];
          kvps[i] = kvp.join('=');
          skipParams.push(ii);
        }
      }
    }
  }
  var ii = params.length;
  while (ii--) {
    if (skipParams.indexOf(ii) === -1) {
      kvps.push(params[ii].join('='));
    }
  }
  result = kvps.length ? '?' + kvps.join('&') : '';
  return result;
}

//////////////////////////// CEK LIMIT PAGU DI FORM MEDICAL


$('#tahun_pagu').change(function () {
  var employee_nik = $("#employee_id").val();
  var employee_group = $("#employee_group").val();
  var grandparent = $("#request_grandparent_tambah").val();
  var parent = $("#request_parent_tambah").val();
  var child = $("#request_child_tambah").val();
  var tanggal_kuitansi = $(this).val();
  var cek_limit_pagu = "form/cek_limit_pagu";


  // alert("01-01-"+tanggal_kuitansi);
  $.ajax({
    url: cek_limit_pagu,
    dataType: 'json',
    type: 'POST',
    data: {
      tanggal_kuitansi: "01-01-" + tanggal_kuitansi,
      employee_nik: employee_nik,
      employee_group: employee_group
    },
    success: function (pagu_remaining) {
      var pagu_remaining = pagu_remaining;
      $("#limit_rawat_jalan").val(formatRupiah.format(pagu_remaining['pagu_jalan_tahun']));
      $("#limit_rawat_inap_kamar").val(formatRupiah.format(pagu_remaining['pagu_inap_kamar']));
      $("#limit_rawat_inap").val(formatRupiah.format(pagu_remaining['pagu_inap_tahun']));
      $("#limit_kacamata_one_focus").val(formatRupiah.format(pagu_remaining['pagu_one_focus_tahun']));
      $("#limit_kacamata_two_focus").val(formatRupiah.format(pagu_remaining['pagu_two_focus_tahun']));
      $("#limit_kacamata_frame").val(formatRupiah.format(pagu_remaining['pagu_frame_dua_tahun']));
    }
  });
});

$('.decrypt_encryption').click(function () {

  var con_type = $('#conversion_type').val();
  var input = $('#input_check_enc').val();
  var url = "enc/dec";

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { con_type: con_type, input: input },
    success: function (data) {
      $('#output_check_enc').val(data);
    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Kesalahan dalam decryption',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function change_type(type) {
  $('#input_check_enc').val('');
  $('#output_check_enc').val('');

  $('#conversion_type').val(type);
}


////////////////////////////PA 2024/////////////////////////////////

$('#getEmployeeToDivisions').click(function () {
  $('#form_tambah_mul_div').trigger("reset");
  $("#year_picker").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years"
  });

  $('.select-search_user_division').select2({
    dropdownParent: $('#modalTambahMulDivision')
  });

  $('.select-search_division').select2({
    dropdownParent: $('#modalTambahMulDivision')
  });

  var getEmployeeToMulDiv = "master/getEmployeeToUsers";
  $.ajax({
    url: getEmployeeToMulDiv,
    dataType: 'json',
    type: 'POST',
    data: {},
    success: function (data) {
      $('#full_name_tambah_mul_div').html(data);
    }
  });


  var getDataDiv = "master/getDataDivisions";
  $.ajax({
    url: getDataDiv,
    dataType: 'json',
    type: 'POST',
    data: {},
    success: function (data) {
      $('#tambah_divisi').html(data);
    }
  });
});

$('#full_name_tambah_mul_div').change(function () {
  var full_name_tambah_users = $('#full_name_tambah_mul_div').val();
  if (full_name_tambah_users != '') {
    var get_Data_Employee = "master/get_DataEmployeeToUsers";
    $.ajax({
      url: get_Data_Employee,
      method: 'POST',
      dataType: 'json',
      data: { full_name_tambah_users: full_name_tambah_users },
      success: function (data) {
        var nik = data.nik;
        $('#employee_id_tambah').val(nik);
      }
    });
  }
});

///////////////////////////////// START TIME MANAGEMENT 2024 /////////////////////////////////////////
// Mengubah Format Tanggal
function dateFormat(inputDate, format) {
  const date = new Date(inputDate);

  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();

  format = format.replace("MM", month.toString().padStart(2, "0"));

  if (format.indexOf("yyyy") > -1) {
    format = format.replace("yyyy", year.toString());
  } else if (format.indexOf("yy") > -1) {
    format = format.replace("yy", year.toString().substr(2, 2));
  }

  format = format.replace("dd", day.toString().padStart(2, "0"));

  return format;
}
///////////////////////////////// END TIME MANAGEMENT 2024 /////////////////////////////////////////

///////////////Start Luffi 2024/////////////

function edit_user(id_user) {
  var id = document.getElementById(id_user).getAttribute("id");
  var url = "master/show_user/";

  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { id: id },
    success: function (data) {
      if (data != null) {
        $("#edit_id_user").val(id);
        $("#edit_employee_name").val(data.full_name);
        $("#edit_employee_id").val(data.employee_id);
        $("#edit_email").val(data.user_email);
        $("#edit_phone").val(data.phone_number);
        $("#edit_role").val(data.user_role).change();
        $("#edit_access").val(data.access_level).change();
        $("#edit_verification").val(data.verification_status).change();
      } else {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Data tidak ada salah",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Data tidak ada",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
}

$("#reset_password").click(function () {
  var new_reset_password = $("#new_reset_password").val();
  var confirm_reset_password = $("#confirm_reset_password").val();
  var id_user = $("#edit_id_user").val();

  if (new_reset_password == "" || new_reset_password === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Silahkan isi Password baru",
      showConfirmButton: false,
      timer: 2500,
    });
    return false;
  }

  if (confirm_reset_password == "" || confirm_reset_password === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Silahkan isi Password Confirmation baru",
      showConfirmButton: false,
      timer: 2500,
    });
    return false;
  }

  if (confirm_reset_password != new_reset_password) {
    Swal.fire({
      position: "center",
      icon: "error",
      title:
        "Password Confirmation tidak sama dengan Password baru, silahkan pastikan kembali",
      showConfirmButton: false,
      timer: 2500,
    });
    return false;
  }

  var url = "master/save_password_user/";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { id_user: id_user, confirm_reset_password: confirm_reset_password },
    success: function (data) {
      if (data == true) {
        $("#table_users").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Password Berhasil di-Reset",
          showConfirmButton: false,
          timer: 2500,
        });
      } else {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Password Error!",
          showConfirmButton: false,
          timer: 2500,
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Password Error",
        showConfirmButton: false,
        timer: 2500,
      });
    },
  });
});

function delete_user(delete_user) {
  var id = document.getElementById(delete_user).getAttribute("id");
  var url = "master/delete_user/";

  Swal.fire({
    title: "Are you sure?",
    text: "It will permanently deleted !",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $("#table_users").DataTable().ajax.reload();
            Swal.fire({
              position: "center",
              icon: "info",
              title: "Data telah dihapus",
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Data tidak dapat dihapus",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        },
        error: function (data) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Data tidak dapat dihapus",
            showConfirmButton: false,
            timer: 1500,
          });
        },
      });
    }
  });
}

///////////////End Luffi 2024/////////////

///////////////////////////////Start Penambahan Logs Activity 2025///////////////////////////
$('.logs_report-table thead tr')
  .clone(true)
  .addClass('filters')
  .appendTo('.logs_report-table thead');

const d = new Date();
var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + "" + ("0" + d.getMinutes()).slice(-2);
$(".logs_report-table").DataTable({
  ajax: "report/logs_report_table",
  columnDefs: [{ targets: 4, className: "truncate" }],
  createdRow: function (row) {
    var td = $(row).find(".truncate");
    td.attr("title", td.html());
  },
  //scrollY: '100%',
  scrollX: true,
  ordering: true,
  overflow: true,
  order: [6, "desc"],
  searching: true,
  dom:
    "<'row'<'col-sm-6'B><'col-sm-5 text-right'f>>" +
    "<'row'<'col-sm-12'tr>>" +
    "<'row'<'col-sm-4 text-left'l>>" +
    "<'row'<'col-sm-8 text-right'p>>" +
    "<'row'<'col-sm-2'i>>",
  buttons: [
    {
      extend: "copy",
      text: "Copy to clipboard",
    },
    {
      extend: "pdf",
      title: 'Activity Logs ' + datestring + ' - HRIS'
    },
    // "excel",
    // "csv",
    // 'pdf',
    "colvis",
  ],
  autoWidth: true,
  pagingType: "full_numbers",
  orderCellsTop: true,
  fixedHeader: true,
  initComplete: function () {
    var api = this.api();

    api
      .columns()
      .eq(0)
      .each(function (colIdx) {
        var cell = $(".filters th").eq(
          $(api.column(colIdx).header()).index()
        );
        var title = $(cell).text();
        $(cell).html('<input type="text" placeholder="' + title + '" />');

        $(
          "input",
          $(".filters th").eq($(api.column(colIdx).header()).index())
        )
          .off("keyup change")
          .on("change", function (e) {
            // Get the search value
            $(this).attr("title", $(this).val());
            var regexr = "({search})";

            var cursorPosition = this.selectionStart;
            api
              .column(colIdx)
              .search(
                this.value != ""
                  ? regexr.replace("{search}", "(((" + this.value + ")))")
                  : "",
                this.value != "",
                this.value == ""
              )
              .draw();
          })
          .on("keyup", function (e) {
            e.stopPropagation();

            $(this).trigger("change");
            $(this)
              .focus()[0]
              .setSelectionRange(cursorPosition, cursorPosition);
          });
      }).columns.adjust();
  },
});
///////////////////////////////End Penambahan Logs Activity 2025///////////////////////////

///////////////////////////////START Penambahan Action couple Luffi 2025 //////////////////////////////
$("#start_date_couple").focus(function () {
  if (!$(this).val()) {
    $("#end_date_couple").val("12/31/9999");
  }
});

function edit_couple(edit_couple) {
  var id = document.getElementById(edit_couple).getAttribute("id");
  $('.modalEditCouple').modal('show');
  var url = 'master/edit_couple/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (data) {
      if (data == false) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat dicari',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $("#id_couple").val(id);
        $("#full_name_male_edit_couple").val(data.male_employee);
        $("#employee_id_male_edit").val(data.male_nik);
        $("#full_name_female_edit_couple").val(data.female_employee);
        $("#employee_id_female_edit").val(data.female_nik);
        var start_date = new Date(data.start_date);
        var end_date = new Date(data.end_date);
        var start_date = (start_date.getMonth() + 1).toString().padStart(2, '0') + "/" + (start_date.getDate()).toString().padStart(2, '0') + "/" + start_date.getFullYear();
        var end_date = (end_date.getMonth() + 1).toString().padStart(2, '0') + "/" + (end_date.getDate()).toString().padStart(2, '0') + "/" + end_date.getFullYear();
        $("#start_date_couple_edit").val(start_date);
        $('.sd_date-picker').datepicker('setDate', start_date);
        $("#end_date_couple_edit").val(data.end_date);
        $('.ed_date-picker').datepicker('setDate', end_date);
      }


    },
    error: function (data) {
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat dicari',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });

}


$("#edit_save_couple").click(function () {
  var id_couple = $("#id_couple").val();
  var start_date_couple = $("#start_date_couple_edit").val();
  var end_date_couple = $("#end_date_couple_edit").val();

  if (start_date_couple == "" || start_date_couple === undefined || end_date_couple == "" || end_date_couple === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: 'Periode tidak boleh kosong',
      showConfirmButton: false,
      timer: 2500,
    });
    return false;
  }

  if (start_date_couple > end_date_couple) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: 'Start Date tidak boleh melebihi <br>End Date',
      showConfirmButton: false,
      timer: 2500,
    });
    return false;
  }

  Swal.fire({
    title: 'Are you sure?',
    text: "You will change the data and it will affect the transaction.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, edit it!'
  }).then((result) => {
    if (result.isConfirmed) {

      var url = 'master/edit_save_couple/';
      $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id_couple: id_couple, start_date_couple: start_date_couple, end_date_couple: end_date_couple },
        success: function (data) {
          if (data == true) {
            $('#table_couple').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Data telah dirubah',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Data tidak dapat dirubah',
              showConfirmButton: false,
              timer: 1500
            });
          }

        },
        error: function (data) {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Data tidak dapat dicari',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });

});
///////////////////////////////End Penambahan Action couple Luffi 2025 //////////////////////////////


//////////////////////////////Start Penambahan action sent to AP Luffi 2025//////////////////////////////
function SentMDCRToAP(SentToAP) {
  const id = SentToAP.getAttribute('data-no_req');
  var url = "form/SentDocumentsToAP/";

  Swal.fire({
    title: "Are you sure?",
    html: "Send documents <b>" + id + "</b> to the AP Department",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sent!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#list_mdcr_proccess_fi').DataTable().ajax.reload();
            $('#list_approval_mdcr_waitinglist').DataTable().ajax.reload();
            $('#list_approval_mdcr_revised').DataTable().ajax.reload();
            $('#list_approval_mdcr_rejected').DataTable().ajax.reload();
            $('#list_approval_mdcr_approved').DataTable().ajax.reload();
            $('#list_request_to_hr_mdcr').DataTable().ajax.reload();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Documents was sent",
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Documents can not sent",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        },
        error: function (data) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Documents can not sent",
            showConfirmButton: false,
            timer: 1500,
          });
        },
      });
    }
  });
}


$(document).ready(function () {

  const baseUrl = `${window.location.protocol}//${window.location.host}`;
  // alert(baseUrl);
  let tableRequestToDivHrMDCR = $('#list_mdcr_group').DataTable({
    serverSide: true,
    ajax: {
      url: "form/get_doc_mdcr_div_hr_fi",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "30%", targets: 0 },
      { width: "30%", targets: 1 },
      { width: "40%", targets: 2 }
    ]
  });

	//list mdcr untuk AP
	let tableRequestToAPMDCR = $('#list_mdcr_group_ap').DataTable({
    serverSide: true,
    ajax: {
      url: "report/get_doc_mdcr_ap",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "30%", targets: 0 },
      { width: "50%", targets: 1 },
      { width: "20%", targets: 2 }
    ]
  });

  let tableRequestToHrMDCR = $('#list_request_to_hr_mdcr').DataTable({
    serverSide: true,
    ajax: {
      url: "form/get_request_to_hr_mdcr",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },    
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "20%", targets: 0 },
      { width: "50%", targets: 1 },
      { width: "30%", targets: 2 }
    ]
  });

  let tableMDCRfi = $('#list_mdcr_proccess_fi').DataTable({
    serverSide: true,
    ajax: {
      url: "form/get_doc_mdcr_fi",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },    
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "30%", targets: 0 },
      { width: "30%", targets: 1 },
      { width: "40%", targets: 2 }
    ]
  });

  let tableApprovalMDCR = $('#list_approval_mdcr_approved').DataTable({
    serverSide: true,
    ajax: {
      url: "form/get_approved_mdcr",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },    
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "20%", targets: 0 },
      { width: "50%", targets: 1 },
      { width: "30%", targets: 2 }
    ]
  });

  let tableRejectMDCR = $('#list_approval_mdcr_rejected').DataTable({
    serverSide: true,
    ajax: {
      url: "form/get_reject_mdcr",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },    
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "20%", targets: 0 },
      { width: "50%", targets: 1 },
      { width: "30%", targets: 2 }
    ]
  });

  let tableReviseMDCR = $('#list_approval_mdcr_revised').DataTable({
    serverSide: true,
    ajax: {
      url: "form/get_revise_mdcr",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },    
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "20%", targets: 0 },
      { width: "50%", targets: 1 },
      { width: "30%", targets: 2 }
    ]
  });

  // Simpan state checkbox (by ID)
  let selectedWaitingListMDCR = {};

  let tableWaitingListMDCR = $('#list_approval_mdcr_waitinglist').DataTable({
    serverSide: true,
    ajax: {
      url: "form/get_waitinglist_mdcr",
      type: "POST"
    },
    dom: 'frtip',
    pageLength: 10,
    processing: true,
    language: {
      processing: '<img style="width:100px; height:100px;" src="'+baseUrl+'/assets/images/kucinghitam.gif" />'
    },    
    ordering: false,
    autoWidth: false,
    columnDefs: [
      { width: "5%", targets: 0 },
      { width: "10%", targets: 1 },
      { width: "30%", targets: 2 },
      { width: "20%", targets: 3 },
      { width: "35%", targets: 4 }
    ],
    drawCallback: function () {
      // Setelah tabel di-render ulang
      $('#list_approval_mdcr_waitinglist .checked_id_mdcr').each(function () {
        let id = $(this).val();
        if (selectedWaitingListMDCR[id]) {
          $(this).prop('checked', true);
        }
      });
    }
  });

  $(document).on('change', '.checked_id_mdcr', function () {
    let id = $(this).val();
    if (this.checked) {
      selectedWaitingListMDCR[id] = true;
    } else {
      delete selectedWaitingListMDCR[id];
    }
  });

  // Checkbox "Select All" di header
  $(document).on('change', '.check11', function () {
    let checked = this.checked;
    $('#list_approval_mdcr_waitinglist .checked_id_mdcr').each(function () {
      $(this).prop('checked', checked).trigger('change');
    });
  });


  $('#search_approval_mdcr').on('keyup', function () {
    tableRequestToDivHrMDCR.search(this.value).draw();
    tableRequestToHrMDCR.search(this.value).draw();
    tableWaitingListMDCR.search(this.value).draw();
    tableReviseMDCR.search(this.value).draw();
    tableRejectMDCR.search(this.value).draw();
    tableApprovalMDCR.search(this.value).draw();
    tableMDCRfi.search(this.value).draw();
		tableRequestToAPMDCR.search(this.value).draw();
  });


	$('.btn_modal_ap').click(function () {
		// var id = $(this).attr("data-id");

		console.log('awndinnw');
		
	});

  $('.grouping_req_mdcr').click(function () {

    var req_mdcr = Object.keys(selectedWaitingListMDCR);

    if (req_mdcr.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'No document selected!',
        text: 'Please select at least one document to group.',
        showConfirmButton: true
      });
      return;
    }

    Swal.fire({
      title: 'Are you sure you want to grouping all these documents?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Submit'
    }).then((result) => {
      if (result.isConfirmed) {

        Swal.fire({
          title: 'Processing...',
          text: 'Please wait while we save your data.',
          showConfirmButton: false,
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        $.ajax({
          url: 'inbox/grouping_req_mdcr/',
          type: 'POST',
          dataType: 'json',
          data: { req_mdcr: req_mdcr }, // kirim semua ID yang disimpan
          success: function (data) {
            Swal.close();

            if (data === true) {

              // RESET DATA
              Object.keys(selectedWaitingListMDCR).forEach(
                key => delete selectedWaitingListMDCR[key]
              );

              // RESET CHECKBOX
              $('.checked_id_mdcr').prop('checked', false);
              $('.check11').prop('checked', false);              

              $('#list_mdcr_proccess_fi').DataTable().ajax.reload();
              $('#list_approval_mdcr_waitinglist').DataTable().ajax.reload();
              $('#list_approval_mdcr_revised').DataTable().ajax.reload();
              $('#list_approval_mdcr_rejected').DataTable().ajax.reload();
              $('#list_approval_mdcr_approved').DataTable().ajax.reload();
              $('#list_request_to_hr_mdcr').DataTable().ajax.reload();

              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Success Grouping',
                showConfirmButton: false,
                timer: 1500
              });
              // }).then(() => location.reload());

            } else if (data === '15_lebih') {
              Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Please group the form less than or equal to 15 requests',
                showConfirmButton: false,
                timer: 2000
              });
            }
          },
          error: function () {
            Swal.close();
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong during grouping process.'
            });
          }
        });
      }
    });
  });

});





//////////////////////////////End Penambahan action sent to AP Luffi 2025//////////////////////////////