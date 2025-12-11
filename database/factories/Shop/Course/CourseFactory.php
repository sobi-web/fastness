<?php

namespace Database\Factories\Shop\Course;

use GlassCode\PersianFaker\PersianFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Course\Course>
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
        $price = $this->faker->numberBetween(100000, 15000000);

        $title= $faker->text()->word() . ' ' . $faker->text()->word() . ' ' . $faker->text()->word();
        $hasDiscount = $this->faker->boolean(50);
        $discountPrice = $hasDiscount
            ? $this->faker->numberBetween(10, $price - 10)
            : 0;
        return [
            'name' => $faker->text()->word() . ' ' . $faker->text()->word() . ' ' . $faker->text()->word(),
            'slug' => Str::slug($title),
            'description' => $faker->text()->paragraph() . '<br>' . $faker->text()->paragraph(),
            'price' => $price,
            'discount_price' => $discountPrice,

            'status' => rand(1,2),
        ];
    }
}
