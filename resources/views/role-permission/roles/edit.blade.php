@extends('dummy.app_new')

@section('content')
<style>
     .btn-custom {
        background: #b70a9b !important;
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
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
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bold;">Edit Role</h4>
                        <p class="mg-b-30">Use this page to <code style="color:#e300be;">Edit</code> Role.</p>
                        <hr>
                    </div>


                </div>
                                       <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $role->name }}" required>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-custom float-right">Update</button>
                            <a href="{{ route('roles.index')}}" class="btn btn-secondary float-left">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
