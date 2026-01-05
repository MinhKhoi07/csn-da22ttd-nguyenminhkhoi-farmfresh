<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chỉnh sửa Sản phẩm') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT') <!-- Giả lập PUT -->

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Cột 1 -->
                            <div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Tên sản phẩm:</label>
                                    <input type="text" name="name" value="{{ $product->name }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Danh mục:</label>
                                    <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Giá (VNĐ):</label>
                                    <input type="number" name="price" value="{{ $product->price }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Đơn vị tính:</label>
                                    <input type="text" name="unit" value="{{ $product->unit }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>

                            <!-- Cột 2 -->
                            <div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Hình ảnh hiện tại:</label>
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" class="w-32 h-32 object-cover rounded mb-2">
                                    @else
                                        <p class="text-gray-500">Chưa có ảnh</p>
                                    @endif
                                    
                                    <label class="block text-gray-700 text-sm font-bold mb-2 mt-2">Thay ảnh mới (nếu muốn):</label>
                                    <input type="file" name="image" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nguồn gốc:</label>
                                    <input type="text" name="origin" value="{{ $product->origin }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Mô tả:</label>
                                    <textarea name="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cập nhật sản phẩm
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="ml-4 text-gray-600 hover:text-gray-900">Quay lại</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>