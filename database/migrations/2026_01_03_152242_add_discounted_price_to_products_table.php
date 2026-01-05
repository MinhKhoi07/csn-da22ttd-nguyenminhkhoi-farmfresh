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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('discounted_price', 10, 2)->nullable()->after('price');
            $table->boolean('has_promotion')->default(false)->after('discounted_price');
            $table->integer('discount_percentage')->nullable()->after('has_promotion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discounted_price', 'has_promotion', 'discount_percentage']);
        });
    }
};
