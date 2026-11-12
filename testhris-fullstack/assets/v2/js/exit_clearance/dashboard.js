$(document).ready(function () {
    $('#table-monitoring').DataTable({
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        scrollX: true,
        ordering: true,
        searching: true,
        responsive: false,
        autoWidth: false,
        order: [[8, 'desc']],
        rowCallback: function (row, data, displayIndex) {
            const pageInfo = this.api().page.info();
            $('td:eq(0)', row).text(pageInfo.start + displayIndex + 1);
        },
        columnDefs: [
            {
                targets: [0, 12],
                orderable: false,
                searchable: false
            }
        ],
        language: {
            emptyTable: 'No data available',
            search: 'Search:',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            zeroRecords: 'No matching records found',
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        }
    });

    $('#table-monitoring_wrapper .dataTables_scroll').css('margin-top', '16px');
});