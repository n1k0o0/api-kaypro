<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 128);
            $table->string('last_name', 128);
            $table->string('patronymic', 128)->nullable();
            $table->string('email', 128)->unique();
            $table->string('password');
            $table->string('phone', 50);
            $table->string('address', 256);
            $table->string('status', 256)->default(User::STATUS_EMAIL_VERIFICATION);
            $table->enum('entity', [0, 1]);
            $table->string('entity_name', 128)->nullable();
            $table->string('entity_status', 128)->nullable();
            $table->string('itn', 256)->comment(
                    'ИНН (Идентификационный Номер Налогоплательщика) — ITN (Individual Taxpayer Number)'
            )->nullable();
            $table->string('psrn', 256)->comment(
                    'ОГРН (Основной Государственный Регистрационный Номер) — PSRN (Primary State Registration Number)'
            )->nullable();
            $table->string('entity_address', 256)->nullable();
            $table->string('price_type', 256)->nullable();
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
        Schema::dropIfExists('users');
    }
}
