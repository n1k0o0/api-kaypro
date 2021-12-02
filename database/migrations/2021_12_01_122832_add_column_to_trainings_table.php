<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('city', 100)->after('description');
            $table->string('lecturer_description', 500)->after('lecturer')->nullable();
            $table->string('lecturer_position', 250)->after('lecturer_description');
            $table->json('days')->after('lecturer_position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['lecturer_position', 'lecturer_description', 'days', 'city']);
        });
    }
}
