<?php

namespace Database\Factories\Courses;

use GlassCode\PersianFaker\PersianFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = PersianFaker::create();

        $title= $faker->text()->word() . ' ' . $faker->text()->word() . ' ' . $faker->text()->word();

        return [
            'name' => $faker->text()->word() . ' ' . $faker->text()->word() . ' ' . $faker->text()->word(),
            'slug' => Str::slug($title),
            'description' => $faker->text()->paragraph() . '<br>' . $faker->text()->paragraph(),
            'price' => fake()->randomElement([rand(1000, 999999)]),
            'status' => rand(1,2),
        ];
    }
}
