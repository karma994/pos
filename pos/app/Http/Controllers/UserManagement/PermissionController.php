<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('UserManagement.permission');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->permission_name;
        $permission->type = $request->type;
        if ($permission->save()) {
            return response()->json('Success');
        } else {
            return response()->json('Error');
        }
    }

    public function show($id)
    {
        $permissions = Permission::find($id);
        return response()->json($permissions);
    }

    public function edit($id)
    {
        $permissions = Permission::find($id);
        return response()->json($permissions);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'permission_name' => 'required|min:3',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->permission_name;
        if ($permission->save()) {
            return response()->json('Success');
        } else {
            return response()->json('Error');
        }
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        if ($permission->delete()) {
            return response()->json('Success');
        } else {
            return response()->json('Error');
        }
    }
}
