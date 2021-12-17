<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_1c', 256);
            $table->unsignedInteger('barcode');
            $table->string('vendor_code')->comment('Артикул');
            $table->string('name', 512);
            $table->string('unit', 50)->comment('базовая единица');
            $table->string('category', 512)->comment('вид номенклатуры')->nullable();
            $table->double('weight')->nullable();
            $table->unsignedInteger('count')->nullable();
            $table->string('short_description', 512)->nullable();
            $table->string('full_description', 2048)->nullable();
            $table->string('composition', 512)->comment('состав')->nullable();
            $table->string('price', 512)->nullable();
            $table->string('country', 256)->nullable();
            $table->string('volume', 256)->comment('объем')->nullable();
            $table->string('status', 256)->default('inactive');
            $table->string('meta_title', 128)->nullable();
            $table->string('meta_description', 512)->nullable();
            $table->string('meta_keywords', 512)->nullable();
            $table->string('meta_slug', 128)->unique();
            $table->string('meta_image', 512)->nullable();
            $table->timestamps();
            $table->foreign('category')
                ->references('title')
                ->on('product_categories')
                ->onDelete('set null')
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
        Schema::dropIfExists('products');
    }
}
