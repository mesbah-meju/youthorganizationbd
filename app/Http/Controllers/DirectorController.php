<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectorRequest;
use App\Models\BusinessSetting;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Upazila;
use App\Models\User;
use App\Models\UserRole;
use App\Utility\EmailUtility;
use Auth;
use Hash;
use App\Rules\Recaptcha;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_all_director'])->only('index');
        $this->middleware(['permission:add_director'])->only('create');
        $this->middleware(['permission:edit_director'])->only('edit');
        $this->middleware(['permission:delete_director'])->only('destroy');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha') == 1, ['required', new Recaptcha()], ['sometimes'])
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $sort_search = $request->search;
        $division_id = $request->division_id;
        $district_id = $request->district_id;
        $upazila_id = $request->upazila_id;
        $role_id = $request->role_id;

        $divisions = Division::where('status', 1)->orderBy('name', 'asc')->get();
        $districts = District::where('status', 1)->orderBy('name', 'asc')->get();
        $upazilas = Upazila::where('status', 1)->orderBy('name', 'asc')->get();
        $roles = Role::where('user_type', 'directorate')->orderBy('id', 'asc')->get();

        $users = User::leftJoin('user_roles', 'user_roles.user_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'user_roles.role_id')
            ->leftJoin('divisions', 'divisions.id', 'users.division')
            ->leftJoin('districts', 'districts.id', 'users.district')
            ->leftJoin('upazilas', 'upazilas.id', 'users.upazila')
            ->select(
                'users.*',
                'roles.name as role_name',
                'divisions.name as division_name',
                'districts.name as district_name',
                'upazilas.name as upazila_name'
            )
            ->where('users.user_type', 'directorate')->where('users.id', '!=', $user->id);

        if ($request->search) {
            $sort_search = $request->search;
            $users->where('users.name', 'like', '%' . $sort_search . '%');
        }

        if ($request->division_id) {
            $division_id = $request->division_id;
            $districts = District::where('status', 1)->where('division_id', $division_id)->orderBy('name', 'asc')->get();
            $users->where('users.division', $division_id);
        }

        if ($request->district_id) {
            $district_id = $request->district_id;
            $upazilas = Upazila::where('status', 1)->where('district_id', $district_id)->orderBy('name', 'asc')->get();
            $users->where('users.district', $district_id);
        }

        if ($request->upazila_id) {
            $upazila_id = $request->upazila_id;
            $users->where('users.upazila', $upazila_id);
        }

        if ($request->role_id) {
            $role_id = $request->role_id;
            $users->where('user_roles.role_id', $role_id);
        }

        if (isset($user->userrole) && $user->userrole->role_id == 4) {
            if ($user->division) {
                $division_id = $user->division;

                $divisions = Division::where('status', 1)->where('id', $user->division)->orderBy('name', 'asc')->get();
                $districts = District::where('status', 1)->where('division_id', $user->division)->orderBy('name', 'asc')->get();
                $roles = Role::where('user_type', 'directorate')->where('id', '!=', 4)->orderBy('id', 'asc')->get();

                $users->where('users.division', $user->division)->where('user_roles.role_id', '!=', 4);
            }
        }

        if (isset($user->userrole) && $user->userrole->role_id == 5) {
            if ($user->division && $user->district) {
                $division_id = $user->division;
                $district_id = $user->district;

                $divisions = Division::where('status', 1)->where('id', $user->division)->orderBy('name', 'asc')->get();
                $districts = District::where('status', 1)->where('id', $user->district)->orderBy('name', 'asc')->get();
                $upazilas = Upazila::where('status', 1)->where('district_id', $user->district)->orderBy('name', 'asc')->get();
                $roles = Role::where('user_type', 'directorate')->whereNotIn('id', [4, 5])->orderBy('id', 'asc')->get();

                $users->where('users.division', $user->division)->where('users.district', $user->district)->whereNotIn('user_roles.role_id', [4, 5]);
            }
        }

        $users = $users->orderBy('users.id', 'desc')->paginate(15);

        return view('backend.directors.index', compact('users', 'divisions', 'districts', 'upazilas', 'division_id', 'district_id', 'upazila_id', 'roles', 'role_id', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->user_type == 'admin' || $user->user_type == 'developer') {
            $divisions = Division::orderBy('name', 'asc')->get();
        } else {
            $divisions = Division::where('status', 1)->where('id', $user->division)->orderBy('name', 'asc')->get();
        }
        if (isset($user->userrole) && $user->userrole->role_id == 4) {
            $roles = Role::where('user_type', 'directorate')->where('id', '!=', 4)->orderBy('id', 'asc')->get();
        } else if (isset($user->userrole) && $user->userrole->role_id == 4) {
            $roles = Role::where('user_type', 'directorate')->whereNotIn('id', [4, 5])->orderBy('id', 'asc')->get();
        } else {
            $roles = Role::where('user_type', 'directorate')->orderBy('id', 'asc')->get();
        }

        return view('backend.directors.create', compact('roles', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DirectorRequest $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null && User::where('phone', $request->phone)->first() != null) {
                flash(translate('Email or Phone already exists.'));
                return back();
            } else if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email already exists.'));
                return back();
            } else if (User::where('phone', $request->phone)->first() != null) {
                flash(translate('Phone already exists.'));
                return back();
            }
        } else {
            if (User::where('phone', $request->phone)->first() != null) {
                flash(translate('Phone already exists.'));
                return back();
            }
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->division = $request->division_id;
        $user->district = $request->district_id ?? null;
        $user->upazila = $request->upazila_id ?? null;
        $user->user_type = "directorate";
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            $userrole = new UserRole();
            $userrole->user_id = $user->id;
            $userrole->role_id = $request->role_id;
            $user->assignRole(Role::findOrFail($request->role_id)->name);
            if ($userrole->save()) {
                if ($user->email != null) {
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();

                    // Account Create Email to Directors
                    if ($user != null && (get_email_template_data('registration_email_to_customer', 'status') == 1)) {
                        try {
                            EmailUtility::customer_registration_email('registration_email_to_customer', $user, null);
                        } catch (\Exception $e) {
                        }
                    }
                }
            }
        }
        return redirect()->route('directors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $director = User::findOrFail(decrypt($id));
        if (isset($user->userrole) && $user->userrole->role_id == 4) {
            $roles = Role::where('user_type', 'directorate')->where('id', '!=', 4)->orderBy('id', 'asc')->get();
        } else if (isset($user->userrole) && $user->userrole->role_id == 4) {
            $roles = Role::where('user_type', 'directorate')->whereNotIn('id', [4, 5])->orderBy('id', 'asc')->get();
        } else {
            $roles = Role::where('user_type', 'directorate')->orderBy('id', 'asc')->get();
        }

        $divisions = Division::where('status', 1)->where('id', $user->division)->orderBy('name', 'asc')->get();
        $districts = District::where('division_id', $director->division)->where('status', 1)->orderBy('name', 'asc')->get();
        $upazilas = Upazila::where('district_id', $director->district)->where('status', 1)->orderBy('name', 'asc')->get();

        return view('backend.directors.edit', compact('director', 'roles', 'divisions', 'districts', 'upazilas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DirectorRequest $request, $id)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->where('id', '!=', $id)->first() != null && User::where('phone', $request->phone)->where('id', '!=', $id)->first() != null) {
                flash(translate('Email or Phone already exists.'));
                return back();
            } else if (User::where('email', $request->email)->where('id', '!=', $id)->first() != null) {
                flash(translate('Email already exists.'));
                return back();
            } else if (User::where('phone', $request->phone)->where('id', '!=', $id)->first() != null) {
                flash(translate('Phone already exists.'));
                return back();
            }
        } else {
            if (User::where('phone', $request->phone)->where('id', '!=', $id)->first() != null) {
                flash(translate('Phone already exists.'));
                return back();
            }
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->division = $request->division_id;
        $user->district = $request->district_id ?? null;
        $user->upazila = $request->upazila_id ?? null;
        $user->user_type = "directorate";
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
            $user_role = UserRole::where('user_id', $id)->first();
            $user_role->role_id = $request->role_id;
            if ($user_role->save()) {
                $user->syncRoles(Role::findOrFail($request->role_id)->name);
                flash(translate('Director has been updated successfully'))->success();
                return redirect()->route('directors.index');
            }
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (User::destroy($id)) {
            flash(translate('Director has been deleted successfully'))->success();
            return redirect()->route('directors.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Approve the specified resource from storage.
     */
    public function approve($id)
    {
        $user = User::find($id);
        if ($user->is_approved == 1) {
            $user->is_approved = 0;
            $user->save();
            flash(translate('User approved successfully.'))->success();
        } else {
            $user->is_approved = 1;
            $user->save();
            flash(translate('User unapproved successfully.'))->success();
        }
        return redirect()->route('directors.index');
    }

    /**
     * Register a newly created resource in storage.
     */
    public function register(DirectorRequest $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null && User::where('phone', $request->phone)->first() != null) {
                flash(translate('Email or Phone already exists.'));
                return back();
            } else if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email already exists.'));
                return back();
            } else if (User::where('phone', $request->phone)->first() != null) {
                flash(translate('Phone already exists.'));
                return back();
            }
        } else {
            if (User::where('phone', $request->phone)->first() != null) {
                flash(translate('Phone already exists.'));
                return back();
            }
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->division = $request->division_id;
        $user->district = $request->district_id;
        $user->upazila = $request->upazila_id;
        $user->user_type = "directorate";
        $user->is_approved = 0;
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            $userrole = new UserRole();
            $userrole->user_id = $user->id;
            $userrole->role_id = $request->role_id;
            $user->assignRole(Role::findOrFail($request->role_id)->name);

            Auth::login($user, true);

            if ($userrole->save()) {
                if ($user->email != null) {
                    if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
                        $user->email_verified_at = date('Y-m-d H:m:s');
                        $user->save();
                        flash(translate('Registration successful.'))->success();
                        return redirect()->route('admin.dashboard');
                    } else {
                        try {
                            EmailUtility::email_verification($user, 'customer');
                            flash(translate('Registration successful. Please verify your email.'))->success();
                            return redirect()->route('admin.dashboard');
                        } catch (\Throwable $e) {
                            $user->delete();
                            flash(translate('Registration failed. Please try again later.'))->error();
                            return redirect()->route('admin.dashboard');
                        }
                    }

                    // Account Opening Email to customer
                    if ($user != null && (get_email_template_data('registration_email_to_customer', 'status') == 1)) {
                        try {
                            EmailUtility::customer_registration_email('registration_email_to_customer', $user, null);
                        } catch (\Exception $e) {
                        }
                    }
                }

                // customer Account Opening Email to Admin
                if ($user != null && (get_email_template_data('customer_reg_email_to_admin', 'status') == 1)) {
                    try {
                        EmailUtility::customer_registration_email('customer_reg_email_to_admin', $user, null);
                    } catch (\Exception $e) {
                    }
                }
            }
        }
    }
}
