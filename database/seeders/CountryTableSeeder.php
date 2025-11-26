<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("countries")->insert([
            [
                'id' => 18,
                "code" => "BD",
                "name" => "Bangladesh",
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ]
        ]);
    }
}
