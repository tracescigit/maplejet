@extends('dummy.app_new')

@section('content')
<style>
    .card-header h6 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header a.btn {
        font-size: 14px;
    }

    .form-control {
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }

    .btn-primary:hover {
        background-color: #45a049;
        border-color: #45a049;
    }

    .btn-danger {
        background-color: #f44336;
        border-color: #f44336;
    }

    .btn-danger:hover {
        background-color: #e53935;
        border-color: #e53935;
    }
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
        <div class="col-md-6">
        <div class="card pd-20 mg-t-10 col-11 mx-auto">
                <div class="card-header btn-custom">
                    <h6 class="text-white">Create Roles</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" id="name" value="{{old('name')}}" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                        <button type="submit" class="btn btn-custom float-right"><i class="fas fa-save"></i>Submit</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary float-left"><i class="fas fa-arrow-left"></i>Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
