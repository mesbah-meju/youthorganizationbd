<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DynamicPopupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("dynamic_popups")->insert([
            [
                "status" => 1,
                "title" => "Subscribe to Our Newsletter",
                "summary" =>
                "Subscribe our newsletter for coupon, offer and exciting promotional discount..",
                "banner" => null,
                "btn_link" => "#",
                "btn_text" => "Subscribe Now",
                "btn_text_color" => "white",
                "btn_background_color" => "#baa185",
                "show_subscribe_form" => "on",
                "created_at" => $now,
                "updated_at" => null,
            ],
        ]);
    }
}
