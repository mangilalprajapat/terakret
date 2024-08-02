@extends('layouts.main') 
@section('title', 'Customer')
@section('content')
    <!-- push external head elements to head -->
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
                                    <th>{{ __('Gender')}}</th>
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
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script>
        // $(document).ready(function() {
        //     // When an edit button is clicked
        //     $('.table-user-thumb').click(function() {
        //         const itemId = $(this).data('id');
        //         alert('sdfdsfsdf');
        //     });
        // });
    </script>
    @endpush
@endsection
