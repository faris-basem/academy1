<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function show_users(Request $request)
    {
        $data = Admin::orderBy('id', 'DESC')->paginate(5);
        return view('users.show_users', compact('data'));
    }

    public function add_user()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.Add_user', compact('roles'));
    }

    public function store_user(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required',
            'roles_name' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['roles_name'] = json_encode($input['roles_name']);
        $user = Admin::create($input);
        $user->assignRole($request->input('roles_name'));    
        return redirect()->route('show_users')
            ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = Admin::find($id);
        return view('users.show', compact('user'));
    }

    public function edit_user($id)
    {
        $user = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'required',
            'roles_name' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user = Admin::find($request->id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('show_users')
            ->with('success', 'User updated successfully');
    }

    public function delete_user(Request $request)
    {
        Admin::find($request->user_id)->delete();
        return redirect()->route('show_users')
            ->with('success', 'User deleted successfully');
    }
}
