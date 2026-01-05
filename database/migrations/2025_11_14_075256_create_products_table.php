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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Liên kết với bảng categories (Khóa ngoại)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            $table->string('name'); // Tên sản phẩm
            $table->text('description')->nullable(); // Mô tả sản phẩm
            $table->decimal('price', 10, 2); // Giá bán (10 số, 2 số thập phân)
            $table->string('unit'); // Đơn vị tính (kg, bó, túi...)
            $table->string('origin')->nullable(); // Nguồn gốc (Đà Lạt, Sapa...)
            $table->string('image')->nullable(); // Đường dẫn ảnh
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
