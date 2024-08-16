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
                            <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">View Details</h4>
                            <p class="mg-b-30">Use this page to  <code style="color:#e300be;">View</code> Details.</p>
                            <hr>
                        </div>


                    </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Log Name:</label>
                                <p> {{$userlog->log_name}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="product_brand">Event:</label>
                                <p>{{$userlog->log_name}} has been {{$userlog->event}}</p>
                                <hr>
                            </div>
                        </div>
                        @if(empty($log_datas))
                        @php
                        $new_values = ''; // Initialize the variable to hold concatenated values

                        foreach ($new_data as $key=>$singledata) {
                        $new_values .= $key.': '.$singledata . ' , '; // Append each value followed by a comma
                        }

                        // Optionally, you might want to remove the trailing comma
                        $new_values = rtrim($new_values, ' ,');
                        $old_values='';
                        foreach($old_data as $key=>$singleolddata){
                        $old_values.= $key.': '.$singleolddata.' , ';
                        }
                        $old_values = rtrim($old_values, ' ,');
                        @endphp
                        <div class="col-12">
                            <label class="font-weight-bold" for="company_name">Properties:</label><br>
                            <div class="form-group">
                                <span style="color:blue">New Values :</span>
                                <p>{{$new_values}} </p>
                                <div>
                                    <span style="color:blue">Old Values :</span>
                                    <p>{{$old_values}}</p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <label class="font-weight-bold" for="company_name">User Details</label><br>
                            <div class="form-group">
                                <p>{{$log_datas}} </p>
                            </div>
                        </div>
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="image_preview">Done At:</label>
                                <p>{{ \Carbon\Carbon::parse($userlog->created_at)->format('d-m-Y \a\t h:i A') }}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="label_image_preview">Done By :</label>
                                <p>{{ucfirst($userlog->user->name)}}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold" for="description">Description:</label>
                                <p>{!!$userlog->description!!}</p>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group mt-4 col-6">
                            <a href="{{ route('userlog.index') }}" class="btn btn-secondary mx-2">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection