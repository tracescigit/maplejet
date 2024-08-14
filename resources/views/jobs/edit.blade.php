@extends('dummy.app_new')

@section('content')
<style>
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .btn-custom {
        background: #b70a9b !important;
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }
</style>
<div class="content content-components">
   
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="container">
                    <div class="d-flex bg-gray-10">
                        <div class="pd-10 flex-grow-1">
                            <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">Edit Details</h4>
                            <p class="mg-b-30">Use this page to <code>Edit</code> Jobs Details.</p>
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
                        <form method="POST" action="{{ route('jobs.update', $productionjob->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="prod_plant">Production Plant</label>
                                        <select name="prod_plant" id="prod_plant" class="form-control">
                                            <option value="">Please select</option>
                                            @foreach($productionplant as $plant)
                                            <option value="{{ $plant->id }}" {{ $productionjob->plant_id == $plant->id ? 'selected' : '' }}>
                                                {{ $plant->name }} ({{ $plant->code }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="prod_line">Production Line</label>
                                        <select name="prod_line" id="prod_line" class="form-control">
                                            <option value="">Please select</option>
                                            @foreach($productionline as $line)
                                            <option value="{{ $line->id }}" {{ $productionjob->line_id == $line->id ? 'selected' : '' }}>
                                                {{ $line->name }} ({{ $line->code }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="job_code">Job Code</label>
                                        <input type="text" name="job_code" id="job_code" class="form-control" value="{{ $productionjob->job_code }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="start_code">Start Code</label>
                                        <input type="text" name="start_code" id="start_code" class="form-control" value="{{ $productionjob->start_code }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" min="1" name="quantity" id="quantity" class="form-control" value="{{ $productionjob->quantity }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="Assigned" {{ $productionjob->status == 'Assigned' ? 'selected' : '' }}>Assigned</option>
                                            <option value="Hold" {{ $productionjob->status == 'Hold' ? 'selected' : '' }}>Hold</option>
                                            <option value="Cancel" {{ $productionjob->status == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-custom float-right"> Update</button>
                                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary float-left"> Back</a>
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