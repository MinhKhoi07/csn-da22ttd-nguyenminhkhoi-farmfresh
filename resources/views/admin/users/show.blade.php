<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👤 Chi Tiết Người Dùng
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition">
                    ✏️ Chỉnh Sửa
                </a>
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">← Quay lại</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Header với avatar -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8 flex items-center gap-4">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-blue-600 shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="text-white">
                        <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                        <p class="text-blue-100">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Nội dung -->
                <div class="p-6 space-y-6">
                    <!-- Thông tin cơ bản -->
                    <div class="border-b pb-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Thông Tin Cơ Bản</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Tên</p>
                                <p class="text-lg text-gray-900 mt-1">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Email</p>
                                <p class="text-lg text-gray-900 mt-1">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">ID Người Dùng</p>
                                <p class="text-lg text-gray-900 mt-1">#{{ $user->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Quyền Hạn</p>
                                <div class="mt-1">
                                    @if ($user->is_admin)
                                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 font-semibold rounded-full text-sm">👤 Admin</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 font-semibold rounded-full text-sm">👤 Khách hàng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin hệ thống -->
                    <div class="border-b pb-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Thông Tin Hệ Thống</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Ngày Tạo</p>
                                <p class="text-lg text-gray-900 mt-1">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Cập Nhật Lần Cuối</p>
                                <p class="text-lg text-gray-900 mt-1">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Email Xác Thực</p>
                                <div class="mt-1">
                                    @if ($user->email_verified_at)
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 font-semibold rounded-full text-sm">✅ Đã xác thực</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 font-semibold rounded-full text-sm">⏳ Chưa xác thực</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition text-center">
                            ✏️ Chỉnh Sửa
                        </a>
                        @if ($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1" onsubmit="return confirm('Bạn chắc chắn muốn xóa người dùng này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                    🗑️ Xóa
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
