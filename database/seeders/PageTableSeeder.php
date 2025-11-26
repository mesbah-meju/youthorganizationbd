<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table("pages")->insert([
            [
                "type" => "home_page",
                "title" => "Home Page",
                "slug" => "home",
                "content" => null,
                "meta_title" => null,
                "meta_description" => null,
                "keywords" => null,
                "meta_image" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "type" => "seller_policy_page",
                "title" => "Seller Policy Pages",
                "slug" => "seller-policy",
                "content" => null,
                "meta_title" => null,
                "meta_description" => null,
                "keywords" => null,
                "meta_image" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "type" => "return_policy_page",
                "title" => "Return Policy Page",
                "slug" => "return-policy",
                "content" => null,
                "meta_title" => null,
                "meta_description" => null,
                "keywords" => null,
                "meta_image" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "type" => "support_policy_page",
                "title" => "Support Policy Page",
                "slug" => "support-policy",
                "content" => null,
                "meta_title" => null,
                "meta_description" => null,
                "keywords" => null,
                "meta_image" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "type" => "terms_conditions_page",
                "title" => "Term Conditions Page",
                "slug" => "terms",
                "content" => null,
                "meta_title" => null,
                "meta_description" => null,
                "keywords" => null,
                "meta_image" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "type" => "privacy_policy_page",
                "title" => "Privacy Policy Page",
                "slug" => "privacy-policy",
                "content" => null,
                "meta_title" => null,
                "meta_description" => null,
                "keywords" => null,
                "meta_image" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "type" => "contact_us_page",
                "title" => "Contact us",
                "slug" => "contact-us",
                "content" => '{"description":null,"address":null,"phone":null,"email":null}',
                "meta_title" => null,
                "meta_description" => null,
                "keywords" => null,
                "meta_image" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
