<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomAlertTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("custom_alerts")->insert([
            [
                "status" => 1,
                "type" => "small",
                "banner" => null,
                "link" => "#",
                "description" =>
                '<p>We use cookie for better user experience, check our policy <a href="https://demo.activeitzone.com/ecommerce/privacypolicy">here</a>&nbsp;</p>',
                "text_color" => "dark",
                "background_color" => "#ffffff",
                "created_at" => $now,
                "updated_at" => null,
            ],
        ]);
    }
}
