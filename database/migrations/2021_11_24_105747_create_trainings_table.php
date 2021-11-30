<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 512);
            $table->string('description', 10240);
            $table->string('location', 512);
            $table->dateTime('date');
            $table->string('duration', 512);
            $table->string('price', 512)->nullable();
            $table->string('lecturer', 512);
            $table->unsignedInteger('seats');
            $table->unsignedInteger('empty_seats');
            $table->string('status', 512);
            $table->unsignedInteger('is_visible')->comment('0 - Invisible, 1 - Visible');
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
        Schema::dropIfExists('trainings');
    }
}
