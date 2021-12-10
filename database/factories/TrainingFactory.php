<?php

namespace Database\Factories;

use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Training::all()->each->delete();
        $name = $this->faker->unique()->text(20);
        $seats = $this->faker->numberBetween(1, 50);

        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
            'location' => $this->faker->address(),
            'city' => $this->faker->randomElement(['Москва', 'Баку', 'Осло', 'Мадрид']),
            'date' => $this->faker->dateTimeThisYear(),
            'duration' => $this->faker->text(10),
            'price' => $this->faker->numberBetween(1, 1000),
            'lecturer' => $this->faker->name(),
            'lecturer_description' => $this->faker->text(75),
            'lecturer_position' => $this->faker->text(15),
            'days' => [
                ['name' => $this->faker->text(5), 'content' => $this->faker->text(150)],
                ['name' => $this->faker->text(5), 'content' => $this->faker->text(150)],
            ],
            'seats' => $seats,
            'empty_seats' => $this->faker->numberBetween(1, $seats),
            'status' => $this->faker->randomElement(Training::STATUSES),
            'is_visible' => 1,
            'meta_slug' => Str::slug($name),
            'created_at' => $this->faker->date(),
            'meta_title' => $name,
            'meta_description' => $this->faker->sentence(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Training $training) {
            $logo = 'https://elearningindustry.com/wp-content/uploads/2019/12/the-value-of-employee-training.jpg';
            $lecturer = 'https://us.123rf.com/450wm/lightfieldstudios/lightfieldstudios1903/lightfieldstudios190306033/118631872-beautiful-female-teacher-in-formal-wear-writing-in-notebook-and-looking-at-camera-in-classroom.jpg?ver=6';
            $training->addMediaFromUrl($logo)->toMediaCollection('logo');
            $training->addMediaFromUrl($lecturer)->toMediaCollection('lecturer_avatar');
        });
    }

}
