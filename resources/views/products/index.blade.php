@extends('layouts.main') 
@section('title', 'Products')
@section('content')
    <!-- push external head elements to head -->
    resources/views/withdrawal/index.blade.php
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-shopping-bag bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Productss')}}</h5>
                            <span>{{ __('List of products')}}</span>
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
                                <a href="#">{{ __('Products')}}</a>
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
                    <div class="card-header"><h3>{{ __('Products')}}</h3></div>
                    <div class="card-body">
                        <table id="products_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Image')}}</th>
                                    <th>{{ __('Category')}}</th>
                                    <th>{{ __('Sale Price')}}</th>
                                    <th>{{ __('Price')}}</th>
                                    <th>{{ __('Size')}}</th>
                                    <th>{{ __('Product Code')}}</th>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Created At')}}</th>
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
    <script src="{{ asset('js/products.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-item', function() {
                var $this = $(this);
                var itemId = $this.data('id');

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to delete this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with AJAX request
                        $.ajax({
                            url: 'product/delete/' + itemId, // Adjust the URL to match your route
                            method: 'GET',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove the product from the DOM
                                    $this.closest('tr').remove();
                                    Swal.fire(
                                        'Deleted!',
                                        'Your product has been deleted.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete the product.',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endpush
@endsection
