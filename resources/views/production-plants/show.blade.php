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
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">View Production Plants Details</h4>
                        <p class="mg-b-30">Use this page to  <code>View</code> Production Plants details</p>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Production-plant Name:</label>
                                <p> {{$productionplant->name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Production-plant code:</label>
                                <p>{{$productionplant->code}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="company_name">Status :</label>
                               <p> @if($productionplant->status == 'Active')
                                <span class="badge badge-success"> {{$productionplant->status}}</span>
                                @else
                                <span class="badge badge-danger"> {{$productionplant->status}}</span>
                                @endif
                                </p>
                                <hr>
                            </div>
                        </div>
                       
                    </div>
                    <div class="form-group mt-4">
                            <a href="{{ route('production-plants.index') }}" class="btn btn-secondary float-left">Back</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection