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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('receiver', 20);
            $table->string('identifier', 100);
            $table->string('email_type', 255);
            $table->string('subject', 255);
            $table->text('default_text')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_status_changeable')->default(1);
            $table->tinyInteger('is_dafault_text_editable')->default(1);
            $table->string('addon', 50)->nullable();
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
};
