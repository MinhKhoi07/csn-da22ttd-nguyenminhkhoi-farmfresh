<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'category_id',
        'product_id',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2'
    ];

    // Relationship với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Kiểm tra khuyến mãi còn hiệu lực
    public function isValid()
    {
        $now = Carbon::now();
        return $this->is_active 
            && $this->start_date <= $now 
            && $this->end_date >= $now;
    }

    // Tính giá sau khuyến mãi
    public function calculateDiscountedPrice($originalPrice)
    {
        if (!$this->isValid()) {
            return $originalPrice;
        }

        if ($this->discount_type === 'percentage') {
            $discount = $originalPrice * ($this->discount_value / 100);
            return $originalPrice - $discount;
        }

        // fixed
        return max(0, $originalPrice - $this->discount_value);
    }

    // Scope để lấy các khuyến mãi đang hoạt động
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
                    ->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }
}

