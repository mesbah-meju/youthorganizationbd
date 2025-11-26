<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmsTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("sms_templates")->insert([
            [
                "id" => 1,
                "identifier" => "phone_number_verification",
                "sms_body" => "[[code]] is your verification code for [[site_name]].",
                "template_id" => null,
                "status" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 2,
                "identifier" => "password_reset",
                "sms_body" => "Your password reset code is [[code]].",
                "template_id" => null,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 3,
                "identifier" => "order_placement",
                "sms_body" => "Your order has been placed and Order Code is [[order_code]]",
                "template_id" => null,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 4,
                "identifier" => "delivery_status_change",
                "sms_body" => "Your delivery status has been updated to [[delivery_status]]  for Order code : [[order_code]]",
                "template_id" => null,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 5,
                "identifier" => "payment_status_change",
                "sms_body" => "Your payment status has been updated to [[payment_status]] for Order code : [[order_code]]",
                "template_id" => null,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 6,
                "identifier" => "assign_delivery_boy",
                "sms_body" => "You are assigned to deliver an order. Order code : [[order_code]]",
                "template_id" => null,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 7,
                "identifier" => "account_opening",
                "sms_body" => "Hi! An account has been created on [[site_name]]. Your account type is: [[user_type]], password is: [[password]] and the verification code is [[code]] .",
                "template_id" => null,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
