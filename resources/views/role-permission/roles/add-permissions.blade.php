@extends('dummy.app_new')

@section('content')
<div class="content content-components">
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
                    <!-- <form action="{{route('manageroles',$role->id)}}" method="Post">
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
                                        <input type="checkbox" name="permission[]" value="{{$permission->name}}" {{in_array($permission->id,$rolePermissions)? 'checked':''}} />
                                        <b>{{$permission->name}}</b>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form> -->
                    <div class="card-body col-10">
                        <form action="{{route('manageroles',$role->id)}}" method="Post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="" name="role_id">
                            <input type="hidden" value="update_role" name="action">

                            <div class="table-responsive">
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th class="fw-bolder">Module Permission</th>
                                            <th class="text-center fw-bolder">View</th>
                                            <th class="text-center fw-bolder">Create</th>
                                            <th class="text-center fw-bolder">Update</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($uniquePermissionNames as $permission)
                                        <tr>
                                            <td>
                                                <i class="ti-folder">{{ucfirst($permission)}}</i>
                                                <input type="hidden" value="" name="module_id[]">
                                            </td>
                                            <td class="text-center">
                                                <input class="access_module" type="checkbox" name="permission[]" value="view {{ $permission }}" {{ in_array("view {$permission}", $rolePermissions_name) ? 'checked' : '' }} {{ !in_array("view {$permission}", $permissionsArray) ? 'disabled' : '' }}>


                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="permission[]" value="create {{$permission}}" {{ in_array("create {$permission}", $rolePermissions_name) ? 'checked' : '' }} {{ !in_array("create {$permission}", $permissionsArray) ? 'disabled' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="permission[]" value="update {{$permission}}" {{ in_array("update {$permission}", $rolePermissions_name) ? 'checked' : '' }} {{ !in_array("update {$permission}", $permissionsArray) ? 'disabled' : '' }}>
                                            </td>

                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection