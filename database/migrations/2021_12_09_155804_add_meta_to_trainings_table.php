<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaToTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('name', 512)->unique()->change();
            $table->string('meta_title', 128)->nullable()->after('is_visible');
            $table->string('meta_description', 512)->nullable()->after('meta_title');
            $table->string('meta_keywords', 512)->nullable()->after('meta_description');
            $table->string('meta_slug', 128)->unique()->after('meta_keywords');
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
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('name', 512)->change();
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords', 'meta_slug', 'meta_image']
            );
        });
    }
}
