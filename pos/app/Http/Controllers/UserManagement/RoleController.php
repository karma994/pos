<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('UserManagement.role')->with(['permissions'=>$permissions,'roles'=>$roles]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->role_name;
        $permissions = $request->permissions;
        $role->syncPermissions($permissions);

        if ($role->save()) {
            return redirect('roles');
        } else {
            return response()->json('Error');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Role::where('id',$id)->delete();
        return redirect('roles');
    }
}
