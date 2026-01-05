<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Cho phép lưu 3 trường này vào CSDL
    protected $fillable = [
        'name', 
        'description',
        'icon_image'
    ];

    // Relationship: Category có nhiều Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relationship: Category có nhiều Promotions
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    // Lấy khuyến mãi đang hoạt động cho category này
    public function activePromotion()
    {
        return $this->hasOne(Promotion::class)
                    ->where('type', 'category')
                    ->active()
                    ->latest();
    }
}
