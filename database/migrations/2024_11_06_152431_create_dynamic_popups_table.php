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
        Schema::create('dynamic_popups', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->string('title', 191);
            $table->text('summary');
            $table->string('banner', 191)->nullable();
            $table->string('btn_link', 191);
            $table->string('btn_text', 191)->nullable();
            $table->string('btn_text_color', 191)->nullable();
            $table->string('btn_background_color', 191)->nullable();
            $table->string('show_subscribe_form', 191)->nullable();
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
        Schema::dropIfExists('dynamic_popups');
    }
};
