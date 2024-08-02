@extends('layouts.main') 
@section('title', "App Settings")
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
                        <i class="ik ik-settings bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('App Settings')}}</h5>
                            <span>{{ __('App Settings')}}</span>
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
                                <a href="#">{{ __('App Settings')}}</a>
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
                        <form class="forms-sample" method="POST" action="{{ url('app_settings/update') }}" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="app_settings_id" value="{{$app_settings->app_settings_id}}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="point_amount">{{ __('Points Amounts')}} ({{__('1 Points == Amounts')}})<span class="text-red">*</span></label>
                                        <input id="point_amount" type="text" class="form-control @error('point_amount') is-invalid @enderror" name="point_amount" value="{{ clean($app_settings->point_amount, 'point_amount')}}" placeholder="Enter points amounts">
                                        <div class="help-block with-errors"></div>

                                        @error('point_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="minimum_redeem_point">{{ __('Minimum Redeem Points Withdrawal')}}<span class="text-red">*</span></label>
                                        <input id="minimum_redeem_point" type="text" class="form-control @error('minimum_redeem_point') is-invalid @enderror" name="minimum_redeem_point" value="{{ clean($app_settings->minimum_redeem_point, 'minimum_redeem_point')}}" placeholder="Enter Minimum Redeem Points Withdrawal">
                                        <div class="help-block with-errors"></div>

                                        @error('minimum_redeem_point')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="maximum_redeem_point">{{ __('Maximum Redeem Points Withdrawal')}}<span class="text-red">*</span></label>
                                        <input id="maximum_redeem_point" type="text" class="form-control @error('maximum_redeem_point') is-invalid @enderror" name="maximum_redeem_point" value="{{ clean($app_settings->maximum_redeem_point, 'maximum_redeem_point')}}" placeholder="Enter Maximum Redeem Points Withdrawal">
                                        <div class="help-block with-errors"></div>

                                        @error('maximum_redeem_point')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="app_version">{{ __('App Version')}}<span class="text-red">*</span></label>
                                        <input id="app_version" type="number" class="form-control @error('app_version') is-invalid @enderror" name="app_version" value="{{ clean($app_settings->app_version, 'app_version')}}" placeholder="Enter points amounts">
                                        <div class="help-block with-errors"></div>

                                        @error('app_version')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="maintenance_mode">Maintenance Mode</label>
                                        <select class="form-control" id="maintenance_mode" name="maintenance_mode">
                                            <option value="0" {{ $app_settings->maintenance_mode == '0' ? 'selected' : '' }}>OFF</option>
                                            <option value="1" {{ $app_settings->maintenance_mode == '1' ? 'selected' : '' }}>ON</option>
                                        </select>
                                        @error('maintenance_mode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="maintenance_mode_message">{{ __('Maintenance Mode Message')}}<span class="text-red">*</span></label>
                                        <textarea id="maintenance_mode_message"  class="form-control @error('maintenance_mode_message') is-invalid @enderror" name="maintenance_mode_message" placeholder="Enter Maintenance Mode Message" rows="3">{{ clean($app_settings->maintenance_mode_message, 'maintenance_mode_message')}}</textarea>
                                        <div class="help-block with-errors"></div>

                                        @error('maintenance_mode_message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
@endsection
