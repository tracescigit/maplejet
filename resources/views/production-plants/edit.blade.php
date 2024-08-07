@extends('dummy.app_new')

@section('content')
<style>
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
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
        <div class="col-lg-8">
        <div class="card pd-20 mg-t-8 col-11 mx-auto">
               
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-primary" style="font-weight:bold;">Edit Prod.line</h4>
                        <p class="mg-b-30">Use this page to  <code>Edit</code> Prod.plant</p>
                        <hr>
                    </div>


                </div>
               
                <div class="card-body">
                    <form method="POST" action="{{ route('production-plants.update', $productionplant->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $productionplant->name }}">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" value="{{ $productionplant->code }}">
                                    @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" {{ $productionplant->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $productionplant->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <button type="submit" class="btn btn-custom float-right"><i class="fas fa-save"></i> Save Changes</button>
                                <a href="{{ route('production-plants.index') }}" class="btn btn-secondary float-left"><i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
