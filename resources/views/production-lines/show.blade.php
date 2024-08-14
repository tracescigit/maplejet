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
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">View Production line Details</h4>
                        <p class="mg-b-30">Use this page to <code>View</code> Production line Details.</p>
                        <hr>
                    </div>


                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Production-Line Code:</label>
                                <p> {{$productionlines->code}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">IP Address:</label>
                                <p>{{$productionlines->ip_address}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="company_name">Printer Name:</label>
                                <p>{{$productionlines->printer_name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">Production-Line Name:</label>
                                <p>{{$productionlines->name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="status">Status:</label>
                                <p>@if($productionlines->status == 'Active')
                                    <span class="tx-10 badge badge-success">Active</span>
                                    @else
                                    <span class="tx-10 badge badge-danger">Inactive</span>
                                    @endif
                                </p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="label_image_preview">Created At</label>
                                <p>{{$productionlines->created_at}}</p>
                                <hr>
                            </div>
                        </div>
                       
                    </div>
                    <div class="form-group mt-4">
                            <a href="{{ route('production-lines.index') }}" class="btn btn-secondary float-left">Back</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection