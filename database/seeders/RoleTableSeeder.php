<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("roles")->insert([
            [
                "id" => 1,
                "name" => "System Engineer",
                "user_type" => "developer",
                "guard_name" => "web",
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 2,
                "name" => "Super Admin",
                "user_type" => "admin",
                "guard_name" => "web",
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 3,
                "name" => "Admin",
                "user_type" => "admin",
                "guard_name" => "web",
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 4,
                "name" => "Director",
                "user_type" => "directorate",
                "guard_name" => "web",
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 5,
                "name" => "Deputy Director",
                "user_type" => "directorate",
                "guard_name" => "web",
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 6,
                "name" => "Assistant Director",
                "user_type" => "directorate",
                "guard_name" => "web",
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 7,
                "name" => "Organization",
                "user_type" => "organization",
                "guard_name" => "web",
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
