<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("model_has_roles")->insert([
            [
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 9
            ],
            [
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 10
            ],
            [
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32
            ],
            [
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33
            ],
            [
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34
            ],
            [
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36
            ],
            [
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35
            ]
        ]);
    }
}
