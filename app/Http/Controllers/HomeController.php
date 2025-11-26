<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Mail;
use Cache;
use Cookie;
use App\Models\Page;
use App\Models\Shop;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Models\AffiliateConfig;
use App\Models\BusinessSetting;
use App\Models\CustomerPackage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\Cart;
use App\Models\District;
use App\Models\Division;
use App\Models\Role;
use App\Models\Upazila;
use App\Models\UserRole;
use App\Utility\EmailUtility;
use Artisan;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use ZipArchive;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $lang = get_system_language() ? get_system_language()->code : null;
        // return redirect()->route('user.registration');

        return view('frontend.' . get_setting('homepage_select') . '.index', compact('lang'));
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('user.registration');
        }

        // if (Auth::user()->user_type == 'organization') {
        //     return redirect()->route('school.dashboard');
        // }

        if (Route::currentRouteName() == 'seller.login' && get_setting('vendor_system_activation') == 1) {
            return view('auth.' . get_setting('authentication_layout_select') . '.seller_login');
        } else if (Route::currentRouteName() == 'deliveryboy.login' && addon_is_activated('delivery_boy')) {
            return view('auth.' . get_setting('authentication_layout_select') . '.deliveryboy_login');
        }
        return view('auth.' . get_setting('authentication_layout_select') . '.user_login');
    }


    public function registration(Request $request)
    {
        if (Auth::check()) {
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'developer' || Auth::user()->user_type == 'directorate') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('organization.dashboard');
            }
            
        }

        $divisions = Division::where('country_id', '18')->orderBy('name', 'asc')->get();
        $roles = Role::where('user_type', 'directorate')->orderBy('id', 'asc')->get();

        return view('auth.' . get_setting('authentication_layout_select') . '.user_registration', compact('divisions','roles'));
    }

    public function store_director(Request $request)
    {
        if(User::where('email', $request->email)->first() == null) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->mobile;
            $user->division = $request->division_id;
            $user->district = $request->district_id;
            $user->upazila = $request->upazila_id;
            $user->user_type = "directorate";
            $user->password = Hash::make($request->password);
            if($user->save()){
                $userrole = new UserRole();
                $userrole->user_id = $user->id;
                $userrole->role_id = $request->role_id;
                $user->assignRole(Role::findOrFail($request->role_id)->name);
                if($userrole->save()){
                    if ($user->email != null) {
                        if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
                            $user->email_verified_at = date('Y-m-d H:m:s');
                            $user->save();
                            flash(translate('Registration successful.'))->success();
                        } else {
                            try {
                                EmailUtility::email_verification($user, 'customer');
                                flash(translate('Registration successful. Please verify your email.'))->success();
                            } catch (\Throwable $e) {
                                $user->delete();
                                flash(translate('Registration failed. Please try again later.'))->error();
                            }
                        }
                    }
            
                    // Customer Account Opening Email to Admin
                    if ($user != null && (get_email_template_data('customer_reg_email_to_admin', 'status') == 1)) {
                        try {
                            EmailUtility::customer_registration_email('customer_reg_email_to_admin', $user, null);
                        } catch (\Exception $e) {
                        }
                    }

                    flash(translate('Director has been inserted successfully'))->success();
                    return redirect()->route('directors.index');
                }
            }
        }

        flash(translate('Email already exists!'))->error();
        return back();
    }

    public function profile(Request $request)
    {
        if (Auth::user()->user_type == 'seller') {
            return redirect()->route('seller.profile.index');
        } elseif (Auth::user()->user_type == 'delivery_boy') {
            return view('delivery_boys.profile');
        } else {
            return view('frontend.user.profile');
        }
    }

    public function userProfileUpdate(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->avatar_original = $request->photo;
        $user->save();

        flash(translate('Your Profile has been updated successfully!'))->success();
        return back();
    }

    public function sellerpolicy()
    {
        $page =  Page::where('type', 'seller_policy_page')->first();
        return view("frontend.policies.sellerpolicy", compact('page'));
    }

    public function returnpolicy()
    {
        $page =  Page::where('type', 'return_policy_page')->first();
        return view("frontend.policies.returnpolicy", compact('page'));
    }

    public function supportpolicy()
    {
        $page =  Page::where('type', 'support_policy_page')->first();
        return view("frontend.policies.supportpolicy", compact('page'));
    }

    public function terms()
    {
        $page =  Page::where('type', 'terms_conditions_page')->first();
        return view("frontend.policies.terms", compact('page'));
    }

    public function privacypolicy()
    {
        $page =  Page::where('type', 'privacy_policy_page')->first();
        return view("frontend.policies.privacypolicy", compact('page'));
    }

    public function verify()
    {
        if (Auth::check() && Auth::user()->is_approved == 1) {
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'developer' || Auth::user()->user_type == 'directorate') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('organization.dashboard');
            }
        }
        return view('auth.'.get_setting('authentication_layout_select').'.verify_status');
    }

    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if (isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = translate('Email already exists!');
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
    }


    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if (isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $user = auth()->user();
        $response['status'] = 0;
        $response['message'] = 'Unknown';
        try {
            EmailUtility::email_verification($user, $user->user_type);
            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");
        } catch (\Exception $e) {
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request)
    {
        if ($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if ($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                auth()->login($user, true);

                flash(translate('Email Changed successfully'))->success();
                if ($user->user_type == 'seller') {
                    return redirect()->route('seller.dashboard');
                }
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');
    }

    public function reset_password_with_code(Request $request)
    {
        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'wellbeing') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            } else {
                flash(translate("Password and confirm password didn't match"))->warning();
                return view('auth.' . get_setting('authentication_layout_select') . '.reset_password');
            }
        } else {
            flash(translate("Verification code mismatch"))->error();
            return view('auth.' . get_setting('authentication_layout_select') . '.reset_password');
        }
    }

    public function import_data(Request $request)
    {
        $upload_path = $request->file('uploaded_file')->store('uploads', 'local');
        $sql_path = $request->file('sql_file')->store('uploads', 'local');

        $zip = new ZipArchive;
        $zip->open(base_path('public/' . $upload_path));
        $zip->extractTo('public/uploads/all');

        $zip1 = new ZipArchive;
        $zip1->open(base_path('public/' . $sql_path));
        $zip1->extractTo('public/uploads');

        Artisan::call('cache:clear');
        $sql_path = base_path('public/uploads/demo_data.sql');
        DB::unprepared(file_get_contents($sql_path));
    }

    public function countryWiseDivision($id)
    {
        $divisions = Division::where('country_id', $id)->orderBy('name', 'asc')->get();
        $options = '<option value="">' . 'Select a division' . '</option>';
        foreach ($divisions as $division) {
            $options .= '<option value="' . $division->id . '">' . $division->name . '</option>';
        }
        return $options;
    }

    public function divisionWiseDistrict($id)
    {
        $districts = District::where('division_id', $id)->orderBy('name', 'asc')->get();
        $options = '<option value="">' . 'Select a district' . '</option>';
        foreach ($districts as $district) {
            $options .= '<option value="' . $district->id . '">' . $district->name . '</option>';
        }
        return $options;
    }

    public function districtWiseUpazila($id)
    {
        $upazilas = Upazila::where('district_id', $id)->orderBy('name', 'asc')->get();
        $options = '<option value="">' . 'Select a upazila' . '</option>';
        foreach ($upazilas as $upazila) {
            $options .= '<option value="' . $upazila->id . '">' . $upazila->name . '</option>';
        }
        return $options;
    }
}
