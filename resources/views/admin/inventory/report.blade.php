<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 Báo Cáo Kho
            </h2>
            <a href="{{ route('admin.inventory.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">← Quay lại</a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Tóm tắt kho -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📈 Tổng Quan Kho</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                        <p class="text-sm text-gray-600 font-semibold">Tổng Sản Phẩm</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $products->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                        <p class="text-sm text-gray-600 font-semibold">Tổng Giá Trị Kho</p>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{ number_format($totalValue) }}đ</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4">
                        <p class="text-sm text-gray-600 font-semibold">Gần Hết</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $products->where('quantity', '<', 10)->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4">
                        <p class="text-sm text-gray-600 font-semibold">Hết Hàng</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $products->where('quantity', 0)->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Bảng chi tiết kho -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">STT</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Sản Phẩm</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Danh Mục</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Số Lượng</th>
                            <th class="px-6 py-3 text-right font-semibold text-gray-700">Giá/Đơn Vị</th>
                            <th class="px-6 py-3 text-right font-semibold text-gray-700">Tổng Giá Trị</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($products as $key => $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $key + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $product->category->name }}</td>
                                <td class="px-6 py-4 text-center font-bold">
                                    {{ $product->quantity }} {{ $product->unit }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600">
                                    {{ number_format($product->price) }}đ
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-green-600">
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
                            </tr>
                        @endforeach
                        <!-- Tổng cộng -->
                        <tr class="bg-gray-100 border-t-2 border-gray-300 font-bold">
                            <td colspan="3" class="px-6 py-4 text-right">TỔNG CỘNG</td>
                            <td class="px-6 py-4 text-center">{{ $products->sum('quantity') }}</td>
                            <td colspan="1" class="px-6 py-4 text-right"></td>
                            <td class="px-6 py-4 text-right text-green-700">
                                {{ number_format($totalValue) }}đ
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Ghi chú in -->
            <div class="mt-8 text-center text-xs text-gray-600">
                <p>Báo cáo được tạo lúc: {{ now()->format('d/m/Y H:i:s') }}</p>
                <p>FARM FRESH - Hệ thống quản lý nông sản sạch</p>
            </div>
        </div>
    </div>

    <!-- In trang -->
    <script>
        window.addEventListener('load', function() {
            if (window.location.hash === '#print') {
                window.print();
            }
        });
    </script>
</x-app-layout>
