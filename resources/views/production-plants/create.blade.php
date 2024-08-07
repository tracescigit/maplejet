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
        <div class="card pd-20 mg-t-10 col-11 mx-auto">
                
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-primary" style="font-weight:bold;">Add new prod.Plant</h4>
                        <p class="mg-b-30">Use this page to add <code>NEW</code> Prod.Plant</p>
                        <hr>
                    </div>
                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('production-plants.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span style="color: red;">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter plant name"value="{{ old('name')}}">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Code <span style="color: red;">*</span></label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Enter plant code" value="{{ old('code')}}">
                                    @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status <span style="color: red;">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" {{ old('status') == "Active"? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status') == "InActive" ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('production-plants.index') }}" class="btn btn-secondary float-left">
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
