@extends('layouts.main') 
@section('title', 'Coupons')
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
                        <i class="fas fa-tags bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Couponss')}}</h5>
                            <span>{{ __('List of Coupons')}}</span>
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
                                <a href="#">{{ __('Coupons')}}</a>
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
                    <div class="card-header"><h3>{{ __('Coupons')}}</h3></div>
                    <div class="card-body">
                        <table id="coupons_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Coupon Code')}}</th>
                                    <th>{{ __('Points')}}</th>
                                    <th>{{ __('Maximun Usage')}}</th>
                                    <th>{{ __('User Limit')}}</th>
                                    <th>{{ __('Start At')}}</th>
                                    <th>{{ __('Expired At')}}</th>
                                    <th>{{ __('Created At')}}</th>
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
    <script src="{{ asset('js/coupons.js') }}"></script>
    @endpush
@endsection