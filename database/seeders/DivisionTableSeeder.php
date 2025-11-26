<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("divisions")->insert([
            [
                "id" => 1,
                "name" => "Khulna",
                "code" => "BD40",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "id" => 2,
                "name" => "Dhaka",
                "code" => "BD30",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "id" => 3,
                "name" => "Rajshahi",
                "code" => "BD50",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "id" => 4,
                "name" => "Rangpur",
                "code" => "BD55",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "id" => 5,
                "name" => "Barisal",
                "code" => "BD10",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "id" => 6,
                "name" => "Sylhet",
                "code" => "BD60",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "id" => 7,
                "name" => "Chittagong",
                "code" => "BD20",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "id" => 8,
                "name" => "Mymensingh",
                "code" => "BD45",
                "country_id" => 18,
                "status" => 1,
                "created_at" => $now,
                "updated_at" => null,
                "deleted_at" => null,
            ],
        ]);
    }
}
