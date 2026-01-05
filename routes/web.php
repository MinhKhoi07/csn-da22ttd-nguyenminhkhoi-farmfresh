<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;    // Controller cho Dashboard
use App\Http\Controllers\Admin\AdminUserController;    // Controller quản lý người dùng
use App\Http\Controllers\Admin\CategoryController; // Controller cho Danh mục
use App\Http\Controllers\Admin\ProductController as AdminProductController;  // Admin ProductController
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\InventoryController;  // Controller quản lý kho
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;  // Product detail page controller
use App\Http\Controllers\ContactController;  // Contact page controller
use App\Http\Controllers\Api\AiChatController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact page
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Product detail page
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Order detail and review
Route::middleware('auth')->post('/orders/{order}/review/{product}', [CartController::class, 'storeReview'])->name('orders.review');

// Cart routes (Session-based)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/checkout', [CartController::class, 'checkout'])->middleware('auth')->name('cart.checkout');
Route::post('/checkout/confirm', [CartController::class, 'confirm'])->middleware('auth')->name('cart.checkout.confirm');
// Buy Now (checkout single product immediately)
Route::get('/buy-now/{product}', [CartController::class, 'buyNow'])->middleware('auth')->name('cart.buy_now');
Route::post('/buy-now/confirm', [CartController::class, 'confirmBuyNow'])->middleware('auth')->name('cart.buy_now.confirm');
Route::get('/order/success', function(){
    return view('cart.success');
})->name('cart.success');

// Favorites
Route::middleware('auth')->group(function(){
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [CartController::class, 'showOrder'])->name('orders.show');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

// --- KHU VỰC ADMIN (Chỉ dành cho Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Trang Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // 2. Quản lý Người Dùng (Users)
    Route::resource('users', AdminUserController::class);

    // 3. Quản lý Danh mục (Categories)
    Route::resource('categories', CategoryController::class);

    // 4. Quản lý Sản phẩm (Products)
    // <--- 2. Thêm dòng này để tạo toàn bộ route cho sản phẩm (index, create, store, edit, update, destroy)
    Route::resource('products', AdminProductController::class);

    // 5. Quản lý Đơn hàng (Orders)
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // 6. Thống kê
    Route::get('stats', [AdminController::class, 'stats'])->name('stats');

    // 5. Quản lý Liên hệ (Contacts)
    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contact}/update-status', [AdminContactController::class, 'updateStatus'])->name('contacts.updateStatus');
    Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('contacts/destroy-multiple', [AdminContactController::class, 'destroyMultiple'])->name('contacts.destroyMultiple');

    // 6. Quản lý Khuyến mãi (Promotions)
    Route::resource('promotions', PromotionController::class);

    // 7. Quản lý Đánh giá (Reviews)
    Route::resource('reviews', ReviewController::class)->only(['index', 'show', 'destroy']);

    // 8. Quản lý Kho (Inventory)
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('inventory/{product}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('inventory/{product}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::post('inventory/{product}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::get('inventory/report', [InventoryController::class, 'report'])->name('inventory.report');

});

// --- API ROUTES ---
Route::prefix('api')->group(function () {
    // AI Chat endpoints
    Route::get('/products/ai-feed', [AiChatController::class, 'productsFeed'])->name('api.products.feed');
    Route::post('/ai-chat', [AiChatController::class, 'chat'])
         ->middleware('throttle:20,1')
         ->name('api.ai.chat');
});

require __DIR__.'/auth.php';
