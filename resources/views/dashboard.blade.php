@extends('layouts.main') 
@section('title', 'Dashboard')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/chartist/dist/chartist.min.css') }}">
    @endpush


    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-layers bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Dashboard')}}</h5>
                            <span>{{ __('dashboard')}}</span>
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
                                <a href="#">{{ __('Dashboard')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- page statustic chart start -->
            <div class="col-xl-3 col-md-6">
                <div class="card card-red text-white">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="mb-0">0</h4>
                                <p class="mb-0">Customer</p>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ik ik-user f-30"></i>
                            </div>
                        </div>
                        <div id="Widget-line-chart1" class="chart-line chart-shadow" ></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-blue text-white">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="mb-0">0</h4>
                                <p class="mb-0">Coupons</p>
                            </div>
                            <div class="col-4 text-right">
                                <i class="fas fa-tags f-30"></i>
                            </div>
                        </div>
                        <div id="Widget-line-chart2" class="chart-line chart-shadow" ></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-green text-white">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="mb-0">0</h4>
                                <p class="mb-0">Total Order</p>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ik ik-shopping-cart f-30"></i>
                            </div>
                        </div>
                        <div id="Widget-line-chart3" class="chart-line chart-shadow" ></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-yellow text-white">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="mb-0">0</h4>
                                <p class="mb-0">Banner</p>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ik ik-volume-2 f-30"></i>
                            </div>
                        </div>
                        <div id="Widget-line-chart4" class="chart-line chart-shadow" ></div>
                    </div>
                </div>
            </div>
            <!-- page statustic chart end -->

            <!-- product profit start -->
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-red">
                    <div class="card-body">
                        <div class="row align-items-center mb-30">
                            <div class="col">
                                <h6 class="mb-5 text-white">Total Profit</h6>
                                <h3 class="mb-0 fw-700 text-white">0</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-money-bill-alt text-red f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-blue">
                    <div class="card-body">
                        <div class="row align-items-center mb-30">
                            <div class="col">
                                <h6 class="mb-5 text-white">Total Orders</h6>
                                <h3 class="mb-0 fw-700 text-white">0</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database text-blue f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-green">
                    <div class="card-body">
                        <div class="row align-items-center mb-30">
                            <div class="col">
                                <h6 class="mb-5 text-white">Average Price</h6>
                                <h3 class="mb-0 fw-700 text-white">0</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign text-green f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-yellow">
                    <div class="card-body">
                        <div class="row align-items-center mb-30">
                            <div class="col">
                                <h6 class="mb-5 text-white">Order Sold</h6>
                                <h3 class="mb-0 fw-700 text-white">0</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tags text-warning f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- product profit end -->

        </div>
    </div>
     
        
        
        
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('plugins/chartist/dist/chartist.min.js') }}"></script>
        
        <script src="{{ asset('js/widget-statistic.js') }}"></script>
    @endpush
@endsection
  