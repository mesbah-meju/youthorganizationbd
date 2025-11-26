<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;

class Bulk24sms implements SendSms {
    
    public function send($to, $from, $text, $template_id) {
        
        $api_key = env("BULK24SMS_API_KEY");
        $sender_id = env("BULK24SMS_SENDER_ID");
        $user_email = env("BULK24SMS_EMAIL_ID");

        $url = 'https://24bulksms.com/24bulksms/api/otp-api-sms-send';

        $data = array('api_key' => $api_key,
         'sender_id' => $sender_id,
         'message' => $text,
         'mobile_no' => $to,
         'user_email'=> $user_email,
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        dd(json_decode($response));
        
        curl_close($curl);        
        return $response;
    }
}

