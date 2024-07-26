<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class RoleController extends Controller


{
    public function index()
    {
        $roles = Role::with("users")->paginate(10);
        return view('role-permission.roles.index', compact('roles'));
    }
    public function show()
    {
        
    }
    public function create()
    {
        // if (!Auth::user()->can('create role')) {
        //      return view('dummy.unauthorized');
        // }
        return view('role-permission.roles.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:Roles,name']
        ]);
        Role::create(['name' => $request->name]);
        return redirect('roles')->with('status', 'Role Created Successfully');
    }
    public function edit(Role $role)
    {
        // if (!Auth::user()->can('update role')) {
        //      return view('dummy.unauthorized');
        // }
        return view('role-permission.roles.edit',compact('role'));

    }
    public function update(Request $request,Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:Roles,name']
        ]);
        $role->update(['name' => $request->name]);
        return redirect('roles')->with('status', 'Role Updated Successfully');

    }
    public function destroy($id)
    {
        // if (!Auth::user()->can('delete role')) {
        //      return view('dummy.unauthorized');
        // }
        // $role=Role::find($id);
        // $role->delete();
        // return redirect('roles')->with('status', 'Role Deleted Successfully');

    }
    public function addPermissionToRole($roleid){
        $role=Role::findorFail($roleid);
        $permissions=Permission::get();
        $rolePermissions=DB::table('role_has_permissions')->where('role_has_permissions.role_id',$role->id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        return view('role-permission.roles.add-permissions',compact('role','permissions','rolePermissions'));
    }
    public function givePermissionToRole(Request $request,$roleid){
        $request->validate(['permission'=>'required']);
   $role=Role::findorFail($roleid);
   $role->syncPermissions($request->permission);
        return redirect('roles')->with('status','Permissions Updated');
    }
}
