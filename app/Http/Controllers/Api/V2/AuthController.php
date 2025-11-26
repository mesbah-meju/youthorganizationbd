<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Models\BusinessSetting;
use App\Models\ConfigFcm;
use App\Models\Doctor;
use App\Models\Parents;
use App\Models\Student;
use App\Models\User;
use App\Notifications\AppEmailVerificationNotification;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;
use Socialite;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Carbon\Carbon;


class AuthController extends Controller
{
    public $first_time =  false;

    public function signup(Request $request)
    {
        $messages = array(
            'user_type.required' => translate('User type is required'),
            'user_type.in' => translate('Invalid user type selected'),
            'name.required' => translate('Name is required'),
            'phone.required' => translate('Phone is required'),
            'phone.numeric' => translate('Phone must be a number.'),
            'phone.unique' => translate('The phone has already been taken'),
            'email.required' => translate('Email is required'),
            'email.email' => translate('Invalid email format'),
            'email.unique' => translate('The email has already been taken'),
            'password.required' => translate('Password is required'),
            'password.confirmed' => translate('Password confirmation does not match'),
            'password.min' => translate('Minimum 6 digits required for password')
        );

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:doctor,parent,student',
            'name' => 'required',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|numeric|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha') == 1, ['required', new Recaptcha()], ['sometimes'])
            ]
        ], $messages);

        if ($validator->fails()) {
            // Combine all validation error messages into a single string
            $errorMessages = implode(' ', $validator->errors()->all());

            return response()->json([
                'result' => false,
                'message' => $errorMessages // Return as a single string
            ]);
        }

        $user = new User();
        $user->user_type = $request->user_type;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email ?? null;
        $user->password = bcrypt($request->password);
        $user->verification_code = rand(100000, 999999);

        if ($user->save()) {
            $config_fcm = new ConfigFcm();
            $config_fcm->user_id = $user->id;
            $config_fcm->device_type = $request->device_type;
            $config_fcm->token = $request->fcm_token;
            $config_fcm->save();

            if ($user->user_type == 'doctor') {
                $doctor = new Doctor();
                $doctor->user_id = $user->id;
                $doctor->save();

                $userrole = new UserRole();
                $userrole->user_id = $user->id;
                $userrole->role_id = 5;
                $user->assignRole(Role::findOrFail(5)->name);
                $userrole->save();
            } elseif ($user->user_type == 'parent') {
                $parent = new Parents();
                $parent->user_id = $user->id;
                $parent->save();

                $userrole = new UserRole();
                $userrole->user_id = $user->id;
                $userrole->role_id = 6;
                $user->assignRole(Role::findOrFail(6)->name);
                $userrole->save();
            } elseif ($user->user_type == 'student') {
                $student = new Student();
                $student->user_id = $user->id;
                $student->save();

                $userrole = new UserRole();
                $userrole->user_id = $user->id;
                $userrole->role_id = 7;
                $user->assignRole(Role::findOrFail(7)->name);
                $userrole->save();
            }
        }

        $user->email_verified_at = null;
        if ($user->email != null && BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
        }

        if ($user->email_verified_at == null) {
            if ($request->register_by == 'email') {
                try {
                    $user->notify(new AppEmailVerificationNotification());
                } catch (\Exception $e) {
                }
            } else {
                $otpController = new OTPVerificationController();
                $otpController->send_code($user);
            }
        }

        return response()->json([
            'result' => true,
            'message' => "Sign Up Successful. Please check your email for verification.",
            'data' => $user
        ]);
    }

    public function verification_confirmation(Request $request, $id)
    {
        $user = User::where('id', $id)->where('verification_code', $request->verification_code)->first();
        if ($user != null) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            $user->createToken('tokens')->plainTextToken;

            return $this->loginSuccess($user);
        } else {
            return response()->json([
                'result' => false,
                'message' => "Sorry, we could not verifiy you. Please try again.",
            ]);
        }
    }

    public function resendCode()
    {
        $user = Auth::user();
        $user->verification_code = rand(100000, 999999);

        if ($user->email) {
            try {
                $user->notify(new AppEmailVerificationNotification());
            } catch (\Exception $e) {
            }
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();

        return response()->json([
            'result' => true,
            'message' => translate('Verification code is sent again'),
        ], 200);
    }

    public function confirmCode(Request $request)
    {
        $user = User::where('email', $request->email_or_phone)
            ->orWhere('phone', $request->email_or_phone)
            ->first();

        $config_fcm = new ConfigFcm();

        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_code = null;
            $user->save();

            $user->createToken('tokens')->plainTextToken;

            return $this->loginSuccess($user);
        } else {
            return response()->json([
                'result' => false,
                'message' => translate('Code does not match, you can request for resending the code'),
            ], 200);
        }
    }

    public function login(Request $request)
    {

        $messages = [
            'email.required' => $request->login_by == 'email' ? translate('Email is required') : translate('Phone is required'),
            'email.email' => translate('Email must be a valid email address'),
            'email.numeric' => translate('Phone must be a number.'),
            'password.required' => translate('Password is required'),
        ];

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'login_by' => 'required',
            'email' => [
                'required',
                Rule::when($request->login_by === 'email', ['email', 'required']),
                Rule::when($request->login_by === 'phone', ['numeric', 'required']),
            ]
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $doctor_condition = null;
        $parent_condition = null;
        $req_email = $request->email;

        $check = User::where('email', $req_email)->orWhere('phone', $req_email)->first();

        if($check){
            if($check->user_type == 'doctor'){
                $doctor_condition = $check->user_type;
            }else if($check->user_type == 'parent'){
                $parent_condition = $check->user_type;
            }
        }


        if ($doctor_condition) {
            $user = User::whereIn('user_type', ['doctor'])
                ->where(function ($query) use ($req_email) {
                    $query->where('email', $req_email)
                        ->orWhere('phone', $req_email);
                })
                ->first();
        } elseif ($parent_condition) {
            $user = User::whereIn('user_type', ['parent'])
                ->where(function ($query) use ($req_email) {
                    $query->where('email', $req_email)
                        ->orWhere('phone', $req_email);
                })
                ->first();

            if ($user && $user->status == 0) {
                return response()->json([
                    'result' => false,
                    'message' => translate('Not primary login, try to login by your primary user'),
                    'user' => null,
                ], 401);
            }
        } else {
            $user = User::whereIn('user_type', ['developer', 'admin', 'doctor', 'student', 'parent'])
                ->where(function ($query) use ($req_email) {
                    $query->where('email', $req_email)
                        ->orWhere('phone', $req_email);
                })
                ->first();
        }

        if ($user != null) {
            if (!$user->banned) {
                if (Hash::check($request->password, $user->password)) {
                    $config_fcm = ConfigFcm::where('user_id', $user->id)
                        ->where('device_type', $request->device_type)
                        ->first();

                    if (!$config_fcm) {
                        $this->first_time = true;
                    }

                    if ($config_fcm) {
                        $config_fcm->user_id = $user->id;
                        $config_fcm->device_type = $request->device_type;
                        $config_fcm->token = $request->fcm_token;
                    } else {
                        $config_fcm = new ConfigFcm();
                        $config_fcm->user_id = $user->id;
                        $config_fcm->device_type = $request->device_type;
                        $config_fcm->token = $request->fcm_token;
                    }
                    $config_fcm->save();

                    return $this->loginSuccess($user, '');
                } else {
                    return response()->json([
                        'result' => false,
                        'message' => translate('Unauthorized'),
                        'user' => null,
                    ], 401);
                }
            } else {
                return response()->json([
                    'result' => false,
                    'message' => translate('User is banned'),
                    'user' => null,
                ], 401);
            }
        } else {
            return response()->json([
                'result' => false,
                'message' => translate('User not found'),
                'user' => null,
            ], 401);
        }
    }
    
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged out')
        ]);
    }

    public function socialLogin(Request $request)
    {
        if (!$request->provider) {
            return response()->json([
                'result' => false,
                'message' => translate('User not found'),
                'user' => null
            ]);
        }

        switch ($request->social_provider) {
            case 'facebook':
                $social_user = Socialite::driver('facebook')->fields([
                    'name',
                    'first_name',
                    'last_name',
                    'email'
                ]);
                break;
            case 'google':
                $social_user = Socialite::driver('google')
                    ->scopes(['profile', 'email']);
                break;
            case 'twitter':
                $social_user = Socialite::driver('twitter');
                break;
            case 'apple':
                $social_user = Socialite::driver('sign-in-with-apple')
                    ->scopes(['name', 'email']);
                break;
            default:
                $social_user = null;
        }
        if ($social_user == null) {
            return response()->json(['result' => false, 'message' => translate('No social provider matches'), 'user' => null]);
        }

        if ($request->social_provider == 'twitter') {
            $social_user_details = $social_user->userFromTokenAndSecret($request->access_token, $request->secret_token);
        } else {
            $social_user_details = $social_user->userFromToken($request->access_token);
        }

        if ($social_user_details == null) {
            return response()->json(['result' => false, 'message' => translate('No social account matches'), 'user' => null]);
        }

        $existingUserByProviderId = User::where('provider_id', $request->provider)->first();

        if ($existingUserByProviderId) {
            $existingUserByProviderId->access_token = $social_user_details->token;
            if ($request->social_provider == 'apple') {
                $existingUserByProviderId->refresh_token = $social_user_details->refreshToken;
                if (!isset($social_user->user['is_private_email'])) {
                    $existingUserByProviderId->email = $social_user_details->email;
                }
            }
            $existingUserByProviderId->save();
            return $this->loginSuccess($existingUserByProviderId);
        } else {
            $existing_or_new_user = User::firstOrNew(
                [['email', '!=', null], 'email' => $social_user_details->email]
            );

            // $existing_or_new_user->user_type = 'customer';
            $existing_or_new_user->provider_id = $social_user_details->id;

            if (!$existing_or_new_user->exists) {
                if ($request->social_provider == 'apple') {
                    if ($request->name) {
                        $existing_or_new_user->name = $request->name;
                    } else {
                        $existing_or_new_user->name = 'Apple User';
                    }
                } else {
                    $existing_or_new_user->name = $social_user_details->name;
                }
                $existing_or_new_user->email = $social_user_details->email;
                $existing_or_new_user->email_verified_at = date('Y-m-d H:m:s');
            }

            $existing_or_new_user->save();

            return $this->loginSuccess($existing_or_new_user);
        }
    }

    public function loginSuccess($user, $token = null)
    {
        if (!$token) {
            $token = $user->createToken('API Token')->plainTextToken;
        }

        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged in'),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'first_login' => $this->first_time,
            'expires_at' => null,
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'avatar_original' => uploaded_asset($user->avatar_original),
                'phone' => $user->phone,
                'email_verified' => $user->email_verified_at != null
            ]
        ]);
    }

    protected function loginFailed()
    {
        return response()->json([
            'result' => false,
            'message' => translate('Login Failed'),
            'access_token' => '',
            'token_type' => '',
            'expires_at' => null,
            'user' => [
                'id' => 0,
                'type' => '',
                'name' => '',
                'email' => '',
                'avatar' => '',
                'avatar_original' => '',
                'phone' => ''
            ]
        ]);
    }

    public function account_deletion()
    {
        $auth_user = Auth::user();
        $auth_user->tokens()->where('id', $auth_user->currentAccessToken()->id)->delete();

        User::destroy(auth()->user()->id);

        return response()->json([
            "result" => true,
            "message" => translate('Your account deletion successfully done')
        ]);
    }

    public function getUserInfoByAccessToken(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->access_token);
        if (!$token) {
            return $this->loginFailed();
        }
        $user = $token->tokenable;

        if ($user == null) {
            return $this->loginFailed();
        }

        return $this->loginSuccess($user, $request->access_token);
    }
}
