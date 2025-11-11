<?php

namespace Database\Factories\Courses;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses\CourseCategory>
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
        return [
            'name' => $this->faker->unique()->words(2, true),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->sentence(10),
            'parent_id' => null, // در صورت نیاز بعداً می‌تونیم setParent کنیم
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
