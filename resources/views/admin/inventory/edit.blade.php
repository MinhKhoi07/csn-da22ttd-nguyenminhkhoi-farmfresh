<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ Chỉnh Sửa Kho - {{ $product->name }}
            </h2>
            <a href="{{ route('admin.inventory.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">← Quay lại</a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thông tin sản phẩm -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📦 Thông Tin Sản Phẩm</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Tên Sản Phẩm</p>
                            <p class="text-lg text-gray-900 mt-1">{{ $product->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Danh Mục</p>
                            <p class="text-lg text-gray-900 mt-1">{{ $product->category->name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Giá</p>
                                <p class="text-lg text-gray-900 mt-1">{{ number_format($product->price) }}đ</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Đơn Vị</p>
                                <p class="text-lg text-gray-900 mt-1">{{ $product->unit }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-4 mt-4">
                            <p class="text-sm text-gray-600 font-semibold">Số Lượng Hiện Tại</p>
                            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $product->quantity }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $product->unit }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form cập nhật kho -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📝 Cập Nhật Số Lượng</h3>
                    
                    <form action="{{ route('admin.inventory.update', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Số lượng mới -->
                        <div>
                            <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                Số Lượng Mới <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="quantity" 
                                id="quantity"
                                value="{{ old('quantity', $product->quantity) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('quantity') border-red-500 @enderror text-lg font-bold"
                                placeholder="Nhập số lượng"
                                min="0"
                                required
                            >
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lý do thay đổi -->
                        <div>
                            <label for="reason" class="block text-sm font-semibold text-gray-700 mb-2">
                                Lý Do (Ghi Chú)
                            </label>
                            <textarea 
                                name="reason" 
                                id="reason"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reason') border-red-500 @enderror"
                                placeholder="VD: Nhập hàng từ nhà cung cấp, bán hết..."
                            >{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nút hành động -->
                        <div class="flex gap-3 pt-4">
                            <button 
                                type="submit" 
                                class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                            >
                                ✅ Cập Nhật
                            </button>
                            <a 
                                href="{{ route('admin.inventory.index') }}" 
                                class="flex-1 px-4 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg text-center transition"
                            >
                                ❌ Hủy
                            </a>
                        </div>
                    </form>

                    <!-- Tính toán -->
                    <div class="bg-gray-50 rounded-lg p-4 mt-6">
                        <p class="text-xs text-gray-600 font-semibold mb-2">💡 Ghi Chú</p>
                        <ul class="text-xs text-gray-600 space-y-1">
                            <li>• Số lượng mới sẽ thay thế hoàn toàn số lượng hiện tại</li>
                            <li>• Nhập 0 để đánh dấu sản phẩm hết hàng</li>
                            <li>• Lý do thay đổi sẽ được ghi lại trong hệ thống</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
