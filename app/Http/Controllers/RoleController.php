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
            'name' => ['required', 'string', 'unique:roles,name']
        ]);
        Role::create(['name' => $request->name]);
        return redirect('roles')->with('status', 'Role Created Successfully');
    }
    public function edit(Role $role)
    {
        // if (!Auth::user()->can('update role')) {
        //      return view('dummy.unauthorized');
        // }
        return view('role-permission.roles.edit', compact('role'));
    }
    public function update(Request $request, Role $role)
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
    public function addPermissionToRole($roleid)
    {
        $role = Role::findorFail($roleid);
        $permissions_name = Permission::select('name')->get();
        $permissions = Permission::get();
        $permissionsArray = [];
        foreach ($permissions as $permission) {
            if (isset($permission['id'])) { // Ensure 'id' exists
                $permissionsArray[$permission['id']] = $permission->name;
            }
        }
        // Define action prefixes
        $actionPrefixes = ['view ', 'create ', 'update '];

        // Process permissions to remove action prefixes
        $cleanedPermissions = $permissions_name->map(function ($permission) use ($actionPrefixes) {
            $name = strtolower(trim($permission->name));
            foreach ($actionPrefixes as $prefix) {
                if (str_starts_with($name, $prefix)) {
                    // Remove the prefix from the permission name
                    return trim(substr($name, strlen($prefix)));
                }
            }
            // Return the name as is if no prefix is matched
            return $name;
        })->unique(); // Get unique names

        // Convert to array if needed
        $uniquePermissionNames = $cleanedPermissions->values()->all();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $role->id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        $rolePermissions_name = DB::table('role_has_permissions')
        ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
        ->where('role_has_permissions.role_id', $role->id)
        ->pluck('permissions.name', 'role_has_permissions.permission_id')
        ->all();
        return view('role-permission.roles.add-permissions', compact('role', 'permissions', 'rolePermissions', 'uniquePermissionNames','permissionsArray','rolePermissions_name'));
    }
    public function givePermissionToRole(Request $request, $roleid)
    {
        $request->validate(['permission' => 'required']);
        $role = Role::findorFail($roleid);
        $role->syncPermissions($request->permission);
        return redirect('roles')->with('status', 'Permissions Updated');
    }
}
