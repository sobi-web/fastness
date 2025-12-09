<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique(); // مثل FOOD30 یا SARA5000
            $table->enum('discount_type', ['percent', 'amount']); // نوع تخفیف: درصد یا مبلغ ثابت
            $table->unsignedInteger('discount_value'); // مقدار تخفیف (درصد یا مبلغ ثابت)

            $table->foreignId('course_id')->nullable()
                ->constrained()
                ->cascadeOnDelete(); // اگر کوپن مخصوص یک دوره خاص باشد

            $table->boolean('is_global')->default(true); // آیا عمومی است یا مخصوص کاربران خاص؟
            $table->unsignedInteger('max_per_user')->nullable(); // تعداد مجاز استفاده برای هر کاربر
            $table->unsignedInteger('max_uses')->nullable(); // تعداد کل استفاده مجاز در کل سیستم
            $table->unsignedInteger('used_count')->default(0); // دفعات استفاده‌شده تا حالا

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
