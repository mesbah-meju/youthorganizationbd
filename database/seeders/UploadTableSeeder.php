<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UploadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("uploads")->insert([
            [
                "id" => "1",
                "file_original_name" => "icon",
                "file_name" => "uploads/all/Hh4upGtoJbJW8KCdAa2oc7KTiD1wbKqh77duMrDb.png",
                "user_id" => "1",
                "file_size" => "35755",
                "extension" => "png",
                "type" => "image",
                "external_link" => null,
                "created_at" => $now,
                "updated_at" => $now,
                "deleted_at" => null,
            ],
            [
                "id" => "2",
                "file_original_name" => "wellbeing",
                "file_name" => "uploads/all/tkJYXlhbnEVKXn4taiv6HjQ7ruc3B7gHbvaBiUn0.png",
                "user_id" => "1",
                "file_size" => "31379",
                "extension" => "png",
                "type" => "image",
                "external_link" => null,
                "created_at" => $now,
                "updated_at" => $now,
                "deleted_at" => null,
            ],
        ]);
    }
}
