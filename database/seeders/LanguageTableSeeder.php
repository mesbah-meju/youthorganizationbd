<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("languages")->insert([
            [
                "name" => "English",
                "code" => "en",
                "app_lang_code" => "en",
                "rtl" => "0",
                "status" => "1",
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "name" => "Bangla",
                "code" => "bd",
                "app_lang_code" => "bn",
                "rtl" => "0",
                "status" => "1",
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
