$(document).ready(function () {

  // $(".start_date_request_time_off").datepicker({
  //   format: 'dd/mm/yyyy',
  //   autoclose: true
  // });
  
  // $(".end_date_request_time_off").datepicker({
  //   format: 'dd/mm/yyyy',
  //   autoclose: true
  // });

// if ($.fn.DataTable.isDataTable('#MySlip')) {
  
// $("#MySlip").DataTable({
//     // scrollY: '100%',
//     // scrollX: true,
//     ordering: true,
//     order: [3, "desc"],
//     searching: true,
//     dom:
//       "<'row'<'col-sm-6'B><'col-sm-5 text-right'f>>" +
//       "<'row'<'col-sm-12'tr>>" +
//       "<'row'<'col-sm-4 text-left'l>>" +
//       "<'row'<'col-sm-8 text-right'p>>" +
//       "<'row'<'col-sm-2'i>>",
//     buttons: [
//       {
//         extend: "copy",
//         text: "Copy to clipboard",
//       },
//       // "excel",
//       // "csv",
//       // 'pdf',
//       "colvis",
//     ],
//     // columnDefs: [
//     //   { 'visible': false, 'targets': [5], 'searchable': false }
//     // ],
//     autoWidth: true,
//     pagingType: "full_numbers",
//     orderCellsTop: true,
//     fixedHeader: true,
//     initComplete: function () {
//       var api = this.api();

//       api
//         .columns()
//         .eq(0)
//         .each(function (colIdx) {
//           var cell = $(".filters th").eq(
//             $(api.column(colIdx).header()).index()
//           );
//           var title = $(cell).text();
//           $(cell).html('<input type="text" placeholder="' + title + '" />');

//           $(
//             "input",
//             $(".filters th").eq($(api.column(colIdx).header()).index())
//           )
//             .off("keyup change")
//             .on("change", function (e) {
//               // Get the search value
//               $(this).attr("title", $(this).val());
//               var regexr = "({search})";

//               var cursorPosition = this.selectionStart;
//               api
//                 .column(colIdx)
//                 .search(
//                   this.value != ""
//                     ? regexr.replace("{search}", "(((" + this.value + ")))")
//                     : "",
//                   this.value != "",
//                   this.value == ""
//                 )
//                 .draw();
//             })
//             .on("keyup", function (e) {
//               e.stopPropagation();

//               $(this).trigger("change");
//               $(this)
//                 .focus()[0]
//                 .setSelectionRange(cursorPosition, cursorPosition);
//             });
//         });
//     },
//   });

// }

  
  
  $(".log_balance-table").DataTable({
    ajax: "form/balance_log_table",
    //scrollY: '100%',
    scrollX: true,
    ordering: true,
    order: [0, "asc"],
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
      "excel",
      "csv",
      // 'pdf',
      "colvis",
    ],
    columnDefs: [
      { 'visible': false, 'targets': [0] }
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
        });
    },
  });

  $(".r_attendance-table").DataTable({
    processing: true,
    language: { processing: '<i class="spinner-border"></i><span class="sr-only">Loading...</span> '},
    // serverSide :true,
    ajax: {
      "type" : 'GET',
      "url": 'report/attendance_table/1200',
      "dataSrc": function ( json ) {
        $("#in-office").html(json.InOffice);
        $("#out-office").html(json.OutOffice);
        $("#inoffice_percent").html(json.InPercent);
        $("#outoffice_percent").html(json.OutPercent);
        return json.data;
      }
    },
    //scrollY: '100%',
    scrollX: true,
    order: [
      [1, "asc"],
      [5, "desc"],
    ],
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
        extend: "copy",
        text: "Copy to clipboard",
      },
      "excel",
      "csv",
      //'pdf',
      "colvis",
    ],
    autoWidth: true,
    pagingType: "full_numbers",
    orderCellsTop: true,
    fixedHeader: true,
    // TIME MANAGEMENT 2.0
    rowCallback: function( row, data ) {
      if ( (data[14] === "Non Office Area" && data[18] === "Non Office Area") && (data[12] != 'DDK' && data[12] != 'PPD')) {
        $(row).find('td:eq(0)').css('background-color','#FF4D4D');
      } else if ( (data[14] === "Non Office Area" && data[18] === "") && (data[12] != 'DDK' && data[12] != 'PPD')) {        
        $(row).find('td:eq(0)').css({background:'linear-gradient(90deg, #FF4D4D 50%, #FFFFFF 50%)'});
      } else if ( (data[14] === "Non Office Area" && data[18] === "Office Area") && (data[12] != 'DDK' && data[12] != 'PPD')) {        
        $(row).find('td:eq(0)').css({background:'linear-gradient(90deg, #FF4D4D 50%, #4DFF65 50%)'});
      } else if ( (data[14] === "Office Area" && data[18] === "Office Area") && (data[12] != 'DDK' && data[12] != 'PPD')) {        
        $(row).find('td:eq(0)').css('background-color','#4DFF65');
      } else if ( (data[14] === "Office Area" && data[18] === "") && (data[12] != 'DDK' && data[12] != 'PPD')) {        
        $(row).find('td:eq(0)').css({background:'linear-gradient(90deg, #4DFF65 50%, #FFFFFF 50%)'});
      } else if ( (data[14] === "Office Area" && data[18] === "Non Office Area") && (data[12] != 'DDK' && data[12] != 'PPD')) {        
        $(row).find('td:eq(0)').css({background:'linear-gradient(90deg, #4DFF65 50%, #FF4D4D 50%)'});
      }

      $("#in-office h3").html(data[19]);
      $("#out-office h3").html(data[20]);
    },
    // ///////////////////
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
        });
    },
  });

  // TIME MANAGEMENT 2.0
  $('.office-table').DataTable({
    ajax: 'master/read/office/',
    //scrollY: '100%',
    scrollX: true,
    order: [[1, 'asc']],
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
      //'pdf',
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
  ///////////////////////////////////////

  //CR: AFTER TM 2.0
  $('.relocation-table').DataTable({
    ajax: 'master/read/relocation/',
    //scrollY: '100%',
    scrollX: true,
    order: [[1, 'asc']],
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
      //'pdf',
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
  // //////////////////

  // START CR 2 TM
  $(".detail_shift_schedule-table").DataTable({
    //scrollY: '100%',
    scrollX: true,
    ordering: true,
    order: [2, "asc"],
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
      "excel",
      "csv",
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
        });
    },
  });
  // END CR 2 TM
});

//////////////////////////////////// Master Time Management - Time Off ////////////////////////////////////////////
////////////////////               Created By:   Ronald Leonardo Prawira                       ////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(".tambah_time_off").click(function () {
  var nama = $("#nama_tambah_time_off").val();
  var kode = $("#kode_tambah_time_off").val();
  var company_name = $("#company_name_tambah_time_off option:selected").text();
  var company_code = $("#company_code_tambah_time_off option:selected").text();
  var start_date = $("#start_date_tambah_time_off").val();
  var end_date = $("#end_date_tambah_time_off").val();
  var deskripsi = $("#deskripsi_tambah_time_off").val();
  var url = "master/tambah_time_off";
  //alert(start_date);
  if (
    start_date == "" ||
    start_date === undefined ||
    end_date == "" ||
    end_date === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (nama == "" || nama === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (kode == "" || kode === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Kode Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (company_name == "" || company_name === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama Perusahaan tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: "json",
    type: "POST",
    data: {
      nama: nama,
      kode: kode,
      company_name: company_name,
      company_code: company_code,
      start_date: start_date,
      end_date: end_date,
      deskripsi: deskripsi,
    },
    success: function (data) {
      if (data == true) {
        $("#table_time_off").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Data telah ditambahkan",
          showConfirmButton: false,
          timer: 1500,
        });
        $("#modalTambahTimeOff").find("input,textarea").val("").end();
      } else if (data == "jarak_minus") {
        $("#table_time_off").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "warning",
          title:
            "Tidak bisa ditambahkan karena,<br> start date masuk dalam kategori role sebelumnya",
          showConfirmButton: false,
          timer: 3000,
        });
      }
    },
    error: function (data) {
      $("#table_time_off").DataTable().ajax.reload();
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Data tidak dapat ditambahkan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

function edit_time_off(edit_TM_time_off) {
  var id = document.getElementById(edit_TM_time_off).getAttribute("id");
  var url = "master/getEditTimeOff/";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { id: id },
    success: function (response) {
      var id = response[0].id;
      var nama = response[0].nama;
      var kode = response[0].kode;
      var company_name = response[0].company_name;
      var company_code = response[0].company_code;
      var start_date = dateFormat(response[0].start_date, "MM/dd/yyyy");
      var end_date = dateFormat(response[0].end_date, "MM/dd/yyyy");
      var deskripsi = response[0].deskripsi;

      $("#id_edit_time_off").val(id);
      $("#nama_edit_time_off").val(nama);
      $("#kode_edit_time_off").val(kode);
      $("div.company_name_edit select").val(company_name).change();
      $("div.company_code_edit select").val(company_code).change();
      $("#start_date_edit_time_off").val(start_date);
      $("#end_date_edit_time_off").val(end_date);
      $("#deskripsi_edit_time_off").val(deskripsi);
    },
  });
}

$(".ubah_time_off").click(function () {
  var id = $("#id_edit_time_off").val();
  var nama = $("#nama_edit_time_off").val();
  var kode = $("#kode_edit_time_off").val();
  var company_name = $("#company_name_edit_time_off").val();
  var company_code = $("#company_code_edit_time_off").val();
  var start_date = $("#start_date_edit_time_off").val();
  var end_date = $("#end_date_edit_time_off").val();
  var deskripsi = $("#deskripsi_edit_time_off").val();
  var url = "master/ubah_time_off";

  if (
    start_date == "" ||
    start_date === undefined ||
    end_date == "" ||
    end_date === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (nama == "" || nama === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (kode == "" || kode === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Kode Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: "json",
    type: "POST",
    data: {
      id: id,
      nama: nama,
      kode: kode,
      company_name: company_name,
      company_code: company_code,
      start_date: start_date,
      end_date: end_date,
      deskripsi: deskripsi,
    },
    success: function (data) {
      if (data == true) {
        $("#table_time_off").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Data telah diperbaharui",
          showConfirmButton: false,
          timer: 1500,
        });
      } else if (data == "jarak_minus") {
        $("#table_time_off").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "warning",
          title:
            "Tidak bisa diperbaharui karena,<br> start date masuk dalam kategori role sebelumnya",
          showConfirmButton: false,
          timer: 3000,
        });
      }
    },
    error: function (data) {
      $("#table_time_off").DataTable().ajax.reload();
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Data tidak dapat diperbaharui",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

function delete_time_off(DeleteTimeOff, KodeDelete) {
  Swal.fire({
    title: "Are you sure?",
    text: "Data tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete",
  }).then((result) => {
    if (result.isConfirmed) {
      var id = document.getElementById(DeleteTimeOff).getAttribute("id");
      var kode = KodeDelete;
      var url = "master/getDeleteTimeOff/";
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { id: id, kode: kode },
        success: function (data) {
          if (data == true) {
            $("#table_time_off").DataTable().ajax.reload();
            Swal.fire({
              position: "center",
              icon: "success",
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

$("#start_date_tambah_time_off").focus(function () {
  if (!$(this).val()) {
    $("#end_date_tambah_time_off").val("12/31/9999");
  }
});

function inputCountDescTO() {
  var display = document.getElementById("counter_deskripsi");
  var sisa = 99 - $("#deskripsi_tambah_time_off").val().length;
  display.innerHTML = sisa + "/99";
}

$("#company_name_tambah_time_off").change(function () {
  var id = $(this).children(":selected").attr("id");
  var code = "kode";
  var add = code.concat(id);
  var getVal = document.getElementById(add).text;

  $("div.company_code select").val(getVal).change();
});

$("#company_name_edit_time_off").change(function () {
  var id = $(this).children(":selected").attr("id");
  var code = "kode";
  var add = code.concat(id);
  var getVal = document.getElementById(add).text;

  $("div.company_code_edit select").val(getVal).change();
});

//////////////////////////////////// Master Time Management - Schedule ////////////////////////////////////////////

$(".tambah_schedule").click(function () {
  var nama = $("#nama_tambah_schedule").val();
  var kode = $("#kode_tambah_schedule").val();
  var company_name = $("#company_name_tambah_time_off option:selected").text();
  var company_code = $("#company_code_tambah_time_off option:selected").text();
  var start_date = $("#start_date_tambah_schedule").val();
  var end_date = $("#end_date_tambah_schedule").val();
  var schedule_in = $("#tambah_schedule_in").val();
  var schedule_out = $("#tambah_schedule_out").val();
  var tipe_shift = $("#shift_type_tambah_time_off").val();
  var url = "master/tambah_schedule";
  //alert(start_date);
  if (
    start_date == "" ||
    start_date === undefined ||
    end_date == "" ||
    end_date === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (
    schedule_in == "" ||
    schedule_in === undefined ||
    schedule_out == "" ||
    schedule_out === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Workhour tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (nama == "" || nama === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (kode == "" || kode === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Kode Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (company_name == "" || company_name === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama Perusahaan tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: "json",
    type: "POST",
    data: {
      nama: nama,
      kode: kode,
      company_name: company_name,
      company_code: company_code,
      start_date: start_date,
      end_date: end_date,
      schedule_in: schedule_in,
      schedule_out: schedule_out,
      tipe_shift: tipe_shift
    },
    success: function (data) {
      if (data == true) {
        $("#table_schedule").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Data telah ditambahkan",
          showConfirmButton: false,
          timer: 1500,
        });
        $("#modalTambahSchedule").find("input").val("").end();
      } else if (data == "jarak_minus") {
        $("#table_schedule").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "warning",
          title:
            "Tidak bisa ditambahkan karena,<br> start date masuk dalam kategori role sebelumnya",
          showConfirmButton: false,
          timer: 3000,
        });
      }
    },
    error: function (data) {
      $("#table_schedule").DataTable().ajax.reload();
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Data tidak dapat ditambahkan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

$("#start_date_tambah_schedule").focus(function () {
  if (!$(this).val()) {
    $("#end_date_tambah_schedule").val("12/31/9999");
  }
});

function edit_schedule(edit_TM_schedule) {
  var id = document.getElementById(edit_TM_schedule).getAttribute("id");
  var url = "master/getEditSchedule/";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { id: id },
    success: function (response) {
      var id = response[0].id;
      var nama = response[0].nama;
      var kode = response[0].kode;
      var company_name = response[0].company_name;
      var company_code = response[0].company_code;
      var start_date = dateFormat(response[0].start_date, "MM/dd/yyyy");
      var end_date = dateFormat(response[0].end_date, "MM/dd/yyyy");
      var schedule_in = response[0].schedule_in;
      var schedule_out = response[0].schedule_out;
      var tipe_shift = response[0].shift_type;

      $("#id_edit_schedule").val(id);
      $("#nama_edit_schedule").val(nama);
      $("#kode_edit_schedule").val(kode);
      $("div.company_name_edit select").val(company_name).change();
      $("div.company_code_edit select").val(company_code).change();
      $("#start_date_edit_schedule").val(start_date);
      $("#end_date_edit_schedule").val(end_date);
      $("#edit_schedule_in").val(schedule_in);
      $("#edit_schedule_out").val(schedule_out);
      $("#shift_type_edit_time_off").val(tipe_shift).change();
    },
  });
}

$(".ubah_schedule").click(function () {
  var id = $("#id_edit_schedule").val();
  var nama = $("#nama_edit_schedule").val();
  var kode = $("#kode_edit_schedule").val();
  var company_name = $("#company_name_edit_time_off option:selected").text();
  var company_code = $("#company_code_edit_time_off option:selected").text();
  var start_date = $("#start_date_edit_schedule").val();
  var end_date = $("#end_date_edit_schedule").val();
  var schedule_in = $("#edit_schedule_in").val();
  var schedule_out = $("#edit_schedule_out").val();
  var tipe_shift = $("#shift_type_edit_time_off").val();
  var url = "master/ubah_schedule";

  if (
    start_date == "" ||
    start_date === undefined ||
    end_date == "" ||
    end_date === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (
    schedule_in == "" ||
    schedule_in === undefined ||
    schedule_out == "" ||
    schedule_out === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Workhour tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (nama == "" || nama === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (kode == "" || kode === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Kode Time-Off tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: "json",
    type: "POST",
    data: { id: id, nama: nama, kode: kode, company_name: company_name, company_code: company_code, start_date: start_date, end_date: end_date, schedule_in: schedule_in, schedule_out: schedule_out, tipe_shift: tipe_shift },
    success: function (data) {
      if (data == true) {
        $("#table_schedule").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Data telah diperbaharui",
          showConfirmButton: false,
          timer: 1500,
        });
      } else if (data == "jarak_minus") {
        $("#table_schedule").DataTable().ajax.reload();
        Swal.fire({
          position: "center",
          icon: "warning",
          title:
            "Tidak bisa diperbaharui karena,<br> start date masuk dalam kategori role sebelumnya",
          showConfirmButton: false,
          timer: 3000,
        });
      }
    },
    error: function (data) {
      $("#table_schedule").DataTable().ajax.reload();
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Data tidak dapat diperbaharui",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

function delete_schedule(DeleteSchedule, KodeDelete) {
  Swal.fire({
    title: "Are you sure?",
    text: "Data tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete",
  }).then((result) => {
    if (result.isConfirmed) {
      var id = document.getElementById(DeleteSchedule).getAttribute("id");
      var kode = KodeDelete;
      var url = "master/getDeleteSchedule/";
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { id: id, kode: kode },
        success: function (data) {
          if (data == true) {
            $("#table_schedule").DataTable().ajax.reload();
            Swal.fire({
              position: "center",
              icon: "success",
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

// $('.clockpicker').clockpicker();

////////////////////////////////////////// TIME MANAGEMENT - REPORT ATTENDANCE //////////////////////////////////////////

function loadAttendanceReport(all_data = '', filter = '', type = ''){ 
  
  var is_head = $('#attendance_head').val();
  if (is_head == true){
    if (type != ''){
      var company_code = 1;

    } else {
      var company_code = 0;

      var emp_dept = [];
      $.ajax({
        async : false,
        type: 'POST',
        url: 'report/getEmpDept',
        dataType: 'json',
        success: function (response) {
          const chars = {
            '(': '^',
            ')': '_'
          };
          let s;
          
          for (let x in response){
            emp_dept.push(response[x].department);
          }
          var department = [...new Set(emp_dept)];

          for (let y = 0; y < department.length; y++) {
            s = department[y];
            s = s.replace(/[()]/g, m => chars[m]);
            department[y] = s;
          }
          
          all_data = encodeURIComponent(JSON.stringify(department));
        }
      });
    }
  } else {
    var company_code = $('#attendance_company').val();
  }
  
  var url = 'report/attendanceAnalysis/' + company_code + '/' + all_data;
  $.ajax({
      type: 'POST',
      url: url,
      data: { filter: filter, },
      dataType: 'json',
      success: function (response) {
          if (response == 0){
              $("#hadir_in").html("0");
              $("#hadir_out").html("0");
              $("#tidak_hadir_in").html("0");
              $("#tidak_hadir_out").html("0");
              $("#cuti").html("0");
              $("#on_time").html("0");
              $("#telat").html("0");
              $("#sakit").html("0");
          } else {
              $("#hadir_in").html(response[0]);
              $("#hadir_out").html(response[1]);
              $("#tidak_hadir_in").html(response[2]);
              $("#tidak_hadir_out").html(response[3]);
              $("#cuti").html(response[4]);
              $("#on_time").html(response[5]);
              $("#telat").html(response[6]);
              $("#sakit").html(response[7]);

              var in_percent = Math.round((response[0] / response[8]) * 100);
              var out_percent = Math.round((response[1] / response[8]) * 100);
              var no_in_percent = Math.round((response[2] / response[8]) * 100);
              var no_out_percent = Math.round((response[3] / response[8]) * 100);
              var cuti_percent = Math.round((response[4] / response[8]) * 100);
              var tepat_percent = Math.round((response[5] / response[8]) * 100);
              var telat_percent = Math.round((response[6] / response[8]) * 100);
              var sakit_percent = Math.round((response[7] / response[8]) * 100);
              $("#hadirin_percent").html(in_percent);
              $("#hadirout_percent").html(out_percent);
              $("#tidakhadirin_percent").html(no_in_percent);
              $("#tidakhadirout_percent").html(no_out_percent);
              $("#cuti_percent").html(cuti_percent);
              $("#ontime_percent").html(tepat_percent);
              $("#telat_percent").html(telat_percent);
              $("#sakit_percent").html(sakit_percent);
          }
      }
  });
}

var base_url = window.location.origin;

$(document).ready(function () {
  if(window.location == base_url + "/report/attendance"){
    var is_hr = $('#attendance_hr').val();
    var nik = $('#attendance_nik').val();
    if (is_hr == true){
      loadAttendanceReport();
    } else {
      var today = new Date();
      var this_month = new Date(today.getFullYear(), today.getMonth() + 1, 1);
      var start_date = this_month.getFullYear() + this_month.getMonth().toString().padStart(2, "0") + this_month.getDate().toString().padStart(2, "0") + 's-';
      var end_date = today.getFullYear() + (today.getMonth() + 1).toString().padStart(2, "0") + today.getDate().toString().padStart(2, "0") + 'e-';
      var data = nik + 'i-' + start_date + end_date;
      loadAttendanceReport(data);
    }
    
    // TIME MANAGEMENT 2.0
    var is_head = $('#attendance_head').val();
    if (is_head == true){
      var url_emp = 'report/getBelowHead';
      var own_dept = $('#attendance_dept').val();

      var dept = [];
      $("#search_employee_department").select2();
      $.ajax({
        type: 'POST',
        url: 'report/getEmpDept',
        dataType: 'json',
        success: function (response) {
          const chars = {
            '(': '^',
            ')': '_'
          };
          let s;

          for (let x in response){
            dept.push(response[x].department);
          }

          let uniqueDept = [...new Set(dept)];
          for (let y = 0; y < uniqueDept.length; y++) {
            s = uniqueDept[y];
            s = s.replace(/[()]/g, m => chars[m]);
            
            $('#search_employee_department').append($('<option></option>').attr('value', s).text(uniqueDept[y]));

            // s = s
            // .trim()
            // .replace(/\s+/g, '-')
            // .replace(/\(/g, '|-|')
            // .replace(/\)/g, '|_|');

            uniqueDept[y] = s;
          }
          if (own_dept != ''){
            $('#search_employee_department').append($('<option></option>').attr('value', own_dept).text(own_dept));
          }
          if ($.fn.DataTable.isDataTable('#table_attendance')) {
            $('#table_attendance').DataTable().ajax.url(base_url + '/report/attendance_table/0/' + encodeURIComponent(JSON.stringify(uniqueDept))).load();
          }
        }
      });
    } else {
      var url_emp = 'report/getEmployee';
    }
    ///////////////////////
    $.ajax({
      type: 'POST',
      url: url_emp, //TIME MANAGEMENT 2.0
      dataType: 'json', 
      success: function (response) {
          for (let x in response){
              $('#search_employee_names').append($('<option></option>').attr('value', response[x].nik).text(response[x].nik + ' - '+ response[x].complete_name));
          }
      }
    });

    //START CR 3 TM
    $("#search_dir_names").select2({
      dropdownParent: $("#modalAdvancedSearch"),
    });
    $("#search_div_names").select2({
      dropdownParent: $("#modalAdvancedSearch"),
    });
    $("#search_dept_names").select2({
      dropdownParent: $("#modalAdvancedSearch"),
    });

    $.ajax({
      type: "POST",
      url: "report/getDepartment",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#search_dept_names").append(
            $("<option></option>").attr("value", response[x]).text(response[x])
          );
        }
      },
    });
    $.ajax({
      type: "POST",
      url: "report/getDivision",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#search_div_names").append(
            $("<option></option>").attr("value", response[x]).text(response[x])
          );
        }
      },
    });
    $.ajax({
      type: "POST",
      url: "report/getDirectorate",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#search_dir_names").append(
            $("<option></option>").attr("value", response[x]).text(response[x])
          );
        }
      },
    });
    //END CR 3 TM
  }

  if (window.location == base_url + "/report/calendar") {
    $("#calendar").evoCalendar({
      theme: "Royal Navy",
      sidebarDisplayDefault: false,
      eventListToggler: false,
      todayHighlight: true,
    });
    $.ajax({
      type: "POST",
      url: "report/getCalendarEvents",
      dataType: "json",
      success: function (response) {
        // console.log(response);
        for (let x in response) {
          if (response[x][0] == 1) {
            $("#calendar").evoCalendar("addCalendarEvent", [
              {
                id: x,
                name: response[x][2],
                date: response[x][1],
                type: "holiday",
                color: response[x][3],
              },
            ]);
          } else if (response[x][0] == 2) {
            var to_date;
            if (response[x][3] == response[x][4]) {
              to_date = response[x][3];
            } else {
              to_date = [response[x][3], response[x][4]];
            }
            $("#calendar").evoCalendar("addCalendarEvent", [
              {
                id: x,
                name: response[x][1] + " ~ " + response[x][2],
                date: to_date,
                type: "time-off",
                color: "#f5cb25",
              },
            ]);
          } else if (response[x][0] == 3) {
            $("#calendar").evoCalendar("addCalendarEvent", [
              {
                id: x,
                name: "Birthday ~ " + response[x][1],
                date: response[x][2],
                type: "birthday",
                color: "#21d952",
                everyYear: true,
              },
            ]);
          }
        }
      },
    });

    $("#assign_schedule_employee_name").select2({
      dropdownParent: $("#modalAssignSchedule"),
    });
    $.ajax({
      type: "POST",
      url: "form/getEmployee",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#assign_schedule_employee_name").append(
            $("<option></option>")
              .attr("value", response[x].nik)
              .text(response[x].nik + " - " + response[x].complete_name)
          );
        }
      },
    });

    $.ajax({
      type: "POST",
      url: "report/getCompany",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#assign_schedule_branch").append(
            $("<option></option>")
              .attr("value", response[x].company_code)
              .text(response[x].company_name + " - " + response[x].company_code)
          );
        }
      },
    });
  }
  if (window.location == base_url + "/master/schedule") {

    $("#assign_schedule_employee_name").select2({
      dropdownParent: $("#modalAssignSchedule"),
    });
    $.ajax({
      type: "POST",
      url: "form/getEmployee",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#assign_schedule_employee_name").append(
            $("<option></option>")
              .attr("value", response[x].nik)
              .text(response[x].nik + " - " + response[x].complete_name)
          );
        }
      },
    });

    $.ajax({
      type: "POST",
      url: "report/getCompany",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#assign_schedule_branch").append(
            $("<option></option>")
              .attr("value", response[x].company_code)
              .text(response[x].company_name + " - " + response[x].company_code)
          );
        }
      },
    });

  }


  if (window.location == base_url + "/report/time_management_report") {
    $.ajax({
      type: "POST",
      url: "report/getCompany",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          if (x == 0) {
            $("#tm_report_branch").append(
              $("<option></option>")
                .attr({ value: response[x].company_code })
                .text(response[x].company_name)
            );
          } else {
            $("#tm_report_branch").append(
              $("<option></option>")
                .attr("value", response[x].company_code)
                .text(response[x].company_name)
            );
          }
        }
      },
    });
    
    $("#tm_report_employee").select2();
    $.ajax({
      type: 'POST',
      url: 'report/getEmployee',
      dataType: 'json',
      success: function (response) {
          for (let x in response){
              $('#tm_report_employee').append($('<option></option>').attr('value', response[x].nik).text(response[x].nik + ' - '+ response[x].complete_name));
          }
      }
    });
  }
  if(window.location == base_url + "/report/tm_report_head"){
    var dept = [];

    $("#tm_report_head_department").select2();
    $("#tm_report_head_employee").select2();
    $.ajax({
      type: 'POST',
      url: 'report/getEmpDept',
      dataType: 'json',
      success: function (response) {
        const chars = {
          '(': '^',
          ')': '_'
        };
        let s;
        
          for (let x in response){
            $('#tm_report_head_employee').append($('<option></option>').attr('value', response[x].nik).text(response[x].nik + ' - '+ response[x].complete_name));

            dept.push(response[x].department);
          }

          let uniqueDept = [...new Set(dept)];
          for (let y = 0; y < uniqueDept.length; y++) {
            s = uniqueDept[y];
            s = s.replace(/[()]/g, m => chars[m]);
            $('#tm_report_head_department').append($('<option></option>').attr('value', s).text(uniqueDept[y]));
          }
      }
    });
  }
  if(window.location == base_url + "/master/office"){ //CR: AFTER TM 2.0
    $("#employee_tambah_relokasi").select2({
      dropdownParent: $("#modalTambahRelokasi"),
    });
    $.ajax({
      type: "POST",
      url: "form/getEmployee",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#employee_tambah_relokasi").append(
            $("<option></option>")
              .attr("value", response[x].nik)
              .text(response[x].nik + " - " + response[x].complete_name)
          );
        }
      },
    });

    $.ajax({
      type: "POST",
      url: "master/getRelocationLocation",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          $("#pa_akhir_tambah_relokasi").append(
            $("<option></option>")
              .attr("value", response[x].personnel_area)
              .text(response[x].personnel_area)
          );
        }
      },
    });
  }

  // START CR 2 TM
  if(window.location == base_url + "/master/shifting_menu"){
    const date = new Date(); 
    var this_month = ("0" + (date.getMonth() + 1)).slice(-2);
    var this_year = date.getFullYear(); 

    $.ajax({
      type: "POST",
      url: "master/getYear",
      dataType: "json",
      success: function (response) {
        for (let x in response) {
          if (response[x].year == this_year){
            $("#detail_schedule_year").append(
              $("<option></option>")
                .attr({ value: response[x].year, selected: true })
                .text(response[x].year)
            );
            $("#upload_shift_schedule_year").append(
              $("<option></option>")
                .attr({ value: response[x].year, selected: true })
                .text(response[x].year)
            );
          } else {
            $("#detail_schedule_year").append(
              $("<option></option>")
                .attr("value", response[x].year)
                .text(response[x].year)
            );
            $("#upload_shift_schedule_year").append(
              $("<option></option>")
                .attr("value", response[x].year)
                .text(response[x].year)
            );
          }
        }
      },
    });

    $("#detail_schedule_month").val(this_month).change();
    $("#upload_shift_schedule_month").val(this_month).change();
  }
  // END CR 2 TM
});

$('.advance_search').click(function () {
  // var nik = $("#search_employee_id").val();
  // var nama = $("#search_employee_name").val();
  var access = $("#check_access_level").val();
  var start_date = $("#search_start_date").val();
  var end_date = $("#search_end_date").val();
  var department = $("#search_employee_department").val();
  var depart = $("#search_dept_names").val();
  var division = $("#search_div_names").val();
  var directorate = $("#search_dir_names").val();
  var all_data = '';

  if (access == '' || access == undefined){
    var names = $("#search_employee_names").val();

    if (depart != undefined || division != undefined || directorate != undefined){
      // const chars = {
      //   '(': '^',
      //   ')': '_'
      // };
      // if (depart == '' || depart === undefined){
        
      // } else {
      //   depart = depart.replace(/[()]/g, m => chars[m]);
      // }
  
      if (depart) {
        const chars = { '(': '^', ')': '_' };
        depart = depart.replace(/[()]/g, m => chars[m]);
      }
      
      if (division) {
        const chars = { '(': '^', ')': '_' };
        division = division.replace(/[()]/g, m => chars[m]);
      }

      if (directorate) {
        const chars = { '(': '^', ')': '_' };
        directorate = directorate.replace(/[()]/g, m => chars[m]);
      }

      var filter = [depart, division, directorate];
      var filter_data = encodeURIComponent(JSON.stringify(filter));
    }
    
  } else {
    var names = [access];

    var filter_data = '';
  }

  var is_head = $("#attendance_head").val();
  if (is_head == true){
    var company_code = 1;

    if (((names.length == 0) || (names == undefined)) && ((start_date != '') || (end_date != '')) && ((department.length == 0) || (department == undefined))){
      var emp_dept = [];
      $("#search_employee_department option").each(function()
      {
        emp_dept.push(this.value);
      });
      department = emp_dept;
    }
  } else {
    var company_code = $("#attendance_company").val();
  }

  if (((names.length == 0) || (names == undefined)) && ((start_date == '') || (start_date == undefined)) && ((end_date == '') || (end_date == undefined)) && ((department.length == 0) || (department == undefined))){
    
  } else {
    // if (nik != '' && nik != undefined){
    //   all_data += ' '+nik+'i ';
    // }
    // if (nama != '' && nama != undefined){
    //   var new_nama = nama.replace(/\s+/g,"?");
    //   all_data += ' '+new_nama+'n ';
    // }
    if (names != '' && names != undefined){
      for(var x=0; x<names.length; x++){
        if (x==0){
          var flag = 'i';
        } else {
          var flag = 'n';
        }
        all_data += ' '+names[x]+ flag +' ';
      }
    }
    if (start_date != '' && start_date != undefined){
      var new_start_date = dateFormat(start_date, 'yyyyMMdd');
      all_data += ' '+new_start_date+'s ';
    }
    if (end_date != '' && end_date != undefined){
      var new_end_date = dateFormat(end_date, 'yyyyMMdd');
      all_data += ' '+new_end_date+'e ';
    }
    if (department != '' && department != undefined){
      var dept;
      for(var y=0; y<department.length; y++){
        if (y==0){
          var flag = '.';
        } else {
          var flag = ':';
        }

        dept = department[y].replace(/\s+/g,'~');
        const chars = { '(': '^', ')': '_' };
        dept = dept.replace(/[()]/g, m => chars[m]);
        all_data += ' '+encodeURIComponent(dept)+ flag +'@';
      }
    }
    
    all_data = all_data.replace(/\s+/g,'-');
    all_data = all_data.slice(1);
    
    if ($.fn.DataTable.isDataTable('#table_attendance')) {
      $('#table_attendance').DataTable().ajax.url(base_url + '/report/attendance_table/' + company_code + '/' + all_data + '/' + filter_data).load();
    }
    if (is_head == true){
      loadAttendanceReport(all_data, filter,'head');
    } else {
      loadAttendanceReport(all_data, filter);
    }
    $('#search_end_date').attr('disabled', true);
  }

  // $('#search_start_date').val('');
  // $('#search_end_date').val('');
});

// $('.advance_search').click(function () {
//   const access = $("#check_access_level").val();
//   const start_date = $("#search_start_date").val();
//   const end_date = $("#search_end_date").val();
//   const department = $("#search_employee_department").val() || [];
//   let depart = $("#search_dept_names").val();
//   let division = $("#search_div_names").val();
//   let directorate = $("#search_dir_names").val();
//   const is_head = $("#attendance_head").val();
//   let company_code = is_head ? 1 : $("#attendance_company").val();
//   let names = [];
//   let all_data = '';
//   let filter_data = '';
//   let filter = [];

//   // === Handle access level ===
//   if (!access) {
//     names = $("#search_employee_names").val() || [];

//     // Handle depart with special characters ( ) -> ^ and _
//     if (depart) {
//       const chars = { '(': '^', ')': '_' };
//       depart = depart.replace(/[()]/g, m => chars[m]);
//     }
    
//     if (division) {
//       const chars = { '(': '^', ')': '_' };
//       division = division.replace(/[()]/g, m => chars[m]);
//     }

//     if (directorate) {
//       const chars = { '(': '^', ')': '_' };
//       directorate = directorate.replace(/[()]/g, m => chars[m]);
//     }

//     // Build filter array and encode it

//     //alert(division)

//     filter = [depart, division, directorate];

//     filter_data = encodeURIComponent(JSON.stringify(filter));
//   } else {
//     names = [access];
//     filter_data = '';
//   }

//   // === If user is head and didn't select specific departments, select all ===
//   if (is_head) {
//     if ((!names.length || names === undefined) &&
//         (start_date || end_date) &&
//         (!department.length || department === undefined)) {

//       let emp_dept = [];
//       $("#search_employee_department option").each(function () {
//         emp_dept.push(this.value);
//       });
//       department = emp_dept;
//     }
//   }

//   // === Only proceed if there is at least one filter ===
//   if (
//     (names && names.length > 0) ||
//     start_date ||
//     end_date ||
//     (department && department.length > 0)
//   ) {
//     // Names → all_data
//     names.forEach((name, index) => {
//       const flag = index === 0 ? 'i' : 'n';
//       all_data += ` ${name}${flag} `;
//     });

//     // Start Date
//     if (start_date) {
//       const new_start_date = dateFormat(start_date, 'yyyyMMdd');
//       all_data += ` ${new_start_date}s `;
//     }

//     // End Date
//     if (end_date) {
//       const new_end_date = dateFormat(end_date, 'yyyyMMdd');
//       all_data += ` ${new_end_date}e `;
//     }

//     // Department
//     if (department.length > 0) {
//       department.forEach((dept, index) => {
//         const flag = index === 0 ? '.' : ':';
//         const safe_dept = encodeURIComponent(dept.replace(/\s+/g, '~'));
//         all_data += ` ${safe_dept}${flag}@`;
//       });
//     }

//     // Final clean-up: remove leading/trailing spaces, replace spaces with `-`, then encode
//     // all_data = all_data.trim().replace(/\s+/g, '-');
//     all_data = all_data
//     .trim()
//     .replace(/\s+/g, '-')
//     .replace(/\(/g, '|-|')
//     .replace(/\)/g, '|_|');
//     all_data = encodeURIComponent(all_data); // Important to prevent URI character issues
    
//     // === Load DataTable with sanitized data ===
//     if ($.fn.DataTable.isDataTable('#table_attendance')) {
//       $('#table_attendance').DataTable().ajax.url(
//         `${base_url}/report/attendance_table/${company_code}/${all_data}/${filter_data}`
//       ).load();
//     }

//     // === Call attendance report function ===
//     if (is_head) {
//       loadAttendanceReport(all_data, filter, 'head');
//     } else {
//       loadAttendanceReport(all_data, filter);
//     }

//     // Disable end date input after search
//     $('#search_end_date').attr('disabled', true);
//   }
// });


$("#search_start_date").change(function () {
  var setDate;
  var date_range = compareDate("#search_start_date");
  if (date_range < 0) {
    setDate = date_range + "d";
  } else {
    setDate = "+" + date_range + "d";
  }
  $("#search_end_date").datepicker("setStartDate", setDate);
  $("#search_end_date").attr("disabled", false);
  if ($("#search_start_date").val() == "") {
    $("#search_end_date").val("").trigger("change");
    $("#search_end_date").attr("disabled", true);
  }
});

function compareDate(start_date) {
  var tgl1 = new Date($(start_date).val());
  var tgl2 = new Date();
  tgl2.setHours(0, 0, 0, 0);
  var jarak_time = Date.parse(tgl1) - Date.parse(tgl2);
  var jarak_tgl = jarak_time / 1000 / 60 / 60 / 24;

  return jarak_tgl;
}

$("#create_employee_calendar").click(function (e) {
  Swal.fire({
    title: "Are you sure?",
    text: "This will generate this year's Employee Calendar.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "report/createEmployeeCalendar",
        dataType: "json",
        beforeSend: function () {
          Swal.fire({
            position: "center",
            title: "Please Wait...",
            onBeforeOpen: () => {
              Swal.showLoading();
            },
            allowOutsideClick: false,
            allowEscapeKey: false
          });
        },
        success: function (response) {
          if (response == true) {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Jadwal setiap karyawan telah ditambahkan",
              showConfirmButton: false,
              timer: 1500,
            });
          } else if (response == "already_created") {
            Swal.fire({
              position: "center",
              icon: "warning",
              title: "Jadwal karyawan tahun ini sudah ada",
              showConfirmButton: false,
              timer: 5000,
            });
          }
        },
        error: function (response) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Jadwal karyawan tidak dapat ditambahkan",
            showConfirmButton: false,
            timer: 5000,
          });
        },
      });
    }
  });
});

$("#create_holiday_event").click(function (e) {
  var nama = $("#add_holiday_name").val();
  var start_date = $("#add_holiday_start_date").val();
  var end_date = $("#add_holiday_end_date").val();
  if (end_date == "") {
    end_date = start_date;
  }
  if ($("#add_holiday_ct").is(":checked")) {
    var kode = "CTB";
  } else {
    var kode = "DON";
  }

  if (nama == "" || nama === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama event tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (start_date == "" || start_date === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Tanggal event tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    type: "POST",
    url: "report/createHolidayEvent",
    dataType: "json",
    data: {
      nama: nama,
      start_date: start_date,
      end_date: end_date,
      kode: kode,
    },
    success: function (response) {
      Swal.fire({
        position: "center",
        icon: "success",
        title: "Event berhasil ditambahkan",
        showConfirmButton: false,
        timer: 1500,
      });
      var HE_date;
      if (end_date == start_date) {
        HE_date = start_date;
      } else {
        HE_date = [start_date, end_date];
      }
      $("#calendar").evoCalendar("addCalendarEvent", [
        {
          id: "new-" + nama + "-" + start_date,
          name: nama,
          date: HE_date,
          type: "holiday",
          color: "#7242f5",
        },
      ]);
    },
    error: function (response) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Event tidak dapat dibuat",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

$("#add_holiday_start_date").change(function () {
  var setDate;
  var date_range = compareDate("#add_holiday_start_date");
  if (date_range < 0) {
    setDate = date_range + "d";
  } else {
    setDate = "+" + date_range + "d";
  }
  $("#add_holiday_end_date").datepicker("setStartDate", setDate);
  $("#add_holiday_end_date").attr("disabled", false);
  if ($("#add_holiday_start_date").val() == "") {
    $("#add_holiday_end_date").val("").trigger("change");
    $("#add_holiday_end_date").attr("disabled", true);
  }
});

/////////////////////////////////////////////////// TIME MANAGEMENT 2.0 ///////////////////////////////////////////////////

$('#tm_report_status').change(function() {
  var status = $(this).children(":selected").val();
  var branch = $('#tm_report_branch').children(":selected").val();
  var balance = $('#tm_report_balance_type').children(":selected").val();
  if ($('#tm_report_employee').val() != ''){
    var employee = encodeURIComponent(JSON.stringify($('#tm_report_employee').val()));
  } else {
    var employee = '';
  }
  $('#table_tm_report').DataTable().ajax.url(base_url + '/report/tm_report_table/' + status + '-' + branch + '-' + balance + '-' + '/' + employee).load();
});

$('#tm_report_branch').change(function() {
  var status = $('#tm_report_status').children(":selected").val();
  var branch = $(this).children(":selected").val();
  var balance = $('#tm_report_balance_type').children(":selected").val();
  if ($('#tm_report_employee').val() != ''){
    var employee = encodeURIComponent(JSON.stringify($('#tm_report_employee').val()));
  } else {
    var employee = '';
  }
  $('#table_tm_report').DataTable().ajax.url(base_url + '/report/tm_report_table/' + status + '-' + branch + '-' + balance + '-' + '/' + employee).load();
});

$('#tm_report_balance_type').change(function() {
  var status = $('#tm_report_status').children(":selected").val();
  var branch = $('#tm_report_branch').children(":selected").val();
  var balance = $(this).children(":selected").val();
  if ($('#tm_report_employee').val() != ''){
    var employee = encodeURIComponent(JSON.stringify($('#tm_report_employee').val()));
  } else {
    var employee = '';
  }
  $('#table_tm_report').DataTable().ajax.url(base_url + '/report/tm_report_table/' + status + '-' + branch + '-' + balance + '-' + '/' + employee).load();
});

$('#tm_report_employee').change(function() {
  var status = $('#tm_report_status').children(":selected").val();
  var branch = $('#tm_report_branch').children(":selected").val();
  var balance = $('#tm_report_balance_type').children(":selected").val();
  if ($(this).val() != ''){
    var employee = encodeURIComponent(JSON.stringify($(this).val()));
  } else {
    var employee = '';
  }
  $('#table_tm_report').DataTable().ajax.url(base_url + '/report/tm_report_table/' + status + '-' + branch + '-' + balance + '-' + '/' + employee).load();
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$("#assign_schedule_action").change(function () {
  $("#modalAssignSchedule").find("input").val("").end();
  if ($(this).children(":selected").val() == "single") {
    $("#schedule_emp_name").attr("hidden", false);
    $("#schedule_type").attr("hidden", false);
    $("#current_schedule").attr("hidden", true);
    $("#branch").attr("hidden", true);
    $("#new_schedule").attr("hidden", true);
    $("#assign_work_schedule_single").attr("hidden", false);
    $("#assign_work_schedule_multi").attr("hidden", true);
  } else {
    var company = $("#assign_schedule_branch").val();
    $.ajax({
      type: "POST",
      url: "report/getWorkSchedule2/" + company,
      dataType: "json",
      success: function (response) {
        $("#assign_schedule_current").empty();
        $("#assign_schedule_new").empty();
        for (let x in response) {
          $("#assign_schedule_current").append(
            $("<option></option>")
              .attr("value", response[x].kode)
              .text(response[x].nama + " - " + response[x].kode)
          );
          $("#assign_schedule_new").append(
            $("<option></option>")
              .attr("value", response[x].kode)
              .text(response[x].nama + " - " + response[x].kode)
          );
        }
      },
    });
    $("#schedule_emp_name").attr("hidden", true);
    $("#schedule_type").attr("hidden", true);
    $("#current_schedule").attr("hidden", false);
    $("#new_schedule").attr("hidden", false);
    $("#branch").attr("hidden", false);
    $("#assign_work_schedule_single").attr("hidden", true);
    $("#assign_work_schedule_multi").attr("hidden", false);
  }
});

// Assign Work Schedule - Calendar Settings //
$("#assign_schedule_start_date").datepicker({
  daysOfWeekDisabled: "0,6",
  autoclose: true,
  todayHighlight: "TRUE",
});
$("#assign_schedule_end_date").datepicker({
  daysOfWeekDisabled: "0,6",
  autoclose: true,
  todayHighlight: "TRUE",
});
/////////////////////////////////////////////

$("#assign_schedule_start_date").change(function () {
  var setDate;
  var date_range = compareDate(this);
  if (date_range < 0) {
    setDate = date_range + "d";
  } else {
    setDate = "+" + date_range + "d";
  }
  $("#assign_schedule_end_date").datepicker("setStartDate", setDate);
  $("#assign_schedule_end_date").attr("disabled", false);
  if ($(this).val() == "") {
    $("#assign_schedule_end_date").val("").trigger("change");
    $("#assign_schedule_end_date").attr("disabled", true);
  }
});

$("#assign_schedule_employee_name").change(function () {
  var nik = $(this).children(":selected").val();
  if (nik == " ") {
    $("#assign_schedule_type").empty();
  } else {
    $.ajax({
      type: "POST",
      url: "report/getWorkSchedule/" + nik,
      dataType: "json",
      success: function (response) {
        $("#assign_schedule_type").empty();
        for (let x in response) {
          $("#assign_schedule_type").append(
            $("<option></option>")
              .attr("value", response[x].kode)
              .text(response[x].nama)
          );
        }
      },
    });
  }
});

$("#assign_work_schedule_single").click(function (e) {
  var emp_name = $("#assign_schedule_employee_name").val();
  var work_schedule = $("#assign_schedule_type").val();
  var ws_name = $("#assign_schedule_type :selected").text();
  var start_date = $("#assign_schedule_start_date").val();
  var end_date = $("#assign_schedule_end_date").val();

  if (emp_name == "" || emp_name === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Nama karyawan tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (
    start_date == "" ||
    start_date === undefined ||
    end_date == "" ||
    end_date === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Tanggal assignment tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (work_schedule == "" || work_schedule === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Work Schedule tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    type: "POST",
    url: "report/assignWorkSchedule",
    dataType: "json",
    data: {
      emp_name: emp_name,
      work_schedule: work_schedule,
      ws_name: ws_name,
      start_date: start_date,
      end_date: end_date,
    },
    success: function (response) {
      Swal.fire({
        position: "center",
        icon: "success",
        title: "Assignment Work Schedule karyawan berhasil",
        showConfirmButton: false,
        timer: 1500,
      });
      $("#modalAssignSchedule").find("input").val("").end();
    },
    error: function (response) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Assignment tidak dapat dilakukan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

$("#assign_schedule_branch").change(function (e) {
  var company = $("#assign_schedule_branch").val();
  $.ajax({
    type: "POST",
    url: "report/getWorkSchedule2/" + company,
    dataType: "json",
    success: function (response) {
      $("#assign_schedule_current").empty();
      $("#assign_schedule_new").empty();
      for (let x in response) {
        $("#assign_schedule_current").append(
          $("<option></option>")
            .attr("value", response[x].kode)
            .text(response[x].nama + " - " + response[x].kode)
        );
        $("#assign_schedule_new").append(
          $("<option></option>")
            .attr("value", response[x].kode)
            .text(response[x].nama + " - " + response[x].kode)
        );
      }
    },
  });
});

$("#assign_work_schedule_multi").click(function (e) {
  var branch = $("#assign_schedule_branch").val();
  var current_schedule = $("#assign_schedule_current").val();
  var new_schedule = $("#assign_schedule_new").val();
  var start_date = $("#assign_schedule_start_date").val();
  var end_date = $("#assign_schedule_end_date").val();

  if (current_schedule == new_schedule) {
    Swal.fire({
      position: "center",
      icon: "warning",
      title: "Tidak ada perubahan pada work schedule",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if (
    start_date == "" ||
    start_date === undefined ||
    end_date == "" ||
    end_date === undefined
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Tanggal assignment tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  $.ajax({
    type: "POST",
    url: "report/assignWorkScheduleMulti",
    dataType: "json",
    data: {
      branch: branch,
      current_schedule: current_schedule,
      new_schedule: new_schedule,
      start_date: start_date,
      end_date: end_date,
    },
    success: function (response) {
      if (response == true) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Assignment Work Schedule karyawan berhasil",
          showConfirmButton: false,
          timer: 1500,
        });
      } else if (response == "not_retrieved") {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Tidak ada karyawan dengan Work Schedule awal",
          showConfirmButton: false,
          timer: 1500,
        });
      }
      $("#modalAssignSchedule").find("input").val("").end();
    },
    error: function (response) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Assignment tidak dapat dilakukan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

$(".assign_work_schedule_pattern").click(function () {
  var pattern_file = $("#upload_schedule_file").val();

  if (pattern_file == "" || pattern_file === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Upload dokumen tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  var form_data = new FormData($("#form_pattern_shift")[0]);
  $.ajax({
    type: "POST",
    url: "report/save_upload_pattern",
    data: form_data,
    processData: false,
    contentType: false,
    beforeSend: function () {
      Swal.fire({
        position: "center",
        allowOutsideClick: false,
        title: "Please Wait...",
        onBeforeOpen: () => {
          Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false
      });
    },
    success: function (res) {
      var title = [
        "Ukuran file telah melebihi batas maksimum",
        "File hanya terupload separuh",
        "Direktori file tidak ditemukan",
        "Error saat menyimpan file",
        "Tipe file tidak sesuai",
        "Tidak dapat mengupload file",
      ];
      if (
        res == 0 ||
        res == 1 ||
        res == 2 ||
        res == 3 ||
        res == 4 ||
        res == 5
      ) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: title[res],
          showConfirmButton: false,
          timer: 2500,
        });
        return false;
      } else {
        var file_name = res;
        $.ajax({
          type: "POST",
          url: "report/assignShiftPattern",
          dataType: "json",
          data: { file_name: file_name },
          success: function (response) {
            if (response == true) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Upload Shift Pattern berhasil",
                showConfirmButton: false,
                timer: 1500,
              });
            } else if (response == "company_not_found") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "NIK tidak ditemukan! Pastikan NIK yang dimasukkan sudah benar",
                showConfirmButton: false,
                timer: 3000,
              });
            } else if (response == "schedule_not_found") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "Shift tidak ditemukan! Konfigurasi SHIFT terlebih dahulu",
                showConfirmButton: false,
                timer: 3000,
              });
            } else if (response == "no_file_exist") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "File tidak ditemukan! Silahkan upload file pattern kembali",
                showConfirmButton: false,
                timer: 3000,
              });
            }
            $("#modalUploadPattern").find("input").val("").end();
            $(".custom-file-label").text("Choose file");
          },
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Upload Shift Pattern tidak dapat dilakukan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

$("#modalBalanceLog").on("shown.bs.modal", function () {
  $(this).trigger("resize");
});

function company_select(company_code) {
  $("#attendance_company").val(company_code);
  if ($.fn.DataTable.isDataTable('#table_attendance')) {
    $("#table_attendance")
      .DataTable()
      .ajax.url(base_url + "/report/attendance_table/" + company_code)
      .load();
  }
  loadAttendanceReport();
}

function detail_balance_log(nik, nama) {
  $("#nama_detail_log h4").html(nama);
  $("#table_detail_balance_log")
    .DataTable()
    .ajax.url(base_url + "/form/balance_log_table/" + nik)
    .load();
}

$("#modalDetailBalance").on("shown.bs.modal", function () {
  $(this).trigger("resize");
});

// TIME MANAGEMENT 2.0
function edit_employee_attend(edit_TM_time_off) {
  var id = document.getElementById(edit_TM_time_off).getAttribute("id");
  var url = 'report/getEditEmpAtd/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      var id = response[0].id;
      var nik = response[0].employee_id;
      var nama = response[0].full_name;
      var date =  dateFormat(response[0].date, 'MM/dd/yyyy');
      var schedule = response[0].dws;
      var check_in = response[0].check_in;
      var check_out = response[0].check_out;
      var check_in_location = response[0].check_in_location;
      var check_out_location = response[0].check_out_location;
      var attendance_code = response[0].attendence_code;
      var time_off_code = response[0].time_off_code;
      var notes = response[0].note;

      $.ajax({
        type: 'POST',
        url: 'report/getTO/' + nik, 
        dataType: 'json', 
        success: function (response) {
          if (time_off_code == '' || time_off_code == null){
            $('#to_code_emp_atd').empty().append($('<option></option>').attr('value', 'empty').text(''));
          } else {
            $('#to_code_emp_atd').empty().append($('<option></option>').attr('value', time_off_code).text(time_off_code));
            $('#to_code_emp_atd').append($('<option></option>').attr('value', 'empty').text(''));
          }
          for (let x in response){
            if (response[x].kode != time_off_code){
              $('#to_code_emp_atd').append($('<option></option>').attr('value', response[x].kode).text(response[x].kode + ' - ' + response[x].nama));
            } else {
              continue;
            }
          }
        }
      });
      
      $.ajax({
        type: 'POST',
        url: 'report/getLocation/' + nik + '/' + response[0].date, 
        dataType: 'json', 
        success: function (response) {
          if (check_in_location == '' || check_in_location == null){
            $('#clock_in_loc_emp_atd').empty().append($('<option></option>').attr('value', 'empty').text(''));
            $('#clock_out_loc_emp_atd').empty().append($('<option></option>').attr('value', 'empty').text(''));
          } else {
            $('#clock_in_loc_emp_atd').empty().append($('<option></option>').attr('value', 'same').text(check_in_location));
            $('#clock_out_loc_emp_atd').empty().append($('<option></option>').attr('value', 'same').text(check_out_location));
            $('#clock_in_loc_emp_atd').append($('<option></option>').attr('value', 'empty').text(''));
            $('#clock_out_loc_emp_atd').append($('<option></option>').attr('value', 'empty').text(''));
          }
          for (let x in response){
            $('#clock_in_loc_emp_atd').append($('<option></option>').attr('value', response[x].id).text(response[x].address));
            $('#clock_out_loc_emp_atd').append($('<option></option>').attr('value', response[x].id).text(response[x].address));
          }
        }
      });


      $("#id_edit_emp_atd").val(id);
      $("#nik_edit_emp_atd").val(nik);
      $("#nama_edit_emp_atd").val(nama);
      $("#date_edit_emp_atd").val(date);
      $("#schedule_edit_emp_atd").val(schedule);
      $("#clock_in_emp_atd").val(check_in);
      $("#clock_out_emp_atd").val(check_out);

      $("div.atd_code select").val(attendance_code).change();
      // $("#to_code_atd").val(time_off_code);
      // $("div.to_code select").val(time_off_code).change();
      $("#notes_edit_emp_atd").val(notes);
      
    }
  });
}

$('.ubah_emp_atd').click(function () {

  var id = $("#id_edit_emp_atd").val();
  var company_code = $('#attendance_company').val();
  var check_in = $("#clock_in_emp_atd").val();
  var check_out = $("#clock_out_emp_atd").val();
  var check_in_location = $("#clock_in_loc_emp_atd").val();
  var check_out_location = $("#clock_out_loc_emp_atd").val();

  if ($("#atd_code_emp_atd").val() == 'empty'){
    var attendance_code = '';
  } else {
    var attendance_code = $("#atd_code_emp_atd").val();
  }
  if ($("#to_code_emp_atd").val() == 'empty'){
    var time_off_code = '';
  } else {
    var time_off_code = $("#to_code_emp_atd").val();
  }
  
  var notes = $("#notes_edit_emp_atd").val();
  var url = "report/ubah_emp_atd";

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, check_in: check_in, check_out: check_out, check_in_location: check_in_location, check_out_location: check_out_location, attendance_code: attendance_code, time_off_code: time_off_code, notes: notes },
    success: function (data) {
      if (data == true) {
        var start_date = $("#search_start_date").val();
        var end_date = $("#search_end_date").val();
        var names = $("#search_employee_names").val();

        if (names != '' || start_date != '' || end_date != ''){
          $(".advance_search" ).trigger( "click" );
        } else {
          if ($.fn.DataTable.isDataTable('#table_attendance')) {
            $('#table_attendance').DataTable().ajax.url(base_url + '/report/attendance_table/' + company_code).load();
          }
        }
        
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      if ($.fn.DataTable.isDataTable('#table_attendance')) {
        $('#table_attendance').DataTable().ajax.url(base_url + '/report/attendance_table/' + company_code).load();
      }
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

$('.tambah_office').click(function () {
  var nama = $("#nama_tambah_office").val();
  var kode = $("#kode_tambah_office").val();
  var start_date = $("#start_date_tambah_office").val();
  var end_date = $("#end_date_tambah_office").val();
  var alamat = $("#alamat_tambah_office").val();
  var lat = $("#lat_tambah_office").val();
  var long = $("#long_tambah_office").val();
  var radius = $("#radius_tambah_office").val();
  var url = "master/tambah_office";
  //alert(start_date);
  if ((nama == "") || (nama === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Personnel Area tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((kode == "") || (kode === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Kode PA tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ( start_date == "" || start_date === undefined || end_date == "" || end_date === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if ((alamat == "") || (alamat === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Alamat tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((lat == "") || (lat === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Lattitude tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((long == "") || (long === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Longitude tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((radius == "") || (radius === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Radius tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { nama: nama, kode: kode, start_date: start_date, end_date: end_date, alamat: alamat, lat: lat, long: long, radius: radius },
    success: function (data) {
      $('#table_office').DataTable().ajax.reload();
      if (data == true) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
        $('#modalTambahOffice').find("input,textarea").val('').end();
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat ditambahkan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_office').DataTable().ajax.reload();
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

function edit_office(edit_TM_office) {
  var id = document.getElementById(edit_TM_office).getAttribute("id");
  var url = 'master/getEditOffice/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      var id = response[0].id;
      var nama = response[0].personnel_area;
      var kode = response[0].pa_code;
      var start_date = response[0].start_date;
      var end_date = response[0].end_date;
      var alamat = response[0].address;
      var lat = response[0].lattitude;
      var long = response[0].longitude;
      var radius = response[0].radius;

      $("#id_edit_office").val(id);
      $("#nama_edit_office").val(nama);
      $("#kode_edit_office").val(kode);
      $("#start_date_edit_office").val(start_date);
      $("#end_date_edit_office").val(end_date);
      $("#alamat_edit_office").val(alamat);
      $("#lat_edit_office").val(lat);
      $("#long_edit_office").val(long);
      $("#radius_edit_office").val(radius);
    }
  });
}

$('.ubah_office').click(function () {

  var id = $("#id_edit_office").val();
  var nama = $("#nama_edit_office").val();
  var kode = $("#kode_edit_office").val();
  var start_date = $("#start_date_edit_office").val();
  var end_date = $("#end_date_edit_office").val();
  var alamat = $("#alamat_edit_office").val();
  var lat = $("#lat_edit_office").val();
  var long = $("#long_edit_office").val();
  var radius = $("#radius_edit_office").val();
  var url = "master/ubah_office";

  if ((nama == "") || (nama === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Personnel Area tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((kode == "") || (kode === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Kode PA tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ( start_date == "" || start_date === undefined || end_date == "" || end_date === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if ((alamat == "") || (alamat === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Alamat tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((lat == "") || (lat === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Lattitude tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((long == "") || (long === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Longitude tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((radius == "") || (radius === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Radius tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, nama: nama, kode: kode, start_date: start_date, end_date: end_date, alamat: alamat, lat: lat, long: long, radius: radius },
    success: function (data) {
      $('#table_office').DataTable().ajax.reload();
      if (data == true) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_office').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_office(DeleteOffice) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Data tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {
      var id = document.getElementById(DeleteOffice).getAttribute("id");
      var url = 'master/getDeleteOffice/';
      $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#table_office').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'success',
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

$('#tm_report_head_employee').change(function() {
  var department = encodeURIComponent(JSON.stringify($('#tm_report_head_department').val()));
  var employee = encodeURIComponent(JSON.stringify($(this).val()));
  $('#table_tm_report_head').DataTable().ajax.url(base_url + '/report/tm_report_table_head/' + department + '/' + employee).load();
});

$('#tm_report_head_department').change(function() {
  var department = encodeURIComponent(JSON.stringify($(this).val()));
  var employee = encodeURIComponent(JSON.stringify($('#tm_report_head_employee').val()));
  $('#table_tm_report_head').DataTable().ajax.url(base_url + '/report/tm_report_table_head/' + department + '/' + employee).load();
});

// START CR: AFTER TM 2.0
$('#employee_tambah_relokasi').change(function() {
  var nik = $('#employee_tambah_relokasi').find(":selected").val();
  var nama = $('#employee_tambah_relokasi').find(":selected").text();
  
  $('#nik_tambah_relokasi').val(nik);
  $('#nama_tambah_relokasi').val(nama.slice(11));

  $.ajax({
    type: "POST",
    url: "master/getEmpPA",
    dataType: "json",
    data: { nik: nik },
    success: function (response) {
      $("#pa_awal_tambah_relokasi").val(response);
    },
  });
});

function edit_relokasi(edit_TM_reloc) {
  var id = document.getElementById(edit_TM_reloc).getAttribute("id");
  var url = 'master/getEditReloc/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      var id = response[0].id;
      var nik = response[0].nik;
      var name = response[0].full_name;
      var start_date = dateFormat(response[0].start_date, "MM/dd/yyyy");
      var end_date = dateFormat(response[0].end_date, "MM/dd/yyyy");
      var pa_awal = response[0].pa_awal;
      var pa_akhir = response[0].pa_akhir;

      $("#id_edit_relokasi").val(id);
      $("#nik_edit_relokasi").val(nik);
      $("#nama_edit_relokasi").val(name);
      $("#start_date_edit_relokasi").val(start_date);
      $("#end_date_edit_relokasi").val(end_date);
      $("#pa_awal_edit_relokasi").val(pa_awal);
      
      $.ajax({
        type: "POST",
        url: "master/getRelocationLocation",
        dataType: "json",
        success: function (response) {
          $('#pa_akhir_edit_relokasi').empty().append($('<option></option>').attr('value', pa_akhir).text(pa_akhir));
          for (let x in response){
            if (response[x].personnel_area != pa_akhir){
              $('#pa_akhir_edit_relokasi').append($('<option></option>').attr('value', response[x].personnel_area).text(response[x].personnel_area));
            } else {
              continue;
            }
          }
        },
      });
    }
  });
}

$('.ubah_relokasi').click(function () {

  var id = $("#id_edit_relokasi").val();
  var nik = $("#nik_edit_relokasi").val();
  var nama = $("#nama_edit_relokasi").val();
  var start_date = $("#start_date_edit_relokasi").val();
  var end_date = $("#end_date_edit_relokasi").val();
  var pa_awal = $("#pa_awal_edit_relokasi").val();
  var pa_akhir = $("#pa_akhir_edit_relokasi").val();
  var url = "master/ubah_relokasi";

  if ( start_date == "" || start_date === undefined || end_date == "" || end_date === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if ((pa_awal == "") || (pa_awal === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Personnel Area Asal tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pa_akhir == "") || (pa_akhir === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Personnel Area Tujuan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { id: id, nama: nama, nik: nik, start_date: start_date, end_date: end_date, pa_awal: pa_awal, pa_akhir: pa_akhir },
    success: function (data) {
      console.log(data);
      $('#table_relocation').DataTable().ajax.reload();
      if (data) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data telah diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat diperbaharui',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_relocation').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Data tidak dapat diperbaharui',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function delete_relokasi(DeleteReloc) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Data tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {
      var id = document.getElementById(DeleteReloc).getAttribute("id");
      var url = 'master/getDeleteReloc/';
      $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#table_relocation').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'success',
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

$('.tambah_relokasi').click(function () {

  var nik = $("#nik_tambah_relokasi").val();
  var nama = $("#nama_tambah_relokasi").val();
  var start_date = $("#start_date_tambah_relokasi").val();
  var end_date = $("#end_date_tambah_relokasi").val();
  var pa_awal = $("#pa_awal_tambah_relokasi").val();
  var pa_akhir = $("#pa_akhir_tambah_relokasi").val();
  var url = "master/tambah_relokasi";

  if ( start_date == "" || start_date === undefined || end_date == "" || end_date === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Periode tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  } else if ((pa_awal == "") || (pa_awal === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Personnel Area Asal tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  } else if ((pa_akhir == "") || (pa_akhir === undefined)) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Personnel Area Tujuan tidak boleh kosong',
      showConfirmButton: false,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: url,
    dataType: 'json',
    type: 'POST',
    data: { nama: nama, nik: nik, start_date: start_date, end_date: end_date, pa_awal: pa_awal, pa_akhir: pa_akhir },
    success: function (data) {
      console.log(data);
      if (data) {
        $('#table_reloc_req').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Request berhasil diajukan',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Request tidak dapat diajukan',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function (data) {
      $('#table_reloc_req').DataTable().ajax.reload();
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Request tidak dapat ditambahkan',
        showConfirmButton: false,
        timer: 1500
      });
    }
  });
});

function detail_approval_reloc(request_id) {
  window.location.href = "master/detail_approval/relokasi/" + request_id;
}

function responseRequestReloc(type) { 
    
  var id = $('#request_id').val(); 
  
  if(type == 'Reject'){

  var url = 'inbox/cekNote/TM'
  $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data: { id : id },
      success: function (data) {
        if (data == true) {
          
          const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                  confirmButton: 'btn btn-primary',
                  cancelButton: 'btn btn-light'
              },
              buttonsStyling: false
          })
      
          swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              //text: "Revise this request",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, sure.',
              cancelButtonText: 'Cancel.',
              reverseButtons: true,
              allowOutsideClick: false
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      url: "inbox/responseRequestRelokasi",
                      type: 'post',
                      data: 'id=' + id + '&resp=' + type,
                      dataType: 'json',
                      beforeSend: function () {
                        Swal.fire({
                          position: "center",
                          title: "Please Wait...",
                          onBeforeOpen: () => {
                            Swal.showLoading();
                          },
                          allowOutsideClick: false,
                          allowEscapeKey: false
                        });
                      },
                      success: function (response) {
      
                          if (response.status == 1) {
      
                              window.location.href = 'inbox/approval_TM_ztm';
                              swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success')
      
                          } else {
                              swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
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

        }else{

          Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Dimohon untuk mengisi note',
              showConfirmButton: false,
              timer: 1500
            });

        }
      },
      error: function (data) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat diproses',
          showConfirmButton: false,
          timer: 1500
        });
      }
  });

  }else{
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        //text: "Revise this request",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure.',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "inbox/responseRequestRelokasi",
                type: 'post',
                data: 'id=' + id + '&resp=' + type,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 1) {

                        window.location.href = 'inbox/approval_TM_ztm';
                        swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success')

                    } else {
                        swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
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
// END CR: AFTER TM 2.0

// START CR 2 TM
function detail_shift_schedule(nik, nama) {
  $("#nama_detail_schedule").html(nama);
  $("#detail_schedule_nik").val(nik);
  $("#table_detail_shift_schedule")
    .DataTable()
    .ajax.url(base_url + "/master/detail_employee_shift_schedule/" + nik)
    .load();
}

$("#modalDetailSchedule").on("shown.bs.modal", function () {
  $(this).trigger("resize");
  change_shift_detail();
});

function change_shift_detail(){
  var nik = $("#detail_schedule_nik").val();
  var month = $("#detail_schedule_month").val();
  var year = $("#detail_schedule_year").val();
  var date = year.concat("-", month);
  $("#table_detail_shift_schedule")
    .DataTable()
    .ajax.url(base_url + "/master/detail_employee_shift_schedule/" + nik + "/" + date)
    .load();
}
$("#detail_schedule_month").change(function () {
  change_shift_detail();
});

$("#detail_schedule_year").change(function () {
  change_shift_detail();
});

$('.assign_shift_schedule_pattern').click(function () {
  var month_name = $("#upload_shift_schedule_month option:selected").text();
  var month = $("#upload_shift_schedule_month option:selected").val();
  var year = $("#upload_shift_schedule_year option:selected").val();
  var pattern_file = $("#upload_schedule_file").val();

  if (pattern_file == "" || pattern_file === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Upload dokumen tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  var form_data = new FormData($("#form_pattern_shift")[0]);
  $.ajax({
    type: "POST",
    url: "report/save_upload_pattern",
    data: form_data,
    processData: false,
    contentType: false,
    beforeSend: function () {
      Swal.fire({
        position: "center",
        title: "Please Wait...",
        onBeforeOpen: () => {
          Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false
      });
    },
    success: function (res) {
      var title = [
        "Ukuran file telah melebihi batas maksimum",
        "File hanya terupload separuh",
        "Direktori file tidak ditemukan",
        "Error saat menyimpan file",
        "Tipe file tidak sesuai",
        "Tidak dapat mengupload file",
      ];
      if (
        res == 0 ||
        res == 1 ||
        res == 2 ||
        res == 3 ||
        res == 4 ||
        res == 5
      ) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: title[res],
          showConfirmButton: false,
          timer: 2500,
        });
        return false;
      } else {
        var file_name = res;
        $.ajax({
          type: "POST",
          url: "master/requestShiftPattern",
          dataType: "json",
          data: { file_name: file_name, month_name: month_name, month: month, year: year },
          success: function (response) {
            if (response == true) {
              $("#table_upload_shift").DataTable().ajax.reload();
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Upload Shift Pattern berhasil",
                showConfirmButton: false,
                timer: 1500,
              });
            } else if (response == "company_not_found") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "NIK tidak ditemukan! Pastikan NIK yang dimasukkan sudah benar",
                showConfirmButton: false,
                timer: 3000,
              });
            } else if (response == "schedule_not_found") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "Shift tidak ditemukan! Konfigurasi SHIFT terlebih dahulu",
                showConfirmButton: false,
                timer: 3000,
              });
            } else if (response == "no_file_exist") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "File tidak ditemukan! Silahkan upload file pattern kembali",
                showConfirmButton: false,
                timer: 3000,
              });
            }
            $("#modalUploadShift").find("input").val("").end();
            $(".custom-file-label").text("Choose file");
          },
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Upload Shift Pattern tidak dapat dilakukan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

function detail_approval_shift_schedule(request_id) {
  window.location.href = "master/detail_approval/shift/" + request_id;
}

function delete_request_shift_schedule(DeleteShiftReq) {
  Swal.fire({
    title: "Are you sure?",
    text: "Data tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete",
  }).then((result) => {
    if (result.isConfirmed) {
      var id = document.getElementById(DeleteShiftReq).getAttribute("id");
      var url = "master/getDeleteShiftReq/";
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $("#table_upload_shift").DataTable().ajax.reload();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Request berhasil dibatalkan",
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Request tidak dapat dibatalkan",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        },
        error: function (data) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Request tidak dapat dibatalkan",
            showConfirmButton: false,
            timer: 1500,
          });
        },
      });
    }
  });
}

$("#btn_save_shift_sch").click(function () {
  var request_id = $("#id_request").val();
  var pattern_file = $("#upload_schedule_file").val();

  if (pattern_file == "" || pattern_file === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Upload dokumen tidak boleh kosong",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  var form_data = new FormData($("#form_pattern_shift")[0]);
  $.ajax({
    type: "POST",
    url: "report/save_upload_pattern",
    data: form_data,
    processData: false,
    contentType: false,
    beforeSend: function () {
      Swal.fire({
        position: "center",
        title: "Please Wait...",
        onBeforeOpen: () => {
          Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false
      });
    },
    success: function (res) {
      var title = [
        "Ukuran file telah melebihi batas maksimum",
        "File hanya terupload separuh",
        "Direktori file tidak ditemukan",
        "Error saat menyimpan file",
        "Tipe file tidak sesuai",
        "Tidak dapat mengupload file",
      ];
      if (
        res == 0 ||
        res == 1 ||
        res == 2 ||
        res == 3 ||
        res == 4 ||
        res == 5
      ) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: title[res],
          showConfirmButton: false,
          timer: 2500,
        });
        return false;
      } else {
        var file_name = res;
        $.ajax({
          type: "POST",
          url: "master/newShiftPattern",
          dataType: "json",
          data: { request_id: request_id, file_name: file_name },
          success: function (response) {
            if (response == true) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Upload Shift Pattern berhasil",
                showConfirmButton: false,
                timer: 1500,
              });
              $("#document-shift").load(location.href + " #document-shift");
            } else if (response == "company_not_found") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "NIK tidak ditemukan! Pastikan NIK yang dimasukkan sudah benar",
                showConfirmButton: false,
                timer: 3000,
              });
            } else if (response == "schedule_not_found") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "Shift tidak ditemukan! Konfigurasi SHIFT terlebih dahulu",
                showConfirmButton: false,
                timer: 3000,
              });
            } else if (response == "no_file_exist") {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "File tidak ditemukan! Silahkan upload file pattern kembali",
                showConfirmButton: false,
                timer: 3000,
              });
            }
            
            $(".custom-file-label").text("Choose file");
          },
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Upload Shift Pattern tidak dapat dilakukan",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

function responseRequestShift(type) { 
    
  var id = $('#request_id').val(); 
  
  var pattern_file = $("#upload_schedule_file").val();
  if(type == 'Resubmitted'){
    if (pattern_file == "" || pattern_file === undefined) {
      Swal.fire({
        position: "center",
        icon: "info",
        title: "Upload dokumen<br>EMPLOYEE SHIFT SCHEDULE<br>silahkan upload dokumen SHIFT dan klik tombol SAVE",
        showConfirmButton: true,
        // timer: 1500,
      });
      return false;
    }
  }

  if(type == 'Reject' || type == 'Revised' || type == 'RevisedHR'){

  var url = 'inbox/cekNote/TM'
  $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data: { id : id },
      success: function (data) {
        if (data == true) {
          
          const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                  confirmButton: 'btn btn-primary',
                  cancelButton: 'btn btn-light'
              },
              buttonsStyling: false
          })
      
          swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              //text: "Revise this request",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, sure.',
              cancelButtonText: 'Cancel.',
              reverseButtons: true,
              allowOutsideClick: false
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      url: "inbox/responseRequestShift",
                      type: 'post',
                      data: 'id=' + id + '&resp=' + type,
                      dataType: 'json',
                      beforeSend: function () {
                        Swal.fire({
                          position: "center",
                          title: "Please Wait...",
                          onBeforeOpen: () => {
                            Swal.showLoading();
                          },
                          allowOutsideClick: false,
                          allowEscapeKey: false
                        });
                      },
                      success: function (response) {
      
                          if (response.status == 1) {
      
                              window.location.href = 'inbox/approval_TM_ztm';
                              swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success')
      
                          } else {
                              swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
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

        }else{

          Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Dimohon untuk mengisi note',
              showConfirmButton: false,
              timer: 1500
            });

        }
      },
      error: function (data) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Data tidak dapat diproses',
          showConfirmButton: false,
          timer: 1500
        });
      }
  });

  }else{
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        //text: "Revise this request",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure.',
        cancelButtonText: 'Cancel.',
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "inbox/responseRequestShift",
                type: 'post',
                data: 'id=' + id + '&resp=' + type,
                dataType: 'json',
                beforeSend: function () {
                  Swal.fire({
                    position: "center",
                    title: "Please Wait...",
                    onBeforeOpen: () => {
                      Swal.showLoading();
                    },
                    allowOutsideClick: false,
                    allowEscapeKey: false
                  });
                },
                success: function (response) {

                    if (response.status == 1) {

                        if (type != 'Resubmitted'){
                            window.location.href = 'inbox/approval_TM_ztm';
                        } else {
                            window.location.href = 'master/shifting_menu';
                        }
                        swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success')

                    } else {
                        swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
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
// END CR 2 TM

// START CR 3 TM
function req_emp_loc(emp_tm_loc, flag) {
  var id = document.getElementById(emp_tm_loc).getAttribute("id");
  var url = 'report/getEditEmpAtd/';
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
      var date =  dateFormat(response[0].date, 'MM/dd/yyyy');

      $("#modalRequestLocation").find("input").val("").end();
      $(".custom-file-label").text("Choose file");

      $("#date_req_loc").val(date);
      if (flag == 0){
        $("#req_loc_in_upload_file").prop("disabled", true);
        $("#req_loc_out_upload_file").prop("disabled", false);

        $("#req_loc_in").val(0);
        $("#req_loc_out").val(1);
      } else if (flag == 1){
        $("#req_loc_in_upload_file").prop("disabled", false);
        $("#req_loc_out_upload_file").prop("disabled", true);

        $("#req_loc_in").val(1);
        $("#req_loc_out").val(0);
      } else {
        $("#req_loc_in_upload_file").prop("disabled", false);
        $("#req_loc_out_upload_file").prop("disabled", false);

        $("#req_loc_in").val(1);
        $("#req_loc_out").val(1);
      }
    }
  });
}

$(document).ready(function () {
  var status = $('#tm_report_status').children(":selected").val();
  // var branch = $('#tm_report_branch').children(":selected").val();
  var branch = $('#company_code').val();
  var balance = $('#tm_report_balance_type').children(":selected").val();
  
  if ($('#tm_report_employee').val() != ''){
    var employee = encodeURIComponent(JSON.stringify($('#tm_report_employee').val()));
  } else {
    var employee = '';
  }
  $('#table_tm_report').DataTable().ajax.url(base_url + '/report/tm_report_table/' + status + '-' + branch + '-' + balance + '-' + '/' + employee).load();
});

function delete_request_reloc(DeleteReloc) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Data tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {
      var id = document.getElementById(DeleteReloc).getAttribute("id");
      var url = 'master/getDeleteReqReloc/';
      $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: { id: id },
        success: function (data) {
          if (data == true) {
            $('#table_reloc_req').DataTable().ajax.reload();
            Swal.fire({
              position: 'center',
              icon: 'success',
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


NioApp.DataTable(".arv-table", {
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
  bPaginate: false,
  bFilter: false
});

function inputCountVDD() {
  var display = document.getElementById("counter_VDD");
  var sisa = 255 - $("#vdd").val().length;
  display.innerHTML = sisa + "/255";
}

$(".add_versions").click(function () {
  var versions_numbers  = $("#versions_numbers").val();
  var operating_system  = $("#operating_system").val();
  var vdd               = $("#vdd").val();
  var app_file          = $("#upload_application").val();

  if (versions_numbers == "" || versions_numbers === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Versions numbers must be filled",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (vdd == "" || vdd === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Version Description Document must be filled",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  if (app_file == "" || app_file === undefined) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "File Application must be filled",
      showConfirmButton: false,
      timer: 1500,
    });
    return false;
  }

  var form_data = new FormData($("#AddVersions")[0]);
  $.ajax({
    type: "POST",
    url: "master/Arv/save_file_application_versions",
    data: form_data,
    processData: false,
    contentType: false,
    beforeSend: function () {
      Swal.fire({
        position: "center",
        allowOutsideClick: false,
        title: "Please Wait...",
        onBeforeOpen: () => {
          Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false
      });
    },
    success: function (res) {
      var title = [
        "The file size has exceeded the maximum limit",
        "File only half uploaded",
        "File directory not found",
        "Error while saving the file",
        "File type does not match",
        "Unable to upload file",
      ];
      if (
        res == 0 ||
        res == 1 ||
        res == 2 ||
        res == 3 ||
        res == 4 ||
        res == 5
      ) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: title[res],
          showConfirmButton: false,
          timer: 2500,
        });
        return false;
      } else {
        var file_name = res;
        $.ajax({
          type: "POST",
          url: "master/Arv/save_application_versions",
          dataType: "json",
          data: { file_name: file_name, versions_numbers: versions_numbers, operating_system : operating_system, vdd: vdd},
          success: function (response) {
            if (response == true) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Application Version Updated",
                showConfirmButton: false,
                timer: 3500,
              });
              $(".arv-table").DataTable().ajax.reload();
            } else {
              Swal.fire({
                position: "center",
                icon: "error",
                title:
                  "Application Version can't updated",
                showConfirmButton: false,
                timer: 3000,
              });
            }
            
          },
        });
      }
    },
    error: function (data) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "Application Version can't updated",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
});

function delete_apps_version(id, file) {
  Swal.fire({
    title: "Are you sure?",
    text: "Data cannot be restored!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete",
  }).then((result) => {
    if (result.isConfirmed) {
      var url = "master/Arv/DeleteARV";
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { id: id, file: file },
        success: function (data) {
          if (data == true) {
            $(".arv-table").DataTable().ajax.reload();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Data has been deleted",
              showConfirmButton: false,
              timer: 2500,
            });
          } else {
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Data cannot be deleted",
              showConfirmButton: false,
              timer: 2500,
            });
          }
        },
        error: function (data) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Data cannot be deleted",
            showConfirmButton: false,
            timer: 2500,
          });
        },
      });
    }
  });
}
// END CR 3 TM

////////Start Menambahkan modul info 2025///////////////
function inputCountInfo() {
  var display = document.getElementById("counter_info");
  var sisa = 150 - $("#c_info").val().length;
  display.innerHTML = sisa + "/150";
}

NioApp.DataTable(".info-table", {
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
  bPaginate: false,
  bFilter: false
});

////////End Menambahkan modul info 2025///////////////



  $(document).ready(function() {
    // Inisialisasi DataTables

    let balanceTable = $('#balanceMDCRTable').DataTable({
        scrollX: true,
        ordering: false,
        searching: false,
        autoWidth: true,
        pagingType: 'full_numbers',
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "/master/get_balance_mdcr",
            type: "POST",
            data: function (d) {
                d.nik   = $('#nik').val();
                d.year  = $('#year').val();
                d.month = $('#month').val();
            }
        },
        dom:
          "<'row'<'col-12 col-md-6'B><'col-12 col-md-6'f>>" +
          "<'row'<'col-12'tr>>" +
          "<'row mt-2'<'col-12 col-md-5'l><'col-12 col-md-7 d-flex justify-content-md-end'p>>" +
          "<'row'<'col-12'i>>",
        buttons: [
            {
                extend: 'colvis',
                className: 'btn btn-outline-secondary'
            },
            {
                extend: 'excel',
                className: 'btn btn-outline-success'
            }
        ]
        // columnDefs: [
        //   { 'visible': false, 'targets': [0] }
        // ],
    });


    let detailTable = $('#detailMDCRTable').DataTable({
        scrollX: true,
        ordering: true,
        searching: false,
        autoWidth: true,
        pagingType: 'full_numbers',
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "/master/get_detail_balance_mdcr",
            type: "POST",
            data: function (e) {
                e.nik   = $('#nik').val();
                e.year  = $('#year').val();
                e.month = $('#month').val();
            }
        },
        dom:
          "<'row'<'col-12 col-md-6'B><'col-12 col-md-6'f>>" +
          "<'row'<'col-12'tr>>" +
          "<'row mt-2'<'col-12 col-md-5'l><'col-12 col-md-7 d-flex justify-content-md-end'p>>" +
          "<'row'<'col-12'i>>",
        buttons: [
            {
                extend: 'colvis',
                className: 'btn btn-outline-secondary'
            },
            {
                extend: 'excel',
                className: 'btn btn-outline-success'
            }
        ]
        // columnDefs: [
        //   { 'visible': false, 'targets': [0] }
        // ],
    });
    
    window.applyFilter = function() {
        // const nik = $('#nik').val();
        // const month = $('#month').val();
        const year = $('#year').val();

        if (year == "" || year === undefined) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Please select a year",
            showConfirmButton: false,
            timer: 1500,
          });
          return false;
        }else{
          balanceTable.ajax.reload();
          detailTable.ajax.reload();
        }
    }

    if (window.location.pathname === "/report/medical_claim_and_balance") {

        // Pasang event filter input
        $('#nik, #month, #year').on('change', applyFilter);
        balanceTable.ajax.reload();
        detailTable.ajax.reload();

        // Toggle table radio
        function toggleTable() {
            const type = $('input[name="reportType"]:checked').val();

            if(type === 'balance') {
                $('#balanceMDCRTable').closest('.dataTables_wrapper').show();
                $('#detailMDCRTable').closest('.dataTables_wrapper').hide();
                balanceTable.columns.adjust().draw();
                $('#div-exp-balance').show();
                $('#div-exp-detail').hide();
            } else {
                $('#balanceMDCRTable').closest('.dataTables_wrapper').hide();
                $('#detailMDCRTable').closest('.dataTables_wrapper').show();
                detailTable.columns.adjust().draw();
                $('#div-exp-balance').hide();
                $('#div-exp-detail').show();
            }
        }

        $('input[name="reportType"]').on('change', toggleTable);
        toggleTable();

        $('.select-search_employee_balance').select2({
        });

        $('.select-search_month_balance').select2({
        });

        $('.select-search_employee_balance').trigger("reset");

        var getEmployeeToBalance = "master/getEmployeeToBalance";
          $.ajax({
            url: getEmployeeToBalance,
            dataType: 'json',
            type: 'POST',
            data: {},
            success: function (data) {
              $('.select-search_employee_balance').html(data);
            }
        });
    }

});

// console.log('CLICK');

$('#export_report_mdcr_balance').on('click', function () {

    Swal.fire({
        icon: 'info',
        title: 'Export Medical Claim Balance',
        html: 'Click OK to continue',
        showCancelButton: true,
        confirmButtonText: 'OK'
    }).then((result) => {

        if (result.isConfirmed) {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            });

            const url = base_url + "/master/export_report_mdcr_balance_csv"
                + "?nik="   + encodeURIComponent($('#nik').val())
                + "&year="  + encodeURIComponent($('#year').val())
                + "&month=" + encodeURIComponent($('#month').val());

            // 🔥 DOWNLOAD TANPA PINDAH HALAMAN
            $('#downloadFrame').attr('src', url);

            setTimeout(() => {
                Swal.close();
            }, 1500);
        }
    });
});

$('#export_report_mdcr_detail').on('click', function () {

    Swal.fire({
        icon: 'info',
        title: 'Export Medical Claim Detail',
        html: 'Click OK to continue',
        showCancelButton: true,
        confirmButtonText: 'OK'
    }).then((result) => {

        if (result.isConfirmed) {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            });

            const url = base_url + "/master/export_report_mdcr_detail_csv"
                + "?nik="   + encodeURIComponent($('#nik').val())
                + "&year="  + encodeURIComponent($('#year').val())
                + "&month=" + encodeURIComponent($('#month').val());

            // 🔥 DOWNLOAD TANPA PINDAH HALAMAN
            $('#downloadFrame').attr('src', url);

            setTimeout(() => {
                Swal.close();
            }, 1500);
        }
    });
});


$('#export_detail').click(function() {
  Swal.fire({
        icon: 'info',
        title: 'Export Medical Claim Details',
        html: 'Click OK to continue',
        showCancelButton: true,
        confirmButtonText: 'OK'
    }).then((result) => {

        if (result.isConfirmed) {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            });

            const url = base_url + "/master/export_details_csv"
                + "?nik="   + encodeURIComponent($('#nik').val())
                + "&year="  + encodeURIComponent($('#year').val())
                + "&month=" + encodeURIComponent($('#month').val());

            // 🔥 DOWNLOAD TANPA PINDAH HALAMAN
            $('#downloadFrame').attr('src', url);

            setTimeout(() => {
                Swal.close();
            }, 1500);
        }
    });
});

function view_req_mdcr_on_tm(req_num, nama, nik) {
  
  $("#nama_request_mdcr h4").html(nama);
  $("#view_req_mdcr_on_tm")
    .DataTable()
    .ajax.url(base_url + "/master/view_req_mdcr_on_tm/" + nik +"/"+req_num)
    .load();
}

$("#modalViewReqMDCR").on("shown.bs.modal", function () {
  $(this).trigger("resize");
});

$(".view_req_mdcr_on_tm-table").DataTable({
    scrollX: false,
    ordering: false,
    searching: false,
    autoWidth: false,
    fixedHeader: true,
    paging: false,
    responsive: true,
    lengthChange: false
  });