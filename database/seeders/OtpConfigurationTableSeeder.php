<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtpConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("otp_configurations")->insert([
            [
                "id" => 1,
                "type" => "nexmo",
                "value" => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 2,
                "type" => "twillo",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 3,
                "type" => "ssl_wireless",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 4,
                "type" => "fast2sms",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 5,
                "type" => "mimsms",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 6,
                "type" => "mimo",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 7,
                "type" => "msegat",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 8,
                "type" => "sparrow",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 9,
                "type" => "zender",
                "value" => 0,
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
