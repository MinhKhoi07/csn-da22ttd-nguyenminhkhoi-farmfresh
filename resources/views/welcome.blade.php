<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FARM FRESH - Nông Sản Sạch Tươi Ngon</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Nạp CSS và JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font chữ Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen" @if(session('clearAiChat')) data-clear-ai-chat="true" @endif>

    <!-- 1. HEADER -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between gap-4 md:gap-8">
            
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 flex-shrink-0 group">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-2xl shadow-lg group-hover:rotate-12 transition duration-300">
                    🥦
                </div>
                <div class="leading-tight hidden sm:block">
                    <span class="block text-xl font-extrabold text-gray-900 tracking-tight group-hover:text-green-600 transition">FARM<span class="text-green-600 group-hover:text-gray-900">FRESH</span></span>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Organic Food</span>
                </div>
            </a>

            <!-- Lời chào đặt bên trái, gần logo -->
            <div class="hidden sm:flex items-center">
                <div class="px-4 py-2 rounded-full bg-green-50 border border-green-100 text-sm font-semibold text-green-700 shadow-sm">
                    Chào mừng bạn đến với FARM FRESH
                </div>
            </div>

            <!-- Đệm co giãn -->
            <div class="flex-1"></div>

            <!-- Điều hướng chuyển sang bên phải -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-600">
                <a href="#products" class="hover:text-green-700 transition">Sản phẩm</a>
                <a href="#categories" class="hover:text-green-700 transition">Danh mục</a>
                <a href="{{ route('contact.show') }}" class="hover:text-green-700 transition">Liên hệ</a>
            </nav>

            <!-- Menu Phải -->
            <div class="flex items-center gap-4 md:gap-6 flex-shrink-0">
                <!-- Yêu thích -->
                <a href="{{ route('favorites.index') }}" class="relative group">
                    <div class="p-2.5 bg-gray-100 rounded-full group-hover:bg-pink-50 text-gray-600 group-hover:text-pink-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21l-7.682-7.682a4.5 4.5 0 010-6.364z" /></svg>
                    </div>
                    @php($favCountHome = isset($favoriteIds) ? count($favoriteIds) : 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-pink-500 text-white text-xs font-bold flex items-center justify-center rounded-full border-2 border-white">{{ $favCountHome }}</span>
                </a>

                <!-- Giỏ hàng -->
                <a id="cartIcon" href="{{ route('cart.index') }}" class="relative group">
                    <div class="p-2.5 bg-gray-100 rounded-full group-hover:bg-green-50 text-gray-600 group-hover:text-green-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    @php($cartCountHome = collect(session('cart', []))->sum('quantity'))
                    <span id="cartCountBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold flex items-center justify-center rounded-full border-2 border-white">{{ $cartCountHome }}</span>
                </a>

                <!-- User Account -->
                @if (Route::has('login'))
                    <div class="flex items-center">
                        @auth
                            <!-- Đã đăng nhập -->
                            <div class="flex items-center gap-3 pl-4 md:pl-6 border-l border-gray-200">
                                <div class="text-right">
                                    <span class="block text-xs text-gray-500 font-medium">Xin chào,</span>
                                    <span class="block text-sm font-bold text-gray-900">{{ Auth::user()->name }}</span>
                                </div>
                                
                                <div class="relative group cursor-pointer">
                                    <a href="{{ url('/dashboard') }}" class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold border-2 border-white shadow-sm hover:ring-2 hover:ring-green-200 transition">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </a>
                                    
                                    <!-- Dropdown menu with bridge -->
                                    <div class="absolute right-0 top-0 pt-12 hidden group-hover:block z-50">
                                        <div class="w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2">
                                            @if(Auth::user()->is_admin)
                                                <a href="{{ url('/admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium">
                                                    🛠 Trang quản trị
                                                </a>
                                            @endif
                                            <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 font-medium">
                                                ❤️ Yêu thích
                                            </a>
                                            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium">
                                                👤 Tài khoản
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                                    🚪 Đăng xuất
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Chưa đăng nhập -->
                            <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-green-700 font-bold text-sm whitespace-nowrap">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="hidden sm:block bg-gray-900 text-white px-5 py-2.5 rounded-full font-bold text-sm hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 whitespace-nowrap">
                                    Đăng ký
                                </a>
                            </div>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </header>

    <!-- 2. HERO BANNER -->
    <div class="relative h-[500px] md:h-[600px] flex items-center bg-gray-900">
        <!-- Ảnh nền -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                 class="w-full h-full object-cover opacity-80">
            <!-- Lớp phủ Gradient mạnh hơn -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl text-white">
                <span class="inline-block py-1 px-3 rounded-lg bg-green-500/20 border border-green-400 text-green-300 text-xs font-bold uppercase tracking-wider mb-6 backdrop-blur-sm">
                    🌿 100% Tự nhiên & Hữu cơ
                </span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-6 tracking-tight drop-shadow-2xl">
                    Hương Vị <br>
                    <span class="text-green-400">Thuần Khiết</span> Nhất
                </h1>
                <p class="text-base md:text-lg text-gray-300 mb-8 leading-relaxed font-light max-w-lg">
                    Kết nối trực tiếp từ nông trại đến bàn ăn. Chúng tôi cam kết mang lại những sản phẩm rau củ quả tươi ngon, an toàn tuyệt đối cho sức khỏe.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#products" class="bg-green-600 hover:bg-green-500 text-white text-base md:text-lg font-bold px-8 py-3.5 rounded-full transition shadow-lg hover:shadow-green-600/40 transform hover:-translate-y-1">
                        Mua Sắm Ngay
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DANH MỤC -->
    <div id="categories" class="py-16 bg-white border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Danh Mục Nổi Bật</h2>
                <div class="w-20 h-1.5 bg-green-500 rounded-full mt-4"></div>
            </div>
            
            <div class="flex flex-wrap justify-center gap-6">
                <!-- Nút Tất cả -->
                <a href="#" class="group min-w-[140px] p-6 rounded-2xl bg-green-50 border border-green-100 hover:border-green-500 hover:bg-green-500 hover:shadow-xl transition-all duration-300 flex flex-col items-center gap-4 cursor-pointer">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl shadow-sm group-hover:scale-110 transition duration-300">
                        🥗
                    </div>
                    <span class="font-bold text-gray-700 group-hover:text-white transition">Tất cả</span>
                </a>

                @foreach($categories as $category)
                    <a href="#" 
                       onclick="selectCategory('{{ $category->id }}'); return false;"
                       class="group min-w-[140px] p-6 rounded-2xl bg-white border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300 flex flex-col items-center gap-4 cursor-pointer"
                       data-category-id="{{ $category->id }}">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-3xl shadow-inner group-hover:scale-110 group-hover:bg-green-50 transition duration-300 overflow-hidden">
                            @if($category->icon_image)
                                <img src="{{ Storage::url($category->icon_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                            @else
                                🌾
                            @endif
                        </div>
                        <span class="font-bold text-gray-700 group-hover:text-green-600 transition">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 4. DANH SÁCH SẢN PHẨM GIẢM GIÁ -->
    @if($discountedProducts->count() > 0)
    <div class="bg-gradient-to-r from-red-50 to-orange-50 py-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                        <span class="text-3xl">🔥</span> Sản Phẩm Giảm Giá
                    </h2>
                    <p class="text-gray-500 mt-2 font-medium">Những sản phẩm đang có khuyến mãi hấp dẫn, mua ngay kẻo hết</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($discountedProducts as $product)
                    <div class="bg-white rounded-2xl border-2 border-orange-200 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full overflow-hidden product-card relative" 
                        data-name="{{ strtolower($product->name) }}" 
                        data-category-id="{{ $product->category_id }}" 
                        data-product-name="{{ $product->name }}"
                        data-product-id="{{ $product->id }}"
                        data-image="{{ $product->image ? Storage::url($product->image) : '' }}">
                        
                        <!-- Discount Badge -->
                        <?php $discountPercent = round((($product->price - $product->discounted_price) / $product->price) * 100); ?>
                        <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1.5 rounded-full font-bold text-sm shadow-lg z-20 flex items-center gap-1">
                            <span>🔥</span>
                            <span>-{{ $discountPercent }}%</span>
                        </div>

                        <!-- Product Image - Clickable Link -->
                        <a href="{{ route('products.show', $product->id) }}" class="relative h-64 overflow-hidden bg-gray-100 block group">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50">
                                    <svg class="w-16 h-16 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-semibold">Đang cập nhật</span>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Favorite Button -->
                        <button
                            class="js-fav-btn absolute top-3 right-3 bg-white/90 backdrop-blur p-2.5 rounded-full shadow-lg hover:scale-110 transition duration-300 z-10 {{ (auth()->check() && in_array($product->id, $favoriteIds ?? [])) ? 'text-red-500' : 'text-gray-400' }}"
                            data-product-id="{{ $product->id }}"
                            aria-pressed="{{ (auth()->check() && in_array($product->id, $favoriteIds ?? [])) ? 'true' : 'false' }}"
                            title="Yêu thích">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        </button>

                        <!-- Product Info -->
                        <div class="p-5 flex flex-col flex-grow">
                            <a href="{{ route('products.show', $product->id) }}" class="font-bold text-gray-900 text-base group-hover:text-green-600 transition line-clamp-2 mb-2">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-gray-500 font-medium mb-2">{{ $product->category->name }}</p>

                            <!-- Giá gốc và giá giảm -->
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-sm font-bold text-green-600">{{ number_format($product->discounted_price) }}đ/{{ $product->unit }}</span>
                                <span class="text-sm line-through text-gray-400">{{ number_format($product->price) }}đ</span>
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded">-{{ number_format($product->discount_percentage, 0) }}%</span>
                            </div>

                            <!-- Hành động: Thêm và Mua ngay -->
                            <div class="flex items-center gap-2 mt-auto">
                                <form class="flex-1" method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-green-600 text-white h-10 rounded-xl flex items-center justify-center hover:bg-green-700 transition shadow-lg shadow-green-200 active:scale-95 group/btn font-semibold" title="Thêm vào giỏ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Thêm
                                    </button>
                                </form>
                                <a href="{{ route('cart.buy_now', $product->id) }}?quantity=1" class="h-10 px-4 rounded-xl border border-green-600 text-green-700 bg-white hover:bg-green-50 font-semibold text-sm transition active:scale-95 flex items-center whitespace-nowrap" title="Mua ngay">
                                    Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- 4. DANH SÁCH SẢN PHẨM -->
    <div id="products" class="bg-gray-50 py-20 flex-grow">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Sản Phẩm Mới Về</h2>
                    <p class="text-gray-500 mt-2 font-medium">Tuyển chọn những thực phẩm tươi ngon nhất hôm nay</p>
                </div>
            </div>

            <!-- Thanh tìm kiếm và lọc sản phẩm -->
            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-16">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    🔍 Tìm Kiếm & Lọc Sản Phẩm
                </h3>
                <form id="filterForm" class="space-y-4">
                    <!-- Hàng 1: Tìm kiếm -->
                    <div class="flex w-full bg-gray-50 rounded-2xl border border-gray-200 focus-within:border-green-500 focus-within:ring-4 focus-within:ring-green-500/10 transition-all duration-300 overflow-hidden">
                        <div class="pl-4 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text"
                            id="searchInput"
                            placeholder="Nhập tên sản phẩm..."
                            class="flex-1 bg-transparent border-none py-3 px-3 text-gray-700 placeholder-gray-500 focus:ring-0 text-sm font-medium h-full outline-none">
                        <button type="button" onclick="filterProducts(event)" class="bg-green-600 text-white px-6 py-2 font-bold text-sm hover:bg-green-700 transition-colors duration-200 m-2 rounded-full shadow-sm whitespace-nowrap">
                            Tìm kiếm
                        </button>
                    </div>

                    <!-- Hàng 2: Lọc theo danh mục và sắp xếp giá -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Lọc theo danh mục -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📂 Danh mục</label>
                            <select id="categoryFilter" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition font-medium">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sắp xếp giá -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📈 Sắp xếp giá</label>
                            <div class="flex flex-wrap gap-3">
                                <button type="button" id="sortAscBtn" onclick="setSort('asc')" class="px-4 py-2.5 rounded-xl font-bold border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition">
                                    ⬆️ Thấp → Cao
                                </button>
                                <button type="button" id="sortDescBtn" onclick="setSort('desc')" class="px-4 py-2.5 rounded-xl font-bold border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition">
                                    ⬇️ Cao → Thấp
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nút lọc và reset -->
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="filterProducts(event)" class="bg-green-600 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                            🔍 Lọc sản phẩm
                        </button>
                        <button type="button" onclick="resetFilters()" class="bg-gray-200 text-gray-700 px-8 py-2.5 rounded-xl font-bold hover:bg-gray-300 transition-colors">
                            ↺ Đặt lại
                        </button>
                    </div>
                </form>
            </div>
            
            <div id="productsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full overflow-hidden product-card relative" 
                        data-name="{{ strtolower($product->name) }}" 
                        data-category-id="{{ $product->category_id }}" 
                        data-price="{{ $product->has_promotion && $product->discounted_price ? $product->discounted_price : $product->price }}"
                        data-index="{{ $loop->index }}"
                        data-product-name="{{ $product->name }}"
                        data-product-price="{{ number_format($product->has_promotion && $product->discounted_price ? $product->discounted_price : $product->price) }}"
                        data-product-unit="{{ $product->unit }}"
                        data-product-id="{{ $product->id }}"
                        data-image="{{ $product->image ? Storage::url($product->image) : '' }}">
                        
                        <!-- Product Image - Clickable Link -->
                        <a href="{{ route('products.show', $product->id) }}" class="relative h-64 overflow-hidden bg-gray-100 block group">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50">
                                    <svg class="w-16 h-16 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-semibold">Đang cập nhật</span>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Favorite Button -->
                        <button
                            class="js-fav-btn absolute top-3 right-3 bg-white/90 backdrop-blur p-2.5 rounded-full shadow-lg hover:scale-110 transition duration-300 z-10 {{ (auth()->check() && in_array($product->id, $favoriteIds ?? [])) ? 'text-red-500' : 'text-gray-400' }}"
                            data-product-id="{{ $product->id }}"
                            aria-pressed="{{ (auth()->check() && in_array($product->id, $favoriteIds ?? [])) ? 'true' : 'false' }}"
                            title="Yêu thích">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        </button>

                        <!-- Product Info -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-extrabold text-green-600 bg-green-50 px-2 py-1 rounded-md uppercase tracking-wider border border-green-100">
                                    {{ $product->category->name ?? 'Nông sản' }}
                                </span>
                                <div class="flex text-yellow-400 text-xs gap-0.5">
                                    <span>★</span><span>★</span><span>★</span><span>★</span><span class="text-gray-300">★</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('products.show', $product->id) }}" class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 hover:text-green-600 transition duration-300" title="{{ $product->name }}">
                                {{ $product->name }}
                            </a>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <div class="flex justify-between items-end mb-4">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-400 font-medium">Giá bán</span>
                                        <div class="flex items-baseline gap-2">
                                            @if($product->has_promotion)
                                                <div class="flex flex-col">
                                                    <div class="flex items-baseline gap-1">
                                                        <span class="text-xl font-extrabold text-red-600">{{ number_format($product->discounted_price) }}đ</span>
                                                        <span class="text-sm font-medium text-gray-500">/{{ $product->unit }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-sm text-gray-400 line-through">{{ number_format($product->price) }}đ</span>
                                                        <span class="text-xs font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded">-{{ number_format($product->discount_percentage, 0) }}%</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xl font-extrabold text-gray-900">{{ number_format($product->price) }}đ</span>
                                                <span class="text-sm font-medium text-gray-500">/{{ $product->unit }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2">
                                    <form class="js-add-to-cart-form flex-1" method="POST" action="{{ route('cart.add', $product->id) }}">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-green-600 text-white h-10 rounded-xl flex items-center justify-center hover:bg-green-700 transition shadow-lg shadow-green-200 active:scale-95 group/btn font-semibold" title="Thêm vào giỏ">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Thêm
                                        </button>
                                    </form>
                                    <a href="{{ route('cart.buy_now', $product->id) }}?quantity=1" class="h-10 px-4 rounded-xl border border-green-600 text-green-700 bg-white hover:bg-green-50 font-semibold text-sm transition active:scale-95 flex items-center whitespace-nowrap" title="Mua ngay">
                                        Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                        <div class="p-5 bg-gray-50 rounded-full mb-4">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có sản phẩm nào</h3>
                        <p class="text-gray-500 mb-6 font-medium">Hiện tại cửa hàng đang cập nhật sản phẩm mới.</p>
                        @auth @if(Auth::user()->is_admin)
                            <a href="{{ url('/admin/products/create') }}" class="bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition shadow-lg shadow-green-200">
                                Thêm sản phẩm ngay
                            </a>
                        @endif @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        let currentSort = null; // 'asc' | 'desc' | null

        function setSort(direction) {
            currentSort = direction;
            updateSortButtons();
            filterProducts();
        }

        function updateSortButtons() {
            const ascBtn = document.getElementById('sortAscBtn');
            const descBtn = document.getElementById('sortDescBtn');
            const active = ['bg-green-600', 'text-white', 'border-green-600', 'shadow'];
            const inactive = ['bg-white', 'text-gray-700', 'border-gray-200'];

            if (ascBtn) {
                ascBtn.classList.remove(...active, ...inactive);
                ascBtn.classList.add(...inactive);
                if (currentSort === 'asc') ascBtn.classList.add(...active);
            }
            if (descBtn) {
                descBtn.classList.remove(...active, ...inactive);
                descBtn.classList.add(...inactive);
                if (currentSort === 'desc') descBtn.classList.add(...active);
            }
        }

        function applySort(productsContainer, cards) {
            const sorted = [...cards];
            if (currentSort === 'asc') {
                sorted.sort((a, b) => (parseFloat(a.dataset.price) || 0) - (parseFloat(b.dataset.price) || 0));
            } else if (currentSort === 'desc') {
                sorted.sort((a, b) => (parseFloat(b.dataset.price) || 0) - (parseFloat(a.dataset.price) || 0));
            } else {
                sorted.sort((a, b) => (parseInt(a.dataset.index) || 0) - (parseInt(b.dataset.index) || 0));
            }
            sorted.forEach(card => productsContainer.appendChild(card));
        }

        // Lọc trực tiếp trên DOM bằng data attributes, tránh lỗi Blade khi build JSON
        function filterProducts(event) {
            if (event) event.preventDefault();

            const searchValue = (document.getElementById('searchInput').value || '').toLowerCase().trim();
            const categoryValue = document.getElementById('categoryFilter').value;

            const productsContainer = document.getElementById('productsContainer');
            const currentY = window.scrollY;
            const cards = productsContainer.querySelectorAll('.product-card');
            let visible = 0;

            cards.forEach(card => {
                const name = (card.dataset.name || '').toLowerCase();
                const cid = card.dataset.categoryId || '';

                const matchSearch = !searchValue || name.includes(searchValue);
                const matchCategory = !categoryValue || cid === categoryValue;

                const show = matchSearch && matchCategory;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            applySort(productsContainer, Array.from(cards));

            let empty = document.getElementById('noResults');
            if (visible === 0) {
                if (!empty) {
                    empty = document.createElement('div');
                    empty.id = 'noResults';
                    empty.className = 'col-span-full py-16 text-center text-gray-500';
                    empty.innerHTML = '<p class="text-lg font-semibold">Không tìm thấy sản phẩm nào phù hợp</p>';
                    productsContainer.appendChild(empty);
                }
            } else if (empty) {
                empty.remove();
            }

            window.scrollTo(0, currentY);
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            currentSort = null;
            updateSortButtons();
            filterProducts();
        }

        // Khi bấm danh mục nổi bật, set giá trị dropdown và lọc ngay
        function selectCategory(categoryId) {
            const select = document.getElementById('categoryFilter');
            if (select) {
                select.value = categoryId;
                filterProducts();
                // scroll tới khu vực lọc để người dùng thấy kết quả
                const filterBlock = document.getElementById('filterForm');
                if (filterBlock) {
                    filterBlock.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }
    </script>

    <!-- 5. FOOTER (Đã sửa icon mạng xã hội) -->
    <footer id="footer" class="bg-gray-900 text-gray-400 pt-20 pb-10 border-t-4 border-green-600">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                
                <!-- Brand -->
                <div class="space-y-6">
                    <a href="/" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-2xl">🥦</div>
                        <span class="text-2xl font-extrabold text-white tracking-wide">FARM FRESH</span>
                    </a>
                    <p class="text-sm leading-7">
                        Sứ mệnh của chúng tôi là mang đến bữa ăn an toàn, dinh dưỡng và hạnh phúc cho mọi gia đình Việt.
                    </p>
                    <div class="flex gap-4">
                        <!-- Icon Facebook -->
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <!-- Icon Instagram -->
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-pink-600 hover:text-white transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <!-- Icon Youtube -->
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-red-600 hover:text-white transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span> Về Chúng Tôi
                    </h4>
                    <ul class="space-y-3 text-sm font-medium">
                        <li><a href="#" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Câu chuyện thương hiệu</a></li>
                        <li><a href="#" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Chuỗi cửa hàng</a></li>
                        <li><a href="#" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Tuyển dụng</a></li>
                        <li><a href="{{ route('contact.show') }}" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Liên hệ & Hợp tác</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span> Hỗ Trợ
                    </h4>
                    <ul class="space-y-3 text-sm font-medium">
                        <li><a href="#" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Trung tâm trợ giúp</a></li>
                        <li><a href="#" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Chính sách vận chuyển</a></li>
                        <li><a href="#" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Chính sách đổi trả</a></li>
                        <li><a href="#" class="hover:text-green-400 hover:pl-2 transition-all duration-300">Bảo mật thông tin</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Đăng Ký Nhận Tin</h4>
                    <p class="text-sm mb-4">Nhận ngay voucher giảm giá 10% cho đơn hàng đầu tiên.</p>
                    <form class="flex flex-col gap-3">
                        <input type="email" placeholder="Email của bạn..." 
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-green-500 focus:bg-gray-700 text-white transition placeholder-gray-500">
                        <button class="bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-500 transition shadow-lg shadow-green-900/50">
                            Đăng Ký Ngay
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-gray-500">
                <p>&copy; {{ date('Y') }} Farm Fresh. All rights reserved.</p>
                <div class="flex gap-8">
                    <a href="#" class="hover:text-white transition">Điều khoản sử dụng</a>
                    <a href="#" class="hover:text-white transition">Chính sách quyền riêng tư</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Product Preview Modal -->
    <div id="productModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-500 p-6 text-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Thêm vào giỏ hàng</h3>
                    <button id="closeModal" class="p-2 hover:bg-white/20 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="flex gap-4 mb-6">
                    <div id="modalImage" class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 id="modalProductName" class="font-bold text-gray-900 text-lg mb-2 line-clamp-2"></h4>
                        <div class="flex items-baseline gap-2">
                            <span id="modalProductPrice" class="text-2xl font-extrabold text-green-600"></span>
                            <span id="modalProductUnit" class="text-sm text-gray-500"></span>
                        </div>
                    </div>
                </div>

                <!-- Quantity Control -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Số lượng</label>
                    <div class="flex items-center gap-3">
                        <button id="decreaseQty" class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center font-bold text-gray-700 transition">
                            −
                        </button>
                        <input id="modalQuantity" type="number" value="1" min="1" class="w-20 h-10 text-center border-2 border-gray-200 rounded-lg font-bold text-gray-900 focus:border-green-500 focus:outline-none">
                        <button id="increaseQty" class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center font-bold text-gray-700 transition">
                            +
                        </button>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-green-50 rounded-xl p-4 mb-6 border border-green-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Tạm tính</span>
                        <span id="modalTotal" class="text-xl font-extrabold text-green-600"></span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button id="cancelModal" class="flex-1 px-6 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition">
                        Hủy
                    </button>
                    <button id="confirmAddToCart" class="flex-1 px-6 py-3 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 transition shadow-lg shadow-green-200">
                        Thêm vào giỏ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Chat Widget -->
    <x-ai-chat-widget />

</body>
</html>