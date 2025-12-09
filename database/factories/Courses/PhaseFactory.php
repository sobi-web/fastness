<?php

namespace Database\Factories\Courses;

use App\Models\Shop\Course\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Course\Phase>
 */
class PhaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

            $name = fake()->words(2, true);

            return [
                'name' => $name,
                'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 999),
                'description' => fake()->paragraph(),
                'order' => fake()->numberBetween(1, 10),
                'duration_days' => fake()->numberBetween(5, 30),
                'course_id' => Course::factory(), // یا به صورت دستی در Seeder مقدار دهی می‌شود
            ];

    }
}
