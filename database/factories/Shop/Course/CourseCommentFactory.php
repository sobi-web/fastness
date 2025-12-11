<?php

namespace Database\Factories\Shop\Course;

use App\Models\Shop\Course\Course;
use App\Models\User\User;
use GlassCode\PersianFaker\PersianFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Course\CourseComment>
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
        $faker = PersianFaker::create();

        return [
            'body' => $faker->text()->paragraph(), // متن طولانی
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'status' => 2,
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
