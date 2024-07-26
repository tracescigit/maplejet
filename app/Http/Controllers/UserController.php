<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function index()
    {
        // if (!Auth::user()->can('view user')) {
        //      return view('dummy.unauthorized');
        // }
        $users = User::paginate(10);
        return view('role-permission.user.index', compact('users'));
    }
    public function create()
    {
        // if (!Auth::user()->can('create user')) {
        //      return view('dummy.unauthorized');
        // }
        $roles = Role::get();
        return view('role-permission.user.create', compact('roles'));
    }
    public function store(Request $request)
    {
        // if (Auth::user()->email=='admin@tracesci.in' ||!Auth::user()->can('create user')) {
        //      return view('dummy.unauthorized');
        // }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min :8|max:25',
            'roles' => 'required',
            'status'=>'required'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,

        ]);
        $user->syncRoles($request->roles);
        return redirect()->route('users.index')->with('status', 'User created successfully.');
    }
    public function edit(User $user)
    {
        // if (!Auth::user()->can('update user')) {
        //      return view('dummy.unauthorized');
        // }
        $roles = Role::get();
        $userroles = $user->roles->pluck('name')->first();
        return view('role-permission.user.edit', compact('user', 'roles', 'userroles'));
    }
    public function update(Request $request, User $user)
    {
        // if (!Auth::user()->can('update user')) {
        //      return view('dummy.unauthorized');
        // }
        $request->validate([
            'name' => 'required|string|max:255',
            'password'=>'nullable|string|min:8|max:20',
            'roles' => 'required',
            'status'=>'required'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ];
        if (!empty($request->password)) {
            $data += ['password' => Hash::make($request->password),];
        }
        $user->update($data);
        $user->syncRoles(($request->roles));
        return redirect('users')->with('status', 'User Updated Successfully');
    }
    public function destroy($userid)
    {
        // if (!Auth::user()->can('delete user')) {
        //      return view('dummy.unauthorized');
        // }
        // $user = User::findorFail($userid);
        // $user->delete();
        // return redirect('users')->with('status', 'User Deleted Successfully');
    }
}
