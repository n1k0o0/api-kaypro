<?php

namespace Database\Seeders;

use App\Models\Moderator;
use Illuminate\Database\Seeder;

class ModeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Moderator::query()->create([
                'email' => 'admin@admin.ru',
                'first_name' => 'Admin',
                'last_name' => 'Moderator',
                'phone' => '999999999999',
                'type' => Moderator::TYPE_ADMIN,
                'password' => '3=%Qy2gq'
        ]);
    }
}
