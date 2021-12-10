<?php

namespace Database\Factories;

use App\Models\Moderator;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        News::all()->each->delete();
        $title = $this->faker->unique()->text(20);

        return [
            'title' => $title,
            'text' => $this->faker->text(75),
            'meta_slug' => Str::slug($title),
            'meta_title' => $title,
            'meta_description' => $this->faker->text(75),
            'moderator_id' => $this->faker->randomElement(Moderator::query()->pluck('id')),
            'visibility' => 1,
            'published_at' => $this->faker->dateTime,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (News $news) {
            $logo = 'https://timesofindia.indiatimes.com/thumb/msid-88175197,width-1200,height-900,resizemode-4/88175197.jpg';
            $news->addMediaFromUrl($logo)->toMediaCollection('logo');
        });
    }
}
