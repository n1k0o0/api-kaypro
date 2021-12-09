<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetTittleUniqueInNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('title', 250)->unique()->change();
            $table->string('meta_slug', 128)->nullable(false)->unique()->after('meta_keywords')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('title', 250)->change();
            $table->string('meta_slug', 128)->nullable()->after('meta_keywords')->change();
        });
    }
}
