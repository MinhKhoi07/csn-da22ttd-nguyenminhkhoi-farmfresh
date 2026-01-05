<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - FARM FRESH</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- HEADER -->
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

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-600">
                <a href="/" class="hover:text-green-700 transition">Trang chủ</a>
                <a href="/#products" class="hover:text-green-700 transition">Sản phẩm</a>
                <a href="/#categories" class="hover:text-green-700 transition">Danh mục</a>
                <a href="{{ route('contact.show') }}" class="text-green-700 border-b-2 border-green-700">Liên hệ</a>
            </nav>

            <!-- Menu Phải -->
            <div class="flex items-center gap-4 md:gap-6 flex-shrink-0">
                <!-- Yêu thích -->
                <a href="{{ route('favorites.index') }}" class="relative group">
                    <div class="p-2.5 bg-gray-100 rounded-full group-hover:bg-pink-50 text-gray-600 group-hover:text-pink-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21l-7.682-7.682a4.5 4.5 0 010-6.364z" /></svg>
                    </div>
                </a>

                <!-- Giỏ hàng -->
                <a href="{{ route('cart.index') }}" class="relative group">
                    <div class="p-2.5 bg-gray-100 rounded-full group-hover:bg-green-50 text-gray-600 group-hover:text-green-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 container mx-auto px-4 py-12">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="/" class="hover:text-green-600">Trang chủ</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-green-600 font-semibold">Liên hệ</li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Liên Hệ Với Chúng Tôi</h1>
            <p class="text-lg text-gray-600">Chúng tôi rất vui lòng được nghe từ bạn. Gửi tin nhắn cho chúng tôi và chúng tôi sẽ phản hồi sớm nhất có thể.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Address -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 text-xl flex-shrink-0">
                            📍
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Địa chỉ</h3>
                            <p class="text-gray-600">Số 126, Nguyễn Thiện Thành, phường Hòa Thuận</p>
                            <p class="text-gray-600">tỉnh Vĩnh Long, Việt Nam</p>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xl flex-shrink-0">
                            📞
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Điện thoại</h3>
                            <p class="text-gray-600">(+84) 123 456 789</p>
                            <p class="text-gray-600">Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 text-xl flex-shrink-0">
                            ✉️
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Email</h3>
                            <p class="text-gray-600">info@farmfresh.com</p>
                            <p class="text-gray-600">support@farmfresh.com</p>
                        </div>
                    </div>
                </div>

                <!-- Hours -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 text-xl flex-shrink-0">
                            🕐
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Giờ làm việc</h3>
                            <p class="text-gray-600">Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                            <p class="text-gray-600">Thứ 7 - Chủ nhật: 9:00 - 16:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Gửi tin nhắn cho chúng tôi</h2>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium">
                            ✓ {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Họ tên *</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                placeholder="Nhập họ tên của bạn"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                                required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email *</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="Nhập email của bạn"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                                required>
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">Số điện thoại</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                placeholder="Nhập số điện thoại (tùy chọn)"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-900 mb-2">Tiêu đề *</label>
                            <input 
                                type="text" 
                                id="subject" 
                                name="subject" 
                                value="{{ old('subject') }}"
                                placeholder="Chủ đề của tin nhắn"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('subject') border-red-500 @enderror"
                                required>
                            @error('subject')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">Nội dung *</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="6"
                                placeholder="Nhập nội dung tin nhắn của bạn..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition resize-vertical @error('message') border-red-500 @enderror"
                                required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                            Gửi tin nhắn
                        </button>

                        <p class="text-sm text-gray-500 text-center">* Những trường này là bắt buộc</p>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="text-white font-bold mb-4">FARMFRESH</h4>
                    <p class="text-sm">Cung cấp nông sản sạch, tươi ngon trực tiếp từ nông trại đến tay bạn.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Sản phẩm</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/#products" class="hover:text-green-400">Sản phẩm mới</a></li>
                        <li><a href="/#categories" class="hover:text-green-400">Danh mục</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('contact.show') }}" class="hover:text-green-400">Liên hệ</a></li>
                        <li><a href="/" class="hover:text-green-400">Trang chủ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Theo dõi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-green-400">Facebook</a></li>
                        <li><a href="#" class="hover:text-green-400">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                <p class="text-center text-sm">&copy; 2025 FARM FRESH. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
