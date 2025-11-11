<?php

namespace Database\Seeders;

use App\Models\Courses\Course;
use App\Models\Courses\CourseCategory;
use App\Models\Courses\CourseMedia;
use App\Models\Courses\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * اجرای Seeder برای ساخت دوره‌ها همراه با فازها و رسانه‌ها
     */
    public function run(): void
    {
        // اطمینان از وجود حداقلی دسته‌بندی‌ها
        if (CourseCategory::count() === 0) {
            $this->command->warn('⚠️ هیچ دسته‌بندی‌ای وجود ندارد. ساخت چند دسته نمونه...');
            CourseCategory::factory(5)->create();
        }

        $categories = CourseCategory::all();

        $this->command->info('🚀 شروع ساخت دوره‌ها همراه با فازها و رسانه‌ها...');

        // ساخت مثلاً ۱۰ دوره
        $courses = Course::factory(10)->create();

        $courses->each(function ($course) use ($categories) {
            // اتصال تصادفی ۱ تا ۳ دسته به هر دوره
            $course->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // ساخت ۳ تا ۵ فاز برای هر دوره
            Phase::factory(rand(3, 5))->create([
                'course_id' => $course->id,
            ]);

            // ساخت ۱ تا ۳ رسانه برای هر دوره
            CourseMedia::factory(rand(1, 3))->create([
                'course_id' => $course->id,
            ]);

            $this->command->line("📘 دوره '{$course->name}' ساخته شد با فازها و رسانه‌هایش.");
        });

        $this->command->info('✅ CourseSeeder با موفقیت اجرا شد!');
    }
}

