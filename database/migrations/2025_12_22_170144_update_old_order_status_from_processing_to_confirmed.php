<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cập nhật tất cả đơn hàng có trạng thái "processing" cũ
        // sang trạng thái "confirmed" (đã xác nhận) trong hệ thống mới
        DB::table('orders')
            ->where('status', 'processing')
            ->update(['status' => 'confirmed']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: chuyển ngược từ "confirmed" về "processing"
        // (chỉ chạy nếu cần rollback migration này)
        DB::table('orders')
            ->where('status', 'confirmed')
            ->update(['status' => 'processing']);
    }
};
