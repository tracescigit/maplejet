@extends('dummy.app_new')

@section('content')
<style>
    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
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
            <div class="container pd-20 mg-t-10 col-11 mx-auto">
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bold;">Scan Details</h4>
                        <p class="mg-b-30">Use this page to <code>View</code> Scan Details.</p>
                        <hr>
                    </div>


                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Product Name:</label>
                                <p> {{$scanhistories->product}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Batch Name:</label>
                                <p>{{$scanhistories->batch}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="company_name">IP Address :</label>
                                <p>{{$scanhistories->ip_address}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">Genuine:</label>
                                <p>{{$scanhistories->genuine==1?'Genuine':($scanhistories->genuine==0? 'Fake':'Suspicious')}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="image_preview">Scanned At:</label>
                                <p>{{$scanhistories->created_at}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('scanhistories.index') }}" class="btn btn-secondary float-left">
                                Back</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection