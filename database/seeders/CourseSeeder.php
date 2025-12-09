<?php

namespace Database\Seeders;

use App\Models\Shop\Course\Course;
use App\Models\Shop\Course\CourseCategory;
use App\Models\Shop\Course\CourseMedia;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * اجرای Seeder برای ساخت دوره‌ها همراه با فازها و رسانه‌ها
     */
    public function run(): void
    {
        // اطمینان از وجود حداقلی دسته‌بندی‌ها


        $categories = CourseCategory::all();


        // ساخت مثلاً ۱۰ دوره
        $courses = Course::factory(10)->create();

        $courses->each(function ($course) use ($categories) {
            // اتصال تصادفی ۱ تا ۳ دسته به هر دوره
            $course->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // ساخت ۱ تا ۳ رسانه برای هر دوره
            CourseMedia::factory(rand(1, 3))->create([
                'course_id' => $course->id,
            ]);

            $this->command->line("📘 دوره '{$course->name}' ساخته شد با فازها و رسانه‌هایش.");
        });

        $this->command->info('✅ CourseSeeder با موفقیت اجرا شد!');
    }
}

