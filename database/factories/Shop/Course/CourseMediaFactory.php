<?php

namespace Database\Factories\Shop\Course;

use App\Models\Shop\Course\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Course\CourseMedia>
 */
class CourseMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['image', 'video', 'voice'];

        return [
            'course_id' => Course::factory(),
            'type' => $this->faker->randomElement($types),
            'path' => 'uploads/courses/' . $this->faker->uuid . '.jpg',
            'name' => $this->faker->sentence(),
        ];
    }
}
