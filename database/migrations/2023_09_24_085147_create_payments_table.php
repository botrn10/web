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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('p_transaction_id')->nullable();
            $table->integer('p_user_id')->nullable();
            $table->integer('p_money_id')->nullable(); // Số tiền thanh toán
            $table->string('p_note')->nullable();
            $table->string('p_vnp_response_code', 255)->nullable(); // Mã phản hồi
            $table->string('p_code_vnpay', 255)->nullable();
            $table->string('p_code_bank', 255)->nullable();
            $table->dateTime('p_time')->nullable(); // Thời gian chuyển khoản
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
