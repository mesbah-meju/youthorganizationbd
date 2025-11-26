<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use Hash;

class StaffController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:view_all_users'])->only('index');
        $this->middleware(['permission:add_user'])->only('create');
        $this->middleware(['permission:edit_user'])->only('edit');
        $this->middleware(['permission:delete_user'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $email = $request->email;
        $phone = $request->phone;
    
        $users = User::leftJoin('user_roles', 'user_roles.user_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'user_roles.role_id')
            ->select('users.*', 'roles.name as role_name')
            ->where('roles.name', '!=', 'System Engineer');
    
        if ($email) {
            $users->where('users.email', 'like', "%$email%");
        }
    
        if ($phone) {
            $users->where('users.phone', 'like', "%$phone%");
        }
    
        $users = $users->paginate(10);
    
        return view('backend.staff.staffs.index', compact('users', 'email', 'phone'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->user_type == 'developer') {
            $roles = Role::whereIn('user_type', ['developer','admin'])->orderBy('id', 'desc')->get();
        } else {
            $roles = Role::where('user_type', 'admin')->orderBy('id', 'desc')->get();
        }
        
        return view('backend.staff.staffs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::where('email', $request->email)->first() == null){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->mobile;
            $user->user_type = "wellbeing";
            $user->password = Hash::make($request->password);
            if($user->save()){
                $userrole = new UserRole();
                $userrole->user_id = $user->id;
                $userrole->role_id = $request->role_id;
                $user->assignRole(Role::findOrFail($request->role_id)->name);
                if($userrole->save()){
                    flash(translate('User has been inserted successfully'))->success();
                    return redirect()->route('users.index');
                }
            }
        }

        flash(translate('Email already used'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail(decrypt($id));
        
        if($user->user_type == "admin") {
            $roles = $roles = Role::where('user_type', 'admin')->orderBy('id', 'desc')->get();
        } elseif($user->user_type == "directorate") {
            $roles = $roles = Role::where('user_type', 'directorate')->orderBy('id', 'desc')->get();
        } elseif($user->user_type == "directorate") {
            $roles = $roles = Role::where('user_type', 'directorate')->orderBy('id', 'desc')->get();
        } else {
            $roles = $roles = Role::where('user_type', 'developer')->orderBy('id', 'desc')->get();
        }
        
        return view('backend.staff.staffs.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        if(strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if($user->save()){
            $user_role = UserRole::where('user_id',$id)->first();
            $user_role->role_id = $request->role_id;
            if($user_role->save()){
                $user->syncRoles(Role::findOrFail($request->role_id)->name);
                flash(translate('User has been updated successfully'))->success();
                return redirect()->route('users.index');
            }
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::destroy($id)){
            flash(translate('User has been deleted successfully'))->success();
            return redirect()->route('users.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
}
