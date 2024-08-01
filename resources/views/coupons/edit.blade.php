@extends('layouts.main') 
@section('title', $coupon->code)
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Coupon')}}</h5>
                            <span>{{ __('Edit Coupon')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Coupon')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($coupon->code, 'titles')}}
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
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ url('coupon/update') }}" >
                        @csrf
                            <input type="hidden" name="coupon_id" value="{{$coupon->coupon_id}}">
                            <div class="row">
                            <div class="col-sm-6">
                                    
                                    <div class="form-group">
                                    <label for="code">{{ __('Coupon Code')}}<span class="text-red">*</span></label>
                                        <div class="input-group input-group-button">
                                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ clean($coupon->code, 'code')}}" placeholder="Enter coupon code" >
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="button" id="generateRandomCoupon">{{ __('Generate Coupon')}}</button>
                                            </div>
                                            <div class="help-block with-errors" ></div>

                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="points">{{ __('Coupon Points')}}<span class="text-red">*</span></label>
                                        <input id="points" type="number" class="form-control @error('points') is-invalid @enderror" name="points" value="{{ clean($coupon->points, 'points')}}" placeholder="Enter coupon points" >
                                        <div class="help-block with-errors" ></div>

                                        @error('points')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="maximum_usage">{{ __('Maximun Coupon Usage')}}<span class="text-red">*</span></label>
                                        <input id="maximum_usage" type="number" class="form-control @error('maximum_usage') is-invalid @enderror" name="maximum_usage" value="{{ clean($coupon->maximum_usage, 'maximum_usage')}}" placeholder="Enter maximum coupon usage" >
                                        <div class="help-block with-errors" ></div>

                                        @error('maximum_usage')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="user_limit">{{ __('Coupon User Limit')}}<span class="text-red">*</span></label>
                                        <input id="user_limit" type="number" class="form-control @error('user_limit') is-invalid @enderror" name="user_limit" value="{{ clean($coupon->user_limit, 'user_limit')}}" placeholder="Enter coupon user limit" >
                                        <div class="help-block with-errors" ></div>

                                        @error('user_limit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="start_at">{{ __('Start Date')}}<span class="text-red">*</span></label>
                                        <input id="start_at" type="date" class="form-control @error('start_at') is-invalid @enderror" name="start_at" value="{{ clean($coupon->start_at, 'start_at')}}" placeholder="Enter start date" >
                                        <div class="help-block with-errors" ></div>

                                        @error('start_at')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="expired_at">{{ __('Expired Date')}}<span class="text-red">*</span></label>
                                        <input id="expired_at" type="date" class="form-control @error('expired_at') is-invalid @enderror" name="expired_at" value="{{ clean($coupon->expired_at, 'expired_at')}}" placeholder="Enter start date" >
                                        <div class="help-block with-errors" ></div>

                                        @error('expired_at')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="A" {{ $coupon->status == 'A' ? 'selected' : '' }}>Active</option>
                                            <option value="I" {{ $coupon->status == 'I' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary form-control-right">{{ __('Update')}}</button>
                                    </div>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script') 
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <!--get role wise permissiom ajax script-->
        <script src="{{ asset('js/get-role.js') }}"></script>
    @endpush
    <script>
        $(document).ready(function() {
            $('#generateRandomCoupon').click(function() {
                var length = 15; // Specify the length of the random string
                var charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var result = '';
                for (var i = 0; i < length; i++) {
                    result += charset.charAt(Math.floor(Math.random() * charset.length));
                }
                $('#code').val(result);
            });
        });
        </script>
@endsection
