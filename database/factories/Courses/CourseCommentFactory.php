<?php

namespace Database\Factories\Courses;

use App\Models\Users\User;
use Database\Factories\Users\UserFactory;
use Database\Factories\Users\UserProfileFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses\CourseComment>
 */
class CourseCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->text(200),
             'user_id' => 1,
            'course_id' => $this->faker->numberBetween(1, 10),
            'rating' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->numberBetween(0, 1),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
