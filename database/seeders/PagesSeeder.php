<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Page::query()
            ->insertOrIgnore([
                [
                    'name' => 'about',
                    'content' => '{"text": "","description": ""}'
                ],
                [
                    'name' => 'contact',
                    'content' => '{"phone":""}'
                ],
                [
                    'name' => 'help',
                    'content' => '{}'
                ],
                [
                    'name' => 'document',
                    'content' => '{}'
                ],
                [
                    'name' => 'cooperation',
                    'content' => '{"description": ""}'
                ],
                [
                    'name' => 'home',
                    'content' => '{"new_products":[],"bestsellers":[],"line":{"title":""},"product":{},"popular":[],"line_2":[{"title":""},{"title":""}],"instagram":[]}'
                ],
                [
                    'name' => 'catalog',
                    'content' => '{"bestsellers":[],"banner1":{"title":""},"banner2":{"title":""},"popular":[],"line":[{"title":""},{"title":""}]}'
                ]
            ]);
    }
}
