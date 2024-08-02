(function($) {
'use strict';
      //Products data table
    $(document).ready(function()
    {

        var searchable = [];
        var selectable = []; 
        

        var dTable = $('#withdrawal_table').DataTable({

            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            responsive: false,
            serverSide: true,
            processing: true,
            language: {
              processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
            },
            scroller: {
                loadingIndicator: false
            },
            pagingType: "full_numbers",
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
            ajax: {
                url: 'withdrawal/get-list',
                type: "get"
            },
            columns: [
                {data:'withdrawal_id', name: 'withdrawal_id', render: function(data, type, row) {
                   
                    return '#'+data;
                }},
                {data:'customer.username', name: 'customer.username'},
                {data:'customer.phone', name: 'customer.phone'},
                {data:'userbank.account_number', name: 'userbank.account_number'},
                {data:'redeem_points', name: 'redeem_points'},
                {data:'reddeem_amounts', name: 'reddeem_amounts', render: function(data, type, row) {
                   
                    return '₹'+data;
                }},
                { data: 'transaction_id', name: 'transaction_id', render: function(data, type, row) {
                    let statusLabel = '';
                    if (data == null) {
                        statusLabel = '-';
                    } else {
                        statusLabel = data;
                    }
                    return statusLabel;
                }},
                { data: 'status', name: 'status', render: function(data, type, row) {
                    let statusLabel = '';
                    if (data === 'S') {
                        statusLabel = '<label class="badge badge-success">Success</label>';
                    } else if (data === 'P') {
                        statusLabel = '<label class="badge badge-secondary">Pending</label>';
                    } else if (data === 'R') {
                        statusLabel = '<label class="badge badge-primary">Rejected</label>';
                    } else if (data === 'C') {
                        statusLabel = '<label class="badge badge-danger">Cancelled</label>';
                    } else {
                        statusLabel = '<label class="badge badge-danger">Faild</label>';
                    }
                    return statusLabel;
                }},
                {data:'created_at', name: 'create_at'},
                {data:'action', name: 'action'}
            ],
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    title: 'Withdrawal',
                    header: true,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    title: 'Withdrawal',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    title: 'Withdrawal',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible',
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    title: 'Withdrawal',
                    pageSize: 'A2',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-sm btn-default',
                    title: 'Withdrawal',
                    // orientation:'landscape',
                    pageSize: 'A4',
                    header: false,
                    footer: true,
                    orientation: 'landscape',
                    exportOptions: {
                         columns: ':visible',
                        stripHtml: true
                    }
                }
            ],
            initComplete: function () {
                var api =  this.api();
                api.columns(searchable).every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    input.setAttribute('placeholder', $(column.header()).text());
                    input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');

                    $(input).appendTo($(column.header()).empty())
                    .on('keyup', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });

                    $('input', this.column(column).header()).on('click', function(e) {
                        e.stopPropagation();
                    });
                });

                api.columns(selectable).every( function (i, x) {
                    var column = this;

                    var select = $('<select style="width: 140px; height:25px; border:1px solid whitesmoke; font-size: 12px; font-weight:bold;"><option value="">'+$(column.header()).text()+'</option></select>')
                        .appendTo($(column.header()).empty())
                        .on('change', function(e){
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search(val ? '^'+val+'$' : '', true, false ).draw();
                            e.stopPropagation();
                        });

                    $.each(dropdownList[i], function(j, v) {
                        select.append('<option value="'+v+'">'+v+'</option>')
                    });
                });
            }
        });
    });
    $('select').select2();
})(jQuery);