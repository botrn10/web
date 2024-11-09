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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('tr_user_id')->index()->default(0);
            $table->integer('tr_total')->default(0);
            $table->integer('tr_type_payemnt')->nullable()->default(0);
            $table->string('tr_note')->nullable();
            $table->string('tr_address')->nullable();
            $table->string('tr_phone')->nullable();
            $table->integer('tr_user_sale')->nullable()->default(0);
            $table->tinyInteger('tr_status')->index()->default(0); // Đầu tiên bằng 0 giao hàng xong 1


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
