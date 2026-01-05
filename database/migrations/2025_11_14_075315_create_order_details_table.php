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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            // Liên kết với đơn hàng
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // Liên kết với sản phẩm
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->integer('quantity'); // Số lượng mua
            $table->decimal('price', 10, 2); // Giá tại thời điểm mua
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
