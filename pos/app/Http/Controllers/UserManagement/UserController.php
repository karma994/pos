<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Validator;

class UserController extends Controller
{
    use HasRoles;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::all();
        $users = User::orderBy('id', 'DESC')->simplePaginate(5);
        $branches = Branch::all();
        $departments = Department::all();
        return view('UserManagement.user')->with(['roles'=>$roles, 'branches'=>$branches, 'departments'=>$departments,'users'=>$users]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if($request->id == null){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'employee_code' => "BHT/LAMLA/".$request->cid,
                'branch' => $request->branch,
                'department' => $request->department,
                'status' => "active",
                'cid' => $request->cid,
                'contact_no' => $request->contact_no,
                'gender' => $request->gender,
                'date_of_join' => $request->date_of_join,
            ]);
    
            // Assign Roles
            $role = $request->role;
            $assignrole = $user->assignRole($role);
        }
        else{
           User::where('id', $request->id)->update([
               'name' => $request->name,
               'email' => $request->email,
                'password' => bcrypt($request->password),
                'employee_code' => "BHT/LAMLA/".$request->cid,
                'branch' => $request->branch,
                'department' => $request->department,
                'status' => "active",
                'cid' => $request->cid,
                'contact_no' => $request->contact_no,
                'gender' => $request->gender,
                'date_of_join' => $request->date_of_join,
            ]);
            $user = User::where('id', $request->id)->first();
            $user->removeRole($user->getRoleNames()[0]);
           // Assign Roles
           $role = $request->role;
           $user->assignRole($role);
        }
        return redirect('users');
        // return $user->getRoleNames();
        // return $user->->getAllPermissions()
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
        User::where('id',$id)->delete();
        return redirect('users');
    }

    public function checkuser($email){
        if (User::where('email',$email )->exists()) {
            return "yes";
        }
        return "no";
    }
}
