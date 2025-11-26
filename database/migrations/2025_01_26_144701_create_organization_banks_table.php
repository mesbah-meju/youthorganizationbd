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
        Schema::create('organization_banks', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('organization_id');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('source_of_income');
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
        Schema::dropIfExists('organization_banks');
    }
};
