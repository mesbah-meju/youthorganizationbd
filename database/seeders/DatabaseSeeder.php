<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AddonTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(CustomAlertTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(DivisionTableSeeder::class);
        $this->call(DynamicPopupTableSeeder::class);
        $this->call(EmailTemplateTableSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(NotificationTypeTableSeeder::class);
        $this->call(OtpConfigurationTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ModelHasRoleTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(SmsTemplateTableSeeder::class);
        $this->call(UpazilaTableSeeder::class);
        $this->call(UploadTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
