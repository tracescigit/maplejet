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
        <div class="col-lg-8">
            <div class="container pd-20 mg-t-10 col-10 mx-auto">
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10">Add Job</h4>
                        <p class="mg-b-30">Use this page to add <code>NEW</code> Job.</p>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('status'))
                    <div id="errormsg" class="alert alert-danger">
                        {{ session('status') }}
                    </div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('errormsg').style.display = 'none';
                        }, 10000);
                    </script>
                    @endif
                    <form method="POST" action="{{ route('jobs.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prod_plant">Production Plant</label>
                                    <select name="prod_plant" id="prod_plant" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($productionplant as $value)
                                        <option value="{{$value->id}}" {{ old('prod_plant') == $value->id ? 'selected' : '' }}>{{$value->name}} ({{$value->code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prod_line">Production Line</label>
                                    <select name="prod_line" id="prod_line" class="form-control">
                                        <option value="">Please select</option>
                                        @foreach($productionline as $value)
                                        <option value="{{$value->id}}" {{ old('prod_line') == $value->id ? 'selected' : '' }}>{{$value->name}} ({{$value->code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="job_code">Job Code</label>
                                    <input type="text" name="job_code" id="job_code" value="{{old('job_code')}}" class="form-control" placeholder="Enter Job Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_code">Start Code</label>
                                    <input type="text" name="start_code" id="start_code" value="{{old('start_code')}}" class="form-control" placeholder="Enter Start Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" value="{{old('quantity')}}" id="quantity" min="1" class="form-control" placeholder="Enter Quantity">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Assigned" {{ old('status') == "Assigned" ? 'selected' : '' }}>Assigned</option>
                                        <option value="Hold" {{ old('status') == "Hold" ? 'selected' : '' }}>Hold</option>
                                        <option value="Cancel" {{ old('status') == "Cancel" ? 'selected' : '' }}>Cancel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary float-left">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-custom float-right">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection