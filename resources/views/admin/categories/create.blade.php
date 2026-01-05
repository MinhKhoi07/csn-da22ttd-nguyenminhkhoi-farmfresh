<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Thêm Danh mục mới') }}
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
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- KHÁC BIỆT 1: Ở đây là FORM nhập liệu -->
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf 

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục:</label>
                            <input type="text" name="name" id="name" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Ví dụ: Rau củ">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả (tùy chọn):</label>
                            <textarea name="description" id="description" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Mô tả ngắn về danh mục này..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="icon_image" class="block text-gray-700 text-sm font-bold mb-2">Icon ảnh (PNG, JPG):</label>
                            <input type="file" name="icon_image" id="icon_image" accept="image/*"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Chọn ảnh icon">
                            <small class="text-gray-500">Kích thước khuyến nghị: 200x200px</small>
                        </div>

                        <!-- KHÁC BIỆT 2: Ở đây có nút LƯU LẠI -->
                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Lưu lại
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