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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('or_transaction_id')->index()->default(0);
            $table->integer('or_product_id')->index()->default(0);
            $table->tinyInteger('or_qty')->default(0);
            $table->integer('or_price')->default(0); // Lưu giá tại thời điểm mua (tránh tăng sau này)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
