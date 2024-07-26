<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('role-permission.permission.index', compact('permissions'));
    }
    public function show()
    {
        
    }
    public function create()
    {
        // if (!Auth::user()->can('create permission')) {
        //      return view('dummy.unauthorized');
        // }
        return view('role-permission.permission.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name']
        ]);
        Permission::create(['name' => $request->name]);
        return redirect('permissions')->with('status', 'Permission Created Successfully');
    }
    public function edit(Permission $permission)
    {
        // if (!Auth::user()->can('update permission')) {
        //      return view('dummy.unauthorized');
        // }
        return view('role-permission.permission.edit',compact('permission'));

    }
    public function update(Request $request,Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name']
        ]);
        $permission->update(['name' => $request->name]);
        return redirect('permissions')->with('status', 'Permission Updated Successfully');

    }
    public function destroy($id)
    {
        // if (!Auth::user()->can('delete permission')) {
        //      return view('dummy.unauthorized');
        // }
        // $permission=Permission::find($id);
        // $permission->delete();
        // return redirect('permissions')->with('status', 'Permission Deleted Successfully');

    }
  
}
