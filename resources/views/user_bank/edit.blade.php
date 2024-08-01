@extends('layouts.main') 
@section('title', $products->name)
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
                            <h5>{{ __('Edit Product')}}</h5>
                            <span>{{ __('Edit Product')}}</span>
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
                                <a href="#">{{ __('Product')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($products->name, 'titles')}}
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
                        <form class="forms-sample" method="POST" action="{{ url('product/update') }}" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="product_id" value="{{$products->product_id}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Product Name')}}<span class="text-red">*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ clean($products->name, 'name')}}" placeholder="Enter name">
                                        <div class="help-block with-errors"></div>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="category-id">{{ __('Product Category')}}<span class="text-red">*</span></label>
                                        {!! Form::select('category_id', $product_cateogry, $products->category_id,[ 'class'=>'form-control select2', 'placeholder' => 'Select product category','id'=> 'category-id', 'required'=> 'required']) !!}
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="product_image_new">{{ __('Product Image')}}<span class="text-red">*</span></label>
                                        <input id="product_image_new" type="file" class="form-control @error('product_image_new') is-invalid @enderror file-upload-info" name="product_image_new" value="{{ old('product_image_new') }}">
                                        <div class="help-block with-errors" ></div>

                                        @error('product_image_new')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <input id="product_image" type="hidden" class="form-control @error('product_image') is-invalid @enderror file-upload-info" name="product_image" value="{{ clean($products->product_image, 'product_image')}}">   
                                        <img src="{{ asset('products/'.$products->product_image) }}" alt="Image" width="250" height="200">
                                 
                                    </div>
                                    <div class="form-group">
                                        <label for="sale_price">{{ __('Sale Price')}}</label>
                                        <input id="sale_price" type="number" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{ clean($products->sale_price, 'sale_price')}}" placeholder="Enter sale price">
                                        <div class="help-block with-errors"></div>

                                        @error('sale_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="price">{{ __('Price')}}<span class="text-red">*</span></label>
                                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ clean($products->price, 'price')}}" placeholder="Enter price">
                                        <div class="help-block with-errors"></div>

                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="size">{{ __('Size')}}<span class="text-red">*</span></label>
                                        <input id="size" type="text" class="form-control @error('size') is-invalid @enderror" name="size" value="{{$products->size}}" placeholder="Enter size">
                                        <div class="help-block with-errors"></div>

                                        @error('size')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="product_code">{{ __('Product Code')}}<span class="text-red">*</span></label>
                                        <input id="product_code" type="text" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{$products->product_code}}" placeholder="Enter product code">
                                        <div class="help-block with-errors"></div>

                                        @error('product_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                            <div class="card">
                                                <div class="card-header"><h3>{{ __('Description')}}</h3></div>
                                                <div class="card-body">
                                                    <textarea class="form-control html-editor" rows="5" name="description">{{$products->description}} </textarea>
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
                                            <option value="A" {{ $products->status == 'A' ? 'selected' : '' }}>Active</option>
                                            <option value="I" {{ $products->status == 'I' ? 'selected' : '' }}>Inactive</option>
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
