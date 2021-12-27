<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('sliders', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('model_type', 128);
            $table->unsignedInteger('model_id');
            $table->string('collection_name', 128)->default('default');
            $table->string('title', 512)->nullable();
            $table->string('subtitle', 1024)->nullable();
            $table->string('link', 1024)->nullable();
            $table->string('button_text', 128)->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
}
