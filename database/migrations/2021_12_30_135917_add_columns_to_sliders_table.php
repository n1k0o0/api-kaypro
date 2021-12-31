<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('sliders', static function (Blueprint $table) {
            $table->string('description', 1024)->nullable()->after('subtitle');
            $table->string('title_color', 10)->nullable()->after('description');
            $table->string('subtitle_color', 10)->nullable()->after('title_color');
            $table->boolean('button')->default(0)->after('link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('sliders', static function (Blueprint $table) {
            $table->dropColumn(['description', 'title_color', 'subtitle_color', 'button']);
        });
    }
}
