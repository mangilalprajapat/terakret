(function($) {
'use strict';
      //User Bank data table
    $(document).ready(function()
    {

        var searchable = [];
        var selectable = []; 
        

        var dTable = $('#user_bank_table').DataTable({

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
                url: 'user_bank/get-list',
                type: "get"
            },
            columns: [
                { 
                    data: 'document', 
                    name: 'document',
                    render: function(data, type, full, meta) {
                        return '<img src="bank_document/' + data + '" style="max-width:100px; max-height:100px;" class="table-user-thumb"/>';
                    },
                    orderable: false,
                    searchable: false
                },
                {data:'account_number', name: 'account_number', orderable: true, searchable: true},
                {data:'payment_method', name: 'payment_method', orderable: true, searchable: true},
                {data:'upi', name: 'upi', orderable: true, searchable: true},
                {data:'googlepay', name: 'googlepay', orderable: true, searchable: true},
                {data:'phonepe', name: 'phonepe', orderable: true, searchable: true},
                {data:'paytm', name: 'paytm', orderable: true, searchable: true},
                {data:'customer.username', name: 'customer.username'},
                {data:'customer.phone', name: 'customer.phone'},
                {data:'account_holder_name', name: 'account_holder_name'},
                {data:'bank_name', name: 'bank_name'},
                {data:'ifsc_code', name: 'ifsc_code'},
                {data:'status', name: 'status'},
                {data:'created_at', name: 'create_at'},
                {data:'action', name: 'action'}
            ],
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    title: 'User Bank',
                    header: true,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    title: 'User Bank',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    title: 'User Bank',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible',
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    title: 'User Bank',
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
                    title: 'User Bank',
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