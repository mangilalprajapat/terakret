@extends('layouts.main') 
@section('title', $banner->title)
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
                        <i class="ik ik-layers bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Banner')}}</h5>
                            <span>{{ __('Edit Banner')}}</span>
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
                                <a href="#">{{ __('Banner')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($banner->title, 'titles')}}
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
                        <form class="forms-sample" method="POST" action="{{ url('banners/update') }}" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="banner_id" value="{{$banner->banner_id}}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title')}}<span class="text-red">*</span></label>
                                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ clean($banner->title, 'title')}}" placeholder="Enter title">
                                        <div class="help-block with-errors"></div>

                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group">
                                        <label for="banner_new">{{ __('Banner')}}<span class="text-red">*</span></label>
                                        <input id="banner_new" type="file" class="form-control @error('banner_new') is-invalid @enderror file-upload-info" name="banner_new" value="{{ old('banner_new') }}">
                                        <div class="help-block with-errors" ></div>

                                        @error('banner_new')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="banner" type="hidden" class="form-control @error('banner') is-invalid @enderror file-upload-info" name="banner" value="{{ clean($banner->banner, 'banner')}}">   
                                        <img src="{{ asset('banner/'.$banner->banner) }}" alt="Image" width="250" height="200">
                                 
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header"><h3>{{ __('Description')}}</h3></div>
                                            <div class="card-body">
                                                <textarea class="form-control html-editor" rows="5" name="description">{{$banner->description}} </textarea>
                                            </div>
                                        </div>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="A" {{ $banner->status == 'A' ? 'selected' : '' }}>Active</option>
                                            <option value="I" {{ $banner->status == 'I' ? 'selected' : '' }}>Inactive</option>
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
    @endpush
@endsection
