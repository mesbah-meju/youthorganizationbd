<?php

namespace App\Http\Controllers\Api\V2;

use App\Notifications\AppEmailVerificationNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\OTPVerificationController;
use Auth;

use Hash;

class PasswordResetController extends Controller
{
    public function forgetRequest(Request $request)
    {
        if ($request->send_code_by == 'email') {
            $user = User::where('email', $request->email_or_phone)->first();
        } else {
            $user = User::where('phone', $request->email_or_phone)->first();
        }


        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => translate('User is not found')
            ], 404);
        }

        if ($user) {
            $user->verification_code = rand(100000, 999999);
            $user->save();
            if ($request->send_code_by == 'phone') {

                $otpController = new OTPVerificationController();
                $otpController->send_code($user);
            } else {
                try {

                    $user->notify(new AppEmailVerificationNotification());
                } catch (\Exception $e) {
                }
            }
        }

        return response()->json([
            'result' => true,
            'message' => translate('A code is sent')
        ], 200);
    }

    public function confirmReset(Request $request)
    {
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => translate('No user is found with this email.'),
            ], 200);
        }
    
        if ($user->verification_code !== $request->verification_code) {
            return response()->json([
                'result' => false,
                'message' => translate('Verification code does not match.'),
            ], 200);
        }
    
        $user->verification_code = null;
        $user->password = Hash::make($request->password);
        $user->save();
    
        return response()->json([
            'result' => true,
            'message' => translate('Your password is reset. Please login.'),
        ], 200);
    }
    

    public function resendCode(Request $request)
    {

        if ($request->verify_by == 'email') {
            $user = User::where('email', $request->email_or_phone)->first();
        } else {
            $user = User::where('phone', $request->email_or_phone)->first();
        }

        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => translate('User is not found')
            ], 404);
        }

        $user->verification_code = rand(100000, 999999);
        $user->save();

        if ($request->verify_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }



        return response()->json([
            'result' => true,
            'message' => translate('A code is sent again'),
        ], 200);
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->new_password != null && ($request->new_password == $request->confirm_password) && $request->old_password != null && (Hash::check($request->old_password, $user->password))) {
            $user->password = Hash::make($request->new_password);
            if ($user->save()) {
                return response()->json([
                    'result' => true,
                    'message' => translate('Your password has been changed successfully.'),
                ], 200);
            }
        }
        return response()->json([
            'result' => false,
            'message' => translate("Old password didn't match."),
        ], 200);
    }
}
