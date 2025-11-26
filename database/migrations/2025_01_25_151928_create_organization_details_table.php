<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_details', function (Blueprint $table) {
            $table->id(); // Primary key 
            $table->string('user_id');
            $table->string('reg_type')->nullable();
            $table->string('work_area');
            $table->string('org_name_bn');
            $table->string('org_name_en');
            $table->string('org_type');
            $table->date('establishment_date');
            $table->string('logo');
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_details');
    }
};
