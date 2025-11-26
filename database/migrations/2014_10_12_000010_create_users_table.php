<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['developer', 'admin', 'directorate', 'organization'])->default('organization');
            $table->string('name');
            $table->string('phone', 20)->unique();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->text('verification_code')->nullable();
            $table->text('new_email_verification_code')->nullable();
            $table->string('avatar', 256)->nullable();
            $table->string('avatar_original', 256)->nullable();
            $table->text('refresh_token')->nullable();
            $table->longText('access_token')->nullable();
            $table->string('device_token', 255)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable();
            $table->text('address')->nullable();
            $table->string('country', 30)->nullable();
            $table->string('division', 30)->nullable();
            $table->string('district', 30)->nullable();
            $table->string('upazila', 30)->nullable();
            $table->integer('remaining_uploads')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
