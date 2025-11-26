<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Classes;
use App\Models\ClassShift;
use App\Models\Coordinator;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\School;
use App\Models\Section;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\Models\UserRole;
use App\Utility\EmailUtility;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Yajra\DataTables\Facades\DataTables;

class CoordinatorController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:view_all_coordinators'])->only('index');
        // $this->middleware(['permission:add_coordinator'])->only('create');
        // $this->middleware(['permission:edit_coordinator'])->only('edit');
        // $this->middleware(['permission:delete_coordinator'])->only('destroy');
        // $this->middleware(['permission:login_as_coordinator'])->only('login');
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $school_id)
    {
        // Retrieve coordinators for the specific school
        $coordinators = Coordinator::with(['user', 'campus', 'shift', 'class', 'section'])
            ->where('school_id', $school_id)
            ->orderBy('id', 'desc')
            ->get();
        // Handle the AJAX request from DataTable
        if ($request->ajax()) {
            return DataTables::of($coordinators)
                ->addColumn('actions', function ($coordinator) {
                    return '
                        <a href="' . route("coordinators.login", encrypt($coordinator->id)) . '" class="btn btn-soft-success btn-icon btn-circle btn-sm" title="' . translate("Login as Coordinator") . '">
                            <i class="las la-sign-in-alt"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-soft-warning btn-icon btn-circle btn-sm" onclick="showAddEditCoordinatorForm(' . $coordinator->id . ', ' . $coordinator->school_id . ')" title="' . translate('Edit') . '">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="' . route("coordinators.destroy", $coordinator->id) . '" title="' . translate('Delete') . '">
                            <i class="las la-trash"></i>
                        </a>
                    ';
                })
                ->addColumn('role', function ($coordinator) {
                    return ($coordinator->user && $coordinator->user->userrole) ? $coordinator->user->userrole->role->getTranslation('name') : 'N/A';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        // Return view with school_id to pass to the front-end
        return view('backend.school.coordinators.index', compact('school_id', 'coordinators'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create($school_id)
    {
        $schools = School::where('id', $school_id)->whereNull('deleted_at')->get();
        $campuses = Campus::where('school_id', $school_id)->get();
        $roles = Role::where('user_type', 'school')->orderBy('id', 'asc')->get();

        return view('backend.school.coordinators.create', compact('schools', 'campuses', 'roles'))->render();
    }

    public function store(Request $request, $school_id)
    {
        // dd($request->all());
        // Custom validation rules
        $request->validate(
            [
                'name' => 'required|max:255',
                'phone' => 'required|unique:users',
                'email' => 'nullable|email|unique:users',
                'address' => 'max:500',
                // 'campus_id' => 'required|integer',
                // 'shift_id' => 'required|integer',
                // 'class_id' => 'required|integer',
                // 'section_id' => 'required|integer',
            ],
            [
                'name.required' => translate('Name is required'),
                'name.max' => translate('Max 255 characters allowed'),
                'email.email' => translate('Email must be valid'),
                'email.unique' => translate('An user exists with this email'),
                'phone.required' => translate('Phone is required'),
                'phone.unique' => translate('A user exists with this phone number'),
                'address.max' => translate('Max 500 characters allowed'),
                // 'campus_id.required' => translate('Campus is required'),
                // 'shift_id.required' => translate('Shift is required'),
                // 'class_id.required' => translate('Class is required'),
                // 'section_id.required' => translate('Section is required'),
            ]
        );

        $schools = School::where('id', $school_id)->whereNull('deleted_at')->get();

        // Check for an existing coordinator
        $existingCoordinator = Coordinator::where('school_id', $school_id)
            ->where('campus_id', $request->campus_id)
            ->where('shift_id', $request->shift_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->first();

        if ($existingCoordinator) {
            return response()->json([
                'error' => true,
                'status' => 'warning',
                'message' => 'A coordinator already exists for the selected school, campus, shift, class, and section.',
            ]);
        }

        // Default Password
        $password = "123456";

        // Create new User
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->user_type = "school";
        $user->password = Hash::make($password);
        $user->verification_code = rand(100000, 999999);

        if ($user->save()) {
            // Assign Role
            $userrole = new UserRole();
            $userrole->user_id = $user->id;
            $userrole->role_id = $request->role_id;
            $user->assignRole(Role::findOrFail($request->role_id)->name);
            $userrole->save();

            // Create Coordinator
            $coordinator = new Coordinator();
            $coordinator->user_id = $user->id;
            $coordinator->school_id = $request->school_id;
            $coordinator->campus_id = $request->campus_id;
            $coordinator->shift_id = $request->shift_id;
            $coordinator->class_id = $request->class_id;
            $coordinator->section_id = $request->section_id;
            $coordinator->save();

            // Send Verification Email
            if (get_setting('email_verification') == 1) {
                $user->email_verified_at = now();
                $user->save();
            } else {
                EmailUtility::email_verification($user, 'school');
            }

            return response()->json([
                'success' => true,
                'message' => 'Coordinator saved successfully',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Something went wrong. Please try again.',
        ], 500);
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
    public function edit($id, $school_id)
    {
        $coordinator = Coordinator::where('school_id', $school_id)->findOrFail($id);

        $roles = Role::where('user_type', 'school')->orderBy('id', 'asc')->get();
        $schools = School::where('id', $school_id)->whereNull('deleted_at')->get();
        $campuses = Campus::where('school_id', $coordinator->school_id)->get();
        $shifts = Shift::where('school_id', $coordinator->school_id)->get();
        $classes = Classes::where('school_id', $coordinator->school_id)->get();
        $sections = Section::where('class_id', $coordinator->class_id)->get();

        return view('backend.school.coordinators.edit', compact('school_id', 'coordinator', 'roles', 'schools', 'campuses', 'shifts', 'classes', 'sections'));
    }

    public function update(Request $request, $id, $school_id)
    {
        $coordinator = Coordinator::findOrFail($id);

        $existingCoordinator = Coordinator::where('school_id', $school_id)
            ->where('campus_id', $request->campus_id)
            ->where('shift_id', $request->shift_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existingCoordinator) {
            flash(translate('A coordinator already exists for the selected school, campus, shift, class, and section.'))->error();
            return back();
        }

        $user = User::findOrFail($coordinator->user_id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->user_type = "school";

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $userrole = UserRole::firstOrNew(['user_id' => $user->id]);
        $userrole->role_id = $request->role_id;
        $userrole->save();

        $coordinator->school_id = $school_id;

        if ($request->role_id == 4) {
            $coordinator->campus_id = $request->campus_id;
            $coordinator->shift_id = $request->shift_id;
            $coordinator->class_id = $request->class_id;
            $coordinator->section_id = $request->section_id;
        }

        $coordinator->save();

        flash(translate('Coordinator has been updated successfully'))->success();
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $coordinator = Coordinator::findOrFail($id);

        User::destroy($coordinator->user->id);

        if (Coordinator::destroy($id)) {
            flash(translate('Coordinator has been deleted successfully'))->success();
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function login($id)
    {
        $coordinator = Coordinator::findOrFail(decrypt($id));
        $user  = $coordinator->user;

        Session::put('school_id', $coordinator->school_id);
        Auth::login($user, true);

        return redirect()->route('school.dashboard');
    }

    public function getClassSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();

        return response()->json($sections);
    }

    public function getClassesByCampus($campus_id)
    {
        $classes = Classes::where('campus_id', $campus_id)->get();
        $options = '<option value="">' . translate('Select Class') . '</option>';
        foreach ($classes as $class) {
            $options .= '<option value="' . $class->id . '">' . $class->name . '</option>';
        }
        return response()->json(['options' => $options]);
    }

    public function getClassesByShift($shift_id)
    {
        // Get class IDs related to the selected shift
        $classIds = ClassShift::where('shift_id', $shift_id)->pluck('class_id');

        // Fetch the classes using the class IDs
        $classes = Classes::whereIn('id', $classIds)->get();

        $options = '<option value="">Select a class</option>';
        foreach ($classes as $class) {
            $options .= '<option value="' . $class->id . '">' . $class->name . '</option>';
        }

        return response()->json(['options' => $options]);
    }



    public function campus_wise_shift($id)
    {
        $shifts = Shift::where('campus_id', $id)->get();
        $options = '<option value="">' . 'Select a shift' . '</option>';
        foreach ($shifts as $shift) {
            $options .= '<option value="' . $shift->id . '">' . $shift->name . '</option>';
        }
        echo $options;
    }
    public function classWiseSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        $options = '<option value="">Select a section</option>';
        foreach ($sections as $section) {
            $options .= '<option value="' . $section->id . '">' . $section->name . '</option>';
        }
        return response()->json(['options' => $options]);
    }
}
