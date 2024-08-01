@extends('layouts.main') 
@section('title', 'User Withdrawal')

@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <title>View | Terakret</title>
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/c3/c3.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    @endpush
    <style>
        #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 60%;
        }

        /* Caption of Modal Image */
        #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {  
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)} 
        to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
        position: absolute;
        top: 65px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        }

        .close:hover,
        .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
        }
    </style>
    
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-wallet bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('User Withdrawal')}}</h5>
                            <span>{{ __('User Withdrawal Reqeust')}}</span>
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
                                <a href="#">{{ __('Withdrawal')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$withdrawal->withdrawal_id}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3 class="d-block w-100">Order ID : #{{$withdrawal->withdrawal_id}}<small class="float-right"><strong>{{ __('Order Date:')}} {{ date('j F Y, h:i A', strtotime($withdrawal->created_at)) }}</strong></small></h3></div>
            <div class="card-body">
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <strong>CUSTOMER INFO</strong><hr>
                        <address>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>{{ __('Customer Name')}}:</td>
                                        <td class="font-medium"><strong>{{$withdrawal->customer->username}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td class="font-medium"><strong>N/A</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Phone:</td>
                                        <td class="font-medium"><strong>{{$withdrawal->customer->phone_code}} {{$withdrawal->customer->phone}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td class="font-medium"><strong>{{$withdrawal->customer->email}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <strong>BANK INFO</strong><hr>
                        <address>                        
                            <table class="table table-borderless">
                                <tbody>
                                    @if ($withdrawal->userbank->payment_method == 'Bank Account')
                                        <tr>
                                            <td>Payment Method</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->payment_method}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Account Holder Name</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->account_holder_name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Account Number</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->account_number}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Account Type</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->account_type}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>IFSC Code</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->ifsc_code}}</strong></td>
                                        </tr>
                                    @elseif ($withdrawal->userbank->payment_method == 'UPI')
                                        <tr>
                                            <td>Account Holder Name</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->account_holder_name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>UPI ID</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->upi}}</strong></td>
                                        </tr>
                                    @elseif ($withdrawal->userbank->payment_method == 'Google Pay')
                                        <tr>
                                            <td>Account Holder Name</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->account_holder_name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Google Pay</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->googlepay}}</strong></td>
                                        </tr>
                                        
                                    @elseif ($withdrawal->userbank->payment_method == 'PhonePe')
                                        <tr>
                                            <td>Account Holder Name</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->account_holder_name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>PhonePe</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->phonepe}}</strong></td>
                                        </tr>
                                    @elseif ($withdrawal->userbank->payment_method == 'Paytm')
                                        <tr>
                                            <td>Account Holder Name</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->account_holder_name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Paytm</td>
                                            <td class="font-medium"><strong>{{$withdrawal->userbank->paytm}}</strong></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>Other</td>
                                            <td class="font-medium"><strong>Other</strong></td>
                                        </tr>
                                    @endif
                                        <tr>
                                            <td>Documents</td>
                                            @if($withdrawal->userbank->document)
                                            <td class="font-medium"><strong><i class="ik ik-eye f-16 mr-15 text-green" id="view-button" title="View Bank Document"></i></strong></td>
                                            <td class="font-medium d-none"><img id="myImg" src="{{ asset('bank_document/'.$withdrawal->userbank->document) }}" alt="Bank Document Info"></td>
                                            @else
                                            <td class="font-medium"><strong>N/A</strong></td>
                                            @endif
                                        </tr>
                                </tbody>
                            </table>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                    <strong>ORDER INFO</strong><hr>
                        <table class="table table-borderless">
                            <tbody>
                                   
                                    <tr>
                                        <td>Status:</td>
                                        <td class="font-medium">
                                            <strong>
                                                @if($withdrawal->status == "P")
                                                <button type="button" class="btn btn-secondary pull-right">Pending</button>
                                                @elseif ($withdrawal->status == "S")
                                                <button type="button" class="btn btn-success pull-right">Success</button>
                                                @elseif ($withdrawal->status == "C")
                                                <button type="button" class="btn btn-danger pull-right">Cancelled</button>
                                                @elseif ($withdrawal->status == "R")
                                                <button type="button" class="btn btn-primary pull-right">Rejected</button>
                                                @else
                                                <button type="button" class="btn btn-danger pull-right">Faild</button>
                                                @endif   
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Payment Method:</td>
                                        <td class="font-medium"><strong>{{$withdrawal->userbank->payment_method}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Redeems Points:</td>
                                        <td class="font-medium"><strong>{{$withdrawal->redeem_points}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Redeems Account:</td>
                                        <td class="font-medium"><strong>₹{{$withdrawal->reddeem_amounts}}</strong></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <p class="lead">{{ __('Payment Method')}}</p>
                        @if ($withdrawal->userbank->payment_method == 'Bank Account')
                            <img src="{{ asset('src/img/bank.png') }}" alt="Bank Account" style="max-width:50%">
                            @elseif ($withdrawal->userbank->payment_method == 'UPI')
                            <img src="{{ asset('src/img/upi.png') }}" alt="UPI" style="max-width:50%">
                            @elseif ($withdrawal->userbank->payment_method == 'Google Pay')
                            <img src="{{ asset('src/img/googlepey.png') }}" alt="Google Pay" style="max-width:50%">
                            @elseif ($withdrawal->userbank->payment_method == 'PhonePe')
                            <img src="{{ asset('src/img/phonepe.png') }}" alt="PhonePe" style="max-width:50%">
                            @elseif ($withdrawal->userbank->payment_method == 'Paytm')
                            <img src="{{ asset('src/img/paytm.png') }}" alt="Paytm" style="max-width:50%">
                            @else
                            @endif                       
                    </div>
                    <div class="col-9">
                        <p class="lead">{{ __('Status Update')}}</p>
                        <div class="card card-484">
                        <div class="card-body">
                            @if($withdrawal->status != "P")
                            <div class="alert alert-secondary mt-20">
                              Withdrawal request can only be updated if it is in <b>Pending</b> status.
                            </div>
                            @else
                            <form class="forms-sample" id="withdrawalForm" action="{{ url('withdrawal/statusupdate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="withdrawal_id" id="withdrawal_id" value="{{$withdrawal->withdrawal_id}}">
                                <input type="hidden" name="customer_id" id="customer_id" value="{{$withdrawal->user_id}}">
                                <input type="hidden" name="redeem_points" id="redeem_points" value="{{$withdrawal->redeem_points}}">
                                <input type="hidden" name="reddeem_amounts" id="reddeem_amounts" value="{{$withdrawal->reddeem_amounts}}">
                                
                                <div class="form-group row">
                                    <label for="Status" class="col-sm-3 col-form-label">{{ __('Status')}}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="status" name="status">
                                            <option value="P" {{($withdrawal->status == "P") ? 'selected' : ''}}>{{ __('Pending')}}</option>
                                            <option value="S" {{($withdrawal->status == "S") ? 'selected' : ''}}>{{ __('Success')}}</option>
                                            <option value="C" {{($withdrawal->status == "C") ? 'selected' : ''}}>{{ __('Cancelled')}}</option>
                                            <option value="R" {{($withdrawal->status == "R") ? 'selected' : ''}}>{{ __('Rejected')}}</option>
                                            <option value="F" {{($withdrawal->status == "F") ? 'selected' : ''}}>{{ __('Faild')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row transaction-group">
                                    <label for="transactionid" class="col-sm-3 col-form-label">{{ __('Transaction Id')}}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="transactionid" class="form-control" id="transactionid" placeholder="Enter Transaction Id">
                                    </div>
                                </div>
                                
                                <div class="form-group row description-group">
                                    <label for="description" class="col-sm-3 col-form-label">{{ __('Description')}}</label>
                                    <div class="col-sm-9">
                                      <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                    </div>
                                </div>
                            
                                <button type="button" class="btn btn-primary mr-2" id="orderStatusUpdate">{{ __('Order Update')}}</button>
                                <button type="button" class="btn btn-light cancel-button" id="cancelButton">{{ __('Cancel')}}</button>
                            </form>
                            <br>
                            <div id="responseMessage"></div> <!-- For displaying success or error messages -->
                            @endif
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="bankDocumentsModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById("bankDocumentsModal");

        var viewButton = document.getElementById("view-button");
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        viewButton.onclick = function(){
        modal.style.display = "block";
        modalImg.src = img.src;
        captionText.innerHTML = img.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
        modal.style.display = "none";
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#orderStatusUpdate').click(function() {
                
                var confirmed = confirm('Are you sure you want to perform this action?');
                if (confirmed) {
                    var formData = $('#withdrawalForm').serialize();
                    $("#orderStatusUpdate").prop('disabled', true);
                    $("#cancelButton").prop('disabled', true);
                    $.ajax({
                        url: $('#withdrawalForm').attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log('Success',response);
                            if(response.status ==200){
                                $("#orderStatusUpdate").prop('disabled', false);
                                $("#cancelButton").prop('disabled', false);
                                $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                                $('#withdrawalForm')[0].reset();
                                location.reload();
                            }else{
                                $('#responseMessage').html('<div class="alert alert-danger">' + response.errors + '</div>');
                            }
                        },
                        error: function(xhr) {
                            console.log('Error',xhr.responseJSON.errors);
                            $("#orderStatusUpdate").prop('disabled', false);
                            $("#cancelButton").prop('disabled', false);
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value + '<br>';
                            });
                            $('#responseMessage').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                        }
                    });
                }
            });
            document.getElementById('cancelButton').addEventListener('click', function () {
                $('#withdrawalForm')[0].reset();
            });
        });
    </script>
    <script>
      $('#status').on('change', function (e) {
        var selectedValue = $(this).val();
        if (selectedValue == 'S'){
            $('.transaction-group').addClass('input-group-warning');
            $('.description-group').removeClass('input-group-warning');
        } else {
            $('.transaction-group').removeClass('input-group-warning');
            $('.description-group').addClass('input-group-warning');
        }
     });
     $('#transactionid').keyup(function(e) {
        var transactionidVale = $('#transactionid').val();
        if(transactionidVale != ""){
            $('.transaction-group').removeClass('input-group-warning');
        }else{
            $('.transaction-group').addClass('input-group-warning');
        }
    });
     $('#description').keyup(function(e) {
        var descriptionVale = $('#description').val();
        if(descriptionVale != ""){
            $('.description-group').removeClass('input-group-warning');
        }else{
            $('.description-group').addClass('input-group-warning');
        }
    });
    </script>
    <!-- push external js -->
    @push('script') 
        <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap.min.js') }}"></script>
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ asset('plugins/d3/dist/d3.min.js') }}"></script>
        <script src="{{ asset('plugins/c3/c3.min.js') }}"></script>
        <script src="{{ asset('js/tables.js') }}"></script>
        <script src="{{ asset('js/widgets.js') }}"></script>
        <script src="{{ asset('js/charts.js') }}"></script>
    @endpush
@endsection