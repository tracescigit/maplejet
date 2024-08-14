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
        <div class="col-md-10">
        <div class="container">
                
                <div class="d-flex bg-gray-10">
                    <div class="pd-10 flex-grow-1">
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">Edit Permission</h4>
                        <p class="mg-b-30">Use this page to  <code>Edit</code> permission.</p>
                        <hr>
                    </div>


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
                            <button type="submit" class="btn btn-custom float-right">Update</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary float-left">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
