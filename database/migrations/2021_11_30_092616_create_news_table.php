<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 250);
            $table->string('text', 4096);
            $table->dateTime('published_at');
            $table->unsignedInteger('moderator_id')->nullable();
            $table->unsignedInteger('visibility')->comment('0 - Invisible, 1 - Visible');
            $table->timestamps();
            $table->foreign('moderator_id')->references('id')->on('moderators')->onUpdate('cascade')->onDelete(
                    'set null'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
}
