<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 Trang Quản Trị Hệ Thống
            </h2>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ now()->format('d/m/Y H:i') }}</span>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 text-sm font-medium text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại trang chủ
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Lời chào -->
            <div class="mb-8">
                <h3 class="text-3xl font-bold text-gray-900">Chào mừng, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-600 mt-1">Đây là bảng điều khiển quản lý toàn hệ thống FARM FRESH</p>
            </div>

            <!-- THỐNG KÊ TỔNG QUÁT (4 ô chính) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Sản phẩm -->
                <div class="bg-white rounded-2xl shadow-md border-l-4 border-blue-500 p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-gray-600 text-sm font-medium">Tổng Sản Phẩm</span>
                            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalProducts }}</p>
                            <p class="text-gray-500 text-xs mt-2">Đang quản lý</p>
                        </div>
                        <div class="text-4xl">📦</div>
                    </div>
                </div>

                <!-- Đơn hàng -->
                <div class="bg-white rounded-2xl shadow-md border-l-4 border-green-500 p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-gray-600 text-sm font-medium">Tổng Đơn Hàng</span>
                            <p class="text-4xl font-bold text-green-600 mt-2">{{ $totalOrders }}</p>
                            <p class="text-gray-500 text-xs mt-2">Tất cả thời gian</p>
                        </div>
                        <div class="text-4xl">🛒</div>
                    </div>
                </div>

                <!-- Khách hàng -->
                <div class="bg-white rounded-2xl shadow-md border-l-4 border-orange-500 p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-gray-600 text-sm font-medium">Tổng Khách Hàng</span>
                            <p class="text-4xl font-bold text-orange-600 mt-2">{{ $totalCustomers }}</p>
                            <p class="text-gray-500 text-xs mt-2">Người dùng</p>
                        </div>
                        <div class="text-4xl">👥</div>
                    </div>
                </div>

                <!-- Doanh thu -->
                <div class="bg-white rounded-2xl shadow-md border-l-4 border-red-500 p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-gray-600 text-sm font-medium">Tổng Doanh Thu</span>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ number_format($totalRevenue) }}đ</p>
                            <p class="text-gray-500 text-xs mt-2">Từ bán hàng</p>
                        </div>
                        <div class="text-4xl">💰</div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col lg:flex-row gap-8">
                <!-- Thanh quản lý nhanh dạng cột bên trái -->
                <div class="bg-white rounded-2xl shadow-md p-6 h-fit w-full lg:w-72 flex-shrink-0">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">⚙️ Quản Lý Nhanh</h4>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('admin.stats') }}" class="flex items-center justify-between p-4 bg-sky-50 rounded-lg hover:bg-sky-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📈</span>
                                <span class="text-sm font-semibold text-sky-700">Thống Kê</span>
                            </div>
                            <span class="text-sky-600">→</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">👥</span>
                                <span class="text-sm font-semibold text-indigo-700">Quản Lý Người Dùng</span>
                            </div>
                            <span class="text-indigo-600">→</span>
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">➕</span>
                                <span class="text-sm font-semibold text-blue-700">Thêm Sản Phẩm</span>
                            </div>
                            <span class="text-blue-500">→</span>
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📂</span>
                                <span class="text-sm font-semibold text-green-700">Thêm Danh Mục</span>
                            </div>
                            <span class="text-green-600">→</span>
                        </a>
                        <a href="{{ route('admin.inventory.index') }}" class="flex items-center justify-between p-4 bg-cyan-50 rounded-lg hover:bg-cyan-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📦</span>
                                <span class="text-sm font-semibold text-cyan-700">Quản Lý Kho</span>
                            </div>
                            <span class="text-cyan-600">→</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📦</span>
                                <span class="text-sm font-semibold text-orange-700">Quản Lý Sản Phẩm</span>
                            </div>
                            <span class="text-orange-600">→</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🏷️</span>
                                <span class="text-sm font-semibold text-purple-700">Quản Lý Danh Mục</span>
                            </div>
                            <span class="text-purple-600">→</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📋</span>
                                <span class="text-sm font-semibold text-yellow-700">Quản Lý Đơn Hàng</span>
                            </div>
                            <span class="text-yellow-600">→</span>
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" class="flex items-center justify-between p-4 bg-pink-50 rounded-lg hover:bg-pink-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📧</span>
                                <span class="text-sm font-semibold text-pink-700">Quản Lý Liên Hệ</span>
                            </div>
                            <span class="text-pink-600">→</span>
                        </a>
                        <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">⭐</span>
                                <span class="text-sm font-semibold text-indigo-700">Quản Lý Đánh Giá</span>
                            </div>
                            <span class="text-indigo-600">→</span>
                        </a>
                        <a href="{{ route('admin.promotions.index') }}" class="flex items-center justify-between p-4 bg-red-50 rounded-lg hover:bg-red-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🎁</span>
                                <span class="text-sm font-semibold text-red-700">Quản Lý Khuyến Mãi</span>
                            </div>
                            <span class="text-red-600">→</span>
                        </a>
                    </div>
                </div>

                <div class="flex-1 grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Sản phẩm bán chạy nhất -->
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-xl font-bold text-gray-900">⭐ Sản Phẩm Bán Chạy Nhất</h4>
                            <a href="{{ route('admin.products.index') }}" class="text-green-600 text-sm font-semibold hover:text-green-700">Xem tất cả →</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($bestSellingProducts as $product)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900">{{ $product->name }}</h5>
                                        <p class="text-xs text-gray-500">{{ $product->category->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-green-600">{{ $product->order_details_count }} đơn</p>
                                        <p class="text-xs text-gray-500">{{ number_format($product->price) }}đ</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-6">Chưa có sản phẩm</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Đơn hàng gần đây -->
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-xl font-bold text-gray-900">📋 Đơn Hàng Gần Đây</h4>
                            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 text-sm font-semibold hover:text-blue-700">Xem tất cả →</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recentOrders as $order)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900">#{{ $order->id }}</h5>
                                        <p class="text-xs text-gray-500">{{ $order->user->name ?? 'Khách' }} - {{ $order->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-blue-600">{{ number_format($order->total_price ?? 0) }}đ</p>
                                        <p class="text-xs text-gray-500">{{ $order->status ?? 'Đang xử lý' }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-6">Chưa có đơn hàng</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>