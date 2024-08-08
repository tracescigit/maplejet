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
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card pd-20 mg-t-8 col-11 mx-auto">
                <div class="card-header btn-custom">
                    <h5 class="m-0 text-white">Edit Permission
                       
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Permission Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $permission->name }}" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom float-right"><i class="fas fa-save"></i>Update</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary float-left"><i class="fas fa-arrow-left"></i>Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
