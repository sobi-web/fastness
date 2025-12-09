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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

// کاربر خریدکننده

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

// سبد خریدی که تبدیل به سفارش شده (اختیاری)

            $table->foreignId('cart_id')->nullable()->constrained('carts')->nullOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();

// مبالغ فریز شده

            $table->unsignedBigInteger('total_price')->default(0);

            $table->unsignedBigInteger('discount_amount')->default(0);

            $table->unsignedBigInteger('final_price')->default(0);

// وضعیت پرداخت

            $table->smallInteger('payment_status')->default(1); // pending, paid, failed, canceled

            $table->smallInteger('payment_gateway')->default(1); // zarinpal, idpay, …

            $table->string('payment_ref')->nullable(); // شماره پیگیری درگاه

            $table->timestamp('paid_at')->nullable();

// وضعیت کلی سفارش

            $table->smallInteger('status')->default(1); // created, processing, completed, canceled

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

// آیتم خریداری شده

            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();

// قیمت فریز شده

            $table->unsignedInteger('quantity')->default(1);

            $table->unsignedBigInteger('unit_price')->default(0);

            $table->unsignedBigInteger('discount_amount')->default(0);

            $table->unsignedBigInteger('final_price')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');


    }
};
