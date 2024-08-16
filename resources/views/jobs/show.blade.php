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
                <div class="Container">
                    <div class="d-flex bg-gray-10">
                        <div class="pd-10 flex-grow-1">
                            <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">Jobs Details</h4>
                            <p class="mg-b-30">Use this page to <code style="color:#e300be;">View</code> Jobs Details.</p>
                            <hr>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="product_brand">Job Code:</label>
                                    <p> {{$jobs->code}}</p>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="product_brand">Start Code:</label>
                                    <p>{{$jobs->start_code}}</p>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="company_name">Quantity:</label>
                                    <p>{{$jobs->quantity}}</p>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="gtin">Status:</label>
                                    <p> @if($jobs->status == 'Assigned')
                                        <span class="badge badge-success">{{$jobs->status}}</span>
                                        @else
                                        <span class="badge badge-danger">{{$jobs->status}}</span>
                                        @endif
                                    </p>
                                    <hr>
                                </div>
                            </div>
                            <div class="form-group mt-4 col-6">
                                <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
</div>

@endsection