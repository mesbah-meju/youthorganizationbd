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
        Schema::create('organization_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('division');
            $table->string('district');
            $table->string('sub_district');
            $table->string('post_office_bn');
            $table->string('post_office_en');
            $table->string('street_bn');
            $table->string('street_en');
            $table->string('address_bn');
            $table->string('address_en');
            $table->timestamps();
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_addresses');
    }
};
