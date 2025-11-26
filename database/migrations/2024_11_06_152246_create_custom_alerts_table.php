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
        Schema::create('custom_alerts', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->string('type', 191);
            $table->string('banner', 191)->nullable();
            $table->string('link', 191);
            $table->text('description');
            $table->string('text_color', 191)->nullable();
            $table->string('background_color', 191)->nullable();
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
        Schema::dropIfExists('custom_alerts');
    }
};
