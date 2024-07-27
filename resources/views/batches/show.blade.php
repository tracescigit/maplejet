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
                    <h5 class="mb-0  text-white">Batches Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Product:</label>
                                <p> {{$batch->product->name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Batch Code:</label>
                                <p>{{$batch->code}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="company_name">Currency:</label>
                                <p>{{$batch->currency}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="gtin">Price:</label>
                                <p>{{$batch->price}}</p>
                                <hr>
                            </div>
                        </div>
                        @php
                        $dateTime = new DateTime($batch->created_at);
                        $formattedDate = $dateTime->format('d M Y');
                        @endphp
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="image_preview">Manufacturing Date:</label><br>
                                <p>{{ $dateTime->format('d M Y') }}</p>
                                <hr>
                            </div>
                        </div>
                        @php
                        $dateTime = new DateTime($batch->Updated_at);
                        $formattedDate = $dateTime->format('d M Y');
                        @endphp
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="label_image_preview">Expiry Date:</label><br>
                                <p>{{ $dateTime->format('d M Y') }}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold" for="description">Description:</label>
                                <p>{!!$batch->remarks!!}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-bold" for="status">Status:</label>
                                <p>@if($batch->status == 'Active')
                                    <span class="tx-10 badge badge-success">Active</span>
                                    @else
                                    <span class="tx-10 badge badge-danger">Inactive</span>
                                    @endif
                                </p>
                                <hr>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection