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
            // Liên kết với bảng users (người mua hàng)
            // Lưu ý: Bảng users đã được Laravel tạo sẵn từ đầu
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->decimal('total_price', 10, 2); // Tổng tiền đơn hàng
            $table->string('status')->default('pending'); // Trạng thái (chờ xử lý, đã giao...)
            $table->string('shipping_address'); // Địa chỉ giao hàng
            $table->string('phone'); // Số điện thoại nhận hàng
            $table->text('note')->nullable(); // Ghi chú của khách
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
