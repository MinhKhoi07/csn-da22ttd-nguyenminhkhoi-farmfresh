<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tạo Khuyến mãi mới') }}
            </h2>
            <a href="{{ route('admin.promotions.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.promotions.store') }}" method="POST">
                        @csrf

                        <!-- Tên khuyến mãi -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Tên khuyến mãi <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Loại khuyến mãi -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Loại khuyến mãi <span class="text-red-500">*</span></label>
                            <select name="type" id="type" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Chọn loại --</option>
                                <option value="category" {{ old('type') == 'category' ? 'selected' : '' }}>Theo danh mục</option>
                                <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Theo sản phẩm</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Danh mục (hiển thị khi chọn category) -->
                        <div class="mb-4" id="category_field" style="display: none;">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sản phẩm (hiển thị khi chọn product) -->
                        <div class="mb-4" id="product_field" style="display: none;">
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Sản phẩm <span class="text-red-500">*</span></label>
                            <select name="product_id" id="product_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->category->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Loại giảm giá -->
                        <div class="mb-4">
                            <label for="discount_type" class="block text-sm font-medium text-gray-700">Loại giảm giá <span class="text-red-500">*</span></label>
                            <select name="discount_type" id="discount_type" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Phần trăm (%)</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Số tiền cố định (đ)</option>
                            </select>
                            @error('discount_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Giá trị giảm -->
                        <div class="mb-4">
                            <label for="discount_value" class="block text-sm font-medium text-gray-700">Giá trị giảm <span class="text-red-500">*</span></label>
                            <input type="number" name="discount_value" id="discount_value" value="{{ old('discount_value') }}" step="0.01" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <p class="mt-1 text-xs text-gray-500" id="discount_hint">Nhập giá trị giảm giá</p>
                            @error('discount_value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Ngày bắt đầu -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt đầu <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ngày kết thúc -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết thúc <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Trạng thái -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Kích hoạt khuyến mãi</span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.promotions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Hủy
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Tạo khuyến mãi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle hiển thị trường category/product dựa vào loại khuyến mãi
        const typeSelect = document.getElementById('type');
        const categoryField = document.getElementById('category_field');
        const productField = document.getElementById('product_field');
        const discountTypeSelect = document.getElementById('discount_type');
        const discountHint = document.getElementById('discount_hint');

        function updateFields() {
            const type = typeSelect.value;
            if (type === 'category') {
                categoryField.style.display = 'block';
                productField.style.display = 'none';
                document.getElementById('category_id').required = true;
                document.getElementById('product_id').required = false;
            } else if (type === 'product') {
                categoryField.style.display = 'none';
                productField.style.display = 'block';
                document.getElementById('category_id').required = false;
                document.getElementById('product_id').required = true;
            } else {
                categoryField.style.display = 'none';
                productField.style.display = 'none';
                document.getElementById('category_id').required = false;
                document.getElementById('product_id').required = false;
            }
        }

        function updateDiscountHint() {
            const discountType = discountTypeSelect.value;
            if (discountType === 'percentage') {
                discountHint.textContent = 'Nhập phần trăm giảm giá (0-100)';
            } else {
                discountHint.textContent = 'Nhập số tiền giảm (VNĐ)';
            }
        }

        typeSelect.addEventListener('change', updateFields);
        discountTypeSelect.addEventListener('change', updateDiscountHint);

        // Chạy khi load trang để hiển thị đúng khi có old() value
        updateFields();
        updateDiscountHint();
    </script>
</x-app-layout>
