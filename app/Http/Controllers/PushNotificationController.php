<?php

namespace App\Http\Controllers;

use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use App\models\ConfigFcm;
use App\models\User;

class PushNotificationController extends Controller
{
    protected $firebaseNotificationService;

    public function __construct(FirebaseNotificationService $firebaseNotificationService)
    {
        $this->firebaseNotificationService = $firebaseNotificationService;
    }

    public function pushNotificationForm()
    {
        $user = User::leftjoin('config_fcm', 'users.id', 'config_fcm.user_id')
            ->select('users.name', 'users.id')
            ->where('config_fcm.token', '!=', null)
            ->get();
        return view('push-notification-form', compact('user'));
    }


    // public function sendPushNotification(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string',
    //         'body' => 'required|string',
    //         'data' => 'nullable|string',
    //     ]);

    //     $customData = !empty($validated['data']) ? json_decode($validated['data'], true) : [];

    //     if (!empty($validated['data']) && json_last_error() !== JSON_ERROR_NONE) {
    //         return redirect()
    //             ->back()
    //             ->with('flash_error', __('Invalid JSON format in the "data" field.'));
    //     }

    //     $response = $this->firebaseNotificationService->sendNotification(
    //         $validated['title'],
    //         $validated['body'],
    //         $validated['device_token'],
    //         $customData
    //     );

    //     flash(translate('Notification sent successfully!'))->success();
    //     return redirect()->back();
    // }

    public function sendPushNotification(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $title = $validated['title'];
        $body = $validated['body'];
        $userId = $validated['user_id'];

        $response = $this->firebaseNotificationService->send_Notification($userId,$title,$body);

        flash(translate('Notification sent successfully!'))->success();
        return redirect()->back();
    }
}
