<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_categories', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 512)->unique();
            $table->string('subtitle', 512);
            $table->boolean('mobile_visibility');
            $table->unsignedInteger('order')->default(0);
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('meta_title', 128)->nullable();
            $table->string('meta_description', 512)->nullable();
            $table->string('meta_keywords', 512)->nullable();
            $table->string('meta_slug', 128)->unique();
            $table->string('meta_image', 512)->nullable();
            $table->timestamps();
            $table->foreign('parent_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
}
