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
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card pd-20 mg-t-10 col-11 mx-auto">
                <div class="card-header btn-custom ">
                    <h5 class="mb-0  text-white">Jobs Details</h5>
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
                        <div class="form-group mt-4">
                            <a href="{{ route('jobs.index') }}" class="btn btn-secondary float-left"><i class="fas fa-arrow-left"></i>Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection