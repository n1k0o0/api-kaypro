<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        ProductCategory::truncate();
        $title = $this->faker->unique()->text(10);
        return [
            'title' => $title,
            'subtitle' => $this->faker->text(50),
            'mobile_visibility' => $this->faker->randomElement([0, 1]),
            'meta_slug' => Str::slug($title),
            'meta_title' => $title,
            'meta_description' => $this->faker->text(75),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (ProductCategory $productCategory) {
            $rand = $this->faker->numberBetween(1, 20);
            $productCategory->update(['parent_id' => $this->faker->randomElement([$rand, null, null])]);
        });
    }
}
