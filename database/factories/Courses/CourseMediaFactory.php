<?php

namespace Database\Factories\Courses;

use App\Models\Courses\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses\CourseMedia>
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
