<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Product::all()->each->delete();
        $name = $this->faker->unique()->text(20);
        $categories = ProductCategory::query()->pluck('title')->toArray();
        return [
            'id_1c' => $this->faker->unique()->text(20),
            'barcode' => $this->faker->unique()->text(20),
            'vendor_code' => $this->faker->randomNumber(6),
            'count' => $this->faker->randomNumber(2),
            'name' => $name,
            'unit' => $this->faker->text(5),
            'category' => $this->faker->randomElement($categories),
            'volume' => $this->faker->randomNumber(3),
            'weight' => $this->faker->randomNumber(3),
            'price' => $this->faker->randomNumber(4),
            'short_description' => $this->faker->realText(15),
            'full_description' => $this->faker->text(150),
            'composition' => $this->faker->text(150),
            'country' => $this->faker->text(10),
            'meta_slug' => Str::slug($name),
        ];
    }
}
