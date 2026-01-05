<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ Chỉnh Sửa Người Dùng
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">← Quay lại</a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Tên -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tên người dùng <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="Nhập tên người dùng"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="example@email.com"
                            required
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mật khẩu (tùy chọn) -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mật khẩu mới (để trống nếu không thay đổi)
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                            placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Xác nhận mật khẩu -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Xác nhận mật khẩu
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Nhập lại mật khẩu mới"
                        >
                    </div>

                    <!-- Quyền Admin -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_admin" 
                                id="is_admin"
                                value="1"
                                @checked($user->is_admin)
                                class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                            >
                            <span class="text-sm font-semibold text-gray-700">Cấp quyền Admin</span>
                        </label>
                        <p class="mt-1 text-xs text-gray-500">Nếu chọn, người dùng sẽ có quyền truy cập trang quản trị</p>
                    </div>

                    <!-- Thông tin hệ thống -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600">
                            <strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            <strong>Cập nhật lần cuối:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <!-- Nút hành động -->
                    <div class="flex gap-4 pt-6">
                        <button 
                            type="submit" 
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                        >
                            ✅ Cập Nhật
                        </button>
                        <a 
                            href="{{ route('admin.users.index') }}" 
                            class="flex-1 px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg text-center transition"
                        >
                            ❌ Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
