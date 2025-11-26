<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("user_roles")->insert([
            [
                "id" => 1,
                "user_id" => 2,
                "role_id" => 2,
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
