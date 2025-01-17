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
                            <h5>{{ __('Edit Customer')}}</h5>
                            <span>{{ __('Edit customer')}}</span>
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
                                <a href="#">{{ __('Customer')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($customer->username, 'titles')}}
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
                        <form class="forms-sample" method="POST" action="{{ url('customer/update') }}" >
                        @csrf
                            <input type="hidden" name="customer_id" value="{{$customer->customer_id}}">
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="name">{{ __('Username')}}<span class="text-red">*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ clean($customer->username, 'username')}}" required>
                                        <div class="help-block with-errors"></div>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">{{ __('Mobile Number')}}<span class="text-red">*</span></label>
                                        <input id="mobile" type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="phone" value="{{ clean($customer->phone, 'Mobile Number')}}" placeholder="Enter mobile number" required>
                                        <div class="help-block with-errors" ></div>

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">{{ __('Email')}}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ clean($customer->email, 'email')}}" placeholder="Enter email address">
                                        <div class="help-block with-errors" ></div>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="customer-type">{{ __('Customer Type')}}<span class="text-red">*</span></label>
                                        {!! Form::select('customer_type', $customer_type, $selectedCustomerType,[ 'class'=>'form-control select2', 'placeholder' => 'Select customer type','id'=> 'customer-type', 'required'=> 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">{{ __('Date of Birth')}}</label>
                                        <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ clean($customer->dob, 'DOB')}}" placeholder="Enter DOB">
                                        <div class="help-block with-errors" ></div>

                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="pincode">{{ __('PinCode')}}</label>
                                        <input id="pincode" type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode" value="{{ clean($customer->pincode, 'pincode')}}" placeholder="Enter PinCode">
                                        <div class="help-block with-errors" ></div>

                                        @error('pincode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                                <option value="M" {{ $customer->gender == 'M' ? 'selected' : '' }}>Male</option>
                                                <option value="F" {{ $customer->gender == 'F' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select id="country" name="country" class="form-control">
                                                @foreach($countries as $country)
                                                @if(!empty($cities->state))  
                                                    <option value="{{ $country->id }}" {{ $country->id == $cities->state->country_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @else
                                                <option value=""> Select Country</option>
                                                <option value="{{ $country->id }}"> {{ $country->name }}</option>
                                                @endif
                                                @endforeach
                                            
                                        </select>
                                        @error('country_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="state_id">State</label>
                                        <select id="state_id" name="state" class="form-control">
                                            @if(!empty($states))
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}" {{ $state->id == $cities->state_id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                            @else
                                            <option value="">Select State</option>
                                            @endif
                                        </select>
                                        @error('state_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select id="city" name="city" class="form-control">
                                               @if(!empty($cities))
                                                <option value="{{ $cities->id }}" {{ $cities->id == $cities->id ? 'selected' : '' }}>
                                                    {{ $cities->name }}
                                                </option>
                                                @endif
                                        </select>
                                        @error('city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="Active" {{ $customer->status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $customer->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="Rejected" {{ $customer->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        @error('status')
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
        <script>
        $(document).ready(function() {
            $('#country').change(function() {
                var countryId = 101;//$(this).val();
                $('#state').empty().append('<option value="">Select State</option>').prop('disabled', !countryId);
                $('#city').empty().append('<option value="">Select City</option>').prop('disabled', true);

                if (countryId) {
                    $.ajax({
                        url: `/states/${countryId}`,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(index, state) {
                                $('#state_id').append(`<option value="${state.id}">${state.name}</option>`);
                            });
                        }
                    });
                }
            });

            $('#state_id').change(function() {
                var stateId = $(this).val();
                $('#city').empty().append('<option value="">Select City</option>').prop('disabled', !stateId);

                if (stateId) {
                    $.ajax({
                        url: `/cities/${stateId}`,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(index, city) {
                                $('#city').append(`<option value="${city.id}">${city.name}</option>`);
                            });
                        }
                    });
                }
            });
        });
        </script>
    @endpush
@endsection
