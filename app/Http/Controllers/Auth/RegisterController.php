<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\OTPVerificationController;
use App\Models\District;
use App\Models\Division;
use App\Models\Organization;
use App\Models\Upazila;
use App\Utility\EmailUtility;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha') == 1, ['required', new Recaptcha()], ['sometimes'])
            ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $organization = new Organization();
            $organization->user_id = $user->id;
            $organization->org_name_en = $data['organization_name'];
            $organization->save();

            if (addon_is_activated('otp_system')) {
                $otpController = new OTPVerificationController;
                $otpController->send_code($user);
            }
        } else {
            if (addon_is_activated('otp_system')) {
                $user = User::create([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'verification_code' => rand(100000, 999999)
                ]);

                $organization = new Organization();
                $organization->user_id = $user->id;
                $organization->org_name_en = $data['organization_name'];
                $organization->save();

                $otpController = new OTPVerificationController;
                $otpController->send_code($user);
            }
        }

        return $user;
    }

    public function register(Request $request)
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

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

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

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        if ($user->email == null) {
            return redirect()->route('verification');
        } elseif (session('link') != null) {
            return redirect(session('link'));
        } else {
            return redirect()->route('organization.dashboard');
        }
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
