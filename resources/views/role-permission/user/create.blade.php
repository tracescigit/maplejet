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

    .select2-container {
        width: 100% !important;
    }

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
                        <h4 id="section3" class="mg-b-10 text-dark" style="font-weight:bolder;">Add new User</h4>
                        <p class="mg-b-30">Use this page to add <code style="color:#e300be;">NEW</code> User.</p>
                        <hr>
                    </div>


                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" value="{{old('name')}}" name="name" class="form-control" />
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"  value="{{old('email')}}" class="form-control" />
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control" />
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <select name="role" id="role" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Active" {{ old('status') == "Active" ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == "Inactive" ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                        <button type="submit" class="btn btn-custom float-right">Submit</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary float-left">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Roles",
            allowClear: true,
            closeOnSelect: false
        });
    });
</script>
@endpush