<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();

            // شماره تلفن منحصر به فرد برای جریان OTP
            $table->string('phone')->index();

            // کد OTP موقت
            $table->string('code');

            // شناسه جریان بدون session
            $table->uuid('flow_token')->unique();

            // نوع جریان OTP (login, register, password_reset)
            $table->smallInteger('type')->default(1);

            // وضعیت فعلی OTP
            $table->smallInteger('status')->default(1);

            // محدودیت ارسال و نرخ
            $table->unsignedInteger('send_count')->default(1);
            $table->timestamp('last_sent_at')->nullable();

            // زمان انقضای کد و زمان تأیید
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();

            // اطلاعات کاربر و امنیت
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 255)->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->timestamps();
            $table->index(['phone', 'status', 'expires_at']);
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
