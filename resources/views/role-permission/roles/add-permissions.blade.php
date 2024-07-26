@extends('dummy.app_new')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
        @if(session('status'))
            <div id="statusMessage" class="alert alert-success">{{session('status')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h6 style="margin:auto;">Role :{{$role->name}}
                        <a href="{{route('roles.index')}}" class="btn btn-danger float-right mr-4">Back</a>
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{route('manageroles',$role->id)}}" method="Post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            @error('permission')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <label for="">Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-2">
                                    <label>
                                        <input type="checkbox" name="permission[]"  value="{{$permission->name}}" {{in_array($permission->id,$rolePermissions)? 'checked':''}}/>
                                        <b>{{$permission->name}}</b>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
