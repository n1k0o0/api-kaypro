<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaToNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('meta_title', 128)->nullable()->after('visibility');
            $table->string('meta_description', 512)->nullable()->after('meta_title');
            $table->string('meta_keywords', 512)->nullable()->after('meta_description');
            $table->string('meta_slug', 128)->nullable()->after('meta_keywords');
            $table->string('meta_image', 512)->nullable()->after('meta_slug');
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
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords', 'meta_slug', 'meta_image']
            );
        });
    }
}
