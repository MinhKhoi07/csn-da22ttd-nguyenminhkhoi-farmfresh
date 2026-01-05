<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Quản Lý Kho
            </h2>
            <a href="{{ route('admin.inventory.report') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Báo Cáo Kho
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Thống kê nhanh -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <p class="text-gray-600 text-sm font-semibold">Tổng Giá Trị Kho</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($totalInventoryValue) }}đ</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <p class="text-gray-600 text-sm font-semibold">Sản Phẩm Gần Hết</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $lowStockCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">(Dưới 10 cái)</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                    <p class="text-gray-600 text-sm font-semibold">Hết Hàng</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $outOfStockCount }}</p>
                </div>
            </div>

            <!-- Thông báo -->
            @if ($message = session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ $message }}
                </div>
            @endif

            <!-- Bảng danh sách kho -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Sản Phẩm</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Danh Mục</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Số Lượng</th>
                            <th class="px-6 py-3 text-right font-semibold text-gray-700">Giá/Đơn Vị</th>
                            <th class="px-6 py-3 text-right font-semibold text-gray-700">Tổng Giá Trị</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Trạng Thái</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $product->category->name }}</td>
                                <td class="px-6 py-4 text-center font-bold text-gray-900">
                                    {{ $product->quantity }} {{ $product->unit }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600">
                                    {{ number_format($product->price) }}đ
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-blue-600">
                                    {{ number_format($product->quantity * $product->price) }}đ
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($product->quantity == 0)
                                        <span class="inline-block px-3 py-1 bg-red-100 text-red-700 font-semibold rounded-full text-xs">🔴 Hết</span>
                                    @elseif ($product->quantity < 10)
                                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 font-semibold rounded-full text-xs">⚠️ Gần hết</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 font-semibold rounded-full text-xs">✅ Có hàng</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.inventory.edit', $product) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                        ✏️ Chỉnh sửa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Không có sản phẩm nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
