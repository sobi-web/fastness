<?php

namespace Database\Factories\Courses;

use App\Models\Shop\Course\CourseCategory;
use GlassCode\PersianFaker\PersianFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Course\CourseCategory>
 */
class CourseCategoryFactory extends Factory
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
            'name' => $faker->text()->word(),
            'slug' => Str::slug(fake()->unique()->words(3, true)),
            'description' => $this->faker->sentence(10),
            'parent_id' => fake()->randomElements([
                null,
                CourseCategory::factory()
            ]),
            'icon' => null
        ];
    }

    // برای ساخت زیرمجموعه در صورت نیاز
    public function withParent($parentId)
    {
        return $this->state([
            'parent_id' => $parentId,
        ]);
    }
}
