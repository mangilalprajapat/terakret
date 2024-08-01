@extends('layouts.main') 
@section('title', "Contact Us")
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
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Contact Us')}}</h5>
                            <span>{{ __('Contact Us')}}</span>
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
                                <a href="#">{{ __('Contact Us')}}</a>
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
                        <form class="forms-sample" method="POST" action="{{ url('contact_us/update') }}" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="contact_us_id" value="{{$contact_us->contact_us_id}}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phone_number">{{ __('Phone Number')}}<span class="text-red">*</span></label>
                                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ clean($contact_us->phone_number, 'phone_number')}}" placeholder="Enter Phone Number">
                                        <div class="help-block with-errors"></div>

                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">{{ __('Email')}}<span class="text-red">*</span></label>
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ clean($contact_us->email, 'email')}}" placeholder="Enter Phone Number">
                                        <div class="help-block with-errors"></div>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header"><h3>{{ __('Address')}}</h3></div>
                                            <div class="card-body">
                                                <textarea class="form-control html-editor" rows="3" name="address">{{$contact_us->address}} </textarea>
                                            </div>
                                        </div>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header"><h3>{{ __('Map Address')}}</h3></div>
                                            <div class="card-body">
                                                <textarea class="form-control html-editor" rows="3" name="map_address">{{$contact_us->map_address}} </textarea>
                                            </div>
                                        </div>
                                        @error('map_address')
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
