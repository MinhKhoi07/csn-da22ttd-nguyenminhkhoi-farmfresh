<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $quantity
 * @property float $price
 */
class Product extends Model
{
    // Cho phép lưu các trường này
    protected $fillable = [
        'category_id', // ID danh mục
        'name',        // Tên sản phẩm
        'description', // Mô tả
        'price',       // Giá
        'unit',        // Đơn vị (kg, bó...)
        'origin',      // Nguồn gốc
        'image',       // Đường dẫn ảnh (quan trọng)
        'quantity',    // Số lượng trong kho
    ];

    // Khai báo mối quan hệ: "Sản phẩm này thuộc về 1 Danh mục"
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Khai báo mối quan hệ: "Sản phẩm này có nhiều Order Details"
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Khai báo mối quan hệ: "Sản phẩm này có nhiều Reviews"
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Tính đánh giá trung bình
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Đếm số reviews
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    // Relationship: Product có nhiều Promotions
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    // Lấy khuyến mãi đang hoạt động cho product này (ưu tiên product > category)
    public function getActivePromotionAttribute()
    {
        // Ưu tiên khuyến mãi theo sản phẩm
        $productPromotion = $this->promotions()
                                ->where('type', 'product')
                                ->active()
                                ->latest()
                                ->first();
        
        if ($productPromotion) {
            return $productPromotion;
        }

        // Nếu không có, lấy khuyến mãi theo danh mục
        if ($this->category) {
            return $this->category->promotions()
                        ->where('type', 'category')
                        ->active()
                        ->latest()
                        ->first();
        }

        return null;
    }

    // Lấy giá sau khi áp dụng khuyến mãi
    public function getDiscountedPriceAttribute()
    {
        $promotion = $this->active_promotion;
        
        if ($promotion) {
            return $promotion->calculateDiscountedPrice($this->price);
        }

        return $this->price;
    }

    // Kiểm tra có khuyến mãi không
    public function getHasPromotionAttribute()
    {
        return $this->active_promotion !== null;
    }

    // Lấy phần trăm giảm giá (nếu có)
    public function getDiscountPercentageAttribute()
    {
        $promotion = $this->active_promotion;
        
        if (!$promotion) {
            return 0;
        }

        if ($promotion->discount_type === 'percentage') {
            return $promotion->discount_value;
        }

        // Tính % từ giá trị cố định
        return round(($promotion->discount_value / $this->price) * 100, 0);
    }
}

#### Bước 2: Tạo Controller Sản phẩm

/*Mở **Terminal** và chạy lệnh tạo Controller (có sẵn các hàm resource):

```bash
php artisan make:controller Admin/ProductController --resource
*/

#### Bước 3: Khai báo Đường dẫn (Route)

/*Mở file **`routes/web.php`**.
Chúng ta cần thêm route cho Product, giống hệt như đã làm với Category.

1.  Thêm dòng `use` ở đầu file:
    ```php
    use App\Http\Controllers\Admin\ProductController;
    ```
2.  Thêm dòng `Route::resource` vào trong nhóm admin (ngay dưới dòng categories):
    ```php
    Route::resource('products', ProductController::class);
    */