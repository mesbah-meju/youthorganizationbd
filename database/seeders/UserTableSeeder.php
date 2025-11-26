<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("users")->insert([
            [
                "id" => 1,
                "user_type" => "developer",
                "name" => "Mr. Developer",
                "phone" => "01759724410",
                "email" => "tanem@fouraxiz.com",
                "email_verified_at" => $now,
                "password" => '$2y$10$8qBXky2ZRy1bggoRVXZAj.6RByJg0xp.JHr2bGeBjSojCAstS2FCa',
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "id" => 2,
                "user_type" => "admin",
                "name" => "Mr. Super Admin",
                "phone" => "01988837838",
                "email" => "admin@youthorganizationbd.org",
                "email_verified_at" => $now,
                "password" => '$2y$10$8qBXky2ZRy1bggoRVXZAj.6RByJg0xp.JHr2bGeBjSojCAstS2FCa',
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
