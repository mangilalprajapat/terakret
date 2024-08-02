(function($) {
'use strict';
      //Customer data table
    $(document).ready(function()
    {

        var searchable = [];
        var selectable = []; 
        

        var dTable = $('#customer_table').DataTable({

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
                url: 'customer/get-list',
                type: "get"
            },
            columns: [
                {data:'profile_image', name: 'profile_image', orderable: false, searchable: false},
                {data:'referal_code', name: 'referal_code', orderable: true, searchable: true},
                {data:'username', name: 'username', orderable: true, searchable: true},
                {data:'gender', name: 'gender', orderable: true, searchable: true},
                {data:'phone', name: 'phone'},
                {data:'email', name: 'email'},
                { data: 'wallet_amount', name: 'wallet_amount', render: function(data, type, row) {                    
                    return '₹'+data;
                }},
                {data:'coupon_points', name: 'coupon_points'},
                {data:'customertype.customer_type', name: 'customertype.customer_type'},
                {data:'created_at', name: 'create_at'},
                {data:'is_blocked', name: 'is_blocked'},
                {data:'status', name: 'status'},
                {data:'action', name: 'action'}
            ],
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    title: 'Customer',
                    header: true,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    title: 'Customer',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    title: 'Customer',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible',
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    title: 'Customer',
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
                    title: 'Customer',
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