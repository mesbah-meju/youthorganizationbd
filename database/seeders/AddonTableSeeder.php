<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("addons")->insert([
            [
                "name" => "OTP",
                "unique_identifier" => "otp_system",
                "version" => "2.6",
                "activated" => 1,
                "image" => "otp_system.png",
                "purchase_code" => "a9eb3ab2-7edb-4554-ac95-41997a228631",
                "created_at" => $now,
                "updated_at" => $now
            ]
        ]);
    }
}
