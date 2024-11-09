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
            $table->string('code')->nullable();
            $table->char('type_otp')->comment('update_profile|otp_register');
            $table->tinyInteger('status')->default(0)->comment(' 0 khởi tạo, 1 đã gủi, 2 đã sử dụng, -1 lỗi');
            $table->integer('user_id')->default(0);
            $table->string('service')->comment('email|sms');
            $table->tinyInteger('re_send_otp')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
