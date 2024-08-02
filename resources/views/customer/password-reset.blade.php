@extends('layouts.main') 
@section('title', $customer->username)
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
                            <h5>{{ __('Password Reset')}}</h5>
                            <span>{{ __('customer password reset')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Password Reset')}} / {{$customer->username}}</a>
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
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Password Reset')}}</h3>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('password-update') }}" >
                        @csrf
                            <div class="row">
                                <div class="col-sm-6">

                                <input id="customer_id" type="hidden" class="form-control" name="customer_id" value="{{$customer->customer_id}}">
                                    
                                    <div class="form-group">
                                        <label for="password">{{ __('Password')}}<span class="text-red">*</span></label>
                                        <input id="password" type="password" class="form-control @error('name') is-invalid @enderror" name="password" value="" placeholder="Enter password">
                                        <div class="help-block with-errors"></div>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">{{ __('Confirm Password')}}<span class="text-red">*</span></label>
                                        <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Enter Confirm Password">
                                        <div class="help-block with-errors" ></div>

                                        @error('confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="showPassword" class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="showPassword">
                                            <span class="custom-control-label">&nbsp; {{ __('Show Password')}}</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
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
        <script>
        $(document).ready(function() {
            $('#showPassword').on('change', function() {
                var passwordField = $('#password');
                var conformPasswordField = $('#confirm_password');
                if ($(this).is(':checked')) {
                    passwordField.attr('type', 'text'); // Show password
                    conformPasswordField.attr('type', 'text'); // Show conform Password
                } else {
                    passwordField.attr('type', 'password'); // Hide password
                    conformPasswordField.attr('type', 'password'); // Hide conform Password
                }
            });
        });
        </script>
    @endpush
@endsection
