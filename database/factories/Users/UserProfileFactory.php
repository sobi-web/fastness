<?php

namespace Database\Factories\Users;

use App\Models\User\User;
use GlassCode\PersianFaker\PersianFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\UserProfile>
 */
class UserProfileFactory extends Factory
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
            'user_id' => User::factory(),
            'full_name' => $faker->person()->name() . ' ' . $faker->person()->lastName() ,  //علی
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => verta($this->faker->date())->format('Y/m/d'),
            'job_title' => $faker->person()->job(),
            'bio' => $faker->text()->paragraph(),
        ];
    }
}
