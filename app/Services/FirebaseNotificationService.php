<?php

namespace App\Services;

use Kreait\Firebase\Factory; // Adjust based on your Firebase package
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\ConfigFcm;



class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $credentialsPath = config('firebase.credentials');
        if (!file_exists($credentialsPath)) {
            throw new \Exception("Firebase credentials file not found at: {$credentialsPath}");
        }
    
        $firebase = (new Factory)->withServiceAccount($credentialsPath);
        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification(string $title, string $body, string $deviceToken, array $data = [])
    {
        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
        ]);
        
        return $this->messaging->send($message);
    }

    public function send_Notification(int $id, string $title, string $body,array $data = [])
    {
        $deviceToken = ConfigFcm::where('user_id',$id)->value('token');
        
        if(!$deviceToken){
            flash(translate('Fcm token not found!'))->error();
            return false;
        }
        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
        ]);
        return $this->messaging->send($message);
    }
}
