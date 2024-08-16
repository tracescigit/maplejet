@extends('dummy.app_new')

@section('content')
<style>
    .btn-custom {
        background: #b70a9b !important;
        color: white;
        border-radius: 5px;
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
</style>
<div class="content content-components">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 font-weight-bolder">View Details</h4>
                        <p class="mg-b-30">Use this page to <code style="color:#e300be;">View</code> System Report Details .</p>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Product Name:</label>
                                <p> {{$sysshow->product}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Batch Name:</label>
                                <p>{{$sysshow->batch}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="company_name">Latitude :</label>
                                <p>{{$sysshow->lat}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">Longitude :</label>
                                <p>{{$sysshow->long}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">Reported At:</label>
                                <p class="text-danger">{{$sysshow->created_at}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="image_preview">Report Reason:</label>
                                <p>{{$sysshow->report_reason}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="label_image_preview">IP Address:</label>
                                <p>{{$sysshow->ip}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold" for="description">Description:</label>
                                <p>{!!$sysshow->description!!}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <a href="{{ route('systemalerts') }}" class="btn btn-secondary float-left">
                        Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection