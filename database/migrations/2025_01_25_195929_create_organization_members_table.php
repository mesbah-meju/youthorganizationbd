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
        Schema::create('organization_members', function (Blueprint $table) {
            $table->id();
            $table->string('organization_id');
            $table->string('user_id');
            $table->string('designation');
            $table->string('is_founder');
            $table->string('name_bn');
            $table->string('name_en');
            $table->date('dob');
            $table->string('age');
            $table->string('nid')->nullable();
            $table->string('address')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('image');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('organization_members');
    }
};
