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
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">Edit User</h4>
                        <p class="mg-b-30">Use this page to  <code style="color:#e300be;">Edit</code> User.</p>
                        <hr>
                    </div>


                </div>
              
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="roles">Roles</label>
                         
                            <select name="roles" id="role" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{$userroles==$role->name?'selected':''}}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mt-4">
                        <button type="submit" class="btn btn-custom float-right">Update</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary float-left">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection