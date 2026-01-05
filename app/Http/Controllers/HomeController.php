<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;  // Gọi Model Sản phẩm
use App\Models\Category; // Gọi Model Danh mục
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy toàn bộ sản phẩm (mới nhất trước)
        $products = Product::with('category')->latest()->get();

        // 2. Lấy sản phẩm đang giảm giá (nhiều nhất 8 sản phẩm)
        //    Dựa trên khuyến mãi đang hoạt động (theo sản phẩm hoặc theo danh mục)
        $discountedProducts = Product::with(['category', 'promotions', 'category.promotions'])
            ->where(function ($query) {
                // Có khuyến mãi gán trực tiếp cho sản phẩm
                $query->whereHas('promotions', function ($q) {
                    $q->active();
                })
                // Hoặc có khuyến mãi áp dụng cho danh mục của sản phẩm
                ->orWhereHas('category.promotions', function ($q) {
                    $q->active();
                });
            })
            ->latest()
            ->limit(8)
            ->get();

        // 3. Lấy tất cả danh mục (để làm menu lọc sau này)
        $categories = Category::all();

        // 4. Lấy danh sách sản phẩm yêu thích của user (nếu đã đăng nhập)
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }

        // 5. Trả về view 'welcome' và gửi kèm dữ liệu
        return view('welcome', compact('products', 'discountedProducts', 'categories', 'favoriteIds'));
    }
}