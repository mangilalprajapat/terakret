@extends('layouts.main') 
@section('title', 'Customer')
@section('content')
    <!-- push external head elements to head -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Customers')}}</h5>
                            <span>{{ __('List of customer')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Customer')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header"><h3>{{ __('Customer')}}</h3></div>
                    <div class="card-body">
                        <table id="customer_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Profile')}}</th>
                                    <th>{{ __('Referal Code')}}</th>
                                    <th>{{ __('Name')}}</th>
                                    <!-- <th>{{ __('Gender')}}</th> -->
                                    <th>{{ __('Moble Number')}}</th>
                                    <th>{{ __('Email')}}</th>
                                    <th>{{ __('Wallet Amount')}}</th>
                                    <th>{{ __('Coupon Points')}}</th>
                                    <th>{{ __('Customer Type')}}</th>
                                    <th>{{ __('Registration Date')}}</th>
                                    <th>{{ __('Blocked')}}</th>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    <script src="{{ asset('js/customer.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // Handle the click event on the block/unblock icon
        $(document).on('click', '.icon.blockuser', function() {
            var $this = $(this);
            var customerId = $this.data('id');
            var isBlocked = $this.data('isblock');
            // Toggle the block status
            
            // Show confirmation dialog
            var confirmMessage = isBlocked === 'blocked' ? 'Are you sure you want to unblock this customer?' : 'Are you sure you want to block this customer?';
            if (!confirm(confirmMessage)) {
                return;
            }
            $.ajax({
                url: 'customer/block-unblock',
                method: 'POST',
                data: {
                    id: customerId,
                    is_blocked: isBlocked,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
                success: function(response) {
                    if (response.success) {
                        // Update the icon based on the new block status
                        if (isBlocked === 'blocked') {
                            $this.html('<i class="ik ik-toggle-left text-red f-35 text-center"></i>');
                            $this.data('isblock', 'unblocked');
                        } else {
                            $this.html('<i class="ik ik-toggle-right text-green f-35 text-center"></i>');
                            $this.data('isblock', 'blocked');
                        }
                    } else {
                        // Handle error
                        alert('Failed to update block status');
                    }
                },
                error: function() {
                    // Handle AJAX error
                    alert('An error occurred');
                }
            });
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        $(document).on('click', '.delete-item', function() {
            var $this = $(this);
            var customerId = $this.data('id');

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to delete this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with AJAX request
                    $.ajax({
                        url: 'customer/delete/' + customerId, // Adjust the URL to match your route
                        method: 'GET',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove the customer from the DOM
                                $this.closest('tr').remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Your customer has been deleted.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the customer.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'An error occurred.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
    </script>

    @endpush
@endsection
