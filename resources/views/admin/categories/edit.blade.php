<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chỉnh sửa Danh mục') }}
            </h2>
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Form sửa gửi đến route UPDATE -->
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT') <!-- Quan trọng: Giả lập phương thức PUT để update -->

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục:</label>
                            <!-- value="{{ $category->name }}" để hiện tên cũ -->
                            <input type="text" name="name" id="name" value="{{ $category->name }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả (tùy chọn):</label>
                            <!-- Nội dung cũ của textarea nằm giữa cặp thẻ -->
                            <textarea name="description" id="description" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $category->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="icon_image" class="block text-gray-700 text-sm font-bold mb-2">Icon ảnh (PNG, JPG):</label>
                            @if($category->icon_image)
                                <div class="mb-3">
                                    <p class="text-gray-600 text-sm mb-2">Ảnh hiện tại:</p>
                                    <img src="{{ Storage::url($category->icon_image) }}" alt="{{ $category->name }}" class="w-20 h-20 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" name="icon_image" id="icon_image" accept="image/*"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <small class="text-gray-500">Để trống nếu không muốn đổi ảnh. Kích thước khuyến nghị: 200x200px</small>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cập nhật
                            </button>

                            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900">
                                Quay lại
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>