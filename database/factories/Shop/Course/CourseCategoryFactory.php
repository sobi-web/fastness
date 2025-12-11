<?php

namespace Database\Factories\Shop\Course;

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
            'name' => $faker->word(),
            'slug' => Str::slug(fake()->unique()->words(3, true)),
            'description' => fake()->sentence(10),

            // مقدار parent_id گاهی null، گاهی یکی از id‌های موجود
            'parent_id' => fake()->optional()->randomElement(
                CourseCategory::pluck('id')->toArray()
            ),

            'icon' => null,
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
